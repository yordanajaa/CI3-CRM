<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
:root {
  --wa-primary: #075e54;
  --wa-accent: #128c7e;
  --wa-light: #25d366;
  --wa-bg: #efeae2;
  --wa-chat-bg: #d9fdd3;
}

.wa-chat-container {
  display: flex;
  height: calc(100vh - 120px);
  min-height: 600px;
  background: #ffffff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(0,0,0,0.1);
  border: 1px solid #e2e8f0;
  margin-bottom: 20px;
  position: relative;
}

/* Left Sidebar: Conversation List */
.wa-sidebar {
  width: 350px;
  border-right: 1px solid #e2e8f0;
  display: flex;
  flex-direction: column;
  background: #f8fafc;
  flex-shrink: 0;
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
}
.wa-conv-item:hover {
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
.wa-conv-badge {
  background: #25d366;
  color: #fff;
  font-size: 10px;
  font-weight: 800;
  padding: 2px 7px;
  border-radius: 10px;
  margin-left: 4px;
}

/* Right Main Chat Panel */
.wa-main-panel {
  flex: 1;
  display: flex;
  flex-direction: column;
  background: #efeae2;
  background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4cfc6' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  position: relative;
}

/* Chat Header */
.wa-chat-header {
  background: #f0f2f5;
  padding: 12px 20px;
  border-bottom: 1px solid #cbd5e1;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 1px 4px rgba(0,0,0,0.05);
  z-index: 10;
}
.wa-header-info {
  display: flex;
  align-items: center;
  gap: 12px;
}
.wa-header-avatar {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: linear-gradient(135deg, #075e54, #128c7e);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 17px;
  font-weight: 700;
  box-shadow: 0 2px 6px rgba(0,0,0,0.12);
}
.wa-header-name {
  font-weight: 700;
  font-size: 15px;
  color: #0f172a;
  line-height: 1.2;
  display: flex;
  align-items: center;
  gap: 8px;
}
.wa-header-sub {
  font-size: 11.5px;
  color: #64748b;
  margin-top: 2px;
}

/* Canvas & Bubbles */
.wa-canvas {
  flex: 1;
  overflow-y: auto;
  padding: 20px 16px;
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
</style>

<div class="row" style="margin-top: 10px;">
  <div class="col-md-12">
    <div class="wa-chat-container">

      <!-- Left Sidebar: Conversation List -->
      <div class="wa-sidebar">
        <div class="wa-sidebar-header">
          <h4><i class="fa fa-whatsapp"></i> WhatsApp Chat Center</h4>
          <button type="button" id="btn-refresh-convs" class="btn btn-xs" style="background:rgba(255,255,255,0.2); color:#fff; border-radius:50%; width:28px; height:28px;" title="Refresh Percakapan">
            <i class="fa fa-refresh"></i>
          </button>
        </div>
        <div class="wa-search-box">
          <input type="text" id="input-search-conv" class="form-control" placeholder="Cari nama atau nomor WA..." value="<?= htmlspecialchars($search_q ?? ''); ?>">
        </div>
        <ul class="wa-conv-list" id="wa-conv-list">
          <?php if (!empty($conversations)): ?>
            <?php foreach ($conversations as $conv): 
              $is_act = ($active_label_id == $conv->label_id || $active_phone == $conv->customer_phone);
              $initial = strtoupper(substr($conv->customer_nama ?: 'C', 0, 1));
              $time_str = !empty($conv->last_message_at) ? date('d/m H:i', strtotime($conv->last_message_at)) : '';
              $rfm = $conv->rfm ?? null;
              $badge = $rfm['badge'] ?? ['bg' => '#f1f5f9', 'color' => '#475569', 'border' => '#cbd5e1', 'icon' => 'fa-tag'];
            ?>
            <li class="wa-conv-item <?= $is_act ? 'active' : ''; ?>" data-label-id="<?= $conv->label_id; ?>" data-phone="<?= htmlspecialchars($conv->customer_phone); ?>" data-nama="<?= htmlspecialchars($conv->customer_nama); ?>">
              <div class="wa-conv-avatar"><?= $initial; ?></div>
              <div class="wa-conv-info">
                <div class="wa-conv-top">
                  <span class="wa-conv-name"><?= htmlspecialchars($conv->customer_nama); ?></span>
                  <span class="wa-conv-time"><?= $time_str; ?></span>
                </div>
                <div class="wa-conv-msg" style="display:flex; justify-content:space-between; align-items:center; gap:4px;">
                  <span style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; flex:1;"><?= htmlspecialchars($conv->last_message ?: $conv->customer_phone); ?></span>
                  <?php if (!empty($rfm['segment'])): ?>
                    <span class="badge" style="background:<?= $badge['bg']; ?>; color:<?= $badge['color']; ?>; border:1px solid <?= $badge['border']; ?>; font-size:9.5px; font-weight:700; padding:2px 6px; flex-shrink:0;">
                      <i class="fa <?= $badge['icon']; ?>"></i> <?= htmlspecialchars($rfm['segment']); ?>
                    </span>
                  <?php endif; ?>
                </div>
              </div>
              <?php if (!empty($conv->unread_count) && $conv->unread_count > 0): ?>
                <span class="wa-conv-badge"><?= $conv->unread_count; ?></span>
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
            <div class="wa-header-avatar" id="header-avatar"><i class="fa fa-user"></i></div>
            <div>
              <div class="wa-header-name">
                <span id="header-cust-name">Pilih Percakapan</span>
                <span id="header-rfm-badge" style="display:none;"></span>
              </div>
              <div class="wa-header-sub"><span id="header-cust-phone">-</span> &nbsp;|&nbsp; Order: <span id="header-cust-order">-</span></div>
            </div>
          </div>
          <div style="display: flex; gap: 8px;">
            <a href="#" id="btn-header-rfm" class="btn btn-sm" style="background:#6366f1; color:#fff; border-radius: 8px; font-weight: 700; display: none;" title="Buka Analisis RFM Customer">
              <i class="fa fa-bar-chart"></i> Analisis RFM
            </a>
            <a href="#" id="btn-header-profile" class="btn btn-sm btn-default" style="border-radius: 8px; font-weight: 600; display: none;" title="Lihat Profil CRM Customer">
              <i class="fa fa-user"></i> Profil CRM
            </a>
            <button type="button" id="btn-refresh-stream" class="btn btn-sm btn-default" style="border-radius: 8px;" title="Refresh Chat">
              <i class="fa fa-refresh"></i>
            </button>
          </div>
        </div>

        <div class="wa-canvas" id="wa-canvas">
          <div class="empty-state" id="empty-chat-state">
            <i class="fa fa-comments-o"></i>
            <h4 style="font-weight: 700; color: #475569; margin-bottom: 6px;">WhatsApp Live Chat Center</h4>
            <p style="font-size: 13px; max-width: 340px;">Pilih salah satu kontak customer di sebelah kiri untuk membuka pesan & membalas percakapan WhatsApp real-time.</p>
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

          <!-- Attachment Chip Preview -->
          <div id="wa-attachment-chip" style="display:none; background:#e0f2fe; border:1px solid #bae6fd; color:#0284c7; padding:5px 12px; border-radius:8px; margin-bottom:8px; font-size:11.5px; align-items:center; justify-content:space-between;">
            <div><i class="fa fa-paperclip"></i> <span id="wa-attachment-filename">File terlampir</span></div>
            <button type="button" id="btn-remove-attachment" style="background:none; border:none; color:#0284c7; font-weight:700; cursor:pointer;">&times;</button>
          </div>

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
                <span class="wa-emoji-item">😎</span><span class="wa-emoji-item">🤗</span><span class="wa-emoji-item">🤔</span><span class="wa-emoji-item">😐</span><span class="wa-emoji-item">😏</span><span class="wa-emoji-item">😌</span><span class="wa-emoji-item">🥳</span>
              </div>
              <div class="wa-emoji-category-title">Tangan & Simbol WA</div>
              <div class="wa-emoji-grid">
                <span class="wa-emoji-item">👍</span><span class="wa-emoji-item">🙏</span><span class="wa-emoji-item">👌</span><span class="wa-emoji-item">🙌</span><span class="wa-emoji-item">👏</span><span class="wa-emoji-item">🤝</span><span class="wa-emoji-item">💪</span>
                <span class="wa-emoji-item">❤️</span><span class="wa-emoji-item">🧡</span><span class="wa-emoji-item">💛</span><span class="wa-emoji-item">💚</span><span class="wa-emoji-item">💙</span><span class="wa-emoji-item">💜</span><span class="wa-emoji-item">🔥</span>
                <span class="wa-emoji-item">⭐</span><span class="wa-emoji-item">✨</span><span class="wa-emoji-item">🎉</span><span class="wa-emoji-item">🎁</span><span class="wa-emoji-item">📦</span><span class="wa-emoji-item">🛒</span><span class="wa-emoji-item">💯</span>
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
              
              <textarea id="chat-textarea" class="wa-textarea" rows="1" placeholder="Ketik balasan CS ke WhatsApp customer..."></textarea>
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

<script>
$(document).ready(function() {
  var rawBase = (typeof BASE_URL !== 'undefined') ? BASE_URL : '<?= base_url(); ?>';
  var _BASE = rawBase.replace(/\/+$/, '') + '/';
  var csrf_name = '<?= $this->security->get_csrf_token_name(); ?>';
  var csrf_hash = '<?= $this->security->get_csrf_hash(); ?>';

  var activeLabelId = '<?= (!empty($active_label_id) && $active_label_id > 0) ? $active_label_id : ''; ?>';
  var activePhone = '<?= htmlspecialchars(!empty($active_phone) ? $active_phone : ''); ?>';
  var autoMsg = '<?= str_replace("'", "\'", !empty($auto_msg) ? $auto_msg : ''); ?>';

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
    activeLabelId = labelId;
    isFirstLoad = true;
    lastMsgId = 0;

    $('.wa-conv-item').removeClass('active');
    $('.wa-conv-item[data-label-id="' + labelId + '"]').addClass('active');

    $('#header-cust-name').text(custName || 'Customer');
    $('#header-cust-phone').text(custPhone || '-');
    $('#header-cust-order').text(custOrder || '-');
    $('#header-avatar').text((custName || 'C').substring(0, 1).toUpperCase());

    if (custPhone) {
      $('#btn-header-profile').attr('href', _BASE + 'administrator/crm/customer_detail?phone=' + encodeURIComponent(custPhone)).show();
      $('#btn-header-rfm').attr('href', _BASE + 'administrator/rfm/customer_detail?phone=' + encodeURIComponent(custPhone)).show();
    } else {
      $('#btn-header-profile, #btn-header-rfm').hide();
    }

    $('#wa-status-bar, #wa-footer').show();
    if (autoMsg) {
      $('#chat-textarea').val(autoMsg);
      autoMsg = ''; // clear after load
    }

    loadStream(labelId, true);
    startPolling(labelId);

    // Mark all incoming messages for this label as read (clears notification bell)
    $.post(_BASE + 'administrator/crm/mark_notification_read_ajax', buildPayload({ label_id: labelId }));

    // Clear unread badge on sidebar item
    var $activeItem = $('.wa-conv-item[data-label-id="' + labelId + '"]');
    $activeItem.find('.wa-conv-badge').remove();
  }

  function loadStream(lid, showSpinner) {
    if (showSpinner) {
      $('#wa-canvas').html('<div class="empty-state"><i class="fa fa-spinner fa-spin"></i><p>Memuat percakapan...</p></div>');
    }

    if (isFirstLoad) {
      $.get(_BASE + 'administrator/crm/get_chat_timeline_ajax', { label_id: lid }, function(res) {
        var r = parseRes(res);
        if (r.success) {
          if (r.label) {
            $('#header-cust-name').text(r.label.customer_nama || 'Customer');
            $('#header-cust-phone').text(r.label.customer_phone || '-');
            $('#header-cust-order').text(r.label.no_pesanan || '-');
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
          }
          isFirstLoad = false;
        } else {
          $('#wa-canvas').html('<div class="empty-state"><i class="fa fa-exclamation-triangle" style="color:#f59e0b;"></i><p>Gagal memuat timeline: ' + (r.message || 'Unknown error') + '</p></div>');
        }
      }).fail(function(xhr, status, err) {
        $('#wa-canvas').html('<div class="empty-state"><i class="fa fa-exclamation-triangle" style="color:#ef4444;"></i><p>Koneksi gagal</p></div>');
      });
    } else {
      $.get(_BASE + 'administrator/crm/get_new_messages_ajax', { label_id: lid, last_id: lastMsgId }, function(res) {
        var r = parseRes(res);
        if (r.success && r.messages && r.messages.length > 0) {
          appendMessages(r.messages);
          for (var i = 0; i < r.messages.length; i++) {
            var mid = parseInt(r.messages[i].id || 0);
            if (mid > lastMsgId) lastMsgId = mid;
          }
        }
        // Sync status from server on every poll cycle
        if (r.success && r.label && r.label.status_label) {
          var srvSt = r.label.status_label;
          if ($('#chat-status-select').val() !== srvSt) {
            $('#chat-status-select').val(srvSt);
          }
        }
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

    var senderName = item.sender_name || (isOut ? 'CS Metafora' : 'Customer');
    var senderHtml = isOut ? '' : '<div class="bubble-sender">' + htmlEntities(senderName) + '</div>';
    if (isNote) {
      senderHtml = '<div class="bubble-sender"><i class="fa fa-bookmark"></i> Catatan Internal (' + htmlEntities(senderName) + ')</div>';
    }

    var time = item.created_at ? item.created_at.substring(11, 16) : '';
    var tick = (isOut && !isNote) ? '<i class="fa fa-check text-success" style="font-size:10px;"></i>' : '';

    return '<div class="chat-bubble ' + cls + '">' +
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
        return '<div style="margin-top:6px;display:inline-block;max-width:280px;">' +
                 '<video controls preload="metadata" style="max-width:100%;max-height:220px;border-radius:10px;border:1px solid #cbd5e1;box-shadow:0 2px 6px rgba(0,0,0,0.12);display:block;margin-bottom:4px;">' +
                   '<source src="' + fullUrl + '" type="video/mp4">' +
                   '<source src="' + fullUrl + '" type="video/webm">' +
                   'Browser tidak mendukung video.' +
                 '</video>' +
                 '<a href="' + fullUrl + '" target="_blank" download style="display:inline-flex;align-items:center;gap:4px;padding:4px 10px;background:#7c3aed;color:#ffffff;border-radius:6px;font-weight:700;font-size:10.5px;text-decoration:none;">' +
                   '<i class="fa fa-download"></i> Unduh Video' +
                 '</a>' +
               '</div>';
      } else if (isImg) {
        return '<div style="margin-top:6px;display:inline-block;max-width:260px;">' +
                 '<a href="' + fullUrl + '" target="_blank" style="display:block;">' +
                   '<img src="' + fullUrl + '" alt="Foto" style="max-width:100%;max-height:200px;border-radius:10px;border:1px solid #cbd5e1;box-shadow:0 2px 6px rgba(0,0,0,0.12);display:block;margin-bottom:4px;object-fit:cover;" onerror="this.style.display=\'none\';this.parentElement.nextElementSibling.style.display=\'inline-flex\';">' +
                 '</a>' +
                 '<a href="' + fullUrl + '" target="_blank" download style="display:inline-flex;align-items:center;gap:4px;padding:4px 10px;background:#3b82f6;color:#ffffff;border-radius:6px;font-weight:700;font-size:10.5px;text-decoration:none;">' +
                   '<i class="fa fa-download"></i> Unduh Foto' +
                 '</a>' +
               '</div>';
      } else if (isDoc) {
        var docIcon = 'fa-file-text-o';
        if (/\.pdf/i.test(cleanUrl)) docIcon = 'fa-file-pdf-o';
        else if (/\.(doc|docx)/i.test(cleanUrl)) docIcon = 'fa-file-word-o';
        else if (/\.(xls|xlsx)/i.test(cleanUrl)) docIcon = 'fa-file-excel-o';
        else if (/\.(zip|rar)/i.test(cleanUrl)) docIcon = 'fa-file-archive-o';

        return '<div style="margin-top:6px;">' +
                 '<a href="' + fullUrl + '" target="_blank" download style="display:inline-flex;align-items:center;gap:6px;padding:6px 12px;background:#0284c7;color:#ffffff;border-radius:8px;font-weight:700;font-size:11px;text-decoration:none;">' +
                   '<i class="fa ' + docIcon + '" style="font-size:13px;"></i> Unduh Dokumen' +
                 '</a>' +
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

  function startPolling(lid) {
    stopPolling();
    chatPollTimer = setInterval(function() {
      if (activeLabelId && !isSending) loadStream(activeLabelId, false);
    }, 1500);
  }

  function stopPolling() {
    if (chatPollTimer) { clearInterval(chatPollTimer); chatPollTimer = null; }
  }

  // Conversation item click
  $(document).on('click', '.wa-conv-item', function() {
    var lid = $(this).attr('data-label-id');
    var name = $(this).attr('data-nama');
    var phone = $(this).attr('data-phone');
    if (lid) selectConversation(lid, name, phone, '');
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

  // Emoji Click
  $(document).on('click', '.wa-emoji-item', function() {
    var emoji = $(this).text();
    var txt = $('#chat-textarea').val();
    $('#chat-textarea').val(txt + emoji).focus();
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

  $(document).on('click', '#btn-apply-url', function() {
    var url = $.trim($('#input-attach-url').val());
    if (url) {
      $('#note-file-url').val(url);
      $('#wa-attachment-filename').text(url);
      $('#wa-attachment-chip').css('display', 'flex');
      $('#wa-url-input-container').slideUp(150);
    }
  });

  // File Upload Handler
  $(document).on('change', '#file-upload-input', function() {
    var file = this.files[0];
    if (!file) return;

    var formData = new FormData();
    formData.append('file', file);
    if (csrf_name && csrf_hash) formData.append(csrf_name, csrf_hash);

    $('#wa-attachment-filename').text('Mengunggah ' + file.name + '...');
    $('#wa-attachment-chip').css('display', 'flex');
    notify('info', 'Mengunggah file ' + file.name + '...');

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
          $('#wa-attachment-filename').html('<i class="fa fa-check-circle" style="color:#10b981;"></i> ' + (r.file_name || file.name));
          notify('success', 'File berhasil diunggah dan siap dikirim!');
        } else {
          $('#wa-attachment-chip').hide();
          notify('error', r.message || 'Gagal mengunggah file');
        }
      },
      error: function() {
        $('#wa-attachment-chip').hide();
        notify('error', 'Gagal mengunggah file ke server');
      }
    });

    $(this).val(''); // Reset file input agar bisa upload ulang file yang sama
  });

  $(document).on('click', '#btn-remove-attachment', function() {
    $('#note-file-url').val('');
    $('#wa-attachment-chip').hide();
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

        // Force full timeline reload to show the new message immediately
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

  // Smart Search filter sidebar (Instant filter + Enter key server search)
  $(document).on('keyup input', '#input-search-conv', function(e) {
    if (e.keyCode === 13) {
      var qVal = $.trim($(this).val());
      window.location.href = _BASE + 'administrator/crm/chat?q=' + encodeURIComponent(qVal);
      return;
    }

    var rawQ = $.trim($(this).val()).toLowerCase();
    if (!rawQ) {
      $('.wa-conv-item').show();
      return;
    }

    var cleanQ = rawQ.replace(/[^0-9]/g, '');
    var altPhoneQ = '';
    if (cleanQ.length >= 3) {
      if (cleanQ.indexOf('08') === 0) {
        altPhoneQ = '628' + cleanQ.substring(2);
      } else if (cleanQ.indexOf('628') === 0) {
        altPhoneQ = '08' + cleanQ.substring(3);
      }
    }

    $('.wa-conv-item').each(function() {
      var $item = $(this);
      var text = $item.text().toLowerCase();
      var phone = ($item.attr('data-phone') || '').toLowerCase();
      var cleanPhone = phone.replace(/[^0-9]/g, '');

      var match = (text.indexOf(rawQ) !== -1) || (phone.indexOf(rawQ) !== -1);
      
      if (!match && cleanQ.length >= 3) {
        if (cleanPhone.indexOf(cleanQ) !== -1) match = true;
        if (altPhoneQ && cleanPhone.indexOf(altPhoneQ) !== -1) match = true;
      }

      $item.toggle(match);
    });
  });

  // Refresh buttons
  $(document).on('click', '#btn-refresh-convs, #btn-refresh-stream', function() {
    if (activeLabelId) {
      isFirstLoad = true;
      loadStream(activeLabelId, false);
    }
  });

  // Auto select active label if provided via URL param, OR default to the first conversation in list
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
    // Default: auto open top conversation on load so chat box & input controls are immediately visible!
    var $firstItem = $('.wa-conv-item').first();
    if ($firstItem.length) {
      $firstItem.click();
    }
  }
});
</script>
