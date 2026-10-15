<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
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

.stat-box {
  background: #ffffff;
  border-radius: 14px;
  padding: 18px 20px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.04);
  border: 1px solid #f1f5f9;
  text-align: center;
  margin-bottom: 16px;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.stat-box:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}
.stat-box .num { font-size: 28px; font-weight: 800; letter-spacing: -0.5px; }
.stat-box .lbl { font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; margin-top: 4px; }
.stat-box.sb-red { border-left: 4px solid #ef4444; }
.stat-box.sb-red .num { color: #ef4444; }
.stat-box.sb-orange { border-left: 4px solid #f59e0b; }
.stat-box.sb-orange .num { color: #f59e0b; }
.stat-box.sb-blue { border-left: 4px solid #3b82f6; }
.stat-box.sb-blue .num { color: #3b82f6; }

.badge-source {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  color: #fff;
  display: inline-block;
  margin: 2px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.badge-toko { background: linear-gradient(135deg, #1e293b, #334155); }
.badge-shopee { background: linear-gradient(135deg, #ee4d2d, #ff6b4a); }
.badge-tokopedia { background: linear-gradient(135deg, #059669, #10b981); }
.badge-tiktok { background: linear-gradient(135deg, #09090b, #18181b); }
.badge-whatsapp { background: linear-gradient(135deg, #16a34a, #22c55e); }
.badge-wa-group { background: linear-gradient(135deg, #0284c7, #38bdf8); }

.status-select { padding: 5px 10px; font-size: 12px; font-weight: 600; border-radius: 8px; border: 1px solid #cbd5e1; background: #f8fafc; color: #1e293b; transition: all 0.2s ease; cursor: pointer; }
.status-select:hover, .status-select:focus { border-color: #6366f1; background: #ffffff; outline: none; }
.btn-wa-sm { background: #25D366; color: #fff; border: none; padding: 5px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; box-shadow: 0 2px 6px rgba(37, 211, 102, 0.2); transition: all 0.2s ease; }
.btn-wa-sm:hover { background: #128C7E; color: #fff; transform: translateY(-1px); }
.btn-wa-sm.disabled { background: #cbd5e1; color: #94a3b8; cursor: not-allowed; box-shadow: none; }

.filter-section { border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; box-shadow: 0 4px 16px rgba(0,0,0,0.03); margin-bottom: 18px; }
.filter-section .form-control { font-size: 12px; height: 38px; border-radius: 8px; border: 1px solid #cbd5e1; box-shadow: none; transition: all 0.2s ease; }
.filter-section .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12); }

.cat-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 11px;
  font-weight: 700;
  background: #e0f2fe;
  color: #0284c7;
  border: 1px solid #bae6fd;
  box-shadow: 0 2px 4px rgba(0,0,0,0.02);
  white-space: nowrap;
}

.label-selisih {
  display: inline-block;
  font-size: 11px;
  font-weight: 700;
  color: #2563eb;
  background: #eff6ff;
  border: 1px solid #bfdbfe;
  border-radius: 8px;
  padding: 1px 6px;
}

.badge-h-followup {
  display: inline-block;
  padding: 3px 9px;
  border-radius: 10px;
  font-size: 10.5px;
  font-weight: 700;
  box-shadow: 0 2px 5px rgba(0,0,0,0.08);
  white-space: nowrap;
  letter-spacing: 0.2px;
  transition: all 0.3s ease;
}
.bh-today { background: linear-gradient(135deg, #2563eb, #3b82f6); color: #fff; }
.bh-overdue { background: linear-gradient(135deg, #dc2626, #ef4444); color: #fff; }
.bh-future { background: linear-gradient(135deg, #475569, #64748b); color: #fff; }
.bh-sent { background: linear-gradient(135deg, #4f46e5, #6366f1); color: #fff; }
.bh-responded { background: linear-gradient(135deg, #7c3aed, #8b5cf6); color: #fff; }
.bh-confirmed { background: linear-gradient(135deg, #059669, #10b981); color: #fff; }
.bh-no-response { background: linear-gradient(135deg, #d97706, #f59e0b); color: #fff; }
.bh-complaint { background: linear-gradient(135deg, #e11d48, #f43f5e); color: #fff; }
.bh-repeat { background: linear-gradient(135deg, #0284c7, #06b6d4); color: #fff; }
.bh-done { background: linear-gradient(135deg, #166534, #15803d); color: #fff; }

.table-journal th { background: #f8fafc; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; font-weight: 700; padding: 12px 10px !important; border-bottom: 2px solid #e2e8f0 !important; }
.table-journal td { font-size: 12.5px; padding: 12px 10px !important; vertical-align: middle !important; color: #1e293b; }
.table-journal tbody tr { transition: all 0.2s ease; }
.table-journal tbody tr:hover { background: #f8fafc !important; }

.cat-pill { display: inline-flex; align-items: center; gap: 4px; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; margin: 3px; cursor: pointer; border: 1px solid #e2e8f0; background: #fff; color: #475569; transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 2px 6px rgba(0,0,0,0.02); }
.cat-pill:hover { border-color: #6366f1; color: #6366f1; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15); }
.cat-pill.active { background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: #fff; border-color: #4f46e5; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3); }

.modal-backdrop { z-index: 1040 !important; }
.modal { z-index: 1050 !important; }
.modal-dialog { z-index: 1060 !important; }

/* ===== Animations & Micro-Interactions ===== */
@keyframes crmFadeInUp {
  from {
    opacity: 0;
    transform: translateY(14px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.crm-header, .stat-box, .filter-section, .box {
  animation: crmFadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease, border-color 0.25s ease;
}

.btn:active, .btn-wa-sm:active {
  transform: scale(0.97) !important;
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

@media (max-width: 991px) {
  .crm-header-nav { padding: 16px 16px 12px 16px; margin-bottom: 12px; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 12px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn, .crm-header-nav .action-tools > a { font-size: 11px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
  .filter-section .col-md-2 { margin-bottom: 8px; }
}

@media (max-width: 767px) {
  .content { padding: 8px 6px !important; }
  .crm-header-nav { padding: 14px 12px 10px 12px; border-radius: 12px; margin-bottom: 12px; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 10px; }
  .crm-header-nav .header-title h2 { font-size: 18px; }
  .crm-header-nav .header-title p { font-size: 11px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn, .crm-header-nav .action-tools > a { font-size: 10.5px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
  .crm-header-nav .nav-tabs-bar { gap: 6px; padding-top: 10px; }
  .crm-header-nav .nav-tab-btn { font-size: 11.5px; padding: 6px 12px; }

  .stat-box { padding: 12px 10px; margin-bottom: 8px; border-radius: 10px; }
  .stat-box .num { font-size: 20px; }
  .stat-box .lbl { font-size: 9px; }
  .row > .col-md-4 { width: 33.333%; float: left; padding-left: 4px; padding-right: 4px; }

  .cat-pill { padding: 5px 10px; font-size: 10.5px; margin: 2px; }

  .filter-section { margin-bottom: 12px; }
  .filter-section .box-body { padding: 10px; }
  .filter-section .col-md-2 { margin-bottom: 6px; }
  .filter-section .form-control { font-size: 11px; height: 34px; }

  .box-header { padding: 10px 12px !important; }
  .box-header .box-title { font-size: 13px; }
  .box-header .box-tools .btn { font-size: 10px; padding: 4px 8px; }

  .table-responsive { border: none !important; margin-bottom: 0; }
  .table-journal { min-width: 840px; }
  .table-journal th { font-size: 10px; padding: 8px 4px !important; white-space: nowrap; }
  .table-journal td { font-size: 11px; padding: 8px 4px !important; }
  .status-select { font-size: 10.5px; padding: 3px 6px; }
  .badge-source { font-size: 9.5px; padding: 2px 8px; }
  .cat-badge { font-size: 10px; padding: 2px 7px; }
  .badge-h-followup { font-size: 9.5px; padding: 2px 7px; }
  .label-selisih { font-size: 9.5px; padding: 1px 5px; }
  .btn-wa-sm { font-size: 10px; padding: 4px 8px; }
  .time-log-wa { font-size: 10px !important; }
  .badge-wa-count { font-size: 9px !important; padding: 2px 6px !important; }

  /* Chat Modal mobile full-screen */
  .chat-modal .modal-dialog { max-width: 100%; margin: 6px; width: auto; }
  .chat-modal .modal-content { border-radius: 10px; }
  .chat-header { padding: 10px 12px; gap: 8px; }
  .chat-header .avatar { width: 36px; height: 36px; font-size: 15px; }
  .chat-header .info .name { font-size: 13.5px; }
  .chat-header .info .meta { font-size: 10px; }
  .chat-canvas { min-height: 260px; max-height: 55vh; padding: 10px 8px; }
  .chat-bubble { max-width: 88%; font-size: 12.5px; padding: 7px 10px; }
  .chat-bubble .bubble-time { font-size: 9px; }
  .chat-status-bar { padding: 6px 10px; font-size: 11px; }
  .chat-status-bar select { font-size: 11px; padding: 4px 6px; }

  .wa-chat-footer { padding: 8px 10px; }
  .sender-toggle { gap: 4px !important; margin-bottom: 6px !important; }
  .sender-toggle .btn-toggle-sender { font-size: 10.5px !important; padding: 5px 8px !important; }

  .wa-emoji-popover { width: 290px; left: 6px; bottom: 58px; padding: 8px; }
  .wa-emoji-container { max-height: 180px; }
  .wa-emoji-grid { grid-template-columns: repeat(7, 1fr); gap: 2px; font-size: 19px; }
  .wa-emoji-item { padding: 4px 1px; }
  .wa-emoji-category-title { font-size: 9.5px; margin: 6px 0 3px 2px; }

  .wa-attach-popover { width: 220px; left: 6px; bottom: 58px; }

  .wa-input-pill-container { gap: 5px !important; }
  .wa-input-pill { padding: 3px 6px 3px 8px; min-height: 38px; gap: 5px; }
  .wa-textarea { font-size: 13px; }
  .wa-icon-btn { font-size: 17px; padding: 2px 4px; }
  .wa-send-btn { width: 38px; height: 38px; font-size: 16px; }
  .wa-mic-btn { width: 38px; height: 38px; font-size: 16px; }

  #wa-mic-recording-bar { padding: 6px 10px !important; border-radius: 20px !important; margin-bottom: 6px !important; flex-wrap: wrap; gap: 6px; }
  #wa-mic-recording-bar > div { gap: 6px !important; }
  #wa-mic-recording-bar span { font-size: 11px !important; }
  #wa-mic-recording-bar .btn { font-size: 10.5px !important; padding: 3px 10px !important; }

  .wa-attachment-chip { padding: 6px 8px; font-size: 11px; border-radius: 8px; }

  /* WA Preview Modal */
  #modal-wa-preview .modal-dialog { margin: 6px; }
  #modal-wa-preview .modal-body { padding: 12px; }
  #modal-wa-preview .modal-body textarea { font-size: 12px; }
  #modal-wa-preview .modal-footer .btn { font-size: 12px; padding: 6px 14px; }
}

@media (max-width: 480px) {
  .crm-header h2 { font-size: 15px; }
  .crm-header > div > div:last-child { flex-direction: column; width: 100%; }
  .crm-header > div > div:last-child .btn { width: 100%; }
  .stat-box .num { font-size: 18px; }
  .cat-pill { font-size: 10px; padding: 4px 8px; }
  .table-journal th, .table-journal td { font-size: 10px; padding: 6px 3px !important; }
  .wa-emoji-popover { width: calc(100vw - 40px); left: 6px; }
  .wa-emoji-grid { grid-template-columns: repeat(6, 1fr); font-size: 18px; }
}
</style>

<section class="content" style="padding-top:15px;">
  <!-- Header Banner & Navigation -->
  <div class="crm-header-nav">
    <!-- Top Row: Title, Subtitle & Action Tools -->
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> CRM & After Sales <i class="fa fa-angle-right"></i> <span>Journal Follow-Up</span>
        </div>
        <h2><i class="fa fa-tasks" style="color:#818cf8;"></i> Journal Follow-Up After Sales</h2>
        <p>Pantau tahapan after sales — Konfirmasi Pengiriman, H+3 Cek Sampai, H+7 Experience, Custom H+n</p>
      </div>

      <div class="action-tools">
        <button type="button" class="btn" style="background:#0284c7; color:#fff;" id="btn-open-manual-add" title="Tambah Data Follow-Up Manual Baru"><i class="fa fa-plus-circle"></i> Tambah Manual</button>
        <button type="button" class="btn" style="background:#8e44ad; color:#fff;" id="btn-sync-cron" title="Pindai transaksi baru & buat label H+"><i class="fa fa-refresh"></i> Sync Label H+</button>
        
        <div class="btn-group">
          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background:#10b981; color:#fff; border:none;">
            <i class="fa fa-download"></i> Export <span class="caret"></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-right" style="border-radius:10px; box-shadow:0 10px 25px rgba(0,0,0,0.15); padding:6px 0;">
            <li><a href="<?= site_url('administrator/crm/export_journal_excel?' . http_build_query($_GET)); ?>"><i class="fa fa-file-excel-o text-success" style="width:20px;"></i> Export Excel (.xls)</a></li>
            <li><a href="<?= site_url('administrator/crm/export_journal?' . http_build_query($_GET)); ?>"><i class="fa fa-file-text-o text-info" style="width:20px;"></i> Export CSV (.csv)</a></li>
            <li role="separator" class="divider" style="margin:4px 0;"></li>
            <li><a href="<?= site_url('administrator/crm/export_journal_pdf?' . http_build_query($_GET)); ?>" target="_blank"><i class="fa fa-file-pdf-o text-danger" style="width:20px;"></i> Export PDF (.pdf)</a></li>
          </ul>
        </div>

        <a href="<?= site_url('administrator/crm/followup_setting'); ?>" class="btn" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-cogs"></i> Settings</a>
      </div>
    </div>

    <!-- Bottom Row: Navigation Tabs Bar -->
    <div class="nav-tabs-bar">
      <a href="<?= site_url('administrator/crm/dashboard'); ?>" class="nav-tab-btn">
        <i class="fa fa-tachometer"></i> 1. Dashboard CRM
      </a>
      <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-tasks"></i> 2. Journal Follow-Up
      </a>
      <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="nav-tab-btn">
        <i class="fa fa-bullhorn"></i> 3. Broadcast WA
      </a>
      <a href="<?= site_url('administrator/crm'); ?>" class="nav-tab-btn">
        <i class="fa fa-users"></i> 4. Daftar Customer CRM
      </a>
    </div>
  </div>

  <!-- Stats -->
  <div class="row">
    <div class="col-md-4">
      <div class="stat-box sb-red">
        <div class="num"><?= $stats['total_pending']; ?></div>
        <div class="lbl">Total Pending</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stat-box sb-orange">
        <div class="num"><?= $stats['overdue']; ?></div>
        <div class="lbl">Overdue (Lewat Jadwal)</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stat-box sb-blue">
        <div class="num"><?= $stats['today']; ?></div>
        <div class="lbl">Follow-Up Hari Ini</div>
      </div>
    </div>
  </div>

  <!-- Category Tabs -->
  <div style="margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">

    <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="cat-pill <?= (empty($filters['category_id']) && empty($filters['status_label'])) ? 'active' : ''; ?>">
      <i class="fa fa-list"></i> Semua Data
    </a>
    
    <a href="<?= site_url('administrator/crm/journal_followup?status_label=belum_direspon'); ?>" class="cat-pill <?= (($filters['status_label'] ?? '') === 'belum_direspon') ? 'active' : ''; ?>" style="background: linear-gradient(135deg, #d97706, #f59e0b); color:#fff; border:none;">
      <i class="fa fa-clock-o"></i> Belum Direspon (Pending)
    </a>

    <a href="<?= site_url('administrator/crm/journal_followup?status_label=Direspon'); ?>" class="cat-pill <?= (($filters['status_label'] ?? '') === 'Direspon') ? 'active' : ''; ?>" style="background: linear-gradient(135deg, #7c3aed, #8b5cf6); color:#fff; border:none;">
      <i class="fa fa-comments"></i> Customer Direspon
    </a>

    <div style="width: 1px; height: 22px; background: #cbd5e1; margin: 0 4px;"></div>

    <?php foreach ($categories as $cat): ?>
    <?php
    $raw_name = htmlspecialchars($cat->nama_kategori);
    // Standardize category tab names cleanly: strip redundant H+ prefix if present and append (H+n) uniformly
    $clean_name = preg_replace('/^H\+\d+\s*[\—\-]?\s*/i', '', $raw_name);
    $cat_label = $clean_name . ' (H+' . $cat->jumlah_hari . ')';
    ?>
    <a href="<?= site_url('administrator/crm/journal_followup?category_id=' . $cat->id . (!empty($filters['status_label']) ? '&status_label=' . $filters['status_label'] : '')); ?>" class="cat-pill <?= (($filters['category_id'] ?? '') == $cat->id) ? 'active' : ''; ?>">
      <?= $cat_label; ?>
    </a>
    <?php endforeach; ?>
  </div>

  <!-- Filters -->
  <div class="box box-default filter-section">
    <div class="box-body">
      <form method="get" action="<?= site_url('administrator/crm/journal_followup'); ?>">
        <?php if (!empty($filters['category_id'])): ?>
        <input type="hidden" name="category_id" value="<?= $filters['category_id']; ?>">
        <?php endif; ?>
        <div class="row">
          <div class="col-md-2">
            <select name="order_source" class="form-control">
              <option value="">Semua Sumber</option>
              <option value="Toko" <?= ($filters['order_source'] ?? '') == 'Toko' ? 'selected' : ''; ?>>Toko</option>
              <option value="Shopee" <?= ($filters['order_source'] ?? '') == 'Shopee' ? 'selected' : ''; ?>>Shopee</option>
              <option value="Tokopedia" <?= ($filters['order_source'] ?? '') == 'Tokopedia' ? 'selected' : ''; ?>>Tokopedia</option>
              <option value="TikTok Shop" <?= ($filters['order_source'] ?? '') == 'TikTok Shop' ? 'selected' : ''; ?>>TikTok Shop</option>
              <option value="WhatsApp Live" <?= ($filters['order_source'] ?? '') == 'WhatsApp Live' ? 'selected' : ''; ?>>WhatsApp Live</option>
              <option value="WhatsApp Group" <?= ($filters['order_source'] ?? '') == 'WhatsApp Group' ? 'selected' : ''; ?>>WhatsApp Group</option>
            </select>
          </div>
          <div class="col-md-2">
            <select name="status_label" class="form-control">
              <option value="">Semua Status</option>
              <option value="belum_direspon" <?= ($filters['status_label'] ?? '') == 'belum_direspon' ? 'selected' : ''; ?>>Belum Direspon (Pending/Dikirim)</option>
              <option value="Pending" <?= ($filters['status_label'] ?? '') == 'Pending' ? 'selected' : ''; ?>>Pending</option>
              <option value="Sudah Dikirim" <?= ($filters['status_label'] ?? '') == 'Sudah Dikirim' ? 'selected' : ''; ?>>Sudah Dikirim</option>
              <option value="Direspon" <?= ($filters['status_label'] ?? '') == 'Direspon' ? 'selected' : ''; ?>>Direspon</option>
              <option value="Belum Respon" <?= ($filters['status_label'] ?? '') == 'Belum Respon' ? 'selected' : ''; ?>>Belum Respon</option>
              <option value="Komplain" <?= ($filters['status_label'] ?? '') == 'Komplain' ? 'selected' : ''; ?>>Komplain</option>
              <option value="Selesai" <?= ($filters['status_label'] ?? '') == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
            </select>
          </div>
          <div class="col-md-2">
            <input type="date" name="date_from" class="form-control" placeholder="Dari tanggal" value="<?= $filters['date_from'] ?? ''; ?>">
          </div>
          <div class="col-md-2">
            <input type="date" name="date_to" class="form-control" placeholder="Sampai tanggal" value="<?= $filters['date_to'] ?? ''; ?>">
          </div>
          <div class="col-md-2">
            <input type="text" name="q" class="form-control" placeholder="Cari nama/HP..." value="<?= htmlspecialchars($filters['search'] ?? ''); ?>">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-filter"></i> Filter</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Journal Table -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-list-alt"></i> Data Follow-Up (<?= number_format($entry_counts); ?> entri)</h3>
      <div class="box-tools">
        <button class="btn btn-sm btn-success" id="btn-broadcast-selected" disabled><i class="fa fa-whatsapp"></i> Broadcast Terpilih</button>
        <button class="btn btn-sm btn-default" id="btn-select-all"><i class="fa fa-check-square-o"></i> Pilih Semua Pending</button>
      </div>
    </div>
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover table-journal">
        <thead>
          <tr>
            <th style="width:30px"><input type="checkbox" id="check-all"></th>
            <th>Customer</th>
            <th>No. HP</th>
            <th>No. Pesanan</th>
            <th>Sumber</th>
            <th>Kategori Follow-Up</th>
            <th>Tgl Kirim</th>
            <th>Jadwal Follow-Up</th>
            <th>Status</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($entries)): ?>
          <tr><td colspan="10" class="text-center" style="padding:40px;color:#95a5a6;"><i class="fa fa-check-circle fa-2x text-success"></i><br>Tidak ada follow-up pending saat ini.</td></tr>
          <?php else: foreach ($entries as $e): ?>
          <tr>
            <td>
              <?php if ($e->status_label === 'Pending' && !$e->is_broadcast_sent && !empty($e->customer_phone)): ?>
              <input type="checkbox" class="cb-label" value="<?= $e->id; ?>">
              <?php endif; ?>
            </td>
            <td><strong><?= htmlspecialchars($e->customer_nama); ?></strong></td>
            <td style="font-size:12px;"><i class="fa fa-phone" style="color:#27ae60;"></i> <?= htmlspecialchars($e->customer_phone); ?></td>
            <td style="font-size:12px;"><?= htmlspecialchars($e->no_pesanan ?: '-'); ?></td>
            <td>
              <?php
              $cls = 'badge-toko';
              if (stripos($e->order_source, 'Shopee') !== false) $cls = 'badge-shopee';
              elseif (stripos($e->order_source, 'Tokopedia') !== false) $cls = 'badge-tokopedia';
              elseif (stripos($e->order_source, 'TikTok') !== false) $cls = 'badge-tiktok';
              elseif (stripos($e->order_source, 'Group') !== false) $cls = 'badge-wa-group';
              elseif (stripos($e->order_source, 'WhatsApp') !== false) $cls = 'badge-whatsapp';
              ?>
              <span class="badge-source <?= $cls; ?>"><?= $e->order_source; ?></span>
            </td>
            <td>
              <?php
              $cat_name = htmlspecialchars($e->nama_kategori);
              if (isset($e->jumlah_hari)) {
                $clean_cat = preg_replace('/\s*\(H\+\d+\)/i', '', $cat_name);
                $cat_display = $clean_cat . ' (H+' . $e->jumlah_hari . ')';
              } else {
                $cat_display = $cat_name;
              }
              ?>
              <span class="cat-badge"><?= $cat_display; ?></span>
            </td>
            <td style="font-size:12px; white-space:nowrap;"><?= $e->tanggal_pengiriman ? date('d/m/Y', strtotime($e->tanggal_pengiriman)) : '-'; ?></td>
            <td style="font-size:12px;" class="cell-target-date" data-label-id="<?= $e->id; ?>" data-target="<?= $e->tanggal_label_muncul; ?>">
              <?php
              $target = $e->tanggal_label_muncul;
              $target_time = strtotime($target);
              $today_time = strtotime(date('Y-m-d'));
              $diff_days = (int)round(($today_time - $target_time) / 86400);

              if (!empty($e->tanggal_pengiriman)) {
                $dt_ship = new DateTime($e->tanggal_pengiriman);
                $dt_target = new DateTime($target);
                $selisih_hari = (int)$dt_ship->diff($dt_target)->format('%r%a');
              } else {
                $selisih_hari = isset($e->jumlah_hari) ? (int)$e->jumlah_hari : 0;
              }

              $st = $e->status_label;
              $bh_cls = 'bh-today';
              $bh_icon = 'fa-clock-o';
              $bh_text = '';

              if ($st === 'Pending') {
                if ($diff_days > 0) {
                  $bh_cls = 'bh-overdue';
                  $bh_icon = 'fa-exclamation-triangle';
                  $bh_text = 'Terlewat ' . $diff_days . ' Hari';
                } elseif ($diff_days == 0) {
                  $bh_cls = 'bh-today';
                  $bh_icon = 'fa-clock-o';
                  $bh_text = 'Hari Ini';
                } else {
                  $bh_cls = 'bh-future';
                  $bh_icon = 'fa-calendar';
                  $bh_text = abs($diff_days) . ' Hari Lagi';
                }
              } elseif ($st === 'Sudah Dikirim') {
                $bh_cls = 'bh-sent';
                $bh_icon = 'fa-whatsapp';
                $bh_text = 'WA Terkirim';
              } elseif ($st === 'Direspon') {
                $bh_cls = 'bh-responded';
                $bh_icon = 'fa-comments';
                $bh_text = 'Direspon';
              } elseif ($st === 'Sudah Konfirmasi Diterima') {
                $bh_cls = 'bh-confirmed';
                $bh_icon = 'fa-check-circle';
                $bh_text = 'Barang Diterima';
              } elseif ($st === 'Belum Respon') {
                $bh_cls = 'bh-no-response';
                $bh_icon = 'fa-hourglass-half';
                $bh_text = 'Belum Respon';
              } elseif ($st === 'Komplain') {
                $bh_cls = 'bh-complaint';
                $bh_icon = 'fa-warning';
                $bh_text = 'Komplain';
              } elseif ($st === 'Tawarkan Repeat Order') {
                $bh_cls = 'bh-repeat';
                $bh_icon = 'fa-shopping-cart';
                $bh_text = 'Repeat Order';
              } elseif ($st === 'Selesai') {
                $bh_cls = 'bh-done';
                $bh_icon = 'fa-check-square-o';
                $bh_text = 'Selesai';
              } else {
                $bh_cls = 'bh-done';
                $bh_icon = 'fa-info-circle';
                $bh_text = htmlspecialchars($st);
              }
              ?>
              <div style="display:flex; align-items:center; gap:4px; flex-wrap:wrap; margin-bottom:3px;">
                <strong style="color:#1e293b;"><?= date('d/m/Y', strtotime($target)); ?></strong>
                <span class="label-selisih" title="Selisih <?= $selisih_hari; ?> hari dari Tgl Kirim">(H+<?= $selisih_hari; ?>)</span>
              </div>
              <span class="badge-h-followup <?= $bh_cls; ?>" id="badge-h-<?= $e->id; ?>" title="Status jadwal follow up">
                <i class="fa <?= $bh_icon; ?>"></i> <?= $bh_text; ?>
              </span>
            </td>
            <td>
              <select class="status-select" data-label-id="<?= $e->id; ?>" data-current="<?= $e->status_label; ?>">
                <?php foreach (['Pending','Sudah Dikirim','Direspon','Sudah Konfirmasi Diterima','Belum Respon','Komplain','Tawarkan Repeat Order','Selesai'] as $st): ?>
                <option value="<?= $st; ?>" <?= ($e->status_label == $st) ? 'selected' : ''; ?>><?= $st; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="time-log-wa" id="time-log-<?= $e->id; ?>" style="font-size:11px;color:#27ae60;margin-top:4px;font-weight:600;<?= empty($e->waktu_kirim_wa) ? 'display:none;' : ''; ?>">
                <i class="fa fa-paper-plane" style="color:#25D366;"></i> Terkirim: <span class="time-val"><?= !empty($e->waktu_kirim_wa) ? date('d/m/Y H:i', strtotime($e->waktu_kirim_wa)) : ''; ?></span>
              </div>
              <span class="badge label-success badge-wa-count" id="badge-count-<?= $e->id; ?>" data-count="<?= (int)($e->total_wa_sent ?? 0); ?>" style="background:#25D366;font-size:10px;padding:3px 8px;margin-top:3px;display:<?= (!empty($e->total_wa_sent) && $e->total_wa_sent > 0) ? 'inline-block' : 'none'; ?>;border-radius:10px;" title="Total pengiriman WhatsApp ke customer ini">
                <i class="fa fa-comments"></i> <span class="cnt-val"><?= (int)($e->total_wa_sent ?? 0); ?></span>x Chat WA
              </span>
            </td>
            <td class="text-center" style="white-space:nowrap;">
              <div style="display:inline-flex; align-items:center; justify-content:center; gap:4px;">
                <?php if (!empty($e->customer_phone)): 
                  $clean_ph = preg_replace('/[^0-9]/', '', $e->customer_phone);
                  $wa_ph = (substr($clean_ph, 0, 1) === '0') ? ('62' . substr($clean_ph, 1)) : $clean_ph;
                  if (substr($wa_ph, 0, 2) !== '62') $wa_ph = '62' . $wa_ph;
                  $rendered_msg = $this->model_crm->render_template($e->template_pesan_default, $e);
                  $direct_wa_followup = 'https://api.whatsapp.com/send?phone=' . $wa_ph . '&text=' . rawurlencode($rendered_msg);
                ?>
                <a href="<?= $direct_wa_followup; ?>" target="_blank" class="btn-wa-sm btn-direct-followup <?= $e->is_broadcast_sent ? 'sent-active' : ''; ?>" data-label-id="<?= $e->id; ?>" data-nama="<?= htmlspecialchars($e->customer_nama); ?>" title="Buka WhatsApp Web / Aplikasi untuk Follow-Up Customer ini">
                  <i class="fa fa-whatsapp"></i> Follow-Up WA
                </a>
                <button type="button" class="btn btn-xs btn-default btn-send-wa" data-label-id="<?= $e->id; ?>" title="Pratinjau & Edit Teks Follow-Up Sebelum Kirim" style="border-radius:6px; padding:5px 8px; font-size:11px;">
                  <i class="fa fa-pencil-square-o"></i> Edit
                </button>
                <?php endif; ?>
                <button class="btn btn-xs btn-default btn-add-note" data-label-id="<?= $e->id; ?>" data-nama="<?= htmlspecialchars($e->customer_nama); ?>" title="Tambah Catatan" style="border-radius:6px; padding:5px 8px; font-size:11px;">
                  <i class="fa fa-pencil"></i>
                </button>
              </div>
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

<!-- Modal: 2-Way WhatsApp Chat -->
<style>
.chat-modal .modal-dialog { max-width: 520px; }
.chat-modal .modal-content { border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
.chat-header { background: linear-gradient(135deg, #075e54 0%, #128c7e 100%); color: #fff; padding: 16px 20px; display: flex; align-items: center; gap: 12px; }
.chat-header .avatar { width: 42px; height: 42px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; flex-shrink: 0; }
.chat-header .info { flex: 1; }
.chat-header .info .name { font-size: 15px; font-weight: 700; }
.chat-header .info .meta { font-size: 11px; opacity: 0.8; }

.chat-canvas {
  background: #efeae2;
  background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4cfc6' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  min-height: 320px;
  max-height: 420px;
  overflow-y: auto;
  padding: 16px 14px;
  scroll-behavior: smooth;
}

.chat-bubble {
  max-width: 82%;
  padding: 8px 12px;
  border-radius: 10px;
  font-size: 13px;
  line-height: 1.5;
  margin-bottom: 6px;
  position: relative;
  word-wrap: break-word;
  box-shadow: 0 1px 2px rgba(0,0,0,0.08);
}
.chat-bubble .bubble-time {
  font-size: 10px;
  color: rgba(0,0,0,0.4);
  margin-top: 4px;
  display: flex;
  align-items: center;
  gap: 4px;
  justify-content: flex-end;
}

/* Outgoing: CS sent (right, green) */
.bubble-outgoing {
  background: #d9fdd3;
  color: #1a1a1a;
  margin-left: auto;
  border-bottom-right-radius: 3px;
}
.bubble-outgoing .bubble-sender { display: none; }

/* Incoming: Customer reply (left, white) */
.bubble-incoming {
  background: #ffffff;
  color: #1a1a1a;
  margin-right: auto;
  border-bottom-left-radius: 3px;
}
.bubble-incoming .bubble-sender {
  font-size: 11px;
  font-weight: 700;
  color: #075e54;
  margin-bottom: 2px;
}

/* System note (center, amber) */
.bubble-note {
  background: #fef3c7;
  color: #78350f;
  margin: 6px auto;
  text-align: center;
  border-radius: 8px;
  font-size: 12px;
  max-width: 90%;
  border: 1px solid #fde68a;
}
.bubble-note .bubble-sender {
  font-size: 10px;
  font-weight: 700;
  color: #92400e;
  margin-bottom: 2px;
}

.wa-chat-footer {
  background: #f0f2f5;
  padding: 10px 14px;
  border-top: 1px solid #e2e8f0;
  position: relative;
}

.wa-input-pill-container {
  display: flex;
  align-items: flex-end;
  gap: 8px;
}

.wa-input-pill {
  flex: 1;
  background: #ffffff;
  border: 1px solid #cbd5e1;
  border-radius: 24px;
  padding: 4px 10px 4px 12px;
  display: flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.06);
  transition: border-color 0.2s, box-shadow 0.2s;
  min-height: 42px;
}
.wa-input-pill:focus-within {
  border-color: #00a884;
  box-shadow: 0 0 0 2px rgba(0,168,132,0.15);
}

.wa-icon-btn {
  background: none;
  border: none;
  color: #54656f;
  font-size: 19px;
  cursor: pointer;
  padding: 2px 5px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: color 0.15s, background 0.15s;
  flex-shrink: 0;
}
.wa-icon-btn:hover {
  color: #111b21;
  background: #f0f2f5;
}

.wa-textarea {
  flex: 1;
  border: none;
  outline: none;
  background: transparent;
  resize: none;
  font-size: 14px;
  line-height: 1.4;
  color: #111b21;
  padding: 4px 0;
  max-height: 90px;
  font-family: inherit;
}

.wa-send-btn {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: #00a884;
  color: #ffffff;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(0,168,132,0.35);
  transition: all 0.2s;
  flex-shrink: 0;
}
.wa-send-btn:hover {
  background: #008f6f;
  transform: scale(1.05);
}

.wa-mic-btn {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: #f1f5f9;
  color: #075e54;
  border: 1px solid #cbd5e1;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  cursor: pointer;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
  transition: all 0.2s;
  flex-shrink: 0;
}
.wa-mic-btn:hover {
  background: #ffe4e6;
  color: #e11d48;
  border-color: #fecdd3;
  transform: scale(1.05);
}

/* Emoji Popover */
.wa-emoji-popover {
  position: absolute;
  bottom: 65px;
  left: 14px;
  background: #ffffff;
  border: 1px solid #cbd5e1;
  border-radius: 14px;
  padding: 10px 12px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.18);
  display: none;
  z-index: 1050;
  width: 330px;
}
.wa-emoji-container {
  max-height: 220px;
  overflow-y: auto;
  padding-right: 4px;
}
.wa-emoji-category-title {
  font-size: 10.5px;
  font-weight: 700;
  color: #64748b;
  margin: 8px 0 4px 2px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.wa-emoji-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 4px;
  font-size: 21px;
  text-align: center;
}
.wa-emoji-item {
  cursor: pointer;
  padding: 5px 2px;
  border-radius: 8px;
  transition: background 0.15s, transform 0.1s;
  user-select: none;
  display: flex;
  align-items: center;
  justify-content: center;
}
.wa-emoji-item:hover {
  background: #e2e8f0;
  transform: scale(1.2);
}

/* Attachment Menu Popover */
.wa-attach-popover {
  position: absolute;
  bottom: 65px;
  left: 14px;
  background: #ffffff;
  border: 1px solid #cbd5e1;
  border-radius: 14px;
  padding: 8px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
  display: none;
  z-index: 1050;
  width: 240px;
}
.wa-attach-menu-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 12px;
  font-size: 13px;
  font-weight: 600;
  color: #334155;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.15s;
}
.wa-attach-menu-item:hover {
  background: #f1f5f9;
  color: #0f172a;
}
.wa-attach-icon {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 13px;
}

/* Active Attachment Chip */
.wa-attachment-chip {
  background: #f0f9ff;
  border: 1px solid #bae6fd;
  border-radius: 10px;
  padding: 8px 12px;
  margin-bottom: 8px;
  display: none;
  align-items: center;
  justify-content: space-between;
  font-size: 12px;
  color: #0284c7;
}

.chat-empty {
  text-align: center;
  padding: 50px 20px;
  color: #94a3b8;
  font-size: 13px;
}
.chat-empty i { font-size: 36px; display: block; margin-bottom: 10px; color: #cbd5e1; }

.chat-status-bar {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 14px;
  background: #f8fafc;
  border-top: 1px solid #e2e8f0;
  font-size: 12px;
}
.chat-status-bar select {
  flex: 1;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  padding: 5px 10px;
  font-size: 12px;
  font-weight: 600;
  background: #fff;
}

/* ========================================================
   RICH MEDIA & DOCUMENT PREVIEWS (WHATSAPP STYLE)
   ======================================================== */
.chat-media-card {
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.chat-media-card:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 14px rgba(0,0,0,0.12) !important;
}
.chat-media-clickable {
  position: relative;
  overflow: hidden;
  border-radius: 10px 10px 0 0;
}
.chat-media-clickable:hover .chat-img-hover-overlay {
  opacity: 1 !important;
}
.chat-media-clickable:hover img {
  transform: scale(1.03);
}

.chat-doc-card {
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.chat-doc-card:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 14px rgba(0,0,0,0.12) !important;
}

.btn-open-preview {
  transition: all 0.15s ease;
}
.btn-open-preview:hover {
  filter: brightness(0.92);
  transform: scale(1.02);
}

/* Lightbox Modal */
#modal-media-lightbox .modal-content {
  background: #0f172a !important;
  box-shadow: 0 25px 60px rgba(0,0,0,0.65) !important;
}
.btn-lightbox-tool {
  transition: all 0.15s ease;
}
.btn-lightbox-tool:hover {
  background: rgba(255,255,255,0.3) !important;
  color: #fff !important;
}
#lightbox-img {
  user-select: none;
  -webkit-user-drag: none;
}
</style>

<div class="modal fade chat-modal" id="modal-note" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="chat-header">
        <div class="avatar"><i class="fa fa-user"></i></div>
        <div class="info">
          <div class="name" id="note-customer-name">Customer</div>
          <div class="meta"><i class="fa fa-phone"></i> <span id="chat-phone">-</span> &nbsp;|&nbsp; <i class="fa fa-shopping-bag"></i> <span id="chat-order">-</span></div>
        </div>
        <button type="button" class="btn-refresh-chat" id="btn-refresh-chat" title="Refresh Chat" style="background:rgba(255,255,255,0.2);border:none;color:#fff;width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:14px;margin-right:6px;transition:all 0.2s;">
          <i class="fa fa-refresh"></i>
        </button>
        <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:0.8;font-size:22px;">&times;</button>
      </div>

      <div class="chat-canvas" id="chat-canvas">
        <div class="chat-empty">
          <i class="fa fa-comments-o"></i>
          Memuat riwayat percakapan...
        </div>
      </div>

      <div class="chat-status-bar">
        <label style="margin:0;font-weight:600;white-space:nowrap;color:#475569;">Status:</label>
        <select id="note-status">
          <option value="">-- Tidak ubah --</option>
          <option value="Direspon">Direspon</option>
          <option value="Sudah Konfirmasi Diterima">Sudah Konfirmasi Diterima</option>
          <option value="Belum Respon">Belum Respon</option>
          <option value="Komplain">Komplain</option>
          <option value="Tawarkan Repeat Order">Tawarkan Repeat Order</option>
          <option value="Selesai">Selesai</option>
        </select>
      </div>

      <div class="chat-footer wa-chat-footer">
        <!-- Sender Type Toggle: CS WA Reply vs Internal Note -->
        <div class="sender-toggle" style="display:flex;gap:6px;margin-bottom:8px;">
          <button type="button" class="btn-toggle-sender active" data-type="cs_chat" style="flex:1;padding:6px 10px;border:2px solid #00a884;background:#d9fdd3;color:#005c4b;border-radius:20px;font-size:11.5px;font-weight:700;cursor:pointer;transition:all 0.2s;">
            <i class="fa fa-whatsapp"></i> Balasan CS (WA)
          </button>
          <button type="button" class="btn-toggle-sender" data-type="cs" style="flex:1;padding:6px 10px;border:2px solid #e2e8f0;background:#fff;color:#64748b;border-radius:20px;font-size:11.5px;font-weight:700;cursor:pointer;transition:all 0.2s;">
            <i class="fa fa-bookmark"></i> Catatan Internal
          </button>
        </div>

        <!-- Emoji Popover (Banyak Emoji Lengkap) -->
        <div class="wa-emoji-popover" id="wa-emoji-popover">
          <div style="font-size:11.5px;font-weight:700;color:#334155;margin-bottom:8px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f1f5f9;padding-bottom:6px;">
            <span><i class="fa fa-smile-o" style="color:#f59e0b;"></i> Pilih Emoji WhatsApp:</span>
            <button type="button" id="btn-close-emoji" style="background:none;border:none;color:#94a3b8;cursor:pointer;font-size:18px;line-height:1;">&times;</button>
          </div>
          <div class="wa-emoji-container">
            <div class="wa-emoji-category-title" style="margin-top:2px;">Ekspresi & Wajah</div>
            <div class="wa-emoji-grid">
              <span class="wa-emoji-item">😊</span>
              <span class="wa-emoji-item">😀</span>
              <span class="wa-emoji-item">😁</span>
              <span class="wa-emoji-item">😂</span>
              <span class="wa-emoji-item">🤣</span>
              <span class="wa-emoji-item">😃</span>
              <span class="wa-emoji-item">😄</span>
              <span class="wa-emoji-item">😅</span>
              <span class="wa-emoji-item">😆</span>
              <span class="wa-emoji-item">😉</span>
              <span class="wa-emoji-item">😋</span>
              <span class="wa-emoji-item">😎</span>
              <span class="wa-emoji-item">😍</span>
              <span class="wa-emoji-item">😘</span>
              <span class="wa-emoji-item">🥰</span>
              <span class="wa-emoji-item">😗</span>
              <span class="wa-emoji-item">😙</span>
              <span class="wa-emoji-item">😚</span>
              <span class="wa-emoji-item">☺️</span>
              <span class="wa-emoji-item">🙂</span>
              <span class="wa-emoji-item">🤗</span>
              <span class="wa-emoji-item">🤩</span>
              <span class="wa-emoji-item">🤔</span>
              <span class="wa-emoji-item">🤨</span>
              <span class="wa-emoji-item">😐</span>
              <span class="wa-emoji-item">😑</span>
              <span class="wa-emoji-item">😶</span>
              <span class="wa-emoji-item">🙄</span>
              <span class="wa-emoji-item">😏</span>
              <span class="wa-emoji-item">😣</span>
              <span class="wa-emoji-item">😥</span>
              <span class="wa-emoji-item">😮</span>
              <span class="wa-emoji-item">🤐</span>
              <span class="wa-emoji-item">😯</span>
              <span class="wa-emoji-item">😪</span>
              <span class="wa-emoji-item">😫</span>
              <span class="wa-emoji-item">😴</span>
              <span class="wa-emoji-item">😌</span>
              <span class="wa-emoji-item">😛</span>
              <span class="wa-emoji-item">😜</span>
              <span class="wa-emoji-item">😝</span>
              <span class="wa-emoji-item">🤤</span>
            </div>

            <div class="wa-emoji-category-title">Tangan & Gestur</div>
            <div class="wa-emoji-grid">
              <span class="wa-emoji-item">👍</span>
              <span class="wa-emoji-item">👎</span>
              <span class="wa-emoji-item">👌</span>
              <span class="wa-emoji-item">✌️</span>
              <span class="wa-emoji-item">🤞</span>
              <span class="wa-emoji-item">🤟</span>
              <span class="wa-emoji-item">🤘</span>
              <span class="wa-emoji-item">🤙</span>
              <span class="wa-emoji-item">👈</span>
              <span class="wa-emoji-item">👉</span>
              <span class="wa-emoji-item">👆</span>
              <span class="wa-emoji-item">👇</span>
              <span class="wa-emoji-item">☝️</span>
              <span class="wa-emoji-item">✋</span>
              <span class="wa-emoji-item">🤚</span>
              <span class="wa-emoji-item">🖐️</span>
              <span class="wa-emoji-item">👋</span>
              <span class="wa-emoji-item">💪</span>
              <span class="wa-emoji-item">✍️</span>
              <span class="wa-emoji-item">🙏</span>
              <span class="wa-emoji-item">🤝</span>
              <span class="wa-emoji-item">👏</span>
              <span class="wa-emoji-item">🙌</span>
              <span class="wa-emoji-item">🤲</span>
            </div>

            <div class="wa-emoji-category-title">Bisnis, Toko & Pengiriman</div>
            <div class="wa-emoji-grid">
              <span class="wa-emoji-item">📦</span>
              <span class="wa-emoji-item">🚚</span>
              <span class="wa-emoji-item">🚛</span>
              <span class="wa-emoji-item">🛍️</span>
              <span class="wa-emoji-item">🛒</span>
              <span class="wa-emoji-item">💰</span>
              <span class="wa-emoji-item">💵</span>
              <span class="wa-emoji-item">💳</span>
              <span class="wa-emoji-item">🧾</span>
              <span class="wa-emoji-item">🏷️</span>
              <span class="wa-emoji-item">💼</span>
              <span class="wa-emoji-item">📄</span>
              <span class="wa-emoji-item">📑</span>
              <span class="wa-emoji-item">📋</span>
              <span class="wa-emoji-item">📌</span>
              <span class="wa-emoji-item">📍</span>
              <span class="wa-emoji-item">✉️</span>
              <span class="wa-emoji-item">📧</span>
              <span class="wa-emoji-item">📞</span>
              <span class="wa-emoji-item">📱</span>
              <span class="wa-emoji-item">💬</span>
              <span class="wa-emoji-item">⏰</span>
              <span class="wa-emoji-item">⏳</span>
              <span class="wa-emoji-item">📅</span>
              <span class="wa-emoji-item">🗓️</span>
              <span class="wa-emoji-item">🔍</span>
              <span class="wa-emoji-item">📢</span>
              <span class="wa-emoji-item">🎁</span>
            </div>

            <div class="wa-emoji-category-title">Simbol & Bintang</div>
            <div class="wa-emoji-grid">
              <span class="wa-emoji-item">⭐</span>
              <span class="wa-emoji-item">🌟</span>
              <span class="wa-emoji-item">✨</span>
              <span class="wa-emoji-item">💫</span>
              <span class="wa-emoji-item">🔥</span>
              <span class="wa-emoji-item">💥</span>
              <span class="wa-emoji-item">💯</span>
              <span class="wa-emoji-item">❤️</span>
              <span class="wa-emoji-item">💖</span>
              <span class="wa-emoji-item">💕</span>
              <span class="wa-emoji-item">✔️</span>
              <span class="wa-emoji-item">❌</span>
              <span class="wa-emoji-item">❗</span>
              <span class="wa-emoji-item">❓</span>
              <span class="wa-emoji-item">⚠️</span>
              <span class="wa-emoji-item">🔴</span>
              <span class="wa-emoji-item">🟢</span>
              <span class="wa-emoji-item">🔵</span>
              <span class="wa-emoji-item">👑</span>
              <span class="wa-emoji-item">💎</span>
              <span class="wa-emoji-item">🎉</span>
              <span class="wa-emoji-item">🎊</span>
              <span class="wa-emoji-item">💡</span>
              <span class="wa-emoji-item">⚡</span>
              <span class="wa-emoji-item">🚀</span>
              <span class="wa-emoji-item">🏆</span>
              <span class="wa-emoji-item">🎯</span>
              <span class="wa-emoji-item">🥇</span>
            </div>
          </div>
        </div>

        <!-- Attachment Popover Menu -->
        <div class="wa-attach-popover" id="wa-attach-popover">
          <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;display:flex;justify-content:space-between;align-items:center;padding:0 4px;">
            <span>Lampirkan Berkas:</span>
            <button type="button" id="btn-close-attach-pop" style="background:none;border:none;color:#94a3b8;cursor:pointer;">&times;</button>
          </div>
          <div class="wa-attach-menu-item" id="wa-opt-doc">
            <div class="wa-attach-icon" style="background:#7f66ff;"><i class="fa fa-file-text-o"></i></div>
            <div>Dokumen & PDF</div>
          </div>
          <div class="wa-attach-menu-item" id="wa-opt-img">
            <div class="wa-attach-icon" style="background:#007bfc;"><i class="fa fa-picture-o"></i></div>
            <div>Foto & Gambar</div>
          </div>
          <div class="wa-attach-menu-item" id="wa-opt-audio">
            <div class="wa-attach-icon" style="background:#ff2e74;"><i class="fa fa-microphone"></i></div>
            <div>Voice Note / Audio</div>
          </div>
          <div class="wa-attach-menu-item" id="wa-opt-url">
            <div class="wa-attach-icon" style="background:#0284c7;"><i class="fa fa-link"></i></div>
            <div>Tempel URL / Link</div>
          </div>
        </div>

        <!-- URL Input Container (Hidden by default) -->
        <div id="wa-url-input-container" style="display:none;margin-bottom:8px;">
          <div style="display:flex;gap:6px;">
            <input type="url" id="note-file-url" class="form-control" placeholder="Tempelkan URL file (https://...)" style="font-size:12px;border-radius:8px;height:34px;">
            <button type="button" class="btn btn-sm btn-default" id="btn-close-url-input" style="border-radius:8px;">&times;</button>
          </div>
        </div>

        <!-- Active Attachment Chip -->
        <div class="wa-attachment-chip" id="wa-attachment-chip">
          <div style="display:flex;align-items:center;gap:6px;overflow:hidden;">
            <i class="fa fa-paperclip" style="font-size:14px;"></i>
            <span id="wa-attach-filename" style="font-weight:700;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;max-width:240px;">file.pdf</span>
            <span id="wa-upload-spinner" style="display:none;"><i class="fa fa-spin fa-spinner"></i> Mengunggah...</span>
          </div>
          <button type="button" id="btn-remove-attachment" style="background:none;border:none;color:#ef4444;cursor:pointer;font-weight:700;font-size:14px;">&times;</button>
        </div>

        <!-- Hidden Native File Upload Input -->
        <input type="file" id="chat-file-upload" style="display:none;" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar">

        <!-- WhatsApp Reply Quote Preview Bar -->
        <div id="wa-reply-preview-bar" style="display:none;background:#f0fdf4;border-left:4px solid #00a884;padding:6px 12px;margin-bottom:8px;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.05);position:relative;">
          <div style="display:flex;align-items:center;justify-content:space-between;">
            <div style="font-weight:700;font-size:11.5px;color:#00a884;">
              <i class="fa fa-reply"></i> Membalas: <span id="wa-reply-sender-name">Nama</span>
            </div>
            <button type="button" id="btn-cancel-reply" style="background:none;border:none;color:#ef4444;font-size:14px;font-weight:700;cursor:pointer;padding:0 4px;" title="Batal Balas">&times;</button>
          </div>
          <div id="wa-reply-text-preview" style="font-size:11px;color:#475569;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-top:2px;max-width:92%;">Pesan...</div>
        </div>

        <!-- WhatsApp Input Bar (Paperclip - Emoji - Input Textarea - Send Button) -->
        <div class="wa-input-pill-container">
          <div class="wa-input-pill">
            <button type="button" class="wa-icon-btn" id="btn-toggle-attach" title="Kirim File / Dokumen / Foto">
              <i class="fa fa-paperclip"></i>
            </button>
            <button type="button" class="wa-icon-btn" id="btn-toggle-emoji" title="Pilih Emoji">
              <i class="fa fa-smile-o"></i>
            </button>
            <textarea id="note-text" class="wa-textarea" rows="1" placeholder="Ketik pesan"></textarea>
          </div>
          <button type="button" class="wa-send-btn" id="btn-save-note" title="Kirim Pesan (✈️)">
            <i class="fa fa-paper-plane" id="wa-send-icon"></i>
          </button>
        </div>
      </div>

      <input type="hidden" id="note-label-id">
      <input type="hidden" id="note-sender-type" value="cs_chat">
    </div>
  </div>
</div>

<!-- Modal: Preview & Edit WA Message -->
<div class="modal fade" id="modal-wa-preview" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#25D366;color:#fff;">
        <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:0.9;">&times;</button>
        <h4 class="modal-title" style="font-weight:700;"><i class="fa fa-whatsapp"></i> Pratinjau & Edit Pesan WhatsApp</h4>
      </div>
      <div class="modal-body">
        <div style="background:#f8fafc;border:1px solid #e2e8f0;padding:12px 16px;border-radius:10px;margin-bottom:15px;font-size:12px;">
          <div style="margin-bottom:4px;"><strong>Penerima:</strong> <span id="wa-preview-name" style="font-weight:700;color:#1e293b;"></span> (<span id="wa-preview-phone" style="color:#2563eb;"></span>)</div>
          <div><strong>No. Pesanan:</strong> <span id="wa-preview-order" style="color:#64748b;"></span></div>
        </div>
        <div class="form-group">
          <label style="font-weight:700;font-size:13px;color:#334155;"><i class="fa fa-pencil-square-o" style="color:#25D366;"></i> Isi Pesan WhatsApp (Bisa Diubah):</label>
          <textarea class="form-control" id="wa-preview-message" rows="6" style="font-family:inherit;font-size:13px;line-height:1.6;border-radius:8px;border:1px solid #cbd5e1;padding:12px;" placeholder="Isi pesan WhatsApp..."></textarea>
        </div>
        <div class="form-group" style="margin-top:10px;">
          <label style="font-weight:700;font-size:12px;color:#334155;"><i class="fa fa-paperclip" style="color:#0284c7;"></i> Lampiran File / Dokumen / Foto (Opsional):</label>
          <div style="display:flex;gap:8px;align-items:center;">
            <input type="text" id="wa-preview-file-url" class="form-control input-sm" placeholder="URL file atau klik Unggah File..." style="border-radius:8px;font-size:12px;">
            <button type="button" class="btn btn-sm btn-default" id="btn-browse-preview-file" style="border-radius:8px;white-space:nowrap;font-weight:600;"><i class="fa fa-folder-open"></i> Unggah File</button>
          </div>
          <input type="file" id="input-file-preview-modal" style="display:none;" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.mp3,.wav,.ogg,.m4a">
          <small id="preview-file-status" class="text-muted" style="font-size:11px;margin-top:4px;display:block;"><i class="fa fa-info-circle" style="color:#3b82f6;"></i> Dukungan format: Foto (JPG/PNG), Dokumen (PDF/Word/Excel), ZIP/RAR, & Voice Note (MP3/WAV).</small>
        </div>
        <input type="hidden" id="wa-preview-label-id">
        <input type="hidden" id="wa-preview-raw-phone">
      </div>
      <div class="modal-footer" style="background:#f8fafc;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="btn-confirm-send-wa" style="background:#25D366;border:none;font-weight:700;padding:8px 20px;">
          <i class="fa fa-whatsapp"></i> Buka & Kirim di WhatsApp
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Tambah Follow-Up Manual -->
<div class="modal fade" id="modal-manual-add" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:12px;overflow:hidden;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
      <div class="modal-header" style="background:#0284c7;color:#fff;padding:14px 18px;">
        <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:0.9;">&times;</button>
        <h4 class="modal-title" style="font-weight:700;font-size:15px;"><i class="fa fa-plus-circle"></i> Tambah Follow-Up Manual Baru</h4>
      </div>
      <form id="form-manual-add">
        <div class="modal-body" style="padding:18px;">
          <div class="form-group">
            <label style="font-size:12px;color:#334155;font-weight:600;">Nama Customer <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="customer_nama" placeholder="Contoh: Budi Santoso" required style="border-radius:8px;height:38px;">
          </div>
          <div class="form-group">
            <label style="font-size:12px;color:#334155;font-weight:600;">Nomor WhatsApp / Telepon <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="customer_phone" placeholder="Contoh: 081234567890" required style="border-radius:8px;height:38px;">
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-size:12px;color:#334155;font-weight:600;">No. Pesanan / Resi (Opsional)</label>
                <input type="text" class="form-control" name="no_pesanan" placeholder="Contoh: INV-20260901" style="border-radius:8px;height:38px;">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-size:12px;color:#334155;font-weight:600;">Sumber Order</label>
                <select class="form-control" name="order_source" style="border-radius:8px;height:38px;">
                  <option value="Toko">Toko</option>
                  <option value="WhatsApp">WhatsApp</option>
                  <option value="Shopee">Shopee</option>
                  <option value="Tokopedia">Tokopedia</option>
                  <option value="TikTok Shop">TikTok Shop</option>
                  <option value="Lazada">Lazada</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-size:12px;color:#334155;font-weight:600;">Tanggal Kirim / Transaksi</label>
                <input type="date" class="form-control" name="tanggal_pengiriman" value="<?= date('Y-m-d'); ?>" required style="border-radius:8px;height:38px;">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-size:12px;color:#334155;font-weight:600;">Kategori Label</label>
                <select class="form-control" name="cat_mode" style="border-radius:8px;height:38px;">
                  <option value="all">Semua Kategori (H+0 s/d H+30)</option>
                  <?php foreach ($categories as $c): ?>
                  <option value="<?= $c->id; ?>"><?= htmlspecialchars($c->nama_kategori); ?> (H+<?= $c->jumlah_hari; ?>)</option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background:#f8fafc;padding:12px 18px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:8px;">Batal</button>
          <button type="submit" class="btn btn-primary" id="btn-submit-manual-add" style="background:#0284c7;border:none;border-radius:8px;font-weight:700;padding:8px 20px;">
            <i class="fa fa-save"></i> Simpan Follow-Up
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Media Lightbox & Document Preview -->
<div class="modal fade" id="modal-media-lightbox" tabindex="-1" role="dialog" style="z-index: 10050;">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 920px; width: 92%; margin: 30px auto;">
    <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 25px 50px rgba(0,0,0,0.5); background: #0f172a; color: #fff;">
      
      <!-- Lightbox Header -->
      <div class="modal-header" style="background: rgba(30, 41, 59, 0.9); backdrop-filter: blur(8px); border-bottom: 1px solid rgba(255,255,255,0.1); padding: 12px 20px; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 10px; overflow: hidden; padding-right: 12px;">
          <span id="lightbox-badge" class="badge" style="background: #3b82f6; font-size: 11px; padding: 4px 8px; border-radius: 6px; text-transform: uppercase;">PRATINJAU</span>
          <div id="lightbox-filename" style="font-weight: 700; font-size: 13.5px; color: #f8fafc; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 420px;">Lampiran Media</div>
        </div>
        
        <!-- Toolbar Actions -->
        <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
          <div id="lightbox-img-tools" style="display: none; align-items: center; gap: 4px; margin-right: 6px;">
            <button type="button" class="btn btn-xs btn-default btn-lightbox-tool" id="btn-lightbox-zoomin" title="Perbesar (+)" style="background: rgba(255,255,255,0.15); border: none; color: #fff; border-radius: 6px; width: 30px; height: 28px;"><i class="fa fa-search-plus"></i></button>
            <button type="button" class="btn btn-xs btn-default btn-lightbox-tool" id="btn-lightbox-zoomout" title="Perkecil (-)" style="background: rgba(255,255,255,0.15); border: none; color: #fff; border-radius: 6px; width: 30px; height: 28px;"><i class="fa fa-search-minus"></i></button>
            <button type="button" class="btn btn-xs btn-default btn-lightbox-tool" id="btn-lightbox-rotate" title="Putar 90°" style="background: rgba(255,255,255,0.15); border: none; color: #fff; border-radius: 6px; width: 30px; height: 28px;"><i class="fa fa-repeat"></i></button>
            <button type="button" class="btn btn-xs btn-default btn-lightbox-tool" id="btn-lightbox-zoomreset" title="Reset Ukuran" style="background: rgba(255,255,255,0.15); border: none; color: #fff; border-radius: 6px; font-size: 10px; padding: 0 8px; height: 28px; font-weight: 700;">1:1</button>
          </div>

          <a href="#" id="btn-lightbox-open-tab" target="_blank" class="btn btn-xs btn-default" title="Buka di Tab Baru" style="background: rgba(255,255,255,0.15); border: none; color: #fff; border-radius: 6px; padding: 5px 10px; font-size: 11px; font-weight: 600;">
            <i class="fa fa-external-link"></i> Tab Baru
          </a>
          <a href="#" id="btn-lightbox-download" download class="btn btn-xs btn-success" title="Unduh File" style="background: #10b981; border: none; color: #fff; border-radius: 6px; padding: 5px 12px; font-size: 11px; font-weight: 700;">
            <i class="fa fa-download"></i> Unduh
          </a>
          <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.8; font-size: 24px; margin-left: 8px; line-height: 24px;">&times;</button>
        </div>
      </div>

      <!-- Lightbox Body -->
      <div class="modal-body" style="padding: 0; background: #020617; position: relative; min-height: 400px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        
        <!-- Loading Spinner -->
        <div id="lightbox-loading" style="display: none; position: absolute; z-index: 10; color: #94a3b8; text-align: center;">
          <i class="fa fa-spinner fa-spin" style="font-size: 32px; color: #6366f1;"></i>
          <p style="margin-top: 8px; font-size: 12px;">Memuat pratinjau...</p>
        </div>

        <!-- Image Viewer Container -->
        <div id="lightbox-img-container" style="display: none; width: 100%; height: 75vh; overflow: auto; align-items: center; justify-content: center; padding: 20px;">
          <img id="lightbox-img" src="" alt="Pratinjau Foto" style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.15s ease-out; box-shadow: 0 10px 30px rgba(0,0,0,0.5); border-radius: 8px;">
        </div>

        <!-- PDF / Document iframe Viewer -->
        <div id="lightbox-doc-container" style="display: none; width: 100%; height: 78vh;">
          <iframe id="lightbox-iframe" src="" style="width: 100%; height: 100%; border: none; background: #fff;"></iframe>
        </div>

        <!-- Video Viewer -->
        <div id="lightbox-video-container" style="display: none; width: 100%; max-height: 75vh; padding: 20px; text-align: center;">
          <video id="lightbox-video" controls autoplay style="max-width: 100%; max-height: 70vh; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);"></video>
        </div>

        <!-- Audio Viewer -->
        <div id="lightbox-audio-container" style="display: none; padding: 50px 20px; text-align: center; width: 100%;">
          <div style="width: 70px; height: 70px; border-radius: 50%; background: #059669; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 28px;">
            <i class="fa fa-music"></i>
          </div>
          <h4 id="lightbox-audio-title" style="color: #fff; font-weight: 700; margin-bottom: 16px;">Pemutar Audio</h4>
          <audio id="lightbox-audio" controls style="width: 80%; max-width: 450px;"></audio>
        </div>

        <!-- Generic / Fallback Viewer -->
        <div id="lightbox-generic-container" style="display: none; padding: 50px 20px; text-align: center;">
          <div id="lightbox-generic-icon" style="font-size: 56px; color: #60a5fa; margin-bottom: 16px;">
            <i class="fa fa-file-text-o"></i>
          </div>
          <h4 id="lightbox-generic-title" style="color: #fff; font-weight: 700; margin-bottom: 8px;">Dokumen Terlampir</h4>
          <p id="lightbox-generic-desc" style="color: #94a3b8; font-size: 13px; max-width: 420px; margin: 0 auto 20px;">File ini siap diunduh atau dibuka di aplikasi eksternal.</p>
          <a href="#" id="lightbox-generic-download" download class="btn btn-primary" style="border-radius: 8px; font-weight: 700; padding: 8px 20px; background: #3b82f6; border: none;">
            <i class="fa fa-download"></i> Unduh File Sekarang
          </a>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  var csrf_name = '<?= $this->security->get_csrf_token_name(); ?>';
  var csrf_hash = '<?= $this->security->get_csrf_hash(); ?>';
  var rawBase = (typeof BASE_URL !== 'undefined') ? BASE_URL : '<?= base_url(); ?>';
  var _BASE = rawBase.replace(/\/+$/, '') + '/';

  // Move modals to body to prevent container z-index overlay issues
  if ($('#modal-note').length) $('#modal-note').appendTo('body');
  if ($('#modal-wa-preview').length) $('#modal-wa-preview').appendTo('body');
  if ($('#modal-manual-add').length) $('#modal-manual-add').appendTo('body');
  if ($('#modal-media-lightbox').length) $('#modal-media-lightbox').appendTo('body');

  $('.modal-backdrop').remove();
  $('body').removeClass('modal-open');

  $(document).on('hidden.bs.modal', '#modal-note, #modal-wa-preview', function () {
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css('padding-right', '');
  });

  function buildPayload(data) {
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

  // ===== Sync Label H+ (CRON) =====
  $(document).on('click', '#btn-sync-cron', function() {
    var $btn = $(this);
    $btn.prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Memindai...');
    $.get(_BASE + 'administrator/crm/generate_labels_cron', function(res) {
      var r = parseRes(res);
      notify('success', r.message || ('Berhasil generate ' + (r.generated || 0) + ' label baru!'));
      setTimeout(function() { location.reload(); }, 1500);
    }).fail(function() {
      notify('error', 'Gagal menjalankan sinkronisasi label');
      $btn.prop('disabled', false).html('<i class="fa fa-refresh"></i> Sync Label H+');
    });
  });

  function updateBadgeRealtime(label_id, status) {
    var $cell = $('.cell-target-date[data-label-id="' + label_id + '"]');
    if (!$cell.length) return;
    
    var targetStr = $cell.data('target');
    if (!targetStr) return;

    var targetDate = new Date(targetStr + 'T00:00:00');
    var todayDate = new Date();
    todayDate.setHours(0,0,0,0);
    
    var diffTime = todayDate.getTime() - targetDate.getTime();
    var diffDays = Math.round(diffTime / (1000 * 3600 * 24));

    var cls = 'bh-done';
    var icon = 'fa-info-circle';
    var text = status;

    if (status === 'Pending') {
      if (diffDays > 0) {
        cls = 'bh-overdue'; icon = 'fa-exclamation-triangle'; text = 'Terlewat ' + diffDays + ' Hari (Pending)';
      } else if (diffDays === 0) {
        cls = 'bh-today'; icon = 'fa-clock-o'; text = 'Jadwal Follow-Up Hari Ini';
      } else {
        cls = 'bh-future'; icon = 'fa-calendar'; text = Math.abs(diffDays) + ' Hari Lagi';
      }
    } else if (status === 'Sudah Dikirim') {
      cls = 'bh-sent'; icon = 'fa-whatsapp'; text = 'WA Sudah Dikirim';
    } else if (status === 'Direspon') {
      cls = 'bh-responded'; icon = 'fa-comments'; text = 'Customer Direspon';
    } else if (status === 'Sudah Konfirmasi Diterima') {
      cls = 'bh-confirmed'; icon = 'fa-check-circle'; text = 'Barang Diterima';
    } else if (status === 'Belum Respon') {
      cls = 'bh-no-response'; icon = 'fa-hourglass-half'; text = 'Belum Respon';
    } else if (status === 'Komplain') {
      cls = 'bh-complaint'; icon = 'fa-warning'; text = 'Ada Komplain';
    } else if (status === 'Tawarkan Repeat Order') {
      cls = 'bh-repeat'; icon = 'fa-shopping-cart'; text = 'Penawaran Repeat Order';
    } else if (status === 'Selesai') {
      cls = 'bh-done'; icon = 'fa-check-square-o'; text = 'Follow-Up Selesai';
    }

    var $badge = $('#badge-h-' + label_id);
    if ($badge.length) {
      $badge.attr('class', 'badge-h-followup ' + cls)
            .html('<i class="fa ' + icon + '"></i> ' + text);
    }
  }

  // ===== Status Change Inline =====
  $(document).on('change', '.status-select', function() {
    var $sel = $(this);
    var label_id = $sel.attr('data-label-id');
    var status = $sel.val();
    updateBadgeRealtime(label_id, status);
    $.post(_BASE + 'administrator/crm/update_status_ajax', buildPayload({ label_id: label_id, status: status }), function(res) {
      var r = parseRes(res);
      if (r.success) {
        notify('success', 'Status diperbarui');
        $sel.data('current', status);
      } else {
        notify('error', r.message || 'Gagal memperbarui status');
      }
    }).fail(function() {
      notify('error', 'Gagal menghubungi server');
    });
  });

  // ===== Direct WhatsApp Follow-Up Click (Redirect to WA Web / WA App) =====
  $(document).on('click', '.btn-direct-followup', function() {
    var $btn = $(this);
    var label_id = $btn.attr('data-label-id');
    var nama = $btn.attr('data-nama') || 'Customer';

    $btn.addClass('sent-active');
    
    var dt = new Date();
    var nowStr = ('0' + dt.getDate()).slice(-2) + '/' + ('0' + (dt.getMonth() + 1)).slice(-2) + '/' + dt.getFullYear() + ' ' + ('0' + dt.getHours()).slice(-2) + ':' + ('0' + dt.getMinutes()).slice(-2);
    $('#time-log-' + label_id).show().find('.time-val').text(nowStr);

    var $cntBadge = $('#badge-count-' + label_id);
    var currCnt = parseInt($cntBadge.attr('data-count') || 0) + 1;
    $cntBadge.attr('data-count', currCnt).find('.cnt-val').text(currCnt);
    $cntBadge.css('display', 'inline-block');

    var $statusSel = $('.status-select[data-label-id="' + label_id + '"]');
    if ($statusSel.length && $statusSel.val() === 'Pending') {
      $statusSel.val('Sudah Dikirim').trigger('change');
    }

    notify('success', 'Membuka WhatsApp Web / Aplikasi untuk ' + nama);

    // Kirim pencatatan log ke server di latar belakang
    $.post(_BASE + 'administrator/crm/log_direct_followup_ajax', buildPayload({
      label_id: label_id
    }));
  });

  // ===== Single WA Send (With Preview & Edit Modal) =====
  $(document).on('click', '.btn-send-wa', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $btn = $(this);
    var label_id = $btn.attr('data-label-id');

    if (!label_id) {
      notify('error', 'Label ID tidak ditemukan');
      return;
    }

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

    $.get(_BASE + 'administrator/crm/get_wa_link_ajax', { label_id: label_id }, function(res) {
      $btn.prop('disabled', false).html('<i class="fa fa-whatsapp"></i> Kirim WA');
      var r = parseRes(res);
      if (r.success) {
        $('#wa-preview-label-id').val(label_id);
        $('#wa-preview-name').text(r.nama || '-');
        $('#wa-preview-phone').text(r.phone || '-');
        $('#wa-preview-raw-phone').val(r.phone || '');
        $('#wa-preview-order').text(r.no_pesanan || '-');
        $('#wa-preview-message').val(r.message_preview || '');
        $('#wa-preview-file-url').val('');
        $('#preview-file-status').html('<i class="fa fa-info-circle" style="color:#3b82f6;"></i> Dukungan format: Foto (JPG/PNG), Dokumen (PDF/Word/Excel), ZIP/RAR, & Voice Note (MP3/WAV).');

        $('.modal-backdrop').remove();
        $('#modal-wa-preview').modal('show');
        setTimeout(function() { $('#wa-preview-message').focus(); }, 300);
      } else {
        notify('error', r.message || 'Gagal memuat pratinjau pesan WA');
      }
    }).fail(function() {
      $btn.prop('disabled', false).html('<i class="fa fa-whatsapp"></i> Kirim WA');
      notify('error', 'Gagal menghubungi server');
    });
  });

  // Modal Preview File Upload Browse & Handler
  $(document).on('click', '#btn-browse-preview-file', function() {
    $('#input-file-preview-modal').click();
  });

  $(document).on('change', '#input-file-preview-modal', function() {
    var file = this.files[0];
    if (!file) return;

    var formData = new FormData();
    formData.append('file', file);
    if (csrf_name && csrf_hash) formData.append(csrf_name, csrf_hash);

    $('#preview-file-status').html('<i class="fa fa-spinner fa-spin" style="color:#0284c7;"></i> Mengunggah file ' + file.name + '...');

    $.ajax({
      url: _BASE + 'administrator/crm/upload_attachment_ajax',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(res) {
        var r = parseRes(res);
        if (r.success && r.file_url) {
          $('#wa-preview-file-url').val(r.file_url);
          $('#preview-file-status').html('<i class="fa fa-check-circle" style="color:#10b981;"></i> Berhasil mengunggah: <strong>' + (r.file_name || file.name) + '</strong>');
          notify('success', 'File ' + file.name + ' berhasil diunggah!');
        } else {
          $('#preview-file-status').html('<i class="fa fa-exclamation-circle" style="color:#ef4444;"></i> ' + (r.message || 'Gagal mengunggah file'));
          notify('error', r.message || 'Gagal mengunggah file');
        }
      },
      error: function() {
        $('#preview-file-status').html('<i class="fa fa-exclamation-circle" style="color:#ef4444;"></i> Gagal mengunggah file ke server');
        notify('error', 'Gagal mengunggah file ke server');
      }
    });
  });

  // ===== Confirm & Send Custom WA Message =====
  $(document).on('click', '#btn-confirm-send-wa', function() {
    var $btn = $(this);
    var label_id = $('#wa-preview-label-id').val();
    var customMsg = $.trim($('#wa-preview-message').val());
    var rawPhone = $('#wa-preview-raw-phone').val();
    var nama = $('#wa-preview-name').text();

    var customFileUrl = $.trim($('#wa-preview-file-url').val());

    if (!customMsg && !customFileUrl) {
      notify('warning', 'Pesan WA atau lampiran file tidak boleh kosong');
      return;
    }

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Mengirim...');

    $.post(_BASE + 'administrator/crm/send_broadcast_ajax', buildPayload({
      label_ids: [label_id],
      custom_message: customMsg,
      file_url: customFileUrl
    }), function(res) {
      $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Kirim via WhatsApp');
      var r = parseRes(res);
      $('#modal-wa-preview').modal('hide');
      
      var $targetBtn = $('.btn-send-wa[data-label-id="' + label_id + '"]');
      $targetBtn.addClass('sent-active').prop('disabled', false).attr('title', 'Sudah pernah dikirim (Klik untuk kirim ulang / follow up susulan)');

      var dt = new Date();
      var nowStr = ('0' + dt.getDate()).slice(-2) + '/' + ('0' + (dt.getMonth() + 1)).slice(-2) + '/' + dt.getFullYear() + ' ' + ('0' + dt.getHours()).slice(-2) + ':' + ('0' + dt.getMinutes()).slice(-2);
      $('#time-log-' + label_id).show().find('.time-val').text(nowStr);

      var $cntBadge = $('#badge-count-' + label_id);
      var currCnt = parseInt($cntBadge.attr('data-count') || 0) + 1;
      $cntBadge.attr('data-count', currCnt).find('.cnt-val').text(currCnt);
      $cntBadge.css('display', 'inline-block');

      var $statusSel = $('.status-select[data-label-id="' + label_id + '"]');
      if ($statusSel.length && $statusSel.val() === 'Pending') {
        $statusSel.val('Sudah Dikirim').trigger('change');
      }

      if (r.mode === 'wa_gateway') {
        var apiSuccess = true;
        var apiMsg = '';
        if (r.api_results && r.api_results.length > 0) {
          apiSuccess = r.api_results[0].success;
          apiMsg = r.api_results[0].message || '';
        }
        if (apiSuccess) {
          notify('success', 'Pesan WA sukses terkirim via Fonnte API ke ' + nama + ' (' + rawPhone + ')! Pesan telah masuk antrean pengiriman.');
        } else {
          notify('error', 'Gagal pengiriman via Fonnte API: ' + apiMsg);
        }
      } else {
        var phone = rawPhone.replace(/^0/, '62').replace(/[^0-9]/g, '');
        if (phone.substring(0, 2) !== '62') phone = '62' + phone;
        var sendMsg = customMsg;
        if (customFileUrl && sendMsg.indexOf(customFileUrl) === -1) {
          sendMsg += "\n\n[Lampiran File]: " + customFileUrl;
        }
        var wa_link = 'https://api.whatsapp.com/send?phone=' + phone + '&text=' + encodeURIComponent(sendMsg);
        window.open(wa_link, '_blank');
        notify('success', 'Membuka WhatsApp Web untuk ' + nama);
      }
    }).fail(function() {
      $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Kirim via WhatsApp');
      notify('error', 'Gagal mengirim pesan WA');
    });
  });

  // ===== Checkbox Select All =====
  $(document).on('change', '#check-all', function() {
    $('.cb-label').prop('checked', this.checked);
    updateBroadcastBtn();
  });
  $(document).on('click', '#btn-select-all', function() {
    $('.cb-label').prop('checked', true);
    updateBroadcastBtn();
  });
  $(document).on('change', '.cb-label', function() {
    updateBroadcastBtn();
  });

  function updateBroadcastBtn() {
    var count = $('.cb-label:checked').length;
    $('#btn-broadcast-selected').prop('disabled', count === 0)
      .html('<i class="fa fa-whatsapp"></i> Broadcast (' + count + ')');
  }

  // ===== Broadcast Selected =====
  $(document).on('click', '#btn-broadcast-selected', function() {
    var ids = [];
    $('.cb-label:checked').each(function() { ids.push($(this).val()); });
    if (ids.length === 0) return;

    if (typeof swal === 'function') {
      swal({
        title: 'Broadcast WA?',
        text: 'Kirim WA ke ' + ids.length + ' customer terpilih?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal'
      }, function(confirmed) {
        if (confirmed) doBroadcast(ids);
      });
    } else {
      if (confirm('Kirim WA ke ' + ids.length + ' customer terpilih?')) {
        doBroadcast(ids);
      }
    }
  });

  function doBroadcast(ids) {
    $.post(_BASE + 'administrator/crm/send_broadcast_ajax', buildPayload({ label_ids: ids }), function(res) {
      var r = parseRes(res);
      if (r.success) {
        if (r.mode === 'wa_gateway') {
          notify('success', 'Berhasil mengirim ' + r.count + ' pesan WA otomatis via Fonnte Gateway API!');
          setTimeout(function() { location.reload(); }, 1500);
        } else if (r.wa_links) {
          var delay = 0;
          $.each(r.wa_links, function(i, link) {
            setTimeout(function() { window.open(link.link, '_blank'); }, delay);
            delay += 2000;
          });
          notify('success', r.count + ' pesan WA berhasil dikirim!');
          setTimeout(function() { location.reload(); }, 3000);
        }
      }
    });
  }

  // ===== Open 2-Way Chat Modal =====
  var chatPollTimer = null;
  var currentChatLabelId = null;
  var lastMessageId = 0;
  var isFirstLoad = true;
  var isSendingChat = false;

  function loadChatTimeline(lid, showSpinner) {
    if (showSpinner) {
      $('#chat-canvas').html('<div class="chat-empty"><i class="fa fa-spinner fa-spin"></i> Memuat riwayat percakapan...</div>');
      lastMessageId = 0;
      isFirstLoad = true;
    }

    // First load: get full timeline from get_chat_timeline_ajax
    // Subsequent loads: use optimized get_new_messages_ajax with last_id
    if (isFirstLoad) {
      $.get(_BASE + 'administrator/crm/get_chat_timeline_ajax', { label_id: lid }, function(res) {
        var r = parseRes(res);
        if (r.success) {
          if (r.label) {
            $('#chat-phone').text(r.label.customer_phone || '-');
            $('#chat-order').text(r.label.no_pesanan || '-');
          }
          renderChatTimeline(r.timeline || []);
          // Track max ID from timeline for subsequent polling
          if (r.timeline && r.timeline.length > 0) {
            for (var i = 0; i < r.timeline.length; i++) {
              var tid = parseInt(r.timeline[i].id || 0);
              if (tid > lastMessageId) lastMessageId = tid;
            }
          }
          isFirstLoad = false;
        } else if (showSpinner) {
          $('#chat-canvas').html('<div class="chat-empty"><i class="fa fa-exclamation-circle"></i> Gagal memuat percakapan.</div>');
        }
      }).fail(function() {
        if (showSpinner) {
          $('#chat-canvas').html('<div class="chat-empty"><i class="fa fa-exclamation-circle"></i> Gagal menghubungi server.</div>');
        }
      });
    } else {
      // Optimized polling: only get new messages after lastMessageId
      $.get(_BASE + 'administrator/crm/get_new_messages_ajax', { label_id: lid, last_id: lastMessageId }, function(res) {
        var r = parseRes(res);
        if (r.success && r.messages && r.messages.length > 0) {
          appendNewMessages(r.messages);
          // Update lastMessageId
          for (var i = 0; i < r.messages.length; i++) {
            var mid = parseInt(r.messages[i].id || 0);
            if (mid > lastMessageId) lastMessageId = mid;
          }
        }
      });
    }
  }

  function startChatPolling(lid) {
    stopChatPolling();
    currentChatLabelId = lid;
    chatPollTimer = setInterval(function() {
      if (isSendingChat) return; // Skip polling while sending
      if ($('#modal-note').hasClass('in') || $('#modal-note').hasClass('show')) {
        loadChatTimeline(lid, false);
      } else {
        stopChatPolling();
      }
    }, 1500); // Auto-refresh setiap 1.5 detik
  }

  function stopChatPolling() {
    if (chatPollTimer) {
      clearInterval(chatPollTimer);
      chatPollTimer = null;
    }
  }

  $(document).on('click', '.btn-add-note', function() {
    var lid = $(this).attr('data-label-id');
    var nama = $(this).attr('data-nama');
    $('#note-label-id').val(lid);
    $('#note-customer-name').text(nama);
    $('#note-text').val('');
    $('#note-status').val('');
    
    // Reset toggle to Balasan CS (WA) mode
    $('#note-sender-type').val('cs_chat');
    $('.btn-toggle-sender').css({ border: '2px solid #e2e8f0', background: '#fff', color: '#64748b' }).removeClass('active');
    $('.btn-toggle-sender[data-type="cs_chat"]').css({ border: '2px solid #25D366', background: '#d9fdd3', color: '#15803d' }).addClass('active');
    $('#note-text').attr('placeholder', 'Ketik balasan CS ke WhatsApp customer...').css('background', '#fff');
    $('.btn-send-chat').css('background', '#25D366');

    loadChatTimeline(lid, true);
    startChatPolling(lid);

    $('.modal-backdrop').remove();
    $('#modal-note').modal('show');
    setTimeout(function() { $('#note-text').focus(); }, 300);
  });

  // Refresh button
  $(document).on('click', '#btn-refresh-chat', function() {
    var $icon = $(this).find('i');
    $icon.addClass('fa-spin');
    var lid = $('#note-label-id').val();
    isFirstLoad = true; // Force full reload
    loadChatTimeline(lid, false);
    setTimeout(function() { $icon.removeClass('fa-spin'); }, 1000);
  });

  // Stop polling when modal closes
  $(document).on('hidden.bs.modal', '#modal-note', function() {
    stopChatPolling();
  });

  function renderChatTimeline(timeline) {
    var canvas = $('#chat-canvas');
    if (!timeline || timeline.length === 0) {
      canvas.html('<div class="chat-empty"><i class="fa fa-comments-o"></i> Belum ada percakapan.<br><small style="color:#94a3b8;">Kirim pesan WhatsApp atau tulis catatan untuk memulai.</small></div>');
      return;
    }

    var html = '';
    var lastDate = '';
    $.each(timeline, function(i, item) {
      html += renderSingleBubble(item, lastDate);
      var itemDate = (item.created_at || '').substring(0, 10);
      if (itemDate) lastDate = itemDate;
    });

    canvas.html(html);
    // Scroll to bottom
    canvas.scrollTop(canvas[0].scrollHeight);
  }

  function appendNewMessages(messages) {
    var canvas = $('#chat-canvas');
    // If canvas shows empty state, clear it first
    if (canvas.find('.chat-empty').length) {
      canvas.html('');
    }

    var lastDateEl = canvas.find('[data-chat-date]:last');
    var lastDate = lastDateEl.length ? lastDateEl.data('chat-date') : '';

    var html = '';
    $.each(messages, function(i, item) {
      html += renderSingleBubble(item, lastDate);
      var itemDate = (item.created_at || '').substring(0, 10);
      if (itemDate) lastDate = itemDate;
    });

    if (html) {
      canvas.append(html);
      canvas.scrollTop(canvas[0].scrollHeight);
    }
  }

  function formatChatMessage(msg) {
    if (!msg) return '';
    var text = $('<div>').text(msg).html();
    
    // Pre-detect context labels before URL processing (for URLs without extensions)
    var contextType = '';
    if (/\[Foto\]/i.test(text)) contextType = 'image';
    else if (/\[Video\]/i.test(text)) contextType = 'video';
    else if (/\[Dokumen PDF\]/i.test(text)) contextType = 'pdf';
    else if (/\[Dokumen\]|\[Dokumen Arsip\]/i.test(text)) contextType = 'document';

    // Match URLs (https, http, and relative uploads paths)
    var urlRegex = /(https?:\/\/[^\s<]+|(?:\/|\b)uploads\/[^\s<]+)/gi;
    
    text = text.replace(urlRegex, function(url) {
      var cleanUrl = url.trim();
      // Detect by file extension first
      var isImg = /\.(jpeg|jpg|gif|png|webp|bmp|svg)(\?.*)?$/i.test(cleanUrl);
      var isVideo = /\.(mp4|avi|mov|mkv|3gp|webm)(\?.*)?$/i.test(cleanUrl);
      var isDoc = /\.(pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar|txt|csv|mp3|ogg|wav|m4a|aac)(\?.*)?$/i.test(cleanUrl);

      // Fallback: use context label if extension not detected (e.g. Fonnte storage URL)
      if (!isImg && !isVideo && !isDoc && contextType) {
        if (contextType === 'image') isImg = true;
        else if (contextType === 'video') isVideo = true;
        else if (contextType === 'pdf' || contextType === 'document') isDoc = true;
      }

      // Fallback 2: detect Fonnte/WA storage URL patterns
      if (!isImg && !isVideo && !isDoc) {
        if (/storage\.fonnte\.com/i.test(cleanUrl) || /mmg\.whatsapp\.net/i.test(cleanUrl)) {
          isImg = true;
        }
      }

      var fullUrl = cleanUrl;
      if (fullUrl.indexOf('http') !== 0) {
        fullUrl = _BASE + fullUrl.replace(/^\//, '');
      }

      if (isVideo) {
        var cleanFileName = cleanUrl.split('/').pop().split('?')[0] || 'Video WhatsApp';
        return '<div class="chat-media-card" style="margin-top:6px;max-width:280px;background:rgba(0,0,0,0.03);border:1px solid rgba(0,0,0,0.08);border-radius:12px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.08);">' +
                 '<video controls preload="metadata" style="max-width:100%;max-height:220px;display:block;background:#000;">' +
                   '<source src="' + fullUrl + '" type="video/mp4">' +
                   '<source src="' + fullUrl + '" type="video/webm">' +
                   'Browser tidak mendukung video.' +
                 '</video>' +
                 '<div style="padding:6px 10px;background:#ffffff;display:flex;align-items:center;justify-content:space-between;gap:6px;border-top:1px solid rgba(0,0,0,0.06);">' +
                   '<button type="button" class="btn-open-preview" data-media-url="' + fullUrl + '" data-media-type="video" data-media-title="' + htmlEntities(cleanFileName) + '" style="background:#7c3aed;color:#ffffff;border:none;border-radius:6px;padding:3px 8px;font-size:11px;font-weight:700;display:inline-flex;align-items:center;gap:4px;cursor:pointer;">' +
                     '<i class="fa fa-arrows-alt"></i> Pratinjau' +
                   '</button>' +
                   '<a href="' + fullUrl + '" target="_blank" download style="color:#64748b;font-size:13px;padding:3px 6px;text-decoration:none;" title="Unduh Video">' +
                     '<i class="fa fa-download"></i>' +
                   '</a>' +
                 '</div>' +
               '</div>';
      } else if (isAudio) {
        var cleanFileName = cleanUrl.split('/').pop().split('?')[0] || 'Voice Note';
        return '<div class="chat-audio-card" style="margin-top:6px;max-width:280px;background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:8px 12px;box-shadow:0 2px 6px rgba(0,0,0,0.06);">' +
                 '<div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">' +
                   '<div style="width:26px;height:26px;border-radius:50%;background:#d1fae5;color:#059669;display:flex;align-items:center;justify-content:center;font-size:12px;"><i class="fa fa-microphone"></i></div>' +
                   '<div style="font-size:11.5px;font-weight:700;color:#1e293b;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;flex:1;">' + htmlEntities(cleanFileName) + '</div>' +
                 '</div>' +
                 '<audio controls preload="metadata" style="max-width:100%;width:100%;height:36px;display:block;">' +
                   '<source src="' + fullUrl + '">' +
                 '</audio>' +
                 '<div style="display:flex;justify-content:flex-end;margin-top:4px;">' +
                   '<a href="' + fullUrl + '" target="_blank" download style="font-size:10.5px;color:#059669;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:3px;"><i class="fa fa-download"></i> Unduh Suara</a>' +
                 '</div>' +
               '</div>';
      } else if (isImg) {
        var cleanFileName = cleanUrl.split('/').pop().split('?')[0] || 'Foto WhatsApp';
        return '<div class="chat-media-card" style="margin-top:6px;max-width:260px;background:#ffffff;border:1px solid rgba(0,0,0,0.08);border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">' +
                 '<div class="chat-media-clickable" data-media-url="' + fullUrl + '" data-media-type="image" data-media-title="' + htmlEntities(cleanFileName) + '" style="cursor:pointer;position:relative;background:#f1f5f9;display:block;text-align:center;">' +
                   '<img src="' + fullUrl + '" alt="Foto" style="width:100%;max-height:220px;object-fit:cover;display:block;transition:transform 0.2s;" onerror="this.onerror=null;this.parentElement.style.display=\'none\';this.parentElement.nextElementSibling.style.display=\'block\';">' +
                   '<div class="chat-img-hover-overlay" style="position:absolute;inset:0;background:rgba(15,23,42,0.38);opacity:0;transition:opacity 0.2s;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:12px;gap:6px;">' +
                     '<i class="fa fa-search-plus" style="font-size:16px;"></i> Pratinjau Foto' +
                   '</div>' +
                 '</div>' +
                 '<div style="padding:6px 10px;background:#ffffff;display:flex;align-items:center;justify-content:space-between;gap:6px;border-top:1px solid rgba(0,0,0,0.06);">' +
                   '<button type="button" class="btn-open-preview" data-media-url="' + fullUrl + '" data-media-type="image" data-media-title="' + htmlEntities(cleanFileName) + '" style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;border-radius:6px;padding:3px 8px;font-size:11px;font-weight:700;display:inline-flex;align-items:center;gap:4px;cursor:pointer;">' +
                     '<i class="fa fa-eye"></i> Pratinjau' +
                   '</button>' +
                   '<a href="' + fullUrl + '" target="_blank" download style="color:#64748b;font-size:13px;padding:3px 6px;text-decoration:none;" title="Unduh Foto">' +
                     '<i class="fa fa-download"></i>' +
                   '</a>' +
                 '</div>' +
               '</div>';
      } else if (isDoc) {
        var cleanFileName = cleanUrl.split('/').pop().split('?')[0] || 'Dokumen';
        var isPdf = /\.pdf/i.test(cleanUrl);
        var isWord = /\.(doc|docx)/i.test(cleanUrl);
        var isExcel = /\.(xls|xlsx|csv)/i.test(cleanUrl);
        var isPpt = /\.(ppt|pptx)/i.test(cleanUrl);
        var isZip = /\.(zip|rar|7z|tar|gz)/i.test(cleanUrl);

        var docIcon = 'fa-file-text-o';
        var docColor = '#0284c7';
        var docBg = '#e0f2fe';
        var docBadge = 'DOKUMEN';
        var previewBtnText = 'Pratinjau';
        var previewType = 'generic';

        if (isPdf) {
          docIcon = 'fa-file-pdf-o';
          docColor = '#dc2626';
          docBg = '#fee2e2';
          docBadge = 'PDF';
          previewBtnText = 'Pratinjau PDF';
          previewType = 'pdf';
        } else if (isWord) {
          docIcon = 'fa-file-word-o';
          docColor = '#2563eb';
          docBg = '#dbeafe';
          docBadge = 'WORD';
          previewType = 'office';
        } else if (isExcel) {
          docIcon = 'fa-file-excel-o';
          docColor = '#059669';
          docBg = '#d1fae5';
          docBadge = 'EXCEL';
          previewType = 'office';
        } else if (isPpt) {
          docIcon = 'fa-file-powerpoint-o';
          docColor = '#d97706';
          docBg = '#fef3c7';
          docBadge = 'POWERPOINT';
          previewType = 'office';
        } else if (isZip) {
          docIcon = 'fa-file-archive-o';
          docColor = '#7c3aed';
          docBg = '#ede9fe';
          docBadge = 'ZIP ARSIP';
          previewType = 'generic';
        }

        return '<div class="chat-doc-card" style="margin-top:6px;max-width:280px;background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.06);">' +
                 '<div style="padding:10px 12px;display:flex;align-items:center;gap:10px;">' +
                   '<div style="width:42px;height:42px;border-radius:10px;background:' + docBg + ';color:' + docColor + ';display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">' +
                     '<i class="fa ' + docIcon + '"></i>' +
                   '</div>' +
                   '<div style="flex:1;min-width:0;">' +
                     '<div style="font-weight:700;font-size:12px;color:#1e293b;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="' + htmlEntities(cleanFileName) + '">' + htmlEntities(cleanFileName) + '</div>' +
                     '<span style="display:inline-block;font-size:9.5px;font-weight:800;color:' + docColor + ';background:' + docBg + ';padding:1px 6px;border-radius:4px;margin-top:2px;">' + docBadge + '</span>' +
                   '</div>' +
                 '</div>' +
                 '<div style="padding:6px 10px;background:#f8fafc;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;gap:6px;">' +
                   '<button type="button" class="btn-open-preview" data-media-url="' + fullUrl + '" data-media-type="' + previewType + '" data-media-title="' + htmlEntities(cleanFileName) + '" style="flex:1;background:' + docColor + ';color:#ffffff;border:none;border-radius:6px;padding:4px 8px;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;gap:4px;cursor:pointer;">' +
                     '<i class="fa fa-eye"></i> ' + previewBtnText +
                   '</button>' +
                   '<a href="' + fullUrl + '" target="_blank" download style="display:inline-flex;align-items:center;justify-content:center;padding:4px 10px;background:#ffffff;border:1px solid #cbd5e1;color:#475569;border-radius:6px;font-size:11px;font-weight:700;text-decoration:none;" title="Unduh Dokumen">' +
                     '<i class="fa fa-download"></i> Unduh' +
                   '</a>' +
                 '</div>' +
               '</div>';
      } else {
        return '<a href="' + fullUrl + '" target="_blank" style="color:#2563eb;text-decoration:underline;word-break:break-all;"><i class="fa fa-external-link"></i> ' + cleanUrl + '</a>';
      }
    });

    // Remove all media label tags after URL rendering (clean display)
    text = text.replace(/\[Lampiran Media\/Dokumen\]:\s*/gi, '');
    text = text.replace(/\[Lampiran File\]:\s*/gi, '');
    text = text.replace(/\[Foto\]:\s*/gi, '');
    text = text.replace(/\[Video\]:\s*/gi, '');
    text = text.replace(/\[Voice Note\]:\s*/gi, '');
    text = text.replace(/\[Pesan Suara\]:\s*/gi, '');
    text = text.replace(/\[Dokumen PDF\]:\s*/gi, '');
    text = text.replace(/\[Dokumen\]:\s*/gi, '');
    text = text.replace(/\[Dokumen Arsip\]:\s*/gi, '');

    // Render WhatsApp quote blocks
    text = text.replace(/(?:^|<br>)(?:&gt;|>)\s*\*Membalas ([^*]+)\*:\s*(?:&quot;|")([^"\n<]+)(?:&quot;|")(?:\s*<br>|\s*\n)?/gi, function(m, qSender, qText) {
      return '<div style="background:rgba(0,168,132,0.12);border-left:3.5px solid #00a884;padding:4px 8px;border-radius:6px;font-size:11px;margin-bottom:6px;color:#1e293b;">' +
               '<div style="font-weight:700;color:#00a884;font-size:10.5px;"><i class="fa fa-reply"></i> Membalas ' + $('<div>').text(qSender).html() + '</div>' +
               '<div style="color:#475569;font-size:10.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:240px;">' + $('<div>').text(qText).html() + '</div>' +
             '</div>';
    });

    return text.replace(/\n/g, '<br>');
  }

  function renderSingleBubble(item, lastDate) {
    // Skip duplicate echo bubbles of outgoing messages sent via Fonnte
    if (item.direction === 'incoming' && item.message && (item.message.indexOf('Sent via fonnte.com') !== -1 || item.message.indexOf('fonnte.com') !== -1)) {
      return '';
    }

    var html = '';
    // Date separator
    var itemDate = (item.created_at || '').substring(0, 10);
    if (itemDate && itemDate !== lastDate) {
      var d = new Date(itemDate + 'T00:00:00');
      var today = new Date(); today.setHours(0,0,0,0);
      var dateLabel = '';
      if (d.getTime() === today.getTime()) {
        dateLabel = 'Hari Ini';
      } else {
        var dd = ('0' + d.getDate()).slice(-2);
        var mm = ('0' + (d.getMonth()+1)).slice(-2);
        dateLabel = dd + '/' + mm + '/' + d.getFullYear();
      }
      html += '<div style="text-align:center;margin:12px 0 8px;" data-chat-date="' + itemDate + '"><span style="background:rgba(255,255,255,0.85);padding:3px 14px;border-radius:8px;font-size:11px;color:#64748b;box-shadow:0 1px 2px rgba(0,0,0,0.06);font-weight:600;">' + dateLabel + '</span></div>';
    }

    var formattedMsg = formatChatMessage(item.message || '');
    var timeStr = (item.created_at || '').substring(11, 16);
    var statusIcon = '';
    var rawMsg = $('<div>').text(item.message || '').html();

    if (item.direction === 'outgoing') {
      // CS sent → right (green bubble)
      var csSender = item.sender || 'CS Admin';

      // Status icon for sent/failed
      if (item.status_kirim === 'failed') {
        statusIcon = '<i class="fa fa-exclamation-circle" style="color:#ef4444;font-size:10px;" title="Gagal terkirim"></i>';
      } else {
        statusIcon = '<i class="fa fa-check-circle" style="color:#34d399;font-size:10px;"></i>';
      }

      html += '<div class="chat-bubble bubble-outgoing" style="position:relative;">';
      html += '<div class="bubble-sender-head" style="font-size:11px;font-weight:700;color:#075e54;margin-bottom:3px;display:flex;align-items:center;justify-content:space-between;">' +
                '<span><i class="fa fa-user-circle"></i> ' + $('<div>').text(csSender).html() + '</span>' +
                '<button type="button" class="btn-reply-msg" data-sender="' + $('<div>').text(csSender).html() + '" data-msg="' + rawMsg + '" style="background:none;border:none;color:#047857;font-size:10px;font-weight:700;cursor:pointer;padding:0 2px;" title="Balas pesan ini"><i class="fa fa-reply"></i> Balas</button>' +
              '</div>';
      html += '<div>' + formattedMsg + '</div>';

      // Show error message if failed
      if (item.status_kirim === 'failed') {
        html += '<div style="font-size:10px;color:#ef4444;margin-top:4px;padding:3px 6px;background:#fef2f2;border-radius:4px;border:1px solid #fecaca;"><i class="fa fa-warning"></i> Gagal terkirim via Fonnte API</div>';
      }

      html += '<div class="bubble-time">';
      if (item.metode_kirim) html += '<span style="font-size:9px;color:#64748b;font-weight:600;">(' + $('<div>').text(item.metode_kirim).html() + ')</span> ';
      html += timeStr + ' ' + statusIcon;
      html += '</div></div>';

    } else if (item.direction === 'incoming') {
      // Customer reply → left (clean WhatsApp style white bubble)
      var custSender = item.sender || 'Pelanggan';
      html += '<div class="chat-bubble bubble-incoming" style="position:relative;">';
      html += '<div class="bubble-sender-head" style="font-size:11px;font-weight:700;color:#15803d;margin-bottom:3px;display:flex;align-items:center;justify-content:space-between;">' +
                '<span><i class="fa fa-whatsapp" style="color:#25D366;"></i> ' + $('<div>').text(custSender).html() + '</span>' +
                '<button type="button" class="btn-reply-msg" data-sender="' + $('<div>').text(custSender).html() + '" data-msg="' + rawMsg + '" style="background:none;border:none;color:#166534;font-size:10px;font-weight:700;cursor:pointer;padding:0 2px;" title="Balas pesan ini"><i class="fa fa-reply"></i> Balas</button>' +
              '</div>';
      html += '<div>' + formattedMsg + '</div>';
      html += '<div class="bubble-time">' + timeStr + '</div>';
      html += '</div>';

    } else {
      // Internal note → center (amber)
      var noteSender = item.sender || 'CS Admin';
      html += '<div class="chat-bubble bubble-note" style="position:relative;">';
      html += '<div class="bubble-sender" style="font-weight:700;color:#92400e;margin-bottom:3px;display:flex;align-items:center;justify-content:space-between;">' +
                '<span><i class="fa fa-bookmark"></i> Catatan Internal (' + $('<div>').text(noteSender).html() + ')</span>' +
                '<button type="button" class="btn-reply-msg" data-sender="' + $('<div>').text(noteSender).html() + '" data-msg="' + rawMsg + '" style="background:none;border:none;color:#b45309;font-size:10px;font-weight:700;cursor:pointer;padding:0 2px;" title="Balas pesan ini"><i class="fa fa-reply"></i> Balas</button>' +
              '</div>';
      if (item.status_kirim && item.status_kirim !== 'delivered') html += '<div style="font-size:10px;margin-bottom:2px;"><span style="background:#f59e0b;color:#fff;padding:1px 6px;border-radius:4px;font-size:9px;">' + $('<div>').text(item.status_kirim).html() + '</span></div>';
      html += '<div>' + formattedMsg + '</div>';
      html += '<div class="bubble-time" style="justify-content:center;color:#b45309;">' + timeStr + '</div>';
      html += '</div>';
    }

    return html;
  }

  // ===== WhatsApp Input Bar Events =====
  
  // Toggle Attachment Popover Menu
  $(document).on('click', '#btn-toggle-attach', function(e) {
    e.stopPropagation();
    $('#wa-emoji-popover').hide();
    $('#wa-attach-popover').fadeToggle(150);
  });

  $(document).on('click', '#btn-close-attach-pop', function() {
    $('#wa-attach-popover').fadeOut(100);
  });

  // Toggle Emoji Popover
  $(document).on('click', '#btn-toggle-emoji', function(e) {
    e.stopPropagation();
    $('#wa-attach-popover').hide();
    $('#wa-emoji-popover').fadeToggle(150);
  });

  $(document).on('click', '#btn-close-emoji', function() {
    $('#wa-emoji-popover').fadeOut(100);
  });

  // Emoji Click Handler
  $(document).on('click', '.wa-emoji-item', function() {
    var emoji = $(this).text();
    var $txt = $('#note-text');
    var val = $txt.val();
    $txt.val(val + emoji).focus();
  });

  // Close popovers on click outside
  $(document).on('click', function(e) {
    if (!$(e.target).closest('#wa-attach-popover, #btn-toggle-attach').length) {
      $('#wa-attach-popover').fadeOut(100);
    }
    if (!$(e.target).closest('#wa-emoji-popover, #btn-toggle-emoji').length) {
      $('#wa-emoji-popover').fadeOut(100);
    }
  });

  // Attachment Menu Options -> Trigger File Upload Input
  $(document).on('click', '#wa-opt-doc', function() {
    $('#wa-attach-popover').hide();
    $('#chat-file-upload').attr('accept', '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.txt,.csv').click();
  });

  $(document).on('click', '#wa-opt-img', function() {
    $('#wa-attach-popover').hide();
    $('#chat-file-upload').attr('accept', 'image/*').click();
  });

  $(document).on('click', '#wa-opt-audio', function() {
    $('#wa-attach-popover').hide();
    $('#chat-file-upload').attr('accept', 'audio/*,.mp3,.ogg,.wav,.m4a,.aac,.opus').click();
  });

  $(document).on('click', '#wa-opt-url', function() {
    $('#wa-attach-popover').hide();
    $('#wa-url-input-container').slideDown(150);
    setTimeout(function() { $('#note-file-url').focus(); }, 200);
  });

  $(document).on('click', '#btn-close-url-input', function() {
    $('#wa-url-input-container').slideUp(150);
  });

  // When URL input changes manually
  $(document).on('input change', '#note-file-url', function() {
    var url = $.trim($(this).val());
    if (url) {
      var fname = url.substring(url.lastIndexOf('/') + 1) || 'Link File';
      $('#wa-attach-filename').text(fname + ' (' + url + ')');
      $('#wa-attachment-chip').css('display', 'flex');
    } else {
      $('#wa-attachment-chip').hide();
    }
  });

  // Handle Native Local File Upload Selection
  $(document).on('change', '#chat-file-upload', function() {
    var file = this.files[0];
    if (!file) return;

    $('#wa-attach-filename').text(file.name);
    $('#wa-upload-spinner').show();
    $('#wa-attachment-chip').css('display', 'flex');

    var formData = new FormData();
    formData.append('file', file);
    if (csrf_name && csrf_hash) formData.append(csrf_name, csrf_hash);

    $.ajax({
      url: _BASE + 'administrator/crm/upload_attachment_ajax',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(res) {
        var r = parseRes(res);
        $('#wa-upload-spinner').hide();
        if (r.success && r.file_url) {
          $('#note-file-url').val(r.file_url);
          $('#wa-attach-filename').html('<i class="fa fa-check-circle" style="color:#10b981;"></i> ' + (r.file_name || file.name));
          notify('success', 'File berhasil diunggah dan siap dikirim!');
        } else {
          $('#wa-attachment-chip').hide();
          notify('error', r.message || 'Gagal mengunggah file');
        }
      },
      error: function() {
        $('#wa-upload-spinner').hide();
        $('#wa-attachment-chip').hide();
        notify('error', 'Gagal mengunggah file ke server');
      }
    });

    $(this).val(''); // Reset file input
  });

  // Remove Attachment
  $(document).on('click', '#btn-remove-attachment', function() {
    $('#note-file-url').val('');
    $('#wa-attachment-chip').hide();
  });

  // Dedicated Mic Recording Button Click Handler
  $(document).on('click', '#btn-start-mic-rec', function(e) {
    e.preventDefault();
    startMicRecording();
  });

  // ===== Sender Type Toggle (CS WA Reply vs Internal Note) =====
  $(document).on('click', '.btn-toggle-sender', function() {
    var type = $(this).data('type');
    $('#note-sender-type').val(type);
    
    $('.btn-toggle-sender').css({ border: '2px solid #e2e8f0', background: '#fff', color: '#64748b' }).removeClass('active');
    $(this).addClass('active');

    if (type === 'cs_chat') {
      $(this).css({ border: '2px solid #00a884', background: '#d9fdd3', color: '#005c4b' });
      $('#note-text').attr('placeholder', 'Ketik pesan...').css('background', '#fff');
      $('.wa-send-btn').css('background', '#00a884');
    } else { // cs note
      $(this).css({ border: '2px solid #f59e0b', background: '#fef3c7', color: '#92400e' });
      $('#note-text').attr('placeholder', 'Tulis catatan internal CS (hanya tersimpan di sistem)...').css('background', '#fffbe6');
      $('.wa-send-btn').css('background', '#f59e0b');
    }
  });

  // Enter key to send (Shift+Enter for newline)
  $(document).on('keydown', '#note-text', function(e) {
    if (e.keyCode === 13 && !e.shiftKey) {
      e.preventDefault();
      $('#btn-save-note').trigger('click');
    }
  });

  // ===== In-Browser Microphone Voice Recording (Web MediaRecorder API) =====
  var mediaRecorder = null;
  var audioChunks = [];
  var recTimerInterval = null;
  var recSeconds = 0;

  function dateStr() {
    var dt = new Date();
    return dt.getFullYear() + ('0' + (dt.getMonth()+1)).slice(-2) + ('0' + dt.getDate()).slice(-2) + '_' + ('0' + dt.getHours()).slice(-2) + ('0' + dt.getMinutes()).slice(-2) + ('0' + dt.getSeconds()).slice(-2);
  }

  function startMicRecording() {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
      $('#chat-file-upload').attr('accept', 'audio/*,.mp3,.ogg,.wav,.m4a,.aac,.opus,.webm').click();
      return;
    }

    navigator.mediaDevices.getUserMedia({ audio: true }).then(function(stream) {
      audioChunks = [];
      var mimeType = 'audio/webm';
      if (!MediaRecorder.isTypeSupported('audio/webm')) {
        if (MediaRecorder.isTypeSupported('audio/ogg')) mimeType = 'audio/ogg';
        else if (MediaRecorder.isTypeSupported('audio/mp4')) mimeType = 'audio/mp4';
        else mimeType = '';
      }

      try {
        mediaRecorder = mimeType ? new MediaRecorder(stream, { mimeType: mimeType }) : new MediaRecorder(stream);
      } catch(e) {
        mediaRecorder = new MediaRecorder(stream);
      }

      mediaRecorder.ondataavailable = function(e) {
        if (e.data && e.data.size > 0) {
          audioChunks.push(e.data);
        }
      };

      mediaRecorder.start(100);

      recSeconds = 0;
      $('#wa-rec-timer').text('00:00');
      $('#wa-mic-recording-bar').css('display', 'flex');
      $('.wa-input-pill-container').slideUp(150);

      recTimerInterval = setInterval(function() {
        recSeconds++;
        var m = ('0' + Math.floor(recSeconds / 60)).slice(-2);
        var s = ('0' + (recSeconds % 60)).slice(-2);
        $('#wa-rec-timer').text(m + ':' + s);
      }, 1000);

    }).catch(function(err) {
      notify('info', 'Izin mikrofon tidak diberikan. Membuka pemilih berkas audio...');
      $('#chat-file-upload').attr('accept', 'audio/*,.mp3,.ogg,.wav,.m4a,.aac,.opus,.webm').click();
    });
  }

  function stopAndSendMicRecording() {
    if (!mediaRecorder || mediaRecorder.state === 'inactive') return;

    clearInterval(recTimerInterval);
    recTimerInterval = null;

    mediaRecorder.onstop = function() {
      if (mediaRecorder.stream) {
        mediaRecorder.stream.getTracks().forEach(function(track) { track.stop(); });
      }

      var blobType = mediaRecorder.mimeType || 'audio/webm';
      var audioBlob = new Blob(audioChunks, { type: blobType });
      var ext = 'webm';
      if (blobType.indexOf('ogg') !== -1) ext = 'ogg';
      else if (blobType.indexOf('mp4') !== -1 || blobType.indexOf('m4a') !== -1) ext = 'm4a';
      else if (blobType.indexOf('wav') !== -1) ext = 'wav';

      var filename = 'voice_rec_' + dateStr() + '.' + ext;
      var file = new File([audioBlob], filename, { type: blobType });

      notify('info', 'Mengunggah pesan suara...');
      var formData = new FormData();
      formData.append('file', file);
      if (csrf_name && csrf_hash) formData.append(csrf_name, csrf_hash);

      $.ajax({
        url: _BASE + 'administrator/crm/upload_attachment_ajax',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(res) {
          var r = parseRes(res);
          if (r.success && r.file_url) {
            var lid = $('#note-label-id').val();
            var status = $('#note-status').val();
            var senderType = $('#note-sender-type').val() || 'cs_chat';
            var isInternalNote = (senderType === 'cs') ? 1 : 0;

            $.ajax({
              url: _BASE + 'administrator/crm/send_message_ajax',
              type: 'POST',
              data: buildPayload({
                label_id: lid,
                message: '[Pesan Suara]: ' + r.file_url,
                file_url: r.file_url,
                is_internal_note: isInternalNote
              }),
              success: function(sres) {
                var sr = parseRes(sres);
                if (sr.success) {
                  notify('success', 'Pesan suara berhasil dikirim!');
                  isFirstLoad = true;
                  loadChatTimeline(lid, false);
                } else {
                  notify('error', sr.message || 'Gagal mengirim pesan suara');
                }
              }
            });
          } else {
            notify('error', r.message || 'Gagal mengunggah pesan suara');
          }
        },
        error: function() {
          notify('error', 'Gagal mengunggah rekaman suara');
        },
        complete: function() {
          $('#wa-mic-recording-bar').hide();
          $('.wa-input-pill-container').slideDown(150);
        }
      });
    };

    mediaRecorder.stop();
  }

  function cancelMicRecording() {
    if (mediaRecorder && mediaRecorder.state !== 'inactive') {
      mediaRecorder.onstop = function() {
        if (mediaRecorder.stream) {
          mediaRecorder.stream.getTracks().forEach(function(track) { track.stop(); });
        }
      };
      mediaRecorder.stop();
    }
    clearInterval(recTimerInterval);
    recTimerInterval = null;
    audioChunks = [];
    $('#wa-mic-recording-bar').hide();
    $('.wa-input-pill-container').slideDown(150);
    notify('info', 'Perekaman suara dibatalkan');
  }

  $(document).on('click', '#btn-cancel-recording', function() {
    cancelMicRecording();
  });

  $(document).on('click', '#btn-stop-send-recording', function() {
    stopAndSendMicRecording();
  });

  // ===== Save Note / Chat Message (via send_message_ajax) =====
  $(document).on('click', '#btn-save-note', function(e) {
    e.preventDefault();
    e.stopPropagation();

    var $btn = $(this);
    if ($btn.prop('disabled') || $btn.hasClass('is-sending')) {
      return false;
    }

    var lid = $('#note-label-id').val();
    var catatan = $.trim($('#note-text').val());
    var fileUrl = $.trim($('#note-file-url').val());
    var status = $('#note-status').val();
    var senderType = $('#note-sender-type').val() || 'cs_chat';
    
    if (!catatan && !fileUrl && !status) { 
      notify('warning', 'Ketik pesan, pilih lampiran file, atau pilih status terlebih dahulu');
      return; 
    }

    // If only status change (no message/file), use the old update_status_ajax
    if (!catatan && !fileUrl && status) {
      $btn.prop('disabled', true).addClass('is-sending');
      $.post(_BASE + 'administrator/crm/update_status_ajax', buildPayload({
        label_id: lid,
        status: status
      }), function(res) {
        var r = parseRes(res);
        if (r.success) {
          notify('success', 'Status berhasil diperbarui');
          if (status) {
            var $inlineSel = $('.status-select[data-label-id="' + lid + '"]');
            if ($inlineSel.length) $inlineSel.val(status).data('current', status);
            updateBadgeRealtime(lid, status);
          }
          $('#note-status').val('');
        } else {
          notify('error', r.message || 'Gagal memperbarui status');
        }
      }).always(function() {
        $btn.prop('disabled', false).removeClass('is-sending');
      });
      return;
    }

    var replySender = $('#wa-reply-preview-bar').is(':visible') ? $.trim($('#wa-reply-sender-name').text()) : '';
    var replyText = $('#wa-reply-preview-bar').is(':visible') ? $.trim($('#wa-reply-text-preview').text()) : '';

    if (replySender && replyText && catatan) {
      catatan = '> *Membalas ' + replySender + '*: "' + replyText + '"\n\n' + catatan;
    }

    var isInternalNote = (senderType === 'cs') ? 1 : 0;

    $btn.prop('disabled', true).addClass('is-sending').html('<i class="fa fa-spin fa-spinner"></i>');
    isSendingChat = true;

    // Use the send_message_ajax endpoint with optional file_url
    $.ajax({
      url: _BASE + 'administrator/crm/send_message_ajax',
      type: 'POST',
      data: buildPayload({
        label_id: lid,
        message: catatan,
        file_url: fileUrl,
        is_internal_note: isInternalNote
      }),
      success: function(res) {
        var r = parseRes(res);
        $btn.prop('disabled', false).html('<i class="fa fa-paper-plane" id="wa-send-icon"></i>');
        if (r.success) {
          // Hide reply preview bar
          $('#wa-reply-preview-bar').slideUp(100);
          $('#wa-reply-sender-name').text('');
          $('#wa-reply-text-preview').text('');

          // Show appropriate notification
          if (r.send_error) {
            notify('warning', r.message);
          } else {
            notify('success', r.message || 'Pesan berhasil dikirim');
          }

          // Update status if needed
          if (status) {
            var $inlineSel = $('.status-select[data-label-id="' + lid + '"]');
            if ($inlineSel.length) $inlineSel.val(status).data('current', status);
            updateBadgeRealtime(lid, status);
          } else if (!isInternalNote) {
            var $inlineSel = $('.status-select[data-label-id="' + lid + '"]');
            if ($inlineSel.length && $inlineSel.val() === 'Pending') {
              $inlineSel.val('Sudah Dikirim').data('current', 'Sudah Dikirim');
              updateBadgeRealtime(lid, 'Sudah Dikirim');
            }
          }

          // Update badge count
          if (!isInternalNote) {
            var $cntBadge = $('#badge-count-' + lid);
            var currCnt = parseInt($cntBadge.attr('data-count') || 0) + 1;
            $cntBadge.attr('data-count', currCnt).find('.cnt-val').text(currCnt);
            $cntBadge.css('display', 'inline-block');
          }

          // Open wa_link if wa_direct mode
          if (r.wa_link && !isInternalNote) {
            window.open(r.wa_link, '_blank');
          }

          // Clear inputs and reload chat
          $('#note-text').val('');
          $('#note-file-url').val('');
          $('#wa-attachment-chip').hide();
          $('#wa-url-input-container').slideUp(150);
          $('#note-status').val('');

          // Force a full timeline reload to show the new message immediately
          isFirstLoad = true;
          loadChatTimeline(lid, false);
        } else {
          notify('error', r.message || 'Gagal menyimpan');
        }
      },
      error: function(xhr) {
        notify('error', 'Terjadi kesalahan: ' + (xhr.statusText || 'Error'));
      },
      complete: function() {
        isSendingChat = false;
        $btn.prop('disabled', false).removeClass('is-sending').html('<i class="fa fa-paper-plane" id="wa-send-icon"></i>');
      }
    });
  });

  // Auto-open chat modal if label_id URL query parameter is present (from notification click)
  var urlParams = new URLSearchParams(window.location.search);
  var targetLabelId = urlParams.get('label_id');
  if (targetLabelId) {
    var $btnTarget = $('.btn-add-note[data-label-id="' + targetLabelId + '"]');
    if ($btnTarget.length) {
      setTimeout(function() { $btnTarget.trigger('click'); }, 300);
    } else {
      $.get(_BASE + 'administrator/crm/get_wa_link_ajax', { label_id: targetLabelId }, function(res) {
        var r = parseRes(res);
        if (r.success) {
          $('#note-label-id').val(targetLabelId);
          $('#note-customer-name').text(r.nama || 'Customer');
          $('#chat-phone').text(r.phone || '-');
          $('#chat-order').text(r.no_pesanan || '-');
          loadChatTimeline(targetLabelId, true);
          startChatPolling(targetLabelId);
          $('.modal-backdrop').remove();
          $('#modal-note').modal('show');
        }
      });
    }
  }

  // ===== Reply Message Event Handlers =====
  $(document).on('click', '.btn-reply-msg', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var sender = $(this).attr('data-sender') || 'Pesan';
    var rawMsg = $(this).attr('data-msg') || '';
    
    // Clean rawMsg for quote preview
    var cleanMsg = rawMsg.replace(/\[Lampiran[^\]]+\]:\s*/gi, '').replace(/https?:\/\/[^\s]+/gi, '[Lampiran File]').trim();
    if (cleanMsg.length > 70) cleanMsg = cleanMsg.substring(0, 70) + '...';
    if (!cleanMsg) cleanMsg = '[Lampiran File]';

    $('#wa-reply-sender-name').text(sender);
    $('#wa-reply-text-preview').text(cleanMsg);
    $('#wa-reply-preview-bar').slideDown(150);

    $('#note-text').focus();
  });

  $(document).on('click', '#btn-cancel-reply', function() {
    $('#wa-reply-preview-bar').slideUp(100);
    $('#wa-reply-sender-name').text('');
    $('#wa-reply-text-preview').text('');
  });

  // ===== Manual Follow-Up Add Event Handlers =====
  $(document).on('click', '#btn-open-manual-add', function() {
    $('.modal-backdrop').remove();
    $('#modal-manual-add').modal('show');
  });

  $(document).on('submit', '#form-manual-add', function(e) {
    e.preventDefault();
    var $btn = $('#btn-submit-manual-add');
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    $.ajax({
      url: _BASE + 'administrator/crm/add_manual_label_ajax',
      type: 'POST',
      data: buildPayload($(this).serialize()),
      success: function(res) {
        var r = parseRes(res);
        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Follow-Up');
        if (r.success) {
          notify('success', r.message || 'Data follow-up manual berhasil ditambahkan!');
          $('#modal-manual-add').modal('hide');
          $('#form-manual-add')[0].reset();
          setTimeout(function() { location.reload(); }, 1200);
        } else {
          notify('error', r.message || 'Gagal menambahkan data');
        }
      },
      error: function(xhr) {
        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Follow-Up');
        notify('error', 'Terjadi kesalahan: ' + (xhr.statusText || 'Error'));
      }
    });
  });

  /* ========================================================
     UNIVERSAL MEDIA LIGHTBOX VIEWER (Foto & Dokumen)
     ======================================================== */
  var currentScale = 1;
  var currentRotate = 0;

  function openMediaPreview(url, type, title) {
    if (!url) return;
    title = title || url.split('/').pop().split('?')[0] || 'Media Preview';

    $('#lightbox-filename').text(title);
    $('#btn-lightbox-open-tab').attr('href', url);
    $('#btn-lightbox-download').attr('href', url).attr('download', title);
    $('#lightbox-generic-download').attr('href', url).attr('download', title);

    // Reset displays
    $('#lightbox-img-container').hide();
    $('#lightbox-doc-container').hide();
    $('#lightbox-video-container').hide();
    $('#lightbox-audio-container').hide();
    $('#lightbox-generic-container').hide();
    $('#lightbox-img-tools').hide();
    $('#lightbox-loading').hide();

    // Stop previous media
    var videoEl = document.getElementById('lightbox-video');
    if (videoEl) { videoEl.pause(); videoEl.src = ''; }
    var audioEl = document.getElementById('lightbox-audio');
    if (audioEl) { audioEl.pause(); audioEl.src = ''; }
    var iframeEl = document.getElementById('lightbox-iframe');
    if (iframeEl) { iframeEl.src = ''; }

    // Auto-detect type
    if (!type || type === 'auto') {
      if (/\.(jpeg|jpg|png|webp|gif|bmp|svg)(\?.*)?$/i.test(url) || url.indexOf('data:image/') === 0) type = 'image';
      else if (/\.(mp4|webm|avi|mov|3gp)(\?.*)?$/i.test(url)) type = 'video';
      else if (/\.(mp3|wav|ogg|m4a|aac|opus)(\?.*)?$/i.test(url)) type = 'audio';
      else if (/\.pdf(\?.*)?$/i.test(url) || url.indexOf('blob:') === 0) type = 'pdf';
      else if (/\.(doc|docx|xls|xlsx|ppt|pptx)(\?.*)?$/i.test(url)) type = 'office';
      else type = 'generic';
    }

    if (type === 'image') {
      $('#lightbox-badge').text('FOTO').css('background', '#3b82f6');
      $('#lightbox-img-tools').css('display', 'flex');
      currentScale = 1;
      currentRotate = 0;
      applyImageTransform();

      $('#lightbox-loading').show();
      var $img = $('#lightbox-img');
      $img.off('load error').on('load', function() {
        $('#lightbox-loading').hide();
      }).on('error', function() {
        $('#lightbox-loading').hide();
        notify('error', 'Gagal memuat gambar');
      });
      $img.attr('src', url);
      $('#lightbox-img-container').css('display', 'flex');

    } else if (type === 'pdf') {
      $('#lightbox-badge').text('DOKUMEN PDF').css('background', '#dc2626');
      $('#lightbox-loading').show();
      $('#lightbox-iframe').off('load').on('load', function() {
        $('#lightbox-loading').hide();
      }).attr('src', url);
      $('#lightbox-doc-container').show();

    } else if (type === 'office') {
      $('#lightbox-badge').text('DOKUMEN OFFICE').css('background', '#2563eb');
      if (/^https?:\/\//i.test(url) && !/localhost|127\.0\.0\.1/i.test(url)) {
        var gDocUrl = 'https://docs.google.com/viewer?url=' + encodeURIComponent(url) + '&embedded=true';
        $('#lightbox-loading').show();
        $('#lightbox-iframe').off('load').on('load', function() {
          $('#lightbox-loading').hide();
        }).attr('src', gDocUrl);
        $('#lightbox-doc-container').show();
      } else {
        $('#lightbox-generic-icon').html('<i class="fa fa-file-word-o" style="color:#2563eb;"></i>');
        $('#lightbox-generic-title').text(title);
        $('#lightbox-generic-desc').text('Dokumen siap diunduh untuk dibuka pada perangkat Anda.');
        $('#lightbox-generic-container').show();
      }

    } else if (type === 'video') {
      $('#lightbox-badge').text('VIDEO').css('background', '#7c3aed');
      var $video = $('#lightbox-video');
      $video.attr('src', url);
      $('#lightbox-video-container').show();

    } else if (type === 'audio') {
      $('#lightbox-badge').text('PESAN SUARA').css('background', '#059669');
      $('#lightbox-audio-title').text(title);
      var $audio = $('#lightbox-audio');
      $audio.attr('src', url);
      $('#lightbox-audio-container').show();

    } else {
      $('#lightbox-badge').text('FILE').css('background', '#64748b');
      $('#lightbox-generic-icon').html('<i class="fa fa-file-text-o" style="color:#64748b;"></i>');
      $('#lightbox-generic-title').text(title);
      $('#lightbox-generic-desc').text('File lampiran siap diunduh.');
      $('#lightbox-generic-container').show();
    }

    $('#modal-media-lightbox').modal('show');
  }

  function applyImageTransform() {
    $('#lightbox-img').css('transform', 'scale(' + currentScale + ') rotate(' + currentRotate + 'deg)');
  }

  $(document).on('click', '#btn-lightbox-zoomin', function() {
    if (currentScale < 3) {
      currentScale += 0.25;
      applyImageTransform();
    }
  });
  $(document).on('click', '#btn-lightbox-zoomout', function() {
    if (currentScale > 0.5) {
      currentScale -= 0.25;
      applyImageTransform();
    }
  });
  $(document).on('click', '#btn-lightbox-zoomreset', function() {
    currentScale = 1;
    currentRotate = 0;
    applyImageTransform();
  });
  $(document).on('click', '#btn-lightbox-rotate', function() {
    currentRotate = (currentRotate + 90) % 360;
    applyImageTransform();
  });

  $('#modal-media-lightbox').on('hidden.bs.modal', function() {
    var videoEl = document.getElementById('lightbox-video');
    if (videoEl) { videoEl.pause(); videoEl.src = ''; }
    var audioEl = document.getElementById('lightbox-audio');
    if (audioEl) { audioEl.pause(); audioEl.src = ''; }
    var iframeEl = document.getElementById('lightbox-iframe');
    if (iframeEl) { iframeEl.src = ''; }
  });

  // Click on chat preview buttons or media items
  $(document).on('click', '.btn-open-preview, .chat-media-clickable', function(e) {
    e.preventDefault();
    var url = $(this).data('media-url');
    var type = $(this).data('media-type');
    var title = $(this).data('media-title');
    openMediaPreview(url, type, title);
  });

});
</script>

