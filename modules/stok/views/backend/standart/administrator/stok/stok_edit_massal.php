<?php
/**
 * View: Edit Semua Stok Produk (Massal)
 * File: stok_edit_massal.php
 */
?>
<style>
.bulk-card { border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.06); background: #fff; margin-bottom: 25px; }
.bulk-card .box-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; border-radius: 10px 10px 0 0; }
.table-bulk-stok th { background: #f1f5f9; color: #1e293b; font-weight: 700; font-size: 12px; vertical-align: middle !important; border-bottom: 2px solid #cbd5e1 !important; text-transform: uppercase; letter-spacing: 0.3px; }
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
   .bulk-card .box-header .row {
      flex-direction: column;
      align-items: stretch !important;
      gap: 10px;
   }
   .bulk-card .box-header .text-right {
      text-align: left !important;
      display: flex;
      flex-direction: column;
      gap: 8px;
   }
   .bulk-card .box-header form {
      margin-right: 0 !important;
      width: 100%;
      display: flex;
   }
   .bulk-card .box-header form .form-group {
      width: 100%;
      display: flex;
      align-items: center;
      gap: 6px;
   }
   .bulk-card .box-header form select {
      flex: 1;
      width: 100%;
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
      <div class="box-header with-border">
         <div class="row" style="display:flex; align-items:center; flex-wrap:wrap;">
            <div class="col-md-5 col-sm-6">
               <h3 class="box-title" style="font-weight:800; color:#0f172a;">
                  <i class="fa fa-list-ol text-primary"></i> Daftar Seluruh Produk &amp; Stok Fisik
               </h3>
               <div style="font-size:12px; color:#64748b; margin-top:2px;">
                  Total <strong id="lbl_total_baris"><?= count($items); ?></strong> item produk tercatat
               </div>
            </div>
            
            <div class="col-md-7 col-sm-6 text-right">
               <!-- Filter Gudang -->
               <form method="GET" action="<?= site_url('administrator/stok/edit_massal'); ?>" class="form-inline" style="display:inline-block; margin-right:8px;">
                  <div class="form-group">
                     <label style="font-size:12px; margin-right:4px;">Filter Gudang: </label>
                     <select name="gudang_id" class="form-control input-sm" onchange="this.form.submit()" style="font-weight:700;">
                        <option value="all" <?= ($gudang_sel === 'all') ? 'selected' : ''; ?>>-- Semua Gudang --</option>
                        <?php foreach($gudangs as $g): ?>
                           <option value="<?= $g->id; ?>" <?= ($gudang_sel == $g->id) ? 'selected' : ''; ?>>
                              <?= _ent($g->nama_gudang); ?>
                           </option>
                        <?php endforeach; ?>
                     </select>
                  </div>
               </form>

               <!-- Tombol Kembali -->
               <a href="<?= site_url('administrator/stok' . (!empty($gudang_sel) && $gudang_sel !== 'all' ? '?gudang_id=' . $gudang_sel : '')); ?>" class="btn btn-default btn-sm" style="font-weight:600;">
                  <i class="fa fa-arrow-left"></i> Kembali ke Dashboard
               </a>
            </div>
         </div>
      </div>

      <div class="box-body" style="padding: 20px;">

         <!-- Quick Search & Helper Controls -->
         <div class="row" style="margin-bottom: 16px;">
            <div class="col-md-6 col-sm-8">
               <div class="input-group">
                  <span class="input-group-addon" style="background:#f8fafc;"><i class="fa fa-search text-muted"></i></span>
                  <input type="text" id="filter_produk_input" class="form-control" placeholder="Cari kode atau nama produk di tabel ini..." autofocus>
               </div>
            </div>
            <div class="col-md-6 col-sm-4 text-right" style="padding-top: 6px;">
               <span class="badge bg-green" id="badge_changed_count" style="font-size:12px; padding:6px 12px; border-radius:12px; display:none;">
                  <i class="fa fa-pencil"></i> <span id="num_changed">0</span> produk diubah
               </span>
            </div>
         </div>

         <!-- FORM TABEL MASSAL -->
         <form id="form_bulk_stok" method="POST" action="<?= site_url('administrator/stok/edit_massal_save'); ?>">
            <input type="hidden" name="gudang_id" value="<?= _ent($gudang_sel); ?>">
            <div class="table-responsive" style="max-height: 650px; overflow-y: auto;">
               <table class="table table-bordered table-striped table-hover table-bulk-stok" id="table_bulk_editor">
                  <thead>
                     <tr>
                        <th width="40" class="text-center">#</th>
                        <th width="120">Kode Produk</th>
                        <th>Nama Produk &amp; Kategori</th>
                        <th width="150">Gudang</th>
                        <th width="80" class="text-center">Satuan</th>
                        <th width="120" class="text-center" style="background:#f1f5f9; color:#475569;">Stok Saat Ini</th>
                        <th width="150" class="text-center" style="background:#ecfdf5; color:#065f46;">Stok Baru *</th>
                        <th width="100" class="text-center">Selisih</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($items)): ?>
                        <?php $no = 1; foreach($items as $it): 
                           $cur_qty = (float)$it->qty;
                                                      $sat = !empty($it->singkatan) ? $it->singkatan : 'Pcs';
                        ?>
                        <tr class="row-item" id="row_<?= $it->id; ?>" data-id="<?= $it->id; ?>" data-kode="<?= strtolower($it->kode_produk); ?>" data-nama="<?= strtolower($it->nama_produk); ?>">
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
                           <td>
                              <span class="text-muted"><i class="fa fa-bank text-primary"></i> <?= _ent($it->nama_gudang); ?></span>
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
                     <?php else: ?>
                        <tr>
                           <td colspan="8" class="text-center text-muted" style="padding:40px;">
                              <i class="fa fa-info-circle fa-2x"></i><br>
                              Tidak ada data stok produk ditemukan untuk gudang ini.
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
   var changedCount = 0;

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
      if (totalChanged > 0) {
         $('#badge_changed_count').show();
         $('#num_changed').text(totalChanged);
         $('#footer_changed_text').html('<strong style="color:#4ade80;">' + totalChanged + ' produk telah diubah.</strong> Klik tombol simpan untuk memperbarui database.');
      } else {
         $('#badge_changed_count').hide();
         $('#footer_changed_text').text('Belum ada stok yang diubah. Ubah angka pada kolom Stok Baru di atas.');
      }
   }

   // Event input pada kolom qty
   $(document).on('input keyup change', '.input-qty-baru', function(){
      var $row = $(this).closest('.row-item');
      updateRowDiff($row);
   });

   // Filter live pencarian nama/kode produk di tabel
   $('#filter_produk_input').on('keyup', function(){
      var q = $(this).val().toLowerCase().trim();
      if (!q) {
         $('.row-item').show();
         return;
      }
      $('.row-item').each(function(){
         var kode = $(this).data('kode') || '';
         var nama = $(this).data('nama') || '';
         if (kode.indexOf(q) !== -1 || nama.indexOf(q) !== -1) {
            $(this).show();
         } else {
            $(this).hide();
         }
      });
   });

   // Submit form edit massal via AJAX
   $('#form_bulk_stok').on('submit', function(e){
      e.preventDefault();
      var totalChanged = $('.row-changed').length;
      if (totalChanged === 0) {
         if (typeof show_alert === 'function') {
            show_alert('Anda belum mengubah angka stok pada produk manapun.', 'info');
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
