<style type="text/css">
  .approval-stat-card {
    background: #fff;
    border-radius: 10px;
    padding: 16px 20px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
    transition: all 0.2s;
  }
  .approval-stat-card:hover {
    box-shadow: 0 6px 14px rgba(0,0,0,0.06);
    transform: translateY(-2px);
  }
  .stat-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
  }
  .stat-icon-pending { background: #FEF3C7; color: #D97706; }
  .stat-icon-approved { background: #DCFCE7; color: #16A34A; }
  .stat-icon-rejected { background: #FEE2E2; color: #DC2626; }
  .stat-number {
    font-size: 22px;
    font-weight: 800;
    line-height: 1.1;
    color: #0F172A;
  }
  .stat-label {
    font-size: 12.5px;
    font-weight: 600;
    color: #64748B;
    margin-top: 2px;
  }
  .table-approval th {
    background: #0F172A !important;
    color: #fff !important;
    font-size: 12px !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    padding: 12px 14px !important;
    border: none !important;
  }
  .table-approval td {
    padding: 12px 14px !important;
    font-size: 13px !important;
    vertical-align: middle !important;
    border-bottom: 1px solid #F1F5F9 !important;
  }
  .table-approval tr:hover td {
    background: #F8FAFC !important;
  }
  @media (max-width: 767px) {
    .approval-stat-card {
      margin-bottom: 12px;
      padding: 12px 14px;
    }
    .stat-number {
      font-size: 18px;
    }
    .box-header .row {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 10px !important;
    }
    .box-header .col-sm-6 {
      width: 100% !important;
    }
    .box-header .btn-group {
      display: flex !important;
      flex-wrap: wrap !important;
      width: 100% !important;
      gap: 4px !important;
    }
    .box-header .btn-group .btn {
      flex: 1 1 calc(50% - 4px) !important;
      text-align: center !important;
      border-radius: 4px !important;
      margin-left: 0 !important;
      font-size: 11px !important;
      padding: 6px 8px !important;
    }
    .box-header .text-right {
      text-align: left !important;
    }
    .box-header form {
      max-width: 100% !important;
      width: 100% !important;
      display: flex !important;
    }
    .box-header form input[name="q"] {
      flex: 1 !important;
      width: 100% !important;
    }
  }
</style>

<section class="content-header" style="margin-bottom: 15px;">
  <h1>
    Approval Calon Customer <small>Kelola Izin &amp; Aktivasi Akun Uji Coba Calon Customer</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?= site_url('administrator/user'); ?>">User</a></li>
    <li class="active">Approval Calon Customer</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <!-- Stat Cards -->
    <div class="col-md-4 col-sm-6">
      <a href="<?= site_url('administrator/user/approval?status=pending'); ?>" style="text-decoration: none;">
        <div class="approval-stat-card" style="<?= $status_filter == 'pending' ? 'border: 2px solid #D97706;' : ''; ?>">
          <div class="stat-icon-wrap stat-icon-pending">
            <i class="fa fa-clock-o"></i>
          </div>
          <div>
            <div class="stat-number"><?= (int)$pending_count; ?></div>
            <div class="stat-label">Menunggu Persetujuan</div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4 col-sm-6">
      <a href="<?= site_url('administrator/user/approval?status=approved'); ?>" style="text-decoration: none;">
        <div class="approval-stat-card" style="<?= $status_filter == 'approved' ? 'border: 2px solid #16A34A;' : ''; ?>">
          <div class="stat-icon-wrap stat-icon-approved">
            <i class="fa fa-check-circle"></i>
          </div>
          <div>
            <div class="stat-number"><?= (int)$approved_count; ?></div>
            <div class="stat-label">Telah Disetujui (Aktif Demo)</div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4 col-sm-6">
      <a href="<?= site_url('administrator/user/approval?status=rejected'); ?>" style="text-decoration: none;">
        <div class="approval-stat-card" style="<?= $status_filter == 'rejected' ? 'border: 2px solid #DC2626;' : ''; ?>">
          <div class="stat-icon-wrap stat-icon-rejected">
            <i class="fa fa-times-circle"></i>
          </div>
          <div>
            <div class="stat-number"><?= (int)$rejected_count; ?></div>
            <div class="stat-label">Ditolak</div>
          </div>
        </div>
      </a>
    </div>
  </div>

  <div class="box box-primary" style="border-radius: 10px; border-top: 3px solid #2563EB;">
    <div class="box-header with-border" style="padding: 16px 20px;">
      <div class="row" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <div class="col-sm-6">
          <div class="btn-group">
            <a href="<?= site_url('administrator/user/approval?status=pending'); ?>" class="btn btn-sm <?= $status_filter == 'pending' ? 'btn-primary' : 'btn-default'; ?>" style="font-weight: 600;">
              <i class="fa fa-hourglass-half"></i> Menunggu Approval (<?= $pending_count; ?>)
            </a>
            <a href="<?= site_url('administrator/user/approval?status=approved'); ?>" class="btn btn-sm <?= $status_filter == 'approved' ? 'btn-primary' : 'btn-default'; ?>" style="font-weight: 600;">
              <i class="fa fa-check"></i> Disetujui (<?= $approved_count; ?>)
            </a>
            <a href="<?= site_url('administrator/user/approval?status=rejected'); ?>" class="btn btn-sm <?= $status_filter == 'rejected' ? 'btn-primary' : 'btn-default'; ?>" style="font-weight: 600;">
              <i class="fa fa-ban"></i> Ditolak (<?= $rejected_count; ?>)
            </a>
            <a href="<?= site_url('administrator/user/approval?status=all'); ?>" class="btn btn-sm <?= $status_filter == 'all' ? 'btn-primary' : 'btn-default'; ?>" style="font-weight: 600;">
              Semua Data
            </a>
          </div>
        </div>

        <div class="col-sm-6 text-right">
          <form action="<?= site_url('administrator/user/approval'); ?>" method="GET" style="display: inline-flex; gap: 6px; max-width: 300px;">
            <input type="hidden" name="status" value="<?= htmlspecialchars($status_filter); ?>">
            <input type="text" name="q" class="form-control input-sm" placeholder="Cari nama, toko, WA..." value="<?= htmlspecialchars($search_q); ?>">
            <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
            <?php if (!empty($search_q)): ?>
              <a href="<?= site_url('administrator/user/approval?status=' . $status_filter); ?>" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>

    <div class="box-body table-responsive no-padding">
      <table class="table table-hover table-approval">
        <thead>
          <tr>
            <th width="4%">No</th>
            <th width="24%">Calon Customer &amp; Bisnis</th>
            <th width="22%">Kontak Langsung</th>
            <th width="14%">Username Login</th>
            <th width="14%">Waktu Daftar</th>
            <th width="10%">Status</th>
            <th style="width: 180px; text-align: center; white-space: nowrap;">Aksi Approval</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($users)): $no = 1; foreach ($users as $u): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td>
                <div style="font-weight: 700; color: #0F172A; font-size: 13.5px;">
                  <?= htmlspecialchars($u->full_name ?: $u->username); ?>
                </div>
                <?php if (!empty($u->company_name)): ?>
                  <div style="color: #2563EB; font-weight: 600; font-size: 12px; margin-top: 2px;">
                    <i class="fa fa-building-o"></i> <?= htmlspecialchars($u->company_name); ?>
                  </div>
                <?php endif; ?>
                <div style="font-size: 11px; color: #94A3B8;">
                  Role: <?= htmlspecialchars($u->group_name ?: 'Calon Customer (Demo)'); ?>
                </div>
              </td>
              <td>
                <?php if (!empty($u->phone)): 
                  $wa_phone = preg_replace('/[^0-9]/', '', $u->phone);
                  if (substr($wa_phone, 0, 1) === '0') {
                    $wa_phone = '62' . substr($wa_phone, 1);
                  } elseif (substr($wa_phone, 0, 1) === '8') {
                    $wa_phone = '62' . $wa_phone;
                  }
                  $wa_msg = urlencode("Halo Bapak/Ibu " . ($u->full_name ?: '') . ",\n\nTerima kasih telah mendaftar uji coba Metafora ERP & CRM. Akun demo Anda telah kami aktifkan.");
                ?>
                  <div style="margin-bottom: 3px;">
                    <a href="https://wa.me/<?= $wa_phone; ?>?text=<?= $wa_msg; ?>" target="_blank" class="btn btn-xs btn-success" style="font-weight: 600; border-radius: 4px; padding: 2px 7px;">
                      <i class="fa fa-whatsapp"></i> <?= htmlspecialchars($u->phone); ?>
                    </a>
                  </div>
                <?php endif; ?>
                <div style="color: #64748B; font-size: 12px;">
                  <i class="fa fa-envelope-o"></i> <?= htmlspecialchars($u->email); ?>
                </div>
              </td>
              <td>
                <code style="background: #F1F5F9; color: #0F172A; padding: 2px 6px; border-radius: 4px; font-weight: 600;">
                  <?= htmlspecialchars($u->username); ?>
                </code>
              </td>
              <td style="font-size: 12px; color: #64748B;">
                <?= !empty($u->date_created) ? date('d M Y, H:i', strtotime($u->date_created)) : '-'; ?>
              </td>
              <td>
                <?php if ($u->approval_status === 'pending'): ?>
                  <span class="label label-warning" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; font-weight: 700;">
                    <i class="fa fa-clock-o"></i> Menunggu
                  </span>
                <?php elseif ($u->approval_status === 'approved'): ?>
                  <span class="label label-success" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; font-weight: 700;">
                    <i class="fa fa-check"></i> Disetujui
                  </span>
                <?php else: ?>
                  <span class="label label-danger" style="font-size: 11.5px; padding: 4px 8px; border-radius: 4px; font-weight: 700;">
                    <i class="fa fa-times"></i> Ditolak
                  </span>
                <?php endif; ?>
              </td>
              <td class="text-center" style="white-space: nowrap; vertical-align: middle;">
                <?php if ($u->approval_status === 'pending'): ?>
                  <div style="display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                    <button type="button" 
                       data-href="<?= site_url('administrator/user/action_approve/' . $u->id); ?>" 
                       data-name="<?= htmlspecialchars($u->full_name ?: $u->username); ?>" 
                       data-action="approve"
                       class="btn btn-xs btn-success btn-action-approve" 
                       style="font-weight: 700; padding: 5px 12px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(16,185,129,0.25); cursor: pointer; border: none;">
                      <i class="fa fa-check"></i> <span>Setujui</span>
                    </button>
                    <button type="button" 
                       data-href="<?= site_url('administrator/user/action_reject/' . $u->id); ?>" 
                       data-name="<?= htmlspecialchars($u->full_name ?: $u->username); ?>" 
                       data-action="reject"
                       class="btn btn-xs btn-danger btn-action-reject" 
                       style="font-weight: 700; padding: 5px 12px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(239,68,68,0.25); cursor: pointer; border: none;">
                      <i class="fa fa-times"></i> <span>Tolak</span>
                    </button>
                  </div>
                <?php elseif ($u->approval_status === 'rejected'): ?>
                  <button type="button" 
                     data-href="<?= site_url('administrator/user/action_approve/' . $u->id); ?>" 
                     data-name="<?= htmlspecialchars($u->full_name ?: $u->username); ?>" 
                     data-action="reactivate"
                     class="btn btn-xs btn-default btn-action-approve" 
                     style="font-weight: 600; padding: 5px 10px; border-radius: 6px; cursor: pointer;">
                    <i class="fa fa-refresh text-success"></i> Setujui Ulang
                  </button>
                <?php else: ?>
                  <button type="button" 
                     data-href="<?= site_url('administrator/user/action_reject/' . $u->id); ?>" 
                     data-name="<?= htmlspecialchars($u->full_name ?: $u->username); ?>" 
                     data-action="deactivate"
                     class="btn btn-xs btn-default btn-action-reject" 
                     style="font-weight: 600; padding: 5px 10px; border-radius: 6px; cursor: pointer;">
                    <i class="fa fa-ban text-danger"></i> Nonaktifkan
                  </button>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; else: ?>
            <tr>
              <td colspan="7" class="text-center text-muted" style="padding: 40px !important;">
                <i class="fa fa-check-circle text-success" style="font-size: 36px; margin-bottom: 10px; display: block;"></i>
                Tidak ada data calon customer dengan status <strong><?= htmlspecialchars($status_filter); ?></strong> saat ini.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  function executeApprovalAction(href) {
    if (typeof $ !== 'undefined' && $.ajax) {
      $.ajax({
        url: href,
        type: 'GET',
        dataType: 'json',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(res) {
          if (res && res.success) {
            if (typeof swal === 'function') {
              var cleanMsg = res.message.replace(/<[^>]*>?/gm, '');
              swal({
                title: "Berhasil!",
                text: cleanMsg,
                type: "success",
                timer: 1400,
                showConfirmButton: false
              });
            }
            setTimeout(function() {
              window.location.reload();
            }, 1000);
          } else {
            window.location.href = href;
          }
        },
        error: function() {
          window.location.href = href;
        }
      });
    } else {
      window.location.href = href;
    }
  }

  $(document).on('click', '.btn-action-approve', function(e) {
    e.preventDefault();
    var href = $(this).data('href');
    var name = $(this).data('name') || 'Calon Customer';
    var action = $(this).data('action') || 'approve';

    var title = "Setujui Akun Demo?";
    var text = "Akun calon customer \"" + name + "\" akan diaktifkan dan dapat langsung login untuk mencoba sistem.";
    var confirmText = "Ya, Setujui Sekarang!";

    if (action === 'reactivate') {
      title = "Aktifkan Kembali Akun Demo?";
      text = "Akun calon customer \"" + name + "\" akan diaktifkan kembali dan dapat login mencoba sistem.";
      confirmText = "Ya, Aktifkan Kembali";
    }

    if (typeof swal === 'function') {
      swal({
        title: title,
        text: text,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#10B981",
        confirmButtonText: confirmText,
        cancelButtonText: "Batal",
        closeOnConfirm: false
      }, function(isConfirm) {
        if (isConfirm) {
          executeApprovalAction(href);
        }
      });
    } else {
      if (confirm(title + "\n\n" + text)) {
        executeApprovalAction(href);
      }
    }
  });

  $(document).on('click', '.btn-action-reject', function(e) {
    e.preventDefault();
    var href = $(this).data('href');
    var name = $(this).data('name') || 'Calon Customer';
    var action = $(this).data('action') || 'reject';

    var title = "Tolak Permohonan Akun?";
    var text = "Permohonan akun calon customer \"" + name + "\" akan ditolak.";
    var confirmText = "Ya, Tolak Permohonan";

    if (action === 'deactivate') {
      title = "Nonaktifkan / Blokir Akun?";
      text = "Akun calon customer \"" + name + "\" akan dinonaktifkan (diblokir) sehingga tidak dapat login sementara waktu.";
      confirmText = "Ya, Nonaktifkan Akun";
    }

    if (typeof swal === 'function') {
      swal({
        title: title,
        text: text,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#EF4444",
        confirmButtonText: confirmText,
        cancelButtonText: "Batal",
        closeOnConfirm: false
      }, function(isConfirm) {
        if (isConfirm) {
          executeApprovalAction(href);
        }
      });
    } else {
      if (confirm(title + "\n\n" + text)) {
        executeApprovalAction(href);
      }
    }
  });
});
</script>
