<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<style>
/* Modern Styling System for RFM Tracking Page */
.rfm-tracking-wrapper {
  padding: 10px 0 30px 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}
.tracking-header-card {
  background: linear-gradient(135deg, #064e3b 0%, #047857 40%, #059669 100%);
  border-radius: 16px;
  padding: 24px 28px;
  color: #ffffff;
  box-shadow: 0 10px 25px rgba(4, 120, 87, 0.25);
  margin-bottom: 20px;
  position: relative;
  overflow: hidden;
}
.tracking-header-card::after {
  content: '';
  position: absolute;
  right: -20px;
  bottom: -30px;
  width: 180px;
  height: 180px;
  background: rgba(255, 255, 255, 0.06);
  border-radius: 50%;
  pointer-events: none;
}
.tracking-title {
  margin: 0 0 6px 0;
  font-weight: 800;
  font-size: 22px;
  color: #ffffff;
  display: flex;
  align-items: center;
  gap: 10px;
}
.tracking-subtitle {
  margin: 0;
  font-size: 13.5px;
  color: #a7f3d0;
  line-height: 1.5;
}
.kpi-mini-card {
  background: #ffffff;
  border-radius: 14px;
  padding: 18px 20px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
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
  font-size: 11.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-top: 4px;
}
.section-card-custom {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
  padding: 22px;
  margin-bottom: 22px;
}
.table-tracking {
  margin-bottom: 0;
}
.table-tracking th {
  background: #f8fafc;
  color: #334155;
  font-size: 12.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.3px;
  padding: 12px 14px !important;
  border-bottom: 2px solid #e2e8f0 !important;
  vertical-align: middle !important;
}
.table-tracking td {
  padding: 14px !important;
  vertical-align: middle !important;
  border-top: 1px solid #f1f5f9 !important;
  font-size: 13px;
}
.table-tracking tr:hover {
  background-color: #f8fafc !important;
}
</style>

<div class="rfm-tracking-wrapper">
  <!-- Header Banner -->
  <div class="tracking-header-card">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px; position:relative; z-index:2;">
      <div>
        <h2 class="tracking-title">
          <i class="fa fa-line-chart" style="color:#6ee7b7; font-size:26px;"></i>
          Tracking & Tren RFM Bulanan
        </h2>
        <p class="tracking-subtitle">
          Rekapitulasi historis omset (monetary), frekuensi order, dan pembeli unik per bulan <?= !empty($product_filter) ? 'untuk produk: <strong>' . htmlspecialchars($product_filter) . '</strong>' : '(Seluruh Produk)'; ?>
        </p>
      </div>

      <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
        <a href="<?= site_url('administrator/rfm/dashboard'); ?>" class="btn" style="background:rgba(255,255,255,0.15); color:#fff; font-weight:700; border-radius:10px; padding:9px 16px; border:1px solid rgba(255,255,255,0.3); transition:all 0.2s;">
          <i class="fa fa-tachometer"></i> Dashboard RFM
        </a>
        <a href="<?= site_url('administrator/rfm'); ?>" class="btn" style="background:#ffffff; color:#047857; font-weight:700; border-radius:10px; padding:9px 18px; box-shadow:0 4px 12px rgba(0,0,0,0.15);">
          <i class="fa fa-users"></i> Customer & Segmentasi
        </a>
      </div>
    </div>
  </div>

  <!-- Filter Control Bar -->
  <div class="section-card-custom" style="padding:16px 22px; margin-bottom:20px;">
    <form method="GET" action="<?= site_url('administrator/rfm/tracking'); ?>" id="form-filter-tracking">
      <div class="row" style="display:flex; align-items:center; flex-wrap:wrap; margin:0 -8px;">
        <div class="col-md-5 col-sm-6" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-shopping-bag" style="color:#059669;"></i> Filter Produk:
          </label>
          <select name="product" class="form-control select2" style="width:100%; border-radius:8px; height:38px;">
            <option value="">-- Semua Produk (Keseluruhan) --</option>
            <?php foreach ($products_list as $prod): 
              $p_name = is_object($prod) ? $prod->item_name : (is_array($prod) ? ($prod['item_name'] ?? '') : (string)$prod);
            ?>
            <option value="<?= htmlspecialchars($p_name); ?>" <?= (!empty($product_filter) && $product_filter === $p_name) ? 'selected' : ''; ?>>
              <?= htmlspecialchars($p_name); ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-4 col-sm-6" style="padding:0 8px; margin-bottom:8px;">
          <label style="font-weight:700; font-size:12px; color:#475569; display:block; margin-bottom:5px;">
            <i class="fa fa-calendar" style="color:#6366f1;"></i> Filter Bulan / Periode:
          </label>
          <select name="period" class="form-control" style="width:100%; border-radius:8px; height:38px;">
            <option value="">-- Semua Periode Bulanan --</option>
            <?php foreach ($months_list as $m): 
              $m_val = is_object($m) ? $m->ym_val : ($m['ym_val'] ?? '');
              $m_lbl = is_object($m) ? $m->ym_label : ($m['ym_label'] ?? '');
            ?>
            <option value="<?= htmlspecialchars($m_val); ?>" <?= (!empty($period_filter) && $period_filter === $m_val) ? 'selected' : ''; ?>>
              <?= htmlspecialchars($m_lbl); ?> (<?= $m_val; ?>)
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3 col-sm-12" style="padding:0 8px; margin-bottom:8px; display:flex; gap:8px; align-items:flex-end;">
          <button type="submit" class="btn btn-primary" style="background:#047857; border:none; border-radius:8px; font-weight:700; height:38px; flex:1; margin-top:21px;">
            <i class="fa fa-filter"></i> Terapkan Filter
          </button>
          <?php if (!empty($product_filter) || !empty($period_filter)): ?>
          <a href="<?= site_url('administrator/rfm/tracking'); ?>" class="btn btn-default" style="border-radius:8px; font-weight:600; height:38px; margin-top:21px; border:1px solid #cbd5e1; color:#64748b;" title="Reset Filter">
            <i class="fa fa-refresh"></i> Reset
          </a>
          <?php endif; ?>
        </div>
      </div>
    </form>
  </div>

  <?php 
  $track_data = $monthly_tracking ?? [];
  $track_cnt = $kpi_tracking['track_cnt'] ?? count($track_data);
  $total_sum_spend = $kpi_tracking['total_sum_spend'] ?? 0;
  $avg_sum_spend = $kpi_tracking['avg_sum_spend'] ?? 0;
  $total_sum_buyers = $kpi_tracking['total_sum_buyers'] ?? 0;
  $avg_sum_buyers = $kpi_tracking['avg_sum_buyers'] ?? 0;
  $total_sum_orders = $kpi_tracking['total_sum_orders'] ?? 0;
  ?>

  <!-- 4 Mini Summary Stats Cards -->
  <div class="row" style="margin-bottom:22px;">
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #10b981;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#15803d;"><?= number_format($track_cnt); ?> Bulan</div>
            <div class="kpi-mini-lbl" style="color:#166534;">Total Periode Teracak</div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#dcfce7; color:#166534; display:flex; align-items:center; justify-content:center; font-size:18px;">
            <i class="fa fa-calendar-check-o"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #3b82f6;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#1d4ed8;">Rp <?= number_format($avg_sum_spend, 0, ',', '.'); ?></div>
            <div class="kpi-mini-lbl" style="color:#1e40af;">Rata2 Omset / Bulan</div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#dbeafe; color:#1e40af; display:flex; align-items:center; justify-content:center; font-size:18px;">
            <i class="fa fa-money"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #8b5cf6;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#6b21a8;"><?= number_format($avg_sum_buyers); ?> Customer</div>
            <div class="kpi-mini-lbl" style="color:#7e22ce;">Rata2 Pembeli / Bulan</div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#f3e8ff; color:#7e22ce; display:flex; align-items:center; justify-content:center; font-size:18px;">
            <i class="fa fa-users"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:12px;">
      <div class="kpi-mini-card" style="border-left:4px solid #f97316;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <div>
            <div class="kpi-mini-val" style="color:#c2410c;"><?= number_format($total_sum_orders); ?>x</div>
            <div class="kpi-mini-lbl" style="color:#ea580c;">Total Transaksi (F)</div>
          </div>
          <div style="width:42px; height:42px; border-radius:10px; background:#ffedd5; color:#c2410c; display:flex; align-items:center; justify-content:center; font-size:18px;">
            <i class="fa fa-shopping-cart"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Monthly Visual Trend Chart -->
  <?php if (!empty($track_data)): ?>
  <div class="section-card-custom">
    <div style="font-weight:800; font-size:15px; color:#0f172a; margin-bottom:16px; display:flex; justify-content:space-between; align-items:center;">
      <span><i class="fa fa-area-chart" style="color:#059669; font-size:18px; margin-right:6px;"></i> Grafik Historis Omset (Rp) & Pembeli Unik (Customer) Per Bulan</span>
      <span class="badge" style="background:#ecfdf5; color:#047857; font-weight:700; padding:6px 12px; font-size:11.5px; border:1px solid #a7f3d0;"><i class="fa fa-bar-chart"></i> Dual-Axis Analytics</span>
    </div>
    <div style="position:relative; height:320px; width:100%;">
      <canvas id="monthlyTrendChart"></canvas>
    </div>
  </div>
  <?php endif; ?>

  <!-- Monthly Performance Table -->
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
      <table class="table table-hover table-striped table-tracking">
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
              <span class="label" style="background:<?= $r_days <= 30 ? '#dcfce7; color:#166534;' : ($r_days <= 90 ? '#fef3c7; color:#92400e;' : '#fee2e2; color:#991b1b;'); ?> border-radius:6px; padding:5px 9px; font-weight:700;">
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
