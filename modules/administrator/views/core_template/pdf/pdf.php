<?php
$is_landscape = (isset($orientation) && $orientation === 'l') || (count($fields) > 4);
$page_orientation = $is_landscape ? 'paysage' : 'portrait';

// Hitung bobot setiap kolom agar persentase lebar kolom proporsional dan tidak terpotong
$col_weights = [];
$total_weight = 0;
foreach ($fields as $field) {
    $f_lower = strtolower($field);
    if ($f_lower === 'id' || $f_lower === 'no') {
        $weight = 0.8;
    } elseif (strpos($f_lower, 'status') !== false || strpos($f_lower, 'singkatan') !== false) {
        $weight = 1.3;
    } elseif (strpos($f_lower, 'tanggal') !== false || strpos($f_lower, 'created_at') !== false || strpos($f_lower, 'updated_at') !== false) {
        $weight = 1.8;
    } elseif (strpos($f_lower, 'kode') !== false || strpos($f_lower, 'tipe') !== false || strpos($f_lower, 'telepon') !== false || strpos($f_lower, 'no_telp') !== false) {
        $weight = 1.7;
    } elseif (strpos($f_lower, 'nama') !== false || strpos($f_lower, 'email') !== false || strpos($f_lower, 'title') !== false) {
        $weight = 2.8;
    } elseif (strpos($f_lower, 'deskripsi') !== false || strpos($f_lower, 'keterangan') !== false || strpos($f_lower, 'alamat') !== false || strpos($f_lower, 'catatan') !== false) {
        $weight = 3.2;
    } else {
        $weight = 1.6;
    }
    $col_weights[$field] = $weight;
    $total_weight += $weight;
}

// Alokasikan persentase lebar kolom
$no_pct = $is_landscape ? 4.0 : 5.0;
$rem_pct = 100.0 - $no_pct;
$col_pcts = [];
$sum_pcts = 0;
$field_keys = array_values($fields);
$last_field = end($field_keys);

foreach ($fields as $field) {
    $pct = round(($col_weights[$field] / $total_weight) * $rem_pct, 1);
    $pct = max(5.0, $pct);
    $col_pcts[$field] = $pct;
    $sum_pcts += $pct;
}

// Koreksi selisih pembulatan pada kolom terakhir agar total persentase tepat 100%
$diff = (100.0 - $no_pct) - $sum_pcts;
if ($last_field && isset($col_pcts[$last_field])) {
    $col_pcts[$last_field] = round($col_pcts[$last_field] + $diff, 1);
}

// Penyesuaian font
$f_count = count($fields);
$font_size = $f_count > 10 ? '6.5pt' : ($f_count > 6 ? '7pt' : '7.5pt');
$th_font_size = $f_count > 10 ? '6.5pt' : ($f_count > 6 ? '7pt' : '7.5pt');
?>
<style type="text/css">
	* {
		font-family: Arial, Helvetica, sans-serif;
		font-size: <?= $font_size; ?>;
		color: #1e293b;
	}
	table.data-table {
		width: 100%;
		border-collapse: collapse;
		margin-top: 8px;
		table-layout: fixed;
	}
	table.data-table thead th {
		background-color: #1e40af;
		color: #ffffff;
		font-weight: bold;
		padding: 5px 3px;
		border: 0.5px solid #1e3a8a;
		text-align: center;
		font-size: <?= $th_font_size; ?>;
	}
	table.data-table tbody td {
		padding: 4px 3px;
		border: 0.5px solid #cbd5e1;
		font-size: <?= $font_size; ?>;
		word-wrap: break-word;
	}
	.text-center { text-align: center; }
	.text-right { text-align: right; }
	.text-left { text-align: left; }
	tr.even { background-color: #f8fafc; }
</style>
<page orientation="<?= $page_orientation; ?>" format="A4" backtop="8mm" backbottom="8mm" backleft="7mm" backright="7mm">
	<page_footer>
		<table style="width: 100%; border: none;">
			<tr>
				<td style="width: 50%; font-size: 7pt; color: #64748b;">
					Dicetak pada: <?= date('d/m/Y H:i'); ?> | Sistem IDMETAFORA
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
				<h2 style="margin: 0; font-size: 13pt; color: #1e40af; font-weight: bold;"><?= htmlspecialchars(strtoupper($title), ENT_QUOTES); ?></h2>
				<p style="margin: 2px 0 0 0; font-size: 7.5pt; color: #64748b;">Rekap Data Sistem Realtime</p>
			</td>
			<td style="width: 30%; text-align: right;">
				<span style="font-size: 8pt; color: #334155;">Total Record: <strong><?= count($results); ?> Data</strong></span><br>
				<span style="font-size: 7pt; color: #64748b;">Tanggal: <?= date('d M Y'); ?></span>
			</td>
		</tr>
	</table>

	<table class="data-table">
		<thead>
			<tr>
				<th style="width: <?= $no_pct; ?>%;">No</th>
			<?php foreach ($fields as $field): 
				$header_text = !empty($labels[$field]) ? $labels[$field] : ucwords(str_replace(['_', '-'], ' ', $field));
			?>
				<th style="width: <?= $col_pcts[$field]; ?>%;"><?= htmlspecialchars($header_text, ENT_QUOTES); ?></th>
			<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php 
			$no = 1; 
			if (!empty($results)):
				foreach ($results as $row): 
					$is_even = ($no % 2 == 0);
			?>
			<tr class="<?= $is_even ? 'even' : ''; ?>">
				<td class="text-center" style="width: <?= $no_pct; ?>%;"><?= $no++; ?></td>
				<?php foreach ($fields as $field): 
					$val = $row->{$field} ?? '';
					$f_lower = strtolower($field);
					$align = 'text-left';
					$extra_style = '';

					if ($f_lower === 'id' || strpos($f_lower, 'status') !== false || strpos($f_lower, 'singkatan') !== false) {
						$align = 'text-center';
						if ($f_lower === 'status' || strpos($f_lower, 'status') !== false || $f_lower === 'banned') {
							$v_low = strtolower((string)$val);
							if (in_array($v_low, ['aktif', 'delivered', 'paid', 'lunas', 'selesai', 'success', 'completed', '0'])) {
								$extra_style = 'color: #065f46; font-weight: bold;';
								if ($val === '0' && $f_lower === 'banned') $val = 'Aktif';
							} elseif (in_array($v_low, ['nonaktif', 'cancelled', 'tempo', 'banned', '1', 'rusak', 'habis'])) {
								$extra_style = 'color: #b91c1c; font-weight: bold;';
								if ($val === '1' && $f_lower === 'banned') $val = 'Banned';
							} else {
								$extra_style = 'font-weight: bold;';
							}
						}
					} elseif (strpos($f_lower, 'tanggal') !== false || strpos($f_lower, 'created_at') !== false || strpos($f_lower, 'updated_at') !== false || strpos($f_lower, 'last_login') !== false) {
						$align = 'text-center';
						if (!empty($val) && strtotime($val) > 0) {
							if (strpos($f_lower, 'created_at') !== false || strpos($f_lower, 'updated_at') !== false || strpos($f_lower, 'last_login') !== false) {
								$val = date('d/m/Y H:i', strtotime($val));
							} else {
								$val = date('d/m/Y', strtotime($val));
							}
						}
					} elseif (in_array($f_lower, ['total', 'subtotal', 'diskon', 'diskon_total', 'harga', 'limit_kredit', 'sisa_utang', 'sisa_piutang', 'total_nilai', 'terbayar', 'sisa'])) {
						$align = 'text-right';
						$extra_style = 'font-weight: bold;';
						$val = 'Rp ' . number_format((float)$val, 0, ',', '.');
					} elseif (is_numeric($val) && strpos($f_lower, 'kode') === false && strpos($f_lower, 'telp') === false && strpos($f_lower, 'id') === false) {
						$align = 'text-right';
					}

					// Wrap kata panjang tanpa spasi agar tidak meluap keluar sel di HTML2PDF
					$display_str = (string)$val;
					if (strlen($display_str) > 25 && strpos($display_str, ' ') === false) {
						$display_str = wordwrap($display_str, 20, ' ', true);
					}
				?>
					<td class="<?= $align; ?>" style="width: <?= $col_pcts[$field]; ?>%; <?= $extra_style; ?>">
						<?= htmlspecialchars($display_str, ENT_QUOTES); ?>
					</td>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<tr>
				<td colspan="<?= count($fields) + 1; ?>" class="text-center" style="padding: 12px; color: #64748b;">Tidak ada data yang ditemukan.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</page>
