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
  padding: 12px 14px 30px 14px;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
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

.kpi-mini-card {
  background: #ffffff;
  border-radius: 14px;
  padding: 16px 18px;
  border: 1px solid #e2e8f0;
  box-shadow: var(--card-shadow);
  cursor: pointer;
  transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.22s ease, border-color 0.22s ease;
  height: 100%;
  user-select: none;
}
.kpi-mini-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
  border-color: #cbd5e1;
}
.kpi-mini-card:active {
  transform: translateY(-1px) scale(0.99);
}
.kpi-mini-val {
  font-size: 20px;
  font-weight: 800;
  line-height: 1.2;
}
.kpi-mini-lbl {
  font-size: 10.5px;
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
  padding: 20px;
  margin-bottom: 20px;
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
  .rfm-header-nav { padding: 18px 20px; }
  .chart-box-responsive { height: 280px !important; }
}

@media (max-width: 767px) {
  .rfm-tracking-wrapper { padding: 8px 8px 20px 8px; }
  .rfm-header-nav { padding: 16px 14px; border-radius: 12px; }
  .rfm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; }
  .rfm-header-nav .header-title h2 { font-size: 18px; }
  .rfm-header-nav .header-title p { font-size: 11.5px; }
  .rfm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .rfm-header-nav .action-tools .btn { font-size: 11px; padding: 6px 10px; flex: 1 1 auto; min-width: 110px; }
  .rfm-header-nav .nav-tabs-bar { padding-top: 10px; gap: 6px; }
  .rfm-header-nav .nav-tab-btn { padding: 7px 12px; font-size: 11.5px; }
  
  .kpi-mini-card { padding: 12px 14px; }
  .kpi-mini-val { font-size: 17px; }
  .kpi-mini-lbl { font-size: 9.5px; }
  .section-card-custom { padding: 14px; border-radius: 12px; margin-bottom: 14px; }
  .chart-box-responsive { height: 240px !important; }
  .modal-dialog {
    width: 94% !important;
    max-width: 520px !important;
    margin: 15px auto !important;
  }
  .modal-content {
    border-radius: 12px !important;
  }
}

@media (max-width: 575px) {
  .rfm-header-nav { padding: 14px 12px; }
  .rfm-header-nav .header-title h2 { font-size: 16px; }
  .rfm-header-nav .action-tools .btn { font-size: 10.5px; padding: 5px 8px; min-width: 0; }
  .kpi-mini-val { font-size: 15px; }
  .kpi-mini-lbl { font-size: 9px; }
  .section-card-custom { padding: 12px; margin-bottom: 12px; }
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
        <p>Grafik dan tabel rekapitulasi riwayat omset, jumlah transaksi, dan pertumbuhan pembeli baru <?= !empty($period_filter) ? 'periode <strong>' . htmlspecialchars(!empty($track_data[0]->period_label) ? $track_data[0]->period_label : $period_filter) . '</strong>' : 'setiap bulannya'; ?> <?= !empty($product_filter) ? 'untuk produk: <strong>' . htmlspecialchars($product_filter) . '</strong>' : '(Semua Produk)'; ?></p>
      </div>

      <?php
        $nav_params = array_filter(['product' => $product_filter ?? '', 'period' => $period_filter ?? '', 'year' => $year_filter ?? '', 'kategori' => $category_filter ?? '']);
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
       LAYER 2: FILTER CONTROL BAR
       ========================================== -->
  <div class="section-card-custom" style="padding:16px 22px; margin-bottom:20px;">
    <form method="GET" action="<?= site_url('administrator/rfm/tracking'); ?>" id="form-filter-tracking">
      <div class="row" style="display:flex; align-items:center; flex-wrap:wrap; margin:0 -8px;">
        <div class="col-md-3 col-sm-6 col-xs-12" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-folder-open-o" style="color:#0284c7;"></i> Filter Kategori:
          </label>
          <select name="kategori" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12.5px; font-weight:600;" onchange="this.form.submit();">
            <option value="">-- Semua Kategori --</option>
            <?php if (!empty($categories_list)): ?>
              <?php foreach ($categories_list as $cat): 
                $c_name = is_object($cat) ? $cat->nama_kategori : (is_array($cat) ? ($cat['nama_kategori'] ?? '') : (string)$cat);
                if (empty($c_name)) continue;
              ?>
              <option value="<?= htmlspecialchars($c_name); ?>" <?= (!empty($category_filter) && $category_filter === $c_name) ? 'selected' : ''; ?>>
                📁 <?= htmlspecialchars($c_name); ?>
              </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-shopping-bag" style="color:#059669;"></i> Filter Produk:
          </label>
          <select name="product" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12.5px; font-weight:600;">
            <option value="">-- Semua Produk (Keseluruhan) --</option>
            <?php 
            $grouped_prods = [];
            foreach ($products_list as $prod) {
              $p_name = is_object($prod) ? $prod->item_name : (is_array($prod) ? ($prod['item_name'] ?? '') : (string)$prod);
              $p_cat = is_object($prod) ? ($prod->nama_kategori ?? 'Lainnya') : (is_array($prod) ? ($prod['nama_kategori'] ?? 'Lainnya') : 'Lainnya');
              if (empty($p_cat)) $p_cat = 'Tanpa Kategori';
              if (empty($p_name)) continue;
              $grouped_prods[$p_cat][] = $p_name;
            }
            ksort($grouped_prods);
            ?>
            <?php foreach ($grouped_prods as $kat => $prods): ?>
              <optgroup label="📂 <?= htmlspecialchars($kat); ?>">
                <?php foreach ($prods as $p_name): ?>
                  <option value="<?= htmlspecialchars($p_name); ?>" <?= (!empty($product_filter) && $product_filter === $p_name) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($p_name); ?>
                  </option>
                <?php endforeach; ?>
              </optgroup>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-2 col-sm-4 col-xs-6" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-calendar-o" style="color:#8b5cf6;"></i> Filter Tahun:
          </label>
          <select name="year" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12.5px; font-weight:600;">
            <option value="">-- Semua Tahun --</option>
            <?php if (!empty($available_years)): ?>
              <?php foreach ($available_years as $yr): ?>
              <option value="<?= $yr->yr; ?>" <?= (isset($year_filter) && $year_filter == $yr->yr) ? 'selected' : ''; ?>>
                <?= $yr->yr; ?>
              </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <div class="col-md-2 col-sm-4 col-xs-6" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-calendar" style="color:#6366f1;"></i> Filter Periode:
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

        <div class="col-md-2 col-sm-4 col-xs-12" style="padding:0 8px; margin-bottom:8px; display:flex; gap:8px; align-items:flex-end;">
          <button type="submit" class="btn btn-primary" style="background:#6366f1; border:none; border-radius:8px; font-weight:700; height:38px; flex:1; margin-top:21px; display:inline-flex; align-items:center; justify-content:center; gap:6px; box-shadow:0 2px 6px rgba(99,102,241,0.3);">
            <i class="fa fa-filter"></i> Filter
          </button>
          <?php if (!empty($product_filter) || !empty($period_filter) || !empty($year_filter) || !empty($category_filter)): ?>
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
  $total_sum_profit = $kpi_tracking['total_sum_profit'] ?? array_sum(array_column($track_data, 'total_profit'));
  $avg_sum_profit = $kpi_tracking['avg_sum_profit'] ?? ($track_cnt > 0 ? $total_sum_profit / $track_cnt : 0);
  $total_sum_buyers = $kpi_tracking['total_sum_buyers'] ?? 0;
  $avg_sum_buyers = $kpi_tracking['avg_sum_buyers'] ?? 0;
  $total_sum_orders = $kpi_tracking['total_sum_orders'] ?? 0;
  $is_filtered_period = !empty($period_filter);
  
  // Latest profit trend
  $latest_mt = !empty($track_data) ? array_values($track_data)[0] : null;
  $latest_profit_status = $latest_mt ? ($latest_mt->profit_status ?? 'naik') : 'naik';
  $latest_profit_pct = $latest_mt ? ($latest_mt->profit_growth_pct ?? 0) : 0;
  ?>

  <?php if ($is_filtered_period): ?>
  <div style="background:#eff6ff; border:1px solid #bfdbfe; border-left:4px solid #3b82f6; border-radius:12px; padding:14px 18px; margin-bottom:18px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
    <div style="font-size:12.5px; color:#1e40af; line-height:1.5;">
      <i class="fa fa-info-circle" style="font-size:16px; margin-right:6px; color:#2563eb;"></i>
      <strong>Filter Periode Aktif: <?= htmlspecialchars($track_data[0]->period_label ?? $period_filter); ?></strong> &bull;
      Menampilkan <strong><?= number_format($total_sum_orders); ?> transaksi</strong> dengan omset <strong>Rp <?= number_format($total_sum_spend, 0, ',', '.'); ?></strong> dari <strong><?= number_format($total_sum_buyers); ?> pembeli aktif</strong>.
      <?php if ($period_filter === '2026-10'): ?>
        <div style="margin-top:4px; color:#2563eb; font-size:11.5px;">
          <i class="fa fa-clock-o"></i> <em>Catatan: Bulan Oktober 2026 merupakan bulan berjalan (baru tanggal 1–3 Oktober), sehingga akumulasi transaksi masih bergerak dan akan terus bertambah.</em>
        </div>
      <?php endif; ?>
    </div>
    <a href="<?= site_url('administrator/rfm/tracking'); ?>" class="btn btn-xs btn-default" style="font-weight:700; border-radius:6px; background:#fff; border:1px solid #93c5fd; color:#1d4ed8; padding:5px 12px;">
      <i class="fa fa-refresh"></i> Tampilkan Semua Bulan
    </a>
  </div>
  <?php endif; ?>

  <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px; margin-bottom:22px;">
    <div>
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="var el=document.getElementById('section-monthly-table'); if(el){ el.scrollIntoView({behavior:'smooth'}); }" title="Klik untuk menuju ke tabel rekapitulasi performa bulanan" style="border-left:4px solid #10b981;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <?php if ($is_filtered_period): ?>
              <div class="kpi-mini-val" style="color:#15803d; font-size:16px;"><?= !empty($track_data[0]->period_label) ? htmlspecialchars($track_data[0]->period_label) : $period_filter; ?></div>
              <div class="kpi-mini-lbl" style="color:#166534;">Periode Terpilih &darr;</div>
            <?php else: ?>
              <div class="kpi-mini-val" style="color:#15803d;"><?= number_format($track_cnt); ?> Bulan</div>
              <div class="kpi-mini-lbl" style="color:#166534;">Total Bulan Terdata &darr;</div>
            <?php endif; ?>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#dcfce7; color:#166534; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-calendar-check-o"></i>
          </div>
        </div>
      </div>
    </div>

    <div>
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="var el=document.getElementById('section-monthly-chart'); if(el){ el.scrollIntoView({behavior:'smooth'}); }" title="Klik untuk melihat grafik historis tren omset bulanan" style="border-left:4px solid #3b82f6;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <?php if ($is_filtered_period): ?>
              <div class="kpi-mini-val" style="color:#1d4ed8; font-size:17px;">Rp <?= number_format($total_sum_spend, 0, ',', '.'); ?></div>
              <div class="kpi-mini-lbl" style="color:#1e40af;">Total Omset Bulan Ini &darr;</div>
            <?php else: ?>
              <div class="kpi-mini-val" style="color:#1d4ed8; font-size:17px;">Rp <?= number_format($avg_sum_spend, 0, ',', '.'); ?></div>
              <div class="kpi-mini-lbl" style="color:#1e40af;">Rata-rata Omset / Bulan &darr;</div>
            <?php endif; ?>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#dbeafe; color:#1e40af; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-money"></i>
          </div>
        </div>
      </div>
    </div>

    <div>
      <?php 
        $display_profit = $is_filtered_period ? $total_sum_profit : $avg_sum_profit; 
        $profit_lbl = $is_filtered_period ? 'Estimasi Laba Bulan Ini &darr;' : 'Rata-rata Laba / Bulan &darr;';
      ?>
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="var el=document.getElementById('section-monthly-chart'); if(el){ el.scrollIntoView({behavior:'smooth'}); }" title="Klik untuk melihat grafik tren laba bersih bulanan" style="border-left:4px solid <?= $display_profit < 0 ? '#ef4444' : '#059669'; ?>; background:linear-gradient(135deg, #ffffff, <?= $display_profit < 0 ? '#fef2f2' : '#f0fdf4'; ?>);">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:<?= $display_profit < 0 ? '#b91c1c' : '#047857'; ?>; font-size:17px;">
              Rp <?= number_format($display_profit, 0, ',', '.'); ?>
            </div>
            <div class="kpi-mini-lbl" style="color:<?= $display_profit < 0 ? '#991b1b' : '#065f46'; ?>; display:flex; align-items:center; gap:4px; margin-top:3px;">
              <span><?= $profit_lbl; ?></span>
              <?php if ($display_profit < 0 || $latest_profit_status === 'rugi'): ?>
                <span class="badge" style="background:#fee2e2; color:#b91c1c; font-size:10px; padding:2px 6px;">📉 Defisit</span>
              <?php elseif ($latest_profit_status === 'naik'): ?>
                <span class="badge" style="background:#dcfce7; color:#15803d; font-size:10px; padding:2px 6px;">📈 Naik</span>
              <?php else: ?>
                <span class="badge" style="background:#fee2e2; color:#b91c1c; font-size:10px; padding:2px 6px;">📉 Turun</span>
              <?php endif; ?>
            </div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:<?= $display_profit < 0 ? '#fee2e2' : '#d1fae5'; ?>; color:<?= $display_profit < 0 ? '#b91c1c' : '#047857'; ?>; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-line-chart"></i>
          </div>
        </div>
      </div>
    </div>

    <div>
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm' . $nav_qs); ?>';" title="Klik untuk membuka dan melihat daftar customer di Daftar Customer RFM" style="border-left:4px solid #8b5cf6;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <?php if ($is_filtered_period): ?>
              <div class="kpi-mini-val" style="color:#6b21a8;"><?= number_format($total_sum_buyers); ?> Orang</div>
              <div class="kpi-mini-lbl" style="color:#7e22ce;">Pembeli Aktif Bulan Ini &rarr;</div>
            <?php else: ?>
              <div class="kpi-mini-val" style="color:#6b21a8;"><?= number_format($avg_sum_buyers); ?> Orang</div>
              <div class="kpi-mini-lbl" style="color:#7e22ce;">Rata-rata Pembeli / Bulan &rarr;</div>
            <?php endif; ?>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#f3e8ff; color:#7e22ce; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-users"></i>
          </div>
        </div>
      </div>
    </div>

    <div>
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="var el=document.getElementById('section-monthly-table'); if(el){ el.scrollIntoView({behavior:'smooth'}); }" title="Klik untuk melihat rincian transaksi di tabel bulanan" style="border-left:4px solid #f97316;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <?php if ($is_filtered_period): ?>
              <div class="kpi-mini-val" style="color:#c2410c;"><?= number_format($total_sum_orders); ?>x</div>
              <div class="kpi-mini-lbl" style="color:#ea580c;">Total Transaksi Bulan Ini &darr;</div>
            <?php else: ?>
              <div class="kpi-mini-val" style="color:#c2410c;"><?= number_format($total_sum_orders); ?>x</div>
              <div class="kpi-mini-lbl" style="color:#ea580c;">Total Transaksi (F) &darr;</div>
            <?php endif; ?>
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
  <div class="section-card-custom" id="section-monthly-chart">
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
  <div class="section-card-custom" id="section-monthly-table" style="padding:0; overflow:hidden;">
    <div style="padding:18px 22px; background:#fafbfc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
      <h3 style="margin:0; font-size:15px; font-weight:800; color:#0f172a; display:flex; align-items:center; gap:8px;">
        <i class="fa fa-table" style="color:#6366f1;"></i> Tabel Rekapitulasi Performa Bulanan & Profit
      </h3>
      <span style="font-size:12px; color:#64748b; font-weight:600;">
        <?php if ($is_filtered_period): ?>
          Menampilkan Data: <strong>Periode <?= htmlspecialchars($track_data[0]->period_label ?? $period_filter); ?></strong>
        <?php else: ?>
          Total Data: <strong><?= count($track_data); ?> Periode Bulan</strong>
        <?php endif; ?>
      </span>
    </div>

    <div class="table-responsive" style="overflow-x:auto;">
      <table class="table table-hover table-striped table-tracking" style="min-width:1050px;">
        <thead>
          <tr>
            <th style="width:3%;">#</th>
            <th style="min-width:140px;">Bulan / Periode</th>
            <th style="text-align:center; min-width:120px;">Pembeli Unik</th>
            <th style="text-align:center; min-width:110px;">Jumlah Order (F)</th>
            <th style="text-align:center; min-width:90px;">Total Qty</th>
            <th style="text-align:right; min-width:160px;">Total Omset (Monetary)</th>
            <th style="text-align:center; min-width:110px;">Tren Omset</th>
            <th style="text-align:right; min-width:160px; background:#f0fdf4; color:#166534;">Estimasi Profit</th>
            <th style="text-align:center; min-width:140px; background:#f0fdf4; color:#166534;">Tren Profit (Naik/Turun)</th>
            <th style="text-align:center; min-width:120px;">Rata2 Recency (R)</th>
            <th style="text-align:center; min-width:120px;">Aksi / Filter</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($track_data)): ?>
          <tr>
            <td colspan="11" class="text-center" style="padding:40px !important; color:#94a3b8;">
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
            $prev_spend = isset($mt->prev_spend) ? (float)$mt->prev_spend : (isset($track_list[$idx + 1]) ? (float)$track_list[$idx + 1]->total_spend : 0);
            $growth_pct = isset($mt->mom_growth_pct) ? (float)$mt->mom_growth_pct : 0;
            if (!isset($mt->mom_growth_pct) && $prev_spend > 0) {
              $growth_pct = round((($mt->total_spend - $prev_spend) / $prev_spend) * 100, 1);
            }

            // Profit calculation & status
            $prev_profit = isset($mt->prev_profit) ? (float)$mt->prev_profit : (isset($track_list[$idx + 1]) ? (float)$track_list[$idx + 1]->total_profit : 0);
            $profit_pct = isset($mt->profit_growth_pct) ? (float)$mt->profit_growth_pct : 0;
            if (!isset($mt->profit_growth_pct) && $prev_profit > 0) {
              $profit_pct = round((($mt->total_profit - $prev_profit) / $prev_profit) * 100, 1);
            }
            $is_profit_up = (isset($mt->profit_status) && $mt->profit_status === 'naik') || $profit_pct >= 0;
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
            <td style="text-align:right; background:<?= ($mt->total_profit ?? 0) < 0 ? '#fef2f2' : '#f0fdf4'; ?>;">
              <strong style="color:<?= ($mt->total_profit ?? 0) < 0 ? '#b91c1c' : '#047857'; ?>; font-size:14px;">Rp <?= number_format($mt->total_profit ?? 0, 0, ',', '.'); ?></strong>
            </td>
            <td style="text-align:center; background:<?= ($mt->total_profit ?? 0) < 0 ? '#fef2f2' : '#f0fdf4'; ?>;">
              <?php if (($mt->total_profit ?? 0) < 0): ?>
                <span class="label" style="background:#fee2e2; color:#b91c1c; font-size:11.5px; font-weight:800; padding:4px 8px; border-radius:6px;" title="Rugi / Defisit Operasional">
                  📉 Defisit / Rugi
                </span>
              <?php elseif ($prev_profit <= 0): ?>
                <span class="label" style="background:#f1f5f9; color:#64748b; font-size:11px; font-weight:600;">-- (Awal)</span>
              <?php elseif ($is_profit_up): ?>
                <span class="label" style="background:#dcfce7; color:#15803d; font-size:11.5px; font-weight:800; padding:4px 8px; border-radius:6px;" title="Profit Naik dari Bulan Sebelumnya">
                  📈 Naik <?= $profit_pct > 0 ? '+'.$profit_pct.'%' : ''; ?>
                </span>
              <?php else: ?>
                <span class="label" style="background:#fee2e2; color:#b91c1c; font-size:11.5px; font-weight:800; padding:4px 8px; border-radius:6px;" title="Profit Turun dari Bulan Sebelumnya">
                  📉 Turun <?= $profit_pct < 0 ? $profit_pct.'%' : ''; ?>
                </span>
              <?php endif; ?>
            </td>
            <td style="text-align:center;">
              <?php $r_days = is_object($mt) ? ($mt->avg_recency_days ?? $mt->avg_recency ?? 0) : ($mt['avg_recency_days'] ?? $mt['avg_recency'] ?? 0); ?>
              <span class="label" style="background:<?= $r_days <= 30 ? '#dcfce7; color:#166534;' : ($r_days <= 90 ? '#fef3c7; color:#92400e;' : '#fee2e2; color:#991b1b;'); ?> border-radius:6px; font-weight:700; padding:5px 9px;">
                <i class="fa fa-clock-o"></i> <?= round($r_days); ?> hr lalu
              </span>
            </td>
            <td style="text-align:center;">
              <a href="<?= site_url('administrator/rfm?period=' . urlencode($mt->ym_period) . (!empty($product_filter) ? '&product=' . urlencode($product_filter) : '') . (!empty($category_filter) ? '&kategori=' . urlencode($category_filter) : '')); ?>" class="btn btn-xs" style="background:#6366f1; color:#fff; border-radius:6px; font-weight:600; padding:5px 10px;" title="Filter Customer di Bulan Ini">
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

  <!-- ==========================================
       LAYER 6: ANALISIS & INSIGHT KESELURUHAN
       ========================================== -->
  <?php 
  $source_for_insights = !empty($all_historical_tracking) ? $all_historical_tracking : $track_data;
  if (!empty($source_for_insights)):
    // Calculate insights from historical tracking data
    $tl = array_values($source_for_insights);
    $t_cnt = count($tl);
    
    // Comprehensive metrics
    $best_spend = null; $worst_spend = null;
    $best_buyers = null; $worst_buyers = null;
    $best_orders = null; $worst_orders = null;
    $declining_months = 0; $growing_months = 0;
    $recent_3_avg_spend = 0; $older_3_avg_spend = 0;
    $total_all_spend = 0; $total_all_orders = 0; $total_all_buyers = 0; $total_all_qty = 0;
    $mom_list = []; // Month-over-Month data
    
    foreach ($tl as $i => $mt) {
      $spend = (float)$mt->total_spend;
      $buyers = (int)$mt->unique_buyers;
      $orders = (int)$mt->total_orders;
      $qty = (int)$mt->total_qty;
      
      $total_all_spend += $spend;
      $total_all_orders += $orders;
      $total_all_buyers += $buyers;
      $total_all_qty += $qty;
      
      if ($best_spend === null || $spend > (float)$best_spend->total_spend) $best_spend = $mt;
      if ($worst_spend === null || ($spend < (float)$worst_spend->total_spend && $spend > 0)) $worst_spend = $mt;
      if ($best_buyers === null || $buyers > (int)$best_buyers->unique_buyers) $best_buyers = $mt;
      if ($worst_buyers === null || ($buyers < (int)$worst_buyers->unique_buyers && $buyers > 0)) $worst_buyers = $mt;
      if ($best_orders === null || $orders > (int)$best_orders->total_orders) $best_orders = $mt;
      if ($worst_orders === null || ($orders < (int)$worst_orders->total_orders && $orders > 0)) $worst_orders = $mt;
      
      // Growth/decline calculation (use precalculated MoM from model if available)
      $mom_pct = isset($mt->mom_growth_pct) ? (float)$mt->mom_growth_pct : null;
      if ($mom_pct === null && $i < $t_cnt - 1) {
        $prev = (float)$tl[$i + 1]->total_spend;
        if ($prev > 0) {
          $mom_pct = round((($spend - $prev) / $prev) * 100, 1);
        }
      }
      if ($mom_pct !== null) {
        if ($mom_pct < 0) $declining_months++;
        else $growing_months++;
      }
      $mom_list[] = ['mt' => $mt, 'mom' => $mom_pct];

      // Recent vs older comparison
      if ($i < 3) $recent_3_avg_spend += $spend;
      if ($i >= 3 && $i < 6) $older_3_avg_spend += $spend;
    }
    
    $recent_3_avg_spend = $t_cnt >= 3 ? $recent_3_avg_spend / min(3, $t_cnt) : $recent_3_avg_spend;
    $older_3_avg_spend = $t_cnt >= 6 ? $older_3_avg_spend / 3 : ($t_cnt >= 4 ? $older_3_avg_spend / min(3, $t_cnt - 3) : 0);
    $trend_direction = $older_3_avg_spend > 0 ? round((($recent_3_avg_spend - $older_3_avg_spend) / $older_3_avg_spend) * 100, 1) : 0;
    
    // Average metrics
    $avg_order_value = $total_all_orders > 0 ? $total_all_spend / $total_all_orders : 0;
    $avg_orders_per_buyer = $total_all_buyers > 0 ? round($total_all_orders / $total_all_buyers, 2) : 0;
    $avg_spend_per_buyer = $total_all_buyers > 0 ? $total_all_spend / $total_all_buyers : 0;
    $avg_qty_per_order = $total_all_orders > 0 ? round($total_all_qty / $total_all_orders, 1) : 0;
    
    // Latest month stats
    $latest = $tl[0] ?? null;
    $latest_recency = $latest ? ($latest->avg_recency_days ?? $latest->avg_recency ?? 0) : 0;
    $latest_buyers = $latest ? (int)$latest->unique_buyers : 0;
    $latest_orders = $latest ? (int)$latest->total_orders : 0;
    $latest_spend = $latest ? (float)$latest->total_spend : 0;
    $latest_qty = $latest ? (int)$latest->total_qty : 0;
    
    // Map tracking data by ym_period for comparison lookup
    $track_by_ym = [];
    foreach ($tl as $mt) {
      $track_by_ym[$mt->ym_period] = $mt;
    }

    $cmp_a_val = isset($_GET['compare_a']) && isset($track_by_ym[$_GET['compare_a']]) ? $_GET['compare_a'] : ($tl[0]->ym_period ?? '');
    $cmp_b_val = isset($_GET['compare_b']) && isset($track_by_ym[$_GET['compare_b']]) ? $_GET['compare_b'] : (isset($tl[1]) ? $tl[1]->ym_period : ($tl[0]->ym_period ?? ''));

    $obj_a = $track_by_ym[$cmp_a_val] ?? ($tl[0] ?? null);
    $obj_b = $track_by_ym[$cmp_b_val] ?? ($tl[1] ?? $tl[0] ?? null);

    $a_spend = $obj_a ? (float)$obj_a->total_spend : 0;
    $a_buyers = $obj_a ? (int)$obj_a->unique_buyers : 0;
    $a_orders = $obj_a ? (int)$obj_a->total_orders : 0;
    $a_qty = $obj_a ? (int)$obj_a->total_qty : 0;
    $a_avg_order = $a_orders > 0 ? $a_spend / $a_orders : 0;

    $b_spend = $obj_b ? (float)$obj_b->total_spend : 0;
    $b_buyers = $obj_b ? (int)$obj_b->unique_buyers : 0;
    $b_orders = $obj_b ? (int)$obj_b->total_orders : 0;
    $b_qty = $obj_b ? (int)$obj_b->total_qty : 0;
    $b_avg_order = $b_orders > 0 ? $b_spend / $b_orders : 0;

    $cmp_spend_pct = $b_spend > 0 ? round((($a_spend - $b_spend) / $b_spend) * 100, 1) : 0;
    $cmp_spend_diff = $a_spend - $b_spend;

    $cmp_buyers_pct = $b_buyers > 0 ? round((($a_buyers - $b_buyers) / $b_buyers) * 100, 1) : 0;
    $cmp_buyers_diff = $a_buyers - $b_buyers;

    $cmp_orders_pct = $b_orders > 0 ? round((($a_orders - $b_orders) / $b_orders) * 100, 1) : 0;
    $cmp_orders_diff = $a_orders - $b_orders;

    $cmp_aov_pct = $b_avg_order > 0 ? round((($a_avg_order - $b_avg_order) / $b_avg_order) * 100, 1) : 0;
    $cmp_aov_diff = $a_avg_order - $b_avg_order;

    $cmp_qty_pct = $b_qty > 0 ? round((($a_qty - $b_qty) / $b_qty) * 100, 1) : 0;
    $cmp_qty_diff = $a_qty - $b_qty;
    
    // Business Performance Index (0-100)
    $health = 50; // base
    if ($trend_direction > 0) $health += min(15, $trend_direction / 2);
    if ($trend_direction < 0) $health -= min(20, abs($trend_direction) / 2);
    if ($growing_months > $declining_months) $health += 10;
    if ($declining_months > $growing_months) $health -= 10;
    if ($latest_recency <= 30) $health += 10;
    if ($latest_recency > 60) $health -= 15;
    if ($latest_buyers >= $avg_sum_buyers) $health += 10;
    if ($latest_buyers < $avg_sum_buyers * 0.7) $health -= 10;
    $health = max(0, min(100, round($health)));
    $health_color = $health >= 70 ? '#16a34a' : ($health >= 40 ? '#f59e0b' : '#dc2626');
    $health_bg = $health >= 70 ? '#dcfce7' : ($health >= 40 ? '#fef3c7' : '#fee2e2');
    $health_label = $health >= 70 ? 'Performa Optimal' : ($health >= 40 ? 'Performa Sedang' : 'Perlu Evaluasi');
    
    // Need attention flags
    $alerts = [];
    if ($latest_recency > 60) $alerts[] = ['type' => 'danger', 'icon' => 'fa-exclamation-triangle', 'title' => 'Recency Terlalu Tinggi!', 'msg' => 'Rata-rata recency bulan terakhir (<strong>' . round($latest_recency) . ' hari</strong>) sangat tinggi. Artinya customer rata-rata sudah ' . round($latest_recency) . ' hari tidak bertransaksi. <em>Segera lakukan follow-up via WhatsApp atau email!</em>', 'detail' => 'Recency mengukur berapa hari sejak transaksi terakhir customer. Semakin tinggi angkanya, semakin lama customer tidak belanja. Idealnya di bawah 30 hari.'];
    if ($trend_direction < -20) $alerts[] = ['type' => 'danger', 'icon' => 'fa-arrow-down', 'title' => 'Omset Turun Drastis (' . abs($trend_direction) . '%)', 'msg' => 'Rata-rata omset 3 bulan terakhir (<strong>Rp ' . number_format($recent_3_avg_spend, 0, ',', '.') . '/bln</strong>) turun drastis dibanding 3 bulan sebelumnya (<strong>Rp ' . number_format($older_3_avg_spend, 0, ',', '.') . '/bln</strong>).', 'detail' => 'Penurunan >20% dianggap signifikan. Penyebab bisa karena berkurangnya customer aktif, penurunan frekuensi pembelian, atau penurunan nilai rata-rata pesanan.'];
    if ($declining_months > $growing_months && $t_cnt >= 4) $alerts[] = ['type' => 'warning', 'icon' => 'fa-line-chart', 'title' => 'Tren Penurunan Dominan (' . $declining_months . '/' . ($t_cnt - 1) . ' bulan)', 'msg' => '<strong>' . $declining_months . ' dari ' . ($t_cnt - 1) . '</strong> transisi bulan menunjukkan penurunan omset (MoM negatif). Hanya <strong>' . $growing_months . '</strong> bulan yang tumbuh.', 'detail' => 'MoM (Month-over-Month) mengukur persentase perubahan omset dari bulan ke bulan. Jika lebih banyak bulan turun, berarti bisnis secara umum mengalami tekanan.'];
    if ($latest_buyers < $avg_sum_buyers * 0.7 && $avg_sum_buyers > 0) $alerts[] = ['type' => 'warning', 'icon' => 'fa-users', 'title' => 'Pembeli Unik Menurun Signifikan', 'msg' => 'Bulan terakhir hanya <strong>' . $latest_buyers . ' customer</strong>, padahal rata-rata bulanan <strong>' . round($avg_sum_buyers) . ' customer</strong> (turun ' . round((1 - $latest_buyers / $avg_sum_buyers) * 100) . '%).', 'detail' => 'Pembeli unik yang menurun bisa disebabkan oleh kurangnya promosi, persaingan pasar, atau customer berpindah ke kompetitor. Perlu strategi akuisisi baru.'];
    if ($avg_orders_per_buyer <= 1.1 && $total_all_buyers > 0) $alerts[] = ['type' => 'warning', 'icon' => 'fa-repeat', 'title' => 'Repeat Purchase Rendah (' . $avg_orders_per_buyer . 'x)', 'msg' => 'Rata-rata setiap customer hanya melakukan <strong>' . $avg_orders_per_buyer . ' order</strong>. Artinya sangat sedikit yang melakukan pembelian ulang.', 'detail' => 'Idealnya rasio order/buyer > 1.5x, menunjukkan customer melakukan repeat purchase. Jika mendekati 1x, artinya hampir semua customer hanya beli sekali.'];
    
    // Positive signals
    $positives = [];
    if ($trend_direction > 10) $positives[] = ['icon' => 'fa-rocket', 'title' => 'Tren Omset Naik +' . $trend_direction . '%', 'msg' => 'Rata-rata omset 3 bulan terakhir (<strong>Rp ' . number_format($recent_3_avg_spend, 0, ',', '.') . '/bln</strong>) naik dibanding sebelumnya (<strong>Rp ' . number_format($older_3_avg_spend, 0, ',', '.') . '/bln</strong>).'];
    if ($growing_months > $declining_months && $t_cnt >= 4) $positives[] = ['icon' => 'fa-thumbs-up', 'title' => 'Pertumbuhan Konsisten (' . $growing_months . '/' . ($t_cnt - 1) . ' bulan)', 'msg' => '<strong>' . $growing_months . ' dari ' . ($t_cnt - 1) . '</strong> transisi bulan menunjukkan pertumbuhan omset positif. Bisnis cenderung stabil.'];
    if ($latest_recency <= 30) $positives[] = ['icon' => 'fa-check-circle', 'title' => 'Recency Baik (' . round($latest_recency) . ' hari)', 'msg' => 'Customer rata-rata baru bertransaksi <strong>' . round($latest_recency) . ' hari lalu</strong>. Ini menunjukkan engagement yang baik (batas optimal: ≤30 hari).'];
    if ($latest_buyers >= $avg_sum_buyers && $avg_sum_buyers > 0) $positives[] = ['icon' => 'fa-user-plus', 'title' => 'Pembeli Stabil/Naik', 'msg' => 'Pembeli unik bulan terakhir (<strong>' . $latest_buyers . '</strong>) sama atau di atas rata-rata bulanan (<strong>' . round($avg_sum_buyers) . '</strong>).'];
    if ($avg_orders_per_buyer > 1.5) $positives[] = ['icon' => 'fa-repeat', 'title' => 'Repeat Purchase Tinggi (' . $avg_orders_per_buyer . 'x)', 'msg' => 'Rata-rata customer melakukan <strong>' . $avg_orders_per_buyer . ' order</strong>, menunjukkan tingkat loyalitas dan kepuasan yang baik.'];
  ?>
  <div class="section-card-custom" style="padding:0; overflow:hidden;">
    <div style="padding:18px 22px; background:linear-gradient(135deg, #1e1b4b, #312e81); border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
      <h3 style="margin:0; font-size:15px; font-weight:800; color:#fff; display:flex; align-items:center; gap:8px;">
        <i class="fa fa-lightbulb-o" style="color:#fbbf24;"></i> Analisis & Insight Keseluruhan
      </h3>
      <span style="font-size:12px; color:#c7d2fe; font-weight:600;">
        <i class="fa fa-database"></i> Data dari <?= $t_cnt; ?> periode &bull; Total <?= number_format($total_all_buyers); ?> pembeli unik
      </span>
    </div>

    <div style="padding:20px;">

      <!-- SECTION 1: Performance Index + Key Metrics Grid -->
      <div style="display:grid; grid-template-columns:180px 1fr; gap:20px; margin-bottom:24px; align-items:start;">
        <!-- Performance Index Gauge -->
        <div style="background:<?= $health_bg; ?>; border-radius:14px; padding:20px; text-align:center; border:2px solid <?= $health_color; ?>20;">
          <div style="font-size:11px; font-weight:700; color:<?= $health_color; ?>; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:10px;">
            <i class="fa fa-line-chart"></i> Indeks Performa Bisnis
          </div>
          <div style="font-size:42px; font-weight:900; color:<?= $health_color; ?>; line-height:1;"><?= $health; ?></div>
          <div style="font-size:11px; color:<?= $health_color; ?>; font-weight:700; margin-top:4px;">/100 — <?= $health_label; ?></div>
          <div style="margin-top:10px; background:<?= $health_color; ?>20; border-radius:20px; height:8px; overflow:hidden;">
            <div style="height:100%; width:<?= $health; ?>%; background:<?= $health_color; ?>; border-radius:20px; transition:width 0.5s ease;"></div>
          </div>
          <div style="font-size:10px; color:#64748b; margin-top:6px; line-height:1.3;">
            Dihitung dari tren omset, recency, jumlah pembeli & konsistensi pertumbuhan
          </div>
        </div>

        <!-- Key Metrics Grid -->
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(155px, 1fr)); gap:10px;">
          <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px;">
            <div style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.4px;">Total Omset Keseluruhan</div>
            <div style="font-size:17px; font-weight:800; color:#15803d; margin-top:4px;">Rp <?= number_format($total_all_spend, 0, ',', '.'); ?></div>
            <div style="font-size:10.5px; color:#64748b; margin-top:2px;">dari <?= $t_cnt; ?> bulan</div>
          </div>
          <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px;">
            <div style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.4px;">Rata-rata Omset / Bulan</div>
            <div style="font-size:17px; font-weight:800; color:#1d4ed8; margin-top:4px;">Rp <?= number_format($avg_sum_spend, 0, ',', '.'); ?></div>
            <div style="font-size:10.5px; color:#64748b; margin-top:2px;">median bulanan</div>
          </div>
          <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px;">
            <div style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.4px;">Rata-rata per Transaksi</div>
            <div style="font-size:17px; font-weight:800; color:#7c3aed; margin-top:4px;">Rp <?= number_format($avg_order_value, 0, ',', '.'); ?></div>
            <div style="font-size:10.5px; color:#64748b; margin-top:2px;"><?= number_format($total_all_orders); ?> total order</div>
          </div>
          <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px;">
            <div style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.4px;">Rata-rata Belanja / Customer</div>
            <div style="font-size:17px; font-weight:800; color:#0891b2; margin-top:4px;">Rp <?= number_format($avg_spend_per_buyer, 0, ',', '.'); ?></div>
            <div style="font-size:10.5px; color:#64748b; margin-top:2px;"><?= number_format($total_all_buyers); ?> total customer</div>
          </div>
          <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px;">
            <div style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.4px;">Rasio Order / Customer</div>
            <div style="font-size:17px; font-weight:800; color:<?= $avg_orders_per_buyer > 1.3 ? '#15803d' : '#dc2626'; ?>; margin-top:4px;"><?= $avg_orders_per_buyer; ?>x</div>
            <div style="font-size:10.5px; color:#64748b; margin-top:2px;"><?= $avg_orders_per_buyer > 1.3 ? 'Repeat baik' : 'Repeat rendah'; ?></div>
          </div>
          <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px;">
            <div style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.4px;">Rata-rata Qty / Order</div>
            <div style="font-size:17px; font-weight:800; color:#ea580c; margin-top:4px;"><?= $avg_qty_per_order; ?> pcs</div>
            <div style="font-size:10.5px; color:#64748b; margin-top:2px;"><?= number_format($total_all_qty); ?> total qty</div>
          </div>
        </div>
      </div>

      <!-- SECTION 2: Custom Period Comparison (Bebas Pilih Bulan) -->
      <?php if ($obj_a && $obj_b): ?>
      <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; padding:20px; margin-bottom:24px;">
        <form method="GET" action="<?= site_url('administrator/rfm/tracking'); ?>" id="form-compare-months" style="margin-bottom:18px;">
          <?php if (!empty($product_filter)): ?>
            <input type="hidden" name="product" value="<?= htmlspecialchars($product_filter); ?>">
          <?php endif; ?>
          <?php if (!empty($category_filter)): ?>
            <input type="hidden" name="kategori" value="<?= htmlspecialchars($category_filter); ?>">
          <?php endif; ?>

          <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
            <div>
              <div style="font-weight:800; font-size:14px; color:#0f172a; display:flex; align-items:center; gap:8px;">
                <i class="fa fa-exchange" style="color:#6366f1; font-size:16px;"></i> Perbandingan Antar Periode / Bulan (Bebas Pilih Bulan)
              </div>
              <div style="font-size:12px; color:#64748b; margin-top:2px;">
                Pilih dua bulan mana saja di bawah ini untuk membandingkan omset, customer, dan order secara langsung
              </div>
            </div>

            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
              <div style="display:flex; align-items:center; gap:6px;">
                <label style="font-size:12px; font-weight:700; color:#475569; margin:0; white-space:nowrap;">Bulan A:</label>
                <select name="compare_a" class="form-control" style="border-radius:8px; font-weight:700; border:1px solid #cbd5e1; height:36px; font-size:12.5px; min-width:140px;" onchange="document.getElementById('form-compare-months').submit();">
                  <?php foreach ($tl as $mitem): ?>
                    <option value="<?= $mitem->ym_period; ?>" <?= $mitem->ym_period === $cmp_a_val ? 'selected' : ''; ?>>
                      📅 <?= htmlspecialchars($mitem->period_label); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <span style="font-weight:800; color:#6366f1; font-size:14px;">VS</span>

              <div style="display:flex; align-items:center; gap:6px;">
                <label style="font-size:12px; font-weight:700; color:#475569; margin:0; white-space:nowrap;">Bulan B (Pembanding):</label>
                <select name="compare_b" class="form-control" style="border-radius:8px; font-weight:700; border:1px solid #cbd5e1; height:36px; font-size:12.5px; min-width:140px;" onchange="document.getElementById('form-compare-months').submit();">
                  <?php foreach ($tl as $mitem): ?>
                    <option value="<?= $mitem->ym_period; ?>" <?= $mitem->ym_period === $cmp_b_val ? 'selected' : ''; ?>>
                      📅 <?= htmlspecialchars($mitem->period_label); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <button type="submit" class="btn btn-sm" style="background:#6366f1; color:#fff; border-radius:8px; font-weight:700; height:36px; padding:0 14px; border:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa fa-refresh"></i> Bandingkan
              </button>
            </div>
          </div>
        </form>

        <!-- Metric comparison cards grid (6 Metrik Detail) -->
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
          <!-- Omset Comparison -->
          <div style="background:#fff; border-radius:12px; padding:16px; border:1px solid #e2e8f0; box-shadow:0 2px 6px rgba(0,0,0,0.03);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
              <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">Total Omset</span>
              <span style="font-size:12px; font-weight:800; color:<?= $cmp_spend_pct >= 0 ? '#16a34a' : '#dc2626'; ?>; background:<?= $cmp_spend_pct >= 0 ? '#dcfce7' : '#fee2e2'; ?>; padding:3px 8px; border-radius:6px;">
                <i class="fa fa-arrow-<?= $cmp_spend_pct >= 0 ? 'up' : 'down'; ?>"></i> <?= $cmp_spend_pct >= 0 ? '+' : ''; ?><?= $cmp_spend_pct; ?>%
              </span>
            </div>
            <div style="font-size:18px; font-weight:800; color:#0f172a;">Rp <?= number_format($a_spend, 0, ',', '.'); ?></div>
            <div style="font-size:11.5px; color:#64748b; margin-top:4px;">
              <?= htmlspecialchars($obj_b->period_label); ?>: <strong>Rp <?= number_format($b_spend, 0, ',', '.'); ?></strong>
            </div>
            <div style="font-size:11px; font-weight:700; color:<?= $cmp_spend_diff >= 0 ? '#16a34a' : '#dc2626'; ?>; margin-top:3px;">
              Selisih: <?= $cmp_spend_diff >= 0 ? '+' : ''; ?>Rp <?= number_format($cmp_spend_diff, 0, ',', '.'); ?>
            </div>
          </div>

          <!-- Buyers Comparison -->
          <div style="background:#fff; border-radius:12px; padding:16px; border:1px solid #e2e8f0; box-shadow:0 2px 6px rgba(0,0,0,0.03);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
              <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">Pembeli Unik</span>
              <span style="font-size:12px; font-weight:800; color:<?= $cmp_buyers_pct >= 0 ? '#16a34a' : '#dc2626'; ?>; background:<?= $cmp_buyers_pct >= 0 ? '#dcfce7' : '#fee2e2'; ?>; padding:3px 8px; border-radius:6px;">
                <i class="fa fa-arrow-<?= $cmp_buyers_pct >= 0 ? 'up' : 'down'; ?>"></i> <?= $cmp_buyers_pct >= 0 ? '+' : ''; ?><?= $cmp_buyers_pct; ?>%
              </span>
            </div>
            <div style="font-size:18px; font-weight:800; color:#0f172a;"><?= number_format($a_buyers); ?> customer</div>
            <div style="font-size:11.5px; color:#64748b; margin-top:4px;">
              <?= htmlspecialchars($obj_b->period_label); ?>: <strong><?= number_format($b_buyers); ?> customer</strong>
            </div>
            <div style="font-size:11px; font-weight:700; color:<?= $cmp_buyers_diff >= 0 ? '#16a34a' : '#dc2626'; ?>; margin-top:3px;">
              Selisih: <?= $cmp_buyers_diff >= 0 ? '+' : ''; ?><?= number_format($cmp_buyers_diff); ?> customer
            </div>
          </div>

          <!-- Orders Comparison -->
          <div style="background:#fff; border-radius:12px; padding:16px; border:1px solid #e2e8f0; box-shadow:0 2px 6px rgba(0,0,0,0.03);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
              <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">Jumlah Order</span>
              <span style="font-size:12px; font-weight:800; color:<?= $cmp_orders_pct >= 0 ? '#16a34a' : '#dc2626'; ?>; background:<?= $cmp_orders_pct >= 0 ? '#dcfce7' : '#fee2e2'; ?>; padding:3px 8px; border-radius:6px;">
                <i class="fa fa-arrow-<?= $cmp_orders_pct >= 0 ? 'up' : 'down'; ?>"></i> <?= $cmp_orders_pct >= 0 ? '+' : ''; ?><?= $cmp_orders_pct; ?>%
              </span>
            </div>
            <div style="font-size:18px; font-weight:800; color:#0f172a;"><?= number_format($a_orders); ?> order</div>
            <div style="font-size:11.5px; color:#64748b; margin-top:4px;">
              <?= htmlspecialchars($obj_b->period_label); ?>: <strong><?= number_format($b_orders); ?> order</strong>
            </div>
            <div style="font-size:11px; font-weight:700; color:<?= $cmp_orders_diff >= 0 ? '#16a34a' : '#dc2626'; ?>; margin-top:3px;">
              Selisih: <?= $cmp_orders_diff >= 0 ? '+' : ''; ?><?= number_format($cmp_orders_diff); ?> order
            </div>
          </div>

          <!-- AOV / Basket Size Comparison -->
          <div style="background:#fff; border-radius:12px; padding:16px; border:1px solid #e2e8f0; box-shadow:0 2px 6px rgba(0,0,0,0.03);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
              <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">Rata-Rata / Order</span>
              <span style="font-size:12px; font-weight:800; color:<?= $cmp_aov_pct >= 0 ? '#16a34a' : '#dc2626'; ?>; background:<?= $cmp_aov_pct >= 0 ? '#dcfce7' : '#fee2e2'; ?>; padding:3px 8px; border-radius:6px;">
                <i class="fa fa-arrow-<?= $cmp_aov_pct >= 0 ? 'up' : 'down'; ?>"></i> <?= $cmp_aov_pct >= 0 ? '+' : ''; ?><?= $cmp_aov_pct; ?>%
              </span>
            </div>
            <div style="font-size:18px; font-weight:800; color:#0f172a;">Rp <?= number_format($a_avg_order, 0, ',', '.'); ?></div>
            <div style="font-size:11.5px; color:#64748b; margin-top:4px;">
              <?= htmlspecialchars($obj_b->period_label); ?>: <strong>Rp <?= number_format($b_avg_order, 0, ',', '.'); ?></strong>
            </div>
            <div style="font-size:11px; font-weight:700; color:<?= $cmp_aov_diff >= 0 ? '#16a34a' : '#dc2626'; ?>; margin-top:3px;">
              Selisih: <?= $cmp_aov_diff >= 0 ? '+' : ''; ?>Rp <?= number_format($cmp_aov_diff, 0, ',', '.'); ?>
            </div>
          </div>

          <!-- Total Qty Comparison -->
          <div style="background:#fff; border-radius:12px; padding:16px; border:1px solid #e2e8f0; box-shadow:0 2px 6px rgba(0,0,0,0.03);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
              <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">Total Qty Terjual</span>
              <span style="font-size:12px; font-weight:800; color:<?= $cmp_qty_pct >= 0 ? '#16a34a' : '#dc2626'; ?>; background:<?= $cmp_qty_pct >= 0 ? '#dcfce7' : '#fee2e2'; ?>; padding:3px 8px; border-radius:6px;">
                <i class="fa fa-arrow-<?= $cmp_qty_pct >= 0 ? 'up' : 'down'; ?>"></i> <?= $cmp_qty_pct >= 0 ? '+' : ''; ?><?= $cmp_qty_pct; ?>%
              </span>
            </div>
            <div style="font-size:18px; font-weight:800; color:#0f172a;"><?= number_format($a_qty); ?> pcs</div>
            <div style="font-size:11.5px; color:#64748b; margin-top:4px;">
              <?= htmlspecialchars($obj_b->period_label); ?>: <strong><?= number_format($b_qty); ?> pcs</strong>
            </div>
            <div style="font-size:11px; font-weight:700; color:<?= $cmp_qty_diff >= 0 ? '#16a34a' : '#dc2626'; ?>; margin-top:3px;">
              Selisih: <?= $cmp_qty_diff >= 0 ? '+' : ''; ?><?= number_format($cmp_qty_diff); ?> pcs
            </div>
          </div>
        </div>

        <!-- Deep Breakdown: Top Products & Platforms Comparison -->
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:16px; margin-top:16px;">
          <!-- Top 5 Products Comparison -->
          <div style="background:#fff; border-radius:12px; padding:16px; border:1px solid #e2e8f0;">
            <div style="font-weight:800; font-size:12.5px; color:#1e1b4b; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
              <i class="fa fa-trophy" style="color:#f59e0b;"></i> Top 5 Produk Terlaris (Nominal Omset)
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:8px;">
              <div style="font-size:11px; font-weight:700; color:#4338ca; background:#e0e7ff; padding:4px 8px; border-radius:6px; text-align:center;">
                <?= htmlspecialchars($obj_a->period_label); ?>
              </div>
              <div style="font-size:11px; font-weight:700; color:#475569; background:#f1f5f9; padding:4px 8px; border-radius:6px; text-align:center;">
                <?= htmlspecialchars($obj_b->period_label); ?>
              </div>
            </div>
            
            <?php if (empty($top_products_a) && empty($top_products_b)): ?>
              <div style="font-size:11px; color:#94a3b8; text-align:center; padding:10px;">Tidak ada data produk</div>
            <?php else: ?>
              <div style="display:flex; flex-direction:column; gap:6px;">
                <?php 
                  $max_len = max(count($top_products_a), count($top_products_b));
                  for ($i = 0; $i < $max_len; $i++): 
                ?>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                  <!-- Month A Item -->
                  <div>
                    <?php if (isset($top_products_a[$i])): $tp = $top_products_a[$i]; ?>
                    <div style="height:100%; font-size:11px; padding:8px; background:#f8fafc; border-radius:6px; border:1px solid #e2e8f0; display:flex; flex-direction:column; justify-content:center;">
                      <div style="font-weight:700; color:#0f172a; white-space:normal; line-height:1.3;" title="<?= htmlspecialchars($tp->nama_produk); ?>">
                        <?= ($i+1); ?>. <?= htmlspecialchars($tp->nama_produk); ?>
                      </div>
                      <div style="display:flex; justify-content:space-between; align-items:flex-end; color:#15803d; font-weight:700; margin-top:4px;">
                        <span>Rp <?= number_format($tp->total_spend, 0, ',', '.'); ?></span>
                        <span style="color:#64748b; font-weight:600;"><?= number_format($tp->total_qty); ?> pcs</span>
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>
                  <!-- Month B Item -->
                  <div>
                    <?php if (isset($top_products_b[$i])): $tp = $top_products_b[$i]; ?>
                    <div style="height:100%; font-size:11px; padding:8px; background:#f8fafc; border-radius:6px; border:1px solid #e2e8f0; display:flex; flex-direction:column; justify-content:center;">
                      <div style="font-weight:700; color:#0f172a; white-space:normal; line-height:1.3;" title="<?= htmlspecialchars($tp->nama_produk); ?>">
                        <?= ($i+1); ?>. <?= htmlspecialchars($tp->nama_produk); ?>
                      </div>
                      <div style="display:flex; justify-content:space-between; align-items:flex-end; color:#15803d; font-weight:700; margin-top:4px;">
                        <span>Rp <?= number_format($tp->total_spend, 0, ',', '.'); ?></span>
                        <span style="color:#64748b; font-weight:600;"><?= number_format($tp->total_qty); ?> pcs</span>
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
                <?php endfor; ?>
              </div>
            <?php endif; ?>
          </div>

          <!-- Platform / Sales Channel Breakdown -->
          <div style="background:#fff; border-radius:12px; padding:16px; border:1px solid #e2e8f0;">
            <div style="font-weight:800; font-size:12.5px; color:#1e1b4b; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
              <i class="fa fa-shopping-cart" style="color:#10b981;"></i> Performa Channel / Platform Penjualan
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:8px;">
              <div style="font-size:11px; font-weight:700; color:#4338ca; background:#e0e7ff; padding:4px 8px; border-radius:6px; text-align:center;">
                <?= htmlspecialchars($obj_a->period_label); ?>
              </div>
              <div style="font-size:11px; font-weight:700; color:#475569; background:#f1f5f9; padding:4px 8px; border-radius:6px; text-align:center;">
                <?= htmlspecialchars($obj_b->period_label); ?>
              </div>
            </div>

            <?php if (empty($platform_a) && empty($platform_b)): ?>
              <div style="font-size:11px; color:#94a3b8; text-align:center; padding:10px;">Tidak ada data platform</div>
            <?php else: ?>
              <div style="display:flex; flex-direction:column; gap:6px;">
                <?php 
                  $max_len = max(count($platform_a), count($platform_b));
                  for ($i = 0; $i < $max_len; $i++): 
                ?>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                  <!-- Month A Item -->
                  <div>
                    <?php if (isset($platform_a[$i])): $pf = $platform_a[$i]; ?>
                    <div style="height:100%; font-size:11px; padding:8px; background:#f8fafc; border-radius:6px; border:1px solid #e2e8f0; display:flex; flex-direction:column; justify-content:center;">
                      <div style="font-weight:700; color:#0f172a; display:flex; justify-content:space-between; align-items:flex-start;">
                        <span style="white-space:normal; line-height:1.3;"><?= htmlspecialchars($pf->sumber_penjualan); ?></span>
                        <span style="color:#4338ca; white-space:nowrap; margin-left:8px;"><?= number_format($pf->total_orders); ?> order</span>
                      </div>
                      <div style="font-size:11px; font-weight:700; color:#15803d; margin-top:4px;">
                        Rp <?= number_format($pf->total_spend, 0, ',', '.'); ?>
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>
                  <!-- Month B Item -->
                  <div>
                    <?php if (isset($platform_b[$i])): $pf = $platform_b[$i]; ?>
                    <div style="height:100%; font-size:11px; padding:8px; background:#f8fafc; border-radius:6px; border:1px solid #e2e8f0; display:flex; flex-direction:column; justify-content:center;">
                      <div style="font-weight:700; color:#0f172a; display:flex; justify-content:space-between; align-items:flex-start;">
                        <span style="white-space:normal; line-height:1.3;"><?= htmlspecialchars($pf->sumber_penjualan); ?></span>
                        <span style="color:#4338ca; white-space:nowrap; margin-left:8px;"><?= number_format($pf->total_orders); ?> order</span>
                      </div>
                      <div style="font-size:11px; font-weight:700; color:#15803d; margin-top:4px;">
                        Rp <?= number_format($pf->total_spend, 0, ',', '.'); ?>
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
                <?php endfor; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <!-- SECTION 3: Need Attention & Positive Signals -->
      <?php if (!empty($alerts)): ?>
      <div style="margin-bottom:20px;">
        <div style="font-weight:800; font-size:13px; color:#991b1b; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
          <i class="fa fa-exclamation-circle" style="font-size:16px;"></i> PERLU PERHATIAN (Need Attention) — <?= count($alerts); ?> item
        </div>
        <div style="display:flex; flex-direction:column; gap:10px;">
          <?php foreach ($alerts as $alert): ?>
          <div style="background:<?= $alert['type'] === 'danger' ? '#fef2f2' : '#fffbeb'; ?>; border:1px solid <?= $alert['type'] === 'danger' ? '#fecaca' : '#fde68a'; ?>; border-left:4px solid <?= $alert['type'] === 'danger' ? '#ef4444' : '#f59e0b'; ?>; border-radius:10px; padding:14px 18px;">
            <div style="display:flex; align-items:flex-start; gap:12px;">
              <div style="width:36px; height:36px; border-radius:8px; background:<?= $alert['type'] === 'danger' ? '#fee2e2' : '#fef3c7'; ?>; color:<?= $alert['type'] === 'danger' ? '#dc2626' : '#d97706'; ?>; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0;">
                <i class="fa <?= $alert['icon']; ?>"></i>
              </div>
              <div style="flex:1;">
                <div style="font-weight:800; font-size:13px; color:<?= $alert['type'] === 'danger' ? '#991b1b' : '#92400e'; ?>; margin-bottom:3px;"><?= $alert['title']; ?></div>
                <div style="font-size:12.5px; color:<?= $alert['type'] === 'danger' ? '#b91c1c' : '#a16207'; ?>; line-height:1.6;"><?= $alert['msg']; ?></div>
                <?php if (!empty($alert['detail'])): ?>
                <div style="margin-top:8px; padding:10px 12px; background:<?= $alert['type'] === 'danger' ? '#fff1f2' : '#fefce8'; ?>; border-radius:8px; font-size:11.5px; color:#64748b; line-height:1.5;">
                  <i class="fa fa-info-circle" style="color:#94a3b8;"></i> <strong>Penjelasan:</strong> <?= $alert['detail']; ?>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <?php if (!empty($positives)): ?>
      <div style="margin-bottom:20px;">
        <div style="font-weight:800; font-size:13px; color:#166534; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
          <i class="fa fa-check-circle" style="font-size:16px;"></i> SINYAL POSITIF — <?= count($positives); ?> item
        </div>
        <div style="display:flex; flex-direction:column; gap:10px;">
          <?php foreach ($positives as $pos): ?>
          <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-left:4px solid #22c55e; border-radius:10px; padding:14px 18px; display:flex; align-items:flex-start; gap:12px;">
            <div style="width:36px; height:36px; border-radius:8px; background:#dcfce7; color:#16a34a; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0;">
              <i class="fa <?= $pos['icon']; ?>"></i>
            </div>
            <div>
              <div style="font-weight:800; font-size:13px; color:#166534; margin-bottom:3px;"><?= $pos['title']; ?></div>
              <div style="font-size:12.5px; color:#15803d; line-height:1.6;"><?= $pos['msg']; ?></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <!-- SECTION 4: Performance Summary Cards -->
      <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:14px; margin-bottom:20px;">
        <?php if ($best_spend): ?>
        <div style="background:linear-gradient(135deg, #f0fdf4, #dcfce7); border:1px solid #bbf7d0; border-radius:12px; padding:16px;">
          <div style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
            <i class="fa fa-trophy" style="color:#f59e0b;"></i> Bulan Omset Tertinggi
          </div>
          <div style="font-size:18px; font-weight:800; color:#15803d;">Rp <?= number_format($best_spend->total_spend, 0, ',', '.'); ?></div>
          <div style="font-size:12px; color:#166534; font-weight:600; margin-top:4px;">
            <i class="fa fa-calendar"></i> <?= htmlspecialchars($best_spend->period_label); ?>
            · <?= number_format($best_spend->unique_buyers); ?> pembeli · <?= number_format($best_spend->total_orders); ?> order
          </div>
        </div>
        <?php endif; ?>

        <?php if ($worst_spend && $worst_spend !== $best_spend): ?>
        <div style="background:linear-gradient(135deg, #fef2f2, #fee2e2); border:1px solid #fecaca; border-radius:12px; padding:16px;">
          <div style="font-size:11px; font-weight:700; color:#991b1b; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
            <i class="fa fa-arrow-down"></i> Bulan Omset Terendah
          </div>
          <div style="font-size:18px; font-weight:800; color:#dc2626;">Rp <?= number_format($worst_spend->total_spend, 0, ',', '.'); ?></div>
          <div style="font-size:12px; color:#991b1b; font-weight:600; margin-top:4px;">
            <i class="fa fa-calendar"></i> <?= htmlspecialchars($worst_spend->period_label); ?>
            · <?= number_format($worst_spend->unique_buyers); ?> pembeli · <?= number_format($worst_spend->total_orders); ?> order
          </div>
        </div>
        <?php endif; ?>

        <?php if ($best_buyers): ?>
        <div style="background:linear-gradient(135deg, #eef2ff, #e0e7ff); border:1px solid #c7d2fe; border-radius:12px; padding:16px;">
          <div style="font-size:11px; font-weight:700; color:#3730a3; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
            <i class="fa fa-users" style="color:#6366f1;"></i> Bulan Pembeli Terbanyak
          </div>
          <div style="font-size:18px; font-weight:800; color:#4338ca;"><?= number_format($best_buyers->unique_buyers); ?> Customer</div>
          <div style="font-size:12px; color:#3730a3; font-weight:600; margin-top:4px;">
            <i class="fa fa-calendar"></i> <?= htmlspecialchars($best_buyers->period_label); ?>
            · Omset Rp <?= number_format($best_buyers->total_spend, 0, ',', '.'); ?>
          </div>
        </div>
        <?php endif; ?>

        <div style="background:linear-gradient(135deg, <?= $trend_direction >= 0 ? '#f0fdf4, #dcfce7' : '#fef2f2, #fee2e2'; ?>); border:1px solid <?= $trend_direction >= 0 ? '#bbf7d0' : '#fecaca'; ?>; border-radius:12px; padding:16px;">
          <div style="font-size:11px; font-weight:700; color:<?= $trend_direction >= 0 ? '#166534' : '#991b1b'; ?>; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
            <i class="fa fa-line-chart"></i> Tren 3 Bulan Terakhir
          </div>
          <div style="font-size:18px; font-weight:800; color:<?= $trend_direction >= 0 ? '#16a34a' : '#dc2626'; ?>;">
            <?= $trend_direction >= 0 ? '+' : ''; ?><?= $trend_direction; ?>%
          </div>
          <div style="font-size:12px; color:<?= $trend_direction >= 0 ? '#166534' : '#991b1b'; ?>; font-weight:600; margin-top:4px;">
            Rp <?= number_format($recent_3_avg_spend, 0, ',', '.'); ?>/bln vs Rp <?= number_format($older_3_avg_spend, 0, ',', '.'); ?>/bln
          </div>
        </div>
      </div>

      <!-- SECTION 5: Detailed MoM Growth Table -->
      <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; margin-bottom:20px;">
        <div style="padding:14px 18px; background:#fff; border-bottom:1px solid #e2e8f0; font-weight:800; font-size:13px; color:#0f172a; display:flex; align-items:center; gap:8px;">
          <i class="fa fa-bar-chart" style="color:#6366f1;"></i> Detail Performa per Bulan
          <span style="margin-left:auto; font-size:11px; font-weight:600; color:#94a3b8;">Menampilkan <?= min(count($mom_list), 6); ?> bulan terakhir</span>
        </div>
        <div style="overflow-x:auto;">
          <table style="width:100%; border-collapse:collapse; font-size:12px;">
            <thead>
              <tr style="background:#f1f5f9;">
                <th style="padding:10px 14px; text-align:left; font-weight:700; color:#475569; font-size:10.5px; text-transform:uppercase;">Periode</th>
                <th style="padding:10px 14px; text-align:right; font-weight:700; color:#475569; font-size:10.5px; text-transform:uppercase;">Omset</th>
                <th style="padding:10px 14px; text-align:center; font-weight:700; color:#475569; font-size:10.5px; text-transform:uppercase;">MoM</th>
                <th style="padding:10px 14px; text-align:center; font-weight:700; color:#475569; font-size:10.5px; text-transform:uppercase;">Pembeli</th>
                <th style="padding:10px 14px; text-align:center; font-weight:700; color:#475569; font-size:10.5px; text-transform:uppercase;">Order</th>
                <th style="padding:10px 14px; text-align:center; font-weight:700; color:#475569; font-size:10.5px; text-transform:uppercase;">Qty</th>
                <th style="padding:10px 14px; text-align:right; font-weight:700; color:#475569; font-size:10.5px; text-transform:uppercase;">Avg/Order</th>
                <th style="padding:10px 14px; text-align:center; font-weight:700; color:#475569; font-size:10.5px; text-transform:uppercase;">Order/Buyer</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach (array_slice($mom_list, 0, 6) as $idx => $md): 
                $mt = $md['mt']; $mom = $md['mom'];
                $m_spend = (float)$mt->total_spend;
                $m_orders = (int)$mt->total_orders;
                $m_buyers = (int)$mt->unique_buyers;
                $m_qty = (int)$mt->total_qty;
                $m_avg = $m_orders > 0 ? $m_spend / $m_orders : 0;
                $m_opb = $m_buyers > 0 ? round($m_orders / $m_buyers, 2) : 0;
              ?>
              <tr style="border-bottom:1px solid #f1f5f9; <?= $idx === 0 ? 'background:#eff6ff;' : ''; ?>">
                <td style="padding:10px 14px; font-weight:700; color:#0f172a;">
                  <?= $idx === 0 ? '<i class="fa fa-star" style="color:#f59e0b; font-size:10px;"></i> ' : ''; ?>
                  <?= htmlspecialchars($mt->period_label); ?>
                  <?= $idx === 0 ? '<span style="font-size:10px; background:#dbeafe; color:#2563eb; padding:1px 6px; border-radius:4px; margin-left:4px;">Terbaru</span>' : ''; ?>
                </td>
                <td style="padding:10px 14px; text-align:right; font-weight:700; color:#15803d;">Rp <?= number_format($m_spend, 0, ',', '.'); ?></td>
                <td style="padding:10px 14px; text-align:center;">
                  <?php if ($mom === null): ?>
                    <span style="color:#94a3b8; font-size:11px;">—</span>
                  <?php elseif ($mom >= 0): ?>
                    <span style="background:#dcfce7; color:#16a34a; padding:2px 8px; border-radius:6px; font-weight:700; font-size:11px;"><i class="fa fa-arrow-up"></i> +<?= $mom; ?>%</span>
                  <?php else: ?>
                    <span style="background:#fee2e2; color:#dc2626; padding:2px 8px; border-radius:6px; font-weight:700; font-size:11px;"><i class="fa fa-arrow-down"></i> <?= $mom; ?>%</span>
                  <?php endif; ?>
                </td>
                <td style="padding:10px 14px; text-align:center; font-weight:600;"><?= number_format($m_buyers); ?></td>
                <td style="padding:10px 14px; text-align:center; font-weight:600;"><?= number_format($m_orders); ?>x</td>
                <td style="padding:10px 14px; text-align:center; color:#64748b;"><?= number_format($m_qty); ?> pcs</td>
                <td style="padding:10px 14px; text-align:right; color:#7c3aed; font-weight:600;">Rp <?= number_format($m_avg, 0, ',', '.'); ?></td>
                <td style="padding:10px 14px; text-align:center;">
                  <span style="background:<?= $m_opb > 1.3 ? '#dcfce7' : ($m_opb > 1.0 ? '#fef3c7' : '#fee2e2'); ?>; color:<?= $m_opb > 1.3 ? '#16a34a' : ($m_opb > 1.0 ? '#92400e' : '#dc2626'); ?>; padding:2px 8px; border-radius:6px; font-weight:700; font-size:11px;"><?= $m_opb; ?>x</span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- SECTION 6: Recommendations -->
      <div style="background:linear-gradient(135deg, #eff6ff, #dbeafe); border:1px solid #bfdbfe; border-radius:12px; padding:18px;">
        <div style="font-weight:800; font-size:13px; color:#1e40af; margin-bottom:14px; display:flex; align-items:center; gap:6px;">
          <i class="fa fa-magic" style="font-size:16px;"></i> Rekomendasi Aksi Berdasarkan Data
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:12px;">
          <?php if ($latest_recency > 30): ?>
          <div style="background:#fff; border-radius:10px; padding:14px; border:1px solid #bfdbfe;">
            <div style="font-weight:700; font-size:12.5px; color:#1e40af; margin-bottom:6px;"><i class="fa fa-whatsapp" style="color:#25D366;"></i> Follow-up Customer Lama</div>
            <div style="font-size:12px; color:#475569; line-height:1.6;">Recency rata-rata <?= round($latest_recency); ?> hari. Kirim broadcast WhatsApp ke customer yang sudah >30 hari tidak beli. <a href="<?= site_url('administrator/crm/broadcast'); ?>" style="color:#4338ca; font-weight:700;">Buka Broadcast WA →</a></div>
          </div>
          <?php endif; ?>
          <?php if ($trend_direction < 0): ?>
          <div style="background:#fff; border-radius:10px; padding:14px; border:1px solid #bfdbfe;">
            <div style="font-weight:700; font-size:12.5px; color:#1e40af; margin-bottom:6px;"><i class="fa fa-gift" style="color:#f59e0b;"></i> Buat Promo Spesial</div>
            <div style="font-size:12px; color:#475569; line-height:1.6;">Omset turun <?= abs($trend_direction); ?>%. Buat diskon/promo untuk menarik pembelian ulang. Target segment "At Risk" dan "Need Attention" di Dashboard RFM.</div>
          </div>
          <?php endif; ?>
          <?php if ($latest_buyers < $avg_sum_buyers): ?>
          <div style="background:#fff; border-radius:10px; padding:14px; border:1px solid #bfdbfe;">
            <div style="font-weight:700; font-size:12.5px; color:#1e40af; margin-bottom:6px;"><i class="fa fa-user-plus" style="color:#10b981;"></i> Akuisisi Customer Baru</div>
            <div style="font-size:12px; color:#475569; line-height:1.6;">Pembeli bulan terakhir (<?= $latest_buyers; ?>) di bawah rata-rata (<?= round($avg_sum_buyers); ?>). Perluas channel marketing atau tingkatkan iklan.</div>
          </div>
          <?php endif; ?>
          <?php if ($avg_orders_per_buyer <= 1.3): ?>
          <div style="background:#fff; border-radius:10px; padding:14px; border:1px solid #bfdbfe;">
            <div style="font-weight:700; font-size:12.5px; color:#1e40af; margin-bottom:6px;"><i class="fa fa-repeat" style="color:#8b5cf6;"></i> Tingkatkan Repeat Purchase</div>
            <div style="font-size:12px; color:#475569; line-height:1.6;">Rasio order/buyer hanya <?= $avg_orders_per_buyer; ?>x (rendah). Buat program loyalitas, cashback, atau paket bundle untuk dorong pembelian ulang.</div>
          </div>
          <?php endif; ?>
          <div style="background:#fff; border-radius:10px; padding:14px; border:1px solid #bfdbfe;">
            <div style="font-weight:700; font-size:12.5px; color:#1e40af; margin-bottom:6px;"><i class="fa fa-th" style="color:#6366f1;"></i> Analisis Kohort Retensi</div>
            <div style="font-size:12px; color:#475569; line-height:1.6;">Lihat pola retensi customer per periode — berapa % yang kembali beli setelah pembelian pertama. <a href="<?= site_url('administrator/rfm/cohort'); ?>" style="color:#4338ca; font-weight:700;">Buka Analisis Kohort →</a></div>
          </div>
          <div style="background:#fff; border-radius:10px; padding:14px; border:1px solid #bfdbfe;">
            <div style="font-weight:700; font-size:12.5px; color:#1e40af; margin-bottom:6px;"><i class="fa fa-diamond" style="color:#ec4899;"></i> Identifikasi Champions</div>
            <div style="font-size:12px; color:#475569; line-height:1.6;">Temukan customer bernilai tinggi (sering beli, belanja besar) dan yang berisiko hilang di segmentasi RFM. <a href="<?= site_url('administrator/rfm/dashboard'); ?>" style="color:#4338ca; font-weight:700;">Buka Dashboard RFM →</a></div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <?php endif; ?>
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
    $chart_source = (!empty($all_historical_tracking) && count($all_historical_tracking) > 1) ? $all_historical_tracking : $track_data;
    $chart_data = !empty($chart_source) ? array_reverse(array_values($chart_source)) : [];
    $chart_labels = array_map(function($m) { return $m->period_label; }, $chart_data);
    $chart_spends = array_map(function($m) { return (float)$m->total_spend; }, $chart_data);
    $chart_buyers = array_map(function($m) { return (int)$m->unique_buyers; }, $chart_data);
    $chart_bg_spends = array_map(function($m) use ($period_filter) {
        if (!empty($period_filter) && $m->ym_period === $period_filter) {
            return 'rgba(79, 70, 229, 0.95)'; // Highlight active period
        }
        return 'rgba(16, 185, 129, 0.75)';
    }, $chart_data);
    $chart_border_spends = array_map(function($m) use ($period_filter) {
        if (!empty($period_filter) && $m->ym_period === $period_filter) {
            return '#312e81';
        }
        return '#10b981';
    }, $chart_data);
    ?>
    var trendLabels = <?= json_encode($chart_labels); ?>;
    var trendSpends = <?= json_encode($chart_spends); ?>;
    var trendBuyers = <?= json_encode($chart_buyers); ?>;
    var trendBgSpends = <?= json_encode($chart_bg_spends); ?>;
    var trendBorderSpends = <?= json_encode($chart_border_spends); ?>;

    new Chart(trendCtx, {
      type: 'bar',
      data: {
        labels: trendLabels,
        datasets: [
          {
            label: 'Total Omset (Rp)',
            data: trendSpends,
            backgroundColor: trendBgSpends,
            borderColor: trendBorderSpends,
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
