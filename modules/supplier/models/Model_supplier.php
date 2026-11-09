<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Model_supplier extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'supplier';
	private $field_search 	= ['kode_supplier', 'nama_supplier', 'kontak_person', 'telepon', 'no_telp', 'email', 'kota'];

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
		 );

		parent::__construct($config);
	}

	public function count_all($q = '', $field = '')
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
	        foreach ($this->field_search as $f) {
	            if ($iterasi == 1) {
	                $where .= "(" . $f . " LIKE '%" . $q . "%' ";
	            } else if ($iterasi == $num) {
	                $where .= "OR " . $f . " LIKE '%" . $q . "%') ";
	            } else {
	                $where .= "OR " . $f . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }
        } else {
        	$where .= "(" . $field . " LIKE '%" . $q . "%' )";
        }

        $this->db->where($where);
		$query = $this->db->get($this->table_name);

		return $query->num_rows();
	}

	public function get($q = '', $field = '', $limit = 0, $offset = 0)
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
	        foreach ($this->field_search as $f) {
	            if ($iterasi == 1) {
	                $where .= "(" . $f . " LIKE '%" . $q . "%' ";
	            } else if ($iterasi == $num) {
	                $where .= "OR " . $f . " LIKE '%" . $q . "%') ";
	            } else {
	                $where .= "OR " . $f . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }
        } else {
        	$where .= "(" . $field . " LIKE '%" . $q . "%' )";
        }

        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by($this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function generate_kode()
	{
		$max_id_row = $this->db->select_max('id')->get($this->table_name)->row();
		$next_num = ($max_id_row && $max_id_row->id) ? ((int)$max_id_row->id + 1) : 1;
		$kode = 'SUP-' . str_pad($next_num, 4, '0', STR_PAD_LEFT);

		while ($this->db->where('kode_supplier', $kode)->get($this->table_name)->num_rows() > 0) {
			$next_num++;
			$kode = 'SUP-' . str_pad($next_num, 4, '0', STR_PAD_LEFT);
		}
		return $kode;
	}

	/**
	 * Get riwayat harga beli per supplier/produk
	 */
	public function get_riwayat_harga($supplier_id = null, $produk_id = null)
	{
		$this->db->select('purchase_order_item.*, purchase_order.nomor_po, purchase_order.tanggal_po, supplier.nama_supplier, produk.nama_produk, produk.kode_produk')
			->from('purchase_order_item')
			->join('purchase_order', 'purchase_order.id = purchase_order_item.po_id')
			->join('supplier', 'supplier.id = purchase_order.supplier_id')
			->join('produk', 'produk.id = purchase_order_item.produk_id')
			->order_by('purchase_order.tanggal_po', 'DESC');

		if ($supplier_id) { $this->db->where('purchase_order.supplier_id', $supplier_id); }
		if ($produk_id) { $this->db->where('purchase_order_item.produk_id', $produk_id); }

		return $this->db->get()->result();
	}

	/**
	 * Cascade delete menyeluruh ketika data supplier di Master Data dihapus
	 * Menghapus seluruh relasi di Purchase Order, Utang Usaha, Kas Keluar, Retur Pembelian, & Riwayat Harga
	 */
	public function remove($id = NULL)
	{
		if ($id) {
			$this->db->trans_start();

			// 1. Modul Purchase Order & Item
			$po_list = $this->db->select('id')->where('supplier_id', $id)->get('purchase_order')->result();
			if (!empty($po_list)) {
				$po_ids = array_map(function($p) { return $p->id; }, $po_list);
				$this->db->where_in('po_id', $po_ids)->delete('purchase_order_item');
				$this->db->where_in('id', $po_ids)->delete('purchase_order');
			}

			// 2. Modul Utang Usaha & Pembayaran Kas Keluar
			$utang_list = $this->db->select('id')->where('supplier_id', $id)->get('utang_usaha')->result();
			if (!empty($utang_list)) {
				$utang_ids = array_map(function($u) { return $u->id; }, $utang_list);
				$this->db->where_in('utang_id', $utang_ids)->delete('pembayaran_utang');
				$this->db->where_in('id', $utang_ids)->delete('utang_usaha');
			}
			$this->db->delete('pembayaran_utang', ['supplier_id' => $id]);

			// 3. Modul Retur Pembelian & Item
			$retur_list = $this->db->select('id')->where('supplier_id', $id)->get('retur_pembelian')->result();
			if (!empty($retur_list)) {
				$retur_ids = array_map(function($r) { return $r->id; }, $retur_list);
				$this->db->where_in('retur_pembelian_id', $retur_ids)->delete('retur_pembelian_item');
				$this->db->where_in('id', $retur_ids)->delete('retur_pembelian');
			}

			// 4. Modul Riwayat Harga & Log
			$this->db->delete('riwayat_harga_beli', ['supplier_id' => $id]);
			$this->db->delete('produk_harga_log', ['supplier_id' => $id]);

			// 5. Hapus data utama master supplier
			$ret = parent::remove($id);

			$this->db->trans_complete();

			return ($this->db->trans_status() !== FALSE) && $ret;
		}

		return false;
	}

}

/* End of file Model_supplier.php */
/* Location: ./modules/supplier/models/Model_supplier.php */
