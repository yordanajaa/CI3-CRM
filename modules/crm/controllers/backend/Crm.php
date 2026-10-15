<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crm extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_crm');
	}

	// ===== MODUL A: Customer Directory & Detail =====

	public function index($offset = 0)
	{
		$filter = $this->input->get('q');
		$rfm_segment = $this->input->get('rfm_segment');
		$result = $this->model_crm->get_customers($filter, $this->limit_page, $offset, $rfm_segment);

		$this->data['customers'] = $result['rows'];
		$this->data['customer_counts'] = $result['total'];
		$this->data['filter'] = $filter;
		$this->data['rfm_segment'] = $rfm_segment;

		$config = [
			'base_url'    => 'administrator/crm/index/',
			'total_rows'  => $result['total'],
			'per_page'    => $this->limit_page,
			'uri_segment' => 4,
		];
		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('CRM — Customer Directory & Segmentasi RFM');
		$this->render('backend/standart/administrator/crm/crm_customer_list', $this->data);
	}

	public function customer_list($offset = 0)
	{
		return $this->index($offset);
	}

	public function pelanggan($offset = 0)
	{
		return $this->index($offset);
	}

	public function customer_detail($phone_segment = null)
	{
		$phone = $this->input->get('phone');
		if (empty($phone) && !empty($phone_segment)) {
			$phone = urldecode($phone_segment);
		}
		if (empty($phone)) {
			set_message('Nomor telepon customer tidak valid.', 'error');
			redirect('administrator/crm');
		}

		$this->data['summary'] = $this->model_crm->get_customer_summary($phone);
		$this->data['transactions'] = $this->model_crm->get_customer_transactions($phone);
		$this->data['product_rfm'] = $this->model_crm->get_customer_product_rfm($phone);
		$this->data['phone'] = $phone;

		$this->template->title('CRM — Detail Customer');
		$this->render('backend/standart/administrator/crm/crm_customer_detail', $this->data);
	}

	// ===== MODUL DEDICATED WHATSAPP CHAT CENTER =====

	public function chat()
	{
		$phone = trim((string)$this->input->get('phone'));
		if (!empty($phone)) {
			redirect('administrator/crm/journal_followup?q=' . urlencode($phone), 'refresh');
		} else {
			redirect('administrator/crm/journal_followup', 'refresh');
		}
	}

	public function transaction_detail_ajax()
	{
		header('Content-Type: application/json');
		$table = $this->input->get('table');
		$order_id = $this->input->get('order_id');
		if (!$table || !$order_id) {
			echo json_encode(['success' => false, 'message' => 'Parameter tidak valid']); return;
		}
		$items = $this->model_crm->get_transaction_items($table, $order_id);
		$timeline = $this->model_crm->get_transaction_followup_timeline($table, $order_id);
		echo json_encode(['success' => true, 'items' => $items, 'timeline' => $timeline]);
	}

	// ===== MODUL B: Journal Follow-Up =====

	public function journal($offset = 0)
	{
		return $this->journal_followup($offset);
	}

	public function journal_followup($offset = 0)
	{
		$phone_param = trim((string)$this->input->get('phone'));
		if (!empty($phone_param)) {
			$this->model_crm->ensure_label_for_phone($phone_param);
		}

		$search_query = $this->input->get('q') ?: $phone_param;

		$filters = [
			'category_id' => $this->input->get('category_id'),
			'order_source' => $this->input->get('order_source'),
			'status_label' => $this->input->get('status_label'),
			'date_from' => $this->input->get('date_from'),
			'date_to' => $this->input->get('date_to'),
			'search' => $search_query,
			'show_future' => !empty($phone_param) ? 1 : 0,
		];

		$result = $this->model_crm->get_journal_entries($filters, $this->limit_page, $offset);
		$this->data['entries'] = $result['rows'];
		$this->data['entry_counts'] = $result['total'];
		$this->data['categories'] = $this->model_crm->get_categories();
		$this->data['stats'] = $this->model_crm->get_journal_stats();
		$this->data['filters'] = $filters;

		$config = [
			'base_url'    => 'administrator/crm/journal_followup/',
			'total_rows'  => $result['total'],
			'per_page'    => $this->limit_page,
			'uri_segment' => 4,
		];
		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('CRM — Journal Follow-Up');
		$this->render('backend/standart/administrator/crm/crm_journal_followup', $this->data);
	}

	public function update_status_ajax()
	{
		header('Content-Type: application/json');
		$label_id = $this->input->post('label_id') ?: $this->input->get('label_id');
		$status = trim($this->input->post('status') ?: $this->input->get('status'));
		$catatan = trim($this->input->post('catatan') ?: $this->input->get('catatan'));
		$sender_type = trim($this->input->post('sender_type') ?: 'cs');

		if (!$label_id) {
			echo json_encode(['success' => false, 'message' => 'Label ID tidak valid']);
			return;
		}

		$existing = $this->model_crm->get_label($label_id);
		if (!$existing) {
			echo json_encode(['success' => false, 'message' => 'Label follow-up tidak ditemukan']);
			return;
		}

		if (empty($status)) {
			$status = $existing->status_label;
		}

		$username = 'administrator';
		if (function_exists('get_user_data')) {
			$u = get_user_data('username');
			if (!empty($u)) $username = $u;
		}

		// If sender_type is customer, auto-set status to Direspon
		if ($sender_type === 'customer' && in_array($existing->status_label, ['Pending', 'Sudah Dikirim', 'Belum Respon'])) {
			$status = 'Direspon';
		}

		$api_result = null;
		$wa_link = null;

		// Handle CS WA Chat reply
		if ($sender_type === 'cs_chat' && !empty($catatan)) {
			$config = $this->model_crm->get_wa_gateway_config();
			if ($config->mode === 'wa_gateway') {
				$api_res = $this->model_crm->send_wa_via_api($existing->customer_phone, $catatan);
				$this->model_crm->log_broadcast($label_id, $catatan, 'wa_gateway_api');
				$api_result = $api_res;
			} else {
				$wa_link = $this->model_crm->generate_wa_link($existing->customer_phone, $catatan);
				$this->model_crm->log_broadcast($label_id, $catatan, 'wa_direct_link');
			}
			if ($existing->status_label === 'Pending') {
				$status = 'Sudah Dikirim';
			}
		} elseif (!empty($catatan)) {
			$this->model_crm->add_note($label_id, $catatan, $status, $sender_type);
		}

		$res_status = $this->model_crm->update_label_status($label_id, $status, $username);

		$msg = 'Berhasil disimpan';
		if ($sender_type === 'customer') {
			$msg = 'Balasan customer berhasil dicatat';
		} elseif ($sender_type === 'cs_chat') {
			$msg = ($api_result && $api_result['success']) ? 'Pesan CS terkirim via WhatsApp API!' : 'Pesan CS berhasil dikirim & dicatat';
		} else {
			$msg = 'Catatan & status berhasil disimpan';
		}

		echo json_encode([
			'success' => true,
			'message' => $msg,
			'status' => $status,
			'sender_type' => $sender_type,
			'wa_link' => $wa_link,
			'api_result' => $api_result
		]);
	}

	/**
	 * AJAX endpoint to add manual follow-up label entry
	 */
	public function add_manual_label_ajax()
	{
		header('Content-Type: application/json');

		$nama = trim($this->input->post('customer_nama') ?: '');
		$phone = trim($this->input->post('customer_phone') ?: '');
		$no_pesanan = trim($this->input->post('no_pesanan') ?: '');
		$source = trim($this->input->post('order_source') ?: 'Toko');
		$tanggal_kirim = trim($this->input->post('tanggal_pengiriman') ?: date('Y-m-d'));
		$cat_mode = trim($this->input->post('cat_mode') ?: 'all');

		if (empty($nama) || empty($phone)) {
			echo json_encode(['success' => false, 'message' => 'Nama Customer dan Nomor WhatsApp wajib diisi']);
			return;
		}

		$clean_phone = $this->model_crm->normalize_phone_number($phone);
		if (empty($no_pesanan)) {
			$no_pesanan = 'MANUAL-' . date('YmdHis') . '-' . rand(100, 999);
		}

		$categories = $this->model_crm->get_categories(true);
		if ($cat_mode !== 'all') {
			$cat_id = (int)$cat_mode;
			$categories = array_filter($categories, function($c) use ($cat_id) { return (int)$c->id === $cat_id; });
		}

		$inserted = 0;
		$now = date('Y-m-d H:i:s');
		foreach ($categories as $cat) {
			$target = date('Y-m-d', strtotime($tanggal_kirim . ' + ' . $cat->jumlah_hari . ' days'));
			$this->db->insert('crm_transaction_followup_labels', [
				'order_source' => $source,
				'order_id' => 0,
				'order_table' => 'manual_entry',
				'customer_nama' => $nama,
				'customer_phone' => $clean_phone,
				'no_pesanan' => $no_pesanan,
				'tanggal_pengiriman' => $tanggal_kirim,
				'followup_category_id' => $cat->id,
				'tanggal_label_muncul' => $target,
				'status_label' => 'Pending',
				'created_at' => $now,
				'updated_at' => $now,
			]);
			$inserted++;
		}

		echo json_encode([
			'success' => true,
			'message' => 'Berhasil menambahkan ' . $inserted . ' label follow-up manual untuk ' . $nama,
		]);
	}

	/**
	 * AJAX endpoint to upload local file attachments (Photos, PDFs, Documents, Voice Notes)
	 */
	public function upload_attachment_ajax()
	{
		header('Content-Type: application/json');

		if (empty($_FILES['file']['name'])) {
			echo json_encode(['success' => false, 'message' => 'Tidak ada file yang dipilih']);
			return;
		}

		$upload_dir = FCPATH . 'uploads/crm_attachments/';
		if (!is_dir($upload_dir)) {
			@mkdir($upload_dir, 0777, true);
		}

		$orig_name = $_FILES['file']['name'];
		$file_ext  = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
		$allowed   = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', 'mp3', 'ogg', 'wav', 'm4a', 'aac', 'opus', 'webm', '3gp', 'amr', 'txt', 'csv'];

		if (!in_array($file_ext, $allowed)) {
			echo json_encode(['success' => false, 'message' => 'Format file (.' . $file_ext . ') tidak didukung. Harap pilih gambar, PDF, dokumen Office, ZIP, atau audio.']);
			return;
		}

		$new_name    = 'crm_' . date('Ymd_His') . '_' . rand(1000, 9999) . '.' . $file_ext;
		$target_path = $upload_dir . $new_name;

		$tmp_file = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : '';
		if (!empty($tmp_file) && move_uploaded_file($tmp_file, $target_path)) {
			$file_url = base_url('uploads/crm_attachments/' . $new_name);
			echo json_encode([
				'success'   => true,
				'file_url'  => $file_url,
				'file_name' => $orig_name,
				'file_ext'  => $file_ext,
				'message'   => 'File berhasil diunggah'
			]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Gagal mengunggah file ke folder uploads/crm_attachments']);
		}
	}

	public function get_wa_link_ajax()
	{
		header('Content-Type: application/json');
		$label_id = $this->input->get('label_id');
		$label = $this->model_crm->get_label($label_id);
		if (!$label) {
			echo json_encode(['success' => false]); return;
		}

		$message = $this->model_crm->render_template($label->template_pesan_default, $label);
		$wa_link = $this->model_crm->generate_wa_link($label->customer_phone, $message);

		echo json_encode([
			'success' => true,
			'wa_link' => $wa_link,
			'message_preview' => $message,
			'phone' => $label->customer_phone,
			'nama' => $label->customer_nama,
			'no_pesanan' => $label->no_pesanan ?: '-',
		]);
	}

	public function get_templates_ajax()
	{
		header('Content-Type: application/json');
		$label_id = $this->input->get('label_id');
		$categories = $this->model_crm->get_categories(true);
		
		$label = null;
		if (!empty($label_id)) {
			$label = $this->model_crm->get_label($label_id);
		}

		$list = [];
		foreach ($categories as $cat) {
			$preview = $cat->template_pesan_default;
			if ($label) {
				$preview = $this->model_crm->render_template($cat->template_pesan_default, $label);
			}
			$list[] = [
				'id' => $cat->id,
				'nama' => $cat->nama_kategori,
				'jumlah_hari' => $cat->jumlah_hari,
				'template_raw' => $cat->template_pesan_default,
				'template_rendered' => $preview,
			];
		}

		echo json_encode(['success' => true, 'templates' => $list]);
	}

	public function send_broadcast_ajax()
	{
		header('Content-Type: application/json');
		$label_ids = $this->input->post('label_ids');
		$custom_message = trim($this->input->post('custom_message') ?: '');
		$file_url = trim($this->input->post('file_url') ?: '');

		if (empty($label_ids) || !is_array($label_ids)) {
			echo json_encode(['success' => false, 'message' => 'Pilih minimal 1 customer']); return;
		}

		$config = $this->model_crm->get_wa_gateway_config();
		$use_api = ($config->mode === 'wa_gateway');

		$wa_links = [];
		$api_results = [];

		foreach ($label_ids as $lid) {
			$label = $this->model_crm->get_label($lid);
			if (!$label) continue;
			// Skip duplicate only on bulk broadcast without custom message
			if ($label->is_broadcast_sent && count($label_ids) > 1 && empty($custom_message)) continue;

			$message = !empty($custom_message) ? $custom_message : $this->model_crm->render_template($label->template_pesan_default, $label);
			if (!empty($file_url) && strpos($message, $file_url) === false) {
				$message .= "\n\n[Lampiran File]: " . $file_url;
			}

			if ($use_api) {
				$api_res = $this->model_crm->send_wa_via_api($label->customer_phone, $message, $file_url);
				$this->model_crm->log_broadcast($lid, $message, 'wa_gateway_api');
				$api_results[] = [
					'phone' => $label->customer_phone,
					'nama' => $label->customer_nama,
					'success' => $api_res['success'],
					'message' => $api_res['message']
				];
			} else {
				$wa_link = $this->model_crm->generate_wa_link($label->customer_phone, $message);
				$this->model_crm->log_broadcast($lid, $message, 'wa_direct_link');
				$wa_links[] = ['link' => $wa_link, 'nama' => $label->customer_nama, 'phone' => $label->customer_phone];
			}
		}

		echo json_encode([
			'success' => true,
			'mode' => $config->mode,
			'wa_links' => $wa_links,
			'api_results' => $api_results,
			'count' => $use_api ? count($api_results) : count($wa_links)
		]);
	}

	// ===== MODUL WA GATEWAY API CONFIGURATION =====

	public function wa_gateway_setting()
	{
		$this->data['config'] = $this->model_crm->get_wa_gateway_config();
		$this->template->title('CRM — Pengaturan WhatsApp Gateway API');
		$this->render('backend/standart/administrator/crm/crm_wa_gateway_setting', $this->data);
	}

	public function save_wa_gateway_config_ajax()
	{
		header('Content-Type: application/json');
		$data = [
			'mode' => $this->input->post('mode') ?: 'wa_direct',
			'provider' => $this->input->post('provider') ?: 'fonnte',
			'api_key' => trim($this->input->post('api_key') ?: ''),
			'api_url' => trim($this->input->post('api_url') ?: ''),
			'sender_phone' => trim($this->input->post('sender_phone') ?: ''),
			'additional_headers' => trim($this->input->post('additional_headers') ?: ''),
		];

		$res = $this->model_crm->save_wa_gateway_config($data);
		echo json_encode([
			'success' => (bool)$res,
			'message' => $res ? 'Konfigurasi WhatsApp Gateway API berhasil disimpan' : 'Gagal menyimpan konfigurasi'
		]);
	}

	public function test_wa_gateway_ajax()
	{
		header('Content-Type: application/json');
		$phone = trim($this->input->post('phone') ?: '');
		$message = trim($this->input->post('message') ?: 'Tes WA Gateway ERP Metafora');

		if (empty($phone)) {
			echo json_encode(['success' => false, 'message' => 'Nomor HP tidak boleh kosong']);
			return;
		}

		$res = $this->model_crm->send_wa_via_api($phone, $message);
		echo json_encode($res);
	}

	// ===== Follow-Up Settings =====

	public function followup_setting()
	{
		$this->data['categories'] = $this->model_crm->get_categories(false);
		$this->template->title('CRM — Pengaturan Kelompok Follow-Up');
		$this->render('backend/standart/administrator/crm/crm_followup_setting', $this->data);
	}

	public function save_category_ajax()
	{
		header('Content-Type: application/json');
		$id = $this->input->post('id');
		$data = [
			'nama_kategori' => $this->input->post('nama_kategori'),
			'kode_kategori' => $this->input->post('kode_kategori'),
			'jumlah_hari' => (int)$this->input->post('jumlah_hari'),
			'template_pesan_default' => $this->input->post('template_pesan_default'),
			'is_active' => $this->input->post('is_active') ? 1 : 0,
			'urutan' => (int)$this->input->post('urutan'),
			'created_by' => get_user_data('username'),
		];

		$result = $this->model_crm->save_category($data, $id ?: null);
		echo json_encode(['success' => (bool)$result, 'message' => $result ? 'Berhasil disimpan' : 'Gagal menyimpan']);
	}

	public function delete_category_ajax()
	{
		header('Content-Type: application/json');
		$id = $this->input->post('id');
		$result = $this->model_crm->delete_category($id);
		echo json_encode(['success' => (bool)$result, 'message' => $result ? 'Berhasil dihapus' : 'Gagal: masih ada label follow-up aktif']);
	}

	// ===== Broadcast =====

	public function broadcast($offset = 0)
	{
		$this->data['categories'] = $this->model_crm->get_categories();
		$this->data['logs'] = $this->model_crm->get_broadcast_logs([], 50, 0);
		$this->data['stats'] = $this->model_crm->get_journal_stats();

		$this->template->title('CRM — Broadcast WhatsApp');
		$this->render('backend/standart/administrator/crm/crm_broadcast', $this->data);
	}

	public function get_broadcast_recipients_ajax()
	{
		header('Content-Type: application/json');
		$category_id = $this->input->get('category_id');
		$order_source = $this->input->get('order_source');
		$rfm_segment = $this->input->get('rfm_segment');

		$filters = [
			'category_id' => $category_id,
			'order_source' => $order_source,
			'status_label' => 'Pending',
		];
		$result = $this->model_crm->get_journal_entries($filters, 500, 0);

		// Filter only non-broadcast-sent (FB-10) and optional RFM segment
		$recipients = [];
		foreach ($result['rows'] as $r) {
			if (!$r->is_broadcast_sent && !empty($r->customer_phone)) {
				if (!empty($rfm_segment)) {
					$cust_summary = $this->model_crm->get_customer_summary($r->customer_phone);
					$cust_segment = isset($cust_summary['rfm']['segment']) ? $cust_summary['rfm']['segment'] : '';
					if (strcasecmp($cust_segment, $rfm_segment) !== 0) {
						continue;
					}
				}
				$recipients[] = $r;
			}
		}

		echo json_encode(['success' => true, 'recipients' => $recipients, 'count' => count($recipients)]);
	}

	// ===== CRON Endpoint =====

	public function generate_labels_cron()
	{
		header('Content-Type: application/json');
		$count = $this->model_crm->generate_labels_for_new_orders();
		echo json_encode(['success' => true, 'generated' => $count]);
	}

	// ===== DASHBOARD CRM ANALYTICS (Fase 5) =====

	public function dashboard()
	{
		$this->data['kpis'] = $this->model_crm->get_dashboard_kpis();
		$this->data['channels'] = $this->model_crm->get_channel_distribution();
		$this->data['trend'] = $this->model_crm->get_followup_trend_30days();
		$this->data['category_status'] = $this->model_crm->get_category_status_breakdown();
		$this->data['top_repeat'] = $this->model_crm->get_top_repeat_customers(5);
		$this->data['urgent_alerts'] = $this->model_crm->get_urgent_alerts();
		$this->data['recent_activities'] = $this->model_crm->get_recent_activities(10);

		$this->template->title('CRM — Dashboard Analytics');
		$this->render('backend/standart/administrator/crm/crm_dashboard', $this->data);
	}

	// ===== EXPORT & MANUAL CRON SYNC =====

	public function export_customers()
	{
		$filter = $this->input->get('q');
		$rfm_segment = $this->input->get('rfm_segment');
		$result = $this->model_crm->get_customers($filter, 10000, 0, $rfm_segment);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=CRM_Customer_Directory_' . date('Ymd_His') . '.csv');
		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fwrite($output, "sep=;\n");
		fputcsv($output, ['No', 'Nama Customer', 'No. HP', 'Sumber Penjualan', 'Total Order', 'Total Spend (Rp)', 'Kode RFM', 'Segmen RFM', 'Target Goal', 'Rekomendasi Action', 'Order Terakhir'], ';');

		$no = 1;
		foreach ($result['rows'] as $c) {
			$phone = trim((string)$c->customer_phone);
			$phone_str = !empty($phone) ? '="' . $phone . '"' : '-';
			$last_date = !empty($c->last_order_date) ? '="' . date('d/m/Y', strtotime($c->last_order_date)) . '"' : '-';
			$rfm = isset($c->rfm) ? $c->rfm : $this->model_crm->calculate_rfm($c->last_order_date, $c->total_orders, $c->total_spend);

			fputcsv($output, [
				$no++,
				$c->customer_nama,
				$phone_str,
				$c->sumber_penjualan ?: 'Direct',
				$c->total_orders,
				number_format($c->total_spend, 0, ',', '.'),
				$rfm['rfm_display'],
				$rfm['segment'],
				$rfm['goal'],
				$rfm['action'],
				$last_date
			], ';');
		}
		fclose($output);
		exit;
	}

	public function export_customers_pdf()
	{
		$filter = $this->input->get('q');
		$rfm_segment = $this->input->get('rfm_segment');
		$result = $this->model_crm->get_customers($filter, 10000, 0, $rfm_segment);

		$this->data['rows'] = $result['rows'];
		$this->load->library('HtmlPdf');
		$this->htmlpdf->initialize(['orientation' => 'L', 'format' => 'A4', 'marges' => [5, 5, 5, 5]]);
		$content = $this->load->view('backend/standart/administrator/crm/crm_customers_pdf', $this->data, true);
		$this->htmlpdf->writeHTML($content);
		$filename = 'CRM_Customer_Directory_' . date('Ymd_His') . '.pdf';
		if (ob_get_length()) { ob_clean(); }
		$this->htmlpdf->Output($filename, 'D');
	}

	public function export_journal()
	{
		$filters = [
			'category_id' => $this->input->get('category_id'),
			'order_source' => $this->input->get('order_source'),
			'status_label' => $this->input->get('status_label'),
			'date_from' => $this->input->get('date_from'),
			'date_to' => $this->input->get('date_to'),
			'search' => $this->input->get('q'),
			'show_future' => 1
		];

		$result = $this->model_crm->get_journal_entries($filters, 10000, 0);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=CRM_Journal_FollowUp_' . date('Ymd_His') . '.csv');
		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fwrite($output, "sep=;\n");
		fputcsv($output, ['No', 'Customer', 'No. HP', 'No. Pesanan', 'Sumber', 'Kategori H+', 'Tgl Kirim', 'Target Label', 'Status', 'Broadcast Terkirim'], ';');

		$no = 1;
		foreach ($result['rows'] as $e) {
			$phone = trim((string)$e->customer_phone);
			$phone_str = !empty($phone) ? '="' . $phone . '"' : '-';

			$order_no = trim((string)$e->no_pesanan);
			$order_str = !empty($order_no) ? '="' . $order_no . '"' : '-';

			$tgl_kirim = !empty($e->tanggal_pengiriman) ? '="' . date('d/m/Y', strtotime($e->tanggal_pengiriman)) . '"' : '-';
			$tgl_target = !empty($e->tanggal_label_muncul) ? '="' . date('d/m/Y', strtotime($e->tanggal_label_muncul)) . '"' : '-';

			fputcsv($output, [
				$no++,
				$e->customer_nama,
				$phone_str,
				$order_str,
				$e->order_source ?: 'Direct',
				$e->nama_kategori,
				$tgl_kirim,
				$tgl_target,
				$e->status_label,
				$e->is_broadcast_sent ? 'Ya' : 'Belum'
			], ';');
		}
		fclose($output);
		exit;
	}

	public function export_journal_pdf()
	{
		$filters = [
			'category_id' => $this->input->get('category_id'),
			'order_source' => $this->input->get('order_source'),
			'status_label' => $this->input->get('status_label'),
			'date_from' => $this->input->get('date_from'),
			'date_to' => $this->input->get('date_to'),
			'search' => $this->input->get('q'),
			'show_future' => 1
		];

		$result = $this->model_crm->get_journal_entries($filters, 10000, 0);

		$this->data['rows'] = $result['rows'];
		$this->load->library('HtmlPdf');
		$this->htmlpdf->initialize(['orientation' => 'L', 'format' => 'A4', 'marges' => [5, 5, 5, 5]]);
		$content = $this->load->view('backend/standart/administrator/crm/crm_journal_pdf', $this->data, true);
		$this->htmlpdf->writeHTML($content);
		$filename = 'CRM_Journal_FollowUp_' . date('Ymd_His') . '.pdf';
		if (ob_get_length()) { ob_clean(); }
		$this->htmlpdf->Output($filename, 'D');
	}

	public function export_journal_excel()
	{
		$filters = [
			'category_id' => $this->input->get('category_id'),
			'order_source' => $this->input->get('order_source'),
			'status_label' => $this->input->get('status_label'),
			'date_from' => $this->input->get('date_from'),
			'date_to' => $this->input->get('date_to'),
			'search' => $this->input->get('q'),
			'show_future' => 1
		];

		$result = $this->model_crm->get_journal_entries($filters, 10000, 0);

		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment; filename=CRM_Journal_FollowUp_' . date('Ymd_His') . '.xls');
		header('Cache-Control: max-age=0');

		echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
		echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
		echo '<style>';
		echo 'table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; font-size: 10pt; }';
		echo 'th { background-color: #1e293b; color: #ffffff; font-weight: bold; padding: 8px; border: 1px solid #000000; text-align: center; }';
		echo 'td { padding: 6px; border: 1px solid #cccccc; vertical-align: middle; }';
		echo '.txt { mso-number-format:"\@"; text-align: left; }';
		echo '.center { text-align: center; }';
		echo '</style></head><body>';
		echo '<h2>LAPORAN JOURNAL FOLLOW-UP CRM & AFTER SALES</h2>';
		echo '<p>Tanggal Ekspor: ' . date('d/m/Y H:i:s') . '</p>';
		echo '<table border="1">';
		echo '<thead><tr>';
		echo '<th>No</th><th>Customer</th><th>No. HP</th><th>No. Pesanan</th><th>Sumber</th><th>Kategori H+</th><th>Tgl Kirim</th><th>Target Label</th><th>Status</th><th>Broadcast Terkirim</th>';
		echo '</tr></thead><tbody>';

		$no = 1;
		foreach ($result['rows'] as $e) {
			$tgl_kirim = !empty($e->tanggal_pengiriman) ? date('d/m/Y', strtotime($e->tanggal_pengiriman)) : '-';
			$tgl_target = !empty($e->tanggal_label_muncul) ? date('d/m/Y', strtotime($e->tanggal_label_muncul)) : '-';

			echo '<tr>';
			echo '<td class="center">' . $no++ . '</td>';
			echo '<td>' . htmlspecialchars($e->customer_nama ?? '-') . '</td>';
			echo '<td class="txt">' . htmlspecialchars($e->customer_phone ?? '-') . '</td>';
			echo '<td class="txt">' . htmlspecialchars($e->no_pesanan ?? '-') . '</td>';
			echo '<td>' . htmlspecialchars($e->order_source ?: 'Direct') . '</td>';
			echo '<td>' . htmlspecialchars($e->nama_kategori ?? '-') . '</td>';
			echo '<td class="txt center">' . $tgl_kirim . '</td>';
			echo '<td class="txt center">' . $tgl_target . '</td>';
			echo '<td class="center">' . htmlspecialchars($e->status_label ?? 'Pending') . '</td>';
			echo '<td class="center">' . ($e->is_broadcast_sent ? 'Ya' : 'Belum') . '</td>';
			echo '</tr>';
		}

		echo '</tbody></table></body></html>';
		exit;
	}

	// ===== MODUL OTOMASI CRM (CLI & WEB) =====

	public function automation($offset = 0)
	{
		return $this->automations($offset);
	}

	public function automations($offset = 0)
	{
		$this->data['logs'] = $this->model_crm->get_automation_logs(50, $offset);
		$this->template->title('CRM — Otomasi & Monitoring Log');
		$this->render('backend/standart/administrator/crm/crm_automations', $this->data);
	}

	public function run_automations_ajax()
	{
		header('Content-Type: application/json');
		$user = get_user_data('username') ?: 'web_admin';
		$result = $this->model_crm->run_all_automations('web_manual', $user);
		echo json_encode($result);
	}

	public function cli_automations()
	{
		// Allow running via CLI command or Web CRON
		$user = is_cli() ? 'cli_cron' : (get_user_data('username') ?: 'web_cron');
		$result = $this->model_crm->run_all_automations(is_cli() ? 'cli_cron' : 'web_manual', $user);
		
		if (is_cli()) {
			echo "=== CRM AUTOMATIONS COMPLETED ===\n";
			echo "Total Affected Records: {$result['total_affected']}\n";
			echo "1. Overdue Updates: {$result['overdue']['count']}\n";
			echo "2. Cancellations: {$result['cancellations']['count']}\n";
			echo "3. Multi-Product Repeat Bundles: {$result['bundles']['count']}\n";
			echo "4. 14-Day Conversions: {$result['conversions']['count']} (Rp " . number_format($result['conversions']['amount'], 0, ',', '.') . ")\n";
		} else {
			echo json_encode($result);
		}
	}

	public function get_notes_ajax()
	{
		header('Content-Type: application/json');
		$label_id = $this->input->get('label_id');
		$notes = $this->model_crm->get_notes($label_id);
		$wa_logs = $this->db->where('followup_label_id', $label_id)->order_by('waktu_kirim', 'DESC')->get('crm_broadcast_logs')->result();
		echo json_encode(['success' => true, 'notes' => $notes, 'wa_logs' => $wa_logs]);
	}

	// ===== MODUL ANALITIK KINERJA & KONVERSI TIM CS =====

	public function cs_performance()
	{
		$filters = [
			'date_from' => $this->input->get('date_from'),
			'date_to' => $this->input->get('date_to'),
		];

		$this->data['filters'] = $filters;
		$this->data['report'] = $this->model_crm->get_cs_performance_report($filters);
		$this->data['kpis'] = $this->model_crm->get_cs_performance_kpis($filters);

		$this->template->title('CRM — Laporan Kinerja & Konversi Tim CS');
		$this->render('backend/standart/administrator/crm/crm_cs_performance', $this->data);
	}

	public function export_cs_performance()
	{
		$filters = [
			'date_from' => $this->input->get('date_from'),
			'date_to' => $this->input->get('date_to'),
		];

		$report = $this->model_crm->get_cs_performance_report($filters);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=CRM_Kinerja_Tim_CS_' . date('Ymd_His') . '.csv');
		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fwrite($output, "sep=;\n");
		fputcsv($output, ['Ranking', 'Username CS / Operator', 'Total Follow-Up Handled', 'Broadcast WA Terkirim', 'Respon Positif', 'Komplain Handled', 'Total Konversi Repeat Order', 'Total Omset Konversi (Rp)', 'Conversion Rate (%)'], ';');

		$no = 1;
		foreach ($report as $r) {
			fputcsv($output, [
				$no++,
				$r->cs_name,
				$r->total_handled,
				$r->broadcast_count,
				$r->respon_positif,
				$r->komplain_count,
				$r->conversion_count,
				$r->conversion_amount,
				$r->conversion_rate . '%'
			], ';');
		}
		fclose($output);
		exit;
	}

	public function export_cs_performance_pdf()
	{
		$filters = [
			'date_from' => $this->input->get('date_from'),
			'date_to' => $this->input->get('date_to'),
		];

		$this->data['report'] = $this->model_crm->get_cs_performance_report($filters);

		$this->load->library('HtmlPdf');
		$this->htmlpdf->initialize(['orientation' => 'L', 'format' => 'A4', 'marges' => [5, 5, 5, 5]]);
		$content = $this->load->view('backend/standart/administrator/crm/crm_cs_performance_pdf', $this->data, true);
		$this->htmlpdf->writeHTML($content);
		$filename = 'CRM_Kinerja_Tim_CS_' . date('Ymd_His') . '.pdf';
		if (ob_get_length()) { ob_clean(); }
		$this->htmlpdf->Output($filename, 'D');
	}

	// ===== WEBHOOK RECEIVERS (Fonnte & WAHA) =====

	/**
	 * Fonnte Webhook Receiver
	 * Fonnte sends: sender, message, name, device, url, member
	 */
	public function fonnte_webhook()
	{
		header('Content-Type: application/json');

		$raw  = file_get_contents('php://input');
		$json = json_decode($raw, true);
		if (!is_array($json)) {
			$json = [];
		}

		// Debug log: simpan semua request masuk ke file untuk troubleshooting
		$log_data = date('Y-m-d H:i:s') . " | IP: " . $this->input->ip_address()
			. " | METHOD: " . $this->input->method(TRUE)
			. " | RAW: " . $raw
			. " | POST: " . json_encode($_POST)
			. " | GET: " . json_encode($_GET)
			. "\n";
		$log_path = APPPATH . 'logs/fonnte_webhook_debug.log';
		@file_put_contents($log_path, $log_data, FILE_APPEND);

		// Extract sender
		$sender = '';
		if ($this->input->post('sender')) {
			$sender = $this->input->post('sender');
		} elseif ($this->input->get('sender')) {
			$sender = $this->input->get('sender');
		} elseif (isset($json['sender'])) {
			$sender = $json['sender'];
		} elseif (isset($json['from'])) {
			$sender = $json['from'];
		} elseif (isset($json['phone'])) {
			$sender = $json['phone'];
		} elseif (isset($json['wa_number'])) {
			$sender = $json['wa_number'];
		}
		$sender = trim($sender);

		// Extract message or caption
		$message = '';
		if ($this->input->post('message')) {
			$message = $this->input->post('message');
		} elseif ($this->input->get('message')) {
			$message = $this->input->get('message');
		} elseif (isset($json['message'])) {
			$message = $json['message'];
		} elseif (isset($json['body'])) {
			$message = $json['body'];
		} elseif (isset($json['text'])) {
			$message = $json['text'];
		} elseif (isset($json['caption'])) {
			$message = $json['caption'];
		}
		$message = trim($message);

		// Extract media / document URL if present (Fonnte photo/document payload)
		$media_url = '';
		if ($this->input->post('url')) {
			$media_url = $this->input->post('url');
		} elseif ($this->input->get('url')) {
			$media_url = $this->input->get('url');
		} elseif (isset($json['url'])) {
			$media_url = $json['url'];
		} elseif (isset($json['file'])) {
			$media_url = $json['file'];
		} elseif (isset($json['filename'])) {
			$media_url = $json['filename'];
		}
		$media_url = trim($media_url);

		// Extract mimetype from Fonnte payload for better media type detection
		$mimetype = '';
		if ($this->input->post('mimetype')) {
			$mimetype = $this->input->post('mimetype');
		} elseif (isset($json['mimetype'])) {
			$mimetype = $json['mimetype'];
		} elseif (isset($json['type'])) {
			$mimetype = $json['type'];
		} elseif (isset($json['content_type'])) {
			$mimetype = $json['content_type'];
		} elseif (isset($json['media_type'])) {
			$mimetype = $json['media_type'];
		}
		$mimetype = strtolower(trim($mimetype));

		// Determine media label based on mimetype or file extension
		if (!empty($media_url)) {
			$ext = strtolower(pathinfo(parse_url($media_url, PHP_URL_PATH), PATHINFO_EXTENSION));
			$media_label = '[Lampiran File]';

			if (strpos($mimetype, 'image') !== false || in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'])) {
				$media_label = '[Foto]';
			} elseif (strpos($mimetype, 'video') !== false || in_array($ext, ['mp4', 'avi', 'mov', 'mkv', '3gp', 'webm'])) {
				$media_label = '[Video]';
			} elseif (strpos($mimetype, 'audio') !== false || strpos($mimetype, 'ogg') !== false || in_array($ext, ['mp3', 'ogg', 'wav', 'm4a', 'aac', 'opus', 'amr', 'webm', '3gp'])) {
				$media_label = '[Dokumen]';
			} elseif (strpos($mimetype, 'pdf') !== false || in_array($ext, ['pdf'])) {
				$media_label = '[Dokumen PDF]';
			} elseif (strpos($mimetype, 'document') !== false || strpos($mimetype, 'word') !== false || strpos($mimetype, 'spreadsheet') !== false || strpos($mimetype, 'excel') !== false || in_array($ext, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'csv', 'txt'])) {
				$media_label = '[Dokumen]';
			} elseif (strpos($mimetype, 'zip') !== false || strpos($mimetype, 'rar') !== false || in_array($ext, ['zip', 'rar', '7z', 'tar', 'gz'])) {
				$media_label = '[Dokumen Arsip]';
			}

			if (empty($message)) {
				$message = $media_label . ': ' . $media_url;
			} elseif (strpos($message, $media_url) === false) {
				$message .= "\n\n" . $media_label . ': ' . $media_url;
			}
		}

		// Extract name
		$name = '';
		if ($this->input->post('name')) {
			$name = $this->input->post('name');
		} elseif ($this->input->get('name')) {
			$name = $this->input->get('name');
		} elseif (isset($json['name'])) {
			$name = $json['name'];
		} elseif (isset($json['pushname'])) {
			$name = $json['pushname'];
		} elseif (isset($json['sender_name'])) {
			$name = $json['sender_name'];
		}
		$name = trim($name);

		if (empty($sender) || empty($message)) {
			echo json_encode([
				'success' => true,
				'message' => 'Fonnte webhook endpoint is ready and active',
				'received' => [
					'sender' => $sender,
					'message' => $message,
					'name' => $name,
					'url' => $media_url
				]
			]);
			return;
		}

		// Skip outgoing message echoes sent by Fonnte / system
		$location  = strtolower($this->input->post('location') ?: (isset($json['location']) ? $json['location'] : ''));
		$direction = strtolower($this->input->post('direction') ?: (isset($json['direction']) ? $json['direction'] : ''));
		$from_me   = $this->input->post('from_me') ?: (isset($json['from_me']) ? $json['from_me'] : null);

		if (
			in_array($location, ['outgoing', 'device', 'sent', 'out']) ||
			in_array($direction, ['outgoing', 'sent', 'out']) ||
			$from_me === true || $from_me === 1 || $from_me === '1' || $from_me === 'true' ||
			stripos($message, 'Sent via fonnte.com') !== false ||
			stripos($message, 'fonnte.com') !== false
		) {
			echo json_encode(['success' => true, 'message' => 'Outgoing message echo skipped', 'skipped' => true]);
			return;
		}

		// Skip group messages (Fonnte group chats contain @g.us or hyphens in ID)
		if (strpos($sender, '@g.us') !== false || (strpos($sender, '-') !== false && strlen($sender) > 15)) {
			echo json_encode(['success' => true, 'message' => 'group message skipped']);
			return;
		}

		$count = $this->model_crm->log_incoming_reply($sender, $message, $name, $raw);

		echo json_encode([
			'success' => true,
			'message' => 'Berhasil memproses balasan pesan WhatsApp dari ' . $sender,
			'logged' => $count
		]);
	}

	/**
	 * AJAX endpoint to simulate incoming customer WhatsApp reply on local environment
	 */
	public function simulate_customer_reply_ajax()
	{
		header('Content-Type: application/json');
		$phone   = trim($this->input->post('phone') ?: ($this->input->get('phone') ?: ''));
		$message = trim($this->input->post('message') ?: ($this->input->get('message') ?: ''));
		$name    = trim($this->input->post('name') ?: ($this->input->get('name') ?: 'Customer'));

		if (empty($phone) || empty($message)) {
			echo json_encode(['success' => false, 'message' => 'Nomor HP dan isi balasan pesan tidak boleh kosong']);
			return;
		}

		$count = $this->model_crm->log_incoming_reply($phone, $message, $name);

		echo json_encode([
			'success' => true,
			'message' => "Simulasi Webhook Sukses: Berhasil mencatat balasan customer dari {$phone}!",
			'logged' => $count
		]);
	}

	/**
	 * WAHA Webhook Receiver
	 * WAHA sends JSON: { event: "message", payload: { from, body, notifyName, ... } }
	 */
	public function waha_webhook()
	{
		header('Content-Type: application/json');

		$raw = file_get_contents('php://input');
		$json = json_decode($raw, true);

		if (empty($json) || empty($json['event'])) {
			echo json_encode(['success' => false, 'message' => 'Invalid WAHA payload']);
			return;
		}

		// Only process incoming messages (not status updates)
		if ($json['event'] !== 'message' && $json['event'] !== 'message.any') {
			echo json_encode(['success' => true, 'message' => 'Event skipped: ' . $json['event']]);
			return;
		}

		$payload = $json['payload'] ?? [];

		// Skip outgoing message echo
		$from_me = $payload['fromMe'] ?? false;
		if ($from_me === true || $from_me === 'true' || $from_me === 1) {
			echo json_encode(['success' => true, 'message' => 'Outgoing message echo skipped', 'skipped' => true]);
			return;
		}

		$from    = trim($payload['from'] ?? '');
		$body    = trim($payload['body'] ?? '');
		$name    = trim($payload['pushName'] ?? ($payload['notifyName'] ?? ($payload['_data']['notifyName'] ?? '')));
		$session = trim($json['session'] ?? 'default');

		// Ignore channels, broadcasts, newsletter, and excluded bot groups
		if (empty($from) 
			|| strpos($from, '@newsletter') !== false 
			|| strpos($from, '@broadcast') !== false 
			|| $from === '0@c.us'
			|| strpos($from, '120363413453996264') !== false
			|| strpos($from, '120363423301242522') !== false
			|| stripos($name, 'asikn') !== false) {
			echo json_encode(['success' => true, 'message' => 'Broadcast/Newsletter/Status skipped', 'skipped' => true]);
			return;
		}

		// Handle media in incoming message (photos, documents, videos, audio, etc)
		if (!empty($payload['hasMedia'])) {
			$media_info = $this->model_crm->save_inbound_waha_media($payload, $session);
			if ($media_info) {
				$m_label = $media_info['label'];
				$m_url   = $media_info['url'];
				$caption = !empty($body) ? trim($body) : '';

				if (!empty($m_url)) {
					if (empty($caption)) {
						$body = $m_label . ': ' . $m_url;
					} else {
						$body = $caption . "\n\n" . $m_label . ': ' . $m_url;
					}
				} else {
					$body = $m_label . (!empty($caption) ? ' ' . $caption : '');
				}
			}
		}

		$is_group = (strpos($from, '@g.us') !== false);
		if ($is_group) {
			// Prepend sender name for group chat
			if (!empty($name) && strpos($body, "*{$name}*:") === false) {
				$body = "*{$name}*: " . $body;
			}
		} else {
			// Resolve WhatsApp LID (Linked Identity) to canonical phone number
			$resolved = $this->model_crm->resolve_waha_sender_phone($from, $payload, $session);
			$from = $resolved['phone'];
			if (empty($name) && !empty($resolved['name'])) {
				$name = $resolved['name'];
			}
			// Remove any remaining suffixes
			$from = preg_replace('/@(c\.us|lid|s\.whatsapp\.net)$/', '', $from);
		}

		if (empty($from) || empty($body)) {
			echo json_encode(['success' => false, 'message' => 'from or body is empty']);
			return;
		}

		$count = $this->model_crm->log_incoming_reply($from, $body, $name, $raw);

		echo json_encode([
			'success' => true,
			'message' => "Logged {$count} label(s) for WAHA reply from {$from}",
			'logged' => $count
		]);
	}

	/**
	 * Get live WAHA status and session state
	 */
	public function waha_status_ajax()
	{
		header('Content-Type: application/json');
		$config = $this->model_crm->get_wa_gateway_config();
		$base_url = rtrim($config->api_url ?: 'http://localhost:3000', '/');
		$api_key = $config->api_key ?: '';

		$ch = curl_init($base_url . '/api/sessions');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		if (!empty($api_key)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['x-api-key: ' . $api_key]);
		}
		$res = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);

		if ($err || empty($res)) {
			echo json_encode(['success' => false, 'status' => 'OFFLINE', 'message' => 'WhatsApp belum aktif di ' . $base_url]);
			return;
		}

		$sessions = json_decode($res, true);
		$default_session = null;
		if (is_array($sessions)) {
			foreach ($sessions as $s) {
				if (($s['name'] ?? '') === 'default') {
					$default_session = $s;
					break;
				}
			}
		}

		$status = $default_session['status'] ?? 'STOPPED';

		echo json_encode([
			'success' => true,
			'status' => $status,
			'session' => $default_session,
			'qr_url' => base_url('administrator/crm/waha_qr_image?t=' . time())
		]);
	}

	/**
	 * Proxy WAHA live QR code image directly to the browser
	 */
	public function waha_qr_image()
	{
		$config = $this->model_crm->get_wa_gateway_config();
		$base_url = rtrim($config->api_url ?: 'http://localhost:3000', '/');
		$api_key = $config->api_key ?: '';

		$ch = curl_init($base_url . '/api/default/auth/qr');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		if (!empty($api_key)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['x-api-key: ' . $api_key]);
		}
		$img = curl_exec($ch);
		$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($http_code === 200 && strpos($content_type, 'image') !== false) {
			header('Content-Type: image/png');
			echo $img;
		} else {
			header('Content-Type: image/png');
			$fallback = FCPATH . 'uploads/waha_qr.png';
			if (file_exists($fallback)) {
				readfile($fallback);
			}
		}
	}

	/**
	 * Restart WAHA session (generate fresh QR code)
	 */
	public function waha_restart_session_ajax()
	{
		header('Content-Type: application/json');
		$config = $this->model_crm->get_wa_gateway_config();
		$base_url = rtrim($config->api_url ?: 'http://localhost:3000', '/');
		$api_key = $config->api_key ?: '';

		$ch = curl_init($base_url . '/api/sessions/default/restart');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 6);
		if (!empty($api_key)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['x-api-key: ' . $api_key, 'Content-Type: application/json']);
		}
		$res = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);

		if ($err) {
			echo json_encode(['success' => false, 'message' => 'cURL Error: ' . $err]);
			return;
		}

		echo json_encode(['success' => true, 'message' => 'Session default berhasil di-restart, memuat QR code baru...', 'data' => json_decode($res, true)]);
	}

	/**
	 * Sync chats and message history from WAHA /api/default/chats into CRM
	 */
	public function sync_waha_chats_ajax()
	{
		header('Content-Type: application/json');
		$config = $this->model_crm->get_wa_gateway_config();
		$base_url = rtrim($config->api_url ?: 'http://localhost:3000', '/');
		$api_key = $config->api_key ?: '';

		// 1. Fetch chats from WAHA
		$ch = curl_init($base_url . '/api/default/chats');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		if (!empty($api_key)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['x-api-key: ' . $api_key]);
		}
		$res = curl_exec($ch);
		$err = curl_error($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($err || $http_code >= 400 || empty($res)) {
			$json_err = json_decode($res, true);
			$msg = $json_err['error'] ?? ($json_err['message'] ?? 'Device WAHA belum terhubung (silakan scan QR terlebih dahulu)');
			echo json_encode(['success' => false, 'message' => $msg]);
			return;
		}

		$chats = json_decode($res, true);
		if (!is_array($chats)) {
			echo json_encode(['success' => false, 'message' => 'Format balasan chats tidak valid']);
			return;
		}

		// 2. Fetch contacts map for rich names
		$contacts_map = [];
		$ch_c = curl_init($base_url . '/api/contacts/all?session=default');
		curl_setopt($ch_c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch_c, CURLOPT_TIMEOUT, 8);
		if (!empty($api_key)) {
			curl_setopt($ch_c, CURLOPT_HTTPHEADER, ['x-api-key: ' . $api_key]);
		}
		$res_c = curl_exec($ch_c);
		curl_close($ch_c);
		$contacts_arr = json_decode($res_c, true);
		if (is_array($contacts_arr)) {
			foreach ($contacts_arr as $ct) {
				$c_num = $ct['number'] ?? '';
				$c_push = trim($ct['pushname'] ?? ($ct['name'] ?? ''));
				if (!empty($c_num) && !empty($c_push)) {
					$contacts_map[$c_num] = $c_push;
				}
			}
		}

		$synced_labels = 0;
		$synced_messages = 0;
		$now = date('Y-m-d H:i:s');

		$cat = $this->db->query("SELECT id FROM crm_followup_categories WHERE is_active = 1 ORDER BY urutan ASC LIMIT 1")->row();
		$default_cat_id = $cat ? $cat->id : 1;

		foreach ($chats as $c) {
			$raw_id = $c['id'] ?? '';
			$chat_serialized = is_array($raw_id) ? ($raw_id['_serialized'] ?? '') : (string)$raw_id;

			$name = trim($c['name'] ?? '');

			// Skip broadcast channels, newsletters, system contacts, and excluded bot groups
			if (empty($chat_serialized) 
				|| strpos($chat_serialized, '@newsletter') !== false 
				|| strpos($chat_serialized, '@broadcast') !== false 
				|| $chat_serialized === '0@c.us'
				|| strpos($chat_serialized, '120363413453996264') !== false
				|| strpos($chat_serialized, '120363423301242522') !== false
				|| stripos($name, 'asikn') !== false) {
				continue;
			}

			$is_group = !empty($c['isGroup']) || strpos($chat_serialized, '@g.us') !== false;
			$phone = '';

			// If name is phone number
			if (preg_match('/\+?[0-9\s\-]{8,}/', $name, $matches)) {
				$extracted = preg_replace('/[^0-9]/', '', $matches[0]);
				if (strlen($extracted) >= 9) {
					$phone = $extracted;
					if (substr($phone, 0, 1) === '0') $phone = '62' . substr($phone, 1);
				}
			}

			// If still no phone, check user part of id
			if (empty($phone) && is_array($raw_id) && !empty($raw_id['user']) && is_numeric($raw_id['user']) && strlen($raw_id['user']) >= 9 && strlen($raw_id['user']) <= 15) {
				$phone = $raw_id['user'];
				if (substr($phone, 0, 1) === '0') $phone = '62' . substr($phone, 1);
			}

			// If still no phone, check lastMessage
			if (empty($phone)) {
				if ($is_group) {
					$phone = $chat_serialized;
				} else {
					$lm_from = is_array($c['lastMessage']['from'] ?? null) ? ($c['lastMessage']['from']['_serialized'] ?? '') : ($c['lastMessage']['from'] ?? '');
					$lm_to = is_array($c['lastMessage']['to'] ?? null) ? ($c['lastMessage']['to']['_serialized'] ?? '') : ($c['lastMessage']['to'] ?? '');
					$candidate = (!empty($c['lastMessage']['fromMe'])) ? $lm_to : $lm_from;
					$clean_c = preg_replace('/[^0-9]/', '', explode('@', $candidate)[0]);
					if (strlen($clean_c) >= 9 && strlen($clean_c) <= 15) {
						$phone = $clean_c;
					} else {
						$phone = $chat_serialized;
					}
				}
			}

			// Enrich name from contacts_map if available
			if (!empty($phone) && isset($contacts_map[$phone]) && (empty($name) || preg_match('/^[0-9\+\-\s]+$/', $name))) {
				$name = $contacts_map[$phone];
			}

			if (empty($name)) {
				$name = $is_group ? 'WA Group' : ('Customer ' . substr($phone, -4));
			}

			$last_time = !empty($c['timestamp']) ? date('Y-m-d H:i:s', $c['timestamp']) : $now;

			// Find existing label (prefer most recent)
			if ($is_group) {
				$label = $this->db->query("SELECT id FROM crm_transaction_followup_labels WHERE customer_phone = ? ORDER BY id DESC LIMIT 1", [$phone])->row();
			} else {
				$tail = strlen($phone) >= 9 ? substr($phone, -9) : $phone;
				$label = $this->db->query("SELECT id FROM crm_transaction_followup_labels WHERE customer_phone = ? OR (LENGTH(customer_phone) >= 9 AND RIGHT(customer_phone, 9) = ?) ORDER BY id DESC LIMIT 1", [$phone, $tail])->row();
			}

			$label_id = null;
			if ($label) {
				$label_id = $label->id;
				$update_data = ['updated_at' => $last_time];
				if (!empty($name) && $name !== 'Customer') {
					$update_data['customer_nama'] = $name;
				}
				$this->db->where('id', $label_id)->update('crm_transaction_followup_labels', $update_data);
			} else {
				$this->db->insert('crm_transaction_followup_labels', [
					'order_source' => $is_group ? 'WA Group' : 'WhatsApp Live',
					'order_id' => 0,
					'order_table' => 'waha_direct',
					'customer_nama' => $name,
					'customer_phone' => $phone,
					'no_pesanan' => $is_group ? 'GROUP' : 'WAHA-LIVE',
					'tanggal_pengiriman' => date('Y-m-d'),
					'followup_category_id' => $default_cat_id,
					'tanggal_label_muncul' => date('Y-m-d'),
					'status_label' => 'Direspon',
					'handled_by' => 'system',
					'created_at' => $last_time,
					'updated_at' => $last_time,
				]);
				$label_id = $this->db->insert_id();
				$synced_labels++;
			}

			// 3. Fetch conversation messages
			if (!empty($chat_serialized)) {
				$enc_chat_id = urlencode($chat_serialized);
				$ch_m = curl_init($base_url . "/api/default/chats/{$enc_chat_id}/messages?limit=25");
				curl_setopt($ch_m, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch_m, CURLOPT_TIMEOUT, 5);
				if (!empty($api_key)) {
					curl_setopt($ch_m, CURLOPT_HTTPHEADER, ['x-api-key: ' . $api_key]);
				}
				$m_res = curl_exec($ch_m);
				curl_close($ch_m);

				$messages = json_decode($m_res, true);
				if (is_array($messages)) {
					usort($messages, function($a, $b) {
						return ($a['timestamp'] ?? 0) - ($b['timestamp'] ?? 0);
					});

					foreach ($messages as $m) {
						$m_body = trim($m['body'] ?? '');
						if (empty($m_body) && !empty($m['hasMedia'])) {
							$m_body = '[Media / Gambar / Lampiran]';
						} elseif (empty($m_body)) {
							continue;
						}

						$m_time = !empty($m['timestamp']) ? date('Y-m-d H:i:s', $m['timestamp']) : $now;
						$m_dir = !empty($m['fromMe']) ? 'out' : 'in';
						$sender = $m_dir === 'out' ? 'administrator' : $name;

						$exist_msg = $this->db->query("SELECT id FROM crm_chat_history WHERE label_id = ? AND message = ? AND created_at = ? LIMIT 1", [
							$label_id, $m_body, $m_time
						])->row();

						if (!$exist_msg) {
							$this->db->insert('crm_chat_history', [
								'label_id' => $label_id,
								'customer_phone' => $phone,
								'direction' => $m_dir,
								'message' => $m_body,
								'sender_name' => $m_dir === 'in' ? $sender : null,
								'sender_cs_name' => $m_dir === 'out' ? 'administrator' : null,
								'is_internal_note' => 0,
								'status' => 'read',
								'created_at' => $m_time,
							]);
							$synced_messages++;
						}
					}
				}
			}
		}

		echo json_encode([
			'success' => true,
			'message' => "Berhasil menyinkronkan data WhatsApp! ({$synced_labels} kontak baru, {$synced_messages} pesan tersinkron)",
			'count' => $synced_labels,
			'messages_count' => $synced_messages
		]);
	}

	// ===== CHAT TIMELINE AJAX =====

	/**
	 * Get conversation list for sidebar (Supports instant search & full list reload)
	 */
	public function get_conversations_ajax()
	{
		header('Content-Type: application/json');
		$search = trim((string)$this->input->get('q'));
		$conversations = $this->model_crm->get_all_chat_conversations($search);
		echo json_encode([
			'success' => true,
			'conversations' => $conversations,
			'count' => count($conversations)
		], JSON_UNESCAPED_UNICODE);
	}

	/**
	 * Get unified 2-way chat timeline for a label
	 */
	public function get_chat_timeline_ajax()
	{
		header('Content-Type: application/json');
		$label_id = $this->input->get('label_id');
		if (!$label_id) {
			echo json_encode(['success' => false, 'message' => 'label_id required']);
			return;
		}

		$label = $this->model_crm->get_label($label_id);
		if (!$label) {
			echo json_encode(['success' => false, 'message' => 'Label not found']);
			return;
		}

		$timeline = $this->model_crm->get_chat_timeline($label_id);

		// Calculate max chat_history ID for accurate client cursor tracking
		$max_id = 0;
		if (!empty($timeline)) {
			foreach ($timeline as $t) {
				if ((int)$t['id'] > $max_id) $max_id = (int)$t['id'];
			}
		}

		// Mark incoming messages for this customer (and related labels) as read
		if ($this->db->table_exists('crm_chat_history')) {
			$rel_ids = $this->model_crm->get_related_label_ids($label);
			$this->db->where_in('label_id', $rel_ids)
				->where('direction', 'in')
				->where('status !=', 'read')
				->update('crm_chat_history', ['status' => 'read']);

			// Double check absolute max ID in crm_chat_history for related labels
			$clean_phone = $this->model_crm->normalize_phone_number($label->customer_phone);
			$phone_tail = strlen($clean_phone) >= 9 ? substr($clean_phone, -9) : $clean_phone;
			$this->db->select_max('id', 'max_id')->from('crm_chat_history');
			$this->db->group_start();
			if (!empty($rel_ids)) {
				$this->db->where_in('label_id', $rel_ids);
			}
			if (strpos($label->customer_phone, '@') !== false) {
				$this->db->or_where('customer_phone', $label->customer_phone);
			} elseif (!empty($phone_tail)) {
				$this->db->or_like('customer_phone', $phone_tail);
			}
			$this->db->group_end();
			$row_max = $this->db->get()->row();
			if ($row_max && (int)$row_max->max_id > $max_id) {
				$max_id = (int)$row_max->max_id;
			}
		}

		echo json_encode([
			'success' => true,
			'label' => [
				'id' => $label->id,
				'customer_nama' => $label->customer_nama,
				'customer_phone' => $label->customer_phone,
				'no_pesanan' => $label->no_pesanan,
				'order_source' => $label->order_source,
				'status_label' => $label->status_label,
			],
			'timeline' => $timeline,
			'count' => count($timeline),
			'max_id' => $max_id
		], JSON_UNESCAPED_UNICODE);
	}

	/**
	 * Mark notification(s) as read when clicked
	 * Accepts: chat_id (single), label_id (all for that label), or mark_all=1
	 */
	public function mark_notification_read_ajax()
	{
		header('Content-Type: application/json');

		$chat_id  = (int)($this->input->post('chat_id') ?: $this->input->get('chat_id') ?: 0);
		$label_id = (int)($this->input->post('label_id') ?: $this->input->get('label_id') ?: 0);
		$mark_all = (int)($this->input->post('mark_all') ?: $this->input->get('mark_all') ?: 0);

		if (!$this->db->table_exists('crm_chat_history')) {
			echo json_encode(['success' => false, 'message' => 'Table not found']);
			return;
		}

		$affected = 0;

		if ($chat_id > 0) {
			// Mark single message as read
			$this->db->where('id', $chat_id)
				->where('direction', 'in')
				->where('status !=', 'read')
				->update('crm_chat_history', ['status' => 'read']);
			$affected = $this->db->affected_rows();
		} elseif ($label_id > 0) {
			// Mark all incoming messages for this label as read
			$this->db->where('label_id', $label_id)
				->where('direction', 'in')
				->where('status !=', 'read')
				->update('crm_chat_history', ['status' => 'read']);
			$affected = $this->db->affected_rows();
		} elseif ($mark_all) {
			// Mark ALL unread incoming messages as read
			$this->db->where('direction', 'in')
				->where('status !=', 'read')
				->update('crm_chat_history', ['status' => 'read']);
			$affected = $this->db->affected_rows();
		}

		echo json_encode([
			'success' => true,
			'affected' => $affected,
			'message' => $affected . ' notifikasi ditandai sudah dibaca'
		]);
	}

	/**
	 * Dedicated endpoint: Send chat message from CS to customer
	 * Supports: WA Reply (via Fonnte API) and Internal Note
	 */
	public function send_message_ajax()

	{
		header('Content-Type: application/json');
		$label_id = $this->input->post('label_id');
		$message = trim($this->input->post('message') ?: '');
		$file_url = trim($this->input->post('file_url') ?: '');
		$is_internal_note = (int)($this->input->post('is_internal_note') ?: 0);

		// Validasi: harus ada pesan ATAU file
		if (empty($message) && empty($file_url)) {
			echo json_encode(['success' => false, 'message' => 'Label ID dan pesan atau file attachment tidak boleh kosong'], JSON_UNESCAPED_UNICODE);
			return;
		}

		if (!$label_id) {
			echo json_encode(['success' => false, 'message' => 'Label ID tidak boleh kosong'], JSON_UNESCAPED_UNICODE);
			return;
		}

		$label = $this->model_crm->get_label($label_id);
		if (!$label) {
			echo json_encode(['success' => false, 'message' => 'Label follow-up tidak ditemukan']);
			return;
		}

		$username = 'administrator';
		if (function_exists('get_user_data')) {
			$u = get_user_data('username');
			if (!empty($u)) $username = $u;
		}

		$customer_phone = $this->model_crm->normalize_phone_number($label->customer_phone);
		$api_result = null;
		$chat_status = 'sent';
		$fonnte_response = null;

		// ---- Build message for LOCAL save (display di chat bubble) ----
		// Teks caption asli user + info lampiran file (untuk tampilan di CRM saja)
		$message_to_save = $message;
		if (!empty($file_url)) {
			$ext = strtolower(pathinfo(parse_url($file_url, PHP_URL_PATH), PATHINFO_EXTENSION));
			if (in_array($ext, ['mp3', 'ogg', 'wav', 'm4a', 'aac', 'opus', 'webm', '3gp', 'amr']) || strpos($file_url, 'voice') !== false || strpos($file_url, 'audio') !== false) {
				$file_label = '[Dokumen]';
			} elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'])) {
				$file_label = '[Foto]';
			} elseif (in_array($ext, ['mp4', 'avi', 'mov', 'mkv', 'webm'])) {
				$file_label = '[Video]';
			} else {
				$file_label = '[Dokumen]';
			}

			if (empty($message_to_save)) {
				$message_to_save = $file_label . ': ' . $file_url;
			} elseif (strpos($message_to_save, $file_url) === false) {
				$message_to_save .= "\n\n" . $file_label . ': ' . $file_url;
			}
		}

		// ---- Build message for FONNTE API (kirim ke WhatsApp) ----
		// Fonnte butuh: message = caption teks saja, url = link file terpisah
		// Jika hanya file tanpa caption, beri caption kosong '' agar Fonnte kirim sebagai media
		$message_for_api = $message; // Caption asli tanpa URL embed

		if ($is_internal_note) {
			// Internal note: DO NOT send to Fonnte, just save locally
			$chat_status = 'delivered'; // Internal notes are always "delivered" locally
		} else {
			// Send via Fonnte API
			$config = $this->model_crm->get_wa_gateway_config();
			if ($config->mode === 'wa_gateway') {
				$api_result = $this->model_crm->send_wa_via_api($label->customer_phone, $message_for_api, $file_url);
				$fonnte_response = json_encode($api_result);

				if ($api_result['success']) {
					$chat_status = 'sent';
					// Also log to legacy broadcast_logs for backward compat
					$this->model_crm->log_broadcast($label_id, $message_to_save, 'wa_gateway_api');
				} else {
					$chat_status = 'failed';
				}
			} else {
				// wa_direct mode: generate link, mark as sent
				$chat_status = 'sent';
				$this->model_crm->log_broadcast($label_id, $message_to_save, 'wa_direct_link');
			}
		}

		// Insert into crm_chat_history
		$chat_id = $this->model_crm->insert_chat_message([
			'label_id' => (int)$label_id,
			'customer_phone' => $customer_phone,
			'direction' => 'out',
			'message' => $message_to_save,
			'sender_cs_name' => $username,
			'is_internal_note' => $is_internal_note,
			'status' => $chat_status,
			'fonnte_response' => $fonnte_response,
		]);

		// Note: Pesan baru HANYA disimpan ke crm_chat_history.
		// Tidak perlu insert ke crm_followup_notes lagi agar tidak dobel di timeline.

		// Update label status & timestamp agar data tetap muncul paling atas di halaman journal
		if (!$is_internal_note) {
			$current_status = $label->status_label;
			if ($current_status === 'Pending') {
				$this->model_crm->update_label_status($label_id, 'Sudah Dikirim', $username);
			} else {
				// Tetap update updated_at agar data naik ke atas daftar setelah interaksi
				$this->db->where('id', $label_id)->update('crm_transaction_followup_labels', [
					'updated_at' => date('Y-m-d H:i:s'),
				]);
			}
		} else {
			// Internal note juga update timestamp agar data naik ke atas
			$this->db->where('id', $label_id)->update('crm_transaction_followup_labels', [
				'updated_at' => date('Y-m-d H:i:s'),
			]);
		}

		// Generate wa_link for wa_direct mode
		$wa_link = null;
		if (!$is_internal_note) {
			$config = $this->model_crm->get_wa_gateway_config();
			if ($config->mode !== 'wa_gateway') {
				$wa_link = $this->model_crm->generate_wa_link($label->customer_phone, $message);
			}
		}

		// Build response
		$response = [
			'success' => true,
			'chat_id' => (int)$chat_id,
			'is_internal_note' => $is_internal_note,
			'status' => $chat_status,
			'message' => 'Pesan berhasil disimpan',
		];

		if (!$is_internal_note && $api_result !== null) {
			$response['api_result'] = $api_result;
			if ($api_result['success']) {
				$response['message'] = 'Pesan WhatsApp berhasil terkirim via Fonnte API!';
			} else {
				$response['success'] = true; // Chat saved, but sending failed
				$response['message'] = 'Pesan tersimpan, tapi gagal terkirim via Fonnte: ' . ($api_result['message'] ?: 'Unknown error');
				$response['send_error'] = true;
			}
		} elseif (!$is_internal_note && $wa_link) {
			$response['wa_link'] = $wa_link;
			$response['message'] = 'Pesan tercatat. Silakan kirim via WhatsApp.';
		} elseif ($is_internal_note) {
			$response['message'] = 'Catatan internal berhasil disimpan.';
		}

		echo json_encode($response, JSON_UNESCAPED_UNICODE);
	}

	/**
	 * Optimized polling endpoint: Get only NEW messages after last_id
	 * Client sends last_id → server returns only newer messages
	 */
	public function get_new_messages_ajax()
	{
		header('Content-Type: application/json');
		$label_id = $this->input->get('label_id');
		$last_id = (int)($this->input->get('last_id') ?: 0);

		if (!$label_id) {
			echo json_encode(['success' => false, 'message' => 'label_id required']);
			return;
		}

		$label = $this->model_crm->get_label($label_id);
		if (!$label) {
			echo json_encode(['success' => false, 'message' => 'Label not found']);
			return;
		}

		// Polling endpoint requires a valid last_id cursor. If last_id <= 0, return empty to prevent returning historical chats
		if ($last_id <= 0) {
			echo json_encode([
				'success' => true,
				'messages' => [],
				'count' => 0,
				'label' => [
					'id' => $label->id,
					'customer_nama' => $label->customer_nama,
					'customer_phone' => $label->customer_phone,
					'no_pesanan' => $label->no_pesanan,
					'status_label' => $label->status_label,
				],
			], JSON_UNESCAPED_UNICODE);
			return;
		}

		$messages = $this->model_crm->get_new_messages($label_id, $last_id);

		// Mark incoming messages for this customer (and related labels) as read
		if (!empty($messages) && $this->db->table_exists('crm_chat_history')) {
			$rel_ids = $this->model_crm->get_related_label_ids($label);
			$this->db->where_in('label_id', $rel_ids)
				->where('direction', 'in')
				->where('status !=', 'read')
				->update('crm_chat_history', ['status' => 'read']);
		}

		echo json_encode([
			'success' => true,
			'messages' => $messages,
			'count' => count($messages),
			'label' => [
				'id' => $label->id,
				'customer_nama' => $label->customer_nama,
				'customer_phone' => $label->customer_phone,
				'no_pesanan' => $label->no_pesanan,
				'status_label' => $label->status_label,
			],
		], JSON_UNESCAPED_UNICODE);
	}

	public function get_new_messages()
	{
		return $this->get_new_messages_ajax();
	}

	/**
	 * Debug: Lihat 20 webhook log terakhir di database (untuk troubleshooting Fonnte)
	 */
	public function debug_webhook_logs()
	{
		header('Content-Type: application/json');
		$logs = $this->db->order_by('id', 'DESC')->limit(20)->get('crm_webhook_logs')->result();
		$chat_in = $this->db->where('direction', 'in')->order_by('id', 'DESC')->limit(20)->get('crm_chat_history')->result();
		echo json_encode([
			'webhook_logs_count' => count($logs),
			'webhook_logs' => $logs,
			'incoming_chats_count' => count($chat_in),
			'incoming_chats' => $chat_in,
			'server_time' => date('Y-m-d H:i:s'),
			'php_version' => PHP_VERSION,
		], JSON_PRETTY_PRINT);
	}
}
