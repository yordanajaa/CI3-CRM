<section class="content-header">
   <h1>Unit Barang (Satuan) <small>Daftar Standar Satuan Unit Produk</small></h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li>Master Data</li>
      <li class="active">Unit Barang</li>
   </ol>
</section>

<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-header with-border">
               <h3 class="box-title"><i class="fa fa-balance-scale text-primary"></i> Daftar Unit Barang (Satuan) <span class="label label-warning" style="font-size:11px;"><?= $satuan_counts; ?> Item</span></h3>
               <div class="box-tools pull-right">
                  <a class="btn btn-flat btn-success btn-sm" href="<?= site_url('administrator/satuan/add'); ?>"><i class="fa fa-plus"></i> Tambah Unit Barang</a>
                  <?php $export_qs = !empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : ''; ?>
                  <a class="btn btn-flat btn-primary btn-sm" href="<?= site_url('administrator/satuan/export' . $export_qs); ?>"><i class="fa fa-file-excel-o"></i> Export XLS</a>
                  <a class="btn btn-flat btn-info btn-sm" href="<?= site_url('administrator/satuan/export_pdf' . $export_qs); ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
               </div>
            </div>
            <div class="box-body">
               <form name="form_satuan" id="form_satuan" action="<?= base_url('administrator/satuan/index'); ?>">
                  <div class="row margin-bottom">
                     <div class="col-sm-4">
                        <div class="input-group">
                           <input type="text" class="form-control" name="q" id="filter" placeholder="Cari unit barang..." value="<?= $this->input->get('q'); ?>">
                           <span class="input-group-btn">
                              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                              <a href="<?= base_url('administrator/satuan'); ?>" class="btn btn-default"><i class="fa fa-undo"></i></a>
                           </span>
                        </div>
                     </div>
                  </div>

                  <div class="table-responsive"> 
                     <table class="table table-bordered table-striped dataTable">
                        <thead>
                           <tr>
                              <th>Kode Satuan</th>
                              <th>Nama Satuan</th>
                              <th>Keterangan</th>
                              <th>Dibuat Pada</th>
                              <th>Diperbarui</th>
                              <th width="120" class="text-center">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                        <?php foreach($satuans as $s): ?>
                           <tr>
                              <td><span class="badge bg-blue"><?= strtoupper(_ent($s->singkatan)); ?></span></td>
                              <td><strong><?= _ent($s->nama_satuan); ?></strong></td> 
                              <td><small><?= _ent($s->deskripsi ?? 'Satuan standar produk'); ?></small></td> 
                              <td><small><?= date('Y-m-d H:i', strtotime($s->created_at ?? date('Y-m-d H:i'))); ?></small></td> 
                              <td><small><?= date('Y-m-d H:i', strtotime($s->created_at ?? date('Y-m-d H:i'))); ?></small></td> 
                              <td class="text-center">
                                 <a href="javascript:void(0);" data-href="<?= site_url('administrator/satuan/delete/' . $s->id); ?>" class="btn btn-danger btn-xs remove-data" title="Hapus"><i class="fa fa-trash"></i></a>
                              </td>
                           </tr>
                        <?php endforeach; ?>
                        <?php if ($satuan_counts == 0) :?>
                           <tr><td colspan="6" class="text-center text-muted">Units Barang data is not available</td></tr>
                        <?php endif; ?>
                        </tbody>
                     </table>
                  </div>
                  <div class="row" style="margin-top:15px;">
                     <div class="col-md-6"><span class="text-muted">Total: <strong><?= $satuan_counts; ?></strong> unit</span></div>
                     <div class="col-md-6"><div class="pull-right"><?= $pagination; ?></div></div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>

<script>
$(document).ready(function(){
   $('.remove-data').click(function(){
      var url = $(this).attr('data-href');
      swal({
         title: "Hapus Unit Barang?",
         text: "Data tidak bisa dikembalikan!",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Ya, Hapus!",
         cancelButtonText: "Batal",
         closeOnConfirm: true
      }, function(ok){ if(ok) window.location.href = url; });
   });
});
</script>
