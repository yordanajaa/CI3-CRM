<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
	public function get_rfm_percentile_thresholds($product_filter = '')
	{
		static $cached_thresholds = [];
		$cache_key = md5((string)$product_filter);
		if (isset($cached_thresholds[$cache_key])) {
			return $cached_thresholds[$cache_key];
		}

		if (!empty($product_filter)) {
			$p_esc = $this->db->escape_like_str($product_filter);
			$sql = "
				SELECT 
					c_data.no_telepon,
					DATEDIFF(CURRENT_DATE(), MAX(c_data.last_date)) as days_since_last,
					COUNT(DISTINCT c_data.order_id) as total_orders,
					SUM(c_data.subtotal) as total_spend
				FROM (
					SELECT 
						so.no_telepon, 
						so.tanggal_so as last_date, 
						CONCAT('so_', so.id) as order_id, 
						soi.subtotal 
					FROM sales_order_item soi
					JOIN sales_order so ON soi.so_id = so.id
					LEFT JOIN produk p ON soi.produk_id = p.id
					WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
					AND (p.nama_produk LIKE '%{$p_esc}%' OR soi.catatan LIKE '%{$p_esc}%')

					UNION ALL

					SELECT 
						pm.no_telepon, 
						pm.tanggal_so as last_date, 
						CONCAT('pm_', pm.id) as order_id, 
						pmi.subtotal 
					FROM penjualan_marketplace_item pmi
					JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
					LEFT JOIN produk p ON pmi.produk_id = p.id
					WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
					AND (p.nama_produk LIKE '%{$p_esc}%' OR pmi.catatan LIKE '%{$p_esc}%')
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
					SELECT no_telepon, tanggal_so as last_date, CONCAT('so_', id) as order_id, total 
					FROM sales_order 
					WHERE no_telepon IS NOT NULL AND no_telepon != ''
					
					UNION ALL
					
					SELECT no_telepon, tanggal_so as last_date, CONCAT('pm_', id) as order_id, total 
					FROM penjualan_marketplace 
					WHERE no_telepon IS NOT NULL AND no_telepon != ''
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

		$cached_thresholds = [
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

		return $cached_thresholds;
	}

	/**
	 * Calculate RFM Score and Segment for a customer using percentile quantiles (20%, 40%, 60%, 80%)
	 */
	public function calculate_rfm($last_order_date = null, $total_orders = 0, $total_spend = 0.0, $thresholds = null)
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
				$days_since_last = (int)floor((time() - $ts_last) / 86400);
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

		$rfm_code = "{$r_score}{$f_score}{$m_score}";

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
			'rfm_display' => "{$r_score}-{$f_score}-{$m_score}",
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
	public function get_customers($filter = '', $limit = 25, $offset = 0, $rfm_segment_filter = '', $product_filter = '', $period_filter = '')
	{
		$thresholds = $this->get_rfm_percentile_thresholds($product_filter, $period_filter);

		if (!empty($product_filter)) {
			$p_esc = $this->db->escape_like_str($product_filter);
			$sql = "SELECT 
				phone as customer_phone,
				COALESCE(NULLIF(MAX(nama), ''), 'Customer') as customer_nama,
				COUNT(DISTINCT order_id) as total_orders,
				SUM(total) as total_spend,
				MAX(tanggal) as last_order_date,
				GROUP_CONCAT(DISTINCT source ORDER BY source SEPARATOR ', ') as sumber_penjualan
			FROM (
				SELECT 
					CAST(so.no_telepon AS CHAR) COLLATE utf8mb4_unicode_ci as phone, 
					CAST(so.nama_penerima AS CHAR) COLLATE utf8mb4_unicode_ci as nama, 
					CAST(CONCAT('so_', so.id) AS CHAR) COLLATE utf8mb4_unicode_ci as order_id, 
					soi.subtotal as total, 
					CAST(so.tanggal_so AS DATETIME) as tanggal, 
					'Toko' COLLATE utf8mb4_unicode_ci as source 
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND so.tanggal_so IS NOT NULL 
				  AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND so.tanggal_so > '1970-01-01'
				  AND (p.nama_produk LIKE '%{$p_esc}%' OR soi.catatan LIKE '%{$p_esc}%')

				UNION ALL

				SELECT 
					CAST(pm.no_telepon AS CHAR) COLLATE utf8mb4_unicode_ci as phone, 
					CAST(pm.nama_penerima AS CHAR) COLLATE utf8mb4_unicode_ci as nama, 
					CAST(CONCAT('pm_', pm.id) AS CHAR) COLLATE utf8mb4_unicode_ci as order_id, 
					pmi.subtotal as total, 
					CAST(pm.tanggal_so AS DATETIME) as tanggal, 
					CAST(COALESCE(
						lbl.order_source,
						CASE 
							WHEN LOWER(pm.source) LIKE '%tokopedia%' THEN 'Tokopedia'
							WHEN LOWER(pm.source) LIKE '%tiktok%' THEN 'TikTok Shop'
							WHEN LOWER(pm.source) LIKE '%shopee%' THEN 'Shopee'
							WHEN LOWER(pm.no_pesanan) LIKE '%shp%' THEN 'Shopee'
							WHEN LOWER(pm.no_pesanan) LIKE '%tkp%' THEN 'Tokopedia'
							WHEN LOWER(pm.no_pesanan) LIKE '%ttk%' THEN 'TikTok Shop'
							ELSE 'Shopee'
						END
					) AS CHAR) COLLATE utf8mb4_unicode_ci as source 
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p ON pmi.produk_id = p.id
				LEFT JOIN crm_transaction_followup_labels lbl ON lbl.order_id = pm.id AND lbl.order_table = 'penjualan_marketplace'
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL 
				  AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND pm.tanggal_so > '1970-01-01'
				  AND (p.nama_produk LIKE '%{$p_esc}%' OR pmi.catatan LIKE '%{$p_esc}%')
			) u";
		} else {
			$sql = "SELECT 
				phone as customer_phone,
				COALESCE(NULLIF(MAX(nama), ''), 'Customer') as customer_nama,
				COUNT(DISTINCT order_id) as total_orders,
				SUM(total) as total_spend,
				MAX(tanggal) as last_order_date,
				GROUP_CONCAT(DISTINCT source ORDER BY source SEPARATOR ', ') as sumber_penjualan
			FROM (
				SELECT 
					CAST(so.no_telepon AS CHAR) COLLATE utf8mb4_unicode_ci as phone, 
					CAST(so.nama_penerima AS CHAR) COLLATE utf8mb4_unicode_ci as nama, 
					CAST(CONCAT('so_', so.id) AS CHAR) COLLATE utf8mb4_unicode_ci as order_id, 
					soi.subtotal as total, 
					CAST(so.tanggal_so AS DATETIME) as tanggal, 
					'Toko' COLLATE utf8mb4_unicode_ci as source 
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND so.tanggal_so IS NOT NULL 
				  AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND so.tanggal_so > '1970-01-01'

				UNION ALL

				SELECT 
					CAST(pm.no_telepon AS CHAR) COLLATE utf8mb4_unicode_ci as phone, 
					CAST(pm.nama_penerima AS CHAR) COLLATE utf8mb4_unicode_ci as nama, 
					CAST(CONCAT('pm_', pm.id) AS CHAR) COLLATE utf8mb4_unicode_ci as order_id, 
					pmi.subtotal as total, 
					CAST(pm.tanggal_so AS DATETIME) as tanggal, 
					CAST(COALESCE(
						lbl.order_source,
						CASE 
							WHEN LOWER(pm.source) LIKE '%tokopedia%' THEN 'Tokopedia'
							WHEN LOWER(pm.source) LIKE '%tiktok%' THEN 'TikTok Shop'
							WHEN LOWER(pm.source) LIKE '%shopee%' THEN 'Shopee'
							WHEN LOWER(pm.no_pesanan) LIKE '%shp%' THEN 'Shopee'
							WHEN LOWER(pm.no_pesanan) LIKE '%tkp%' THEN 'Tokopedia'
							WHEN LOWER(pm.no_pesanan) LIKE '%ttk%' THEN 'TikTok Shop'
							ELSE 'Shopee'
						END
					) AS CHAR) COLLATE utf8mb4_unicode_ci as source 
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN crm_transaction_followup_labels lbl ON lbl.order_id = pm.id AND lbl.order_table = 'penjualan_marketplace'
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL 
				  AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND pm.tanggal_so > '1970-01-01'
			) u";
		}

		$where_conditions = [];
		if (!empty($filter)) {
			$f_esc = $this->db->escape_like_str($filter);
			$where_conditions[] = "(nama LIKE '%{$f_esc}%' OR phone LIKE '%{$f_esc}%')";
		}
		if (!empty($period_filter)) {
			$period_esc = $this->db->escape_str($period_filter);
			$where_conditions[] = "DATE_FORMAT(tanggal, '%Y-%m') = '{$period_esc}'";
		}
		if (!empty($where_conditions)) {
			$sql .= " WHERE " . implode(" AND ", $where_conditions);
		}

		$sql .= " GROUP BY phone ORDER BY last_order_date DESC";
		
		$all_rows = $this->db->query($sql)->result();

		// Enhance each row with RFM calculation
		$enhanced_rows = [];
		$total_orders_sum = 0;
		$total_spend_sum = 0;
		foreach ($all_rows as $r) {
			$r->total_orders = (int)$r->total_orders;
			$r->total_spend = (float)$r->total_spend;

			$r->rfm = $this->calculate_rfm($r->last_order_date, $r->total_orders, $r->total_spend, $thresholds);

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
	public function get_rfm_dashboard_distribution($product_filter = '', $period_filter = '')
	{
		$result = $this->get_customers('', 10000, 0, '', $product_filter, $period_filter);
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
			return "{$column} = '{$phone_esc}'";
		}
		
		$raw_tail = strlen($clean) >= 9 ? substr($clean, -9) : $clean;
		$zero_format = '0' . (substr($clean, 0, 2) === '62' ? substr($clean, 2) : (substr($clean, 0, 1) === '0' ? substr($clean, 1) : $clean));
		$sixty_format = '62' . (substr($clean, 0, 2) === '62' ? substr($clean, 2) : (substr($clean, 0, 1) === '0' ? substr($clean, 1) : $clean));
		
		$zero_esc = $this->db->escape_str($zero_format);
		$sixty_esc = $this->db->escape_str($sixty_format);
		$tail_esc = $this->db->escape_str($raw_tail);

		return "({$column} = '{$phone_esc}' OR {$column} = '{$zero_esc}' OR {$column} = '{$sixty_esc}' OR (LENGTH({$column}) >= 9 AND RIGHT({$column}, 9) = '{$tail_esc}'))";
	}

	/**
	 * Get customer summary stats (FA-04)
	 */
	public function get_customer_summary($phone, $product_filter = '')
	{
		$where_so = $this->get_phone_where_clause('so.no_telepon', $phone);
		$where_pm = $this->get_phone_where_clause('pm.no_telepon', $phone);
		$where_lbl = $this->get_phone_where_clause('customer_phone', $phone);

		// Product filter: JOIN to item tables and filter by product name
		$so_join = '';
		$so_product_where = '';
		$pm_join = '';
		$pm_product_where = '';
		if (!empty($product_filter)) {
			$pf = $this->db->escape($product_filter);
			$so_join = "INNER JOIN sales_order_item soi ON soi.so_id = so.id LEFT JOIN produk p ON soi.produk_id = p.id";
			$so_product_where = " AND (p.nama_produk = {$pf} OR soi.catatan = {$pf})";
			$pm_join = "INNER JOIN penjualan_marketplace_item pmi ON pmi.penjualan_marketplace_id = pm.id LEFT JOIN produk p2 ON pmi.produk_id = p2.id";
			$pm_product_where = " AND (p2.nama_produk = {$pf} OR pmi.catatan = {$pf} OR pm.nama_produk_marketplace = {$pf})";

			// Get total spend from SO item subtotal for this product
			$so_spend = $this->get_query_sum("SELECT COALESCE(SUM(soi.subtotal),0) as t FROM sales_order so {$so_join} WHERE {$where_so}{$so_product_where}");
			
			// Get total spend from marketplace item subtotal for this product
			$mp_spend = $this->get_query_sum("SELECT COALESCE(SUM(pmi.subtotal),0) as t FROM penjualan_marketplace pm {$pm_join} WHERE {$where_pm}{$pm_product_where}");
		} else {
			// Get overall total spend across all products
			$so_spend = $this->get_query_sum("SELECT COALESCE(SUM(so.total),0) as t FROM sales_order so WHERE {$where_so}");
			$mp_spend = $this->get_query_sum("SELECT COALESCE(SUM(pm.total),0) as t FROM penjualan_marketplace pm WHERE {$where_pm}");
		}

		// Get order counts
		$so_count = $this->get_query_count("SELECT COUNT(DISTINCT so.id) as cnt FROM sales_order so {$so_join} WHERE {$where_so}{$so_product_where}");
		$mp_count = $this->get_query_count("SELECT COUNT(DISTINCT pm.id) as cnt FROM penjualan_marketplace pm {$pm_join} WHERE {$where_pm}{$pm_product_where}");

		// Get dates & names
		$dates_so = $this->db->query("SELECT MIN(so.tanggal_so) as first_order, MAX(so.tanggal_so) as last_order, MAX(so.nama_penerima) as nama FROM sales_order so {$so_join} WHERE {$where_so}{$so_product_where}")->row();
		$dates_pm = $this->db->query("SELECT MIN(pm.tanggal_so) as first_order, MAX(pm.tanggal_so) as last_order, MAX(pm.nama_penerima) as nama, GROUP_CONCAT(DISTINCT COALESCE(lbl.order_source, CASE WHEN LOWER(pm.source) LIKE '%tokopedia%' THEN 'Tokopedia' WHEN LOWER(pm.source) LIKE '%tiktok%' THEN 'TikTok Shop' WHEN LOWER(pm.source) LIKE '%shopee%' THEN 'Shopee' WHEN LOWER(pm.no_pesanan) LIKE '%shp%' THEN 'Shopee' WHEN LOWER(pm.no_pesanan) LIKE '%tkp%' THEN 'Tokopedia' WHEN LOWER(pm.no_pesanan) LIKE '%ttk%' THEN 'TikTok Shop' ELSE 'Shopee' END) SEPARATOR ', ') as sources FROM penjualan_marketplace pm {$pm_join} LEFT JOIN crm_transaction_followup_labels lbl ON lbl.order_id = pm.id AND lbl.order_table = 'penjualan_marketplace' WHERE {$where_pm}{$pm_product_where}")->row();

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
		$lbl_sources = $this->db->query("SELECT GROUP_CONCAT(DISTINCT order_source SEPARATOR ', ') as sources FROM crm_transaction_followup_labels WHERE {$where_lbl}")->row();
		if ($lbl_sources && !empty($lbl_sources->sources)) {
			foreach (explode(', ', $lbl_sources->sources) as $s) {
				if ($s && !in_array($s, $sources_arr)) $sources_arr[] = $s;
			}
		}

		$name = '-';
		if ($dates_so && !empty($dates_so->nama)) $name = $dates_so->nama;
		elseif ($dates_pm && !empty($dates_pm->nama)) $name = $dates_pm->nama;
		else {
			$name_lbl = $this->db->query("SELECT customer_nama FROM crm_transaction_followup_labels WHERE {$where_lbl} LIMIT 1")->row();
			if ($name_lbl) $name = $name_lbl->customer_nama;
		}

		$total_spend = (float)$so_spend + (float)$mp_spend;
		$total_orders = (int)$so_count + (int)$mp_count;

		$thresholds = !empty($product_filter) ? $this->get_rfm_percentile_thresholds($product_filter) : null;
		$rfm = $this->calculate_rfm($last_order, $total_orders, $total_spend, $thresholds);

		return [
			'nama' => $name,
			'phone' => $phone,
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
		$where_so = $this->get_phone_where_clause('so.no_telepon', $phone);
		$where_pm = $this->get_phone_where_clause('pm.no_telepon', $phone);
		$where_lbl = $this->get_phone_where_clause('lbl.customer_phone', $phone);

		// Product filter JOINs
		$so_join = '';
		$so_product_where = '';
		$pm_join_extra = '';
		$pm_product_where = '';
		if (!empty($product_filter)) {
			$pf = $this->db->escape($product_filter);
			$so_join = "INNER JOIN sales_order_item soi_f ON soi_f.so_id = so.id LEFT JOIN produk p_f ON soi_f.produk_id = p_f.id";
			$so_product_where = " AND (p_f.nama_produk = {$pf} OR soi_f.catatan = {$pf})";
			$pm_join_extra = "INNER JOIN penjualan_marketplace_item pmi_f ON pmi_f.penjualan_marketplace_id = pm.id LEFT JOIN produk p2_f ON pmi_f.produk_id = p2_f.id";
			$pm_product_where = " AND (p2_f.nama_produk = {$pf} OR pmi_f.catatan = {$pf} OR pm.nama_produk_marketplace = {$pf})";
		}

		$sql = "
			(SELECT DISTINCT
				CAST('sales_order' AS CHAR) COLLATE utf8mb4_unicode_ci as tbl, 
				so.id, 
				CAST(so.nomor_so AS CHAR) COLLATE utf8mb4_unicode_ci as nomor_so, 
				CAST(so.no_pesanan AS CHAR) COLLATE utf8mb4_unicode_ci as no_pesanan, 
				so.tanggal_so as tanggal,
				COALESCE(so.tanggal_kirim, so.tanggal_so) as tanggal_kirim,
				CAST('Toko' AS CHAR) COLLATE utf8mb4_unicode_ci as sumber_penjualan,
				CAST(so.status AS CHAR) COLLATE utf8mb4_unicode_ci as status, 
				CAST(so.status_pesanan AS CHAR) COLLATE utf8mb4_unicode_ci as status_pesanan, 
				CAST(so.nomor_resi AS CHAR) COLLATE utf8mb4_unicode_ci as nomor_resi, 
				CAST(so.kurir_ekspedisi AS CHAR) COLLATE utf8mb4_unicode_ci as kurir_ekspedisi,
				CAST(so.nama_penerima AS CHAR) COLLATE utf8mb4_unicode_ci as nama_penerima, 
				CAST(so.no_telepon AS CHAR) COLLATE utf8mb4_unicode_ci as no_telepon, 
				CAST(so.alamat_pengiriman AS CHAR) COLLATE utf8mb4_unicode_ci as alamat_pengiriman,
				so.total, 
				CAST(COALESCE(
					NULLIF(so.nama_produk_marketplace, ''),
					(SELECT COALESCE(NULLIF(soi.catatan, ''), p.nama_produk) FROM sales_order_item soi LEFT JOIN produk p ON soi.produk_id = p.id WHERE soi.so_id = so.id ORDER BY soi.id ASC LIMIT 1),
					'Produk SO'
				) AS CHAR) COLLATE utf8mb4_unicode_ci as produk_ringkasan
			FROM sales_order so 
			{$so_join}
			WHERE {$where_so}{$so_product_where})
			UNION ALL
			(SELECT DISTINCT
				CAST('penjualan_marketplace' AS CHAR) COLLATE utf8mb4_unicode_ci as tbl, 
				pm.id, 
				CAST(pm.nomor_so AS CHAR) COLLATE utf8mb4_unicode_ci as nomor_so, 
				CAST(pm.no_pesanan AS CHAR) COLLATE utf8mb4_unicode_ci as no_pesanan, 
				pm.tanggal_so as tanggal,
				pm.tanggal_so as tanggal_kirim,
				CAST(COALESCE(
					lbl.order_source,
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
				pm.total, 
				CAST(COALESCE(
					NULLIF(pm.nama_produk_marketplace, ''),
					(SELECT COALESCE(NULLIF(pmi.catatan, ''), p.nama_produk) FROM penjualan_marketplace_item pmi LEFT JOIN produk p ON pmi.produk_id = p.id WHERE pmi.penjualan_marketplace_id = pm.id ORDER BY pmi.id ASC LIMIT 1),
					'Produk Marketplace'
				) AS CHAR) COLLATE utf8mb4_unicode_ci as produk_ringkasan
			FROM penjualan_marketplace pm 
			{$pm_join_extra}
			LEFT JOIN crm_transaction_followup_labels lbl ON lbl.order_id = pm.id AND lbl.order_table = 'penjualan_marketplace'
			WHERE {$where_pm}{$pm_product_where})
			" . (empty($product_filter) ? "UNION ALL
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
			WHERE {$where_lbl} AND (lbl.order_id = 0 OR lbl.order_id IS NULL))" : "") . "
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
	 * Get product-level RFM metrics for a customer (Recency, Frequency, Monetary PER PRODUCT)
	 */
	public function get_customer_product_rfm($phone)
	{
		$where_so = $this->get_phone_where_clause('so.no_telepon', $phone);
		$where_pm = $this->get_phone_where_clause('pm.no_telepon', $phone);

		$sql = "
			SELECT 
				item_data.produk_id,
				item_data.nama_produk,
				item_data.kode_produk,
				MAX(item_data.tanggal_transaksi) as last_bought_date,
				DATEDIFF(CURRENT_DATE(), MAX(item_data.tanggal_transaksi)) as recency_days,
				COUNT(DISTINCT item_data.order_id) as order_count,
				SUM(item_data.qty) as total_qty,
				SUM(item_data.subtotal) as total_spend
			FROM (
				SELECT 
					soi.produk_id,
					COALESCE(NULLIF(soi.catatan, ''), p.nama_produk, 'Produk SO') as nama_produk,
					COALESCE(p.kode_produk, '-') as kode_produk,
					so.tanggal_so as tanggal_transaksi,
					CONCAT('so_', so.id) as order_id,
					soi.qty,
					soi.subtotal
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				WHERE {$where_so}

				UNION ALL

				SELECT 
					pmi.produk_id,
					COALESCE(NULLIF(pmi.catatan, ''), p.nama_produk, 'Produk Marketplace') as nama_produk,
					COALESCE(p.kode_produk, '-') as kode_produk,
					pm.tanggal_so as tanggal_transaksi,
					CONCAT('pm_', pm.id) as order_id,
					pmi.qty,
					pmi.subtotal
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p ON pmi.produk_id = p.id
				WHERE {$where_pm}
			) item_data
			GROUP BY item_data.nama_produk, item_data.kode_produk, item_data.produk_id
			ORDER BY total_spend DESC, last_bought_date DESC
		";

		return $this->db->query($sql)->result();
	}

	/**
	 * Get list of all distinct products for dropdown filters
	 */
	public function get_all_products_list()
	{
		$sql = "
			SELECT DISTINCT item_name FROM (
				SELECT COALESCE(NULLIF(soi.catatan, ''), p.nama_produk) as item_name
				FROM sales_order_item soi LEFT JOIN produk p ON soi.produk_id = p.id
				UNION
				SELECT COALESCE(NULLIF(pmi.catatan, ''), p.nama_produk) as item_name
				FROM penjualan_marketplace_item pmi LEFT JOIN produk p ON pmi.produk_id = p.id
			) u
			WHERE item_name IS NOT NULL AND item_name != ''
			ORDER BY item_name ASC
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
	 * Get monthly RFM tracking & trend data per product
	 */
	public function get_monthly_rfm_tracking_per_product($product_filter = '', $period_filter = '')
	{
		$where_conds = [];
		if (!empty($product_filter)) {
			$pf_esc = $this->db->escape_like_str($product_filter);
			$where_conds[] = "(t_data.nama_produk LIKE '%{$pf_esc}%')";
		}

		$where_sql = !empty($where_conds) ? "WHERE " . implode(' AND ', $where_conds) : "";

		$sql = "
			SELECT 
				DATE_FORMAT(t_data.tanggal_so, '%Y-%m') as ym_period,
				DATE_FORMAT(t_data.tanggal_so, '%M %Y') as period_label,
				COUNT(DISTINCT t_data.no_telepon) as unique_buyers,
				COUNT(DISTINCT t_data.order_id) as total_orders,
				SUM(t_data.qty) as total_qty,
				SUM(t_data.subtotal) as total_spend,
				ROUND(AVG(DATEDIFF(CURRENT_DATE(), t_data.tanggal_so)), 0) as avg_recency_days
			FROM (
				SELECT 
					so.no_telepon,
					so.tanggal_so,
					CONCAT('so_', so.id) as order_id,
					soi.qty,
					soi.subtotal,
					COALESCE(p.nama_produk, soi.catatan, 'Produk SO') as nama_produk
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND so.tanggal_so IS NOT NULL 
				  AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND so.tanggal_so > '1970-01-01'

				UNION ALL

				SELECT 
					pm.no_telepon,
					pm.tanggal_so,
					CONCAT('pm_', pm.id) as order_id,
					pmi.qty,
					pmi.subtotal,
					COALESCE(p2.nama_produk, pmi.catatan, pm.nama_produk_marketplace, 'Produk Marketplace') as nama_produk
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p2 ON pmi.produk_id = p2.id
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL 
				  AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' 
				  AND pm.tanggal_so > '1970-01-01'
			) t_data
			{$where_sql}
			GROUP BY ym_period, period_label
			ORDER BY ym_period DESC
		";

		$all_rows = $this->db->query($sql)->result();

		// Calculate MoM growth percentage for each month chronologically
		for ($i = 0; $i < count($all_rows); $i++) {
			$all_rows[$i]->unique_buyers = (int)$all_rows[$i]->unique_buyers;
			$all_rows[$i]->total_orders = (int)$all_rows[$i]->total_orders;
			$all_rows[$i]->total_qty = (float)$all_rows[$i]->total_qty;
			$all_rows[$i]->total_spend = (float)$all_rows[$i]->total_spend;
			$all_rows[$i]->avg_recency_days = (int)$all_rows[$i]->avg_recency_days;

			$prev_spend = isset($all_rows[$i + 1]) ? (float)$all_rows[$i + 1]->total_spend : 0;
			$all_rows[$i]->prev_spend = $prev_spend;
			if ($prev_spend > 0) {
				$all_rows[$i]->mom_growth_pct = round((($all_rows[$i]->total_spend - $prev_spend) / $prev_spend) * 100, 1);
			} else {
				$all_rows[$i]->mom_growth_pct = 0.0;
			}
		}

		if (!empty($period_filter)) {
			$filtered = [];
			foreach ($all_rows as $r) {
				if ($r->ym_period === $period_filter) {
					$filtered[] = $r;
				}
			}
			return $filtered;
		}

		return $all_rows;
	}

	/**
	 * Get Cohort Analysis Data
	 * 
	 * @param string $mode 'daily' (show days within 1 month) or 'monthly' (show months within 1 year)
	 * @param string $year The year to analyze (e.g. '2026')
	 * @param string $month The month to analyze for daily mode (e.g. '09')
	 * @return array ['cohorts' => [...], 'periods' => [...], 'summary' => [...]]
	 */
	public function get_cohort_analysis($mode = 'monthly', $year = '', $month = '')
	{
		if (empty($year)) {
			$year = date('Y');
		}

		if ($mode === 'daily') {
			if (empty($month)) {
				$month = date('m');
			}
			return $this->_get_daily_cohort($year, $month);
		} else {
			return $this->_get_monthly_cohort($year);
		}
	}

	/**
	 * Daily cohort: customers grouped by the DAY of first purchase within a given month
	 * Columns = subsequent days within the same month
	 */
	private function _get_daily_cohort($year, $month)
	{
		$ym = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
		$days_in_month = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);

		// Get all transactions in this month
		$sql = "
			SELECT phone, DATE(tanggal) as order_date
			FROM (
				SELECT CAST(so.no_telepon AS CHAR) as phone, so.tanggal_so as tanggal
				FROM sales_order so
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND so.tanggal_so IS NOT NULL AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' AND so.tanggal_so > '1970-01-01'
				  AND DATE_FORMAT(so.tanggal_so, '%Y-%m') = '{$ym}'

				UNION ALL

				SELECT CAST(pm.no_telepon AS CHAR) as phone, pm.tanggal_so as tanggal
				FROM penjualan_marketplace pm
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' AND pm.tanggal_so > '1970-01-01'
				  AND DATE_FORMAT(pm.tanggal_so, '%Y-%m') = '{$ym}'
			) u
			ORDER BY order_date ASC
		";

		$rows = $this->db->query($sql)->result();

		// Find first purchase date for each customer within this month
		$first_purchase = [];
		$customer_dates = [];
		foreach ($rows as $r) {
			$phone = $r->phone;
			$date = $r->order_date;
			if (!isset($first_purchase[$phone]) || $date < $first_purchase[$phone]) {
				$first_purchase[$phone] = $date;
			}
			if (!isset($customer_dates[$phone])) {
				$customer_dates[$phone] = [];
			}
			$customer_dates[$phone][$date] = true;
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

		// Build cohort data
		$cohorts = [];
		$period_labels = [];
		for ($d = 1; $d <= $days_in_month; $d++) {
			$period_labels[] = $d;
		}

		ksort($cohort_customers);
		$total_initial = 0;
		$total_retained_sum = [];

		foreach ($cohort_customers as $cohort_day => $phones) {
			$cohort_size = count($phones);
			$total_initial += $cohort_size;
			$retention = [];

			for ($d = 1; $d <= $days_in_month; $d++) {
				$target_date = sprintf('%s-%02d', $ym, $d);
				if ($d < $cohort_day) {
					$retention[$d] = null; // Before cohort start
				} elseif ($d === $cohort_day) {
					$retention[$d] = 100.0; // Cohort start = 100%
				} else {
					$active = 0;
					foreach ($phones as $phone) {
						if (isset($customer_dates[$phone][$target_date])) {
							$active++;
						}
					}
					$pct = $cohort_size > 0 ? round(($active / $cohort_size) * 100, 1) : 0;
					$retention[$d] = $pct;

					if (!isset($total_retained_sum[$d])) $total_retained_sum[$d] = 0;
					$total_retained_sum[$d] += $active;
				}
			}

			$cohorts[] = [
				'label' => 'Hari ' . $cohort_day,
				'date_label' => sprintf('%s-%02d', $ym, $cohort_day),
				'size' => $cohort_size,
				'retention' => $retention,
			];
		}

		return [
			'cohorts' => $cohorts,
			'periods' => $period_labels,
			'mode' => 'daily',
			'year' => $year,
			'month' => $month,
			'ym' => $ym,
			'summary' => [
				'total_cohorts' => count($cohorts),
				'total_customers' => $total_initial,
				'days_in_month' => $days_in_month,
			],
		];
	}

	/**
	 * Monthly cohort: customers grouped by the MONTH of first purchase within a given year
	 * Columns = subsequent months within the same year
	 */
	private function _get_monthly_cohort($year)
	{
		// Get all transactions in this year
		$sql = "
			SELECT phone, DATE_FORMAT(tanggal, '%Y-%m') as order_month
			FROM (
				SELECT CAST(so.no_telepon AS CHAR) as phone, so.tanggal_so as tanggal
				FROM sales_order so
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''
				  AND so.tanggal_so IS NOT NULL AND CAST(so.tanggal_so AS CHAR) NOT LIKE '0000%' AND so.tanggal_so > '1970-01-01'
				  AND YEAR(so.tanggal_so) = '{$year}'

				UNION ALL

				SELECT CAST(pm.no_telepon AS CHAR) as phone, pm.tanggal_so as tanggal
				FROM penjualan_marketplace pm
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
				  AND pm.tanggal_so IS NOT NULL AND CAST(pm.tanggal_so AS CHAR) NOT LIKE '0000%' AND pm.tanggal_so > '1970-01-01'
				  AND YEAR(pm.tanggal_so) = '{$year}'
			) u
			ORDER BY order_month ASC
		";

		$rows = $this->db->query($sql)->result();

		// Find first purchase month for each customer within this year
		$first_purchase = [];
		$customer_months = [];
		foreach ($rows as $r) {
			$phone = $r->phone;
			$ym = $r->order_month;
			if (!isset($first_purchase[$phone]) || $ym < $first_purchase[$phone]) {
				$first_purchase[$phone] = $ym;
			}
			if (!isset($customer_months[$phone])) {
				$customer_months[$phone] = [];
			}
			$customer_months[$phone][$ym] = true;
		}

		// Group customers by their cohort month
		$cohort_customers = [];
		foreach ($first_purchase as $phone => $first_ym) {
			if (!isset($cohort_customers[$first_ym])) {
				$cohort_customers[$first_ym] = [];
			}
			$cohort_customers[$first_ym][] = $phone;
		}

		// Build month labels
		$month_names_id = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Ags',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
		$period_labels = [];
		$all_months = [];
		for ($m = 1; $m <= 12; $m++) {
			$ym_key = sprintf('%s-%02d', $year, $m);
			$period_labels[] = $month_names_id[$m];
			$all_months[] = $ym_key;
		}

		ksort($cohort_customers);
		$cohorts = [];
		$total_initial = 0;

		foreach ($cohort_customers as $cohort_ym => $phones) {
			$cohort_size = count($phones);
			$total_initial += $cohort_size;
			$cohort_month_idx = (int)substr($cohort_ym, 5, 2); // 1-12
			$retention = [];

			for ($m = 1; $m <= 12; $m++) {
				$target_ym = sprintf('%s-%02d', $year, $m);
				if ($m < $cohort_month_idx) {
					$retention[$m] = null; // Before cohort start
				} elseif ($m === $cohort_month_idx) {
					$retention[$m] = 100.0; // Cohort start = 100%
				} else {
					$active = 0;
					foreach ($phones as $phone) {
						if (isset($customer_months[$phone][$target_ym])) {
							$active++;
						}
					}
					$pct = $cohort_size > 0 ? round(($active / $cohort_size) * 100, 1) : 0;
					$retention[$m] = $pct;
				}
			}

			$cohorts[] = [
				'label' => $month_names_id[$cohort_month_idx] . ' ' . $year,
				'date_label' => $cohort_ym,
				'size' => $cohort_size,
				'retention' => $retention,
			];
		}

		return [
			'cohorts' => $cohorts,
			'periods' => $period_labels,
			'mode' => 'monthly',
			'year' => $year,
			'month' => '',
			'ym' => '',
			'summary' => [
				'total_cohorts' => count($cohorts),
				'total_customers' => $total_initial,
			],
		];
	}

	/**
	 * Get aggregated RFM analysis PER PRODUCT across all customers
	 */
	public function get_product_rfm_list($filter = '', $limit = 50, $offset = 0)
	{
		$where_clause = "";
		if (!empty($filter)) {
			$f_esc = $this->db->escape_like_str($filter);
			$where_clause = " WHERE item_name LIKE '%{$f_esc}%'";
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
					COALESCE(NULLIF(soi.catatan, ''), p.nama_produk, 'Produk SO') as item_name,
					soi.qty,
					soi.subtotal,
					so.tanggal_so as tanggal
				FROM sales_order_item soi
				JOIN sales_order so ON soi.so_id = so.id
				LEFT JOIN produk p ON soi.produk_id = p.id
				WHERE so.no_telepon IS NOT NULL AND so.no_telepon != ''

				UNION ALL

				SELECT 
					pm.no_telepon as phone,
					CONCAT('pm_', pm.id) as order_id,
					COALESCE(NULLIF(pmi.catatan, ''), p.nama_produk, 'Produk Marketplace') as item_name,
					pmi.qty,
					pmi.subtotal,
					pm.tanggal_so as tanggal
				FROM penjualan_marketplace_item pmi
				JOIN penjualan_marketplace pm ON pmi.penjualan_marketplace_id = pm.id
				LEFT JOIN produk p ON pmi.produk_id = p.id
				WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != ''
			) u
			{$where_clause}
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
			$this->db->join('crm_followup_categories fc', 'tfl.followup_category_id = fc.id');

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
			if (empty($filters['show_future']) && empty($filters['search']) && empty($filters['date_from']) && empty($filters['date_to'])) {
				$this->db->where('tfl.tanggal_label_muncul <=', date('Y-m-d'));
			}
		};

		// 1. Fast count query (NO subselects)
		$this->db->select('COUNT(tfl.id) as total_count');
		$apply_where();
		$count_row = $this->db->get()->row();
		$count = $count_row ? (int)$count_row->total_count : 0;

		// 2. Fast paginated rows query
		$this->db->select('tfl.*, fc.nama_kategori, fc.kode_kategori, fc.jumlah_hari, 0 AS total_wa_sent');
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

		return ['rows' => $rows, 'total' => $count];
	}

	/**
	 * Ensure at least one followup label exists for a given phone number so that 2-way chat modal can open
	 */
	public function ensure_label_for_phone($phone)
	{
		$clean_phone = preg_replace('/[^0-9]/', '', (string)$phone);
		if (empty($clean_phone)) return null;

		$where_clause = $this->get_phone_where_clause('tfl.customer_phone', $phone);
		$existing = $this->db->query("SELECT id FROM crm_transaction_followup_labels tfl WHERE {$where_clause} LIMIT 1")->row();
		if ($existing) {
			return $existing->id;
		}

		// Find customer name from sales_order or marketplace
		$so_cust = $this->db->query("SELECT nama_penerima as nama FROM sales_order so WHERE " . $this->get_phone_where_clause('so.no_telepon', $phone) . " LIMIT 1")->row();
		$pm_cust = $this->db->query("SELECT nama_penerima as nama FROM penjualan_marketplace pm WHERE " . $this->get_phone_where_clause('pm.no_telepon', $phone) . " LIMIT 1")->row();

		$nama = 'Customer';
		if (!empty($so_cust->nama)) $nama = $so_cust->nama;
		elseif (!empty($pm_cust->nama)) $nama = $pm_cust->nama;

		$categories = $this->get_categories(true);
		$cat_id = !empty($categories) ? $categories[0]->id : 1;
		$now = date('Y-m-d H:i:s');

		$this->db->insert('crm_transaction_followup_labels', [
			'order_source' => 'Direct',
			'order_id' => 0,
			'order_table' => 'manual_entry',
			'customer_nama' => $nama,
			'customer_phone' => $phone,
			'no_pesanan' => 'RFM-' . date('YmdHis'),
			'tanggal_pengiriman' => date('Y-m-d'),
			'followup_category_id' => $cat_id,
			'tanggal_label_muncul' => date('Y-m-d'),
			'status_label' => 'Pending',
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
				(SELECT message FROM crm_chat_history ch WHERE LENGTH(ch.customer_phone) >= 9 AND RIGHT(ch.customer_phone, 9) = RIGHT(tfl.customer_phone, 9) ORDER BY ch.id DESC LIMIT 1) as last_message,
				(SELECT created_at FROM crm_chat_history ch WHERE LENGTH(ch.customer_phone) >= 9 AND RIGHT(ch.customer_phone, 9) = RIGHT(tfl.customer_phone, 9) ORDER BY ch.id DESC LIMIT 1) as last_message_at,
				(SELECT COUNT(*) FROM crm_chat_history ch WHERE LENGTH(ch.customer_phone) >= 9 AND RIGHT(ch.customer_phone, 9) = RIGHT(tfl.customer_phone, 9) AND ch.direction = 'in' AND ch.status != 'read') as unread_count
			FROM crm_transaction_followup_labels tfl
			INNER JOIN (
				SELECT MAX(id) as max_id
				FROM crm_transaction_followup_labels
				WHERE customer_phone IS NOT NULL AND customer_phone != ''
				GROUP BY RIGHT(customer_phone, 9)
			) latest ON latest.max_id = tfl.id
			WHERE 1=1
		";

		if (!empty($search)) {
			$s = $this->db->escape_like_str($search);
			$clean_search = preg_replace('/[^0-9]/', '', $search);
			
			$phone_conds = ["tfl.customer_phone LIKE '%{$s}%'"];
			if (strlen($clean_search) >= 4) {
				$tail = strlen($clean_search) >= 8 ? substr($clean_search, -8) : $clean_search;
				$tail_esc = $this->db->escape_like_str($tail);
				$phone_conds[] = "RIGHT(tfl.customer_phone, 8) LIKE '%{$tail_esc}%'";
				
				if (substr($clean_search, 0, 2) === '08') {
					$alt = '628' . substr($clean_search, 2);
					$phone_conds[] = "tfl.customer_phone LIKE '%{$alt}%'";
				} elseif (substr($clean_search, 0, 3) === '628') {
					$alt = '08' . substr($clean_search, 3);
					$phone_conds[] = "tfl.customer_phone LIKE '%{$alt}%'";
				}
			}
			$phone_sql = implode(' OR ', $phone_conds);

			$sql .= " AND (tfl.customer_nama LIKE '%{$s}%' OR ({$phone_sql}) OR tfl.no_pesanan LIKE '%{$s}%')";
		}

		$sql .= " ORDER BY 
			unread_count DESC,
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
			$conditions_so[] = "(LENGTH(so.no_telepon) >= 9 AND RIGHT(so.no_telepon, 9) = '{$tail_esc}')";
			$conditions_pm[] = "(LENGTH(pm.no_telepon) >= 9 AND RIGHT(pm.no_telepon, 9) = '{$tail_esc}')";
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
		WHERE so.no_telepon IS NOT NULL AND so.no_telepon != '' AND ({$so_where})
		GROUP BY phone_tail";

		// Query 2: penjualan_marketplace summary grouped by phone tail
		$pm_where = implode(' OR ', $conditions_pm);
		$sql_pm = "SELECT 
			RIGHT(pm.no_telepon, 9) as phone_tail,
			COUNT(*) as cnt,
			COALESCE(SUM(pm.total), 0) as spend,
			MAX(pm.tanggal_so) as last_date
		FROM penjualan_marketplace pm
		WHERE pm.no_telepon IS NOT NULL AND pm.no_telepon != '' AND ({$pm_where})
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
	 * Add follow-up note (FB-07) — supports sender_type for 2-way chat
	 */
	public function add_note($label_id, $catatan, $status_manual = null, $sender_type = 'cs')
	{
		return $this->db->insert('crm_followup_notes', [
			'followup_label_id' => $label_id,
			'username' => get_user_data('username') ?: 'system',
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

		// Find active labels for this phone by comparing canonical numbers
		$all_labels = $this->db
			->order_by('tanggal_label_muncul', 'DESC')
			->get('crm_transaction_followup_labels')
			->result();

		$matched_labels = [];
		foreach ($all_labels as $lbl) {
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
				$clean_db_phone = $this->normalize_phone_number($lbl->customer_phone);
				if ($clean_db_phone === $clean_input_phone || (!empty($phone_tail) && strlen($clean_db_phone) >= 9 && substr($clean_db_phone, -9) === $phone_tail)) {
					$matched_labels[] = $lbl;
					break;
				}
			}
		}

		// Fallback 2: If no label exists at all for this customer phone, check sales_order / penjualan_marketplace
		if (empty($matched_labels)) {
			$cust_name = !empty($sender_name) ? $sender_name : '';
			$so_match = $this->db->query("SELECT id, nama_penerima FROM sales_order WHERE no_telepon LIKE ? ORDER BY id DESC LIMIT 1", ["%{$phone_tail}%"])->row();
			if ($so_match && !empty($so_match->nama_penerima)) {
				$cust_name = $so_match->nama_penerima;
			} else {
				$mp_match = $this->db->query("SELECT id, nama_penerima FROM penjualan_marketplace WHERE no_telepon LIKE ? ORDER BY id DESC LIMIT 1", ["%{$phone_tail}%"])->row();
				if ($mp_match && !empty($mp_match->nama_penerima)) {
					$cust_name = $mp_match->nama_penerima;
				}
			}

			if (!empty($cust_name)) {
				$first_cat = $this->db->query("SELECT id FROM crm_followup_categories WHERE is_active = 1 ORDER BY urutan ASC LIMIT 1")->row();
				$cat_id = $first_cat ? $first_cat->id : 1;

				$new_label_data = [
					'order_source' => 'Toko',
					'order_id' => 0,
					'order_table' => 'sales_order',
					'customer_nama' => $cust_name,
					'customer_phone' => $clean_input_phone,
					'no_pesanan' => 'WA-INCOMING',
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
		}

		$logged_count = 0;

		if (!empty($matched_labels)) {
			// If sender_name was provided, narrow matched_labels down to ones matching customer_nama
			if (count($matched_labels) > 1 && !empty($sender_name)) {
				$clean_sname = strtolower(trim($sender_name));
				$filtered = [];
				foreach ($matched_labels as $lbl) {
					if (strtolower(trim($lbl->customer_nama)) === $clean_sname) {
						$filtered[] = $lbl;
					}
				}
				if (!empty($filtered)) {
					$matched_labels = $filtered;
				}
			}

			$primary_label = $matched_labels[0];
			$cust_username = !empty($primary_label->customer_nama) ? $primary_label->customer_nama : (!empty($sender_name) ? $sender_name : 'Customer');

			// Idempotency check: Skip duplicate insert if same message was logged for this label within 5 minutes
			// Or if CS sent an outgoing message matching this text in the last 3 minutes
			$three_mins_ago = date('Y-m-d H:i:s', time() - 180);
			$clean_check_msg = trim(str_replace(['> _Sent via fonnte.com_', '_Sent via fonnte.com_', 'Sent via fonnte.com'], '', $message));

			$cs_outgoing_exists = $this->db->query("
				SELECT id FROM crm_chat_history 
				WHERE label_id = ? AND created_at >= ? 
				  AND (direction = 'out' OR is_internal_note = 0)
				  AND (message = ? OR message LIKE ?)
				LIMIT 1
			", [$primary_label->id, $three_mins_ago, $clean_check_msg, '%' . $this->db->escape_like_str($clean_check_msg) . '%'])->num_rows();

			if ($cs_outgoing_exists > 0) {
				return 0; // Skip echo of CS outgoing message
			}

			$five_mins_ago = date('Y-m-d H:i:s', time() - 300);
			$dup_check = $this->db->where([
				'label_id' => $primary_label->id,
				'direction' => 'in',
				'message' => $message,
				'created_at >=' => $five_mins_ago
			])->count_all_results('crm_chat_history');

			// Also check legacy notes table for backward compat
			if ($dup_check == 0) {
				$dup_check = $this->db->where([
					'followup_label_id' => $primary_label->id,
					'sender_type' => 'customer',
					'catatan' => $message,
					'created_at >=' => $five_mins_ago
				])->count_all_results('crm_followup_notes');
			}

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
			$first_cat = $this->db->query("SELECT id FROM crm_followup_categories WHERE is_active = 1 ORDER BY urutan ASC LIMIT 1")->row();
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

		$label_ids = $this->get_related_label_ids($label);
		$clean_phone = $this->normalize_phone_number($label->customer_phone);
		$phone_tail = strlen($clean_phone) >= 9 ? substr($clean_phone, -9) : $clean_phone;

		$this->db->select('id, label_id, customer_phone, direction, message, sender_name, sender_cs_name, is_internal_note, status, created_at')
			->from('crm_chat_history');

		$this->db->group_start();
		$this->db->where_in('label_id', $label_ids);
		if (!empty($phone_tail)) {
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
				$sender = !empty($row['sender_cs_name']) ? $row['sender_cs_name'] : (!empty($row['sender_name']) ? $row['sender_name'] : 'CS Admin');
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
	private function get_related_label_ids($label)
	{
		$clean_phone = $this->normalize_phone_number($label->customer_phone);
		$phone_tail = strlen($clean_phone) >= 9 ? substr($clean_phone, -9) : $clean_phone;

		if (empty($phone_tail)) {
			return [(int)$label->id];
		}

		$tail_esc = $this->db->escape_str($phone_tail);
		$sql = "SELECT id FROM crm_transaction_followup_labels 
				WHERE LENGTH(customer_phone) >= 9 AND RIGHT(customer_phone, 9) = '{$tail_esc}'";
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
			if (!empty($phone_tail)) {
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
				$sender = !empty($row['sender_cs_name']) ? $row['sender_cs_name'] : (!empty($row['sender_name']) ? $row['sender_name'] : 'CS Admin');
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
				'sender' => !empty($row['sender']) ? $row['sender'] : 'CS Admin',
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

			$sender = isset($row['sender']) ? $row['sender'] : 'CS Admin';
			if ($direction === 'incoming') {
				$sender = $cust_display_name . ' (Balasan)';
			} elseif (empty($sender)) {
				$sender = 'CS Admin';
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
				$seen[$key] = true;
				$timeline[] = $item;
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
		return 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . rawurlencode($message);
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
	public function send_wa_via_api($phone, $message, $file_url = '')
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
				'message' => !empty($message) ? $message : ' ',
			];
			if (!empty($file_url)) {
				$post_data['url'] = $file_url;
				$filename = pathinfo(parse_url($file_url, PHP_URL_PATH), PATHINFO_BASENAME);
				if (!empty($filename)) {
					$post_data['filename'] = $filename;
				}

				// Auto-detect media type for Fonnte API
				$ext = strtolower(pathinfo(parse_url($file_url, PHP_URL_PATH), PATHINFO_EXTENSION));
				if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'])) {
					$post_data['type'] = 'image';
				} elseif (in_array($ext, ['mp4', 'avi', 'mov', 'mkv', '3gp'])) {
					$post_data['type'] = 'video';
				} elseif (in_array($ext, ['mp3', 'ogg', 'wav', 'm4a', 'aac', 'opus', 'amr', 'webm'])) {
					$post_data['type'] = 'audio';
				} else {
					$post_data['type'] = 'document';
				}
			}
			$target_url = (empty($api_url) || strpos($api_url, 'send-message') !== false) ? 'https://api.fonnte.com/send' : $api_url;
			curl_setopt($ch, CURLOPT_URL, $target_url);
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
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

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
		$err_msg = 'API Error (HTTP ' . $http_code . ')';

		if (is_array($res_json)) {
			if (isset($res_json['status'])) {
				if ($res_json['status'] === false || $res_json['status'] === 'false' || $res_json['status'] === 0) {
					$is_ok = false;
					$reason = !empty($res_json['reason']) ? $res_json['reason'] : (!empty($res_json['detail']) ? $res_json['detail'] : (!empty($res_json['message']) ? $res_json['message'] : 'Gagal terkirim dari Fonnte Gateway'));
					$err_msg = 'Fonnte Gateway Error: ' . $reason;
				}
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

		// Process sales_order
		$so_rows = $this->db->query("SELECT so.*, p.nama_pelanggan, p.telepon, p.no_telp 
			FROM sales_order so LEFT JOIN pelanggan p ON so.pelanggan_id = p.id 
			WHERE so.status NOT IN ('cancelled','dibatalkan')")->result();

		foreach ($so_rows as $so) {
			$ship_date = $so->tanggal_kirim ?: ($so->tanggal_so ?: substr($so->created_at, 0, 10));
			$phone = $so->no_telepon ?: ($so->telepon ?: ($so->no_telp ?: ''));
			$nama = $so->nama_penerima ?: ($so->nama_pelanggan ?: '-');
			$so_src = strtolower($so->source ?: '');
			$source = 'Toko';
			if (strpos($so_src, 'shopee') !== false) $source = 'Shopee';
			elseif (strpos($so_src, 'tokopedia') !== false) $source = 'Tokopedia';
			elseif (strpos($so_src, 'tiktok') !== false) $source = 'TikTok Shop';

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
			    WHEN LOWER(so.source) LIKE '%toko%' OR so.source = 'manual' OR so.source IS NULL THEN 'Toko'
			    WHEN LOWER(so.source) LIKE '%shopee%' THEN 'Shopee'
			    WHEN LOWER(so.source) LIKE '%tokopedia%' THEN 'Tokopedia'
			    WHEN LOWER(so.source) LIKE '%tiktok%' THEN 'TikTok Shop'
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
