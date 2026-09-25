<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
:root {
  --rfm-primary: #6366f1;
  --rfm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
  --card-radius: 14px;
}

.rfm-cohort-wrapper {
  padding: 5px 0 30px 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

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
.rfm-header-nav .header-title {
  flex: 1;
  min-width: 280px;
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

.section-card-custom {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid #e2e8f0;
  box-shadow: var(--card-shadow);
  padding: 22px;
  margin-bottom: 22px;
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

/* Cohort Heatmap Table */
.cohort-table-wrap {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: thin;
  scrollbar-color: #cbd5e1 #f8fafc;
}
.cohort-table-wrap::-webkit-scrollbar { height: 6px; }
.cohort-table-wrap::-webkit-scrollbar-track { background: #f8fafc; border-radius: 4px; }
.cohort-table-wrap::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

.cohort-table {
  border-collapse: separate;
  border-spacing: 2px;
  width: 100%;
}
.cohort-table th {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #475569;
  padding: 8px 6px;
  text-align: center;
  white-space: nowrap;
  background: #f1f5f9;
  border-radius: 4px;
}
.cohort-table th.cohort-label-th {
  text-align: left;
  min-width: 120px;
  position: sticky;
  left: 0;
  z-index: 3;
  background: #f1f5f9;
}
.cohort-table th.cohort-size-th {
  min-width: 60px;
  position: sticky;
  left: 120px;
  z-index: 3;
  background: #f1f5f9;
}
.cohort-table td {
  padding: 6px 5px;
  text-align: center;
  font-size: 11px;
  font-weight: 700;
  border-radius: 4px;
  min-width: 42px;
  transition: all 0.15s ease;
  position: relative;
}
.cohort-table td:hover {
  transform: scale(1.15);
  z-index: 5;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
.cohort-table td.cohort-label-td {
  text-align: left;
  font-size: 11.5px;
  color: #0f172a;
  font-weight: 800;
  position: sticky;
  left: 0;
  z-index: 2;
  background: #fff;
  min-width: 120px;
  white-space: nowrap;
}
.cohort-table td.cohort-size-td {
  font-size: 11.5px;
  color: #334155;
  font-weight: 800;
  position: sticky;
  left: 120px;
  z-index: 2;
  background: #fff;
  min-width: 60px;
}
.cohort-table td.cohort-cell-null {
  background: #f8fafc;
  color: transparent;
}

.cohort-legend {
  display: flex;
  align-items: center;
  gap: 4px;
  flex-wrap: wrap;
  margin-top: 14px;
}
.cohort-legend-item {
  width: 28px;
  height: 14px;
  border-radius: 3px;
}
.cohort-legend span {
  font-size: 10px;
  color: #64748b;
  font-weight: 600;
  margin: 0 6px 0 2px;
}

/* Mode toggle pills */
.mode-pill-group {
  display: inline-flex;
  background: #f1f5f9;
  border-radius: 10px;
  padding: 3px;
  gap: 2px;
}
.mode-pill {
  padding: 7px 16px;
  border-radius: 8px;
  font-size: 12.5px;
  font-weight: 700;
  color: #64748b;
  background: transparent;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.mode-pill:hover {
  color: #334155;
  background: #e2e8f0;
}
.mode-pill.active {
  background: #6366f1;
  color: #fff;
  box-shadow: 0 2px 8px rgba(99,102,241,0.3);
}

/* Animations */
@keyframes rfmFadeInUp {
  from { opacity: 0; transform: translateY(14px); }
  to { opacity: 1; transform: translateY(0); }
}
.rfm-header-nav, .kpi-mini-card, .section-card-custom {
  animation: rfmFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Responsive */
@media (max-width: 767px) {
  .rfm-header-nav { padding: 18px 16px; text-align: center; }
  .rfm-header-nav .header-top-flex { flex-direction: column; align-items: center; }
  .rfm-header-nav .header-title h2 { font-size: 20px; }
  .rfm-header-nav .nav-tabs-bar { justify-content: center; width: 100%; }
  .rfm-header-nav .nav-tab-btn { width: 100%; justify-content: center; padding: 10px; font-size: 12.5px; }
  .kpi-mini-card { padding: 14px 16px; }
  .kpi-mini-val { font-size: 18px; }
  .section-card-custom { padding: 14px; border-radius: 12px; }
  .cohort-table td { min-width: 36px; font-size: 9.5px; padding: 5px 3px; }
  .cohort-table th { font-size: 9px; padding: 6px 4px; }
}
</style>

<?php
  $cohort_data = $cohort ?? [];
  $c_mode = $cohort_mode ?? 'monthly';
  $c_year = $cohort_year ?? date('Y');
  $c_month = $cohort_month ?? date('m');
  $summary = $cohort_data['summary'] ?? [];
  $month_names_id = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];

  // Monthly mode data
  $cohorts = $cohort_data['cohorts'] ?? [];
  $periods = $cohort_data['periods'] ?? [];

  // Daily calendar mode data
  $calendar = $cohort_data['calendar'] ?? [];
  $day_labels = $cohort_data['day_labels'] ?? ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
  $total_weeks = $cohort_data['total_weeks'] ?? 0;
  $max_cust = $cohort_data['max_customers_day'] ?? 1;
?>

<div class="rfm-cohort-wrapper">
  <!-- ==========================================
       LAYER 1: HEADER & NAVIGATION
       ========================================== -->
  <div class="rfm-header-nav">
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> Analisis RFM <i class="fa fa-angle-right"></i> <span>Analisis Kohort</span>
        </div>
        <h2><i class="fa fa-th" style="color:#818cf8;"></i> Analisis Kohort Retensi</h2>
        <p>Heatmap retensi pelanggan berdasarkan kohort pembelian pertama —
          <?php if ($c_mode === 'daily'): ?>
            Mode Harian: <?= $month_names_id[(int)$c_month] . ' ' . $c_year; ?>
          <?php else: ?>
            Mode Bulanan: Tahun <?= $c_year; ?>
          <?php endif; ?>
        </p>
      </div>
    </div>

    <div class="nav-tabs-bar">
      <a href="<?= site_url('administrator/rfm/dashboard'); ?>" class="nav-tab-btn">
        <i class="fa fa-tachometer"></i> 1. Dashboard RFM
      </a>
      <a href="<?= site_url('administrator/rfm'); ?>" class="nav-tab-btn">
        <i class="fa fa-users"></i> 2. Daftar Customer
      </a>
      <a href="<?= site_url('administrator/rfm/tracking'); ?>" class="nav-tab-btn">
        <i class="fa fa-line-chart"></i> 3. Tracking Bulanan
      </a>
      <a href="<?= site_url('administrator/rfm/cohort'); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-th"></i> 4. Analisis Kohort
      </a>
    </div>
  </div>

  <!-- ==========================================
       LAYER 2: FILTER CONTROLS
       ========================================== -->
  <div class="section-card-custom" style="padding:16px 22px; margin-bottom:20px;">
    <form method="GET" action="<?= site_url('administrator/rfm/cohort'); ?>" id="form-cohort-filter">
      <div class="row" style="display:flex; align-items:flex-end; flex-wrap:wrap; margin:0 -8px; gap:0;">
        <!-- Mode Toggle -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-sliders" style="color:#6366f1;"></i> Mode Analisis:
          </label>
          <div class="mode-pill-group">
            <a href="<?= site_url('administrator/rfm/cohort?mode=monthly&year=' . $c_year); ?>" class="mode-pill <?= $c_mode === 'monthly' ? 'active' : ''; ?>">
              <i class="fa fa-calendar"></i> Bulanan (Tahunan)
            </a>
            <a href="<?= site_url('administrator/rfm/cohort?mode=daily&year=' . $c_year . '&month=' . $c_month); ?>" class="mode-pill <?= $c_mode === 'daily' ? 'active' : ''; ?>">
              <i class="fa fa-calendar-o"></i> Harian (1 Bulan)
            </a>
          </div>
        </div>

        <!-- Year Select -->
        <div class="col-md-3 col-sm-3 col-xs-6" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-calendar-check-o" style="color:#059669;"></i> Tahun:
          </label>
          <select name="year" class="form-control" style="border-radius:8px; height:38px; font-size:12.5px; font-weight:600;">
            <?php if (!empty($available_years)): foreach ($available_years as $ay): ?>
            <option value="<?= $ay->yr; ?>" <?= $c_year == $ay->yr ? 'selected' : ''; ?>><?= $ay->yr; ?></option>
            <?php endforeach; endif; ?>
          </select>
        </div>

        <!-- Month Select (for daily mode) -->
        <?php if ($c_mode === 'daily'): ?>
        <div class="col-md-3 col-sm-3 col-xs-6" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-calendar" style="color:#f97316;"></i> Bulan:
          </label>
          <select name="month" class="form-control" style="border-radius:8px; height:38px; font-size:12.5px; font-weight:600;">
            <?php for ($mi = 1; $mi <= 12; $mi++): ?>
            <option value="<?= str_pad($mi, 2, '0', STR_PAD_LEFT); ?>" <?= (int)$c_month === $mi ? 'selected' : ''; ?>><?= $month_names_id[$mi]; ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <?php endif; ?>

        <input type="hidden" name="mode" value="<?= $c_mode; ?>">
        <div class="col-md-2 col-sm-3 col-xs-12" style="padding:0 8px; margin-bottom:8px;">
          <button type="submit" class="btn" style="background:#6366f1; color:#fff; border:none; border-radius:8px; font-weight:700; height:38px; width:100%; display:inline-flex; align-items:center; justify-content:center; gap:6px; box-shadow:0 2px 6px rgba(99,102,241,0.3);">
            <i class="fa fa-filter"></i> Terapkan
          </button>
        </div>
      </div>
    </form>
  </div>

  <!-- ==========================================
       LAYER 3: KPI SUMMARY CARDS
       ========================================== -->
  <div class="row" style="margin-bottom:22px;">
    <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #6366f1;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#4338ca;"><?= $c_mode === 'daily' ? 'Harian' : 'Bulanan'; ?></div>
            <div class="kpi-mini-lbl" style="color:#6366f1;">Mode Analisis</div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#eef2ff; color:#4338ca; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-<?= $c_mode === 'daily' ? 'calendar-o' : 'calendar'; ?>"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #10b981;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <?php if ($c_mode === 'daily'): ?>
            <div class="kpi-mini-val" style="color:#15803d;"><?= number_format($summary['total_orders'] ?? 0); ?></div>
            <div class="kpi-mini-lbl" style="color:#166534;">Total Order</div>
            <?php else: ?>
            <div class="kpi-mini-val" style="color:#15803d;"><?= number_format($summary['total_cohorts'] ?? 0); ?></div>
            <div class="kpi-mini-lbl" style="color:#166534;">Total Kohort</div>
            <?php endif; ?>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#dcfce7; color:#166534; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-<?= $c_mode === 'daily' ? 'shopping-cart' : 'object-group'; ?>"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #3b82f6;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#1d4ed8;"><?= number_format($summary['total_customers'] ?? 0); ?></div>
            <div class="kpi-mini-lbl" style="color:#1e40af;">Total Customer</div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#dbeafe; color:#1e40af; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-users"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #f97316;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#c2410c;">
              <?php if ($c_mode === 'daily'): ?>
                <?= $month_names_id[(int)$c_month] . ' ' . $c_year; ?>
              <?php else: ?>
                Tahun <?= $c_year; ?>
              <?php endif; ?>
            </div>
            <div class="kpi-mini-lbl" style="color:#ea580c;">Periode Analisis</div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#ffedd5; color:#c2410c; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-clock-o"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ==========================================
       LAYER 4: HEATMAP TABLE / CALENDAR
       ========================================== -->
  <div class="section-card-custom" style="padding:0; overflow:hidden;">
    <div style="padding:18px 22px; background:#fafbfc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
      <h3 style="margin:0; font-size:15px; font-weight:800; color:#0f172a; display:flex; align-items:center; gap:8px;">
        <i class="fa fa-<?= $c_mode === 'daily' ? 'calendar' : 'th'; ?>" style="color:#6366f1;"></i>
        <?php if ($c_mode === 'daily'): ?>
          Kalender Heatmap Transaksi — <?= $month_names_id[(int)$c_month] . ' ' . $c_year; ?>
        <?php else: ?>
          Tabel Heatmap Retensi Kohort — Tahun <?= $c_year; ?>
        <?php endif; ?>
      </h3>
      <span style="font-size:12px; color:#64748b; font-weight:600;">
        <i class="fa fa-info-circle"></i>
        <?= $c_mode === 'daily' ? 'Warna = intensitas jumlah customer unik per hari' : 'Warna = % customer yang bertransaksi lagi di periode kolom'; ?>
      </span>
    </div>

    <div class="cohort-table-wrap" style="padding:16px;">
      <?php if ($c_mode === 'daily'): ?>
        <!-- ====== DAILY CALENDAR HEATMAP ====== -->
        <?php if (empty($calendar)): ?>
          <div class="text-center" style="padding:40px 20px; color:#94a3b8;">
            <i class="fa fa-calendar" style="font-size:32px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
            <strong style="font-size:14px; display:block; color:#64748b;">Belum Ada Data</strong>
            <span style="font-size:12px;">Tidak ditemukan data transaksi untuk bulan ini.</span>
          </div>
        <?php else: ?>
          <style>
            .calendar-grid {
              display:grid;
              grid-template-columns: 90px repeat(7, 1fr);
              gap:4px;
              max-width:700px;
              margin:0 auto;
            }
            .calendar-grid .cal-header {
              background:#f1f5f9;
              border-radius:8px;
              padding:10px 6px;
              text-align:center;
              font-size:11px;
              font-weight:800;
              color:#475569;
              text-transform:uppercase;
              letter-spacing:0.5px;
            }
            .calendar-grid .cal-header.col-sab,
            .calendar-grid .cal-header.col-min {
              color:#ef4444;
            }
            .calendar-grid .cal-week-label {
              background:linear-gradient(135deg, #eef2ff, #e0e7ff);
              border-radius:8px;
              padding:10px 8px;
              display:flex;
              align-items:center;
              justify-content:center;
              font-size:11px;
              font-weight:800;
              color:#4338ca;
            }
            .calendar-grid .cal-cell {
              border-radius:10px;
              padding:8px 4px;
              text-align:center;
              min-height:72px;
              display:flex;
              flex-direction:column;
              align-items:center;
              justify-content:center;
              gap:3px;
              transition:all 0.2s ease;
              cursor:default;
              position:relative;
            }
            .calendar-grid .cal-cell:hover {
              transform:scale(1.06);
              z-index:3;
              box-shadow:0 4px 16px rgba(0,0,0,0.15);
            }
            .calendar-grid .cal-cell .cal-date {
              font-size:16px;
              font-weight:900;
              line-height:1;
            }
            .calendar-grid .cal-cell .cal-cust {
              font-size:10px;
              font-weight:700;
              line-height:1;
              opacity:0.9;
            }
            .calendar-grid .cal-cell .cal-order {
              font-size:9px;
              font-weight:600;
              line-height:1;
              opacity:0.75;
            }
            .calendar-grid .cal-cell-empty {
              background:#fafbfc;
              border:1px dashed #e2e8f0;
              border-radius:10px;
              min-height:72px;
            }
            @media (max-width:767px) {
              .calendar-grid { grid-template-columns:60px repeat(7, 1fr); gap:3px; }
              .calendar-grid .cal-cell { min-height:56px; padding:6px 2px; border-radius:8px; }
              .calendar-grid .cal-cell .cal-date { font-size:13px; }
              .calendar-grid .cal-cell .cal-cust { font-size:9px; }
              .calendar-grid .cal-cell .cal-order { font-size:8px; }
              .calendar-grid .cal-header { font-size:9px; padding:8px 4px; }
              .calendar-grid .cal-week-label { font-size:9px; padding:8px 4px; }
            }
          </style>

          <div class="calendar-grid">
            <!-- Header row: empty corner + day labels -->
            <div class="cal-header" style="background:transparent;"></div>
            <?php foreach ($day_labels as $di => $dl): ?>
            <div class="cal-header <?= $di >= 5 ? ($di == 5 ? 'col-sab' : 'col-min') : ''; ?>"><?= $dl; ?></div>
            <?php endforeach; ?>

            <!-- Calendar weeks -->
            <?php for ($w = 1; $w <= $total_weeks; $w++): ?>
              <div class="cal-week-label">Minggu <?= $w; ?></div>
              <?php for ($dow = 1; $dow <= 7; $dow++):
                if (isset($calendar[$w][$dow])):
                  $cell = $calendar[$w][$dow];
                  $cust = $cell['customers'];
                  $ord = $cell['orders'];
                  $date_num = $cell['date'];

                  // Color based on customer intensity
                  if ($max_cust > 0 && $cust > 0) {
                    $intensity = $cust / $max_cust; // 0 to 1
                    if ($intensity >= 0.8) {
                      $bg = '#312e81'; $fg = '#fff';
                    } elseif ($intensity >= 0.6) {
                      $bg = '#4338ca'; $fg = '#fff';
                    } elseif ($intensity >= 0.4) {
                      $bg = '#6366f1'; $fg = '#fff';
                    } elseif ($intensity >= 0.2) {
                      $bg = '#818cf8'; $fg = '#fff';
                    } else {
                      $bg = '#c7d2fe'; $fg = '#312e81';
                    }
                  } elseif ($cust == 0) {
                    $bg = '#fef2f2'; $fg = '#94a3b8';
                  } else {
                    $bg = '#f1f5f9'; $fg = '#64748b';
                  }

                  // Weekend styling override (softer tint)
                  $is_weekend = ($dow >= 6);
              ?>
              <div class="cal-cell" style="background:<?= $bg; ?>; color:<?= $fg; ?>; <?= $is_weekend && $cust == 0 ? 'border:1px solid #fecaca;' : ''; ?>" title="<?= $date_num . ' ' . $month_names_id[(int)$c_month] . ': ' . $cust . ' customer, ' . $ord . ' order'; ?>">
                <span class="cal-date"><?= $date_num; ?></span>
                <span class="cal-cust"><i class="fa fa-user" style="font-size:8px;"></i> <?= $cust; ?></span>
                <span class="cal-order"><i class="fa fa-shopping-cart" style="font-size:7px;"></i> <?= $ord; ?> order</span>
              </div>
              <?php else: ?>
              <div class="cal-cell-empty"></div>
              <?php endif; endfor; ?>
            <?php endfor; ?>
          </div>

          <!-- Calendar Legend -->
          <div class="cohort-legend" style="justify-content:center; margin-top:18px;">
            <span style="font-weight:700; color:#334155; margin-right:8px;">Intensitas Customer:</span>
            <div class="cohort-legend-item" style="background:#fef2f2;"></div><span>0</span>
            <div class="cohort-legend-item" style="background:#c7d2fe;"></div><span>Sedikit</span>
            <div class="cohort-legend-item" style="background:#818cf8;"></div><span>Sedang</span>
            <div class="cohort-legend-item" style="background:#6366f1;"></div><span>Banyak</span>
            <div class="cohort-legend-item" style="background:#312e81;"></div><span>Terbanyak</span>
          </div>
        <?php endif; ?>

      <?php else: ?>
        <!-- ====== MONTHLY COHORT RETENTION TABLE ====== -->
        <?php if (empty($cohorts)): ?>
          <div class="text-center" style="padding:40px 20px; color:#94a3b8;">
            <i class="fa fa-th" style="font-size:32px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
            <strong style="font-size:14px; display:block; color:#64748b;">Belum Ada Data Kohort</strong>
            <span style="font-size:12px;">Tidak ditemukan data transaksi untuk periode ini.</span>
          </div>
        <?php else: ?>
          <table class="cohort-table">
            <thead>
              <tr>
                <th class="cohort-label-th">Kohort</th>
                <th class="cohort-size-th">Jumlah</th>
                <?php foreach ($periods as $p_idx => $p_label): ?>
                <th><?= $p_label; ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($cohorts as $c): ?>
              <tr>
                <td class="cohort-label-td">
                  <i class="fa fa-circle" style="color:#6366f1; font-size:6px; margin-right:4px;"></i>
                  <?= htmlspecialchars($c['label']); ?>
                </td>
                <td class="cohort-size-td"><?= number_format($c['size']); ?></td>
                <?php foreach ($periods as $p_idx => $p_label):
                  $key = $p_idx + 1; // 1-indexed
                  $val = $c['retention'][$key] ?? null;
                  if ($val === null):
                ?>
                <td class="cohort-cell-null">—</td>
                <?php else:
                  if ($val >= 100) {
                    $bg = '#312e81'; $fg = '#fff';
                  } elseif ($val >= 50) {
                    $ratio = ($val - 50) / 50;
                    $r = round(16 + (49 - 16) * (1 - $ratio));
                    $g = round(163 + (46 - 163) * (1 - $ratio));
                    $b = round(33 + (129 - 33) * (1 - $ratio));
                    $bg = "rgb($r,$g,$b)"; $fg = '#fff';
                  } elseif ($val >= 20) {
                    $ratio = ($val - 20) / 30;
                    $r = round(234 + (16 - 234) * $ratio);
                    $g = round(179 + (163 - 179) * $ratio);
                    $b = round(8 + (33 - 8) * $ratio);
                    $bg = "rgb($r,$g,$b)"; $fg = $val >= 35 ? '#fff' : '#1e1b4b';
                  } elseif ($val > 0) {
                    $ratio = $val / 20;
                    $r = round(254 + (234 - 254) * $ratio);
                    $g = round(202 + (179 - 202) * $ratio);
                    $b = round(202 + (8 - 202) * $ratio);
                    $bg = "rgb($r,$g,$b)"; $fg = '#991b1b';
                  } else {
                    $bg = '#fef2f2'; $fg = '#f87171';
                  }
                ?>
                <td style="background:<?= $bg; ?>; color:<?= $fg; ?>;" title="<?= $c['label'] . ' → ' . $p_label . ': ' . $val . '%'; ?>">
                  <?= $val > 0 ? $val . '%' : '0'; ?>
                </td>
                <?php endif; endforeach; ?>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <!-- Legend -->
          <div class="cohort-legend">
            <span style="font-weight:700; color:#334155; margin-right:8px;">Legenda Retensi:</span>
            <div class="cohort-legend-item" style="background:#fef2f2;"></div><span>0%</span>
            <div class="cohort-legend-item" style="background:#fecaca;"></div><span>1-10%</span>
            <div class="cohort-legend-item" style="background:#eab308;"></div><span>20-30%</span>
            <div class="cohort-legend-item" style="background:#10a321;"></div><span>50%+</span>
            <div class="cohort-legend-item" style="background:#312e81;"></div><span>100%</span>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- ==========================================
       LAYER 5: INTERPRETATION GUIDE
       ========================================== -->
  <div class="section-card-custom" style="background:linear-gradient(135deg, #fafbfc, #eef2ff); border:1px solid #e0e7ff;">
    <div style="display:flex; align-items:flex-start; gap:14px; flex-wrap:wrap;">
      <div style="width:42px; height:42px; border-radius:10px; background:#eef2ff; color:#4338ca; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; border:1px solid #c7d2fe;">
        <i class="fa fa-lightbulb-o"></i>
      </div>
      <div style="flex:1; min-width:250px;">
        <?php if ($c_mode === 'daily'): ?>
        <h4 style="margin:0 0 8px 0; font-size:14px; font-weight:800; color:#1e1b4b;">Cara Membaca Kalender Heatmap</h4>
        <ul style="margin:0; padding-left:18px; font-size:12.5px; color:#475569; line-height:1.9;">
          <li><strong>Baris</strong> = Minggu ke-1 sampai ke-5 dalam bulan.</li>
          <li><strong>Kolom</strong> = Hari dalam seminggu (Senin – Minggu).</li>
          <li><strong>Angka besar</strong> = Tanggal. <strong>Angka kecil</strong> = Jumlah customer unik & order hari tersebut.</li>
          <li><strong>Warna gelap (ungu tua)</strong> = Customer terbanyak. <strong>Warna terang (pink)</strong> = Tidak ada transaksi.</li>
          <li>Gunakan kalender ini untuk melihat <strong>pola hari-hari ramai vs sepi</strong> dalam 1 bulan.</li>
        </ul>
        <?php else: ?>
        <h4 style="margin:0 0 8px 0; font-size:14px; font-weight:800; color:#1e1b4b;">Cara Membaca Tabel Kohort</h4>
        <ul style="margin:0; padding-left:18px; font-size:12.5px; color:#475569; line-height:1.9;">
          <li><strong>Baris (Kohort)</strong> = Kelompok customer berdasarkan bulan pembelian pertama mereka.</li>
          <li><strong>Kolom</strong> = Bulan-bulan berikutnya dalam tahun.</li>
          <li><strong>Sel berwarna</strong> = Persentase (%) customer dari kohort tersebut yang melakukan transaksi ulang di bulan kolom.</li>
          <li><strong>Warna gelap (hijau/ungu)</strong> = Retensi tinggi. <strong>Warna terang (merah/pink)</strong> = Retensi rendah.</li>
          <li><strong>100%</strong> = Semua customer kohort bertransaksi di bulan tersebut (biasanya di kolom awal).</li>
        </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
