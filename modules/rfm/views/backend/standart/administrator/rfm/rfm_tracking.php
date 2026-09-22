<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<style>
:root {
  --rfm-primary: #6366f1;
  --rfm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
  --card-radius: 14px;
}

.rfm-tracking-wrapper {
  padding: 5px 0 30px 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

/* Header & Location Navigation Card */
.rfm-header-nav {
  background: var(--rfm-gradient);
  color: #fff;
  padding: 24px 28px 20px 28px;
  border-radius: 16px;
  margin-bottom: 22px;
  box-shadow: 0 12px 30px rgba(30, 27, 75, 0.25);
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
  gap: 16px;
  margin-bottom: 18px;
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
.rfm-header-nav .header-title h2 {
  margin: 0 0 4px 0;
  font-weight: 800;
  font-size: 24px;
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
}
.rfm-header-nav .action-tools .btn {
  border-radius: 9px;
  font-weight: 700;
  font-size: 12px;
  padding: 7px 14px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  transition: all 0.2s ease;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  border: none;
}
.rfm-header-nav .action-tools .btn:hover { transform: translateY(-2px); }

/* Navigation Tab Bar */
.rfm-header-nav .nav-tabs-bar {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
  padding-top: 14px;
  border-top: 1px solid rgba(255,255,255,0.18);
  position: relative;
  z-index: 2;
}
.rfm-header-nav .nav-tab-btn {
  padding: 8px 18px;
  border-radius: 10px;
  font-size: 13px;
  font-weight: 700;
  color: rgba(255,255,255,0.92);
  background: rgba(255,255,255,0.12);
  border: 1px solid rgba(255,255,255,0.22);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
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

.kpi-mini-card {
  background: #ffffff;
  border-radius: 14px;
  padding: 18px 20px;
  border: 1px solid #e2e8f0;
  box-shadow: var(--card-shadow);
  transition: all 0.25s ease;
  height: 100%;
}
.kpi-mini-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
}
.kpi-mini-val {
  font-size: 22px;
  font-weight: 800;
  line-height: 1.2;
}
.kpi-mini-lbl {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-top: 4px;
}

.section-card-custom {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid #e2e8f0;
  box-shadow: var(--card-shadow);
  padding: 22px;
  margin-bottom: 22px;
}

.table-tracking {
  margin-bottom: 0;
}
.table-tracking th {
  background: #f8fafc;
  color: #334155;
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 12px 14px !important;
  border-bottom: 2px solid #e2e8f0 !important;
  vertical-align: middle !important;
  white-space: nowrap;
}
.table-tracking td {
  padding: 12px 14px !important;
  vertical-align: middle !important;
  border-top: 1px solid #f1f5f9 !important;
  font-size: 12.5px;
  color: #334155;
}
.table-tracking tr:hover {
  background-color: #f8fafc !important;
}

/* Animations */
@keyframes rfmFadeInUp {
  from { opacity: 0; transform: translateY(14px); }
  to { opacity: 1; transform: translateY(0); }
}
.rfm-header-nav, .kpi-mini-card, .section-card-custom {
  animation: rfmFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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

/* Mobile Responsive Media Queries */
@media (max-width: 991px) {
  .rfm-header-nav { padding: 20px 22px; }
  .chart-box-responsive { height: 280px !important; }
}

@media (max-width: 767px) {
  .rfm-header-nav { padding: 18px 16px; text-align: center; }
  .rfm-header-nav .header-top-flex { flex-direction: column; align-items: center; }
  .rfm-header-nav .header-title h2 { font-size: 20px; }
  .rfm-header-nav .header-title p { font-size: 12px; }
  .rfm-header-nav .action-tools { width: 100%; justify-content: center; }
  .rfm-header-nav .action-tools .btn { font-size: 11.5px; padding: 6px 10px; }
  .rfm-header-nav .nav-tabs-bar { justify-content: center; width: 100%; }
  .rfm-header-nav .nav-tab-btn { width: 100%; justify-content: center; padding: 10px; font-size: 12.5px; }
  
  .kpi-mini-card { padding: 14px 16px; }
  .kpi-mini-val { font-size: 18px; }
  .kpi-mini-lbl { font-size: 10px; }
  .section-card-custom { padding: 16px; border-radius: 12px; margin-bottom: 16px; }
  .chart-box-responsive { height: 240px !important; }
}
</style>

<div class="rfm-tracking-wrapper">
  <!-- ==========================================
       LAYER 1: HEADER & LOCATION NAVIGATION
       ========================================== -->
  <div class="rfm-header-nav">
    <!-- Top Row: Title, Subtitle & Action Tools -->
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> Analisis RFM <i class="fa fa-angle-right"></i> <span>Tracking & Tren Bulanan</span>
        </div>
        <h2><i class="fa fa-line-chart" style="color:#818cf8;"></i> Tracking & Tren RFM Bulanan</h2>
        <p>Rekapitulasi historis omset (monetary), frekuensi order, dan pembeli unik per bulan <?= !empty($product_filter) ? 'untuk produk: <strong>' . htmlspecialchars($product_filter) . '</strong>' : '(Seluruh Produk)'; ?></p>
      </div>

      <?php
        $nav_params = array_filter(['product' => $product_filter ?? '', 'period' => $period_filter ?? '']);
        $nav_qs = !empty($nav_params) ? '?' . http_build_query($nav_params) : '';
      ?>
      <div class="action-tools">
        <a href="<?= site_url('administrator/crm/chat'); ?>" class="btn" style="background:linear-gradient(135deg, #075e54, #128c7e); color:#fff; box-shadow:0 4px 12px rgba(18,140,126,0.35);" title="Live Chat WA"><i class="fa fa-whatsapp"></i> Live Chat WA</a>
        <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn" style="background:#25D366; color:#fff;" title="Broadcast WA"><i class="fa fa-bullhorn"></i> Broadcast WA</a>
        <button type="button" class="btn" data-toggle="modal" data-target="#modal-import-excel" style="background:#10b981; color:#fff; box-shadow:0 4px 12px rgba(16,185,129,0.35);"><i class="fa fa-file-excel-o"></i> Import Excel Data</button>
        <a href="<?= site_url('administrator/rfm/export_customers' . $nav_qs); ?>" class="btn" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-download"></i> Export CSV</a>
      </div>
    </div>

    <!-- Bottom Row: Navigation Tabs Bar (Clear Location Indicator) -->
    <div class="nav-tabs-bar">
      <a href="<?= site_url('administrator/rfm/dashboard' . $nav_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-tachometer"></i> 1. Dashboard RFM
      </a>
      <a href="<?= site_url('administrator/rfm' . $nav_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-users"></i> 2. Daftar Customer
      </a>
      <a href="<?= site_url('administrator/rfm/tracking' . $nav_qs); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-line-chart"></i> 3. Tracking RFM Bulanan
      </a>
    </div>
  </div>

  <!-- ==========================================
       LAYER 2: FILTER CONTROL BAR
       ========================================== -->
  <div class="section-card-custom" style="padding:16px 22px; margin-bottom:20px;">
    <form method="GET" action="<?= site_url('administrator/rfm/tracking'); ?>" id="form-filter-tracking">
      <div class="row" style="display:flex; align-items:center; flex-wrap:wrap; margin:0 -8px;">
        <div class="col-md-5 col-sm-6 col-xs-12" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-shopping-bag" style="color:#059669;"></i> Filter Produk:
          </label>
          <select name="product" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12.5px; font-weight:600;">
            <option value="">-- Semua Produk (Keseluruhan) --</option>
            <?php foreach ($products_list as $prod): 
              $p_name = is_object($prod) ? $prod->item_name : (is_array($prod) ? ($prod['item_name'] ?? '') : (string)$prod);
              if (empty($p_name)) continue;
            ?>
            <option value="<?= htmlspecialchars($p_name); ?>" <?= (!empty($product_filter) && $product_filter === $p_name) ? 'selected' : ''; ?>>
              <?= htmlspecialchars($p_name); ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-calendar" style="color:#6366f1;"></i> Filter Bulan / Periode:
          </label>
          <select name="period" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12.5px; font-weight:600;">
            <option value="">-- Semua Periode Bulanan --</option>
            <?php foreach ($months_list as $m): 
              $m_val = is_object($m) ? $m->ym_val : ($m['ym_val'] ?? '');
              $m_lbl = is_object($m) ? $m->ym_label : ($m['ym_label'] ?? '');
            ?>
            <option value="<?= htmlspecialchars($m_val); ?>" <?= (!empty($period_filter) && $period_filter === $m_val) ? 'selected' : ''; ?>>
              📅 <?= htmlspecialchars($m_lbl); ?> (<?= $m_val; ?>)
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3 col-sm-12 col-xs-12" style="padding:0 8px; margin-bottom:8px; display:flex; gap:8px; align-items:flex-end;">
          <button type="submit" class="btn btn-primary" style="background:#6366f1; border:none; border-radius:8px; font-weight:700; height:38px; flex:1; margin-top:21px; display:inline-flex; align-items:center; justify-content:center; gap:6px; box-shadow:0 2px 6px rgba(99,102,241,0.3);">
            <i class="fa fa-filter"></i> Filter
          </button>
          <?php if (!empty($product_filter) || !empty($period_filter)): ?>
          <a href="<?= site_url('administrator/rfm/tracking'); ?>" class="btn btn-default" style="border-radius:8px; font-weight:600; height:38px; margin-top:21px; border:1px solid #cbd5e1; color:#64748b; display:inline-flex; align-items:center; justify-content:center;" title="Reset Filter">
            <i class="fa fa-refresh"></i> Reset
          </a>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </div>

  <!-- ==========================================
       LAYER 3: 4 MINI SUMMARY STATS CARDS
       ========================================== -->
  <?php 
  $track_data = $monthly_tracking ?? [];
  $track_cnt = $kpi_tracking['track_cnt'] ?? count($track_data);
  $total_sum_spend = $kpi_tracking['total_sum_spend'] ?? 0;
  $avg_sum_spend = $kpi_tracking['avg_sum_spend'] ?? 0;
  $total_sum_buyers = $kpi_tracking['total_sum_buyers'] ?? 0;
  $avg_sum_buyers = $kpi_tracking['avg_sum_buyers'] ?? 0;
  $total_sum_orders = $kpi_tracking['total_sum_orders'] ?? 0;
  ?>

  <div class="row" style="margin-bottom:22px;">
    <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #10b981;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#15803d;"><?= number_format($track_cnt); ?> Bulan</div>
            <div class="kpi-mini-lbl" style="color:#166534;">Total Periode Teracak</div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#dcfce7; color:#166534; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-calendar-check-o"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #3b82f6;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#1d4ed8; font-size:18px;">Rp <?= number_format($avg_sum_spend, 0, ',', '.'); ?></div>
            <div class="kpi-mini-lbl" style="color:#1e40af;">Rata2 Omset / Bulan</div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#dbeafe; color:#1e40af; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-money"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #8b5cf6;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#6b21a8;"><?= number_format($avg_sum_buyers); ?> Cust</div>
            <div class="kpi-mini-lbl" style="color:#7e22ce;">Rata2 Pembeli / Bulan</div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#f3e8ff; color:#7e22ce; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-users"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #f97316;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#c2410c;"><?= number_format($total_sum_orders); ?>x</div>
            <div class="kpi-mini-lbl" style="color:#ea580c;">Total Transaksi (F)</div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#ffedd5; color:#c2410c; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-shopping-cart"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ==========================================
       LAYER 4: MONTHLY DUAL-AXIS VISUAL TREND CHART
       ========================================== -->
  <?php if (!empty($track_data)): ?>
  <div class="section-card-custom">
    <div style="font-weight:800; font-size:15px; color:#0f172a; margin-bottom:16px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
      <span><i class="fa fa-area-chart" style="color:#059669; font-size:18px; margin-right:6px;"></i> Grafik Historis Omset (Rp) & Pembeli Unik Per Bulan</span>
      <span class="badge" style="background:#ecfdf5; color:#047857; font-weight:700; padding:6px 12px; font-size:11.5px; border:1px solid #a7f3d0;"><i class="fa fa-bar-chart"></i> Dual-Axis Analytics</span>
    </div>
    <div class="chart-box-responsive" style="position:relative; height:320px; width:100%;">
      <canvas id="monthlyTrendChart"></canvas>
    </div>
  </div>
  <?php endif; ?>

  <!-- ==========================================
       LAYER 5: MONTHLY PERFORMANCE DATA TABLE
       ========================================== -->
  <div class="section-card-custom" style="padding:0; overflow:hidden;">
    <div style="padding:18px 22px; background:#fafbfc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
      <h3 style="margin:0; font-size:15px; font-weight:800; color:#0f172a; display:flex; align-items:center; gap:8px;">
        <i class="fa fa-table" style="color:#6366f1;"></i> Tabel Rekapitulasi Performa Bulanan
      </h3>
      <span style="font-size:12px; color:#64748b; font-weight:600;">
        Total Data: <strong><?= count($track_data); ?> Periode Bulan</strong>
      </span>
    </div>

    <div class="table-responsive" style="overflow-x:auto;">
      <table class="table table-hover table-striped table-tracking" style="min-width:880px;">
        <thead>
          <tr>
            <th style="width:4%;">#</th>
            <th style="min-width:150px;">Bulan / Periode</th>
            <th style="text-align:center; min-width:130px;">Pembeli Unik</th>
            <th style="text-align:center; min-width:130px;">Jumlah Order (F)</th>
            <th style="text-align:center; min-width:100px;">Total Qty</th>
            <th style="text-align:right; min-width:170px;">Total Omset (Monetary)</th>
            <th style="text-align:center; min-width:130px;">Tren Omset (MoM)</th>
            <th style="text-align:center; min-width:130px;">Rata2 Recency (R)</th>
            <th style="text-align:center; min-width:140px;">Aksi / Filter</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($track_data)): ?>
          <tr>
            <td colspan="9" class="text-center" style="padding:40px !important; color:#94a3b8;">
              <i class="fa fa-calendar-o" style="font-size:32px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
              <strong style="font-size:14px; display:block; color:#64748b;">Belum Ada Data Transaksi Bulanan</strong>
              <span style="font-size:12px;">Tidak ditemukan rekapan transaksi untuk kriteria filter ini.</span>
            </td>
          </tr>
          <?php else: ?>
          <?php 
          $m_no = 1; 
          $track_list = array_values($track_data);
          foreach ($track_list as $idx => $mt): 
            $is_active_m = (!empty($period_filter) && $period_filter === $mt->ym_period);
            
            // Calculate Month-over-Month (MoM) growth percentage
            $prev_spend = isset($track_list[$idx + 1]) ? (float)$track_list[$idx + 1]->total_spend : 0;
            $growth_pct = 0;
            if ($prev_spend > 0) {
              $growth_pct = round((($mt->total_spend - $prev_spend) / $prev_spend) * 100, 1);
            }
          ?>
          <tr<?= $is_active_m ? ' style="background:#ecfdf5; border-left:4px solid #10b981;"' : ''; ?>>
            <td><?= $m_no++; ?></td>
            <td>
              <strong style="color:#0f172a; font-size:13.5px;"><i class="fa fa-calendar" style="color:#6366f1; margin-right:5px;"></i> <?= htmlspecialchars($mt->period_label); ?></strong>
              <code style="font-size:10.5px; background:#f1f5f9; padding:2px 6px; border-radius:4px; margin-left:4px; color:#475569; font-weight:600;"><?= htmlspecialchars($mt->ym_period); ?></code>
              <?php if ($is_active_m): ?>
              <span class="label" style="background:#059669; color:#fff; font-size:10px; margin-left:4px; padding:2px 6px; border-radius:8px;">Aktif</span>
              <?php endif; ?>
            </td>
            <td style="text-align:center;">
              <span class="label" style="background:#e0e7ff; color:#3730a3; font-size:12px; font-weight:800; padding:6px 12px; border-radius:6px; display:inline-block;">
                <i class="fa fa-user"></i> <?= number_format($mt->unique_buyers); ?> Customer
              </span>
            </td>
            <td style="text-align:center;">
              <strong style="color:#0f172a; font-size:13px;"><?= number_format($mt->total_orders); ?>x</strong> <span style="font-size:11px; color:#64748b;">Order</span>
            </td>
            <td style="text-align:center; color:#475569; font-weight:600;">
              <?= number_format($mt->total_qty); ?> pcs
            </td>
            <td style="text-align:right;">
              <strong style="color:#16a34a; font-size:14px;">Rp <?= number_format($mt->total_spend, 0, ',', '.'); ?></strong>
            </td>
            <td style="text-align:center;">
              <?php if ($prev_spend <= 0): ?>
              <span class="label" style="background:#f1f5f9; color:#64748b; font-size:11px; font-weight:600;">-- (Awal)</span>
              <?php elseif ($growth_pct > 0): ?>
              <span class="label" style="background:#dcfce7; color:#15803d; font-size:11.5px; font-weight:800; padding:4px 8px; border-radius:6px;">
                <i class="fa fa-arrow-up"></i> +<?= $growth_pct; ?>%
              </span>
              <?php elseif ($growth_pct < 0): ?>
              <span class="label" style="background:#fee2e2; color:#b91c1c; font-size:11.5px; font-weight:800; padding:4px 8px; border-radius:6px;">
                <i class="fa fa-arrow-down"></i> <?= $growth_pct; ?>%
              </span>
              <?php else: ?>
              <span class="label" style="background:#fef3c7; color:#92400e; font-size:11.5px; font-weight:700; padding:4px 8px; border-radius:6px;">
                0.0%
              </span>
              <?php endif; ?>
            </td>
            <td style="text-align:center;">
              <?php $r_days = is_object($mt) ? ($mt->avg_recency_days ?? $mt->avg_recency ?? 0) : ($mt['avg_recency_days'] ?? $mt['avg_recency'] ?? 0); ?>
              <span class="label" style="background:<?= $r_days <= 30 ? '#dcfce7; color:#166534;' : ($r_days <= 90 ? '#fef3c7; color:#92400e;' : '#fee2e2; color:#991b1b;'); ?> border-radius:6px; padding:5px 99px; font-weight:700; padding:5px 9px;">
                <i class="fa fa-clock-o"></i> <?= round($r_days); ?> hr lalu
              </span>
            </td>
            <td style="text-align:center;">
              <a href="<?= site_url('administrator/rfm?period=' . urlencode($mt->ym_period) . (!empty($product_filter) ? '&product=' . urlencode($product_filter) : '')); ?>" class="btn btn-xs" style="background:#6366f1; color:#fff; border-radius:6px; font-weight:600; padding:5px 10px;" title="Filter Customer di Bulan Ini">
                <i class="fa fa-users"></i> Filter Customer
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
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

<script>
window.addEventListener('DOMContentLoaded', function() {
  // Initialize Dual-Axis Chart.js
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
            backgroundColor: 'rgba(16, 185, 129, 0.75)',
            borderColor: '#10b981',
            borderWidth: 2,
            borderRadius: 6,
            yAxisID: 'ySpend',
            order: 2
          },
          {
            label: 'Pembeli Unik (Customer)',
            data: trendBuyers,
            type: 'line',
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99, 102, 241, 0.15)',
            borderWidth: 3,
            pointBackgroundColor: '#4f46e5',
            pointRadius: 5,
            pointHoverRadius: 7,
            tension: 0.35,
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
          legend: { 
            position: 'top', 
            labels: { font: { weight: '700', size: 12 }, usePointStyle: true, padding: 15 } 
          },
          tooltip: {
            padding: 12,
            backgroundColor: 'rgba(15, 23, 42, 0.9)',
            titleFont: { size: 13, weight: '700' },
            bodyFont: { size: 12 },
            callbacks: {
              label: function(context) {
                var label = context.dataset.label || '';
                if (label) label += ': ';
                if (context.dataset.yAxisID === 'ySpend') {
                  label += 'Rp ' + Number(context.raw).toLocaleString('id-ID');
                } else {
                  label += context.raw + ' Customer';
                }
                return label;
              }
            }
          }
        },
        scales: {
          ySpend: {
            type: 'linear',
            display: true,
            position: 'left',
            grid: { color: '#f1f5f9' },
            ticks: {
              font: { weight: '600', size: 11 },
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
              font: { weight: '600', size: 11 },
              callback: function(val) { return val + ' cust'; }
            }
          },
          x: {
            grid: { display: false },
            ticks: { font: { weight: '600', size: 11 } }
          }
        }
      }
    });
  }
});
</script>
