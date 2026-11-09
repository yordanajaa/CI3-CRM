<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_penjualan_marketplace extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'penjualan_marketplace';
	private $field_search 	= [
		'penjualan_marketplace.nomor_so', 
		'penjualan_marketplace.no_pesanan', 
		'penjualan_marketplace.nomor_resi', 
		'penjualan_marketplace.username_pembeli', 
		'penjualan_marketplace.nama_penerima', 
		'penjualan_marketplace.nama_pengirim', 
		'pelanggan.nama_pelanggan', 
		'penjualan_marketplace.status'
	];

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
		 );

		parent::__construct($config);
	}

	public function join_available()
	{
		$this->db->select('penjualan_marketplace.*, pelanggan.nama_pelanggan, pelanggan.kode_pelanggan, pelanggan.tipe_pelanggan, pelanggan.alamat as alamat_pelanggan, pelanggan.no_telp as telp_pelanggan, pelanggan.telepon as telepon_pelanggan, (SELECT COALESCE(SUM(qty), 1) FROM penjualan_marketplace_item WHERE penjualan_marketplace_item.penjualan_marketplace_id = penjualan_marketplace.id) as total_qty');
		$this->db->join('pelanggan', 'pelanggan.id = penjualan_marketplace.pelanggan_id', 'LEFT');
		return $this;
	}

	public function count_all($q = '', $field = '')
	{
		$where = $this->build_where($q, $field);
		if (!empty($where)) {
			$this->db->join('pelanggan', 'pelanggan.id = penjualan_marketplace.pelanggan_id', 'LEFT');
			$this->db->where($where);
		}
		return $this->db->count_all_results($this->table_name);
	}

	public function get($q = '', $field = '', $limit = 0, $offset = 0)
	{
		$this->join_available();
		$where = $this->build_where($q, $field);
		if (!empty($where)) {
			$this->db->where($where);
		}
		if ($limit > 0) {
			$this->db->limit($limit, $offset);
		}
		// Selalu tampilkan data yang baru diimport / discan / diupdate paling pertama di atas
		$this->db->order_by('GREATEST(COALESCE(penjualan_marketplace.updated_at, "1970-01-01"), COALESCE(penjualan_marketplace.created_at, "1970-01-01"))', 'DESC', FALSE);
		$this->db->order_by('penjualan_marketplace.'.$this->primary_key, 'DESC');
		return $this->db->get($this->table_name)->result();
	}

	private function build_where($q = '', $field = '')
	{
		$where = NULL;
		$q = $this->scurity($q);
		$field = $this->scurity($field);

		if (!empty($q)) {
			if (empty($field)) {
				$where_q = [];
				foreach ($this->field_search as $f) {
					$where_q[] = $f . " LIKE '%" . $q . "%'";
				}
				$where .= "(" . implode(" OR ", $where_q) . ")";
			} else {
				$where .= "(" . $field . " LIKE '%" . $q . "%' )";
			}
		}

		$pelanggan_id = $this->input->get('pelanggan_id');
		if (!empty($pelanggan_id)) {
			$where .= ($where ? ' AND ' : '') . "penjualan_marketplace.pelanggan_id = " . intval($pelanggan_id);
		}

		$status = $this->input->get('status');
		if (!empty($status)) {
			$st_low = strtolower(trim($status));
			if ($st_low === 'draft') {
				$where .= ($where ? ' AND ' : '') . "(penjualan_marketplace.status = 'draft' OR LOWER(penjualan_marketplace.status_pesanan) IN ('draft', 'pesanan baru', 'siap kirim'))";
			} elseif ($st_low === 'confirmed') {
				$where .= ($where ? ' AND ' : '') . "(penjualan_marketplace.status IN ('confirmed', 'submitted') OR LOWER(penjualan_marketplace.status_pesanan) IN ('confirmed', 'ready', 'terkonfirmasi'))";
			} elseif ($st_low === 'packing') {
				$where .= ($where ? ' AND ' : '') . "(penjualan_marketplace.status = 'packing' OR LOWER(penjualan_marketplace.status_pesanan) IN ('packing', 'awaiting shipment', 'sedang dikemas', 'perlu dikirim'))";
			} elseif ($st_low === 'shipped') {
				$where .= ($where ? ' AND ' : '') . "(penjualan_marketplace.status = 'shipped' OR LOWER(penjualan_marketplace.status_pesanan) IN ('shipped', 'dikirim', 'dalam pengiriman'))";
			} elseif ($st_low === 'delivered') {
				$where .= ($where ? ' AND ' : '') . "(penjualan_marketplace.status IN ('delivered', 'completed', 'sukses') OR LOWER(penjualan_marketplace.status_pesanan) IN ('delivered', 'completed', 'selesai', 'sukses'))";
			} elseif ($st_low === 'cancelled') {
				$where .= ($where ? ' AND ' : '') . "(penjualan_marketplace.status IN ('cancelled', 'batal') OR LOWER(penjualan_marketplace.status_pesanan) IN ('cancelled', 'batal', 'dibatalkan'))";
			} else {
				$where .= ($where ? ' AND ' : '') . "penjualan_marketplace.status = " . $this->db->escape($status);
			}
		}

		$source = $this->input->get('source');
		if (!empty($source)) {
			$source_clean = strtolower(trim($source));
			if (in_array($source_clean, ['resi', 'scan_resi', 'import_resi', 'scan'])) {
				$where .= ($where ? ' AND ' : '') . "(
					LOWER(penjualan_marketplace.source) IN ('resi', 'scan_resi', 'import_resi', 'scan') 
					OR penjualan_marketplace.created_by IN ('import_resi', 'scan_resi') 
					OR penjualan_marketplace.catatan LIKE '%Auto-Created%' 
					OR penjualan_marketplace.catatan LIKE '%Label%' 
					OR penjualan_marketplace.catatan LIKE '%Scan Resi%'
					OR (penjualan_marketplace.nomor_resi IS NOT NULL AND penjualan_marketplace.nomor_resi != '' AND penjualan_marketplace.nomor_resi != '-' AND (penjualan_marketplace.catatan LIKE '%Label%' OR penjualan_marketplace.catatan LIKE '%Scan%'))
				)";
			} else if (in_array($source_clean, ['tiktok', 'tiktokshop', 'tiktok_shop', 'tiktok shop'])) {
				$where .= ($where ? ' AND ' : '') . "LOWER(penjualan_marketplace.source) IN ('tiktok', 'tiktokshop', 'tiktok_shop', 'tiktok shop')";
			} else if (in_array($source_clean, ['tokopedia', 'tokped', 'toped'])) {
				$where .= ($where ? ' AND ' : '') . "LOWER(penjualan_marketplace.source) IN ('tokopedia', 'tokped', 'toped')";
			} else if (in_array($source_clean, ['shopee', 'shp'])) {
				$where .= ($where ? ' AND ' : '') . "LOWER(penjualan_marketplace.source) IN ('shopee', 'shp')";
			} else if (in_array($source_clean, ['manual', 'regular', 'pos', 'offline'])) {
				$where .= ($where ? ' AND ' : '') . "(LOWER(penjualan_marketplace.source) IN ('manual', 'regular', 'pos', 'offline') OR penjualan_marketplace.source IS NULL OR penjualan_marketplace.source = '')";
			} else {
				$where .= ($where ? ' AND ' : '') . "LOWER(penjualan_marketplace.source) = " . $this->db->escape($source_clean);
			}
		}

		return $where;
	}

	public function find_with_detail($id)
	{
		$this->join_available();
		return $this->db->get_where($this->table_name, ['penjualan_marketplace.id' => $id])->row();
	}

	public function get_items($pm_id)
	{
		$pm = $this->db->get_where('penjualan_marketplace', ['id' => $pm_id])->row();
		return $this->db->select('penjualan_marketplace_item.*, produk.nama_produk, produk.kode_produk, kategori_produk.nama_kategori, satuan.singkatan, MIN(rak.kode_rak) as kode_rak, MIN(rak.baris) as baris')
			->join('produk', 'produk.id = penjualan_marketplace_item.produk_id', 'LEFT')
			->join('kategori_produk', 'kategori_produk.id = produk.kategori_id', 'LEFT')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT')
			->join('rak', "rak.id = produk.default_rak_id", 'LEFT')
			->group_by('penjualan_marketplace_item.id')
			->get_where('penjualan_marketplace_item', ['penjualan_marketplace_id' => $pm_id])->result();
	}

	public function generate_nomor()
	{
		$prefix = 'MP-' . date('Ym') . '-';

		// Cari nomor SO tertinggi dengan prefix MP- di tabel penjualan_marketplace
		$this->db->select('nomor_so');
		$this->db->like('nomor_so', $prefix, 'after');
		$this->db->order_by('nomor_so', 'DESC');
		$this->db->limit(1);
		$last_pm = $this->db->get('penjualan_marketplace')->row();
		$num_pm = $last_pm ? ((int) substr($last_pm->nomor_so, -4)) : 0;

		// Cari nomor SO tertinggi dengan prefix MP- di tabel sales_order
		$this->db->select('nomor_so');
		$this->db->like('nomor_so', $prefix, 'after');
		$this->db->order_by('nomor_so', 'DESC');
		$this->db->limit(1);
		$last_so = $this->db->get('sales_order')->row();
		$num_so = $last_so ? ((int) substr($last_so->nomor_so, -4)) : 0;

		$num = max($num_pm, $num_so) + 1;
		$nomor = $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);

		// Proteksi tabrakan: pastikan nomor_so benar-benar belum terpakai di kedua tabel
		while (
			$this->db->where('nomor_so', $nomor)->get('penjualan_marketplace')->num_rows() > 0 ||
			$this->db->where('nomor_so', $nomor)->get('sales_order')->num_rows() > 0
		) {
			$num++;
			$nomor = $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
		}

		return $nomor;
	}

	public function get_stats()
	{
		$total_omset_all = $this->db->select_sum('total')
			->where('status_pesanan !=', 'BATAL')
			->get('penjualan_marketplace')->row()->total ?: 0;

		$start_month = date('Y-m-01');
		$end_month   = date('Y-m-t');

		$penjualan_bulan_ini = $this->db->select_sum('total')
			->where('status_pesanan !=', 'BATAL')
			->where('DATE(tanggal_so) >=', $start_month)
			->where('DATE(tanggal_so) <=', $end_month)
			->get('penjualan_marketplace')->row()->total ?: 0;

		$terbayar_lunas = $this->db->select_sum('penjualan_marketplace.total')
			->join('invoice', 'invoice.so_id = penjualan_marketplace.id')
			->where('invoice.status', 'paid')
			->get('penjualan_marketplace')->row()->total ?: 0;

		$piutang_unpaid = max(0, $total_omset_all - $terbayar_lunas);

		$pesanan_aktif = $this->db->where_in('status', ['draft', 'submitted', 'confirmed'])
			->count_all_results('penjualan_marketplace');

		$proses_packing = $this->db->where('status', 'packing')
			->count_all_results('penjualan_marketplace');

		$siap_kirim = $this->db->where_in('status', ['ready_to_ship', 'shipped'])
			->count_all_results('penjualan_marketplace');

		$pesanan_terkirim = $this->db->where_in('status', ['delivered', 'completed', 'paid'])
			->count_all_results('penjualan_marketplace');

		return [
			'total_omset_all'     => $total_omset_all,
			'penjualan_bulan_ini' => $penjualan_bulan_ini,
			'terbayar_lunas'      => $terbayar_lunas,
			'piutang_unpaid'      => $piutang_unpaid,
			'pesanan_aktif'       => $pesanan_aktif,
			'proses_packing'       => $proses_packing,
			'siap_kirim'          => $siap_kirim,
			'pesanan_terkirim'    => $pesanan_terkirim,
		];
	}

	/**
	 * Sinkronisasi otomatis data pesanan marketplace ke tabel sales_order
	 * Agar transaksi import resi / online shop juga otomatis muncul di daftar Transaksi Penjualan
	 */
	public function sync_to_sales_order($pm_id)
	{
		$pm = $this->db->get_where('penjualan_marketplace', ['id' => $pm_id])->row();
		if (!$pm) {
			return false;
		}

		// Cari record sales_order yang cocok berdasarkan no_pesanan marketplace
		$so = null;
		if (!empty($pm->no_pesanan)) {
			$so = $this->db->get_where('sales_order', ['no_pesanan' => $pm->no_pesanan])->row();
		}
		if (!$so && !empty($pm->nomor_so) && strpos($pm->nomor_so, 'TRX-') === false) {
			$so = $this->db->get_where('sales_order', ['nomor_so' => $pm->nomor_so])->row();
		}

		// Keamanan: JANGAN PERNAH menimpa data transaksi POS atau Transaksi Offline!
		if ($so && in_array(strtolower($so->source ?? ''), ['pos', 'manual', 'offline'])) {
			return false;
		}

		$so_status = strtolower($pm->status ?: 'packing');
		if (!in_array($so_status, ['draft', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])) {
			if (in_array($so_status, ['packing', 'menunggu diproses', 'diproses'])) {
				$so_status = 'processing';
			} elseif (in_array($so_status, ['selesai', 'completed', 'paid'])) {
				$so_status = 'delivered';
			} else {
				$so_status = 'confirmed';
			}
		}

		$so_data = [
			'nomor_so'            => $pm->nomor_so,
			'no_pesanan'          => $pm->no_pesanan,
			'pelanggan_id'        => $pm->pelanggan_id ?: 1,
			'tanggal_so'          => $pm->tanggal_so ?: date('Y-m-d'),
			'status'              => $so_status,
			'status_pesanan'      => $pm->status_pesanan ?: 'Sedang Dikemas',
			'source'              => $pm->source ?: 'shopee',
			'nomor_resi'          => (!empty($pm->nomor_resi) && $pm->nomor_resi !== '-') ? $pm->nomor_resi : (!empty($pm->no_pesanan) ? $pm->no_pesanan : '-'),
			'kurir_ekspedisi'     => $pm->kurir_ekspedisi ?: ($pm->opsi_pengiriman ?: 'JNE/SPX'),
			'opsi_pengiriman'     => $pm->opsi_pengiriman ?: ($pm->kurir_ekspedisi ?: 'JNE/SPX'),
			'tipe_pengiriman'     => $pm->tipe_pengiriman ?: 'Non-COD',
			'pesanan_harus_dikirim_sebelum' => $pm->pesanan_harus_dikirim_sebelum ?: null,
			'tanggal_estimasi_kirim'        => $pm->pesanan_harus_dikirim_sebelum ? date('Y-m-d', strtotime($pm->pesanan_harus_dikirim_sebelum)) : date('Y-m-d', strtotime('+1 day', strtotime($pm->tanggal_so ?: date('Y-m-d')))),
			'waktu_pesanan_dibuat'          => $pm->waktu_pesanan_dibuat ?: ($pm->waktu_pembayaran ?: ($pm->tanggal_so ? $pm->tanggal_so . ' 12:00:00' : date('Y-m-d H:i:s'))),
			'waktu_pembayaran'              => $pm->waktu_pembayaran ?: ($pm->tanggal_so ? $pm->tanggal_so . ' 12:00:00' : date('Y-m-d H:i:s')),
			'username_pembeli'    => $pm->username_pembeli ?: '',
			'nama_penerima'       => $pm->nama_penerima ?: '',
			'no_telepon'          => $pm->no_telepon ?: '',
			'alamat_pengiriman'   => $pm->alamat_pengiriman ?: '',
			'nama_pengirim'       => !empty($pm->nama_pengirim) ? $pm->nama_pengirim : '',
			'no_telepon_pengirim' => !empty($pm->no_telepon_pengirim) ? $pm->no_telepon_pengirim : '',
			'alamat_pengirim'     => !empty($pm->alamat_pengirim) ? $pm->alamat_pengirim : '',
			'kota_kabupaten'      => $pm->kota_kabupaten ?: '',
			'provinsi'            => $pm->provinsi ?: '',
			'sku_induk'           => $pm->sku_induk ?: '-',
			'nama_produk_marketplace' => $pm->nama_produk_marketplace ?: '',
			'nama_variasi'        => $pm->nama_variasi ?: '',
			'subtotal'            => (float)$pm->subtotal,
			'total'               => (float)$pm->total,
			'total_pembayaran'    => (float)$pm->total,
			'catatan'             => $pm->catatan ?: '',
			'updated_at'          => date('Y-m-d H:i:s'),
		];

		if ($so) {
			$this->db->where('id', $so->id)->update('sales_order', $so_data);
			$so_id = $so->id;
		} else {
			// Pastikan nomor_so belum pernah dipakai oleh transaksi lain di sales_order
			$collision = $this->db->get_where('sales_order', ['nomor_so' => $so_data['nomor_so']])->row();
			if ($collision) {
				$new_so_num = $this->generate_nomor();
				$so_data['nomor_so'] = $new_so_num;
				$this->db->where('id', $pm->id)->update('penjualan_marketplace', ['nomor_so' => $new_so_num]);
			}

			$so_data['created_by'] = $pm->created_by ?: 'administrator';
			$so_data['created_at'] = $pm->created_at ?: date('Y-m-d H:i:s');
			$this->db->insert('sales_order', $so_data);
			$so_id = $this->db->insert_id();
		}

		if ($so_id) {
			$pm_items = $this->db->get_where('penjualan_marketplace_item', ['penjualan_marketplace_id' => $pm_id])->result();
			$this->db->where('so_id', $so_id)->delete('sales_order_item');

			foreach ($pm_items as $pmi) {
				$this->db->insert('sales_order_item', [
					'so_id'         => $so_id,
					'produk_id'     => $pmi->produk_id ?: 0,
					'sku'           => $pmi->sku ?: '-',
					'nama_variasi'  => $pmi->nama_variasi ?: 'Default',
					'qty'           => max(1, (float)$pmi->qty),
					'satuan'        => $pmi->satuan ?: 'pcs',
					'harga_satuan'  => (float)$pmi->harga_satuan,
					'diskon_persen' => (float)$pmi->diskon_persen,
					'diskon_nominal'=> (float)$pmi->diskon_nominal,
					'subtotal'      => (float)$pmi->subtotal,
					'catatan'       => $pmi->catatan ?: '',
				]);
			}
		}

		// Sinkronisasi otomatis label follow-up CRM untuk pesanan marketplace / import resi
		if (file_exists(APPPATH . '../modules/crm/models/Model_crm.php')) {
			$this->load->model('crm/Model_crm');
			$this->Model_crm->generate_labels_for_order('penjualan_marketplace', $pm_id);
		}

		return $so_id;
	}

	public function delete_marketplace_order_cascade($id)
	{
		$so = $this->db->get_where('penjualan_marketplace', ['id' => $id])->row();
		if (!$so) return false;

		$nomor_so     = $so->nomor_so;
		$no_pesanan   = $so->no_pesanan;
		$nomor_resi   = $so->nomor_resi;
		$pelanggan_id = intval($so->pelanggan_id);

		// Ambil semua produk_id dari pesanan marketplace sebelum item dihapus
		$check_product_ids = [];
		$order_items = $this->db->get_where('penjualan_marketplace_item', ['penjualan_marketplace_id' => $id])->result();
		foreach ($order_items as $oi) {
			if (!empty($oi->produk_id)) {
				$check_product_ids[] = intval($oi->produk_id);
			}
		}

		// 1. Hapus Item Penjualan Marketplace
		$this->db->delete('penjualan_marketplace_item', ['penjualan_marketplace_id' => $id]);

		// 2. Cari semua matching sales_order (sinkronisasi)
		$matching_so_ids = [];
		$this->db->group_start();
		$has_so_cond = false;
		if (!empty($nomor_so)) {
			$this->db->where('nomor_so', $nomor_so);
			$has_so_cond = true;
		}
		if (!empty($no_pesanan)) {
			if ($has_so_cond) $this->db->or_where('no_pesanan', $no_pesanan);
			else { $this->db->where('no_pesanan', $no_pesanan); $has_so_cond = true; }
		}
		if (!empty($nomor_resi)) {
			if ($has_so_cond) $this->db->or_where('nomor_resi', $nomor_resi);
			else { $this->db->where('nomor_resi', $nomor_resi); $has_so_cond = true; }
		}
		$this->db->group_end();

		if ($has_so_cond) {
			$matching_sos = $this->db->get('sales_order')->result();
			foreach ($matching_sos as $m_so) {
				$matching_so_ids[] = intval($m_so->id);
				$so_items = $this->db->get_where('sales_order_item', ['so_id' => $m_so->id])->result();
				foreach ($so_items as $soi) {
					if (!empty($soi->produk_id)) {
						$check_product_ids[] = intval($soi->produk_id);
					}
				}
				$this->db->delete('sales_order_item', ['so_id' => $m_so->id]);
				// Hapus invoice jika ada
				$invoices = $this->db->get_where('invoice', ['so_id' => $m_so->id])->result();
				foreach ($invoices as $inv) {
					$this->db->delete('invoice_item', ['invoice_id' => $inv->id]);
					// Hapus pembayaran piutang dan piutang linked ke invoice
					$pu_inv = $this->db->get_where('piutang_usaha', ['invoice_id' => $inv->id])->result();
					foreach ($pu_inv as $pu) {
						$this->db->delete('pembayaran_piutang', ['piutang_id' => $pu->id]);
					}
					$this->db->delete('piutang_usaha', ['invoice_id' => $inv->id]);
					$this->db->delete('invoice', ['id' => $inv->id]);
				}
				// Hapus piutang langsung dari SO jika ada
				$pu_so = $this->db->get_where('piutang_usaha', ['so_id' => $m_so->id])->result();
				foreach ($pu_so as $pu) {
					$this->db->delete('pembayaran_piutang', ['piutang_id' => $pu->id]);
				}
				$this->db->delete('piutang_usaha', ['so_id' => $m_so->id]);
				$this->db->delete('sales_order', ['id' => $m_so->id]);
			}
		}

		// 3. Hapus CRM Transaction Followup Labels & Notes terkait pesanan ini
		$this->db->group_start();
		$this->db->where("(order_table = 'penjualan_marketplace' AND order_id = " . intval($id) . ")");
		if (!empty($no_pesanan)) {
			$this->db->or_where('no_pesanan', $no_pesanan);
		}
		if (!empty($nomor_resi)) {
			$this->db->or_where('nomor_resi', $nomor_resi);
		}
		foreach ($matching_so_ids as $m_id) {
			$this->db->or_where("(order_table = 'sales_order' AND order_id = " . intval($m_id) . ")");
		}
		$this->db->group_end();
		$labels = $this->db->get('crm_transaction_followup_labels')->result();

		if (!empty($labels)) {
			$label_ids = array_column($labels, 'id');
			$this->db->where_in('followup_label_id', $label_ids)->delete('crm_followup_notes');
			$this->db->where_in('label_id', $label_ids)->delete('crm_chat_history');
			$this->db->where_in('id', $label_ids)->delete('crm_transaction_followup_labels');
		}

		// 4. Hapus record penjualan_marketplace utama
		$remove = $this->db->delete('penjualan_marketplace', ['id' => $id]);

		// 5. Cek & Hapus Pelanggan jika sudah tidak memiliki transaksi lain di sistem
		if ($pelanggan_id > 1) {
			$customer = $this->db->get_where('pelanggan', ['id' => $pelanggan_id])->row();
			if ($customer && !in_array(strtoupper($customer->kode_pelanggan), ['CUS-MARKETPLACE', 'CUS-DEFAULT', 'UMUM', 'DEFAULT'])) {
				$rem_pm = $this->db->where('pelanggan_id', $pelanggan_id)->count_all_results('penjualan_marketplace');
				$rem_so = $this->db->where('pelanggan_id', $pelanggan_id)->count_all_results('sales_order');

				if ($rem_pm == 0 && $rem_so == 0) {
					// Hapus label CRM sisa pelanggan ini jika ada
					$cust_labels = $this->db->get_where('crm_transaction_followup_labels', ['customer_pelanggan_id' => $pelanggan_id])->result();
					if (!empty($cust_labels)) {
						$c_label_ids = array_column($cust_labels, 'id');
						$this->db->where_in('followup_label_id', $c_label_ids)->delete('crm_followup_notes');
						$this->db->where_in('label_id', $c_label_ids)->delete('crm_chat_history');
						$this->db->where_in('id', $c_label_ids)->delete('crm_transaction_followup_labels');
					}
					// Hapus riwayat chat pelanggan jika ada
					if (!empty($customer->no_telp)) {
						$clean_phone = preg_replace('/[^0-9]/', '', $customer->no_telp);
						if (!empty($clean_phone)) {
							$this->db->like('customer_phone', $clean_phone)->delete('crm_chat_history');
						}
					}
					$this->db->delete('pelanggan', ['id' => $pelanggan_id]);
				}
			}
		}

		// 6. Cek & Bersihkan Produk Auto-Created yang menjadi orphan (tidak ada transaksi lain sama sekali)
		$this->cleanup_orphan_marketplace_products($check_product_ids);

		return $remove;
	}

	public function delete_from_sales_order($nomor_so, $no_pesanan = '')
	{
		if (empty($nomor_so) && empty($no_pesanan)) return false;

		$this->db->group_start();
		if (!empty($nomor_so)) {
			$this->db->where('nomor_so', $nomor_so);
		}
		if (!empty($no_pesanan)) {
			$this->db->or_where('no_pesanan', $no_pesanan);
		}
		$this->db->group_end();
		$so = $this->db->get('sales_order')->row();

		if ($so) {
			$pelanggan_id = intval($so->pelanggan_id);

			$check_product_ids = [];
			$so_items = $this->db->get_where('sales_order_item', ['so_id' => $so->id])->result();
			foreach ($so_items as $soi) {
				if (!empty($soi->produk_id)) {
					$check_product_ids[] = intval($soi->produk_id);
				}
			}

			$this->db->delete('sales_order_item', ['so_id' => $so->id]);

			// Hapus invoice dan piutang jika ada
			$invoices = $this->db->get_where('invoice', ['so_id' => $so->id])->result();
			foreach ($invoices as $inv) {
				$this->db->delete('invoice_item', ['invoice_id' => $inv->id]);
				$pu_inv = $this->db->get_where('piutang_usaha', ['invoice_id' => $inv->id])->result();
				foreach ($pu_inv as $pu) {
					$this->db->delete('pembayaran_piutang', ['piutang_id' => $pu->id]);
				}
				$this->db->delete('piutang_usaha', ['invoice_id' => $inv->id]);
				$this->db->delete('invoice', ['id' => $inv->id]);
			}
			$pu_so = $this->db->get_where('piutang_usaha', ['so_id' => $so->id])->result();
			foreach ($pu_so as $pu) {
				$this->db->delete('pembayaran_piutang', ['piutang_id' => $pu->id]);
			}
			$this->db->delete('piutang_usaha', ['so_id' => $so->id]);
			$this->db->delete('sales_order', ['id' => $so->id]);

			if (!empty($no_pesanan)) {
				$labels = $this->db->get_where('crm_transaction_followup_labels', ['no_pesanan' => $no_pesanan])->result();
				if (!empty($labels)) {
					$label_ids = array_column($labels, 'id');
					$this->db->where_in('followup_label_id', $label_ids)->delete('crm_followup_notes');
					$this->db->where_in('label_id', $label_ids)->delete('crm_chat_history');
					$this->db->where_in('id', $label_ids)->delete('crm_transaction_followup_labels');
				}
			}

			// Cek pelanggan jika tidak punya order lain
			if ($pelanggan_id > 1) {
				$customer = $this->db->get_where('pelanggan', ['id' => $pelanggan_id])->row();
				if ($customer && !in_array(strtoupper($customer->kode_pelanggan), ['CUS-MARKETPLACE', 'CUS-DEFAULT', 'UMUM', 'DEFAULT'])) {
					$rem_pm = $this->db->where('pelanggan_id', $pelanggan_id)->count_all_results('penjualan_marketplace');
					$rem_so = $this->db->where('pelanggan_id', $pelanggan_id)->count_all_results('sales_order');
					if ($rem_pm == 0 && $rem_so == 0) {
						$cust_labels = $this->db->get_where('crm_transaction_followup_labels', ['customer_pelanggan_id' => $pelanggan_id])->result();
						if (!empty($cust_labels)) {
							$c_label_ids = array_column($cust_labels, 'id');
							$this->db->where_in('followup_label_id', $c_label_ids)->delete('crm_followup_notes');
							$this->db->where_in('label_id', $c_label_ids)->delete('crm_chat_history');
							$this->db->where_in('id', $c_label_ids)->delete('crm_transaction_followup_labels');
						}
						if (!empty($customer->no_telp)) {
							$clean_phone = preg_replace('/[^0-9]/', '', $customer->no_telp);
							if (!empty($clean_phone)) {
								$this->db->like('customer_phone', $clean_phone)->delete('crm_chat_history');
							}
						}
						$this->db->delete('pelanggan', ['id' => $pelanggan_id]);
					}
				}
			}

			// Bersihkan orphan produk
			$this->cleanup_orphan_marketplace_products($check_product_ids);

			return true;
		}
		return false;
	}

	/**
	 * Thorough cascade cleanup of auto-generated products created during resi/marketplace imports.
	 * If a product was auto-created and no longer has any associated orders/items in the ERP,
	 * it removes its inventory records and deletes it from `produk` and `kategori_produk`.
	 */
	public function cleanup_orphan_marketplace_products($product_ids = [])
	{
		$cat = $this->db->get_where('kategori_produk', ['nama_kategori' => 'Produk Marketplace (Import Resi)'])->row();
		$cat_id = $cat ? intval($cat->id) : 0;

		$this->db->select('p.id, p.kode_produk, p.kategori_id, p.created_by');
		$this->db->from('produk p');

		$this->db->group_start();
		$this->db->where('p.created_by', 'import_resi');
		if ($cat_id > 0) {
			$this->db->or_where('p.kategori_id', $cat_id);
		}
		$this->db->or_like('p.kode_produk', 'MP-', 'after');
		$this->db->group_end();

		if (!empty($product_ids)) {
			$product_ids = array_unique(array_filter(array_map('intval', (array)$product_ids)));
			if (!empty($product_ids)) {
				$this->db->where_in('p.id', $product_ids);
			}
		}

		$candidates = $this->db->get()->result();
		if (empty($candidates)) return 0;

		$deleted_count = 0;
		foreach ($candidates as $prod) {
			$p_id = intval($prod->id);

			// Check all transaction tables
			$has_pm = $this->db->where('produk_id', $p_id)->count_all_results('penjualan_marketplace_item');
			if ($has_pm > 0) continue;

			$has_so = $this->db->where('produk_id', $p_id)->count_all_results('sales_order_item');
			if ($has_so > 0) continue;

			$has_po = $this->db->where('produk_id', $p_id)->count_all_results('purchase_order_item');
			if ($has_po > 0) continue;

			$has_inv = $this->db->where('produk_id', $p_id)->count_all_results('invoice_item');
			if ($has_inv > 0) continue;

			$has_ret_jual = $this->db->where('produk_id', $p_id)->count_all_results('retur_penjualan_item');
			if ($has_ret_jual > 0) continue;

			$has_ret_beli = $this->db->where('produk_id', $p_id)->count_all_results('retur_pembelian_item');
			if ($has_ret_beli > 0) continue;

			$has_so_item = $this->db->where('produk_id', $p_id)->count_all_results('stock_opname_item');
			if ($has_so_item > 0) continue;

			// Safe to delete! Clean up child tables
			$this->db->delete('stok', ['produk_id' => $p_id]);
			$this->db->delete('stok_log', ['produk_id' => $p_id]);
			$this->db->delete('stok_rusak', ['produk_id' => $p_id]);
			$this->db->delete('riwayat_harga_beli', ['produk_id' => $p_id]);
			$this->db->delete('produk_harga_log', ['produk_id' => $p_id]);
			$this->db->delete('harga_pelanggan', ['produk_id' => $p_id]);

			// Delete product
			$this->db->delete('produk', ['id' => $p_id]);
			$deleted_count++;
		}

		return $deleted_count;
	}

	/**
	 * Standarisasi nomor telepon/WA ke format standar Indonesia (08...)
	 */
	public function normalize_phone($phone)
	{
		$clean = preg_replace('/[^0-9]/', '', (string)$phone);
		if (empty($clean)) return '';

		if (substr($clean, 0, 2) === '62') {
			$clean = '0' . substr($clean, 2);
		} elseif (substr($clean, 0, 1) === '8') {
			$clean = '0' . $clean;
		}
		return $clean;
	}

	/**
	 * Cek duplikasi nomor pesanan dan/atau nomor resi
	 */
	public function check_order_duplicate($no_pesanan, $nomor_resi = null, $exclude_id = null)
	{
		$no_pesanan = trim((string)$no_pesanan);
		$nomor_resi = trim((string)$nomor_resi);

		if (!empty($no_pesanan)) {
			$this->db->where('no_pesanan', $no_pesanan);
			if ($exclude_id) {
				$this->db->where('id !=', $exclude_id);
			}
			$dup = $this->db->get('penjualan_marketplace')->row();
			if ($dup) {
				return [
					'duplicate' => true,
					'type'      => 'no_pesanan',
					'message'   => "Nomor Pesanan '{$no_pesanan}' sudah terdaftar pada tanggal " . date('d/m/Y', strtotime($dup->created_at ?: $dup->tanggal_so)) . " (ID: #{$dup->id})",
					'data'      => $dup
				];
			}
		}

		if (!empty($nomor_resi) && !preg_match('/^SPX\d{10}$/', $nomor_resi)) {
			$this->db->where('nomor_resi', $nomor_resi);
			if ($exclude_id) {
				$this->db->where('id !=', $exclude_id);
			}
			$dup_resi = $this->db->get('penjualan_marketplace')->row();
			if ($dup_resi) {
				return [
					'duplicate' => true,
					'type'      => 'nomor_resi',
					'message'   => "Nomor Resi '{$nomor_resi}' sudah digunakan pada pesanan '{$dup_resi->no_pesanan}' (ID: #{$dup_resi->id})",
					'data'      => $dup_resi
				];
			}
		}

		return ['duplicate' => false];
	}

	/**
	 * Cari atau daftarkan Master Data Pelanggan secara otomatis
	 */
	public function resolve_customer($data = [])
	{
		$phone_clean      = $this->normalize_phone($data['no_telepon'] ?? '');
		$username_pembeli = trim($data['username_pembeli'] ?? '');
		$nama_penerima    = trim($data['nama_penerima'] ?? '');
		$alamat           = trim($data['alamat_pengiriman'] ?? '');
		$kota             = trim($data['kota_kabupaten'] ?? '');
		$provinsi         = trim($data['provinsi'] ?? '');
		$source           = trim($data['source'] ?? 'marketplace');

		$customer = null;

		// 1. Prioritas Utama: Cari berdasarkan No. Telepon / WA (jika valid >= 8 digit)
		if (!empty($phone_clean) && strlen($phone_clean) >= 8) {
			$customer = $this->db->group_start()
				->where('telepon', $phone_clean)
				->or_where('no_telp', $phone_clean)
				->group_end()
				->order_by('id', 'ASC')
				->get('pelanggan')->row();
		}

		// 2. Prioritas Kedua: Cari berdasarkan Username Pembeli atau Nama Penerima
		if (!$customer && !empty($username_pembeli)) {
			$customer = $this->db->where('LOWER(nama_pelanggan)', strtolower($username_pembeli))
				->get('pelanggan')->row();
		}
		if (!$customer && !empty($nama_penerima) && !in_array(strtolower($nama_penerima), ['customer', 'pembeli', 'pelanggan umum', '-'])) {
			$customer = $this->db->where('LOWER(nama_pelanggan)', strtolower($nama_penerima))
				->get('pelanggan')->row();
		}

		// Jika Pelanggan Ditemukan -> Gunakan pelanggan_id eksisting & perbarui info jika ada yang kosong
		if ($customer) {
			$update_fields = [];
			if (empty($customer->telepon) && !empty($phone_clean)) {
				$update_fields['telepon'] = $phone_clean;
				$update_fields['no_telp'] = $phone_clean;
			}
			if (empty($customer->alamat) && !empty($alamat)) {
				$update_fields['alamat'] = $alamat;
			}
			if (empty($customer->kota) && !empty($kota)) {
				$update_fields['kota'] = $kota;
			}
			if (!empty($update_fields)) {
				$update_fields['updated_at'] = date('Y-m-d H:i:s');
				$this->db->where('id', $customer->id)->update('pelanggan', $update_fields);
			}

			return [
				'pelanggan_id' => (int) $customer->id,
				'is_new'       => false,
				'customer'     => $customer
			];
		}

		// Jika Pelanggan Baru -> Buat record baru di Master Data Pelanggan
		$max_cust = $this->db->select_max('id')->get('pelanggan')->row();
		$next_num = ($max_cust && $max_cust->id) ? ((int)$max_cust->id + 1) : 1;
		$kode = sprintf('CUST-%04d', $next_num);
		while ($this->db->where('kode_pelanggan', $kode)->get('pelanggan')->num_rows() > 0) {
			$next_num++;
			$kode = sprintf('CUST-%04d', $next_num);
		}

		$nama_cust = !empty($nama_penerima) ? $nama_penerima : (!empty($username_pembeli) ? $username_pembeli : 'Pelanggan ' . ucfirst($source));

		$new_cust_data = [
			'kode_pelanggan' => $kode,
			'nama_pelanggan' => $nama_cust,
			'kontak_person'  => !empty($username_pembeli) ? $username_pembeli : $nama_cust,
			'source'         => strtolower($source),
			'telepon'        => $phone_clean,
			'no_telp'        => $phone_clean,
			'alamat'         => !empty($alamat) ? $alamat : 'Pelanggan Online Shop',
			'kota'           => !empty($kota) ? $kota : '',
			'tipe_pelanggan' => 'retail',
			'tier_pelanggan' => 'RETAIL',
			'status'         => 'aktif',
			'created_by'     => get_user_data('username') ?: 'admin',
			'created_at'     => date('Y-m-d H:i:s')
		];

		$this->db->insert('pelanggan', $new_cust_data);
		$new_id = (int) $this->db->insert_id();

		return [
			'pelanggan_id' => $new_id,
			'is_new'       => true,
			'customer'     => (object) array_merge(['id' => $new_id], $new_cust_data)
		];
	}

	/**
	 * Cari atau daftarkan Master Data Produk secara otomatis jika belum ada
	 */
	public function resolve_product($item_data = [])
	{
		$prod_id  = intval($item_data['produk_id'] ?? 0);
		$sku      = trim($item_data['sku'] ?? '');
		$nama     = trim($item_data['nama_produk'] ?? '');
		$variasi  = trim($item_data['variasi'] ?? '');
		$harga    = (float) ($item_data['harga_satuan'] ?? 0);

		// 1. Jika produk_id sudah dipilih dan valid di Master Produk
		if ($prod_id > 0) {
			$p = $this->db->get_where('produk', ['id' => $prod_id])->row();
			if ($p) return $p->id;
		}

		// 2. Cari berdasarkan Kode SKU di tabel produk
		if (!empty($sku)) {
			$p_sku = $this->db->where('kode_produk', $sku)->get('produk')->row();
			if ($p_sku) return $p_sku->id;
		}

		// 3. Cari berdasarkan Nama Produk yang persis sama
		if (!empty($nama)) {
			$p_name = $this->db->where('LOWER(nama_produk)', strtolower($nama))->get('produk')->row();
			if ($p_name) return $p_name->id;
		}

		// 4. Jika tetap tidak ada dan nama produk terisi -> Daftarkan ke Master Data Produk
		if (!empty($nama)) {
			if (empty($sku)) {
				$max_p = $this->db->select_max('id')->get('produk')->row();
				$next_p = ($max_p && $max_p->id) ? ((int)$max_p->id + 1) : 1;
				$sku = sprintf('MP-%04d', $next_p);
				while ($this->db->where('kode_produk', $sku)->get('produk')->num_rows() > 0) {
					$next_p++;
					$sku = sprintf('MP-%04d', $next_p);
				}
			}

			// Kategori default
			$default_kat = $this->db->select('id')->get('kategori_produk')->row();
			$kat_id = $default_kat ? $default_kat->id : 1;

			// Satuan default
			$default_sat = $this->db->select('id')->get('satuan')->row();
			$sat_id = $default_sat ? $default_sat->id : 1;

			$full_nama = $nama . (!empty($variasi) ? " ({$variasi})" : '');

			$new_prod = [
				'kode_produk'  => $sku,
				'nama_produk'  => $full_nama,
				'kategori_id'  => $kat_id,
				'satuan_id'    => $sat_id,
				'harga_beli'   => 0,
				'harga_jual'   => $harga,
				'stok_minimum' => 5,
				'status'       => 'aktif',
				'deskripsi'    => 'Dibuat otomatis dari Penjualan Marketplace',
				'created_by'   => get_user_data('username') ?: 'marketplace',
				'created_at'   => date('Y-m-d H:i:s'),
			];

			$this->db->insert('produk', $new_prod);
			$new_prod_id = (int) $this->db->insert_id();

			// Inisialisasi stok 0 untuk produk baru
			$this->db->insert('stok', [
				'produk_id'  => $new_prod_id,
				'qty'        => 0,
				'qty_rusak'  => 0,
				'updated_at' => date('Y-m-d H:i:s')
			]);

			return $new_prod_id;
		}

		return 0;
	}

	/**
	 * Hapus pesanan marketplace secara menyeluruh (Cascade Delete)
	 * Menghapus seluruh item produk terkait pada nomor pesanan yang sama,
	 * serta sinkronisasi sales_order, sales_order_item, dan label CRM.
	 *
	 * @param int|array $id_or_array
	 * @return array
	 */
	public function delete_order_cascade($id_or_array)
	{
		$ids = array_filter(array_map('intval', (array)$id_or_array));
		if (empty($ids)) {
			return ['success' => false, 'message' => 'ID pesanan tidak valid atau kosong.'];
		}

		$orders = $this->db->where_in('id', $ids)->get('penjualan_marketplace')->result();
		if (empty($orders)) {
			return ['success' => false, 'message' => 'Data pesanan tidak ditemukan di database.'];
		}

		$no_pesanans = [];
		$nomor_sos   = [];
		foreach ($orders as $o) {
			if (!empty($o->no_pesanan)) $no_pesanans[] = $o->no_pesanan;
			if (!empty($o->nomor_so))   $nomor_sos[]   = $o->nomor_so;
		}

		// Kumpulkan seluruh ID penjualan_marketplace yang memiliki nomor pesanan yang sama
		$all_pm_ids = $ids;
		if (!empty($no_pesanans)) {
			$same_pm = $this->db->where_in('no_pesanan', $no_pesanans)->get('penjualan_marketplace')->result();
			foreach ($same_pm as $spm) {
				$all_pm_ids[] = (int)$spm->id;
			}
			$all_pm_ids = array_values(array_unique($all_pm_ids));
		}

		// Hitung total item produk di penjualan_marketplace_item yang akan dihapus
		$total_items = $this->db->where_in('penjualan_marketplace_id', $all_pm_ids)->count_all_results('penjualan_marketplace_item');

		// Cari record transaksi sinkronisasi di sales_order
		$so_ids = [];
		if (!empty($no_pesanans)) {
			$sos = $this->db->where_in('no_pesanan', $no_pesanans)->get('sales_order')->result();
			foreach ($sos as $s) {
				$so_ids[] = (int)$s->id;
			}
		}
		if (!empty($nomor_sos)) {
			$sos2 = $this->db->where_in('nomor_so', $nomor_sos)->get('sales_order')->result();
			foreach ($sos2 as $s) {
				$so_ids[] = (int)$s->id;
			}
		}
		$so_ids = array_values(array_unique($so_ids));

		$this->db->trans_start();

		// 1. Hapus seluruh item produk di penjualan_marketplace_item
		$this->db->where_in('penjualan_marketplace_id', $all_pm_ids)->delete('penjualan_marketplace_item');

		// 2. Hapus transaksi sinkronisasi di sales_order & sales_order_item
		if (!empty($so_ids)) {
			$this->db->where_in('so_id', $so_ids)->delete('sales_order_item');
			$this->db->where_in('id', $so_ids)->delete('sales_order');
		}

		// 3. Bersihkan label CRM & interaksi chat/follow-up terkait
		$crm_labels = [];
		$crm1 = $this->db->where('order_table', 'penjualan_marketplace')
			->where_in('order_id', $all_pm_ids)
			->get('crm_transaction_followup_labels')->result();
		if (!empty($crm1)) {
			$crm_labels = array_merge($crm_labels, $crm1);
		}
		if (!empty($so_ids)) {
			$crm2 = $this->db->where('order_table', 'sales_order')
				->where_in('order_id', $so_ids)
				->get('crm_transaction_followup_labels')->result();
			if (!empty($crm2)) {
				$crm_labels = array_merge($crm_labels, $crm2);
			}
		}
		if (!empty($no_pesanans)) {
			$crm3 = $this->db->where_in('no_pesanan', $no_pesanans)
				->get('crm_transaction_followup_labels')->result();
			if (!empty($crm3)) {
				$crm_labels = array_merge($crm_labels, $crm3);
			}
		}

		if (!empty($crm_labels)) {
			$label_ids = array_values(array_unique(array_map(function($l) { return (int)$l->id; }, $crm_labels)));
			if (!empty($label_ids)) {
				$this->db->where_in('label_id', $label_ids)->delete('crm_chat_history');
				$this->db->where_in('followup_label_id', $label_ids)->delete('crm_followup_notes');
				$this->db->where_in('followup_label_id', $label_ids)->delete('crm_broadcast_logs');
				$this->db->where_in('id', $label_ids)->delete('crm_transaction_followup_labels');
			}
		}

		// 4. Hapus header penjualan_marketplace
		$this->db->where_in('id', $all_pm_ids)->delete('penjualan_marketplace');

		$this->db->trans_complete();

		$status = ($this->db->trans_status() !== FALSE);

		return [
			'success'     => $status,
			'order_count' => count($all_pm_ids),
			'item_count'  => $total_items,
			'no_pesanans' => array_values(array_unique($no_pesanans))
		];
	}


	/**
	 * Auto-create master produk ketika produk baru ditemukan dari import atau scan resi
	 *
	 * @param string $nama_produk
	 * @param string $sku
	 * @param float $harga
	 * @param string $variasi
	 * @param string $source
	 * @param array &$prod_by_code
	 * @param array &$prod_by_name
	 * @return object|null
	 */
	public function get_or_create_product($nama_produk, $sku = '', $harga = 0, $variasi = '', $source = 'marketplace', &$prod_by_code = [], &$prod_by_name = [])
	{
		$nama_produk = trim((string)$nama_produk);
		$sku = trim((string)$sku);
		$harga = (float)$harga;
		$variasi = trim((string)$variasi);

		if (empty($nama_produk) && empty($sku)) {
			$nama_produk = 'Produk ' . ucfirst($source) . ' ' . date('d-m-Y');
		}

		// 1. Cek dari in-memory cache
		if (!empty($sku) && isset($prod_by_code[strtolower($sku)])) {
			return $prod_by_code[strtolower($sku)];
		}
		if (!empty($nama_produk) && isset($prod_by_name[strtolower($nama_produk)])) {
			return $prod_by_name[strtolower($nama_produk)];
		}

		// 2. Cek dari database
		$prod = null;
		if (!empty($sku)) {
			$prod = $this->db->get_where('produk', ['kode_produk' => $sku])->row();
		}
		if (!$prod && !empty($nama_produk)) {
			$prod = $this->db->get_where('produk', ['nama_produk' => $nama_produk])->row();
		}
		if (!$prod && !empty($nama_produk)) {
			$prod = $this->db->like('nama_produk', $nama_produk)->get('produk')->row();
		}

		if ($prod) {
			if (!empty($sku)) $prod_by_code[strtolower($sku)] = $prod;
			if (!empty($nama_produk)) $prod_by_name[strtolower($nama_produk)] = $prod;
			return $prod;
		}

		// 3. Produk Belum Ada -> Auto Create ke tabel `produk`
		$final_kode = $sku;
		if (empty($final_kode) || $this->db->get_where('produk', ['kode_produk' => $final_kode])->num_rows() > 0) {
			$prefix = 'PRD-' . strtoupper(substr($source, 0, 3)) . '-' . date('ym');
			$seq = 1;
			do {
				$final_kode = $prefix . '-' . str_pad($seq++, 4, '0', STR_PAD_LEFT);
			} while ($this->db->get_where('produk', ['kode_produk' => $final_kode])->num_rows() > 0);
		}

		$final_nama = $nama_produk;
		if (!empty($variasi) && stripos($final_nama, $variasi) === false) {
			$final_nama .= ' (' . $variasi . ')';
		}
		$final_nama = substr($final_nama, 0, 200);

		// Default kategori ID 16 (Produk Marketplace) atau fallback ke kategori pertama
		$kategori_id = 16;
		$kat_exists = $this->db->get_where('kategori_produk', ['id' => $kategori_id])->row();
		if (!$kat_exists) {
			$first_kat = $this->db->order_by('id', 'ASC')->get('kategori_produk')->row();
			$kategori_id = $first_kat ? $first_kat->id : null;
		}

		// Default satuan ID 1 (Pcs) atau fallback ke satuan pertama
		$satuan_id = 1;
		$sat_exists = $this->db->get_where('satuan', ['id' => $satuan_id])->row();
		if (!$sat_exists) {
			$first_sat = $this->db->order_by('id', 'ASC')->get('satuan')->row();
			$satuan_id = $first_sat ? $first_sat->id : null;
		}

		$harga_jual = ($harga > 0) ? $harga : 50000;
		$harga_beli = round($harga_jual * 0.7, 2);

		$new_prod_data = [
			'kode_produk'       => $final_kode,
			'nama_produk'       => $final_nama,
			'kategori_id'       => $kategori_id,
			'satuan_id'         => $satuan_id,
			'harga_beli'        => $harga_beli,
			'harga_jual'        => $harga_jual,
			'harga_jual_retail' => $harga_jual,
			'stok_minimum'      => 0,
			'status'            => 'aktif',
			'metode_stok'       => 'FIFO',
			'created_by'        => get_user_data('username') ?: 'import_marketplace',
			'created_at'        => date('Y-m-d H:i:s')
		];

		$this->db->insert('produk', $new_prod_data);
		$new_id = $this->db->insert_id();

		if ($new_id) {
			// Inisialisasi stok fisik 0
			$this->db->insert('stok', [
				'produk_id'  => $new_id,
				'rak_id'     => 7, // default rak
				'qty'        => 0,
				'qty_rusak'  => 0,
				'updated_at' => date('Y-m-d H:i:s')
			]);

			$created_prod = $this->db->get_where('produk', ['id' => $new_id])->row();
			if ($created_prod) {
				if (!empty($sku)) $prod_by_code[strtolower($sku)] = $created_prod;
				$prod_by_code[strtolower($final_kode)] = $created_prod;
				if (!empty($nama_produk)) $prod_by_name[strtolower($nama_produk)] = $created_prod;
				$prod_by_name[strtolower($final_nama)] = $created_prod;
				return $created_prod;
			}
		}

		return null;
	}
}

/* End of file Model_penjualan_marketplace.php */
