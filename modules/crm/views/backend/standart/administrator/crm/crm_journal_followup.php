<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
.crm-header {
  background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #312e81 100%);
  color: #fff;
  padding: 28px 32px;
  border-radius: 16px;
  margin-bottom: 22px;
  box-shadow: 0 12px 30px rgba(15, 23, 42, 0.25);
  position: relative;
  overflow: hidden;
}
.crm-header h2 { margin: 0 0 6px 0; font-weight: 800; font-size: 24px; letter-spacing: -0.5px; }
.crm-header p { margin: 0; opacity: 0.85; font-size: 13px; }

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

@media (max-width: 767px) {
  .crm-header { padding: 20px 16px; text-align: center; }
  .crm-header h2 { font-size: 18px; }
  .crm-header .text-right { text-align: center !important; margin-top: 16px; }
  .stat-box { padding: 12px 10px; margin-bottom: 10px; }
  .stat-box .num { font-size: 22px; }
  .stat-box .lbl { font-size: 9px; }
  .filter-section .col-md-2 { margin-bottom: 8px; }
  .cat-pill { padding: 5px 12px; font-size: 11px; }
}
</style>

<section class="content" style="padding-top:15px;">
  <div class="crm-header">
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:15px;">
      <div>
        <h2><i class="fa fa-tasks"></i> Journal Follow-Up</h2>
        <p>Pantau tahapan after sales — Konfirmasi Pengiriman, H+3 Cek Sampai, H+7 Experience, Custom H+n</p>
      </div>
      <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
        <button class="btn btn-sm" style="background:#8e44ad;color:#fff;border:none;border-radius:8px;font-weight:600;padding:7px 14px;" id="btn-sync-cron" title="Pindai transaksi baru & buat label H+"><i class="fa fa-refresh"></i> Sync Label H+</button>
        
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:8px;font-weight:600;padding:7px 14px;background:#10b981;border:none;">
            <i class="fa fa-download"></i> Export Data <span class="caret"></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-right" style="border-radius:10px;box-shadow:0 10px 25px rgba(0,0,0,0.15);padding:6px 0;">
            <li><a href="<?= site_url('administrator/crm/export_journal_excel?' . http_build_query($_GET)); ?>"><i class="fa fa-file-excel-o text-success" style="width:20px;"></i> Export Excel (.xls)</a></li>
            <li><a href="<?= site_url('administrator/crm/export_journal?' . http_build_query($_GET)); ?>"><i class="fa fa-file-text-o text-info" style="width:20px;"></i> Export CSV (.csv)</a></li>
            <li role="separator" class="divider" style="margin:4px 0;"></li>
            <li><a href="<?= site_url('administrator/crm/export_journal_pdf?' . http_build_query($_GET)); ?>" target="_blank"><i class="fa fa-file-pdf-o text-danger" style="width:20px;"></i> Export PDF (.pdf)</a></li>
          </ul>
        </div>

        <a href="<?= site_url('administrator/crm/broadcast'); ?>" class="btn btn-sm" style="background:#25D366;color:#fff;border:none;border-radius:8px;font-weight:600;padding:7px 14px;"><i class="fa fa-bullhorn"></i> Broadcast WA</a>
        <a href="<?= site_url('administrator/crm/followup_setting'); ?>" class="btn btn-sm" style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.3);border-radius:8px;font-weight:600;padding:7px 14px;"><i class="fa fa-cogs"></i> Settings</a>
      </div>
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
  <div style="margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 6px;">
    <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="cat-pill <?= empty($filters['category_id']) ? 'active' : ''; ?>">Semua</a>
    <?php foreach ($categories as $cat): ?>
    <?php
    $raw_name = htmlspecialchars($cat->nama_kategori);
    // Standardize category tab names cleanly: strip redundant H+ prefix if present and append (H+n) uniformly
    $clean_name = preg_replace('/^H\+\d+\s*[\—\-]?\s*/i', '', $raw_name);
    $cat_label = $clean_name . ' (H+' . $cat->jumlah_hari . ')';
    ?>
    <a href="<?= site_url('administrator/crm/journal_followup?category_id=' . $cat->id); ?>" class="cat-pill <?= ($filters['category_id'] == $cat->id) ? 'active' : ''; ?>">
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
            </select>
          </div>
          <div class="col-md-2">
            <select name="status_label" class="form-control">
              <option value="">Semua Status</option>
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

              $ship_time = !empty($e->tanggal_pengiriman) ? strtotime($e->tanggal_pengiriman) : 0;
              $selisih_hari = ($ship_time > 0) ? (int)round(($target_time - $ship_time) / 86400) : (isset($e->jumlah_hari) ? (int)$e->jumlah_hari : 0);

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
                <?php if (!empty($e->customer_phone)): ?>
                <button class="btn-wa-sm btn-send-wa <?= $e->is_broadcast_sent ? 'sent-active' : ''; ?>" data-label-id="<?= $e->id; ?>" title="<?= $e->is_broadcast_sent ? 'Sudah pernah dikirim (Klik untuk kirim ulang / follow up susulan)' : 'Kirim WA'; ?>">
                  <i class="fa fa-whatsapp"></i>
                </button>
                <?php endif; ?>
                <button class="btn btn-xs btn-default btn-add-note" data-label-id="<?= $e->id; ?>" data-nama="<?= htmlspecialchars($e->customer_nama); ?>" title="Tambah Catatan" style="border-radius:6px; padding:4px 8px;">
                  <i class="fa fa-comment"></i>
                </button>
                <a href="<?= site_url('administrator/crm/customer_detail?phone=' . urlencode($e->customer_phone)); ?>" class="btn btn-xs btn-info" title="Profile Customer" style="border-radius:6px; padding:4px 8px;">
                  <i class="fa fa-user"></i>
                </a>
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

.chat-footer {
  background: #f0f2f5;
  padding: 12px 14px;
  border-top: 1px solid #e2e8f0;
}
.chat-footer .input-row {
  display: flex;
  gap: 8px;
  align-items: flex-end;
}
.chat-footer textarea {
  flex: 1;
  border: 1px solid #cbd5e1;
  border-radius: 22px;
  padding: 10px 16px;
  font-size: 13px;
  resize: none;
  outline: none;
  max-height: 80px;
  transition: border-color 0.2s;
}
.chat-footer textarea:focus { border-color: #25D366; }
.chat-footer .btn-send-chat {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: #25D366;
  color: #fff;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.2s;
  flex-shrink: 0;
}
.chat-footer .btn-send-chat:hover { background: #128C7E; transform: scale(1.05); }

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

      <div class="chat-footer">
        <!-- Sender Type Toggle -->
        <div class="sender-toggle" style="display:flex;gap:4px;margin-bottom:8px;">
          <button type="button" class="btn-toggle-sender active" data-type="cs" style="flex:1;padding:6px 10px;border:2px solid #25D366;background:#d9fdd3;color:#15803d;border-radius:20px;font-size:11px;font-weight:700;cursor:pointer;transition:all 0.2s;">
            <i class="fa fa-headset"></i> Catatan CS
          </button>
          <button type="button" class="btn-toggle-sender" data-type="customer" style="flex:1;padding:6px 10px;border:2px solid #e2e8f0;background:#fff;color:#64748b;border-radius:20px;font-size:11px;font-weight:700;cursor:pointer;transition:all 0.2s;">
            <i class="fa fa-user"></i> Balasan Customer
          </button>
        </div>
        <div class="input-row">
          <textarea id="note-text" rows="1" placeholder="Tulis catatan CS..."></textarea>
          <button class="btn-send-chat" id="btn-save-note" title="Kirim"><i class="fa fa-paper-plane"></i></button>
        </div>
      </div>

      <input type="hidden" id="note-label-id">
      <input type="hidden" id="note-sender-type" value="cs">
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
          <textarea class="form-control" id="wa-preview-message" rows="8" style="font-family:inherit;font-size:13px;line-height:1.6;border-radius:8px;border:1px solid #cbd5e1;padding:12px;" placeholder="Isi pesan WhatsApp..."></textarea>
          <small class="text-muted" style="font-size:11px;margin-top:6px;display:block;"><i class="fa fa-info-circle" style="color:#3b82f6;"></i> Anda dapat mengedit atau menyesuaikan pesan di atas sebelum diarahkan ke WhatsApp Web / Aplikasi.</small>
        </div>
        <input type="hidden" id="wa-preview-label-id">
        <input type="hidden" id="wa-preview-raw-phone">
      </div>
      <div class="modal-footer" style="background:#f8fafc;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="btn-confirm-send-wa" style="background:#25D366;border:none;font-weight:700;padding:8px 20px;">
          <i class="fa fa-paper-plane"></i> Kirim via WhatsApp
        </button>
      </div>
    </div>
  </div>
</div>

<script>
window.addEventListener('load', function() {
  var csrf_name = '<?= $this->security->get_csrf_token_name(); ?>';
  var csrf_hash = '<?= $this->security->get_csrf_hash(); ?>';
  var _BASE = (typeof BASE_URL !== 'undefined') ? BASE_URL : '<?= base_url(); ?>';

  // Move modals to body to prevent container z-index overlay issues
  if ($('#modal-note').length) $('#modal-note').appendTo('body');
  if ($('#modal-wa-preview').length) $('#modal-wa-preview').appendTo('body');

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
    var label_id = $sel.data('label-id');
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

  // ===== Single WA Send (With Preview & Edit Modal) =====
  $(document).on('click', '.btn-send-wa', function() {
    var $btn = $(this);
    var label_id = $btn.data('label-id');

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

    $.get(_BASE + 'administrator/crm/get_wa_link_ajax', { label_id: label_id }, function(res) {
      $btn.prop('disabled', false).html('<i class="fa fa-whatsapp"></i>');
      var r = parseRes(res);
      if (r.success) {
        $('#wa-preview-label-id').val(label_id);
        $('#wa-preview-name').text(r.nama || '-');
        $('#wa-preview-phone').text(r.phone || '-');
        $('#wa-preview-raw-phone').val(r.phone || '');
        $('#wa-preview-order').text(r.no_pesanan || '-');
        $('#wa-preview-message').val(r.message_preview || '');

        $('.modal-backdrop').remove();
        $('#modal-wa-preview').modal('show');
        setTimeout(function() { $('#wa-preview-message').focus(); }, 300);
      } else {
        notify('error', r.message || 'Gagal memuat pratinjau pesan WA');
      }
    }).fail(function() {
      $btn.prop('disabled', false).html('<i class="fa fa-whatsapp"></i>');
      notify('error', 'Gagal menghubungi server');
    });
  });

  // ===== Confirm & Send Custom WA Message =====
  $(document).on('click', '#btn-confirm-send-wa', function() {
    var $btn = $(this);
    var label_id = $('#wa-preview-label-id').val();
    var customMsg = $.trim($('#wa-preview-message').val());
    var rawPhone = $('#wa-preview-raw-phone').val();
    var nama = $('#wa-preview-name').text();

    if (!customMsg) {
      notify('warning', 'Pesan WA tidak boleh kosong');
      return;
    }

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Mengirim...');

    $.post(_BASE + 'administrator/crm/send_broadcast_ajax', buildPayload({
      label_ids: [label_id],
      custom_message: customMsg
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
        var wa_link = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(customMsg);
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
  $(document).on('click', '.btn-add-note', function() {
    var lid = $(this).data('label-id');
    var nama = $(this).data('nama');
    $('#note-label-id').val(lid);
    $('#note-customer-name').text(nama);
    $('#note-text').val('');
    $('#note-status').val('');
    $('#chat-canvas').html('<div class="chat-empty"><i class="fa fa-spinner fa-spin"></i> Memuat riwayat percakapan...</div>');
    
    $.get(_BASE + 'administrator/crm/get_chat_timeline_ajax', { label_id: lid }, function(res) {
      var r = parseRes(res);
      if (r.success) {
        // Populate header info
        if (r.label) {
          $('#chat-phone').text(r.label.customer_phone || '-');
          $('#chat-order').text(r.label.no_pesanan || '-');
        }
        renderChatTimeline(r.timeline || []);
      } else {
        $('#chat-canvas').html('<div class="chat-empty"><i class="fa fa-exclamation-circle"></i> Gagal memuat percakapan.</div>');
      }
    }).fail(function() {
      $('#chat-canvas').html('<div class="chat-empty"><i class="fa fa-exclamation-circle"></i> Gagal menghubungi server.</div>');
    });

    $('.modal-backdrop').remove();
    $('#modal-note').modal('show');
    setTimeout(function() { $('#note-text').focus(); }, 300);
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
      // Date separator
      var itemDate = (item.created_at || '').substring(0, 10);
      if (itemDate && itemDate !== lastDate) {
        lastDate = itemDate;
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
        html += '<div style="text-align:center;margin:12px 0 8px;"><span style="background:rgba(255,255,255,0.85);padding:3px 14px;border-radius:8px;font-size:11px;color:#64748b;box-shadow:0 1px 2px rgba(0,0,0,0.06);font-weight:600;">' + dateLabel + '</span></div>';
      }

      var safeMsg = $('<div>').text(item.message || '').html().replace(/\n/g, '<br>');
      var timeStr = (item.created_at || '').substring(11, 16);

      if (item.direction === 'outgoing') {
        // CS sent → right (green bubble)
        html += '<div class="chat-bubble bubble-outgoing">';
        html += '<div style="white-space:pre-wrap;">' + safeMsg + '</div>';
        html += '<div class="bubble-time">';
        if (item.metode_kirim) html += '<span style="font-size:9px;color:#64748b;">(' + item.metode_kirim + ')</span> ';
        html += timeStr + ' <i class="fa fa-check" style="color:#53bdeb;font-size:9px;"></i>';
        html += '</div></div>';

      } else if (item.direction === 'incoming') {
        // Customer reply → left (white bubble)
        html += '<div class="chat-bubble bubble-incoming">';
        html += '<div class="bubble-sender"><i class="fa fa-user-circle"></i> ' + (item.sender || 'Customer') + '</div>';
        html += '<div style="white-space:pre-wrap;">' + safeMsg + '</div>';
        html += '<div class="bubble-time">' + timeStr + '</div>';
        html += '</div>';

      } else {
        // Internal note → center (amber)
        html += '<div class="chat-bubble bubble-note">';
        html += '<div class="bubble-sender"><i class="fa fa-bookmark"></i> ' + (item.sender || 'CS') + '</div>';
        if (item.status_kirim) html += '<div style="font-size:10px;margin-bottom:2px;"><span style="background:#f59e0b;color:#fff;padding:1px 6px;border-radius:4px;font-size:9px;">' + item.status_kirim + '</span></div>';
        html += '<div style="white-space:pre-wrap;">' + safeMsg + '</div>';
        html += '<div class="bubble-time" style="justify-content:center;">' + timeStr + '</div>';
        html += '</div>';
      }
    });

    canvas.html(html);
    // Scroll to bottom
    canvas.scrollTop(canvas[0].scrollHeight);
  }

  // ===== Sender Type Toggle =====
  $(document).on('click', '.btn-toggle-sender', function() {
    var type = $(this).data('type');
    $('#note-sender-type').val(type);
    
    // Visual toggle
    $('.btn-toggle-sender').css({ border: '2px solid #e2e8f0', background: '#fff', color: '#64748b' });
    
    if (type === 'customer') {
      $(this).css({ border: '2px solid #3b82f6', background: '#eff6ff', color: '#1d4ed8' });
      $('#note-text').attr('placeholder', 'Ketik balasan customer dari WA...').css('background', '#f0f9ff');
      $('.btn-send-chat').css('background', '#3b82f6');
    } else {
      $(this).css({ border: '2px solid #25D366', background: '#d9fdd3', color: '#15803d' });
      $('#note-text').attr('placeholder', 'Tulis catatan CS...').css('background', '#fff');
      $('.btn-send-chat').css('background', '#25D366');
    }
    
    $('.btn-toggle-sender').removeClass('active');
    $(this).addClass('active');
  });

  // ===== Save Note (Chat Message) =====
  $(document).on('click', '#btn-save-note', function(e) {
    e.preventDefault();
    e.stopPropagation();

    var $btn = $(this);
    var lid = $('#note-label-id').val();
    var catatan = $.trim($('#note-text').val());
    var status = $('#note-status').val();
    var senderType = $('#note-sender-type').val() || 'cs';
    
    if (!catatan && !status) { 
      notify('warning', 'Tulis pesan atau pilih status terlebih dahulu');
      return; 
    }

    var finalStatus = status;
    if (!finalStatus) {
      var $inlineSelect = $('.status-select[data-label-id="' + lid + '"]');
      if ($inlineSelect.length) finalStatus = $inlineSelect.val();
    }

    // Auto-set status to Direspon when recording customer reply
    if (senderType === 'customer' && !status) {
      finalStatus = 'Direspon';
      $('#note-status').val('Direspon');
    }

    $btn.prop('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');

    $.ajax({
      url: _BASE + 'administrator/crm/update_status_ajax',
      type: 'POST',
      data: buildPayload({
        label_id: lid,
        status: finalStatus || '',
        catatan: catatan,
        sender_type: senderType
      }),
      success: function(res) {
        var r = parseRes(res);
        $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i>');
        if (r.success) {
          var label = senderType === 'customer' ? 'Balasan customer' : 'Catatan';
          notify('success', label + ' berhasil disimpan');
          if (finalStatus) {
            var $inlineSel = $('.status-select[data-label-id="' + lid + '"]');
            if ($inlineSel.length) {
              $inlineSel.val(finalStatus).data('current', finalStatus);
            }
            updateBadgeRealtime(lid, finalStatus);
          }
          // Append new bubble in real time
          if (catatan) {
            var now = new Date();
            var timeStr = ('0' + now.getHours()).slice(-2) + ':' + ('0' + now.getMinutes()).slice(-2);
            var safeMsg = $('<div>').text(catatan).html().replace(/\n/g, '<br>');
            var newBubble = '';

            if (senderType === 'customer') {
              // Customer reply → white bubble LEFT
              newBubble = '<div class="chat-bubble bubble-incoming">';
              newBubble += '<div class="bubble-sender"><i class="fa fa-user-circle"></i> Customer</div>';
              newBubble += '<div style="white-space:pre-wrap;">' + safeMsg + '</div>';
              newBubble += '<div class="bubble-time">' + timeStr + '</div>';
              newBubble += '</div>';
            } else {
              // CS note → amber bubble CENTER
              newBubble = '<div class="chat-bubble bubble-note">';
              newBubble += '<div class="bubble-sender"><i class="fa fa-bookmark"></i> CS</div>';
              if (finalStatus) newBubble += '<div style="font-size:10px;margin-bottom:2px;"><span style="background:#f59e0b;color:#fff;padding:1px 6px;border-radius:4px;font-size:9px;">' + finalStatus + '</span></div>';
              newBubble += '<div style="white-space:pre-wrap;">' + safeMsg + '</div>';
              newBubble += '<div class="bubble-time" style="justify-content:center;">' + timeStr + '</div>';
              newBubble += '</div>';
            }

            var $canvas = $('#chat-canvas');
            $canvas.find('.chat-empty').remove();
            $canvas.append(newBubble);
            $canvas.scrollTop($canvas[0].scrollHeight);
          }
          $('#note-text').val('');
          $('#note-status').val('');
        } else {
          notify('error', r.message || 'Gagal menyimpan');
        }
      },
      error: function(xhr) {
        $btn.prop('disabled', false).html('<i class="fa fa-paper-plane"></i>');
        notify('error', 'Terjadi kesalahan: ' + (xhr.statusText || 'Error'));
      }
    });
  });
});
</script>

