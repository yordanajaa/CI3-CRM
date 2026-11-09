<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model_rfm
 * 
 * Thin wrapper model that delegates to Model_crm for shared data access.
 * The RFM module is separate from CRM but uses the same underlying data.
 */
class Model_rfm extends CI_Model
{
	private $crm = null;

	public function __construct()
	{
		parent::__construct();
		// Load the CRM model from the crm module
		$this->load->model('crm/model_crm');
		$this->crm = $this->model_crm;
	}

	// ===== RFM Core Logic (delegates to Model_crm) =====

	public function get_rfm_matrix()
	{
		return $this->crm->get_rfm_matrix();
	}

	public function save_rfm_matrix_custom($matrix)
	{
		return $this->crm->save_rfm_matrix_custom($matrix);
	}

	public function get_rfm_badge_style($segment)
	{
		return $this->crm->get_rfm_badge_style($segment);
	}

	public function get_rfm_percentile_thresholds($product_filter = '', $period_filter = '', $category_filter = '')
	{
		return $this->crm->get_rfm_percentile_thresholds($product_filter, $period_filter, $category_filter);
	}

	public function calculate_rfm($last_order_date = null, $total_orders = 0, $total_spend = 0.0, $thresholds = null, $reference_date = null)
	{
		return $this->crm->calculate_rfm($last_order_date, $total_orders, $total_spend, $thresholds, $reference_date);
	}

	// ===== Customer Data (delegates to Model_crm) =====

	public function get_customers($filter = '', $limit = 25, $offset = 0, $rfm_segment_filter = '', $product_filter = '', $period_filter = '', $category_filter = '')
	{
		return $this->crm->get_customers($filter, $limit, $offset, $rfm_segment_filter, $product_filter, $period_filter, $category_filter);
	}

	public function get_rfm_dashboard_distribution($product_filter = '', $period_filter = '', $category_filter = '')
	{
		return $this->crm->get_rfm_dashboard_distribution($product_filter, $period_filter, $category_filter);
	}

	public function get_customer_summary($phone, $product_filter = '')
	{
		return $this->crm->get_customer_summary($phone, $product_filter);
	}

	public function get_customer_transactions($phone, $product_filter = '')
	{
		return $this->crm->get_customer_transactions($phone, $product_filter);
	}

	public function get_customer_product_rfm($phone)
	{
		return $this->crm->get_customer_product_rfm($phone);
	}

	public function get_all_products_list($category_filter = '')
	{
		return $this->crm->get_all_products_list($category_filter);
	}

	public function get_all_categories_list()
	{
		return $this->crm->get_all_categories_list();
	}

	public function get_distinct_months_list()
	{
		return $this->crm->get_distinct_months_list();
	}

	public function get_distinct_years_list()
	{
		return $this->crm->get_distinct_years_list();
	}

	public function get_monthly_rfm_tracking_per_product($product_filter = '', $period_filter = '', $year_filter = '', $category_filter = '')
	{
		return $this->crm->get_monthly_rfm_tracking_per_product($product_filter, $period_filter, $year_filter, $category_filter);
	}

	public function get_top_products_by_month($ym_period, $product_filter = '', $limit = 5)
	{
		return $this->crm->get_top_products_by_month($ym_period, $product_filter, $limit);
	}

	public function get_platform_breakdown_by_month($ym_period, $product_filter = '')
	{
		return $this->crm->get_platform_breakdown_by_month($ym_period, $product_filter);
	}

	public function get_product_rfm_list($filter = '', $limit = 50, $offset = 0)
	{
		return $this->crm->get_product_rfm_list($filter, $limit, $offset);
	}

	public function get_cohort_analysis($mode = 'monthly', $year = '', $month = '', $product = '', $category = '')
	{
		return $this->crm->get_cohort_analysis($mode, $year, $month, $product, $category);
	}

	public function get_product_cohort_summary($year = '', $category = '')
	{
		return $this->crm->get_product_cohort_summary($year, $category);
	}

	public function get_cohort_drilldown_customers($cohort_period, $target_period, $mode = 'monthly', $product = '', $category = '')
	{
		return $this->crm->get_cohort_drilldown_customers($cohort_period, $target_period, $mode, $product, $category);
	}

	public function get_transaction_items($table, $order_id)
	{
		return $this->crm->get_transaction_items($table, $order_id);
	}

	// ===== RFM-Specific Analytics =====

	/**
	 * Get threshold details formatted for display
	 */
	public function get_threshold_display($product_filter = '')
	{
		$t = $this->get_rfm_percentile_thresholds($product_filter);

		return [
			'recency' => [
				['percentile' => '0% - 20%', 'range' => '≤ ' . round($t['r'][20]) . ' hari', 'score' => 5, 'label' => 'Sangat Baru'],
				['percentile' => '20% - 40%', 'range' => round($t['r'][20]) . ' - ' . round($t['r'][40]) . ' hari', 'score' => 4, 'label' => 'Baru'],
				['percentile' => '40% - 60%', 'range' => round($t['r'][40]) . ' - ' . round($t['r'][60]) . ' hari', 'score' => 3, 'label' => 'Cukup Lama'],
				['percentile' => '60% - 80%', 'range' => round($t['r'][60]) . ' - ' . round($t['r'][80]) . ' hari', 'score' => 2, 'label' => 'Lama'],
				['percentile' => '80% - 100%', 'range' => '> ' . round($t['r'][80]) . ' hari', 'score' => 1, 'label' => 'Sangat Lama'],
			],
			'frequency' => [
				['percentile' => '80% - 100%', 'range' => '≥ ' . round($t['f'][80]) . ' order', 'score' => 5, 'label' => 'Sangat Sering'],
				['percentile' => '60% - 80%', 'range' => round($t['f'][60]) . ' - ' . round($t['f'][80]) . ' order', 'score' => 4, 'label' => 'Sering'],
				['percentile' => '40% - 60%', 'range' => round($t['f'][40]) . ' - ' . round($t['f'][60]) . ' order', 'score' => 3, 'label' => 'Kadang'],
				['percentile' => '20% - 40%', 'range' => round($t['f'][20]) . ' - ' . round($t['f'][40]) . ' order', 'score' => 2, 'label' => 'Jarang'],
				['percentile' => '0% - 20%', 'range' => '< ' . round($t['f'][20]) . ' order', 'score' => 1, 'label' => 'Sangat Jarang'],
			],
			'monetary' => [
				['percentile' => '80% - 100%', 'range' => '≥ Rp ' . number_format($t['m'][80], 0, ',', '.'), 'score' => 5, 'label' => 'Sangat Besar'],
				['percentile' => '60% - 80%', 'range' => 'Rp ' . number_format($t['m'][60], 0, ',', '.') . ' - ' . number_format($t['m'][80], 0, ',', '.'), 'score' => 4, 'label' => 'Besar'],
				['percentile' => '40% - 60%', 'range' => 'Rp ' . number_format($t['m'][40], 0, ',', '.') . ' - ' . number_format($t['m'][60], 0, ',', '.'), 'score' => 3, 'label' => 'Sedang'],
				['percentile' => '20% - 40%', 'range' => 'Rp ' . number_format($t['m'][20], 0, ',', '.') . ' - ' . number_format($t['m'][40], 0, ',', '.'), 'score' => 2, 'label' => 'Kecil'],
				['percentile' => '0% - 20%', 'range' => '< Rp ' . number_format($t['m'][20], 0, ',', '.'), 'score' => 1, 'label' => 'Sangat Kecil'],
			],
		];
	}

	/**
	 * Get segment summary with goals and actions from database
	 */
	public function get_segment_definitions()
	{
		if ($this->db->table_exists('rfm_segment_strategy')) {
			$query = $this->db->order_by('sort_order', 'ASC')->order_by('id', 'ASC')->get('rfm_segment_strategy');
			if ($query && $query->num_rows() > 0) {
				return $query->result_array();
			}
		}

		// Fallback default definitions
		return [
			['id' => 1, 'segment' => 'Champions', 'icon' => 'fa-trophy', 'color' => '#f59e0b', 'goal' => 'Pertahankan loyalitas dan beri apresiasi', 'action' => 'Berikan hadiah eksklusif, early access, dan testimoni program'],
			['id' => 2, 'segment' => 'Loyal Customers', 'icon' => 'fa-diamond', 'color' => '#10b981', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			['id' => 3, 'segment' => 'Potential Loyalist', 'icon' => 'fa-star', 'color' => '#6366f1', 'goal' => 'Dorong jadi loyal customer', 'action' => 'Follow up rutin, edukasi produk, dan masuk grup WA konsultasi'],
			['id' => 4, 'segment' => 'New Customers', 'icon' => 'fa-user-plus', 'color' => '#3b82f6', 'goal' => 'Bina jadi pembeli ulang', 'action' => 'Reminder, konsultasi awal, dan edukasi cara konsumsi'],
			['id' => 5, 'segment' => 'Big Spenders', 'icon' => 'fa-credit-card', 'color' => '#8b5cf6', 'goal' => 'Pertahankan nilai belanja', 'action' => 'Berikan penawaran VIP, diskon eksklusif, dan layanan personal'],
			['id' => 6, 'segment' => 'Frequent Low Value', 'icon' => 'fa-shopping-basket', 'color' => '#64748b', 'goal' => 'Dorong naik kelas belanja', 'action' => 'Upsell produk premium, bundling hemat'],
			['id' => 7, 'segment' => 'Need Attention', 'icon' => 'fa-bell', 'color' => '#f97316', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			['id' => 8, 'segment' => 'At Risk Customers', 'icon' => 'fa-exclamation-triangle', 'color' => '#ef4444', 'goal' => 'Cegah churn, reaktivasi', 'action' => 'Diskon khusus, personal outreach, tanya feedback'],
			['id' => 9, 'segment' => "Can't Lose Them", 'icon' => 'fa-heart', 'color' => '#ec4899', 'goal' => 'Win back segera', 'action' => 'Kontak langsung, penawaran istimewa, eskalasi ke manajemen'],
			['id' => 10, 'segment' => 'Hibernating', 'icon' => 'fa-moon-o', 'color' => '#6b7280', 'goal' => 'Reaktivasi atau lepaskan', 'action' => 'Kampanye re-engagement, survei alasan berhenti'],
		];
	}

	public function get_segment_strategy_by_id($id)
	{
		return $this->db->get_where('rfm_segment_strategy', ['id' => $id])->row_array();
	}

	public function add_segment_strategy($data)
	{
		return $this->db->insert('rfm_segment_strategy', $data);
	}

	public function update_segment_strategy($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('rfm_segment_strategy', $data);
	}

	public function delete_segment_strategy($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('rfm_segment_strategy');
	}

	// ===== Daily RFM Tracking (per-date segment breakdown) =====

	/**
	 * Get daily RFM segment tracking data within date range.
	 * Shows how many customers fall into each RFM segment per day.
	 */
	/**
	 * Get daily RFM segment tracking data within date range.
	 * Calculates the distribution across all 10 RFM segments for each day.
	 * Matches the exact RFM Tracking Register All structure.
	 */
	public function get_daily_rfm_tracking($date_from = '', $date_to = '', $category_filter = '', $product_filter = '', $status_rfm_filter = [], $brand_filter = '', $specialist_filter = '')
	{
		// Normalize d/m/Y or d-m-Y to Y-m-d if needed
		$date_from = trim($date_from);
		$date_to = trim($date_to);
		if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $date_from, $m)) {
			$date_from = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
		}
		if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $date_to, $m)) {
			$date_to = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
		}

		if (empty($date_from) || empty($date_to)) {
			return [
				'data_awal'       => 0,
				'total_items'     => 0,
				'daily_rows'      => [],
				'date_from'       => '',
				'date_to'         => '',
				'date_from_view'  => '',
				'date_to_view'    => '',
				'chart_labels'    => [],
				'chart_datasets'  => [],
				'all_segments'    => [
					'New Customers', 'Need Attention', 'Frequent Low Value', 'Hibernating',
					'At Risk Customers', 'Cant Lose Them', 'Potential Loyalist', 'Loyal Customers',
					'Big Spenders', 'Champion'
				],
				'colors'          => []
			];
		}

		$df_ts = strtotime(str_replace('/', '-', $date_from));
		$dt_ts = strtotime(str_replace('/', '-', $date_to));
		if ($df_ts && $dt_ts && $df_ts > $dt_ts) {
			$tmp = $date_from; $date_from = $date_to; $date_to = $tmp;
			$df_ts = strtotime(str_replace('/', '-', $date_from));
			$dt_ts = strtotime(str_replace('/', '-', $date_to));
		}

		// Thresholds & Matrix
		$effective_prod = !empty($product_filter) ? $product_filter : $brand_filter;
		$effective_cat = !empty($category_filter) ? $category_filter : $brand_filter;
		$thresholds = $this->get_rfm_percentile_thresholds($effective_prod, '', $effective_cat);
		$matrix = $this->get_rfm_matrix();

		// All 10 segments in exact display order
		$all_segments = [
			'New Customers',
			'Need Attention',
			'Frequent Low Value',
			'Hibernating',
			'At Risk Customers',
			'Cant Lose Them',
			'Potential Loyalist',
			'Loyal Customers',
			'Big Spenders',
			'Champion'
		];

		// Filters
		$so_where = [];
		$pm_where = [];

		$so_where[] = "so.no_telepon IS NOT NULL AND so.no_telepon != ''";
		$so_where[] = "(so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))";
		$so_where[] = "so.tanggal_so IS NOT NULL AND so.tanggal_so <= " . $this->db->escape($date_to);
		$so_where[] = "CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' AND so.tanggal_so > '1970-01-01'";
		$so_where[] = "(so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))";

		$pm_where[] = "pm.no_telepon IS NOT NULL AND pm.no_telepon != ''";
		$pm_where[] = "pm.tanggal_so IS NOT NULL AND pm.tanggal_so <= " . $this->db->escape($date_to);
		$pm_where[] = "CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' AND pm.tanggal_so > '1970-01-01'";
		$pm_where[] = "(pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))";

		if (!empty($category_filter)) {
			$cf = $this->db->escape(trim($category_filter));
			$so_where[] = "(kp.nama_kategori = {$cf} OR kp.id = {$cf} OR p.kategori_id = {$cf})";
			$pm_where[] = "(kp2.nama_kategori = {$cf} OR kp2.id = {$cf} OR p2.kategori_id = {$cf})";
		}

		if (!empty($product_filter)) {
			$pf = $this->db->escape(trim($product_filter));
			$so_where[] = "(p.nama_produk = {$pf} OR p.id = {$pf} OR soi.catatan = {$pf})";
			$pm_where[] = "(p2.nama_produk = {$pf} OR p2.id = {$pf} OR pmi.catatan = {$pf} OR pm.nama_produk_marketplace = {$pf})";
		}

		if (!empty($brand_filter) && empty($category_filter)) {
			$bf = $this->db->escape(trim($brand_filter));
			$so_where[] = "(p.nama_produk = {$bf} OR kp.nama_kategori = {$bf} OR kp.id = {$bf} OR p.kategori_id = {$bf})";
			$pm_where[] = "(p2.nama_produk = {$bf} OR kp2.nama_kategori = {$bf} OR kp2.id = {$bf} OR p2.kategori_id = {$bf})";
		}

		if (!empty($specialist_filter)) {
			$sf = $this->db->escape(trim($specialist_filter));
			$so_where[] = "(so.created_by = {$sf} OR u.username = {$sf} OR u.email = {$sf} OR u.full_name = {$sf})";
			$pm_where[] = "(pm.created_by = {$sf})";
		}

		$so_where_sql = implode(' AND ', $so_where);
		$pm_where_sql = implode(' AND ', $pm_where);

		$sql = "
			SELECT 
				RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(so.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10) as clean_phone,
				DATE(so.tanggal_so) as tgl,
				COALESCE(soi.subtotal, (soi.qty * soi.harga_satuan), so.total, 0) as total,
				COALESCE(NULLIF(so.nama_penerima, ''), p_cust.nama_pelanggan, 'Customer') as nama
			FROM sales_order so
			JOIN sales_order_item soi ON soi.so_id = so.id
			LEFT JOIN pelanggan p_cust ON so.pelanggan_id = p_cust.id
			LEFT JOIN produk p ON soi.produk_id = p.id
			LEFT JOIN kategori_produk kp ON kp.id = p.kategori_id
			LEFT JOIN aauth_users u ON u.username = so.created_by
			WHERE {$so_where_sql}

			UNION ALL

			SELECT 
				RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(pm.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10) as clean_phone,
				DATE(pm.tanggal_so) as tgl,
				COALESCE(pmi.subtotal, (pmi.qty * pmi.harga_satuan), pm.total, 0) as total,
				COALESCE(NULLIF(pm.nama_penerima, ''), NULLIF(pm.username_pembeli, ''), 'Customer') as nama
			FROM penjualan_marketplace pm
			JOIN penjualan_marketplace_item pmi ON pmi.penjualan_marketplace_id = pm.id
			LEFT JOIN produk p2 ON pmi.produk_id = p2.id
			LEFT JOIN kategori_produk kp2 ON kp2.id = p2.kategori_id
			WHERE {$pm_where_sql}
			ORDER BY tgl ASC
		";

		$query = $this->db->query($sql);
		$raw_orders = $query ? $query->result() : [];

		// Group transactions by customer
		$customer_orders = [];
		$customer_names = [];
		$data_awal_phones = [];

		foreach ($raw_orders as $ro) {
			$phone = $ro->clean_phone;
			if (empty($phone) || strlen($phone) < 8 || $phone === '-') continue;
			if (!isset($customer_orders[$phone])) {
				$customer_orders[$phone] = [];
				$customer_names[$phone] = $ro->nama;
			}
			$customer_orders[$phone][] = [
				'tgl' => $ro->tgl,
				'tot' => (float)$ro->total
			];
			if ($ro->tgl < $date_from) {
				$data_awal_phones[$phone] = true;
			}
		}

		$data_awal = count($data_awal_phones);
		if ($data_awal === 0 && !empty($customer_orders)) {
			// If all orders fall within or after date_from, calculate customers active on the start date dynamically
			$first_day_phones = [];
			foreach ($customer_orders as $phone => $orders) {
				foreach ($orders as $o) {
					if ($o['tgl'] <= $date_from) {
						$first_day_phones[$phone] = true;
						break;
					}
				}
			}
			$data_awal = count($first_day_phones);
		}

		// Helper to score RFM
		$score_rfm = function($days, $ord_cnt, $spend) use ($thresholds, $matrix) {
			$t_r = $thresholds['r'];
			if ($days <= $t_r[20]) $r = 5;
			elseif ($days <= $t_r[40]) $r = 4;
			elseif ($days <= $t_r[60]) $r = 3;
			elseif ($days <= $t_r[80]) $r = 2;
			else $r = 1;

			$t_f = $thresholds['f'];
			if ($ord_cnt >= $t_f[80]) $f = 5;
			elseif ($ord_cnt >= $t_f[60]) $f = 4;
			elseif ($ord_cnt >= $t_f[40]) $f = 3;
			elseif ($ord_cnt >= $t_f[20]) $f = 2;
			else $f = 1;

			$t_m = $thresholds['m'];
			if ($spend >= $t_m[80]) $m = 5;
			elseif ($spend >= $t_m[60]) $m = 4;
			elseif ($spend >= $t_m[40]) $m = 3;
			elseif ($spend >= $t_m[20]) $m = 2;
			else $m = 1;

			$code = $r . $f . $m;
			$seg = isset($matrix[$code]) ? $matrix[$code]['segment'] : 'Need Attention';
			if ($seg === 'Champions') $seg = 'Champion';
			if ($seg === "Can't Lose Them") $seg = 'Cant Lose Them';

			return [
				'code' => $code,
				'segment' => $seg,
				'r' => $r, 'f' => $f, 'm' => $m
			];
		};

		// Iterate day-by-day from date_from to date_to
		$daily_rows = [];
		$prev_counts = null;
		$chart_labels = [];
		$chart_datasets = [];

		$colors = [
			'New Customers' => '#06b6d4',
			'Need Attention' => '#f97316',
			'Frequent Low Value' => '#eab308',
			'Hibernating' => '#64748b',
			'At Risk Customers' => '#ef4444',
			'Cant Lose Them' => '#ec4899',
			'Potential Loyalist' => '#10b981',
			'Loyal Customers' => '#3b82f6',
			'Big Spenders' => '#8b5cf6',
			'Champion' => '#f59e0b'
		];

		// Segments to chart (if filtered by status_rfm, only display the filtered segments)
		$active_chart_segs = !empty($status_rfm_filter) ? array_values(array_intersect($all_segments, $status_rfm_filter)) : $all_segments;
		if (empty($active_chart_segs)) {
			$active_chart_segs = $all_segments;
		}

		// Initialize chart series
		foreach ($active_chart_segs as $seg) {
			$chart_datasets[$seg] = [
				'label' => $seg,
				'borderColor' => $colors[$seg] ?? '#6366f1',
				'backgroundColor' => ($colors[$seg] ?? '#6366f1') . '22',
				'data' => []
			];
		}

		$curr_ts = $df_ts;
		while ($curr_ts <= $dt_ts) {
			$dt_str = date('Y-m-d', $curr_ts);
			$formatted_dt = date('l, d M Y', $curr_ts);
			$short_label = date('d M', $curr_ts);
			$chart_labels[] = $short_label;

			$counts = array_fill_keys($all_segments, 0);

			foreach ($customer_orders as $phone => $orders) {
				$orders_to_date = [];
				$sum_spend = 0.0;
				$last_date = null;

				foreach ($orders as $o) {
					if ($o['tgl'] <= $dt_str) {
						$orders_to_date[] = $o;
						$sum_spend += $o['tot'];
						$last_date = $o['tgl'];
					}
				}

				if (empty($orders_to_date)) continue;

				$ord_cnt = count($orders_to_date);
				$days_since = max(0, (int)floor(($curr_ts - strtotime($last_date)) / 86400));

				$rfm_res = $score_rfm($days_since, $ord_cnt, $sum_spend);
				$seg = $rfm_res['segment'];

				if (isset($counts[$seg])) {
					$counts[$seg]++;
				} else {
					$counts['Need Attention']++;
				}
			}

			// Assemble segments data with diff & pct
			$segments_data = [];
			foreach ($all_segments as $seg) {
				$cnt = $counts[$seg];
				$diff = 0;
				$pct = 0.0;
				$trend = 'same';

				if ($prev_counts !== null) {
					$prev = $prev_counts[$seg];
					$diff = $cnt - $prev;
					if ($prev > 0) {
						$pct = round(($diff / $prev) * 100, 2);
					} elseif ($cnt > 0) {
						$pct = 100.0;
					}
					if ($diff > 0) $trend = 'up';
					elseif ($diff < 0) $trend = 'down';
				}

				$segments_data[$seg] = [
					'count' => $cnt,
					'diff'  => $diff,
					'pct'   => $pct,
					'trend' => $trend
				];

				if (isset($chart_datasets[$seg])) {
					$chart_datasets[$seg]['data'][] = $cnt;
				}
			}

			$day_data_awal = ($prev_counts !== null) ? array_sum($prev_counts) : $data_awal;
			$total_today = array_sum($counts);

			// Add to daily_rows (skip empty days before any customer existed)
			if ($total_today > 0 || $day_data_awal > 0) {
				$daily_rows[] = (object)[
					'date' => $dt_str,
					'formatted_date' => $formatted_dt,
					'data_awal' => $day_data_awal,
					'total_active' => $total_today,
					'segments' => $segments_data
				];
			}

			$prev_counts = $counts;
			$curr_ts = strtotime('+1 day', $curr_ts);
		}

		$total_customers = count($customer_orders);
		$total_orders = count($raw_orders);
		$daily_rows_table = array_reverse($daily_rows);

		return [
			'data_awal'        => $data_awal,
			'total_customers'  => $total_customers,
			'total_orders'     => $total_orders,
			'total_items'      => count($daily_rows),
			'daily_rows'       => $daily_rows_table,
			'daily_rows_asc'   => $daily_rows,
			'chart_rows'       => $daily_rows,
			'date_from'        => $date_from,
			'date_to'          => $date_to,
			'date_from_view'   => date('d/m/Y', $df_ts),
			'date_to_view'     => date('d/m/Y', $dt_ts),
			'chart_labels'     => $chart_labels,
			'chart_datasets'   => array_values($chart_datasets),
			'all_segments'     => $all_segments,
			'colors'           => $colors
		];
	}

	/**
	 * Get customer drilldown list for a specific date and RFM segment
	 */
	public function get_rfm_tracking_drilldown($date, $segment, $category_filter = '', $product_filter = '', $brand_filter = '', $specialist_filter = '')
	{
		if (empty($date)) {
			$date = date('Y-m-d');
		} elseif (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', trim($date), $m)) {
			$date = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
		}
		$effective_prod = !empty($product_filter) ? $product_filter : $brand_filter;
		$effective_cat = !empty($category_filter) ? $category_filter : $brand_filter;
		$thresholds = $this->get_rfm_percentile_thresholds($effective_prod, '', $effective_cat);
		$matrix = $this->get_rfm_matrix();

		$so_where = [];
		$pm_where = [];
		$so_where[] = "so.no_telepon IS NOT NULL AND so.no_telepon != ''";
		$so_where[] = "(so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))";
		$so_where[] = "so.tanggal_so IS NOT NULL AND so.tanggal_so <= " . $this->db->escape($date);
		$so_where[] = "CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' AND so.tanggal_so > '1970-01-01'";
		$so_where[] = "(so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))";

		$pm_where[] = "pm.no_telepon IS NOT NULL AND pm.no_telepon != ''";
		$pm_where[] = "pm.tanggal_so IS NOT NULL AND pm.tanggal_so <= " . $this->db->escape($date);
		$pm_where[] = "CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' AND pm.tanggal_so > '1970-01-01'";
		$pm_where[] = "(pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))";

		if (!empty($category_filter)) {
			$cf = $this->db->escape(trim($category_filter));
			$so_where[] = "(kp.nama_kategori = {$cf} OR kp.id = {$cf} OR p.kategori_id = {$cf})";
			$pm_where[] = "(kp2.nama_kategori = {$cf} OR kp2.id = {$cf} OR p2.kategori_id = {$cf})";
		}

		if (!empty($product_filter)) {
			$pf = $this->db->escape(trim($product_filter));
			$so_where[] = "(p.nama_produk = {$pf} OR p.id = {$pf} OR soi.catatan = {$pf})";
			$pm_where[] = "(p2.nama_produk = {$pf} OR p2.id = {$pf} OR pmi.catatan = {$pf} OR pm.nama_produk_marketplace = {$pf})";
		}

		if (!empty($brand_filter) && empty($category_filter)) {
			$bf = $this->db->escape(trim($brand_filter));
			$so_where[] = "(p.nama_produk = {$bf} OR kp.nama_kategori = {$bf} OR kp.id = {$bf} OR p.kategori_id = {$bf})";
			$pm_where[] = "(p2.nama_produk = {$bf} OR kp2.nama_kategori = {$bf} OR kp2.id = {$bf} OR p2.kategori_id = {$bf})";
		}

		if (!empty($specialist_filter)) {
			$sf = $this->db->escape(trim($specialist_filter));
			$so_where[] = "(so.created_by = {$sf} OR u.username = {$sf} OR u.email = {$sf} OR u.full_name = {$sf})";
			$pm_where[] = "(pm.created_by = {$sf})";
		}

		$so_where_sql = implode(' AND ', $so_where);
		$pm_where_sql = implode(' AND ', $pm_where);

		$sql = "
			SELECT 
				RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(so.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10) as clean_phone,
				DATE(so.tanggal_so) as tgl,
				COALESCE(soi.subtotal, (soi.qty * soi.harga_satuan), so.total, 0) as total,
				COALESCE(NULLIF(so.nama_penerima, ''), p_cust.nama_pelanggan, 'Customer') as nama
			FROM sales_order so
			JOIN sales_order_item soi ON soi.so_id = so.id
			LEFT JOIN pelanggan p_cust ON so.pelanggan_id = p_cust.id
			LEFT JOIN produk p ON soi.produk_id = p.id
			LEFT JOIN kategori_produk kp ON kp.id = p.kategori_id
			LEFT JOIN aauth_users u ON u.username = so.created_by
			WHERE {$so_where_sql}

			UNION ALL

			SELECT 
				RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(pm.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10) as clean_phone,
				DATE(pm.tanggal_so) as tgl,
				COALESCE(pmi.subtotal, (pmi.qty * pmi.harga_satuan), pm.total, 0) as total,
				COALESCE(NULLIF(pm.nama_penerima, ''), NULLIF(pm.username_pembeli, ''), 'Customer') as nama
			FROM penjualan_marketplace pm
			JOIN penjualan_marketplace_item pmi ON pmi.penjualan_marketplace_id = pm.id
			LEFT JOIN produk p2 ON pmi.produk_id = p2.id
			LEFT JOIN kategori_produk kp2 ON kp2.id = p2.kategori_id
			WHERE {$pm_where_sql}
			ORDER BY tgl ASC
		";

		$query = $this->db->query($sql);
		$raw_orders = $query ? $query->result() : [];

		$customer_orders = [];
		$customer_names = [];
		foreach ($raw_orders as $ro) {
			$phone = $ro->clean_phone;
			if (empty($phone) || strlen($phone) < 8 || $phone === '-') continue;
			if (!isset($customer_orders[$phone])) {
				$customer_orders[$phone] = [];
			}
			if (!isset($customer_names[$phone]) || $customer_names[$phone] === 'Customer') {
				if (!empty($ro->nama) && $ro->nama !== 'Customer') {
					$customer_names[$phone] = $ro->nama;
				} elseif (!isset($customer_names[$phone])) {
					$customer_names[$phone] = $ro->nama ?: 'Customer';
				}
			}
			$customer_orders[$phone][] = [
				'tgl' => $ro->tgl,
				'tot' => (float)$ro->total
			];
		}

		$date_ts = strtotime($date);
		$result_customers = [];

		foreach ($customer_orders as $phone => $orders) {
			$orders_to_date = [];
			$sum_spend = 0.0;
			$last_date = null;

			foreach ($orders as $o) {
				if ($o['tgl'] <= $date) {
					$orders_to_date[] = $o;
					$sum_spend += $o['tot'];
					$last_date = $o['tgl'];
				}
			}

			if (empty($orders_to_date)) continue;

			$ord_cnt = count($orders_to_date);
			$days_since = max(0, (int)floor(($date_ts - strtotime($last_date)) / 86400));

			$t_r = $thresholds['r'];
			if ($days_since <= $t_r[20]) $r = 5;
			elseif ($days_since <= $t_r[40]) $r = 4;
			elseif ($days_since <= $t_r[60]) $r = 3;
			elseif ($days_since <= $t_r[80]) $r = 2;
			else $r = 1;

			$t_f = $thresholds['f'];
			if ($ord_cnt >= $t_f[80]) $f = 5;
			elseif ($ord_cnt >= $t_f[60]) $f = 4;
			elseif ($ord_cnt >= $t_f[40]) $f = 3;
			elseif ($ord_cnt >= $t_f[20]) $f = 2;
			else $f = 1;

			$t_m = $thresholds['m'];
			if ($sum_spend >= $t_m[80]) $m = 5;
			elseif ($sum_spend >= $t_m[60]) $m = 4;
			elseif ($sum_spend >= $t_m[40]) $m = 3;
			elseif ($sum_spend >= $t_m[20]) $m = 2;
			else $m = 1;

			$code = $r . $f . $m;
			$seg = isset($matrix[$code]) ? $matrix[$code]['segment'] : 'Need Attention';
			if ($seg === 'Champions') $seg = 'Champion';
			if ($seg === "Can't Lose Them") $seg = 'Cant Lose Them';

			// Filter by segment if specified
			if ($segment !== 'all' && strcasecmp($seg, $segment) !== 0) {
				continue;
			}

			$display_phone = $phone;
			if (strpos($display_phone, '0') !== 0 && strpos($display_phone, '62') !== 0) {
				$display_phone = '0' . $display_phone;
			}
			$cust_name = $customer_names[$phone] ?? 'Customer';

			$result_customers[] = (object)[
				'phone'           => $display_phone,
				'no_hp'           => $display_phone,
				'nama'            => $cust_name,
				'nama_pelanggan'  => $cust_name,
				'total_orders'    => $ord_cnt,
				'frequency'       => $ord_cnt,
				'total_spend'     => $sum_spend,
				'monetary'        => $sum_spend,
				'last_order_date' => $last_date,
				'days_since_last' => $days_since,
				'recency'         => $days_since,
				'rfm_code'        => $code,
				'rfm_score'       => $code,
				'rfm_display'     => $r . '-' . $f . '-' . $m,
				'segment'         => $seg
			];
		}

		// Selalu urutkan agar pelanggan dengan transaksi paling baru selalu muncul paling atas
		usort($result_customers, function($a, $b) {
			if ($a->last_order_date === $b->last_order_date) {
				return $a->recency <=> $b->recency;
			}
			return strcmp($b->last_order_date, $a->last_order_date);
		});

		return $result_customers;
	}

	/**
	 * Get daily Keterangan BC (followup) summary within date range.
	 * Aggregates followup categories per day: H+0, H+3, H+7, H+11, Repeat Order, etc.
	 */
	public function get_daily_bc_summary($date_from = '', $date_to = '')
	{
		// Normalize d/m/Y or d-m-Y to Y-m-d
		$date_from = trim($date_from);
		$date_to = trim($date_to);
		if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $date_from, $m)) {
			$date_from = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
		}
		if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $date_to, $m)) {
			$date_to = sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
		}

		if (empty($date_from) || empty($date_to)) {
			return [];
		}

		if ($date_from > $date_to) {
			$tmp = $date_from; $date_from = $date_to; $date_to = $tmp;
		}

		// Get followup categories for column headers, ordered strictly by jumlah_hari
		$categories = $this->db->order_by('CAST(jumlah_hari AS UNSIGNED)', 'ASC')
							   ->order_by('urutan', 'ASC')
							   ->order_by('id', 'ASC')
							   ->get_where('crm_followup_categories', ['is_active' => 1])->result();

		// Build dynamic options from categories matching Kelompok & Template Follow-Up (H+0, H+3, H+7, etc.)
		$dynamic_h = [];
		$cat_map = [];
		foreach ($categories as $cat) {
			if (isset($cat->jumlah_hari)) {
				$code = 'H+' . (int)$cat->jumlah_hari;
				$dynamic_h[] = $code;
				$cat_map[$cat->id] = $code;
			}
		}
		$dynamic_h = array_values(array_unique($dynamic_h));
		$all_bc_opts = $dynamic_h;

		$df_esc = $this->db->escape($date_from);
		$dt_esc = $this->db->escape($date_to);

		// Query all followup labels that have been COMPLETED / SENT ("followup yang sudah"):
		// 1. is_broadcast_sent = 1
		// 2. OR status_label is not Pending / empty (e.g. Sudah Dikirim, Direspon, Selesai, Sudah Konfirmasi Diterima, Completed)
		// 3. OR keterangan_bc is set
		// 4. OR waktu_kirim_wa is recorded
		// 5. OR a broadcast log exists in crm_broadcast_logs
		// Matches date range by tanggal_pengiriman (order/shipping date) OR by actual followup/broadcast date
		$sql = "SELECT 
					fl.id,
					fl.no_pesanan,
					fl.customer_nama,
					fl.customer_phone,
					fl.status_label,
					fl.is_broadcast_sent,
					fl.waktu_kirim_wa,
					fl.keterangan_bc,
					fl.followup_category_id,
					fl.tanggal_pengiriman,
					fl.updated_at,
					fc.jumlah_hari,
					fc.nama_kategori,
					(SELECT MAX(bl.waktu_kirim) FROM crm_broadcast_logs bl WHERE bl.followup_label_id = fl.id) as log_waktu_kirim
				FROM crm_transaction_followup_labels fl
				JOIN crm_followup_categories fc ON fl.followup_category_id = fc.id
				WHERE (
					fl.is_broadcast_sent = 1
					OR (fl.status_label IS NOT NULL AND fl.status_label NOT IN ('Pending', ''))
					OR (fl.keterangan_bc IS NOT NULL AND fl.keterangan_bc != '')
					OR (fl.waktu_kirim_wa IS NOT NULL AND fl.waktu_kirim_wa > '1970-01-01')
					OR (SELECT COUNT(*) FROM crm_broadcast_logs bl WHERE bl.followup_label_id = fl.id) > 0
				)
				AND (
					fl.tanggal_pengiriman BETWEEN {$df_esc} AND {$dt_esc}
					OR DATE(fl.waktu_kirim_wa) BETWEEN {$df_esc} AND {$dt_esc}
					OR (SELECT COUNT(*) FROM crm_broadcast_logs bl WHERE bl.followup_label_id = fl.id AND DATE(bl.waktu_kirim) BETWEEN {$df_esc} AND {$dt_esc}) > 0
				)
				ORDER BY fl.tanggal_pengiriman DESC, fl.id DESC";

		$done_rows = $this->db->query($sql)->result();

		$rows_by_date = [];
		$hari_indo = [
			'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
			'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
		];

		$column_totals = array_fill_keys($all_bc_opts, 0);
		$grand_total = 0;

		foreach ($done_rows as $r) {
			// Resolve exact milestone code: H+0, H+3, H+7, etc.
			$milestone = isset($r->jumlah_hari) ? ('H+' . (int)$r->jumlah_hari) : null;
			if (!$milestone && !empty($r->keterangan_bc)) {
				if (preg_match('/\(H\+(\d+)\)/i', $r->keterangan_bc, $m) || preg_match('/^H\+(\d+)$/i', $r->keterangan_bc, $m)) {
					$milestone = 'H+' . (int)$m[1];
				}
			}
			if (!$milestone && isset($cat_map[$r->followup_category_id])) {
				$milestone = $cat_map[$r->followup_category_id];
			}
			if (!$milestone) {
				$milestone = 'H+0';
			}

			// Ensure milestone exists in options
			if (!in_array($milestone, $all_bc_opts)) {
				$all_bc_opts[] = $milestone;
				$column_totals[$milestone] = 0;
			}

			// Determine date within filter range (priority: tanggal_pengiriman if within range, else actual send date)
			$eff_date = $r->tanggal_pengiriman;
			if ($eff_date < $date_from || $eff_date > $date_to) {
				if (!empty($r->log_waktu_kirim)) {
					$log_d = date('Y-m-d', strtotime($r->log_waktu_kirim));
					if ($log_d >= $date_from && $log_d <= $date_to) $eff_date = $log_d;
				} elseif (!empty($r->waktu_kirim_wa)) {
					$wa_d = date('Y-m-d', strtotime($r->waktu_kirim_wa));
					if ($wa_d >= $date_from && $wa_d <= $date_to) $eff_date = $wa_d;
				}
			}

			if (empty($eff_date) || $eff_date < '1970-01-01') {
				$eff_date = date('Y-m-d');
			}

			if (!isset($rows_by_date[$eff_date])) {
				$day_name = date('l', strtotime($eff_date));
				$nama_h = $hari_indo[$day_name] ?? $day_name;
				$rows_by_date[$eff_date] = [
					'tgl'       => $eff_date,
					'day_label' => $nama_h . ', ' . date('d/m/Y', strtotime($eff_date)),
					'total'     => 0,
					'counts'    => array_fill_keys($all_bc_opts, 0),
					'customers' => []
				];
			}

			if (!isset($rows_by_date[$eff_date]['counts'][$milestone])) {
				$rows_by_date[$eff_date]['counts'][$milestone] = 0;
			}
			$rows_by_date[$eff_date]['counts'][$milestone]++;
			$rows_by_date[$eff_date]['total']++;

			if (!isset($rows_by_date[$eff_date]['customers'][$milestone])) {
				$rows_by_date[$eff_date]['customers'][$milestone] = [];
			}
			$rows_by_date[$eff_date]['customers'][$milestone][] = $r->customer_nama ?: 'Customer';

			$column_totals[$milestone]++;
			$grand_total++;
		}

		krsort($rows_by_date);

		return [
			'categories'    => $categories,
			'bc_options'    => $all_bc_opts,
			'rows'          => array_values($rows_by_date),
			'column_totals' => $column_totals,
			'grand_total'   => $grand_total,
			'date_from'     => $date_from,
			'date_to'       => $date_to,
		];
	}
}
