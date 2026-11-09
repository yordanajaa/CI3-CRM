<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crm_segments extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('crm_segments/model_crm_segments');
		$this->load->model('rfm/model_rfm');
	}

	public function index()
	{
		return $this->product_rfm();
	}

	/**
	 * Product RFM Matrix Table View
	 * Matching: /administrator/crm_segments/product_rfm
	 */
	public function product_rfm()
	{
		$category = $this->input->get('kategori') ?: '';
		$year = $this->input->get('year');
		if ($year === null) {
			$year = '2026';
		}
		$period = $this->input->get('period') ?: '';
		$mode   = $this->input->get('mode') ?: 'cumulative';

		$categories_list = $this->model_crm_segments->get_distinct_categories_list();
		$available_years = $this->model_crm_segments->get_distinct_years_list();
		$available_months = $this->model_crm_segments->get_distinct_months_list($year);
		$products_list = $this->model_crm_segments->get_distinct_products_list($category);

		$product_param = $this->input->get('product');
		$product = '';
		if (!empty($product_param) && $product_param !== 'all' && !empty($products_list)) {
			foreach ($products_list as $p_item) {
				if ($p_item->nama_produk === $product_param || (string)$p_item->id === (string)$product_param || $p_item->kode_produk === $product_param) {
					$product = $p_item->nama_produk;
					break;
				}
			}
		}

		$matrix_data = $this->model_crm_segments->get_product_rfm_matrix($product, $year, $period, $category, $mode);

		$this->data['products_list'] = $products_list;
		$this->data['categories_list'] = $categories_list;
		$this->data['available_years'] = $available_years;
		$this->data['available_months'] = $available_months;
		$this->data['selected_product'] = $product;
		$this->data['selected_product_id'] = $matrix_data['product_id'] ?? null;
		$this->data['selected_product_code'] = $matrix_data['product_code'] ?? '';
		$this->data['selected_year'] = $year;
		$this->data['selected_period'] = $period;
		$this->data['selected_category'] = $category;
		$this->data['selected_mode'] = $mode;
		$this->data['matrix_data'] = $matrix_data;

		$this->template->title('Analisis RFM — Tren Segmen Produk');
		$this->render('backend/standart/administrator/crm_segments/product_rfm', $this->data);
	}

	/**
	 * AJAX endpoint for Customer Drill-down Modal
	 */
	public function product_rfm_drilldown_ajax()
	{
		$product  = $this->input->get_post('product') ?: '';
		$category = $this->input->get_post('category') ?: '';
		$segment  = $this->input->get_post('segment');
		$period   = $this->input->get_post('period');
		$mode     = $this->input->get_post('mode') ?: 'cumulative';

		if (empty($segment) || empty($period)) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(400)
				->set_output(json_encode([
					'status' => 'error',
					'message' => 'Parameter segment dan period harus diisi.'
				]));
		}

		$customers = $this->model_crm_segments->get_drilldown_customers($product, $segment, $period, $category, $mode);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode([
				'status'    => 'success',
				'product'   => $product,
				'category'  => $category,
				'segment'   => $segment,
				'period'    => $period,
				'mode'      => $mode,
				'count'     => count($customers),
				'customers' => $customers
			]));
	}

	/**
	 * Export Product RFM Matrix to CSV / Spreadsheet
	 */
	public function export_csv()
	{
		$product  = $this->input->get('product');
		$year     = $this->input->get('year') ?: '2026';
		$period   = $this->input->get('period') ?: '';
		$category = $this->input->get('kategori') ?: '';
		$mode     = $this->input->get('mode') ?: 'cumulative';

		$matrix_data = $this->model_crm_segments->get_product_rfm_matrix($product, $year, $period, $category, $mode);

		$filename = 'Tren_RFM_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $matrix_data['product_name']) . '_' . $mode . '_' . date('Ymd_His') . '.csv';

		if (ob_get_length()) { ob_end_clean(); }

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Pragma: no-cache');
		header('Expires: 0');

		// UTF-8 BOM for perfect Excel compatibility on Windows & Hostinger
		echo "\xEF\xBB\xBF";

		$output = fopen('php://output', 'w');


		// Header row
		$headers = ['Segmen RFM'];
		foreach ($matrix_data['months'] as $ym => $label) {
			$headers[] = $label;
		}
		$headers[] = ($mode === 'cumulative') ? 'Total Basis Pelanggan' : 'Jumlah Pelanggan';
		$headers[] = 'Tren (%)';
		fputcsv($output, $headers);

		// Matrix rows
		foreach ($matrix_data['matrix'] as $seg_name => $row) {
			$line = [$seg_name];
			foreach ($matrix_data['months'] as $ym => $label) {
				$line[] = $row['counts'][$ym] ?? 0;
			}
			$line[] = $row['total_cust'];
			$has_data = array_sum($row['counts'] ?? []) > 0;
			$line[] = $has_data ? (($row['trend_pct'] > 0 ? '+' : '') . $row['trend_pct'] . '%') : '0%';
			fputcsv($output, $line);
		}

		// Total Row
		$total_line = [($mode === 'cumulative') ? 'Total Basis Pelanggan Kumulatif' : 'Total Pelanggan'];
		foreach ($matrix_data['months'] as $ym => $label) {
			$total_line[] = $matrix_data['totals_row']['counts'][$ym] ?? 0;
		}
		$total_line[] = $matrix_data['totals_row']['grand_total'];
		$total_line[] = '-';
		fputcsv($output, $total_line);

		// MoM Growth Row
		$mom_line = ['Pertumbuhan MoM (%)'];
		foreach ($matrix_data['months'] as $ym => $label) {
			$g = $matrix_data['mom_row']['growth'][$ym];
			$mom_line[] = $g !== null ? (($g >= 0 ? '+' : '') . $g . '%') : '-';
		}
		$mom_line[] = '-';
		$mom_line[] = ($matrix_data['net_growth_pct'] >= 0 ? '+' : '') . $matrix_data['net_growth_pct'] . '%';
		fputcsv($output, $mom_line);

		fclose($output);
		exit();
	}
}
