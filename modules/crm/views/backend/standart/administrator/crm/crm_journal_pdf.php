<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Journal Follow-Up CRM</title>
<style type="text/css">
body { font-family: sans-serif; font-size: 10px; color: #333; margin: 0; padding: 0; }
.header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #2563eb; padding-bottom: 8px; }
.header h2 { margin: 0; padding: 0; color: #1e293b; font-size: 16px; font-weight: bold; }
.header p { margin: 3px 0 0 0; color: #64748b; font-size: 10px; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
th { background-color: #1e293b; color: #ffffff; padding: 6px 4px; text-align: left; font-size: 9px; font-weight: bold; text-transform: uppercase; border: 1px solid #1e293b; }
td { padding: 5px 4px; border: 1px solid #cbd5e1; font-size: 8.5px; vertical-align: middle; }
tr:nth-child(even) { background-color: #f8fafc; }
.badge { padding: 2px 4px; border-radius: 3px; font-size: 7.5px; font-weight: bold; color: #ffffff; text-align: center; display: inline-block; }
.badge-pending { background-color: #d97706; }
.badge-sudah { background-color: #059669; }
.badge-overdue { background-color: #dc2626; }
.badge-batal { background-color: #4b5563; }
.footer { margin-top: 15px; text-align: right; font-size: 8.5px; color: #94a3b8; }
</style>
</head>
<body>
<div class="header">
    <h2>LAPORAN JOURNAL FOLLOW-UP CRM & AFTER SALES</h2>
    <p>METAFORA ERP System — Waktu Ekspor: <?= date('d/m/Y H:i:s'); ?></p>
</div>

<table>
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="16%">Nama Customer</th>
            <th width="12%">No. HP</th>
            <th width="14%">No. Pesanan</th>
            <th width="10%">Sumber</th>
            <th width="18%">Kategori Follow-Up</th>
            <th width="9%">Tgl Kirim</th>
            <th width="9%">Target Tag</th>
            <th width="8%">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($rows)): $no = 1; foreach ($rows as $r): ?>
        <tr>
            <td style="text-align:center;"><?= $no++; ?></td>
            <td><strong><?= htmlspecialchars($r->customer_nama ?? '-'); ?></strong></td>
            <td><?= htmlspecialchars($r->customer_phone ?? '-'); ?></td>
            <td><?= htmlspecialchars($r->no_pesanan ?? '-'); ?></td>
            <td><?= htmlspecialchars($r->order_source ?? 'Direct'); ?></td>
            <td>
                <?php
                $cat_pdf = htmlspecialchars($r->nama_kategori ?? '-');
                if (stripos($cat_pdf, 'H+') === false && isset($r->jumlah_hari)) {
                    $cat_pdf .= ' (H+' . $r->jumlah_hari . ')';
                }
                echo $cat_pdf;
                ?>
            </td>
            <td><?= !empty($r->tanggal_pengiriman) ? date('d/m/Y', strtotime($r->tanggal_pengiriman)) : '-'; ?></td>
            <td><?= !empty($r->tanggal_label_muncul) ? date('d/m/Y', strtotime($r->tanggal_label_muncul)) : '-'; ?></td>
            <td>
                <?php
                $st = strtolower($r->status_label ?? '');
                $cls = 'badge-pending';
                if (strpos($st, 'sudah') !== false) $cls = 'badge-sudah';
                elseif (strpos($st, 'overdue') !== false) $cls = 'badge-overdue';
                elseif (strpos($st, 'batal') !== false) $cls = 'badge-batal';
                ?>
                <span class="badge <?= $cls; ?>"><?= htmlspecialchars($r->status_label ?? 'Pending'); ?></span>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="9" style="text-align:center;padding:15px;color:#94a3b8;">Tidak ada data jurnal follow-up.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="footer">
    Dokumen ini dihasilkan secara otomatis oleh Modul CRM & After Sales Metafora ERP.
</div>
</body>
</html>
