<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_crm extends CI_Model
{
	/**
	 * Get consolidated customer list from sales_order + penjualan_marketplace
	 * Grouped by phone number (primary key for customer identity)
	 */
	private function get_query_count($sql, $params = [])
	{
		$row = $this->db->query($sql, $params)->row();
		return $row ? (int)($row->cnt ?? 0) : 0;
	}

	private function get_query_sum($sql, $params = [])
	{
		$row = $this->db->query($sql, $params)->row();
		return $row ? (float)($row->t ?? 0) : 0;
	}

	/**
	 * Get consolidated customer list from sales_order + penjualan_marketplace
	 * Grouped by phone number (primary key for customer identity)
	 */
	public function get_customers($filter = '', $limit = 25, $offset = 0)
	{
		$sql = "SELECT 
			customer_phone,
			customer_nama,
			COUNT(DISTINCT CONCAT(order_table, '-', order_id)) as total_orders,
			GROUP_CONCAT(DISTINCT order_source SEPARATOR ', ') as sumber_penjualan,
			MAX(tanggal_pengiriman) as last_order_date,
			SUM(CASE WHEN status_label = 'Pending' THEN 1 ELSE 0 END) as pending_followups
		FROM crm_transaction_followup_labels
		WHERE customer_phone IS NOT NULL AND customer_phone != ''";

		if (!empty($filter)) {
			$filter = $this->db->escape_like_str($filter);
			$sql .= " AND (customer_nama LIKE '%{$filter}%' OR customer_phone LIKE '%{$filter}%')";
		}

		$sql .= " GROUP BY customer_phone, customer_nama ORDER BY last_order_date DESC";
		
		$count_sql = "SELECT COUNT(*) as cnt FROM ({$sql}) as sub";
		$count = $this->get_query_count($count_sql);

		$sql .= " LIMIT {$limit} OFFSET {$offset}";
		$rows = $this->db->query($sql)->result();

		return ['rows' => $rows, 'total' => $count];
	}

	/**
	 * Get customer summary stats (FA-04)
	 */
	public function get_customer_summary($phone)
	{
		$phone = $this->db->escape_str($phone);

		// Get total spend from SO
		$so_spend = $this->get_query_sum("SELECT COALESCE(SUM(total),0) as t FROM sales_order WHERE no_telepon = ?", [$phone]);
		
		// Get total spend from marketplace
		$mp_spend = $this->get_query_sum("SELECT COALESCE(SUM(total),0) as t FROM penjualan_marketplace WHERE no_telepon = ?", [$phone]);

		// Get order counts
		$so_count = $this->get_query_count("SELECT COUNT(*) as cnt FROM sales_order WHERE no_telepon = ?", [$phone]);
		$mp_count = $this->get_query_count("SELECT COUNT(*) as cnt FROM penjualan_marketplace WHERE no_telepon = ?", [$phone]);

		// Get sources breakdown
		$sources = $this->db->query("SELECT DISTINCT order_source FROM crm_transaction_followup_labels WHERE customer_phone = ?", [$phone])->result();
		$source_list = array_map(function($s) { return $s->order_source; }, $sources);

		// Get first and last order dates
		$dates = $this->db->query("SELECT 
			MIN(tanggal_pengiriman) as first_order, 
			MAX(tanggal_pengiriman) as last_order 
			FROM crm_transaction_followup_labels WHERE customer_phone = ?", [$phone])->row();

		// Customer name
		$name_row = $this->db->query("SELECT customer_nama FROM crm_transaction_followup_labels WHERE customer_phone = ? ORDER BY id DESC LIMIT 1", [$phone])->row();

		return [
			'nama' => $name_row ? $name_row->customer_nama : '-',
			'phone' => $phone,
			'total_spend_toko' => (float)$so_spend,
			'total_spend_online' => (float)$mp_spend,
			'total_spend' => (float)$so_spend + (float)$mp_spend,
			'order_count_toko' => (int)$so_count,
			'order_count_online' => (int)$mp_count,
			'total_orders' => (int)$so_count + (int)$mp_count,
			'sources' => $source_list,
			'first_order' => $dates ? $dates->first_order : null,
			'last_order' => $dates ? $dates->last_order : null,
		];
	}

	/**
	 * Get transaction history for a customer (FA-01, FA-02)
	 * UNION of sales_order + penjualan_marketplace
	 */
	public function get_customer_transactions($phone)
	{
		$phone = $this->db->escape_str($phone);

		$sql = "
			(SELECT 
				'sales_order' as tbl, so.id, so.nomor_so, so.no_pesanan, so.tanggal_so as tanggal,
				COALESCE(so.tanggal_kirim, so.tanggal_so) as tanggal_kirim,
				'Toko' as sumber_penjualan,
				so.status, so.status_pesanan, so.nomor_resi, so.kurir_ekspedisi,
				so.nama_penerima, so.no_telepon, so.alamat_pengiriman,
				so.total, 
				COALESCE(
					NULLIF(so.nama_produk_marketplace, ''),
					(SELECT COALESCE(NULLIF(soi.catatan, ''), p.nama_produk) FROM sales_order_item soi LEFT JOIN produk p ON soi.produk_id = p.id WHERE soi.so_id = so.id ORDER BY soi.id ASC LIMIT 1),
					'Produk SO'
				) as produk_ringkasan
			FROM sales_order so 
			WHERE so.no_telepon = '{$phone}')
			UNION ALL
			(SELECT 
				'penjualan_marketplace' as tbl, pm.id, pm.nomor_so, pm.no_pesanan, pm.tanggal_so as tanggal,
				pm.tanggal_so as tanggal_kirim,
				CASE 
					WHEN LOWER(pm.source) LIKE '%tokopedia%' THEN 'Tokopedia'
					WHEN LOWER(pm.source) LIKE '%tiktok%' THEN 'TikTok Shop'
					ELSE 'Shopee'
				END as sumber_penjualan,
				pm.status, pm.status_pesanan, pm.nomor_resi, pm.kurir_ekspedisi,
				pm.nama_penerima, pm.no_telepon, pm.alamat_pengiriman,
				pm.total, 
				COALESCE(
					NULLIF(pm.nama_produk_marketplace, ''),
					(SELECT COALESCE(NULLIF(pmi.catatan, ''), p.nama_produk) FROM penjualan_marketplace_item pmi LEFT JOIN produk p ON pmi.produk_id = p.id WHERE pmi.penjualan_marketplace_id = pm.id ORDER BY pmi.id ASC LIMIT 1),
					'Produk Marketplace'
				) as produk_ringkasan
			FROM penjualan_marketplace pm 
			WHERE pm.no_telepon = '{$phone}')
			ORDER BY tanggal DESC";

		return $this->db->query($sql)->result();
	}

	/**
	 * Get transaction items (FA-03)
	 */
	public function get_transaction_items($table, $order_id)
	{
		if ($table === 'sales_order') {
			return $this->db->query("SELECT soi.*, 
				COALESCE(NULLIF(soi.catatan, ''), p.nama_produk, 'Produk SO') as nama_produk, 
				p.kode_produk 
				FROM sales_order_item soi 
				LEFT JOIN produk p ON soi.produk_id = p.id 
				WHERE soi.so_id = ?", [$order_id])->result();
		} else {
			return $this->db->query("SELECT pmi.*, 
				COALESCE(NULLIF(pmi.catatan, ''), p.nama_produk, 'Produk Marketplace') as nama_produk, 
				p.kode_produk 
				FROM penjualan_marketplace_item pmi 
				LEFT JOIN produk p ON pmi.produk_id = p.id 
				WHERE pmi.penjualan_marketplace_id = ?", [$order_id])->result();
		}
	}

	/**
	 * Get follow-up labels for a specific transaction (FA-05 timeline)
	 */
	public function get_transaction_followup_timeline($table, $order_id)
	{
		return $this->db->query("
			SELECT tfl.*, fc.nama_kategori, fc.kode_kategori, fc.jumlah_hari,
				(SELECT GROUP_CONCAT(fn.catatan SEPARATOR ' | ') FROM crm_followup_notes fn WHERE fn.followup_label_id = tfl.id) as notes,
				(SELECT COUNT(*) FROM crm_broadcast_logs bl WHERE bl.followup_label_id = tfl.id) as broadcast_count
			FROM crm_transaction_followup_labels tfl
			JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
			WHERE tfl.order_table = ? AND tfl.order_id = ?
			ORDER BY fc.jumlah_hari ASC", [$table, $order_id])->result();
	}

	// ===== JOURNAL FOLLOW-UP (Modul B) =====

	/**
	 * Get follow-up journal entries with filters (FB-03)
	 */
	public function get_journal_entries($filters = [], $limit = 25, $offset = 0)
	{
		$this->db->select('tfl.*, fc.nama_kategori, fc.kode_kategori, fc.jumlah_hari');
		$this->db->from('crm_transaction_followup_labels tfl');
		$this->db->join('crm_followup_categories fc', 'tfl.followup_category_id = fc.id');

		if (!empty($filters['category_id'])) {
			$this->db->where('tfl.followup_category_id', $filters['category_id']);
		}
		if (!empty($filters['order_source'])) {
			$this->db->where('tfl.order_source', $filters['order_source']);
		}
		if (!empty($filters['status_label'])) {
			$this->db->where('tfl.status_label', $filters['status_label']);
		}
		if (!empty($filters['date_from'])) {
			$this->db->where('tfl.tanggal_pengiriman >=', $filters['date_from']);
		}
		if (!empty($filters['date_to'])) {
			$this->db->where('tfl.tanggal_pengiriman <=', $filters['date_to']);
		}
		if (!empty($filters['search'])) {
			$this->db->group_start();
			$this->db->like('tfl.customer_nama', $filters['search']);
			$this->db->or_like('tfl.customer_phone', $filters['search']);
			$this->db->or_like('tfl.no_pesanan', $filters['search']);
			$this->db->group_end();
		}
		// Only show labels whose target date has arrived
		if (empty($filters['show_future'])) {
			$this->db->where('tfl.tanggal_label_muncul <=', date('Y-m-d'));
		}

		$count = $this->db->count_all_results('', false);

		$this->db->order_by('tfl.tanggal_label_muncul', 'DESC');
		$this->db->limit($limit, $offset);
		$rows = $this->db->get()->result();

		return ['rows' => $rows, 'total' => $count];
	}

	/**
	 * Get all active follow-up categories
	 */
	public function get_categories($active_only = true)
	{
		$this->db->order_by('urutan', 'ASC');
		if ($active_only) $this->db->where('is_active', 1);
		return $this->db->get('crm_followup_categories')->result();
	}

	public function get_category($id)
	{
		return $this->db->get_where('crm_followup_categories', ['id' => $id])->row();
	}

	public function save_category($data, $id = null)
	{
		if ($id) {
			$data['updated_at'] = date('Y-m-d H:i:s');
			return $this->db->where('id', $id)->update('crm_followup_categories', $data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			return $this->db->insert('crm_followup_categories', $data);
		}
	}

	public function delete_category($id)
	{
		// Check if labels exist using this category
		$count = $this->db->where('followup_category_id', $id)->count_all_results('crm_transaction_followup_labels');
		if ($count > 0) {
			return false; // Cannot delete if labels exist
		}
		return $this->db->delete('crm_followup_categories', ['id' => $id]);
	}

	/**
	 * Update follow-up label status (FB-07)
	 */
	public function update_label_status($label_id, $status, $handled_by = null)
	{
		$data = [
			'status_label' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
		];
		if ($handled_by) $data['handled_by'] = $handled_by;
		return $this->db->where('id', $label_id)->update('crm_transaction_followup_labels', $data);
	}

	/**
	 * Add follow-up note (FB-07)
	 */
	public function add_note($label_id, $catatan, $status_manual = null)
	{
		return $this->db->insert('crm_followup_notes', [
			'followup_label_id' => $label_id,
			'username' => get_user_data('username') ?: 'system',
			'catatan' => $catatan,
			'status_manual' => $status_manual,
			'created_at' => date('Y-m-d H:i:s'),
		]);
	}

	public function get_notes($label_id)
	{
		return $this->db->where('followup_label_id', $label_id)->order_by('created_at', 'DESC')->get('crm_followup_notes')->result();
	}

	/**
	 * Render WA template with variables (FB-05)
	 */
	public function render_template($template, $label)
	{
		// Get product info
		$produk = '-';
		if ($label->order_table === 'sales_order') {
			$items = $this->db->query("SELECT COALESCE(p.nama_produk, soi.catatan) as nama FROM sales_order_item soi LEFT JOIN produk p ON soi.produk_id = p.id WHERE soi.so_id = ? LIMIT 3", [$label->order_id])->result();
		} else {
			$items = $this->db->query("SELECT COALESCE(p.nama_produk, pmi.catatan) as nama FROM penjualan_marketplace_item pmi LEFT JOIN produk p ON pmi.produk_id = p.id WHERE pmi.penjualan_marketplace_id = ? LIMIT 3", [$label->order_id])->result();
		}
		if (!empty($items)) {
			$produk = implode(', ', array_map(function($i) { return $i->nama; }, $items));
		}

		// Get kurir info
		$kurir = '-';
		if ($label->order_table === 'sales_order') {
			$order = $this->db->get_where('sales_order', ['id' => $label->order_id])->row();
		} else {
			$order = $this->db->get_where('penjualan_marketplace', ['id' => $label->order_id])->row();
		}
		if ($order) {
			$kurir = $order->kurir_ekspedisi ?: ($order->opsi_pengiriman ?? '-');
		}

		$vars = [
			'{{nama_customer}}' => $label->customer_nama ?: '-',
			'{{no_pesanan}}' => $label->no_pesanan ?: '-',
			'{{nomor_resi}}' => $label->nomor_resi ?: '-',
			'{{sumber_penjualan}}' => $label->order_source ?: '-',
			'{{produk}}' => $produk,
			'{{tanggal_kirim}}' => $label->tanggal_pengiriman ? date('d/m/Y', strtotime($label->tanggal_pengiriman)) : '-',
			'{{kurir}}' => $kurir,
		];

		return str_replace(array_keys($vars), array_values($vars), $template);
	}

	/**
	 * Generate WA direct link
	 */
	public function generate_wa_link($phone, $message)
	{
		// Normalize phone: 08xx → 628xx
		$phone = preg_replace('/^0/', '62', $phone);
		$phone = preg_replace('/[^0-9]/', '', $phone);
		if (substr($phone, 0, 2) !== '62') $phone = '62' . $phone;
		return 'https://wa.me/' . $phone . '?text=' . rawurlencode($message);
	}

	/**
	 * Log broadcast (FB-06)
	 */
	public function log_broadcast($label_id, $pesan_final, $metode = 'wa_direct_link')
	{
		$this->db->insert('crm_broadcast_logs', [
			'followup_label_id' => $label_id,
			'dikirim_oleh' => get_user_data('username') ?: 'system',
			'isi_pesan_final' => $pesan_final,
			'waktu_kirim' => date('Y-m-d H:i:s'),
			'status_kirim' => 'Terkirim',
			'metode_kirim' => $metode,
		]);
		// Mark as broadcast sent (FB-10: prevent duplicate)
		$this->db->where('id', $label_id)->update('crm_transaction_followup_labels', [
			'is_broadcast_sent' => 1,
			'status_label' => 'Sudah Dikirim',
			'handled_by' => get_user_data('username') ?: 'system',
		]);
	}

	/**
	 * Get WA Gateway Configuration
	 */
	public function get_wa_gateway_config()
	{
		$row = $this->db->get('crm_wa_gateway_config')->row();
		if (!$row) {
			return (object)[
				'provider' => 'fonnte',
				'mode' => 'wa_direct',
				'api_key' => '',
				'api_url' => 'https://api.fonnte.com/send',
				'sender_phone' => '',
				'additional_headers' => '',
				'is_active' => 1
			];
		}
		return $row;
	}

	public function save_wa_gateway_config($data)
	{
		$row = $this->db->get('crm_wa_gateway_config')->row();
		if ($row) {
			$data['updated_at'] = date('Y-m-d H:i:s');
			return $this->db->where('id', $row->id)->update('crm_wa_gateway_config', $data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			return $this->db->insert('crm_wa_gateway_config', $data);
		}
	}

	/**
	 * Send WhatsApp message directly via Gateway API (cURL)
	 */
	public function send_wa_via_api($phone, $message)
	{
		$config = $this->get_wa_gateway_config();

		// Normalize phone: 08xx -> 628xx
		$phone = preg_replace('/^0/', '62', $phone);
		$phone = preg_replace('/[^0-9]/', '', $phone);
		if (substr($phone, 0, 2) !== '62') $phone = '62' . $phone;

		$provider = strtolower($config->provider ?: 'fonnte');
		$api_key = trim($config->api_key ?: '');
		$api_url = trim($config->api_url ?: 'https://api.fonnte.com/send');

		if (empty($api_key) && in_array($provider, ['fonnte', 'wablas', 'starsender'])) {
			return [
				'success' => false,
				'message' => 'API Key WhatsApp Gateway belum dikonfigurasi di sistem.',
			];
		}

		$ch = curl_init();
		$headers = [];
		$post_data = [];

		if ($provider === 'fonnte') {
			$headers[] = 'Authorization: ' . $api_key;
			$post_data = [
				'target' => $phone,
				'message' => $message,
			];
			curl_setopt($ch, CURLOPT_URL, $api_url ?: 'https://api.fonnte.com/send');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
		} elseif ($provider === 'wablas') {
			$headers[] = 'Authorization: ' . $api_key;
			$headers[] = 'Content-Type: application/json';
			$payload = [
				'data' => [
					['phone' => $phone, 'message' => $message]
				]
			];
			curl_setopt($ch, CURLOPT_URL, $api_url ?: 'https://api.wablas.com/api/v2/send-message');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		} elseif ($provider === 'waha') {
			$headers[] = 'Content-Type: application/json';
			if (!empty($api_key)) {
				$headers[] = 'x-api-key: ' . $api_key;
			}
			$payload = [
				'chatId' => $phone . '@c.us',
				'text' => $message
			];
			$url = rtrim($api_url ?: 'http://localhost:3000', '/') . '/api/sendText';
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		} elseif ($provider === 'starsender') {
			$headers[] = 'apikey: ' . $api_key;
			$post_data = [
				'message' => $message,
				'tujuan' => $phone
			];
			curl_setopt($ch, CURLOPT_URL, $api_url ?: 'https://api.starsender.online/api/sendText');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
		} else { // custom cURL
			$headers[] = 'Authorization: Bearer ' . $api_key;
			$headers[] = 'Content-Type: application/json';

			if (!empty($config->additional_headers)) {
				$extra_lines = explode("\n", $config->additional_headers);
				foreach ($extra_lines as $el) {
					$el = trim($el);
					if (!empty($el)) $headers[] = $el;
				}
			}

			$payload = [
				'phone' => $phone,
				'target' => $phone,
				'message' => $message,
				'text' => $message
			];
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		}

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);

		$response = curl_exec($ch);
		$err = curl_error($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($err) {
			return [
				'success' => false,
				'message' => 'cURL Error: ' . $err,
				'http_code' => $http_code
			];
		}

		$res_json = json_decode($response, true);
		$is_ok = ($http_code >= 200 && $http_code < 300);

		return [
			'success' => $is_ok,
			'message' => $is_ok ? 'Pesan WA berhasil dikirim via API' : ('API Error (HTTP ' . $http_code . ')'),
			'response' => $res_json ?: $response,
			'http_code' => $http_code
		];
	}

	public function get_broadcast_logs($filters = [], $limit = 25, $offset = 0)
	{
		$this->db->select('bl.*, tfl.customer_nama, tfl.customer_phone, tfl.no_pesanan, tfl.order_source, fc.nama_kategori');
		$this->db->from('crm_broadcast_logs bl');
		$this->db->join('crm_transaction_followup_labels tfl', 'bl.followup_label_id = tfl.id');
		$this->db->join('crm_followup_categories fc', 'tfl.followup_category_id = fc.id');
		$this->db->order_by('bl.waktu_kirim', 'DESC');
		$this->db->limit($limit, $offset);
		return $this->db->get()->result();
	}

	/**
	 * CRON: Generate follow-up labels for new shipped orders (FB-01)
	 */
	public function generate_labels_for_new_orders()
	{
		$categories = $this->get_categories(true);
		$generated = 0;

		// Process sales_order
		$so_rows = $this->db->query("SELECT so.*, p.nama_pelanggan, p.telepon, p.no_telp 
			FROM sales_order so LEFT JOIN pelanggan p ON so.pelanggan_id = p.id 
			WHERE so.status NOT IN ('cancelled','dibatalkan')")->result();

		foreach ($so_rows as $so) {
			$ship_date = $so->tanggal_kirim ?: ($so->tanggal_so ?: substr($so->created_at, 0, 10));
			$phone = $so->no_telepon ?: ($so->telepon ?: ($so->no_telp ?: ''));
			$nama = $so->nama_penerima ?: ($so->nama_pelanggan ?: '-');

			foreach ($categories as $cat) {
				$target = date('Y-m-d', strtotime($ship_date . ' + ' . $cat->jumlah_hari . ' days'));
				$exists = $this->db->where(['order_table' => 'sales_order', 'order_id' => $so->id, 'followup_category_id' => $cat->id])
					->count_all_results('crm_transaction_followup_labels');
				if ($exists == 0) {
					$this->db->insert('crm_transaction_followup_labels', [
						'order_source' => 'Toko',
						'order_id' => $so->id,
						'order_table' => 'sales_order',
						'customer_nama' => $nama,
						'customer_phone' => $phone,
						'customer_pelanggan_id' => $so->pelanggan_id,
						'no_pesanan' => $so->no_pesanan ?: $so->nomor_so,
						'nomor_resi' => $so->nomor_resi,
						'tanggal_pengiriman' => $ship_date,
						'followup_category_id' => $cat->id,
						'tanggal_label_muncul' => $target,
					]);
					$generated++;
				}
			}
		}

		// Process penjualan_marketplace
		$mp_rows = $this->db->query("SELECT * FROM penjualan_marketplace 
			WHERE status NOT IN ('cancelled','dibatalkan','returned','pengembalian')")->result();

		foreach ($mp_rows as $mp) {
			$ship_date = $mp->tanggal_so ?: substr($mp->created_at, 0, 10);
			$phone = $mp->no_telepon ?: '';
			$nama = $mp->nama_penerima ?: '-';
			$src = strtolower($mp->source ?: '');
			$source = 'Shopee';
			if (strpos($src, 'tokopedia') !== false) $source = 'Tokopedia';
			elseif (strpos($src, 'tiktok') !== false) $source = 'TikTok Shop';

			foreach ($categories as $cat) {
				$target = date('Y-m-d', strtotime($ship_date . ' + ' . $cat->jumlah_hari . ' days'));
				$exists = $this->db->where(['order_table' => 'penjualan_marketplace', 'order_id' => $mp->id, 'followup_category_id' => $cat->id])
					->count_all_results('crm_transaction_followup_labels');
				if ($exists == 0) {
					$this->db->insert('crm_transaction_followup_labels', [
						'order_source' => $source,
						'order_id' => $mp->id,
						'order_table' => 'penjualan_marketplace',
						'customer_nama' => $nama,
						'customer_phone' => $phone,
						'customer_pelanggan_id' => $mp->pelanggan_id,
						'no_pesanan' => $mp->no_pesanan ?: $mp->nomor_so,
						'nomor_resi' => $mp->nomor_resi,
						'tanggal_pengiriman' => $ship_date,
						'followup_category_id' => $cat->id,
						'tanggal_label_muncul' => $target,
					]);
					$generated++;
				}
			}
		}

		return $generated;
	}

	/**
	 * Get journal stats for badges
	 */
	public function get_journal_stats()
	{
		$today = date('Y-m-d');
		return [
			'total_pending' => $this->db->where(['status_label' => 'Pending', 'tanggal_label_muncul <=' => $today])->count_all_results('crm_transaction_followup_labels'),
			'overdue' => $this->db->where(['status_label' => 'Pending', 'tanggal_label_muncul <' => $today])->count_all_results('crm_transaction_followup_labels'),
			'today' => $this->db->where(['status_label' => 'Pending', 'tanggal_label_muncul' => $today])->count_all_results('crm_transaction_followup_labels'),
		];
	}

	public function get_label($id)
	{
		return $this->db->select('tfl.*, fc.nama_kategori, fc.kode_kategori, fc.template_pesan_default, fc.jumlah_hari')
			->from('crm_transaction_followup_labels tfl')
			->join('crm_followup_categories fc', 'tfl.followup_category_id = fc.id')
			->where('tfl.id', $id)
			->get()->row();
	}

	// ===== DASHBOARD CRM ANALYTICS (Fase 5) =====

	public function get_dashboard_kpis()
	{
		$today = date('Y-m-d');
		
		// Total customers
		$total_cust = $this->get_query_count("SELECT COUNT(DISTINCT customer_phone) as cnt FROM crm_transaction_followup_labels WHERE customer_phone IS NOT NULL AND customer_phone != ''");
		
		// Total spend
		$so_spend = $this->get_query_sum("SELECT COALESCE(SUM(total),0) as t FROM sales_order");
		$mp_spend = $this->get_query_sum("SELECT COALESCE(SUM(total),0) as t FROM penjualan_marketplace");
		$total_spend = (float)$so_spend + (float)$mp_spend;

		// Repeat order customers (more than 1 order)
		$repeat_cust = $this->get_query_count("SELECT COUNT(*) as cnt FROM (
			SELECT customer_phone FROM crm_transaction_followup_labels 
			WHERE customer_phone IS NOT NULL AND customer_phone != '' 
			GROUP BY customer_phone HAVING COUNT(DISTINCT CONCAT(order_table, '-', order_id)) > 1
		) sub");
		
		$repeat_rate = $total_cust > 0 ? round(($repeat_cust / $total_cust) * 100, 1) : 0;

		// Pending today & overdue
		$pending_today = $this->get_query_count("SELECT COUNT(*) as cnt FROM crm_transaction_followup_labels WHERE status_label = 'Pending' AND tanggal_label_muncul = ?", [$today]);
		$overdue = $this->get_query_count("SELECT COUNT(*) as cnt FROM crm_transaction_followup_labels WHERE status_label = 'Pending' AND tanggal_label_muncul < ?", [$today]);

		// Broadcast sent count
		$total_broadcast = $this->get_query_count("SELECT COUNT(*) as cnt FROM crm_broadcast_logs");

		return [
			'total_customers' => (int)$total_cust,
			'total_spend' => $total_spend,
			'repeat_customers' => (int)$repeat_cust,
			'repeat_rate' => $repeat_rate,
			'pending_today' => (int)$pending_today,
			'overdue' => (int)$overdue,
			'total_broadcast' => (int)$total_broadcast,
		];
	}

	public function get_channel_distribution()
	{
		$rows = $this->db->query("SELECT order_source, COUNT(DISTINCT CONCAT(order_table, '-', order_id)) as cnt 
			FROM crm_transaction_followup_labels 
			GROUP BY order_source")->result();

		$data = ['Toko' => 0, 'Shopee' => 0, 'Tokopedia' => 0, 'TikTok Shop' => 0];
		foreach ($rows as $r) {
			if (isset($data[$r->order_source])) {
				$data[$r->order_source] = (int)$r->cnt;
			}
		}
		return $data;
	}

	public function get_followup_trend_30days()
	{
		$dates = [];
		$broadcast_counts = [];
		$labels_counts = [];

		for ($i = 14; $i >= 0; $i--) {
			$d = date('Y-m-d', strtotime("-$i days"));
			$dates[] = date('d M', strtotime($d));
			
			$bc = $this->get_query_count("SELECT COUNT(*) as cnt FROM crm_broadcast_logs WHERE DATE(waktu_kirim) = ?", [$d]);
			$lbl = $this->get_query_count("SELECT COUNT(*) as cnt FROM crm_transaction_followup_labels WHERE tanggal_label_muncul = ?", [$d]);
			
			$broadcast_counts[] = (int)$bc;
			$labels_counts[] = (int)$lbl;
		}

		return [
			'dates' => $dates,
			'broadcast' => $broadcast_counts,
			'labels' => $labels_counts,
		];
	}

	public function get_category_status_breakdown()
	{
		$cats = $this->get_categories(true);
		$result = [];

		foreach ($cats as $c) {
			$pending = $this->get_query_count("SELECT COUNT(*) as cnt FROM crm_transaction_followup_labels WHERE followup_category_id = ? AND status_label = 'Pending'", [(int)$c->id]);
			$dikirim = $this->get_query_count("SELECT COUNT(*) as cnt FROM crm_transaction_followup_labels WHERE followup_category_id = ? AND status_label IN ('Sudah Dikirim','Direspon','Sudah Konfirmasi Diterima')", [(int)$c->id]);
			$selesai = $this->get_query_count("SELECT COUNT(*) as cnt FROM crm_transaction_followup_labels WHERE followup_category_id = ? AND status_label IN ('Selesai','Tawarkan Repeat Order')", [(int)$c->id]);

			$result[] = [
				'kategori' => $c->nama_kategori,
				'pending' => (int)$pending,
				'dikirim' => (int)$dikirim,
				'selesai' => (int)$selesai,
			];
		}
		return $result;
	}

	public function get_top_repeat_customers($limit = 5)
	{
		$sql = "SELECT 
			customer_nama,
			customer_phone,
			COUNT(DISTINCT CONCAT(order_table, '-', order_id)) as total_orders,
			GROUP_CONCAT(DISTINCT order_source SEPARATOR ', ') as sources,
			MAX(tanggal_pengiriman) as last_order
		FROM crm_transaction_followup_labels 
		WHERE customer_phone IS NOT NULL AND customer_phone != ''
		GROUP BY customer_phone, customer_nama
		ORDER BY total_orders DESC, last_order DESC
		LIMIT $limit";

		return $this->db->query($sql)->result();
	}

	public function get_urgent_alerts()
	{
		$today = date('Y-m-d');
		$sql = "SELECT tfl.*, fc.nama_kategori 
			FROM crm_transaction_followup_labels tfl
			JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
			WHERE tfl.status_label = 'Komplain' 
			OR (tfl.status_label = 'Pending' AND tfl.tanggal_label_muncul <= DATE_SUB('$today', INTERVAL 3 DAY))
			ORDER BY tfl.tanggal_label_muncul ASC
			LIMIT 10";

		return $this->db->query($sql)->result();
	}

	public function get_recent_activities($limit = 10)
	{
		$sql = "SELECT 
			bl.waktu_kirim as waktu,
			bl.dikirim_oleh as user,
			tfl.customer_nama,
			tfl.customer_phone,
			fc.nama_kategori,
			'broadcast' as type,
			bl.isi_pesan_final as detail
		FROM crm_broadcast_logs bl
		JOIN crm_transaction_followup_labels tfl ON bl.followup_label_id = tfl.id
		JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
		UNION ALL
		SELECT 
			fn.created_at as waktu,
			fn.username as user,
			tfl.customer_nama,
			tfl.customer_phone,
			fc.nama_kategori,
			'note' as type,
			fn.catatan as detail
		FROM crm_followup_notes fn
		JOIN crm_transaction_followup_labels tfl ON fn.followup_label_id = tfl.id
		JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
		ORDER BY waktu DESC
		LIMIT $limit";

		return $this->db->query($sql)->result();
	}

	// ===== MODUL OTOMASI CRM (CLI & WEB) =====

	public function run_all_automations($mode = 'web_manual', $executed_by = 'system')
	{
		$res1 = $this->process_overdue_automations($mode, $executed_by);
		$res2 = $this->process_cancellation_automations($mode, $executed_by);
		$res3 = $this->process_bundle_repeat_automations($mode, $executed_by);
		$res4 = $this->process_conversion_tracking_automations($mode, $executed_by);

		return [
			'success' => true,
			'mode' => $mode,
			'executed_by' => $executed_by,
			'executed_at' => date('Y-m-d H:i:s'),
			'overdue' => $res1,
			'cancellations' => $res2,
			'bundles' => $res3,
			'conversions' => $res4,
			'total_affected' => $res1['count'] + $res2['count'] + $res3['count'] + $res4['count']
		];
	}

	// Proses 1: Pembaruan Jadwal Follow-Up yang Jatuh Tempo
	public function process_overdue_automations($mode, $executed_by)
	{
		$today = date('Y-m-d');
		$sql = "SELECT id, customer_nama, customer_phone, no_pesanan, tanggal_label_muncul 
			FROM crm_transaction_followup_labels 
			WHERE status_label = 'Pending' AND is_cancelled = 0 AND tanggal_label_muncul < '$today'";
		
		$overdue_items = $this->db->query($sql)->result();
		$count = count($overdue_items);

		if ($count > 0) {
			// Mark overdue status notice or update timestamp
			$ids = array_map(function($o) { return $o->id; }, $overdue_items);
			$this->db->where_in('id', $ids)->update('crm_transaction_followup_labels', ['updated_at' => date('Y-m-d H:i:s')]);
		}

		$details = "Terdeteksi $count label follow-up pending yang jatuh tempo (overdue).";
		$this->log_automation_run('Overdue Follow-Up Update', $mode, $count, $details, $executed_by);

		return ['count' => $count, 'details' => $details];
	}

	// Proses 2: Pembatalan Jadwal untuk Pesanan Retur / Cancelled
	public function process_cancellation_automations($mode, $executed_by)
	{
		$affected = 0;

		// 1. Cancelled from sales_order
		$so_cancelled = $this->db->query("SELECT id, nomor_so, no_pesanan FROM sales_order WHERE status IN ('cancelled', 'dibatalkan', 'returned')")->result();
		foreach ($so_cancelled as $so) {
			$order_no = $so->no_pesanan ?: $so->nomor_so;
			$this->db->query("UPDATE crm_transaction_followup_labels 
				SET is_cancelled = 1, status_label = 'Batal (Retur/Cancelled)', updated_at = NOW() 
				WHERE (order_table = 'sales_order' AND order_id = ?) OR (no_pesanan = ? AND is_cancelled = 0)", [(int)$so->id, $order_no]);
			$affected += $this->db->affected_rows();
		}

		// 2. Cancelled from penjualan_marketplace
		$mp_cancelled = $this->db->query("SELECT id, no_pesanan FROM penjualan_marketplace WHERE status IN ('cancelled', 'dibatalkan', 'returned', 'pengembalian')")->result();
		foreach ($mp_cancelled as $mp) {
			$this->db->query("UPDATE crm_transaction_followup_labels 
				SET is_cancelled = 1, status_label = 'Batal (Retur/Cancelled)', updated_at = NOW() 
				WHERE (order_table = 'penjualan_marketplace' AND order_id = ?) OR (no_pesanan = ? AND is_cancelled = 0)", [(int)$mp->id, $mp->no_pesanan]);
			$affected += $this->db->affected_rows();
		}

		$details = "Otomatis membatalkan $affected label follow-up untuk pesanan retur/batal.";
		$this->log_automation_run('Auto-Cancellation Retur/Cancelled', $mode, $affected, $details, $executed_by);

		return ['count' => $affected, 'details' => $details];
	}

	// Proses 3: Penggabungan Penawaran Repeat Order Multi-Produk
	public function process_bundle_repeat_automations($mode, $executed_by)
	{
		$sql = "SELECT customer_phone, customer_nama, COUNT(id) as label_count, GROUP_CONCAT(DISTINCT order_source SEPARATOR ', ') as sources 
			FROM crm_transaction_followup_labels 
			WHERE status_label IN ('Pending', 'Tawarkan Repeat Order') AND is_cancelled = 0 AND customer_phone IS NOT NULL AND customer_phone != ''
			GROUP BY customer_phone, customer_nama 
			HAVING label_count > 1";

		$bundled_customers = $this->db->query($sql)->result();
		$count = count($bundled_customers);

		$details = "Penggabungan paket penawaran repeat order multi-produk untuk $count customer aktif.";
		$this->log_automation_run('Multi-Product Repeat Consolidation', $mode, $count, $details, $executed_by);

		return ['count' => $count, 'customers' => $bundled_customers, 'details' => $details];
	}

	// Proses 4: Pelacakan Konversi Transaksi dalam 14 Hari
	public function process_conversion_tracking_automations($mode, $executed_by)
	{
		$converted_count = 0;
		$total_amount = 0;

		// Get all labels created in last 60 days that are not converted yet
		$sql = "SELECT id, customer_phone, tanggal_label_muncul, order_table, order_id 
			FROM crm_transaction_followup_labels 
			WHERE is_converted = 0 AND is_cancelled = 0 AND customer_phone IS NOT NULL AND customer_phone != ''
			AND tanggal_label_muncul <= CURDATE()";

		$labels = $this->db->query($sql)->result();

		foreach ($labels as $lbl) {
			$start_date = $lbl->tanggal_label_muncul;
			$end_date = date('Y-m-d', strtotime($start_date . ' +14 days'));
			$phone = $lbl->customer_phone;

			// Check SO new purchase within 14 days after label date
			$new_so = $this->db->query("SELECT id, total, tanggal_so FROM sales_order 
				WHERE (pelanggan_id IN (SELECT id FROM pelanggan WHERE no_telepon = ?) OR catatan LIKE ?)
				AND tanggal_so >= ? AND tanggal_so <= ?
				AND id != ? LIMIT 1", [$phone, "%{$phone}%", $start_date, $end_date, $lbl->order_id])->row();

			// Check Marketplace new purchase within 14 days
			$new_mp = $this->db->query("SELECT id, total, tanggal_so FROM penjualan_marketplace 
				WHERE no_telepon = ? 
				AND tanggal_so >= ? AND tanggal_so <= ?
				AND id != ? LIMIT 1", [$phone, $start_date, $end_date, $lbl->order_id])->row();

			$converted_order = $new_so ?: $new_mp;

			if ($converted_order) {
				$amt = (float)$converted_order->total;
				$conv_date = $converted_order->tanggal_so;

				$this->db->where('id', $lbl->id)->update('crm_transaction_followup_labels', [
					'is_converted' => 1,
					'converted_at' => date('Y-m-d H:i:s', strtotime($conv_date)),
					'converted_amount' => $amt,
					'status_label' => 'Selesai'
				]);

				$converted_count++;
				$total_amount += $amt;
			}
		}

		$details = "Berhasil melacak $converted_count konversi repeat order 14 hari dengan total nominal Rp " . number_format($total_amount, 0, ',', '.') . ".";
		$this->log_automation_run('14-Day Conversion Tracking', $mode, $converted_count, $details, $executed_by);

		return ['count' => $converted_count, 'amount' => $total_amount, 'details' => $details];
	}

	public function log_automation_run($process_name, $mode, $affected_count, $details, $executed_by = 'system')
	{
		$this->db->insert('crm_automation_logs', [
			'process_name' => $process_name,
			'mode' => $mode,
			'affected_count' => (int)$affected_count,
			'details' => $details,
			'executed_by' => $executed_by,
			'executed_at' => date('Y-m-d H:i:s')
		]);
	}

	public function get_automation_logs($limit = 50, $offset = 0)
	{
		return $this->db->order_by('executed_at', 'DESC')
			->limit($limit, $offset)
			->get('crm_automation_logs')
			->result();
	}

	// ===== MODUL ANALITIK KINERJA & KONVERSI TIM CS =====

	public function get_cs_performance_report($filters = [])
	{
		$where_label = "WHERE (tfl.handled_by IS NOT NULL AND tfl.handled_by != '' AND tfl.handled_by != 'system')";
		$where_bc = "WHERE (bl.dikirim_oleh IS NOT NULL AND bl.dikirim_oleh != '' AND bl.dikirim_oleh != 'system')";
		$where_note = "WHERE (fn.username IS NOT NULL AND fn.username != '' AND fn.username != 'system')";

		if (!empty($filters['date_from'])) {
			$where_label .= " AND tfl.updated_at >= '{$filters['date_from']} 00:00:00'";
			$where_bc .= " AND bl.waktu_kirim >= '{$filters['date_from']} 00:00:00'";
			$where_note .= " AND fn.created_at >= '{$filters['date_from']} 00:00:00'";
		}
		if (!empty($filters['date_to'])) {
			$where_label .= " AND tfl.updated_at <= '{$filters['date_to']} 23:59:59'";
			$where_bc .= " AND bl.waktu_kirim <= '{$filters['date_to']} 23:59:59'";
			$where_note .= " AND fn.created_at <= '{$filters['date_to']} 23:59:59'";
		}

		$sql = "SELECT 
			u.cs_name,
			COALESCE(lbl.handled_count, 0) + COALESCE(nt.note_count, 0) as total_handled,
			COALESCE(bc.broadcast_count, 0) as broadcast_count,
			COALESCE(lbl.respon_positif, 0) as respon_positif,
			COALESCE(lbl.komplain_count, 0) as komplain_count,
			COALESCE(lbl.conversion_count, 0) as conversion_count,
			COALESCE(lbl.conversion_amount, 0) as conversion_amount
		FROM (
			SELECT DISTINCT handled_by as cs_name FROM crm_transaction_followup_labels WHERE handled_by IS NOT NULL AND handled_by != '' AND handled_by != 'system'
			UNION
			SELECT DISTINCT dikirim_oleh as cs_name FROM crm_broadcast_logs WHERE dikirim_oleh IS NOT NULL AND dikirim_oleh != '' AND dikirim_oleh != 'system'
			UNION
			SELECT DISTINCT username as cs_name FROM crm_followup_notes WHERE username IS NOT NULL AND username != '' AND username != 'system'
		) u
		LEFT JOIN (
			SELECT 
				handled_by,
				COUNT(id) as handled_count,
				SUM(CASE WHEN status_label IN ('Direspon', 'Sudah Konfirmasi Diterima', 'Selesai') THEN 1 ELSE 0 END) as respon_positif,
				SUM(CASE WHEN status_label = 'Komplain' THEN 1 ELSE 0 END) as komplain_count,
				SUM(CASE WHEN is_converted = 1 THEN 1 ELSE 0 END) as conversion_count,
				SUM(CASE WHEN is_converted = 1 THEN converted_amount ELSE 0 END) as conversion_amount
			FROM crm_transaction_followup_labels tfl
			$where_label
			GROUP BY handled_by
		) lbl ON u.cs_name = lbl.handled_by
		LEFT JOIN (
			SELECT dikirim_oleh, COUNT(id) as broadcast_count 
			FROM crm_broadcast_logs bl
			$where_bc
			GROUP BY dikirim_oleh
		) bc ON u.cs_name = bc.dikirim_oleh
		LEFT JOIN (
			SELECT username, COUNT(id) as note_count 
			FROM crm_followup_notes fn
			$where_note
			GROUP BY username
		) nt ON u.cs_name = nt.username
		ORDER BY conversion_amount DESC, total_handled DESC";

		$rows = $this->db->query($sql)->result();

		// Calculate conversion rates
		foreach ($rows as &$r) {
			$r->total_handled = (int)$r->total_handled;
			$r->broadcast_count = (int)$r->broadcast_count;
			$r->respon_positif = (int)$r->respon_positif;
			$r->komplain_count = (int)$r->komplain_count;
			$r->conversion_count = (int)$r->conversion_count;
			$r->conversion_amount = (float)$r->conversion_amount;
			$r->conversion_rate = $r->total_handled > 0 ? round(($r->conversion_count / $r->total_handled) * 100, 1) : 0;
		}

		return $rows;
	}

	public function get_cs_performance_kpis($filters = [])
	{
		$rows = $this->get_cs_performance_report($filters);
		
		$total_cs = count($rows);
		$total_handled = 0;
		$total_conversions = 0;
		$total_revenue = 0;

		foreach ($rows as $r) {
			$total_handled += $r->total_handled;
			$total_conversions += $r->conversion_count;
			$total_revenue += $r->conversion_amount;
		}

		return [
			'total_cs_active' => $total_cs,
			'total_handled' => $total_handled,
			'total_conversions' => $total_conversions,
			'total_revenue' => $total_revenue,
			'avg_conversion_rate' => $total_handled > 0 ? round(($total_conversions / $total_handled) * 100, 1) : 0
		];
	}
}
