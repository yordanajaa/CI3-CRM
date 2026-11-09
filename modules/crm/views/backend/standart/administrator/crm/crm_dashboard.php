<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Load Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<style>
:root {
  --crm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.08), 0 2px 6px -1px rgba(0, 0, 0, 0.04);
}

.crm-header-nav {
  background: var(--crm-gradient);
  color: #fff;
  padding: 22px 26px 18px 26px;
  border-radius: 16px;
  margin-bottom: 20px;
  box-shadow: 0 10px 28px rgba(30, 27, 75, 0.22);
  position: relative;
  overflow: hidden;
}
.crm-header-nav::after {
  content: '';
  position: absolute;
  right: -50px; bottom: -50px;
  width: 220px; height: 220px;
  background: rgba(255,255,255,0.04);
  border-radius: 50%;
  pointer-events: none;
}
.crm-header-nav .header-top-flex {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  flex-wrap: wrap;
  gap: 14px;
  margin-bottom: 16px;
  position: relative;
  z-index: 2;
}
.crm-header-nav .location-tag {
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
.crm-header-nav .header-title h2 {
  margin: 0 0 4px 0;
  font-weight: 800;
  font-size: 22px;
  letter-spacing: -0.5px;
  color: #fff;
}
.crm-header-nav .header-title p {
  margin: 0;
  opacity: 0.88;
  font-size: 13px;
  color: #e2e8f0;
}
.crm-header-nav .action-tools {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  align-items: center;
}
.crm-header-nav .action-tools .btn {
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
.crm-header-nav .action-tools .btn:hover { transform: translateY(-2px); }

/* Navigation Tab Bar - Touch Scrollable */
.crm-header-nav .nav-tabs-bar {
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
.crm-header-nav .nav-tabs-bar::-webkit-scrollbar {
  display: none;
}
.crm-header-nav .nav-tab-btn {
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
.crm-header-nav .nav-tab-btn:hover {
  background: rgba(255,255,255,0.25);
  color: #fff;
  transform: translateY(-1px);
}
.crm-header-nav .nav-tab-btn.active {
  background: #ffffff !important;
  color: #312e81 !important;
  border-color: #ffffff !important;
  box-shadow: 0 4px 14px rgba(0,0,0,0.18) !important;
}
.crm-header-nav .nav-tab-btn .active-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #6366f1;
  display: inline-block;
}

/* KPI Cards */
.kpi-card {
  background: #fff;
  border-radius: 12px;
  padding: 18px 20px;
  box-shadow: var(--card-shadow);
  margin-bottom: 20px;
  cursor: pointer;
  transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.22s ease, border-color 0.22s ease;
  position: relative;
  overflow: hidden;
  border: 1px solid rgba(0,0,0,0.04);
  user-select: none;
}
.kpi-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.12);
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
  margin-bottom: 10px;
}
.kpi-card .kpi-value {
  font-size: 22px;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.2;
}
.kpi-card .kpi-label {
  font-size: 11px;
  color: #64748b;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-top: 4px;
}

.kpi-blue .kpi-icon { background: #e0f2fe; color: #0284c7; }
.kpi-purple .kpi-icon { background: #f3e8ff; color: #9333ea; }
.kpi-amber .kpi-icon { background: #fef3c7; color: #d97706; }
.kpi-emerald .kpi-icon { background: #dcfce7; color: #16a34a; }
.kpi-rose .kpi-icon { background: #ffe4e6; color: #e11d48; }

/* Chart Container Cards */
.chart-box {
  background: #fff;
  border-radius: 12px;
  padding: 20px 22px;
  box-shadow: var(--card-shadow);
  margin-bottom: 20px;
  border: 1px solid rgba(0,0,0,0.04);
}
.chart-box .chart-title {
  font-size: 15px;
  font-weight: 800;
  color: #1e293b;
  margin-bottom: 15px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.chart-box .chart-title i {
  margin-right: 8px;
}

/* Custom Leaderboard & List Table */
.leader-table th {
  background: #f8fafc;
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #64748b;
  border-bottom: 2px solid #e2e8f0 !important;
}
.leader-table td {
  vertical-align: middle !important;
  font-size: 12.5px;
}
.avatar-circle {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #6366f1;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 14px;
}

/* Alert badge pills */
.badge-urgent {
  background: #ef4444;
  color: #fff;
  padding: 3px 10px;
  border-radius: 12px;
  font-size: 11px;
  font-weight: 600;
}

/* RFM Card Grid */
.rfm-card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
  gap: 12px;
}
.rfm-dash-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 12px 14px;
  transition: all 0.2s ease;
  position: relative;
  box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.rfm-dash-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0,0,0,0.06);
  border-color: #cbd5e1;
}

/* ===== Animations & Micro-Interactions ===== */
@keyframes crmFadeInUp {
  from {
    opacity: 0;
    transform: translateY(14px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.crm-dash-header, .kpi-card, .chart-box, .rfm-dash-card {
  animation: crmFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease, border-color 0.25s ease;
}

.btn:active {
  transform: scale(0.97) !important;
}

.table-responsive {
  -webkit-overflow-scrolling: touch;
  scrollbar-width: thin;
  scrollbar-color: #cbd5e1 #f8fafc;
}

@media (max-width: 991px) {
  .crm-header-nav { padding: 18px 20px; }
}

@media (max-width: 767px) {
  .content { padding: 8px 8px !important; }
  .crm-header-nav { padding: 16px 14px; border-radius: 12px; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; }
  .crm-header-nav .header-title h2 { font-size: 18px; }
  .crm-header-nav .header-title p { font-size: 11.5px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn, .crm-header-nav .action-tools > a { font-size: 11px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
  .crm-header-nav .nav-tabs-bar { padding-top: 10px; gap: 6px; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
  .crm-header-nav .nav-tab-btn { padding: 7px 12px; font-size: 11.5px; }
  
  .kpi-card { padding: 12px 14px; margin-bottom: 10px; border-radius: 10px; }
  .kpi-card .kpi-icon { width: 36px; height: 36px; font-size: 16px; margin-bottom: 6px; }
  .kpi-card .kpi-value { font-size: 17px; }
  .kpi-card .kpi-label { font-size: 9.5px; }
  
  .chart-box { padding: 14px 12px; margin-bottom: 14px; border-radius: 10px; }
  .chart-box .chart-title { font-size: 13px; flex-direction: column; align-items: flex-start; gap: 4px; }
  
  .leader-table th { font-size: 10px; padding: 6px 4px !important; }
  .leader-table td { font-size: 11.5px; padding: 8px 4px !important; }
  .avatar-circle { width: 28px; height: 28px; font-size: 11px; margin-right: 6px !important; }
}

@media (max-width: 575px) {
  .kpi-card .kpi-value { font-size: 15px; }
  .kpi-card .kpi-label { font-size: 9px; }
  .rfm-card-grid { grid-template-columns: 1fr; }
}
</style>

<section class="content" style="padding-top:15px;">
  <!-- Header Banner & Navigation -->
  <div class="crm-header-nav">
    <!-- Top Row: Title, Subtitle & Action Tools -->
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> CRM & After Sales <i class="fa fa-angle-right"></i> <span>Dashboard Utama</span>
        </div>
        <h2><i class="fa fa-tachometer" style="color:#818cf8;"></i> Dashboard Performa CRM & After Sales</h2>
        <p>Pantau keterlibatan pelanggan, tren pengiriman follow-up, repeat order rate, dan performa tim CS secara real-time.</p>
      </div>

      <div class="action-tools">
        <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn" style="background:#25D366; color:#fff;" title="Broadcast WA"><i class="fa fa-bullhorn"></i> Broadcast WA</a>
        <a href="<?= site_url('administrator/rfm/dashboard'); ?>" class="btn" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-bar-chart"></i> Analisis RFM</a>
      </div>
    </div>

    <!-- Bottom Row: Navigation Tabs Bar -->
    <div class="nav-tabs-bar">
      <a href="<?= site_url('administrator/crm/dashboard'); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-tachometer"></i> 1. Dashboard CRM
      </a>
      <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="nav-tab-btn">
        <i class="fa fa-tasks"></i> 2. Journal Follow-Up
      </a>
      <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="nav-tab-btn">
        <i class="fa fa-whatsapp"></i> 3. Broadcast WA
      </a>
      <a href="<?= site_url('administrator/crm'); ?>" class="nav-tab-btn">
        <i class="fa fa-users"></i> 4. Customer Directory
      </a>
      <a href="<?= site_url('administrator/crm/cs_performance'); ?>" class="nav-tab-btn">
        <i class="fa fa-trophy"></i> 5. Kinerja Tim CS
      </a>
      <a href="<?= site_url('administrator/crm/followup_setting'); ?>" class="nav-tab-btn">
        <i class="fa fa-cogs"></i> 6. Kelompok Follow-Up
      </a>
    </div>
  </div>

  <!-- KPI Cards Row -->
  <div class="row">
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="kpi-card kpi-blue" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/crm/customer_list'); ?>';" title="Klik untuk membuka Customer Directory">
        <div class="kpi-icon"><i class="fa fa-users"></i></div>
        <div class="kpi-value"><?= number_format($kpis['total_customers']); ?></div>
        <div class="kpi-label">Total Pelanggan &rarr;</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-6">
      <div class="kpi-card kpi-emerald" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm/tracking'); ?>';" title="Klik untuk melihat riwayat volume transaksi di Tracking Bulanan">
        <div class="kpi-icon"><i class="fa fa-money"></i></div>
        <div class="kpi-value">Rp <?= number_format($kpis['total_spend'], 0, ',', '.'); ?></div>
        <div class="kpi-label">Total Volume Transaksi &rarr;</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="kpi-card kpi-purple" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/rfm/cohort'); ?>';" title="Klik untuk melihat analisis retensi kohort">
        <div class="kpi-icon"><i class="fa fa-refresh"></i></div>
        <div class="kpi-value"><?= $kpis['repeat_rate']; ?>%</div>
        <div class="kpi-label">Repeat Order Rate &rarr;</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="kpi-card kpi-amber" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/crm/journal_followup'); ?>';" title="Klik untuk melihat jadwal follow-up pelanggan pending">
        <div class="kpi-icon"><i class="fa fa-clock-o"></i></div>
        <div class="kpi-value"><?= $kpis['pending_today']; ?> <small style="font-size:12px;color:#d97706;">(<?= $kpis['overdue']; ?> late)</small></div>
        <div class="kpi-label">Pending Hari Ini &rarr;</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
      <div class="kpi-card kpi-rose" role="button" tabindex="0" onclick="window.location.href='<?= site_url('administrator/crm/broadcast'); ?>';" title="Klik untuk membuka riwayat broadcast WA">
        <div class="kpi-icon"><i class="fa fa-paper-plane"></i></div>
        <div class="kpi-value"><?= number_format($kpis['total_broadcast']); ?></div>
        <div class="kpi-label">WA Broadcast Terkirim &rarr;</div>
      </div>
    </div>
  </div>

  <!-- RFM Link Card (now in separate module) -->
  <div class="row">
    <div class="col-md-12">
      <div class="chart-box" style="border-top: 4px solid #6366f1; background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
          <div style="display:flex; align-items:center; gap:14px;">
            <div style="width:52px; height:52px; border-radius:12px; background:#6366f1; color:#fff; display:flex; align-items:center; justify-content:center; font-size:22px;">
              <i class="fa fa-bar-chart"></i>
            </div>
            <div>
              <div style="font-size:17px; font-weight:800; color:#1e1b4b;">Analisis RFM Pelanggan</div>
              <div style="font-size:12.5px; color:#475569;">Lihat segmentasi lengkap Recency, Frequency, Monetary di modul terpisah</div>
            </div>
          </div>
          <div>
            <a href="<?= site_url('administrator/rfm/dashboard'); ?>" class="btn btn-sm" style="background:#6366f1; color:#fff; border:none; font-weight:600; border-radius:8px; padding:8px 18px; margin-right:6px;"><i class="fa fa-tachometer"></i> Dashboard RFM</a>
            <a href="<?= site_url('administrator/rfm'); ?>" class="btn btn-sm" style="background:#fff; color:#312e81; border:1px solid #c7d2fe; font-weight:600; border-radius:8px; padding:8px 18px;"><i class="fa fa-users"></i> Daftar Customer RFM</a>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Charts Row 1 -->
  <div class="row">
    <!-- Trend Follow-Up (15 Hari) -->
    <div class="col-md-8">
      <div class="chart-box">
        <div class="chart-title">
          <span><i class="fa fa-line-chart text-indigo" style="color:#6366f1;"></i> Tren Tugas Follow-Up vs WA Broadcast Terkirim</span>
          <small class="text-muted">15 Hari Terakhir</small>
        </div>
        <div style="height: 280px; position: relative;">
          <canvas id="chartTrend"></canvas>
        </div>
      </div>
    </div>

    <!-- Distribusi Sumber Penjualan -->
    <div class="col-md-4">
      <div class="chart-box">
        <div class="chart-title">
          <span><i class="fa fa-pie-chart" style="color:#0ea5e9;"></i> Customer per Channel</span>
        </div>
        <div style="height: 280px; position: relative;">
          <canvas id="chartChannels"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Row 2 & Leaderboards -->
  <div class="row">
    <!-- Breakdown Status Follow-Up per Kategori -->
    <div class="col-md-6">
      <div class="chart-box">
        <div class="chart-title">
          <span><i class="fa fa-bar-chart" style="color:#8b5cf6;"></i> Status Follow-Up per Kategori H+</span>
        </div>
        <div style="height: 280px; position: relative;">
          <canvas id="chartCategoryStatus"></canvas>
        </div>
      </div>
    </div>

    <!-- Top 5 Champions (Repeat Order Leaders) -->
    <div class="col-md-6">
      <div class="chart-box">
        <div class="chart-title">
          <span><i class="fa fa-trophy" style="color:#eab308;"></i> Top 5 Pelanggan Repeat Order</span>
          <a href="<?= site_url('administrator/crm'); ?>" class="btn btn-xs btn-default">Lihat Semua</a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover leader-table" style="margin:0;">
            <thead>
              <tr>
                <th>Pelanggan</th>
                <th>Sumber</th>
                <th class="text-center">Total Order</th>
                <th>Order Terakhir</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($top_repeat)): ?>
              <tr><td colspan="5" class="text-center text-muted">Belum ada data pelanggan.</td></tr>
              <?php else: foreach ($top_repeat as $tr): ?>
              <tr>
                <td>
                  <div style="display:flex; align-items:center;">
                    <div class="avatar-circle" style="margin-right:10px; background: <?= sprintf('#%06X', mt_rand(0, 0xFFFFFF)); ?>;">
                      <?= strtoupper(substr($tr->customer_nama, 0, 1)); ?>
                    </div>
                    <div>
                      <strong><?= htmlspecialchars($tr->customer_nama); ?></strong><br>
                      <small class="text-muted"><?= htmlspecialchars($tr->customer_phone); ?></small>
                    </div>
                  </div>
                </td>
                <td><small><?= htmlspecialchars($tr->sources); ?></small></td>
                <td class="text-center">
                  <span class="badge" style="background:#6366f1; font-size:12px; font-weight:700;"><?= $tr->total_orders; ?>x Order</span>
                </td>
                <td><small><?= date('d/m/Y', strtotime($tr->last_order)); ?></small></td>
                <td class="text-center">
                  <a href="<?= site_url('administrator/crm/customer_detail?phone=' . urlencode($tr->customer_phone)); ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> Detail</a>
                </td>
              </tr>
              <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Urgent Action Alerts & Activity Feed Row -->
  <div class="row">
    <!-- Urgent Action List -->
    <div class="col-md-6">
      <div class="chart-box" style="border-left: 4px solid #ef4444;">
        <div class="chart-title text-danger">
          <span><i class="fa fa-exclamation-triangle"></i> Membutuhkan Perhatian CS Segera</span>
          <span class="badge badge-urgent"><?= count($urgent_alerts); ?> Item</span>
        </div>
        <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
          <table class="table table-hover table-condensed" style="font-size:12px; margin:0;">
            <thead>
              <tr style="background:#fff5f5;">
                <th>Customer</th>
                <th>Kategori</th>
                <th>Target Tgl</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($urgent_alerts)): ?>
              <tr><td colspan="5" class="text-center text-muted" style="padding:20px;"><i class="fa fa-check-circle text-success"></i> Tidak ada komplain / overdue urgent saat ini!</td></tr>
              <?php else: foreach ($urgent_alerts as $ua): ?>
              <tr>
                <td><strong><?= htmlspecialchars($ua->customer_nama); ?></strong><br><small><?= htmlspecialchars($ua->customer_phone); ?></small></td>
                <td><span class="label label-info"><?= htmlspecialchars($ua->nama_kategori); ?></span></td>
                <td><span style="color:#ef4444; font-weight:700;"><?= date('d/m/Y', strtotime($ua->tanggal_label_muncul)); ?></span></td>
                <td>
                  <span class="label label-danger"><?= $ua->status_label; ?></span>
                </td>
                <td class="text-center">
                  <a href="<?= site_url('administrator/crm/journal_followup?q=' . urlencode($ua->customer_phone)); ?>" class="btn btn-xs btn-warning"><i class="fa fa-share"></i> Follow Up</a>
                </td>
              </tr>
              <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Recent Activity Feed -->
    <div class="col-md-6">
      <div class="chart-box">
        <div class="chart-title">
          <span><i class="fa fa-history" style="color:#10b981;"></i> Aktivitas CS & Broadcast Terbaru</span>
        </div>
        <div style="max-height: 250px; overflow-y: auto; padding-right: 5px;">
          <?php if (empty($recent_activities)): ?>
          <p class="text-center text-muted" style="padding:20px;">Belum ada riwayat aktivitas terbaru.</p>
          <?php else: foreach ($recent_activities as $act): ?>
          <div style="display:flex; align-items:flex-start; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size:12px;">
            <div style="margin-right:12px; font-size:16px; color: <?= $act->type === 'broadcast' ? '#22c55e' : '#3b82f6'; ?>;">
              <i class="fa <?= $act->type === 'broadcast' ? 'fa-whatsapp' : 'fa-commenting-o'; ?>"></i>
            </div>
            <div style="flex:1;">
              <strong><?= htmlspecialchars($act->user); ?></strong> <?= $act->type === 'broadcast' ? 'mengirim WA' : 'menambahkan catatan'; ?> ke <strong><?= htmlspecialchars($act->customer_nama); ?></strong>
              <div style="color:#64748b; font-size:11px; margin-top:2px;"><?= htmlspecialchars(mb_strimwidth($act->detail, 0, 80, '...')); ?></div>
            </div>
            <div style="font-size:10px; color:#94a3b8; white-space:nowrap; margin-left:10px;">
              <?= date('d/m H:i', strtotime($act->waktu)); ?>
            </div>
          </div>
          <?php endforeach; endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Chart.js Logic -->
<script>
$(document).ready(function() {
  // Chart 1: Trend
  var trendData = <?= json_encode($trend); ?>;
  var ctxTrend = document.getElementById('chartTrend').getContext('2d');
  new Chart(ctxTrend, {
    type: 'line',
    data: {
      labels: trendData.dates,
      datasets: [
        {
          label: 'Target Follow-Up Label',
          data: trendData.labels,
          borderColor: '#6366f1',
          backgroundColor: 'rgba(99, 102, 241, 0.1)',
          tension: 0.3,
          fill: true,
          pointRadius: 4
        },
        {
          label: 'WA Broadcast Terkirim',
          data: trendData.broadcast,
          borderColor: '#22c55e',
          backgroundColor: 'rgba(34, 197, 94, 0.1)',
          tension: 0.3,
          fill: true,
          pointRadius: 4
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'top' } },
      scales: { y: { beginAtZero: true } }
    }
  });

  // Chart 2: Channels
  var channelData = <?= json_encode($channels); ?>;
  var ctxChannels = document.getElementById('chartChannels').getContext('2d');
  new Chart(ctxChannels, {
    type: 'doughnut',
    data: {
      labels: Object.keys(channelData),
      datasets: [{
        data: Object.values(channelData),
        backgroundColor: ['#1e293b', '#ee4d2d', '#42b549', '#010101'],
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom' } }
    }
  });

  // Chart 3: Category Status Breakdown
  var catStatusData = <?= json_encode($category_status); ?>;
  var catLabels = catStatusData.map(function(item) { return item.kategori; });
  var dataPending = catStatusData.map(function(item) { return item.pending; });
  var dataDikirim = catStatusData.map(function(item) { return item.dikirim; });
  var dataSelesai = catStatusData.map(function(item) { return item.selesai; });

  var ctxCatStatus = document.getElementById('chartCategoryStatus').getContext('2d');
  new Chart(ctxCatStatus, {
    type: 'bar',
    data: {
      labels: catLabels,
      datasets: [
        { label: 'Pending', data: dataPending, backgroundColor: '#f59e0b' },
        { label: 'Dikirim/Direspon', data: dataDikirim, backgroundColor: '#3b82f6' },
        { label: 'Selesai', data: dataSelesai, backgroundColor: '#10b981' }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'top' } },
      scales: { x: { stacked: true }, y: { stacked: true, beginAtZero: true } }
    }
  });

  // Chart 4: RFM Segment Distribution
  var rfmData = <?= json_encode(!empty($rfm_distribution) ? $rfm_distribution : []); ?>;
  if (rfmData && rfmData.length > 0) {
    var rfmLabels = rfmData.map(function(item) { return item.segment; });
    var rfmCounts = rfmData.map(function(item) { return item.count; });
    var rfmColors = rfmData.map(function(item) { return item.badge ? item.badge.bg : '#6366f1'; });

    var ctxRfm = document.getElementById('chartRfmDistribution').getContext('2d');
    new Chart(ctxRfm, {
      type: 'doughnut',
      data: {
        labels: rfmLabels,
        datasets: [{
          data: rfmCounts,
          backgroundColor: rfmColors,
          borderWidth: 2,
          borderColor: '#ffffff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { boxWidth: 10, font: { size: 10 } }
          }
        }
      }
    });
  }
});
</script>
