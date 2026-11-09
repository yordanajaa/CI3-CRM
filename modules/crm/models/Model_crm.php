<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class Model_crm extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		@$this->db->query("SET NAMES utf8mb4");
	}
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
	 * RFM 125-Rule Matrix Lookup (Source: rfm magang.xlsx)
	 */
	public function get_rfm_matrix()
	{
		$custom = $this->db->get_where('cc_options', ['option_name' => 'rfm_matrix_custom'])->row();
		if ($custom && !empty($custom->option_value)) {
			$json = json_decode($custom->option_value, true);
			if (is_array($json) && count($json) > 0) {
				return $json;
			}
		}

		return [
			'555' => ['r' => 5, 'f' => 5, 'm' => 5, 'segment' => 'Champions', 'goal' => 'Pertahankan loyalitas dan beri apresiasi', 'action' => 'Berikan hadiah eksklusif, early access, dan testimoni program'],
			'554' => ['r' => 5, 'f' => 5, 'm' => 4, 'segment' => 'Champions', 'goal' => 'Pertahankan loyalitas dan beri apresiasi', 'action' => 'Berikan hadiah eksklusif, early access, dan testimoni program'],
			'553' => ['r' => 5, 'f' => 5, 'm' => 3, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'552' => ['r' => 5, 'f' => 5, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'551' => ['r' => 5, 'f' => 5, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'545' => ['r' => 5, 'f' => 4, 'm' => 5, 'segment' => 'Champions', 'goal' => 'Pertahankan loyalitas dan beri apresiasi', 'action' => 'Berikan hadiah eksklusif, early access, dan testimoni program'],
			'544' => ['r' => 5, 'f' => 4, 'm' => 4, 'segment' => 'Champions', 'goal' => 'Pertahankan loyalitas dan beri apresiasi', 'action' => 'Berikan hadiah eksklusif, early access, dan testimoni program'],
			'543' => ['r' => 5, 'f' => 4, 'm' => 3, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'542' => ['r' => 5, 'f' => 4, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'541' => ['r' => 5, 'f' => 4, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'535' => ['r' => 5, 'f' => 3, 'm' => 5, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'534' => ['r' => 5, 'f' => 3, 'm' => 4, 'segment' => 'Potential Loyalist', 'goal' => 'Dorong jadi loyal customer', 'action' => 'Follow up rutin, edukasi produk, dan masuk grup WA konsultasi'],
			'533' => ['r' => 5, 'f' => 3, 'm' => 3, 'segment' => 'Potential Loyalist', 'goal' => 'Dorong jadi loyal customer', 'action' => 'Follow up rutin, edukasi produk, dan masuk grup WA konsultasi'],
			'532' => ['r' => 5, 'f' => 3, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'531' => ['r' => 5, 'f' => 3, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'525' => ['r' => 5, 'f' => 2, 'm' => 5, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'524' => ['r' => 5, 'f' => 2, 'm' => 4, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'523' => ['r' => 5, 'f' => 2, 'm' => 3, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'522' => ['r' => 5, 'f' => 2, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'521' => ['r' => 5, 'f' => 2, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'515' => ['r' => 5, 'f' => 1, 'm' => 5, 'segment' => 'New Customers', 'goal' => 'Bina jadi pembeli ulang', 'action' => 'Reminder, konsultasi awal, dan edukasi cara konsumsi'],
			'514' => ['r' => 5, 'f' => 1, 'm' => 4, 'segment' => 'New Customers', 'goal' => 'Bina jadi pembeli ulang', 'action' => 'Reminder, konsultasi awal, dan edukasi cara konsumsi'],
			'513' => ['r' => 5, 'f' => 1, 'm' => 3, 'segment' => 'New Customers', 'goal' => 'Bina jadi pembeli ulang', 'action' => 'Reminder, konsultasi awal, dan edukasi cara konsumsi'],
			'512' => ['r' => 5, 'f' => 1, 'm' => 2, 'segment' => 'New Customers', 'goal' => 'Bina jadi pembeli ulang', 'action' => 'Reminder, konsultasi awal, dan edukasi cara konsumsi'],
			'511' => ['r' => 5, 'f' => 1, 'm' => 1, 'segment' => 'New Customers', 'goal' => 'Bina jadi pembeli ulang', 'action' => 'Reminder, konsultasi awal, dan edukasi cara konsumsi'],
			'455' => ['r' => 4, 'f' => 5, 'm' => 5, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'454' => ['r' => 4, 'f' => 5, 'm' => 4, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'453' => ['r' => 4, 'f' => 5, 'm' => 3, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'452' => ['r' => 4, 'f' => 5, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'451' => ['r' => 4, 'f' => 5, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'445' => ['r' => 4, 'f' => 4, 'm' => 5, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'444' => ['r' => 4, 'f' => 4, 'm' => 4, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'443' => ['r' => 4, 'f' => 4, 'm' => 3, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'442' => ['r' => 4, 'f' => 4, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'441' => ['r' => 4, 'f' => 4, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'435' => ['r' => 4, 'f' => 3, 'm' => 5, 'segment' => 'Big Spenders', 'goal' => 'Pertahankan nilai belanja 4', 'action' => 'Berikan penawaran VIP, diskon eksklusif, dan layanan personal'],
			'434' => ['r' => 4, 'f' => 3, 'm' => 4, 'segment' => 'Potential Loyalist', 'goal' => 'Dorong jadi loyal customer', 'action' => 'Follow up rutin, edukasi produk, dan masuk grup WA konsultasi'],
			'433' => ['r' => 4, 'f' => 3, 'm' => 3, 'segment' => 'Potential Loyalist', 'goal' => 'Dorong jadi loyal customer', 'action' => 'Follow up rutin, edukasi produk, dan masuk grup WA konsultasi'],
			'432' => ['r' => 4, 'f' => 3, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'431' => ['r' => 4, 'f' => 3, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'425' => ['r' => 4, 'f' => 2, 'm' => 5, 'segment' => 'Big Spenders', 'goal' => 'Pertahankan nilai belanja 4', 'action' => 'Berikan penawaran VIP, diskon eksklusif, dan layanan personal'],
			'424' => ['r' => 4, 'f' => 2, 'm' => 4, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'423' => ['r' => 4, 'f' => 2, 'm' => 3, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'422' => ['r' => 4, 'f' => 2, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'421' => ['r' => 4, 'f' => 2, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'415' => ['r' => 4, 'f' => 1, 'm' => 5, 'segment' => 'New Customers', 'goal' => 'Bina jadi pembeli ulang', 'action' => 'Reminder, konsultasi awal, dan edukasi cara konsumsi'],
			'414' => ['r' => 4, 'f' => 1, 'm' => 4, 'segment' => 'New Customers', 'goal' => 'Bina jadi pembeli ulang', 'action' => 'Reminder, konsultasi awal, dan edukasi cara konsumsi'],
			'413' => ['r' => 4, 'f' => 1, 'm' => 3, 'segment' => 'New Customers', 'goal' => 'Bina jadi pembeli ulang', 'action' => 'Reminder, konsultasi awal, dan edukasi cara konsumsi'],
			'412' => ['r' => 4, 'f' => 1, 'm' => 2, 'segment' => 'New Customers', 'goal' => 'Bina jadi pembeli ulang', 'action' => 'Reminder, konsultasi awal, dan edukasi cara konsumsi'],
			'411' => ['r' => 4, 'f' => 1, 'm' => 1, 'segment' => 'New Customers', 'goal' => 'Bina jadi pembeli ulang', 'action' => 'Reminder, konsultasi awal, dan edukasi cara konsumsi'],
			'355' => ['r' => 3, 'f' => 5, 'm' => 5, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'354' => ['r' => 3, 'f' => 5, 'm' => 4, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'353' => ['r' => 3, 'f' => 5, 'm' => 3, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'352' => ['r' => 3, 'f' => 5, 'm' => 2, 'segment' => 'Frequent Low Value', 'goal' => 'Upsell ke paket besar', 'action' => 'Tawarkan paket hemat, diskon volume, dan tesimoni produk'],
			'351' => ['r' => 3, 'f' => 5, 'm' => 1, 'segment' => 'Frequent Low Value', 'goal' => 'Upsell ke paket besar', 'action' => 'Tawarkan paket hemat, diskon volume, dan tesimoni produk'],
			'345' => ['r' => 3, 'f' => 4, 'm' => 5, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'344' => ['r' => 3, 'f' => 4, 'm' => 4, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'343' => ['r' => 3, 'f' => 4, 'm' => 3, 'segment' => 'Loyal Customers', 'goal' => 'Naikkan frekuensi atau AOV', 'action' => 'Tawarkan bundling, loyalty reward, dan referral program'],
			'342' => ['r' => 3, 'f' => 4, 'm' => 2, 'segment' => 'Frequent Low Value', 'goal' => 'Upsell ke paket besar', 'action' => 'Tawarkan paket hemat, diskon volume, dan tesimoni produk'],
			'341' => ['r' => 3, 'f' => 4, 'm' => 1, 'segment' => 'Frequent Low Value', 'goal' => 'Upsell ke paket besar', 'action' => 'Tawarkan paket hemat, diskon volume, dan tesimoni produk'],
			'335' => ['r' => 3, 'f' => 3, 'm' => 5, 'segment' => 'Big Spenders', 'goal' => 'Pertahankan nilai belanja 4', 'action' => 'Berikan penawaran VIP, diskon eksklusif, dan layanan personal'],
			'334' => ['r' => 3, 'f' => 3, 'm' => 4, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'333' => ['r' => 3, 'f' => 3, 'm' => 3, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'332' => ['r' => 3, 'f' => 3, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'331' => ['r' => 3, 'f' => 3, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'325' => ['r' => 3, 'f' => 2, 'm' => 5, 'segment' => 'Big Spenders', 'goal' => 'Pertahankan nilai belanja 4', 'action' => 'Berikan penawaran VIP, diskon eksklusif, dan layanan personal'],
			'324' => ['r' => 3, 'f' => 2, 'm' => 4, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'323' => ['r' => 3, 'f' => 2, 'm' => 3, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'322' => ['r' => 3, 'f' => 2, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'321' => ['r' => 3, 'f' => 2, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'315' => ['r' => 3, 'f' => 1, 'm' => 5, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'314' => ['r' => 3, 'f' => 1, 'm' => 4, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'313' => ['r' => 3, 'f' => 1, 'm' => 3, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'312' => ['r' => 3, 'f' => 1, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'311' => ['r' => 3, 'f' => 1, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'255' => ['r' => 2, 'f' => 5, 'm' => 5, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'254' => ['r' => 2, 'f' => 5, 'm' => 4, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'253' => ['r' => 2, 'f' => 5, 'm' => 3, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'252' => ['r' => 2, 'f' => 5, 'm' => 2, 'segment' => 'Frequent Low Value', 'goal' => 'Upsell ke paket besar', 'action' => 'Tawarkan paket hemat, diskon volume, dan tesimoni produk'],
			'251' => ['r' => 2, 'f' => 5, 'm' => 1, 'segment' => 'Frequent Low Value', 'goal' => 'Upsell ke paket besar', 'action' => 'Tawarkan paket hemat, diskon volume, dan tesimoni produk'],
			'245' => ['r' => 2, 'f' => 4, 'm' => 5, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'244' => ['r' => 2, 'f' => 4, 'm' => 4, 'segment' => 'At Risk Customers', 'goal' => 'Tarik kembali ke aktif', 'action' => 'Kirim campaign reaktivasi + bonus spesial jika beli ulang'],
			'243' => ['r' => 2, 'f' => 4, 'm' => 3, 'segment' => 'At Risk Customers', 'goal' => 'Tarik kembali ke aktif', 'action' => 'Kirim campaign reaktivasi + bonus spesial jika beli ulang'],
			'242' => ['r' => 2, 'f' => 4, 'm' => 2, 'segment' => 'Frequent Low Value', 'goal' => 'Upsell ke paket besar', 'action' => 'Tawarkan paket hemat, diskon volume, dan tesimoni produk'],
			'241' => ['r' => 2, 'f' => 4, 'm' => 1, 'segment' => 'Frequent Low Value', 'goal' => 'Upsell ke paket besar', 'action' => 'Tawarkan paket hemat, diskon volume, dan tesimoni produk'],
			'235' => ['r' => 2, 'f' => 3, 'm' => 5, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'234' => ['r' => 2, 'f' => 3, 'm' => 4, 'segment' => 'At Risk Customers', 'goal' => 'Tarik kembali ke aktif', 'action' => 'Kirim campaign reaktivasi + bonus spesial jika beli ulang'],
			'233' => ['r' => 2, 'f' => 3, 'm' => 3, 'segment' => 'At Risk Customers', 'goal' => 'Tarik kembali ke aktif', 'action' => 'Kirim campaign reaktivasi + bonus spesial jika beli ulang'],
			'232' => ['r' => 2, 'f' => 3, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'231' => ['r' => 2, 'f' => 3, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'225' => ['r' => 2, 'f' => 2, 'm' => 5, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'224' => ['r' => 2, 'f' => 2, 'm' => 4, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'223' => ['r' => 2, 'f' => 2, 'm' => 3, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'222' => ['r' => 2, 'f' => 2, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'221' => ['r' => 2, 'f' => 2, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'215' => ['r' => 2, 'f' => 1, 'm' => 5, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'214' => ['r' => 2, 'f' => 1, 'm' => 4, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'213' => ['r' => 2, 'f' => 1, 'm' => 3, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'212' => ['r' => 2, 'f' => 1, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'211' => ['r' => 2, 'f' => 1, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'155' => ['r' => 1, 'f' => 5, 'm' => 5, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'154' => ['r' => 1, 'f' => 5, 'm' => 4, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'153' => ['r' => 1, 'f' => 5, 'm' => 3, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'152' => ['r' => 1, 'f' => 5, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'151' => ['r' => 1, 'f' => 5, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'145' => ['r' => 1, 'f' => 4, 'm' => 5, 'segment' => "Can't Lose Them", 'goal' => 'Cegah churn', 'action' => 'Follow up personal, beri hadiah loyalitas & tanya feedback langsung'],
			'144' => ['r' => 1, 'f' => 4, 'm' => 4, 'segment' => 'At Risk Customers', 'goal' => 'Tarik kembali ke aktif', 'action' => 'Kirim campaign reaktivasi + bonus spesial jika beli ulang'],
			'143' => ['r' => 1, 'f' => 4, 'm' => 3, 'segment' => 'At Risk Customers', 'goal' => 'Tarik kembali ke aktif', 'action' => 'Kirim campaign reaktivasi + bonus spesial jika beli ulang'],
			'142' => ['r' => 1, 'f' => 4, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'141' => ['r' => 1, 'f' => 4, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'135' => ['r' => 1, 'f' => 3, 'm' => 5, 'segment' => "Can't Lose Them", 'goal' => 'Cegah churn', 'action' => 'Follow up personal, beri hadiah loyalitas & tanya feedback langsung'],
			'134' => ['r' => 1, 'f' => 3, 'm' => 4, 'segment' => 'At Risk Customers', 'goal' => 'Tarik kembali ke aktif', 'action' => 'Kirim campaign reaktivasi + bonus spesial jika beli ulang'],
			'133' => ['r' => 1, 'f' => 3, 'm' => 3, 'segment' => 'At Risk Customers', 'goal' => 'Tarik kembali ke aktif', 'action' => 'Kirim campaign reaktivasi + bonus spesial jika beli ulang'],
			'132' => ['r' => 1, 'f' => 3, 'm' => 2, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'131' => ['r' => 1, 'f' => 3, 'm' => 1, 'segment' => 'Need Attention', 'goal' => 'Kenalkan kembali brand & manfaat', 'action' => 'Kirim ulang value produk + testimoni relevan'],
			'125' => ['r' => 1, 'f' => 2, 'm' => 5, 'segment' => 'Hibernating', 'goal' => 'Aktifkan kembali', 'action' => 'Kirim broadcast promo besar + story hasil customer lain'],
			'124' => ['r' => 1, 'f' => 2, 'm' => 4, 'segment' => 'Hibernating', 'goal' => 'Aktifkan kembali', 'action' => 'Kirim broadcast promo besar + story hasil customer lain'],
			'123' => ['r' => 1, 'f' => 2, 'm' => 3, 'segment' => 'Hibernating', 'goal' => 'Aktifkan kembali', 'action' => 'Kirim broadcast promo besar + story hasil customer lain'],
			'122' => ['r' => 1, 'f' => 2, 'm' => 2, 'segment' => 'Hibernating', 'goal' => 'Aktifkan kembali', 'action' => 'Kirim broadcast promo besar + story hasil customer lain'],
			'121' => ['r' => 1, 'f' => 2, 'm' => 1, 'segment' => 'Hibernating', 'goal' => 'Aktifkan kembali', 'action' => 'Kirim broadcast promo besar + story hasil customer lain'],
			'115' => ['r' => 1, 'f' => 1, 'm' => 5, 'segment' => 'Hibernating', 'goal' => 'Aktifkan kembali', 'action' => 'Kirim broadcast promo besar + story hasil customer lain'],
			'114' => ['r' => 1, 'f' => 1, 'm' => 4, 'segment' => 'Hibernating', 'goal' => 'Aktifkan kembali', 'action' => 'Kirim broadcast promo besar + story hasil customer lain'],
			'113' => ['r' => 1, 'f' => 1, 'm' => 3, 'segment' => 'Hibernating', 'goal' => 'Aktifkan kembali', 'action' => 'Kirim broadcast promo besar + story hasil customer lain'],
			'112' => ['r' => 1, 'f' => 1, 'm' => 2, 'segment' => 'Hibernating', 'goal' => 'Aktifkan kembali', 'action' => 'Kirim broadcast promo besar + story hasil customer lain'],
			'111' => ['r' => 1, 'f' => 1, 'm' => 1, 'segment' => 'Hibernating', 'goal' => 'Aktifkan kembali', 'action' => 'Kirim broadcast promo besar + story hasil customer lain'],
		];
	}

	public function save_rfm_matrix_custom($matrix)
	{
		$json = json_encode($matrix, JSON_UNESCAPED_UNICODE);
		$existing = $this->db->get_where('cc_options', ['option_name' => 'rfm_matrix_custom'])->row();
		if ($existing) {
			$this->db->where('id', $existing->id)->update('cc_options', ['option_value' => $json]);
		} else {
			$this->db->insert('cc_options', [
				'option_name'  => 'rfm_matrix_custom',
				'option_value' => $json
			]);
		}
		return true;
	}

	public function get_rfm_badge_style($segment)
	{
		$segment = trim((string)$segment);
		$styles = [
			'Champions' => ['bg' => '#fef3c7', 'color' => '#92400e', 'border' => '#fde68a', 'icon' => 'fa-trophy', 'badge' => 'label-warning'],
			'Loyal Customers' => ['bg' => '#dcfce7', 'color' => '#166534', 'border' => '#bbf7d0', 'icon' => 'fa-diamond', 'badge' => 'label-success'],
			'Potential Loyalist' => ['bg' => '#e0e7ff', 'color' => '#3730a3', 'border' => '#c7d2fe', 'icon' => 'fa-star', 'badge' => 'label-primary'],
			'New Customers' => ['bg' => '#e0f2fe', 'color' => '#075985', 'border' => '#bae6fd', 'icon' => 'fa-user-plus', 'badge' => 'label-info'],
			'Big Spenders' => ['bg' => '#f3e8ff', 'color' => '#6b21a8', 'border' => '#e9d5ff', 'icon' => 'fa-credit-card', 'badge' => 'label-primary'],
			'Frequent Low Value' => ['bg' => '#f1f5f9', 'color' => '#475569', 'border' => '#e2e8f0', 'icon' => 'fa-shopping-basket', 'badge' => 'label-default'],
			'Need Attention' => ['bg' => '#ffedd5', 'color' => '#9a3412', 'border' => '#fed7aa', 'icon' => 'fa-bell', 'badge' => 'label-warning'],
			'At Risk Customers' => ['bg' => '#fee2e2', 'color' => '#991b1b', 'border' => '#fca5a5', 'icon' => 'fa-exclamation-triangle', 'badge' => 'label-danger'],
			"Can't Lose Them" => ['bg' => '#fce7f3', 'color' => '#9d174d', 'border' => '#fbcfe8', 'icon' => 'fa-heart', 'badge' => 'label-danger'],
			'Hibernating' => ['bg' => '#f3f4f6', 'color' => '#1f2937', 'border' => '#e5e7eb', 'icon' => 'fa-moon-o', 'badge' => 'label-default'],
		];

		foreach ($styles as $name => $style) {
			if (strcasecmp($name, $segment) === 0 || strpos(strtolower($name), strtolower(substr($segment, 0, 5))) !== false) {
				return $style;
			}
		}

		return ['bg' => '#e2e8f0', 'color' => '#334155', 'border' => '#cbd5e1', 'icon' => 'fa-tag', 'badge' => 'label-default'];
	}

	/**
	 * Calculate quantitative percentile thresholds (20%, 40%, 60%, 80%) across all active customers
	/**
	 * Calculate quantitative percentile thresholds (20%, 40%, 60%, 80%) across active customers (optionally filtered by product)
	 */
	public function get_rfm_percentile_thresholds($product_filter = '', $period_filter = '', $category_filter = '')
	{
		static $cached_thresholds = [];
		$cache_key = md5((string)$product_filter . '_' . (string)$period_filter . '_' . (string)$category_filter);
		if (isset($cached_thresholds[$cache_key])) {
			return $cached_thresholds[$cache_key];
		}

		if (!empty($product_filter) || !empty($category_filter)) {
			$product_so_where = '';
			$product_pm_where = '';
			if (!empty($product_filter)) {
				$clean_pf = trim(preg_replace('/\s*\([^)]*\)$/', '', $product_filter));
				$pf_esc = $this->db->escape(trim($product_filter));
				$clean_pf_esc = $this->db->escape($clean_pf);
				$like_pf = $this->db->escape_like_str($clean_pf);

				$product_so_where .= " AND (
					TRIM(REGEXP_REPLACE(soi.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pf_esc}
					OR soi.catatan = {$pf_esc}
					OR soi.catatan LIKE '{$like_pf}%'
					OR ((soi.catatan IS NULL OR soi.catatan = '' OR soi.catatan LIKE '%Produk%') AND p.id > 1 AND p.nama_produk = {$clean_pf_esc})
				)";
				$product_pm_where .= " AND (
					TRIM(REGEXP_REPLACE(pmi.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pf_esc}
					OR pmi.catatan = {$pf_esc}
					OR pmi.catatan LIKE '{$like_pf}%'
					OR ((pmi.catatan IS NULL OR pmi.catatan = '' OR pmi.catatan LIKE '%Produk%') AND p.id > 1 AND p.nama_produk = {$clean_pf_esc})
				)";
			}
			if (!empty($category_filter)) {
				$cf = $this->db->escape(trim($category_filter));
				$product_so_where .= " AND (kp.nama_kategori = " . $cf . " OR p.kategori_id = " . $cf . ")";
				$product_pm_where .= " AND (kp.nama_kategori = " . $cf . " OR p.kategori_id = " . $cf . ")";
			}

			$sql = "
				SELECT 
					c_data.no_telepon,
					DATEDIFF(CURRENT_DATE(), MAX(c_data.last_date)) as days_since_last,
					COUNT(DISTINCT c_data.order_id) as total_orders,
					SUM(c_data.subtotal) as total_spend
				FROM (
					SELECT 
						CAST(COALESCE(NULLIF(NULLIF(so.no_telepon, '-'), ''), CONCAT('RESI_', COALESCE(NULLIF(so.nomor_resi, ''), NULLIF(so.no_pesanan, ''), so.id))) AS CHAR) COLLATE utf8mb4_unicode_ci as no_telepon, 
						so.tanggal_so as last_date, 
						CONCAT('so_', so.id) as order_id, 
						soi.subtotal 
					FROM sales_order_item soi
					JOIN sales_order so ON soi.so_id = so.id
					LEFT JOIN produk p ON soi.produk_id = p.id
					LEFT JOIN kategori_produk kp ON kp.id = p.kategori_id
					WHERE ((so.no_telepon IS NOT NULL AND so.no_telepon != '' AND so.no_telepon != '-') OR (so.nomor_resi IS NOT NULL AND so.nomor_resi != '' AND so.nomor_resi != '-') OR (so.no_pesanan IS NOT NULL AND so.no_pesanan != '' AND so.no_pesanan != '-'))
					  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
					  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))
					" . $product_so_where . "

					UNION ALL

					SELECT 
						CAST(COALESCE(NULLIF(NULLIF(pm.no_telepon, '-'), ''), CONCAT('RESI_', COALESCE(NULLIF(pm.nomor_resi, ''), NULLIF(pm.no_pesanan, ''), pm.id))) AS CHAR) COLLATE utf8mb4_unicode_ci as no_telepon, 
						pm.tanggal_so as last_date, 
						CONCAT('pm_', pm.id) as order_id, 
						pmi.subtotal 
					FROM penjualan_marketplace_item pmi
					JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
					LEFT JOIN produk p ON pmi.produk_id = p.id
					LEFT JOIN kategori_produk kp ON kp.id = p.kategori_id
					WHERE ((pm.no_telepon IS NOT NULL AND pm.no_telepon != '' AND pm.no_telepon != '-') OR (pm.nomor_resi IS NOT NULL AND pm.nomor_resi != '' AND pm.nomor_resi != '-') OR (pm.no_pesanan IS NOT NULL AND pm.no_pesanan != '' AND pm.no_pesanan != '-'))
					  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
					" . $product_pm_where . "
				) c_data
				GROUP BY c_data.no_telepon
			";
		} else {
			$sql = "
				SELECT 
					c_data.no_telepon,
					DATEDIFF(CURRENT_DATE(), MAX(c_data.last_date)) as days_since_last,
					COUNT(DISTINCT c_data.order_id) as total_orders,
					SUM(c_data.total) as total_spend
				FROM (
					SELECT 
						CAST(COALESCE(NULLIF(NULLIF(no_telepon, '-'), ''), CONCAT('RESI_', COALESCE(NULLIF(nomor_resi, ''), NULLIF(no_pesanan, ''), id))) AS CHAR) COLLATE utf8mb4_unicode_ci as no_telepon, 
						tanggal_so as last_date, 
						CONCAT('so_', id) as order_id, 
						total 
					FROM sales_order 
					WHERE ((no_telepon IS NOT NULL AND no_telepon != '' AND no_telepon != '-') OR (nomor_resi IS NOT NULL AND nomor_resi != '' AND nomor_resi != '-') OR (no_pesanan IS NOT NULL AND no_pesanan != '' AND no_pesanan != '-'))
					  AND (source = 'excel_import' OR (source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (no_pesanan IS NULL OR no_pesanan = '' OR no_pesanan = nomor_so)))
					  AND (status_pesanan IS NULL OR (LOWER(status_pesanan) NOT LIKE '%batal%' AND LOWER(status_pesanan) NOT LIKE '%cancel%'))
					
					UNION ALL
					
					SELECT 
						CAST(COALESCE(NULLIF(NULLIF(no_telepon, '-'), ''), CONCAT('RESI_', COALESCE(NULLIF(nomor_resi, ''), NULLIF(no_pesanan, ''), id))) AS CHAR) COLLATE utf8mb4_unicode_ci as no_telepon, 
						tanggal_so as last_date, 
						CONCAT('pm_', id) as order_id, 
						total 
					FROM penjualan_marketplace 
					WHERE ((no_telepon IS NOT NULL AND no_telepon != '' AND no_telepon != '-') OR (nomor_resi IS NOT NULL AND nomor_resi != '' AND nomor_resi != '-') OR (no_pesanan IS NOT NULL AND no_pesanan != '' AND no_pesanan != '-'))
					  AND (status_pesanan IS NULL OR (LOWER(status_pesanan) NOT LIKE '%batal%' AND LOWER(status_pesanan) NOT LIKE '%cancel%'))
				) c_data
				GROUP BY c_data.no_telepon
			";
		}

		$rows = $this->db->query($sql)->result();
		if (empty($rows)) {
			$cached_thresholds[$cache_key] = [
				'r' => [20 => 30, 40 => 60, 60 => 90, 80 => 180],
				'f' => [20 => 2, 40 => 4, 60 => 7, 80 => 10],
				'm' => [20 => 300000, 40 => 1000000, 60 => 2500000, 80 => 5000000]
			];
			return $cached_thresholds[$cache_key];
		}

		$r_vals = [];
		$f_vals = [];
		$m_vals = [];

		foreach ($rows as $r) {
			$r_vals[] = (int)$r->days_since_last;
			$f_vals[] = (int)$r->total_orders;
			$m_vals[] = (float)$r->total_spend;
		}

		$calc_p = function($arr, $percentile) {
			sort($arr);
			$count = count($arr);
			if ($count === 0) return 0;
			if ($count === 1) return $arr[0];
			$index = ($percentile / 100.0) * ($count - 1);
			$lower = (int)floor($index);
			$fraction = $index - $lower;
			if ($lower >= $count - 1) return $arr[$count - 1];
			return $arr[$lower] + $fraction * ($arr[$lower + 1] - $arr[$lower]);
		};

		$r_p20 = $calc_p($r_vals, 20);
		$r_p40 = $calc_p($r_vals, 40);
		$r_p60 = $calc_p($r_vals, 60);
		$r_p80 = $calc_p($r_vals, 80);

		$f_p20 = $calc_p($f_vals, 20);
		$f_p40 = $calc_p($f_vals, 40);
		$f_p60 = $calc_p($f_vals, 60);
		$f_p80 = $calc_p($f_vals, 80);

		$m_p20 = $calc_p($m_vals, 20);
		$m_p40 = $calc_p($m_vals, 40);
		$m_p60 = $calc_p($m_vals, 60);
		$m_p80 = $calc_p($m_vals, 80);

		$cached_thresholds[$cache_key] = [
			'r' => [
				20 => $r_p20 ?: 30,
				40 => max($r_p40, ($r_p20 ?: 30) + 1),
				60 => max($r_p60, ($r_p40 ?: 60) + 1),
				80 => max($r_p80, ($r_p60 ?: 90) + 1)
			],
			'f' => [
				20 => $f_p20 ?: 2,
				40 => max($f_p40, ($f_p20 ?: 2) + 1),
				60 => max($f_p60, ($f_p40 ?: 4) + 1),
				80 => max($f_p80, ($f_p60 ?: 7) + 1)
			],
			'm' => [
				20 => $m_p20 ?: 300000,
				40 => max($m_p40, ($m_p20 ?: 300000) + 100000),
				60 => max($m_p60, ($m_p40 ?: 1000000) + 100000),
				80 => max($m_p80, ($m_p60 ?: 2500000) + 100000)
			]
		];

		return $cached_thresholds[$cache_key];
	}

	/**
	 * Calculate RFM Score and Segment for a customer using percentile quantiles (20%, 40%, 60%, 80%)
	 */
	public function calculate_rfm($last_order_date = null, $total_orders = 0, $total_spend = 0.0, $thresholds = null, $reference_date = null)
	{
		if ($thresholds === null) {
			$thresholds = $this->get_rfm_percentile_thresholds();
		}

		$t_r = $thresholds['r'];
		$t_f = $thresholds['f'];
		$t_m = $thresholds['m'];

		// 1. Recency (R) score (1 to 5) - percentile 20%, 40%, 60%, 80%
		$r_score = 1;
		$r_label = 'Sangat lama';
		$days_since_last = null;
		if (!empty($last_order_date) && $last_order_date !== '0000-00-00') {
			$ts_last = strtotime($last_order_date);
			if ($ts_last && $ts_last > 0) {
				$ref_ts = !empty($reference_date) ? (is_numeric($reference_date) ? (int)$reference_date : strtotime($reference_date)) : time();
				$days_since_last = max(0, (int)floor(($ref_ts - $ts_last) / 86400));
				if ($days_since_last <= $t_r[20]) {
					$r_score = 5; $r_label = 'Sangat baru';
				} elseif ($days_since_last <= $t_r[40]) {
					$r_score = 4; $r_label = 'Baru';
				} elseif ($days_since_last <= $t_r[60]) {
					$r_score = 3; $r_label = 'Cukup lama';
				} elseif ($days_since_last <= $t_r[80]) {
					$r_score = 2; $r_label = 'Lama';
				} else {
					$r_score = 1; $r_label = 'Sangat lama';
				}
			}
		}

		// 2. Frequency (F) score (1 to 5) - percentile 20%, 40%, 60%, 80%
		$f_score = 1;
		$f_label = 'Sangat jarang';
		$total_orders = (int)$total_orders;
		if ($total_orders >= $t_f[80]) {
			$f_score = 5; $f_label = 'Sangat sering';
		} elseif ($total_orders >= $t_f[60]) {
			$f_score = 4; $f_label = 'Sering';
		} elseif ($total_orders >= $t_f[40]) {
			$f_score = 3; $f_label = 'Kadang';
		} elseif ($total_orders >= $t_f[20]) {
			$f_score = 2; $f_label = 'Jarang';
		} else {
			$f_score = 1; $f_label = 'Sangat jarang';
		}

		// 3. Monetary (M) score (1 to 5) - percentile 20%, 40%, 60%, 80%
		$m_score = 1;
		$m_label = 'Sangat kecil';
		$total_spend = (float)$total_spend;
		if ($total_spend >= $t_m[80]) {
			$m_score = 5; $m_label = 'Sangat Besar';
		} elseif ($total_spend >= $t_m[60]) {
			$m_score = 4; $m_label = 'Besar';
		} elseif ($total_spend >= $t_m[40]) {
			$m_score = 3; $m_label = 'Sedang';
		} elseif ($total_spend >= $t_m[20]) {
			$m_score = 2; $m_label = 'Kecil';
		} else {
			$m_score = 1; $m_label = 'Sangat kecil';
		}

		$rfm_code = $r_score . $f_score . $m_score;

		$matrix = $this->get_rfm_matrix();
		$rule = isset($matrix[$rfm_code]) ? $matrix[$rfm_code] : [
			'segment' => 'Need Attention',
			'goal' => 'Kenalkan kembali brand & manfaat',
			'action' => 'Kirim ulang value produk + testimoni relevan'
		];

		if (strpos($rule['segment'], 'Can') !== false) {
			$rule['segment'] = "Can't Lose Them";
		}

		$badge_style = $this->get_rfm_badge_style($rule['segment']);

		return [
			'r_score' => $r_score,
			'f_score' => $f_score,
			'm_score' => $m_score,
			'r_label' => $r_label,
			'f_label' => $f_label,
			'm_label' => $m_label,
			'rfm_code' => $rfm_code,
			'rfm_display' => $r_score . '-' . $f_score . '-' . $m_score,
			'segment' => $rule['segment'],
			'goal' => $rule['goal'],
			'action' => $rule['action'],
			'days_since_last' => $days_since_last,
			'badge' => $badge_style
		];
	}

	/**
	 * Get consolidated customer list directly from sales_order + penjualan_marketplace
	 * Grouped by phone number (primary key for customer identity)
	 */
	public function get_customers($filter = '', $limit = 25, $offset = 0, $rfm_segment_filter = '', $product_filter = '', $period_filter = '', $category_filter = '')
	{
		$thresholds = $this->get_rfm_percentile_thresholds($product_filter, $period_filter, $category_filter);

		if (!empty($product_filter) || !empty($category_filter)) {
			$product_so_where = '';
			$product_pm_where = '';
			if (!empty($product_filter)) {
				$clean_pf = trim(preg_replace('/\s*\([^)]*\)$/', '', $product_filter));
				$pf_esc = $this->db->escape(trim($product_filter));
				$clean_pf_esc = $this->db->escape($clean_pf);
				$like_pf = $this->db->escape_like_str($clean_pf);

				$product_so_where .= " AND (
					TRIM(REGEXP_REPLACE(soi.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pf_esc}
					OR soi.catatan = {$pf_esc}
					OR soi.catatan LIKE '{$like_pf}%'
					OR ((soi.catatan IS NULL OR soi.catatan = '' OR soi.catatan LIKE '%Produk%') AND p.id > 1 AND p.nama_produk = {$clean_pf_esc})
				)";
				$product_pm_where .= " AND (
					TRIM(REGEXP_REPLACE(pmi.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pf_esc}
					OR pmi.catatan = {$pf_esc}
					OR pmi.catatan LIKE '{$like_pf}%'
					OR ((pmi.catatan IS NULL OR pmi.catatan = '' OR pmi.catatan LIKE '%Produk%') AND p.id > 1 AND p.nama_produk = {$clean_pf_esc})
				)";
			}
			if (!empty($category_filter)) {
				$cf = $this->db->escape(trim($category_filter));
				$product_so_where .= " AND (kp.nama_kategori = " . $cf . " OR p.kategori_id = " . $cf . ")";
				$product_pm_where .= " AND (kp.nama_kategori = " . $cf . " OR p.kategori_id = " . $cf . ")";
			}

			$sql = "SELECT 
				COALESCE(NULLIF(NULLIF(MAX(phone), '-'), ''), '-') as customer_phone,
				cust_group_key,
				COALESCE(NULLIF(NULLIF(MAX(nama), '-'), ''), 'Customer') as customer_nama,
				COUNT(DISTINCT order_id) as total_orders,
				SUM(total) as total_spend,
				MAX(tanggal) as last_order_date,
				MAX(created_at) as last_created_at,
				GROUP_CONCAT(DISTINCT source ORDER BY source SEPARATOR ', ') as sumber_penjualan,
				MAX(NULLIF(raw_resi, '')) as nomor_resi,
				MAX(NULLIF(pesanan, '')) as no_pesanan,
				MAX(NULLIF(kurir, '')) as kurir_ekspedisi
			FROM (
				SELECT 
					CAST(COALESCE(NULLIF(NULLIF(so.no_telepon, '-'), ''), NULLIF(NULLIF(p_cust.no_telp, '-'), ''), NULLIF(NULLIF(p_cust.telepon, '-'), ''), NULLIF(NULLIF(so.no_telepon_pengirim, '-'), ''), '-') AS CHAR) COLLATE utf8mb4_unicode_ci as phone, 
					CAST(COALESCE(NULLIF(NULLIF(so.nama_penerima, '-'), ''), p_cust.nama_pelanggan, 'Customer') AS CHAR) COLLATE utf8mb4_unicode_ci as nama, 
					CAST(CONCAT('so_', so.id) AS CHAR) COLLATE utf8mb4_unicode_ci as order_id, 
					COALESCE(NULLIF(soi.subtotal, 0), NULLIF(soi.qty * soi.harga_satuan, 0), NULLIF(so.total, 0), NULLIF(so.subtotal, 0), NULLIF(so.total_pembayaran, 0), 0) as total, 
					CAST(COALESCE(so.waktu_pembayaran, so.created_at, so.tanggal_so) AS DATETIME) as tanggal, 
					COALESCE(so.created_at, so.tanggal_so) as created_at,
					'Toko' COLLATE utf8mb4_unicode_ci as source,
					CAST(CASE WHEN so.nomor_resi IS NOT NULL AND so.nomor_resi != '' THEN CONCAT('resi kurir ', so.nomor_resi) ELSE '' END AS CHAR) COLLATE utf8mb4_unicode_ci as resi,
					CAST(COALESCE(so.nomor_resi, '') AS CHAR) COLLATE utf8mb4_unicode_ci as raw_resi,
					CAST(COALESCE(so.no_pesanan, '') AS CHAR) COLLATE utf8mb4_unicode_ci as pesanan,
					CAST(COALESCE(so.catatan, '') AS CHAR) COLLATE utf8mb4_unicode_ci as catatan,
					CAST(COALESCE(so.kurir_ekspedisi, '') AS CHAR) COLLATE utf8mb4_unicode_ci as kurir,
					CAST(CASE 
						WHEN (so.no_telepon IS NOT NULL AND so.no_telepon != '' AND so.no_telepon != '-' AND so.no_telepon NOT LIKE '%*%')
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(so.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN (p_cust.no_telp IS NOT NULL AND p_cust.no_telp != '' AND p_cust.no_telp != '-' AND p_cust.no_telp NOT LIKE '%*%')
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(p_cust.no_telp, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN (so.no_telepon_pengirim IS NOT NULL AND so.no_telepon_pengirim != '' AND so.no_telepon_pengirim != '-' AND so.no_telepon_pengirim NOT LIKE '%*%' AND LENGTH(so.no_telepon_pengirim) >= 8)
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(so.no_telepon_pengirim, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN so.nomor_resi IS NOT NULL AND so.nomor_resi != '' AND so.nomor_resi != '-'
							THEN CONCAT('RESI_', so.nomor_resi)
						WHEN so.no_pesanan IS NOT NULL AND so.no_pesanan != '' AND so.no_pesanan != '-'
							THEN CONCAT('ORD_', so.no_pesanan)
						ELSE CONCAT('CUST_SO_', so.id)
					END AS CHAR) COLLATE utf8mb4_unicode_ci as cust_group_key
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN pelanggan p_cust ON so.pelanggan_id = p_cust.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				LEFT JOIN kategori_produk kp ON kp.id = p.kategori_id
				WHERE ((so.no_telepon IS NOT NULL AND so.no_telepon != '' AND so.no_telepon != '-') 
					OR (p_cust.telepon IS NOT NULL AND p_cust.telepon != '' AND p_cust.telepon != '-') 
					OR (p_cust.no_telp IS NOT NULL AND p_cust.no_telp != '' AND p_cust.no_telp != '-')
					OR (so.no_telepon_pengirim IS NOT NULL AND so.no_telepon_pengirim != '' AND so.no_telepon_pengirim != '-')
					OR (so.nomor_resi IS NOT NULL AND so.nomor_resi != '' AND so.nomor_resi != '-')
					OR (so.no_pesanan IS NOT NULL AND so.no_pesanan != '' AND so.no_pesanan != '-'))
				  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
				  AND so.tanggal_so IS NOT NULL 
				  AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND so.tanggal_so > '1970-01-01'
				  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))
				  " . $product_so_where . "

				UNION ALL

				SELECT 
					CAST(COALESCE(NULLIF(NULLIF(pm.no_telepon, '-'), ''), NULLIF(NULLIF(p_pm.no_telp, '-'), ''), NULLIF(NULLIF(p_pm.telepon, '-'), ''), NULLIF(NULLIF(pm.no_telepon_pengirim, '-'), ''), '-') AS CHAR) COLLATE utf8mb4_unicode_ci as phone, 
					CAST(COALESCE(NULLIF(NULLIF(TRIM(pm.nama_penerima), '-'), ''), NULLIF(NULLIF(TRIM(pm.username_pembeli), '-'), ''), NULLIF(NULLIF(TRIM(p_pm.nama_pelanggan), '-'), ''), 'Customer Marketplace') AS CHAR) COLLATE utf8mb4_unicode_ci as nama, 
					CAST(CONCAT('pm_', pm.id) AS CHAR) COLLATE utf8mb4_unicode_ci as order_id, 
					COALESCE(NULLIF(pmi.subtotal, 0), NULLIF(pmi.qty * pmi.harga_satuan, 0), NULLIF(pm.total, 0), NULLIF(pm.subtotal, 0), 0) as total, 
					CAST(COALESCE(pm.waktu_pembayaran, pm.created_at, pm.tanggal_so) AS DATETIME) as tanggal, 
					COALESCE(pm.created_at, pm.tanggal_so) as created_at,
					CAST(CASE 
						WHEN LOWER(pm.source) LIKE '%tokopedia%' THEN 'Tokopedia'
						WHEN LOWER(pm.source) LIKE '%tiktok%' THEN 'TikTok Shop'
						WHEN LOWER(pm.source) LIKE '%shopee%' THEN 'Shopee'
						WHEN LOWER(pm.source) LIKE '%resi%' THEN 'Resi Marketplace'
						WHEN LOWER(pm.no_pesanan) LIKE '%shp%' THEN 'Shopee'
						WHEN LOWER(pm.no_pesanan) LIKE '%tkp%' THEN 'Tokopedia'
						WHEN LOWER(pm.no_pesanan) LIKE '%ttk%' THEN 'TikTok Shop'
						ELSE 'Shopee'
					END AS CHAR) COLLATE utf8mb4_unicode_ci as source,
					CAST(CASE WHEN pm.nomor_resi IS NOT NULL AND pm.nomor_resi != '' THEN CONCAT('resi kurir ', pm.nomor_resi) ELSE '' END AS CHAR) COLLATE utf8mb4_unicode_ci as resi,
					CAST(COALESCE(pm.nomor_resi, '') AS CHAR) COLLATE utf8mb4_unicode_ci as raw_resi,
					CAST(COALESCE(pm.no_pesanan, '') AS CHAR) COLLATE utf8mb4_unicode_ci as pesanan,
					CAST(COALESCE(pm.catatan, '') AS CHAR) COLLATE utf8mb4_unicode_ci as catatan,
					CAST(COALESCE(pm.kurir_ekspedisi, '') AS CHAR) COLLATE utf8mb4_unicode_ci as kurir,
					CAST(CASE 
						WHEN (pm.no_telepon IS NOT NULL AND pm.no_telepon != '' AND pm.no_telepon != '-' AND pm.no_telepon NOT LIKE '%*%' AND LENGTH(pm.no_telepon) >= 8)
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(pm.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN (p_pm.no_telp IS NOT NULL AND p_pm.no_telp != '' AND p_pm.no_telp != '-' AND p_pm.no_telp NOT LIKE '%*%' AND LENGTH(p_pm.no_telp) >= 8)
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(p_pm.no_telp, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN (pm.no_telepon_pengirim IS NOT NULL AND pm.no_telepon_pengirim != '' AND pm.no_telepon_pengirim != '-' AND pm.no_telepon_pengirim NOT LIKE '%*%' AND LENGTH(pm.no_telepon_pengirim) >= 8)
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(pm.no_telepon_pengirim, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN pm.nomor_resi IS NOT NULL AND pm.nomor_resi != '' AND pm.nomor_resi != '-'
							THEN CONCAT('RESI_', pm.nomor_resi)
						WHEN pm.no_pesanan IS NOT NULL AND pm.no_pesanan != '' AND pm.no_pesanan != '-'
							THEN CONCAT('ORD_', pm.no_pesanan)
						ELSE CONCAT('CUST_PM_', pm.id)
					END AS CHAR) COLLATE utf8mb4_unicode_ci as cust_group_key
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN pelanggan p_pm ON pm.pelanggan_id = p_pm.id
				LEFT JOIN produk p ON pmi.produk_id = p.id
				LEFT JOIN kategori_produk kp ON kp.id = p.kategori_id
				WHERE ((pm.no_telepon IS NOT NULL AND pm.no_telepon != '' AND pm.no_telepon != '-' AND LENGTH(pm.no_telepon) >= 8)
					OR (p_pm.no_telp IS NOT NULL AND p_pm.no_telp != '' AND p_pm.no_telp != '-')
					OR (p_pm.telepon IS NOT NULL AND p_pm.telepon != '' AND p_pm.telepon != '-')
					OR (pm.no_telepon_pengirim IS NOT NULL AND pm.no_telepon_pengirim != '' AND pm.no_telepon_pengirim != '-' AND LENGTH(pm.no_telepon_pengirim) >= 8)
					OR (pm.nomor_resi IS NOT NULL AND pm.nomor_resi != '' AND pm.nomor_resi != '-')
					OR (pm.no_pesanan IS NOT NULL AND pm.no_pesanan != '' AND pm.no_pesanan != '-'))
				  AND pm.tanggal_so IS NOT NULL 
				  AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND pm.tanggal_so > '1970-01-01'
				  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
				  " . $product_pm_where . "
			) u";
		} else {
			$sql = "SELECT 
				COALESCE(NULLIF(NULLIF(MAX(phone), '-'), ''), '-') as customer_phone,
				cust_group_key,
				COALESCE(NULLIF(NULLIF(MAX(nama), '-'), ''), 'Customer') as customer_nama,
				COUNT(DISTINCT order_id) as total_orders,
				SUM(total) as total_spend,
				MAX(tanggal) as last_order_date,
				MAX(created_at) as last_created_at,
				GROUP_CONCAT(DISTINCT source ORDER BY source SEPARATOR ', ') as sumber_penjualan,
				MAX(NULLIF(raw_resi, '')) as nomor_resi,
				MAX(NULLIF(pesanan, '')) as no_pesanan,
				MAX(NULLIF(kurir, '')) as kurir_ekspedisi
			FROM (
				SELECT 
					CAST(COALESCE(NULLIF(NULLIF(so.no_telepon, '-'), ''), NULLIF(NULLIF(p_cust.no_telp, '-'), ''), NULLIF(NULLIF(p_cust.telepon, '-'), ''), NULLIF(NULLIF(so.no_telepon_pengirim, '-'), ''), '-') AS CHAR) COLLATE utf8mb4_unicode_ci as phone, 
					CAST(COALESCE(NULLIF(NULLIF(so.nama_penerima, '-'), ''), p_cust.nama_pelanggan, 'Customer') AS CHAR) COLLATE utf8mb4_unicode_ci as nama, 
					CAST(CONCAT('so_', so.id) AS CHAR) COLLATE utf8mb4_unicode_ci as order_id, 
					COALESCE(NULLIF(soi.subtotal, 0), NULLIF(soi.qty * soi.harga_satuan, 0), NULLIF(so.total, 0), NULLIF(so.subtotal, 0), NULLIF(so.total_pembayaran, 0), 0) as total, 
					CAST(COALESCE(so.waktu_pembayaran, so.created_at, so.tanggal_so) AS DATETIME) as tanggal, 
					COALESCE(so.created_at, so.tanggal_so) as created_at,
					'Toko' COLLATE utf8mb4_unicode_ci as source,
					CAST(CASE WHEN so.nomor_resi IS NOT NULL AND so.nomor_resi != '' THEN CONCAT('resi kurir ', so.nomor_resi) ELSE '' END AS CHAR) COLLATE utf8mb4_unicode_ci as resi,
					CAST(COALESCE(so.nomor_resi, '') AS CHAR) COLLATE utf8mb4_unicode_ci as raw_resi,
					CAST(COALESCE(so.no_pesanan, '') AS CHAR) COLLATE utf8mb4_unicode_ci as pesanan,
					CAST(COALESCE(so.catatan, '') AS CHAR) COLLATE utf8mb4_unicode_ci as catatan,
					CAST(COALESCE(so.kurir_ekspedisi, '') AS CHAR) COLLATE utf8mb4_unicode_ci as kurir,
					CAST(CASE 
						WHEN (so.no_telepon IS NOT NULL AND so.no_telepon != '' AND so.no_telepon != '-' AND so.no_telepon NOT LIKE '%*%')
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(so.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN (p_cust.no_telp IS NOT NULL AND p_cust.no_telp != '' AND p_cust.no_telp != '-' AND p_cust.no_telp NOT LIKE '%*%')
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(p_cust.no_telp, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN (so.no_telepon_pengirim IS NOT NULL AND so.no_telepon_pengirim != '' AND so.no_telepon_pengirim != '-' AND so.no_telepon_pengirim NOT LIKE '%*%' AND LENGTH(so.no_telepon_pengirim) >= 8)
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(so.no_telepon_pengirim, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN so.nomor_resi IS NOT NULL AND so.nomor_resi != '' AND so.nomor_resi != '-'
							THEN CONCAT('RESI_', so.nomor_resi)
						WHEN so.no_pesanan IS NOT NULL AND so.no_pesanan != '' AND so.no_pesanan != '-'
							THEN CONCAT('ORD_', so.no_pesanan)
						ELSE CONCAT('CUST_SO_', so.id)
					END AS CHAR) COLLATE utf8mb4_unicode_ci as cust_group_key
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN pelanggan p_cust ON so.pelanggan_id = p_cust.id
				WHERE ((so.no_telepon IS NOT NULL AND so.no_telepon != '' AND so.no_telepon != '-') 
					OR (p_cust.telepon IS NOT NULL AND p_cust.telepon != '' AND p_cust.telepon != '-') 
					OR (p_cust.no_telp IS NOT NULL AND p_cust.no_telp != '' AND p_cust.no_telp != '-')
					OR (so.no_telepon_pengirim IS NOT NULL AND so.no_telepon_pengirim != '' AND so.no_telepon_pengirim != '-')
					OR (so.nomor_resi IS NOT NULL AND so.nomor_resi != '' AND so.nomor_resi != '-')
					OR (so.no_pesanan IS NOT NULL AND so.no_pesanan != '' AND so.no_pesanan != '-'))
				  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
				  AND so.tanggal_so IS NOT NULL 
				  AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND so.tanggal_so > '1970-01-01'
				  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))

				UNION ALL

				SELECT 
					CAST(COALESCE(NULLIF(NULLIF(pm.no_telepon, '-'), ''), NULLIF(NULLIF(p_pm.no_telp, '-'), ''), NULLIF(NULLIF(p_pm.telepon, '-'), ''), NULLIF(NULLIF(pm.no_telepon_pengirim, '-'), ''), '-') AS CHAR) COLLATE utf8mb4_unicode_ci as phone, 
					CAST(COALESCE(NULLIF(NULLIF(TRIM(pm.nama_penerima), '-'), ''), NULLIF(NULLIF(TRIM(pm.username_pembeli), '-'), ''), NULLIF(NULLIF(TRIM(p_pm.nama_pelanggan), '-'), ''), 'Customer Marketplace') AS CHAR) COLLATE utf8mb4_unicode_ci as nama, 
					CAST(CONCAT('pm_', pm.id) AS CHAR) COLLATE utf8mb4_unicode_ci as order_id, 
					COALESCE(NULLIF(pmi.subtotal, 0), NULLIF(pmi.qty * pmi.harga_satuan, 0), NULLIF(pm.total, 0), NULLIF(pm.subtotal, 0), 0) as total, 
					CAST(COALESCE(pm.waktu_pembayaran, pm.created_at, pm.tanggal_so) AS DATETIME) as tanggal, 
					COALESCE(pm.created_at, pm.tanggal_so) as created_at,
					CAST(CASE 
						WHEN LOWER(pm.source) LIKE '%tokopedia%' THEN 'Tokopedia'
						WHEN LOWER(pm.source) LIKE '%tiktok%' THEN 'TikTok Shop'
						WHEN LOWER(pm.source) LIKE '%shopee%' THEN 'Shopee'
						WHEN LOWER(pm.source) LIKE '%resi%' THEN 'Resi Marketplace'
						WHEN LOWER(pm.no_pesanan) LIKE '%shp%' THEN 'Shopee'
						WHEN LOWER(pm.no_pesanan) LIKE '%tkp%' THEN 'Tokopedia'
						WHEN LOWER(pm.no_pesanan) LIKE '%ttk%' THEN 'TikTok Shop'
						ELSE 'Shopee'
					END AS CHAR) COLLATE utf8mb4_unicode_ci as source,
					CAST(CASE WHEN pm.nomor_resi IS NOT NULL AND pm.nomor_resi != '' THEN CONCAT('resi kurir ', pm.nomor_resi) ELSE '' END AS CHAR) COLLATE utf8mb4_unicode_ci as resi,
					CAST(COALESCE(pm.nomor_resi, '') AS CHAR) COLLATE utf8mb4_unicode_ci as raw_resi,
					CAST(COALESCE(pm.no_pesanan, '') AS CHAR) COLLATE utf8mb4_unicode_ci as pesanan,
					CAST(COALESCE(pm.catatan, '') AS CHAR) COLLATE utf8mb4_unicode_ci as catatan,
					CAST(COALESCE(pm.kurir_ekspedisi, '') AS CHAR) COLLATE utf8mb4_unicode_ci as kurir,
					CAST(CASE 
						WHEN (pm.no_telepon IS NOT NULL AND pm.no_telepon != '' AND pm.no_telepon != '-' AND pm.no_telepon NOT LIKE '%*%' AND LENGTH(pm.no_telepon) >= 8)
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(pm.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN (p_pm.no_telp IS NOT NULL AND p_pm.no_telp != '' AND p_pm.no_telp != '-' AND p_pm.no_telp NOT LIKE '%*%' AND LENGTH(p_pm.no_telp) >= 8)
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(p_pm.no_telp, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN (pm.no_telepon_pengirim IS NOT NULL AND pm.no_telepon_pengirim != '' AND pm.no_telepon_pengirim != '-' AND pm.no_telepon_pengirim NOT LIKE '%*%' AND LENGTH(pm.no_telepon_pengirim) >= 8)
							THEN RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(pm.no_telepon_pengirim, ' ', ''), '-', ''), '+', ''), '628', '08'), 10)
						WHEN pm.nomor_resi IS NOT NULL AND pm.nomor_resi != '' AND pm.nomor_resi != '-'
							THEN CONCAT('RESI_', pm.nomor_resi)
						WHEN pm.no_pesanan IS NOT NULL AND pm.no_pesanan != '' AND pm.no_pesanan != '-'
							THEN CONCAT('ORD_', pm.no_pesanan)
						ELSE CONCAT('CUST_PM_', pm.id)
					END AS CHAR) COLLATE utf8mb4_unicode_ci as cust_group_key
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN pelanggan p_pm ON pm.pelanggan_id = p_pm.id
				WHERE ((pm.no_telepon IS NOT NULL AND pm.no_telepon != '' AND pm.no_telepon != '-' AND LENGTH(pm.no_telepon) >= 8)
					OR (p_pm.no_telp IS NOT NULL AND p_pm.no_telp != '' AND p_pm.no_telp != '-')
					OR (p_pm.telepon IS NOT NULL AND p_pm.telepon != '' AND p_pm.telepon != '-')
					OR (pm.no_telepon_pengirim IS NOT NULL AND pm.no_telepon_pengirim != '' AND pm.no_telepon_pengirim != '-' AND LENGTH(pm.no_telepon_pengirim) >= 8)
					OR (pm.nomor_resi IS NOT NULL AND pm.nomor_resi != '' AND pm.nomor_resi != '-')
					OR (pm.no_pesanan IS NOT NULL AND pm.no_pesanan != '' AND pm.no_pesanan != '-'))
				  AND pm.tanggal_so IS NOT NULL 
				  AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND pm.tanggal_so > '1970-01-01'
				  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
			) u";
		}

		$where_conditions = [];
		if (!empty($filter)) {
			$f_esc = $this->db->escape_like_str($filter);
			$where_conditions[] = "(nama LIKE '%" . $f_esc . "%' OR phone LIKE '%" . $f_esc . "%' OR source LIKE '%" . $f_esc . "%' OR resi LIKE '%" . $f_esc . "%' OR raw_resi LIKE '%" . $f_esc . "%' OR pesanan LIKE '%" . $f_esc . "%' OR catatan LIKE '%" . $f_esc . "%')";
		}
		if (!empty($period_filter)) {
			$period_esc = $this->db->escape_str($period_filter);
			$where_conditions[] = "DATE_FORMAT(tanggal, '%Y-%m') = '" . $period_esc . "'";
		}
		if (!empty($where_conditions)) {
			$sql .= " WHERE " . implode(" AND ", $where_conditions);
		}

		$sql .= " GROUP BY cust_group_key ORDER BY MAX(created_at) DESC, last_order_date DESC";
		
		$all_rows = $this->db->query($sql)->result();

		// Enhance each row with RFM calculation
		$enhanced_rows = [];
		$total_orders_sum = 0;
		$total_spend_sum = 0;
		foreach ($all_rows as $r) {
			$r->total_orders = (int)$r->total_orders;
			$r->total_spend = (float)$r->total_spend;

			$ref_date = null;
			if (!empty($period_filter)) {
				$ref_date = date('Y-m-t 23:59:59', strtotime($period_filter . '-01'));
				if ($ref_date > date('Y-m-d H:i:s')) {
					$ref_date = date('Y-m-d H:i:s');
				}
			}

			$r->rfm = $this->calculate_rfm($r->last_order_date, $r->total_orders, $r->total_spend, $thresholds, $ref_date);

			if (!empty($rfm_segment_filter)) {
				if (strcasecmp($r->rfm['segment'], $rfm_segment_filter) !== 0) {
					continue;
				}
			}

			$total_orders_sum += $r->total_orders;
			$total_spend_sum += $r->total_spend;
			$enhanced_rows[] = $r;
		}

		$count = count($enhanced_rows);
		$paged_rows = array_slice($enhanced_rows, $offset, $limit);

		// Attach pending followups count for paged rows (handles both phone and resi matching)
		if (!empty($paged_rows)) {
			foreach ($paged_rows as $pr) {
				$pr->pending_followups = 0;
			}
			$phones = array_filter(array_map(function($r) { return ($r->customer_phone && $r->customer_phone !== '-') ? $r->customer_phone : null; }, $paged_rows));
			$resis = array_filter(array_map(function($r) { return (!empty($r->nomor_resi) && $r->nomor_resi !== '-') ? $r->nomor_resi : null; }, $paged_rows));
			if (!empty($phones) || !empty($resis)) {
				$this->db->select('customer_phone, nomor_resi, COUNT(*) as cnt')
					->from('crm_transaction_followup_labels')
					->where('status_label', 'Pending');
				$this->db->group_start();
				if (!empty($phones)) {
					$this->db->where_in('customer_phone', array_values(array_unique($phones)));
				}
				if (!empty($resis)) {
					if (!empty($phones)) {
						$this->db->or_where_in('nomor_resi', array_values(array_unique($resis)));
					} else {
						$this->db->where_in('nomor_resi', array_values(array_unique($resis)));
					}
				}
				$this->db->group_end();
				$this->db->group_by(['customer_phone', 'nomor_resi']);
				$pending_counts = $this->db->get()->result();
				foreach ($pending_counts as $pc) {
					foreach ($paged_rows as $pr) {
						if (($pc->customer_phone && $pr->customer_phone === $pc->customer_phone) || ($pc->nomor_resi && $pr->nomor_resi === $pc->nomor_resi)) {
							$pr->pending_followups += (int)$pc->cnt;
						}
					}
				}
			}
		}

		return [
			'rows' => $paged_rows, 
			'total' => $count,
			'total_orders' => $total_orders_sum,
			'total_spend' => $total_spend_sum
		];
	}

	/**
	 * Get RFM Segmentation Breakdown for Dashboard Cards
	 */
	public function get_rfm_dashboard_distribution($product_filter = '', $period_filter = '', $category_filter = '')
	{
		$result = $this->get_customers('', 10000, 0, '', $product_filter, $period_filter, $category_filter);
		$rows = $result['rows'];
		$total = count($rows);

		$distribution = [
			'Champions' => 0,
			'Loyal Customers' => 0,
			'Potential Loyalist' => 0,
			'New Customers' => 0,
			'Big Spenders' => 0,
			'Frequent Low Value' => 0,
			'Need Attention' => 0,
			'At Risk Customers' => 0,
			"Can't Lose Them" => 0,
			'Hibernating' => 0,
		];

		foreach ($rows as $r) {
			$seg = $r->rfm['segment'];
			if (!isset($distribution[$seg])) {
				$distribution[$seg] = 0;
			}
			$distribution[$seg]++;
		}

		$formatted = [];
		foreach ($distribution as $seg => $cnt) {
			$pct = $total > 0 ? round(($cnt / $total) * 100, 1) : 0;
			$badge = $this->get_rfm_badge_style($seg);
			$formatted[] = [
				'segment' => $seg,
				'count' => $cnt,
				'percentage' => $pct,
				'badge' => $badge
			];
		}

		return ['total' => $total, 'segments' => $formatted];
	}

	/**
	 * Helper: build SQL phone condition matching raw, canonical, zero-prefix, 62-prefix, or 9-digit tail
	 */
	private function get_phone_where_clause($column, $phone)
	{
		$phone_esc = $this->db->escape_str($phone);
		$clean = preg_replace('/[^0-9]/', '', (string)$phone);
		if (empty($clean)) {
			return $column . " = '" . $phone_esc . "'";
		}
		
		$raw_tail = strlen($clean) >= 9 ? substr($clean, -9) : $clean;
		$zero_format = '0' . (substr($clean, 0, 2) === '62' ? substr($clean, 2) : (substr($clean, 0, 1) === '0' ? substr($clean, 1) : $clean));
		$sixty_format = '62' . (substr($clean, 0, 2) === '62' ? substr($clean, 2) : (substr($clean, 0, 1) === '0' ? substr($clean, 1) : $clean));
		
		$zero_esc = $this->db->escape_str($zero_format);
		$sixty_esc = $this->db->escape_str($sixty_format);
		$tail_esc = $this->db->escape_str($raw_tail);

		$clean_col = "REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(" . $column . ", ' ', ''), '-', ''), '+', ''), '(', ''), ')', '')";

		return "(" . $column . " = '" . $phone_esc . "' OR " . $column . " = '" . $zero_esc . "' OR " . $column . " = '" . $sixty_esc . "' OR " . $clean_col . " = '" . $zero_esc . "' OR " . $clean_col . " = '" . $sixty_esc . "' OR (LENGTH(" . $clean_col . ") >= 9 AND RIGHT(" . $clean_col . ", 9) = '" . $tail_esc . "'))";
	}

	/**
	 * Build SQL conditions and resolve customer identities across pelanggan, SO, and PM
	 */
	public function resolve_customer_criteria($phone)
	{
		$phone_str = trim((string)$phone);
		$clean_digits = preg_replace('/[^0-9]/', '', $phone_str);
		$tail9 = strlen($clean_digits) >= 9 ? substr($clean_digits, -9) : '';

		$pelanggan_ids = [];
		$customer_name = '';
		$customer_phone = $phone_str;

		if (strpos($phone_str, 'RESI_') === 0) {
			$resi_esc = $this->db->escape_str(substr($phone_str, 5));
			$where_so = "(so.nomor_resi = '" . $resi_esc . "' OR so.no_pesanan = '" . $resi_esc . "')";
			$where_pm = "(pm.nomor_resi = '" . $resi_esc . "' OR pm.no_pesanan = '" . $resi_esc . "')";
			$where_lbl = "(customer_phone = '" . $resi_esc . "' OR nomor_resi = '" . $resi_esc . "' OR no_pesanan = '" . $resi_esc . "')";
			
			$pm_match = $this->db->query("SELECT pelanggan_id, nama_penerima, no_telepon FROM penjualan_marketplace WHERE nomor_resi = '" . $resi_esc . "' OR no_pesanan = '" . $resi_esc . "' LIMIT 1")->row();
			if ($pm_match) {
				if (!empty($pm_match->pelanggan_id)) $pelanggan_ids[] = (int)$pm_match->pelanggan_id;
				if (!empty($pm_match->nama_penerima)) $customer_name = $pm_match->nama_penerima;
				if (!empty($pm_match->no_telepon) && $pm_match->no_telepon !== '-' && strpos($pm_match->no_telepon, '*') === false) $customer_phone = $pm_match->no_telepon;
			}
			$so_match = $this->db->query("SELECT pelanggan_id, nama_penerima, no_telepon FROM sales_order WHERE nomor_resi = '" . $resi_esc . "' OR no_pesanan = '" . $resi_esc . "' LIMIT 1")->row();
			if ($so_match) {
				if (!empty($so_match->pelanggan_id)) $pelanggan_ids[] = (int)$so_match->pelanggan_id;
				if (empty($customer_name) && !empty($so_match->nama_penerima)) $customer_name = $so_match->nama_penerima;
				if ((empty($customer_phone) || strpos($customer_phone, 'RESI_') === 0) && !empty($so_match->no_telepon)) $customer_phone = $so_match->no_telepon;
			}
		} elseif (strpos($phone_str, 'ORD_') === 0) {
			$ord_esc = $this->db->escape_str(substr($phone_str, 4));
			$where_so = "(so.no_pesanan = '" . $ord_esc . "' OR so.nomor_resi = '" . $ord_esc . "')";
			$where_pm = "(pm.no_pesanan = '" . $ord_esc . "' OR pm.nomor_resi = '" . $ord_esc . "')";
			$where_lbl = "(customer_phone = '" . $ord_esc . "' OR no_pesanan = '" . $ord_esc . "' OR nomor_resi = '" . $ord_esc . "')";

			$pm_match = $this->db->query("SELECT pelanggan_id, nama_penerima, no_telepon FROM penjualan_marketplace WHERE no_pesanan = '" . $ord_esc . "' OR nomor_resi = '" . $ord_esc . "' LIMIT 1")->row();
			if ($pm_match) {
				if (!empty($pm_match->pelanggan_id)) $pelanggan_ids[] = (int)$pm_match->pelanggan_id;
				if (!empty($pm_match->nama_penerima)) $customer_name = $pm_match->nama_penerima;
				if (!empty($pm_match->no_telepon) && $pm_match->no_telepon !== '-' && strpos($pm_match->no_telepon, '*') === false) $customer_phone = $pm_match->no_telepon;
			}
		} elseif (strpos($phone_str, 'CUST_PM_') === 0) {
			$pm_id = (int)substr($phone_str, 8);
			$where_so = "1=0";
			$where_pm = "pm.id = " . $pm_id;
			$where_lbl = "order_table = 'penjualan_marketplace' AND order_id = " . $pm_id;
			$pm_match = $this->db->get_where('penjualan_marketplace', ['id' => $pm_id])->row();
			if ($pm_match) {
				if (!empty($pm_match->pelanggan_id)) $pelanggan_ids[] = (int)$pm_match->pelanggan_id;
				if (!empty($pm_match->nama_penerima)) $customer_name = $pm_match->nama_penerima;
				if (!empty($pm_match->no_telepon)) $customer_phone = $pm_match->no_telepon;
			}
		} elseif (strpos($phone_str, 'CUST_SO_') === 0) {
			$so_id = (int)substr($phone_str, 8);
			$where_so = "so.id = " . $so_id;
			$where_pm = "1=0";
			$where_lbl = "order_table = 'sales_order' AND order_id = " . $so_id;
			$so_match = $this->db->get_where('sales_order', ['id' => $so_id])->row();
			if ($so_match) {
				if (!empty($so_match->pelanggan_id)) $pelanggan_ids[] = (int)$so_match->pelanggan_id;
				if (!empty($so_match->nama_penerima)) $customer_name = $so_match->nama_penerima;
				if (!empty($so_match->no_telepon)) $customer_phone = $so_match->no_telepon;
			}
		} else {
			$raw_esc = $this->db->escape_str($phone_str);
			$is_direct_resi = false;
			$pm_resi_match = $this->db->query("SELECT id, pelanggan_id, nama_penerima, no_telepon FROM penjualan_marketplace WHERE nomor_resi = '{$raw_esc}' OR no_pesanan = '{$raw_esc}' LIMIT 1")->row();
			$so_resi_match = !$pm_resi_match ? $this->db->query("SELECT id, pelanggan_id, nama_penerima, no_telepon FROM sales_order WHERE nomor_resi = '{$raw_esc}' OR no_pesanan = '{$raw_esc}' LIMIT 1")->row() : null;

			if ($pm_resi_match || $so_resi_match) {
				$is_direct_resi = true;
				$target_match = $pm_resi_match ?: $so_resi_match;
				if (!empty($target_match->pelanggan_id)) $pelanggan_ids[] = (int)$target_match->pelanggan_id;
				if (!empty($target_match->nama_penerima)) $customer_name = $target_match->nama_penerima;
				if (!empty($target_match->no_telepon) && $target_match->no_telepon !== '-' && strpos($target_match->no_telepon, '*') === false) $customer_phone = $target_match->no_telepon;

				$where_lbl = "(customer_phone = '{$raw_esc}' OR nomor_resi = '{$raw_esc}' OR no_pesanan = '{$raw_esc}')";
			} else {
				$where_lbl = $this->get_phone_where_clause('customer_phone', $phone_str);
			}

			$pel_cond = [];
			if (!empty($tail9)) {
				$clean_col_telp = "REPLACE(REPLACE(REPLACE(REPLACE(telepon, ' ', ''), '-', ''), '+', ''), '(', '')";
				$clean_col_no_telp = "REPLACE(REPLACE(REPLACE(REPLACE(no_telp, ' ', ''), '-', ''), '+', ''), '(', '')";
				$pel_cond[] = "(LENGTH({$clean_col_telp}) >= 9 AND RIGHT({$clean_col_telp}, 9) = '{$tail9}')";
				$pel_cond[] = "(LENGTH({$clean_col_no_telp}) >= 9 AND RIGHT({$clean_col_no_telp}, 9) = '{$tail9}')";
			}
			if (strpos($phone_str, 'CUST-') === 0) {
				$pel_cond[] = "kode_pelanggan = " . $this->db->escape($phone_str);
			} elseif (is_numeric($phone_str) && strlen($phone_str) <= 6) {
				$pel_cond[] = "id = " . (int)$phone_str;
			} elseif (strlen($phone_str) >= 3 && empty($tail9)) {
				$pel_cond[] = "LOWER(nama_pelanggan) = " . $this->db->escape(strtolower($phone_str));
			}

			if (!empty($pel_cond)) {
				$pel_rows = $this->db->query("SELECT id, nama_pelanggan, telepon, no_telp FROM pelanggan WHERE " . implode(' OR ', $pel_cond))->result();
				foreach ($pel_rows as $pr) {
					$pelanggan_ids[] = (int)$pr->id;
					if (empty($customer_name) && !empty($pr->nama_pelanggan) && $pr->nama_pelanggan !== '-') {
						$customer_name = $pr->nama_pelanggan;
					}
					if (!empty($pr->telepon) && $pr->telepon !== '-' && strpos($pr->telepon, '*') === false) {
						$customer_phone = $pr->telepon;
					} elseif (!empty($pr->no_telp) && $pr->no_telp !== '-' && strpos($pr->no_telp, '*') === false) {
						$customer_phone = $pr->no_telp;
					}
				}
			}

			$pel_extra_so = !empty($pelanggan_ids) ? " OR so.pelanggan_id IN (" . implode(',', array_unique($pelanggan_ids)) . ")" : "";
			$pel_extra_pm = !empty($pelanggan_ids) ? " OR pm.pelanggan_id IN (" . implode(',', array_unique($pelanggan_ids)) . ")" : "";

			if ($is_direct_resi) {
				$cond_so_base = "(so.nomor_resi = '{$raw_esc}' OR so.no_pesanan = '{$raw_esc}')";
				$cond_pm_base = "(pm.nomor_resi = '{$raw_esc}' OR pm.no_pesanan = '{$raw_esc}')";
			} else {
				$cond_so_base = $this->get_phone_where_clause('so.no_telepon', $phone_str);
				$cond_pm_base = $this->get_phone_where_clause('pm.no_telepon', $phone_str);
			}

			$where_so = "(" . $cond_so_base . $pel_extra_so . ") AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))";
			$where_pm = "(" . $cond_pm_base . $pel_extra_pm . ")";
		}

		if (empty($customer_name) && !empty($pelanggan_ids)) {
			$p_row = $this->db->query("SELECT nama_pelanggan FROM pelanggan WHERE id IN (" . implode(',', array_unique($pelanggan_ids)) . ") AND nama_pelanggan IS NOT NULL AND nama_pelanggan != '-' LIMIT 1")->row();
			if ($p_row && !empty($p_row->nama_pelanggan)) {
				$customer_name = $p_row->nama_pelanggan;
			}
		}

		return [
			'where_so'        => $where_so,
			'where_pm'        => $where_pm,
			'where_lbl'       => $where_lbl,
			'pelanggan_ids'   => array_unique($pelanggan_ids),
			'customer_name'   => $customer_name,
			'customer_phone'  => $customer_phone,
		];
	}

	/**
	 * Get customer summary stats (FA-04)
	 */
	public function get_customer_summary($phone, $product_filter = '')
	{
		$crit = $this->resolve_customer_criteria($phone);
		$where_so = $crit['where_so'];
		$where_pm = $crit['where_pm'];
		$where_lbl = $crit['where_lbl'];
		$display_phone = $crit['customer_phone'];
		$fallback_name = $crit['customer_name'];

		// Product filter: JOIN to item tables and filter by product name
		$so_join = '';
		$so_product_where = '';
		$pm_join = '';
		$pm_product_where = '';
		if (!empty($product_filter)) {
			$clean_pf = trim(preg_replace('/\s*\([^)]*\)$/', '', $product_filter));
			$pf_esc = $this->db->escape(trim($product_filter));
			$clean_pf_esc = $this->db->escape($clean_pf);
			$like_pf = $this->db->escape_like_str($clean_pf);

			$so_join = "INNER JOIN sales_order_item soi ON soi.so_id = so.id LEFT JOIN produk p ON soi.produk_id = p.id";
			$so_product_where = " AND (
				TRIM(REGEXP_REPLACE(soi.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pf_esc}
				OR soi.catatan = {$pf_esc}
				OR soi.catatan LIKE '{$like_pf}%'
				OR ((soi.catatan IS NULL OR soi.catatan = '' OR soi.catatan LIKE '%Produk%') AND p.id > 1 AND p.nama_produk = {$clean_pf_esc})
			)";
			$pm_join = "INNER JOIN penjualan_marketplace_item pmi ON pmi.penjualan_marketplace_id = pm.id LEFT JOIN produk p2 ON pmi.produk_id = p2.id";
			$pm_product_where = " AND (
				TRIM(REGEXP_REPLACE(pmi.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pf_esc}
				OR pmi.catatan = {$pf_esc}
				OR pmi.catatan LIKE '{$like_pf}%'
				OR ((pmi.catatan IS NULL OR pmi.catatan = '' OR pmi.catatan LIKE '%Produk%') AND p2.id > 1 AND p2.nama_produk = {$clean_pf_esc})
			)";

			// Get total spend from SO item subtotal for this product
			$so_spend = $this->get_query_sum("SELECT COALESCE(SUM(soi.subtotal),0) as t FROM sales_order so " . $so_join . " WHERE " . $where_so . $so_product_where);
			
			// Get total spend from marketplace item subtotal for this product
			$mp_spend = $this->get_query_sum("SELECT COALESCE(SUM(pmi.subtotal),0) as t FROM penjualan_marketplace pm " . $pm_join . " WHERE " . $where_pm . $pm_product_where);
		} else {
			// Get overall total spend across all products
			$so_spend = $this->get_query_sum("SELECT COALESCE(SUM(so.total),0) as t FROM sales_order so WHERE " . $where_so);
			$mp_spend = $this->get_query_sum("SELECT COALESCE(SUM(pm.total),0) as t FROM penjualan_marketplace pm WHERE " . $where_pm);
		}

		// Get order counts
		$so_count = $this->get_query_count("SELECT COUNT(DISTINCT so.id) as cnt FROM sales_order so " . $so_join . " WHERE " . $where_so . $so_product_where);
		$mp_count = $this->get_query_count("SELECT COUNT(DISTINCT pm.id) as cnt FROM penjualan_marketplace pm " . $pm_join . " WHERE " . $where_pm . $pm_product_where);

		// Get dates & names
		$dates_so = $this->db->query("SELECT MIN(so.tanggal_so) as first_order, MAX(so.tanggal_so) as last_order, MAX(so.nama_penerima) as nama FROM sales_order so " . $so_join . " WHERE " . $where_so . $so_product_where)->row();
		$dates_pm = $this->db->query("SELECT MIN(pm.tanggal_so) as first_order, MAX(pm.tanggal_so) as last_order, MAX(pm.nama_penerima) as nama, GROUP_CONCAT(DISTINCT COALESCE(lbl.order_source, CASE WHEN LOWER(pm.source) LIKE '%tokopedia%' THEN 'Tokopedia' WHEN LOWER(pm.source) LIKE '%tiktok%' THEN 'TikTok Shop' WHEN LOWER(pm.source) LIKE '%shopee%' THEN 'Shopee' WHEN LOWER(pm.no_pesanan) LIKE '%shp%' THEN 'Shopee' WHEN LOWER(pm.no_pesanan) LIKE '%tkp%' THEN 'Tokopedia' WHEN LOWER(pm.no_pesanan) LIKE '%ttk%' THEN 'TikTok Shop' ELSE 'Shopee' END) SEPARATOR ', ') as sources FROM penjualan_marketplace pm " . $pm_join . " LEFT JOIN crm_transaction_followup_labels lbl ON lbl.order_id = pm.id AND lbl.order_table = 'penjualan_marketplace' WHERE " . $where_pm . $pm_product_where)->row();

		$first_candidates = array_filter([$dates_so ? $dates_so->first_order : null, $dates_pm ? $dates_pm->first_order : null]);
		$last_candidates = array_filter([$dates_so ? $dates_so->last_order : null, $dates_pm ? $dates_pm->last_order : null]);

		$first_order = !empty($first_candidates) ? min($first_candidates) : null;
		$last_order = !empty($last_candidates) ? max($last_candidates) : null;

		$sources_arr = [];
		if ($so_count > 0) $sources_arr[] = 'Toko';
		if (!empty($dates_pm->sources)) {
			foreach (explode(', ', $dates_pm->sources) as $s) {
				if ($s && !in_array($s, $sources_arr)) $sources_arr[] = $s;
			}
		}
		$lbl_sources = $this->db->query("SELECT GROUP_CONCAT(DISTINCT order_source SEPARATOR ', ') as sources FROM crm_transaction_followup_labels WHERE " . $where_lbl)->row();
		if ($lbl_sources && !empty($lbl_sources->sources)) {
			foreach (explode(', ', $lbl_sources->sources) as $s) {
				if ($s && !in_array($s, $sources_arr)) $sources_arr[] = $s;
			}
		}

		$name = '-';
		if ($dates_so && !empty($dates_so->nama) && $dates_so->nama !== '-' && $dates_so->nama !== 'Customer') {
			$name = $dates_so->nama;
		} elseif ($dates_pm && !empty($dates_pm->nama) && $dates_pm->nama !== '-' && $dates_pm->nama !== 'Customer' && $dates_pm->nama !== 'Customer Marketplace') {
			$name = $dates_pm->nama;
		} elseif (!empty($fallback_name) && $fallback_name !== '-') {
			$name = $fallback_name;
		} else {
			$name_lbl = $this->db->query("SELECT customer_nama FROM crm_transaction_followup_labels WHERE (" . $where_lbl . ") AND customer_nama IS NOT NULL AND customer_nama != '-' AND customer_nama != '' LIMIT 1")->row();
			if ($name_lbl && !empty($name_lbl->customer_nama)) {
				$name = $name_lbl->customer_nama;
			} elseif (!empty($fallback_name)) {
				$name = $fallback_name;
			}
		}

		$total_spend = (float)$so_spend + (float)$mp_spend;
		$total_orders = (int)$so_count + (int)$mp_count;

		$thresholds = !empty($product_filter) ? $this->get_rfm_percentile_thresholds($product_filter) : null;
		$rfm = $this->calculate_rfm($last_order, $total_orders, $total_spend, $thresholds);

		return [
			'nama' => $name,
			'phone' => !empty($display_phone) ? $display_phone : $phone,
			'total_spend_toko' => (float)$so_spend,
			'total_spend_online' => (float)$mp_spend,
			'total_spend' => $total_spend,
			'order_count_toko' => (int)$so_count,
			'order_count_online' => (int)$mp_count,
			'total_orders' => $total_orders,
			'sources' => $sources_arr,
			'first_order' => $first_order,
			'last_order' => $last_order,
			'rfm' => $rfm,
		];
	}

	/**
	 * Get transaction history for a customer (FA-01, FA-02)
	 * UNION of sales_order + penjualan_marketplace
	 */
	public function get_customer_transactions($phone, $product_filter = '')
	{
		$crit = $this->resolve_customer_criteria($phone);
		$where_so = $crit['where_so'];
		$where_pm = $crit['where_pm'];
		$where_lbl = str_replace('customer_phone', 'lbl.customer_phone', $crit['where_lbl']);

		// Product filter JOINs
		$so_join = '';
		$so_product_where = '';
		$pm_join_extra = '';
		$pm_product_where = '';
		if (!empty($product_filter)) {
			$clean_pf = trim(preg_replace('/\s*\([^)]*\)$/', '', $product_filter));
			$pf_esc = $this->db->escape(trim($product_filter));
			$clean_pf_esc = $this->db->escape($clean_pf);
			$like_pf = $this->db->escape_like_str($clean_pf);

			$so_join = "INNER JOIN sales_order_item soi_f ON soi_f.so_id = so.id LEFT JOIN produk p_f ON soi_f.produk_id = p_f.id";
			$so_product_where = " AND (
				TRIM(REGEXP_REPLACE(soi_f.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pf_esc}
				OR soi_f.catatan = {$pf_esc}
				OR soi_f.catatan LIKE '{$like_pf}%'
				OR ((soi_f.catatan IS NULL OR soi_f.catatan = '' OR soi_f.catatan LIKE '%Produk%') AND p_f.id > 1 AND p_f.nama_produk = {$clean_pf_esc})
			)";
			$pm_join_extra = "INNER JOIN penjualan_marketplace_item pmi_f ON pmi_f.penjualan_marketplace_id = pm.id LEFT JOIN produk p2_f ON pmi_f.produk_id = p2_f.id";
			$pm_product_where = " AND (
				TRIM(REGEXP_REPLACE(pmi_f.catatan, '\\\\s*\\\\([^)]*\\\\)$', '')) = {$clean_pf_esc}
				OR pmi_f.catatan = {$pf_esc}
				OR pmi_f.catatan LIKE '{$like_pf}%'
				OR ((pmi_f.catatan IS NULL OR pmi_f.catatan = '' OR pmi_f.catatan LIKE '%Produk%') AND p2_f.id > 1 AND p2_f.nama_produk = {$clean_pf_esc})
			)";
		}

		$so_spend_col = !empty($product_filter) ? "COALESCE(SUM(soi_f.subtotal), so.total)" : "so.total";
		$pm_spend_col = !empty($product_filter) ? "COALESCE(SUM(pmi_f.subtotal), pm.total)" : "pm.total";
		$so_group_clause = !empty($product_filter) ? "GROUP BY so.id" : "";
		$pm_group_clause = !empty($product_filter) ? "GROUP BY pm.id" : "";

		$sql = "
			(SELECT DISTINCT
				CAST('sales_order' AS CHAR) COLLATE utf8mb4_unicode_ci as tbl, 
				so.id, 
				CAST(so.nomor_so AS CHAR) COLLATE utf8mb4_unicode_ci as nomor_so, 
				CAST(so.no_pesanan AS CHAR) COLLATE utf8mb4_unicode_ci as no_pesanan, 
				COALESCE(so.waktu_pembayaran, so.created_at, so.tanggal_so) as tanggal,
				COALESCE(so.tanggal_kirim, so.tanggal_so) as tanggal_kirim,
				CAST('Toko' AS CHAR) COLLATE utf8mb4_unicode_ci as sumber_penjualan,
				CAST(so.status AS CHAR) COLLATE utf8mb4_unicode_ci as status, 
				CAST(so.status_pesanan AS CHAR) COLLATE utf8mb4_unicode_ci as status_pesanan, 
				CAST(so.nomor_resi AS CHAR) COLLATE utf8mb4_unicode_ci as nomor_resi, 
				CAST(so.kurir_ekspedisi AS CHAR) COLLATE utf8mb4_unicode_ci as kurir_ekspedisi,
				CAST(so.nama_penerima AS CHAR) COLLATE utf8mb4_unicode_ci as nama_penerima, 
				CAST(so.no_telepon AS CHAR) COLLATE utf8mb4_unicode_ci as no_telepon, 
				CAST(so.alamat_pengiriman AS CHAR) COLLATE utf8mb4_unicode_ci as alamat_pengiriman,
				{$so_spend_col} as total, 
				CAST(COALESCE(
					" . (!empty($product_filter) ? $this->db->escape($product_filter) . ", " : "") . "
					NULLIF(so.nama_produk_marketplace, ''),
					(SELECT COALESCE(NULLIF(soi.catatan, ''), p.nama_produk) FROM sales_order_item soi LEFT JOIN produk p ON soi.produk_id = p.id WHERE soi.so_id = so.id ORDER BY soi.id ASC LIMIT 1),
					'Produk SO'
				) AS CHAR) COLLATE utf8mb4_unicode_ci as produk_ringkasan
			FROM sales_order so 
			" . $so_join . "
			WHERE " . $where_so . " AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))" . $so_product_where . "
			{$so_group_clause})
			UNION ALL
			(SELECT DISTINCT
				CAST('penjualan_marketplace' AS CHAR) COLLATE utf8mb4_unicode_ci as tbl, 
				pm.id, 
				CAST(pm.nomor_so AS CHAR) COLLATE utf8mb4_unicode_ci as nomor_so, 
				CAST(pm.no_pesanan AS CHAR) COLLATE utf8mb4_unicode_ci as no_pesanan, 
				COALESCE(pm.waktu_pembayaran, pm.created_at, pm.tanggal_so) as tanggal,
				pm.tanggal_so as tanggal_kirim,
				CAST(COALESCE(
					(SELECT order_source FROM crm_transaction_followup_labels WHERE order_id = pm.id AND order_table = 'penjualan_marketplace' LIMIT 1),
					CASE 
						WHEN LOWER(pm.source) LIKE '%tokopedia%' THEN 'Tokopedia'
						WHEN LOWER(pm.source) LIKE '%tiktok%' THEN 'TikTok Shop'
						WHEN LOWER(pm.source) LIKE '%shopee%' THEN 'Shopee'
						WHEN LOWER(pm.no_pesanan) LIKE '%shp%' THEN 'Shopee'
						WHEN LOWER(pm.no_pesanan) LIKE '%tkp%' THEN 'Tokopedia'
						WHEN LOWER(pm.no_pesanan) LIKE '%ttk%' THEN 'TikTok Shop'
						ELSE 'Shopee'
					END
				) AS CHAR) COLLATE utf8mb4_unicode_ci as sumber_penjualan,
				CAST(pm.status AS CHAR) COLLATE utf8mb4_unicode_ci as status, 
				CAST(pm.status_pesanan AS CHAR) COLLATE utf8mb4_unicode_ci as status_pesanan, 
				CAST(pm.nomor_resi AS CHAR) COLLATE utf8mb4_unicode_ci as nomor_resi, 
				CAST(pm.kurir_ekspedisi AS CHAR) COLLATE utf8mb4_unicode_ci as kurir_ekspedisi,
				CAST(pm.nama_penerima AS CHAR) COLLATE utf8mb4_unicode_ci as nama_penerima, 
				CAST(pm.no_telepon AS CHAR) COLLATE utf8mb4_unicode_ci as no_telepon, 
				CAST(pm.alamat_pengiriman AS CHAR) COLLATE utf8mb4_unicode_ci as alamat_pengiriman,
				{$pm_spend_col} as total, 
				CAST(COALESCE(
					" . (!empty($product_filter) ? $this->db->escape($product_filter) . ", " : "") . "
					NULLIF(pm.nama_produk_marketplace, ''),
					(SELECT COALESCE(NULLIF(pmi.catatan, ''), p.nama_produk) FROM penjualan_marketplace_item pmi LEFT JOIN produk p ON pmi.produk_id = p.id WHERE pmi.penjualan_marketplace_id = pm.id ORDER BY pmi.id ASC LIMIT 1),
					'Produk Marketplace'
				) AS CHAR) COLLATE utf8mb4_unicode_ci as produk_ringkasan
			FROM penjualan_marketplace pm 
			" . $pm_join_extra . "
			WHERE " . $where_pm . $pm_product_where . "
			{$pm_group_clause})";

		if (empty($product_filter)) {
			$sql .= " UNION ALL
			(SELECT 
				CAST('crm_transaction_followup_labels' AS CHAR) COLLATE utf8mb4_unicode_ci as tbl, 
				lbl.id, 
				CAST('' AS CHAR) COLLATE utf8mb4_unicode_ci as nomor_so, 
				CAST(COALESCE(NULLIF(lbl.no_pesanan,''), 'WA-INCOMING') AS CHAR) COLLATE utf8mb4_unicode_ci as no_pesanan, 
				COALESCE(lbl.tanggal_pengiriman, lbl.created_at) as tanggal,
				COALESCE(lbl.tanggal_pengiriman, lbl.created_at) as tanggal_kirim,
				CAST(lbl.order_source AS CHAR) COLLATE utf8mb4_unicode_ci as sumber_penjualan,
				CAST(lbl.status_label AS CHAR) COLLATE utf8mb4_unicode_ci as status, 
				CAST(lbl.status_label AS CHAR) COLLATE utf8mb4_unicode_ci as status_pesanan, 
				CAST(COALESCE(lbl.nomor_resi, '-') AS CHAR) COLLATE utf8mb4_unicode_ci as nomor_resi, 
				CAST('-' AS CHAR) COLLATE utf8mb4_unicode_ci as kurir_ekspedisi,
				CAST(lbl.customer_nama AS CHAR) COLLATE utf8mb4_unicode_ci as nama_penerima, 
				CAST(lbl.customer_phone AS CHAR) COLLATE utf8mb4_unicode_ci as no_telepon, 
				CAST('' AS CHAR) COLLATE utf8mb4_unicode_ci as alamat_pengiriman,
				COALESCE(lbl.converted_amount, 0) as total, 
				CAST('Transaksi Follow-up Toko/CRM' AS CHAR) COLLATE utf8mb4_unicode_ci as produk_ringkasan
			FROM crm_transaction_followup_labels lbl 
			WHERE " . $where_lbl . " AND (lbl.order_id = 0 OR lbl.order_id IS NULL))";
		}

		$sql .= " ORDER BY tanggal DESC, id DESC";

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
	 * Get product-level RFM metrics for a customer (Recency, Frequency, Monetary PER PRODUCT)
	 */
	public function get_customer_product_rfm($phone)
	{
		$crit = $this->resolve_customer_criteria($phone);
		$where_so = $crit['where_so'];
		$where_pm = $crit['where_pm'];

		$sql = "
			SELECT 
				MAX(item_data.produk_id) as produk_id,
				item_data.nama_produk,
				MAX(item_data.kode_produk) as kode_produk,
				MAX(item_data.tanggal_transaksi) as last_bought_date,
				DATEDIFF(CURRENT_DATE(), MAX(item_data.tanggal_transaksi)) as recency_days,
				COUNT(DISTINCT item_data.order_id) as order_count,
				SUM(item_data.qty) as total_qty,
				SUM(item_data.subtotal) as total_spend
			FROM (
				SELECT 
					soi.produk_id,
					CASE 
						WHEN soi.catatan IS NOT NULL AND TRIM(soi.catatan) != '' THEN TRIM(REGEXP_REPLACE(soi.catatan, '\\\\s*\\\\([^)]*\\\\)$', ''))
						ELSE COALESCE(p.nama_produk, 'Produk SO')
					END as nama_produk,
					COALESCE(p.kode_produk, '-') as kode_produk,
					so.tanggal_so as tanggal_transaksi,
					CONCAT('so_', so.id) as order_id,
					soi.qty,
					soi.subtotal
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				WHERE " . $where_so . "

				UNION ALL

				SELECT 
					pmi.produk_id,
					CASE 
						WHEN pmi.catatan IS NOT NULL AND TRIM(pmi.catatan) != '' THEN TRIM(REGEXP_REPLACE(pmi.catatan, '\\\\s*\\\\([^)]*\\\\)$', ''))
						ELSE COALESCE(p.nama_produk, 'Produk Marketplace')
					END as nama_produk,
					CASE
						WHEN p.id > 1 AND p.kode_produk IS NOT NULL THEN p.kode_produk
						WHEN pmi.sku IS NOT NULL AND pmi.sku != '' THEN pmi.sku
						ELSE '-'
					END as kode_produk,
					pm.tanggal_so as tanggal_transaksi,
					CONCAT('pm_', pm.id) as order_id,
					pmi.qty,
					pmi.subtotal
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p ON pmi.produk_id = p.id
				WHERE " . $where_pm . "
			) item_data
			GROUP BY item_data.nama_produk
			ORDER BY total_spend DESC, last_bought_date DESC
		";

		return $this->db->query($sql)->result();
	}

	/**
	 * Get list of all distinct products for dropdown filters with category info
	 */
	public function get_all_products_list($category_filter = '')
	{
		$where_conditions = ["u.item_name IS NOT NULL", "u.item_name != ''"];
		if (!empty($category_filter)) {
			$cf = $this->db->escape(trim($category_filter));
			$where_conditions[] = "(u.nama_kategori = " . $cf . " OR u.kategori_id = " . $cf . ")";
		}
		$where_sql = " WHERE " . implode(' AND ', $where_conditions);

		$sql = "
			SELECT DISTINCT u.item_name, u.nama_kategori, u.kategori_id FROM (
				SELECT 
					CASE 
						WHEN soi.catatan IS NOT NULL AND TRIM(soi.catatan) != '' THEN TRIM(REGEXP_REPLACE(soi.catatan, '\\\\s*\\\\([^)]*\\\\)$', ''))
						ELSE COALESCE(p.nama_produk, 'Produk SO')
					END as item_name,
					COALESCE(kp.nama_kategori, 'Tanpa Kategori') as nama_kategori,
					p.kategori_id
				FROM sales_order_item soi 
				LEFT JOIN produk p ON soi.produk_id = p.id
				LEFT JOIN kategori_produk kp ON kp.id = p.kategori_id
				WHERE (soi.catatan IS NOT NULL AND soi.catatan != '') OR (p.nama_produk IS NOT NULL AND p.nama_produk != '')

				UNION

				SELECT 
					CASE 
						WHEN pmi.catatan IS NOT NULL AND TRIM(pmi.catatan) != '' THEN TRIM(REGEXP_REPLACE(pmi.catatan, '\\\\s*\\\\([^)]*\\\\)$', ''))
						ELSE COALESCE(p.nama_produk, 'Produk Marketplace')
					END as item_name,
					COALESCE(kp.nama_kategori, 'Tanpa Kategori') as nama_kategori,
					p.kategori_id
				FROM penjualan_marketplace_item pmi 
				LEFT JOIN produk p ON pmi.produk_id = p.id
				LEFT JOIN kategori_produk kp ON kp.id = p.kategori_id
				WHERE (pmi.catatan IS NOT NULL AND pmi.catatan != '') OR (p.nama_produk IS NOT NULL AND p.nama_produk != '')
			) u
			" . $where_sql . "
			ORDER BY u.nama_kategori ASC, u.item_name ASC
		";
		return $this->db->query($sql)->result();
	}

	/**
	 * Get list of all categories for dropdown filters
	 */
	public function get_all_categories_list()
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
		return $this->db->query($sql)->result();
	}

	/**
	 * Get list of available distinct months/periods for filter dropdowns
	 */
	public function get_distinct_months_list()
	{
		$sql = "
			SELECT DISTINCT 
				DATE_FORMAT(tanggal_so, '%Y-%m') as ym_val,
				DATE_FORMAT(tanggal_so, '%M %Y') as ym_label
			FROM (
				SELECT tanggal_so FROM sales_order 
				WHERE tanggal_so IS NOT NULL 
				  AND CAST(tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND tanggal_so > '1970-01-01'

				UNION ALL

				SELECT tanggal_so FROM penjualan_marketplace 
				WHERE tanggal_so IS NOT NULL 
				  AND CAST(tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND tanggal_so > '1970-01-01'
			) d
			WHERE DATE_FORMAT(tanggal_so, '%Y-%m') IS NOT NULL 
			  AND DATE_FORMAT(tanggal_so, '%Y-%m') != '0000-00'
			ORDER BY ym_val DESC
		";
		return $this->db->query($sql)->result();
	}

	/**
	 * Get list of available distinct years for filter dropdowns
	 */
	public function get_distinct_years_list()
	{
		$sql = "
			SELECT DISTINCT YEAR(tanggal_so) as yr 
			FROM (
				SELECT tanggal_so FROM sales_order 
				WHERE tanggal_so IS NOT NULL 
				  AND CAST(tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND tanggal_so > '1970-01-01'

				UNION ALL

				SELECT tanggal_so FROM penjualan_marketplace 
				WHERE tanggal_so IS NOT NULL 
				  AND CAST(tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND tanggal_so > '1970-01-01'
			) d
			WHERE YEAR(tanggal_so) IS NOT NULL AND YEAR(tanggal_so) > 1970
			ORDER BY yr DESC
		";
		return $this->db->query($sql)->result();
	}

	/**
	 * Get monthly RFM tracking & trend data per product
	 */
	public function get_monthly_rfm_tracking_per_product($product_filter = '', $period_filter = '', $year_filter = '', $category_filter = '')
	{
		$where_conds = [];
		if (!empty($product_filter)) {
			$pf = $this->db->escape(trim($product_filter));
			$where_conds[] = "(TRIM(t_data.nama_produk) = " . $pf . ")";
		}
		if (!empty($category_filter)) {
			$cf = $this->db->escape(trim($category_filter));
			$where_conds[] = "(TRIM(t_data.nama_kategori) = " . $cf . " OR t_data.kategori_id = " . $cf . ")";
		}
		if (!empty($year_filter)) {
			$y_esc = $this->db->escape_str($year_filter);
			$where_conds[] = "(YEAR(t_data.tanggal_so) = '" . $y_esc . "')";
		}

		$where_sql = !empty($where_conds) ? "WHERE " . implode(' AND ', $where_conds) : "";

		$sql = "SELECT 
				DATE_FORMAT(t_data.tanggal_so, '%Y-%m') as ym_period,
				DATE_FORMAT(t_data.tanggal_so, '%M %Y') as period_label,
				COUNT(DISTINCT t_data.clean_phone) as unique_buyers,
				COUNT(DISTINCT t_data.order_id) as total_orders,
				SUM(t_data.qty) as total_qty,
				SUM(t_data.subtotal) as total_spend,
				SUM(t_data.subtotal - t_data.total_hpp) as total_profit,
				SUM(t_data.total_hpp) as total_hpp,
				COUNT(DISTINCT t_data.nama_produk) as total_products,
				ROUND(COALESCE(SUM(t_data.subtotal) / NULLIF(COUNT(DISTINCT t_data.order_id), 0), 0), 2) as avg_order_value,
				ROUND(AVG(DATEDIFF(CURRENT_DATE(), t_data.tanggal_so)), 0) as avg_recency_days
			FROM (
				SELECT 
					RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(so.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10) as clean_phone,
					so.tanggal_so,
					CONCAT('so_', so.id) as order_id,
					soi.qty,
					COALESCE(soi.subtotal, (soi.qty * soi.harga_satuan), 0) as subtotal,
					(soi.qty * (CASE WHEN (p.harga_beli > 0 AND p.harga_beli < soi.harga_satuan) THEN p.harga_beli ELSE (soi.harga_satuan * 0.65) END)) as total_hpp,
					COALESCE(p.nama_produk, soi.catatan, 'Produk SO') as nama_produk,
					COALESCE(kp.nama_kategori, 'Tanpa Kategori') as nama_kategori,
					p.kategori_id
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				LEFT JOIN kategori_produk kp ON kp.id = p.kategori_id
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
				  AND so.tanggal_so IS NOT NULL 
				  AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND so.tanggal_so > '1970-01-01'
				  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))

				UNION ALL

				SELECT 
					RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(pm.no_telepon, ' ', ''), '-', ''), '+', ''), '628', '08'), 10) as clean_phone,
					pm.tanggal_so,
					CONCAT('pm_', pm.id) as order_id,
					pmi.qty,
					COALESCE(pmi.subtotal, (pmi.qty * pmi.harga_satuan), 0) as subtotal,
					(pmi.qty * (CASE WHEN (p2.harga_beli > 0 AND p2.harga_beli < pmi.harga_satuan) THEN p2.harga_beli ELSE (pmi.harga_satuan * 0.65) END)) as total_hpp,
					COALESCE(p2.nama_produk, pmi.catatan, pm.nama_produk_marketplace, 'Produk Marketplace') as nama_produk,
					COALESCE(kp2.nama_kategori, 'Tanpa Kategori') as nama_kategori,
					p2.kategori_id
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p2 ON pmi.produk_id = p2.id
				LEFT JOIN kategori_produk kp2 ON kp2.id = p2.kategori_id
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL 
				  AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND pm.tanggal_so > '1970-01-01'
				  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
			) t_data 
";

		if (!empty($where_sql)) {
			$sql .= " " . $where_sql;
		}

		$sql .= " GROUP BY ym_period, period_label ORDER BY ym_period DESC";

		$all_rows = $this->db->query($sql)->result();

		// Calculate MoM growth percentage for spend & profit chronologically
		for ($i = 0; $i < count($all_rows); $i++) {
			$all_rows[$i]->unique_buyers = (int)$all_rows[$i]->unique_buyers;
			$all_rows[$i]->total_orders = (int)$all_rows[$i]->total_orders;
			$all_rows[$i]->total_qty = (float)$all_rows[$i]->total_qty;
			$all_rows[$i]->total_spend = (float)$all_rows[$i]->total_spend;
			$all_rows[$i]->total_profit = (float)$all_rows[$i]->total_profit;
			$all_rows[$i]->total_hpp = (float)$all_rows[$i]->total_hpp;
			$all_rows[$i]->avg_recency_days = (int)$all_rows[$i]->avg_recency_days;
			$all_rows[$i]->product_label = !empty($product_filter) ? $product_filter : 'Semua Produk';
			$all_rows[$i]->avg_order_value = $all_rows[$i]->total_orders > 0 
				? round($all_rows[$i]->total_spend / $all_rows[$i]->total_orders, 2) 
				: (float)($all_rows[$i]->avg_order_value ?? 0.0);

			$prev_spend = isset($all_rows[$i + 1]) ? (float)$all_rows[$i + 1]->total_spend : 0;
			$prev_profit = isset($all_rows[$i + 1]) ? (float)$all_rows[$i + 1]->total_profit : 0;

			$all_rows[$i]->prev_spend = $prev_spend;
			$all_rows[$i]->prev_profit = $prev_profit;

			if ($prev_spend > 0) {
				$all_rows[$i]->mom_growth_pct = round((($all_rows[$i]->total_spend - $prev_spend) / $prev_spend) * 100, 1);
			} else {
				$all_rows[$i]->mom_growth_pct = 0.0;
			}

			if ($prev_profit != 0) {
				$all_rows[$i]->profit_growth_pct = round((($all_rows[$i]->total_profit - $prev_profit) / abs($prev_profit)) * 100, 1);
			} else {
				$all_rows[$i]->profit_growth_pct = 0.0;
			}

			$all_rows[$i]->spend_status = ($all_rows[$i]->total_spend >= $prev_spend) ? 'naik' : 'turun';

			if ($all_rows[$i]->total_profit < 0) {
				$all_rows[$i]->profit_status = 'rugi';
			} else {
				$all_rows[$i]->profit_status = ($all_rows[$i]->total_profit >= $prev_profit) ? 'naik' : 'turun';
			}
		}

		if (!empty($period_filter)) {
			$filtered = [];
			foreach ($all_rows as $row) {
				if ($row->ym_period === $period_filter) {
					$filtered[] = $row;
				}
			}
			return $filtered;
		}

		return $all_rows;
	}

	/**
	 * Get top selling products for a specific month
	 */
	public function get_top_products_by_month($ym_period, $product_filter = '', $limit = 5)
	{
		if (empty($ym_period)) return [];

		$where_conds = ["DATE_FORMAT(t_data.tanggal_so, '%Y-%m') = '" . $this->db->escape_str($ym_period) . "'"];
		if (!empty($product_filter)) {
			$pf = $this->db->escape(trim($product_filter));
			$where_conds[] = "(TRIM(t_data.nama_produk) = " . $pf . ")";
		}
		$where_sql = "WHERE " . implode(' AND ', $where_conds);

		$sql = "SELECT 
				t_data.nama_produk,
				COUNT(DISTINCT t_data.order_id) as total_orders,
				SUM(t_data.qty) as total_qty,
				SUM(t_data.subtotal) as total_spend
			FROM (
				SELECT 
					so.tanggal_so,
					CONCAT('so_', so.id) as order_id,
					soi.qty,
					COALESCE(soi.subtotal, (soi.qty * soi.harga_satuan), 0) as subtotal,
					COALESCE(p.nama_produk, soi.catatan, 'Produk SO') as nama_produk
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
				  AND so.tanggal_so IS NOT NULL 
				  AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND so.tanggal_so > '1970-01-01'
				  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))

				UNION ALL

				SELECT 
					pm.tanggal_so,
					CONCAT('pm_', pm.id) as order_id,
					pmi.qty,
					COALESCE(pmi.subtotal, (pmi.qty * pmi.harga_satuan), 0) as subtotal,
					COALESCE(p2.nama_produk, pmi.catatan, pm.nama_produk_marketplace, 'Produk Marketplace') as nama_produk
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p2 ON pmi.produk_id = p2.id
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL 
				  AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND pm.tanggal_so > '1970-01-01'
				  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
			) t_data ";

		if (!empty($where_sql)) {
			$sql .= " " . $where_sql;
		}

		$sql .= " GROUP BY t_data.nama_produk ORDER BY total_spend DESC LIMIT " . (int)$limit;

		return $this->db->query($sql)->result();
	}

	/**
	 * Get platform sales breakdown for a specific month
	 */
	public function get_platform_breakdown_by_month($ym_period, $product_filter = '')
	{
		if (empty($ym_period)) return [];

		$where_conds = ["DATE_FORMAT(t_data.tanggal_so, '%Y-%m') = '" . $this->db->escape_str($ym_period) . "'"];
		if (!empty($product_filter)) {
			$pf = $this->db->escape(trim($product_filter));
			$where_conds[] = "(TRIM(t_data.nama_produk) = " . $pf . ")";
		}
		$where_sql = "WHERE " . implode(' AND ', $where_conds);

		$sql = "SELECT 
				t_data.sumber_penjualan,
				COUNT(DISTINCT t_data.order_id) as total_orders,
				SUM(t_data.subtotal) as total_spend
			FROM (
				SELECT 
					so.tanggal_so,
					CONCAT('so_', so.id) as order_id,
					'Toko Direct' as sumber_penjualan,
					COALESCE(soi.subtotal, (soi.qty * soi.harga_satuan), 0) as subtotal,
					COALESCE(p.nama_produk, soi.catatan, 'Produk SO') as nama_produk
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
				  AND so.tanggal_so IS NOT NULL 
				  AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND so.tanggal_so > '1970-01-01'
				  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))

				UNION ALL

				SELECT 
					pm.tanggal_so,
					CONCAT('pm_', pm.id) as order_id,
					CASE 
						WHEN LOWER(pm.source) LIKE '%tokopedia%' THEN 'Tokopedia'
						WHEN LOWER(pm.source) LIKE '%tiktok%' THEN 'TikTok Shop'
						WHEN LOWER(pm.source) LIKE '%shopee%' THEN 'Shopee'
						WHEN LOWER(pm.no_pesanan) LIKE '%shp%' THEN 'Shopee'
						WHEN LOWER(pm.no_pesanan) LIKE '%tkp%' THEN 'Tokopedia'
						WHEN LOWER(pm.no_pesanan) LIKE '%ttk%' THEN 'TikTok Shop'
						ELSE 'Marketplace'
					END as sumber_penjualan,
					COALESCE(pmi.subtotal, (pmi.qty * pmi.harga_satuan), 0) as subtotal,
					COALESCE(p2.nama_produk, pmi.catatan, pm.nama_produk_marketplace, 'Produk Marketplace') as nama_produk
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p2 ON pmi.produk_id = p2.id
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL 
				  AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND pm.tanggal_so > '1970-01-01'
				  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
			) t_data ";

		if (!empty($where_sql)) {
			$sql .= " " . $where_sql;
		}

		$sql .= " GROUP BY t_data.sumber_penjualan ORDER BY total_spend DESC";

		return $this->db->query($sql)->result();
	}

	/**
	 * Get Cohort Analysis Data
	 * 
	 * @param string $mode 'daily' (show days within 1 month) or 'monthly' (show months within 1 year)
	 * @param string $year The year to analyze (e.g. '2026')
	 * @param string $month The month to analyze for daily mode (e.g. '09')
	 * @return array ['cohorts' => [...], 'periods' => [...], 'summary' => [...]]
	 */
	public function get_cohort_analysis($mode = 'monthly', $year = '', $month = '', $product = '', $category = '')
	{
		if (empty($year)) {
			$year = date('Y');
		}

		if ($mode === 'daily') {
			if (empty($month)) {
				$month = date('m');
			}
			return $this->_get_daily_cohort($year, $month, $product, $category);
		} else {
			return $this->_get_monthly_cohort($year, $product, $category);
		}
	}

	/**
	 * Daily cohort: customers grouped by the DAY of first purchase within a given month
	 * Columns = relative days (Day 0, Day 1, Day 2, ...) since first purchase
	 */
	private function _get_daily_cohort($year, $month, $product = '', $category = '')
	{
		$ym = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
		$days_in_month = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);
		$month_names_id = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Ags',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];

		$where_conds = [];
		if (!empty($product)) {
			$p_esc = $this->db->escape(trim($product));
			$where_conds[] = "TRIM(u.nama_produk) = " . $p_esc;
		}
		if (!empty($category)) {
			$c_esc = $this->db->escape(trim($category));
			$where_conds[] = "(TRIM(u.nama_kategori) = " . $c_esc . " OR u.kategori_id = " . $c_esc . ")";
		}
		$filter_where = !empty($where_conds) ? " WHERE " . implode(" AND ", $where_conds) : "";

		// Get all transactions in this month with subtotal revenue
		$sql = "SELECT phone, DATE(tanggal) as order_date, subtotal
			FROM (
				SELECT CAST(so.no_telepon AS CHAR) as phone, so.tanggal_so as tanggal, COALESCE(soi.subtotal, (soi.qty * soi.harga_satuan), 0) as subtotal, COALESCE(p.nama_produk, soi.catatan, 'Produk SO') as nama_produk, p.kategori_id, COALESCE(NULLIF(kp.nama_kategori, ''), 'Tanpa Kategori') as nama_kategori
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				LEFT JOIN kategori_produk kp ON p.kategori_id = kp.id
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
				  AND so.tanggal_so IS NOT NULL AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' AND so.tanggal_so > '1970-01-01'
				  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))
				  AND DATE_FORMAT(so.tanggal_so, '%Y-%m') = '" . $this->db->escape_str($ym) . "'

				UNION ALL

				SELECT CAST(pm.no_telepon AS CHAR) as phone, pm.tanggal_so as tanggal, COALESCE(pmi.subtotal, (pmi.qty * pmi.harga_satuan), 0) as subtotal, COALESCE(p2.nama_produk, pmi.catatan, pm.nama_produk_marketplace, 'Produk Marketplace') as nama_produk, p2.kategori_id, COALESCE(NULLIF(kp2.nama_kategori, ''), 'Tanpa Kategori') as nama_kategori
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p2 ON pmi.produk_id = p2.id
				LEFT JOIN kategori_produk kp2 ON p2.kategori_id = kp2.id
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' AND pm.tanggal_so > '1970-01-01'
				  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
				  AND DATE_FORMAT(pm.tanggal_so, '%Y-%m') = '" . $this->db->escape_str($ym) . "'
			) u " . $filter_where . " ORDER BY order_date ASC";

		$rows = $this->db->query($sql)->result();

		// Find first purchase date for each customer within this month & track revenue per date
		$first_purchase = [];
		$customer_dates = [];
		$customer_revenue_by_date = [];

		foreach ($rows as $r) {
			$phone = $r->phone;
			$date = $r->order_date;
			$subtotal = (float)$r->subtotal;

			if (!isset($first_purchase[$phone]) || $date < $first_purchase[$phone]) {
				$first_purchase[$phone] = $date;
			}
			if (!isset($customer_dates[$phone])) {
				$customer_dates[$phone] = [];
			}
			$customer_dates[$phone][$date] = true;

			if (!isset($customer_revenue_by_date[$phone][$date])) {
				$customer_revenue_by_date[$phone][$date] = 0.0;
			}
			$customer_revenue_by_date[$phone][$date] += $subtotal;
		}

		// Group customers by their cohort day
		$cohort_customers = [];
		foreach ($first_purchase as $phone => $first_date) {
			$day = (int)date('j', strtotime($first_date));
			if (!isset($cohort_customers[$day])) {
				$cohort_customers[$day] = [];
			}
			$cohort_customers[$day][] = $phone;
		}

		ksort($cohort_customers);

		// Determine max relative days
		$max_rel_days = 0;
		foreach ($cohort_customers as $cohort_day => $phones) {
			$remaining = $days_in_month - $cohort_day;
			if ($remaining > $max_rel_days) $max_rel_days = $remaining;
		}

		// Build cohort data with RELATIVE periods
		$cohorts = [];
		$total_initial = 0;
		$overall_total_revenue = 0.0;
		$all_users_active = []; // For "Semua Customer" aggregate row
		$all_revenue_by_period = []; // For aggregate revenue

		foreach ($cohort_customers as $cohort_day => $phones) {
			$cohort_size = count($phones);
			$total_initial += $cohort_size;
			$retention = [];
			$revenue = [];
			$cohort_total_rev = 0.0;
			$max_for_this = $days_in_month - $cohort_day;

			for ($rel = 0; $rel <= $max_rel_days; $rel++) {
				if (!isset($all_revenue_by_period[$rel])) $all_revenue_by_period[$rel] = 0.0;

				if ($rel > $max_for_this) {
					$retention[$rel] = null; // No data yet (future)
					$revenue[$rel] = null;
				} else {
					$target_day = $cohort_day + $rel;
					$target_date = sprintf('%s-%02d', $ym, $target_day);
					$active = 0;
					$rel_rev = 0.0;

					foreach ($phones as $phone) {
						if (isset($customer_dates[$phone][$target_date])) {
							$active++;
						}
						if (isset($customer_revenue_by_date[$phone][$target_date])) {
							$rel_rev += $customer_revenue_by_date[$phone][$target_date];
						}
					}

					if ($rel === 0) {
						$retention[$rel] = 100.0;
					} else {
						$pct = $cohort_size > 0 ? round(($active / $cohort_size) * 100, 1) : 0;
						$retention[$rel] = $pct;
					}

					$revenue[$rel] = $rel_rev;
					$cohort_total_rev += $rel_rev;
					$all_revenue_by_period[$rel] += $rel_rev;

					if (!isset($all_users_active[$rel])) $all_users_active[$rel] = ['active' => 0, 'total' => 0];
					$all_users_active[$rel]['active'] += $active;
					$all_users_active[$rel]['total'] += $cohort_size;
				}
			}

			$overall_total_revenue += $cohort_total_rev;

			$cohorts[] = [
				'label' => $month_names_id[(int)$month] . ' ' . str_pad($cohort_day, 2, '0', STR_PAD_LEFT),
				'date_label' => sprintf('%s-%02d', $ym, $cohort_day),
				'size' => $cohort_size,
				'retention' => $retention,
				'revenue' => $revenue,
				'total_revenue' => $cohort_total_rev,
			];
		}

		// Build "Semua Customer" aggregate row
		$all_retention = [];
		for ($rel = 0; $rel <= $max_rel_days; $rel++) {
			if (isset($all_users_active[$rel]) && $all_users_active[$rel]['total'] > 0) {
				$all_retention[$rel] = round(($all_users_active[$rel]['active'] / $all_users_active[$rel]['total']) * 100, 1);
			} else {
				$all_retention[$rel] = null;
			}
		}

		// Period labels: Day 0, Day 1, Day 2, ...
		$period_labels = [];
		for ($d = 0; $d <= $max_rel_days; $d++) {
			$period_labels[] = 'Day ' . $d;
		}

		return [
			'cohorts' => $cohorts,
			'periods' => $period_labels,
			'aggregate' => [
				'label' => 'Semua Customer',
				'size' => $total_initial,
				'retention' => $all_retention,
				'revenue' => $all_revenue_by_period,
				'total_revenue' => $overall_total_revenue,
			],
			'mode' => 'daily',
			'year' => $year,
			'month' => $month,
			'ym' => $ym,
			'summary' => [
				'total_cohorts' => count($cohorts),
				'total_customers' => $total_initial,
				'total_revenue' => $overall_total_revenue,
				'days_in_month' => $days_in_month,
			],
		];
	}

	/**
	 * Monthly cohort: customers grouped by the MONTH of first purchase within a given year
	 * Columns = actual month names (Jan, Feb, Mar... Des)
	 */
	private function _get_monthly_cohort($year, $product = '', $category = '')
	{
		$where_conds = [];
		if (!empty($product)) {
			$p_esc = $this->db->escape(trim($product));
			$where_conds[] = "TRIM(u.nama_produk) = " . $p_esc;
		}
		if (!empty($category)) {
			$c_esc = $this->db->escape(trim($category));
			$where_conds[] = "(TRIM(u.nama_kategori) = " . $c_esc . " OR u.kategori_id = " . $c_esc . ")";
		}
		$filter_where = !empty($where_conds) ? " WHERE " . implode(" AND ", $where_conds) : "";

		// Get all transactions in this year with subtotal revenue
		$sql = "
			SELECT phone, DATE_FORMAT(tanggal, '%Y-%m') as order_month, subtotal
			FROM (
				SELECT CAST(so.no_telepon AS CHAR) as phone, so.tanggal_so as tanggal, COALESCE(soi.subtotal, (soi.qty * soi.harga_satuan), 0) as subtotal, COALESCE(p.nama_produk, soi.catatan, 'Produk SO') as nama_produk, p.kategori_id, COALESCE(NULLIF(kp.nama_kategori, ''), 'Tanpa Kategori') as nama_kategori
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				LEFT JOIN kategori_produk kp ON p.kategori_id = kp.id
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
				  AND so.tanggal_so IS NOT NULL AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' AND so.tanggal_so > '1970-01-01'
				  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))
				  AND YEAR(so.tanggal_so) = '" . $this->db->escape_str($year) . "'

				UNION ALL

				SELECT CAST(pm.no_telepon AS CHAR) as phone, pm.tanggal_so as tanggal, COALESCE(pmi.subtotal, (pmi.qty * pmi.harga_satuan), 0) as subtotal, COALESCE(p2.nama_produk, pmi.catatan, pm.nama_produk_marketplace, 'Produk Marketplace') as nama_produk, p2.kategori_id, COALESCE(NULLIF(kp2.nama_kategori, ''), 'Tanpa Kategori') as nama_kategori
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p2 ON pmi.produk_id = p2.id
				LEFT JOIN kategori_produk kp2 ON p2.kategori_id = kp2.id
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' AND pm.tanggal_so > '1970-01-01'
				  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
				  AND YEAR(pm.tanggal_so) = '" . $this->db->escape_str($year) . "'
			) u
			" . $filter_where . "
			ORDER BY order_month ASC
		";

		$rows = $this->db->query($sql)->result();

		// Find first purchase month for each customer within this year & track revenue per month
		$first_purchase = [];
		$customer_months = [];
		$customer_revenue_by_month = [];

		foreach ($rows as $r) {
			$phone = $r->phone;
			$ym = $r->order_month;
			$subtotal = (float)$r->subtotal;

			if (!isset($first_purchase[$phone]) || $ym < $first_purchase[$phone]) {
				$first_purchase[$phone] = $ym;
			}
			if (!isset($customer_months[$phone])) {
				$customer_months[$phone] = [];
			}
			$customer_months[$phone][$ym] = true;

			if (!isset($customer_revenue_by_month[$phone][$ym])) {
				$customer_revenue_by_month[$phone][$ym] = 0.0;
			}
			$customer_revenue_by_month[$phone][$ym] += $subtotal;
		}

		// Group customers by their cohort month
		$cohort_customers = [];
		foreach ($first_purchase as $phone => $first_ym) {
			if (!isset($cohort_customers[$first_ym])) {
				$cohort_customers[$first_ym] = [];
			}
			$cohort_customers[$first_ym][] = $phone;
		}

		// Build month labels (Jan - Des, 1-indexed)
		$month_names_id = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Ags',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
		$period_labels = [];
		for ($m = 1; $m <= 12; $m++) {
			$period_labels[$m] = $month_names_id[$m];
		}

		ksort($cohort_customers);
		$cohorts = [];
		$total_initial = 0;
		$overall_total_revenue = 0.0;
		$all_users_active = []; // For aggregate row
		$all_revenue_by_period = []; // For aggregate revenue row

		foreach ($cohort_customers as $cohort_ym => $phones) {
			$cohort_size = count($phones);
			$total_initial += $cohort_size;
			$cohort_month_idx = (int)substr($cohort_ym, 5, 2);
			$retention = [];
			$revenue = [];
			$cohort_total_rev = 0.0;

			for ($m = 1; $m <= 12; $m++) {
				if (!isset($all_revenue_by_period[$m])) $all_revenue_by_period[$m] = 0.0;

				$target_ym = sprintf('%s-%02d', $year, $m);
				if ($m < $cohort_month_idx) {
					$retention[$m] = null; // Before cohort start
					$revenue[$m] = null;
				} else {
					$active = 0;
					$rel_rev = 0.0;

					foreach ($phones as $phone) {
						if (isset($customer_months[$phone][$target_ym])) {
							$active++;
						}
						if (isset($customer_revenue_by_month[$phone][$target_ym])) {
							$rel_rev += $customer_revenue_by_month[$phone][$target_ym];
						}
					}

					if ($m === $cohort_month_idx) {
						$retention[$m] = 100.0;
					} else {
						$pct = $cohort_size > 0 ? round(($active / $cohort_size) * 100, 1) : 0;
						$retention[$m] = $pct;
					}

					$revenue[$m] = $rel_rev;
					$cohort_total_rev += $rel_rev;
					$all_revenue_by_period[$m] += $rel_rev;

					if (!isset($all_users_active[$m])) $all_users_active[$m] = ['active' => 0, 'total' => 0];
					$all_users_active[$m]['active'] += $active;
					$all_users_active[$m]['total'] += $cohort_size;
				}
			}

			$overall_total_revenue += $cohort_total_rev;

			$cohorts[] = [
				'label' => $month_names_id[$cohort_month_idx] . ' ' . $year,
				'date_label' => $cohort_ym,
				'size' => $cohort_size,
				'retention' => $retention,
				'revenue' => $revenue,
				'total_revenue' => $cohort_total_rev,
			];
		}

		// Build "Semua Customer" aggregate
		$all_retention = [];
		for ($m = 1; $m <= 12; $m++) {
			if (isset($all_users_active[$m]) && $all_users_active[$m]['total'] > 0) {
				$all_retention[$m] = round(($all_users_active[$m]['active'] / $all_users_active[$m]['total']) * 100, 1);
			} else {
				$all_retention[$m] = null;
			}
		}

		return [
			'cohorts' => $cohorts,
			'periods' => $period_labels,
			'aggregate' => [
				'label' => 'Semua Customer',
				'size' => $total_initial,
				'retention' => $all_retention,
				'revenue' => $all_revenue_by_period,
				'total_revenue' => $overall_total_revenue,
			],
			'mode' => 'monthly',
			'year' => $year,
			'month' => '',
			'ym' => '',
			'summary' => [
				'total_cohorts' => count($cohorts),
				'total_customers' => $total_initial,
				'total_revenue' => $overall_total_revenue,
			],
		];
	}

	/**
	 * Get list of customers for a specific cohort cell drill-down
	 *
	 * @param string $cohort_period e.g. '2026-01' (monthly) or '2026-09-01' (daily)
	 * @param string $target_period e.g. '2026-02' (monthly) or '2026-09-05' (daily)
	 * @param string $mode 'monthly' or 'daily'
	 * @param string $product Optional product filter
	 * @return array
	 */
	public function get_cohort_drilldown_customers($cohort_period, $target_period, $mode = 'monthly', $product = '', $category = '')
	{
		$where_conds = [];
		if (!empty($product)) {
			$p_esc = $this->db->escape(trim($product));
			$where_conds[] = "TRIM(u.nama_produk) = " . $p_esc;
		}
		if (!empty($category)) {
			$c_esc = $this->db->escape(trim($category));
			$where_conds[] = "(TRIM(u.nama_kategori) = " . $c_esc . " OR u.kategori_id = " . $c_esc . ")";
		}
		$filter_where = !empty($where_conds) ? " WHERE " . implode(" AND ", $where_conds) : "";

		if ($mode === 'daily') {
			$year_month = substr($cohort_period, 0, 7); // '2026-09'
			$sql = "
				SELECT phone, nama, DATE(tanggal) as order_period, subtotal
				FROM (
					SELECT CAST(COALESCE(NULLIF(NULLIF(so.no_telepon, '-'), ''), NULLIF(NULLIF(pel.no_telp, '-'), ''), NULLIF(NULLIF(pel.telepon, '-'), ''), NULLIF(NULLIF(so.no_telepon_pengirim, '-'), ''), '-') AS CHAR) as phone, 
						CAST(COALESCE(NULLIF(TRIM(so.nama_penerima), ''), NULLIF(TRIM(so.username_pembeli), ''), NULLIF(TRIM(pel.nama_pelanggan), ''), 'Customer') AS CHAR) as nama, 
						so.tanggal_so as tanggal, 
						COALESCE(soi.subtotal, (soi.qty * soi.harga_satuan), 0) as subtotal, 
						COALESCE(p.nama_produk, soi.catatan, 'Produk SO') as nama_produk,
						p.kategori_id,
						COALESCE(NULLIF(kp.nama_kategori, ''), 'Tanpa Kategori') as nama_kategori
					FROM sales_order_item soi
					JOIN sales_order so ON soi.so_id = so.id
					LEFT JOIN pelanggan pel ON so.pelanggan_id = pel.id
					LEFT JOIN produk p ON soi.produk_id = p.id
					LEFT JOIN kategori_produk kp ON p.kategori_id = kp.id
					WHERE ((so.no_telepon IS NOT NULL AND so.no_telepon != '' AND so.no_telepon != '-')
						OR (pel.no_telp IS NOT NULL AND pel.no_telp != '' AND pel.no_telp != '-')
						OR (pel.telepon IS NOT NULL AND pel.telepon != '' AND pel.telepon != '-')
						OR (so.no_telepon_pengirim IS NOT NULL AND so.no_telepon_pengirim != '' AND so.no_telepon_pengirim != '-'))
					  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
					  AND so.tanggal_so IS NOT NULL AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' AND so.tanggal_so > '1970-01-01'
					  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))
					  AND DATE_FORMAT(so.tanggal_so, '%Y-%m') = '" . $this->db->escape_str($year_month) . "'

					UNION ALL

					SELECT CAST(COALESCE(NULLIF(NULLIF(pm.no_telepon, '-'), ''), NULLIF(NULLIF(pel2.no_telp, '-'), ''), NULLIF(NULLIF(pel2.telepon, '-'), ''), NULLIF(NULLIF(pm.no_telepon_pengirim, '-'), ''), '-') AS CHAR) as phone, 
						CAST(COALESCE(NULLIF(TRIM(pm.nama_penerima), ''), NULLIF(TRIM(pm.username_pembeli), ''), NULLIF(TRIM(pel2.nama_pelanggan), ''), 'Customer') AS CHAR) as nama, 
						pm.tanggal_so as tanggal, 
						COALESCE(pmi.subtotal, (pmi.qty * pmi.harga_satuan), 0) as subtotal, 
						COALESCE(p2.nama_produk, pmi.catatan, pm.nama_produk_marketplace, 'Produk Marketplace') as nama_produk,
						p2.kategori_id,
						COALESCE(NULLIF(kp2.nama_kategori, ''), 'Tanpa Kategori') as nama_kategori
					FROM penjualan_marketplace_item pmi
					JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
					LEFT JOIN pelanggan pel2 ON pm.pelanggan_id = pel2.id
					LEFT JOIN produk p2 ON pmi.produk_id = p2.id
					LEFT JOIN kategori_produk kp2 ON p2.kategori_id = kp2.id
					WHERE ((pm.no_telepon IS NOT NULL AND pm.no_telepon != '' AND pm.no_telepon != '-')
						OR (pel2.no_telp IS NOT NULL AND pel2.no_telp != '' AND pel2.no_telp != '-')
						OR (pel2.telepon IS NOT NULL AND pel2.telepon != '' AND pel2.telepon != '-')
						OR (pm.no_telepon_pengirim IS NOT NULL AND pm.no_telepon_pengirim != '' AND pm.no_telepon_pengirim != '-'))
					  AND pm.tanggal_so IS NOT NULL AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' AND pm.tanggal_so > '1970-01-01'
					  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
					  AND DATE_FORMAT(pm.tanggal_so, '%Y-%m') = '" . $this->db->escape_str($year_month) . "'
				) u
				" . $filter_where . "
				ORDER BY order_period ASC
			";
		} else {
			$year = substr($cohort_period, 0, 4); // '2026'
			$sql = "
				SELECT phone, nama, DATE_FORMAT(tanggal, '%Y-%m') as order_period, subtotal
				FROM (
					SELECT CAST(COALESCE(NULLIF(NULLIF(so.no_telepon, '-'), ''), NULLIF(NULLIF(pel.no_telp, '-'), ''), NULLIF(NULLIF(pel.telepon, '-'), ''), NULLIF(NULLIF(so.no_telepon_pengirim, '-'), ''), '-') AS CHAR) as phone, 
						CAST(COALESCE(NULLIF(TRIM(so.nama_penerima), ''), NULLIF(TRIM(so.username_pembeli), ''), NULLIF(TRIM(pel.nama_pelanggan), ''), 'Customer') AS CHAR) as nama, 
						so.tanggal_so as tanggal, 
						COALESCE(soi.subtotal, (soi.qty * soi.harga_satuan), 0) as subtotal, 
						COALESCE(p.nama_produk, soi.catatan, 'Produk SO') as nama_produk,
						p.kategori_id,
						COALESCE(NULLIF(kp.nama_kategori, ''), 'Tanpa Kategori') as nama_kategori
					FROM sales_order_item soi
					JOIN sales_order so ON soi.so_id = so.id
					LEFT JOIN pelanggan pel ON so.pelanggan_id = pel.id
					LEFT JOIN produk p ON soi.produk_id = p.id
					LEFT JOIN kategori_produk kp ON p.kategori_id = kp.id
					WHERE ((so.no_telepon IS NOT NULL AND so.no_telepon != '' AND so.no_telepon != '-')
						OR (pel.no_telp IS NOT NULL AND pel.no_telp != '' AND pel.no_telp != '-')
						OR (pel.telepon IS NOT NULL AND pel.telepon != '' AND pel.telepon != '-')
						OR (so.no_telepon_pengirim IS NOT NULL AND so.no_telepon_pengirim != '' AND so.no_telepon_pengirim != '-'))
					  AND so.tanggal_so IS NOT NULL AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' AND so.tanggal_so > '1970-01-01'
					  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))
					  AND YEAR(so.tanggal_so) = '" . $this->db->escape_str($year) . "'

					UNION ALL

					SELECT CAST(COALESCE(NULLIF(NULLIF(pm.no_telepon, '-'), ''), NULLIF(NULLIF(pel2.no_telp, '-'), ''), NULLIF(NULLIF(pel2.telepon, '-'), ''), NULLIF(NULLIF(pm.no_telepon_pengirim, '-'), ''), '-') AS CHAR) as phone, 
						CAST(COALESCE(NULLIF(TRIM(pm.nama_penerima), ''), NULLIF(TRIM(pm.username_pembeli), ''), NULLIF(TRIM(pel2.nama_pelanggan), ''), 'Customer') AS CHAR) as nama, 
						pm.tanggal_so as tanggal, 
						COALESCE(pmi.subtotal, (pmi.qty * pmi.harga_satuan), 0) as subtotal, 
						COALESCE(p2.nama_produk, pmi.catatan, pm.nama_produk_marketplace, 'Produk Marketplace') as nama_produk,
						p2.kategori_id,
						COALESCE(NULLIF(kp2.nama_kategori, ''), 'Tanpa Kategori') as nama_kategori
					FROM penjualan_marketplace_item pmi
					JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
					LEFT JOIN pelanggan pel2 ON pm.pelanggan_id = pel2.id
					LEFT JOIN produk p2 ON pmi.produk_id = p2.id
					LEFT JOIN kategori_produk kp2 ON p2.kategori_id = kp2.id
					WHERE ((pm.no_telepon IS NOT NULL AND pm.no_telepon != '' AND pm.no_telepon != '-')
						OR (pel2.no_telp IS NOT NULL AND pel2.no_telp != '' AND pel2.no_telp != '-')
						OR (pel2.telepon IS NOT NULL AND pel2.telepon != '' AND pel2.telepon != '-')
						OR (pm.no_telepon_pengirim IS NOT NULL AND pm.no_telepon_pengirim != '' AND pm.no_telepon_pengirim != '-'))
					  AND pm.tanggal_so IS NOT NULL AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' AND pm.tanggal_so > '1970-01-01'
					  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
					  AND YEAR(pm.tanggal_so) = '" . $this->db->escape_str($year) . "'
				) u
				" . $filter_where . "
				ORDER BY order_period ASC
			";
		}

		$rows = $this->db->query($sql)->result();

		$first_purchase = [];
		$customer_names = [];
		$customer_orders = [];
		$customer_total_spend = [];
		$customer_total_orders = [];
		$customer_last_date = [];

		foreach ($rows as $r) {
			$p = $r->phone;
			$p_period = $r->order_period;
			if (!isset($first_purchase[$p]) || $p_period < $first_purchase[$p]) {
				$first_purchase[$p] = $p_period;
			}
			if (!empty($r->nama) && (!isset($customer_names[$p]) || empty($customer_names[$p]) || $customer_names[$p] === 'Customer')) {
				$customer_names[$p] = $r->nama;
			}
			if (!isset($customer_orders[$p])) {
				$customer_orders[$p] = [];
			}
			if (!isset($customer_orders[$p][$p_period])) {
				$customer_orders[$p][$p_period] = ['count' => 0, 'spend' => 0.0];
			}
			$customer_orders[$p][$p_period]['count']++;
			$customer_orders[$p][$p_period]['spend'] += (float)$r->subtotal;

			if (!isset($customer_total_spend[$p])) {
				$customer_total_spend[$p] = 0.0;
				$customer_total_orders[$p] = 0;
				$customer_last_date[$p] = $r->order_period;
			}
			$customer_total_spend[$p] += (float)$r->subtotal;
			$customer_total_orders[$p]++;
			if ($r->order_period > $customer_last_date[$p]) {
				$customer_last_date[$p] = $r->order_period;
			}
		}

		$cohort_phones = [];
		foreach ($first_purchase as $p => $f_period) {
			if ($f_period === $cohort_period) {
				$cohort_phones[] = $p;
			}
		}

		$retained = [];
		$churned = [];

		foreach ($cohort_phones as $p) {
			$nama = !empty($customer_names[$p]) ? $customer_names[$p] : 'Pelanggan ' . substr($p, -4);
			$clean_phone = preg_replace('/[^0-9]/', '', $p);
			if (substr($clean_phone, 0, 1) === '0') {
				$wa_phone = '62' . substr($clean_phone, 1);
			} else {
				$wa_phone = $clean_phone;
			}

			if (isset($customer_orders[$p][$target_period])) {
				$orders = $customer_orders[$p][$target_period]['count'];
				$spend = $customer_orders[$p][$target_period]['spend'];
				$wa_text = rawurlencode("Halo Kak {$nama}, terima kasih banyak ya sudah setia berbelanja kembali di toko kami! Semoga produknya bermanfaat selalu. Ada yang bisa kami bantu lagi?");
				$retained[] = [
					'phone' => $p,
					'nama' => $nama,
					'is_retained' => true,
					'orders' => $orders,
					'spend' => $spend,
					'target_spend' => $spend,
					'total_spend' => $customer_total_spend[$p] ?? $spend,
					'total_orders' => $customer_total_orders[$p] ?? $orders,
					'last_order_date' => $customer_last_date[$p] ?? '-',
					'spend_formatted' => 'Rp ' . number_format($spend, 0, ',', '.'),
					'wa_link' => 'https://wa.me/' . $wa_phone . '?text=' . $wa_text,
					'crm_link' => site_url('administrator/crm/customer_detail?phone=' . urlencode($p)),
				];
			} else {
				$wa_text = rawurlencode("Halo Kak {$nama}, apa kabar? Kami kangen nih! Kebetulan kami sedang ada promo spesial/voucher belanja untuk Kakak. Yuk cek penawaran menarik hari ini!");
				$churned[] = [
					'phone' => $p,
					'nama' => $nama,
					'is_retained' => false,
					'orders' => 0,
					'spend' => 0,
					'target_spend' => 0,
					'total_spend' => $customer_total_spend[$p] ?? 0,
					'total_orders' => $customer_total_orders[$p] ?? 0,
					'last_order_date' => $customer_last_date[$p] ?? '-',
					'spend_formatted' => 'Rp 0',
					'wa_link' => 'https://wa.me/' . $wa_phone . '?text=' . $wa_text,
					'crm_link' => site_url('administrator/crm/customer_detail?phone=' . urlencode($p)),
				];
			}
		}

		// Sort retained by spend DESC, churned by name ASC
		usort($retained, function($a, $b) {
			return $b['spend'] <=> $a['spend'];
		});
		usort($churned, function($a, $b) {
			return strcmp($a['nama'], $b['nama']);
		});

		$total_cohort = count($cohort_phones);
		$retention_pct = $total_cohort > 0 ? round((count($retained) / $total_cohort) * 100, 1) : 0;

		return [
			'cohort_period' => $cohort_period,
			'target_period' => $target_period,
			'mode' => $mode,
			'total_cohort' => $total_cohort,
			'retained_count' => count($retained),
			'churned_count' => count($churned),
			'retention_pct' => $retention_pct,
			'retained_customers' => $retained,
			'churned_customers' => $churned,
		];
	}

	/**
	 * Get product breakdown summary for cohort analysis page
	 */
	public function get_product_cohort_summary($year = '', $category = '')
	{
		if (empty($year)) $year = date('Y');
		$year_esc = $this->db->escape_str($year);

		$cat_where = "";
		if (!empty($category)) {
			$c_esc = $this->db->escape(trim($category));
			$cat_where = " WHERE (TRIM(u.nama_kategori) = " . $c_esc . " OR u.kategori_id = " . $c_esc . ") ";
		}

		$sql = "
			SELECT 
				u.nama_produk,
				COUNT(DISTINCT u.phone) as total_customers,
				COUNT(DISTINCT u.order_id) as total_orders,
				SUM(u.subtotal) as total_revenue
			FROM (
				SELECT 
					CAST(so.no_telepon AS CHAR) as phone,
					CONCAT('so_', so.id) as order_id,
					so.tanggal_so as tanggal,
					COALESCE(soi.subtotal, (soi.qty * soi.harga_satuan), 0) as subtotal,
					COALESCE(p.nama_produk, soi.catatan, 'Produk SO') as nama_produk,
					p.kategori_id,
					COALESCE(NULLIF(kp.nama_kategori, ''), 'Tanpa Kategori') as nama_kategori
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				LEFT JOIN kategori_produk kp ON p.kategori_id = kp.id
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
				  AND so.tanggal_so IS NOT NULL AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' AND so.tanggal_so > '1970-01-01'
				  AND (so.status_pesanan IS NULL OR (LOWER(so.status_pesanan) NOT LIKE '%batal%' AND LOWER(so.status_pesanan) NOT LIKE '%cancel%'))
				  AND YEAR(so.tanggal_so) = '" . $year_esc . "'

				UNION ALL

				SELECT 
					CAST(pm.no_telepon AS CHAR) as phone,
					CONCAT('pm_', pm.id) as order_id,
					pm.tanggal_so as tanggal,
					COALESCE(pmi.subtotal, (pmi.qty * pmi.harga_satuan), 0) as subtotal,
					COALESCE(p2.nama_produk, pmi.catatan, pm.nama_produk_marketplace, 'Produk Marketplace') as nama_produk,
					p2.kategori_id,
					COALESCE(NULLIF(kp2.nama_kategori, ''), 'Tanpa Kategori') as nama_kategori
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p2 ON pmi.produk_id = p2.id
				LEFT JOIN kategori_produk kp2 ON p2.kategori_id = kp2.id
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' AND pm.tanggal_so > '1970-01-01'
				  AND (pm.status_pesanan IS NULL OR (LOWER(pm.status_pesanan) NOT LIKE '%batal%' AND LOWER(pm.status_pesanan) NOT LIKE '%cancel%'))
				  AND YEAR(pm.tanggal_so) = '" . $year_esc . "'
			) u
			" . $cat_where . "
			GROUP BY u.nama_produk
			HAVING total_customers > 0
			ORDER BY total_customers DESC, total_revenue DESC
			LIMIT 15
		";

		return $this->db->query($sql)->result();
	}

	/**
	 * Get aggregated RFM analysis PER PRODUCT across all customers
	 */
	public function get_product_rfm_list($filter = '', $limit = 50, $offset = 0)
	{
		$where_clause = "";
		if (!empty($filter)) {
			$f_esc = $this->db->escape_like_str($filter);
			$where_clause = " WHERE item_name LIKE '%" . $f_esc . "%'";
		}

		$sql = "
			SELECT 
				item_name,
				COUNT(DISTINCT phone) as total_customers,
				COUNT(DISTINCT order_id) as total_orders,
				SUM(qty) as total_qty,
				SUM(subtotal) as total_spend,
				MAX(tanggal) as last_order_date,
				DATEDIFF(CURRENT_DATE(), MAX(tanggal)) as recency_days
			FROM (
				SELECT 
					so.no_telepon as phone,
					CONCAT('so_', so.id) as order_id,
					CASE 
						WHEN soi.catatan IS NOT NULL AND TRIM(soi.catatan) != '' THEN TRIM(REGEXP_REPLACE(soi.catatan, '\\\\s*\\\\([^)]*\\\\)$', ''))
						ELSE COALESCE(p.nama_produk, 'Produk SO')
					END as item_name,
					soi.qty,
					soi.subtotal,
					so.tanggal_so as tanggal
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))

				UNION ALL

				SELECT 
					pm.no_telepon as phone,
					CONCAT('pm_', pm.id) as order_id,
					CASE 
						WHEN pmi.catatan IS NOT NULL AND TRIM(pmi.catatan) != '' THEN TRIM(REGEXP_REPLACE(pmi.catatan, '\\\\s*\\\\([^)]*\\\\)$', ''))
						ELSE COALESCE(p.nama_produk, 'Produk Marketplace')
					END as item_name,
					pmi.qty,
					pmi.subtotal,
					pm.tanggal_so as tanggal
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p ON pmi.produk_id = p.id
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
			) u
			" . $where_clause . "
			GROUP BY item_name
			ORDER BY total_spend DESC, last_order_date DESC
		";

		$all_rows = $this->db->query($sql)->result();
		
		foreach ($all_rows as $r) {
			$r->total_customers = (int)$r->total_customers;
			$r->total_orders = (int)$r->total_orders;
			$r->total_qty = (float)$r->total_qty;
			$r->total_spend = (float)$r->total_spend;
			$r->recency_days = (int)$r->recency_days;

			if ($r->recency_days <= 30 && $r->total_orders >= 10) {
				$r->status_badge = ['label' => 'Best Seller', 'bg' => '#dcfce7', 'color' => '#15803d', 'icon' => 'fa-fire'];
			} elseif ($r->recency_days <= 60 && $r->total_orders >= 5) {
				$r->status_badge = ['label' => 'High Demand', 'bg' => '#e0e7ff', 'color' => '#4338ca', 'icon' => 'fa-trending-up'];
			} elseif ($r->recency_days <= 90) {
				$r->status_badge = ['label' => 'Steady Sales', 'bg' => '#fef3c7', 'color' => '#b45309', 'icon' => 'fa-clock-o'];
			} else {
				$r->status_badge = ['label' => 'Slow Moving', 'bg' => '#fee2e2', 'color' => '#b91c1c', 'icon' => 'fa-exclamation-triangle'];
			}
		}

		$total = count($all_rows);
		$paged = array_slice($all_rows, $offset, $limit);
		return ['rows' => $paged, 'total' => $total];
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
		// Auto-sync dates for all labels to guarantee order ship date & H+n category alignment
		$this->sync_label_dates_if_needed();

		$apply_where = function() use ($filters) {
			$this->db->from('crm_transaction_followup_labels tfl');
			$this->db->join('crm_followup_categories fc', 'tfl.followup_category_id = fc.id', 'left');

			if (!empty($filters['category_id'])) {
				$this->db->where('tfl.followup_category_id', $filters['category_id']);
			}
			if (!empty($filters['order_source'])) {
				$this->db->where('tfl.order_source', $filters['order_source']);
			}
			if (!empty($filters['status_label'])) {
				if ($filters['status_label'] === 'belum_direspon') {
					$this->db->where_in('tfl.status_label', ['Pending', 'Sudah Dikirim', 'Belum Respon']);
				} else {
					$this->db->where('tfl.status_label', $filters['status_label']);
				}
			}
			if (!empty($filters['date_from'])) {
				$this->db->where('tfl.tanggal_pengiriman >=', $filters['date_from']);
			}
			if (!empty($filters['date_to'])) {
				$this->db->where('tfl.tanggal_pengiriman <=', $filters['date_to']);
			}
			if (!empty($filters['search'])) {
				$s = trim((string)$filters['search']);
				$this->db->group_start();
				$this->db->like('tfl.customer_nama', $s);
				$this->db->or_like('tfl.customer_phone', $s);
				$this->db->or_like('tfl.no_pesanan', $s);
				$this->db->or_like('tfl.nomor_resi', $s);
				$this->db->or_like('fc.nama_kategori', $s);
				$this->db->group_end();
			}
			if (!empty($filters['keterangan_bc'])) {
				$this->db->where('tfl.keterangan_bc', $filters['keterangan_bc']);
			}
			if (empty($filters['show_future']) && empty($filters['search']) && empty($filters['date_from']) && empty($filters['date_to']) && empty($filters['keterangan_bc'])) {
				$this->db->where('tfl.tanggal_label_muncul <=', date('Y-m-d'));
			}
		};

		// 1. Fast count query (NO subselects)
		$this->db->select('COUNT(tfl.id) as total_count');
		$apply_where();
		$count_row = $this->db->get()->row();
		$count = $count_row ? (int)$count_row->total_count : 0;

		// 2. Fast paginated rows query
		$this->db->select('tfl.*, fc.nama_kategori, fc.kode_kategori, fc.jumlah_hari, fc.template_pesan_default, 0 AS total_wa_sent');
		$apply_where();
		$this->db->order_by('tfl.updated_at', 'DESC');
		$this->db->order_by('tfl.id', 'DESC');
		$this->db->limit($limit, $offset);
		$rows = $this->db->get()->result();

		// Calculate total_wa_sent for the 25 paginated rows only
		if (!empty($rows)) {
			$lids = array_map(function($r) { return $r->id; }, $rows);
			$counts_raw = $this->db->select('followup_label_id, COUNT(*) as cnt')
				->from('crm_broadcast_logs')
				->where_in('followup_label_id', $lids)
				->group_by('followup_label_id')
				->get()->result_array();
			
			$cnt_map = [];
			foreach ($counts_raw as $cr) {
				$cnt_map[$cr['followup_label_id']] = (int)$cr['cnt'];
			}
			foreach ($rows as &$r) {
				$r->total_wa_sent = isset($cnt_map[$r->id]) ? $cnt_map[$r->id] : 0;
			}
		}

		// Fallback check: if any paginated row has missing phone, attempt live resolution from mp / pelanggan
		if (!empty($rows)) {
			foreach ($rows as &$r) {
				if (empty($r->customer_phone) || $r->customer_phone === '-') {
					$resolved_ph = '';
					if ($r->order_table === 'penjualan_marketplace' && !empty($r->order_id)) {
						$pm_row = $this->db->select('no_telepon')->get_where('penjualan_marketplace', ['id' => $r->order_id])->row();
						if ($pm_row && !empty($pm_row->no_telepon) && $pm_row->no_telepon !== '-') {
							$resolved_ph = $pm_row->no_telepon;
						}
					}
					if (empty($resolved_ph) && !empty($r->customer_pelanggan_id)) {
						$p_row = $this->db->select('telepon, no_telp')->get_where('pelanggan', ['id' => $r->customer_pelanggan_id])->row();
						if ($p_row) {
							$resolved_ph = (!empty($p_row->telepon) && $p_row->telepon !== '-') ? $p_row->telepon : ((!empty($p_row->no_telp) && $p_row->no_telp !== '-') ? $p_row->no_telp : '');
						}
					}
					if (!empty($resolved_ph)) {
						$r->customer_phone = $resolved_ph;
						$this->db->where('id', $r->id)->update('crm_transaction_followup_labels', ['customer_phone' => $resolved_ph]);
					}
				}
			}
		}

		return ['rows' => $rows, 'total' => $count];
	}

	/**
	 * Prepare and enrich journal entries for Export (Excel, CSV, PDF)
	 * Matches the exact display calculation and formatting of the web interface
	 */
	public function prepare_journal_entries_for_export($rows)
	{
		if (empty($rows)) return [];

		// 1. Gather all order numbers
		$order_p_list = [];
		foreach ($rows as $ent) {
			if (!empty($ent->no_pesanan) && $ent->no_pesanan !== '-') {
				$order_p_list[] = $ent->no_pesanan;
			}
		}
		$order_p_list = array_values(array_unique($order_p_list));

		// 2. Build order completed milestone map from labels and broadcast logs
		$order_completed_map = [];
		if (!empty($order_p_list)) {
			$comp_rows = $this->db->select('tfl.no_pesanan, fc.jumlah_hari, tfl.keterangan_bc, tfl.status_label, tfl.is_broadcast_sent, tfl.waktu_kirim_wa')
				->from('crm_transaction_followup_labels tfl')
				->join('crm_followup_categories fc', 'tfl.followup_category_id = fc.id')
				->where_in('tfl.no_pesanan', $order_p_list)
				->group_start()
					->where('tfl.status_label !=', 'Pending')
					->or_where('tfl.is_broadcast_sent', 1)
					->or_where('tfl.waktu_kirim_wa IS NOT NULL', null, false)
					->or_where('(tfl.keterangan_bc IS NOT NULL AND tfl.keterangan_bc != "")', null, false)
				->group_end()
				->get()->result();
			foreach ($comp_rows as $cr) {
				$np = $cr->no_pesanan;
				if (!isset($order_completed_map[$np])) {
					$order_completed_map[$np] = [];
				}
				$order_completed_map[$np]['H+' . (int)$cr->jumlah_hari] = true;
			}

			// Broadcast logs
			$b_logs = $this->db->select('tfl.no_pesanan, fc.jumlah_hari')
				->from('crm_broadcast_logs bl')
				->join('crm_transaction_followup_labels tfl', 'bl.followup_label_id = tfl.id')
				->join('crm_followup_categories fc', 'tfl.followup_category_id = fc.id')
				->where_in('tfl.no_pesanan', $order_p_list)
				->get()->result();
			foreach ($b_logs as $bl) {
				if (!isset($order_completed_map[$bl->no_pesanan])) {
					$order_completed_map[$bl->no_pesanan] = [];
				}
				$order_completed_map[$bl->no_pesanan]['H+' . (int)$bl->jumlah_hari] = true;
			}
		}

		// 3. Multi-source Fallback phone map for entries whose phone is empty in tfl
		$cust_ids_no_phone = [];
		$pm_ids_no_phone = [];
		$so_ids_no_phone = [];
		$cust_names_no_phone = [];

		foreach ($rows as $r) {
			$cur_ph = trim((string)$r->customer_phone);
			if (empty($cur_ph) || $cur_ph === '-' || strpos($cur_ph, '*') !== false) {
				if (!empty($r->customer_pelanggan_id)) {
					$cust_ids_no_phone[] = (int)$r->customer_pelanggan_id;
				}
				if ($r->order_table === 'penjualan_marketplace' && !empty($r->order_id)) {
					$pm_ids_no_phone[] = (int)$r->order_id;
				}
				if ($r->order_table === 'sales_order' && !empty($r->order_id)) {
					$so_ids_no_phone[] = (int)$r->order_id;
				}
				if (!empty($r->customer_nama) && $r->customer_nama !== '-') {
					$cust_names_no_phone[] = $r->customer_nama;
				}
			}
		}

		$pel_id_map = [];
		if (!empty($cust_ids_no_phone)) {
			$p_rows = $this->db->select('id, telepon, no_telp')
				->from('pelanggan')
				->where_in('id', array_values(array_unique($cust_ids_no_phone)))
				->get()->result();
			foreach ($p_rows as $pr) {
				$ph = !empty($pr->no_telp) && $pr->no_telp !== '-' ? $pr->no_telp : (!empty($pr->telepon) && $pr->telepon !== '-' ? $pr->telepon : '');
				if (!empty($ph)) $pel_id_map[$pr->id] = $ph;
			}
		}

		$pm_order_map = [];
		if (!empty($pm_ids_no_phone)) {
			$pm_rows = $this->db->select('pm.id, pm.no_telepon, pm.no_telepon_pengirim, p.no_telp, p.telepon')
				->from('penjualan_marketplace pm')
				->join('pelanggan p', 'pm.pelanggan_id = p.id', 'left')
				->where_in('pm.id', array_values(array_unique($pm_ids_no_phone)))
				->get()->result();
			foreach ($pm_rows as $pm) {
				$ph = !empty($pm->no_telepon) && $pm->no_telepon !== '-' ? $pm->no_telepon : (!empty($pm->no_telp) && $pm->no_telp !== '-' ? $pm->no_telp : (!empty($pm->telepon) && $pm->telepon !== '-' ? $pm->telepon : (!empty($pm->no_telepon_pengirim) && $pm->no_telepon_pengirim !== '-' ? $pm->no_telepon_pengirim : '')));
				if (!empty($ph)) $pm_order_map[$pm->id] = $ph;
			}
		}

		$so_order_map = [];
		if (!empty($so_ids_no_phone)) {
			$so_rows = $this->db->select('so.id, so.no_telepon, so.no_telepon_pengirim, p.no_telp, p.telepon')
				->from('sales_order so')
				->join('pelanggan p', 'so.pelanggan_id = p.id', 'left')
				->where_in('so.id', array_values(array_unique($so_ids_no_phone)))
				->get()->result();
			foreach ($so_rows as $so) {
				$ph = !empty($so->no_telepon) && $so->no_telepon !== '-' ? $so->no_telepon : (!empty($so->no_telp) && $so->no_telp !== '-' ? $so->no_telp : (!empty($so->telepon) && $so->telepon !== '-' ? $so->telepon : (!empty($so->no_telepon_pengirim) && $so->no_telepon_pengirim !== '-' ? $so->no_telepon_pengirim : '')));
				if (!empty($ph)) $so_order_map[$so->id] = $ph;
			}
		}

		$pel_name_map = [];
		if (!empty($cust_names_no_phone)) {
			$pel_rows = $this->db->select('nama_pelanggan, telepon, no_telp')
				->from('pelanggan')
				->where_in('nama_pelanggan', array_values(array_unique($cust_names_no_phone)))
				->get()->result();
			foreach ($pel_rows as $pr) {
				$ph = !empty($pr->no_telp) && $pr->no_telp !== '-' ? $pr->no_telp : (!empty($pr->telepon) && $pr->telepon !== '-' ? $pr->telepon : '');
				if (!empty($ph) && !isset($pel_name_map[$pr->nama_pelanggan])) {
					$pel_name_map[$pr->nama_pelanggan] = $ph;
				}
			}
		}

		// 4. Enrich every row
		$enriched = [];
		foreach ($rows as $e) {
			// Order number
			$display_no_p = $e->no_pesanan ?: '-';
			if (stripos($display_no_p, 'WAHA-LIVE') !== false || stripos($display_no_p, 'GROUP') !== false) {
				$display_no_p = '-';
			}

			// Phone number resolution with full fallback
			$ph = trim((string)$e->customer_phone);
			if (empty($ph) || $ph === '-' || strpos($ph, '*') !== false) {
				if (!empty($e->customer_pelanggan_id) && isset($pel_id_map[$e->customer_pelanggan_id])) {
					$ph = $pel_id_map[$e->customer_pelanggan_id];
				} elseif ($e->order_table === 'penjualan_marketplace' && isset($pm_order_map[$e->order_id])) {
					$ph = $pm_order_map[$e->order_id];
				} elseif ($e->order_table === 'sales_order' && isset($so_order_map[$e->order_id])) {
					$ph = $so_order_map[$e->order_id];
				} elseif (isset($pel_name_map[$e->customer_nama])) {
					$ph = $pel_name_map[$e->customer_nama];
				}
			}
			$display_phone = (!empty($ph) && $ph !== '-') ? $ph : '-';

			// Normalized channel / source
			$src = $e->order_source ?: '';
			$no_p = $display_no_p !== '-' ? $display_no_p : '';
			if (stripos($src, 'Shopee') !== false || stripos($no_p, 'SHP') !== false) {
				$src = 'Shopee';
			} elseif (stripos($src, 'Tokopedia') !== false || stripos($no_p, 'TKP') !== false) {
				$src = 'Tokopedia';
			} elseif (stripos($src, 'TikTok') !== false || stripos($no_p, 'TTK') !== false) {
				$src = 'TikTok Shop';
			} elseif (stripos($src, 'WhatsApp') !== false) {
				$src = 'WhatsApp';
			} elseif (stripos($src, 'WAHA') !== false || stripos($src, 'Group') !== false) {
				$src = 'Toko';
			} else {
				$src = $src ?: 'Direct / Toko';
			}

			// Clean category display with (H+n)
			$cat_name = $e->nama_kategori ?: 'Follow-Up';
			$milestone_day = isset($e->jumlah_hari) ? (int)$e->jumlah_hari : 0;
			$clean_cat = preg_replace('/\s*\(H\+\d+\)/i', '', $cat_name);
			$display_kategori = $clean_cat . ' (H+' . $milestone_day . ')';

			// Dates and calculation
			$waktu_ref = !empty($e->tanggal_pengiriman) ? $e->tanggal_pengiriman : (!empty($e->created_at) ? date('Y-m-d', strtotime($e->created_at)) : date('Y-m-d'));
			$dt_ref = new DateTime(date('Y-m-d', strtotime($waktu_ref)));
			$dt_now = new DateTime(date('Y-m-d'));
			$diff_h = max(0, (int)$dt_ref->diff($dt_now)->format('%r%a'));

			$cur_bc = isset($e->keterangan_bc) ? trim($e->keterangan_bc) : '';
			$is_followed_up = !empty($cur_bc) 
				|| (!empty($no_p) && isset($order_completed_map[$no_p]['H+' . $milestone_day]))
				|| (!empty($e->status_label) && !in_array($e->status_label, ['Pending', 'belum_direspon']))
				|| ((int)$e->is_broadcast_sent === 1)
				|| !empty($e->waktu_kirim_wa);

			$is_overdue = ($diff_h > $milestone_day);
			$is_today = ($diff_h === $milestone_day);

			// Keterangan (Status Waktu & Umur Pesanan)
			if ($is_followed_up) {
				$display_keterangan = 'Sudah Di-Follow Up (✓ H+' . $diff_h . ')';
			} elseif ($is_overdue) {
				$display_keterangan = 'Terlewat (H+' . $diff_h . ')';
			} elseif ($is_today) {
				$display_keterangan = 'Jadwal Hari Ini (H+' . $diff_h . ')';
			} else {
				$display_keterangan = 'Mendatang (H+' . $diff_h . ')';
			}

			// Keterangan BC (Milestone Progress)
			if (!empty($cur_bc)) {
				$display_keterangan_bc = $cur_bc;
			} elseif (!empty($no_p) && !empty($order_completed_map[$no_p])) {
				$done_milestones = array_keys($order_completed_map[$no_p]);
				$display_keterangan_bc = 'Selesai: ' . implode(', ', $done_milestones);
			} else {
				$display_keterangan_bc = 'Belum Ada Follow-Up';
			}

			// Status
			$raw_status = trim($e->status_label ?? '');
			if (!empty($raw_status) && $raw_status !== 'Pending') {
				$display_status = $raw_status;
			} elseif ($is_followed_up) {
				$display_status = 'Sudah Dikirim';
			} elseif ($is_overdue) {
				$display_status = 'Overdue';
			} else {
				$display_status = 'Pending';
			}

			// Broadcast Terkirim
			if ($is_followed_up || (int)$e->is_broadcast_sent === 1 || !empty($e->waktu_kirim_wa)) {
				$display_broadcast = !empty($e->waktu_kirim_wa) ? ('Sudah (' . date('d/m/Y H:i', strtotime($e->waktu_kirim_wa)) . ')') : 'Sudah';
			} else {
				$display_broadcast = 'Belum';
			}

			$display_tgl_kirim = !empty($e->tanggal_pengiriman) ? date('d/m/Y', strtotime($e->tanggal_pengiriman)) : '-';
			$display_tgl_target = !empty($e->tanggal_label_muncul) ? date('d/m/Y', strtotime($e->tanggal_label_muncul)) : '-';

			$row_obj = clone $e;
			$row_obj->display_customer_nama = $e->customer_nama ?: '-';
			$row_obj->display_phone = $display_phone;
			$row_obj->display_no_pesanan = $display_no_p;
			$row_obj->display_sumber = $src;
			$row_obj->display_kategori = $display_kategori;
			$row_obj->display_tgl_kirim = $display_tgl_kirim;
			$row_obj->display_tgl_target = $display_tgl_target;
			$row_obj->display_keterangan = $display_keterangan;
			$row_obj->display_keterangan_bc = $display_keterangan_bc;
			$row_obj->display_status = $display_status;
			$row_obj->display_broadcast = $display_broadcast;
			$row_obj->diff_h = $diff_h;
			$row_obj->is_followed_up = $is_followed_up;
			$row_obj->is_overdue = $is_overdue;

			$enriched[] = $row_obj;
		}

		return $enriched;
	}

	/**
	 * Ensure at least one followup label exists for a given phone number so that 2-way chat modal can open
	 */
	public function ensure_label_for_phone($phone, $nama_fallback = '')
	{
		$is_jid = (strpos($phone, '@') !== false);
		if ($is_jid) {
			$existing = $this->db->get_where('crm_transaction_followup_labels', ['customer_phone' => $phone])->row();
			if ($existing) {
				return $existing->id;
			}
		} else {
			$clean_phone = preg_replace('/[^0-9]/', '', (string)$phone);
			if (empty($clean_phone)) return null;

			$where_clause = $this->get_phone_where_clause('tfl.customer_phone', $phone);
			$existing = $this->db->query("SELECT id FROM crm_transaction_followup_labels tfl WHERE " . $where_clause . " ORDER BY tfl.id DESC LIMIT 1")->row();
			if ($existing) {
				return $existing->id;
			}
		}

		// Find customer and order info from sales_order or marketplace
		$nama = !empty($nama_fallback) ? $nama_fallback : 'Customer';
		$order_source = 'Toko';
		$order_table = 'sales_order';
		$order_id = 0;
		$clean_num = preg_replace('/[^0-9]/', '', $phone);
		$no_pesanan = 'TRX-' . date('Ymd') . '-' . (strlen($clean_num) >= 4 ? substr($clean_num, -4) : rand(1000, 9999));

		if (!$is_jid) {
			$pm_cust = $this->db->query("SELECT pm.id, pm.no_pesanan, pm.nomor_so, pm.source, pm.nama_penerima as nama FROM penjualan_marketplace pm WHERE " . $this->get_phone_where_clause('pm.no_telepon', $phone) . " ORDER BY pm.id DESC LIMIT 1")->row();
			$so_cust = $this->db->query("SELECT so.id, so.no_pesanan, so.nomor_so, so.source, so.nama_penerima as nama FROM sales_order so WHERE " . $this->get_phone_where_clause('so.no_telepon', $phone) . " ORDER BY so.id DESC LIMIT 1")->row();

			if ($pm_cust) {
				$nama = !empty($pm_cust->nama) ? $pm_cust->nama : $nama;
				$order_table = 'penjualan_marketplace';
				$order_id = $pm_cust->id;
				$no_pesanan = $pm_cust->no_pesanan ?: ($pm_cust->nomor_so ?: $no_pesanan);
				$pm_src = strtolower($pm_cust->source ?: '');
				$pm_nop = strtolower($no_pesanan);
				if (strpos($pm_src, 'tokopedia') !== false || strpos($pm_nop, 'tkp') !== false) $order_source = 'Tokopedia';
				elseif (strpos($pm_src, 'tiktok') !== false || strpos($pm_nop, 'ttk') !== false) $order_source = 'TikTok Shop';
				else $order_source = 'Shopee';
			} elseif ($so_cust) {
				$nama = !empty($so_cust->nama) ? $so_cust->nama : $nama;
				$order_table = 'sales_order';
				$order_id = $so_cust->id;
				$no_pesanan = $so_cust->no_pesanan ?: ($so_cust->nomor_so ?: $no_pesanan);
				$so_src = strtolower($so_cust->source ?: '');
				$so_nop = strtolower($no_pesanan);
				if (strpos($so_src, 'shopee') !== false || strpos($so_nop, 'shp') !== false) $order_source = 'Shopee';
				elseif (strpos($so_src, 'tokopedia') !== false || strpos($so_nop, 'tkp') !== false) $order_source = 'Tokopedia';
				elseif (strpos($so_src, 'tiktok') !== false || strpos($so_nop, 'ttk') !== false) $order_source = 'TikTok Shop';
				else $order_source = 'Toko';
			}
		}

		$categories = $this->get_categories(true);
		$cat_id = !empty($categories) ? $categories[0]->id : 1;
		$now = date('Y-m-d H:i:s');

		$this->db->insert('crm_transaction_followup_labels', [
			'order_source' => $order_source,
			'order_id' => $order_id,
			'order_table' => $order_table,
			'customer_nama' => $nama,
			'customer_phone' => $phone,
			'no_pesanan' => $no_pesanan,
			'tanggal_pengiriman' => date('Y-m-d'),
			'followup_category_id' => $cat_id,
			'tanggal_label_muncul' => date('Y-m-d'),
			'status_label' => 'Direspon',
			'created_at' => $now,
			'updated_at' => $now,
		]);

		return $this->db->insert_id();
	}

	/**
	 * Get all chat conversations for dedicated WhatsApp Chat Center page
	 * OPTIMIZED: Uses batch query instead of N+1 get_customer_summary() per row
	 */
	public function get_all_chat_conversations($search = '')
	{
		$sql = "
			SELECT 
				tfl.id as label_id,
				tfl.customer_nama,
				tfl.customer_phone,
				tfl.no_pesanan,
				tfl.order_source,
				tfl.status_label,
				tfl.updated_at,
				(SELECT message FROM crm_chat_history ch WHERE (ch.label_id = tfl.id OR (LENGTH(ch.customer_phone) >= 9 AND RIGHT(ch.customer_phone, 9) = RIGHT(tfl.customer_phone, 9))) ORDER BY ch.created_at DESC, ch.id DESC LIMIT 1) as last_message,
				(SELECT created_at FROM crm_chat_history ch WHERE (ch.label_id = tfl.id OR (LENGTH(ch.customer_phone) >= 9 AND RIGHT(ch.customer_phone, 9) = RIGHT(tfl.customer_phone, 9))) ORDER BY ch.created_at DESC, ch.id DESC LIMIT 1) as last_message_at,
				(SELECT COUNT(*) FROM crm_chat_history ch WHERE (ch.label_id = tfl.id OR (LENGTH(ch.customer_phone) >= 9 AND RIGHT(ch.customer_phone, 9) = RIGHT(tfl.customer_phone, 9))) AND ch.direction = 'in' AND ch.status != 'read') as unread_count
			FROM crm_transaction_followup_labels tfl
			INNER JOIN (
				SELECT MAX(id) as max_id
				FROM crm_transaction_followup_labels
				WHERE customer_phone IS NOT NULL AND customer_phone != ''
				GROUP BY IF(customer_phone LIKE '%@g.us', customer_phone, RIGHT(customer_phone, 9))
			) latest ON latest.max_id = tfl.id
			WHERE 1=1
		";

		if (!empty($search)) {
			$s = $this->db->escape_like_str($search);
			$clean_search = preg_replace('/[^0-9]/', '', $search);
			
			$phone_conds = ["tfl.customer_phone LIKE '%" . $s . "%'"];
			if (strlen($clean_search) >= 4) {
				$tail = strlen($clean_search) >= 8 ? substr($clean_search, -8) : $clean_search;
				$tail_esc = $this->db->escape_like_str($tail);
				$phone_conds[] = "RIGHT(tfl.customer_phone, 8) LIKE '%" . $tail_esc . "%'";
				
				if (substr($clean_search, 0, 2) === '08') {
					$alt = '628' . substr($clean_search, 2);
					$phone_conds[] = "tfl.customer_phone LIKE '%" . $alt . "%'";
				} elseif (substr($clean_search, 0, 3) === '628') {
					$alt = '08' . substr($clean_search, 3);
					$phone_conds[] = "tfl.customer_phone LIKE '%" . $alt . "%'";
				}
			}
			$phone_sql = implode(' OR ', $phone_conds);

			$sql .= " AND (tfl.customer_nama LIKE '%" . $s . "%' OR (" . $phone_sql . ") OR tfl.no_pesanan LIKE '%" . $s . "%')";
		} else {
			$sql .= " HAVING (last_message_at IS NOT NULL)";
		}

		$sql .= " ORDER BY 
			unread_count DESC,
			(last_message_at IS NOT NULL) DESC,
			last_message_at DESC,
			tfl.updated_at DESC
			LIMIT 100
		";

		$rows = $this->db->query($sql)->result();

		if (empty($rows)) {
			return $rows;
		}

		// --- BATCH RFM: collect unique phones, do 1 batch query ---
		$phones = [];
		foreach ($rows as $r) {
			$clean = preg_replace('/[^0-9]/', '', (string)$r->customer_phone);
			if (!empty($clean)) {
				$phones[$clean] = $r->customer_phone;
			}
		}

		// Build batch summary: 1 query for all phones at once
		$phone_rfm_map = [];
		if (!empty($phones)) {
			$phone_rfm_map = $this->batch_get_rfm_for_phones(array_values($phones));
		}

		// Attach RFM to each row using phone lookup
		foreach ($rows as &$r) {
			$clean = preg_replace('/[^0-9]/', '', (string)$r->customer_phone);
			$tail = strlen($clean) >= 9 ? substr($clean, -9) : $clean;
			$r->rfm = isset($phone_rfm_map[$tail]) ? $phone_rfm_map[$tail] : [
				'segment' => 'Need Attention',
				'badge' => $this->get_rfm_badge_style('Need Attention')
			];
		}

		return $rows;
	}

	/**
	 * Batch get RFM data for multiple phones in 2 queries instead of N*6
	 * Returns array keyed by last-9-digits of phone
	 */
	private function batch_get_rfm_for_phones($phones)
	{
		if (empty($phones)) return [];

		// Build OR conditions for all phones
		$conditions_so = [];
		$conditions_pm = [];
		$phone_tails = [];

		foreach ($phones as $phone) {
			$clean = preg_replace('/[^0-9]/', '', (string)$phone);
			if (empty($clean)) continue;

			$tail = strlen($clean) >= 9 ? substr($clean, -9) : $clean;
			$phone_tails[$tail] = true;

			$tail_esc = $this->db->escape_str($tail);
			$conditions_so[] = "(LENGTH(so.no_telepon) >= 9 AND RIGHT(so.no_telepon, 9) = '" . $tail_esc . "')";
			$conditions_pm[] = "(LENGTH(pm.no_telepon) >= 9 AND RIGHT(pm.no_telepon, 9) = '" . $tail_esc . "')";
		}

		if (empty($conditions_so)) return [];

		// Query 1: sales_order summary grouped by phone tail
		$so_where = implode(' OR ', $conditions_so);
		$sql_so = "SELECT 
			RIGHT(so.no_telepon, 9) as phone_tail,
			COUNT(*) as cnt,
			COALESCE(SUM(so.total), 0) as spend,
			MAX(so.tanggal_so) as last_date
		FROM sales_order so
		WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
		  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))
		  AND (" . $so_where . ")
		GROUP BY phone_tail";

		// Query 2: penjualan_marketplace summary grouped by phone tail
		$pm_where = implode(' OR ', $conditions_pm);
		$sql_pm = "SELECT 
			RIGHT(pm.no_telepon, 9) as phone_tail,
			COUNT(*) as cnt,
			COALESCE(SUM(pm.total), 0) as spend,
			MAX(pm.tanggal_so) as last_date
		FROM penjualan_marketplace pm
		WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != '' AND (" . $pm_where . ")
		GROUP BY phone_tail";

		$so_data = [];
		$pm_data = [];

		$so_rows = $this->db->query($sql_so)->result();
		foreach ($so_rows as $row) {
			$so_data[$row->phone_tail] = $row;
		}

		$pm_rows = $this->db->query($sql_pm)->result();
		foreach ($pm_rows as $row) {
			$pm_data[$row->phone_tail] = $row;
		}

		// Calculate RFM for each phone
		$thresholds = $this->get_rfm_percentile_thresholds();
		$result = [];

		foreach (array_keys($phone_tails) as $tail) {
			$so = isset($so_data[$tail]) ? $so_data[$tail] : null;
			$pm = isset($pm_data[$tail]) ? $pm_data[$tail] : null;

			$total_orders = ($so ? (int)$so->cnt : 0) + ($pm ? (int)$pm->cnt : 0);
			$total_spend = ($so ? (float)$so->spend : 0) + ($pm ? (float)$pm->spend : 0);

			$last_dates = array_filter([
				$so ? $so->last_date : null,
				$pm ? $pm->last_date : null
			]);
			$last_order = !empty($last_dates) ? max($last_dates) : null;

			$rfm = $this->calculate_rfm($last_order, $total_orders, $total_spend, $thresholds);
			$result[$tail] = $rfm;
		}

		return $result;
	}



	/**
	 * Get all active follow-up categories
	 */
	public function get_categories($active_only = true)
	{
		$this->db->order_by('urutan', 'ASC');
		$this->db->order_by('jumlah_hari', 'ASC');
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

	public function delete_category($id, $force = false)
	{
		// Cek apakah ada label yang sudah berjalan (sudah dikirim / direspon / status selain Pending)
		$active_count = $this->db->where('followup_category_id', $id)
			->group_start()
				->where('is_broadcast_sent', 1)
				->or_where('status_label !=', 'Pending')
			->group_end()
			->count_all_results('crm_transaction_followup_labels');

		if ($active_count > 0 && !$force) {
			return [
				'success' => false,
				'has_history' => true,
				'active_count' => $active_count,
				'message' => "Kategori ini memiliki {$active_count} riwayat follow-up yang sudah diproses/terkirim."
			];
		}

		// Hapus catatan follow-up dan antrean label transaksi yang terkait kategori ini
		$label_rows = $this->db->select('id')->where('followup_category_id', $id)->get('crm_transaction_followup_labels')->result_array();
		if (!empty($label_rows)) {
			$label_ids = array_column($label_rows, 'id');
			if (!empty($label_ids)) {
				$this->db->where_in('followup_label_id', $label_ids)->delete('crm_followup_notes');
			}
			$this->db->where('followup_category_id', $id)->delete('crm_transaction_followup_labels');
		}

		$del = $this->db->delete('crm_followup_categories', ['id' => $id]);
		return [
			'success' => (bool)$del,
			'message' => $del ? 'Kategori & template follow-up berhasil dihapus' : 'Gagal menghapus kategori'
		];
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

	public function update_keterangan_bc($label_id, $keterangan_bc, $handled_by = null)
	{
		$label = $this->db->get_where('crm_transaction_followup_labels', ['id' => $label_id])->row();
		if (!$label) return false;

		$val = !empty($keterangan_bc) ? $keterangan_bc : null;
		$data = [
			'keterangan_bc' => $val,
			'updated_at'    => date('Y-m-d H:i:s'),
		];
		if ($handled_by) $data['handled_by'] = $handled_by;

		$is_h_match = preg_match('/\(H\+(\d+)\)/i', (string)$keterangan_bc, $m) || preg_match('/^H\+(\d+)$/i', (string)$keterangan_bc, $m);
		$selected_h = $is_h_match ? (int)$m[1] : null;

		if ($selected_h !== null) {
			// An H+ milestone was selected (e.g. H+0, H+3, etc.)
			// Update the specific milestone label that matches $selected_h
			$cat = $this->db->get_where('crm_followup_categories', ['jumlah_hari' => $selected_h])->row();
			$cat_id = $cat ? $cat->id : $label->followup_category_id;

			$target_label = null;
			if (!empty($label->order_table) && !empty($label->order_id)) {
				$target_label = $this->db->get_where('crm_transaction_followup_labels', [
					'order_table' => $label->order_table,
					'order_id' => $label->order_id,
					'followup_category_id' => $cat_id
				])->row();
			} elseif (!empty($label->no_pesanan) && $label->no_pesanan !== '-' && trim($label->no_pesanan) !== '') {
				$target_label = $this->db->get_where('crm_transaction_followup_labels', [
					'no_pesanan' => $label->no_pesanan,
					'followup_category_id' => $cat_id
				])->row();
			}

			if ($target_label) {
				$this->db->where('id', $target_label->id)->update('crm_transaction_followup_labels', $data);
			} else {
				$this->db->where('id', $label_id)->update('crm_transaction_followup_labels', $data);
			}
		} else {
			// Single label update or reset
			$this->db->where('id', $label_id)->update('crm_transaction_followup_labels', $data);
		}

		// Synchronize latest keterangan_bc to penjualan_marketplace
		if ($label->order_table === 'penjualan_marketplace' && !empty($label->order_id)) {
			$this->db->where('id', $label->order_id)->update('penjualan_marketplace', [
				'keterangan_bc' => $val,
				'updated_at'    => date('Y-m-d H:i:s')
			]);
		}
		if (!empty($label->no_pesanan) && $label->no_pesanan !== '-' && trim($label->no_pesanan) !== '') {
			$this->db->where('no_pesanan', $label->no_pesanan)->update('penjualan_marketplace', [
				'keterangan_bc' => $val,
				'updated_at'    => date('Y-m-d H:i:s')
			]);
		}

		return true;
	}

	/**
	 * Add follow-up note (FB-07) — supports sender_type for 2-way chat
	 */
	public function add_note($label_id, $catatan, $status_manual = null, $sender_type = 'cs')
	{
		$author = function_exists('get_user_data') ? (get_user_data('full_name') ?: get_user_data('username')) : null;
		if (empty($author)) $author = ($sender_type === 'customer' ? 'Customer' : 'Petugas CS');
		return $this->db->insert('crm_followup_notes', [
			'followup_label_id' => $label_id,
			'username' => $author,
			'catatan' => $catatan,
			'status_manual' => $status_manual,
			'sender_type' => in_array($sender_type, ['cs','customer','system']) ? $sender_type : 'cs',
			'created_at' => date('Y-m-d H:i:s'),
		]);
	}

	public function get_notes($label_id)
	{
		return $this->db->where('followup_label_id', $label_id)->order_by('created_at', 'DESC')->get('crm_followup_notes')->result();
	}

	/**
	 * Canonical Phone Number Normalizer (628xxxxxxxxxx)
	 * Unit-testable: converts 08xx, +628xx, 628xx, 8xx to 628xx
	 */
	public function normalize_phone_number($phone)
	{
		$digits = preg_replace('/[^0-9]/', '', (string)$phone);
		if (empty($digits)) return '';
		if (substr($digits, 0, 1) === '0') {
			return '62' . substr($digits, 1);
		}
		if (substr($digits, 0, 2) !== '62') {
			return '62' . $digits;
		}
		return $digits;
	}

	public function normalize_phone($phone)
	{
		return $this->normalize_phone_number($phone);
	}

	/**
	 * Log incoming WhatsApp reply from customer (Webhook)
	 * Finds matching label(s) by phone, saves reply, auto-updates status to Direspon
	 */
	public function log_incoming_reply($phone, $message, $sender_name = '', $raw_data = null)
	{
		if (stripos($message, 'Sent via fonnte.com') !== false || stripos($message, 'fonnte.com') !== false) {
			return 0;
		}

		if (empty($phone) || strpos($phone, '@newsletter') !== false || strpos($phone, '@broadcast') !== false || $phone === '0@c.us' || $phone === '0') {
			return 0;
		}

		$clean_input_phone = $this->normalize_phone_number($phone);
		if (empty($clean_input_phone)) {
			$clean_input_phone = preg_replace('/[^0-9]/', '', $phone);
		}
		$phone_tail = strlen($clean_input_phone) >= 9 ? substr($clean_input_phone, -9) : $clean_input_phone;

		// 1. Log raw payload into crm_webhook_logs for audit FIRST (before any processing)
		$this->db->insert('crm_webhook_logs', [
			'sender' => $clean_input_phone ? $clean_input_phone : $phone,
			'sender_name' => $sender_name,
			'message' => $message,
			'raw_payload' => is_string($raw_data) ? $raw_data : json_encode($raw_data),
			'processed_count' => 1,
			'created_at' => date('Y-m-d H:i:s'),
		]);
		$webhook_log_id = $this->db->insert_id();

		// Find active labels for this phone by comparing canonical numbers (newest first)
		$all_labels = $this->db
			->order_by('id', 'DESC')
			->get('crm_transaction_followup_labels')
			->result();

		$is_jid = (strpos($phone, '@') !== false);
		$matched_labels = [];
		foreach ($all_labels as $lbl) {
			if ($is_jid && $lbl->customer_phone === $phone) {
				$matched_labels[] = $lbl;
				break;
			}
			$clean_db_phone = $this->normalize_phone_number($lbl->customer_phone);
			if ($clean_db_phone === $clean_input_phone || (!empty($phone_tail) && strlen($clean_db_phone) >= 9 && substr($clean_db_phone, -9) === $phone_tail)) {
				// Prefer active labels
				if (!in_array($lbl->status_label, ['Selesai', 'Batal (Retur/Cancelled)'])) {
					$matched_labels[] = $lbl;
				}
			}
		}

		// Fallback: if all existing labels are Selesai, select the most recent label for this phone
		if (empty($matched_labels)) {
			foreach ($all_labels as $lbl) {
				if ($is_jid && $lbl->customer_phone === $phone) {
					$matched_labels[] = $lbl;
					break;
				}
				$clean_db_phone = $this->normalize_phone_number($lbl->customer_phone);
				if ($clean_db_phone === $clean_input_phone || (!empty($phone_tail) && strlen($clean_db_phone) >= 9 && substr($clean_db_phone, -9) === $phone_tail)) {
					$matched_labels[] = $lbl;
					break;
				}
			}
		}

		// Fallback 2: If no label exists at all for this customer phone, check sales_order / penjualan_marketplace
		if (empty($matched_labels)) {
			$cust_name = !empty($sender_name) ? $sender_name : ($is_jid ? 'WhatsApp Group' : ('+' . $phone));
			$order_table = 'sales_order';
			$order_id = 0;
			$order_source = 'Toko';
			$clean_num = preg_replace('/[^0-9]/', '', $phone);
			$no_pesanan = 'TRX-' . date('Ymd') . '-' . (strlen($clean_num) >= 4 ? substr($clean_num, -4) : rand(1000, 9999));

			$so_match = $this->db->query("SELECT id, nomor_so, no_pesanan, source, nama_penerima FROM sales_order WHERE no_telepon LIKE ? ORDER BY id DESC LIMIT 1", ["%" . $phone_tail . "%"])->row();
			$mp_match = $this->db->query("SELECT id, nomor_so, no_pesanan, source, nama_penerima FROM penjualan_marketplace WHERE no_telepon LIKE ? ORDER BY id DESC LIMIT 1", ["%" . $phone_tail . "%"])->row();

			if ($mp_match) {
				if (!empty($mp_match->nama_penerima)) $cust_name = $mp_match->nama_penerima;
				$order_table = 'penjualan_marketplace';
				$order_id = $mp_match->id;
				$no_pesanan = $mp_match->no_pesanan ?: ($mp_match->nomor_so ?: $no_pesanan);
				$mp_src = strtolower($mp_match->source ?: '');
				$mp_nop = strtolower($no_pesanan);
				if (strpos($mp_src, 'tokopedia') !== false || strpos($mp_nop, 'tkp') !== false) $order_source = 'Tokopedia';
				elseif (strpos($mp_src, 'tiktok') !== false || strpos($mp_nop, 'ttk') !== false) $order_source = 'TikTok Shop';
				else $order_source = 'Shopee';
			} elseif ($so_match) {
				if (!empty($so_match->nama_penerima)) $cust_name = $so_match->nama_penerima;
				$order_table = 'sales_order';
				$order_id = $so_match->id;
				$no_pesanan = $so_match->no_pesanan ?: ($so_match->nomor_so ?: $no_pesanan);
				$so_src = strtolower($so_match->source ?: '');
				$so_nop = strtolower($no_pesanan);
				if (strpos($so_src, 'shopee') !== false || strpos($so_nop, 'shp') !== false) $order_source = 'Shopee';
				elseif (strpos($so_src, 'tokopedia') !== false || strpos($so_nop, 'tkp') !== false) $order_source = 'Tokopedia';
				elseif (strpos($so_src, 'tiktok') !== false || strpos($so_nop, 'ttk') !== false) $order_source = 'TikTok Shop';
				else $order_source = 'Toko';
			}

			$first_cat = $this->db->query("SELECT id FROM crm_followup_categories WHERE is_active = 1 ORDER BY jumlah_hari ASC, urutan ASC LIMIT 1")->row();
			$cat_id = $first_cat ? $first_cat->id : 1;

			$new_label_data = [
				'order_source' => $order_source,
				'order_id' => $order_id,
				'order_table' => $order_table,
				'customer_nama' => $cust_name,
				'customer_phone' => $phone,
				'no_pesanan' => $no_pesanan,
				'tanggal_pengiriman' => date('Y-m-d'),
				'followup_category_id' => $cat_id,
				'tanggal_label_muncul' => date('Y-m-d'),
				'status_label' => 'Direspon',
				'handled_by' => 'system',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];
			$this->db->insert('crm_transaction_followup_labels', $new_label_data);
			$new_id = $this->db->insert_id();

			$new_label = $this->db->get_where('crm_transaction_followup_labels', ['id' => $new_id])->row();
			if ($new_label) {
				$matched_labels[] = $new_label;
			}
		}

		$logged_count = 0;

		if (!empty($matched_labels)) {
			// Always pick the newest active label as primary
			$primary_label = $matched_labels[0];
			$cust_username = !empty($primary_label->customer_nama) ? $primary_label->customer_nama : (!empty($sender_name) ? $sender_name : 'Customer');

			// Idempotency check: Skip echo of CS outgoing message only if EXACT match and within 60s
			$one_min_ago = date('Y-m-d H:i:s', time() - 60);
			$clean_check_msg = trim(str_replace(['> _Sent via fonnte.com_', '_Sent via fonnte.com_', 'Sent via fonnte.com'], '', $message));

			if (mb_strlen($clean_check_msg) >= 3) {
				$cs_outgoing_exists = $this->db->query("
					SELECT id FROM crm_chat_history 
					WHERE label_id = ? AND created_at >= ? 
					  AND direction = 'out' AND is_internal_note = 0
					  AND TRIM(message) = ?
					LIMIT 1
				", [$primary_label->id, $one_min_ago, $clean_check_msg])->num_rows();

				if ($cs_outgoing_exists > 0) {
					return 0; // Skip echo of CS outgoing message
				}
			}

			// Prevent rapid duplicate webhook retries (within 10 seconds only)
			$ten_secs_ago = date('Y-m-d H:i:s', time() - 10);
			$dup_check = $this->db->where([
				'label_id' => $primary_label->id,
				'direction' => 'in',
				'message' => $message,
				'created_at >=' => $ten_secs_ago
			])->count_all_results('crm_chat_history');

			if ($dup_check == 0) {
				$now = date('Y-m-d H:i:s');

				// Insert into legacy crm_followup_notes for backward compat
				$this->db->insert('crm_followup_notes', [
					'followup_label_id' => $primary_label->id,
					'username' => $cust_username,
					'catatan' => $message,
					'status_manual' => 'Direspon',
					'sender_type' => 'customer',
					'created_at' => $now,
				]);

				// Insert into new crm_chat_history table
				$this->insert_chat_message([
					'label_id' => (int)$primary_label->id,
					'customer_phone' => $clean_input_phone,
					'direction' => 'in',
					'message' => $message,
					'sender_name' => $cust_username,
					'is_internal_note' => 0,
					'status' => 'delivered',
					'webhook_log_id' => (int)$webhook_log_id,
					'created_at' => $now,
				]);

				$logged_count++;
			}

			// Update status to Direspon for active labels
			foreach ($matched_labels as $label) {
				if (in_array($label->status_label, ['Pending', 'Sudah Dikirim', 'Belum Respon'])) {
					$this->db->where('id', $label->id)->update('crm_transaction_followup_labels', [
						'status_label' => 'Direspon',
						'updated_at' => date('Y-m-d H:i:s'),
					]);
				}
			}
		} else {
			// Unmatched phone number: Log into crm_unmatched_inbound (Section 4.1 Requirement 26)
			$this->db->insert('crm_unmatched_inbound', [
				'sender_phone' => $clean_input_phone,
				'sender_name' => $sender_name ? $sender_name : 'Unknown Customer',
				'message' => $message,
				'raw_payload' => is_string($raw_data) ? $raw_data : json_encode($raw_data),
				'status' => 'pending',
				'created_at' => date('Y-m-d H:i:s'),
			]);

			// Auto-create a label in crm_transaction_followup_labels so CS can see & reply in UI
			$first_cat = $this->db->query("SELECT id FROM crm_followup_categories WHERE is_active = 1 ORDER BY jumlah_hari ASC, urutan ASC LIMIT 1")->row();
			$cat_id = $first_cat ? $first_cat->id : 1;
			$cust_name = !empty($sender_name) ? $sender_name : ('Customer (' . $clean_input_phone . ')');

			$new_label_data = [
				'order_source' => 'WhatsApp',
				'order_id' => 0,
				'order_table' => 'crm_unmatched_inbound',
				'customer_nama' => $cust_name,
				'customer_phone' => $clean_input_phone,
				'no_pesanan' => 'WA-CHAT',
				'tanggal_pengiriman' => date('Y-m-d'),
				'followup_category_id' => $cat_id,
				'tanggal_label_muncul' => date('Y-m-d'),
				'status_label' => 'Direspon',
				'handled_by' => 'system',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];
			$this->db->insert('crm_transaction_followup_labels', $new_label_data);
			$new_id = $this->db->insert_id();

			$now = date('Y-m-d H:i:s');
			if ($new_id) {
				$this->db->insert('crm_followup_notes', [
					'followup_label_id' => $new_id,
					'username' => $cust_name,
					'catatan' => $message,
					'status_manual' => 'Direspon',
					'sender_type' => 'customer',
					'created_at' => $now,
				]);

				$this->insert_chat_message([
					'label_id' => (int)$new_id,
					'customer_phone' => $clean_input_phone,
					'direction' => 'in',
					'message' => $message,
					'sender_name' => $cust_name,
					'is_internal_note' => 0,
					'status' => 'delivered',
					'webhook_log_id' => (int)$webhook_log_id,
					'created_at' => $now,
				]);
			}

			$logged_count++;
		}

		return $logged_count;
	}

	// ===== 2-WAY CHAT HISTORY (crm_chat_history) =====

	/**
	 * Insert a message into crm_chat_history
	 * @param array $data Keys: label_id, customer_phone, direction, message, sender_name, sender_cs_name, is_internal_note, status, fonnte_response, webhook_log_id, created_at
	 * @return int insert_id
	 */
	public function insert_chat_message($data)
	{
		$insert = [
			'label_id' => (int)($data['label_id']),
			'customer_phone' => isset($data['customer_phone']) ? $data['customer_phone'] : '',
			'direction' => isset($data['direction']) ? $data['direction'] : 'out',
			'message' => isset($data['message']) ? $data['message'] : '',
			'sender_name' => isset($data['sender_name']) ? $data['sender_name'] : null,
			'sender_cs_name' => isset($data['sender_cs_name']) ? $data['sender_cs_name'] : null,
			'is_internal_note' => isset($data['is_internal_note']) ? (int)$data['is_internal_note'] : 0,
			'status' => isset($data['status']) ? $data['status'] : 'sent',
			'fonnte_response' => isset($data['fonnte_response']) ? $data['fonnte_response'] : null,
			'webhook_log_id' => isset($data['webhook_log_id']) ? (int)$data['webhook_log_id'] : null,
			'created_at' => isset($data['created_at']) ? $data['created_at'] : date('Y-m-d H:i:s'),
		];
		$this->db->insert('crm_chat_history', $insert);
		return $this->db->insert_id();
	}

	/**
	 * Get new messages after a given ID (optimized polling)
	 * Only returns messages inserted AFTER last_id, avoiding full refetch.
	 * @param int $label_id
	 * @param int $last_id Last message ID the client already has
	 * @return array
	 */
	public function get_new_messages($label_id, $last_id = 0)
	{
		$label = $this->get_label($label_id);
		if (!$label) return [];
		if ($last_id <= 0) return [];

		$label_ids = $this->get_related_label_ids($label);
		$clean_phone = $this->normalize_phone_number($label->customer_phone);
		$phone_tail = strlen($clean_phone) >= 9 ? substr($clean_phone, -9) : $clean_phone;

		$this->db->select('id, label_id, customer_phone, direction, message, sender_name, sender_cs_name, is_internal_note, status, created_at')
			->from('crm_chat_history');

		$this->db->group_start();
		$this->db->where_in('label_id', $label_ids);
		if (strpos($label->customer_phone, '@') !== false) {
			$this->db->or_where('customer_phone', $label->customer_phone);
		} elseif (!empty($phone_tail)) {
			$this->db->or_like('customer_phone', $phone_tail);
		}
		$this->db->group_end();

		if ($last_id > 0) {
			$this->db->where('id >', (int)$last_id);
		}

		$this->db->order_by('created_at', 'ASC');
		$this->db->order_by('id', 'ASC');
		$rows = $this->db->get()->result_array();

		$cust_display_name = !empty($label->customer_nama) ? $label->customer_nama : 'Pelanggan';

		$timeline = [];
		foreach ($rows as $row) {
			// Skip Fonnte outgoing echo falsely logged as incoming
			if ($row['direction'] === 'in' && !empty($row['message']) && (stripos($row['message'], 'Sent via fonnte.com') !== false || stripos($row['message'], 'fonnte.com') !== false)) {
				continue;
			}

			$direction = 'note';
			if ($row['is_internal_note']) {
				$direction = 'note';
			} elseif ($row['direction'] === 'in') {
				$direction = 'incoming';
			} elseif ($row['direction'] === 'out') {
				$direction = 'outgoing';
			}

			$sender = '';
			if ($direction === 'incoming') {
				$sender = !empty($row['sender_name']) ? $row['sender_name'] : $cust_display_name;
			} else {
				$raw_s = !empty($row['sender_cs_name']) ? $row['sender_cs_name'] : (!empty($row['sender_name']) ? $row['sender_name'] : 'Petugas CS');
				$sender = ucwords(clean_snake_case($raw_s));
			}

			$timeline[] = [
				'id' => (int)$row['id'],
				'direction' => $direction,
				'message' => $row['message'],
				'sender' => $sender,
				'sender_type' => $row['is_internal_note'] ? 'cs' : ($row['direction'] === 'in' ? 'customer' : 'cs_chat'),
				'created_at' => $row['created_at'],
				'metode_kirim' => ($row['direction'] === 'out' && !$row['is_internal_note']) ? 'wa_gateway_api' : '',
				'status_kirim' => isset($row['status']) ? $row['status'] : '',
				'is_internal_note' => (int)$row['is_internal_note'],
			];
		}

		return $timeline;
	}

	/**
	 * Get all related label IDs for a customer (by phone tail matching)
	 * OPTIMIZED: Uses SQL WHERE instead of loading entire table into PHP
	 * @param object $label
	 * @return array of label IDs
	 */
	public function get_related_label_ids($label)
	{
		$clean_phone = $this->normalize_phone_number($label->customer_phone);
		$phone_tail = strlen($clean_phone) >= 9 ? substr($clean_phone, -9) : $clean_phone;

		if (empty($phone_tail)) {
			return [(int)$label->id];
		}

		$tail_esc = $this->db->escape_str($phone_tail);
		$sql = "SELECT id FROM crm_transaction_followup_labels 
				WHERE LENGTH(customer_phone) >= 9 AND RIGHT(customer_phone, 9) = '" . $tail_esc . "'";
		$rows = $this->db->query($sql)->result();

		$label_ids = [];
		foreach ($rows as $r) {
			$label_ids[] = (int)$r->id;
		}

		if (empty($label_ids)) {
			$label_ids = [(int)$label->id];
		}

		return array_unique($label_ids);
	}

	/**
	 * Get unified 2-way chat timeline for a label / customer
	 * Merges: crm_chat_history (new) + legacy broadcast_logs + legacy followup_notes
	 */
	public function get_chat_timeline($label_id)
	{
		$label = $this->get_label($label_id);
		if (!$label) return [];

		$label_ids = $this->get_related_label_ids($label);
		$clean_phone = $this->normalize_phone_number($label->customer_phone);
		$phone_tail = strlen($clean_phone) >= 9 ? substr($clean_phone, -9) : $clean_phone;

		// Source 1: NEW crm_chat_history table
		$chat_rows = [];
		if ($this->db->table_exists('crm_chat_history')) {
			$this->db->select('id, direction, message, sender_name, sender_cs_name, is_internal_note, status, created_at')
				->from('crm_chat_history');

			$this->db->group_start();
			$this->db->where_in('label_id', $label_ids);
			if (strpos($label->customer_phone, '@') !== false) {
				$this->db->or_where('customer_phone', $label->customer_phone);
			} elseif (!empty($phone_tail)) {
				$this->db->or_like('customer_phone', $phone_tail);
			}
			$this->db->group_end();

			$chat_rows = $this->db->get()->result_array();
		}

		// Source 2: Legacy broadcast_logs (outgoing)
		$this->db->select('bl.id, bl.isi_pesan_final as message, bl.dikirim_oleh as sender, bl.waktu_kirim as created_at, bl.metode_kirim, bl.status_kirim')
			->from('crm_broadcast_logs bl')
			->where_in('bl.followup_label_id', $label_ids);
		$legacy_outgoing = $this->db->get()->result_array();

		// Source 3: Legacy followup_notes
		$legacy_notes = $this->db->select('fn.id, fn.catatan as message, fn.username as sender, fn.created_at, fn.sender_type')
			->from('crm_followup_notes fn')
			->where_in('fn.followup_label_id', $label_ids)
			->get()->result_array();

		$cust_display_name = !empty($label->customer_nama) ? $label->customer_nama : 'Pelanggan';

		// Normalize all items into unified format
		$raw_timeline = [];

		// New chat_history items
		foreach ($chat_rows as $row) {
			$direction = 'note';
			if ($row['is_internal_note']) {
				$direction = 'note';
			} elseif ($row['direction'] === 'in') {
				$direction = 'incoming';
			} elseif ($row['direction'] === 'out') {
				$direction = 'outgoing';
			}

			$sender = '';
			if ($direction === 'incoming') {
				$sender = !empty($row['sender_name']) ? $row['sender_name'] : $cust_display_name;
			} else {
				$raw_s = !empty($row['sender_cs_name']) ? $row['sender_cs_name'] : (!empty($row['sender_name']) ? $row['sender_name'] : 'Petugas CS');
				$sender = ucwords(clean_snake_case($raw_s));
			}

			$raw_timeline[] = [
				'id' => (int)$row['id'],
				'direction' => $direction,
				'message' => $row['message'],
				'sender' => $sender,
				'sender_type' => $row['is_internal_note'] ? 'cs' : ($row['direction'] === 'in' ? 'customer' : 'cs_chat'),
				'created_at' => $row['created_at'],
				'metode_kirim' => ($row['direction'] === 'out' && !$row['is_internal_note']) ? 'wa_gateway_api' : '',
				'status_kirim' => isset($row['status']) ? $row['status'] : '',
				'source' => 'chat_history',
			];
		}

		// Legacy outgoing (broadcast_logs)
		foreach ($legacy_outgoing as $row) {
			$raw_timeline[] = [
				'id' => 0,
				'direction' => 'outgoing',
				'message' => isset($row['message']) ? $row['message'] : '',
				'sender' => !empty($row['sender']) ? ucwords(clean_snake_case($row['sender'])) : 'Petugas CS',
				'sender_type' => 'cs',
				'created_at' => $row['created_at'],
				'metode_kirim' => isset($row['metode_kirim']) ? $row['metode_kirim'] : '',
				'status_kirim' => isset($row['status_kirim']) ? $row['status_kirim'] : '',
				'source' => 'broadcast_logs',
			];
		}

		// Legacy notes
		foreach ($legacy_notes as $row) {
			$stype = isset($row['sender_type']) ? $row['sender_type'] : 'cs';
			$direction = 'note';
			if ($stype === 'customer') {
				$direction = 'incoming';
			} elseif ($stype === 'cs_chat') {
				$direction = 'outgoing';
			}

			$sender = isset($row['sender']) ? ucwords(clean_snake_case($row['sender'])) : 'Petugas CS';
			if ($direction === 'incoming') {
				$sender = $cust_display_name . ' (Balasan)';
			} elseif (empty($sender)) {
				$sender = 'Petugas CS';
			}

			$raw_timeline[] = [
				'id' => 0,
				'direction' => $direction,
				'message' => isset($row['message']) ? $row['message'] : '',
				'sender' => $sender,
				'sender_type' => $stype,
				'created_at' => $row['created_at'],
				'metode_kirim' => '',
				'status_kirim' => '',
				'source' => 'followup_notes',
			];
		}

		// Merge and deduplicate by direction + content + timestamp minute
		$timeline = [];
		$seen = [];

		foreach ($raw_timeline as $item) {
			$msg_clean = trim(isset($item['message']) ? $item['message'] : '');
			if (empty($msg_clean)) continue;

			// Filter out incoming echoes containing Fonnte signature
			if ($item['direction'] === 'incoming' && (stripos($msg_clean, 'Sent via fonnte.com') !== false || stripos($msg_clean, 'fonnte.com') !== false)) {
				continue;
			}

			$key = md5((isset($item['direction']) ? $item['direction'] : '') . '|' . $msg_clean . '|' . substr(isset($item['created_at']) ? $item['created_at'] : '', 0, 16));
			if (!isset($seen[$key])) {
				$seen[$key] = count($timeline);
				$timeline[] = $item;
			} else {
				// If duplicate has higher ID, update the ID so cursor tracking always uses the latest DB ID
				$idx = $seen[$key];
				if ((int)$item['id'] > (int)$timeline[$idx]['id']) {
					$timeline[$idx]['id'] = (int)$item['id'];
				}
			}
		}

		usort($timeline, function($a, $b) {
			return strtotime($a['created_at']) - strtotime($b['created_at']);
		});

		return $timeline;
	}

	/**
	 * Render WA template with variables (FB-05)
	 */
	public function render_template($template, $label)
	{
		if (empty($template) && is_object($label) && !empty($label->followup_category_id)) {
			$cat = $this->db->get_where('crm_followup_categories', ['id' => $label->followup_category_id])->row();
			if ($cat && !empty($cat->template_pesan_default)) {
				$template = $cat->template_pesan_default;
			}
		}

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

		$cust_nama = $label->customer_nama ?: '-';
		$no_pesanan = $label->no_pesanan ?: '-';
		$nomor_resi = $label->nomor_resi ?: '-';
		$sumber_penjualan = $label->order_source ?: '-';
		$tgl_kirim = $label->tanggal_pengiriman ? date('d/m/Y', strtotime($label->tanggal_pengiriman)) : '-';

		$vars = [
			'{{nama_customer}}' => $cust_nama,
			'{{nama}}' => $cust_nama,
			'{nama_customer}' => $cust_nama,
			'{nama}' => $cust_nama,
			'{{no_pesanan}}' => $no_pesanan,
			'{no_pesanan}' => $no_pesanan,
			'{{nomor_resi}}' => $nomor_resi,
			'{nomor_resi}' => $nomor_resi,
			'{{resi}}' => $nomor_resi,
			'{resi}' => $nomor_resi,
			'{{sumber_penjualan}}' => $sumber_penjualan,
			'{sumber_penjualan}' => $sumber_penjualan,
			'{{produk}}' => $produk,
			'{produk}' => $produk,
			'{{tanggal_kirim}}' => $tgl_kirim,
			'{tanggal_kirim}' => $tgl_kirim,
			'{{kurir}}' => $kurir,
			'{kurir}' => $kurir,
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
		return 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . rawurlencode($message);
	}

	/**
	 * Log broadcast (FB-06)
	 */
	public function log_broadcast($label_id, $pesan_final, $metode = 'wa_direct_link', $author = null)
	{
		if (empty($author)) {
			$author = function_exists('get_user_data') ? (get_user_data('full_name') ?: get_user_data('username')) : null;
			if (empty($author)) $author = 'system';
		}
		$this->db->insert('crm_broadcast_logs', [
			'followup_label_id' => $label_id,
			'dikirim_oleh' => $author,
			'isi_pesan_final' => $pesan_final,
			'waktu_kirim' => date('Y-m-d H:i:s'),
			'status_kirim' => 'Terkirim',
			'metode_kirim' => $metode,
		]);
		// Mark as broadcast sent (FB-10: prevent duplicate)
		$this->db->where('id', $label_id)->update('crm_transaction_followup_labels', [
			'is_broadcast_sent' => 1,
			'waktu_kirim_wa' => date('Y-m-d H:i:s'),
			'status_label' => 'Sudah Dikirim',
			'handled_by' => $author,
			'updated_at' => date('Y-m-d H:i:s'),
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
				'provider' => 'waha',
				'mode' => 'wa_gateway',
				'api_key' => 'metafora123',
				'api_url' => 'http://localhost:3000',
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
	 * Save WA LID (Linked Identity) to customer phone mapping in database
	 */
	public function save_wa_lid_map($lid, $phone, $pushname = null)
	{
		$lid = preg_replace('/@(lid|c\.us|s\.whatsapp\.net)$/', '', trim($lid));
		$phone = preg_replace('/@(lid|c\.us|s\.whatsapp\.net)$/', '', trim($phone));
		$phone = preg_replace('/[^0-9]/', '', $phone);

		if (empty($lid) || empty($phone) || strlen($phone) < 8) {
			return false;
		}

		$data = [
			'lid' => $lid,
			'phone' => $phone,
			'updated_at' => date('Y-m-d H:i:s')
		];
		if (!empty($pushname)) {
			$data['pushname'] = $pushname;
		}

		$existing = $this->db->get_where('crm_wa_lid_map', ['lid' => $lid])->row();
		if ($existing) {
			$this->db->where('lid', $lid)->update('crm_wa_lid_map', $data);
		} else {
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('crm_wa_lid_map', $data);
		}
		return true;
	}

	/**
	 * Resolve sender identifier to a canonical customer phone number.
	 * Modern WhatsApp uses LID (Linked Identity, e.g. 83889670369419@lid) instead of phone numbers.
	 * This resolver maps the LID to the customer's real phone number using:
	 * 1. crm_wa_lid_map table
	 * 2. crm_chat_history outgoing responses
	 * 3. WAHA contact API (/api/{session}/contacts/{lid})
	 * 4. WAHA chats API (/api/{session}/chats)
	 */
	public function resolve_waha_sender_phone($from, $payload = [], $session = 'default')
	{
		$is_group = (strpos($from, '@g.us') !== false);
		if ($is_group) {
			return ['phone' => $from, 'is_group' => true, 'name' => ''];
		}

		$is_lid = (strpos($from, '@lid') !== false);
		$lid_clean = preg_replace('/@(lid|c\.us|s\.whatsapp\.net)$/', '', trim($from));

		// If it's already a standard phone number (numeric and <= 15 digits)
		if (!$is_lid && is_numeric($lid_clean) && strlen($lid_clean) <= 15 && strlen($lid_clean) >= 8) {
			return ['phone' => $lid_clean, 'is_group' => false, 'name' => ''];
		}

		// 1. Check local crm_wa_lid_map table
		$mapped = $this->db->get_where('crm_wa_lid_map', ['lid' => $lid_clean])->row();
		if ($mapped && !empty($mapped->phone)) {
			return [
				'phone' => $mapped->phone,
				'is_group' => false,
				'name' => $mapped->pushname ?: ''
			];
		}

		// 2. Check crm_chat_history outgoing messages where fonnte_response recorded this LID
		$history = $this->db->query(
			"SELECT customer_phone FROM crm_chat_history WHERE direction = 'out' AND fonnte_response LIKE ? ORDER BY id DESC LIMIT 1",
			['%' . $lid_clean . '%']
		)->row();
		if ($history && !empty($history->customer_phone)) {
			$clean_ph = preg_replace('/[^0-9]/', '', $history->customer_phone);
			if (strlen($clean_ph) >= 8) {
				$this->save_wa_lid_map($lid_clean, $clean_ph);
				return ['phone' => $clean_ph, 'is_group' => false, 'name' => ''];
			}
		}

		// 3. Query WAHA Contact API
		$config = $this->get_wa_gateway_config();
		$api_url = rtrim($config->api_url ?: 'http://localhost:3000', '/');
		$api_key = trim($config->api_key ?: '');

		$sess_name = !empty($session) ? $session : 'default';
		$ch = curl_init($api_url . '/api/' . urlencode($sess_name) . '/contacts/' . urlencode($lid_clean . '@lid'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 4);
		if (!empty($api_key)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['x-api-key: ' . $api_key]);
		}
		$res = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($http_code == 200 && !empty($res)) {
			$c_data = json_decode($res, true);
			if (!empty($c_data['id'])) {
				$real_ph = preg_replace('/@(c\.us|lid|s\.whatsapp\.net)$/', '', $c_data['id']);
				$real_ph = preg_replace('/[^0-9]/', '', $real_ph);
				if (strlen($real_ph) >= 8) {
					$pushname = $c_data['pushname'] ?? ($c_data['name'] ?? '');
					$this->save_wa_lid_map($lid_clean, $real_ph, $pushname);
					return [
						'phone' => $real_ph,
						'is_group' => false,
						'name' => $pushname
					];
				}
			}
		}

		// 4. Query WAHA Chats API as fallback
		$ch = curl_init($api_url . '/api/' . urlencode($sess_name) . '/chats');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 4);
		if (!empty($api_key)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['x-api-key: ' . $api_key]);
		}
		$res_chats = curl_exec($ch);
		$http_code_chats = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($http_code_chats == 200 && !empty($res_chats)) {
			$chats = json_decode($res_chats, true);
			if (is_array($chats)) {
				foreach ($chats as $chat_item) {
					$chat_serialized = $chat_item['id']['_serialized'] ?? ($chat_item['id'] ?? '');
					if (strpos($chat_serialized, $lid_clean) !== false) {
						$chat_name = $chat_item['name'] ?? '';
						// If name looks like a phone number: +62 897-3994-407
						$clean_name_ph = preg_replace('/[^0-9]/', '', $chat_name);
						if (strlen($clean_name_ph) >= 8) {
							$this->save_wa_lid_map($lid_clean, $clean_name_ph);
							return ['phone' => $clean_name_ph, 'is_group' => false, 'name' => ''];
						}
					}
				}
			}
		}

		// 5. Fallback: return raw cleaned LID
		return ['phone' => $lid_clean, 'is_group' => false, 'name' => ''];
	}

	/**
	 * Download and save inbound media from WAHA webhook to local storage (uploads/crm_attachments/)
	 * Returns array with label ([Foto], [Video], [Dokumen], etc), public url, and file info
	 */
	public function save_inbound_waha_media($payload, $session = 'default')
	{
		if (empty($payload['hasMedia'])) {
			return null;
		}

		$config = $this->get_wa_gateway_config();
		$api_url = rtrim($config->api_url ?: 'http://localhost:3000', '/');
		$api_key = trim($config->api_key ?: '');

		$m_type = strtolower($payload['type'] ?? ($payload['_data']['type'] ?? ''));
		$mimetype = strtolower($payload['media']['mimetype'] ?? ($payload['_data']['mimetype'] ?? ''));
		$waha_url = trim($payload['media']['url'] ?? '');
		$filename = trim($payload['media']['filename'] ?? '');

		// Map type if not explicitly set
		if (empty($m_type)) {
			if (strpos($mimetype, 'image') !== false) {
				$m_type = 'image';
			} elseif (strpos($mimetype, 'video') !== false) {
				$m_type = 'video';
			} elseif (strpos($mimetype, 'audio') !== false || strpos($mimetype, 'ogg') !== false) {
				$m_type = 'audio';
			} elseif (strpos($mimetype, 'pdf') !== false) {
				$m_type = 'pdf';
			} else {
				$m_type = 'document';
			}
		}

		// Choose display label
		if (in_array($m_type, ['image', 'sticker'])) {
			$label = '[Foto]';
		} elseif ($m_type === 'video') {
			$label = '[Video]';
		} elseif (in_array($m_type, ['audio', 'ptt', 'voice'])) {
			$label = '[Pesan Suara]';
		} elseif ($m_type === 'pdf' || strpos($mimetype, 'pdf') !== false) {
			$label = '[Dokumen PDF]';
		} elseif (in_array($m_type, ['zip', 'rar', 'tar', 'gz'])) {
			$label = '[Dokumen Arsip]';
		} else {
			$label = '[Dokumen]';
		}

		// Determine file extension
		$ext = '';
		if (!empty($filename)) {
			$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		}
		if (empty($ext) && !empty($waha_url)) {
			$path = parse_url($waha_url, PHP_URL_PATH);
			$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
		}
		if (empty($ext) && !empty($mimetype)) {
			$clean_mime = trim(explode(';', $mimetype)[0]);
			$mime_map = [
				'image/jpeg' => 'jpg',
				'image/jpg'  => 'jpg',
				'image/png'  => 'png',
				'image/webp' => 'webp',
				'image/gif'  => 'gif',
				'video/mp4'  => 'mp4',
				'video/3gpp' => '3gp',
				'video/quicktime' => 'mov',
				'video/webm' => 'webm',
				'audio/ogg'  => 'ogg',
				'audio/mpeg' => 'mp3',
				'audio/mp3'  => 'mp3',
				'audio/mp4'  => 'm4a',
				'audio/m4a'  => 'm4a',
				'audio/wav'  => 'wav',
				'application/pdf' => 'pdf',
				'application/msword' => 'doc',
				'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
				'application/vnd.ms-excel' => 'xls',
				'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
				'application/zip' => 'zip',
				'application/x-rar-compressed' => 'rar',
			];
			$ext = $mime_map[$clean_mime] ?? '';
		}

		if (empty($ext)) {
			if ($m_type === 'image' || $m_type === 'sticker') $ext = 'jpg';
			elseif ($m_type === 'video') $ext = 'mp4';
			elseif ($m_type === 'audio' || $m_type === 'ptt') $ext = 'ogg';
			elseif ($m_type === 'pdf') $ext = 'pdf';
			else $ext = 'bin';
		}

		$upload_dir = FCPATH . 'uploads/crm_attachments/';
		if (!is_dir($upload_dir)) {
			@mkdir($upload_dir, 0777, true);
		}

		$new_filename = 'wa_in_' . date('Ymd_His') . '_' . substr(md5(uniqid(mt_rand(), true)), 0, 6) . '.' . $ext;
		$dest_path = $upload_dir . $new_filename;

		// 1. Download file directly from WAHA API
		$saved = false;
		if (!empty($waha_url)) {
			$fetch_url = $waha_url;
			if (strpos($fetch_url, 'http') !== 0) {
				$fetch_url = $api_url . '/' . ltrim($fetch_url, '/');
			} else {
				$parsed_waha = parse_url($waha_url);
				$parsed_cfg = parse_url($api_url);
				if (!empty($parsed_waha['path']) && !empty($parsed_cfg['host'])) {
					$cfg_port = !empty($parsed_cfg['port']) ? ':' . $parsed_cfg['port'] : '';
					$cfg_scheme = !empty($parsed_cfg['scheme']) ? $parsed_cfg['scheme'] : 'http';
					$fetch_url = $cfg_scheme . '://' . $parsed_cfg['host'] . $cfg_port . $parsed_waha['path'];
				}
			}

			$ch = curl_init($fetch_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			if (!empty($api_key)) {
				curl_setopt($ch, CURLOPT_HTTPHEADER, ['x-api-key: ' . $api_key]);
			}
			$content = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			if ($http_code >= 200 && $http_code < 300 && !empty($content)) {
				if (@file_put_contents($dest_path, $content)) {
					$saved = true;
				}
			}
		}

		// 2. Fallback: Base64 decode from _data.body
		if (!$saved && !empty($payload['_data']['body']) && is_string($payload['_data']['body'])) {
			$decoded = base64_decode($payload['_data']['body']);
			if (!empty($decoded) && strlen($decoded) > 50) {
				if (@file_put_contents($dest_path, $decoded)) {
					$saved = true;
				}
			}
		}

		if ($saved) {
			$public_url = base_url('uploads/crm_attachments/' . $new_filename);
			return [
				'label' => $label,
				'url' => $public_url,
				'local_path' => $dest_path,
				'filename' => $new_filename,
				'm_type' => $m_type,
			];
		}

		// Fallback if local saving failed: return remote URL
		if (!empty($waha_url)) {
			return [
				'label' => $label,
				'url' => $waha_url,
				'local_path' => null,
				'filename' => $filename,
				'm_type' => $m_type,
			];
		}

		return [
			'label' => $label,
			'url' => '',
			'local_path' => null,
			'filename' => '',
			'm_type' => $m_type,
		];
	}

	/**
	 * Send WhatsApp message directly via Gateway API (cURL)
	 */
	public function send_wa_via_api($phone, $message, $file_url = '')
	{
		$config = $this->get_wa_gateway_config();

		$phone = trim((string)$phone);
		// Normalize phone: 08xx -> 628xx (if not already a JID like group @g.us or @lid)
		$is_jid = (strpos($phone, '@') !== false);
		if (!$is_jid) {
			$digits = preg_replace('/[^0-9]/', '', $phone);
			if (substr($digits, 0, 1) === '0') {
				$phone = '62' . substr($digits, 1);
			} elseif (substr($digits, 0, 2) !== '62') {
				$phone = '62' . $digits;
			} else {
				$phone = $digits;
			}
		}

		$provider = strtolower($config->provider ?: 'waha');
		$api_key = trim($config->api_key ?: '');
		$api_url = trim($config->api_url ?: 'http://localhost:3000');
		$base_url = rtrim($api_url ?: 'http://localhost:3000', '/');

		if (empty($api_key) && in_array($provider, ['wablas', 'starsender'])) {
			return [
				'success' => false,
				'message' => 'API Key WhatsApp Gateway belum dikonfigurasi di sistem.',
			];
		}

		$ch = curl_init();
		$headers = [];
		$post_data = [];

		if ($provider === 'waha') {
			$headers[] = 'Content-Type: application/json';
			if (!empty($api_key)) {
				$headers[] = 'x-api-key: ' . $api_key;
			}
			$dest_chat_id = $is_jid ? $phone : ($phone . '@c.us');
			if (!empty($file_url)) {
				$filename = pathinfo(parse_url($file_url, PHP_URL_PATH), PATHINFO_BASENAME) ?: 'document.pdf';

				// Transform localhost / 127.0.0.1 / local virtualhost so Docker WAHA container can reach Apache
				$waha_file_url = $file_url;
				$parsed_url = parse_url($file_url);
				if (!empty($parsed_url['host']) && in_array(strtolower($parsed_url['host']), ['localhost', '127.0.0.1', 'ci3_metafora.test'])) {
					$waha_file_url = str_replace($parsed_url['host'], 'host.docker.internal', $file_url);
				}

				$payload = [
					'session' => 'default',
					'chatId' => $dest_chat_id,
					'file' => [
						'url' => $waha_file_url,
						'filename' => $filename
					],
					'caption' => !empty($message) ? $message : ''
				];
				$url = $base_url . '/api/sendFile';
			} else {
				$payload = [
					'session' => 'default',
					'chatId' => $dest_chat_id,
					'text' => $message
				];
				$url = $base_url . '/api/sendText';
			}
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
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
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 35);

		$response = curl_exec($ch);
		$err = curl_error($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($err) {
			$user_tip = '';
			if (strpos($err, 'Failed to connect') !== false || strpos($err, 'Connection refused') !== false || strpos($err, 'timed out') !== false) {
				$user_tip = " (Server WAHA di {$base_url} tidak dapat dihubungi. Pastikan service/container WAHA sudah running dan URL gateway benar)";
			}
			return [
				'success' => false,
				'message' => 'Gagal koneksi ke WAHA: ' . $err . $user_tip,
				'http_code' => $http_code
			];
		}

		$res_json = json_decode($response, true);
		$is_ok = ($http_code >= 200 && $http_code < 300);
		$err_msg = 'API Error (HTTP ' . $http_code . ')';

		if (is_array($res_json)) {
			if (isset($res_json['status'])) {
				if ($res_json['status'] === false || $res_json['status'] === 'false' || $res_json['status'] === 0) {
					$is_ok = false;
					$reason = !empty($res_json['reason']) ? $res_json['reason'] : (!empty($res_json['detail']) ? $res_json['detail'] : (!empty($res_json['message']) ? $res_json['message'] : 'Gagal terkirim dari WhatsApp Gateway'));
					$err_msg = 'Gateway Error: ' . (is_array($reason) ? implode(', ', $reason) : $reason);
				}
			} elseif (isset($res_json['error']) || isset($res_json['statusCode'])) {
				if ($http_code >= 400 || !empty($res_json['error'])) {
					$is_ok = false;
					$err_part = is_string($res_json['error'] ?? null) ? $res_json['error'] : '';
					$msg_part = '';
					if (!empty($res_json['message'])) {
						$msg_part = is_array($res_json['message']) ? implode(', ', $res_json['message']) : $res_json['message'];
					}
					$err_msg = 'WAHA Error: ' . trim($err_part . ($err_part && $msg_part ? ' - ' : '') . $msg_part);
					if (trim($err_msg) === 'WAHA Error:') {
						$err_msg = 'WAHA Error (HTTP ' . $http_code . ')';
					}
				}
			}
		}

		// Cache WAHA recipient LID mapping if present in API response
		if ($is_ok && $provider === 'waha' && is_array($res_json)) {
			$lid_cand = $res_json['id']['remote'] ?? ($res_json['to'] ?? ($res_json['_data']['id']['remote'] ?? ''));
			if (!empty($lid_cand) && strpos($lid_cand, '@lid') !== false) {
				$this->save_wa_lid_map($lid_cand, $phone);
			}
		}

		return [
			'success' => $is_ok,
			'message' => $is_ok ? 'Pesan WA berhasil dikirim via API' : $err_msg,
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
	 * Auto-sync label dates to match actual order dates & category days H+n
	 */
	public function sync_label_dates_if_needed()
	{
		// Sync sales_order dates
		$this->db->query("
			UPDATE crm_transaction_followup_labels tfl
			JOIN sales_order so ON tfl.order_table = 'sales_order' AND tfl.order_id = so.id
			JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
			SET 
			  tfl.tanggal_pengiriman = COALESCE(
			    CASE WHEN so.tanggal_kirim > '1000-01-01' THEN DATE(so.tanggal_kirim) ELSE NULL END,
			    CASE WHEN so.tanggal_so > '1000-01-01' THEN DATE(so.tanggal_so) ELSE NULL END,
			    CASE WHEN so.created_at > '1000-01-01' THEN DATE(so.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  ),
			  tfl.tanggal_label_muncul = DATE_ADD(COALESCE(
			    CASE WHEN so.tanggal_kirim > '1000-01-01' THEN DATE(so.tanggal_kirim) ELSE NULL END,
			    CASE WHEN so.tanggal_so > '1000-01-01' THEN DATE(so.tanggal_so) ELSE NULL END,
			    CASE WHEN so.created_at > '1000-01-01' THEN DATE(so.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  ), INTERVAL fc.jumlah_hari DAY)
			WHERE tfl.tanggal_label_muncul != DATE_ADD(COALESCE(
			    CASE WHEN so.tanggal_kirim > '1000-01-01' THEN DATE(so.tanggal_kirim) ELSE NULL END,
			    CASE WHEN so.tanggal_so > '1000-01-01' THEN DATE(so.tanggal_so) ELSE NULL END,
			    CASE WHEN so.created_at > '1000-01-01' THEN DATE(so.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  ), INTERVAL fc.jumlah_hari DAY)
			   OR tfl.tanggal_pengiriman != COALESCE(
			    CASE WHEN so.tanggal_kirim > '1000-01-01' THEN DATE(so.tanggal_kirim) ELSE NULL END,
			    CASE WHEN so.tanggal_so > '1000-01-01' THEN DATE(so.tanggal_so) ELSE NULL END,
			    CASE WHEN so.created_at > '1000-01-01' THEN DATE(so.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  )
		");

		// Sync penjualan_marketplace dates
		$this->db->query("
			UPDATE crm_transaction_followup_labels tfl
			JOIN penjualan_marketplace mp ON tfl.order_table = 'penjualan_marketplace' AND tfl.order_id = mp.id
			JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
			SET 
			  tfl.tanggal_pengiriman = COALESCE(
			    CASE WHEN mp.tanggal_so > '1000-01-01' THEN DATE(mp.tanggal_so) ELSE NULL END,
			    CASE WHEN mp.created_at > '1000-01-01' THEN DATE(mp.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  ),
			  tfl.tanggal_label_muncul = DATE_ADD(COALESCE(
			    CASE WHEN mp.tanggal_so > '1000-01-01' THEN DATE(mp.tanggal_so) ELSE NULL END,
			    CASE WHEN mp.created_at > '1000-01-01' THEN DATE(mp.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  ), INTERVAL fc.jumlah_hari DAY)
			WHERE tfl.tanggal_label_muncul != DATE_ADD(COALESCE(
			    CASE WHEN mp.tanggal_so > '1000-01-01' THEN DATE(mp.tanggal_so) ELSE NULL END,
			    CASE WHEN mp.created_at > '1000-01-01' THEN DATE(mp.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  ), INTERVAL fc.jumlah_hari DAY)
			   OR tfl.tanggal_pengiriman != COALESCE(
			    CASE WHEN mp.tanggal_so > '1000-01-01' THEN DATE(mp.tanggal_so) ELSE NULL END,
			    CASE WHEN mp.created_at > '1000-01-01' THEN DATE(mp.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  )
		");

		// Global safety sync for any remaining labels
		$this->db->query("
			UPDATE crm_transaction_followup_labels tfl
			JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
			SET tfl.tanggal_label_muncul = DATE_ADD(tfl.tanggal_pengiriman, INTERVAL fc.jumlah_hari DAY)
			WHERE tfl.tanggal_label_muncul != DATE_ADD(tfl.tanggal_pengiriman, INTERVAL fc.jumlah_hari DAY)
		");

		// Two-way synchronization of keterangan_bc between CRM labels and penjualan_marketplace
		// 1. Sync H+ milestone from mp to matching category label only (preserving uncompleted future milestones)
		$this->db->query("
			UPDATE crm_transaction_followup_labels tfl
			JOIN penjualan_marketplace mp ON (tfl.order_table = 'penjualan_marketplace' AND tfl.order_id = mp.id) OR (tfl.no_pesanan = mp.no_pesanan COLLATE utf8mb4_unicode_ci)
			JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
			SET tfl.keterangan_bc = mp.keterangan_bc
			WHERE (mp.keterangan_bc LIKE CONCAT('%(H+', fc.jumlah_hari, ')') OR mp.keterangan_bc = CONCAT('H+', fc.jumlah_hari))
			  AND (tfl.keterangan_bc IS NULL OR tfl.keterangan_bc = '')
		");

		// 3. Sync latest completed keterangan_bc from tfl to mp
		$this->db->query("
			UPDATE penjualan_marketplace mp
			JOIN (
				SELECT tfl.no_pesanan, tfl.keterangan_bc 
				FROM crm_transaction_followup_labels tfl
				JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
				WHERE tfl.keterangan_bc IS NOT NULL AND tfl.keterangan_bc != ''
				ORDER BY fc.jumlah_hari DESC
			) latest_tfl ON mp.no_pesanan = latest_tfl.no_pesanan COLLATE utf8mb4_unicode_ci
			SET mp.keterangan_bc = latest_tfl.keterangan_bc
			WHERE mp.keterangan_bc IS NULL OR mp.keterangan_bc = ''
		");

		// 4. Synchronize phone numbers from penjualan_marketplace to tfl if missing
		$this->db->query("
			UPDATE crm_transaction_followup_labels tfl
			JOIN penjualan_marketplace mp ON tfl.order_table = 'penjualan_marketplace' AND tfl.order_id = mp.id
			SET tfl.customer_phone = mp.no_telepon
			WHERE (tfl.customer_phone = '-' OR tfl.customer_phone = '' OR tfl.customer_phone IS NULL)
			  AND mp.no_telepon IS NOT NULL AND mp.no_telepon != '' AND mp.no_telepon != '-'
		");

		// 5. Synchronize phone numbers from sales_order / pelanggan to tfl if missing
		$this->db->query("
			UPDATE crm_transaction_followup_labels tfl
			JOIN sales_order so ON tfl.order_table = 'sales_order' AND tfl.order_id = so.id
			JOIN pelanggan p ON so.pelanggan_id = p.id
			SET tfl.customer_phone = COALESCE(NULLIF(NULLIF(p.telepon, '-'), ''), NULLIF(NULLIF(p.no_telp, '-'), ''), NULLIF(NULLIF(so.no_telepon, '-'), ''))
			WHERE (tfl.customer_phone = '-' OR tfl.customer_phone = '' OR tfl.customer_phone IS NULL)
			  AND (
			    (p.telepon IS NOT NULL AND p.telepon != '' AND p.telepon != '-') OR
			    (p.no_telp IS NOT NULL AND p.no_telp != '' AND p.no_telp != '-') OR
			    (so.no_telepon IS NOT NULL AND so.no_telepon != '' AND so.no_telepon != '-')
			  )
		");

		// 6. Synchronize phone numbers from pelanggan by customer_pelanggan_id if missing
		$this->db->query("
			UPDATE crm_transaction_followup_labels tfl
			JOIN pelanggan p ON tfl.customer_pelanggan_id = p.id
			SET tfl.customer_phone = COALESCE(NULLIF(NULLIF(p.telepon, '-'), ''), NULLIF(NULLIF(p.no_telp, '-'), ''))
			WHERE (tfl.customer_phone = '-' OR tfl.customer_phone = '' OR tfl.customer_phone IS NULL)
			  AND (
			    (p.telepon IS NOT NULL AND p.telepon != '' AND p.telepon != '-') OR
			    (p.no_telp IS NOT NULL AND p.no_telp != '' AND p.no_telp != '-')
			  )
		");
	}

	/**
	 * Update customer phone number across CRM labels, marketplace orders, and pelanggan
	 */
	public function update_customer_phone($label_id, $new_phone)
	{
		$digits = preg_replace('/[^0-9]/', '', (string)$new_phone);
		if (strlen($digits) >= 9) {
			if (substr($digits, 0, 2) === '62') {
				$digits = '0' . substr($digits, 2);
			} elseif (substr($digits, 0, 1) === '8') {
				$digits = '0' . $digits;
			}
			$clean_phone = $digits;
		} else {
			$clean_phone = trim((string)$new_phone);
		}

		$label = $this->db->get_where('crm_transaction_followup_labels', ['id' => $label_id])->row();
		if (!$label) return false;

		// 1. Update all followup labels for this order/customer
		if (!empty($label->no_pesanan)) {
			$this->db->where('no_pesanan', $label->no_pesanan)->update('crm_transaction_followup_labels', [
				'customer_phone' => $clean_phone,
				'updated_at'     => date('Y-m-d H:i:s')
			]);
		} else {
			$this->db->where('id', $label_id)->update('crm_transaction_followup_labels', [
				'customer_phone' => $clean_phone,
				'updated_at'     => date('Y-m-d H:i:s')
			]);
		}

		// 2. Update penjualan_marketplace if applicable
		if ($label->order_table === 'penjualan_marketplace' && !empty($label->order_id)) {
			$this->db->where('id', $label->order_id)->update('penjualan_marketplace', [
				'no_telepon' => $clean_phone,
				'updated_at' => date('Y-m-d H:i:s')
			]);
		} elseif (!empty($label->no_pesanan)) {
			$this->db->where('no_pesanan', $label->no_pesanan)->update('penjualan_marketplace', [
				'no_telepon' => $clean_phone,
				'updated_at' => date('Y-m-d H:i:s')
			]);
		}

		// 3. Update pelanggan record
		if (!empty($label->customer_pelanggan_id)) {
			$this->db->where('id', $label->customer_pelanggan_id)->update('pelanggan', [
				'telepon'    => $clean_phone,
				'no_telp'    => $clean_phone,
				'updated_at' => date('Y-m-d H:i:s')
			]);
		} elseif (!empty($label->customer_nama)) {
			$this->db->where('nama_pelanggan', $label->customer_nama)->update('pelanggan', [
				'telepon'    => $clean_phone,
				'no_telp'    => $clean_phone,
				'updated_at' => date('Y-m-d H:i:s')
			]);
		}

		return $clean_phone;
	}

	/**
	 * Generate follow-up labels for a single order instantly
	 */
	public function generate_labels_for_order($order_table, $order_id)
	{
		$categories = $this->get_categories(true);
		$generated = 0;

		if ($order_table === 'sales_order') {
			$so = $this->db->query("SELECT so.*, p.nama_pelanggan, p.telepon, p.no_telp 
				FROM sales_order so LEFT JOIN pelanggan p ON so.pelanggan_id = p.id 
				WHERE so.id = ?", [$order_id])->row();
			if (!$so || in_array($so->status, ['cancelled', 'dibatalkan'])) return 0;

			$ship_date = $so->tanggal_kirim ?: ($so->tanggal_so ?: substr($so->created_at, 0, 10));
			$phone = $so->no_telepon ?: ($so->telepon ?: ($so->no_telp ?: ''));
			$nama = $so->nama_penerima ?: ($so->nama_pelanggan ?: 'Customer');
			$so_src = strtolower($so->source ?: '');
			$so_no = strtolower(($so->no_pesanan ?: '') . ' ' . ($so->nomor_so ?: ''));
			$source = 'Toko';
			if (strpos($so_src, 'shopee') !== false || strpos($so_no, 'shp') !== false) $source = 'Shopee';
			elseif (strpos($so_src, 'tokopedia') !== false || strpos($so_no, 'tkp') !== false) $source = 'Tokopedia';
			elseif (strpos($so_src, 'tiktok') !== false || strpos($so_no, 'ttk') !== false) $source = 'TikTok Shop';

			foreach ($categories as $cat) {
				$exists = $this->db->get_where('crm_transaction_followup_labels', [
					'order_table' => 'sales_order',
					'order_id' => $so->id,
					'followup_category_id' => $cat->id
				])->num_rows();

				$target = date('Y-m-d', strtotime($ship_date . ' + ' . $cat->jumlah_hari . ' days'));
				if ($exists == 0) {
					$this->db->insert('crm_transaction_followup_labels', [
						'order_source' => $source,
						'order_id' => $so->id,
						'order_table' => 'sales_order',
						'customer_nama' => $nama,
						'customer_phone' => $phone,
						'customer_pelanggan_id' => $so->pelanggan_id,
						'no_pesanan' => $so->no_pesanan ?: $so->nomor_so,
						'nomor_resi' => $so->nomor_resi ?: '',
						'tanggal_pengiriman' => $ship_date,
						'followup_category_id' => $cat->id,
						'tanggal_label_muncul' => $target,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					]);
					$generated++;
				} else {
					$this->db->where([
						'order_table' => 'sales_order',
						'order_id' => $so->id,
						'followup_category_id' => $cat->id
					])->update('crm_transaction_followup_labels', [
						'order_source' => $source,
						'customer_nama' => $nama,
						'customer_phone' => $phone,
						'customer_pelanggan_id' => $so->pelanggan_id,
						'no_pesanan' => $so->no_pesanan ?: $so->nomor_so,
						'nomor_resi' => $so->nomor_resi ?: '',
						'tanggal_pengiriman' => $ship_date,
						'tanggal_label_muncul' => $target,
						'updated_at' => date('Y-m-d H:i:s'),
					]);
				}
			}
		} elseif ($order_table === 'penjualan_marketplace') {
			$mp = $this->db->query("SELECT mp.*, p.nama_pelanggan, p.telepon, p.no_telp 
				FROM penjualan_marketplace mp LEFT JOIN pelanggan p ON mp.pelanggan_id = p.id 
				WHERE mp.id = ?", [$order_id])->row();
			if (!$mp || in_array($mp->status, ['cancelled', 'dibatalkan', 'returned', 'pengembalian'])) return 0;

			$ship_date = $mp->tanggal_so ?: substr($mp->created_at, 0, 10);
			$phone = $mp->no_telepon ?: ($mp->telepon ?: ($mp->no_telp ?: ''));
			$nama = $mp->nama_penerima ?: ($mp->nama_pelanggan ?: ($mp->username_pembeli ?: 'Customer Marketplace'));
			$src = strtolower($mp->source ?: '');
			$no_p = strtolower(($mp->no_pesanan ?: '') . ' ' . ($mp->nomor_so ?: ''));
			$source = 'Shopee';
			if (strpos($src, 'tokopedia') !== false || strpos($no_p, 'tkp') !== false) $source = 'Tokopedia';
			elseif (strpos($src, 'tiktok') !== false || strpos($no_p, 'ttk') !== false) $source = 'TikTok Shop';
			elseif (strpos($src, 'shopee') !== false || strpos($no_p, 'shp') !== false) $source = 'Shopee';

			foreach ($categories as $cat) {
				$exists = $this->db->get_where('crm_transaction_followup_labels', [
					'order_table' => 'penjualan_marketplace',
					'order_id' => $mp->id,
					'followup_category_id' => $cat->id
				])->num_rows();

				$target = date('Y-m-d', strtotime($ship_date . ' + ' . $cat->jumlah_hari . ' days'));
				if ($exists == 0) {
					$this->db->insert('crm_transaction_followup_labels', [
						'order_source' => $source,
						'order_id' => $mp->id,
						'order_table' => 'penjualan_marketplace',
						'customer_nama' => $nama,
						'customer_phone' => $phone,
						'customer_pelanggan_id' => $mp->pelanggan_id,
						'no_pesanan' => $mp->no_pesanan ?: $mp->nomor_so,
						'nomor_resi' => $mp->nomor_resi ?: '',
						'tanggal_pengiriman' => $ship_date,
						'followup_category_id' => $cat->id,
						'tanggal_label_muncul' => $target,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					]);
					$generated++;
				} else {
					$this->db->where([
						'order_table' => 'penjualan_marketplace',
						'order_id' => $mp->id,
						'followup_category_id' => $cat->id
					])->update('crm_transaction_followup_labels', [
						'order_source' => $source,
						'customer_nama' => $nama,
						'customer_phone' => $phone,
						'customer_pelanggan_id' => $mp->pelanggan_id,
						'no_pesanan' => $mp->no_pesanan ?: $mp->nomor_so,
						'nomor_resi' => $mp->nomor_resi ?: '',
						'tanggal_pengiriman' => $ship_date,
						'tanggal_label_muncul' => $target,
						'updated_at' => date('Y-m-d H:i:s'),
					]);
				}
			}
		}

		return $generated;
	}

	/**
	 * CRON: Generate follow-up labels for new shipped orders (FB-01)
	 */
	public function generate_labels_for_new_orders()
	{
		$categories = $this->get_categories(true);
		$generated = 0;

		$existing_raw = $this->db->select('order_table, order_id, followup_category_id')
			->get('crm_transaction_followup_labels')->result_array();
		$existing_set = [];
		foreach ($existing_raw as $er) {
			$key = $er['order_table'] . '_' . $er['order_id'] . '_' . $er['followup_category_id'];
			$existing_set[$key] = true;
		}

		// Process sales_order (exclude synced marketplace orders to prevent duplicate followup labels)
		$so_rows = $this->db->query("SELECT so.*, p.nama_pelanggan, p.telepon, p.no_telp 
			FROM sales_order so LEFT JOIN pelanggan p ON so.pelanggan_id = p.id 
			WHERE so.status NOT IN ('cancelled','dibatalkan')
			  AND (so.source = 'excel_import' OR (so.source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (so.no_pesanan IS NULL OR so.no_pesanan = '' OR so.no_pesanan = so.nomor_so)))")->result();

		foreach ($so_rows as $so) {
			$ship_date = $so->tanggal_kirim ?: ($so->tanggal_so ?: substr($so->created_at, 0, 10));
			$phone = $so->no_telepon ?: ($so->telepon ?: ($so->no_telp ?: ''));
			$nama = $so->nama_penerima ?: ($so->nama_pelanggan ?: '-');
			$so_src = strtolower($so->source ?: '');
			$so_no = strtolower(($so->no_pesanan ?: '') . ' ' . ($so->nomor_so ?: ''));
			$source = 'Toko';
			if (strpos($so_src, 'shopee') !== false || strpos($so_no, 'shp') !== false) $source = 'Shopee';
			elseif (strpos($so_src, 'tokopedia') !== false || strpos($so_no, 'tkp') !== false) $source = 'Tokopedia';
			elseif (strpos($so_src, 'tiktok') !== false || strpos($so_no, 'ttk') !== false) $source = 'TikTok Shop';

			foreach ($categories as $cat) {
				$key = 'sales_order_' . $so->id . '_' . $cat->id;
				if (!isset($existing_set[$key])) {
					$target = date('Y-m-d', strtotime($ship_date . ' + ' . $cat->jumlah_hari . ' days'));
					$this->db->insert('crm_transaction_followup_labels', [
						'order_source' => $source,
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
					$existing_set[$key] = true;
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
			$no_p = strtolower($mp->no_pesanan ?: '');
			$source = 'Shopee';
			if (strpos($src, 'tokopedia') !== false || strpos($no_p, 'tkp') !== false) $source = 'Tokopedia';
			elseif (strpos($src, 'tiktok') !== false || strpos($no_p, 'ttk') !== false) $source = 'TikTok Shop';
			elseif (strpos($src, 'shopee') !== false || strpos($no_p, 'shp') !== false) $source = 'Shopee';

			foreach ($categories as $cat) {
				$key = 'penjualan_marketplace_' . $mp->id . '_' . $cat->id;
				if (!isset($existing_set[$key])) {
					$target = date('Y-m-d', strtotime($ship_date . ' + ' . $cat->jumlah_hari . ' days'));
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
					$existing_set[$key] = true;
					$generated++;
				}
			}
		}

		// Realtime sync resi, no_pesanan, tanggal_pengiriman, tanggal_label_muncul and order_source for existing labels
		$this->db->query("
			UPDATE crm_transaction_followup_labels tfl
			JOIN sales_order so ON tfl.order_table = 'sales_order' AND tfl.order_id = so.id
			JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
			SET 
			  tfl.nomor_resi = COALESCE(NULLIF(so.nomor_resi, ''), tfl.nomor_resi),
			  tfl.no_pesanan = COALESCE(NULLIF(so.no_pesanan, ''), NULLIF(so.nomor_so, ''), tfl.no_pesanan),
			  tfl.customer_nama = COALESCE(NULLIF(so.nama_penerima, ''), tfl.customer_nama),
			  tfl.customer_phone = COALESCE(NULLIF(so.no_telepon, ''), tfl.customer_phone),
			  tfl.tanggal_pengiriman = COALESCE(
			    CASE WHEN so.tanggal_kirim > '1000-01-01' THEN DATE(so.tanggal_kirim) ELSE NULL END,
			    CASE WHEN so.tanggal_so > '1000-01-01' THEN DATE(so.tanggal_so) ELSE NULL END,
			    CASE WHEN so.created_at > '1000-01-01' THEN DATE(so.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  ),
			  tfl.tanggal_label_muncul = DATE_ADD(COALESCE(
			    CASE WHEN so.tanggal_kirim > '1000-01-01' THEN DATE(so.tanggal_kirim) ELSE NULL END,
			    CASE WHEN so.tanggal_so > '1000-01-01' THEN DATE(so.tanggal_so) ELSE NULL END,
			    CASE WHEN so.created_at > '1000-01-01' THEN DATE(so.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  ), INTERVAL fc.jumlah_hari DAY),
			  tfl.order_source = CASE 
			    WHEN LOWER(so.source) LIKE '%shopee%' OR so.no_pesanan LIKE '%SHP%' OR so.nomor_so LIKE '%SHP%' THEN 'Shopee'
			    WHEN LOWER(so.source) LIKE '%tokopedia%' OR so.no_pesanan LIKE '%TKP%' OR so.nomor_so LIKE '%TKP%' THEN 'Tokopedia'
			    WHEN LOWER(so.source) LIKE '%tiktok%' OR so.no_pesanan LIKE '%TTK%' OR so.nomor_so LIKE '%TTK%' THEN 'TikTok Shop'
			    ELSE 'Toko'
			  END
		");

		$this->db->query("
			UPDATE crm_transaction_followup_labels tfl
			JOIN penjualan_marketplace mp ON tfl.order_table = 'penjualan_marketplace' AND tfl.order_id = mp.id
			JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
			SET 
			  tfl.nomor_resi = COALESCE(NULLIF(mp.nomor_resi, ''), tfl.nomor_resi),
			  tfl.no_pesanan = COALESCE(NULLIF(mp.no_pesanan, ''), NULLIF(mp.nomor_so, ''), tfl.no_pesanan),
			  tfl.customer_nama = COALESCE(NULLIF(mp.nama_penerima, ''), tfl.customer_nama),
			  tfl.customer_phone = COALESCE(NULLIF(mp.no_telepon, ''), tfl.customer_phone),
			  tfl.tanggal_pengiriman = COALESCE(
			    CASE WHEN mp.tanggal_so > '1000-01-01' THEN DATE(mp.tanggal_so) ELSE NULL END,
			    CASE WHEN mp.created_at > '1000-01-01' THEN DATE(mp.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  ),
			  tfl.tanggal_label_muncul = DATE_ADD(COALESCE(
			    CASE WHEN mp.tanggal_so > '1000-01-01' THEN DATE(mp.tanggal_so) ELSE NULL END,
			    CASE WHEN mp.created_at > '1000-01-01' THEN DATE(mp.created_at) ELSE NULL END,
			    tfl.tanggal_pengiriman
			  ), INTERVAL fc.jumlah_hari DAY),
			  tfl.order_source = CASE 
			    WHEN LOWER(mp.source) LIKE '%tokopedia%' OR LOWER(mp.no_pesanan) LIKE '%tkp%' THEN 'Tokopedia'
			    WHEN LOWER(mp.source) LIKE '%tiktok%' OR LOWER(mp.no_pesanan) LIKE '%ttk%' THEN 'TikTok Shop'
			    WHEN LOWER(mp.source) LIKE '%shopee%' OR LOWER(mp.no_pesanan) LIKE '%shp%' THEN 'Shopee'
			    ELSE 'Shopee'
			  END
		");

		// Global safety sync for any remaining custom/manual labels
		$this->db->query("
			UPDATE crm_transaction_followup_labels tfl
			JOIN crm_followup_categories fc ON tfl.followup_category_id = fc.id
			SET tfl.tanggal_label_muncul = DATE_ADD(tfl.tanggal_pengiriman, INTERVAL fc.jumlah_hari DAY)
		");

		return $generated;
	}

	/**
	 * Get journal stats for badges
	 */
	public function get_journal_stats()
	{
		$today = date('Y-m-d');
		$row = $this->db->query("
			SELECT 
				SUM(CASE WHEN status_label = 'Pending' AND tanggal_label_muncul <= ? THEN 1 ELSE 0 END) AS total_pending,
				SUM(CASE WHEN status_label = 'Pending' AND tanggal_label_muncul < ? THEN 1 ELSE 0 END) AS overdue,
				SUM(CASE WHEN status_label = 'Pending' AND tanggal_label_muncul = ? THEN 1 ELSE 0 END) AS today
			FROM crm_transaction_followup_labels
		", [$today, $today, $today])->row();

		return [
			'total_pending' => $row ? (int)$row->total_pending : 0,
			'overdue' => $row ? (int)$row->overdue : 0,
			'today' => $row ? (int)$row->today : 0,
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

	/**
	 * Get purchased items and order metadata for follow-up detail
	 * Supports sales_order (Toko/POS/Import) and penjualan_marketplace (Shopee/Tokopedia/TikTok)
	 * With fallback search by no_pesanan / nomor_so
	 */
	public function get_order_purchased_items($label)
	{
		if (!$label) return ['items' => [], 'order_meta' => null];

		$items = [];
		$order_data = null;
		$order_table = !empty($label->order_table) ? $label->order_table : '';
		$order_id = !empty($label->order_id) ? (int)$label->order_id : 0;
		$no_pesanan = !empty($label->no_pesanan) ? trim($label->no_pesanan) : '';

		if ($order_table === 'sales_order' && $order_id > 0) {
			$order_data = $this->db->where('id', $order_id)->get('sales_order')->row_array();
			$items = $this->db->select('soi.*, p.nama_produk, p.kode_produk, p.gambar')
				->from('sales_order_item soi')
				->join('produk p', 'soi.produk_id = p.id', 'left')
				->where('soi.so_id', $order_id)
				->get()->result_array();
		} elseif ($order_table === 'penjualan_marketplace' && $order_id > 0) {
			$order_data = $this->db->where('id', $order_id)->get('penjualan_marketplace')->row_array();
			$items = $this->db->select('pmi.*, p.nama_produk, p.kode_produk, p.gambar')
				->from('penjualan_marketplace_item pmi')
				->join('produk p', 'pmi.produk_id = p.id', 'left')
				->where('pmi.penjualan_marketplace_id', $order_id)
				->get()->result_array();
		}

		// Fallback lookup if empty and no_pesanan is present
		if (empty($items) && !empty($no_pesanan) && $no_pesanan !== '-') {
			$so = $this->db->group_start()
				->where('no_pesanan', $no_pesanan)
				->or_where('nomor_so', $no_pesanan)
				->group_end()
				->get('sales_order')->row_array();
			if ($so) {
				$order_data = $so;
				$order_table = 'sales_order';
				$items = $this->db->select('soi.*, p.nama_produk, p.kode_produk, p.gambar')
					->from('sales_order_item soi')
					->join('produk p', 'soi.produk_id = p.id', 'left')
					->where('soi.so_id', $so['id'])
					->get()->result_array();
			} else {
				$pm = $this->db->group_start()
					->where('no_pesanan', $no_pesanan)
					->or_where('nomor_so', $no_pesanan)
					->group_end()
					->get('penjualan_marketplace')->row_array();
				if ($pm) {
					$order_data = $pm;
					$order_table = 'penjualan_marketplace';
					$items = $this->db->select('pmi.*, p.nama_produk, p.kode_produk, p.gambar')
						->from('penjualan_marketplace_item pmi')
						->join('produk p', 'pmi.produk_id = p.id', 'left')
						->where('pmi.penjualan_marketplace_id', $pm['id'])
						->get()->result_array();
				}
			}
		}

		// Fallback: If still no items, but order_data has marketplace product info
		if (empty($items) && !empty($order_data) && !empty($order_data['nama_produk_marketplace'])) {
			$items[] = [
				'nama_produk' => $order_data['nama_produk_marketplace'],
				'kode_produk' => !empty($order_data['nomor_referensi_sku']) ? $order_data['nomor_referensi_sku'] : (!empty($order_data['sku_induk']) ? $order_data['sku_induk'] : '-'),
				'qty' => 1,
				'satuan' => 'pcs',
				'harga_satuan' => !empty($order_data['harga_setelah_diskon']) ? $order_data['harga_setelah_diskon'] : (!empty($order_data['subtotal']) ? $order_data['subtotal'] : $order_data['total']),
				'subtotal' => !empty($order_data['subtotal']) ? $order_data['subtotal'] : $order_data['total'],
				'catatan' => !empty($order_data['nama_variasi']) ? 'Variasi: ' . $order_data['nama_variasi'] : '',
				'gambar' => null
			];
		}

		$formatted_items = [];
		$total_qty = 0;
		foreach ($items as $it) {
			$qty_num = isset($it['qty']) ? (float)$it['qty'] : 1;
			$total_qty += $qty_num;
			$qty_str = (floor($qty_num) == $qty_num) ? number_format($qty_num, 0, ',', '.') : number_format($qty_num, 2, ',', '.');
			$satuan = !empty($it['satuan']) ? trim($it['satuan']) : 'pcs';

			$nama = '';
			if ($order_table === 'penjualan_marketplace') {
				if (!empty($it['catatan']) && strlen(trim($it['catatan'])) > 3) {
					$nama = trim($it['catatan']);
				} elseif (!empty($it['nama_produk'])) {
					$nama = trim($it['nama_produk']);
				} elseif (!empty($order_data['nama_produk_marketplace'])) {
					$nama = trim($order_data['nama_produk_marketplace']);
				} else {
					$nama = 'Produk Pesanan';
				}
			} else {
				if (!empty($it['nama_produk'])) {
					$nama = trim($it['nama_produk']);
				} elseif (!empty($it['catatan'])) {
					$nama = trim($it['catatan']);
				} else {
					$nama = 'Produk Pesanan';
				}
			}

			$kode = !empty($it['kode_produk']) ? trim($it['kode_produk']) : (!empty($order_data['nomor_referensi_sku']) ? trim($order_data['nomor_referensi_sku']) : '-');
			$harga = isset($it['harga_satuan']) ? (float)$it['harga_satuan'] : 0;
			$subtotal = isset($it['subtotal']) ? (float)$it['subtotal'] : ($harga * $qty_num);

			$img_url = null;
			if (!empty($it['gambar'])) {
				$img_path = 'uploads/produk/' . $it['gambar'];
				if (file_exists(FCPATH . $img_path)) {
					$img_url = base_url($img_path);
				}
			}

			$formatted_items[] = [
				'nama_produk' => $nama,
				'kode_produk' => $kode,
				'qty' => $qty_num,
				'qty_formatted' => $qty_str,
				'satuan' => $satuan,
				'harga_satuan' => $harga,
				'harga_satuan_formatted' => 'Rp ' . number_format($harga, 0, ',', '.'),
				'subtotal' => $subtotal,
				'subtotal_formatted' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
				'catatan' => !empty($it['catatan']) ? $it['catatan'] : '',
				'gambar_url' => $img_url
			];
		}

		$order_meta = [
			'order_table' => $order_table,
			'order_id' => $order_id,
			'order_total' => $order_data ? (float)$order_data['total'] : null,
			'order_total_formatted' => $order_data ? ('Rp ' . number_format((float)$order_data['total'], 0, ',', '.')) : null,
			'subtotal_formatted' => ($order_data && isset($order_data['subtotal'])) ? ('Rp ' . number_format((float)$order_data['subtotal'], 0, ',', '.')) : null,
			'kurir' => ($order_data && !empty($order_data['kurir_ekspedisi'])) ? $order_data['kurir_ekspedisi'] : null,
			'resi' => ($order_data && !empty($order_data['nomor_resi'])) ? $order_data['nomor_resi'] : null,
			'opsi_pengiriman' => ($order_data && !empty($order_data['opsi_pengiriman'])) ? $order_data['opsi_pengiriman'] : null,
			'total_items_count' => count($formatted_items),
			'total_qty' => $total_qty
		];

		return [
			'items' => $formatted_items,
			'order_meta' => $order_meta
		];
	}

	// ===== DASHBOARD CRM ANALYTICS (Fase 5) =====

	public function get_dashboard_kpis()
	{
		$today = date('Y-m-d');
		
		// Total customers
		$total_cust = $this->get_query_count("SELECT COUNT(DISTINCT customer_phone) as cnt FROM crm_transaction_followup_labels WHERE customer_phone IS NOT NULL AND customer_phone != ''");
		
		// Total spend
		$so_spend = $this->get_query_sum("SELECT COALESCE(SUM(total),0) as t FROM sales_order WHERE (source = 'excel_import' OR (source NOT IN ('shopee', 'tokopedia', 'tiktok', 'tiktokshop', 'lazada', 'marketplace') AND (no_pesanan IS NULL OR no_pesanan = '' OR no_pesanan = nomor_so)))");
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
				AND id != ? LIMIT 1", [$phone, "%" . $phone . "%", $start_date, $end_date, $lbl->order_id])->row();

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
			$df_esc = $this->db->escape_str($filters['date_from']);
			$where_label .= " AND tfl.updated_at >= '" . $df_esc . " 00:00:00'";
			$where_bc .= " AND bl.waktu_kirim >= '" . $df_esc . " 00:00:00'";
			$where_note .= " AND fn.created_at >= '" . $df_esc . " 00:00:00'";
		}
		if (!empty($filters['date_to'])) {
			$dt_esc = $this->db->escape_str($filters['date_to']);
			$where_label .= " AND tfl.updated_at <= '" . $dt_esc . " 23:59:59'";
			$where_bc .= " AND bl.waktu_kirim <= '" . $dt_esc . " 23:59:59'";
			$where_note .= " AND fn.created_at <= '" . $dt_esc . " 23:59:59'";
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
