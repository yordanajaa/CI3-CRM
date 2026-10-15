<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Stok extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_stok');
	}

	public function index($offset = 0)
	{
		$this->is_allowed('stok_list');
		$filter    = $this->input->get('q');
		$field     = $this->input->get('f');
		$gudang_id = $this->input->get('gudang_id');
		$status    = $this->input->get('status');
		$per_page  = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 100;
		if ($per_page <= 0) $per_page = 100;

		$this->data['stoks']       = $this->model_stok->get($filter, $field, $per_page, $offset, $gudang_id, $status);
		$this->data['stok_counts'] = $this->model_stok->count_all($filter, $field, $gudang_id, $status);
		$this->data['summary']     = $this->model_stok->get_summary_dashboard($gudang_id);
		$this->data['menipis']     = $this->model_stok->get_stok_menipis($gudang_id);
		$this->data['gudangs']     = $this->db->get_where('gudang', ['status' => 'aktif'])->result();
		$this->data['gudang_sel']  = $gudang_id;
		$this->data['status_sel']  = $status;
		$this->data['per_page']    = $per_page;

		$config = [
			'base_url'           => 'administrator/stok/index/', 
			'total_rows'         => $this->data['stok_counts'], 
			'per_page'           => $per_page, 
			'uri_segment'        => 4,
			'reuse_query_string' => true,
		];
		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Dashboard Stok');
		$this->render('backend/standart/administrator/stok/stok_list', $this->data);
	}

	public function menipis()
	{
		$this->is_allowed('stok_list');
		$gudang_id = $this->input->get('gudang_id');

		$this->data['stoks']       = $this->model_stok->get_stok_menipis($gudang_id);
		$this->data['stok_counts'] = count($this->data['stoks']);
		$this->data['summary']     = $this->model_stok->get_summary_dashboard($gudang_id);
		$this->data['menipis']     = $this->data['stoks'];
		$this->data['gudangs']     = $this->db->get('gudang')->result();
		$this->data['gudang_sel']  = $gudang_id;
		$this->data['pagination']  = '';

		$this->template->title('Peringatan Stok Menipis & Habis');
		$this->render('backend/standart/administrator/stok/stok_list', $this->data);
	}

	public function kartu($produk_id = null)
	{
		$this->is_allowed('stok_list');
		if (empty($produk_id)) {
			$first = $this->db->where('status', 'aktif')->order_by('id', 'ASC')->get('produk')->row();
			if ($first) {
				redirect('administrator/stok/kartu/' . $first->id);
				return;
			}
		}

		$gudang_id  = $this->input->get('gudang_id');
		$date_start = $this->input->get('date_start');
		$date_end   = $this->input->get('date_end');

		$this->data['produk']      = $this->db->get_where('produk', ['id' => $produk_id])->row();
		$this->data['kartu']       = $this->model_stok->get_kartu_stok($produk_id, $gudang_id, $date_start, $date_end);
		$this->data['all_produks'] = $this->db->where('status', 'aktif')->order_by('id', 'ASC')->get('produk')->result();
		$this->data['gudangs']     = $this->db->get('gudang')->result();
		$this->data['gudang_sel']  = $gudang_id;
		$this->data['date_start']  = $date_start;
		$this->data['date_end']    = $date_end;

		$this->template->title('Kartu Stok - ' . ($this->data['produk'] ? $this->data['produk']->nama_produk : ''));
		$this->render('backend/standart/administrator/stok/stok_kartu', $this->data);
	}

	public function api_summary()
	{
		$gudang_id = $this->input->get('gudang_id');
		$summary   = $this->model_stok->get_summary_dashboard($gudang_id);
		$this->response(['success' => true, 'data' => $summary]);
	}

	public function batch_tracking()
	{
		$this->is_allowed('stok_list');
		$produk_id  = $this->input->get('produk_id');
		$gudang_id  = $this->input->get('gudang_id');
		$date_start = $this->input->get('date_start');
		$date_end   = $this->input->get('date_end');

		// Batch summary: current batches per product per gudang
		$this->db->select('pbi.batch_no, pbi.expired_date, p.kode_produk, p.nama_produk, g.nama_gudang, r.kode_rak, r.baris, r.kolom, r.keterangan as rak_keterangan, MAX(pb.tanggal_terima) as tanggal_terima, MAX(pb.nomor_penerimaan) as nomor_penerimaan, SUM(pbi.qty_baik) as total_qty_masuk');
		$this->db->from('penerimaan_barang_item pbi');
		$this->db->join('penerimaan_barang pb', 'pb.id = pbi.penerimaan_id');
		$this->db->join('produk p', 'p.id = pbi.produk_id');
		$this->db->join('gudang g', 'g.id = pb.gudang_id');
		$this->db->join('stok s', 's.produk_id = pbi.produk_id AND s.gudang_id = pb.gudang_id', 'LEFT');
		$this->db->join('rak r', 'r.id = IFNULL(s.rak_id, p.default_rak_id)', 'LEFT');
		$this->db->where('pb.status', 'confirmed');
		$this->db->where('pbi.batch_no IS NOT NULL', null, false);
		$this->db->where("pbi.batch_no != ''", null, false);
		if ($produk_id) $this->db->where('pbi.produk_id', $produk_id);
		if ($gudang_id) $this->db->where('pb.gudang_id', $gudang_id);
		if ($date_start) $this->db->where('pb.tanggal_terima >=', $date_start);
		if ($date_end) $this->db->where('pb.tanggal_terima <=', $date_end);
		$this->db->group_by('pbi.batch_no, pbi.produk_id, pb.gudang_id, pbi.expired_date, p.kode_produk, p.nama_produk, g.nama_gudang, r.kode_rak, r.baris, r.kolom, r.keterangan');
		$this->db->order_by('tanggal_terima', 'DESC');

		$this->data['batches']    = $this->db->get()->result();
		$this->data['produks']    = $this->db->where('status', 'aktif')->get('produk')->result();
		$this->data['gudangs']    = $this->db->get('gudang')->result();
		$this->data['produk_sel'] = $produk_id;
		$this->data['gudang_sel'] = $gudang_id;
		$this->data['date_start'] = $date_start;
		$this->data['date_end']   = $date_end;

		// Products expiring within 30 days
		$this->data['kadaluarsa_soon'] = $this->db->query("
			SELECT pbi.batch_no, pbi.expired_date, p.kode_produk, p.nama_produk, g.nama_gudang, SUM(pbi.qty_baik) as qty
			FROM penerimaan_barang_item pbi
			JOIN penerimaan_barang pb ON pb.id = pbi.penerimaan_id
			JOIN produk p ON p.id = pbi.produk_id
			JOIN gudang g ON g.id = pb.gudang_id
			WHERE pb.status = 'confirmed' AND pbi.expired_date IS NOT NULL AND pbi.expired_date > '1900-01-01'
			AND pbi.expired_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
			GROUP BY pbi.batch_no, pbi.produk_id, pb.gudang_id, pbi.expired_date, p.kode_produk, p.nama_produk, g.nama_gudang
			ORDER BY pbi.expired_date ASC
		")->result();

		$this->template->title('Laporan Batch & Lot Tracking');
		$this->render('backend/standart/administrator/stok/stok_batch', $this->data);
	}

	public function api_chart()
	{
		// Chart data: stok masuk vs keluar per hari (30 hari terakhir)
		$days = [];
		for ($i = 29; $i >= 0; $i--) {
			$date = date('Y-m-d', strtotime("-{$i} days"));
			$masuk  = $this->db->select('SUM(qty) AS total')->where('jenis', 'masuk')->where('DATE(created_at)', $date)->get('stok_log')->row();
			$keluar = $this->db->select('SUM(qty) AS total')->where('jenis', 'keluar')->where('DATE(created_at)', $date)->get('stok_log')->row();
			$days[] = [
				'date'   => $date,
				'masuk'  => $masuk ? (float) $masuk->total : 0,
				'keluar' => $keluar ? (float) $keluar->total : 0,
			];
		}
		$this->response(['success' => true, 'data' => $days]);
	}

	public function export()
	{
		$this->is_allowed('stok_export');
		$gudang_id = $this->input->get('gudang_id');
		$this->model_stok->join_available();
		if ($gudang_id) $this->db->where('stok.gudang_id', $gudang_id);
		$this->model_stok->export('stok', 'stok_export');
	}

	public function add()
	{
		$this->is_allowed('stok_add');
		$this->data['produks'] = $this->db->select('produk.*, satuan.singkatan as nama_satuan')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT')
			->where('produk.status', 'aktif')
			->order_by('produk.id', 'ASC')
			->get('produk')->result();
		$this->data['gudangs'] = $this->db->get_where('gudang', ['status' => 'aktif'])->result();
		$this->data['raks']    = $this->db->order_by('kode_rak', 'ASC')->get('rak')->result();
		$this->template->title('Input Stok Manual');
		$this->render('backend/standart/administrator/stok/stok_add', $this->data);
	}

	public function get_current_stok()
	{
		$produk_id = (int) $this->input->get('produk_id');
		$gudang_id = (int) $this->input->get('gudang_id');

		if (!$produk_id || !$gudang_id) {
			$this->response(['success' => false, 'message' => 'Parameter tidak lengkap']);
			return;
		}

		$stok = $this->db->select('stok.*, rak.kode_rak, rak.baris, rak.kolom')
			->join('rak', 'rak.id = stok.rak_id', 'LEFT')
			->get_where('stok', ['produk_id' => $produk_id, 'gudang_id' => $gudang_id])
			->row();

		$produk = $this->db->select('produk.*, satuan.singkatan as nama_satuan')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT')
			->get_where('produk', ['produk.id' => $produk_id])
			->row();

		$this->response([
			'success'     => true,
			'exists'      => !empty($stok),
			'qty'         => $stok ? (float) $stok->qty : 0,
			'qty_rusak'   => $stok ? (float) $stok->qty_rusak : 0,
			'rak_id'      => $stok ? $stok->rak_id : ($produk ? $produk->default_rak_id : null),
			'kode_rak'    => $stok ? ($stok->kode_rak ?: '-') : '-',
			'nama_satuan' => $produk ? ($produk->nama_satuan ?: 'Pcs') : 'Pcs',
			'nama_produk' => $produk ? $produk->nama_produk : '',
			'kode_produk' => $produk ? $produk->kode_produk : '',
		]);
	}

	public function add_save()
	{
		if (!$this->is_allowed('stok_add', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$this->form_validation->set_rules('produk_id', 'Produk', 'trim|required|numeric');
		$this->form_validation->set_rules('gudang_id', 'Gudang', 'trim|required|numeric');
		$this->form_validation->set_rules('qty', 'Jumlah Qty', 'trim|required|numeric');

		if ($this->form_validation->run()) {
			$produk_id  = (int) $this->input->post('produk_id');
			$gudang_id  = (int) $this->input->post('gudang_id');
			$rak_id     = $this->input->post('rak_id') ? (int) $this->input->post('rak_id') : null;
			$mode       = $this->input->post('mode') ?: 'set'; // 'set', 'tambah', 'kurang'
			$input_qty  = (float) $this->input->post('qty');
			$qty_rusak  = $this->input->post('qty_rusak') !== null && $this->input->post('qty_rusak') !== '' ? (float) $this->input->post('qty_rusak') : 0;
			$keterangan = trim($this->input->post('keterangan'));
			if (empty($keterangan)) {
				$keterangan = 'Input Penyesuaian Manual Stok';
			}

			// Ambil stok sekarang
			$existing    = $this->db->get_where('stok', ['produk_id' => $produk_id, 'gudang_id' => $gudang_id])->row();
			$current_qty = $existing ? (float) $existing->qty : 0;

			// Hitung stok baru berdasarkan mode
			if ($mode === 'tambah') {
				$new_qty   = $current_qty + $input_qty;
				$jenis_log = 'masuk';
				$selisih   = $input_qty;
			} elseif ($mode === 'kurang') {
				$new_qty   = max(0, $current_qty - $input_qty);
				$jenis_log = 'keluar';
				$selisih   = $input_qty;
			} else { // 'set'
				$new_qty   = max(0, $input_qty);
				$selisih   = abs($new_qty - $current_qty);
				$jenis_log = 'penyesuaian';
			}

			// Simpan / update ke table stok
			$data_stok = [
				'qty'       => $new_qty,
				'qty_rusak' => $qty_rusak,
				'updated_at'=> date('Y-m-d H:i:s'),
			];
			if ($rak_id) {
				$data_stok['rak_id'] = $rak_id;
			}

			if ($existing) {
				$this->db->update('stok', $data_stok, ['id' => $existing->id]);
				$stok_id = $existing->id;
			} else {
				$data_stok['produk_id'] = $produk_id;
				$data_stok['gudang_id'] = $gudang_id;
				$stok_id = $this->model_stok->store($data_stok);
			}

			// Catat mutasi ke stok_log
			$this->db->insert('stok_log', [
				'produk_id'      => $produk_id,
				'gudang_id'      => $gudang_id,
				'jenis'          => $jenis_log,
				'qty'            => $selisih > 0 ? $selisih : $new_qty,
				'keterangan'     => $keterangan . " (Mode: {$mode}, Stok: {$current_qty} -> {$new_qty})",
				'referensi_type' => 'manual',
				'referensi_id'   => $stok_id,
				'created_by'     => get_user_data('username') ?: 'admin',
				'created_at'     => date('Y-m-d H:i:s'),
			]);

			$msg = 'Data Stok berhasil disimpan.';
			set_message($msg, 'success');
			$this->response([
				'success'  => true,
				'message'  => $msg,
				'redirect' => site_url('administrator/stok')
			]);
		} else {
			$this->response([
				'success' => false,
				'message' => validation_errors()
			]);
		}
	}

	public function edit($id)
	{
		$this->is_allowed('stok_update');
		$this->model_stok->join_available();
		$this->data['stok']    = $this->db->get_where('stok', ['stok.id' => $id])->row();
		if (!$this->data['stok']) {
			set_message('Data stok tidak ditemukan.', 'danger');
			redirect('administrator/stok');
			return;
		}
		$this->data['raks']    = $this->db->order_by('kode_rak', 'ASC')->get('rak')->result();
		$this->template->title('Sesuaikan Stok - ' . $this->data['stok']->nama_produk);
		$this->render('backend/standart/administrator/stok/stok_update', $this->data);
	}

	public function edit_save($id)
	{
		if (!$this->is_allowed('stok_update', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$this->form_validation->set_rules('qty', 'Qty Stok Baik', 'trim|required|numeric');

		if ($this->form_validation->run()) {
			$existing = $this->db->get_where('stok', ['id' => $id])->row();
			if (!$existing) {
				$this->response(['success' => false, 'message' => 'Data stok tidak ditemukan']);
				return;
			}

			$current_qty = (float) $existing->qty;
			$mode        = $this->input->post('mode') ?: 'set';
			$input_qty   = (float) $this->input->post('qty');
			$qty_rusak   = $this->input->post('qty_rusak') !== null && $this->input->post('qty_rusak') !== '' ? (float) $this->input->post('qty_rusak') : (float) $existing->qty_rusak;
			$rak_id      = $this->input->post('rak_id') ? (int) $this->input->post('rak_id') : $existing->rak_id;
			$keterangan  = trim($this->input->post('keterangan'));
			if (empty($keterangan)) {
				$keterangan = 'Penyesuaian Manual Stok';
			}

			if ($mode === 'tambah') {
				$new_qty   = $current_qty + $input_qty;
				$jenis_log = 'masuk';
				$selisih   = $input_qty;
			} elseif ($mode === 'kurang') {
				$new_qty   = max(0, $current_qty - $input_qty);
				$jenis_log = 'keluar';
				$selisih   = $input_qty;
			} else {
				$new_qty   = max(0, $input_qty);
				$selisih   = abs($new_qty - $current_qty);
				$jenis_log = 'penyesuaian';
			}

			$data_update = [
				'qty'        => $new_qty,
				'qty_rusak'  => $qty_rusak,
				'rak_id'     => $rak_id,
				'updated_at' => date('Y-m-d H:i:s'),
			];
			$this->db->update('stok', $data_update, ['id' => $id]);

			// Catat mutasi ke stok_log
			$this->db->insert('stok_log', [
				'produk_id'      => $existing->produk_id,
				'gudang_id'      => $existing->gudang_id,
				'jenis'          => $jenis_log,
				'qty'            => $selisih > 0 ? $selisih : $new_qty,
				'keterangan'     => $keterangan . " (Mode: {$mode}, Stok: {$current_qty} -> {$new_qty})",
				'referensi_type' => 'manual',
				'referensi_id'   => $id,
				'created_by'     => get_user_data('username') ?: 'admin',
				'created_at'     => date('Y-m-d H:i:s'),
			]);

			$msg = 'Data Stok berhasil diperbarui.';
			set_message($msg, 'success');
			$this->response([
				'success'  => true,
				'message'  => $msg,
				'redirect' => site_url('administrator/stok')
			]);
		} else {
			$this->response([
				'success' => false,
				'message' => validation_errors()
			]);
		}
	}

	public function view($id)
	{
		$this->is_allowed('stok_view');
		$this->model_stok->join_available();
		$this->data['stok']  = $this->db->get_where('stok', ['stok.id' => $id])->row();
		$this->template->title('Detail Stok Barang');
		$this->render('backend/standart/administrator/stok/stok_view', $this->data);
	}

	public function delete($id = null)
	{
		$this->is_allowed('stok_delete');

		$redirect_url = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url('administrator/stok');

		$stok = $this->db->get_where('stok', ['id' => $id])->row();
		if (!$stok) {
			set_message('Data stok tidak ditemukan.', 'danger');
			redirect($redirect_url);
			return;
		}

		$current_qty = (float) $stok->qty;

		// Jika stok kosong (<= 0), tidak boleh dihapus
		if ($current_qty <= 0) {
			set_message('Stok produk ini sudah kosong (0), tidak dapat dihapus lagi.', 'warning');
			redirect($redirect_url);
			return;
		}

		// Jika ada stok (> 0), aksi "hapus" berarti mengosongkan stok menjadi 0
		$now  = date('Y-m-d H:i:s');
		$user = get_user_data('username') ?: 'admin';

		$this->db->trans_start();

		$this->db->update('stok', [
			'qty'        => 0,
			'qty_rusak'  => 0,
			'updated_at' => $now,
		], ['id' => $id]);

		// Catat ke stok_log bahwa stok telah dikosongkan/dihapus
		$this->db->insert('stok_log', [
			'produk_id'      => $stok->produk_id,
			'gudang_id'      => $stok->gudang_id,
			'jenis'          => 'keluar',
			'qty'            => $current_qty,
			'keterangan'     => "Stok dikosongkan/dihapus secara manual dari {$current_qty} menjadi 0",
			'referensi_type' => 'manual',
			'referensi_id'   => $id,
			'created_by'     => $user,
			'created_at'     => $now,
		]);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			set_message('Terjadi kesalahan database saat mengosongkan stok.', 'danger');
		} else {
			set_message('Stok produk berhasil dihapus (dikosongkan menjadi 0).', 'success');
		}

		redirect($redirect_url);
	}

	public function edit_massal()
	{
		$this->is_allowed('stok_update');
		$gudang_id = $this->input->get('gudang_id');

		$this->data['gudangs'] = $this->db->get_where('gudang', ['status' => 'aktif'])->result();
		if ($gudang_id === null || $gudang_id === '') {
			$gudang_id = 'all';
		}

		$this->db->select('stok.*, produk.kode_produk, produk.nama_produk, produk.harga_jual, satuan.singkatan, gudang.nama_gudang, kategori_produk.nama_kategori')
			->from('stok')
			->join('produk', 'produk.id = stok.produk_id')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT')
			->join('gudang', 'gudang.id = stok.gudang_id')
			->join('kategori_produk', 'kategori_produk.id = produk.kategori_id', 'LEFT')
			->where('produk.status', 'aktif')
			->where('gudang.status', 'aktif');

		if (!empty($gudang_id) && $gudang_id !== 'all') {
			$this->db->where('stok.gudang_id', $gudang_id);
		}

		$this->data['items']      = $this->db->order_by('produk.id', 'ASC')->order_by('stok.gudang_id', 'ASC')->get()->result();
		$this->data['gudang_sel'] = $gudang_id;

		$this->template->title('Edit Semua Stok Produk (Massal)');
		$this->render('backend/standart/administrator/stok/stok_edit_massal', $this->data);
	}

	public function edit_massal_save()
	{
		if (!$this->is_allowed('stok_update', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']);
			return;
		}

		$items = $this->input->post('items');
		if (empty($items) || !is_array($items)) {
			$this->response(['success' => false, 'message' => 'Tidak ada data stok yang dikirim.']);
			return;
		}

		$updated_count = 0;
		$user = get_user_data('username') ?: 'admin';
		$now  = date('Y-m-d H:i:s');

		$this->db->trans_start();

		foreach ($items as $stok_id => $val) {
			$stok_id = (int)$stok_id;
			$existing = $this->db->get_where('stok', ['id' => $stok_id])->row();
			if (!$existing) continue;

			$old_qty = (float)$existing->qty;
			$new_qty = isset($val['qty']) && $val['qty'] !== '' ? max(0, (float)$val['qty']) : $old_qty;

			// Hanya update jika ada perubahan nilai stok
			if ($new_qty != $old_qty) {
				$this->db->update('stok', [
					'qty'        => $new_qty,
					'updated_at' => $now,
				], ['id' => $stok_id]);

				$diff = $new_qty - $old_qty;
				$jenis_log = $diff > 0 ? 'masuk' : 'keluar';

				$this->db->insert('stok_log', [
					'produk_id'      => $existing->produk_id,
					'gudang_id'      => $existing->gudang_id,
					'jenis'          => $jenis_log,
					'qty'            => abs($diff),
					'keterangan'     => "Penyesuaian Stok (Stok: {$old_qty} -> {$new_qty})",
					'referensi_type' => 'manual',
					'referensi_id'   => $stok_id,
					'created_by'     => $user,
					'created_at'     => $now,
				]);

				$updated_count++;
			}
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->response(['success' => false, 'message' => 'Terjadi kesalahan database saat memperbarui stok massal.']);
			return;
		}

		$gudang_id = $this->input->post('gudang_id');
		$redirect_url = site_url('administrator/stok' . (!empty($gudang_id) && $gudang_id !== 'all' ? '?gudang_id=' . $gudang_id : ''));

		$msg = 'Data Stok berhasil diperbarui.';
		set_message($msg, 'success');
		$this->response([
			'success'  => true,
			'message'  => $msg,
			'redirect' => $redirect_url
		]);
	}

	public function export_pdf()
	{
		$this->is_allowed('stok_export');
		$this->model_stok->pdf('stok', 'stok');
	}

	public function print_stok()
	{
		$this->is_allowed('stok_list');
		$gudang_id = $this->input->get('gudang_id');
		$status    = $this->input->get('status');
		$q         = $this->input->get('q');
		$f         = $this->input->get('f');

		// Ambil seluruh data stok tanpa batas per_page untuk cetak
		$this->data['stoks']      = $this->model_stok->get($q, $f, 999999, 0, $gudang_id, $status);
		$this->data['summary']    = $this->model_stok->get_summary_dashboard($gudang_id);
		$this->data['gudangs']    = $this->db->get_where('gudang', ['status' => 'aktif'])->result();
		$this->data['gudang_sel'] = $gudang_id;
		$this->data['status_sel'] = $status;

		$nama_gudang = 'Semua Gudang Aktif';
		if (!empty($gudang_id)) {
			$g = $this->db->get_where('gudang', ['id' => $gudang_id])->row();
			if ($g) $nama_gudang = $g->nama_gudang;
		}
		$this->data['nama_gudang_aktif'] = $nama_gudang;

		$this->load->view('backend/standart/administrator/stok/stok_print', $this->data);
	}

}
