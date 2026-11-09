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
		$category_filter = $this->input->get('kategori');

		$this->data['rfm_distribution'] = $this->model_rfm->get_rfm_dashboard_distribution($product_filter, $period_filter, $category_filter);
		$this->data['thresholds'] = $this->model_rfm->get_threshold_display($product_filter);
		$this->data['segments'] = $this->model_rfm->get_segment_definitions();
		$this->data['product_rfm_list'] = $this->model_rfm->get_product_rfm_list('', 25, 0);
		$this->data['products_list'] = $this->model_rfm->get_all_products_list($category_filter);
		$this->data['categories_list'] = $this->model_rfm->get_all_categories_list();
		$this->data['months_list'] = $this->model_rfm->get_distinct_months_list();
		$this->data['monthly_tracking'] = $this->model_rfm->get_monthly_rfm_tracking_per_product($product_filter, $period_filter, '', $category_filter);
		$this->data['product_filter'] = $product_filter;
		$this->data['period_filter'] = $period_filter;
		$this->data['category_filter'] = $category_filter;

		// Quick stats per product (if filtered) or overall
		$result = $this->model_rfm->get_customers('', 10000, 0, '', $product_filter, $period_filter, $category_filter);
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
		$year_filter = $this->input->get('year');
		$category_filter = $this->input->get('kategori');
		$brand_filter = $this->input->get('brand') ?: $category_filter;
		$specialist_filter = $this->input->get('specialist');
		$status_rfm_raw = $this->input->get('status_rfm');
		$status_rfm = [];
		if (is_array($status_rfm_raw)) {
			$status_rfm = array_filter($status_rfm_raw);
		} elseif (!empty($status_rfm_raw)) {
			$status_rfm = array_filter(explode(',', $status_rfm_raw));
		}

		$compare_a = $this->input->get('compare_a');
		$compare_b = $this->input->get('compare_b');

		// Date range filters for RFM tracking (only load data when user has explicitly selected both start & end dates and submitted)
		$has_filtered = ($this->input->get('filtered') == '1' || $this->input->get('filtered') === 'true');
		$raw_date_from = trim($this->input->get('date_from') ?: '');
		$raw_date_to = trim($this->input->get('date_to') ?: '');

		$is_filtered = ($has_filtered && !empty($raw_date_from) && !empty($raw_date_to));

		$date_from = $is_filtered ? $raw_date_from : '';
		$date_to = $is_filtered ? $raw_date_to : '';

		if (!$is_filtered) {
			$status_rfm = [];
			$category_filter = '';
			$product_filter = '';
			$brand_filter = '';
			$specialist_filter = '';
		}

		$this->data['is_filtered'] = $is_filtered;
		$this->data['date_from'] = $date_from;
		$this->data['date_to'] = $date_to;

		$this->data['products_list'] = $this->model_rfm->get_all_products_list($category_filter);
		$this->data['categories_list'] = $this->model_rfm->get_all_categories_list();
		$this->data['brands_list'] = $this->data['categories_list'];
		
		// Fetch specialist list from aauth_users and sales_order
		$this->data['specialists_list'] = $this->db->select('username, full_name, email')->get('aauth_users')->result();
		
		$this->data['months_list'] = $this->model_rfm->get_distinct_months_list();
		$this->data['monthly_tracking'] = $this->model_rfm->get_monthly_rfm_tracking_per_product($product_filter, $period_filter, $year_filter, $category_filter);
		$this->data['all_historical_tracking'] = $this->model_rfm->get_monthly_rfm_tracking_per_product($product_filter, '', $year_filter, $category_filter);
		$this->data['product_filter'] = $product_filter;
		$this->data['period_filter'] = $period_filter;
		$this->data['year_filter'] = $year_filter;
		$this->data['category_filter'] = $category_filter;
		$this->data['brand_filter'] = $brand_filter;
		$this->data['specialist_filter'] = $specialist_filter;
		$this->data['status_rfm_selected'] = $status_rfm;
		$this->data['compare_a'] = $compare_a;
		$this->data['compare_b'] = $compare_b;

		// Get available years from database
		$this->data['available_years'] = $this->model_rfm->get_distinct_years_list();

		// Summary statistics
		$track_data = $this->data['monthly_tracking'] ?? [];
		$track_cnt = count($track_data);
		$total_sum_spend = array_sum(array_column($track_data, 'total_spend'));
		$avg_sum_spend = $track_cnt > 0 ? $total_sum_spend / $track_cnt : 0;
		$total_sum_buyers = array_sum(array_column($track_data, 'unique_buyers'));
		$avg_sum_buyers = $track_cnt > 0 ? $total_sum_buyers / $track_cnt : 0;
		$total_sum_orders = array_sum(array_column($track_data, 'total_orders'));

		// Fetch top products and platform breakdown for Month A and Month B comparison
		$hist_list = $this->data['all_historical_tracking'] ?? $track_data;
		$ym_a = !empty($compare_a) ? $compare_a : (!empty($period_filter) ? $period_filter : (!empty($hist_list[0]->ym_period) ? $hist_list[0]->ym_period : ''));
		$ym_b = !empty($compare_b) ? $compare_b : (!empty($hist_list[1]->ym_period) ? $hist_list[1]->ym_period : $ym_a);

		$this->data['top_products_a'] = !empty($ym_a) ? $this->model_rfm->get_top_products_by_month($ym_a, $product_filter, 5) : [];
		$this->data['top_products_b'] = !empty($ym_b) ? $this->model_rfm->get_top_products_by_month($ym_b, $product_filter, 5) : [];
		$this->data['platform_a'] = !empty($ym_a) ? $this->model_rfm->get_platform_breakdown_by_month($ym_a, $product_filter) : [];
		$this->data['platform_b'] = !empty($ym_b) ? $this->model_rfm->get_platform_breakdown_by_month($ym_b, $product_filter) : [];

		$total_sum_profit = array_sum(array_column($track_data, 'total_profit'));
		$avg_sum_profit = $track_cnt > 0 ? $total_sum_profit / $track_cnt : 0;

		$this->data['kpi_tracking'] = [
			'track_cnt' => $track_cnt,
			'total_sum_spend' => $total_sum_spend,
			'avg_sum_spend' => $avg_sum_spend,
			'total_sum_profit' => $total_sum_profit,
			'avg_sum_profit' => $avg_sum_profit,
			'total_sum_buyers' => $total_sum_buyers,
			'avg_sum_buyers' => $avg_sum_buyers,
			'total_sum_orders' => $total_sum_orders
		];

		// Complete Daily RFM tracking and BC followup summary (only if user filtered)
		$this->data['daily_tracking'] = $is_filtered ? $this->model_rfm->get_daily_rfm_tracking($date_from, $date_to, $category_filter, $product_filter, $status_rfm, $brand_filter, $specialist_filter) : [];
		$this->data['bc_summary'] = $is_filtered ? $this->model_rfm->get_daily_bc_summary($date_from, $date_to) : [];

		$this->template->title('RFM Tracking Register All');
		$this->render('backend/standart/administrator/rfm/rfm_tracking', $this->data);
	}

	public function tracking_drilldown_ajax()
	{
		header('Content-Type: application/json');
		$date = $this->input->get('date');
		$segment = $this->input->get('segment') ?: 'all';
		$category = $this->input->get('kategori');
		$product = $this->input->get('product');
		$brand = $this->input->get('brand') ?: $category;
		$specialist = $this->input->get('specialist');

		if (empty($date)) {
			echo json_encode(['success' => false, 'message' => 'Parameter tanggal wajib diisi']);
			return;
		}

		$data = $this->model_rfm->get_rfm_tracking_drilldown($date, $segment, $category, $product, $brand, $specialist);
		echo json_encode([
			'success' => true,
			'date' => $date,
			'formatted_date' => date('l, d M Y', strtotime($date)),
			'segment' => $segment,
			'count' => count($data),
			'customers' => $data,
			'data' => $data
		]);
	}

	public function cohort()
	{
		$mode = $this->input->get('mode') ?: 'monthly';
		$year = $this->input->get('year');
		$month = $this->input->get('month') ?: date('m');
		$product = $this->input->get('product') ?: '';
		$category = $this->input->get('kategori') ?: '';

		// Get available years from database
		$available_years = $this->model_rfm->get_distinct_years_list();
		$this->data['available_years'] = $available_years;

		$avail_yr_values = !empty($available_years) ? array_map(function($y) { return (string)$y->yr; }, $available_years) : [];
		if (empty($year) || (!empty($avail_yr_values) && !in_array((string)$year, $avail_yr_values))) {
			$year = !empty($avail_yr_values) ? $avail_yr_values[0] : date('Y');
		}

		$this->data['cohort'] = $this->model_rfm->get_cohort_analysis($mode, $year, $month, $product, $category);
		$this->data['cohort_mode'] = $mode;
		$this->data['cohort_year'] = $year;
		$this->data['cohort_month'] = $month;
		$this->data['cohort_product'] = $product;
		$this->data['cohort_category'] = $category;

		// Get category list and filtered product list for dropdown filter
		$this->data['categories_list'] = $this->model_rfm->get_all_categories_list();
		$this->data['products_list'] = $this->model_rfm->get_all_products_list($category);
		$this->data['product_list'] = $this->data['products_list'];
		$this->data['product_cohort_summary'] = $this->model_rfm->get_product_cohort_summary($year, $category);

		$this->template->title('Analisis RFM — Analisis Kohort');
		$this->render('backend/standart/administrator/rfm/rfm_cohort', $this->data);
	}

	public function cohort_drilldown_ajax()
	{
		header('Content-Type: application/json');
		$cohort = $this->input->get('cohort');
		$target = $this->input->get('target');
		$mode = $this->input->get('mode') ?: 'monthly';
		$product = $this->input->get('product') ?: '';
		$category = $this->input->get('kategori') ?: '';

		if (empty($cohort) || $target === null || $target === '') {
			echo json_encode(['success' => false, 'message' => 'Parameter periode tidak lengkap']);
			return;
		}

		$data = $this->model_rfm->get_cohort_drilldown_customers($cohort, $target, $mode, $product, $category);
		echo json_encode(['success' => true, 'data' => $data]);
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

		if (!empty($id)) {
			// Update existing segment: focused on goal and action
			$existing = $this->db->get_where('rfm_segment_strategy', ['id' => $id])->row();
			$data = [
				'goal' => $goal,
				'action' => $action,
			];
			if (!empty($segment)) {
				$data['segment'] = $segment;
			} elseif ($existing) {
				$data['segment'] = $existing->segment;
			}
			if (!empty($icon)) {
				$data['icon'] = $icon;
			} elseif ($existing) {
				$data['icon'] = $existing->icon;
			}
			if (!empty($color)) {
				$data['color'] = $color;
			} elseif ($existing) {
				$data['color'] = $existing->color;
			}
			if ($this->input->post('sort_order') !== null && $this->input->post('sort_order') !== '') {
				$data['sort_order'] = $sort_order;
			} elseif ($existing) {
				$data['sort_order'] = (int)$existing->sort_order;
			}

			$this->model_rfm->update_segment_strategy($id, $data);
			set_message('Strategi segmen RFM berhasil diperbarui!', 'success');
		} else {
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
		$category_filter = $this->input->get('kategori');

		$result = $this->model_rfm->get_customers($filter, $this->limit_page, $offset, $rfm_segment, $product_filter, $period_filter, $category_filter);

		$this->data['customers'] = $result['rows'];
		$this->data['customer_counts'] = $result['total'];
		$this->data['total_orders'] = $result['total_orders'] ?? 0;
		$this->data['total_spend'] = $result['total_spend'] ?? 0;
		$this->data['filter'] = $filter;
		$this->data['rfm_segment'] = $rfm_segment;
		$this->data['product_filter'] = $product_filter;
		$this->data['period_filter'] = $period_filter;
		$this->data['category_filter'] = $category_filter;
		$this->data['products_list'] = $this->model_rfm->get_all_products_list($category_filter);
		$this->data['categories_list'] = $this->model_rfm->get_all_categories_list();
		$this->data['months_list'] = $this->model_rfm->get_distinct_months_list();

		// Product Recap: when filtered by product, get product-level summary
		$this->data['product_recap'] = null;
		if (!empty($product_filter)) {
			$product_rfm_all = $this->model_rfm->get_product_rfm_list($product_filter, 1, 0);
			if (!empty($product_rfm_all['rows'])) {
				$this->data['product_recap'] = $product_rfm_all['rows'][0];
			}
			// Get RFM distribution for this product
			$this->data['product_distribution'] = $this->model_rfm->get_rfm_dashboard_distribution($product_filter, $period_filter, $category_filter);
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

	public function customer_detail($phone_segment = null)
	{
		$phone = $this->input->get('phone');
		if (empty($phone) && !empty($phone_segment)) {
			$phone = urldecode($phone_segment);
		}
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

	/**
	 * Output a CSV line compatible with Microsoft Excel, LibreOffice Calc, and Google Sheets
	 * Preserves ="..." text formulas for phone numbers, resi, and dates without escaping double quotes
	 */
	protected function write_excel_csv_line($fp, array $fields, $delimiter = ';')
	{
		$escaped = [];
		foreach ($fields as $field) {
			$field = (string)$field;
			if (preg_match('/^=".*"$/', $field)) {
				$escaped[] = $field;
			} elseif (strpos($field, $delimiter) !== false || strpos($field, '"') !== false || strpos($field, "\n") !== false || strpos($field, "\r") !== false) {
				$escaped[] = '"' . str_replace('"', '""', $field) . '"';
			} else {
				$escaped[] = $field;
			}
		}
		fwrite($fp, implode($delimiter, $escaped) . "\r\n");
	}

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

		if (ob_get_length()) { ob_end_clean(); }

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		
		$output = fopen('php://output', 'w');

		// UTF-8 BOM + Excel separator instruction for 100% automatic multi-column parsing
		fprintf($output, "\xEF\xBB\xBF");
		fwrite($output, "sep=;\r\n");

		// Header columns (separated by semicolon)
		$this->write_excel_csv_line($output, [
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
			
			$this->write_excel_csv_line($output, [
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

	public function export_cohort()
	{
		$mode = $this->input->get('mode') ?: 'monthly';
		$year = $this->input->get('year') ?: date('Y');
		$month = $this->input->get('month') ?: date('m');
		$product = $this->input->get('product') ?: '';
		$category = $this->input->get('kategori') ?: '';

		$cohort_data = $this->model_rfm->get_cohort_analysis($mode, $year, $month, $product, $category);

		$month_names_id = [
			1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
			5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
			9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
		];

		$filename_parts = ['Kohort', ucfirst($mode), $year];
		if ($mode === 'daily') {
			$filename_parts[] = 'Bln' . $month;
		}
		if (!empty($category)) {
			$filename_parts[] = preg_replace('/[^a-zA-Z0-9_]/', '_', substr($category, 0, 15));
		}
		if (!empty($product)) {
			$filename_parts[] = preg_replace('/[^a-zA-Z0-9_]/', '_', substr($product, 0, 15));
		}
		$filename_parts[] = date('Ymd_His');
		$filename = implode('_', $filename_parts) . '.csv';

		if (ob_get_length()) { ob_end_clean(); }

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');

		$output = fopen('php://output', 'w');

		// UTF-8 BOM + Excel separator instruction for 100% automatic multi-column parsing
		fprintf($output, "\xEF\xBB\xBF");
		fwrite($output, "sep=;\r\n");

		// Header Meta
		fputcsv($output, ['LAPORAN ANALISIS KOHORT RETENSI & OMSET PELANGGAN'], ';');
		fputcsv($output, ['Mode Analisis', ($mode === 'daily' ? 'Harian (Bulan ' . ($month_names_id[(int)$month] ?? $month) . ' ' . $year . ')' : 'Bulanan (Tahun ' . $year . ')')], ';');
		fputcsv($output, ['Tahun Periode', $year], ';');
		fputcsv($output, ['Filter Kategori', (!empty($category) ? $category : 'Semua Kategori')], ';');
		fputcsv($output, ['Filter Produk', (!empty($product) ? $product : 'Semua Produk (Keseluruhan)')], ';');
		fputcsv($output, ['Tanggal Unduh', date('d-m-Y H:i:s')], ';');
		fputcsv($output, [], ';');

		$cohorts = $cohort_data['cohorts'] ?? [];
		$periods = $cohort_data['periods'] ?? [];
		$aggregate = $cohort_data['aggregate'] ?? [];
		$summary = $cohort_data['summary'] ?? [];

		// Executive KPIs
		$avg_m1 = 0;
		$m1_vals = [];
		foreach ($cohorts as $ch) {
			$m_idx = (int)substr($ch['date_label'] ?? '', 5, 2);
			if (isset($ch['retention'][$m_idx + 1]) && $ch['retention'][$m_idx + 1] !== null) {
				$m1_vals[] = $ch['retention'][$m_idx + 1];
			}
		}
		if (!empty($m1_vals)) {
			$avg_m1 = round(array_sum($m1_vals) / count($m1_vals), 1);
		}

		fputcsv($output, ['RINGKASAN EKSEKUTIF & KPI'], ';');
		fputcsv($output, ['Total Kelompok Kohort', count($cohorts)], ';');
		fputcsv($output, ['Total Pelanggan Terakuisisi', ($summary['total_customers'] ?? 0)], ';');
		fputcsv($output, ['Total Omset Terdata', 'Rp ' . number_format($summary['total_revenue'] ?? 0, 0, ',', '.')], ';');
		fputcsv($output, ['Rata-rata Retensi M+1 (Repeat Order Bulan Ke-2)', $avg_m1 . '%'], ';');
		fputcsv($output, [], ';');

		// TABLE 1: RETENSI (%)
		fputcsv($output, ['1. TABEL HEATMAP RETENSI PELANGGAN (%)'], ';');
		$th1 = ['No', 'Kohort Akuisisi', 'Jumlah Pelanggan (Size)', 'Total Omset Kohort (Rp)'];
		foreach ($periods as $p_idx => $p_name) {
			$th1[] = $p_name;
		}
		fputcsv($output, $th1, ';');

		$no = 1;
		foreach ($cohorts as $ch) {
			$row = [
				$no++,
				$ch['label'] ?? '',
				$ch['size'] ?? 0,
				'Rp ' . number_format($ch['total_revenue'] ?? 0, 0, ',', '.')
			];
			foreach ($periods as $p_idx => $p_name) {
				if (isset($ch['retention'][$p_idx]) && $ch['retention'][$p_idx] !== null) {
					$row[] = number_format($ch['retention'][$p_idx], 1, ',', '') . '%';
				} else {
					$row[] = '-';
				}
			}
			fputcsv($output, $row, ';');
		}

		// Aggregate Row for Table 1
		if (!empty($aggregate)) {
			$agg_row1 = [
				'',
				'Rata-rata Retensi Keseluruhan',
				$aggregate['size'] ?? 0,
				'Rp ' . number_format($aggregate['total_revenue'] ?? 0, 0, ',', '.')
			];
			foreach ($periods as $p_idx => $p_name) {
				if (isset($aggregate['retention'][$p_idx]) && $aggregate['retention'][$p_idx] !== null) {
					$agg_row1[] = number_format($aggregate['retention'][$p_idx], 1, ',', '') . '%';
				} else {
					$agg_row1[] = '-';
				}
			}
			fputcsv($output, $agg_row1, ';');
		}

		fputcsv($output, [], ';');

		// TABLE 2: OMSET (RP)
		fputcsv($output, ['2. TABEL HEATMAP OMSET PENJUALAN (RP)'], ';');
		$th2 = ['No', 'Kohort Akuisisi', 'Jumlah Pelanggan (Size)', 'Total Omset Kohort (Rp)'];
		foreach ($periods as $p_idx => $p_name) {
			$th2[] = $p_name;
		}
		fputcsv($output, $th2, ';');

		$no = 1;
		foreach ($cohorts as $ch) {
			$row = [
				$no++,
				$ch['label'] ?? '',
				$ch['size'] ?? 0,
				'Rp ' . number_format($ch['total_revenue'] ?? 0, 0, ',', '.')
			];
			foreach ($periods as $p_idx => $p_name) {
				if (isset($ch['revenue'][$p_idx]) && $ch['revenue'][$p_idx] !== null) {
					$row[] = 'Rp ' . number_format($ch['revenue'][$p_idx], 0, ',', '.');
				} else {
					$row[] = '-';
				}
			}
			fputcsv($output, $row, ';');
		}

		// Aggregate Row for Table 2
		if (!empty($aggregate)) {
			$agg_row2 = [
				'',
				'Total Omset Keseluruhan',
				$aggregate['size'] ?? 0,
				'Rp ' . number_format($aggregate['total_revenue'] ?? 0, 0, ',', '.')
			];
			foreach ($periods as $p_idx => $p_name) {
				if (isset($aggregate['revenue'][$p_idx]) && $aggregate['revenue'][$p_idx] !== null) {
					$agg_row2[] = 'Rp ' . number_format($aggregate['revenue'][$p_idx], 0, ',', '.');
				} else {
					$agg_row2[] = '-';
				}
			}
			fputcsv($output, $agg_row2, ';');
		}

		fclose($output);
		exit;
	}

	public function export_cohort_drilldown()
	{
		$cohort = $this->input->get('cohort');
		$target = $this->input->get('target');
		$mode = $this->input->get('mode') ?: 'monthly';
		$product = $this->input->get('product') ?: '';
		$category = $this->input->get('kategori') ?: '';
		$filter = $this->input->get('filter') ?: 'all'; // all, retained, churned

		if (empty($cohort) || $target === null || $target === '') {
			show_error('Parameter periode kohort tidak lengkap.');
			return;
		}

		$data = $this->model_rfm->get_cohort_drilldown_customers($cohort, $target, $mode, $product, $category);

		$filename = 'Detail_Customer_Kohort_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $cohort) . '_ke_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $target) . '_' . date('Ymd_His') . '.csv';

		if (ob_get_length()) { ob_end_clean(); }

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');

		$output = fopen('php://output', 'w');

		// UTF-8 BOM + sep=;
		fprintf($output, "\xEF\xBB\xBF");
		fwrite($output, "sep=;\r\n");

		// Metadata
		fputcsv($output, ['DAFTAR CUSTOMER KOHORT DRILL-DOWN'], ';');
		fputcsv($output, ['Kohort Asal', $cohort], ';');
		fputcsv($output, ['Periode Target', $target], ';');
		fputcsv($output, ['Filter Status', strtoupper($filter)], ';');
		if (!empty($category)) {
			fputcsv($output, ['Filter Kategori', $category], ';');
		}
		if (!empty($product)) {
			fputcsv($output, ['Filter Produk', $product], ';');
		}
		fputcsv($output, ['Total Customer Kohort', $data['total_cohort'] ?? 0], ';');
		fputcsv($output, ['Repeat Order (Retained)', ($data['retained_count'] ?? 0) . ' (' . ($data['retention_pct'] ?? 0) . '%)'], ';');
		fputcsv($output, ['Belum Repeat Order (Churn Risk)', ($data['churned_count'] ?? 0)], ';');
		fputcsv($output, ['Tanggal Unduh', date('d-m-Y H:i:s')], ';');
		fputcsv($output, [], ';');

		// Header Table
		$this->write_excel_csv_line($output, [
			'No',
			'Nama Customer',
			'No Telepon',
			'Status Kohort',
			'Belanja di Periode Ini (Rp)',
			'Total Belanja Akumulasi (Rp)',
			'Total Order',
			'Tanggal Transaksi Terakhir',
			'Link WhatsApp Follow-up',
			'Link Profil CRM'
		], ';');

		$list = [];
		if ($filter === 'retained') {
			$list = $data['retained_customers'] ?? [];
		} elseif ($filter === 'churned') {
			$list = $data['churned_customers'] ?? [];
		} else {
			$list = array_merge($data['retained_customers'] ?? [], $data['churned_customers'] ?? []);
		}

		$no = 1;
		foreach ($list as $c) {
			$raw_phone = preg_replace('/[^0-9]/', '', $c['phone'] ?? '');
			$phone_formatted = !empty($raw_phone) ? '="' . $raw_phone . '"' : '-';
			$status_text = !empty($c['is_retained']) ? 'Repeat Order' : 'Belum Order (Churn Risk)';

			$wa_num = $raw_phone;
			if (substr($wa_num, 0, 1) === '0') {
				$wa_num = '62' . substr($wa_num, 1);
			}
			$wa_link = !empty($wa_num) ? 'https://api.whatsapp.com/send?phone=' . $wa_num : '-';
			$crm_link = site_url('administrator/crm/customer_detail/' . ($raw_phone ?: ''));

			$this->write_excel_csv_line($output, [
				$no++,
				$c['nama'] ?? 'Pelanggan',
				$phone_formatted,
				$status_text,
				(float)($c['target_spend'] ?? 0),
				(float)($c['total_spend'] ?? 0),
				(int)($c['total_orders'] ?? 1),
				$c['last_order_date'] ?? '-',
				$wa_link,
				$crm_link
			], ';');
		}

		fclose($output);
		exit;
	}

	// ===== Import Excel (Large Data & RFM Matrix) =====

	private function _clean_number($val)
	{
		if (is_numeric($val)) return (float)$val;
		$str = trim((string)$val);
		if (empty($str)) return 0;
		// Strip currency symbols and spaces
		$str = preg_replace('/[^\d.,]/', '', $str);
		// If ends with ,00 or .00, remove decimal zero part
		$str = preg_replace('/[,.]00$/', '', $str);
		// If has comma followed by 1 or 2 digits at the end e.g. 50000,50
		if (preg_match('/,(\d{1,2})$/', $str, $dm)) {
			$str = preg_replace('/,(\d{1,2})$/', '.$1', $str);
			$str = str_replace([',', ' '], '', $str);
			return (float)$str;
		}
		// Standard cleanup: remove dots and commas used as thousand separators
		$str = str_replace(['.', ',', ' '], '', $str);
		return (float)$str;
	}

	private function _parse_clean_date($raw)
	{
		$raw = trim((string)$raw);
		if (empty($raw)) return date('Y-m-d H:i:s');

		// Excel serial number (numeric, e.g. 40000 - 55000)
		if (is_numeric($raw) && $raw > 30000 && $raw < 60000) {
			$unix = ($raw - 25569) * 86400;
			return date('Y-m-d H:i:s', (int)$unix);
		}

		// Replace Indonesian month names if present
		$bulan_id = [
			'januari' => 'January', 'februari' => 'February', 'maret' => 'March',
			'april' => 'April', 'mei' => 'May', 'juni' => 'June',
			'juli' => 'July', 'agustus' => 'August', 'september' => 'September',
			'oktober' => 'October', 'november' => 'November', 'desember' => 'December',
			'ags' => 'Aug', 'okt' => 'Oct', 'des' => 'Dec'
		];
		$raw_en = str_ireplace(array_keys($bulan_id), array_values($bulan_id), $raw);

		// Format dd/mm/yyyy or dd-mm-yyyy with optional time
		if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})(.*)$/', $raw_en, $matches)) {
			$day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
			$month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
			$year = $matches[3];
			$time = trim($matches[4]);
			if (empty($time)) $time = '00:00:00';
			$normalized = "$year-$month-$day $time";
			$t = strtotime($normalized);
			if ($t !== false && $t > 0) {
				return date('Y-m-d H:i:s', $t);
			}
		}

		$t = strtotime($raw_en);
		if ($t !== false && $t > 0) {
			return date('Y-m-d H:i:s', $t);
		}

		return date('Y-m-d H:i:s');
	}

	public function import_excel()
	{
		@ini_set('memory_limit', '1024M');
		@set_time_limit(0);

		$redirect_back = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url('administrator/rfm/dashboard');

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
			redirect($redirect_back);
			return;
		}

		if (empty($_FILES['file_excel']['name'])) {
			set_message('Silakan pilih file Excel (.xlsx, .xls) atau CSV yang akan diimport.', 'error');
			redirect($redirect_back);
			return;
		}

		$file_tmp = $_FILES['file_excel']['tmp_name'];
		$file_name = $_FILES['file_excel']['name'];
		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

		if (!in_array($ext, ['xlsx', 'xls', 'csv'])) {
			set_message('Format file tidak didukung! Harus berupa .xlsx, .xls, atau .csv.', 'error');
			redirect($redirect_back);
			return;
		}

		$rows = [];

		try {
			if ($ext === 'csv') {
				// Pure native PHP CSV parser - fast, lightweight, 0 MB overhead
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

					$count_semi = substr_count($first_line, ';');
					$count_comma = substr_count($first_line, ',');
					$count_tab = substr_count($first_line, "\t");

					$delimiter = ',';
					if ($count_semi > $count_comma && $count_semi > $count_tab) {
						$delimiter = ';';
					} elseif ($count_tab > $count_comma && $count_tab > $count_semi) {
						$delimiter = "\t";
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
				$prev_err = error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
				require_once FCPATH . 'application/libraries/Excel/PHPExcel/IOFactory.php';
				$objPHPExcel = PHPExcel_IOFactory::load($file_tmp);
				$sheet = $objPHPExcel->getActiveSheet();
				$rows = $sheet->toArray(null, true, true, true);
				error_reporting($prev_err);
			}
		} catch (Exception $e) {
			set_message('Gagal membaca file data: ' . $e->getMessage(), 'error');
			redirect($redirect_back);
			return;
		}

		if (empty($rows) || count($rows) < 2) {
			set_message('File Excel kosong atau tidak memiliki data.', 'error');
			redirect($redirect_back);
			return;
		}

		$header_row = $rows[1];
		$import_type = $this->input->post('import_type'); // 'auto', 'matrix', 'transactions'

		// Auto-detect file type if set to auto
		if (empty($import_type) || $import_type === 'auto') {
			$has_r = false; $has_f = false; $has_m = false; $has_seg = false;
			foreach ($header_row as $colLetter => $hText) {
				if (empty($hText)) continue;
				$hNorm = strtolower(trim(preg_replace('/[^a-zA-Z]/', '', (string)$hText)));
				if ($hNorm === 'recency' || $hNorm === 'r') $has_r = true;
				if ($hNorm === 'frequency' || $hNorm === 'f') $has_f = true;
				if ($hNorm === 'monetary' || $hNorm === 'm') $has_m = true;
				if ($hNorm === 'segment' || $hNorm === 'segments' || $hNorm === 'segmentasi') $has_seg = true;
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
			$hNorm = strtolower(trim(preg_replace('/[^a-zA-Z]/', '', (string)$hText)));
			if ($hNorm === 'recency' || $hNorm === 'r') $col_map['r'] = $colLetter;
			if ($hNorm === 'frequency' || $hNorm === 'f') $col_map['f'] = $colLetter;
			if ($hNorm === 'monetary' || $hNorm === 'm') $col_map['m'] = $colLetter;
			if ($hNorm === 'rfm' || $hNorm === 'kode' || $hNorm === 'koderfm') $col_map['rfm'] = $colLetter;
			if ($hNorm === 'segment' || $hNorm === 'segments' || $hNorm === 'segmentasi') { if (!isset($col_map['segment'])) $col_map['segment'] = $colLetter; }
			if ($hNorm === 'goals' || $hNorm === 'goal' || $hNorm === 'tujuan') { if (!isset($col_map['goal'])) $col_map['goal'] = $colLetter; }
			if ($hNorm === 'actions' || $hNorm === 'action' || $hNorm === 'aksi' || $hNorm === 'actionplan') { if (!isset($col_map['action'])) $col_map['action'] = $colLetter; }
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
		foreach ($rows as $r => $row) {
			if ($r === 1 || empty(array_filter($row))) continue;
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

		$redirect_back = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url('administrator/rfm/matrix_rules');

		if (empty($matrix_rules)) {
			set_message('Gagal meng-import aturan RFM. Kolom data tidak valid atau tidak ditemukan aturan kombinasi.', 'error');
			redirect($redirect_back);
			return;
		}

		$this->model_rfm->save_rfm_matrix_custom($matrix_rules);
		set_message('Berhasil meng-import ' . count($matrix_rules) . ' aturan kombinasi matriks RFM dari file Excel!', 'success');
		redirect($redirect_back);
	}

	private function _import_transactions_data($rows)
	{
		$header_row = $rows[1];
		$col_map = [];

		// Precise & Flexible column matching for sales transactions
		foreach ($header_row as $colLetter => $hText) {
			if (empty($hText)) continue;
			$hNorm = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '', (string)$hText)));

			if (in_array($hNorm, ['nopesanan', 'orderid', 'noso', 'nomorpesanan', 'invoice', 'nomorso', 'idpesanan'])) {
				$col_map['order_id'] = $colLetter;
			} elseif (in_array($hNorm, ['namapenerima', 'namapelanggan', 'namacustomer', 'customername', 'namapembeli'])) {
				$col_map['customer_name'] = $colLetter;
			} elseif (in_array($hNorm, ['usernamepembeli', 'username', 'customer', 'pembeli', 'buyer', 'nama'])) {
				if (!isset($col_map['customer_name'])) $col_map['customer_name'] = $colLetter;
				if (!isset($col_map['username'])) $col_map['username'] = $colLetter;
			} elseif (in_array($hNorm, ['notelepon', 'telepon', 'nohp', 'hp', 'phone', 'notelp', 'handphone', 'wa', 'whatsapp', 'nomortelepon', 'nomorhp'])) {
				if (!isset($col_map['phone'])) $col_map['phone'] = $colLetter;
			} elseif (in_array($hNorm, ['namaproduk', 'namabarang', 'productname', 'itemname', 'produk', 'item', 'product'])) {
				if (!isset($col_map['product'])) $col_map['product'] = $colLetter;
			} elseif (in_array($hNorm, ['skuinduk', 'sku', 'kodeproduk', 'nomorreferensisku', 'kodebarang'])) {
				if (!isset($col_map['sku'])) $col_map['sku'] = $colLetter;
			} elseif (in_array($hNorm, ['namavariasi', 'variasi', 'variant'])) {
				if (!isset($col_map['variasi'])) $col_map['variasi'] = $colLetter;
			} elseif (in_array($hNorm, ['nomorresi', 'resi', 'trackingnumber', 'awb', 'noresi'])) {
				if (!isset($col_map['resi'])) $col_map['resi'] = $colLetter;
			} elseif (in_array($hNorm, ['opsipengiriman', 'kurir', 'ekspedisi', 'courier'])) {
				if (!isset($col_map['kurir'])) $col_map['kurir'] = $colLetter;
			} elseif (in_array($hNorm, ['jumlah', 'jumlahprodukdipesan', 'qty', 'quantity', 'kuantitas', 'totalqty'])) {
				if (!isset($col_map['qty'])) $col_map['qty'] = $colLetter;
			} elseif (in_array($hNorm, ['totalpembayaran', 'totalhargaproduk', 'hargasetelahdiskon', 'total', 'subtotal', 'monetary', 'grandtotal', 'nominal', 'totalbayar'])) {
				if (!isset($col_map['total'])) $col_map['total'] = $colLetter;
			} elseif (in_array($hNorm, ['hargasatuan', 'harga', 'unitprice', 'price', 'hargaawal'])) {
				if (!isset($col_map['unit_price'])) $col_map['unit_price'] = $colLetter;
			} elseif (in_array($hNorm, ['waktupembayarandilakukan', 'waktupesanandibuat', 'tanggalso', 'tanggal', 'waktupembayaran', 'date', 'tgl', 'tanggaltransaksi', 'waktutransaksi'])) {
				if (!isset($col_map['date'])) $col_map['date'] = $colLetter;
			} elseif (in_array($hNorm, ['statuspesanan', 'status', 'orderstatus'])) {
				if (!isset($col_map['status'])) $col_map['status'] = $colLetter;
			} elseif (in_array($hNorm, ['alamatpengiriman', 'alamat', 'address'])) {
				if (!isset($col_map['alamat'])) $col_map['alamat'] = $colLetter;
			} elseif (in_array($hNorm, ['kotakabupaten', 'kota', 'city'])) {
				if (!isset($col_map['kota'])) $col_map['kota'] = $colLetter;
			} elseif (in_array($hNorm, ['provinsi', 'province'])) {
				if (!isset($col_map['provinsi'])) $col_map['provinsi'] = $colLetter;
			}
		}

		$default_pelanggan = $this->db->get_where('pelanggan', ['kode_pelanggan' => 'CUS-MARKETPLACE'])->row() ?: $this->db->get('pelanggan')->row();
		$pelanggan_id = $default_pelanggan ? $default_pelanggan->id : 1;
		$user_created = get_user_data('username') ?: 'admin';

		// Pre-fetch all existing order_ids in both sales_order and penjualan_marketplace for O(1) duplicate lookup
		$existing_orders = [];
		$res_existing = $this->db->select('no_pesanan')->get('sales_order')->result();
		foreach ($res_existing as $e_row) {
			if (!empty($e_row->no_pesanan)) {
				$existing_orders[$e_row->no_pesanan] = true;
			}
		}
		$res_pm = $this->db->select('no_pesanan')->get('penjualan_marketplace')->result();
		foreach ($res_pm as $e_row) {
			if (!empty($e_row->no_pesanan)) {
				$existing_orders[$e_row->no_pesanan] = true;
			}
		}

		// Pre-fetch all customers into array for O(1) matching by phone or name
		$all_pelanggan = $this->db->select('id, kode_pelanggan, nama_pelanggan, telepon, no_telp')->get('pelanggan')->result();
		$cust_by_phone = [];
		$cust_by_name = [];
		foreach ($all_pelanggan as $cp) {
			$p1 = preg_replace('/[^0-9]/', '', (string)$cp->telepon);
			$p2 = preg_replace('/[^0-9]/', '', (string)$cp->no_telp);
			if (!empty($p1)) $cust_by_phone[$p1] = (int)$cp->id;
			if (!empty($p2)) $cust_by_phone[$p2] = (int)$cp->id;
			if (!empty($cp->nama_pelanggan)) {
				$cust_by_name[strtolower(trim($cp->nama_pelanggan))] = (int)$cp->id;
			}
		}

		$max_cust_row = $this->db->select_max('id')->get('pelanggan')->row();
		$next_cust_num = ($max_cust_row && $max_cust_row->id) ? ((int)$max_cust_row->id + 1) : 1;

		// Pre-fetch products into array
		$all_products = $this->db->get('produk')->result();
		$default_prod_id = !empty($all_products) ? $all_products[0]->id : 1;
		$prod_map = [];
		foreach ($all_products as $pr) {
			$prod_map[strtolower(trim($pr->nama_produk))] = $pr->id;
		}

		// Pre-fetch CRM categories for bulk label generation
		$crm_categories = $this->db->get_where('crm_followup_categories', ['is_active' => 1])->result();
		$bulk_crm_labels = [];

		$success_count = 0;
		$skipped_count = 0;
		$today_str = date('Ymd');
		$now_dt = date('Y-m-d H:i:s');

		// Track orders created in THIS current batch to support multi-line item orders
		$batch_orders = []; // no_pesanan => so_id

		// Enable DB transaction for high performance bulk insert
		$this->db->trans_start();

		foreach ($rows as $r => $row) {
			if ($r === 1 || empty(array_filter($row))) continue;

			$no_pesanan = isset($col_map['order_id']) ? trim((string)($row[$col_map['order_id']] ?? '')) : '';
			if (empty($no_pesanan)) {
				$no_pesanan = 'IMP-' . $today_str . '-' . str_pad($r - 1, 6, '0', STR_PAD_LEFT);
			}

			$product_name = isset($col_map['product']) ? trim((string)($row[$col_map['product']] ?? '')) : 'Produk General';
			$sku_code = isset($col_map['sku']) ? trim((string)($row[$col_map['sku']] ?? '')) : '';
			$variasi_name = isset($col_map['variasi']) ? trim((string)($row[$col_map['variasi']] ?? '')) : '';
			$resi_code = isset($col_map['resi']) ? trim((string)($row[$col_map['resi']] ?? '')) : '';
			$kurir_name = isset($col_map['kurir']) ? trim((string)($row[$col_map['kurir']] ?? '')) : '';
			$provinsi = isset($col_map['provinsi']) ? trim((string)($row[$col_map['provinsi']] ?? '')) : '';

			$qty_raw = isset($col_map['qty']) ? $row[$col_map['qty']] : 1;
			$qty = max(1, (float)$this->_clean_number($qty_raw));

			$unit_price_raw = isset($col_map['unit_price']) ? $row[$col_map['unit_price']] : 0;
			$unit_price = (float)$this->_clean_number($unit_price_raw);

			$total_raw = isset($col_map['total']) ? $row[$col_map['total']] : 0;
			$total = (float)$this->_clean_number($total_raw);

			if ($total <= 0 && $unit_price > 0) {
				$total = $unit_price * $qty;
			}
			if ($unit_price <= 0 && $qty > 0 && $total > 0) {
				$unit_price = $total / $qty;
			}

			// If this order was ALREADY created in THIS batch (multi-line item in the same order):
			if (isset($batch_orders[$no_pesanan])) {
				$so_id = $batch_orders[$no_pesanan];

				$prod_id = $default_prod_id;
				$p_lower = strtolower(trim($product_name));
				if (isset($prod_map[$p_lower])) {
					$prod_id = $prod_map[$p_lower];
				} else {
					foreach ($prod_map as $pname => $pid) {
						if (strpos($p_lower, $pname) !== false || strpos($pname, $p_lower) !== false) {
							$prod_id = $pid;
							break;
						}
					}
				}

				// Insert additional line item
				$this->db->insert('sales_order_item', [
					'so_id'         => $so_id,
					'produk_id'     => $prod_id,
					'sku'           => $sku_code,
					'nama_variasi'  => $variasi_name,
					'qty'           => $qty,
					'satuan'        => 'pcs',
					'harga_satuan'  => $unit_price,
					'diskon_persen' => 0,
					'diskon_nominal'=> 0,
					'subtotal'      => $total,
					'catatan'       => $product_name,
				]);

				// Update order total
				$this->db->set('subtotal', 'subtotal + ' . (float)$total, false);
				$this->db->set('total', 'total + ' . (float)$total, false);
				$this->db->where('id', $so_id);
				$this->db->update('sales_order');

				continue;
			}

			// Duplicate check against existing database orders
			if (isset($existing_orders[$no_pesanan])) {
				$skipped_count++;
				continue;
			}
			$existing_orders[$no_pesanan] = true;

			$customer_name = isset($col_map['customer_name']) ? trim((string)($row[$col_map['customer_name']] ?? '')) : '';
			$username_buyer = isset($col_map['username']) ? trim((string)($row[$col_map['username']] ?? '')) : '';
			if (empty($customer_name) && !empty($username_buyer)) {
				$customer_name = $username_buyer;
			}
			if (empty($customer_name)) {
				$customer_name = 'Customer Import';
			}

			$phone_raw = isset($col_map['phone']) ? trim((string)($row[$col_map['phone']] ?? '')) : '';
			$phone = preg_replace('/[^0-9]/', '', $phone_raw);

			$alamat = isset($col_map['alamat']) ? trim((string)($row[$col_map['alamat']] ?? '')) : '';
			$kota = isset($col_map['kota']) ? trim((string)($row[$col_map['kota']] ?? '')) : '';

			// Customer matching & synchronization into 'pelanggan'
			$row_pelanggan_id = null;
			$c_name_clean = strtolower(trim($customer_name));
			$is_generic_name = in_array($c_name_clean, ['customer excel', 'customer import', '-', '', 'null', 'pembeli']);

			if (!empty($phone) && isset($cust_by_phone[$phone])) {
				$row_pelanggan_id = $cust_by_phone[$phone];
			} elseif (!$is_generic_name && isset($cust_by_name[$c_name_clean])) {
				$row_pelanggan_id = $cust_by_name[$c_name_clean];
			} else {
				$c_kode = 'CUST-' . str_pad($next_cust_num++, 4, '0', STR_PAD_LEFT);
				$phone_save = !empty($phone) ? $phone : ('0899' . str_pad($next_cust_num, 8, '0', STR_PAD_LEFT));
				$new_cust = [
					'kode_pelanggan' => $c_kode,
					'nama_pelanggan' => $customer_name ?: 'Customer Import',
					'telepon'        => $phone_save,
					'no_telp'        => $phone_save,
					'alamat'         => !empty($alamat) ? $alamat : 'Imported via Excel/CSV',
					'kota'           => !empty($kota) ? $kota : '',
					'provinsi'       => !empty($provinsi) ? $provinsi : '',
					'tipe_pelanggan' => 'Retail',
					'tier_pelanggan' => 'RETAIL',
					'status'         => 'aktif',
					'created_by'     => $user_created,
					'created_at'     => $now_dt,
				];
				$this->db->insert('pelanggan', $new_cust);
				$row_pelanggan_id = $this->db->insert_id();
				if (!empty($phone_save)) $cust_by_phone[$phone_save] = $row_pelanggan_id;
				if (!$is_generic_name) $cust_by_name[$c_name_clean] = $row_pelanggan_id;
				if (empty($phone)) $phone = $phone_save;
			}
			if (empty($row_pelanggan_id)) {
				$row_pelanggan_id = $pelanggan_id;
			}

			$date_raw = isset($col_map['date']) ? trim((string)($row[$col_map['date']] ?? '')) : '';
			$date_time = $this->_parse_clean_date($date_raw);
			$tanggal_so = substr($date_time, 0, 10);

			$raw_status = isset($col_map['status']) ? strtolower(trim((string)($row[$col_map['status']] ?? ''))) : 'selesai';
			$status = 'delivered';
			if (strpos($raw_status, 'batal') !== false || strpos($raw_status, 'cancel') !== false) {
				$status = 'cancelled';
			} elseif (strpos($raw_status, 'kirim') !== false || strpos($raw_status, 'ship') !== false) {
				$status = 'shipped';
			}

			$nomor_so_code = 'TRX-IMP-' . $today_str . '-' . sprintf('%05d', $r) . '-' . rand(10, 99);

			$so_data = [
				'nomor_so'                => $nomor_so_code,
				'no_pesanan'              => $no_pesanan,
				'source'                  => 'excel_import',
				'pelanggan_id'            => $row_pelanggan_id,
				'tanggal_so'              => $tanggal_so,
				'status'                  => $status,
				'status_pesanan'          => $raw_status ?: 'Selesai',
				'waktu_pembayaran'        => $date_time,
				'waktu_pesanan_dibuat'    => $date_time,
				'username_pembeli'        => $customer_name,
				'nama_penerima'           => $customer_name,
				'no_telepon'              => $phone ?: '08123456789',
				'alamat_pengiriman'       => $alamat,
				'kota_kabupaten'          => $kota,
				'provinsi'                => $provinsi,
				'nomor_resi'              => $resi_code,
				'kurir_ekspedisi'         => $kurir_name,
				'sku_induk'               => $sku_code,
				'nama_produk_marketplace' => $product_name,
				'nama_variasi'            => $variasi_name,
				'harga_awal'              => $unit_price,
				'harga_setelah_diskon'    => $unit_price,
				'total_harga_produk'      => $total,
				'total_pembayaran'        => $total,
				'subtotal'                => $total,
				'total'                   => $total,
				'catatan'                 => 'Import Excel RFM - Buyer: ' . $customer_name,
				'created_by'              => $user_created,
				'created_at'              => $now_dt,
			];

			$this->db->insert('sales_order', $so_data);
			$so_id = $this->db->insert_id();

			if ($so_id) {
				$batch_orders[$no_pesanan] = $so_id;

				$prod_id = $default_prod_id;
				$p_lower = strtolower(trim($product_name));
				if (isset($prod_map[$p_lower])) {
					$prod_id = $prod_map[$p_lower];
				} else {
					foreach ($prod_map as $pname => $pid) {
						if (strpos($p_lower, $pname) !== false || strpos($pname, $p_lower) !== false) {
							$prod_id = $pid;
							break;
						}
					}
				}

				$this->db->insert('sales_order_item', [
					'so_id'         => $so_id,
					'produk_id'     => $prod_id,
					'sku'           => $sku_code,
					'nama_variasi'  => $variasi_name,
					'qty'           => $qty,
					'satuan'        => 'pcs',
					'harga_satuan'  => $unit_price,
					'diskon_persen' => 0,
					'diskon_nominal'=> 0,
					'subtotal'      => $total,
					'catatan'       => $product_name,
				]);

				// Generate CRM follow-up labels in memory for batch insert
				if (!empty($crm_categories)) {
					$ship_date = !empty($tanggal_so) ? $tanggal_so : date('Y-m-d');
					foreach ($crm_categories as $cat) {
						$target_lbl = date('Y-m-d', strtotime($ship_date . ' + ' . $cat->jumlah_hari . ' days'));
						$bulk_crm_labels[] = [
							'order_source'          => 'Toko',
							'order_id'              => $so_id,
							'order_table'           => 'sales_order',
							'customer_nama'         => $customer_name ?: 'Customer Import',
							'customer_phone'        => $phone ?: '',
							'customer_pelanggan_id' => $row_pelanggan_id,
							'no_pesanan'            => $no_pesanan,
							'nomor_resi'            => $resi_code,
							'tanggal_pengiriman'    => $ship_date,
							'followup_category_id'  => $cat->id,
							'tanggal_label_muncul'  => $target_lbl,
							'created_at'            => $now_dt,
						];
					}

					if (count($bulk_crm_labels) >= 500) {
						$this->db->insert_batch('crm_transaction_followup_labels', $bulk_crm_labels);
						$bulk_crm_labels = [];
					}
				}

				$success_count++;
			}
		}

		if (!empty($bulk_crm_labels)) {
			$this->db->insert_batch('crm_transaction_followup_labels', $bulk_crm_labels);
		}

		$this->db->trans_complete();

		if ($success_count > 0) {
			set_message("Berhasil meng-import {$success_count} data pesanan dari file Excel/CSV! ({$skipped_count} pesanan duplikat dilewati). Analisis RFM & Kohort telah diperbarui.", 'success');
		} else {
			set_message("Tidak ada data pesanan baru yang berhasil diimport ({$skipped_count} pesanan duplikat dilewati).", 'warning');
		}

		$redirect_url = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url('administrator/rfm/dashboard');
		redirect($redirect_url);
	}

	public function download_template_matrix()
	{
		$headers = ['No.', 'Recency', 'Frequency', 'Monetary', 'RFM', 'Segment', 'Goals', 'Actions'];
		if (ob_get_length()) { ob_end_clean(); }

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
		if (ob_get_length()) { ob_end_clean(); }

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=template_import_transaksi_sales_rfm.csv');
		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fputcsv($output, $headers, ';');

		fclose($output);
		exit;
	}

	/**
	 * 125 RFM Rule Matrix Table View (Matching User's Excel Matrix)
	 * URL: /administrator/rfm/matrix_rules
	 */
	public function matrix_rules()
	{
		$r_filter = $this->input->get('r');
		$f_filter = $this->input->get('f');
		$m_filter = $this->input->get('m');
		$seg_filter = $this->input->get('segment');
		$search = trim($this->input->get('q') ?: '');

		$full_matrix = $this->model_rfm->get_rfm_matrix();

		// Calculate current live customer count mapped to each RFM score code
		$customer_dist = [];
		$res = $this->model_rfm->get_customers('', 10000, 0, '', '', '', '');
		$total_customers = 0;
		if (!empty($res['rows'])) {
			$total_customers = count($res['rows']);
			foreach ($res['rows'] as $c) {
				$r_s = $c->rfm['r_score'] ?? 0;
				$f_s = $c->rfm['f_score'] ?? 0;
				$m_s = $c->rfm['m_score'] ?? 0;
				$code = "{$r_s}{$f_s}{$m_s}";
				if (!isset($customer_dist[$code])) {
					$customer_dist[$code] = 0;
				}
				$customer_dist[$code]++;
			}
		}

		$filtered_rules = [];
		$segment_summary = [];

		foreach ($full_matrix as $code => $rule) {
			$r_val = (int)($rule['r'] ?? $code[0]);
			$f_val = (int)($rule['f'] ?? $code[1]);
			$m_val = (int)($rule['m'] ?? $code[2]);
			$segment = $rule['segment'] ?? '';
			$goal = $rule['goal'] ?? '';
			$action = $rule['action'] ?? '';

			if (!isset($segment_summary[$segment])) {
				$segment_summary[$segment] = [
					'count' => 0,
					'customers' => 0,
					'badge' => $this->model_rfm->get_rfm_badge_style($segment)
				];
			}
			$segment_summary[$segment]['count']++;
			$segment_summary[$segment]['customers'] += ($customer_dist[$code] ?? 0);

			if (!empty($r_filter) && (string)$r_val !== (string)$r_filter) continue;
			if (!empty($f_filter) && (string)$f_val !== (string)$f_filter) continue;
			if (!empty($m_filter) && (string)$m_val !== (string)$m_filter) continue;
			if (!empty($seg_filter) && strtolower($segment) !== strtolower($seg_filter)) continue;
			if (!empty($search)) {
				$search_l = strtolower($search);
				if (
					strpos($code, $search) === false &&
					stripos($segment, $search_l) === false &&
					stripos($goal, $search_l) === false &&
					stripos($action, $search_l) === false
				) {
					continue;
				}
			}

			$filtered_rules[$code] = [
				'code' => $code,
				'r' => $r_val,
				'f' => $f_val,
				'm' => $m_val,
				'segment' => $segment,
				'goal' => $goal,
				'action' => $action,
				'badge' => $this->model_rfm->get_rfm_badge_style($segment),
				'active_customers' => $customer_dist[$code] ?? 0
			];
		}

		// Check if custom matrix option exists in database
		$is_custom = false;
		$custom = $this->db->get_where('cc_options', ['option_name' => 'rfm_matrix_custom'])->row();
		if ($custom && !empty($custom->option_value)) {
			$is_custom = true;
		}

		$this->data['rules'] = $filtered_rules;
		$this->data['total_rules'] = count($full_matrix);
		$this->data['filtered_count'] = count($filtered_rules);
		$this->data['total_customers'] = $total_customers;
		$this->data['segment_summary'] = $segment_summary;
		$this->data['is_custom'] = $is_custom;
		$this->data['r_filter'] = $r_filter;
		$this->data['f_filter'] = $f_filter;
		$this->data['m_filter'] = $m_filter;
		$this->data['seg_filter'] = $seg_filter;
		$this->data['search'] = $search;

		$this->template->title('Analisis RFM — 125 Aturan Matriks RFM');
		$this->render('backend/standart/administrator/rfm/rfm_matrix_rules', $this->data);
	}

	public function reset_matrix_rules()
	{
		$this->db->where('option_name', 'rfm_matrix_custom')->delete('cc_options');
		set_message('Aturan Matriks RFM berhasil direset kembali ke standar bawaan (125 aturan)!', 'success');
		redirect('administrator/rfm/matrix_rules');
	}
}
