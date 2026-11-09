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
	
	.badge-aktif { color: #047857; font-weight: bold; }
	.badge-nonaktif { color: #dc2626; font-weight: bold; }
	
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
					Dicetak otomatis pada: <?= date('d/m/Y H:i:s'); ?> | Sistem Inventori &amp; Master Produk IDMETAFORA
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
				<div class="report-title">LAPORAN MASTER DATA PRODUK &amp; KATALOG</div>
				<div class="report-meta">
					Daftar Katalog Produk &amp; Informasi Stok Keseluruhan
					<?php if (!empty($search_q)): ?>
						&nbsp;|&nbsp; Filter: <em>"<?= htmlspecialchars($search_q, ENT_QUOTES); ?>"</em>
					<?php endif; ?>
					<?php if (!empty($kategori_nama)): ?>
						&nbsp;|&nbsp; Kategori: <strong><?= htmlspecialchars($kategori_nama, ENT_QUOTES); ?></strong>
					<?php endif; ?>
					<?php if (!empty($status_sel)): ?>
						&nbsp;|&nbsp; Status: <strong><?= ucfirst($status_sel); ?></strong>
					<?php endif; ?>
				</div>
			</td>
			<td style="width: 32%; text-align: right; vertical-align: middle;">
				<table align="right" style="border-collapse: collapse; font-size: 8pt; color: #475569;">
					<tr>
						<td style="text-align: right; padding: 1px 0; font-weight: bold; color: #1e293b;">Total</td>
						<td style="width: 10px; text-align: center; padding: 1px 0; color: #1e293b;">:</td>
						<td style="text-align: left; padding: 1px 0; font-weight: bold; color: #1e293b;"><?= number_format(count($results), 0, ',', '.'); ?> Produk</td>
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

	<!-- Data Table -->
	<table class="data-table">
		<thead>
			<tr>
				<th style="width: 3.5%;">No</th>
				<th style="width: 13%;">Kode Produk</th>
				<th style="width: 27%;">Nama Produk</th>
				<th style="width: 14%;">Kategori</th>
				<th style="width: 6%;">Satuan</th>
				<th style="width: 12%;">Harga Beli</th>
				<th style="width: 12%;">Harga Jual</th>
				<th style="width: 4%;">Min</th>
				<th style="width: 4.5%;">Stok</th>
				<th style="width: 6%;">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no = 1; 
			$grand_stok = 0;
			if (!empty($results)):
				foreach ($results as $row): 
					$is_even = ($no % 2 == 0);
					$stok_val = (int)($row->total_stok ?? 0);
					$grand_stok += $stok_val;
			?>
			<tr class="<?= $is_even ? 'even' : ''; ?>">
				<td class="text-center" style="width: 3.5%;"><?= $no++; ?></td>
				<td class="text-center code-mono" style="width: 13%; font-weight: bold;"><?= htmlspecialchars($row->kode_produk, ENT_QUOTES); ?></td>
				<td class="text-left" style="width: 27%;"><?= htmlspecialchars($row->nama_produk, ENT_QUOTES); ?></td>
				<td class="text-left" style="width: 14%;"><?= htmlspecialchars($row->nama_kategori ?: '-', ENT_QUOTES); ?></td>
				<td class="text-center" style="width: 6%;"><?= htmlspecialchars($row->singkatan ?: '-', ENT_QUOTES); ?></td>
				<td class="text-right" style="width: 12%;">Rp <?= number_format((float)$row->harga_beli, 0, ',', '.'); ?></td>
				<td class="text-right" style="width: 12%; font-weight: bold;">Rp <?= number_format((float)$row->harga_jual, 0, ',', '.'); ?></td>
				<td class="text-center" style="width: 4%;"><?= (int)$row->stok_minimum; ?></td>
				<td class="text-center" style="width: 4.5%; font-weight: bold;"><?= $stok_val; ?></td>
				<td class="text-center <?= $row->status == 'aktif' ? 'badge-aktif' : 'badge-nonaktif'; ?>" style="width: 6%;">
					<?= ucfirst($row->status); ?>
				</td>
			</tr>
			<?php endforeach; ?>
			
			<!-- Footer Total -->
			<tr style="background-color: #f1f5f9; font-weight: bold; border-top: 2px solid #cbd5e1;">
				<td colspan="8" class="text-center" style="padding: 7px 4px; font-weight: bold; color: #1e293b;">
					TOTAL SELURUH ITEM KATALOG (<?= number_format(count($results), 0, ',', '.'); ?> PRODUK)
				</td>
				<td class="text-center" style="color: #1e40af; padding: 7px 4px; font-weight: bold;">
					<?= number_format($grand_stok, 0, ',', '.'); ?>
				</td>
				<td style="padding: 7px 4px;"></td>
			</tr>
			<?php else: ?>
			<tr>
				<td colspan="10" class="text-center" style="padding: 16px; color: #64748b;">Tidak ada data produk yang sesuai dengan filter.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</page>
