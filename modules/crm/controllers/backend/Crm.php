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
		// Auto-sync new ERP orders (sales_order & penjualan_marketplace) into CRM labels
		$this->model_crm->generate_labels_for_new_orders();

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

		$res_status = $this->model_crm->update_label_status($label_id, $status, $username);
		
		if (!empty($catatan)) {
			$this->model_crm->add_note($label_id, $catatan, $status);
		}

		echo json_encode(['success' => true, 'message' => 'Catatan & status berhasil disimpan']);
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
		// Auto-sync new ERP orders into CRM labels
		$this->model_crm->generate_labels_for_new_orders();

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
		echo json_encode(['success' => true, 'notes' => $notes]);
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
}
