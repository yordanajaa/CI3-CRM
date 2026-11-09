<?php /* pelanggan_list.php - Sleek High-End UI with Mobile-First Card View */ ?>
<style>
@keyframes pelangganFadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}
.box-primary {
  border-radius: 12px !important;
  box-shadow: 0 4px 18px rgba(0,0,0,0.04) !important;
  animation: pelangganFadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.table-responsive {
  -webkit-overflow-scrolling: touch;
  min-height: 250px;
}

/* Visibility toggles for Desktop Table vs Mobile Cards */
.pelanggan-desktop-table {
  display: block;
}
.pelanggan-mobile-cards {
  display: none;
}

@media (max-width: 767px) {
  .box-header {
    padding: 12px 14px !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 10px !important;
  }
  .box-header .box-title {
    font-size: 15px !important;
  }
  .box-header .box-tools {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 8px !important;
    width: 100% !important;
    position: static !important;
    float: none !important;
  }
  .box-header .box-tools a[href*="pelanggan/add"] {
    grid-column: span 2 !important;
    width: 100% !important;
    padding: 10px 12px !important;
    text-align: center !important;
    font-size: 13px !important;
  }
  .box-header .box-tools .btn {
    text-align: center !important;
    justify-content: center !important;
    font-size: 11.5px !important;
    padding: 8px !important;
  }
  #form_pelanggan .row > div {
    margin-bottom: 8px !important;
  }

  /* Switch view to Mobile Cards on mobile screens */
  .pelanggan-desktop-table {
    display: none !important;
  }
  .pelanggan-mobile-cards {
    display: block !important;
  }

  /* Modern Mobile Card Styles */
  .pelanggan-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    margin-bottom: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    overflow: visible;
    position: relative;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .pelanggan-card:hover {
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
  }
  .pelanggan-card-header {
    padding: 12px 14px 10px 14px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
  }
  .pelanggan-card-title-group {
    flex: 1;
  }
  .pelanggan-code-badge {
    font-size: 10.5px;
    padding: 2px 6px;
    border-radius: 4px;
    background: #e2e8f0;
    color: #475569;
    font-weight: 600;
    display: inline-block;
  }
  .pelanggan-card-title {
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    margin: 4px 0 0 0;
    line-height: 1.35;
  }
  .pelanggan-card-body {
    padding: 12px 14px;
  }
  .pelanggan-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px 12px;
  }
  .pelanggan-info-item {
    display: flex;
    flex-direction: column;
    gap: 3px;
  }
  .pelanggan-info-item.full-width {
    grid-column: span 2;
  }
  .info-label {
    font-size: 10.5px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.3px;
  }
  .info-value {
    font-size: 12.5px;
    color: #1e293b;
  }
  .pelanggan-card-footer {
    padding: 10px 14px;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
    border-radius: 0 0 10px 10px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .btn-mobile-detail {
    flex: 1;
    font-weight: 600;
    font-size: 12px;
    padding: 7px 12px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: #0284c7;
    border-color: #0284c7;
    color: #ffffff;
  }
  .btn-mobile-detail:hover, .btn-mobile-detail:focus, .btn-mobile-detail:active {
    background: #0369a1;
    border-color: #0369a1;
    color: #ffffff;
  }
  .btn-mobile-wa {
    font-weight: 600;
    font-size: 12px;
    padding: 7px 10px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    background: #10b981;
    border-color: #10b981;
    color: #ffffff;
  }
  .btn-mobile-wa:hover, .btn-mobile-wa:focus, .btn-mobile-wa:active {
    background: #059669;
    border-color: #059669;
    color: #ffffff;
  }
  .btn-mobile-more {
    border-radius: 6px;
    font-weight: 600;
    font-size: 12px;
    padding: 7px 12px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #334155;
  }
}
</style>

<section class="content-header">
   <h1>Data Pelanggan <small>Manajemen Data Pelanggan Terdaftar</small></h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li>Master Data</li>
      <li class="active">Pelanggan</li>
   </ol>
</section>

<section class="content">
   <?php 
   $f_message = $this->session->flashdata('f_message');
   $f_type    = $this->session->flashdata('f_type');
   if (!empty($f_message)):
      $alert_bg = ($f_type == 'error') ? '#fef2f2' : (($f_type == 'warning') ? '#fffbeb' : '#f0fdf4');
      $alert_border = ($f_type == 'error') ? '#ef4444' : (($f_type == 'warning') ? '#f59e0b' : '#10b981');
      $alert_icon = ($f_type == 'error') ? 'fa-exclamation-triangle text-danger' : (($f_type == 'warning') ? 'fa-exclamation-circle text-warning' : 'fa-check-circle text-success');
      $alert_title = ($f_type == 'error') ? 'Peringatan / Gagal' : 'Berhasil';
   ?>
   <div class="alert alert-dismissible" style="background:<?= $alert_bg; ?>; border:1px solid <?= $alert_border; ?>; border-left:6px solid <?= $alert_border; ?>; border-radius:10px; color:#0f172a; padding:14px 18px; margin-bottom:18px; box-shadow:0 3px 12px rgba(0,0,0,0.03);">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:#0f172a; opacity:0.6; font-size:20px;">&times;</button>
      <div style="display:flex; align-items:center; gap:12px;">
         <i class="fa <?= $alert_icon; ?>" style="font-size:22px;"></i>
         <div>
            <strong style="font-size:14px; font-weight:800; color:#0f172a;"><?= $alert_title; ?>: </strong>
            <span style="font-size:13px; color:#334155;"><?= $f_message; ?></span>
         </div>
      </div>
   </div>
   <?php endif; ?>
   <div class="box box-primary" style="border-radius:6px;">
      <div class="box-header with-border">
         <h3 class="box-title"><i class="fa fa-address-book text-primary"></i> Daftar Master Pelanggan</h3>
         <div class="box-tools pull-right">
            <?php 
            $export_qs = !empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : '';
            is_allowed('pelanggan_add', function(){ ?>
            <a href="<?= site_url('administrator/pelanggan/add'); ?>" class="btn btn-success btn-sm btn-flat" style="border-radius:4px; font-weight:600;"><i class="fa fa-plus-circle"></i> Tambah Pelanggan Baru</a>
            <?php }); ?>
            <?php is_allowed('pelanggan_export', function() use ($export_qs){ ?>
            <a href="<?= site_url('administrator/pelanggan/export' . $export_qs); ?>" class="btn btn-primary btn-sm btn-flat" style="border-radius:4px; font-weight:600;"><i class="fa fa-file-excel-o"></i> Export XLS</a>
            <a href="<?= site_url('administrator/pelanggan/export_pdf' . $export_qs); ?>" target="_blank" class="btn btn-info btn-sm btn-flat" style="border-radius:4px; font-weight:600;"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
            <?php }); ?>
         </div>
      </div>
      <div class="box-body">
         <form id="form_pelanggan" action="<?= base_url('administrator/pelanggan/index'); ?>">
            <div class="row" style="margin-bottom:15px;">
               <div class="col-md-5">
                  <div class="input-group">
                     <input type="text" class="form-control" name="q" placeholder="Cari Kode, Nama, Kota, Telepon..." value="<?= _ent($this->input->get('q')); ?>">
                     <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Cari</button>
                        <a href="<?= base_url('administrator/pelanggan'); ?>" class="btn btn-default btn-flat" title="Reset Filter"><i class="fa fa-refresh"></i></a>
                     </span>
                  </div>
               </div>
               <div class="col-md-3">
                  <select name="f" class="form-control">
                     <option value="">-- Semua Kriteria --</option>
                     <option <?= $this->input->get('f') == 'nama_pelanggan' ? 'selected' : ''; ?> value="nama_pelanggan">Nama Pelanggan</option>
                     <option <?= $this->input->get('f') == 'kota' ? 'selected' : ''; ?> value="kota">Kota / Wilayah</option>
                  </select>
               </div>
               <div class="col-md-3">
                  <select name="source" class="form-control" onchange="this.form.submit()">
                     <option value="">-- Semua Kategori --</option>
                     <option <?= $this->input->get('source') == 'resi' ? 'selected' : ''; ?> value="resi">Resi</option>
                     <option <?= $this->input->get('source') == 'tiktok' ? 'selected' : ''; ?> value="tiktok">TikTok Shop</option>
                     <option <?= $this->input->get('source') == 'shopee' ? 'selected' : ''; ?> value="shopee">Shopee</option>
                     <option <?= $this->input->get('source') == 'tokopedia' ? 'selected' : ''; ?> value="tokopedia">Tokopedia</option>
                     <option <?= $this->input->get('source') == 'manual' ? 'selected' : ''; ?> value="manual">Toko / Regular</option>
                  </select>
               </div>
            </div>

            <!-- 1. DESKTOP / TABLET VIEW (TABLE) -->
            <div class="pelanggan-desktop-table table-responsive">
               <table class="table table-bordered table-striped table-hover">
                  <thead>
                     <tr style="background:#f8fafc;">
                        <th width="40" class="text-center">No</th>
                        <th>Kode</th>
                        <th>Nama Pelanggan</th>
                        <th>Kategori</th>
                        <th>No. Telepon</th>
                        <th>Kota</th>
                        <th class="text-right">Limit Kredit</th>
                        <th class="text-center">Status</th>
                        <th width="150" class="text-center">Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $no = 1; foreach($pelanggans as $p): ?>
                     <?php 
                        $raw_ph = !empty($p->telepon) && $p->telepon !== '-' ? $p->telepon : (!empty($p->no_telp) && $p->no_telp !== '-' ? $p->no_telp : (!empty($p->resolved_phone) && $p->resolved_phone !== '-' ? $p->resolved_phone : '-'));
                        $is_masked_ph = strpos($raw_ph, '*') !== false;
                        $ph_digits = preg_replace('/[^0-9]/', '', $raw_ph);
                        $wa_clean = '';
                        if (!empty($ph_digits) && strlen($ph_digits) >= 9) {
                           $wa_clean = (substr($ph_digits, 0, 1) === '0') ? ('62' . substr($ph_digits, 1)) : $ph_digits;
                           if (substr($wa_clean, 0, 2) !== '62') $wa_clean = '62' . $wa_clean;
                        }
                     ?>
                     <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><span class="label label-default" style="font-size:11px;"><?= _ent($p->kode_pelanggan); ?></span></td>
                        <td><strong style="color:#0f172a; font-size:13px;"><?= _ent($p->nama_pelanggan); ?></strong></td>
                        <td>
                           <?php 
                           $src = strtolower($p->source ?? 'manual');
                           if ($src == 'resi' || $src == 'scan_resi' || $src == 'import_resi') {
                              echo '<span class="label" style="background:#0284c7; color:#ffffff; padding:4px 8px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-barcode"></i> Resi</span>';
                           } elseif ($src == 'demo' || $src == 'calon_customer' || strpos($src, 'demo') !== false) {
                              echo '<span class="label" style="background:#2563eb; color:#ffffff; padding:4px 8px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-user-plus"></i> Calon Customer (Demo)</span>';
                           } elseif ($src == 'tiktok' || $src == 'tiktokshop' || $src == 'tiktok_shop' || $src == 'tiktok shop') {
                              echo '<span class="label" style="background:#0f172a; color:#ffffff; padding:4px 8px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-music" style="color:#22d3ee;"></i> TikTok Shop</span>';
                           } elseif ($src == 'shopee') {
                              echo '<span class="label" style="background:#ee4d2d; color:#ffffff; padding:4px 8px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-shopping-bag"></i> Shopee</span>';
                           } elseif ($src == 'tokopedia') {
                              echo '<span class="label" style="background:#03ac0e; color:#ffffff; padding:4px 8px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-shopping-cart"></i> Tokopedia</span>';
                           } else {
                              echo '<span class="label" style="background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; padding:4px 8px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-home text-muted"></i> Toko / Regular</span>';
                           }
                           ?>
                        </td>
                        <td>
                           <i class="fa fa-phone text-muted"></i> <?= _ent($raw_ph); ?>
                           <?php if ($is_masked_ph): ?>
                              <span class="label" style="background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1; font-size:10px; padding:2px 6px; border-radius:3px; margin-left:4px; font-weight:600;" title="Nomor disensor oleh marketplace untuk privasi pembeli">
                                 <i class="fa fa-shield"></i> Disensor Resi
                              </span>
                           <?php elseif (!empty($wa_clean)): ?>
                              <a href="https://wa.me/<?= $wa_clean; ?>" target="_blank" class="btn btn-xs btn-success" style="margin-left:6px; border-radius:3px; padding:1px 6px;" title="Chat WhatsApp Langsung">
                                 <i class="fa fa-whatsapp"></i> Chat WA
                              </a>
                           <?php endif; ?>
                        </td>
                        <td><?= _ent($p->kota ?? '-'); ?></td>
                        <td class="text-right"><strong>Rp <?= number_format($p->limit_kredit, 0, ',', '.'); ?></strong></td>
                        <td class="text-center"><span class="label <?= $p->status == 'aktif' ? 'label-success' : 'label-danger'; ?>"><?= ucfirst($p->status); ?></span></td>
                        <td class="text-center" style="white-space:nowrap;">
                           <?php is_allowed('pelanggan_view', function() use ($p){ ?>
                              <a href="<?= site_url('administrator/pelanggan/view/'.$p->id); ?>" class="btn btn-info btn-xs btn-flat" style="border-radius:3px; padding:2px 8px; font-weight:600;" title="Detail Pelanggan">
                                 <i class="fa fa-eye"></i> Detail
                              </a>
                           <?php }); ?>
                           <div class="btn-group">
                              <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:3px; padding:2px 6px;">
                                 Aksi <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-right" style="border-radius:4px; box-shadow:0 4px 14px rgba(0,0,0,0.15); min-width:200px;">
                                 <?php is_allowed('pelanggan_view', function() use ($p){ ?>
                                    <li><a href="<?= site_url('administrator/pelanggan/view/'.$p->id); ?>"><i class="fa fa-eye text-info"></i> Detail Pelanggan</a></li>
                                 <?php }); ?>
                                 <?php is_allowed('sales_order_add', function() use ($p){ ?>
                                    <li><a href="<?= site_url('administrator/sales_order/add?pelanggan_id='.$p->id); ?>"><i class="fa fa-shopping-cart text-success"></i> Buat Penjualan Baru</a></li>
                                 <?php }); ?>
                                 <?php if (!$is_masked_ph && !empty($wa_clean)): ?>
                                    <li><a href="https://wa.me/<?= $wa_clean; ?>" target="_blank"><i class="fa fa-whatsapp text-success"></i> Chat Langsung WA (wa.me)</a></li>
                                    <li><a href="<?= site_url('administrator/crm/customer_summary?phone='.urlencode($ph_digits)); ?>"><i class="fa fa-line-chart text-purple"></i> Analisis RFM &amp; CRM</a></li>
                                 <?php endif; ?>
                                 <?php is_allowed('pelanggan_update', function() use ($p){ ?>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= site_url('administrator/pelanggan/edit/'.$p->id); ?>"><i class="fa fa-edit text-warning"></i> Edit Data</a></li>
                                 <?php }); ?>
                                 <li role="separator" class="divider"></li>
                                 <?php is_allowed('pelanggan_delete', function() use ($p){ ?>
                                    <li><a href="javascript:void(0);" data-href="<?= site_url('administrator/pelanggan/delete/'.$p->id); ?>" class="remove-data text-danger"><i class="fa fa-trash"></i> Hapus Pelanggan</a></li>
                                 <?php }); ?>
                              </ul>
                           </div>
                        </td>
                     </tr>
                     <?php endforeach; ?>
                     <?php if(count($pelanggans) == 0): ?><tr><td colspan="9" class="text-center text-muted"><i class="fa fa-inbox"></i> Tidak ada data pelanggan.</td></tr><?php endif; ?>
                  </tbody>
               </table>
            </div>

            <!-- 2. MOBILE CARD VIEW (OPTIMIZED FOR SMARTPHONES) -->
            <div class="pelanggan-mobile-cards">
               <?php foreach($pelanggans as $p): ?>
                  <?php 
                     $raw_ph = !empty($p->telepon) && $p->telepon !== '-' ? $p->telepon : (!empty($p->no_telp) && $p->no_telp !== '-' ? $p->no_telp : (!empty($p->resolved_phone) && $p->resolved_phone !== '-' ? $p->resolved_phone : '-'));
                     $is_masked_ph = strpos($raw_ph, '*') !== false;
                     $ph_digits = preg_replace('/[^0-9]/', '', $raw_ph);
                     $wa_clean = '';
                     if (!empty($ph_digits) && strlen($ph_digits) >= 9) {
                        $wa_clean = (substr($ph_digits, 0, 1) === '0') ? ('62' . substr($ph_digits, 1)) : $ph_digits;
                        if (substr($wa_clean, 0, 2) !== '62') $wa_clean = '62' . $wa_clean;
                     }
                  ?>
                  <div class="pelanggan-card">
                     <div class="pelanggan-card-header">
                        <div class="pelanggan-card-title-group">
                           <span class="pelanggan-code-badge"><i class="fa fa-id-badge"></i> <?= _ent($p->kode_pelanggan); ?></span>
                           <h4 class="pelanggan-card-title"><?= _ent($p->nama_pelanggan); ?></h4>
                        </div>
                        <div>
                           <span class="label <?= $p->status == 'aktif' ? 'label-success' : 'label-danger'; ?>" style="font-size:10.5px; padding:3px 7px; border-radius:4px;">
                              <i class="fa fa-circle" style="font-size:7px; vertical-align:middle; margin-right:2px;"></i> <?= ucfirst($p->status); ?>
                           </span>
                        </div>
                     </div>
                     <div class="pelanggan-card-body">
                        <div class="pelanggan-info-grid">
                           <div class="pelanggan-info-item">
                              <span class="info-label"><i class="fa fa-tag text-muted"></i> Kategori</span>
                              <div class="info-value">
                                 <?php 
                                 $src = strtolower($p->source ?? 'manual');
                                 if ($src == 'resi' || $src == 'scan_resi' || $src == 'import_resi') {
                                    echo '<span class="label" style="background:#0284c7; color:#ffffff; padding:3px 6px; border-radius:4px; font-weight:700; font-size:10.5px;"><i class="fa fa-barcode"></i> Resi</span>';
                                 } elseif ($src == 'demo' || $src == 'calon_customer' || strpos($src, 'demo') !== false) {
                                    echo '<span class="label" style="background:#2563eb; color:#ffffff; padding:3px 6px; border-radius:4px; font-weight:700; font-size:10.5px;"><i class="fa fa-user-plus"></i> Calon Demo</span>';
                                 } elseif ($src == 'tiktok' || $src == 'tiktokshop' || $src == 'tiktok_shop' || $src == 'tiktok shop') {
                                    echo '<span class="label" style="background:#0f172a; color:#ffffff; padding:3px 6px; border-radius:4px; font-weight:700; font-size:10.5px;"><i class="fa fa-music" style="color:#22d3ee;"></i> TikTok</span>';
                                 } elseif ($src == 'shopee') {
                                    echo '<span class="label" style="background:#ee4d2d; color:#ffffff; padding:3px 6px; border-radius:4px; font-weight:700; font-size:10.5px;"><i class="fa fa-shopping-bag"></i> Shopee</span>';
                                 } elseif ($src == 'tokopedia') {
                                    echo '<span class="label" style="background:#03ac0e; color:#ffffff; padding:3px 6px; border-radius:4px; font-weight:700; font-size:10.5px;"><i class="fa fa-shopping-cart"></i> Tokopedia</span>';
                                 } else {
                                    echo '<span class="label" style="background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; padding:3px 6px; border-radius:4px; font-weight:700; font-size:10.5px;"><i class="fa fa-home text-muted"></i> Regular</span>';
                                 }
                                 ?>
                              </div>
                           </div>
                           <div class="pelanggan-info-item">
                              <span class="info-label"><i class="fa fa-map-marker text-muted"></i> Kota / Wilayah</span>
                              <span class="info-value" style="font-weight:600;"><?= _ent($p->kota ?? '-'); ?></span>
                           </div>
                           <div class="pelanggan-info-item full-width">
                              <span class="info-label"><i class="fa fa-phone text-muted"></i> No. Telepon</span>
                              <div class="info-value" style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                                 <span><?= _ent($raw_ph); ?></span>
                                 <?php if ($is_masked_ph): ?>
                                    <span class="label" style="background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1; font-size:9.5px; padding:2px 5px; border-radius:3px;">
                                       <i class="fa fa-shield"></i> Disensor Resi
                                    </span>
                                 <?php elseif (!empty($wa_clean)): ?>
                                    <a href="https://wa.me/<?= $wa_clean; ?>" target="_blank" class="btn btn-xs btn-success" style="border-radius:3px; padding:1px 6px; font-size:10.5px;" title="Chat WhatsApp Langsung">
                                       <i class="fa fa-whatsapp"></i> Chat WA
                                    </a>
                                 <?php endif; ?>
                              </div>
                           </div>
                           <div class="pelanggan-info-item full-width">
                              <span class="info-label"><i class="fa fa-credit-card text-muted"></i> Limit Kredit</span>
                              <span class="info-value"><strong style="color:#0f172a; font-size:13px;">Rp <?= number_format($p->limit_kredit, 0, ',', '.'); ?></strong></span>
                           </div>
                        </div>
                     </div>
                     <div class="pelanggan-card-footer">
                        <?php is_allowed('pelanggan_view', function() use ($p){ ?>
                           <a href="<?= site_url('administrator/pelanggan/view/'.$p->id); ?>" class="btn btn-sm btn-flat btn-mobile-detail">
                              <i class="fa fa-eye"></i> Detail Pelanggan
                           </a>
                        <?php }); ?>

                        <?php if (!$is_masked_ph && !empty($wa_clean)): ?>
                           <a href="https://wa.me/<?= $wa_clean; ?>" target="_blank" class="btn btn-sm btn-flat btn-mobile-wa" title="WhatsApp Langsung">
                              <i class="fa fa-whatsapp"></i> WA
                           </a>
                        <?php endif; ?>

                        <div class="btn-group">
                           <button type="button" class="btn btn-sm btn-flat btn-mobile-more dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Aksi <span class="caret"></span>
                           </button>
                           <ul class="dropdown-menu dropdown-menu-right" style="border-radius:6px; box-shadow:0 6px 18px rgba(0,0,0,0.15); min-width:185px;">
                              <?php is_allowed('pelanggan_view', function() use ($p){ ?>
                                 <li><a href="<?= site_url('administrator/pelanggan/view/'.$p->id); ?>"><i class="fa fa-eye text-info"></i> Detail Pelanggan</a></li>
                              <?php }); ?>
                              <?php is_allowed('sales_order_add', function() use ($p){ ?>
                                 <li><a href="<?= site_url('administrator/sales_order/add?pelanggan_id='.$p->id); ?>"><i class="fa fa-shopping-cart text-success"></i> Buat Penjualan Baru</a></li>
                              <?php }); ?>
                              <?php if (!$is_masked_ph && !empty($wa_clean)): ?>
                                 <li><a href="https://wa.me/<?= $wa_clean; ?>" target="_blank"><i class="fa fa-whatsapp text-success"></i> Chat Langsung WA (wa.me)</a></li>
                                 <li><a href="<?= site_url('administrator/crm/customer_summary?phone='.urlencode($ph_digits)); ?>"><i class="fa fa-line-chart text-purple"></i> Analisis RFM &amp; CRM</a></li>
                              <?php endif; ?>
                              <?php is_allowed('pelanggan_update', function() use ($p){ ?>
                                 <li role="separator" class="divider"></li>
                                 <li><a href="<?= site_url('administrator/pelanggan/edit/'.$p->id); ?>"><i class="fa fa-edit text-warning"></i> Edit Data</a></li>
                              <?php }); ?>
                              <li role="separator" class="divider"></li>
                              <?php is_allowed('pelanggan_delete', function() use ($p){ ?>
                                 <li><a href="javascript:void(0);" data-href="<?= site_url('administrator/pelanggan/delete/'.$p->id); ?>" class="remove-data text-danger"><i class="fa fa-trash"></i> Hapus Pelanggan</a></li>
                              <?php }); ?>
                           </ul>
                        </div>
                     </div>
                  </div>
               <?php endforeach; ?>
               <?php if(count($pelanggans) == 0): ?>
                  <div class="text-center text-muted" style="padding:30px 15px; background:#fff; border:1px solid #e2e8f0; border-radius:8px;">
                     <i class="fa fa-inbox fa-3x" style="color:#cbd5e1; margin-bottom:8px;"></i>
                     <p style="font-size:14px; margin:0;">Tidak ada data pelanggan yang sesuai dengan pencarian / filter.</p>
                  </div>
               <?php endif; ?>
            </div>
         </form>

         <div class="row" style="margin-top:15px;">
            <div class="col-md-6 col-sm-6 col-xs-12" style="margin-bottom:8px;">
               <span class="text-muted" style="font-size:13px;">Total Data: <strong><?= number_format($pelanggan_counts); ?></strong> Pelanggan</span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 text-right">
               <?= $pagination; ?>
            </div>
         </div>
      </div>
   </div>
</section>

<script>
$(document).ready(function(){
   $('.remove-data').click(function(){
      var url = $(this).attr('data-href');
      swal({
         title: "Hapus Pelanggan?",
         text: "Data yang dihapus tidak bisa dikembalikan!",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Ya, Hapus!",
         cancelButtonText: "Batal"
      }, function(ok){ if(ok) window.location.href=url; });
   });
});
</script>
