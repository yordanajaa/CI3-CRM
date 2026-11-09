<?php
/**
 * View: Edit Semua Stok Produk (Massal)
 * File: stok_edit_massal.php
 */
$cnt_total = count($items ?? []);
$cnt_empty = 0;
$cnt_low = 0;
if (!empty($items)) {
   foreach ($items as $it) {
      $stok_val = (float)$it->total_stok;
      if ($stok_val <= 0) {
         $cnt_empty++;
      } elseif ($stok_val <= 5) {
         $cnt_low++;
      }
   }
}
?>
<style>
.bulk-card { border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.06); background: #fff; margin-bottom: 25px; }
.bulk-card .box-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: #ffffff; border-radius: 10px 10px 0 0; }

/* Header & Toolbar Unified (Satu Garis Rapi) */
.bulk-header-bar {
   display: flex;
   align-items: center;
   justify-content: space-between;
   flex-wrap: wrap;
   gap: 12px;
}
.bulk-header-title-box {
   display: flex;
   align-items: center;
   gap: 12px;
}
.bulk-header-icon {
   width: 42px;
   height: 42px;
   border-radius: 8px;
   background: #eff6ff;
   color: #2563eb;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 19px;
   flex-shrink: 0;
   border: 1px solid #dbeafe;
}
.bulk-header-title {
   margin: 0;
   font-weight: 800;
   color: #0f172a;
   font-size: 16.5px;
   line-height: 1.2;
}
.bulk-header-subtitle {
   font-size: 12px;
   color: #64748b;
   margin-top: 3px;
}
.bulk-header-actions {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
}

/* Toolbar Baris Terpadu */
.bulk-toolbar-bar {
   display: flex;
   align-items: center;
   justify-content: space-between;
   flex-wrap: wrap;
   gap: 12px;
   padding: 12px 16px;
   background: #f8fafc;
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   margin-bottom: 18px;
}
.bulk-toolbar-left {
   display: flex;
   align-items: center;
   gap: 12px;
   flex-wrap: wrap;
   flex: 1;
}
.bulk-search-box {
   position: relative;
   width: 290px;
   max-width: 100%;
}
.bulk-search-box input {
   width: 100%;
   height: 38px;
   padding-left: 36px;
   padding-right: 32px;
   border-radius: 6px;
   border: 1.5px solid #cbd5e1;
   font-size: 13px;
   transition: all .2s;
   background: #ffffff;
   color: #1e293b;
}
.bulk-search-box input:focus {
   border-color: #2563eb;
   box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
   outline: none;
}
.bulk-search-box .search-icon {
   position: absolute;
   left: 12px;
   top: 50%;
   transform: translateY(-50%);
   color: #94a3b8;
   pointer-events: none;
   font-size: 13.5px;
}
.bulk-search-box .clear-btn {
   position: absolute;
   right: 10px;
   top: 50%;
   transform: translateY(-50%);
   color: #94a3b8;
   border: none;
   background: transparent;
   cursor: pointer;
   font-size: 14px;
   display: none;
   padding: 0;
   line-height: 1;
}
.bulk-search-box .clear-btn:hover {
   color: #ef4444;
}

/* Pill Tabs */
.bulk-pill-tabs {
   display: inline-flex;
   align-items: center;
   background: #e2e8f0;
   padding: 3px;
   border-radius: 8px;
   gap: 2px;
   overflow-x: auto;
   max-width: 100%;
}
.bulk-pill-btn {
   border: none;
   background: transparent;
   padding: 6px 13px;
   border-radius: 6px;
   font-size: 12.5px;
   font-weight: 600;
   color: #475569;
   cursor: pointer;
   transition: all .2s;
   white-space: nowrap;
   display: inline-flex;
   align-items: center;
   gap: 6px;
   line-height: 1.3;
}
.bulk-pill-btn:hover {
   background: rgba(255,255,255,0.7);
   color: #0f172a;
}
.bulk-pill-btn.active {
   background: #ffffff;
   color: #2563eb;
   box-shadow: 0 1px 3px rgba(0,0,0,0.08);
   font-weight: 700;
}
.bulk-pill-btn .badge-pill-count {
   padding: 1px 7px;
   border-radius: 10px;
   font-size: 11px;
   font-weight: 700;
   background: #cbd5e1;
   color: #334155;
   transition: all .2s;
}
.bulk-pill-btn.active .badge-pill-count {
   background: #dbeafe;
   color: #1d4ed8;
}
.bulk-pill-btn[data-filter="empty"].active .badge-pill-count {
   background: #fee2e2;
   color: #b91c1c;
}
.bulk-pill-btn[data-filter="changed"].active .badge-pill-count {
   background: #dcfce7;
   color: #15803d;
}

.bulk-toolbar-right {
   display: flex;
   align-items: center;
   gap: 10px;
   flex-shrink: 0;
}
.bulk-showing-text {
   font-size: 12.5px;
   color: #64748b;
}

/* Tabel */
.table-bulk-stok th {
   background: #f1f5f9;
   color: #1e293b;
   font-weight: 700;
   font-size: 12px;
   vertical-align: middle !important;
   border-bottom: 2px solid #cbd5e1 !important;
   text-transform: uppercase;
   letter-spacing: 0.3px;
   position: sticky;
   top: 0;
   z-index: 5;
}
.table-bulk-stok td { vertical-align: middle !important; font-size: 13px; }
.input-qty-bulk { font-size: 15px; font-weight: 800; text-align: center; border-radius: 6px; border: 1.5px solid #cbd5e1; transition: all .2s; min-width: 80px; }
.input-qty-bulk:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.2); background: #eff6ff; }
.input-qty-bulk.changed { border-color: #10b981 !important; background: #ecfdf5 !important; color: #065f46 !important; font-weight: 900; }
.row-changed { background-color: #f0fdf4 !important; }

.sticky-save-bar {
   position: sticky;
   bottom: 12px;
   z-index: 100;
   background: #1e293b;
   color: #fff;
   border-radius: 10px;
   padding: 12px 20px;
   box-shadow: 0 8px 30px rgba(0,0,0,0.25);
   display: flex;
   align-items: center;
   justify-content: space-between;
   flex-wrap: wrap;
   gap: 12px;
   margin-top: 20px;
}
.bulk-action-buttons {
   display: flex;
   align-items: center;
   gap: 8px;
}

@media (max-width: 767px) {
   .bulk-header-bar {
      flex-direction: column;
      align-items: stretch;
      gap: 12px;
   }
   .bulk-header-actions {
      width: 100%;
   }
   .bulk-header-actions .btn {
      flex: 1;
      text-align: center;
      justify-content: center;
   }
   .bulk-toolbar-bar {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
      padding: 12px;
   }
   .bulk-toolbar-left {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
   }
   .bulk-search-box {
      width: 100%;
      max-width: 100%;
   }
   .bulk-pill-tabs {
      width: 100%;
      justify-content: flex-start;
   }
   .bulk-toolbar-right {
      justify-content: space-between;
      width: 100%;
   }
   .sticky-save-bar {
      flex-direction: column;
      align-items: stretch;
      padding: 12px 14px;
      bottom: 6px;
      margin-top: 15px;
   }
   .bulk-action-buttons {
      width: 100%;
   }
   .bulk-action-buttons .btn {
      flex: 1;
      text-align: center;
      justify-content: center;
   }
   .bulk-action-buttons #btn_save_all_stok {
      flex: 2;
   }
   .content {
      padding-bottom: 90px !important;
   }
}
</style>

<section class="content-header">
   <h1>
      <i class="fa fa-pencil-square text-primary"></i> Edit Semua Stok Produk
      <small>Pembaruan Massal / Bulk Stock Editor</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/stok'); ?>"><i class="fa fa-database"></i> Stok</a></li>
      <li class="active">Edit Semua Stok</li>
   </ol>
</section>

<section class="content">

   <div class="box bulk-card">
      <!-- HEADER ATAS (SATU GARIS RAPI) -->
      <div class="box-header with-border">
         <div class="bulk-header-bar">
            <div class="bulk-header-title-box">
               <div class="bulk-header-icon">
                  <i class="fa fa-list-ol"></i>
               </div>
               <div>
                  <h3 class="bulk-header-title">Daftar Seluruh Produk &amp; Stok Fisik</h3>
                  <div class="bulk-header-subtitle">
                     Total <strong id="lbl_total_baris"><?= $cnt_total; ?></strong> item produk tercatat
                  </div>
               </div>
            </div>
            
            <div class="bulk-header-actions">
               <!-- Tombol Reset Input -->
               <button type="button" id="btn_reset_all" class="btn btn-default btn-sm" style="font-weight:600; border-radius:6px; display:inline-flex; align-items:center; gap:6px;" disabled title="Kembalikan semua angka input ke stok awal">
                  <i class="fa fa-undo text-muted"></i> <span>Reset Input</span>
               </button>
               <!-- Tombol Kembali -->
               <a href="<?= site_url('administrator/stok'); ?>" class="btn btn-default btn-sm" style="font-weight:600; border-radius:6px; display:inline-flex; align-items:center; gap:6px;">
                  <i class="fa fa-arrow-left"></i> <span>Kembali ke Stok</span>
               </a>
            </div>
         </div>
      </div>

      <div class="box-body" style="padding: 20px;">

         <!-- TOOLBAR TERPADU (SEARCH + PILL TABS + LIVE COUNTER) -->
         <div class="bulk-toolbar-bar">
            <div class="bulk-toolbar-left">
               <!-- Search Box with Clear Button -->
               <div class="bulk-search-box">
                  <i class="fa fa-search search-icon"></i>
                  <input type="text" id="filter_produk_input" placeholder="Cari kode atau nama produk..." autofocus autocomplete="off">
                  <button type="button" class="clear-btn" id="btn_clear_search" title="Hapus pencarian">
                     <i class="fa fa-times-circle"></i>
                  </button>
               </div>

               <!-- Filter Pill Tabs -->
               <div class="bulk-pill-tabs">
                  <button type="button" class="bulk-pill-btn active" data-filter="all">
                     <i class="fa fa-th-list"></i> Semua <span class="badge-pill-count count-semua"><?= $cnt_total; ?></span>
                  </button>
                  <button type="button" class="bulk-pill-btn" data-filter="changed">
                     <i class="fa fa-pencil"></i> Diubah <span class="badge-pill-count count-diubah" id="pill_count_changed">0</span>
                  </button>
                  <button type="button" class="bulk-pill-btn" data-filter="empty">
                     <i class="fa fa-exclamation-circle text-danger"></i> Stok Habis <span class="badge-pill-count count-habis"><?= $cnt_empty; ?></span>
                  </button>
                  <button type="button" class="bulk-pill-btn" data-filter="low">
                     <i class="fa fa-warning text-warning"></i> Menipis (&le; 5) <span class="badge-pill-count count-menipis"><?= $cnt_low; ?></span>
                  </button>
               </div>
            </div>

            <!-- Toolbar Kanan: Live Info -->
            <div class="bulk-toolbar-right">
               <span class="badge bg-green" id="badge_changed_count" style="font-size:12px; padding:6px 14px; border-radius:20px; font-weight:700; display:none; box-shadow:0 2px 6px rgba(16,185,129,0.3);">
                  <i class="fa fa-pencil"></i> <span id="num_changed">0</span> produk diubah
               </span>
               <span class="bulk-showing-text">
                  Menampilkan <strong id="lbl_showing_count" style="color:#0f172a;"><?= $cnt_total; ?></strong> item
               </span>
            </div>
         </div>

         <!-- FORM TABEL MASSAL -->
         <form id="form_bulk_stok" method="POST" action="<?= site_url('administrator/stok/edit_massal_save'); ?>">
            <div class="table-responsive" style="max-height: 650px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 8px;">
               <table class="table table-bordered table-striped table-hover table-bulk-stok" id="table_bulk_editor" style="margin-bottom:0;">
                  <thead>
                     <tr>
                        <th width="40" class="text-center">#</th>
                        <th width="110">Kode Produk</th>
                        <th>Nama Produk &amp; Kategori</th>
                        <th width="75" class="text-center">Satuan</th>
                        <th width="120" class="text-center" style="background:#f1f5f9; color:#475569;">Stok Saat Ini</th>
                        <th width="150" class="text-center" style="background:#ecfdf5; color:#065f46;">Stok Baru *</th>
                        <th width="100" class="text-center">Selisih</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($items)): ?>
                        <?php $no = 1; foreach($items as $it): 
                           $cur_qty = (float)$it->total_stok;
                           $sat = !empty($it->singkatan) ? $it->singkatan : 'Pcs';
                           $is_empty = ($cur_qty <= 0) ? '1' : '0';
                           $is_low = ($cur_qty > 0 && $cur_qty <= 5) ? '1' : '0';
                        ?>
                        <tr class="row-item" id="row_<?= $it->id; ?>" 
                            data-id="<?= $it->id; ?>" 
                            data-kode="<?= strtolower($it->kode_produk); ?>" 
                            data-nama="<?= strtolower($it->nama_produk); ?>"
                            data-stok="<?= $cur_qty; ?>"
                            data-empty="<?= $is_empty; ?>"
                            data-low="<?= $is_low; ?>">
                           <td class="text-center text-muted"><?= $no++; ?></td>
                           <td>
                              <span class="label label-primary" style="font-size:11px;"><?= _ent($it->kode_produk); ?></span>
                           </td>
                           <td>
                              <strong style="color:#0f172a; font-size:13.5px;"><?= _ent($it->nama_produk); ?></strong>
                              <?php if(!empty($it->nama_kategori)): ?>
                                 <br><small class="text-muted"><i class="fa fa-tag"></i> <?= _ent($it->nama_kategori); ?></small>
                              <?php endif; ?>
                           </td>
                           <td class="text-center">
                              <span class="badge bg-gray" style="font-size:11px;"><?= _ent($sat); ?></span>
                           </td>
                           
                           <!-- STOK SAAT INI -->
                           <td class="text-center" style="background:#f8fafc; font-weight:800; font-size:14px; color:#334155;">
                              <span class="disp-prev-qty"><?= number_format($cur_qty, 0, ',', '.'); ?></span>
                              <input type="hidden" class="orig-qty" value="<?= $cur_qty; ?>">
                           </td>

                           <!-- INPUT STOK BARU -->
                           <td style="background:#f0fdf4;">
                              <input type="number" step="any" min="0" 
                                     class="form-control input-qty-bulk input-qty-baru" 
                                     name="items[<?= $it->id; ?>][qty]" 
                                     value="<?= $cur_qty; ?>" 
                                     data-id="<?= $it->id; ?>"
                                     required>
                           </td>

                           <!-- SELISIH LIVE -->
                           <td class="text-center selisih-col" style="font-weight:700;">
                              <span class="label label-default badge-selisih">0</span>
                           </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <!-- BARIS KOSONG JIKA TIDAK ADA HASIL FILTER -->
                        <tr id="row_no_filter_match" style="display:none;">
                           <td colspan="7" class="text-center text-muted" style="padding:40px;">
                              <i class="fa fa-search fa-2x text-muted" style="margin-bottom:8px; display:block;"></i>
                              <span style="font-size:14px; font-weight:600; color:#64748b;">Tidak ada produk yang cocok dengan filter atau kata kunci pencarian.</span>
                           </td>
                        </tr>
                     <?php else: ?>
                        <tr>
                           <td colspan="7" class="text-center text-muted" style="padding:40px;">
                              <i class="fa fa-info-circle fa-2x"></i><br>
                              Tidak ada data stok produk ditemukan.
                           </td>
                        </tr>
                     <?php endif; ?>
                  </tbody>
               </table>
            </div>

            <!-- STICKY ACTION BAR DI BAWAH -->
            <div class="sticky-save-bar">
               <div>
                  <span style="font-weight:800; font-size:15px; color:#38bdf8;">
                     <i class="fa fa-pencil-square-o"></i> Mode Edit Semua Stok
                  </span>
                  <div style="font-size:12px; color:#94a3b8;">
                     <span id="footer_changed_text">Belum ada stok yang diubah. Ubah angka pada kolom Stok Baru di atas.</span>
                  </div>
               </div>
               <div class="bulk-action-buttons">
                  <a href="<?= site_url('administrator/stok'); ?>" class="btn btn-default btn-sm" style="font-weight:600;">
                     <i class="fa fa-times"></i> Batal
                  </a>
                  <button type="submit" id="btn_save_all_stok" class="btn btn-success" style="font-weight:800; padding:8px 20px; border-radius:6px; box-shadow:0 3px 10px rgba(16,185,129,0.4); font-size:13.5px;">
                     <i class="fa fa-save"></i> Simpan Semua Perubahan Stok
                  </button>
               </div>
            </div>

         </form>

      </div>
   </div>

</section>

<script>
$(document).ready(function(){
   var currentFilter = 'all';

   function updateRowDiff($row) {
      var origVal = parseFloat($row.find('.orig-qty').val()) || 0;
      var newVal = parseFloat($row.find('.input-qty-baru').val());
      if (isNaN(newVal)) newVal = 0;

      var diff = newVal - origVal;
      var $badge = $row.find('.badge-selisih');

      if (newVal !== origVal) {
         $row.addClass('row-changed');
         $row.find('.input-qty-baru').addClass('changed');
         
         if (diff > 0) {
            $badge.attr('class', 'label label-success badge-selisih').text('+' + diff.toLocaleString('id-ID'));
         } else {
            $badge.attr('class', 'label label-danger badge-selisih').text(diff.toLocaleString('id-ID'));
         }
      } else {
         $row.removeClass('row-changed');
         $row.find('.input-qty-baru').removeClass('changed');
         $badge.attr('class', 'label label-default badge-selisih').text('0');
      }

      // Hitung total perubahan
      var totalChanged = $('.row-changed').length;
      $('#pill_count_changed').text(totalChanged);

      if (totalChanged > 0) {
         $('#badge_changed_count').show();
         $('#num_changed').text(totalChanged);
         $('#btn_reset_all').prop('disabled', false).find('i').removeClass('text-muted').addClass('text-warning');
         $('#footer_changed_text').html('<strong style="color:#4ade80;">' + totalChanged + ' produk telah diubah.</strong> Klik tombol simpan untuk memperbarui database.');
      } else {
         $('#badge_changed_count').hide();
         $('#btn_reset_all').prop('disabled', true).find('i').addClass('text-muted').removeClass('text-warning');
         $('#footer_changed_text').text('Belum ada stok yang diubah. Ubah angka pada kolom Stok Baru di atas.');
      }

      if (currentFilter === 'changed') {
         applyTableFilter();
      }
   }

   // Fungsi Filter Gabungan (Pencarian Text + Pill Tabs)
   function applyTableFilter() {
      var q = $('#filter_produk_input').val().toLowerCase().trim();
      var visibleCount = 0;

      $('.row-item').each(function(){
         var $row = $(this);
         var kode = $row.data('kode') || '';
         var nama = $row.data('nama') || '';
         var matchSearch = (!q) || (kode.indexOf(q) !== -1 || nama.indexOf(q) !== -1);

         var matchPill = true;
         if (currentFilter === 'changed') {
            matchPill = $row.hasClass('row-changed');
         } else if (currentFilter === 'empty') {
            matchPill = ($row.data('empty') == '1');
         } else if (currentFilter === 'low') {
            matchPill = ($row.data('low') == '1');
         }

         if (matchSearch && matchPill) {
            $row.show();
            visibleCount++;
         } else {
            $row.hide();
         }
      });

      $('#lbl_showing_count').text(visibleCount);
      if (visibleCount === 0) {
         $('#row_no_filter_match').show();
      } else {
         $('#row_no_filter_match').hide();
      }
   }

   // Event input pada kolom qty
   $(document).on('input keyup change', '.input-qty-baru', function(){
      var $row = $(this).closest('.row-item');
      updateRowDiff($row);
   });

   // Filter live pencarian nama/kode produk di tabel
   $('#filter_produk_input').on('keyup input', function(){
      var q = $(this).val().trim();
      if (q.length > 0) {
         $('#btn_clear_search').show();
      } else {
         $('#btn_clear_search').hide();
      }
      applyTableFilter();
   });

   // Tombol Clear Search
   $('#btn_clear_search').on('click', function(){
      $('#filter_produk_input').val('').focus();
      $(this).hide();
      applyTableFilter();
   });

   // Klik Tab Pill Filter
   $('.bulk-pill-btn').on('click', function(e){
      e.preventDefault();
      $('.bulk-pill-btn').removeClass('active');
      $(this).addClass('active');
      currentFilter = $(this).data('filter');
      applyTableFilter();
   });

   // Tombol Reset Input ke Stok Awal
   $('#btn_reset_all').on('click', function(e){
      e.preventDefault();
      var totalChanged = $('.row-changed').length;
      if (totalChanged === 0) return;

      var executeReset = function() {
         $('.row-changed').each(function(){
            var $row = $(this);
            var orig = $row.find('.orig-qty').val();
            $row.find('.input-qty-baru').val(orig);
            updateRowDiff($row);
         });
         applyTableFilter();
      };

      if (typeof swal === 'function') {
         swal({
            title: "Reset Semua Perubahan?",
            text: "Seluruh angka input stok (" + totalChanged + " produk) akan dikembalikan ke stok semula.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#f59e0b",
            confirmButtonText: "Ya, Kembalikan!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
         }, function(isConfirm){
            if (isConfirm) {
               executeReset();
            }
         });
      } else {
         if (confirm("Kembalikan seluruh input (" + totalChanged + " produk) ke angka stok awal?")) {
            executeReset();
         }
      }
   });

   // Submit form edit massal via AJAX
   $('#form_bulk_stok').on('submit', function(e){
      e.preventDefault();
      var totalChanged = $('.row-changed').length;
      if (totalChanged === 0) {
         if (typeof show_alert === 'function') {
            show_alert('Anda belum mengubah angka stok pada produk manapun.', 'info');
         } else if (typeof swal === 'function') {
            swal('Info', 'Anda belum mengubah angka stok pada produk manapun.', 'info');
         } else {
            alert('Anda belum mengubah angka stok pada produk manapun.');
         }
         return false;
      }

      var $btn = $('#btn_save_all_stok');
      var origHtml = $btn.html();
      $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan ' + totalChanged + ' Produk...');

      $.ajax({
         url: $(this).attr('action'),
         type: 'POST',
         dataType: 'json',
         data: $(this).serialize(),
         success: function(res) {
            if (res.success) {
               if (res.redirect) {
                  window.location.href = res.redirect;
               } else {
                  $btn.prop('disabled', false).html(origHtml);
                  if (typeof show_alert === 'function') {
                     show_alert(res.message || 'Data Stok berhasil diperbarui.', 'success');
                  } else {
                     alert(res.message || 'Data Stok berhasil diperbarui.');
                  }
               }
            } else {
               $btn.prop('disabled', false).html(origHtml);
               if (typeof show_alert === 'function') {
                  show_alert(res.message || 'Gagal menyimpan stok massal.', 'warning');
               } else {
                  alert(res.message || 'Gagal menyimpan stok massal.');
               }
            }
         },
         error: function(xhr, status, err) {
            $btn.prop('disabled', false).html(origHtml);
            var errMsg = 'Terjadi kesalahan sistem saat menyimpan stok massal.';
            if (typeof show_alert === 'function') {
               show_alert(errMsg, 'warning');
            } else {
               alert(errMsg);
            }
         }
      });
   });
});
</script>
