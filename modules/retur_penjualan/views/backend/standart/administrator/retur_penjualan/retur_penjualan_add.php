<?php
/**
 * View: Buat / Edit Retur Penjualan (Desktop & Mobile Friendly)
 * File: retur_penjualan_add.php
 */
$is_edit = isset($retur);
$action_url = $is_edit
    ? site_url('administrator/retur_penjualan/edit_save/' . $retur->id)
    : site_url('administrator/retur_penjualan/add_save');
?>
<style>
.form-card {
   border-radius: 8px;
   border: 1px solid #e2e8f0;
   box-shadow: 0 2px 10px rgba(0,0,0,0.04);
   background: #fff;
   margin-bottom: 20px;
}
.form-card .box-header {
   padding: 14px 18px;
   border-bottom: 1px solid #f1f5f9;
   background: #fafafa;
   border-radius: 8px 8px 0 0;
}
.form-card .box-title {
   font-weight: 700;
   font-size: 15px;
   color: #1e293b;
   display: flex;
   align-items: center;
   gap: 8px;
}
.form-card .box-body {
   padding: 18px 20px;
}
.form-group label {
   font-weight: 600;
   font-size: 12.5px;
   color: #475569;
   margin-bottom: 6px;
   display: block;
}
.form-control {
   border-radius: 6px;
   border: 1px solid #cbd5e1;
   padding: 8px 12px;
   font-size: 13px;
   height: 38px;
   transition: all .2s;
}
.form-control:focus {
   border-color: #3b82f6;
   box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}
textarea.form-control {
   height: auto;
}
.table-responsive-custom {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow-x: auto;
   -webkit-overflow-scrolling: touch;
   background: #ffffff;
}
.table-item-form {
   width: 100%;
   margin-bottom: 0 !important;
}
.table-item-form th {
   background: #f1f5f9;
   font-size: 11.5px;
   text-transform: uppercase;
   letter-spacing: 0.3px;
   color: #475569;
   font-weight: 700;
   padding: 10px 8px !important;
   border-bottom: 2px solid #cbd5e1 !important;
   white-space: nowrap;
   vertical-align: middle !important;
}
.table-item-form td {
   padding: 8px !important;
   vertical-align: middle !important;
   font-size: 12.5px;
}
.retur-form-footer {
   padding: 14px 18px;
   background: #f8fafc;
   border-top: 1px solid #f1f5f9;
   border-radius: 0 0 8px 8px;
   display: flex;
   align-items: center;
   justify-content: space-between;
   flex-wrap: wrap;
   gap: 10px;
}

@media (max-width: 768px) {
   .form-card .box-body {
      padding: 14px 12px;
   }
   .retur-form-footer {
      flex-direction: column-reverse;
   }
   .retur-form-footer .btn {
      width: 100%;
      text-align: center;
      padding: 10px 14px;
   }
}
</style>

<section class="content-header">
   <h1>
      <i class="fa fa-reply-all text-primary"></i> <?= $is_edit ? 'Edit' : 'Buat'; ?> Retur Penjualan 
      <small><?= _ent($nomor_baru ?? ($retur->nomor_retur ?? '')); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= base_url('administrator/retur_penjualan'); ?>">Retur Penjualan</a></li>
      <li class="active"><?= $is_edit ? 'Edit' : 'Buat'; ?></li>
   </ol>
</section>

<section class="content">
<form id="form_retur_jual">
<div class="row">
   <div class="col-md-12">
      <!-- Header Retur Box -->
      <div class="box form-card" style="border-top: 3px solid #3b82f6;">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-file-text-o text-primary"></i> Header &amp; Informasi Retur Penjualan</h3>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label>Referensi Invoice <span class="text-danger">*</span></label>
                     <select class="form-control chosen" name="invoice_id" id="invoice_id" required>
                        <option value="">-- Pilih Invoice --</option>
                        <?php if (!empty($invoices)): ?>
                           <?php foreach($invoices as $inv): 
                              $sel_inv = (isset($retur) && $retur->invoice_id == $inv->id) ? 'selected' : '';
                           ?>
                              <option value="<?= $inv->id; ?>" <?= $sel_inv; ?>><?= _ent($inv->nomor_invoice); ?></option>
                           <?php endforeach; ?>
                        <?php endif; ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label>Tanggal Retur <span class="text-danger">*</span></label>
                     <input type="date" class="form-control" name="tanggal_retur" value="<?= isset($retur->tanggal_retur) ? date('Y-m-d', strtotime($retur->tanggal_retur)) : date('Y-m-d'); ?>" required>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label>Alasan Retur Utama <span class="text-danger">* (Wajib Diisi)</span></label>
                     <select class="form-control" name="alasan" id="alasan" required>
                        <option value="">-- Pilih Alasan Retur (Wajib) --</option>
                        <option value="cacat" <?= (isset($retur) && $retur->alasan == 'cacat') ? 'selected' : ''; ?>>Cacat / Rusak</option>
                        <option value="salah_kirim" <?= (isset($retur) && $retur->alasan == 'salah_kirim') ? 'selected' : ''; ?>>Salah Kirim Barang</option>
                        <option value="tidak_sesuai" <?= (isset($retur) && $retur->alasan == 'tidak_sesuai') ? 'selected' : ''; ?>>Tidak Sesuai Spesifikasi Pesanan</option>
                        <option value="kadaluarsa" <?= (isset($retur) && $retur->alasan == 'kadaluarsa') ? 'selected' : ''; ?>>Kadaluarsa / Expired</option>
                        <option value="lainnya" <?= (isset($retur) && $retur->alasan == 'lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                     <label>Tindak Lanjut Retur <span class="text-danger">*</span></label>
                     <select class="form-control" name="tindak_lanjut" required>
                        <option value="tukar_barang" <?= (isset($retur) && $retur->tindak_lanjut == 'tukar_barang') ? 'selected' : ''; ?>>Tukar Barang Baru</option>
                        <option value="refund" <?= (isset($retur) && $retur->tindak_lanjut == 'refund') ? 'selected' : ''; ?>>Refund (Pengembalian Dana)</option>
                        <option value="kredit_poin" <?= (isset($retur) && $retur->tindak_lanjut == 'kredit_poin') ? 'selected' : ''; ?>>Kredit Poin / Nota Kredit</option>
                     </select>
                  </div>
               </div>
            </div>

            <div class="form-group" style="margin-bottom:0;">
               <label>Detail / Catatan Alasan Retur <span class="text-danger">* (Wajib Diisi)</span></label>
               <textarea class="form-control" name="catatan" id="catatan_alasan" rows="2" placeholder="Jelaskan alasan detail pengembalian barang dari pelanggan (wajib)..." required><?= _ent($retur->catatan ?? ''); ?></textarea>
            </div>
         </div>
      </div>

      <!-- Item Box -->
      <div class="box form-card" style="border-top: 3px solid #f59e0b;">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-list text-warning"></i> Item Produk Retur</h3>
         </div>
         <div class="box-body">
            <div id="items_area">
               <?php if ($is_edit && !empty($items)): ?>
                  <div class="table-responsive-custom">
                     <table class="table table-bordered table-striped table-item-form">
                        <thead>
                           <tr>
                              <th>Produk</th>
                              <th class="text-center" width="90">Qty Retur</th>
                              <th width="150">Harga Satuan (IDR)</th>
                              <th width="170">Kondisi Barang</th>
                              <th>Alasan Spesifik Item</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($items as $idx => $it): ?>
                              <tr class="item-row">
                                 <input type="hidden" name="items[<?= $idx; ?>][produk_id]" value="<?= $it->produk_id; ?>">
                                 <td><strong><?= _ent($it->nama_produk ?? 'Produk'); ?></strong></td>
                                 <td>
                                    <input type="number" step="1" min="1" class="form-control" name="items[<?= $idx; ?>][qty_retur]" value="<?= (int)$it->qty_retur; ?>">
                                 </td>
                                 <td>
                                    <input type="text" class="form-control rupiah" name="items[<?= $idx; ?>][harga_satuan]" value="<?= number_format($it->harga_satuan, 0, ',', '.'); ?>">
                                 </td>
                                 <td>
                                    <select class="form-control item-kondisi-select" name="items[<?= $idx; ?>][kondisi]">
                                       <option value="rusak" <?= ($it->kondisi == 'rusak') ? 'selected' : ''; ?>>🔴 Rusak (Stok Rusak/Afkir)</option>
                                       <option value="baik" <?= ($it->kondisi == 'baik') ? 'selected' : ''; ?>>🟢 Baik (Stok Aktif Dijual)</option>
                                    </select>
                                 </td>
                                 <td>
                                    <input type="text" class="form-control item-alasan-input" name="items[<?= $idx; ?>][alasan]" value="<?= htmlspecialchars($it->alasan ?? ''); ?>">
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     </table>
                  </div>
               <?php else: ?>
                  <div class="callout callout-info" style="border-radius:6px; margin-bottom:0;">
                     <p><i class="fa fa-info-circle"></i> Pilih invoice di atas untuk memuat item pesanan secara otomatis.</p>
                  </div>
               <?php endif; ?>
            </div>
         </div>

         <!-- Card Footer: Action Buttons -->
         <div class="retur-form-footer">
            <div>
               <a href="<?= base_url('administrator/retur_penjualan'); ?>" class="btn btn-default btn-flat" style="border-radius:6px; font-weight:600; padding:8px 18px;">
                  <i class="fa fa-arrow-left"></i> Kembali ke Daftar Retur
               </a>
            </div>
            <div>
               <button type="button" id="btn_save" class="btn btn-primary btn-flat" style="border-radius:6px; font-weight:700; padding:8px 24px; font-size:13.5px;" <?= ($is_edit ? '' : 'disabled'); ?>>
                  <i class="fa fa-save"></i> <?= $is_edit ? 'Update Retur Penjualan' : 'Simpan Retur Penjualan'; ?>
               </button>
            </div>
         </div>
      </div>
   </div>
</div>
</form>
</section>

<script>
function formatRupiahVal(val) {
   var number_string = Math.round(parseFloat(val || 0)).toString().replace(/[^0-9]/g, '');
   var sisa   = number_string.length % 3;
   var rupiah = number_string.substr(0, sisa);
   var ribuan = number_string.substr(sisa).match(/\d{3}/g);
   if (ribuan) {
      var separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
   }
   return rupiah || '0';
}

$(document).ready(function(){
   $(document).on('keyup input', '.rupiah', function() {
      var val = $(this).val().replace(/[^0-9]/g, '');
      $(this).val(formatRupiahVal(val));
   });

   $(document).on('input keyup change', '#catatan_alasan', function() {
      var currentVal = $(this).val();
      $('.item-alasan-input').val(currentVal);
   });

   $('#alasan').on('change', function() {
      var alasanVal = $(this).val();
      if (alasanVal == 'cacat' || alasanVal == 'kadaluarsa') {
         $('.item-kondisi-select').val('rusak');
      } else if (alasanVal == 'salah_kirim' || alasanVal == 'tidak_sesuai') {
         $('.item-kondisi-select').val('baik');
      }
   });

   $('#invoice_id').on('change', function(){
      var inv_id = $(this).val();
      if(!inv_id){
         $('#btn_save').prop('disabled', true);
         return;
      }
      $.get('<?= site_url("administrator/retur_penjualan/get_invoice_items"); ?>', {invoice_id: inv_id}, function(r){
         if(r.success && r.items && r.items.length > 0){
            var currentHeaderCatatan = $('#catatan_alasan').val() || '';
            var currentAlasanHeader  = $('#alasan').val() || '';
            var defaultKondisi       = (currentAlasanHeader == 'cacat' || currentAlasanHeader == 'kadaluarsa') ? 'rusak' : 'baik';

            var html = '<div class="table-responsive-custom"><table class="table table-bordered table-striped table-item-form"><thead><tr><th>Produk</th><th class="text-center" width="90">Qty Invoice</th><th width="110">Qty Retur</th><th width="150">Harga Satuan (IDR)</th><th width="170">Kondisi Barang</th><th width="180">Lokasi Rak</th><th>Alasan Spesifik Item</th></tr></thead><tbody>';
            r.items.forEach(function(it, idx){
                var qty_inv = Math.round(parseFloat(it.qty || 0));
                var harga_sat = Math.round(parseFloat(it.harga_satuan || 0));
                var selBaik = defaultKondisi == 'baik' ? 'selected' : '';
                var selRusak = defaultKondisi == 'rusak' ? 'selected' : '';

                var rakOptions = '<option value="">-- Auto Rak Default --</option>';
                if (r.raks && r.raks.length > 0) {
                   r.raks.forEach(function(rk){
                      var selRk = (it.default_rak_id == rk.id) ? 'selected' : '';
                      var locName = 'Lokasi';
                      rakOptions += '<option value="'+rk.id+'" '+selRk+'>📍 '+rk.kode_rak+' ('+locName+')</option>';
                   });
                }

                html += '<tr class="item-row"><input type="hidden" name="items['+idx+'][produk_id]" value="'+it.produk_id+'"><td><strong>'+(it.nama_produk ? it.nama_produk : '<i class="text-muted">(Produk Telah Dihapus)</i>')+'</strong></td><td class="text-center"><strong>'+qty_inv+'</strong></td><td><input type="number" step="1" min="1" class="form-control" name="items['+idx+'][qty_retur]" value="1" max="'+qty_inv+'"></td><td><input type="text" class="form-control rupiah" name="items['+idx+'][harga_satuan]" value="'+formatRupiahVal(harga_sat)+'"></td><td><select class="form-control item-kondisi-select" name="items['+idx+'][kondisi]"><option value="rusak" '+selRusak+'>🔴 Rusak (Stok Rusak/Afkir)</option><option value="baik" '+selBaik+'>🟢 Baik (Stok Aktif Dijual)</option></select></td><td><select class="form-control rak-select" name="items['+idx+'][rak_id]">'+rakOptions+'</select></td><td><input type="text" class="form-control item-alasan-input" name="items['+idx+'][alasan]" value="'+currentHeaderCatatan+'"></td></tr>';
             });
            html += '</tbody></table></div>';
            $('#items_area').html(html);
            $('#btn_save').prop('disabled', false);
         } else {
            $('#items_area').html('<div class="callout callout-warning" style="border-radius:6px; margin-bottom:0;"><p><i class="fa fa-warning"></i> Invoice ini tidak memiliki item atau item telah diproses.</p></div>');
            $('#btn_save').prop('disabled', true);
         }
      },'json');
   });

   $('#btn_save').click(function(){
      var btn = $(this);
      btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
      $.ajax({
         url: '<?= $action_url; ?>',
         method: 'POST',
         data: $('#form_retur_jual').serialize(),
         dataType: 'json',
         success: function(res){
            if(res.success){
               window.location.href = res.redirect || '<?= base_url("administrator/retur_penjualan"); ?>';
            } else {
               show_alert(res.message, 'error');
               btn.prop('disabled', false).html('<i class="fa fa-save"></i> <?= $is_edit ? "Update Retur Penjualan" : "Simpan Retur Penjualan"; ?>');
            }
         },
         error: function(){
            btn.prop('disabled', false).html('<i class="fa fa-save"></i> <?= $is_edit ? "Update Retur Penjualan" : "Simpan Retur Penjualan"; ?>');
         }
      });
   });
});
</script>
