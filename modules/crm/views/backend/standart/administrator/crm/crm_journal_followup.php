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
  overflow: visible;
}
.crm-header-nav::after {
  content: '';
  position: absolute;
  right: 0; bottom: 0;
  width: 220px; height: 180px;
  background: radial-gradient(circle at bottom right, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0) 70%);
  border-bottom-right-radius: 16px;
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
  z-index: 20;
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

.crm-header-nav .action-tools .btn-group {
  position: relative;
}
.crm-header-nav .action-tools .btn-group.open {
  z-index: 1050;
}
.crm-header-nav .action-tools .btn-group .dropdown-menu {
  z-index: 1060 !important;
  border-radius: 12px;
  box-shadow: 0 12px 32px rgba(0,0,0,0.25) !important;
  border: 1px solid rgba(0,0,0,0.08);
  padding: 8px 0;
  min-width: 195px;
}
.crm-header-nav .action-tools .btn-group .dropdown-menu > li > a {
  padding: 9px 16px;
  font-size: 12.5px;
  font-weight: 600;
  color: #334155;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.15s ease;
}
.crm-header-nav .action-tools .btn-group .dropdown-menu > li > a:hover {
  background: #f1f5f9;
  color: #0f172a;
}

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

.table-journal { width: 100% !important; margin-bottom: 0 !important; }
.table-journal th { background: #f8fafc; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; font-weight: 700; padding: 9px 5px !important; border-bottom: 2px solid #e2e8f0 !important; vertical-align: middle !important; }
.table-journal td { font-size: 12px; padding: 7px 5px !important; vertical-align: middle !important; color: #1e293b; }
.table-journal tbody tr { transition: all 0.15s ease; }
.table-journal tbody tr:hover { background: #f8fafc !important; }

/* Keterangan Badges: Green (Sudah Follow-Up), Red (Terlewat / Overdue), Orange (Hari Ini), Muted (Mendatang) */
.badge-keterangan-green {
  background: #10b981;
  color: #ffffff !important;
  font-size: 10.5px;
  font-weight: 800;
  padding: 3px 6px;
  border-radius: 4px;
  display: inline-block;
  letter-spacing: 0.3px;
  box-shadow: 0 1px 3px rgba(16, 185, 129, 0.3);
  white-space: nowrap;
}
.badge-keterangan-red {
  background: #ef4444;
  color: #ffffff !important;
  font-size: 10.5px;
  font-weight: 800;
  padding: 3px 6px;
  border-radius: 4px;
  display: inline-block;
  letter-spacing: 0.3px;
  box-shadow: 0 1px 3px rgba(239, 68, 68, 0.3);
  white-space: nowrap;
}
.badge-keterangan-orange {
  background: #f59e0b;
  color: #ffffff !important;
  font-size: 10.5px;
  font-weight: 800;
  font-style: italic;
  padding: 3px 6px;
  border-radius: 4px;
  display: inline-block;
  letter-spacing: 0.3px;
  box-shadow: 0 1px 3px rgba(245, 158, 11, 0.3);
  white-space: nowrap;
}
.badge-keterangan-muted {
  background: #64748b;
  color: #ffffff !important;
  font-size: 10.5px;
  font-weight: 700;
  font-style: italic;
  padding: 3px 6px;
  border-radius: 4px;
  display: inline-block;
  letter-spacing: 0.3px;
  white-space: nowrap;
}

/* Keterangan Follow-Up Badge Style (Non-clickable automatic status) */
.badge-keterangan-green, .badge-keterangan-red, .badge-keterangan-orange, .badge-keterangan-muted {
  user-select: none;
}

/* Keterangan BC Milestone Indicators (Indikator Otomatis - Tidak Bisa Diklik) */
.badge-group-keterangan-bc, .btn-group-keterangan-bc {
  display: inline-flex;
  flex-wrap: nowrap;
  gap: 2px;
  align-items: center;
  justify-content: center;
  user-select: none;
}
.badge-bc-pill, .btn-bc-pill {
  display: inline-flex;
  align-items: center;
  gap: 2px;
  background: #f8fafc;
  border: 1px solid #cbd5e1;
  border-radius: 4px;
  color: #475569;
  font-size: 10px;
  font-weight: 700;
  padding: 2.5px 5.5px;
  cursor: pointer !important;
  user-select: none;
  white-space: nowrap;
  line-height: 1.25;
  text-decoration: none !important;
  transition: all 0.18s ease-in-out;
}
.badge-bc-pill:hover, .btn-bc-pill:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 6px rgba(0,0,0,0.12);
  border-color: #94a3b8;
  color: #1e293b;
  text-decoration: none !important;
}
.badge-bc-pill.btn-bc-overdue, .btn-bc-pill.btn-bc-overdue {
  background: #fee2e2;
  border-color: #fca5a5;
  color: #b91c1c;
  font-weight: 700;
}
.badge-bc-pill.btn-bc-overdue:hover, .btn-bc-pill.btn-bc-overdue:hover {
  background: #fecaca;
  border-color: #f87171;
  color: #991b1b;
  box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
  text-decoration: none !important;
}
.badge-bc-pill.active, .btn-bc-pill.active {
  background: #10b981 !important;
  border-color: #059669 !important;
  color: #ffffff !important;
  font-weight: 800;
  box-shadow: 0 1px 3px rgba(16, 185, 129, 0.35);
}
.badge-bc-pill.active:hover, .btn-bc-pill.active:hover {
  background: #059669 !important;
  border-color: #047857 !important;
  color: #ffffff !important;
  box-shadow: 0 2px 6px rgba(5, 150, 105, 0.35);
  text-decoration: none !important;
}

.tooltip-inner {
  max-width: 340px !important;
  padding: 6px 12px !important;
  font-size: 11.5px !important;
  font-weight: 600 !important;
  line-height: 1.45 !important;
  border-radius: 6px !important;
  background-color: #0f172a !important;
  box-shadow: 0 4px 14px rgba(0,0,0,0.25) !important;
}
.tooltip.top .tooltip-arrow {
  border-top-color: #0f172a !important;
}

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
.cat-pill-scroll-container {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  align-items: center;
  margin-bottom: 15px;
}

@media (max-width: 991px) {
  .crm-header-nav { padding: 16px 16px 12px 16px; margin-bottom: 12px; overflow: visible; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 12px; z-index: 20; }
  .crm-header-nav .action-tools { width: 100%; display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; }
  .crm-header-nav .action-tools .btn,
  .crm-header-nav .action-tools > a,
  .crm-header-nav .action-tools .btn-group { font-size: 11px; width: 100% !important; margin: 0 !important; }
  .crm-header-nav .action-tools .btn-group .btn { width: 100% !important; justify-content: center; }
  .filter-section .col-md-2 { margin-bottom: 8px; }
}

@media (max-width: 767px) {
  .content { padding: 8px 6px !important; }
  .crm-header-nav { padding: 14px 12px 10px 12px; border-radius: 12px; margin-bottom: 12px; overflow: visible; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 10px; z-index: 20; }
  .crm-header-nav .header-title h2 { font-size: 18px; }
  .crm-header-nav .header-title p { font-size: 11px; }
  .crm-header-nav .action-tools { width: 100%; display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; }
  .crm-header-nav .action-tools .btn,
  .crm-header-nav .action-tools > a,
  .crm-header-nav .action-tools .btn-group { font-size: 11px; padding: 7px 10px; width: 100% !important; margin: 0 !important; }
  .crm-header-nav .action-tools .btn-group .btn { width: 100% !important; justify-content: center; }
  .crm-header-nav .action-tools .btn-group .dropdown-menu {
    position: absolute;
    top: 100%;
    margin-top: 6px;
    min-width: 185px;
    max-width: calc(100vw - 32px);
    z-index: 1060 !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.25) !important;
  }
  .crm-header-nav .action-tools .btn-group:nth-child(odd) .dropdown-menu {
    left: 0 !important;
    right: auto !important;
  }
  .crm-header-nav .action-tools .btn-group:nth-child(even) .dropdown-menu {
    right: 0 !important;
    left: auto !important;
  }
  .crm-header-nav .nav-tabs-bar { gap: 6px; padding-top: 10px; z-index: 2; }
  .crm-header-nav .nav-tab-btn { font-size: 11.5px; padding: 6px 12px; }

  .stat-box { padding: 12px 10px; margin-bottom: 8px; border-radius: 10px; }
  .stat-box .num { font-size: 20px; }
  .stat-box .lbl { font-size: 9px; }
  .row > .col-md-4 { width: 33.333%; float: left; padding-left: 4px; padding-right: 4px; }

  .cat-pill-scroll-container {
    display: flex !important;
    flex-wrap: nowrap !important;
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
    scrollbar-width: none !important;
    padding-bottom: 6px !important;
    margin-bottom: 10px !important;
  }
  .cat-pill-scroll-container::-webkit-scrollbar { display: none !important; }
  .cat-pill { padding: 6px 12px; font-size: 11px; margin: 0; flex-shrink: 0 !important; white-space: nowrap !important; }

  .filter-section { margin-bottom: 12px; }
  .filter-section .box-body { padding: 12px 14px; }
  .filter-section .form-control { font-size: 13px; height: 38px; }
  .crm-filter-flex { display: flex !important; flex-direction: column !important; gap: 8px !important; }
  .crm-filter-flex > div { width: 100% !important; flex: 1 1 100% !important; }
  .crm-filter-flex .crm-filter-dates { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 8px !important; width: 100% !important; }
  .crm-filter-flex .crm-filter-dates > div { width: 100% !important; }
  .crm-filter-flex .crm-filter-btns { display: grid !important; grid-template-columns: 1fr auto !important; gap: 8px !important; width: 100% !important; }
  .crm-filter-flex .crm-filter-btns .btn { width: 100% !important; justify-content: center !important; }

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
          <i class="fa fa-map-marker"></i> Metafora CRM & After Sales <i class="fa fa-angle-right"></i> <span>Journal Follow-Up</span>
        </div>
        <h2><i class="fa fa-tasks" style="color:#818cf8;"></i> Journal Follow-Up After Sales</h2>
        <p>Pantau tahapan after sales — Konfirmasi Pengiriman, H+3 Cek Sampai, H+7 Experience, Custom H+n</p>
      </div>

      <div class="action-tools">
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
        <i class="fa fa-tachometer"></i> 1. Dashboard Metafora CRM
      </a>
      <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-tasks"></i> 2. Journal Follow-Up
      </a>
      <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="nav-tab-btn">
        <i class="fa fa-whatsapp"></i> 3. Broadcast WA
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
  <div class="cat-pill-scroll-container">

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
  <div class="box box-default filter-section" style="border-radius:12px; border:1px solid #e2e8f0; box-shadow:0 2px 10px rgba(0,0,0,0.03); margin-bottom:18px;">
    <div class="box-body" style="padding:14px 18px;">
      <form method="get" action="<?= site_url('administrator/crm/journal_followup'); ?>">
        <div class="crm-filter-flex" style="display:flex; flex-wrap:wrap; align-items:center; gap:8px;">
          <div style="flex:1 1 130px; min-width:120px;">
            <select name="order_source" class="form-control" style="border-radius:8px; height:38px; font-size:12px;">
              <option value="">Semua Sumber</option>
              <option value="Toko" <?= ($filters['order_source'] ?? '') == 'Toko' ? 'selected' : ''; ?>>Toko</option>
              <option value="Shopee" <?= ($filters['order_source'] ?? '') == 'Shopee' ? 'selected' : ''; ?>>Shopee</option>
              <option value="Tokopedia" <?= ($filters['order_source'] ?? '') == 'Tokopedia' ? 'selected' : ''; ?>>Tokopedia</option>
              <option value="TikTok Shop" <?= ($filters['order_source'] ?? '') == 'TikTok Shop' ? 'selected' : ''; ?>>TikTok Shop</option>
            </select>
          </div>
          <div style="flex:1 1 140px; min-width:130px;">
            <select name="status_label" class="form-control" style="border-radius:8px; height:38px; font-size:12px;">
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
          <div style="flex:1.2 1 160px; min-width:150px;">
            <select name="category_id" class="form-control" style="border-radius:8px; height:38px; font-size:12px;">
              <option value="">Semua Kelompok Follow-Up</option>
              <?php if (!empty($categories)): foreach ($categories as $cat): ?>
              <option value="<?= $cat->id; ?>" <?= (($filters['category_id'] ?? '') == $cat->id) ? 'selected' : ''; ?>>
                <?= htmlspecialchars($cat->nama_kategori); ?> (H+<?= $cat->jumlah_hari; ?>)
              </option>
              <?php endforeach; endif; ?>
            </select>
          </div>
          <div class="crm-filter-dates" style="display:flex; gap:8px; flex:2 1 250px;">
            <div style="flex:1 1 120px;">
              <input type="date" name="date_from" class="form-control" placeholder="Dari tanggal" value="<?= $filters['date_from'] ?? ''; ?>" style="border-radius:8px; height:38px; font-size:12px;" title="Dari Tanggal">
            </div>
            <div style="flex:1 1 120px;">
              <input type="date" name="date_to" class="form-control" placeholder="Sampai tanggal" value="<?= $filters['date_to'] ?? ''; ?>" style="border-radius:8px; height:38px; font-size:12px;" title="Sampai Tanggal">
            </div>
          </div>
          <div style="flex:1.2 1 150px; min-width:130px;">
            <input type="text" name="q" class="form-control" placeholder="Cari nama/HP/resi/pesanan..." value="<?= htmlspecialchars($filters['search'] ?? ''); ?>" style="border-radius:8px; height:38px; font-size:12px;">
          </div>
          <div class="crm-filter-btns" style="display:flex; gap:6px; align-items:center;">
            <button type="submit" class="btn btn-primary" style="border-radius:8px; height:38px; font-weight:700; padding:0 16px; font-size:12px; display:inline-flex; align-items:center; gap:6px;"><i class="fa fa-filter"></i> Filter</button>
            <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="btn btn-default" style="border-radius:8px; height:38px; font-weight:600; padding:0 12px; font-size:12px; display:inline-flex; align-items:center; gap:4px;" title="Reset Filter"><i class="fa fa-refresh"></i></a>
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
            <th style="width:30px; text-align:center; vertical-align:middle;"><input type="checkbox" id="check-all"></th>
            <th style="min-width:140px; vertical-align:middle;">Customer</th>
            <th style="white-space:nowrap; vertical-align:middle;">No. HP</th>
            <th style="white-space:nowrap; vertical-align:middle;">No. Pesanan</th>
            <th style="text-align:center; white-space:nowrap; vertical-align:middle;">Sumber</th>
            <th style="white-space:nowrap; vertical-align:middle;">Kategori Follow-Up</th>
            <th style="text-align:center; white-space:nowrap; vertical-align:middle;">Tgl Kirim</th>
            <th style="text-align:center; white-space:nowrap; vertical-align:middle; width:70px;">Keterangan</th>
            <th style="text-align:center; white-space:nowrap; vertical-align:middle; width:220px; min-width:210px;">Keterangan BC</th>
            <th class="text-center" style="white-space:nowrap; vertical-align:middle; width:95px; min-width:90px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($entries)): ?>
          <tr><td colspan="10" class="text-center" style="padding:40px;color:#95a5a6;"><i class="fa fa-check-circle fa-2x text-success"></i><br>Tidak ada follow-up pending saat ini.</td></tr>
          <?php else: 
          $default_bc_opts = [];
          $crm_milestones = [];
          $categories_by_days = [];
          if (!empty($categories)) {
            foreach ($categories as $cat) {
              if (isset($cat->jumlah_hari)) {
                $clean_cat = preg_replace('/\s*\(H\+\d+\)/i', '', $cat->nama_kategori);
                $default_bc_opts[] = $clean_cat . ' (H+' . (int)$cat->jumlah_hari . ')';
                $crm_milestones[] = (int)$cat->jumlah_hari;
                $categories_by_days[(int)$cat->jumlah_hari] = $cat;
              }
            }
          }
          $default_bc_opts = array_values(array_unique($default_bc_opts));
          $crm_milestones = array_values(array_unique($crm_milestones));
          sort($crm_milestones);

          // Map completed follow-up milestones for orders in current page
          $order_p_list = [];
          foreach ($entries as $ent) {
            if (!empty($ent->no_pesanan) && $ent->no_pesanan !== '-') {
              $order_p_list[] = $ent->no_pesanan;
            }
          }
          $order_p_list = array_values(array_unique($order_p_list));

          $order_completed_map = []; // [ no_pesanan => [ 'H+0' => true, ... ] ]
          if (!empty($order_p_list)) {
            $comp_rows = $this->db->select('tfl.no_pesanan, fc.jumlah_hari, tfl.keterangan_bc, tfl.status_label, tfl.is_broadcast_sent, tfl.waktu_kirim_wa')
              ->from('crm_transaction_followup_labels tfl')
              ->join('crm_followup_categories fc', 'tfl.followup_category_id = fc.id')
              ->where_in('tfl.no_pesanan', $order_p_list)
              ->group_start()
                ->where('tfl.status_label !=', 'Pending')
                ->or_where('tfl.is_broadcast_sent', 1)
                ->or_where('tfl.waktu_kirim_wa IS NOT NULL', null, false)
                ->or_where('(tfl.keterangan_bc IS NOT NULL AND tfl.keterangan_bc != "")', null, false)
              ->group_end()
              ->get()->result();
            foreach ($comp_rows as $cr) {
              $np = $cr->no_pesanan;
              if (!isset($order_completed_map[$np])) {
                $order_completed_map[$np] = [];
              }
              $order_completed_map[$np]['H+' . (int)$cr->jumlah_hari] = true;
            }

            // Also check broadcast logs
            $b_logs = $this->db->select('tfl.no_pesanan, fc.jumlah_hari')
              ->from('crm_broadcast_logs bl')
              ->join('crm_transaction_followup_labels tfl', 'bl.followup_label_id = tfl.id')
              ->join('crm_followup_categories fc', 'tfl.followup_category_id = fc.id')
              ->where_in('tfl.no_pesanan', $order_p_list)
              ->get()->result();
            foreach ($b_logs as $bl) {
              if (!isset($order_completed_map[$bl->no_pesanan])) {
                $order_completed_map[$bl->no_pesanan] = [];
              }
              $order_completed_map[$bl->no_pesanan]['H+' . (int)$bl->jumlah_hari] = true;
            }
          }

          foreach ($entries as $e): 
          ?>
          <tr>
            <td>
              <?php if ($e->status_label === 'Pending' && !$e->is_broadcast_sent && !empty($e->customer_phone) && $e->customer_phone !== '-'): ?>
              <input type="checkbox" class="cb-label" value="<?= $e->id; ?>">
              <?php endif; ?>
            </td>
            <td><strong><?= htmlspecialchars($e->customer_nama); ?></strong></td>
            <td style="font-size:12px; white-space:nowrap;" id="cell-phone-<?= $e->id; ?>">
              <?php if (!empty($e->customer_phone) && $e->customer_phone !== '-'): ?>
                <span class="phone-display" style="font-weight:600; color:#1e293b;"><i class="fa fa-phone" style="color:#27ae60;"></i> <?= htmlspecialchars($e->customer_phone); ?></span>
                <button type="button" class="btn btn-xs btn-link btn-edit-phone" data-label-id="<?= $e->id; ?>" data-nama="<?= htmlspecialchars($e->customer_nama); ?>" data-order="<?= htmlspecialchars($e->no_pesanan ?: '-'); ?>" data-phone="<?= htmlspecialchars($e->customer_phone); ?>" style="color:#94a3b8; padding:0 3px;" title="Ubah Nomor HP"><i class="fa fa-pencil"></i></button>
              <?php else: ?>
                <span class="text-muted"><i class="fa fa-phone-slash text-danger"></i> -</span>
                <button type="button" class="btn btn-xs btn-default btn-edit-phone" data-label-id="<?= $e->id; ?>" data-nama="<?= htmlspecialchars($e->customer_nama); ?>" data-order="<?= htmlspecialchars($e->no_pesanan ?: '-'); ?>" data-phone="" style="border-radius:6px; font-size:10.5px; font-weight:700; padding:2px 7px; margin-left:4px; color:#4338ca; border-color:#cbd5e1; background:#f8fafc;" title="Label resi marketplace ini tidak mencantumkan nomor HP. Klik untuk melengkapi No. HP agar bisa di-broadcast"><i class="fa fa-plus text-primary"></i> Isi No. HP</button>
              <?php endif; ?>
            </td>
            <td style="font-size:12px;">
              <?php 
              $display_no_p = $e->no_pesanan ?: '-';
              if (stripos($display_no_p, 'WAHA-LIVE') !== false || stripos($display_no_p, 'GROUP') !== false) {
                $display_no_p = '-';
              }
              echo htmlspecialchars($display_no_p);
              ?>
              <?php if (!empty($e->nomor_resi) && $e->nomor_resi !== '-' && $e->nomor_resi !== $display_no_p): ?>
                <div style="margin-top:2px;">
                  <span class="label" style="font-family:monospace; color:#0284c7; background:#f0f9ff; border:1px solid #bae6fd; font-size:10px; padding:1px 5px; border-radius:3px; display:inline-flex; align-items:center; gap:3px;" title="Nomor Resi"><i class="fa fa-barcode"></i> <?= htmlspecialchars($e->nomor_resi); ?></span>
                </div>
              <?php endif; ?>
            </td>
            <td>
              <?php
              $src = $e->order_source;
              $no_p = $e->no_pesanan ?: '';
              $cls = 'badge-toko';

              if (stripos($src, 'Shopee') !== false || stripos($no_p, 'SHP') !== false) {
                $cls = 'badge-shopee';
                $src = 'Shopee';
              } elseif (stripos($src, 'Tokopedia') !== false || stripos($no_p, 'TKP') !== false) {
                $cls = 'badge-tokopedia';
                $src = 'Tokopedia';
              } elseif (stripos($src, 'TikTok') !== false || stripos($no_p, 'TTK') !== false) {
                $cls = 'badge-tiktok';
                $src = 'TikTok Shop';
              } elseif (stripos($src, 'WhatsApp') !== false) {
                $cls = 'badge-whatsapp';
                $src = 'WhatsApp';
              } elseif (stripos($src, 'WAHA') !== false || stripos($src, 'Group') !== false) {
                $cls = 'badge-toko';
                $src = 'Toko';
              }
              ?>
              <span class="badge-source <?= $cls; ?>"><?= htmlspecialchars($src); ?></span>
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
            <?php
            $target = $e->tanggal_label_muncul;
            $target_time = strtotime($target);
            $today_time = strtotime(date('Y-m-d'));
            $diff_days = (int)round(($today_time - $target_time) / 86400);

            $waktu_ref = !empty($e->tanggal_pengiriman) ? $e->tanggal_pengiriman : (!empty($e->created_at) ? date('Y-m-d', strtotime($e->created_at)) : date('Y-m-d'));
            $dt_ref = new DateTime(date('Y-m-d', strtotime($waktu_ref)));
            $dt_now = new DateTime(date('Y-m-d'));
            $diff_h = max(0, (int)$dt_ref->diff($dt_now)->format('%r%a'));

            $cur_bc = isset($e->keterangan_bc) ? trim($e->keterangan_bc) : '';
            $milestone_day = isset($e->jumlah_hari) ? (int)$e->jumlah_hari : 0;
            $is_followed_up = !empty($cur_bc) 
              || (!empty($no_p) && isset($order_completed_map[$no_p]['H+' . $milestone_day]))
              || (!empty($e->status_label) && $e->status_label !== 'Pending')
              || ((int)$e->is_broadcast_sent === 1)
              || !empty($e->waktu_kirim_wa);

            $is_overdue = ($diff_h > $milestone_day);
            $is_today = ($diff_h === $milestone_day);

            if ($is_followed_up) {
              $ket_cls = 'badge-keterangan-green';
              $ket_title = 'Sudah Di-Follow Up: ' . ($cur_bc ?: ($order_completed_map[$no_p]['H+' . $milestone_day] ?? ('H+' . $milestone_day)));
              $ket_text = '<i class="fa fa-check"></i> H+' . $diff_h;
            } elseif ($is_overdue) {
              $ket_cls = 'badge-keterangan-red';
              $ket_title = 'Terlewat H+' . $diff_h . ' (Belum Di-Follow Up: ' . $e->nama_kategori . ')';
              $ket_text = 'H+' . $diff_h;
            } elseif ($is_today) {
              $ket_cls = 'badge-keterangan-orange';
              $ket_title = 'Jadwal Hari Ini: ' . $e->nama_kategori . ' (H+' . $milestone_day . ')';
              $ket_text = 'H+' . $diff_h;
            } else {
              $ket_cls = 'badge-keterangan-muted';
              $ket_title = 'Mendatang: Jadwal ' . $e->nama_kategori . ' (H+' . $milestone_day . ')';
              $ket_text = 'H+' . $diff_h;
            }
            ?>
            <!-- 1. Tgl Kirim (Tanggal Customer Beli / Dikirim) -->
            <td style="font-size:12px; white-space:nowrap;"><?= $e->tanggal_pengiriman ? date('d/m/Y', strtotime($e->tanggal_pengiriman)) : '-'; ?></td>

            <!-- 2. Keterangan (Hijau jika sudah difollowup, Merah jika terlewat/overdue, Orange jika hari ini) -->
            <td style="vertical-align:middle; text-align:center; white-space:nowrap;">
              <span class="<?= $ket_cls; ?> btn-open-detail-fu" id="badge-ket-<?= $e->id; ?>" data-label-id="<?= $e->id; ?>" data-diff-h="<?= $diff_h; ?>" data-h-label="H+<?= $diff_h; ?>" data-milestone="<?= $milestone_day; ?>" style="cursor:pointer;" title="<?= $ket_title; ?> &bull; Klik untuk lihat Detail Terakhir Follow-Up">
                <?= $ket_text; ?>
              </span>
            </td>

            <!-- 3. Keterangan BC (Klik label H+ untuk langsung Follow-Up ke WhatsApp sesuai template kategori) -->
            <td style="vertical-align:middle; white-space:nowrap; text-align:center;">
              <div class="badge-group-keterangan-bc">
                <?php 
                $clean_ph = preg_replace('/[^0-9]/', '', (string)$e->customer_phone);
                $wa_ph = (substr($clean_ph, 0, 1) === '0') ? ('62' . substr($clean_ph, 1)) : $clean_ph;
                if (!empty($wa_ph) && substr($wa_ph, 0, 2) !== '62') $wa_ph = '62' . $wa_ph;

                $row_bc_opts = $default_bc_opts;
                foreach ($row_bc_opts as $bco):
                  $is_h = preg_match('/\(H\+(\d+)\)/i', $bco, $m) || preg_match('/^H\+(\d+)$/i', $bco, $m);
                  $h_val = $is_h ? (int)$m[1] : null;
                  $display_text = $is_h ? ('H+' . $h_val) : $bco;

                  $is_act = false;
                  if ($is_h) {
                    $is_act = (!empty($no_p) && isset($order_completed_map[$no_p]['H+' . $h_val]))
                      || (empty($no_p) && $milestone_day === $h_val && $is_followed_up);
                  } else {
                    $is_act = ($cur_bc === $bco);
                  }

                  $btn_cls = '';
                  $btn_title = 'Jadwal Mendatang: ' . $bco . ' &bull; Klik untuk Follow-Up WhatsApp';
                  if ($is_act) {
                    $btn_cls = 'active';
                    $btn_title = 'Sudah Di-Follow Up: ' . $bco . ' &bull; Klik untuk Kirim Ulang via WhatsApp';
                  } elseif (!$is_act && $is_h && $diff_h >= $h_val) {
                    $btn_cls = 'btn-bc-overdue';
                    $btn_title = 'Terlewat: Belum Follow-Up ' . $bco . ' (Umur Pesanan H+' . $diff_h . ') &bull; Klik untuk Follow-Up WhatsApp';
                  }

                  $target_cat = ($is_h && isset($categories_by_days[$h_val])) ? $categories_by_days[$h_val] : null;
                  $target_cat_id = $target_cat ? $target_cat->id : ($e->followup_category_id ?: '');
                  $target_template = ($target_cat && !empty($target_cat->template_pesan_default)) ? $target_cat->template_pesan_default : $e->template_pesan_default;
                  $rendered_msg = $this->model_crm->render_template($target_template, $e);

                  $h_wa_url = !empty($wa_ph) 
                    ? ('https://api.whatsapp.com/send?phone=' . $wa_ph . '&text=' . rawurlencode($rendered_msg))
                    : 'javascript:void(0);';
                ?>
                  <a href="<?= $h_wa_url; ?>" 
                     target="<?= !empty($wa_ph) ? '_blank' : '_self'; ?>"
                     class="badge-bc-pill <?= $btn_cls; ?> btn-h-followup" 
                     data-toggle="tooltip"
                     title="<?= $btn_title; ?>"
                     data-label-id="<?= $e->id; ?>"
                     data-h-val="<?= $h_val; ?>"
                     data-cat-id="<?= $target_cat_id; ?>"
                     data-bc-val="<?= htmlspecialchars($bco); ?>"
                     data-order-no="<?= htmlspecialchars($no_p); ?>"
                     data-nama="<?= htmlspecialchars($e->customer_nama); ?>"
                     data-phone="<?= htmlspecialchars($wa_ph); ?>">
                    <?php if ($is_act): ?><i class="fa fa-check"></i> <?php endif; ?><?= htmlspecialchars($display_text); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </td>
            <td class="text-center" style="white-space:nowrap;">
              <div style="display:inline-flex; align-items:center; justify-content:center; gap:4px;">
                <button type="button" class="btn btn-xs btn-info btn-add-note" 
                        data-label-id="<?= $e->id; ?>" 
                        data-nama="<?= htmlspecialchars($e->customer_nama); ?>" 
                        data-phone="<?= htmlspecialchars($e->customer_phone ?: '-'); ?>"
                        data-order="<?= htmlspecialchars($e->no_pesanan ?: '-'); ?>"
                        data-diff-h="<?= $diff_h; ?>"
                        data-tgl-kirim="<?= $e->tanggal_pengiriman ? date('d/m/Y', strtotime($e->tanggal_pengiriman)) : '-'; ?>"
                        title="Klik untuk melihat Detail Kapan Terakhir Follow-Up, Keterlambatan & Riwayat Catatan" 
                        style="background:#0284c7; border-color:#0284c7; color:#fff; border-radius:6px; padding:4px 10px; font-size:11px; font-weight:600; white-space:nowrap;">
                  <i class="fa fa-clock-o"></i> Detail FU
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

/* Follow-up info card at top of chat modal */
.chat-followup-info-card {
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  padding: 10px 16px;
  font-size: 12px;
}
.fu-card-row {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 12px;
}
.fu-status-col {
  flex: 1;
}
.fu-label-title {
  font-size: 10.5px;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 3px;
  display: flex;
  align-items: center;
  gap: 5px;
}
.fu-status-detail {
  font-size: 12px;
  color: #1e293b;
  line-height: 1.4;
}
.fu-age-col {
  flex-shrink: 0;
  text-align: right;
}
.fu-age-badge {
  display: inline-block;
  background: #e0f2fe;
  color: #0369a1;
  font-weight: 800;
  font-size: 12px;
  padding: 3px 9px;
  border-radius: 6px;
  border: 1px solid #bae6fd;
}
.fu-ship-date {
  font-size: 10.5px;
  color: #64748b;
  margin-top: 3px;
}
.fu-milestones-row {
  margin-top: 8px;
  padding-top: 7px;
  border-top: 1px dashed #cbd5e1;
}
.fu-milestones-title {
  font-size: 10.5px;
  font-weight: 700;
  color: #475569;
  margin-bottom: 5px;
  display: flex;
  align-items: center;
  gap: 5px;
}
.fu-milestones-list {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
  align-items: center;
}
.milestone-journey-pill {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 3px 8px;
  border-radius: 12px;
  font-size: 10.5px;
  font-weight: 700;
  text-decoration: none;
  cursor: default;
  white-space: nowrap;
  transition: all 0.15s ease;
}
.milestone-journey-pill.pill-done {
  background: #dcfce7;
  color: #15803d;
  border: 1px solid #86efac;
}
.milestone-journey-pill.pill-overdue {
  background: #fee2e2;
  color: #b91c1c;
  border: 1px solid #fca5a5;
}
.milestone-journey-pill.pill-today {
  background: #fef3c7;
  color: #b45309;
  border: 1px solid #fcd34d;
  box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2);
}
.milestone-journey-pill.pill-upcoming {
  background: #f1f5f9;
  color: #64748b;
  border: 1px solid #e2e8f0;
}

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
  <div class="modal-dialog" style="max-width: 580px;">
    <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.25);">
      <!-- Header -->
      <div class="chat-header" style="background: linear-gradient(135deg, #075e54 0%, #128c7e 100%); color: #fff; padding: 14px 18px; display: flex; align-items: center; gap: 12px;">
        <div class="avatar" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 17px; font-weight: 700; flex-shrink: 0;"><i class="fa fa-user"></i></div>
        <div class="info" style="flex: 1;">
          <div class="name" id="note-customer-name" style="font-size: 15px; font-weight: 700;">Customer</div>
          <div class="meta" style="font-size: 11.5px; opacity: 0.9; margin-top: 1px;"><i class="fa fa-phone"></i> <span id="chat-phone">-</span> &nbsp;|&nbsp; <i class="fa fa-shopping-bag"></i> <span id="chat-order">-</span></div>
        </div>
        <button type="button" class="btn-refresh-chat" id="btn-refresh-chat" title="Refresh Data" style="background:rgba(255,255,255,0.2);border:none;color:#fff;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:13px;margin-right:6px;transition:all 0.2s;">
          <i class="fa fa-refresh"></i>
        </button>
        <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:0.85;font-size:22px;margin-top:-2px;">&times;</button>
      </div>

      <!-- Main Body Container -->
      <div style="padding: 16px; background: #f8fafc; max-height: calc(85vh - 70px); overflow-y: auto;">
        
        <!-- 1. KOTAK KETERLAMBATAN (Sudah Telat Berapa Lama Tidak Follow-Up) -->
        <div id="fu-delay-box">
          <div style="text-align:center; padding:15px; color:#94a3b8; font-size:12px;">
            <i class="fa fa-spinner fa-spin"></i> Menghitung keterlambatan follow-up...
          </div>
        </div>

        <!-- 2. KOTAK TERAKHIR FOLLOW-UP (Kapan Terakhir Di-Followup) -->
        <div id="fu-last-box">
          <div style="text-align:center; padding:15px; color:#94a3b8; font-size:12px;">
            <i class="fa fa-spinner fa-spin"></i> Memuat riwayat follow-up terakhir...
          </div>
        </div>

        <!-- 2.5. KOTAK PRODUK YANG DIBELI (Customer Pembelian Barang Apa) -->
        <div id="fu-products-box">
          <div style="text-align:center; padding:15px; color:#94a3b8; font-size:12px;">
            <i class="fa fa-spinner fa-spin"></i> Memuat rincian produk yang dibeli...
          </div>
        </div>

        <!-- 3. ALUR TAHAPAN FOLLOW-UP (Jadwal H+ Journey) -->
        <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:12px 14px; margin-bottom:12px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
          <div style="font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; margin-bottom:8px; display:flex; align-items:center; justify-content:space-between;">
            <span><i class="fa fa-road text-primary"></i> Alur Tahapan Follow-Up (Jadwal H+):</span>
            <span id="fu-ship-date-info" style="font-size:11px; font-weight:600; color:#64748b;">Kirim: -</span>
          </div>
          <div class="fu-milestones-list" id="fu-milestones-list" style="display:flex; flex-wrap:wrap; gap:5px;">
            <!-- Populated dynamically via JS -->
          </div>
        </div>

        <!-- 4. RIWAYAT CATATAN INTERNAL -->
        <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:12px 14px; margin-bottom:12px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
          <div style="font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; margin-bottom:8px; display:flex; align-items:center; justify-content:space-between;">
            <span><i class="fa fa-bookmark text-warning"></i> Riwayat Catatan Internal CS:</span>
            <span id="fu-notes-count" class="badge" style="background:#f1f5f9; color:#475569; font-size:10px; font-weight:700;">0 Catatan</span>
          </div>
          <div id="fu-notes-list" style="max-height: 140px; overflow-y: auto;">
            <!-- Populated dynamically via JS -->
          </div>
        </div>

        <!-- 5. FORM TAMBAH CATATAN & UPDATE STATUS -->
        <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:14px 16px; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
          <div style="font-size:12px; font-weight:700; color:#1e293b; margin-bottom:10px; display:flex; align-items:center; gap:6px;">
            <i class="fa fa-pencil-square-o text-success"></i> Tambah Catatan & Update Status Follow-Up
          </div>
          
          <div class="form-group" style="margin-bottom:10px;">
            <label style="font-size:11px; font-weight:700; color:#64748b; margin-bottom:4px; display:block;">Status Follow-Up (Keterangan BC):</label>
            <select id="note-status" class="form-control input-sm" style="border-radius:8px; font-size:12px; font-weight:600; height:34px;">
              <option value="">-- Tetap / Tidak Ubah --</option>
              <option value="Direspon">Direspon</option>
              <option value="Sudah Konfirmasi Diterima">Sudah Konfirmasi Diterima</option>
              <option value="Belum Respon">Belum Respon</option>
              <option value="Komplain">Komplain</option>
              <option value="Tawarkan Repeat Order">Tawarkan Repeat Order</option>
              <option value="Selesai">Selesai</option>
            </select>
          </div>

          <div class="form-group" style="margin-bottom:12px;">
            <label style="font-size:11px; font-weight:700; color:#64748b; margin-bottom:4px; display:block;">Tulis Catatan Internal Baru:</label>
            <textarea id="note-text" class="form-control" rows="3" placeholder="Tulis catatan follow-up di sini (misal: customer respon via telp, barang komplit, minta kirim invoice)..." style="border-radius:8px; font-size:12px; resize:vertical; padding:8px 10px;"></textarea>
          </div>

          <div style="display:flex; gap:8px; align-items:center; justify-content:space-between; padding-top:4px;">
            <a href="#" target="_blank" id="btn-modal-direct-wa" class="btn btn-sm" style="border-radius:8px; font-weight:700; font-size:11.5px; color:#15803d; border:1px solid #86efac; background:#f0fdf4; padding:6px 12px; text-decoration:none;">
              <i class="fa fa-whatsapp"></i> Chat WhatsApp
            </a>
            <button type="button" id="btn-save-note" class="btn btn-sm btn-primary" style="border-radius:8px; font-weight:700; font-size:12px; padding:6px 18px; background:#0284c7; border:none; box-shadow:0 2px 5px rgba(2,132,199,0.3);">
              <i class="fa fa-save"></i> Simpan Catatan
            </button>
          </div>
        </div>

      </div>

      <input type="hidden" id="note-label-id">
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
        <div class="form-group" style="margin-bottom:12px;">
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px;">
            <label style="font-weight:700;font-size:12px;color:#334155; margin-bottom:0;"><i class="fa fa-tags" style="color:#0284c7;"></i> Template Kelompok Follow-Up:</label>
            <span id="wa-preview-template-badge" class="badge" style="background:#e0f2fe; color:#0369a1; font-size:10.5px; font-weight:700; border:1px solid #bae6fd;">Template Otomatis</span>
          </div>
          <select class="form-control input-sm" id="wa-preview-template-select" style="border-radius:8px; font-size:12px; font-weight:600; height:34px;">
            <option value="">-- Memuat Pilihan Template --</option>
          </select>
          <small class="text-muted" style="font-size:11px; margin-top:3px; display:block;"><i class="fa fa-info-circle text-info"></i> Anda dapat mengganti template ke tahapan lain (H+0, H+3, H+7, H+11, H+30) secara instan.</small>
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
  if ($('#modal-media-lightbox').length) $('#modal-media-lightbox').appendTo('body');

  $('.modal-backdrop').remove();
  $('body').removeClass('modal-open');

  $(document).on('hidden.bs.modal', '#modal-note, #modal-wa-preview', function () {
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css('padding-right', '');
  });

  // Initialize Bootstrap Tooltip for BC Pills and Badges
  if ($.fn.tooltip) {
    $('.btn-bc-pill, .badge-keterangan-green, .badge-keterangan-red, .badge-keterangan-orange, .badge-keterangan-muted, .btn-wa-sm').tooltip({
      container: 'body',
      placement: 'top',
      trigger: 'hover',
      delay: { show: 150, hide: 50 }
    });
  }

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

    // Update Keterangan Follow-Up badge otomatis (tidak bisa diklik)
    var $ketBadge = $('#badge-ket-' + label_id);
    var diffH = parseInt($ketBadge.attr('data-diff-h') || 0);
    var hLabel = 'H+' + diffH;

    if (['Sudah Dikirim', 'Direspon', 'Sudah Konfirmasi Diterima', 'Selesai'].indexOf(status) !== -1) {
      // Sudah difollowup: Green
      $ketBadge.removeClass('badge-keterangan-red badge-keterangan-orange badge-keterangan-muted')
               .addClass('badge-keterangan-green')
               .attr('title', 'Sudah Di-Follow Up')
               .html('<i class="fa fa-check"></i> ' + hLabel);

      // Realtime update row BC pills if responded or completed
      var $row = $ketBadge.closest('tr');
      if (['Direspon', 'Sudah Konfirmasi Diterima', 'Selesai'].indexOf(status) !== -1) {
        $row.find('.badge-bc-pill').each(function() {
          var $p = $(this);
          $p.removeClass('btn-bc-overdue').addClass('active');
          if (!$p.find('.fa-check').length) {
            $p.prepend('<i class="fa fa-check"></i> ');
          }
        });
      }
    } else {
      // Belum difollowup (Pending / Belum Respon)
      var ketClass = (diffH > 0) ? 'badge-keterangan-red' : 'badge-keterangan-orange';
      var ketTitle = (diffH > 0) ? 'Terlewat H+' + diffH + ' (Belum Di-Follow Up)' : 'Jadwal Hari Ini (H+0)';
      $ketBadge.removeClass('badge-keterangan-green badge-keterangan-red badge-keterangan-orange badge-keterangan-muted')
               .addClass(ketClass)
               .attr('title', ketTitle)
               .html(hLabel);
    }
  }

  // ===== H+ Milestone WhatsApp Follow-Up Click =====
  $(document).on('click', '.btn-h-followup', function(e) {
    var $btn = $(this);
    var phone = $btn.attr('data-phone');
    if (!phone) {
      e.preventDefault();
      notify('error', 'Nomor WhatsApp customer tidak tersedia.');
      return false;
    }

    var label_id = $btn.attr('data-label-id');
    var h_val = $btn.attr('data-h-val');
    var cat_id = $btn.attr('data-cat-id');
    var bc_val = $btn.attr('data-bc-val');
    var nama = $btn.attr('data-nama') || 'Customer';

    // Mark clicked milestone pill as active visually
    $btn.removeClass('btn-bc-overdue').addClass('active');
    if (!$btn.find('.fa-check').length) {
      $btn.prepend('<i class="fa fa-check"></i> ');
    }
    $btn.attr('data-original-title', 'Sudah Di-Follow Up: ' + bc_val).tooltip('hide');

    // Also update Keterangan column badge
    updateBadgeRealtime(label_id, 'Sudah Dikirim');

    notify('success', 'Membuka WhatsApp follow-up ' + ($btn.text().trim()) + ' untuk ' + nama);

    // Kirim pencatatan log ke server di latar belakang
    $.post(_BASE + 'administrator/crm/log_direct_followup_ajax', buildPayload({
      label_id: label_id,
      category_id: cat_id,
      h_val: h_val,
      keterangan_bc: bc_val
    }));
  });

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

    var currentTemplatesMap = {};
    $('#wa-preview-template-select').html('<option value="">Memuat template...</option>');

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

        // Fetch all templates rendered for this customer so CS can easily switch milestone (H+0 s/d H+30)
        $.get(_BASE + 'administrator/crm/get_templates_ajax', { label_id: label_id }, function(tRes) {
          var tr = parseRes(tRes);
          if (tr.success && tr.templates && tr.templates.length > 0) {
            var $sel = $('#wa-preview-template-select');
            $sel.empty();
            currentTemplatesMap = {};
            var foundCurrent = false;

            $.each(tr.templates, function(i, t) {
              currentTemplatesMap[t.id] = t;
              var isSel = t.is_current ? 'selected' : '';
              if (t.is_current) {
                foundCurrent = true;
                $('#wa-preview-template-badge').text('H+' + t.jumlah_hari);
              }
              $sel.append('<option value="' + t.id + '" ' + isSel + '>' + $('<div>').text(t.nama + ' (H+' + t.jumlah_hari + ')').html() + '</option>');
            });

            if (!foundCurrent && tr.templates.length > 0) {
              $('#wa-preview-template-badge').text('H+' + tr.templates[0].jumlah_hari);
            }
          }
        });

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

  // Switch template on dropdown change
  $(document).on('change', '#wa-preview-template-select', function() {
    var catId = $(this).val();
    if (catId && currentTemplatesMap[catId]) {
      var t = currentTemplatesMap[catId];
      $('#wa-preview-message').val(t.template_rendered || '');
      $('#wa-preview-template-badge').text('H+' + t.jumlah_hari);
    }
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
          notify('success', 'Pesan WA sukses terkirim via WhatsApp API ke ' + nama + ' (' + rawPhone + ')! Pesan telah masuk antrean pengiriman.');
        } else {
          notify('error', 'Gagal pengiriman via WhatsApp API: ' + apiMsg);
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
          notify('success', 'Berhasil mengirim ' + r.count + ' pesan WA otomatis via WhatsApp Gateway API!');
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

  // ===== Open Follow-Up Detail & Note Modal =====
  function loadChatTimeline(lid, showSpinner) {
    if (showSpinner) {
      $('#fu-delay-box').html('<div style="text-align:center; padding:15px; color:#94a3b8; font-size:12px;"><i class="fa fa-spinner fa-spin"></i> Menghitung keterlambatan follow-up...</div>');
      $('#fu-last-box').html('<div style="text-align:center; padding:15px; color:#94a3b8; font-size:12px;"><i class="fa fa-spinner fa-spin"></i> Memuat riwayat follow-up terakhir...</div>');
      $('#fu-products-box').html('<div style="text-align:center; padding:15px; color:#94a3b8; font-size:12px;"><i class="fa fa-spinner fa-spin"></i> Memuat rincian produk yang dibeli...</div>');
      $('#fu-notes-list').html('<div style="text-align:center; padding:15px; color:#94a3b8; font-size:12px;"><i class="fa fa-spinner fa-spin"></i> Memuat catatan internal...</div>');
    }

    $.get(_BASE + 'administrator/crm/get_chat_timeline_ajax', { label_id: lid }, function(res) {
      var r = parseRes(res);
      if (r.success) {
        if (r.label) {
          $('#chat-phone').text(r.label.customer_phone || '-');
          $('#chat-order').text(r.label.no_pesanan || '-');
          if (r.label.status_label) {
            $('#note-status').val(r.label.status_label);
          }
        }
        if (r.followup_info) {
          renderFollowUpSummary(r.followup_info);
          if (r.followup_info.direct_wa_url) {
            $('#btn-modal-direct-wa').attr('href', r.followup_info.direct_wa_url);
          }
        }
        renderInternalNotes(r.internal_notes || []);
      } else {
        $('#fu-delay-box').html('<div style="text-align:center; padding:15px; color:#ef4444; font-size:12px;"><i class="fa fa-exclamation-circle"></i> Gagal memuat data follow-up.</div>');
      }
    }).fail(function() {
      $('#fu-delay-box').html('<div style="text-align:center; padding:15px; color:#ef4444; font-size:12px;"><i class="fa fa-exclamation-circle"></i> Gagal menghubungi server.</div>');
    });
  }

  // Render follow-up info: Kapan terakhir di-followup & Sudah telat berapa lama tidak followup
  function renderFollowUpSummary(info) {
    if (!info) return;

    var ageLabel = info.diff_h_label || ('H+' + (info.diff_h || 0));
    $('#fu-ship-date-info').html('Kirim: <strong>' + (info.tanggal_pengiriman_formatted || '-') + '</strong> (Umur: ' + ageLabel + ')');

    // 1. KOTAK KETERLAMBATAN (Sudah telat berapa lama tidak followup)
    var $delayCard = $('#fu-delay-box');
    var d = info.delay_info || {};
    var delayHtml = '';

    if (d.delay_status === 'delayed') {
      var overdueStagesHtml = '';
      if (d.overdue_milestones && d.overdue_milestones.length > 0) {
        overdueStagesHtml = '<div style="margin-top:10px; padding-top:8px; border-top:1px dashed #fca5a5; display:flex; flex-direction:column; gap:5px;">';
        overdueStagesHtml += '<div style="font-size:10.5px; font-weight:700; color:#991b1b; text-transform:uppercase;"><i class="fa fa-exclamation-circle"></i> Rincian Jadwal yang Terlewat:</div>';
        $.each(d.overdue_milestones, function(idx, om) {
          overdueStagesHtml += '<div style="font-size:11.5px; color:#7f1d1d; display:flex; align-items:center; justify-content:space-between; background:#fff; padding:4px 8px; border-radius:6px; border:1px solid #fecaca;">' +
            '<span><strong style="color:#b91c1c;">&bull; ' + $('<div>').text(om.h_label).html() + '</strong> (' + $('<div>').text(om.category).html() + ')</span>' +
            '<span class="badge" style="background:#fee2e2; color:#991b1b; font-size:10.5px; border:1px solid #fca5a5; font-weight:700;">Telat ' + om.overdue_days + ' Hari</span>' +
          '</div>';
        });
        overdueStagesHtml += '</div>';
      }

      delayHtml = '<div style="background:#fef2f2; border:1.5px solid #fecaca; border-radius:12px; padding:12px 16px; margin-bottom:12px;">' +
        '<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">' +
          '<div style="font-size:11px; font-weight:700; color:#991b1b; text-transform:uppercase; letter-spacing:0.5px;"><i class="fa fa-clock-o"></i> Keterlambatan Follow-Up:</div>' +
          '<span style="background:#ef4444; color:#fff; font-weight:800; font-size:12px; padding:4px 12px; border-radius:20px; display:inline-flex; align-items:center; gap:5px; box-shadow:0 2px 6px rgba(239,68,68,0.3);"><i class="fa fa-exclamation-triangle"></i> ' + $('<div>').text(d.delay_badge || 'Telat').html() + '</span>' +
        '</div>' +
        '<div style="font-size:14px; font-weight:800; color:#7f1d1d;">' + $('<div>').text(d.delay_title || '').html() + '</div>' +
        '<div style="font-size:12px; color:#450a0a; margin-top:3px; line-height:1.4;">' + $('<div>').text(d.delay_desc || '').html() + '</div>' +
        overdueStagesHtml +
      '</div>';

    } else if (d.delay_status === 'due_today') {
      delayHtml = '<div style="background:#fffbeb; border:1.5px solid #fde68a; border-radius:12px; padding:12px 16px; margin-bottom:12px;">' +
        '<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">' +
          '<div style="font-size:11px; font-weight:700; color:#92400e; text-transform:uppercase; letter-spacing:0.5px;"><i class="fa fa-bell"></i> Status Jadwal Hari Ini:</div>' +
          '<span style="background:#f59e0b; color:#fff; font-weight:800; font-size:12px; padding:4px 12px; border-radius:20px; display:inline-flex; align-items:center; gap:5px; box-shadow:0 2px 6px rgba(245,158,11,0.3);"><i class="fa fa-calendar-check-o"></i> ' + $('<div>').text(d.delay_badge || 'Hari Ini').html() + '</span>' +
        '</div>' +
        '<div style="font-size:14px; font-weight:800; color:#78350f;">' + $('<div>').text(d.delay_title || '').html() + '</div>' +
        '<div style="font-size:12px; color:#92400e; margin-top:3px; line-height:1.4;">' + $('<div>').text(d.delay_desc || '').html() + '</div>' +
      '</div>';

    } else if (d.delay_status === 'responded') {
      delayHtml = '<div style="background:#f5f3ff; border:1.5px solid #ddd6fe; border-radius:12px; padding:12px 16px; margin-bottom:12px;">' +
        '<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">' +
          '<div style="font-size:11px; font-weight:700; color:#6d28d9; text-transform:uppercase; letter-spacing:0.5px;"><i class="fa fa-comments"></i> Status Interaksi Pelanggan:</div>' +
          '<span style="background:#7c3aed; color:#fff; font-weight:800; font-size:12px; padding:4px 12px; border-radius:20px; display:inline-flex; align-items:center; gap:5px; box-shadow:0 2px 6px rgba(124,58,237,0.3);"><i class="fa fa-check-circle"></i> ' + $('<div>').text(d.delay_badge || 'Sudah Direspon').html() + '</span>' +
        '</div>' +
        '<div style="font-size:14px; font-weight:800; color:#5b21b6;">' + $('<div>').text(d.delay_title || '').html() + '</div>' +
        '<div style="font-size:12px; color:#6d28d9; margin-top:3px; line-height:1.4;">' + $('<div>').text(d.delay_desc || '').html() + '</div>' +
      '</div>';

    } else if (d.delay_status === 'completed') {
      delayHtml = '<div style="background:#f0fdf4; border:1.5px solid #bbf7d0; border-radius:12px; padding:12px 16px; margin-bottom:12px;">' +
        '<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">' +
          '<div style="font-size:11px; font-weight:700; color:#166534; text-transform:uppercase; letter-spacing:0.5px;"><i class="fa fa-check-circle"></i> Status Tahapan Selesai:</div>' +
          '<span style="background:#10b981; color:#fff; font-weight:800; font-size:12px; padding:4px 12px; border-radius:20px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-check"></i> ' + $('<div>').text(d.delay_badge || 'Selesai').html() + '</span>' +
        '</div>' +
        '<div style="font-size:14px; font-weight:800; color:#14532d;">' + $('<div>').text(d.delay_title || '').html() + '</div>' +
        '<div style="font-size:12px; color:#166534; margin-top:3px; line-height:1.4;">' + $('<div>').text(d.delay_desc || '').html() + '</div>' +
      '</div>';

    } else {
      // on_track (Tepat Waktu)
      delayHtml = '<div style="background:#ecfdf5; border:1.5px solid #a7f3d0; border-radius:12px; padding:12px 16px; margin-bottom:12px;">' +
        '<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">' +
          '<div style="font-size:11px; font-weight:700; color:#065f46; text-transform:uppercase; letter-spacing:0.5px;"><i class="fa fa-clock-o"></i> Status Keterlambatan:</div>' +
          '<span style="background:#059669; color:#fff; font-weight:800; font-size:12px; padding:4px 12px; border-radius:20px; display:inline-flex; align-items:center; gap:5px;"><i class="fa fa-check-circle"></i> ' + $('<div>').text(d.delay_badge || 'Tepat Waktu').html() + '</span>' +
        '</div>' +
        '<div style="font-size:14px; font-weight:800; color:#064e3b;">' + $('<div>').text(d.delay_title || '').html() + '</div>' +
        '<div style="font-size:12px; color:#065f46; margin-top:3px; line-height:1.4;">' + $('<div>').text(d.delay_desc || '').html() + '</div>' +
      '</div>';
    }
    $delayCard.html(delayHtml);

    // 2. KOTAK KAPAN TERAKHIR DI-FOLLOWUP
    var $lastCard = $('#fu-last-box');
    var lastHtml = '';
    if (info.latest_followup && info.latest_followup.time_formatted && info.latest_followup.time_formatted !== '-') {
      var fu = info.latest_followup;
      var rawBy = fu.handled_by || 'Petugas CS';
      var byText = rawBy.split(' ').map(function(w) { return w.charAt(0).toUpperCase() + w.slice(1); }).join(' ');
      byText = $('<div>').text(byText).html();
      lastHtml = '<div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:12px 16px; margin-bottom:12px; box-shadow:0 1px 3px rgba(0,0,0,0.04);">' +
        '<div style="font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; margin-bottom:6px; display:flex; align-items:center; justify-content:space-between;">' +
          '<span><i class="fa fa-calendar-check-o text-success"></i> Terakhir Di-Followup:</span>' +
          '<span class="badge" style="background:#dcfce7; color:#15803d; font-weight:700; font-size:11px; border:1px solid #86efac;"><i class="fa fa-check"></i> Sudah Di-Followup</span>' +
        '</div>' +
        '<div style="display:flex; align-items:flex-start; gap:10px; margin-top:6px;">' +
          '<div style="width:34px; height:34px; border-radius:50%; background:#dcfce7; color:#15803d; display:flex; align-items:center; justify-content:center; font-size:15px; flex-shrink:0;">' +
            '<i class="fa fa-check"></i>' +
          '</div>' +
          '<div style="flex:1;">' +
            '<div style="font-size:13px; font-weight:800; color:#0f172a;">' + $('<div>').text(fu.category || fu.h_label || '').html() + '</div>' +
            '<div style="font-size:12px; color:#475569; margin-top:2px;">' +
              '<i class="fa fa-clock-o text-muted"></i> Kapan: <strong style="color:#1e293b;">' + $('<div>').text(fu.time_formatted).html() + ' WIB</strong>' +
              ' &nbsp;&bull;&nbsp; <i class="fa fa-user text-muted"></i> Oleh: <strong style="color:#1e293b;">' + byText + '</strong>' +
            '</div>' +
          '</div>' +
        '</div>' +
      '</div>';
    } else {
      lastHtml = '<div style="background:#fff; border:1px solid #fed7aa; border-radius:12px; padding:12px 16px; margin-bottom:12px; box-shadow:0 1px 3px rgba(0,0,0,0.04);">' +
        '<div style="font-size:11px; font-weight:700; color:#9a3412; text-transform:uppercase; margin-bottom:6px; display:flex; align-items:center; justify-content:space-between;">' +
          '<span><i class="fa fa-history text-warning"></i> Terakhir Di-Followup:</span>' +
          '<span class="badge" style="background:#fee2e2; color:#dc2626; font-weight:700; font-size:11px; border:1px solid #fca5a5;"><i class="fa fa-exclamation-circle"></i> Belum Pernah</span>' +
        '</div>' +
        '<div style="display:flex; align-items:flex-start; gap:10px; margin-top:6px;">' +
          '<div style="width:34px; height:34px; border-radius:50%; background:#fee2e2; color:#dc2626; display:flex; align-items:center; justify-content:center; font-size:15px; flex-shrink:0;">' +
            '<i class="fa fa-exclamation"></i>' +
          '</div>' +
          '<div style="flex:1;">' +
            '<div style="font-size:13px; font-weight:800; color:#991b1b;">Belum Pernah Di-Followup</div>' +
            '<div style="font-size:12px; color:#64748b; margin-top:2px;">Pesanan ini belum pernah menerima pesan broadcast atau follow-up dari CS sejak pengiriman.</div>' +
          '</div>' +
        '</div>' +
      '</div>';
    }
    $lastCard.html(lastHtml);

    // 2.5. KOTAK PRODUK YANG DIBELI (Customer Pembelian Barang Apa)
    var $prodCard = $('#fu-products-box');
    var items = info.purchased_items || [];
    var meta = info.order_meta || {};
    var prodHtml = '';

    var totalQty = meta.total_qty || 0;
    var badgeItemsCount = items.length + ' Produk' + (totalQty > 0 ? (' (' + totalQty + ' item)') : '');

    var itemsListHtml = '';
    if (items.length > 0) {
      itemsListHtml = '<div style="display:flex; flex-direction:column; gap:8px; max-height:200px; overflow-y:auto; padding-right:2px;">';
      $.each(items, function(idx, item) {
        var imgThumb = '';
        if (item.gambar_url) {
          imgThumb = '<img src="' + $('<div>').text(item.gambar_url).html() + '" style="width:38px; height:38px; object-fit:cover; border-radius:8px; border:1px solid #e2e8f0; flex-shrink:0;">';
        } else {
          imgThumb = '<div style="width:38px; height:38px; border-radius:8px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; border:1px solid #bfdbfe;"><i class="fa fa-cube"></i></div>';
        }

        var skuBadge = item.kode_produk && item.kode_produk !== '-' ? ('<span style="background:#f1f5f9; color:#475569; font-size:10px; padding:2px 6px; border-radius:4px; font-weight:600; font-family:monospace; border:1px solid #e2e8f0;">' + $('<div>').text(item.kode_produk).html() + '</span>') : '';
        var noteBadge = item.catatan && item.catatan !== item.nama_produk ? ('<span style="font-size:11px; color:#64748b; font-style:italic;">' + $('<div>').text(item.catatan).html() + '</span>') : '';

        itemsListHtml += '<div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:8px 10px; display:flex; align-items:center; gap:10px;">' +
          imgThumb +
          '<div style="flex:1; min-width:0;">' +
            '<div style="font-size:12.5px; font-weight:700; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="' + $('<div>').text(item.nama_produk).html() + '">' +
              $('<div>').text(item.nama_produk).html() +
            '</div>' +
            '<div style="display:flex; align-items:center; flex-wrap:wrap; gap:6px; margin-top:3px;">' +
              skuBadge +
              '<span class="badge" style="background:#dbeafe; color:#1e40af; font-size:10.5px; font-weight:700; border:1px solid #bfdbfe;">' + $('<div>').text(item.qty_formatted + ' ' + item.satuan).html() + '</span>' +
              '<span style="font-size:11px; color:#64748b;">@ ' + $('<div>').text(item.harga_satuan_formatted).html() + '</span>' +
              noteBadge +
            '</div>' +
          '</div>' +
          '<div style="text-align:right; flex-shrink:0;">' +
            '<div style="font-size:9.5px; color:#94a3b8; font-weight:700; text-transform:uppercase;">Subtotal</div>' +
            '<div style="font-size:12.5px; font-weight:800; color:#0f172a;">' + $('<div>').text(item.subtotal_formatted).html() + '</div>' +
          '</div>' +
        '</div>';
      });
      itemsListHtml += '</div>';

      // Meta order footer (Kurir, Resi, Total Belanja)
      var metaFooter = '<div style="margin-top:10px; padding-top:8px; border-top:1px dashed #cbd5e1; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">' +
        '<div style="display:flex; align-items:center; gap:10px; font-size:11.5px; color:#475569;">';
      if (meta.kurir) {
        metaFooter += '<span><i class="fa fa-truck text-muted"></i> <strong>' + $('<div>').text(meta.kurir).html() + '</strong></span>';
      }
      if (meta.resi && meta.resi !== '-') {
        metaFooter += '<span><i class="fa fa-barcode text-muted"></i> <span style="font-family:monospace; background:#fff; padding:2px 6px; border-radius:4px; border:1px solid #cbd5e1; font-weight:600;">' + $('<div>').text(meta.resi).html() + '</span></span>';
      }
      if (!meta.kurir && (!meta.resi || meta.resi === '-')) {
        metaFooter += '<span style="color:#94a3b8;"><i class="fa fa-shopping-bag text-muted"></i> Transaksi Follow-Up</span>';
      }
      metaFooter += '</div>' +
        '<div style="text-align:right;">' +
          '<span style="font-size:11.5px; color:#64748b;">Total Belanja: </span>' +
          '<strong style="font-size:13.5px; color:#059669; font-weight:800;">' + $('<div>').text(meta.order_total_formatted || '-').html() + '</strong>' +
        '</div>' +
      '</div>';
      itemsListHtml += metaFooter;

    } else {
      itemsListHtml = '<div style="text-align:center; padding:12px; color:#94a3b8; font-size:11.5px; background:#f8fafc; border-radius:8px; border:1px dashed #cbd5e1;">' +
        '<i class="fa fa-info-circle text-muted" style="margin-right:4px;"></i> Data rincian barang belum terhubung atau tidak ditemukan untuk transaksi ini.' +
      '</div>';
    }

    prodHtml = '<div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:12px 14px; margin-bottom:12px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">' +
      '<div style="font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; margin-bottom:8px; display:flex; align-items:center; justify-content:space-between;">' +
        '<span><i class="fa fa-shopping-bag" style="color:#0284c7;"></i> Produk yang Dibeli Customer:</span>' +
        (items.length > 0 ? ('<span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:10.5px; font-weight:700; border:1px solid #bae6fd;">' + $('<div>').text(badgeItemsCount).html() + '</span>') : '') +
      '</div>' +
      itemsListHtml +
    '</div>';

    $prodCard.html(prodHtml);

    // 3. TAHAPAN MILESTONE JOURNEY (Daftar H+)
    var $milestonesList = $('#fu-milestones-list');
    $milestonesList.empty();
    if (info.milestones && info.milestones.length > 0) {
      $.each(info.milestones, function(idx, m) {
        var cls = 'pill-upcoming';
        var icon = 'fa-clock-o';
        var badgeText = m.h_label;
        var tooltip = m.category;

        if (m.is_completed || m.status === 'completed') {
          cls = 'pill-done';
          icon = 'fa-check';
          badgeText = m.h_label + ' Selesai';
          tooltip = m.category + ' | Sudah difollowup: ' + (m.completed_at || '-') + (m.handled_by ? (' (Oleh ' + m.handled_by + ')') : '');
        } else if (m.status === 'overdue') {
          cls = 'pill-overdue';
          icon = 'fa-times';
          badgeText = m.h_label + ' Terlewat';
          tooltip = m.category + ' | Terlewat (Jadwal ' + m.h_label + ', Umur pesanan saat ini ' + ageLabel + ')';
        } else if (m.status === 'today') {
          cls = 'pill-today';
          icon = 'fa-bell';
          badgeText = m.h_label + ' Hari Ini';
          tooltip = m.category + ' | Jadwal follow-up jatuh HARI INI!';
        } else {
          cls = 'pill-upcoming';
          icon = 'fa-calendar-o';
          badgeText = m.h_label;
          tooltip = m.category + ' | Belum jatuh tempo (' + m.h_label + ')';
        }

        var pillHtml = '<span class="milestone-journey-pill ' + cls + '" title="' + $('<div>').text(tooltip).html() + '">' +
                       '<i class="fa ' + icon + '"></i> ' + $('<div>').text(badgeText).html() +
                       '</span>';
        $milestonesList.append(pillHtml);
      });
    } else {
      $milestonesList.html('<span style="color:#94a3b8; font-size:11px;">Tidak ada konfigurasi tahapan follow-up.</span>');
    }
  }

  // Render Riwayat Catatan Internal CS
  function renderInternalNotes(notes) {
    var $box = $('#fu-notes-list');
    $('#fu-notes-count').text((notes ? notes.length : 0) + ' Catatan');

    if (!notes || notes.length === 0) {
      $box.html('<div style="text-align:center; padding:14px 10px; color:#94a3b8; font-size:12px; background:#f8fafc; border-radius:8px; border:1px dashed #cbd5e1;">' +
        '<i class="fa fa-sticky-note-o" style="font-size:18px; display:block; margin-bottom:4px; color:#cbd5e1;"></i>' +
        'Belum ada catatan internal untuk pesanan ini.<br><small style="color:#94a3b8;">Gunakan form di bawah untuk menulis catatan follow-up.</small>' +
      '</div>');
      return;
    }

    var html = '<div style="display:flex; flex-direction:column; gap:6px;">';
    $.each(notes, function(i, n) {
      var author = n.author || 'Petugas CS';
      var time = n.created_at_formatted || n.created_at || '-';
      var statusTag = n.status_manual ? ('<span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:10px; font-weight:600; margin-left:6px;">' + $('<div>').text(n.status_manual).html() + '</span>') : '';
      var cleanCatatan = $('<div>').text(n.catatan || '').html().replace(/\n/g, '<br>');
      var noteId = n.id;
      var noteType = n.type || (String(noteId).indexOf('ch_') === 0 ? 'chat' : 'note');
      var rawId = n.raw_id || String(noteId).replace('ch_', '');
      var rawAttr = $('<div>').text(n.catatan || '').html().replace(/"/g, '&quot;');

      html += '<div class="internal-note-item" id="note-item-' + noteId + '" data-id="' + noteId + '" style="background:#f8fafc; border:1px solid #e2e8f0; border-left:3px solid #f59e0b; border-radius:6px; padding:8px 10px; font-size:12px; transition:all 0.2s;">' +
        '<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px; gap:8px;">' +
          '<div style="font-weight:700; color:#334155; display:flex; align-items:center; flex-wrap:wrap; gap:4px;">' +
            '<i class="fa fa-user-circle text-muted"></i> ' + $('<div>').text(author).html() + statusTag +
          '</div>' +
          '<div style="display:flex; align-items:center; gap:5px; flex-shrink:0;">' +
            '<span style="font-size:10.5px; color:#94a3b8;"><i class="fa fa-clock-o"></i> ' + $('<div>').text(time).html() + '</span>' +
            '<button type="button" class="btn btn-xs btn-edit-internal-note" data-id="' + noteId + '" data-type="' + noteType + '" data-raw-id="' + rawId + '" title="Edit Catatan" style="padding:1px 7px; font-size:11px; font-weight:600; color:#2563eb; border:1px solid #bfdbfe; background:#eff6ff; border-radius:4px; line-height:1.3; cursor:pointer;">' +
              '<i class="fa fa-pencil"></i> Edit' +
            '</button>' +
            '<button type="button" class="btn btn-xs btn-delete-internal-note" data-id="' + noteId + '" data-type="' + noteType + '" data-raw-id="' + rawId + '" title="Hapus Catatan" style="padding:1px 7px; font-size:11px; font-weight:600; color:#dc2626; border:1px solid #fecaca; background:#fef2f2; border-radius:4px; line-height:1.3; cursor:pointer;">' +
              '<i class="fa fa-trash"></i> Hapus' +
            '</button>' +
          '</div>' +
        '</div>' +
        '<div class="note-content-display" id="note-text-display-' + noteId + '" data-raw-text="' + rawAttr + '" style="color:#1e293b; line-height:1.4;">' + cleanCatatan + '</div>' +
        '<div class="note-edit-box" id="note-edit-box-' + noteId + '" style="display:none; margin-top:6px;">' +
          '<textarea class="form-control input-sm note-edit-textarea" id="note-edit-textarea-' + noteId + '" rows="2" style="font-size:12px; resize:vertical; border-radius:6px; border:1.5px solid #3b82f6;"></textarea>' +
          '<div style="display:flex; justify-content:flex-end; gap:6px; margin-top:5px;">' +
            '<button type="button" class="btn btn-xs btn-default btn-cancel-edit-note" data-id="' + noteId + '" style="font-size:11px; padding:2px 8px; border-radius:4px;">Batal</button>' +
            '<button type="button" class="btn btn-xs btn-primary btn-save-edit-note" data-id="' + noteId + '" data-type="' + noteType + '" data-raw-id="' + rawId + '" style="font-size:11px; padding:2px 10px; font-weight:700; background:#2563eb; border-radius:4px;"><i class="fa fa-check"></i> Simpan</button>' +
          '</div>' +
        '</div>' +
      '</div>';
    });
    html += '</div>';

    $box.html(html);
  }

  // ===== EDIT & DELETE INTERNAL NOTES EVENT HANDLERS =====
  $(document).on('click', '.btn-edit-internal-note', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var noteId = $(this).attr('data-id');
    var $display = $('#note-text-display-' + noteId);
    var rawText = $display.attr('data-raw-text');
    if (typeof rawText === 'undefined' || rawText === null) {
      rawText = $display.text();
    }
    $('#note-edit-textarea-' + noteId).val(rawText);
    $display.hide();
    $('#note-edit-box-' + noteId).slideDown(150);
    setTimeout(function() {
      $('#note-edit-textarea-' + noteId).focus();
    }, 160);
  });

  $(document).on('click', '.btn-cancel-edit-note', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var noteId = $(this).attr('data-id');
    $('#note-edit-box-' + noteId).hide();
    $('#note-text-display-' + noteId).show();
  });

  $(document).on('click', '.btn-save-edit-note', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $btn = $(this);
    var noteId = $btn.attr('data-id');
    var rawId = $btn.attr('data-raw-id');
    var type = $btn.attr('data-type');
    var newText = $.trim($('#note-edit-textarea-' + noteId).val());

    if (!newText) {
      notify('warning', 'Isi catatan tidak boleh kosong');
      return;
    }

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    $.ajax({
      url: _BASE + 'administrator/crm/update_internal_note_ajax',
      type: 'POST',
      data: buildPayload({
        note_id: noteId,
        raw_id: rawId,
        type: type,
        catatan: newText
      }),
      success: function(res) {
        var r = parseRes(res);
        if (r.success) {
          notify('success', r.message || 'Catatan berhasil diperbarui');
          var cleanHtml = $('<div>').text(newText).html().replace(/\n/g, '<br>');
          var escapedAttr = $('<div>').text(newText).html().replace(/"/g, '&quot;');
          $('#note-text-display-' + noteId).attr('data-raw-text', escapedAttr).html(cleanHtml).show();
          $('#note-edit-box-' + noteId).hide();
          
          var lid = $('#note-label-id').val();
          if (lid) loadChatTimeline(lid, false);
        } else {
          notify('error', r.message || 'Gagal memperbarui catatan');
        }
      },
      error: function() {
        notify('error', 'Gagal menghubungi server');
      },
      complete: function() {
        $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Simpan');
      }
    });
  });

  $(document).on('click', '.btn-delete-internal-note', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var noteId = $(this).attr('data-id');
    var rawId = $(this).attr('data-raw-id');
    var type = $(this).attr('data-type');

    var doDelete = function() {
      var $item = $('#note-item-' + noteId);
      $item.css('opacity', '0.4');

      $.ajax({
        url: _BASE + 'administrator/crm/delete_internal_note_ajax',
        type: 'POST',
        data: buildPayload({
          note_id: noteId,
          raw_id: rawId,
          type: type
        }),
        success: function(res) {
          var r = parseRes(res);
          if (r.success) {
            notify('success', r.message || 'Catatan berhasil dihapus');
            $item.slideUp(200, function() {
              $(this).remove();
              var count = $('.internal-note-item').length;
              $('#fu-notes-count').text(count + ' Catatan');
              if (count === 0) {
                $('#fu-notes-list').html('<div style="text-align:center; padding:14px 10px; color:#94a3b8; font-size:12px; background:#f8fafc; border-radius:8px; border:1px dashed #cbd5e1;">' +
                  '<i class="fa fa-sticky-note-o" style="font-size:18px; display:block; margin-bottom:4px; color:#cbd5e1;"></i>' +
                  'Belum ada catatan internal untuk pesanan ini.<br><small style="color:#94a3b8;">Gunakan form di bawah untuk menulis catatan follow-up.</small>' +
                '</div>');
              }
            });

            var lid = $('#note-label-id').val();
            if (lid) loadChatTimeline(lid, false);
          } else {
            $item.css('opacity', '1');
            notify('error', r.message || 'Gagal menghapus catatan');
          }
        },
        error: function() {
          $item.css('opacity', '1');
          notify('error', 'Gagal menghubungi server');
        }
      });
    };

    if (typeof swal === 'function') {
      swal({
        title: 'Hapus Catatan?',
        text: 'Apakah Anda yakin ingin menghapus catatan internal ini?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        closeOnConfirm: true
      }, function(confirmed) {
        if (confirmed) doDelete();
      });
    } else {
      if (confirm('Apakah Anda yakin ingin menghapus catatan internal ini?')) {
        doDelete();
      }
    }
  });

  $(document).on('click', '.btn-add-note, .btn-open-detail-fu', function() {
    var lid = $(this).attr('data-label-id') || $(this).attr('id').replace('badge-ket-', '');
    var $btnRef = $('.btn-add-note[data-label-id="' + lid + '"]');
    var nama = $btnRef.attr('data-nama') || $(this).attr('data-nama');
    var phone = $btnRef.attr('data-phone') || $(this).attr('data-phone') || '-';
    var order = $btnRef.attr('data-order') || $(this).attr('data-order') || '-';

    $('#note-label-id').val(lid);
    $('#note-customer-name').text(nama);
    $('#chat-phone').text(phone);
    $('#chat-order').text(order);

    $('#note-text').val('');
    $('#note-status').val('');

    loadChatTimeline(lid, true);

    $('.modal-backdrop').remove();
    $('#modal-note').modal('show');
    setTimeout(function() { $('#note-text').focus(); }, 300);
  });

  // Refresh button
  $(document).on('click', '#btn-refresh-chat', function() {
    var $icon = $(this).find('i');
    $icon.addClass('fa-spin');
    var lid = $('#note-label-id').val();
    loadChatTimeline(lid, false);
    setTimeout(function() { $icon.removeClass('fa-spin'); }, 800);
  });

  function renderChatTimeline(timeline) {
    var canvas = $('#chat-canvas');
    if (!canvas.length) return;
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
    if (canvas[0]) canvas.scrollTop(canvas[0].scrollHeight);
  }

  function appendNewMessages(messages) {
    var canvas = $('#chat-canvas');
    if (!canvas.length) return;
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

      // Fallback: use context label if extension not detected
      if (!isImg && !isVideo && !isDoc && contextType) {
        if (contextType === 'image') isImg = true;
        else if (contextType === 'video') isVideo = true;
        else if (contextType === 'pdf' || contextType === 'document') isDoc = true;
      }

      // Fallback 2: detect WA storage URL patterns
      if (!isImg && !isVideo && !isDoc) {
        if (/mmg\.whatsapp\.net/i.test(cleanUrl)) {
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
      var csSender = item.sender || 'Petugas CS';

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
        html += '<div style="font-size:10px;color:#ef4444;margin-top:4px;padding:3px 6px;background:#fef2f2;border-radius:4px;border:1px solid #fecaca;"><i class="fa fa-warning"></i> Gagal terkirim via WhatsApp API</div>';
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
      var noteSender = item.sender || 'Petugas CS';
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

  // ===== Save Note / Update Status =====
  $(document).on('click', '#btn-save-note', function(e) {
    e.preventDefault();
    e.stopPropagation();

    var $btn = $(this);
    if ($btn.prop('disabled') || $btn.hasClass('is-sending')) {
      return false;
    }

    var lid = $('#note-label-id').val();
    var catatan = $.trim($('#note-text').val());
    var status = $('#note-status').val();
    
    if (!catatan && !status) { 
      notify('warning', 'Tulis catatan atau pilih status terlebih dahulu');
      return; 
    }

    $btn.prop('disabled', true).addClass('is-sending').html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    var finishCallback = function() {
      // If status selected, update status
      if (status) {
        $.post(_BASE + 'administrator/crm/update_status_ajax', buildPayload({
          label_id: lid,
          status: status
        }), function(res) {
          var r = parseRes(res);
          if (r.success) {
            var $inlineSel = $('.status-select[data-label-id="' + lid + '"]');
            if ($inlineSel.length) $inlineSel.val(status).data('current', status);
            updateBadgeRealtime(lid, status);
          }
        });
      }

      notify('success', 'Catatan follow-up & status berhasil disimpan');
      $('#note-text').val('');
      $btn.prop('disabled', false).removeClass('is-sending').html('<i class="fa fa-save"></i> Simpan Catatan');
      loadChatTimeline(lid, false);
    };

    if (catatan) {
      $.ajax({
        url: _BASE + 'administrator/crm/send_message_ajax',
        type: 'POST',
        data: buildPayload({
          label_id: lid,
          message: catatan,
          is_internal_note: 1
        }),
        success: function(res) {
          var r = parseRes(res);
          if (r.success) {
            finishCallback();
          } else {
            notify('error', r.message || 'Gagal menyimpan catatan');
            $btn.prop('disabled', false).removeClass('is-sending').html('<i class="fa fa-save"></i> Simpan Catatan');
          }
        },
        error: function(xhr) {
          notify('error', 'Terjadi kesalahan: ' + (xhr.statusText || 'Error'));
          $btn.prop('disabled', false).removeClass('is-sending').html('<i class="fa fa-save"></i> Simpan Catatan');
        }
      });
    } else {
      finishCallback();
    }
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

  // Handle click on Edit Phone button
  $(document).on('click', '.btn-edit-phone', function(e) {
    e.preventDefault();
    var lid = $(this).data('label-id');
    var nama = $(this).data('nama');
    var order = $(this).data('order');
    var phone = $(this).data('phone') || '';
    if (phone === '-') phone = '';

    $('#m-edit-label-id').val(lid);
    $('#m-edit-cust-name').text(nama);
    $('#m-edit-order-no').text(order);
    $('#m-edit-phone-input').val(phone);

    $('#modal-edit-phone').modal('show');
    setTimeout(function() { $('#m-edit-phone-input').focus(); }, 400);
  });

  // Save Phone via AJAX
  $('#btn-save-customer-phone').on('click', function() {
    var lid = $('#m-edit-label-id').val();
    var phone = $('#m-edit-phone-input').val().trim();

    if (!phone || phone.replace(/[^0-9]/g, '').length < 9) {
      if (typeof toastr !== 'undefined') {
        toastr.warning('Masukkan nomor HP yang valid (minimal 9 digit angka)!');
      } else {
        alert('Masukkan nomor HP yang valid (minimal 9 digit angka)!');
      }
      $('#m-edit-phone-input').focus();
      return;
    }

    var $btn = $(this);
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    $.post(_BASE + 'administrator/crm/update_phone_ajax', {
      label_id: lid,
      phone: phone
    }, function(res) {
      $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan No. HP');
      var r = (typeof res === 'object') ? res : JSON.parse(res);
      if (r.success) {
        if (typeof toastr !== 'undefined') {
          toastr.success(r.message);
        } else {
          alert(r.message);
        }
        $('#modal-edit-phone').modal('hide');

        // Update the phone cell in the row
        var cleanPhone = r.phone;
        var cellHtml = '<span class="phone-display" style="font-weight:600; color:#1e293b;"><i class="fa fa-phone" style="color:#27ae60;"></i> ' + cleanPhone + '</span> ' +
          '<button type="button" class="btn btn-xs btn-link btn-edit-phone" data-label-id="' + lid + '" data-nama="' + $('#m-edit-cust-name').text() + '" data-order="' + $('#m-edit-order-no').text() + '" data-phone="' + cleanPhone + '" style="color:#94a3b8; padding:0 3px;" title="Ubah Nomor HP"><i class="fa fa-pencil"></i></button>';
        $('#cell-phone-' + lid).html(cellHtml);

        // Also add checkbox if missing in this row
        var $row = $('#cell-phone-' + lid).closest('tr');
        var $firstTd = $row.find('td:first');
        if ($firstTd.find('.cb-label').length === 0) {
          $firstTd.html('<input type="checkbox" class="cb-label" value="' + lid + '">');
        }

        // Update WhatsApp pill links in this row
        var waPhone = cleanPhone.replace(/[^0-9]/g, '');
        if (waPhone.substr(0, 1) === '0') waPhone = '62' + waPhone.substr(1);
        if (waPhone.substr(0, 2) !== '62') waPhone = '62' + waPhone;
        $row.find('.btn-h-followup').each(function() {
          var curHref = $(this).attr('href');
          if (curHref.indexOf('api.whatsapp.com') !== -1 || curHref.indexOf('javascript') !== -1) {
            $(this).attr('href', 'https://api.whatsapp.com/send?phone=' + waPhone);
            $(this).attr('target', '_blank');
            $(this).data('phone', waPhone);
          }
        });
      } else {
        if (typeof toastr !== 'undefined') {
          toastr.error(r.message || 'Gagal menyimpan nomor HP');
        } else {
          alert(r.message || 'Gagal menyimpan nomor HP');
        }
      }
    }).fail(function() {
      $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan No. HP');
      alert('Gagal menghubungi server.');
    });
  });

});
</script>

<!-- Modal: Edit / Input No. HP Customer -->
<div class="modal fade" id="modal-edit-phone" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document" style="max-width:380px;">
    <div class="modal-content" style="border-radius:14px; overflow:hidden; border:none; box-shadow:0 10px 40px rgba(0,0,0,0.2);">
      <div class="modal-header" style="background:#1e1b4b; color:#fff; padding:16px 20px;">
        <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:0.8;">&times;</button>
        <h4 class="modal-title" style="font-weight:800; font-size:15px;"><i class="fa fa-phone text-success"></i> Kelola No. HP Customer</h4>
      </div>
      <div class="modal-body" style="padding:20px;">
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px 12px; margin-bottom:14px;">
          <div style="font-size:11px; color:#64748b; font-weight:700; text-transform:uppercase;">Customer</div>
          <div id="m-edit-cust-name" style="font-weight:800; color:#0f172a; font-size:13.5px;">-</div>
          <div style="font-size:11px; color:#64748b; margin-top:4px;">No. Pesanan: <span id="m-edit-order-no" style="font-weight:600; color:#334155;">-</span></div>
        </div>

        <div class="form-group" style="margin-bottom:0;">
          <label style="font-size:12px; font-weight:700; color:#334155; margin-bottom:6px;">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-addon" style="background:#f1f5f9; font-weight:700; color:#475569;"><i class="fa fa-whatsapp text-success"></i></span>
            <input type="tel" class="form-control" id="m-edit-phone-input" placeholder="Contoh: 081234567890" style="border-radius:0 8px 8px 0; height:40px; font-size:13px; font-weight:600;">
          </div>
          <small class="text-muted" style="display:block; margin-top:4px; font-size:11px;">Nomor HP akan disimpan otomatis ke CRM, data pesanan marketplace, dan direktori pelanggan.</small>
        </div>
      </div>
      <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:12px 20px;">
        <input type="hidden" id="m-edit-label-id">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:8px; font-weight:600;">Batal</button>
        <button type="button" class="btn btn-primary" id="btn-save-customer-phone" style="border-radius:8px; font-weight:700; background:#4338ca; border-color:#4338ca;"><i class="fa fa-save"></i> Simpan No. HP</button>
      </div>
    </div>
  </div>
</div>

