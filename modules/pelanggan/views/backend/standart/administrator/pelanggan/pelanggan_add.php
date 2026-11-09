<?php /* pelanggan_add.php - Modern & Clean Layout */
$is_edit = isset($pelanggan);
$action_url = $is_edit ? site_url('administrator/pelanggan/edit_save/'.$pelanggan->id) : site_url('administrator/pelanggan/add_save');
?>
<style>
.form-card { border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 3px 12px rgba(0,0,0,0.04); background: #fff; margin-bottom: 20px; overflow: hidden; }
.form-card .box-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: #fafcff; }
.form-card .box-title { font-weight: 700; font-size: 15px; color: #1e293b; }
.form-card .box-body { padding: 20px; }
.form-group label { font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px; display: block; }
.form-control { border-radius: 8px; border: 1px solid #cbd5e1; padding: 8px 12px; height: 40px; font-size: 13px; transition: border-color .2s; }
.form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); outline: none; }
textarea.form-control { height: auto; }

@media (max-width: 768px) {
  .form-card .box-body { padding: 14px 12px; }
  .box-footer .pull-left,
  .box-footer .pull-right {
    float: none !important;
    width: 100% !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 8px !important;
    margin-bottom: 8px;
  }
  .box-footer .btn {
    width: 100% !important;
    margin-right: 0 !important;
    padding: 10px !important;
  }
}
</style>

<section class="content-header">
   <h1><i class="fa fa-user-plus text-primary"></i> <?= $is_edit ? 'Edit' : 'Tambah'; ?> Pelanggan <small>Kelola Data Pelanggan</small></h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= base_url('administrator/pelanggan'); ?>">Pelanggan</a></li>
      <li class="active"><?= $is_edit ? 'Edit' : 'Tambah'; ?></li>
   </ol>
</section>

<section class="content">
<form id="form_pelanggan" onsubmit="return false;">
   <div class="row">
      <div class="col-md-12">
         <div class="box form-card" style="border-top: 3px solid #3b82f6;">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-id-card-o text-primary"></i> Informasi &amp; Profil Pelanggan</h3>
            </div>
            <div class="box-body">
               <!-- Row 1: Kode & Nama Pelanggan -->
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Kode Pelanggan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kode_pelanggan"
                           value="<?= $is_edit ? _ent($pelanggan->kode_pelanggan) : _ent($kode_baru); ?>"
                           <?= $is_edit ? 'readonly' : ''; ?> required>
                     </div>
                  </div>
                  <div class="col-md-8">
                     <div class="form-group">
                        <label>Nama Pelanggan / Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_pelanggan"
                           placeholder="Masukkan nama lengkap / nama toko..."
                           value="<?= $is_edit ? _ent($pelanggan->nama_pelanggan) : ''; ?>" required>
                     </div>
                  </div>
               </div>

               <!-- Row 2: Kontak Person, Telepon, Email -->
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Kontak Person</label>
                        <input type="text" class="form-control" name="kontak_person" placeholder="Nama Penanggung Jawab" value="<?= $is_edit ? _ent($pelanggan->kontak_person) : ''; ?>">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>No. Telepon / HP</label>
                        <input type="text" class="form-control" name="telepon" placeholder="08xxxxxxxxxx" value="<?= $is_edit ? _ent($pelanggan->telepon) : ''; ?>">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Alamat Email</label>
                        <input type="email" class="form-control" name="email" placeholder="contoh@domain.com" value="<?= $is_edit ? _ent($pelanggan->email) : ''; ?>">
                     </div>
                  </div>
               </div>

               <!-- Row 3: NPWP, Kota, Status -->
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label>Nomor NPWP</label>
                        <input type="text" class="form-control" name="npwp" placeholder="00.000.000.0-000.000" value="<?= $is_edit ? _ent($pelanggan->npwp) : ''; ?>">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label>Kota / Wilayah</label>
                        <input type="text" class="form-control" name="kota" placeholder="Nama Kota / Kabupaten" value="<?= $is_edit ? _ent($pelanggan->kota) : ''; ?>">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label>Kategori Pelanggan <span class="text-danger">*</span></label>
                        <?php $cur_src = strtolower($pelanggan->source ?? 'manual'); ?>
                        <select class="form-control" name="source">
                           <option <?= ($is_edit && in_array($cur_src, ['manual', 'toko', 'offline'])) || !$is_edit ? 'selected' : ''; ?> value="manual">Toko / Regular / Offline</option>
                           <option <?= ($is_edit && in_array($cur_src, ['resi', 'scan_resi'])) ? 'selected' : ''; ?> value="resi">Resi</option>
                           <option <?= ($is_edit && in_array($cur_src, ['tiktok', 'tiktokshop', 'tiktok_shop', 'tiktok shop'])) ? 'selected' : ''; ?> value="tiktok">TikTok Shop</option>
                           <option <?= ($is_edit && $cur_src == 'shopee') ? 'selected' : ''; ?> value="shopee">Shopee</option>
                           <option <?= ($is_edit && $cur_src == 'tokopedia') ? 'selected' : ''; ?> value="tokopedia">Tokopedia</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label>Status Pelanggan <span class="text-danger">*</span></label>
                        <select class="form-control" name="status">
                           <option <?= ($is_edit && $pelanggan->status == 'aktif') || !$is_edit ? 'selected' : ''; ?> value="aktif">Aktif (Dapat Bertransaksi)</option>
                           <option <?= ($is_edit && $pelanggan->status == 'nonaktif') ? 'selected' : ''; ?> value="nonaktif">Nonaktif (Dikunci)</option>
                        </select>
                     </div>
                  </div>
               </div>

               <!-- Row 4: Limit Kredit & Catatan -->
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Limit Kredit Piutang (Rp)</label>
                        <input type="text" class="form-control rupiah" name="limit_kredit" placeholder="0" value="<?= $is_edit ? number_format($pelanggan->limit_kredit ?? 0, 0, ',', '.') : '0'; ?>">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Catatan Internal</label>
                        <input type="text" class="form-control" name="catatan" placeholder="Catatan internal transaksi pelanggan..." value="<?= $is_edit ? _ent($pelanggan->catatan) : ''; ?>">
                     </div>
                  </div>
               </div>

               <!-- Row 5: Alamat Lengkap -->
               <div class="form-group" style="margin-bottom:0;">
                  <label>Alamat Lengkap Pengiriman</label>
                  <textarea class="form-control" name="alamat" rows="3" placeholder="Jalan, RT/RW, Kecamatan, Kategori Lokasi..."><?= $is_edit ? _ent($pelanggan->alamat) : ''; ?></textarea>
               </div>
            </div>

            <!-- Card Footer: Action Buttons at the Bottom! -->
            <div class="box-footer" style="padding:15px 20px; background:#f8fafc; border-top:1px solid #f1f5f9; border-radius: 0 0 8px 8px;">
               <div class="pull-left">
                  <a href="<?= base_url('administrator/pelanggan'); ?>" class="btn btn-default btn-flat" style="border-radius:6px; font-weight:600; padding:8px 18px;">
                     <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                  </a>
               </div>
               <div class="pull-right">
                   <?php if (!$is_edit): ?>
                   <button type="button" id="btn_save_and_so" class="btn btn-success btn-flat" style="border-radius:6px; font-weight:700; padding:8px 20px; font-size:14px; margin-right:8px;">
                      <i class="fa fa-shopping-cart"></i> Simpan &amp; Buat Transaksi Penjualan
                   </button>
                   <?php endif; ?>
                   <button type="button" id="btn_save" class="btn btn-primary btn-flat" style="border-radius:6px; font-weight:700; padding:8px 24px; font-size:14px;">
                      <i class="fa fa-save"></i> <?= $is_edit ? 'Update Data Pelanggan' : 'Simpan Pelanggan'; ?>
                   </button>
                </div>
            </div>
         </div>
      </div>
   </div>
</form>
</section>

<script>
$(document).ready(function(){
   $('#btn_save').click(function(){
      var btn = $(this);
      btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
      $.ajax({ 
         url: '<?= $action_url; ?>', 
         method: 'POST', 
         data: $('#form_pelanggan').serialize() + '&save_type=redirect', 
         dataType: 'json',
         success: function(res){
            if(res.success){ 
               if(res.redirect){ 
                  window.location.href = res.redirect; 
               } else { 
                  show_alert(res.message || 'Pelanggan berhasil disimpan.', 'success'); 
                  btn.prop('disabled', false).html('<i class="fa fa-save"></i> <?= $is_edit ? 'Update Data Pelanggan' : 'Simpan Pelanggan'; ?>');
               } 
            } else { 
               show_alert(res.message || 'Gagal menyimpan data.', 'error'); 
               btn.prop('disabled', false).html('<i class="fa fa-save"></i> <?= $is_edit ? 'Update Data Pelanggan' : 'Simpan Pelanggan'; ?>'); 
            }
         }, 
         error: function(xhr){ 
            var errMsg = 'Terjadi kesalahan server saat menyimpan data.';
            try {
               var r = JSON.parse(xhr.responseText);
               if (r && r.message) errMsg = r.message;
            } catch(e){}
            show_alert(errMsg, 'error');
            btn.prop('disabled', false).html('<i class="fa fa-save"></i> <?= $is_edit ? 'Update Data Pelanggan' : 'Simpan Pelanggan'; ?>'); 
         }
      });
   });

   $('#btn_save_and_so').click(function(){
       var btn = $(this);
       btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan &amp; Membuka SO...');
       $.ajax({ 
          url: '<?= $action_url; ?>', 
          method: 'POST', 
          data: $('#form_pelanggan').serialize() + '&save_type=sales_order', 
          dataType: 'json',
          success: function(res){
             if(res.success){ 
                if(res.redirect){ 
                   window.location.href = res.redirect; 
                } else { 
                   window.location.href = '<?= site_url("administrator/sales_order/add"); ?>';
                } 
             } else { 
                show_alert(res.message || 'Gagal menyimpan data.', 'error'); 
                btn.prop('disabled', false).html('<i class="fa fa-shopping-cart"></i> Simpan &amp; Buat Transaksi Penjualan'); 
             }
          }, 
          error: function(xhr){ 
             var errMsg = 'Terjadi kesalahan server saat menyimpan data.';
             try {
                var r = JSON.parse(xhr.responseText);
                if (r && r.message) errMsg = r.message;
             } catch(e){}
             show_alert(errMsg, 'error');
             btn.prop('disabled', false).html('<i class="fa fa-shopping-cart"></i> Simpan &amp; Buat Transaksi Penjualan'); 
          }
       });
    });

   $('#form_pelanggan input').keypress(function(e){
      if (e.which == 13) {
         e.preventDefault();
         $('#btn_save').click();
      }
   });
});
</script>
