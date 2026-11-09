<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$r_fil = $r_filter ?? '';
$f_fil = $f_filter ?? '';
$m_fil = $m_filter ?? '';
$seg_fil = $seg_filter ?? '';
$q_search = $search ?? '';

$nav_params = array_filter([
  'r'       => $r_fil,
  'f'       => $f_fil,
  'm'       => $m_fil,
  'segment' => $seg_fil,
  'q'       => $q_search
]);
$nav_qs = !empty($nav_params) ? '?' . http_build_query($nav_params) : '';
?>

<style>
:root {
  --rfm-primary: #6366f1;
  --rfm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
  --card-shadow-hover: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 10px -2px rgba(0, 0, 0, 0.05);
}

.rfm-matrix-rules-wrapper {
  padding: 0 0 25px 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  color: #1e293b;
}

/* =========================================================
   LAYER 1: HEADER & LOCATION NAVIGATION (UNIFIED DESIGN)
   ========================================================= */
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

/* =========================================================
   LAYER 2: 4 MINI KPI CARDS
   ========================================================= */
.rfm-kpi-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
  margin-bottom: 22px;
}
.kpi-mini-card {
  background: #ffffff;
  border-radius: 14px;
  padding: 16px 18px;
  box-shadow: var(--card-shadow);
  border: 1px solid #e2e8f0;
  height: 100%;
  cursor: pointer;
  transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s ease, border-color 0.2s ease;
  user-select: none;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.kpi-mini-card:hover {
  transform: translateY(-3px);
  box-shadow: var(--card-shadow-hover);
  border-color: #cbd5e1;
}
.kpi-mini-val {
  font-size: 21px;
  font-weight: 800;
  line-height: 1.2;
}
.kpi-mini-lbl {
  font-size: 11.5px;
  font-weight: 600;
  color: #64748b;
  margin-top: 4px;
  line-height: 1.35;
}

/* =========================================================
   LAYER 3: FILTER CONTROL BAR & SEGMENT PILLS
   ========================================================= */
.section-card-custom {
  background: #ffffff;
  border-radius: 14px;
  box-shadow: var(--card-shadow);
  border: 1px solid #e2e8f0;
  margin-bottom: 22px;
  overflow: hidden;
}

.segment-quick-filter-scroll {
  display: flex;
  gap: 8px;
  margin-top: 14px;
  padding-top: 12px;
  border-top: 1px dashed #e2e8f0;
  overflow-x: auto;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: thin;
  padding-bottom: 4px;
}
.segment-quick-filter-scroll::-webkit-scrollbar {
  height: 4px;
}
.segment-quick-filter-scroll::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}
.seg-quick-pill {
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 11.5px;
  font-weight: 700;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border: 1px solid #e2e8f0;
  background: #f8fafc;
  color: #475569;
  transition: all 0.15s ease;
  flex-shrink: 0;
}
.seg-quick-pill:hover, .seg-quick-pill.active {
  background: #4338ca;
  color: #ffffff !important;
  border-color: #4338ca;
  box-shadow: 0 2px 8px rgba(67,56,202,0.3);
}

/* =========================================================
   SCORE PILLS
   ========================================================= */
.score-pill {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  border-radius: 8px;
  font-weight: 800;
  font-size: 13px;
  box-shadow: 0 1px 2px rgba(0,0,0,0.06);
}
.score-5 { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.score-4 { background: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
.score-3 { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.score-2 { background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }
.score-1 { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

/* =========================================================
   TOOLBAR & LIVE CONTROLS
   ========================================================= */
.rules-toolbar-flex {
  padding: 16px 22px;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 14px;
  background: #ffffff;
}
.rules-toolbar-controls {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}

/* View Mode Switcher */
.view-mode-toggle {
  display: inline-flex;
  background: #f1f5f9;
  padding: 3px;
  border-radius: 10px;
  border: 1px solid #e2e8f0;
}
.view-toggle-btn {
  border: none;
  background: transparent;
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 700;
  color: #64748b;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.18s ease;
}
.view-toggle-btn.active {
  background: #4338ca !important;
  color: #ffffff !important;
  box-shadow: 0 2px 8px rgba(67, 56, 202, 0.35) !important;
}
.view-toggle-btn.active i {
  color: #ffffff !important;
}

/* Live Instant Search Bar */
.live-search-box {
  position: relative;
  min-width: 200px;
}
.live-search-box input {
  height: 36px;
  border-radius: 20px;
  border: 1px solid #cbd5e1;
  padding: 6px 28px 6px 32px;
  font-size: 12px;
  background: #f8fafc;
  color: #1e293b;
  width: 220px;
  transition: all 0.2s ease;
}
.live-search-box input:focus {
  background: #ffffff;
  border-color: #6366f1;
  width: 250px;
  outline: none;
  box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}
.live-search-icon {
  position: absolute;
  left: 11px;
  top: 10px;
  color: #94a3b8;
  font-size: 13px;
  pointer-events: none;
}
.live-search-clear {
  position: absolute;
  right: 10px;
  top: 9px;
  color: #94a3b8;
  font-size: 14px;
  cursor: pointer;
  display: none;
}
.live-search-clear:hover { color: #ef4444; }

/* =========================================================
   TABLE VIEW (DESKTOP / TABLET)
   ========================================================= */
.rfm-table-responsive-container {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  margin: 0;
  border: none;
}
.rfm-table-responsive-container::-webkit-scrollbar {
  height: 8px;
}
.rfm-table-responsive-container::-webkit-scrollbar-track {
  background: #f1f5f9;
}
.rfm-table-responsive-container::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}
.rfm-table-responsive-container::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

.table-rules-matrix {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  font-size: 12px;
}
.table-rules-matrix th {
  background: #f8fafc;
  color: #334155;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 12px 10px;
  border-bottom: 2px solid #e2e8f0;
  white-space: nowrap;
  position: sticky;
  top: 0;
  z-index: 2;
}
.table-rules-matrix td {
  padding: 10px 10px;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
}
.table-rules-matrix tbody tr:hover td {
  background: #f8fafc;
}
.table-rules-matrix tbody tr.rule-row-hidden {
  display: none !important;
}

/* =========================================================
   CARD VIEW (MOBILE / TOUCH FRIENDLY)
   ========================================================= */
.rfm-cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 14px;
  padding: 18px 20px;
}
.rfm-rule-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  transition: all 0.2s ease;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}
.rfm-rule-card:hover {
  border-color: #cbd5e1;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  transform: translateY(-2px);
}
.rfm-rule-card.rule-card-hidden {
  display: none !important;
}

.rfm-card-header {
  padding: 12px 14px;
  background: #f8fafc;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 8px;
}
.rfm-scores-group {
  display: inline-flex;
  align-items: center;
  gap: 4px;
}
.rfm-card-code {
  font-family: monospace;
  font-size: 13.5px;
  font-weight: 800;
  color: #1e1b4b;
  background: #ffffff;
  padding: 3px 8px;
  border-radius: 6px;
  border: 1px solid #cbd5e1;
  letter-spacing: 1px;
  margin-left: 4px;
}

.rfm-card-body {
  padding: 14px;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.rfm-card-box {
  border-radius: 10px;
  padding: 10px 12px;
}
.rfm-card-box-goal {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
}
.rfm-card-box-action {
  background: #fffbeb;
  border: 1px solid #fef3c7;
}
.rfm-card-box-title {
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 4px;
  display: flex;
  align-items: center;
  gap: 5px;
}
.rfm-card-box-desc {
  font-size: 12.5px;
  line-height: 1.45;
  color: #334155;
  font-weight: 500;
}

.rfm-card-footer {
  padding: 10px 14px;
  background: #fafafa;
  border-top: 1px solid #f1f5f9;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 11.5px;
}

/* =========================================================
   PAGINATION BAR
   ========================================================= */
.rfm-pagination-bar {
  padding: 12px 20px;
  background: #f8fafc;
  border-top: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
  font-size: 12px;
  color: #64748b;
}
.rfm-page-size-picker {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.rfm-page-size-picker .btn-size {
  border: 1px solid #cbd5e1;
  background: #ffffff;
  color: #475569;
  font-size: 11.5px;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.15s ease;
}
.rfm-page-size-picker .btn-size.active {
  background: #4338ca;
  color: #ffffff;
  border-color: #4338ca;
}
.rfm-pagination-controls {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.rfm-page-btn {
  border: 1px solid #cbd5e1;
  background: #ffffff;
  color: #334155;
  font-size: 12px;
  font-weight: 700;
  padding: 5px 11px;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.15s ease;
}
.rfm-page-btn:hover:not(:disabled) {
  background: #f1f5f9;
  color: #1e293b;
}
.rfm-page-btn:disabled {
  opacity: 0.45;
  cursor: not-allowed;
}

/* Empty State */
.rfm-empty-state {
  text-align: center;
  padding: 50px 20px;
  display: none;
}
.rfm-empty-state i {
  font-size: 38px;
  color: #94a3b8;
  margin-bottom: 12px;
}

/* =========================================================
   RESPONSIVE BREAKPOINTS (MOBILE & TABLET)
   ========================================================= */
@media (max-width: 991px) {
  .rfm-kpi-grid {
    grid-template-columns: repeat(2, 1fr) !important;
  }
}

@media (max-width: 768px) {
  .rfm-matrix-rules-wrapper {
    padding: 0 0 15px 0 !important;
  }
  .rfm-header-nav {
    padding: 18px 16px 14px 16px !important;
    border-radius: 12px !important;
    margin-bottom: 14px !important;
  }
  .rfm-header-nav .header-top-flex {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 12px !important;
  }
  .rfm-header-nav .header-title h2 {
    font-size: 18px !important;
  }
  .rfm-header-nav .header-title p {
    font-size: 12px !important;
  }
  .rfm-header-nav .action-tools {
    width: 100% !important;
    display: flex !important;
    gap: 6px !important;
  }
  .rfm-header-nav .action-tools .btn {
    flex: 1 1 0% !important;
    text-align: center !important;
    justify-content: center !important;
    font-size: 11px !important;
    padding: 7px 8px !important;
  }
  .rfm-header-nav .nav-tabs-bar {
    padding-top: 10px !important;
    gap: 6px !important;
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
  .kpi-mini-lbl {
    font-size: 11px !important;
  }

  .rules-toolbar-flex {
    padding: 12px 14px !important;
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 10px !important;
  }
  .rules-toolbar-controls {
    justify-content: space-between !important;
    width: 100% !important;
  }
  .live-search-box {
    width: 100% !important;
    min-width: 0 !important;
  }
  .live-search-box input {
    width: 100% !important;
  }
  .live-search-box input:focus {
    width: 100% !important;
  }

  .rfm-cards-grid {
    grid-template-columns: 1fr !important;
    padding: 12px 10px !important;
    gap: 12px !important;
  }

  .rfm-pagination-bar {
    flex-direction: column !important;
    align-items: stretch !important;
    text-align: center !important;
    padding: 12px 14px !important;
    gap: 10px !important;
  }
  .rfm-page-size-picker, .rfm-pagination-controls {
    justify-content: center !important;
  }

  .modal-dialog {
    width: 94% !important;
    max-width: 500px !important;
    margin: 20px auto !important;
  }
}

@media (max-width: 480px) {
  .rfm-kpi-grid {
    grid-template-columns: 1fr !important;
    gap: 10px !important;
  }
}
</style>

<div class="rfm-matrix-rules-wrapper">

  <!-- =========================================================
       LAYER 1: HEADER & LOCATION NAVIGATION
       ========================================================= -->
  <div class="rfm-header-nav">
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> Analisis RFM <i class="fa fa-angle-right"></i> <span>Matriks Aturan RFM</span>
        </div>
        <h2><i class="fa fa-table" style="color:#818cf8;"></i> Matriks Aturan RFM (125 Aturan)</h2>
        <p>Kamus lengkap pemetaan kombinasi skor Recency (1-5), Frequency (1-5), dan Monetary (1-5) ke 10 Segmen RFM &amp; strategi rekomendasi</p>
      </div>

      <div class="action-tools">
        <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn" style="background:#25D366; color:#fff;" title="Broadcast WA"><i class="fa fa-bullhorn"></i> Broadcast WA</a>
        <button type="button" class="btn" data-toggle="modal" data-target="#modal-import-matrix" style="background:#10b981; color:#fff; box-shadow:0 4px 12px rgba(16,185,129,0.35);" title="Import / Update Aturan Matriks dari Excel"><i class="fa fa-file-excel-o"></i> Import Excel Data</button>
        <a href="<?= site_url('administrator/rfm/download_template_matrix'); ?>" class="btn" style="background:rgba(255,255,255,0.18); color:#fff; border:1px solid rgba(255,255,255,0.3);" title="Unduh Matriks 125 Aturan dalam format CSV"><i class="fa fa-download"></i> Export CSV</a>
        <?php if (!empty($is_custom)): ?>
        <a href="<?= site_url('administrator/rfm/reset_matrix_rules'); ?>" class="btn" style="background:#ef4444; color:#fff;" onclick="return confirm('Apakah Anda yakin ingin mereset aturan matriks ke standar bawaan (125 aturan)?');" title="Reset Aturan ke Standar Bawaan"><i class="fa fa-refresh"></i> Reset Standar</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Navigation Tabs Bar -->
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
      <a href="<?= site_url('administrator/rfm/cohort' . $nav_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-th"></i> 4. Analisis Kohort
      </a>
      <a href="<?= site_url('administrator/crm_segments/product_rfm' . $nav_qs); ?>" class="nav-tab-btn">
        <i class="fa fa-th-large"></i> 5. Tren Segmen Produk
      </a>
      <a href="<?= site_url('administrator/rfm/matrix_rules' . $nav_qs); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-table"></i> 6. Matriks Aturan RFM
      </a>
    </div>
  </div>

  <!-- =========================================================
       LAYER 2: 4 MINI KPI INSIGHT CARDS
       ========================================================= -->
  <div class="rfm-kpi-grid">
    <!-- KPI 1: Total Rules -->
    <div class="kpi-mini-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm/matrix_rules' . $nav_qs); ?>';" title="Klik untuk menampilkan seluruh aturan (Reset Pencarian & Filter Segmen)" style="border-left:4px solid #6366f1;">
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
          <div class="kpi-mini-val" style="color:#312e81;">
            <?= number_format($total_rules); ?> Aturan
          </div>
          <div class="kpi-mini-lbl" style="color:#4338ca;">
            <?= $filtered_count < $total_rules ? 'Menampilkan ' . $filtered_count . ' difilter (Klik utk Reset)' : 'Kombinasi 5 × 5 × 5 Lengkap'; ?>
          </div>
        </div>
        <div style="width:40px; height:40px; border-radius:10px; background:#e0e7ff; color:#3730a3; display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0;">
          <i class="fa fa-table"></i>
        </div>
      </div>
    </div>

    <!-- KPI 2: Total Segmen -->
    <div class="kpi-mini-card" role="button" tabindex="0" onclick="var el=document.getElementById('section-filter-segment'); if(el){ el.scrollIntoView({behavior:'smooth'}); }" title="Klik untuk menuju ke pilihan filter 10 Segmen RFM" style="border-left:4px solid #10b981;">
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
          <div class="kpi-mini-val" style="color:#065f46;">
            10 Segmen
          </div>
          <div class="kpi-mini-lbl" style="color:#047857;">Champions s/d Hibernating &darr;</div>
        </div>
        <div style="width:40px; height:40px; border-radius:10px; background:#dcfce7; color:#15803d; display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0;">
          <i class="fa fa-trophy"></i>
        </div>
      </div>
    </div>

    <!-- KPI 3: Live Customers Mapped -->
    <div class="kpi-mini-card" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm' . $nav_qs); ?>';" title="Klik untuk membuka dan melihat rincian seluruh pelanggan di Daftar Customer RFM" style="border-left:4px solid #0284c7;">
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
          <div class="kpi-mini-val" style="color:#0369a1;">
            <?= number_format($total_customers); ?> Orang
          </div>
          <div class="kpi-mini-lbl" style="color:#0284c7;">Pelanggan Database Terpetakan &rarr;</div>
        </div>
        <div style="width:40px; height:40px; border-radius:10px; background:#e0f2fe; color:#0369a1; display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0;">
          <i class="fa fa-users"></i>
        </div>
      </div>
    </div>

    <!-- KPI 4: Status Rule Engine -->
    <div class="kpi-mini-card" role="button" tabindex="0" data-toggle="modal" data-target="#modal-import-matrix" title="Klik untuk membuka dialog Import Aturan Excel / Kelola Matriks" style="border-left:4px solid <?= !empty($is_custom) ? '#f59e0b' : '#14b8a6'; ?>;">
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
          <div class="kpi-mini-val" style="color:<?= !empty($is_custom) ? '#b45309' : '#0f766e'; ?>; font-size:17px;">
            <?= !empty($is_custom) ? 'Aturan Khusus' : 'Standar Bawaan'; ?>
          </div>
          <div class="kpi-mini-lbl" style="color:#475569;">
            <?= !empty($is_custom) ? 'Tersimpan Custom Excel (Klik)' : 'Sinkron rfm magang.xlsx (Klik)'; ?>
          </div>
        </div>
        <div style="width:40px; height:40px; border-radius:10px; background:<?= !empty($is_custom) ? '#fef3c7' : '#ccfbf1'; ?>; color:<?= !empty($is_custom) ? '#b45309' : '#0f766e'; ?>; display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0;">
          <i class="fa <?= !empty($is_custom) ? 'fa-pencil-square-o' : 'fa-check-circle'; ?>"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- =========================================================
       LAYER 3: FILTER CONTROL BAR
       ========================================================= -->
  <div class="section-card-custom" style="padding:16px 20px; margin-bottom:22px;">
    <form method="GET" action="<?= site_url('administrator/rfm/matrix_rules'); ?>" id="form-rules-filter">
      <div class="row" style="display:flex; align-items:center; flex-wrap:wrap; margin:0 -6px;">
        
        <!-- Filter Segmen -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="padding:0 6px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:11.5px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-filter" style="color:#6366f1;"></i> Filter Segmen RFM:
          </label>
          <select name="segment" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12px; font-weight:600;" onchange="this.form.submit();">
            <option value="">-- Semua Segmen (10) --</option>
            <?php foreach ($segment_summary as $s_name => $s_info): ?>
              <option value="<?= htmlspecialchars($s_name); ?>" <?= ($seg_fil === $s_name) ? 'selected' : ''; ?>>
                <?= htmlspecialchars($s_name); ?> (<?= $s_info['count']; ?> aturan)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Filter Recency (R) -->
        <div class="col-md-2 col-sm-4 col-xs-4" style="padding:0 6px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:11.5px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-clock-o" style="color:#2563eb;"></i> Recency (R):
          </label>
          <select name="r" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12px; font-weight:600;" onchange="this.form.submit();">
            <option value="">Semua R</option>
            <?php for ($s = 5; $s >= 1; $s--): ?>
              <option value="<?= $s; ?>" <?= ($r_fil === (string)$s) ? 'selected' : ''; ?>>Skor <?= $s; ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <!-- Filter Frequency (F) -->
        <div class="col-md-2 col-sm-4 col-xs-4" style="padding:0 6px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:11.5px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-repeat" style="color:#16a34a;"></i> Frequency (F):
          </label>
          <select name="f" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12px; font-weight:600;" onchange="this.form.submit();">
            <option value="">Semua F</option>
            <?php for ($s = 5; $s >= 1; $s--): ?>
              <option value="<?= $s; ?>" <?= ($f_fil === (string)$s) ? 'selected' : ''; ?>>Skor <?= $s; ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <!-- Filter Monetary (M) -->
        <div class="col-md-2 col-sm-4 col-xs-4" style="padding:0 6px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:11.5px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-money" style="color:#7c3aed;"></i> Monetary (M):
          </label>
          <select name="m" class="form-control" style="width:100%; border-radius:8px; height:38px; font-size:12px; font-weight:600;" onchange="this.form.submit();">
            <option value="">Semua M</option>
            <?php for ($s = 5; $s >= 1; $s--): ?>
              <option value="<?= $s; ?>" <?= ($m_fil === (string)$s) ? 'selected' : ''; ?>>Skor <?= $s; ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <!-- Submit & Reset Actions -->
        <div class="col-md-3 col-sm-6 col-xs-12" style="padding:0 6px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:11.5px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-search" style="color:#0284c7;"></i> Kata Kunci Server:
          </label>
          <div style="display:flex; gap:6px;">
            <input type="text" name="q" value="<?= htmlspecialchars($q_search); ?>" placeholder="Kode / Segmen / Kata..." class="form-control" style="border-radius:8px; height:38px; font-size:12px;">
            <button type="submit" class="btn btn-primary" style="border-radius:8px; height:38px; font-weight:700; padding:0 14px; background:#4338ca; border-color:#4338ca;">
              <i class="fa fa-filter"></i>
            </button>
            <?php if (!empty($r_fil) || !empty($f_fil) || !empty($m_fil) || !empty($seg_fil) || !empty($q_search)): ?>
              <a href="<?= site_url('administrator/rfm/matrix_rules'); ?>" class="btn btn-default" style="border-radius:8px; height:38px; font-weight:700; padding:0 12px; display:inline-flex; align-items:center;" title="Reset Filter">
                <i class="fa fa-times text-danger"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>

      </div>

      <!-- Quick Filter Pills by Segment (Touch Scrollable) -->
      <div class="segment-quick-filter-scroll" id="section-filter-segment">
        <span style="font-size:11.5px; font-weight:700; color:#64748b; display:inline-flex; align-items:center; margin-right:4px;">
          <i class="fa fa-tags" style="margin-right:4px;"></i> Segmen:
        </span>
        <a href="<?= site_url('administrator/rfm/matrix_rules'); ?>" class="seg-quick-pill <?= empty($seg_fil) ? 'active' : ''; ?>">
          Semua (<?= $total_rules; ?>)
        </a>
        <?php foreach ($segment_summary as $s_name => $s_info): 
          $is_active = ($seg_fil === $s_name);
        ?>
        <a href="<?= site_url('administrator/rfm/matrix_rules?segment=' . urlencode($s_name)); ?>" class="seg-quick-pill <?= $is_active ? 'active' : ''; ?>">
          <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:<?= $s_info['badge']['color']; ?>;"></span>
          <?= htmlspecialchars($s_name); ?> (<?= $s_info['count']; ?>)
        </a>
        <?php endforeach; ?>
      </div>
    </form>
  </div>

  <!-- =========================================================
       LAYER 4: MAIN 125 RULES (DUAL VIEW: TABLE & CARDS)
       ========================================================= -->
  <div class="section-card-custom" id="table-rules-section" style="padding:0; margin-bottom:25px;">
    
    <!-- Section Toolbar Header -->
    <div class="rules-toolbar-flex">
      <div>
        <h4 style="margin:0 0 4px 0; font-weight:800; font-size:16px; color:#1e293b;">
          <i class="fa fa-list-ol" style="color:#6366f1;"></i> Daftar Aturan Kombinasi Matriks RFM
        </h4>
        <div style="font-size:12px; color:#64748b;">
          Menampilkan <strong id="rules-visible-count"><?= count($rules); ?></strong> dari total <strong><?= $total_rules; ?></strong> kombinasi aturan segmentasi
        </div>
      </div>

      <div class="rules-toolbar-controls">
        <!-- Live Instant Search Bar -->
        <div class="live-search-box">
          <i class="fa fa-search live-search-icon"></i>
          <input type="text" id="input-instant-search" placeholder="Cari cepat (555, Champions, dll)..." autocomplete="off">
          <i class="fa fa-times-circle live-search-clear" id="btn-clear-search" title="Hapus pencarian"></i>
        </div>

        <!-- View Switcher -->
        <div class="view-mode-toggle" title="Ubah tampilan antara Mode Tabel dan Mode Kartu">
          <button type="button" class="view-toggle-btn active" id="btn-view-table" onclick="setRulesViewMode('table');">
            <i class="fa fa-table"></i> Tabel
          </button>
          <button type="button" class="view-toggle-btn" id="btn-view-cards" onclick="setRulesViewMode('cards');">
            <i class="fa fa-th-large"></i> Kartu
          </button>
        </div>

        <span class="badge hidden-xs" style="background:#f1f5f9; color:#475569; font-weight:700; font-size:11px; padding:6px 10px; border-radius:20px; border:1px solid #cbd5e1;">
          <i class="fa fa-info-circle text-primary"></i> [R] + [F] + [M] &rarr; Segmen
        </span>
      </div>
    </div>

    <!-- ==============================================
         VIEW A: RESPONSIVE TABLE VIEW (DESKTOP/TABLET)
         ============================================== -->
    <div id="rfm-view-table">
      <div class="rfm-table-responsive-container">
        <table class="table-rules-matrix" id="rules-table-element">
          <thead>
            <tr>
              <th style="width:44px; text-align:center;">#</th>
              <th style="width:65px; text-align:center;">RECENCY (B)</th>
              <th style="width:65px; text-align:center;">FREQ (C)</th>
              <th style="width:65px; text-align:center;">MONET (D)</th>
              <th style="width:82px; text-align:center;">SKOR RFM</th>
              <th style="width:155px;">SEGMEN (F)</th>
              <th style="min-width:180px; max-width:260px;">TARGET PERILAKU (GOALS)</th>
              <th style="min-width:220px;">STRATEGI PROMO &amp; CRM (ACTIONS)</th>
              <th style="width:125px; text-align:center;">PELANGGAN SAAT INI</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($rules)): ?>
              <?php 
              $no = 1;
              foreach ($rules as $code => $r_item): 
                $badge = $r_item['badge'];
                $active_c = $r_item['active_customers'] ?? 0;
                $search_text = strtolower($code . ' ' . $r_item['r'] . ' ' . $r_item['f'] . ' ' . $r_item['m'] . ' ' . $r_item['segment'] . ' ' . $r_item['goal'] . ' ' . $r_item['action']);
              ?>
              <tr class="rule-item-row" 
                  data-code="<?= htmlspecialchars($code); ?>"
                  data-segment="<?= strtolower(htmlspecialchars($r_item['segment'])); ?>"
                  data-r="<?= $r_item['r']; ?>"
                  data-f="<?= $r_item['f']; ?>"
                  data-m="<?= $r_item['m']; ?>"
                  data-search="<?= htmlspecialchars($search_text); ?>">
                
                <!-- Number -->
                <td style="text-align:center; color:#94a3b8; font-weight:600; font-size:11.5px;">
                  <?= $no++; ?>
                </td>
                
                <!-- Recency -->
                <td style="text-align:center;">
                  <span class="score-pill score-<?= $r_item['r']; ?>" title="Skor Recency: <?= $r_item['r']; ?>">
                    <?= $r_item['r']; ?>
                  </span>
                </td>

                <!-- Frequency -->
                <td style="text-align:center;">
                  <span class="score-pill score-<?= $r_item['f']; ?>" title="Skor Frequency: <?= $r_item['f']; ?>">
                    <?= $r_item['f']; ?>
                  </span>
                </td>

                <!-- Monetary -->
                <td style="text-align:center;">
                  <span class="score-pill score-<?= $r_item['m']; ?>" title="Skor Monetary: <?= $r_item['m']; ?>">
                    <?= $r_item['m']; ?>
                  </span>
                </td>

                <!-- RFM Code -->
                <td style="text-align:center;">
                  <span style="font-family:monospace; font-size:13.5px; font-weight:800; color:#1e1b4b; background:#f1f5f9; padding:4px 8px; border-radius:6px; letter-spacing:1px; border:1px solid #e2e8f0;">
                    <?= htmlspecialchars($r_item['code']); ?>
                  </span>
                </td>

                <!-- Segment -->
                <td>
                  <span style="display:inline-flex; align-items:center; gap:6px; padding:4px 9px; border-radius:8px; font-weight:700; font-size:11.5px; background:<?= $badge['bg']; ?>; color:<?= $badge['color']; ?>; border:1px solid <?= $badge['border']; ?>; white-space:nowrap;">
                    <i class="fa <?= $badge['icon']; ?>"></i> <?= htmlspecialchars($r_item['segment']); ?>
                  </span>
                </td>

                <!-- Goals -->
                <td style="color:#334155; font-size:12px; font-weight:500; line-height:1.4;">
                  <?= htmlspecialchars($r_item['goal'] ?: '-'); ?>
                </td>

                <!-- Actions -->
                <td style="color:#475569; font-size:12px; line-height:1.4;">
                  <i class="fa fa-lightbulb-o" style="color:#f59e0b; margin-right:4px;"></i> <?= htmlspecialchars($r_item['action'] ?: '-'); ?>
                </td>

                <!-- Active Customers Count in Database -->
                <td style="text-align:center;">
                  <?php if ($active_c > 0): ?>
                    <a href="<?= site_url('administrator/rfm?rfm_segment=' . urlencode($r_item['segment'])); ?>" class="btn btn-xs" style="background:#e0e7ff; color:#3730a3; font-weight:800; border-radius:6px; padding:4px 9px;" title="Buka Daftar Customer segmen <?= htmlspecialchars($r_item['segment']); ?>">
                      <i class="fa fa-users"></i> <?= number_format($active_c); ?> Orang
                    </a>
                  <?php else: ?>
                    <span style="color:#94a3b8; font-size:11px; font-weight:600;">0 Orang</span>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ==============================================
         VIEW B: MOBILE-FIRST CARD VIEW (SMARTPHONES/TABLETS)
         ============================================== -->
    <div id="rfm-view-cards" style="display:none;">
      <div class="rfm-cards-grid" id="rules-cards-container">
        <?php if (!empty($rules)): ?>
          <?php 
          $no = 1;
          foreach ($rules as $code => $r_item): 
            $badge = $r_item['badge'];
            $active_c = $r_item['active_customers'] ?? 0;
            $search_text = strtolower($code . ' ' . $r_item['r'] . ' ' . $r_item['f'] . ' ' . $r_item['m'] . ' ' . $r_item['segment'] . ' ' . $r_item['goal'] . ' ' . $r_item['action']);
          ?>
          <div class="rfm-rule-card rule-item-card"
               data-code="<?= htmlspecialchars($code); ?>"
               data-segment="<?= strtolower(htmlspecialchars($r_item['segment'])); ?>"
               data-r="<?= $r_item['r']; ?>"
               data-f="<?= $r_item['f']; ?>"
               data-m="<?= $r_item['m']; ?>"
               data-search="<?= htmlspecialchars($search_text); ?>">
            
            <!-- Card Header: Scores & Segment -->
            <div class="rfm-card-header">
              <div class="rfm-scores-group">
                <span class="score-pill score-<?= $r_item['r']; ?>" title="Recency: <?= $r_item['r']; ?>">R<?= $r_item['r']; ?></span>
                <span class="score-pill score-<?= $r_item['f']; ?>" title="Frequency: <?= $r_item['f']; ?>">F<?= $r_item['f']; ?></span>
                <span class="score-pill score-<?= $r_item['m']; ?>" title="Monetary: <?= $r_item['m']; ?>">M<?= $r_item['m']; ?></span>
                <span class="rfm-card-code"><?= htmlspecialchars($r_item['code']); ?></span>
              </div>
              <div>
                <span style="display:inline-flex; align-items:center; gap:5px; padding:4px 9px; border-radius:8px; font-weight:700; font-size:11.5px; background:<?= $badge['bg']; ?>; color:<?= $badge['color']; ?>; border:1px solid <?= $badge['border']; ?>;">
                  <i class="fa <?= $badge['icon']; ?>"></i> <?= htmlspecialchars($r_item['segment']); ?>
                </span>
              </div>
            </div>

            <!-- Card Body: Goals & Action Strategies -->
            <div class="rfm-card-body">
              <!-- Target Perilaku (Goal) -->
              <div class="rfm-card-box rfm-card-box-goal">
                <div class="rfm-card-box-title" style="color:#4f46e5;">
                  <i class="fa fa-bullseye"></i> Target Perilaku (Goal):
                </div>
                <div class="rfm-card-box-desc">
                  <?= htmlspecialchars($r_item['goal'] ?: '-'); ?>
                </div>
              </div>

              <!-- Strategi Promo & CRM (Action) -->
              <div class="rfm-card-box rfm-card-box-action">
                <div class="rfm-card-box-title" style="color:#b45309;">
                  <i class="fa fa-lightbulb-o"></i> Strategi Promo &amp; CRM:
                </div>
                <div class="rfm-card-box-desc">
                  <?= htmlspecialchars($r_item['action'] ?: '-'); ?>
                </div>
              </div>
            </div>

            <!-- Card Footer: Index & Customer Count -->
            <div class="rfm-card-footer">
              <span style="color:#94a3b8; font-weight:700; font-size:11px;">
                #<?= $no++; ?> dari <?= count($rules); ?>
              </span>
              <div>
                <?php if ($active_c > 0): ?>
                  <a href="<?= site_url('administrator/rfm?rfm_segment=' . urlencode($r_item['segment'])); ?>" class="btn btn-xs" style="background:#e0e7ff; color:#3730a3; font-weight:800; border-radius:6px; padding:3px 8px;">
                    <i class="fa fa-users"></i> <?= number_format($active_c); ?> Pelanggan &rarr;
                  </a>
                <?php else: ?>
                  <span style="color:#94a3b8; font-size:11px; font-weight:600;">0 Pelanggan</span>
                <?php endif; ?>
              </div>
            </div>

          </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <!-- Empty State Result -->
    <div class="rfm-empty-state" id="rfm-empty-state">
      <i class="fa fa-search"></i>
      <h4 style="font-weight:800; color:#334155; margin:0 0 6px 0;">Tidak Ada Aturan yang Cocok</h4>
      <p style="color:#64748b; font-size:12.5px; max-width:400px; margin:0 auto 14px auto;">
        Tidak ditemukan aturan kombinasi matriks RFM dengan kata kunci atau kriteria pencarian tersebut.
      </p>
      <button type="button" class="btn btn-primary btn-sm" onclick="resetLiveSearch();" style="border-radius:8px; font-weight:700; background:#4338ca; border-color:#4338ca;">
        <i class="fa fa-refresh"></i> Reset Pencarian
      </button>
    </div>

    <!-- ==============================================
         INTERACTIVE PAGINATION & FOOTER CONTROLS
         ============================================== -->
    <div class="rfm-pagination-bar" id="rfm-pagination-container">
      <!-- Showing count text -->
      <div>
        Menampilkan baris <strong id="page-item-start">1</strong> - <strong id="page-item-end">25</strong> dari <strong id="page-item-total"><?= count($rules); ?></strong> aturan
      </div>

      <!-- Rows per page selector -->
      <div class="rfm-page-size-picker">
        <span style="font-size:11.5px; font-weight:700; color:#64748b;">Per Halaman:</span>
        <button type="button" class="btn-size active" data-size="25" onclick="setRulesPageSize(25);">25</button>
        <button type="button" class="btn-size" data-size="50" onclick="setRulesPageSize(50);">50</button>
        <button type="button" class="btn-size" data-size="100" onclick="setRulesPageSize(100);">100</button>
        <button type="button" class="btn-size" data-size="-1" onclick="setRulesPageSize(-1);">Semua</button>
      </div>

      <!-- Pagination Buttons -->
      <div class="rfm-pagination-controls">
        <button type="button" class="rfm-page-btn" id="btn-page-first" onclick="goToRulesPage(1);" title="Halaman Pertama">
          <i class="fa fa-angle-double-left"></i>
        </button>
        <button type="button" class="rfm-page-btn" id="btn-page-prev" onclick="prevRulesPage();" title="Halaman Sebelumnya">
          <i class="fa fa-angle-left"></i> Sebelumnya
        </button>
        <span style="font-weight:700; color:#334155; padding:0 4px;">
          Hal <span id="page-current">1</span> / <span id="page-max">1</span>
        </span>
        <button type="button" class="rfm-page-btn" id="btn-page-next" onclick="nextRulesPage();" title="Halaman Selanjutnya">
          Selanjutnya <i class="fa fa-angle-right"></i>
        </button>
        <button type="button" class="rfm-page-btn" id="btn-page-last" onclick="goToRulesLastPage();" title="Halaman Terakhir">
          <i class="fa fa-angle-double-right"></i>
        </button>
      </div>
    </div>

    <!-- Table Footer Note -->
    <div style="padding:12px 20px; background:#ffffff; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; font-size:11.5px; color:#64748b;">
      <div>
        <i class="fa fa-check-circle" style="color:#10b981;"></i> Struktur aturan tabel di atas sama persis dengan sheet <strong>rfm magang.xlsx</strong> (Kolom B: Recency, C: Frequency, D: Monetary, E: RFM, F: Segment).
      </div>
      <div>
        <a href="<?= site_url('administrator/rfm/download_template_matrix'); ?>" style="color:#4338ca; font-weight:700; text-decoration:none;">
          <i class="fa fa-download"></i> Unduh File CSV Matriks Lengkap &rarr;
        </a>
      </div>
    </div>

  </div>

</div>

<!-- =========================================================
     MODAL IMPORT ATURAN MATRIKS EXCEL
     ========================================================= -->
<div class="modal fade" id="modal-import-matrix" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="max-width:520px; margin:50px auto;">
    <div class="modal-content" style="border-radius:14px; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.25); overflow:hidden;">
      <div class="modal-header" style="background:linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%); color:#fff; padding:18px 24px; border:none;">
        <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:0.85; font-size:24px; text-shadow:none;">&times;</button>
        <h4 class="modal-title" style="font-weight:800; font-size:16px; margin:0;">
          <i class="fa fa-upload"></i> Import Aturan Matriks RFM (.xlsx / .csv)
        </h4>
        <div style="font-size:11.5px; opacity:0.85; margin-top:4px;">
          Perbarui 125 aturan kombinasi skor RFM dengan file Excel custom Anda
        </div>
      </div>

      <form method="POST" action="<?= site_url('administrator/rfm/import_excel'); ?>" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="import_type" value="matrix">
        
        <div class="modal-body" style="padding:22px;">
          <div style="background:#eef2ff; border:1px solid #c7d2fe; border-radius:8px; padding:12px 14px; font-size:12px; color:#3730a3; margin-bottom:16px; line-height:1.4;">
            <i class="fa fa-info-circle"></i> Pastikan file memiliki susunan kolom:
            <br><strong>B: Recency, C: Frequency, D: Monetary, E: RFM, F: Segment, G: Goal, H: Action</strong>
          </div>

          <div class="form-group">
            <label style="font-weight:700; color:#1e1b4b; font-size:12px;">Pilih File (.xlsx, .xls, .csv):</label>
            <div style="border:2px dashed #a5b4fc; background:#faf5ff; border-radius:10px; padding:18px; text-align:center;">
              <i class="fa fa-cloud-upload" style="font-size:32px; color:#6366f1; display:block; margin-bottom:8px;"></i>
              <input type="file" name="file_excel" class="form-control" accept=".xlsx, .xls, .csv" required style="max-width:320px; margin:0 auto; padding:4px; font-size:12px; border-radius:6px;">
            </div>
          </div>

          <div style="background:#f8fafc; border-radius:8px; padding:10px 12px; border:1px solid #e2e8f0; font-size:11.5px;">
            <span style="font-weight:700; color:#475569; display:block; margin-bottom:6px;"><i class="fa fa-download"></i> Belum punya file format yang tepat?</span>
            <a href="<?= site_url('administrator/rfm/download_template_matrix'); ?>" class="btn btn-default btn-xs" style="border-radius:6px; font-size:11px; font-weight:700; color:#15803d; border-color:#86efac;">
              <i class="fa fa-table text-success"></i> Unduh Format Template Matriks 125 Aturan
            </a>
          </div>
        </div>

        <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:12px 22px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:8px; font-weight:600;">Batal</button>
          <button type="submit" class="btn btn-primary" style="border-radius:8px; font-weight:700; background:#4338ca; border-color:#4338ca;">
            <i class="fa fa-upload"></i> Simpan &amp; Terapkan Aturan Matriks
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- =========================================================
     JAVASCRIPT: CLIENT-SIDE INSTANT SEARCH, VIEW SWITCHER & PAGING
     ========================================================= -->
<script>
(function() {
  var currentViewMode = 'table';
  var currentPage = 1;
  var pageSize = 25;
  var rows = [];
  var cards = [];
  var matchedIndices = [];

  document.addEventListener('DOMContentLoaded', function() {
    initRulesEngine();
  });

  // Also support jQuery ready if already loaded
  if (typeof jQuery !== 'undefined') {
    jQuery(document).ready(function() {
      initRulesEngine();
    });
  }

  var isInitialized = false;
  function initRulesEngine() {
    if (isInitialized) return;
    isInitialized = true;

    // Cache rows and cards
    var tableEl = document.getElementById('rules-table-element');
    if (tableEl) {
      rows = Array.prototype.slice.call(tableEl.querySelectorAll('tbody tr.rule-item-row'));
    }
    var cardsContainer = document.getElementById('rules-cards-container');
    if (cardsContainer) {
      cards = Array.prototype.slice.call(cardsContainer.querySelectorAll('.rule-item-card'));
    }

    // Initialize all matching indices
    matchedIndices = [];
    for (var i = 0; i < rows.length; i++) {
      matchedIndices.push(i);
    }

    // Auto-select view mode based on screen width
    var savedView = localStorage.getItem('rfm_matrix_view_preference');
    if (savedView) {
      currentViewMode = savedView;
    } else {
      // Mobile (< 768px) defaults to Cards mode for optimal mobile UX!
      if (window.innerWidth < 768) {
        currentViewMode = 'cards';
      } else {
        currentViewMode = 'table';
      }
    }
    applyViewMode(currentViewMode);

    // Bind instant search
    var searchInput = document.getElementById('input-instant-search');
    var clearBtn = document.getElementById('btn-clear-search');
    if (searchInput) {
      searchInput.addEventListener('input', function() {
        performLiveFilter(this.value.trim());
      });
      searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Escape') {
          resetLiveSearch();
        }
      });
    }
    if (clearBtn) {
      clearBtn.addEventListener('click', function() {
        resetLiveSearch();
      });
    }

    renderPagination();
  }

  function applyViewMode(mode) {
    currentViewMode = mode;
    var tableContainer = document.getElementById('rfm-view-table');
    var cardsContainer = document.getElementById('rfm-view-cards');
    var btnTable = document.getElementById('btn-view-table');
    var btnCards = document.getElementById('btn-view-cards');

    if (mode === 'cards') {
      if (tableContainer) tableContainer.style.display = 'none';
      if (cardsContainer) cardsContainer.style.display = 'block';
      if (btnCards) btnCards.classList.add('active');
      if (btnTable) btnTable.classList.remove('active');
    } else {
      if (cardsContainer) cardsContainer.style.display = 'none';
      if (tableContainer) tableContainer.style.display = 'block';
      if (btnTable) btnTable.classList.add('active');
      if (btnCards) btnCards.classList.remove('active');
    }
  }

  window.setRulesViewMode = function(mode) {
    applyViewMode(mode);
    try {
      localStorage.setItem('rfm_matrix_view_preference', mode);
    } catch(e) {}
  };

  function performLiveFilter(query) {
    var clearBtn = document.getElementById('btn-clear-search');
    if (clearBtn) {
      clearBtn.style.display = query.length > 0 ? 'block' : 'none';
    }

    var q = query.toLowerCase();
    matchedIndices = [];

    for (var i = 0; i < rows.length; i++) {
      var searchAttr = rows[i].getAttribute('data-search') || '';
      var isMatch = (q === '') || (searchAttr.indexOf(q) !== -1);
      if (isMatch) {
        matchedIndices.push(i);
      }
    }

    currentPage = 1;
    renderPagination();
  }

  window.resetLiveSearch = function() {
    var searchInput = document.getElementById('input-instant-search');
    if (searchInput) {
      searchInput.value = '';
    }
    performLiveFilter('');
    if (searchInput) searchInput.focus();
  };

  window.setRulesPageSize = function(size) {
    pageSize = parseInt(size, 10);
    currentPage = 1;

    // Update active class on size buttons
    var sizeBtns = document.querySelectorAll('.rfm-page-size-picker .btn-size');
    for (var i = 0; i < sizeBtns.length; i++) {
      var s = parseInt(sizeBtns[i].getAttribute('data-size'), 10);
      if (s === pageSize) {
        sizeBtns[i].classList.add('active');
      } else {
        sizeBtns[i].classList.remove('active');
      }
    }

    renderPagination();
  };

  window.goToRulesPage = function(page) {
    currentPage = page;
    renderPagination();
    scrollToSectionTop();
  };

  window.prevRulesPage = function() {
    if (currentPage > 1) {
      currentPage--;
      renderPagination();
      scrollToSectionTop();
    }
  };

  window.nextRulesPage = function() {
    var totalMatches = matchedIndices.length;
    var maxPages = (pageSize === -1) ? 1 : Math.ceil(totalMatches / pageSize);
    if (currentPage < maxPages) {
      currentPage++;
      renderPagination();
      scrollToSectionTop();
    }
  };

  window.goToRulesLastPage = function() {
    var totalMatches = matchedIndices.length;
    var maxPages = (pageSize === -1) ? 1 : Math.ceil(totalMatches / pageSize);
    currentPage = maxPages;
    renderPagination();
    scrollToSectionTop();
  };

  function scrollToSectionTop() {
    var sec = document.getElementById('table-rules-section');
    if (sec) {
      var topPos = sec.getBoundingClientRect().top + window.pageYOffset - 70;
      window.scrollTo({ top: topPos, behavior: 'smooth' });
    }
  }

  function renderPagination() {
    var totalMatches = matchedIndices.length;
    var countVisibleEl = document.getElementById('rules-visible-count');
    if (countVisibleEl) {
      countVisibleEl.innerText = totalMatches;
    }

    var emptyStateEl = document.getElementById('rfm-empty-state');
    var paginationBarEl = document.getElementById('rfm-pagination-container');
    var tableEl = document.getElementById('rfm-view-table');
    var cardsEl = document.getElementById('rfm-view-cards');

    if (totalMatches === 0) {
      if (emptyStateEl) emptyStateEl.style.display = 'block';
      if (paginationBarEl) paginationBarEl.style.display = 'none';
      if (tableEl) tableEl.style.display = 'none';
      if (cardsEl) cardsEl.style.display = 'none';
      return;
    } else {
      if (emptyStateEl) emptyStateEl.style.display = 'none';
      if (paginationBarEl) paginationBarEl.style.display = 'flex';
      applyViewMode(currentViewMode);
    }

    var effectivePageSize = (pageSize === -1) ? totalMatches : pageSize;
    var maxPages = Math.max(1, Math.ceil(totalMatches / effectivePageSize));
    if (currentPage > maxPages) currentPage = maxPages;
    if (currentPage < 1) currentPage = 1;

    var startIndex = (currentPage - 1) * effectivePageSize;
    var endIndex = Math.min(startIndex + effectivePageSize, totalMatches);

    // Set of indices to show
    var visibleSet = {};
    for (var k = startIndex; k < endIndex; k++) {
      visibleSet[matchedIndices[k]] = true;
    }

    // Toggle table rows
    for (var r = 0; r < rows.length; r++) {
      if (visibleSet[r]) {
        rows[r].classList.remove('rule-row-hidden');
      } else {
        rows[r].classList.add('rule-row-hidden');
      }
    }

    // Toggle cards
    for (var c = 0; c < cards.length; c++) {
      if (visibleSet[c]) {
        cards[c].classList.remove('rule-card-hidden');
      } else {
        cards[c].classList.add('rule-card-hidden');
      }
    }

    // Update Pagination UI text
    var itemStartEl = document.getElementById('page-item-start');
    var itemEndEl = document.getElementById('page-item-end');
    var itemTotalEl = document.getElementById('page-item-total');
    var pageCurrEl = document.getElementById('page-current');
    var pageMaxEl = document.getElementById('page-max');

    if (itemStartEl) itemStartEl.innerText = (totalMatches === 0) ? 0 : (startIndex + 1);
    if (itemEndEl) itemEndEl.innerText = endIndex;
    if (itemTotalEl) itemTotalEl.innerText = totalMatches;
    if (pageCurrEl) pageCurrEl.innerText = currentPage;
    if (pageMaxEl) pageMaxEl.innerText = maxPages;

    // Prev / Next button states
    var btnFirst = document.getElementById('btn-page-first');
    var btnPrev = document.getElementById('btn-page-prev');
    var btnNext = document.getElementById('btn-page-next');
    var btnLast = document.getElementById('btn-page-last');

    if (btnFirst) btnFirst.disabled = (currentPage <= 1);
    if (btnPrev) btnPrev.disabled = (currentPage <= 1);
    if (btnNext) btnNext.disabled = (currentPage >= maxPages);
    if (btnLast) btnLast.disabled = (currentPage >= maxPages);
  }

})();
</script>
