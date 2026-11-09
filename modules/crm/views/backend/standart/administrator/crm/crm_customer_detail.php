<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
@keyframes crmFadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}

:root {
  --crm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
}

.profile-header {
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
.profile-header::after {
  content: '';
  position: absolute;
  top: -50%; right: -20%;
  width: 300px; height: 300px;
  background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(255,255,255,0) 70%);
  pointer-events: none;
}
.profile-header .location-tag {
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
  margin-bottom: 12px;
}
.profile-header .name { font-size: 26px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 4px; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }
.profile-header .phone { font-size: 15px; color: #cbd5e1; font-weight: 500; }

/* Navigation Tab Bar - Touch Scrollable */
.profile-header .nav-tabs-bar {
  display: flex;
  align-items: center;
  gap: 8px;
  padding-top: 14px;
  margin-top: 18px;
  border-top: 1px solid rgba(255,255,255,0.18);
  position: relative;
  z-index: 2;
  overflow-x: auto;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
}
.profile-header .nav-tabs-bar::-webkit-scrollbar {
  display: none;
}
.profile-header .nav-tab-btn {
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
.profile-header .nav-tab-btn:hover {
  background: rgba(255,255,255,0.25);
  color: #fff;
  transform: translateY(-1px);
}
.profile-header .nav-tab-btn.active {
  background: #ffffff !important;
  color: #312e81 !important;
  border-color: #ffffff !important;
  box-shadow: 0 4px 14px rgba(0,0,0,0.18) !important;
}
.profile-header .nav-tab-btn .active-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #6366f1;
  display: inline-block;
}

.summary-card {
  background: #ffffff;
  border-radius: 14px;
  padding: 20px 16px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.04);
  border: 1px solid #f1f5f9;
  text-align: center;
  margin-bottom: 16px;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  animation: crmFadeInUp 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}
.summary-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.08);
  border-color: #cbd5e1;
}

.box {
  animation: crmFadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.table-responsive {
  -webkit-overflow-scrolling: touch;
}
.summary-card .num { font-size: 26px; font-weight: 800; letter-spacing: -0.5px; }
.summary-card .lbl { font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; margin-top: 4px; }
.sc-blue .num { color: #2563eb; }
.sc-green .num { color: #059669; }
.sc-orange .num { color: #ea580c; }
.sc-purple .num { color: #7c3aed; }
.sc-red .num { color: #dc2626; }

.badge-source {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  color: #fff;
  display: inline-block;
  margin: 3px 2px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
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
  box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}
.bs-shipped { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.bs-delivered { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.bs-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.bs-cancelled { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
.bs-completed { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.bs-processing { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
.bs-packed { background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }

.timeline-fu { position: relative; padding-left: 28px; margin: 12px 0; }
.timeline-fu::before { content: ''; position: absolute; left: 10px; top: 4px; bottom: 4px; width: 2px; background: #e2e8f0; }
.tl-item { position: relative; margin-bottom: 12px; padding: 10px 14px; background: #ffffff; border-radius: 10px; border: 1px solid #f1f5f9; border-left: 4px solid #3b82f6; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
.tl-item.tl-done { border-left-color: #10b981; }
.tl-item.tl-pending { border-left-color: #f59e0b; }
.tl-item .tl-title { font-weight: 700; font-size: 13px; color: #1e293b; }
.tl-item .tl-date { font-size: 11px; color: #64748b; }
.tl-item .tl-status { font-size: 11px; margin-top: 3px; }

.trx-row { cursor: pointer; transition: all 0.2s ease; }
.trx-row:hover { background: #f8fafc !important; }
.trx-detail-panel { display: none; background: #f8fafc; border-top: 2px solid #6366f1; border-bottom: 2px solid #cbd5e1; }
.table-crm th { background: #f1f5f9; font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: #475569; font-weight: 700; }
.table-crm td { font-size: 13px; vertical-align: middle !important; color: #334155; }

@media (max-width: 991px) {
  .profile-header .col-md-1 { display: none; }
  .profile-header .text-right { text-align: center !important; margin-top: 12px; }
}

@media (max-width: 767px) {
  .content { padding: 10px 8px !important; }
  .profile-header { padding: 18px 14px; text-align: center; border-radius: 12px; margin-bottom: 14px; }
  .profile-header .name { font-size: 19px; }
  .profile-header .phone { font-size: 13px; }
  .profile-header .col-md-1 { display: none; }
  .profile-header .text-right { text-align: center !important; margin-top: 10px; }
  .profile-header .text-right .btn { font-size: 10.5px; padding: 5px 10px; margin-bottom: 4px; }
  .profile-header div[style*="margin-top: 8px"] { margin-top: 8px; }

  .summary-card { padding: 12px 10px; margin-bottom: 8px; border-radius: 10px; }
  .summary-card .num { font-size: 18px; }
  .summary-card .lbl { font-size: 9px; }

  .box-header { padding: 10px 12px !important; }
  .box-header .box-title { font-size: 13px; }

  .table-responsive { border: none !important; margin-bottom: 0; }
  .table-crm { min-width: 700px; }
  .table-crm th { font-size: 10px; padding: 8px 4px !important; white-space: nowrap; }
  .table-crm td { font-size: 11px; padding: 8px 4px !important; }
  .badge-source { font-size: 9.5px; padding: 2px 7px; }
  .badge-status { font-size: 9px; padding: 3px 8px; }

  .trx-detail-panel td { padding: 10px 12px !important; }
  .trx-detail-panel .col-md-7, .trx-detail-panel .col-md-5 { width: 100%; margin-bottom: 10px; }
  .trx-detail-panel h5 { font-size: 13px; }

  .timeline-fu { padding-left: 18px; }
  .tl-item { padding: 8px 10px; }
  .tl-item .tl-title { font-size: 12px; }
  .tl-item .tl-date { font-size: 10px; }
}

@media (max-width: 480px) {
  .profile-header .name { font-size: 17px; }
  .profile-header .text-right { display: flex; flex-direction: column; gap: 4px; }
  .profile-header .text-right .btn { width: 100%; }
  .summary-card .num { font-size: 16px; }
  .table-crm th, .table-crm td { font-size: 10px; padding: 6px 3px !important; }
}
</style>

<section class="content" style="padding-top:15px;">
  <!-- Profile Header & Navigation -->
  <div class="profile-header">
    <div class="location-tag">
      <i class="fa fa-map-marker"></i> CRM & After Sales <i class="fa fa-angle-right"></i> <a href="<?= site_url('administrator/crm'); ?>" style="color:#e0e7ff;text-decoration:underline;">Daftar Customer</a> <i class="fa fa-angle-right"></i> <span>Detail Customer</span>
    </div>

    <div class="row">
      <div class="col-md-1 text-center" style="padding-top: 5px;">
        <i class="fa fa-user-circle-o" style="font-size: 50px; opacity: 0.8;"></i>
      </div>
      <div class="col-md-7">
        <?php
          $is_resi_ident = (strpos($summary['phone'] ?? '', 'RESI_') === 0);
          $disp_phone = $is_resi_ident ? ('Resi: ' . substr($summary['phone'], 5)) : ($summary['phone'] ?? '-');
          $phone_clean = preg_replace('/[^0-9]/', '', $summary['phone'] ?? '');
          $has_valid_top_phone = (!empty($phone_clean) && strlen($phone_clean) >= 8 && !$is_resi_ident);
        ?>
        <div class="name"><?= htmlspecialchars($summary['nama']); ?></div>
        <div class="phone">
          <?php if ($is_resi_ident): ?>
            <i class="fa fa-barcode"></i> <?= htmlspecialchars($disp_phone); ?> <span class="badge" style="background:#0284c7;font-size:10px;margin-left:4px;">Resi Marketplace</span>
          <?php elseif (!empty($summary['phone']) && $summary['phone'] !== '-'): ?>
            <i class="fa fa-phone"></i> <?= htmlspecialchars($summary['phone']); ?>
          <?php else: ?>
            <i class="fa fa-phone-slash" style="opacity:0.6;"></i> <span style="opacity:0.8;">(Tanpa No. HP)</span>
          <?php endif; ?>
        </div>
        <div style="margin-top: 8px;">
          <?php foreach ($summary['sources'] as $s):
            $cls = 'badge-toko';
            if (stripos($s, 'Shopee') !== false) $cls = 'badge-shopee';
            elseif (stripos($s, 'Tokopedia') !== false) $cls = 'badge-tokopedia';
            elseif (stripos($s, 'TikTok') !== false) $cls = 'badge-tiktok';
          ?>
          <span class="badge-source <?= $cls; ?>"><?= $s; ?></span>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="col-md-4 text-right" style="padding-top: 10px;">
        <a href="<?= site_url('administrator/crm'); ?>" class="btn btn-sm" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-arrow-left"></i> Kembali</a>
        <a href="<?= site_url('administrator/sales_order/add'); ?>" class="btn btn-sm" style="background:#f39c12;color:#fff;border:none;" title="Buat Transaksi Penjualan Repeat Order"><i class="fa fa-cart-plus"></i> Repeat Order</a>
        <?php if ($has_valid_top_phone):
          $top_phone = preg_replace('/^0/', '62', $phone_clean);
          if (substr($top_phone, 0, 2) !== '62') $top_phone = '62' . $top_phone;
          $top_act = !empty($summary['rfm']['action']) ? $summary['rfm']['action'] : 'Terima kasih telah berbelanja bersama kami.';
          $top_msg = "Halo Kak " . $summary['nama'] . ",\n\nSalam dari Metafora! " . $top_act . "\n\nAda yang bisa kami bantu hari ini?";
          $top_wa_url = 'https://api.whatsapp.com/send?phone=' . $top_phone . '&text=' . rawurlencode($top_msg);
        ?>
        <a href="<?= $top_wa_url; ?>" target="_blank" class="btn btn-sm" style="background:#25D366;color:#fff;border:none;font-weight:700;border-radius:6px;" title="Buka Chat WhatsApp Langsung"><i class="fa fa-whatsapp"></i> Chat WA</a>
        <?php endif; ?>
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
      <a href="<?= site_url('administrator/crm'); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-users"></i> 4. Customer Directory
      </a>
      <a href="<?= site_url('administrator/crm/cs_performance'); ?>" class="nav-tab-btn">
        <i class="fa fa-trophy"></i> 5. Kinerja Tim CS
      </a>
      <a href="<?= site_url('administrator/crm/followup_setting'); ?>" class="nav-tab-btn">
        <i class="fa fa-cogs"></i> 6. Kelompok Follow-Up
      </a>
    </div>
  </div>

  <!-- Summary Cards (FA-04) -->
  <div class="row">
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-blue">
        <div class="num"><?= $summary['total_orders']; ?></div>
        <div class="lbl">Total Order</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-green">
        <div class="num">Rp <?= number_format($summary['total_spend'], 0, ',', '.'); ?></div>
        <div class="lbl">Total Spend</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-orange">
        <div class="num"><?= $summary['order_count_toko']; ?></div>
        <div class="lbl">Order Toko</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-purple">
        <div class="num"><?= $summary['order_count_online']; ?></div>
        <div class="lbl">Order Online</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-blue">
        <div class="num"><?= $summary['first_order'] ? date('d/m/y', strtotime($summary['first_order'])) : '-'; ?></div>
        <div class="lbl">Order Pertama</div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
      <div class="summary-card sc-red">
        <div class="num"><?= $summary['last_order'] ? date('d/m/y', strtotime($summary['last_order'])) : '-'; ?></div>
        <div class="lbl">Order Terakhir</div>
      </div>
    </div>
  </div>

  <!-- RFM Customer Intelligence Card (rfm magang.xlsx) -->
  <?php if (isset($summary['rfm'])): $rfm = $summary['rfm']; $badge = $rfm['badge']; ?>
  <div class="box box-solid" style="border-radius:14px;box-shadow:0 8px 24px rgba(0,0,0,0.06);border:1px solid #e2e8f0;margin-bottom:20px;overflow:hidden;">
    <div class="box-header" style="background:linear-gradient(135deg, #1e293b 0%, #0f172a 100%);color:#fff;padding:16px 20px;">
      <h3 class="box-title" style="font-weight:800;font-size:16px;color:#fff;">
        <i class="fa fa-line-chart" style="color:#38bdf8;"></i> Intelijen Segmentasi RFM (Recency, Frequency, Monetary)
      </h3>
      <div class="box-tools pull-right">
        <span class="badge" style="background:<?= $badge['bg']; ?>;color:<?= $badge['color']; ?>;font-size:13px;font-weight:800;padding:6px 14px;border-radius:20px;border:1px solid <?= $badge['border']; ?>;">
          <i class="fa <?= $badge['icon']; ?>"></i> <?= htmlspecialchars($rfm['segment']); ?>
        </span>
      </div>
    </div>
    <div class="box-body" style="padding:22px;background:#ffffff;">
      <div class="row">
        <!-- RFM Scores -->
        <div class="col-md-4" style="border-right:1px solid #f1f5f9;padding-right:20px;">
          <h5 style="font-weight:800;color:#1e293b;margin-top:0;font-size:13px;text-transform:uppercase;letter-spacing:0.5px;">
            <i class="fa fa-dashboard" style="color:#6366f1;"></i> Skor Perilaku Pelanggan
          </h5>
          <div style="margin-top:14px;">
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:13px;">
              <span><i class="fa fa-clock-o text-info"></i> Recency (R):</span>
              <span class="label label-info" style="font-size:11px;font-weight:700;"><?= $rfm['r_score']; ?>/5 — <?= $rfm['r_label']; ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:13px;">
              <span><i class="fa fa-refresh text-success"></i> Frequency (F):</span>
              <span class="label label-success" style="font-size:11px;font-weight:700;"><?= $rfm['f_score']; ?>/5 — <?= $rfm['f_label']; ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:13px;">
              <span><i class="fa fa-money text-warning"></i> Monetary (M):</span>
              <span class="label label-warning" style="font-size:11px;font-weight:700;"><?= $rfm['m_score']; ?>/5 — <?= $rfm['m_label']; ?></span>
            </div>
            <hr style="margin:10px 0;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
              <span style="font-weight:700;color:#475569;font-size:12px;">Kode Matriks RFM:</span>
              <span style="font-weight:900;font-size:18px;letter-spacing:2px;color:#0f172a;background:#f1f5f9;padding:2px 10px;border-radius:6px;"><?= $rfm['rfm_display']; ?></span>
            </div>
          </div>
        </div>

        <!-- RFM Goal & Action Strategy -->
        <div class="col-md-5" style="border-right:1px solid #f1f5f9;padding-left:20px;padding-right:20px;">
          <h5 style="font-weight:800;color:#1e293b;margin-top:0;font-size:13px;text-transform:uppercase;letter-spacing:0.5px;">
            <i class="fa fa-bullseye" style="color:#ec4899;"></i> Strategi & Tindakan Follow-Up
          </h5>
          <div style="margin-top:12px;">
            <div style="margin-bottom:12px;">
              <strong style="color:#0284c7;font-size:12px;display:block;margin-bottom:2px;"><i class="fa fa-flag"></i> Target / Goal:</strong>
              <div style="font-size:13px;color:#334155;background:#f0f9ff;padding:8px 12px;border-radius:8px;border-left:3px solid #0284c7;">
                <?= htmlspecialchars($rfm['goal']); ?>
              </div>
            </div>
            <div>
              <strong style="color:#d97706;font-size:12px;display:block;margin-bottom:2px;"><i class="fa fa-magic"></i> Rekomendasi Action:</strong>
              <div style="font-size:13px;color:#334155;background:#fffbeb;padding:8px 12px;border-radius:8px;border-left:3px solid #d97706;">
                <?= htmlspecialchars($rfm['action']); ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Action Button -->
        <div class="col-md-3 text-center" style="display:flex;flex-direction:column;justify-content:center;align-items:center;padding-left:15px;">
          <div style="font-size:12px;color:#64748b;font-weight:700;margin-bottom:10px;text-transform:uppercase;">Aksi Cepat CS</div>
          <?php if (!empty($summary['phone'])):
            $wa_phone = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $summary['phone']));
            if (substr($wa_phone, 0, 2) !== '62') $wa_phone = '62' . $wa_phone;
            $wa_msg = "Halo Kak " . $summary['nama'] . ",\n\nSalam dari Metafora! " . $rfm['action'] . "\n\nAda yang bisa kami bantu hari ini?";
            $wa_url = "https://api.whatsapp.com/send?phone=" . $wa_phone . "&text=" . rawurlencode($wa_msg);
          ?>
          <a href="<?= $wa_url; ?>" target="_blank" class="btn btn-block" style="background:#25D366;color:#fff;font-weight:700;border-radius:10px;padding:10px 14px;box-shadow:0 4px 12px rgba(37,211,102,0.3);font-size:12px;white-space:normal;">
            <i class="fa fa-whatsapp fa-lg"></i><br>Kirim WA Sesuai Strategi RFM
          </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Product-Level RFM Analysis Section -->
  <div class="box box-solid" style="border-radius:14px;box-shadow:0 8px 24px rgba(0,0,0,0.06);border:1px solid #e2e8f0;margin-bottom:20px;overflow:hidden;">
    <div class="box-header" style="background:#ffffff;border-bottom:1px solid #f1f5f9;padding:16px 20px;">
      <h3 class="box-title" style="font-weight:800;font-size:15px;color:#1e293b;">
        <i class="fa fa-shopping-basket" style="color:#8b5cf6;"></i> Analisis RFM Per Produk (Recency, Frequency, Monetary)
      </h3>
      <small class="text-muted" style="display:block;margin-top:3px;font-size:12px;">Rekam data transaksi per produk: tanggal beli terakhir, jumlah frekuensi order/qty, dan total biaya yang dikeluarkan.</small>
    </div>
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover table-striped" style="margin:0;font-size:12.5px;">
        <thead>
          <tr style="background:#f8fafc;color:#475569;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;">
            <th style="width:40px;padding:12px 14px;">#</th>
            <th style="min-width:220px;padding:12px 14px;">Produk & SKU</th>
            <th style="width:200px;padding:12px 14px;"><i class="fa fa-clock-o text-info"></i> Recency (Beli Terakhir)</th>
            <th style="width:180px;padding:12px 14px;"><i class="fa fa-refresh text-success"></i> Frequency (Order & Qty)</th>
            <th style="width:180px;padding:12px 14px;" class="text-right"><i class="fa fa-money text-warning"></i> Monetary (Total Biaya)</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($product_rfm)): ?>
          <tr><td colspan="5" class="text-center" style="padding:30px;color:#94a3b8;"><i class="fa fa-info-circle fa-2x"></i><br>Belum ada rincian transaksi produk untuk pelanggan ini.</td></tr>
          <?php else: 
            $p_no = 1;
            $cust_total_spend = max(1, $summary['total_spend']);
            foreach ($product_rfm as $pr):
              $p_pct = round(($pr->total_spend / $cust_total_spend) * 100, 1);
          ?>
          <tr>
            <td style="padding:12px 14px;vertical-align:middle;font-weight:700;color:#64748b;"><?= $p_no++; ?></td>
            <td style="padding:12px 14px;vertical-align:middle;">
              <strong style="color:#0f172a;"><?= htmlspecialchars($pr->nama_produk); ?></strong><br>
              <small class="text-muted"><i class="fa fa-tag"></i> SKU: <?= htmlspecialchars($pr->kode_produk); ?></small>
            </td>
            <td style="padding:12px 14px;vertical-align:middle;">
              <strong style="color:#1e293b;"><?= date('d/m/Y', strtotime($pr->last_bought_date)); ?></strong><br>
              <span class="label" style="background:#e0f2fe;color:#0369a1;font-weight:700;font-size:10.5px;padding:3px 8px;border-radius:10px;display:inline-block;margin-top:2px;">
                <i class="fa fa-history"></i> <?= $pr->recency_days; ?> hari lalu
              </span>
            </td>
            <td style="padding:12px 14px;vertical-align:middle;">
              <span class="badge" style="background:#dcfce7;color:#15803d;font-weight:800;font-size:11.5px;padding:4px 10px;border-radius:10px;">
                <?= $pr->order_count; ?>x Order
              </span>
              <small style="color:#475569;font-weight:600;margin-left:4px;">(<?= number_format($pr->total_qty); ?> pcs)</small>
            </td>
            <td style="padding:12px 14px;vertical-align:middle;" class="text-right">
              <strong style="color:#16a34a;font-size:14px;">Rp <?= number_format($pr->total_spend, 0, ',', '.'); ?></strong>
              <div class="progress" style="height:4px;margin:4px 0 0 0;background:#e2e8f0;border-radius:2px;">
                <div class="progress-bar" role="progressbar" style="width:<?= min(100, max(5, $p_pct)); ?>%;background:#16a34a;"></div>
              </div>
              <small class="text-muted" style="font-size:10px;"><?= $p_pct; ?>% dari total belanja</small>
            </td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-history"></i> Riwayat Transaksi (<?= count($transactions); ?>)</h3>
    </div>
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover table-crm" id="tbl-trx">
        <thead>
          <tr>
            <th style="width:30px">#</th>
            <th>Tanggal</th>
            <th>No. Pesanan</th>
            <th>Sumber</th>
            <th>Produk</th>
            <th class="text-right">Nominal</th>
            <th>Status</th>
            <th>Resi</th>
            <th class="text-center">Follow-Up</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($transactions)): ?>
          <tr><td colspan="9" class="text-center" style="padding:40px;color:#95a5a6;"><i class="fa fa-inbox fa-2x"></i><br>Belum ada transaksi.</td></tr>
          <?php else: $no = 1; foreach ($transactions as $t): ?>
          <tr class="trx-row" data-table="<?= $t->tbl; ?>" data-id="<?= $t->id; ?>">
            <td><?= $no++; ?></td>
            <td><?= date('d M Y', strtotime($t->tanggal)); ?></td>
            <td><strong><?= htmlspecialchars($t->no_pesanan ?: $t->nomor_so); ?></strong></td>
            <td>
              <?php
              $cls = 'badge-toko';
              if (stripos($t->sumber_penjualan, 'Shopee') !== false) $cls = 'badge-shopee';
              elseif (stripos($t->sumber_penjualan, 'Tokopedia') !== false) $cls = 'badge-tokopedia';
              elseif (stripos($t->sumber_penjualan, 'TikTok') !== false) $cls = 'badge-tiktok';
              ?>
              <span class="badge-source <?= $cls; ?>"><?= $t->sumber_penjualan; ?></span>
            </td>
            <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($t->produk_ringkasan ?: '-'); ?></td>
            <td class="text-right"><strong>Rp <?= number_format($t->total, 0, ',', '.'); ?></strong></td>
            <td>
              <?php
              $st = strtolower($t->status);
              $st_p = strtolower($t->status_pesanan ?: '');
              $stcls = 'bs-pending';
              if (in_array($st, ['shipped','dikirim']) || strpos($st_p, 'dikirim') !== false) $stcls = 'bs-shipped';
              elseif (in_array($st, ['delivered','terkirim'])) $stcls = 'bs-delivered';
              elseif (in_array($st, ['completed','selesai'])) $stcls = 'bs-completed';
              elseif (in_array($st, ['cancelled','dibatalkan'])) $stcls = 'bs-cancelled';
              elseif (in_array($st, ['packed','dikemas']) || strpos($st_p, 'packed') !== false || strpos($st_p, 'kemas') !== false) $stcls = 'bs-packed';
              elseif (in_array($st, ['processing','confirmed','packing']) || strpos($st_p, 'perlu dikirim') !== false) $stcls = 'bs-processing';
              ?>
              <span class="badge-status <?= $stcls; ?>"><?= ucfirst($t->status_pesanan ?: $t->status); ?></span>
            </td>
            <td style="font-size:11px;"><?= htmlspecialchars($t->nomor_resi ?: '-'); ?></td>
            <td class="text-center">
              <button class="btn btn-xs btn-default btn-timeline" data-table="<?= $t->tbl; ?>" data-id="<?= $t->id; ?>" title="Lihat Timeline Follow-Up">
                <i class="fa fa-clock-o"></i>
              </button>
            </td>
          </tr>
          <!-- Detail Panel (FA-03, FA-05) -->
          <tr class="trx-detail-panel" id="detail-<?= $t->tbl; ?>-<?= $t->id; ?>">
            <td colspan="9" style="padding: 15px 25px;">
              <div class="row">
                <div class="col-md-7">
                  <h5 style="font-weight:700;color:#2c3e50;"><i class="fa fa-cubes"></i> Detail Item</h5>
                  <div class="detail-items-<?= $t->tbl; ?>-<?= $t->id; ?>">
                    <p class="text-muted"><i class="fa fa-spinner fa-spin"></i> Memuat...</p>
                  </div>
                  <hr>
                  <div style="font-size:12px;color:#6c757d;">
                    <strong>Penerima:</strong> <?= htmlspecialchars($t->nama_penerima ?: '-'); ?><br>
                    <strong>Alamat:</strong> <?= htmlspecialchars($t->alamat_pengiriman ?: '-'); ?><br>
                    <strong>Ekspedisi:</strong> <?= htmlspecialchars($t->kurir_ekspedisi ?: '-'); ?>
                  </div>
                </div>
                <div class="col-md-5">
                  <h5 style="font-weight:700;color:#2c3e50;"><i class="fa fa-clock-o"></i> Timeline Follow-Up</h5>
                  <div class="timeline-fu timeline-content-<?= $t->tbl; ?>-<?= $t->id; ?>">
                    <p class="text-muted"><i class="fa fa-spinner fa-spin"></i> Memuat...</p>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  // Toggle transaction detail panel
  $('.trx-row').on('click', function() {
    var tbl = $(this).data('table');
    var id = $(this).data('id');
    var panel = $('#detail-' + tbl + '-' + id);
    
    if (panel.is(':visible')) {
      panel.slideUp(200);
      return;
    }
    
    // Close other panels
    $('.trx-detail-panel').slideUp(200);
    panel.slideDown(300);
    
    // Load detail via AJAX (FA-03)
    $.ajax({
      url: BASE_URL + 'administrator/crm/transaction_detail_ajax',
      type: 'GET',
      data: { table: tbl, order_id: id },
      dataType: 'json',
      success: function(res) {
        if (res.success) {
          // Render items
          var itemHtml = '<table class="table table-condensed table-bordered" style="font-size:12px;margin:0;">';
          itemHtml += '<thead><tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead><tbody>';
          if (res.items.length > 0) {
            $.each(res.items, function(i, item) {
              itemHtml += '<tr>';
              itemHtml += '<td>' + (item.nama_produk || item.catatan || '-') + '</td>';
              itemHtml += '<td class="text-center">' + parseFloat(item.qty) + ' ' + (item.satuan || '') + '</td>';
              itemHtml += '<td class="text-right">Rp ' + parseInt(item.harga_satuan).toLocaleString('id-ID') + '</td>';
              itemHtml += '<td class="text-right">Rp ' + parseInt(item.subtotal).toLocaleString('id-ID') + '</td>';
              itemHtml += '</tr>';
            });
          } else {
            itemHtml += '<tr><td colspan="4" class="text-center text-muted">Tidak ada detail item</td></tr>';
          }
          itemHtml += '</tbody></table>';
          $('.detail-items-' + tbl + '-' + id).html(itemHtml);
          
          // Render timeline (FA-05)
          var tlHtml = '';
          if (res.timeline.length > 0) {
            $.each(res.timeline, function(i, tl) {
              var cls = 'tl-pending';
              var catName = tl.nama_kategori || '';
              if (catName.indexOf('H+') === -1) {
                catName += ' (H+' + tl.jumlah_hari + ')';
              }
              tlHtml += '<div class="tl-item ' + cls + '">';
              tlHtml += '<div class="tl-title">' + catName + '</div>';
              tlHtml += '<div class="tl-date">Target: ' + tl.tanggal_label_muncul + '</div>';
              tlHtml += '<div class="tl-status">';
              tlHtml += '<span class="label label-' + (tl.status_label === 'Pending' ? 'warning' : tl.status_label === 'Selesai' ? 'success' : 'info') + '">' + tl.status_label + '</span>';
              if (tl.broadcast_count > 0) tlHtml += ' <span class="label label-primary"><i class="fa fa-whatsapp"></i> ' + tl.broadcast_count + 'x</span>';
              tlHtml += '</div>';
              if (tl.notes) tlHtml += '<div style="font-size:11px;color:#6c757d;margin-top:4px;"><i class="fa fa-comment"></i> ' + tl.notes + '</div>';
              tlHtml += '</div>';
            });
          } else {
            tlHtml = '<p class="text-muted" style="font-size:12px;">Belum ada data follow-up</p>';
          }
          $('.timeline-content-' + tbl + '-' + id).html(tlHtml);
        }
      }
    });
  });
});
</script>
