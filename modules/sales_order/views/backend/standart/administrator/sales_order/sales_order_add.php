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

/* Payment Status & Terms Cards */
.payment-option-card {
  display: block;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  padding: 14px 16px;
  cursor: pointer;
  background: #ffffff;
  transition: all 0.2s ease;
  margin-bottom: 10px;
  position: relative;
  text-decoration: none !important;
}
.payment-option-card:hover {
  border-color: #cbd5e1;
  background: #f8fafc;
  transform: translateY(-1px);
}
.payment-option-card.active {
  border-color: #f59e0b !important;
  background: #fffdf5 !important;
  box-shadow: 0 4px 14px rgba(245, 158, 11, 0.15) !important;
}
.payment-option-card.active#card_opt_lunas {
  border-color: #10b981 !important;
  background: #f0fdf4 !important;
  box-shadow: 0 4px 14px rgba(16, 185, 129, 0.15) !important;
}
.payment-option-card.active#card_opt_draft {
  border-color: #64748b !important;
  background: #f8fafc !important;
  box-shadow: 0 4px 14px rgba(100, 116, 139, 0.15) !important;
}
.option-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 6px;
}
.option-icon {
  width: 38px;
  height: 38px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 17px;
  flex-shrink: 0;
}
.option-icon.bg-amber { background: #fef3c7; color: #d97706; }
.option-icon.bg-emerald { background: #d1fae5; color: #059669; }
.option-icon.bg-slate { background: #e2e8f0; color: #475569; }
.option-title {
  font-size: 13.5px;
  font-weight: 700;
  color: #1e293b;
  display: block;
  line-height: 1.25;
}
.option-sub {
  font-size: 11px;
  font-weight: 600;
  color: #64748b;
  margin-top: 2px;
}
.option-desc {
  font-size: 11.5px;
  color: #64748b;
  margin: 0;
  line-height: 1.4;
  font-weight: normal;
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
                              <a href="javascript:void(0);" id="btn_open_modal_cust" class="text-primary" style="font-size:11px; font-weight:600; cursor:pointer;" title="Tambah Pelanggan Baru tanpa berpindah halaman">
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

         <!-- Section Status Pembayaran & Ketentuan Tagihan (Piutang Usaha) -->
         <div style="padding: 18px 20px 8px 20px; background: #fafcff; border-top: 1px solid #e2e8f0;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:6px;">
               <h4 style="margin:0; font-size:14px; font-weight:700; color:#1e293b;">
                  <i class="fa fa-credit-card text-warning"></i> Status Pembayaran &amp; Ketentuan Tagihan (Piutang Usaha)
               </h4>
               <span class="text-muted" style="font-size:12px;">Pilih metode penyelesaian: Tempo (masuk piutang), Lunas langsung, atau Draft</span>
            </div>

            <div class="row">
               <div class="col-md-4 col-sm-12">
                  <!-- Option 1: Belum Bayar / Tempo (Default) -->
                  <label class="payment-option-card active" id="card_opt_tempo">
                     <input type="radio" name="status_pembayaran" value="tempo" checked style="position:absolute; opacity:0;">
                     <div class="option-header">
                        <span class="option-icon bg-amber"><i class="fa fa-clock-o"></i></span>
                        <div>
                           <strong class="option-title">Belum Bayar (Tempo / Kredit)</strong>
                           <div class="option-sub"><i class="fa fa-arrow-circle-right text-warning"></i> Otomatis Masuk Piutang Usaha (AR)</div>
                        </div>
                     </div>
                     <p class="option-desc">Menerbitkan Faktur resmi &amp; mencatat tagihan ke modul <b>Piutang Usaha</b> dengan status <i>Belum Bayar</i>.</p>
                  </label>
               </div>

               <div class="col-md-4 col-sm-12">
                  <!-- Option 2: Sudah Bayar Lunas -->
                  <label class="payment-option-card" id="card_opt_lunas">
                     <input type="radio" name="status_pembayaran" value="lunas" style="position:absolute; opacity:0;">
                     <div class="option-header">
                        <span class="option-icon bg-emerald"><i class="fa fa-check-circle"></i></span>
                        <div>
                           <strong class="option-title">Sudah Bayar / Lunas</strong>
                           <div class="option-sub"><i class="fa fa-arrow-circle-right text-success"></i> Masuk Kas/Bank &amp; Faktur Lunas</div>
                        </div>
                     </div>
                     <p class="option-desc">Mencatat pelunasan langsung ke Kas/Bank, menerbitkan Faktur Lunas, dan Bukti Kas Masuk (BKM).</p>
                  </label>
               </div>

               <div class="col-md-4 col-sm-12">
                  <!-- Option 3: Draft Pemesanan -->
                  <label class="payment-option-card" id="card_opt_draft">
                     <input type="radio" name="status_pembayaran" value="draft" style="position:absolute; opacity:0;">
                     <div class="option-header">
                        <span class="option-icon bg-slate"><i class="fa fa-file-text-o"></i></span>
                        <div>
                           <strong class="option-title">Draft Pemesanan Saja</strong>
                           <div class="option-sub"><i class="fa fa-arrow-circle-right text-muted"></i> Belum Diterbitkan Tagihan</div>
                        </div>
                      </div>
                     <p class="option-desc">Menyimpan sebagai draf penawaran/pemesanan awal tanpa memotong stok dan belum masuk ke piutang.</p>
                  </label>
               </div>
            </div>

            <!-- Sub-Panel: Detail Tempo / Piutang -->
            <div id="panel_tempo_details" class="panel-payment-sub" style="margin-top:4px; margin-bottom:12px; padding:14px 16px; background:#fffbeb; border:1px solid #fde68a; border-radius:8px;">
               <div class="row">
                  <div class="col-md-4 col-sm-6">
                     <div class="form-group" style="margin-bottom:0;">
                        <label style="font-weight:700; color:#92400e; font-size:12px;"><i class="fa fa-calendar"></i> Syarat Pembayaran (Termin)</label>
                        <select class="form-control" name="syarat_pembayaran" id="syarat_pembayaran" style="border-radius:6px; font-weight:600; height:38px; border-color:#fcd34d;">
                           <option value="net_30" selected>Net 30 (Jatuh Tempo 30 Hari)</option>
                           <option value="net_14">Net 14 (Jatuh Tempo 14 Hari)</option>
                           <option value="net_7">Net 7 (Jatuh Tempo 7 Hari)</option>
                           <option value="net_60">Net 60 (Jatuh Tempo 60 Hari)</option>
                           <option value="cod">COD (Bayar Saat Pengiriman / Serah Terima)</option>
                           <option value="custom">Custom (Pilih Tanggal Bebas)</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4 col-sm-6">
                     <div class="form-group" style="margin-bottom:0;">
                        <label style="font-weight:700; color:#92400e; font-size:12px;"><i class="fa fa-clock-o"></i> Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" value="<?= date('Y-m-d', strtotime('+30 days')); ?>" style="border-radius:6px; font-weight:700; height:38px; border-color:#fcd34d;">
                        <div style="margin-top:5px; display:flex; gap:4px; flex-wrap:wrap;">
                           <button type="button" class="btn btn-xs btn-default btn-quick-due" data-days="7" style="font-size:10px; border-radius:4px; padding:2px 7px;">+7 Hari</button>
                           <button type="button" class="btn btn-xs btn-default btn-quick-due" data-days="14" style="font-size:10px; border-radius:4px; padding:2px 7px;">+14 Hari</button>
                           <button type="button" class="btn btn-xs btn-default btn-quick-due active" data-days="30" style="font-size:10px; border-radius:4px; padding:2px 7px; background:#fef3c7; border-color:#d97706; font-weight:700;">+30 Hari</button>
                           <button type="button" class="btn btn-xs btn-default btn-quick-due" data-days="60" style="font-size:10px; border-radius:4px; padding:2px 7px;">+60 Hari</button>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4 col-sm-12">
                     <div class="form-group" style="margin-bottom:0;">
                        <label style="font-weight:700; color:#92400e; font-size:12px;"><i class="fa fa-info-circle"></i> Info Tagihan Piutang</label>
                        <div style="font-size:11.5px; color:#78350f; line-height:1.45; padding-top:2px;">
                           Setelah disimpan, tagihan senilai <b id="preview_total_piutang" class="text-danger">Rp 0</b> akan otomatis tercatat pada daftar <b>Piutang Usaha</b> pelanggan dan siap dicicil/dilunasi kapan saja.
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <!-- Sub-Panel: Detail Lunas Langsung -->
            <div id="panel_lunas_details" class="panel-payment-sub" style="display:none; margin-top:4px; margin-bottom:12px; padding:14px 16px; background:#ecfdf5; border:1px solid #a7f3d0; border-radius:8px;">
               <div class="row">
                  <div class="col-md-4 col-sm-6">
                     <div class="form-group" style="margin-bottom:0;">
                        <label style="font-weight:700; color:#065f46; font-size:12px;"><i class="fa fa-money"></i> Metode Pembayaran</label>
                        <select class="form-control" name="metode_pembayaran" id="metode_pembayaran" style="border-radius:6px; font-weight:600; height:38px; border-color:#6ee7b7;">
                           <option value="tunai" selected>Tunai / Cash</option>
                           <option value="bank_transfer">Transfer Bank</option>
                           <option value="qris">QRIS / E-Wallet</option>
                           <option value="debit">Kartu Debit</option>
                           <option value="giro">Giro / Cek</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4 col-sm-6">
                     <div class="form-group" style="margin-bottom:0;">
                        <label style="font-weight:700; color:#065f46; font-size:12px;"><i class="fa fa-university"></i> Setor ke Akun Kas/Bank</label>
                        <select class="form-control" name="akun_kas_bank" id="akun_kas_bank" style="border-radius:6px; font-weight:600; height:38px; border-color:#6ee7b7;">
                           <option value="Kas Tunai Kasir" selected>Kas Tunai Kasir</option>
                           <option value="Bank BCA (Rek: 8830-123-456)">Bank BCA (Rek: 8830-123-456)</option>
                           <option value="Bank Mandiri (Rek: 137-00-98765)">Bank Mandiri (Rek: 137-00-98765)</option>
                           <option value="Bank BNI">Bank BNI</option>
                           <option value="Bank BRI">Bank BRI</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4 col-sm-12">
                     <div class="form-group" style="margin-bottom:0;">
                        <label style="font-weight:700; color:#065f46; font-size:12px;"><i class="fa fa-hashtag"></i> No. Referensi / Bukti Transfer (Opsional)</label>
                        <input type="text" class="form-control" name="nomor_referensi" id="nomor_referensi" placeholder="Contoh: REF-TRX-12345" style="border-radius:6px; height:38px; border-color:#6ee7b7;">
                     </div>
                  </div>
               </div>
            </div>

            <!-- Sub-Panel: Detail Draft -->
            <div id="panel_draft_details" class="panel-payment-sub" style="display:none; margin-top:4px; margin-bottom:12px; padding:12px 16px; background:#f1f5f9; border:1px solid #cbd5e1; border-radius:8px;">
               <div style="font-size:12px; color:#475569; display:flex; align-items:center; gap:8px;">
                  <i class="fa fa-info-circle text-primary" style="font-size:16px;"></i>
                  <span>Mode <b>Draft</b> akan menyimpan dokumen pemesanan tanpa memotong stok dan tanpa mencatat tagihan ke piutang. Tagihan dapat diterbitkan di kemudian hari melalui tombol Konfirmasi &amp; Terbitkan Invoice.</span>
               </div>
            </div>
         </div>

         <!-- Card Footer: Action Buttons at the Bottom! -->
         <div class="box-footer" style="padding:15px 20px; background:#f8fafc; border-top:1px solid #e2e8f0; border-radius: 0 0 8px 8px;">
            <div class="pull-left">
               <a href="<?= base_url('administrator/sales_order'); ?>" class="btn btn-default btn-flat" style="border-radius:6px; font-weight:600; padding:8px 18px;">
                  <i class="fa fa-arrow-left"></i> Kembali ke Daftar SO
               </a>
            </div>
            <div class="pull-right" style="display:flex; gap:10px; align-items:center;">
               <button type="button" id="btn_save" class="btn btn-default btn-flat" style="border-radius:6px; font-weight:600; padding:8px 18px; font-size:13.5px; border:1px solid #cbd5e1;">
                  <i class="fa fa-save text-muted"></i> <?= $is_edit ? 'Simpan (Draft)' : 'Simpan Draft Saja'; ?>
               </button>
               <button type="button" id="btn_save_confirm" class="btn btn-warning btn-flat" style="border-radius:6px; font-weight:700; padding:8px 22px; font-size:14px; background:#f59e0b; border-color:#d97706; color:#ffffff; box-shadow:0 3px 10px rgba(245,158,11,0.25);">
                  <i class="fa fa-clock-o"></i> <?= $is_edit ? 'Simpan &amp; Terbitkan Piutang (Tempo)' : '⚡ Simpan &amp; Terbitkan Piutang (Tempo)'; ?>
               </button>
            </div>
         </div>
      </div>
   </div>
</div>

</form>

<!-- Modal Tambah Pelanggan Baru (Tanpa Pindah Halaman) -->
<div class="modal fade" id="modal_add_pelanggan" tabindex="-1" role="dialog" aria-labelledby="modalAddPelangganLabel">
   <div class="modal-dialog" role="document" style="max-width: 520px;">
      <div class="modal-content" style="border-radius: 10px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
         <div class="modal-header" style="background: linear-gradient(135deg, #0284c7, #0369a1); color: #fff; padding: 14px 20px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.85; font-size: 24px;">&times;</button>
            <h4 class="modal-title" id="modalAddPelangganLabel" style="font-weight: 700; font-size: 15px;">
               <i class="fa fa-user-plus"></i> Tambah Pelanggan Baru
            </h4>
            <small style="color: #e0f2fe; font-size: 11.5px;">Data pelanggan akan otomatis tersimpan dan langsung dipilih di formulir ini tanpa kehilangan data barang.</small>
         </div>
         <form id="form_modal_pelanggan" onsubmit="return false;">
         <div class="modal-body" style="padding: 18px 20px;">
            <div class="form-group" style="margin-bottom: 12px;">
               <label style="font-size: 12px; font-weight: 700; color: #334155;">Nama Pelanggan / Usaha <span class="text-danger">*</span></label>
               <input type="text" class="form-control" name="nama_pelanggan" id="modal_cust_nama" placeholder="Contoh: Budi Santoso / Toko Berkah" required style="border-radius: 6px; font-weight: 600; height: 38px;">
            </div>

            <div class="row">
               <div class="col-xs-12 col-sm-6">
                  <div class="form-group" style="margin-bottom: 12px;">
                     <label style="font-size: 12px; font-weight: 700; color: #334155;"><i class="fa fa-phone text-success"></i> No. Telp / WhatsApp <span class="text-danger">*</span></label>
                     <input type="text" class="form-control" name="telepon" id="modal_cust_telp" placeholder="08xxxxxxxxxx" required style="border-radius: 6px; font-weight: 600; height: 38px;">
                     <small class="text-muted" style="font-size: 10.5px;">Untuk kontak &amp; riwayat CRM.</small>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6">
                  <div class="form-group" style="margin-bottom: 12px;">
                     <label style="font-size: 12px; font-weight: 700; color: #334155;">Tipe Pelanggan</label>
                     <select class="form-control" name="tipe_pelanggan" id="modal_cust_tipe" style="border-radius: 6px; font-weight: 600; height: 38px;">
                        <option value="retail" selected>Retail / Eceran (Umum)</option>
                        <option value="grosir">Grosir</option>
                        <option value="distributor">Distributor</option>
                        <option value="vip">VIP / Member</option>
                     </select>
                  </div>
               </div>
            </div>

            <div class="form-group" style="margin-bottom: 12px;">
               <label style="font-size: 12px; font-weight: 700; color: #334155;"><i class="fa fa-map-marker text-danger"></i> Alamat Lengkap (Opsional)</label>
               <textarea class="form-control" name="alamat" id="modal_cust_alamat" rows="2" placeholder="Jl. Raya No..., RT/RW, Kelurahan..." style="border-radius: 6px; font-size: 12px; resize: vertical;"></textarea>
            </div>

            <div class="row">
               <div class="col-xs-12 col-sm-6">
                  <div class="form-group" style="margin-bottom: 0;">
                     <label style="font-size: 12px; font-weight: 700; color: #334155;">Kota / Wilayah</label>
                     <input type="text" class="form-control" name="kota" id="modal_cust_kota" placeholder="Nama Kota/Kabupaten" style="border-radius: 6px; height: 36px;">
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6">
                  <div class="form-group" style="margin-bottom: 0;">
                     <label style="font-size: 12px; font-weight: 700; color: #334155;">Email (Opsional)</label>
                     <input type="email" class="form-control" name="email" id="modal_cust_email" placeholder="email@contoh.com" style="border-radius: 6px; height: 36px;">
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer" style="background: #f8fafc; padding: 12px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">Batal</button>
            <button type="button" id="btn_submit_modal_pelanggan" class="btn btn-primary" style="border-radius: 6px; font-weight: 700; background: #0284c7; border-color: #0284c7; padding: 7px 18px;">
               <i class="fa fa-save"></i> Simpan &amp; Pilih Pelanggan
            </button>
         </div>
         </form>
      </div>
   </div>
</div>

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
   $('#preview_total_piutang').text(format_rp(total));
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

   // Event Listener: Opsi Pembayaran (Tempo / Lunas / Draft)
   $('input[name="status_pembayaran"]').change(function(){
      var val = $(this).val();
      $('.payment-option-card').removeClass('active');
      $('#card_opt_' + val).addClass('active');

      $('.panel-payment-sub').hide();
      if (val === 'tempo') {
         $('#panel_tempo_details').slideDown(180);
         $('#btn_save_confirm')
            .removeClass('btn-success btn-default')
            .addClass('btn-warning')
            .css({'background': '#f59e0b', 'border-color': '#d97706', 'color': '#ffffff'})
            .html('<i class="fa fa-clock-o"></i> ⚡ Simpan &amp; Terbitkan Piutang (Tempo)');
      } else if (val === 'lunas') {
         $('#panel_lunas_details').slideDown(180);
         $('#btn_save_confirm')
            .removeClass('btn-warning btn-default')
            .addClass('btn-success')
            .css({'background': '#10b981', 'border-color': '#059669', 'color': '#ffffff'})
            .html('<i class="fa fa-check-circle"></i> ✓ Simpan &amp; Bayar Lunas Langsung');
      } else {
         $('#panel_draft_details').slideDown(180);
         $('#btn_save_confirm')
            .removeClass('btn-warning btn-success')
            .addClass('btn-default')
            .css({'background': '#64748b', 'border-color': '#475569', 'color': '#ffffff'})
            .html('<i class="fa fa-save"></i> Simpan Dokumen Draft');
      }
   });

   // Tombol Cepat Jatuh Tempo (+7, +14, +30, +60 hari)
   $('.btn-quick-due').click(function(e){
      e.preventDefault();
      $('.btn-quick-due').removeClass('active').css({'background': '#ffffff', 'border-color': '#cbd5e1', 'font-weight': 'normal'});
      $(this).addClass('active').css({'background': '#fef3c7', 'border-color': '#d97706', 'font-weight': 'bold'});
      var days = parseInt($(this).data('days'));
      var d = new Date();
      d.setDate(d.getDate() + days);
      var yyyy = d.getFullYear();
      var mm = String(d.getMonth() + 1).padStart(2, '0');
      var dd = String(d.getDate()).padStart(2, '0');
      $('#tanggal_jatuh_tempo').val(yyyy + '-' + mm + '-' + dd);

      if (days === 7) $('#syarat_pembayaran').val('net_7');
      else if (days === 14) $('#syarat_pembayaran').val('net_14');
      else if (days === 30) $('#syarat_pembayaran').val('net_30');
      else if (days === 60) $('#syarat_pembayaran').val('net_60');
   });

   $('#syarat_pembayaran').change(function(){
      var v = $(this).val();
      var d = new Date();
      var days = 30;
      if (v === 'net_7') days = 7;
      else if (v === 'net_14') days = 14;
      else if (v === 'net_30') days = 30;
      else if (v === 'net_60') days = 60;
      else if (v === 'cod') days = 0;

      if (v !== 'custom') {
         d.setDate(d.getDate() + days);
         var yyyy = d.getFullYear();
         var mm = String(d.getMonth() + 1).padStart(2, '0');
         var dd = String(d.getDate()).padStart(2, '0');
         $('#tanggal_jatuh_tempo').val(yyyy + '-' + mm + '-' + dd);
         $('.btn-quick-due').removeClass('active').css({'background': '#ffffff', 'border-color': '#cbd5e1', 'font-weight': 'normal'});
         $('.btn-quick-due[data-days="' + days + '"]').addClass('active').css({'background': '#fef3c7', 'border-color': '#d97706', 'font-weight': 'bold'});
      }
   });

   // Submit Handlers
   $('#btn_save').click(function(){
      submit_so_form('draft', $(this));
   });

   $('#btn_save_confirm').click(function(){
      var mode = $('input[name="status_pembayaran"]:checked').val() || 'tempo';
      submit_so_form(mode, $(this));
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
         $btn.html('<i class="fa fa-refresh"></i> Segarkan List');
      }).fail(function(){
         $btn.html('<i class="fa fa-refresh"></i> Segarkan List');
      });
   });

   // Buka Modal Tambah Pelanggan Baru (Tanpa Pindah Halaman)
   $('#btn_open_modal_cust').click(function(e){
      e.preventDefault();
      $('#modal_cust_nama').val('');
      $('#modal_cust_telp').val('');
      $('#modal_cust_tipe').val('retail');
      $('#modal_cust_alamat').val('');
      $('#modal_cust_kota').val('');
      $('#modal_cust_email').val('');
      $('#modal_add_pelanggan').modal('show');
      setTimeout(function(){
         $('#modal_cust_nama').focus();
      }, 350);
   });

   // Submit Modal Tambah Pelanggan Baru via AJAX
   $('#btn_submit_modal_pelanggan').click(function(){
      var nama   = $.trim($('#modal_cust_nama').val());
      var telp   = $.trim($('#modal_cust_telp').val());
      var tipe   = $('#modal_cust_tipe').val() || 'retail';
      var alamat = $.trim($('#modal_cust_alamat').val());
      var kota   = $.trim($('#modal_cust_kota').val());
      var email  = $.trim($('#modal_cust_email').val());

      if (!nama) {
         show_alert('Nama Pelanggan wajib diisi!', 'warning');
         $('#modal_cust_nama').focus();
         return;
      }
      if (!telp) {
         show_alert('No. Telepon / WhatsApp wajib diisi agar terekap di CRM!', 'warning');
         $('#modal_cust_telp').focus();
         return;
      }

      var $btn = $(this);
      var origHtml = $btn.html();
      $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

      $.ajax({
         url: '<?= site_url("administrator/sales_order/ajax_add_pelanggan"); ?>',
         method: 'POST',
         data: {
            nama_pelanggan: nama,
            telepon: telp,
            tipe_pelanggan: tipe,
            alamat: alamat,
            kota: kota,
            email: email
         },
         dataType: 'json',
         success: function(res){
            $btn.prop('disabled', false).html(origHtml);
            if (res && res.success && res.data) {
               var p = res.data;
               var t_badge = (p.tipe || 'RETAIL').toUpperCase();
               var telpFmt = p.telp ? ' (' + p.telp + ')' : '';
               var optionText = (p.kode ? p.kode + ' - ' : '') + p.nama + ' [' + t_badge + ']' + telpFmt;
               
               // Buat option baru di select2 dan pilih langsung
               var newOption = new Option(optionText, p.id, true, true);
               $(newOption).attr('data-kode', p.kode || '');
               $(newOption).attr('data-nama', p.nama || '');
               $(newOption).attr('data-tipe', p.tipe || 'retail');
               $(newOption).attr('data-telp', p.telp || '');
               $(newOption).attr('data-alamat', p.alamat || '');
               $(newOption).attr('data-kota', p.kota || '');

               $('#pelanggan_id').append(newOption).trigger('change');
               $('#modal_add_pelanggan').modal('hide');
               show_alert('Pelanggan (' + p.nama + ') berhasil ditambahkan dan langsung dipilih!', 'success');
            } else {
               show_alert((res && res.message) ? res.message : 'Gagal menyimpan data pelanggan.', 'error');
            }
         },
         error: function(xhr){
            $btn.prop('disabled', false).html(origHtml);
            var msg = 'Terjadi kesalahan server saat menyimpan pelanggan.';
            try {
               var r = JSON.parse(xhr.responseText);
               if (r && r.message) msg = r.message;
            } catch(e){}
            show_alert(msg, 'error');
         }
      });
   });
});
</script>
