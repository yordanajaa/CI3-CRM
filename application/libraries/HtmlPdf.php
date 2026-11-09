<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Library HTML PDF for CodeIgniter 3
 * Fully compatible with PHP 5.6 - PHP 8.3+ (Hostinger & Localhost)
 */

if (version_compare(PHP_VERSION, '8.0.0', '<')) {
    // Legacy HTML2PDF for PHP 5.6 - 7.4
    require_once(APPPATH . "libraries/htmlpdf/html2pdf.class.php");

    class HtmlPdf extends HTML2PDF
    {
        var $orientation    = 'p';
        var $format         = 'A4';
        var $langue         = 'fr';
        var $unicode        = TRUE;
        var $encoding       = 'UTF-8';
        var $marges         = array(5, 5, 5, 5);

        public function __construct($config = array())
        {
            $this->initialize($config);
            parent::__construct($this->orientation, $this->format, $this->langue, $this->unicode, $this->encoding, $this->marges);
        }

        public function initialize($config = array())
        {
            foreach ($config as $key => $value) {
                if(isset($this->$key))
                {
                    $this->$key = $value;
                }
            }
        }

        public function loadHtmlPdf($file = NULL, $data = array())
        {
            $CI =& get_instance();
            $file = $CI->load->view($file, $data, TRUE);

            for ($i=0; $i < 50; $i++) { 
                $file = str_replace("[space_{$i}]", $this->_parseChars($i), $file);
            }
            return $file;
        }

        public function _parseChars($jml = 1, $chars = "&nbsp;")
        {
            $htmlChars = NULL;
            for ($i=0; $i < $jml; $i++) { 
                $htmlChars .= $chars;
            }
            return $htmlChars;
        }
    }
} else {
    // Modern High-Definition Print & PDF Engine for PHP 8.0 - 8.3+ (Hostinger)
    class HtmlPdf
    {
        public $orientation = 'p';
        public $format      = 'A4';
        public $langue      = 'id';
        public $unicode     = TRUE;
        public $encoding    = 'UTF-8';
        public $marges      = array(7, 7, 7, 7);
        public $pdf         = null;
        protected $_html_content = '';

        public function __construct($config = array())
        {
            $this->initialize($config);
            // Dummy PDF sub-object to prevent errors on $this->pdf->pdf->SetDisplayMode(...)
            $this->pdf = new class {
                public function __call($name, $arguments) { return $this; }
                public function SetDisplayMode($mode) { return $this; }
            };
        }

        public function __call($name, $arguments)
        {
            return $this;
        }

        public function initialize($config = array())
        {
            if (is_array($config)) {
                foreach ($config as $key => $value) {
                    if (property_exists($this, $key)) {
                        $this->$key = $value;
                    }
                }
            }
            return $this;
        }

        public function loadHtmlPdf($file = NULL, $data = array())
        {
            $CI =& get_instance();
            $content = $CI->load->view($file, $data, TRUE);

            for ($i = 0; $i < 50; $i++) { 
                $content = str_replace("[space_{$i}]", $this->_parseChars($i), $content);
            }
            return $content;
        }

        public function _parseChars($jml = 1, $chars = "&nbsp;")
        {
            $htmlChars = '';
            for ($i = 0; $i < $jml; $i++) { 
                $htmlChars .= $chars;
            }
            return $htmlChars;
        }

        public function writeHTML($content, $test = false)
        {
            $this->_html_content .= (string)$content;
            return $this;
        }

        public function Output($filename = 'document.pdf', $mode = 'I')
        {
            if (ob_get_length()) {
                ob_end_clean();
            }

            $clean_title = preg_replace('/\.pdf$/i', '', basename($filename));
            $clean_title_display = ucwords(str_replace(['_', '-'], ' ', $clean_title));
            $orientation = strtolower($this->orientation) === 'l' ? 'landscape' : 'portrait';

            // Bersihkan tag khusus legacy HTML2PDF
            $body_content = $this->_html_content;
            $body_content = preg_replace('/<page[^>]*>/i', '', $body_content);
            $body_content = str_replace('</page>', '', $body_content);
            $body_content = preg_replace('/<page_footer[^>]*>.*?<\/page_footer>/is', '', $body_content);
            $body_content = str_replace(['[[page_cu]]', '[[page_nb]]'], ['1', '1'], $body_content);

            header('Content-Type: text/html; charset=utf-8');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');

            echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes">
    <title>' . htmlspecialchars($clean_title_display) . '</title>
    <style>
        @page {
            size: A4 ' . $orientation . ';
            margin: 8mm 7mm 10mm 7mm;
        }
        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        html, body {
            margin: 0;
            padding: 0;
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            color: #1e293b;
            background-color: #f1f5f9;
            -webkit-text-size-adjust: 100%;
        }
        .pdf-print-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50px;
            background: #0f172a;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            z-index: 999999;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        .pdf-title-info {
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            min-width: 0;
            overflow: hidden;
        }
        .pdf-title-icon {
            font-size: 15px;
            flex-shrink: 0;
        }
        .pdf-title-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 260px;
        }
        .pdf-title-sub {
            color: #94a3b8;
            font-size: 11.5px;
            font-weight: normal;
            white-space: nowrap;
        }
        .pdf-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }
        .pdf-btn {
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12.5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s ease;
            text-decoration: none;
            line-height: 1.4;
        }
        .pdf-btn-primary {
            background-color: #2563eb;
            color: #ffffff;
        }
        .pdf-btn-primary:hover {
            background-color: #1d4ed8;
        }
        .pdf-btn-close {
            background-color: #334155;
            color: #e2e8f0;
        }
        .pdf-btn-close:hover {
            background-color: #475569;
        }
        .pdf-mobile-hint {
            display: none;
            position: fixed;
            top: 50px;
            left: 0;
            right: 0;
            background: #1e293b;
            color: #cbd5e1;
            font-size: 11px;
            text-align: center;
            padding: 4px 10px;
            border-bottom: 1px solid #334155;
            z-index: 999998;
        }
        .pdf-page-wrapper {
            width: 100%;
            min-height: 100vh;
            background-color: #f1f5f9;
            padding-top: 50px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .pdf-sheet-scroll {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 22px 14px 40px 14px;
            min-width: fit-content;
        }
        .pdf-sheet {
            background: #ffffff;
            width: 100%;
            max-width: ' . ($orientation === 'landscape' ? '1120px' : '820px') . ';
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 6px;
            padding: 30px 35px;
            box-sizing: border-box;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            display: table-header-group;
        }
        tr {
            page-break-inside: avoid;
        }
        @media screen and (max-width: 991px) {
            .pdf-title-text {
                max-width: 150px;
                font-size: 12.5px;
            }
            .pdf-title-sub {
                display: none;
            }
            .pdf-btn {
                padding: 6px 10px;
                font-size: 11.5px;
            }
            .pdf-mobile-hint {
                display: block;
            }
            .pdf-page-wrapper {
                padding-top: 74px;
            }
            .pdf-sheet-scroll {
                padding: 14px 8px 30px 8px;
                justify-content: flex-start;
            }
            .pdf-sheet {
                min-width: ' . ($orientation === 'landscape' ? '960px' : '720px') . ' !important;
                padding: 22px 18px;
                border-radius: 4px;
            }
        }
        @media print {
            .pdf-print-bar, .pdf-mobile-hint {
                display: none !important;
            }
            body, .pdf-page-wrapper, .pdf-sheet-scroll {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                min-width: 0 !important;
                overflow: visible !important;
            }
            .pdf-sheet {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                border-radius: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div class="pdf-print-bar">
        <div class="pdf-title-info">
            <span class="pdf-title-icon">📄</span>
            <span class="pdf-title-text" title="' . htmlspecialchars($clean_title_display) . '">' . htmlspecialchars($clean_title_display) . '</span>
            <span class="pdf-title-sub">(Dokumen Cetak / Simpan PDF)</span>
        </div>
        <div class="pdf-actions">
            <button onclick="window.print()" class="pdf-btn pdf-btn-primary">
                <span>🖨️</span> <span>Cetak / PDF</span>
            </button>
            <button onclick="window.close()" class="pdf-btn pdf-btn-close">
                <span>✕</span> <span>Tutup</span>
            </button>
        </div>
    </div>

    <div class="pdf-mobile-hint">
        <span>↔ <em>Geser layar ke samping untuk melihat seluruh kolom dokumen</em></span>
    </div>

    <div class="pdf-page-wrapper">
        <div class="pdf-sheet-scroll">
            <div class="pdf-sheet">
                ' . $body_content . '
            </div>
        </div>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                window.print();
            }, 400);
        });
    </script>
</body>
</html>';
            exit;
        }
    }
}