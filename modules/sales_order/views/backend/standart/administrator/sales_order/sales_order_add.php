<?php
$is_edit = isset($so);
$action_url = $is_edit
    ? site_url('administrator/sales_order/edit_save/' . $so->id)
    : site_url('administrator/sales_order/add_save');

$diskon_persen_init = 0;
if ($is_edit && isset($so->subtotal) && $so->subtotal > 0 && isset($so->diskon_total)) {
    $diskon_persen_init = round(($so->diskon_total / $so->subtotal) * 100, 2);
}
?>
<link rel="stylesheet" href="<?= base_url('asset/admin-lte/plugins/select2/select2.min.css'); ?>">
<style>
@keyframes soFadeInUp {
  from { opacity: 0; transform: translateY(8px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Modern & Mobile-First Clean Styling */
/* Select2 Modern Searchable Dropdown */
.select2-container {
  width: 100% !important;
}
.select2-container--default .select2-selection--single {
  height: 38px !important;
  line-height: 36px !important;
  border-radius: 8px !important;
  border: 1px solid #cbd5e1 !important;
  background-color: #ffffff !important;
  padding: 0 10px !important;
  display: flex !important;
  align-items: center !important;
  transition: all .15s ease !important;
  position: relative !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
  color: #1e293b !important;
  font-size: 13px !important;
  padding-left: 0 !important;
  padding-right: 44px !important;
  line-height: 36px !important;
  font-weight: 500 !important;
  overflow: hidden !important;
  text-overflow: ellipsis !important;
  white-space: nowrap !important;
  display: block !important;
  max-width: 100% !important;
}
.select2-container--default .select2-selection--single .select2-selection__clear {
  position: absolute !important;
  right: 24px !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
  font-size: 15px !important;
  font-weight: bold !important;
  color: #94a3b8 !important;
  cursor: pointer !important;
  line-height: 1 !important;
  padding: 2px !important;
  z-index: 2 !important;
  transition: color 0.15s ease !important;
}
.select2-container--default .select2-selection--single .select2-selection__clear:hover {
  color: #ef4444 !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 36px !important;
  right: 8px !important;
}
.select2-container--default .select2-selection--single:focus,
.select2-container--default.select2-container--open .select2-selection--single {
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.12) !important;
  outline: none !important;
}
.select2-dropdown {
  border: 1px solid #cbd5e1 !important;
  border-radius: 8px !important;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
  z-index: 9999 !important;
  overflow: hidden !important;
}
.select2-search--dropdown {
  padding: 8px !important;
  background: #f8fafc !important;
  border-bottom: 1px solid #f1f5f9 !important;
}
.select2-search--dropdown .select2-search__field {
  border: 1px solid #cbd5e1 !important;
  border-radius: 6px !important;
  padding: 6px 12px !important;
  font-size: 13px !important;
  height: 36px !important;
  outline: none !important;
  background: #ffffff !important;
}
.select2-search--dropdown .select2-search__field:focus {
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 2px rgba(59,130,246,0.1) !important;
}
.select2-results__option {
  padding: 8px 12px !important;
  font-size: 13px !important;
  color: #334155 !important;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
  background-color: #3b82f6 !important;
  color: #ffffff !important;
}
.select2-container--default .select2-results__option[aria-selected=true] {
  background-color: #eff6ff !important;
  color: #1d4ed8 !important;
  font-weight: 600 !important;
}

/* Select2 inside Table Rows */
#tbl_items .select2-container--default .select2-selection--single {
  height: 34px !important;
  line-height: 32px !important;
  border-radius: 6px !important;
  position: relative !important;
}
#tbl_items .select2-container--default .select2-selection--single .select2-selection__rendered {
  line-height: 32px !important;
  font-size: 12px !important;
  padding-right: 38px !important;
}
#tbl_items .select2-container--default .select2-selection--single .select2-selection__clear {
  position: absolute !important;
  right: 22px !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
  font-size: 14px !important;
  color: #94a3b8 !important;
  line-height: 1 !important;
}
#tbl_items .select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 32px !important;
}

.form-card {
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 3px 14px rgba(0,0,0,0.03);
  background: #ffffff;
  margin-bottom: 18px;
  animation: soFadeInUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  overflow: hidden;
}
.form-card .box-header { 
  padding: 14px 18px; 
  border-bottom: 1px solid #f1f5f9; 
  background: #fafcff; 
}
.form-card .box-title { 
  font-weight: 700; 
  font-size: 14px; 
  color: #1e293b; 
}
.form-card .box-body { 
  padding: 18px; 
}

.form-group {
  margin-bottom: 15px;
}
.form-group label { 
  font-weight: 600; 
  font-size: 13px; 
  color: #334155; 
  margin-bottom: 6px; 
  display: block;
}
.form-control { 
  border-radius: 8px; 
  border: 1px solid #cbd5e1; 
  padding: 8px 12px; 
  height: 38px;
  font-size: 13px; 
  color: #1e293b;
  transition: all .15s ease;
}
.form-control:focus { 
  border-color: #3b82f6; 
  box-shadow: 0 0 0 3px rgba(59,130,246,0.12); 
  outline: none;
}
textarea.form-control {
  height: auto;
}

/* Chosen Select Full Width & Clean */
.chosen-container {
  width: 100% !important;
  font-size: 13px !important;
}
.chosen-container-single .chosen-single {
  height: 38px !important;
  line-height: 36px !important;
  border-radius: 8px !important;
  border: 1px solid #cbd5e1 !important;
  background: #ffffff !important;
  box-shadow: none !important;
  padding: 0 12px !important;
  color: #1e293b !important;
}
.chosen-container-single .chosen-single div b {
  background-position: 0 8px !important;
}
.chosen-container .chosen-drop {
  border-radius: 8px !important;
  border: 1px solid #cbd5e1 !important;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}



/* Table Item Rows */
.table-responsive {
  -webkit-overflow-scrolling: touch;
  border-radius: 8px;
  border: 1px solid #e2e8f0;
  margin-bottom: 12px;
}
#tbl_items {
  margin-bottom: 0;
}
#tbl_items th {
  background: #f8fafc;
  color: #475569;
  font-weight: 700;
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 0.3px;
  padding: 10px 12px;
  border-bottom: 2px solid #e2e8f0;
}
#tbl_items td {
  padding: 8px 10px;
  vertical-align: middle;
}
#tbl_items .form-control {
  height: 34px;
  font-size: 13px;
}

/* Responsive & Mobile Screens */
@media (max-width: 768px) {
  .form-card .box-body {
    padding: 14px 12px;
  }
  .form-card .box-header {
    padding: 12px 14px;
  }
  .mobile-table-hint {
    display: block !important;
  }
  #tbl_items {
    min-width: 650px;
  }
  
  
  
  /* Stack footer buttons cleanly */
  .box-footer .pull-left,
  .box-footer .pull-right {
    float: none !important;
    width: 100% !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 8px !important;
    margin-bottom: 6px;
  }
  .box-footer .btn {
    width: 100% !important;
    padding: 10px !important;
  }
}
@media (min-width: 769px) {
  .mobile-table-hint {
    display: none !important;
  }
}
</style>

<section class="content-header">
   <h1><i class="fa fa-shopping-bag text-primary"></i> <?= $is_edit ? 'Edit Penjualan' : 'Tambah Penjualan'; ?> <small><?= _ent($is_edit ? ($so->nomor_so ?? '') : ($nomor_baru ?? '')); ?></small></h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= base_url('administrator/sales_order'); ?>">Penjualan</a></li>
      <li class="active"><?= $is_edit ? 'Edit' : 'Tambah'; ?></li>
   </ol>
</section>

<section class="content">

<!-- Banner Mode Switcher to Penjualan Cepat -->
<div class="alert alert-info" style="background:#eff6ff !important; border:1px solid #bfdbfe !important; color:#1e40af !important; border-radius:8px; margin-bottom:18px; padding:12px 18px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
   <div>
      <i class="fa fa-file-text-o text-primary" style="font-size:16px;"></i> 
      <strong>Mode Penjualan Regular:</strong> Digunakan untuk penawaran pesanan, B2B regular, sistem tempo, dan pengiriman terjadwal.
   </div>
   <div>
      <a href="<?= site_url('administrator/sales_order/cepat'); ?>" class="btn btn-xs btn-success" style="font-weight:700; border-radius:4px; padding:6px 14px; background:#059669; border-color:#047857; color:#fff; box-shadow:0 2px 6px rgba(5,150,105,0.3);">
         <i class="fa fa-bolt"></i> Pelanggan Mau Langsung Bayar Lunas? Buka Penjualan Cepat (POS) &rarr;
      </a>
   </div>
</div>

<form id="form_so">
<div class="row">
   <div class="col-md-12">
      <!-- Header Box -->
      <div class="box form-card" style="border-top: 3px solid #3b82f6;">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-file-text-o text-primary"></i> Header &amp; Konfigurasi Penjualan</h3>
         </div>
         <div class="box-body">
            <div class="row">
               <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                     <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                        <label style="margin:0;"><i class="fa fa-user text-primary"></i> Pelanggan <span class="text-danger">*</span></label>
                        <div>
                           <a href="javascript:void(0);" id="btn_refresh_pelanggan" class="text-success" style="font-size:11px; font-weight:600; margin-right:8px;" title="Segarkan daftar pelanggan">
                              <i class="fa fa-refresh"></i> Segarkan List
                           </a>
                           <?php if (is_allowed('pelanggan_add', false)): ?>
                              <a href="<?= site_url('administrator/pelanggan/add'); ?>" target="_blank" class="text-primary" style="font-size:11px; font-weight:600;">
                                 <i class="fa fa-plus-circle"></i> + Pelanggan Baru
                              </a>
                           <?php endif; ?>
                        </div>
                     </div>
                     <select class="form-control select2" name="pelanggan_id" id="pelanggan_id" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php foreach($pelanggans as $p): ?>
                           <?php 
                              $t_badge = strtoupper($p->tipe_pelanggan ?: 'RETAIL');
                              $telp_fmt = !empty($p->no_telp) ? ' ('.$p->no_telp.')' : '';
                           ?>
                           <option value="<?= $p->id; ?>" 
                                   data-kode="<?= _ent($p->kode_pelanggan); ?>"
                                   data-nama="<?= _ent($p->nama_pelanggan); ?>"
                                   data-tipe="<?= _ent($p->tipe_pelanggan); ?>"
                                   data-telp="<?= _ent($p->no_telp); ?>"
                                   data-alamat="<?= _ent($p->alamat); ?>"
                                   <?= (($is_edit && $so->pelanggan_id == $p->id) || (!$is_edit && $this->input->get('pelanggan_id') == $p->id)) ? 'selected' : ''; ?>>
                              <?= _ent($p->kode_pelanggan.' - '.$p->nama_pelanggan . ' [' . $t_badge . ']' . $telp_fmt); ?>
                           </option>
                        <?php endforeach; ?>
                     </select>

                     <!-- Live Customer Info Preview Card -->
                     <div id="customer_info_card" style="display:none; margin-top:8px; padding:8px 12px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:6px;">
                        <div>
                           <strong id="card_cust_nama" style="font-size:13px; color:#1e40af;">-</strong>
                           <span id="card_cust_tipe" class="label label-info" style="font-size:9px; margin-left:4px; vertical-align:middle;">RETAIL</span>
                           <div style="font-size:11px; color:#2563eb; margin-top:3px;">
                              <i class="fa fa-phone"></i> <span id="card_cust_telp">-</span> | 
                              <i class="fa fa-id-card-o"></i> Kode: <span id="card_cust_kode">-</span>
                           </div>
                           <div style="font-size:11px; color:#475569; margin-top:2px;">
                              <i class="fa fa-map-marker"></i> <span id="card_cust_alamat">-</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php
                  $default_gudang_id = $is_edit ? ($so->gudang_id ?? '') : (isset($gudangs[0]) ? $gudangs[0]->id : (isset($default_gudang->id) ? $default_gudang->id : 1));
               ?>
               <input type="hidden" name="gudang_id" id="gudang_id" value="<?= $default_gudang_id; ?>">
               <div class="col-md-3 col-sm-6 col-xs-6">
                  <div class="form-group"><label>Tanggal Penjualan <span class="text-danger">*</span></label>
                     <input type="date" class="form-control" name="tanggal_so" value="<?= $is_edit ? $so->tanggal_so : date('Y-m-d'); ?>" required>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6 col-xs-6">
                  <div class="form-group"><label>Est. Tanggal Kirim</label>
                     <input type="date" class="form-control" name="tanggal_estimasi_kirim" value="<?= $is_edit ? $so->tanggal_estimasi_kirim : ''; ?>">
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-md-3 col-sm-6 col-xs-6">
                  <div class="form-group"><label>Diskon Keseluruhan (%)</label>
                     <input type="number" step="0.1" min="0" max="100" class="form-control" name="diskon_persen_total" id="diskon_persen_total" value="<?= $diskon_persen_init; ?>">
                     <input type="hidden" name="diskon_total" id="diskon_total" value="<?= $is_edit ? (float)$so->diskon_total : 0; ?>">
                  </div>
               </div>
               <div class="col-md-3 col-sm-6 col-xs-6">
                  <div class="form-group"><label>Pajak (%)</label>
                     <input type="number" step="1" min="0" class="form-control" name="pajak_persen" id="pajak_persen" value="<?= $is_edit ? (float)$so->pajak_persen : 0; ?>">
                  </div>
               </div>
               <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group" style="margin-bottom:0;"><label>Catatan Penjualan</label>
                     <textarea class="form-control" name="catatan" rows="1" placeholder="Catatan khusus transaksi penjualan..."><?= $is_edit ? _ent($so->catatan) : ''; ?></textarea>
                  </div>
               </div>
            </div>
         </div>
      </div>


      <!-- Item Box -->
      <div class="box form-card" style="border-top: 3px solid #10b981;">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-cubes text-success"></i> Item Produk Pesanan</h3>
            <div class="box-tools pull-right">
               <button type="button" id="btn_add_item" class="btn btn-sm btn-success" style="border-radius:4px;"><i class="fa fa-plus"></i> Tambah Item Produk</button>
            </div>
         </div>
         <div class="box-body">
            <div class="mobile-table-hint text-muted" style="display:none; font-size:11px; margin-bottom:6px; color:#64748b;">
               <i class="fa fa-arrows-h text-primary"></i> <em>Geser tabel ke kiri/kanan untuk melihat Qty, Diskon, dan Subtotal</em>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered table-striped" id="tbl_items">
                  <thead>
                     <tr class="active">
                        <th width="35%">Produk</th>
                        <th width="10%">Qty</th>
                        <th width="8%">Satuan</th>
                        <th width="18%">Harga Jual (IDR)</th>
                        <th width="10%">Disc%</th>
                        <th width="15%">Subtotal (IDR)</th>
                        <th width="80">Stok</th>
                        <th width="40"></th>
                     </tr>
                  </thead>
                  <tbody id="item_rows">
                     <?php if ($is_edit && !empty($items)): ?>
                        <?php foreach($items as $idx => $it): ?>
                           <tr id="item_row_<?= $idx; ?>" class="item-row">
                              <td>
                                 <select class="form-control produk-select" style="width:100%;" name="items[<?= $idx; ?>][produk_id]">
                                    <option value="">-- Pilih Produk --</option>
                                    <?php foreach($produks as $p): ?>
                                       <option value="<?= $p->id; ?>" data-harga="<?= $p->harga_jual; ?>" <?= ($it->produk_id == $p->id) ? 'selected' : ''; ?>>
                                          <?= _ent($p->kode_produk.' - '.$p->nama_produk); ?>
                                       </option>
                                    <?php endforeach; ?>
                                 </select>
                              </td>
                              <td><input type="number" step="1" min="1" class="form-control qty-input" name="items[<?= $idx; ?>][qty]" value="<?= (int)$it->qty; ?>"></td>
                              <td><input type="text" class="form-control" name="items[<?= $idx; ?>][satuan]" style="width:60px" value="<?= _ent($it->singkatan ?? $it->satuan); ?>"></td>
                              <td><input type="text" class="form-control harga-input rupiah" name="items[<?= $idx; ?>][harga_satuan]" value="<?= (float)$it->harga_satuan; ?>"></td>
                              <td><input type="text" class="form-control disc-input" name="items[<?= $idx; ?>][diskon_persen]" value="<?= (float)$it->diskon_persen; ?>"></td>
                              <td><input type="text" class="form-control subtotal-display" value="<?= (float)$it->subtotal; ?>" readonly></td>
                              <td><span class="stok-display badge bg-green">-</span></td>
                              <td><button type="button" class="btn btn-xs btn-danger remove-row"><i class="fa fa-times"></i></button></td>
                           </tr>
                        <?php endforeach; ?>
                     <?php else: ?>
                        <tr id="item_row_0" class="item-row">
                           <td><select class="form-control produk-select" style="width:100%;" name="items[0][produk_id]"><option value="">-- Pilih Produk --</option><?php foreach($produks as $p): ?><option value="<?= $p->id; ?>" data-harga="<?= $p->harga_jual; ?>"><?= _ent($p->kode_produk.' - '.$p->nama_produk); ?></option><?php endforeach; ?></select></td>
                           <td><input type="number" step="1" min="1" class="form-control qty-input" name="items[0][qty]" value="1"></td>
                           <td><input type="text" class="form-control" name="items[0][satuan]" style="width:60px"></td>
                           <td><input type="text" class="form-control harga-input rupiah" name="items[0][harga_satuan]" value="0"></td>
                           <td><input type="text" class="form-control disc-input" name="items[0][diskon_persen]" value="0"></td>
                           <td><input type="text" class="form-control subtotal-display" value="0" readonly></td>
                           <td><span class="stok-display badge bg-green">-</span></td>
                           <td><button type="button" class="btn btn-xs btn-danger remove-row"><i class="fa fa-times"></i></button></td>
                        </tr>
                     <?php endif; ?>
                  </tbody>
                  <tfoot>
                     <tr><td colspan="5" class="text-right"><strong>Subtotal:</strong></td><td colspan="3"><strong id="display_subtotal">Rp 0</strong></td></tr>
                     <tr><td colspan="5" class="text-right">Diskon Keseluruhan:</td><td colspan="3" class="text-danger" id="display_diskon">- Rp 0</td></tr>
                     <tr><td colspan="5" class="text-right">Pajak:</td><td colspan="3" id="display_pajak">Rp 0</td></tr>
                     <tr class="active" style="background:#f1f5f9;"><td colspan="5" class="text-right"><strong style="font-size:14px;">TOTAL:</strong></td><td colspan="3"><strong class="text-success" id="display_total" style="font-size: 16px;">Rp 0</strong></td></tr>
                  </tfoot>
               </table>
            </div>
         </div>

         <!-- Card Footer: Action Buttons at the Bottom! -->
         <div class="box-footer" style="padding:15px 20px; background:#f8fafc; border-top:1px solid #f1f5f9; border-radius: 0 0 8px 8px;">
            <div class="pull-left">
               <a href="<?= base_url('administrator/sales_order'); ?>" class="btn btn-default btn-flat" style="border-radius:6px; font-weight:600; padding:8px 18px;">
                  <i class="fa fa-arrow-left"></i> Kembali ke Daftar SO
               </a>
            </div>
            <div class="pull-right" style="display:flex; gap:10px; align-items:center;">
               <button type="button" id="btn_save" class="btn btn-default btn-flat" style="border-radius:6px; font-weight:600; padding:8px 18px; font-size:14px; border:1px solid #cbd5e1;">
                  <i class="fa fa-save text-muted"></i> <?= $is_edit ? 'Simpan (Draft)' : 'Simpan Draft'; ?>
               </button>
               <button type="button" id="btn_save_confirm" class="btn btn-success btn-flat" style="border-radius:6px; font-weight:700; padding:8px 22px; font-size:14px; box-shadow:0 3px 10px rgba(16,185,129,0.25);">
                  <i class="fa fa-check-circle"></i> <?= $is_edit ? 'Update &amp; Konfirmasi Langsung' : '⚡ Simpan &amp; Konfirmasi Langsung'; ?>
               </button>
            </div>
         </div>
      </div>
   </div>
</div>

</form>

</section>

<script src="<?= base_url('asset/admin-lte/plugins/select2/select2.full.min.js'); ?>"></script>
<script>
var item_count = <?= ($is_edit && !empty($items)) ? count($items) : 1; ?>;
var available_produks = [];
var produks_initial = <?= json_encode(array_map(function($p){ return ['id'=>$p->id, 'kode'=>$p->kode_produk, 'nama'=>$p->nama_produk, 'satuan'=>$p->nama_satuan ?? 'Pcs', 'harga_jual'=>$p->harga_jual, 'harga_jual_grosir'=>$p->harga_jual_grosir, 'harga_jual_distributor'=>$p->harga_jual_distributor, 'harga_jual_vip'=>$p->harga_jual_vip, 'qty'=>(float)($p->stok_qty ?? 0), 'stok'=>(float)($p->stok_qty ?? 0)]; }, $produks)); ?>;

function play_scanner_beep() {
   try {
      var ctx = new (window.AudioContext || window.webkitAudioContext)();
      var osc = ctx.createOscillator();
      var gain = ctx.createGain();
      osc.type = 'sine';
      osc.frequency.value = 1800;
      gain.gain.setValueAtTime(0.3, ctx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.00001, ctx.currentTime + 0.12);
      osc.connect(gain);
      gain.connect(ctx.destination);
      osc.start();
      osc.stop(ctx.currentTime + 0.12);
   } catch(e){}
}

function build_options() {
   var list = (available_produks && available_produks.length > 0) ? available_produks : produks_initial;
   if (!list || list.length === 0) {
      return '<option value="">-- Tidak ada produk aktif di sistem --</option>';
   }
   var opts = '<option value="">-- Pilih Produk --</option>';
   list.forEach(function(p) {
      var pId = p.id;
      var pKode = p.kode_produk || p.kode || '';
      var pNama = p.nama_produk || p.nama || '';
      var pHarga = p.harga_jual || 0;
      var stok = (p.qty !== undefined) ? parseFloat(p.qty) : (p.stok !== undefined ? parseFloat(p.stok) : 0);
      var stokBadge = ' [Stok: ' + stok + ']';
      opts += '<option value="' + pId + '" data-harga="' + pHarga + '" data-stok="' + stok + '">' + pKode + ' - ' + pNama + stokBadge + '</option>';
   });
   return opts;
}

function init_produk_select2($container) {
   if (typeof $.fn.select2 === 'function') {
      var $targets = $container ? $container.find('.produk-select') : $('.produk-select');
      $targets.each(function() {
         if ($(this).data('select2')) {
            $(this).select2('destroy');
         }
         $(this).select2({
            placeholder: '-- Cari / Pilih Produk --',
            allowClear: true,
            width: '100%'
         });
      });
   }
}

function update_all_product_dropdowns() {
   var new_opts = build_options();
   $('.produk-select').each(function() {
      var current_val = $(this).val();
      if ($(this).data('select2')) {
         $(this).select2('destroy');
      }
      $(this).html(new_opts);
      if (current_val) {
         $(this).val(current_val);
      }
      var $row = $(this).closest('.item-row');
      cek_stok($(this).val(), $('#gudang_id').val(), $row.find('.stok-display'));
   });
   init_produk_select2();
}

function load_produk_by_gudang(gudang_id) {
   if (!gudang_id) {
      available_produks = [];
      update_all_product_dropdowns();
      return;
   }
   
   $.ajax({
      url: '<?= base_url("administrator/sales_order/get_produk_by_gudang"); ?>',
      data: {gudang_id: gudang_id},
      dataType: 'json',
      cache: false,
      success: function(res) {
         if (res && res.success && res.data) {
            available_produks = res.data;
         } else {
            available_produks = [];
         }
         update_all_product_dropdowns();
      },
      error: function() {
         available_produks = [];
         update_all_product_dropdowns();
      }
   });
}



function format_rp(n){return 'Rp '+parseInt(n||0).toLocaleString('id-ID');}
function format_num_id(val){return parseInt(val||0).toLocaleString('id-ID');}

function show_alert(msg, type) {
   if (typeof swal !== 'undefined') {
      var titles = {warning: 'Peringatan!', error: 'Error!', success: 'Berhasil!', info: 'Info'};
      swal(titles[type] || 'Pemberitahuan', msg, type || 'info');
   } else {
      alert(msg);
   }
}

function recalc_row($row){var qty=parseFloat($row.find('.qty-input').val())||0;var harga=parseFloat($row.find('.harga-input').val())||0;var disc=parseFloat($row.find('.disc-input').val())||0;var sub=(qty*harga)*(1-disc/100);$row.find('.subtotal-display').val(sub.toFixed(0));recalc_total();}

function recalc_total(){
   var sub = 0;
   $('.item-row').each(function(){
      sub += parseFloat($(this).find('.subtotal-display').val()) || 0;
   });
   
   var disc_pct = parseFloat($('#diskon_persen_total').val()) || 0;
   var dis_nominal = sub * (disc_pct / 100);
   $('#diskon_total').val(dis_nominal.toFixed(0));
   
   var pjk_pct = parseFloat($('#pajak_persen').val()) || 0;
   var after_disc = Math.max(0, sub - dis_nominal);
   var pjk_nominal = after_disc * (pjk_pct / 100);
   var total = after_disc + pjk_nominal;
   
   $('#display_subtotal').text(format_rp(sub));
   $('#display_diskon').text('- ' + format_rp(dis_nominal));
   $('#display_pajak').text(format_rp(pjk_nominal) + (pjk_pct > 0 ? ' (' + pjk_pct + '%)' : ''));
   $('#display_total').text(format_rp(total));
}

function validate_row_qty($row) {
   var $qtyInp  = $row.find('.qty-input');
   var qty      = parseFloat($qtyInp.val()) || 0;
   var stokMax  = parseFloat($qtyInp.data('stok-max'));
   if (isNaN(stokMax)) {
      stokMax = parseFloat($row.find('.stok-display').text()) || 0;
   }
   
   $row.find('.stok-warn-msg').remove();

   if (stokMax > 0 && qty > stokMax) {
      $qtyInp.val(stokMax);
      $qtyInp.css({'border': '2px solid #ef4444', 'background-color': '#fef2f2'});
      $qtyInp.after('<small class="text-danger stok-warn-msg" style="display:block; font-weight:600; font-size:11px; margin-top:3px;"><i class="fa fa-exclamation-triangle"></i> Max Stok: <b>' + stokMax + '</b></small>');
      if (typeof swal !== 'undefined') {
         swal("Stok Tidak Cukup!", "Jumlah pesanan melebihi stok yang tersedia di gudang ini (" + stokMax + " unit). Qty otomatis disesuaikan ke " + stokMax + ".", "warning");
      }
      recalc_row($row);
   } else if (qty <= 0) {
      $qtyInp.css({'border': '1px solid #cbd5e1', 'background-color': '#ffffff'});
   } else {
      $qtyInp.css({'border': '1px solid #cbd5e1', 'background-color': '#ffffff'});
   }
}

function cek_stok(produk_id, gudang_id, $span){
   if(!produk_id || !gudang_id){
      $span.text('-').removeClass('bg-red bg-green').addClass('bg-gray');
      return;
   }
   $.get('<?= site_url("administrator/produk/cek_stok"); ?>', {produk_id: produk_id, gudang_id: gudang_id}, function(r){
      var stok_num = parseFloat(r.stok) || 0;
      var $row = $span.closest('.item-row');
      $row.find('.qty-input').data('stok-max', stok_num).attr('max', stok_num);

      if (stok_num > 0) {
         $span.text(stok_num).removeClass('bg-red bg-gray').addClass('bg-green');
      } else {
         $span.text('0').removeClass('bg-green bg-gray').addClass('bg-red');
      }
      validate_row_qty($row);
   }, 'json');
}

function get_harga_by_tipe(produk_id, tipe_pelanggan) {
   var list = (available_produks && available_produks.length > 0) ? available_produks : produks_initial;
   var p = list.find(function(x) { return parseInt(x.id) === parseInt(produk_id); });
   if (!p) return 0;
   if (!tipe_pelanggan) return parseFloat(p.harga_jual || 0);
   tipe_pelanggan = $.trim(tipe_pelanggan).toLowerCase();
   if (tipe_pelanggan === 'grosir' && parseFloat(p.harga_jual_grosir) > 0) return parseFloat(p.harga_jual_grosir);
   if (tipe_pelanggan === 'distributor' && parseFloat(p.harga_jual_distributor) > 0) return parseFloat(p.harga_jual_distributor);
   if (tipe_pelanggan === 'vip' && parseFloat(p.harga_jual_vip) > 0) return parseFloat(p.harga_jual_vip);
   return parseFloat(p.harga_jual || 0);
}

function get_satuan_by_produk(produk_id) {
   var list = (available_produks && available_produks.length > 0) ? available_produks : produks_initial;
   var p = list.find(function(x) { return parseInt(x.id) === parseInt(produk_id); });
   if (!p) return 'Pcs';
   return p.nama_satuan || p.satuan || 'Pcs';
}

$(document).ready(function(){
   if (typeof $.fn.select2 === 'function') {
      $('#pelanggan_id').select2({
         placeholder: '-- Ketik / Cari Nama atau Telp Pelanggan --',
         allowClear: true,
         width: '100%'
      });
      if ($('#gudang_id').is('select')) {
         $('#gudang_id').select2({
            width: '100%'
         });
      }
      init_produk_select2();
   }

   var initial_gudang = $('#gudang_id').val();
   if (initial_gudang) {
      load_produk_by_gudang(initial_gudang);
   } else {
      available_produks = produks_initial.slice();
      update_all_product_dropdowns();
   }
   
   var init_disc = parseFloat($('#diskon_persen_total').val()) || 0;
   if (init_disc > 0) {
      $('.disc-input').each(function(){
         if (parseFloat($(this).val()) === 0) {
            $(this).val(init_disc);
         }
      });
   }

   $('.item-row').each(function(){
      recalc_row($(this));
   });
   recalc_total();

   $('#diskon_persen_total').on('input', function(){
      var val = $(this).val();
      $('.disc-input').val(val);
      $('.item-row').each(function(){
         recalc_row($(this));
      });
      recalc_total();
   });



   $('#btn_add_item').click(function(){
      var idx = item_count++;
      $('#item_rows').append('<tr id="item_row_'+idx+'" class="item-row"><td><select class="form-control produk-select" style="width:100%;" name="items['+idx+'][produk_id]">'+build_options()+'</select></td><td><input type="number" step="1" min="1" class="form-control qty-input" name="items['+idx+'][qty]" value="1"></td><td><input type="text" class="form-control" name="items['+idx+'][satuan]" style="width:60px"></td><td><input type="number" class="form-control harga-input rupiah" name="items['+idx+'][harga_satuan]" value="0"></td><td><input type="number" step="1" min="1" class="form-control disc-input rupiah" name="items['+idx+'][diskon_persen]" value="0"></td><td><input type="text" class="form-control subtotal-display" value="0" readonly></td><td><span class="stok-display badge bg-gray">-</span></td><td><button type="button" class="btn btn-xs btn-danger remove-row"><i class="fa fa-times"></i></button></td></tr>');
      var $new_row = $('#item_rows tr:last');
      init_produk_select2($new_row);
      cek_stok($new_row.find('.produk-select').val(), $('#gudang_id').val(), $new_row.find('.stok-display'));
   });

   $(document).on('change','.produk-select',function(){
      var $row = $(this).closest('.item-row');
      var pid = $(this).val();
      var tipe = $('#pelanggan_id option:selected').data('tipe') || '';
      var harga = get_harga_by_tipe(pid, tipe);
      var satuan = get_satuan_by_produk(pid);
      $row.find('.harga-input').val(harga);
      $row.find('input[name*="[satuan]"]').val(satuan);
      recalc_row($row);
      cek_stok(pid, $('#gudang_id').val(), $row.find('.stok-display'));
   });

   $(document).on('input keyup change','.qty-input', function(){
      var $row = $(this).closest('.item-row');
      recalc_row($row);
      validate_row_qty($row);
   });
   $(document).on('input','.harga-input,.disc-input',function(){recalc_row($(this).closest('.item-row'));});
   $(document).on('click','.remove-row',function(){if($('.item-row').length>1){$(this).closest('.item-row').remove();recalc_total();}});
   $('#diskon_persen_total,#diskon_total,#pajak_persen').on('input change',function(){recalc_total();});
   
   $('#gudang_id').on('change',function(){
      var gid = $(this).val();
      load_produk_by_gudang(gid);
   });

   function render_customer_card() {
      var $opt = $('#pelanggan_id option:selected');
      var val = $('#pelanggan_id').val();
      if (!val) {
         $('#customer_info_card').slideUp(150);
         return;
      }
      var kode = $opt.data('kode') || '-';
      var nama = $opt.data('nama') || $opt.text();
      var tipe = ($opt.data('tipe') || 'RETAIL').toUpperCase();
      var telp = $opt.data('telp') || '-';
      var alamat = $opt.data('alamat') || 'Alamat pengiriman belum diatur';

      $('#card_cust_nama').text(nama);
      $('#card_cust_kode').text(kode);
      $('#card_cust_tipe').text(tipe);
      $('#card_cust_telp').text(telp);
      $('#card_cust_alamat').text(alamat);
      $('#customer_info_card').slideDown(150);
   }

   $('#pelanggan_id').on('change',function(){
      render_customer_card();
      var tipe = $(this).find(':selected').data('tipe') || '';
      $('.item-row').each(function(){
         var pid = $(this).find('.produk-select').val();
         if(pid){
            var h = get_harga_by_tipe(pid, tipe);
            $(this).find('.harga-input').val(h);
            recalc_row($(this));
         }
      });
   });
   render_customer_card();



   function submit_so_form(actionType, $btn, extraData) {
      if (!$('#pelanggan_id').val()) {
         show_alert('Pilih Pelanggan terlebih dahulu!', 'warning');
         return;
      }
      if (!$('#gudang_id').val()) {
         show_alert('Pilih Gudang Sumber terlebih dahulu!', 'warning');
         return;
      }

      var is_valid = true;
      var err_msg = '';

      $('.item-row').each(function() {
         var $sel = $(this).find('.produk-select');
         var pid = $sel.val();
         var qty = parseFloat($(this).find('.qty-input').val()) || 0;
         var stok = parseFloat($(this).find('.stok-display').text()) || 0;
         var prod_nama = $sel.find('option:selected').text();

         if (!pid) {
            is_valid = false;
            err_msg = 'Silakan pilih produk untuk semua baris item!';
            return false;
         }

         if (qty <= 0) {
            is_valid = false;
            err_msg = 'Qty penjualan harus lebih dari 0!';
            return false;
         }

         if (stok > 0 && qty > stok) {
            is_valid = false;
            err_msg = 'Qty pesanan untuk (' + prod_nama + ') sejumlah ' + qty + ' melebihi Stok Gudang yang tersedia (' + stok + ')!';
            return false;
         }
      });

      if (!is_valid) {
         show_alert(err_msg, 'warning');
         return;
      }

      var origHtml = $btn.html();
      $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');
      var formData = $('#form_so').serialize() + '&save_action=' + actionType;
      if (extraData) {
         formData += '&' + $.param(extraData);
      }

      $.ajax({
         url: '<?= $action_url; ?>',
         method: 'POST',
         data: formData,
         dataType: 'json',
         success: function(res){
            if(res.success){
               if(res.redirect){
                  window.location.href = res.redirect;
               } else {
                  window.location.href = '<?= site_url("administrator/sales_order"); ?>';
               }
            } else {
               show_alert(res.message || 'Gagal menyimpan data.', 'error');
               $btn.prop('disabled', false).html(origHtml);
            }
         },
         error: function(xhr){
            var msg = 'Terjadi kesalahan server saat menyimpan data.';
            try {
               var r = JSON.parse(xhr.responseText);
               if (r && r.message) msg = r.message;
            } catch(e){}
            show_alert(msg, 'error');
            $btn.prop('disabled', false).html(origHtml);
         }
      });
   }

   $('#btn_save').click(function(){
      submit_so_form('draft', $(this));
   });

   $('#btn_save_confirm').click(function(){
      submit_so_form('confirm', $(this));
   });

   $('#btn_refresh_pelanggan').click(function(){
      var $btn = $(this);
      $btn.html('<i class="fa fa-spinner fa-spin"></i> Memuat...');
      $.getJSON('<?= site_url("administrator/pelanggan/get_list_json"); ?>', function(res){
         if (res && res.status && res.data) {
            var currVal = $('#pelanggan_id').val();
            var html = '<option value="">-- Pilih Pelanggan --</option>';
            $.each(res.data, function(i, p){
               var t_badge = (p.tipe_pelanggan || 'RETAIL').toUpperCase();
               var telp = p.no_telp || p.telepon || '';
               var telp_fmt = telp ? ' (' + telp + ')' : '';
               var sel = (currVal == p.id) ? ' selected' : '';
               html += '<option value="' + p.id + '" data-kode="' + (p.kode_pelanggan||'') + '" data-nama="' + (p.nama_pelanggan||'') + '" data-tipe="' + (p.tipe_pelanggan||'') + '" data-telp="' + telp + '"' + sel + '>' + (p.kode_pelanggan||'') + ' - ' + (p.nama_pelanggan||'') + ' [' + t_badge + ']' + telp_fmt + '</option>';
            });
            $('#pelanggan_id').html(html);
            if (typeof $.fn.select2 === 'function') {
               $('#pelanggan_id').select2({
                  placeholder: '-- Ketik / Cari Nama atau Telp Pelanggan --',
                  allowClear: true,
                  width: '100%'
               });
            }
            $('#pelanggan_id').trigger('change');
            show_alert('Daftar pelanggan berhasil diperbarui!', 'success');
         }
         $btn.html('<i class="fa fa-refresh"></i> Segarkan');
      }).fail(function(){
         $btn.html('<i class="fa fa-refresh"></i> Segarkan');
      });
   });
});
</script>
