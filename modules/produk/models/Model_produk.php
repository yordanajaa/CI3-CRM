<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Model_produk extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'produk';
	private $field_search 	= ['kode_produk', 'nama_produk', 'deskripsi'];

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
	                $where .= "(produk." . $f . " LIKE '%" . $q . "%' ";
	            } else if ($iterasi == $num) {
	                $where .= "OR produk." . $f . " LIKE '%" . $q . "%') ";
	            } else {
	                $where .= "OR produk." . $f . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }
        } else {
        	$where .= "(produk." . $field . " LIKE '%" . $q . "%' )";
        }

        $this->join_available();
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
	                $where .= "(produk." . $f . " LIKE '%" . $q . "%' ";
	            } else if ($iterasi == $num) {
	                $where .= "OR produk." . $f . " LIKE '%" . $q . "%') ";
	            } else {
	                $where .= "OR produk." . $f . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }
        } else {
        	$where .= "(produk." . $field . " LIKE '%" . $q . "%' )";
        }

        $this->join_available();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('produk.id', "ASC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_available()
	{
		$this->db->select('produk.*, kategori_produk.nama_kategori, satuan.nama_satuan, satuan.singkatan');
		$this->db->join('kategori_produk', 'kategori_produk.id = produk.kategori_id', 'LEFT');
		$this->db->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT');
		return $this;
	}

	public function get_stok($produk_id)
	{
		$row = $this->db->get_where('stok', ['produk_id' => $produk_id])->row();
		return $row ? (float)$row->qty : 0;
	}

	public function generate_kode()
	{
		$max_id_row = $this->db->select_max('id')->get($this->table_name)->row();
		$next_num = ($max_id_row && $max_id_row->id) ? ((int)$max_id_row->id + 1) : 1;
		$kode = 'PRD-' . str_pad($next_num, 4, '0', STR_PAD_LEFT);

		while ($this->db->where('kode_produk', $kode)->get($this->table_name)->num_rows() > 0) {
			$next_num++;
			$kode = 'PRD-' . str_pad($next_num, 4, '0', STR_PAD_LEFT);
		}
		return $kode;
	}

	public function generate_barcode()
	{
		return null;
	}

	public function get_for_select()
	{
		return $this->db->where('status', 'aktif')->get($this->table_name)->result();
	}

	public function get_riwayat_harga($produk_id)
	{
		$this->db->select('riwayat_harga_beli.*, supplier.nama_supplier, purchase_order.mata_uang, purchase_order.kurs');
		$this->db->join('supplier', 'supplier.id = riwayat_harga_beli.supplier_id', 'LEFT');
		$this->db->join('purchase_order', 'purchase_order.nomor_po = riwayat_harga_beli.nomor_po', 'LEFT');
		$this->db->where('riwayat_harga_beli.produk_id', $produk_id);
		$this->db->order_by('riwayat_harga_beli.tanggal', 'DESC');
		$this->db->order_by('riwayat_harga_beli.id', 'DESC');
		return $this->db->get('riwayat_harga_beli')->result();
	}

	/**
	 * Cek apakah produk memiliki riwayat transaksi (Penjualan, Pembelian, Retur, Faktur, Mutasi Stok)
	 */
	public function has_transactions($id)
	{
		if (!$id) return false;

		// 1. Cek transaksi penjualan (Offline, POS, Marketplace, Faktur)
		if ($this->db->where('produk_id', $id)->count_all_results('sales_order_item') > 0) return true;
		if ($this->db->where('produk_id', $id)->count_all_results('penjualan_marketplace_item') > 0) return true;
		if ($this->db->where('produk_id', $id)->count_all_results('invoice_item') > 0) return true;

		// 2. Cek transaksi pembelian & retur
		if ($this->db->where('produk_id', $id)->count_all_results('purchase_order_item') > 0) return true;
		if ($this->db->where('produk_id', $id)->count_all_results('retur_penjualan_item') > 0) return true;
		if ($this->db->where('produk_id', $id)->count_all_results('retur_pembelian_item') > 0) return true;

		// 3. Cek log stok (riwayat mutasi kartu stok)
		if ($this->db->where('produk_id', $id)->count_all_results('stok_log') > 0) return true;

		return false;
	}

			/**
	 * Hard Delete Total / Cascading:
	 * Menghapus fisik baris produk secara permanen beserta seluruh data transaksi terkait
	 * di Penjualan (Offline, POS, Marketplace), Inventori Stok, CRM, Invoice, Purchase Order, dan Retur.
	 *
	 * @param int|array $ids
	 * @return array
	 */
	public function delete_cascade($ids)
	{
		$ids = is_array($ids) ? array_filter(array_map('intval', $ids)) : [(int)$ids];
		$ids = array_filter($ids);
		if (empty($ids)) {
			return ['status' => 'error', 'message' => 'Pilih minimal satu produk yang valid untuk dihapus.'];
		}

		$this->db->trans_start();

		// 1. Tangani Sales Order (Transaksi Offline & Kasir POS)
		$so_items = $this->db->where_in('produk_id', $ids)->get('sales_order_item')->result();
		$affected_so_ids = array_unique(array_filter(array_column($so_items, 'so_id')));

		$this->db->where_in('produk_id', $ids)->delete('sales_order_item');

		foreach ($affected_so_ids as $so_id) {
			$remaining = $this->db->where('so_id', $so_id)->get('sales_order_item')->result();
			if (empty($remaining)) {
				// Hapus relasi follow-up CRM jika pesanan ini kosong
				$labels_so = $this->db->where('order_table', 'sales_order')->where('order_id', $so_id)->get('crm_transaction_followup_labels')->result();
				if (!empty($labels_so)) {
					$lbl_ids = array_column($labels_so, 'id');
					$this->db->where_in('followup_label_id', $lbl_ids)->delete('crm_broadcast_logs');
					$this->db->where_in('followup_label_id', $lbl_ids)->delete('crm_followup_notes');
					$this->db->where_in('label_id', $lbl_ids)->delete('crm_chat_history');
					$this->db->where_in('id', $lbl_ids)->delete('crm_transaction_followup_labels');
				}
				$this->db->delete('sales_order', ['id' => $so_id]);
			} else {
				$new_subtotal = array_sum(array_column($remaining, 'subtotal'));
				$this->db->where('id', $so_id)->update('sales_order', [
					'subtotal'         => $new_subtotal,
					'total'            => $new_subtotal,
					'total_pembayaran' => $new_subtotal,
					'updated_at'       => date('Y-m-d H:i:s')
				]);
			}
		}

		// 2. Tangani Penjualan Marketplace (Online Shop)
		$pm_items = $this->db->where_in('produk_id', $ids)->get('penjualan_marketplace_item')->result();
		$affected_pm_ids = array_unique(array_filter(array_column($pm_items, 'penjualan_marketplace_id')));

		$this->db->where_in('produk_id', $ids)->delete('penjualan_marketplace_item');

		foreach ($affected_pm_ids as $pm_id) {
			$remaining_pm = $this->db->where('penjualan_marketplace_id', $pm_id)->get('penjualan_marketplace_item')->result();
			if (empty($remaining_pm)) {
				$labels_pm = $this->db->where('order_table', 'penjualan_marketplace')->where('order_id', $pm_id)->get('crm_transaction_followup_labels')->result();
				if (!empty($labels_pm)) {
					$lbl_ids = array_column($labels_pm, 'id');
					$this->db->where_in('followup_label_id', $lbl_ids)->delete('crm_broadcast_logs');
					$this->db->where_in('followup_label_id', $lbl_ids)->delete('crm_followup_notes');
					$this->db->where_in('label_id', $lbl_ids)->delete('crm_chat_history');
					$this->db->where_in('id', $lbl_ids)->delete('crm_transaction_followup_labels');
				}
				$this->db->delete('penjualan_marketplace', ['id' => $pm_id]);
			} else {
				$new_pm_sub = array_sum(array_column($remaining_pm, 'subtotal'));
				$this->db->where('id', $pm_id)->update('penjualan_marketplace', [
					'subtotal'   => $new_pm_sub,
					'total'      => $new_pm_sub,
					'updated_at' => date('Y-m-d H:i:s')
				]);
			}
		}

		// 3. Tangani Invoice & Purchase Order
		$inv_items = $this->db->where_in('produk_id', $ids)->get('invoice_item')->result();
		$affected_inv_ids = array_unique(array_filter(array_column($inv_items, 'invoice_id')));
		$this->db->where_in('produk_id', $ids)->delete('invoice_item');

		foreach ($affected_inv_ids as $inv_id) {
			$remaining_inv = $this->db->where('invoice_id', $inv_id)->get('invoice_item')->result();
			if (empty($remaining_inv)) {
				$this->db->delete('invoice', ['id' => $inv_id]);
			} else {
				$new_inv_sub = array_sum(array_column($remaining_inv, 'subtotal'));
				$this->db->where('id', $inv_id)->update('invoice', [
					'subtotal'   => $new_inv_sub,
					'total'      => $new_inv_sub,
					'updated_at' => date('Y-m-d H:i:s')
				]);
			}
		}

		$po_items = $this->db->where_in('produk_id', $ids)->get('purchase_order_item')->result();
		$affected_po_ids = array_unique(array_filter(array_column($po_items, 'po_id')));
		$this->db->where_in('produk_id', $ids)->delete('purchase_order_item');

		foreach ($affected_po_ids as $po_id) {
			$remaining_po = $this->db->where('po_id', $po_id)->get('purchase_order_item')->result();
			if (empty($remaining_po)) {
				$this->db->delete('purchase_order', ['id' => $po_id]);
			} else {
				$new_po_sub = array_sum(array_column($remaining_po, 'subtotal'));
				$this->db->where('id', $po_id)->update('purchase_order', [
					'subtotal'   => $new_po_sub,
					'total'      => $new_po_sub,
					'updated_at' => date('Y-m-d H:i:s')
				]);
			}
		}

		// 4. Tangani Retur Penjualan & Retur Pembelian
		$retur_penj_items = $this->db->where_in('produk_id', $ids)->get('retur_penjualan_item')->result();
		$affected_retur_penj_ids = array_unique(array_filter(array_column($retur_penj_items, 'retur_penjualan_id')));
		$this->db->where_in('produk_id', $ids)->delete('retur_penjualan_item');

		foreach ($affected_retur_penj_ids as $rp_id) {
			$remaining_rp = $this->db->where('retur_penjualan_id', $rp_id)->get('retur_penjualan_item')->result();
			if (empty($remaining_rp)) {
				$this->db->delete('retur_penjualan', ['id' => $rp_id]);
			} else {
				$new_rp_total = array_sum(array_column($remaining_rp, 'subtotal'));
				$this->db->where('id', $rp_id)->update('retur_penjualan', [
					'total'      => $new_rp_total,
					'updated_at' => date('Y-m-d H:i:s')
				]);
			}
		}

		$retur_pemb_items = $this->db->where_in('produk_id', $ids)->get('retur_pembelian_item')->result();
		$affected_retur_pemb_ids = array_unique(array_filter(array_column($retur_pemb_items, 'retur_pembelian_id')));
		$this->db->where_in('produk_id', $ids)->delete('retur_pembelian_item');

		foreach ($affected_retur_pemb_ids as $rb_id) {
			$remaining_rb = $this->db->where('retur_pembelian_id', $rb_id)->get('retur_pembelian_item')->result();
			if (empty($remaining_rb)) {
				$this->db->delete('retur_pembelian', ['id' => $rb_id]);
			} else {
				$new_rb_total = array_sum(array_column($remaining_rb, 'subtotal'));
				$this->db->where('id', $rb_id)->update('retur_pembelian', [
					'total' => $new_rb_total
				]);
			}
		}

		// 5. Bersihkan Inventori & Log Terkait Produk
		$this->db->where_in('produk_id', $ids)->delete('stok_log');
		$this->db->where_in('produk_id', $ids)->delete('stok');
		$this->db->where_in('produk_id', $ids)->delete('stok_rusak');
		$this->db->where_in('produk_id', $ids)->delete('stock_opname_item');
		$this->db->where_in('produk_id', $ids)->delete('harga_pelanggan');
		$this->db->where_in('produk_id', $ids)->delete('riwayat_harga_beli');
		$this->db->where_in('produk_id', $ids)->delete('produk_harga_log');

		// 6. Hapus Fisik Master Produk
		$this->db->where_in('id', $ids)->delete($this->table_name);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return ['status' => 'error', 'message' => 'Gagal mengeksekusi hard delete cascading produk.'];
		}

		$count = count($ids);
		return [
			'status'  => 'success',
			'message' => "{$count} produk beserta seluruh data transaksi penjualan, stok, dan relasi CRM terkait berhasil dihapus total dari database."
		];
	}

	public function remove($id = NULL)
	{
		if ($id) {
			$res = $this->delete_cascade([$id]);
			return ($res['status'] === 'success');
		}
		return false;
	}

}

/* End of file Model_produk.php */
/* Location: ./modules/produk/models/Model_produk.php */
