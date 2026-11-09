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

.cat-card {
  background: #ffffff;
  border-radius: 14px;
  padding: 20px 22px;
  margin-bottom: 16px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.04);
  border: 1px solid #f1f5f9;
  border-left: 4px solid #6366f1;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  animation: crmFadeInUp 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}
.cat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(0,0,0,0.08); }

.box {
  animation: crmFadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.table-responsive {
  -webkit-overflow-scrolling: touch;
}
.cat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(0,0,0,0.08); }
.cat-card.inactive { border-left-color: #cbd5e1; opacity: 0.65; }
.cat-card .cat-title { font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
.cat-card .cat-code { font-size: 11px; color: #64748b; font-family: monospace; font-weight: 600; }
.cat-card .cat-days { display: inline-block; background: #e0e7ff; color: #4338ca; padding: 4px 14px; border-radius: 20px; font-weight: 800; font-size: 13px; box-shadow: 0 2px 6px rgba(99, 102, 241, 0.15); }
.cat-card .cat-template { background: #f8fafc; padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; margin-top: 12px; font-size: 12px; color: #334155; white-space: pre-wrap; word-wrap: break-word; max-height: 120px; overflow-y: auto; }
.var-tag { display: inline-block; background: #e2e8f0; color: #334155; padding: 2px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; font-family: monospace; margin: 3px 2px; cursor: pointer; transition: all 0.2s ease; }
.var-tag:hover { background: #6366f1; color: #fff; transform: translateY(-1px); }

@media (max-width: 991px) {
  .crm-header-nav { padding: 16px 16px 12px 16px; margin-bottom: 12px; }
  .crm-header-nav .header-top-flex { flex-direction: column; align-items: stretch; gap: 10px; margin-bottom: 12px; }
  .crm-header-nav .action-tools { width: 100%; justify-content: flex-start; gap: 6px; }
  .crm-header-nav .action-tools .btn { font-size: 11px; padding: 6px 10px; flex: 1 1 auto; text-align: center; justify-content: center; }
  .col-md-7, .col-md-5 { width: 100%; }
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

  .cat-card { padding: 12px 10px; margin-bottom: 10px; border-radius: 10px; }
  .cat-card .cat-title { font-size: 13.5px; }
  .cat-card .cat-code { font-size: 9.5px; }
  .cat-card .cat-days { font-size: 11px; padding: 2px 8px; }
  .cat-card .cat-template { font-size: 10.5px; padding: 8px 10px; max-height: 100px; }
  .cat-card .col-md-8, .cat-card .col-md-4 { width: 100%; }
  .cat-card .col-md-4 { text-align: left !important; margin-top: 8px; }

  .var-tag { font-size: 9.5px; padding: 2px 7px; margin: 2px; }

  .box-body { padding: 12px !important; }
  .box-body .form-control { font-size: 12px; }
  .box-body label { font-size: 11.5px; }
  .box-footer { padding: 10px 12px !important; }
  .box-footer .btn { font-size: 11.5px; }
}

@media (max-width: 480px) {
  .crm-header-nav .header-title h2 { font-size: 15px; }
  .crm-header-nav .action-tools { flex-direction: column; width: 100%; }
  .crm-header-nav .action-tools .btn { width: 100%; }
  .cat-card .cat-title { font-size: 13px; }
  .cat-card .btn { font-size: 10px; padding: 3px 8px; }
}
</style>

<section class="content" style="padding-top:15px;">
  <!-- Integrated Header Banner & Navigation -->
  <div class="crm-header-nav">
    <div class="header-top-flex">
      <div class="header-title">
        <div class="location-tag">
          <i class="fa fa-map-marker"></i> CRM & After Sales <i class="fa fa-angle-right"></i> <span>Kelompok Follow-Up</span>
        </div>
        <h2><i class="fa fa-cogs" style="color:#818cf8;"></i> Kelompok & Template Follow-Up</h2>
        <p>Atur kategori H+ custom dan template pesan WhatsApp untuk setiap tahapan follow-up</p>
      </div>

      <div class="action-tools">
        <button type="button" class="btn btn-success" style="background:#10b981; color:#fff;" id="btn-add-cat"><i class="fa fa-plus"></i> Tambah Kategori Baru</button>
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
        <i class="fa fa-whatsapp"></i> 3. Broadcast WA
      </a>
      <a href="<?= site_url('administrator/crm'); ?>" class="nav-tab-btn">
        <i class="fa fa-users"></i> 4. Customer Directory
      </a>
      <a href="<?= site_url('administrator/crm/cs_performance'); ?>" class="nav-tab-btn">
        <i class="fa fa-trophy"></i> 5. Kinerja Tim CS
      </a>
      <a href="<?= site_url('administrator/crm/followup_setting'); ?>" class="nav-tab-btn active">
        <span class="active-dot"></span> <i class="fa fa-cogs"></i> 6. Kelompok Follow-Up
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-7">
      <h4 style="font-weight:700;color:#2c3e50;margin-bottom:15px;"><i class="fa fa-list"></i> Kategori Aktif (<?= count($categories); ?>)</h4>
      <?php if (empty($categories)): ?>
        <div class="alert alert-info"><i class="fa fa-info-circle"></i> Belum ada kategori follow-up.</div>
      <?php else: foreach ($categories as $cat): ?>
      <div class="cat-card <?= $cat->is_active ? '' : 'inactive'; ?>" data-id="<?= $cat->id; ?>">
        <div class="row">
          <div class="col-md-8">
            <div class="cat-title"><?= htmlspecialchars($cat->nama_kategori); ?></div>
            <div class="cat-code"><?= $cat->kode_kategori; ?></div>
          </div>
          <div class="col-md-4 text-right">
            <span class="cat-days">H+<?= $cat->jumlah_hari; ?></span>
            <br><br>
            <button class="btn btn-xs btn-warning btn-edit-cat" 
              data-id="<?= $cat->id; ?>" 
              data-nama="<?= htmlspecialchars($cat->nama_kategori); ?>"
              data-kode="<?= $cat->kode_kategori; ?>"
              data-hari="<?= $cat->jumlah_hari; ?>"
              data-template="<?= htmlspecialchars($cat->template_pesan_default); ?>"
              data-active="<?= $cat->is_active; ?>"
              data-urutan="<?= $cat->urutan; ?>"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-xs btn-danger btn-del-cat" data-id="<?= $cat->id; ?>" data-nama="<?= htmlspecialchars($cat->nama_kategori); ?>"><i class="fa fa-trash"></i></button>
          </div>
        </div>
        <?php if (!empty($cat->template_pesan_default)): ?>
        <div class="cat-template"><?= htmlspecialchars($cat->template_pesan_default); ?></div>
        <?php endif; ?>
        <div style="margin-top: 8px;">
          <span style="font-size:11px;color:#7f8c8d;">Status: <?= $cat->is_active ? '<span class="text-success"><i class="fa fa-check-circle"></i> Aktif</span>' : '<span class="text-muted"><i class="fa fa-times-circle"></i> Nonaktif</span>'; ?> | Urutan: <?= $cat->urutan; ?></span>
        </div>
      </div>
      <?php endforeach; endif; ?>
    </div>

    <div class="col-md-5">
      <!-- Add/Edit Form -->
      <div class="box box-primary" id="form-category">
        <div class="box-header with-border">
          <h3 class="box-title" id="form-title"><i class="fa fa-plus"></i> Tambah Kategori Baru</h3>
        </div>
        <div class="box-body">
          <input type="hidden" id="cat-id" value="">
          <div class="form-group">
            <label>Nama Kategori <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="cat-nama" placeholder="e.g. H+14 — Follow Up Lanjutan">
          </div>
          <div class="form-group">
            <label>Kode Kategori <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="cat-kode" placeholder="e.g. H_14_FOLLOWUP" style="font-family:monospace;">
          </div>
          <div class="form-group">
            <label>Jumlah Hari (H+n) <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="cat-hari" value="0" min="0">
            <small class="text-muted">H+0 = saat kirim, H+3 = 3 hari setelah kirim, dst.</small>
          </div>
          <div class="form-group">
            <label>Template Pesan WA</label>
            <textarea class="form-control" id="cat-template" rows="6" placeholder="Halo Kak {{nama_customer}}..."></textarea>
            <small class="text-muted">Variabel tersedia:</small><br>
            <span class="var-tag" onclick="insertVar('{{nama_customer}}')">{{nama_customer}}</span>
            <span class="var-tag" onclick="insertVar('{{no_pesanan}}')">{{no_pesanan}}</span>
            <span class="var-tag" onclick="insertVar('{{nomor_resi}}')">{{nomor_resi}}</span>
            <span class="var-tag" onclick="insertVar('{{produk}}')">{{produk}}</span>
            <span class="var-tag" onclick="insertVar('{{tanggal_kirim}}')">{{tanggal_kirim}}</span>
            <span class="var-tag" onclick="insertVar('{{sumber_penjualan}}')">{{sumber_penjualan}}</span>
            <span class="var-tag" onclick="insertVar('{{kurir}}')">{{kurir}}</span>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Urutan Tampil <small class="text-muted">(No. Urut)</small></label>
                <input type="number" class="form-control" id="cat-urutan" value="<?= count($categories) + 1; ?>" min="0">
                <small class="text-muted">Urutan posisi dalam daftar (0, 1, 2, 3...)</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="cat-active">
                  <option value="1">Aktif</option>
                  <option value="0">Nonaktif</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button class="btn btn-primary" id="btn-save-cat"><i class="fa fa-save"></i> Simpan</button>
          <button class="btn btn-default" id="btn-reset-form"><i class="fa fa-refresh"></i> Reset</button>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
function insertVar(v) {
  var ta = document.getElementById('cat-template');
  var start = ta.selectionStart;
  var end = ta.selectionEnd;
  ta.value = ta.value.substring(0, start) + v + ta.value.substring(end);
  ta.selectionStart = ta.selectionEnd = start + v.length;
  ta.focus();
}

$(document).ready(function() {
  var csrf_name = '<?= $this->security->get_csrf_token_name(); ?>';
  var csrf_hash = '<?= $this->security->get_csrf_hash(); ?>';
  var _BASE = (typeof BASE_URL !== 'undefined') ? BASE_URL : '<?= base_url(); ?>';

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

  // Add new
  $('#btn-add-cat').on('click', function() {
    resetForm();
    $('html,body').animate({ scrollTop: $('#form-category').offset().top - 100 }, 400);
  });

  // Edit
  $('.btn-edit-cat').on('click', function() {
    var $b = $(this);
    $('#cat-id').val($b.data('id'));
    $('#cat-nama').val($b.data('nama'));
    $('#cat-kode').val($b.data('kode'));
    var hariVal = $b.data('hari');
    $('#cat-hari').val(hariVal !== undefined && hariVal !== null ? hariVal : 0);
    $('#cat-template').val($b.data('template'));
    $('#cat-active').val($b.data('active'));
    var urutanRaw = $b.data('urutan');
    var urutanVal = (urutanRaw !== undefined && urutanRaw !== null && urutanRaw !== '') ? parseInt(urutanRaw, 10) : 0;
    $('#cat-urutan').val(!isNaN(urutanVal) ? urutanVal : 0);
    $('#form-title').html('<i class="fa fa-edit"></i> Edit Kategori');
    $('html,body').animate({ scrollTop: $('#form-category').offset().top - 100 }, 400);
  });

  // Save
  $('#btn-save-cat').on('click', function() {
    var rawUrutanInput = $('#cat-urutan').val();
    var urutanVal = (rawUrutanInput !== '' && rawUrutanInput !== null) ? parseInt(rawUrutanInput, 10) : 0;
    if (isNaN(urutanVal) || urutanVal < 0) {
      urutanVal = 0;
      $('#cat-urutan').val(0);
    }

    var hariVal = $('#cat-hari').val();
    if (hariVal === '' || hariVal === null || isNaN(parseInt(hariVal, 10))) {
      hariVal = 0;
      $('#cat-hari').val(0);
    }

    var data = {
      id: $('#cat-id').val(),
      nama_kategori: $.trim($('#cat-nama').val()),
      kode_kategori: $.trim($('#cat-kode').val()),
      jumlah_hari: parseInt(hariVal, 10),
      template_pesan_default: $('#cat-template').val(),
      is_active: $('#cat-active').val(),
      urutan: urutanVal
    };

    if (!data.nama_kategori || !data.kode_kategori) {
      notify('warning', 'Nama dan Kode wajib diisi');
      return;
    }

    $.post(_BASE + 'administrator/crm/save_category_ajax', buildPayload(data), function(res) {
      var r = parseRes(res);
      if (r.success) {
        notify('success', r.message || 'Berhasil disimpan');
        setTimeout(function() { location.reload(); }, 800);
      } else {
        notify('error', r.message || 'Gagal menyimpan');
      }
    }).fail(function() {
      notify('error', 'Gagal menghubungi server');
    });
  });

  // Delete
  $('.btn-del-cat').on('click', function() {
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    if (typeof swal === 'function') {
      swal({
        title: 'Hapus "' + nama + '"?',
        text: 'Kategori hanya bisa dihapus jika belum digunakan oleh label follow-up.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
      }, function(confirmed) {
        if (confirmed) doDeleteCat(id);
      });
    } else {
      if (confirm('Hapus "' + nama + '"?')) {
        doDeleteCat(id);
      }
    }
  });

  function doDeleteCat(id, force) {
    $.post(_BASE + 'administrator/crm/delete_category_ajax', buildPayload({ id: id, force: force ? 1 : 0 }), function(res) {
      var r = parseRes(res);
      if (r.success) {
        notify('success', r.message || 'Berhasil dihapus');
        setTimeout(function() { location.reload(); }, 800);
      } else {
        if (r.has_history) {
          if (typeof swal === 'function') {
            swal({
              title: 'Kategori Memiliki Riwayat',
              text: r.message + '\n\nApakah Anda yakin ingin tetap menghapus permanen kategori ini beserta seluruh riwayatnya?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              confirmButtonText: 'Ya, Hapus Semua',
              cancelButtonText: 'Batal'
            }, function(confirmed) {
              if (confirmed) {
                doDeleteCat(id, true);
              }
            });
          } else {
            if (confirm(r.message + '\n\nTetap hapus semua?')) {
              doDeleteCat(id, true);
            }
          }
        } else {
          notify('error', r.message || 'Gagal menghapus kategori');
        }
      }
    }).fail(function() {
      notify('error', 'Gagal menghubungi server');
    });
  }

  // Reset
  $('#btn-reset-form').on('click', resetForm);

  function resetForm() {
    $('#cat-id').val('');
    $('#cat-nama, #cat-kode, #cat-template').val('');
    $('#cat-hari').val(0);
    $('#cat-urutan').val(<?= count($categories) + 1; ?>);
    $('#cat-active').val(1);
    $('#form-title').html('<i class="fa fa-plus"></i> Tambah Kategori Baru');
  }
});
</script>
