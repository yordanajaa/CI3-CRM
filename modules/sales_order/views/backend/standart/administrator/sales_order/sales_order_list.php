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
.kpi-card {
   background: #ffffff;
   border-radius: 8px;
   padding: 16px 20px;
   box-shadow: 0 2px 10px rgba(0,0,0,0.04);
   border-left: 4px solid #00c0ef;
   margin-bottom: 20px;
   transition: all 0.2s ease;
   cursor: pointer;
   position: relative;
   user-select: none;
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

.kpi-title { font-size: 11px; text-transform: uppercase; font-weight: 700; color: #888; letter-spacing: 0.5px; display:flex; justify-content:space-between; align-items:center; }
.kpi-value { font-size: 22px; font-weight: 700; color: #222; margin: 4px 0; }
.kpi-sub { font-size: 11px; color: #999; }
.kpi-icon { font-size: 28px; opacity: 0.2; float: right; margin-top: -35px; }

.kpi-pill-badge {
   display: inline-block;
   padding: 2px 7px;
   border-radius: 4px;
   font-size: 10px;
   font-weight: 700;
   cursor: pointer;
   transition: all 0.15s ease;
}
.kpi-pill-badge:hover {
   transform: scale(1.05);
   box-shadow: 0 2px 5px rgba(0,0,0,0.12);
}

.clean-filter-box {
   background: #fdfdfd;
   border: 1px solid #e9ecef;
   border-radius: 6px;
   padding: 15px;
   margin-bottom: 20px;
}
.table-responsive {
   -webkit-overflow-scrolling: touch;
}
@media (max-width: 767px) {
   .content { padding: 8px 6px !important; }
   .kpi-card { padding: 12px 10px; margin-bottom: 10px; }
   .kpi-title { font-size: 10px; }
   .kpi-value { font-size: 16px; }
   .kpi-sub { font-size: 9.5px; }
   .kpi-icon { font-size: 22px; margin-top: -26px; }
   .clean-filter-box { padding: 10px; margin-bottom: 12px; }
   .box-header { padding: 12px 14px !important; }
   .box-header .box-title { font-size: 14px !important; display: block !important; margin-bottom: 8px; }
   .box-header .box-tools.pull-right {
      position: static !important;
      float: none !important;
      width: 100% !important;
      display: flex !important;
      flex-wrap: wrap !important;
      gap: 6px !important;
   }
   .box-header .box-tools .btn {
      flex: 1 1 calc(50% - 4px) !important;
      margin-right: 0 !important;
      font-size: 11px !important;
      padding: 6px 8px !important;
      text-align: center !important;
   }
   .table-responsive { border: none !important; }
   .table-responsive table { min-width: 820px; }
}
@media (max-width: 480px) {
   .box-header .box-tools .btn {
      flex: 1 1 100% !important;
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
      $current_status = $this->input->get('status');
   ?>

   <!-- 4 Interactive Clickable KPI Cards -->
   <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-6">
         <div class="kpi-card <?= ($current_status == 'lunas' || $current_status == 'tempo') ? 'active-kpi' : (empty($current_status) ? '' : ''); ?>"
              onclick="window.location.href='<?= site_url('administrator/sales_order'); ?>';"
              role="button" tabindex="0" title="Klik untuk menampilkan SEMUA pesanan sales order">
            <div class="kpi-title">
               <span>Total Omset Penjualan</span>
               <?php if (empty($current_status)): ?>
                  <span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:9px;">SEMUA</span>
               <?php elseif ($current_status == 'lunas'): ?>
                  <span class="badge" style="background:#10b981; color:#fff; font-size:9px;">LUNAS</span>
               <?php elseif ($current_status == 'tempo'): ?>
                  <span class="badge" style="background:#ef4444; color:#fff; font-size:9px;">TEMPO</span>
               <?php endif; ?>
            </div>
            <div class="kpi-value">Rp <?= number_format($stats['total_omset_all'] ?? $stats['penjualan_bulan_ini'] ?? 0, 0, ',', '.'); ?></div>
            <div class="kpi-sub" style="font-size:11px; margin-top:4px;">
               <span class="kpi-pill-badge" 
                     onclick="event.stopPropagation(); window.location.href='<?= $current_status == 'lunas' ? site_url('administrator/sales_order') : site_url('administrator/sales_order?status=lunas'); ?>';"
                     style="background:<?= $current_status == 'lunas' ? '#10b981' : '#f0fdf4'; ?>; color:<?= $current_status == 'lunas' ? '#fff' : '#15803d'; ?>; border:1px solid #bbf7d0;"
                     title="Klik untuk filter data khusus pesanan LUNAS">
                  <i class="fa fa-check-circle"></i> Lunas: Rp <?= number_format($stats['terbayar_lunas'] ?? 0, 0, ',', '.'); ?>
               </span> | 
               <span class="kpi-pill-badge" 
                     onclick="event.stopPropagation(); window.location.href='<?= $current_status == 'tempo' ? site_url('administrator/sales_order') : site_url('administrator/sales_order?status=tempo'); ?>';"
                     style="background:<?= $current_status == 'tempo' ? '#ef4444' : '#fef2f2'; ?>; color:<?= $current_status == 'tempo' ? '#fff' : '#b91c1c'; ?>; border:1px solid #fecaca;"
                     title="Klik untuk filter data khusus pesanan TEMPO (Unpaid)">
                  <i class="fa fa-clock-o"></i> Tempo: Rp <?= number_format($stats['piutang_unpaid'] ?? 0, 0, ',', '.'); ?>
               </span>
            </div>
            <i class="fa fa-line-chart kpi-icon text-info"></i>
         </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-6">
         <div class="kpi-card orange <?= $current_status == 'aktif' ? 'active-kpi' : ''; ?>"
              onclick="window.location.href='<?= $current_status == 'aktif' ? site_url('administrator/sales_order') : site_url('administrator/sales_order?status=aktif'); ?>';"
              role="button" tabindex="0" title="Klik untuk masuk ke filter Pesanan Aktif (Draft, Baru Masuk)">
            <div class="kpi-title">
               <span>Pesanan Aktif</span>
               <?php if ($current_status == 'aktif'): ?>
                  <span class="badge" style="background:#f59e0b; color:#fff; font-size:9px;">AKTIF</span>
               <?php endif; ?>
            </div>
            <div class="kpi-value"><?= $stats['pesanan_aktif'] ?? 0; ?> <small style="font-size:14px;">Order</small></div>
            <div class="kpi-sub"><i class="fa fa-clock-o"></i> Draft / Baru Masuk</div>
            <i class="fa fa-shopping-cart kpi-icon text-warning"></i>
         </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-6">
         <div class="kpi-card green <?= $current_status == 'proses' ? 'active-kpi' : ''; ?>"
              onclick="window.location.href='<?= $current_status == 'proses' ? site_url('administrator/sales_order') : site_url('administrator/sales_order?status=proses'); ?>';"
              role="button" tabindex="0" title="Klik untuk masuk ke filter Proses Gudang & Pengiriman (Packing, Shipped)">
            <div class="kpi-title">
               <span>Proses Gudang &amp; Kirim</span>
               <?php if ($current_status == 'proses'): ?>
                  <span class="badge" style="background:#00a65a; color:#fff; font-size:9px;">AKTIF</span>
               <?php endif; ?>
            </div>
            <div class="kpi-value"><?= ($stats['proses_gudang'] ?? 0) + ($stats['siap_kirim'] ?? 0); ?> <small style="font-size:14px;">Order</small></div>
            <div class="kpi-sub"><i class="fa fa-truck"></i> Packing &amp; Pengiriman</div>
            <i class="fa fa-truck kpi-icon text-success"></i>
         </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-6">
         <div class="kpi-card purple <?= $current_status == 'selesai' ? 'active-kpi' : ''; ?>"
              onclick="window.location.href='<?= $current_status == 'selesai' ? site_url('administrator/sales_order') : site_url('administrator/sales_order?status=selesai'); ?>';"
              role="button" tabindex="0" title="Klik untuk masuk ke filter Pesanan Selesai (Delivered, Selesai)">
            <div class="kpi-title">
               <span>Pesanan Selesai</span>
               <?php if ($current_status == 'selesai'): ?>
                  <span class="badge" style="background:#605ca8; color:#fff; font-size:9px;">AKTIF</span>
               <?php endif; ?>
            </div>
            <div class="kpi-value"><?= $stats['pesanan_terkirim'] ?? 0; ?> <small style="font-size:14px;">Order</small></div>
            <div class="kpi-sub"><i class="fa fa-check-circle"></i> Delivered / Selesai</div>
            <i class="fa fa-check-square-o kpi-icon text-purple"></i>
         </div>
      </div>
   </div>

   <!-- Active Filter Indicator Banner -->
   <?php if (!empty($current_status)): 
      $filter_titles = [
         'aktif'     => ['title' => 'Pesanan Aktif (Draft / Baru Masuk)', 'color' => '#f59e0b', 'icon' => 'fa-shopping-cart'],
         'proses'    => ['title' => 'Proses Gudang & Kirim (Packing / Dalam Pengiriman)', 'color' => '#00a65a', 'icon' => 'fa-truck'],
         'selesai'   => ['title' => 'Pesanan Selesai (Delivered / Selesai)', 'color' => '#605ca8', 'icon' => 'fa-check-circle'],
         'lunas'     => ['title' => 'Pesanan Terbayar (Lunas)', 'color' => '#00a65a', 'icon' => 'fa-money'],
         'tempo'     => ['title' => 'Pesanan Belum Lunas (Piutang Tempo)', 'color' => '#dd4b39', 'icon' => 'fa-clock-o'],
         'draft'     => ['title' => 'Status: Draft', 'color' => '#f39c12', 'icon' => 'fa-file-text-o'],
         'confirmed' => ['title' => 'Status: Terkonfirmasi', 'color' => '#00c0ef', 'icon' => 'fa-check'],
         'packing'   => ['title' => 'Status: Sedang Dikemas (Packing)', 'color' => '#3c8dbc', 'icon' => 'fa-archive'],
         'shipped'   => ['title' => 'Status: Dalam Pengiriman (Shipped)', 'color' => '#00a65a', 'icon' => 'fa-truck'],
         'delivered' => ['title' => 'Status: Delivered (Selesai)', 'color' => '#605ca8', 'icon' => 'fa-check-square-o'],
         'cancelled' => ['title' => 'Status: Dibatalkan', 'color' => '#dd4b39', 'icon' => 'fa-times-circle'],
      ];
      $f_info = $filter_titles[$current_status] ?? ['title' => 'Status: ' . strtoupper($current_status), 'color' => '#3c8dbc', 'icon' => 'fa-filter'];
   ?>
   <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:4px solid <?= $f_info['color']; ?>; border-radius:8px; padding:12px 18px; margin-bottom:18px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
      <div style="display:flex; align-items:center; gap:12px;">
         <span style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:50%; background:<?= $f_info['color']; ?>18; color:<?= $f_info['color']; ?>; font-size:15px;">
            <i class="fa <?= $f_info['icon']; ?>"></i>
         </span>
         <div>
            <div style="font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700;">Menampilkan Filter Kartu:</div>
            <div style="font-size:14px; font-weight:700; color:#1e293b;">
               <?= $f_info['title']; ?> 
               <span class="badge" style="background:<?= $f_info['color']; ?>; font-size:11px; margin-left:6px;"><?= number_format($so_counts); ?> Order Ditemukan</span>
            </div>
         </div>
      </div>
      <div>
         <a href="<?= site_url('administrator/sales_order'); ?>" class="btn btn-default btn-sm btn-flat" style="border-radius:5px; font-weight:600; color:#475569;">
            <i class="fa fa-times text-danger"></i> Reset / Tampilkan Semua Pesanan
         </a>
      </div>
   </div>
   <?php endif; ?>

   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary" style="border-radius:6px; border-top: 3px solid #3c8dbc;">
            <div class="box-header with-border" style="padding: 15px 20px;">
               <h3 class="box-title" style="font-weight:600;"><i class="fa fa-list-alt text-primary"></i> Daftar Dokumen Penjualan</h3>
               <div class="box-tools pull-right">
                  <a href="<?= site_url('administrator/penjualan_marketplace'); ?>" class="btn btn-info btn-sm btn-flat" style="margin-right:5px; border-radius:4px; font-weight:600;">
                     <i class="fa fa-shopping-bag"></i> Penjualan Register All (Marketplace)
                  </a>
                  <?php if (is_allowed('pelanggan_list', false)): ?>
                     <a href="<?= site_url('administrator/pelanggan'); ?>" class="btn btn-default btn-sm btn-flat" style="margin-right:5px; border-radius:4px;">
                        <i class="fa fa-users"></i> Data Pelanggan
                     </a>
                  <?php endif; ?>
                  <?php if (is_allowed('sales_order_add', false)): ?>
                      <a href="<?= site_url('administrator/sales_order/cepat'); ?>" class="btn btn-success btn-sm btn-flat" style="margin-right:5px; border-radius:4px; font-weight:700; background:#059669; border-color:#047857; box-shadow:0 2px 6px rgba(5,150,105,0.3);">
                         <i class="fa fa-bolt"></i> ⚡ Penjualan Cepat (POS)
                      </a>
                      <a href="<?= site_url('administrator/sales_order/add'); ?>" class="btn btn-primary btn-sm btn-flat" style="border-radius:4px; font-weight:600; background:#2563eb; border-color:#1d4ed8;">
                         <i class="fa fa-plus-circle"></i> + Tambah Penjualan
                      </a>
                  <?php endif; ?>
               </div>
            </div>

            <div class="box-body" style="padding: 20px;">
               <!-- Clean Filter Bar -->
               <div class="clean-filter-box">
                  <form action="<?= base_url('administrator/sales_order/index'); ?>" method="GET">
                     <div class="row">
                        <div class="col-md-3 col-sm-6">
                           <label class="text-muted" style="font-size:12px;">Pelanggan:</label>
                           <select class="form-control chosen" name="pelanggan_id">
                              <option value="">-- Semua Pelanggan --</option>
                              <?php foreach($pelanggans as $p): ?>
                              <option value="<?= $p->id; ?>" <?= $this->input->get('pelanggan_id') == $p->id ? 'selected':''; ?>><?= _ent($p->nama_pelanggan); ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <label class="text-muted" style="font-size:12px;">Filter Status:</label>
                           <select class="form-control" name="status" style="border-radius:4px;">
                              <option value="">-- Semua Status --</option>
                              <option value="aktif" <?= $current_status == 'aktif' ? 'selected' : ''; ?>>🟡 Pesanan Aktif (Draft / Baru Masuk)</option>
                              <option value="proses" <?= $current_status == 'proses' ? 'selected' : ''; ?>>📦 Proses Gudang &amp; Kirim (Packing / Shipped)</option>
                              <option value="selesai" <?= $current_status == 'selesai' ? 'selected' : ''; ?>>🟢 Pesanan Selesai (Delivered)</option>
                              <option value="lunas" <?= $current_status == 'lunas' ? 'selected' : ''; ?>>💵 Pembayaran Lunas (Paid)</option>
                              <option value="tempo" <?= $current_status == 'tempo' ? 'selected' : ''; ?>>⏰ Pembayaran Tempo (Unpaid)</option>
                              <option value="draft" <?= $current_status == 'draft' ? 'selected' : ''; ?>>Draft</option>
                              <option value="confirmed" <?= $current_status == 'confirmed' ? 'selected' : ''; ?>>Terkonfirmasi</option>
                              <option value="packing" <?= $current_status == 'packing' ? 'selected' : ''; ?>>Sedang Dikemas (Packing)</option>
                              <option value="shipped" <?= $current_status == 'shipped' ? 'selected' : ''; ?>>Dalam Pengiriman (Shipped)</option>
                              <option value="delivered" <?= $current_status == 'delivered' ? 'selected' : ''; ?>>Selesai (Delivered)</option>
                              <option value="cancelled" <?= $current_status == 'cancelled' ? 'selected' : ''; ?>>Dibatalkan</option>
                           </select>
                        </div>
                        <div class="col-md-2 col-sm-6">
                           <label class="text-muted" style="font-size:12px;">Saluran / Channel:</label>
                           <select class="form-control" name="source" style="border-radius:4px;">
                              <option value="">-- Semua Saluran --</option>
                              <option value="pos" <?= $this->input->get('source') == 'pos' ? 'selected' : ''; ?>>⚡ POS Kasir (Cepat)</option>
                              <option value="manual" <?= $this->input->get('source') == 'manual' ? 'selected' : ''; ?>>🏢 Regular (B2B Offline)</option>
                              <option value="excel_import" <?= $this->input->get('source') == 'excel_import' ? 'selected' : ''; ?>>🛍️ Marketplace (Shopee/Online)</option>
                           </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <label class="text-muted" style="font-size:12px;">Cari No SO / Nama:</label>
                           <input type="text" class="form-control" name="q" placeholder="Ketik No. SO / Nama..." value="<?= _ent($this->input->get('q')); ?>">
                        </div>
                        <div class="col-md-1 col-sm-6" style="padding-top: 23px;">
                           <button type="submit" class="btn btn-primary btn-flat btn-block" style="border-radius:4px;" title="Cari Data"><i class="fa fa-search"></i></button>
                        </div>
                     </div>
                  </form>
               </div>

               <div class="table-responsive" style="overflow-x: auto; min-height: 250px;">
                  <table class="table table-hover table-striped table-bordered" style="vertical-align: middle; margin-bottom: 0;">
                     <thead>
                        <tr style="background:#f8fafc; font-size:12px; color:#555;">
                           <th width="40" class="text-center">No</th>
                           <th width="170">No. Sales Order</th>
                           <th>Tanggal SO</th>
                           <th>Pelanggan & Tier</th>
                           <th class="text-right">Grand Total (Rp)</th>
                           <th class="text-center">Status Pesanan</th>
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
                                  <?php elseif ($so->source == 'excel_import' || (!empty($so->no_pesanan) && $so->source != 'manual')): ?>
                                     <span class="label" style="background:#fff2ee; color:#ee4d2d; border:1px solid #ffccbe; font-size:9.5px; padding:2px 5px; border-radius:3px;">
                                        <i class="fa fa-shopping-bag"></i> Marketplace (Shopee)
                                     </span>
                                  <?php else: ?>
                                     <span class="label" style="background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; font-size:9.5px; padding:2px 5px; border-radius:3px;">
                                        <i class="fa fa-building-o"></i> Penjualan Regular (B2B)
                                     </span>
                                  <?php endif; ?>
                              </td>
                              <td><i class="fa fa-calendar text-muted"></i> <?= date('d/m/Y', strtotime($so->tanggal_so)); ?></td>
                               <td>
                                  <?php
                                     $customer_name = !empty($so->nama_pelanggan) 
                                         ? $so->nama_pelanggan 
                                         : (!empty($so->nama_penerima) 
                                             ? $so->nama_penerima 
                                             : (!empty($so->username_pembeli) 
                                                 ? $so->username_pembeli 
                                                 : (!empty($so->no_telepon) 
                                                     ? $so->no_telepon 
                                                     : 'Pelanggan Umum')));
                                     $customer_phone = !empty($so->no_telepon) ? $so->no_telepon : ($so->telp_pelanggan ?? '');
                                  ?>
                                  <strong style="color:#1e293b; font-size:13px;"><?= _ent($customer_name); ?></strong>
                                  <?php if (!empty($so->username_pembeli) && $so->username_pembeli != $customer_name): ?>
                                     <small class="text-muted">(@<?= _ent($so->username_pembeli); ?>)</small>
                                  <?php endif; ?>
                                  <br>
                                  <small>
                                     <span class="label label-info" style="font-size:9px; font-weight:600;"><?= strtoupper(_ent($so->tipe_pelanggan ?? 'RETAIL')); ?></span>
                                     <?php if (!empty($customer_phone)): ?>
                                        <span class="text-muted" style="font-size:11px; margin-left:4px;"><i class="fa fa-phone"></i> <?= _ent($customer_phone); ?></span>
                                     <?php endif; ?>
                                  </small>
                               </td>
                               <td class="text-right"><strong class="text-success" style="font-size:13px;">Rp <?= number_format($so->total, 0, ',', '.'); ?></strong></td>
                               <td class="text-center">
                                  <span class="label <?= isset($status_color[$so->status]) ? $status_color[$so->status] : 'label-default'; ?>" style="font-size:11px; padding:4px 8px; display:inline-block;">
                                     <?= isset($status_display[$so->status]) ? $status_display[$so->status] : strtoupper($so->status); ?>
                                  </span>

                                  <?php if (is_allowed('sales_order_update', false)): ?>
                                  <div class="dropdown" style="margin-top:4px;">
                                     <button class="btn btn-xs btn-default dropdown-toggle" type="button" data-toggle="dropdown" style="font-size:10px; padding:2px 7px; border-radius:3px;">
                                        <i class="fa fa-refresh text-primary"></i> Ubah Status <span class="caret"></span>
                                     </button>
                                     <ul class="dropdown-menu dropdown-menu-right" style="font-size:11px; text-align:left; min-width:210px; box-shadow:0 4px 15px rgba(0,0,0,0.15);">
                                        <li class="dropdown-header" style="font-weight:700; color:#475569;">Progres Status Berkala:</li>
                                        <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=draft'); ?>">🟡 1. DRAFT (Pesanan Baru)</a></li>
                                        <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=confirmed'); ?>">🔵 2. TERKONFIRMASI (Stok Ready)</a></li>
                                        <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=packing'); ?>">📦 3. SEDANG DIKEMAS (Packing)</a></li>
                                        <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=shipped'); ?>">🚚 4. DALAM PENGIRIMAN (Shipped)</a></li>
                                        <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=delivered'); ?>">🟢 5. PESANAN SELESAI (Delivered)</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=cancelled'); ?>" class="text-danger"><i class="fa fa-times-circle"></i> Dibatalkan</a></li>
                                     </ul>
                                  </div>
                                  <?php endif; ?>
                               </td>
                              <td class="text-center" style="vertical-align: middle;">
                                 <?php
                                    $is_pos = ($so->source == 'pos' || strpos((string)$so->catatan, '[POS CEPAT') !== false);
                                    $is_mp  = ($so->source == 'excel_import' || (!empty($so->no_pesanan) && $so->source != 'manual'));
                                    
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
                                 <a href="<?= site_url('administrator/sales_order/cetak/' . $so->id); ?>" target="_blank" class="btn btn-info btn-xs" title="Cetak PDF"><i class="fa fa-print"></i></a>
                                 
                                 <?php if ($so->status == 'draft' && is_allowed('sales_order_update', false)): ?>
                                 <a href="<?= site_url('administrator/sales_order/edit/'.$so->id); ?>" class="btn btn-warning btn-xs" title="Edit Order"><i class="fa fa-edit"></i></a>
                                 <a href="<?= site_url('administrator/sales_order/konfirmasi/' . $so->id); ?>" class="btn btn-primary btn-xs" title="Konfirmasi Order"><i class="fa fa-check"></i></a>
                                 <?php endif; ?>

                                 <?php 
                                 $linked_inv = $this->db->get_where('invoice', ['so_id' => $so->id])->row();
                                 if ($linked_inv): 
                                 ?>
                                    <a href="<?= site_url('administrator/invoice/view/' . $linked_inv->id); ?>" class="btn btn-info btn-xs" title="Lihat Invoice <?= _ent($linked_inv->nomor_invoice); ?>"><i class="fa fa-file-text-o"></i> <?= _ent($linked_inv->nomor_invoice); ?></a>
                                 <?php elseif (in_array($so->status, ['confirmed', 'processing', 'approved']) && is_allowed('invoice_add', false)): ?>
                                    <a href="<?= site_url('administrator/invoice/from_so/' . $so->id); ?>" class="btn btn-success btn-xs" title="Terbitkan Invoice"><i class="fa fa-file-text-o"></i> Invoice</a>
                                 <?php endif; ?>

                                 <?php if (is_allowed('sales_order_delete', false) && $so->status == 'draft'): ?>
                                 <a href="javascript:void(0);" data-href="<?= site_url('administrator/sales_order/delete/' . $so->id); ?>" class="btn btn-danger btn-xs remove-data" title="Hapus"><i class="fa fa-trash"></i></a>
                                 <?php endif; ?>
                              </td>
                           </tr>
                           <?php endforeach; ?>
                         <?php else: ?>
                            <tr>
                               <td colspan="8" class="text-center text-muted" style="padding:40px;">
                                  <i class="fa fa-shopping-cart fa-3x" style="color:#cbd5e1; margin-bottom:10px;"></i><br>
                                  <span style="font-size:16px; font-weight:600; color:#475569;">Tidak ada data Sales Order Offline untuk filter ini.</span><br>
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
                     <span class="text-muted">Total: <strong><?= $so_counts; ?></strong> Sales Order</span>
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
   $('.remove-data').click(function(){
      var url = $(this).attr('data-href');
      swal({
         title: "Hapus Sales Order?",
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
