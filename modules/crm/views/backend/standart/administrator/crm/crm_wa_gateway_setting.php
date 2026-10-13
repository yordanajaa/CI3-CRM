<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
:root {
  --crm-gradient: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
  --wa-green: #25D366;
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

/* Navigation Tab Bar */
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
.crm-header-nav .nav-tabs-bar::-webkit-scrollbar { display: none; }
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

.box-clean {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.06);
  border: 1px solid #e2e8f0;
  margin-bottom: 24px;
  overflow: hidden;
}
.box-clean .box-header {
  padding: 18px 24px;
  border-bottom: 1px solid #f1f5f9;
  background: #fafafa;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.box-clean .box-title { font-size: 16px; font-weight: 800; color: #1e293b; margin: 0; }

@keyframes wahaPulse {
  0% { transform: scale(0.95); opacity: 0.8; }
  50% { transform: scale(1.3); opacity: 1; }
  100% { transform: scale(0.95); opacity: 0.8; }
}
.waha-pulsing-dot {
  animation: wahaPulse 1.8s infinite ease-in-out;
  display: inline-block;
}

@media (max-width: 991px) {
  .crm-header-nav { padding: 16px 16px 12px 16px; margin-bottom: 12px; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 12px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn { font-size: 11px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
  .box-clean { margin-bottom: 16px; }
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

  .box-clean { border-radius: 12px; }
  .box-clean .box-header { padding: 12px 16px; flex-wrap: wrap; gap: 8px; }
  .box-clean .box-title { font-size: 14px; }
  .box-clean .box-body { padding: 14px !important; }

  #waha-qr-box { min-width: 0 !important; width: 100% !important; padding: 14px !important; }
  #waha-qr-img { max-width: 180px !important; }
  #waha-instructions { padding: 10px 12px !important; font-size: 11.5px !important; }
  #waha-instructions ol { padding-left: 16px !important; font-size: 11px !important; }

  .btn-copy-webhook { width: 100%; margin-top: 6px; }
}

@media (max-width: 480px) {
  .crm-header-nav .header-title h2 { font-size: 15px; }
  .crm-header-nav .action-tools { flex-direction: column; width: 100%; }
  .crm-header-nav .action-tools .btn { width: 100%; }
}
</style>

<section class="content" style="padding-top:15px;">
  <!-- Header Banner & Navigation -->
  <div class="crm-header-nav">
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> CRM & After Sales <i class="fa fa-angle-right"></i> <span>WhatsApp Gateway</span>
        </div>
        <h2><i class="fa fa-whatsapp" style="color:#25D366;"></i> Pusat Kontrol WhatsApp Gateway</h2>
        <p>Sistem terintegrasi langsung dengan WhatsApp secara real-time. Semua pengiriman pesan & balasan pelanggan berjalan otomatis di latar belakang.</p>
      </div>

      <div class="action-tools">
        <a href="<?= site_url('administrator/crm/chat'); ?>" class="btn" style="background:#25D366; color:#fff;" title="Buka Live Chat WA"><i class="fa fa-comments"></i> Buka Live Chat WA</a>
        <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="btn" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-arrow-left"></i> Kembali ke Journal</a>
      </div>
    </div>

    <!-- Navigation Tabs Bar -->
    <div class="nav-tabs-bar">
      <a href="<?= site_url('administrator/crm/dashboard'); ?>" class="nav-tab-btn">
        <i class="fa fa-tachometer"></i> 1. Dashboard CRM
      </a>
      <a href="<?= site_url('administrator/crm/chat'); ?>" class="nav-tab-btn">
        <i class="fa fa-comments"></i> 2. Live Chat WA
      </a>
      <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="nav-tab-btn">
        <i class="fa fa-tasks"></i> 3. Journal Follow-Up
      </a>
      <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="nav-tab-btn">
        <i class="fa fa-bullhorn"></i> 4. Broadcast WA
      </a>
      <a href="<?= site_url('administrator/crm'); ?>" class="nav-tab-btn">
        <i class="fa fa-users"></i> 5. Daftar Customer CRM
      </a>
    </div>
  </div>

  <div class="row">
    <!-- Left Column: Status, Live QR Scanner & Configuration -->
    <div class="col-md-7">
      
      <!-- Card 1: Status & Live QR Code Scanner -->
      <div class="box-clean">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-qrcode text-success"></i> Status & Live QR Code WhatsApp</h3>
          <span id="badge-waha-status" class="badge" style="background:#eab308; font-size:12px; font-weight:700; padding:6px 14px; border-radius:20px;">Memeriksa Koneksi...</span>
        </div>
        <div class="box-body" style="padding:24px; text-align:center;">

          <!-- Info Box WhatsApp -->
          <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:12px 18px; margin-bottom:20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
            <div style="text-align:left;">
              <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Status Koneksi WhatsApp:</div>
              <div style="font-size:13px; font-weight:800; color:#1e293b; display:flex; align-items:center; gap:6px; margin-top:2px;">
                <span class="waha-pulsing-dot" id="waha-pulse-indicator" style="width:9px; height:9px; border-radius:50%; background:#eab308;"></span>
                <span id="waha-server-label">Memeriksa status...</span>
              </div>
            </div>
            <div style="text-align:right;">
              <a href="http://localhost:3000/dashboard" target="_blank" class="btn btn-xs btn-primary" style="border-radius:8px; font-weight:700; background:#6366f1; border:none; padding:5px 12px;">
                <i class="fa fa-external-link"></i> Buka Dashboard WAHA
              </a>
            </div>
          </div>

          <!-- QR Code Display Box -->
          <div id="waha-qr-box" style="background:#fafafa; border:2px dashed #cbd5e1; border-radius:16px; padding:24px; display:inline-block; margin-bottom:18px; min-width:280px; min-height:280px;">
            <img id="waha-qr-img" src="<?= base_url('administrator/crm/waha_qr_image'); ?>" alt="QR Code WhatsApp" style="max-width:220px; border-radius:12px; box-shadow:0 6px 16px rgba(0,0,0,0.1); display:none;">
            
            <div id="waha-qr-loading" style="padding:50px 20px; color:#64748b;">
              <i class="fa fa-spinner fa-spin" style="font-size:36px; color:#6366f1;"></i>
              <p style="margin-top:12px; font-size:13px; font-weight:600;">Menghubungkan ke WhatsApp...</p>
            </div>

            <!-- Connected View (when WORKING) -->
            <div id="waha-connected-card" style="display:none; padding:30px 20px;">
              <i class="fa fa-check-circle" style="font-size:64px; color:#22c55e;"></i>
              <h3 style="font-weight:800; color:#15803d; margin:14px 0 6px;">WhatsApp Terhubung!</h3>
              <p style="color:#475569; font-size:13px; margin:0 0 10px;" id="waha-connected-number">Session default aktif & siap kirim/terima pesan.</p>
              <span class="badge" style="background:#dcfce7; color:#166534; border:1px solid #bbf7d0; font-size:11px; padding:5px 12px; border-radius:14px;">
                <i class="fa fa-bolt"></i> Engine: WEBJS Real-Time
              </span>
            </div>
          </div>

          <!-- Scan Instructions -->
          <div id="waha-instructions" style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:14px 18px; font-size:12.5px; color:#166534; text-align:left; margin-bottom:20px;">
            <div style="font-weight:800; margin-bottom:6px;"><i class="fa fa-mobile" style="font-size:16px;"></i> Cara Scan WhatsApp dari HP:</div>
            <ol style="margin:0; padding-left:20px; font-size:12px; line-height:1.7;">
              <li>Buka aplikasi <strong>WhatsApp</strong> di HP Anda.</li>
              <li>Ketuk <strong>Titik tiga (kanan atas)</strong> ➔ pilih <strong>Perangkat Tertaut</strong> (*Linked Devices*).</li>
              <li>Ketuk <strong>Tautkan Perangkat</strong>, lalu arahkan kamera ke QR Code di atas.</li>
            </ol>
          </div>

          <!-- Controls Button -->
          <div style="display:flex; gap:10px; justify-content:center; flex-wrap:wrap;">
            <button type="button" class="btn btn-default" id="btn-refresh-qr" style="border-radius:10px; font-size:12px; font-weight:700; padding:8px 18px;">
              <i class="fa fa-refresh"></i> Refresh Status / QR
            </button>
            <button type="button" class="btn btn-warning" id="btn-restart-session" style="border-radius:10px; font-size:12px; font-weight:700; padding:8px 18px;">
              <i class="fa fa-repeat"></i> Restart Session (QR Baru)
            </button>
          </div>

        </div>
      </div>

      <!-- Card 2: Server WhatsApp Configuration -->
      <div class="box-clean">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-sliders text-primary"></i> Konfigurasi Koneksi WhatsApp</h3>
        </div>
        <div class="box-body" style="padding:24px;">
          <form id="form-waha-config">
            <input type="hidden" name="mode" value="wa_gateway">
            <input type="hidden" name="provider" value="waha">

            <div class="form-group" style="margin-bottom:16px;">
              <label style="font-weight:700;font-size:12.5px;color:#334155;">WAHA API Endpoint URL <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="api_url" id="config-api-url" value="<?= htmlspecialchars($config->api_url ?? 'http://localhost:3000'); ?>" placeholder="http://localhost:3000" style="border-radius:8px;height:42px;font-family:monospace;font-weight:600;">
              <small class="text-muted"><i class="fa fa-info-circle"></i> Gunakan <code>http://localhost:3000</code> jika berjalan di laptop ini, atau IP VPS (contoh: <code>http://103.xxx:3000</code>) jika di server.</small>
            </div>

            <div class="form-group" style="margin-bottom:16px;">
              <label style="font-weight:700;font-size:12.5px;color:#334155;">WAHA API Key / Token Otentikasi</label>
              <input type="text" class="form-control" name="api_key" id="config-api-key" value="<?= htmlspecialchars($config->api_key ?? 'metafora123'); ?>" placeholder="metafora123" style="border-radius:8px;height:42px;font-family:monospace;">
              <small class="text-muted"><i class="fa fa-lock"></i> Kunci keamanan container WAHA (default: <code>metafora123</code>).</small>
            </div>

            <div class="form-group" style="margin-bottom:22px;">
              <label style="font-weight:700;font-size:12.5px;color:#334155;">Nomor WhatsApp Pengirim (Sender Number)</label>
              <input type="text" class="form-control" name="sender_phone" id="config-sender-phone" value="<?= htmlspecialchars($config->sender_phone ?? ''); ?>" placeholder="Contoh: 081234567890" style="border-radius:8px;height:42px;">
              <small class="text-muted">Nomor WhatsApp perangkat yang terhubung.</small>
            </div>

            <button type="button" class="btn btn-success btn-block" id="btn-save-waha-config" style="border-radius:10px;font-weight:700;height:44px;background:#25D366;border:none;box-shadow:0 4px 12px rgba(37,211,102,0.3);">
              <i class="fa fa-save"></i> Simpan Pengaturan WhatsApp
            </button>
          </form>
        </div>
      </div>

    </div>

    <!-- Right Column: Test Send & Webhook -->
    <div class="col-md-5">

      <!-- Card 3: Uji Coba Pengiriman WA -->
      <div class="box-clean">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-paper-plane text-primary"></i> Uji Coba Kirim WhatsApp</h3>
        </div>
        <div class="box-body" style="padding:24px;">
          <p style="font-size:12.5px;color:#64748b;margin-bottom:16px;">Kirim pesan uji coba langsung ke nomor WhatsApp Anda untuk memastikan sistem dapat mengirimkan pesan.</p>
          
          <div class="form-group" style="margin-bottom:14px;">
            <label style="font-weight:700;font-size:12px;color:#334155;">Nomor WhatsApp Penerima Uji Coba <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="test-phone" placeholder="Contoh: 08123456789" style="border-radius:8px;height:40px;font-weight:600;">
          </div>

          <div class="form-group" style="margin-bottom:16px;">
            <label style="font-weight:700;font-size:12px;color:#334155;">Isi Pesan Uji Coba</label>
            <textarea class="form-control" id="test-message" rows="4" style="border-radius:8px;font-size:13px;">[Tes ERP Metafora CRM] Halo! Ini adalah pesan uji coba integrasi WhatsApp secara real-time. 🎉</textarea>
          </div>

          <button type="button" class="btn btn-primary btn-block" id="btn-test-waha" style="border-radius:10px;font-weight:700;height:44px;background:#6366f1;border:none;box-shadow:0 4px 12px rgba(99,102,241,0.3);">
            <i class="fa fa-paper-plane"></i> Kirim Pesan Uji Coba Sekarang
          </button>

          <div id="test-result-box" style="margin-top:16px;display:none;"></div>
        </div>
      </div>

      <!-- Card 4: Webhook Real-Time WAHA -->
      <div class="box-clean">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-exchange text-warning"></i> Webhook Terima Pesan Masuk</h3>
        </div>
        <div class="box-body" style="padding:24px;">
          <div style="background:#fefce8;border:1px solid #fde68a;border-radius:12px;padding:16px;margin-bottom:16px;">
            <label style="font-weight:700;font-size:12px;color:#92400e;margin-bottom:6px;display:block;">
              <i class="fa fa-server" style="color:#6366f1;"></i> WAHA Webhook URL:
            </label>
            <div style="display:flex;gap:8px;align-items:center;">
              <input type="text" class="form-control" readonly value="<?= base_url('administrator/crm/waha_webhook'); ?>" id="webhook-waha-url" style="font-family:monospace;font-size:11.5px;border-radius:8px;height:38px;background:#fff;flex:1;">
              <button class="btn btn-sm btn-default btn-copy-webhook" data-target="webhook-waha-url" style="border-radius:8px;height:38px;padding:0 14px;"><i class="fa fa-copy"></i> Copy</button>
            </div>
            <small class="text-muted" style="font-size:11px;margin-top:6px;display:block;">Sistem otomatis meneruskan pesan masuk ke URL webhook ini.</small>
          </div>
          
          <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;font-size:12px;color:#166534;line-height:1.5;">
            <i class="fa fa-check-circle" style="color:#22c55e;"></i>
            <strong>Cara Kerja Real-Time:</strong> Saat customer membalas chat WhatsApp di HP-nya, pesan langsung diterima ke sistem CRM secara instan. Pesan otomatis muncul di <strong>Live Chat WA</strong> tanpa perlu reload halaman!
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  var csrf_name = '<?= $this->security->get_csrf_token_name(); ?>';
  var csrf_hash = '<?= $this->security->get_csrf_hash(); ?>';
  var rawBase = (typeof BASE_URL !== 'undefined') ? BASE_URL : '<?= base_url(); ?>';
  var _BASE = rawBase.replace(/\/+$/, '') + '/';

  function buildPayload(data) {
    if (csrf_name && csrf_hash) data[csrf_name] = csrf_hash;
    return data;
  }

  // Real-Time Polling for WAHA status
  function checkWahaStatus() {
    $.getJSON(_BASE + 'administrator/crm/waha_status_ajax', function(res) {
      if (res && res.success) {
        var phone = (res.session && res.session.me && res.session.me.id) ? res.session.me.id.replace('@c.us', '') : '';
        
        if (res.status === 'WORKING' || res.status === 'CONNECTED') {
          $('#badge-waha-status').css('background', '#22c55e').html('<i class="fa fa-check-circle"></i> Terhubung & Aktif');
          $('#waha-pulse-indicator').css({ background: '#22c55e', boxShadow: '0 0 8px #22c55e' });
          $('#waha-server-label').html('Status: <span style="color:#15803d;font-weight:800;">CONNECTED</span> (Port: 3000)');

          $('#waha-qr-loading').hide();
          $('#waha-qr-img').hide();
          $('#waha-connected-card').show();
          $('#waha-instructions').hide();
          if (phone) {
            $('#waha-connected-number').html('Nomor WhatsApp: <strong>' + phone + '</strong> | Session <code>default</code>');
            if (!$('#config-sender-phone').val()) {
              $('#config-sender-phone').val(phone);
            }
          }
        } else if (res.status === 'SCAN_QR_CODE') {
          $('#badge-waha-status').css('background', '#eab308').html('<i class="fa fa-qrcode"></i> Menunggu Scan QR');
          $('#waha-pulse-indicator').css({ background: '#eab308', boxShadow: '0 0 8px #eab308' });
          $('#waha-server-label').html('Status: <span style="color:#d97706;font-weight:800;">SCAN_QR_CODE</span>');

          $('#waha-qr-loading').hide();
          $('#waha-connected-card').hide();
          $('#waha-instructions').show();
          $('#waha-qr-img').attr('src', res.qr_url).show();
        } else {
          $('#badge-waha-status').css('background', '#64748b').text('STATUS: ' + res.status);
          $('#waha-server-label').text('Status: ' + res.status);
        }
      } else {
        $('#badge-waha-status').css('background', '#ef4444').text('WhatsApp Terputus');
        $('#waha-pulse-indicator').css({ background: '#ef4444', boxShadow: 'none' });
        $('#waha-server-label').html('<span style="color:#ef4444;font-weight:800;">OFFLINE</span>');
      }
    }).fail(function() {
      $('#badge-waha-status').css('background', '#ef4444').text('WhatsApp Terputus');
    });
  }

  // Initial check & interval poll every 3.5 seconds
  checkWahaStatus();
  setInterval(checkWahaStatus, 3500);

  // Refresh QR
  $('#btn-refresh-qr').on('click', function() {
    var $b = $(this);
    $b.html('<i class="fa fa-spinner fa-spin"></i> Refreshing...');
    $('#waha-qr-img').attr('src', _BASE + 'administrator/crm/waha_qr_image?t=' + new Date().getTime());
    checkWahaStatus();
    setTimeout(function() {
      $b.html('<i class="fa fa-refresh"></i> Refresh Status / QR');
    }, 1000);
  });

  // Restart WAHA Session
  $('#btn-restart-session').on('click', function() {
    var $b = $(this);
    if (!confirm('Restart session WAHA untuk mendapatkan QR code baru?')) return;
    $b.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Restarting Session...');
    $.post(_BASE + 'administrator/crm/waha_restart_session_ajax', buildPayload({}), function(res) {
      if (typeof toastr !== 'undefined') toastr.info(res.message || 'Session restarted');
      setTimeout(function() {
        checkWahaStatus();
        $b.prop('disabled', false).html('<i class="fa fa-repeat"></i> Restart Session (QR Baru)');
      }, 3000);
    });
  });

  // Save WAHA config
  $('#btn-save-waha-config').on('click', function() {
    var $btn = $(this);
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan Konfigurasi...');

    var formData = $('#form-waha-config').serializeArray();
    var payload = {};
    $.each(formData, function(i, field) {
      payload[field.name] = field.value;
    });

    $.ajax({
      url: _BASE + 'administrator/crm/save_wa_gateway_config_ajax',
      type: 'POST',
      data: buildPayload(payload),
      dataType: 'json',
      success: function(res) {
        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Pengaturan Server WAHA');
        if (res.success) {
          if (typeof toastr !== 'undefined') toastr.success(res.message || 'Pengaturan WAHA berhasil disimpan!');
          else alert(res.message || 'Pengaturan berhasil disimpan');
          checkWahaStatus();
        } else {
          if (typeof toastr !== 'undefined') toastr.error(res.message || 'Gagal menyimpan');
          else alert(res.message || 'Gagal menyimpan');
        }
      },
      error: function() {
        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Pengaturan Server WAHA');
        alert('Gagal menghubungi server');
      }
    });
  });

  // Test WAHA Send Message
  $('#btn-test-waha').on('click', function() {
    var phone = $.trim($('#test-phone').val());
    var message = $.trim($('#test-message').val());

    if (!phone) {
      alert('Masukkan nomor WhatsApp penerima uji coba');
      return;
    }

    var $btn = $(this);
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Mengirim pesan...');
    $('#test-result-box').hide();

    $.ajax({
      url: _BASE + 'administrator/crm/test_wa_gateway_ajax',
      type: 'POST',
      data: buildPayload({ phone: phone, message: message }),
      dataType: 'json',
      success: function(res) {
        $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Kirim Pesan Uji Coba Sekarang');
        var resHtml = '';
        if (res.success) {
          resHtml = '<div class="alert alert-success" style="border-radius:10px;font-size:12.5px;"><i class="fa fa-check-circle"></i> ' + res.message + '<br><pre style="font-size:10.5px;margin-top:8px;max-height:120px;background:#fff;border:none;">' + JSON.stringify(res.response, null, 2) + '</pre></div>';
        } else {
          resHtml = '<div class="alert alert-danger" style="border-radius:10px;font-size:12.5px;"><i class="fa fa-exclamation-triangle"></i> ' + res.message + '<br><pre style="font-size:10.5px;margin-top:8px;max-height:120px;background:#fff;border:none;">' + JSON.stringify(res.response || res, null, 2) + '</pre></div>';
        }
        $('#test-result-box').html(resHtml).slideDown(300);
      },
      error: function() {
        $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Kirim Pesan Uji Coba Sekarang');
        alert('Gagal menghubungi server');
      }
    });
  });

  // Copy Webhook URL
  $(document).on('click', '.btn-copy-webhook', function() {
    var targetId = $(this).data('target');
    var $input = $('#' + targetId);
    $input.select();
    document.execCommand('copy');
    var $btn = $(this);
    $btn.html('<i class="fa fa-check"></i> Copied!').css('color','#22c55e');
    setTimeout(function() { $btn.html('<i class="fa fa-copy"></i> Copy').css('color',''); }, 2000);
  });
});
</script>
