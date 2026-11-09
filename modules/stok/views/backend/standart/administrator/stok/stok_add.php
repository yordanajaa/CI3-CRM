<?php
/**
 * View: Input Stok Manual
 * File: stok_add.php
 */
?>
<style>
.form-card { border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.06); background: #fff; margin-bottom: 25px; }
.form-card .box-header { padding: 18px 24px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; border-radius: 10px 10px 0 0; }
.form-card .box-title { font-weight: 700; font-size: 17px; color: #0f172a; }
.form-card .box-body { padding: 25px; }
.form-group label { font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px; }
.form-control { border-radius: 6px; border: 1px solid #cbd5e1; padding: 8px 12px; font-size: 13px; transition: all .2s; }
.form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }

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
      <i class="fa fa-cubes text-primary"></i> Input Stok Manual
      <small>Penyesuaian Fisik &amp; Tambah Stok Produk</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/stok'); ?>"><i class="fa fa-database"></i> Stok</a></li>
      <li class="active">Input Stok Manual</li>
   </ol>
</section>

<section class="content">
<form id="form_stok_manual" method="POST" action="<?= site_url('administrator/stok/add_save'); ?>">
   <!-- Hidden input untuk mode yang dipilih secara pasti -->
   <input type="hidden" name="mode" id="selected_mode" value="set">

   <div class="row">
      <div class="col-md-9 col-md-offset-1 col-lg-8 col-lg-offset-2">
         <div class="box form-card" style="border-top: 3px solid #10b981;">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-edit text-success"></i> Formulir Input / Penyesuaian Stok Barang</h3>
               <div class="box-tools pull-right">
                  <a href="<?= site_url('administrator/stok'); ?>" class="btn btn-default btn-xs" style="font-weight:600;">
                     <i class="fa fa-arrow-left"></i> Kembali ke Stok
                  </a>
               </div>
            </div>
            <div class="box-body">

               <!-- Step 1: Alokasi Produk -->
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>Pilih Produk <span class="text-danger">*</span></label>
                        <select class="form-control chosen-select" name="produk_id" id="produk_id" required style="width: 100%;">
                           <option value="">-- Cari / Pilih Produk --</option>
                           <?php foreach($produks as $p): ?>
                              <option value="<?= $p->id; ?>" data-satuan="<?= _ent($p->nama_satuan ?: 'Pcs'); ?>" data-kode="<?= _ent($p->kode_produk); ?>">
                                 <?= _ent($p->kode_produk . ' - ' . $p->nama_produk); ?>
                              </option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                  </div>
               </div>

               <!-- PANEL KOMPARASI 3 KOLOM: STOK SEBELUMNYA -> PERUBAHAN -> STOK AKHIR -->
               <div id="section_comparison" style="margin-bottom: 25px; display: none;">
                  <label style="font-size:13.5px; color:#1e293b; margin-bottom:10px; display:block;">
                     <i class="fa fa-balance-scale text-primary"></i> <strong>Perbandingan Stok Barang</strong>
                  </label>
                  <div class="row">
                     <!-- 1. STOK SEBELUMNYA (SAAT INI) -->
                     <div class="col-sm-4" style="margin-bottom: 12px;">
                        <div class="comp-card comp-card-prev">
                           <div class="comp-title" style="color: #475569;"><i class="fa fa-history"></i> Stok Sebelumnya</div>
                           <div class="comp-val" style="color: #1e293b;">
                              <span id="label_stok_sebelumnya">0</span>
                              <small style="font-size: 15px; font-weight: 700; color: #64748b;" class="lbl-satuan">Pcs</small>
                           </div>
                           <div>
                              <span class="label label-default" style="font-size: 11px;"><i class="fa fa-database"></i> Posisi di Sistem</span>
                           </div>
                           <div id="box_prev_rusak" style="display:none; font-size: 11px; font-weight: 700; color: #dc2626; margin-top: 5px;">
                              Rusak: <span id="disp_prev_rusak">0</span> <span class="lbl-satuan">Pcs</span>
                           </div>
                        </div>
                     </div>

                     <!-- 2. PERUBAHAN / PENYESUAIAN -->
                     <div class="col-sm-4" style="margin-bottom: 12px;">
                        <div class="comp-card comp-card-change" id="box_comp_change">
                           <div class="comp-title" id="title_comp_change" style="color: #15803d;"><i class="fa fa-exchange"></i> Penyesuaian</div>
                           <div class="comp-val" id="val_comp_change" style="color: #16a34a;">
                              +0 <small style="font-size: 15px; font-weight: 700;" class="lbl-satuan">Pcs</small>
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
                              <span id="label_stok_akhir">0</span>
                              <small style="font-size: 15px; font-weight: 700; color: #3b82f6;" class="lbl-satuan">Pcs</small>
                           </div>
                           <div>
                              <span class="label label-primary" id="badge_status_akhir" style="font-size: 11px;">Stok Baru Setelah Simpan</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- STEP 2: PILIH MODE PENYESUAIAN -->
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
                           <span class="mode-desc">Ditambahkan ke stok sebelumnya</span>
                        </div>
                     </div>

                     <!-- Opsi 3: Kurangi Keluar (-) -->
                     <div class="col-xs-12 col-sm-4" style="margin-bottom: 10px;">
                        <div class="mode-btn-card" id="card_mode_kurang" onclick="selectMode('kurang')">
                           <i class="fa fa-minus-circle fa-2x text-danger"></i>
                           <span class="mode-title">- Kurangi Stok Keluar</span>
                           <span class="mode-desc">Dikurangkan dari stok sebelumnya</span>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- STEP 3: INPUT QUANTITY -->
               <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 9px; padding: 20px; margin-bottom: 22px;">
                  <div class="row">
                     <div class="col-md-7">
                        <div class="form-group" style="margin-bottom: 0;">
                           <label id="label_input_qty" style="font-size: 14px; font-weight: 700; color: #0f172a;">
                              Total Stok Fisik Baru (Hasil Opname) <span class="text-danger">*</span>
                           </label>
                           <div class="input-group">
                              <input type="number" step="any" min="0" class="form-control input-lg" name="qty" id="input_qty" placeholder="0" required style="font-size: 22px; font-weight: 800; color: #0f172a; height: 50px;">
                              <span class="input-group-addon lbl-satuan" style="font-weight: 700; font-size: 16px; background: #e2e8f0; color: #334155;">Pcs</span>
                           </div>
                           <small class="text-muted" id="help_input_qty" style="display: block; margin-top: 6px; font-size: 12px;">
                              <i class="fa fa-info-circle text-primary"></i> Masukkan total fisik baru hasil penghitungan fisik.
                           </small>
                        </div>
                     </div>

                     <div class="col-md-5">
                        <div class="form-group" style="margin-bottom: 0;">
                           <label style="font-size: 14px; font-weight: 600; color: #475569;">
                              Jumlah Qty Rusak / Reject
                           </label>
                           <div class="input-group">
                              <input type="number" step="any" min="0" class="form-control input-lg" name="qty_rusak" id="input_qty_rusak" placeholder="0" value="0" style="font-size: 20px; font-weight: 700; color: #dc2626; height: 50px;">
                              <span class="input-group-addon lbl-satuan" style="font-weight: 700; font-size: 15px; background: #fee2e2; color: #dc2626;">Pcs</span>
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
                        Pilih produk untuk melihat simulasi perhitungan stok.
                     </div>
                  </div>
               </div>

               <!-- STEP 4: ALASAN PENYESUAIAN -->
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>Alasan / Keterangan Penyesuaian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Misal: Stok Awal, Hasil Hitung Fisik, Non-PO..." required value="Input Penyesuaian Manual Stok">
                     </div>
                     <input type="hidden" name="rak_id" id="rak_id" value="">
                  </div>
               </div>

            </div>

            <!-- Footer Tombol -->
            <div class="box-footer" style="padding: 18px 25px; background: #fafafa; border-top: 1px solid #f1f5f9; border-radius: 0 0 10px 10px;">
               <div class="pull-right">
                  <a href="<?= site_url('administrator/stok'); ?>" class="btn btn-default" style="margin-right: 10px; font-weight:600; padding: 10px 20px;">
                     <i class="fa fa-times"></i> Batal
                  </a>
                  <button type="submit" id="btn_submit_stok" class="btn btn-success" style="font-weight: 800; font-size: 14px; padding: 10px 30px; border-radius: 6px; box-shadow: 0 3px 8px rgba(16,185,129,0.35);">
                     <i class="fa fa-save"></i> Simpan Stok Sekarang
                  </button>
               </div>
            </div>

         </div>
      </div>
   </div>
</form>
</section>

<script>
var currentStokQty = 0;
var currentRusakQty = 0;
var currentSatuan = 'Pcs';

function updateSatuanLabel(sat) {
   currentSatuan = sat || 'Pcs';
   $('.lbl-satuan').text(currentSatuan);
}

function selectMode(mode) {
   $('#selected_mode').val(mode);

   // Update visual tabs
   $('.mode-btn-card').removeClass('active-set active-tambah active-kurang');
   
   if (mode === 'tambah') {
      $('#card_mode_tambah').addClass('active-tambah');
      $('#label_input_qty').html('Jumlah Unit yang Ditambahkan (+) <span class="text-danger">*</span>');
      $('#help_input_qty').html('<i class="fa fa-info-circle text-success"></i> Angka ini akan <strong>DITAMBAHKAN</strong> ke stok sebelumnya (' + currentStokQty.toLocaleString('id-ID') + ' ' + currentSatuan + ').');
      $('#keterangan').val('Penambahan Stok Masuk');
      $('#input_qty').attr('placeholder', 'Contoh: 10');
   } else if (mode === 'kurang') {
      $('#card_mode_kurang').addClass('active-kurang');
      $('#label_input_qty').html('Jumlah Unit yang Dikurangkan (-) <span class="text-danger">*</span>');
      $('#help_input_qty').html('<i class="fa fa-info-circle text-danger"></i> Angka ini akan <strong>DIKURANGKAN</strong> dari stok sebelumnya (' + currentStokQty.toLocaleString('id-ID') + ' ' + currentSatuan + ').');
      $('#keterangan').val('Pengurangan Stok Keluar');
      $('#input_qty').attr('placeholder', 'Contoh: 5');
   } else { // mode === 'set'
      $('#card_mode_set').addClass('active-set');
      $('#label_input_qty').html('Total Stok Fisik Baru (Hasil Opname) <span class="text-danger">*</span>');
      $('#help_input_qty').html('<i class="fa fa-info-circle text-primary"></i> Stok fisik saat ini adalah <strong>' + currentStokQty.toLocaleString('id-ID') + ' ' + currentSatuan + '</strong>. Masukkan total fisik baru hasil penghitungan fisik.');
      $('#keterangan').val('Input Penyesuaian Manual Stok');
      $('#input_qty').attr('placeholder', currentStokQty);
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
      changeText = '+' + inputVal.toLocaleString('id-ID') + ' ' + currentSatuan;
      badgeModeText = 'Tambah Masuk (+)';
      
      $('#box_comp_change').css({'background': '#f0fdf4', 'border': '2px dashed #86efac'});
      $('#title_comp_change').css('color', '#15803d');
      $('#val_comp_change').css('color', '#16a34a').text(changeText);
      $('#badge_comp_mode').attr('class', 'label label-success').text(badgeModeText);

      formulaText = 'Stok Sebelumnya (' + currentStokQty.toLocaleString('id-ID') + ') + Masuk (' + inputVal.toLocaleString('id-ID') + ') = Stok Akhir: ' + hasilVal.toLocaleString('id-ID') + ' ' + currentSatuan;
   } else if (mode === 'kurang') {
      hasilVal = Math.max(0, currentStokQty - inputVal);
      changeText = '-' + inputVal.toLocaleString('id-ID') + ' ' + currentSatuan;
      badgeModeText = 'Kurang Keluar (-)';

      $('#box_comp_change').css({'background': '#fef2f2', 'border': '2px dashed #fca5a5'});
      $('#title_comp_change').css('color', '#b91c1c');
      $('#val_comp_change').css('color', '#dc2626').text(changeText);
      $('#badge_comp_mode').attr('class', 'label label-danger').text(badgeModeText);

      formulaText = 'Stok Sebelumnya (' + currentStokQty.toLocaleString('id-ID') + ') - Keluar (' + inputVal.toLocaleString('id-ID') + ') = Stok Akhir: ' + hasilVal.toLocaleString('id-ID') + ' ' + currentSatuan;
      if (inputVal > currentStokQty) {
         formulaText += ' (Perhatian: Pengurangan melebihi stok sebelumnya, stok akan jadi 0)';
      }
   } else { // mode === 'set'
      hasilVal = Math.max(0, inputVal);
      var selisih = hasilVal - currentStokQty;
      var selisihSign = selisih >= 0 ? '+' : '';
      changeText = selisihSign + selisih.toLocaleString('id-ID') + ' ' + currentSatuan;
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

function checkLiveStok() {
   var pId = $('#produk_id').val();
   
   var $opt = $('#produk_id').find('option:selected');
   if ($opt.data('satuan')) {
      updateSatuanLabel($opt.data('satuan'));
   }

   if (!pId) {
      $('#section_comparison').slideUp(200);
      return;
   }

   $.ajax({
      url: '<?= site_url("administrator/stok/get_current_stok"); ?>',
      type: 'GET',
      dataType: 'json',
      data: { produk_id: pId },
      success: function(res) {
         if (res.success) {
            currentStokQty = parseFloat(res.qty) || 0;
            currentRusakQty = parseFloat(res.qty_rusak) || 0;
            updateSatuanLabel(res.nama_satuan);

            $('#label_stok_sebelumnya').text(currentStokQty.toLocaleString('id-ID'));
            if (currentRusakQty > 0) {
               $('#disp_prev_rusak').text(currentRusakQty.toLocaleString('id-ID'));
               $('#box_prev_rusak').show();
            } else {
               $('#box_prev_rusak').hide();
            }

            $('#section_comparison').slideDown(250);

            if (res.rak_id && !$('#rak_id').val()) {
               $('#rak_id').val(res.rak_id).trigger('change');
            }

            calculateSimulation();
         }
      }
   });
}

$(document).ready(function(){
   if ($.fn.select2) {
      $('.chosen-select').select2();
   } else if ($.fn.chosen) {
      $('.chosen-select').chosen({width: '100%'});
   }

   $('#produk_id').on('change', function(){
      checkLiveStok();
   });

   $('#input_qty').on('input keyup change', function(){
      calculateSimulation();
   });

   // Form Submit Handling via AJAX
   $('#form_stok_manual').on('submit', function(e){
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

      $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan Stok...');

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
                     show_alert(res.message || 'Data Stok berhasil disimpan.', 'success');
                  } else {
                     alert(res.message || 'Data Stok berhasil disimpan.');
                  }
               }
            } else {
               $btn.prop('disabled', false).html(origHtml);
               if (typeof show_alert === 'function') {
                  show_alert(res.message || 'Gagal menyimpan stok.', 'warning');
               } else {
                  alert(res.message || 'Gagal menyimpan stok.');
               }
            }
         },
         error: function(xhr, status, err) {
            $btn.prop('disabled', false).html(origHtml);
            var errMsg = 'Terjadi kesalahan saat menyimpan data stok.';
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
