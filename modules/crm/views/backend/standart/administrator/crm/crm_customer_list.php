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

.stat-card {
  background: #ffffff;
  border-radius: 14px;
  padding: 20px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.04);
  border: 1px solid #f1f5f9;
  border-left: 4px solid #3b82f6;
  margin-bottom: 16px;
}
.stat-card .stat-num { font-size: 26px; font-weight: 800; color: #1e293b; }
.stat-card .stat-label { font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; }

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

.table-crm th { background: #f1f5f9; font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: #475569; font-weight: 700; }
.table-crm td { vertical-align: middle !important; font-size: 13px; color: #334155; }
.table-crm tbody tr { transition: all 0.2s ease; }
.table-crm tbody tr:hover { background: #f8fafc !important; }

.pending-badge { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; }
.btn-wa { background: #25D366; color: #fff; border: none; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; }
.btn-wa:hover { background: #128C7E; color: #fff; }

@media (max-width: 767px) {
  .crm-header { padding: 20px 16px; text-align: center; }
  .crm-header h2 { font-size: 18px; }
  .table-crm td, .table-crm th { font-size: 12px; padding: 8px 6px !important; }
  .badge-source { font-size: 10px; padding: 2px 6px; }
}
</style>

<section class="content" style="padding-top:15px;">
  <div class="crm-header">
    <h2><i class="fa fa-users"></i> Customer Directory</h2>
    <p>Daftar pelanggan otomatis dari seluruh sumber penjualan — Toko, Shopee, Tokopedia, TikTok Shop</p>
  </div>

  <!-- Search & Filter -->
  <div class="box box-default">
    <div class="box-body">
      <form method="get" action="<?= site_url('administrator/crm'); ?>">
        <div class="row">
          <div class="col-md-8">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-search"></i></span>
              <input type="text" name="q" class="form-control" placeholder="Cari nama customer atau nomor HP..." value="<?= htmlspecialchars($filter ?? ''); ?>">
            </div>
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
            <a href="<?= site_url('administrator/crm'); ?>" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</a>
            <a href="<?= site_url('administrator/crm/export_customers?q=' . urlencode($filter ?? '')); ?>" class="btn btn-success"><i class="fa fa-file-excel-o"></i> CSV</a>
            <a href="<?= site_url('administrator/crm/export_customers_pdf?q=' . urlencode($filter ?? '')); ?>" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> PDF</a>
            <a href="<?= site_url('administrator/crm/journal_followup'); ?>" class="btn btn-warning"><i class="fa fa-tasks"></i> Journal</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Customer Table -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-address-book"></i> Daftar Customer (<?= number_format($customer_counts); ?> total)</h3>
    </div>
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover table-striped table-crm">
        <thead>
          <tr>
            <th style="width:40px">#</th>
            <th>Customer</th>
            <th>No. HP</th>
            <th>Sumber Penjualan</th>
            <th class="text-center">Total Order</th>
            <th>Transaksi Terakhir</th>
            <th class="text-center">Pending Follow-Up</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($customers)): ?>
          <tr><td colspan="8" class="text-center" style="padding:40px;color:#95a5a6;"><i class="fa fa-inbox fa-2x"></i><br>Belum ada data customer.</td></tr>
          <?php else: ?>
          <?php $no = ($this->uri->segment(4) ?: 0) + 1; foreach ($customers as $c): ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><strong><?= htmlspecialchars($c->customer_nama); ?></strong></td>
            <td>
              <i class="fa fa-phone" style="color:#27ae60;"></i> <?= htmlspecialchars($c->customer_phone); ?>
            </td>
            <td>
              <?php
              $sources = explode(', ', $c->sumber_penjualan);
              foreach ($sources as $s):
                $s = trim($s);
                $cls = 'badge-toko';
                if (stripos($s, 'Shopee') !== false) $cls = 'badge-shopee';
                elseif (stripos($s, 'Tokopedia') !== false) $cls = 'badge-tokopedia';
                elseif (stripos($s, 'TikTok') !== false) $cls = 'badge-tiktok';
              ?>
              <span class="badge-source <?= $cls; ?>"><?= $s; ?></span>
              <?php endforeach; ?>
            </td>
            <td class="text-center"><strong><?= $c->total_orders; ?></strong></td>
            <td><?= $c->last_order_date ? date('d M Y', strtotime($c->last_order_date)) : '-'; ?></td>
            <td class="text-center">
              <?php if ($c->pending_followups > 0): ?>
                <span class="pending-badge"><?= $c->pending_followups; ?> pending</span>
              <?php else: ?>
                <span style="color:#27ae60;font-size:12px;"><i class="fa fa-check-circle"></i> Done</span>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <a href="<?= site_url('administrator/crm/customer_detail?phone=' . urlencode($c->customer_phone)); ?>" class="btn btn-sm btn-info" title="Lihat Detail">
                <i class="fa fa-eye"></i> Detail
              </a>
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
