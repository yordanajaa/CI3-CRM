<?php /* purchase_order_view.php */ 
$status_color = ['draft'=>'default','submitted'=>'info','approved'=>'primary','completed'=>'success','rejected'=>'danger','received'=>'success','partial'=>'warning','cancelled'=>'danger'];
?>
<section class="content-header">
   <h1>Detail PO <small><?= _ent($po->nomor_po); ?></small></h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/purchase_order'); ?>"><i class="fa fa-shopping-cart"></i> Purchase Order</a></li>
      <li class="active">Detail</li>
   </ol>
</section>
<section class="content">
<div class="row">
   <div class="col-md-8">
      <div class="box box-primary">
         <div class="box-header with-border">
            <h3 class="box-title"><?= _ent($po->nomor_po); ?> &nbsp;<span class="label label-<?= $status_color[$po->status]??'default'; ?>"><?= $po->status == 'completed' ? 'SELESAI (MASUK STOK)' : strtoupper($po->status); ?></span></h3>
            <div class="box-tools pull-right"> <a href="<?= site_url('administrator/purchase_order/cetak/' . $po->id); ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i> Cetak PDF</a> 
               <?php if($po->status=='draft' && is_allowed('purchase_order_update', false)): ?>
                  <a href="<?= site_url('administrator/purchase_order/complete/'.$po->id); ?>" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> Selesaikan &amp; Masuk Stok</a>
                  <a href="<?= site_url('administrator/purchase_order/edit/'.$po->id); ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
               <?php endif; ?>
               
               
                  
               <a href="<?= base_url('administrator/purchase_order'); ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
         </div>
         <div class="box-body">
             
            <div class="row">
               <div class="col-md-6">
                  <table class="table table-condensed">
                     <tr><th>Nomor PO</th><td><?= _ent($po->nomor_po); ?></td></tr>
                     <tr><th>Supplier</th><td><strong><?= _ent($po->nama_supplier); ?></strong></td></tr>
                     <tr><th>Tanggal PO</th><td><?= date('d/m/Y',strtotime($po->tanggal_po)); ?></td></tr>
                     <tr><th>Est. Terima</th><td><?= $po->tanggal_estimasi ? date('d/m/Y',strtotime($po->tanggal_estimasi)) : '-'; ?></td></tr>
                     <tr><th>Mata Uang</th><td><?= $po->mata_uang; ?> (<?= $po->kurs; ?>)</td></tr>
                     <tr><th>Dibuat Oleh</th><td><?= _ent($po->created_by); ?></td></tr>
                     <?php $linked_utg = $this->db->get_where('utang_usaha', ['po_id' => $po->id])->row(); ?>
                     <?php if($linked_utg): ?>
                     <tr><th>Tagihan Utang</th><td><a href="<?= site_url('administrator/utang_usaha?q=' . urlencode($linked_utg->nomor_utang)); ?>" class="label <?= $linked_utg->status == 'lunas' ? 'label-success' : 'label-warning'; ?>" style="font-size:12px; padding:3px 8px;"><i class="fa fa-money"></i> <?= _ent($linked_utg->nomor_utang); ?> (<?= strtoupper($linked_utg->status); ?> - Sisa Rp <?= number_format($linked_utg->sisa, 0, ',', '.'); ?>)</a></td></tr>
                     <?php endif; ?>
                  </table>
               </div>
               <div class="col-md-6">
                  <?php 
                     $curr = $po->mata_uang ?? 'IDR';
                     $rate = (float)($po->kurs ?? 1);
                     $fmt_curr = function($val) use ($curr) {
                        if ($curr === 'IDR') {
                           return 'Rp ' . number_format((float)$val, 0, ',', '.');
                        } else {
                           return $curr . ' ' . number_format((float)$val, 2, ',', '.');
                        }
                     };
                  ?>
                  <table class="table table-condensed">
                     <tr><th>Subtotal (<?= $curr; ?>)</th><td class="text-right"><?= $fmt_curr($po->subtotal); ?></td></tr>
                     <tr><th>Diskon (<?= $curr; ?>)</th><td class="text-right text-danger">- <?= $fmt_curr($po->diskon); ?></td></tr>
                     <tr><th>Pajak (<?= (float)$po->pajak_persen; ?>%)</th><td class="text-right"><?= $fmt_curr($po->pajak_nominal); ?></td></tr>
                     <tr class="active"><th><strong>TOTAL (<?= $curr; ?>)</strong></th><td class="text-right"><strong class="text-success"><?= $fmt_curr($po->total); ?></strong></td></tr>
                     <?php if($curr !== 'IDR'): ?>
                        <tr class="info" style="background:#e0f2fe;">
                           <th><strong>Estimasi Harga IDR:</strong></th>
                           <td class="text-right"><strong class="text-primary" style="font-size:14px;">Rp <?= number_format($po->total * $rate, 0, ',', '.'); ?></strong></td>
                        </tr>
                     <?php endif; ?>
                  </table>
                  <?php if($po->catatan): ?><p class="text-muted"><em><?= nl2br(_ent($po->catatan)); ?></em></p><?php endif; ?>
               </div>
            </div>
            <hr>
            <h4>Item Pesanan</h4>
            <div class="table-responsive">
               <table class="table table-striped table-sm">
                  <thead><tr><th>#</th><th>Produk</th><th class="text-center">Qty Pesan</th><th class="text-center">Qty Terima</th><th>Harga Satuan (<?= $curr; ?>)</th><th>Disc%</th><th class="text-right">Subtotal (<?= $curr; ?>)</th></tr></thead>
                  <tbody>
                     <?php foreach($items as $i => $item): ?>
                     <tr>
                        <td><?= $i+1; ?></td>
                        <td><strong><?= _ent($item->nama_produk); ?></strong><br><small class="text-muted"><?= _ent($item->kode_produk); ?></small></td>
                        <td class="text-center"><?= number_format((float)$item->qty_pesan, 0, ',', '.'); ?> <?= _ent($item->satuan); ?></td>
                        <td class="text-center <?= $item->qty_terima >= $item->qty_pesan ? 'text-success' : ''; ?>"><?= number_format((float)$item->qty_terima, 0, ',', '.'); ?></td>
                        <td><?= $fmt_curr($item->harga_satuan); ?></td>
                        <td><?= $item->diskon_persen; ?>%</td>
                        <td class="text-right"><?= $fmt_curr($item->subtotal); ?></td>
                     </tr>
                     <?php endforeach; ?>
                     <?php if(empty($items)): ?><tr><td colspan="7" class="text-center text-muted">Tidak ada item</td></tr><?php endif; ?>
                  </tbody>
               </table>
            </div>

            </div>
      </div>
   </div>
   <div class="col-md-4">
      <div class="box box-info" style="border-radius:6px;">
         <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-truck text-info"></i> Informasi Supplier</h3></div>
         <div class="box-body">
            <p><i class="fa fa-building-o text-muted"></i> <strong><?= _ent($po->nama_supplier ?? '-'); ?></strong></p>
            <p><i class="fa fa-tag text-muted"></i> Kode: <span class="label label-default"><?= _ent($po->kode_supplier ?? '-'); ?></span></p>
            <?php if(!empty($po->kontak_person)): ?><p><i class="fa fa-user text-muted"></i> PIC: <?= _ent($po->kontak_person); ?></p><?php endif; ?>
            <?php 
               $alamat_supp = trim(($po->alamat ?? '') . (!empty($po->kota) ? ', ' . $po->kota : ''));
               if (!empty($alamat_supp)):
            ?>
               <p><i class="fa fa-map-marker text-muted"></i> <?= nl2br(_ent($alamat_supp)); ?></p>
            <?php endif; ?>
            <?php 
               $telp_supp = !empty($po->no_telp) ? $po->no_telp : (!empty($po->telepon) ? $po->telepon : '');
               if (!empty($telp_supp)):
            ?>
               <p><i class="fa fa-phone text-muted"></i> <?= _ent($telp_supp); ?></p>
            <?php endif; ?>
            <?php if(!empty($po->email)): ?><p><i class="fa fa-envelope-o text-muted"></i> <?= _ent($po->email); ?></p><?php endif; ?>
         </div>
      </div>
   </div>
</div>
</section>
