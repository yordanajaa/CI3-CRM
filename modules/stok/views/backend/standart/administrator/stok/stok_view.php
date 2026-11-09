<?php
/**
 * View: Detail Stok Barang
 * File: stok_view.php
 */
$satuan_label = !empty($stok->singkatan) ? $stok->singkatan : 'Pcs';
$qty = (float)($stok->qty ?? 0);
$qty_rusak = (float)($stok->qty_rusak ?? 0);
$stok_min = (float)($stok->stok_minimum ?? 0);
?>
<section class="content-header">
   <h1>
      <i class="fa fa-cubes text-primary"></i> Detail Stok Barang
      <small><?= _ent($stok->nama_produk ?? ''); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/stok'); ?>"><i class="fa fa-database"></i> Stok</a></li>
      <li class="active">Detail</li>
   </ol>
</section>

<section class="content">
   <div class="row">
      <div class="col-md-8 col-md-offset-2">
         <div class="box box-primary" style="border-radius:8px; border-top: 3px solid #3b82f6; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            <div class="box-header with-border" style="padding:16px 20px;">
               <h3 class="box-title" style="font-weight:700;"><i class="fa fa-info-circle text-info"></i> Informasi Stok Produk</h3>
               <div class="box-tools pull-right">
                  <?php if (is_allowed('stok_update', false) && !empty($stok->id)): ?>
                     <a href="<?= site_url('administrator/stok/edit/' . $stok->id); ?>" class="btn btn-warning btn-xs" style="font-weight:600; margin-right:4px;">
                        <i class="fa fa-pencil"></i> Sesuaikan Stok
                     </a>
                  <?php endif; ?>
                  <button type="button" onclick="window.print()" class="btn btn-default btn-xs" style="font-weight:600; margin-right:4px;" title="Cetak Halaman Ini">
                     <i class="fa fa-print"></i> Cetak
                  </button>
                  <a href="<?= site_url('administrator/stok'); ?>" class="btn btn-default btn-xs" style="font-weight:600;">
                     <i class="fa fa-arrow-left"></i> Kembali
                  </a>
               </div>
            </div>
            <div class="box-body" style="padding:22px;">
               <div class="row">
                  <div class="col-sm-6">
                     <table class="table table-striped table-bordered">
                        <tr>
                           <th width="40%" style="background:#f8fafc;">Kode Produk</th>
                           <td><span class="label label-primary" style="font-size:11px;"><?= _ent($stok->kode_produk ?? '-'); ?></span></td>
                        </tr>
                        <tr>
                           <th style="background:#f8fafc;">Nama Produk</th>
                           <td><strong style="color:#0f172a;"><?= _ent($stok->nama_produk ?? '-'); ?></strong></td>
                        </tr>
                        <tr>
                           <th style="background:#f8fafc;">Kategori</th>
                           <td><?= _ent($stok->nama_kategori ?? '-'); ?></td>
                        </tr>
                      </table>
                  </div>

                  <div class="col-sm-6">
                     <div style="background:#f0fdf4; border:1.5px solid #86efac; border-radius:8px; padding:16px; margin-bottom:15px; text-align:center;">
                        <span style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase;">Stok Fisik Tersedia (Baik)</span>
                        <div style="font-size:32px; font-weight:900; color:#15803d; margin:4px 0;">
                           <?= number_format($qty, 0, ',', '.'); ?> <small style="font-size:16px; font-weight:700; color:#166534;"><?= _ent($satuan_label); ?></small>
                        </div>
                        <?php if ($qty == 0): ?>
                           <span class="label label-danger"><i class="fa fa-times"></i> Stok Habis</span>
                        <?php elseif ($qty <= $stok_min): ?>
                           <span class="label label-warning"><i class="fa fa-warning"></i> Stok Menipis</span>
                        <?php else: ?>
                           <span class="label label-success"><i class="fa fa-check"></i> Stok Normal</span>
                        <?php endif; ?>
                     </div>

                     <table class="table table-bordered">
                        <tr>
                           <th width="50%" style="background:#f8fafc;">Stok Rusak / Reject</th>
                           <td style="font-weight:700; color:<?= $qty_rusak > 0 ? '#dc2626' : '#64748b'; ?>;">
                              <?= number_format($qty_rusak, 0, ',', '.'); ?> <?= _ent($satuan_label); ?>
                           </td>
                        </tr>
                        <tr>
                           <th style="background:#f8fafc;">Batas Alert Min. Stok</th>
                           <td><?= number_format($stok_min, 0, ',', '.'); ?> <?= _ent($satuan_label); ?></td>
                        </tr>
                        <tr>
                           <th style="background:#f8fafc;">Terakhir Diperbarui</th>
                           <td><small class="text-muted"><i class="fa fa-clock-o"></i> <?= !empty($stok->updated_at) ? date('d/m/Y H:i', strtotime($stok->updated_at)) : '-'; ?></small></td>
                        </tr>
                     </table>
                  </div>
               </div>
            </div>
            <div class="box-footer" style="padding:15px 22px; background:#fafafa; border-radius:0 0 8px 8px;">
               <?php if (!empty($stok->produk_id)): ?>
                  <a href="<?= site_url('administrator/stok/kartu/' . $stok->produk_id); ?>" class="btn btn-primary" style="font-weight:600;">
                     <i class="fa fa-list-alt"></i> Lihat Riwayat Kartu Stok
                  </a>
               <?php endif; ?>
               <div class="pull-right">
                  <button type="button" onclick="window.print()" class="btn btn-default" style="font-weight:600; margin-right:4px;">
                     <i class="fa fa-print"></i> Cetak Detail
                  </button>
                  <a href="<?= site_url('administrator/stok'); ?>" class="btn btn-default" style="font-weight:600;">
                     <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
