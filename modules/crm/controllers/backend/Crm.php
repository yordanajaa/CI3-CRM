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
		$result = $this->model_crm->get_customers($filter, $this->limit_page, $offset);

		$this->data['customers'] = $result['rows'];
		$this->data['customer_counts'] = $result['total'];
		$this->data['filter'] = $filter;

		$config = [
			'base_url'    => 'administrator/crm/index/',
			'total_rows'  => $result['total'],
			'per_page'    => $this->limit_page,
			'uri_segment' => 4,
		];
		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('CRM — Customer Directory');
		$this->render('backend/standart/administrator/crm/crm_customer_list', $this->data);
	}

	public function customer_list($offset = 0)
	{
		return $this->index($offset);
	}

	public function customer_detail()
	{
		$phone = $this->input->get('phone');
		if (empty($phone)) {
			set_message('Nomor telepon customer tidak valid.', 'error');
			redirect('administrator/crm');
		}

		$this->data['summary'] = $this->model_crm->get_customer_summary($phone);
		$this->data['transactions'] = $this->model_crm->get_customer_transactions($phone);
		$this->data['phone'] = $phone;

		$this->template->title('CRM — Detail Customer');
		$this->render('backend/standart/administrator/crm/crm_customer_detail', $this->data);
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

	public function journal_followup($offset = 0)
	{
		$filters = [
			'category_id' => $this->input->get('category_id'),
			'order_source' => $this->input->get('order_source'),
			'status_label' => $this->input->get('status_label'),
			'date_from' => $this->input->get('date_from'),
			'date_to' => $this->input->get('date_to'),
			'search' => $this->input->get('q'),
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
		$allowed   = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', 'mp3', 'ogg', 'wav', 'm4a', 'aac', 'opus'];

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

	public function send_broadcast_ajax()
	{
		header('Content-Type: application/json');
		$label_ids = $this->input->post('label_ids');
		$custom_message = trim($this->input->post('custom_message') ?: '');

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

			if ($use_api) {
				$api_res = $this->model_crm->send_wa_via_api($label->customer_phone, $message);
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

		$filters = [
			'category_id' => $category_id,
			'order_source' => $order_source,
			'status_label' => 'Pending',
		];
		$result = $this->model_crm->get_journal_entries($filters, 200, 0);

		// Filter only non-broadcast-sent (FB-10)
		$recipients = [];
		foreach ($result['rows'] as $r) {
			if (!$r->is_broadcast_sent && !empty($r->customer_phone)) {
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
		$result = $this->model_crm->get_customers($filter, 10000, 0);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=CRM_Customer_Directory_' . date('Ymd_His') . '.csv');
		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fwrite($output, "sep=;\n");
		fputcsv($output, ['No', 'Nama Customer', 'No. HP', 'Sumber Penjualan', 'Total Order', 'Order Terakhir', 'Pending Followup'], ';');

		$no = 1;
		foreach ($result['rows'] as $c) {
			$phone = trim((string)$c->customer_phone);
			$phone_str = !empty($phone) ? '="' . $phone . '"' : '-';
			$last_date = !empty($c->last_order_date) ? '="' . date('d/m/Y', strtotime($c->last_order_date)) . '"' : '-';

			fputcsv($output, [
				$no++,
				$c->customer_nama,
				$phone_str,
				$c->sumber_penjualan ?: 'Direct',
				$c->total_orders,
				$last_date,
				$c->pending_followups
			], ';');
		}
		fclose($output);
		exit;
	}

	public function export_customers_pdf()
	{
		$filter = $this->input->get('q');
		$result = $this->model_crm->get_customers($filter, 10000, 0);

		$this->data['rows'] = $result['rows'];
		$this->load->library('HtmlPdf');
		$this->htmlpdf->initialize(['orientation' => 'P', 'format' => 'A4', 'marges' => [5, 5, 5, 5]]);
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

		if (empty($message) && !empty($media_url)) {
			$message = '[Lampiran Media/Dokumen]: ' . $media_url;
		} elseif (!empty($media_url) && strpos($message, $media_url) === false) {
			$message .= "\n\n[Lampiran File]: " . $media_url;
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
		if ($json['event'] !== 'message') {
			echo json_encode(['success' => true, 'message' => 'Event skipped: ' . $json['event']]);
			return;
		}

		$payload = $json['payload'] ?? [];
		$from    = trim($payload['from'] ?? '');
		$body    = trim($payload['body'] ?? '');
		$name    = trim($payload['notifyName'] ?? ($payload['_data']['notifyName'] ?? ''));

		// Skip group messages
		if (strpos($from, '@g.us') !== false) {
			echo json_encode(['success' => true, 'message' => 'group message skipped']);
			return;
		}

		// Remove @c.us suffix
		$from = str_replace('@c.us', '', $from);

		if (empty($from) || empty($body)) {
			echo json_encode(['success' => false, 'message' => 'from or body is empty']);
			return;
		}

		$count = $this->model_crm->log_incoming_reply($from, $body, $name);

		echo json_encode([
			'success' => true,
			'message' => "Logged {$count} label(s) for WAHA reply from {$from}",
			'logged' => $count
		]);
	}

	// ===== CHAT TIMELINE AJAX =====

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

		// Mark incoming messages for this label as read
		if ($this->db->table_exists('crm_chat_history')) {
			$this->db->where('label_id', (int)$label_id)
				->where('direction', 'in')
				->where('status !=', 'read')
				->update('crm_chat_history', ['status' => 'read']);
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
			'count' => count($timeline)
		], JSON_UNESCAPED_UNICODE);
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

		if (empty($message) && !empty($file_url)) {
			$ext = strtolower(pathinfo(parse_url($file_url, PHP_URL_PATH), PATHINFO_EXTENSION));
			if (in_array($ext, ['mp3', 'ogg', 'wav', 'm4a', 'aac', 'opus', 'webm', '3gp', 'amr']) || strpos($file_url, 'voice') !== false || strpos($file_url, 'audio') !== false) {
				$message = '[Pesan Suara]: ' . $file_url;
			} else {
				$message = '[Lampiran Media/Dokumen]: ' . $file_url;
			}
		}

		if (!$label_id || empty($message)) {
			echo json_encode(['success' => false, 'message' => 'Label ID dan pesan atau file attachment tidak boleh kosong'], JSON_UNESCAPED_UNICODE);
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

		$message_to_save = $message;
		if (!empty($file_url) && strpos($message_to_save, $file_url) === false) {
			$message_to_save .= "\n\n[Lampiran File]: " . $file_url;
		}

		if ($is_internal_note) {
			// Internal note: DO NOT send to Fonnte, just save locally
			$chat_status = 'delivered'; // Internal notes are always "delivered" locally
		} else {
			// Send via Fonnte API
			$config = $this->model_crm->get_wa_gateway_config();
			if ($config->mode === 'wa_gateway') {
				$api_result = $this->model_crm->send_wa_via_api($label->customer_phone, $message, $file_url);
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

		$messages = $this->model_crm->get_new_messages($label_id, $last_id);

		// Mark incoming messages for this label as read
		if (!empty($messages) && $this->db->table_exists('crm_chat_history')) {
			$this->db->where('label_id', (int)$label_id)
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
