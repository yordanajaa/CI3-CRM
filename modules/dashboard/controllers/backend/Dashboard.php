<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Dashboard extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_dashboard');
	}

	public function index()
	{
		if (!$this->aauth->is_allowed('dashboard')) {
			$this->render('backend/standart/blank', []);
			return;
		}


		$data['low_stocks']    = $this->model_dashboard->get_low_stocks(10);
		$data['recent_returs'] = $this->model_dashboard->get_recent_returs(5);
		$summary  = $this->model_dashboard->get_summary();
		$realtime = $this->model_dashboard->get_realtime_stats();
		
		$data = array_merge($data, $summary, $realtime);

		$this->render('backend/standart/dashboard', $data);
	}

	public function chart()
	{
		if (!$this->aauth->is_allowed('dashboard')) {
			redirect('/', 'refresh');
		}

		$data = [];
		$this->render('backend/standart/chart', $data);
	}

	public function get_notifications()
	{
		$user_id = get_user_data('id');
		$is_manager = $this->aauth->is_admin() 
			|| $this->aauth->is_allowed('purchase_order_approve', false) 
			|| $this->aauth->is_allowed('transfer_stok_approve', false);

		$items = [];
		$total_count = 0;
		$wa_unread_count = 0;

		// 1. Incoming WhatsApp Messages (Visible to CS / Admin / All Staff)
		if ($this->db->table_exists('crm_chat_history')) {
			$incoming_chats = $this->db->select('c.id, c.label_id, c.customer_phone, c.message, c.sender_name, c.status, c.created_at, l.customer_nama, l.no_pesanan')
				->from('crm_chat_history c')
				->join('crm_transaction_followup_labels l', 'l.id = c.label_id', 'left')
				->where('c.direction', 'in')
				->where('c.is_internal_note', 0)
				->where('c.status !=', 'read')
				->order_by('c.id', 'DESC')
				->limit(10)
				->get()->result();

			foreach ($incoming_chats as $chat) {
				// Skip Fonnte echo falsely logged as incoming
				if (!empty($chat->message) && (stripos($chat->message, 'Sent via fonnte.com') !== false || stripos($chat->message, 'fonnte.com') !== false)) {
					continue;
				}

				$cust_name = !empty($chat->sender_name) ? $chat->sender_name : (!empty($chat->customer_nama) ? $chat->customer_nama : $chat->customer_phone);
				$preview = trim(strip_tags($chat->message));
				if (mb_strlen($preview) > 40) {
					$preview = mb_substr($preview, 0, 40) . '...';
				}

				$items[] = [
					'id' => (int)$chat->id,
					'type' => 'incoming_wa',
					'title' => '💬 WA: ' . $cust_name,
					'subtitle' => $preview ? $preview : '[Pesan / Media]',
					'url' => site_url('administrator/crm/chat?label_id=' . $chat->label_id),
					'icon' => 'fa-whatsapp',
					'icon_bg' => 'text-green',
					'date' => date('d/m H:i', strtotime($chat->created_at))
				];
			}

			$wa_unread_count = $this->db->where([
				'direction' => 'in',
				'is_internal_note' => 0,
				'status !=' => 'read'
			])->count_all_results('crm_chat_history');
			
			$total_count += $wa_unread_count;
		}

		// 2. Purchase Order Pending Approval (For Managers / Admins)
		if ($is_manager && $this->db->table_exists('purchase_order')) {
			$threshold = (float) get_option('po_approval_threshold', 50000000);

			$pos = $this->db->select('po.id, po.nomor_po, po.created_at, po.total, po.kurs, s.nama_supplier')
				->from('purchase_order po')
				->join('supplier s', 's.id = po.supplier_id', 'left')
				->where('po.status', 'submitted')
				->order_by('po.id', 'DESC')
				->limit(10)
				->get()->result();

			foreach ($pos as $po) {
				$total_idr = (float)$po->total * (float)($po->kurs ?: 1);
				$is_high_value = ($total_idr >= $threshold);

				$items[] = [
					'id' => (int)$po->id,
					'type' => 'po',
					'title' => ($is_high_value ? '⚠️ PO High-Value: ' : 'PO Pending Approval: ') . $po->nomor_po,
					'subtitle' => ($po->nama_supplier ? $po->nama_supplier . ' - ' : '') . 'Rp ' . number_format($total_idr, 0, ',', '.') . ($is_high_value ? ' (Butuh Approval Manajer)' : ''),
					'url' => site_url('administrator/purchase_order/view/' . $po->id),
					'icon' => $is_high_value ? 'fa-shield' : 'fa-shopping-cart',
					'icon_bg' => $is_high_value ? 'text-red' : 'text-aqua',
					'date' => date('d/m H:i', strtotime($po->created_at))
				];
			}
			$po_count = $this->db->where('status', 'submitted')->count_all_results('purchase_order');
			$total_count += $po_count;
		}


		$header_title = 'Notifikasi & Pesan WA';
		$footer_url = site_url('administrator/crm/journal_followup');
		$footer_label = 'Lihat Journal Chat WA';

		if ($wa_unread_count === 0) {
			if ($is_manager) {
				$header_title = 'Notifikasi Approval';
				$footer_url = site_url('administrator/purchase_order');
				$footer_label = 'Lihat Kelola Purchase Order';
			} else {
				$header_title = 'Notifikasi Saya';
				$footer_url = site_url('administrator/hr_profile');
				$footer_label = 'Lihat Profile & Presensi';
			}
		}

		return $this->response([
			'success' => true,
			'header_title' => $header_title,
			'footer_url' => $footer_url,
			'footer_label' => $footer_label,
			'total_count' => $total_count,
			'items' => $items
		]);
	}
}

/* End of file Dashboard.php */
/* Location: ./modules/dashboard/controllers/backend/Dashboard.php */