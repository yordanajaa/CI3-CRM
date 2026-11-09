<style>
@keyframes produkFadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}

.box {
  border-radius: 12px !important;
  box-shadow: 0 4px 18px rgba(0,0,0,0.04) !important;
  animation: produkFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.table-responsive { -webkit-overflow-scrolling: touch; }
</style>

<section class="content-header">
   <h1>Detail Produk <small><?= _ent($produk->nama_produk); ?></small></h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= base_url('administrator/produk'); ?>"><i class="fa fa-cube"></i> Produk</a></li>
      <li class="active">Detail</li>
   </ol>
</section>
<section class="content">
   <div class="row">
      <!-- Info Detail Produk -->
      <div class="col-md-7">
         <div class="box box-primary" style="border-radius:6px;">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-cube text-primary"></i> <?= _ent($produk->nama_produk); ?></h3>
               <div class="box-tools pull-right">
                  <?php is_allowed('produk_update', function() use ($produk){ ?>
                     <a href="<?= site_url('administrator/produk/edit/'.$produk->id); ?>" class="btn btn-warning btn-sm btn-flat" style="border-radius:4px;"><i class="fa fa-edit"></i> Edit</a>
                  <?php }); ?>
                  <a href="<?= base_url('administrator/produk'); ?>" class="btn btn-default btn-sm btn-flat" style="border-radius:4px;"><i class="fa fa-arrow-left"></i> Kembali</a>
               </div>
            </div>
            <div class="box-body">
               <table class="table table-striped table-hover">
                  <tr><th width="35%">Kode Produk</th><td><span class="label label-default" style="font-size:12px;"><?= _ent($produk->kode_produk); ?></span></td></tr>
                  <tr><th>Nama Produk</th><td><strong><?= _ent($produk->nama_produk); ?></strong></td></tr>
                  <tr><th>Kategori</th><td><?= _ent($produk->nama_kategori ?? '-'); ?></td></tr>
                  <tr><th>Satuan</th><td><?php 
                     $sat_singkat = trim((string)($produk->singkatan ?? ''));
                     $sat_nama    = trim((string)($produk->nama_satuan ?? ''));
                     $badge_txt   = !empty($sat_singkat) ? $sat_singkat : (!empty($sat_nama) ? $sat_nama : 'PCS');
                     $extra_txt   = (!empty($sat_nama) && !empty($sat_singkat) && strcasecmp($sat_nama, $sat_singkat) !== 0) ? (' ' . _ent($sat_nama)) : '';
                  ?><span class="badge bg-blue"><?= _ent($badge_txt); ?></span><?= $extra_txt; ?></td></tr>
                  <tr><th>Harga Beli</th><td>Rp <?= number_format($produk->harga_beli, 0, ',', '.'); ?></td></tr>
                  <tr><th>Harga Jual</th><td><strong class="text-success" style="font-size:14px;">Rp <?= number_format($produk->harga_jual, 0, ',', '.'); ?></strong></td></tr>
                  <tr><th>Stok Minimum</th><td><?= $produk->stok_minimum; ?> <?= _ent($produk->singkatan ?? $produk->nama_satuan ?? 'unit'); ?></td></tr>
                  <tr><th>Metode Stok</th><td><span class="label label-info"><?= $produk->metode_stok; ?></span></td></tr>
                  <tr><th>Batch Tracking</th><td><?= $produk->batch_tracking ? '<span class="label label-success">Aktif</span>' : '-'; ?></td></tr>
                  <tr><th>Tracking Exp</th><td><?= $produk->tanggal_kadaluarsa ? '<span class="label label-warning">Aktif</span>' : '-'; ?></td></tr>
                  <tr><th>Status Operasional</th><td><span class="label <?= $produk->status=='aktif'?'label-success':'label-danger'; ?>"><?= ucfirst($produk->status); ?></span></td></tr>
                  <tr><th>Deskripsi</th><td><?= nl2br(_ent($produk->deskripsi ?? '-')); ?></td></tr>
               </table>
            </div>
         </div>
      </div>

      <!-- Ringkasan Stok Produk -->
      <div class="col-md-5">
         <div class="box box-success" style="border-radius:6px;">
            <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-cubes text-success"></i> Ringkasan Stok Produk</h3></div>
            <div class="box-body" style="padding:10px 15px;">
               <?php 
                  $tot_baik = 0; 
                  $tot_rusak = 0; 
                  foreach($stok_list as $s) { 
                     $tot_baik += (float)$s->qty; 
                     $tot_rusak += (float)$s->qty_rusak; 
                  } 
               ?>
               <table class="table table-striped table-hover" style="margin-bottom:10px;">
                  <thead><tr style="background:#f8fafc;"><th>Status Stok</th><th class="text-center">Stok Baik</th><th class="text-center">Stok Rusak</th></tr></thead>
                  <tbody>
                     <tr>
                        <td>
                           <?php if($tot_baik == 0): ?>
                              <span class="label label-danger">Habis</span>
                           <?php elseif($tot_baik <= $produk->stok_minimum): ?>
                              <span class="label label-warning">Menipis</span>
                           <?php else: ?>
                              <span class="label label-success">Normal</span>
                           <?php endif; ?>
                        </td>
                        <td class="text-center">
                           <?php if($tot_baik <= $produk->stok_minimum): ?>
                              <span class="text-danger"><strong><?= number_format($tot_baik, 0); ?></strong> <i class="fa fa-exclamation-triangle" title="Stok menipis!"></i></span>
                           <?php else: ?>
                              <strong><?= number_format($tot_baik, 0); ?></strong>
                           <?php endif; ?>
                        </td>
                        <td class="text-center"><?= $tot_rusak > 0 ? '<span class="text-danger">'.number_format($tot_rusak,0).'</span>' : '-'; ?></td>
                     </tr>
                  </tbody>
               </table>
               <?php is_allowed('stok_list', function() use ($produk){ ?>
               <a href="<?= site_url('administrator/stok/kartu/'.$produk->id); ?>" class="btn btn-primary btn-sm btn-block btn-flat" style="border-radius:4px;"><i class="fa fa-list-alt"></i> Lihat Kartu Stok Produk</a>
               <?php }); ?>
            </div>
         </div>
      </div>
   </div>

   <!-- Full-Width Card for Unified Price History & Audit -->
   <div class="row" style="margin-top: 10px;">
      <div class="col-md-12">
         <div class="box box-default" style="border-radius:6px; border-top: 3px solid #3c8dbc;">
            <div class="box-header with-border" style="background:#fafafa;">
               <h3 class="box-title" style="font-weight:700; color:#1e293b;"><i class="fa fa-line-chart text-primary"></i> Riwayat &amp; Audit Perubahan Harga Produk</h3>
            </div>
            <div class="box-body" style="padding: 20px;">
               <div class="row">
                  <!-- Log Audit Perubahan Harga Master -->
                  <div class="col-md-6">
                     <h4 style="font-weight:700; font-size:14px; margin-top:0; margin-bottom:12px; color:#0369a1;">
                        <i class="fa fa-history text-primary"></i> Log Audit Perubahan Harga Master
                     </h4>
                     <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                           <thead>
                              <tr style="background:#e0f2fe; color:#0369a1;">
                                 <th width="35" class="text-center">No</th>
                                 <th width="120">Waktu</th>
                                 <th>Harga Beli (Lama &rarr; Baru)</th>
                                 <th>Harga Jual (Lama &rarr; Baru)</th>
                                 <th width="80" class="text-center">User</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php 
                              $no_log = 1;
                              if (!empty($harga_logs)):
                                 foreach($harga_logs as $log): 
                                    $hb_changed = ($log->harga_beli_lama != $log->harga_beli_baru);
                                    $hj_changed = ($log->harga_jual_lama != $log->harga_jual_baru);
                                    
                                    $hb_diff = $log->harga_beli_baru - $log->harga_beli_lama;
                                    $hb_trend = $hb_diff > 0 ? '<span class="badge bg-red" style="font-size:10px; margin-left:3px;"><i class="fa fa-arrow-up"></i> Naik</span>' : ($hb_diff < 0 ? '<span class="badge bg-green" style="font-size:10px; margin-left:3px;"><i class="fa fa-arrow-down"></i> Turun</span>' : '');

                                    $hj_diff = $log->harga_jual_baru - $log->harga_jual_lama;
                                    $hj_trend = $hj_diff > 0 ? '<span class="badge bg-green" style="font-size:10px; margin-left:3px;"><i class="fa fa-arrow-up"></i> Naik</span>' : ($hj_diff < 0 ? '<span class="badge bg-red" style="font-size:10px; margin-left:3px;"><i class="fa fa-arrow-down"></i> Turun</span>' : '');
                                 ?>
                                 <tr>
                                    <td class="text-center"><?= $no_log++; ?></td>
                                    <td><small><i class="fa fa-clock-o text-muted"></i> <?= date('d/m/Y H:i', strtotime($log->created_at)); ?></small></td>
                                    <td>
                                       <?php if($hb_changed): ?>
                                          <span class="text-muted" style="text-decoration:line-through;">Rp <?= number_format($log->harga_beli_lama, 0, ',', '.'); ?></span> 
                                          <i class="fa fa-long-arrow-right text-muted" style="margin: 0 3px;"></i> 
                                          <strong class="text-danger">Rp <?= number_format($log->harga_beli_baru, 0, ',', '.'); ?></strong> <?= $hb_trend; ?>
                                       <?php else: ?>
                                          <span class="text-muted">Rp <?= number_format($log->harga_beli_baru, 0, ',', '.'); ?> <small class="text-muted">(Tidak Berubah)</small></span>
                                       <?php endif; ?>
                                    </td>
                                    <td>
                                       <?php if($hj_changed): ?>
                                          <span class="text-muted" style="text-decoration:line-through;">Rp <?= number_format($log->harga_jual_lama, 0, ',', '.'); ?></span> 
                                          <i class="fa fa-long-arrow-right text-muted" style="margin: 0 3px;"></i> 
                                          <strong class="text-success">Rp <?= number_format($log->harga_jual_baru, 0, ',', '.'); ?></strong> <?= $hj_trend; ?>
                                       <?php else: ?>
                                          <span class="text-muted">Rp <?= number_format($log->harga_jual_baru, 0, ',', '.'); ?> <small class="text-muted">(Tidak Berubah)</small></span>
                                       <?php endif; ?>
                                    </td>
                                    <td class="text-center"><span class="label label-primary"><?= _ent($log->created_by); ?></span></td>
                                 </tr>
                              <?php endforeach; else: ?>
                                 <tr><td colspan="5" class="text-center text-muted" style="padding:15px;">Belum ada catatan perubahan harga master.</td></tr>
                              <?php endif; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>

                  <!-- Riwayat Harga Beli per Supplier (PO) -->
                  <div class="col-md-6">
                     <h4 style="font-weight:700; font-size:14px; margin-top:0; margin-bottom:12px; color:#92400e;">
                        <i class="fa fa-shopping-cart text-warning"></i> Riwayat Harga Beli per Supplier (PO)
                     </h4>
                     <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                           <thead>
                              <tr style="background:#fef3c7; color:#92400e;">
                                 <th width="35" class="text-center">No</th>
                                 <th>Tanggal &amp; No PO</th>
                                 <th>Nama Supplier</th>
                                 <th class="text-right">Harga Modal PO</th>
                                 <th class="text-center">Tren</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php 
                              $no = 1;
                              $total = count($riwayat_harga);
                              foreach($riwayat_harga as $index => $r): 
                                 $mata_uang = !empty($r->mata_uang) ? $r->mata_uang : 'IDR';
                                 $is_idr = ($mata_uang == 'IDR');
                                 $rate = (!empty($r->kurs) && (float)$r->kurs > 0) ? (float)$r->kurs : 1.0;
                                 $r_idr = $is_idr ? (float)$r->harga_beli : round((float)$r->harga_beli * $rate, 2);

                                 $older = ($index + 1 < $total) ? $riwayat_harga[$index + 1] : null;
                                 $trend_icon = '<i class="fa fa-minus text-muted" title="Sama"></i>';
                                 if ($older) {
                                     $older_is_idr = (empty($older->mata_uang) || $older->mata_uang === 'IDR');
                                     $older_rate = (!empty($older->kurs) && (float)$older->kurs > 0) ? (float)$older->kurs : 1.0;
                                     $older_idr = $older_is_idr ? (float)$older->harga_beli : round((float)$older->harga_beli * $older_rate, 2);
                                     if ($r_idr > $older_idr) {
                                         $trend_icon = '<i class="fa fa-arrow-up text-danger" title="Naik"></i>';
                                     } elseif ($r_idr < $older_idr) {
                                         $trend_icon = '<i class="fa fa-arrow-down text-success" title="Turun"></i>';
                                     }
                                 }
                              ?>
                              <tr>
                                 <td class="text-center"><?= $no++; ?></td>
                                 <td>
                                    <i class="fa fa-calendar text-muted"></i> <?= date('d/m/Y', strtotime($r->tanggal)); ?>
                                    <br><span class="label label-default" style="font-size:10px;"><?= _ent($r->nomor_po); ?></span>
                                 </td>
                                 <td><strong><?= _ent($r->nama_supplier); ?></strong></td>
                                 <td class="text-right">
                                    <strong class="<?= $is_idr ? 'text-danger' : 'text-primary' ?>">
                                       <?= $mata_uang ?> <?= number_format($r->harga_beli, ($is_idr ? 0 : 2), ',', '.'); ?>
                                    </strong>
                                    <?php if (!$is_idr && $rate > 1): ?>
                                       <br><small class="text-muted">(Rp <?= number_format($r_idr, 0, ',', '.'); ?>)</small>
                                    <?php endif; ?>
                                 </td>
                                 <td class="text-center"><?= $trend_icon; ?></td>
                              </tr>
                              <?php endforeach; ?>
                              <?php if(empty($riwayat_harga)): ?>
                              <tr><td colspan="5" class="text-center text-muted" style="padding:15px;">Belum ada riwayat transaksi PO ke supplier.</td></tr>
                              <?php endif; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>


