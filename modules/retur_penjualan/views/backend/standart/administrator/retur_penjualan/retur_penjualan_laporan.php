<?php
/**
 * View: Laporan Retur Penjualan per Produk (Desktop & Mobile Friendly)
 * File: retur_penjualan_laporan.php
 */
?>
<style>
.kpi-card {
   background: #fff;
   border-radius: 8px;
   padding: 16px;
   margin-bottom: 16px;
   border: 1px solid #e2e8f0;
   box-shadow: 0 2px 8px rgba(0,0,0,0.04);
   position: relative;
   overflow: hidden;
}
.kpi-title {
   font-size: 11px;
   text-transform: uppercase;
   color: #64748b;
   font-weight: 700;
   letter-spacing: 0.4px;
}
.kpi-value {
   font-size: 22px;
   font-weight: 800;
   color: #1e293b;
   margin: 4px 0;
}
.kpi-sub {
   font-size: 11px;
   color: #94a3b8;
}
.kpi-icon {
   position: absolute;
   right: 14px;
   top: 16px;
   font-size: 32px;
   opacity: 0.14;
}
.table-responsive-custom {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow-x: auto;
   -webkit-overflow-scrolling: touch;
   background: #ffffff;
}
.table-lap th {
   background: #f1f5f9;
   font-size: 11.5px;
   text-transform: uppercase;
   letter-spacing: 0.3px;
   color: #475569;
   font-weight: 700;
   white-space: nowrap;
   vertical-align: middle !important;
}
.table-lap td {
   vertical-align: middle !important;
   font-size: 12.5px;
}
.nowrap {
   white-space: nowrap !important;
}
.filter-btn-col {
   padding-top: 25px;
}

@media (max-width: 991px) {
   .filter-btn-col {
      padding-top: 4px;
      margin-bottom: 8px;
   }
}
@media (max-width: 768px) {
   .kpi-card {
      padding: 12px;
   }
   .kpi-value {
      font-size: 18px;
   }
}
</style>

<section class="content-header">
   <h1>
      Laporan Retur Penjualan per Produk 
      <small>Analisis &amp; Pola Barang Bermasalah</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= base_url('administrator/retur_penjualan'); ?>">Retur Penjualan</a></li>
      <li class="active">Laporan per Produk</li>
   </ol>
</section>

<section class="content">
   <?php
      $sum_total_qty = 0;
      $sum_baik_qty  = 0;
      $sum_rusak_qty = 0;
      $sum_nominal   = 0;

      if (!empty($laporan)) {
         foreach ($laporan as $item_lap) {
            $sum_total_qty += $item_lap->qty_retur;
            $sum_nominal   += $item_lap->subtotal;
            if ($item_lap->kondisi == 'baik') {
               $sum_baik_qty += $item_lap->qty_retur;
            } else {
               $sum_rusak_qty += $item_lap->qty_retur;
            }
         }
      }
   ?>

   <!-- KPI Metric Summary -->
   <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-6">
         <div class="kpi-card" style="border-left: 4px solid #3b82f6;">
            <div class="kpi-title">TOTAL DITERIMA RETUR</div>
            <div class="kpi-value"><?= number_format($sum_total_qty, 0, ',', '.'); ?> <small style="font-size:12px;">Unit</small></div>
            <div class="kpi-sub"><i class="fa fa-calculator"></i> Total Fisik Diterima</div>
            <i class="fa fa-refresh kpi-icon text-primary"></i>
         </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-6">
         <div class="kpi-card" style="border-left: 4px solid #ef4444;">
            <div class="kpi-title">KONDISI RUSAK / CACAT</div>
            <div class="kpi-value text-danger"><?= number_format($sum_rusak_qty, 0, ',', '.'); ?> <small style="font-size:12px;">Unit</small></div>
            <div class="kpi-sub" style="color:#ef4444;"><i class="fa fa-warning"></i> Barang Afkir (Stok Rusak)</div>
            <i class="fa fa-times-circle kpi-icon text-danger"></i>
         </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-6">
         <div class="kpi-card" style="border-left: 4px solid #10b981;">
            <div class="kpi-title">KONDISI BAIK (RESTOCK)</div>
            <div class="kpi-value text-success"><?= number_format($sum_baik_qty, 0, ',', '.'); ?> <small style="font-size:12px;">Unit</small></div>
            <div class="kpi-sub"><i class="fa fa-check-circle"></i> Masuk ke Stok Jual</div>
            <i class="fa fa-check-square-o kpi-icon text-success"></i>
         </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-6">
         <div class="kpi-card" style="border-left: 4px solid #f59e0b;">
            <div class="kpi-title">TOTAL NOMINAL RETUR</div>
            <div class="kpi-value text-warning" style="font-size:18px;">Rp <?= number_format($sum_nominal, 0, ',', '.'); ?></div>
            <div class="kpi-sub"><i class="fa fa-money"></i> Nilai Total Pengembalian</div>
            <i class="fa fa-calculator kpi-icon text-warning"></i>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary" style="border-radius:8px; border:none; box-shadow:0 2px 10px rgba(0,0,0,0.05); margin-bottom:20px;">
            <div class="box-header with-border" style="padding:14px 18px; border-bottom:1px solid #f1f5f9;">
               <h3 class="box-title" style="font-weight:700; color:#1e293b; font-size:15px;"><i class="fa fa-filter text-primary"></i> Filter Analisis Produk Bermasalah</h3>
            </div>
            <div class="box-body" style="padding:16px 18px;">
               <form action="<?= base_url('administrator/retur_penjualan/laporan'); ?>" method="GET">
                  <div class="row">
                     <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group" style="margin-bottom:10px;">
                           <label style="font-size:12px; font-weight:600; color:#475569;">Pilih Produk Specific:</label>
                           <select name="produk_id" class="form-control chosen" style="border-radius:6px; height:38px;">
                              <option value="">-- Semua Produk (Tampilkan Semua) --</option>
                              <?php foreach($produks as $p): ?>
                                 <option value="<?= $p->id; ?>" <?= ($this->input->get('produk_id') == $p->id) ? 'selected' : ''; ?>>
                                    <?= _ent($p->kode_produk . ' - ' . $p->nama_produk); ?>
                                 </option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group" style="margin-bottom:10px;">
                           <label style="font-size:12px; font-weight:600; color:#475569;">Periode Mulai:</label>
                           <input type="date" name="date_start" class="form-control" value="<?= $this->input->get('date_start'); ?>" style="border-radius:6px; height:38px;">
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group" style="margin-bottom:10px;">
                           <label style="font-size:12px; font-weight:600; color:#475569;">Periode Selesai:</label>
                           <input type="date" name="date_end" class="form-control" value="<?= $this->input->get('date_end'); ?>" style="border-radius:6px; height:38px;">
                        </div>
                     </div>
                     <div class="col-md-2 col-sm-6 col-xs-12 filter-btn-col">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" style="border-radius:6px; font-weight:700; height:38px;"><i class="fa fa-filter"></i> Analisis</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>

         <div class="box box-warning" style="border-radius:8px; border:none; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
            <div class="box-header with-border" style="padding:14px 18px; border-bottom:1px solid #f1f5f9;">
               <h3 class="box-title" style="font-weight:700; color:#1e293b; font-size:15px;"><i class="fa fa-list text-warning"></i> Rekapitulasi &amp; Pola Retur per Produk</h3>
            </div>
            <div class="box-body" style="padding:16px 18px;">
               <div class="table-responsive-custom">
                  <table class="table table-bordered table-striped table-hover table-lap">
                     <thead>
                        <tr>
                           <th width="40" class="text-center nowrap">No</th>
                           <th class="nowrap">Tanggal Retur</th>
                           <th class="nowrap">No. Retur</th>
                           <th>Pelanggan</th>
                           <th>Produk &amp; Kode</th>
                           <th class="text-center nowrap">Kondisi Fisik</th>
                           <th class="text-right nowrap">Qty Retur</th>
                           <th class="text-right nowrap">Subtotal Nilai</th>
                           <th>Alasan Retur (Pola Masalah)</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($laporan)): ?>
                           <?php $no = 1; foreach ($laporan as $row): ?>
                              <tr>
                                 <td class="text-center nowrap"><?= $no++; ?></td>
                                 <td class="nowrap"><i class="fa fa-calendar text-muted"></i> <?= date('d/m/Y', strtotime($row->tanggal_retur)); ?></td>
                                 <td class="nowrap"><strong class="text-primary"><?= _ent($row->nomor_retur); ?></strong></td>
                                 <td><strong><?= _ent($row->nama_pelanggan); ?></strong></td>
                                 <td>
                                    <strong><?= _ent($row->nama_produk); ?></strong><br>
                                    <small class="text-muted"><i class="fa fa-tag"></i> <?= _ent($row->kode_produk); ?></small>
                                 </td>
                                 <td class="text-center nowrap">
                                    <?php if ($row->kondisi == 'baik'): ?>
                                       <span class="label label-success" style="font-weight:700; padding:3px 8px; border-radius:4px;"><i class="fa fa-check-circle"></i> BAIK (RESTOCK)</span>
                                    <?php else: ?>
                                       <span class="label label-danger" style="font-weight:700; padding:3px 8px; border-radius:4px;"><i class="fa fa-times-circle"></i> RUSAK / AFKIR</span>
                                    <?php endif; ?>
                                 </td>
                                 <td class="text-right nowrap"><strong><?= number_format($row->qty_retur, 0, ',', '.'); ?> Unit</strong></td>
                                 <td class="text-right nowrap" style="font-weight:700;">Rp <?= number_format($row->subtotal, 0, ',', '.'); ?></td>
                                 <td>
                                    <?php if(!empty($row->alasan_utama)): ?>
                                       <span class="label label-default" style="font-weight:600;"><?= strtoupper(_ent($row->alasan_utama)); ?></span><br>
                                    <?php endif; ?>
                                    <small class="text-muted"><?= _ent($row->catatan_retur ?: ($row->alasan ?? '-')); ?></small>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        <?php else: ?>
                           <tr>
                              <td colspan="9" class="text-center text-muted" style="padding:30px;">
                                 <i class="fa fa-info-circle fa-2x"></i><br>Belum ada data retur produk untuk kriteria pencarian ini.
                              </td>
                           </tr>
                        <?php endif; ?>
                     </tbody>
                     <?php if (!empty($laporan)): ?>
                        <tfoot>
                           <tr style="background:#f1f5f9; font-weight:700;">
                              <th colspan="6" class="text-right nowrap">TOTAL RETUR:</th>
                              <th class="text-right nowrap"><strong class="text-danger"><?= number_format($sum_total_qty, 0, ',', '.'); ?> Unit</strong></th>
                              <th class="text-right nowrap"><strong class="text-danger">Rp <?= number_format($sum_nominal, 0, ',', '.'); ?></strong></th>
                              <th></th>
                           </tr>
                        </tfoot>
                     <?php endif; ?>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
