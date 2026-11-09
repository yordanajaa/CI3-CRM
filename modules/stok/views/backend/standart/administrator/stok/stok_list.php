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
   <div class="row stok-summary-row">
      <div class="col-md-3 col-sm-6 col-xs-12">
         <a href="<?= site_url('administrator/stok?status=all' . '' . '&per_page=' . $per_page); ?>" class="info-box-link" title="Klik untuk menampilkan SEMUA produk">
            <div class="info-box bg-aqua <?= (empty($status_sel) || $status_sel == 'all') ? 'active-card' : ''; ?>">
               <span class="info-box-icon"><i class="fa fa-cubes"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Total Produk</span>
                  <span class="info-box-number"><?= is_object($summary) ? $summary->total_produk : ($summary['total_produk'] ?? 0); ?> <span class="info-box-unit">Item</span></span>
                  <span class="info-box-hint"><i class="fa fa-mouse-pointer"></i> Klik: Semua Produk &rarr;</span>
               </div>
            </div>
         </a>
      </div>
      
      <div class="col-md-3 col-sm-6 col-xs-12">
         <a href="<?= site_url('administrator/stok?status=ada' . '' . '&per_page=' . $per_page); ?>" class="info-box-link" title="Klik untuk filter produk yang MEMILIKI STOK">
            <div class="info-box bg-green <?= ($status_sel == 'ada') ? 'active-card' : ''; ?>">
               <span class="info-box-icon"><i class="fa fa-check-circle"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Total Keseluruhan Stok</span>
                  <span class="info-box-number"><?= number_format(is_object($summary) ? $summary->total_stok : ($summary['total_stok'] ?? 0), 0, ',', '.'); ?> <span class="info-box-unit">Unit</span></span>
                  <span class="info-box-hint"><i class="fa fa-mouse-pointer"></i> Klik: Filter Ada Stok &rarr;</span>
               </div>
            </div>
         </a>
      </div>
      
      <div class="col-md-3 col-sm-6 col-xs-12">
         <a href="<?= site_url('administrator/stok?status=menipis' . '' . '&per_page=' . $per_page); ?>" class="info-box-link" title="Klik untuk filter produk STOK MENIPIS">
            <div class="info-box bg-yellow <?= ($status_sel == 'menipis') ? 'active-card' : ''; ?>">
               <span class="info-box-icon"><i class="fa fa-exclamation-triangle"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Stok Menipis</span>
                  <span class="info-box-number"><?= is_object($summary) ? $summary->stok_menipis : ($summary['stok_menipis'] ?? 0); ?> <span class="info-box-unit">Produk</span></span>
                  <span class="info-box-hint"><i class="fa fa-mouse-pointer"></i> Klik: Filter Menipis &rarr;</span>
               </div>
            </div>
         </a>
      </div>
      
      <div class="col-md-3 col-sm-6 col-xs-12">
         <a href="<?= site_url('administrator/stok?status=habis' . '' . '&per_page=' . $per_page); ?>" class="info-box-link" title="Klik untuk filter produk STOK HABIS">
            <div class="info-box bg-red <?= ($status_sel == 'habis') ? 'active-card' : ''; ?>">
               <span class="info-box-icon"><i class="fa fa-times-circle"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Stok Habis</span>
                  <span class="info-box-number"><?= is_object($summary) ? $summary->stok_habis : ($summary['stok_habis'] ?? 0); ?> <span class="info-box-unit">Produk</span></span>
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
.stok-summary-row {
   display: flex;
   flex-wrap: wrap;
   margin-bottom: 5px;
}
.stok-summary-row > div[class*="col-"] {
   display: flex;
   flex-direction: column;
   margin-bottom: 15px;
}
.stok-summary-row .info-box-link {
   display: flex;
   flex-direction: column;
   flex: 1;
   height: 100%;
   color: #fff !important;
   text-decoration: none !important;
}
.stok-summary-row .info-box {
   display: flex !important;
   align-items: stretch;
   flex: 1;
   width: 100%;
   height: 100%;
   min-height: 96px;
   margin-bottom: 0 !important;
   border-radius: 8px !important;
   overflow: hidden;
   box-shadow: 0 2px 8px rgba(0,0,0,0.12);
   transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
   position: relative;
   cursor: pointer !important;
}
.stok-summary-row .info-box-link:hover .info-box {
   transform: translateY(-3px) !important;
   box-shadow: 0 10px 22px rgba(0,0,0,0.22) !important;
}
.stok-summary-row .info-box.active-card {
   box-shadow: 0 0 0 3px #1e293b, 0 8px 20px rgba(0,0,0,0.25) !important;
   z-index: 2;
}
.stok-summary-row .info-box-icon {
   float: none !important;
   height: auto !important;
   width: 82px !important;
   min-width: 82px !important;
   display: flex !important;
   align-items: center;
   justify-content: center;
   font-size: 38px;
   background: rgba(0, 0, 0, 0.15) !important;
   border-radius: 8px 0 0 8px;
   margin: 0 !important;
}
.stok-summary-row .info-box-content {
   float: none !important;
   margin-left: 0 !important;
   flex: 1;
   display: flex;
   flex-direction: column;
   justify-content: center;
   padding: 10px 14px;
   min-width: 0;
}
.stok-summary-row .info-box-text {
   font-size: 11.5px !important;
   font-weight: 700 !important;
   letter-spacing: 0.5px;
   text-transform: uppercase;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
   margin-bottom: 2px;
}
.stok-summary-row .info-box-number {
   font-size: 20px !important;
   font-weight: 800 !important;
   line-height: 1.2;
   margin-bottom: 4px;
   white-space: nowrap;
}
.stok-summary-row .info-box-unit {
   font-size: 13px;
   font-weight: normal;
   opacity: 0.9;
   margin-left: 2px;
}
.stok-summary-row .info-box-hint {
   display: block;
   font-size: 11px;
   font-weight: 600;
   opacity: 0.9;
   letter-spacing: 0.2px;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
   margin-top: 2px;
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
                  <a href="<?= site_url('administrator/stok/edit_massal' . ''); ?>" class="btn btn-warning btn-sm" style="font-weight: 700; background-color: #f59e0b; border-color: #d97706; color: #fff; padding: 6px 14px; border-radius: 5px;" title="Edit Stok Semua Produk Sekaligus (Massal)">
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
                     <select class="form-control input-sm" name="per_page" onchange="this.form.submit()" style="font-weight: 600; width: 85px; border-radius: 4px;">
                        <option value="25" <?= ($per_page == 25) ? 'selected' : ''; ?>>25</option>
                        <option value="50" <?= ($per_page == 50) ? 'selected' : ''; ?>>50</option>
                        <option value="100" <?= ($per_page == 100) ? 'selected' : ''; ?>>100</option>
                        <option value="250" <?= ($per_page == 250) ? 'selected' : ''; ?>>Semua</option>
                     </select>

                     <!-- Quick Search -->
                     <div class="input-group input-group-sm" style="margin-left: 4px;">
                        <input type="text" class="form-control" name="q" value="<?= _ent($this->input->get('q')); ?>" placeholder="Cari kode/nama produk..." style="border-radius: 4px 0 0 4px; min-width: 160px;">
                        <span class="input-group-btn">
                           <button type="submit" class="btn btn-default btn-flat" title="Cari"><i class="fa fa-search"></i></button>
                           <?php if($this->input->get('q')): ?>
                              <a href="<?= site_url('administrator/stok' . ''); ?>" class="btn btn-danger btn-flat" title="Reset Cari"><i class="fa fa-times"></i></a>
                           <?php endif; ?>
                        </span>
                     </div>

                     <?php if(!empty($status_sel) && $status_sel !== 'all'): ?>
                        <span class="label <?= $status_sel == 'habis' ? 'label-danger' : ($status_sel == 'menipis' ? 'label-warning' : 'label-success'); ?>" style="font-size: 11.5px; padding: 5px 9px; border-radius: 4px; display: inline-flex; align-items: center; gap: 5px;">
                           <i class="fa fa-filter"></i> Filter: <?= $status_sel == 'habis' ? 'Stok Habis' : ($status_sel == 'menipis' ? 'Stok Menipis' : 'Ada Stok'); ?>
                           <a href="<?= site_url('administrator/stok' . ''); ?>" style="color: #fff; margin-left: 4px; font-weight: bold;" title="Hapus Filter"><i class="fa fa-times"></i></a>
                        </span>
                     <?php endif; ?>
                  </form>

                  <!-- Secondary Tools -->
                  <div class="stok-toolbar-tools">
                     <?php if (is_allowed('stok_export', false)): ?>
                        <?php
                        $export_params = array_filter([
                           
                           'status'    => (!empty($status_sel) && $status_sel !== 'all') ? $status_sel : null,
                           'q'         => $this->input->get('q') ?: null,
                           'f'         => $this->input->get('f') ?: null,
                        ]);
                        $export_qs = !empty($export_params) ? '?' . http_build_query($export_params) : '';
                        ?>
                        <a href="<?= site_url('administrator/stok/export' . $export_qs); ?>" class="btn btn-default btn-sm" style="font-weight: 600; border-radius: 4px;">
                           <i class="fa fa-file-excel-o text-success"></i> Export Excel
                        </a>
                        <a href="<?= site_url('administrator/stok/export_pdf' . $export_qs); ?>" target="_blank" class="btn btn-default btn-sm" style="font-weight: 600; border-radius: 4px;">
                           <i class="fa fa-file-pdf-o text-danger"></i> Export PDF
                        </a>
                        <a href="<?= site_url('administrator/stok/print_stok' . $export_qs); ?>" target="_blank" class="btn btn-default btn-sm" style="font-weight: 600; border-radius: 4px;" title="Cetak / Print Laporan Stok Resmi">
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
                     <a href="<?= site_url('administrator/stok' . ''); ?>" class="btn btn-xs btn-primary" style="font-weight:700; padding:4px 10px; border-radius:4px;">
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
                                    <a href="<?= site_url('administrator/stok/kartu/' . $s->produk_id . ''); ?>" class="btn btn-xs btn-primary" title="Kartu Stok">
                                       <i class="fa fa-list-alt"></i> Kartu Stok
                                    </a>
                                    <?php if (is_allowed('stok_delete', false)): ?>
                                       <?php if ((float)$s->qty <= 0): ?>
                                          <button type="button" class="btn btn-xs btn-default disabled" style="margin: 2px 1px; opacity: 0.55; cursor: not-allowed;" title="Stok sudah kosong (0), tidak dapat dihapus lagi" disabled>
                                             <i class="fa fa-trash text-muted"></i> Hapus
                                          </button>
                                       <?php else: ?>
                                          <a href="javascript:void(0);" data-href="<?= site_url('administrator/stok/delete/' . $s->id); ?>" data-nama="<?= htmlspecialchars($s->nama_produk, ENT_QUOTES); ?>"  data-qty="<?= number_format((float)$s->qty, 0, ',', '.'); ?>" class="btn btn-xs btn-danger remove-data" style="margin: 2px 1px;" title="Hapus / Kosongkan Stok">
                                             <i class="fa fa-trash"></i> Hapus
                                          </a>
                                       <?php endif; ?>
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
      var nama = $(this).attr('data-nama') || 'produk ini';
      var qty = $(this).attr('data-qty') || '';
      swal({
         title: 'Hapus / Kosongkan Stok?',
         text: 'Stok ' + nama + (qty ? ' (saat ini: ' + qty + ')' : '') + ' akan dihapus dan direset menjadi 0 (kosong)!',
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#DD6B55',
         confirmButtonText: 'Ya, Kosongkan Stok!',
         cancelButtonText: 'Batal',
         closeOnConfirm: true
      }, function(ok){
         if (ok) { window.location.href = url; }
      });
   });
});
</script>
