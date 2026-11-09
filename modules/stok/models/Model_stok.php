<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Model_stok extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'stok';
	private $field_search 	= ['produk.nama_produk', 'produk.kode_produk'];

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
		 );

		parent::__construct($config);
	}

	public function count_all($q = '', $field = '', $status = null)
	{
		$this->join_available();
		$where = $this->build_where($q, $field);
		if ($where) $this->db->where($where);
		$this->apply_status_filter($status);
		return $this->db->get($this->table_name)->num_rows();
	}

	public function get($q = '', $field = '', $limit = 0, $offset = 0, $status = null)
	{
		$this->join_available();
		$where = $this->build_where($q, $field);
		if ($where) $this->db->where($where);
		$this->apply_status_filter($status);
		if ($limit) $this->db->limit($limit, $offset);
		$this->db->order_by('produk.id', 'ASC');
		return $this->db->get($this->table_name)->result();
	}

	private function apply_status_filter($status)
	{
		if ($status === 'habis') {
			$this->db->where('stok.qty', 0);
		} elseif ($status === 'menipis') {
			$this->db->where('stok.qty > 0', null, false);
			$this->db->where('stok.qty <= produk.stok_minimum', null, false);
		} elseif ($status === 'ada' || $status === 'tersedia') {
			$this->db->where('stok.qty > 0', null, false);
		}
	}

	public function join_available()
	{
		$this->db->select('stok.*, produk.nama_produk, produk.kode_produk, produk.stok_minimum, produk.harga_beli, produk.harga_jual, satuan.singkatan, kategori_produk.nama_kategori, rak.kode_rak, rak.baris');
		$this->db->join('produk', 'produk.id = stok.produk_id');
		$this->db->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT');
		$this->db->join('kategori_produk', 'kategori_produk.id = produk.kategori_id', 'LEFT');
		$this->db->join('rak', 'rak.id = IFNULL(stok.rak_id, produk.default_rak_id)', 'LEFT');
		$this->db->where('produk.status', 'aktif');
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

	public function get_stok_menipis()
	{
		$this->db->select('stok.*, produk.nama_produk, produk.kode_produk, produk.stok_minimum, satuan.singkatan');
		$this->db->join('produk', 'produk.id = stok.produk_id');
		$this->db->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT');
		$this->db->where('produk.status', 'aktif');
		$this->db->where('stok.qty > 0', null, false);
		$this->db->where('stok.qty <= produk.stok_minimum', null, false);
		$this->db->order_by('produk.id', 'ASC');
		return $this->db->get('stok')->result();
	}

	public function get_kartu_stok($produk_id, $date_start = null, $date_end = null)
	{
		$this->db->select('stok_log.*, produk.nama_produk, produk.kode_produk');
		$this->db->join('produk', 'produk.id = stok_log.produk_id');
		$this->db->where('stok_log.produk_id', $produk_id);
		if ($date_start) $this->db->where('DATE(stok_log.created_at) >=', $date_start);
		if ($date_end) $this->db->where('DATE(stok_log.created_at) <=', $date_end);
		$this->db->order_by('stok_log.created_at', 'ASC');
		return $this->db->get('stok_log')->result();
	}

	public function ensure_all_stok_synced()
	{
		// Pastikan setiap produk aktif memiliki record stok
		$this->db->query("
			INSERT INTO stok (produk_id, qty, qty_rusak, updated_at)
			SELECT p.id, 0, 0, NOW()
			FROM produk p
			WHERE p.status = 'aktif'
			  AND NOT EXISTS (
			      SELECT 1 FROM stok s WHERE s.produk_id = p.id
			  )
		");

		// Bersihkan record stok yatim (orphan) jika produk induk sudah tidak ada
		$this->db->query("
			DELETE s FROM stok s
			LEFT JOIN produk p ON p.id = s.produk_id
			WHERE p.id IS NULL
		");
	}

	public function get_summary_dashboard()
	{
		$this->ensure_all_stok_synced();

		// Total nilai stok, total produk, & total keseluruhan stok
		$summary = $this->db->select('SUM(stok.qty * produk.harga_beli) AS total_nilai, COUNT(stok.produk_id) AS total_produk, SUM(stok.qty) AS total_keseluruhan_stok')
			->join('produk', 'produk.id = stok.produk_id')
			->where('produk.status', 'aktif')
			->get('stok')->row();

		$menipis_count = $this->db->where('stok.qty > 0', null, false)
			->where('stok.qty <= produk.stok_minimum', null, false)
			->join('produk', 'produk.id = stok.produk_id')
			->where('produk.status', 'aktif')
			->count_all_results('stok');

		$habis_count = $this->db->where('stok.qty', 0)
			->join('produk', 'produk.id = stok.produk_id')
			->where('produk.status', 'aktif')
			->count_all_results('stok');

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
