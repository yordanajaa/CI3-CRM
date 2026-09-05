<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Direktori Pelanggan & History CRM</title>
<style type="text/css">
body { font-family: sans-serif; font-size: 10px; color: #333; margin: 0; padding: 0; }
.header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #0284c7; padding-bottom: 8px; }
.header h2 { margin: 0; padding: 0; color: #0f172a; font-size: 16px; font-weight: bold; }
.header p { margin: 3px 0 0 0; color: #64748b; font-size: 10px; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
th { background-color: #0f172a; color: #ffffff; padding: 6px 5px; text-align: left; font-size: 9px; font-weight: bold; text-transform: uppercase; border: 1px solid #0f172a; }
td { padding: 5px 5px; border: 1px solid #cbd5e1; font-size: 9px; vertical-align: middle; }
tr:nth-child(even) { background-color: #f8fafc; }
.footer { margin-top: 15px; text-align: right; font-size: 8.5px; color: #94a3b8; }
</style>
</head>
<body>
<div class="header">
    <h2>DIREKTORI PELANGGAN & HISTORY FOLLOW-UP CRM</h2>
    <p>METAFORA ERP System — Waktu Ekspor: <?= date('d/m/Y H:i:s'); ?></p>
</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="25%">Nama Customer</th>
            <th width="15%">No. HP</th>
            <th width="15%">Sumber Penjualan</th>
            <th width="12%" style="text-align:center;">Total Order</th>
            <th width="15%" style="text-align:center;">Order Terakhir</th>
            <th width="13%" style="text-align:center;">Pending Followup</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($rows)): $no = 1; foreach ($rows as $c): ?>
        <tr>
            <td style="text-align:center;"><?= $no++; ?></td>
            <td><strong><?= htmlspecialchars($c->customer_nama ?? '-'); ?></strong></td>
            <td><?= htmlspecialchars($c->customer_phone ?? '-'); ?></td>
            <td><?= htmlspecialchars($c->sumber_penjualan ?? 'Direct'); ?></td>
            <td style="text-align:center;"><strong><?= (int) ($c->total_orders ?? 0); ?></strong> Transaksi</td>
            <td style="text-align:center;"><?= !empty($c->last_order_date) ? date('d/m/Y', strtotime($c->last_order_date)) : '-'; ?></td>
            <td style="text-align:center;">
                <?php if (!empty($c->pending_followups) && $c->pending_followups > 0): ?>
                    <span style="color:#d97706;font-weight:bold;"><?= $c->pending_followups; ?> Pending</span>
                <?php else: ?>
                    <span style="color:#059669;">0 Pending</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="7" style="text-align:center;padding:15px;color:#94a3b8;">Tidak ada data pelanggan.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="footer">
    Dokumen ini dihasilkan secara otomatis oleh Modul CRM & After Sales Metafora ERP.
</div>
</body>
</html>
