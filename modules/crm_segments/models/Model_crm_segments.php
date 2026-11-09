<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_crm_segments extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('crm/model_crm');
	}

	/**
	 * Get list of official master products directly from table `produk` in database
	 */
	/**
	 * Get list of categories directly from database
	 */
	public function get_distinct_categories_list()
	{
		$sql = "
			SELECT DISTINCT kp.id, kp.nama_kategori
			FROM kategori_produk kp
			WHERE kp.nama_kategori IS NOT NULL AND TRIM(kp.nama_kategori) != ''
			  AND (
				EXISTS (SELECT 1 FROM produk p WHERE p.kategori_id = kp.id)
				OR kp.nama_kategori LIKE '%Resi%'
				OR kp.nama_kategori LIKE '%Marketplace%'
			  )
			ORDER BY kp.nama_kategori ASC
		";
		$query = $this->db->query($sql);
		return $query ? $query->result() : [];
	}

	/**
	 * Get distinct transaction years directly from sales_order and penjualan_marketplace
	 */
	public function get_distinct_years_list()
	{
		$sql = "
			SELECT DISTINCT YEAR(tanggal_so) as yr 
			FROM (
				SELECT tanggal_so FROM sales_order WHERE tanggal_so > '1970-01-01'
				UNION ALL
				SELECT tanggal_so FROM penjualan_marketplace WHERE tanggal_so > '1970-01-01'
			) t
			HAVING yr IS NOT NULL AND yr > 2000
			ORDER BY yr DESC
		";
		$query = $this->db->query($sql);
		$res = $query ? $query->result() : [];
		return !empty($res) ? $res : [(object)['yr' => date('Y')]];
	}

	/**
	 * Get distinct transaction months directly from database or all 12 calendar months for the year
	 */
	public function get_distinct_months_list($year = null)
	{
		$indo_months = [
			'01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
			'04' => 'April',   '05' => 'Mei',      '06' => 'Juni',
			'07' => 'Juli',    '08' => 'Agustus',  '09' => 'September',
			'10' => 'Oktober', '11' => 'November', '12' => 'Desember'
		];

		if (!empty($year) && $year !== 'all') {
			$y_int = (int)$year;
			$res = [];
			for ($m = 1; $m <= 12; $m++) {
				$m_pad = str_pad($m, 2, '0', STR_PAD_LEFT);
				$ym_val = "{$y_int}-{$m_pad}";
				$ym_label = ($indo_months[$m_pad] ?? $m_pad) . " " . $y_int;
				$res[] = (object)[
					'ym_val'   => $ym_val,
					'ym_label' => $ym_label
				];
			}
			return $res;
		}

		// If 'all' years, get distinct years from transactions and return all 12 months for each year
		$sql = "
			SELECT DISTINCT YEAR(tanggal_so) as yr
			FROM (
				SELECT tanggal_so FROM sales_order WHERE tanggal_so > '1970-01-01'
				UNION ALL
				SELECT tanggal_so FROM penjualan_marketplace WHERE tanggal_so > '1970-01-01'
			) t
			WHERE tanggal_so IS NOT NULL
			ORDER BY yr DESC
		";
		$years_rows = $this->db->query($sql)->result();
		if (empty($years_rows)) {
			$years_rows = [(object)['yr' => 2026]];
		}

		$res = [];
		foreach ($years_rows as $yr_item) {
			$y_int = (int)$yr_item->yr;
			for ($m = 1; $m <= 12; $m++) {
				$m_pad = str_pad($m, 2, '0', STR_PAD_LEFT);
				$ym_val = "{$y_int}-{$m_pad}";
				$ym_label = ($indo_months[$m_pad] ?? $m_pad) . " " . $y_int;
				$res[] = (object)[
					'ym_val'   => $ym_val,
					'ym_label' => $ym_label
				];
			}
		}
		return $res;
	}

	/**
	 * Get list of official master products directly from table `produk` in database (with optional category filter)
	 */
	public function get_distinct_products_list($category = null)
	{
		$cat_where = "";
		if (!empty($category)) {
			$c_esc = $this->db->escape(trim($category));
			$cat_where = " AND (kp.nama_kategori = {$c_esc} OR kp.id = {$c_esc}) ";
		}
		$sql = "
			SELECT p.id, p.kode_produk, p.nama_produk, p.harga_jual, COALESCE(NULLIF(kp.nama_kategori, ''), 'Tanpa Kategori') as nama_kategori
			FROM produk p 
			LEFT JOIN kategori_produk kp ON p.kategori_id = kp.id
			WHERE p.nama_produk IS NOT NULL AND TRIM(p.nama_produk) != ''
			  AND (
				(p.created_by != 'import_resi' AND p.kode_produk NOT LIKE 'MP-%')
				OR EXISTS (SELECT 1 FROM penjualan_marketplace_item pmi WHERE pmi.produk_id = p.id)
				OR EXISTS (SELECT 1 FROM sales_order_item soi WHERE soi.produk_id = p.id)
			  )
			{$cat_where}
			ORDER BY kp.nama_kategori ASC, p.nama_produk ASC
		";

		$query = $this->db->query($sql);
		return $query ? $query->result() : [];
	}

	/**
	 * Resolve product row from table `produk` by ID, code, or name, with optional category fallback
	 */
	public function resolve_product($product_identifier = null, $category = null)
	{
		$prod_row = null;
		if (!empty($product_identifier) && $product_identifier !== 'all') {
			$clean_name = trim(preg_replace('/\s*\([^)]*\)$/', '', $product_identifier));
			// 1. Try by ID if numeric
			if (is_numeric($product_identifier)) {
				$prod_row = $this->db->get_where('produk', ['id' => (int)$product_identifier])->row();
			}
			// 2. Try by exact nama_produk (clean name)
			if (!$prod_row) {
				$prod_row = $this->db->get_where('produk', ['nama_produk' => $clean_name])->row();
			}
			// 3. Try by raw product_identifier
			if (!$prod_row && $clean_name !== $product_identifier) {
				$prod_row = $this->db->get_where('produk', ['nama_produk' => $product_identifier])->row();
			}
			// 4. Try by kode_produk
			if (!$prod_row) {
				$prod_row = $this->db->get_where('produk', ['kode_produk' => $product_identifier])->row();
			}
			// 5. Try by like nama_produk
			if (!$prod_row) {
				$prod_row = $this->db->like('nama_produk', $clean_name)->get('produk')->row();
			}
			// 6. Marketplace items fallback (e.g. unmapped skincare products)
			if (!$prod_row) {
				$clean_esc = $this->db->escape($clean_name);
				$check_pm = $this->db->query("
					SELECT pmi.catatan, kp.nama_kategori, kp.id as kategori_id
					FROM penjualan_marketplace_item pmi
					LEFT JOIN produk p ON pmi.produk_id = p.id
					LEFT JOIN kategori_produk kp ON p.kategori_id = kp.id
					WHERE TRIM(REGEXP_REPLACE(pmi.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_esc}
					   OR pmi.catatan = " . $this->db->escape($product_identifier) . "
					LIMIT 1
				")->row();

				if ($check_pm) {
					$prod_row = (object)[
						'id'            => 0,
						'kode_produk'   => '-',
						'nama_produk'   => $clean_name,
						'kategori_id'   => $check_pm->kategori_id ?? 0,
						'nama_kategori' => $check_pm->nama_kategori ?? 'Produk Marketplace'
					];
				}
			}
		}

		return $prod_row;
	}

	/**
	 * Standard 10 RFM Segments definition with official icons and badges
	 */
	public function get_standard_segments()
	{
		return [
			'Champions'           => ['icon' => '🏆', 'fa_icon' => 'fa-trophy', 'color' => '#f59e0b', 'bg' => '#fef3c7'],
			'Loyal Customers'     => ['icon' => '💚', 'fa_icon' => 'fa-heart', 'color' => '#10b981', 'bg' => '#d1fae5'],
			'Potential Loyalist'  => ['icon' => '⭐', 'fa_icon' => 'fa-star', 'color' => '#3b82f6', 'bg' => '#dbeafe'],
			'New Customers'       => ['icon' => '👥', 'fa_icon' => 'fa-user-plus', 'color' => '#6366f1', 'bg' => '#e0e7ff'],
			'Big Spenders'        => ['icon' => '💰', 'fa_icon' => 'fa-diamond', 'color' => '#8b5cf6', 'bg' => '#ede9fe'],
			'Frequent Low Value'  => ['icon' => '🛒', 'fa_icon' => 'fa-shopping-cart', 'color' => '#64748b', 'bg' => '#f1f5f9'],
			'Need Attention'      => ['icon' => '🔔', 'fa_icon' => 'fa-bell', 'color' => '#f97316', 'bg' => '#ffedd5'],
			'At Risk Customers'   => ['icon' => '⚠️', 'fa_icon' => 'fa-exclamation-triangle', 'color' => '#ef4444', 'bg' => '#fee2e2'],
			'Can\'t Lose Them'    => ['icon' => '🚨', 'fa_icon' => 'fa-shield', 'color' => '#dc2626', 'bg' => '#fecaca'],
			'Hibernating'         => ['icon' => '💤', 'fa_icon' => 'fa-moon-o', 'color' => '#94a3b8', 'bg' => '#f8fafc'],
		];
	}

	/**
	 * Compute the Product RFM Matrix across months from real database records
	 */
	public function get_product_rfm_matrix($product = null, $year = null, $period = null, $category = null, $mode = 'cumulative')
	{
		$prod_row = null;
		if (!empty($product) && $product !== 'all') {
			$prod_row = $this->resolve_product($product, $category);
		}

		$standard_segments = $this->get_standard_segments();

		$indo_short = [
			'01' => 'JAN', '02' => 'FEB', '03' => 'MAR', '04' => 'APR',
			'05' => 'MEI', '06' => 'JUN', '07' => 'JUL', '08' => 'AGS',
			'09' => 'SEP', '10' => 'OKT', '11' => 'NOV', '12' => 'DES'
		];

		// Build dynamic months: generate all 12 calendar months for selected year (or all years if year=all)
		$months = [];
		if (!empty($year) && $year !== 'all') {
			$y_int = (int)$year;
			for ($m = 1; $m <= 12; $m++) {
				$m_pad = str_pad($m, 2, '0', STR_PAD_LEFT);
				$ym = "{$y_int}-{$m_pad}";
				$y_short = substr((string)$y_int, 2, 2);
				$label = ($indo_short[$m_pad] ?? $m_pad) . " '" . $y_short;
				$months[$ym] = $label;
			}
		} elseif ($year === 'all') {
			$ym_rows = $this->db->query("
				SELECT DISTINCT DATE_FORMAT(tanggal_so, '%Y-%m') as ym
				FROM (
					SELECT tanggal_so FROM sales_order WHERE tanggal_so > '1970-01-01'
					UNION ALL
					SELECT tanggal_so FROM penjualan_marketplace WHERE tanggal_so > '1970-01-01'
				) t
				ORDER BY ym ASC
			")->result();
			if (!empty($ym_rows)) {
				foreach ($ym_rows as $yr_row) {
					$ym = $yr_row->ym;
					$m_num = substr($ym, 5, 2);
					$y_short = substr($ym, 2, 2);
					$label = ($indo_short[$m_num] ?? $m_num) . " '" . $y_short;
					$months[$ym] = $label;
				}
			} else {
				$y_int = 2026;
				for ($m = 1; $m <= 12; $m++) {
					$m_pad = str_pad($m, 2, '0', STR_PAD_LEFT);
					$ym = "{$y_int}-{$m_pad}";
					$y_short = substr((string)$y_int, 2, 2);
					$label = ($indo_short[$m_pad] ?? $m_pad) . " '" . $y_short;
					$months[$ym] = $label;
				}
			}
		} else {
			// Default: Year 2026 all 12 calendar months
			$y_int = 2026;
			for ($m = 1; $m <= 12; $m++) {
				$m_pad = str_pad($m, 2, '0', STR_PAD_LEFT);
				$ym = "{$y_int}-{$m_pad}";
				$y_short = substr((string)$y_int, 2, 2);
				$label = ($indo_short[$m_pad] ?? $m_pad) . " '" . $y_short;
				$months[$ym] = $label;
			}
		}

		if (empty($months)) {
			// Fallback: 10 months default
			$months = [
				'2026-01' => "JAN '26", '2026-02' => "FEB '26", '2026-03' => "MAR '26",
				'2026-04' => "APR '26", '2026-05' => "MEI '26", '2026-06' => "JUN '26",
				'2026-07' => "JUL '26", '2026-08' => "AGS '26", '2026-09' => "SEP '26", '2026-10' => "OKT '26"
			];
		}

		return $this->_calculate_dynamic_matrix($prod_row, $months, $standard_segments, $period, $category, $mode);
	}

	/**
	 * Compute dynamic matrix from real database records for the resolved master product
	 */
	private function _calculate_dynamic_matrix($prod_row, $default_months, $standard_segments, $period_filter = null, $category = null, $mode = 'cumulative')
	{
		$cat_join_so = "";
		$cat_join_pm = "";
		$item_filter_so = "";
		$item_filter_pm = "";

		if ($prod_row) {
			$pid = (int)$prod_row->id;
			$clean_pname = trim(preg_replace('/\s*\([^)]*\)$/', '', $prod_row->nama_produk));
			$clean_pname_esc = $this->db->escape($clean_pname);
			$like_pname = $this->db->escape_like_str($clean_pname);

			$id_match_so = ($pid > 1) ? "(p.id > 1 AND p.nama_produk = {$clean_pname_esc}) OR soi.produk_id = {$pid} OR " : "";
			$id_match_pm = ($pid > 1) ? "(p.id > 1 AND p.nama_produk = {$clean_pname_esc}) OR pmi.produk_id = {$pid} OR " : "";

			$item_filter_so = "AND ({$id_match_so} TRIM(REGEXP_REPLACE(soi.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pname_esc} OR soi.catatan LIKE '{$like_pname}%')";
			$item_filter_pm = "AND ({$id_match_pm} TRIM(REGEXP_REPLACE(pmi.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pname_esc} OR pmi.catatan LIKE '{$like_pname}%')";
		} elseif (!empty($category)) {
			$c_esc = $this->db->escape(trim($category));
			$cat_join_so = "LEFT JOIN kategori_produk kp ON p.kategori_id = kp.id";
			$cat_join_pm = "LEFT JOIN kategori_produk kp ON p.kategori_id = kp.id";
			$item_filter_so = "AND (kp.nama_kategori = {$c_esc} OR kp.id = {$c_esc} OR p.kategori_id = {$c_esc})";
			$item_filter_pm = "AND (kp.nama_kategori = {$c_esc} OR kp.id = {$c_esc} OR p.kategori_id = {$c_esc})";
		}

		$sql = "
			SELECT 
				RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(t.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10) as clean_phone,
				t.tanggal_so,
				DATE_FORMAT(t.tanggal_so, '%Y-%m') as ym,
				t.subtotal,
				t.order_id
			FROM (
				SELECT 
					so.no_telepon, 
					so.tanggal_so, 
					COALESCE(soi.subtotal, soi.qty * soi.harga_satuan, 0) as subtotal, 
					CONCAT('so_', so.id) as order_id
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				{$cat_join_so}
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
				  AND so.tanggal_so IS NOT NULL AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%'
				  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))
				  {$item_filter_so}

				UNION ALL

				SELECT 
					pm.no_telepon, 
					pm.tanggal_so, 
					COALESCE(pmi.subtotal, pmi.qty * pmi.harga_satuan, 0) as subtotal, 
					CONCAT('pm_', pm.id) as order_id
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p ON pmi.produk_id = p.id
				{$cat_join_pm}
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%'
				  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
				  {$item_filter_pm}
			) t
			ORDER BY t.tanggal_so ASC
		";

		$transactions = $this->db->query($sql)->result();

		$months = $default_months;
		$unique_phones = [];
		$total_omset = 0.0;
		$customer_monthly_stats = [];

		foreach ($transactions as $tx) {
			$phone = $tx->clean_phone;
			$ym = $tx->ym;
			$subtotal = (float)$tx->subtotal;

			$unique_phones[$phone] = true;
			$total_omset += $subtotal;

			if (!isset($customer_monthly_stats[$ym])) {
				$customer_monthly_stats[$ym] = [];
			}
			if (!isset($customer_monthly_stats[$ym][$phone])) {
				$customer_monthly_stats[$ym][$phone] = [
					'orders' => [],
					'spend' => 0.0,
					'last_date' => $tx->tanggal_so
				];
			}
			$customer_monthly_stats[$ym][$phone]['orders'][$tx->order_id] = true;
			$customer_monthly_stats[$ym][$phone]['spend'] += $subtotal;
			if ($tx->tanggal_so > $customer_monthly_stats[$ym][$phone]['last_date']) {
				$customer_monthly_stats[$ym][$phone]['last_date'] = $tx->tanggal_so;
			}
		}

		// Calculate 80th percentile spend threshold for product/category
		$prod_name = $prod_row ? $prod_row->nama_produk : '';
		$thresholds = $this->model_crm->get_rfm_percentile_thresholds($prod_name, '', $category);
		$p80_spend = $thresholds['m'][80] ?? 1000000;

		// Retrieve all chronological months in database for lifecycle index calculation
		$all_months_query = $this->db->query("
			SELECT DISTINCT DATE_FORMAT(tanggal_so, '%Y-%m') as ym
			FROM (
				SELECT tanggal_so FROM sales_order WHERE tanggal_so > '1970-01-01'
				UNION ALL
				SELECT tanggal_so FROM penjualan_marketplace WHERE tanggal_so > '1970-01-01'
			) t ORDER BY ym ASC
		")->result();
		$all_system_months = !empty($all_months_query) ? array_column($all_months_query, 'ym') : array_keys($months);

		// Initialize matrix counts
		$matrix = [];
		$max_cell_val = 1;
		$totals_per_month = array_fill_keys(array_keys($months), 0);

		foreach ($standard_segments as $seg_name => $meta) {
			$matrix[$seg_name] = [
				'name'       => $seg_name,
				'icon'       => $meta['icon'],
				'fa_icon'    => $meta['fa_icon'],
				'color'      => $meta['color'],
				'counts'     => array_fill_keys(array_keys($months), 0),
				'growth'     => [],
				'total_cust' => 0,
				'trend_pct'  => 0.0,
			];
		}

		// Cumulative running stats per customer across months
		$running_stats = [];

		// Assign customers to segments per month using dynamic customer lifecycle RFM
		foreach ($months as $ym => $label) {
			// Skip months if no customer history yet and no transaction in this month
			if (!isset($customer_monthly_stats[$ym]) && empty($running_stats)) {
				continue;
			}

			// For future months beyond the current system date, leave as 0 (rendered as -)
			if ($ym > date('Y-m')) {
				continue;
			}

			// Accumulate history up to this month
			if (isset($customer_monthly_stats[$ym])) {
				foreach ($customer_monthly_stats[$ym] as $phone => $m_stat) {
					if (!isset($running_stats[$phone])) {
						$running_stats[$phone] = [
							'first_ym'  => $ym,
							'orders'    => [],
							'spend'     => 0.0,
							'last_date' => $m_stat['last_date'],
							'last_ym'   => $ym,
						];
					}
					foreach ($m_stat['orders'] as $oid => $val) {
						$running_stats[$phone]['orders'][$oid] = true;
					}
					$running_stats[$phone]['spend'] += $m_stat['spend'];
					$running_stats[$phone]['last_ym'] = $ym;
					if ($m_stat['last_date'] > $running_stats[$phone]['last_date']) {
						$running_stats[$phone]['last_date'] = $m_stat['last_date'];
					}
				}
			}

			// In cumulative mode: evaluate entire cumulative customer base up to this month
			// In monthly mode: evaluate only customers active in this specific month
			$eval_pool = ($mode === 'monthly') ? ($customer_monthly_stats[$ym] ?? []) : $running_stats;

			foreach ($eval_pool as $phone => $stat_item) {
				$c_stat = $running_stats[$phone];
				$order_count = count($c_stat['orders']);
				$total_spend = $c_stat['spend'];
				$is_active_now = isset($customer_monthly_stats[$ym][$phone]);

				if ($is_active_now) {
					// Active in this month
					if ($c_stat['first_ym'] === $ym && $order_count === 1) {
						// First time customer for this product
						$seg = ($total_spend >= $p80_spend) ? 'Big Spenders' : 'New Customers';
					} else {
						// Repeat buyer (bought across months or multiple orders)
						if ($order_count >= 3 && $total_spend >= $p80_spend) {
							$seg = 'Champions';
						} elseif ($total_spend >= $p80_spend) {
							$seg = 'Big Spenders';
						} elseif ($order_count >= 2) {
							$seg = 'Loyal Customers';
						} else {
							$seg = 'Potential Loyalist';
						}
					}
				} else {
					// Inactive this month (bought in previous months)
					$y_curr = (int)substr($ym, 0, 4);
					$m_curr = (int)substr($ym, 5, 2);
					$y_last = (int)substr($c_stat['last_ym'], 0, 4);
					$m_last = (int)substr($c_stat['last_ym'], 5, 2);
					$idle_months = ($y_curr - $y_last) * 12 + ($m_curr - $m_last);

					if ($idle_months <= 1) {
						$seg = 'Need Attention'; // 1 month idle (Belum Beli Lagi)
					} elseif ($idle_months == 2) {
						$seg = ($total_spend >= $p80_spend) ? "Can't Lose Them" : 'At Risk Customers';
					} else {
						$seg = 'Hibernating'; // 3+ months idle
					}
				}

				if (isset($matrix[$seg])) {
					$matrix[$seg]['counts'][$ym]++;
					$totals_per_month[$ym]++;
					if ($matrix[$seg]['counts'][$ym] > $max_cell_val) {
						$max_cell_val = $matrix[$seg]['counts'][$ym];
					}
				}
			}
		}

		// Identify active transaction window
		$active_keys = array_keys(array_filter($totals_per_month, function($v) { return $v > 0; }));
		$first_active_ym = !empty($active_keys) ? reset($active_keys) : null;
		$latest_active_ym = !empty($active_keys) ? end($active_keys) : (!empty($months) ? end(array_keys($months)) : null);

		// Calculate MoM growth for each segment
		foreach ($standard_segments as $seg_name => $meta) {
			$prev_c = null;
			$last_non_zero_c = null;
			$first_val = null;
			$last_val = 0;

			foreach ($months as $ym => $label) {
				$c = $matrix[$seg_name]['counts'][$ym];
				
				if ($mode === 'monthly') {
					$matrix[$seg_name]['total_cust'] += $c;
				}

				if ($first_val === null && $c > 0) {
					$first_val = $c;
				}
				if ($c > 0) {
					$last_val = $c;
				}

				$g = null;
				$display_zero = false;

				// Calculate progression within active transaction window
				if ($first_active_ym && $latest_active_ym && $ym >= $first_active_ym && $ym <= $latest_active_ym) {
					if ($c > 0) {
						if ($last_non_zero_c === null) {
							// First time this segment appears: 100% baseline
							$g = 100.0;
						} elseif ($prev_c > 0) {
							$g = round((($c - $prev_c) / $prev_c) * 100, 1);
						} else {
							// Grew back from 0, compare with last active count
							$g = round((($c - $last_non_zero_c) / $last_non_zero_c) * 100, 1);
						}
						$last_non_zero_c = $c;
					} else {
						// c == 0 in active operational period
						if ($last_non_zero_c !== null) {
							// Previously had customers, now 0: drop by 100% (-100%)
							$display_zero = true;
							if ($prev_c > 0) {
								$g = -100.0;
							} else {
								$g = 0.0;
							}
						}
					}
				}

				$matrix[$seg_name]['growth'][$ym] = $g;
				$matrix[$seg_name]['display_zero'][$ym] = $display_zero;
				$prev_c = $c;
			}

			if ($mode !== 'monthly') {
				// In cumulative mode, total_cust is the latest cumulative count
				$matrix[$seg_name]['total_cust'] = $latest_active_ym ? ($matrix[$seg_name]['counts'][$latest_active_ym] ?? 0) : 0;
			}

			// Trend percentage: compare last active vs first active month in matrix
			$first_ym = !empty($active_keys) ? $active_keys[0] : null;
			$last_ym = $latest_active_ym;
			$first_month_c = ($first_ym && isset($matrix[$seg_name]['counts'][$first_ym])) ? $matrix[$seg_name]['counts'][$first_ym] : 0;
			$last_month_c = ($last_ym && isset($matrix[$seg_name]['counts'][$last_ym])) ? $matrix[$seg_name]['counts'][$last_ym] : 0;

			if ($first_month_c == 0) {
				foreach ($months as $ym => $l) {
					if ($matrix[$seg_name]['counts'][$ym] > 0) {
						$first_month_c = $matrix[$seg_name]['counts'][$ym];
						$first_ym = $ym;
						break;
					}
				}
			}

			if ($first_ym && $first_ym === $last_ym) {
				// The segment only has data in the latest active month (newly emerged)
				if ($last_month_c > 0) {
					$matrix[$seg_name]['trend_pct'] = 100.0;
				} else {
					$matrix[$seg_name]['trend_pct'] = 0.0;
				}
			} elseif ($first_month_c > 0) {
				$matrix[$seg_name]['trend_pct'] = round((($last_month_c - $first_month_c) / $first_month_c) * 100, 1);
			} elseif ($last_month_c > 0) {
				$matrix[$seg_name]['trend_pct'] = 100.0;
			} else {
				$matrix[$seg_name]['trend_pct'] = 0.0;
			}
			$matrix[$seg_name]['trend_first_val'] = $first_month_c;
			$matrix[$seg_name]['trend_last_val'] = $last_month_c;
			$matrix[$seg_name]['trend_first_ym'] = $first_ym;
			$matrix[$seg_name]['trend_last_ym'] = $last_ym;
		}

		// Calculate MoM growth for Totals row
		$totals_growth = [];
		$totals_display_zero = [];
		$prev_total = null;
		$last_non_zero_t = null;
		$grand_total = ($mode === 'monthly') 
			? array_sum($totals_per_month) 
			: ($latest_active_ym ? ($totals_per_month[$latest_active_ym] ?? count($unique_phones)) : count($unique_phones));

		foreach ($months as $ym => $label) {
			$t = $totals_per_month[$ym];
			$g = null;
			$display_zero_t = false;

			if ($first_active_ym && $latest_active_ym && $ym >= $first_active_ym && $ym <= $latest_active_ym) {
				if ($t > 0) {
					if ($last_non_zero_t === null) {
						$g = 100.0; // Basis awal 100%
					} elseif ($prev_total > 0) {
						$g = round((($t - $prev_total) / $prev_total) * 100, 1);
					} else {
						$g = round((($t - $last_non_zero_t) / $last_non_zero_t) * 100, 1);
					}
					$last_non_zero_t = $t;
				} else {
					if ($last_non_zero_t !== null) {
						$display_zero_t = true;
						if ($prev_total > 0) {
							$g = -100.0;
						} else {
							$g = 0.0;
						}
					}
				}
			}

			$totals_growth[$ym] = $g;
			$totals_display_zero[$ym] = $display_zero_t;
			$prev_total = $t;
		}

		// Net Pertumbuhan (Awal vs Akhir)
		$active_keys = array_keys(array_filter($totals_per_month, function($v) { return $v > 0; }));
		$net_growth_pct = 0.0;
		if (!empty($active_keys)) {
			$first_ym = $active_keys[0];
			$last_ym = end($active_keys);
			$first_t = $totals_per_month[$first_ym];
			$last_t = $totals_per_month[$last_ym];
			if ($first_t > 0) {
				$net_growth_pct = round((($last_t - $first_t) / $first_t) * 100, 1);
			}
		}

		// Find overall top segment
		$top_segment_name = '-';
		$top_segment_count = 0;
		foreach ($matrix as $s_name => $s_data) {
			if ($s_data['total_cust'] > $top_segment_count) {
				$top_segment_count = $s_data['total_cust'];
				$top_segment_name = $s_name;
			}
		}

		$period_active_customers = null;
		$period_omset = null;
		$period_top_segment_name = null;
		$period_top_segment_count = 0;
		$period_mom_growth = null;

		if (!empty($period_filter) && isset($totals_per_month[$period_filter])) {
			$period_active_customers = $totals_per_month[$period_filter];
			if (isset($customer_monthly_stats[$period_filter])) {
				$p_sum = 0.0;
				foreach ($customer_monthly_stats[$period_filter] as $c_stat) {
					$p_sum += (float)($c_stat['spend'] ?? 0);
				}
				$period_omset = $p_sum;
			}
			// Find dominant segment for this specific period
			foreach ($matrix as $s_name => $s_data) {
				$c_cnt = $s_data['counts'][$period_filter] ?? 0;
				if ($c_cnt > $period_top_segment_count) {
					$period_top_segment_count = $c_cnt;
					$period_top_segment_name = $s_name;
				}
			}
			$period_mom_growth = $totals_growth[$period_filter] ?? null;
		}

		$display_name = $prod_row ? $prod_row->nama_produk : (!empty($category) ? "Semua Produk ({$category})" : "Semua Produk (Keseluruhan)");
		$product_code = $prod_row ? $prod_row->kode_produk : 'ALL';
		$product_id = $prod_row ? $prod_row->id : '';

		return [
			'product'               => $prod_row ? $prod_row->nama_produk : '',
			'product_name'          => $display_name,
			'product_id'            => $product_id,
			'product_code'          => $product_code,
			'active_customers_count'=> count($unique_phones),
			'accumulated_omset'     => $total_omset,
			'net_growth_pct'        => $net_growth_pct,
			'top_segment_name'      => $top_segment_name,
			'top_segment_count'     => $top_segment_count,
			'period_filter'         => $period_filter,
			'period_active_customers' => $period_active_customers,
			'period_omset'          => $period_omset,
			'period_top_segment_name' => $period_top_segment_name,
			'period_top_segment_count' => $period_top_segment_count,
			'period_mom_growth'     => $period_mom_growth,
			'months'                => $months,
			'matrix'                => $matrix,
			'totals_row'            => ['counts' => $totals_per_month, 'grand_total' => $grand_total, 'display_zero' => $totals_display_zero],
			'mom_row'               => ['growth' => $totals_growth, 'net_growth' => $net_growth_pct],
			'max_cell_val'          => $max_cell_val,
			'mode'                  => $mode,
		];
	}

	/**
	 * Drilldown Customers for a specific Product, Segment, and Month from real database records
	 */
	public function get_drilldown_customers($product, $segment, $period, $category = null, $mode = 'cumulative')
	{
		$prod_row = null;
		if (!empty($product) && $product !== 'all') {
			$prod_row = $this->resolve_product($product, $category);
		}

		$ym_esc = $this->db->escape_str($period);
		$ref_date = date('Y-m-t 23:59:59', strtotime($period . '-01'));
		if ($ref_date > date('Y-m-d H:i:s')) {
			$ref_date = date('Y-m-d H:i:s');
		}

		$cat_join_so = "";
		$cat_join_pm = "";
		$item_filter_so = "";
		$item_filter_pm = "";

		if ($prod_row) {
			$pid = (int)$prod_row->id;
			$clean_pname = trim(preg_replace('/\s*\([^)]*\)$/', '', $prod_row->nama_produk));
			$clean_pname_esc = $this->db->escape($clean_pname);
			$like_pname = $this->db->escape_like_str($clean_pname);

			$id_match_so = ($pid > 1) ? "(p.id > 1 AND p.nama_produk = {$clean_pname_esc}) OR soi.produk_id = {$pid} OR " : "";
			$id_match_pm = ($pid > 1) ? "(p.id > 1 AND p.nama_produk = {$clean_pname_esc}) OR pmi.produk_id = {$pid} OR " : "";

			$item_filter_so = "AND ({$id_match_so} TRIM(REGEXP_REPLACE(soi.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pname_esc} OR soi.catatan LIKE '{$like_pname}%')";
			$item_filter_pm = "AND ({$id_match_pm} TRIM(REGEXP_REPLACE(pmi.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pname_esc} OR pmi.catatan LIKE '{$like_pname}%')";
		} elseif (!empty($category)) {
			$c_esc = $this->db->escape(trim($category));
			$cat_join_so = "LEFT JOIN kategori_produk kp ON p.kategori_id = kp.id";
			$cat_join_pm = "LEFT JOIN kategori_produk kp ON p.kategori_id = kp.id";
			$item_filter_so = "AND (kp.nama_kategori = {$c_esc} OR kp.id = {$c_esc} OR p.kategori_id = {$c_esc})";
			$item_filter_pm = "AND (kp.nama_kategori = {$c_esc} OR kp.id = {$c_esc} OR p.kategori_id = {$c_esc})";
		}

		$having_clause = ($mode === 'monthly') ? "HAVING period_orders > 0" : "HAVING total_orders > 0";
		$order_clause = ($mode === 'monthly') ? "ORDER BY period_spend DESC, total_spend DESC" : "ORDER BY total_spend DESC, period_spend DESC";

		$sql = "
			SELECT 
				RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(t.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10) as clean_phone,
				MAX(t.no_telepon) as no_telepon,
				MAX(t.customer_name) as customer_name,
				MAX(t.tanggal_so) as last_order_date,
				MIN(DATE_FORMAT(t.tanggal_so, '%Y-%m')) as first_ym,
				MAX(DATE_FORMAT(t.tanggal_so, '%Y-%m')) as last_ym,
				COUNT(DISTINCT t.order_id) as total_orders,
				SUM(t.qty) as total_qty,
				SUM(t.subtotal) as total_spend,
				SUM(CASE WHEN DATE_FORMAT(t.tanggal_so, '%Y-%m') = '{$ym_esc}' THEN t.subtotal ELSE 0 END) as period_spend,
				COUNT(DISTINCT CASE WHEN DATE_FORMAT(t.tanggal_so, '%Y-%m') = '{$ym_esc}' THEN t.order_id ELSE NULL END) as period_orders
			FROM (
				SELECT 
					so.no_telepon, 
					COALESCE(NULLIF(TRIM(so.nama_penerima), ''), pel.nama_pelanggan, NULLIF(TRIM(so.username_pembeli), ''), 'Customer SO') as customer_name,
					so.tanggal_so, 
					soi.qty, 
					COALESCE(soi.subtotal, soi.qty * soi.harga_satuan, 0) as subtotal, 
					CONCAT('so_', so.id) as order_id
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN pelanggan pel ON so.pelanggan_id = pel.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				{$cat_join_so}
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
				  AND DATE_FORMAT(so.tanggal_so, '%Y-%m') <= '{$ym_esc}'
				  AND so.tanggal_so > '1970-01-01'
				  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))
				  {$item_filter_so}

				UNION ALL

				SELECT 
					pm.no_telepon, 
					COALESCE(NULLIF(TRIM(pm.nama_penerima), ''), pel2.nama_pelanggan, NULLIF(TRIM(pm.username_pembeli), ''), 'Customer Marketplace') as customer_name,
					pm.tanggal_so, 
					pmi.qty, 
					COALESCE(pmi.subtotal, pmi.qty * pmi.harga_satuan, 0) as subtotal, 
					CONCAT('pm_', pm.id) as order_id
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN pelanggan pel2 ON pm.pelanggan_id = pel2.id
				LEFT JOIN produk p ON pmi.produk_id = p.id
				{$cat_join_pm}
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND DATE_FORMAT(pm.tanggal_so, '%Y-%m') <= '{$ym_esc}'
				  AND pm.tanggal_so > '1970-01-01'
				  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
				  {$item_filter_pm}
			) t
			GROUP BY clean_phone
			{$having_clause}
			{$order_clause}
		";

		$customers = $this->db->query($sql)->result();

		// Retrieve all chronological months in database for lifecycle index calculation
		$all_months_query = $this->db->query("
			SELECT DISTINCT DATE_FORMAT(tanggal_so, '%Y-%m') as ym
			FROM (
				SELECT tanggal_so FROM sales_order WHERE tanggal_so > '1970-01-01'
				UNION ALL
				SELECT tanggal_so FROM penjualan_marketplace WHERE tanggal_so > '1970-01-01'
			) t ORDER BY ym ASC
		")->result();
		$all_system_months = !empty($all_months_query) ? array_column($all_months_query, 'ym') : [$period];
		$period_idx = array_search($period, $all_system_months);
		if ($period_idx === false) $period_idx = 0;

		$prod_name = $prod_row ? $prod_row->nama_produk : '';
		$thresholds = $this->model_crm->get_rfm_percentile_thresholds($prod_name, '', $category);
		$p80_spend = $thresholds['m'][80] ?? 1000000;

		$filtered_customers = [];
		foreach ($customers as $c) {
			$is_active_now = ((int)$c->period_orders > 0);
			$order_count = (int)$c->total_orders;
			$total_spend = (float)$c->total_spend;

			if ($is_active_now) {
				if ($c->first_ym === $period && $order_count === 1) {
					$c->rfm_segment = ($total_spend >= $p80_spend) ? 'Big Spenders' : 'New Customers';
				} else {
					if ($order_count >= 3 && $total_spend >= $p80_spend) {
						$c->rfm_segment = 'Champions';
					} elseif ($total_spend >= $p80_spend) {
						$c->rfm_segment = 'Big Spenders';
					} elseif ($order_count >= 2) {
						$c->rfm_segment = 'Loyal Customers';
					} else {
						$c->rfm_segment = 'Potential Loyalist';
					}
				}
			} else {
				$y_curr = (int)substr($period, 0, 4);
				$m_curr = (int)substr($period, 5, 2);
				$y_last = (int)substr($c->last_ym, 0, 4);
				$m_last = (int)substr($c->last_ym, 5, 2);
				$idle_months = ($y_curr - $y_last) * 12 + ($m_curr - $m_last);

				if ($idle_months <= 1) {
					$c->rfm_segment = 'Need Attention';
				} elseif ($idle_months == 2) {
					$c->rfm_segment = ($total_spend >= $p80_spend) ? "Can't Lose Them" : 'At Risk Customers';
				} else {
					$c->rfm_segment = 'Hibernating';
				}
			}

			// If specific segment requested (and not 'Total' / 'All'), filter by segment
			if (!empty($segment) && strtolower($segment) !== 'total' && strtolower($segment) !== 'all') {
				if (stripos($c->rfm_segment, $segment) === false && stripos($segment, $c->rfm_segment) === false) {
					continue;
				}
			}

			$raw_phone = !empty($c->no_telepon) ? $c->no_telepon : ('08' . $c->clean_phone);
			$c->clean_phone = preg_replace('/[^0-9]/', '', $raw_phone);
			if (substr($c->clean_phone, 0, 1) === '0') {
				$wa_phone = '62' . substr($c->clean_phone, 1);
			} elseif (substr($c->clean_phone, 0, 2) === '62') {
				$wa_phone = $c->clean_phone;
			} else {
				$wa_phone = '62' . $c->clean_phone;
			}

			$greet_item = $prod_row ? ("pembelian " . $prod_row->nama_produk) : "berbelanja";
			$msg = urlencode("Halo Kak " . $c->customer_name . ", terima kasih telah {$greet_item} di toko kami. Apakah produknya sudah diterima dengan baik?");
			$c->wa_link = "https://wa.me/{$wa_phone}?text={$msg}";
			$c->crm_link = site_url('administrator/crm/customer_detail?phone=' . urlencode($raw_phone));
			$c->recency_days = max(0, (int)round((strtotime($ref_date) - strtotime($c->last_order_date)) / 86400));
			$c->total_qty = (float)$c->total_qty;
			$c->total_spend = (float)$c->total_spend;

			$filtered_customers[] = $c;
		}

		return $filtered_customers;
	}

	/**
	 * Empty matrix fallback
	 */
	private function _get_empty_matrix()
	{
		$months = [
			'2025-12' => "DES '25", '2026-01' => "JAN '26", '2026-02' => "FEB '26",
			'2026-03' => "MAR '26", '2026-04' => "APR '26", '2026-05' => "MEI '26",
			'2026-06' => "JUN '26", '2026-07' => "JUL '26", '2026-08' => "AGS '26",
			'2026-09' => "SEP '26", '2026-10' => "OKT '26"
		];
		$standard_segments = $this->get_standard_segments();
		$matrix = [];
		foreach ($standard_segments as $seg_name => $meta) {
			$matrix[$seg_name] = [
				'name'       => $seg_name,
				'icon'       => $meta['icon'],
				'fa_icon'    => $meta['fa_icon'],
				'color'      => $meta['color'],
				'counts'     => array_fill_keys(array_keys($months), 0),
				'growth'     => [],
				'total_cust' => 0,
				'trend_pct'  => 0.0,
			];
		}
		return [
			'product'               => '-',
			'product_name'          => '-',
			'product_id'            => 0,
			'product_code'          => '-',
			'active_customers_count'=> 0,
			'accumulated_omset'     => 0,
			'net_growth_pct'        => 0.0,
			'months'                => $months,
			'matrix'                => $matrix,
			'totals_row'            => ['counts' => array_fill_keys(array_keys($months), 0), 'grand_total' => 0],
			'mom_row'               => ['growth' => array_fill_keys(array_keys($months), null), 'net_growth' => 0.0],
			'max_cell_val'          => 1,
		];
	}
}
