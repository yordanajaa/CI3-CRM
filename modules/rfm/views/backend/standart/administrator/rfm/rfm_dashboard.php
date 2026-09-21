<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<style>
:root {
  --rfm-primary: #6366f1;
  --rfm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
  --card-radius: 14px;
}

.rfm-header {
  background: var(--rfm-gradient);
  color: #fff;
  padding: 28px 32px;
  border-radius: 16px;
  margin-bottom: 24px;
  box-shadow: 0 12px 30px rgba(49, 46, 129, 0.25);
  position: relative;
  overflow: hidden;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
}
.rfm-header::before {
  content: '';
  position: absolute;
  right: -60px;
  top: -60px;
  width: 220px;
  height: 220px;
  background: rgba(255,255,255,0.06);
  border-radius: 50%;
  pointer-events: none;
}
.rfm-header::after {
  content: '';
  position: absolute;
  right: 60px;
  bottom: -80px;
  width: 280px;
  height: 280px;
  background: rgba(255,255,255,0.03);
  border-radius: 50%;
  pointer-events: none;
}
.rfm-header .header-title h2 {
  margin: 0 0 6px 0;
  font-weight: 800;
  font-size: 26px;
  letter-spacing: -0.5px;
  color: #fff;
}
.rfm-header .header-title p {
  margin: 0;
  opacity: 0.85;
  font-size: 13.5px;
  font-weight: 400;
  color: #e2e8f0;
}
.rfm-header .header-actions {
  position: relative;
  z-index: 2;
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}
.rfm-header .header-actions .btn {
  border-radius: 10px;
  font-weight: 700;
  font-size: 13px;
  padding: 9px 18px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.2s ease;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.rfm-header .header-actions .btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

/* KPI Cards */
.kpi-row { margin-bottom: 8px; }
.kpi-card {
  background: #fff;
  border-radius: var(--card-radius);
  padding: 20px 22px;
  box-shadow: var(--card-shadow);
  margin-bottom: 20px;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  position: relative;
  overflow: hidden;
  border: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  gap: 16px;
}
.kpi-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px -4px rgba(0, 0, 0, 0.1);
}
.kpi-card .kpi-icon {
  width: 50px;
  height: 50px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  flex-shrink: 0;
}
.kpi-card .kpi-body {
  flex: 1;
  min-width: 0;
}
.kpi-card .kpi-value {
  font-size: 26px;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.1;
  letter-spacing: -0.5px;
}
.kpi-card .kpi-label {
  font-size: 11px;
  color: #64748b;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-top: 4px;
}

/* Section Card */
.section-card {
  background: #fff;
  border-radius: var(--card-radius);
  padding: 22px 24px;
  box-shadow: var(--card-shadow);
  margin-bottom: 24px;
  border: 1px solid #f1f5f9;
}
.section-card .card-title {
  font-weight: 800;
  font-size: 16px;
  color: #0f172a;
  margin: 0 0 20px 0;
  letter-spacing: -0.3px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.section-card .card-title i {
  font-size: 18px;
}

/* Segment Cards */
.segment-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
}
.seg-card {
  background: #f8fafc;
  border-radius: 12px;
  padding: 14px 16px;
  border: 1px solid #e2e8f0;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  gap: 14px;
}
.seg-card:hover {
  background: #fff;
  border-color: #cbd5e1;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.06);
}
.seg-card .seg-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 17px;
  flex-shrink: 0;
}
.seg-card .seg-info { flex: 1; min-width: 0; }
.seg-card .seg-name { font-weight: 700; font-size: 13px; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.seg-card .seg-count { font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1.1; margin-top: 2px; }
.seg-card .seg-pct { font-size: 11px; color: #64748b; font-weight: 600; }
.seg-card .seg-action { margin-top: 3px; }
.seg-card .seg-action a {
  font-size: 11px;
  color: var(--rfm-primary);
  font-weight: 700;
  text-decoration: none;
}
.seg-card .seg-action a:hover { text-decoration: underline; }

/* Tables */
.table-threshold th {
  background: #f8fafc;
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #475569;
  padding: 10px 12px !important;
  border-bottom: 2px solid #e2e8f0;
  white-space: nowrap;
}
.table-threshold td {
  padding: 9px 12px !important;
  font-size: 12.5px;
  color: #334155;
  vertical-align: middle !important;
  white-space: nowrap;
}
.table-threshold tbody tr:hover { background: #f8fafc; }
.table-threshold .score-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 26px;
  height: 26px;
  border-radius: 7px;
  font-weight: 800;
  font-size: 12px;
  color: #fff;
}

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

/* Segment Definition Table */
.seg-def-table th {
  background: #f8fafc;
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #475569;
  padding: 8px 10px !important;
  border-bottom: 2px solid #e2e8f0;
  white-space: nowrap;
}
.seg-def-table td {
  padding: 8px 10px !important;
  font-size: 12px;
  color: #334155;
  vertical-align: middle !important;
}
.seg-def-table tbody tr:hover { background: #f8fafc; }

/* Chart Containers */
.chart-box-pie {
  position: relative;
  height: 340px;
  width: 100%;
}
.chart-box-bar {
  position: relative;
  height: 260px;
  width: 100%;
}

/* ===== Animations & Micro-Interactions ===== */
@keyframes rfmFadeInUp {
  from {
    opacity: 0;
    transform: translateY(16px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes rfmPulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.03); }
  100% { transform: scale(1); }
}

.rfm-animated {
  animation: rfmFadeInUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.rfm-header, .kpi-card, .section-card, .seg-card {
  animation: rfmFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.25s ease;
}

.rfm-header .header-actions .btn:active,
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

@media (min-width: 992px) {
  .rfm-flex-row { display: flex; flex-wrap: wrap; }
  .rfm-flex-col { display: flex; flex-direction: column; }
}

@media (max-width: 991px) {
  .segment-grid { grid-template-columns: repeat(2, 1fr); }
  .chart-box-pie { height: 300px; }
}

@media (max-width: 767px) {
  .rfm-header { padding: 20px 16px; border-radius: 12px; text-align: center; flex-direction: column; }
  .rfm-header .header-title h2 { font-size: 21px; }
  .rfm-header .header-title p { font-size: 12.5px; }
  .rfm-header .header-actions { width: 100%; justify-content: center; gap: 8px; }
  .rfm-header .header-actions .btn { width: 100%; max-width: 100%; padding: 10px; font-size: 12.5px; justify-content: center; }
  .kpi-card { padding: 14px 16px; gap: 12px; }
  .kpi-card .kpi-icon { width: 42px; height: 42px; font-size: 18px; border-radius: 10px; }
  .kpi-card .kpi-value { font-size: 22px; }
  .kpi-card .kpi-label { font-size: 10px; }
  .section-card { padding: 16px; margin-bottom: 16px; }
  .section-card .card-title { font-size: 15px; margin-bottom: 14px; flex-wrap: wrap; }
  .chart-box-pie { height: 260px; }
  .chart-box-bar { height: 220px; }
}

@media (max-width: 575px) {
  .segment-grid { grid-template-columns: 1fr; }
  .kpi-row .col-xs-6 { width: 50%; float: left; padding-left: 5px; padding-right: 5px; }
  .kpi-row { margin-left: -5px; margin-right: -5px; }
  .kpi-card { flex-direction: column; text-align: center; gap: 6px; padding: 12px 6px; }
  .kpi-card .kpi-icon { width: 36px; height: 36px; font-size: 16px; margin: 0 auto; }
  .kpi-card .kpi-value { font-size: 18px; }
  .kpi-card .kpi-label { font-size: 9.5px; letter-spacing: 0; line-height: 1.3; }
  #form-product-filter { flex-direction: column; align-items: stretch !important; }
  #form-product-filter > div { width: 100%; }
}
</style>

<!-- ===== HEADER ===== -->
<div class="rfm-header">
  <div class="header-title">
    <h2><i class="fa fa-bar-chart"></i> Dashboard Analisis RFM</h2>
    <p>Recency, Frequency, Monetary — Segmentasi pelanggan berdasarkan perilaku transaksi per produk</p>
  </div>
  <?php
    $nav_params = array_filter(['product' => $product_filter ?? '', 'period' => $period_filter ?? '']);
    $nav_qs = !empty($nav_params) ? '?' . http_build_query($nav_params) : '';
  ?>
  <div class="header-actions">
    <a href="<?= site_url('administrator/rfm/dashboard' . $nav_qs); ?>" class="btn" style="background:#fff; color:#312e81; font-weight:700;"><i class="fa fa-tachometer"></i> Dashboard RFM</a>
    <a href="<?= site_url('administrator/rfm' . $nav_qs); ?>" class="btn" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.3); font-weight:700;"><i class="fa fa-users"></i> Daftar Customer</a>
    <a href="<?= site_url('administrator/crm/chat'); ?>" class="btn" style="background:linear-gradient(135deg, #075e54, #128c7e); color:#fff; box-shadow:0 4px 12px rgba(18,140,126,0.35); font-weight:700;"><i class="fa fa-whatsapp"></i> Live Chat WA</a>
    <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn" style="background:#25D366; color:#fff; font-weight:700;"><i class="fa fa-bullhorn"></i> Broadcast WA</a>
    <button type="button" class="btn" data-toggle="modal" data-target="#modal-import-excel" style="background:#10b981; color:#fff; font-weight:700; border:none; box-shadow:0 4px 12px rgba(16,185,129,0.35);"><i class="fa fa-file-excel-o"></i> Import Excel Data</button>
    <a href="<?= site_url('administrator/rfm/export_customers' . $nav_qs); ?>" class="btn" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.3); font-weight:700;"><i class="fa fa-download"></i> Export CSV</a>
  </div>
</div>

<!-- ===== PRODUCT & PERIODE FILTER BAR ===== -->
<div class="section-card" style="margin-bottom:20px; padding:16px 20px; background:#fff; border:1px solid #e0e7ff; border-left:4px solid #6366f1;">
  <form method="GET" action="<?= site_url('administrator/rfm/dashboard'); ?>" id="form-product-filter" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
    <div style="display:flex; align-items:center; gap:16px; flex:1; min-width:320px; flex-wrap:wrap;">
      <i class="fa fa-filter" style="color:#6366f1; font-size:18px;"></i>
      
      <!-- Filter Produk -->
      <div style="display:flex; align-items:center; gap:6px;">
        <label for="product-select" style="margin:0; font-weight:700; color:#1e1b4b; font-size:13px; white-space:nowrap;">Produk:</label>
        <select name="product" id="product-select" class="form-control" style="border-radius:8px; border:1px solid #cbd5e1; font-size:12.5px; font-weight:600; height:38px; min-width:240px; max-width:360px;" onchange="document.getElementById('form-product-filter').submit();">
           <option value="">-- Semua Produk --</option>
          <?php if (!empty($products_list)): ?>
            <?php foreach ($products_list as $prod): 
              $p_name = !empty($prod->item_name) ? $prod->item_name : (!empty($prod->nama_produk) ? $prod->nama_produk : '');
              if (empty($p_name)) continue;
            ?>
              <option value="<?= htmlspecialchars($p_name); ?>" <?= ($product_filter === $p_name) ? 'selected' : ''; ?>>
                <?= htmlspecialchars($p_name); ?>
              </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>

      <!-- Filter Periode Bulan -->
      <div style="display:flex; align-items:center; gap:6px;">
        <label for="period-select" style="margin:0; font-weight:700; color:#1e1b4b; font-size:13px; white-space:nowrap;">Periode / Bulan:</label>
        <select name="period" id="period-select" class="form-control" style="border-radius:8px; border:1px solid #cbd5e1; font-size:12.5px; font-weight:600; height:38px; min-width:180px;" onchange="document.getElementById('form-product-filter').submit();">
           <option value="">-- Semua Periode Bulan --</option>
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

    <div style="display:flex; align-items:center; gap:8px;">
      <?php if (!empty($product_filter) || !empty($period_filter)): ?>
        <a href="<?= site_url('administrator/rfm/dashboard'); ?>" class="btn btn-sm btn-default" style="border-radius:8px; font-weight:600;"><i class="fa fa-times"></i> Reset Filter</a>
      <?php endif; ?>
    </div>
  </form>
</div>

<!-- ===== KPI CARDS ===== -->
<div class="row kpi-row">
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="kpi-card">
      <div class="kpi-icon" style="background:#e0e7ff; color:#4338ca;"><i class="fa fa-users"></i></div>
      <div class="kpi-body">
        <div class="kpi-value"><?= number_format($kpis['total_customers']); ?></div>
        <div class="kpi-label">Total Pembeli<?= !empty($product_filter) ? ' Produk Ini' : ' (Keseluruhan)'; ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="kpi-card" title="Rata-rata jumlah hari sejak transaksi produk terakhir (Skor R: <?= $kpis['avg_r']; ?> dari 5)">
      <div class="kpi-icon" style="background:#dbeafe; color:#2563eb;"><i class="fa fa-clock-o"></i></div>
      <div class="kpi-body">
        <div class="kpi-value"><?= number_format($kpis['avg_days']); ?> <small style="font-size:13px; font-weight:600; color:#2563eb;">Hari</small></div>
        <div class="kpi-label">Recency (Terakhir Beli) <span class="label" style="background:#dbeafe; color:#1e40af; font-size:10px; margin-left:3px; padding:2px 6px;">Skor R: <?= $kpis['avg_r']; ?>/5</span></div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="kpi-card" title="Rata-rata frekuensi order produk ini per customer (Skor F: <?= $kpis['avg_f']; ?> dari 5)">
      <div class="kpi-icon" style="background:#dcfce7; color:#16a34a;"><i class="fa fa-repeat"></i></div>
      <div class="kpi-body">
        <div class="kpi-value"><?= $kpis['avg_orders']; ?>x <small style="font-size:13px; font-weight:600; color:#16a34a;">Order</small></div>
        <div class="kpi-label">Frequency (Frekuensi Beli) <span class="label" style="background:#dcfce7; color:#166534; font-size:10px; margin-left:3px; padding:2px 6px;">Skor F: <?= $kpis['avg_f']; ?>/5</span></div>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-6">
    <div class="kpi-card" title="Rata-rata belanja produk ini per customer (Skor M: <?= $kpis['avg_m']; ?> dari 5)">
      <div class="kpi-icon" style="background:#f3e8ff; color:#7c3aed;"><i class="fa fa-money"></i></div>
      <div class="kpi-body">
        <div class="kpi-value" style="font-size:18px;">Rp <?= number_format($kpis['avg_spend'], 0, ',', '.'); ?></div>
        <div class="kpi-label">Monetary (Total Belanja) <span class="label" style="background:#f3e8ff; color:#6b21a8; font-size:10px; margin-left:3px; padding:2px 6px;">Skor M: <?= $kpis['avg_m']; ?>/5</span></div>
      </div>
    </div>
  </div>
</div>

<!-- ===== SEGMENT DISTRIBUTION & BREAKDOWN ===== -->
<div class="row rfm-flex-row">
  <!-- Pie Chart -->
  <div class="col-md-5 col-sm-12 rfm-flex-col">
    <div class="section-card" style="flex:1; display:flex; flex-direction:column;">
      <div class="card-title"><i class="fa fa-pie-chart" style="color:#6366f1;"></i> Distribusi Segmen RFM</div>
      <div class="chart-box-pie">
        <canvas id="rfmPieChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Segment Cards Grid -->
  <div class="col-md-7 col-sm-12 rfm-flex-col">
    <div class="section-card" style="flex:1;">
      <div class="card-title"><i class="fa fa-th-large" style="color:#6366f1;"></i> Breakdown Per Segmen</div>
      <div class="segment-grid">
        <?php foreach ($rfm_distribution['segments'] as $dist): ?>
        <div class="seg-card">
          <div class="seg-icon" style="background: <?= $dist['badge']['bg']; ?>; color: <?= $dist['badge']['color']; ?>;">
            <i class="fa <?= $dist['badge']['icon']; ?>"></i>
          </div>
          <div class="seg-info">
            <div class="seg-name"><?= htmlspecialchars($dist['segment']); ?></div>
            <div class="seg-count"><?= number_format($dist['count']); ?> <span class="seg-pct">(<?= $dist['percentage']; ?>%)</span></div>
            <div class="seg-action">
              <a href="<?= site_url('administrator/rfm?rfm_segment=' . urlencode($dist['segment']) . (!empty($product_filter) ? '&product=' . urlencode($product_filter) : '')); ?>"><i class="fa fa-filter"></i> Filter Customer</a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- ===== MONTHLY RFM TRACKING & TREND PER PRODUK ===== -->
<?php
  $track_data = $monthly_tracking ?? [];
  $track_cnt = count($track_data);
  $total_sum_spend = array_sum(array_column($track_data, 'total_spend'));
  $avg_sum_spend = $track_cnt > 0 ? $total_sum_spend / $track_cnt : 0;
  $total_sum_buyers = array_sum(array_column($track_data, 'unique_buyers'));
  $avg_sum_buyers = $track_cnt > 0 ? $total_sum_buyers / $track_cnt : 0;
  $total_sum_orders = array_sum(array_column($track_data, 'total_orders'));
?>
<div class="row" style="margin-top:20px; margin-bottom:24px;">
  <div class="col-md-12">
    <div class="section-card" id="section-tracking-monthly" style="border-radius:16px; overflow:hidden; border:1px solid #a7f3d0; box-shadow:0 10px 30px rgba(16,185,129,0.12); padding:0; background:#fff; transition:all 0.3s ease;">
      <!-- Header Banner -->
      <div style="background:linear-gradient(135deg, #064e3b 0%, #047857 50%, #059669 100%); padding:22px 28px; color:#fff; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div>
          <h3 style="margin:0 0 6px 0; font-weight:800; font-size:20px; color:#fff; display:flex; align-items:center; gap:10px;">
            <i class="fa fa-line-chart" style="color:#6ee7b7; font-size:22px;"></i>
            Tracking & Tren RFM Bulanan
          </h3>
          <p style="margin:0; opacity:0.9; font-size:13px; color:#ecfdf5;">
            Analisis rekapitulasi performa omset, frekuensi order, dan pembeli unik per bulan <?= !empty($product_filter) ? 'untuk produk: <strong>' . htmlspecialchars($product_filter) . '</strong>' : '(Semua Produk)'; ?>
          </p>
        </div>
        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
          <?php if (!empty($period_filter)): ?>
          <span class="label" style="background:rgba(255,255,255,0.2); color:#fff; font-size:12px; padding:6px 14px; border-radius:20px; border:1px solid rgba(255,255,255,0.4); font-weight:700;"><i class="fa fa-calendar"></i> Filter Periode: <?= htmlspecialchars($period_filter); ?></span>
          <a href="<?= site_url('administrator/rfm/dashboard' . (!empty($product_filter) ? '?product=' . urlencode($product_filter) : '')); ?>" class="btn btn-xs" style="background:#fff; color:#047857; font-weight:700; border-radius:8px; padding:6px 14px; box-shadow:0 2px 6px rgba(0,0,0,0.1);"><i class="fa fa-times"></i> Reset Filter Bulan</a>
          <?php else: ?>
          <span class="label" style="background:rgba(255,255,255,0.2); color:#fff; font-size:12.5px; padding:6px 14px; border-radius:20px; font-weight:700;"><i class="fa fa-check-circle"></i> Tracking Aktif Real-Time</span>
          <?php endif; ?>
        </div>
      </div>

      <div style="padding:22px 26px;">
        <!-- 4 Mini Summary Stats Cards -->
        <div class="row" style="margin-bottom:20px;">
          <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:10px;">
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:14px 16px; text-align:center;">
              <div style="font-size:20px; font-weight:800; color:#166534;"><?= $track_cnt; ?> Bulan</div>
              <div style="font-size:11px; font-weight:700; color:#15803d; text-transform:uppercase; margin-top:2px;">Total Periode Teracak</div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:10px;">
            <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px; padding:14px 16px; text-align:center;">
              <div style="font-size:18px; font-weight:800; color:#1e40af;">Rp <?= number_format($avg_sum_spend, 0, ',', '.'); ?></div>
              <div style="font-size:11px; font-weight:700; color:#1d4ed8; text-transform:uppercase; margin-top:2px;">Rata2 Omset / Bulan</div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:10px;">
            <div style="background:#faf5ff; border:1px solid #e9d5ff; border-radius:12px; padding:14px 16px; text-align:center;">
              <div style="font-size:20px; font-weight:800; color:#6b21a8;"><?= number_format($avg_sum_buyers); ?> Customer</div>
              <div style="font-size:11px; font-weight:700; color:#7e22ce; text-transform:uppercase; margin-top:2px;">Rata2 Pembeli / Bulan</div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:10px;">
            <div style="background:#fff7ed; border:1px solid #fed7aa; border-radius:12px; padding:14px 16px; text-align:center;">
              <div style="font-size:20px; font-weight:800; color:#c2410c;"><?= number_format($total_sum_orders); ?>x</div>
              <div style="font-size:11px; font-weight:700; color:#ea580c; text-transform:uppercase; margin-top:2px;">Total Transaksi</div>
            </div>
          </div>
        </div>

        <!-- Monthly Visual Trend Chart -->
        <?php if (!empty($track_data)): ?>
        <div style="background:#fafbfc; border:1px solid #e2e8f0; border-radius:14px; padding:18px; margin-bottom:22px;">
          <div style="font-weight:800; font-size:14px; color:#0f172a; margin-bottom:14px; display:flex; align-items:center; gap:8px;">
            <i class="fa fa-area-chart" style="color:#059669; font-size:16px;"></i> Grafik Tren Omset (Rp) & Pembeli Unik (Customer) Per Bulan
          </div>
          <div style="position:relative; height:270px; width:100%;">
            <canvas id="monthlyTrendChart"></canvas>
          </div>
        </div>
        <?php endif; ?>

        <!-- Monthly Performance Table -->
        <div class="table-responsive" style="overflow-x:auto;">
          <table class="table table-hover table-striped seg-def-table" style="margin-bottom:0; width:100%; min-width:880px;">
            <thead>
              <tr style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                <th style="width:4%;">#</th>
                <th style="min-width:140px;">Bulan / Periode</th>
                <th style="text-align:center; min-width:120px;">Pembeli Unik</th>
                <th style="text-align:center; min-width:120px;">Jumlah Order (F)</th>
                <th style="text-align:center; min-width:100px;">Total Qty</th>
                <th style="text-align:right; min-width:160px;">Total Omset (Monetary)</th>
                <th style="text-align:center; min-width:120px;">Tren Omset (MoM)</th>
                <th style="text-align:center; min-width:130px;">Rata2 Recency (R)</th>
                <th style="text-align:center; min-width:120px;">Aksi / Filter</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($track_data)): ?>
              <tr><td colspan="9" class="text-center" style="padding:30px !important; color:#94a3b8;"><i class="fa fa-calendar-o" style="font-size:24px; display:block; margin-bottom:6px;"></i>Belum ada data transaksi bulanan untuk periode/produk ini</td></tr>
              <?php else: ?>
              <?php 
              $m_no = 1; 
              foreach ($track_data as $idx => $mt): 
                $is_active_m = (!empty($period_filter) && $period_filter === $mt->ym_period);
                
                // Calculate Month-over-Month (MoM) growth percentage
                $prev_spend = isset($track_data[$idx + 1]) ? (float)$track_data[$idx + 1]->total_spend : 0;
                $growth_pct = 0;
                if ($prev_spend > 0) {
                  $growth_pct = round((($mt->total_spend - $prev_spend) / $prev_spend) * 100, 1);
                }
              ?>
              <tr<?= $is_active_m ? ' style="background:#ecfdf5; border-left:4px solid #10b981;"' : ''; ?>>
                <td><?= $m_no++; ?></td>
                <td>
                  <strong style="color:#0f172a; font-size:13.5px;"><i class="fa fa-calendar" style="color:#6366f1; margin-right:4px;"></i> <?= htmlspecialchars($mt->period_label); ?></strong>
                  <code style="font-size:10px; background:#f1f5f9; padding:2px 5px; border-radius:4px; margin-left:4px; color:#475569;"><?= htmlspecialchars($mt->ym_period); ?></code>
                  <?php if ($is_active_m): ?>
                  <span class="label" style="background:#059669; color:#fff; font-size:10px; margin-left:4px; padding:2px 6px; border-radius:8px;">Aktif</span>
                  <?php endif; ?>
                </td>
                <td style="text-align:center;">
                  <span class="label" style="background:#e0e7ff; color:#3730a3; font-size:12px; font-weight:800; padding:5px 10px; border-radius:6px;">
                    <i class="fa fa-user"></i> <?= number_format($mt->unique_buyers); ?> Customer
                  </span>
                </td>
                <td style="text-align:center;">
                  <strong style="color:#0f172a; font-size:13px;"><?= number_format($mt->total_orders); ?>x</strong> Transaksi
                </td>
                <td style="text-align:center;">
                  <span class="label" style="background:#f1f5f9; color:#334155; font-size:11.5px; font-weight:700; padding:4px 8px; border-radius:6px;">
                    <?= number_format($mt->total_qty); ?> pcs
                  </span>
                </td>
                <td style="text-align:right;">
                  <strong style="color:#059669; font-size:14px;">Rp <?= number_format($mt->total_spend, 0, ',', '.'); ?></strong>
                </td>
                <td style="text-align:center;">
                  <?php if ($prev_spend == 0): ?>
                    <span class="label" style="background:#f1f5f9; color:#64748b; font-size:11px; padding:4px 8px; border-radius:6px; font-weight:600;"><i class="fa fa-minus"></i> Awal</span>
                  <?php elseif ($growth_pct > 0): ?>
                    <span class="label" style="background:#dcfce7; color:#166534; font-size:11.5px; padding:4px 8px; border-radius:6px; font-weight:700;"><i class="fa fa-arrow-up"></i> +<?= $growth_pct; ?>%</span>
                  <?php elseif ($growth_pct < 0): ?>
                    <span class="label" style="background:#fee2e2; color:#991b1b; font-size:11.5px; padding:4px 8px; border-radius:6px; font-weight:700;"><i class="fa fa-arrow-down"></i> <?= $growth_pct; ?>%</span>
                  <?php else: ?>
                    <span class="label" style="background:#f1f5f9; color:#475569; font-size:11px; padding:4px 8px; border-radius:6px; font-weight:600;"><i class="fa fa-minus"></i> 0.0%</span>
                  <?php endif; ?>
                </td>
                <td style="text-align:center;">
                  <span class="label" style="background:<?= ($mt->avg_recency_days <= 30 ? '#dcfce7; color:#166534;' : ($mt->avg_recency_days <= 90 ? '#fef3c7; color:#92400e;' : '#fee2e2; color:#991b1b;')); ?> font-size:11.5px; padding:4px 8px; border-radius:6px; font-weight:600;">
                    ~<?= $mt->avg_recency_days; ?> hari
                  </span>
                </td>
                <td style="text-align:center;">
                  <?php if ($is_active_m): ?>
                    <a href="<?= site_url('administrator/rfm/dashboard' . (!empty($product_filter) ? '?product=' . urlencode($product_filter) : '')); ?>" class="btn btn-xs btn-default" style="border-radius:6px; font-size:11px; font-weight:600;" title="Reset Filter Bulan"><i class="fa fa-times"></i> Reset</a>
                  <?php else: ?>
                    <a href="<?= site_url('administrator/rfm/dashboard?period=' . urlencode($mt->ym_period) . (!empty($product_filter) ? '&product=' . urlencode($product_filter) : '')); ?>" class="btn btn-xs" style="background:#10b981; color:#fff; border-radius:6px; font-size:11px; font-weight:700; padding:3px 10px; box-shadow:0 2px 4px rgba(16,185,129,0.2);" title="Filter khusus bulan ini"><i class="fa fa-filter"></i> Filter Bulan</a>
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
</div>

<!-- ===== DAFTAR PEMBELI & FREKUENSI TRANSAKSI PRODUK ===== -->
<div class="row" style="margin-top:16px; margin-bottom:8px;">
  <div class="col-md-12">
    <div class="section-card" style="border-left:4px solid #6366f1;">
      <div class="card-title" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:16px;">
        <span>
          <i class="fa fa-users" style="color:#6366f1;"></i> 
          Daftar Pembeli & Frekuensi Transaksi <?= !empty($product_filter) ? 'Produk: <strong style="color:#1e1b4b; background:#e0e7ff; padding:3px 10px; border-radius:6px; font-size:14px;">' . htmlspecialchars($product_filter) . '</strong>' : '(Semua Customer)'; ?>
          <span class="badge" style="background:#4338ca; color:#fff; margin-left:8px; font-size:12px; font-weight:700;"><?= count($filtered_customers); ?> Customer</span>
        </span>
        <div>
          <?php if (!empty($product_filter)): ?>
          <a href="<?= site_url('administrator/rfm?product=' . urlencode($product_filter)); ?>" class="btn btn-xs" style="background:#6366f1; color:#fff; border-radius:6px; font-weight:700; padding:6px 14px;">
            <i class="fa fa-external-link"></i> Lihat Atau Export List Lengkap
          </a>
          <?php else: ?>
          <a href="<?= site_url('administrator/rfm'); ?>" class="btn btn-xs" style="background:#6366f1; color:#fff; border-radius:6px; font-weight:700; padding:6px 14px;">
            <i class="fa fa-list"></i> Lihat Semua Customer
          </a>
          <?php endif; ?>
        </div>
      </div>

      <div class="table-responsive" style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
        <table class="table table-hover table-striped seg-def-table" style="margin-bottom:0; width:100%; min-width:920px;">
          <thead>
            <tr style="background:#f8fafc;">
              <th style="width:3%; min-width:28px;">#</th>
              <th style="min-width:130px;">Nama Pembeli</th>
              <th style="min-width:105px;">No. Telepon</th>
              <th style="text-align:center; min-width:105px;">Frekuensi Beli</th>
              <th style="text-align:right; min-width:110px;">Total Spend<?= !empty($product_filter) ? ' Produk' : ''; ?></th>
              <th style="text-align:center; min-width:105px;">Recency</th>
              <th style="text-align:center; min-width:85px;">Skor RFM</th>
              <th style="text-align:center; min-width:115px;">Segmen Market</th>
              <th style="text-align:center; min-width:125px; width:125px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($filtered_customers)): ?>
              <?php 
              $cust_no = 1;
              $score_colors = [1 => '#ef4444', 2 => '#f97316', 3 => '#eab308', 4 => '#22c55e', 5 => '#16a34a'];
              $display_customers = array_slice($filtered_customers, 0, 50);
              foreach ($display_customers as $c): 
                $rfm = $c->rfm;
                $badge = $rfm['badge'];
              ?>
              <tr>
                <td><?= $cust_no++; ?></td>
                <td>
                  <strong style="color:#0f172a; font-size:13.5px;"><?= htmlspecialchars($c->customer_nama); ?></strong>
                </td>
                <td>
                  <span style="color:#475569; font-size:12px; font-weight:600;"><i class="fa fa-phone" style="font-size:11px; color:#64748b;"></i> <?= htmlspecialchars($c->customer_phone); ?></span>
                </td>
                <td style="text-align:center;">
                  <span class="label" style="background:#dcfce7; color:#166534; font-size:12px; font-weight:800; padding:5px 10px; border-radius:6px;">
                    <i class="fa fa-repeat"></i> <?= $c->total_orders; ?>x Transaksi
                  </span>
                </td>
                <td style="text-align:right;">
                  <strong style="color:#059669; font-size:13px;">Rp <?= number_format($c->total_spend, 0, ',', '.'); ?></strong>
                </td>
                <td style="text-align:center;">
                  <span class="label" style="background:<?= ($rfm['days_since_last'] <= 30 ? '#dcfce7; color:#166534;' : ($rfm['days_since_last'] <= 90 ? '#fef3c7; color:#92400e;' : '#fee2e2; color:#991b1b;')); ?> font-size:11.5px; padding:4px 8px; border-radius:6px; font-weight:600;">
                    <?= $rfm['days_since_last']; ?> hari lalu
                  </span>
                </td>
                <td style="text-align:center;">
                  <div class="rfm-score-cell" style="justify-content:center;">
                    <span class="rfm-score-pill" style="background:<?= $score_colors[$rfm['r_score']]; ?>" title="Recency Skor: <?= $rfm['r_score']; ?>"><?= $rfm['r_score']; ?></span>
                    <span class="rfm-score-pill" style="background:<?= $score_colors[$rfm['f_score']]; ?>" title="Frequency Skor: <?= $rfm['f_score']; ?>"><?= $rfm['f_score']; ?></span>
                    <span class="rfm-score-pill" style="background:<?= $score_colors[$rfm['m_score']]; ?>" title="Monetary Skor: <?= $rfm['m_score']; ?>"><?= $rfm['m_score']; ?></span>
                  </div>
                </td>
                <td style="text-align:center;">
                  <span class="segment-badge" style="background:<?= $badge['bg']; ?>; color:<?= $badge['color']; ?>; border:1px solid <?= $badge['border']; ?>; font-size:11px; font-weight:700;">
                    <i class="fa <?= $badge['icon']; ?>" style="margin-right:4px;"></i><?= htmlspecialchars($rfm['segment']); ?>
                  </span>
                </td>
                <td style="text-align:center; white-space:nowrap; min-width:125px; width:125px;">
                  <a href="<?= site_url('administrator/rfm/customer_detail?phone=' . urlencode($c->customer_phone) . (!empty($product_filter) ? '&product=' . urlencode($product_filter) : '')); ?>" class="btn btn-xs" style="background:#6366f1; color:#fff; border-radius:6px; font-weight:700; padding:3px 7px; font-size:11px;" title="Detail Customer">
                    <i class="fa fa-user"></i> Detail
                  </a>
                  <?php 
                    $clean_phone = preg_replace('/[^0-9]/', '', $c->customer_phone ?? '');
                    if (!empty($clean_phone)):
                      $wa_phone = preg_replace('/^0/', '62', $clean_phone);
                      if (substr($wa_phone, 0, 2) !== '62') $wa_phone = '62' . $wa_phone;
                      $wa_action = !empty($rfm['action']) ? $rfm['action'] : 'Terima kasih telah menjadi pelanggan setia kami.';
                      $wa_msg = "Halo Kak " . $c->customer_nama . ",\n\nSalam dari Metafora! " . $wa_action . "\n\nAda yang bisa kami bantu hari ini?";
                      $direct_wa_url = 'https://api.whatsapp.com/send?phone=' . $wa_phone . '&text=' . rawurlencode($wa_msg);
                      $crm_chat_url = site_url('administrator/crm/chat?phone=' . urlencode($c->customer_phone) . '&wa_msg=' . rawurlencode($wa_msg));
                  ?>
                  <a href="<?= $direct_wa_url; ?>" target="_blank" class="btn btn-xs" style="background:#25D366; color:#fff; border-radius:6px; font-weight:700; padding:3px 7px; font-size:11px; margin-left:2px;" title="Buka Chat WhatsApp Langsung">
                    <i class="fa fa-whatsapp"></i> Chat
                  </a>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="9" class="text-center" style="color:#94a3b8; padding:30px !important;">Tidak ada customer ditemukan</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <?php if (count($filtered_customers) > 50): ?>
      <div style="text-align:center; padding:12px 0 4px 0;">
        <span class="text-muted" style="font-size:12px;">Menampilkan 50 dari <?= count($filtered_customers); ?> customer pembeli produk ini. </span>
        <a href="<?= site_url('administrator/rfm?product=' . urlencode($product_filter)); ?>" style="font-weight:700; color:#6366f1;">Lihat Selengkapnya <i class="fa fa-arrow-right"></i></a>
      </div>
      <?php endif; ?>
    </div>
  </div>
<!-- ===== BAR CHART ===== -->
<div class="row">
  <div class="col-md-12">
    <div class="section-card">
      <div class="card-title"><i class="fa fa-bar-chart" style="color:#6366f1;"></i> Perbandingan Jumlah Customer Per Segmen</div>
      <div class="chart-box-bar">
        <canvas id="rfmBarChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- ===== THRESHOLD TABLES ===== -->
<div class="row">
  <div class="col-md-4 col-sm-12">
    <div class="section-card">
      <div class="card-title"><i class="fa fa-clock-o" style="color:#2563eb;"></i> Threshold Recency</div>
      <div class="table-responsive">
        <table class="table table-threshold">
          <thead><tr><th>Percentile</th><th>Range Hari</th><th>Skor</th><th>Label</th></tr></thead>
          <tbody>
            <?php $r_colors = ['#16a34a','#22c55e','#eab308','#f97316','#ef4444']; ?>
            <?php foreach ($thresholds['recency'] as $i => $tr): ?>
            <tr>
              <td><strong><?= $tr['percentile']; ?></strong></td>
              <td><?= $tr['range']; ?></td>
              <td><span class="score-badge" style="background:<?= $r_colors[$i]; ?>"><?= $tr['score']; ?></span></td>
              <td><?= $tr['label']; ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-12">
    <div class="section-card">
      <div class="card-title"><i class="fa fa-repeat" style="color:#16a34a;"></i> Threshold Frequency</div>
      <div class="table-responsive">
        <table class="table table-threshold">
          <thead><tr><th>Percentile</th><th>Range Order</th><th>Skor</th><th>Label</th></tr></thead>
          <tbody>
            <?php $f_colors = ['#16a34a','#22c55e','#eab308','#f97316','#ef4444']; ?>
            <?php foreach ($thresholds['frequency'] as $i => $tf): ?>
            <tr>
              <td><strong><?= $tf['percentile']; ?></strong></td>
              <td><?= $tf['range']; ?></td>
              <td><span class="score-badge" style="background:<?= $f_colors[$i]; ?>"><?= $tf['score']; ?></span></td>
              <td><?= $tf['label']; ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-12">
    <div class="section-card">
      <div class="card-title"><i class="fa fa-money" style="color:#7c3aed;"></i> Threshold Monetary</div>
      <div class="table-responsive">
        <table class="table table-threshold">
          <thead><tr><th>Percentile</th><th>Range Nominal</th><th>Skor</th><th>Label</th></tr></thead>
          <tbody>
            <?php $m_colors = ['#16a34a','#22c55e','#eab308','#f97316','#ef4444']; ?>
            <?php foreach ($thresholds['monetary'] as $i => $tm): ?>
            <tr>
              <td><strong><?= $tm['percentile']; ?></strong></td>
              <td><?= $tm['range']; ?></td>
              <td><span class="score-badge" style="background:<?= $m_colors[$i]; ?>"><?= $tm['score']; ?></span></td>
              <td><?= $tm['label']; ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- ===== SEGMENT DEFINITIONS TABLE (always visible) ===== -->
<div class="row">
  <div class="col-md-12">
    <div class="section-card">
      <div class="card-title"><i class="fa fa-book" style="color:#6366f1;"></i> Definisi & Strategi Per Segmen</div>
      <div class="table-responsive">
        <table class="table seg-def-table">
          <thead>
            <tr>
              <th style="min-width:140px;">Segment</th>
              <th style="min-width:110px;">Jumlah Customer</th>
              <th style="min-width:200px;">Goal</th>
              <th style="min-width:240px;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $dist_map = [];
            foreach ($rfm_distribution['segments'] as $d) { $dist_map[$d['segment']] = $d; }
            foreach ($segments as $s): 
              $cnt = isset($dist_map[$s['segment']]) ? $dist_map[$s['segment']]['count'] : 0;
              $pct = isset($dist_map[$s['segment']]) ? $dist_map[$s['segment']]['percentage'] : 0;
            ?>
            <tr>
              <td>
                <span style="display:inline-flex;align-items:center;gap:10px;">
                  <span style="width:30px;height:30px;border-radius:8px;background:<?= $s['color']; ?>15;color:<?= $s['color']; ?>;display:inline-flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;"><i class="fa <?= $s['icon']; ?>"></i></span>
                  <strong style="font-size:13px; color:#0f172a;"><?= htmlspecialchars($s['segment']); ?></strong>
                </span>
              </td>
              <td>
                <strong style="font-size:14px; color:#0f172a;"><?= number_format($cnt); ?></strong>
                <span style="color:#64748b; font-size:11px;"> (<?= $pct; ?>%)</span>
              </td>
              <td style="font-size:12.5px; color:#475569; line-height:1.4;"><?= htmlspecialchars($s['goal']); ?></td>
              <td style="font-size:12.5px; color:#475569; line-height:1.4;"><?= htmlspecialchars($s['action']); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- ===== PRODUCT RFM ANALYSIS ===== -->
<div class="row" style="margin-top:16px;">
  <div class="col-xs-12">
    <div class="section-card">
      <div class="card-title" style="display:flex; justify-content:space-between; align-items:center;">
        <span><i class="fa fa-shopping-bag" style="color:#ec4899;"></i> Analisis RFM Per Produk (Product-Level Performance)</span>
        <a href="<?= site_url('administrator/rfm'); ?>" class="btn btn-xs" style="background:#f1f5f9; color:#475569; border-radius:6px; font-weight:600;"><i class="fa fa-arrow-right"></i> Lihat Semua Customer</a>
      </div>

      <div class="table-responsive">
        <table class="table seg-def-table" style="margin-bottom:0;">
          <thead>
            <tr>
              <th style="width:4%;">#</th>
              <th>Nama Produk</th>
              <th style="text-align:center;">Pembeli Unik</th>
              <th style="text-align:center;">Total Order</th>
              <th style="text-align:center;">Total Qty</th>
              <th style="text-align:right;">Total Omset</th>
              <th style="text-align:center;">Recency (Hari)</th>
              <th style="text-align:center;">Status RFM Produk</th>
              <th style="text-align:center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($product_rfm_list['rows'])): ?>
            <?php $p_no = 1; foreach ($product_rfm_list['rows'] as $pr): ?>
            <tr>
              <td><?= $p_no++; ?></td>
              <td>
                <strong style="color:#0f172a; font-size:13px;"><?= htmlspecialchars($pr->item_name); ?></strong>
              </td>
              <td style="text-align:center;"><span class="badge" style="background:#e2e8f0; color:#334155; font-size:12px; font-weight:700;"><?= number_format($pr->total_customers); ?> cust</span></td>
              <td style="text-align:center;"><strong style="color:#1e293b;"><?= number_format($pr->total_orders); ?>x</strong></td>
              <td style="text-align:center; color:#64748b;"><?= number_format($pr->total_qty); ?></td>
              <td style="text-align:right; font-weight:700; color:#16a34a;">Rp <?= number_format($pr->total_spend, 0, ',', '.'); ?></td>
              <td style="text-align:center;">
                <span class="label" style="background:<?= $pr->recency_days <= 30 ? '#dcfce7; color:#166534;' : ($pr->recency_days <= 90 ? '#fef3c7; color:#92400e;' : '#fee2e2; color:#991b1b;'); ?> border-radius:6px; padding:4px 8px;">
                  <?= $pr->recency_days; ?> hr lalu
                </span>
              </td>
              <td style="text-align:center;">
                <span class="label" style="background:<?= $pr->status_badge['bg']; ?>; color:<?= $pr->status_badge['color']; ?>; border-radius:6px; padding:5px 9px; font-weight:700;">
                  <i class="fa <?= $pr->status_badge['icon']; ?>"></i> <?= $pr->status_badge['label']; ?>
                </span>
              </td>
              <td style="text-align:center;">
                <a href="<?= site_url('administrator/rfm?product=' . urlencode($pr->item_name)); ?>" class="btn btn-xs" style="background:#6366f1; color:#fff; border-radius:6px; font-weight:600;"><i class="fa fa-users"></i> Filter Customer</a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr><td colspan="9" class="text-center" style="color:#94a3b8; padding:30px !important;">Tidak ada data produk ditemukan</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
window.addEventListener('DOMContentLoaded', function() {
  var segData = <?= json_encode(array_map(function($d) { return ['segment' => $d['segment'], 'count' => $d['count'], 'color' => $d['badge']['color']]; }, $rfm_distribution['segments'])); ?>;
  
  var labels = segData.map(function(d) { return d.segment; });
  var counts = segData.map(function(d) { return d.count; });
  var colors = ['#f59e0b','#10b981','#6366f1','#3b82f6','#8b5cf6','#64748b','#f97316','#ef4444','#ec4899','#6b7280'];

  // Pie / Doughnut Chart
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
            position: 'bottom',
            labels: {
              font: { size: 11, weight: '600' },
              padding: 10,
              usePointStyle: true,
              pointStyle: 'circle'
            }
          }
        },
        cutout: '60%'
      }
    });
  }

  // Bar Chart
  var barCtx = document.getElementById('rfmBarChart');
  if (barCtx) {
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Jumlah Customer',
          data: counts,
          backgroundColor: colors.map(function(c) { return c + 'dd'; }),
          borderColor: colors,
          borderWidth: 1.5,
          borderRadius: 6,
          borderSkipped: false
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        }
      }
    });
  }

  // Monthly Trend Chart
  var trendCtx = document.getElementById('monthlyTrendChart');
  if (trendCtx) {
    <?php 
    $chart_data = !empty($track_data) ? array_reverse(array_values($track_data)) : [];
    $chart_labels = array_map(function($m) { return $m->period_label; }, $chart_data);
    $chart_spends = array_map(function($m) { return (float)$m->total_spend; }, $chart_data);
    $chart_buyers = array_map(function($m) { return (int)$m->unique_buyers; }, $chart_data);
    ?>
    var trendLabels = <?= json_encode($chart_labels); ?>;
    var trendSpends = <?= json_encode($chart_spends); ?>;
    var trendBuyers = <?= json_encode($chart_buyers); ?>;

    new Chart(trendCtx, {
      type: 'bar',
      data: {
        labels: trendLabels,
        datasets: [
          {
            label: 'Total Omset (Rp)',
            data: trendSpends,
            backgroundColor: 'rgba(16, 185, 129, 0.7)',
            borderColor: '#10b981',
            borderWidth: 2,
            borderRadius: 6,
            yAxisID: 'ySpend',
            order: 2
          },
          {
            label: 'Pembeli Unik',
            data: trendBuyers,
            type: 'line',
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99, 102, 241, 0.15)',
            borderWidth: 3,
            pointBackgroundColor: '#4f46e5',
            pointRadius: 4,
            tension: 0.3,
            yAxisID: 'yBuyers',
            order: 1
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { position: 'top', labels: { font: { weight: '600', size: 12 }, usePointStyle: true } }
        },
        scales: {
          ySpend: {
            type: 'linear',
            display: true,
            position: 'left',
            grid: { color: '#f1f5f9' },
            ticks: {
              callback: function(val) { 
                if (val >= 1000000000) return 'Rp ' + (val/1000000000).toFixed(1) + 'B';
                if (val >= 1000000) return 'Rp ' + (val/1000000).toFixed(0) + 'Jt';
                return 'Rp ' + val.toLocaleString('id-ID');
              }
            }
          },
          yBuyers: {
            type: 'linear',
            display: true,
            position: 'right',
            grid: { drawOnChartArea: false },
            ticks: {
              callback: function(val) { return val + ' cust'; }
            }
          }
        }
      }
    });
  }

  if (window.location.hash === '#section-tracking-monthly') {
    setTimeout(function() {
      var trackEl = document.getElementById('section-tracking-monthly');
      if (trackEl) {
        trackEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
        trackEl.style.boxShadow = '0 0 25px rgba(16, 185, 129, 0.5)';
        trackEl.style.borderColor = '#10b981';
      }
    }, 250);
  }
});
</script>

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


