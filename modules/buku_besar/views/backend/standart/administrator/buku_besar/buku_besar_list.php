<?php /* buku_besar_list.php - Buku Utama / General Ledger */ ?>
<style>
.kpi-card { 
   border-radius: 10px; 
   border: 1.5px solid #e2e8f0; 
   background: #fff; 
   box-shadow: 0 2px 8px rgba(0,0,0,0.04); 
   padding: 16px 18px; 
   transition: all .22s cubic-bezier(0.16, 1, 0.3, 1); 
   cursor: pointer !important;
   text-decoration: none !important;
   display: block;
   color: inherit !important;
   position: relative;
   overflow: hidden;
}
.kpi-card:hover { 
   transform: translateY(-4px); 
   box-shadow: 0 10px 24px rgba(0,0,0,0.1); 
   border-color: #cbd5e1;
}
.kpi-card:active {
   transform: translateY(-1px);
}
.kpi-card.active-card {
   box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
}
.kpi-card.active-debit {
   border-color: #15803d !important;
   background: #f0fdf4 !important;
}
.kpi-card.active-kredit {
   border-color: #b91c1c !important;
   background: #fef2f2 !important;
}
.kpi-card.active-cash {
   border-color: #1d4ed8 !important;
   background: #eff6ff !important;
}
.kpi-card.active-all {
   border-color: #7e22ce !important;
   background: #faf5ff !important;
}
.kpi-card .kpi-badge-filter {
   position: absolute;
   top: 10px;
   right: 12px;
   font-size: 10px;
   font-weight: 700;
   padding: 2px 8px;
   border-radius: 12px;
   display: inline-flex;
   align-items: center;
   gap: 4px;
}
.kpi-card .kpi-icon { width: 44px; height: 44px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; float: left; margin-right: 14px; }
.kpi-card .kpi-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 2px; }
.kpi-card .kpi-val { font-size: 18px; font-weight: 800; color: #0f172a; margin: 0; }
.kpi-card .kpi-hint { font-size: 10.5px; color: #94a3b8; font-weight: 600; margin-top: 4px; display: block; }
.kpi-card:hover .kpi-hint { color: #3b82f6; }

.form-card { border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.04); background: #fff; margin-bottom: 20px; }
.form-card .box-header { padding: 15px 20px; border-bottom: 1px solid #f1f5f9; background: #fafafa; border-radius: 8px 8px 0 0; }
.form-card .box-title { font-weight: 700; font-size: 15px; color: #1e293b; }
.form-card .box-body { padding: 20px; }

.badge-modul { padding: 5px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-block; }
.badge-penjualan { background: #dbeafe; color: #1e40af; }
.badge-pembelian { background: #fef3c7; color: #92400e; }
.badge-utang { background: #fee2e2; color: #991b1b; }
.badge-piutang { background: #e0e7ff; color: #3730a3; }
.badge-kas_keluar { background: #ffedd5; color: #c2410c; }
.badge-kas_masuk { background: #dcfce7; color: #166534; }
.badge-retur { background: #f3e8ff; color: #6b21a8; }
.badge-warehouse { background: #f1f5f9; color: #334155; }
</style>

<section class="content-header">
   <h1><i class="fa fa-book text-primary"></i> Buku Besar (General Ledger) <small>Audit Trail &amp; Konsolidasi Seluruh Transaksi Perusahaan</small></h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= base_url('administrator/piutang_usaha'); ?>">Keuangan</a></li>
      <li class="active">Buku Besar</li>
   </ol>
</section>

<?php
$current_params = $_GET;
unset($current_params['offset']);

// Card 1: Debit toggle
$p_debit = $current_params;
$p_debit['type'] = (($filter_type ?? '') === 'debit') ? '' : 'debit';
$link_debit = base_url('administrator/buku_besar?' . http_build_query(array_filter($p_debit)));

// Card 2: Kredit toggle
$p_kredit = $current_params;
$p_kredit['type'] = (($filter_type ?? '') === 'kredit') ? '' : 'kredit';
$link_kredit = base_url('administrator/buku_besar?' . http_build_query(array_filter($p_kredit)));

// Card 3: Arus Kas & Neraca toggle
$p_cash = $current_params;
$p_cash['type'] = (($filter_type ?? '') === 'cash') ? '' : 'cash';
$link_cash = base_url('administrator/buku_besar?' . http_build_query(array_filter($p_cash)));

// Card 4: Total Transaksi (Reset to all)
$p_all = $current_params;
unset($p_all['type']);
$link_all = base_url('administrator/buku_besar?' . http_build_query(array_filter($p_all)));
?>

<section class="content">
   <!-- Summary KPI Cards (Clickable Filter Cards) -->
   <div class="row" style="margin-bottom: 20px;">
      <div class="col-md-3 col-sm-6">
         <a href="<?= $link_debit; ?>" class="kpi-card <?= (($filter_type ?? '') === 'debit') ? 'active-debit active-card' : ''; ?>" title="Klik untuk memfilter transaksi Debit / Masuk saja">
            <?php if (($filter_type ?? '') === 'debit'): ?>
               <span class="kpi-badge-filter label label-success"><i class="fa fa-check"></i> Aktif</span>
            <?php endif; ?>
            <div class="kpi-icon" style="background: #dcfce7; color: #15803d;"><i class="fa fa-arrow-down"></i></div>
            <div class="kpi-title">Total Transaksi Masuk (Debit)</div>
            <div class="kpi-val text-success">Rp <?= number_format($summary['total_debit'], 0, ',', '.'); ?></div>
            <span class="kpi-hint"><i class="fa fa-mouse-pointer"></i> <?= (($filter_type ?? '') === 'debit') ? 'Sedang aktif (klik untuk lepas)' : 'Klik untuk filter Debit'; ?></span>
         </a>
      </div>
      <div class="col-md-3 col-sm-6">
         <a href="<?= $link_kredit; ?>" class="kpi-card <?= (($filter_type ?? '') === 'kredit') ? 'active-kredit active-card' : ''; ?>" title="Klik untuk memfilter transaksi Kredit / Keluar saja">
            <?php if (($filter_type ?? '') === 'kredit'): ?>
               <span class="kpi-badge-filter label label-danger"><i class="fa fa-check"></i> Aktif</span>
            <?php endif; ?>
            <div class="kpi-icon" style="background: #fee2e2; color: #b91c1c;"><i class="fa fa-arrow-up"></i></div>
            <div class="kpi-title">Total Transaksi Keluar (Kredit)</div>
            <div class="kpi-val text-danger">Rp <?= number_format($summary['total_kredit'], 0, ',', '.'); ?></div>
            <span class="kpi-hint"><i class="fa fa-mouse-pointer"></i> <?= (($filter_type ?? '') === 'kredit') ? 'Sedang aktif (klik untuk lepas)' : 'Klik untuk filter Kredit'; ?></span>
         </a>
      </div>
      <div class="col-md-3 col-sm-6">
         <a href="<?= $link_cash; ?>" class="kpi-card <?= (($filter_type ?? '') === 'cash') ? 'active-cash active-card' : ''; ?>" title="Klik untuk memfilter Arus Kas & Bank (Penerimaan BKM & Pengeluaran BKK)">
            <?php if (($filter_type ?? '') === 'cash'): ?>
               <span class="kpi-badge-filter label label-primary"><i class="fa fa-check"></i> Aktif</span>
            <?php endif; ?>
            <div class="kpi-icon" style="background: #dbeafe; color: #1d4ed8;"><i class="fa fa-balance-scale"></i></div>
            <div class="kpi-title">Arus Kas &amp; Neraca Bersih</div>
            <div class="kpi-val <?= $summary['net_balance'] >= 0 ? 'text-primary' : 'text-danger'; ?>">
               Rp <?= number_format($summary['net_balance'], 0, ',', '.'); ?>
            </div>
            <span class="kpi-hint"><i class="fa fa-mouse-pointer"></i> <?= (($filter_type ?? '') === 'cash') ? 'Sedang aktif (klik untuk lepas)' : 'Klik filter Kas &amp; Bank'; ?></span>
         </a>
      </div>
      <div class="col-md-3 col-sm-6">
         <a href="<?= $link_all; ?>" class="kpi-card <?= empty($filter_type) ? 'active-all active-card' : ''; ?>" title="Klik untuk menampilkan seluruh catatan transaksi">
            <?php if (empty($filter_type)): ?>
               <span class="kpi-badge-filter label label-default" style="background:#7e22ce; color:#fff;"><i class="fa fa-check"></i> Semua</span>
            <?php endif; ?>
            <div class="kpi-icon" style="background: #f3e8ff; color: #7e22ce;"><i class="fa fa-list-alt"></i></div>
            <div class="kpi-title">Total Catatan Transaksi</div>
            <div class="kpi-val"><?= number_format($summary['total_transaksi'], 0, ',', '.'); ?> <small style="font-size:12px; color:#64748b;">Entry</small></div>
            <span class="kpi-hint"><i class="fa fa-refresh"></i> Tampilkan Semua Entry</span>
         </a>
      </div>
   </div>

   <!-- Main Filter & Data Table Card -->
   <div class="row">
      <div class="col-md-12">
         <div class="box form-card" style="border-top: 3px solid #3b82f6;">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-filter text-primary"></i> Filter &amp; Pencarian Laporan Buku Besar</h3>
               <div class="box-tools pull-right" style="display: flex; gap: 6px;">
                  <a href="<?= base_url('administrator/buku_besar/export_excel?' . $_SERVER['QUERY_STRING']); ?>" class="btn btn-sm btn-success" style="border-radius:6px; font-weight:600;" title="Unduh format spreadsheet Excel lengkap">
                     <i class="fa fa-file-excel-o"></i> Export Excel
                  </a>
                  <a href="<?= base_url('administrator/buku_besar/export_csv?' . $_SERVER['QUERY_STRING']); ?>" class="btn btn-sm btn-info" style="border-radius:6px; font-weight:600;" title="Unduh data murni CSV">
                     <i class="fa fa-file-text-o"></i> Export CSV
                  </a>
                  <a href="<?= base_url('administrator/buku_besar/export_pdf?' . $_SERVER['QUERY_STRING']); ?>" target="_blank" class="btn btn-sm btn-danger" style="border-radius:6px; font-weight:600;" title="Cetak atau unduh dokumen PDF resmi">
                     <i class="fa fa-file-pdf-o"></i> Export PDF
                  </a>
               </div>
            </div>
            <div class="box-body">
               <form method="GET" action="<?= base_url('administrator/buku_besar'); ?>">
                  <input type="hidden" name="type" value="<?= _ent($filter_type ?? ''); ?>">
                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label>Dari Tanggal</label>
                           <input type="date" class="form-control" name="date_start" value="<?= _ent($filter_date_start); ?>">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label>Sampai Tanggal</label>
                           <input type="date" class="form-control" name="date_end" value="<?= _ent($filter_date_end); ?>">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label>Kategori Modul Transaksi</label>
                           <select class="form-control" name="category">
                              <option value="">-- Semua Kategori Transaksi --</option>
                              <option value="penjualan" <?= $filter_category == 'penjualan' ? 'selected' : ''; ?>>Penjualan (Invoice)</option>
                              <option value="pembelian" <?= $filter_category == 'pembelian' ? 'selected' : ''; ?>>Pembelian (PO &amp; Penerimaan Barang)</option>
                              <option value="utang" <?= $filter_category == 'utang' ? 'selected' : ''; ?>>Utang Usaha (AP)</option>
                              <option value="kas_keluar" <?= $filter_category == 'kas_keluar' ? 'selected' : ''; ?>>Pengeluaran Kas (BKK)</option>
                              <option value="piutang" <?= $filter_category == 'piutang' ? 'selected' : ''; ?>>Piutang Usaha (AR)</option>
                              <option value="kas_masuk" <?= $filter_category == 'kas_masuk' ? 'selected' : ''; ?>>Penerimaan Kas (BKM)</option>
                              <option value="retur" <?= $filter_category == 'retur' ? 'selected' : ''; ?>>Retur Pembelian / Penjualan</option>
                              <option value="warehouse" <?= $filter_category == 'warehouse' ? 'selected' : ''; ?>>Warehouse (Opname &amp; Transfer)</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label>Cari (No. Ref / Entitas / Uraian)</label>
                           <div class="input-group">
                              <input type="text" class="form-control" name="q" placeholder="Ketik kata kunci..." value="<?= _ent($filter_search); ?>">
                              <span class="input-group-btn">
                                 <button type="submit" class="btn btn-primary btn-flat" style="font-weight:600;"><i class="fa fa-search"></i> Cari</button>
                                 <?php if(!empty($filter_date_start) || !empty($filter_date_end) || !empty($filter_category) || !empty($filter_search) || !empty($filter_type)): ?>
                                    <a href="<?= base_url('administrator/buku_besar'); ?>" class="btn btn-danger btn-flat" style="font-weight:600;" title="Reset Filter ke Tampilan Awal">
                                       <i class="fa fa-refresh"></i> Reset
                                    </a>
                                 <?php endif; ?>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>

               <?php if (!empty($filter_type)): ?>
                  <div class="alert" style="background:#f8fafc; border:1px solid #cbd5e1; border-left:4px solid #3b82f6; border-radius:8px; padding:10px 16px; margin-top:10px; margin-bottom:12px; display:flex; justify-content:space-between; align-items:center;">
                     <div style="font-size:12.5px; color:#1e293b; font-weight:600;">
                        <i class="fa fa-filter text-primary"></i> Sedang Memfilter Berdasarkan Kartu: 
                        <strong class="text-primary">
                           <?= $filter_type === 'debit' ? 'Total Transaksi Masuk (Debit Saja)' : ($filter_type === 'kredit' ? 'Total Transaksi Keluar (Kredit Saja)' : 'Transaksi Arus Kas & Bank (BKM / BKK)'); ?>
                        </strong>
                        <span class="text-muted">(<?= number_format($total_rows); ?> entri ditemukan)</span>
                     </div>
                     <a href="<?= $link_all; ?>" class="btn btn-xs btn-default" style="border-radius:6px; font-weight:700;"><i class="fa fa-times text-danger"></i> Reset Filter Kartu</a>
                  </div>
               <?php endif; ?>

               <!-- Table Jurnal Audit Buku Besar -->
               <div class="table-responsive" style="margin-top: 10px;">
                  <table class="table table-bordered table-striped table-hover">
                     <thead>
                        <tr style="background: #f8fafc; color: #1e293b;">
                           <th width="40" class="text-center">No</th>
                           <th width="110">Tanggal</th>
                           <th width="160">No. Referensi</th>
                           <th width="170">Kategori Modul</th>
                           <th width="200">Entitas / Pihak Terkait</th>
                           <th>Deskripsi &amp; Uraian Transaksi</th>
                           <th width="140" class="text-right">Debit / Masuk (Rp)</th>
                           <th width="140" class="text-right">Kredit / Keluar (Rp)</th>
                           <th width="70" class="text-center">Aksi</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(!empty($entries)): ?>
                           <?php 
                           $no = $this->uri->segment(4) ? $this->uri->segment(4) + 1 : 1; 
                           foreach($entries as $row):
                              $badge_class = 'badge-' . $row->modul_code;
                           ?>
                              <tr>
                                 <td class="text-center"><?= $no++; ?></td>
                                 <td><i class="fa fa-calendar text-muted"></i> <strong><?= date('d/m/Y', strtotime($row->tanggal)); ?></strong></td>
                                 <td>
                                    <span class="label label-default" style="font-size:12px; font-family:monospace; padding:3px 8px;">
                                       <?= _ent($row->nomor_ref); ?>
                                    </span>
                                 </td>
                                 <td><span class="badge-modul <?= $badge_class; ?>"><?= _ent($row->modul_label); ?></span></td>
                                 <td><strong><?= _ent($row->entitas); ?></strong></td>
                                 <td><span style="color:#475569;"><?= _ent($row->deskripsi); ?></span></td>
                                 <td class="text-right font-weight-bold" style="color: #15803d;">
                                    <?= $row->debit > 0 ? 'Rp ' . number_format($row->debit, 0, ',', '.') : '-'; ?>
                                 </td>
                                 <td class="text-right font-weight-bold" style="color: #b91c1c;">
                                    <?= $row->kredit > 0 ? 'Rp ' . number_format($row->kredit, 0, ',', '.') : '-'; ?>
                                 </td>
                                 <td class="text-center">
                                    <?php 
                                    $link = '#';
                                    if ($row->modul_code == 'penjualan') $link = site_url('administrator/invoice');
                                    else if ($row->modul_code == 'pembelian') $link = site_url('administrator/purchase_order');
                                    else if ($row->modul_code == 'utang') $link = site_url('administrator/utang_usaha');
                                    else if ($row->modul_code == 'kas_keluar') $link = site_url('administrator/utang_usaha/kas_keluar');
                                    else if ($row->modul_code == 'piutang' || $row->modul_code == 'kas_masuk') $link = site_url('administrator/piutang_usaha');
                                    else if ($row->modul_code == 'retur') $link = site_url('administrator/retur_pembelian');
                                    else if ($row->modul_code == 'warehouse') $link = site_url('administrator/stok');
                                    ?>
                                    <a href="<?= $link; ?>" class="btn btn-xs btn-default" title="Buka Modul Terkait" style="border-radius:4px;"><i class="fa fa-external-link text-primary"></i></a>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        <?php else: ?>
                           <tr>
                              <td colspan="9" class="text-center" style="padding: 40px; color: #94a3b8;">
                                 <i class="fa fa-folder-open-o fa-3x" style="margin-bottom:10px; display:block;"></i>
                                 Belum ada data transaksi yang sesuai dengan filter di Buku Besar.
                              </td>
                           </tr>
                        <?php endif; ?>
                     </tbody>
                  </table>
               </div>

               <!-- Pagination -->
               <div class="row" style="margin-top: 15px;">
                  <div class="col-md-6">
                     <span class="text-muted" style="font-size:13px;">
                        Menampilkan data transaksi dari total <strong><?= number_format($total_rows, 0, ',', '.'); ?></strong> rekaman audit.
                     </span>
                  </div>
                  <div class="col-md-6 text-right">
                     <?= $pagination; ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
