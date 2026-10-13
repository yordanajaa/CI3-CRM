/**
 * Thermal Bluetooth Printer Driver for POS Kasir (Web Bluetooth API + ESC/POS)
 * IDMETAFORA ERP / POS System
 *
 * Mendukung printer thermal Bluetooth BLE (58mm / 80mm) seperti:
 * Panda, Iware, VSC, Eppos, GOOJPRT, PT-210, MPT-II, RPP02N, Zjiang, dsb.
 *
 * FITUR UTAMA:
 * - Sekali pair/sambungkan, koneksi persisten selama sesi browser.
 * - Jika printer disconnect (mati/keluar jangkauan), otomatis reconnect
 *   tanpa perlu menampilkan popup pencarian Bluetooth lagi.
 * - Tombol "Cetak" langsung mencetak tanpa popup pencarian.
 */
(function(window) {
   'use strict';

   // ESC/POS Command Constants
   const ESC = 0x1B;
   const GS  = 0x1D;
   const LF  = 0x0A;

   // Common BLE Thermal Printer Services & Characteristics
   const PRINTER_SERVICES = [
      '000018f0-0000-1000-8000-00805f9b34fb', // Standard BLE Print Service
      'e7810a71-73ae-499d-8c15-faa9aef0c3f2', // MPT-II, Iware, Panda, RPP02
      '49535343-fe7d-4e58-83cd-ab2821046132', // ISSC Transparent UART
      '0000fee7-0000-1000-8000-00805f9b34fb', // Tencent POS BLE
      '0000ff00-0000-1000-8000-00805f9b34fb', // Common 58mm BLE
      '0000fff0-0000-1000-8000-00805f9b34fb', // VSC / GOOJPRT
      '0000ffe0-0000-1000-8000-00805f9b34fb', // HM-10 / CC2541 BLE serial
      '0000ae30-0000-1000-8000-00805f9b34fb', // Alternative BLE
      '0000af30-0000-1000-8000-00805f9b34fb', // Alternative BLE 2
      '6e400001-b5a3-f393-e0a9-e50e24dcca9e', // Nordic UART Service (NUS)
      '0000fee0-0000-1000-8000-00805f9b34fb', // Common BLE Serial
      '00001800-0000-1000-8000-00805f9b34fb', // Generic Access
      '00001801-0000-1000-8000-00805f9b34fb', // Generic Attribute
      '0000180a-0000-1000-8000-00805f9b34fb'  // Device Info
   ];

   class ThermalBluetoothPrinter {
      constructor() {
         this.device = null;
         this.server = null;
         this.characteristic = null;
         this.listeners = [];
         this.paperWidthChars = 32; // Default 32 karakter (standar kertas 58mm)
         this._reconnecting = false;
         this._serviceUuid = null;    // UUID service yang berhasil ditemukan
         this._charUuid = null;       // UUID characteristic yang berhasil ditemukan
      }

      /**
       * Cek apakah browser mendukung Web Bluetooth API
       */
      isSupported() {
         return Boolean(window.navigator && window.navigator.bluetooth);
      }

      /**
       * Cek apakah printer saat ini terhubung dan siap cetak
       */
      isConnected() {
         return Boolean(this.device && this.device.gatt && this.device.gatt.connected && this.characteristic);
      }

      /**
       * Cek apakah sudah pernah pair (device masih di-remember browser)
       */
      isPaired() {
         return Boolean(this.device);
      }

      /**
       * Ambil nama printer yang tersambung
       */
      getDeviceName() {
         return this.device ? (this.device.name || 'Printer Bluetooth') : null;
      }

      /**
       * Ambil status lengkap koneksi
       */
      getStatus() {
         if (!this.device) {
            return { status: 'unpaired', label: 'Belum Disambungkan', color: '#94a3b8', icon: 'fa-bluetooth' };
         }
         if (this.isConnected()) {
            return { status: 'connected', label: 'Tersambung: ' + this.getDeviceName(), color: '#10b981', icon: 'fa-check-circle' };
         }
         return { status: 'paired', label: 'Terpasangkan: ' + this.getDeviceName() + ' (Offline)', color: '#f59e0b', icon: 'fa-exclamation-circle' };
      }

      /**
       * Daftarkan listener saat status koneksi berubah
       */
      onStateChange(callback) {
         if (typeof callback === 'function') {
            this.listeners.push(callback);
         }
      }

      _notifyState() {
         const st = this.getStatus();
         this.listeners.forEach(fn => {
            try { fn(st); } catch(e){}
         });
      }

      /**
       * Cari dan temukan write characteristic dari GATT server yang sudah terkoneksi
       */
      async _discoverCharacteristic() {
         if (!this.server || !this.server.connected) {
            throw new Error('GATT server tidak terhubung.');
         }

         let writeChar = null;
         let foundServiceUuid = null;
         let foundCharUuid = null;

         // Jika kita sudah tahu UUID dari koneksi sebelumnya, coba langsung
         if (this._serviceUuid && this._charUuid) {
            try {
               const service = await this.server.getPrimaryService(this._serviceUuid);
               const c = await service.getCharacteristic(this._charUuid);
               if (c && (c.properties.write || c.properties.writeWithoutResponse)) {
                  this.characteristic = c;
                  this._notifyState();
                  return c;
               }
            } catch (err) {
               // UUID lama tidak valid lagi, scan ulang
            }
         }

         // 1. Coba dari service UUID yang umum
         for (const sUuid of PRINTER_SERVICES) {
            try {
               const service = await this.server.getPrimaryService(sUuid);
               const chars = await service.getCharacteristics();
               for (const c of chars) {
                  if (c.properties.write || c.properties.writeWithoutResponse) {
                     writeChar = c;
                     foundServiceUuid = sUuid;
                     foundCharUuid = c.uuid;
                     break;
                  }
               }
               if (writeChar) break;
            } catch (err) {
               // Lanjut service berikutnya
            }
         }

         // 2. Jika belum ditemukan, scan seluruh primary service di perangkat
         if (!writeChar) {
            try {
               const services = await this.server.getPrimaryServices();
               for (const service of services) {
                  try {
                     const chars = await service.getCharacteristics();
                     for (const c of chars) {
                        if (c.properties.write || c.properties.writeWithoutResponse) {
                           writeChar = c;
                           foundServiceUuid = service.uuid;
                           foundCharUuid = c.uuid;
                           break;
                        }
                     }
                     if (writeChar) break;
                  } catch(e) {}
               }
            } catch(e) {}
         }

         if (!writeChar) {
            throw new Error('Perangkat Bluetooth "' + (this.device.name || '') + '" terhubung, tetapi tidak ditemukan port/service pencetakan thermal.');
         }

         // Simpan UUID yang berhasil agar reconnect lebih cepat
         this._serviceUuid = foundServiceUuid;
         this._charUuid = foundCharUuid;
         this.characteristic = writeChar;
         this._notifyState();
         return writeChar;
      }

      /**
       * PAIR: Tampilkan popup pencarian Bluetooth browser untuk memilih printer.
       * Hanya perlu dipanggil SATU KALI. Setelah pair, koneksi akan di-maintain
       * dan reconnect otomatis tanpa popup.
       */
      async pair() {
         if (!this.isSupported()) {
            throw new Error('Web Bluetooth API tidak didukung pada browser ini. Harap gunakan Google Chrome atau Microsoft Edge via HTTPS / localhost.');
         }

         // Meminta izin dan memilih perangkat printer bluetooth (POPUP BROWSER)
         this.device = await navigator.bluetooth.requestDevice({
            acceptAllDevices: true,
            optionalServices: PRINTER_SERVICES
         });

         if (!this.device) {
            throw new Error('Tidak ada perangkat Bluetooth yang dipilih.');
         }

         // Pasang disconnect listener untuk auto-reconnect
         this.device.addEventListener('gattserverdisconnected', () => {
            this.characteristic = null;
            this.server = null;
            this._notifyState();
            // Auto reconnect setelah 1 detik
            setTimeout(() => {
               this._autoReconnect();
            }, 1000);
         });

         // Hubungkan ke GATT Server
         this.server = await this.device.gatt.connect();

         // Cari characteristic
         await this._discoverCharacteristic();

         return this.device;
      }

      /**
       * RECONNECT: Sambungkan kembali ke device yang sudah di-pair TANPA popup.
       * Dipanggil otomatis jika printer sempat disconnect (mati/keluar jangkauan).
       */
      async reconnect() {
         if (!this.device) {
            throw new Error('Belum ada printer yang dipasangkan. Silakan klik "Sambungkan Printer" terlebih dahulu.');
         }

         if (this.isConnected()) {
            return this.device; // Sudah tersambung
         }

         // Reconnect GATT tanpa popup pencarian browser
         this.server = await this.device.gatt.connect();

         // Re-discover characteristic
         await this._discoverCharacteristic();

         return this.device;
      }

      /**
       * Auto reconnect (dipanggil oleh disconnect listener)
       */
      async _autoReconnect() {
         if (this._reconnecting || !this.device || this.isConnected()) return;
         this._reconnecting = true;
         try {
            await this.reconnect();
            console.log('[ThermalPrinter] Auto-reconnected to:', this.getDeviceName());
         } catch(e) {
            console.warn('[ThermalPrinter] Auto-reconnect failed (printer mungkin mati):', e.message);
         } finally {
            this._reconnecting = false;
         }
      }

      /**
       * CONNECT: Smart connect - jika sudah pair, coba reconnect.
       * Jika belum pair atau reconnect gagal, langsung buka popup pencarian.
       */
      async connect() {
         if (this.isConnected()) {
            return this.device;
         }

         if (this.device) {
            try {
               return await this.reconnect();
            } catch (err) {
               console.warn('[ThermalPrinter] Reconnect failed, requesting device pairing:', err.message);
            }
         }

         // Belum terhubung / reconnect gagal -> tampilkan popup pencarian Bluetooth
         return await this.pair();
      }

      /**
       * Putuskan koneksi printer (manual disconnect)
       */
      disconnect() {
         if (this.device && this.device.gatt && this.device.gatt.connected) {
            this.device.gatt.disconnect();
         }
         this.characteristic = null;
         this.server = null;
         // JANGAN set this.device = null agar bisa reconnect tanpa popup
         this._notifyState();
      }

      /**
       * Unpair: Putuskan sepenuhnya dan lupakan device
       */
      unpair() {
         this.disconnect();
         this.device = null;
         this._serviceUuid = null;
         this._charUuid = null;
         this._notifyState();
      }

      /**
       * Format angka rupiah 15000000 -> 15.500.000
       */
      _formatNum(n) {
         return parseInt(n || 0).toLocaleString('id-ID');
      }

      /**
       * Format baris 2 kolom (kiri & kanan) pas sesuai lebar kertas (32 karakter)
       */
      _padTwoCol(left, right, width = 32) {
         const l = String(left || '');
         const r = String(right || '');
         const maxLeft = width - r.length - 1;
         let trimmedLeft = l;
         if (trimmedLeft.length > maxLeft) {
            trimmedLeft = trimmedLeft.substring(0, maxLeft);
         }
         const spaces = Math.max(1, width - trimmedLeft.length - r.length);
         return trimmedLeft + ' '.repeat(spaces) + r + '\n';
      }

      /**
       * Susun baris meta format "Label : Value"
       */
      _padMeta(label, value, width = 32) {
         const lbl = (label + '            ').substring(0, 11) + ': ';
         return lbl + String(value || '-') + '\n';
      }

      /**
       * Generate byte ESC/POS dari struktur data struk
       */
      buildEscPos(rc, paperWidth = 32) {
         const bytes = [];
         const add = (arr) => bytes.push(...arr);
         const enc = new TextEncoder();
         const addText = (str) => {
            bytes.push(...enc.encode(str));
         };

         // Inisialisasi printer & reset
         add([ESC, 0x40]); // ESC @
         add([ESC, 0x74, 0x00]); // PC437 charset

         // Header Toko (Rata Tengah)
         add([ESC, 0x61, 0x01]); // Align Center
         add([ESC, 0x45, 0x01]); // Bold ON
         add([GS, 0x21, 0x11]);  // Double Height & Width
         addText('IDMETAFORA STORE\n');
         add([GS, 0x21, 0x00]);  // Normal Font
         add([ESC, 0x45, 0x00]); // Bold OFF

         addText('SISTEM KASIR & RETAIL TERPADU\n');
         addText('Jl. Imogiri Timur KM 7, Banguntapan, Bantul, DIY\n');
         addText('Telp/WA: 0812-3456-7890\n');

         // Garis Pembatas
         addText('-'.repeat(paperWidth) + '\n');

         // Info Nota & Transaksi (Rata Kiri)
         add([ESC, 0x61, 0x00]); // Align Left
         addText(this._padMeta('No. Nota', rc.nomor_so || '-', paperWidth));
         if (rc.nomor_inv) addText(this._padMeta('No. Faktur', rc.nomor_inv, paperWidth));
         if (rc.nomor_bkm) addText(this._padMeta('No. Kas/BKM', rc.nomor_bkm, paperWidth));
         addText(this._padMeta('Tanggal', rc.tanggal || '-', paperWidth));
         addText(this._padMeta('Kasir', rc.kasir || 'Kasir POS', paperWidth));
         addText(this._padMeta('Pelanggan', rc.pelanggan || 'Umum', paperWidth));
         if (rc.telepon) addText(this._padMeta('Telp', rc.telepon, paperWidth));

         addText('-'.repeat(paperWidth) + '\n');

         // Rincian Item Pesanan
         let totalQty = 0;
         (rc.items || []).forEach(it => {
            const qty = parseFloat(it.qty) || 1;
            totalQty += qty;
            const nm = String(it.nama_produk || it.nama || 'Item').trim();
            
            // Nama barang (Tebal)
            add([ESC, 0x45, 0x01]);
            addText(nm + '\n');
            add([ESC, 0x45, 0x00]);

            // Qty x Harga Jual (Kiri) & Subtotal (Kanan)
            const subStr = 'Rp ' + this._formatNum(it.subtotal);
            const discNote = (parseFloat(it.diskon_persen) > 0) ? ` (Disc ${it.diskon_persen}%)` : '';
            const calcStr = `  ${qty} ${it.satuan || 'pcs'} x ${this._formatNum(it.harga_satuan)}${discNote}`;
            addText(this._padTwoCol(calcStr, subStr, paperWidth));
         });

         addText('-'.repeat(paperWidth) + '\n');

         // Ringkasan Subtotal, Diskon, Pajak
         addText(this._padTwoCol(`Total Item (${totalQty} pcs)`, 'Rp ' + this._formatNum(rc.subtotal), paperWidth));

         if (parseFloat(rc.diskon_total) > 0) {
            addText(this._padTwoCol('Diskon Nota', '- Rp ' + this._formatNum(rc.diskon_total), paperWidth));
         }
         if (parseFloat(rc.pajak_nominal) > 0) {
            addText(this._padTwoCol('PPN', '+ Rp ' + this._formatNum(rc.pajak_nominal), paperWidth));
         }

         addText('='.repeat(paperWidth) + '\n');

         // TOTAL TAGIHAN (Tebal)
         add([ESC, 0x45, 0x01]); // Bold ON
         addText(this._padTwoCol('TOTAL TAGIHAN', 'Rp ' + this._formatNum(rc.total), paperWidth));
         add([ESC, 0x45, 0x00]); // Bold OFF

         addText(this._padTwoCol('Metode Bayar', String(rc.metode_pembayaran || 'TUNAI').toUpperCase(), paperWidth));
         addText(this._padTwoCol('Bayar / Diterima', 'Rp ' + this._formatNum(rc.uang_diterima || rc.total), paperWidth));

         add([ESC, 0x45, 0x01]);
         addText(this._padTwoCol('KEMBALIAN', 'Rp ' + this._formatNum(rc.kembalian || 0), paperWidth));
         add([ESC, 0x45, 0x00]);

         addText('='.repeat(paperWidth) + '\n');

         // Footer Ucapan Terima Kasih (Rata Tengah)
         add([ESC, 0x61, 0x01]); // Align Center
         add([ESC, 0x45, 0x01]);
         addText('=== STATUS: LUNAS DIRECT ===\n');
         add([ESC, 0x45, 0x00]);
         addText('TERIMA KASIH ATAS KUNJUNGAN ANDA!\n');
         addText('Barang yang dibeli tidak dapat ditukar/dikembalikan.\n');
         addText('Struk ini merupakan bukti pembayaran sah.\n');

         // Spasi Kertas (Feed) & Potong
         addText('\n\n\n\n');
         add([GS, 0x56, 0x41, 0x10]); // Partial Cut paper

         return new Uint8Array(bytes);
      }

      /**
       * Cetak struk langsung via Web Bluetooth API (dikirim per chunks)
       */
      async printReceipt(rc, onProgress) {
         // Smart connect: reconnect jika sudah pair, atau pair baru jika belum
         if (!this.isConnected()) {
            await this.connect();
         }

         if (!this.characteristic) {
            throw new Error('Karakteristik Bluetooth printer tidak tersedia.');
         }

         const rawBytes = this.buildEscPos(rc, this.paperWidthChars);

         // Kirim dalam potongan data (chunks 40-50 byte) untuk mencegah buffer overflow pada mikrokontroler mini printer
         const CHUNK_SIZE = 45;
         const totalChunks = Math.ceil(rawBytes.length / CHUNK_SIZE);

         for (let i = 0; i < rawBytes.length; i += CHUNK_SIZE) {
            const slice = rawBytes.subarray(i, Math.min(i + CHUNK_SIZE, rawBytes.length));
            
            if (this.characteristic.properties.write) {
               await this.characteristic.writeValue(slice);
            } else if (this.characteristic.properties.writeWithoutResponse) {
               await this.characteristic.writeValueWithoutResponse(slice);
            }

            if (typeof onProgress === 'function') {
               const currentChunk = Math.floor(i / CHUNK_SIZE) + 1;
               onProgress(Math.round((currentChunk / totalChunks) * 100));
            }

            // Jeda 25 milidetik antar paket data BLE
            await new Promise(r => setTimeout(r, 25));
         }

         return true;
      }

      /**
       * PAIR AND PRINT:
       * Jika belum terhubung, LANGSUNG panggil dialog pairing browser (navigator.bluetooth.requestDevice)
       * pada baris pertama eksekusi click event agar user-gesture token tidak expired.
       * Setelah printer dipilih & terhubung, segera kirim data struk untuk dicetak.
       */
      async pairAndPrint(rc, onProgress, forcePair = false) {
         if (!this.isSupported()) {
            throw new Error('Web Bluetooth API tidak didukung pada browser ini. Harap gunakan Google Chrome atau Microsoft Edge melalui URL HTTPS.');
         }

         if (forcePair || !this.isConnected()) {
            await this.pair();
         }

         if (!this.characteristic) {
            throw new Error('Karakteristik Bluetooth printer tidak ditemukan.');
         }

         return await this.printReceipt(rc, onProgress);
      }
   }

   // Buat instance global (singleton - koneksi persisten selama sesi halaman)
   window.ThermalPrinter = new ThermalBluetoothPrinter();

})(window);
