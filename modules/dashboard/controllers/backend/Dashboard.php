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
		$overdue_count = 0;

		// 1. Peringatan Follow-Up Terlupakan (CRM Overdue Pending Reminders)
		if ($this->db->table_exists('crm_transaction_followup_labels')) {
			$today = date('Y-m-d');

			// Hitung total follow-up pending yang sudah jatuh tempo / terlewat
			$overdue_row = $this->db->query("
				SELECT COUNT(*) as cnt 
				FROM crm_transaction_followup_labels 
				WHERE status_label = 'Pending' 
				  AND is_cancelled = 0 
				  AND tanggal_label_muncul < '$today'
			")->row();
			$overdue_count = $overdue_row ? (int)$overdue_row->cnt : 0;

			// Ambil 10 data follow-up yang paling lama terlupakan (tanggal jadwal paling lampau)
			$overdue_items = $this->db->query("
				SELECT tfl.id, tfl.customer_nama, tfl.customer_phone, tfl.no_pesanan, tfl.order_source, 
				       tfl.tanggal_pengiriman, tfl.tanggal_label_muncul, fc.nama_kategori,
				       DATEDIFF('$today', tfl.tanggal_label_muncul) as terlambat_hari
				FROM crm_transaction_followup_labels tfl
				LEFT JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
				WHERE tfl.status_label = 'Pending' 
				  AND tfl.is_cancelled = 0 
				  AND tfl.tanggal_label_muncul < '$today'
				ORDER BY tfl.tanggal_label_muncul ASC, tfl.id ASC
				LIMIT 10
			")->result();

			foreach ($overdue_items as $fup) {
				$cust = !empty($fup->customer_nama) && $fup->customer_nama !== '-' ? $fup->customer_nama : ($fup->customer_phone ?: 'Pelanggan');
				$days = (int)$fup->terlambat_hari;
				$kat = !empty($fup->nama_kategori) ? $fup->nama_kategori : 'Follow-Up';
				$order_info = !empty($fup->no_pesanan) ? $fup->no_pesanan : ($fup->order_source ?: 'Pesanan');
				$source_badge = !empty($fup->order_source) ? ' (' . $fup->order_source . ')' : '';

				$items[] = [
					'id' => (int)$fup->id,
					'type' => 'overdue_followup',
					'title' => '⏰ Terlewat ' . $days . ' Hari: ' . $cust,
					'subtitle' => $kat . ' • ' . $order_info . $source_badge,
					'url' => site_url('administrator/crm/journal_followup?status_label=belum_direspon&q=' . urlencode($fup->no_pesanan ?: $cust)),
					'icon' => 'fa-clock-o',
					'icon_bg' => 'text-yellow',
					'date' => date('d/m/Y', strtotime($fup->tanggal_label_muncul))
				];
			}

			$total_count += $overdue_count;
		}

		// 2. Purchase Order Pending Approval (For Managers / Admins)
		$po_count = 0;
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

		// Header & Footer
		if ($overdue_count > 0) {
			$header_title = 'Peringatan Follow-Up';
			$footer_url = site_url('administrator/crm/journal_followup?status_label=belum_direspon');
			$footer_label = 'Lihat Follow-Up Terlewat';
		} elseif ($po_count > 0 && $is_manager) {
			$header_title = 'Notifikasi Approval';
			$footer_url = site_url('administrator/purchase_order');
			$footer_label = 'Lihat Kelola Purchase Order';
		} else {
			$header_title = 'Notifikasi Follow-Up';
			$footer_url = site_url('administrator/crm/journal_followup');
			$footer_label = 'Lihat Journal Follow-Up';
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