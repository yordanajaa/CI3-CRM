<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cetak Nota - <?= _ent($so->nomor_so ?? 'Dokumen'); ?></title>
   <style>
      * {
         box-sizing: border-box;
         margin: 0;
         padding: 0;
      }
      body {
         font-family: Arial, Helvetica, sans-serif;
         font-size: 12px;
         color: #1e293b;
         background: #f1f5f9;
         padding: 15px;
      }

      /* TOOLBAR ATAS (TEMPLATE SWITCHER & ACTION BUTTONS) */
      .top-control-panel {
         max-width: 960px;
         margin: 0 auto 16px auto;
         background: #ffffff;
         border: 1px solid #cbd5e1;
         border-radius: 8px;
         padding: 10px 14px;
         box-shadow: 0 2px 8px rgba(0,0,0,0.06);
         display: flex;
         flex-wrap: wrap;
         align-items: center;
         justify-content: space-between;
         gap: 10px;
      }
      .template-nav {
         display: flex;
         align-items: center;
         gap: 6px;
      }
      .template-nav-label {
         font-size: 11px;
         font-weight: 700;
         color: #64748b;
         text-transform: uppercase;
         letter-spacing: 0.5px;
         margin-right: 4px;
      }
      .btn-tab {
         padding: 7px 14px;
         font-size: 12px;
         font-weight: 700;
         border-radius: 6px;
         border: 1.5px solid #cbd5e1;
         background: #f8fafc;
         color: #334155;
         cursor: pointer;
         transition: all 0.2s ease;
         display: inline-flex;
         align-items: center;
         gap: 6px;
      }
      .btn-tab:hover {
         background: #f1f5f9;
         border-color: #94a3b8;
      }
      .btn-tab.active {
         background: #0284c7;
         color: #ffffff;
         border-color: #0369a1;
         box-shadow: 0 2px 6px rgba(2,132,199,0.3);
      }
      .action-buttons {
         display: flex;
         align-items: center;
         gap: 6px;
      }
      .btn-action {
         padding: 7px 14px;
         font-size: 12px;
         font-weight: 700;
         border-radius: 6px;
         border: none;
         cursor: pointer;
         display: inline-flex;
         align-items: center;
         gap: 6px;
         text-decoration: none;
         transition: all 0.15s ease;
      }
      .btn-action-primary {
         background: #059669;
         color: #fff;
         box-shadow: 0 2px 6px rgba(5,150,105,0.25);
      }
      .btn-action-primary:hover {
         background: #047857;
      }
      .btn-action-bluetooth {
         background: #2563eb;
         color: #fff;
         box-shadow: 0 2px 6px rgba(37,99,235,0.25);
      }
      .btn-action-bluetooth:hover {
         background: #1d4ed8;
      }
      .btn-action-pdf {
         background: #0284c7;
         color: #fff;
      }
      .btn-action-pdf:hover {
         background: #0369a1;
      }
      .btn-action-close {
         background: #64748b;
         color: #fff;
      }
      .btn-action-close:hover {
         background: #475569;
      }

      .bt-status-card {
         max-width: 960px;
         margin: 0 auto 12px auto;
         font-size: 11px;
         color: #0369a1;
         background: #f0f9ff;
         border: 1px solid #bae6fd;
         border-radius: 6px;
         padding: 6px 12px;
         display: flex;
         align-items: center;
         justify-content: space-between;
      }

      /* ========================================================
         TEMPLATE 1: STANDAR THERMAL PRINT POS (58mm / 80mm)
         ======================================================== */
      .receipt-wrapper {
         max-width: 330px;
         margin: 0 auto;
         background: #fff;
         padding: 16px 14px;
         border-radius: 8px;
         box-shadow: 0 4px 18px rgba(0,0,0,0.08);
         font-family: 'Courier New', Courier, monospace;
         font-size: 12px;
         color: #000;
         border: 1px solid #e2e8f0;
      }
      .receipt-wrapper .text-center { text-align: center; }
      .receipt-wrapper .text-right { text-align: right; }
      .receipt-wrapper .text-left { text-align: left; }
      .receipt-wrapper .fw-bold { font-weight: bold; }
      .receipt-wrapper .store-name {
         font-size: 15px;
         font-weight: 900;
         letter-spacing: 0.5px;
         margin-bottom: 2px;
      }
      .receipt-wrapper .store-sub {
         font-size: 10px;
         color: #333;
         line-height: 1.35;
      }
      .receipt-wrapper .divider {
         border-top: 1px dashed #000;
         margin: 8px 0;
      }
      .receipt-wrapper .divider-double {
         border-top: 1px dashed #000;
         border-bottom: 1px dashed #000;
         height: 3px;
         margin: 8px 0;
      }
      .receipt-wrapper .meta-table,
      .receipt-wrapper .item-table,
      .receipt-wrapper .total-table {
         width: 100%;
         font-size: 11px;
         border-collapse: collapse;
      }
      .receipt-wrapper .meta-table td {
         padding: 1.5px 0;
         vertical-align: top;
      }
      .receipt-wrapper .item-table td {
         padding: 2.5px 0;
         vertical-align: top;
      }
      .receipt-wrapper .total-table td {
         padding: 2px 0;
         vertical-align: top;
      }
      .receipt-wrapper .item-name {
         font-weight: bold;
         display: block;
         font-size: 11px;
      }
      .receipt-wrapper .item-calc {
         font-size: 10.5px;
         color: #222;
      }
      .receipt-wrapper .footer-note {
         font-size: 10px;
         text-align: center;
         line-height: 1.35;
         margin-top: 8px;
         color: #222;
      }

      /* ========================================================
         TEMPLATE 2: NOTA / FAKTUR LEBAR PERUSAHAAN (A4 / CONTINUOUS)
         ======================================================== */
      .invoice-lebar-wrapper {
         max-width: 960px;
         margin: 0 auto;
         background: #ffffff;
         padding: 24px 28px;
         border-radius: 8px;
         box-shadow: 0 4px 20px rgba(0,0,0,0.08);
         font-family: Arial, Helvetica, sans-serif;
         font-size: 11.5px;
         color: #0f172a;
         border: 1px solid #cbd5e1;
      }
      .inv-header-table {
         width: 100%;
         border-collapse: collapse;
         margin-bottom: 12px;
      }
      .inv-kop-title {
         font-size: 18px;
         font-weight: 900;
         color: #0f172a;
         letter-spacing: 0.5px;
         margin-bottom: 2px;
      }
      .inv-kop-sub {
         font-size: 11px;
         color: #475569;
         line-height: 1.4;
      }
      .inv-badge-title {
         font-size: 16px;
         font-weight: 800;
         color: #0284c7;
         text-transform: uppercase;
         letter-spacing: 0.5px;
         margin-bottom: 6px;
         text-align: right;
      }
      .inv-meta-box-table {
         width: 100%;
         font-size: 11px;
         border-collapse: collapse;
         margin-left: auto;
      }
      .inv-meta-box-table td {
         padding: 2px 4px;
         vertical-align: top;
      }
      .inv-divider-double {
         border-top: 2px solid #0f172a;
         border-bottom: 1px solid #0f172a;
         height: 3px;
         margin: 10px 0 14px 0;
      }
      .inv-info-grid {
         width: 100%;
         border-collapse: collapse;
         margin-bottom: 14px;
      }
      .inv-info-box {
         width: 48%;
         background: #f8fafc;
         border: 1px solid #e2e8f0;
         border-radius: 6px;
         padding: 10px 14px;
         vertical-align: top;
      }
      .inv-info-title {
         font-size: 11px;
         font-weight: 800;
         color: #0369a1;
         text-transform: uppercase;
         letter-spacing: 0.5px;
         border-bottom: 1px dashed #cbd5e1;
         padding-bottom: 4px;
         margin-bottom: 6px;
      }
      .inv-info-content-table {
         width: 100%;
         font-size: 11px;
         border-collapse: collapse;
      }
      .inv-info-content-table td {
         padding: 2px 0;
         vertical-align: top;
      }

      /* Tabel Item Grid Lebar */
      .inv-items-table {
         width: 100%;
         border-collapse: collapse;
         margin-bottom: 14px;
         font-size: 11px;
      }
      .inv-items-table th {
         background: #f1f5f9;
         color: #1e293b;
         font-weight: 800;
         text-transform: uppercase;
         font-size: 10.5px;
         padding: 7px 6px;
         border-top: 1.5px solid #334155;
         border-bottom: 1.5px solid #334155;
         border-left: 1px solid #e2e8f0;
         border-right: 1px solid #e2e8f0;
         letter-spacing: 0.3px;
      }
      .inv-items-table td {
         padding: 6px 6px;
         border-bottom: 1px solid #e2e8f0;
         border-left: 1px solid #f1f5f9;
         border-right: 1px solid #f1f5f9;
         vertical-align: middle;
      }
      .inv-items-table tbody tr:nth-child(even) {
         background: #fafbfc;
      }
      .inv-items-table tfoot td {
         padding: 6px 8px;
         font-size: 11px;
         border-top: 1.5px solid #334155;
         border-bottom: 1.5px solid #334155;
      }

      /* Bagian Rekap & Terbilang Bawah */
      .inv-bottom-table {
         width: 100%;
         border-collapse: collapse;
         margin-bottom: 16px;
      }
      .inv-bottom-table td {
         vertical-align: top;
      }
      .inv-terbilang-box {
         background: #f8fafc;
         border: 1px solid #e2e8f0;
         border-radius: 6px;
         padding: 8px 12px;
         margin-bottom: 8px;
         font-size: 11px;
      }
      .inv-terms-box {
         font-size: 10px;
         color: #475569;
         line-height: 1.45;
         padding-right: 14px;
      }
      .inv-totals-box-table {
         width: 100%;
         font-size: 11.5px;
         border-collapse: collapse;
      }
      .inv-totals-box-table td {
         padding: 3px 6px;
      }
      .inv-totals-grand {
         font-size: 13.5px;
         font-weight: 800;
         color: #0f172a;
         background: #f0fdf4;
         border-top: 1.5px solid #86efac;
         border-bottom: 1.5px solid #86efac;
      }

      /* 4 Kolom Tanda Tangan */
      .inv-signatures-table {
         width: 100%;
         border-collapse: collapse;
         margin-top: 16px;
         page-break-inside: avoid;
      }
      .inv-signatures-table td {
         width: 25%;
         text-align: center;
         font-size: 10.5px;
         vertical-align: top;
         padding: 0 6px;
      }
      .inv-sig-space {
         height: 52px;
      }
      .inv-sig-name {
         border-top: 1px solid #334155;
         padding-top: 4px;
         font-weight: 700;
      }
      .inv-rangkap-note {
         font-size: 9.5px;
         color: #64748b;
         margin-top: 12px;
         text-align: left;
         font-style: italic;
         border-top: 1px dashed #cbd5e1;
         padding-top: 4px;
      }

      /* ========================================================
         RESPONSIVE & MOBILE-FRIENDLY UI/UX (SCREEN ONLY)
         ======================================================== */
      @media screen and (max-width: 768px) {
         body {
            padding: 8px !important;
         }
         .top-control-panel {
            padding: 10px 12px !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            border-radius: 8px !important;
         }
         .template-nav {
            flex-direction: column !important;
            align-items: stretch !important;
            width: 100% !important;
            gap: 6px !important;
         }
         .template-nav-label {
            text-align: center !important;
            margin-bottom: 2px !important;
            font-size: 11px !important;
         }
         .btn-tab {
            width: 100% !important;
            min-height: 42px !important;
            justify-content: center !important;
            font-size: 12.5px !important;
            padding: 8px 10px !important;
         }
         .action-buttons {
            width: 100% !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
         }
         .btn-action {
            width: 100% !important;
            min-height: 42px !important;
            justify-content: center !important;
            font-size: 13px !important;
            padding: 10px 12px !important;
         }
         .bt-status-card {
            flex-direction: column !important;
            gap: 8px !important;
            text-align: center !important;
            padding: 10px 12px !important;
         }
         #btn_connect_bt {
            width: 100% !important;
            min-height: 38px !important;
            font-size: 12px !important;
         }

         /* Struk Thermal di Layar Mobile */
         .receipt-wrapper {
            max-width: 100% !important;
            width: 100% !important;
            padding: 14px 12px !important;
            border-radius: 8px !important;
         }

         /* Faktur Lebar di Layar Mobile */
         .invoice-lebar-wrapper {
            max-width: 100% !important;
            width: 100% !important;
            padding: 16px 12px !important;
            border-radius: 8px !important;
         }
         .inv-header-table td {
            display: block !important;
            width: 100% !important;
         }
         .inv-badge-title {
            text-align: left !important;
            margin-top: 10px !important;
            font-size: 15px !important;
         }
         .inv-meta-box-table {
            margin-left: 0 !important;
            width: 100% !important;
         }
         .inv-info-grid td.inv-info-box {
            display: block !important;
            width: 100% !important;
            margin-bottom: 8px !important;
         }
         .inv-info-grid td[style*="width: 4%"] {
            display: none !important;
         }
         .inv-items-table {
            min-width: 580px !important;
         }
         .inv-table-scroll-wrap {
            width: 100% !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            margin-bottom: 12px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 6px !important;
         }
         .inv-bottom-table td {
            display: block !important;
            width: 100% !important;
            margin-bottom: 8px !important;
         }
         .inv-bottom-table td[style*="width: 4%"] {
            display: none !important;
         }
         .inv-signatures-table td {
            display: inline-block !important;
            width: 49% !important;
            margin-bottom: 12px !important;
            vertical-align: top !important;
         }
      }

      /* ========================================================
         TABLET & MID-SCREEN RESPONSIVE (769px - 1024px)
         ======================================================== */
      @media screen and (min-width: 769px) and (max-width: 1024px) {
         .top-control-panel {
            padding: 12px 18px !important;
            gap: 12px !important;
         }
         .invoice-lebar-wrapper {
            max-width: 95% !important;
            padding: 22px 24px !important;
         }
      }

      /* ========================================================
         MEDIA PRINT RULES
         ======================================================== */
      @media print {
         body {
            background: #ffffff !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
         }
         .top-control-panel,
         .bt-status-card {
            display: none !important;
         }

         /* Saat template Thermal aktif (Roll paper 58mm) */
         body.print-mode-thermal .receipt-wrapper {
            display: block !important;
            max-width: 100% !important;
            width: 100% !important;
            padding: 2mm 1mm !important;
            box-shadow: none !important;
            border: none !important;
         }
         body.print-mode-thermal .invoice-lebar-wrapper {
            display: none !important;
         }

         /* Saat template Faktur Lebar aktif (Kertas A4 Landscape) */
         body.print-mode-lebar .invoice-lebar-wrapper {
            display: block !important;
            max-width: 100% !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            box-shadow: none !important;
            border: none !important;
         }
         body.print-mode-lebar .receipt-wrapper {
            display: none !important;
         }
      }
   </style>
   <?php $current_tpl = isset($template) && $template === 'lebar' ? 'lebar' : 'thermal'; ?>
   <?php if ($current_tpl === 'lebar'): ?>
      <style id="dynamic_page_style">@page { size: A4 landscape; margin: 8mm 10mm; }</style>
   <?php else: ?>
      <style id="dynamic_page_style">@page { size: 58mm auto; margin: 0mm; }</style>
   <?php endif; ?>
</head>
<?php 
   $current_tpl = isset($template) && $template === 'lebar' ? 'lebar' : 'thermal';
?>
<body class="print-mode-<?= $current_tpl; ?>">

<!-- KONTROL PANEL ATAS (PILIHAN TEMPLATE & TOMBOL AKSI) -->
<div class="top-control-panel">
   <div class="template-nav">
      <span class="template-nav-label">Format Cetak:</span>
      <button type="button" class="btn-tab <?= $current_tpl === 'thermal' ? 'active' : ''; ?>" id="tab_btn_thermal" onclick="setTemplate('thermal')">
         🧾 1. Standar Thermal POS (58/80mm)
      </button>
      <button type="button" class="btn-tab <?= $current_tpl === 'lebar' ? 'active' : ''; ?>" id="tab_btn_lebar" onclick="setTemplate('lebar')">
         🏢 2. Nota / Faktur Lebar (Format Perusahaan)
      </button>
   </div>

   <div class="action-buttons">
      <!-- Tombol Aksi Template Thermal -->
      <button type="button" class="btn-action btn-action-bluetooth" id="btn_print_bluetooth" style="<?= $current_tpl === 'thermal' ? '' : 'display:none;'; ?>" title="Cetak langsung ke Thermal Bluetooth via ESC/POS">
         📶 CETAK BLUETOOTH
      </button>
      <button type="button" class="btn-action btn-action-primary" id="btn_print_thermal" style="<?= $current_tpl === 'thermal' ? '' : 'display:none;'; ?>" onclick="doPrint()" title="Cetak via dialog printer browser">
         🖨️ CETAK STRUK
      </button>

      <!-- Tombol Aksi Template Lebar -->
      <button type="button" class="btn-action btn-action-primary" id="btn_print_lebar" style="<?= $current_tpl === 'lebar' ? '' : 'display:none;'; ?>" onclick="doPrint()" title="Cetak Faktur Lebar Resmi ke Printer A4 / Continuous Form">
         🖨️ CETAK FAKTUR LEBAR (A4 / CONTINUOUS)
      </button>
      <?php 
         $pdf_download_url = !empty($inv->id) 
            ? site_url('administrator/invoice/print_invoice/' . $inv->id) 
            : site_url('administrator/sales_order/cetak/' . ($so->id ?? '')); 
      ?>
      <a href="<?= $pdf_download_url; ?>" target="_blank" class="btn-action btn-action-pdf" id="btn_pdf_download" title="Unduh Dokumen format PDF">
         📄 SIMPAN PDF
      </a>

      <button type="button" class="btn-action btn-action-close" onclick="closeOrReturn()" title="Tutup / Kembali">
         ✖ TUTUP / KEMBALI KE POS
      </button>
   </div>
</div>

<!-- Bluetooth Connection Status Bar (hanya untuk mode thermal) -->
<div class="bt-status-card" id="bt_status_bar" style="<?= $current_tpl === 'thermal' ? 'display:flex;' : 'display:none;'; ?>">
   <span>📶 <strong id="bt_device_label">Bluetooth: Belum Terhubung</strong></span>
   <button type="button" id="btn_connect_bt" style="background:#0284c7; color:#fff; border:none; border-radius:4px; padding:4px 12px; font-size:11px; font-weight:bold; cursor:pointer;">Hubungkan / Cari Printer</button>
</div>

<?php
   // Persiapan variabel data umum
   $metode = 'TUNAI';
   $catatan = $so->catatan ?? '';
   if (stripos($catatan, 'TRANSFER_MANDIRI') !== false) {
      $metode = 'TRANSFER MANDIRI';
   } elseif (stripos($catatan, 'TRANSFER') !== false || stripos($catatan, 'BCA') !== false) {
      $metode = 'TRANSFER BCA';
   } elseif (stripos($catatan, 'BRI') !== false) {
      $metode = 'TRANSFER BRI';
   } elseif (stripos($catatan, 'QRIS') !== false) {
      $metode = 'QRIS / E-WALLET';
   } elseif (stripos($catatan, 'DEBIT') !== false) {
      $metode = 'KARTU DEBIT';
   }
   
   $bayar = (float) $so->total;
   $kembalian = 0;
   if (preg_match('/Uang Diterima:\s*Rp\s*([\d\.]+)/', $catatan, $m_bayar)) {
      $bayar = (float) str_replace('.', '', $m_bayar[1]);
   }
   if (preg_match('/Kembalian:\s*Rp\s*([\d\.]+)/', $catatan, $m_kem)) {
      $kembalian = (float) str_replace('.', '', $m_kem[1]);
   }

   $total_qty = 0;
   $gross_item_total = 0;
   $item_disc_total = 0;
   foreach ($items as $it) {
      $q = (float) ($it->qty ?? 0);
      $h = (float) ($it->harga_satuan ?? 0);
      $d = (float) ($it->diskon_persen ?? 0);
      $g = $q * $h;
      $dis = $g * ($d / 100);
      $total_qty += $q;
      $gross_item_total += $g;
      $item_disc_total += $dis;
   }
   $grand_total = (float) ($so->total ?? 0);
   $terbilang_txt = function_exists('terbilang') ? ucwords(trim(terbilang($grand_total))) : '';
?>

<!-- ====================================================================
     TEMPLATE 1: STANDAR THERMAL PRINT POS (58mm / 80mm)
     ==================================================================== -->
<div class="receipt-wrapper" id="receipt_content" style="<?= $current_tpl === 'thermal' ? 'display:block;' : 'display:none;'; ?>">
   <!-- Header Toko -->
   <div class="text-center">
      <div class="store-name">IDMETAFORA STORE</div>
      <div class="store-sub">SISTEM KASIR &amp; PENJUALAN TERPADU</div>
      <div class="store-sub">Jl. Imogiri Timur KM 7, Banguntapan, Bantul, DIY</div>
      <div class="store-sub">Telp/WA: 0812-3456-7890</div>
   </div>

   <div class="divider"></div>

   <!-- Info Transaksi -->
   <table class="meta-table">
      <tr>
         <td width="30%">No. Nota</td>
         <td width="4%">:</td>
         <td class="fw-bold"><?= _ent($so->nomor_so ?? '-'); ?></td>
      </tr>
      <?php if (!empty($inv->nomor_invoice)): ?>
      <tr>
         <td>No. Faktur</td>
         <td>:</td>
         <td><?= _ent($inv->nomor_invoice); ?></td>
      </tr>
      <?php endif; ?>
      <?php if (!empty($bkm->nomor_bkm)): ?>
      <tr>
         <td>No. Kas/BKM</td>
         <td>:</td>
         <td><?= _ent($bkm->nomor_bkm); ?></td>
      </tr>
      <?php endif; ?>
      <tr>
         <td>Tanggal</td>
         <td>:</td>
         <td><?= date('d/m/Y H:i', strtotime($so->created_at ?? date('Y-m-d H:i:s'))); ?></td>
      </tr>
      <tr>
         <td>Kasir</td>
         <td>:</td>
         <td><?= _ent($so->created_by ?: 'Kasir POS'); ?></td>
      </tr>
      <tr>
         <td>Pelanggan</td>
         <td>:</td>
         <td class="fw-bold">
            <?= _ent($so->nama_pelanggan ?: ($so->nama_penerima ?: 'Pelanggan Umum')); ?>
         </td>
      </tr>
      <?php if (!empty($so->no_telepon ?: $so->telp_pelanggan)): ?>
      <tr>
         <td>Telp/WA</td>
         <td>:</td>
         <td><?= _ent($so->no_telepon ?: $so->telp_pelanggan); ?></td>
      </tr>
      <?php endif; ?>
   </table>

   <div class="divider"></div>

   <!-- Item Keranjang Belanja -->
   <table class="item-table">
      <?php foreach ($items as $it): 
            $qty = (float) $it->qty;
            $harga = (float) $it->harga_satuan;
            $disc = (float) ($it->diskon_persen ?? 0);
            $sub = (float) $it->subtotal;
      ?>
      <tr>
         <td colspan="2">
            <span class="item-name"><?= _ent($it->nama_produk); ?></span>
         </td>
      </tr>
      <tr>
         <td class="item-calc">
            <?= number_format($qty, 0, ',', '.'); ?> <?= _ent($it->singkatan ?? ($it->satuan ?: 'pcs')); ?> x <?= number_format($harga, 0, ',', '.'); ?>
            <?php if ($disc > 0): ?>
               <span style="color:#d9534f;">(Disc <?= $disc; ?>%)</span>
            <?php endif; ?>
         </td>
         <td class="text-right fw-bold" style="white-space: nowrap;">
            Rp <?= number_format($sub, 0, ',', '.'); ?>
         </td>
      </tr>
      <?php endforeach; ?>
   </table>

   <div class="divider"></div>

   <!-- Ringkasan Perhitungan -->
   <table class="total-table">
      <?php if ($item_disc_total > 0): ?>
      <tr>
         <td>Subtotal Belanja (<?= $total_qty; ?> pcs)</td>
         <td class="text-right">Rp <?= number_format($gross_item_total, 0, ',', '.'); ?></td>
      </tr>
      <tr>
         <td>Diskon Item</td>
         <td class="text-right" style="color:#d9534f;">- Rp <?= number_format($item_disc_total, 0, ',', '.'); ?></td>
      </tr>
      <?php else: ?>
      <tr>
         <td>Total Item (<?= $total_qty; ?> pcs)</td>
         <td class="text-right">Rp <?= number_format((float)$so->subtotal, 0, ',', '.'); ?></td>
      </tr>
      <?php endif; ?>
      <?php if ((float)$so->diskon_total > 0): ?>
      <tr>
         <td>Diskon Global (<?= (float)$so->diskon; ?>%)</td>
         <td class="text-right">- Rp <?= number_format((float)$so->diskon_total, 0, ',', '.'); ?></td>
      </tr>
      <?php endif; ?>
      <?php if ((float)$so->pajak_nominal > 0): ?>
      <tr>
         <td>PPN (<?= (float)$so->pajak_persen; ?>%)</td>
         <td class="text-right">+ Rp <?= number_format((float)$so->pajak_nominal, 0, ',', '.'); ?></td>
      </tr>
      <?php endif; ?>
   </table>

   <div class="divider-double"></div>

   <table class="total-table">
      <tr style="font-size: 13px;">
         <td class="fw-bold">TOTAL TAGIHAN</td>
         <td class="text-right fw-bold">Rp <?= number_format((float)$so->total, 0, ',', '.'); ?></td>
      </tr>
      <tr>
         <td>Metode Pembayaran</td>
         <td class="text-right fw-bold"><?= $metode; ?></td>
      </tr>
      <tr>
         <td>Bayar / Diterima</td>
         <td class="text-right">Rp <?= number_format($bayar, 0, ',', '.'); ?></td>
      </tr>
      <tr style="font-size: 12px;">
         <td class="fw-bold">KEMBALIAN</td>
         <td class="text-right fw-bold">Rp <?= number_format($kembalian, 0, ',', '.'); ?></td>
      </tr>
   </table>

   <div class="divider-double"></div>

   <!-- Footer Ucapan -->
   <div class="footer-note">
      <div class="fw-bold">=== STATUS: LUNAS DIRECT ===</div>
      <div style="margin-top: 4px;">TERIMA KASIH ATAS KUNJUNGAN ANDA!</div>
      <div>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan kecuali ada perjanjian.</div>
      <div style="margin-top: 4px; font-size: 9px; color: #555;">Struk ini merupakan bukti pembayaran sah</div>
   </div>
</div>


<!-- ====================================================================
     TEMPLATE 2: NOTA / FAKTUR LEBAR PERUSAHAAN (A4 / CONTINUOUS FORM)
     ==================================================================== -->
<div class="invoice-lebar-wrapper" id="invoice_lebar_content" style="<?= $current_tpl === 'lebar' ? 'display:block;' : 'display:none;'; ?>">
   
   <!-- KOP SURAT PERUSAHAAN & HEADER DOKUMEN -->
   <table class="inv-header-table">
      <tr>
         <td style="width: 58%; vertical-align: top;">
            <div class="inv-kop-title">IDMETAFORA STORE / PT. IDMETAFORA INDONESIA</div>
            <div class="inv-kop-sub">SISTEM INTEGRASI KASIR &amp; PENJUALAN TERPADU</div>
            <div class="inv-kop-sub">Jl. Imogiri Timur KM 7, Banguntapan, Bantul, D.I. Yogyakarta 55198</div>
            <div class="inv-kop-sub">Telp / WA: (0274) 123456 / 0812-3456-7890 | Email: billing@idmetafora.com</div>
            <div class="inv-kop-sub">NPWP: 01.234.567.8-543.000</div>
         </td>
         <td style="width: 42%; vertical-align: top;">
            <div class="inv-badge-title">FAKTUR PENJUALAN</div>
            <table class="inv-meta-box-table">
               <tr>
                  <td style="width: 40%; font-weight: bold;">No. Faktur</td>
                  <td style="width: 4%;">:</td>
                  <td style="font-weight: 800; font-size: 13px; color: #0f172a;"><?= _ent($inv->nomor_invoice ?? ($so->nomor_so ?? '-')); ?></td>
               </tr>
               <tr>
                  <td style="font-weight: bold;">No. Transaksi Penjualan</td>
                  <td>:</td>
                  <td><?= _ent($so->nomor_so ?? '-'); ?></td>
               </tr>
               <?php if (!empty($bkm->nomor_bkm)): ?>
               <tr>
                  <td style="font-weight: bold;">No. Kas/BKM</td>
                  <td>:</td>
                  <td><?= _ent($bkm->nomor_bkm); ?></td>
               </tr>
               <?php endif; ?>
               <tr>
                  <td style="font-weight: bold;">Tanggal Faktur</td>
                  <td>:</td>
                  <td><?= date('d/m/Y H:i', strtotime($so->created_at ?? date('Y-m-d H:i:s'))); ?></td>
               </tr>
               <tr>
                  <td style="font-weight: bold;">Jatuh Tempo</td>
                  <td>:</td>
                  <td><?= !empty($inv->tanggal_jatuh_tempo) ? date('d/m/Y', strtotime($inv->tanggal_jatuh_tempo)) : date('d/m/Y'); ?> (Cash / Lunas)</td>
               </tr>
            </table>
         </td>
      </tr>
   </table>

   <div class="inv-divider-double"></div>

   <!-- DUA KOTAK INFORMASI (PELANGGAN & DETAIL TRANSAKSI) -->
   <table class="inv-info-grid">
      <tr>
         <td class="inv-info-box">
            <div class="inv-info-title">Tagihan &amp; Pengiriman Kepada (Customer):</div>
            <table class="inv-info-content-table">
               <tr>
                  <td style="width: 28%; font-weight: 700;">Pelanggan</td>
                  <td style="width: 4%;">:</td>
                  <td style="font-weight: 800; font-size: 12px; color: #0284c7;">
                     <?= _ent($so->nama_pelanggan ?: ($so->nama_penerima ?: 'Pelanggan Umum')); ?>
                  </td>
               </tr>
               <tr>
                  <td style="font-weight: 700;">No. Telp/WA</td>
                  <td>:</td>
                  <td><?= _ent($so->no_telepon ?: ($so->telp_pelanggan ?: '-')); ?></td>
               </tr>
               <tr>
                  <td style="font-weight: 700;">Alamat Kirim</td>
                  <td>:</td>
                  <td><?= _ent($so->alamat_pengiriman ?: ($so->alamat_pelanggan ?: '-')); ?></td>
               </tr>
               <tr>
                  <td style="font-weight: 700;">Kota / Wilayah</td>
                  <td>:</td>
                  <td><?= _ent($so->kota_kabupaten ?: ($so->kota_pelanggan ?: '-')); ?></td>
               </tr>
            </table>
         </td>
         <td style="width: 4%;"></td>
         <td class="inv-info-box">
            <div class="inv-info-title">Pengiriman &amp; Syarat Pembayaran:</div>
            <table class="inv-info-content-table">
               <tr>
                  <td style="width: 32%; font-weight: 700;">Lokasi Sumber</td>
                  <td style="width: 4%;">:</td>
                  <td style="font-weight: 700;"><?= 'Pusat / Kasir Utama'; ?></td>
               </tr>
               <tr>
                  <td style="font-weight: 700;">Metode Bayar</td>
                  <td>:</td>
                  <td style="font-weight: 800; color: #047857;"><?= $metode; ?></td>
               </tr>
               <tr>
                  <td style="font-weight: 700;">Kasir / Sales</td>
                  <td>:</td>
                  <td><?= _ent($so->created_by ?: 'Kasir POS'); ?></td>
               </tr>
               <tr>
                  <td style="font-weight: 700;">Status Transaksi</td>
                  <td>:</td>
                  <td>
                     <span style="background: #dcfce7; color: #15803d; border: 1px solid #86efac; padding: 2px 8px; border-radius: 4px; font-weight: 800; font-size: 10.5px;">
                        ✓ LUNAS DIRECT (SELESAI)
                     </span>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </table>

   <!-- TABEL RINCIAN BARANG (FORMAT ENTERPRISE LEBAR) -->
   <div class="inv-table-scroll-wrap">
   <table class="inv-items-table">
      <thead>
         <tr>
            <th style="width: 4%; text-align: center;">No</th>
            <th style="width: 14%; text-align: center;">Kode Barang</th>
            <th style="width: 34%; text-align: left;">Nama Barang &amp; Deskripsi Produk</th>
            <th style="width: 8%; text-align: center;">Jumlah</th>
            <th style="width: 7%; text-align: center;">Satuan</th>
            <th style="width: 13%; text-align: right;">Harga Satuan</th>
            <th style="width: 7%; text-align: center;">Disc (%)</th>
            <th style="width: 13%; text-align: right;">Total Harga</th>
         </tr>
      </thead>
      <tbody>
         <?php $no = 1; foreach ($items as $it): 
               $qty = (float) $it->qty;
               $harga = (float) $it->harga_satuan;
               $disc = (float) ($it->diskon_persen ?? 0);
               $sub = (float) $it->subtotal;
         ?>
         <tr>
            <td style="text-align: center; font-weight: 600;"><?= $no++; ?></td>
            <td style="text-align: center; font-family: monospace; font-size: 11px;"><?= _ent($it->kode_produk ?? '-'); ?></td>
            <td>
               <strong style="color: #0f172a;"><?= _ent($it->nama_produk); ?></strong>
            </td>
            <td style="text-align: center; font-weight: 700;"><?= number_format($qty, 0, ',', '.'); ?></td>
            <td style="text-align: center;"><?= _ent($it->singkatan ?? ($it->satuan ?: 'Pcs')); ?></td>
            <td style="text-align: right;">Rp <?= number_format($harga, 0, ',', '.'); ?></td>
            <td style="text-align: center; color: <?= $disc > 0 ? '#dc2626' : '#64748b'; ?>; font-weight: 600;">
               <?= $disc > 0 ? ($disc . '%') : '-'; ?>
            </td>
            <td style="text-align: right; font-weight: 700; color: #0f172a;">Rp <?= number_format($sub, 0, ',', '.'); ?></td>
         </tr>
         <?php endforeach; ?>
      </tbody>
      <tfoot>
         <tr style="background: #f8fafc; font-weight: bold;">
            <td colspan="3" style="text-align: right; padding-right: 12px;">TOTAL KUANTITAS:</td>
            <td style="text-align: center; font-weight: 800; color: #0284c7;"><?= number_format($total_qty, 0, ',', '.'); ?></td>
            <td colspan="3" style="text-align: right; padding-right: 12px;">SUBTOTAL ITEM:</td>
            <td style="text-align: right; font-weight: 800;">Rp <?= number_format((float)$so->subtotal, 0, ',', '.'); ?></td>
         </tr>
      </tfoot>
   </table>
   </div>

   <!-- BAGIAN BAWAH (TERBILANG, SYARAT PEMBAYARAN & REKAP KEUANGAN) -->
   <table class="inv-bottom-table">
      <tr>
         <td style="width: 56%; vertical-align: top;">
            <div class="inv-terbilang-box">
               <span style="font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase;">Terbilang:</span><br>
               <strong style="font-style: italic; color: #0369a1; font-size: 11.5px;"><?= $terbilang_txt; ?> Rupiah</strong>
            </div>

            <div class="inv-terms-box">
               <strong style="color: #0f172a;">Keterangan &amp; Syarat Ketentuan:</strong>
               <ol style="margin-left: 16px; margin-top: 3px;">
                  <li>Barang yang sudah dibeli telah diperiksa dan diterima dalam keadaan baik &amp; lengkap.</li>
                  <li>Pembayaran resmi transfer bank hanya diakui sah jika ditujukan ke rekening perusahaan:
                     <br>&bull; <b>Bank Mandiri:</b> 137-00-1234567-8 a/n IDMETAFORA STORE
                     <br>&bull; <b>Bank BCA:</b> 869-0123-456 a/n IDMETAFORA STORE
                  </li>
                  <li>Klaim / komplain maksimal 2 x 24 jam setelah barang diterima dengan membawa faktur asli ini.</li>
               </ol>
            </div>
         </td>

         <td style="width: 4%;"></td>

         <td style="width: 40%; vertical-align: top;">
            <table class="inv-totals-box-table">
               <?php if ($item_disc_total > 0): ?>
               <tr>
                  <td>Subtotal Belanja</td>
                  <td style="text-align: right; font-weight: 600;">Rp <?= number_format($gross_item_total, 0, ',', '.'); ?></td>
               </tr>
               <tr>
                  <td style="color: #dc2626;">Diskon Item</td>
                  <td style="text-align: right; color: #dc2626; font-weight: 600;">- Rp <?= number_format($item_disc_total, 0, ',', '.'); ?></td>
               </tr>
               <?php else: ?>
               <tr>
                  <td>Subtotal Penjualan</td>
                  <td style="text-align: right; font-weight: 600;">Rp <?= number_format((float)$so->subtotal, 0, ',', '.'); ?></td>
               </tr>
               <?php endif; ?>
               <?php if ((float)$so->diskon_total > 0): ?>
               <tr>
                  <td style="color: #dc2626;">Diskon Nota (<?= (float)$so->diskon; ?>%)</td>
                  <td style="text-align: right; color: #dc2626; font-weight: 600;">- Rp <?= number_format((float)$so->diskon_total, 0, ',', '.'); ?></td>
               </tr>
               <?php endif; ?>
               <?php if ((float)$so->pajak_nominal > 0): ?>
               <tr>
                  <td>PPN (<?= (float)$so->pajak_persen; ?>%)</td>
                  <td style="text-align: right; font-weight: 600;">+ Rp <?= number_format((float)$so->pajak_nominal, 0, ',', '.'); ?></td>
               </tr>
               <?php endif; ?>
               <tr class="inv-totals-grand">
                  <td>TOTAL TAGIHAN</td>
                  <td style="text-align: right; color: #047857;">Rp <?= number_format($grand_total, 0, ',', '.'); ?></td>
               </tr>
               <tr>
                  <td>Metode Bayar</td>
                  <td style="text-align: right; font-weight: 700;"><?= $metode; ?></td>
               </tr>
               <tr>
                  <td>Bayar / Diterima</td>
                  <td style="text-align: right; font-weight: 700;">Rp <?= number_format($bayar, 0, ',', '.'); ?></td>
               </tr>
               <tr>
                  <td>Kembalian</td>
                  <td style="text-align: right; font-weight: 700; color: #047857;">Rp <?= number_format($kembalian, 0, ',', '.'); ?></td>
               </tr>
            </table>
         </td>
      </tr>
   </table>

   <!-- 4 KOLOM TANDA TANGAN RESMI PERUSAHAAN -->
   <table class="inv-signatures-table">
      <tr>
         <td>
            <div>Tanda Terima / Pelanggan,</div>
            <div class="inv-sig-space"></div>
            <div class="inv-sig-name">( <?= _ent($so->nama_pelanggan ?: ($so->nama_penerima ?: '.......................')); ?> )</div>
         </td>
         <td>
            <div>Pengemudi / Ekspedisi,</div>
            <div class="inv-sig-space"></div>
            <div class="inv-sig-name">( ....................... )</div>
         </td>
         <td>
            <div>Bagian Logistik,</div>
            <div class="inv-sig-space"></div>
            <div class="inv-sig-name">( ....................... )</div>
         </td>
         <td>
            <div>Hormat Kami / Kasir,</div>
            <div class="inv-sig-space"></div>
            <div class="inv-sig-name">( <?= _ent($so->created_by ?: 'Kasir POS'); ?> )</div>
         </td>
      </tr>
   </table>

   <div class="inv-rangkap-note">
      * Lembar 1: Putih (Asli Pelanggan) &nbsp;|&nbsp; Lembar 2: Merah (Keuangan / Akuntansi) &nbsp;|&nbsp; Lembar 3: Kuning (Logistik / Ekspedisi)
   </div>

</div>

<!-- JAVASCRIPT LOGIC & BLUETOOTH DRIVER -->
<script src="<?= base_url('asset/js/thermal-bluetooth-printer.js'); ?>"></script>
<script>
   const receiptData = {
      nomor_so: <?= json_encode($so->nomor_so ?? 'SO'); ?>,
      nomor_inv: <?= json_encode($inv->nomor_invoice ?? ''); ?>,
      nomor_bkm: <?= json_encode($bkm->nomor_bkm ?? ''); ?>,
      nomor_ref: <?= json_encode($so->nomor_referensi ?? ''); ?>,
      tanggal: <?= json_encode(date('d/m/Y H:i', strtotime($so->tanggal_so ?? 'now'))); ?>,
      kasir: <?= json_encode(get_user_data('username') ?: 'Kasir POS'); ?>,
      pelanggan: <?= json_encode($so->nama_pelanggan ?: ($so->customer_nama ?: 'Umum')); ?>,
      telepon: <?= json_encode($so->no_telepon ?: ''); ?>,
      alamat: <?= json_encode($so->alamat_pengiriman ?: ''); ?>,
      metode_pembayaran: <?= json_encode($metode); ?>,
      subtotal: <?= (float)($so->subtotal ?? 0); ?>,
      diskon_total: <?= (float)($so->diskon_total ?? 0); ?>,
      pajak_nominal: <?= (float)($so->pajak_nominal ?? 0); ?>,
      total: <?= (float)($so->total ?? 0); ?>,
      uang_diterima: <?= (float)$bayar; ?>,
      kembalian: <?= (float)$kembalian; ?>,
      items: [
         <?php foreach($items as $it): ?>
         {
            nama_produk: <?= json_encode($it->nama_produk ?? ''); ?>,
            qty: <?= (float)($it->qty ?? 1); ?>,
            satuan: <?= json_encode($it->singkatan ?? ($it->satuan ?: 'pcs')); ?>,
            harga_satuan: <?= (float)($it->harga_satuan ?? 0); ?>,
            diskon_persen: <?= (float)($it->diskon_persen ?? 0); ?>,
            subtotal: <?= (float)($it->subtotal ?? 0); ?>
         },
         <?php endforeach; ?>
      ]
   };

   var currentActiveTemplate = '<?= $current_tpl; ?>';

   function setTemplate(tpl) {
      currentActiveTemplate = tpl;
      document.body.className = 'print-mode-' + tpl;

      var styleEl = document.getElementById('dynamic_page_style');
      if (!styleEl) {
         styleEl = document.createElement('style');
         styleEl.id = 'dynamic_page_style';
         document.head.appendChild(styleEl);
      }
      if (tpl === 'lebar') {
         styleEl.textContent = '@page { size: A4 landscape; margin: 8mm 10mm; }';
      } else {
         styleEl.textContent = '@page { size: 58mm auto; margin: 0mm; }';
      }

      var btnThermal = document.getElementById('tab_btn_thermal');
      var btnLebar   = document.getElementById('tab_btn_lebar');
      var elThermal  = document.getElementById('receipt_content');
      var elLebar    = document.getElementById('invoice_lebar_content');

      var btnPrintBt      = document.getElementById('btn_print_bluetooth');
      var btnPrintThermal = document.getElementById('btn_print_thermal');
      var btnPrintLebar   = document.getElementById('btn_print_lebar');
      var btStatusBar     = document.getElementById('bt_status_bar');

      if (tpl === 'lebar') {
         btnThermal.classList.remove('active');
         btnLebar.classList.add('active');
         elThermal.style.display = 'none';
         elLebar.style.display = 'block';

         if (btnPrintBt) btnPrintBt.style.display = 'none';
         if (btnPrintThermal) btnPrintThermal.style.display = 'none';
         if (btnPrintLebar) btnPrintLebar.style.display = 'inline-flex';
         if (btStatusBar) btStatusBar.style.display = 'none';
         document.title = "Faktur Lebar - <?= _ent($inv->nomor_invoice ?? ($so->nomor_so ?? 'Nota')); ?>";
      } else {
         btnLebar.classList.remove('active');
         btnThermal.classList.add('active');
         elLebar.style.display = 'none';
         elThermal.style.display = 'block';

         if (btnPrintBt) btnPrintBt.style.display = 'inline-flex';
         if (btnPrintThermal) btnPrintThermal.style.display = 'inline-flex';
         if (btnPrintLebar) btnPrintLebar.style.display = 'none';
         if (btStatusBar) btStatusBar.style.display = 'flex';
         document.title = "Struk POS - <?= _ent($so->nomor_so ?? 'Nota'); ?>";
      }

      // Update URL query string tanpa reload halaman
      if (window.history && window.history.replaceState) {
         var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?template=' + tpl;
         window.history.replaceState({path: newUrl}, '', newUrl);
      }
   }

   function doPrint() {
      window.print();
   }

   function closeOrReturn() {
      if (window.opener && !window.opener.closed) {
         window.close();
      } else if (document.referrer && document.referrer.indexOf(window.location.host) !== -1) {
         window.location.href = document.referrer;
      } else {
         window.location.href = '<?= site_url('administrator/sales_order/cepat'); ?>';
      }
   }

   function handleInsecureBluetoothStruk() {
      var portPart = (window.location.port && window.location.port !== '80' && window.location.port !== '443') ? (':' + window.location.port) : '';
      var targetUrl = 'https://' + window.location.hostname + portPart + window.location.pathname + window.location.search;
      if (confirm("Fitur Web Bluetooth mewajibkan URL Aman (HTTPS berlogo gembok) sesuai standar Google Chrome / Edge / Opera.\n\nKlik OK untuk berpindah ke HTTPS agar Bluetooth langsung aktif,\natau Cancel untuk menggunakan tombol CETAK biasa.")) {
         window.location.href = targetUrl;
      } else {
         doPrint();
      }
   }

   function updateBluetoothStatus() {
      var statusBar = document.getElementById('bt_status_bar');
      var label = document.getElementById('bt_device_label');
      var btnConnect = document.getElementById('btn_connect_bt');
      var btnPrint = document.getElementById('btn_print_bluetooth');

      var isSecure = Boolean(window.isSecureContext);
      if (!isSecure) {
         if (statusBar) {
            statusBar.style.background = '#fffbeb';
            statusBar.style.borderColor = '#fde68a';
            statusBar.style.color = '#b45309';
         }
         if (label) label.textContent = 'Bluetooth butuh URL Aman (HTTPS)';
         if (btnConnect) {
            btnConnect.textContent = 'Buka via HTTPS';
            btnConnect.style.background = '#0284c7';
            btnConnect.style.display = 'inline-block';
         }
         if (btnPrint) {
            btnPrint.disabled = false;
            btnPrint.style.opacity = '1';
            btnPrint.title = 'Klik untuk membuka via HTTPS agar Bluetooth aktif';
         }
         return;
      }

      if (!window.ThermalPrinter || !window.ThermalPrinter.isSupported()) {
         if (statusBar) {
            statusBar.style.background = '#fef2f2';
            statusBar.style.borderColor = '#fca5a5';
            statusBar.style.color = '#b91c1c';
         }
         if (label) label.textContent = 'Web Bluetooth tidak didukung browser ini (Gunakan Chrome/Edge)';
         if (btnConnect) btnConnect.style.display = 'none';
         if (btnPrint) {
            btnPrint.disabled = true;
            btnPrint.style.opacity = '0.5';
            btnPrint.title = 'Web Bluetooth hanya didukung di Google Chrome / Edge';
         }
         return;
      }

      if (window.ThermalPrinter.isConnected()) {
         if (statusBar) {
            statusBar.style.background = '#f0fdf4';
            statusBar.style.borderColor = '#86efac';
            statusBar.style.color = '#15803d';
         }
         if (label) label.textContent = 'Terhubung: ' + window.ThermalPrinter.getDeviceName();
         if (btnConnect) btnConnect.textContent = 'Ganti Printer';
         if (btnPrint) {
            btnPrint.disabled = false;
            btnPrint.style.opacity = '1';
            btnPrint.innerHTML = '📶 CETAK BLUETOOTH (' + window.ThermalPrinter.getDeviceName() + ')';
         }
      } else {
         if (statusBar) {
            statusBar.style.background = '#f0f9ff';
            statusBar.style.borderColor = '#bae6fd';
            statusBar.style.color = '#0369a1';
         }
         if (label) label.textContent = 'Bluetooth: Belum Terhubung (Klik Hubungkan / Cetak Bluetooth)';
         if (btnConnect) {
            btnConnect.textContent = 'Hubungkan / Cari Printer';
            btnConnect.style.display = 'inline-block';
         }
         if (btnPrint) {
            btnPrint.disabled = false;
            btnPrint.style.opacity = '1';
            btnPrint.innerHTML = '📶 CETAK BLUETOOTH';
         }
      }
   }

   window.onload = function() {
      if (window.ThermalPrinter) {
         window.ThermalPrinter.onStateChange(updateBluetoothStatus);
         updateBluetoothStatus();
      }

      var urlParams = new URLSearchParams(window.location.search);
      if (urlParams.get('template') === 'lebar') {
         setTemplate('lebar');
      }

      // Auto print jika dipanggil dengan parameter autoprint=1
      if (urlParams.get('autoprint') === '1') {
         setTimeout(function(){ window.print(); }, 400);
      }
   };

   document.getElementById('btn_connect_bt').addEventListener('click', async function() {
      if (!window.isSecureContext) {
         handleInsecureBluetoothStruk();
         return;
      }
      var btn = this;
      try {
         btn.disabled = true;
         btn.textContent = 'Mencari Printer...';
         await window.ThermalPrinter.pair();
         updateBluetoothStatus();
      } catch(err) {
         if (err.name !== 'NotFoundError' && !(err.message && err.message.indexOf('User cancelled') !== -1)) {
            alert('Gagal menghubungkan Bluetooth printer: ' + (err.message || err));
         }
         updateBluetoothStatus();
      } finally {
         btn.disabled = false;
      }
   });

   document.getElementById('btn_print_bluetooth').addEventListener('click', async function() {
      if (!window.isSecureContext) {
         handleInsecureBluetoothStruk();
         return;
      }
      var btn = this;
      var origText = btn.innerHTML;
      try {
         btn.disabled = true;

         // Langsung panggil pairAndPrint() - jika belum connect, browser dialog pairing langsung muncul tanpa delay
         if (!window.ThermalPrinter.isConnected()) {
            btn.innerHTML = '📶 Memilih Printer Bluetooth...';
         } else {
            btn.innerHTML = '📶 Mengirim ke Printer...';
         }

         await window.ThermalPrinter.pairAndPrint(receiptData, function(percent) {
            btn.innerHTML = '📶 Mencetak ' + percent + '%...';
         });

         btn.innerHTML = '✓ Selesai Dicetak!';
         setTimeout(function(){
            btn.innerHTML = origText;
            btn.disabled = false;
         }, 2500);
      } catch(err) {
         console.warn('Bluetooth print error:', err);
         if (err.name !== 'NotFoundError' && !(err.message && err.message.indexOf('User cancelled') !== -1)) {
            alert('Gagal cetak via Bluetooth: ' + (err.message || err));
         }
         btn.innerHTML = origText;
         btn.disabled = false;
      } finally {
         updateBluetoothStatus();
      }
   });
</script>
</body>
</html>
