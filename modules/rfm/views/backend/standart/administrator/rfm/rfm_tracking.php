<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/plugins/select2/select2.min.css">
<link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/plugins/datepicker/datepicker3.css">
<script src="<?= BASE_ASSET; ?>admin-lte/plugins/select2/select2.full.min.js"></script>
<script src="<?= BASE_ASSET; ?>admin-lte/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<style>
:root {
  --rfm-primary: #6366f1;
  --rfm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
  --card-radius: 14px;
}

.rfm-tracking-wrapper {
  padding: 0 0 30px 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  color: #1e293b;
}

/* ========================================================
   LAYER 1: HEADER & LOCATION NAVIGATION (Standard RFM Tabs)
   ======================================================== */
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

/* Navigation Tab Bar - Unified Across All RFM Pages */
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

/* ========================================================
   LAYER 2: MAIN CONTAINER CARD (Matches Screenshot)
   ======================================================== */
.rfm-main-card {
  background: #ffffff;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  box-shadow: var(--card-shadow);
  padding: 24px;
  margin-bottom: 24px;
}

/* Card Header with Red Round Icon */
.rfm-card-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 22px;
  flex-wrap: wrap;
}
.rfm-icon-badge {
  width: 48px;
  height: 48px;
  background: #ef4444;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  font-size: 20px;
  box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
  flex-shrink: 0;
}
.rfm-title-area h3 {
  margin: 0 0 4px 0;
  font-size: 20px;
  font-weight: 800;
  color: #1e293b;
}
.rfm-sub-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: #64748b;
  font-weight: 500;
}
.rfm-badge-orange {
  background: #ea580c;
  color: #ffffff;
  font-size: 11px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 12px;
  letter-spacing: 0.3px;
}

/* Filter Form */
.rfm-filter-form {
  position: relative;
  background: #ffffff;
  margin-bottom: 20px;
}
.rfm-filter-form .rfm-filter-label-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 6px;
  min-height: 20px;
  gap: 6px;
  white-space: nowrap;
}
.rfm-filter-form label {
  font-size: 12px;
  font-weight: 700;
  color: #334155;
  margin: 0;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  white-space: nowrap;
}
.rfm-quick-pill {
  font-size: 10.5px;
  font-weight: 700;
  padding: 1px 7px;
  border-radius: 4px;
  text-decoration: none !important;
  display: inline-flex;
  align-items: center;
  line-height: 1.4;
  white-space: nowrap;
  transition: all 0.15s ease;
}
.rfm-quick-pill:hover {
  filter: brightness(0.92);
  transform: translateY(-0.5px);
}
.rfm-pill-indigo { background: #ede9fe; color: #6366f1 !important; }
.rfm-pill-green  { background: #d1fae5; color: #059669 !important; }
.rfm-pill-blue   { background: #e0f2fe; color: #0284c7 !important; }
.rfm-pill-gray   { background: #f1f5f9; color: #64748b !important; }

/* Normalize Select2 inside Filter Form */
.rfm-filter-form .select2-container .select2-selection--single {
  height: 36px !important;
  border-radius: 6px !important;
  border: 1px solid #cbd5e1 !important;
  display: flex !important;
  align-items: center !important;
}
.rfm-filter-form .select2-container--default .select2-selection--single .select2-selection__rendered {
  line-height: 34px !important;
  font-size: 12.5px !important;
  font-weight: 500 !important;
  color: #334155 !important;
  padding-left: 10px !important;
}
.rfm-filter-form .select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 34px !important;
}
.rfm-filter-form .select2-container--default .select2-selection--multiple {
  min-height: 36px !important;
  border-radius: 6px !important;
  border: 1px solid #cbd5e1 !important;
}
.rfm-filter-form .select2-container--default .select2-selection--multiple .select2-selection__rendered {
  padding: 2px 6px !important;
  font-size: 12.5px !important;
}
.rfm-filter-form .select2-container--default .select2-selection--multiple .select2-selection__choice {
  background-color: #e0f2fe !important;
  border: 1px solid #bae6fd !important;
  color: #0369a1 !important;
  border-radius: 4px !important;
  padding: 1px 6px !important;
  font-size: 11px !important;
  font-weight: 600 !important;
  margin-top: 3px !important;
}
.rfm-btn-search {
  background: #0284c7;
  color: #ffffff;
  border: none;
  border-radius: 6px;
  font-weight: 700;
  font-size: 13px;
  height: 36px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  transition: all 0.2s ease;
  box-shadow: 0 2px 4px rgba(2, 132, 199, 0.25);
  cursor: pointer;
  white-space: nowrap;
}
.rfm-btn-search:hover {
  background: #0369a1;
  color: #ffffff;
}

/* Data Awal KPI Mini Card */
/* Data Awal & KPI Summary Grid */
.rfm-summary-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 14px;
  margin-bottom: 20px;
}
.rfm-summary-card {
  flex: 1 1 180px;
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 14px 20px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
  transition: all 0.2s ease;
}
.rfm-summary-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
  transform: translateY(-1px);
}
.rfm-summary-card .card-lbl {
  font-size: 12px;
  font-weight: 600;
  color: #64748b;
  margin-bottom: 5px;
  display: flex;
  align-items: center;
  gap: 6px;
}
.rfm-summary-card .card-val {
  font-size: 26px;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.1;
  margin-bottom: 4px;
}
.rfm-summary-card .card-sub {
  font-size: 11.5px;
  color: #94a3b8;
  font-weight: 500;
}

/* Chart Container Box */
.rfm-chart-box {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 20px 22px;
  margin-bottom: 24px;
}
.rfm-chart-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 14px;
  flex-wrap: wrap;
  gap: 10px;
}
.rfm-chart-header h4 {
  margin: 0;
  font-size: 15px;
  font-weight: 800;
  color: #1e293b;
  display: flex;
  align-items: center;
  gap: 8px;
}

/* Data Table Two-Tier Header Styling */
.table-rfm-custom {
  border-collapse: separate;
  border-spacing: 0;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  overflow: hidden;
  font-size: 12.5px;
  margin-bottom: 0;
}
.table-rfm-custom th {
  background: #f8fafc;
  color: #334155;
  font-weight: 700;
  font-size: 11.5px;
  border-color: #e2e8f0 !important;
  vertical-align: middle !important;
  text-align: center;
  white-space: nowrap;
  padding: 10px 12px !important;
}
.table-rfm-custom td {
  padding: 10px 12px !important;
  border-color: #f1f5f9 !important;
  vertical-align: middle !important;
  color: #1e293b;
}
.table-rfm-custom tr:hover td {
  background-color: #f8fafc !important;
}
.cell-num {
  text-align: center;
  font-weight: 700;
}
.cell-num a {
  color: #0284c7;
  text-decoration: none;
  font-weight: 700;
  display: inline-block;
  cursor: pointer;
  transition: color 0.15s ease;
}
.cell-num a:hover {
  color: #0369a1;
  text-decoration: underline;
}
.trend-pill {
  display: block;
  font-size: 10.5px;
  font-weight: 600;
  margin-top: 2px;
  white-space: nowrap;
}
.trend-pill.up { color: #16a34a; }
.trend-pill.down { color: #dc2626; }
.trend-pill.neutral { color: #94a3b8; }

/* Modal Styling */
#modal-tracking-drilldown .modal-header {
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  border-radius: 12px 12px 0 0;
  padding: 16px 20px;
}
#modal-tracking-drilldown .modal-content {
  border-radius: 12px;
  border: none;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* ========================================================
   BULLETPROOF DATEPICKER POPUP FIX (Eliminates raw text bugs)
   ======================================================== */
#ui-datepicker-div {
  display: none;
  position: fixed !important;
  z-index: 99999 !important;
  background: #ffffff !important;
  border: 1px solid #cbd5e1 !important;
  border-radius: 12px !important;
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.16) !important;
  padding: 14px !important;
  width: 280px !important;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}
#ui-datepicker-div .ui-datepicker-header {
  display: flex !important;
  justify-content: space-between !important;
  align-items: center !important;
  position: relative !important;
  padding: 4px 6px 10px 6px !important;
  border-bottom: 1px solid #f1f5f9 !important;
}
#ui-datepicker-div .ui-datepicker-title {
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 4px !important;
  margin: 0 !important;
  padding: 0 !important;
}
#ui-datepicker-div .ui-datepicker-title select {
  font-size: 12px !important;
  font-weight: 700 !important;
  color: #1e293b !important;
  background-color: #ffffff !important;
  border: 1px solid #cbd5e1 !important;
  border-radius: 6px !important;
  padding: 3px 6px !important;
  height: 28px !important;
  cursor: pointer !important;
  outline: none !important;
}
#ui-datepicker-div .ui-datepicker-title select.ui-datepicker-month {
  max-width: 120px !important;
}
#ui-datepicker-div .ui-datepicker-title select.ui-datepicker-year {
  max-width: 80px !important;
}
#ui-datepicker-div .ui-datepicker-title select:focus {
  border-color: #0284c7 !important;
  box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.2) !important;
}
#ui-datepicker-div .ui-datepicker-prev,
#ui-datepicker-div .ui-datepicker-next {
  cursor: pointer !important;
  width: 26px !important;
  height: 26px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  border-radius: 6px !important;
  background: #f1f5f9 !important;
  color: #475569 !important;
  text-decoration: none !important;
  font-size: 11px !important;
  font-weight: bold !important;
}
#ui-datepicker-div .ui-datepicker-prev:hover,
#ui-datepicker-div .ui-datepicker-next:hover {
  background: #e2e8f0 !important;
  color: #0f172a !important;
}
#ui-datepicker-div .ui-datepicker-calendar {
  width: 100% !important;
  border-collapse: separate !important;
  border-spacing: 2px !important;
  margin-top: 8px !important;
}
#ui-datepicker-div .ui-datepicker-calendar th {
  text-align: center !important;
  font-size: 11px !important;
  font-weight: 700 !important;
  color: #64748b !important;
  padding: 4px !important;
}
#ui-datepicker-div .ui-datepicker-calendar td {
  padding: 2px !important;
  text-align: center !important;
}
#ui-datepicker-div .ui-datepicker-calendar td a {
  display: block !important;
  padding: 6px 0 !important;
  border-radius: 6px !important;
  color: #1e293b !important;
  text-decoration: none !important;
  font-size: 12px !important;
  font-weight: 600 !important;
}
#ui-datepicker-div .ui-datepicker-calendar td a:hover {
  background: #0284c7 !important;
  color: #ffffff !important;
}
#ui-datepicker-div .ui-datepicker-calendar td.ui-datepicker-current-day a {
  background: #0284c7 !important;
  color: #ffffff !important;
  font-weight: 700 !important;
}

/* Bootstrap Datepicker Popup Styling */
.datepicker.datepicker-dropdown {
  z-index: 99999 !important;
  background: #ffffff !important;
  border: 1px solid #cbd5e1 !important;
  border-radius: 12px !important;
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.16) !important;
  padding: 12px !important;
}
.datepicker table tr td.active,
.datepicker table tr td.active:hover {
  background: #0284c7 !important;
  border-radius: 6px !important;
}

/* Mobile Responsiveness */
@media (max-width: 991px) {
  .rfm-header-nav { padding: 18px 20px; }
}
@media (max-width: 767px) {
  .rfm-header-nav { padding: 16px 14px; border-radius: 12px; }
  .rfm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; }
  .rfm-header-nav .header-title h2 { font-size: 18px; }
  .rfm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .rfm-header-nav .action-tools .btn { font-size: 11px; padding: 6px 10px; flex: 1 1 auto; min-width: 100px; }
  .rfm-header-nav .nav-tabs-bar { padding-top: 10px; gap: 6px; }
  .rfm-header-nav .nav-tab-btn { padding: 7px 12px; font-size: 11.5px; }
  .rfm-main-card { padding: 16px; }

  /* Mobile Datepicker Centered Modal Fix */
  #ui-datepicker-div {
    position: fixed !important;
    top: 50% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    width: 310px !important;
    max-width: 92vw !important;
    z-index: 999999 !important;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35) !important;
    border-radius: 14px !important;
  }
}
</style>

<?php
  // Pre-calculate variables
  $is_filtered = !empty($is_filtered);
  $dt = $daily_tracking ?? [];
  $dt_rows = $dt['daily_rows'] ?? [];
  $dt_chart_rows = $dt['chart_rows'] ?? ($dt['daily_rows_asc'] ?? $dt_rows);
  $dt_data_awal = $dt['data_awal'] ?? 0;
  $dt_total_customers = $dt['total_customers'] ?? count($dt_rows);
  $dt_total_orders = $dt['total_orders'] ?? 0;
  $dt_date_from = $is_filtered ? ($dt['date_from_view'] ?? ($date_from ?? '')) : '';
  $dt_date_to = $is_filtered ? ($dt['date_to_view'] ?? ($date_to ?? '')) : '';
  $dt_total_items = $dt['total_items'] ?? count($dt_rows);
  $all_segs = $dt['all_segments'] ?? [
    'New Customers', 'Need Attention', 'Frequent Low Value', 'Hibernating',
    'At Risk Customers', 'Cant Lose Them', 'Potential Loyalist', 'Loyal Customers',
    'Big Spenders', 'Champion'
  ];

  $nav_params = array_filter([
    'date_from' => $is_filtered ? $dt_date_from : '',
    'date_to' => $is_filtered ? $dt_date_to : '',
    'kategori' => $category_filter ?? '',
    'product' => $product_filter ?? '',
    'filtered' => $is_filtered ? '1' : ''
  ]);
  $nav_qs = !empty($nav_params) ? '?' . http_build_query($nav_params) : '';
?>

<div class="rfm-tracking-wrapper">

  <!-- ==========================================
       LAYER 1: HEADER & UNIFIED LOCATION NAVIGATION
       (Matches rfm_dashboard.php, rfm_cohort.php, etc.)
       ========================================== -->
  <div class="rfm-header-nav">
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> Analisis RFM <i class="fa fa-angle-right"></i> <span>Tracking RFM</span>
        </div>
        <h2><i class="fa fa-line-chart" style="color:#818cf8;"></i> RFM Tracking Harian</h2>
        <p>Ringkasan segmentasi Recency (Kebaruan), Frequency (Frekuensi), dan Monetary (Nominal Belanja) pergerakan 10 segmen harian</p>
      </div>

      <div class="action-tools">
        <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn" style="background:#25D366; color:#fff;" title="Broadcast WA"><i class="fa fa-bullhorn"></i> Broadcast WA</a>
        <button type="button" class="btn" data-toggle="modal" data-target="#modal-import-excel" style="background:#10b981; color:#fff; box-shadow:0 4px 12px rgba(16,185,129,0.35);"><i class="fa fa-file-excel-o"></i> Import Excel Data</button>
        <a href="<?= site_url('administrator/rfm/export_customers' . $nav_qs); ?>" class="btn" style="background:rgba(255,255,255,0.18); color:#fff; border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-download"></i> Export CSV</a>
      </div>
    </div>

    <!-- Navigation Tab Bar (6 Standard Tabs) -->
    <div class="nav-tabs-bar">
      <a href="<?= site_url('administrator/rfm/dashboard' . $nav_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-tachometer"></i> 1. Dashboard RFM
      </a>
      <a href="<?= site_url('administrator/rfm' . $nav_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-users"></i> 2. Daftar Customer
      </a>
      <a href="<?= site_url('administrator/rfm/tracking'); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-line-chart"></i> 3. Tracking RFM
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
       LAYER 2: MAIN CONTAINER CARD (Matches Screenshot)
       ========================================== -->
  <div class="rfm-main-card">

    <!-- Card Header: Red Circle Icon + Title + Orange Badge -->
    <div class="rfm-card-header">
      <div class="rfm-icon-badge">
        <i class="fa fa-th-list"></i>
      </div>
      <div class="rfm-title-area">
        <h3>RFM Tracking</h3>
        <div class="rfm-sub-badge">
          <span>Register All Customer</span>
          <?php if ($is_filtered): ?>
            <span class="rfm-badge-orange"><?= $dt_total_items; ?> Item</span>
          <?php else: ?>
            <span class="badge" style="background:#94a3b8; font-size:11px;">Belum Difilter</span>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- ==========================================
         FILTER ROW (Matches Screenshot Exactly)
         ========================================== -->
    <form method="GET" action="<?= site_url('administrator/rfm/tracking'); ?>" id="form-rfm-tracking" class="rfm-filter-form" autocomplete="off">
      <input type="hidden" name="filtered" value="1">
      <div class="row" style="margin:0 -6px; display:flex; align-items:flex-end; flex-wrap:wrap;">

        <!-- Tanggal Awal -->
        <div style="flex:1 1 135px; max-width:175px; min-width:130px; padding:0 6px; margin-bottom:14px;">
          <div class="rfm-filter-label-row">
            <label><i class="fa fa-calendar" style="color:#0284c7;"></i> Tanggal Awal <span style="color:#ef4444;" title="Wajib Diisi">*</span></label>
          </div>
          <div class="input-group" style="width:100%;">
            <input type="text" name="date_from" id="filter_date_from" class="form-control rfm-datepicker" value="<?= $is_filtered ? htmlspecialchars($dt_date_from) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" required style="border-radius:6px 0 0 6px; font-weight:600; height:36px; border-color:#cbd5e1;">
            <span class="input-group-addon btn-trigger-datepicker ui-datepicker-trigger" data-target="#filter_date_from" style="border-radius:0 6px 6px 0; background:#f8fafc; border-color:#cbd5e1; color:#64748b; cursor:pointer;" title="Buka Kalender">
              <i class="fa fa-calendar" style="pointer-events:none;"></i>
            </span>
          </div>
        </div>

        <!-- Tanggal Akhir -->
        <div style="flex:1 1 135px; max-width:175px; min-width:130px; padding:0 6px; margin-bottom:14px;">
          <div class="rfm-filter-label-row">
            <label><i class="fa fa-calendar" style="color:#0284c7;"></i> Tanggal Akhir <span style="color:#ef4444;" title="Wajib Diisi">*</span></label>
          </div>
          <div class="input-group" style="width:100%;">
            <input type="text" name="date_to" id="filter_date_to" class="form-control rfm-datepicker" value="<?= $is_filtered ? htmlspecialchars($dt_date_to) : ''; ?>" placeholder="DD/MM/YYYY" autocomplete="off" required style="border-radius:6px 0 0 6px; font-weight:600; height:36px; border-color:#cbd5e1;">
            <span class="input-group-addon btn-trigger-datepicker ui-datepicker-trigger" data-target="#filter_date_to" style="border-radius:0 6px 6px 0; background:#f8fafc; border-color:#cbd5e1; color:#64748b; cursor:pointer;" title="Buka Kalender">
              <i class="fa fa-calendar" style="pointer-events:none;"></i>
            </span>
          </div>
        </div>

        <!-- Kategori Produk -->
        <div style="flex:1.2 1 150px; min-width:140px; padding:0 6px; margin-bottom:14px;">
          <div class="rfm-filter-label-row">
            <label><i class="fa fa-folder-open-o" style="color:#6366f1;"></i> Kategori</label>
            <a href="javascript:void(0)" class="btn-reset-select2 rfm-quick-pill rfm-pill-indigo" data-target="#filter_kategori" title="Pilih Semua Kategori">Semua</a>
          </div>
          <select name="kategori" id="filter_kategori" class="form-control select2" data-placeholder="Semua Kategori" style="width:100%;">
            <option value="">-- Semua Kategori --</option>
            <?php if (!empty($categories_list)): ?>
              <?php foreach ($categories_list as $cat): 
                $c_name = is_object($cat) ? $cat->nama_kategori : (is_array($cat) ? ($cat['nama_kategori'] ?? '') : (string)$cat);
                if (empty($c_name)) continue;
              ?>
              <option value="<?= htmlspecialchars($c_name); ?>" <?= (!empty($category_filter) && $category_filter === $c_name) ? 'selected' : ''; ?>>
                <?= (stripos($c_name, 'Resi') !== false ? '📦 ' : '📁 ') . htmlspecialchars($c_name); ?>
              </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <!-- Filter Produk (dengan grouping optgroup kategori) -->
        <div style="flex:1.5 1 190px; min-width:170px; padding:0 6px; margin-bottom:14px;">
          <div class="rfm-filter-label-row">
            <label><i class="fa fa-shopping-bag" style="color:#059669;"></i> Produk</label>
            <a href="javascript:void(0)" class="btn-reset-select2 rfm-quick-pill rfm-pill-green" data-target="#filter_product" title="Pilih Semua Produk">Semua</a>
          </div>
          <select name="product" id="filter_product" class="form-control select2" data-placeholder="Semua Produk" style="width:100%;">
            <option value="">-- Semua Produk --</option>
            <?php 
            $grouped_prods = [];
            if (!empty($products_list)) {
              foreach ($products_list as $prod) {
                $p_name = is_object($prod) ? ($prod->item_name ?? $prod->nama_produk ?? '') : (is_array($prod) ? ($prod['item_name'] ?? $prod['nama_produk'] ?? '') : (string)$prod);
                $p_cat = is_object($prod) ? ($prod->nama_kategori ?? 'Lainnya') : (is_array($prod) ? ($prod['nama_kategori'] ?? 'Lainnya') : 'Lainnya');
                if (empty($p_cat)) $p_cat = 'Tanpa Kategori';
                if (empty($p_name)) continue;
                $grouped_prods[$p_cat][] = $p_name;
              }
              ksort($grouped_prods);
            }
            ?>
            <?php if (!empty($grouped_prods)): ?>
              <?php foreach ($grouped_prods as $kat_title => $prods): ?>
                <optgroup label="📂 <?= htmlspecialchars($kat_title); ?>">
                  <?php foreach ($prods as $p_item): ?>
                    <option value="<?= htmlspecialchars($p_item); ?>" <?= (!empty($product_filter) && $product_filter === $p_item) ? 'selected' : ''; ?>>
                      <?= htmlspecialchars($p_item); ?>
                    </option>
                  <?php endforeach; ?>
                </optgroup>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <!-- Status RFM (Select2 Tag Multiple) -->
        <div style="flex:2.3 1 270px; min-width:240px; padding:0 6px; margin-bottom:14px;">
          <div class="rfm-filter-label-row">
            <label><i class="fa fa-tags" style="color:#ea580c;"></i> Status RFM</label>
            <div style="display:flex; gap:4px; align-items:center; white-space:nowrap;">
              <a href="javascript:void(0)" id="btn-select-all-rfm" class="rfm-quick-pill rfm-pill-blue" title="Pilih Semua 10 Segmen RFM">Pilih Semua</a>
              <a href="javascript:void(0)" id="btn-clear-rfm" class="rfm-quick-pill rfm-pill-gray" title="Kosongkan (Mencakup Semua Status)">Reset</a>
            </div>
          </div>
          <select name="status_rfm[]" id="filter_status_rfm" class="form-control select2" multiple="multiple" data-placeholder="Semua Status RFM" style="width:100%;">
            <?php foreach ($all_segs as $s_opt): 
              $is_sel = (!empty($status_rfm_selected) && in_array($s_opt, $status_rfm_selected));
            ?>
            <option value="<?= htmlspecialchars($s_opt); ?>" <?= $is_sel ? 'selected' : ''; ?>>
              <?= htmlspecialchars($s_opt); ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Submit & Reset Button -->
        <div style="flex:0 0 auto; padding:0 6px; margin-bottom:14px; display:flex; gap:6px;">
          <button type="submit" class="btn rfm-btn-search" title="Tampilkan Data" style="padding:0 18px;">
            <i class="fa fa-search"></i> Lihat Data
          </button>
          <?php if ($is_filtered): ?>
          <a href="<?= site_url('administrator/rfm/tracking'); ?>" class="btn btn-default" title="Reset Filter" style="height:36px; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#64748b; border:1px solid #cbd5e1; padding:0 12px;">
            <i class="fa fa-refresh"></i>
          </a>
          <?php endif; ?>
        </div>

      </div>
    </form>

    <?php if (!$is_filtered): ?>
      <!-- Call-To-Action / Empty State (Belum memilih filter) -->
      <div class="rfm-empty-filter-state" style="text-align:center; padding:50px 24px; background:#f8fafc; border:1.5px dashed #cbd5e1; border-radius:12px; margin:22px 0 10px 0;">
        <div style="width:62px; height:62px; margin:0 auto 16px auto; background:#e0f2fe; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#0284c7; font-size:24px; box-shadow:0 4px 12px rgba(2, 132, 199, 0.15);">
          <i class="fa fa-filter"></i>
        </div>
        <h4 style="font-weight:800; font-size:17.5px; color:#1e293b; margin:0 0 8px 0;">Silakan Tentukan Filter Terlebih Dahulu</h4>
        <p style="color:#64748b; font-size:13.5px; max-width:540px; margin:0 auto 18px auto; line-height:1.6;">
          Cukup isi <strong>Tanggal Awal</strong> &amp; <strong>Tanggal Akhir</strong>, lalu klik tombol <strong style="color:#0284c7;">"Lihat Data"</strong>. Untuk Kategori Produk, Produk, dan Status RFM secara default otomatis mencakup <strong>Semua Data</strong> tanpa wajib dipilih satu per satu.
        </p>
      </div>
    <?php else: ?>
      <!-- ==========================================
           SUMMARY KPI CARDS (Data Awal, Total Pelanggan, Total Order)
           ========================================== -->
      <div class="rfm-summary-grid">
        <div class="rfm-summary-card">
          <div class="card-lbl"><i class="fa fa-history text-muted"></i> Data Awal (Saldo Awal)</div>
          <div class="card-val"><?= number_format($dt_data_awal); ?></div>
          <div class="card-sub">Pelanggan sebelum <?= htmlspecialchars($dt_date_from); ?></div>
        </div>

        <div class="rfm-summary-card" style="border-left: 4px solid #0284c7;">
          <div class="card-lbl"><i class="fa fa-users" style="color:#0284c7;"></i> Total Customer Terdaftar</div>
          <div class="card-val" style="color:#0284c7;"><?= number_format($dt_total_customers); ?></div>
          <div class="card-sub">Customer aktif di database</div>
        </div>

        <div class="rfm-summary-card" style="border-left: 4px solid #10b981;">
          <div class="card-lbl"><i class="fa fa-shopping-cart" style="color:#10b981;"></i> Total Transaksi</div>
          <div class="card-val" style="color:#10b981;"><?= number_format($dt_total_orders); ?></div>
          <div class="card-sub">Item pesanan teranalisis</div>
        </div>

        <div class="rfm-summary-card" style="border-left: 4px solid #8b5cf6;">
          <div class="card-lbl"><i class="fa fa-calendar-check-o" style="color:#8b5cf6;"></i> Total Baris Harian</div>
          <div class="card-val" style="color:#8b5cf6;"><?= number_format($dt_total_items); ?></div>
          <div class="card-sub">Hari riwayat tracking (terbaru di atas)</div>
        </div>
      </div>

      <?php if ($dt_data_awal == 0 && $dt_total_customers > 0): ?>
      <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 16px; margin-bottom:20px; color:#1e40af; font-size:13px; display:flex; align-items:flex-start; gap:10px;">
        <i class="fa fa-info-circle" style="font-size:18px; color:#3b82f6; margin-top:1px;"></i>
        <div style="line-height:1.5;">
          <strong>Data Ditemukan:</strong> Terdeteksi <strong><?= number_format($dt_total_customers); ?> Customer</strong> dengan total <strong><?= number_format($dt_total_orders); ?> Transaksi</strong> pada database. 
          <em>Data Awal</em> bernilai 0 karena tanggal awal filter (<strong><?= htmlspecialchars($dt_date_from); ?></strong>) dimulai sebelum adanya aktivitas transaksi pada periode tersebut. Seluruh riwayat transaksi customer dapat Anda lihat lengkap pada tabel di bawah (diurutkan otomatis dari tanggal terbaru).
        </div>
      </div>
      <?php endif; ?>

    <!-- ==========================================
         RFM TRACKING CHART (Interactive Multi-Line)
         ========================================== -->
    <div class="rfm-chart-box">
      <div class="rfm-chart-header">
        <h4>
          <i class="fa fa-line-chart" style="color:#0284c7;"></i> Grafik Tren RFM Tracking Harian
        </h4>
        <span style="font-size:11.5px; color:#64748b; font-weight:600;">
          <i class="fa fa-info-circle" style="color:#0284c7;"></i> Klik label segmen pada legenda untuk menyembunyikan / menampilkan garis tren
        </span>
      </div>
      <div style="position:relative; height:290px; width:100%;">
        <canvas id="rfmTrackingChart"></canvas>
      </div>
    </div>

    <!-- ==========================================
         RFM TRACKING DATA TABLE (Matches Screenshot Exactly)
         ========================================== -->
    <div class="table-responsive" style="overflow-x:auto; border-radius:8px;">
      <table class="table table-hover table-bordered table-rfm-custom" id="table-rfm-tracking">
        <thead>
          <tr>
            <th rowspan="2" style="vertical-align:middle; text-align:left; min-width:160px; cursor:pointer;" onclick="sortTrackingTable(0)">
              Hari, Tanggal <span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:10px; font-weight:600; margin-left:4px;">Terbaru</span> <i class="fa fa-sort text-muted" style="margin-left:4px;"></i>
            </th>
            <th rowspan="2" style="vertical-align:middle; text-align:center; min-width:90px; cursor:pointer;" onclick="sortTrackingTable(1)">
              Data Awal <i class="fa fa-sort text-muted" style="margin-left:4px;"></i>
            </th>
            <th colspan="10" style="text-align:center; background:#f1f5f9; padding:8px;">
              RFM Tracking
            </th>
          </tr>
          <tr>
            <th style="cursor:pointer;" onclick="sortTrackingTable(2)">New Customers <i class="fa fa-sort text-muted"></i></th>
            <th style="cursor:pointer;" onclick="sortTrackingTable(3)">Need Attention <i class="fa fa-sort text-muted"></i></th>
            <th style="cursor:pointer;" onclick="sortTrackingTable(4)">Frequent Low Value <i class="fa fa-sort text-muted"></i></th>
            <th style="cursor:pointer;" onclick="sortTrackingTable(5)">Hibernating <i class="fa fa-sort text-muted"></i></th>
            <th style="cursor:pointer;" onclick="sortTrackingTable(6)">At Risk Customers <i class="fa fa-sort text-muted"></i></th>
            <th style="cursor:pointer;" onclick="sortTrackingTable(7)">Cant Lose Them <i class="fa fa-sort text-muted"></i></th>
            <th style="cursor:pointer;" onclick="sortTrackingTable(8)">Potential Loyalist <i class="fa fa-sort text-muted"></i></th>
            <th style="cursor:pointer;" onclick="sortTrackingTable(9)">Loyal Customers <i class="fa fa-sort text-muted"></i></th>
            <th style="cursor:pointer;" onclick="sortTrackingTable(10)">Big Spenders <i class="fa fa-sort text-muted"></i></th>
            <th style="cursor:pointer;" onclick="sortTrackingTable(11)">Champion <i class="fa fa-sort text-muted"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($dt_rows)): ?>
          <tr>
            <td colspan="12" class="text-center" style="padding:40px; color:#94a3b8;">
              <i class="fa fa-calendar-o" style="font-size:36px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
              Tidak ada data RFM tracking pada rentang tanggal yang dipilih.
            </td>
          </tr>
          <?php else: ?>
            <?php foreach ($dt_rows as $row): 
              $is_obj = is_object($row);
              $tgl_raw = $is_obj ? ($row->date ?? $row->tgl ?? '') : ($row['date'] ?? $row['tgl'] ?? '');
              $tgl_lbl = $is_obj ? ($row->formatted_date ?? $row->day_date_label ?? '') : ($row['formatted_date'] ?? $row['day_date_label'] ?? '');
              $init_val = $is_obj ? ($row->data_awal ?? 0) : ($row['data_awal'] ?? 0);
              $segs_data = $is_obj ? ($row->segments ?? []) : ($row['segments'] ?? []);
            ?>
            <tr>
              <td style="font-weight:600; color:#334155; white-space:nowrap; text-align:left;">
                <?= $tgl_lbl; ?>
              </td>
              <td class="cell-num">
                <a href="javascript:void(0)" onclick="openTrackingCustomerDrilldown('<?= $tgl_raw; ?>', 'all', '<?= htmlspecialchars($tgl_lbl); ?>')" title="Klik untuk rincian customer">
                  <?= number_format($init_val); ?>
                </a>
              </td>

              <?php foreach ($all_segs as $seg_key): 
                $seg_info = $segs_data[$seg_key] ?? null;
                $c = is_array($seg_info) ? ($seg_info['count'] ?? 0) : (is_object($seg_info) ? ($seg_info->count ?? 0) : 0);
                $p = is_array($seg_info) ? ($seg_info['pct'] ?? 0) : (is_object($seg_info) ? ($seg_info->pct ?? 0) : 0);
              ?>
              <td class="cell-num">
                <a href="javascript:void(0)" onclick="openTrackingCustomerDrilldown('<?= $tgl_raw; ?>', '<?= htmlspecialchars($seg_key); ?>', '<?= htmlspecialchars($tgl_lbl); ?>')" title="Klik untuk rincian customer segmen <?= htmlspecialchars($seg_key); ?>">
                  <?= number_format($c); ?>
                </a>
                <?php if ($p > 0): ?>
                  <span class="trend-pill up" title="Naik <?= number_format($p, 2); ?>% dari hari sebelumnya">
                    (&uarr;<?= number_format($p, 2); ?>%)
                  </span>
                <?php elseif ($p < 0): ?>
                  <span class="trend-pill down" title="Turun <?= number_format(abs($p), 2); ?>% dari hari sebelumnya">
                    (&darr;<?= number_format(abs($p), 2); ?>%)
                  </span>
                <?php endif; ?>
              </td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>

  </div> <!-- End rfm-main-card -->

  <?php if ($is_filtered): ?>
  <!-- ==========================================
       LAYER 3: HISTORICAL MONTHLY PERFORMANCE (Collapsible)
       ========================================== -->
  <div style="margin-top:20px;">
    <div class="panel panel-default" style="border-radius:12px; border:1px solid #e2e8f0; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
      <div class="panel-heading" style="background:#ffffff; border-radius:12px 12px 0 0; padding:16px 20px; cursor:pointer;" data-toggle="collapse" data-target="#collapseHistorical">
        <h4 class="panel-title" style="font-size:14px; font-weight:700; color:#1e293b; display:flex; justify-content:space-between; align-items:center;">
          <span><i class="fa fa-bar-chart" style="color:#6366f1; margin-right:8px;"></i> Ringkasan Performa & Rekap Bulanan Historis</span>
          <i class="fa fa-chevron-down text-muted" style="font-size:12px;"></i>
        </h4>
      </div>
      <div id="collapseHistorical" class="panel-collapse collapse">
        <div class="panel-body" style="padding:20px;">
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-rfm-custom">
              <thead>
                <tr>
                  <th style="text-align:left;">Periode Bulan</th>
                  <th>Produk</th>
                  <th>Pembeli Unik</th>
                  <th>Total Transaksi</th>
                  <th>Total Omset (Rp)</th>
                  <th>Rata-rata Order</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($monthly_tracking)): ?>
                  <?php foreach ($monthly_tracking as $mt): ?>
                  <?php 
                    $prod_label = !empty($mt->product_label) ? $mt->product_label : (!empty($product_filter) ? $product_filter : 'Semua Produk');
                    $aov = (isset($mt->avg_order_value) && (float)$mt->avg_order_value > 0)
                      ? (float)$mt->avg_order_value
                      : ($mt->total_orders > 0 ? round((float)$mt->total_spend / (int)$mt->total_orders, 2) : 0);
                  ?>
                  <tr>
                    <td style="font-weight:600; text-align:left;"><?= htmlspecialchars($mt->period_label); ?></td>
                    <td><span class="label label-default" style="font-size:11px; padding:3px 8px; font-weight:normal; background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; border-radius:4px;"><?= htmlspecialchars($prod_label); ?></span></td>
                    <td class="text-center font-bold" style="color:#0284c7;"><?= number_format($mt->unique_buyers); ?></td>
                    <td class="text-center font-bold"><?= number_format($mt->total_orders); ?></td>
                    <td class="text-right" style="font-weight:700; color:#16a34a;">Rp <?= number_format($mt->total_spend, 0, ',', '.'); ?></td>
                    <td class="text-right" style="font-weight:600; color:#334155;">Rp <?= number_format($aov, 0, ',', '.'); ?></td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="6" class="text-center text-muted">Tidak ada data rekap bulanan</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ==========================================
       LAYER 4: BC SUMMARY (Collapsible)
       ========================================== -->
  <?php $bc_sum = $bc_summary ?? []; ?>
  <div style="margin-top:12px;">
    <div class="panel panel-default" style="border-radius:12px; border:1px solid #e2e8f0; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
      <div class="panel-heading" style="background:#ffffff; border-radius:12px 12px 0 0; padding:16px 20px; cursor:pointer;" data-toggle="collapse" data-target="#collapseBC">
        <h4 class="panel-title" style="font-size:14px; font-weight:700; color:#1e293b; display:flex; justify-content:space-between; align-items:center;">
          <span>
            <i class="fa fa-whatsapp text-green" style="margin-right:8px;"></i> Ringkasan Follow-Up Harian (H+0 s/d Masuk Grup)
            <?php if (!empty($bc_sum['grand_total'])): ?>
              <span class="badge" style="background:#22c55e; color:#fff; font-size:11px; margin-left:8px; padding:3px 9px; border-radius:10px; font-weight:700;"><?= number_format($bc_sum['grand_total']); ?> Terkirim</span>
            <?php endif; ?>
          </span>
          <i class="fa fa-chevron-down text-muted" style="font-size:12px;"></i>
        </h4>
      </div>
      <div id="collapseBC" class="panel-collapse collapse">
        <div class="panel-body" style="padding:20px;">
          <?php if (!empty($bc_sum['rows'])): ?>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-rfm-custom" style="margin-bottom:0;">
              <thead>
                <tr>
                  <th style="text-align:left; min-width:180px;">Hari, Tanggal</th>
                  <th style="width:130px; text-align:center;">Total Terkirim</th>
                  <?php 
                  $display_opts = !empty($bc_sum['bc_options']) ? $bc_sum['bc_options'] : [];
                  foreach ($display_opts as $bco): 
                  ?>
                  <th style="text-align:center; min-width:85px;"><?= $bco; ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($bc_sum['rows'] as $bcr): ?>
                <tr>
                  <td style="font-weight:600; text-align:left; vertical-align:middle; color:#1e293b;">
                    <i class="fa fa-calendar-check-o text-primary" style="margin-right:4px;"></i> <?= $bcr['day_label']; ?>
                  </td>
                  <td class="text-center font-bold" style="color:#0284c7; vertical-align:middle; font-size:13px;">
                    <span class="badge" style="background:#e0f2fe; color:#0284c7; border:1px solid #bae6fd; font-weight:800; font-size:12px; padding:5px 12px; border-radius:12px;">
                      <?= number_format($bcr['total']); ?>
                    </span>
                  </td>
                  <?php foreach ($display_opts as $bco): 
                    $c = $bcr['counts'][$bco] ?? 0;
                    $cust_list = !empty($bcr['customers'][$bco]) ? implode(', ', array_unique($bcr['customers'][$bco])) : '';
                    $tip = $c > 0 ? "title=\"{$c} Customer: " . htmlspecialchars($cust_list) . "\"" : "";
                  ?>
                  <td class="text-center" style="vertical-align:middle;" <?= $tip; ?>>
                    <?php if ($c > 0): ?>
                      <span class="badge" style="background:#0284c7; color:#fff; font-weight:700; font-size:12px; padding:4px 9px; border-radius:8px; cursor:default; box-shadow:0 2px 4px rgba(2,132,199,0.25);" data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($c . ' Customer: ' . $cust_list); ?>">
                        <?= number_format($c); ?>
                      </span>
                    <?php else: ?>
                      <span style="color:#cbd5e1; font-weight:500; font-size:12px;">0</span>
                    <?php endif; ?>
                  </td>
                  <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr style="background:#f8fafc; font-weight:800; border-top:2px solid #cbd5e1;">
                  <td style="text-align:left; color:#1e293b; vertical-align:middle;">
                    <i class="fa fa-calculator text-primary" style="margin-right:4px;"></i> Total Keseluruhan
                  </td>
                  <td class="text-center" style="vertical-align:middle;">
                    <span class="badge" style="background:#0284c7; color:#fff; font-weight:800; font-size:13px; padding:6px 14px; border-radius:12px; box-shadow:0 2px 6px rgba(2,132,199,0.3);">
                      <?= number_format($bc_sum['grand_total'] ?? array_sum(array_column($bc_sum['rows'], 'total'))); ?>
                    </span>
                  </td>
                  <?php foreach ($display_opts as $bco): 
                    $col_t = $bc_sum['column_totals'][$bco] ?? array_sum(array_map(function($r) use ($bco) { return $r['counts'][$bco] ?? 0; }, $bc_sum['rows']));
                  ?>
                  <td class="text-center" style="vertical-align:middle;">
                    <?php if ($col_t > 0): ?>
                      <strong style="color:#0f172a; font-size:13px;"><?= number_format($col_t); ?></strong>
                    <?php else: ?>
                      <span style="color:#cbd5e1; font-weight:500;">0</span>
                    <?php endif; ?>
                  </td>
                  <?php endforeach; ?>
                </tr>
              </tfoot>
            </table>
          </div>
          <?php else: ?>
            <p class="text-muted text-center" style="margin:20px 0;"><i class="fa fa-info-circle text-info"></i> Tidak ada aktivitas follow-up pada rentang tanggal ini.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

</div> <!-- End rfm-tracking-wrapper -->

<!-- ==========================================
     MODAL DRILLDOWN CUSTOMER DETAIL
     ========================================== -->
<div class="modal fade" id="modal-tracking-drilldown" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:90%; max-width:1050px; margin:30px auto;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:24px; color:#64748b; margin-top:-4px;">&times;</button>
        <h4 class="modal-title" id="drilldown-modal-title" style="font-size:16px; font-weight:800; color:#1e293b;">
          <i class="fa fa-users text-primary"></i> Daftar Customer
        </h4>
        <div id="drilldown-modal-subtitle" style="font-size:12.5px; color:#64748b; margin-top:4px;">
          Memuat data...
        </div>
      </div>
      <div class="modal-body" style="padding:20px;">
        <div class="row" style="margin-bottom:14px;">
          <div class="col-md-5 col-sm-6 col-xs-12">
            <div class="input-group">
              <span class="input-group-addon" style="background:#f8fafc; border-color:#cbd5e1;"><i class="fa fa-search text-muted"></i></span>
              <input type="text" id="drilldown-search" class="form-control" placeholder="Cari nama atau no HP customer..." onkeyup="filterDrilldownTable()">
            </div>
          </div>
          <div class="col-md-7 col-sm-6 col-xs-12 text-right">
            <span id="drilldown-count-badge" class="badge" style="background:#0284c7; padding:6px 12px; font-size:12px; font-weight:700;">
              0 Customer
            </span>
          </div>
        </div>

        <div class="table-responsive" style="max-height:420px; overflow-y:auto; border:1px solid #e2e8f0; border-radius:8px;">
          <table class="table table-hover table-striped" id="table-drilldown-content" style="margin-bottom:0; font-size:12.5px;">
            <thead style="position:sticky; top:0; background:#f8fafc; z-index:2;">
              <tr>
                <th style="width:50px; text-align:center;">No</th>
                <th>No. HP / WA</th>
                <th>Nama Customer</th>
                <th style="text-align:center;">Total Orders</th>
                <th style="text-align:right;">Total Spend</th>
                <th style="text-align:center;">Recency (Hari)</th>
                <th style="text-align:center;">Skor R-F-M</th>
                <th style="text-align:center;">Segmen</th>
              </tr>
            </thead>
            <tbody id="drilldown-tbody">
              <tr>
                <td colspan="8" class="text-center" style="padding:30px; color:#94a3b8;">
                  <i class="fa fa-spinner fa-spin" style="font-size:24px; color:#0284c7;"></i>
                  <div style="margin-top:8px;">Mengambil data customer dari database...</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; border-radius:0 0 12px 12px; padding:12px 20px;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight:700; border-radius:6px;">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================
     MODAL IMPORT EXCEL DATA
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
            <strong>Auto-Detect Pintar:</strong> Sistem akan otomatis mengenali apakah file berisi data transaksi sales atau 125 aturan matriks RFM.
          </div>

          <!-- Import Mode Type -->
          <div class="form-group" style="margin-bottom:18px;">
            <label style="font-weight:700; color:#1e1b4b; font-size:13px; margin-bottom:6px; display:block;">Tipe Data Import:</label>
            <select name="import_type" class="form-control" style="border-radius:8px; border:1px solid #cbd5e1; height:40px; font-weight:600; font-size:13px;">
              <option value="auto">✨ Deteksi Otomatis (Rekomendasi)</option>
              <option value="transactions">🛒 Data Transaksi Penjualan (Format Shopee, Tokopedia, Excel)</option>
              <option value="matrix">📊 Aturan Matriks RFM &amp; Segmentasi (File Matriks 125 Aturan)</option>
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

<script>
$(document).ready(function() {
  // Initialize Select2 with dynamic data-placeholder support
  if ($.fn.select2) {
    $('.select2').each(function() {
      var ph = $(this).data('placeholder') || $(this).attr('placeholder') || 'Pilih...';
      $(this).select2({
        placeholder: ph,
        allowClear: true
      });
    });
  }

  // Handle quick [ Semua ] click for Kategori and Produk
  $(document).on('click', '.btn-reset-select2', function(e) {
    e.preventDefault();
    var target = $(this).data('target');
    if (target) {
      $(target).val('').trigger('change');
    }
  });

  // Handle [ Pilih Semua ] for Status RFM (Selects all 10 segment tags)
  $(document).on('click', '#btn-select-all-rfm', function(e) {
    e.preventDefault();
    var $select = $('#filter_status_rfm');
    $select.find('option').prop('selected', true);
    $select.trigger('change');
  });

  // Handle [ Reset ] for Status RFM (Clears tags, automatically meaning All segments)
  $(document).on('click', '#btn-clear-rfm', function(e) {
    e.preventDefault();
    $('#filter_status_rfm').val(null).trigger('change');
  });

  // Global jQuery UI Datepicker Indonesian Localization & Format Defaults (dd/mm/yy)
  if ($.datepicker) {
    $.datepicker.setDefaults({
      dateFormat: 'dd/mm/yy',
      firstDay: 1,
      isRTL: false,
      showAnim: '',
      duration: 0,
      showMonthAfterYear: false,
      yearSuffix: '',
      monthNames: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
      monthNamesShort: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
      dayNames: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
      dayNamesShort: ['Min','Sen','Sel','Rab','Kam','Jum','Sab'],
      dayNamesMin: ['Mg','Sn','Sl','Rb','Km','Jm','Sb']
    });
  }

  // Auto-hide datepicker popup immediately on scroll/resize to prevent floating calendar bug
  function autoHideRfmDatepicker(e) {
    if (window.innerWidth <= 767) {
      // Never auto-hide on mobile resize or scroll, because mobile OS select wheel/sheet triggers window resize/scroll!
      return;
    }
    if (e && e.target && (e.target.id === 'ui-datepicker-div' || $(e.target).closest('#ui-datepicker-div, .datepicker-dropdown').length)) {
      return;
    }
    if ($.datepicker && typeof $.datepicker._hideDatepicker === 'function') {
      try { $.datepicker._hideDatepicker(); } catch(err){}
    }
    var uiDiv = document.getElementById('ui-datepicker-div');
    if (uiDiv) {
      uiDiv.style.display = 'none';
    }
    var bsPickers = document.querySelectorAll('.datepicker-dropdown');
    bsPickers.forEach(function(el) { el.style.display = 'none'; });
  }

  // Bind scroll listener on window (capture phase) AND directly on .content-wrapper (AdminLTE fixed layout)
  window.addEventListener('scroll', autoHideRfmDatepicker, true);
  window.addEventListener('resize', autoHideRfmDatepicker, true);
  var cw = document.querySelector('.content-wrapper');
  if (cw) {
    cw.addEventListener('scroll', autoHideRfmDatepicker, false);
  }

  // Position datepicker using position:fixed + getBoundingClientRect (viewport-relative, scroll-proof)
  function positionRfmDatepicker(input) {
    if (!input) return;
    var dp = document.getElementById('ui-datepicker-div');
    if (!dp) return;
    if (window.innerWidth <= 767) {
      dp.style.position = 'fixed';
      dp.style.top = '50%';
      dp.style.left = '50%';
      dp.style.transform = 'translate(-50%, -50%)';
      dp.style.zIndex = '999999';
      dp.style.display = 'block';
      return;
    }
    var alignPos = function() {
      if (dp.style.display === 'none') return;
      var rect = input.getBoundingClientRect();
      dp.style.position = 'fixed';
      dp.style.top = (rect.bottom + 4) + 'px';
      dp.style.left = rect.left + 'px';
      dp.style.transform = 'none';
      dp.style.zIndex = '999999';
      dp.style.display = 'block';
    };
    alignPos();
    setTimeout(alignPos, 10);
    setTimeout(alignPos, 30);
  }

  // Safe Datepicker Initialization with explicit DD/MM/YYYY enforcement & reliable positioning
  if ($.fn.datepicker) {
    $('.rfm-datepicker').datepicker({
      dateFormat: 'dd/mm/yy',   // jQuery UI (dd = 2-digit day, mm = 2-digit month, yy = 4-digit year e.g. 2026)
      format: 'dd/mm/yyyy',     // Bootstrap Datepicker (dd = day, mm = month, yyyy = year)
      autoclose: true,
      todayHighlight: true,
      showAnim: '',
      duration: 0,
      changeMonth: true,
      changeYear: true,
      yearRange: '2015:2035',
      beforeShow: function(input, inst) {
        positionRfmDatepicker(input);
      },
      onChangeMonthYear: function(year, month, inst) {
        // When month/year is changed in the dropdown, keep the datepicker properly positioned on mobile
        setTimeout(function() {
          if (inst && inst.input) {
            positionRfmDatepicker(inst.input[0]);
          }
        }, 10);
      },
      onSelect: function(dateText, inst) {
        // Directly use the selected date formatted by jQuery UI according to dateFormat (dd/mm/yy)
        $(this).val(dateText).trigger('change');
      }
    });

    // Support bootstrap-datepicker changeDate event
    $('.rfm-datepicker').on('changeDate', function(e) {
      if (e.date) {
        var day = String(e.date.getDate()).padStart(2, '0');
        var month = String(e.date.getMonth() + 1).padStart(2, '0');
        var year = e.date.getFullYear();
        $(this).val(day + '/' + month + '/' + year);
      }
    });
  }

  // Prevent default mousedown on calendar button to avoid premature blur/dismiss
  $(document).on('mousedown', '.btn-trigger-datepicker', function(e) {
    e.preventDefault();
  });

  // Trigger datepicker popup on calendar icon click (Reliable toggle open/close)
  $(document).on('click', '.btn-trigger-datepicker', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var target = $(this).data('target');
    if (!target) return;
    var $inp = $(target);
    if (!$inp.length) return;

    var isShowing = false;
    if ($.datepicker) {
      isShowing = $.datepicker._datepickerShowing && ($.datepicker._lastInput === $inp[0] || ($.datepicker._curInst && $.datepicker._curInst.input && $.datepicker._curInst.input[0] === $inp[0]));
    } else {
      isShowing = $('#ui-datepicker-div').is(':visible');
    }

    if (isShowing) {
      if ($.datepicker) {
        $.datepicker._hideDatepicker();
      } else if ($.fn.datepicker) {
        $inp.datepicker('hide');
      }
    } else {
      if ($.datepicker) {
        $.datepicker._lastInput = null; // Clear so jQuery UI never ignores this show call
        $.datepicker._showDatepicker($inp[0]);
      } else if ($.fn.datepicker) {
        $inp.datepicker('show');
      }
      $inp.focus();
      positionRfmDatepicker($inp[0]);
    }
  });

  // Reposition and show datepicker when input is focused or clicked
  $(document).on('focus', '.rfm-datepicker', function() {
    positionRfmDatepicker(this);
  });
  $(document).on('click', '.rfm-datepicker', function() {
    if ($.datepicker && !$.datepicker._datepickerShowing) {
      $.datepicker._lastInput = null;
      $.datepicker._showDatepicker(this);
    }
    positionRfmDatepicker(this);
  });

  // Auto-normalize user input on blur (e.g. 1/10/2026 or 2026-10-01 -> 01/10/2026)
  $(document).on('blur change', '.rfm-datepicker', function() {
    var val = $(this).val().trim();
    if (!val) return;
    var mYmd = val.match(/^(\d{4})[\/\-](\d{1,2})[\/\-](\d{1,2})$/);
    if (mYmd) {
      var y = mYmd[1];
      var m = mYmd[2].padStart(2, '0');
      var d = mYmd[3].padStart(2, '0');
      $(this).val(d + '/' + m + '/' + y);
      return;
    }
    var mDmy = val.match(/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/);
    if (mDmy) {
      var d = mDmy[1].padStart(2, '0');
      var m = mDmy[2].padStart(2, '0');
      var y = mDmy[3];
      $(this).val(d + '/' + m + '/' + y);
    }
  });

  <?php if (!$is_filtered): ?>
  // Explicitly ensure blank inputs and no preselected tags on initial page load
  $('#filter_date_from').val('');
  $('#filter_date_to').val('');
  if ($.fn.select2) {
    $('#filter_kategori').val('').trigger('change');
    $('#filter_product').val('').trigger('change');
    $('select[name="status_rfm[]"]').val(null).trigger('change');
  }
  <?php endif; ?>

  // Clean outside-click listener to close datepicker without breaking clicks
  $(document).on('mousedown', function(e) {
    if (!$(e.target).closest('.rfm-datepicker, #ui-datepicker-div, .ui-datepicker, .btn-trigger-datepicker, .datepicker').length) {
      if ($.datepicker) {
        try { $.datepicker._hideDatepicker(); } catch(err){}
      }
      var uiDiv = document.getElementById('ui-datepicker-div');
      if (uiDiv) uiDiv.style.display = 'none';
      var bsPickers = document.querySelectorAll('.datepicker-dropdown');
      bsPickers.forEach(function(el) { el.style.display = 'none'; });
    }
  });

  // Chart.js Trend Line Visualization (Only when filtered)
  <?php if ($is_filtered): ?>
  renderRfmTrackingChart();
  <?php endif; ?>
});

function renderRfmTrackingChart() {
  var canvas = document.getElementById('rfmTrackingChart');
  if (!canvas) return;

  var dailyData = <?= json_encode($dt_chart_rows); ?>;
  if (!dailyData || dailyData.length === 0) return;

  var labels = [];
  var segmentKeys = <?= json_encode(!empty($status_rfm_selected) ? array_values(array_intersect($all_segs, $status_rfm_selected)) : $all_segs); ?>;
  if (!segmentKeys || segmentKeys.length === 0) {
    segmentKeys = <?= json_encode($all_segs); ?>;
  }

  var colorPalette = {
    'New Customers': '#06b6d4',
    'Need Attention': '#f97316',
    'Frequent Low Value': '#eab308',
    'Hibernating': '#64748b',
    'At Risk Customers': '#ef4444',
    'Cant Lose Them': '#ec4899',
    'Potential Loyalist': '#10b981',
    'Loyal Customers': '#3b82f6',
    'Big Spenders': '#8b5cf6',
    'Champion': '#f59e0b'
  };

  var datasetsObj = {};
  segmentKeys.forEach(function(key) {
    datasetsObj[key] = {
      label: key,
      data: [],
      borderColor: colorPalette[key] || '#6366f1',
      backgroundColor: colorPalette[key] || '#6366f1',
      borderWidth: 2,
      pointRadius: 3,
      pointHoverRadius: 6,
      tension: 0.25,
      fill: false
    };
  });

  dailyData.forEach(function(item) {
    var raw = item.date || item.tgl;
    var d = new Date(raw);
    var labelStr = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    labels.push(labelStr);

    segmentKeys.forEach(function(key) {
      var val = 0;
      if (item.segments && item.segments[key]) {
        val = parseInt(item.segments[key].count || 0, 10);
      } else if (item.counts && item.counts[key]) {
        val = parseInt(item.counts[key], 10);
      }
      datasetsObj[key].data.push(val);
    });
  });

  var chartDatasets = segmentKeys.map(function(k) { return datasetsObj[k]; });

  var ctx = canvas.getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: chartDatasets
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: {
        mode: 'index',
        intersect: false
      },
      plugins: {
        legend: {
          position: 'top',
          labels: {
            boxWidth: 12,
            boxHeight: 12,
            usePointStyle: true,
            pointStyle: 'circle',
            font: { size: 11, weight: 'bold' },
            padding: 12
          }
        },
        tooltip: {
          backgroundColor: 'rgba(15, 23, 42, 0.92)',
          titleFont: { size: 12, weight: 'bold' },
          bodyFont: { size: 11 },
          padding: 10,
          cornerRadius: 8
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: {
            font: { size: 10 },
            maxRotation: 45,
            autoSkip: true,
            maxTicksLimit: 20
          }
        },
        y: {
          beginAtZero: true,
          grid: { color: '#f1f5f9' },
          ticks: { font: { size: 10 } }
        }
      }
    }
  });
}

// Client-side table sort
var currentSortCol = -1;
var sortAsc = true;
function sortTrackingTable(colIndex) {
  var table = document.getElementById('table-rfm-tracking');
  if (!table) return;
  var tbody = table.querySelector('tbody');
  var rows = Array.from(tbody.querySelectorAll('tr'));
  if (rows.length <= 1) return;

  if (currentSortCol === colIndex) {
    sortAsc = !sortAsc;
  } else {
    currentSortCol = colIndex;
    sortAsc = true;
  }

  rows.sort(function(a, b) {
    var cellA = a.children[colIndex];
    var cellB = b.children[colIndex];
    if (!cellA || !cellB) return 0;

    var textA = cellA.innerText.trim();
    var textB = cellB.innerText.trim();

    var numA = parseFloat(textA.replace(/[^0-9.-]/g, ''));
    var numB = parseFloat(textB.replace(/[^0-9.-]/g, ''));

    if (!isNaN(numA) && !isNaN(numB) && colIndex > 0) {
      return sortAsc ? numA - numB : numB - numA;
    }
    return sortAsc ? textA.localeCompare(textB) : textB.localeCompare(textA);
  });

  rows.forEach(function(r) { tbody.appendChild(r); });
}

// Drilldown AJAX Modal Function
function openTrackingCustomerDrilldown(date, segment, dateLabel) {
  var modal = $('#modal-tracking-drilldown');
  $('#drilldown-modal-title').html('<i class="fa fa-users text-primary"></i> Daftar Customer: ' + (segment === 'all' ? 'Semua Customer Aktif' : segment));
  $('#drilldown-modal-subtitle').html('Posisi per tanggal: <strong>' + dateLabel + '</strong>');
  $('#drilldown-count-badge').text('Memuat...');
  $('#drilldown-search').val('');
  
  var tbody = $('#drilldown-tbody');
  tbody.html('<tr><td colspan="8" class="text-center" style="padding:40px; color:#64748b;"><i class="fa fa-spinner fa-spin fa-2x" style="color:#0284c7;"></i><br><span style="margin-top:10px; display:inline-block; font-weight:600;">Mengambil data customer...</span></td></tr>');
  
  modal.modal('show');

  var category = $('select[name="kategori"]').val() || '';
  var product = $('select[name="product"]').val() || '';

  $.ajax({
    url: '<?= site_url("administrator/rfm/tracking_drilldown_ajax"); ?>',
    type: 'GET',
    data: {
      date: date,
      segment: segment,
      kategori: category,
      product: product
    },
    dataType: 'json',
    success: function(res) {
      if (!res || !res.customers || res.customers.length === 0) {
        tbody.html('<tr><td colspan="8" class="text-center" style="padding:30px; color:#94a3b8;"><i class="fa fa-info-circle fa-2x"></i><br>Tidak ada customer di segmen ini pada tanggal tersebut.</td></tr>');
        $('#drilldown-count-badge').text('0 Customer');
        return;
      }

      var customers = res.customers || res.data || [];
      $('#drilldown-count-badge').text(customers.length + ' Customer');

      var html = '';
      customers.forEach(function(c, idx) {
        var phone = c.no_hp || c.phone || '';
        var phoneClean = (phone || '').replace(/[^0-9]/g, '');
        var waLink = phoneClean ? 'https://wa.me/' + (phoneClean.startsWith('0') ? '62' + phoneClean.substring(1) : (phoneClean.startsWith('62') ? phoneClean : '62' + phoneClean)) : '#';
        var name = c.nama_pelanggan || c.nama || 'Customer';
        var orders = (c.frequency !== undefined && c.frequency !== null) ? c.frequency : ((c.total_orders !== undefined && c.total_orders !== null) ? c.total_orders : 0);
        var spend = (c.monetary !== undefined && c.monetary !== null) ? c.monetary : ((c.total_spend !== undefined && c.total_spend !== null) ? c.total_spend : 0);
        var recency = (c.recency !== undefined && c.recency !== null) ? c.recency : ((c.days_since_last !== undefined && c.days_since_last !== null) ? c.days_since_last : 0);
        var score = c.rfm_score || c.rfm_display || c.rfm_code || '-';
        var segment = c.segment || '-';

        html += '<tr>';
        html += '<td style="text-align:center; color:#94a3b8;">' + (idx + 1) + '</td>';
        html += '<td style="font-weight:600;">';
        if (phoneClean && phoneClean.length >= 7) {
          html += '<a href="' + waLink + '" target="_blank" style="color:#16a34a; text-decoration:none;"><i class="fa fa-whatsapp"></i> ' + (phone || '-') + '</a>';
        } else {
          html += (phone || '-');
        }
        html += '</td>';
        html += '<td style="font-weight:700; color:#1e293b;">' + name + '</td>';
        html += '<td style="text-align:center; font-weight:700;">' + orders + 'x</td>';
        html += '<td style="text-align:right; font-weight:700; color:#0f172a;">Rp ' + parseInt(spend || 0, 10).toLocaleString('id-ID') + '</td>';
        html += '<td style="text-align:center;"><span class="badge" style="background:#f1f5f9; color:#475569; font-weight:600;">' + recency + ' hari lalu</span></td>';
        html += '<td style="text-align:center;"><span style="font-family:monospace; font-weight:800; background:#e0e7ff; color:#3730a3; padding:2px 8px; border-radius:4px; font-size:11.5px;">' + score + '</span></td>';
        html += '<td style="text-align:center;"><span class="badge" style="background:#0284c7; font-size:11px;">' + segment + '</span></td>';
        html += '</tr>';
      });

      tbody.html(html);
    },
    error: function() {
      tbody.html('<tr><td colspan="8" class="text-center text-danger" style="padding:30px;"><i class="fa fa-exclamation-triangle fa-2x"></i><br>Gagal memuat data customer dari server.</td></tr>');
      $('#drilldown-count-badge').text('Error');
    }
  });
}

function filterDrilldownTable() {
  var input = document.getElementById('drilldown-search');
  var filter = input.value.toLowerCase().trim();
  var table = document.getElementById('table-drilldown-content');
  var tbody = document.getElementById('drilldown-tbody');
  if (!tbody) return;
  var trs = tbody.getElementsByTagName('tr');
  var visibleCount = 0;

  for (var i = 0; i < trs.length; i++) {
    var cells = trs[i].getElementsByTagName('td');
    if (cells.length < 8) continue; // Skip loading / empty placeholder row

    var tdHp = cells[1] ? (cells[1].textContent || cells[1].innerText || '') : '';
    var tdName = cells[2] ? (cells[2].textContent || cells[2].innerText || '') : '';
    var tdScore = cells[6] ? (cells[6].textContent || cells[6].innerText || '') : '';
    var tdSeg = cells[7] ? (cells[7].textContent || cells[7].innerText || '') : '';

    var match = !filter || 
                tdHp.toLowerCase().indexOf(filter) > -1 || 
                tdName.toLowerCase().indexOf(filter) > -1 || 
                tdScore.toLowerCase().indexOf(filter) > -1 || 
                tdSeg.toLowerCase().indexOf(filter) > -1;

    if (match) {
      trs[i].style.display = '';
      visibleCount++;
    } else {
      trs[i].style.display = 'none';
    }
  }

  $('#drilldown-count-badge').text(visibleCount + ' Customer');
}
</script>
