<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_besar extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_buku_besar');
	}

	private function check_access($perm = 'buku_besar_list')
	{
		if (!$this->aauth->is_allowed($perm) 
			&& !$this->aauth->is_allowed('menu_buku_besar_(general_ledger)')
			&& !$this->aauth->is_allowed('menu_buku_besar_general_ledger')
			&& !$this->aauth->is_allowed('utang_usaha_list')
			&& !$this->aauth->is_allowed('piutang_usaha_list')
			&& !$this->aauth->is_admin()) {
			$this->is_allowed($perm);
			return false;
		}
		return true;
	}

	public function index($offset = 0)
	{
		if (!$this->check_access('buku_besar_list')) {
			return;
		}

		$date_start = $this->input->get('date_start');
		$date_end   = $this->input->get('date_end');
		$category   = $this->input->get('category');
		$search     = $this->input->get('q');
		$type       = $this->input->get('type');

		$this->data['entries']      = $this->model_buku_besar->get_ledger_entries($date_start, $date_end, $category, $search, $this->limit_page, $offset, $type);
		$this->data['total_rows']   = $this->model_buku_besar->count_ledger_entries($date_start, $date_end, $category, $search, $type);
		$this->data['summary']      = $this->model_buku_besar->get_summary_kpi($date_start, $date_end, $category, $search);

		$config = [
			'base_url'    => 'administrator/buku_besar/index/',
			'total_rows'  => $this->data['total_rows'],
			'per_page'    => $this->limit_page,
			'uri_segment' => 4,
			'reuse_query_string' => true,
		];
		$this->data['pagination'] = $this->pagination($config);

		$this->data['filter_date_start'] = $date_start;
		$this->data['filter_date_end']   = $date_end;
		$this->data['filter_category']   = $category;
		$this->data['filter_search']     = $search;
		$this->data['filter_type']       = $type;

		$this->template->title('Buku Besar (General Ledger & Audit Transaksi)');
		$this->render('backend/standart/administrator/buku_besar/buku_besar_list', $this->data);
	}

	private function get_periode_label($date_start, $date_end)
	{
		if (!empty($date_start) && !empty($date_end)) {
			return date('d/m/Y', strtotime($date_start)) . ' s/d ' . date('d/m/Y', strtotime($date_end));
		} elseif (!empty($date_start)) {
			return 'Mulai ' . date('d/m/Y', strtotime($date_start));
		} elseif (!empty($date_end)) {
			return 'Sampai ' . date('d/m/Y', strtotime($date_end));
		}
		return 'Semua Periode Transaksi';
	}

	private function clean_deskripsi($str)
	{
		$str = str_replace('bank_transfer', 'Transfer Bank', $str);
		$str = str_replace('cash', 'Tunai', $str);
		$str = str_replace('COMPLETED', 'SELESAI', $str);
		return $str;
	}

	public function export_excel()
	{
		if (!$this->check_access('buku_besar_export')) {
			return;
		}

		$date_start = $this->input->get('date_start');
		$date_end   = $this->input->get('date_end');
		$category   = $this->input->get('category');
		$search     = $this->input->get('q');
		$type       = $this->input->get('type');

		$entries = $this->model_buku_besar->get_ledger_entries($date_start, $date_end, $category, $search, 0, 0, $type);
		$summary = $this->model_buku_besar->get_summary_kpi($date_start, $date_end, $category, $search);
		$periode = $this->get_periode_label($date_start, $date_end);

		if (ob_get_length()) { ob_end_clean(); }

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=Buku_Besar_Laporan_Keuangan_" . date('Ymd_His') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");


		echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
		echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Buku Besar</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
		echo '<style>
				body { font-family: Calibri, Arial, sans-serif; }
				.title-company { font-size: 15pt; font-weight: bold; color: #1e3a8a; }
				.title-report { font-size: 12pt; font-weight: bold; color: #0f172a; }
				.meta-info { font-size: 9.5pt; color: #475569; }
				.tbl-data { border-collapse: collapse; width: 100%; font-size: 10pt; }
				.tbl-data th { background-color: #1e3a8a; color: #ffffff; font-weight: bold; padding: 8px 6px; border: 1px solid #0f172a; text-align: center; }
				.tbl-data td { border: 1px solid #cbd5e1; padding: 6px 8px; vertical-align: middle; }
				.zebra { background-color: #f8fafc; }
				.text-center { text-align: center; }
				.text-right { text-align: right; }
				.text-bold { font-weight: bold; }
				.num-val { mso-number-format:"\#\,\#\#0"; text-align: right; }
				.date-val { mso-number-format:"\@"; text-align: center; }
				.text-val { mso-number-format:"\@"; }
				.tfoot-total { font-weight: bold; background-color: #e2e8f0; border-top: 1.5px solid #0f172a; border-bottom: 3px double #0f172a; }
			  </style></head><body>';

		// 1. Header Informasi Perusahaan & Laporan
		echo '<table border="0" cellpadding="0" cellspacing="0" style="margin-bottom:15px;">';
		echo '<tr><td colspan="8" class="title-company">' . strtoupper(get_option('site_name', 'IDMETAFORA')) . '</td></tr>';
		echo '<tr><td colspan="8" class="title-report">LAPORAN BUKU BESAR (GENERAL LEDGER &amp; AUDIT TRAIL)</td></tr>';
		echo '<tr><td colspan="8" class="meta-info">Periode Transaksi: <b>' . _ent($periode) . '</b></td></tr>';
		if (!empty($category)) {
			echo '<tr><td colspan="8" class="meta-info">Kategori Modul: <b>' . strtoupper(_ent($category)) . '</b></td></tr>';
		}
		if (!empty($search)) {
			echo '<tr><td colspan="8" class="meta-info">Kata Kunci Pencarian: <b>' . _ent($search) . '</b></td></tr>';
		}
		echo '<tr><td colspan="8" class="meta-info">Tanggal Cetak: ' . date('d/m/Y H:i:s') . ' | Oleh: ' . (get_user_data('username') ?: 'Administrator') . '</td></tr>';
		echo '<tr><td colspan="8" style="height:12px;"></td></tr>';
		echo '</table>';

		// 2. Ringkasan KPI
		echo '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse; font-size:9.5pt; margin-bottom:15px;">';
		echo '<tr style="background:#f1f5f9; font-weight:bold; text-align:center;">';
		echo '<th style="padding:6px 12px; background:#dcfce7; color:#166534;">Total Masuk (Debit)</th>';
		echo '<th style="padding:6px 12px; background:#fee2e2; color:#991b1b;">Total Keluar (Kredit)</th>';
		echo '<th style="padding:6px 12px; background:#eff6ff; color:#1e40af;">Saldo Bersih (Net Balance)</th>';
		echo '<th style="padding:6px 12px; background:#f8fafc; color:#334155;">Total Transaksi</th>';
		echo '</tr>';
		echo '<tr style="font-weight:bold; text-align:right;">';
		echo '<td class="num-val" style="color:#15803d; padding:6px 12px;">' . $summary['total_debit'] . '</td>';
		echo '<td class="num-val" style="color:#b91c1c; padding:6px 12px;">' . $summary['total_kredit'] . '</td>';
		echo '<td class="num-val" style="color:#1d4ed8; padding:6px 12px;">' . $summary['net_balance'] . '</td>';
		echo '<td class="text-center" style="padding:6px 12px;">' . $summary['total_transaksi'] . ' Data</td>';
		echo '</tr>';
		echo '</table>';

		echo '<br>';

		// 3. Data Table
		echo '<table border="1" class="tbl-data">';
		echo '<thead>
				<tr>
					<th width="45">No</th>
					<th width="110">Tanggal Transaksi</th>
					<th width="150">No. Referensi / Dokumen</th>
					<th width="150">Kategori Modul</th>
					<th width="200">Entitas / Pihak Terkait</th>
					<th width="320">Deskripsi / Uraian Transaksi</th>
					<th width="130">Debit / Masuk (Rp)</th>
					<th width="130">Kredit / Keluar (Rp)</th>
				</tr>
			  </thead><tbody>';

		$no = 1;
		$tot_debit = 0;
		$tot_kredit = 0;

		foreach ($entries as $row) {
			$tot_debit += (float)$row->debit;
			$tot_kredit += (float)$row->kredit;
			$bg = ($no % 2 == 0) ? ' class="zebra"' : '';
			$deskripsi = $this->clean_deskripsi($row->deskripsi);

			echo '<tr' . $bg . '>';
			echo '<td class="text-center">' . $no++ . '</td>';
			echo '<td class="date-val">' . date('d/m/Y', strtotime($row->tanggal)) . '</td>';
			echo '<td class="text-val text-bold text-center">' . _ent($row->nomor_ref) . '</td>';
			echo '<td class="text-center">' . _ent($row->modul_label) . '</td>';
			echo '<td>' . _ent($row->entitas) . '</td>';
			echo '<td>' . _ent($deskripsi) . '</td>';
			echo '<td class="num-val">' . (float)$row->debit . '</td>';
			echo '<td class="num-val">' . (float)$row->kredit . '</td>';
			echo '</tr>';
		}

		echo '</tbody><tfoot>';
		echo '<tr class="tfoot-total">';
		echo '<td colspan="6" class="text-right" style="padding:8px 12px;">TOTAL KESELURUHAN:</td>';
		echo '<td class="num-val" style="color:#15803d; padding:8px 6px;">' . $tot_debit . '</td>';
		echo '<td class="num-val" style="color:#b91c1c; padding:8px 6px;">' . $tot_kredit . '</td>';
		echo '</tr>';
		echo '<tr style="font-weight:bold; background-color:#f8fafc;">';
		echo '<td colspan="6" class="text-right" style="padding:6px 12px;">SALDO BERSIH (DEBIT - KREDIT):</td>';
		echo '<td colspan="2" class="num-val" style="color:#1d4ed8; padding:6px 12px; font-size:11pt;">Rp ' . number_format($tot_debit - $tot_kredit, 0, ',', '.') . '</td>';
		echo '</tr>';
		echo '</tfoot></table>';
		echo '</body></html>';
	}

	public function export_csv()
	{
		if (!$this->check_access('buku_besar_export')) {
			return;
		}

		$date_start = $this->input->get('date_start');
		$date_end   = $this->input->get('date_end');
		$category   = $this->input->get('category');
		$search     = $this->input->get('q');
		$type       = $this->input->get('type');

		$entries = $this->model_buku_besar->get_ledger_entries($date_start, $date_end, $category, $search, 0, 0, $type);
		$summary = $this->model_buku_besar->get_summary_kpi($date_start, $date_end, $category, $search);
		$periode = $this->get_periode_label($date_start, $date_end);
		if (ob_get_length()) { ob_end_clean(); }

		header('Content-Type: text/csv; charset=utf-8');

		header('Content-Disposition: attachment; filename=Buku_Besar_Laporan_Keuangan_' . date('Ymd_His') . '.csv');
		header('Pragma: no-cache');
		header('Expires: 0');

		// UTF-8 BOM for perfect Excel compatibility on Windows
		echo "\xEF\xBB\xBF";

		$out = fopen('php://output', 'w');

		// Header Information
		fputcsv($out, ['LAPORAN BUKU BESAR (GENERAL LEDGER)']);
		fputcsv($out, ['Perusahaan:', get_option('site_name', 'IDMETAFORA')]);
		fputcsv($out, ['Periode:', $periode]);
		if (!empty($category)) fputcsv($out, ['Kategori Modul:', strtoupper($category)]);
		if (!empty($search)) fputcsv($out, ['Pencarian:', $search]);
		fputcsv($out, ['Tanggal Unduh:', date('d/m/Y H:i:s'), 'Operator:', get_user_data('username') ?: 'Admin']);
		fputcsv($out, []); // Blank line

		// Table Columns
		fputcsv($out, [
			'No',
			'Tanggal Transaksi',
			'No. Referensi / Dokumen',
			'Kategori Modul',
			'Entitas / Pihak Terkait',
			'Deskripsi Transaksi',
			'Debit / Masuk (Rp)',
			'Kredit / Keluar (Rp)'
		]);

		$no = 1;
		$tot_debit = 0;
		$tot_kredit = 0;

		foreach ($entries as $row) {
			$tot_debit += (float)$row->debit;
			$tot_kredit += (float)$row->kredit;
			$deskripsi = $this->clean_deskripsi($row->deskripsi);

			fputcsv($out, [
				$no++,
				date('d/m/Y', strtotime($row->tanggal)),
				$row->nomor_ref,
				$row->modul_label,
				$row->entitas,
				$deskripsi,
				(float)$row->debit,
				(float)$row->kredit
			]);
		}

		// Footer Totals
		fputcsv($out, ['', '', '', '', '', 'TOTAL KESELURUHAN:', $tot_debit, $tot_kredit]);
		fputcsv($out, ['', '', '', '', '', 'SALDO BERSIH (NET BALANCE):', $tot_debit - $tot_kredit, '']);

		fclose($out);
	}

	public function export_pdf()
	{
		if (!$this->check_access('buku_besar_export')) {
			return;
		}

		$date_start = $this->input->get('date_start');
		$date_end   = $this->input->get('date_end');
		$category   = $this->input->get('category');
		$search     = $this->input->get('q');
		$type       = $this->input->get('type');

		$this->data['entries']       = $this->model_buku_besar->get_ledger_entries($date_start, $date_end, $category, $search, 0, 0, $type);
		$this->data['summary']       = $this->model_buku_besar->get_summary_kpi($date_start, $date_end, $category, $search);
		$this->data['periode_label'] = $this->get_periode_label($date_start, $date_end);

		$this->load->library('HtmlPdf');
		$this->htmlpdf->initialize([
			'orientation' => 'L',
			'format'      => 'A4',
			'marges'      => [8, 8, 8, 8]
		]);

		$content = $this->load->view('buku_besar/backend/standart/administrator/buku_besar/buku_besar_pdf', $this->data, true);
		$this->htmlpdf->writeHTML($content);

		$filename = 'Buku_Besar_Laporan_Keuangan_' . date('Ymd_His') . '.pdf';
		if (ob_get_length()) { ob_clean(); }

		$mode = $this->input->get('mode') === 'view' ? 'I' : 'D';
		$this->htmlpdf->Output($filename, $mode);
	}
}

/* End of file Buku_besar.php */
/* Location: ./modules/buku_besar/controllers/backend/Buku_besar.php */
