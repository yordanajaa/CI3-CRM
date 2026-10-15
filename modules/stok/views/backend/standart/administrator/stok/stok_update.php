<?php
/**
 * View: Edit / Sesuaikan Stok Barang
 * File: stok_update.php
 */
$satuan_label = !empty($stok->singkatan) ? $stok->singkatan : (!empty($stok->nama_satuan) ? $stok->nama_satuan : 'Pcs');
$current_qty = (float)($stok->qty ?? 0);
$current_rusak = (float)($stok->qty_rusak ?? 0);
?>
<style>
.form-card { border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.06); background: #fff; margin-bottom: 25px; }
.form-card .box-header { padding: 18px 24px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; border-radius: 10px 10px 0 0; }
.form-card .box-title { font-weight: 700; font-size: 17px; color: #0f172a; }
.form-card .box-body { padding: 25px; }
.form-group label { font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px; }
.form-control { border-radius: 6px; border: 1px solid #cbd5e1; padding: 8px 12px; font-size: 13px; transition: all .2s; }
.form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }

/* Hero Product Card */
.product-hero-card { background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 18px 22px; margin-bottom: 22px; }

/* 3-Box Comparison */
.comp-card { border-radius: 10px; padding: 16px 14px; text-align: center; transition: all 0.25s ease; min-height: 120px; display: flex; flex-direction: column; justify-content: center; }
.comp-card-prev { background: #f1f5f9; border: 2px solid #cbd5e1; }
.comp-card-change { background: #f0fdf4; border: 2px dashed #86efac; }
.comp-card-next { background: #eff6ff; border: 2px solid #3b82f6; }

.comp-title { font-size: 11.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
.comp-val { font-size: 28px; font-weight: 900; line-height: 1.1; margin: 4px 0 6px 0; }

/* Custom Mode Selector Tabs */
.mode-btn-card {
   background: #fff;
   border: 2px solid #e2e8f0;
   border-radius: 9px;
   padding: 14px 10px;
   text-align: center;
   cursor: pointer;
   transition: all 0.2s ease;
   user-select: none;
   width: 100%;
   display: block;
}
.mode-btn-card:hover {
   border-color: #94a3b8;
   transform: translateY(-2px);
   box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}
.mode-btn-card.active-set {
   background: #eff6ff !important;
   border-color: #2563eb !important;
   box-shadow: 0 4px 14px rgba(37,99,235,0.15);
}
.mode-btn-card.active-set .mode-title { color: #1d4ed8; font-weight: 800; }
.mode-btn-card.active-set i { color: #2563eb; }

.mode-btn-card.active-tambah {
   background: #f0fdf4 !important;
   border-color: #16a34a !important;
   box-shadow: 0 4px 14px rgba(22,163,74,0.15);
}
.mode-btn-card.active-tambah .mode-title { color: #15803d; font-weight: 800; }
.mode-btn-card.active-tambah i { color: #16a34a; }

.mode-btn-card.active-kurang {
   background: #fef2f2 !important;
   border-color: #dc2626 !important;
   box-shadow: 0 4px 14px rgba(220,38,38,0.15);
}
.mode-btn-card.active-kurang .mode-title { color: #b91c1c; font-weight: 800; }
.mode-btn-card.active-kurang i { color: #dc2626; }

.mode-title { font-size: 13.5px; font-weight: 700; color: #334155; margin-top: 4px; display: block; }
.mode-desc { font-size: 11px; color: #64748b; margin-top: 2px; display: block; }
</style>

<section class="content-header">
   <h1>
      <i class="fa fa-pencil text-warning"></i> Sesuaikan Stok Barang
      <small><?= _ent($stok->nama_produk ?? ''); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/stok'); ?>"><i class="fa fa-database"></i> Stok</a></li>
      <li class="active">Sesuaikan Stok</li>
   </ol>
</section>

<section class="content">
<form id="form_stok_edit" method="POST" action="<?= site_url('administrator/stok/edit_save/' . $stok->id); ?>">
   <!-- Hidden input untuk mode yang dipilih secara pasti -->
   <input type="hidden" name="mode" id="selected_mode" value="set">

   <div class="row">
      <div class="col-md-9 col-md-offset-1 col-lg-8 col-lg-offset-2">
         <div class="box form-card" style="border-top: 3px solid #f59e0b;">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-pencil-square-o text-warning"></i> Form Penyesuaian Stok Fisik</h3>
               <div class="box-tools pull-right">
                  <a href="<?= site_url('administrator/stok'); ?>" class="btn btn-default btn-xs" style="font-weight:600;">
                     <i class="fa fa-arrow-left"></i> Kembali ke Stok
                  </a>
               </div>
            </div>
            <div class="box-body">

               <!-- Info Header Produk -->
               <div class="product-hero-card">
                  <div class="row" style="display:flex; align-items:center; flex-wrap:wrap;">
                     <div class="col-sm-8">
                        <span class="label label-primary" style="font-size:11px; padding:3px 8px;"><?= _ent($stok->kode_produk ?? '-'); ?></span>
                        <h3 style="margin: 6px 0 6px 0; font-weight:800; color:#0f172a; font-size:19px;"><?= _ent($stok->nama_produk ?? ''); ?></h3>
                        <?php if (!empty($stok->nama_kategori)): ?>
                           <div style="font-size:13px; color:#475569;">
                              Kategori: <strong><?= _ent($stok->nama_kategori); ?></strong>
                           </div>
                        <?php endif; ?>
                     </div>
                     <div class="col-sm-4 text-right">
                        <span class="label label-default" style="font-size:11px;"><i class="fa fa-clock-o"></i> Update: <?= $stok->updated_at ? date('d/m/Y H:i', strtotime($stok->updated_at)) : '-'; ?></span>
                     </div>
                  </div>
               </div>

               <!-- PANEL KOMPARASI 3 KOLOM: STOK SEBELUMNYA -> PERUBAHAN -> STOK AKHIR -->
               <div style="margin-bottom: 25px;">
                  <label style="font-size:13.5px; color:#1e293b; margin-bottom:10px; display:block;">
                     <i class="fa fa-balance-scale text-primary"></i> <strong>Perbandingan Stok Barang</strong>
                  </label>
                  <div class="row">
                     <!-- 1. STOK SEBELUMNYA (SAAT INI) -->
                     <div class="col-sm-4" style="margin-bottom: 12px;">
                        <div class="comp-card comp-card-prev">
                           <div class="comp-title" style="color: #475569;"><i class="fa fa-history"></i> Stok Sebelumnya</div>
                           <div class="comp-val" style="color: #1e293b;">
                              <span id="label_stok_sebelumnya"><?= number_format($current_qty, 0, ',', '.'); ?></span>
                              <small style="font-size: 15px; font-weight: 700; color: #64748b;"><?= _ent($satuan_label); ?></small>
                           </div>
                           <div>
                              <span class="label label-default" style="font-size: 11px;"><i class="fa fa-database"></i> Posisi di Sistem</span>
                           </div>
                           <?php if ($current_rusak > 0): ?>
                              <div style="font-size: 11px; font-weight: 700; color: #dc2626; margin-top: 5px;">
                                 Rusak: <?= number_format($current_rusak, 0, ',', '.'); ?> <?= _ent($satuan_label); ?>
                              </div>
                           <?php endif; ?>
                        </div>
                     </div>

                     <!-- 2. PERUBAHAN / PENYESUAIAN -->
                     <div class="col-sm-4" style="margin-bottom: 12px;">
                        <div class="comp-card comp-card-change" id="box_comp_change">
                           <div class="comp-title" id="title_comp_change" style="color: #15803d;"><i class="fa fa-exchange"></i> Penyesuaian</div>
                           <div class="comp-val" id="val_comp_change" style="color: #16a34a;">
                              +0 <small style="font-size: 15px; font-weight: 700;"><?= _ent($satuan_label); ?></small>
                           </div>
                           <div>
                              <span class="label label-success" id="badge_comp_mode" style="font-size: 11px;">Set Fisik Baru</span>
                           </div>
                        </div>
                     </div>

                     <!-- 3. STOK AKHIR BARU (SESUDAHNYA) -->
                     <div class="col-sm-4" style="margin-bottom: 12px;">
                        <div class="comp-card comp-card-next">
                           <div class="comp-title" style="color: #1e40af;"><i class="fa fa-check-circle"></i> Stok Akhir (Sesudahnya)</div>
                           <div class="comp-val" style="color: #1d4ed8;">
                              <span id="label_stok_akhir"><?= number_format($current_qty, 0, ',', '.'); ?></span>
                              <small style="font-size: 15px; font-weight: 700; color: #3b82f6;"><?= _ent($satuan_label); ?></small>
                           </div>
                           <div>
                              <span class="label label-primary" id="badge_status_akhir" style="font-size: 11px;">Stok Baru Setelah Simpan</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- STEP 1: PILIH MODE PENYESUAIAN -->
               <div class="form-group" style="margin-bottom: 22px;">
                  <label style="font-size: 13.5px;">Pilih Cara Penyesuaian Stok <span class="text-danger">*</span></label>
                  <div class="row">
                     <!-- Opsi 1: Set Total Fisik -->
                     <div class="col-xs-12 col-sm-4" style="margin-bottom: 10px;">
                        <div class="mode-btn-card active-set" id="card_mode_set" onclick="selectMode('set')">
                           <i class="fa fa-crosshairs fa-2x"></i>
                           <span class="mode-title">Set Total Fisik</span>
                           <span class="mode-desc">Angka diinput langsung jadi stok akhir (Opname)</span>
                        </div>
                     </div>

                     <!-- Opsi 2: Tambah Masuk (+) -->
                     <div class="col-xs-12 col-sm-4" style="margin-bottom: 10px;">
                        <div class="mode-btn-card" id="card_mode_tambah" onclick="selectMode('tambah')">
                           <i class="fa fa-plus-circle fa-2x text-success"></i>
                           <span class="mode-title">+ Tambah Stok Masuk</span>
                           <span class="mode-desc">Ditambahkan ke stok sebelumnya (<?= number_format($current_qty, 0, ',', '.'); ?>)</span>
                        </div>
                     </div>

                     <!-- Opsi 3: Kurangi Keluar (-) -->
                     <div class="col-xs-12 col-sm-4" style="margin-bottom: 10px;">
                        <div class="mode-btn-card" id="card_mode_kurang" onclick="selectMode('kurang')">
                           <i class="fa fa-minus-circle fa-2x text-danger"></i>
                           <span class="mode-title">- Kurangi Stok Keluar</span>
                           <span class="mode-desc">Dikurangkan dari stok sebelumnya (<?= number_format($current_qty, 0, ',', '.'); ?>)</span>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- STEP 2: INPUT QUANTITY -->
               <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 9px; padding: 20px; margin-bottom: 22px;">
                  <div class="row">
                     <div class="col-md-7">
                        <div class="form-group" style="margin-bottom: 0;">
                           <label id="label_input_qty" style="font-size: 14px; font-weight: 700; color: #0f172a;">
                              Total Stok Fisik Baru (Hasil Opname) <span class="text-danger">*</span>
                           </label>
                           <div class="input-group">
                              <input type="number" step="any" min="0" class="form-control input-lg" name="qty" id="input_qty" placeholder="<?= $current_qty; ?>" value="<?= $current_qty; ?>" required style="font-size: 22px; font-weight: 800; color: #0f172a; height: 50px;">
                              <span class="input-group-addon" style="font-weight: 700; font-size: 16px; background: #e2e8f0; color: #334155;"><?= _ent($satuan_label); ?></span>
                           </div>
                           <small class="text-muted" id="help_input_qty" style="display: block; margin-top: 6px; font-size: 12px;">
                              <i class="fa fa-info-circle text-primary"></i> Stok fisik saat ini adalah <strong><?= number_format($current_qty, 0, ',', '.'); ?> <?= _ent($satuan_label); ?></strong>. Masukkan total fisik baru hasil penghitungan fisik.
                           </small>
                        </div>
                     </div>

                     <div class="col-md-5">
                        <div class="form-group" style="margin-bottom: 0;">
                           <label style="font-size: 14px; font-weight: 600; color: #475569;">
                              Jumlah Qty Rusak / Reject
                           </label>
                           <div class="input-group">
                              <input type="number" step="any" min="0" class="form-control input-lg" name="qty_rusak" id="input_qty_rusak" placeholder="0" value="<?= $current_rusak; ?>" style="font-size: 20px; font-weight: 700; color: #dc2626; height: 50px;">
                              <span class="input-group-addon" style="font-weight: 700; font-size: 15px; background: #fee2e2; color: #dc2626;"><?= _ent($satuan_label); ?></span>
                           </div>
                           <small class="text-muted" style="display: block; margin-top: 6px; font-size: 12px;">
                              Barang cacat/reject (tidak dihitung stok baik).
                           </small>
                        </div>
                     </div>
                  </div>

                  <!-- Formula Rumus Real-Time -->
                  <div style="margin-top: 16px; padding: 12px 16px; background: #fff; border: 1px solid #cbd5e1; border-radius: 8px;">
                     <div style="font-size: 12px; font-weight: 700; color: #475569;"><i class="fa fa-calculator text-primary"></i> Rincian Perhitungan Stok:</div>
                     <div id="simulasi_formula" style="font-size: 14px; font-weight: 700; color: #1e40af; margin-top: 4px;">
                        Stok Sebelumnya (<?= number_format($current_qty, 0, ',', '.'); ?>) &rarr; Ditetapkan Baru (<?= number_format($current_qty, 0, ',', '.'); ?>) &bull; Selisih: 0 <?= _ent($satuan_label); ?>
                     </div>
                  </div>
               </div>

               <!-- STEP 3: ALASAN PENYESUAIAN -->
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>Alasan / Keterangan Penyesuaian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Misal: Koreksi Selisih, Masuk Tambahan, dll..." required value="Penyesuaian Manual Stok">
                     </div>
                     <input type="hidden" name="rak_id" value="<?= $stok->rak_id ?? ''; ?>">
                  </div>
               </div>

            </div>

            <!-- Footer Tombol -->
            <div class="box-footer" style="padding: 18px 25px; background: #fafafa; border-top: 1px solid #f1f5f9; border-radius: 0 0 10px 10px;">
               <div class="pull-right">
                  <a href="<?= site_url('administrator/stok'); ?>" class="btn btn-default" style="margin-right: 10px; font-weight:600; padding: 10px 20px;">
                     <i class="fa fa-times"></i> Batal
                  </a>
                  <button type="submit" id="btn_submit_stok" class="btn btn-warning" style="font-weight: 800; font-size: 14px; padding: 10px 30px; border-radius: 6px; box-shadow: 0 3px 8px rgba(245,158,11,0.35); color: #fff;">
                     <i class="fa fa-save"></i> Simpan Penyesuaian Stok
                  </button>
               </div>
            </div>

         </div>
      </div>
   </div>
</form>
</section>

<script>
var currentStokQty = <?= (float)$current_qty; ?>;
var currentRusakQty = <?= (float)$current_rusak; ?>;
var satuanLabel = '<?= addslashes($satuan_label); ?>';

function selectMode(mode) {
   $('#selected_mode').val(mode);

   // Update visual tabs
   $('.mode-btn-card').removeClass('active-set active-tambah active-kurang');
   
   if (mode === 'tambah') {
      $('#card_mode_tambah').addClass('active-tambah');
      $('#label_input_qty').html('Jumlah Unit yang Ditambahkan (+) <span class="text-danger">*</span>');
      $('#help_input_qty').html('<i class="fa fa-info-circle text-success"></i> Angka ini akan <strong>DITAMBAHKAN</strong> ke stok sebelumnya (' + currentStokQty.toLocaleString('id-ID') + ' ' + satuanLabel + ').');
      $('#keterangan').val('Penambahan Stok Masuk');
      
      // Jika input masih sama dengan stok sebelumnya, ganti placeholder/value
      var curVal = parseFloat($('#input_qty').val());
      if (curVal === currentStokQty) {
         $('#input_qty').val('').attr('placeholder', 'Contoh: 10');
      }
   } else if (mode === 'kurang') {
      $('#card_mode_kurang').addClass('active-kurang');
      $('#label_input_qty').html('Jumlah Unit yang Dikurangkan (-) <span class="text-danger">*</span>');
      $('#help_input_qty').html('<i class="fa fa-info-circle text-danger"></i> Angka ini akan <strong>DIKURANGKAN</strong> dari stok sebelumnya (' + currentStokQty.toLocaleString('id-ID') + ' ' + satuanLabel + ').');
      $('#keterangan').val('Pengurangan Stok Keluar');

      var curVal = parseFloat($('#input_qty').val());
      if (curVal === currentStokQty) {
         $('#input_qty').val('').attr('placeholder', 'Contoh: 5');
      }
   } else { // mode === 'set'
      $('#card_mode_set').addClass('active-set');
      $('#label_input_qty').html('Total Stok Fisik Baru (Hasil Opname) <span class="text-danger">*</span>');
      $('#help_input_qty').html('<i class="fa fa-info-circle text-primary"></i> Stok fisik saat ini adalah <strong>' + currentStokQty.toLocaleString('id-ID') + ' ' + satuanLabel + '</strong>. Masukkan total fisik baru hasil penghitungan fisik.');
      $('#keterangan').val('Penyesuaian Manual Stok');

      if ($('#input_qty').val() === '') {
         $('#input_qty').val(currentStokQty);
      }
   }

   calculateSimulation();
}

function calculateSimulation() {
   var mode = $('#selected_mode').val() || 'set';
   var rawInput = $('#input_qty').val();
   var inputVal = parseFloat(rawInput);
   if (isNaN(inputVal) || rawInput === '') {
      inputVal = 0;
   }

   var formulaText = '';
   var hasilVal = 0;
   var changeText = '';
   var badgeModeText = '';

   if (mode === 'tambah') {
      hasilVal = currentStokQty + inputVal;
      changeText = '+' + inputVal.toLocaleString('id-ID') + ' ' + satuanLabel;
      badgeModeText = 'Tambah Masuk (+)';
      
      $('#box_comp_change').css({'background': '#f0fdf4', 'border': '2px dashed #86efac'});
      $('#title_comp_change').css('color', '#15803d');
      $('#val_comp_change').css('color', '#16a34a').text(changeText);
      $('#badge_comp_mode').attr('class', 'label label-success').text(badgeModeText);

      formulaText = 'Stok Sebelumnya (' + currentStokQty.toLocaleString('id-ID') + ') + Masuk (' + inputVal.toLocaleString('id-ID') + ') = Stok Akhir: ' + hasilVal.toLocaleString('id-ID') + ' ' + satuanLabel;
   } else if (mode === 'kurang') {
      hasilVal = Math.max(0, currentStokQty - inputVal);
      changeText = '-' + inputVal.toLocaleString('id-ID') + ' ' + satuanLabel;
      badgeModeText = 'Kurang Keluar (-)';

      $('#box_comp_change').css({'background': '#fef2f2', 'border': '2px dashed #fca5a5'});
      $('#title_comp_change').css('color', '#b91c1c');
      $('#val_comp_change').css('color', '#dc2626').text(changeText);
      $('#badge_comp_mode').attr('class', 'label label-danger').text(badgeModeText);

      formulaText = 'Stok Sebelumnya (' + currentStokQty.toLocaleString('id-ID') + ') - Keluar (' + inputVal.toLocaleString('id-ID') + ') = Stok Akhir: ' + hasilVal.toLocaleString('id-ID') + ' ' + satuanLabel;
      if (inputVal > currentStokQty) {
         formulaText += ' (Perhatian: Pengurangan melebihi stok sebelumnya, stok akan jadi 0)';
      }
   } else { // mode === 'set'
      hasilVal = Math.max(0, inputVal);
      var selisih = hasilVal - currentStokQty;
      var selisihSign = selisih >= 0 ? '+' : '';
      changeText = selisihSign + selisih.toLocaleString('id-ID') + ' ' + satuanLabel;
      badgeModeText = 'Set Total Baru';

      $('#box_comp_change').css({'background': '#eff6ff', 'border': '2px dashed #93c5fd'});
      $('#title_comp_change').css('color', '#1e40af');
      $('#val_comp_change').css('color', '#2563eb').text(changeText);
      $('#badge_comp_mode').attr('class', 'label label-primary').text(badgeModeText);

      formulaText = 'Stok Sebelumnya (' + currentStokQty.toLocaleString('id-ID') + ') &rarr; Ditetapkan Baru (' + hasilVal.toLocaleString('id-ID') + ') &bull; Selisih: ' + changeText;
   }

   $('#label_stok_akhir').text(hasilVal.toLocaleString('id-ID'));
   $('#simulasi_formula').html(formulaText);
}

$(document).ready(function(){
   if ($.fn.select2) {
      $('.chosen-select').select2();
   } else if ($.fn.chosen) {
      $('.chosen-select').chosen({width: '100%'});
   }

   $('#input_qty').on('input keyup change', function(){
      calculateSimulation();
   });

   // Inisialisasi awal
   calculateSimulation();

   // Form Submit Handling via AJAX
   $('#form_stok_edit').on('submit', function(e){
      e.preventDefault();
      var $form = $(this);
      var $btn = $('#btn_submit_stok');
      var origHtml = $btn.html();

      var inputVal = $('#input_qty').val();
      if (inputVal === '' || isNaN(parseFloat(inputVal))) {
         alert('Silakan masukkan jumlah stok dengan benar.');
         $('#input_qty').focus();
         return false;
      }

      $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan Perubahan...');

      $.ajax({
         url: $form.attr('action'),
         type: 'POST',
         dataType: 'json',
         data: $form.serialize(),
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
                  show_alert(res.message || 'Gagal menyimpan perubahan.', 'warning');
               } else {
                  alert(res.message || 'Gagal menyimpan perubahan.');
               }
            }
         },
         error: function(xhr, status, err) {
            $btn.prop('disabled', false).html(origHtml);
            var errMsg = 'Terjadi kesalahan saat menyimpan data penyesuaian stok.';
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
