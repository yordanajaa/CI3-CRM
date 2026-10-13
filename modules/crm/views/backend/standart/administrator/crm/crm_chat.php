<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
:root {
  --wa-primary: #075e54;
  --wa-accent: #128c7e;
  --wa-light: #25d366;
  --wa-bg: #efeae2;
  --wa-chat-bg: #d9fdd3;
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

@keyframes wahaPulse {
  0% { transform: scale(0.95); opacity: 0.8; }
  50% { transform: scale(1.3); opacity: 1; }
  100% { transform: scale(0.95); opacity: 0.8; }
}
.waha-pulsing-dot {
  animation: wahaPulse 1.8s infinite ease-in-out;
  display: inline-block;
}

.wa-chat-container {
  display: flex;
  height: calc(100vh - 280px);
  min-height: 480px;
  background: #ffffff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(0,0,0,0.1);
  border: 1px solid #e2e8f0;
  margin-bottom: 20px;
  position: relative;
}

/* Fullscreen Mode */
.wa-chat-container.wa-fullscreen {
  position: fixed !important;
  top: 0 !important;
  left: 0 !important;
  right: 0 !important;
  bottom: 0 !important;
  width: 100vw !important;
  height: 100vh !important;
  max-height: 100vh !important;
  min-height: 100vh !important;
  z-index: 99999 !important;
  border-radius: 0 !important;
  margin: 0 !important;
  border: none !important;
}

/* Left Sidebar: Conversation List */
.wa-sidebar {
  width: 350px;
  border-right: 1px solid #e2e8f0;
  display: flex;
  flex-direction: column;
  background: #f8fafc;
  flex-shrink: 0;
  height: 100%;
}
.wa-sidebar-header {
  padding: 16px 18px;
  background: linear-gradient(135deg, #075e54 0%, #128c7e 100%);
  color: #fff;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 2px 8px rgba(7,94,84,0.15);
}
.wa-sidebar-header h4 {
  margin: 0;
  font-size: 15px;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 8px;
}
.wa-search-box {
  padding: 12px 14px;
  background: #fff;
  border-bottom: 1px solid #e2e8f0;
}
.wa-search-box input {
  border-radius: 20px;
  border: 1px solid #cbd5e1;
  font-size: 12.5px;
  padding: 7px 16px;
  background: #f1f5f9;
  transition: all 0.2s ease;
}
.wa-search-box input:focus {
  background: #fff;
  border-color: #128c7e;
  box-shadow: 0 0 0 3px rgba(18,140,126,0.15);
  outline: none;
}

.wa-conv-list {
  flex: 1;
  overflow-y: auto;
  margin: 0;
  padding: 0;
  list-style: none;
}
.wa-conv-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  border-bottom: 1px solid #f1f5f9;
  cursor: pointer;
  transition: background 0.15s ease;
  position: relative;
  -webkit-tap-highlight-color: rgba(2, 132, 199, 0.1);
  touch-action: manipulation;
}
.wa-conv-item:hover, .wa-conv-item:active {
  background: #f1f5f9;
}
.wa-conv-item.active {
  background: #e0f2fe;
  border-left: 4px solid #0284c7;
}
.wa-conv-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: #cbd5e1;
  color: #334155;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  font-weight: 700;
  flex-shrink: 0;
  box-shadow: 0 2px 5px rgba(0,0,0,0.06);
}
.wa-conv-item.active .wa-conv-avatar {
  background: #0284c7;
  color: #fff;
}
.wa-conv-info {
  flex: 1;
  min-width: 0;
}
.wa-conv-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 3px;
}
.wa-conv-name {
  font-weight: 700;
  font-size: 13.5px;
  color: #0f172a;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.wa-conv-time {
  font-size: 10.5px;
  color: #94a3b8;
  white-space: nowrap;
}
.wa-conv-msg {
  font-size: 12px;
  color: #64748b;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.wa-conv-item.has-unread {
  background: #f0fdf4 !important;
  border-left: 3px solid #22c55e !important;
}
.wa-conv-item.has-unread .wa-conv-name {
  font-weight: 800;
  color: #064e3b;
}
.wa-conv-item.has-unread .wa-conv-time {
  color: #16a34a;
  font-weight: 700;
}
.wa-conv-item.has-unread .wa-conv-msg span:first-child {
  font-weight: 700;
  color: #0f172a;
}
.wa-conv-badge {
  background: #22c55e;
  color: #fff;
  font-size: 10.5px;
  font-weight: 800;
  min-width: 19px;
  height: 19px;
  line-height: 19px;
  padding: 0 5px;
  border-radius: 10px;
  text-align: center;
  margin-left: 6px;
  box-shadow: 0 2px 5px rgba(34, 197, 94, 0.35);
  flex-shrink: 0;
}
.wa-filter-tabs {
  display: flex;
  gap: 6px;
  padding: 6px 14px 8px 14px;
  border-bottom: 1px solid #e2e8f0;
  background: #f8fafc;
}
.btn-filter-tab {
  background: #f1f5f9;
  border: 1px solid #cbd5e1;
  color: #64748b;
  font-size: 11.5px;
  font-weight: 600;
  border-radius: 16px;
  padding: 3px 12px;
  cursor: pointer;
  transition: all 0.15s ease;
  outline: none;
}
.btn-filter-tab:hover {
  background: #e2e8f0;
  color: #334155;
}
.btn-filter-tab.active {
  background: #dcfce7;
  border-color: #86efac;
  color: #15803d;
  font-weight: 700;
}

/* Right Main Chat Panel */
.wa-main-panel {
  flex: 1;
  display: flex;
  flex-direction: column;
  background: #efeae2;
  background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4cfc6' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  position: relative;
  min-width: 0;
  height: 100%;
}

/* Chat Header */
.wa-chat-header {
  background: #f0f2f5;
  padding: 10px 18px;
  border-bottom: 1px solid #cbd5e1;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 1px 4px rgba(0,0,0,0.05);
  z-index: 10;
  flex-shrink: 0;
}
.wa-header-info {
  display: flex;
  align-items: center;
  gap: 10px;
  min-width: 0;
}
.wa-header-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: linear-gradient(135deg, #075e54, #128c7e);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  font-weight: 700;
  box-shadow: 0 2px 6px rgba(0,0,0,0.12);
  flex-shrink: 0;
}
.wa-header-name {
  font-weight: 700;
  font-size: 14.5px;
  color: #0f172a;
  line-height: 1.2;
  display: flex;
  align-items: center;
  gap: 6px;
  flex-wrap: wrap;
}
.wa-header-sub {
  font-size: 11px;
  color: #64748b;
  margin-top: 2px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Canvas & Bubbles */
.wa-canvas {
  flex: 1 1 auto;
  min-height: 0; /* CRITICAL: allows scrolling without expanding parent */
  overflow-y: auto;
  padding: 16px 14px;
  display: flex;
  flex-direction: column;
  gap: 8px;
  scroll-behavior: smooth;
}

.chat-date-separator {
  align-self: center;
  background: rgba(255,255,255,0.92);
  color: #54656f;
  font-size: 11px;
  font-weight: 700;
  padding: 4px 14px;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.08);
  margin: 10px 0 4px 0;
  text-transform: uppercase;
  letter-spacing: 0.4px;
}

.chat-bubble {
  max-width: 78%;
  padding: 8px 12px;
  border-radius: 10px;
  font-size: 13px;
  line-height: 1.5;
  position: relative;
  word-wrap: break-word;
  box-shadow: 0 1px 2px rgba(0,0,0,0.08);
  transition: transform 0.15s ease;
}
.chat-bubble:hover .btn-reply-msg {
  opacity: 1;
}
.chat-bubble .bubble-time {
  font-size: 10px;
  color: rgba(0,0,0,0.45);
  margin-top: 4px;
  display: flex;
  align-items: center;
  gap: 4px;
  justify-content: flex-end;
}
.bubble-outgoing {
  background: #d9fdd3;
  color: #1a1a1a;
  align-self: flex-end;
  border-bottom-right-radius: 3px;
}
.bubble-incoming {
  background: #ffffff;
  color: #1a1a1a;
  align-self: flex-start;
  border-bottom-left-radius: 3px;
}
.bubble-incoming .bubble-sender {
  font-size: 11px;
  font-weight: 700;
  color: #075e54;
  margin-bottom: 2px;
}
.bubble-note {
  background: #fef3c7;
  color: #78350f;
  align-self: center;
  text-align: center;
  border-radius: 8px;
  font-size: 12px;
  max-width: 88%;
  border: 1px solid #fde68a;
}
.bubble-note .bubble-sender {
  font-size: 10px;
  font-weight: 700;
  color: #92400e;
  margin-bottom: 2px;
}

.btn-reply-msg {
  position: absolute;
  top: 4px;
  right: 6px;
  background: rgba(255,255,255,0.8);
  color: #54656f;
  border: none;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 10px;
  cursor: pointer;
  opacity: 0;
  transition: opacity 0.15s ease;
}
.btn-reply-msg:hover { background: #fff; color: #075e54; }

/* Status Bar */
.wa-status-bar {
  background: #f8fafc;
  padding: 8px 20px;
  border-top: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 12.5px;
  flex-shrink: 0;
}
.wa-status-bar select {
  border-radius: 8px;
  border: 1px solid #cbd5e1;
  padding: 5px 12px;
  font-size: 12px;
  font-weight: 600;
  background: #fff;
  color: #1e293b;
}

/* Footer Input Bar */
.wa-footer {
  background: #f0f2f5;
  padding: 10px 16px;
  border-top: 1px solid #cbd5e1;
  position: relative;
  flex-shrink: 0;
  z-index: 15;
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
  padding: 4px 10px 4px 14px;
  display: flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.06);
  min-height: 44px;
  transition: border-color 0.2s, box-shadow 0.2s;
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
  padding: 4px 6px;
  border-radius: 50%;
  transition: color 0.15s, background 0.15s;
  display: flex;
  align-items: center;
  justify-content: center;
}
.wa-icon-btn:hover { color: #111b21; background: #e2e8f0; }

.wa-textarea {
  flex: 1;
  border: none;
  outline: none;
  background: transparent;
  resize: none;
  font-size: 13.5px;
  line-height: 1.4;
  color: #111b21;
  padding: 4px 0;
  max-height: 90px;
  font-family: inherit;
}

.wa-send-btn {
  width: 44px;
  height: 44px;
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

/* Emoji Popover */
.wa-emoji-popover {
  position: absolute;
  bottom: 65px;
  left: 16px;
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
  padding: 4px 2px;
  border-radius: 8px;
  transition: background 0.15s, transform 0.1s;
  user-select: none;
}
.wa-emoji-item:hover { background: #f1f5f9; transform: scale(1.2); }

/* Attach Popover */
.wa-attach-popover {
  position: absolute;
  bottom: 65px;
  left: 50px;
  background: #ffffff;
  border: 1px solid #cbd5e1;
  border-radius: 12px;
  padding: 8px 0;
  box-shadow: 0 10px 30px rgba(0,0,0,0.18);
  display: none;
  z-index: 1050;
  width: 240px;
}
.wa-attach-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px 16px;
  font-size: 12.5px;
  font-weight: 600;
  color: #334155;
  cursor: pointer;
  transition: background 0.15s;
}
.wa-attach-item:hover { background: #f8fafc; color: #0284c7; }

/* Template Popover */
.wa-template-popover {
  position: absolute;
  bottom: 65px;
  left: 90px;
  background: #ffffff;
  border: 1px solid #cbd5e1;
  border-radius: 14px;
  padding: 10px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.18);
  display: none;
  z-index: 1050;
  width: 320px;
  max-height: 280px;
  overflow-y: auto;
}
.wa-template-item {
  padding: 8px 12px;
  border-radius: 8px;
  border: 1px solid #f1f5f9;
  margin-bottom: 6px;
  cursor: pointer;
  transition: all 0.15s;
  background: #fafafa;
}
.wa-template-item:hover {
  border-color: #00a884;
  background: #f0fdf4;
}
.wa-template-item .tpl-title { font-size: 12px; font-weight: 700; color: #075e54; margin-bottom: 2px; }
.wa-template-item .tpl-preview { font-size: 11px; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  color: #94a3b8;
  text-align: center;
  padding: 40px;
}
.empty-state i {
  font-size: 56px;
  color: #cbd5e1;
  margin-bottom: 14px;
}

@media (min-width: 992px) {
  .btn-back-to-convs {
    display: none !important;
  }
}

/* Laptop / Short Viewport Adjustment (height <= 800px) */
@media (max-height: 800px) and (min-width: 992px) {
  .crm-header-nav {
    padding: 12px 20px 10px 20px;
    margin-bottom: 10px;
  }
  .crm-header-nav .header-top-flex {
    margin-bottom: 6px;
    gap: 8px;
  }
  .crm-header-nav .header-title h2 {
    font-size: 19px;
    margin: 0;
  }
  .crm-header-nav .header-title p {
    font-size: 11px;
    display: none; /* Hide subtitle on short screen laptops to give max height to chat */
  }
  .crm-header-nav .location-tag {
    margin-bottom: 2px;
    padding: 2px 8px;
    font-size: 10px;
  }
  .crm-header-nav .nav-tabs-bar {
    padding-top: 8px;
    gap: 6px;
  }
  .crm-header-nav .nav-tab-btn {
    padding: 5px 12px;
    font-size: 11.5px;
  }
  .wa-chat-container {
    height: calc(100vh - 215px);
    min-height: 420px;
  }
  .wa-canvas {
    padding: 10px 14px;
  }
}

/* Tablet & Mobile Screens (<= 991px) */
@media (max-width: 991px) {
  .crm-header-nav {
    padding: 10px 14px 8px 14px;
    border-radius: 10px;
    margin-bottom: 8px;
  }
  .crm-header-nav .location-tag {
    display: none; /* Hide breadcrumb on mobile to maximize chat area */
  }
  .crm-header-nav .header-top-flex {
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
    flex-wrap: wrap;
  }
  .crm-header-nav .header-title h2 {
    font-size: 16px;
    margin: 0;
  }
  .crm-header-nav .header-title p {
    display: none; /* Hide paragraph on mobile to save vertical space */
  }
  .crm-header-nav .action-tools {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
  }
  .crm-header-nav .action-tools .btn,
  .crm-header-nav .action-tools .btn-open-waha-modal {
    font-size: 10.5px;
    padding: 4px 8px;
    flex: 0 1 auto;
  }
  .crm-header-nav .nav-tabs-bar {
    gap: 4px;
    padding-top: 6px;
  }
  .crm-header-nav .nav-tab-btn {
    font-size: 11px;
    padding: 5px 10px;
    gap: 5px;
  }

  /* Mobile Chat Container: Seamless 1-Pane Switch */
  .wa-chat-container {
    flex-direction: row;
    height: calc(100vh - 165px) !important;
    min-height: 420px;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
    margin-bottom: 8px;
  }
  .wa-sidebar {
    width: 100%;
    height: 100%;
    border-right: none;
    display: flex;
    flex-direction: column;
  }
  .wa-main-panel {
    display: none;
    width: 100%;
    height: 100%;
    flex-direction: column;
  }

  /* When user opens a conversation on mobile */
  .wa-chat-container.mobile-chat-open .wa-sidebar {
    display: none !important;
  }
  .wa-chat-container.mobile-chat-open .wa-main-panel {
    display: flex !important;
    width: 100% !important;
  }

  .btn-back-to-convs {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    padding: 0 !important;
    border-radius: 50% !important;
    background: #f1f5f9 !important;
    border: 1px solid #cbd5e1 !important;
    color: #334155 !important;
    font-size: 13px;
    flex-shrink: 0;
    transition: all 0.15s ease;
  }
  .btn-back-to-convs:hover, .btn-back-to-convs:active {
    background: #e2e8f0 !important;
    color: #0f172a !important;
  }

  #btn-test-notif, #btn-toggle-fullscreen, #btn-close-chat {
    display: none !important;
  }

  .wa-status-bar {
    padding: 6px 10px;
    font-size: 11px;
    gap: 8px;
  }
  .wa-status-bar select {
    padding: 4px 8px;
    font-size: 11px;
  }

  .wa-chat-header {
    padding: 8px 10px;
    gap: 6px;
  }
  .wa-header-avatar {
    width: 36px;
    height: 36px;
    font-size: 14px;
  }
  .wa-header-name {
    font-size: 13px;
  }
  .wa-header-sub {
    font-size: 10px;
  }
  #header-cust-name {
    max-width: 140px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
    vertical-align: middle;
  }
  #header-waha-badge {
    display: none !important;
  }
  .wa-chat-header .btn {
    padding: 5px 8px;
    font-size: 11px;
  }

  .wa-canvas {
    padding: 10px 8px;
  }
  .chat-bubble {
    max-width: 88%;
    font-size: 12.5px;
    padding: 7px 10px;
  }

  .wa-footer {
    padding: 6px 8px;
  }
  .wa-input-pill {
    min-height: 38px;
    padding: 3px 8px;
    gap: 4px;
  }
  .wa-icon-btn {
    font-size: 16px;
    padding: 2px 4px;
  }
  .wa-textarea {
    font-size: 15px; /* Cegah auto-zoom di browser iOS */
  }
  .wa-send-btn {
    width: 38px;
    height: 38px;
    font-size: 15px;
  }

  .wa-emoji-popover {
    width: calc(100vw - 24px);
    left: 12px;
    right: 12px;
    bottom: 56px;
  }
  .wa-emoji-grid {
    grid-template-columns: repeat(6, 1fr);
    font-size: 19px;
  }
  .wa-attach-popover {
    left: 8px;
    bottom: 56px;
    width: calc(100vw - 24px);
    max-width: 260px;
  }
  .wa-template-popover {
    left: 8px;
    bottom: 56px;
    width: calc(100vw - 24px);
    max-width: 320px;
  }

  .modal-dialog {
    margin: 8px auto !important;
    width: calc(100% - 16px) !important;
    max-width: 100% !important;
  }
  .modal-content {
    border-radius: 12px !important;
  }
}

@media (max-width: 480px) {
  .content {
    padding: 4px !important;
  }
  .crm-header-nav {
    padding: 10px 8px;
    border-radius: 8px;
  }
  .crm-header-nav .header-title h2 {
    font-size: 15px;
  }
  .wa-chat-container {
    height: calc(100vh - 140px) !important;
    height: calc(100dvh - 140px) !important;
    min-height: 380px;
    border-radius: 8px;
  }
  .chat-bubble {
    max-width: 92%;
    font-size: 12px;
  }
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

/* Staged Attachment Box (Before Send) */
#wa-attachment-preview-box {
  border-left: 4px solid #3b82f6 !important;
  transition: all 0.2s ease;
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

<div class="row" style="margin-top: 10px;">
  <div class="col-md-12">
    <!-- Header Banner & Navigation -->
    <div class="crm-header-nav">
      <!-- Top Row: Title, Subtitle & Action Tools -->
      <div class="header-top-flex">
        <div class="header-title">
          <div class="location-tag">
            <i class="fa fa-map-marker"></i> CRM & After Sales <i class="fa fa-angle-right"></i> <span>Live Chat WA</span>
          </div>
          <h2><i class="fa fa-comments" style="color:#25d366;"></i> WhatsApp Live Chat Center</h2>
          <p>Kelola percakapan WhatsApp pelanggan, balas pesan real-time, dan catat riwayat interaksi tim CS.</p>
        </div>

        <div class="action-tools">
          <!-- Real-Time WhatsApp Status Pill -->
          <div id="waha-header-pill" class="btn-open-waha-modal" style="display:inline-flex; align-items:center; gap:8px; background:rgba(0,0,0,0.32); border:1px solid rgba(255,255,255,0.25); border-radius:24px; padding:6px 14px; cursor:pointer; transition:all 0.2s;" title="Status WhatsApp (Klik untuk Buka QR / Pengaturan)">
            <span class="waha-pulsing-dot" style="width:10px; height:10px; border-radius:50%; background:#22c55e; display:inline-block; box-shadow:0 0 8px #22c55e;"></span>
            <span id="waha-header-text" style="font-size:12px; font-weight:700; color:#fff;">WhatsApp Terkoneksi</span>
            <span class="badge" id="waha-header-badge" style="display:none; background:#15803d; color:#fff; font-size:10px; font-weight:700; border-radius:12px; padding:3px 8px;">
              <i class="fa fa-check"></i> Connected
            </span>
          </div>

          <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn" style="background:#25D366; color:#fff;" title="Broadcast WA"><i class="fa fa-bullhorn"></i> Broadcast WA</a>
          <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="btn" style="background:#6366f1; color:#fff;" title="Journal Follow-Up"><i class="fa fa-tasks"></i> Journal Follow-Up</a>
          <a href="<?= site_url('administrator/rfm/dashboard'); ?>" class="btn" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.3);"><i class="fa fa-bar-chart"></i> Analisis RFM</a>
        </div>
      </div>

      <!-- Bottom Row: Navigation Tabs Bar -->
      <div class="nav-tabs-bar">
        <a href="<?= site_url('administrator/crm/dashboard'); ?>" class="nav-tab-btn">
          <i class="fa fa-tachometer"></i> 1. Dashboard CRM
        </a>
        <a href="<?= site_url('administrator/crm/chat'); ?>" class="nav-tab-btn active">
          <span class="active-dot"></span> <i class="fa fa-comments"></i> 2. Live Chat WA
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

    <!-- Real-Time WAHA QR Alert Banner (shown when session is in SCAN_QR_CODE) -->
    <div id="waha-qr-alert-banner" style="display:none; background:linear-gradient(90deg, #fffbeb 0%, #fef3c7 100%); border:1px solid #fde68a; border-radius:14px; padding:14px 20px; margin-bottom:18px; box-shadow:0 4px 14px rgba(245,158,11,0.15);">
      <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
        <div style="display:flex; align-items:center; gap:14px;">
          <div style="width:40px; height:40px; border-radius:50%; background:#fef08a; color:#b45309; display:flex; align-items:center; justify-content:center; font-size:19px; box-shadow:0 2px 8px rgba(180,83,9,0.15);">
            <i class="fa fa-qrcode"></i>
          </div>
          <div>
            <div style="font-size:14px; font-weight:800; color:#92400e; display:flex; align-items:center; gap:8px;">
              <span>WhatsApp Memerlukan Scan QR</span>
              <span class="badge" style="background:#f59e0b; color:#fff; font-size:10px;">SESSION: default</span>
            </div>
            <div style="font-size:12px; color:#b45309; margin-top:2px;">
              Tautkan nomor WhatsApp Anda agar pesan masuk & keluar dari pelanggan tersinkronisasi otomatis secara real-time.
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-sm btn-open-waha-modal" style="background:#d97706; color:#fff; border-radius:10px; font-weight:700; font-size:12px; border:none; padding:8px 18px; box-shadow:0 3px 8px rgba(217,119,6,0.35);">
          <i class="fa fa-camera"></i> Tampilkan QR Code Sekarang
        </button>
      </div>
    </div>

    <div class="wa-chat-container" id="wa-chat-container">

      <!-- Left Sidebar: Conversation List -->
      <div class="wa-sidebar">
        <div class="wa-sidebar-header">
          <div>
            <h4><i class="fa fa-whatsapp"></i> WhatsApp Chat Center</h4>
            <div id="waha-sidebar-status" style="font-size:10.5px; opacity:0.95; margin-top:3px; display:flex; align-items:center; gap:6px;">
              <span class="waha-pulsing-dot" style="width:7px; height:7px; border-radius:50%; background:#22c55e; display:inline-block;"></span>
              <span id="waha-sidebar-text">WhatsApp Terkoneksi</span>
            </div>
          </div>
          <div style="display:flex; gap:6px;">
            <button type="button" id="btn-sync-waha-chats" class="btn btn-xs" style="background:rgba(255,255,255,0.25); color:#fff; border-radius:50%; width:28px; height:28px;" title="Tarik Percakapan Real-Time dari WhatsApp">
              <i class="fa fa-cloud-download"></i>
            </button>
            <button type="button" id="btn-refresh-convs" class="btn btn-xs" style="background:rgba(255,255,255,0.25); color:#fff; border-radius:50%; width:28px; height:28px;" title="Refresh Percakapan">
              <i class="fa fa-refresh"></i>
            </button>
          </div>
        </div>
        <div class="wa-search-box" style="position:relative;">
          <input type="text" id="input-search-conv" class="form-control" placeholder="Cari nama atau nomor WA..." value="<?= htmlspecialchars((!empty($search_q) && $search_q !== 'null') ? $search_q : ''); ?>" style="padding-right: 32px;" autocomplete="off">
          <button type="button" id="btn-clear-search-conv" style="display:<?= (!empty($search_q) && $search_q !== 'null') ? 'block' : 'none'; ?>; position:absolute; right:18px; top:50%; transform:translateY(-50%); background:none; border:none; color:#94a3b8; font-size:16px; cursor:pointer; padding:2px 6px; line-height:1;" title="Hapus Pencarian">&times;</button>
        </div>
        <div class="wa-filter-tabs" id="wa-filter-tabs">
          <button type="button" class="btn-filter-tab active" data-filter="all">Semua</button>
          <button type="button" class="btn-filter-tab" data-filter="unread">
            Belum Dibaca <span class="badge-unread-total" id="badge-unread-total" style="display:none; background:#22c55e; color:#fff; font-size:10px; font-weight:800; padding:1px 6px; border-radius:10px; margin-left:3px;">0</span>
          </button>
        </div>
        <ul class="wa-conv-list" id="wa-conv-list">
          <?php if (!empty($conversations)): ?>
            <?php foreach ($conversations as $conv): 
              $is_act = ($active_label_id == $conv->label_id || $active_phone == $conv->customer_phone);
              $is_group = ($conv->order_source === 'WhatsApp Group' || strpos($conv->customer_phone, '@g.us') !== false);
              $initial = $is_group ? '<i class="fa fa-users" style="font-size:14px;"></i>' : strtoupper(substr($conv->customer_nama ?: 'C', 0, 1));
              $time_str = !empty($conv->last_message_at) ? date('d/m H:i', strtotime($conv->last_message_at)) : '';
              $rfm = $conv->rfm ?? null;
              $badge = $rfm['badge'] ?? ['bg' => '#f1f5f9', 'color' => '#475569', 'border' => '#cbd5e1', 'icon' => 'fa-tag'];
              $unread_cnt = (int)($conv->unread_count ?? 0);
              $has_unread = ($unread_cnt > 0);
            ?>
            <li class="wa-conv-item <?= $is_act ? 'active' : ''; ?> <?= $has_unread ? 'has-unread' : ''; ?>" data-label-id="<?= $conv->label_id; ?>" data-phone="<?= htmlspecialchars($conv->customer_phone); ?>" data-nama="<?= htmlspecialchars($conv->customer_nama); ?>" data-order="<?= htmlspecialchars($conv->no_pesanan ?: ($is_group ? 'WhatsApp Group' : 'Direct Chat')); ?>" data-unread="<?= $unread_cnt; ?>">
              <div class="wa-conv-avatar" style="<?= $is_group ? 'background:linear-gradient(135deg, #0284c7, #0ea5e9);' : ''; ?>"><?= $initial; ?></div>
              <div class="wa-conv-info">
                <div class="wa-conv-top">
                  <span class="wa-conv-name">
                    <?php if ($is_group): ?>
                      <i class="fa fa-users" style="color:#0284c7; font-size:11px; margin-right:3px;" title="Grup WhatsApp"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($conv->customer_nama); ?>
                  </span>
                  <span class="wa-conv-time"><?= $time_str; ?></span>
                </div>
                <div class="wa-conv-msg" style="display:flex; justify-content:space-between; align-items:center; gap:4px;">
                  <?php
                    $raw_snip = $conv->last_message ?: ($is_group ? 'Grup WhatsApp' : $conv->customer_phone);
                    if (stripos($raw_snip, '[Foto]') !== false) {
                      $c_cap = trim(str_ireplace(['[Foto]:', '[Foto]'], '', preg_replace('/https?:\/\/[^\s<]+/i', '', $raw_snip)));
                      $snip_display = '📷 Foto' . ($c_cap ? ': ' . $c_cap : '');
                    } elseif (stripos($raw_snip, '[Video]') !== false) {
                      $c_cap = trim(str_ireplace(['[Video]:', '[Video]'], '', preg_replace('/https?:\/\/[^\s<]+/i', '', $raw_snip)));
                      $snip_display = '🎥 Video' . ($c_cap ? ': ' . $c_cap : '');
                    } elseif (stripos($raw_snip, '[Pesan Suara]') !== false || stripos($raw_snip, '[Voice Note]') !== false) {
                      $snip_display = '🎤 Pesan Suara';
                    } elseif (stripos($raw_snip, '[Dokumen') !== false) {
                      $c_cap = trim(preg_replace('/\[Dokumen[^\]]*\]:?/i', '', preg_replace('/https?:\/\/[^\s<]+/i', '', $raw_snip)));
                      $snip_display = '📄 Dokumen' . ($c_cap ? ': ' . $c_cap : '');
                    } else {
                      $snip_display = $raw_snip;
                    }
                  ?>
                  <span class="wa-conv-snip-text" style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; flex:1;"><?= htmlspecialchars($snip_display); ?></span>
                  <?php if (!empty($rfm['segment'])): ?>
                    <span class="badge" style="background:<?= $badge['bg']; ?>; color:<?= $badge['color']; ?>; border:1px solid <?= $badge['border']; ?>; font-size:9.5px; font-weight:700; padding:2px 6px; flex-shrink:0;">
                      <i class="fa <?= $badge['icon']; ?>"></i> <?= htmlspecialchars($rfm['segment']); ?>
                    </span>
                  <?php endif; ?>
                </div>
              </div>
              <?php if ($has_unread): ?>
                <span class="wa-conv-badge"><?= $unread_cnt; ?></span>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li style="padding: 30px 20px; text-align: center; color: #94a3b8; font-size: 13px;">Tidak ada percakapan ditemukan.</li>
          <?php endif; ?>
        </ul>
      </div>

      <!-- Right Main Chat Panel -->
      <div class="wa-main-panel">
        <div class="wa-chat-header" id="wa-chat-header">
          <div class="wa-header-info">
            <button type="button" class="btn btn-sm btn-default btn-back-to-convs" id="btn-back-to-convs" style="display:none; border-radius:8px; padding:6px 10px; margin-right:4px;" title="Kembali ke Daftar Chat">
              <i class="fa fa-arrow-left"></i>
            </button>
            <div class="wa-header-avatar" id="header-avatar"><i class="fa fa-user"></i></div>
            <div style="min-width:0;">
              <div class="wa-header-name">
                <span id="header-cust-name">Pilih Percakapan</span>
                <span id="header-rfm-badge" style="display:none;"></span>
                <span id="header-waha-badge" class="badge" style="background:#dcfce7; color:#15803d; border:1px solid #86efac; font-size:10.5px; font-weight:700; padding:2px 8px; border-radius:12px;">
                  <i class="fa fa-whatsapp"></i> WhatsApp Terkoneksi
                </span>
              </div>
              <div class="wa-header-sub"><span id="header-cust-phone">-</span> &nbsp;|&nbsp; Order: <span id="header-cust-order">-</span></div>
            </div>
          </div>
          <div style="display: flex; gap: 6px; align-items:center; flex-shrink:0;">
            <a href="#" id="btn-header-rfm" class="btn btn-sm" style="background:#6366f1; color:#fff; border-radius: 8px; font-weight: 700; display: none;" title="Buka Analisis RFM Customer">
              <i class="fa fa-bar-chart"></i> <span class="hidden-xs">Analisis RFM</span>
            </a>
            <a href="#" id="btn-header-profile" class="btn btn-sm btn-default" style="border-radius: 8px; font-weight: 600; display: none;" title="Lihat Profil CRM Customer">
              <i class="fa fa-user"></i> <span class="hidden-xs">Profil CRM</span>
            </a>
            <button type="button" id="btn-test-notif" class="btn btn-sm btn-default" style="border-radius: 8px; color: #0284c7; font-weight: 700;" title="Tes Suara Notifikasi & Izin Browser">
              <i class="fa fa-volume-up"></i> <span class="hidden-xs">Tes Suara</span>
            </button>
            <button type="button" id="btn-toggle-fullscreen" class="btn btn-sm btn-default" style="border-radius: 8px;" title="Layar Penuh (Fullscreen)">
              <i class="fa fa-arrows-alt"></i>
            </button>
            <button type="button" id="btn-refresh-stream" class="btn btn-sm btn-default" style="border-radius: 8px;" title="Refresh Chat">
              <i class="fa fa-refresh"></i>
            </button>
            <button type="button" id="btn-close-chat" class="btn btn-sm btn-default" style="border-radius: 8px; color: #ef4444; font-weight:700; display: none;" title="Keluar / Tutup Percakapan Ini">
              <i class="fa fa-times"></i> <span class="hidden-xs">Tutup Chat</span>
            </button>
          </div>
        </div>

        <div class="wa-canvas" id="wa-canvas">
          <div class="empty-state" id="empty-chat-state" style="margin:auto;">
            <div style="width:84px; height:84px; border-radius:50%; background:linear-gradient(135deg, #10b981, #059669); display:flex; align-items:center; justify-content:center; color:#fff; font-size:42px; box-shadow:0 8px 24px rgba(16,185,129,0.3); margin-bottom:18px;">
              <i class="fa fa-whatsapp" style="margin-bottom:0; color:#fff; font-size:42px;"></i>
            </div>
            <h3 style="font-weight: 700; color: #1e293b; margin: 0 0 8px 0; font-size: 20px;">WhatsApp Live Chat</h3>
            <p style="font-size: 13px; color: #64748b; max-width: 420px; line-height: 1.6; margin: 0 0 16px 0;">Pilih salah satu kontak customer di bilah sisi sebelah kiri untuk membuka pesan & membalas percakapan WhatsApp real-time.</p>
            <div style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; background:#ffffff; border-radius:20px; font-size:11.5px; color:#475569; border:1px solid #cbd5e1; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
              <i class="fa fa-lock" style="color:#10b981; font-size:12px; margin:0;"></i> Percakapan terenkripsi & tersinkronisasi via WhatsApp Gateway
            </div>
          </div>
        </div>

        <div class="wa-status-bar" id="wa-status-bar" style="display: none;">
          <label style="margin:0; font-weight: 600; color: #475569;"><i class="fa fa-tag"></i> Status Follow-Up:</label>
          <select id="chat-status-select">
            <option value="">-- Tetapkan Status --</option>
            <option value="Pending">Pending</option>
            <option value="Sudah Dikirim">Sudah Dikirim</option>
            <option value="Direspon">Direspon</option>
            <option value="Sudah Konfirmasi Diterima">Sudah Konfirmasi Diterima</option>
            <option value="Belum Respon">Belum Respon</option>
            <option value="Komplain">Komplain</option>
            <option value="Tawarkan Repeat Order">Tawarkan Repeat Order</option>
            <option value="Selesai">Selesai</option>
          </select>
        </div>

        <!-- Footer Input Bar -->
        <div class="wa-footer" id="wa-footer" style="display: none;">

          <!-- Reply Preview Bar -->
          <div id="wa-reply-preview-bar" style="display:none; background:rgba(0,168,132,0.12); border-left:4px solid #00a884; padding:6px 12px; border-radius:8px; margin-bottom:8px; font-size:12px; position:relative;">
            <div style="font-weight:700; color:#00a884; font-size:11px;"><i class="fa fa-reply"></i> Membalas <span id="wa-reply-sender-name">Pesan</span></div>
            <div id="wa-reply-text-preview" style="color:#334155; font-size:11.5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:90%;"></div>
            <button type="button" id="btn-cancel-reply" style="position:absolute; right:8px; top:6px; background:none; border:none; color:#64748b; font-size:14px; cursor:pointer;" title="Batal Balas">&times;</button>
          </div>

          <!-- Rich Attachment Preview Box (Pratinjau File Sebelum Dikirim) -->
          <div id="wa-attachment-preview-box" style="display:none; background:#ffffff; border:1.5px solid #cbd5e1; border-radius:12px; padding:10px 14px; margin-bottom:10px; box-shadow:0 4px 12px rgba(0,0,0,0.06); animation:fadeIn 0.2s ease;">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
              <div style="display:flex; align-items:center; gap:12px; min-width:0; flex:1;">
                <!-- Thumbnail / Icon Area -->
                <div style="width:50px; height:50px; border-radius:8px; overflow:hidden; background:#e2e8f0; display:flex; align-items:center; justify-content:center; flex-shrink:0; border:1px solid #cbd5e1;">
                  <img id="wa-preview-thumb-img" src="" alt="Thumbnail" style="width:100%; height:100%; object-fit:cover; display:none;">
                  <div id="wa-preview-thumb-icon" style="display:flex; align-items:center; justify-content:center; width:100%; height:100%;">
                    <i class="fa fa-file-text-o" style="font-size:22px; color:#64748b;"></i>
                  </div>
                </div>
                <!-- File Details -->
                <div style="min-width:0; flex:1;">
                  <div id="wa-preview-filename" style="font-weight:700; font-size:12.5px; color:#1e293b; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">nama_file.jpg</div>
                  <div style="display:flex; align-items:center; gap:8px; margin-top:3px; font-size:11px;">
                    <span id="wa-preview-filesize" style="color:#64748b; font-weight:600;">0 KB</span>
                    <span style="color:#cbd5e1;">•</span>
                    <span id="wa-preview-status" style="font-weight:600;"><i class="fa fa-spinner fa-spin text-primary"></i> Mengunggah...</span>
                  </div>
                </div>
              </div>
              <!-- Controls -->
              <div style="display:flex; align-items:center; gap:6px; flex-shrink:0;">
                <button type="button" class="btn btn-xs btn-default" id="btn-quick-preview-staged" title="Pratinjau File" style="border-radius:6px; font-weight:700; padding:4px 10px; background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; display:none;">
                  <i class="fa fa-eye"></i> Pratinjau
                </button>
                <button type="button" class="btn btn-xs btn-default" id="btn-remove-attachment" title="Hapus Lampiran" style="border-radius:6px; font-weight:700; padding:4px 8px; background:#fef2f2; color:#ef4444; border:1px solid #fecaca;">
                  <i class="fa fa-trash"></i>
                </button>
              </div>
            </div>
          </div>
          <div id="wa-attachment-chip" style="display:none;"><span id="wa-attachment-filename"></span></div>

          <!-- URL Input Bar -->
          <div id="wa-url-input-container" style="display:none; margin-bottom:8px;">
            <div style="display:flex; gap:6px;">
              <input type="text" id="input-attach-url" class="form-control input-sm" placeholder="Tempel URL gambar / file (http://...)" style="border-radius:16px; font-size:12px;">
              <button type="button" id="btn-apply-url" class="btn btn-xs btn-primary" style="border-radius:12px; padding:0 12px;">Pakai URL</button>
            </div>
          </div>

          <!-- Popovers -->
          <!-- Emoji Popover -->
          <div class="wa-emoji-popover" id="wa-emoji-popover">
            <div class="wa-emoji-container">
              <div class="wa-emoji-category-title">Ekspresi & Senyum</div>
              <div class="wa-emoji-grid">
                <span class="wa-emoji-item">😊</span><span class="wa-emoji-item">😃</span><span class="wa-emoji-item">😄</span><span class="wa-emoji-item">😁</span><span class="wa-emoji-item">😆</span><span class="wa-emoji-item">😅</span><span class="wa-emoji-item">😂</span>
                <span class="wa-emoji-item">🤣</span><span class="wa-emoji-item">😇</span><span class="wa-emoji-item">😉</span><span class="wa-emoji-item">😍</span><span class="wa-emoji-item">🥰</span><span class="wa-emoji-item">😘</span><span class="wa-emoji-item">😋</span>
                <span class="wa-emoji-item">😎</span><span class="wa-emoji-item">🤗</span><span class="wa-emoji-item">🤔</span><span class="wa-emoji-item">🤩</span><span class="wa-emoji-item">🥳</span><span class="wa-emoji-item">😌</span><span class="wa-emoji-item">😏</span>
                <span class="wa-emoji-item">🥺</span><span class="wa-emoji-item">😢</span><span class="wa-emoji-item">😭</span><span class="wa-emoji-item">😱</span><span class="wa-emoji-item">😴</span><span class="wa-emoji-item">🤫</span><span class="wa-emoji-item">🤭</span>
              </div>
              <div class="wa-emoji-category-title">Tangan & Gestur</div>
              <div class="wa-emoji-grid">
                <span class="wa-emoji-item">👍</span><span class="wa-emoji-item">👎</span><span class="wa-emoji-item">🙏</span><span class="wa-emoji-item">👌</span><span class="wa-emoji-item">🙌</span><span class="wa-emoji-item">👏</span><span class="wa-emoji-item">🤝</span>
                <span class="wa-emoji-item">💪</span><span class="wa-emoji-item">✌️</span><span class="wa-emoji-item">🤞</span><span class="wa-emoji-item">👊</span><span class="wa-emoji-item">👋</span><span class="wa-emoji-item">👉</span><span class="wa-emoji-item">👈</span>
                <span class="wa-emoji-item">👆</span><span class="wa-emoji-item">👇</span><span class="wa-emoji-item">🤙</span><span class="wa-emoji-item">✍️</span><span class="wa-emoji-item">🙋</span><span class="wa-emoji-item">💁</span><span class="wa-emoji-item">🙇</span>
              </div>
              <div class="wa-emoji-category-title">Pesanan & Toko</div>
              <div class="wa-emoji-grid">
                <span class="wa-emoji-item">📦</span><span class="wa-emoji-item">🛒</span><span class="wa-emoji-item">🛍️</span><span class="wa-emoji-item">💰</span><span class="wa-emoji-item">💵</span><span class="wa-emoji-item">🏷️</span><span class="wa-emoji-item">🚚</span>
                <span class="wa-emoji-item">🛵</span><span class="wa-emoji-item">🏢</span><span class="wa-emoji-item">💼</span><span class="wa-emoji-item">📞</span><span class="wa-emoji-item">📱</span><span class="wa-emoji-item">💬</span><span class="wa-emoji-item">📄</span>
                <span class="wa-emoji-item">📑</span><span class="wa-emoji-item">📊</span><span class="wa-emoji-item">📈</span><span class="wa-emoji-item">⏰</span><span class="wa-emoji-item">📅</span><span class="wa-emoji-item">📍</span><span class="wa-emoji-item">🧾</span>
              </div>
              <div class="wa-emoji-category-title">Simbol & Reaksi</div>
              <div class="wa-emoji-grid">
                <span class="wa-emoji-item">❤️</span><span class="wa-emoji-item">🧡</span><span class="wa-emoji-item">💛</span><span class="wa-emoji-item">💚</span><span class="wa-emoji-item">💙</span><span class="wa-emoji-item">💜</span><span class="wa-emoji-item">🤍</span>
                <span class="wa-emoji-item">🔥</span><span class="wa-emoji-item">⭐</span><span class="wa-emoji-item">✨</span><span class="wa-emoji-item">🎉</span><span class="wa-emoji-item">🎁</span><span class="wa-emoji-item">💯</span><span class="wa-emoji-item">✅</span>
                <span class="wa-emoji-item">❌</span><span class="wa-emoji-item">⚠️</span><span class="wa-emoji-item">ℹ️</span><span class="wa-emoji-item">🔔</span><span class="wa-emoji-item">💡</span><span class="wa-emoji-item">🚀</span><span class="wa-emoji-item">🎯</span>
              </div>
            </div>
          </div>

          <!-- Attach Popover -->
          <div class="wa-attach-popover" id="wa-attach-popover">
            <div class="wa-attach-item" id="attach-option-photo"><i class="fa fa-picture-o text-success" style="font-size:16px;"></i> Foto / Gambar</div>
            <div class="wa-attach-item" id="attach-option-doc"><i class="fa fa-file-text-o text-info" style="font-size:16px;"></i> Dokumen (PDF/Doc/Xls)</div>
            <div class="wa-attach-item" id="attach-option-url"><i class="fa fa-link text-warning" style="font-size:16px;"></i> URL Media / Gambar</div>
          </div>

          <!-- Template Popover -->
          <div class="wa-template-popover" id="wa-template-popover">
            <div style="font-size:11px; font-weight:700; color:#64748b; margin-bottom:6px; text-transform:uppercase;">Pilih Template WA:</div>
            <div id="wa-template-list">
              <div style="text-align:center; padding:10px; color:#94a3b8; font-size:11px;"><i class="fa fa-spinner fa-spin"></i> Memuat template...</div>
            </div>
          </div>

          <!-- File Input Hidden -->
          <input type="file" id="file-upload-input" style="display:none;" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.mp3,.wav,.ogg,.m4a">
          <input type="hidden" id="note-file-url" value="">

          <!-- Mode Selector Tabs: Balasan CS vs Catatan Internal -->
          <div style="display: flex; gap: 6px; margin-bottom: 8px;">
            <button type="button" class="btn btn-xs btn-toggle-sender active" data-type="cs_chat" style="border-radius: 6px; font-weight: 700; padding: 4px 10px; border: 2px solid #25D366; background: #d9fdd3; color: #15803d;">
              <i class="fa fa-whatsapp"></i> Balasan CS (WA)
            </button>
            <button type="button" class="btn btn-xs btn-toggle-sender" data-type="cs_note" style="border-radius: 6px; font-weight: 700; padding: 4px 10px; border: 2px solid #e2e8f0; background: #fff; color: #64748b;">
              <i class="fa fa-bookmark"></i> Catatan Internal
            </button>
          </div>

          <div class="wa-input-pill-container">
            <div class="wa-input-pill">
              <button type="button" class="wa-icon-btn" id="btn-toggle-emoji" title="Pilih Emoji (😊)"><i class="fa fa-smile-o"></i></button>
              <button type="button" class="wa-icon-btn" id="btn-toggle-attach" title="Lampirkan File / Gambar (📎)"><i class="fa fa-paperclip"></i></button>
              <button type="button" class="wa-icon-btn" id="btn-toggle-template" title="Template Pesan WA (⚡)"><i class="fa fa-bolt"></i></button>
              
              <textarea id="chat-textarea" class="wa-textarea" rows="1" placeholder="Ketik balasan CS ke WhatsApp customer..." autocomplete="off"></textarea>
            </div>
            <button type="button" class="wa-send-btn" id="btn-send-chat" title="Kirim Pesan WhatsApp (✈️)">
              <i class="fa fa-paper-plane"></i>
            </button>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<!-- Modal Live WhatsApp QR & Connection -->
<div class="modal fade" id="modal-waha-qr" tabindex="-1" role="dialog" style="z-index:9999;">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content" style="border-radius:16px; overflow:hidden; border:none; box-shadow:0 20px 40px rgba(0,0,0,0.25);">
      <div class="modal-header" style="background:linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); color:#fff; padding:18px 22px;">
        <button type="button" class="close" data-dismiss="modal" style="color:#fff; opacity:0.8; font-size:24px;">&times;</button>
        <h4 class="modal-title" style="font-weight:800; display:flex; align-items:center; gap:8px;">
          <i class="fa fa-whatsapp" style="color:#22c55e;"></i> Status Koneksi WhatsApp
        </h4>
      </div>
      <div class="modal-body" style="padding:24px; text-align:center;">
        
        <!-- Live Status Badge -->
        <div style="margin-bottom:16px;">
          <span id="modal-waha-status-badge" class="badge" style="background:#eab308; font-size:12px; font-weight:700; padding:6px 14px; border-radius:20px;">
            Checking status...
          </span>
        </div>

        <!-- QR Code Container (shown when SCAN_QR_CODE) -->
        <div id="modal-qr-container" style="background:#f8fafc; border:2px dashed #cbd5e1; border-radius:14px; padding:20px; display:inline-block; margin-bottom:16px; min-width:260px; min-height:260px;">
          <img id="modal-waha-qr-img" src="<?= base_url('administrator/crm/waha_qr_image'); ?>" alt="Scan QR Code WhatsApp" style="max-width:220px; border-radius:10px; box-shadow:0 4px 14px rgba(0,0,0,0.08); display:none;">
          <div id="modal-qr-loading" style="padding:40px 20px; color:#64748b;">
            <i class="fa fa-spinner fa-spin" style="font-size:32px; color:#6366f1;"></i>
            <p style="margin-top:10px; font-size:12px;">Memuat QR Code...</p>
          </div>
          <div id="modal-waha-connected-view" style="display:none; padding:30px 20px;">
            <i class="fa fa-check-circle" style="font-size:60px; color:#22c55e;"></i>
            <h4 style="font-weight:800; color:#15803d; margin:12px 0 4px;">WhatsApp Terhubung!</h4>
            <p style="color:#64748b; font-size:12px; margin:0;" id="modal-connected-phone">Session default aktif dan siap kirim/terima pesan.</p>
          </div>
        </div>

        <!-- Instructions -->
        <div id="modal-qr-instructions" style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:12px 16px; font-size:12px; color:#166534; text-align:left; margin-bottom:16px;">
          <div style="font-weight:700; margin-bottom:4px;"><i class="fa fa-mobile" style="font-size:16px;"></i> Cara Scan dari HP:</div>
          <ol style="margin:0; padding-left:18px; font-size:11.5px; line-height:1.6;">
            <li>Buka aplikasi <strong>WhatsApp</strong> di HP Anda.</li>
            <li>Ketuk <strong>Titik tiga (kanan atas)</strong> ➔ pilih <strong>Perangkat Tertaut</strong>.</li>
            <li>Ketuk <strong>Tautkan Perangkat</strong>, lalu arahkan kamera ke QR Code di atas.</li>
          </ol>
        </div>

        <!-- Action Controls -->
        <div style="display:flex; gap:8px; justify-content:center;">
          <button type="button" class="btn btn-default" id="btn-modal-refresh-qr" style="border-radius:8px; font-size:12px; font-weight:700;">
            <i class="fa fa-refresh"></i> Refresh QR
          </button>
          <button type="button" class="btn btn-warning" id="btn-modal-restart-session" style="border-radius:8px; font-size:12px; font-weight:700;">
            <i class="fa fa-repeat"></i> Restart Session
          </button>
          <a href="<?= site_url('administrator/crm/wa_gateway_setting'); ?>" target="_blank" class="btn btn-primary" style="border-radius:8px; font-size:12px; font-weight:700; background:#6366f1; border:none;">
            <i class="fa fa-cogs"></i> Pengaturan WhatsApp
          </a>
        </div>

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
  var rawBase = (typeof BASE_URL !== 'undefined') ? BASE_URL : '<?= base_url(); ?>';
  var _BASE = rawBase.replace(/\/+$/, '') + '/';
  var csrf_name = '<?= $this->security->get_csrf_token_name(); ?>';
  var csrf_hash = '<?= $this->security->get_csrf_hash(); ?>';

  var activeLabelId = '<?= (!empty($active_label_id) && $active_label_id > 0) ? $active_label_id : ''; ?>';
  var activePhone = '<?= htmlspecialchars(!empty($active_phone) ? $active_phone : ''); ?>';
  var autoMsg = '<?= str_replace("'", "\'", (!empty($auto_msg) && $auto_msg !== 'null') ? $auto_msg : ''); ?>';

  var chatPollTimer = null;
  var lastMsgId = 0;
  var isFirstLoad = true;
  var isSending = false;

  function buildPayload(data) {
    if (csrf_name && csrf_hash) data[csrf_name] = csrf_hash;
    return data;
  }

  function parseRes(res) {
    if (typeof res === 'object') return res;
    try { return JSON.parse(res); } catch(e) { return { success: false }; }
  }

  function notify(type, msg) {
    if (typeof toastr !== 'undefined' && typeof toastr[type] === 'function') {
      toastr[type](msg);
    } else {
      alert(msg);
    }
  }

  // Load chat stream for selected conversation
  function selectConversation(labelId, custName, custPhone, custOrder) {
    stopPolling();
    activeLabelId = labelId;
    isFirstLoad = true;
    lastMsgId = 0;

    $('.wa-conv-item').removeClass('active');
    var $activeItem = $('.wa-conv-item[data-label-id="' + labelId + '"]');
    $activeItem.addClass('active');

    // Clear unread visual state on selected item
    $activeItem.removeClass('has-unread').attr('data-unread', '0');
    $activeItem.find('.wa-conv-badge').remove();
    updateUnreadFilterBadge();

    $('#header-cust-name').text(custName || 'Customer');
    
    var isGrp = custPhone && custPhone.indexOf('@g.us') !== -1;
    if (isGrp) {
      $('#header-avatar').html('<i class="fa fa-users" style="font-size:16px;"></i>').css('background', 'linear-gradient(135deg, #0284c7, #0ea5e9)');
      $('#header-cust-phone').text('Grup WhatsApp');
      $('#header-cust-order').text('WhatsApp Group');
      $('#btn-header-profile, #btn-header-rfm').hide();
    } else {
      $('#header-avatar').text((custName || 'C').substring(0, 1).toUpperCase()).css('background', 'linear-gradient(135deg, #10b981, #059669)');
      $('#header-cust-phone').text(custPhone || '-');
      $('#header-cust-order').text(custOrder || '-');
      if (custPhone) {
        $('#btn-header-profile').attr('href', _BASE + 'administrator/crm/customer_detail?phone=' + encodeURIComponent(custPhone)).show();
        $('#btn-header-rfm').attr('href', _BASE + 'administrator/rfm/customer_detail?phone=' + encodeURIComponent(custPhone)).show();
      } else {
        $('#btn-header-profile, #btn-header-rfm').hide();
      }
    }

    // Show action buttons
    $('#btn-close-chat').show();
    $('#btn-back-to-convs').show();

    $('#wa-status-bar, #wa-footer').show();
    if (autoMsg) {
      $('#chat-textarea').val(autoMsg);
      autoMsg = ''; // clear after load
    }

    // Load initial timeline; startPolling will be activated only AFTER timeline loads successfully
    loadStream(labelId, true);

    // Mark all incoming messages for this label as read (clears notification bell)
    $.post(_BASE + 'administrator/crm/mark_notification_read_ajax', buildPayload({ label_id: labelId }));
  }

  // Close active conversation & return to standby WhatsApp Web screen
  function closeConversation() {
    stopPolling();
    activeLabelId = null;
    activePhone = null;
    $('.wa-conv-item').removeClass('active');

    $('#header-avatar').html('<i class="fa fa-user"></i>').css('background', 'linear-gradient(135deg, #64748b, #475569)');
    $('#header-cust-name').text('Pilih Percakapan');
    $('#header-cust-phone').text('-');
    $('#header-cust-order').text('-');
    $('#btn-header-profile, #btn-header-rfm, #btn-close-chat').hide();
    $('#btn-back-to-convs').hide();

    $('#wa-canvas').html(renderWelcomeScreen());
    $('#wa-status-bar, #wa-footer').hide();

    $('#wa-chat-container, .wa-chat-container').removeClass('mobile-chat-open');

    if (window.location.search.indexOf('label_id=') !== -1 || window.location.search.indexOf('phone=') !== -1) {
      window.history.replaceState({}, '', _BASE + 'administrator/crm/chat');
    }
  }

  function renderWelcomeScreen() {
    return '<div class="empty-state" id="empty-chat-state" style="margin:auto;">' +
             '<div style="width:84px; height:84px; border-radius:50%; background:linear-gradient(135deg, #10b981, #059669); display:flex; align-items:center; justify-content:center; color:#fff; font-size:42px; box-shadow:0 8px 24px rgba(16,185,129,0.3); margin-bottom:18px;">' +
               '<i class="fa fa-whatsapp" style="margin-bottom:0; color:#fff; font-size:42px;"></i>' +
             '</div>' +
             '<h3 style="font-weight:700; color:#1e293b; margin:0 0 8px 0; font-size:20px;">WhatsApp Live Chat</h3>' +
             '<p style="font-size:13px; color:#64748b; max-width:420px; line-height:1.6; margin:0 0 16px 0;">' +
               'Pilih salah satu kontak customer di bilah sisi sebelah kiri untuk membuka pesan & membalas percakapan WhatsApp real-time.' +
             '</p>' +
             '<div style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; background:#ffffff; border-radius:20px; font-size:11.5px; color:#475569; border:1px solid #cbd5e1; box-shadow:0 1px 3px rgba(0,0,0,0.05);">' +
               '<i class="fa fa-lock" style="color:#10b981; font-size:12px; margin:0;"></i> Percakapan terenkripsi & tersinkronisasi via WhatsApp Gateway' +
             '</div>' +
           '</div>';
  }

  function loadStream(lid, showSpinner, callback) {
    if (showSpinner) {
      $('#wa-canvas').html('<div class="empty-state"><i class="fa fa-spinner fa-spin"></i><p>Memuat percakapan...</p></div>');
    }

    if (isFirstLoad) {
      $.get(_BASE + 'administrator/crm/get_chat_timeline_ajax', { label_id: lid }, function(res) {
        if (lid !== activeLabelId) return; // User switched to another conversation
        var r = parseRes(res);
        if (r.success) {
          if (r.label) {
            var isG = r.label.customer_phone && r.label.customer_phone.indexOf('@g.us') !== -1;
            $('#header-cust-name').text(r.label.customer_nama || 'Customer');
            if (isG) {
              $('#header-cust-phone').text('Grup WhatsApp');
              $('#header-cust-order').text('WhatsApp Group');
              $('#header-avatar').html('<i class="fa fa-users" style="font-size:16px;"></i>').css('background', 'linear-gradient(135deg, #0284c7, #0ea5e9)');
              $('#btn-header-profile, #btn-header-rfm').hide();
            } else {
              $('#header-cust-phone').text(r.label.customer_phone || '-');
              $('#header-cust-order').text(r.label.no_pesanan || '-');
            }
            // Always sync status from server (realtime)
            var serverStatus = r.label.status_label || '';
            if ($('#chat-status-select').val() !== serverStatus) {
              $('#chat-status-select').val(serverStatus);
            }
          }
          renderCanvas(r.timeline || []);
          if (r.timeline && r.timeline.length > 0) {
            for (var i = 0; i < r.timeline.length; i++) {
              var tid = parseInt(r.timeline[i].id || 0);
              if (tid > lastMsgId) lastMsgId = tid;
            }
            // Always sync left sidebar with the actual latest message on the right pane!
            var lastTimelineItem = r.timeline[r.timeline.length - 1];
            if (lastTimelineItem && lastTimelineItem.message) {
              updateSidebarConversation(lid, lastTimelineItem.message, lastTimelineItem.created_at);
            }
          }
          if (r.max_id && parseInt(r.max_id) > lastMsgId) {
            lastMsgId = parseInt(r.max_id);
          }
          isFirstLoad = false;
          // Start polling ONLY now, after full timeline is loaded & lastMsgId established
          startPolling(lid);
        } else {
          $('#wa-canvas').html('<div class="empty-state"><i class="fa fa-exclamation-triangle" style="color:#f59e0b;"></i><p>Gagal memuat timeline: ' + (r.message || 'Unknown error') + '</p></div>');
        }
      }).fail(function(xhr, status, err) {
        if (lid !== activeLabelId) return;
        $('#wa-canvas').html('<div class="empty-state"><i class="fa fa-exclamation-triangle" style="color:#ef4444;"></i><p>Koneksi gagal</p></div>');
      }).always(function() {
        if (typeof callback === 'function') callback();
      });
    } else {
      if (lastMsgId <= 0) {
        if (typeof callback === 'function') callback();
        return;
      }
      var prevLastMsgId = lastMsgId;
      $.get(_BASE + 'administrator/crm/get_new_messages_ajax', { label_id: lid, last_id: lastMsgId }, function(res) {
        if (lid !== activeLabelId) return;
        var r = parseRes(res);
        if (r.success && r.messages && r.messages.length > 0) {
          appendMessages(r.messages);
          var hasIncoming = false;
          var lastIncomingText = '';
          var lastIncomingSender = '';
          for (var i = 0; i < r.messages.length; i++) {
            var m = r.messages[i];
            var mid = parseInt(m.id || 0);
            if (mid > lastMsgId) lastMsgId = mid;
            // Only trigger alert for strictly NEW, UNREAD incoming messages received in real-time
            if ((m.direction === 'incoming' || m.direction === 'in') &&
                m.status_kirim !== 'read' &&
                mid > prevLastMsgId &&
                prevLastMsgId > 0 &&
                !isFirstLoad) {
              hasIncoming = true;
              lastIncomingText = m.message || '';
              lastIncomingSender = m.sender || 'Customer';
            }
          }

          // Always sync sidebar with the newest message in this batch
          var newestBatchMsg = r.messages[r.messages.length - 1];
          if (newestBatchMsg && newestBatchMsg.message) {
            updateSidebarConversation(lid, newestBatchMsg.message, newestBatchMsg.created_at);
          }

          if (hasIncoming) {
            playChatChime();
            if (typeof toastr !== 'undefined') {
              toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 8000 };
              toastr.info('<b>' + htmlEntities(lastIncomingSender) + '</b><br>' + htmlEntities(lastIncomingText.substring(0, 70)), '💬 Balasan WhatsApp Masuk');
            }
            if (window.Notification && Notification.permission === 'granted') {
              try {
                new Notification('💬 ' + lastIncomingSender, {
                  body: lastIncomingText.substring(0, 80),
                  icon: _BASE + 'asset/img/icon-wide.png'
                });
              } catch(e) {}
            }
            flashPageTitle('💬 Balasan: ' + lastIncomingSender);
          }
        }
        // Sync status from server on every poll cycle
        if (r.success && r.label && r.label.status_label) {
          var srvSt = r.label.status_label;
          if ($('#chat-status-select').val() !== srvSt) {
            $('#chat-status-select').val(srvSt);
          }
        }
      }).always(function() {
        if (typeof callback === 'function') callback();
      });
    }
  }

  function renderCanvas(timeline) {
    var $canvas = $('#wa-canvas');
    if (!timeline || timeline.length === 0) {
      $canvas.html('<div class="empty-state"><i class="fa fa-comments-o"></i><p>Belum ada percakapan.<br>Ketik pesan di bawah untuk memulai balasan WhatsApp.</p></div>');
      return;
    }

    var html = '';
    var lastDate = '';
    $.each(timeline, function(i, item) {
      var itemDate = (item.created_at || '').substring(0, 10);
      if (itemDate && itemDate !== lastDate) {
        var d = new Date(itemDate + 'T00:00:00');
        var today = new Date(); today.setHours(0,0,0,0);
        var dateLabel = (d.getTime() === today.getTime()) ? 'Hari Ini' : itemDate;
        html += '<div class="chat-date-separator" data-chat-date="' + itemDate + '">' + dateLabel + '</div>';
        lastDate = itemDate;
      }
      html += renderBubble(item);
    });
    $canvas.html(html);
    $canvas.scrollTop($canvas[0].scrollHeight);
  }

  function appendMessages(msgs) {
    var $canvas = $('#wa-canvas');
    if ($canvas.find('.empty-state').length) {
      $canvas.html('');
    }
    $.each(msgs, function(i, item) {
      var mid = parseInt(item.id || 0);
      if (mid > 0 && $canvas.find('.chat-bubble[data-msg-id="' + mid + '"]').length) {
        return; // skip duplicate bubble
      }
      $canvas.append(renderBubble(item));
    });
    $canvas.scrollTop($canvas[0].scrollHeight);
  }

  function renderBubble(item) {
    // Skip duplicate echo bubbles of outgoing messages sent via Fonnte
    if (item.direction === 'incoming' && item.message && (item.message.indexOf('Sent via fonnte.com') !== -1 || item.message.indexOf('fonnte.com') !== -1)) {
      return '';
    }

    var isNote = (parseInt(item.is_internal_note || 0) === 1);
    var isOut = (item.direction === 'out' || item.direction === 'outgoing');

    var cls = isNote ? 'bubble-note' : (isOut ? 'bubble-outgoing' : 'bubble-incoming');
    var rawText = item.message || '';
    var formattedText = formatChatMessage(rawText);

    var senderName = item.sender_name || (isOut ? 'Customer Service' : 'Customer');
    var senderHtml = isOut ? '' : '<div class="bubble-sender">' + htmlEntities(senderName) + '</div>';
    if (isNote) {
      senderHtml = '<div class="bubble-sender"><i class="fa fa-bookmark"></i> Catatan Internal (' + htmlEntities(senderName) + ')</div>';
    }

    var time = item.created_at ? item.created_at.substring(11, 16) : '';
    var tick = (isOut && !isNote) ? '<i class="fa fa-check text-success" style="font-size:10px;"></i>' : '';
    var mid = parseInt(item.id || 0);

    return '<div class="chat-bubble ' + cls + '" data-msg-id="' + mid + '">' +
             '<button class="btn-reply-msg" data-sender="' + htmlEntities(senderName) + '" data-msg="' + htmlEntities(rawText) + '" title="Balas pesan ini"><i class="fa fa-reply"></i></button>' +
             senderHtml +
             '<div class="bubble-text">' + formattedText + '</div>' +
             '<div class="bubble-time">' + time + ' ' + tick + '</div>' +
           '</div>';
  }

  function formatChatMessage(msg) {
    if (!msg) return '';
    var text = $('<div>').text(msg).html();
    
    // Pre-detect context labels before URL processing (for URLs without extensions)
    var contextType = '';
    if (/\[Foto\]/i.test(text)) contextType = 'image';
    else if (/\[Video\]/i.test(text)) contextType = 'video';
    else if (/\[Pesan Suara\]|\[Voice Note\]/i.test(text)) contextType = 'audio';
    else if (/\[Dokumen PDF\]/i.test(text)) contextType = 'pdf';
    else if (/\[Dokumen\]|\[Dokumen Arsip\]/i.test(text)) contextType = 'document';

    // Match URLs (https, http, and relative uploads paths)
    var urlRegex = /(https?:\/\/[^\s<]+|(?:\/|\b)uploads\/[^\s<]+)/gi;
    
    text = text.replace(urlRegex, function(url) {
      var cleanUrl = url.trim();
      // Detect by file extension first
      var isImg = /\.(jpeg|jpg|gif|png|webp|bmp|svg)(\?.*)?$/i.test(cleanUrl);
      var isVideo = /\.(mp4|avi|mov|mkv|3gp|webm)(\?.*)?$/i.test(cleanUrl);
      var isAudio = /\.(mp3|ogg|wav|m4a|aac|opus)(\?.*)?$/i.test(cleanUrl);
      var isDoc = /\.(pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar|txt|csv)(\?.*)?$/i.test(cleanUrl);

      // Fallback: use context label if extension not detected (e.g. Fonnte storage URL)
      if (!isImg && !isVideo && !isAudio && !isDoc && contextType) {
        if (contextType === 'image') isImg = true;
        else if (contextType === 'video') isVideo = true;
        else if (contextType === 'audio') isAudio = true;
        else if (contextType === 'pdf' || contextType === 'document') isDoc = true;
      }

      // Fallback 2: detect Fonnte/WA storage URL patterns
      if (!isImg && !isVideo && !isAudio && !isDoc) {
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
    text = text.replace(/\[Dokumen PDF\]:\s*/gi, '');
    text = text.replace(/\[Dokumen\]:\s*/gi, '');
    text = text.replace(/\[Dokumen Arsip\]:\s*/gi, '');
    text = text.replace(/\[Voice Note\]:\s*/gi, '');
    text = text.replace(/\[Pesan Suara\]:\s*/gi, '');

    // Render WhatsApp quote blocks
    text = text.replace(/(?:^|<br>)(?:&gt;|>)\s*\*Membalas ([^*]+)\*:\s*(?:&quot;|")([^"\n<]+)(?:&quot;|")(?:\s*<br>|\s*\n)?/gi, function(m, qSender, qText) {
      return '<div style="background:rgba(0,168,132,0.12);border-left:3.5px solid #00a884;padding:4px 8px;border-radius:6px;font-size:11px;margin-bottom:6px;color:#1e293b;">' +
               '<div style="font-weight:700;color:#00a884;font-size:10.5px;"><i class="fa fa-reply"></i> Membalas ' + $('<div>').text(qSender).html() + '</div>' +
               '<div style="color:#475569;font-size:10.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:240px;">' + $('<div>').text(qText).html() + '</div>' +
             '</div>';
    });

    return text.replace(/\n/g, '<br>');
  }

  function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  // Web Audio WhatsApp Notification Chime
  var chatAudioCtx = null;
  function getChatAudioCtx() {
    try {
      if (!chatAudioCtx) {
        var AudioCtx = window.AudioContext || window.webkitAudioContext;
        if (AudioCtx) chatAudioCtx = new AudioCtx();
      }
      if (chatAudioCtx && chatAudioCtx.state === 'suspended') {
        chatAudioCtx.resume();
      }
    } catch(e) {}
    return chatAudioCtx;
  }

  // Ensure AudioContext is unlocked and requested on ANY user action
  $(document).on('click keydown touchstart', function() {
    getChatAudioCtx();
  });

  function playChatChime() {
    try {
      var ctx = getChatAudioCtx();
      if (!ctx) return;
      if (ctx.state === 'suspended') {
        ctx.resume().then(function() {
          _executeChime(ctx);
        }).catch(function() {
          _executeChime(ctx);
        });
      } else {
        _executeChime(ctx);
      }
    } catch(e) {}
  }

  function _executeChime(ctx) {
    try {
      var now = ctx.currentTime;
      var osc = ctx.createOscillator();
      var gain = ctx.createGain();
      osc.type = 'sine';
      // Crisp 3-tone WhatsApp melodic ping: E6 (1318 Hz) -> A6 (1760 Hz) -> B6 (1975 Hz)
      osc.frequency.setValueAtTime(1318.5, now);
      osc.frequency.exponentialRampToValueAtTime(1760.0, now + 0.08);
      osc.frequency.exponentialRampToValueAtTime(1975.5, now + 0.16);
      gain.gain.setValueAtTime(0.65, now);
      gain.gain.exponentialRampToValueAtTime(0.01, now + 0.45);
      osc.connect(gain);
      gain.connect(ctx.destination);
      osc.start(now);
      osc.stop(now + 0.45);
    } catch(e) {}
  }

  function updateSidebarConversation(lid, lastText, customTime) {
    if (!lid) return;
    var $item = $('.wa-conv-item[data-label-id="' + lid + '"]');
    if (!$item.length && activePhone) {
      $item = $('.wa-conv-item[data-phone="' + activePhone + '"]');
    }
    if ($item.length) {
      var timeFormatted = '';
      if (customTime && customTime.length >= 16) {
        timeFormatted = customTime.substring(8, 10) + '/' + customTime.substring(5, 7) + ' ' + customTime.substring(11, 16);
      } else {
        var nowTime = new Date();
        var hours = ('0' + nowTime.getHours()).slice(-2);
        var mins = ('0' + nowTime.getMinutes()).slice(-2);
        timeFormatted = ('0' + nowTime.getDate()).slice(-2) + '/' + ('0' + (nowTime.getMonth() + 1)).slice(-2) + ' ' + hours + ':' + mins;
      }
      $item.find('.wa-conv-time').text(timeFormatted);
      $item.find('.wa-conv-msg span:first-child').text(lastText || '');
      $item.prependTo('#wa-conv-list');
    }
  }

  var originalDocTitle = document.title;
  var titleBlinkTimer = null;
  function flashPageTitle(text) {
    if (document.hasFocus()) return;
    if (titleBlinkTimer) clearInterval(titleBlinkTimer);
    var state = false;
    titleBlinkTimer = setInterval(function() {
      document.title = state ? text : originalDocTitle;
      state = !state;
    }, 1000);
  }
  $(window).on('focus click', function() {
    if (titleBlinkTimer) {
      clearInterval(titleBlinkTimer);
      titleBlinkTimer = null;
      document.title = originalDocTitle;
    }
  });

  // Adaptive sub-second polling (600ms focused, 1500ms background) with in-flight lock
  var isPollingStream = false;
  var chatPollTimer = null;

  function scheduleNextPoll(delayMs) {
    if (chatPollTimer) clearTimeout(chatPollTimer);
    chatPollTimer = setTimeout(function() {
      if (!activeLabelId || isSending) {
        scheduleNextPoll(1000);
        return;
      }
      runPollStream();
    }, delayMs !== undefined ? delayMs : 600);
  }

  function runPollStream() {
    if (isPollingStream || !activeLabelId || isSending) {
      scheduleNextPoll(600);
      return;
    }
    isPollingStream = true;
    loadStream(activeLabelId, false, function() {
      isPollingStream = false;
      var nextDelay = document.hasFocus() ? 600 : 1500;
      scheduleNextPoll(nextDelay);
    });
  }

  function startPolling(lid) {
    stopPolling();
    scheduleNextPoll(300);
  }

  function stopPolling() {
    if (chatPollTimer) { clearTimeout(chatPollTimer); chatPollTimer = null; }
    isPollingStream = false;
  }

  // Periodic sidebar sync with real database counts (every 3.5s)
  setInterval(function() {
    $.getJSON(_BASE + 'administrator/crm/get_conversations_ajax', { q: $('#input-search-conv').val() || '' }, function(res) {
      if (res && res.success && res.conversations) {
        var hasChanges = false;
        var needsFullReload = false;
        $.each(res.conversations, function(i, conv) {
          var unread = parseInt(conv.unread_count || 0);
          // If this is currently the active conversation being viewed, count is 0
          if (activeLabelId && conv.label_id == activeLabelId) {
            unread = 0;
          }

          var $item = $('.wa-conv-item[data-label-id="' + conv.label_id + '"]');
          if (!$item.length && conv.customer_phone) {
            $item = $('.wa-conv-item[data-phone="' + conv.customer_phone + '"]');
          }

          if ($item.length) {
            var curUnread = parseInt($item.attr('data-unread') || 0);
            if (curUnread !== unread) {
              $item.attr('data-unread', unread);
              if (unread > 0) {
                $item.addClass('has-unread');
                if (!$item.find('.wa-conv-badge').length) {
                  $item.append('<span class="wa-conv-badge">' + unread + '</span>');
                } else {
                  $item.find('.wa-conv-badge').text(unread);
                }
              } else {
                $item.removeClass('has-unread');
                $item.find('.wa-conv-badge').remove();
              }
              hasChanges = true;
            }

            // Sync last message text and timestamp
            if (conv.last_message && $item.find('.wa-conv-msg span:first-child').text() !== conv.last_message) {
              $item.find('.wa-conv-msg span:first-child').text(conv.last_message);
              if (conv.last_message_at && conv.last_message_at.length >= 16) {
                var timeStr = conv.last_message_at.substring(8, 10) + '/' + conv.last_message_at.substring(5, 7) + ' ' + conv.last_message_at.substring(11, 16);
                $item.find('.wa-conv-time').text(timeStr);
              }
              hasChanges = true;
            }
          } else if (unread > 0) {
            // New incoming customer not yet in DOM: trigger full reload
            needsFullReload = true;
          }
        });

        if (needsFullReload) {
          reloadConversationList($('#input-search-conv').val());
        } else if (hasChanges) {
          updateUnreadFilterBadge();
          applyConversationFilters();
        }
      }
    });
  }, 3500);

  // Conversation item click
  $(document).on('click', '.wa-conv-item', function() {
    var lid = $(this).attr('data-label-id');
    var name = $(this).attr('data-nama');
    var phone = $(this).attr('data-phone');
    var order = $(this).attr('data-order') || '';
    if (lid) {
      $('#wa-chat-container, .wa-chat-container').addClass('mobile-chat-open');
      if ($(window).width() <= 991 && $('#wa-chat-container').length) {
        $('html, body').animate({ scrollTop: $('#wa-chat-container').offset().top - 10 }, 200);
      }
      selectConversation(lid, name, phone, order);
    }
  });

  // Mobile back button to conversation list
  $(document).on('click', '#btn-back-to-convs', function(e) {
    e.preventDefault();
    closeConversation();
    if ($(window).width() <= 991 && $('#wa-chat-container').length) {
      $('html, body').animate({ scrollTop: $('#wa-chat-container').offset().top - 10 }, 200);
    }
  });

  // Desktop close chat button
  $(document).on('click', '#btn-close-chat', function(e) {
    e.preventDefault();
    closeConversation();
  });

  // Test Sound & Notification Button Click
  $(document).on('click', '#btn-test-notif', function() {
    getChatAudioCtx();
    playChatChime();
    if (typeof toastr !== 'undefined') {
      toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 6000 };
      toastr.success('<b>Suara & Notifikasi Aktif!</b><br>Sistem siap menerima balasan WhatsApp secara real-time.', '🔔 WhatsApp Live Chat');
    }
    if (window.Notification) {
      if (Notification.permission === 'granted') {
        try {
          new Notification('🔔 Tes Notifikasi CRM', {
            body: 'Notifikasi desktop aktif dan siap digunakan!',
            icon: _BASE + 'asset/img/icon-wide.png'
          });
        } catch(e) {}
      } else if (Notification.permission !== 'denied') {
        Notification.requestPermission().then(function(perm) {
          if (perm === 'granted') {
            new Notification('🔔 Notifikasi Diizinkan!', {
              body: 'Notifikasi desktop sekarang sudah aktif.',
              icon: _BASE + 'asset/img/icon-wide.png'
            });
          }
        });
      }
    }
  });

  // Fullscreen Toggle
  $(document).on('click', '#btn-toggle-fullscreen', function() {
    var $c = $('#wa-chat-container');
    $c.toggleClass('wa-fullscreen');
    if ($c.hasClass('wa-fullscreen')) {
      $(this).find('i').removeClass('fa-arrows-alt').addClass('fa-compress');
      $(this).attr('title', 'Kecilkan Layar');
    } else {
      $(this).find('i').removeClass('fa-compress').addClass('fa-arrows-alt');
      $(this).attr('title', 'Layar Penuh');
    }
  });

  // Popover Toggles
  $(document).on('click', '#btn-toggle-emoji', function(e) {
    e.stopPropagation();
    $('#wa-attach-popover, #wa-template-popover').hide();
    $('#wa-emoji-popover').toggle();
  });

  $(document).on('click', '#btn-toggle-attach', function(e) {
    e.stopPropagation();
    $('#wa-emoji-popover, #wa-template-popover').hide();
    $('#wa-attach-popover').toggle();
  });

  $(document).on('click', '#btn-toggle-template', function(e) {
    e.stopPropagation();
    $('#wa-emoji-popover, #wa-attach-popover').hide();
    var $pop = $('#wa-template-popover');
    $pop.toggle();
    if ($pop.is(':visible')) {
      loadTemplates();
    }
  });

  $(document).on('click', function() {
    $('#wa-emoji-popover, #wa-attach-popover, #wa-template-popover').hide();
  });

  $(document).on('click', '#wa-emoji-popover, #wa-attach-popover, #wa-template-popover', function(e) {
    e.stopPropagation();
  });

  // Emoji Click (inserts at current cursor position)
  $(document).on('click', '.wa-emoji-item', function() {
    var emoji = $(this).text();
    var textarea = document.getElementById('chat-textarea');
    if (!textarea) return;
    var start = (typeof textarea.selectionStart === 'number') ? textarea.selectionStart : textarea.value.length;
    var end = (typeof textarea.selectionEnd === 'number') ? textarea.selectionEnd : textarea.value.length;
    var val = textarea.value;
    textarea.value = val.substring(0, start) + emoji + val.substring(end);
    textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
    textarea.focus();
    $('#wa-emoji-popover').hide();
  });

  // Attach Options Click
  $(document).on('click', '#attach-option-photo', function() {
    $('#wa-attach-popover').hide();
    $('#file-upload-input').attr('accept', 'image/*,.jpg,.jpeg,.png,.webp,.gif').click();
  });

  $(document).on('click', '#attach-option-doc', function() {
    $('#wa-attach-popover').hide();
    $('#file-upload-input').attr('accept', '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.txt,.csv,.mp3,.ogg,.wav,.m4a,.aac,.opus,.webm').click();
  });

  $(document).on('click', '#attach-option-url', function() {
    $('#wa-attach-popover').hide();
    $('#wa-url-input-container').slideToggle(150);
  });

  function formatBytes(bytes, decimals) {
    if (!bytes || bytes === 0) return '0 B';
    decimals = (typeof decimals !== 'undefined') ? decimals : 1;
    var k = 1024;
    var dm = decimals < 0 ? 0 : decimals;
    var sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
  }

  $(document).on('click', '#btn-apply-url', function() {
    var url = $.trim($('#input-attach-url').val());
    if (url) {
      $('#note-file-url').val(url);
      var urlFileName = url.split('/').pop().split('?')[0] || url;
      var isImgUrl = /\.(jpeg|jpg|png|webp|gif|bmp|svg)(\?.*)?$/i.test(url);

      $('#wa-preview-filename').text(urlFileName);
      $('#wa-preview-filesize').text('URL Link');
      $('#wa-preview-status').html('<span class="text-success"><i class="fa fa-check-circle"></i> Siap dikirim</span>');

      if (isImgUrl) {
        $('#wa-preview-thumb-img').attr('src', url).show();
        $('#wa-preview-thumb-icon').hide();
        $('#btn-quick-preview-staged').data('preview-src', url).data('preview-type', 'image').show();
      } else {
        $('#wa-preview-thumb-img').hide();
        $('#wa-preview-thumb-icon').html('<i class="fa fa-link" style="color:#0284c7;font-size:22px;"></i>').show();
        $('#btn-quick-preview-staged').data('preview-src', url).data('preview-type', 'auto').show();
      }

      $('#wa-attachment-preview-box').slideDown(150);
      $('#wa-attachment-chip').hide();
      $('#wa-url-input-container').slideUp(150);
    }
  });

  // File Upload Handler (Interactive Preview Before Send)
  $(document).on('change', '#file-upload-input', function() {
    var file = this.files[0];
    if (!file) return;

    var fileName = file.name;
    var fileSize = formatBytes(file.size);
    var isImg = (file.type && file.type.indexOf('image/') !== -1) || /\.(jpeg|jpg|png|webp|gif|bmp)$/i.test(fileName);
    var isPdf = (file.type === 'application/pdf') || /\.pdf$/i.test(fileName);
    var isDoc = /\.(doc|docx|xls|xlsx|ppt|pptx|zip|rar)$/i.test(fileName);
    var isAudio = (file.type && file.type.indexOf('audio/') !== -1) || /\.(mp3|wav|ogg|m4a|aac)$/i.test(fileName);
    var isVideo = (file.type && file.type.indexOf('video/') !== -1) || /\.(mp4|webm|avi|mov)$/i.test(fileName);

    // Show preview box immediately
    $('#wa-preview-filename').text(fileName);
    $('#wa-preview-filesize').text(fileSize);
    $('#wa-preview-status').html('<i class="fa fa-spinner fa-spin text-primary"></i> Mengunggah...');
    $('#btn-quick-preview-staged').hide();
    $('#wa-attachment-preview-box').slideDown(150);

    // Instant local thumbnail preview using FileReader / ObjectURL
    if (isImg && typeof FileReader !== 'undefined') {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#wa-preview-thumb-img').attr('src', e.target.result).show();
        $('#wa-preview-thumb-icon').hide();
        $('#btn-quick-preview-staged').data('preview-src', e.target.result).data('preview-type', 'image').show();
      };
      reader.readAsDataURL(file);
    } else {
      $('#wa-preview-thumb-img').hide();
      var iconClass = 'fa-file-text-o';
      var badgeColor = '#0284c7';
      if (isPdf) { iconClass = 'fa-file-pdf-o'; badgeColor = '#dc2626'; }
      else if (/\.(doc|docx)/i.test(fileName)) { iconClass = 'fa-file-word-o'; badgeColor = '#2563eb'; }
      else if (/\.(xls|xlsx)/i.test(fileName)) { iconClass = 'fa-file-excel-o'; badgeColor = '#059669'; }
      else if (/\.(zip|rar)/i.test(fileName)) { iconClass = 'fa-file-archive-o'; badgeColor = '#7c3aed'; }
      else if (isAudio) { iconClass = 'fa-music'; badgeColor = '#0d9488'; }
      else if (isVideo) { iconClass = 'fa-film'; badgeColor = '#7c3aed'; }

      $('#wa-preview-thumb-icon').html('<i class="fa ' + iconClass + '" style="color:' + badgeColor + ';font-size:24px;"></i>').show();

      if (isPdf && typeof URL !== 'undefined' && URL.createObjectURL) {
        try {
          var pdfObjUrl = URL.createObjectURL(file);
          $('#btn-quick-preview-staged').data('preview-src', pdfObjUrl).data('preview-type', 'pdf').show();
        } catch(e) {}
      }
    }

    notify('info', 'Mengunggah ' + fileName + '...');

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
          $('#note-file-url').val(r.file_url);
          $('#wa-preview-status').html('<span class="text-success"><i class="fa fa-check-circle"></i> Siap dikirim</span>');
          $('#btn-quick-preview-staged').data('preview-src', r.file_url).show();
          notify('success', 'File siap dikirim!');
        } else {
          $('#wa-attachment-preview-box').slideUp(150);
          $('#note-file-url').val('');
          notify('error', r.message || 'Gagal mengunggah file');
        }
      },
      error: function() {
        $('#wa-attachment-preview-box').slideUp(150);
        $('#note-file-url').val('');
        notify('error', 'Gagal mengunggah file ke server');
      }
    });

    $(this).val(''); // Reset file input agar bisa upload ulang file yang sama
  });

  $(document).on('click', '#btn-remove-attachment', function() {
    $('#note-file-url').val('');
    $('#wa-attachment-preview-box').slideUp(150);
    $('#wa-attachment-chip').hide();
  });

  $(document).on('click', '#btn-quick-preview-staged', function() {
    var src = $(this).data('preview-src') || $('#note-file-url').val();
    var type = $(this).data('preview-type') || 'auto';
    var title = $('#wa-preview-filename').text();
    openMediaPreview(src, type, title);
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

  // Load Templates
  function loadTemplates() {
    $.get(_BASE + 'administrator/crm/get_templates_ajax', { label_id: activeLabelId }, function(res) {
      var r = parseRes(res);
      if (r.success && r.templates && r.templates.length > 0) {
        var html = '';
        $.each(r.templates, function(i, tpl) {
          html += '<div class="wa-template-item" data-text="' + htmlEntities(tpl.template_rendered || tpl.template_raw) + '">' +
                    '<div class="tpl-title">' + htmlEntities(tpl.nama) + ' (H+' + tpl.jumlah_hari + ')</div>' +
                    '<div class="tpl-preview">' + htmlEntities(tpl.template_rendered || tpl.template_raw) + '</div>' +
                  '</div>';
        });
        $('#wa-template-list').html(html);
      } else {
        $('#wa-template-list').html('<div style="text-align:center; padding:10px; color:#94a3b8; font-size:11px;">Tidak ada template ditemukan.</div>');
      }
    });
  }

  $(document).on('click', '.wa-template-item', function() {
    var text = $(this).attr('data-text');
    if (text) {
      $('#chat-textarea').val(text).focus();
      $('#wa-template-popover').hide();
    }
  });

  // Reply Msg Handler
  $(document).on('click', '.btn-reply-msg', function(e) {
    e.stopPropagation();
    var sender = $(this).attr('data-sender') || 'Pesan';
    var rawMsg = $(this).attr('data-msg') || '';
    
    var cleanMsg = rawMsg.replace(/\[Lampiran[^\]]+\]:\s*/gi, '').replace(/https?:\/\/[^\s]+/gi, '[Lampiran File]').trim();
    if (cleanMsg.length > 70) cleanMsg = cleanMsg.substring(0, 70) + '...';
    if (!cleanMsg) cleanMsg = '[Lampiran File]';

    $('#wa-reply-sender-name').text(sender);
    $('#wa-reply-text-preview').text(cleanMsg);
    $('#wa-reply-preview-bar').slideDown(150);
    $('#chat-textarea').focus();
  });

  $(document).on('click', '#btn-cancel-reply', function() {
    $('#wa-reply-preview-bar').slideUp(100);
    $('#wa-reply-sender-name').text('');
    $('#wa-reply-text-preview').text('');
  });

  // Mode Toggle (Balasan CS vs Catatan Internal)
  $(document).on('click', '.btn-toggle-sender', function() {
    $('.btn-toggle-sender').css({ border: '2px solid #e2e8f0', background: '#fff', color: '#64748b' }).removeClass('active');
    $(this).css({ border: '2px solid #25D366', background: '#d9fdd3', color: '#15803d' }).addClass('active');
    var type = $(this).data('type');
    if (type === 'cs_chat') {
      $('#chat-textarea').attr('placeholder', 'Ketik balasan CS ke WhatsApp customer...');
    } else {
      $('#chat-textarea').attr('placeholder', 'Tulis catatan internal (hanya terlihat oleh tim CS)...');
    }
  });

  // Send Message
  $(document).on('click', '#btn-send-chat', function() {
    sendMessage();
  });

  $('#chat-textarea').on('keydown', function(e) {
    if (e.keyCode === 13 && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });

  function sendMessage() {
    // Anti-double-send guard
    if (isSending) return;

    var msg = $.trim($('#chat-textarea').val());
    var fileUrl = $.trim($('#note-file-url').val());

    if (!msg && !fileUrl) {
      // Nothing to send
      if (!activeLabelId) return;
      return;
    }

    // Attach reply quote if present
    if ($('#wa-reply-preview-bar').is(':visible')) {
      var qSender = $('#wa-reply-sender-name').text();
      var qText = $('#wa-reply-text-preview').text();
      if (msg) {
        msg = '> *Membalas ' + qSender + '*: "' + qText + '"\n' + msg;
      }
    }

    if (!activeLabelId) return;

    var isNote = ($('.btn-toggle-sender.active').data('type') === 'cs_note') ? 1 : 0;
    var $btn = $('#btn-send-chat');

    // Lock: prevent double send
    isSending = true;
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

    $.post(_BASE + 'administrator/crm/send_message_ajax', buildPayload({
      label_id: activeLabelId,
      message: msg || '',
      file_url: fileUrl || '',
      is_internal_note: isNote
    }), function(res) {
      var r = parseRes(res);
      if (r.success) {
        // Clear inputs
        $('#chat-textarea').val('');
        $('#note-file-url').val('');
        $('#wa-attachment-preview-box').slideUp(150);
        $('#wa-attachment-chip').hide();
        $('#wa-url-input-container').slideUp(100);
        $('#btn-cancel-reply').click();

        // Show notification
        if (r.send_error) {
          notify('warning', r.message);
        } else {
          notify('success', r.message || 'Pesan berhasil dikirim');
        }

        // Open wa_link for wa_direct mode
        if (r.wa_link && !isNote) {
          window.open(r.wa_link, '_blank');
        }

        // Immediately update left sidebar snippet so it stays 100% in sync with what CS just sent!
        updateSidebarConversation(activeLabelId, msg);

        // Force full timeline reload to show the new message immediately
        stopPolling();
        isFirstLoad = true;
        loadStream(activeLabelId, false);
      } else {
        notify('error', r.message || 'Gagal mengirim pesan');
      }
    }).fail(function() {
      notify('error', 'Gagal menghubungi server');
    }).always(function() {
      // Unlock: allow sending again
      isSending = false;
      $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i>');
    });
  }

  // Update Status
  $(document).on('change', '#chat-status-select', function() {
    var st = $(this).val();
    if (!activeLabelId || !st) return;

    $.post(_BASE + 'administrator/crm/update_status_ajax', buildPayload({
      label_id: activeLabelId,
      status: st
    }), function(res) {
      var r = parseRes(res);
      if (r.success) notify('success', 'Status diperbarui');
    });
  });

  // Update unread count badge on "Belum Dibaca" tab
  function updateUnreadFilterBadge() {
    var totalUnread = 0;
    $('.wa-conv-item').each(function() {
      var unread = parseInt($(this).attr('data-unread') || 0);
      if (unread > 0 || $(this).find('.wa-conv-badge').length > 0) {
        totalUnread++;
      }
    });
    var $badge = $('#badge-unread-total');
    if (totalUnread > 0) {
      $badge.text(totalUnread).show();
    } else {
      $badge.text('0').hide();
    }
  }

  // Active filter tab state ('all' or 'unread')
  var activeFilterTab = 'all';

  $(document).on('click', '.btn-filter-tab', function() {
    $('.btn-filter-tab').removeClass('active');
    $(this).addClass('active');
    activeFilterTab = $(this).data('filter') || 'all';
    applyConversationFilters();
  });

  // Unified filter function for Search input + Tabs
  function applyConversationFilters() {
    var rawQ = $.trim($('#input-search-conv').val()).toLowerCase();
    var cleanQ = rawQ.replace(/[^0-9]/g, '');
    var altPhoneQ = '';
    if (cleanQ.length >= 3) {
      if (cleanQ.indexOf('08') === 0) altPhoneQ = '628' + cleanQ.substring(2);
      else if (cleanQ.indexOf('628') === 0) altPhoneQ = '08' + cleanQ.substring(3);
    }

    var visibleCount = 0;
    $('.wa-conv-item').each(function() {
      var $item = $(this);
      var unread = parseInt($item.attr('data-unread') || 0);
      var hasBadge = $item.find('.wa-conv-badge').length > 0;
      var isUnread = (unread > 0 || hasBadge);

      // Filter by tab
      if (activeFilterTab === 'unread' && !isUnread) {
        $item.hide();
        return;
      }

      // Filter by search query
      if (rawQ) {
        var text = $item.text().toLowerCase();
        var phone = ($item.attr('data-phone') || '').toLowerCase();
        var cleanPhone = phone.replace(/[^0-9]/g, '');
        var match = (text.indexOf(rawQ) !== -1) || (phone.indexOf(rawQ) !== -1);
        if (!match && cleanQ.length >= 3) {
          if (cleanPhone.indexOf(cleanQ) !== -1) match = true;
          if (altPhoneQ && cleanPhone.indexOf(altPhoneQ) !== -1) match = true;
        }
        if (!match) {
          $item.hide();
          return;
        }
      }

      $item.show();
      visibleCount++;
    });

    return visibleCount;
  }

  function formatSidebarSnippet(msg) {
    if (!msg) return '';
    var s = String(msg);
    if (/\[Foto\]/i.test(s)) {
      var cap = s.replace(/\[Foto\]:?\s*https?:\/\/[^\s<]+/gi, '').replace(/\[Foto\]/gi, '').trim();
      return '📷 Foto' + (cap ? ': ' + cap : '');
    }
    if (/\[Video\]/i.test(s)) {
      var cap = s.replace(/\[Video\]:?\s*https?:\/\/[^\s<]+/gi, '').replace(/\[Video\]/gi, '').trim();
      return '🎥 Video' + (cap ? ': ' + cap : '');
    }
    if (/\[Pesan Suara\]|\[Voice Note\]/i.test(s)) {
      return '🎤 Pesan Suara';
    }
    if (/\[Dokumen/i.test(s)) {
      var cap = s.replace(/\[Dokumen[^\]]*\]:?\s*https?:\/\/[^\s<]+/gi, '').replace(/\[Dokumen[^\]]*\]/gi, '').trim();
      return '📄 Dokumen' + (cap ? ': ' + cap : '');
    }
    return s;
  }

  function updateSidebarConversation(lid, msg, createdAt) {
    if (!lid) return;
    var $item = $('.wa-conv-item[data-label-id="' + lid + '"]');
    if ($item.length) {
      if (msg) {
        $item.find('.wa-conv-snip-text').text(formatSidebarSnippet(msg));
      }
      if (createdAt) {
        var timeStr = createdAt.substring(8, 10) + '/' + createdAt.substring(5, 7) + ' ' + createdAt.substring(11, 16);
        $item.find('.wa-conv-time').text(timeStr);
      }
      $item.prependTo('#wa-conv-list');
    }
  }

  // Reload conversation list dynamically via AJAX
  function reloadConversationList(q, onDone) {
    var $list = $('#wa-conv-list');
    $.getJSON(_BASE + 'administrator/crm/get_conversations_ajax', { q: q || '' }, function(res) {
      if (res && res.success && res.conversations) {
        if (res.conversations.length === 0) {
          $list.html('<li style="padding: 30px 20px; text-align: center; color: #94a3b8; font-size: 13px;">Tidak ada percakapan ditemukan.</li>');
          updateUnreadFilterBadge();
        } else {
          var html = '';
          $.each(res.conversations, function(i, conv) {
            var isAct = (activeLabelId == conv.label_id || activePhone == conv.customer_phone);
            var isGroup = (conv.order_source === 'WhatsApp Group' || (conv.customer_phone && conv.customer_phone.indexOf('@g.us') !== -1));
            var initial = isGroup ? '<i class="fa fa-users" style="font-size:14px;"></i>' : (conv.customer_nama ? conv.customer_nama.substring(0, 1).toUpperCase() : 'C');
            var timeStr = conv.last_message_at ? conv.last_message_at.substring(8, 10) + '/' + conv.last_message_at.substring(5, 7) + ' ' + conv.last_message_at.substring(11, 16) : '';
            var groupBadge = isGroup ? '<i class="fa fa-users" style="color:#0284c7; font-size:11px; margin-right:3px;" title="Grup WhatsApp"></i>' : '';
            var rawLast = conv.last_message || (isGroup ? 'Grup WhatsApp' : conv.customer_phone);
            var lastMsg = formatSidebarSnippet(rawLast);
            var badgeHtml = '';
            if (conv.rfm && conv.rfm.segment) {
              var b = conv.rfm.badge || { bg: '#f1f5f9', color: '#475569', border: '#cbd5e1', icon: 'fa-tag' };
              badgeHtml = '<span class="badge" style="background:' + b.bg + '; color:' + b.color + '; border:1px solid ' + b.border + '; font-size:9.5px; font-weight:700; padding:2px 6px; flex-shrink:0;"><i class="fa ' + b.icon + '"></i> ' + htmlEntities(conv.rfm.segment) + '</span>';
            }
            var unreadCnt = (conv.unread_count && parseInt(conv.unread_count) > 0) ? parseInt(conv.unread_count) : 0;
            var hasUnread = (unreadCnt > 0);
            var unreadHtml = hasUnread ? '<span class="wa-conv-badge">' + unreadCnt + '</span>' : '';

            html += '<li class="wa-conv-item ' + (isAct ? 'active' : '') + ' ' + (hasUnread ? 'has-unread' : '') + '" data-label-id="' + conv.label_id + '" data-phone="' + htmlEntities(conv.customer_phone || '') + '" data-nama="' + htmlEntities(conv.customer_nama || '') + '" data-order="' + htmlEntities(conv.no_pesanan || (isGroup ? 'WhatsApp Group' : 'Direct Chat')) + '" data-unread="' + unreadCnt + '">' +
                      '<div class="wa-conv-avatar" style="' + (isGroup ? 'background:linear-gradient(135deg, #0284c7, #0ea5e9);' : '') + '">' + initial + '</div>' +
                      '<div class="wa-conv-info">' +
                        '<div class="wa-conv-top">' +
                          '<span class="wa-conv-name">' + groupBadge + htmlEntities(conv.customer_nama || 'Pelanggan') + '</span>' +
                          '<span class="wa-conv-time">' + timeStr + '</span>' +
                        '</div>' +
                        '<div class="wa-conv-msg" style="display:flex; justify-content:space-between; align-items:center; gap:4px;">' +
                          '<span class="wa-conv-snip-text" style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; flex:1;">' + htmlEntities(lastMsg) + '</span>' +
                          badgeHtml +
                        '</div>' +
                      '</div>' +
                      unreadHtml +
                    '</li>';
          });
          $list.html(html);
          updateUnreadFilterBadge();
          applyConversationFilters();
        }
      }
      if (typeof onDone === 'function') onDone();
    });
  }

  // Smart Search filter sidebar (Instant filter + Automatic full restore when cleared)
  var searchDebounceTimer = null;
  $(document).on('keyup input', '#input-search-conv', function(e) {
    var rawQ = $.trim($(this).val());
    var $clearBtn = $('#btn-clear-search-conv');

    if (rawQ) {
      $clearBtn.show();
    } else {
      $clearBtn.hide();
    }

    // Enter key: search immediately without full page reload
    if (e.keyCode === 13) {
      if (searchDebounceTimer) clearTimeout(searchDebounceTimer);
      if (!rawQ) {
        window.history.replaceState({}, '', _BASE + 'administrator/crm/chat' + (activeLabelId ? '?label_id=' + activeLabelId : ''));
        reloadConversationList('');
      } else {
        reloadConversationList(rawQ);
      }
      return;
    }

    // When search input is DELETED / EMPTIED: IMMEDIATELY SHOW ALL CHATS!
    if (!rawQ) {
      if (searchDebounceTimer) clearTimeout(searchDebounceTimer);
      // Clean query parameter from URL
      if (window.location.search.indexOf('q=') !== -1) {
        window.history.replaceState({}, '', _BASE + 'administrator/crm/chat' + (activeLabelId ? '?label_id=' + activeLabelId : ''));
      }
      applyConversationFilters();
      reloadConversationList('');
      return;
    }

    // Client-side instant filter on current list with tab awareness
    var visibleCount = applyConversationFilters();

    // If client DOM has no match or query has >= 3 chars, perform server-side debounced search
    if (searchDebounceTimer) clearTimeout(searchDebounceTimer);
    searchDebounceTimer = setTimeout(function() {
      if (visibleCount === 0 || rawQ.length >= 4) {
        reloadConversationList(rawQ);
      }
    }, 350);
  });

  // Clear search button (X) click: instant reset and show all chats
  $(document).on('click', '#btn-clear-search-conv', function() {
    $('#input-search-conv').val('').trigger('input');
  });

  // Refresh buttons
  $(document).on('click', '#btn-refresh-convs', function() {
    var $btn = $(this);
    $btn.find('i').addClass('fa-spin');
    reloadConversationList($('#input-search-conv').val(), function() {
      $btn.find('i').removeClass('fa-spin');
    });
  });

  $(document).on('click', '#btn-refresh-stream', function() {
    if (activeLabelId) {
      stopPolling();
      isFirstLoad = true;
      loadStream(activeLabelId, false);
    }
  });

  // Auto select active label ONLY if explicitly provided via URL param (e.g. redirected from customer profile / transaction)
  if (activeLabelId && activeLabelId !== '0' && activeLabelId !== '') {
    var $target = $('.wa-conv-item[data-label-id="' + activeLabelId + '"]');
    if ($target.length) {
      $target.first().click();
    }
  } else if (activePhone && activePhone !== '') {
    var $phoneTarget = $('.wa-conv-item[data-phone="' + activePhone + '"]');
    if ($phoneTarget.length) {
      $phoneTarget.first().click();
    }
  } else {
    // Default: Standby mode! Do NOT auto open the first conversation.
    // This allows the user to stay in standby (not "always on" in a chat)
    // and keeps all unread message badges visible until the user intentionally clicks them!
    closeConversation();
    updateUnreadFilterBadge();
  }

  // ===== REALTIME WHATSAPP INTEGRATION =====
  var wahaPollTimer = null;
  var currentWahaStatus = '';

  function pollWahaStatus() {
    $.getJSON(_BASE + 'administrator/crm/waha_status_ajax', function(res) {
      if (res && res.success) {
        currentWahaStatus = res.status;
        var phone = (res.session && res.session.me && res.session.me.id) ? res.session.me.id.replace('@c.us', '') : '';

        if (res.status === 'WORKING' || res.status === 'CONNECTED') {
          // Connected state
          $('.waha-pulsing-dot').css({ background: '#22c55e', boxShadow: '0 0 8px #22c55e' });
          $('#waha-header-text').html('<span style="color:#86efac; font-weight:700;">WhatsApp Terkoneksi</span>');
          $('#waha-header-badge').hide();
          $('#waha-sidebar-status .waha-pulsing-dot').css({ background: '#22c55e', boxShadow: '0 0 6px #22c55e' });
          $('#waha-sidebar-text').text('WhatsApp Terkoneksi' + (phone ? ' (' + phone + ')' : ''));
          $('#header-waha-badge').css({ background: '#dcfce7', color: '#15803d', borderColor: '#86efac' })
                                 .html('<i class="fa fa-whatsapp"></i> WhatsApp Terkoneksi');

          $('#waha-qr-alert-banner').slideUp(200);

          // Modal connected view
          $('#modal-waha-status-badge').css('background', '#22c55e').html('<i class="fa fa-check-circle"></i> WhatsApp Terkoneksi');
          $('#modal-qr-loading').hide();
          $('#modal-waha-qr-img').hide();
          $('#modal-waha-connected-view').show();
          $('#modal-qr-instructions').hide();
          if (phone) {
            $('#modal-connected-phone').text('Nomor WhatsApp: ' + phone + ' | Siap kirim & terima pesan.');
          }
        } else if (res.status === 'SCAN_QR_CODE') {
          // Needs scan QR
          $('.waha-pulsing-dot').css({ background: '#eab308', boxShadow: '0 0 8px #eab308' });
          $('#waha-header-text').html('WhatsApp: <span style="color:#fde047;">Perlu Scan QR</span>');
          $('#waha-header-badge').css('background', '#d97706').html('<i class="fa fa-qrcode"></i> Scan QR').show();
          $('#waha-sidebar-status .waha-pulsing-dot').css({ background: '#eab308', boxShadow: 'none' });
          $('#waha-sidebar-text').text('WhatsApp: Scan QR');
          $('#header-waha-badge').css({ background: '#fef3c7', color: '#b45309', borderColor: '#fde68a' })
                                 .html('<i class="fa fa-qrcode"></i> Scan QR');

          $('#waha-qr-alert-banner').slideDown(200);

          // Modal QR view
          $('#modal-waha-status-badge').css('background', '#eab308').html('<i class="fa fa-qrcode"></i> STATUS: PERLU SCAN QR');
          $('#modal-qr-loading').hide();
          $('#modal-waha-connected-view').hide();
          $('#modal-qr-instructions').show();
          $('#modal-waha-qr-img').attr('src', res.qr_url).show();
        } else {
          // Other status (STARTING / STOPPED)
          $('.waha-pulsing-dot').css({ background: '#64748b', boxShadow: 'none' });
          $('#waha-header-text').text('WhatsApp: ' + res.status);
          $('#waha-header-badge').hide();
          $('#waha-sidebar-text').text('WhatsApp: ' + res.status);
          $('#modal-waha-status-badge').css('background', '#64748b').text('STATUS: ' + res.status);
        }
      } else {
        // Offline
        $('.waha-pulsing-dot').css({ background: '#ef4444', boxShadow: 'none' });
        $('#waha-header-text').html('WhatsApp: <span style="color:#fca5a5;">Terputus</span>');
        $('#waha-header-badge').css('background', '#b91c1c').html('<i class="fa fa-warning"></i> Offline').show();
        $('#waha-sidebar-text').text('WhatsApp: Terputus');
        $('#modal-waha-status-badge').css('background', '#ef4444').text('WhatsApp Terputus');
      }
    });
  }

  // Initial check & interval poll every 3.5 seconds
  pollWahaStatus();
  wahaPollTimer = setInterval(pollWahaStatus, 3500);

  // Modal open
  $(document).on('click', '.btn-open-waha-modal', function(e) {
    e.preventDefault();
    $('#modal-waha-qr').modal('show');
    $('#modal-qr-loading').show();
    pollWahaStatus();
  });

  // Refresh QR inside modal
  $('#btn-modal-refresh-qr').on('click', function() {
    var $b = $(this);
    $b.html('<i class="fa fa-spinner fa-spin"></i> Refreshing...');
    $('#modal-waha-qr-img').attr('src', _BASE + 'administrator/crm/waha_qr_image?t=' + new Date().getTime());
    pollWahaStatus();
    setTimeout(function() {
      $b.html('<i class="fa fa-refresh"></i> Refresh QR');
    }, 1000);
  });

  // Restart WAHA Session inside modal
  $('#btn-modal-restart-session').on('click', function() {
    var $b = $(this);
    if (!confirm('Restart session WAHA untuk mendapatkan QR code baru?')) return;
    $b.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Restarting...');
    $.post(_BASE + 'administrator/crm/waha_restart_session_ajax', buildPayload({}), function(res) {
      notify('info', res.message || 'Session restarted');
      setTimeout(function() {
        pollWahaStatus();
        $b.prop('disabled', false).html('<i class="fa fa-repeat"></i> Restart Session');
      }, 3000);
    });
  });

  // Sync chats from WAHA
  $('#btn-sync-waha-chats').on('click', function() {
    var $b = $(this);
    $b.html('<i class="fa fa-spinner fa-spin"></i>');
    $.post(_BASE + 'administrator/crm/sync_waha_chats_ajax', buildPayload({}), function(res) {
      if (res && res.success) {
        notify('success', res.message);
        setTimeout(function() { window.location.reload(); }, 1200);
      } else {
        notify('warning', res.message || 'Tidak ada percakapan baru untuk disinkronkan');
      }
    }).always(function() {
      $b.html('<i class="fa fa-cloud-download"></i>');
    });
  });

  // If mobile and activeLabelId was supplied, show chat pane immediately
  if ($(window).width() <= 991 && activeLabelId) {
    $('#wa-chat-container, .wa-chat-container').addClass('mobile-chat-open');
  }
});
</script>
