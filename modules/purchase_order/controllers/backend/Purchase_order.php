<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Purchase_order extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_purchase_order');
	}

	public function index($offset = 0)
	{
		$this->is_allowed('purchase_order_list');

		$filter = $this->input->get('q');
		$field  = $this->input->get('f');

		$this->data['pos']       = $this->model_purchase_order->get($filter, $field, $this->limit_page, $offset);
		$this->data['po_counts'] = $this->model_purchase_order->count_all($filter, $field);
		$this->data['po_count']  = $this->data['po_counts'];

		
		$config = [
			'base_url'    => 'administrator/purchase_order/index/',
			'total_rows'  => $this->data['po_counts'],
			'per_page'    => $this->limit_page,
			'uri_segment' => 4,
		];
		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Purchase Order');
		$this->render('backend/standart/administrator/purchase_order/purchase_order_list', $this->data);
	}

	public function add()
	{
		$this->is_allowed('purchase_order_add');
		$this->data['nomor_baru'] = $this->model_purchase_order->generate_nomor();
		$this->data['suppliers']  = $this->db->where('status', 'aktif')->get('supplier')->result();
		$this->data['produks']    = $this->db->select('produk.*, satuan.nama_satuan, satuan.singkatan')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT')
			->where('produk.status', 'aktif')
			->get('produk')->result();
		$this->template->title('Buat Purchase Order');
		$this->render('backend/standart/administrator/purchase_order/purchase_order_add', $this->data);
	}

	private function parse_number($val)
	{
		if ($val === null || $val === '' || $val === false) return 0.0;
		$val = trim((string)$val);
		
		// If contains both dot and comma (e.g. 18.000,00 or 18,000.00)
		if (strpos($val, '.') !== false && strpos($val, ',') !== false) {
			if (strrpos($val, ',') > strrpos($val, '.')) {
				$val = str_replace('.', '', $val);
				$val = str_replace(',', '.', $val);
			} else {
				$val = str_replace(',', '', $val);
			}
		} elseif (strpos($val, ',') !== false) {
			$parts = explode(',', $val);
			if (count($parts) > 2 || (count($parts) === 2 && strlen($parts[1]) === 3)) {
				$val = str_replace(',', '', $val);
			} else {
				$val = str_replace(',', '.', $val);
			}
		} elseif (strpos($val, '.') !== false) {
			$parts = explode('.', $val);
			if (count($parts) > 2 || (count($parts) === 2 && strlen($parts[1]) === 3)) {
				$val = str_replace('.', '', $val);
			}
		}
		return (float) $val;
	}

	public function add_save()
	{
		if (!$this->is_allowed('purchase_order_add', false)) {
			return $this->response(['success' => false, 'message' => 'Tidak punya akses']);
		}

		$this->form_validation->set_rules('supplier_id', 'Supplier', 'trim|required');
		$this->form_validation->set_rules('tanggal_po', 'Tanggal PO', 'trim|required');

		if ($this->form_validation->run()) {
			$action_type = $this->input->post('action_type') ?: 'direct';
			$initial_status = ($action_type === 'draft') ? 'draft' : 'completed';

			$data = [
				'nomor_po'         => $this->model_purchase_order->generate_nomor(),
				'supplier_id'      => $this->input->post('supplier_id'),
				'tanggal_po'       => $this->input->post('tanggal_po'),
				'tanggal_estimasi' => $this->input->post('tanggal_estimasi') ?: null,
				'mata_uang'        => $this->input->post('mata_uang') ?: 'IDR',
				'kurs'             => $this->parse_number($this->input->post('kurs')) ?: 1,
				'diskon'           => $this->parse_number($this->input->post('diskon')),
				'pajak_persen'     => $this->parse_number($this->input->post('pajak_persen')),
				'status'           => $initial_status,
				'catatan'          => $this->input->post('catatan'),
				'created_by'       => get_user_data('username') ?: 'admin',
				'created_at'       => date('Y-m-d H:i:s'),
			];

			$po_id = $this->model_purchase_order->store($data);

			if ($po_id && $this->input->post('items')) {
				foreach ($this->input->post('items') as $item) {
					if (empty($item['produk_id'])) continue;
					$qty       = max(1, (int) round($item['qty']));
					$harga     = $this->parse_number($item['harga_satuan'] ?? 0);
					$diskon    = $this->parse_number($item['diskon_persen'] ?? 0);
					$d_nom     = $harga * $qty * ($diskon / 100);
					$subtotal  = ($harga * $qty) - $d_nom;
					$this->db->insert('purchase_order_item', [
						'po_id'          => $po_id,
						'produk_id'      => $item['produk_id'],
						'qty_pesan'      => $qty,
						'satuan'         => $item['satuan'] ?? '',
						'harga_satuan'   => $harga,
						'diskon_persen'  => $diskon,
						'diskon_nominal' => $d_nom,
						'subtotal'       => $subtotal,
						'catatan'        => $item['catatan'] ?? '',
					]);
				}
				$this->model_purchase_order->update_total($po_id);
			}

			if ($initial_status === 'completed') {
				$this->complete_po_and_sync_inventory($po_id);
				set_message('Purchase Order berhasil dibuat! Stok produk otomatis bertambah dan tagihan Utang Usaha telah dicatat.', 'success');
			} else {
				set_message('Purchase Order berhasil disimpan sebagai Draft.', 'info');
			}

			$this->data['success']  = true;
			$this->data['redirect'] = base_url('administrator/purchase_order');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}
		$this->response($this->data);
	}

	public function auto_restock($produk_id)
	{
		$this->is_allowed('purchase_order_add');
		$produk = $this->db->get_where('produk', ['id' => $produk_id])->row();
		if (!$produk) {
			set_message('Produk tidak ditemukan.', 'error');
			redirect('administrator/dashboard');
		}

		$supplier_id = null;
		$last_po_item = $this->db->select('purchase_order.supplier_id')
			->join('purchase_order', 'purchase_order.id = purchase_order_item.po_id')
			->where('purchase_order_item.produk_id', $produk_id)
			->order_by('purchase_order.tanggal_po', 'DESC')
			->limit(1)
			->get('purchase_order_item')->row();
			
		if ($last_po_item) {
			$supplier_id = $last_po_item->supplier_id;
		} else {
			$supp = $this->db->where('status', 'aktif')->get('supplier')->row();
			if($supp) $supplier_id = $supp->id;
		}

		$data = [
			'nomor_po' => $this->model_purchase_order->generate_nomor(),
			'supplier_id' => $supplier_id,
			'tanggal_po' => date('Y-m-d'),
			'mata_uang' => 'IDR',
			'kurs' => 1,
			'status' => 'draft',
			'created_by' => get_user_data('username'),
			'created_at' => date('Y-m-d H:i:s'),
		];
		$po_id = $this->model_purchase_order->store($data);

		$qty = $produk->stok_minimum > 0 ? $produk->stok_minimum * 2 : 10;
		$harga = $produk->harga_beli;

		$this->db->insert('purchase_order_item', [
			'po_id' => $po_id,
			'produk_id' => $produk_id,
			'qty_pesan' => $qty,
			'harga_satuan' => $harga,
			'subtotal' => $qty * $harga,
		]);
		
		$this->model_purchase_order->update_total($po_id);

		set_message('Draft Auto Restock berhasil dibuat. Silakan lengkapi data PO ini.', 'success');
		redirect('administrator/purchase_order/edit/' . $po_id);
	}

	public function view($id)
	{
		$this->is_allowed('purchase_order_view');
		$this->data['po']               = $this->model_purchase_order->find_with_detail($id);
		$this->data['items']            = $this->model_purchase_order->get_items($id);
		$this->data['penerimaans']      = $this->model_purchase_order->get_penerimaan_list($id);
		$this->data['draft_penerimaan'] = $this->model_purchase_order->get_draft_penerimaan($id);
		$this->template->title('Detail Purchase Order');
		$this->render('backend/standart/administrator/purchase_order/purchase_order_view', $this->data);
	}

	public function submit($id)
	{
		$this->is_allowed('purchase_order_update');
		$this->complete_po_and_sync_inventory($id);
		set_message('Purchase Order berhasil diselesaikan! Stok produk otomatis bertambah dan tagihan Utang Usaha telah dicatat.', 'success');
		redirect('administrator/purchase_order/view/' . $id);
	}

	public function approve($id)
	{
		$this->is_allowed('purchase_order_update');
		$this->complete_po_and_sync_inventory($id);
		set_message('Purchase Order berhasil diselesaikan! Stok produk otomatis bertambah dan tagihan Utang Usaha telah dicatat.', 'success');
		redirect('administrator/purchase_order/view/' . $id);
	}

	public function complete($id)
	{
		$this->is_allowed('purchase_order_update');
		$this->complete_po_and_sync_inventory($id);
		set_message('Purchase Order berhasil diselesaikan! Stok produk otomatis bertambah dan tagihan Utang Usaha telah dicatat.', 'success');
		redirect('administrator/purchase_order/view/' . $id);
	}

	public function quick_add_supplier()
	{
		$nama_supplier = trim($this->input->post('nama_supplier'));
		if (empty($nama_supplier)) {
			return $this->response(['success' => false, 'message' => 'Nama Supplier wajib diisi!']);
		}

		$this->load->model('supplier/model_supplier');
		$kode = $this->model_supplier->generate_kode();

		$data = [
			'kode_supplier'  => $kode,
			'nama_supplier'  => $nama_supplier,
			'kontak_person'  => $this->input->post('kontak_person') ?: '-',
			'telepon'        => $this->input->post('telepon') ?: '-',
			'no_telp'        => $this->input->post('telepon') ?: '-',
			'alamat'         => $this->input->post('alamat') ?: '-',
			'mata_uang'      => $this->input->post('mata_uang') ?: 'IDR',
			'status'         => 'aktif',
			'created_by'     => get_user_data('username') ?: 'admin',
			'created_at'     => date('Y-m-d H:i:s'),
		];

		$this->db->insert('supplier', $data);
		$supplier_id = $this->db->insert_id();

		return $this->response([
			'success'       => true,
			'supplier_id'   => $supplier_id,
			'kode_supplier' => $kode,
			'nama_supplier' => $nama_supplier,
			'mata_uang'     => $data['mata_uang'],
			'message'       => 'Supplier berhasil ditambahkan.'
		]);
	}

	public function complete_po_and_sync_inventory($po_id)
	{
		$po = $this->db->get_where('purchase_order', ['id' => $po_id])->row();
		if (!$po) return false;

		// 1. Mark PO as completed
		$this->db->update('purchase_order', [
			'status'         => 'completed',
			'approval_level' => 1,
			'approved_by'    => get_user_data('username') ?: 'admin',
			'approved_at'    => date('Y-m-d H:i:s'),
			'updated_at'     => date('Y-m-d H:i:s')
		], ['id' => $po_id]);

		// Record price history
		$this->model_purchase_order->record_price_history($po_id);

		// 2. Fetch items and add stock directly
		$items = $this->db->get_where('purchase_order_item', ['po_id' => $po_id])->result();

		$supplier = $this->db->get_where('supplier', ['id' => $po->supplier_id])->row();
		$supplier_name = $supplier ? $supplier->nama_supplier : 'Supplier';
		$rate = ((float)$po->kurs > 0) ? (float)$po->kurs : 1.0;

		foreach ($items as $it) {
			$qty = (float)$it->qty_pesan;
			if ($qty <= 0) continue;

			// Check existing stock record
			$curr_stok = $this->db->get_where('stok', [
				'produk_id' => $it->produk_id
			])->row();

			if ($curr_stok) {
				$this->db->where('id', $curr_stok->id)->update('stok', [
					'qty'        => (float)$curr_stok->qty + $qty,
					'updated_at' => date('Y-m-d H:i:s')
				]);
			} else {
				$this->db->insert('stok', [
					'produk_id'  => $it->produk_id,
					'qty'        => $qty,
					'qty_rusak'  => 0,
					'updated_at' => date('Y-m-d H:i:s')
				]);
			}

			// Konversi harga beli ke IDR jika transaksi menggunakan mata uang asing
			$harga_beli_idr = ($po->mata_uang !== 'IDR' && $rate > 0)
				? round((float)$it->harga_satuan * $rate, 2)
				: (float)$it->harga_satuan;

			// Update harga_beli in master produk (selalu dalam IDR)
			if ($harga_beli_idr > 0) {
				$curr_prod = $this->db->get_where('produk', ['id' => $it->produk_id])->row();
				if ($curr_prod) {
					// Jika transaksi menggunakan valuta asing, hindari pergeseran pembulatan desimal sen (rounding drift)
					// Misal: Rp 50.000 dikonversi ke USD 2.76, lalu saat dikalikan kurs kembali menjadi Rp 50.091 (selisih < 1 sen USD).
					// Jika selisihnya di bawah nilai 1 sen mata uang asing, pertahankan harga master awal yang bulat.
					if ($po->mata_uang !== 'IDR' && $rate > 0) {
						$one_cent_idr = $rate * 0.01;
						if (abs($harga_beli_idr - (float)$curr_prod->harga_beli) <= ceil($one_cent_idr)) {
							$harga_beli_idr = (float)$curr_prod->harga_beli;
						}
					}

					if ((float)$curr_prod->harga_beli != $harga_beli_idr) {
						// Catat riwayat audit perubahan harga master produk
						$this->db->insert('produk_harga_log', [
							'produk_id'       => $it->produk_id,
							'tipe_perubahan'  => 'purchase_order',
							'supplier_id'     => $po->supplier_id,
							'nomor_po'        => $po->nomor_po,
							'harga_beli_lama' => (float)$curr_prod->harga_beli,
							'harga_beli_baru' => $harga_beli_idr,
							'harga_jual_lama' => (float)$curr_prod->harga_jual,
							'harga_jual_baru' => (float)$curr_prod->harga_jual,
							'catatan'         => 'Update Otomatis dari PO #' . $po->nomor_po . ($po->mata_uang !== 'IDR' ? ' (' . $po->mata_uang . ' ' . number_format($it->harga_satuan, 2) . ' @ kurs ' . number_format($rate, 0, ',', '.') . ')' : ''),
							'created_by'      => get_user_data('username') ?: 'System',
							'created_at'      => date('Y-m-d H:i:s'),
						]);

						$this->db->where('id', $it->produk_id)->update('produk', [
							'harga_beli' => $harga_beli_idr,
							'updated_at' => date('Y-m-d H:i:s')
						]);
					}
				}
			}

			// Record in stok_log
			$keterangan_log = 'Pembelian PO #' . $po->nomor_po . ' dari ' . $supplier_name;
			if ($po->mata_uang !== 'IDR') {
				$keterangan_log .= ' (' . $po->mata_uang . ' ' . number_format($it->harga_satuan, 2) . ' @ kurs ' . number_format($rate, 0, ',', '.') . ')';
			}

			$this->db->insert('stok_log', [
				'produk_id'      => $it->produk_id,
				'jenis'          => 'masuk',
				'qty'            => $qty,
				'harga_satuan'   => $harga_beli_idr,
				'referensi_type' => 'purchase_order',
				'referensi_id'   => $po_id,
				'keterangan'     => $keterangan_log,
				'created_by'     => get_user_data('username') ?: 'admin',
				'created_at'     => date('Y-m-d H:i:s')
			]);
		}

		// 3. Auto Generate Utang Usaha (Accounts Payable)
		$existing_utang = $this->db->get_where('utang_usaha', ['po_id' => $po_id])->row();
		if (!$existing_utang) {
			$prefix_utg = 'UTG-' . date('Ym') . '-';
			$last_utg = $this->db->like('nomor_utang', $prefix_utg, 'after')
				->order_by('id', 'DESC')->limit(1)->get('utang_usaha')->row();
			$num_utg = $last_utg ? ((int) substr($last_utg->nomor_utang, -4)) + 1 : 1;
			$nomor_utang = $prefix_utg . str_pad($num_utg, 4, '0', STR_PAD_LEFT);
			while ($this->db->where('nomor_utang', $nomor_utang)->get('utang_usaha')->num_rows() > 0) {
				$num_utg++;
				$nomor_utang = $prefix_utg . str_pad($num_utg, 4, '0', STR_PAD_LEFT);
			}

			$total_idr = (float)($po->total * ($po->kurs ?: 1));
			$jatuh_tempo = !empty($po->tanggal_estimasi) ? $po->tanggal_estimasi : date('Y-m-d', strtotime('+30 days'));

			$catatan_utang = 'Tagihan Pembelian PO #' . $po->nomor_po . ' (' . $supplier_name . ')';
			if ($po->mata_uang !== 'IDR') {
				$catatan_utang .= ' [' . $po->mata_uang . ' ' . number_format($po->total, 2) . ' @ kurs ' . number_format($rate, 0, ',', '.') . ']';
			}

			$this->db->insert('utang_usaha', [
				'nomor_utang'         => $nomor_utang,
				'supplier_id'         => $po->supplier_id,
				'tanggal_utang'       => $po->tanggal_po,
				'po_id'               => $po_id,
				'total'               => $total_idr,
				'terbayar'            => 0,
				'sisa'                => $total_idr,
				'subtotal'            => $total_idr,
				'tanggal_jatuh_tempo' => $jatuh_tempo,
				'status'              => 'belum_bayar',
				'catatan'             => $catatan_utang,
				'created_at'          => date('Y-m-d H:i:s')
			]);
		}

		return true;
	}

	public function save_setting()
	{
		$this->is_allowed('purchase_order_update');
		$threshold_raw = $this->input->post('po_approval_threshold');
		$threshold = (float) str_replace(['.', ','], '', $threshold_raw);
		set_option('po_approval_threshold', $threshold);

		set_message('Batas nominal threshold approval PO berhasil diperbarui menjadi Rp ' . number_format($threshold, 0, ',', '.'), 'success');
		redirect('administrator/purchase_order');
	}

	public function reject($id)
	{
		if (!$this->aauth->is_admin()) {
			set_message('Wewenang Ditolak: Penolakan Purchase Order hanya dapat dilakukan oleh Administrator / Admin Utama!', 'error');
			redirect('administrator/purchase_order/view/' . $id);
			return;
		}

		$this->db->update('purchase_order', ['status' => 'rejected', 'updated_at' => date('Y-m-d H:i:s')], ['id' => $id]);

		$this->db->insert('approval_log', [
			'referensi_type' => 'purchase_order',
			'referensi_id'   => $id,
			'level'          => 1,
			'action'         => 'rejected',
			'catatan'        => $this->input->post('catatan'),
			'created_by'     => get_user_data('username'),
			'created_at'     => date('Y-m-d H:i:s'),
		]);
		set_message('PO ditolak.', 'warning');
		redirect('administrator/purchase_order/view/' . $id);
	}


	public function edit($id)
	{
		$this->is_allowed('purchase_order_update');
		$this->data['po'] = $this->model_purchase_order->find($id);
		if (!$this->data['po'] || $this->data['po']->status != 'draft') {
			set_message('Hanya data berstatus Draft yang bisa diedit.', 'error');
			redirect('administrator/purchase_order');
		}
		$this->data['suppliers']  = $this->db->where('status', 'aktif')->get('supplier')->result();
		$this->data['produks']    = $this->db->select('produk.*, satuan.nama_satuan, satuan.singkatan')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT')
			->where('produk.status', 'aktif')
			->get('produk')->result();
		$this->data['items']      = $this->model_purchase_order->get_items($id);
		$this->template->title('Edit Purchase Order');
		$this->render('backend/standart/administrator/purchase_order/purchase_order_update', $this->data);
	}

	public function edit_save($id)
	{
		if (!$this->is_allowed('purchase_order_update', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$existing = $this->model_purchase_order->find($id);
		if (!$existing || $existing->status != 'draft') {
			$this->response(['success' => false, 'message' => 'Hanya data berstatus Draft yang bisa diedit.']); return;
		}

		$data = [
			'catatan'    => $this->input->post('catatan'),
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => get_user_data('username'),
		];
		$data['supplier_id'] = $this->input->post('supplier_id');
		$data['tanggal_po'] = $this->input->post('tanggal_po');
		$data['tanggal_estimasi'] = $this->input->post('tanggal_estimasi');
		$data['mata_uang'] = $this->input->post('mata_uang');
		$data['kurs'] = $this->parse_number($this->input->post('kurs')) ?: 1;
		$data['diskon'] = $this->parse_number($this->input->post('diskon'));
		$data['pajak_persen'] = $this->parse_number($this->input->post('pajak_persen'));

		$this->model_purchase_order->change($id, $data);

		// Update items: delete old and insert new
		$this->db->delete('purchase_order_item', ['po_id' => $id]);
		if ($this->input->post('items')) {
			foreach ($this->input->post('items') as $item) {
				$qty       = max(1, (int) round($item['qty']));
				$harga     = $this->parse_number($item['harga_satuan'] ?? 0);
				$diskon    = $this->parse_number($item['diskon_persen'] ?? 0);
				$d_nom     = $harga * $qty * ($diskon / 100);
				$subtotal  = ($harga * $qty) - $d_nom;
				$this->db->insert('purchase_order_item', [
					'po_id'          => $id,
					'produk_id'      => $item['produk_id'],
					'qty_pesan'      => $qty,
					'satuan'         => $item['satuan'] ?? 'pcs',
					'harga_satuan'   => $harga,
					'diskon_persen'  => $diskon,
					'diskon_nominal' => $d_nom,
					'subtotal'       => $subtotal,
					'catatan'        => $item['catatan'] ?? '',
				]);
			}
		}
		$this->model_purchase_order->update_total($id);

		set_message('Purchase Order berhasil diupdate.', 'success');
		$this->data['success']  = true;
		$this->data['redirect'] = base_url('administrator/purchase_order');
		$this->response($this->data);
	}

	public function delete($id = null)
	{
		$this->is_allowed('purchase_order_delete');
		$po = $this->model_purchase_order->find($id);
		if ($po && $po->status == 'draft') {
			$this->db->delete('purchase_order_item', ['po_id' => $id]);
			$this->model_purchase_order->remove($id);
			set_message('PO berhasil dihapus.', 'success');
		} else {
			set_message('Hanya PO berstatus Draft yang bisa dihapus.', 'error');
		}
		redirect('administrator/purchase_order');
	}

	public function export()
	{
		$this->is_allowed('purchase_order_export');

		@ini_set('memory_limit', '512M');
		@set_time_limit(180);

		$filter = $this->input->get('q');
		$field  = $this->input->get('f');

		$pos = $this->model_purchase_order->get($filter, $field, 0, 0);

		$filename = 'Purchase_Order_' . date('Y-m-d') . '.xls';

		if (ob_get_length()) { ob_end_clean(); }

		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		header('Pragma: public');

		echo "<!DOCTYPE html>\n<html>\n<head>\n<meta charset=\"utf-8\">\n";
		echo "<style>
			th { background-color: #1E40AF; color: #ffffff; font-weight: bold; padding: 9px 12px; border: 1px solid #1E3A8A; text-align: center; font-family: Calibri, Arial, sans-serif; font-size: 11pt; white-space: nowrap; }
			td { padding: 7px 12px; border: 1px solid #cbd5e1; font-family: Calibri, Arial, sans-serif; font-size: 10pt; vertical-align: middle; white-space: nowrap; }
			.zebra { background-color: #F8FAFC; }
			.num { mso-number-format:\"\\#\\,\\#\\#0\"; text-align: right; }
			.currency { mso-number-format:\"\\\"Rp\\\"\\ \\#\\,\\#\\#0\"; text-align: right; font-weight: bold; }
			.text { mso-number-format:\"\\@\"; }
			.center { text-align: center; }
			.bold { font-weight: bold; }
		</style>\n</head>\n<body>\n";

		$headers = [
			'No',
			'Nomor PO',
			'Tanggal Order',
			'Supplier',
			'Mata Uang',
			'Grand Total',
			'Subtotal',
			'Diskon',
			'Kurs Valas',
			'Est. Datang',
			'Status'
		];

		echo "<table border=\"1\" cellpadding=\"6\" cellspacing=\"0\" style=\"border-collapse:collapse;\">\n";
		echo "<colgroup>
			<col width=\"50\">
			<col width=\"145\">
			<col width=\"115\">
			<col width=\"220\">
			<col width=\"85\">
			<col width=\"190\">
			<col width=\"140\">
			<col width=\"100\">
			<col width=\"110\">
			<col width=\"115\">
			<col width=\"180\">
		</colgroup>\n";
		echo "<thead>\n<tr>\n";
		foreach ($headers as $h) {
			echo '<th>' . htmlspecialchars($h) . "</th>\n";
		}
		echo "</tr>\n</thead>\n<tbody>\n";

		$no = 1;
		foreach ($pos as $po) {
			$cls_row = ($no % 2 === 0) ? ' class="zebra"' : '';
			$mata_uang = !empty($po->mata_uang) ? strtoupper($po->mata_uang) : 'IDR';
			$kurs = (float) ($po->kurs ?? 1);
			if ($kurs <= 0) $kurs = 1;

			$subtotal_valas = (float) ($po->subtotal ?? 0);
			$diskon_valas   = (float) ($po->diskon ?? 0);
			$total_valas    = (float) ($po->total ?? 0);
			$total_rp       = $total_valas * $kurs;

			if ($mata_uang !== 'IDR') {
				$grand_total_display = $mata_uang . ' ' . number_format($total_valas, 2, ',', '.') . ' (Rp ' . number_format($total_rp, 0, ',', '.') . ')';
				$subtotal_display    = $mata_uang . ' ' . number_format($subtotal_valas, 2, ',', '.');
				$diskon_display      = $mata_uang . ' ' . number_format($diskon_valas, 2, ',', '.');
				$kurs_display        = 'Rp ' . number_format($kurs, 0, ',', '.');
			} else {
				$grand_total_display = 'Rp ' . number_format($total_valas, 0, ',', '.');
				$subtotal_display    = 'Rp ' . number_format($subtotal_valas, 0, ',', '.');
				$diskon_display      = 'Rp ' . number_format($diskon_valas, 0, ',', '.');
				$kurs_display        = '-'; // Transaksi IDR tidak memerlukan kurs konversi valas
			}

			$tgl_po = !empty($po->tanggal_po) ? date('d/m/Y', strtotime($po->tanggal_po)) : '-';
			$est_datang = (!empty($po->tanggal_estimasi) && $po->tanggal_estimasi !== '0000-00-00') 
				? date('d/m/Y', strtotime($po->tanggal_estimasi)) 
				: '-';

			$supplier = !empty($po->nama_supplier) ? $po->nama_supplier : '-';

			if ($po->status == 'completed') {
				$status_label = 'SELESAI (MASUK STOK)';
			} elseif ($po->status == 'approved') {
				$status_label = 'DISETUJUI';
			} elseif ($po->status == 'cancelled') {
				$status_label = 'DIBATALKAN';
			} elseif ($po->status == 'draft') {
				$status_label = 'DRAFT';
			} elseif ($po->status == 'ordered') {
				$status_label = 'DIPESAN';
			} else {
				$status_label = strtoupper($po->status);
			}

			echo "<tr{$cls_row}>\n";
			echo "<td class=\"center\">" . ($no++) . "</td>\n";
			echo "<td class=\"text center bold\">" . htmlspecialchars($po->nomor_po) . "</td>\n";
			echo "<td class=\"center text\">" . $tgl_po . "</td>\n";
			echo "<td class=\"bold\">" . htmlspecialchars($supplier) . "</td>\n";
			echo "<td class=\"center bold\">" . htmlspecialchars($mata_uang) . "</td>\n";
			echo "<td class=\"bold\" style=\"text-align:right;\">" . htmlspecialchars($grand_total_display) . "</td>\n";
			echo "<td style=\"text-align:right;\">" . htmlspecialchars($subtotal_display) . "</td>\n";
			echo "<td style=\"text-align:right;\">" . htmlspecialchars($diskon_display) . "</td>\n";
			echo "<td class=\"center\">" . htmlspecialchars($kurs_display) . "</td>\n";
			echo "<td class=\"center text\">" . $est_datang . "</td>\n";
			echo "<td class=\"center bold\">" . htmlspecialchars($status_label) . "</td>\n";
			echo "</tr>\n";
		}

		echo "</tbody>\n</table>\n</body>\n</html>";
		exit;
	}

	public function export_csv()
	{
		$this->is_allowed('purchase_order_export');

		@ini_set('memory_limit', '512M');
		@set_time_limit(180);

		$filter = $this->input->get('q');
		$field  = $this->input->get('f');

		$pos = $this->model_purchase_order->get($filter, $field, 0, 0);

		$filename = 'Purchase_Order_' . date('Y-m-d') . '.csv';

		if (ob_get_length()) { ob_end_clean(); }

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		header('Pragma: public');

		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fwrite($output, "sep=;\r\n");

		$headers = [
			'No',
			'Nomor PO',
			'Tanggal Order',
			'Supplier',
			'Mata Uang',
			'Grand Total',
			'Subtotal',
			'Diskon',
			'Kurs Valas',
			'Est. Datang',
			'Status'
		];
		fputcsv($output, $headers, ';');

		$no = 1;
		foreach ($pos as $po) {
			$mata_uang = !empty($po->mata_uang) ? strtoupper($po->mata_uang) : 'IDR';
			$kurs = (float) ($po->kurs ?? 1);
			if ($kurs <= 0) $kurs = 1;

			$subtotal_valas = (float) ($po->subtotal ?? 0);
			$diskon_valas   = (float) ($po->diskon ?? 0);
			$total_valas    = (float) ($po->total ?? 0);
			$total_rp       = $total_valas * $kurs;

			if ($mata_uang !== 'IDR') {
				$grand_total_display = $mata_uang . ' ' . number_format($total_valas, 2, ',', '.') . ' (Rp ' . number_format($total_rp, 0, ',', '.') . ')';
				$subtotal_display    = $mata_uang . ' ' . number_format($subtotal_valas, 2, ',', '.');
				$diskon_display      = $mata_uang . ' ' . number_format($diskon_valas, 2, ',', '.');
				$kurs_display        = 'Rp ' . number_format($kurs, 0, ',', '.');
			} else {
				$grand_total_display = 'Rp ' . number_format($total_valas, 0, ',', '.');
				$subtotal_display    = 'Rp ' . number_format($subtotal_valas, 0, ',', '.');
				$diskon_display      = 'Rp ' . number_format($diskon_valas, 0, ',', '.');
				$kurs_display        = '-'; // Transaksi IDR tidak memerlukan kurs konversi valas
			}

			$tgl_po = !empty($po->tanggal_po) ? date('d/m/Y', strtotime($po->tanggal_po)) : '-';
			$est_datang = (!empty($po->tanggal_estimasi) && $po->tanggal_estimasi !== '0000-00-00') 
				? date('d/m/Y', strtotime($po->tanggal_estimasi)) 
				: '-';

			$supplier = !empty($po->nama_supplier) ? $po->nama_supplier : '-';

			if ($po->status == 'completed') {
				$status_label = 'SELESAI (MASUK STOK)';
			} elseif ($po->status == 'approved') {
				$status_label = 'DISETUJUI';
			} elseif ($po->status == 'cancelled') {
				$status_label = 'DIBATALKAN';
			} elseif ($po->status == 'draft') {
				$status_label = 'DRAFT';
			} elseif ($po->status == 'ordered') {
				$status_label = 'DIPESAN';
			} else {
				$status_label = strtoupper($po->status);
			}

			fputcsv($output, [
				$no++,
				$po->nomor_po,
				$tgl_po,
				$supplier,
				$mata_uang,
				$grand_total_display,
				$subtotal_display,
				$diskon_display,
				$kurs_display,
				$est_datang,
				$status_label
			], ';');
		}

		fclose($output);
		exit;
	}

	

	

	public function cetak($id)
	{
		$this->is_allowed('purchase_order_view');
		$this->data['po'] = $this->model_purchase_order->join_available()->find($id);
		$this->data['items'] = $this->model_purchase_order->get_items($id);
		
		$this->load->library('HtmlPdf');
		$this->htmlpdf->initialize(['orientation' => 'P', 'format' => 'A4', 'marges' => [5, 5, 5, 5]]);
		$content = $this->load->view('purchase_order/backend/standart/administrator/purchase_order/purchase_order_pdf', $this->data, true);
		
		$this->htmlpdf->writeHTML($content);
		$po = $this->data['po'];
		$doc_num = preg_replace('/[^a-zA-Z0-9_-]/', '_', $po->nomor_po ?? $id);
		$filename = 'purchase_order_' . $doc_num . '.pdf';
		if (ob_get_length()) { ob_clean(); }
		$this->htmlpdf->Output($filename, 'D');
	}

	public function get_live_rates()
	{
		$url = 'https://open.er-api.com/v6/latest/USD';
		$json = @file_get_contents($url);

		if ($json) {
			$data = json_decode($json, true);
			if (isset($data['result']) && $data['result'] == 'success' && isset($data['rates'])) {
				$rates = $data['rates'];
				$idr = isset($rates['IDR']) ? (float)$rates['IDR'] : 16200;

				$calculated = [
					'IDR' => 1,
					'USD' => round($idr, 2),
					'EUR' => isset($rates['EUR']) && $rates['EUR'] > 0 ? round($idr / $rates['EUR'], 2) : 17500,
					'SGD' => isset($rates['SGD']) && $rates['SGD'] > 0 ? round($idr / $rates['SGD'], 2) : 12000,
					'JPY' => isset($rates['JPY']) && $rates['JPY'] > 0 ? round($idr / $rates['JPY'], 2) : 110,
					'CNY' => isset($rates['CNY']) && $rates['CNY'] > 0 ? round($idr / $rates['CNY'], 2) : 2250,
					'GBP' => isset($rates['GBP']) && $rates['GBP'] > 0 ? round($idr / $rates['GBP'], 2) : 20800,
					'AUD' => isset($rates['AUD']) && $rates['AUD'] > 0 ? round($idr / $rates['AUD'], 2) : 10500,
				];

				$this->response([
					'success' => true,
					'provider' => 'ExchangeRate-API (open.er-api.com)',
					'last_update' => $data['time_last_update_utc'] ?? date('r'),
					'rates' => $calculated
				]);
				return;
			}
		}

		$this->response(['success' => false, 'message' => 'Gagal mengambil data kurs dari API']);
	}

	public function export_pdf()
	{
		$this->is_allowed('purchase_order_export');

		@ini_set('memory_limit', '512M');
		@set_time_limit(180);

		$filter = $this->input->get('q');
		$field  = $this->input->get('f');

		$pos = $this->model_purchase_order->get($filter, $field, 0, 0);

		$total_nilai_rp = 0;
		$total_selesai  = 0;
		$total_pending  = 0;

		foreach ($pos as $po) {
			$kurs = (float) ($po->kurs ?? 1);
			if ($kurs <= 0) $kurs = 1;
			$total_rp = ((float) $po->total) * $kurs;
			$total_nilai_rp += $total_rp;

			if ($po->status === 'completed') {
				$total_selesai++;
			} else {
				$total_pending++;
			}
		}

		$this->load->library('HtmlPdf');
		$config = [
			'orientation' => 'L',
			'format'      => 'A4',
			'marges'      => [8, 8, 8, 8]
		];

		$this->htmlpdf->initialize($config);

		$html = $this->load->view('backend/standart/administrator/purchase_order/purchase_order_rekap_pdf', [
			'pos'            => $pos,
			'total_nilai_rp' => $total_nilai_rp,
			'total_selesai'  => $total_selesai,
			'total_pending'  => $total_pending,
			'filter'         => $filter,
		], true);

		$this->htmlpdf->writeHTML($html);
		if (ob_get_length()) { ob_end_clean(); }
		$this->htmlpdf->Output('Rekap_Purchase_Order_' . date('Y-m-d') . '.pdf', 'I');
		exit;
	}

}
