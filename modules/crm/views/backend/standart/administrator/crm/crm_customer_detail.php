<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
.profile-header {
  background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #312e81 100%);
  color: #fff;
  padding: 28px 32px;
  border-radius: 16px;
  margin-bottom: 22px;
  box-shadow: 0 12px 30px rgba(15, 23, 42, 0.25);
  position: relative;
  overflow: hidden;
}
.profile-header::after {
  content: '';
  position: absolute;
  top: -50%; right: -20%;
  width: 300px; height: 300px;
  background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(255,255,255,0) 70%);
  pointer-events: none;
}
.profile-header .name { font-size: 26px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 4px; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }
.profile-header .phone { font-size: 15px; color: #cbd5e1; font-weight: 500; }

.summary-card {
  background: #ffffff;
  border-radius: 14px;
  padding: 20px 16px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.04);
  border: 1px solid #f1f5f9;
  text-align: center;
  margin-bottom: 16px;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.summary-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.08);
  border-color: #cbd5e1;
}
.summary-card .num { font-size: 26px; font-weight: 800; letter-spacing: -0.5px; }
.summary-card .lbl { font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; margin-top: 4px; }
.sc-blue .num { color: #2563eb; }
.sc-green .num { color: #059669; }
.sc-orange .num { color: #ea580c; }
.sc-purple .num { color: #7c3aed; }
.sc-red .num { color: #dc2626; }

.badge-source {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  color: #fff;
  display: inline-block;
  margin: 3px 2px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.badge-toko { background: linear-gradient(135deg, #1e293b, #334155); }
.badge-shopee { background: linear-gradient(135deg, #ee4d2d, #ff6b4a); }
.badge-tokopedia { background: linear-gradient(135deg, #059669, #10b981); }
.badge-tiktok { background: linear-gradient(135deg, #09090b, #18181b); }

.badge-status {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: inline-block;
  box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}
.bs-shipped { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.bs-delivered { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.bs-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.bs-cancelled { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
.bs-completed { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.bs-processing { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
.bs-packed { background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }

.timeline-fu { position: relative; padding-left: 28px; margin: 12px 0; }
.timeline-fu::before { content: ''; position: absolute; left: 10px; top: 4px; bottom: 4px; width: 2px; background: #e2e8f0; }
.tl-item { position: relative; margin-bottom: 12px; padding: 10px 14px; background: #ffffff; border-radius: 10px; border: 1px solid #f1f5f9; border-left: 4px solid #3b82f6; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
.tl-item.tl-done { border-left-color: #10b981; }
.tl-item.tl-pending { border-left-color: #f59e0b; }
.tl-item .tl-title { font-weight: 700; font-size: 13px; color: #1e293b; }
.tl-item .tl-date { font-size: 11px; color: #64748b; }
.tl-item .tl-status { font-size: 11px; margin-top: 3px; }

.trx-row { cursor: pointer; transition: all 0.2s ease; }
.trx-row:hover { background: #f8fafc !important; }
.trx-detail-panel { display: none; background: #f8fafc; border-top: 2px solid #6366f1; border-bottom: 2px solid #cbd5e1; }
.table-crm th { background: #f1f5f9; font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: #475569; font-weight: 700; }
.table-crm td { font-size: 13px; vertical-align: middle !important; color: #334155; }

@media (max-width: 767px) {
  .profile-header { padding: 20px 16px; text-align: center; }
  .profile-header .name { font-size: 20px; }
  .profile-header .text-right { text-align: center !important; margin-top: 16px; }
  .summary-card { padding: 12px; margin-bottom: 10px; }
  .summary-card .num { font-size: 20px; }
  .summary-card .lbl { font-size: 9px; }
}
</style>

<section class="content" style="padding-top:15px;">
  <!-- Profile Header -->
  <div class="profile-header">
    <div class="row">
      <div class="col-md-1 text-center" style="padding-top: 5px;">
        <i class="fa fa-user-circle-o" style="font-size: 50px; opacity: 0.8;"></i>
      </div>
      <div class="col-md-7">
        <div class="name"><?= htmlspecialchars($summary['nama']); ?></div>
        <div class="phone"><i class="fa fa-phone"></i> <?= htmlspecialchars($summary['phone']); ?></div>
        <div style="margin-top: 8px;">
          <?php foreach ($summary['sources'] as $s):
            $cls = 'badge-toko';
            if (stripos($s, 'Shopee') !== false) $cls = 'badge-shopee';
            elseif (stripos($s, 'Tokopedia') !== false) $cls = 'badge-tokopedia';
            elseif (stripos($s, 'TikTok') !== false) $cls = 'badge-tiktok';
          ?>
          <span class="badge-source <?= $cls; ?>"><?= $s; ?></span>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="col-md-4 text-right" style="padding-top: 10px;">
        <a href="<?= site_url('administrator/crm'); ?>" class="btn btn-sm" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-arrow-left"></i> Kembali</a>
        <a href="<?= site_url('administrator/sales_order/add'); ?>" class="btn btn-sm" style="background:#f39c12;color:#fff;border:none;" title="Buat Sales Order Repeat Order"><i class="fa fa-cart-plus"></i> Repeat Order</a>
        <?php if (!empty($summary['phone'])): ?>
        <a href="https://wa.me/<?= preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $summary['phone'])); ?>" target="_blank" class="btn btn-sm" style="background:#25D366;color:#fff;border:none;"><i class="fa fa-whatsapp"></i> Chat WA</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Summary Cards (FA-04) -->
  <div class="row">
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-blue">
        <div class="num"><?= $summary['total_orders']; ?></div>
        <div class="lbl">Total Order</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-green">
        <div class="num">Rp <?= number_format($summary['total_spend'], 0, ',', '.'); ?></div>
        <div class="lbl">Total Spend</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-orange">
        <div class="num"><?= $summary['order_count_toko']; ?></div>
        <div class="lbl">Order Toko</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-purple">
        <div class="num"><?= $summary['order_count_online']; ?></div>
        <div class="lbl">Order Online</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-blue">
        <div class="num"><?= $summary['first_order'] ? date('d/m/y', strtotime($summary['first_order'])) : '-'; ?></div>
        <div class="lbl">Order Pertama</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-red">
        <div class="num"><?= $summary['last_order'] ? date('d/m/y', strtotime($summary['last_order'])) : '-'; ?></div>
        <div class="lbl">Order Terakhir</div>
      </div>
    </div>
  </div>

  <!-- Transaction History (FA-01, FA-02) -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-history"></i> Riwayat Transaksi (<?= count($transactions); ?>)</h3>
    </div>
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover table-crm" id="tbl-trx">
        <thead>
          <tr>
            <th style="width:30px">#</th>
            <th>Tanggal</th>
            <th>No. Pesanan</th>
            <th>Sumber</th>
            <th>Produk</th>
            <th class="text-right">Nominal</th>
            <th>Status</th>
            <th>Resi</th>
            <th class="text-center">Follow-Up</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($transactions)): ?>
          <tr><td colspan="9" class="text-center" style="padding:40px;color:#95a5a6;"><i class="fa fa-inbox fa-2x"></i><br>Belum ada transaksi.</td></tr>
          <?php else: $no = 1; foreach ($transactions as $t): ?>
          <tr class="trx-row" data-table="<?= $t->tbl; ?>" data-id="<?= $t->id; ?>">
            <td><?= $no++; ?></td>
            <td><?= date('d M Y', strtotime($t->tanggal)); ?></td>
            <td><strong><?= htmlspecialchars($t->no_pesanan ?: $t->nomor_so); ?></strong></td>
            <td>
              <?php
              $cls = 'badge-toko';
              if (stripos($t->sumber_penjualan, 'Shopee') !== false) $cls = 'badge-shopee';
              elseif (stripos($t->sumber_penjualan, 'Tokopedia') !== false) $cls = 'badge-tokopedia';
              elseif (stripos($t->sumber_penjualan, 'TikTok') !== false) $cls = 'badge-tiktok';
              ?>
              <span class="badge-source <?= $cls; ?>"><?= $t->sumber_penjualan; ?></span>
            </td>
            <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($t->produk_ringkasan ?: '-'); ?></td>
            <td class="text-right"><strong>Rp <?= number_format($t->total, 0, ',', '.'); ?></strong></td>
            <td>
              <?php
              $st = strtolower($t->status);
              $st_p = strtolower($t->status_pesanan ?: '');
              $stcls = 'bs-pending';
              if (in_array($st, ['shipped','dikirim']) || strpos($st_p, 'dikirim') !== false) $stcls = 'bs-shipped';
              elseif (in_array($st, ['delivered','terkirim'])) $stcls = 'bs-delivered';
              elseif (in_array($st, ['completed','selesai'])) $stcls = 'bs-completed';
              elseif (in_array($st, ['cancelled','dibatalkan'])) $stcls = 'bs-cancelled';
              elseif (in_array($st, ['packed','dikemas']) || strpos($st_p, 'packed') !== false || strpos($st_p, 'kemas') !== false) $stcls = 'bs-packed';
              elseif (in_array($st, ['processing','confirmed','packing']) || strpos($st_p, 'perlu dikirim') !== false) $stcls = 'bs-processing';
              ?>
              <span class="badge-status <?= $stcls; ?>"><?= ucfirst($t->status_pesanan ?: $t->status); ?></span>
            </td>
            <td style="font-size:11px;"><?= htmlspecialchars($t->nomor_resi ?: '-'); ?></td>
            <td class="text-center">
              <button class="btn btn-xs btn-default btn-timeline" data-table="<?= $t->tbl; ?>" data-id="<?= $t->id; ?>" title="Lihat Timeline Follow-Up">
                <i class="fa fa-clock-o"></i>
              </button>
            </td>
          </tr>
          <!-- Detail Panel (FA-03, FA-05) -->
          <tr class="trx-detail-panel" id="detail-<?= $t->tbl; ?>-<?= $t->id; ?>">
            <td colspan="9" style="padding: 15px 25px;">
              <div class="row">
                <div class="col-md-7">
                  <h5 style="font-weight:700;color:#2c3e50;"><i class="fa fa-cubes"></i> Detail Item</h5>
                  <div class="detail-items-<?= $t->tbl; ?>-<?= $t->id; ?>">
                    <p class="text-muted"><i class="fa fa-spinner fa-spin"></i> Memuat...</p>
                  </div>
                  <hr>
                  <div style="font-size:12px;color:#6c757d;">
                    <strong>Penerima:</strong> <?= htmlspecialchars($t->nama_penerima ?: '-'); ?><br>
                    <strong>Alamat:</strong> <?= htmlspecialchars($t->alamat_pengiriman ?: '-'); ?><br>
                    <strong>Ekspedisi:</strong> <?= htmlspecialchars($t->kurir_ekspedisi ?: '-'); ?>
                  </div>
                </div>
                <div class="col-md-5">
                  <h5 style="font-weight:700;color:#2c3e50;"><i class="fa fa-clock-o"></i> Timeline Follow-Up</h5>
                  <div class="timeline-fu timeline-content-<?= $t->tbl; ?>-<?= $t->id; ?>">
                    <p class="text-muted"><i class="fa fa-spinner fa-spin"></i> Memuat...</p>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  // Toggle transaction detail panel
  $('.trx-row').on('click', function() {
    var tbl = $(this).data('table');
    var id = $(this).data('id');
    var panel = $('#detail-' + tbl + '-' + id);
    
    if (panel.is(':visible')) {
      panel.slideUp(200);
      return;
    }
    
    // Close other panels
    $('.trx-detail-panel').slideUp(200);
    panel.slideDown(300);
    
    // Load detail via AJAX (FA-03)
    $.ajax({
      url: BASE_URL + 'administrator/crm/transaction_detail_ajax',
      type: 'GET',
      data: { table: tbl, order_id: id },
      dataType: 'json',
      success: function(res) {
        if (res.success) {
          // Render items
          var itemHtml = '<table class="table table-condensed table-bordered" style="font-size:12px;margin:0;">';
          itemHtml += '<thead><tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead><tbody>';
          if (res.items.length > 0) {
            $.each(res.items, function(i, item) {
              itemHtml += '<tr>';
              itemHtml += '<td>' + (item.nama_produk || item.catatan || '-') + '</td>';
              itemHtml += '<td class="text-center">' + parseFloat(item.qty) + ' ' + (item.satuan || '') + '</td>';
              itemHtml += '<td class="text-right">Rp ' + parseInt(item.harga_satuan).toLocaleString('id-ID') + '</td>';
              itemHtml += '<td class="text-right">Rp ' + parseInt(item.subtotal).toLocaleString('id-ID') + '</td>';
              itemHtml += '</tr>';
            });
          } else {
            itemHtml += '<tr><td colspan="4" class="text-center text-muted">Tidak ada detail item</td></tr>';
          }
          itemHtml += '</tbody></table>';
          $('.detail-items-' + tbl + '-' + id).html(itemHtml);
          
          // Render timeline (FA-05)
          var tlHtml = '';
          if (res.timeline.length > 0) {
            $.each(res.timeline, function(i, tl) {
              var cls = 'tl-pending';
              var catName = tl.nama_kategori || '';
              if (catName.indexOf('H+') === -1) {
                catName += ' (H+' + tl.jumlah_hari + ')';
              }
              tlHtml += '<div class="tl-item ' + cls + '">';
              tlHtml += '<div class="tl-title">' + catName + '</div>';
              tlHtml += '<div class="tl-date">Target: ' + tl.tanggal_label_muncul + '</div>';
              tlHtml += '<div class="tl-status">';
              tlHtml += '<span class="label label-' + (tl.status_label === 'Pending' ? 'warning' : tl.status_label === 'Selesai' ? 'success' : 'info') + '">' + tl.status_label + '</span>';
              if (tl.broadcast_count > 0) tlHtml += ' <span class="label label-primary"><i class="fa fa-whatsapp"></i> ' + tl.broadcast_count + 'x</span>';
              tlHtml += '</div>';
              if (tl.notes) tlHtml += '<div style="font-size:11px;color:#6c757d;margin-top:4px;"><i class="fa fa-comment"></i> ' + tl.notes + '</div>';
              tlHtml += '</div>';
            });
          } else {
            tlHtml = '<p class="text-muted" style="font-size:12px;">Belum ada data follow-up</p>';
          }
          $('.timeline-content-' + tbl + '-' + id).html(tlHtml);
        }
      }
    });
  });
});
</script>
