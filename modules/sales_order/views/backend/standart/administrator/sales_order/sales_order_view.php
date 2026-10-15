<?php /* sales_order_view.php */
$status_color=['draft'=>'default','confirmed'=>'info','processing'=>'primary','shipped'=>'warning','delivered'=>'success','cancelled'=>'danger'];

// Determine address
$display_alamat = !empty($so->alamat_pengiriman) 
    ? trim($so->alamat_pengiriman . ($so->kota_kabupaten ? ', ' . $so->kota_kabupaten : '') . ($so->provinsi ? ', ' . $so->provinsi : ''))
    : (!empty($so->alamat_pelanggan) ? $so->alamat_pelanggan : 'Jl. Sudirman No. 45, Jakarta');

// Determine phone
$display_phone = !empty($so->no_telepon) 
    ? $so->no_telepon 
    : (!empty($so->telp_pelanggan) ? $so->telp_pelanggan : '081234567890');

// Determine receiver & customer name
$display_pelanggan = !empty($so->nama_pelanggan) 
    ? $so->nama_pelanggan 
    : (!empty($so->nama_penerima) 
        ? $so->nama_penerima 
        : (!empty($so->username_pembeli) 
            ? $so->username_pembeli 
            : (!empty($so->no_telepon) 
                ? $so->no_telepon 
                : 'Pelanggan Umum')));
$display_buyer = (!empty($so->username_pembeli) && $so->username_pembeli != $display_pelanggan) ? ' (@' . $so->username_pembeli . ')' : '';

// Determine estimated send date / deadline
$display_est_kirim = !empty($so->pesanan_harus_dikirim_sebelum) 
    ? date('d/m/Y H:i', strtotime($so->pesanan_harus_dikirim_sebelum)) 
    : (!empty($so->tanggal_estimasi_kirim) ? date('d/m/Y', strtotime($so->tanggal_estimasi_kirim)) : date('d/m/Y', strtotime("+1 day", strtotime($so->tanggal_so))));

// Determine resi & courier
$display_resi = !empty($so->nomor_resi) ? $so->nomor_resi : '-';
$display_kurir = !empty($so->opsi_pengiriman) ? $so->opsi_pengiriman : (!empty($so->kurir_ekspedisi) ? $so->kurir_ekspedisi : 'Reguler Courier');
?>
<style>
@keyframes soFadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}
.box-primary {
  border-radius: 12px !important;
  box-shadow: 0 4px 18px rgba(0,0,0,0.04) !important;
  animation: soFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.table-responsive { -webkit-overflow-scrolling: touch; }

@media (max-width: 767px) {
  .content { padding: 8px 6px !important; }
  .box-header { padding: 12px 14px !important; }
  .box-header .box-title { font-size: 14px !important; display: block !important; line-height: 1.4 !important; }
  .box-header .box-tools.pull-right {
    position: static !important;
    float: none !important;
    width: 100% !important;
    margin-top: 10px !important;
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 6px !important;
  }
  .box-header .box-tools .btn,
  .box-header .box-tools .btn-group {
    flex: 1 1 calc(50% - 4px) !important;
    min-width: 0 !important;
  }
  .box-header .box-tools .btn-group .btn {
    width: 100% !important;
  }
  .box-body { padding: 12px 10px !important; }
  .panel-body { padding: 10px !important; }
  .table-responsive { border: none !important; margin-bottom: 12px !important; }
  .table-responsive table { min-width: 600px; }
  .alert { padding: 10px 12px !important; font-size: 11.5px !important; }
  .alert h4 { font-size: 13.5px !important; }
}

@media (max-width: 480px) {
  .box-header .box-tools .btn,
  .box-header .box-tools .btn-group {
    flex: 1 1 100% !important;
  }
}
</style>

<section class="content-header">
   <h1>Detail Penjualan <small><?= _ent($so->nomor_so); ?></small></h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/sales_order'); ?>"><i class="fa fa-file-text"></i> Penjualan</a></li>
      <li class="active">Detail</li>
   </ol>
</section>

<section class="content">
<div class="row">
   <div class="col-md-12">
      <?php 
      $linked_inv = $this->db->get_where('invoice', ['so_id' => $so->id])->row();
      ?>
      <div class="box box-primary" style="border-radius:6px; border-top: 3px solid #3c8dbc;">
         <div class="box-header with-border" style="padding: 15px 20px;">
            <h3 class="box-title" style="font-weight:600;"><i class="fa fa-shopping-cart text-primary"></i> Sales Order <?= _ent($so->nomor_so); ?> &nbsp;
               <?php if(!empty($so->no_pesanan) && $so->no_pesanan != $so->nomor_so): ?>
                  <span class="label label-primary" style="font-size:11px;"><?= _ent($so->no_pesanan); ?></span>
               <?php endif; ?>
               <span class="label label-<?= $status_color[$so->status]??'default'; ?>" style="font-size:11px; margin-left:4px;"><?= strtoupper($so->status); ?></span>
               <?php if(!empty($so->waktu_pembayaran) || ($linked_inv && $linked_inv->status == 'paid')): ?>
                  <span class="label label-success" style="font-size:11px; margin-left:4px;"><i class="fa fa-check-circle"></i> LUNAS (PAID)</span>
               <?php endif; ?>
               <?php if ($so->source == 'pos' || strpos((string)$so->catatan, '[POS CEPAT') !== false): ?>
                  <span class="label" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; font-size:11px; margin-left:4px;"><i class="fa fa-bolt"></i> POS KASIR</span>
               <?php elseif(!empty($so->source) && $so->source != 'manual'): ?>
                  <span class="label label-success" style="font-size:11px; margin-left:4px; text-transform:uppercase;"><i class="fa fa-shopping-bag"></i> <?= _ent($so->source); ?></span>
               <?php endif; ?>
            </h3>
            <div class="box-tools pull-right" style="display:flex; gap:6px; align-items:center;">
               <?php if ($linked_inv): ?>
                  <a href="<?= site_url('administrator/invoice/view/' . $linked_inv->id); ?>" class="btn btn-info btn-sm btn-flat" style="border-radius:4px; font-weight:600;"><i class="fa fa-file-text-o"></i> Lihat Invoice <?= _ent($linked_inv->nomor_invoice); ?></a>
               <?php elseif (in_array($so->status, ['confirmed', 'processing', 'packing', 'shipped', 'delivered']) && is_allowed('invoice_add', false)): ?>
                  <a href="<?= site_url('administrator/invoice/from_so/' . $so->id); ?>" class="btn btn-success btn-sm btn-flat" style="border-radius:4px; font-weight:600;"><i class="fa fa-file-text-o"></i> Buat Invoice</a>
               <?php endif; ?>

               <?php if ($so->status == 'draft' && is_allowed('sales_order_update', false)): ?>
               <a href="<?= site_url('administrator/sales_order/konfirmasi/' . $so->id); ?>" class="btn btn-success btn-sm btn-flat" style="border-radius:4px; font-weight:700;" onclick="return confirm('Konfirmasi Sales Order ini sekarang? Stok barang akan diverifikasi.');">
                  <i class="fa fa-check-circle"></i> Konfirmasi Pesanan Sekarang
               </a>
               <?php endif; ?>

               <?php if (is_allowed('sales_order_update', false)): ?>
               <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-default dropdown-toggle btn-flat" data-toggle="dropdown" style="border-radius:4px; font-weight:600;">
                     <i class="fa fa-refresh text-primary"></i> Ubah Status <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right" style="font-size:12px; text-align:left; min-width:220px; box-shadow:0 4px 15px rgba(0,0,0,0.15);">
                     <li class="dropdown-header" style="font-weight:700; color:#475569;">Alur Status Pesanan:</li>
                     <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=draft'); ?>">🟡 1. DRAFT (Pesanan Baru)</a></li>
                     <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=confirmed'); ?>">🔵 2. TERKONFIRMASI (Stok Ready)</a></li>
                     <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=packing'); ?>">📦 3. SEDANG DIKEMAS (Packing)</a></li>
                     <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=shipped'); ?>">🚚 4. DALAM PENGIRIMAN (Shipped)</a></li>
                     <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=delivered'); ?>">🟢 5. PESANAN SELESAI (Delivered)</a></li>
                     <li class="divider"></li>
                     <li><a href="<?= site_url('administrator/sales_order/update_status/'.$so->id.'?status=cancelled'); ?>" class="text-danger"><i class="fa fa-times-circle"></i> Dibatalkan</a></li>
                  </ul>
               </div>
               <?php endif; ?>

               <div class="btn-group">
                   <button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown" style="border-radius:4px; font-weight:600;">
                      <i class="fa fa-print text-primary"></i> Cetak Dokumen <span class="caret"></span>
                   </button>
                   <ul class="dropdown-menu dropdown-menu-right" style="font-size:12px; min-width:260px; box-shadow:0 4px 15px rgba(0,0,0,0.15);">
                      <li>
                         <a href="<?= site_url('administrator/sales_order/cetak_struk/' . $so->id . '?template=thermal'); ?>" target="_blank">
                            <i class="fa fa-ticket text-success"></i> <b>1. Struk Kasir Thermal (58/80mm)</b>
                         </a>
                      </li>
                      <li>
                         <a href="<?= site_url('administrator/sales_order/cetak_struk/' . $so->id . '?template=lebar'); ?>" target="_blank">
                            <i class="fa fa-building-o text-primary"></i> <b>2. Faktur Lebar (Format Perusahaan)</b>
                         </a>
                      </li>
                      <li class="divider"></li>
                      <li>
                         <a href="<?= site_url('administrator/sales_order/cetak/' . $so->id); ?>" target="_blank">
                            <i class="fa fa-file-pdf-o text-danger"></i> 3. Unduh Dokumen PDF (A4)
                         </a>
                      </li>
                   </ul>
                </div> 
               <a href="<?= site_url('administrator/sales_order'); ?>" class="btn btn-default btn-sm btn-flat" style="border-radius:4px;"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
         </div>

         <div class="box-body" style="padding: 20px;">
            <!-- Header Grid: 2 Columns -->
            <div class="row" style="margin-bottom: 20px;">
               <div class="col-md-6">
                  <div class="panel panel-default" style="border-radius: 6px; box-shadow: none; border:1px solid #e9ecef;">
                     <div class="panel-heading" style="background:#f8fafc; font-weight:700; color:#334155; display:flex; justify-content:space-between; align-items:center;">
                        <span><i class="fa fa-user text-primary"></i> Informasi Pelanggan &amp; Order</span>
                        <?php if (!empty($display_phone)): ?>
                           <a href="<?= site_url('administrator/crm/customer_summary?phone=' . urlencode(preg_replace('/[^0-9]/', '', $display_phone))); ?>" class="btn btn-xs btn-default" style="border-radius:4px; font-weight:600;"><i class="fa fa-line-chart text-purple"></i> Analisis RFM / CRM</a>
                        <?php endif; ?>
                     </div>
                     <div class="panel-body" style="padding: 15px;">
                        <table class="table table-condensed table-borderless" style="margin-bottom:0; font-size:13px;">
                           <tr>
                              <th style="width:35%; color:#64748b;">Pelanggan / Penerima:</th>
                              <td>
                                 <?php if (!empty($so->pelanggan_id)): ?>
                                    <a href="<?= site_url('administrator/pelanggan/view/' . $so->pelanggan_id); ?>" title="Buka Detail Pelanggan" style="font-weight:700; font-size:14px; color:#1d4ed8;">
                                       <?= _ent($display_pelanggan); ?> <i class="fa fa-external-link" style="font-size:11px;"></i>
                                    </a>
                                 <?php else: ?>
                                    <strong style="font-size:14px; color:#1e293b;"><?= _ent($display_pelanggan); ?></strong>
                                 <?php endif; ?>
                                 <small class="text-muted"><?= _ent($display_buyer); ?></small>
                                 <span class="label label-info" style="font-size:9px; margin-left:4px;"><?= strtoupper(_ent($so->tipe_pelanggan ?? 'ONLINE')); ?></span>
                              </td>
                           </tr>
                           <tr><th style="color:#64748b;">Alamat Pengiriman:</th><td><strong style="color:#334155;"><?= _ent($display_alamat); ?></strong></td></tr>
                           <tr>
                              <th style="color:#64748b;">No. Telepon:</th>
                              <td>
                                 <?php $phone_digits = preg_replace('/[^0-9]/', '', (string)$display_phone); ?>
                                 <?php if (!empty($phone_digits)): ?>
                                    <strong style="color:#0284c7;"><?= _ent($display_phone); ?></strong>
                                    <a href="https://wa.me/<?= (substr($phone_digits, 0, 1) === '0') ? ('62' . substr($phone_digits, 1)) : $phone_digits; ?>" target="_blank" class="btn btn-xs btn-success" style="margin-left:6px; border-radius:3px; padding:1px 6px;" title="Hubungi via WhatsApp">
                                       <i class="fa fa-whatsapp"></i> Chat WA
                                    </a>
                                 <?php else: ?>
                                    <span class="text-muted">-</span>
                                 <?php endif; ?>
                              </td>
                           </tr>
                           <tr><th style="color:#64748b;">Dibuat Oleh:</th><td><i class="fa fa-user-circle text-muted"></i> <?= _ent($so->created_by ?: 'admin'); ?></td></tr>
                        </table>
                     </div>
                  </div>
               </div>
               
               <div class="col-md-6">
                  <div class="panel panel-default" style="border-radius: 6px; box-shadow: none; border:1px solid #e9ecef;">
                     <div class="panel-heading" style="background:#f8fafc; font-weight:700; color:#334155;"><i class="fa fa-calendar text-primary"></i> Tanggal &amp; Pengiriman Pesanan</div>
                     <div class="panel-body" style="padding: 15px;">
                        <table class="table table-condensed table-borderless" style="margin-bottom:0; font-size:13px;">
                           <tr><th style="width:40%; color:#64748b;">Tanggal Penjualan:</th><td><i class="fa fa-calendar text-muted"></i> <?= date('d/m/Y', strtotime($so->tanggal_so)); ?></td></tr>
                           <tr><th style="color:#64748b;">Est. Tanggal / Deadline Kirim:</th><td><strong class="text-warning"><i class="fa fa-clock-o"></i> <?= $display_est_kirim; ?></strong></td></tr>
                           <tr><th style="color:#64748b;">Opsi / Ekspedisi Kirim:</th><td><span class="label label-default" style="font-size:11px; padding:3px 7px;"><?= _ent($display_kurir); ?></span></td></tr>
                           <tr><th style="color:#64748b;">No. Resi Pengiriman:</th><td><span class="label label-info" style="font-size:11px; font-family:monospace;"><?= _ent($display_resi); ?></span></td></tr>
                           <tr><th style="color:#64748b;">Status SO:</th><td><strong class="text-primary"><?= strtoupper($so->status); ?></strong></td></tr>
                        </table>
                     </div>
                  </div>
               </div>
            </div>

            <!-- Payment Status & BKM Info -->
            <?php
            $bkm_payment = $this->db->select('pp.*, pu.nomor_piutang')
               ->from('pembayaran_piutang pp')
               ->join('piutang_usaha pu', 'pu.id = pp.piutang_id', 'LEFT')
               ->where('pu.so_id', $so->id)
               ->order_by('pp.id', 'DESC')
               ->limit(1)
               ->get()->row();
            ?>
            <?php if ($bkm_payment || !empty($so->waktu_pembayaran)): ?>
            <div class="alert alert-success" style="background:#ecfdf5 !important; border:1px solid #a7f3d0 !important; color:#065f46 !important; border-radius:8px; margin-bottom:20px; padding:12px 18px;">
               <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                  <div>
                     <h4 style="margin:0 0 4px 0; font-size:15px; font-weight:700;"><i class="fa fa-check-circle text-success"></i> Transaksi Penjualan Telah Selesai &amp; LUNAS</h4>
                     <div style="font-size:12px; color:#047857;">
                        <?php if ($bkm_payment): ?>
                           No. Kas Masuk (BKM): <strong><?= _ent($bkm_payment->nomor_bkm); ?></strong> &bull; 
                           Metode: <strong><?= strtoupper(_ent($bkm_payment->metode_pembayaran)); ?></strong> (<?= _ent($bkm_payment->akun_kas_bank); ?>) &bull; 
                           Nominal: <strong>Rp <?= number_format($bkm_payment->nominal, 0, ',', '.'); ?></strong>
                           <?php if (!empty($bkm_payment->nomor_referensi)): ?> &bull; Ref: <strong><?= _ent($bkm_payment->nomor_referensi); ?></strong><?php endif; ?>
                           <?php if (!empty($bkm_payment->catatan)): ?><br><small style="color:#059669; font-style:italic;"><i class="fa fa-info-circle"></i> <?= _ent($bkm_payment->catatan); ?></small><?php endif; ?>
                        <?php else: ?>
                           Waktu Pembayaran: <strong><?= date('d/m/Y H:i', strtotime($so->waktu_pembayaran)); ?></strong> &bull; Total: <strong>Rp <?= number_format($so->total, 0, ',', '.'); ?></strong>
                        <?php endif; ?>
                     </div>
                  </div>
                  <div>
                     <?php if ($linked_inv): ?>
                        <a href="<?= site_url('administrator/invoice/view/' . $linked_inv->id); ?>" class="btn btn-xs btn-info" style="border-radius:4px; font-weight:600;"><i class="fa fa-file-text-o"></i> Lihat Faktur Lunas</a>
                     <?php endif; ?>
                     <a href="<?= site_url('administrator/piutang_usaha'); ?>" class="btn btn-xs btn-success" style="border-radius:4px; font-weight:600;"><i class="fa fa-book"></i> Rekap Piutang &amp; Kas</a>
                  </div>
               </div>
            </div>
            <?php endif; ?>

            <!-- Item Table -->
            <h4 style="border-bottom:2px solid #3c8dbc; padding-bottom:8px; margin-bottom:15px; font-weight:700; color:#1e293b;"><i class="fa fa-cubes text-primary"></i> Item Pesanan Barang</h4>
            <div class="table-responsive" style="margin-bottom: 25px;">
               <table class="table table-bordered table-striped" style="font-size:12px; vertical-align:middle;">
                  <thead>
                     <tr style="background:#f1f5f9; color:#475569;">
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
                        $so_disc_pct = (float)($so->diskon_persen_total ?? 0);
                        if ($so_disc_pct == 0 && !empty($so->diskon_total) && !empty($so->subtotal) && $so->subtotal > 0) {
                           $so_disc_pct = round(($so->diskon_total / $so->subtotal) * 100, 1);
                        }
                        if ($so_disc_pct > 100) {
                           $so_disc_pct = min(100, $so_disc_pct / 100);
                        }
                        $it_disc = (float)(($item->diskon_persen > 0) ? $item->diskon_persen : $so_disc_pct);
                        if ($it_disc > 100) {
                           if ($it_disc <= 10000) {
                              $it_disc = $it_disc / 100;
                           } else {
                              $it_disc = $so_disc_pct;
                           }
                        }
                        $it_disc_fmt = ($it_disc == floor($it_disc)) ? number_format($it_disc, 0) : number_format($it_disc, 1);
                     ?>
                     <tr>
                        <td class="text-center"><?= $i+1; ?></td>
                        <td>
                           <a href="<?= site_url('administrator/stok/kartu/' . $item->produk_id); ?>" title="Buka Kartu Stok Produk"><strong style="color:#0284c7; font-size:13px;"><?= _ent($item->nama_produk); ?> <i class="fa fa-external-link" style="font-size:10px;"></i></strong></a><br>
                           <small class="text-muted">Kode / SKU: <?= _ent($item->kode_produk); ?></small>
                        </td>
                        <td class="text-center"><strong><?= number_format((float)$item->qty, 0, ',', '.'); ?></strong> <?= _ent($item->singkatan??$item->satuan??'unit'); ?></td>
                        <td class="text-right">Rp <?= number_format($item->harga_satuan, 0, ',', '.'); ?></td>
                        <td class="text-right"><strong><?= $it_disc_fmt; ?>%</strong></td>
                        <td class="text-right"><strong class="text-success" style="font-size:13px;">Rp <?= number_format($item->subtotal, 0, ',', '.'); ?></strong></td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>

            <!-- Footer Grid: Catatan & Ringkasan Total -->
            <?php 
               $subtotal_val = (float) ($so->subtotal ?? 0);
               $diskon_val   = (float) ($so->diskon_total ?? 0);
               $pajak_pct    = (float) ($so->pajak_persen ?? 0);
               $pajak_val    = (float) ($so->pajak_nominal ?? 0);
               $total_val    = (float) ($so->total ?? 0);
               $diskon_pct_display = (float) ($so->diskon_persen_total ?? ($subtotal_val > 0 ? round(($diskon_val / $subtotal_val) * 100, 1) : 0));
            ?>

            <div class="row">
               <div class="col-md-7">
                  <?php if (!empty($so->catatan)): ?>
                     <div class="callout callout-info" style="border-left-width: 4px; background:#f0f9ff; border-color:#0284c7; color:#0369a1; padding: 12px 15px; border-radius:4px;">
                        <h5 style="margin-top:0; font-weight:bold;"><i class="fa fa-commenting-o"></i> Catatan Pesanan:</h5>
                        <p style="margin-bottom:0; font-style:italic;"><?= nl2br(_ent($so->catatan)); ?></p>
                     </div>
                  <?php endif; ?>
               </div>
               
               <div class="col-md-5">
                  <div class="well well-sm" style="background: #fff; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px;">
                     <table class="table table-condensed" style="margin-bottom: 0; font-size:13px;">
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
                        <tr style="font-size: 16px; border-top: 2px solid #e2e8f0;">
                           <td style="padding-top:10px;"><strong>TOTAL SALES ORDER:</strong></td>
                           <td style="padding-top:10px;" class="text-right"><strong class="text-success" style="font-size:18px;">Rp <?= number_format($total_val, 0, ',', '.'); ?></strong></td>
                        </tr>
                      </table>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>
</section>
