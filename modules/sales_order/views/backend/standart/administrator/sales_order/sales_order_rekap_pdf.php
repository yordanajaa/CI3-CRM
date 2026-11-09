<style type="text/css">
	* {
		font-family: helvetica, arial, sans-serif;
		font-size: 7.5pt;
		color: #1e293b;
	}
	
	.header-table {
		width: 100%;
		border-bottom: 2px solid #1e40af;
		padding-bottom: 8px;
		margin-bottom: 8px;
	}
	.report-title {
		font-size: 13pt;
		font-weight: bold;
		color: #1e40af;
		margin: 0 0 4px 0;
	}
	.report-meta {
		font-size: 7.5pt;
		color: #475569;
		margin: 0;
	}
	
	/* KPI Summary Cards */
	.kpi-table {
		width: 100%;
		border-collapse: separate;
		margin-bottom: 10px;
	}
	.kpi-card {
		padding: 7px 10px;
		background-color: #f8fafc;
		border: 1px solid #e2e8f0;
		border-radius: 5px;
	}
	.kpi-card-blue { border-left: 3.5px solid #2563eb; }
	.kpi-card-indigo { border-left: 3.5px solid #4f46e5; }
	.kpi-card-green { border-left: 3.5px solid #059669; }
	.kpi-card-red { border-left: 3.5px solid #dc2626; }
	
	.kpi-label {
		font-size: 6.5pt;
		font-weight: bold;
		color: #64748b;
		text-transform: uppercase;
		letter-spacing: 0.5px;
		margin-bottom: 3px;
	}
	.kpi-value {
		font-size: 10.5pt;
		font-weight: bold;
		color: #0f172a;
	}
	
	/* Data Table */
	table.data-table {
		width: 100%;
		table-layout: fixed;
		border-collapse: collapse;
		margin-top: 4px;
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
	
	.badge-lunas { color: #047857; font-weight: bold; }
	.badge-tempo { color: #dc2626; font-weight: bold; }
	
	.code-mono {
		font-family: courier;
		font-size: 7pt;
		letter-spacing: -0.3px;
	}
</style>

<page orientation="paysage" format="A4" backtop="8mm" backbottom="8mm" backleft="7mm" backright="7mm">
	<page_footer>
		<table style="width: 100%; border: none;">
			<tr>
				<td style="width: 60%; font-size: 7pt; color: #64748b;">
					Dicetak otomatis pada: <?= date('d/m/Y H:i:s'); ?> | Sistem Inventori &amp; Penjualan IDMETAFORA
				</td>
				<td style="width: 40%; text-align: right; font-size: 7pt; color: #64748b;">
					Halaman [[page_cu]] dari [[page_nb]]
				</td>
			</tr>
		</table>
	</page_footer>

	<!-- Header Rekap -->
	<table class="header-table">
		<tr>
			<td style="width: 68%;">
				<div class="report-title">LAPORAN REKAP DATA TRANSAKSI PENJUALAN</div>
				<div class="report-meta">
					Status: <strong><?= !empty($status_sel) ? ucfirst($status_sel) : 'Semua Status'; ?></strong>
					<?php if (!empty($pelanggan_nama)): ?>
						&nbsp;|&nbsp; Pelanggan: <strong><?= htmlspecialchars($pelanggan_nama, ENT_QUOTES); ?></strong>
					<?php endif; ?>
					<?php if (!empty($source_sel)): ?>
						&nbsp;|&nbsp; Saluran: <strong><?= strtoupper($source_sel); ?></strong>
					<?php endif; ?>
					<?php if (!empty($search_q)): ?>
						&nbsp;|&nbsp; Pencarian: <em>"<?= htmlspecialchars($search_q, ENT_QUOTES); ?>"</em>
					<?php endif; ?>
				</div>
			</td>
			<td style="width: 32%; text-align: right; vertical-align: middle;">
				<table align="right" style="border-collapse: collapse; font-size: 8pt; color: #475569;">
					<tr>
						<td style="text-align: right; padding: 1px 0; font-weight: bold; color: #1e293b;">Total</td>
						<td style="width: 10px; text-align: center; padding: 1px 0; color: #1e293b;">:</td>
						<td style="text-align: left; padding: 1px 0; font-weight: bold; color: #1e293b;"><?= number_format(count($results), 0, ',', '.'); ?> Transaksi</td>
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

	<!-- KPI Summary Box -->
	<?php if (!empty($summary)): ?>
	<table class="kpi-table">
		<tr>
			<td style="width: 25%; padding-right: 4px;">
				<div class="kpi-card kpi-card-blue">
					<div class="kpi-label">TOTAL TRANSAKSI</div>
					<div class="kpi-value"><?= number_format(count($results), 0, ',', '.'); ?> <span style="font-size:7.5pt; font-weight:normal; color:#64748b;">Order</span></div>
				</div>
			</td>
			<td style="width: 25%; padding: 0 3px;">
				<div class="kpi-card kpi-card-indigo">
					<div class="kpi-label">TOTAL OMSET PENJUALAN</div>
					<div class="kpi-value" style="color: #4f46e5;">Rp <?= number_format($summary['total_omset'] ?? 0, 0, ',', '.'); ?></div>
				</div>
			</td>
			<td style="width: 25%; padding: 0 3px;">
				<div class="kpi-card kpi-card-green">
					<div class="kpi-label">TERBAYAR (LUNAS)</div>
					<div class="kpi-value" style="color: #059669;">Rp <?= number_format($summary['total_lunas'] ?? 0, 0, ',', '.'); ?></div>
				</div>
			</td>
			<td style="width: 25%; padding-left: 4px;">
				<div class="kpi-card kpi-card-red">
					<div class="kpi-label">BELUM LUNAS (TEMPO)</div>
					<div class="kpi-value" style="color: #dc2626;">Rp <?= number_format($summary['total_tempo'] ?? 0, 0, ',', '.'); ?></div>
				</div>
			</td>
		</tr>
	</table>
	<?php endif; ?>

	<!-- Data Table -->
	<table class="data-table">
		<thead>
			<tr>
				<th style="width: 3%;">No</th>
				<th style="width: 11%;">No. Transaksi Penjualan</th>
				<th style="width: 9%;">No. Pesanan</th>
				<th style="width: 7%;">Tanggal Transaksi</th>
				<th style="width: 12%;">Pelanggan</th>
				<th style="width: 8%;">No. Telepon</th>
				<th style="width: 5.5%;">Tipe</th>
				<th style="width: 6.5%;">Saluran</th>
				<th style="width: 8%;">Subtotal (Rp)</th>
				<th style="width: 6%;">Diskon (Rp)</th>
				<th style="width: 5%;">Pajak (Rp)</th>
				<th style="width: 8%;">Total Nilai (Rp)</th>
				<th style="width: 5%;">Status Order</th>
				<th style="width: 6%;">Status Bayar</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no = 1; 
			$grand_total_all = 0;
			$grand_subtotal_all = 0;
			$grand_diskon_all = 0;
			$grand_pajak_all = 0;
			if (!empty($results)):
				foreach ($results as $row): 
					$is_even = ($no % 2 == 0);
					$subtotal = (float)($row->subtotal ?? $row->total);
					$diskon   = (float)($row->diskon ?? 0);
					$pajak    = (float)($row->pajak ?? 0);
					$total    = (float)$row->total;

					$grand_subtotal_all += $subtotal;
					$grand_diskon_all += $diskon;
					$grand_pajak_all += $pajak;
					$grand_total_all += $total;

					$pelanggan = $row->nama_pelanggan ?: ($row->nama_penerima ?: 'Pelanggan Umum');
					$username  = !empty($row->username_pembeli) ? $row->username_pembeli : '';
					$tipe      = !empty($row->tipe_pelanggan) ? ucwords(str_replace('_', ' ', $row->tipe_pelanggan)) : 'Umum';

					$telp_val = !empty($row->no_telepon) && $row->no_telepon !== '-' 
						? (string)$row->no_telepon 
						: (!empty($row->telp_pelanggan) && $row->telp_pelanggan !== '-' 
							? (string)$row->telp_pelanggan 
							: (!empty($row->no_telepon_pengirim) && $row->no_telepon_pengirim !== '-' 
								? (string)$row->no_telepon_pengirim 
								: '-'));

					$source = 'Regular (B2B)';
					if ($row->source == 'pos' || strpos((string)($row->catatan ?? ''), '[POS CEPAT') !== false) {
						$source = 'POS Kasir';
					} elseif ($row->source == 'excel_import' || (!empty($row->no_pesanan) && $row->source != 'manual')) {
						$source = 'Marketplace';
					}

					// Status Bayar
					$is_paid = (!empty($row->waktu_pembayaran) || ($row->inv_status_db ?? '') == 'paid');
					$pay_status = $is_paid ? 'LUNAS' : 'TEMPO';
					$pay_class  = $is_paid ? 'badge-lunas' : 'badge-tempo';
			?>
			<tr class="<?= $is_even ? 'even' : ''; ?>">
				<td class="text-center" style="width: 3%;"><?= $no++; ?></td>
				<td class="text-left code-mono" style="width: 11%; font-weight: bold;"><?= htmlspecialchars($row->nomor_so, ENT_QUOTES); ?></td>
				<td class="text-left code-mono" style="width: 9%;"><?= htmlspecialchars($row->no_pesanan ?: '-', ENT_QUOTES); ?></td>
				<td class="text-center" style="width: 7%;"><?= date('d/m/Y', strtotime($row->tanggal_so)); ?></td>
				<td class="text-left" style="width: 12%;">
					<strong><?= htmlspecialchars($pelanggan, ENT_QUOTES); ?></strong>
					<?php if ($username && $username !== $pelanggan): ?>
						<br><span style="font-size: 6pt; color: #64748b;">(<?= htmlspecialchars($username, ENT_QUOTES); ?>)</span>
					<?php endif; ?>
				</td>
				<td class="text-center" style="width: 8%; font-size: 6.5pt;"><?= htmlspecialchars($telp_val, ENT_QUOTES); ?></td>
				<td class="text-center" style="width: 5.5%; font-size: 6.5pt;"><?= htmlspecialchars($tipe, ENT_QUOTES); ?></td>
				<td class="text-center" style="width: 6.5%; font-weight: bold;"><?= htmlspecialchars($source, ENT_QUOTES); ?></td>
				<td class="text-right" style="width: 8%;">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
				<td class="text-right" style="width: 6%;"><?= $diskon > 0 ? ('Rp ' . number_format($diskon, 0, ',', '.')) : '-'; ?></td>
				<td class="text-right" style="width: 5%;"><?= $pajak > 0 ? ('Rp ' . number_format($pajak, 0, ',', '.')) : '-'; ?></td>
				<td class="text-right" style="width: 8%; font-weight: bold; color: #0f172a;">Rp <?= number_format($total, 0, ',', '.'); ?></td>
				<td class="text-center" style="width: 5%;"><?= strtoupper(htmlspecialchars($row->status, ENT_QUOTES)); ?></td>
				<td class="text-center <?= $pay_class; ?>" style="width: 6%;"><?= $pay_status; ?></td>
			</tr>
			<?php endforeach; ?>
			
			<!-- Footer Grand Total -->
			<tr style="background-color: #f1f5f9; font-weight: bold; border-top: 2px solid #cbd5e1;">
				<td colspan="8" class="text-center" style="padding: 7px 4px; font-weight: bold; color: #1e293b;">
					TOTAL KESELURUHAN (<?= number_format(count($results), 0, ',', '.'); ?> TRANSAKSI TERDATA)
				</td>
				<td class="text-right" style="padding: 7px 4px; color: #1e293b; font-size: 7.5pt;">
					Rp <?= number_format($grand_subtotal_all, 0, ',', '.'); ?>
				</td>
				<td class="text-right" style="padding: 7px 4px; color: #dc2626; font-size: 7pt;">
					<?= $grand_diskon_all > 0 ? ('Rp ' . number_format($grand_diskon_all, 0, ',', '.')) : '-'; ?>
				</td>
				<td class="text-right" style="padding: 7px 4px; color: #64748b; font-size: 7pt;">
					<?= $grand_pajak_all > 0 ? ('Rp ' . number_format($grand_pajak_all, 0, ',', '.')) : '-'; ?>
				</td>
				<td class="text-right" style="color: #1e40af; padding: 7px 4px; font-weight: bold; font-size: 8pt;">
					Rp <?= number_format($grand_total_all, 0, ',', '.'); ?>
				</td>
				<td colspan="2" style="padding: 7px 4px;"></td>
			</tr>
			<?php else: ?>
			<tr>
				<td colspan="13" class="text-center" style="padding: 16px; color: #64748b;">Tidak ada data transaksi penjualan yang sesuai.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</page>
