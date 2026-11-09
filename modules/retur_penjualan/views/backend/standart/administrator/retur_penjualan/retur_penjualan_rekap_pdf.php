<style type="text/css">
	* {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 8.5pt;
		color: #1e293b;
		box-sizing: border-box;
	}
	table.data-table {
		width: 100%;
		border-collapse: collapse;
		margin-top: 10px;
	}
	table.data-table thead th {
		background-color: #0f172a;
		color: #ffffff;
		font-weight: bold;
		padding: 7px 5px;
		border: 0.5px solid #0f172a;
		text-align: center;
		font-size: 8.5pt;
		white-space: nowrap;
	}
	table.data-table tbody td {
		padding: 6px 5px;
		border: 0.5px solid #cbd5e1;
		font-size: 8pt;
		vertical-align: middle;
	}
	.nowrap {
		white-space: nowrap !important;
	}
	.text-center { text-align: center; }
	.text-right { text-align: right; }
	.text-left { text-align: left; }
	tr.even { background-color: #f8fafc; }
	.kpi-table {
		width: 100%;
		border-collapse: separate;
		margin-top: 8px;
		margin-bottom: 6px;
	}
	.kpi-box {
		padding: 7px 12px;
		border: 0.5px solid #cbd5e1;
		background-color: #f8fafc;
		border-radius: 4px;
	}
	.kpi-title {
		font-size: 7pt;
		color: #64748b;
		text-transform: uppercase;
		font-weight: bold;
		letter-spacing: 0.4px;
	}
	.kpi-val {
		font-size: 11pt;
		font-weight: bold;
		color: #0f172a;
		margin-top: 2px;
	}
	.badge-status {
		display: inline-block;
		padding: 2px 7px;
		border-radius: 4px;
		font-size: 7.5pt;
		font-weight: bold;
		text-transform: uppercase;
		white-space: nowrap;
	}
	.badge-selesai { background: #dcfce7; color: #15803d; border: 0.5px solid #86efac; }
	.badge-draft { background: #f1f5f9; color: #475569; border: 0.5px solid #cbd5e1; }
	.badge-approved { background: #e0f2fe; color: #0369a1; border: 0.5px solid #7dd3fc; }
	.badge-cancelled { background: #fee2e2; color: #b91c1c; border: 0.5px solid #fca5a5; }
</style>
<page orientation="paysage" format="A4" backtop="10mm" backbottom="10mm" backleft="8mm" backright="8mm">
	<page_footer>
		<table style="width: 100%; border: none;">
			<tr>
				<td style="width: 50%; font-size: 7pt; color: #64748b;">
					Dicetak pada: <?= date('d/m/Y H:i'); ?> | Sistem Penjualan &amp; Retur IDMETAFORA
				</td>
				<td style="width: 50%; text-align: right; font-size: 7pt; color: #64748b;">
					Halaman [[page_cu]] dari [[page_nb]]
				</td>
			</tr>
		</table>
	</page_footer>

	<table style="width: 100%; border-bottom: 2px solid #0f172a; padding-bottom: 8px;">
		<tr>
			<td style="width: 65%;">
				<h2 style="margin: 0; font-size: 14pt; color: #0f172a; font-weight: bold;">LAPORAN DATA RETUR PENJUALAN</h2>
				<p style="margin: 3px 0 0 0; font-size: 8pt; color: #64748b;">
					IDMETAFORA &mdash; Sistem Manajemen Retur Pelanggan Terintegrasi
					<?php 
					$f_notes = [];
					if (!empty($search_q)) $f_notes[] = 'Pencarian: "' . htmlspecialchars($search_q, ENT_QUOTES) . '"';
					if (!empty($filter_extra['date_start']) || !empty($filter_extra['date_end'])) {
						$f_notes[] = 'Tanggal: ' . date('d/m/Y', strtotime($filter_extra['date_start'] ?: date('Y-m-d'))) . ' s/d ' . date('d/m/Y', strtotime($filter_extra['date_end'] ?: date('Y-m-d')));
					}
					if (!empty($filter_extra['bulan'])) {
						$m_names = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
						$f_notes[] = 'Bulan: ' . ($m_names[(int)$filter_extra['bulan']] ?? $filter_extra['bulan']);
					}
					if (!empty($filter_extra['tahun'])) $f_notes[] = 'Tahun: ' . $filter_extra['tahun'];
					if (!empty($filter_extra['status'])) $f_notes[] = 'Status: ' . strtoupper($filter_extra['status']);

					if (!empty($f_notes)) {
						echo ' | ' . implode(' | ', $f_notes);
					}
					?>
				</p>
			</td>
			<td style="width: 35%; text-align: right; vertical-align: bottom;">
				<table align="right" style="border-collapse: collapse; font-size: 8pt; color: #475569;">
					<tr>
						<td style="text-align: right; padding: 1px 0;">Tanggal Cetak</td>
						<td style="width: 10px; text-align: center; padding: 1px 0;">:</td>
						<td style="text-align: left; padding: 1px 0;"><strong><?= date('d/m/Y H:i'); ?></strong></td>
					</tr>
					<tr>
						<td style="text-align: right; padding: 1px 0;">Petugas</td>
						<td style="text-align: center; padding: 1px 0;">:</td>
						<td style="text-align: left; padding: 1px 0;"><strong><?= get_user_data('username') ?: 'Administrator'; ?></strong></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<!-- KPI Summary Bar -->
	<table class="kpi-table">
		<tr>
			<td style="width: 33%;">
				<div class="kpi-box">
					<div class="kpi-title">TOTAL DATA RETUR</div>
					<div class="kpi-val"><?= number_format(count($returs), 0, ',', '.'); ?> Transaksi</div>
				</div>
			</td>
			<td style="width: 33%;">
				<div class="kpi-box">
					<div class="kpi-title">TOTAL NILAI RETUR</div>
					<div class="kpi-val" style="color: #b91c1c;">Rp <?= number_format($total_nominal ?? 0, 0, ',', '.'); ?></div>
				</div>
			</td>
			<td style="width: 34%;">
				<div class="kpi-box">
					<div class="kpi-title">STATUS LAPORAN</div>
					<div class="kpi-val" style="color: #0284c7;">Semua Data Terverifikasi</div>
				</div>
			</td>
		</tr>
	</table>

	<!-- Main Data Table -->
	<table class="data-table">
		<thead>
			<tr>
				<th style="width: 4%;">No</th>
				<th style="width: 14%;">No. Retur</th>
				<th style="width: 14%;">No. Invoice</th>
				<th style="width: 18%;">Pelanggan</th>
				<th style="width: 9%;">Tanggal Retur</th>
				<th style="width: 12%;">Total Nilai (Rp)</th>
				<th style="width: 13%;">Alasan Retur</th>
				<th style="width: 9%;">Tindak Lanjut</th>
				<th style="width: 7%;">Status Retur</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($returs)): ?>
				<?php 
				$no = 1; 
				$grand_total = 0;
				foreach ($returs as $r): 
					$grand_total += (float)$r->total;
					$is_even = ($no % 2 == 0);
					$tl = ucwords(str_replace('_', ' ', $r->tindak_lanjut ?? '-'));
					$st_raw = strtolower($r->status ?? 'draft');
					$badge_cls = 'badge-draft';
					if ($st_raw === 'selesai') $badge_cls = 'badge-selesai';
					elseif ($st_raw === 'approved') $badge_cls = 'badge-approved';
					elseif ($st_raw === 'cancelled') $badge_cls = 'badge-cancelled';
					$alasan = !empty($r->alasan) ? $r->alasan : '-';
				?>
					<tr class="<?= $is_even ? 'even' : ''; ?>">
						<td class="text-center nowrap" style="width: 4%;"><?= $no++; ?></td>
						<td class="text-left nowrap" style="width: 14%; font-weight: bold;"><?= htmlspecialchars($r->nomor_retur, ENT_QUOTES); ?></td>
						<td class="text-left nowrap" style="width: 14%;"><?= htmlspecialchars($r->nomor_invoice ?? '-', ENT_QUOTES); ?></td>
						<td class="text-left" style="width: 18%;"><strong><?= htmlspecialchars($r->nama_pelanggan ?? '-', ENT_QUOTES); ?></strong></td>
						<td class="text-center nowrap" style="width: 9%;"><?= date('d/m/Y', strtotime($r->tanggal_retur)); ?></td>
						<td class="text-right nowrap" style="width: 12%; font-weight: bold;">Rp <?= number_format((float)$r->total, 0, ',', '.'); ?></td>
						<td class="text-left" style="width: 13%;"><?= htmlspecialchars($alasan, ENT_QUOTES); ?></td>
						<td class="text-center nowrap" style="width: 9%;"><?= htmlspecialchars($tl, ENT_QUOTES); ?></td>
						<td class="text-center nowrap" style="width: 7%;">
							<span class="badge-status <?= $badge_cls; ?>"><?= htmlspecialchars(strtoupper($r->status ?? '-'), ENT_QUOTES); ?></span>
						</td>
					</tr>
				<?php endforeach; ?>
				<tr style="background-color: #e2e8f0; font-weight: bold;">
					<td colspan="5" class="text-right nowrap" style="padding: 7px; font-size: 8.5pt;">TOTAL NILAI KESELURUHAN:</td>
					<td class="text-right nowrap" style="padding: 7px; font-size: 9pt; color: #0f172a;">Rp <?= number_format($grand_total, 0, ',', '.'); ?></td>
					<td colspan="3"></td>
				</tr>
			<?php else: ?>
			<tr>
				<td colspan="9" class="text-center" style="padding: 15px; color: #64748b;">
					Tidak ada data retur penjualan ditemukan.
				</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<br><br>
	<!-- Signature section -->
	<table style="width: 100%; border: none; font-size: 8pt;">
		<tr>
			<td style="width: 33%; text-align: center;">
				Dibuat Oleh,<br><br><br><br>
				<strong>( <?= get_user_data('username') ?: 'Staff Retur'; ?> )</strong>
			</td>
			<td style="width: 34%; text-align: center;">
				Diperiksa Oleh,<br><br><br><br>
				<strong>( ______________________ )</strong><br>
				Supervisor Logistik
			</td>
			<td style="width: 33%; text-align: center;">
				Disetujui Oleh,<br><br><br><br>
				<strong>( ______________________ )</strong><br>
				Kepala Operasional
			</td>
		</tr>
	</table>
</page>
