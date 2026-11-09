<?php
/**
 * View: Daftar Sales Order Regular
 * File: sales_order_list.php
 */
$status_color = [
    'draft'      => 'label-default',
    'submitted'  => 'label-default',
    'confirmed'  => 'label-info',
    'approved'   => 'label-info',
    'packing'    => 'label-warning',
    'processing' => 'label-warning',
    'shipped'    => 'label-primary',
    'delivered'  => 'label-success',
    'completed'  => 'label-success',
    'cancelled'  => 'label-danger'
];

$status_display = [
    'draft'      => '1. DRAFT',
    'submitted'  => '1. DRAFT',
    'confirmed'  => '2. TERKONFIRMASI',
    'approved'   => '2. TERKONFIRMASI',
    'packing'    => '3. SEDANG DIKEMAS',
    'processing' => '3. SEDANG DIKEMAS',
    'shipped'    => '4. DALAM PENGIRIMAN',
    'delivered'  => '5. SELESAI',
    'completed'  => '5. SELESAI',
    'cancelled'  => 'DIBATALKAN'
];
?>
<style>
/* Modern Responsive Sales Order UI */
.so-kpi-grid {
   display: grid;
   grid-template-columns: repeat(4, 1fr);
   gap: 14px;
   margin-bottom: 20px;
}
.kpi-card {
   background: #ffffff;
   border-radius: 10px;
   padding: 16px 18px;
   box-shadow: 0 2px 10px rgba(0,0,0,0.04);
   border: 1px solid #e2e8f0;
   border-left: 4px solid #00c0ef;
   margin-bottom: 0 !important;
   transition: all 0.2s ease;
   cursor: pointer;
   position: relative;
   user-select: none;
   display: flex;
   flex-direction: column;
   justify-content: space-between;
}
.kpi-card:hover {
   transform: translateY(-3px);
   box-shadow: 0 8px 22px rgba(0,0,0,0.12);
}
.kpi-card:active {
   transform: translateY(-1px);
}
.kpi-card.orange { border-left-color: #f39c12; }
.kpi-card.green  { border-left-color: #00a65a; }
.kpi-card.purple { border-left-color: #605ca8; }

/* Active Card Highlights */
.kpi-card.active-kpi {
   background: #eff6ff;
   box-shadow: 0 0 0 2px #00c0ef, 0 8px 24px rgba(0, 192, 239, 0.25);
}
.kpi-card.orange.active-kpi {
   background: #fffbeb;
   box-shadow: 0 0 0 2px #f39c12, 0 8px 24px rgba(243, 156, 18, 0.25);
}
.kpi-card.green.active-kpi {
   background: #f0fdf4;
   box-shadow: 0 0 0 2px #00a65a, 0 8px 24px rgba(0, 166, 90, 0.25);
}
.kpi-card.purple.active-kpi {
   background: #faf5ff;
   box-shadow: 0 0 0 2px #605ca8, 0 8px 24px rgba(96, 92, 168, 0.25);
}

.kpi-title {
   font-size: 11px;
   text-transform: uppercase;
   font-weight: 700;
   color: #64748b;
   letter-spacing: 0.5px;
   display: flex;
   justify-content: space-between;
   align-items: center;
}
.kpi-value {
   font-size: 22px;
   font-weight: 800;
   color: #0f172a;
   margin: 4px 0;
   line-height: 1.2;
}
.kpi-sub {
   font-size: 11px;
   color: #64748b;
}
.kpi-icon {
   font-size: 26px;
   opacity: 0.2;
   float: right;
   margin-top: -32px;
}

.kpi-pill-badge {
   display: inline-flex;
   align-items: center;
   gap: 4px;
   padding: 3px 8px;
   border-radius: 4px;
   font-size: 10px;
   font-weight: 700;
   cursor: pointer;
   transition: all 0.15s ease;
   white-space: nowrap;
}
.kpi-pill-badge:hover {
   transform: scale(1.04);
   box-shadow: 0 2px 5px rgba(0,0,0,0.12);
}

/* Action Header & Tools */
.so-header-wrap {
   display: flex;
   align-items: center;
   justify-content: space-between;
   width: 100%;
   flex-wrap: wrap;
   gap: 12px;
}
.so-header-title {
   font-size: 16px;
   font-weight: 700;
   color: #0f172a;
   margin: 0;
   display: flex;
   align-items: center;
   gap: 8px;
}
.so-action-tools {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
}
.so-btn {
   display: inline-flex;
   align-items: center;
   justify-content: center;
   gap: 6px;
   padding: 7px 14px;
   border-radius: 6px;
   font-size: 12px;
   font-weight: 700;
   text-decoration: none !important;
   transition: all 0.2s ease;
   border: 1px solid transparent;
   white-space: nowrap;
   cursor: pointer;
}
.so-btn:hover {
   transform: translateY(-1px);
   box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.so-btn-pos {
   background: linear-gradient(135deg, #059669, #10b981);
   color: #fff !important;
   box-shadow: 0 2px 8px rgba(5,150,105,0.25);
}
.so-btn-add {
   background: #2563eb;
   color: #fff !important;
   box-shadow: 0 2px 8px rgba(37,99,235,0.25);
}
.so-btn-mp {
   background: #0284c7;
   color: #fff !important;
}
.so-btn-cust {
   background: #f1f5f9;
   color: #334155 !important;
   border-color: #cbd5e1;
}
.so-btn-cust:hover {
   background: #e2e8f0;
}

.clean-filter-box {
   background: #f8fafc;
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   padding: 16px;
   margin-bottom: 20px;
}
.table-responsive {
   -webkit-overflow-scrolling: touch;
}

/* Responsive Breakpoints */
@media (max-width: 991px) {
   .so-kpi-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
   }
   .so-action-tools {
      width: 100%;
      justify-content: flex-start;
   }
}

@media (max-width: 767px) {
   .content {
      padding: 10px 8px !important;
   }
   .content-header {
      padding: 10px 10px 0 10px !important;
   }
   .content-header > h1 {
      font-size: 20px !important;
   }
   /* KPI Grid on Mobile: Top Card 100% width, 3 cards in 3 columns below it */
   .so-kpi-grid {
      grid-template-columns: repeat(3, 1fr);
      gap: 8px;
      margin-bottom: 14px;
   }
   .so-kpi-card-omset {
      grid-column: 1 / -1 !important; /* Full width 100% */
      padding: 14px 16px !important;
   }
   .so-kpi-card-omset .kpi-value {
      font-size: 20px !important;
      margin: 4px 0 6px !important;
   }
   .so-kpi-card-omset .kpi-sub {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin-top: 4px;
   }
   .so-kpi-card-omset .kpi-icon {
      font-size: 24px;
      margin-top: -30px;
   }
   .so-kpi-stage-card {
      padding: 10px 8px !important;
      min-height: 86px;
      justify-content: center;
   }
   .so-kpi-stage-card .kpi-title {
      font-size: 9.5px !important;
      line-height: 1.2;
   }
   .so-kpi-stage-card .kpi-value {
      font-size: 17px !important;
      font-weight: 800 !important;
      margin: 2px 0 !important;
   }
   .so-kpi-stage-card .kpi-sub {
      font-size: 9px !important;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
   }
   .so-kpi-stage-card .kpi-icon {
      display: none !important;
   }

   /* Header and 2x2 Buttons */
   .box-header {
      padding: 12px 14px !important;
   }
   .so-header-wrap {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 10px !important;
   }
   .so-action-tools {
      display: grid !important;
      grid-template-columns: repeat(2, 1fr) !important;
      gap: 6px !important;
      width: 100% !important;
   }
   .so-btn {
      padding: 8px 6px !important;
      font-size: 11px !important;
      width: 100% !important;
      text-align: center !important;
   }
   .clean-filter-box {
      padding: 12px !important;
      margin-bottom: 14px !important;
   }
   .clean-filter-box .row > div {
      margin-bottom: 8px;
   }
   .clean-filter-box .row > div:last-child {
      margin-bottom: 0;
      padding-top: 4px !important;
   }
   .clean-filter-box button[type="submit"] {
      height: 36px;
   }
}
</style>

<section class="content-header">
   <h1>
      Penjualan
      <small>Daftar Pesanan &amp; Transaksi Penjualan</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Penjualan</li>
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

   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary" style="border-radius:8px; border-top: 3px solid #3c8dbc;">
            <div class="box-header with-border">
               <div class="so-header-wrap">
                  <h3 class="so-header-title">
                     <i class="fa fa-list-alt text-primary"></i> Daftar Dokumen Penjualan
                  </h3>
                  <div class="so-action-tools">
                     <!-- 1. Quick POS Kasir -->
                     <?php if (is_allowed('sales_order_add', false)): ?>
                        <a href="<?= site_url('administrator/sales_order/cepat'); ?>" class="so-btn so-btn-pos" title="Buka Penjualan Cepat POS">
                           <i class="fa fa-bolt"></i> <span>Penjualan Cepat (POS)</span>
                        </a>
                        <a href="<?= site_url('administrator/sales_order/add'); ?>" class="so-btn so-btn-add" title="Input Pesanan Baru Manual">
                           <i class="fa fa-plus"></i> <span>Tambah Penjualan</span>
                        </a>
                     <?php endif; ?>
                     
                     <?php if (is_allowed('pelanggan_list', false)): ?>
                        <a href="<?= site_url('administrator/pelanggan'); ?>" class="so-btn so-btn-cust" title="Buka Data Pelanggan">
                           <i class="fa fa-users"></i> <span>Data Pelanggan</span>
                        </a>
                     <?php endif; ?>

                     <!-- 3. Export / Print Tools -->
                     <?php if (is_allowed('sales_order_export', false)): ?>
                        <?php
                        $export_params = array_filter([
                           'pelanggan_id' => $this->input->get('pelanggan_id') ?: null,
                           'status'       => $this->input->get('status') ?: null,
                           'source'       => $this->input->get('source') ?: null,
                           'q'            => $this->input->get('q') ?: null,
                           'f'            => $this->input->get('f') ?: null,
                        ]);
                        $export_qs = !empty($export_params) ? '?' . http_build_query($export_params) : '';
                        ?>
                        <a href="<?= site_url('administrator/sales_order/export' . $export_qs); ?>" class="so-btn so-btn-cust" style="background:#f8fafc; color:#15803d; border-color:#cbd5e1;" title="Export Rekap Penjualan ke Excel">
                           <i class="fa fa-file-excel-o text-success"></i> <span>Export Excel</span>
                        </a>
                        <a href="<?= site_url('administrator/sales_order/export_pdf' . $export_qs); ?>" target="_blank" class="so-btn so-btn-cust" style="background:#f8fafc; color:#b91c1c; border-color:#cbd5e1;" title="Cetak Rekap Laporan Penjualan (PDF)">
                           <i class="fa fa-file-pdf-o text-danger"></i> <span>Cetak PDF</span>
                        </a>
                     <?php endif; ?>
                  </div>
               </div>
            </div>

            <div class="box-body" style="padding: 20px;">
               <!-- Clean Filter Bar -->
               <div class="clean-filter-box">
                  <form action="<?= base_url('administrator/sales_order/index'); ?>" method="GET">
                     <div class="row">
                        <div class="col-md-4 col-sm-6">
                           <label class="text-muted" style="font-size:12px;">Pelanggan:</label>
                           <select class="form-control chosen" name="pelanggan_id" onchange="this.form.submit()">
                              <option value="">-- Semua Pelanggan --</option>
                              <?php foreach($pelanggans as $p): ?>
                              <option value="<?= $p->id; ?>" <?= $this->input->get('pelanggan_id') == $p->id ? 'selected':''; ?>><?= _ent($p->nama_pelanggan); ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <label class="text-muted" style="font-size:12px;">Saluran / Channel:</label>
                           <select class="form-control" name="source" style="border-radius:4px;" onchange="this.form.submit()">
                              <option value="">-- Semua Saluran --</option>
                              <option value="pos" <?= $this->input->get('source') == 'pos' ? 'selected' : ''; ?>>⚡ POS Kasir (Cepat)</option>
                              <option value="manual" <?= in_array($this->input->get('source'), ['manual', 'offline']) ? 'selected' : ''; ?>>🏢 Transaksi Offline</option>
                           </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <label class="text-muted" style="font-size:12px;">Cari No. Transaksi Penjualan / Nama:</label>
                           <input type="text" class="form-control" name="q" placeholder="Ketik No. Transaksi / Nama..." value="<?= _ent($this->input->get('q')); ?>">
                        </div>
                        <div class="col-md-2 col-sm-6" style="padding-top: 23px; display:flex; gap:6px;">
                           <button type="submit" class="btn btn-primary btn-flat" style="border-radius:4px; flex:1;" title="Cari Data"><i class="fa fa-search"></i> Cari</button>
                           <?php if (!empty($this->input->get('source')) || !empty($this->input->get('pelanggan_id')) || !empty($this->input->get('q'))): ?>
                           <a href="<?= site_url('administrator/sales_order'); ?>" class="btn btn-default btn-flat" style="border-radius:4px;" title="Reset / Tampilkan Semua"><i class="fa fa-refresh"></i> Reset</a>
                           <?php endif; ?>
                        </div>
                     </div>
                  </form>
               </div>

               <div class="table-responsive" style="overflow-x: auto; min-height: 250px;">
                  <table class="table table-hover table-striped table-bordered" style="vertical-align: middle; margin-bottom: 0;">
                     <thead>
                        <tr style="background:#f8fafc; font-size:12px; color:#555;">
                           <th width="40" class="text-center">No</th>
                           <th width="170">No. Transaksi Penjualan</th>
                           <th>Tanggal Penjualan</th>
                           <th>Pelanggan</th>
                           <th class="text-right">Grand Total (Rp)</th>
                           <th class="text-center" width="160">Metode Pembayaran</th>
                           <th class="text-center" width="220">Aksi</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($sos)): ?>
                           <?php $no = $this->uri->segment(4) + 1; foreach ($sos as $so): ?>
                           <tr>
                              <td class="text-center"><?= $no++; ?></td>
                              <td>
                                 <strong class="text-primary"><a href="<?= site_url('administrator/sales_order/view/' . $so->id); ?>"><?= _ent($so->nomor_so); ?></a></strong>
                                 <br>
                                 <?php if ($so->source == 'pos' || strpos((string)$so->catatan, '[POS CEPAT') !== false): ?>
                                     <span class="label" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; font-size:9.5px; padding:2px 5px; border-radius:3px;">
                                        <i class="fa fa-bolt"></i> POS Kasir (Cepat)
                                     </span>
                                  <?php elseif ($so->source == 'excel_import' || in_array(strtolower((string)$so->source), ['shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace']) || (!empty($so->no_pesanan) && $so->source != 'manual' && $so->source != 'pos')): ?>
                                     <?php
                                        $s_low = strtolower((string)$so->source);
                                        $mp_name = 'Marketplace (Shopee)';
                                        $mp_bg = '#fff2ee'; $mp_color = '#ee4d2d'; $mp_border = '#ffccbe'; $mp_icon = 'fa-shopping-bag';
                                        if ($s_low == 'tokopedia') {
                                           $mp_name = 'Tokopedia'; $mp_bg = '#f0fdf4'; $mp_color = '#15803d'; $mp_border = '#bbf7d0'; $mp_icon = 'fa-shopping-cart';
                                        } elseif (in_array($s_low, ['tiktok', 'tiktokshop'])) {
                                           $mp_name = 'TikTok Shop'; $mp_bg = '#f1f5f9'; $mp_color = '#0f172a'; $mp_border = '#cbd5e1'; $mp_icon = 'fa-music';
                                        } elseif ($s_low == 'shopee') {
                                           $mp_name = 'Shopee'; $mp_bg = '#fff2ee'; $mp_color = '#ee4d2d'; $mp_border = '#ffccbe'; $mp_icon = 'fa-shopping-bag';
                                        }
                                     ?>
                                     <span class="label" style="background:<?= $mp_bg; ?>; color:<?= $mp_color; ?>; border:1px solid <?= $mp_border; ?>; font-size:9.5px; padding:2px 5px; border-radius:3px;">
                                        <i class="fa <?= $mp_icon; ?>"></i> <?= $mp_name; ?>
                                     </span>
                                     <?php if (!empty($so->no_pesanan) && $so->no_pesanan !== $so->nomor_so): ?>
                                        <br><small style="font-family:monospace; color:#64748b; font-size:10px;">#<?= _ent($so->no_pesanan); ?></small>
                                     <?php endif; ?>
                                     <?php if (!empty($so->nomor_resi) && $so->nomor_resi !== '-'): ?>
                                        <br><small style="font-family:monospace; color:#0284c7; font-size:9.5px;"><i class="fa fa-barcode"></i> <?= _ent($so->nomor_resi); ?></small>
                                     <?php endif; ?>
                                  <?php else: ?>
                                     <span class="label" style="background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; font-size:9.5px; padding:2px 5px; border-radius:3px;">
                                        <i class="fa fa-building-o"></i> Transaksi Offline
                                     </span>
                                  <?php endif; ?>
                              </td>
                              <td><i class="fa fa-calendar text-muted"></i> <?= date('d/m/Y', strtotime($so->tanggal_so)); ?></td>
                               <td>
                                  <?php
                                     $is_mp = ($so->source == 'excel_import' 
                                         || in_array(strtolower((string)$so->source), ['shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace']) 
                                         || (!empty($so->no_pesanan) && !in_array(strtolower((string)$so->source), ['manual', 'pos', 'regular', 'b2b'])));

                                     if ($is_mp) {
                                         if (!empty($so->nama_penerima) && $so->nama_penerima !== '-') {
                                             $raw_cust = $so->nama_penerima;
                                         } elseif (!empty($so->nama_pelanggan) && stripos($so->nama_pelanggan, 'Kencana Retail') === false) {
                                             $raw_cust = $so->nama_pelanggan;
                                         } elseif (!empty($so->username_pembeli) && !in_array(strtolower($so->username_pembeli), ['-', '_', 'buyer'])) {
                                             $raw_cust = $so->username_pembeli;
                                         } else {
                                             $raw_cust = !empty($so->nama_pelanggan) ? $so->nama_pelanggan : 'Pelanggan Umum';
                                         }
                                     } else {
                                         $raw_cust = !empty($so->nama_pelanggan) ? $so->nama_pelanggan : (!empty($so->nama_penerima) ? $so->nama_penerima : 'Pelanggan Umum');
                                     }

                                     $customer_name = clean_customer_name($raw_cust) ?: 'Pelanggan Umum';
                                     $customer_user = clean_customer_username($so->username_pembeli ?? '', $customer_name);
                                     $raw_ph = ($is_mp && (int)$so->pelanggan_id === 1) ? (!empty($so->no_telepon) ? $so->no_telepon : '') : (!empty($so->no_telepon) ? $so->no_telepon : ($so->telp_pelanggan ?? ''));
                                     $customer_phone = clean_customer_phone($raw_ph);
                                  ?>
                                  <strong style="color:#1e293b; font-size:13px;"><?= _ent($customer_name); ?></strong>
                                  <?php if (!empty($customer_user)): ?>
                                     <small class="text-muted">(@<?= _ent($customer_user); ?>)</small>
                                  <?php endif; ?>
                                  <?php if (!empty($customer_phone)): ?>
                                     <small class="text-muted" style="font-size:11.5px; margin-left:3px;"><i class="fa fa-phone text-muted"></i> <?= _ent($customer_phone); ?></small>
                                  <?php endif; ?>
                                  <?php if (!empty($so->nama_pengirim) && $so->nama_pengirim !== '-'): ?>
                                     <div style="margin-top:2px; font-size:11px; color:#64748b;">
                                        <i class="fa fa-paper-plane text-info"></i> Pengirim: <span style="color:#1e293b; font-weight:600;"><?= _ent($so->nama_pengirim); ?></span><?= (!empty($so->no_telepon_pengirim) && $so->no_telepon_pengirim !== '-') ? ' <span style="color:#0284c7; font-weight:600;">(' . _ent($so->no_telepon_pengirim) . ')</span>' : ''; ?>
                                     </div>
                                  <?php endif; ?>
                               </td>
                               <td class="text-right">
                                   <?php 
                                      $is_so_cod = (strtolower($so->tipe_pengiriman ?? '') === 'cod' || (!empty($so->total) && (float)$so->total > 0 && stripos($so->catatan ?? '', 'COD') !== false));
                                   ?>
                                   <?php if ($so->total > 0): ?>
                                      <strong class="text-success" style="font-size:13px;">Rp <?= number_format($so->total, 0, ',', '.'); ?></strong>
                                      <?php if ($is_so_cod): ?>
                                         <br><span class="badge" style="background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; font-size:9.5px; padding:1px 5px;"><i class="fa fa-money"></i> COD</span>
                                      <?php endif; ?>
                                   <?php else: ?>
                                      <span class="text-muted" style="font-size:12px; font-style:italic;">Rp 0</span>
                                      <br><span class="badge" style="background:#f8fafc; color:#64748b; border:1px solid #e2e8f0; font-size:9px; padding:1px 4px;">Cashless</span>
                                   <?php endif; ?>
                                </td>
                              <td class="text-center" style="vertical-align: middle;">
                                 <?php
                                    $is_pos = ($so->source == 'pos' || strpos((string)$so->catatan, '[POS CEPAT') !== false);
                                    $is_mp  = ($so->source == 'excel_import' || in_array(strtolower((string)$so->source), ['shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace']) || (!empty($so->no_pesanan) && $so->source != 'manual' && $so->source != 'pos'));
                                    
                                    $inv_status = isset($so->inv_status_db) ? $so->inv_status_db : null;
                                    if ($inv_status === null && empty($so->waktu_pembayaran) && !$is_pos && !$is_mp) {
                                       $inv_row = $this->db->select('status')->get_where('invoice', ['so_id' => $so->id])->row();
                                       $inv_status = $inv_row ? $inv_row->status : null;
                                    }
                                    
                                    $is_paid = !empty($so->waktu_pembayaran) || ($inv_status == 'paid');
                                    $metode_code = !empty($so->metode_bayar_db) ? strtolower(trim($so->metode_bayar_db)) : '';

                                    if ($is_pos) {
                                       if (empty($metode_code) || $metode_code == 'tunai' || $metode_code == 'cash') {
                                          $metode_label = 'Tunai (Cash)';
                                          $icon = 'fa-money text-success';
                                       } elseif ($metode_code == 'bank_transfer' || $metode_code == 'transfer') {
                                          $metode_label = 'Transfer Bank';
                                          $icon = 'fa-bank text-primary';
                                       } elseif ($metode_code == 'qris') {
                                          $metode_label = 'QRIS';
                                          $icon = 'fa-qrcode text-purple';
                                       } elseif (strpos($metode_code, 'debit') !== false) {
                                          $metode_label = 'Kartu Debit';
                                          $icon = 'fa-credit-card text-info';
                                       } elseif (strpos($metode_code, 'kredit') !== false) {
                                          $metode_label = 'Kartu Kredit';
                                          $icon = 'fa-credit-card text-warning';
                                       } else {
                                          $metode_label = strtoupper($metode_code);
                                          $icon = 'fa-money text-success';
                                       }
                                       $status_badge = '<span class="label label-success" style="font-size:9.5px; padding:2px 6px; border-radius:3px; display:inline-block; margin-top:3px;"><i class="fa fa-check-circle"></i> Lunas (POS)</span>';
                                    } elseif ($is_mp) {
                                       $metode_label = 'Marketplace';
                                       $icon = 'fa-shopping-bag text-warning';
                                       $status_badge = '<span class="label" style="background:#fff2ee; color:#ee4d2d; border:1px solid #ffccbe; font-size:9.5px; padding:2px 6px; border-radius:3px; display:inline-block; margin-top:3px;"><i class="fa fa-check-circle"></i> Lunas (Online)</span>';
                                    } elseif ($is_paid) {
                                       if (!empty($metode_code)) {
                                          $metode_label = ($metode_code == 'bank_transfer' || $metode_code == 'transfer') ? 'Transfer Bank' : strtoupper($metode_code);
                                       } else {
                                          $metode_label = 'Transfer Bank';
                                       }
                                       $icon = 'fa-bank text-primary';
                                       $status_badge = '<span class="label label-success" style="font-size:9.5px; padding:2px 6px; border-radius:3px; display:inline-block; margin-top:3px;"><i class="fa fa-check-circle"></i> Lunas</span>';
                                    } else {
                                       $metode_label = 'Tempo / Kredit';
                                       $icon = 'fa-clock-o text-muted';
                                       $status_badge = '<span class="label label-danger" style="font-size:9.5px; padding:2px 6px; border-radius:3px; display:inline-block; margin-top:3px;"><i class="fa fa-clock-o"></i> Menunggu Bayar</span>';
                                    }
                                 ?>
                                 <div style="font-size:12px; font-weight:700; color:#1e293b; margin-bottom:1px;">
                                    <i class="fa <?= $icon; ?>"></i> <?= _ent($metode_label); ?>
                                 </div>
                                 <?= $status_badge; ?>
                              </td>
                              <td class="text-center">
                                 <a href="<?= site_url('administrator/sales_order/view/' . $so->id); ?>" class="btn btn-default btn-xs" title="Detail"><i class="fa fa-eye"></i></a>
                                 <?php if ($is_pos): ?>
                                 <a href="<?= site_url('administrator/sales_order/cetak_struk/' . $so->id . '?template=thermal'); ?>" target="_blank" class="btn btn-success btn-xs" style="background:#059669; border-color:#047857;" title="Cetak Struk Thermal (POS Kasir 58mm/80mm)"><i class="fa fa-ticket"></i></a>
                                 <?php endif; ?>
                                 <a href="<?= site_url('administrator/sales_order/cetak/' . $so->id); ?>" target="_blank" class="btn btn-info btn-xs" title="Cetak PDF"><i class="fa fa-print"></i></a>
                                 
                                 <?php if (is_allowed('sales_order_update', false)): ?>
                                 <a href="<?= site_url('administrator/sales_order/edit/'.$so->id); ?>" class="btn btn-warning btn-xs" title="Edit Order"><i class="fa fa-edit"></i></a>
                                 <?php endif; ?>

                                 <?php 
                                 $linked_inv = $this->db->get_where('invoice', ['so_id' => $so->id])->row();
                                 if ($linked_inv): 
                                 ?>
                                    <a href="<?= site_url('administrator/invoice/view/' . $linked_inv->id); ?>" class="btn btn-info btn-xs" title="Lihat Invoice <?= _ent($linked_inv->nomor_invoice); ?>"><i class="fa fa-file-text-o"></i> <?= _ent($linked_inv->nomor_invoice); ?></a>
                                 <?php elseif (is_allowed('invoice_add', false)): ?>
                                    <a href="<?= site_url('administrator/invoice/from_so/' . $so->id); ?>" class="btn btn-success btn-xs" title="Terbitkan Invoice"><i class="fa fa-file-text-o"></i> Invoice</a>
                                 <?php endif; ?>

                                 <?php if (is_allowed('sales_order_delete', false)): ?>
                                 <a href="javascript:void(0);" data-href="<?= site_url('administrator/sales_order/delete/' . $so->id); ?>" class="btn btn-danger btn-xs remove-data" title="Hapus"><i class="fa fa-trash"></i></a>
                                 <?php endif; ?>
                              </td>
                           </tr>
                           <?php endforeach; ?>
                         <?php else: ?>
                            <tr>
                               <td colspan="7" class="text-center text-muted" style="padding:40px;">
                                  <i class="fa fa-shopping-cart fa-3x" style="color:#cbd5e1; margin-bottom:10px;"></i><br>
                                  <span style="font-size:16px; font-weight:600; color:#475569;">Tidak ada data Transaksi Penjualan untuk filter ini.</span><br>
                                  <small class="text-muted" style="display:inline-block; margin-top:6px;">
                                     Jika pelanggan bertransaksi melalui <strong>Shopee, Tokopedia, atau TikTok Shop</strong>, silakan cek di menu: 
                                     <a href="<?= site_url('administrator/penjualan_marketplace'); ?>" class="btn btn-xs btn-info btn-flat" style="border-radius:3px; margin-left:3px; font-weight:600;">
                                        <i class="fa fa-shopping-bag"></i> Penjualan Register All (Marketplace)
                                     </a>
                                  </small>
                               </td>
                            </tr>
                         <?php endif; ?>
                     </tbody>
                  </table>
               </div>

               <div class="row" style="margin-top: 15px;">
                  <div class="col-md-6">
                     <span class="text-muted">Total: <strong><?= $so_counts; ?></strong> Transaksi Penjualan</span>
                  </div>
                  <div class="col-md-6">
                     <div class="pull-right">
                        <?= $pagination; ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<script>
$(document).ready(function(){
   $('select[name="source"]').on('change', function(){ $(this).closest('form').submit(); });
   $('select[name="pelanggan_id"]').on('change', function(){ $(this).closest('form').submit(); });
   $('.remove-data').click(function(){
      var url = $(this).attr('data-href');
      swal({
         title: "Hapus Transaksi Penjualan?",
         text: "Data yang dihapus tidak dapat dikembalikan!",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Ya, Hapus!",
         cancelButtonText: "Batal",
         closeOnConfirm: true
      }, function(ok){
         if (ok) {
            window.location.href = url;
         }
      });
   });
});
</script>
