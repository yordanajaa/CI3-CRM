<style>
@keyframes pelangganFadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}

.small-box {
  border-radius: 12px !important;
  box-shadow: 0 4px 16px rgba(0,0,0,0.04) !important;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  animation: pelangganFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.small-box:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.08) !important;
}

.box-primary, .nav-tabs-custom {
  border-radius: 12px !important;
  box-shadow: 0 4px 18px rgba(0,0,0,0.04) !important;
  animation: pelangganFadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.table-responsive { -webkit-overflow-scrolling: touch; }

/* Desktop KPI Row */
.pv-kpi-row {
  display: flex;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}
.pv-kpi-col-lifetime,
.pv-kpi-col-sub {
  position: relative;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
}
@media (min-width: 992px) {
  .pv-kpi-col-lifetime,
  .pv-kpi-col-sub {
    width: 33.33333333%;
    float: left;
  }
}
@media (min-width: 768px) and (max-width: 991px) {
  .pv-kpi-col-lifetime,
  .pv-kpi-col-sub {
    width: 50%;
    float: left;
  }
}

/* Profile Box Header & Action Toolbar */
.profile-box-header {
  position: relative !important;
  padding: 16px 18px 14px 18px !important;
  background: #ffffff !important;
  border-bottom: 1px solid #f1f5f9 !important;
}
.profile-header-row {
  display: flex !important;
  justify-content: space-between !important;
  align-items: center !important;
  width: 100% !important;
  margin-bottom: 12px !important;
  gap: 12px !important;
}
.profile-header-title {
  font-size: 16px !important;
  font-weight: 700 !important;
  margin: 0 !important;
  color: #1e293b !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 8px !important;
}
.profile-actions-bar {
  position: static !important;
  float: none !important;
  display: flex !important;
  flex-wrap: wrap !important;
  gap: 6px !important;
  align-items: center !important;
  width: 100% !important;
}
.profile-actions-bar .btn,
.profile-header-row .btn-kembali {
  border-radius: 6px !important;
  font-weight: 600 !important;
  font-size: 11.5px !important;
  padding: 6px 11px !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 5px !important;
  box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
  line-height: 1.2 !important;
}
.profile-actions-bar .btn:hover,
.profile-header-row .btn-kembali:hover {
  transform: translateY(-1px) !important;
  box-shadow: 0 3px 8px rgba(0,0,0,0.08) !important;
}
.profile-actions-bar .btn-add-so {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
  border: 1px solid #059669 !important;
  color: #ffffff !important;
  font-weight: 700 !important;
}
.profile-actions-bar .btn-crm {
  background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
  border: 1px solid #0284c7 !important;
  color: #ffffff !important;
}
.profile-actions-bar .btn-followup {
  background: #f0fdf4 !important;
  border: 1px solid #bbf7d0 !important;
  color: #166534 !important;
}
.profile-actions-bar .btn-followup:hover {
  background: #dcfce7 !important;
  border-color: #86efac !important;
}
.profile-actions-bar .btn-edit {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
  border: 1px solid #d97706 !important;
  color: #ffffff !important;
}
.profile-header-row .btn-kembali {
  background: #f8fafc !important;
  border: 1px solid #cbd5e1 !important;
  color: #475569 !important;
}
.profile-header-row .btn-kembali:hover {
  background: #e2e8f0 !important;
  color: #0f172a !important;
}

/* Profile Table */
.table-profile {
  margin-bottom: 0 !important;
  border: 1px solid #f1f5f9 !important;
}
.table-profile tr th {
  background-color: #f8fafc !important;
  color: #475569 !important;
  font-weight: 600 !important;
  font-size: 12.5px !important;
  border-top: 1px solid #f1f5f9 !important;
  padding: 10px 12px !important;
  vertical-align: middle !important;
}
.table-profile tr td {
  color: #0f172a !important;
  font-size: 13px !important;
  border-top: 1px solid #f1f5f9 !important;
  padding: 10px 12px !important;
  vertical-align: middle !important;
}

/* Mobile Specific Optimizations */
@media (max-width: 767px) {
  .content-header > h1 {
    font-size: 19px !important;
    line-height: 1.3 !important;
  }
  .content-header > h1 small {
    display: block !important;
    margin-top: 4px !important;
    font-size: 13px !important;
    color: #475569 !important;
  }
  .content-header > .breadcrumb {
    position: static !important;
    float: none !important;
    padding: 6px 0 12px 0 !important;
    background: transparent !important;
    font-size: 11.5px !important;
  }

  /* Compact 2-column KPI Grid on Mobile */
  .pv-kpi-row {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 8px !important;
    margin: 0 0 14px 0 !important;
  }
  .pv-kpi-col-lifetime {
    grid-column: span 2 !important;
    width: 100% !important;
    padding: 0 !important;
    float: none !important;
  }
  .pv-kpi-col-sub {
    width: 100% !important;
    padding: 0 !important;
    float: none !important;
  }
  .small-box {
    margin-bottom: 0 !important;
    border-radius: 8px !important;
  }
  .small-box .inner {
    padding: 10px 12px !important;
  }
  .small-box h3 {
    font-size: 18px !important;
    margin: 0 0 2px 0 !important;
    font-weight: 700 !important;
  }
  .small-box p {
    font-size: 10.5px !important;
    margin: 0 !important;
    line-height: 1.3 !important;
  }
  .small-box .icon {
    display: none !important;
  }

  /* Profile Header & Action Toolbar on Mobile */
  .profile-box-header {
    padding: 12px 14px !important;
  }
  .profile-header-row {
    margin-bottom: 10px !important;
  }
  .profile-header-title {
    font-size: 14.5px !important;
  }
  .profile-header-row .btn-kembali {
    padding: 5px 8px !important;
    font-size: 11px !important;
  }
  .profile-actions-bar {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 6px !important;
    width: 100% !important;
  }
  .profile-actions-bar .btn {
    width: 100% !important;
    text-align: center !important;
    justify-content: center !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 5px !important;
    padding: 8px 8px !important;
    font-size: 11px !important;
    margin: 0 !important;
  }
  .profile-actions-bar .btn-add-so {
    grid-column: span 2 !important;
    padding: 9px 12px !important;
    font-size: 12px !important;
    font-weight: 700 !important;
  }

  /* Profile Table on Mobile */
  .table-profile th {
    width: 38% !important;
    font-size: 11.5px !important;
    color: #64748b !important;
    padding: 8px 6px !important;
    vertical-align: middle !important;
  }
  .table-profile td {
    font-size: 12.5px !important;
    padding: 8px 6px !important;
    word-break: break-word !important;
    vertical-align: middle !important;
  }

  /* Tab Navigation touch scroll */
  .nav-tabs-custom > .nav-tabs {
    display: flex !important;
    overflow-x: auto !important;
    white-space: nowrap !important;
    -webkit-overflow-scrolling: touch !important;
    border-bottom: 2px solid #e2e8f0 !important;
  }
  .nav-tabs-custom > .nav-tabs > li {
    flex-shrink: 0 !important;
    float: none !important;
    display: inline-block !important;
  }
  .nav-tabs-custom > .nav-tabs > li > a {
    padding: 9px 12px !important;
    font-size: 11.5px !important;
  }

  /* Tab Tables */
  .tab-pane .table-responsive {
    border: none !important;
  }
  .tab-pane table th {
    font-size: 11px !important;
    padding: 7px 6px !important;
    white-space: nowrap !important;
  }
  .tab-pane table td {
    font-size: 11.5px !important;
    padding: 7px 6px !important;
  }
}
</style>

<section class="content-header">
   <h1>Detail &amp; Analisis Pelanggan <small><?= _ent($pelanggan->nama_pelanggan); ?></small></h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= base_url('administrator/pelanggan'); ?>">Pelanggan</a></li>
      <li class="active">Detail &amp; Analisis</li>
   </ol>
</section>

<section class="content">
   <!-- Top Analytics Summary Cards -->
   <div class="pv-kpi-row">
      <div class="pv-kpi-col-lifetime">
         <div class="small-box bg-aqua" style="border-radius:6px;">
            <div class="inner">
               <h3>Rp <?= number_format($total_volume, 0, ',', '.'); ?></h3>
               <p>Total Volume Transaksi (Lifetime)</p>
            </div>
            <div class="icon"><i class="fa fa-line-chart"></i></div>
         </div>
      </div>
      <div class="pv-kpi-col-sub">
         <div class="small-box bg-green" style="border-radius:6px;">
            <div class="inner">
               <h3><?= count($riwayat_so); ?> Kali</h3>
               <p>Frekuensi Pembelian Ulang</p>
            </div>
            <div class="icon"><i class="fa fa-refresh"></i></div>
         </div>
      </div>
      <div class="pv-kpi-col-sub">
         <div class="small-box bg-purple" style="border-radius:6px;">
            <div class="inner">
               <h3>Rp <?= number_format($pelanggan->limit_kredit, 0, ',', '.'); ?></h3>
               <p>Limit Kredit Belanja</p>
            </div>
            <div class="icon"><i class="fa fa-credit-card"></i></div>
         </div>
      </div>
   </div>

   <div class="row">
      <!-- Sisi Kiri: Profil Pelanggan -->
      <div class="col-md-5">
         <div class="box box-primary" style="border-radius:8px; overflow:hidden;">
            <div class="profile-box-header">
               <!-- Row 1: Judul Profil & Tombol Kembali -->
               <div class="profile-header-row">
                  <h3 class="profile-header-title">
                     <i class="fa fa-user-circle text-primary"></i> Informasi Profil Pelanggan
                  </h3>
                  <a href="<?= base_url('administrator/pelanggan'); ?>" class="btn btn-default btn-xs btn-kembali" title="Kembali ke Daftar Pelanggan">
                     <i class="fa fa-arrow-left"></i> Kembali
                  </a>
               </div>
               <!-- Row 2: Toolbar Aksi Cepat -->
               <div class="profile-actions-bar">
                  <?php is_allowed('sales_order_add', function() use ($pelanggan){ ?>
                     <a href="<?= site_url('administrator/sales_order/add?pelanggan_id='.$pelanggan->id); ?>" class="btn btn-success btn-xs btn-add-so" title="Buat Transaksi Penjualan Baru">
                        <i class="fa fa-shopping-cart"></i> + Transaksi Penjualan
                     </a>
                  <?php }); ?>
                  <?php 
                     $view_phone_clean = !empty($pelanggan->telepon) && $pelanggan->telepon !== '-' ? preg_replace('/[^0-9]/', '', $pelanggan->telepon) : (!empty($pelanggan->no_telp) && $pelanggan->no_telp !== '-' ? preg_replace('/[^0-9]/', '', $pelanggan->no_telp) : '');
                     if (!empty($view_phone_clean)): 
                  ?>
                     <a href="<?= site_url('administrator/crm/customer_summary?phone='.urlencode($view_phone_clean)); ?>" class="btn btn-info btn-xs btn-crm" title="Analisis RFM / CRM Pelanggan">
                        <i class="fa fa-line-chart"></i> RFM / CRM
                     </a>
                     <a href="<?= site_url('administrator/crm/journal_followup?phone='.urlencode($view_phone_clean)); ?>" class="btn btn-default btn-xs btn-followup" title="Jadwal & Riwayat Follow-Up">
                        <i class="fa fa-whatsapp text-success"></i> Follow-up
                     </a>
                  <?php endif; ?>
                  <?php is_allowed('pelanggan_update', function() use ($pelanggan){ ?>
                     <a href="<?= site_url('administrator/pelanggan/edit/'.$pelanggan->id); ?>" class="btn btn-warning btn-xs btn-edit" title="Edit Data Pelanggan">
                        <i class="fa fa-edit"></i> Edit
                     </a>
                  <?php }); ?>
               </div>
            </div>
            <div class="box-body" style="padding:15px;">
               <table class="table table-striped table-hover table-profile" style="margin-bottom:0;">
                  <tr><th width="35%">Kode Pelanggan</th><td><span class="label label-default" style="font-size:12px;"><?= _ent($pelanggan->kode_pelanggan); ?></span></td></tr>
                  <tr><th>Nama Pelanggan</th><td><strong><?= _ent($pelanggan->nama_pelanggan); ?></strong></td></tr>
                  <tr><th>Kategori</th><td>
                     <?php 
                     $src = strtolower($pelanggan->source ?? 'manual');
                     if ($src == 'resi' || $src == 'scan_resi' || $src == 'import_resi') {
                        echo '<span class="label" style="background:#0284c7; color:#ffffff; padding:4px 9px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-barcode"></i> Resi</span>';
                     } elseif ($src == 'demo' || $src == 'calon_customer' || strpos($src, 'demo') !== false) {
                        echo '<span class="label" style="background:#2563eb; color:#ffffff; padding:4px 8px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-user-plus"></i> Calon Demo</span>';
                     } elseif ($src == 'tiktok' || $src == 'tiktokshop' || $src == 'tiktok_shop' || $src == 'tiktok shop') {
                        echo '<span class="label" style="background:#0f172a; color:#ffffff; padding:4px 9px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-music" style="color:#22d3ee;"></i> TikTok Shop</span>';
                     } elseif ($src == 'shopee') {
                        echo '<span class="label" style="background:#ee4d2d; color:#ffffff; padding:4px 9px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-shopping-bag"></i> Shopee</span>';
                     } elseif ($src == 'tokopedia') {
                        echo '<span class="label" style="background:#03ac0e; color:#ffffff; padding:4px 9px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-shopping-cart"></i> Tokopedia</span>';
                     } else {
                        echo '<span class="label" style="background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; padding:4px 9px; border-radius:5px; font-weight:700; font-size:11px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-home text-muted"></i> Toko / Regular</span>';
                     }
                     ?>
                  </td></tr>
                  <tr><th>Kontak Person</th><td><?= _ent($pelanggan->kontak_person ?? '-'); ?></td></tr>
                  <tr>
                     <th>Telepon</th>
                     <td>
                        <?php 
                           $raw_pht = !empty($pelanggan->telepon) && $pelanggan->telepon !== '-' ? $pelanggan->telepon : (!empty($pelanggan->no_telp) && $pelanggan->no_telp !== '-' ? $pelanggan->no_telp : '-');
                           $is_masked_pht = strpos($raw_pht, '*') !== false;
                           $pht_digits = preg_replace('/[^0-9]/', '', $raw_pht);
                        ?>
                        <?php if (!empty($raw_pht) && $raw_pht !== '-'): ?>
                           <i class="fa fa-phone text-muted"></i> <?= _ent($raw_pht); ?>
                           <?php if ($is_masked_pht): ?>
                              <span class="label" style="background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1; font-size:10px; padding:2px 6px; border-radius:3px; margin-left:4px; font-weight:600;" title="Nomor disensor oleh marketplace untuk privasi pembeli">
                                 <i class="fa fa-shield"></i> Disensor Resi
                              </span>
                           <?php elseif (!empty($pht_digits) && strlen($pht_digits) >= 9): 
                              $wa_numt = (substr($pht_digits, 0, 1) === '0') ? ('62' . substr($pht_digits, 1)) : $pht_digits;
                              if (substr($wa_numt, 0, 2) !== '62') $wa_numt = '62' . $wa_numt;
                           ?>
                              <a href="https://wa.me/<?= $wa_numt; ?>" target="_blank" class="btn btn-xs btn-success" style="margin-left:6px; border-radius:3px; padding:1px 6px;" title="Hubungi via WhatsApp">
                                 <i class="fa fa-whatsapp"></i> Chat WA
                              </a>
                           <?php endif; ?>
                        <?php else: ?>
                           <span class="text-muted">-</span>
                        <?php endif; ?>
                     </td>
                  </tr>
                  <tr><th>Email</th><td><i class="fa fa-envelope text-muted"></i> <?= _ent($pelanggan->email ?? '-'); ?></td></tr>
                  <tr><th>Kota / Wilayah</th><td><?= _ent($pelanggan->kota ?? '-'); ?></td></tr>
                  <tr><th>Alamat Lengkap</th><td><?= nl2br(_ent($pelanggan->alamat ?? '-')); ?></td></tr>
                  <tr><th>NPWP</th><td><?= _ent($pelanggan->npwp ?? '-'); ?></td></tr>
                  <tr><th>Status</th><td><span class="label <?= $pelanggan->status == 'aktif' ? 'label-success' : 'label-danger'; ?>"><?= ucfirst($pelanggan->status); ?></span></td></tr>
               </table>
            </div>
         </div>
      </div>

      <!-- Sisi Kanan: Tab Riwayat Transaksi & Pembelian Ulang -->
      <div class="col-md-7">
         <div class="nav-tabs-custom" style="border-radius:6px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
            <ul class="nav nav-tabs">
               <li class="active"><a href="#tab_so" data-toggle="tab"><i class="fa fa-shopping-cart text-primary"></i> Riwayat Penjualan (<?= count($riwayat_so); ?>)</a></li>
               <li><a href="#tab_mp" data-toggle="tab"><i class="fa fa-globe text-info"></i> Riwayat Marketplace (<?= count($riwayat_mp); ?>)</a></li>
               <li><a href="#tab_invoice" data-toggle="tab"><i class="fa fa-file-text-o text-success"></i> Riwayat Invoice (<?= count($riwayat_invoice); ?>)</a></li>
            </ul>
            <div class="tab-content">
               <!-- Tab SO -->
               <div class="tab-pane active" id="tab_so">
                  <div class="table-responsive">
                     <table class="table table-bordered table-striped table-hover">
                        <thead>
                           <tr style="background:#f8fafc;">
                              <th>No. Transaksi Penjualan</th>
                              <th>Tanggal</th>
                              <th class="text-right">Total Transaksi</th>
                              <th class="text-center">Status Kirim</th>
                              <th class="text-center" width="80">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach($riwayat_so as $so): ?>
                           <tr>
                              <td><strong class="text-primary"><?= _ent($so->nomor_so); ?></strong></td>
                              <td><?= date('d/m/Y', strtotime($so->tanggal_so)); ?></td>
                              <td class="text-right"><strong>Rp <?= number_format($so->total, 0, ',', '.'); ?></strong></td>
                              <td class="text-center">
                                 <span class="label label-info"><?= strtoupper($so->status_kirim ?? 'DIPROSES'); ?></span>
                              </td>
                              <td class="text-center">
                                 <a href="<?= site_url('administrator/sales_order/view/'.$so->id); ?>" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> Detail</a>
                              </td>
                           </tr>
                           <?php endforeach; ?>
                           <?php if(empty($riwayat_so)): ?><tr><td colspan="5" class="text-center text-muted"><i class="fa fa-inbox"></i> Belum ada riwayat transaksi penjualan.</td></tr><?php endif; ?>
                        </tbody>
                     </table>
                  </div>
               </div>

               <!-- Tab Marketplace -->
               <div class="tab-pane" id="tab_mp">
                  <div class="table-responsive">
                     <table class="table table-bordered table-striped table-hover">
                        <thead>
                           <tr style="background:#f8fafc;">
                              <th>No. Pesanan</th>
                              <th>Marketplace</th>
                              <th>Tanggal</th>
                              <th class="text-right">Total Transaksi</th>
                              <th class="text-center">Status</th>
                              <th class="text-center" width="80">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach($riwayat_mp as $mp): ?>
                           <tr>
                              <td><strong class="text-info"><?= _ent(!empty($mp->no_pesanan) ? $mp->no_pesanan : ($mp->nomor_so ?? '-')); ?></strong></td>
                              <td><span class="badge bg-purple"><?= strtoupper(_ent($mp->source ?? 'Shopee')); ?></span></td>
                              <td><?= !empty($mp->tanggal_so) ? date('d/m/Y', strtotime($mp->tanggal_so)) : (!empty($mp->created_at) ? date('d/m/Y', strtotime($mp->created_at)) : '-'); ?></td>
                              <td class="text-right"><strong>Rp <?= number_format($mp->total, 0, ',', '.'); ?></strong></td>
                              <td class="text-center">
                                 <span class="label label-default"><?= strtoupper(_ent($mp->status_pesanan ?? ($mp->status ?? 'SELESAI'))); ?></span>
                              </td>
                              <td class="text-center">
                                 <a href="<?= site_url('administrator/penjualan_marketplace/view/'.$mp->id); ?>" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> Detail</a>
                              </td>
                           </tr>
                           <?php endforeach; ?>
                           <?php if(empty($riwayat_mp)): ?><tr><td colspan="6" class="text-center text-muted"><i class="fa fa-inbox"></i> Belum ada riwayat transaksi Marketplace untuk pelanggan ini.</td></tr><?php endif; ?>
                        </tbody>
                     </table>
                  </div>
               </div>

               <!-- Tab Invoice -->
               <div class="tab-pane" id="tab_invoice">
                  <div class="table-responsive">
                     <table class="table table-bordered table-striped table-hover">
                        <thead>
                           <tr style="background:#f8fafc;">
                              <th>No. Invoice</th>
                              <th>Tanggal</th>
                              <th class="text-right">Total Tagihan</th>
                              <th class="text-center">Status Bayar</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach($riwayat_invoice as $inv): ?>
                           <tr>
                              <td><strong class="text-success"><?= _ent($inv->nomor_invoice); ?></strong></td>
                              <td><?= date('d/m/Y', strtotime($inv->tanggal_invoice)); ?></td>
                              <td class="text-right"><strong>Rp <?= number_format($inv->total, 0, ',', '.'); ?></strong></td>
                              <td class="text-center">
                                 <span class="label <?= $inv->status == 'paid' ? 'label-success' : 'label-warning'; ?>"><?= strtoupper($inv->status); ?></span>
                              </td>
                           </tr>
                           <?php endforeach; ?>
                           <?php if(empty($riwayat_invoice)): ?><tr><td colspan="4" class="text-center text-muted"><i class="fa fa-inbox"></i> Belum ada riwayat Invoice.</td></tr><?php endif; ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
