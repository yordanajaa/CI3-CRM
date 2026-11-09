<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<style>
:root {
  --rfm-primary: #6366f1;
  --rfm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
  --card-radius: 14px;
}

.rfm-cohort-wrapper {
  padding: 0 0 25px 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
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
}
.rfm-header-nav .action-tools .btn {
  border-radius: 9px;
  font-weight: 700;
  font-size: 12px;
  padding: 7px 13px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  border: none;
  transition: transform 0.2s ease;
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

.section-card-custom {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid #e2e8f0;
  box-shadow: var(--card-shadow);
  padding: 20px;
  margin-bottom: 20px;
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
.kpi-mini-sub {
  font-size: 11.5px;
  color: #64748b;
  margin-top: 4px;
}
.kpi-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 3px 9px;
  border-radius: 6px;
  font-size: 11px;
  font-weight: 700;
  margin-top: 8px;
}

/* Cohort Heatmap Table */
.cohort-table-wrap {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: thin;
  scrollbar-color: #cbd5e1 #f8fafc;
  position: relative;
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

/* Sticky frozen columns: High z-index to stay strictly above scrolling data cells */
.cohort-table th.cohort-label-th {
  text-align: left;
  width: 130px;
  min-width: 130px;
  max-width: 130px;
  position: sticky;
  left: 0;
  z-index: 25;
  background-color: #f1f5f9 !important;
  box-sizing: border-box;
}
.cohort-table th.cohort-size-th {
  width: 75px;
  min-width: 75px;
  max-width: 75px;
  position: sticky;
  left: 130px;
  z-index: 25;
  background-color: #f1f5f9 !important;
  box-sizing: border-box;
}
.cohort-table th.cohort-rev-th {
  width: 95px;
  min-width: 95px;
  max-width: 95px;
  position: sticky;
  left: 205px;
  z-index: 25;
  background-color: #f1f5f9 !important;
  box-sizing: border-box;
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
  transform: scale(1.1);
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
  z-index: 20;
  background-color: #ffffff !important;
  width: 130px;
  min-width: 130px;
  max-width: 130px;
  white-space: nowrap;
  box-sizing: border-box;
}
.cohort-table td.cohort-size-td {
  font-size: 11.5px;
  color: #334155;
  font-weight: 800;
  position: sticky;
  left: 130px;
  z-index: 20;
  background-color: #ffffff !important;
  width: 75px;
  min-width: 75px;
  max-width: 75px;
  box-sizing: border-box;
  box-shadow: 2px 0 5px rgba(0,0,0,0.06);
}
.cohort-table td.cohort-rev-td {
  font-size: 11px;
  color: #059669;
  font-weight: 800;
  position: sticky;
  left: 205px;
  z-index: 20;
  background-color: #ffffff !important;
  width: 95px;
  min-width: 95px;
  max-width: 95px;
  white-space: nowrap;
  box-sizing: border-box;
  box-shadow: 2px 0 5px rgba(0,0,0,0.06);
}

/* Ensure aggregate row frozen cells have solid opaque background */
tr[style*="border-top"] td.cohort-label-td,
tr[style*="border-top"] td.cohort-size-td,
tr[style*="border-top"] td.cohort-rev-td {
  background-color: #eef2ff !important;
}

.cohort-table td.cohort-cell-null {
  background: #f8fafc;
  color: transparent;
}

.cohort-cell-clickable {
  cursor: pointer !important;
  position: relative;
  transition: transform 0.16s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.16s ease !important;
}
.cohort-cell-clickable:hover {
  transform: scale(1.15) !important;
  z-index: 6 !important; /* Kept strictly below sticky columns (z-index: 20) */
  box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;
  outline: 2px solid #ffffff;
}

/* Mobile Responsiveness for Cohort Table */
@media (max-width: 767px) {
  .cohort-table-wrap {
    padding: 10px 0 !important;
    margin: 0 !important;
  }
  .cohort-table {
    border-collapse: separate !important;
    border-spacing: 0 !important;
    width: max-content !important;
    min-width: 100% !important;
  }
  .cohort-table th,
  .cohort-table td {
    box-sizing: border-box !important;
    border-right: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    border-radius: 0 !important;
    white-space: nowrap !important;
  }
  .cohort-table td {
    min-width: 52px !important;
    padding: 6px 4px !important;
    font-size: 11px !important;
    font-weight: 700 !important;
  }
  .cohort-table th.cohort-label-th,
  .cohort-table td.cohort-label-td {
    width: 94px !important;
    min-width: 94px !important;
    max-width: 94px !important;
    left: 0 !important;
    font-size: 10.5px !important;
    padding: 7px 5px !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    z-index: 20 !important;
    background-color: #ffffff !important;
  }
  .cohort-table th.cohort-label-th {
    background-color: #f1f5f9 !important;
    z-index: 25 !important;
    text-align: left !important;
  }
  .cohort-table th.cohort-size-th,
  .cohort-table td.cohort-size-td {
    width: 62px !important;
    min-width: 62px !important;
    max-width: 62px !important;
    left: 94px !important;
    font-size: 10.5px !important;
    padding: 7px 3px !important;
    text-align: center !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    z-index: 20 !important;
    background-color: #ffffff !important;
    border-right: 2px solid #94a3b8 !important;
    box-shadow: 3px 0 8px rgba(0, 0, 0, 0.16) !important;
  }
  .cohort-table th.cohort-size-th {
    background-color: #f1f5f9 !important;
    z-index: 25 !important;
  }
  /* In Table 2 (Omset), un-stick 3rd column on mobile so it scrolls naturally with months */
  .cohort-table th.cohort-rev-th,
  .cohort-table td.cohort-rev-td {
    position: static !important;
    left: auto !important;
    z-index: auto !important;
    box-shadow: none !important;
    border-right: 1px solid #f1f5f9 !important;
    min-width: 82px !important;
    font-size: 10px !important;
    padding: 6px 4px !important;
  }
  /* Table 2 monthly revenue cells: generous width so numbers and trend arrows never get cut off */
  #section-cohort-revenue-table .cohort-table td {
    min-width: 68px !important;
    font-size: 10px !important;
    padding: 6px 3px !important;
  }
  #section-cohort-revenue-table .cohort-table th {
    min-width: 68px !important;
  }
  /* Aggregate row solid background */
  tr[style*="border-top"] td.cohort-label-td,
  tr[style*="border-top"] td.cohort-size-td {
    background-color: #eef2ff !important;
  }
  #section-cohort-revenue-table tr[style*="border-top"] td.cohort-label-td,
  #section-cohort-revenue-table tr[style*="border-top"] td.cohort-size-td {
    background-color: #ecfdf5 !important;
  }
  /* Disable cell scale transformation on touch to prevent bleeding into adjacent cells */
  .cohort-table td:hover,
  .cohort-cell-clickable:hover {
    transform: none !important;
    outline: none !important;
  }
}

/* Modal Drilldown Styling */
#modalCohortDrilldown .modal-dialog {
  width: 92%;
  max-width: 950px;
  margin: 30px auto;
}
#modalCohortDrilldown .modal-content {
  border-radius: 16px;
  border: none;
  overflow: hidden;
  box-shadow: 0 20px 50px rgba(0,0,0,0.25);
}
#modalCohortDrilldown .modal-header {
  background: var(--rfm-gradient);
  color: #fff;
  padding: 18px 24px;
  border: none;
}
#modalCohortDrilldown .modal-header .close {
  color: #fff;
  opacity: 0.85;
  font-size: 26px;
  text-shadow: none;
  transition: opacity 0.2s;
}
#modalCohortDrilldown .modal-header .close:hover {
  opacity: 1;
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
  padding: 7px 14px;
  border-radius: 8px;
  font-size: 12px;
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

/* Decay Chart Curve Toggle Buttons */
.decay-toggle-btn {
  background: #ffffff;
  color: #475569;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  padding: 6px 13px;
  font-size: 11.5px;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.decay-toggle-btn:hover {
  background: #f8fafc;
  color: #1e293b;
  border-color: #94a3b8;
  transform: translateY(-1px);
}
.decay-toggle-btn.active {
  background: #4338ca !important;
  color: #ffffff !important;
  border-color: #4338ca !important;
  box-shadow: 0 3px 10px rgba(67, 56, 202, 0.35) !important;
}
.decay-toggle-btn.active i {
  color: #ffffff !important;
}

/* Drilldown Filter Tab Buttons */
#ddTabFilter .btn {
  font-weight: 700;
  font-size: 12px;
  padding: 6px 14px;
  transition: all 0.2s ease;
}
#ddTabFilter .btn.active {
  background: #4338ca !important;
  border-color: #4338ca !important;
  color: #ffffff !important;
  box-shadow: 0 2px 8px rgba(67, 56, 202, 0.35) !important;
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
  .rfm-cohort-wrapper { padding: 0 0 15px 0; }
  .rfm-header-nav { padding: 16px 14px; border-radius: 12px; }
  .rfm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; }
  .rfm-header-nav .header-title h2 { font-size: 18px; }
  .rfm-header-nav .header-title p { font-size: 11.5px; }
  .rfm-header-nav .nav-tabs-bar { padding-top: 10px; gap: 6px; }
  .rfm-header-nav .nav-tab-btn { padding: 7px 12px; font-size: 11.5px; }
  .kpi-mini-card { padding: 12px 14px; }
  .kpi-mini-val { font-size: 15px; }
  .section-card-custom { padding: 14px; border-radius: 12px; }
  .cohort-table td { min-width: 36px; font-size: 9.5px; padding: 5px 3px; }
  .cohort-table th { font-size: 9px; padding: 6px 4px; }
}
</style>

<?php
  if (!function_exists('rfm_format_compact_rp')) {
    function rfm_format_compact_rp($val) {
      if ($val === null) return '';
      if ($val <= 0) return '0';
      if ($val >= 1000000000) return round($val / 1000000000, 1) . 'M';
      if ($val >= 1000000) return round($val / 1000000, 1) . 'Jt';
      if ($val >= 1000) return round($val / 1000, 0) . 'rb';
      return number_format($val, 0, ',', '.');
    }
  }

  $cohort_data = $cohort ?? [];
  $c_mode = $cohort_mode ?? 'monthly';
  $c_year = $cohort_year ?? date('Y');
  $c_month = $cohort_month ?? date('m');
  $c_product = $cohort_product ?? '';
  $c_category = $cohort_category ?? ($this->input->get('kategori') ?: '');
  $cohorts = $cohort_data['cohorts'] ?? [];
  $periods = $cohort_data['periods'] ?? [];
  $summary = $cohort_data['summary'] ?? [];
  $aggregate = $cohort_data['aggregate'] ?? null;
  $month_names_id = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];

  // Global query string for preserving active filters across all 5 RFM tabs
  $nav_params = array_filter([
    'kategori' => $c_category,
    'product' => $c_product,
    'year' => $c_year,
    'period' => ($c_mode === 'daily' ? ($c_year . '-' . str_pad($c_month, 2, '0', STR_PAD_LEFT)) : '')
  ]);
  $nav_qs = !empty($nav_params) ? '?' . http_build_query($nav_params) : '';

  // Compute max revenue cell value for heatmap scaling
  $max_rev_cell = 1;
  foreach ($cohorts as $ch) {
    if (!empty($ch['revenue'])) {
      foreach ($ch['revenue'] as $rv) {
        if ($rv !== null && $rv > $max_rev_cell) {
          $max_rev_cell = $rv;
        }
      }
    }
  }

  // Smart KPI & Cohort Retention Insights Calculation
  $m1_values = [];
  $best_cohort_name = '-';
  $best_cohort_rate = 0;
  $best_cohort_size = 0;

  foreach ($cohorts as $ch) {
    if ($c_mode === 'daily') {
      if (isset($ch['retention'][1]) && $ch['retention'][1] !== null && (float)$ch['retention'][1] > 0) {
        $r_val = (float)$ch['retention'][1];
        $m1_values[] = $r_val;
        if ($r_val > $best_cohort_rate) {
          $best_cohort_rate = $r_val;
          $best_cohort_name = $ch['label'];
          $best_cohort_size = $ch['size'];
        }
      }
    } else {
      $ch_m = (int)substr($ch['date_label'], 5, 2);
      $next_m = $ch_m + 1;
      if ($next_m <= 12 && isset($ch['retention'][$next_m]) && $ch['retention'][$next_m] !== null) {
        $r_val = (float)$ch['retention'][$next_m];
        if ($r_val > 0) {
          $m1_values[] = $r_val;
          if ($r_val > $best_cohort_rate) {
            $best_cohort_rate = $r_val;
            $best_cohort_name = $ch['label'];
            $best_cohort_size = $ch['size'];
          }
        }
      }
    }
  }

  $avg_m1_retention = !empty($m1_values) ? round(array_sum($m1_values) / count($m1_values), 1) : 0;
  $tot_customers = $summary['total_customers'] ?? ($aggregate['size'] ?? 0);
  $tot_revenue = $summary['total_revenue'] ?? ($aggregate['total_revenue'] ?? 0);
  $avg_ltv = $tot_customers > 0 ? round($tot_revenue / $tot_customers) : 0;

  // Build Retention Decay Chart Datasets
  $chart_decay_labels = [];
  $chart_decay_datasets = [];
  $palette = ['#4f46e5', '#059669', '#d97706', '#dc2626', '#8b5cf6', '#0891b2', '#ea580c', '#ec4899', '#14b8a6', '#64748b'];

  if ($c_mode === 'daily') {
    foreach ($periods as $p_lbl) {
      $chart_decay_labels[] = $p_lbl;
    }
    if (!empty($aggregate['retention'])) {
      $agg_pts = [];
      foreach ($periods as $p_idx => $p_lbl) {
        $agg_pts[] = isset($aggregate['retention'][$p_idx]) ? $aggregate['retention'][$p_idx] : null;
      }
      $chart_decay_datasets[] = [
        'label' => 'Rata-rata Semua Customer',
        'data' => $agg_pts,
        'borderColor' => '#312e81',
        'backgroundColor' => 'rgba(49, 46, 129, 0.08)',
        'borderWidth' => 3.5,
        'tension' => 0.3,
        'fill' => true,
        'pointRadius' => 3,
        'pointBackgroundColor' => '#312e81',
      ];
    }
    $c_idx = 0;
    foreach ($cohorts as $ch) {
      $pts = [];
      foreach ($periods as $p_idx => $p_lbl) {
        $pts[] = isset($ch['retention'][$p_idx]) ? $ch['retention'][$p_idx] : null;
      }
      $chart_decay_datasets[] = [
        'label' => $ch['label'],
        'data' => $pts,
        'borderColor' => $palette[$c_idx % count($palette)],
        'borderWidth' => 2,
        'tension' => 0.3,
        'fill' => false,
        'pointRadius' => 2.5,
        'hidden' => false,
      ];
      $c_idx++;
    }
  } else {
    $max_rel_m = 0;
    $rel_cohort_data = [];

    foreach ($cohorts as $ch) {
      $ch_m = (int)substr($ch['date_label'], 5, 2);
      $decay = [];
      for ($rel = 0; $rel <= (12 - $ch_m); $rel++) {
        $target_m = $ch_m + $rel;
        if (isset($ch['retention'][$target_m])) {
          $decay[$rel] = $ch['retention'][$target_m];
          if ($rel > $max_rel_m) $max_rel_m = $rel;
        }
      }
      $rel_cohort_data[$ch['label']] = $decay;
    }

    for ($r = 0; $r <= $max_rel_m; $r++) {
      $chart_decay_labels[] = $r === 0 ? 'Bulan ke-1 (Awal Belanja)' : 'Bulan ke-' . ($r + 1);
    }

    $avg_curve_pts = [];
    for ($r = 0; $r <= $max_rel_m; $r++) {
      $r_vals = [];
      foreach ($rel_cohort_data as $lbl => $pts) {
        if (isset($pts[$r]) && $pts[$r] !== null) {
          $r_vals[] = $pts[$r];
        }
      }
      $avg_curve_pts[] = !empty($r_vals) ? round(array_sum($r_vals) / count($r_vals), 1) : null;
    }

    $chart_decay_datasets[] = [
      'label' => 'Rata-rata Keseluruhan',
      'data' => $avg_curve_pts,
      'borderColor' => '#312e81',
      'backgroundColor' => 'rgba(49, 46, 129, 0.08)',
      'borderWidth' => 3.5,
      'tension' => 0.3,
      'fill' => true,
      'pointRadius' => 4,
      'pointBackgroundColor' => '#312e81',
      'hidden' => false,
    ];

    $c_idx = 0;
    foreach ($rel_cohort_data as $lbl => $pts) {
      $curve = [];
      for ($r = 0; $r <= $max_rel_m; $r++) {
        $curve[] = isset($pts[$r]) ? $pts[$r] : null;
      }
      $col = $palette[$c_idx % count($palette)];
      $chart_decay_datasets[] = [
        'label' => $lbl,
        'data' => $curve,
        'borderColor' => $col,
        'borderWidth' => 2,
        'tension' => 0.3,
        'fill' => false,
        'pointRadius' => 3,
        'hidden' => false,
      ];
      $c_idx++;
    }
  }
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
        <h2><i class="fa fa-th" style="color:#818cf8;"></i> Analisis Kohort — Loyalitas & Pembelian Ulang Pelanggan</h2>
        <p>Memantau persentase pelanggan yang kembali berbelanja (repeat order) dan total perolehan omset berdasarkan bulan pertama kali mereka bertransaksi —
          <?php if ($c_mode === 'daily'): ?>
            Mode Harian: <?= $month_names_id[(int)$c_month] . ' ' . $c_year; ?>
          <?php else: ?>
            Mode Bulanan: Tahun <?= $c_year; ?>
          <?php endif; ?>
          <?php if (!empty($c_category)): ?>
            | <span class="badge" style="background:#0284c7; font-size:11px;">📁 <?= htmlspecialchars($c_category); ?></span>
          <?php endif; ?>
          <?php if (!empty($c_product)): ?>
            | <span class="badge" style="background:#8b5cf6; font-size:11px;">📦 <?= htmlspecialchars($c_product); ?></span>
          <?php endif; ?>
        </p>
      </div>

      <div class="action-tools">
        <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn" style="background:#25D366; color:#fff;" title="Broadcast WA"><i class="fa fa-bullhorn"></i> Broadcast WA</a>
        <button type="button" class="btn" data-toggle="modal" data-target="#modal-import-excel" style="background:#10b981; color:#fff; box-shadow:0 4px 12px rgba(16,185,129,0.35);"><i class="fa fa-file-excel-o"></i> Import Excel Data</button>
        <a href="<?= site_url('administrator/rfm/export_customers' . $nav_qs); ?>" class="btn" style="background:rgba(255,255,255,0.18); color:#fff; border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-download"></i> Export CSV</a>
      </div>
    </div>

    <div class="nav-tabs-bar">
      <a href="<?= site_url('administrator/rfm/dashboard' . $nav_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-tachometer"></i> 1. Dashboard RFM
      </a>
      <a href="<?= site_url('administrator/rfm' . $nav_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-users"></i> 2. Daftar Customer
      </a>
      <a href="<?= site_url('administrator/rfm/tracking'); ?>" class="nav-tab-btn">
        <i class="fa fa-line-chart"></i> 3. Tracking RFM
      </a>
      <a href="<?= site_url('administrator/rfm/cohort' . $nav_qs); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-th"></i> 4. Analisis Kohort
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
            <a href="<?= site_url('administrator/rfm/cohort?mode=monthly&year=' . $c_year . ($c_category ? '&kategori=' . urlencode($c_category) : '') . ($c_product ? '&product=' . urlencode($c_product) : '')); ?>" class="mode-pill <?= $c_mode === 'monthly' ? 'active' : ''; ?>">
              <i class="fa fa-calendar"></i> Tampilan Bulanan (Setahun)
            </a>
            <a href="<?= site_url('administrator/rfm/cohort?mode=daily&year=' . $c_year . '&month=' . $c_month . ($c_category ? '&kategori=' . urlencode($c_category) : '') . ($c_product ? '&product=' . urlencode($c_product) : '')); ?>" class="mode-pill <?= $c_mode === 'daily' ? 'active' : ''; ?>">
              <i class="fa fa-calendar-o"></i> Tampilan Harian (1 Bulan)
            </a>
          </div>
        </div>

        <!-- Filter Kategori -->
        <div class="col-md-2 col-sm-6 col-xs-12" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-folder-open-o" style="color:#0284c7;"></i> Filter Kategori:
          </label>
          <select name="kategori" class="form-control" style="border-radius:8px; height:38px; font-size:12.5px; font-weight:600;" onchange="document.getElementById('cohort-product-select').value=''; document.getElementById('form-cohort-filter').submit();">
            <option value="">-- Semua Kategori --</option>
            <?php if (!empty($categories_list)): ?>
              <?php foreach ($categories_list as $cat): 
                $c_name = is_object($cat) ? $cat->nama_kategori : (is_array($cat) ? ($cat['nama_kategori'] ?? '') : (string)$cat);
                if (empty($c_name)) continue;
              ?>
              <option value="<?= htmlspecialchars($c_name); ?>" <?= (!empty($c_category) && $c_category === $c_name) ? 'selected' : ''; ?>>
                <?= (stripos($c_name, 'Resi') !== false ? '📦 ' : '📁 ') . htmlspecialchars($c_name); ?>
              </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <!-- Product Filter -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-shopping-bag" style="color:#8b5cf6;"></i> Filter Produk:
          </label>
          <select name="product" id="cohort-product-select" class="form-control" style="border-radius:8px; height:38px; font-size:12.5px; font-weight:600;" onchange="document.getElementById('form-cohort-filter').submit();">
            <option value="">-- Semua Produk (Keseluruhan) --</option>
            <?php 
            $p_all = !empty($products_list) ? $products_list : (!empty($product_list) ? $product_list : []);
            $grouped_prods = [];
            foreach ($p_all as $pl) {
              $p_name = is_object($pl) ? ($pl->item_name ?? $pl->nama_produk ?? '') : (string)$pl;
              $p_cat = is_object($pl) ? ($pl->nama_kategori ?? 'Lainnya') : 'Lainnya';
              if (empty($p_cat)) $p_cat = 'Tanpa Kategori';
              if (empty($p_name)) continue;
              $grouped_prods[$p_cat][] = $p_name;
            }
            ksort($grouped_prods);
            ?>
            <?php foreach ($grouped_prods as $kat => $prods): ?>
              <optgroup label="📂 <?= htmlspecialchars($kat); ?>">
                <?php foreach ($prods as $p_name): ?>
                  <option value="<?= htmlspecialchars($p_name); ?>" <?= (!empty($c_product) && $c_product === $p_name) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($p_name); ?>
                  </option>
                <?php endforeach; ?>
              </optgroup>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Year Select -->
        <div class="col-md-2 col-sm-3 col-xs-6" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-calendar-check-o" style="color:#059669;"></i> Tahun:
          </label>
          <select name="year" class="form-control" style="border-radius:8px; height:38px; font-size:12.5px; font-weight:600;" onchange="document.getElementById('form-cohort-filter').submit();">
            <?php if (!empty($available_years)): foreach ($available_years as $ay): ?>
            <option value="<?= $ay->yr; ?>" <?= $c_year == $ay->yr ? 'selected' : ''; ?>><?= $ay->yr; ?></option>
            <?php endforeach; endif; ?>
          </select>
        </div>

        <!-- Month Select (for daily mode) -->
        <?php if ($c_mode === 'daily'): ?>
        <div class="col-md-2 col-sm-3 col-xs-6" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-calendar" style="color:#f97316;"></i> Bulan:
          </label>
          <select name="month" class="form-control" style="border-radius:8px; height:38px; font-size:12.5px; font-weight:600;" onchange="document.getElementById('form-cohort-filter').submit();">
            <?php for ($mi = 1; $mi <= 12; $mi++): ?>
            <option value="<?= str_pad($mi, 2, '0', STR_PAD_LEFT); ?>" <?= (int)$c_month === $mi ? 'selected' : ''; ?>><?= $month_names_id[$mi]; ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <?php endif; ?>

        <input type="hidden" name="mode" value="<?= $c_mode; ?>">
        <div class="col-md-2 col-sm-3 col-xs-12" style="padding:0 8px; margin-bottom:8px; display:flex; gap:6px;">
          <button type="submit" class="btn" style="background:#6366f1; color:#fff; border:none; border-radius:8px; font-weight:700; height:38px; flex:1; display:inline-flex; align-items:center; justify-content:center; gap:6px; box-shadow:0 2px 6px rgba(99,102,241,0.3);">
            <i class="fa fa-filter"></i> Filter
          </button>
          <?php if (!empty($c_category) || !empty($c_product) || $c_year != date('Y') || ($c_mode === 'daily' && $c_month != date('m'))): ?>
            <a href="<?= site_url('administrator/rfm/cohort?mode=' . $c_mode); ?>" class="btn" style="background:#e2e8f0; color:#475569; border:none; border-radius:8px; font-weight:700; height:38px; padding:0 10px; display:inline-flex; align-items:center; justify-content:center; gap:4px;" title="Reset Filter">
              <i class="fa fa-refresh"></i>
            </a>
          <?php endif; ?>
          <a href="<?= site_url('administrator/rfm/export_cohort?mode=' . $c_mode . '&year=' . $c_year . '&month=' . $c_month . ($c_category ? '&kategori=' . urlencode($c_category) : '') . ($c_product ? '&product=' . urlencode($c_product) : '')); ?>" class="btn" style="background:#10b981; color:#fff; border:none; border-radius:8px; font-weight:700; height:38px; padding:0 12px; display:inline-flex; align-items:center; justify-content:center; gap:6px; box-shadow:0 2px 6px rgba(16,185,129,0.3);" title="Unduh Matriks Kohort (Excel/CSV)">
            <i class="fa fa-file-excel-o"></i> Unduh
          </a>
        </div>
      </div>
    </form>
  </div>

  <!-- ==========================================
       LAYER 3: SMART RETENTION INSIGHTS & KPI CARDS
       ========================================== -->
  <div class="row" style="margin-bottom:22px;">
    <!-- Card 1: Rata-rata Retensi M+1 -->
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:12px;">
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="var el=document.getElementById('section-decay-chart'); if(el){ el.scrollIntoView({behavior:'smooth'}); }" title="Klik untuk melihat grafik kurva tren belanja ulang pelanggan" style="border-left:4px solid #6366f1;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
          <div style="flex:1;">
            <div class="kpi-mini-lbl" style="color:#4338ca;">
              <?= $c_mode === 'daily' ? 'Rata-rata Repeat Order Hari ke-2' : 'Rata-rata Belanja Lagi di Bulan ke-2'; ?> &darr;
            </div>
            <div class="kpi-mini-val" style="color:#312e81; font-size:24px; margin-top:2px;">
              <?= $avg_m1_retention; ?>%
            </div>
            <div class="kpi-mini-sub">
              Pelanggan yang order lagi di <?= $c_mode === 'daily' ? 'hari berikutnya' : 'bulan berikutnya'; ?>
            </div>
            <?php if ($avg_m1_retention >= 40): ?>
              <span class="kpi-badge" style="background:#dcfce7; color:#15803d;"><i class="fa fa-fire"></i> Sangat Kuat (&gt;40%)</span>
            <?php elseif ($avg_m1_retention >= 25): ?>
              <span class="kpi-badge" style="background:#e0e7ff; color:#3730a3;"><i class="fa fa-check-circle"></i> Bagus (25-40%)</span>
            <?php else: ?>
              <span class="kpi-badge" style="background:#fee2e2; color:#b91c1c;"><i class="fa fa-exclamation-triangle"></i> Perlu Ditingkatkan</span>
            <?php endif; ?>
          </div>
          <div style="width:42px; height:42px; border-radius:12px; background:#eef2ff; color:#4338ca; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-refresh"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2: Best Performing Cohort -->
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:12px;">
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="var el=document.getElementById('section-cohort-table'); if(el){ el.scrollIntoView({behavior:'smooth'}); }" title="Klik untuk menuju ke tabel matriks retensi kohort" style="border-left:4px solid #f59e0b;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
          <div style="flex:1;">
            <div class="kpi-mini-lbl" style="color:#b45309;">Kelompok Pelanggan Paling Loyal &darr;</div>
            <div class="kpi-mini-val" style="color:#92400e; font-size:20px; margin-top:2px;">
              <?= htmlspecialchars($best_cohort_name); ?>
            </div>
            <div class="kpi-mini-sub">
              Bulan dengan persentase belanja ulang tertinggi
            </div>
            <span class="kpi-badge" style="background:#fef3c7; color:#92400e;">
              <i class="fa fa-trophy"></i> Belanja Lagi: <?= $best_cohort_rate; ?>% (<?= number_format($best_cohort_size); ?> Pelanggan)
            </span>
          </div>
          <div style="width:42px; height:42px; border-radius:12px; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-star"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3: Customer LTV Indikatif -->
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:12px;">
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm' . $nav_qs); ?>';" title="Klik untuk melihat rincian pelanggan dan nilai belanjanya di Daftar Customer RFM" style="border-left:4px solid #10b981;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
          <div style="flex:1;">
            <div class="kpi-mini-lbl" style="color:#047857;">Rata-rata Belanja per Pelanggan &rarr;</div>
            <div class="kpi-mini-val" style="color:#065f46; font-size:22px; margin-top:2px;" title="Rp <?= number_format($avg_ltv, 0, ',', '.'); ?> / customer">
              Rp <?= rfm_format_compact_rp($avg_ltv); ?>
            </div>
            <div class="kpi-mini-sub">
              Total kontribusi omset rata-rata dari setiap customer
            </div>
            <span class="kpi-badge" style="background:#ecfdf5; color:#047857;">
              <i class="fa fa-line-chart"></i> Rata-rata Belanja per Orang
            </span>
          </div>
          <div style="width:42px; height:42px; border-radius:12px; background:#ecfdf5; color:#059669; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-money"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 4: Total Omset & Populasi Customer -->
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:12px;">
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm/tracking'); ?>';" title="Klik untuk melihat analisis riwayat omset di Tracking RFM" style="border-left:4px solid #3b82f6;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
          <div style="flex:1;">
            <div class="kpi-mini-lbl" style="color:#1d4ed8;">Total Seluruh Omset Penjualan &rarr;</div>
            <div class="kpi-mini-val" style="color:#1e40af; font-size:22px; margin-top:2px;" title="Rp <?= number_format($tot_revenue, 0, ',', '.'); ?>">
              Rp <?= rfm_format_compact_rp($tot_revenue); ?>
            </div>
            <div class="kpi-mini-sub">
              Total dari <?= number_format($tot_customers); ?> pelanggan terdaftar
            </div>
            <span class="kpi-badge" style="background:#eff6ff; color:#1d4ed8;">
              <i class="fa fa-users"></i> <?= number_format($tot_customers); ?> Pelanggan Unik
            </span>
          </div>
          <div style="width:42px; height:42px; border-radius:12px; background:#dbeafe; color:#1d4ed8; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-pie-chart"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ==========================================
       LAYER 3.5: RETENTION DECAY CURVE (CHART.JS)
       ========================================== -->
  <div class="section-card-custom" id="section-decay-chart" style="padding:22px 24px 18px 24px; margin-bottom:24px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:12px; margin-bottom:18px;">
      <div>
        <h4 style="margin:0 0 4px 0; font-size:16px; font-weight:800; color:#1e1b4b; display:flex; align-items:center; gap:8px;">
          <i class="fa fa-line-chart" style="color:#6366f1;"></i> Grafik Tren Belanja Ulang Pelanggan
        </h4>
        <p style="margin:0; font-size:12.5px; color:#475569; line-height:1.5;">
          Grafik ini memperlihatkan seberapa banyak pelanggan yang <strong>kembali belanja</strong> di bulan-bulan berikutnya setelah transaksi pertama mereka.
          <br><small style="color:#64748b;"><i class="fa fa-info-circle" style="color:#6366f1;"></i> <strong>Bulan ke-1 (100%)</strong> = Pembelian pertama &bull; <strong>Bulan ke-2, ke-3, dst</strong> = Persentase pelanggan yang kembali belanja &bull; <em>Klik nama bulan di atas grafik untuk menyembunyikan/menampilkan garis.</em></small>
        </p>
      </div>
      <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
        <button type="button" id="btnToggleAllCurves" class="decay-toggle-btn active" title="Tampilkan seluruh kurva kohort per bulan">
          <i class="fa fa-eye"></i> Tampilkan Semua
        </button>
        <button type="button" id="btnOnlyAvgCurve" class="decay-toggle-btn" title="Hanya tampilkan kurva rata-rata keseluruhan">
          <i class="fa fa-filter"></i> Hanya Rata-rata
        </button>
      </div>
    </div>
    <div style="position:relative; height:320px; width:100%;">
      <canvas id="retentionDecayChart"></canvas>
    </div>
  </div>

  <!-- ==========================================
       LAYER 4A: COHORT RETENTION HEATMAP TABLE (%)
       ========================================== -->
  <div class="section-card-custom" id="section-cohort-table" style="padding:0; overflow:hidden; margin-bottom:24px;">
    <div style="padding:18px 22px; background:#fafbfc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
      <h3 style="margin:0; font-size:15px; font-weight:800; color:#0f172a; display:flex; align-items:center; gap:8px;">
        <i class="fa fa-th" style="color:#6366f1;"></i>
        1. Tabel Persentase Pelanggan Belanja Ulang (%)
        <?php if ($c_mode === 'daily'): ?>
          — <?= $month_names_id[(int)$c_month] . ' ' . $c_year; ?>
        <?php else: ?>
          — Tahun <?= $c_year; ?>
        <?php endif; ?>
      </h3>
      <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
        <a href="<?= site_url('administrator/rfm/export_cohort?mode=' . $c_mode . '&year=' . $c_year . '&month=' . $c_month . ($c_product ? '&product=' . urlencode($c_product) : '')); ?>" class="btn btn-xs" style="background:#10b981; color:#fff; font-weight:700; border-radius:6px; padding:5px 12px; display:inline-flex; align-items:center; gap:5px; border:none; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
          <i class="fa fa-file-excel-o"></i> Unduh Excel Kohort
        </a>
        <span style="font-size:12px; color:#64748b; font-weight:600;">
          <i class="fa fa-info-circle"></i>
          Makin hijau warnanya = Makin banyak pelanggan yang belanja kembali (Klik angka untuk lihat nama pelanggan)
        </span>
      </div>
    </div>

    <div class="cohort-table-wrap" style="padding:16px;">
      <?php if (empty($cohorts)): ?>
        <div class="text-center" style="padding:40px 20px; color:#94a3b8;">
          <i class="fa fa-th" style="font-size:32px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
          <strong style="font-size:14px; display:block; color:#64748b;">Belum Ada Data</strong>
          <span style="font-size:12px;">Tidak ditemukan data transaksi untuk periode ini.</span>
        </div>
      <?php else: ?>
        <table class="cohort-table">
          <thead>
            <tr>
              <th class="cohort-label-th"><span class="hidden-xs">Bulan Pertama Belanja</span><span class="visible-xs">Bulan</span></th>
              <th class="cohort-size-th"><span class="hidden-xs">Jumlah Pelanggan</span><span class="visible-xs">Jml Cust</span></th>
              <?php foreach ($periods as $p_label): ?>
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
                $val = $c['retention'][$p_idx] ?? null;
                if ($val === null):
              ?>
              <td class="cohort-cell-null"></td>
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

                if ($c_mode === 'daily') {
                  $cohort_day = (int)substr($c['date_label'], 8, 2);
                  $target_period_val = sprintf('%s-%02d', substr($c['date_label'], 0, 7), $cohort_day + $p_idx);
                } else {
                  $target_period_val = sprintf('%s-%02d', $c_year, $p_idx);
                }
              ?>
              <td class="cohort-cell-clickable" 
                  data-cohort="<?= $c['date_label']; ?>" 
                  data-target="<?= $target_period_val; ?>" 
                  data-cohort-label="<?= htmlspecialchars($c['label']); ?>" 
                  data-target-label="<?= htmlspecialchars($p_label); ?>" 
                  data-mode="<?= $c_mode; ?>" 
                  data-product="<?= htmlspecialchars($c_product); ?>" 
                  style="background:<?= $bg; ?>; color:<?= $fg; ?>;" 
                  title="<?= htmlspecialchars($c['label']) . ' → ' . htmlspecialchars($p_label) . ': ' . $val . '% (Klik untuk rincian customer)'; ?>">
                <?= $val > 0 ? $val . '%' : '0'; ?>
              </td>
              <?php endif; endforeach; ?>
            </tr>
            <?php endforeach; ?>

            <?php if ($aggregate): ?>
            <!-- Semua Customer aggregate row -->
            <tr style="border-top:3px solid #6366f1;">
              <td class="cohort-label-td" style="background:#eef2ff; font-weight:800; color:#4338ca;">
                <i class="fa fa-users" style="font-size:10px; margin-right:4px;"></i>
                <span class="hidden-xs"><?= $aggregate['label']; ?></span><span class="visible-xs">Semua</span>
              </td>
              <td class="cohort-size-td" style="background:#eef2ff; font-weight:800; color:#4338ca;">
                <?= number_format($aggregate['size']); ?>
              </td>
              <?php foreach ($periods as $p_idx => $p_label):
                $val = $aggregate['retention'][$p_idx] ?? null;
                if ($val === null):
              ?>
              <td style="background:#eef2ff;"></td>
              <?php else:
                if ($val >= 100) {
                  $bg = '#312e81'; $fg = '#fff';
                } elseif ($val >= 50) {
                  $bg = '#4338ca'; $fg = '#fff';
                } else {
                  $bg = '#eef2ff'; $fg = '#4338ca';
                }
              ?>
              <td style="background:<?= $bg; ?>; color:<?= $fg; ?>; font-weight:800;" title="<?= htmlspecialchars($aggregate['label']) . ' → ' . htmlspecialchars($p_label) . ': ' . $val . '%'; ?>">
                <?= $val > 0 ? $val . '%' : '0'; ?>
              </td>
              <?php endif; endforeach; ?>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- Legend Retensi -->
        <div class="cohort-legend">
          <span style="font-weight:700; color:#334155; margin-right:8px;">Keterangan Warna (% Belanja Lagi):</span>
          <div class="cohort-legend-item" style="background:#fef2f2;"></div><span>0% (Belum Ada)</span>
          <div class="cohort-legend-item" style="background:#fecaca;"></div><span>1-10% (Rendah)</span>
          <div class="cohort-legend-item" style="background:#eab308;"></div><span>20-30% (Sedang)</span>
          <div class="cohort-legend-item" style="background:#10a321;"></div><span>50%+ (Tinggi)</span>
          <div class="cohort-legend-item" style="background:#312e81;"></div><span>100% (Bulan Pertama)</span>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- ==========================================
       LAYER 4B: COHORT REVENUE / OMSET HEATMAP TABLE (Rp) - SEPARATE TABLE
       ========================================== -->
  <div class="section-card-custom" id="section-cohort-revenue-table" style="padding:0; overflow:hidden; margin-bottom:24px;">
    <div style="padding:18px 22px; background:#fafbfc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
      <h3 style="margin:0; font-size:15px; font-weight:800; color:#0f172a; display:flex; align-items:center; gap:8px;">
        <i class="fa fa-line-chart" style="color:#059669;"></i>
        2. Tabel Perolehan Omset Penjualan per Bulan (Rp)
        <?php if ($c_mode === 'daily'): ?>
          — <?= $month_names_id[(int)$c_month] . ' ' . $c_year; ?>
        <?php else: ?>
          — Tahun <?= $c_year; ?>
        <?php endif; ?>
      </h3>
      <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
        <a href="<?= site_url('administrator/rfm/export_cohort?mode=' . $c_mode . '&year=' . $c_year . '&month=' . $c_month . ($c_product ? '&product=' . urlencode($c_product) : '')); ?>" class="btn btn-xs" style="background:#059669; color:#fff; font-weight:700; border-radius:6px; padding:5px 12px; display:inline-flex; align-items:center; gap:5px; border:none; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
          <i class="fa fa-file-excel-o"></i> Unduh Excel Omset
        </a>
        <span style="font-size:12px; color:#065f46; font-weight:600; background:#dcfce7; padding:4px 10px; border-radius:12px; border:1px solid #a7f3d0;">
          <i class="fa fa-money"></i>
          Nominal uang masuk (omset) yang dihasilkan pelanggan pada bulan tersebut (Klik angka untuk rincian)
        </span>
      </div>
    </div>

    <div class="cohort-table-wrap" style="padding:16px;">
      <?php if (empty($cohorts)): ?>
        <div class="text-center" style="padding:40px 20px; color:#94a3b8;">
          <i class="fa fa-line-chart" style="font-size:32px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
          <strong style="font-size:14px; display:block; color:#64748b;">Belum Ada Data Omset</strong>
          <span style="font-size:12px;">Tidak ditemukan data omset transaksi untuk periode ini.</span>
        </div>
      <?php else: ?>
        <table class="cohort-table">
          <thead>
            <tr>
              <th class="cohort-label-th"><span class="hidden-xs">Bulan Pertama Belanja</span><span class="visible-xs">Bulan</span></th>
              <th class="cohort-size-th"><span class="hidden-xs">Jumlah Pelanggan</span><span class="visible-xs">Jml Cust</span></th>
              <th class="cohort-rev-th"><span class="hidden-xs">Total Omset</span><span class="visible-xs">Omset</span></th>
              <?php foreach ($periods as $p_label): ?>
              <th><?= $p_label; ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cohorts as $c): 
              $c_tot_rev = $c['total_revenue'] ?? 0;
              $prev_rev_val = null;
              $prev_p_label = '';
            ?>
            <tr>
              <td class="cohort-label-td">
                <i class="fa fa-circle" style="color:#059669; font-size:6px; margin-right:4px;"></i>
                <?= htmlspecialchars($c['label']); ?>
              </td>
              <td class="cohort-size-td"><?= number_format($c['size']); ?></td>
              <td class="cohort-rev-td" title="Rp <?= number_format($c_tot_rev, 0, ',', '.'); ?>">
                Rp <?= rfm_format_compact_rp($c_tot_rev); ?>
              </td>
              <?php foreach ($periods as $p_idx => $p_label):
                $rev_val = $c['revenue'][$p_idx] ?? null;
                if ($rev_val === null):
                  $prev_rev_val = null;
              ?>
              <td class="cohort-cell-null"></td>
              <?php else:
                $trend_icon = '';
                $trend_desc = '';

                if ($prev_rev_val !== null && $rev_val > 0 && $prev_rev_val > 0) {
                  if ($rev_val > $prev_rev_val) {
                    $diff = $rev_val - $prev_rev_val;
                    $pct = round(($diff / $prev_rev_val) * 100, 1);
                    $trend_icon = ' <i class="fa fa-arrow-up" style="font-size:9px; color:#059669;"></i>';
                    $trend_desc = ' (Naik ' . $pct . '% dibanding ' . $prev_p_label . ')';
                  } elseif ($rev_val < $prev_rev_val) {
                    $diff = $prev_rev_val - $rev_val;
                    $pct = round(($diff / $prev_rev_val) * 100, 1);
                    $trend_icon = ' <i class="fa fa-arrow-down" style="font-size:9px; color:#ef4444;"></i>';
                    $trend_desc = ' (Turun ' . $pct . '% dibanding ' . $prev_p_label . ')';
                  } else {
                    $trend_icon = ' <i class="fa fa-minus" style="font-size:8px; opacity:0.6;"></i>';
                    $trend_desc = ' (Sama dibanding ' . $prev_p_label . ')';
                  }
                }

                $prev_rev_val = $rev_val;
                $prev_p_label = $p_label;

                if ($rev_val <= 0) {
                  $bg = '#f8fafc'; $fg = '#94a3b8';
                } else {
                  $ratio = min(1.0, $rev_val / $max_rev_cell);
                  if ($ratio < 0.15) {
                    $bg = '#ecfdf5'; $fg = '#065f46';
                  } elseif ($ratio < 0.45) {
                    $bg = '#a7f3d0'; $fg = '#064e3b';
                  } elseif ($ratio < 0.75) {
                    $bg = '#34d399'; $fg = '#044e37';
                  } else {
                    $bg = '#059669'; $fg = '#ffffff';
                  }
                }

                if ($bg === '#059669' || $bg === '#34d399') {
                  $trend_icon = str_replace(['color:#059669;', 'color:#ef4444;'], ['color:#a7f3d0;', 'color:#fecaca;'], $trend_icon);
                }

                if ($c_mode === 'daily') {
                  $cohort_day = (int)substr($c['date_label'], 8, 2);
                  $target_period_val = sprintf('%s-%02d', substr($c['date_label'], 0, 7), $cohort_day + $p_idx);
                } else {
                  $target_period_val = sprintf('%s-%02d', $c_year, $p_idx);
                }
              ?>
              <td class="cohort-cell-clickable" 
                  data-cohort="<?= $c['date_label']; ?>" 
                  data-target="<?= $target_period_val; ?>" 
                  data-cohort-label="<?= htmlspecialchars($c['label']); ?>" 
                  data-target-label="<?= htmlspecialchars($p_label); ?>" 
                  data-mode="<?= $c_mode; ?>" 
                  data-product="<?= htmlspecialchars($c_product); ?>" 
                  style="background:<?= $bg; ?>; color:<?= $fg; ?>; min-width:62px;" 
                  title="<?= htmlspecialchars($c['label']) . ' → ' . htmlspecialchars($p_label) . ': Rp ' . number_format($rev_val, 0, ',', '.') . $trend_desc . ' (Klik untuk rincian customer)'; ?>">
                <?= $rev_val > 0 ? rfm_format_compact_rp($rev_val) . $trend_icon : '0'; ?>
              </td>
              <?php endif; endforeach; ?>
            </tr>
            <?php endforeach; ?>

            <?php if ($aggregate): 
              $agg_tot_rev = $aggregate['total_revenue'] ?? 0;
              $agg_prev_rev_val = null;
              $agg_prev_p_label = '';
            ?>
            <!-- Semua Customer aggregate omset row -->
            <tr style="border-top:3px solid #059669;">
              <td class="cohort-label-td" style="background:#ecfdf5; font-weight:800; color:#065f46;">
                <i class="fa fa-users" style="font-size:10px; margin-right:4px;"></i>
                <span class="hidden-xs"><?= $aggregate['label']; ?> (Total Omset)</span><span class="visible-xs">Total</span>
              </td>
              <td class="cohort-size-td" style="background:#ecfdf5; font-weight:800; color:#065f46;">
                <?= number_format($aggregate['size']); ?>
              </td>
              <td class="cohort-rev-td" style="background:#ecfdf5; font-weight:800; color:#047857;" title="Rp <?= number_format($agg_tot_rev, 0, ',', '.'); ?>">
                Rp <?= rfm_format_compact_rp($agg_tot_rev); ?>
              </td>
              <?php foreach ($periods as $p_idx => $p_label):
                $rev_val = $aggregate['revenue'][$p_idx] ?? null;
                if ($rev_val === null):
                  $agg_prev_rev_val = null;
              ?>
              <td style="background:#ecfdf5;"></td>
              <?php else:
                $trend_icon = '';
                $trend_desc = '';

                if ($agg_prev_rev_val !== null && $rev_val > 0 && $agg_prev_rev_val > 0) {
                  if ($rev_val > $agg_prev_rev_val) {
                    $diff = $rev_val - $agg_prev_rev_val;
                    $pct = round(($diff / $agg_prev_rev_val) * 100, 1);
                    $trend_icon = ' <i class="fa fa-arrow-up" style="font-size:9px; color:#a7f3d0;"></i>';
                    $trend_desc = ' (Naik ' . $pct . '% dibanding ' . $agg_prev_p_label . ')';
                  } elseif ($rev_val < $agg_prev_rev_val) {
                    $diff = $agg_prev_rev_val - $rev_val;
                    $pct = round(($diff / $agg_prev_rev_val) * 100, 1);
                    $trend_icon = ' <i class="fa fa-arrow-down" style="font-size:9px; color:#fecaca;"></i>';
                    $trend_desc = ' (Turun ' . $pct . '% dibanding ' . $agg_prev_p_label . ')';
                  } else {
                    $trend_icon = ' <i class="fa fa-minus" style="font-size:8px; opacity:0.6;"></i>';
                    $trend_desc = ' (Sama dibanding ' . $agg_prev_p_label . ')';
                  }
                }

                $agg_prev_rev_val = $rev_val;
                $agg_prev_p_label = $p_label;

                $bg = $rev_val > 0 ? '#059669' : '#ecfdf5';
                $fg = $rev_val > 0 ? '#ffffff' : '#065f46';
              ?>
              <td style="background:<?= $bg; ?>; color:<?= $fg; ?>; font-weight:800; min-width:62px;" title="<?= htmlspecialchars($aggregate['label']) . ' → ' . htmlspecialchars($p_label) . ': Rp ' . number_format($rev_val, 0, ',', '.') . $trend_desc; ?>">
                <?= $rev_val > 0 ? rfm_format_compact_rp($rev_val) . $trend_icon : '0'; ?>
              </td>
              <?php endif; endforeach; ?>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- Legend Omset -->
        <div class="cohort-legend" style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
          <div style="display:flex; align-items:center; gap:4px; flex-wrap:wrap;">
            <span style="font-weight:700; color:#334155; margin-right:8px;">Legenda Omset (Rp):</span>
            <div class="cohort-legend-item" style="background:#f8fafc; border:1px solid #cbd5e1;"></div><span>Rp 0</span>
            <div class="cohort-legend-item" style="background:#ecfdf5;"></div><span>Rendah</span>
            <div class="cohort-legend-item" style="background:#a7f3d0;"></div><span>Sedang</span>
            <div class="cohort-legend-item" style="background:#34d399;"></div><span>Tinggi</span>
            <div class="cohort-legend-item" style="background:#059669;"></div><span>Sangat Tinggi</span>
          </div>
          <div style="display:flex; align-items:center; gap:10px; margin-left:auto; font-size:11px; font-weight:700; color:#475569;">
            <span><i class="fa fa-arrow-up" style="color:#059669;"></i> Trend Naik (vs Periode Lalu)</span>
            <span><i class="fa fa-arrow-down" style="color:#ef4444;"></i> Trend Turun (vs Periode Lalu)</span>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- ==========================================
       LAYER 5: TABEL PERBANDINGAN KOHORT PER PRODUK
       ========================================== -->
  <?php if (!empty($product_cohort_summary)): ?>
  <div class="section-card-custom" style="padding:0; overflow:hidden; margin-top:24px;">
    <div style="padding:18px 22px; background:#fafbfc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
      <h3 style="margin:0; font-size:15px; font-weight:800; color:#0f172a; display:flex; align-items:center; gap:8px;">
        <i class="fa fa-shopping-bag" style="color:#8b5cf6;"></i>
        Tabel Perbandingan Retensi Kohort Per Produk — Tahun <?= $c_year; ?>
      </h3>
      <span style="font-size:12px; color:#64748b; font-weight:600;">
        Klik <strong>Filter Heatmap Produk</strong> untuk melihat Heatmap Khusus Produk
      </span>
    </div>

    <div class="table-responsive" style="overflow-x:auto;">
      <table class="table table-hover table-striped" style="margin-bottom:0; width:100%; font-size:12.5px;">
        <thead>
          <tr style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
            <th style="width:4%;">#</th>
            <th style="min-width:220px;">Nama Produk</th>
            <th style="text-align:center; min-width:140px;">Total Customer (Akuisisi)</th>
            <th style="text-align:center; min-width:140px;">Total Transaksi Order</th>
            <th style="text-align:right; min-width:160px;">Total Omset (Monetary)</th>
            <th style="text-align:center; min-width:160px;">Aksi Kohort</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $p_no = 1;
          foreach ($product_cohort_summary as $pcs):
            $is_cur_p = (!empty($c_product) && (mb_strtolower(trim($c_product)) === mb_strtolower(trim($pcs->nama_produk))));
          ?>
          <tr<?= $is_cur_p ? ' style="background:#f3e8ff; border-left:4px solid #8b5cf6;"' : ''; ?>>
            <td><?= $p_no++; ?></td>
            <td>
              <strong style="color:#0f172a; font-size:13px;"><i class="fa fa-tag" style="color:#8b5cf6; margin-right:5px;"></i> <?= htmlspecialchars($pcs->nama_produk); ?></strong>
              <?php if ($is_cur_p): ?>
              <span class="label" style="background:#8b5cf6; color:#fff; font-size:10px; margin-left:5px; padding:2px 6px; border-radius:8px;">Sedang Dilihat</span>
              <?php endif; ?>
            </td>
            <td style="text-align:center;">
              <span class="label" style="background:#e0e7ff; color:#3730a3; font-size:12px; font-weight:800; padding:5px 12px; border-radius:6px;">
                <i class="fa fa-user"></i> <?= number_format($pcs->total_customers); ?> Customer
              </span>
            </td>
            <td style="text-align:center;">
              <strong style="color:#0f172a; font-size:13px;"><?= number_format($pcs->total_orders); ?>x</strong> Order
            </td>
            <td style="text-align:right;">
              <strong style="color:#059669; font-size:13.5px;">Rp <?= number_format($pcs->total_revenue, 0, ',', '.'); ?></strong>
            </td>
            <td style="text-align:center;">
              <?php if ($is_cur_p): ?>
                <a href="<?= site_url('administrator/rfm/cohort?mode=' . $c_mode . '&year=' . $c_year . '&month=' . $c_month); ?>" class="btn btn-xs btn-default" style="border-radius:6px; font-weight:600; font-size:11px;" title="Reset Filter Produk"><i class="fa fa-times"></i> Reset Filter</a>
              <?php else: ?>
                <a href="<?= site_url('administrator/rfm/cohort?mode=' . $c_mode . '&year=' . $c_year . '&month=' . $c_month . '&product=' . urlencode($pcs->nama_produk)); ?>" class="btn btn-xs" style="background:#6366f1; color:#fff; border-radius:6px; font-weight:700; font-size:11px; padding:4px 10px; box-shadow:0 2px 4px rgba(99,102,241,0.25);" title="Filter Heatmap Kohort Produk Ini">
                  <i class="fa fa-th"></i> Filter Heatmap Produk Ini
                </a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

  <!-- ==========================================
       LAYER 6: PANDUAN CARA MEMBACA DATA
       ========================================== -->
  <div class="section-card-custom" style="background:linear-gradient(135deg, #fafbfc, #eef2ff); border:1px solid #e0e7ff;">
    <div style="display:flex; align-items:flex-start; gap:14px; flex-wrap:wrap;">
      <div style="width:42px; height:42px; border-radius:10px; background:#eef2ff; color:#4338ca; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; border:1px solid #c7d2fe;">
        <i class="fa fa-lightbulb-o"></i>
      </div>
      <div style="flex:1; min-width:250px;">
        <h4 style="margin:0 0 8px 0; font-size:14.5px; font-weight:800; color:#1e1b4b;">Panduan Praktis Cara Membaca Data di Halaman Ini</h4>
        <ul style="margin:0; padding-left:18px; font-size:12.5px; color:#475569; line-height:1.9;">
          <li><strong>Baris (Bulan Pertama Belanja)</strong> = Kelompok pelanggan yang pertama kali berbelanja di bulan tersebut.</li>
          <li><strong>Kolom Bulan</strong> = Bulan ketika pelanggan tersebut datang kembali untuk belanja ulang.</li>
          <li><strong>Tabel 1 (Persentase %)</strong> = Menunjukkan berapa persen pelanggan lama yang setia belanja lagi. Makin tinggi persennya, makin bagus retensinya.</li>
          <li><strong>Tabel 2 (Omset Rp)</strong> = Total uang belanja yang masuk dari pelanggan lama tersebut di setiap bulannya.</li>
          <li><strong>Fitur Klik Kotak</strong> = Anda bisa <strong>mengklik kotak angka mana saja</strong> pada tabel untuk langsung melihat siapa saja nama pelanggannya dan nomor WhatsApp mereka.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Modal Cohort Drilldown -->
<div class="modal fade" id="modalCohortDrilldown" tabindex="-1" role="dialog" aria-labelledby="modalCohortDrilldownTitle">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div style="display:flex; align-items:center; gap:10px;">
          <div style="width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.18); display:flex; align-items:center; justify-content:center; font-size:18px;">
            <i class="fa fa-users"></i>
          </div>
          <div>
            <h4 class="modal-title" id="modalCohortDrilldownTitle" style="font-weight:800; font-size:16px; margin:0;">
              Daftar Customer di Periode Ini
            </h4>
            <div id="modalCohortDrilldownSubtitle" style="font-size:12px; color:#e0e7ff; margin-top:3px;">
              Memuat data...
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body" style="padding:20px 24px; background:#f8fafc;">
        <!-- Loading Spinner -->
        <div id="drilldownLoading" style="text-align:center; padding:45px 0;">
          <i class="fa fa-circle-o-notch fa-spin fa-3x" style="color:#6366f1;"></i>
          <p style="margin-top:14px; font-weight:600; color:#64748b; font-size:13px;">Mengambil daftar customer dari database...</p>
        </div>

        <!-- Content Container -->
        <div id="drilldownContent" style="display:none;">
          <!-- KPI Summary Cards in Modal -->
          <div class="row" style="margin-bottom:16px;">
            <div class="col-xs-4" style="padding:0 6px;">
              <div style="background:#fff; border-radius:10px; padding:12px; text-align:center; border:1px solid #e2e8f0; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
                <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.5px;">Total Pelanggan</div>
                <div id="ddTotalUsers" style="font-size:20px; font-weight:800; color:#1e1b4b; margin-top:2px;">0</div>
              </div>
            </div>
            <div class="col-xs-4" style="padding:0 6px;">
              <div style="background:#fff; border-radius:10px; padding:12px; text-align:center; border:1px solid #bbf7d0; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
                <div style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase; letter-spacing:0.5px;">✅ Sudah Belanja Lagi</div>
                <div id="ddRetainedCount" style="font-size:20px; font-weight:800; color:#15803d; margin-top:2px;">0 (0%)</div>
              </div>
            </div>
            <div class="col-xs-4" style="padding:0 6px;">
              <div style="background:#fff; border-radius:10px; padding:12px; text-align:center; border:1px solid #fed7aa; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
                <div style="font-size:11px; font-weight:700; color:#9a3412; text-transform:uppercase; letter-spacing:0.5px;">⚠️ Belum Belanja Lagi</div>
                <div id="ddChurnedCount" style="font-size:20px; font-weight:800; color:#c2410c; margin-top:2px;">0 (0%)</div>
              </div>
            </div>
          </div>

          <!-- Filter Tabs & Search Bar -->
          <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
            <!-- Tabs -->
            <div class="btn-group" role="group" id="ddTabFilter">
              <button type="button" class="btn btn-sm btn-primary active" data-filter="all" style="font-weight:700; border-radius:8px 0 0 8px;">Semua (<span id="tabCountAll">0</span>)</button>
              <button type="button" class="btn btn-sm btn-default" data-filter="retained" style="font-weight:700;">✅ Sudah Belanja Lagi (<span id="tabCountRetained">0</span>)</button>
              <button type="button" class="btn btn-sm btn-default" data-filter="churned" style="font-weight:700; border-radius:0 8px 8px 0;">⚠️ Belum Belanja Lagi (<span id="tabCountChurned">0</span>)</button>
            </div>

            <!-- Search box -->
            <div style="position:relative; width:240px;">
              <input type="text" id="ddSearchInput" class="form-control input-sm" placeholder="Cari nama / no. telp..." style="border-radius:20px; padding-left:28px; font-size:12px;">
              <i class="fa fa-search" style="position:absolute; left:10px; top:8px; color:#94a3b8; font-size:12px;"></i>
            </div>
          </div>

          <!-- Table Container -->
          <div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; overflow:hidden; max-height:420px; overflow-y:auto;">
            <table class="table table-hover table-striped" style="margin-bottom:0;" id="ddCustomerTable">
              <thead style="background:#f1f5f9; position:sticky; top:0; z-index:2;">
                <tr>
                  <th style="font-size:11px; text-transform:uppercase; color:#475569; width:45px;">#</th>
                  <th style="font-size:11px; text-transform:uppercase; color:#475569;">Nama Pelanggan</th>
                  <th style="font-size:11px; text-transform:uppercase; color:#475569;">No. Telepon</th>
                  <th style="font-size:11px; text-transform:uppercase; color:#475569; text-align:center;">Status</th>
                  <th style="font-size:11px; text-transform:uppercase; color:#475569; text-align:right;">Belanja Periode Ini</th>
                  <th style="font-size:11px; text-transform:uppercase; color:#475569; text-align:center; width:180px;">Aksi Cepat</th>
                </tr>
              </thead>
              <tbody id="ddCustomerTbody">
                <!-- Rows populated via JS -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="padding:12px 24px; background:#fff; border-top:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
        <button type="button" class="btn btn-success" id="btnExportDrilldown" style="font-weight:700; border-radius:8px; display:inline-flex; align-items:center; gap:6px;">
          <i class="fa fa-file-excel-o"></i> Unduh Data Customer (Excel / CSV)
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal" style="font-weight:700; border-radius:8px;">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  var _BASE = (typeof BASE_URL !== 'undefined') ? BASE_URL : '<?= base_url(); ?>';
  var allCustomerData = [];
  var currentTab = 'all';
  var currentCohort = '';
  var currentTarget = '';
  var currentMode = '';
  var currentProduct = '';

  // Click on any cohort cell
  $(document).on('click', '.cohort-cell-clickable', function() {
    var cohort = $(this).data('cohort');
    var target = $(this).data('target');
    var cohortLabel = $(this).data('cohort-label');
    var targetLabel = $(this).data('target-label');
    var mode = $(this).data('mode');
    var product = $(this).data('product');

    if (!cohort || !target) return;

    currentCohort = cohort;
    currentTarget = target;
    currentMode = mode;
    currentProduct = product;

    $('#modalCohortDrilldownTitle').html('<i class="fa fa-users"></i> Detail Customer Kohort: ' + cohortLabel);
    $('#modalCohortDrilldownSubtitle').text('Performa Repeat Order pada Periode: ' + targetLabel + (product ? ' | Produk: ' + product : ''));
    $('#drilldownLoading').show();
    $('#drilldownContent').hide();
    $('#modalCohortDrilldown').modal('show');
    $('#ddSearchInput').val('');
    currentTab = 'all';
    $('#ddTabFilter button').removeClass('btn-primary active').addClass('btn-default');
    $('#ddTabFilter button[data-filter="all"]').addClass('btn-primary active').removeClass('btn-default');

    $.ajax({
      url: _BASE + 'administrator/rfm/cohort_drilldown_ajax',
      type: 'GET',
      data: {
        cohort: cohort,
        target: target,
        mode: mode,
        product: product,
        kategori: '<?= htmlspecialchars($c_category, ENT_QUOTES); ?>'
      },
      dataType: 'json',
      success: function(res) {
        $('#drilldownLoading').hide();
        if (res.success && res.data) {
          var d = res.data;
          $('#ddTotalUsers').text(d.total_cohort + ' Orang');
          $('#ddRetainedCount').text(d.retained_count + ' (' + d.retention_pct + '%)');
          var churnCount = d.churned_count;
          var churnPct = d.total_cohort > 0 ? (100 - d.retention_pct).toFixed(1) : 0;
          $('#ddChurnedCount').text(churnCount + ' (' + churnPct + '%)');

          $('#tabCountAll').text(d.total_cohort);
          $('#tabCountRetained').text(d.retained_count);
          $('#tabCountChurned').text(d.churned_count);

          // Combine both for client-side filtering
          allCustomerData = [].concat(d.retained_customers || [], d.churned_customers || []);
          renderCustomerTable();
          $('#drilldownContent').fadeIn(200);
        } else {
          $('#drilldownContent').html('<div class="alert alert-warning">' + (res.message || 'Gagal memuat data customer') + '</div>').show();
        }
      },
      error: function() {
        $('#drilldownLoading').hide();
        $('#drilldownContent').html('<div class="alert alert-danger">Gagal menghubungi server. Silakan coba kembali.</div>').show();
      }
    });
  });

  // Tab switching
  $('#ddTabFilter button').on('click', function() {
    $('#ddTabFilter button').removeClass('btn-primary active').addClass('btn-default');
    $(this).addClass('btn-primary active').removeClass('btn-default');
    currentTab = $(this).data('filter');
    renderCustomerTable();
  });

  // Search input live filter
  $('#ddSearchInput').on('keyup', function() {
    renderCustomerTable();
  });

  function renderCustomerTable() {
    var search = $('#ddSearchInput').val().toLowerCase().trim();
    var tbody = $('#ddCustomerTbody');
    tbody.empty();

    var filtered = allCustomerData.filter(function(c) {
      if (currentTab === 'retained' && !c.is_retained) return false;
      if (currentTab === 'churned' && c.is_retained) return false;
      if (search) {
        var matchName = (c.nama || '').toLowerCase().indexOf(search) !== -1;
        var matchPhone = (c.phone || '').indexOf(search) !== -1;
        if (!matchName && !matchPhone) return false;
      }
      return true;
    });

    if (filtered.length === 0) {
      tbody.html('<tr><td colspan="6" class="text-center" style="padding:30px; color:#94a3b8;"><i class="fa fa-info-circle fa-2x"></i><br>Tidak ditemukan customer yang sesuai filter.</td></tr>');
      return;
    }

    var html = '';
    $.each(filtered, function(idx, item) {
      var statusBadge = item.is_retained 
        ? '<span class="label" style="background:#dcfce7; color:#15803d; font-size:11px; padding:3px 8px; border-radius:6px; font-weight:700;"><i class="fa fa-check"></i> Sudah Belanja Lagi</span>'
        : '<span class="label" style="background:#ffedd5; color:#c2410c; font-size:11px; padding:3px 8px; border-radius:6px; font-weight:700;"><i class="fa fa-clock-o"></i> Belum Belanja Lagi</span>';

      var spendText = item.is_retained 
        ? '<strong style="color:#059669; font-size:12.5px;">' + (item.spend_formatted || 'Rp 0') + '</strong><br><small style="color:#64748b;">(' + item.orders + 'x order)</small>'
        : '<span style="color:#94a3b8; font-size:12px;">Rp 0</span>';

      html += '<tr>' +
        '<td style="font-size:12px; vertical-align:middle; color:#64748b;">' + (idx + 1) + '</td>' +
        '<td style="vertical-align:middle;"><strong style="font-size:13px; color:#1e293b;">' + escapeHtml(item.nama) + '</strong></td>' +
        '<td style="vertical-align:middle;"><code style="font-size:12px; background:#f1f5f9; color:#475569; padding:2px 6px; border-radius:4px;">' + escapeHtml(item.phone) + '</code></td>' +
        '<td style="text-align:center; vertical-align:middle;">' + statusBadge + '</td>' +
        '<td style="text-align:right; vertical-align:middle;">' + spendText + '</td>' +
        '<td style="text-align:center; vertical-align:middle;">' +
          '<div style="display:flex; justify-content:center; gap:6px;">' +
            '<a href="' + item.wa_link + '" target="_blank" class="btn btn-xs btn-success" style="background:#25d366; border:none; border-radius:6px; font-weight:700; padding:4px 8px;" title="Chat WhatsApp">' +
              '<i class="fa fa-whatsapp"></i> Chat WA' +
            '</a>' +
            '<a href="' + item.crm_link + '" target="_blank" class="btn btn-xs" style="background:#6366f1; color:#fff; border:none; border-radius:6px; font-weight:700; padding:4px 8px;" title="Lihat Profil CRM">' +
              '<i class="fa fa-user"></i> Profil CRM' +
            '</a>' +
          '</div>' +
        '</td>' +
      '</tr>';
    });

    tbody.html(html);
  }

  function escapeHtml(text) {
    if (!text) return '';
    return $('<div>').text(text).html();
  }

  // Export Drilldown Button Click
  $('#btnExportDrilldown').on('click', function() {
    if (!currentCohort || !currentTarget) return;
    var url = _BASE + 'administrator/rfm/export_cohort_drilldown?' + $.param({
      cohort: currentCohort,
      target: currentTarget,
      mode: currentMode,
      product: currentProduct,
      kategori: '<?= htmlspecialchars($c_category, ENT_QUOTES); ?>',
      filter: currentTab
    });
    window.location.href = url;
  });

  // Initialize Retention Decay Chart
  var decayCanvas = document.getElementById('retentionDecayChart');
  if (decayCanvas && typeof Chart !== 'undefined') {
    var decayCtx = decayCanvas.getContext('2d');
    window.decayChartInstance = new Chart(decayCtx, {
      type: 'line',
      data: {
        labels: <?= json_encode($chart_decay_labels); ?>,
        datasets: <?= json_encode($chart_decay_datasets); ?>
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          mode: 'index',
          intersect: false,
        },
        plugins: {
          legend: {
            position: 'top',
            labels: {
              usePointStyle: true,
              boxWidth: 8,
              font: { size: 11.5, weight: '600' },
              color: '#334155',
              padding: 12
            }
          },
          tooltip: {
            backgroundColor: 'rgba(15, 23, 42, 0.92)',
            padding: 12,
            cornerRadius: 8,
            titleFont: { size: 12, weight: '700' },
            bodyFont: { size: 11 },
            callbacks: {
              label: function(context) {
                var val = context.parsed.y;
                if (val === null || isNaN(val)) return null;
                return ' ' + context.dataset.label + ': ' + val + '% pelanggan kembali belanja';
              }
            }
          }
        },
        scales: {
          y: {
            min: 0,
            max: 100,
            ticks: {
              stepSize: 20,
              callback: function(value) { return value + '%'; },
              font: { size: 11, weight: '600' },
              color: '#64748b'
            },
            grid: {
              color: '#f1f5f9',
              drawBorder: false
            }
          },
          x: {
            ticks: {
              font: { size: 11, weight: '600' },
              color: '#64748b'
            },
            grid: {
              display: false,
              drawBorder: false
            }
          }
        }
      }
    });

    $('#btnToggleAllCurves').on('click', function() {
      if (!window.decayChartInstance) return;
      window.decayChartInstance.data.datasets.forEach(function(ds) {
        ds.hidden = false;
      });
      window.decayChartInstance.update();
      $('#btnToggleAllCurves').addClass('active');
      $('#btnOnlyAvgCurve').removeClass('active');
    });

    $('#btnOnlyAvgCurve').on('click', function() {
      if (!window.decayChartInstance) return;
      window.decayChartInstance.data.datasets.forEach(function(ds, idx) {
        ds.hidden = (idx !== 0);
      });
      window.decayChartInstance.update();
      $('#btnOnlyAvgCurve').addClass('active');
      $('#btnToggleAllCurves').removeClass('active');
    });
  }
});
</script>

<!-- MODAL IMPORT EXCEL DATA -->
<div class="modal fade" id="modal-import-excel" tabindex="-1" role="dialog" aria-labelledby="modalImportExcelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:560px; margin:40px auto;">
    <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.15); overflow:hidden;">
      <form method="POST" action="<?= site_url('administrator/rfm/import_excel'); ?>" enctype="multipart/form-data" id="form-import-excel" onsubmit="var b=document.getElementById('btn-submit-import-cohort'); if(b){b.disabled=true; b.innerHTML='<i class=\'fa fa-spinner fa-spin\'></i> Mengimport Data...';}">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header" style="background:linear-gradient(135deg, #1e1b4b, #312e81, #4338ca); color:#fff; padding:18px 24px; border:none; position:relative;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.8; font-size:24px; position:absolute; right:20px; top:18px;">&times;</button>
          <h4 class="modal-title" id="modalImportExcelLabel" style="font-weight:700; font-size:17px; margin:0; display:flex; align-items:center; gap:10px;">
            <i class="fa fa-file-excel-o" style="color:#34d399; font-size:22px;"></i> Import Data Excel (Besar / Banyak)
          </h4>
          <p style="margin:4px 0 0 32px; font-size:12.5px; opacity:0.85;">Dapat menerima ribuan data transaksi (.xlsx, .xls, .csv) &amp; aturan matriks RFM</p>
        </div>
        <div class="modal-body" style="padding:24px;">
          <div style="background:#eff6ff; border:1px solid #bfdbfe; border-left:4px solid #3b82f6; border-radius:10px; padding:12px 14px; margin-bottom:18px; font-size:12.5px; color:#1e40af;">
            <i class="fa fa-info-circle" style="font-size:15px; margin-right:6px;"></i>
            <strong>Auto-Detect Pintar:</strong> Sistem otomatis mendeteksi apakah file berisi transaksi sales atau 125 aturan matriks RFM.
          </div>
          <div class="form-group" style="margin-bottom:18px;">
            <label style="font-weight:700; color:#1e1b4b; font-size:13px; margin-bottom:6px; display:block;">Pilih File Excel / CSV:</label>
            <div style="border:2px dashed #a5b4fc; background:#faf5ff; border-radius:12px; padding:20px; text-align:center;">
              <i class="fa fa-cloud-upload" style="font-size:36px; color:#6366f1; display:block; margin-bottom:8px;"></i>
              <input type="file" name="file_excel" class="form-control" accept=".xlsx, .xls, .csv" required style="max-width:320px; margin:0 auto; height:auto; padding:6px; font-size:12px; border-radius:8px;">
            </div>
          </div>
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
          <button type="submit" id="btn-submit-import-cohort" class="btn" style="background:linear-gradient(135deg, #4338ca, #6366f1); color:#fff; border-radius:8px; font-weight:700; padding:8px 22px;"><i class="fa fa-upload"></i> Mulai Import Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

