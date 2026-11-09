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

.box-clean {
  background: #ffffff;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 4px 16px rgba(0,0,0,0.03);
  margin-bottom: 20px;
  animation: crmFadeInUp 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}

.table-responsive {
  -webkit-overflow-scrolling: touch;
}
.box-clean .box-header {
  padding: 16px 20px;
  border-bottom: 1px solid #f1f5f9;
  background: #fafafa;
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
}
.box-clean .box-title { font-size: 15px; font-weight: 800; color: #1e293b; margin: 0; }

.badge-source {
  padding: 3px 10px;
  border-radius: 12px;
  font-size: 10px;
  font-weight: 700;
  color: #fff;
  display: inline-block;
  white-space: nowrap;
}
.badge-toko { background: #1e293b; }
.badge-shopee { background: #ee4d2d; }
.badge-tokopedia { background: #059669; }
.badge-tiktok { background: #09090b; }

.table-log th { background: #f1f5f9; font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.4px; color: #475569; font-weight: 700; padding: 8px 6px !important; }
.table-log td { font-size: 11px; vertical-align: middle !important; color: #334155; padding: 8px 6px !important; }
.table-log tbody tr:hover { background: #f8fafc !important; }

.btn-indigo { background: #4f46e5; color: #fff; border: none; font-weight: 700; border-radius: 8px; transition: all 0.2s; }
.btn-indigo:hover { background: #4338ca; color: #fff; }

.filter-broadcast-row {
  display: grid;
  grid-template-columns: 1.25fr 1fr 1.15fr 170px;
  align-items: flex-start;
  gap: 14px;
}
.filter-broadcast-col {
  min-width: 0;
}
.filter-broadcast-btn {
  width: 100% !important;
  height: 42px !important;
  font-size: 13px !important;
  font-weight: 700 !important;
  border-radius: 9px !important;
  background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%) !important;
  border: none !important;
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28) !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 8px !important;
  padding: 0 16px !important;
  white-space: nowrap !important;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.filter-broadcast-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(79, 70, 229, 0.38) !important;
  background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%) !important;
}

@media (max-width: 991px) {
  .filter-broadcast-row {
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 12px !important;
  }
  .filter-broadcast-col {
    width: 100% !important;
  }
  .filter-broadcast-col.col-action {
    grid-column: span 2;
  }
  .filter-broadcast-btn {
    width: 100% !important;
  }
}

@media (max-width: 600px) {
  .filter-broadcast-row {
    grid-template-columns: 1fr !important;
    gap: 10px !important;
  }
  .filter-broadcast-col.col-action {
    grid-column: span 1;
  }
}

@media (max-width: 991px) {
  .crm-header-nav { padding: 16px 16px 12px 16px; margin-bottom: 12px; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 12px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn { font-size: 11px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
  .box-clean .form-group { margin-bottom: 10px !important; }
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

  .box-clean { border-radius: 10px; margin-bottom: 14px; }
  .box-clean .box-header { padding: 12px 14px; }
  .box-clean .box-title { font-size: 13px; }
  .box-clean .box-body { padding: 14px !important; }

  .box-body .row { margin-left: -4px; margin-right: -4px; }
  .box-body .row > [class*="col-"] { padding-left: 4px; padding-right: 4px; margin-bottom: 10px; }
  .box-body .form-control { font-size: 12px; height: 36px; }
  .box-body label { font-size: 11px !important; }

  #recipients-list { max-height: 200px; padding: 10px; font-size: 11.5px; }
  #btn-execute-broadcast { font-size: 13px !important; padding: 10px !important; border-radius: 8px !important; }

  .table-responsive { border: none !important; margin-bottom: 0; }
  .table-log { min-width: 650px; }
  .table-log th { font-size: 9.5px; padding: 6px 4px !important; }
  .table-log td { font-size: 10.5px; padding: 6px 4px !important; }
  .badge-source { font-size: 9px; padding: 2px 6px; }
}

@media (max-width: 480px) {
  .crm-header-nav .header-title h2 { font-size: 15px; }
  .crm-header-nav .action-tools { flex-direction: column; width: 100%; }
  .crm-header-nav .action-tools .btn { width: 100%; }
  .table-log th, .table-log td { font-size: 9.5px; padding: 5px 3px !important; }
}
</style>

<section class="content" style="padding-top: 15px;">
  <!-- Integrated Header Banner & Navigation -->
  <div class="crm-header-nav">
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> CRM & After Sales <i class="fa fa-angle-right"></i> <span>Broadcast WA</span>
        </div>
        <h2><i class="fa fa-bullhorn" style="color:#818cf8;"></i> Broadcast WhatsApp Massal</h2>
        <p>Kirim pesan massal ke kelompok customer berdasarkan label H+ & Cegah duplikasi pengiriman otomatis</p>
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
      <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-whatsapp"></i> 3. Broadcast WA
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
  <!-- BAGIAN ATAS: Panel Form Kirim Broadcast Baru -->
  <div class="row">
    <div class="col-md-12">
      <div class="box-clean" style="border-radius:14px; border:1px solid #e2e8f0; box-shadow:0 4px 20px rgba(0,0,0,0.04); background:#ffffff; margin-bottom:24px;">
        <div class="box-header" style="padding:16px 22px; background:#fafbfc; border-bottom:1px solid #edf2f7; border-top-left-radius:14px; border-top-right-radius:14px; display:flex; align-items:center; justify-content:space-between;">
          <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:32px; height:32px; border-radius:8px; background:#e0e7ff; color:#4338ca; display:flex; align-items:center; justify-content:center; font-size:14px;">
              <i class="fa fa-paper-plane"></i>
            </div>
            <div>
              <h3 class="box-title" style="font-size:15px; font-weight:800; color:#0f172a; margin:0;">Kirim Broadcast Baru</h3>
              <p style="margin:2px 0 0 0; font-size:12px; color:#64748b;">Pilih target kategori label H+ dan filter customer penerima pesan broadcast</p>
            </div>
          </div>
        </div>
        <div class="box-body" style="padding:22px;">
          <div class="filter-broadcast-row">
            <div class="filter-broadcast-col col-category">
              <div class="form-group" style="margin-bottom:0;">
                <label style="font-size:12px; font-weight:700; color:#334155; margin-bottom:6px; display:flex; align-items:center; gap:4px;">
                  <i class="fa fa-tag text-indigo"></i> Pilih Kategori Label H+ <span class="text-danger">*</span>
                </label>
                <select class="form-control" id="bc-category" style="border-radius:9px; height:42px; font-size:13px; font-weight:500; border:1px solid #cbd5e1;">
                  <option value="">-- Pilih Kategori --</option>
                  <?php foreach ($categories as $cat): ?>
                  <?php
                  $cat_name = htmlspecialchars($cat->nama_kategori);
                  $cat_lbl = $cat_name . ' (H+' . $cat->jumlah_hari . ')';
                  ?>
                  <option value="<?= $cat->id; ?>"><?= $cat_lbl; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="filter-broadcast-col col-source">
              <div class="form-group" style="margin-bottom:0;">
                <label style="font-size:12px; font-weight:700; color:#334155; margin-bottom:6px; display:flex; align-items:center; gap:4px;">
                  <i class="fa fa-shopping-cart text-indigo"></i> Filter Sumber Penjualan
                </label>
                <select class="form-control" id="bc-source" style="border-radius:9px; height:42px; font-size:13px; font-weight:500; border:1px solid #cbd5e1;">
                  <option value="">Semua Sumber (Toko & Online)</option>
                  <option value="Toko">Toko / Offline SO</option>
                  <option value="Shopee">Shopee</option>
                  <option value="Tokopedia">Tokopedia</option>
                  <option value="TikTok Shop">TikTok Shop</option>
                </select>
              </div>
            </div>

            <div class="filter-broadcast-col col-rfm">
              <div class="form-group" style="margin-bottom:0;">
                <label style="font-size:12px; font-weight:700; color:#334155; margin-bottom:6px; display:flex; align-items:center; gap:4px;">
                  <i class="fa fa-pie-chart text-indigo"></i> Filter Segmen RFM
                </label>
                <select class="form-control" id="bc-rfm-segment" style="border-radius:9px; height:42px; font-size:13px; font-weight:500; border:1px solid #cbd5e1;">
                  <option value="">Semua Segmen Customer</option>
                  <option value="Champions">🏆 Champions (Setia & High Value)</option>
                  <option value="Loyal Customers">⭐ Loyal Customers (Frequent Buyers)</option>
                  <option value="Potential Loyalist">🌱 Potential Loyalist (Potensial Setia)</option>
                  <option value="New Customers">🆕 New Customers (Pelanggan Baru)</option>
                  <option value="Big Spenders">💎 Big Spenders (Belanja Besar)</option>
                  <option value="Frequent Low Value">🔄 Frequent Low Value (Sering, Nilai Kecil)</option>
                  <option value="Need Attention">⚠️ Need Attention (Butuh Perhatian)</option>
                  <option value="At Risk Customers">🚨 At Risk Customers (Risiko Churn)</option>
                  <option value="Can't Lose Them">🔥 Can't Lose Them (Wajib Dipertahankan)</option>
                  <option value="Hibernating">💤 Hibernating (Dormant / Pasif)</option>
                </select>
              </div>
            </div>

            <div class="filter-broadcast-col col-action">
              <div class="form-group" style="margin-bottom:0;">
                <label style="font-size:12px; font-weight:700; color:#334155; margin-bottom:6px; display:flex; align-items:center; gap:4px;">
                  <i class="fa fa-bolt text-indigo"></i> Aksi
                </label>
                <button class="btn btn-indigo filter-broadcast-btn" id="btn-load-recipients">
                  <i class="fa fa-users"></i> <span>Muat Penerima</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Preview Penerima -->
          <div id="recipients-container" style="display:none; border-top: 1px solid #e2e8f0; padding-top: 18px; margin-top: 20px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
              <h5 style="margin:0; font-weight:800; color:#1e293b; font-size:14px;"><i class="fa fa-user-check text-success"></i> Daftar Penerima Siap Kirim (<span id="recipient-count">0</span> customer)</h5>
              <button class="btn btn-sm btn-default" id="btn-toggle-all-bc" style="border-radius:6px; font-weight:600;"><i class="fa fa-check-square-o"></i> Pilih Semua</button>
            </div>

            <div id="recipients-list" style="max-height: 250px; overflow-y: auto; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; padding: 14px;">
              <!-- Dynamic Checkbox List -->
            </div>

            <div class="alert alert-info" style="margin-top: 15px; font-size: 12px; padding: 10px 14px; border-radius:8px; background:#eff6ff; color:#1e40af; border:1px solid #bfdbfe;">
              <i class="fa fa-info-circle"></i> Sesuai Aturan (FB-10), customer yang sudah menerima broadcast untuk label ini tidak akan terkirim ulang secara otomatis.
            </div>

            <button class="btn btn-success btn-block btn-lg" id="btn-execute-broadcast" style="margin-top: 15px; border-radius:10px; font-weight:800; background:#059669; border:none; padding:12px; font-size:14px;">
              <i class="fa fa-whatsapp"></i> Mulai Broadcast Sekarang
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- BAGIAN BAWAH: Panel Log Broadcast Terakhir -->
  <div class="row">
    <div class="col-md-12">
      <div class="box-clean">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-history text-indigo"></i> Log Broadcast Terakhir</h3>
        </div>
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover table-striped table-log" style="width:100%;">
            <thead>
              <tr>
                <th style="width:130px;">Waktu Kirim</th>
                <th style="width:110px;">Pengirim</th>
                <th style="min-width:160px;">Customer</th>
                <th style="width:130px;">No. HP</th>
                <th style="min-width:180px;">Kategori Label</th>
                <th style="width:110px;">Sumber Order</th>
                <th class="text-center" style="width:120px;">Status Kirim</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($logs)): ?>
              <tr><td colspan="7" class="text-center" style="padding:40px; color:#94a3b8;"><i class="fa fa-inbox fa-2x"></i><br>Belum ada riwayat broadcast.</td></tr>
              <?php else: foreach ($logs as $log): ?>
              <tr>
                <td style="font-size:12px; white-space:nowrap; font-weight:600; color:#64748b;"><?= date('d/m/Y H:i', strtotime($log->waktu_kirim)); ?></td>
                <td><strong style="color:#1e293b; font-size:12px;"><?= htmlspecialchars($log->dikirim_oleh); ?></strong></td>
                <td style="font-weight:600; color:#1e293b; font-size:12px;"><?= htmlspecialchars($log->customer_nama); ?></td>
                <td style="font-size:12px; font-weight:600; color:#475569; white-space:nowrap;"><?= htmlspecialchars($log->customer_phone); ?></td>
                <td>
                  <span class="label label-info" style="border-radius:10px; font-weight:600; font-size:11px; padding:4px 10px; display:inline-block;"><?= htmlspecialchars($log->nama_kategori); ?></span>
                </td>
                <td>
                  <?php
                  $cls = 'badge-toko';
                  if (stripos($log->order_source, 'Shopee') !== false) $cls = 'badge-shopee';
                  elseif (stripos($log->order_source, 'Tokopedia') !== false) $cls = 'badge-tokopedia';
                  elseif (stripos($log->order_source, 'TikTok') !== false) $cls = 'badge-tiktok';
                  ?>
                  <span class="badge-source <?= $cls; ?>"><?= $log->order_source; ?></span>
                </td>
                <td class="text-center">
                  <span class="label label-success" style="border-radius:10px; font-weight:700; font-size:11px; padding:5px 12px; display:inline-block;"><i class="fa fa-check"></i> <?= $log->status_kirim; ?></span>
                </td>
              </tr>
              <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  var csrf_name = '<?= $this->security->get_csrf_token_name(); ?>';
  var csrf_hash = '<?= $this->security->get_csrf_hash(); ?>';
  var _BASE = (typeof BASE_URL !== 'undefined') ? BASE_URL : '<?= base_url(); ?>';

  function buildPayload(data) {
    if (!data) data = {};
    if (csrf_name && csrf_hash) data[csrf_name] = csrf_hash;
    return data;
  }

  function parseRes(res) {
    if (typeof res === 'object') return res;
    try { return JSON.parse(res); } catch(e) { return { success: false, message: 'Gagal parse response' }; }
  }

  function notify(type, msg) {
    if (typeof toastr !== 'undefined' && typeof toastr[type] === 'function') {
      toastr[type](msg);
    } else {
      alert(msg);
    }
  }

  $('#btn-load-recipients').on('click', function() {
    var cat_id = $('#bc-category').val();
    var source = $('#bc-source').val();
    var rfm_seg = $('#bc-rfm-segment').val();

    if (!cat_id) {
      notify('warning', 'Pilih kategori label H+ terlebih dahulu.');
      return;
    }

    $.get(_BASE + 'administrator/crm/get_broadcast_recipients_ajax', {
      category_id: cat_id, order_source: source, rfm_segment: rfm_seg
    }, function(res) {
      var r = parseRes(res);
      if (r.success) {
        var html = '';
        if (r.recipients && r.recipients.length > 0) {
          $.each(r.recipients, function(i, item) {
            html += '<div style="margin-bottom:6px; font-size:12px;">';
            html += '<label style="font-weight:normal; cursor:pointer;">';
            html += '<input type="checkbox" class="cb-bc-item" value="' + item.id + '" checked> ';
            html += '<strong>' + (item.customer_nama || '-') + '</strong> (' + (item.customer_phone || '-') + ') — <span class="text-muted">' + (item.no_pesanan || '-') + '</span>';
            html += '</label>';
            html += '</div>';
          });
          $('#recipient-count').text(r.recipients.length);
          $('#btn-execute-broadcast').prop('disabled', false);
        } else {
          html = '<div class="text-center text-muted" style="padding:15px;"><i class="fa fa-info-circle"></i> Tidak ada customer pending untuk kategori ini.</div>';
          $('#recipient-count').text(0);
          $('#btn-execute-broadcast').prop('disabled', true);
        }
        $('#recipients-list').html(html);
        $('#recipients-container').slideDown(300);
      } else {
        notify('error', r.message || 'Gagal memuat daftar penerima');
      }
    }).fail(function() {
      notify('error', 'Gagal menghubungi server');
    });
  });

  $('#btn-toggle-all-bc').on('click', function() {
    var allChecked = $('.cb-bc-item:checked').length === $('.cb-bc-item').length;
    $('.cb-bc-item').prop('checked', !allChecked);
  });

  $('#btn-execute-broadcast').on('click', function() {
    var selectedIds = [];
    $('.cb-bc-item:checked').each(function() {
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) {
      notify('warning', 'Pilih minimal 1 customer untuk dikirimkan broadcast.');
      return;
    }

    if (typeof swal === 'function') {
      swal({
        title: 'Mulai Broadcast WA?',
        text: 'Total ' + selectedIds.length + ' pesan akan disiapkan & dicatat ke sistem.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kirim Sekarang!',
        cancelButtonText: 'Batal'
      }, function(confirmed) {
        if (confirmed) doExecuteBroadcast(selectedIds);
      });
    } else {
      if (confirm('Kirim broadcast WA ke ' + selectedIds.length + ' customer?')) {
        doExecuteBroadcast(selectedIds);
      }
    }
  });

  function doExecuteBroadcast(selectedIds) {
    $.post(_BASE + 'administrator/crm/send_broadcast_ajax', buildPayload({
      label_ids: selectedIds
    }), function(res) {
      var r = parseRes(res);
      if (r.success) {
        if (r.mode === 'wa_gateway') {
          notify('success', 'Berhasil mengirim ' + r.count + ' pesan WA otomatis via WhatsApp Gateway API!');
          setTimeout(function() { location.reload(); }, 1500);
        } else if (r.wa_links) {
          var delay = 0;
          $.each(r.wa_links, function(i, item) {
            setTimeout(function() {
              window.open(item.link, '_blank');
            }, delay);
            delay += 2000;
          });
          notify('success', r.count + ' pesan WA sedang diproses batch!');
          setTimeout(function() {
            location.reload();
          }, 3000);
        }
      } else {
        notify('error', r.message || 'Gagal mengirim broadcast');
      }
    }).fail(function() {
      notify('error', 'Gagal menghubungi server');
    });
  }
});
</script>
