<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Model_stok extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'stok';
	private $field_search 	= ['produk.nama_produk', 'produk.kode_produk', 'gudang.nama_gudang'];

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
		 );

		parent::__construct($config);
	}

	public function count_all($q = '', $field = '', $gudang_id = null, $status = null)
	{
		$this->join_available();
		$where = $this->build_where($q, $field);
		if ($where) $this->db->where($where);
		if ($gudang_id) $this->db->where('stok.gudang_id', $gudang_id);
		$this->apply_status_filter($status, $gudang_id);
		return $this->db->get($this->table_name)->num_rows();
	}

	public function get($q = '', $field = '', $limit = 0, $offset = 0, $gudang_id = null, $status = null)
	{
		$this->join_available();
		$where = $this->build_where($q, $field);
		if ($where) $this->db->where($where);
		if ($gudang_id) $this->db->where('stok.gudang_id', $gudang_id);
		$this->apply_status_filter($status, $gudang_id);
		if ($limit) $this->db->limit($limit, $offset);
		$this->db->order_by('produk.id', 'ASC')->order_by('stok.gudang_id', 'ASC');
		return $this->db->get($this->table_name)->result();
	}

	private function apply_status_filter($status, $gudang_id = null)
	{
		if ($status === 'habis') {
			if ($gudang_id) {
				$this->db->where('stok.qty', 0);
			} else {
				$this->db->where("stok.produk_id IN (SELECT s_habis.produk_id FROM stok s_habis JOIN gudang g_habis ON g_habis.id = s_habis.gudang_id WHERE g_habis.status = 'aktif' GROUP BY s_habis.produk_id HAVING SUM(s_habis.qty) = 0)", null, false);
			}
		} elseif ($status === 'menipis') {
			if ($gudang_id) {
				$this->db->where('stok.qty > 0', null, false);
				$this->db->where('stok.qty <= produk.stok_minimum', null, false);
			} else {
				$this->db->where("stok.produk_id IN (SELECT s_men.produk_id FROM stok s_men JOIN produk p_men ON p_men.id = s_men.produk_id JOIN gudang g_men ON g_men.id = s_men.gudang_id WHERE g_men.status = 'aktif' GROUP BY s_men.produk_id, p_men.stok_minimum HAVING SUM(s_men.qty) > 0 AND SUM(s_men.qty) <= p_men.stok_minimum)", null, false);
			}
		} elseif ($status === 'ada' || $status === 'tersedia') {
			$this->db->where('stok.qty > 0', null, false);
		}
	}

	public function join_available()
	{
		$this->db->select('stok.*, produk.nama_produk, produk.kode_produk, produk.stok_minimum, produk.harga_beli, produk.harga_jual, satuan.singkatan, gudang.nama_gudang, kategori_produk.nama_kategori, rak.kode_rak, rak.baris');
		$this->db->join('produk', 'produk.id = stok.produk_id');
		$this->db->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT');
		$this->db->join('gudang', 'gudang.id = stok.gudang_id');
		$this->db->join('kategori_produk', 'kategori_produk.id = produk.kategori_id', 'LEFT');
		$this->db->join('rak', 'rak.id = IFNULL(stok.rak_id, produk.default_rak_id)', 'LEFT');
		$this->db->where('produk.status', 'aktif');
		$this->db->where('gudang.status', 'aktif');
		return $this;
	}

	private function build_where($q, $field)
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
		return $where;
	}

	public function get_stok_menipis($gudang_id = null)
	{
		$this->db->select('stok.*, produk.nama_produk, produk.kode_produk, produk.stok_minimum, satuan.singkatan, gudang.nama_gudang');
		$this->db->join('produk', 'produk.id = stok.produk_id');
		$this->db->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT');
		$this->db->join('gudang', 'gudang.id = stok.gudang_id');
		$this->db->where('produk.status', 'aktif');
		$this->db->where('gudang.status', 'aktif');
		$this->db->where('stok.qty > 0', null, false);
		$this->db->where('stok.qty <= produk.stok_minimum', null, false);
		if ($gudang_id) $this->db->where('stok.gudang_id', $gudang_id);
		$this->db->order_by('produk.id', 'ASC')->order_by('stok.gudang_id', 'ASC');
		return $this->db->get('stok')->result();
	}

	public function get_kartu_stok($produk_id, $gudang_id = null, $date_start = null, $date_end = null)
	{
		$this->db->select('stok_log.*, produk.nama_produk, produk.kode_produk, gudang.nama_gudang');
		$this->db->join('produk', 'produk.id = stok_log.produk_id');
		$this->db->join('gudang', 'gudang.id = stok_log.gudang_id');
		$this->db->where('stok_log.produk_id', $produk_id);
		if ($gudang_id) $this->db->where('stok_log.gudang_id', $gudang_id);
		if ($date_start) $this->db->where('DATE(stok_log.created_at) >=', $date_start);
		if ($date_end) $this->db->where('DATE(stok_log.created_at) <=', $date_end);
		$this->db->order_by('stok_log.created_at', 'ASC');
		return $this->db->get('stok_log')->result();
	}

	public function ensure_all_stok_synced()
	{
		// 1. Pastikan setiap produk aktif memiliki record stok di seluruh gudang aktif
		$this->db->query("
			INSERT INTO stok (produk_id, gudang_id, qty, qty_rusak, updated_at)
			SELECT p.id, g.id, 0, 0, NOW()
			FROM produk p
			CROSS JOIN gudang g
			WHERE p.status = 'aktif' AND g.status = 'aktif'
			  AND NOT EXISTS (
			      SELECT 1 FROM stok s WHERE s.produk_id = p.id AND s.gudang_id = g.id
			  )
		");

		// 2. Bersihkan record stok yatim (orphan) jika produk induk sudah tidak ada
		$this->db->query("
			DELETE s FROM stok s
			LEFT JOIN produk p ON p.id = s.produk_id
			WHERE p.id IS NULL
		");
	}

	public function get_summary_dashboard($gudang_id = null)
	{
		$this->ensure_all_stok_synced();

		// Total nilai stok, total produk, & total keseluruhan stok
		$q = $this->db->select('SUM(stok.qty * produk.harga_beli) AS total_nilai, COUNT(DISTINCT stok.produk_id) AS total_produk, SUM(stok.qty) AS total_keseluruhan_stok');
		$q->join('produk', 'produk.id = stok.produk_id');
		$q->join('gudang', 'gudang.id = stok.gudang_id');
		$q->where('produk.status', 'aktif');
		$q->where('gudang.status', 'aktif');
		if ($gudang_id) $q->where('stok.gudang_id', $gudang_id);
		$summary = $q->get('stok')->row();

		if ($gudang_id) {
			// Jika filter gudang spesifik dipilih
			$q_menipis = $this->db->where('stok.qty > 0', null, false)
				->where('stok.qty <= produk.stok_minimum', null, false)
				->join('produk', 'produk.id = stok.produk_id')
				->join('gudang', 'gudang.id = stok.gudang_id')
				->where('produk.status', 'aktif')
				->where('gudang.status', 'aktif')
				->where('stok.gudang_id', $gudang_id);
			$menipis_count = $q_menipis->count_all_results('stok');

			$q_habis = $this->db->where('stok.qty', 0)
				->join('produk', 'produk.id = stok.produk_id')
				->join('gudang', 'gudang.id = stok.gudang_id')
				->where('produk.status', 'aktif')
				->where('gudang.status', 'aktif')
				->where('stok.gudang_id', $gudang_id);
			$habis_count = $q_habis->count_all_results('stok');
		} else {
			// Jika semua gudang: hitung produk distinct berdasarkan total stok fisiknya di seluruh gudang
			$habis_res = $this->db->query("SELECT COUNT(*) as c FROM (
				SELECT p.id, COALESCE(SUM(s.qty), 0) as tot_qty 
				FROM produk p 
				LEFT JOIN stok s ON s.produk_id = p.id 
				JOIN gudang g ON g.id = s.gudang_id 
				WHERE p.status = 'aktif' AND g.status = 'aktif' 
				GROUP BY p.id 
				HAVING tot_qty = 0
			) t")->row();
			$habis_count = $habis_res ? (int)$habis_res->c : 0;

			$menipis_res = $this->db->query("SELECT COUNT(*) as c FROM (
				SELECT p.id, p.stok_minimum, COALESCE(SUM(s.qty), 0) as tot_qty 
				FROM produk p 
				LEFT JOIN stok s ON s.produk_id = p.id 
				JOIN gudang g ON g.id = s.gudang_id 
				WHERE p.status = 'aktif' AND g.status = 'aktif' 
				GROUP BY p.id 
				HAVING tot_qty > 0 AND tot_qty <= p.stok_minimum
			) t")->row();
			$menipis_count = $menipis_res ? (int)$menipis_res->c : 0;
		}

		return (object) [
			'total_nilai'     => $summary ? (float) $summary->total_nilai : 0,
			'total_produk'    => $summary ? (int) $summary->total_produk : 0,
			'total_stok'      => $summary ? (float) $summary->total_keseluruhan_stok : 0,
			'stok_menipis'    => $menipis_count,
			'stok_habis'      => $habis_count,
		];
	}

}

/* End of file Model_stok.php */
/* Location: ./modules/stok/models/Model_stok.php */
