<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>BUKTI KAS MASUK (BKM) - <?= _ent($bkm->nomor_bkm ?? ''); ?></title>
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">
   <link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= BASE_ASSET; ?>font-awesome/css/font-awesome.min.css">
   <style>
      body {
         font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
         font-size: 13px;
         color: #1e293b;
         background: #f8fafc;
         margin: 0;
         padding: 20px;
      }
      .print-container {
         max-width: 800px;
         margin: 0 auto;
         background: #fff;
         padding: 35px 40px;
         border-radius: 8px;
         box-shadow: 0 4px 15px rgba(0,0,0,0.06);
         border: 1px solid #e2e8f0;
      }
      .no-print-bar {
         max-width: 800px;
         margin: 0 auto 20px auto;
         display: flex;
         justify-content: space-between;
         align-items: center;
         flex-wrap: wrap;
         gap: 10px;
      }
      .header-bar {
         display: flex;
         justify-content: space-between;
         align-items: flex-start;
         border-bottom: 3px double #cbd5e1;
         padding-bottom: 18px;
         margin-bottom: 22px;
      }
      .company-title {
         font-size: 20px;
         font-weight: 800;
         color: #0f172a;
         letter-spacing: -0.5px;
      }
      .company-sub {
         font-size: 12px;
         color: #64748b;
         margin-top: 2px;
      }
      .doc-badge {
         text-align: right;
      }
      .doc-title {
         font-size: 20px;
         font-weight: 800;
         color: #059669;
         letter-spacing: 0.5px;
      }
      .doc-num {
         font-size: 14px;
         font-weight: 700;
         color: #334155;
      }
      .info-grid {
         display: flex;
         justify-content: space-between;
         gap: 20px;
         margin-bottom: 25px;
         background: #f8fafc;
         border: 1px solid #e2e8f0;
         border-radius: 8px;
         padding: 15px 20px;
      }
      .info-col {
         flex: 1;
      }
      .info-table td {
         padding: 3px 6px;
         vertical-align: top;
         font-size: 12.5px;
      }
      .data-table {
         width: 100%;
         border-collapse: collapse;
         margin-bottom: 20px;
      }
      .data-table th, .data-table td {
         border: 1px solid #cbd5e1;
         padding: 10px 14px;
      }
      .data-table th {
         background: #f1f5f9;
         font-weight: 700;
         color: #334155;
         text-transform: uppercase;
         font-size: 11.5px;
         letter-spacing: 0.5px;
      }
      .terbilang-box {
         background: #ecfdf5;
         border: 1px solid #a7f3d0;
         padding: 12px 18px;
         border-radius: 6px;
         font-size: 12.5px;
         color: #065f46;
         margin-bottom: 35px;
      }
      .signatures {
         display: flex;
         justify-content: space-between;
         text-align: center;
         margin-top: 30px;
      }
      .sign-col {
         width: 30%;
      }
      .sign-space {
         height: 70px;
      }
      .sign-line {
         border-top: 1px solid #475569;
         padding-top: 6px;
         font-weight: 700;
         font-size: 12.5px;
         color: #1e293b;
      }
      @media print {
         body {
            background: #fff;
            padding: 0;
         }
         .no-print, .no-print-bar {
            display: none !important;
         }
         .print-container {
            box-shadow: none;
            border: none;
            padding: 10px;
            max-width: 100%;
         }
      }
   </style>
</head>
<body>

<div class="no-print-bar">
   <div>
      <a href="<?= site_url('administrator/piutang_usaha/kas_masuk'); ?>" class="btn btn-default btn-sm" style="border-radius:6px; font-weight:600;">
         <i class="fa fa-arrow-left"></i> Kembali ke Daftar Kas Masuk
      </a>
   </div>
   <div style="display:flex; gap:8px;">
      <button onclick="window.print()" class="btn btn-success btn-sm" style="background:#059669; border-color:#047857; font-weight:700; border-radius:6px; padding:6px 16px;">
         <i class="fa fa-print"></i> Cetak Sekarang (Print)
      </button>
      <a href="<?= site_url('administrator/piutang_usaha/cetak_bkm/' . $bkm->id . '?mode=pdf'); ?>" target="_blank" class="btn btn-primary btn-sm" style="font-weight:600; border-radius:6px;">
         <i class="fa fa-file-pdf-o"></i> Unduh PDF
      </a>
      <button onclick="window.close()" class="btn btn-default btn-sm" style="border-radius:6px;">
         <i class="fa fa-times"></i> Tutup
      </button>
   </div>
</div>

<div class="print-container">
   <!-- Header Bar -->
   <div class="header-bar">
      <div>
         <div class="company-title">IDMETAFORA / CI3 METAFORA</div>
         <div class="company-sub">Sistem Manajemen Bisnis, Distribusi &amp; Penjualan</div>
         <div class="company-sub"><i class="fa fa-phone"></i> Telp: (0274) 123456 &bull; <i class="fa fa-envelope"></i> Email: finance@idmetafora.com</div>
      </div>
      <div class="doc-badge">
         <div class="doc-title">BUKTI KAS MASUK (BKM)</div>
         <div class="doc-num"><?= _ent($bkm->nomor_bkm ?? '-'); ?></div>
         <div style="font-size:12px; color:#64748b; margin-top:3px;">
            <i class="fa fa-calendar"></i> Tanggal: <?= date('d F Y', strtotime($bkm->tanggal_bayar)); ?>
         </div>
      </div>
   </div>

   <!-- Info Grid -->
   <div class="info-grid">
      <div class="info-col">
         <span style="font-size:11px; text-transform:uppercase; font-weight:700; color:#64748b; display:block; margin-bottom:4px;">Diterima Dari (Pelanggan):</span>
         <table class="info-table" style="width:100%;">
            <tr>
               <td width="30%"><strong>Nama</strong></td>
               <td width="5%" style="text-align:center;">:</td>
               <td><strong style="color:#059669; font-size:13.5px;"><?= _ent($bkm->nama_pelanggan ?? 'Umum'); ?></strong></td>
            </tr>
            <tr>
               <td><strong>Kode</strong></td>
               <td style="text-align:center;">:</td>
               <td><?= _ent($bkm->kode_pelanggan ?? '-'); ?></td>
            </tr>
            <tr>
               <td><strong>No. Telp / HP</strong></td>
               <td style="text-align:center;">:</td>
               <td><?= _ent($bkm->no_telp ?: ($bkm->telepon ?: '-')); ?></td>
            </tr>
            <tr>
               <td><strong>Alamat</strong></td>
               <td style="text-align:center;">:</td>
               <td><?= _ent($bkm->alamat ?? '-'); ?></td>
            </tr>
         </table>
      </div>
      <div class="info-col" style="border-left:1px solid #e2e8f0; padding-left:20px;">
         <span style="font-size:11px; text-transform:uppercase; font-weight:700; color:#64748b; display:block; margin-bottom:4px;">Rincian Pembayaran Kas:</span>
         <table class="info-table" style="width:100%;">
            <tr>
               <td width="42%"><strong>Akun Kas / Bank</strong></td>
               <td width="5%" style="text-align:center;">:</td>
               <td><strong style="color:#1d4ed8;"><?= _ent($bkm->akun_kas_bank); ?></strong></td>
            </tr>
            <tr>
               <td><strong>Metode Bayar</strong></td>
               <td style="text-align:center;">:</td>
               <td><span class="badge" style="background:#0284c7;"><?= strtoupper(str_replace('_', ' ', $bkm->metode_pembayaran)); ?></span></td>
            </tr>
            <tr>
               <td><strong>No. Ref Bank</strong></td>
               <td style="text-align:center;">:</td>
               <td><?= _ent($bkm->nomor_referensi ?: '-'); ?></td>
            </tr>
            <tr>
               <td><strong>Ref Tagihan (AR)</strong></td>
               <td style="text-align:center;">:</td>
               <td><strong><?= _ent($bkm->nomor_piutang ?: '-'); ?></strong></td>
            </tr>
         </table>
      </div>
   </div>

   <!-- Detail Table -->
   <table class="data-table">
      <thead>
         <tr>
            <th width="40" class="text-center">No</th>
            <th>Keterangan / Deskripsi Transaksi Penerimaan</th>
            <th width="150" class="text-center">No. Referensi</th>
            <th width="180" class="text-right">Nominal Diterima</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td class="text-center" style="vertical-align:top;">1</td>
            <td>
               <strong style="color:#0f172a; font-size:13.5px;">Penerimaan Pembayaran Piutang Penjualan</strong>
               <?php if (!empty($bkm->nomor_piutang)): ?>
                  <br><span style="color:#475569; font-size:12px;">Tagihan Piutang: <strong><?= _ent($bkm->nomor_piutang); ?></strong></span>
               <?php endif; ?>
               <?php if (!empty($bkm->catatan)): ?>
                  <br><span style="color:#64748b; font-size:12px; font-style:italic;"><i class="fa fa-info-circle"></i> Catatan: <?= _ent($bkm->catatan); ?></span>
               <?php endif; ?>
            </td>
            <td class="text-center" style="vertical-align:top;">
               <?= _ent($bkm->nomor_referensi ?: '-'); ?>
            </td>
            <td class="text-right" style="vertical-align:top;">
               <strong style="font-size:14.5px; color:#059669;">Rp <?= number_format($bkm->nominal, 0, ',', '.'); ?></strong>
            </td>
         </tr>
      </tbody>
      <tfoot>
         <tr style="background:#f8fafc; font-weight:700;">
            <td colspan="3" class="text-right" style="padding:12px 14px; font-size:13px; text-transform:uppercase;">
               Total Penerimaan Kas (BKM):
            </td>
            <td class="text-right" style="padding:12px 14px; font-size:16px; color:#059669;">
               Rp <?= number_format($bkm->nominal, 0, ',', '.'); ?>
            </td>
         </tr>
      </tfoot>
   </table>

   <!-- Terbilang Box -->
   <div class="terbilang-box">
      <strong>Terbilang:</strong> <em><?= ucwords(trim(preg_replace('/\s+/', ' ', terbilang($bkm->nominal)))); ?> Rupiah</em>
   </div>

   <!-- Signatures -->
   <div class="signatures">
      <div class="sign-col">
         <div style="font-size:12px; color:#64748b; margin-bottom:6px;">Diterima Oleh (Kasir)</div>
         <div class="sign-space"></div>
         <div class="sign-line">( <?= _ent($bkm->created_by ?: 'Petugas Kasir'); ?> )</div>
      </div>
      <div class="sign-col">
         <div style="font-size:12px; color:#64748b; margin-bottom:6px;">Disetujui Oleh (Keuangan)</div>
         <div class="sign-space"></div>
         <div class="sign-line">( Manajer Keuangan )</div>
      </div>
      <div class="sign-col">
         <div style="font-size:12px; color:#64748b; margin-bottom:6px;">Pembayar / Pelanggan</div>
         <div class="sign-space"></div>
         <div class="sign-line">( <?= _ent($bkm->nama_pelanggan ?: 'Pelanggan'); ?> )</div>
      </div>
   </div>
</div>

<script>
   // Auto trigger print dialog on page load, can be closed cleanly
   window.addEventListener('load', function() {
      // Short delay to ensure stylesheet rendering
      setTimeout(function() {
         window.print();
      }, 500);
   });
</script>

</body>
</html>
