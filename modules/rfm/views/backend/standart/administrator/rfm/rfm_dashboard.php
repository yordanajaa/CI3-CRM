<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<style>
:root {
  --rfm-primary: #6366f1;
  --rfm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 16px -2px rgba(0, 0, 0, 0.05), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
  --card-radius: 12px;
}

/* Header & Location Navigation Card */
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
  background: rgba(255,255,255,0.05);
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
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  border: none;
  transition: all 0.2s ease;
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

/* KPI Cards */
.kpi-row { margin-bottom: 12px; }
.kpi-card {
  background: #fff;
  border-radius: var(--card-radius);
  padding: 14px 16px;
  box-shadow: var(--card-shadow);
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 12px;
  border: 1px solid #f1f5f9;
  cursor: pointer;
  transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.22s ease, border-color 0.22s ease;
  user-select: none;
}
.kpi-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.12);
  border-color: #cbd5e1;
}
.kpi-card:active {
  transform: translateY(-1px) scale(0.99);
}
.kpi-card .kpi-icon {
  width: 44px;
  height: 44px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 19px;
  flex-shrink: 0;
}
.kpi-card .kpi-body { flex: 1; min-width: 0; }
.kpi-card .kpi-value {
  font-size: 20px;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.2;
}
.kpi-card .kpi-label {
  font-size: 11px;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  margin-top: 2px;
}

/* Section Card */
.section-card {
  background: #fff;
  border-radius: var(--card-radius);
  padding: 16px;
  box-shadow: var(--card-shadow);
  border: 1px solid #f1f5f9;
  margin-bottom: 16px;
}
.section-card .card-title {
  font-size: 14px;
  font-weight: 800;
  color: #1e1b4b;
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 7px;
}

/* Filter Bar */
.rfm-filter-bar {
  padding: 10px 16px;
  margin-bottom: 14px;
  background: #fff;
  border-left: 4px solid #6366f1;
}
.rfm-filter-form {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 10px;
}
.rfm-filter-inner {
  display: flex;
  align-items: center;
  gap: 12px;
  flex: 1;
  min-width: 280px;
  flex-wrap: wrap;
}
.rfm-filter-field {
  display: flex;
  align-items: center;
  gap: 6px;
}
.rfm-filter-field label {
  margin: 0;
  font-weight: 700;
  color: #1e1b4b;
  font-size: 12px;
  white-space: nowrap;
}

/* Charts & Segments Cards */
.section-card-chart {
  height: 360px;
  display: flex;
  flex-direction: column;
}
.section-card-segments {
  height: 360px;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

/* Segment Grid (Compact 2-columns) */
.segment-grid-compact {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 8px;
}
@media (max-width: 767px) {
  .segment-grid-compact { grid-template-columns: 1fr; }
}
.seg-card-compact {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 9px;
  padding: 9px 12px;
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  transition: all 0.22s ease;
  user-select: none;
}
.seg-card-compact:hover {
  background: #fff;
  border-color: #6366f1;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(99,102,241,0.12);
}
.seg-card-compact:active {
  transform: scale(0.99);
}
.seg-card-compact .seg-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  flex-shrink: 0;
}
.seg-card-compact .seg-info { flex: 1; min-width: 0; }
.seg-card-compact .seg-name {
  font-weight: 700;
  font-size: 12px;
  color: #1e293b;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.seg-card-compact .seg-count {
  font-size: 15px;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.1;
}
.seg-card-compact .seg-pct { font-size: 10.5px; color: #64748b; font-weight: 600; }
.seg-card-compact .seg-action a {
  font-size: 10.5px;
  color: var(--rfm-primary);
  font-weight: 700;
  text-decoration: none;
}
.seg-card-compact .seg-action a:hover { text-decoration: underline; }

/* Custom Tabbed Card */
.rfm-tab-card {
  background: #fff;
  border-radius: var(--card-radius);
  box-shadow: var(--card-shadow);
  border: 1px solid #e2e8f0;
  margin-bottom: 20px;
  overflow: hidden;
}
.rfm-tab-card .nav-tabs {
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  padding: 6px 12px 0 12px;
  display: flex;
  overflow-x: auto;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
}
.rfm-tab-card .nav-tabs::-webkit-scrollbar { display: none; }
.rfm-tab-card .nav-tabs > li { float: none; display: inline-block; flex-shrink: 0; }
.rfm-tab-card .nav-tabs > li > a {
  border-radius: 8px 8px 0 0;
  font-weight: 700;
  font-size: 12.5px;
  color: #475569;
  padding: 9px 15px;
  border: 1px solid transparent;
  margin-right: 4px;
  transition: all 0.2s ease;
}
.rfm-tab-card .nav-tabs > li.active > a,
.rfm-tab-card .nav-tabs > li.active > a:focus,
.rfm-tab-card .nav-tabs > li.active > a:hover {
  background: #fff;
  color: #1e1b4b;
  border-color: #e2e8f0 #e2e8f0 transparent;
  border-top: 3px solid #6366f1;
}
.rfm-tab-card .tab-content {
  padding: 16px;
}

/* Compact Tables */
.table-compact th {
  background: #f8fafc;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.4px;
  color: #475569;
  padding: 8px 10px !important;
  border-bottom: 2px solid #e2e8f0;
  white-space: nowrap;
}
.table-compact td {
  padding: 8px 10px !important;
  font-size: 12px;
  color: #334155;
  vertical-align: middle !important;
}
.table-compact tbody tr:hover { background: #f8fafc; }
.score-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 22px;
  height: 22px;
  border-radius: 6px;
  font-weight: 800;
  font-size: 11px;
  color: #fff;
}
.segment-pill {
  padding: 3px 8px;
  border-radius: 12px;
  font-size: 10.5px;
  font-weight: 700;
  display: inline-block;
  white-space: nowrap;
}

/* Mobile Responsiveness Enhancements */
@media (max-width: 768px) {
  .rfm-dashboard-wrapper, .rfm-wrapper {
    padding: 10px 8px 30px 8px !important;
  }
  .rfm-header-nav {
    padding: 16px 14px 14px 14px !important;
    border-radius: 12px !important;
  }
  .rfm-header-nav .header-top-flex {
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 12px !important;
  }
  .rfm-header-nav .header-title h2 {
    font-size: 18px !important;
  }
  .rfm-header-nav .action-tools {
    width: 100% !important;
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 6px !important;
    margin-left: 0 !important;
  }
  .rfm-header-nav .action-tools .btn {
    flex: 1 1 auto !important;
    text-align: center !important;
    justify-content: center !important;
    font-size: 11px !important;
    padding: 6px 9px !important;
  }
  .rfm-header-nav .nav-tabs-bar {
    padding-top: 10px !important;
    gap: 6px !important;
    -webkit-overflow-scrolling: touch !important;
  }
  .rfm-header-nav .nav-tab-btn {
    padding: 6px 12px !important;
    font-size: 11.5px !important;
  }

  /* Filter Bar Mobile */
  .rfm-filter-bar {
    padding: 12px 14px !important;
  }
  #form-product-filter {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 10px !important;
  }
  .rfm-filter-inner {
    flex-direction: column !important;
    align-items: stretch !important;
    min-width: 0 !important;
    width: 100% !important;
    gap: 9px !important;
  }
  .filter-icon-indicator {
    display: none !important;
  }
  .rfm-filter-field {
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 3px !important;
    width: 100% !important;
  }
  .rfm-filter-field label {
    font-size: 11px !important;
    color: #475569 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.3px !important;
    font-weight: 700 !important;
  }
  .rfm-filter-field select,
  .rfm-filter-field .form-control {
    width: 100% !important;
    min-width: 100% !important;
    max-width: 100% !important;
    height: 38px !important;
    font-size: 12.5px !important;
    border-radius: 8px !important;
  }
  .rfm-filter-reset {
    width: 100% !important;
  }
  .rfm-filter-reset .btn {
    width: 100% !important;
    display: block !important;
    text-align: center !important;
    padding: 8px !important;
    font-size: 12px !important;
    border-radius: 8px !important;
  }

  /* KPI Grid Mobile: Strict 2x2 Clean Layout */
  .kpi-row {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 8px !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
  }
  .kpi-row::before, .kpi-row::after {
    display: none !important;
    content: none !important;
  }
  .kpi-row > div {
    width: 100% !important;
    max-width: 100% !important;
    float: none !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin: 0 !important;
  }
  .kpi-card {
    padding: 10px 10px !important;
    margin-bottom: 0 !important;
    height: 100% !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    border-radius: 10px !important;
  }
  .kpi-card .kpi-icon {
    width: 36px !important;
    height: 36px !important;
    font-size: 15px !important;
    border-radius: 8px !important;
    flex-shrink: 0 !important;
  }
  .kpi-card .kpi-body {
    min-width: 0 !important;
    flex: 1 !important;
  }
  .kpi-card .kpi-value {
    font-size: 14.5px !important;
    line-height: 1.15 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
  }
  .kpi-card .kpi-label {
    font-size: 9.5px !important;
    margin-top: 2px !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
  }

  /* Section Cards Mobile */
  .section-card {
    padding: 12px !important;
  }
  .section-card-chart {
    height: 290px !important;
    margin-bottom: 12px !important;
  }
  .section-card-segments {
    height: auto !important;
    max-height: 440px !important;
    margin-bottom: 14px !important;
  }
  .segment-grid-compact {
    grid-template-columns: 1fr !important;
    gap: 6px !important;
  }
  .seg-card-compact {
    padding: 8px 10px !important;
  }

  .rfm-tab-card .tab-content {
    padding: 12px 10px !important;
  }
  .table-responsive {
    border: none !important;
    margin-bottom: 0 !important;
    -webkit-overflow-scrolling: touch !important;
  }
  .modal-dialog {
    width: 94% !important;
    max-width: 520px !important;
    margin: 15px auto !important;
  }
  .modal-content {
    border-radius: 12px !important;
  }
}
</style>

<!-- ==========================================
     1. HEADER BANNER & QUICK ACTIONS
     ========================================== -->
<div class="rfm-header-nav">
  <div class="header-top-flex">
    <div class="header-title">
      <div class="location-tag">
        <i class="fa fa-map-marker"></i> Analisis RFM <i class="fa fa-angle-right"></i> <span>Dashboard Utama</span>
      </div>
      <h2><i class="fa fa-tachometer" style="color:#818cf8;"></i> Dashboard Analisis RFM</h2>
      <p>Ringkasan segmentasi Recency (Kebaruan), Frequency (Frekuensi), dan Monetary (Nominal Belanja)</p>
    </div>

    <?php
      $nav_params = array_filter(['product' => $product_filter ?? '', 'period' => $period_filter ?? '', 'kategori' => $category_filter ?? '']);
      $nav_qs = !empty($nav_params) ? '?' . http_build_query($nav_params) : '';
    ?>
    <div class="action-tools">
      <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn" style="background:#25D366; color:#fff;" title="Broadcast WA"><i class="fa fa-bullhorn"></i> Broadcast WA</a>
      <button type="button" class="btn" data-toggle="modal" data-target="#modal-import-excel" style="background:#10b981; color:#fff; box-shadow:0 4px 12px rgba(16,185,129,0.35);"><i class="fa fa-file-excel-o"></i> Import Excel Data</button>
      <a href="<?= site_url('administrator/rfm/export_customers' . $nav_qs); ?>" class="btn" style="background:rgba(255,255,255,0.18); color:#fff; border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-download"></i> Export CSV</a>
    </div>
  </div>

  <!-- Navigation Tabs Bar -->
  <div class="nav-tabs-bar">
    <a href="<?= site_url('administrator/rfm/dashboard' . $nav_qs); ?>" class="nav-tab-btn active">
      <span class="active-dot"></span> <i class="fa fa-tachometer"></i> 1. Dashboard RFM
    </a>
    <a href="<?= site_url('administrator/rfm' . $nav_qs); ?>" class="nav-tab-btn">
      <i class="fa fa-users"></i> 2. Daftar Customer
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
     2. COMPACT FILTER BAR
     ========================================== -->
<div class="section-card rfm-filter-bar">
  <form method="GET" action="<?= site_url('administrator/rfm/dashboard'); ?>" id="form-product-filter" class="rfm-filter-form">
    <div class="rfm-filter-inner">
      <i class="fa fa-filter filter-icon-indicator" style="color:#6366f1; font-size:16px;"></i>
      
      <!-- Filter Kategori -->
      <div class="rfm-filter-field">
        <label for="category-select">Kategori:</label>
        <select name="kategori" id="category-select" class="form-control input-sm" style="border-radius:6px; font-weight:600; min-width:140px; max-width:200px;" onchange="document.getElementById('product-select').value=''; document.getElementById('form-product-filter').submit();">
          <option value="">-- Semua Kategori --</option>
          <?php if (!empty($categories_list)): ?>
            <?php foreach ($categories_list as $kat): ?>
              <option value="<?= htmlspecialchars($kat->nama_kategori); ?>" <?= (($category_filter ?? '') === $kat->nama_kategori) ? 'selected' : ''; ?>>
                <?= (stripos($kat->nama_kategori, 'Resi') !== false ? '📦 ' : '📁 ') . htmlspecialchars($kat->nama_kategori); ?>
              </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>

      <!-- Filter Produk (dengan pengelompokan Kategori agar spesifik) -->
      <div class="rfm-filter-field">
        <label for="product-select">Produk:</label>
        <select name="product" id="product-select" class="form-control input-sm" style="border-radius:6px; font-weight:600; min-width:200px; max-width:320px;" onchange="document.getElementById('form-product-filter').submit();">
          <option value="">-- Semua Produk --</option>
          <?php 
          $grouped_prods = [];
          if (!empty($products_list)) {
            foreach ($products_list as $prod) {
              $p_name = !empty($prod->item_name) ? $prod->item_name : (!empty($prod->nama_produk) ? $prod->nama_produk : '');
              if (empty($p_name)) continue;
              $kat_name = !empty($prod->nama_kategori) ? $prod->nama_kategori : 'Lainnya';
              $grouped_prods[$kat_name][] = $p_name;
            }
          }
          ?>
          <?php if (!empty($grouped_prods)): ?>
            <?php foreach ($grouped_prods as $kat_title => $items): ?>
              <optgroup label="📂 <?= htmlspecialchars($kat_title); ?>">
                <?php foreach ($items as $p_item): ?>
                  <option value="<?= htmlspecialchars($p_item); ?>" <?= ($product_filter === $p_item) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($p_item); ?>
                  </option>
                <?php endforeach; ?>
              </optgroup>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>

      <!-- Filter Periode Bulan -->
      <div class="rfm-filter-field">
        <label for="period-select">Bulan:</label>
        <select name="period" id="period-select" class="form-control input-sm" style="border-radius:6px; font-weight:600; min-width:160px;" onchange="document.getElementById('form-product-filter').submit();">
           <option value="">-- Semua Bulan --</option>
          <?php if (!empty($months_list)): ?>
            <?php foreach ($months_list as $m): ?>
              <option value="<?= htmlspecialchars($m->ym_val); ?>" <?= (($period_filter ?? '') === $m->ym_val) ? 'selected' : ''; ?>>
                📅 <?= htmlspecialchars($m->ym_label); ?>
              </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
    </div>

    <div class="rfm-filter-reset">
      <?php if (!empty($product_filter) || !empty($period_filter) || !empty($category_filter)): ?>
        <a href="<?= site_url('administrator/rfm/dashboard'); ?>" class="btn btn-xs btn-default" style="border-radius:6px; font-weight:600;"><i class="fa fa-times"></i> Reset</a>
      <?php endif; ?>
    </div>
  </form>
</div>

<!-- ==========================================
     3. EXECUTIVE KPI METRICS (4 CARDS)
     ========================================== -->
<div class="row kpi-row">
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="kpi-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm' . $nav_qs); ?>';" title="Klik untuk membuka dan melihat rincian seluruh pelanggan di Daftar Customer RFM">
      <div class="kpi-icon" style="background:#e0e7ff; color:#4338ca;"><i class="fa fa-users"></i></div>
      <div class="kpi-body">
        <div class="kpi-value"><?= number_format($kpis['total_customers']); ?></div>
        <div class="kpi-label">Total Pembeli &rarr;</div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="kpi-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm' . $nav_qs); ?>';" title="Klik untuk melihat urutan pelanggan berdasarkan Recency (Kebaruan Transaksi)">
      <div class="kpi-icon" style="background:#dbeafe; color:#2563eb;"><i class="fa fa-clock-o"></i></div>
      <div class="kpi-body">
        <div class="kpi-value"><?= number_format($kpis['avg_days']); ?> <small style="font-size:12px; color:#2563eb;">Hari</small></div>
        <div class="kpi-label">Recency (R: <?= $kpis['avg_r']; ?>/5)</div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="kpi-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm' . $nav_qs); ?>';" title="Klik untuk melihat urutan pelanggan berdasarkan Frekuensi Pembelian">
      <div class="kpi-icon" style="background:#dcfce7; color:#16a34a;"><i class="fa fa-repeat"></i></div>
      <div class="kpi-body">
        <div class="kpi-value"><?= $kpis['avg_orders']; ?>x <small style="font-size:12px; color:#16a34a;">Order</small></div>
        <div class="kpi-label">Frequency (F: <?= $kpis['avg_f']; ?>/5)</div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="kpi-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm/tracking'); ?>';" title="Klik untuk melihat analisis tren omset &amp; pertumbuhan di Tracking Bulanan">
      <div class="kpi-icon" style="background:#f3e8ff; color:#7c3aed;"><i class="fa fa-money"></i></div>
      <div class="kpi-body">
        <div class="kpi-value" style="font-size:17px;">Rp <?= number_format($kpis['avg_spend'], 0, ',', '.'); ?></div>
        <div class="kpi-label">Monetary (M: <?= $kpis['avg_m']; ?>/5) &rarr;</div>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================
     4. VISUAL DISTRIBUTION & 10 SEGMEN MATRIX
     ========================================== -->
<div class="row">
  <!-- Left: Donut Chart -->
  <div class="col-md-5 col-sm-12">
    <div class="section-card section-card-chart">
      <div class="card-title"><i class="fa fa-pie-chart" style="color:#6366f1;"></i> Distribusi Segmen Pelanggan</div>
      <div style="flex:1; position:relative; min-height:0;">
        <canvas id="rfmPieChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Right: 10 Segmen Cards Grid (Compact) -->
  <div class="col-md-7 col-sm-12">
    <div class="section-card section-card-segments">
      <div class="card-title" style="display:flex; justify-content:space-between; align-items:center;">
        <span><i class="fa fa-th-large" style="color:#6366f1;"></i> Matriks 10 Segmen RFM</span>
        <a href="<?= site_url('administrator/rfm' . $nav_qs); ?>" class="btn btn-xs btn-default" style="font-size:11px; font-weight:700;"><i class="fa fa-users"></i> Buka Semua Customer</a>
      </div>
      <div style="flex:1; overflow-y:auto; padding-right:4px;">
        <div class="segment-grid-compact">
          <?php foreach ($rfm_distribution['segments'] as $dist): 
            $seg_url = site_url('administrator/rfm?rfm_segment=' . urlencode($dist['segment']) . (!empty($product_filter) ? '&product=' . urlencode($product_filter) : '') . (!empty($period_filter) ? '&period=' . urlencode($period_filter) : '') . (!empty($category_filter) ? '&kategori=' . urlencode($category_filter) : ''));
          ?>
          <div class="seg-card-compact" role="button" tabindex="0" onclick="window.location.href='<?= $seg_url; ?>';" title="Klik untuk memfilter pelanggan segmen <?= htmlspecialchars($dist['segment']); ?>">
            <div class="seg-icon" style="background: <?= $dist['badge']['bg']; ?>; color: <?= $dist['badge']['color']; ?>;">
              <i class="fa <?= $dist['badge']['icon']; ?>"></i>
            </div>
            <div class="seg-info">
              <div class="seg-name" title="<?= htmlspecialchars($dist['segment']); ?>"><?= htmlspecialchars($dist['segment']); ?></div>
              <div class="seg-count"><?= number_format($dist['count']); ?> <span class="seg-pct">(<?= $dist['percentage']; ?>%)</span></div>
              <div class="seg-action">
                <a href="<?= $seg_url; ?>" onclick="event.stopPropagation();"><i class="fa fa-filter"></i> Lihat Pelanggan &rarr;</a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================
     5. TABBED EXPLORATION CENTER (COMPACT)
     ========================================== -->
<div class="rfm-tab-card">
  <ul class="nav nav-tabs" role="tablist">
    <li class="active">
      <a href="#tab-strategies" data-toggle="tab"><i class="fa fa-book text-primary"></i> 1. Strategi &amp; Threshold Segmen</a>
    </li>
    <li>
      <a href="#tab-tracking" data-toggle="tab"><i class="fa fa-line-chart text-success"></i> 2. Ringkasan Tren Bulanan (<?= count($monthly_tracking ?? []); ?> Bln)</a>
    </li>
    <li>
      <a href="#tab-products" data-toggle="tab"><i class="fa fa-shopping-bag text-warning"></i> 3. Top Produk RFM (<?= count($product_rfm_list['rows'] ?? []); ?>)</a>
    </li>
    <li>
      <a href="#tab-customers" data-toggle="tab"><i class="fa fa-users text-info"></i> 4. Preview Customer Terkini (Top 10)</a>
    </li>
  </ul>

  <div class="tab-content">
    <!-- TAB 1: STRATEGI & THRESHOLD -->
    <div class="tab-pane active" id="tab-strategies">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
        <span style="font-weight:700; color:#334155; font-size:13px;"><i class="fa fa-bullseye" style="color:#6366f1;"></i> Definisi Perilaku, Target Goal &amp; Rekomendasi Aksi Promo</span>
        <div>
          <a href="<?= site_url('administrator/rfm/matrix_rules'); ?>" class="btn btn-xs" style="background:#4338ca; color:#fff; font-weight:700; border-radius:6px; margin-right:6px;" title="Buka 125 Aturan Matriks RFM Lengkap">
            <i class="fa fa-table"></i> Buka 125 Matriks Aturan Lengkap
          </a>
          <button type="button" class="btn btn-xs" data-toggle="collapse" data-target="#collapse-thresholds" style="background:#f1f5f9; color:#475569; font-weight:700; border-radius:6px; margin-right:6px;">
            <i class="fa fa-sliders"></i> Lihat Aturan Threshold Skor (R, F, M)
          </button>
          <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-add-segment" style="font-weight:700; border-radius:6px;">
            <i class="fa fa-plus-circle"></i> Tambah Strategi
          </button>
        </div>
      </div>

      <!-- Collapsible Thresholds Rules -->
      <div class="collapse" id="collapse-thresholds" style="margin-bottom:16px;">
        <div class="row">
          <div class="col-md-4">
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px;">
              <strong style="font-size:12px; color:#2563eb;"><i class="fa fa-clock-o"></i> Threshold Recency (R)</strong>
              <table class="table table-compact" style="margin-top:6px; margin-bottom:0;">
                <thead><tr><th>Hari</th><th>Skor</th><th>Label</th></tr></thead>
                <tbody>
                  <?php $r_colors = ['#16a34a','#22c55e','#eab308','#f97316','#ef4444']; ?>
                  <?php foreach ($thresholds['recency'] as $i => $tr): ?>
                  <tr><td><?= $tr['range']; ?></td><td><span class="score-badge" style="background:<?= $r_colors[$i]; ?>"><?= $tr['score']; ?></span></td><td><?= $tr['label']; ?></td></tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-4">
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px;">
              <strong style="font-size:12px; color:#16a34a;"><i class="fa fa-repeat"></i> Threshold Frequency (F)</strong>
              <table class="table table-compact" style="margin-top:6px; margin-bottom:0;">
                <thead><tr><th>Order</th><th>Skor</th><th>Label</th></tr></thead>
                <tbody>
                  <?php $f_colors = ['#16a34a','#22c55e','#eab308','#f97316','#ef4444']; ?>
                  <?php foreach ($thresholds['frequency'] as $i => $tf): ?>
                  <tr><td><?= $tf['range']; ?></td><td><span class="score-badge" style="background:<?= $f_colors[$i]; ?>"><?= $tf['score']; ?></span></td><td><?= $tf['label']; ?></td></tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-4">
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px;">
              <strong style="font-size:12px; color:#7c3aed;"><i class="fa fa-money"></i> Threshold Monetary (M)</strong>
              <table class="table table-compact" style="margin-top:6px; margin-bottom:0;">
                <thead><tr><th>Nominal</th><th>Skor</th><th>Label</th></tr></thead>
                <tbody>
                  <?php $m_colors = ['#16a34a','#22c55e','#eab308','#f97316','#ef4444']; ?>
                  <?php foreach ($thresholds['monetary'] as $i => $tm): ?>
                  <tr><td><?= $tm['range']; ?></td><td><span class="score-badge" style="background:<?= $m_colors[$i]; ?>"><?= $tm['score']; ?></span></td><td><?= $tm['label']; ?></td></tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Segment Strategy Table -->
      <div class="table-responsive">
        <table class="table table-compact">
          <thead>
            <tr>
              <th style="width:18%;">Segmen</th>
              <th style="width:14%;">Customer</th>
              <th style="width:30%;">Goal (Target Perilaku)</th>
              <th style="width:30%;">Action (Strategi Promo &amp; CRM)</th>
              <th style="width:8%; text-align:center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $dist_map = [];
            foreach ($rfm_distribution['segments'] as $d) { $dist_map[$d['segment']] = $d; }
            foreach ($segments as $s): 
              $s_id = $s['id'] ?? '';
              $s_segment = $s['segment'] ?? '';
              $s_icon = $s['icon'] ?? 'fa-star';
              $s_color = $s['color'] ?? '#6366f1';
              $cnt = $dist_map[$s_segment]['count'] ?? 0;
              $pct = $dist_map[$s_segment]['percentage'] ?? 0;
            ?>
            <tr>
              <td>
                <span style="display:inline-flex; align-items:center; gap:6px;">
                  <span style="width:24px; height:24px; border-radius:6px; background:<?= $s_color; ?>15; color:<?= $s_color; ?>; display:inline-flex; align-items:center; justify-content:center; font-size:11px;">
                    <i class="fa <?= $s_icon; ?>"></i>
                  </span>
                  <strong><?= htmlspecialchars($s_segment); ?></strong>
                </span>
              </td>
              <td><strong><?= number_format($cnt); ?></strong> <span class="text-muted">(<?= $pct; ?>%)</span></td>
              <td><?= htmlspecialchars($s['goal'] ?? '-'); ?></td>
              <td><?= htmlspecialchars($s['action'] ?? '-'); ?></td>
              <td style="text-align:center; white-space:nowrap;">
                <button type="button" class="btn btn-xs btn-default btn-edit-segment" 
                  data-id="<?= $s_id; ?>" 
                  data-segment="<?= htmlspecialchars($s_segment, ENT_QUOTES); ?>" 
                  data-icon="<?= htmlspecialchars($s_icon, ENT_QUOTES); ?>" 
                  data-color="<?= htmlspecialchars($s_color, ENT_QUOTES); ?>" 
                  data-goal="<?= htmlspecialchars($s['goal'] ?? '', ENT_QUOTES); ?>" 
                  data-action="<?= htmlspecialchars($s['action'] ?? '', ENT_QUOTES); ?>" 
                  data-sort="<?= $s['sort_order'] ?? 0; ?>" title="Edit">
                  <i class="fa fa-edit text-primary"></i>
                </button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- TAB 2: RINGKASAN TREN BULANAN -->
    <div class="tab-pane" id="tab-tracking">
      <?php $track_data = $monthly_tracking ?? []; ?>
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
        <div>
          <strong style="color:#0f172a; font-size:13px;"><i class="fa fa-line-chart text-success"></i> Tren Performa Omset &amp; Pelanggan Bulanan</strong>
          <span class="text-muted" style="font-size:12px; margin-left:6px;">(Menampilkan ringkasan periode terbaru)</span>
        </div>
        <a href="<?= site_url('administrator/rfm/tracking'); ?>" class="btn btn-xs btn-success" style="font-weight:700; border-radius:6px; padding:5px 12px;">
          <i class="fa fa-external-link"></i> Buka Halaman Khusus Tracking Bulanan Lengkap &rarr;
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-compact">
          <thead>
            <tr>
              <th>Periode</th>
              <th style="text-align:center;">Pembeli Unik</th>
              <th style="text-align:center;">Transaksi (F)</th>
              <th style="text-align:center;">Qty</th>
              <th style="text-align:right;">Total Omset</th>
              <th style="text-align:center;">Pertumbuhan</th>
              <th style="text-align:right;">Profit</th>
              <th style="text-align:center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($track_data)): ?>
              <tr><td colspan="8" class="text-center text-muted" style="padding:20px;">Belum ada data bulanan untuk filter ini.</td></tr>
            <?php else: ?>
              <?php foreach (array_slice($track_data, 0, 6) as $mt): ?>
              <tr>
                <td><strong><i class="fa fa-calendar text-muted"></i> <?= htmlspecialchars($mt->period_label); ?></strong></td>
                <td style="text-align:center;"><span class="label label-info"><?= number_format($mt->unique_buyers); ?> cust</span></td>
                <td style="text-align:center;"><strong><?= number_format($mt->total_orders); ?>x</strong></td>
                <td style="text-align:center;"><?= number_format($mt->total_qty); ?> pcs</td>
                <td style="text-align:right; font-weight:700; color:#059669;">Rp <?= number_format($mt->total_spend, 0, ',', '.'); ?></td>
                <td style="text-align:center;">
                  <?php $gp = (float)($mt->mom_growth_pct ?? 0); ?>
                  <span class="label <?= $gp >= 0 ? 'label-success' : 'label-danger'; ?>"><?= $gp >= 0 ? '+' : ''; ?><?= $gp; ?>%</span>
                </td>
                <td style="text-align:right; font-weight:700; color:<?= ($mt->total_profit ?? 0) < 0 ? '#dc2626' : '#16a34a'; ?>;">
                  Rp <?= number_format($mt->total_profit ?? 0, 0, ',', '.'); ?>
                </td>
                <td style="text-align:center;">
                  <a href="<?= site_url('administrator/rfm/dashboard?period=' . urlencode($mt->ym_period) . (!empty($product_filter) ? '&product=' . urlencode($product_filter) : '')); ?>" class="btn btn-xs btn-default" style="font-size:11px;">
                    <i class="fa fa-filter"></i> Filter
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- TAB 3: TOP PRODUK RFM -->
    <div class="tab-pane" id="tab-products">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
        <div>
          <strong style="color:#0f172a; font-size:13px;"><i class="fa fa-shopping-bag text-warning"></i> Top 10 Produk Berdasarkan Kontribusi Omset &amp; Pembeli</strong>
        </div>
        <a href="<?= site_url('administrator/crm_segments/product_rfm'); ?>" class="btn btn-xs btn-warning" style="font-weight:700; border-radius:6px; padding:5px 12px; color:#1e293b;">
          <i class="fa fa-external-link"></i> Buka Analisis Tren Produk Lengkap &rarr;
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-compact">
          <thead>
            <tr>
              <th style="width:4%;">#</th>
              <th>Nama Produk</th>
              <th style="text-align:center;">Pembeli</th>
              <th style="text-align:center;">Total Order</th>
              <th style="text-align:center;">Qty</th>
              <th style="text-align:right;">Total Omset</th>
              <th style="text-align:center;">Recency Terakhir</th>
              <th style="text-align:center;">Status Segmen</th>
              <th style="text-align:center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $top_prods = array_slice($product_rfm_list['rows'] ?? [], 0, 10);
              if (empty($top_prods)): 
            ?>
              <tr><td colspan="9" class="text-center text-muted" style="padding:20px;">Belum ada data produk.</td></tr>
            <?php else: ?>
              <?php $p_i = 1; foreach ($top_prods as $pr): ?>
              <tr>
                <td><?= $p_i++; ?></td>
                <td><strong><?= htmlspecialchars($pr->item_name); ?></strong></td>
                <td style="text-align:center;"><span class="badge bg-purple"><?= number_format($pr->total_customers); ?></span></td>
                <td style="text-align:center;"><strong><?= number_format($pr->total_orders); ?>x</strong></td>
                <td style="text-align:center;"><?= number_format($pr->total_qty); ?></td>
                <td style="text-align:right; font-weight:700; color:#16a34a;">Rp <?= number_format($pr->total_spend, 0, ',', '.'); ?></td>
                <td style="text-align:center;"><?= $pr->recency_days; ?> hr lalu</td>
                <td style="text-align:center;">
                  <span class="label" style="background:<?= $pr->status_badge['bg']; ?>; color:<?= $pr->status_badge['color']; ?>; font-size:10.5px; padding:3px 7px;">
                    <i class="fa <?= $pr->status_badge['icon']; ?>"></i> <?= $pr->status_badge['label']; ?>
                  </span>
                </td>
                <td style="text-align:center;">
                  <a href="<?= site_url('administrator/rfm?product=' . urlencode($pr->item_name)); ?>" class="btn btn-xs btn-primary" style="font-size:11px;">
                    <i class="fa fa-users"></i> Filter
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- TAB 4: PREVIEW CUSTOMER AKTIF -->
    <div class="tab-pane" id="tab-customers">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px;">
        <div>
          <strong style="color:#0f172a; font-size:13px;"><i class="fa fa-users text-info"></i> Sampel 10 Pelanggan Terkini</strong>
          <span class="text-muted" style="font-size:12px; margin-left:6px;">(Total <?= count($filtered_customers); ?> pelanggan dalam database)</span>
        </div>
        <a href="<?= site_url('administrator/rfm' . (!empty($product_filter) ? '?product=' . urlencode($product_filter) : '')); ?>" class="btn btn-xs btn-info" style="font-weight:700; border-radius:6px; padding:5px 12px;">
          <i class="fa fa-external-link"></i> Buka Halaman Lengkap Semua Customer &rarr;
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-compact">
          <thead>
            <tr>
              <th style="width:4%;">#</th>
              <th>Nama Pembeli</th>
              <th>No. Telepon</th>
              <th style="text-align:center;">Frekuensi</th>
              <th style="text-align:right;">Total Belanja</th>
              <th style="text-align:center;">Terakhir Beli</th>
              <th style="text-align:center;">Skor RFM</th>
              <th style="text-align:center;">Segmen</th>
              <th style="text-align:center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $sample_custs = array_slice($filtered_customers, 0, 10);
              if (empty($sample_custs)): 
            ?>
              <tr><td colspan="9" class="text-center text-muted" style="padding:20px;">Tidak ada customer ditemukan.</td></tr>
            <?php else: ?>
              <?php 
              $c_i = 1; 
              $score_colors = [1 => '#ef4444', 2 => '#f97316', 3 => '#eab308', 4 => '#22c55e', 5 => '#16a34a'];
              foreach ($sample_custs as $c): 
                $rfm = $c->rfm;
                $badge = $rfm['badge'];
              ?>
              <tr>
                <td><?= $c_i++; ?></td>
                <td><strong><?= htmlspecialchars($c->customer_nama); ?></strong></td>
                <td><small><i class="fa fa-phone text-muted"></i> <?= htmlspecialchars($c->customer_phone); ?></small></td>
                <td style="text-align:center;"><strong><?= $c->total_orders; ?>x</strong></td>
                <td style="text-align:right; font-weight:700; color:#059669;">Rp <?= number_format($c->total_spend, 0, ',', '.'); ?></td>
                <td style="text-align:center;"><?= $rfm['days_since_last']; ?> hr lalu</td>
                <td style="text-align:center;">
                  <span class="score-badge" style="background:<?= $score_colors[$rfm['r_score']]; ?>"><?= $rfm['r_score']; ?></span>
                  <span class="score-badge" style="background:<?= $score_colors[$rfm['f_score']]; ?>"><?= $rfm['f_score']; ?></span>
                  <span class="score-badge" style="background:<?= $score_colors[$rfm['m_score']]; ?>"><?= $rfm['m_score']; ?></span>
                </td>
                <td style="text-align:center;">
                  <span class="segment-pill" style="background:<?= $badge['bg']; ?>; color:<?= $badge['color']; ?>; border:1px solid <?= $badge['border']; ?>;">
                    <i class="fa <?= $badge['icon']; ?>"></i> <?= htmlspecialchars($rfm['segment']); ?>
                  </span>
                </td>
                <td style="text-align:center; white-space:nowrap;">
                  <a href="<?= site_url('administrator/rfm/customer_detail?phone=' . urlencode($c->customer_phone)); ?>" class="btn btn-xs btn-default" title="Detail"><i class="fa fa-user"></i></a>
                  <?php 
                    $clean_p = preg_replace('/[^0-9]/', '', (string)$c->customer_phone);
                    if (!empty($clean_p)):
                      $wa_p = (substr($clean_p, 0, 1) === '0') ? ('62' . substr($clean_p, 1)) : $clean_p;
                  ?>
                  <a href="https://wa.me/<?= $wa_p; ?>" target="_blank" class="btn btn-xs btn-success" title="Chat WA"><i class="fa fa-whatsapp"></i></a>
                  <?php endif; ?>
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

<!-- ==========================================
     6. JAVASCRIPT INITIALIZATION
     ========================================== -->
<script>
window.addEventListener('DOMContentLoaded', function() {
  var segData = <?= json_encode(array_map(function($d) { return ['segment' => $d['segment'], 'count' => $d['count'], 'color' => $d['badge']['color']]; }, $rfm_distribution['segments'])); ?>;
  var labels = segData.map(function(d) { return d.segment; });
  var counts = segData.map(function(d) { return d.count; });
  var colors = ['#f59e0b','#10b981','#6366f1','#3b82f6','#8b5cf6','#64748b','#f97316','#ef4444','#ec4899','#6b7280'];

  var pieCtx = document.getElementById('rfmPieChart');
  if (pieCtx) {
    new Chart(pieCtx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          data: counts,
          backgroundColor: colors,
          borderWidth: 2,
          borderColor: '#fff',
          hoverOffset: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
            labels: {
              font: { size: 11, weight: '600' },
              padding: 8,
              boxWidth: 12,
              usePointStyle: true
            }
          }
        },
        cutout: '62%'
      }
    });
  }

  // Edit Segment Strategy Event Handler
  $(document).on('click', '.btn-edit-segment', function() {
    var id = $(this).data('id');
    var segment = $(this).data('segment');
    var icon = $(this).data('icon') || 'fa-star';
    var color = $(this).data('color') || '#6366f1';
    var goal = $(this).data('goal');
    var action = $(this).data('action');
    var sort = $(this).data('sort');

    $('#edit_seg_id').val(id);
    $('#edit_seg_segment').val(segment);
    $('#edit_seg_icon').val(icon);
    $('#edit_seg_color').val(color);
    $('#edit_seg_sort').val(sort);
    $('#edit_seg_goal').val(goal);
    $('#edit_seg_action').val(action);

    $('#edit_seg_name_display').text(segment);
    $('#edit_seg_badge_icon').css('background-color', color);
    $('#edit_seg_icon_i').attr('class', 'fa ' + icon);

    $('#modal-edit-segment').modal('show');
  });
});
</script>

<!-- ==========================================
     7. MODALS (TAMBAH SEGMEN, EDIT SEGMEN, IMPORT)
     ========================================== -->
<!-- MODAL TAMBAH STRATEGI SEGMEN -->
<div class="modal fade" id="modal-add-segment" tabindex="-1" role="dialog" aria-labelledby="modalAddSegmentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:520px; margin:40px auto;">
    <div class="modal-content" style="border-radius:14px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.15); overflow:hidden;">
      <form method="POST" action="<?= site_url('administrator/rfm/save_segment_strategy'); ?>">
        <div class="modal-header" style="background:linear-gradient(135deg, #1e1b4b, #312e81, #4338ca); color:#fff; padding:16px 20px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.8;">&times;</button>
          <h4 class="modal-title" id="modalAddSegmentLabel" style="font-weight:700; font-size:16px; margin:0;">
            <i class="fa fa-plus-circle" style="color:#818cf8;"></i> Tambah Strategi Segmen Baru
          </h4>
        </div>
        <div class="modal-body" style="padding:20px;">
          <div class="form-group">
            <label style="font-weight:700; color:#1e1b4b; font-size:12px;">Nama Segmen RFM:</label>
            <input type="text" name="segment" class="form-control" placeholder="Contoh: VIP Champions" required style="border-radius:6px;">
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-weight:700; color:#1e1b4b; font-size:12px;">Ikon (FontAwesome):</label>
                <input type="text" name="icon" class="form-control" value="fa-star" required style="border-radius:6px;">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-weight:700; color:#1e1b4b; font-size:12px;">Warna (HEX):</label>
                <input type="color" name="color" class="form-control" value="#6366f1" style="border-radius:6px; height:34px; padding:2px 4px;">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label style="font-weight:700; color:#1e1b4b; font-size:12px;">Goal (Target Perilaku):</label>
            <textarea name="goal" class="form-control" rows="2" placeholder="Contoh: Pertahankan loyalitas dan tingkatkan basket size" style="border-radius:6px;"></textarea>
          </div>
          <div class="form-group">
            <label style="font-weight:700; color:#1e1b4b; font-size:12px;">Action (Strategi Promo):</label>
            <textarea name="action" class="form-control" rows="2" placeholder="Contoh: Berikan apresiasi VIP dan promo early bird" style="border-radius:6px;"></textarea>
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label style="font-weight:700; color:#1e1b4b; font-size:12px;">Urutan Tampilan:</label>
            <input type="number" name="sort_order" class="form-control" value="0" style="border-radius:6px;">
          </div>
        </div>
        <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:12px 20px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:6px; font-weight:600;">Batal</button>
          <button type="submit" class="btn btn-primary" style="border-radius:6px; font-weight:700;"><i class="fa fa-save"></i> Simpan Segmen</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT STRATEGI SEGMEN -->
<div class="modal fade" id="modal-edit-segment" tabindex="-1" role="dialog" aria-labelledby="modalEditSegmentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:520px; margin:40px auto;">
    <div class="modal-content" style="border-radius:14px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.15); overflow:hidden;">
      <form method="POST" action="<?= site_url('administrator/rfm/save_segment_strategy'); ?>">
        <input type="hidden" name="id" id="edit_seg_id">
        <input type="hidden" name="segment" id="edit_seg_segment">
        <input type="hidden" name="icon" id="edit_seg_icon">
        <input type="hidden" name="color" id="edit_seg_color">
        <input type="hidden" name="sort_order" id="edit_seg_sort">
        <div class="modal-header" style="background:linear-gradient(135deg, #0284c7, #0369a1); color:#fff; padding:16px 20px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.8;">&times;</button>
          <h4 class="modal-title" id="modalEditSegmentLabel" style="font-weight:700; font-size:16px; margin:0;">
            <i class="fa fa-edit" style="color:#7dd3fc;"></i> Edit Strategi Segmen
          </h4>
        </div>
        <div class="modal-body" style="padding:20px;">
          <!-- Informasi Segmen (Read-only Badge Preview) -->
          <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px 16px; margin-bottom:18px; display:flex; align-items:center; gap:12px;">
            <div id="edit_seg_badge_icon" style="width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:18px; flex-shrink:0; background:#6366f1;">
              <i class="fa fa-star" id="edit_seg_icon_i"></i>
            </div>
            <div>
              <div style="font-size:11px; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; font-weight:700;">Segmen RFM:</div>
              <div id="edit_seg_name_display" style="font-size:16px; font-weight:800; color:#0f172a;"></div>
            </div>
          </div>

          <div class="form-group">
            <label style="font-weight:700; color:#1e1b4b; font-size:12px;"><i class="fa fa-bullseye text-primary"></i> Goal (Target Perilaku):</label>
            <textarea name="goal" id="edit_seg_goal" class="form-control" rows="3" style="border-radius:8px; font-size:13px;" placeholder="Tentukan target perilaku untuk segmen ini..."></textarea>
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label style="font-weight:700; color:#1e1b4b; font-size:12px;"><i class="fa fa-paper-plane text-success"></i> Action (Strategi Promo):</label>
            <textarea name="action" id="edit_seg_action" class="form-control" rows="3" style="border-radius:8px; font-size:13px;" placeholder="Tentukan tindakan dan strategi promo yang tepat..."></textarea>
          </div>
        </div>
        <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:12px 20px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:6px; font-weight:600;">Batal</button>
          <button type="submit" class="btn btn-info" style="border-radius:6px; font-weight:700; background:#0284c7; border-color:#0284c7;"><i class="fa fa-check"></i> Update Segmen</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL IMPORT EXCEL -->
<div class="modal fade" id="modal-import-excel" tabindex="-1" role="dialog" aria-labelledby="modalImportExcelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:540px; margin:40px auto;">
    <div class="modal-content" style="border-radius:14px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.15); overflow:hidden;">
      <form method="POST" action="<?= site_url('administrator/rfm/import_excel'); ?>" enctype="multipart/form-data" id="form-import-excel" onsubmit="document.getElementById('btn-submit-import').disabled=true; document.getElementById('btn-submit-import').innerHTML='<i class=\'fa fa-spinner fa-spin\'></i> Mengimport Data...';">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header" style="background:linear-gradient(135deg, #1e1b4b, #312e81, #4338ca); color:#fff; padding:16px 20px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.8;">&times;</button>
          <h4 class="modal-title" id="modalImportExcelLabel" style="font-weight:700; font-size:16px; margin:0;">
            <i class="fa fa-file-excel-o" style="color:#34d399;"></i> Import Data Excel / CSV
          </h4>
        </div>
        <div class="modal-body" style="padding:20px;">
          <div style="background:#eff6ff; border-left:4px solid #3b82f6; border-radius:8px; padding:10px 12px; margin-bottom:14px; font-size:12px; color:#1e40af;">
            <i class="fa fa-info-circle"></i> <strong>Auto-Detect:</strong> Mengenali otomatis data transaksi marketplace atau 125 aturan matriks RFM.
          </div>

          <div class="form-group">
            <label style="font-weight:700; color:#1e1b4b; font-size:12px;">Tipe Data Import:</label>
            <select name="import_type" class="form-control" style="border-radius:6px; font-weight:600; font-size:12.5px;">
              <option value="auto">✨ Deteksi Otomatis (Rekomendasi)</option>
              <option value="transactions">🛒 Data Transaksi Penjualan (Shopee, Tokopedia, CSV)</option>
              <option value="matrix">📊 Aturan Matriks RFM &amp; Segmentasi</option>
            </select>
          </div>

          <div class="form-group">
            <label style="font-weight:700; color:#1e1b4b; font-size:12px;">Pilih File (.xlsx, .xls, .csv):</label>
            <div style="border:2px dashed #a5b4fc; background:#faf5ff; border-radius:10px; padding:16px; text-align:center;">
              <i class="fa fa-cloud-upload" style="font-size:30px; color:#6366f1; display:block; margin-bottom:6px;"></i>
              <input type="file" name="file_excel" class="form-control" accept=".xlsx, .xls, .csv" required style="max-width:300px; margin:0 auto; padding:4px; font-size:12px; border-radius:6px;">
            </div>
          </div>

          <div style="background:#f8fafc; border-radius:8px; padding:10px 12px; border:1px solid #e2e8f0; font-size:11.5px;">
            <span style="font-weight:700; color:#475569; display:block; margin-bottom:6px;"><i class="fa fa-download"></i> Unduh Template:</span>
            <div style="display:flex; flex-wrap:wrap; gap:6px;">
              <a href="<?= site_url('administrator/rfm/download_template_transactions'); ?>" class="btn btn-default btn-xs" style="border-radius:6px; font-size:11px;"><i class="fa fa-file-text-o text-primary"></i> Template Transaksi</a>
              <a href="<?= site_url('administrator/rfm/download_template_matrix'); ?>" class="btn btn-default btn-xs" style="border-radius:6px; font-size:11px;"><i class="fa fa-table text-success"></i> Template Matriks</a>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:12px 20px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:6px; font-weight:600;">Batal</button>
          <button type="submit" id="btn-submit-import" class="btn btn-primary" style="border-radius:6px; font-weight:700;"><i class="fa fa-upload"></i> Mulai Import Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
