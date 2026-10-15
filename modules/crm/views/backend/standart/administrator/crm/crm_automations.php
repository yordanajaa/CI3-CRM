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

/* Navigation Tab Bar */
.crm-header-nav .nav-tabs-bar {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
  padding-top: 14px;
  border-top: 1px solid rgba(255,255,255,0.18);
  position: relative;
  z-index: 2;
}
.crm-header-nav .nav-tab-btn {
  padding: 8px 18px;
  border-radius: 25px;
  font-size: 12px;
  font-weight: 700;
  color: #e0e7ff;
  background: rgba(255, 255, 255, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.2);
  text-decoration: none !important;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}
.crm-header-nav .nav-tab-btn:hover {
  background: rgba(255, 255, 255, 0.22);
  color: #ffffff;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.crm-header-nav .nav-tab-btn.active {
  background: #ffffff !important;
  color: #312e81 !important;
  border-color: #ffffff !important;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
}
.crm-header-nav .nav-tab-btn.active .active-dot {
  width: 7px;
  height: 7px;
  background: #6366f1;
  border-radius: 50%;
  display: inline-block;
}

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

@media (max-width: 991px) {
  .crm-header-nav { padding: 16px 16px 12px 16px; margin-bottom: 12px; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 12px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn { font-size: 11px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
}

@media (max-width: 767px) {
  .content { padding: 8px 6px !important; }
  .crm-header-nav { padding: 14px 12px 10px 12px; border-radius: 12px; margin-bottom: 12px; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 10px; }
  .crm-header-nav .header-title h2 { font-size: 18px; }
  .crm-header-nav .header-title p { font-size: 11px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn { font-size: 10.5px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
  .crm-header-nav .nav-tabs-bar { gap: 6px; padding-top: 10px; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
  .crm-header-nav .nav-tab-btn { font-size: 11.5px; padding: 6px 12px; }

  .proc-card { padding: 12px 10px; margin-bottom: 8px; border-radius: 8px; }
  .proc-card .proc-title { font-size: 12px; }
  .proc-card .proc-desc { font-size: 10.5px; }

  .box-header .box-title { font-size: 12px; }
  .box-tools .btn { font-size: 10px; }

  .table-responsive { border: none !important; margin-bottom: 0; -webkit-overflow-scrolling: touch; }
  .table-log { min-width: 680px; }
  .table-log th { font-size: 9.5px; padding: 6px 4px !important; white-space: nowrap; }
  .table-log td { font-size: 10.5px; padding: 6px 4px !important; }
  .badge-mode { font-size: 9px; padding: 2px 7px; }
}

@media (max-width: 480px) {
  .crm-header-nav .header-title h2 { font-size: 15px; }
  .crm-header-nav .action-tools { flex-direction: column; width: 100%; }
  .crm-header-nav .action-tools .btn { width: 100%; }
  .proc-card .proc-title { font-size: 11.5px; }
  .table-log th, .table-log td { font-size: 9px; padding: 5px 3px !important; }
}
</style>

<section class="content" style="padding-top:15px;">
  <!-- Integrated Header Banner & Navigation -->
  <div class="crm-header-nav">
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> CRM & After Sales <i class="fa fa-angle-right"></i> <span>Otomasi Cron</span>
        </div>
        <h2><i class="fa fa-cogs" style="color:#818cf8;"></i> Otomasi CRM Backend (CLI & Web)</h2>
        <p>Eksekusi 4 proses otomatisasi: Pembaruan Overdue, Pembatalan Retur, Konsolidasi Repeat Order, & Pelacakan Konversi 14 Hari</p>
      </div>

      <div class="action-tools">
        <button type="button" class="btn btn-warning" id="btn-run-automations-swal" style="background:#f59e0b; color:#fff; font-weight:700;"><i class="fa fa-bolt"></i> Jalankan Otomasi Sekarang</button>
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
        <i class="fa fa-bullhorn"></i> 3. Broadcast WA
      </a>
      <a href="<?= site_url('administrator/crm'); ?>" class="nav-tab-btn">
        <i class="fa fa-users"></i> 4. Daftar Customer CRM
      </a>
    </div>
  </div>

  <!-- 4 Process Cards Row -->
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="proc-card" style="border-left-color: #f59e0b;">
        <div class="proc-num">Proses #1</div>
        <div class="proc-title"><i class="fa fa-clock-o text-warning"></i> Follow-Up Overdue</div>
        <div class="proc-desc">Memindai & memperbarui label follow-up pending yang telah melewati tanggal target jadwal.</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="proc-card" style="border-left-color: #ef4444;">
        <div class="proc-num">Proses #2</div>
        <div class="proc-title"><i class="fa fa-times-circle text-danger"></i> Pembatalan Retur</div>
        <div class="proc-desc">Otomatis membatalkan jadwal follow-up untuk pesanan yang diretur atau dibatalkan.</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6">
      <div class="proc-card" style="border-left-color: #3b82f6;">
        <div class="proc-num">Proses #3</div>
        <div class="proc-title"><i class="fa fa-cubes text-info"></i> Konsolidasi Repeat</div>
        <div class="proc-desc">Menggabungkan penawaran repeat order multi-produk untuk customer yang beli >1 barang.</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-6">
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
