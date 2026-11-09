<?php /* penjualan_marketplace_update.php */ ?>
<style>
@media (max-width: 767px) {
   .content-header h1 {
      font-size: 19px !important;
      line-height: 1.3 !important;
   }
   .content-header h1 small {
      display: block !important;
      margin-top: 4px !important;
   }
   .content-header .breadcrumb {
      position: static !important;
      float: none !important;
      padding: 0 !important;
      margin-top: 8px !important;
      background: transparent !important;
   }
   .box-header.with-border {
      display: flex !important;
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 12px !important;
      padding: 14px 16px !important;
   }
   .box-header .box-title {
      font-size: 16px !important;
      line-height: 1.3 !important;
      word-break: break-all !important;
   }
   .box-header .box-tools {
      position: static !important;
      float: none !important;
      width: 100% !important;
   }
   .box-header .box-tools .btn {
      width: 100% !important;
      text-align: center !important;
      padding: 8px 14px !important;
   }
   .box-body {
      padding: 16px 14px !important;
   }
   .form-horizontal .form-group {
      margin-left: 0 !important;
      margin-right: 0 !important;
      margin-bottom: 14px !important;
   }
   .form-horizontal .control-label {
      text-align: left !important;
      padding-top: 0 !important;
      margin-bottom: 5px !important;
      width: 100% !important;
      float: none !important;
      font-size: 13px !important;
   }
   .form-horizontal .col-sm-8,
   .form-horizontal .col-sm-10 {
      width: 100% !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      float: none !important;
   }
   .form-horizontal .form-control {
      font-size: 13.5px !important;
   }
   h4 {
      font-size: 14.5px !important;
      flex-direction: column !important;
      align-items: flex-start !important;
      gap: 6px !important;
   }
   .table-responsive {
      border: 1px solid #e2e8f0 !important;
      border-radius: 8px !important;
      -webkit-overflow-scrolling: touch !important;
      margin-bottom: 15px !important;
   }
   #table_items {
      min-width: 620px !important;
      margin-bottom: 0 !important;
   }
   .box-footer {
      padding: 14px 16px !important;
   }
   .box-footer .pull-right {
      float: none !important;
      display: flex !important;
      flex-direction: column-reverse !important;
      gap: 8px !important;
      width: 100% !important;
   }
   .box-footer .pull-right .btn {
      width: 100% !important;
      margin-right: 0 !important;
      padding: 11px 16px !important;
      font-size: 14px !important;
      text-align: center !important;
   }
}
</style>
<section class="content-header">
   <h1>
      Edit Penjualan Marketplace
      <small>Perbarui Detail Pesanan Multi-Channel</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/penjualan_marketplace'); ?>"><i class="fa fa-shopping-bag"></i> Penjualan Marketplace</a></li>
      <li class="active">Edit Pesanan</li>
   </ol>
</section>

<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary" style="border-radius:8px; border-top: 4px solid #0284c7; box-shadow:0 2px 10px rgba(0,0,0,0.06);">
            <div class="box-header with-border" style="padding: 16px 20px; background:#fff;">
               <h3 class="box-title" style="font-weight:700; color:#1e293b;"><i class="fa fa-pencil-square-o" style="color:#0284c7;"></i> Edit Pesanan #<?= _ent($so->no_pesanan ?: $so->nomor_so); ?></h3>
               <div class="box-tools pull-right">
                  <a href="<?= site_url('administrator/penjualan_marketplace'); ?>" class="btn btn-default btn-sm btn-flat" style="border-radius:4px;"><i class="fa fa-arrow-left"></i> Batal / Kembali</a>
               </div>
            </div>

            <form action="<?= site_url('administrator/penjualan_marketplace/edit_save/' . $so->id); ?>" method="POST" id="form_penjualan_marketplace" class="form-horizontal">
               <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
               <div class="box-body" style="padding: 24px; background:#fafafa;">

                  <!-- Section 1: Data Transaksi Marketplace -->
                  <h4 style="font-weight:700; color:#0284c7; border-bottom:2px solid #0284c7; padding-bottom:8px; margin-bottom:20px;">
                     <i class="fa fa-shopping-bag"></i> 1. Informasi Pesanan &amp; Saluran Penjualan
                  </h4>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">Saluran Penjualan <span class="text-danger">*</span></label>
                           <div class="col-sm-8">
                              <select name="source" class="form-control" required style="border-radius:4px; font-weight:600;">
                                 <option value="shopee" <?= strtolower($so->source ?? '') == 'shopee' ? 'selected' : ''; ?>>Shopee</option>
                                 <option value="tokopedia" <?= strtolower($so->source ?? '') == 'tokopedia' ? 'selected' : ''; ?>>Tokopedia</option>
                                 <option value="tiktok" <?= in_array(strtolower($so->source ?? ''), ['tiktok', 'tiktokshop', 'tiktok_shop']) ? 'selected' : ''; ?>>TikTok Shop</option>
                                 <option value="lazada" <?= strtolower($so->source ?? '') == 'lazada' ? 'selected' : ''; ?>>Lazada</option>
                                 <option value="manual" <?= strtolower($so->source ?? '') == 'manual' ? 'selected' : ''; ?>>Transaksi Penjualan Regular / Manual</option>
                              </select>
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">No. Pesanan Marketplace <span class="text-danger">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" name="no_pesanan" class="form-control" value="<?= _ent($so->no_pesanan ?: $so->nomor_so); ?>" required style="border-radius:4px; font-family:monospace; font-weight:700;">
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">Status Pesanan <span class="text-danger">*</span></label>
                           <div class="col-sm-8">
                              <?php $cur_st = strtolower($so->status ?? 'packing'); ?>
                              <select name="status" class="form-control" required style="border-radius:4px; font-weight:600;">
                                 <option value="draft" <?= $cur_st == 'draft' ? 'selected' : ''; ?>>Draft / Baru Masuk</option>
                                 <option value="confirmed" <?= $cur_st == 'confirmed' ? 'selected' : ''; ?>>Terkonfirmasi (Ready)</option>
                                 <option value="packing" <?= $cur_st == 'packing' ? 'selected' : ''; ?>>Sedang Dikemas (Packing)</option>
                                 <option value="shipped" <?= $cur_st == 'shipped' ? 'selected' : ''; ?>>Dalam Pengiriman (Shipped)</option>
                                 <option value="delivered" <?= $cur_st == 'delivered' ? 'selected' : ''; ?>>Pesanan Selesai (Delivered)</option>
                                 <option value="cancelled" <?= $cur_st == 'cancelled' ? 'selected' : ''; ?>>Dibatalkan (Cancelled)</option>
                              </select>
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">Tipe Pembayaran <span class="text-danger">*</span></label>
                           <div class="col-sm-8">
                              <?php $is_cod_val = (strtoupper($so->tipe_pengiriman ?? '') === 'COD' || (!empty($so->total) && (float)$so->total > 0 && stripos($so->catatan ?? '', 'COD') !== false)); ?>
                              <select name="tipe_pengiriman" id="tipe_pengiriman" class="form-control" required style="border-radius:4px; font-weight:700;">
                                 <option value="Non-COD" <?= !$is_cod_val ? 'selected' : ''; ?>>Non-COD (Cashless)</option>
                                 <option value="COD" <?= $is_cod_val ? 'selected' : ''; ?>>COD (Bayar di Tempat)</option>
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">Kurir / Ekspedisi</label>
                           <div class="col-sm-8">
                              <input type="text" name="opsi_pengiriman" class="form-control" value="<?= _ent($so->opsi_pengiriman ?: $so->kurir_ekspedisi); ?>" placeholder="Contoh: J&T Express, SiCepat, SPX, dll." style="border-radius:4px;">
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">No. Resi (AWB)</label>
                           <div class="col-sm-8">
                              <input type="text" name="nomor_resi" class="form-control" value="<?= _ent($so->nomor_resi); ?>" placeholder="Contoh: JX88192000000 / SPX..." style="border-radius:4px; font-family:monospace; color:#0284c7; font-weight:700;">
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">Waktu Pembayaran</label>
                           <div class="col-sm-8">
                              <?php 
                              $waktu_raw = !empty($so->waktu_pembayaran) ? $so->waktu_pembayaran : ($so->created_at ?? $so->tanggal_so);
                              $val_waktu = date('Y-m-d\TH:i', strtotime($waktu_raw));
                              ?>
                              <input type="datetime-local" name="waktu_pembayaran" class="form-control" value="<?= $val_waktu; ?>" style="border-radius:4px;">
                           </div>
                        </div>

                        <div class="form-group" id="group_nominal_cod" style="<?= $is_cod_val ? '' : 'display:none;'; ?>">
                           <label class="col-sm-4 control-label text-left">Nominal Tagihan COD</label>
                           <div class="col-sm-8">
                              <div class="input-group">
                                 <span class="input-group-addon" style="font-weight:700;">Rp</span>
                                 <input type="number" name="total_cod" id="total_cod" class="form-control" placeholder="0" value="<?= (float)($so->total ?? 0); ?>" min="0" style="border-radius:4px; font-weight:700; color:#059669;">
                              </div>
                              <small class="text-muted" style="font-size:11px;">Nominal uang yang harus ditagih kurir ke pembeli saat COD</small>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Section 2: Data Pembeli & Penerima -->
                  <h4 style="font-weight:700; color:#0284c7; border-bottom:2px solid #0284c7; padding-bottom:8px; margin-top:20px; margin-bottom:20px;">
                     <i class="fa fa-user"></i> 2. Informasi Pembeli &amp; Alamat Pengiriman
                  </h4>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">Username Pembeli <span class="text-danger">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" name="username_pembeli" class="form-control" value="<?= _ent($so->username_pembeli ?: $so->nama_penerima); ?>" required style="border-radius:4px;">
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">Nama Penerima <span class="text-danger">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" name="nama_penerima" class="form-control" value="<?= _ent($so->nama_penerima ?: $so->nama_pelanggan); ?>" required style="border-radius:4px;">
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">No. Telepon / WA <span class="text-danger">*</span></label>
                           <div class="col-sm-8">
                              <input type="text" name="no_telepon" class="form-control" value="<?= _ent($so->no_telepon); ?>" required style="border-radius:4px;">
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">Alamat Pengiriman</label>
                           <div class="col-sm-8">
                              <textarea name="alamat_pengiriman" class="form-control" rows="2" placeholder="Alamat lengkap tujuan..." style="border-radius:4px;"><?= _ent($so->alamat_pengiriman); ?></textarea>
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">Kota / Kabupaten</label>
                           <div class="col-sm-8">
                              <input type="text" name="kota_kabupaten" class="form-control" value="<?= _ent($so->kota_kabupaten); ?>" placeholder="Contoh: Surabaya" style="border-radius:4px;">
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="col-sm-4 control-label text-left">Provinsi</label>
                           <div class="col-sm-8">
                              <input type="text" name="provinsi" class="form-control" value="<?= _ent($so->provinsi); ?>" placeholder="Contoh: Jawa Timur" style="border-radius:4px;">
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Section 3: Product Items -->
                  <h4 style="font-weight:700; color:#0284c7; border-bottom:2px solid #0284c7; padding-bottom:8px; margin-top:20px; margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;">
                     <span><i class="fa fa-cubes"></i> 3. Item Produk Penjualan Marketplace (Sesuai Resi)</span>
                     <span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:12px; font-weight:700; padding:6px 12px; border:1px solid #bae6fd;">
                        <?= count($items); ?> Item Terdaftar
                     </span>
                  </h4>

                  <div class="visible-xs pm-mobile-swipe-hint" style="background:#f8fafc; border:1px dashed #cbd5e1; border-radius:8px; padding:7px 12px; font-size:11.5px; font-weight:600; color:#64748b; margin-bottom:10px; text-align:center;">
                     <i class="fa fa-hand-o-right text-primary"></i> Geser tabel ke kanan untuk melihat Qty dan tombol Hapus
                  </div>
                  <div class="table-responsive">
                     <table class="table table-bordered table-striped" id="table_items" style="background:#fff;">
                        <thead>
                           <tr style="background:#f1f5f9; color:#475569;">
                              <th style="width:70%;">Nama Produk (Sesuai Resi / Master)</th>
                              <th style="width:20%; text-align:center;">Jumlah (Qty)</th>
                              <th style="width:10%; text-align:center;">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if (!empty($items)): ?>
                              <?php foreach ($items as $it): ?>
                              <?php 
                                 $item_name_val = !empty($it->catatan) ? $it->catatan : (!empty($it->nama_produk) ? $it->nama_produk : $so->nama_produk_marketplace);
                              ?>
                              <tr class="item-row">
                                 <td>
                                    <div style="margin-bottom:6px;">
                                       <input type="text" name="nama_produk_item[]" class="form-control input-nama-produk" value="<?= _ent($item_name_val); ?>" placeholder="Nama produk sesuai resi..." required style="border-radius:4px; font-weight:700; color:#0f172a; font-size:14px; background:#fff;">
                                    </div>
                                    <div style="display:flex; gap:8px; margin-bottom:6px;">
                                       <div style="flex:1;">
                                          <input type="text" name="sku_item[]" class="form-control input-sm input-sku-item" value="<?= _ent((!empty($it->sku) && $it->sku !== '-') ? $it->sku : ''); ?>" placeholder="Kode SKU di resi (cth: PRD-001)..." style="border-radius:4px; font-family:monospace; font-size:11.5px;">
                                       </div>
                                       <div style="flex:1;">
                                          <input type="text" name="variasi_item[]" class="form-control input-sm input-variasi-item" value="<?= _ent((!empty($it->nama_variasi) && strtolower($it->nama_variasi) !== 'default' && $it->nama_variasi !== '-') ? $it->nama_variasi : ''); ?>" placeholder="Variasi di resi (cth: XL, Hitam)..." style="border-radius:4px; font-size:11.5px;">
                                       </div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                       <span style="font-size:11px; color:#64748b; white-space:nowrap;"><i class="fa fa-link text-info"></i> Link Produk Master (Opsional):</span>
                                       <select name="produk_id[]" class="form-control input-sm select-produk" style="border-radius:4px; font-size:11.5px; height:28px; padding:2px 8px;">
                                          <option value="0">-- Tanpa Link / Produk Khusus Resi --</option>
                                          <?php foreach($produks as $p): ?>
                                             <option value="<?= $p->id; ?>" data-nama="<?= _ent($p->nama_produk); ?>" data-kode="<?= _ent($p->kode_produk); ?>" data-harga="<?= (float)($p->harga_jual ?? 0); ?>" <?= ($p->id == $it->produk_id) ? 'selected' : ''; ?>>
                                                <?= _ent($p->nama_produk); ?> (<?= _ent($p->kode_produk); ?>)
                                             </option>
                                          <?php endforeach; ?>
                                       </select>
                                    </div>
                                    <input type="hidden" name="harga_satuan[]" value="0">
                                    <input type="hidden" name="subtotal_item[]" value="0">
                                 </td>
                                 <td style="vertical-align:top; padding-top:14px;">
                                    <input type="number" name="qty[]" class="form-control input-qty text-center" value="<?= max(1, (int)$it->qty); ?>" min="1" required style="border-radius:4px; font-weight:800; font-size:15px; color:#0284c7;">
                                 </td>
                                 <td class="text-center" style="vertical-align:top; padding-top:14px;">
                                    <button type="button" class="btn btn-danger btn-xs btn-remove-row" style="padding:4px 8px;"><i class="fa fa-trash"></i></button>
                                 </td>
                              </tr>
                              <?php endforeach; ?>
                           <?php else: ?>
                              <tr class="item-row">
                                 <td>
                                    <div style="margin-bottom:6px;">
                                       <input type="text" name="nama_produk_item[]" class="form-control input-nama-produk" value="<?= _ent($so->nama_produk_marketplace); ?>" placeholder="Nama produk sesuai resi..." required style="border-radius:4px; font-weight:700; color:#0f172a; font-size:14px; background:#fff;">
                                    </div>
                                    <div style="display:flex; gap:8px; margin-bottom:6px;">
                                       <div style="flex:1;">
                                          <input type="text" name="sku_item[]" class="form-control input-sm input-sku-item" value="<?= _ent((!empty($so->sku_induk) && $so->sku_induk !== '-') ? $so->sku_induk : ''); ?>" placeholder="Kode SKU di resi (cth: PRD-001)..." style="border-radius:4px; font-family:monospace; font-size:11.5px;">
                                       </div>
                                       <div style="flex:1;">
                                          <input type="text" name="variasi_item[]" class="form-control input-sm input-variasi-item" value="<?= _ent((!empty($so->nama_variasi) && strtolower($so->nama_variasi) !== 'default' && $so->nama_variasi !== '-') ? $so->nama_variasi : ''); ?>" placeholder="Variasi di resi (cth: XL, Hitam)..." style="border-radius:4px; font-size:11.5px;">
                                       </div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                       <span style="font-size:11px; color:#64748b; white-space:nowrap;"><i class="fa fa-link text-info"></i> Link Produk Master (Opsional):</span>
                                       <select name="produk_id[]" class="form-control input-sm select-produk" style="border-radius:4px; font-size:11.5px; height:28px; padding:2px 8px;">
                                          <option value="0">-- Tanpa Link / Produk Khusus Resi --</option>
                                          <?php foreach($produks as $p): ?>
                                             <option value="<?= $p->id; ?>" data-nama="<?= _ent($p->nama_produk); ?>" data-kode="<?= _ent($p->kode_produk); ?>" data-harga="<?= (float)($p->harga_jual ?? 0); ?>">
                                                <?= _ent($p->nama_produk); ?> (<?= _ent($p->kode_produk); ?>)
                                             </option>
                                          <?php endforeach; ?>
                                       </select>
                                    </div>
                                    <input type="hidden" name="harga_satuan[]" value="0">
                                    <input type="hidden" name="subtotal_item[]" value="0">
                                 </td>
                                 <td style="vertical-align:top; padding-top:14px;">
                                    <input type="number" name="qty[]" class="form-control input-qty text-center" value="1" min="1" required style="border-radius:4px; font-weight:800; font-size:15px; color:#0284c7;">
                                 </td>
                                 <td class="text-center" style="vertical-align:top; padding-top:14px;">
                                    <button type="button" class="btn btn-danger btn-xs btn-remove-row" style="padding:4px 8px;"><i class="fa fa-trash"></i></button>
                                 </td>
                              </tr>
                           <?php endif; ?>
                        </tbody>
                        <tfoot>
                           <tr style="background:#f8fafc;">
                              <td class="text-right" style="vertical-align:middle;"><strong>TOTAL KUANTITAS BARANG (PCS):</strong></td>
                              <td class="text-center">
                                 <span id="label_total_qty" style="font-size:15px; font-weight:800; color:#0284c7;">0 pcs</span>
                                 <input type="hidden" name="total" id="grand_total" value="0">
                              </td>
                              <td class="text-center">
                                 <button type="button" class="btn btn-success btn-xs" id="btn_add_row"><i class="fa fa-plus"></i> Tambah</button>
                              </td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>

                  <div class="form-group" style="margin-top:20px;">
                     <label class="col-sm-2 control-label text-left">Catatan Pesanan</label>
                     <div class="col-sm-10">
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan pesanan..." style="border-radius:4px;"><?= _ent($so->catatan); ?></textarea>
                     </div>
                  </div>

               </div>

               <div class="box-footer" style="padding: 16px 24px; background:#fff; border-top:1px solid #e2e8f0;">
                  <div class="pull-right">
                     <a href="<?= site_url('administrator/penjualan_marketplace'); ?>" class="btn btn-default btn-flat" style="border-radius:4px; margin-right:8px;">Batal</a>
                     <button type="submit" class="btn btn-primary btn-flat" style="border-radius:4px; font-weight:700; background-color:#0284c7; border-color:#0284c7;"><i class="fa fa-save"></i> Perbarui Pesanan Marketplace</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>

<script>
$(document).ready(function(){
   function recalculateTotalQty() {
      var total = 0;
      $('.input-qty').each(function(){
         total += parseInt($(this).val()) || 0;
      });
      $('#label_total_qty').text(total + ' pcs');
   }

   $(document).on('input change', '.input-qty', function(){
      recalculateTotalQty();
   });

   $(document).on('change', '.select-produk', function(){
      var $row = $(this).closest('.item-row');
      var $selected = $(this).find('option:selected');
      var val = $(this).val();

      if (val && val !== '0') {
         var nama = $selected.attr('data-nama') || $selected.data('nama') || '';
         var kode = $selected.attr('data-kode') || $selected.data('kode') || '';
         var harga = $selected.attr('data-harga') || $selected.data('harga') || 0;

         // Fallback jika data-nama kosong, parse dari teks opsi cth: "Nama Produk (KODE)"
         if (!nama) {
            var txt = $selected.text().trim();
            var match = txt.match(/^(.*?)(?:\s*\((.*?)\))?$/);
            if (match) {
               nama = match[1].trim();
               if (!kode && match[2]) {
                  kode = match[2].trim();
               }
            }
         }

         // Otomatis isi Nama Produk mengikuti Link Produk Master yang dipilih
         if (nama) {
            $row.find('.input-nama-produk').val(nama).trigger('input').trigger('change');
         }
         // Otomatis isi Kode SKU mengikuti Link Produk Master yang dipilih
         if (kode) {
            $row.find('.input-sku-item').val(kode).trigger('input').trigger('change');
         }
         if (typeof harga !== 'undefined') {
            $row.find('input[name="harga_satuan[]"]').val(harga);
         }

         // Efek visual highlight penanda data produk telah sinkron dengan Master
         $row.find('.input-nama-produk, .input-sku-item').css({
            'transition': 'all 0.25s ease',
            'background-color': '#ecfdf5',
            'border-color': '#10b981'
         });
         setTimeout(function(){
            $row.find('.input-nama-produk, .input-sku-item').css({
               'background-color': '#ffffff',
               'border-color': '#cbd5e1'
            });
         }, 800);
      }
   });

   $('#btn_add_row').click(function(){
      var $firstRow = $('.item-row:first');
      var $clone = $firstRow.clone();
      $clone.find('.input-nama-produk').val('');
      $clone.find('.input-sku-item').val('');
      $clone.find('.input-variasi-item').val('');
      $clone.find('.select-produk').val('0');
      $clone.find('.input-qty').val(1);
      $('#table_items tbody').append($clone);
      recalculateTotalQty();
   });

   $(document).on('click', '.btn-remove-row', function(){
      if ($('.item-row').length > 1) {
         $(this).closest('.item-row').remove();
         recalculateTotalQty();
      } else {
         alert('Minimal harus ada 1 item produk!');
      }
   });

   $('#tipe_pengiriman').on('change', function(){
      if ($(this).val() === 'COD') {
         $('#group_nominal_cod').slideDown(200);
      } else {
         $('#group_nominal_cod').slideUp(200);
         $('#total_cod').val(0);
      }
   });

   recalculateTotalQty();
});
</script>
