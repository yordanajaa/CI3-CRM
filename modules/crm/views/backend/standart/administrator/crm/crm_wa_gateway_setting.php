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

@media (max-width: 767px) {
  .crm-header { padding: 20px 16px; text-align: center; }
  .crm-header h2 { font-size: 18px; }
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
</section>

<script>
$(document).ready(function() {
  var presetUrls = {
    'fonnte': 'https://api.fonnte.com/send',
    'wablas': 'https://api.wablas.com/api/v2/send-message',
    'waha': 'http://localhost:3000',
    'starsender': 'https://api.starsender.online/api/sendText',
    'custom': ''
  };

  $('.provider-card').on('click', function() {
    $('.provider-card').removeClass('active');
    $(this).addClass('active');
    var prov = $(this).data('provider');
    $('#config-provider').val(prov);

    if (presetUrls[prov]) {
      $('#config-api-url').val(presetUrls[prov]);
      $('#url-help-text').text('URL endpoint preset ' + prov.toUpperCase() + ': ' + presetUrls[prov]);
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
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    $.ajax({
      url: BASE_URL + 'administrator/crm/save_wa_gateway_config_ajax',
      type: 'POST',
      data: $('#form-wa-config').serialize(),
      dataType: 'json',
      success: function(res) {
        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Konfigurasi WA Gateway');
        if (res.success) {
          if (typeof toastr !== 'undefined') toastr.success(res.message);
          else alert(res.message);
        } else {
          if (typeof toastr !== 'undefined') toastr.error(res.message || 'Gagal menyimpan');
          else alert(res.message || 'Gagal menyimpan');
        }
      },
      error: function() {
        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Konfigurasi WA Gateway');
        alert('Gagal menghubungi server');
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

    $.ajax({
      url: BASE_URL + 'administrator/crm/test_wa_gateway_ajax',
      type: 'POST',
      data: { phone: phone, message: message },
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
      error: function() {
        $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Kirim Pesan Uji Coba Sekarang');
        alert('Gagal menghubungi server API');
      }
    });
  });
});
</script>
