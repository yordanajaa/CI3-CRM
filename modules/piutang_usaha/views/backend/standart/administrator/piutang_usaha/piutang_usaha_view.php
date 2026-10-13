<section class="content-header">
   <h1>
      Detail Piutang Usaha
      <small><?= _ent($piutang->nomor_piutang); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/piutang_usaha'); ?>">Piutang Usaha</a></li>
      <li class="active">Detail</li>
   </ol>
</section>

<style>
@media (max-width: 767px) {
   .content { padding: 8px 6px !important; }
   .table-responsive { -webkit-overflow-scrolling: touch; border: none !important; }
   .table-responsive table { min-width: 520px; }
   .box { margin-bottom: 12px; border-radius: 8px; }
   .table td, .table th { font-size: 12px; }
}
</style>

<section class="content">
   <div class="row">
      <div class="col-md-5">
         <div class="box box-primary">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-file-text-o"></i> Informasi Tagihan</h3>
               <div class="box-tools pull-right">
                  <span class="label <?= $piutang->status == 'lunas' ? 'label-success' : ($piutang->status == 'sebagian' ? 'label-warning' : 'label-danger'); ?>" style="font-size:12px;">
                     <?= strtoupper(_ent($piutang->status)); ?>
                  </span>
               </div>
            </div>
            <div class="box-body no-padding">
               <table class="table table-striped">
                  <tr>
                     <th style="width: 40%">Nomor Piutang</th>
                     <td><strong class="text-primary"><?= _ent($piutang->nomor_piutang); ?></strong></td>
                  </tr>
                  <?php if (!empty($piutang->invoice_id)): ?>
                  <tr>
                     <th>Invoice Ref</th>
                     <td>
                        <a href="<?= site_url('administrator/invoice/view/' . $piutang->invoice_id); ?>">
                           <i class="fa fa-external-link"></i> Lihat Invoice
                        </a>
                     </td>
                  </tr>
                  <?php endif; ?>
                  <tr>
                     <th>Pelanggan</th>
                     <td>
                        <strong><?= _ent($pelanggan->nama_pelanggan ?? $piutang->nama_pelanggan ?? '-'); ?></strong>
                        <?php if (!empty($pelanggan->kode_pelanggan)): ?>
                           <span class="text-muted">(<?= _ent($pelanggan->kode_pelanggan); ?>)</span>
                        <?php endif; ?>
                     </td>
                  </tr>
                  <tr>
                     <th>Tanggal Faktur</th>
                     <td><?= date('d M Y', strtotime($piutang->tanggal_faktur)); ?></td>
                  </tr>
                  <tr>
                     <th>Jatuh Tempo</th>
                     <td>
                        <?= date('d M Y', strtotime($piutang->jatuh_tempo)); ?>
                        <?php if ($piutang->status != 'lunas' && strtotime($piutang->jatuh_tempo) < time()): ?>
                           <span class="label label-danger">Lewat Jatuh Tempo</span>
                        <?php endif; ?>
                     </td>
                  </tr>
                  <tr>
                     <th>Total Piutang</th>
                     <td><strong>Rp <?= number_format($piutang->total, 0, ',', '.'); ?></strong></td>
                  </tr>
                  <tr>
                     <th>Sudah Diterima</th>
                     <td class="text-green"><strong>Rp <?= number_format($piutang->terbayar, 0, ',', '.'); ?></strong></td>
                  </tr>
                  <tr>
                     <th>Sisa Piutang</th>
                     <td>
                        <strong class="<?= $piutang->sisa > 0 ? 'text-red' : 'text-green'; ?>" style="font-size:16px;">
                           Rp <?= number_format($piutang->sisa, 0, ',', '.'); ?>
                        </strong>
                     </td>
                  </tr>
                  <?php if (!empty($piutang->keterangan)): ?>
                  <tr>
                     <th>Keterangan</th>
                     <td><?= nl2br(_ent($piutang->keterangan)); ?></td>
                  </tr>
                  <?php endif; ?>
               </table>
            </div>
            <div class="box-footer">
               <a href="<?= site_url('administrator/piutang_usaha'); ?>" class="btn btn-default">
                  <i class="fa fa-arrow-left"></i> Kembali ke Daftar
               </a>
            </div>
         </div>
      </div>

      <div class="col-md-7">
         <div class="box box-success">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-history"></i> Riwayat Pembayaran (BKM)</h3>
            </div>
            <div class="box-body table-responsive no-padding">
               <table class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>Nomor BKM</th>
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
                              <td><strong class="text-primary"><?= _ent($p->nomor_bkm); ?></strong></td>
                              <td><?= date('d M Y', strtotime($p->tanggal_bayar)); ?></td>
                              <td><span class="label label-default"><?= strtoupper(_ent($p->metode_pembayaran)); ?></span></td>
                              <td><?= _ent($p->akun_kas_bank); ?></td>
                              <td class="text-right"><strong>Rp <?= number_format($p->nominal, 0, ',', '.'); ?></strong></td>
                              <td class="text-center">
                                 <a href="<?= site_url('administrator/piutang_usaha/cetak_bkm/' . $p->id); ?>" target="_blank" class="btn btn-xs btn-primary" title="Cetak Bukti BKM">
                                    <i class="fa fa-print"></i> Cetak
                                 </a>
                              </td>
                           </tr>
                        <?php endforeach; ?>
                     <?php else: ?>
                        <tr>
                           <td colspan="6" class="text-center text-muted" style="padding:20px;">
                              Belum ada pembayaran yang diterima untuk piutang ini.
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
