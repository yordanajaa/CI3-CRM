<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <title>LAPORAN STOK BARANG (<?= date('d/m/Y'); ?>)</title>
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">
   <style>
      body {
         font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
         font-size: 12px;
         color: #1e293b;
         margin: 20px;
         background: #fff;
      }
      .no-print {
         margin-bottom: 20px;
         display: flex;
         justify-content: flex-end;
         gap: 10px;
      }
      .btn-print {
         padding: 8px 20px;
         background: #2563eb;
         color: #fff;
         border: none;
         border-radius: 5px;
         cursor: pointer;
         font-weight: 700;
         font-size: 13px;
         text-decoration: none;
      }
      .btn-close {
         padding: 8px 18px;
         background: #64748b;
         color: #fff;
         border: none;
         border-radius: 5px;
         cursor: pointer;
         font-weight: 600;
         font-size: 13px;
      }
      .header-bar {
         display: flex;
         justify-content: space-between;
         align-items: flex-start;
         border-bottom: 2.5px solid #0f172a;
         padding-bottom: 12px;
         margin-bottom: 16px;
      }
      .company-title {
         font-size: 20px;
         font-weight: 800;
         color: #0f172a;
         letter-spacing: -0.5px;
      }
      .company-sub {
         font-size: 11px;
         color: #475569;
         margin-top: 3px;
         line-height: 1.4;
      }
      .doc-info {
         text-align: right;
      }
      .doc-title {
         font-size: 20px;
         font-weight: 800;
         color: #0284c7;
         text-transform: uppercase;
         letter-spacing: 0.5px;
      }
      .doc-meta {
         font-size: 11.5px;
         color: #334155;
         margin-top: 4px;
      }
      .summary-cards {
         display: flex;
         gap: 12px;
         margin-bottom: 16px;
      }
      .summary-card {
         flex: 1;
         border: 1px solid #cbd5e1;
         border-radius: 6px;
         padding: 8px 12px;
         background: #f8fafc;
      }
      .summary-card-title {
         font-size: 10px;
         text-transform: uppercase;
         color: #64748b;
         font-weight: 700;
      }
      .summary-card-val {
         font-size: 16px;
         font-weight: 800;
         color: #0f172a;
         margin-top: 2px;
      }
      .data-table {
         width: 100%;
         border-collapse: collapse;
         margin-bottom: 25px;
      }
      .data-table th, .data-table td {
         border: 1px solid #cbd5e1;
         padding: 6px 8px;
         font-size: 11px;
      }
      .data-table th {
         background: #f1f5f9;
         color: #0f172a;
         font-weight: 700;
         text-transform: uppercase;
         font-size: 10px;
      }
      .text-center { text-align: center; }
      .text-right { text-align: right; }
      .badge-habis { color: #dc2626; font-weight: 700; }
      .badge-menipis { color: #d97706; font-weight: 700; }
      .badge-aman { color: #16a34a; font-weight: 700; }
      .signatures {
         margin-top: 40px;
         display: flex;
         justify-content: space-between;
         text-align: center;
         page-break-inside: avoid;
      }
      .sign-col { width: 28%; }
      .sign-space { height: 60px; }
      .sign-line {
         border-top: 1px solid #0f172a;
         font-weight: 700;
         padding-top: 4px;
         font-size: 11.5px;
      }
      @media print {
         .no-print { display: none !important; }
         body { margin: 10mm 15mm; }
         .data-table th { background: #f1f5f9 !important; -webkit-print-color-adjust: exact; }
         .summary-card { -webkit-print-color-adjust: exact; }
      }
   </style>
</head>
<body>

<div class="no-print">
   <button onclick="window.print()" class="btn-print">
      Cetak / Simpan PDF
   </button>
   <button onclick="window.close()" class="btn-close">
      Tutup
   </button>
</div>

<!-- Header Kop Surat -->
<div class="header-bar">
   <div>
      <div class="company-title">IDMETAFORA &bull; SISTEM MANAJEMEN INVENTORY</div>
      <div class="company-sub">
         Distribusi Logistik &amp; Penjualan Retail Multi-Outlet<br>
         Jl. Waras No. 179, Sleman, D.I. Yogyakarta | Telp: (0274) 123456 | Email: info@idmetafora.com
      </div>
   </div>
   <div class="doc-info">
      <div class="doc-title">Laporan Posisi Stok Fisik</div>
      <table align="right" style="border-collapse: collapse; font-size: 11.5px; margin-top: 4px; color: #475569;">
         <tr>
            <td style="text-align: right; padding: 1px 0;"><strong>Tanggal Cetak</strong></td>
            <td style="width: 10px; text-align: center; padding: 1px 0;">:</td>
            <td style="text-align: left; padding: 1px 0;"><?= date('d/m/Y H:i'); ?> WIB</td>
         </tr>
         <tr>
            <td style="text-align: right; padding: 1px 0;"><strong>Dicetak Oleh</strong></td>
            <td style="text-align: center; padding: 1px 0;">:</td>
            <td style="text-align: left; padding: 1px 0;"><?= _ent(get_user_data('full_name') ?: get_user_data('username') ?: 'Administrator'); ?></td>
         </tr>
      </table>
   </div>
</div>

<!-- Summary Box -->
<div class="summary-cards">
   <div class="summary-card">
      <div class="summary-card-title">Total Jenis Produk</div>
      <div class="summary-card-val"><?= is_object($summary) ? $summary->total_produk : 0; ?> Item</div>
   </div>
   <div class="summary-card">
      <div class="summary-card-title">Total Keseluruhan Fisik</div>
      <div class="summary-card-val"><?= number_format(is_object($summary) ? $summary->total_stok : 0, 0, ',', '.'); ?> Unit</div>
   </div>
   <div class="summary-card">
      <div class="summary-card-title">Stok Menipis / Kritis</div>
      <div class="summary-card-val" style="color:#d97706;"><?= is_object($summary) ? $summary->stok_menipis : 0; ?> Item</div>
   </div>
   <div class="summary-card">
      <div class="summary-card-title">Stok Habis (Kosong)</div>
      <div class="summary-card-val" style="color:#dc2626;"><?= is_object($summary) ? $summary->stok_habis : 0; ?> Item</div>
   </div>
   <div class="summary-card" style="background:#eff6ff; border-color:#93c5fd;">
      <div class="summary-card-title" style="color:#1d4ed8;">Estimasi Total Nilai Stok</div>
      <div class="summary-card-val" style="color:#1e40af;">Rp <?= number_format(is_object($summary) ? $summary->total_nilai : 0, 0, ',', '.'); ?></div>
   </div>
</div>

<!-- Tabel Data Stok -->
<table class="data-table">
   <thead>
      <tr>
         <th width="30" class="text-center">No</th>
         <th width="85">Kode SKU</th>
         <th>Nama Produk Barang</th>
         <th width="100">Kategori</th>
         <th width="50" class="text-center">Sat</th>
         <th width="65" class="text-right">Min Stok</th>
         <th width="65" class="text-right">Stok Rusak</th>
         <th width="75" class="text-right">Stok Baik</th>
         <th width="90" class="text-right">Harga Beli</th>
         <th width="105" class="text-right">Subtotal Nilai</th>
         <th width="70" class="text-center">Status</th>
      </tr>
   </thead>
   <tbody>
      <?php if (!empty($stoks)): ?>
         <?php 
            $no = 1; 
            $grand_qty = 0; 
            $grand_rusak = 0;
            $grand_nilai = 0;
            foreach ($stoks as $s): 
               $qty = (float)$s->qty;
               $qty_rusak = (float)$s->qty_rusak;
               $min = (float)$s->stok_minimum;
               $hb = (float)$s->harga_beli;
               $sub_nilai = $qty * $hb;
               $grand_qty += $qty;
               $grand_rusak += $qty_rusak;
               $grand_nilai += $sub_nilai;

               $status_class = 'badge-aman';
               $status_label = 'Aman';
               if ($qty == 0) {
                  $status_class = 'badge-habis';
                  $status_label = 'Habis (0)';
               } elseif ($qty <= $min) {
                  $status_class = 'badge-menipis';
                  $status_label = 'Menipis';
               }
         ?>
            <tr>
               <td class="text-center"><?= $no++; ?></td>
               <td><strong><?= _ent($s->kode_produk); ?></strong></td>
               <td><?= _ent($s->nama_produk); ?></td>
               <td><?= _ent($s->nama_kategori ?? '-'); ?></td>
               <td class="text-center"><?= _ent(!empty($s->singkatan) ? $s->singkatan : 'Pcs'); ?></td>
               <td class="text-right"><?= number_format($min, 0, ',', '.'); ?></td>
               <td class="text-right" style="color: <?= $qty_rusak > 0 ? '#dc2626' : '#64748b'; ?>;">
                  <?= number_format($qty_rusak, 0, ',', '.'); ?>
               </td>
               <td class="text-right" style="font-weight: 700; color: #0f172a;">
                  <?= number_format($qty, 0, ',', '.'); ?>
               </td>
               <td class="text-right">Rp <?= number_format($hb, 0, ',', '.'); ?></td>
               <td class="text-right" style="font-weight: 700;">Rp <?= number_format($sub_nilai, 0, ',', '.'); ?></td>
               <td class="text-center <?= $status_class; ?>"><?= $status_label; ?></td>
            </tr>
         <?php endforeach; ?>
         <tr style="background: #f8fafc; font-weight: 800;">
            <td colspan="6" class="text-right">TOTAL KESELURUHAN:</td>
            <td class="text-right" style="color: #dc2626;"><?= number_format($grand_rusak, 0, ',', '.'); ?></td>
            <td class="text-right"><?= number_format($grand_qty, 0, ',', '.'); ?></td>
            <td class="text-right">-</td>
            <td class="text-right">Rp <?= number_format($grand_nilai, 0, ',', '.'); ?></td>
            <td></td>
         </tr>
      <?php else: ?>
         <tr>
            <td colspan="11" class="text-center" style="padding: 20px; color: #64748b;">
               Tidak ada data stok barang yang sesuai kriteria filter.
            </td>
         </tr>
      <?php endif; ?>
   </tbody>
</table>

<!-- Bagian Tanda Tangan Resmi -->
<div class="signatures">
   <div class="sign-col">
      <div>Dibuat Oleh,</div>
      <div class="sign-space"></div>
      <div class="sign-line"><?= _ent(get_user_data('full_name') ?: get_user_data('username') ?: 'Staff Logistik'); ?></div>
      <small style="color:#64748b;">Staff Inventory / Logistik</small>
   </div>
   <div class="sign-col">
      <div>Diperiksa Oleh,</div>
      <div class="sign-space"></div>
      <div class="sign-line">........................................</div>
      <small style="color:#64748b;">Supervisor / Auditor Stok</small>
   </div>
   <div class="sign-col">
      <div>Mengetahui &amp; Menyetujui,</div>
      <div class="sign-space"></div>
      <div class="sign-line">........................................</div>
      <small style="color:#64748b;">Manajer Operasional / Finance</small>
   </div>
</div>

</body>
</html>
