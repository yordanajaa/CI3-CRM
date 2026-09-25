<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfm extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_rfm');
	}

	// ===== Dashboard RFM =====

	public function index($offset = 0)
	{
		return $this->customer_list($offset);
	}

	public function dashboard()
	{
		$product_filter = $this->input->get('product');
		$period_filter = $this->input->get('period');

		$this->data['rfm_distribution'] = $this->model_rfm->get_rfm_dashboard_distribution($product_filter, $period_filter);
		$this->data['thresholds'] = $this->model_rfm->get_threshold_display($product_filter);
		$this->data['segments'] = $this->model_rfm->get_segment_definitions();
		$this->data['product_rfm_list'] = $this->model_rfm->get_product_rfm_list('', 25, 0);
		$this->data['products_list'] = $this->model_rfm->get_all_products_list();
		$this->data['months_list'] = $this->model_rfm->get_distinct_months_list();
		$this->data['monthly_tracking'] = $this->model_rfm->get_monthly_rfm_tracking_per_product($product_filter, $period_filter);
		$this->data['product_filter'] = $product_filter;
		$this->data['period_filter'] = $period_filter;

		// Quick stats per product (if filtered) or overall
		$result = $this->model_rfm->get_customers('', 10000, 0, '', $product_filter, $period_filter);
		$total = count($result['rows']);
		$avg_r = 0; $avg_f = 0; $avg_m = 0;
		$avg_days = 0; $avg_orders = 0; $avg_spend = 0;
		if ($total > 0) {
			foreach ($result['rows'] as $r) {
				$avg_r += $r->rfm['r_score'];
				$avg_f += $r->rfm['f_score'];
				$avg_m += $r->rfm['m_score'];
				$avg_days += ($r->rfm['days_since_last'] !== null ? $r->rfm['days_since_last'] : 0);
				$avg_orders += $r->total_orders;
				$avg_spend += $r->total_spend;
			}
			$avg_r = round($avg_r / $total, 1);
			$avg_f = round($avg_f / $total, 1);
			$avg_m = round($avg_m / $total, 1);
			$avg_days = round($avg_days / $total, 0);
			$avg_orders = round($avg_orders / $total, 1);
			$avg_spend = round($avg_spend / $total, 0);
		}
		$this->data['filtered_customers'] = $result['rows'];
		$this->data['kpis'] = [
			'total_customers' => $total,
			'avg_r' => $avg_r,
			'avg_f' => $avg_f,
			'avg_m' => $avg_m,
			'avg_days' => $avg_days,
			'avg_orders' => $avg_orders,
			'avg_spend' => $avg_spend,
		];

		$this->template->title('Analisis RFM — Dashboard');
		$this->render('backend/standart/administrator/rfm/rfm_dashboard', $this->data);
	}

	public function tracking()
	{
		$product_filter = $this->input->get('product');
		$period_filter = $this->input->get('period');
		$compare_a = $this->input->get('compare_a');
		$compare_b = $this->input->get('compare_b');

		$this->data['products_list'] = $this->model_rfm->get_all_products_list();
		$this->data['months_list'] = $this->model_rfm->get_distinct_months_list();
		$this->data['monthly_tracking'] = $this->model_rfm->get_monthly_rfm_tracking_per_product($product_filter, $period_filter);
		$this->data['product_filter'] = $product_filter;
		$this->data['period_filter'] = $period_filter;
		$this->data['compare_a'] = $compare_a;
		$this->data['compare_b'] = $compare_b;

		// Summary statistics
		$track_data = $this->data['monthly_tracking'] ?? [];
		$track_cnt = count($track_data);
		$total_sum_spend = array_sum(array_column($track_data, 'total_spend'));
		$avg_sum_spend = $track_cnt > 0 ? $total_sum_spend / $track_cnt : 0;
		$total_sum_buyers = array_sum(array_column($track_data, 'unique_buyers'));
		$avg_sum_buyers = $track_cnt > 0 ? $total_sum_buyers / $track_cnt : 0;
		$total_sum_orders = array_sum(array_column($track_data, 'total_orders'));

		$this->data['kpi_tracking'] = [
			'track_cnt' => $track_cnt,
			'total_sum_spend' => $total_sum_spend,
			'avg_sum_spend' => $avg_sum_spend,
			'total_sum_buyers' => $total_sum_buyers,
			'avg_sum_buyers' => $avg_sum_buyers,
			'total_sum_orders' => $total_sum_orders
		];

		$this->template->title('Analisis RFM — Tracking & Tren Bulanan');
		$this->render('backend/standart/administrator/rfm/rfm_tracking', $this->data);
	}

	public function cohort()
	{
		$mode = $this->input->get('mode') ?: 'monthly';
		$year = $this->input->get('year') ?: date('Y');
		$month = $this->input->get('month') ?: date('m');

		$this->data['cohort'] = $this->model_rfm->get_cohort_analysis($mode, $year, $month);
		$this->data['cohort_mode'] = $mode;
		$this->data['cohort_year'] = $year;
		$this->data['cohort_month'] = $month;

		// Get available years from database
		$this->data['available_years'] = $this->db->query("
			SELECT DISTINCT YEAR(tanggal_so) as yr FROM (
				SELECT tanggal_so FROM sales_order WHERE tanggal_so IS NOT NULL AND tanggal_so > '1970-01-01'
				UNION ALL
				SELECT tanggal_so FROM penjualan_marketplace WHERE tanggal_so IS NOT NULL AND tanggal_so > '1970-01-01'
			) u ORDER BY yr DESC
		")->result();

		$this->template->title('Analisis RFM — Analisis Kohort');
		$this->render('backend/standart/administrator/rfm/rfm_cohort', $this->data);
	}

	// ===== Segment Strategy CRUD =====

	public function save_segment_strategy()
	{
		$id = $this->input->post('id');
		$segment = trim($this->input->post('segment'));
		$icon = trim($this->input->post('icon'));
		$color = trim($this->input->post('color'));
		$goal = trim($this->input->post('goal'));
		$action = trim($this->input->post('action'));
		$sort_order = (int)$this->input->post('sort_order');

		if (empty($segment)) {
			set_message('Nama segmen tidak boleh kosong!', 'error');
			redirect('administrator/rfm/dashboard');
			return;
		}

		$data = [
			'segment' => $segment,
			'icon' => !empty($icon) ? $icon : 'fa-star',
			'color' => !empty($color) ? $color : '#6366f1',
			'goal' => $goal,
			'action' => $action,
			'sort_order' => $sort_order,
		];

		if (!empty($id)) {
			$this->model_rfm->update_segment_strategy($id, $data);
			set_message('Strategi segmen RFM berhasil diperbarui!', 'success');
		} else {
			$this->model_rfm->add_segment_strategy($data);
			set_message('Strategi segmen RFM baru berhasil ditambahkan!', 'success');
		}

		redirect('administrator/rfm/dashboard');
	}

	public function delete_segment_strategy($id = null)
	{
		if ($id) {
			$this->model_rfm->delete_segment_strategy($id);
			set_message('Strategi segmen RFM berhasil dihapus!', 'success');
		} else {
			set_message('ID segmen tidak valid!', 'error');
		}

		redirect('administrator/rfm/dashboard');
	}

	// ===== Customer List with RFM =====

	public function customer_list($offset = 0)
	{
		$filter = $this->input->get('q');
		$rfm_segment = $this->input->get('rfm_segment');
		$product_filter = $this->input->get('product');
		$period_filter = $this->input->get('period');

		$result = $this->model_rfm->get_customers($filter, $this->limit_page, $offset, $rfm_segment, $product_filter, $period_filter);

		$this->data['customers'] = $result['rows'];
		$this->data['customer_counts'] = $result['total'];
		$this->data['total_orders'] = $result['total_orders'] ?? 0;
		$this->data['total_spend'] = $result['total_spend'] ?? 0;
		$this->data['filter'] = $filter;
		$this->data['rfm_segment'] = $rfm_segment;
		$this->data['product_filter'] = $product_filter;
		$this->data['period_filter'] = $period_filter;
		$this->data['products_list'] = $this->model_rfm->get_all_products_list();
		$this->data['months_list'] = $this->model_rfm->get_distinct_months_list();

		// Product Recap: when filtered by product, get product-level summary
		$this->data['product_recap'] = null;
		if (!empty($product_filter)) {
			$product_rfm_all = $this->model_rfm->get_product_rfm_list($product_filter, 1, 0);
			if (!empty($product_rfm_all['rows'])) {
				$this->data['product_recap'] = $product_rfm_all['rows'][0];
			}
			// Get RFM distribution for this product
			$this->data['product_distribution'] = $this->model_rfm->get_rfm_dashboard_distribution($product_filter, $period_filter);
		}

		$config = [
			'base_url'    => 'administrator/rfm/index/',
			'total_rows'  => $result['total'],
			'per_page'    => $this->limit_page,
			'uri_segment' => 4,
		];
		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Analisis RFM — Segmentasi Pelanggan');
		$this->render('backend/standart/administrator/rfm/rfm_customer_list', $this->data);
	}

	// ===== Customer Detail =====

	public function customer_detail()
	{
		$phone = $this->input->get('phone');
		$product_filter = $this->input->get('product');
		$period_filter = $this->input->get('period');
		if (empty($phone)) {
			set_message('Nomor telepon customer tidak valid.', 'error');
			redirect('administrator/rfm');
		}

		// Summary is evaluated for product_filter if provided, or overall if empty
		$this->data['summary'] = $this->model_rfm->get_customer_summary($phone, $product_filter);
		$this->data['overall_summary'] = $this->model_rfm->get_customer_summary($phone, '');
		$this->data['transactions'] = $this->model_rfm->get_customer_transactions($phone, $product_filter);
		$this->data['product_rfm'] = $this->model_rfm->get_customer_product_rfm($phone);
		$this->data['phone'] = $phone;
		$this->data['product_filter'] = $product_filter;
		$this->data['period_filter'] = $period_filter;

		$this->template->title('Analisis RFM — Detail Customer');
		$this->render('backend/standart/administrator/rfm/rfm_customer_detail', $this->data);
	}

	// ===== Transaction Detail AJAX =====

	public function transaction_detail_ajax()
	{
		header('Content-Type: application/json');
		$table = $this->input->get('table');
		$order_id = $this->input->get('order_id');
		if (!$table || !$order_id) {
			echo json_encode(['success' => false, 'message' => 'Parameter tidak valid']); return;
		}
		$items = $this->model_rfm->get_transaction_items($table, $order_id);
		echo json_encode(['success' => true, 'items' => $items]);
	}

	// ===== Export =====

	public function export_customers()
	{
		$filter = $this->input->get('q');
		$rfm_segment = $this->input->get('rfm_segment');
		$product = $this->input->get('product');
		$period = $this->input->get('period');
		$result = $this->model_rfm->get_customers($filter, 10000, 0, $rfm_segment, $product, $period);

		$filename_parts = ['RFM'];
		if (!empty($rfm_segment)) {
			$filename_parts[] = preg_replace('/[^a-zA-Z0-9_]/', '_', $rfm_segment);
		}
		if (!empty($product)) {
			$filename_parts[] = preg_replace('/[^a-zA-Z0-9_]/', '_', substr($product, 0, 20));
		}
		$filename_parts[] = date('Ymd_His');
		$filename = implode('_', $filename_parts) . '.csv';

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		
		$output = fopen('php://output', 'w');

		// UTF-8 BOM + Excel separator instruction for 100% automatic multi-column parsing
		fprintf($output, "\xEF\xBB\xBF");
		fwrite($output, "sep=;\r\n");

		// Header columns (separated by semicolon)
		fputcsv($output, [
			'No', 
			'Nama Customer', 
			'No Telepon', 
			'Filter Produk',
			'Total Order (Frequency)', 
			'Total Spend (Monetary)', 
			'Recency (Hari)',
			'R Score', 
			'F Score', 
			'M Score', 
			'RFM Code', 
			'Segment Pasar',
			'Target Goal',
			'Rekomendasi Aksi WA'
		], ';');

		$no = 1;
		foreach ($result['rows'] as $c) {
			$raw_phone = preg_replace('/[^0-9]/', '', $c->customer_phone ?? '');
			$phone_formatted = !empty($raw_phone) ? '="' . $raw_phone . '"' : '-';
			$product_label = !empty($product) ? $product : 'Semua Produk';
			
			fputcsv($output, [
				$no++,
				$c->customer_nama,
				$phone_formatted,
				$product_label,
				(int)$c->total_orders,
				(float)$c->total_spend,
				(int)($c->rfm['days_since_last'] ?? 0),
				(int)$c->rfm['r_score'],
				(int)$c->rfm['f_score'],
				(int)$c->rfm['m_score'],
				$c->rfm['rfm_code'],
				$c->rfm['segment'],
				$c->rfm['goal'] ?? '-',
				$c->rfm['action'] ?? '-'
			], ';');
		}
		fclose($output);
		exit;
	}

	// ===== Import Excel (Large Data & RFM Matrix) =====

	public function import_excel()
	{
		@ini_set('memory_limit', '512M');
		@set_time_limit(300);

		if (isset($_FILES['file_excel']['error']) && $_FILES['file_excel']['error'] !== UPLOAD_ERR_OK) {
			$err_code = $_FILES['file_excel']['error'];
			$err_msg = 'Gagal mengunggah file. ';
			if ($err_code === UPLOAD_ERR_INI_SIZE || $err_code === UPLOAD_ERR_FORM_SIZE) {
				$err_msg .= 'Ukuran file melebihi batas upload_max_filesize di server hosting.';
			} elseif ($err_code === UPLOAD_ERR_NO_FILE) {
				$err_msg .= 'Silakan pilih file Excel (.xlsx, .xls) atau CSV yang akan diimport.';
			} else {
				$err_msg .= 'Kode error upload: ' . $err_code;
			}
			set_message($err_msg, 'error');
			redirect('administrator/rfm');
			return;
		}

		if (empty($_FILES['file_excel']['name'])) {
			set_message('Silakan pilih file Excel (.xlsx, .xls) atau CSV yang akan diimport.', 'error');
			redirect('administrator/rfm');
			return;
		}

		$file_tmp = $_FILES['file_excel']['tmp_name'];
		$file_name = $_FILES['file_excel']['name'];
		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

		if (!in_array($ext, ['xlsx', 'xls', 'csv'])) {
			set_message('Format file tidak didukung! Harus berupa .xlsx, .xls, atau .csv.', 'error');
			redirect('administrator/rfm');
			return;
		}

		$rows = [];

		try {
			if ($ext === 'csv') {
				// Pure native PHP CSV parser - fast, lightweight, 0 MB overhead, works on all hosting environments without PHPZip/PHPExcel dependencies
				$handle = fopen($file_tmp, 'r');
				if ($handle !== false) {
					// Detect UTF-8 BOM
					$bom = fread($handle, 3);
					if ($bom !== "\xEF\xBB\xBF") {
						rewind($handle);
					}
					
					// Detect Delimiter (; or \t or ,)
					$first_line = fgets($handle);
					if ($bom !== "\xEF\xBB\xBF") {
						rewind($handle);
					} else {
						fseek($handle, 3);
					}

					$delimiter = ';';
					if (strpos($first_line, ';') !== false) {
						$delimiter = ';';
					} elseif (strpos($first_line, "\t") !== false) {
						$delimiter = "\t";
					} else {
						$delimiter = ',';
					}

					$r_idx = 1;
					while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
						if (empty($data) || (count($data) === 1 && trim((string)$data[0]) === '')) continue;
						$row_dict = [];
						$col_letter = 'A';
						foreach ($data as $cell) {
							$row_dict[$col_letter] = trim((string)$cell);
							$col_letter++;
						}
						$rows[$r_idx] = $row_dict;
						$r_idx++;
					}
					fclose($handle);
				}
			} else {
				require_once FCPATH . 'application/libraries/Excel/PHPExcel/IOFactory.php';
				$objPHPExcel = PHPExcel_IOFactory::load($file_tmp);
				$sheet = $objPHPExcel->getActiveSheet();
				$rows = $sheet->toArray(null, true, true, true);
			}
		} catch (Exception $e) {
			set_message('Gagal membaca file data: ' . $e->getMessage(), 'error');
			redirect('administrator/rfm');
			return;
		}

		if (empty($rows) || count($rows) < 2) {
			set_message('File Excel kosong atau tidak memiliki data.', 'error');
			redirect('administrator/rfm');
			return;
		}

		$header_row = $rows[1];
		$import_type = $this->input->post('import_type'); // 'auto', 'matrix', 'transactions'

		// Auto-detect file type if set to auto
		if (empty($import_type) || $import_type === 'auto') {
			$has_r = false; $has_f = false; $has_m = false; $has_seg = false;
			foreach ($header_row as $colLetter => $hText) {
				if (empty($hText)) continue;
				$hNorm = strtolower(trim(preg_replace('/[^a-zA-Z]/', '', $hText)));
				if ($hNorm === 'recency') $has_r = true;
				if ($hNorm === 'frequency') $has_f = true;
				if ($hNorm === 'monetary') $has_m = true;
				if ($hNorm === 'segment' || $hNorm === 'segments') $has_seg = true;
			}
			$import_type = ($has_r && $has_f && $has_m && $has_seg) ? 'matrix' : 'transactions';
		}

		if ($import_type === 'matrix') {
			$this->_import_rfm_matrix_rules($rows);
		} else {
			$this->_import_transactions_data($rows);
		}
	}

	private function _import_rfm_matrix_rules($rows)
	{
		$header_row = $rows[1];
		$col_map = [];

		foreach ($header_row as $colLetter => $hText) {
			if (empty($hText)) continue;
			$hNorm = strtolower(trim(preg_replace('/[^a-zA-Z]/', '', $hText)));
			if ($hNorm === 'recency') $col_map['r'] = $colLetter;
			if ($hNorm === 'frequency') $col_map['f'] = $colLetter;
			if ($hNorm === 'monetary') $col_map['m'] = $colLetter;
			if ($hNorm === 'rfm') $col_map['rfm'] = $colLetter;
			if ($hNorm === 'segment' || $hNorm === 'segments') { if (!isset($col_map['segment'])) $col_map['segment'] = $colLetter; }
			if ($hNorm === 'goals' || $hNorm === 'goal') { if (!isset($col_map['goal'])) $col_map['goal'] = $colLetter; }
			if ($hNorm === 'actions' || $hNorm === 'action') { if (!isset($col_map['action'])) $col_map['action'] = $colLetter; }
		}

		// Defaults for standard sheet structure if columns not explicitly named
		if (!isset($col_map['r'])) $col_map['r'] = 'B';
		if (!isset($col_map['f'])) $col_map['f'] = 'C';
		if (!isset($col_map['m'])) $col_map['m'] = 'D';
		if (!isset($col_map['rfm'])) $col_map['rfm'] = 'E';
		if (!isset($col_map['segment'])) $col_map['segment'] = 'F';
		if (!isset($col_map['goal'])) $col_map['goal'] = 'G';
		if (!isset($col_map['action'])) $col_map['action'] = 'H';

		$matrix_rules = [];
		for ($r = 2; $r <= count($rows); $r++) {
			$row = $rows[$r];
			$r_val = (int)($row[$col_map['r']] ?? 0);
			$f_val = (int)($row[$col_map['f']] ?? 0);
			$m_val = (int)($row[$col_map['m']] ?? 0);
			$code = trim((string)($row[$col_map['rfm']] ?? ''));

			if (empty($code) && $r_val > 0 && $f_val > 0 && $m_val > 0) {
				$code = "{$r_val}{$f_val}{$m_val}";
			}

			$segment = trim((string)($row[$col_map['segment']] ?? ''));
			$goal = trim((string)($row[$col_map['goal']] ?? ''));
			$action = trim((string)($row[$col_map['action']] ?? ''));

			if (!empty($code) && strlen($code) === 3 && !empty($segment)) {
				$matrix_rules[$code] = [
					'r' => $r_val ?: (int)$code[0],
					'f' => $f_val ?: (int)$code[1],
					'm' => $m_val ?: (int)$code[2],
					'segment' => $segment,
					'goal' => $goal,
					'action' => $action
				];
			}
		}

		if (empty($matrix_rules)) {
			set_message('Gagal meng-import aturan RFM. Kolom data tidak valid atau kosong.', 'error');
			redirect('administrator/rfm');
			return;
		}

		$this->model_rfm->save_rfm_matrix_custom($matrix_rules);
		set_message('Berhasil meng-import ' . count($matrix_rules) . ' aturan kombinasi matriks RFM dari file Excel!', 'success');
		redirect('administrator/rfm/dashboard');
	}

	private function _import_transactions_data($rows)
	{
		$header_row = $rows[1];
		$col_map = [];

		// Precise & Flexible column matching for sales transactions
		foreach ($header_row as $colLetter => $hText) {
			if (empty($hText)) continue;
			$hNorm = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '', $hText)));

			if (in_array($hNorm, ['nopesanan', 'orderid', 'noso', 'nomorpesanan'])) {
				$col_map['order_id'] = $colLetter;
			} elseif (in_array($hNorm, ['namapenerima', 'usernamepembeli', 'namacustomer', 'namapelanggan', 'nama', 'username', 'customer'])) {
				if (!isset($col_map['customer_name'])) $col_map['customer_name'] = $colLetter;
			} elseif (in_array($hNorm, ['notelepon', 'telepon', 'nohp', 'hp', 'phone', 'notelp'])) {
				if (!isset($col_map['phone'])) $col_map['phone'] = $colLetter;
			} elseif (in_array($hNorm, ['namaproduk', 'skuinduk', 'kodeproduk', 'produk', 'itemname'])) {
				if (!isset($col_map['product'])) $col_map['product'] = $colLetter;
			} elseif (in_array($hNorm, ['jumlah', 'jumlahprodukdipesan', 'qty', 'quantity'])) {
				if (!isset($col_map['qty'])) $col_map['qty'] = $colLetter;
			} elseif (in_array($hNorm, ['totalpembayaran', 'totalhargaproduk', 'hargasetelahdiskon', 'total', 'subtotal', 'monetary'])) {
				if (!isset($col_map['total'])) $col_map['total'] = $colLetter;
			} elseif (in_array($hNorm, ['hargasatuan', 'harga'])) {
				if (!isset($col_map['unit_price'])) $col_map['unit_price'] = $colLetter;
			} elseif (in_array($hNorm, ['waktupembayarandilakukan', 'waktupesanandibuat', 'tanggalso', 'tanggal', 'waktupembayaran', 'date'])) {
				if (!isset($col_map['date'])) $col_map['date'] = $colLetter;
			} elseif (in_array($hNorm, ['statuspesanan', 'status'])) {
				if (!isset($col_map['status'])) $col_map['status'] = $colLetter;
			}
		}

		$default_pelanggan = $this->db->get_where('pelanggan', ['kode_pelanggan' => 'CUS-MARKETPLACE'])->row() ?: $this->db->get('pelanggan')->row();
		$default_gudang = $this->db->get_where('gudang', ['status' => 'aktif'])->row();
		$pelanggan_id = $default_pelanggan ? $default_pelanggan->id : 1;
		$gudang_id = $default_gudang ? $default_gudang->id : 1;

		$success_count = 0;
		$skipped_count = 0;

		for ($r = 2; $r <= count($rows); $r++) {
			$row = $rows[$r];
			if (empty(array_filter($row))) continue;

			$no_pesanan = isset($col_map['order_id']) ? trim((string)($row[$col_map['order_id']] ?? '')) : '';
			if (empty($no_pesanan)) {
				$no_pesanan = 'IMP-' . date('Ymd') . '-' . str_pad($r - 1, 5, '0', STR_PAD_LEFT);
			}

			// Check duplicate
			$existing = $this->db->get_where('sales_order', ['no_pesanan' => $no_pesanan])->row();
			if ($existing) {
				$skipped_count++;
				continue;
			}

			$customer_name = isset($col_map['customer_name']) ? trim((string)($row[$col_map['customer_name']] ?? '')) : 'Customer Excel';
			$phone_raw = isset($col_map['phone']) ? trim((string)($row[$col_map['phone']] ?? '')) : '';
			$phone = preg_replace('/[^0-9]/', '', $phone_raw);

			$product_name = isset($col_map['product']) ? trim((string)($row[$col_map['product']] ?? '')) : 'Produk General';
			$qty_raw = isset($col_map['qty']) ? $row[$col_map['qty']] : 1;
			$qty = max(1, (float)str_replace(['.', ','], '', (string)$qty_raw));

			$unit_price_raw = isset($col_map['unit_price']) ? $row[$col_map['unit_price']] : 0;
			$unit_price = (float)str_replace(['.', ',', 'Rp', ' '], '', (string)$unit_price_raw);

			$total_raw = isset($col_map['total']) ? $row[$col_map['total']] : 0;
			$total = (float)str_replace(['.', ',', 'Rp', ' '], '', (string)$total_raw);

			if ($total <= 0 && $unit_price > 0) {
				$total = $unit_price * $qty;
			}
			if ($unit_price <= 0 && $qty > 0 && $total > 0) {
				$unit_price = $total / $qty;
			}

			$date_raw = isset($col_map['date']) ? trim((string)($row[$col_map['date']] ?? '')) : '';
			$date_time = !empty($date_raw) ? date('Y-m-d H:i:s', strtotime($date_raw)) : date('Y-m-d H:i:s');
			$tanggal_so = !empty($date_raw) ? date('Y-m-d', strtotime($date_raw)) : date('Y-m-d');

			$raw_status = isset($col_map['status']) ? strtolower(trim((string)($row[$col_map['status']] ?? ''))) : 'selesai';
			$status = 'delivered';
			if (strpos($raw_status, 'batal') !== false || strpos($raw_status, 'cancel') !== false) {
				$status = 'cancelled';
			} elseif (strpos($raw_status, 'kirim') !== false || strpos($raw_status, 'ship') !== false) {
				$status = 'shipped';
			}

			// Generate guaranteed unique nomor_so within 28 chars to prevent MySQL UNIQUE constraint error
			$nomor_so_code = 'SO-IMP-' . date('Ymd') . '-' . mt_rand(100, 999) . '-' . sprintf('%04d', $r);
			if (strlen($nomor_so_code) > 28) {
				$nomor_so_code = substr($nomor_so_code, 0, 28);
			}
			while ($this->db->get_where('sales_order', ['nomor_so' => $nomor_so_code])->num_rows() > 0) {
				$nomor_so_code = 'SO-IMP-' . date('Ymd') . '-' . mt_rand(1000, 9999) . '-' . mt_rand(10, 99);
			}

			$so_data = [
				'nomor_so'            => $nomor_so_code,
				'no_pesanan'          => $no_pesanan,
				'source'              => 'excel_import',
				'pelanggan_id'        => $pelanggan_id,
				'gudang_id'           => $gudang_id,
				'tanggal_so'          => $tanggal_so,
				'status'              => $status,
				'status_pesanan'      => $raw_status ?: 'Selesai',
				'waktu_pembayaran'    => $date_time,
				'username_pembeli'    => $customer_name,
				'nama_penerima'       => $customer_name,
				'no_telepon'          => $phone ?: '08123456789',
				'nama_produk_marketplace' => $product_name,
				'subtotal'            => $total,
				'total'               => $total,
				'catatan'             => 'Import Excel RFM - Buyer: ' . $customer_name,
				'created_by'          => get_user_data('username'),
				'created_at'          => date('Y-m-d H:i:s'),
			];

			try {
				$this->db->insert('sales_order', $so_data);
				$so_id = $this->db->insert_id();

				if ($so_id) {
					$prod = $this->db->like('nama_produk', $product_name)->get('produk')->row();
					if (!$prod) {
						$prod = $this->db->get('produk')->row();
					}

					$this->db->insert('sales_order_item', [
						'so_id'         => $so_id,
						'produk_id'     => $prod ? $prod->id : 1,
						'qty'           => $qty,
						'satuan'        => 'pcs',
						'harga_satuan'  => $unit_price,
						'diskon_persen' => 0,
						'diskon_nominal'=> 0,
						'subtotal'      => $total,
						'catatan'       => $product_name,
					]);

					$success_count++;
				}
			} catch (Exception $db_err) {
				$skipped_count++;
				log_message('error', 'RFM Import DB Error: ' . $db_err->getMessage());
			}
		}

		if ($success_count > 0) {
			set_message("Berhasil meng-import {$success_count} data pesanan dari file Excel! ({$skipped_count} pesanan duplikat dilewati). Analisis RFM pelanggan telah diperbarui otomatis.", 'success');
		} else {
			set_message("Tidak ada data pesanan baru yang berhasil diimport ({$skipped_count} pesanan duplikat dilewati).", 'warning');
		}

		redirect('administrator/rfm');
	}

	public function download_template_matrix()
	{
		$headers = ['No.', 'Recency', 'Frequency', 'Monetary', 'RFM', 'Segment', 'Goals', 'Actions'];
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=template_matriks_rfm_125_aturan.csv');
		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fputcsv($output, $headers, ';');

		$matrix = $this->model_rfm->get_rfm_matrix();
		$no = 1;
		foreach ($matrix as $code => $m) {
			fputcsv($output, [
				$no++,
				$m['r'],
				$m['f'],
				$m['m'],
				$code,
				$m['segment'],
				$m['goal'],
				$m['action']
			], ';');
		}
		fclose($output);
		exit;
	}

	public function download_template_transactions()
	{
		$headers = ['No. Pesanan', 'Status Pesanan', 'Waktu Pembayaran Dilakukan', 'Nama Produk', 'Jumlah', 'Total Pembayaran', 'Username (Pembeli)', 'Nama Penerima', 'No. Telepon', 'Alamat Pengiriman', 'Kota/Kabupaten', 'Provinsi'];
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=template_import_transaksi_sales_rfm.csv');
		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fputcsv($output, $headers, ';');
		
		// Sample row
		fputcsv($output, [
			'TRX-20260918-001',
			'Selesai',
			date('Y-m-d H:i:s'),
			'Laptop Pro 15-inch Intel i7 16GB SSD 512GB',
			'1',
			'15500000',
			'budi_santoso',
			'Budi Santoso',
			'081234567890',
			'Jl. Merdeka No. 12',
			'Surabaya',
			'Jawa Timur'
		], ';');

		fclose($output);
		exit;
	}
}
