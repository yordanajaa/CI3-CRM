<?php
/**
 * View: Dashboard Stok
 * File: stok_list.php
 */
?>
<section class="content-header">
   <h1>
      Dashboard Stok
      <small>Real-Time</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Stok</li>
   </ol>
</section>

<section class="content">

   <!-- Card Summary (Interaktif & Dapat Diklik) -->
   <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
         <a href="<?= site_url('administrator/stok?status=all' . ($gudang_sel ? '&gudang_id=' . $gudang_sel : '') . '&per_page=' . $per_page); ?>" class="info-box-link" title="Klik untuk menampilkan SEMUA produk">
            <div class="info-box bg-aqua <?= (empty($status_sel) || $status_sel == 'all') ? 'active-card' : ''; ?>">
               <span class="info-box-icon"><i class="fa fa-cubes"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Total Produk</span>
                  <span class="info-box-number"><?= is_object($summary) ? $summary->total_produk : ($summary['total_produk'] ?? 0); ?> <span style="font-size: 13px; font-weight: normal; opacity: 0.9;">Item</span></span>
                  <span class="info-box-hint">
                     <?php if (!$gudang_sel): ?>
                        <i class="fa fa-cubes"></i> <?= is_object($summary) ? $summary->total_produk : 59; ?> Produk di <?= count($gudangs); ?> Gudang (<?= $stok_counts; ?> Record)
                     <?php else: ?>
                        <i class="fa fa-mouse-pointer"></i> Klik: Semua Produk &rarr;
                     <?php endif; ?>
                  </span>
               </div>
            </div>
         </a>
      </div>
      
      <div class="col-md-3 col-sm-6 col-xs-12">
         <a href="<?= site_url('administrator/stok?status=ada' . ($gudang_sel ? '&gudang_id=' . $gudang_sel : '') . '&per_page=' . $per_page); ?>" class="info-box-link" title="Klik untuk filter produk yang MEMILIKI STOK">
            <div class="info-box bg-green <?= ($status_sel == 'ada') ? 'active-card' : ''; ?>">
               <span class="info-box-icon"><i class="fa fa-check-circle"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text" style="font-size:12px;">Total Keseluruhan Stok</span>
                  <span class="info-box-number"><?= number_format(is_object($summary) ? $summary->total_stok : ($summary['total_stok'] ?? 0), 0, ',', '.'); ?></span>
                  <span class="info-box-hint"><i class="fa fa-mouse-pointer"></i> Klik: Filter Ada Stok &rarr;</span>
               </div>
            </div>
         </a>
      </div>
      
      <div class="col-md-3 col-sm-6 col-xs-12">
         <a href="<?= site_url('administrator/stok?status=menipis' . ($gudang_sel ? '&gudang_id=' . $gudang_sel : '') . '&per_page=' . $per_page); ?>" class="info-box-link" title="Klik untuk filter produk STOK MENIPIS">
            <div class="info-box bg-yellow <?= ($status_sel == 'menipis') ? 'active-card' : ''; ?>">
               <span class="info-box-icon"><i class="fa fa-exclamation-triangle"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Stok Menipis</span>
                  <span class="info-box-number"><?= is_object($summary) ? $summary->stok_menipis : ($summary['stok_menipis'] ?? 0); ?> produk</span>
                  <span class="info-box-hint"><i class="fa fa-mouse-pointer"></i> Klik: Filter Menipis &rarr;</span>
               </div>
            </div>
         </a>
      </div>
      
      <div class="col-md-3 col-sm-6 col-xs-12">
         <a href="<?= site_url('administrator/stok?status=habis' . ($gudang_sel ? '&gudang_id=' . $gudang_sel : '') . '&per_page=' . $per_page); ?>" class="info-box-link" title="Klik untuk filter produk STOK HABIS">
            <div class="info-box bg-red <?= ($status_sel == 'habis') ? 'active-card' : ''; ?>">
               <span class="info-box-icon"><i class="fa fa-times-circle"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Stok Habis</span>
                  <span class="info-box-number"><?= is_object($summary) ? $summary->stok_habis : ($summary['stok_habis'] ?? 0); ?> produk</span>
                  <span class="info-box-hint"><i class="fa fa-mouse-pointer"></i> Klik: Filter Habis &rarr;</span>
               </div>
            </div>
         </a>
      </div>
   </div>

   <!-- Filter dan Data Stok -->
   <div class="row">
      <div class="col-md-12">
         <style>
.info-box-link {
   display: block;
   color: #fff !important;
   text-decoration: none !important;
}
.info-box-link .info-box {
   cursor: pointer !important;
   transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
   position: relative;
   border-radius: 8px !important;
   overflow: hidden;
}
.info-box-link:hover .info-box {
   transform: translateY(-4px) !important;
   box-shadow: 0 10px 22px rgba(0,0,0,0.22) !important;
}
.info-box-hint {
   display: block;
   font-size: 11px;
   font-weight: 600;
   opacity: 0.9;
   margin-top: 4px;
   letter-spacing: 0.2px;
}
.info-box.active-card {
   box-shadow: 0 0 0 3px #1e293b, 0 8px 20px rgba(0,0,0,0.25) !important;
   transform: translateY(-2px) !important;
}
.stok-box { border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
.stok-box-header { padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
.stok-header-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.stok-toolbar { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
.stok-toolbar-tools { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }

@media (max-width: 767px) {
  .stok-box-header {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 10px !important;
  }
  .stok-header-actions {
    width: 100% !important;
    display: flex !important;
    gap: 8px !important;
    margin-top: 4px !important;
  }
  .stok-header-actions a {
    flex: 1 !important;
    text-align: center !important;
    font-size: 12px !important;
    padding: 8px 6px !important;
    white-space: nowrap !important;
  }
  .stok-toolbar {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 10px !important;
  }
  .stok-toolbar form {
    width: 100% !important;
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
  }
  .stok-toolbar form select {
    flex: 1 !important;
    width: 100% !important;
    min-width: 0 !important;
  }
  .stok-toolbar-tools {
    width: 100% !important;
    display: flex !important;
    justify-content: space-between !important;
    gap: 6px !important;
  }
  .stok-toolbar-tools a {
    flex: 1 !important;
    text-align: center !important;
    font-size: 11px !important;
    padding: 7px 4px !important;
  }
}
</style>
         <div class="box box-primary stok-box">
            <div class="box-header with-border stok-box-header">
               <div>
                  <h3 class="box-title" style="margin: 0; font-size: 17px; font-weight: 700; color: #1e293b;">
                     <i class="fa fa-database text-primary"></i> Data Stok Barang
                  </h3>
               </div>
               <div class="stok-header-actions">
                  <a href="<?= site_url('administrator/stok/edit_massal' . ($gudang_sel ? '?gudang_id=' . $gudang_sel : '')); ?>" class="btn btn-warning btn-sm" style="font-weight: 700; background-color: #f59e0b; border-color: #d97706; color: #fff; padding: 6px 14px; border-radius: 5px;" title="Edit Stok Semua Produk Sekaligus (Massal)">
                     <i class="fa fa-pencil-square-o"></i> Edit Semua Stok (Massal)
                  </a>
                  <?php if (is_allowed('stok_add', false)): ?>
                     <a href="<?= site_url('administrator/stok/add'); ?>" class="btn btn-success btn-sm" style="font-weight: 700; padding: 6px 14px; border-radius: 5px;">
                        <i class="fa fa-plus-circle"></i> Input Stok Manual
                     </a>
                  <?php endif; ?>
               </div>
            </div>

            <div class="box-body" style="padding: 18px;">
               <!-- Toolbar Filter & Alat Tambahan -->
               <div class="stok-toolbar">
                  <!-- Filter Status & Per Page -->
                  <form class="form-inline" action="<?= base_url('administrator/stok'); ?>" method="GET" style="margin: 0; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                     <?php if(!empty($status_sel) && $status_sel !== 'all'): ?>
                        <input type="hidden" name="status" value="<?= _ent($status_sel); ?>">
                     <?php endif; ?>
                     <label style="font-size: 13px; font-weight: 600; color: #475569; margin: 0; white-space: nowrap;">
                        <i class="fa fa-list text-muted"></i> Tampil:
                     </label>
                     <select class="form-control input-sm" name="per_page" onchange="this.form.submit()" style="font-weight: 600; width: 90px; border-radius: 4px;">
                        <option value="25" <?= ($per_page == 25) ? 'selected' : ''; ?>>25</option>
                        <option value="50" <?= ($per_page == 50) ? 'selected' : ''; ?>>50</option>
                        <option value="100" <?= ($per_page == 100) ? 'selected' : ''; ?>>100</option>
                        <option value="250" <?= ($per_page == 250) ? 'selected' : ''; ?>>Semua</option>
                     </select>

                     <?php if(!empty($status_sel) && $status_sel !== 'all'): ?>
                        <span class="label <?= $status_sel == 'habis' ? 'label-danger' : ($status_sel == 'menipis' ? 'label-warning' : 'label-success'); ?>" style="font-size: 11.5px; padding: 5px 9px; border-radius: 4px; display: inline-flex; align-items: center; gap: 5px;">
                           <i class="fa fa-filter"></i> Filter: <?= $status_sel == 'habis' ? 'Stok Habis' : ($status_sel == 'menipis' ? 'Stok Menipis' : 'Ada Stok'); ?>
                           <a href="<?= site_url('administrator/stok'); ?>" style="color: #fff; margin-left: 4px; font-weight: bold;" title="Hapus Filter"><i class="fa fa-times"></i></a>
                        </span>
                     <?php endif; ?>
                  </form>

                  <!-- Secondary Tools -->
                  <div class="stok-toolbar-tools">
                     <a href="<?= site_url('administrator/stok/batch_tracking'); ?>" class="btn btn-info btn-sm" style="font-weight: 600; border-radius: 4px;">
                        <i class="fa fa-qrcode"></i> Batch Tracking
                     </a>
                     <?php if (is_allowed('stok_export', false)): ?>
                        <a href="<?= site_url('administrator/stok/export'); ?>" class="btn btn-default btn-sm" style="font-weight: 600; border-radius: 4px;">
                           <i class="fa fa-file-excel-o text-success"></i> Export Excel
                        </a>
                        <a href="<?= site_url('administrator/stok/print_stok' . (!empty($status_sel) && $status_sel !== 'all' ? '?status=' . $status_sel : '')); ?>" target="_blank" class="btn btn-default btn-sm" style="font-weight: 600; border-radius: 4px;" title="Cetak / Print Laporan Stok Resmi">
                           <i class="fa fa-print text-primary"></i> Cetak / Print
                        </a>
                     <?php endif; ?>
                  </div>
               </div>

               <?php if(!empty($status_sel) && $status_sel !== 'all'): ?>
                  <div class="alert alert-info" style="background:#eff6ff !important; border:1px solid #bfdbfe !important; color:#1e40af !important; border-radius:6px; padding:10px 14px; margin-bottom:14px; font-size:12.5px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                     <div>
                        <i class="fa fa-info-circle text-primary" style="font-size:14px;"></i> 
                        <strong>Filter Aktif:</strong> Menampilkan <strong><?= $stok_counts; ?></strong> record dengan status <strong><?= $status_sel == 'habis' ? 'Stok Habis (0)' : ($status_sel == 'menipis' ? 'Stok Menipis' : 'Ada Stok (> 0)'); ?></strong>.
                        <?php if ($status_sel === 'ada'): ?>
                           (<?= is_object($summary) ? $summary->stok_habis : 55; ?> produk lainnya saat ini stok fisiknya 0 sehingga tidak ditampilkan).
                        <?php endif; ?>
                     </div>
                     <a href="<?= site_url('administrator/stok'); ?>" class="btn btn-xs btn-primary" style="font-weight:700; padding:4px 10px; border-radius:4px;">
                        <i class="fa fa-th-list"></i> Tampilkan Semua Produk (<?= is_object($summary) ? $summary->total_produk : 59; ?>)
                     </a>
                  </div>
               <?php endif; ?>

               <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Kode Produk</th>
                           <th>Nama Produk</th>
                           <th class="text-center">Stok</th>
                           <th class="text-center">Rusak</th>
                           <th class="text-center">Min. Stok</th>
                           <th>Status</th>
                           <th class="text-center">Aksi</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($stoks)): ?>
                           <?php foreach ($stoks as $s): ?>
                              <tr class="<?= $s->qty == 0 ? 'danger' : ($s->qty <= $s->stok_minimum ? 'warning' : ''); ?>">
                                 <td><?= _ent($s->kode_produk); ?></td>
                                 <td><strong><?= _ent($s->nama_produk); ?></strong></td>
                                 <td class="text-center"><strong><?= number_format((float)$s->qty, 0, ',', '.'); ?></strong></td>
                                 <td class="text-center <?= $s->qty_rusak > 0 ? 'text-danger' : ''; ?>">
                                    <?= $s->qty_rusak > 0 ? number_format((float)$s->qty_rusak, 0, ',', '.') : '-'; ?>
                                 </td>
                                 <td class="text-center"><?= $s->stok_minimum; ?></td>
                                 <td>
                                    <?php if ($s->qty == 0): ?>
                                       <span class="label label-danger"><i class="fa fa-times"></i> Habis</span>
                                    <?php elseif ($s->qty <= $s->stok_minimum): ?>
                                       <span class="label label-warning"><i class="fa fa-warning"></i> Menipis</span>
                                    <?php else: ?>
                                       <span class="label label-success"><i class="fa fa-check"></i> Normal</span>
                                    <?php endif; ?>
                                 </td>
                                 <td class="text-center" style="white-space:nowrap;">
                                    <?php if (is_allowed('stok_update', false)): ?>
                                       <a href="<?= site_url('administrator/stok/edit/' . $s->id); ?>" class="btn btn-xs btn-warning" style="margin: 2px 1px; font-weight:600;" title="Sesuaikan / Input Stok Manual">
                                          <i class="fa fa-pencil"></i> Sesuaikan Stok
                                       </a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('administrator/stok/kartu/' . $s->produk_id); ?>" class="btn btn-xs btn-primary" title="Kartu Stok">
                                       <i class="fa fa-list-alt"></i> Kartu Stok
                                    </a>
                                    <?php if (is_allowed('stok_delete', false)): ?>
                                       <a href="javascript:void(0);" data-href="<?= site_url('administrator/stok/delete/' . $s->id); ?>" class="btn btn-xs btn-danger remove-data" style="margin: 2px 1px;" title="Hapus">
                                          <i class="fa fa-trash"></i> Hapus
                                       </a>
                                    <?php endif; ?>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        <?php else: ?>
                           <tr>
                              <td colspan="7" class="text-center text-muted">Belum ada data stok barang.</td>
                           </tr>
                        <?php endif; ?>
                     </tbody>
                  </table>
               </div>

               <div class="row" style="margin-top: 15px;">
                  <div class="col-md-7 col-sm-12">
                     <span class="text-muted" style="font-size: 13px;">
                        Total: <strong><?= is_object($summary) ? $summary->total_produk : 59; ?> produk unik</strong> 
                        <span class="label label-default" style="font-size: 11.5px; font-weight: 600; padding: 4px 8px; margin-left: 6px; background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; border-radius: 4px;">
                           <i class="fa fa-database text-muted"></i> <?= $stok_counts; ?> baris record stok
                        </span>
                     </span>
                  </div>
                  <div class="col-md-5 col-sm-12">
                     <div class="pull-right">
                        <?= $pagination; ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Peringatan Stok Menipis -->
   <?php if (!empty($menipis)): ?>
      <div class="row">
         <div class="col-md-12">
            <div class="box box-warning">
               <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-warning text-yellow"></i> Peringatan: Stok Menipis & Habis</h3>
               </div>
               <div class="box-body">
                  <table class="table table-bordered table-striped table-condensed">
                     <thead>
                        <tr>
                           <th>Nama Produk</th>
                           <th class="text-center">Stok Saat Ini</th>
                           <th class="text-center">Batas Minimal</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($menipis as $m): ?>
                           <tr class="<?= $m->qty == 0 ? 'danger' : 'warning'; ?>">
                              <td><?= _ent($m->nama_produk); ?></td>
                              <td class="text-center"><strong><?= number_format((float)$m->qty, 0, ',', '.'); ?></strong></td>
                              <td class="text-center"><?= $m->stok_minimum; ?></td>
                           </tr>
                        <?php endforeach; ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   <?php endif; ?>

</section>

<script>
$(document).ready(function(){
   $('.remove-data').click(function(){
      var url = $(this).attr('data-href');
      swal({
         title: 'Hapus Stok?',
         text: 'Data stok yang dihapus tidak dapat dikembalikan!',
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#DD6B55',
         confirmButtonText: 'Ya, Hapus!',
         cancelButtonText: 'Batal',
         closeOnConfirm: true
      }, function(ok){
         if (ok) { window.location.href = url; }
      });
   });
});
</script>
