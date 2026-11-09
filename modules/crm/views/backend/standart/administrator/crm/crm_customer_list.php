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
  background: #ffffff;
  border-radius: 14px;
  padding: 20px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.04);
  border: 1px solid #f1f5f9;
  border-left: 4px solid #3b82f6;
  margin-bottom: 16px;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  animation: crmFadeInUp 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}
.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.08);
}
.stat-card .stat-num { font-size: 26px; font-weight: 800; color: #1e293b; }
.stat-card .stat-label { font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; }

.box {
  animation: crmFadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
  border-radius: 12px !important;
  box-shadow: 0 4px 18px rgba(0,0,0,0.04) !important;
}

.table-responsive {
  -webkit-overflow-scrolling: touch;
}

.badge-source {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  color: #fff;
  display: inline-block;
  margin: 2px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  transition: transform 0.2s ease;
}
.badge-source:hover { transform: scale(1.05); }
.badge-toko { background: linear-gradient(135deg, #1e293b, #334155); }
.badge-shopee { background: linear-gradient(135deg, #ee4d2d, #ff6b4a); }
.badge-tokopedia { background: linear-gradient(135deg, #059669, #10b981); }
.badge-tiktok { background: linear-gradient(135deg, #09090b, #18181b); }

.table-crm th { background: #f1f5f9; font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: #475569; font-weight: 700; }
.table-crm td { vertical-align: middle !important; font-size: 13px; color: #334155; }
.table-crm tbody tr { transition: all 0.2s ease; }
.table-crm tbody tr:hover { background: #f8fafc !important; }

.pending-badge { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; }
.btn-wa { background: #25D366; color: #fff; border: none; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; transition: all 0.2s ease; }
.btn-wa:hover { background: #128C7E; color: #fff; transform: translateY(-1px); }

@media (max-width: 991px) {
  .crm-header-nav { padding: 16px 16px 12px 16px; margin-bottom: 12px; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 12px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn { font-size: 11px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
}

@media (max-width: 767px) {
  .content { padding: 8px 6px !important; }
  .crm-header-nav { padding: 14px 12px 10px 12px; border-radius: 12px; margin-bottom: 12px; }
  .crm-header-nav .header-title h2 { font-size: 18px; }
  .crm-header-nav .header-title p { font-size: 11px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn { font-size: 10.5px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
  .crm-header-nav .nav-tabs-bar { gap: 6px; padding-top: 10px; }
  .crm-header-nav .nav-tab-btn { font-size: 11.5px; padding: 6px 12px; }

  .box-body { padding: 10px !important; }
  .input-group .form-control { font-size: 12px; height: 36px; }
  .col-md-4 .btn { font-size: 11px; padding: 5px 10px; margin-bottom: 4px; }

  .table-responsive { border: none !important; margin-bottom: 0; }
  .table-crm { min-width: 780px; }
  .table-crm th { font-size: 10px; padding: 8px 4px !important; white-space: nowrap; }
  .table-crm td { font-size: 11px; padding: 8px 4px !important; }
  .badge-source { font-size: 9.5px; padding: 2px 7px; }
  .pending-badge { font-size: 10px; padding: 2px 8px; }
  .btn-wa { font-size: 10px; padding: 3px 8px; }

  .stat-card { padding: 14px; margin-bottom: 10px; }
  .stat-card .stat-num { font-size: 20px; }
  .stat-card .stat-label { font-size: 9.5px; }
}

@media (max-width: 480px) {
  .crm-header-nav .header-title h2 { font-size: 15px; }
  .col-md-4 { display: flex; flex-wrap: wrap; gap: 4px; }
  .col-md-4 .btn { flex: 1; min-width: 45%; font-size: 10px; }
  .table-crm th, .table-crm td { font-size: 10px; padding: 6px 3px !important; }
}
</style>

<section class="content" style="padding-top:15px;">
  <!-- Integrated Header Banner & Navigation -->
  <div class="crm-header-nav">
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> CRM & After Sales <i class="fa fa-angle-right"></i> <span>Daftar Customer</span>
        </div>
        <h2><i class="fa fa-address-book" style="color:#818cf8;"></i> Customer Directory CRM</h2>
        <p>Daftar pelanggan otomatis dari seluruh sumber penjualan — Toko, Shopee, Tokopedia, TikTok Shop</p>
      </div>

      <div class="action-tools">
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

  <!-- Search & Filter -->
  <div class="box box-default" style="border-radius:12px; border:1px solid #e2e8f0; box-shadow:0 2px 10px rgba(0,0,0,0.03); margin-bottom:18px;">
    <div class="box-body" style="padding:14px 18px;">
      <form method="get" action="<?= site_url('administrator/crm'); ?>">
        <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:10px;">
          <div style="display:flex; flex:1 1 480px; gap:10px; flex-wrap:wrap; align-items:center;">
            <div style="flex:1 1 260px; min-width:220px;">
              <div class="input-group">
                <span class="input-group-addon" style="border-radius:8px 0 0 8px; background:#f8fafc; border:1px solid #cbd5e1; border-right:none;"><i class="fa fa-search text-muted"></i></span>
                <input type="text" name="q" class="form-control" placeholder="Cari nama customer, nomor HP, atau nomor resi..." value="<?= htmlspecialchars($filter ?? ''); ?>" style="border-radius:0 8px 8px 0; height:38px; border:1px solid #cbd5e1; font-size:12.5px;">
              </div>
            </div>
            <div style="flex:0 1 220px; min-width:180px;">
              <select name="rfm_segment" class="form-control" style="border-radius:8px; height:38px; border:1px solid #cbd5e1; font-size:12.5px;">
                <option value="">-- Semua Segmen RFM --</option>
                <?php
                $segments_list = ['Champions', 'Loyal Customers', 'Potential Loyalist', 'New Customers', 'Big Spenders', 'Frequent Low Value', 'Need Attention', 'At Risk Customers', "Can't Lose Them", 'Hibernating'];
                foreach ($segments_list as $seg_item):
                  $sel = (strcasecmp($rfm_segment ?? '', $seg_item) === 0) ? 'selected' : '';
                ?>
                <option value="<?= $seg_item; ?>" <?= $sel; ?>><?= $seg_item; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          
          <div style="display:flex; gap:6px; align-items:center; flex-wrap:nowrap; margin-left:auto;">
            <button type="submit" class="btn btn-primary" style="border-radius:8px; height:38px; font-weight:700; padding:0 14px; display:inline-flex; align-items:center; gap:5px; font-size:12.5px; white-space:nowrap;"><i class="fa fa-search"></i> Filter</button>
            <a href="<?= site_url('administrator/crm'); ?>" class="btn btn-default" style="border-radius:8px; height:38px; font-weight:600; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12.5px; white-space:nowrap;"><i class="fa fa-refresh"></i> Reset</a>
            <a href="<?= site_url('administrator/crm/export_customers?q=' . urlencode($filter ?? '') . '&rfm_segment=' . urlencode($rfm_segment ?? '')); ?>" class="btn btn-success" style="border-radius:8px; height:38px; font-weight:700; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12.5px; white-space:nowrap; background:#10b981; border:none;"><i class="fa fa-file-excel-o"></i> CSV</a>
            <a href="<?= site_url('administrator/crm/export_customers_pdf?q=' . urlencode($filter ?? '') . '&rfm_segment=' . urlencode($rfm_segment ?? '')); ?>" target="_blank" class="btn btn-danger" style="border-radius:8px; height:38px; font-weight:700; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12.5px; white-space:nowrap; background:#ef4444; border:none;"><i class="fa fa-file-pdf-o"></i> PDF</a>
            <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="btn btn-warning" style="border-radius:8px; height:38px; font-weight:700; padding:0 14px; display:inline-flex; align-items:center; gap:5px; font-size:12.5px; white-space:nowrap; background:#f59e0b; border:none; color:#fff;"><i class="fa fa-tasks"></i> Journal</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Customer Table -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-address-book"></i> Daftar Customer (<?= number_format($customer_counts); ?> total)</h3>
    </div>
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover table-striped table-crm">
        <thead>
          <tr>
            <th style="width:40px">#</th>
            <th>Customer</th>
            <th>No. HP</th>
            <th>Sumber Penjualan</th>
            <th>Segmen RFM</th>
            <th class="text-center">Total Order</th>
            <th>Transaksi Terakhir</th>
            <th class="text-center">Pending Follow-Up</th>
            <th class="text-center" style="min-width:160px; width:160px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($customers)): ?>
          <tr><td colspan="9" class="text-center" style="padding:40px;color:#95a5a6;"><i class="fa fa-inbox fa-2x"></i><br>Belum ada data customer.</td></tr>
          <?php else: ?>
          <?php $no = ($this->uri->segment(4) ?: 0) + 1; foreach ($customers as $c): ?>
          <?php
            $rfm = isset($c->rfm) ? $c->rfm : $this->model_crm->calculate_rfm($c->last_order_date, $c->total_orders, $c->total_spend ?? 0);
            $badge = $rfm['badge'];
          ?>
          <tr>
            <td><?= $no++; ?></td>
            <td>
              <strong><?= htmlspecialchars($c->customer_nama); ?></strong>
              <?php if (!empty($c->nomor_resi) && $c->nomor_resi !== '-'): ?>
                <div style="margin-top:3px;">
                  <span class="label" style="font-family:monospace; font-size:10.5px; background:#f0f9ff; color:#0284c7; border:1px solid #bae6fd; font-weight:600; padding:2px 7px; border-radius:4px; display:inline-flex; align-items:center; gap:4px;" title="Nomor Resi: <?= htmlspecialchars($c->nomor_resi); ?>">
                    <i class="fa fa-barcode text-primary"></i> <?= htmlspecialchars($c->nomor_resi); ?>
                  </span>
                </div>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($c->customer_phone) && $c->customer_phone !== '-'): ?>
                <i class="fa fa-phone" style="color:#27ae60;"></i> <?= htmlspecialchars($c->customer_phone); ?>
              <?php else: ?>
                <span class="text-muted" style="font-size:11.5px; font-style:italic;" title="No. HP tidak dicantumkan pada label/resi"><i class="fa fa-phone-slash text-muted"></i> -</span>
              <?php endif; ?>
            </td>
            <td>
              <?php
              $sources = explode(', ', $c->sumber_penjualan);
              foreach ($sources as $s):
                $s = trim($s);
                $cls = 'badge-toko';
                if (stripos($s, 'Shopee') !== false) $cls = 'badge-shopee';
                elseif (stripos($s, 'Tokopedia') !== false) $cls = 'badge-tokopedia';
                elseif (stripos($s, 'TikTok') !== false) $cls = 'badge-tiktok';
                elseif (stripos($s, 'Resi') !== false) $cls = 'badge-tokopedia';
              ?>
              <span class="badge-source <?= $cls; ?>"><?= $s; ?></span>
              <?php endforeach; ?>
            </td>
            <td>
              <span class="badge-source" style="background:<?= $badge['bg']; ?>;color:<?= $badge['color']; ?>;border:1px solid <?= $badge['border']; ?>;font-weight:700;" data-toggle="tooltip" data-html="true" title="<b>Skor RFM:</b> <?= $rfm['rfm_display']; ?><br><b>Goal:</b> <?= htmlspecialchars($rfm['goal']); ?><br><b>Action:</b> <?= htmlspecialchars($rfm['action']); ?>">
                <i class="fa <?= $badge['icon']; ?>"></i> <?= htmlspecialchars($rfm['segment']); ?>
              </span>
              <span class="label label-default" style="font-size:10px;font-family:monospace;"><?= $rfm['rfm_display']; ?></span>
            </td>
            <td class="text-center"><strong><?= $c->total_orders; ?></strong></td>
            <td><?= $c->last_order_date ? date('d M Y', strtotime($c->last_order_date)) : '-'; ?></td>
            <td class="text-center">
              <?php if (isset($c->pending_followups) && $c->pending_followups > 0): ?>
                <span class="pending-badge"><?= $c->pending_followups; ?> pending</span>
              <?php else: ?>
                <span style="color:#27ae60;font-size:12px;"><i class="fa fa-check-circle"></i> Done</span>
              <?php endif; ?>
            </td>
            <td class="text-center" style="white-space:nowrap; min-width:160px; width:160px;">
              <?php
                $detail_param = (!empty($c->cust_group_key) && ($c->customer_phone === '-' || empty($c->customer_phone))) ? $c->cust_group_key : $c->customer_phone;
              ?>
              <a href="<?= site_url('administrator/crm/customer_detail?phone=' . urlencode($detail_param)); ?>" class="btn btn-sm btn-info" title="Lihat Detail & Analisis RFM" style="border-radius:6px; font-weight:700;">
                <i class="fa fa-eye"></i> Detail
              </a>
              <?php 
                $clean_phone = preg_replace('/[^0-9]/', '', $c->customer_phone ?? '');
                if (!empty($clean_phone) && strlen($clean_phone) >= 8):
                  $wa_phone = preg_replace('/^0/', '62', $clean_phone);
                  if (substr($wa_phone, 0, 2) !== '62') $wa_phone = '62' . $wa_phone;
                  $wa_action = !empty($rfm['action']) ? $rfm['action'] : 'Terima kasih telah menjadi pelanggan setia kami.';
                  $wa_msg = "Halo Kak " . $c->customer_nama . ",\n\nSalam dari Metafora! " . $wa_action . "\n\nAda yang bisa kami bantu hari ini?";
                  $direct_wa_url = 'https://api.whatsapp.com/send?phone=' . $wa_phone . '&text=' . rawurlencode($wa_msg);
              ?>
              <a href="<?= $direct_wa_url; ?>" target="_blank" class="btn btn-sm" style="background:#25D366; color:#fff; border:none; border-radius:6px; font-size:11px; font-weight:700; padding:4px 8px; margin-left:2px;" title="Buka Chat WhatsApp Langsung">
                <i class="fa fa-whatsapp"></i> Chat
              </a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
    <?php if (!empty($pagination)): ?>
    <div class="box-footer text-center"><?= $pagination; ?></div>
    <?php endif; ?>
  </div>
</section>
