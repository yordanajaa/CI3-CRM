<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
:root {
  --rfm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
  --card-radius: 14px;
}

.profile-header {
  background: var(--rfm-gradient);
  color: #fff;
  padding: 26px 30px;
  border-radius: 16px;
  margin-bottom: 22px;
  box-shadow: 0 12px 30px rgba(30, 27, 75, 0.25);
  position: relative;
  overflow: hidden;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
}
.profile-header::after {
  content: '';
  position: absolute;
  top: -50%; right: -20%;
  width: 300px; height: 300px;
  background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(255,255,255,0) 70%);
  pointer-events: none;
}
.profile-header .name { font-size: 24px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 4px; color: #fff; }
.profile-header .phone { font-size: 14px; color: #cbd5e1; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; }
.profile-header .header-btns { display: flex; gap: 8px; flex-wrap: wrap; position: relative; z-index: 2; }
.profile-header .header-btns .btn {
  border-radius: 9px;
  font-weight: 700;
  font-size: 12.5px;
  padding: 8px 16px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  transition: all 0.2s ease;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.profile-header .header-btns .btn:hover { transform: translateY(-2px); }

/* Summary Cards */
.summary-card {
  background: #ffffff;
  border-radius: var(--card-radius);
  padding: 18px 16px;
  box-shadow: var(--card-shadow);
  border: 1px solid #f1f5f9;
  text-align: center;
  margin-bottom: 20px;
  transition: all 0.25s ease;
}
.summary-card:hover { transform: translateY(-3px); box-shadow: 0 8px 22px rgba(0,0,0,0.08); border-color: #cbd5e1; }
.summary-card .num { font-size: 24px; font-weight: 800; letter-spacing: -0.5px; line-height: 1.2; }
.summary-card .lbl { font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }
.sc-blue .num { color: #2563eb; }
.sc-green .num { color: #059669; }
.sc-orange .num { color: #ea580c; }
.sc-purple .num { color: #7c3aed; }

/* RFM Score Card */
.rfm-detail-card {
  background: #fff;
  border-radius: var(--card-radius);
  padding: 22px 24px;
  box-shadow: var(--card-shadow);
  border: 1px solid #f1f5f9;
  margin-bottom: 22px;
}
.rfm-detail-card .card-title {
  font-weight: 800;
  font-size: 16px;
  color: #0f172a;
  margin: 0 0 18px 0;
  display: flex;
  align-items: center;
  gap: 8px;
}
.rfm-meter {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 0;
  border-bottom: 1px solid #f1f5f9;
}
.rfm-meter:last-of-type { border-bottom: none; }
.rfm-meter .meter-label {
  width: 95px;
  font-size: 12px;
  font-weight: 700;
  color: #475569;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: flex;
  align-items: center;
  gap: 6px;
  flex-shrink: 0;
}
.rfm-meter .meter-bar {
  flex: 1;
  height: 10px;
  background: #f1f5f9;
  border-radius: 6px;
  overflow: hidden;
}
.rfm-meter .meter-fill {
  height: 100%;
  border-radius: 6px;
  transition: width 0.6s ease;
}
.rfm-meter .meter-score {
  width: 34px;
  height: 34px;
  border-radius: 9px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 15px;
  color: #fff;
  flex-shrink: 0;
}
.rfm-meter .meter-desc {
  width: 120px;
  font-size: 12px;
  color: #64748b;
  font-weight: 600;
  text-align: right;
  flex-shrink: 0;
}

.segment-display {
  padding: 14px 18px;
  border-radius: 12px;
  margin-top: 16px;
  display: flex;
  align-items: center;
  gap: 14px;
}
.segment-display .seg-icon-lg {
  width: 46px; height: 46px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
}
.segment-display .seg-label { font-weight: 800; font-size: 17px; line-height: 1.2; }
.segment-display .seg-goal { font-size: 12px; opacity: 0.9; margin-top: 2px; }

/* Product RFM Table */
.table-product-rfm th {
  background: #f8fafc;
  font-size: 10.5px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #475569;
  padding: 10px 12px !important;
  border-bottom: 2px solid #e2e8f0;
  white-space: nowrap;
}
.table-product-rfm td {
  padding: 10px 12px !important;
  font-size: 12.5px;
  color: #334155;
  vertical-align: middle !important;
}
.table-product-rfm tbody tr:hover { background: #f8fafc !important; }

.badge-source {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  color: #fff;
  display: inline-block;
  margin: 2px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  white-space: nowrap;
}
.badge-toko { background: linear-gradient(135deg, #1e293b, #334155); }
.badge-shopee { background: linear-gradient(135deg, #ee4d2d, #ff6b4a); }
.badge-tokopedia { background: linear-gradient(135deg, #059669, #10b981); }
.badge-tiktok { background: linear-gradient(135deg, #09090b, #18181b); }

.badge-status {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: inline-block;
  white-space: nowrap;
}
.bs-shipped { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.bs-delivered { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.bs-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.bs-cancelled { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
.bs-completed { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.bs-processing { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }

/* ===== Animations & Micro-Interactions ===== */
@keyframes rfmFadeInUp {
  from {
    opacity: 0;
    transform: translateY(14px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.profile-header, .summary-card, .rfm-detail-card {
  animation: rfmFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease, border-color 0.25s ease;
}

.btn:active {
  transform: scale(0.97) !important;
}

.meter-fill {
  transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
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

@media (min-width: 992px) {
  .rfm-flex-row { display: flex; flex-wrap: wrap; }
  .rfm-flex-col { display: flex; flex-direction: column; }
}

@media (max-width: 767px) {
  .profile-header { padding: 18px 14px; text-align: center; flex-direction: column; }
  .profile-header .name { font-size: 20px; }
  .profile-header .header-btns { width: 100%; justify-content: center; gap: 8px; }
  .profile-header .header-btns .btn { width: 100%; max-width: 100%; padding: 10px; font-size: 12.5px; justify-content: center; }
  .summary-card .num { font-size: 20px; }
  .rfm-detail-card { padding: 16px; margin-bottom: 16px; }
  .rfm-detail-card .card-title { font-size: 15px; }
}

@media (max-width: 575px) {
  .summary-row .col-xs-6 { width: 50%; float: left; padding-left: 5px; padding-right: 5px; }
  .summary-row { margin-left: -5px; margin-right: -5px; }
  .summary-card { padding: 12px 6px; margin-bottom: 10px; }
  .summary-card .num { font-size: 16px; }
  .summary-card .lbl { font-size: 9px; letter-spacing: 0; }
  .rfm-meter { gap: 8px; }
  .rfm-meter .meter-label { width: 70px; font-size: 10.5px; }
  .rfm-meter .meter-desc { width: 85px; font-size: 10px; }
  .rfm-meter .meter-score { width: 28px; height: 28px; font-size: 13px; border-radius: 7px; }
}
</style>

<?php
$s = $summary;
$rfm = $s['rfm'];
$badge = $rfm['badge'];
$score_colors = [1 => '#ef4444', 2 => '#f97316', 3 => '#eab308', 4 => '#22c55e', 5 => '#16a34a'];
?>

<!-- ===== PROFILE HEADER ===== -->
<div class="profile-header">
  <div>
    <div class="name"><i class="fa fa-user-circle"></i> <?= htmlspecialchars($s['nama']); ?></div>
    <div class="phone"><i class="fa fa-phone"></i> <?= htmlspecialchars($phone); ?></div>
    <div style="margin-top:8px;">
      <?php foreach ($s['sources'] as $src):
        $cls = 'badge-toko';
        if (stripos($src, 'shopee') !== false) $cls = 'badge-shopee';
        elseif (stripos($src, 'tokopedia') !== false) $cls = 'badge-tokopedia';
        elseif (stripos($src, 'tiktok') !== false) $cls = 'badge-tiktok';
      ?>
      <span class="badge-source <?= $cls; ?>"><?= htmlspecialchars($src); ?></span>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="header-btns">
    <a href="<?= site_url('administrator/rfm' . (!empty($product_filter) ? '?product=' . urlencode($product_filter) : '')); ?>" class="btn" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-arrow-left"></i> Kembali</a>
    <a href="<?= site_url('administrator/crm/customer_detail?phone=' . urlencode($phone)); ?>" class="btn" style="background:#fff;color:#312e81;"><i class="fa fa-tasks"></i> Lihat CRM Detail</a>
    <?php
      $clean_phone = preg_replace('/[^0-9]/', '', $phone ?? '');
      $wa_phone = preg_replace('/^0/', '62', $clean_phone);
      if (substr($wa_phone, 0, 2) !== '62') $wa_phone = '62' . $wa_phone;
      $wa_act = !empty($rfm['action']) ? $rfm['action'] : 'Terima kasih telah berbelanja bersama kami.';
      $wa_msg = "Halo Kak " . ($s['nama'] ?? 'Customer') . ",\n\nSalam dari Metafora! " . $wa_act . "\n\nAda yang bisa kami bantu hari ini?";
      $direct_wa_url = 'https://api.whatsapp.com/send?phone=' . $wa_phone . '&text=' . rawurlencode($wa_msg);
    ?>
    <a href="<?= $direct_wa_url; ?>" target="_blank" class="btn" style="background:#25D366;color:#fff;" title="Buka Chat WhatsApp Langsung"><i class="fa fa-whatsapp"></i> Chat WA</a>
  </div>
</div>

<!-- ===== SUMMARY CARDS ===== -->
<?php if (!empty($product_filter)): ?>
<div class="alert" style="background:#e0e7ff; color:#3730a3; border:1px solid #c7d2fe; border-radius:10px; padding:10px 16px; margin-bottom:14px; font-weight:600; font-size:13px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
  <span><i class="fa fa-filter"></i> Data di bawah hanya untuk produk: <strong><?= htmlspecialchars($product_filter); ?></strong></span>
  <a href="<?= site_url('administrator/rfm/customer_detail?phone=' . urlencode($phone)); ?>" style="color:#3730a3; font-size:12px; font-weight:700;"><i class="fa fa-times"></i> Hapus Filter</a>
</div>
<?php endif; ?>
<div class="row summary-row">
  <div class="col-md-3 col-sm-6 col-xs-6"><div class="summary-card sc-blue"><div class="num"><?= number_format($s['total_orders']); ?></div><div class="lbl">Total Order<?= !empty($product_filter) ? ' Produk' : ''; ?></div></div></div>
  <div class="col-md-3 col-sm-6 col-xs-6"><div class="summary-card sc-green"><div class="num">Rp <?= number_format($s['total_spend'], 0, ',', '.'); ?></div><div class="lbl">Total Belanja<?= !empty($product_filter) ? ' Produk' : ''; ?></div></div></div>
  <div class="col-md-3 col-sm-6 col-xs-6"><div class="summary-card sc-orange"><div class="num"><?= $s['first_order'] ? date('d M Y', strtotime($s['first_order'])) : '-'; ?></div><div class="lbl">Order Pertama<?= !empty($product_filter) ? ' Produk' : ''; ?></div></div></div>
  <div class="col-md-3 col-sm-6 col-xs-6"><div class="summary-card sc-purple"><div class="num"><?= $s['last_order'] ? date('d M Y', strtotime($s['last_order'])) : '-'; ?></div><div class="lbl">Order Terakhir<?= !empty($product_filter) ? ' Produk' : ''; ?></div></div></div>
</div>

<!-- ===== RFM SCORE DETAIL ===== -->
<div class="row rfm-flex-row">
  <div class="col-md-7 col-sm-12 rfm-flex-col">
    <div class="rfm-detail-card" style="flex:1;">
      <div class="card-title"><i class="fa fa-bar-chart" style="color:#6366f1;"></i> Skor RFM Customer<?php if (!empty($product_filter)): ?> <span class="label" style="background:#e0e7ff; color:#3730a3; font-size:11px; padding:4px 10px; border-radius:10px;"><i class="fa fa-tag"></i> Produk: <?= htmlspecialchars($product_filter); ?></span><?php endif; ?></div>

      <div class="rfm-meter">
        <div class="meter-label"><i class="fa fa-clock-o" style="color:#2563eb;"></i> Recency</div>
        <div class="meter-bar"><div class="meter-fill" style="width:<?= ($rfm['r_score']/5)*100; ?>%; background:<?= $score_colors[$rfm['r_score']]; ?>;"></div></div>
        <div class="meter-score" style="background:<?= $score_colors[$rfm['r_score']]; ?>"><?= $rfm['r_score']; ?></div>
        <div class="meter-desc"><?= $rfm['r_label']; ?> <?= $rfm['days_since_last'] !== null ? '(' . $rfm['days_since_last'] . ' hr)' : ''; ?></div>
      </div>

      <div class="rfm-meter">
        <div class="meter-label"><i class="fa fa-repeat" style="color:#16a34a;"></i> Frequency</div>
        <div class="meter-bar"><div class="meter-fill" style="width:<?= ($rfm['f_score']/5)*100; ?>%; background:<?= $score_colors[$rfm['f_score']]; ?>;"></div></div>
        <div class="meter-score" style="background:<?= $score_colors[$rfm['f_score']]; ?>"><?= $rfm['f_score']; ?></div>
        <div class="meter-desc"><?= $rfm['f_label']; ?> (<?= $s['total_orders']; ?>x)</div>
      </div>

      <div class="rfm-meter">
        <div class="meter-label"><i class="fa fa-money" style="color:#7c3aed;"></i> Monetary</div>
        <div class="meter-bar"><div class="meter-fill" style="width:<?= ($rfm['m_score']/5)*100; ?>%; background:<?= $score_colors[$rfm['m_score']]; ?>;"></div></div>
        <div class="meter-score" style="background:<?= $score_colors[$rfm['m_score']]; ?>"><?= $rfm['m_score']; ?></div>
        <div class="meter-desc"><?= $rfm['m_label']; ?></div>
      </div>

      <!-- Segment Display -->
      <div class="segment-display" style="background:<?= $badge['bg']; ?>; color:<?= $badge['color']; ?>; border:1px solid <?= $badge['border']; ?>;">
        <div class="seg-icon-lg" style="background:<?= $badge['color']; ?>20; color:<?= $badge['color']; ?>;">
          <i class="fa <?= $badge['icon']; ?>"></i>
        </div>
        <div>
          <div class="seg-label"><?= htmlspecialchars($rfm['segment']); ?></div>
          <div class="seg-goal"><?= htmlspecialchars($rfm['goal']); ?></div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-5 col-sm-12 rfm-flex-col">
    <div class="rfm-detail-card" style="flex:1;">
      <div class="card-title"><i class="fa fa-lightbulb-o" style="color:#f59e0b;"></i> Rekomendasi Action</div>
      <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:10px; padding:14px 16px; margin-bottom:12px;">
        <div style="font-weight:700; color:#92400e; font-size:12.5px; margin-bottom:4px;"><i class="fa fa-bullseye"></i> Goal Strategis</div>
        <div style="font-size:12.5px; color:#78350f; line-height:1.4;"><?= htmlspecialchars($rfm['goal']); ?></div>
      </div>
      <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:14px 16px; margin-bottom:16px;">
        <div style="font-weight:700; color:#166534; font-size:12.5px; margin-bottom:4px;"><i class="fa fa-check-circle"></i> Rekomendasi Aksi</div>
        <div style="font-size:12.5px; color:#14532d; line-height:1.4;"><?= htmlspecialchars($rfm['action']); ?></div>
      </div>

      <div style="text-align:center; background:#fafbfc; border-radius:12px; padding:12px; border:1px solid #f1f5f9;">
        <div style="font-size:11px; color:#64748b; font-weight:700; letter-spacing:0.5px; margin-bottom:4px;">KODE SKOR RFM (R - F - M)</div>
        <div style="font-size:32px; font-weight:900; letter-spacing:3px; color:#0f172a; line-height:1;">
          <span style="color:<?= $score_colors[$rfm['r_score']]; ?>"><?= $rfm['r_score']; ?></span>
          <span style="color:#cbd5e1;">-</span>
          <span style="color:<?= $score_colors[$rfm['f_score']]; ?>"><?= $rfm['f_score']; ?></span>
          <span style="color:#cbd5e1;">-</span>
          <span style="color:<?= $score_colors[$rfm['m_score']]; ?>"><?= $rfm['m_score']; ?></span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ===== PRODUCT RFM TABLE ===== -->
<div class="rfm-detail-card">
  <div class="card-title" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
    <span><i class="fa fa-cubes" style="color:#6366f1;"></i> Analisis RFM Per Produk<?php if (!empty($product_filter)): ?> <span class="label" style="background:#e0e7ff; color:#3730a3; font-size:11px; padding:3px 8px; border-radius:8px;"><?= htmlspecialchars($product_filter); ?></span><?php endif; ?></span>
    <?php if (!empty($product_filter)): ?>
    <a href="<?= site_url('administrator/rfm/customer_detail?phone=' . urlencode($phone)); ?>" class="btn btn-xs" style="background:#f1f5f9; color:#475569; border-radius:6px; font-weight:600; font-size:11px;"><i class="fa fa-list"></i> Lihat Semua Produk</a>
    <?php endif; ?>
  </div>
  <div class="table-responsive">
    <table class="table table-product-rfm">
      <thead>
        <tr>
          <th>#</th>
          <th style="min-width:140px;">Nama Produk</th>
          <th style="min-width:100px;">Kode Produk</th>
          <th style="min-width:110px;">Terakhir Beli</th>
          <th style="min-width:110px;">Recency (Hari)</th>
          <th style="min-width:110px;">Frekuensi Order</th>
          <th style="min-width:90px;">Total Qty</th>
          <th style="min-width:140px;">Total Spend (Monetary)</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        // Filter product_rfm to only show the selected product if filter is active
        $display_products = $product_rfm;
        if (!empty($product_filter) && !empty($product_rfm)) {
            $display_products = array_filter($product_rfm, function($pr) use ($product_filter) {
                return (isset($pr->nama_produk) && $pr->nama_produk === $product_filter);
            });
        }
        ?>
        <?php if (empty($display_products)): ?>
        <tr><td colspan="8" class="text-center" style="padding:30px !important; color:#94a3b8;"><i class="fa fa-info-circle" style="font-size:20px; display:block; margin-bottom:6px;"></i>Belum ada data transaksi produk untuk customer ini</td></tr>
        <?php else: ?>
        <?php $pno = 1; foreach ($display_products as $pr): ?>
        <tr<?= (!empty($product_filter) && isset($pr->nama_produk) && $pr->nama_produk === $product_filter) ? ' style="background:#eef2ff;"' : ''; ?>>
          <td><?= $pno++; ?></td>
          <td><strong style="color:#0f172a;"><?= htmlspecialchars($pr->nama_produk); ?></strong></td>
          <td><code style="font-size:11px; background:#f1f5f9; padding:2px 6px; border-radius:4px; color:#475569; white-space:nowrap;"><?= htmlspecialchars($pr->kode_produk ?? '-'); ?></code></td>
          <td style="white-space:nowrap;"><?= $pr->last_bought_date ? date('d M Y', strtotime($pr->last_bought_date)) : '-'; ?></td>
          <td>
            <?php
            $rd = (int)($pr->recency_days ?? 0);
            $rc = $rd <= 30 ? '#16a34a' : ($rd <= 90 ? '#eab308' : '#ef4444');
            ?>
            <span style="font-weight:700; color:<?= $rc; ?>; white-space:nowrap;"><?= $rd; ?> hari</span>
          </td>
          <td><strong><?= $pr->order_count; ?>x</strong></td>
          <td><?= number_format($pr->total_qty, 0, ',', '.'); ?></td>
          <td><strong style="color:#059669; white-space:nowrap;">Rp <?= number_format($pr->total_spend, 0, ',', '.'); ?></strong></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ===== TRANSACTION HISTORY ===== -->
<div class="rfm-detail-card">
  <div class="card-title" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
    <span><i class="fa fa-history" style="color:#6366f1;"></i> Riwayat Transaksi<?php if (!empty($product_filter)): ?> <span class="label" style="background:#dcfce7; color:#166534; font-size:11px; padding:3px 8px; border-radius:8px;"><i class="fa fa-filter"></i> Hanya transaksi: <?= htmlspecialchars($product_filter); ?></span><?php endif; ?></span>
    <?php if (!empty($product_filter)): ?>
    <a href="<?= site_url('administrator/rfm/customer_detail?phone=' . urlencode($phone)); ?>" class="btn btn-xs" style="background:#f1f5f9; color:#475569; border-radius:6px; font-weight:600; font-size:11px;"><i class="fa fa-list"></i> Lihat Semua Transaksi</a>
    <?php endif; ?>
  </div>
  <div class="table-responsive">
    <table class="table table-product-rfm">
      <thead>
        <tr>
          <th>#</th>
          <th style="min-width:110px;">Tanggal</th>
          <th style="min-width:120px;">No Pesanan</th>
          <th style="min-width:120px;">Sumber</th>
          <th style="min-width:160px;">Produk</th>
          <th style="min-width:120px;">Total</th>
          <th style="min-width:100px;">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($transactions)): ?>
        <tr><td colspan="7" class="text-center" style="padding:30px !important; color:#94a3b8;"><i class="fa fa-info-circle" style="font-size:20px; display:block; margin-bottom:6px;"></i>Belum ada transaksi recorded</td></tr>
        <?php else: ?>
        <?php $tno = 1; foreach ($transactions as $tx): ?>
        <tr>
          <td><?= $tno++; ?></td>
          <td style="white-space:nowrap;"><?= date('d M Y', strtotime($tx->tanggal)); ?></td>
          <td><code style="font-size:11px; background:#f1f5f9; padding:2px 6px; border-radius:4px; color:#475569; white-space:nowrap;"><?= htmlspecialchars($tx->no_pesanan ?: $tx->nomor_so ?: '-'); ?></code></td>
          <td>
            <?php
            $cls = 'badge-toko';
            if (stripos($tx->sumber_penjualan, 'shopee') !== false) $cls = 'badge-shopee';
            elseif (stripos($tx->sumber_penjualan, 'tokopedia') !== false) $cls = 'badge-tokopedia';
            elseif (stripos($tx->sumber_penjualan, 'tiktok') !== false) $cls = 'badge-tiktok';
            ?>
            <span class="badge-source <?= $cls; ?>"><?= htmlspecialchars($tx->sumber_penjualan); ?></span>
          </td>
          <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($tx->produk_ringkasan ?? '-'); ?></td>
          <td><strong style="color:#059669; white-space:nowrap;">Rp <?= number_format($tx->total, 0, ',', '.'); ?></strong></td>
          <td>
            <?php
            $status = strtolower($tx->status_pesanan ?? $tx->status ?? '');
            $bs = 'bs-pending';
            if (strpos($status, 'delivered') !== false || strpos($status, 'selesai') !== false) $bs = 'bs-delivered';
            elseif (strpos($status, 'shipped') !== false || strpos($status, 'kirim') !== false) $bs = 'bs-shipped';
            elseif (strpos($status, 'cancel') !== false || strpos($status, 'batal') !== false) $bs = 'bs-cancelled';
            elseif (strpos($status, 'completed') !== false) $bs = 'bs-completed';
            elseif (strpos($status, 'processing') !== false || strpos($status, 'proses') !== false) $bs = 'bs-processing';
            ?>
            <span class="badge-status <?= $bs; ?>"><?= htmlspecialchars($tx->status_pesanan ?? $tx->status ?? '-'); ?></span>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

