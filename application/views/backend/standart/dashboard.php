<style>
/* ===== Dashboard Metafora - Modern & Unified Design System ===== */
.dash-section-title {
   font-size: 11.5px;
   font-weight: 800;
   color: #475569;
   letter-spacing: 0.8px;
   text-transform: uppercase;
   margin: 20px 0 14px;
   padding-left: 10px;
   border-left: 4px solid #2563eb;
   display: flex;
   align-items: center;
   gap: 6px;
}

/* Card Operasional / Utama */
.dash-card {
   border-radius: 10px;
   padding: 18px 20px;
   margin-bottom: 20px;
   color: #fff;
   position: relative;
   overflow: hidden;
   cursor: pointer;
   box-shadow: 0 4px 14px rgba(0,0,0,0.08);
   transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
   display: flex;
   flex-direction: column;
   justify-content: space-between;
   min-height: 122px;
}
.dash-card:hover {
   transform: translateY(-3px);
   box-shadow: 0 10px 24px rgba(0,0,0,0.18);
}
.dash-card .dc-label {
   font-size: 12px;
   font-weight: 700;
   text-transform: uppercase;
   letter-spacing: 0.5px;
   opacity: 0.95;
   margin-bottom: 2px;
}
.dash-card .dc-num {
   font-size: 30px;
   font-weight: 800;
   line-height: 1.1;
   margin: 2px 0 6px;
}
.dash-card .dc-sub {
   font-size: 11px;
   opacity: 0.9;
   margin-top: auto;
   display: flex;
   align-items: center;
   gap: 5px;
}
.dash-card .dc-icon {
   position: absolute;
   right: 18px;
   top: 50%;
   transform: translateY(-50%);
   font-size: 50px;
   opacity: 0.18;
   pointer-events: none;
}
.dash-card .dc-hint {
   font-size: 10.5px;
   font-weight: 600;
   opacity: 0.85;
   margin-top: 2px;
}

/* Gradients for Operations Cards */
.bg-card-blue    { background: linear-gradient(135deg, #1d4ed8, #3b82f6); }
.bg-card-emerald { background: linear-gradient(135deg, #047857, #10b981); }
.bg-card-orange  { background: linear-gradient(135deg, #c2410c, #ea580c); }
.bg-card-purple  { background: linear-gradient(135deg, #6d28d9, #8b5cf6); }

/* Master Data Cards (Selaras Menu Sidebar) */
.master-card {
   background: #ffffff;
   border: 1px solid #e2e8f0;
   border-radius: 10px;
   padding: 16px 18px;
   margin-bottom: 20px;
   box-shadow: 0 2px 6px rgba(0,0,0,0.03);
   transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
   cursor: pointer;
   display: flex;
   align-items: center;
   gap: 16px;
   position: relative;
   overflow: hidden;
}
.master-card:hover {
   transform: translateY(-3px);
   box-shadow: 0 8px 20px rgba(0,0,0,0.08);
   border-color: #cbd5e1;
}
.master-card .mc-icon-wrap {
   width: 50px;
   height: 50px;
   border-radius: 10px;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 22px;
   flex-shrink: 0;
}
.master-card .mc-info {
   flex: 1;
   min-width: 0;
}
.master-card .mc-label {
   font-size: 11.5px;
   font-weight: 700;
   color: #64748b;
   text-transform: uppercase;
   letter-spacing: 0.4px;
   margin-bottom: 2px;
}
.master-card .mc-num {
   font-size: 22px;
   font-weight: 800;
   color: #0f172a;
   line-height: 1.2;
}
.master-card .mc-sub {
   font-size: 11px;
   color: #94a3b8;
   margin-top: 2px;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
}
.master-card .mc-arrow {
   font-size: 13px;
   color: #cbd5e1;
   transition: transform 0.2s;
}
.master-card:hover .mc-arrow {
   transform: translateX(4px);
   color: #2563eb;
}

/* Master Data Icon Themes */
.theme-pelanggan .mc-icon-wrap { background: #e0f2fe; color: #0284c7; }
.theme-produk    .mc-icon-wrap { background: #fef3c7; color: #d97706; }
.theme-kategori  .mc-icon-wrap { background: #f3e8ff; color: #9333ea; }
.theme-satuan    .mc-icon-wrap { background: #dcfce7; color: #16a34a; }

/* Table Low Stock Box */
.low-stock-box {
   border-radius: 10px;
   box-shadow: 0 2px 10px rgba(0,0,0,0.05);
   border: 1px solid #e2e8f0;
   overflow: hidden;
   background: #fff;
}
.low-stock-box .box-header {
   background: #fefce8;
   border-bottom: 2px solid #eab308;
   padding: 14px 18px;
}
.low-stock-box .box-title {
   color: #854d0e;
   font-weight: 700;
   font-size: 15px;
}

@media (max-width: 767px) {
   .dash-card { padding: 14px 16px; margin-bottom: 12px; min-height: 106px; }
   .dash-card .dc-num { font-size: 24px; }
   .dash-card .dc-icon { font-size: 38px; right: 12px; }
   .master-card { padding: 12px 14px; margin-bottom: 10px; }
   .master-card .mc-icon-wrap { width: 42px; height: 42px; font-size: 18px; }
   .master-card .mc-num { font-size: 19px; }
   .dash-section-title { margin: 16px 0 10px; font-size: 11px; }
}
</style>

<section class="content-header">
    <h1>
        Dashboard Utama
        <small>Ringkasan Sistem &amp; Pemantauan Operasional Real-Time</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<section class="content">

    <!-- Section 1: Ringkasan Utama Bisnis & Operasional (4 Kolom Seragam) -->
    <p class="dash-section-title"><i class="fa fa-bolt text-primary"></i> Ringkasan Utama Operasional &amp; Transaksi</p>
    <div class="row">
       <!-- 1. Penjualan (Sales Order) -->
       <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="dash-card bg-card-blue" onclick="goUrl('administrator/sales_order')" title="Buka modul Transaksi Penjualan">
             <div>
                <div class="dc-label">Transaksi Penjualan</div>
                <div class="dc-num"><?= number_format($total_so ?? 0, 0, ',', '.'); ?></div>
             </div>
             <div>
                <div class="dc-sub"><i class="fa fa-file-text-o"></i> Total Pesanan Aktif</div>
                <div class="dc-hint">Klik untuk kelola &rarr;</div>
             </div>
             <div class="dc-icon"><i class="fa fa-shopping-cart"></i></div>
          </div>
       </div>

       <!-- 2. Stok Barang Tersedia -->
       <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="dash-card bg-card-emerald" onclick="goUrl('administrator/stok')" title="Buka Dashboard Stok Barang">
             <div>
                <div class="dc-label">Stok Barang Tersedia</div>
                <div class="dc-num"><?= number_format($total_stok ?? 0, 0, ',', '.'); ?> <small style="font-size:14px; font-weight:normal;">Unit</small></div>
             </div>
             <div>
                <div class="dc-sub"><i class="fa fa-database"></i> Fisik di Seluruh Lokasi</div>
                <div class="dc-hint">Klik untuk pantau stok &rarr;</div>
             </div>
             <div class="dc-icon"><i class="fa fa-cubes"></i></div>
          </div>
       </div>

       <!-- 3. Total Barang Terjual -->
       <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="dash-card bg-card-orange" onclick="goUrl('administrator/sales_order')" title="Buka Riwayat Penjualan">
             <div>
                <div class="dc-label">Total Barang Terjual</div>
                <div class="dc-num"><?= number_format($total_terjual ?? 0, 0, ',', '.'); ?> <small style="font-size:14px; font-weight:normal;">Unit</small></div>
             </div>
             <div>
                <div class="dc-sub"><i class="fa fa-check-circle"></i> Akumulasi Produk Terjual</div>
                <div class="dc-hint"><?= !empty($terjual_hari_ini) ? 'Hari ini: +' . number_format($terjual_hari_ini, 0, ',', '.') . ' Unit' : 'Seluruh Pesanan Valid'; ?> &rarr;</div>
             </div>
             <div class="dc-icon"><i class="fa fa-shopping-bag"></i></div>
          </div>
       </div>

       <!-- 4. Data Pelanggan -->
       <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="dash-card bg-card-purple" onclick="goUrl('administrator/pelanggan')" title="Buka Data Pelanggan">
             <div>
                <div class="dc-label">Data Pelanggan</div>
                <div class="dc-num"><?= number_format($total_pelanggan ?? 0, 0, ',', '.'); ?></div>
             </div>
             <div>
                <div class="dc-sub"><i class="fa fa-users"></i> Pelanggan Aktif Terdaftar</div>
                <div class="dc-hint">Klik untuk kelola &rarr;</div>
             </div>
             <div class="dc-icon"><i class="fa fa-address-book"></i></div>
          </div>
       </div>
    </div>

    <!-- Section 2: Ringkasan Master Data (Selaras 100% dengan Menu Sidebar Image 2) -->
    <p class="dash-section-title"><i class="fa fa-database text-primary"></i> Ringkasan Master Data</p>
    <div class="row">
       <!-- 1. Pelanggan -->
       <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="master-card theme-pelanggan" onclick="goUrl('administrator/pelanggan')" title="Buka Master Data Pelanggan">
             <div class="mc-icon-wrap"><i class="fa fa-users"></i></div>
             <div class="mc-info">
                <div class="mc-label">Pelanggan</div>
                <div class="mc-num"><?= number_format($total_pelanggan ?? 0, 0, ',', '.'); ?></div>
                <div class="mc-sub">Profil &amp; Limit Kredit</div>
             </div>
             <div class="mc-arrow"><i class="fa fa-chevron-right"></i></div>
          </div>
       </div>

       <!-- 2. Produk -->
       <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="master-card theme-produk" onclick="goUrl('administrator/produk')" title="Buka Master Data Produk">
             <div class="mc-icon-wrap"><i class="fa fa-cube"></i></div>
             <div class="mc-info">
                <div class="mc-label">Produk</div>
                <div class="mc-num"><?= number_format($total_produk ?? 0, 0, ',', '.'); ?></div>
                <div class="mc-sub">Katalog &amp; Master Harga</div>
             </div>
             <div class="mc-arrow"><i class="fa fa-chevron-right"></i></div>
          </div>
       </div>

       <!-- 3. Kategori Barang -->
       <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="master-card theme-kategori" onclick="goUrl('administrator/kategori_produk')" title="Buka Master Data Kategori Barang">
             <div class="mc-icon-wrap"><i class="fa fa-tags"></i></div>
             <div class="mc-info">
                <div class="mc-label">Kategori Barang</div>
                <div class="mc-num"><?= number_format($total_kategori ?? 0, 0, ',', '.'); ?></div>
                <div class="mc-sub">Klasifikasi Jenis Produk</div>
             </div>
             <div class="mc-arrow"><i class="fa fa-chevron-right"></i></div>
          </div>
       </div>

       <!-- 4. Unit Barang -->
       <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="master-card theme-satuan" onclick="goUrl('administrator/satuan')" title="Buka Master Data Unit Barang">
             <div class="mc-icon-wrap"><i class="fa fa-balance-scale"></i></div>
             <div class="mc-info">
                <div class="mc-label">Unit Barang</div>
                <div class="mc-num"><?= number_format($total_satuan ?? 0, 0, ',', '.'); ?></div>
                <div class="mc-sub">Standar Satuan Produk</div>
             </div>
             <div class="mc-arrow"><i class="fa fa-chevron-right"></i></div>
          </div>
       </div>
    </div>

    <!-- Section 3: Peringatan Stok Minimum -->
    <p class="dash-section-title"><i class="fa fa-exclamation-triangle text-warning"></i> Peringatan Stok Minimum</p>
    <div class="row">
       <div class="col-md-12">
          <div class="box low-stock-box">
             <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-warning text-warning"></i> Peringatan Stok Minimum (Perlu Restok Segera)</h3>
                <div class="box-tools pull-right">
                   <?php if (!empty($low_stocks)): ?>
                      <span class="label label-danger" style="font-size:11.5px; padding:5px 12px; border-radius:4px; font-weight:700;">
                         <i class="fa fa-exclamation-circle"></i> <?= count($low_stocks); ?> Produk Kritis
                      </span>
                   <?php else: ?>
                      <span class="label label-success" style="font-size:11.5px; padding:5px 12px; border-radius:4px; font-weight:700;">
                         <i class="fa fa-check-circle"></i> Seluruh Stok Aman
                      </span>
                   <?php endif; ?>
                   <a href="<?= site_url('administrator/stok'); ?>" class="btn btn-sm btn-default" style="margin-left:8px; border-radius:4px; font-weight:600;">
                      <i class="fa fa-database text-primary"></i> Lihat Semua Stok Barang
                   </a>
                </div>
             </div>
             <div class="box-body" style="padding:0;">
                <?php if (!empty($low_stocks)): ?>
                   <div class="table-responsive">
                      <table class="table table-striped table-hover" style="margin-bottom:0;">
                         <thead>
                            <tr style="background:#f8fafc; font-size:12px; color:#475569;">
                               <th class="text-center" width="45">No</th>
                               <th width="140">Kode Produk</th>
                               <th>Nama Produk</th>
                               <th class="text-center" width="130">Stok Saat Ini</th>
                               <th class="text-center" width="130">Stok Minimum</th>
                               <th class="text-center" width="110">Status</th>
                               <th class="text-center" width="130">Aksi</th>
                            </tr>
                         </thead>
                         <tbody>
                            <?php $no = 1; foreach ($low_stocks as $ls): ?>
                            <tr>
                               <td class="text-center"><?= $no++; ?></td>
                               <td><code style="background:#f1f5f9; color:#0f172a; padding:3px 7px; border-radius:4px; font-weight:700;"><?= _ent($ls->kode_produk); ?></code></td>
                               <td><strong><?= _ent($ls->nama_produk); ?></strong></td>
                               <td class="text-center">
                                  <span style="font-size:17px; font-weight:800; color:<?= $ls->total_stok <= 0 ? '#dc2626' : '#d97706'; ?>">
                                     <?= number_format($ls->total_stok, 0, ',', '.'); ?>
                                  </span>
                               </td>
                               <td class="text-center text-muted" style="font-weight:600;"><?= number_format($ls->stok_minimum, 0, ',', '.'); ?></td>
                               <td class="text-center">
                                  <?php if ($ls->total_stok <= 0): ?>
                                     <span class="label label-danger" style="padding:4px 9px; font-size:11px; border-radius:3px;"><i class="fa fa-times-circle"></i> Habis</span>
                                  <?php else: ?>
                                     <span class="label label-warning" style="padding:4px 9px; font-size:11px; border-radius:3px;"><i class="fa fa-exclamation-circle"></i> Menipis</span>
                                  <?php endif; ?>
                                </td>
                               <td class="text-center">
                                  <a href="<?= site_url('administrator/stok/kartu/' . $ls->id); ?>" class="btn btn-xs btn-default" style="font-weight:600; padding:4px 10px; border-radius:3px;" title="Lihat Kartu Riwayat Stok">
                                     <i class="fa fa-list-alt text-primary"></i> Kartu Stok
                                  </a>
                               </td>
                            </tr>
                            <?php endforeach; ?>
                         </tbody>
                      </table>
                   </div>
                <?php else: ?>
                   <div class="text-center" style="padding: 30px; color: #475569;">
                      <i class="fa fa-check-circle" style="font-size: 42px; color: #16a34a; display:block; margin-bottom:10px;"></i>
                      <strong>Seluruh Stok Aman Terkendali</strong><br>
                      <small class="text-muted">Tidak ada produk yang berada di bawah ambang batas stok minimum.</small>
                   </div>
                <?php endif; ?>
             </div>
          </div>
       </div>
    </div>

    <!-- Section 4: Notifikasi Real-Time Retur Penjualan -->
    <p class="dash-section-title"><i class="fa fa-refresh text-warning"></i> Notifikasi Retur Penjualan Terbaru</p>
    <div class="row">
       <div class="col-md-12">
          <div class="box box-warning" style="border-radius:10px; border-top: 3px solid #f59e0b; border: 1px solid #e2e8f0; overflow:hidden;">
             <div class="box-header with-border" style="background:#fffbeb; padding:14px 18px;">
                <h3 class="box-title" style="color:#b45309; font-weight:700; font-size:15px;"><i class="fa fa-refresh text-warning"></i> Transaksi Retur Penjualan Terbaru (Real-Time Feed)</h3>
                <div class="box-tools pull-right">
                   <a href="<?= site_url('administrator/retur_penjualan/add'); ?>" class="btn btn-xs btn-warning" style="font-weight:700; padding:5px 12px; border-radius:4px;"><i class="fa fa-plus-circle"></i> Input Retur Baru</a>
                   <a href="<?= site_url('administrator/retur_penjualan/laporan'); ?>" class="btn btn-xs btn-default" style="margin-left:5px; font-weight:600; padding:5px 12px; border-radius:4px;"><i class="fa fa-bar-chart"></i> Laporan Analytics</a>
                </div>
             </div>
             <div class="box-body" style="padding:0;">
                <?php if (!empty($recent_returs)): ?>
                   <div class="table-responsive">
                      <table class="table table-striped table-hover" style="margin-bottom:0;">
                         <thead>
                            <tr style="background:#f8fafc; font-size:12px; color:#475569;">
                               <th class="text-center" width="45">No</th>
                               <th>No. Retur</th>
                               <th>Pelanggan</th>
                               <th>Tgl Retur</th>
                               <th>Tindak Lanjut</th>
                               <th class="text-right">Total Nominal</th>
                               <th class="text-center">Status</th>
                               <th class="text-center" width="100">Aksi</th>
                            </tr>
                         </thead>
                         <tbody>
                            <?php $r_no = 1; foreach ($recent_returs as $ret): ?>
                            <tr>
                               <td class="text-center"><?= $r_no++; ?></td>
                               <td><strong class="text-primary"><?= _ent($ret->nomor_retur); ?></strong></td>
                               <td><strong><?= _ent($ret->nama_pelanggan ?? 'Pelanggan Umum'); ?></strong></td>
                               <td><i class="fa fa-calendar text-muted"></i> <?= date('d/m/Y', strtotime($ret->tanggal_retur)); ?></td>
                               <td>
                                  <?php if ($ret->tindak_lanjut == 'tukar_barang'): ?>
                                     <span class="label label-info"><i class="fa fa-refresh"></i> Tukar Barang</span>
                                  <?php elseif ($ret->tindak_lanjut == 'refund'): ?>
                                     <span class="label label-danger"><i class="fa fa-money"></i> Refund Dana</span>
                                  <?php else: ?>
                                     <span class="label label-warning"><i class="fa fa-star"></i> Kredit Poin</span>
                                  <?php endif; ?>
                               </td>
                               <td class="text-right"><strong class="text-danger">Rp <?= number_format($ret->total, 0, ',', '.'); ?></strong></td>
                               <td class="text-center">
                                  <?php if ($ret->status == 'selesai' || $ret->status == 'approved'): ?>
                                     <span class="label label-success"><i class="fa fa-check"></i> PROSES SELESAI</span>
                                  <?php else: ?>
                                     <span class="label label-warning"><i class="fa fa-clock-o"></i> DRAFT / MENUNGGU</span>
                                  <?php endif; ?>
                               </td>
                               <td class="text-center">
                                  <a href="<?= site_url('administrator/retur_penjualan/view/' . $ret->id); ?>" class="btn btn-xs btn-primary btn-flat" style="border-radius:3px;">
                                     <i class="fa fa-eye"></i> Detail
                                  </a>
                               </td>
                            </tr>
                            <?php endforeach; ?>
                         </tbody>
                      </table>
                   </div>
                <?php else: ?>
                   <div class="text-center" style="padding: 25px; color: #475569;">
                      <i class="fa fa-info-circle" style="font-size: 32px; color: #d97706; display:block; margin-bottom:8px;"></i>
                      <strong>Belum Ada Notifikasi Retur Penjualan Baru</strong><br>
                      <small class="text-muted">Setiap pengembalian barang dari pelanggan akan masuk secara otomatis ke notifikasi ini.</small>
                   </div>
                <?php endif; ?>
             </div>
          </div>
       </div>
    </div>

    <?php cicool()->eventListen('dashboard_content_bottom'); ?>
</section>
