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
		$status    = $this->input->get('status');
		$per_page  = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 100;
		if ($per_page <= 0) $per_page = 100;

		$this->data['stoks']       = $this->model_stok->get($filter, $field, $per_page, $offset, $status);
		$this->data['stok_counts'] = $this->model_stok->count_all($filter, $field, $status);
		$this->data['summary']     = $this->model_stok->get_summary_dashboard();
		$this->data['menipis']     = $this->model_stok->get_stok_menipis();
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

		$this->data['stoks']       = $this->model_stok->get_stok_menipis();
		$this->data['stok_counts'] = count($this->data['stoks']);
		$this->data['summary']     = $this->model_stok->get_summary_dashboard();
		$this->data['menipis']     = $this->data['stoks'];
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

		$date_start = $this->input->get('date_start');
		$date_end   = $this->input->get('date_end');

		$this->data['produk']      = $this->db->get_where('produk', ['id' => $produk_id])->row();
		$this->data['kartu']       = $this->model_stok->get_kartu_stok($produk_id, $date_start, $date_end);
		$this->data['all_produks'] = $this->db->where('status', 'aktif')->order_by('id', 'ASC')->get('produk')->result();
		$this->data['date_start']  = $date_start;
		$this->data['date_end']    = $date_end;

		$this->template->title('Kartu Stok - ' . ($this->data['produk'] ? $this->data['produk']->nama_produk : ''));
		$this->render('backend/standart/administrator/stok/stok_kartu', $this->data);
	}

	public function api_summary()
	{
		$summary = $this->model_stok->get_summary_dashboard();
		$this->response(['success' => true, 'data' => $summary]);
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

		$filter    = $this->input->get('q');
		$field     = $this->input->get('f');
		$status    = $this->input->get('status');

		// Ambil seluruh data stok sesuai filter tanpa batasan halaman
		$stoks = $this->model_stok->get($filter, $field, 0, 0, $status);

		if (ob_get_length()) {
			ob_end_clean();
		}

		$filename = 'Laporan_Stok_Barang_' . date('Y-m-d_His') . '.xls';

		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate');
		header('Pragma: public');

		echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
		echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
		echo '<style>';
		echo 'body { font-family: Calibri, Arial, sans-serif; font-size: 11pt; }';
		echo 'table { border-collapse: collapse; width: 100%; }';
		echo 'th { background-color: #1E40AF; color: #FFFFFF; font-weight: bold; border: 1px solid #CBD5E1; padding: 10px 8px; text-align: center; }';
		echo 'td { border: 1px solid #CBD5E1; padding: 6px 8px; vertical-align: middle; }';
		echo '.text-center { text-align: center; }';
		echo '.text-right { text-align: right; }';
		echo '.text-left { text-align: left; }';
		echo '.num { mso-number-format:"\#\,\#\#0"; }';
		echo '.text { mso-number-format:"\@"; }';
		echo '</style>';
		echo '</head><body>';

		echo '<div style="margin-bottom: 15px;">';
		echo '<h3 style="margin: 0; padding: 0; color: #1E40AF;">LAPORAN DATA STOK BARANG</h3>';
		echo '<p style="margin: 4px 0 0 0; font-size: 9pt; color: #64748B;">Tanggal Export: ' . date('d/m/Y H:i:s') . '</p>';
		echo '</div>';

		echo '<table>';
		echo '<thead>';
		echo '<tr>';
		echo '<th>No</th>';
		echo '<th>Kode Produk</th>';
		echo '<th>Nama Produk</th>';
		echo '<th>Kategori</th>';
		echo '<th>Stok Fisik</th>';
		echo '<th>Stok Rusak</th>';
		echo '<th>Min. Stok</th>';
		echo '<th>Satuan</th>';
		echo '<th>Harga Beli (Rp)</th>';
		echo '<th>Harga Jual (Rp)</th>';
		echo '<th>Status Stok</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';

		$no = 1;
		$total_fisik = 0;
		$total_rusak = 0;

		foreach ($stoks as $s) {
			$status_text = 'Normal';
			$status_style = 'color: #16A34A; font-weight: bold;';
			$qty = (float)$s->qty;
			$qty_rusak = (float)$s->qty_rusak;
			$min_stok = (float)$s->stok_minimum;

			if ($qty == 0) {
				$status_text = 'Habis';
				$status_style = 'color: #DC2626; font-weight: bold;';
			} elseif ($qty <= $min_stok) {
				$status_text = 'Menipis';
				$status_style = 'color: #D97706; font-weight: bold;';
			}

			$total_fisik += $qty;
			$total_rusak += $qty_rusak;

			echo '<tr>';
			echo '<td class="text-center">' . $no++ . '</td>';
			echo '<td class="text-center text">' . htmlspecialchars($s->kode_produk ?? '') . '</td>';
			echo '<td class="text-left">' . htmlspecialchars($s->nama_produk ?? '') . '</td>';
			echo '<td class="text-left">' . htmlspecialchars($s->nama_kategori ?: '-') . '</td>';
			echo '<td class="text-right num">' . $qty . '</td>';
			echo '<td class="text-right num">' . $qty_rusak . '</td>';
			echo '<td class="text-right num">' . $min_stok . '</td>';
			echo '<td class="text-center">' . htmlspecialchars($s->singkatan ?: '-') . '</td>';
			echo '<td class="text-right num">' . (float)($s->harga_beli ?? 0) . '</td>';
			echo '<td class="text-right num">' . (float)($s->harga_jual ?? 0) . '</td>';
			echo '<td class="text-center" style="' . $status_style . '">' . $status_text . '</td>';
			echo '</tr>';
		}

		echo '</tbody>';
		echo '<tfoot>';
		echo '<tr style="background-color: #F1F5F9; font-weight: bold;">';
		echo '<td colspan="4" class="text-center" style="font-weight: bold;">TOTAL STOK</td>';
		echo '<td class="text-right num" style="font-weight: bold;">' . $total_fisik . '</td>';
		echo '<td class="text-right num" style="font-weight: bold;">' . $total_rusak . '</td>';
		echo '<td colspan="5"></td>';
		echo '</tr>';
		echo '</tfoot>';
		echo '</table>';

		echo '</body></html>';
		exit;
	}

	public function add()
	{
		$this->is_allowed('stok_add');
		$this->data['produks'] = $this->db->select('produk.*, satuan.singkatan as nama_satuan')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT')
			->where('produk.status', 'aktif')
			->order_by('produk.id', 'ASC')
			->get('produk')->result();
		$this->data['raks']    = $this->db->order_by('kode_rak', 'ASC')->get('rak')->result();
		$this->template->title('Input Stok Manual');
		$this->render('backend/standart/administrator/stok/stok_add', $this->data);
	}

	public function get_current_stok()
	{
		$produk_id = (int) $this->input->get('produk_id');

		if (!$produk_id) {
			$this->response(['success' => false, 'message' => 'Parameter tidak lengkap']);
			return;
		}

		$stok = $this->db->select('stok.*, rak.kode_rak, rak.baris, rak.kolom')
			->join('rak', 'rak.id = stok.rak_id', 'LEFT')
			->get_where('stok', ['produk_id' => $produk_id])
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
		$this->form_validation->set_rules('qty', 'Jumlah Qty', 'trim|required|numeric');

		if ($this->form_validation->run()) {
			$produk_id  = (int) $this->input->post('produk_id');
			$rak_id     = $this->input->post('rak_id') ? (int) $this->input->post('rak_id') : null;
			$mode       = $this->input->post('mode') ?: 'set'; // 'set', 'tambah', 'kurang'
			$input_qty  = (float) $this->input->post('qty');
			$qty_rusak  = $this->input->post('qty_rusak') !== null && $this->input->post('qty_rusak') !== '' ? (float) $this->input->post('qty_rusak') : 0;
			$keterangan = trim($this->input->post('keterangan'));
			if (empty($keterangan)) {
				$keterangan = 'Input Penyesuaian Manual Stok';
			}

			// Ambil stok sekarang
			$existing    = $this->db->get_where('stok', ['produk_id' => $produk_id])->row();
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
				$stok_id = $this->model_stok->store($data_stok);
			}

			// Catat mutasi ke stok_log
			$this->db->insert('stok_log', [
				'produk_id'      => $produk_id,
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

		$this->data['items'] = $this->db->select('produk.id, produk.kode_produk, produk.nama_produk, produk.harga_jual, satuan.singkatan, kategori_produk.nama_kategori, IFNULL(stok.qty, 0) AS total_stok')
			->from('produk')
			->join('kategori_produk', 'kategori_produk.id = produk.kategori_id', 'LEFT')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT')
			->join('stok', 'stok.produk_id = produk.id', 'LEFT')
			->where('produk.status', 'aktif')
			->order_by('produk.id', 'ASC')
			->get()->result();

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

		foreach ($items as $produk_id => $val) {
			$produk_id = (int)$produk_id;
			$produk = $this->db->get_where('produk', ['id' => $produk_id])->row();
			if (!$produk) continue;

			$existing = $this->db->get_where('stok', ['produk_id' => $produk_id])->row();
			$old_total = $existing ? (float)$existing->qty : 0;
			$new_total = isset($val['qty']) && $val['qty'] !== '' ? max(0, (float)$val['qty']) : $old_total;

			if ($new_total != $old_total) {
				$diff = $new_total - $old_total;

				if ($existing) {
					$this->db->update('stok', [
						'qty'        => $new_total,
						'updated_at' => $now,
					], ['id' => $existing->id]);
					$ref_id = $existing->id;
				} else {
					$this->db->insert('stok', [
						'produk_id'  => $produk_id,
						'rak_id'     => $produk->default_rak_id,
						'qty'        => $new_total,
						'qty_rusak'  => 0,
						'updated_at' => $now,
					]);
					$ref_id = $this->db->insert_id();
				}

				$this->db->insert('stok_log', [
					'produk_id'      => $produk_id,
					'jenis'          => $diff > 0 ? 'masuk' : 'keluar',
					'qty'            => abs($diff),
					'keterangan'     => "Penyesuaian Stok Massal ({$old_total} -> {$new_total})",
					'referensi_type' => 'manual',
					'referensi_id'   => $ref_id,
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

		$redirect_url = site_url('administrator/stok');
		$msg = 'Data Stok berhasil diperbarui (' . $updated_count . ' produk disesuaikan).';
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

		@ini_set('memory_limit', '512M');
		@set_time_limit(180);

		$filter    = $this->input->get('q');
		$field     = $this->input->get('f');
		$status    = $this->input->get('status');

		// Ambil seluruh data stok sesuai filter tanpa batas
		$stoks   = $this->model_stok->get($filter, $field, 0, 0, $status);
		$summary = $this->model_stok->get_summary_dashboard();

		$this->load->library('HtmlPdf');

		$config = [
			'orientation' => 'l',
			'format'      => 'a4',
			'marges'      => [8, 8, 8, 8]
		];

		$this->htmlpdf->initialize($config);

		$content = $this->load->view('stok/backend/standart/administrator/stok/stok_export_pdf', [
			'results'           => $stoks,
			'summary'           => $summary,
			'status_sel'        => $status,
			'search_q'          => $filter
		], true);

		$this->htmlpdf->writeHTML($content);

		if (ob_get_length()) { ob_end_clean(); }

		$this->htmlpdf->Output('Laporan_Stok_Barang_' . date('Y-m-d') . '.pdf', 'I');
		exit;
	}

	public function print_stok()
	{
		$this->is_allowed('stok_list');
		$status    = $this->input->get('status');
		$q         = $this->input->get('q');
		$f         = $this->input->get('f');

		// Ambil seluruh data stok tanpa batas per_page untuk cetak
		$this->data['stoks']      = $this->model_stok->get($q, $f, 999999, 0, $status);
		$this->data['summary']    = $this->model_stok->get_summary_dashboard();
		$this->data['status_sel'] = $status;

		$this->load->view('stok/backend/standart/administrator/stok/stok_print', $this->data);
	}

}

/* End of file Stok.php */
/* Location: ./modules/stok/controllers/backend/Stok.php */
