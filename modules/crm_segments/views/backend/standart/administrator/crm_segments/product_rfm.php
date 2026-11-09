<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$m_data = $matrix_data;
$months = $m_data['months'] ?? [];
$matrix = $m_data['matrix'] ?? [];
$totals_row = $m_data['totals_row'] ?? ['counts' => [], 'grand_total' => 0];
$mom_row = $m_data['mom_row'] ?? ['growth' => [], 'net_growth' => 0];
$max_val = max(1, $m_data['max_cell_val'] ?? 1);
$sel_prod = isset($selected_product) ? $selected_product : '';
$sel_year = $selected_year ?? '2026';
$sel_period = $selected_period ?? '';
$sel_cat = $selected_category ?? '';
$sel_mode = $selected_mode ?? 'cumulative';
$is_cumulative = ($sel_mode === 'cumulative');
$prod_display_title = !empty($sel_prod) ? $sel_prod : (!empty($sel_cat) ? 'Semua Produk Kategori: ' . $sel_cat : 'Semua Produk (Keseluruhan)');

// Build navigation query string
$nav_params = array_filter([
  'product'  => $sel_prod,
  'year'     => $sel_year,
  'period'   => $sel_period,
  'kategori' => $sel_cat,
  'mode'     => $sel_mode,
]);
$nav_qs = !empty($nav_params) ? '?' . http_build_query($nav_params) : '';

// Customer list query string (excludes period so it never opens an empty month)
$nav_cust_params = array_filter([
  'product'  => $sel_prod,
  'kategori' => $sel_cat,
]);
$nav_cust_qs = !empty($nav_cust_params) ? '?' . http_build_query($nav_cust_params) : '';
?>

<style>
:root {
  --rfm-primary: #6366f1;
  --rfm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
}

.rfm-product-wrapper {
  padding: 0 0 25px 0;
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
  gap: 6px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  border: none;
}
.rfm-header-nav .action-tools .btn:hover { transform: translateY(-2px); }

/* Navigation Tab Bar */
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
  scrollbar-width: none;
}
.rfm-header-nav .nav-tabs-bar::-webkit-scrollbar { display: none; }
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

/* Filter Card */
.section-card-custom {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid #e2e8f0;
  box-shadow: var(--card-shadow);
  padding: 20px;
  margin-bottom: 20px;
}

/* KPI Cards */
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

/* Matrix Table Styling */
.table-matrix-rfm {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  font-size: 12.5px;
}
.table-matrix-rfm th {
  background: #f8fafc;
  color: #334155;
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 12px 10px;
  border-bottom: 2px solid #e2e8f0;
  text-align: center;
  white-space: nowrap;
}
.table-matrix-rfm th:first-child {
  text-align: left;
  padding-left: 18px;
  position: sticky;
  left: 0;
  z-index: 3;
  background: #f8fafc;
  min-width: 190px;
}
.table-matrix-rfm td {
  padding: 8px 6px;
  text-align: center;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
}
.table-matrix-rfm td:first-child {
  text-align: left;
  padding-left: 18px;
  font-weight: 700;
  color: #1e293b;
  position: sticky;
  left: 0;
  z-index: 2;
  background: #ffffff;
  border-right: 1.5px solid #e2e8f0;
}
.table-matrix-rfm tr:hover td:first-child {
  background: #f8fafc;
}

/* Interactive Cell */
.matrix-cell-interactive {
  cursor: pointer;
  border-radius: 8px;
  padding: 6px 4px;
  transition: all 0.15s ease;
  user-select: none;
}
.matrix-cell-interactive:hover {
  filter: brightness(0.94);
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(99,102,241,0.25);
  z-index: 4;
  position: relative;
}
.matrix-cell-interactive.active-selected {
  outline: 2px solid #2563eb !important;
  box-shadow: 0 0 0 4px rgba(37,99,235,0.2) !important;
  background-color: #dbeafe !important;
}

.cell-count-num {
  font-size: 13.5px;
  font-weight: 800;
  line-height: 1.2;
}
.cell-mom-badge {
  font-size: 10px;
  font-weight: 700;
  line-height: 1;
  margin-top: 3px;
  display: block;
}
.cell-mom-up { color: #15803d; }
.cell-mom-down { color: #b91c1c; }
.cell-mom-zero { color: #64748b; }
.cell-mom-none { color: #94a3b8; }

/* Bottom summary rows */
.row-total-produk td {
  background: #f8fafc !important;
  font-weight: 800;
  font-size: 13px;
  border-top: 2px solid #cbd5e1;
}
.row-total-produk td:first-child {
  background: #f1f5f9 !important;
  color: #0f172a;
}
.row-mom-growth td {
  background: #ffffff !important;
  font-weight: 700;
  font-size: 11.5px;
  border-bottom: 2px solid #cbd5e1;
}
.row-mom-growth td:first-child {
  background: #f8fafc !important;
  color: #334155;
}

/* Highlighted selected month column */
.col-period-highlight {
  background: rgba(99, 102, 241, 0.08) !important;
  border-left: 2px solid #6366f1 !important;
  border-right: 2px solid #6366f1 !important;
}

/* Animations */
@keyframes rfmFadeInUp {
  from { opacity: 0; transform: translateY(14px); }
  to { opacity: 1; transform: translateY(0); }
}
.rfm-header-nav, .kpi-mini-card, .section-card-custom {
  animation: rfmFadeInUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Mobile Responsiveness Enhancements */
@media (max-width: 768px) {
  .rfm-product-wrapper {
    padding: 0 0 15px 0 !important;
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
  .kpi-mini-card {
    padding: 12px 14px !important;
  }
  .kpi-mini-val {
    font-size: 17px !important;
  }
  .section-card-custom {
    padding: 14px 12px !important;
    border-radius: 12px !important;
  }
  .table-responsive {
    border: none !important;
    margin-bottom: 0 !important;
    -webkit-overflow-scrolling: touch !important;
  }
  .table-matrix-rfm th:first-child,
  .table-matrix-rfm td:first-child {
    min-width: 135px !important;
    max-width: 140px !important;
    padding-left: 8px !important;
    font-size: 11.5px !important;
  }
  .table-matrix-rfm th, .table-matrix-rfm td {
    padding: 6px 4px !important;
  }
  .cell-count-num {
    font-size: 12px !important;
  }
  .cell-mom-badge {
    font-size: 9px !important;
  }
}
</style>

<div class="rfm-product-wrapper">

  <!-- ==========================================
       LAYER 1: HEADER & LOCATION NAVIGATION
       ========================================== -->
  <div class="rfm-header-nav">
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> Analisis RFM <i class="fa fa-angle-right"></i> <span>Tren Segmen Produk</span>
        </div>
        <h2><i class="fa fa-th-large" style="color:#818cf8;"></i> Analisis Tren Segmen RFM per Produk & Bulan</h2>
        <p>Matriks pergerakan dan dinamika pelanggan di tiap segmen RFM dari bulan ke bulan secara realtime dari database untuk: <strong><?= htmlspecialchars($prod_display_title); ?></strong></p>
      </div>

      <div class="action-tools">
        <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn" style="background:#25D366; color:#fff;" title="Broadcast WA"><i class="fa fa-bullhorn"></i> Broadcast WA</a>
        <button type="button" class="btn" data-toggle="modal" data-target="#modal-import-excel" style="background:#10b981; color:#fff; box-shadow:0 4px 12px rgba(16,185,129,0.35);"><i class="fa fa-file-excel-o"></i> Import Excel Data</button>
        <a href="<?= site_url('administrator/crm_segments/export_csv?product=' . urlencode($sel_prod) . '&year=' . urlencode($sel_year) . '&period=' . urlencode($sel_period) . '&kategori=' . urlencode($sel_cat) . '&mode=' . urlencode($sel_mode)); ?>" class="btn" style="background:rgba(255,255,255,0.18); color:#fff; border:1px solid rgba(255,255,255,0.3);" title="Export Matrix ke CSV / Excel">
          <i class="fa fa-download"></i> Export CSV
        </a>
      </div>
    </div>

    <!-- Navigation Tabs Bar -->
    <div class="nav-tabs-bar">
      <a href="<?= site_url('administrator/rfm/dashboard' . $nav_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-tachometer"></i> 1. Dashboard RFM
      </a>
      <a href="<?= site_url('administrator/rfm' . $nav_cust_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-users"></i> 2. Daftar Customer
      </a>
      <a href="<?= site_url('administrator/rfm/tracking'); ?>" class="nav-tab-btn">
        <i class="fa fa-line-chart"></i> 3. Tracking RFM
      </a>
      <a href="<?= site_url('administrator/rfm/cohort' . $nav_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-th"></i> 4. Analisis Kohort
      </a>
      <a href="<?= site_url('administrator/crm_segments/product_rfm' . $nav_qs); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-th-large"></i> 5. Tren Segmen Produk
      </a>
      <a href="<?= site_url('administrator/rfm/matrix_rules' . $nav_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-table"></i> 6. Matriks Aturan RFM
      </a>
    </div>
  </div>

  <!-- ==========================================
       LAYER 2: FILTER CONTROL BAR (REALTIME DB)
       ========================================== -->
  <div class="section-card-custom" style="padding:16px 22px; margin-bottom:20px;">
    <form method="GET" action="<?= site_url('administrator/crm_segments/product_rfm'); ?>" id="form-product-rfm-filter">
      <div class="row" style="display:flex; align-items:center; flex-wrap:wrap; margin:0 -8px;">
        
        <!-- Filter Kategori -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-folder-open-o" style="color:#0284c7;"></i> Filter Kategori:
          </label>
          <select name="kategori" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12.5px; font-weight:600;" onchange="document.getElementById('select-product').value=''; this.form.submit();">
            <option value="">-- Semua Kategori --</option>
            <?php if (!empty($categories_list)): ?>
              <?php foreach ($categories_list as $cat): 
                $c_name = is_object($cat) ? $cat->nama_kategori : (is_array($cat) ? ($cat['nama_kategori'] ?? '') : (string)$cat);
                if (empty($c_name)) continue;
              ?>
              <option value="<?= htmlspecialchars($c_name); ?>" <?= (!empty($sel_cat) && $sel_cat === $c_name) ? 'selected' : ''; ?>>
                <?= (stripos($c_name, 'Resi') !== false ? '📦 ' : '📁 ') . htmlspecialchars($c_name); ?>
              </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <!-- Filter Produk (dengan optgroup kategori) -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-shopping-bag" style="color:#059669;"></i> Filter Produk:
          </label>
          <select name="product" id="select-product" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12.5px; font-weight:600;" onchange="this.form.submit();">
            <option value="" <?= empty($sel_prod) ? 'selected' : ''; ?>>-- Semua Produk (Keseluruhan) --</option>
            <?php 
            $grouped_prods = [];
            foreach ($products_list as $p_item) {
              $p_name = is_object($p_item) ? $p_item->nama_produk : $p_item;
              $p_code = is_object($p_item) ? $p_item->kode_produk : '';
              $p_cat  = is_object($p_item) ? ($p_item->nama_kategori ?? 'Lainnya') : 'Lainnya';
              if (empty($p_cat)) $p_cat = 'Tanpa Kategori';
              if (empty($p_name)) continue;
              $grouped_prods[$p_cat][] = ['name' => $p_name, 'code' => $p_code, 'item' => $p_item];
            }
            ksort($grouped_prods);
            ?>
            <?php foreach ($grouped_prods as $kat => $prods): ?>
              <optgroup label="📂 <?= htmlspecialchars($kat); ?>">
                <?php foreach ($prods as $p_info): 
                  $p_name = $p_info['name'];
                  $p_code = $p_info['code'];
                  $p_item = $p_info['item'];
                  $is_sel = (!empty($sel_prod) && ($p_name === $sel_prod || (is_object($p_item) && isset($selected_product_id) && !empty($selected_product_id) && $p_item->id == $selected_product_id)));
                ?>
                <option value="<?= htmlspecialchars($p_name); ?>" <?= $is_sel ? 'selected' : ''; ?>>
                  <?= !empty($p_code) ? '[' . htmlspecialchars($p_code) . '] ' : ''; ?><?= htmlspecialchars($p_name); ?>
                </option>
                <?php endforeach; ?>
              </optgroup>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Filter Tahun -->
        <div class="col-md-2 col-sm-4 col-xs-6" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-calendar-o" style="color:#8b5cf6;"></i> Filter Tahun:
          </label>
          <select name="year" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12.5px; font-weight:600;" onchange="this.form.submit();">
            <option value="all" <?= ($sel_year === 'all') ? 'selected' : ''; ?>>-- Semua Tahun --</option>
            <?php if (!empty($available_years)): ?>
              <?php foreach ($available_years as $yr): ?>
              <option value="<?= $yr->yr; ?>" <?= ($sel_year == $yr->yr) ? 'selected' : ''; ?>>
                <?= $yr->yr; ?>
              </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <!-- Filter Bulan / Periode -->
        <div class="col-md-2 col-sm-4 col-xs-6" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-calendar" style="color:#6366f1;"></i> Filter Bulan:
          </label>
          <select name="period" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12.5px; font-weight:600;" onchange="this.form.submit();">
            <option value="">-- Semua Bulan --</option>
            <?php if (!empty($available_months)): ?>
              <?php foreach ($available_months as $m): 
                $m_val = is_object($m) ? $m->ym_val : ($m['ym_val'] ?? '');
                $m_lbl = is_object($m) ? $m->ym_label : ($m['ym_label'] ?? '');
              ?>
              <option value="<?= htmlspecialchars($m_val); ?>" <?= (!empty($sel_period) && $sel_period === $m_val) ? 'selected' : ''; ?>>
                📅 <?= htmlspecialchars($m_lbl); ?>
              </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <!-- Action Buttons -->
        <input type="hidden" name="mode" value="<?= htmlspecialchars($sel_mode); ?>">
        <div class="col-md-2 col-sm-4 col-xs-12" style="padding:0 8px; margin-bottom:8px; display:flex; gap:6px; align-items:flex-end;">
          <button type="submit" class="btn btn-primary" style="background:#6366f1; border:none; border-radius:8px; font-weight:700; height:38px; flex:1; margin-top:21px; display:inline-flex; align-items:center; justify-content:center; gap:6px; box-shadow:0 2px 6px rgba(99,102,241,0.3);">
            <i class="fa fa-filter"></i> Terapkan
          </button>
          <?php if (!empty($sel_cat) || (!empty($sel_year) && $sel_year !== '2026') || !empty($sel_period)): ?>
          <a href="<?= site_url('administrator/crm_segments/product_rfm?product=' . urlencode($sel_prod) . '&mode=' . urlencode($sel_mode)); ?>" class="btn btn-default" style="border-radius:8px; font-weight:600; height:38px; margin-top:21px; border:1px solid #cbd5e1; color:#64748b; display:inline-flex; align-items:center; justify-content:center;" title="Reset Filter">
            <i class="fa fa-refresh"></i> Reset
          </a>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </div>

  <!-- ==========================================
       LAYER 3: 4 MINI KPI INSIGHT CARDS
       ========================================== -->
  <?php
    $has_period = !empty($sel_period) && isset($m_data['period_active_customers']) && $m_data['period_active_customers'] !== null;
    $period_lbl = $has_period ? ($months[$sel_period] ?? $sel_period) : '';
    
    // Find prev period label for MoM comparison
    $prev_period_lbl = '';
    if ($has_period) {
      $m_keys = array_keys($months);
      $pos = array_search($sel_period, $m_keys);
      if ($pos !== false && $pos > 0) {
        $prev_period_lbl = $months[$m_keys[$pos - 1]] ?? $m_keys[$pos - 1];
      }
    }

    $kpi_active_cust = $has_period ? $m_data['period_active_customers'] : $m_data['active_customers_count'];
    $kpi_active_lbl = $has_period ? "Pelanggan Aktif ({$period_lbl})" : ($is_cumulative ? "Total Basis Pelanggan" : "Pelanggan Unik Aktif");
    
    $kpi_omset = $has_period ? $m_data['period_omset'] : $m_data['accumulated_omset'];
    $kpi_omset_lbl = $has_period ? "Omset Penjualan ({$period_lbl})" : "Akumulasi Omset Penjualan";
    
    $kpi_growth = $has_period ? ($m_data['period_mom_growth'] ?? 0) : ($m_data['net_growth_pct'] ?? 0);
    $kpi_growth_lbl = $has_period ? (!empty($prev_period_lbl) ? "Pertumbuhan MoM (vs {$prev_period_lbl})" : "Pertumbuhan MoM") : ($is_cumulative ? "Pertumbuhan Basis (Net)" : "Laju Pertumbuhan Net");

    $kpi_top_seg = $has_period ? ($m_data['period_top_segment_name'] ?? '-') : ($m_data['top_segment_name'] ?? '-');
    $kpi_top_cnt = $has_period ? ($m_data['period_top_segment_count'] ?? 0) : ($m_data['top_segment_count'] ?? 0);
    $kpi_top_lbl = $has_period ? "Segmen Dominan ({$period_lbl})" : "Segmen Dominan";
  ?>
  <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:12px; margin-bottom:20px;">
    <!-- KPI 1: Pelanggan Aktif -->
    <div>
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm' . ($kpi_active_cust > 0 ? $nav_qs : $nav_cust_qs)); ?>';" title="Klik untuk membuka dan melihat daftar pelanggan di Daftar Customer RFM" style="border-left:4px solid #10b981;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#15803d;">
              <?= number_format($kpi_active_cust); ?> Orang
            </div>
            <div class="kpi-mini-lbl" style="color:#166534;"><?= $kpi_active_lbl; ?> &rarr;</div>
            <?php if ($has_period): ?>
              <div style="font-size:10.5px; color:#64748b; margin-top:2px;">Akumulasi: <?= number_format($m_data['active_customers_count']); ?> Pelanggan</div>
            <?php endif; ?>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#dcfce7; color:#166534; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-users"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- KPI 2: Akumulasi / Periode Omset -->
    <div>
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm/tracking'); ?>';" title="Klik untuk melihat analisis tracking omset penjualan di Tracking RFM" style="border-left:4px solid #0284c7;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#0369a1;">
              Rp <?= number_format($kpi_omset, 0, ',', '.'); ?>
            </div>
            <div class="kpi-mini-lbl" style="color:#075985;"><?= $kpi_omset_lbl; ?> &rarr;</div>
            <?php if ($has_period): ?>
              <div style="font-size:10.5px; color:#64748b; margin-top:2px;">Akumulasi: Rp <?= number_format($m_data['accumulated_omset'], 0, ',', '.'); ?></div>
            <?php endif; ?>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#e0f2fe; color:#0369a1; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-money"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- KPI 3: Net Pertumbuhan MoM -->
    <div>
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="var el=document.getElementById('section-product-matrix'); if(el){ el.scrollIntoView({behavior:'smooth'}); }" title="Klik untuk menuju ke tabel matriks distribusi produk per bulan" style="border-left:4px solid <?= $kpi_growth >= 0 ? '#16a34a' : '#ef4444'; ?>;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:<?= $kpi_growth >= 0 ? '#15803d' : '#b91c1c'; ?>;">
              <?= ($kpi_growth >= 0 ? '+' : '') . $kpi_growth; ?>%
            </div>
            <div class="kpi-mini-lbl" style="color:#475569;"><?= $kpi_growth_lbl; ?> &darr;</div>
            <?php if ($has_period): ?>
              <div style="font-size:10.5px; color:#64748b; margin-top:2px;">Net Sepanjang Tahun: <?= ($m_data['net_growth_pct'] >= 0 ? '+' : '') . $m_data['net_growth_pct']; ?>%</div>
            <?php endif; ?>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:<?= $kpi_growth >= 0 ? '#dcfce7' : '#fee2e2'; ?>; color:<?= $kpi_growth >= 0 ? '#15803d' : '#b91c1c'; ?>; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-arrow-<?= $kpi_growth >= 0 ? 'up' : 'down'; ?>"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- KPI 4: Segmen Dominan -->
    <div>
      <div class="kpi-mini-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm?rfm_segment=' . urlencode($kpi_top_seg) . (!empty($sel_prod) ? '&product=' . urlencode($sel_prod) : '') . (!empty($sel_cat) ? '&kategori=' . urlencode($sel_cat) : '') . (!empty($sel_period) ? '&period=' . urlencode($sel_period) : '')); ?>';" title="Klik untuk memfilter pelanggan pada segmen <?= htmlspecialchars($kpi_top_seg); ?>" style="border-left:4px solid #f59e0b;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#b45309; font-size:16px;">
              <?= htmlspecialchars($kpi_top_seg); ?>
            </div>
            <div class="kpi-mini-lbl" style="color:#92400e;">
              <?= $kpi_top_lbl; ?> (<?= number_format($kpi_top_cnt); ?> Pelanggan) &rarr;
            </div>
            <?php if ($has_period): ?>
              <div style="font-size:10.5px; color:#64748b; margin-top:2px;">Dominan Tahun Ini: <?= htmlspecialchars($m_data['top_segment_name'] ?? '-'); ?></div>
            <?php endif; ?>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#fef3c7; color:#b45309; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
            <i class="fa fa-trophy"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ==========================================
       LAYER 4: MAIN INTERACTIVE MATRIX CARD
       ========================================== -->
  <div class="section-card-custom" id="section-product-matrix" style="padding:0; overflow:hidden;">
    
    <!-- Table Header Info Bar -->
    <div style="padding:16px 22px; background:#f8fafc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
      <div>
        <h4 style="margin:0; font-weight:800; font-size:15px; color:#0f172a; display:flex; align-items:center; gap:8px;">
          <i class="fa fa-th" style="color:#6366f1;"></i> Matriks Distribusi Segmen per Bulan
          <span class="badge" style="background:<?= $is_cumulative ? '#dbeafe' : '#fef3c7'; ?>; color:<?= $is_cumulative ? '#1e40af' : '#92400e'; ?>; font-size:11px; font-weight:800; padding:4px 8px; border-radius:6px; border:1px solid <?= $is_cumulative ? '#bfdbfe' : '#fde68a'; ?>;">
            <i class="fa <?= $is_cumulative ? 'fa-line-chart' : 'fa-calendar-check-o'; ?>"></i> <?= $is_cumulative ? 'Mode Kumulatif (Basis Pelanggan)' : 'Mode Bulanan (Aktivitas Transaksi)'; ?>
          </span>
        </h4>
        <div style="font-size:12px; color:#64748b; margin-top:3px;">
          <?= $is_cumulative ? 'Menghitung seluruh basis pelanggan kumulatif yang tercatat hingga bulan bersangkutan dan memetakan dinamika transisi segmen RFM-nya.' : 'Menghitung pelanggan yang aktif melakukan transaksi pada masing-masing bulan saja.'; ?> Klik kotak angka untuk membuka detail nama pelanggan.
        </div>
      </div>
      <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
        <!-- Toggle Mode Switch: Kumulatif vs Per Bulan -->
        <?php
          $url_cum = site_url('administrator/crm_segments/product_rfm?' . http_build_query(array_merge($_GET, ['mode' => 'cumulative'])));
          $url_mon = site_url('administrator/crm_segments/product_rfm?' . http_build_query(array_merge($_GET, ['mode' => 'monthly'])));
        ?>
        <div class="btn-group" role="group" aria-label="Mode Distribusi RFM" style="box-shadow:0 1px 3px rgba(0,0,0,0.08); border-radius:8px;">
          <a href="<?= $url_cum; ?>" 
             class="btn btn-sm <?= $is_cumulative ? 'btn-primary' : 'btn-default'; ?>"
             style="<?= $is_cumulative ? 'background:#4338ca; border-color:#4338ca; color:#fff; font-weight:700;' : 'background:#fff; color:#475569; font-weight:600;'; ?> border-radius:8px 0 0 8px; padding:6px 14px; font-size:12px;"
             title="Mode Kumulatif: Menampilkan seluruh basis pelanggan terakumulasi hingga bulan tersebut">
            <i class="fa fa-line-chart"></i> Kumulatif
          </a>
          <a href="<?= $url_mon; ?>" 
             class="btn btn-sm <?= !$is_cumulative ? 'btn-primary' : 'btn-default'; ?>"
             style="<?= !$is_cumulative ? 'background:#4338ca; border-color:#4338ca; color:#fff; font-weight:700;' : 'background:#fff; color:#475569; font-weight:600;'; ?> border-radius:0 8px 8px 0; padding:6px 14px; font-size:12px;"
             title="Mode Bulanan: Hanya menampilkan pelanggan yang belanja di bulan tersebut">
            <i class="fa fa-calendar-check-o"></i> Per Bulan
          </a>
        </div>

        <span class="badge" style="background:#e0e7ff; color:#3730a3; font-weight:700; padding:7px 12px; border-radius:8px;">
          <i class="fa fa-calendar"></i> Total <?= count($months); ?> Bulan Ditampilkan
        </span>
      </div>
    </div>

    <!-- Matrix Table -->
    <div class="table-responsive" style="overflow-x:auto;">
      <table class="table-matrix-rfm">
        <thead>
          <tr>
            <th><i class="fa fa-tag" style="margin-right:4px;"></i> SEGMEN RFM</th>
            <?php foreach ($months as $ym => $label): 
              $is_col_sel = (!empty($sel_period) && $sel_period === $ym);
            ?>
              <th class="<?= $is_col_sel ? 'col-period-highlight' : ''; ?>" style="<?= $is_col_sel ? 'color:#4338ca; font-weight:800;' : ''; ?>">
                <?= $label; ?>
                <?php if ($is_col_sel): ?>
                  <span style="display:block; font-size:9px; color:#6366f1; text-transform:none;">(Dipilih)</span>
                <?php endif; ?>
              </th>
            <?php endforeach; ?>
            <th style="background:#f1f5f9; color:#0f172a; min-width:130px;">
              <i class="fa fa-users"></i> <?= $is_cumulative ? 'TOTAL PELANGGAN (KUMULATIF)' : 'TOTAL PELANGGAN'; ?>
            </th>
            <th style="background:#f1f5f9; color:#0f172a; min-width:90px;">
              <i class="fa fa-line-chart"></i> TREN
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($matrix as $seg_name => $row): ?>
          <tr>
            <!-- Segment Label -->
            <td>
              <span style="margin-right:6px; font-size:14px;"><?= $row['icon']; ?></span>
              <span style="color:#0f172a; font-weight:700;"><?= htmlspecialchars($seg_name); ?></span>
            </td>

            <!-- Monthly Cells -->
            <?php foreach ($months as $ym => $label): 
              $c = $row['counts'][$ym] ?? 0;
              $g = $row['growth'][$ym] ?? null;
              $is_col_sel = (!empty($sel_period) && $sel_period === $ym);
              $show_zero = !empty($row['display_zero'][$ym]);
              $is_drop_cell = ($c == 0 && $show_zero && $g !== null && $g < 0);

              // Density heatmap background
              $bg_style = 'background: #ffffff;';
              if ($c > 0) {
                $intensity = min(0.75, max(0.12, ($c / $max_val) * 0.70));
                $bg_style = 'background: rgba(16, 185, 129, ' . round($intensity, 2) . ');';
              } elseif ($is_drop_cell) {
                $bg_style = 'background: #fef2f2; border: 1px dashed #fca5a5;';
              }
              if ($is_col_sel && $c == 0) {
                $bg_style = 'background: rgba(99, 102, 241, 0.05);';
              }
            ?>
              <td class="<?= $is_col_sel ? 'col-period-highlight' : ''; ?>">
                <div class="matrix-cell-interactive" 
                     style="<?= $bg_style; ?>"
                     data-product="<?= htmlspecialchars($sel_prod); ?>"
                     data-category="<?= htmlspecialchars($sel_cat); ?>"
                     data-segment="<?= htmlspecialchars($seg_name); ?>"
                     data-period="<?= $ym; ?>"
                     data-period-label="<?= $label; ?>"
                     data-count="<?= $c; ?>"
                     onclick="openDrilldownModal(this);">
                  
                  <div class="cell-count-num" style="color: <?= ($c > 0) ? '#0f172a' : ($is_drop_cell ? '#dc2626' : ($show_zero ? '#0f172a' : '#94a3b8')); ?>;">
                    <?= $c > 0 ? $c : ($show_zero ? '0' : '-'); ?>
                  </div>

                  <?php if (($c > 0 || $show_zero) && $g !== null): ?>
                    <?php if ($g > 0): ?>
                      <span class="cell-mom-badge cell-mom-up"><i class="fa fa-caret-up"></i> +<?= $g; ?>%</span>
                    <?php elseif ($g < 0): ?>
                      <span class="cell-mom-badge cell-mom-down" style="color:#dc2626; font-weight:800;"><i class="fa fa-caret-down"></i> <?= $g; ?>%</span>
                    <?php else: ?>
                      <span class="cell-mom-badge cell-mom-zero">0%</span>
                    <?php endif; ?>
                  <?php endif; ?>

                </div>
              </td>
            <?php endforeach; ?>

            <!-- Total Customers per Segment -->
            <td style="background:#f8fafc; font-weight:800; font-size:14px; color:#1e293b;">
              <?= $row['total_cust'] > 0 ? number_format($row['total_cust']) : '-'; ?>
            </td>

            <!-- Net Trend Badge per Segment -->
            <td style="background:#f8fafc;">
              <?php 
                $tp = $row['trend_pct'];
                $tfv = $row['trend_first_val'] ?? 0;
                $tlv = $row['trend_last_val'] ?? 0;
                $tfym = $row['trend_first_ym'] ?? '';
                $tlym = $row['trend_last_ym'] ?? '';
                $lbl_first = $months[$tfym] ?? $tfym;
                $lbl_last = $months[$tlym] ?? $tlym;

                if ($tfym === $tlym && $tlv > 0) {
                    $trend_title = "Segmen baru pada {$lbl_last}: {$tlv} pelanggan (+100%)";
                } elseif ($tfv > 0 && $tlv == 0) {
                    $trend_title = "Penurunan dari {$tfv} ({$lbl_first}) ke 0 ({$lbl_last}): {$tp}%";
                } elseif ($tfv > 0 && $tlv > 0) {
                    $trend_title = "Pertumbuhan dari {$tfv} ({$lbl_first}) ke {$tlv} ({$lbl_last}): " . ($tp >= 0 ? "+{$tp}%" : "{$tp}%");
                } else {
                    $trend_title = "Tidak ada pergerakan segmen pada periode ini";
                }

                $has_any_data = array_sum($row['counts']) > 0;
                if (!$has_any_data): 
              ?>
                <span class="badge" title="<?= $trend_title; ?>" style="background:#e2e8f0; color:#64748b; font-weight:700; font-size:10.5px; padding:4px 8px; border-radius:4px; cursor:help;">
                  — 0%
                </span>
              <?php elseif ($tp > 0): ?>
                <span class="badge" title="<?= $trend_title; ?>" style="background:#16a34a; color:#fff; font-weight:700; font-size:10.5px; padding:4px 8px; border-radius:4px; cursor:help;">
                  <i class="fa fa-arrow-up"></i> +<?= $tp; ?>%
                </span>
              <?php elseif ($tp < 0): ?>
                <span class="badge" title="<?= $trend_title; ?>" style="background:#ef4444; color:#fff; font-weight:700; font-size:10.5px; padding:4px 8px; border-radius:4px; cursor:help;">
                  <i class="fa fa-arrow-down"></i> <?= $tp; ?>%
                </span>
              <?php else: ?>
                <span class="badge" title="<?= $trend_title; ?>" style="background:#e2e8f0; color:#64748b; font-weight:700; font-size:10.5px; padding:4px 8px; border-radius:4px; cursor:help;">
                  — 0%
                </span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>

          <!-- ROW 1: TOTAL PEMBELI AKTIF / BASIS PELANGGAN -->
          <tr class="row-total-produk">
            <td title="<?= $is_cumulative ? 'Total seluruh basis pelanggan unik yang telah tercatat hingga bulan tersebut' : 'Total pelanggan/pembeli unik yang bertransaksi pada bulan ini'; ?>" style="vertical-align:middle;">
              <i class="fa fa-users" style="color:#2563eb; margin-right:6px;"></i>
              <strong><?= $is_cumulative ? 'TOTAL BASIS PELANGGAN KUMULATIF' : 'TOTAL PEMBELI AKTIF'; ?></strong>
            </td>
            <?php foreach ($months as $ym => $label): 
              $t = $totals_row['counts'][$ym] ?? 0;
              $tg = $mom_row['growth'][$ym] ?? null;
              $show_zero_t = !empty($totals_row['display_zero'][$ym]);
              $is_col_sel = (!empty($sel_period) && $sel_period === $ym);
              $is_drop_tot = ($t == 0 && $show_zero_t && $tg !== null && $tg < 0);
            ?>
              <td class="<?= $is_col_sel ? 'col-period-highlight' : ''; ?>" style="color:#2563eb; vertical-align:middle; text-align:center;">
                <?php if ($t > 0 || $show_zero_t): ?>
                  <div class="matrix-cell-interactive" 
                       style="<?= $is_drop_tot ? 'background: #fef2f2; color: #dc2626; border: 1px dashed #fca5a5;' : 'background: #eff6ff; color: #1d4ed8;'; ?> font-weight: 800; padding: 6px 4px;"
                       data-product="<?= htmlspecialchars($sel_prod); ?>"
                       data-category="<?= htmlspecialchars($sel_cat); ?>"
                       data-segment="Total"
                       data-period="<?= $ym; ?>"
                       data-period-label="<?= $label; ?>"
                       data-count="<?= $t; ?>"
                       title="Klik untuk melihat seluruh <?= number_format($t); ?> pelanggan pada <?= $label; ?>"
                       onclick="openDrilldownModal(this);">
                    <div class="cell-count-num" style="color:<?= $is_drop_tot ? '#dc2626' : '#1d4ed8'; ?>; font-size:14px; font-weight:800;"><?= $t > 0 ? number_format($t) : ($show_zero_t ? '0' : '-'); ?></div>
                    <?php if ($tg !== null): ?>
                      <?php if ($tg > 0): ?>
                        <span class="cell-mom-badge cell-mom-up" style="font-size:9.5px; font-weight:800; padding:2px 6px; border-radius:4px; display:inline-block; margin-top:3px;"><i class="fa fa-caret-up"></i> +<?= $tg; ?>%</span>
                      <?php elseif ($tg < 0): ?>
                        <span class="cell-mom-badge cell-mom-down" style="font-size:9.5px; font-weight:800; padding:2px 6px; border-radius:4px; display:inline-block; margin-top:3px; color:#dc2626;"><i class="fa fa-caret-down"></i> <?= $tg; ?>%</span>
                      <?php else: ?>
                        <span class="cell-mom-badge cell-mom-zero" style="font-size:9.5px; font-weight:700; padding:2px 6px; border-radius:4px; display:inline-block; margin-top:3px;">0%</span>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                <?php else: ?>
                  <span style="color:#94a3b8;">-</span>
                <?php endif; ?>
              </td>
            <?php endforeach; ?>
            <td style="color:#2563eb; font-weight:800; font-size:15px; background:#eff6ff; text-align:center; vertical-align:middle;">
              <?= number_format($totals_row['grand_total']); ?>
            </td>
            <td style="background:#eff6ff; text-align:center; vertical-align:middle;">
              <span class="badge" style="background:#2563eb; color:#fff; font-weight:700; font-size:10.5px; padding:4px 8px; border-radius:4px;">
                <?= number_format($m_data['active_customers_count']); ?> Unik
              </span>
            </td>
          </tr>

          <!-- ROW 2: LAJU PERTUMBUHAN (MoM) -->
          <tr class="row-mom-growth" style="background:#f8fafc;">
            <td style="vertical-align:middle;">
              <i class="fa fa-line-chart" style="color:#059669; margin-right:6px;"></i>
              <strong style="color:#0f172a;">PERTUMBUHAN MoM (BULANAN %)</strong>
            </td>
            <?php foreach ($months as $ym => $label): 
              $mg = $mom_row['growth'][$ym] ?? null;
              $is_col_sel = (!empty($sel_period) && $sel_period === $ym);
            ?>
              <td class="<?= $is_col_sel ? 'col-period-highlight' : ''; ?>" style="vertical-align:middle; text-align:center; padding:10px 4px !important;">
                <?php if ($mg === null): ?>
                  <span style="color:#94a3b8;">-</span>
                <?php elseif ($mg > 0): ?>
                  <span style="background:#dcfce7; color:#15803d; font-weight:800; font-size:11px; padding:3px 7px; border-radius:6px; display:inline-flex; align-items:center; gap:3px; border:1px solid #bbf7d0;"><i class="fa fa-caret-up"></i> +<?= $mg; ?>%</span>
                <?php elseif ($mg < 0): ?>
                  <span style="background:#fee2e2; color:#b91c1c; font-weight:800; font-size:11px; padding:3px 7px; border-radius:6px; display:inline-flex; align-items:center; gap:3px; border:1px solid #fecaca;"><i class="fa fa-caret-down"></i> <?= $mg; ?>%</span>
                <?php else: ?>
                  <span style="background:#f1f5f9; color:#475569; font-weight:700; font-size:10.5px; padding:3px 7px; border-radius:6px; display:inline-flex; align-items:center; gap:3px; border:1px solid #e2e8f0;">0%</span>
                <?php endif; ?>
              </td>
            <?php endforeach; ?>
            <td style="background:#f8fafc; font-size:11.5px; font-weight:700; color:#475569; text-align:center; vertical-align:middle;">
              Net Pertumbuhan:
            </td>
            <td style="background:#f8fafc; text-align:center; vertical-align:middle;">
              <span class="badge" style="background:<?= $mom_row['net_growth'] >= 0 ? '#16a34a' : '#ef4444'; ?>; color:#fff; font-size:11px; font-weight:800; padding:5px 9px; border-radius:5px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                <i class="fa fa-arrow-<?= $mom_row['net_growth'] >= 0 ? 'up' : 'down'; ?>"></i> <?= ($mom_row['net_growth'] >= 0 ? '+' : '') . $mom_row['net_growth']; ?>%
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Matrix Footer Legend -->
    <div style="padding:14px 22px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
      <div style="font-size:11.5px; color:#64748b; display:flex; align-items:center; gap:14px; flex-wrap:wrap;">
        <span><strong style="color:#334155;">Intensitas Warna:</strong></span>
        <span><span style="display:inline-block; width:12px; height:12px; background:rgba(16,185,129,0.15); border-radius:3px; vertical-align:middle;"></span> Rendah</span>
        <span><span style="display:inline-block; width:12px; height:12px; background:rgba(16,185,129,0.45); border-radius:3px; vertical-align:middle;"></span> Sedang</span>
        <span><span style="display:inline-block; width:12px; height:12px; background:rgba(16,185,129,0.75); border-radius:3px; vertical-align:middle;"></span> Tinggi</span>
      </div>
      <div style="font-size:11.5px; color:#64748b;">
        <i class="fa fa-info-circle" style="color:#6366f1;"></i> Data otomatis sinkron dan terhitung dari transaksi <strong>Transaksi Penjualan &amp; Marketplace</strong> secara realtime.
      </div>
    </div>
  </div>

</div>

<!-- ==========================================
     MODAL DRILLDOWN CUSTOMER
     ========================================== -->
<div class="modal fade" id="modalSegmentDrilldown" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="max-width:920px; width:92%; margin:40px auto;">
    <div class="modal-content" style="border-radius:14px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.25); overflow:hidden;">
      
      <!-- Modal Header -->
      <div class="modal-header" style="background:linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%); color:#fff; padding:18px 24px; border:none;">
        <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:0.85; font-size:24px; text-shadow:none;">&times;</button>
        <h4 class="modal-title" id="drilldownTitleText" style="font-weight:800; font-size:16.5px; margin:0;">
          Daftar Pelanggan Segmen
        </h4>
        <div id="drilldownSubtitleText" style="font-size:12px; opacity:0.85; margin-top:4px;">
          Memuat data...
        </div>
      </div>

      <!-- Modal Body -->
      <div class="modal-body" style="padding:20px; max-height:480px; overflow-y:auto;">
        
        <!-- Loading Indicator -->
        <div id="drilldownLoading" style="text-align:center; padding:40px 20px;">
          <i class="fa fa-spinner fa-spin fa-2x" style="color:#6366f1;"></i>
          <p style="margin-top:10px; font-weight:600; color:#64748b;">Mengambil data pelanggan dari database...</p>
        </div>

        <!-- Table Container -->
        <div id="drilldownContent" style="display:none;">
          <div class="table-responsive">
            <table class="table table-hover" style="font-size:12.5px; margin-bottom:0;">
              <thead>
                <tr style="background:#f8fafc; color:#334155;">
                  <th style="width:30px;">#</th>
                  <th>NAMA PELANGGAN</th>
                  <th>NO TELEPON / WA</th>
                  <th style="text-align:center;">ORDER</th>
                  <th style="text-align:center;">QTY</th>
                  <th style="text-align:right;">TOTAL BELANJA</th>
                  <th style="text-align:center;">AKSI</th>
                </tr>
              </thead>
              <tbody id="drilldownTableBody">
                <!-- Dynamically populated via AJAX -->
              </tbody>
            </table>
          </div>
        </div>

        <!-- Empty State -->
        <div id="drilldownEmpty" style="display:none; text-align:center; padding:40px 20px; color:#94a3b8;">
          <i class="fa fa-folder-open-o fa-3x" style="margin-bottom:10px;"></i>
          <br>
          <strong style="font-size:14px; color:#475569;">Data Pelanggan Kosong</strong>
          <br>
          <span style="font-size:12px;">Tidak ditemukan data pembelian untuk segmen dan periode bulan ini.</span>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:12px 24px;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:8px; font-weight:700; padding:7px 18px;">
          Tutup
        </button>
      </div>

    </div>
  </div>
</div>

<script>
var currentActiveCell = null;

function openDrilldownModal(el) {
  var $cell = $(el);
  var product = $cell.attr('data-product') || '';
  var category = $cell.attr('data-category') || '';
  var segment = $cell.attr('data-segment');
  var period = $cell.attr('data-period');
  var periodLabel = $cell.attr('data-period-label');
  var count = parseInt($cell.attr('data-count'), 10) || 0;

  if (currentActiveCell) {
    $(currentActiveCell).removeClass('active-selected');
  }
  $cell.addClass('active-selected');
  currentActiveCell = el;

  var prodLabel = product ? product : (category ? 'Semua Produk Kategori: ' + category : 'Semua Produk (Keseluruhan)');
  var modeLabel = '<?= $is_cumulative ? "Basis Kumulatif" : "Aktivitas Bulanan"; ?>';

  var segTitle = (segment === 'Total') ? 'Seluruh Basis Pelanggan' : ('Pelanggan Segmen <strong>' + segment + '</strong>');
  $('#drilldownTitleText').html(segTitle + ' &bull; ' + periodLabel + ' <span class="badge" style="background:#e0e7ff; color:#3730a3; font-size:11px; vertical-align:middle; margin-left:6px;">' + modeLabel + '</span>');
  $('#drilldownSubtitleText').html('Target: <strong>' + prodLabel + '</strong> &bull; Jumlah: ' + count + ' Pelanggan');

  $('#drilldownLoading').show();
  $('#drilldownContent').hide();
  $('#drilldownEmpty').hide();
  $('#drilldownTableBody').empty();

  $('#modalSegmentDrilldown').modal('show');

  $.ajax({
    url: '<?= site_url("administrator/crm_segments/product_rfm_drilldown_ajax"); ?>',
    type: 'GET',
    data: {
      product: product,
      category: category,
      segment: segment,
      period: period,
      mode: '<?= $sel_mode; ?>'
    },
    dataType: 'json',
    success: function(res) {
      $('#drilldownLoading').hide();

      if (res && res.status === 'success' && res.customers && res.customers.length > 0) {
        var html = '';
        res.customers.forEach(function(c, idx) {
          var spendFormatted = 'Rp ' + Number(c.total_spend || 0).toLocaleString('id-ID');
          var cleanPhone = c.clean_phone || c.no_telepon || '';
          var waPhone = cleanPhone.replace(/^0/, '62');
          var waLink = 'https://wa.me/' + waPhone;
          var crmLink = '<?= site_url("administrator/crm/customer_summary"); ?>?phone=' + encodeURIComponent(cleanPhone);
          var segBadge = c.rfm_segment ? '<span class="badge" style="background:#e0e7ff; color:#3730a3; font-size:10px; font-weight:700; margin-left:6px; vertical-align:middle;">' + c.rfm_segment + '</span>' : '';
          
          var qtyNum = parseFloat(c.total_qty);
          if (isNaN(qtyNum) || qtyNum <= 0) qtyNum = 1;
          var qtyFormatted = (qtyNum % 1 === 0) ? qtyNum.toLocaleString('id-ID') : Number(qtyNum.toFixed(2)).toLocaleString('id-ID');

          var custName = (c.customer_name && c.customer_name !== '-' && c.customer_name.trim() !== '') ? c.customer_name : ('Customer ' + (cleanPhone ? cleanPhone.slice(-4) : (idx + 1)));

          html += '<tr>' +
            '<td>' + (idx + 1) + '</td>' +
            '<td><strong style="color:#0f172a;">' + custName + '</strong>' + segBadge + '</td>' +
            '<td><code style="background:#eef2ff; color:#3730a3; padding:2px 6px; border-radius:4px; font-weight:600;">' + (cleanPhone || '-') + '</code></td>' +
            '<td style="text-align:center;"><span class="badge" style="background:#e0e7ff; color:#3730a3; font-weight:700;">' + (c.total_orders || 1) + 'x</span></td>' +
            '<td style="text-align:center; font-weight:600; color:#475569;">' + qtyFormatted + '</td>' +
            '<td style="text-align:right;"><strong style="color:#16a34a;">' + spendFormatted + '</strong></td>' +
            '<td style="text-align:center; white-space:nowrap;">' +
              (cleanPhone ? '<a href="' + waLink + '" target="_blank" class="btn btn-xs" style="background:#25d366; color:#fff; border-radius:6px; font-weight:700; margin-right:4px;" title="Chat WhatsApp"><i class="fa fa-whatsapp"></i> Chat</a>' : '') +
              '<a href="' + crmLink + '" class="btn btn-xs" style="background:#6366f1; color:#fff; border-radius:6px; font-weight:700;" title="Buka Profil CRM"><i class="fa fa-user"></i> CRM</a>' +
            '</td>' +
          '</tr>';
        });

        $('#drilldownTableBody').html(html);
        $('#drilldownContent').show();
      } else {
        $('#drilldownEmpty').show();
      }
    },
    error: function() {
      $('#drilldownLoading').hide();
      $('#drilldownEmpty').show();
    }
  });
}

$('#modalSegmentDrilldown').on('hidden.bs.modal', function () {
  if (currentActiveCell) {
    $(currentActiveCell).removeClass('active-selected');
    currentActiveCell = null;
  }
});
</script>

<!-- MODAL IMPORT EXCEL DATA -->
<div class="modal fade" id="modal-import-excel" tabindex="-1" role="dialog" aria-labelledby="modalImportExcelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:560px; margin:40px auto;">
    <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.15); overflow:hidden;">
      <form method="POST" action="<?= site_url('administrator/rfm/import_excel'); ?>" enctype="multipart/form-data" id="form-import-excel">
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
          <button type="submit" class="btn" style="background:linear-gradient(135deg, #4338ca, #6366f1); color:#fff; border-radius:8px; font-weight:700; padding:8px 22px;"><i class="fa fa-upload"></i> Mulai Import Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

