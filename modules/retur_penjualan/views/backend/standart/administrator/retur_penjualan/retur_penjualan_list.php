<?php
/**
 * View: Daftar Retur Penjualan (Desktop & Mobile Friendly)
 * File: retur_penjualan_list.php
 */
$status_color = [
    'draft'     => 'default',
    'approved'  => 'primary',
    'selesai'   => 'success',
    'cancelled' => 'danger'
];
?>
<style>
.retur-box-header {
   display: flex;
   align-items: center;
   justify-content: space-between;
   flex-wrap: wrap;
   gap: 12px;
   padding: 14px 18px;
}
.retur-box-header .box-title {
   margin: 0;
   font-size: 17px;
   font-weight: 700;
   color: #1e293b;
   display: flex;
   align-items: center;
   gap: 8px;
}
.retur-header-actions {
   display: flex;
   align-items: center;
   flex-wrap: wrap;
   gap: 6px;
}
.filter-card {
   background: #f8fafc;
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   padding: 16px 18px;
   margin-bottom: 18px;
}
.filter-card .form-group label {
   font-size: 12px;
   font-weight: 600;
   color: #475569;
   margin-bottom: 5px;
   display: block;
}
.filter-card .form-control {
   border-radius: 6px;
   height: 38px;
   font-size: 13px;
   border: 1px solid #cbd5e1;
   background: #ffffff;
}
.filter-card .form-control:focus {
   border-color: #3b82f6;
   box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
}
.filter-btn-col {
   padding-top: 24px;
}
.active-filter-bar {
   background: #eff6ff;
   border: 1px solid #bfdbfe;
   border-radius: 6px;
   padding: 10px 14px;
   margin-bottom: 16px;
   font-size: 12px;
   color: #1e40af;
   display: flex;
   align-items: center;
   justify-content: space-between;
   flex-wrap: wrap;
   gap: 8px;
}
.table-responsive-custom {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow-x: auto;
   -webkit-overflow-scrolling: touch;
   background: #ffffff;
}
.table-retur {
   margin-bottom: 0 !important;
   width: 100%;
}
.table-retur th {
   background: #f1f5f9;
   font-size: 11.5px;
   text-transform: uppercase;
   letter-spacing: 0.4px;
   color: #475569;
   font-weight: 700;
   padding: 10px 8px !important;
   border-bottom: 2px solid #cbd5e1 !important;
   white-space: nowrap;
   vertical-align: middle !important;
}
.table-retur td {
   padding: 8px 8px !important;
   vertical-align: middle !important;
   font-size: 12.5px;
   color: #1e293b;
}
.table-retur tbody tr:hover {
   background-color: #f8fafc;
}
.nowrap {
   white-space: nowrap !important;
}
.badge-retur-status {
   display: inline-block;
   padding: 3px 8px;
   border-radius: 4px;
   font-size: 11px;
   font-weight: 700;
   text-transform: uppercase;
   letter-spacing: 0.3px;
   white-space: nowrap;
}
.badge-st-selesai { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
.badge-st-approved { background: #e0f2fe; color: #0369a1; border: 1px solid #7dd3fc; }
.badge-st-draft { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
.badge-st-cancelled { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

.badge-tl {
   display: inline-block;
   padding: 3px 8px;
   border-radius: 4px;
   font-size: 11px;
   font-weight: 600;
   background: #f0f9ff;
   color: #0284c7;
   border: 1px solid #bae6fd;
   white-space: nowrap;
}
.action-btn-group {
   display: inline-flex;
   align-items: center;
   justify-content: center;
   gap: 3px;
   white-space: nowrap;
}
.action-btn-group .btn {
   padding: 3px 8px;
   font-size: 11px;
   border-radius: 4px;
   font-weight: 600;
}

@media (max-width: 991px) {
   .filter-btn-col {
      padding-top: 4px;
      margin-bottom: 6px;
   }
   .filter-btn-col .btn-group-actions {
      display: flex;
      gap: 6px;
      width: 100%;
   }
   .filter-btn-col .btn-group-actions .btn {
      flex: 1;
      height: 38px;
      display: flex;
      align-items: center;
      justify-content: center;
   }
}

@media (max-width: 768px) {
   .retur-box-header {
      flex-direction: column;
      align-items: stretch;
   }
   .retur-header-actions {
      width: 100%;
   }
   .retur-header-actions .btn {
      flex: 1 1 auto;
      text-align: center;
      padding: 7px 10px;
   }
   .pagination-wrapper {
      text-align: center !important;
      margin-top: 10px;
   }
   .pagination-wrapper .pagination {
      margin: 0 !important;
   }
}
</style>

<section class="content-header">
   <h1>
      Retur Penjualan
      <small>Daftar Retur Pelanggan</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Retur Penjualan</li>
   </ol>
</section>

<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary" style="border-radius:8px; border:none; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            <div class="retur-box-header with-border" style="border-bottom:1px solid #f1f5f9;">
               <h3 class="box-title"><i class="fa fa-reply-all text-primary"></i> Data Retur Penjualan</h3>
               <div class="retur-header-actions">
                  <?php 
                  $export_qs = !empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : '';
                  if (is_allowed('retur_penjualan_export', false)): ?>
                     <a href="<?= site_url('administrator/retur_penjualan/export' . $export_qs); ?>" class="btn btn-primary btn-sm btn-flat" style="border-radius:6px; font-weight:600;">
                        <i class="fa fa-file-excel-o"></i> Export XLS
                     </a>
                     <a href="<?= site_url('administrator/retur_penjualan/export_pdf' . $export_qs); ?>" target="_blank" class="btn btn-info btn-sm btn-flat" style="border-radius:6px; font-weight:600;">
                        <i class="fa fa-file-pdf-o"></i> Export PDF
                     </a>
                  <?php endif; ?>
                  <?php if (is_allowed('retur_penjualan_add', false)): ?>
                     <a href="<?= site_url('administrator/retur_penjualan/add'); ?>" class="btn btn-success btn-sm btn-flat" style="border-radius:6px; font-weight:700;">
                        <i class="fa fa-plus"></i> Buat Retur Baru
                     </a>
                  <?php endif; ?>
               </div>
            </div>

            <div class="box-body" style="padding:16px 18px;">
               <!-- Filter Box: Tanggal, Bulan, Tahun, Status & Keyword -->
               <div class="filter-card">
                  <form action="<?= base_url('administrator/retur_penjualan/index'); ?>" method="GET" id="form-filter-retur">
                     <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                           <div class="form-group" style="margin-bottom:12px;">
                              <label><i class="fa fa-calendar-o text-primary"></i> Rentang Tanggal Mulai:</label>
                              <input type="date" class="form-control" name="date_start" value="<?= $this->input->get('date_start'); ?>">
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                           <div class="form-group" style="margin-bottom:12px;">
                              <label><i class="fa fa-calendar-o text-primary"></i> Rentang Tanggal Selesai:</label>
                              <input type="date" class="form-control" name="date_end" value="<?= $this->input->get('date_end'); ?>">
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                           <div class="form-group" style="margin-bottom:12px;">
                              <label><i class="fa fa-calendar text-info"></i> Bulan:</label>
                              <select name="bulan" class="form-control">
                                 <option value="">-- Semua Bulan --</option>
                                 <?php 
                                 $months = [
                                    '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April',
                                    '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',
                                    '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                 ];
                                 $curr_m = (int)$this->input->get('bulan');
                                 foreach ($months as $m_num => $m_name): ?>
                                    <option value="<?= $m_num; ?>" <?= ($curr_m == $m_num) ? 'selected' : ''; ?>>
                                       <?= str_pad($m_num, 2, '0', STR_PAD_LEFT) . ' - ' . $m_name; ?>
                                    </option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                           <div class="form-group" style="margin-bottom:12px;">
                              <label><i class="fa fa-clock-o text-warning"></i> Tahun:</label>
                              <select name="tahun" class="form-control">
                                 <option value="">-- Semua Tahun --</option>
                                 <?php 
                                 $curr_y = (int)$this->input->get('tahun');
                                 $y_list = !empty($available_years) ? $available_years : [(int)date('Y')];
                                 foreach ($y_list as $yr): ?>
                                    <option value="<?= $yr; ?>" <?= ($curr_y == $yr) ? 'selected' : ''; ?>>
                                       <?= $yr; ?>
                                    </option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group" style="margin-bottom:10px;">
                              <label><i class="fa fa-search text-muted"></i> Kata Kunci (No. Retur / Invoice / Pelanggan):</label>
                              <input type="text" class="form-control" name="q" placeholder="Cari nomor retur, invoice, atau nama pelanggan..." value="<?= htmlspecialchars($this->input->get('q') ?? ''); ?>">
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                           <div class="form-group" style="margin-bottom:10px;">
                              <label><i class="fa fa-tag text-success"></i> Status Retur:</label>
                              <select name="status" class="form-control">
                                 <option value="">-- Semua Status --</option>
                                 <option value="draft" <?= ($this->input->get('status') == 'draft') ? 'selected' : ''; ?>>Draft</option>
                                 <option value="approved" <?= ($this->input->get('status') == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                 <option value="selesai" <?= ($this->input->get('status') == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                 <option value="cancelled" <?= ($this->input->get('status') == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 filter-btn-col">
                           <div class="btn-group-actions">
                              <button type="submit" class="btn btn-primary btn-sm btn-flat" style="border-radius:6px; font-weight:700; height:38px; padding:0 18px;">
                                 <i class="fa fa-filter"></i> Filter
                              </button>
                              <a href="<?= base_url('administrator/retur_penjualan'); ?>" class="btn btn-default btn-sm btn-flat" style="border-radius:6px; font-weight:600; height:38px; line-height:26px; padding:0 14px;">
                                 <i class="fa fa-refresh"></i> Reset
                              </a>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>

               <?php
               $has_active_filter = !empty($this->input->get('date_start')) || !empty($this->input->get('date_end')) || !empty($this->input->get('bulan')) || !empty($this->input->get('tahun')) || !empty($this->input->get('status')) || !empty($this->input->get('q'));
               if ($has_active_filter):
               ?>
               <div class="active-filter-bar">
                  <div>
                     <i class="fa fa-info-circle text-primary"></i> <strong>Filter Aktif:</strong>
                     <?php if (!empty($this->input->get('date_start')) || !empty($this->input->get('date_end'))): ?>
                        <span class="label label-primary" style="margin-left:4px; font-size:11px;">Tanggal: <?= date('d/m/Y', strtotime($this->input->get('date_start') ?: date('Y-m-d'))); ?> s/d <?= date('d/m/Y', strtotime($this->input->get('date_end') ?: date('Y-m-d'))); ?></span>
                     <?php endif; ?>
                     <?php if (!empty($this->input->get('bulan'))): ?>
                        <span class="label label-info" style="margin-left:4px; font-size:11px;">Bulan: <?= $months[(int)$this->input->get('bulan')] ?? $this->input->get('bulan'); ?></span>
                     <?php endif; ?>
                     <?php if (!empty($this->input->get('tahun'))): ?>
                        <span class="label label-warning" style="margin-left:4px; font-size:11px;">Tahun: <?= $this->input->get('tahun'); ?></span>
                     <?php endif; ?>
                     <?php if (!empty($this->input->get('status'))): ?>
                        <span class="label label-success" style="margin-left:4px; font-size:11px;">Status: <?= strtoupper($this->input->get('status')); ?></span>
                     <?php endif; ?>
                     <?php if (!empty($this->input->get('q'))): ?>
                        <span class="label label-default" style="margin-left:4px; font-size:11px;">Kata Kunci: "<?= htmlspecialchars($this->input->get('q')); ?>"</span>
                     <?php endif; ?>
                  </div>
                  <div>
                     Ditemukan <strong><?= number_format($retur_counts, 0, ',', '.'); ?></strong> data retur
                  </div>
               </div>
               <?php endif; ?>

               <div class="table-responsive-custom">
                  <table class="table table-bordered table-striped table-retur">
                     <thead>
                        <tr>
                           <th class="nowrap" style="width:130px;">No. Retur</th>
                           <th class="nowrap" style="width:130px;">Invoice</th>
                           <th style="min-width:140px;">Pelanggan</th>
                           <th class="text-center nowrap" style="width:100px;">Tgl. Retur</th>
                           <th class="text-right nowrap" style="width:120px;">Total</th>
                           <th class="nowrap" style="width:120px;">Tindak Lanjut</th>
                           <th class="text-center nowrap" style="width:90px;">Status</th>
                           <th class="text-center nowrap" style="width:190px;">Aksi</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($returs)): ?>
                           <?php foreach ($returs as $r): 
                              $st_raw = strtolower($r->status ?? 'draft');
                              $badge_class = 'badge-st-draft';
                              if ($st_raw === 'selesai') $badge_class = 'badge-st-selesai';
                              elseif ($st_raw === 'approved') $badge_class = 'badge-st-approved';
                              elseif ($st_raw === 'cancelled') $badge_class = 'badge-st-cancelled';
                           ?>
                              <tr>
                                 <td class="nowrap"><strong style="color:#0f172a;"><?= _ent($r->nomor_retur); ?></strong></td>
                                 <td class="nowrap" style="color:#475569;"><?= _ent(isset($r->nomor_invoice) ? $r->nomor_invoice : '-'); ?></td>
                                 <td><strong><?= _ent($r->nama_pelanggan); ?></strong></td>
                                 <td class="text-center nowrap"><?= date('d/m/Y', strtotime($r->tanggal_retur)); ?></td>
                                 <td class="text-right nowrap" style="font-weight:700; color:#0f172a;">Rp <?= number_format($r->total, 0, ',', '.'); ?></td>
                                 <td class="nowrap"><span class="badge-tl"><?= _ent(ucwords(str_replace('_', ' ', $r->tindak_lanjut))); ?></span></td>
                                 <td class="text-center nowrap">
                                    <span class="badge-retur-status <?= $badge_class; ?>">
                                       <?= strtoupper($r->status); ?>
                                    </span>
                                 </td>
                                 <td class="text-center nowrap">
                                    <div class="action-btn-group">
                                       <?php if (is_allowed('retur_penjualan_view', false)): ?>
                                          <a href="<?= site_url('administrator/retur_penjualan/view/' . $r->id); ?>" class="btn btn-default" title="Detail"><i class="fa fa-eye text-primary"></i> Detail</a>
                                          <a href="<?= site_url('administrator/retur_penjualan/cetak/' . $r->id); ?>" target="_blank" class="btn btn-info" title="Cetak Dokumen Nota Retur Penjualan"><i class="fa fa-print"></i> Cetak </a>
                                       <?php endif; ?>

                                       <?php if ($r->status == 'draft' && is_allowed('retur_penjualan_update', false)): ?>
                                          <a href="<?= site_url('administrator/retur_penjualan/edit/' . $r->id); ?>" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                          <a href="<?= site_url('administrator/retur_penjualan/proses/' . $r->id); ?>" class="btn btn-success" onclick="return confirm('Proses retur ini? Stok barang akan dikembalikan.')" title="Proses Retur">
                                             <i class="fa fa-cogs"></i> Proses
                                          </a>
                                       <?php endif; ?>

                                       <?php if (is_allowed('retur_penjualan_delete', false) && ($r->status == 'draft' || $this->aauth->is_admin())): ?>
                                          <a href="javascript:void(0);" data-href="<?= site_url('administrator/retur_penjualan/delete/' . $r->id); ?>" class="btn btn-danger remove-data" title="Hapus">
                                             <i class="fa fa-trash"></i> Hapus
                                          </a>
                                       <?php endif; ?>
                                    </div>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        <?php else: ?>
                           <tr>
                              <td colspan="8" class="text-center text-muted" style="padding:25px;">Belum ada data retur penjualan ditemukan.</td>
                           </tr>
                        <?php endif; ?>
                     </tbody>
                  </table>
               </div>

               <div class="row" style="margin-top: 18px; align-items:center;">
                  <div class="col-sm-6 col-xs-12 text-center-sm" style="margin-bottom:8px;">
                     <span class="text-muted">Total: <strong><?= number_format($retur_counts, 0, ',', '.'); ?></strong> record Retur</span>
                  </div>
                  <div class="col-sm-6 col-xs-12 pagination-wrapper">
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
   $(document).on('click', '.remove-data', function(e){
      e.preventDefault();
      var url = $(this).attr('data-href');
      swal({
         title: 'Hapus Retur Penjualan?',
         text: 'Data yang dihapus tidak dapat dikembalikan!',
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
