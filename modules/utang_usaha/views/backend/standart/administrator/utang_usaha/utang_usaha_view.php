<section class="content-header">
   <h1>
      Detail Utang Usaha
      <small><?= _ent($utang->nomor_utang); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/utang_usaha'); ?>">Utang Usaha</a></li>
      <li class="active">Detail</li>
   </ol>
</section>

<section class="content">
   <div class="row">
      <div class="col-md-5">
         <div class="box box-primary">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-file-text-o"></i> Informasi Tagihan</h3>
               <div class="box-tools pull-right">
                  <span class="label <?= $utang->status == 'lunas' ? 'label-success' : ($utang->status == 'sebagian' ? 'label-warning' : 'label-danger'); ?>" style="font-size:12px;">
                     <?= strtoupper(_ent($utang->status)); ?>
                  </span>
               </div>
            </div>
            <div class="box-body no-padding">
               <table class="table table-striped">
                  <tr>
                     <th style="width: 40%">Nomor Utang</th>
                     <td><strong class="text-primary"><?= _ent($utang->nomor_utang); ?></strong></td>
                  </tr>
                  <tr>
                     <th>Nomor Faktur / Ref</th>
                     <td><?= _ent($utang->nomor_faktur ?: '-'); ?></td>
                  </tr>
                  <tr>
                     <th>Supplier</th>
                     <td>
                        <strong><?= _ent($supplier->nama_supplier ?? $utang->nama_supplier ?? '-'); ?></strong>
                        <?php if (!empty($supplier->kode_supplier)): ?>
                           <span class="text-muted">(<?= _ent($supplier->kode_supplier); ?>)</span>
                        <?php endif; ?>
                     </td>
                  </tr>
                  <tr>
                     <th>Tanggal Faktur</th>
                     <td><?= date('d M Y', strtotime($utang->tanggal_faktur)); ?></td>
                  </tr>
                  <tr>
                     <th>Jatuh Tempo</th>
                     <td>
                        <?= date('d M Y', strtotime($utang->jatuh_tempo)); ?>
                        <?php if ($utang->status != 'lunas' && strtotime($utang->jatuh_tempo) < time()): ?>
                           <span class="label label-danger">Lewat Jatuh Tempo</span>
                        <?php endif; ?>
                     </td>
                  </tr>
                  <tr>
                     <th>Total Tagihan</th>
                     <td><strong>Rp <?= number_format($utang->total, 0, ',', '.'); ?></strong></td>
                  </tr>
                  <tr>
                     <th>Sudah Terbayar</th>
                     <td class="text-green"><strong>Rp <?= number_format($utang->terbayar, 0, ',', '.'); ?></strong></td>
                  </tr>
                  <tr>
                     <th>Sisa Utang</th>
                     <td>
                        <strong class="<?= $utang->sisa > 0 ? 'text-red' : 'text-green'; ?>" style="font-size:16px;">
                           Rp <?= number_format($utang->sisa, 0, ',', '.'); ?>
                        </strong>
                     </td>
                  </tr>
                  <?php if (!empty($utang->keterangan)): ?>
                  <tr>
                     <th>Keterangan</th>
                     <td><?= nl2br(_ent($utang->keterangan)); ?></td>
                  </tr>
                  <?php endif; ?>
               </table>
            </div>
            <div class="box-footer">
               <a href="<?= site_url('administrator/utang_usaha'); ?>" class="btn btn-default">
                  <i class="fa fa-arrow-left"></i> Kembali ke Daftar
               </a>
            </div>
         </div>
      </div>

      <div class="col-md-7">
         <div class="box box-info">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-history"></i> Riwayat Pembayaran (BKK)</h3>
            </div>
            <div class="box-body table-responsive no-padding">
               <table class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>Nomor BKK</th>
                        <th>Tanggal Bayar</th>
                        <th>Metode</th>
                        <th>Akun Kas / Bank</th>
                        <th class="text-right">Nominal</th>
                        <th class="text-center">Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (!empty($pembayaran)): ?>
                        <?php foreach ($pembayaran as $p): ?>
                           <tr>
                              <td><strong class="text-primary"><?= _ent($p->nomor_bkk); ?></strong></td>
                              <td><?= date('d M Y', strtotime($p->tanggal_bayar)); ?></td>
                              <td><span class="label label-default"><?= strtoupper(_ent($p->metode_pembayaran)); ?></span></td>
                              <td><?= _ent($p->akun_kas_bank); ?></td>
                              <td class="text-right"><strong>Rp <?= number_format($p->nominal, 0, ',', '.'); ?></strong></td>
                              <td class="text-center">
                                 <a href="<?= site_url('administrator/utang_usaha/cetak_bkk/' . $p->id); ?>" target="_blank" class="btn btn-xs btn-primary" title="Cetak Voucher BKK">
                                    <i class="fa fa-print"></i> Cetak
                                 </a>
                              </td>
                           </tr>
                        <?php endforeach; ?>
                     <?php else: ?>
                        <tr>
                           <td colspan="6" class="text-center text-muted" style="padding:20px;">
                              Belum ada pembayaran yang dicatat untuk tagihan ini.
                           </td>
                        </tr>
                     <?php endif; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>
