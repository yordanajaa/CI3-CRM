<style type="text/css">
	* {
		font-family: helvetica, arial, sans-serif;
		font-size: 7.5pt;
		color: #1e293b;
	}
	table.data-table {
		width: 100%;
		table-layout: fixed;
		border-collapse: collapse;
		margin-top: 8px;
	}
	table.data-table thead th {
		background-color: #1e40af;
		color: #ffffff;
		font-weight: bold;
		padding: 5px 3px;
		border: 0.5px solid #1e3a8a;
		text-align: center;
		font-size: 7.5pt;
	}
	table.data-table tbody td {
		padding: 4px 3px;
		border: 0.5px solid #cbd5e1;
		font-size: 7pt;
		word-wrap: break-word;
	}
	.text-center { text-align: center; }
	.text-right { text-align: right; }
	.text-left { text-align: left; }
	tr.even { background-color: #f8fafc; }
</style>
<page orientation="paysage" format="A4" backtop="8mm" backbottom="8mm" backleft="7mm" backright="7mm">
	<page_footer>
		<table style="width: 100%; border: none;">
			<tr>
				<td style="width: 50%; font-size: 7pt; color: #64748b;">
					Dicetak pada: <?= date('d/m/Y H:i'); ?> | Sistem CRM &amp; After Sales IDMETAFORA
				</td>
				<td style="width: 50%; text-align: right; font-size: 7pt; color: #64748b;">
					Halaman [[page_cu]] dari [[page_nb]]
				</td>
			</tr>
		</table>
	</page_footer>

	<table style="width: 100%; border-bottom: 2px solid #1e40af; padding-bottom: 6px;">
		<tr>
			<td style="width: 70%;">
				<h2 style="margin: 0; font-size: 13pt; color: #1e40af; font-weight: bold;">DIREKTORI PELANGGAN &amp; RIWAYAT FOLLOW-UP CRM</h2>
				<p style="margin: 2px 0 0 0; font-size: 7.5pt; color: #64748b;">
					Modul Customer Relationship Management (CRM)
				</p>
			</td>
			<td style="width: 30%; text-align: right; vertical-align: middle;">
				<table align="right" style="border-collapse: collapse; font-size: 7.5pt; color: #475569;">
					<tr>
						<td style="text-align: right; padding: 1px 0; color: #334155;">Total Data</td>
						<td style="width: 10px; text-align: center; padding: 1px 0; color: #334155;">:</td>
						<td style="text-align: left; padding: 1px 0; color: #334155;"><strong><?= count($rows ?? []); ?> Pelanggan</strong></td>
					</tr>
					<tr>
						<td style="text-align: right; padding: 1px 0; color: #64748b; font-size: 7pt;">Tanggal</td>
						<td style="text-align: center; padding: 1px 0; color: #64748b; font-size: 7pt;">:</td>
						<td style="text-align: left; padding: 1px 0; color: #64748b; font-size: 7pt;"><?= date('d M Y'); ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table class="data-table">
		<thead>
			<tr>
				<th style="width: 4%;">No</th>
				<th style="width: 25%;">Nama Customer</th>
				<th style="width: 14%;">No. HP / WhatsApp</th>
				<th style="width: 15%;">Sumber Penjualan</th>
				<th style="width: 12%;">Total Order</th>
				<th style="width: 14%;">Order Terakhir</th>
				<th style="width: 16%;">Pending Follow-Up</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($rows)): $no = 1; foreach ($rows as $c): 
				$is_even = ($no % 2 == 0);
			?>
			<tr class="<?= $is_even ? 'even' : ''; ?>">
				<td class="text-center" style="width: 4%;"><?= $no++; ?></td>
				<td class="text-left" style="width: 25%;">
					<strong><?= htmlspecialchars($c->customer_nama ?? '-', ENT_QUOTES); ?></strong>
					<?php if (!empty($c->nomor_resi) && $c->nomor_resi !== '-'): ?>
						<br><span style="font-size: 6.5pt; color: #0284c7;">Resi: <?= htmlspecialchars($c->nomor_resi, ENT_QUOTES); ?></span>
					<?php endif; ?>
				</td>
				<td class="text-center" style="width: 14%;"><?= htmlspecialchars($c->customer_phone ?? '-', ENT_QUOTES); ?></td>
				<td class="text-left" style="width: 15%;"><?= htmlspecialchars($c->sumber_penjualan ?? 'Direct', ENT_QUOTES); ?></td>
				<td class="text-center" style="width: 12%;"><strong><?= (int) ($c->total_orders ?? 0); ?></strong> Transaksi</td>
				<td class="text-center" style="width: 14%;"><?= !empty($c->last_order_date) ? date('d/m/Y', strtotime($c->last_order_date)) : '-'; ?></td>
				<td class="text-center" style="width: 16%;">
					<?php if (!empty($c->pending_followups) && $c->pending_followups > 0): ?>
						<span style="color:#d97706; font-weight:bold;"><?= $c->pending_followups; ?> Pending</span>
					<?php else: ?>
						<span style="color:#059669;">0 Selesai</span>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; else: ?>
			<tr>
				<td colspan="7" class="text-center" style="padding: 12px; color: #64748b;">Tidak ada data pelanggan yang sesuai.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</page>
