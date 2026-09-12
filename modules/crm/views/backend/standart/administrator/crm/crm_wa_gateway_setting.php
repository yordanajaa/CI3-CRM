<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
.crm-header {
  background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #312e81 100%);
  color: #fff;
  padding: 28px 32px;
  border-radius: 16px;
  margin-bottom: 22px;
  box-shadow: 0 12px 30px rgba(15, 23, 42, 0.25);
}
.crm-header h2 { margin: 0 0 6px 0; font-weight: 800; font-size: 24px; letter-spacing: -0.5px; }
.crm-header p { margin: 0; opacity: 0.85; font-size: 13px; }

.box-clean {
  background: #ffffff;
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 4px 16px rgba(0,0,0,0.04);
  margin-bottom: 20px;
}
.box-clean .box-header {
  padding: 18px 24px;
  border-bottom: 1px solid #f1f5f9;
  background: #fafafa;
  border-top-left-radius: 14px;
  border-top-right-radius: 14px;
}
.box-clean .box-title { font-size: 16px; font-weight: 800; color: #1e293b; margin: 0; }

.provider-card {
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  padding: 16px;
  cursor: pointer;
  transition: all 0.25s ease;
  text-align: center;
  background: #fff;
}
.provider-card:hover, .provider-card.active {
  border-color: #25D366;
  background: #f0fdf4;
  box-shadow: 0 6px 18px rgba(37, 211, 102, 0.15);
}
.provider-card .p-title { font-weight: 800; font-size: 15px; color: #1e293b; }
.provider-card .p-desc { font-size: 11px; color: #64748b; margin-top: 4px; }

@media (max-width: 991px) {
  .col-md-7, .col-md-5 { width: 100%; }
}

@media (max-width: 767px) {
  .content { padding: 10px 8px !important; }
  .crm-header { padding: 18px 14px; text-align: center; border-radius: 12px; margin-bottom: 14px; }
  .crm-header h2 { font-size: 17px; }
  .crm-header p { font-size: 11px; }
  .crm-header .text-right { text-align: center !important; margin-top: 10px; }
  .crm-header .text-right .btn { font-size: 11px; }

  .box-clean { border-radius: 10px; margin-bottom: 14px; }
  .box-clean .box-header { padding: 12px 14px; }
  .box-clean .box-title { font-size: 13px; }
  .box-clean .box-body { padding: 14px !important; }

  .provider-card { padding: 12px 10px; margin-bottom: 8px; }
  .provider-card .p-title { font-size: 13px; }
  .provider-card .p-desc { font-size: 10px; }

  .form-control { font-size: 12px !important; }
  label { font-size: 11.5px !important; }
  .btn-block { font-size: 13px !important; }

  #test-result-box pre { font-size: 9px !important; max-height: 100px !important; overflow-x: auto; }
}

@media (max-width: 480px) {
  .crm-header h2 { font-size: 15px; }
  .provider-card .p-title { font-size: 12px; }
}
</style>

<section class="content" style="padding-top:15px;">
  <div class="crm-header">
    <div class="row">
      <div class="col-md-8">
        <h2><i class="fa fa-plug" style="color:#25D366;"></i> Pengaturan WhatsApp Gateway API</h2>
        <p>Integrasikan sistem CRM ERP secara otomatis dengan API Gateway (Fonnte, Wablas, WAHA, Starsender, atau Custom cURL)</p>
      </div>
      <div class="col-md-4 text-right" style="padding-top: 10px;">
        <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="btn btn-sm" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-arrow-left"></i> Kembali ke Journal</a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="box-clean">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-cogs text-success"></i> Konfigurasi Gateway API</h3>
        </div>
        <div class="box-body" style="padding:24px;">
          <form id="form-wa-config">
            <!-- Mode Selector -->
            <div class="form-group" style="margin-bottom:20px;">
              <label style="font-weight:700;font-size:13px;color:#1e293b;">Mode Pengiriman WhatsApp:</label>
              <select class="form-control" name="mode" id="config-mode" style="border-radius:8px;height:42px;font-weight:700;">
                <option value="wa_direct" <?= ($config->mode ?? '') === 'wa_direct' ? 'selected' : ''; ?>>🔗 WhatsApp Direct Link (Manual via wa.me / WhatsApp Web)</option>
                <option value="wa_gateway" <?= ($config->mode ?? '') === 'wa_gateway' ? 'selected' : ''; ?>>🚀 WhatsApp Gateway API (Otomatis Latar Belakang / Background API)</option>
              </select>
              <small class="text-muted"><i class="fa fa-info-circle"></i> Pilih <strong>WhatsApp Gateway API</strong> untuk mengirimkan pesan follow-up & broadcast secara otomatis di latar belakang tanpa mengklik wa.me satu-satu.</small>
            </div>

            <hr style="margin:20px 0;">

            <!-- Provider Selection -->
            <label style="font-weight:700;font-size:13px;color:#1e293b;margin-bottom:12px;display:block;">Pilih Provider Gateway API:</label>
            <div class="row" style="margin-bottom:20px;">
              <?php
              $cur_prov = strtolower($config->provider ?? 'fonnte');
              $providers = [
                'fonnte' => ['Fonnte', 'Fonnte.com WhatsApp API'],
                'wablas' => ['Wablas', 'Wablas.com API Gateway'],
                'waha' => ['WAHA', 'WAHA Self-Hosted (Docker/NodeJS)'],
                'starsender' => ['Starsender', 'Starsender.online API'],
                'custom' => ['Custom cURL', 'Universal HTTP POST API'],
              ];
              foreach ($providers as $key => $p):
              ?>
              <div class="col-md-4 col-sm-6" style="margin-bottom:12px;">
                <div class="provider-card <?= ($cur_prov === $key) ? 'active' : ''; ?>" data-provider="<?= $key; ?>">
                  <div class="p-title"><?= $p[0]; ?></div>
                  <div class="p-desc"><?= $p[1]; ?></div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <input type="hidden" name="provider" id="config-provider" value="<?= $cur_prov; ?>">

            <!-- Config Form Fields -->
            <div class="form-group">
              <label style="font-weight:700;font-size:12px;color:#334155;">API Key / Token Otentikasi <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="api_key" id="config-api-key" value="<?= htmlspecialchars($config->api_key ?? ''); ?>" placeholder="Masukkan API Key / Token Provider Anda..." style="border-radius:8px;height:40px;font-family:monospace;">
            </div>

            <div class="form-group">
              <label style="font-weight:700;font-size:12px;color:#334155;">API URL Endpoint</label>
              <input type="text" class="form-control" name="api_url" id="config-api-url" value="<?= htmlspecialchars($config->api_url ?? 'https://api.fonnte.com/send'); ?>" placeholder="https://api.fonnte.com/send" style="border-radius:8px;height:40px;font-family:monospace;">
              <small class="text-muted" id="url-help-text">URL endpoint default Fonnte: https://api.fonnte.com/send</small>
            </div>

            <div class="form-group">
              <label style="font-weight:700;font-size:12px;color:#334155;">Nomor WA Pengirim (Sender Phone / Device Number)</label>
              <input type="text" class="form-control" name="sender_phone" value="<?= htmlspecialchars($config->sender_phone ?? ''); ?>" placeholder="Contoh: 081234567890" style="border-radius:8px;height:40px;">
            </div>

            <div class="form-group" id="group-custom-headers" style="<?= ($cur_prov === 'custom') ? '' : 'display:none;'; ?>">
              <label style="font-weight:700;font-size:12px;color:#334155;">Header Tambahan (Custom Headers - 1 Header per Baris)</label>
              <textarea class="form-control" name="additional_headers" rows="3" placeholder="Contoh:&#10;X-Custom-Header: value&#10;Client-Secret: xxx" style="border-radius:8px;font-family:monospace;font-size:12px;"><?= htmlspecialchars($config->additional_headers ?? ''); ?></textarea>
            </div>

            <div style="margin-top:25px;">
              <button type="button" class="btn btn-success btn-lg btn-block" id="btn-save-wa-config" style="border-radius:10px;font-weight:700;background:#25D366;border:none;">
                <i class="fa fa-save"></i> Simpan Konfigurasi WA Gateway
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Test Connection Panel -->
    <div class="col-md-5">
      <div class="box-clean">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-paper-plane text-primary"></i> Uji Coba Kirim WA via API</h3>
        </div>
        <div class="box-body" style="padding:24px;">
          <p style="font-size:12px;color:#64748b;">Kirimkan pesan uji coba langsung ke nomor WhatsApp Anda untuk memastikan API Gateway berfungsi dengan sukses.</p>
          
          <div class="form-group">
            <label style="font-weight:700;font-size:12px;color:#334155;">Nomor WhatsApp Penerima Uji Coba</label>
            <input type="text" class="form-control" id="test-phone" placeholder="Contoh: 08123456789" style="border-radius:8px;height:40px;">
          </div>

          <div class="form-group">
            <label style="font-weight:700;font-size:12px;color:#334155;">Isi Pesan Uji Coba</label>
            <textarea class="form-control" id="test-message" rows="4" style="border-radius:8px;font-size:13px;">[Tes ERP Metafora CRM] Halo! Ini adalah pesan uji coba integrasi WhatsApp API Gateway secara langsung di latar belakang. 🎉</textarea>
          </div>

          <button type="button" class="btn btn-primary btn-block" id="btn-test-wa-api" style="border-radius:8px;font-weight:700;height:42px;">
            <i class="fa fa-paper-plane"></i> Kirim Pesan Uji Coba Sekarang
          </button>

          <div id="test-result-box" style="margin-top:15px;display:none;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Webhook URL Configuration for Incoming Messages -->
  <div class="row" style="margin-top:5px;">
    <div class="col-md-12">
      <div class="box-clean">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-exchange text-warning"></i> Webhook URL — Terima Balasan WA Customer</h3>
        </div>
        <div class="box-body" style="padding:24px;">
          <div style="background:#fefce8;border:1px solid #fde68a;border-radius:10px;padding:16px;margin-bottom:16px;">
            <p style="font-size:13px;color:#78350f;margin:0 0 10px;font-weight:600;">
              <i class="fa fa-lightbulb-o" style="color:#f59e0b;"></i> 
              Copy URL Webhook di bawah dan pasang di pengaturan Webhook provider WhatsApp API Anda agar balasan customer otomatis masuk ke sistem CRM.
            </p>
            
            <div style="margin-bottom:14px;">
              <label style="font-weight:700;font-size:12px;color:#92400e;margin-bottom:4px;display:block;">
                <i class="fa fa-whatsapp" style="color:#25D366;"></i> Fonnte Webhook URL:
              </label>
              <div style="display:flex;gap:8px;align-items:center;">
                <input type="text" class="form-control" readonly value="<?= base_url('administrator/crm/fonnte_webhook'); ?>" id="webhook-fonnte-url" style="font-family:monospace;font-size:12px;border-radius:8px;height:38px;background:#fff;flex:1;">
                <button class="btn btn-sm btn-default btn-copy-webhook" data-target="webhook-fonnte-url" style="border-radius:8px;height:38px;padding:0 14px;"><i class="fa fa-copy"></i> Copy</button>
              </div>
              <small class="text-muted" style="font-size:11px;">Paste URL ini di <strong>Fonnte Dashboard → Devices → Webhook URL</strong></small>
            </div>

            <div>
              <label style="font-weight:700;font-size:12px;color:#92400e;margin-bottom:4px;display:block;">
                <i class="fa fa-server" style="color:#6366f1;"></i> WAHA Webhook URL:
              </label>
              <div style="display:flex;gap:8px;align-items:center;">
                <input type="text" class="form-control" readonly value="<?= base_url('administrator/crm/waha_webhook'); ?>" id="webhook-waha-url" style="font-family:monospace;font-size:12px;border-radius:8px;height:38px;background:#fff;flex:1;">
                <button class="btn btn-sm btn-default btn-copy-webhook" data-target="webhook-waha-url" style="border-radius:8px;height:38px;padding:0 14px;"><i class="fa fa-copy"></i> Copy</button>
              </div>
              <small class="text-muted" style="font-size:11px;">Paste URL ini di <strong>WAHA → API → Sessions → Webhook URL</strong></small>
            </div>
          </div>
          
          <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:12px 16px;font-size:12px;color:#166534;">
            <i class="fa fa-check-circle" style="color:#22c55e;"></i>
            <strong>Cara Kerja:</strong> Saat customer membalas pesan WA, provider (Fonnte/WAHA) akan mengirimkan data balasan ke Webhook URL di atas secara otomatis. Sistem CRM akan mencocokkan nomor HP customer dan menyimpan balasan di riwayat chat follow-up.
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
  var _BASE = (typeof BASE_URL !== 'undefined') ? BASE_URL : '<?= base_url(); ?>';

  var presetUrls = {
    'fonnte': 'https://api.fonnte.com/send',
    'wablas': 'https://api.wablas.com/api/v2/send-message',
    'waha': 'http://localhost:3000',
    'starsender': 'https://api.starsender.online/api/sendText',
    'custom': ''
  };

  var presetPlaceholders = {
    'fonnte': 'Token Fonnte (contoh: aqFuf6TkqXjqHxvtRfbL)',
    'wablas': 'API Key / Secret Token Wablas',
    'waha': 'API Key WAHA (jika menggunakan otentikasi)',
    'starsender': 'API Key Starsender',
    'custom': 'API Key / Bearer Token'
  };

  $('.provider-card').on('click', function() {
    $('.provider-card').removeClass('active');
    $(this).addClass('active');
    var prov = $(this).data('provider');
    $('#config-provider').val(prov);

    if (presetUrls[prov] !== undefined) {
      $('#config-api-url').val(presetUrls[prov]);
      $('#url-help-text').text('URL endpoint preset ' + prov.toUpperCase() + ': ' + (presetUrls[prov] || 'Bebas / Custom URL'));
    }

    if (presetPlaceholders[prov]) {
      $('#config-api-key').attr('placeholder', presetPlaceholders[prov]);
    }
    
    if (prov === 'custom') {
      $('#group-custom-headers').slideDown(200);
    } else {
      $('#group-custom-headers').slideUp(200);
    }
  });

  // Save config
  $('#btn-save-wa-config').on('click', function() {
    var $btn = $(this);
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan Konfigurasi...');

    var formData = $('#form-wa-config').serializeArray();
    var payload = {};
    $.each(formData, function(i, field) {
      payload[field.name] = field.value;
    });
    if (csrf_name && csrf_hash) payload[csrf_name] = csrf_hash;

    $.ajax({
      url: _BASE + 'administrator/crm/save_wa_gateway_config_ajax',
      type: 'POST',
      data: payload,
      dataType: 'json',
      success: function(res) {
        $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Konfigurasi Tersimpan!');
        if (res.success) {
          if (typeof toastr !== 'undefined') toastr.success(res.message || 'Konfigurasi WA Gateway berhasil disimpan!');
          else alert(res.message || 'Konfigurasi berhasil disimpan');

          setTimeout(function() {
            location.reload();
          }, 1000);
        } else {
          $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Konfigurasi WA Gateway');
          if (typeof toastr !== 'undefined') toastr.error(res.message || 'Gagal menyimpan');
          else alert(res.message || 'Gagal menyimpan');
        }
      },
      error: function(xhr) {
        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Konfigurasi WA Gateway');
        alert('Gagal menyimpan konfigurasi: ' + (xhr.statusText || 'Terjadi kesalahan'));
      }
    });
  });

  // Test API Send
  $('#btn-test-wa-api').on('click', function() {
    var phone = $.trim($('#test-phone').val());
    var message = $.trim($('#test-message').val());

    if (!phone) {
      alert('Masukkan nomor WhatsApp penerima uji coba');
      return;
    }

    var $btn = $(this);
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Mengirim cURL API...');
    $('#test-result-box').hide();

    var payload = { phone: phone, message: message };
    if (csrf_name && csrf_hash) payload[csrf_name] = csrf_hash;

    $.ajax({
      url: _BASE + 'administrator/crm/test_wa_gateway_ajax',
      type: 'POST',
      data: payload,
      dataType: 'json',
      success: function(res) {
        $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Kirim Pesan Uji Coba Sekarang');
        var resHtml = '';
        if (res.success) {
          resHtml = '<div class="alert alert-success" style="border-radius:8px;font-size:12px;"><i class="fa fa-check-circle"></i> ' + res.message + '<br><pre style="font-size:10px;margin-top:6px;max-height:120px;">' + JSON.stringify(res.response, null, 2) + '</pre></div>';
        } else {
          resHtml = '<div class="alert alert-danger" style="border-radius:8px;font-size:12px;"><i class="fa fa-exclamation-triangle"></i> ' + res.message + '<br><pre style="font-size:10px;margin-top:6px;max-height:120px;">' + JSON.stringify(res.response || res, null, 2) + '</pre></div>';
        }
        $('#test-result-box').html(resHtml).slideDown(300);
      },
      error: function(xhr) {
        $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Kirim Pesan Uji Coba Sekarang');
        alert('Gagal menghubungi server API: ' + (xhr.statusText || 'Error'));
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
