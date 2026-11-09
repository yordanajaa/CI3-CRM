<style>
@keyframes invoiceFadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}

.box-primary {
  border-radius: 12px !important;
  box-shadow: 0 4px 18px rgba(0,0,0,0.04) !important;
  animation: invoiceFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.table-responsive { -webkit-overflow-scrolling: touch; }

/* Responsive Invoice Info Table */
.table-invoice-info {
  table-layout: fixed !important;
  width: 100% !important;
}
.table-invoice-info th {
  width: 32% !important;
  color: #475569 !important;
  font-weight: 600 !important;
  vertical-align: top !important;
  white-space: normal !important;
  word-break: break-word !important;
  padding: 5px 4px 5px 0 !important;
}
.table-invoice-info td {
  width: 68% !important;
  vertical-align: top !important;
  white-space: normal !important;
  word-break: break-word !important;
  overflow-wrap: break-word !important;
  line-height: 1.45 !important;
  padding: 5px 0 5px 4px !important;
}

@media (max-width: 768px) {
  .box-tools.pull-right {
    float: none !important;
    margin-top: 10px !important;
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 6px !important;
  }
  .box-tools.pull-right .btn {
    margin: 0 !important;
    flex: 1 1 auto !important;
    text-align: center !important;
  }
  .table-invoice-info th {
    width: 33% !important;
    font-size: 11.5px !important;
  }
  .table-invoice-info td {
    width: 67% !important;
    font-size: 11.5px !important;
  }
  .table-invoice-info .chat-wa-wrapper {
    display: inline-block;
    margin-top: 3px;
  }
}
</style>

<section class="content-header">
   <h1>Detail Invoice <small><?= _ent($invoice->nomor_invoice); ?></small></h1>
   <ol class="breadcrumb"><li><a href="<?= base_url('administrator/invoice'); ?>"><i class="fa fa-file-text-o"></i> Invoice</a></li><li class="active">Detail</li></ol>
</section>
<section class="content">
<div class="row">
   <div class="col-md-12">
      <div class="box box-primary">
         <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-file-text-o"></i> Invoice <?= _ent($invoice->nomor_invoice); ?> 
               <span class="label label-<?= $status_c[$invoice->status]??'default'; ?>"><?= strtoupper($invoice->status); ?></span>
               <?php if (!empty($invoice->status_kirim)): ?>
                  <span class="label label-warning"><?= strtoupper($invoice->status_kirim); ?></span>
               <?php endif; ?>
            </h3>
            <div class="box-tools pull-right">
               <?php 
               $is_pos_view = (!empty($invoice->so_source) && $invoice->so_source == 'pos') || (stripos($invoice->catatan ?? '', 'POS Cepat') !== false);
               if ($is_pos_view && !empty($invoice->so_id)): 
               ?>
                  <a href="<?= site_url('administrator/sales_order/cetak_struk/'.$invoice->so_id.'?template=thermal'); ?>" class="btn btn-success btn-sm" style="background:#059669; border-color:#047857; font-weight:700;" target="_blank" title="Cetak Struk Kasir Thermal (58mm/80mm)"><i class="fa fa-print"></i> Cetak Struk Thermal</a>
               <?php endif; ?>
               <a href="<?= site_url('administrator/invoice/print_invoice/'.$invoice->id); ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
               <?php if($invoice->status=='draft'): ?><?php is_allowed('invoice_update', function() use ($invoice){ ?>
               <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_kirim"><i class="fa fa-truck"></i> Kirim &amp; Potong Stok</button>
               <?php }); ?><?php endif; ?>
               <?php if ($invoice->status != 'paid'): ?>
               <?php $target_piutang = $this->db->get_where('piutang_usaha', ['invoice_id' => $invoice->id])->row(); ?>
               <a href="<?= site_url('administrator/piutang_usaha?q=' . urlencode($target_piutang ? $target_piutang->nomor_piutang : $invoice->nomor_invoice)); ?>" class="btn btn-success btn-sm" style="font-weight:700;"><i class="fa fa-money"></i> Terima Pembayaran</a>
               <?php endif; ?>
               <a href="<?= base_url('administrator/invoice'); ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
         </div>
         <div class="box-body">
            
            <!-- Header Grid: 2 Columns -->
             <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-6">
                   <div class="panel panel-default" style="border-radius: 4px; box-shadow: none;">
                      <div class="panel-heading" style="background:#f8f9fa; font-weight:bold;"><i class="fa fa-user"></i> Informasi Pelanggan &amp; Order</div>
                      <div class="panel-body" style="padding: 10px 15px;">
                         <table class="table table-condensed table-borderless table-invoice-info" style="margin-bottom:0;">
                            <tr><th>Pelanggan:</th><td><a href="<?= site_url('administrator/pelanggan/view/'.$invoice->pelanggan_id); ?>"><strong style="font-size:14px; color:#0284c7;"><?= _ent($invoice->nama_pelanggan); ?> <i class="fa fa-external-link" style="font-size:11px;"></i></strong></a></td></tr>
                            <tr><th>Alamat:</th><td style="word-break:break-word; overflow-wrap:break-word; line-height:1.45;"><?= nl2br(_ent($invoice->alamat_pelanggan ?? '-')); ?></td></tr>
                            <tr>
                               <th>No. Telp:</th>
                               <td>
                                  <?= _ent($invoice->telp_pelanggan ?? '-'); ?>
                                  <?php 
                                     $inv_ph = preg_replace('/[^0-9]/', '', (string)($invoice->telp_pelanggan ?? ''));
                                     if(!empty($inv_ph)):
                                        $inv_wa = (substr($inv_ph, 0, 1) === '0') ? ('62' . substr($inv_ph, 1)) : $inv_ph;
                                        $inv_msg = "Halo Kak " . ($invoice->nama_pelanggan ?? '') . ", ini informasi Faktur/Invoice No. " . $invoice->nomor_invoice . " senilai Rp " . number_format($invoice->total, 0, ',', '.') . ". Terima kasih.";
                                  ?>
                                     <span class="chat-wa-wrapper" style="margin-left:4px;">
                                        <a href="https://wa.me/<?= $inv_wa; ?>?text=<?= urlencode($inv_msg); ?>" target="_blank" class="btn btn-xs btn-success" style="border-radius:3px; padding:2px 7px; font-weight:600;" title="Chat WhatsApp Pelanggan">
                                           <i class="fa fa-whatsapp"></i> Chat WA
                                        </a>
                                     </span>
                                  <?php endif; ?>
                               </td>
                            </tr>
                            <tr>
                               <th>Sumber:</th>
                               <td>
                                  <?php 
                                  $is_pos_view = (!empty($invoice->so_source) && $invoice->so_source == 'pos') || (stripos($invoice->catatan ?? '', 'POS Cepat') !== false);
                                  if ($is_pos_view): 
                                  ?>
                                     <span class="label" style="background:#059669; color:#fff; font-size:11px; font-weight:700; padding:4px 8px; border-radius:4px;"><i class="fa fa-bolt"></i> Kasir Cepat (POS)</span>
                                     <?php if (!empty($invoice->so_id)): ?>
                                        <a href="<?= site_url('administrator/sales_order/cetak_struk/' . $invoice->so_id . '?template=thermal'); ?>" target="_blank" class="btn btn-xs btn-default" style="margin-left:6px; font-weight:600; border-color:#059669; color:#059669;" title="Cetak Struk Thermal (58mm/80mm)">
                                           <i class="fa fa-print"></i> Cetak Thermal
                                        </a>
                                     <?php endif; ?>
                                  <?php else: ?>
                                     <span class="label" style="background:#2563eb; color:#fff; font-size:11px; font-weight:700; padding:4px 8px; border-radius:4px;"><i class="fa fa-list-alt"></i> Transaksi Penjualan</span>
                                  <?php endif; ?>
                                </td>
                             </tr>
                             <tr><th>Ref. Transaksi:</th><td><?= !empty($invoice->so_id) ? '<a href="'.site_url('administrator/sales_order/view/'.$invoice->so_id).'"><span class="label label-info" style="font-size:11px; padding:3px 6px; word-break:break-all;">' . _ent($invoice->nomor_so) . ' <i class="fa fa-external-link" style="font-size:10px;"></i></span></a>' : '-'; ?></td></tr>
                         </table>
                      </div>
                   </div>
                </div>
                
                <div class="col-md-6">
                   <div class="panel panel-default" style="border-radius: 4px; box-shadow: none;">
                      <div class="panel-heading" style="background:#f8f9fa; font-weight:bold;"><i class="fa fa-truck"></i> Detail Pengiriman &amp; Tanggal</div>
                      <div class="panel-body" style="padding: 10px 15px;">
                         <table class="table table-condensed table-borderless table-invoice-info" style="margin-bottom:0;">
                            <tr><th>Tgl Invoice:</th><td><?= date('d/m/Y', strtotime($invoice->tanggal_invoice)); ?></td></tr>
                            <tr><th>Jatuh Tempo:</th><td><?= $invoice->tanggal_jatuh_tempo ? date('d/m/Y', strtotime($invoice->tanggal_jatuh_tempo)) : '-'; ?></td></tr>
                            <tr><th>Status Kirim:</th><td><strong class="text-primary"><?= strtoupper(_ent($invoice->status_kirim ?? 'BELUM DIKIRIM')); ?></strong></td></tr>
                            <tr><th>No. Resi / AWB:</th><td style="word-break:break-all;"><strong><?= _ent($invoice->nomor_resi ?? '-'); ?></strong></td></tr>
                            <tr><th>Ekspedisi:</th><td><?= _ent($invoice->ekspedisi ?? '-'); ?></td></tr>
                          <?php $linked_piutang = $this->db->get_where('piutang_usaha', ['invoice_id' => $invoice->id])->row(); ?>
                          <?php if($linked_piutang): ?>
                          <tr><th>Status Piutang:</th><td><a href="<?= site_url('administrator/piutang_usaha?q=' . urlencode($linked_piutang->nomor_piutang)); ?>"><span class="label <?= $linked_piutang->status == 'lunas' ? 'label-success' : 'label-warning'; ?>" style="word-break:break-all;"><i class="fa fa-money"></i> <?= _ent($linked_piutang->nomor_piutang); ?> (<?= strtoupper($linked_piutang->status); ?> - Sisa Rp <?= number_format($linked_piutang->sisa, 0, ',', '.'); ?>)</span></a></td></tr>
                          <?php endif; ?>
                         </table>
                      </div>
                   </div>
                </div>
             </div>

            <!-- Item Table -->
            <h4 style="border-bottom:2px solid #3c8dbc; padding-bottom:5px; margin-bottom:15px; font-weight:bold; color:#333;"><i class="fa fa-cubes"></i> Item Barang Penjualan</h4>
            <div class="table-responsive" style="margin-bottom: 25px;">
               <table class="table table-bordered table-striped">
                  <thead>
                     <tr style="background:#f4f6f9;">
                        <th style="width:5%; text-align:center;">#</th>
                        <th style="width:40%;">Nama Produk</th>
                        <th style="width:10%; text-align:center;">Qty</th>
                        <th style="width:15%; text-align:right;">Harga Satuan</th>
                        <th style="width:10%; text-align:right;">Disc (%)</th>
                        <th style="width:20%; text-align:right;">Subtotal</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($items as $i=>$item): ?>
                     <?php 
                        $inv_disc_pct = (float)($invoice->diskon_persen_total ?? 0);
                        if ($inv_disc_pct == 0 && !empty($invoice->diskon_total) && !empty($invoice->subtotal) && $invoice->subtotal > 0) {
                           $inv_disc_pct = round(($invoice->diskon_total / $invoice->subtotal) * 100, 1);
                        }
                        if ($inv_disc_pct > 100) {
                           $inv_disc_pct = min(100, $inv_disc_pct / 100);
                        }
                        $it_disc = (float)(($item->diskon_persen > 0) ? $item->diskon_persen : $inv_disc_pct);
                        if ($it_disc > 100) {
                           if ($it_disc <= 10000) {
                              $it_disc = $it_disc / 100;
                           } else {
                              $it_disc = $inv_disc_pct;
                           }
                        }
                        $it_disc_fmt = ($it_disc == floor($it_disc)) ? number_format($it_disc, 0) : number_format($it_disc, 1);
                     ?>
                     <tr>
                        <td class="text-center"><?= $i+1; ?></td>
                        <td><a href="<?= site_url('administrator/stok/kartu/' . $item->produk_id); ?>" title="Lihat Kartu Stok Produk"><strong style="color:#0284c7;"><?= _ent($item->nama_produk); ?> <i class="fa fa-external-link" style="font-size:10px;"></i></strong></a><br><small class="text-muted">Kode: <?= _ent($item->kode_produk); ?></small></td>
                        <td class="text-center"><strong><?= number_format((float)$item->qty, 0, ',', '.'); ?></strong> <?= _ent($item->singkatan??$item->satuan); ?></td>
                        <td class="text-right">Rp <?= number_format($item->harga_satuan, 0, ',', '.'); ?></td>
                        <td class="text-right"><strong><?= $it_disc_fmt; ?>%</strong></td>
                        <td class="text-right"><strong>Rp <?= number_format($item->subtotal, 0, ',', '.'); ?></strong></td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>

            <!-- Footer Grid: Catatan & Ringkasan Total -->
            <?php 
               $subtotal_val = (float) ($invoice->subtotal ?? 0);
               $diskon_val   = (float) ($invoice->diskon_total ?? 0);
               if ($diskon_val > $subtotal_val && $subtotal_val > 0) {
                  $pct = min(100, $diskon_val / $subtotal_val);
                  $diskon_val = $subtotal_val * ($pct / 100);
               }
               $pajak_pct     = (float) ($invoice->pajak_persen ?? 0);
               $after_disc_v  = max(0, $subtotal_val - $diskon_val);
               $pajak_val     = $after_disc_v * ($pajak_pct / 100);
               $total_val     = $after_disc_v + $pajak_val;
               $diskon_pct_display = $subtotal_val > 0 ? round(($diskon_val / $subtotal_val) * 100, 1) : 0;
            ?>

            <div class="row">
               <div class="col-md-7">
                  <?php if (!empty($invoice->catatan)): ?>
                     <div class="callout callout-info" style="border-left-width: 4px; background:#f4f8fa; border-color:#5bc0de; color:#31708f; padding: 12px 15px;">
                        <h5 style="margin-top:0; font-weight:bold;"><i class="fa fa-commenting-o"></i> Catatan Transaksi:</h5>
                        <p style="margin-bottom:0; font-style:italic;"><?= nl2br(_ent($invoice->catatan)); ?></p>
                     </div>
                  <?php endif; ?>
               </div>
               
               <div class="col-md-5">
                  <div class="well well-sm" style="background: #fff; border: 1px solid #e3e3e3; padding: 15px; border-radius: 4px;">
                     <table class="table table-condensed" style="margin-bottom: 0;">
                        <tr>
                           <td style="border:none;"><strong>Subtotal:</strong></td>
                           <td style="border:none;" class="text-right">Rp <?= number_format($subtotal_val, 0, ',', '.'); ?></td>
                        </tr>
                        <?php if ($diskon_val > 0): ?>
                        <tr>
                           <td style="border:none;" class="text-danger">Diskon Keseluruhan <?= $diskon_pct_display > 0 ? '('.$diskon_pct_display.'%)' : ''; ?>:</td>
                           <td style="border:none;" class="text-right text-danger">- Rp <?= number_format($diskon_val, 0, ',', '.'); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($pajak_val > 0): ?>
                        <tr>
                           <td style="border:none;">Pajak (<?= $pajak_pct; ?>%):</td>
                           <td style="border:none;" class="text-right">Rp <?= number_format($pajak_val, 0, ',', '.'); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr style="font-size: 16px; border-top: 2px solid #ddd;">
                           <td style="padding-top:10px;"><strong>TOTAL INVOICE:</strong></td>
                           <td style="padding-top:10px;" class="text-right"><strong class="text-primary">Rp <?= number_format($total_val, 0, ',', '.'); ?></strong></td>
                        </tr>
                     </table>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>

<!-- Modal Kirim -->
<div class="modal fade" id="modal_kirim">
   <div class="modal-dialog"><div class="modal-content">
      <div class="modal-header" style="background:#3c8dbc; color:#fff;"><button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button><h4 class="modal-title"><i class="fa fa-truck"></i> Konfirmasi Pengiriman Pesanan</h4></div>
      <form method="post" action="<?= site_url('administrator/invoice/kirim/'.$invoice->id); ?>">
         <div class="modal-body">
            <div class="form-group">
               <label>Pilihan Ekspedisi / Kurir <span class="text-danger">*</span></label>
               <select class="form-control" name="ekspedisi" required>
                  <option value="">-- Pilih Ekspedisi / Kurir --</option>
                  <option value="JNE Express">JNE Express</option>
                  <option value="J&T Express">J&T Express</option>
                  <option value="SiCepat">SiCepat Express</option>
                  <option value="TIKI">TIKI</option>
                  <option value="POS Indonesia">POS Indonesia</option>
                  <option value="AnterAja">AnterAja</option>
                  <option value="Ninja Xpress">Ninja Xpress</option>
                  <option value="GoSend / GrabExpress">GoSend / GrabExpress</option>
                  <option value="Kurir Toko / Internal">Kurir Toko / Internal</option>
                  <option value="Lainnya">Lainnya</option>
               </select>
            </div>
            <div class="form-group">
               <label>No. Resi / AWB / Bukti Kirim <span class="text-danger">*</span></label>
               <input type="text" class="form-control" name="nomor_resi" placeholder="Ketik No. Resi (Contoh: JNE123456789)..." required>
            </div>
            <div class="callout callout-warning" style="margin-bottom:0;"><p><i class="fa fa-info-circle"></i> Setelah dikonfirmasi: Status kirim berubah ke <strong>SHIPPED</strong>, stok barang otomatis terpotong, dan piutang usaha diterbitkan.</p></div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Konfirmasi & Kirim</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
         </div>
      </form>
   </div></div>
</div>
</section>
