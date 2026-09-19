<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
@keyframes crmFadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}

.crm-header {
  background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
  color: #fff;
  padding: 25px 30px;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: 0 10px 25px rgba(49, 46, 129, 0.2);
  animation: crmFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.crm-header h2 { margin: 0 0 5px 0; font-weight: 800; font-size: 22px; }
.crm-header p { margin: 0; opacity: 0.85; font-size: 13px; }

.proc-card {
  background: #fff;
  border-radius: 10px;
  padding: 18px 20px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.06);
  border-left: 4px solid #4f46e5;
  margin-bottom: 15px;
  height: 100%;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  animation: crmFadeInUp 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}
.proc-card:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,0,0,0.1); }
.proc-card .proc-num { font-size: 11px; font-weight: 700; color: #6366f1; text-transform: uppercase; letter-spacing: 0.5px; }
.proc-card .proc-title { font-size: 15px; font-weight: 700; color: #1e293b; margin: 4px 0 6px 0; }
.proc-card .proc-desc { font-size: 12px; color: #64748b; line-height: 1.4; }

.box {
  animation: crmFadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.table-responsive {
  -webkit-overflow-scrolling: touch;
}

.badge-mode { padding: 3px 10px; border-radius: 12px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
.bm-web { background: #e0e7ff; color: #4338ca; }
.bm-cli { background: #dcfce7; color: #15803d; }

.table-log th { background: #f8fafc; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; }
.table-log td { font-size: 13px; vertical-align: middle !important; }

@media (max-width: 767px) {
  .content { padding: 10px 8px !important; }
  .crm-header { padding: 16px 14px; text-align: center; border-radius: 10px; margin-bottom: 14px; }
  .crm-header h2 { font-size: 17px; }
  .crm-header p { font-size: 11px; }
  .crm-header .text-right { text-align: center !important; margin-top: 10px; }
  .crm-header .text-right .btn { font-size: 12px; padding: 8px 16px; width: 100%; }

  .proc-card { padding: 14px 12px; margin-bottom: 10px; border-radius: 8px; }
  .proc-card .proc-title { font-size: 13px; }
  .proc-card .proc-desc { font-size: 11px; }

  .box-header .box-title { font-size: 12px; }
  .box-tools .btn { font-size: 10px; }

  .table-log th { font-size: 10px; padding: 6px 4px !important; white-space: nowrap; }
  .table-log td { font-size: 11px; padding: 6px 4px !important; }
  .badge-mode { font-size: 9px; padding: 2px 7px; }
}

@media (max-width: 480px) {
  .crm-header h2 { font-size: 15px; }
  .proc-card .proc-title { font-size: 12px; }
  .table-log th, .table-log td { font-size: 9.5px; padding: 5px 3px !important; }
}
</style>

<section class="content" style="padding-top:15px;">
  <!-- Header Banner -->
  <div class="crm-header">
    <div class="row" style="align-items:center;">
      <div class="col-md-8">
        <h2><i class="fa fa-cogs"></i> Otomasi CRM Sisi Backend (CLI & Web)</h2>
        <p>Eksekusi 4 proses otomatisasi: Pembaruan Overdue, Pembatalan Retur, Penggabungan Repeat Order Multi-Produk, & Pelacakan Konversi 14 Hari.</p>
      </div>
      <div class="col-md-4 text-right" style="padding-top: 10px;">
        <button class="btn btn-lg btn-warning" id="btn-run-automations-swal" style="font-weight:700; border-radius:8px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);">
          <i class="fa fa-bolt"></i> Jalankan Otomasi Sekarang
        </button>
      </div>
    </div>
  </div>

  <!-- 4 Process Cards Row -->
  <div class="row">
    <div class="col-md-3 col-sm-6">
      <div class="proc-card" style="border-left-color: #f59e0b;">
        <div class="proc-num">Proses #1</div>
        <div class="proc-title"><i class="fa fa-clock-o text-warning"></i> Follow-Up Overdue</div>
        <div class="proc-desc">Memindai & memperbarui label follow-up pending yang telah melewati tanggal target jadwal.</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="proc-card" style="border-left-color: #ef4444;">
        <div class="proc-num">Proses #2</div>
        <div class="proc-title"><i class="fa fa-times-circle text-danger"></i> Pembatalan Retur</div>
        <div class="proc-desc">Otomatis membatalkan jadwal follow-up untuk pesanan yang diretur atau dibatalkan.</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="proc-card" style="border-left-color: #3b82f6;">
        <div class="proc-num">Proses #3</div>
        <div class="proc-title"><i class="fa fa-cubes text-info"></i> Konsolidasi Repeat</div>
        <div class="proc-desc">Menggabungkan penawaran repeat order multi-produk untuk customer yang beli >1 barang.</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="proc-card" style="border-left-color: #10b981;">
        <div class="proc-num">Proses #4</div>
        <div class="proc-title"><i class="fa fa-line-chart text-success"></i> Konversi 14 Hari</div>
        <div class="proc-desc">Pelacakan transaksi baru dalam 14 hari pasca follow-up & pencatatan omset konversi.</div>
      </div>
    </div>
  </div>

  <br>

  <!-- Execution Logs Table -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-history"></i> Log Pemantauan Eksekusi Otomasi</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-sm btn-default" onclick="location.reload();"><i class="fa fa-refresh"></i> Refresh Log</button>
      </div>
    </div>
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover table-striped table-log">
        <thead>
          <tr>
            <th style="width:40px;">#</th>
            <th>Waktu Eksekusi</th>
            <th>Proses Otomasi</th>
            <th class="text-center">Mode</th>
            <th class="text-center">Record Terpengaruh</th>
            <th>Rincian Eksekusi</th>
            <th>Operator</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($logs)): ?>
          <tr><td colspan="7" class="text-center" style="padding:40px; color:#94a3b8;"><i class="fa fa-inbox fa-2x"></i><br>Belum ada log eksekusi otomasi. Klik tombol "Jalankan Otomasi Sekarang" untuk memulai.</td></tr>
          <?php else: $no = 1; foreach ($logs as $log): ?>
          <tr>
            <td><?= $no++; ?></td>
            <td style="white-space:nowrap; font-size:12px;"><strong><?= date('d/m/Y H:i:s', strtotime($log->executed_at)); ?></strong></td>
            <td><strong><?= htmlspecialchars($log->process_name); ?></strong></td>
            <td class="text-center">
              <span class="badge-mode <?= $log->mode === 'cli_cron' ? 'bm-cli' : 'bm-web'; ?>">
                <?= $log->mode === 'cli_cron' ? '<i class="fa fa-terminal"></i> CLI CRON' : '<i class="fa fa-globe"></i> WEB MANUAL'; ?>
              </span>
            </td>
            <td class="text-center">
              <span class="badge" style="background: <?= $log->affected_count > 0 ? '#6366f1' : '#94a3b8'; ?>; font-size:12px; font-weight:700;">
                <?= $log->affected_count; ?> item
              </span>
            </td>
            <td style="font-size:12px; max-width: 350px;"><?= htmlspecialchars($log->details); ?></td>
            <td><small><i class="fa fa-user"></i> <?= htmlspecialchars($log->executed_by); ?></small></td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- SweetAlert Execution Script -->
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

  $('#btn-run-automations-swal').on('click', function() {
    if (typeof swal === 'function') {
      swal({
        title: 'Jalankan Otomasi CRM?',
        text: 'Sistem akan mengeksekusi 4 proses otomasi backend: Pembaruan Overdue, Pembatalan Retur, Konsolidasi Repeat, & Pelacakan Konversi 14 Hari.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        confirmButtonText: 'Ya, Jalankan!',
        cancelButtonText: 'Batal',
        closeOnConfirm: false,
        showLoaderOnConfirm: true
      }, function(confirmed) {
        if (confirmed) doRunAutomations();
      });
    } else {
      if (confirm('Jalankan 4 proses otomasi CRM sekarang?')) {
        doRunAutomations();
      }
    }
  });

  function doRunAutomations() {
    $.ajax({
      url: _BASE + 'administrator/crm/run_automations_ajax',
      type: 'POST',
      data: buildPayload({}),
      dataType: 'json',
      success: function(res) {
        if (res.success) {
          var htmlMsg = 'Otomasi selesai dieksekusi!\n\n';
          htmlMsg += '1. Overdue Updated: ' + (res.overdue ? res.overdue.count : 0) + ' item\n';
          htmlMsg += '2. Retur/Cancelled: ' + (res.cancellations ? res.cancellations.count : 0) + ' item\n';
          htmlMsg += '3. Multi-Product Bundles: ' + (res.bundles ? res.bundles.count : 0) + ' customer\n';
          htmlMsg += '4. Konversi 14 Hari: ' + (res.conversions ? res.conversions.count : 0) + ' item (Rp ' + parseInt(res.conversions ? res.conversions.amount : 0).toLocaleString('id-ID') + ')\n';
          htmlMsg += '\nTotal Affected Records: ' + (res.total_affected || 0);

          if (typeof swal === 'function') {
            swal({
              title: 'Eksekusi Sukses! ⚡',
              text: htmlMsg,
              type: 'success',
              confirmButtonText: 'OK'
            }, function() {
              location.reload();
            });
          } else {
            alert(htmlMsg);
            location.reload();
          }
        } else {
          if (typeof swal === 'function') swal('Gagal!', res.message || 'Terjadi kesalahan saat memproses otomasi.', 'error');
          else alert(res.message || 'Terjadi kesalahan');
        }
      },
      error: function() {
        if (typeof swal === 'function') swal('Error!', 'Gagal menghubungi server.', 'error');
        else alert('Gagal menghubungi server');
      }
    });
  }
});
</script>
