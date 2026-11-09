<?php /* penjualan_marketplace_view.php */
if (!function_exists('mask_nama_penerima')) {
    function mask_nama_penerima($name) {
        if (empty($name) || $name == '-') return '-';
        $words = explode(' ', trim($name));
        $masked_words = [];
        foreach ($words as $w) {
            $len = strlen($w);
            if ($len <= 2) {
                $masked_words[] = $w;
            } else {
                $first = substr($w, 0, 1);
                $last  = substr($w, -1);
                $masked_words[] = $first . '***' . $last;
            }
        }
        return implode(' ', $masked_words);
    }
}

if (!function_exists('mask_notelp')) {
    function mask_notelp($phone) {
        $clean = preg_replace('/[^0-9]/', '', trim($phone));
        if (empty($clean) || strlen($clean) < 6) return '08**********';
        $start = substr($clean, 0, 4);
        $end   = substr($clean, -2);
        return $start . '****' . $end;
    }
}

$status_color = [
    'draft'      => 'default',
    'packing'    => 'warning',
    'shipped'    => 'info',
    'delivered'  => 'success',
    'cancelled'  => 'danger'
];

$source_name = strtolower($so->source ?? 'shopee');
$badge_bg = ($source_name == 'tokopedia') ? '#03ac0e' : (($source_name == 'shopee') ? '#ee4d2d' : '#3c8dbc');
$source_title = strtoupper($so->source ?? 'SHOPEE');

$st_display = !empty($so->status_pesanan) ? strtoupper($so->status_pesanan) : strtoupper($so->status);
?>

<style>
/* Base View Page Responsive Styles */
.pm-view-box {
   border-radius: 12px;
   box-shadow: 0 4px 20px rgba(0,0,0,0.05);
   border: 1px solid #e2e8f0;
   background: #ffffff;
   overflow: hidden;
}
.pm-view-header {
   padding: 16px 20px;
   background: #ffffff;
   border-bottom: 1px solid #e2e8f0;
   display: flex;
   justify-content: space-between;
   align-items: center;
   flex-wrap: wrap;
   gap: 12px;
}
.pm-view-title-wrap {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
   flex: 1;
   min-width: 0;
}
.pm-view-title {
   font-weight: 700;
   font-size: 17px;
   color: #1e293b;
   margin: 0;
   line-height: 1.4;
   word-break: break-word;
}
.pm-view-order-badge {
   font-family: monospace;
   color: #0f172a;
   background: #f1f5f9;
   border: 1px solid #cbd5e1;
   padding: 2px 7px;
   border-radius: 4px;
   font-size: 13px;
   font-weight: 700;
   word-break: break-all;
}
.pm-view-tools {
   display: flex;
   align-items: center;
   gap: 6px;
   flex-wrap: wrap;
}
.pm-view-body {
   padding: 20px;
   background: #f8fafc;
}
.pm-product-table-wrap {
   width: 100%;
   overflow-x: auto;
   -webkit-overflow-scrolling: touch;
   border: 1px solid #e2e8f0;
   border-radius: 10px;
   background: #ffffff;
   margin-bottom: 20px;
}
.pm-product-table {
   width: 100%;
   min-width: 540px;
   font-size: 12.5px;
   margin-bottom: 0;
}

@media (max-width: 767px) {
   body, .content-wrapper, .content {
      overflow-x: hidden !important;
      max-width: 100vw !important;
   }
   .content-header {
      padding: 12px 14px 4px !important;
   }
   .content-header h1 {
      font-size: 18px !important;
   }
   .content {
      padding: 10px 10px !important;
   }
   .pm-view-header {
      padding: 14px 14px !important;
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 12px !important;
   }
   .pm-view-title {
      font-size: 14.5px !important;
   }
   .pm-view-tools {
      flex-direction: column !important;
      width: 100% !important;
      gap: 6px !important;
   }
   .pm-view-tools .btn {
      width: 100% !important;
      text-align: center !important;
      padding: 9px 12px !important;
      font-size: 12px !important;
      font-weight: 700 !important;
      border-radius: 6px !important;
   }
   .pm-view-body {
      padding: 14px 10px !important;
   }
   .row {
      margin-left: -5px !important;
      margin-right: -5px !important;
   }
   .col-md-4 {
      padding-left: 5px !important;
      padding-right: 5px !important;
      width: 100% !important;
      margin-bottom: 12px !important;
   }
   .panel {
      height: auto !important;
      border-radius: 10px !important;
      margin-bottom: 12px !important;
   }
   .panel-heading {
      padding: 9px 12px !important;
      font-size: 13px !important;
   }
   .panel-body {
      padding: 10px 10px !important;
   }
   .table-condensed th {
      font-size: 11.5px !important;
      width: 36% !important;
      padding: 5px 3px !important;
   }
   .table-condensed td {
      font-size: 11.5px !important;
      padding: 5px 3px !important;
      word-break: break-word !important;
   }
   .pm-product-header {
      flex-direction: column !important;
      align-items: flex-start !important;
      gap: 6px !important;
   }
   .pm-product-header .badge {
      font-size: 11px !important;
      padding: 4px 8px !important;
   }
}
</style>

<section class="content-header">
   <h1>Detail Pesanan Online Shop <small>(<?= _ent($source_title); ?>)</small></h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/penjualan_marketplace'); ?>"><i class="fa fa-shopping-bag"></i> Penjualan Online Shop</a></li>
      <li class="active">Detail Pesanan</li>
   </ol>
</section>

<section class="content">
<div class="row">
   <div class="col-md-12">
      <div class="box box-solid pm-view-box" style="border-top: 4px solid <?= $badge_bg; ?>;">
         
         <div class="pm-view-header">
            <div class="pm-view-title-wrap">
               <span class="label" style="background-color:<?= $badge_bg; ?>; font-size:12px; padding:5px 10px;"><i class="fa fa-shopping-cart"></i> <?= $source_title; ?></span>
               <h3 class="pm-view-title">
                  No. Pesanan: <span class="pm-view-order-badge"><?= _ent($so->no_pesanan ?: $so->nomor_so); ?></span>
               </h3>
               <span class="label label-<?= $status_color[$so->status]??'primary'; ?>" style="font-size:11px; padding:5px 9px;"><?= _ent($st_display); ?></span>
            </div>
            <div class="pm-view-tools">
               <a href="<?= site_url('administrator/penjualan_marketplace/cetak_resi/' . $so->id); ?>" target="_blank" class="btn btn-info btn-sm btn-flat" style="border-radius:4px;"><i class="fa fa-print"></i> Cetak Label Resi Thermal AWB</a> 
               <a href="<?= site_url('administrator/penjualan_marketplace/edit/' . $so->id); ?>" class="btn btn-warning btn-sm btn-flat" style="border-radius:4px;"><i class="fa fa-edit"></i> Edit Pesanan</a> 
               <a href="javascript:void(0);" data-href="<?= site_url('administrator/penjualan_marketplace/delete/' . $so->id); ?>" data-nopesanan="<?= _ent($so->no_pesanan ?: ('ID-' . $so->id)); ?>" data-qty="<?= !empty($items) ? count($items) : 1; ?>" class="btn btn-danger btn-sm btn-flat remove-data" style="border-radius:4px;" title="Hapus Pesanan Ini"><i class="fa fa-trash"></i> Hapus Pesanan</a>
               <a href="<?= base_url('administrator/penjualan_marketplace'); ?>" class="btn btn-default btn-sm btn-flat" style="border-radius:4px;"><i class="fa fa-arrow-left"></i> Kembali ke Register All</a>
            </div>
         </div>

         <div class="box-body pm-view-body">
            
            <!-- Header Grid: 3 Columns tailored for E-Commerce & Thermal Label Alignment -->
            <div class="row" style="margin-bottom: 20px;">
               
               <!-- Column 1: Marketplace Buyer & Delivery Info (Penerima) -->
               <div class="col-md-4">
                  <div class="panel panel-default" style="border-radius: 8px; border:1px solid #e2e8f0; box-shadow:none;">
                     <div class="panel-heading" style="background:#f8fafc; font-weight:700; color:#1e293b; border-bottom:1px solid #e2e8f0; padding:10px 14px;">
                        <i class="fa fa-user-circle text-primary"></i> Data Penerima (Customer)
                     </div>
                     <div class="panel-body" style="padding: 14px;">
                        <table class="table table-condensed table-borderless" style="margin-bottom:0; font-size:12.5px;">
                           <tr>
                              <th style="width:38%; color:#64748b;">Username:</th>
                              <td>
                                 <?php $clean_u = clean_customer_username($so->username_pembeli ?? '', $so->nama_penerima ?? ''); ?>
                                 <?php if (!empty($clean_u)): ?>
                                    <strong style="color:#0284c7; font-size:13px;"><i class="fa fa-at"></i> <?= _ent($clean_u); ?></strong>
                                 <?php else: ?>
                                    <span class="text-muted">-</span>
                                 <?php endif; ?>
                              </td>
                           </tr>
                           <tr>
                              <th style="color:#64748b;">Nama Penerima:</th>
                              <td>
                                 <?php 
                                 $raw_p = !empty($so->nama_penerima) ? $so->nama_penerima : '-';
                                 $masked_p = ($raw_p !== '-') ? mask_nama_penerima($raw_p) : '-';
                                 ?>
                                 <strong id="disp_nama_penerima" data-raw="<?= _ent($raw_p); ?>" data-masked="<?= _ent($masked_p); ?>" style="color:#0f172a; font-size:14px; font-weight:800;"><?= _ent($raw_p); ?></strong>
                                 <?php if ($raw_p !== '-' && $raw_p !== $masked_p): ?>
                                    <button type="button" id="btn_toggle_detail_eye" class="btn btn-xs btn-default" onclick="toggleDetailName();" title="Sensor / Buka Nama Lengkap" style="margin-left:6px; border-radius:4px; padding:2px 7px; font-size:11px; color:#64748b; background:#f1f5f9; border:1px solid #cbd5e1;">
                                       <i class="fa fa-eye" id="detail_eye_icon"></i>
                                    </button>
                                 <?php endif; ?>
                              </td>
                           </tr>
                           <tr>
                              <th style="color:#64748b;">No. Telp / WA:</th>
                              <td>
                                 <?php 
                                 $display_phone = clean_customer_phone(!empty($so->no_telepon) && $so->no_telepon !== '-' ? $so->no_telepon : '');
                                 $is_masked_phone = strpos((string)$display_phone, '*') !== false;
                                 ?>
                                 <?php if (!empty($display_phone)): ?>
                                    <strong id="disp_no_telepon" style="color:#16a34a;"><i class="fa fa-phone"></i> <?= _ent($display_phone); ?></strong>
                                    <?php if ($is_masked_phone): ?>
                                       <span class="label" style="background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1; font-size:10px; padding:2px 6px; border-radius:3px; margin-left:4px; font-weight:600;" title="Nomor disensor oleh marketplace untuk privasi pembeli">
                                          <i class="fa fa-shield"></i> Disensor Resi
                                       </span>
                                    <?php else: ?>
                                       <?php 
                                       $clean_wa = preg_replace('/[^0-9]/', '', (string)$display_phone);
                                       if (!empty($clean_wa) && strlen($clean_wa) >= 9):
                                          if (substr($clean_wa, 0, 1) === '0') $clean_wa = '62' . substr($clean_wa, 1);
                                          if (substr($clean_wa, 0, 2) !== '62') $clean_wa = '62' . $clean_wa;
                                       ?>
                                          <a href="https://api.whatsapp.com/send?phone=<?= $clean_wa; ?>" target="_blank" class="btn btn-xs btn-success" style="padding:1px 6px; font-size:10px; margin-left:4px; border-radius:3px;"><i class="fa fa-whatsapp"></i> WA</a>
                                       <?php endif; ?>
                                    <?php endif; ?>
                                 <?php else: ?>
                                    <span class="text-muted" style="font-size:11.5px; font-style:italic;"><i class="fa fa-minus-circle"></i> Tidak tertera di label resi</span>
                                 <?php endif; ?>
                              </td>
                           </tr>
                           <tr>
                              <th style="color:#64748b; vertical-align:top;">Alamat Kirim:</th>
                              <td>
                                 <div style="background:#f8fafc; padding:8px 10px; border-radius:6px; color:#334155; font-size:11.5px; line-height:1.45; border:1px solid #e2e8f0;">
                                    <i class="fa fa-map-marker text-danger"></i> <?= _ent($so->alamat_pengiriman ?: '-'); ?>
                                    <?php if(!empty($so->kota_kabupaten)): ?><br><strong>Kota/Kab:</strong> <?= _ent($so->kota_kabupaten); ?><?php endif; ?>
                                    <?php if(!empty($so->provinsi)): ?><br><strong>Provinsi:</strong> <?= _ent($so->provinsi); ?><?php endif; ?>
                                 </div>
                              </td>
                           </tr>
                        </table>
                     </div>
                  </div>
               </div>

               <!-- Column 2: Sender Info (Pengirim / Toko) -->
               <div class="col-md-4">
                  <div class="panel panel-default" style="border-radius: 8px; border:1px solid #e2e8f0; box-shadow:none; height:100%;">
                     <div class="panel-heading" style="background:#f8fafc; font-weight:700; color:#1e293b; border-bottom:1px solid #e2e8f0; padding:10px 14px;">
                        <i class="fa fa-paper-plane text-info"></i> Data Pengirim (Toko / Seller Resi)
                     </div>
                     <div class="panel-body" style="padding: 14px;">
                        <table class="table table-condensed table-borderless" style="margin-bottom:0; font-size:12.5px;">
                           <tr>
                              <th style="width:38%; color:#64748b;">Nama Pengirim:</th>
                              <td>
                                 <strong style="color:#0f172a; font-size:14px; font-weight:800;"><i class="fa fa-home text-muted"></i> <?= _ent($so->nama_pengirim ?: '-'); ?></strong>
                              </td>
                           </tr>
                           <tr>
                              <th style="color:#64748b;">No. Telp Pengirim:</th>
                              <td>
                                 <?php if (!empty($so->no_telepon_pengirim) && $so->no_telepon_pengirim !== '-'): ?>
                                    <strong style="color:#0284c7;"><i class="fa fa-phone"></i> <?= _ent($so->no_telepon_pengirim); ?></strong>
                                 <?php else: ?>
                                    <span class="text-muted" style="font-size:11.5px;">-</span>
                                 <?php endif; ?>
                              </td>
                           </tr>
                           <tr>
                              <th style="color:#64748b; vertical-align:top;">Asal / Lokasi:</th>
                              <td>
                                 <div style="background:#f8fafc; padding:8px 10px; border-radius:6px; color:#334155; font-size:11.5px; line-height:1.45; border:1px solid #e2e8f0;">
                                    <i class="fa fa-building-o text-info"></i> <?= _ent($so->alamat_pengirim ?: '-'); ?>
                                 </div>
                              </td>
                           </tr>
                           <?php if (!empty($so->catatan)): ?>
                           <tr>
                              <th style="color:#64748b; vertical-align:top;">Catatan:</th>
                              <td>
                                 <small class="text-muted" style="font-size:11px;"><?= _ent($so->catatan); ?></small>
                              </td>
                           </tr>
                           <?php endif; ?>
                        </table>
                     </div>
                  </div>
               </div>

               <!-- Column 3: Logistics & Payment Timeline -->
               <div class="col-md-4">
                  <div class="panel panel-default" style="border-radius: 8px; border:1px solid #e2e8f0; box-shadow:none; height:100%;">
                     <div class="panel-heading" style="background:#f8fafc; font-weight:700; color:#1e293b; border-bottom:1px solid #e2e8f0; padding:10px 14px;">
                        <i class="fa fa-truck text-success"></i> Logistik Pengiriman &amp; Pembayaran
                     </div>
                     <div class="panel-body" style="padding: 14px;">
                        <table class="table table-condensed table-borderless" style="margin-bottom:0; font-size:12.5px;">
                           <tr>
                              <th style="width:40%; color:#64748b;">Kurir / Ekspedisi:</th>
                              <td><span class="label label-primary" style="font-size:11px; padding:4px 8px;"><i class="fa fa-paper-plane"></i> <?= _ent($so->opsi_pengiriman ?: ($so->kurir_ekspedisi ?: 'Reguler')); ?></span></td>
                           </tr>
                           <tr>
                              <th style="color:#64748b;">No. Resi (AWB):</th>
                              <td><strong style="font-family:monospace; font-size:13.5px; color:#0f172a; background:#e2e8f0; padding:3px 8px; border-radius:4px;"><?= _ent((!empty($so->nomor_resi) && $so->nomor_resi !== '-' && $so->nomor_resi !== $so->no_pesanan) ? $so->nomor_resi : 'Belum Terbit'); ?></strong></td>
                           </tr>
                           <tr>
                              <th style="color:#64748b;">Waktu Bayar:</th>
                              <td><i class="fa fa-clock-o text-muted"></i> <?= !empty($so->waktu_pembayaran) ? date('d/m/Y H:i:s', strtotime($so->waktu_pembayaran)) : date('d/m/Y H:i:s', strtotime($so->tanggal_so)); ?></td>
                           </tr>
                           <tr>
                              <th style="color:#64748b;">Deadline Kirim:</th>
                              <td><strong class="text-warning"><i class="fa fa-hourglass-half"></i> <?= !empty($so->pesanan_harus_dikirim_sebelum) ? date('d/m/Y H:i', strtotime($so->pesanan_harus_dikirim_sebelum)) : date('d/m/Y', strtotime("+1 day", strtotime($so->tanggal_so))); ?></strong></td>
                           </tr>
                           <tr>
                              <th style="color:#64748b;">Tipe Pembayaran:</th>
                              <td>
                                 <?php 
                                 $is_cod = (strtolower($so->tipe_pengiriman ?? '') === 'cod' || (!empty($so->total) && (float)$so->total > 0 && stripos($so->catatan ?? '', 'COD') !== false));
                                 $cod_amount = 0;
                                 if (!empty($so->total) && (float)$so->total > 0) {
                                     $cod_amount = (float)$so->total;
                                 } elseif (!empty($so->subtotal) && (float)$so->subtotal > 0) {
                                     $cod_amount = (float)$so->subtotal;
                                 } elseif (!empty($so->total_pembayaran) && (float)$so->total_pembayaran > 0) {
                                     $cod_amount = (float)$so->total_pembayaran;
                                 } elseif (!empty($so->catatan) && preg_match('/COD[:\s]+(?:Rp\.?\s*)?([0-9\.,]+)/i', $so->catatan, $m_c)) {
                                     $cod_amount = (float)str_replace(['.', ','], ['', '.'], $m_c[1]);
                                 }
                                 ?>
                                 <?php if ($is_cod): ?>
                                    <span class="label label-danger" style="font-size:11px; padding:4px 8px; font-weight:bold;"><i class="fa fa-money"></i> COD (Bayar di Tempat)</span>
                                    <?php if ($cod_amount > 0): ?>
                                       <div style="margin-top:6px; font-size:13.5px; font-weight:800; color:#dc2626; letter-spacing:0.3px;">
                                          <i class="fa fa-tag" style="font-size:11px;"></i> Rp <?= number_format($cod_amount, 0, ',', '.'); ?>
                                       </div>
                                    <?php endif; ?>
                                 <?php else: ?>
                                    <span class="label label-default" style="font-size:11px; padding:4px 8px; font-weight:600;"><i class="fa fa-credit-card"></i> Non-COD (Cashless)</span>
                                 <?php endif; ?>
                              </td>
                           </tr>

                        </table>
                     </div>
                  </div>
               </div>

            </div>

            <!-- Rincian Produk Sesuai Resi -->
            <div class="pm-product-header" style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid <?= $badge_bg; ?>; padding-bottom:8px; margin-bottom:14px;">
               <h4 style="margin:0; font-weight:700; color:#0f172a;">
                  <i class="fa fa-barcode" style="color:<?= $badge_bg; ?>;"></i> Rincian Produk Sesuai Resi
               </h4>
               <span class="badge" style="background:#f1f5f9; color:#475569; font-size:12px; font-weight:700; padding:6px 12px; border:1px solid #cbd5e1;">
                  Total: <?= count($items); ?> Item Produk
               </span>
            </div>

            <!-- Mobile Swipe Hint -->
            <div class="visible-xs text-muted" style="font-size:11.5px; margin-bottom:8px; color:#64748b; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:6px; padding:6px 10px;">
               <i class="fa fa-arrows-h text-primary"></i> Geser tabel ke samping untuk melihat rincian SKU, variasi &amp; kuantitas
            </div>

            <div class="pm-product-table-wrap">
               <table class="table table-bordered table-striped pm-product-table" style="background:#fff; font-size:13px; margin-bottom:0;">
                  <thead>
                     <tr style="background:#0f172a; color:#fff;">
                        <th style="width:5%; text-align:center;">#</th>
                        <th style="min-width:200px;">Nama Produk di Resi (Marketplace)</th>
                        <th style="min-width:110px;">Kode SKU</th>
                        <th style="min-width:90px;">Variasi</th>
                        <th style="min-width:80px; text-align:center;">Jumlah (Qty)</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                     $total_pcs = 0;
                     foreach($items as $i=>$item): 
                        $total_pcs += (float)$item->qty;
                        // Gunakan SKU hasil scan resi jika ada; jika tidak ditemukan gunakan auto generate SKU dari produk
                        $raw_sku = (!empty($item->sku) && $item->sku !== '-') 
                           ? $item->sku 
                           : (!empty($item->kode_produk) && $item->kode_produk !== '-'
                              ? $item->kode_produk
                              : (!empty($so->sku_induk) && $so->sku_induk !== '-' 
                                 ? $so->sku_induk 
                                 : (!empty($so->nomor_referensi_sku) && $so->nomor_referensi_sku !== '-' 
                                    ? $so->nomor_referensi_sku 
                                    : '-')));

                        $item_sku = !empty($raw_sku) ? $raw_sku : '-';

                        $item_var = (!empty($item->nama_variasi) && $item->nama_variasi !== '-') 
                           ? $item->nama_variasi 
                           : (!empty($so->nama_variasi) && $so->nama_variasi !== '-' 
                              ? $so->nama_variasi 
                              : '-');
                        $item_pname = $item->catatan ?: ($item->nama_produk ?: ($so->nama_produk_marketplace ?: 'Produk'));
                     ?>
                     <tr>
                        <td class="text-center" style="vertical-align:middle; font-weight:700; color:#64748b;"><?= $i+1; ?></td>
                        <td style="vertical-align:middle;">
                           <strong style="color:#0f172a; font-size:13.5px;"><?= _ent($item_pname); ?></strong>
                        </td>
                        <td style="vertical-align:middle;">
                           <?php if ($item_sku !== '-'): ?>
                              <span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:11.5px; font-weight:700; padding:4px 8px; border-radius:4px; border:1px solid #bae6fd; font-family:monospace;">
                                 <i class="fa fa-barcode"></i> <?= _ent($item_sku); ?>
                              </span>
                           <?php else: ?>
                              <span class="text-muted" style="font-size:12px;">-</span>
                           <?php endif; ?>
                        </td>
                        <td style="vertical-align:middle;">
                           <?php if ($item_var !== '-'): ?>
                              <span class="badge" style="background:#f1f5f9; color:#475569; font-size:11.5px; font-weight:600; padding:4px 8px; border-radius:4px; border:1px solid #cbd5e1;">
                                 <i class="fa fa-tag"></i> <?= _ent($item_var); ?>
                              </span>
                           <?php else: ?>
                              <span class="text-muted" style="font-size:12px;">-</span>
                           <?php endif; ?>
                        </td>
                        <td class="text-center" style="vertical-align:middle;">
                           <span class="badge" style="background:#dcfce7; color:#15803d; font-size:13px; font-weight:800; padding:5px 12px; border-radius:6px; border:1px solid #bbf7d0;">
                              <?= number_format((float)$item->qty, 0, ',', '.'); ?> <?= _ent($item->singkatan??$item->satuan??'pcs'); ?>
                           </span>
                        </td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                     <tr style="background:#f8fafc; font-weight:800; color:#0f172a;">
                        <td colspan="4" class="text-right" style="padding:12px; font-size:13px;">TOTAL KUANTITAS BARANG DI RESI:</td>
                        <td class="text-center" style="padding:12px; font-size:15px; color:#15803d; font-weight:800;">
                           <?= number_format($total_pcs, 0, ',', '.'); ?> pcs
                        </td>
                     </tr>

                  </tfoot>
               </table>
            </div>

            <!-- Catatan Pembeli Marketplace / Label Info -->
            <?php if (!empty($so->catatan)): ?>
               <div class="callout callout-info" style="border-left-width: 4px; background:#f0f9ff; border-color:#0284c7; color:#0369a1; padding: 14px 18px; border-radius:8px; margin-top:15px; margin-bottom:0;">
                  <h5 style="margin-top:0; font-weight:bold; font-size:13.5px;"><i class="fa fa-info-circle"></i> Catatan &amp; Sumber Label Pengiriman:</h5>
                  <p style="margin-bottom:0; font-size:13px; line-height:1.5;"><?= nl2br(_ent($so->catatan)); ?></p>
               </div>
            <?php endif; ?>

         </div>
      </div>
   </div>
</div>
</section>

<script>
$(document).ready(function() {
   $('.remove-data').click(function(e){
      e.preventDefault();
      var url = $(this).attr('data-href');
      var noPesanan = $(this).attr('data-nopesanan') || '';
      var qty = $(this).attr('data-qty') || '1';

      var descText = "Data pesanan ini beserta seluruh produk (" + qty + " item) di dalamnya, transaksi sinkronisasi penjualan, dan riwayat CRM akan dihapus secara menyeluruh!";
      if (noPesanan) {
         descText = "Pesanan #" + noPesanan + " ini berisi " + qty + " produk. Seluruh produk pada pesanan ini serta data transaksi sinkronisasinya akan dihapus permanen!";
      }

      swal({
         title: "Apakah Anda Yakin?",
         text: descText,
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Ya, Hapus Semua!",
         cancelButtonText: "Batal",
         closeOnConfirm: true,
         closeOnCancel: true
      },
      function(isConfirm){
         if (isConfirm) {
            document.location.href = url;            
         }
      });
   });
});

function toggleDetailName() {
   var el = $('#disp_nama_penerima');
   var icon = $('#detail_eye_icon');
   if (el.text() === el.attr('data-raw')) {
      el.text(el.attr('data-masked'));
      icon.removeClass('fa-eye').addClass('fa-eye-slash');
   } else {
      el.text(el.attr('data-raw'));
      icon.removeClass('fa-eye-slash').addClass('fa-eye');
   }
}
</script>
