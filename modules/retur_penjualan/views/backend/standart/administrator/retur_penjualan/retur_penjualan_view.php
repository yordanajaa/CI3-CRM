<?php
/**
 * View: Detail Retur Penjualan (Desktop & Mobile Friendly)
 * File: retur_penjualan_view.php
 */
$st_raw = strtolower($retur->status ?? 'draft');
$badge_class = 'badge-st-draft';
if ($st_raw === 'selesai') $badge_class = 'badge-st-selesai';
elseif ($st_raw === 'approved') $badge_class = 'badge-st-approved';
elseif ($st_raw === 'cancelled') $badge_class = 'badge-st-cancelled';
?>
<style>
.detail-card {
   background: #ffffff;
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   box-shadow: 0 2px 10px rgba(0,0,0,0.04);
   margin-bottom: 20px;
}
.detail-header {
   padding: 16px 20px;
   border-bottom: 1px solid #f1f5f9;
   display: flex;
   align-items: center;
   justify-content: space-between;
   flex-wrap: wrap;
   gap: 12px;
}
.detail-title {
   margin: 0;
   font-size: 17px;
   font-weight: 700;
   color: #1e293b;
   display: flex;
   align-items: center;
   gap: 8px;
}
.detail-actions {
   display: flex;
   align-items: center;
   flex-wrap: wrap;
   gap: 6px;
}
.badge-retur-status {
   display: inline-block;
   padding: 3px 8px;
   border-radius: 4px;
   font-size: 11px;
   font-weight: 700;
   text-transform: uppercase;
   letter-spacing: 0.3px;
   white-space: nowrap;
}
.badge-st-selesai { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
.badge-st-approved { background: #e0f2fe; color: #0369a1; border: 1px solid #7dd3fc; }
.badge-st-draft { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
.badge-st-cancelled { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

.info-grid {
   padding: 20px;
}
.info-row {
   display: flex;
   border-bottom: 1px solid #f1f5f9;
   padding: 9px 0;
   font-size: 13px;
}
.info-row:last-child {
   border-bottom: none;
}
.info-label {
   width: 140px;
   color: #64748b;
   font-weight: 600;
   flex-shrink: 0;
}
.info-val {
   color: #1e293b;
   flex-grow: 1;
}
.total-highlight-card {
   background: linear-gradient(135deg, #1e40af, #3b82f6);
   color: #ffffff;
   border-radius: 8px;
   padding: 18px 20px;
   margin-top: 10px;
   box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}
.total-highlight-card .lbl {
   font-size: 12px;
   text-transform: uppercase;
   letter-spacing: 0.5px;
   opacity: 0.9;
}
.total-highlight-card .val {
   font-size: 24px;
   font-weight: 800;
   margin-top: 4px;
}
.table-responsive-custom {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow-x: auto;
   -webkit-overflow-scrolling: touch;
   background: #ffffff;
}
.table-item {
   width: 100%;
   margin-bottom: 0 !important;
}
.table-item th {
   background: #f1f5f9;
   font-size: 11.5px;
   text-transform: uppercase;
   letter-spacing: 0.3px;
   color: #475569;
   font-weight: 700;
   padding: 10px 10px !important;
   border-bottom: 2px solid #cbd5e1 !important;
   white-space: nowrap;
}
.table-item td {
   padding: 10px !important;
   vertical-align: middle !important;
   font-size: 13px;
   color: #1e293b;
}
.table-item tbody tr:hover {
   background-color: #f8fafc;
}
.badge-kondisi-baik {
   background: #dcfce7;
   color: #166534;
   border: 1px solid #86efac;
   padding: 2px 7px;
   border-radius: 4px;
   font-weight: 700;
   font-size: 11px;
}
.badge-kondisi-rusak {
   background: #fee2e2;
   color: #991b1b;
   border: 1px solid #fca5a5;
   padding: 2px 7px;
   border-radius: 4px;
   font-weight: 700;
   font-size: 11px;
}

@media (max-width: 768px) {
   .detail-header {
      flex-direction: column;
      align-items: stretch;
   }
   .detail-actions {
      width: 100%;
   }
   .detail-actions .btn {
      flex: 1 1 auto;
      text-align: center;
      padding: 8px 10px;
   }
   .info-row {
      flex-direction: column;
      gap: 2px;
   }
   .info-label {
      width: 100%;
      font-size: 11.5px;
   }
}
</style>

<section class="content-header">
   <h1>
      Detail Retur Penjualan
      <small><?= _ent($retur->nomor_retur); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/retur_penjualan'); ?>">Retur Penjualan</a></li>
      <li class="active">Detail</li>
   </ol>
</section>

<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="detail-card">
            <div class="detail-header">
               <h3 class="detail-title">
                  <i class="fa fa-reply-all text-primary"></i> 
                  <?= _ent($retur->nomor_retur); ?>
                  <span class="badge-retur-status <?= $badge_class; ?>">
                     <?= strtoupper($retur->status); ?>
                  </span>
               </h3>
               <div class="detail-actions">
                  <a href="<?= site_url('administrator/retur_penjualan/cetak/' . $retur->id); ?>" target="_blank" class="btn btn-info btn-flat" style="border-radius:6px; font-weight:600;">
                     <i class="fa fa-print"></i> Cetak / Simpan PDF
                  </a>

                  <?php if ($retur->status == 'draft' && is_allowed('retur_penjualan_update', false)): ?>
                     <a href="<?= site_url('administrator/retur_penjualan/edit/' . $retur->id); ?>" class="btn btn-warning btn-flat" style="border-radius:6px; font-weight:600;">
                        <i class="fa fa-edit"></i> Edit Retur
                     </a>
                     <a href="<?= site_url('administrator/retur_penjualan/proses/' . $retur->id); ?>" class="btn btn-success btn-flat" onclick="return confirm('Proses retur ini? Stok barang akan dikembalikan ke stok.')" style="border-radius:6px; font-weight:700;">
                        <i class="fa fa-cogs"></i> Proses Retur
                     </a>
                  <?php endif; ?>

                  <a href="<?= site_url('administrator/retur_penjualan'); ?>" class="btn btn-default btn-flat" style="border-radius:6px; font-weight:600;">
                     <i class="fa fa-arrow-left"></i> Kembali
                  </a>
               </div>
            </div>

            <div class="info-grid">
               <div class="row">
                  <div class="col-md-6 col-sm-12">
                     <div class="info-row">
                        <div class="info-label"><i class="fa fa-hashtag text-muted"></i> No. Retur:</div>
                        <div class="info-val"><strong><?= _ent($retur->nomor_retur); ?></strong></div>
                     </div>
                     <div class="info-row">
                        <div class="info-label"><i class="fa fa-file-text-o text-muted"></i> Ref. Invoice:</div>
                        <div class="info-val"><?= _ent(isset($retur->nomor_invoice) ? $retur->nomor_invoice : '-'); ?></div>
                     </div>
                     <div class="info-row">
                        <div class="info-label"><i class="fa fa-user text-muted"></i> Pelanggan:</div>
                        <div class="info-val"><strong><?= _ent($retur->nama_pelanggan); ?></strong></div>
                     </div>
                     <div class="info-row">
                        <div class="info-label"><i class="fa fa-calendar text-muted"></i> Tanggal Retur:</div>
                        <div class="info-val"><?= date('d/m/Y', strtotime($retur->tanggal_retur)); ?></div>
                     </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                     <div class="info-row">
                        <div class="info-label"><i class="fa fa-exchange text-muted"></i> Tindak Lanjut:</div>
                        <div class="info-val">
                           <span class="label label-info" style="font-size:12px; font-weight:600; padding:4px 8px;">
                              <?= _ent(ucwords(str_replace('_', ' ', $retur->tindak_lanjut))); ?>
                           </span>
                        </div>
                     </div>
                     <div class="info-row">
                        <div class="info-label"><i class="fa fa-user-secret text-muted"></i> Petugas:</div>
                        <div class="info-val"><?= _ent($retur->created_by ?? '-'); ?></div>
                     </div>
                     <div class="info-row">
                        <div class="info-label"><i class="fa fa-commenting-o text-muted"></i> Alasan Retur:</div>
                        <div class="info-val"><?= _ent(ucwords(str_replace('_', ' ', $retur->alasan ?? '-'))); ?></div>
                     </div>
                     <?php if (!empty($retur->catatan)): ?>
                     <div class="info-row">
                        <div class="info-label"><i class="fa fa-sticky-note-o text-muted"></i> Catatan Detail:</div>
                        <div class="info-val" style="color:#64748b;"><?= nl2br(_ent($retur->catatan)); ?></div>
                     </div>
                     <?php endif; ?>

                     <div class="total-highlight-card">
                        <div class="lbl">TOTAL NILAI RETUR PENJUALAN</div>
                        <div class="val">Rp <?= number_format($retur->total, 0, ',', '.'); ?></div>
                     </div>
                  </div>
               </div>
            </div>

            <!-- Items Table Section -->
            <div style="padding: 0 20px 20px 20px;">
               <h4 style="font-weight:700; color:#1e293b; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                  <i class="fa fa-boxes text-primary"></i> Daftar Produk yang Diretur
               </h4>
               <div class="table-responsive-custom">
                  <table class="table table-bordered table-striped table-item">
                     <thead>
                        <tr>
                           <th class="text-center" style="width:45px;">#</th>
                           <th>Produk</th>
                           <th class="text-center" style="width:100px;">Qty Retur</th>
                           <th class="text-right" style="width:140px;">Harga Satuan</th>
                           <th class="text-right" style="width:140px;">Subtotal</th>
                           <th class="text-center" style="width:120px;">Kondisi Barang</th>
                           <th style="min-width:140px;">Alasan Item</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($items)): ?>
                           <?php foreach ($items as $i => $it): 
                              $kd = strtolower($it->kondisi ?? 'baik');
                              $k_badge = ($kd == 'baik') ? 'badge-kondisi-baik' : 'badge-kondisi-rusak';
                           ?>
                              <tr>
                                 <td class="text-center"><?= $i + 1; ?></td>
                                 <td><strong><?= _ent($it->nama_produk ?? '-'); ?></strong></td>
                                 <td class="text-center" style="font-weight:700; font-size:14px;"><?= number_format((float)$it->qty_retur, 0, ',', '.'); ?></td>
                                 <td class="text-right">Rp <?= number_format($it->harga_satuan, 0, ',', '.'); ?></td>
                                 <td class="text-right" style="font-weight:700; color:#0f172a;">Rp <?= number_format($it->subtotal, 0, ',', '.'); ?></td>
                                 <td class="text-center">
                                    <span class="<?= $k_badge; ?>">
                                       <?= ($kd == 'baik') ? '🟢 Baik (Stok Jual)' : '🔴 Rusak (Afkir)'; ?>
                                    </span>
                                 </td>
                                 <td style="color:#64748b;"><?= _ent(!empty($it->alasan) ? $it->alasan : '-'); ?></td>
                              </tr>
                           <?php endforeach; ?>
                        <?php else: ?>
                           <tr>
                              <td colspan="7" class="text-center text-muted" style="padding:18px;">Tidak ada item terdaftar.</td>
                           </tr>
                        <?php endif; ?>
                     </tbody>
                     <tfoot>
                        <tr style="background:#f8fafc; font-weight:700;">
                           <td colspan="4" class="text-right" style="padding:10px; font-size:13px;">TOTAL KESELURUHAN:</td>
                           <td class="text-right" style="padding:10px; font-size:14px; color:#1e40af;">Rp <?= number_format($retur->total, 0, ',', '.'); ?></td>
                           <td colspan="2"></td>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
