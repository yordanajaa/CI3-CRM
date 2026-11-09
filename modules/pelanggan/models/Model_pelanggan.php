<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Model_pelanggan extends MY_Model {

	private $primary_key 	= 'id';
	private $table_name 	= 'pelanggan';
	private $field_search 	= ['kode_pelanggan', 'nama_pelanggan', 'kontak_person', 'telepon', 'no_telp', 'email', 'kota', 'tipe_pelanggan', 'source'];

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
		 );

		parent::__construct($config);
	}

	private static $has_synced = false;

	public function sync_all_customers()
	{
		if (self::$has_synced) return;
		self::$has_synced = true;

		$this->sync_missing_customers();
		$this->heal_missing_phones();
	}

	public function count_all($q = '', $field = '')
	{
		$this->sync_all_customers();
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
        if ($this->input->get('tipe_pelanggan')) {
            $this->db->where('tipe_pelanggan', $this->input->get('tipe_pelanggan'));
        }
        if ($this->input->get('source')) {
            $src_val = strtolower($this->input->get('source'));
            if ($src_val == 'resi' || $src_val == 'scan_resi') {
                $this->db->group_start()
                    ->where('source', 'resi')
                    ->or_where('source', 'scan_resi')
                    ->or_where('source', 'import_resi')
                    ->group_end();
            } else {
                $this->db->where('source', $src_val);
            }
        }
		$query = $this->db->get($this->table_name);

		return $query->num_rows();
	}

	public function get($q = '', $field = '', $limit = 0, $offset = 0)
	{
		$this->sync_all_customers();
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
        if ($this->input->get('tipe_pelanggan')) {
            $this->db->where('tipe_pelanggan', $this->input->get('tipe_pelanggan'));
        }
        if ($this->input->get('source')) {
            $src_val = strtolower($this->input->get('source'));
            if ($src_val == 'resi' || $src_val == 'scan_resi') {
                $this->db->group_start()
                    ->where('source', 'resi')
                    ->or_where('source', 'scan_resi')
                    ->or_where('source', 'import_resi')
                    ->group_end();
            } else {
                $this->db->where('source', $src_val);
            }
        }
        $this->db->select("pelanggan.*, 
            COALESCE(
                NULLIF(NULLIF(pelanggan.telepon, '-'), ''),
                NULLIF(NULLIF(pelanggan.no_telp, '-'), ''),
                (SELECT NULLIF(NULLIF(pm.no_telepon, '-'), '') FROM penjualan_marketplace pm WHERE pm.pelanggan_id = pelanggan.id AND pm.no_telepon IS NOT NULL AND pm.no_telepon != '' AND pm.no_telepon != '-' AND pm.no_telepon NOT LIKE '%*%' ORDER BY pm.id DESC LIMIT 1),
                (SELECT NULLIF(NULLIF(so.no_telepon, '-'), '') FROM sales_order so WHERE so.pelanggan_id = pelanggan.id AND so.no_telepon IS NOT NULL AND so.no_telepon != '' AND so.no_telepon != '-' AND so.no_telepon NOT LIKE '%*%' ORDER BY so.id DESC LIMIT 1),
                (SELECT NULLIF(NULLIF(lbl.customer_phone, '-'), '') FROM crm_transaction_followup_labels lbl WHERE lbl.customer_pelanggan_id = pelanggan.id AND lbl.customer_phone IS NOT NULL AND lbl.customer_phone != '' AND lbl.customer_phone != '-' AND lbl.customer_phone NOT LIKE '%*%' ORDER BY lbl.id DESC LIMIT 1),
                '-'
            ) as resolved_phone", FALSE);
        $this->db->limit($limit, $offset);
        $this->db->order_by($this->primary_key, "DESC");
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function sync_missing_customers()
	{
		// 1. Gather existing customer phones and clean names
		$existing_cust = $this->db->select('id, kode_pelanggan, nama_pelanggan, no_telp, telepon')->get($this->table_name)->result();
		$cust_by_phone = [];
		$cust_by_name = [];
		foreach ($existing_cust as $c) {
			$p1 = preg_replace('/[^0-9]/', '', (string)$c->telepon);
			$p2 = preg_replace('/[^0-9]/', '', (string)$c->no_telp);
			if (!empty($p1) && strlen($p1) >= 8) $cust_by_phone[$p1] = (int)$c->id;
			if (!empty($p2) && strlen($p2) >= 8) $cust_by_phone[$p2] = (int)$c->id;
			$c_name = strtolower(trim((string)$c->nama_pelanggan));
			if (!empty($c_name) && !in_array($c_name, ['pelanggan umum', 'customer shopee', 'customer toko', 'customer marketplace', 'customer import', '-'])) {
				$cust_by_name[$c_name] = (int)$c->id;
			}
		}

		$max_cust = $this->db->select_max('id')->get($this->table_name)->row();
		$next_num = ($max_cust && $max_cust->id) ? ((int)$max_cust->id + 1) : 1;

		// 2. Scan sales_order
		$so_custs = $this->db->query("
			SELECT DISTINCT 
				TRIM(nama_penerima) as nama,
				TRIM(no_telepon) as telepon,
				TRIM(alamat_pengiriman) as alamat,
				TRIM(kota_kabupaten) as kota,
				source,
				pelanggan_id
			FROM sales_order
			WHERE nama_penerima IS NOT NULL AND nama_penerima != '' AND nama_penerima != '-'
		")->result();

		foreach ($so_custs as $sc) {
			$nama = trim($sc->nama);
			$nama_lower = strtolower($nama);
			if (empty($nama) || in_array($nama_lower, ['pelanggan umum', 'customer', '-', 'null']) || strpos($nama, '***') !== false) continue;

			$phone_clean = preg_replace('/[^0-9]/', '', (string)$sc->telepon);
			$matched_id = null;

			if (!empty($phone_clean) && strlen($phone_clean) >= 8 && isset($cust_by_phone[$phone_clean])) {
				$matched_id = $cust_by_phone[$phone_clean];
			} elseif (isset($cust_by_name[$nama_lower])) {
				$matched_id = $cust_by_name[$nama_lower];
			}

			if (!$matched_id) {
				do {
					$c_kode = sprintf('CUST-%04d', $next_num++);
				} while ($this->db->get_where($this->table_name, ['kode_pelanggan' => $c_kode])->num_rows() > 0);

				$src = !empty($sc->source) ? $sc->source : 'toko';
				$new_data = [
					'kode_pelanggan' => $c_kode,
					'nama_pelanggan' => $nama,
					'telepon'        => $phone_clean ?: $sc->telepon,
					'no_telp'        => $phone_clean ?: $sc->telepon,
					'alamat'         => !empty($sc->alamat) ? $sc->alamat : '-',
					'kota'           => !empty($sc->kota) ? $sc->kota : '-',
					'tipe_pelanggan' => 'Retail',
					'tier_pelanggan' => 'RETAIL',
					'source'         => $src,
					'status'         => 'aktif',
					'created_by'     => 'system_sync',
					'created_at'     => date('Y-m-d H:i:s'),
				];
				$this->db->insert($this->table_name, $new_data);
				$matched_id = $this->db->insert_id();

				if (!empty($phone_clean) && strlen($phone_clean) >= 8) {
					$cust_by_phone[$phone_clean] = $matched_id;
				}
				$cust_by_name[$nama_lower] = $matched_id;
			}

			if ($matched_id && ($sc->pelanggan_id != $matched_id)) {
				$this->db->where('nama_penerima', $nama)
					->group_start()
						->where('pelanggan_id', 1)
						->or_where('pelanggan_id', 0)
						->or_where('pelanggan_id IS NULL', null, false)
					->group_end()
					->update('sales_order', ['pelanggan_id' => $matched_id]);
			}
		}

		// 3. Scan penjualan_marketplace
		$pm_custs = $this->db->query("
			SELECT DISTINCT 
				TRIM(nama_penerima) as nama,
				TRIM(username_pembeli) as username,
				TRIM(no_telepon) as telepon,
				TRIM(alamat_pengiriman) as alamat,
				TRIM(kota_kabupaten) as kota,
				source,
				pelanggan_id
			FROM penjualan_marketplace
			WHERE (nama_penerima IS NOT NULL AND nama_penerima != '' AND nama_penerima != '-')
			   OR (username_pembeli IS NOT NULL AND username_pembeli != '' AND username_pembeli != '-')
		")->result();

		foreach ($pm_custs as $pc) {
			$nama = trim($pc->nama ?: $pc->username);
			$nama_lower = strtolower($nama);
			if (empty($nama) || in_array($nama_lower, ['customer shopee', 'customer marketplace', 'customer', '-', 'null']) || strpos($nama, '***') !== false) continue;

			$phone_clean = preg_replace('/[^0-9]/', '', (string)$pc->telepon);
			$matched_id = null;

			if (!empty($phone_clean) && strlen($phone_clean) >= 8 && isset($cust_by_phone[$phone_clean])) {
				$matched_id = $cust_by_phone[$phone_clean];
			} elseif (isset($cust_by_name[$nama_lower])) {
				$matched_id = $cust_by_name[$nama_lower];
			}

			if (!$matched_id) {
				do {
					$c_kode = sprintf('CUST-%04d', $next_num++);
				} while ($this->db->get_where($this->table_name, ['kode_pelanggan' => $c_kode])->num_rows() > 0);

				$src = !empty($pc->source) ? $pc->source : 'shopee';
				$new_data = [
					'kode_pelanggan' => $c_kode,
					'nama_pelanggan' => $nama,
					'telepon'        => $phone_clean ?: $pc->telepon,
					'no_telp'        => $phone_clean ?: $pc->telepon,
					'alamat'         => !empty($pc->alamat) ? $pc->alamat : 'Imported Marketplace',
					'kota'           => !empty($pc->kota) ? $pc->kota : '-',
					'tipe_pelanggan' => 'Marketplace',
					'tier_pelanggan' => 'RETAIL',
					'source'         => $src,
					'status'         => 'aktif',
					'created_by'     => 'system_sync',
					'created_at'     => date('Y-m-d H:i:s'),
				];
				$this->db->insert($this->table_name, $new_data);
				$matched_id = $this->db->insert_id();

				if (!empty($phone_clean) && strlen($phone_clean) >= 8) {
					$cust_by_phone[$phone_clean] = $matched_id;
				}
				$cust_by_name[$nama_lower] = $matched_id;
			}

			if ($matched_id && ($pc->pelanggan_id != $matched_id)) {
				$this->db->group_start()
						->where('nama_penerima', $nama)
						->or_where('username_pembeli', $nama)
					->group_end()
					->group_start()
						->where('pelanggan_id', 1)
						->or_where('pelanggan_id', 0)
						->or_where('pelanggan_id IS NULL', null, false)
					->group_end()
					->update('penjualan_marketplace', ['pelanggan_id' => $matched_id]);
			}
		}
	}

	public function heal_missing_phones()
	{
		// 1. Sync phone from linked penjualan_marketplace
		@$this->db->query("UPDATE pelanggan p
			JOIN (
				SELECT pelanggan_id, MAX(no_telepon) as no_telepon 
				FROM penjualan_marketplace 
				WHERE pelanggan_id > 0 AND no_telepon IS NOT NULL AND no_telepon != '' AND no_telepon != '-' AND no_telepon NOT LIKE '%*%'
				GROUP BY pelanggan_id
			) pm ON pm.pelanggan_id = p.id
			SET p.telepon = pm.no_telepon, p.no_telp = pm.no_telepon
			WHERE (p.telepon IS NULL OR p.telepon = '' OR p.telepon = '-') 
			  AND (p.no_telp IS NULL OR p.no_telp = '' OR p.no_telp = '-')");

		// 2. Sync phone from linked sales_order
		@$this->db->query("UPDATE pelanggan p
			JOIN (
				SELECT pelanggan_id, MAX(no_telepon) as no_telepon 
				FROM sales_order 
				WHERE pelanggan_id > 0 AND no_telepon IS NOT NULL AND no_telepon != '' AND no_telepon != '-' AND no_telepon NOT LIKE '%*%'
				GROUP BY pelanggan_id
			) so ON so.pelanggan_id = p.id
			SET p.telepon = so.no_telepon, p.no_telp = so.no_telepon
			WHERE (p.telepon IS NULL OR p.telepon = '' OR p.telepon = '-') 
			  AND (p.no_telp IS NULL OR p.no_telp = '' OR p.no_telp = '-')");

		// 3. Sync phone from crm_transaction_followup_labels
		@$this->db->query("UPDATE pelanggan p
			JOIN (
				SELECT customer_pelanggan_id, MAX(customer_phone) as customer_phone 
				FROM crm_transaction_followup_labels 
				WHERE customer_pelanggan_id > 0 AND customer_phone IS NOT NULL AND customer_phone != '' AND customer_phone != '-' AND customer_phone NOT LIKE '%*%'
				GROUP BY customer_pelanggan_id
			) lbl ON lbl.customer_pelanggan_id = p.id
			SET p.telepon = lbl.customer_phone, p.no_telp = lbl.customer_phone
			WHERE (p.telepon IS NULL OR p.telepon = '' OR p.telepon = '-') 
			  AND (p.no_telp IS NULL OR p.no_telp = '' OR p.no_telp = '-')");

		// 4. Sync phone by exact clean name from penjualan_marketplace
		@$this->db->query("UPDATE pelanggan p
			JOIN (
				SELECT LOWER(TRIM(nama_penerima)) as clean_name, MAX(no_telepon) as no_telepon
				FROM penjualan_marketplace
				WHERE no_telepon IS NOT NULL AND no_telepon != '' AND no_telepon != '-' AND no_telepon NOT LIKE '%*%'
				  AND nama_penerima IS NOT NULL AND nama_penerima != '' AND nama_penerima != '-'
				GROUP BY LOWER(TRIM(nama_penerima))
			) pm ON LOWER(TRIM(p.nama_pelanggan)) = pm.clean_name
			SET p.telepon = pm.no_telepon, p.no_telp = pm.no_telepon
			WHERE (p.telepon IS NULL OR p.telepon = '' OR p.telepon = '-')
			  AND (p.no_telp IS NULL OR p.no_telp = '' OR p.no_telp = '-')");
	}

	public function generate_kode()
	{
		$row = $this->db->select_max('id')->get($this->table_name)->row();
		$next = ($row && $row->id) ? ((int)$row->id + 1) : 1;
		$kode = sprintf('CUST-%04d', $next);
		while ($this->db->get_where($this->table_name, ['kode_pelanggan' => $kode])->num_rows() > 0) {
			$next++;
			$kode = sprintf('CUST-%04d', $next);
		}
		return $kode;
	}

	public function get_harga($produk_id, $tipe, $qty = 1)
	{
		// Cek apakah ada override harga volume/tier khusus di tabel harga_pelanggan
		$harga_override = $this->db->where('produk_id', $produk_id)
			->where('tipe_pelanggan', $tipe)
			->where('min_qty <=', $qty)
			->order_by('min_qty', 'DESC')
			->limit(1)
			->get('harga_pelanggan')->row();

		if ($harga_override) {
			return $harga_override->harga;
		}

		// Jika tidak ada override, gunakan harga default produk sesuai tipe pelanggan
		$produk = $this->db->get_where('produk', ['id' => $produk_id])->row();
		if (!$produk) return 0;
		
		$tipe = strtolower(trim($tipe));
		if ($tipe == 'grosir' && $produk->harga_jual_grosir > 0) return $produk->harga_jual_grosir;
		if ($tipe == 'distributor' && $produk->harga_jual_distributor > 0) return $produk->harga_jual_distributor;
		if ($tipe == 'vip' && $produk->harga_jual_vip > 0) return $produk->harga_jual_vip;
		
		return $produk->harga_jual;
	}

	/**
	 * Get laporan ringkasan transaksi per pelanggan
	 */
	public function get_laporan_transaksi()
	{
		return $this->db->query("
			SELECT p.id, p.kode_pelanggan, p.nama_pelanggan, p.tipe_pelanggan,
			       COUNT(DISTINCT so.id) AS total_so,
			       COUNT(DISTINCT inv.id) AS total_inv,
			       COALESCE(SUM(inv.total), 0) AS total_belanja,
			       COALESCE(SUM(piu.sisa), 0) AS sisa_piutang
			FROM pelanggan p
			LEFT JOIN sales_order so ON so.pelanggan_id = p.id
			LEFT JOIN invoice inv ON inv.pelanggan_id = p.id
			LEFT JOIN piutang_usaha piu ON piu.pelanggan_id = p.id AND piu.status != 'lunas'
			WHERE p.status = 'aktif'
			GROUP BY p.id, p.kode_pelanggan, p.nama_pelanggan, p.tipe_pelanggan
			ORDER BY total_belanja DESC
		")->result();
	}

	/**
	 * Cascade delete menyeluruh ketika data pelanggan di Master Data dihapus
	 * Menghapus seluruh relasi di CRM, Chat, Broadcast, Penjualan, Invoice, Piutang, & Marketplace
	 */
	public function remove($id = NULL)
	{
		if ($id) {
			$this->db->trans_start();

			// 1. Modul CRM & Interaksi Chat / Follow-up / Broadcast
			$labels = $this->db->select('id')->where('customer_pelanggan_id', $id)->get('crm_transaction_followup_labels')->result();
			if (!empty($labels)) {
				$label_ids = array_map(function($l) { return $l->id; }, $labels);
				$this->db->where_in('label_id', $label_ids)->delete('crm_chat_history');
				$this->db->where_in('followup_label_id', $label_ids)->delete('crm_followup_notes');
				$this->db->where_in('followup_label_id', $label_ids)->delete('crm_broadcast_logs');
				$this->db->where_in('id', $label_ids)->delete('crm_transaction_followup_labels');
			}

			// 2. Modul Penjualan (Sales Order) & Item
			$so_list = $this->db->select('id')->where('pelanggan_id', $id)->get('sales_order')->result();
			if (!empty($so_list)) {
				$so_ids = array_map(function($s) { return $s->id; }, $so_list);
				$this->db->where_in('so_id', $so_ids)->delete('sales_order_item');
				$this->db->where_in('order_id', $so_ids)->delete('crm_transaction_followup_labels');
				$this->db->where_in('id', $so_ids)->delete('sales_order');
			}

			// 3. Modul Invoice & Item
			$inv_list = $this->db->select('id')->where('pelanggan_id', $id)->get('invoice')->result();
			if (!empty($inv_list)) {
				$inv_ids = array_map(function($inv) { return $inv->id; }, $inv_list);
				$this->db->where_in('invoice_id', $inv_ids)->delete('invoice_item');
				$this->db->where_in('id', $inv_ids)->delete('invoice');
			}

			// 4. Modul Piutang Usaha & Pembayaran Kas Masuk
			$piutang_list = $this->db->select('id')->where('pelanggan_id', $id)->get('piutang_usaha')->result();
			if (!empty($piutang_list)) {
				$piutang_ids = array_map(function($p) { return $p->id; }, $piutang_list);
				$this->db->where_in('piutang_id', $piutang_ids)->delete('pembayaran_piutang');
				$this->db->where_in('id', $piutang_ids)->delete('piutang_usaha');
			}
			$this->db->delete('pembayaran_piutang', ['pelanggan_id' => $id]);

			// 5. Modul Retur Penjualan & Item
			$retur_list = $this->db->select('id')->where('pelanggan_id', $id)->get('retur_penjualan')->result();
			if (!empty($retur_list)) {
				$retur_ids = array_map(function($r) { return $r->id; }, $retur_list);
				$this->db->where_in('retur_penjualan_id', $retur_ids)->delete('retur_penjualan_item');
				$this->db->where_in('id', $retur_ids)->delete('retur_penjualan');
			}

			// 6. Modul Penjualan Marketplace & Item
			$mkt_list = $this->db->select('id')->where('pelanggan_id', $id)->get('penjualan_marketplace')->result();
			if (!empty($mkt_list)) {
				$mkt_ids = array_map(function($m) { return $m->id; }, $mkt_list);
				$this->db->where_in('penjualan_marketplace_id', $mkt_ids)->delete('penjualan_marketplace_item');
				$this->db->where_in('id', $mkt_ids)->delete('penjualan_marketplace');
			}

			// 7. Hapus data utama master pelanggan
			$ret = parent::remove($id);

			$this->db->trans_complete();

			return ($this->db->trans_status() !== FALSE) && $ret;
		}

		return false;
	}

}

/* End of file Model_pelanggan.php */
/* Location: ./modules/pelanggan/models/Model_pelanggan.php */
