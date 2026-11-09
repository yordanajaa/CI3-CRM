<style type="text/css">
	* {
		font-family: helvetica, arial, sans-serif;
		font-size: 8pt;
		color: #1e293b;
	}
	
	.header-table {
		width: 100%;
		border-bottom: 2px solid #1e40af;
		padding-bottom: 8px;
		margin-bottom: 10px;
	}
	.report-title {
		font-size: 14pt;
		font-weight: bold;
		color: #1e40af;
		margin: 0 0 4px 0;
	}
	.report-meta {
		font-size: 8pt;
		color: #475569;
		margin: 0;
	}
	
	/* KPI Summary Cards */
	.kpi-table {
		width: 100%;
		border-collapse: separate;
		margin-bottom: 12px;
	}
	.kpi-card {
		padding: 8px 12px;
		background-color: #f8fafc;
		border: 1px solid #e2e8f0;
		border-radius: 5px;
	}
	.kpi-card-blue { border-left: 4px solid #2563eb; }
	.kpi-card-green { border-left: 4px solid #059669; }
	.kpi-card-yellow { border-left: 4px solid #d97706; }
	
	.kpi-label {
		font-size: 7pt;
		font-weight: bold;
		color: #64748b;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		margin-bottom: 3px;
	}
	.kpi-value {
		font-size: 11pt;
		font-weight: bold;
		color: #0f172a;
	}
	
	/* Data Table */
	table.data-table {
		width: 100%;
		border-collapse: collapse;
		margin-top: 5px;
	}
	table.data-table th {
		background-color: #1e40af;
		color: #ffffff;
		font-weight: bold;
		text-align: center;
		padding: 7px 5px;
		border: 1px solid #1e3a8a;
		font-size: 8pt;
	}
	table.data-table td {
		padding: 5px 6px;
		border: 1px solid #cbd5e1;
		font-size: 7.5pt;
		vertical-align: middle;
	}
	table.data-table tr.even {
		background-color: #f8fafc;
	}
	
	.text-center { text-align: center; }
	.text-right { text-align: right; }
	.text-left { text-align: left; }
	.font-bold { font-weight: bold; }
	
	/* Status Badge */
	.badge {
		padding: 3px 6px;
		border-radius: 3px;
		font-size: 7pt;
		font-weight: bold;
		text-align: center;
		display: inline-block;
	}
	.badge-success { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
	.badge-warning { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
	.badge-info { background-color: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }
	.badge-danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
	.badge-purple { background-color: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; }
</style>

<page backtop="7mm" backbottom="7mm" backleft="8mm" backright="8mm">
	<!-- Header -->
	<table class="header-table">
		<tr>
			<td style="width: 70%;">
				<div class="report-title">LAPORAN PURCHASE ORDER (PO)</div>
				<div class="report-meta">
					Sistem Pembelian &amp; Inventory Management
					<?php if (!empty($filter)): ?>
						&nbsp;|&nbsp; Filter: <em>"<?= htmlspecialchars($filter, ENT_QUOTES); ?>"</em>
					<?php endif; ?>
				</div>
			</td>
			<td style="width: 30%; text-align: right; vertical-align: middle;">
				<div style="font-size: 7.5pt; color: #64748b;">
					Dicetak pada: <strong><?= date('d/m/Y H:i'); ?></strong><br>
					Total Data: <strong><?= count($pos); ?> PO</strong>
				</div>
			</td>
		</tr>
	</table>

	<!-- Summary KPI Cards -->
	<table class="kpi-table">
		<tr>
			<td style="width: 33%; padding-right: 6px;">
				<div class="kpi-card kpi-card-blue">
					<div class="kpi-label">TOTAL PESANAN (PO)</div>
					<div class="kpi-value"><?= count($pos); ?> Transaksi</div>
				</div>
			</td>
			<td style="width: 34%; padding-left: 3px; padding-right: 3px;">
				<div class="kpi-card kpi-card-green">
					<div class="kpi-label">TOTAL NILAI PEMBELIAN (RP)</div>
					<div class="kpi-value">Rp <?= number_format($total_nilai_rp, 0, ',', '.'); ?></div>
				</div>
			</td>
			<td style="width: 33%; padding-left: 6px;">
				<div class="kpi-card kpi-card-yellow">
					<div class="kpi-label">STATUS SELESAI / PENDING</div>
					<div class="kpi-value"><?= $total_selesai; ?> Selesai &bull; <?= $total_pending; ?> Pending</div>
				</div>
			</td>
		</tr>
	</table>

	<!-- Data Table -->
	<table class="data-table">
		<thead>
			<tr>
				<th style="width: 4%;">NO</th>
				<th style="width: 15%;">NOMOR PO</th>
				<th style="width: 10%;">TGL ORDER</th>
				<th style="width: 22%;">SUPPLIER</th>
				<th style="width: 8%;">MATA UANG</th>
				<th style="width: 21%;">GRAND TOTAL</th>
				<th style="width: 20%;">STATUS</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($pos)): ?>
				<?php 
				$no = 1;
				foreach ($pos as $po): 
					$mata_uang = !empty($po->mata_uang) ? strtoupper($po->mata_uang) : 'IDR';
					$kurs = (float) ($po->kurs ?? 1);
					if ($kurs <= 0) $kurs = 1;
					$total_valas = (float) ($po->total ?? 0);
					$total_rp = $total_valas * $kurs;

					if ($mata_uang !== 'IDR') {
						$grand_total_display = $mata_uang . ' ' . number_format($total_valas, 2, ',', '.') . '<br><small style="color:#64748b; font-size:6.5pt;">(Rp ' . number_format($total_rp, 0, ',', '.') . ')</small>';
					} else {
						$grand_total_display = 'Rp ' . number_format($total_valas, 0, ',', '.');
					}

					$status_label = ($po->status == 'completed') ? 'SELESAI (MASUK STOK)' : strtoupper($po->status);
					$badge_cls = ($po->status == 'completed') ? 'badge-success' : (($po->status == 'approved') ? 'badge-info' : (($po->status == 'cancelled') ? 'badge-danger' : 'badge-warning'));
					$row_cls = ($no % 2 === 0) ? 'class="even"' : '';
				?>
					<tr <?= $row_cls; ?>>
						<td class="text-center"><?= $no++; ?></td>
						<td class="text-center font-bold" style="color:#1e40af;"><?= htmlspecialchars($po->nomor_po); ?></td>
						<td class="text-center"><?= !empty($po->tanggal_po) ? date('d/m/Y', strtotime($po->tanggal_po)) : '-'; ?></td>
						<td class="font-bold"><?= htmlspecialchars(!empty($po->nama_supplier) ? $po->nama_supplier : '-'); ?></td>
						<td class="text-center"><span class="badge badge-purple"><?= htmlspecialchars($mata_uang); ?></span></td>
						<td class="text-right font-bold"><?= $grand_total_display; ?></td>
						<td class="text-center"><span class="badge <?= $badge_cls; ?>"><?= htmlspecialchars($status_label); ?></span></td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="7" class="text-center" style="padding: 20px; color: #94a3b8;">Tidak ada data Purchase Order</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</page>

