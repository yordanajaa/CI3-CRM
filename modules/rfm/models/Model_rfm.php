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

	public function get_rfm_percentile_thresholds($product_filter = '')
	{
		return $this->crm->get_rfm_percentile_thresholds($product_filter);
	}

	public function calculate_rfm($last_order_date = null, $total_orders = 0, $total_spend = 0.0, $thresholds = null)
	{
		return $this->crm->calculate_rfm($last_order_date, $total_orders, $total_spend, $thresholds);
	}

	// ===== Customer Data (delegates to Model_crm) =====

	public function get_customers($filter = '', $limit = 25, $offset = 0, $rfm_segment_filter = '', $product_filter = '', $period_filter = '')
	{
		return $this->crm->get_customers($filter, $limit, $offset, $rfm_segment_filter, $product_filter, $period_filter);
	}

	public function get_rfm_dashboard_distribution($product_filter = '', $period_filter = '')
	{
		return $this->crm->get_rfm_dashboard_distribution($product_filter, $period_filter);
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

	public function get_all_products_list()
	{
		return $this->crm->get_all_products_list();
	}

	public function get_distinct_months_list()
	{
		return $this->crm->get_distinct_months_list();
	}

	public function get_monthly_rfm_tracking_per_product($product_filter = '', $period_filter = '')
	{
		return $this->crm->get_monthly_rfm_tracking_per_product($product_filter, $period_filter);
	}

	public function get_product_rfm_list($filter = '', $limit = 50, $offset = 0)
	{
		return $this->crm->get_product_rfm_list($filter, $limit, $offset);
	}

	public function get_cohort_analysis($mode = 'monthly', $year = '', $month = '')
	{
		return $this->crm->get_cohort_analysis($mode, $year, $month);
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
}
