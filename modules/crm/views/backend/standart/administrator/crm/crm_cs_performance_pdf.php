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
		padding: 6px 4px;
		border: 0.5px solid #1e3a8a;
		text-align: center;
		font-size: 7.5pt;
		vertical-align: middle;
	}
	table.data-table tbody td {
		padding: 5px 4px;
		border: 0.5px solid #cbd5e1;
		font-size: 7.5pt;
		word-wrap: break-word;
		vertical-align: middle;
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
				<td style="width: 60%; font-size: 7pt; color: #64748b;">
					Dicetak otomatis pada: <?= date('d/m/Y H:i:s'); ?> | Sistem CRM &amp; After Sales IDMETAFORA
				</td>
				<td style="width: 40%; text-align: right; font-size: 7pt; color: #64748b;">
					Halaman [[page_cu]] dari [[page_nb]]
				</td>
			</tr>
		</table>
	</page_footer>

	<table style="width: 100%; border-bottom: 2px solid #1e40af; padding-bottom: 6px; margin-bottom: 8px;">
		<tr>
			<td style="width: 68%;">
				<h2 style="margin: 0; font-size: 13pt; color: #1e40af; font-weight: bold;">LAPORAN KINERJA &amp; PRODUKTIVITAS TIM CS / OPERATOR</h2>
				<p style="margin: 2px 0 0 0; font-size: 7.5pt; color: #64748b;">
					Modul Manajemen Kinerja Tim Customer Service &amp; After Sales CRM
				</p>
			</td>
			<td style="width: 32%; text-align: right; vertical-align: middle;">
				<table align="right" style="border-collapse: collapse; font-size: 7.5pt; color: #475569;">
					<tr>
						<td style="text-align: right; padding: 1px 0; color: #334155;">Total CS</td>
						<td style="width: 10px; text-align: center; padding: 1px 0; color: #334155;">:</td>
						<td style="text-align: left; padding: 1px 0; color: #334155;"><strong><?= count($report ?? []); ?> Orang</strong></td>
					</tr>
					<tr>
						<td style="text-align: right; padding: 1px 0; color: #64748b; font-size: 7pt;">Tanggal Cetak</td>
						<td style="text-align: center; padding: 1px 0; color: #64748b; font-size: 7pt;">:</td>
						<td style="text-align: left; padding: 1px 0; color: #64748b; font-size: 7pt;"><?= date('d F Y'); ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table class="data-table">
		<thead>
			<tr>
				<th style="width: 5%;">Rank</th>
				<th style="width: 20%;">Username CS / Operator</th>
				<th style="width: 12%;">Total Handled</th>
				<th style="width: 12%;">Broadcast WA</th>
				<th style="width: 11%;">Respon Positif</th>
				<th style="width: 10%;">Komplain</th>
				<th style="width: 10%;">Repeat Order</th>
				<th style="width: 12%;">Omset Konversi</th>
				<th style="width: 8%;">Rate (%)</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($report)): 
				$no = 1; 
				$tot_handled = 0;
				$tot_broadcast = 0;
				$tot_positif = 0;
				$tot_komplain = 0;
				$tot_conversion = 0;
				$tot_amount = 0;
				foreach ($report as $r): 
					$is_even = ($no % 2 == 0);
					$tot_handled += (int)($r->total_handled ?? 0);
					$tot_broadcast += (int)($r->broadcast_count ?? 0);
					$tot_positif += (int)($r->respon_positif ?? 0);
					$tot_komplain += (int)($r->komplain_count ?? 0);
					$tot_conversion += (int)($r->conversion_count ?? 0);
					$tot_amount += (float)($r->conversion_amount ?? 0);
			?>
			<tr class="<?= $is_even ? 'even' : ''; ?>">
				<td class="text-center" style="width: 5%; font-weight: bold;"><?= $no++; ?></td>
				<td class="text-left" style="width: 20%;"><strong><?= htmlspecialchars($r->cs_name ?? '-', ENT_QUOTES); ?></strong></td>
				<td class="text-center" style="width: 12%;"><?= number_format((int)($r->total_handled ?? 0), 0, ',', '.'); ?></td>
				<td class="text-center" style="width: 12%;"><?= number_format((int)($r->broadcast_count ?? 0), 0, ',', '.'); ?></td>
				<td class="text-center" style="width: 11%; color: #059669; font-weight: bold;"><?= number_format((int)($r->respon_positif ?? 0), 0, ',', '.'); ?></td>
				<td class="text-center" style="width: 10%; color: <?= ((int)($r->komplain_count ?? 0) > 0) ? '#dc2626' : '#64748b'; ?>;">
					<?= number_format((int)($r->komplain_count ?? 0), 0, ',', '.'); ?>
				</td>
				<td class="text-center" style="width: 10%; font-weight: bold;"><?= number_format((int)($r->conversion_count ?? 0), 0, ',', '.'); ?></td>
				<td class="text-right" style="width: 12%; font-weight: bold; color: #1e40af;">Rp <?= number_format((float)($r->conversion_amount ?? 0), 0, ',', '.'); ?></td>
				<td class="text-center" style="width: 8%; font-weight: bold; color: #059669;"><?= $r->conversion_rate ?? 0; ?>%</td>
			</tr>
			<?php endforeach; ?>
			
			<tr style="background-color: #f1f5f9; font-weight: bold; border-top: 2px solid #cbd5e1;">
				<td colspan="2" class="text-center" style="padding: 7px 4px; font-weight: bold;">TOTAL KESELURUHAN</td>
				<td class="text-center" style="padding: 7px 4px;"><?= number_format($tot_handled, 0, ',', '.'); ?></td>
				<td class="text-center" style="padding: 7px 4px;"><?= number_format($tot_broadcast, 0, ',', '.'); ?></td>
				<td class="text-center" style="padding: 7px 4px; color: #059669;"><?= number_format($tot_positif, 0, ',', '.'); ?></td>
				<td class="text-center" style="padding: 7px 4px;"><?= number_format($tot_komplain, 0, ',', '.'); ?></td>
				<td class="text-center" style="padding: 7px 4px;"><?= number_format($tot_conversion, 0, ',', '.'); ?></td>
				<td class="text-right" style="padding: 7px 4px; color: #1e40af;">Rp <?= number_format($tot_amount, 0, ',', '.'); ?></td>
				<td class="text-center" style="padding: 7px 4px; color: #059669;">
					<?= $tot_handled > 0 ? round(($tot_conversion / $tot_handled) * 100, 1) : 0; ?>%
				</td>
			</tr>
			<?php else: ?>
			<tr>
				<td colspan="9" class="text-center" style="padding: 16px; color: #64748b;">Belum ada data aktivitas follow-up yang tercatat pada periode ini.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</page>
