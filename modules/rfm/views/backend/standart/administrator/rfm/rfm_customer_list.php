<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
:root {
  --rfm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
  --card-radius: 14px;
}

.rfm-header {
  background: var(--rfm-gradient);
  color: #fff;
  padding: 26px 30px;
  border-radius: 16px;
  margin-bottom: 22px;
  box-shadow: 0 12px 30px rgba(30, 27, 75, 0.25);
  position: relative;
  overflow: hidden;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
}
.rfm-header::after {
  content: '';
  position: absolute;
  right: -50px; bottom: -50px;
  width: 220px; height: 220px;
  background: rgba(255,255,255,0.04);
  border-radius: 50%;
  pointer-events: none;
}
.rfm-header .header-title h2 { margin: 0 0 6px 0; font-weight: 800; font-size: 24px; letter-spacing: -0.5px; color: #fff; }
.rfm-header .header-title p { margin: 0; opacity: 0.85; font-size: 13.5px; color: #e2e8f0; }
.rfm-header .header-actions { display: flex; gap: 8px; flex-wrap: wrap; position: relative; z-index: 2; }
.rfm-header .header-actions .btn {
  border-radius: 9px;
  font-weight: 700;
  font-size: 12.5px;
  padding: 8px 16px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  transition: all 0.2s ease;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.rfm-header .header-actions .btn:hover { transform: translateY(-2px); }

.stat-card {
  background: #ffffff;
  border-radius: var(--card-radius);
  padding: 18px 20px;
  box-shadow: var(--card-shadow);
  border: 1px solid #f1f5f9;
  border-left: 4px solid #6366f1;
  margin-bottom: 20px;
  height: calc(100% - 20px);
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.stat-card .stat-num { font-size: 26px; font-weight: 800; color: #0f172a; line-height: 1.1; }
.stat-card .stat-label { font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }

.badge-source {
  padding: 3px 10px;
  border-radius: 20px;
  font-size: 10.5px;
  font-weight: 700;
  color: #fff;
  display: inline-block;
  margin: 2px 1px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.08);
  white-space: nowrap;
}
.badge-toko { background: linear-gradient(135deg, #1e293b, #334155); }
.badge-shopee { background: linear-gradient(135deg, #ee4d2d, #ff6b4a); }
.badge-tokopedia { background: linear-gradient(135deg, #059669, #10b981); }
.badge-tiktok { background: linear-gradient(135deg, #09090b, #18181b); }

.table-rfm th {
  background: #f8fafc;
  font-size: 10.5px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #475569;
  font-weight: 700;
  padding: 11px 14px !important;
  border-bottom: 2px solid #e2e8f0;
  white-space: nowrap;
}
.table-rfm td {
  vertical-align: middle !important;
  font-size: 12.5px;
  color: #334155;
  padding: 11px 14px !important;
}
.table-rfm tbody tr { transition: all 0.15s ease; }
.table-rfm tbody tr:hover { background: #f8fafc !important; }

.rfm-score-cell {
  display: inline-flex;
  align-items: center;
  gap: 4px;
}
.rfm-score-pill {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  border-radius: 6px;
  font-weight: 800;
  font-size: 11.5px;
  color: #fff;
}

.segment-badge {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  display: inline-block;
  box-shadow: 0 1px 4px rgba(0,0,0,0.06);
  white-space: nowrap;
}

.filter-bar {
  background: #fff;
  border-radius: var(--card-radius);
  padding: 16px 20px;
  box-shadow: var(--card-shadow);
  border: 1px solid #f1f5f9;
  margin-bottom: 20px;
}

/* ===== Animations & Micro-Interactions ===== */
@keyframes rfmFadeInUp {
  from {
    opacity: 0;
    transform: translateY(14px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.rfm-header, .stat-card, .filter-bar, .box {
  animation: rfmFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease;
}

.btn:active {
  transform: scale(0.97) !important;
}

.table-responsive {
  -webkit-overflow-scrolling: touch;
  scrollbar-width: thin;
  scrollbar-color: #cbd5e1 #f8fafc;
}
.table-responsive::-webkit-scrollbar {
  height: 6px;
  width: 6px;
}
.table-responsive::-webkit-scrollbar-track {
  background: #f8fafc;
  border-radius: 4px;
}
.table-responsive::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}

@media (max-width: 767px) {
  .rfm-header { padding: 20px 16px; text-align: center; flex-direction: column; }
  .rfm-header .header-title h2 { font-size: 21px; }
  .rfm-header .header-title p { font-size: 12.5px; }
  .rfm-header .header-actions { width: 100%; justify-content: center; gap: 8px; }
  .rfm-header .header-actions .btn { width: 100%; max-width: 100%; padding: 10px; font-size: 12.5px; justify-content: center; }
  .stat-card { padding: 14px; height: auto; margin-bottom: 12px; text-align: center; }
  .stat-card .stat-num { font-size: 22px; }
  .filter-bar { padding: 14px; }
  .table-rfm th { font-size: 10px; padding: 8px 6px !important; }
  .table-rfm td { font-size: 11.5px; padding: 8px 6px !important; }
}

@media (max-width: 575px) {
  .filter-bar .row > div { width: 100%; margin-bottom: 8px; }
  .filter-bar .row > div:last-child { display: flex; gap: 8px; }
}
</style>

<!-- ===== HEADER ===== -->
<div class="rfm-header">
  <div class="header-title">
    <h2><i class="fa fa-bar-chart"></i> Segmentasi Pelanggan RFM</h2>
    <p>Daftar pelanggan dengan skor Recency, Frequency, Monetary dan segmentasi otomatis</p>
  </div>
  <div class="header-actions">
    <button type="button" class="btn" data-toggle="modal" data-target="#modal-import-excel" style="background:#10b981; color:#fff; font-weight:700; border:none; box-shadow:0 4px 12px rgba(16,185,129,0.35);"><i class="fa fa-file-excel-o"></i> Import Excel Data</button>
    <a href="<?= site_url('administrator/rfm/dashboard'); ?>" class="btn" style="background:#fff; color:#312e81;"><i class="fa fa-tachometer"></i> Dashboard RFM</a>
    <a href="<?= site_url('administrator/rfm/export_customers?q=' . urlencode($filter ?? '') . '&rfm_segment=' . urlencode($rfm_segment ?? '') . '&product=' . urlencode($product_filter ?? '')); ?>" class="btn" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-download"></i> Export CSV</a>
    <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn" style="background:#25D366; color:#fff;"><i class="fa fa-whatsapp"></i> Broadcast WA</a>
  </div>
</div>

<!-- ===== STATS & FILTER ===== -->
<div class="row">
  <div class="col-md-3 col-sm-4 col-xs-12">
    <div class="stat-card" style="border-left-color:#6366f1;">
      <div class="stat-num"><?= number_format($customer_counts); ?></div>
      <div class="stat-label">Total Customer <?= !empty($rfm_segment) ? '(' . htmlspecialchars($rfm_segment) . ')' : ''; ?></div>
    </div>
  </div>
  <div class="col-md-9 col-sm-8 col-xs-12">
    <!-- Filter & Search -->
    <div class="filter-bar">
      <form method="get" action="<?= site_url('administrator/rfm'); ?>">
        <div class="row" style="margin-left:-5px; margin-right:-5px;">
          <div class="col-md-4 col-sm-6 col-xs-12" style="padding-left:5px; padding-right:5px; margin-bottom:8px;">
            <input type="text" name="q" class="form-control" placeholder="Cari nama / no telepon..." value="<?= htmlspecialchars($filter ?? ''); ?>" style="border-radius:8px; height:38px;">
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12" style="padding-left:5px; padding-right:5px; margin-bottom:8px;">
            <select name="rfm_segment" class="form-control" style="border-radius:8px; height:38px;">
              <option value="">— Semua Segmen —</option>
              <?php
              $all_segments = ['Champions','Loyal Customers','Potential Loyalist','New Customers','Big Spenders','Frequent Low Value','Need Attention','At Risk Customers',"Can't Lose Them",'Hibernating'];
              foreach ($all_segments as $seg):
              ?>
              <option value="<?= $seg; ?>" <?= ($rfm_segment ?? '') === $seg ? 'selected' : ''; ?>><?= $seg; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12" style="padding-left:5px; padding-right:5px; margin-bottom:8px;">
            <select name="product" class="form-control" style="border-radius:8px; height:38px;">
              <option value="">— Semua Produk —</option>
              <?php if (!empty($products_list)): foreach ($products_list as $p): 
                $p_name = !empty($p->item_name) ? $p->item_name : (!empty($p->nama_produk) ? $p->nama_produk : '');
                if (empty($p_name)) continue;
              ?>
              <option value="<?= htmlspecialchars($p_name); ?>" <?= ($product_filter ?? '') === $p_name ? 'selected' : ''; ?>><?= htmlspecialchars($p_name); ?></option>
              <?php endforeach; endif; ?>
            </select>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12" style="padding-left:5px; padding-right:5px; display:flex; gap:6px; margin-bottom:8px;">
            <button type="submit" class="btn" style="background:#6366f1; color:#fff; border:none; border-radius:8px; font-weight:700; height:38px; flex:1; display:inline-flex; align-items:center; justify-content:center; gap:6px;"><i class="fa fa-search"></i> Filter</button>
            <a href="<?= site_url('administrator/rfm'); ?>" class="btn btn-default" style="border-radius:8px; height:38px; width:38px; display:inline-flex; align-items:center; justify-content:center; flex-shrink:0;" title="Reset Filter"><i class="fa fa-refresh"></i></a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php if (!empty($product_filter)): ?>
<!-- ===== PRODUCT RECAP CARD ===== -->
<div class="box" style="border-radius:14px; overflow:hidden; border:1px solid #e0e7ff; box-shadow:0 4px 16px rgba(99,102,241,0.08); background:#fff; margin-bottom:20px;">
  <div class="box-header" style="background:linear-gradient(135deg, #eef2ff, #e0e7ff); padding:18px 22px; border-bottom:2px solid #c7d2fe;">
    <h4 style="margin:0; font-weight:800; color:#1e1b4b; font-size:16px;">
      <i class="fa fa-shopping-bag" style="color:#6366f1;"></i>
      Rekapan Produk: <span style="color:#4338ca;"><?= htmlspecialchars($product_filter); ?></span>
      <a href="<?= site_url('administrator/rfm'); ?>" class="btn btn-xs pull-right" style="background:#fff; color:#6366f1; border:1px solid #c7d2fe; border-radius:6px; font-weight:700;"><i class="fa fa-times"></i> Hapus Filter Produk</a>
    </h4>
  </div>
  <div class="box-body" style="padding:20px;">
    <?php if (!empty($product_recap)): $pr = $product_recap; ?>
    <div class="row">
      <div class="col-md-2 col-sm-4 col-xs-6">
        <div class="stat-card" style="border-left-color:#6366f1; margin-bottom:12px;">
          <div class="stat-num"><?= number_format($pr->total_customers); ?></div>
          <div class="stat-label">Pembeli Unik</div>
        </div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6">
        <div class="stat-card" style="border-left-color:#16a34a; margin-bottom:12px;">
          <div class="stat-num"><?= number_format($pr->total_orders); ?>x</div>
          <div class="stat-label">Total Order</div>
        </div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6">
        <div class="stat-card" style="border-left-color:#2563eb; margin-bottom:12px;">
          <div class="stat-num"><?= number_format($pr->total_qty); ?></div>
          <div class="stat-label">Total Qty Terjual</div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="stat-card" style="border-left-color:#059669; margin-bottom:12px;">
          <div class="stat-num" style="font-size:18px;">Rp <?= number_format($pr->total_spend, 0, ',', '.'); ?></div>
          <div class="stat-label">Total Omset Produk</div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="stat-card" style="border-left-color:<?= $pr->recency_days <= 30 ? '#16a34a' : ($pr->recency_days <= 90 ? '#f59e0b' : '#ef4444'); ?>; margin-bottom:12px;">
          <div class="stat-num"><?= $pr->recency_days; ?> <small style="font-size:13px; color:#64748b;">hari lalu</small></div>
          <div class="stat-label">Terakhir Dibeli</div>
        </div>
      </div>
    </div>

    <?php if (!empty($product_distribution['segments'])): ?>
    <div style="margin-top:8px;">
      <p style="font-weight:700; color:#1e1b4b; font-size:13px; margin-bottom:10px;"><i class="fa fa-th-large" style="color:#6366f1;"></i> Distribusi Segmen Pembeli Produk Ini:</p>
      <div style="display:flex; flex-wrap:wrap; gap:8px;">
        <?php foreach ($product_distribution['segments'] as $dist): if ($dist['count'] == 0) continue; ?>
        <a href="<?= site_url('administrator/rfm?product=' . urlencode($product_filter) . '&rfm_segment=' . urlencode($dist['segment'])); ?>"
           class="label" style="background:<?= $dist['badge']['bg']; ?>; color:<?= $dist['badge']['color']; ?>; border:1px solid <?= $dist['badge']['border']; ?>; padding:6px 12px; border-radius:20px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:5px; text-decoration:none; transition:transform 0.15s ease;"
           onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
          <i class="fa <?= $dist['badge']['icon']; ?>"></i> <?= $dist['segment']; ?>: <?= $dist['count']; ?> (<?= $dist['percentage']; ?>%)
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <p class="text-muted"><i class="fa fa-info-circle"></i> Data rekapan produk tidak ditemukan.</p>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<!-- ===== TABLE ===== -->
<div class="box box-default" style="border-radius:14px; overflow:hidden; border:1px solid #f1f5f9; box-shadow:0 4px 16px rgba(0,0,0,0.04); background:#fff;">
  <div class="box-body" style="padding:0;">
    <div class="table-responsive">
      <table class="table table-rfm" style="margin-bottom:0;">
        <thead>
          <tr>
            <th style="width:4%;">#</th>
            <th style="min-width:160px;">Customer</th>
            <th style="min-width:120px;">Sumber</th>
            <th style="min-width:80px;">Orders</th>
            <th style="min-width:120px;">Total Spend</th>
            <th style="min-width:100px;">Skor RFM</th>
            <th style="min-width:140px;">Segment</th>
            <th style="text-align:center; min-width:130px; width:130px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($customers)): ?>
          <tr><td colspan="8" class="text-center" style="padding:40px !important; color:#94a3b8; font-size:14px;"><i class="fa fa-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>Tidak ada data customer ditemukan</td></tr>
          <?php else: ?>
          <?php
          $offset_val = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
          $no = $offset_val + 1;
          foreach ($customers as $c):
            $rfm = $c->rfm;
            $badge = $rfm['badge'];
            $sources = explode(', ', $c->sumber_penjualan ?? '');
            
            // Score colors: 5=green, 4=lime, 3=yellow, 2=orange, 1=red
            $score_colors = [1 => '#ef4444', 2 => '#f97316', 3 => '#eab308', 4 => '#22c55e', 5 => '#16a34a'];
          ?>
          <tr>
            <td><?= $no++; ?></td>
            <td>
              <strong style="color:#0f172a; font-size:13px;"><?= htmlspecialchars($c->customer_nama); ?></strong><br>
              <span style="color:#64748b; font-size:11.5px; white-space:nowrap;"><i class="fa fa-phone" style="font-size:10px;"></i> <?= htmlspecialchars($c->customer_phone); ?></span>
            </td>
            <td>
              <?php foreach ($sources as $src):
                $src = trim($src);
                $cls = 'badge-toko';
                if (stripos($src, 'shopee') !== false) $cls = 'badge-shopee';
                elseif (stripos($src, 'tokopedia') !== false) $cls = 'badge-tokopedia';
                elseif (stripos($src, 'tiktok') !== false) $cls = 'badge-tiktok';
              ?>
              <span class="badge-source <?= $cls; ?>"><?= htmlspecialchars($src); ?></span>
              <?php endforeach; ?>
            </td>
            <td><strong><?= $c->total_orders; ?>x</strong></td>
            <td><strong style="color:#059669; white-space:nowrap;">Rp <?= number_format($c->total_spend, 0, ',', '.'); ?></strong></td>
            <td>
              <div class="rfm-score-cell">
                <span class="rfm-score-pill" style="background:<?= $score_colors[$rfm['r_score']]; ?>" title="Recency: <?= $rfm['r_score']; ?>"><?= $rfm['r_score']; ?></span>
                <span class="rfm-score-pill" style="background:<?= $score_colors[$rfm['f_score']]; ?>" title="Frequency: <?= $rfm['f_score']; ?>"><?= $rfm['f_score']; ?></span>
                <span class="rfm-score-pill" style="background:<?= $score_colors[$rfm['m_score']]; ?>" title="Monetary: <?= $rfm['m_score']; ?>"><?= $rfm['m_score']; ?></span>
              </div>
            </td>
            <td>
              <span class="segment-badge" style="background:<?= $badge['bg']; ?>; color:<?= $badge['color']; ?>; border:1px solid <?= $badge['border']; ?>;">
                <i class="fa <?= $badge['icon']; ?>" style="margin-right:4px;"></i><?= htmlspecialchars($rfm['segment']); ?>
              </span>
            </td>
            <td style="text-align:center; white-space:nowrap; min-width:130px; width:130px;">
              <a href="<?= site_url('administrator/rfm/customer_detail?phone=' . urlencode($c->customer_phone) . (!empty($product_filter) ? '&product=' . urlencode($product_filter) : '')); ?>" class="btn btn-sm" style="background:#6366f1; color:#fff; border:none; border-radius:6px; font-size:11px; font-weight:700; padding:4px 8px;" title="Detail RFM">
                <i class="fa fa-bar-chart"></i> Detail
              </a>
              <?php 
                $clean_phone = preg_replace('/[^0-9]/', '', $c->customer_phone ?? '');
                if (!empty($clean_phone)):
                  $wa_phone = preg_replace('/^0/', '62', $clean_phone);
                  if (substr($wa_phone, 0, 2) !== '62') $wa_phone = '62' . $wa_phone;
                  $wa_action = !empty($rfm['action']) ? $rfm['action'] : 'Terima kasih telah menjadi pelanggan setia kami.';
                  $wa_msg = "Halo Kak " . $c->customer_nama . ",\n\nSalam dari Metafora! " . $wa_action . "\n\nAda yang bisa kami bantu hari ini?";
                  $direct_wa_url = 'https://api.whatsapp.com/send?phone=' . $wa_phone . '&text=' . rawurlencode($wa_msg);
              ?>
              <a href="<?= $direct_wa_url; ?>" target="_blank" class="btn btn-sm" style="background:#25D366; color:#fff; border:none; border-radius:6px; font-size:11px; font-weight:700; padding:4px 8px; margin-left:2px;" title="Buka Chat WhatsApp Langsung">
                <i class="fa fa-whatsapp"></i> Chat
              </a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php if (!empty($pagination)): ?>
  <div class="box-footer text-center" style="background:#fafbfc; border-top:1px solid #f1f5f9; padding:12px;">
    <?= $pagination; ?>
  </div>
  <?php endif; ?>
</div>

<!-- ===== MODAL IMPORT EXCEL ===== -->
<div class="modal fade" id="modal-import-excel" tabindex="-1" role="dialog" aria-labelledby="modalImportExcelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:560px; margin:40px auto;">
    <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.15); overflow:hidden;">
      <form method="POST" action="<?= site_url('administrator/rfm/import_excel'); ?>" enctype="multipart/form-data" id="form-import-excel" onsubmit="document.getElementById('btn-submit-import').disabled=true; document.getElementById('btn-submit-import').innerHTML='<i class=\'fa fa-spinner fa-spin\'></i> Mengimport Data...';">
        <div class="modal-header" style="background:linear-gradient(135deg, #1e1b4b, #312e81, #4338ca); color:#fff; padding:18px 24px; border:none; position:relative;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.8; font-size:24px; position:absolute; right:20px; top:18px;">&times;</button>
          <h4 class="modal-title" id="modalImportExcelLabel" style="font-weight:700; font-size:17px; margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fa fa-file-excel-o" style="color:#34d399; font-size:22px;"></i> Import Data Excel (Besar / Banyak)
          </h4>
          <p style="margin:4px 0 0 32px; font-size:12.5px; opacity:0.85;">Dapat menerima ribuan data transaksi (.xlsx, .xls, .csv) & aturan matriks RFM</p>
        </div>
        <div class="modal-body" style="padding:24px;">
          <!-- Alert Note -->
          <div style="background:#eff6ff; border:1px solid #bfdbfe; border-left:4px solid #3b82f6; border-radius:10px; padding:12px 14px; margin-bottom:18px; font-size:12.5px; color:#1e40af;">
            <i class="fa fa-info-circle" style="font-size:15px; margin-right:6px;"></i>
            <strong>Auto-Detect Pintar:</strong> Sistem akan otomatis mengenali apakah file berisi data transaksi sales atau 125 aturan matriks RFM (seperti <code>rfm magang.xlsx</code>).
          </div>

          <!-- Import Mode Type -->
          <div class="form-group" style="margin-bottom:18px;">
            <label style="font-weight:700; color:#1e1b4b; font-size:13px; margin-bottom:6px; display:block;">Tipe Data Import:</label>
            <select name="import_type" class="form-control" style="border-radius:8px; border:1px solid #cbd5e1; height:40px; font-weight:600; font-size:13px;">
              <option value="auto">✨ Deteksi Otomatis (Rekomendasi)</option>
              <option value="transactions">🛒 Data Transaksi / Sales Order (Format Shopee, Tokopedia, Excel)</option>
              <option value="matrix">📊 Aturan Matriks RFM & Segmentasi (File Matriks 125 Aturan)</option>
            </select>
          </div>

          <!-- File Upload Input -->
          <div class="form-group" style="margin-bottom:18px;">
            <label style="font-weight:700; color:#1e1b4b; font-size:13px; margin-bottom:6px; display:block;">Pilih File Excel / CSV:</label>
            <div style="border:2px dashed #a5b4fc; background:#faf5ff; border-radius:12px; padding:20px; text-align:center; transition:all 0.2s;" onmouseover="this.style.borderColor='#6366f1';" onmouseout="this.style.borderColor='#a5b4fc';">
              <i class="fa fa-cloud-upload" style="font-size:36px; color:#6366f1; display:block; margin-bottom:8px;"></i>
              <span style="font-weight:600; color:#312e81; font-size:13px; display:block; margin-bottom:4px;">Klik atau seret file Excel ke sini</span>
              <span style="font-size:11.5px; color:#64748b; display:block; margin-bottom:12px;">Format yang didukung: <strong>.xlsx</strong>, <strong>.xls</strong>, <strong>.csv</strong> (Maks 50MB)</span>
              <input type="file" name="file_excel" class="form-control" accept=".xlsx, .xls, .csv" required style="max-width:320px; margin:0 auto; height:auto; padding:6px; font-size:12px; border-radius:8px;">
            </div>
          </div>

          <!-- Download Templates -->
          <div style="background:#f8fafc; border-radius:10px; padding:12px 16px; border:1px solid #e2e8f0; font-size:12px;">
            <span style="font-weight:700; color:#475569; display:block; margin-bottom:8px;"><i class="fa fa-download"></i> Unduh Contoh Template:</span>
            <div style="display:flex; flex-wrap:wrap; gap:8px;">
              <a href="<?= site_url('administrator/rfm/download_template_transactions'); ?>" class="btn btn-default btn-xs" style="border-radius:6px; font-weight:600; font-size:11.5px; background:#fff; color:#475569; border:1px solid #cbd5e1;"><i class="fa fa-file-text-o" style="color:#3b82f6;"></i> Template Transaksi Sales (CSV)</a>
              <a href="<?= site_url('administrator/rfm/download_template_matrix'); ?>" class="btn btn-default btn-xs" style="border-radius:6px; font-weight:600; font-size:11.5px; background:#fff; color:#475569; border:1px solid #cbd5e1;"><i class="fa fa-table" style="color:#10b981;"></i> Template Matriks RFM (CSV)</a>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:14px 24px; border-radius:0 0 16px 16px; display:flex; justify-content:flex-end; gap:10px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:8px; font-weight:600; padding:8px 18px;">Batal</button>
          <button type="submit" id="btn-submit-import" class="btn" style="background:linear-gradient(135deg, #4338ca, #6366f1); color:#fff; border-radius:8px; font-weight:700; padding:8px 22px; box-shadow:0 4px 12px rgba(99,102,241,0.3);"><i class="fa fa-upload"></i> Mulai Import Data</button>
        </div>
      </form>
    </div>
  </div>
</div>


