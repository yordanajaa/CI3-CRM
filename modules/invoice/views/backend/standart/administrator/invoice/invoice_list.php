<?php
/**
 * View: Daftar Invoice
 * File: invoice_list.php
 */
$status_c = [
    'draft'     => 'default',
    'sent'      => 'info',
    'partial'   => 'warning',
    'paid'      => 'success',
    'overdue'   => 'danger',
    'cancelled' => 'danger'
];
$kirim_c = [
    'pending'    => 'default',
    'processing' => 'info',
    'shipped'    => 'warning',
    'delivered'  => 'success'
];
?>
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
</style>

<section class="content-header">
   <h1>
      Invoice
      <small>Daftar Invoice</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Invoice</li>
   </ol>
</section>

<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-file-text-o"></i> Data Invoice Penjualan</h3>
               <div class="box-tools pull-right">
                  <?php 
                  $export_qs = !empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : '';
                  if (is_allowed('invoice_export', false)): ?>
                     <a href="<?= site_url('administrator/invoice/export' . $export_qs); ?>" class="btn btn-primary btn-sm btn-flat" style="border-radius:4px; font-weight:600; margin-right:4px;">
                        <i class="fa fa-file-excel-o"></i> Export XLS
                     </a>
                     <a href="<?= site_url('administrator/invoice/export_pdf' . $export_qs); ?>" target="_blank" class="btn btn-info btn-sm btn-flat" style="border-radius:4px; font-weight:600; margin-right:4px;">
                        <i class="fa fa-file-pdf-o"></i> Export PDF
                     </a>
                  <?php endif; ?>
                  <?php if (is_allowed('invoice_add', false)): ?>
                     <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_select_so" style="font-weight: bold; border-radius: 4px;">
                        <i class="fa fa-plus-circle"></i> + Buat Invoice (Penjualan)
                     </button>
                  <?php endif; ?>
               </div>
            </div>

            <div class="box-body">
               <form action="<?= base_url('administrator/invoice/index'); ?>" method="GET">
                  <div class="row" style="margin-bottom: 15px;">
                     <div class="col-md-4">
                        <div class="input-group">
                           <input type="text" class="form-control" name="q" placeholder="Cari nomor invoice / pelanggan..." value="<?= $this->input->get('q'); ?>">
                           <span class="input-group-btn">
                              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                              <a href="<?= base_url('administrator/invoice'); ?>" class="btn btn-default"><i class="fa fa-undo"></i></a>
                           </span>
                        </div>
                     </div>
                     <div class="col-md-8 text-right">
                        <div class="btn-group" role="group" style="box-shadow: 0 1px 3px rgba(0,0,0,0.06); border-radius: 4px; overflow: hidden;">
                           <a href="<?= base_url('administrator/invoice'); ?>" class="btn btn-sm <?= empty($this->input->get('tipe')) ? 'btn-primary' : 'btn-default'; ?>" style="font-weight:600;">
                              <i class="fa fa-list"></i> Semua Transaksi
                           </a>
                           <a href="<?= base_url('administrator/invoice?tipe=pos'); ?>" class="btn btn-sm <?= ($this->input->get('tipe') == 'pos') ? 'btn-success' : 'btn-default'; ?>" style="font-weight:700;">
                              <i class="fa fa-bolt"></i> Kasir Cepat (POS)
                           </a>
                           <a href="<?= base_url('administrator/invoice?tipe=so'); ?>" class="btn btn-sm <?= ($this->input->get('tipe') == 'so') ? 'btn-info' : 'btn-default'; ?>" style="font-weight:700;">
                              <i class="fa fa-list-alt"></i> Transaksi Penjualan
                           </a>
                        </div>
                     </div>
                  </div>

                  <div class="table-responsive">
                     <table class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>No Invoice</th>
                              <th class="text-center" style="white-space:nowrap;">Sumber Transaksi</th>
                              <th>No. Transaksi Penjualan</th>
                              <th>Pelanggan</th>
                              <th>Tanggal Invoice</th>
                              <th>Jatuh Tempo</th>
                              <th class="text-right">Total</th>
                              <th class="text-center">Status Bayar</th>
                              <th class="text-center">Status Kirim</th>
                              <th class="text-center" width="220">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if (!empty($invoices)): ?>
                              <?php foreach ($invoices as $inv): ?>
                                 <tr>
                                    <td><strong><?= _ent($inv->nomor_invoice); ?></strong></td>
                                    <td class="text-center" style="vertical-align:middle; white-space:nowrap;">
                                       <?php 
                                       $is_pos = (!empty($inv->so_source) && $inv->so_source == 'pos') || (stripos($inv->catatan ?? '', 'POS Cepat') !== false);
                                       if ($is_pos): 
                                       ?>
                                          <span class="label" style="background:#059669; color:#fff; font-size:11px; font-weight:700; padding:4px 8px; border-radius:4px; display:inline-block; box-shadow:0 1px 3px rgba(5,150,105,0.3);">
                                             <i class="fa fa-bolt"></i> Kasir Cepat (POS)
                                          </span>
                                       <?php else: ?>
                                          <span class="label" style="background:#2563eb; color:#fff; font-size:11px; font-weight:700; padding:4px 8px; border-radius:4px; display:inline-block; box-shadow:0 1px 3px rgba(37,99,235,0.3);">
                                             <i class="fa fa-list-alt"></i> Transaksi Penjualan
                                          </span>
                                       <?php endif; ?>
                                    </td>
                                    <td><?= _ent(isset($inv->nomor_so) ? $inv->nomor_so : '-'); ?></td>
                                    <td><?= _ent($inv->nama_pelanggan); ?></td>
                                    <td><?= date('d/m/Y', strtotime($inv->tanggal_invoice)); ?></td>
                                    <td><?= $inv->tanggal_jatuh_tempo ? date('d/m/Y', strtotime($inv->tanggal_jatuh_tempo)) : '-'; ?></td>
                                    <td class="text-right">Rp <?= number_format($inv->total, 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                       <span class="label label-<?= isset($status_c[$inv->status]) ? $status_c[$inv->status] : 'default'; ?>">
                                          <?= strtoupper($inv->status); ?>
                                       </span>
                                    </td>
                                    <td class="text-center">
                                       <span class="label label-<?= isset($kirim_c[$inv->status_kirim]) ? $kirim_c[$inv->status_kirim] : 'default'; ?>">
                                          <?= strtoupper($inv->status_kirim); ?>
                                       </span>
                                    </td>
                                    <td class="text-center">
                                       <?php if (is_allowed('invoice_view', false)): ?>
                                          <a href="<?= site_url('administrator/invoice/view/' . $inv->id); ?>" class="btn btn-xs btn-info" style="margin: 2px 1px;" title="Detail">
                                             <i class="fa fa-eye"></i> Detail
                                          </a>
                                          <?php if ($inv->status != 'paid'): ?>
                                           <a href="<?= site_url('administrator/piutang_usaha?q=' . urlencode($inv->nomor_invoice)); ?>" class="btn btn-xs btn-success" style="margin: 2px 1px; font-weight:700;" title="Terima Pembayaran di Piutang Usaha"><i class="fa fa-money"></i> Bayar</a>
                                        <?php endif; ?>
                                        <?php if ($is_pos && !empty($inv->so_id)): ?>
                                           <a href="<?= site_url('administrator/sales_order/cetak_struk/' . $inv->so_id . '?template=thermal'); ?>" class="btn btn-xs btn-success" style="margin: 2px 1px; font-weight:700; background:#059669; border-color:#047857;" target="_blank" title="Cetak Struk Thermal (POS Kasir 58mm/80mm)">
                                              <i class="fa fa-print"></i> Thermal
                                           </a>
                                        <?php endif; ?>
                                        <a href="<?= site_url('administrator/invoice/print_invoice/' . $inv->id); ?>" class="btn btn-xs btn-default" style="margin: 2px 1px;" target="_blank" title="Cetak Invoice">
                                             <i class="fa fa-print"></i> Cetak
                                          </a>
                                       <?php endif; ?>

                                       <?php if ($inv->status == 'draft' && is_allowed('invoice_update', false)): ?>
                                          <a href="<?= site_url('administrator/invoice/edit/' . $inv->id); ?>" class="btn btn-xs btn-warning" style="margin: 2px 1px;" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                          <a href="<?= site_url('administrator/invoice/kirim/' . $inv->id); ?>" class="btn btn-xs btn-primary" style="margin: 2px 1px;" title="Kirim Invoice">
                                             <i class="fa fa-send"></i> Kirim
                                          </a>
                                       <?php endif; ?>

                                       <?php if (is_allowed('invoice_delete', false)): ?>
                                          <a href="javascript:void(0);" data-href="<?= site_url('administrator/invoice/delete/' . $inv->id); ?>" class="btn btn-xs btn-danger remove-data" style="margin: 2px 1px;" title="Hapus">
                                             <i class="fa fa-trash"></i> Hapus
                                          </a>
                                       <?php endif; ?>
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
                           <?php else: ?>
                              <tr>
                                 <td colspan="10" class="text-center text-muted">Belum ada data invoice.</td>
                              </tr>
                           <?php endif; ?>
                        </tbody>
                     </table>
                  </div>
               </form>

               <div class="row" style="margin-top: 15px;">
                  <div class="col-md-6">
                     <span class="text-muted">Total: <strong><?= $invoice_counts; ?></strong> record Invoice</span>
                  </div>
                  <div class="col-md-6">
                     <div class="pull-right">
                        <?= $pagination; ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- Modal Pilih Sales Order -->
<div class="modal fade" id="modal_select_so" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content" style="border-radius: 8px;">
         <div class="modal-header" style="background: #3b82f6; color: #fff; border-radius: 8px 8px 0 0;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.9;"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" style="font-weight: bold;"><i class="fa fa-shopping-bag"></i> Pilih Dokumen Transaksi Penjualan untuk Dibuatkan Invoice</h4>
         </div>
         <div class="modal-body" style="padding: 20px;">
            <?php if (!empty($sales_orders)): ?>
               <p class="text-muted" style="margin-bottom: 15px;">
                  <i class="fa fa-info-circle text-info"></i> Silakan pilih dokumen <strong>Transaksi Penjualan</strong> yang ingin diproses menjadi Invoice Penjualan:
               </p>
               <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                     <thead>
                        <tr class="active">
                           <th>No. Transaksi Penjualan</th>
                           <th>Tanggal Penjualan</th>
                           <th>Pelanggan</th>
                           <th class="text-right">Grand Total</th>
                           <th class="text-center">Status</th>
                           <th class="text-center" width="160">Aksi</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach($sales_orders as $so_item): ?>
                           <?php $so_tot = (float)($so_item->total ?? ($so_item->subtotal ?? 0)); ?>
                           <tr>
                              <td><strong><?= _ent($so_item->nomor_so); ?></strong></td>
                              <td><?= date('d/m/Y', strtotime($so_item->tanggal_so)); ?></td>
                              <td><strong><?= _ent($so_item->nama_pelanggan); ?></strong></td>
                              <td class="text-right"><strong class="text-success">Rp <?= number_format($so_tot, 0, ',', '.'); ?></strong></td>
                              <td class="text-center">
                                 <span class="label label-<?= $so_item->status == 'shipped' ? 'success' : ($so_item->status == 'confirmed' ? 'info' : 'default'); ?>">
                                    <?= strtoupper($so_item->status); ?>
                                 </span>
                              </td>
                              <td class="text-center">
                                 <a href="<?= site_url('administrator/invoice/from_so/' . $so_item->id); ?>" class="btn btn-xs btn-success btn-flat" style="border-radius: 4px; font-weight: bold; padding: 4px 10px;">
                                    <i class="fa fa-flash"></i> Buat Invoice
                                 </a>
                              </td>
                           </tr>
                        <?php endforeach; ?>
                     </tbody>
                  </table>
               </div>
            <?php else: ?>
               <div class="callout callout-warning">
                  <h4><i class="fa fa-warning"></i> Belum Ada Transaksi Penjualan!</h4>
                  <p>Belum ada data Transaksi Penjualan aktif yang tersedia di sistem. Silakan buat Transaksi Penjualan baru terlebih dahulu.</p>
               </div>
               <div class="text-center" style="margin-top: 15px;">
                  <a href="<?= site_url('administrator/sales_order/add'); ?>" class="btn btn-primary btn-flat" style="border-radius: 4px;">
                     <i class="fa fa-plus"></i> + Buat Transaksi Penjualan Baru
                  </a>
               </div>
            <?php endif; ?>
         </div>
         <div class="modal-footer" style="background: #f8fafc; border-radius: 0 0 8px 8px;">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal" style="border-radius:4px;"><i class="fa fa-times"></i> Tutup</button>
            <a href="<?= site_url('administrator/sales_order/add'); ?>" class="btn btn-primary" style="border-radius:4px; font-weight:bold;">
               <i class="fa fa-plus"></i> + Buat Transaksi Penjualan Baru
            </a>
         </div>
      </div>
   </div>
</div>

<script>
$(document).ready(function(){
   $('.remove-data').click(function(){
      var url = $(this).attr('data-href');
      swal({
         title: 'Hapus Invoice?',
         text: 'Data yang dihapus tidak dapat dikembalikan!',
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#DD6B55',
         confirmButtonText: 'Ya, Hapus!',
         cancelButtonText: 'Batal',
         closeOnConfirm: true
      }, function(ok){
         if (ok) { window.location.href = url; }
      });
   });
});
</script>
