<style type="text/css">
	* {
		font-family: helvetica, arial, sans-serif;
		font-size: 7.5pt;
		color: #1e293b;
	}
	
	/* Layout Header & KPI */
	.header-table {
		width: 100%;
		border-bottom: 2px solid #0f172a;
		padding-bottom: 8px;
		margin-bottom: 8px;
	}
	.report-title {
		font-size: 13pt;
		font-weight: bold;
		color: #0f172a;
		margin: 0 0 4px 0;
		letter-spacing: 0.2px;
	}
	.report-meta {
		font-size: 7.5pt;
		color: #475569;
		margin: 0;
		line-height: 1.4;
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
	.kpi-card-green { border-left: 3.5px solid #059669; }
	.kpi-card-sky { border-left: 3.5px solid #0284c7; }
	.kpi-card-violet { border-left: 3.5px solid #7c3aed; }
	
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
		background-color: #1e293b;
		color: #ffffff;
		font-weight: bold;
		padding: 6px 4px;
		border: 0.5px solid #0f172a;
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
	tr:hover { background-color: #f1f5f9; }
	
	/* Channel Tag Styles */
	.tag-shopee { color: #c2410c; font-weight: bold; }
	.tag-tiktok { color: #e11d48; font-weight: bold; }
	.tag-tokopedia { color: #15803d; font-weight: bold; }
	.tag-manual { color: #475569; font-weight: bold; }
	
	/* Status Badge Styles */
	.badge-selesai { color: #047857; font-weight: bold; }
	.badge-kirim { color: #0284c7; font-weight: bold; }
	.badge-proses { color: #d97706; font-weight: bold; }
	.badge-batal { color: #dc2626; font-weight: bold; }
	.badge-default { color: #475569; font-weight: bold; }
	
	.code-mono {
		font-family: courier;
		font-size: 7pt;
		letter-spacing: -0.3px;
	}
	
	.sub-text {
		font-size: 6.5pt;
		color: #64748b;
		line-height: 1.2;
	}
</style>

<page orientation="paysage" format="A4" backtop="8mm" backbottom="8mm" backleft="7mm" backright="7mm">
	<page_footer>
		<table style="width: 100%; border: none;">
			<tr>
				<td style="width: 60%; font-size: 7pt; color: #64748b;">
					Dicetak otomatis pada: <?= date('d/m/Y H:i:s'); ?> | Sistem Inventori &amp; Penjualan Marketplace IDMETAFORA
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
				<div class="report-title">LAPORAN REKAP PENJUALAN MARKETPLACE (REGISTER ALL)</div>
				<div class="report-meta">
					Saluran: <strong><?= !empty($source_sel) ? (in_array(strtolower($source_sel), ['resi', 'scan_resi', 'import_resi']) ? 'SCAN RESI (IMPORT RESI)' : strtoupper($source_sel)) : 'Semua Saluran (Shopee, Tokopedia, TikTok, Manual, Scan Resi)'; ?></strong>
					<?php if (!empty($status_sel)): ?>
						&nbsp;|&nbsp; Status: <strong><?= ucfirst($status_sel); ?></strong>
					<?php endif; ?>
					<?php if (!empty($search_q)): ?>
						&nbsp;|&nbsp; Filter Pencarian: <em>"<?= htmlspecialchars($search_q, ENT_QUOTES); ?>"</em>
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
					<div class="kpi-value"><?= number_format(count($results), 0, ',', '.'); ?> <span style="font-size:7.5pt; font-weight:normal; color:#64748b;">Pesanan</span></div>
				</div>
			</td>
			<td style="width: 25%; padding: 0 3px;">
				<div class="kpi-card kpi-card-green">
					<div class="kpi-label">TOTAL OMSET PENJUALAN</div>
					<div class="kpi-value" style="color: #059669;">Rp <?= number_format($summary['total_omset'] ?? 0, 0, ',', '.'); ?></div>
				</div>
			</td>
			<td style="width: 25%; padding: 0 3px;">
				<div class="kpi-card kpi-card-sky">
					<div class="kpi-label">PESANAN SELESAI / TERKIRIM</div>
					<div class="kpi-value" style="color: #0284c7;"><?= number_format($summary['total_selesai'] ?? 0, 0, ',', '.'); ?> <span style="font-size:7.5pt; font-weight:normal; color:#64748b;">Order</span></div>
				</div>
			</td>
			<td style="width: 25%; padding-left: 4px;">
				<div class="kpi-card kpi-card-violet">
					<div class="kpi-label">TOTAL ITEM TERJUAL</div>
					<div class="kpi-value" style="color: #7c3aed;"><?= number_format($summary['total_qty'] ?? 0, 0, ',', '.'); ?> <span style="font-size:7.5pt; font-weight:normal; color:#64748b;">Pcs</span></div>
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
				<th style="width: 10.5%;">No. Pesanan</th>
				<th style="width: 8.5%;">No. Transaksi Penjualan</th>
				<th style="width: 6.5%;">Saluran</th>
				<th style="width: 6.5%;">Status Pesanan</th>
				<th style="width: 9%;">No. Resi</th>
				<th style="width: 7.5%;">Kurir / Ekspedisi</th>
				<th style="width: 3%;">Qty</th>
				<th style="width: 6.5%;">Waktu Bayar</th>
				<th style="width: 7.5%;">Username Pembeli</th>
				<th style="width: 7.5%;">Nama Penerima</th>
				<th style="width: 7%;">No. Telepon</th>
				<th style="width: 8.5%;">Kota / Kab</th>
				<th style="width: 9%;">Total Nilai (Rp)</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no = 1; 
			$grand_total_all = 0;
			$grand_qty_all = 0;
			if (!empty($results)):
				foreach ($results as $row): 
					$is_even = ($no % 2 == 0);
					$total = (float)($row->total ?? 0);
					$qty = (float)($row->total_qty ?? 1);
					$grand_total_all += $total;
					$grand_qty_all += $qty;

					$no_pesanan = !empty($row->no_pesanan) ? $row->no_pesanan : ($row->nomor_so ?? '-');
					$nomor_so = !empty($row->nomor_so) ? $row->nomor_so : '-';
					$src_low = strtolower(trim((string)($row->source ?? '')));
					
					// Format Channel Tag
					if (in_array($src_low, ['tiktok', 'tiktokshop', 'tiktok_shop', 'tiktok shop'])) {
						$src_tag = '<span class="tag-tiktok">TIKTOK SHOP</span>';
					} elseif ($src_low === 'tokopedia') {
						$src_tag = '<span class="tag-tokopedia">TOKOPEDIA</span>';
					} elseif ($src_low === 'shopee') {
						$src_tag = '<span class="tag-shopee">SHOPEE</span>';
					} else {
						$src_tag = '<span class="tag-manual">' . strtoupper($row->source ?: 'MANUAL') . '</span>';
					}

					$is_resi_order = (
						in_array($src_low, ['resi', 'scan_resi', 'import_resi', 'scan']) ||
						($row->created_by ?? '') === 'import_resi' ||
						stripos($row->catatan ?? '', 'Auto-Created') !== false ||
						stripos($row->catatan ?? '', 'Label') !== false ||
						stripos($row->catatan ?? '', 'Scan Resi') !== false
					);
					if ($is_resi_order) {
						$src_tag .= ' <span class="tag-manual" style="background:#e0f2fe; color:#0284c7; border:1px solid #bae6fd;">SCAN RESI</span>';
					}

					$resi = !empty($row->nomor_resi) ? $row->nomor_resi : '-';
					$kurir = !empty($row->opsi_pengiriman) ? $row->opsi_pengiriman : (!empty($row->kurir_ekspedisi) ? $row->kurir_ekspedisi : '-');
					$waktu_bayar = !empty($row->waktu_pembayaran) ? date('d/m/Y H:i', strtotime($row->waktu_pembayaran)) : date('d/m/Y', strtotime($row->tanggal_so ?? $row->created_at));
					
					$penerima_val = !empty($row->nama_penerima) ? $row->nama_penerima : ($row->nama_pelanggan ?: '-');
					$telp_val = !empty($row->no_telepon) && $row->no_telepon !== '-' 
						? (string)$row->no_telepon 
						: (!empty($row->telp_pelanggan) && $row->telp_pelanggan !== '-' 
							? (string)$row->telp_pelanggan 
							: (!empty($row->no_telepon_pengirim) && $row->no_telepon_pengirim !== '-' 
								? (string)$row->no_telepon_pengirim 
								: '-'));
					$kota_val = !empty($row->kota_kabupaten) ? $row->kota_kabupaten : '-';

					// Status normalization & Badge Colors
					$st_raw = !empty($row->status_pesanan) ? $row->status_pesanan : ($row->status ?: '-');
					$st_low = strtolower(trim($st_raw));
					
					if (in_array($st_low, ['selesai', 'delivered', 'completed', 'sukses'])) {
						$st_class = 'badge-selesai';
						$st_label = 'Selesai';
					} elseif (in_array($st_low, ['dikirim', 'shipped', 'dalam pengiriman', 'on_delivery'])) {
						$st_class = 'badge-kirim';
						$st_label = 'Dikirim';
					} elseif (in_array($st_low, ['siap kirim', 'ready_to_ship', 'awaiting shipment', 'menunggu pengiriman'])) {
						$st_class = 'badge-proses';
						$st_label = 'Siap Kirim';
					} elseif (in_array($st_low, ['perlu dikirim', 'packing', 'diproses', 'menunggu diproses', 'process'])) {
						$st_class = 'badge-proses';
						$st_label = 'Dikemas';
					} elseif (in_array($st_low, ['dibatalkan', 'batal', 'cancelled', 'canceled'])) {
						$st_class = 'badge-batal';
						$st_label = 'Dibatalkan';
					} else {
						$st_class = 'badge-default';
						$st_label = ucwords($st_low);
					}
			?>
			<tr class="<?= $is_even ? 'even' : ''; ?>">
				<td class="text-center" style="width: 3%;"><?= $no++; ?></td>
				<td class="text-left code-mono" style="width: 10.5%; font-weight: bold;"><?= htmlspecialchars($no_pesanan, ENT_QUOTES); ?></td>
				<td class="text-left code-mono" style="width: 8.5%;"><?= htmlspecialchars($nomor_so, ENT_QUOTES); ?></td>
				<td class="text-center" style="width: 6.5%;"><?= $src_tag; ?></td>
				<td class="text-center <?= $st_class; ?>" style="width: 6.5%;"><?= htmlspecialchars($st_label, ENT_QUOTES); ?></td>
				<td class="text-center code-mono" style="width: 9%;"><?= htmlspecialchars($resi, ENT_QUOTES); ?></td>
				<td class="text-left" style="width: 7.5%;"><?= htmlspecialchars($kurir, ENT_QUOTES); ?></td>
				<td class="text-center" style="width: 3%; font-weight: bold;"><?= number_format($qty, 0, ',', '.'); ?></td>
				<td class="text-center" style="width: 6.5%; font-size: 6.5pt;"><?= htmlspecialchars($waktu_bayar, ENT_QUOTES); ?></td>
				<td class="text-left" style="width: 7.5%;"><strong><?= htmlspecialchars($buyer_val, ENT_QUOTES); ?></strong></td>
				<td class="text-left" style="width: 7.5%;"><?= htmlspecialchars($penerima_val, ENT_QUOTES); ?></td>
				<td class="text-center code-mono" style="width: 7%; font-size: 6.5pt;"><?= htmlspecialchars($telp_val, ENT_QUOTES); ?></td>
				<td class="text-left" style="width: 8.5%;"><?= htmlspecialchars($kota_val, ENT_QUOTES); ?></td>
				<td class="text-right" style="width: 9%; font-weight: bold;">
					<?php if ($total > 0): ?>
						<span style="color:#0f172a;">Rp <?= number_format($total, 0, ',', '.'); ?></span>
					<?php else: ?>
						<span style="color:#94a3b8; font-weight:normal;">Rp 0</span>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
			
			<!-- Footer Grand Total -->
			<tr style="background-color: #f1f5f9; font-weight: bold; border-top: 2px solid #cbd5e1;">
				<td colspan="7" class="text-center" style="padding: 7px 4px; font-weight: bold; color: #1e293b;">
					TOTAL KESELURUHAN (<?= number_format(count($results), 0, ',', '.'); ?> PESANAN TERDATA)
				</td>
				<td class="text-center" style="color: #1e293b; padding: 7px 4px; font-weight: bold;">
					<?= number_format($grand_qty_all, 0, ',', '.'); ?>
				</td>
				<td colspan="5" class="text-right" style="padding: 7px 4px; color: #64748b;">
					Total Nilai Transaksi:
				</td>
				<td class="text-right" style="color: #059669; padding: 7px 4px; font-weight: bold; font-size: 8pt;">
					Rp <?= number_format($grand_total_all, 0, ',', '.'); ?>
				</td>
			</tr>
			<?php else: ?>
			<tr>
				<td colspan="14" class="text-center" style="padding: 16px; color: #64748b;">
					Tidak ada data penjualan marketplace yang sesuai dengan kriteria filter.
				</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</page>
