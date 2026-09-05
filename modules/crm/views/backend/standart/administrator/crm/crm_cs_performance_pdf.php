<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Kinerja & Konversi Tim CS</title>
<style type="text/css">
body { font-family: sans-serif; font-size: 10px; color: #333; margin: 0; padding: 0; }
.header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #7c3aed; padding-bottom: 8px; }
.header h2 { margin: 0; padding: 0; color: #4c1d95; font-size: 16px; font-weight: bold; }
.header p { margin: 3px 0 0 0; color: #64748b; font-size: 10px; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
th { background-color: #4c1d95; color: #ffffff; padding: 6px 4px; text-align: left; font-size: 8.5px; font-weight: bold; text-transform: uppercase; border: 1px solid #4c1d95; }
td { padding: 5px 4px; border: 1px solid #cbd5e1; font-size: 8.5px; vertical-align: middle; }
tr:nth-child(even) { background-color: #f8fafc; }
.footer { margin-top: 15px; text-align: right; font-size: 8.5px; color: #94a3b8; }
</style>
</head>
<body>
<div class="header">
    <h2>LAPORAN KINERJA &amp; PRODUKSI REPEAT ORDER TIM CS</h2>
    <p>METAFORA ERP System — Waktu Ekspor: <?= date('d/m/Y H:i:s'); ?></p>
</div>

<table>
    <thead>
        <tr>
            <th width="5%">Rank</th>
            <th width="20%">Operator CS</th>
            <th width="12%" style="text-align:center;">Followup</th>
            <th width="12%" style="text-align:center;">Broadcast WA</th>
            <th width="11%" style="text-align:center;">Respon Positif</th>
            <th width="10%" style="text-align:center;">Komplain</th>
            <th width="10%" style="text-align:center;">Konversi RO</th>
            <th width="12%" style="text-align:right;">Omset RO</th>
            <th width="8%" style="text-align:center;">Conv Rate</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($report)): $no = 1; foreach ($report as $r): ?>
        <tr>
            <td style="text-align:center;"><strong>#<?= $no++; ?></strong></td>
            <td><strong><?= htmlspecialchars($r->cs_name ?? 'cs_operator'); ?></strong></td>
            <td style="text-align:center;"><?= number_format($r->total_handled ?? 0); ?></td>
            <td style="text-align:center;"><?= number_format($r->broadcast_count ?? 0); ?></td>
            <td style="text-align:center;color:#059669;font-weight:bold;"><?= number_format($r->respon_positif ?? 0); ?></td>
            <td style="text-align:center;color:#dc2626;"><?= number_format($r->komplain_count ?? 0); ?></td>
            <td style="text-align:center;font-weight:bold;"><?= number_format($r->conversion_count ?? 0); ?> SO</td>
            <td style="text-align:right;font-weight:bold;color:#059669;">Rp <?= number_format($r->conversion_amount ?? 0, 0, ',', '.'); ?></td>
            <td style="text-align:center;font-weight:bold;"><?= number_format($r->conversion_rate ?? 0, 1); ?>%</td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="9" style="text-align:center;padding:15px;color:#94a3b8;">Tidak ada data kinerja tim CS.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="footer">
    Dokumen ini dihasilkan secara otomatis oleh Modul CRM & After Sales Metafora ERP.
</div>
</body>
</html>
