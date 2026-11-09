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
	.kpi-card-amber { border-left: 3.5px solid #d97706; }
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
	
	.badge-normal { color: #047857; font-weight: bold; }
	.badge-menipis { color: #d97706; font-weight: bold; }
	.badge-habis { color: #dc2626; font-weight: bold; }
	
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
					Dicetak otomatis pada: <?= date('d/m/Y H:i:s'); ?> | Sistem Inventori &amp; Stok IDMETAFORA
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
				<div class="report-title">LAPORAN DATA STOK BARANG</div>
				<div class="report-meta">
					Sistem ERP &amp; Inventory Management
					<?php if (!empty($status_sel) && $status_sel !== 'all'): ?>
						&nbsp;|&nbsp; Status: <strong><?= $status_sel == 'habis' ? 'Stok Habis' : ($status_sel == 'menipis' ? 'Stok Menipis' : 'Ada Stok'); ?></strong>
					<?php endif; ?>
					<?php if (!empty($search_q)): ?>
						&nbsp;|&nbsp; Filter: <em>"<?= htmlspecialchars($search_q, ENT_QUOTES); ?>"</em>
					<?php endif; ?>
				</div>
			</td>
			<td style="width: 32%; text-align: right; vertical-align: middle;">
				<table align="right" style="border-collapse: collapse; font-size: 8pt; color: #475569;">
					<tr>
						<td style="text-align: right; padding: 1px 0; font-weight: bold; color: #1e293b;">Total</td>
						<td style="width: 10px; text-align: center; padding: 1px 0; color: #1e293b;">:</td>
						<td style="text-align: left; padding: 1px 0; font-weight: bold; color: #1e293b;"><?= number_format(count($results), 0, ',', '.'); ?> Baris Produk</td>
					</tr>
					<tr>
						<td style="text-align: right; padding: 1px 0; color: #64748b; font-size: 7pt;">Tanggal</td>
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
					<div class="kpi-label">TOTAL PRODUK</div>
					<div class="kpi-value"><?= number_format(is_object($summary) ? $summary->total_produk : ($summary['total_produk'] ?? 0), 0, ',', '.'); ?> <span style="font-size:7.5pt; font-weight:normal; color:#64748b;">Item</span></div>
				</div>
			</td>
			<td style="width: 25%; padding: 0 3px;">
				<div class="kpi-card kpi-card-indigo">
					<div class="kpi-label">TOTAL QTY STOK</div>
					<div class="kpi-value" style="color: #4f46e5;"><?= number_format(is_object($summary) ? $summary->total_stok : ($summary['total_stok'] ?? 0), 0, ',', '.'); ?> <span style="font-size:7.5pt; font-weight:normal; color:#64748b;">Unit</span></div>
				</div>
			</td>
			<td style="width: 25%; padding: 0 3px;">
				<div class="kpi-card kpi-card-amber">
					<div class="kpi-label">STOK MENIPIS</div>
					<div class="kpi-value" style="color: #d97706;"><?= number_format(is_object($summary) ? $summary->stok_menipis : ($summary['stok_menipis'] ?? 0), 0, ',', '.'); ?> <span style="font-size:7.5pt; font-weight:normal; color:#64748b;">SKU</span></div>
				</div>
			</td>
			<td style="width: 25%; padding-left: 4px;">
				<div class="kpi-card kpi-card-red">
					<div class="kpi-label">STOK HABIS (0)</div>
					<div class="kpi-value" style="color: #dc2626;"><?= number_format(is_object($summary) ? $summary->stok_habis : ($summary['stok_habis'] ?? 0), 0, ',', '.'); ?> <span style="font-size:7.5pt; font-weight:normal; color:#64748b;">SKU</span></div>
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
				<th style="width: 11%;">Kode Produk</th>
				<th style="width: 25%;">Nama Produk</th>
				<th style="width: 12%;">Kategori</th>
				<th style="width: 6%;">Stok Fisik</th>
				<th style="width: 5%;">Rusak</th>
				<th style="width: 5%;">Min</th>
				<th style="width: 5%;">Satuan</th>
				<th style="width: 10%;">Harga Beli (Rp)</th>
				<th style="width: 11%;">Harga Jual (Rp)</th>
				<th style="width: 7%;">Status Stok</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no = 1; 
			$total_qty = 0;
			$total_rusak = 0;
			if (!empty($results)):
				foreach ($results as $row): 
					$is_even = ($no % 2 == 0);
					$qty = (float)$row->qty;
					$qty_rusak = (float)$row->qty_rusak;
					$min_stok = (float)$row->stok_minimum;
					$total_qty += $qty;
					$total_rusak += $qty_rusak;

					$status_label = 'Normal';
					$badge_class = 'badge-normal';
					if ($qty == 0) {
						$status_label = 'Habis';
						$badge_class = 'badge-habis';
					} elseif ($qty <= $min_stok) {
						$status_label = 'Menipis';
						$badge_class = 'badge-menipis';
					}
			?>
			<tr class="<?= $is_even ? 'even' : ''; ?>">
				<td class="text-center" style="width: 3%;"><?= $no++; ?></td>
				<td class="text-center code-mono" style="width: 11%; font-weight: bold;"><?= htmlspecialchars($row->kode_produk, ENT_QUOTES); ?></td>
				<td class="text-left" style="width: 25%;"><?= htmlspecialchars($row->nama_produk, ENT_QUOTES); ?></td>
				<td class="text-left" style="width: 12%;"><?= htmlspecialchars($row->nama_kategori ?: '-', ENT_QUOTES); ?></td>
				<td class="text-center" style="width: 6%; font-weight: bold;"><?= number_format($qty, 0, ',', '.'); ?></td>
				<td class="text-center <?= $qty_rusak > 0 ? 'badge-habis' : ''; ?>" style="width: 5%;">
					<?= $qty_rusak > 0 ? number_format($qty_rusak, 0, ',', '.') : '-'; ?>
				</td>
				<td class="text-center" style="width: 5%;"><?= number_format($min_stok, 0, ',', '.'); ?></td>
				<td class="text-center" style="width: 5%;"><?= htmlspecialchars($row->singkatan ?: '-', ENT_QUOTES); ?></td>
				<td class="text-right" style="width: 10%;">Rp <?= number_format((float)($row->harga_beli ?? 0), 0, ',', '.'); ?></td>
				<td class="text-right" style="width: 11%; font-weight: bold;">Rp <?= number_format((float)($row->harga_jual ?? 0), 0, ',', '.'); ?></td>
				<td class="text-center <?= $badge_class; ?>" style="width: 7%;">
					<?= $status_label; ?>
				</td>
			</tr>
			<?php endforeach; ?>
			
			<!-- Footer Grand Total -->
			<tr style="background-color: #f1f5f9; font-weight: bold; border-top: 2px solid #cbd5e1;">
				<td colspan="4" class="text-center" style="padding: 7px 4px; font-weight: bold; color: #1e293b;">
					TOTAL STOK KESELURUHAN (<?= number_format(count($results), 0, ',', '.'); ?> PRODUK)
				</td>
				<td class="text-center" style="color: #1e40af; padding: 7px 4px; font-weight: bold;">
					<?= number_format($total_qty, 0, ',', '.'); ?>
				</td>
				<td class="text-center" style="color: #dc2626; padding: 7px 4px; font-weight: bold;">
					<?= number_format($total_rusak, 0, ',', '.'); ?>
				</td>
				<td colspan="5" style="padding: 7px 4px;"></td>
			</tr>
			<?php else: ?>
			<tr>
				<td colspan="11" class="text-center" style="padding: 16px; color: #64748b;">Tidak ada data stok yang sesuai dengan filter.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</page>
