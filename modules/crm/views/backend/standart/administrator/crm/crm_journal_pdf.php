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
	.badge-pending { color: #d97706; font-weight: bold; }
	.badge-sudah { color: #059669; font-weight: bold; }
	.badge-overdue { color: #dc2626; font-weight: bold; }
	.badge-batal { color: #64748b; font-weight: bold; }
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
				<h2 style="margin: 0; font-size: 13pt; color: #1e40af; font-weight: bold;">LAPORAN JURNAL FOLLOW-UP CRM &amp; AFTER SALES</h2>
				<p style="margin: 2px 0 0 0; font-size: 7.5pt; color: #64748b;">
					Daftar Penjadwalan &amp; Eksekusi Milestone Follow-Up Pelanggan
				</p>
			</td>
			<td style="width: 30%; text-align: right; vertical-align: middle;">
				<table align="right" style="border-collapse: collapse; font-size: 7.5pt; color: #475569;">
					<tr>
						<td style="text-align: right; padding: 1px 0; color: #334155;">Total Data</td>
						<td style="width: 10px; text-align: center; padding: 1px 0; color: #334155;">:</td>
						<td style="text-align: left; padding: 1px 0; color: #334155;"><strong><?= count($rows ?? []); ?> Baris</strong></td>
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
				<th style="width: 3%;">No</th>
				<th style="width: 15%;">Nama Customer</th>
				<th style="width: 9%;">No. HP</th>
				<th style="width: 12%;">No. Pesanan</th>
				<th style="width: 7%;">Sumber</th>
				<th style="width: 14%;">Kategori Follow-Up</th>
				<th style="width: 7%;">Tgl Kirim</th>
				<th style="width: 11%;">Keterangan</th>
				<th style="width: 14%;">Keterangan BC</th>
				<th style="width: 8%;">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($rows)): $no = 1; foreach ($rows as $r): 
				$is_even = ($no % 2 == 0);
				$st = strtolower($r->display_status ?? '');
				$cls = 'badge-pending';
				if (strpos($st, 'sudah') !== false || strpos($st, 'direspon') !== false) $cls = 'badge-sudah';
				elseif (strpos($st, 'overdue') !== false || strpos($st, 'terlewat') !== false) $cls = 'badge-overdue';
				elseif (strpos($st, 'batal') !== false) $cls = 'badge-batal';

				$ket_cls = 'badge-pending';
				if (!empty($r->is_followed_up)) $ket_cls = 'badge-sudah';
				elseif (!empty($r->is_overdue)) $ket_cls = 'badge-overdue';
			?>
			<tr class="<?= $is_even ? 'even' : ''; ?>">
				<td class="text-center" style="width: 3%;"><?= $no++; ?></td>
				<td class="text-left" style="width: 15%;"><strong><?= htmlspecialchars($r->display_customer_nama ?? '-', ENT_QUOTES); ?></strong></td>
				<td class="text-center" style="width: 9%;"><?= htmlspecialchars($r->display_phone ?? '-', ENT_QUOTES); ?></td>
				<td class="text-center" style="width: 12%;"><?= htmlspecialchars($r->display_no_pesanan ?? '-', ENT_QUOTES); ?></td>
				<td class="text-center" style="width: 7%;"><?= htmlspecialchars($r->display_sumber ?? 'Direct', ENT_QUOTES); ?></td>
				<td class="text-left" style="width: 14%;"><?= htmlspecialchars($r->display_kategori ?? '-', ENT_QUOTES); ?></td>
				<td class="text-center" style="width: 7%;"><?= htmlspecialchars($r->display_tgl_kirim ?? '-', ENT_QUOTES); ?></td>
				<td class="text-center <?= $ket_cls; ?>" style="width: 11%;"><?= htmlspecialchars($r->display_keterangan ?? '-', ENT_QUOTES); ?></td>
				<td class="text-left" style="width: 14%;"><?= htmlspecialchars($r->display_keterangan_bc ?? '-', ENT_QUOTES); ?></td>
				<td class="text-center <?= $cls; ?>" style="width: 8%;">
					<?= htmlspecialchars(ucfirst($r->display_status ?? 'Pending'), ENT_QUOTES); ?>
				</td>
			</tr>
			<?php endforeach; else: ?>
			<tr>
				<td colspan="10" class="text-center" style="padding: 12px; color: #64748b;">Tidak ada data jurnal follow-up.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</page>
