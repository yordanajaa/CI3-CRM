<?php
/**
 * View: Kartu Stok Produk
 * File: stok_kartu.php
 */
?>
<section class="content-header">
   <h1>
      Kartu Stok
      <small><?= isset($produk->nama_produk) ? _ent($produk->nama_produk) : ''; ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/stok'); ?>"><i class="fa fa-database"></i> Stok</a></li>
      <li class="active">Kartu Stok</li>
   </ol>
</section>

<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-header with-border">
               <h3 class="box-title">
                  <i class="fa fa-list-alt"></i> Kartu Stok: 
                  <strong><?= isset($produk->nama_produk) ? _ent($produk->nama_produk) : ''; ?></strong> 
                  <span class="label label-default"><?= isset($produk->kode_produk) ? _ent($produk->kode_produk) : ''; ?></span>
               </h3>
               <div class="box-tools pull-right">
                  <button type="button" onclick="window.print();" class="btn btn-default btn-sm" style="margin-right: 5px;">
                     <i class="fa fa-print"></i> Cetak Kartu Stok
                  </button>
                  <a href="<?= site_url('administrator/stok'); ?>" class="btn btn-default btn-sm">
                     <i class="fa fa-arrow-left"></i> Kembali
                  </a>
               </div>
            </div>

            <div class="box-body">
               <!-- Filter Mutasi -->
               <form class="form-inline margin-bottom" action="<?= site_url('administrator/stok/kartu/' . (isset($produk->id) ? $produk->id : '')); ?>" method="GET" style="margin-bottom: 20px;">
                  <?php if (!empty($all_produks)): ?>
                  <div class="form-group" style="margin-right: 15px;">
                     <label style="margin-right: 5px;"><i class="fa fa-cube text-primary"></i> Pilih Produk:</label>
                     <select class="form-control input-sm chosen" onchange="if(this.value) window.location.href='<?= site_url('administrator/stok/kartu/'); ?>/' + this.value;">
                        <?php foreach ($all_produks as $p): ?>
                           <option value="<?= $p->id; ?>" <?= (isset($produk->id) && $produk->id == $p->id) ? 'selected' : ''; ?>>
                              <?= _ent($p->kode_produk . ' - ' . $p->nama_produk); ?>
                           </option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <?php endif; ?>


                  <div class="form-group">
                     <label style="margin-right: 5px;">Dari Tanggal:</label>
                     <input type="date" class="form-control input-sm" name="date_start" value="<?= $date_start; ?>">
                  </div>
                  
                  &nbsp;
                  <div class="form-group">
                     <label style="margin-right: 5px;">Sampai Tanggal:</label>
                     <input type="date" class="form-control input-sm" name="date_end" value="<?= $date_end; ?>">
                  </div>
                  
                  &nbsp;
                  <button type="submit" class="btn btn-primary btn-sm">
                     <i class="fa fa-filter"></i> Filter
                  </button>
                  <a href="<?= site_url('administrator/stok/kartu/' . (isset($produk->id) ? $produk->id : '')); ?>" class="btn btn-default btn-sm">
                     <i class="fa fa-undo"></i> Reset
                  </a>
               </form>

               <!-- Tabel Mutasi Stok -->
               <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>Tanggal & Waktu</th>
                           <th>Keterangan</th>
                           <th>Referensi</th>
                           <th>Batch No</th>
                           <th class="text-center text-success">Masuk</th>
                           <th class="text-center text-danger">Keluar</th>
                           <th class="text-center">Saldo Akhir</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (empty($kartu)): ?>
                           <tr>
                              <td colspan="7" class="text-center text-muted">
                                 <i class="fa fa-inbox"></i> Tidak ada mutasi stok untuk produk ini.
                              </td>
                           </tr>
                        <?php else: ?>
                           <?php 
                           $saldo = 0; 
                           foreach ($kartu as $k): 
                              $is_rusak = ($k->jenis == 'rusak');
                              $is_masuk = in_array($k->jenis, ['masuk', 'transfer_masuk', 'retur_penjualan', 'stok_awal']);
                              if ($is_masuk) {
                                 $saldo += $k->qty;
                              } elseif (!$is_rusak) {
                                 $saldo -= $k->qty;
                              }
                           ?>
                              <tr class="<?= $is_rusak ? 'warning' : ''; ?>">
                                 <td><i class="fa fa-clock-o text-muted"></i> <?= date('d/m/Y H:i', strtotime($k->created_at)); ?></td>
                                 <td>
                                    <strong><?= _ent($k->keterangan); ?></strong>
                                    <?php if ($is_rusak): ?>
                                       <br><span class="label label-danger" style="font-size:10px;"><i class="fa fa-warning"></i> Masuk Stok Rusak / Afkir</span>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <?php if ($is_rusak): ?>
                                       <span class="label label-danger">RETUR_RUSAK</span>
                                    <?php else: ?>
                                       <span class="label label-default"><?= strtoupper(_ent($k->referensi_type ?: $k->jenis)); ?></span>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <?php if(!empty($k->batch_no)): ?>
                                       <span class="label label-info"><i class="fa fa-tag"></i> <?= _ent($k->batch_no); ?></span>
                                    <?php else: ?>
                                       <span class="text-muted">-</span>
                                    <?php endif; ?>
                                 </td>
                                 <td class="text-center text-success">
                                    <?= $is_masuk ? '<strong>+' . number_format((float)$k->qty, 0, ',', '.') . '</strong>' : ($is_rusak ? '<span class="text-muted">(Afkir)</span>' : '-'); ?>
                                 </td>
                                 <td class="text-center text-danger">
                                    <?= (!$is_masuk && !$is_rusak) ? '<strong>-' . number_format((float)$k->qty, 0, ',', '.') . '</strong>' : ($is_rusak ? '<strong>' . number_format((float)$k->qty, 0, ',', '.') . ' (Rusak)</strong>' : '-'); ?>
                                 </td>
                                 <td class="text-center">
                                    <strong><?= number_format((float)$saldo, 0, ',', '.'); ?></strong>
                                 </td>
                               </tr>
                           <?php endforeach; ?>
                        <?php endif; ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<style>
@media print {
  .main-header, .main-sidebar, .content-header, .box-header .box-tools, form, .breadcrumb {
    display: none !important;
  }
  .content-wrapper, .content, .box {
    margin: 0 !important;
    padding: 0 !important;
    border: none !important;
    box-shadow: none !important;
  }
  .box-title {
    font-size: 18px !important;
    display: block !important;
    margin-bottom: 15px !important;
  }
  .table {
    width: 100% !important;
    border-collapse: collapse !important;
  }
  .table th, .table td {
    padding: 6px 8px !important;
    font-size: 11px !important;
  }
}
</style>
