<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
.crm-banner {
  background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #312e81 100%);
  color: #ffffff;
  padding: 24px 28px;
  border-radius: 14px;
  margin-bottom: 20px;
  box-shadow: 0 10px 25px rgba(15, 23, 42, 0.2);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}
.crm-banner .title-area h2 { margin: 0 0 4px 0; font-weight: 800; font-size: 22px; letter-spacing: -0.5px; color: #ffffff; }
.crm-banner .title-area p { margin: 0; opacity: 0.85; font-size: 13px; color: #cbd5e1; }

.box-clean {
  background: #ffffff;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 4px 16px rgba(0,0,0,0.03);
  margin-bottom: 20px;
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

@media (max-width: 991px) {
  .crm-banner { flex-direction: column; text-align: center; }
  .crm-banner .btn-area { margin-top: 10px; justify-content: center; }
}

@media (max-width: 767px) {
  .content { padding: 10px 8px !important; }
  .crm-banner { padding: 16px 14px; text-align: center; justify-content: center; border-radius: 10px; margin-bottom: 14px; }
  .crm-banner .title-area h2 { font-size: 17px; }
  .crm-banner .title-area p { font-size: 11px; }
  .crm-banner .btn-area { margin-top: 10px; flex-wrap: wrap; justify-content: center; }
  .crm-banner .btn-area .btn { font-size: 10.5px; padding: 5px 10px; }

  .box-clean { border-radius: 10px; margin-bottom: 14px; }
  .box-clean .box-header { padding: 12px 14px; }
  .box-clean .box-title { font-size: 13px; }
  .box-clean .box-body { padding: 14px !important; }

  .box-body .row { margin-left: -4px; margin-right: -4px; }
  .box-body .row > [class*="col-"] { padding-left: 4px; padding-right: 4px; margin-bottom: 8px; }
  .box-body .form-control { font-size: 12px; height: 36px; }
  .box-body label { font-size: 11px !important; }

  #recipients-list { max-height: 200px; padding: 10px; font-size: 11.5px; }
  #btn-execute-broadcast { font-size: 13px !important; padding: 10px !important; border-radius: 8px !important; }

  .table-log th { font-size: 9.5px; padding: 6px 4px !important; }
  .table-log td { font-size: 10.5px; padding: 6px 4px !important; }
  .badge-source { font-size: 9px; padding: 2px 6px; }
}

@media (max-width: 480px) {
  .crm-banner .title-area h2 { font-size: 15px; }
  .crm-banner .btn-area { flex-direction: column; width: 100%; }
  .crm-banner .btn-area .btn { width: 100%; }
  .table-log th, .table-log td { font-size: 9.5px; padding: 5px 3px !important; }
}
</style>

<section class="content" style="padding-top: 15px;">
  <!-- Integrated Header Banner -->
  <div class="crm-banner">
    <div class="title-area">
      <h2><i class="fa fa-bullhorn" style="color:#818cf8;"></i> Broadcast WhatsApp</h2>
      <p>Kirim pesan massal ke kelompok customer berdasarkan label H+ & Cegah duplikasi pengiriman otomatis</p>
    </div>
    <div class="btn-area" style="display:flex; gap:8px;">
      <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="btn btn-sm" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3); font-weight:600; border-radius:8px;"><i class="fa fa-tasks"></i> Journal Follow-Up</a>
      <a href="<?= site_url('administrator/crm/automations'); ?>" class="btn btn-sm" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3); font-weight:600; border-radius:8px;"><i class="fa fa-cogs"></i> Otomasi Cron</a>
    </div>
  </div>
  <!-- BAGIAN ATAS: Panel Form Kirim Broadcast Baru -->
  <div class="row">
    <div class="col-md-12">
      <div class="box-clean">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-paper-plane text-indigo"></i> Kirim Broadcast Baru</h3>
        </div>
        <div class="box-body" style="padding:22px;">
          <div class="row" style="align-items: flex-end;">
            <div class="col-md-5">
              <div class="form-group" style="margin-bottom:0;">
                <label style="font-size:12px; font-weight:700; color:#334155;">Pilih Kategori Label H+ <span class="text-danger">*</span></label>
                <select class="form-control" id="bc-category" style="border-radius:8px; height:40px; font-size:13px;">
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
            <div class="col-md-5">
              <div class="form-group" style="margin-bottom:0;">
                <label style="font-size:12px; font-weight:700; color:#334155;">Filter Sumber Penjualan</label>
                <select class="form-control" id="bc-source" style="border-radius:8px; height:40px; font-size:13px;">
                  <option value="">Semua Sumber (Toko & Online)</option>
                  <option value="Toko">Toko / Offline SO</option>
                  <option value="Shopee">Shopee</option>
                  <option value="Tokopedia">Tokopedia</option>
                  <option value="TikTok Shop">TikTok Shop</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <button class="btn btn-indigo btn-block" id="btn-load-recipients" style="height:40px; font-size:13px;"><i class="fa fa-users"></i> Muat Penerima</button>
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

    if (!cat_id) {
      notify('warning', 'Pilih kategori label H+ terlebih dahulu.');
      return;
    }

    $.get(_BASE + 'administrator/crm/get_broadcast_recipients_ajax', {
      category_id: cat_id, order_source: source
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
          notify('success', 'Berhasil mengirim ' + r.count + ' pesan WA otomatis via Fonnte Gateway API!');
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
