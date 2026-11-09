<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Model_retur_penjualan extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'retur_penjualan';
	private $field_search 	= ['retur_penjualan.nomor_retur', 'pelanggan.nama_pelanggan', 'retur_penjualan.status'];

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
		$this->db->select('retur_penjualan.*, 
			COALESCE(NULLIF(pelanggan.nama_pelanggan, ""), NULLIF(inv_pelanggan.nama_pelanggan, ""), NULLIF(so.nama_penerima, ""), "-") as nama_pelanggan,
			COALESCE(NULLIF(pelanggan.kode_pelanggan, ""), NULLIF(inv_pelanggan.kode_pelanggan, ""), "-") as kode_pelanggan,
			invoice.nomor_invoice');
		$this->db->join('invoice', 'invoice.id = retur_penjualan.invoice_id', 'LEFT');
		$this->db->join('sales_order as so', 'so.id = invoice.so_id', 'LEFT');
		$this->db->join('pelanggan', 'pelanggan.id = retur_penjualan.pelanggan_id', 'LEFT');
		$this->db->join('pelanggan as inv_pelanggan', 'inv_pelanggan.id = invoice.pelanggan_id', 'LEFT');
		return $this;
	}

	public function count_all($q = '', $field = '', $filter_extra = [])
	{
		$this->join_available();
		$where = $this->build_where($q, $field);
        $this->db->where($where);
        $this->apply_extra_filters($filter_extra);
		return $this->db->get($this->table_name)->num_rows();
	}

	public function get($q = '', $field = '', $limit = 0, $offset = 0, $filter_extra = [])
	{
		$this->join_available();
		$where = $this->build_where($q, $field);
        $this->db->where($where);
        $this->apply_extra_filters($filter_extra);
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('retur_penjualan.'.$this->primary_key, 'DESC');
		return $this->db->get($this->table_name)->result();
	}

	private function apply_extra_filters($filters = [])
	{
		if (empty($filters) || !is_array($filters)) return;

		if (!empty($filters['date_start'])) {
			$this->db->where('retur_penjualan.tanggal_retur >=', $filters['date_start']);
		}
		if (!empty($filters['date_end'])) {
			$this->db->where('retur_penjualan.tanggal_retur <=', $filters['date_end']);
		}
		if (!empty($filters['tanggal'])) {
			$this->db->where('retur_penjualan.tanggal_retur', $filters['tanggal']);
		}
		if (!empty($filters['bulan'])) {
			$this->db->where('MONTH(retur_penjualan.tanggal_retur)', (int)$filters['bulan']);
		}
		if (!empty($filters['tahun'])) {
			$this->db->where('YEAR(retur_penjualan.tanggal_retur)', (int)$filters['tahun']);
		}
		if (!empty($filters['status'])) {
			$this->db->where('retur_penjualan.status', $filters['status']);
		}
	}

	public function get_available_years()
	{
		$res = $this->db->query("SELECT DISTINCT YEAR(tanggal_retur) as thn FROM retur_penjualan WHERE tanggal_retur IS NOT NULL ORDER BY thn DESC")->result();
		$years = [];
		foreach ($res as $r) {
			if (!empty($r->thn)) $years[] = (int)$r->thn;
		}
		$current_year = (int)date('Y');
		if (!in_array($current_year, $years)) {
			$years[] = $current_year;
			rsort($years);
		}
		return $years;
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

	public function generate_nomor()
	{
		$prefix = 'RTJ-' . date('Ym') . '-';
		$last = $this->db->like('nomor_retur', $prefix, 'after')
			->order_by('id', 'DESC')
			->limit(1)
			->get($this->table_name)->row();
		$num = $last ? ((int) substr($last->nomor_retur, -4)) + 1 : 1;
		return $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
	}

	public function get_items($retur_id)
	{
		return $this->db->select('retur_penjualan_item.*, produk.nama_produk, produk.kode_produk')
			->join('produk', 'produk.id = retur_penjualan_item.produk_id')
			->get_where('retur_penjualan_item', ['retur_penjualan_id' => $retur_id])->result();
	}

	/**
	 * Proses retur: kembalikan stok baik atau catat stok rusak
	 * Tindak lanjut: kredit poin → tambah poin pelanggan
	 */
	public function proses_retur($retur_id, $user)
	{
		$retur = $this->find_with_join($retur_id);
		$items = $this->get_items($retur_id);

		foreach ($items as $item) {
			$stok = $this->db->get_where('stok', ['produk_id' => $item->produk_id])->row();
			$produk = $this->db->get_where('produk', ['id' => $item->produk_id])->row();
			$default_rak_id = $produk ? $produk->default_rak_id : null;

			$is_rusak = ($item->kondisi == 'rusak' || $retur->alasan == 'cacat' || $retur->alasan == 'kadaluarsa');

			if (!$is_rusak) {
				// Kembalikan ke stok normal
				if ($stok) {
					$upd_stok = [
						'qty' => $stok->qty + $item->qty_retur,
						'updated_at' => date('Y-m-d H:i:s'),
					];
					if (empty($stok->rak_id) && $default_rak_id) {
						$upd_stok['rak_id'] = $default_rak_id;
					}
					$this->db->update('stok', $upd_stok, ['id' => $stok->id]);
				} else {
					$this->db->insert('stok', [
						'produk_id' => $item->produk_id,
						'rak_id'    => $default_rak_id,
						'qty'       => $item->qty_retur,
						'qty_rusak' => 0,
						'updated_at' => date('Y-m-d H:i:s'),
					]);
				}

				$this->db->insert('stok_log', [
					'produk_id' => $item->produk_id,
					'jenis' => 'masuk',
					'qty' => $item->qty_retur,
					'harga_satuan' => $item->harga_satuan,
					'referensi_type' => 'retur_penjualan',
					'referensi_id' => $retur_id,
					'keterangan' => 'Retur Penjualan (barang baik) ' . $retur->nomor_retur,
					'created_by' => $user,
					'created_at' => date('Y-m-d H:i:s'),
				]);
			} else {
				// Masuk ke stok rusak (terpisah dari stok aktif & tidak bisa dijual ulang)
				if ($stok) {
					$upd_stok = [
						'qty_rusak' => $stok->qty_rusak + $item->qty_retur,
						'updated_at' => date('Y-m-d H:i:s'),
					];
					if (empty($stok->rak_id) && $default_rak_id) {
						$upd_stok['rak_id'] = $default_rak_id;
					}
					$this->db->update('stok', $upd_stok, ['id' => $stok->id]);
				} else {
					$this->db->insert('stok', [
						'produk_id' => $item->produk_id,
						'rak_id'    => $default_rak_id,
						'qty'       => 0,
						'qty_rusak' => $item->qty_retur,
						'updated_at' => date('Y-m-d H:i:s'),
					]);
				}

				$this->db->insert('stok_log', [
					'produk_id'      => $item->produk_id,
					'jenis'          => 'rusak',
					'qty'            => $item->qty_retur,
					'harga_satuan'   => $item->harga_satuan,
					'referensi_type' => 'retur_penjualan',
					'referensi_id'   => $retur_id,
					'keterangan'     => 'Retur Penjualan (barang rusak/afkir) ' . $retur->nomor_retur,
					'created_by'     => $user,
					'created_at'     => date('Y-m-d H:i:s'),
				]);
			}
		}

		// Proses tindak lanjut: Tukar Barang, Refund, atau Kredit Poin
		if ($retur->tindak_lanjut == 'tukar_barang') {
			// Jika tukar barang baru: kurangi stok barang aktif untuk unit baru pengganti yang diberikan ke pelanggan
			$inv_rec = $this->db->get_where('invoice', ['id' => $retur->invoice_id])->row();

			foreach ($items as $item) {
				$stok = $this->db->get_where('stok', ['produk_id' => $item->produk_id])->row();
				if ($stok) {
					$new_active_qty = max(0, $stok->qty - $item->qty_retur);
					$this->db->update('stok', ['qty' => $new_active_qty, 'updated_at' => date('Y-m-d H:i:s')], ['id' => $stok->id]);
				}
				$this->db->insert('stok_log', [
					'produk_id'      => $item->produk_id,
					'jenis'          => 'keluar',
					'qty'            => $item->qty_retur,
					'harga_satuan'   => $item->harga_satuan,
					'referensi_type' => 'retur_penjualan',
					'referensi_id'   => $retur_id,
					'keterangan'     => 'Pengeluaran Unit Baru Pengganti Retur (Tukar Barang Baru) ' . $retur->nomor_retur,
					'created_by'     => $user,
					'created_at'     => date('Y-m-d H:i:s'),
				]);
			}
		} elseif ($retur->tindak_lanjut == 'kredit_poin') {
			$pel = $this->db->get_where('pelanggan', ['id' => $retur->pelanggan_id])->row();
			$curr_poin = $pel ? (float)($pel->kredit_poin ?? 0) : 0;
			$this->db->update('pelanggan', [
				'kredit_poin' => $curr_poin + $retur->total,
			], ['id' => $retur->pelanggan_id]);
		} elseif ($retur->tindak_lanjut == 'refund' || $retur->tindak_lanjut == 'potong_tagihan') {
			// Jika refund / potong tagihan, potong Invoice & Piutang Usaha yang bersangkutan
			if ($retur->invoice_id) {
				// 1. Update Invoice Total
				$inv = $this->db->get_where('invoice', ['id' => $retur->invoice_id])->row();
				if ($inv) {
					$net_inv_total = max(0, $inv->total - $retur->total);
					$this->db->update('invoice', [
						'total' => $net_inv_total
					], ['id' => $inv->id]);
				}

				// 2. Update Piutang Usaha Total & Sisa Tagihan
				$piutang = $this->db->get_where('piutang_usaha', ['invoice_id' => $retur->invoice_id])->row();
				if ($piutang) {
					$new_total = max(0, $piutang->total - $retur->total);
					$new_sisa  = max(0, $piutang->sisa - $retur->total);
					$new_status = ($new_sisa <= 0) ? 'lunas' : (($piutang->terbayar > 0) ? 'sebagian' : 'belum_bayar');
					$this->db->update('piutang_usaha', [
						'total'      => $new_total,
						'sisa'       => $new_sisa,
						'status'     => $new_status,
						'updated_at' => date('Y-m-d H:i:s')
					], ['id' => $piutang->id]);
				}
			}
		}

		$this->db->update($this->table_name, [
			'status' => 'selesai',
			'updated_at' => date('Y-m-d H:i:s'),
		], ['id' => $retur_id]);

		return true;
	}

	public function find_with_join($id)
	{
		$this->join_available();
		return $this->db->get_where($this->table_name, ['retur_penjualan.id' => $id])->row();
	}

	public function get_laporan($produk_id = null, $date_start = null, $date_end = null)
	{
		$this->db->select('retur_penjualan_item.*, produk.nama_produk, produk.kode_produk, retur_penjualan.nomor_retur, retur_penjualan.tanggal_retur, retur_penjualan.alasan as alasan_utama, retur_penjualan.catatan as catatan_retur, COALESCE(NULLIF(pelanggan.nama_pelanggan, ""), NULLIF(inv_pelanggan.nama_pelanggan, ""), NULLIF(so.nama_penerima, ""), "-") as nama_pelanggan');
		$this->db->join('produk', 'produk.id = retur_penjualan_item.produk_id');
		$this->db->join('retur_penjualan', 'retur_penjualan.id = retur_penjualan_item.retur_penjualan_id');
		$this->db->join('invoice', 'invoice.id = retur_penjualan.invoice_id', 'LEFT');
		$this->db->join('sales_order as so', 'so.id = invoice.so_id', 'LEFT');
		$this->db->join('pelanggan', 'pelanggan.id = retur_penjualan.pelanggan_id', 'LEFT');
		$this->db->join('pelanggan as inv_pelanggan', 'inv_pelanggan.id = invoice.pelanggan_id', 'LEFT');

		if ($produk_id) {
			$this->db->where('retur_penjualan_item.produk_id', $produk_id);
		}
		if ($date_start) {
			$this->db->where('retur_penjualan.tanggal_retur >=', $date_start);
		}
		if ($date_end) {
			$this->db->where('retur_penjualan.tanggal_retur <=', $date_end);
		}
		$this->db->order_by('retur_penjualan.tanggal_retur', 'DESC');
		return $this->db->get('retur_penjualan_item')->result();
	}

}

/* End of file Model_retur_penjualan.php */
/* Location: ./modules/retur_penjualan/models/Model_retur_penjualan.php */
