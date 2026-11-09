<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
@keyframes crmFadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}

:root {
  --crm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
}

.crm-header-nav {
  background: var(--crm-gradient);
  color: #fff;
  padding: 24px 28px 20px 28px;
  border-radius: 16px;
  margin-bottom: 24px;
  box-shadow: 0 12px 30px rgba(30, 27, 75, 0.25);
  position: relative;
  overflow: hidden;
  animation: crmFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
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
  gap: 16px;
  margin-bottom: 18px;
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
  font-size: 24px;
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
  padding: 7px 14px;
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

.stat-card {
  background: #fff;
  border-radius: 10px;
  padding: 18px 20px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.06);
  text-align: center;
  margin-bottom: 15px;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  animation: crmFadeInUp 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}
.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}
.stat-card .num { font-size: 26px; font-weight: 800; }
.stat-card .lbl { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }

.box {
  animation: crmFadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
  border-radius: 10px !important;
}
.table-responsive {
  -webkit-overflow-scrolling: touch;
}
.sc-emerald .num { color: #059669; }
.sc-blue .num { color: #2563eb; }
.sc-amber .num { color: #d97706; }
.sc-purple .num { color: #7c3aed; }
.sc-rose .num { color: #e11d48; }

.table-cs th { background: #f8fafc; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; }
.table-cs td { font-size: 13px; vertical-align: middle !important; }

.trophy-gold { color: #f59e0b; font-size: 16px; }
.trophy-silver { color: #94a3b8; font-size: 16px; }
.trophy-bronze { color: #d97706; font-size: 16px; }

.cs-chart-wrapper {
  position: relative;
  width: 100%;
  height: 280px;
}
.cs-pie-wrapper {
  position: relative;
  width: 100%;
  height: 280px;
}

@media (max-width: 991px) {
  .crm-header-nav { padding: 16px 16px 12px 16px; margin-bottom: 12px; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 12px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn { font-size: 11px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
}

@media (max-width: 767px) {
  .content { padding: 8px 6px !important; }
  .crm-header-nav { padding: 14px 12px 10px 12px; border-radius: 12px; margin-bottom: 12px; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 10px; }
  .crm-header-nav .header-title h2 { font-size: 18px; }
  .crm-header-nav .header-title p { font-size: 11px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn { font-size: 10.5px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
  .crm-header-nav .nav-tabs-bar { gap: 6px; padding-top: 10px; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
  .crm-header-nav .nav-tab-btn { font-size: 11.5px; padding: 6px 12px; }

  .stat-card { padding: 12px 10px; margin-bottom: 8px; border-radius: 8px; }
  .stat-card .num { font-size: 17px; }
  .stat-card .lbl { font-size: 9px; }

  .box-body { padding: 10px !important; }
  .box-header .box-title { font-size: 12px; }
  .form-control { font-size: 12px; }

  .table-responsive { border: none !important; margin-bottom: 0; -webkit-overflow-scrolling: touch; }
  .table-cs { min-width: 820px; }
  .table-cs th { font-size: 9.5px; padding: 6px 4px !important; white-space: nowrap; }
  .table-cs td { font-size: 10.5px; padding: 6px 4px !important; }
  .table-cs .badge, .table-cs .label { font-size: 9.5px !important; padding: 2px 6px !important; }
  .table-cs td[style*="font-size:14px"] { font-size: 11px !important; }

  .cs-chart-wrapper { height: 290px; }
  .cs-pie-wrapper { height: 270px; }
}

@media (max-width: 480px) {
  .crm-header-nav .header-title h2 { font-size: 15px; }
  .crm-header-nav .action-tools { flex-direction: column; width: 100%; }
  .crm-header-nav .action-tools .btn, .crm-header-nav .action-tools a { width: 100%; }
  .stat-card .num { font-size: 15px; }
  .table-cs th, .table-cs td { font-size: 9px; padding: 5px 3px !important; }
}
</style>

<section class="content" style="padding-top:15px;">
  <!-- Integrated Header Banner & Navigation -->
  <div class="crm-header-nav">
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> CRM & After Sales <i class="fa fa-angle-right"></i> <span>Performa CS</span>
        </div>
        <h2><i class="fa fa-line-chart" style="color:#818cf8;"></i> Performa & Produksi Repeat Order Tim CS</h2>
        <p>Pantau jumlah handling follow-up, broadcast WA terkirim, respon positif customer, serta omset repeat order per CS</p>
      </div>

      <div class="action-tools">
        <a href="<?= site_url('administrator/crm/export_cs_performance?' . http_build_query($_GET)); ?>" class="btn btn-success" style="background:#10b981; color:#fff;" title="Export Laporan CSV"><i class="fa fa-file-excel-o"></i> Export CSV</a>
        <a href="<?= site_url('administrator/crm/export_cs_performance_pdf?' . http_build_query($_GET)); ?>" target="_blank" class="btn btn-danger" style="background:#ef4444; color:#fff;" title="Export Laporan PDF"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
        <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="btn" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-tasks"></i> Journal Follow-Up</a>
      </div>
    </div>

    <!-- Bottom Row: Navigation Tabs Bar -->
    <div class="nav-tabs-bar">
      <a href="<?= site_url('administrator/crm/dashboard'); ?>" class="nav-tab-btn">
        <i class="fa fa-tachometer"></i> 1. Dashboard CRM
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
      <a href="<?= site_url('administrator/crm/cs_performance'); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-trophy"></i> 5. Kinerja Tim CS
      </a>
      <a href="<?= site_url('administrator/crm/followup_setting'); ?>" class="nav-tab-btn">
        <i class="fa fa-cogs"></i> 6. Kelompok Follow-Up
      </a>
    </div>
  </div>

  <!-- Filter Bar -->
  <div class="box box-default" style="margin-bottom: 15px;">
    <div class="box-body" style="padding:12px 20px;">
      <form method="get" action="<?= site_url('administrator/crm/cs_performance'); ?>">
        <div class="row">
          <div class="col-md-4">
            <label style="font-size:12px;color:#64748b;">Dari Tanggal:</label>
            <input type="date" name="date_from" class="form-control input-sm" value="<?= $filters['date_from'] ?? ''; ?>">
          </div>
          <div class="col-md-4">
            <label style="font-size:12px;color:#64748b;">Sampai Tanggal:</label>
            <input type="date" name="date_to" class="form-control input-sm" value="<?= $filters['date_to'] ?? ''; ?>">
          </div>
          <div class="col-md-4" style="padding-top: 23px;">
            <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-filter"></i> Filter Periode</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- KPI Overview Cards -->
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="stat-card sc-blue">
        <div class="num"><?= $kpis['total_cs_active']; ?> CS</div>
        <div class="lbl">Tim CS Aktif</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="stat-card sc-purple">
        <div class="num"><?= number_format($kpis['total_handled']); ?></div>
        <div class="lbl">Total Follow-Up Handled</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="stat-card sc-emerald">
        <div class="num">Rp <?= number_format($kpis['total_revenue'], 0, ',', '.'); ?></div>
        <div class="lbl">Total Omset Repeat Order</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="stat-card sc-amber">
        <div class="num"><?= $kpis['avg_conversion_rate']; ?>%</div>
        <div class="lbl">Rata-Rata Conversion Rate</div>
      </div>
    </div>
  </div>

  <!-- Charts Row -->
  <div class="row">
    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-bar-chart text-emerald"></i> Perbandingan Omset Repeat Order per CS (Rp)</h3>
        </div>
        <div class="box-body" style="padding: 12px 10px;">
          <div class="cs-chart-wrapper">
            <canvas id="chart-cs-revenue"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-pie-chart text-purple"></i> Distribusi Handling Follow-Up</h3>
        </div>
        <div class="box-body" style="padding: 12px 10px;">
          <div class="cs-pie-wrapper">
            <canvas id="chart-cs-handled"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Leaderboard Table per CS -->
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-trophy text-warning"></i> Leaderboard & Performa Tim CS</h3>
    </div>
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover table-striped table-cs">
        <thead>
          <tr>
            <th style="width:50px;" class="text-center">Rank</th>
            <th>Operator CS</th>
            <th class="text-center">Follow-Up Handled</th>
            <th class="text-center">Broadcast WA</th>
            <th class="text-center">Respon Positif</th>
            <th class="text-center">Komplain</th>
            <th class="text-center">Repeat Order Konversi</th>
            <th class="text-right">Total Omset Konversi (Rp)</th>
            <th class="text-center" style="width:140px;">Conversion Rate</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($report)): ?>
          <tr><td colspan="9" class="text-center" style="padding:40px; color:#94a3b8;"><i class="fa fa-user-times fa-2x"></i><br>Belum ada aktivitas CS pada periode ini.</td></tr>
          <?php else: $rank = 1; foreach ($report as $r): ?>
          <tr>
            <td class="text-center">
              <?php if ($rank === 1): ?><i class="fa fa-trophy trophy-gold" title="Juara 1"></i>
              <?php elseif ($rank === 2): ?><i class="fa fa-trophy trophy-silver" title="Juara 2"></i>
              <?php elseif ($rank === 3): ?><i class="fa fa-trophy trophy-bronze" title="Juara 3"></i>
              <?php else: ?><strong>#<?= $rank; ?></strong>
              <?php endif; ?>
            </td>
            <td>
              <i class="fa fa-user-circle" style="color:#6366f1;"></i> <strong><?= htmlspecialchars($r->cs_name); ?></strong>
            </td>
            <td class="text-center"><strong><?= number_format($r->total_handled); ?></strong> item</td>
            <td class="text-center"><span class="badge" style="background:#25D366;font-size:11px;"><?= number_format($r->broadcast_count); ?> WA</span></td>
            <td class="text-center"><span class="label label-success" style="font-size:11px;"><?= number_format($r->respon_positif); ?></span></td>
            <td class="text-center"><span class="label label-danger" style="font-size:11px;"><?= number_format($r->komplain_count); ?></span></td>
            <td class="text-center">
              <span class="badge" style="background:#059669; font-size:12px; font-weight:700;">
                <?= number_format($r->conversion_count); ?> order
              </span>
            </td>
            <td class="text-right" style="color:#059669; font-weight:800; font-size:14px;">
              Rp <?= number_format($r->conversion_amount, 0, ',', '.'); ?>
            </td>
            <td class="text-center">
              <div style="font-size:11px; font-weight:700; color:#3b82f6; margin-bottom:2px;"><?= $r->conversion_rate; ?>%</div>
              <div class="progress progress-xs" style="margin:0; background:#e2e8f0; height:6px;">
                <div class="progress-bar progress-bar-success" style="width: <?= min(100, $r->conversion_rate); ?>%"></div>
              </div>
            </td>
          </tr>
          <?php $rank++; endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
$(document).ready(function() {
  var csData = <?= json_encode($report); ?>;
  var labels = [];
  var revenues = [];
  var handleds = [];
  var colors = ['#059669', '#2563eb', '#7c3aed', '#d97706', '#e11d48', '#0891b2', '#4f46e5'];

  $.each(csData, function(i, r) {
    labels.push(r.cs_name);
    revenues.push(r.conversion_amount);
    handleds.push(r.total_handled);
  });

  // Revenue Bar Chart
  var ctxBar = document.getElementById('chart-cs-revenue').getContext('2d');
  new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Omset Konversi (Rp)',
        data: revenues,
        backgroundColor: '#059669',
        hoverBackgroundColor: '#047857',
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: { display: false },
      layout: {
        padding: {
          left: 5,
          right: 15,
          top: 15,
          bottom: 5
        }
      },
      tooltips: {
        backgroundColor: '#1e293b',
        titleFontSize: 12,
        bodyFontSize: 12,
        xPadding: 10,
        yPadding: 8,
        displayColors: false,
        callbacks: {
          label: function(tooltipItem, data) {
            var val = Number(tooltipItem.yLabel || 0);
            return 'Omset: Rp ' + val.toLocaleString('id-ID');
          }
        }
      },
      scales: {
        xAxes: [{
          gridLines: { display: false },
          ticks: {
            autoSkip: false,
            maxRotation: 45,
            minRotation: 25,
            fontSize: 10,
            fontColor: '#64748b',
            callback: function(value) {
              if (typeof value === 'string' && value.length > 13) {
                return value.substring(0, 11) + '..';
              }
              return value;
            }
          }
        }],
        yAxes: [{
          gridLines: {
            color: '#f1f5f9',
            zeroLineColor: '#cbd5e1'
          },
          ticks: {
            beginAtZero: true,
            maxTicksLimit: 5,
            autoSkip: true,
            fontSize: 10,
            fontColor: '#64748b',
            padding: 6,
            callback: function(value) {
              if (value === 0) return 'Rp 0';
              if (value >= 1000000000) {
                var b = value / 1000000000;
                return 'Rp ' + (b % 1 === 0 ? b.toFixed(0) : b.toFixed(1)) + ' M';
              }
              if (value >= 1000000) {
                var m = value / 1000000;
                return 'Rp ' + (m % 1 === 0 ? m.toFixed(0) : m.toFixed(1)) + ' Jt';
              }
              if (value >= 1000) {
                var k = value / 1000;
                return 'Rp ' + (k % 1 === 0 ? k.toFixed(0) : k.toFixed(1)) + ' Rb';
              }
              return 'Rp ' + Number(value).toLocaleString('id-ID');
            }
          }
        }]
      }
    }
  });

  // Handled Doughnut Chart
  var ctxPie = document.getElementById('chart-cs-handled').getContext('2d');
  new Chart(ctxPie, {
    type: 'doughnut',
    data: {
      labels: labels,
      datasets: [{
        data: handleds,
        backgroundColor: colors.slice(0, labels.length)
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        position: 'bottom',
        labels: {
          boxWidth: 12,
          fontSize: 10.5,
          padding: 8
        }
      },
      tooltips: {
        backgroundColor: '#1e293b',
        callbacks: {
          label: function(tooltipItem, data) {
            var idx = tooltipItem.index;
            var label = data.labels[idx] || '';
            var val = data.datasets[0].data[idx] || 0;
            return label + ': ' + Number(val).toLocaleString('id-ID') + ' item';
          }
        }
      }
    }
  });
});
</script>
