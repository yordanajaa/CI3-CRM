<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
@keyframes crmFadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}

.crm-header {
  background: linear-gradient(135deg, #065f46 0%, #047857 50%, #059669 100%);
  color: #fff;
  padding: 25px 30px;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: 0 10px 25px rgba(4, 120, 87, 0.2);
  animation: crmFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.crm-header h2 { margin: 0 0 5px 0; font-weight: 800; font-size: 22px; }
.crm-header p { margin: 0; opacity: 0.85; font-size: 13px; }

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

@media (max-width: 767px) {
  .content { padding: 10px 8px !important; }
  .crm-header { padding: 16px 14px; text-align: center; border-radius: 10px; margin-bottom: 14px; }
  .crm-header h2 { font-size: 17px; }
  .crm-header p { font-size: 11px; }
  .crm-header .text-right { text-align: center !important; margin-top: 10px; }
  .crm-header .text-right .btn { font-size: 10.5px; padding: 5px 10px; margin-bottom: 4px; }

  .stat-card { padding: 12px 10px; margin-bottom: 8px; border-radius: 8px; }
  .stat-card .num { font-size: 18px; }
  .stat-card .lbl { font-size: 9px; }

  .box-body { padding: 10px !important; }
  .box-header .box-title { font-size: 12px; }
  .form-control { font-size: 12px; }

  .table-cs th { font-size: 9.5px; padding: 6px 3px !important; white-space: nowrap; }
  .table-cs td { font-size: 10.5px; padding: 6px 3px !important; }
  .table-cs .badge, .table-cs .label { font-size: 9.5px !important; padding: 2px 6px !important; }
  .table-cs td[style*="font-size:14px"] { font-size: 11px !important; }
}

@media (max-width: 480px) {
  .crm-header h2 { font-size: 15px; }
  .crm-header .text-right { display: flex; flex-direction: column; gap: 4px; }
  .crm-header .text-right .btn, .crm-header .text-right a { width: 100%; }
  .stat-card .num { font-size: 16px; }
  .table-cs th, .table-cs td { font-size: 9px; padding: 5px 2px !important; }
}
</style>

<section class="content" style="padding-top:15px;">
  <!-- Header Banner -->
  <div class="crm-header">
    <div class="row" style="align-items:center;">
      <div class="col-md-8">
        <h2><i class="fa fa-line-chart"></i> Performa & Produksi Repeat Order Tim CS</h2>
        <p>Pantau jumlah handling follow-up, broadcast WA terkirim, respon positif customer, serta omset repeat order yang berhasil dikonversi oleh setiap CS.</p>
      </div>
      <div class="col-md-4 text-right" style="padding-top: 10px;">
        <a href="<?= site_url('administrator/crm/export_cs_performance?' . http_build_query($_GET)); ?>" class="btn btn-sm btn-success" title="Export Laporan CSV"><i class="fa fa-file-excel-o"></i> Export CSV</a>
        <a href="<?= site_url('administrator/crm/export_cs_performance_pdf?' . http_build_query($_GET)); ?>" target="_blank" class="btn btn-sm btn-danger" title="Export Laporan PDF"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
        <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="btn btn-sm" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-tasks"></i> Journal Follow-Up</a>
      </div>
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
    <div class="col-md-3 col-sm-6">
      <div class="stat-card sc-blue">
        <div class="num"><?= $kpis['total_cs_active']; ?> CS</div>
        <div class="lbl">Tim CS Aktif</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="stat-card sc-purple">
        <div class="num"><?= number_format($kpis['total_handled']); ?></div>
        <div class="lbl">Total Follow-Up Handled</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="stat-card sc-emerald">
        <div class="num">Rp <?= number_format($kpis['total_revenue'], 0, ',', '.'); ?></div>
        <div class="lbl">Total Omset Repeat Order</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
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
        <div class="box-body">
          <canvas id="chart-cs-revenue" height="120"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-pie-chart text-purple"></i> Distribusi Handling Follow-Up</h3>
        </div>
        <div class="box-body">
          <canvas id="chart-cs-handled" height="250"></canvas>
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
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      legend: { display: false },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            callback: function(value) { return 'Rp ' + (value/1000000).toFixed(1) + 'M'; }
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
      legend: { position: 'bottom' }
    }
  });
});
</script>
