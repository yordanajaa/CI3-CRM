<?php /* piutang_usaha_list.php - Ledger Piutang Usaha (AR) */ ?>
<style>
.kpi-card { 
   background:#fff; 
   border-radius:8px; 
   padding:15px; 
   margin-bottom:15px; 
   border:1px solid #e2e8f0; 
   box-shadow:0 1px 3px rgba(0,0,0,0.05); 
   position:relative; 
   cursor: pointer;
   transition: all 0.2s ease;
   user-select: none;
}
.kpi-card:hover {
   transform: translateY(-3px);
   box-shadow: 0 6px 18px rgba(0,0,0,0.1);
}
.kpi-card:active {
   transform: translateY(-1px);
}
.kpi-card.active-kpi {
   background: #eff6ff;
   box-shadow: 0 0 0 2px #3b82f6, 0 6px 18px rgba(59, 130, 246, 0.2);
}
.kpi-card.green.active-kpi {
   background: #f0fdf4;
   box-shadow: 0 0 0 2px #10b981, 0 6px 18px rgba(16, 185, 129, 0.2);
}
.kpi-card.yellow.active-kpi {
   background: #fffbeb;
   box-shadow: 0 0 0 2px #f59e0b, 0 6px 18px rgba(245, 158, 11, 0.2);
}
.kpi-card.red.active-kpi {
   background: #fef2f2;
   box-shadow: 0 0 0 2px #ef4444, 0 6px 18px rgba(239, 68, 68, 0.2);
}
.kpi-title { font-size:11px; text-transform:uppercase; color:#64748b; font-weight:600; display:flex; justify-content:space-between; align-items:center; }
.kpi-value { font-size:20px; font-weight:700; color:#1e293b; margin:4px 0; }
.kpi-sub { font-size:11px; color:#94a3b8; }
.kpi-icon { position:absolute; right:15px; top:18px; font-size:28px; opacity:0.15; }
</style>

<section class="content-header">
   <h1>Piutang Usaha (Accounts Receivable) <small>Monitoring &amp; Pelunasan Tagihan Penjualan Pelanggan</small></h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li>Keuangan</li>
      <li class="active">Piutang Usaha (AR)</li>
   </ol>
</section>

<section class="content">
   <?php $current_status = $this->input->get('status'); ?>

   <!-- KPI Metric Summary -->
   <div class="row">
      <div class="col-md-3 col-sm-6">
         <div class="kpi-card <?= empty($current_status) ? '' : ''; ?>" 
              style="border-left: 4px solid #3b82f6;"
              onclick="window.location.href='<?= site_url('administrator/piutang_usaha'); ?>';"
              role="button" tabindex="0" title="Klik untuk menampilkan SEMUA faktur piutang usaha">
            <div class="kpi-title">
               <span>TOTAL HAK PIUTANG</span>
               <?php if (empty($current_status)): ?>
                  <span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:9px;">SEMUA</span>
               <?php endif; ?>
            </div>
            <div class="kpi-value">Rp <?= number_format($stats['total_hak'] ?? 0, 0, ',', '.'); ?></div>
            <div class="kpi-sub"><i class="fa fa-file-text-o"></i> <?= number_format($stats['total_faktur'] ?? 0); ?> Total Faktur Penjualan</div>
            <i class="fa fa-calculator kpi-icon text-primary"></i>
         </div>
      </div>
      <div class="col-md-3 col-sm-6">
         <div class="kpi-card green <?= $current_status == 'lunas' ? 'active-kpi' : ''; ?>" 
              style="border-left: 4px solid #10b981;"
              onclick="window.location.href='<?= $current_status == 'lunas' ? site_url('administrator/piutang_usaha') : site_url('administrator/piutang_usaha?status=lunas'); ?>';"
              role="button" tabindex="0" title="Klik untuk filter tagihan yang TELAH LUNAS">
            <div class="kpi-title">
               <span>TOTAL TELAH DITERIMA</span>
               <?php if ($current_status == 'lunas'): ?>
                  <span class="badge" style="background:#10b981; color:#fff; font-size:9px;">AKTIF</span>
               <?php endif; ?>
            </div>
            <div class="kpi-value">Rp <?= number_format($stats['total_terima'] ?? 0, 0, ',', '.'); ?></div>
            <div class="kpi-sub"><i class="fa fa-check-circle"></i> Kas Masuk Terealisasi</div>
            <i class="fa fa-money kpi-icon text-success"></i>
         </div>
      </div>
      <div class="col-md-3 col-sm-6">
         <div class="kpi-card yellow <?= $current_status == 'belum_lunas' ? 'active-kpi' : ''; ?>" 
              style="border-left: 4px solid #f59e0b;"
              onclick="window.location.href='<?= $current_status == 'belum_lunas' ? site_url('administrator/piutang_usaha') : site_url('administrator/piutang_usaha?status=belum_lunas'); ?>';"
              role="button" tabindex="0" title="Klik untuk filter tagihan yang BELUM LUNAS">
            <div class="kpi-title">
               <span>SISA TAGIHAN BELUM LUNAS</span>
               <?php if ($current_status == 'belum_lunas'): ?>
                  <span class="badge" style="background:#f59e0b; color:#fff; font-size:9px;">AKTIF</span>
               <?php endif; ?>
            </div>
            <div class="kpi-value">Rp <?= number_format($stats['sisa_piutang'] ?? 0, 0, ',', '.'); ?></div>
            <div class="kpi-sub"><i class="fa fa-clock-o"></i> Saldo Piutang Aktif</div>
            <i class="fa fa-hourglass-half kpi-icon text-warning"></i>
         </div>
      </div>
      <div class="col-md-3 col-sm-6">
         <div class="kpi-card red <?= $current_status == 'overdue' ? 'active-kpi' : ''; ?>" 
              style="border-left: 4px solid #ef4444;"
              onclick="window.location.href='<?= $current_status == 'overdue' ? site_url('administrator/piutang_usaha') : site_url('administrator/piutang_usaha?status=overdue'); ?>';"
              role="button" tabindex="0" title="Klik untuk filter tagihan yang LEWAT JATUH TEMPO (Overdue)">
            <div class="kpi-title">
               <span>LEWAT JATUH TEMPO (OVERDUE)</span>
               <?php if ($current_status == 'overdue'): ?>
                  <span class="badge" style="background:#ef4444; color:#fff; font-size:9px;">AKTIF</span>
               <?php endif; ?>
            </div>
            <div class="kpi-value">Rp <?= number_format($stats['overdue_nominal'] ?? 0, 0, ',', '.'); ?></div>
            <div class="kpi-sub" style="color:#ef4444;"><i class="fa fa-warning"></i> <?= number_format($stats['overdue_count'] ?? 0); ?> Tagihan Mendesak Ditagih</div>
            <i class="fa fa-bell kpi-icon text-danger"></i>
         </div>
      </div>
   </div>

   <?php if (!empty($current_status)): 
      $p_titles = [
         'lunas'       => ['title' => 'Piutang Telah Diterima (Lunas)', 'color' => '#10b981'],
         'belum_lunas' => ['title' => 'Sisa Tagihan Belum Lunas (Saldo Piutang Aktif)', 'color' => '#f59e0b'],
         'overdue'     => ['title' => 'Tagihan Lewat Jatuh Tempo (Overdue)', 'color' => '#ef4444'],
      ];
      $p_info = $p_titles[$current_status] ?? ['title' => 'Status: ' . strtoupper($current_status), 'color' => '#3b82f6'];
   ?>
   <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:4px solid <?= $p_info['color']; ?>; border-radius:8px; padding:10px 16px; margin-bottom:15px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
      <div>
         <span style="font-weight:700; color:#1e293b;"><i class="fa fa-filter"></i> Filter Aktif: <?= $p_info['title']; ?></span>
         <span class="badge" style="background:<?= $p_info['color']; ?>; margin-left:6px;"><?= number_format($piutang_counts); ?> Faktur</span>
      </div>
      <a href="<?= site_url('administrator/piutang_usaha'); ?>" class="btn btn-default btn-xs" style="font-weight:600;"><i class="fa fa-times text-danger"></i> Tampilkan Semua Piutang</a>
   </div>
   <?php endif; ?>

   <div class="box box-primary" style="border-radius:6px;">
      <div class="box-header with-border">
         <h3 class="box-title"><i class="fa fa-book text-primary"></i> Buku Besar Piutang Usaha &amp; Status Pelunasan</h3>
         <div class="box-tools pull-right">
            <?php 
            $export_qs = !empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : '';
            if (is_allowed('piutang_usaha_export', false)): ?>
               <a href="<?= site_url('administrator/piutang_usaha/export' . $export_qs); ?>" class="btn btn-primary btn-sm btn-flat" style="border-radius:4px; font-weight:600; margin-right:4px;">
                  <i class="fa fa-file-excel-o"></i> Export XLS
               </a>
               <a href="<?= site_url('administrator/piutang_usaha/export_pdf' . $export_qs); ?>" target="_blank" class="btn btn-info btn-sm btn-flat" style="border-radius:4px; font-weight:600; margin-right:4px;">
                  <i class="fa fa-file-pdf-o"></i> Export PDF
               </a>
            <?php endif; ?>
            <a href="<?= site_url('administrator/piutang_usaha/kas_masuk'); ?>" class="btn btn-default btn-sm btn-flat" style="border-radius:4px; font-weight:600;"><i class="fa fa-history"></i> Riwayat Kas Masuk (BKM)</a>
         </div>
      </div>
      <div class="box-body">
         <!-- Filter Bar -->
         <form method="GET" action="<?= base_url('administrator/piutang_usaha'); ?>">
            <div class="row" style="margin-bottom:15px;">
               <div class="col-md-3">
                  <select name="pelanggan_id" class="form-control chosen">
                     <option value="">-- Semua Pelanggan --</option>
                     <?php foreach($pelanggans as $p): ?>
                        <option value="<?= $p->id; ?>" <?= $this->input->get('pelanggan_id')==$p->id?'selected':''; ?>><?= _ent($p->nama_pelanggan); ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <div class="col-md-3">
                  <select name="status" class="form-control">
                     <option value="">-- Semua Status --</option>
                     <option value="overdue" <?= $this->input->get('status')=='overdue'?'selected':''; ?> style="color:#ef4444; font-weight:bold;">⚠️ Lewat Jatuh Tempo (Overdue)</option>
                     <option value="belum_bayar" <?= $this->input->get('status')=='belum_bayar'?'selected':''; ?>>Belum Bayar (Unpaid)</option>
                     <option value="sebagian" <?= $this->input->get('status')=='sebagian'?'selected':''; ?>>Bayar Sebagian (Partial)</option>
                     <option value="lunas" <?= $this->input->get('status')=='lunas'?'selected':''; ?>>Lunas (Paid)</option>
                  </select>
               </div>
               <div class="col-md-4">
                  <input type="text" class="form-control" name="q" value="<?= _ent($this->input->get('q')); ?>" placeholder="Cari No. Piutang / Pelanggan...">
               </div>
               <div class="col-md-2">
                  <button type="submit" class="btn btn-primary btn-block btn-flat" style="border-radius:4px;"><i class="fa fa-filter"></i> Filter</button>
               </div>
            </div>
         </form>

         <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
               <thead>
                  <tr style="background:#f8fafc;">
                     <th width="40" class="text-center">No</th>
                     <th>No. Tagihan Piutang</th>
                     <th>Pelanggan</th>
                     <th>Ref Transaksi / Invoice</th>
                     <th>Tgl Faktur / Jatuh Tempo</th>
                     <th class="text-right" style="white-space: nowrap; min-width: 120px;">Total Tagihan</th>
                     <th class="text-right" style="white-space: nowrap; min-width: 110px;">Telah Diterima</th>
                     <th class="text-right" style="white-space: nowrap; min-width: 120px;">Sisa Tagihan</th>
                     <th class="text-center">Status</th>
                     <th class="text-center" style="min-width: 150px;">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $no = $this->uri->segment(4) + 1; foreach($piutang_list as $row): ?>
                  <tr>
                     <td class="text-center"><?= $no++; ?></td>
                     <td><strong class="text-primary"><?= _ent($row->nomor_piutang); ?></strong></td>
                     <td>
                        <strong><?= _ent($row->nama_pelanggan ?? 'Umum'); ?></strong>
                        <br><small class="text-muted"><i class="fa fa-tag"></i> <?= _ent($row->kode_pelanggan ?? '-'); ?></small>
                     </td>
                     <td>
                        <?php if($row->nomor_so): ?><span class="label label-default">Penjualan: <?= _ent($row->nomor_so); ?></span><br><?php endif; ?>
                        <?php if($row->nomor_invoice): ?><span class="label label-info">INV: <?= _ent($row->nomor_invoice); ?></span><?php endif; ?>
                     </td>
                     <td>
                        <?php 
                           $tgl_faktur = !empty($row->tanggal_invoice) ? $row->tanggal_invoice : $row->created_at;
                        ?>
                        <i class="fa fa-calendar text-muted"></i> <?= date('d/m/Y', strtotime($tgl_faktur)); ?>
                        <br>
                        <?php if(empty($row->tanggal_jatuh_tempo) || $row->tanggal_jatuh_tempo == '0000-00-00'): ?>
                           <small class="text-muted"><strong>JT: -</strong></small>
                        <?php else: 
                           $jt_time = strtotime($row->tanggal_jatuh_tempo);
                           $today_time = strtotime(date('Y-m-d'));
                           $diff_days = floor(($today_time - $jt_time) / 86400);
                        ?>
                           <small class="text-danger"><strong>JT: <?= date('d/m/Y', $jt_time); ?></strong></small>
                           <?php if($row->status != 'lunas'): ?>
                              <br>
                              <?php if($diff_days > 90): ?>
                                 <span class="label label-danger" style="font-size:10px; padding:2px 5px; background:#991b1b;" title="Piutang macet lebih dari 90 hari"><i class="fa fa-exclamation-triangle"></i> Macet (&gt;90 hr)</span>
                              <?php elseif($diff_days > 60): ?>
                                 <span class="label label-danger" style="font-size:10px; padding:2px 5px; background:#dc2626;"><i class="fa fa-clock-o"></i> Lewat 61-90 hr</span>
                              <?php elseif($diff_days > 30): ?>
                                 <span class="label label-warning" style="font-size:10px; padding:2px 5px; background:#ea580c;"><i class="fa fa-clock-o"></i> Lewat 31-60 hr</span>
                              <?php elseif($diff_days > 0): ?>
                                 <span class="label label-warning" style="font-size:10px; padding:2px 5px; background:#f59e0b;"><i class="fa fa-clock-o"></i> Lewat <?= $diff_days; ?> hr</span>
                              <?php elseif($diff_days == 0): ?>
                                 <span class="label label-danger" style="font-size:10px; padding:2px 5px; background:#e11d48;"><i class="fa fa-bell"></i> Hari Ini!</span>
                              <?php else: ?>
                                 <span class="label label-success" style="font-size:10px; padding:2px 5px; background:#10b981;"><i class="fa fa-check"></i> Lancar</span>
                              <?php endif; ?>
                           <?php endif; ?>
                        <?php endif; ?>
                     </td>
                     <td class="text-right" style="white-space: nowrap;">Rp <?= number_format($row->total, 0, ',', '.'); ?></td>
                     <td class="text-right text-success" style="white-space: nowrap;">Rp <?= number_format($row->terbayar, 0, ',', '.'); ?></td>
                     <td class="text-right text-danger" style="white-space: nowrap;"><strong>Rp <?= number_format($row->sisa, 0, ',', '.'); ?></strong></td>
                     <td class="text-center">
                        <?php 
                           if($row->status == 'lunas'){
                              echo '<span class="label label-success">LUNAS (PAID)</span>';
                           } else if($row->status == 'sebagian'){
                              echo '<span class="label label-warning">SEBAGIAN</span>';
                           } else {
                              echo '<span class="label label-danger">BELUM BAYAR (UNPAID)</span>';
                           }
                        ?>
                     </td>
                     <td class="text-center" style="white-space: nowrap;">
                        <?php if($row->sisa > 0): ?>
                           <button type="button" class="btn btn-success btn-xs btn-flat btn-bayar" data-id="<?= $row->id; ?>" data-nomor="<?= _ent($row->nomor_piutang); ?>" data-pelanggan="<?= _ent($row->nama_pelanggan); ?>" data-sisa="<?= $row->sisa; ?>" style="border-radius:3px;">
                              <i class="fa fa-money"></i> Terima Kas
                           </button>
                           <?php 
                              $cust_phone = !empty($row->no_telp) ? $row->no_telp : (!empty($row->telepon) ? $row->telepon : ($row->so_telepon ?? ''));
                              $clean_phone = preg_replace('/[^0-9]/', '', $cust_phone);
                              if(!empty($clean_phone)):
                                 if(substr($clean_phone, 0, 1) === '0'){
                                    $clean_phone = '62' . substr($clean_phone, 1);
                                 }
                                 $msg = "Halo Bapak/Ibu " . ($row->nama_pelanggan ?? 'Pelanggan') . ", kami dari Keuangan menginformasikan tagihan Piutang No. " . $row->nomor_piutang . " (Invoice: " . ($row->nomor_invoice ?: '-') . ") dengan sisa tagihan sebesar Rp " . number_format($row->sisa, 0, ',', '.') . " yang jatuh tempo pada " . (!empty($row->tanggal_jatuh_tempo) ? date('d/m/Y', strtotime($row->tanggal_jatuh_tempo)) : '-') . ". Mohon kesediaannya untuk konfirmasi jika pembayaran telah dilakukan. Terima kasih 🙏";
                                 $wa_url = "https://api.whatsapp.com/send?phone=" . $clean_phone . "&text=" . urlencode($msg);
                           ?>
                              <a href="<?= $wa_url; ?>" target="_blank" class="btn btn-info btn-xs btn-flat" style="border-radius:3px; margin-left:3px; background:#25d366; border-color:#25d366;" title="Kirim Pengingat Tagihan via WhatsApp">
                                 <i class="fa fa-whatsapp"></i> WA Tagih
                              </a>
                           <?php endif; ?>
                        <?php else: ?>
                           <span class="text-muted"><i class="fa fa-check-circle text-success"></i> Selesai</span>
                        <?php endif; ?>
                     </td>
                  </tr>
                  <?php endforeach; ?>
                  <?php if(empty($piutang_list)): ?><tr><td colspan="10" class="text-center text-muted">Belum ada data piutang usaha.</td></tr><?php endif; ?>
               </tbody>
            </table>
         </div>

         <div class="row">
            <div class="col-md-6"><p class="text-muted">Total Data: <strong><?= number_format($piutang_counts); ?></strong> Record</p></div>
            <div class="col-md-6 text-right"><?= $pagination; ?></div>
         </div>
      </div>
   </div>
</section>

<!-- Modal Penerimaan Kas Masuk (BKM) -->
<div class="modal fade" id="modal_bayar" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document" style="max-width: 580px; margin: 40px auto;">
      <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 45px rgba(0,0,0,0.22); overflow: hidden;">
         <div class="modal-header" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%); color: #fff; padding: 20px 24px; border: none; position: relative;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.85; font-size: 24px; position: absolute; right: 20px; top: 18px; text-shadow: none;">&times;</button>
            <h4 class="modal-title" style="font-weight: 800; font-size: 16px; margin: 0; display: flex; align-items: center; gap: 10px;">
               <i class="fa fa-money" style="color: #34d399; font-size: 20px;"></i> Form Penerimaan Kas / Pelunasan Piutang (BKM)
            </h4>
            <p style="margin: 4px 0 0 30px; font-size: 12px; color: #e0e7ff; opacity: 0.9;">Catat pelunasan pembayaran dari pelanggan ke rekening kas atau bank perusahaan</p>
         </div>
         <form id="form_terima_kas">
            <input type="hidden" name="piutang_id" id="bayar_piutang_id">
            <input type="hidden" id="bayar_nomor_piutang">
            <input type="hidden" id="bayar_pelanggan">
            <input type="hidden" id="bayar_sisa_display">

            <div class="modal-body" style="padding: 22px 24px;">
               <!-- Tagihan Summary Banner -->
               <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                  <div>
                     <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">No. Tagihan &amp; Pelanggan:</div>
                     <div style="font-size: 14.5px; font-weight: 800; color: #1e1b4b; margin-top: 3px;">
                        <span id="bayar_nomor_piutang_text">-</span>
                        <span style="color: #cbd5e1; margin: 0 4px;">&bull;</span>
                        <span id="bayar_pelanggan_text">-</span>
                     </div>
                  </div>
                  <div style="text-align: right;">
                     <div style="font-size: 11px; font-weight: 700; color: #dc2626; text-transform: uppercase; letter-spacing: 0.5px;">Sisa Tagihan:</div>
                     <div style="font-size: 18px; font-weight: 800; color: #dc2626; margin-top: 2px;">
                        Rp <span id="bayar_sisa_text">0</span>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6 col-xs-12">
                     <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 700; color: #1e1b4b; font-size: 12px; margin-bottom: 5px; display: block;">
                           <i class="fa fa-calendar" style="color: #6366f1;"></i> Tanggal Diterima <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control" name="tanggal_bayar" value="<?= date('Y-m-d'); ?>" required style="border-radius: 8px; height: 38px; border: 1px solid #cbd5e1; font-weight: 600;">
                     </div>
                  </div>
                  <div class="col-md-6 col-xs-12">
                     <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 700; color: #1e1b4b; font-size: 12px; margin-bottom: 5px; display: block;">
                           <i class="fa fa-bank" style="color: #6366f1;"></i> Akun Kas / Bank Tujuan <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="akun_kas_bank" id="akun_kas_bank" required style="border-radius: 8px; height: 38px; border: 1px solid #cbd5e1; font-weight: 600;">
                           <option value="Kas Tunai Kasir">💵 Kas Tunai Kasir / Cash</option>
                           <option value="Kas Utama Operasional">🏢 Kas Utama Operasional</option>
                           <option value="Bank BCA" selected>🏦 Bank BCA - Operasional</option>
                           <option value="Bank Mandiri">🏦 Bank Mandiri - Penerimaan</option>
                           <option value="Bank BNI">🏦 Bank BNI</option>
                           <option value="Bank BRI">🏦 Bank BRI</option>
                           <option value="Bank CIMB Niaga">🏦 Bank CIMB Niaga</option>
                           <option value="Kas E-Wallet / QRIS">📱 Kas E-Wallet / QRIS</option>
                           <option value="Lainnya">📦 Akun Lainnya</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6 col-xs-12">
                     <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 700; color: #1e1b4b; font-size: 12px; margin-bottom: 5px; display: block;">
                           <i class="fa fa-credit-card" style="color: #6366f1;"></i> Metode Pembayaran <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="metode_pembayaran" id="metode_pembayaran" style="border-radius: 8px; height: 38px; border: 1px solid #cbd5e1; font-weight: 600;">
                           <option value="tunai">💵 Tunai / Cash</option>
                           <option value="bank_transfer" selected>🏦 Bank Transfer / M-Banking</option>
                           <option value="qris">📱 QRIS / E-Wallet (GoPay, OVO, Dana)</option>
                           <option value="debit_kredit">💳 Kartu Debit / Kartu Kredit</option>
                           <option value="giro">📄 Cek / Giro</option>
                           <option value="lainnya">📦 Lainnya</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6 col-xs-12">
                     <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 700; color: #1e1b4b; font-size: 12px; margin-bottom: 5px; display: block;">
                           <i class="fa fa-file-text-o" style="color: #6366f1;"></i> No. Ref Transfer / Giro
                        </label>
                        <input type="text" class="form-control" name="nomor_referensi" placeholder="Contoh: TRX-998822 / Struk" style="border-radius: 8px; height: 38px; border: 1px solid #cbd5e1; font-size: 12.5px;">
                     </div>
                  </div>
               </div>

               <div class="form-group" style="margin-bottom: 16px;">
                  <label style="font-weight: 700; color: #1e1b4b; font-size: 12.5px; margin-bottom: 6px; display: block;">
                     <i class="fa fa-calculator" style="color: #059669;"></i> Nominal Diterima (Rp) <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                     <span class="input-group-addon" style="background: #f1f5f9; font-weight: 800; color: #334155; border-radius: 8px 0 0 8px; border: 1px solid #cbd5e1; border-right: none; font-size: 14px;">Rp</span>
                     <input type="text" class="form-control rupiah" name="nominal" id="bayar_nominal" required style="border-radius: 0 8px 8px 0; border: 1px solid #cbd5e1; height: 44px; font-size: 17px; font-weight: 800; color: #059669;">
                  </div>
               </div>

               <div class="form-group" style="margin-bottom: 0;">
                  <label style="font-weight: 700; color: #1e1b4b; font-size: 12px; margin-bottom: 5px; display: block;">
                     <i class="fa fa-pencil" style="color: #6366f1;"></i> Catatan Pelunasan
                  </label>
                  <textarea class="form-control" name="catatan" rows="2" placeholder="Keterangan tambahan..." style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 12.5px; resize: vertical;"></textarea>
               </div>
            </div>

            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 24px; border-radius: 0 0 16px 16px; display: flex; justify-content: flex-end; gap: 10px;">
               <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 18px; border: 1px solid #cbd5e1;">Batal</button>
               <button type="submit" id="btn_save_bayar" class="btn" style="background: linear-gradient(135deg, #059669, #10b981); color: #fff; border-radius: 8px; font-weight: 700; padding: 8px 24px; border: none; box-shadow: 0 4px 12px rgba(16,185,129,0.35);"><i class="fa fa-check-circle"></i> Simpan Kas Masuk (BKM)</button>
            </div>
         </form>
      </div>
   </div>
</div>

<script>
$(document).ready(function(){
   $('#metode_pembayaran').on('change', function(){
      var m = $(this).val();
      if (m === 'tunai') {
         $('#akun_kas_bank').val('Kas Tunai Kasir');
      } else if (m === 'qris') {
         $('#akun_kas_bank').val('Kas E-Wallet / QRIS');
      } else if (m === 'bank_transfer') {
         if ($('#akun_kas_bank').val().indexOf('Bank') === -1) {
            $('#akun_kas_bank').val('Bank BCA');
         }
      }
   });
   $(document).on('keyup input', '.rupiah', function(){
      var val = $(this).val().replace(/[^0-9]/g, '');
      if (val !== '') {
         $(this).val(parseInt(val, 10).toLocaleString('id-ID'));
      } else {
         $(this).val('');
      }
   });

   $('.btn-bayar').click(function(){
      var id = $(this).data('id');
      var nomor = $(this).data('nomor');
      var pelanggan = $(this).data('pelanggan');
      var sisa = parseFloat($(this).data('sisa')) || 0;
      var clean_sisa = Math.round(sisa);

      $('#bayar_piutang_id').val(id);
      $('#bayar_nomor_piutang').val(nomor);
      $('#bayar_pelanggan').val(pelanggan);
      $('#bayar_nomor_piutang_text').text(nomor);
      $('#bayar_pelanggan_text').text(pelanggan);
      $('#bayar_sisa_text').text(clean_sisa.toLocaleString('id-ID'));
      $('#bayar_sisa_display').val(clean_sisa.toLocaleString('id-ID'));
      $('#bayar_nominal').val(clean_sisa.toLocaleString('id-ID'));
      $('#modal_bayar').modal('show');
   });

   $('#form_terima_kas').submit(function(e){
      e.preventDefault();
      var btn = $('#btn_save_bayar');
      btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
      $.ajax({
         url: '<?= site_url("administrator/piutang_usaha/bayar_save"); ?>',
         method: 'POST',
         data: $(this).serialize(),
         dataType: 'json',
         success: function(res) {
            if (res.success) {
               window.location.href = res.redirect;
            } else {
               swal("Gagal", res.message, "error");
               btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Kas Masuk (BKM)');
            }
         },
         error: function() {
            btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Kas Masuk (BKM)');
         }
      });
   });
});
</script>
