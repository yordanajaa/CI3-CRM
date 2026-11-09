/**
 * Pure JavaScript Code 128 Barcode Decoder
 * Converted from application/helpers/barcode128_decoder.py
 * 
 * Works 100% in-browser without external libraries, npm packages, or server dependencies.
 * Capable of decoding 1D Code 128 barcodes (Shopee SPX, J&T, SiCepat, JNE, dll)
 * directly from an HTML5 Canvas, ImageData, or Image element.
 */
var Barcode128Decoder = (function() {
    'use strict';

    // Code 128 pattern definitions (107 patterns)
    var CODE128_PATTERNS = [
        "212222", "222122", "222221", "121223", "121322", "131222", "122213", "122312", "132212", "221213",
        "221312", "231212", "112232", "122132", "122231", "113222", "123122", "123221", "223211", "221132",
        "221231", "213212", "223112", "312131", "311222", "321122", "321221", "312212", "322112", "322211",
        "212123", "212321", "232121", "111323", "131123", "131321", "112313", "132113", "132311", "211313",
        "231113", "231311", "112133", "112331", "132131", "113123", "113321", "133121", "313121", "211331",
        "231131", "213113", "213311", "213131", "311123", "311321", "331121", "312113", "312311", "332111",
        "314111", "221411", "431111", "111224", "111422", "121124", "121421", "141122", "141221", "112214",
        "112412", "122114", "122411", "142112", "142211", "241211", "221114", "413111", "241112", "134111",
        "111242", "121142", "121241", "114212", "124112", "124211", "411212", "421112", "421211", "212141",
        "214121", "412121", "111143", "111341", "131141", "114113", "114311", "411113", "411311", "113141",
        "114131", "311141", "411131", "211412", "211214", "211232", "2331112"
    ];

    var PATTERN_TO_VAL = {};
    for (var i = 0; i < CODE128_PATTERNS.length; i++) {
        PATTERN_TO_VAL[CODE128_PATTERNS[i]] = i;
    }

    function decodeSymbolsToText(syms, startVal) {
        var mode = (startVal === 104) ? 'B' : ((startVal === 105) ? 'C' : 'A');
        var out = [];
        var idx = 0;
        while (idx < syms.length) {
            var s = syms[idx];
            if (s === 101) { mode = 'A'; idx++; continue; }
            else if (s === 100) { mode = 'B'; idx++; continue; }
            else if (s === 99) { mode = 'C'; idx++; continue; }

            if (mode === 'C') {
                out.push(s < 10 ? '0' + s : '' + s);
            } else if (mode === 'B') {
                if (s >= 0 && s <= 95) {
                    out.push(String.fromCharCode(32 + s));
                }
            } else if (mode === 'A') {
                if (s >= 0 && s <= 63) {
                    out.push(String.fromCharCode(32 + s));
                } else if (s >= 64 && s <= 95) {
                    out.push(String.fromCharCode(s - 64));
                }
            }
            idx++;
        }
        return out.join('');
    }

    function decodeImageData(imgData) {
        if (!imgData || !imgData.width || !imgData.height || !imgData.data) {
            return [];
        }

        var w = imgData.width;
        var h = imgData.height;
        var d = imgData.data;
        var found = [];

        // Sample scanlines between 5% and 92% of image height, step by 3px
        var startY = Math.max(0, Math.floor(h * 0.05));
        var endY = Math.min(h, Math.floor(h * 0.92));

        for (var y = startY; y < endY; y += 3) {
            var rowOffset = y * w * 4;
            var runs = [];
            var currVal = -1;
            var runLen = 0;

            for (var x = 0; x < w; x++) {
                var pIdx = rowOffset + (x * 4);
                var r = d[pIdx];
                var g = d[pIdx + 1];
                var b = d[pIdx + 2];
                // Grayscale luminance threshold (black bar = 1, white space = 0)
                var isBlack = (0.299 * r + 0.587 * g + 0.114 * b < 128) ? 1 : 0;

                if (currVal === -1) {
                    currVal = isBlack;
                    runLen = 1;
                } else if (isBlack === currVal) {
                    runLen++;
                } else {
                    runs.push({ val: currVal, len: runLen });
                    currVal = isBlack;
                    runLen = 1;
                }
            }
            if (runLen > 0) {
                runs.push({ val: currVal, len: runLen });
            }

            var totalRuns = runs.length;
            if (totalRuns < 16) continue;

            for (var rIdx = 0; rIdx < totalRuns - 15; rIdx++) {
                if (runs[rIdx].val !== 1) continue; // Must start on black bar

                var sixTot = runs[rIdx].len + runs[rIdx + 1].len + runs[rIdx + 2].len +
                               runs[rIdx + 3].len + runs[rIdx + 4].len + runs[rIdx + 5].len;
                if (sixTot < 8) continue;

                var u = sixTot / 11.0;
                var pat = "";
                for (var k = 0; k < 6; k++) {
                    pat += Math.round(runs[rIdx + k].len / u);
                }

                // Check for Code 128 Start Patterns: Start A (211412), Start B (211214), Start C (211232)
                if (pat === "211412" || pat === "211214" || pat === "211232") {
                    var startCode = PATTERN_TO_VAL[pat];
                    var symbols = [startCode];
                    var pos = rIdx + 6;
                    var valid = false;

                    while (pos + 6 <= totalRuns) {
                        // Check for stop pattern (7 bars: 2331112)
                        if (pos + 7 <= totalRuns) {
                            var sevTot = runs[pos].len + runs[pos + 1].len + runs[pos + 2].len +
                                           runs[pos + 3].len + runs[pos + 4].len + runs[pos + 5].len + runs[pos + 6].len;
                            var sevU = sevTot / 13.0;
                            var sevPat = "";
                            for (var sk = 0; sk < 7; sk++) {
                                sevPat += Math.round(runs[pos + sk].len / sevU);
                            }
                            if (sevPat === "2331112") {
                                valid = true;
                                break;
                            }
                        }

                        var sTot = runs[pos].len + runs[pos + 1].len + runs[pos + 2].len +
                                     runs[pos + 3].len + runs[pos + 4].len + runs[pos + 5].len;
                        var sU = sTot / 11.0;
                        var sPat = "";
                        for (var pk = 0; pk < 6; pk++) {
                            sPat += Math.round(runs[pos + pk].len / sU);
                        }

                        if (typeof PATTERN_TO_VAL[sPat] !== 'undefined') {
                            symbols.push(PATTERN_TO_VAL[sPat]);
                            pos += 6;
                        } else {
                            break;
                        }
                    }

                    if (valid && symbols.length >= 3) {
                        var dataSyms = symbols.slice(0, symbols.length - 1);
                        var checkSym = symbols[symbols.length - 1];
                        var checksum = dataSyms[0];
                        for (var wIdx = 1; wIdx < dataSyms.length; wIdx++) {
                            checksum += dataSyms[wIdx] * wIdx;
                        }

                        if ((checksum % 103) === checkSym) {
                            var chars = decodeSymbolsToText(dataSyms.slice(1), dataSyms[0]);
                            if (chars && chars.length >= 4 && found.indexOf(chars) === -1) {
                                found.push(chars);
                            }
                        }
                    }
                }
            }
        }

        return found;
    }

    function decodeCanvas(canvas) {
        if (!canvas || !canvas.width || !canvas.height) return [];
        try {
            var ctx = canvas.getContext('2d');
            var imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            return decodeImageData(imgData);
        } catch(e) {
            console.warn('Barcode128Decoder error:', e);
            return [];
        }
    }

    function detectCOD(canvas) {
        if (!canvas || !canvas.width || !canvas.height) return { is_cod: false, cod_nominal: 0 };
        try {
            var ctx = canvas.getContext('2d');
            var w = canvas.width;
            var h = canvas.height;
            var imgData = ctx.getImageData(0, 0, w, h);
            var d = imgData.data;

            // 1. Thermal label: TikTok Shop / J&T metadata box row (scale-independent)
            var startY = (h < 300) ? Math.floor(h * 0.05) : Math.floor(h * 0.10);
            var endY = (h < 300) ? Math.floor(h * 0.95) : Math.floor(h * 0.70);
            var checkW = Math.floor(w * 0.48);

            var hLines = [];
            for (var y = startY; y < endY; y++) {
                var darkCnt = 0;
                var rowOff = y * w * 4;
                for (var x = 0; x < checkW; x++) {
                    var p = rowOff + (x * 4);
                    // Ignore transparent pixels (if alpha < 128, treat as white)
                    if (d[p+3] >= 128 && (0.299 * d[p] + 0.587 * d[p+1] + 0.114 * d[p+2] < 120)) {
                        darkCnt++;
                    }
                }
                if (darkCnt > checkW * 0.55) {
                    hLines.push(y);
                }
            }

            var minGap = Math.max(3, Math.floor(h * 0.008));
            var distinct = [];
            for (var i = 0; i < hLines.length; i++) {
                if (distinct.length === 0 || hLines[i] - distinct[distinct.length - 1] > minGap) {
                    distinct.push(hLines[i]);
                }
            }

            for (var j = 0; j < distinct.length - 1; j++) {
                var yTop = distinct[j];
                var yBot = distinct[j + 1];
                var rowH = yBot - yTop;
                var relH = rowH / h;
                var maxRelH = (h < 300) ? 0.75 : 0.090;
                if (relH >= 0.012 && relH <= maxRelH) {
                    var minDivX = Math.floor(w * 0.20);
                    var maxDivX = (h < 300) ? Math.floor(w * 0.95) : Math.floor(w * 0.48);
                    var vDiv = (h < 300) ? Math.floor(w * 0.90) : Math.floor(w * 0.35);

                    for (var vx = minDivX; vx <= maxDivX; vx++) {
                        var colDark = 0;
                        for (var vy = yTop; vy <= yBot; vy++) {
                            var vp = (vy * w + vx) * 4;
                            if (d[vp+3] >= 128 && (0.299 * d[vp] + 0.587 * d[vp+1] + 0.114 * d[vp+2] < 120)) colDark++;
                        }
                        if (colDark >= rowH * 0.60) {
                            vDiv = vx;
                            break;
                        }
                    }

                    var textDark = 0;
                    var insetX = Math.max(2, Math.floor(w * 0.02));
                    var insetY = Math.max(1, Math.floor(rowH * 0.15));
                    for (var by = yTop + insetY; by <= yBot - insetY; by++) {
                        var bOff = by * w * 4;
                        for (var bx = insetX; bx < vDiv - 2; bx++) {
                            var bp = bOff + (bx * 4);
                            if (d[bp+3] >= 128 && (0.299 * d[bp] + 0.587 * d[bp+1] + 0.114 * d[bp+2] < 130)) textDark++;
                        }
                    }

                    var minTextDark = Math.max(10, Math.floor(w * 0.015));
                    if (textDark >= minTextDark) {
                        console.log('[Barcode128Decoder] COD Box detected successfully:', { yTop: yTop, yBot: yBot, vDiv: vDiv, rowH: rowH, textDark: textDark });
                        return {
                            is_cod: true,
                            cod_nominal: 0,
                            box: {
                                x: 0,
                                y: yTop,
                                width: vDiv,
                                height: rowH
                            }
                        };
                    }
                }
            }
        } catch(e) {
            console.warn('detectCOD error:', e);
        }
        return { is_cod: false, cod_nominal: 0 };
    }

    return {
        decodeCanvas: decodeCanvas,
        detectCOD: detectCOD,
        decodeImageData: decodeImageData,
        decodeSymbolsToText: decodeSymbolsToText
    };
})();

// Export for Node.js / CommonJS environment if applicable
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Barcode128Decoder;
}
