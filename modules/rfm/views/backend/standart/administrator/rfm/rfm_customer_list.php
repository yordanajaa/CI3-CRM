<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
:root {
  --rfm-primary: #6366f1;
  --rfm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
  --card-radius: 14px;
}

.rfm-header-nav {
  background: var(--rfm-gradient);
  color: #fff;
  padding: 22px 26px 18px 26px;
  border-radius: 16px;
  margin-bottom: 20px;
  box-shadow: 0 10px 28px rgba(30, 27, 75, 0.22);
  position: relative;
  overflow: hidden;
}
.rfm-header-nav::after {
  content: '';
  position: absolute;
  right: -50px; bottom: -50px;
  width: 220px; height: 220px;
  background: rgba(255,255,255,0.04);
  border-radius: 50%;
  pointer-events: none;
}
.rfm-header-nav .header-top-flex {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  flex-wrap: wrap;
  gap: 14px;
  margin-bottom: 16px;
  position: relative;
  z-index: 2;
}
.rfm-header-nav .location-tag {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255,255,255,0.15);
  border: 1px solid rgba(255,255,255,0.25);
  color: #e0e7ff;
  font-size: 11.5px;
  font-weight: 700;
  padding: 4px 12px;
  border-radius: 20px;
  margin-bottom: 8px;
}
.rfm-header-nav .header-title {
  flex: 1;
  min-width: 250px;
}
.rfm-header-nav .header-title h2 {
  margin: 0 0 4px 0;
  font-weight: 800;
  font-size: 22px;
  letter-spacing: -0.5px;
  color: #fff;
}
.rfm-header-nav .header-title p {
  margin: 0;
  opacity: 0.88;
  font-size: 13px;
  color: #e2e8f0;
}
.rfm-header-nav .action-tools {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  align-items: center;
  flex-shrink: 0;
  margin-left: auto;
}
.rfm-header-nav .action-tools .btn {
  border-radius: 9px;
  font-weight: 700;
  font-size: 12px;
  padding: 7px 13px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  transition: all 0.2s ease;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  border: none;
}
.rfm-header-nav .action-tools .btn:hover { transform: translateY(-2px); }

/* Navigation Tab Bar - Touch Scrollable */
.rfm-header-nav .nav-tabs-bar {
  display: flex;
  align-items: center;
  gap: 8px;
  padding-top: 14px;
  border-top: 1px solid rgba(255,255,255,0.18);
  position: relative;
  z-index: 2;
  overflow-x: auto;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
}
.rfm-header-nav .nav-tabs-bar::-webkit-scrollbar {
  display: none;
}
.rfm-header-nav .nav-tab-btn {
  padding: 8px 16px;
  border-radius: 10px;
  font-size: 12.5px;
  font-weight: 700;
  color: rgba(255,255,255,0.92);
  background: rgba(255,255,255,0.12);
  border: 1px solid rgba(255,255,255,0.22);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
  flex-shrink: 0;
}
.rfm-header-nav .nav-tab-btn:hover {
  background: rgba(255,255,255,0.25);
  color: #fff;
  transform: translateY(-1px);
}
.rfm-header-nav .nav-tab-btn.active {
  background: #ffffff !important;
  color: #312e81 !important;
  border-color: #ffffff !important;
  box-shadow: 0 4px 14px rgba(0,0,0,0.18) !important;
}
.rfm-header-nav .nav-tab-btn .active-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #6366f1;
  display: inline-block;
}

.stat-card {
  background: #ffffff;
  border-radius: var(--card-radius);
  padding: 16px 18px;
  box-shadow: var(--card-shadow);
  border: 1px solid #f1f5f9;
  border-left: 4px solid #6366f1;
  margin-bottom: 20px;
  height: calc(100% - 20px);
  display: flex;
  flex-direction: column;
  justify-content: center;
  cursor: pointer;
  transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.22s ease, border-color 0.22s ease;
  user-select: none;
}
.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.12);
  border-color: #cbd5e1;
}
.stat-card:active {
  transform: translateY(-1px) scale(0.99);
}
.stat-card .stat-num { font-size: 22px; font-weight: 800; color: #0f172a; line-height: 1.1; }
.stat-card .stat-label { font-size: 10.5px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }

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
  .rfm-header-nav { padding: 16px 14px; border-radius: 12px; }
  .rfm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; }
  .rfm-header-nav .header-title h2 { font-size: 18px; }
  .rfm-header-nav .header-title p { font-size: 11.5px; }
  .rfm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .rfm-header-nav .action-tools .btn { font-size: 11px; padding: 6px 10px; flex: 1 1 auto; min-width: 110px; }
  .rfm-header-nav .nav-tabs-bar { padding-top: 10px; gap: 6px; }
  .rfm-header-nav .nav-tab-btn { padding: 7px 12px; font-size: 11.5px; }
  .stats-row {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 8px !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
  }
  .stats-row::before, .stats-row::after {
    display: none !important;
    content: none !important;
  }
  .stats-row > div {
    width: 100% !important;
    max-width: 100% !important;
    float: none !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin: 0 !important;
  }
  .stat-card {
    padding: 10px 12px !important;
    height: 100% !important;
    margin-bottom: 0 !important;
    text-align: center !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    border-radius: 10px !important;
  }
  .stat-card .stat-num { font-size: 15px !important; line-height: 1.2 !important; }
  .stat-card .stat-label { font-size: 9px !important; margin-top: 3px !important; line-height: 1.2 !important; }
  .filter-bar { padding: 14px 12px !important; }
  .filter-bar .row > div { width: 100% !important; margin-bottom: 8px !important; }
  .filter-bar .row > div:last-child { display: flex !important; gap: 8px !important; }
  .filter-bar .row > div:last-child .btn { flex: 1 !important; }
  .table-rfm th { font-size: 10px; padding: 8px 6px !important; }
  .table-rfm td { font-size: 11.5px; padding: 8px 6px !important; }
}
</style>

<!-- ==========================================
     LAYER 1: HEADER BANNER & QUICK ACTIONS
     ========================================== -->
<div class="rfm-header-nav">
  <!-- Top Row: Title, Subtitle & Action Tools -->
  <div class="header-top-flex">
    <div class="header-title">
      <div class="location-tag">
        <i class="fa fa-map-marker"></i> Analisis RFM <i class="fa fa-angle-right"></i> <span>Daftar Customer & Segmentasi</span>
      </div>
      <h2><i class="fa fa-users" style="color:#818cf8;"></i> Segmentasi Pelanggan RFM</h2>
      <p>Daftar rincian seluruh pelanggan beserta riwayat transaksi, nilai belanja, dan kategori loyalitasnya</p>
    </div>

    <?php
      $nav_params = array_filter(['product' => $product_filter ?? '', 'period' => $period_filter ?? '', 'kategori' => $category_filter ?? '']);
      $nav_qs = !empty($nav_params) ? '?' . http_build_query($nav_params) : '';
      $export_params = array_filter(['q' => $filter ?? '', 'rfm_segment' => $rfm_segment ?? '', 'product' => $product_filter ?? '', 'period' => $period_filter ?? '', 'kategori' => $category_filter ?? '']);
      $export_qs = !empty($export_params) ? '?' . http_build_query($export_params) : '';
    ?>
    <div class="action-tools">
      <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn" style="background:#25D366; color:#fff;" title="Broadcast WA"><i class="fa fa-bullhorn"></i> Broadcast WA</a>
      <button type="button" class="btn" data-toggle="modal" data-target="#modal-import-excel" style="background:#10b981; color:#fff; box-shadow:0 4px 12px rgba(16,185,129,0.35);"><i class="fa fa-file-excel-o"></i> Import Excel Data</button>
      <a href="<?= site_url('administrator/rfm/export_customers' . $export_qs); ?>" class="btn" style="background:rgba(255,255,255,0.18); color:#fff; border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-download"></i> Export CSV</a>
    </div>
  </div>

  <!-- Bottom Row: Navigation Tabs Bar (Clear Location Indicator) -->
  <div class="nav-tabs-bar">
    <a href="<?= site_url('administrator/rfm/dashboard' . $nav_qs); ?>" class="nav-tab-btn">
      <i class="fa fa-tachometer"></i> 1. Dashboard RFM
    </a>
    <a href="<?= site_url('administrator/rfm' . $nav_qs); ?>" class="nav-tab-btn active">
      <span class="active-dot"></span> <i class="fa fa-users"></i> 2. Daftar Customer
    </a>
    <a href="<?= site_url('administrator/rfm/tracking'); ?>" class="nav-tab-btn">
      <i class="fa fa-line-chart"></i> 3. Tracking RFM
    </a>
    <a href="<?= site_url('administrator/rfm/cohort' . $nav_qs); ?>" class="nav-tab-btn">
      <i class="fa fa-th"></i> 4. Analisis Kohort
    </a>
    <a href="<?= site_url('administrator/crm_segments/product_rfm' . $nav_qs); ?>" class="nav-tab-btn">
      <i class="fa fa-th-large"></i> 5. Tren Segmen Produk
    </a>
    <a href="<?= site_url('administrator/rfm/matrix_rules' . $nav_qs); ?>" class="nav-tab-btn">
      <i class="fa fa-table"></i> 6. Matriks Aturan RFM
    </a>
  </div>
</div>

<!-- ==========================================
     LAYER 2: SUMMARY METRICS & ACTIVE FILTERS
     ========================================== -->
<?php
  // Calculate dataset summary
  $display_orders = isset($total_orders) ? $total_orders : 0;
  $display_spend = isset($total_spend) ? $total_spend : 0;
  if (!isset($total_orders) && !empty($customers)) {
    foreach ($customers as $c) {
      $display_orders += $c->total_orders;
      $display_spend += $c->total_spend;
    }
  }
  $active_filters_count = (!empty($filter) ? 1 : 0) + (!empty($rfm_segment) ? 1 : 0) + (!empty($product_filter) ? 1 : 0) + (!empty($period_filter) ? 1 : 0) + (!empty($category_filter) ? 1 : 0);
?>
<div class="row stats-row">
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="stat-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm'); ?>';" title="Klik untuk menampilkan seluruh pelanggan tanpa filter" style="border-left-color:#6366f1;">
      <div class="stat-num"><?= number_format($customer_counts); ?></div>
      <div class="stat-label">Total Pelanggan Terdaftar &rarr;</div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="stat-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm/tracking'); ?>';" title="Klik untuk melihat riwayat frekuensi transaksi di Tracking Bulanan" style="border-left-color:#16a34a;">
      <div class="stat-num"><?= number_format($display_orders); ?>x</div>
      <div class="stat-label">Total Frekuensi Transaksi &rarr;</div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="stat-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm/tracking'); ?>';" title="Klik untuk melihat riwayat total omset di Tracking Bulanan" style="border-left-color:#059669;">
      <div class="stat-num" style="font-size:18px;">Rp <?= number_format($display_spend, 0, ',', '.'); ?></div>
      <div class="stat-label">Total Omset Penjualan &rarr;</div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="stat-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm'); ?>';" title="Klik untuk mereset semua filter yang aktif" style="border-left-color:<?= $active_filters_count > 0 ? '#f59e0b' : '#64748b'; ?>;">
      <div class="stat-num" style="font-size:16px;">
        <?php if ($active_filters_count > 0): ?>
          <span style="color:#d97706; font-size:18px; font-weight:800;"><?= $active_filters_count; ?> Filter Aktif</span>
        <?php else: ?>
          <span style="color:#64748b; font-size:15px; font-weight:700;">Semua Data</span>
        <?php endif; ?>
      </div>
      <div class="stat-label">
        <?php if ($active_filters_count > 0): ?>
          <span style="color:#d97706; text-decoration:underline; font-weight:700;"><i class="fa fa-times"></i> Reset Semua Filter</span>
        <?php else: ?>
          Tanpa Filter Terpasang
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================
     LAYER 3: MULTI-CRITERIA FILTER BAR
     ========================================== -->
<div class="filter-bar">
  <form method="get" action="<?= site_url('administrator/rfm'); ?>">
    <div class="row" style="margin-left:-5px; margin-right:-5px;">
      <div class="col-md-2 col-sm-6 col-xs-12" style="padding-left:5px; padding-right:5px; margin-bottom:8px;">
        <label style="font-size:11px; font-weight:700; color:#475569; margin-bottom:3px; display:block;">Pencarian:</label>
        <div class="input-group">
          <span class="input-group-addon" style="border-radius:8px 0 0 8px; background:#f8fafc;"><i class="fa fa-search"></i></span>
          <input type="text" name="q" class="form-control" placeholder="Cari nama / no. HP / resi / platform..." value="<?= htmlspecialchars($filter ?? ''); ?>" style="border-radius:0 8px 8px 0; height:38px; font-size:12px;">
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12" style="padding-left:5px; padding-right:5px; margin-bottom:8px;">
        <label style="font-size:11px; font-weight:700; color:#475569; margin-bottom:3px; display:block;">Segmen Market:</label>
        <select name="rfm_segment" class="form-control" style="border-radius:8px; height:38px; font-size:12px; font-weight:600;">
          <option value="">— Semua Segmen —</option>
          <?php
          $all_segments = ['Champions','Loyal Customers','Potential Loyalist','New Customers','Big Spenders','Frequent Low Value','Need Attention','At Risk Customers',"Can't Lose Them",'Hibernating'];
          foreach ($all_segments as $seg):
          ?>
          <option value="<?= $seg; ?>" <?= ($rfm_segment ?? '') === $seg ? 'selected' : ''; ?>><?= $seg; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12" style="padding-left:5px; padding-right:5px; margin-bottom:8px;">
        <label style="font-size:11px; font-weight:700; color:#475569; margin-bottom:3px; display:block;">Kategori Produk:</label>
        <select name="kategori" class="form-control" style="border-radius:8px; height:38px; font-size:12px; font-weight:600;">
          <option value="">— Semua Kategori —</option>
          <?php 
          if (!empty($categories_list)) {
            foreach ($categories_list as $kat) {
              $k_name = is_object($kat) ? $kat->nama_kategori : (string)$kat;
              $is_resi = (stripos($k_name, 'Resi') !== false);
          ?>
          <option value="<?= htmlspecialchars($k_name); ?>" <?= ($category_filter ?? '') === $k_name ? 'selected' : ''; ?>>
            <?= ($is_resi ? '📦 ' : '📁 ') . htmlspecialchars($k_name); ?>
          </option>
          <?php 
            }
          } 
          ?>
        </select>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12" style="padding-left:5px; padding-right:5px; margin-bottom:8px;">
        <label style="font-size:11px; font-weight:700; color:#475569; margin-bottom:3px; display:block;">Produk Transaksi:</label>
        <select name="product" class="form-control" style="border-radius:8px; height:38px; font-size:12px; font-weight:600;">
          <option value="">— Semua Produk —</option>
          <?php 
          $grouped_cust_prods = [];
          if (!empty($products_list)) {
            foreach ($products_list as $p) {
              $p_name = !empty($p->item_name) ? $p->item_name : (!empty($p->nama_produk) ? $p->nama_produk : '');
              if (empty($p_name)) continue;
              $kat_name = !empty($p->nama_kategori) ? $p->nama_kategori : 'Lainnya';
              $grouped_cust_prods[$kat_name][] = $p_name;
            }
          }
          if (!empty($grouped_cust_prods)) {
            foreach ($grouped_cust_prods as $kat_title => $items) {
          ?>
            <optgroup label="📂 <?= htmlspecialchars($kat_title); ?>">
              <?php foreach ($items as $p_item): ?>
                <option value="<?= htmlspecialchars($p_item); ?>" <?= ($product_filter ?? '') === $p_item ? 'selected' : ''; ?>><?= htmlspecialchars($p_item); ?></option>
              <?php endforeach; ?>
            </optgroup>
          <?php 
            }
          } 
          ?>
        </select>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12" style="padding-left:5px; padding-right:5px; margin-bottom:8px;">
        <label style="font-size:11px; font-weight:700; color:#475569; margin-bottom:3px; display:block;">Periode / Bulan:</label>
        <select name="period" class="form-control" style="border-radius:8px; height:38px; font-size:12px; font-weight:600;">
          <option value="">— Semua Periode —</option>
          <?php 
          $period_found = false;
          if (!empty($months_list)) {
            foreach ($months_list as $m) {
              $is_curr_sel = (!empty($period_filter) && $period_filter === $m->ym_val);
              if ($is_curr_sel) $period_found = true;
          ?>
          <option value="<?= htmlspecialchars($m->ym_val); ?>" <?= $is_curr_sel ? 'selected' : ''; ?>>📅 <?= htmlspecialchars($m->ym_label); ?></option>
          <?php 
            }
          }
          if (!empty($period_filter) && !$period_found) {
          ?>
          <option value="<?= htmlspecialchars($period_filter); ?>" selected>📅 <?= htmlspecialchars($period_filter); ?> (Filter Aktif)</option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-1 col-sm-6 col-xs-12" style="padding-left:5px; padding-right:5px; display:flex; flex-direction:column; justify-content:flex-end; margin-bottom:8px;">
        <div style="display:flex; gap:4px;">
          <button type="submit" class="btn" style="background:#6366f1; color:#fff; border:none; border-radius:8px; font-weight:700; height:38px; flex:1; display:inline-flex; align-items:center; justify-content:center; padding:0;" title="Filter"><i class="fa fa-filter"></i></button>
          <a href="<?= site_url('administrator/rfm'); ?>" class="btn btn-default" style="border-radius:8px; height:38px; width:34px; display:inline-flex; align-items:center; justify-content:center; flex-shrink:0; padding:0;" title="Reset Filter"><i class="fa fa-refresh"></i></a>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- ==========================================
     LAYER 4: PRODUCT RECAP CARD (IF FILTERED BY PRODUCT)
     ========================================== -->
<?php if (!empty($product_filter)): ?>
<div class="box" style="border-radius:14px; overflow:hidden; border:1px solid #e0e7ff; box-shadow:0 4px 16px rgba(99,102,241,0.08); background:#fff; margin-bottom:20px;">
  <div class="box-header" style="background:linear-gradient(135deg, #eef2ff, #e0e7ff); padding:18px 22px; border-bottom:2px solid #c7d2fe;">
    <h4 style="margin:0; font-weight:800; color:#1e1b4b; font-size:16px; display:flex; justify-content:space-between; align-items:center;">
      <span><i class="fa fa-shopping-bag" style="color:#6366f1;"></i> Rekapan Produk: <span style="color:#4338ca;"><?= htmlspecialchars($product_filter); ?></span></span>
      <a href="<?= site_url('administrator/rfm'); ?>" class="btn" style="background:linear-gradient(135deg, #dc2626, #b91c1c); color:#ffffff; border-radius:8px; font-weight:800; font-size:12px; padding:6px 14px; box-shadow:0 3px 8px rgba(220,38,38,0.3); border:none; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-times-circle"></i> Hapus Filter Produk</a>
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

<!-- ==========================================
     LAYER 5: CUSTOMER RFM DATA TABLE & PAGINATION
     ========================================== -->
<div class="box box-default" style="border-radius:14px; overflow:hidden; border:1px solid #f1f5f9; box-shadow:0 4px 16px rgba(0,0,0,0.04); background:#fff;">
  <div class="box-body" style="padding:0;">
    <div class="table-responsive">
      <table class="table table-rfm" style="margin-bottom:0; width:100%; min-width:940px;">
        <thead>
          <tr>
            <th style="width:3%; min-width:30px;">#</th>
            <th style="min-width:160px;">Nama Customer</th>
            <th style="min-width:120px;">Sumber Platform</th>
            <th style="text-align:center; min-width:90px;">Order (F)</th>
            <th style="text-align:right; min-width:120px;">Total Spend (M)</th>
            <th style="text-align:center; min-width:105px;">Recency (R)</th>
            <th style="text-align:center; min-width:95px;">Skor RFM</th>
            <th style="text-align:center; min-width:130px;">Segmen Market</th>
            <th style="text-align:center; min-width:180px; width:180px;">Aksi Navigasi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($customers)): ?>
          <tr>
            <td colspan="9" class="text-center" style="padding:45px 20px !important; color:#64748b; font-size:14px;">
              <i class="fa fa-inbox" style="font-size:38px; color:#cbd5e1; display:block; margin-bottom:12px;"></i>
              <strong style="color:#1e293b; font-size:15px; display:block; margin-bottom:6px;">Tidak ada data customer ditemukan</strong>
              <?php if ($active_filters_count > 0): ?>
                <span style="font-size:12.5px; color:#64748b;">Filter yang Anda pilih saat ini tidak memiliki transaksi yang cocok.</span><br>
                <a href="<?= site_url('administrator/rfm'); ?>" class="btn btn-warning btn-sm" style="margin-top:14px; border-radius:8px; font-weight:700; padding:7px 16px;">
                  <i class="fa fa-refresh"></i> Reset Semua Filter &amp; Tampilkan Seluruh Data Pelanggan
                </a>
              <?php else: ?>
                <span style="font-size:12.5px; color:#94a3b8;">Belum ada riwayat transaksi penjualan di database.</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php else: ?>
          <?php
          $offset_val = isset($_GET['offset']) ? (int)$_GET['offset'] : (isset($this->uri->segments[4]) ? (int)$this->uri->segments[4] : 0);
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
              <strong style="color:#0f172a; font-size:13.5px;"><?= htmlspecialchars($c->customer_nama); ?></strong><br>
              <span style="color:#64748b; font-size:11.5px; white-space:nowrap;"><i class="fa fa-phone" style="font-size:10px; color:#6366f1;"></i> <?= htmlspecialchars($c->customer_phone); ?></span>
            </td>
            <td>
              <?php foreach ($sources as $src):
                $src = trim($src);
                if (empty($src)) continue;
                $cls = 'badge-toko';
                if (stripos($src, 'shopee') !== false) $cls = 'badge-shopee';
                elseif (stripos($src, 'tokopedia') !== false) $cls = 'badge-tokopedia';
                elseif (stripos($src, 'tiktok') !== false) $cls = 'badge-tiktok';
              ?>
              <span class="badge-source <?= $cls; ?>"><?= htmlspecialchars($src); ?></span>
              <?php endforeach; ?>
            </td>
            <td style="text-align:center;">
              <span class="label" style="background:#dcfce7; color:#166534; font-size:11.5px; font-weight:800; padding:4px 8px; border-radius:6px;">
                <i class="fa fa-repeat"></i> <?= $c->total_orders; ?>x
              </span>
            </td>
            <td style="text-align:right;">
              <strong style="color:#059669; font-size:13px; white-space:nowrap;">Rp <?= number_format($c->total_spend, 0, ',', '.'); ?></strong>
            </td>
            <td style="text-align:center;">
              <span class="label" style="background:<?= ($rfm['days_since_last'] <= 30 ? '#dcfce7; color:#166534;' : ($rfm['days_since_last'] <= 90 ? '#fef3c7; color:#92400e;' : '#fee2e2; color:#991b1b;')); ?> font-size:11.5px; padding:4px 8px; border-radius:6px; font-weight:600;">
                <?= $rfm['days_since_last']; ?> hr lalu
              </span>
            </td>
            <td style="text-align:center;">
              <div class="rfm-score-cell" style="justify-content:center;">
                <span class="rfm-score-pill" style="background:<?= $score_colors[$rfm['r_score']]; ?>" title="Recency Skor (R): <?= $rfm['r_score']; ?>"><?= $rfm['r_score']; ?></span>
                <span class="rfm-score-pill" style="background:<?= $score_colors[$rfm['f_score']]; ?>" title="Frequency Skor (F): <?= $rfm['f_score']; ?>"><?= $rfm['f_score']; ?></span>
                <span class="rfm-score-pill" style="background:<?= $score_colors[$rfm['m_score']]; ?>" title="Monetary Skor (M): <?= $rfm['m_score']; ?>"><?= $rfm['m_score']; ?></span>
              </div>
            </td>
            <td style="text-align:center;">
              <span class="segment-badge" style="background:<?= $badge['bg']; ?>; color:<?= $badge['color']; ?>; border:1px solid <?= $badge['border']; ?>; font-size:11px; font-weight:700;">
                <i class="fa <?= $badge['icon']; ?>" style="margin-right:4px;"></i><?= htmlspecialchars($rfm['segment']); ?>
              </span>
            </td>
            <td style="text-align:center; white-space:nowrap; min-width:180px; width:180px;">
              <?php
                $det_qs = array_filter([
                  'phone' => $c->customer_phone,
                  'product' => $product_filter ?? '',
                  'period' => $period_filter ?? ''
                ]);
              ?>
              <a href="<?= site_url('administrator/rfm/customer_detail?' . http_build_query($det_qs)); ?>" class="btn btn-sm" style="background:#4338ca; color:#ffffff; font-weight:800; font-size:11.5px; padding:6px 12px; border-radius:8px; box-shadow:0 2px 6px rgba(67,56,202,0.3); display:inline-flex; align-items:center; gap:5px;" title="Lihat Profil & Analisis Detail RFM Customer Ini">
                <i class="fa fa-user"></i> Detail Customer
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
              <a href="<?= $direct_wa_url; ?>" target="_blank" class="btn btn-sm" style="background:#16a34a; color:#ffffff; font-weight:800; font-size:11.5px; padding:6px 12px; border-radius:8px; box-shadow:0 2px 6px rgba(22,163,74,0.3); margin-left:4px; display:inline-flex; align-items:center; gap:5px;" title="Kirim Pesan WhatsApp Langsung">
                <i class="fa fa-whatsapp"></i> Chat WA
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

<!-- ==========================================
     LAYER 6: MODAL IMPORT EXCEL DATA
     ========================================== -->
<div class="modal fade" id="modal-import-excel" tabindex="-1" role="dialog" aria-labelledby="modalImportExcelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:560px; margin:40px auto;">
    <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.15); overflow:hidden;">
      <form method="POST" action="<?= site_url('administrator/rfm/import_excel'); ?>" enctype="multipart/form-data" id="form-import-excel" onsubmit="document.getElementById('btn-submit-import').disabled=true; document.getElementById('btn-submit-import').innerHTML='<i class=\'fa fa-spinner fa-spin\'></i> Mengimport Data...';">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
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
              <option value="transactions">🛒 Data Transaksi Penjualan (Format Shopee, Tokopedia, Excel)</option>
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
