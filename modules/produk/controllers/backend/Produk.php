<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Produk extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_produk');
	}

	public function index($offset = 0)
	{
		$this->is_allowed('produk_list');

		$filter = $this->input->get('q');
		$field  = $this->input->get('f');

		$this->data['produks']       = $this->model_produk->get($filter, $field, $this->limit_page, $offset);
		$this->data['produk_counts'] = $this->model_produk->count_all($filter, $field);

		$config = [
			'base_url'    => 'administrator/produk/index/',
			'total_rows'  => $this->data['produk_counts'],
			'per_page'    => $this->limit_page,
			'uri_segment' => 4,
		];
		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Produk List');
		$this->render('backend/standart/administrator/produk/produk_list', $this->data);
	}

	public function add()
	{
		$this->is_allowed('produk_add');
		$this->data['kode_baru']    = $this->model_produk->generate_kode();
		$this->data['kategoris']    = $this->db->get('kategori_produk')->result();
		$this->data['satuans']      = $this->db->get('satuan')->result();
		$this->data['raks']         = $this->db->where('status', 'aktif')->get('rak')->result();
		$this->template->title('Tambah Produk');
		$this->render('backend/standart/administrator/produk/produk_add', $this->data);
	}

	public function add_save()
	{
		if (!$this->is_allowed('produk_add', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$this->form_validation->set_rules('nama_produk', 'Nama Produk', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('kode_produk', 'Kode Produk', 'trim|required|max_length[30]');

		if ($this->form_validation->run()) {
			$kode_input = trim((string)$this->input->post('kode_produk'));
			if (empty($kode_input) || $this->db->get_where('produk', ['kode_produk' => $kode_input])->num_rows() > 0) {
				$kode_input = $this->model_produk->generate_kode();
			}
			$h_jual = str_replace(['.', ','], '', (string)$this->input->post('harga_jual')) ?: 0;
			$h_retail = str_replace(['.', ','], '', (string)$this->input->post('harga_jual_retail')) ?: $h_jual;

			$data = [
				'kode_produk'       => $kode_input,
				'barcode'           => null,
				'nama_produk'       => $this->input->post('nama_produk'),
				'kategori_id'       => $this->input->post('kategori_id') ?: null,
				'satuan_id'         => $this->input->post('satuan_id') ?: null,
				'default_rak_id'    => $this->input->post('default_rak_id') ?: null,
				'harga_beli'        => str_replace(['.', ','], '', (string)$this->input->post('harga_beli')) ?: 0,
				'harga_jual'        => $h_jual,
				'harga_jual_retail' => $h_retail,
				'harga_jual_grosir' => str_replace(['.', ','], '', (string)$this->input->post('harga_jual_grosir')) ?: 0,
				'harga_jual_distributor' => str_replace(['.', ','], '', (string)$this->input->post('harga_jual_distributor')) ?: 0,
				'harga_jual_vip'    => str_replace(['.', ','], '', (string)$this->input->post('harga_jual_vip')) ?: 0,
				'stok_minimum'      => str_replace(['.', ','], '', (string)$this->input->post('stok_minimum')) ?: 0,
				'berat'             => $this->input->post('berat') ?: null,
				'deskripsi'         => $this->input->post('deskripsi'),
				'metode_stok'       => $this->input->post('metode_stok') ?: 'FIFO',
				'batch_tracking'    => $this->input->post('batch_tracking') ? 1 : 0,
				'tanggal_kadaluarsa'=> $this->input->post('tanggal_kadaluarsa') ? 1 : 0,
				'status'            => $this->input->post('status') ?: 'aktif',
				'created_by'        => get_user_data('username'),
				'created_at'        => date('Y-m-d H:i:s'),
			];

			$id = $this->model_produk->store($data);

			if ($id) {
				// Inisialisasi stok awal
				$exists = $this->db->get_where('stok', ['produk_id' => $id])->row();
				if (!$exists) {
					$this->db->insert('stok', [
						'produk_id'  => $id,
						'rak_id'     => $data['default_rak_id'],
						'qty'        => 0,
						'qty_rusak'  => 0,
						'updated_at' => date('Y-m-d H:i:s')
					]);
				}

				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['message'] = 'Produk berhasil disimpan. ' . anchor('administrator/produk/edit/' . $id, 'Edit');
				} else {
					set_message('Produk berhasil disimpan.', 'success');
					$this->data['success']  = true;
					$this->data['redirect'] = base_url('administrator/produk');
				}
			} else {
				$this->data['success'] = false;
				$this->data['message'] = 'Gagal menyimpan data.';
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}
		$this->response($this->data);
	}

	public function edit($id)
	{
		$this->is_allowed('produk_update');
		$this->data['produk']    = $this->model_produk->find($id);
		$this->data['kategoris'] = $this->db->get('kategori_produk')->result();
		$this->data['satuans']   = $this->db->get('satuan')->result();
		$this->data['raks']      = $this->db->where('status', 'aktif')->get('rak')->result();
		$this->template->title('Edit Produk');
		$this->render('backend/standart/administrator/produk/produk_update', $this->data);
	}

	public function edit_save($id)
	{
		if (!$this->is_allowed('produk_update', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$this->form_validation->set_rules('nama_produk', 'Nama Produk', 'trim|required|max_length[200]');

		if ($this->form_validation->run()) {
			$old_produk = $this->model_produk->find($id);

			$data = [
				'nama_produk'       => $this->input->post('nama_produk'),
				'barcode'           => null,
				'kategori_id'       => $this->input->post('kategori_id') ?: null,
				'satuan_id'         => $this->input->post('satuan_id') ?: null,
				'default_rak_id'    => $this->input->post('default_rak_id') ?: null,
				'harga_beli'        => str_replace(['.', ','], '', (string)$this->input->post('harga_beli')) ?: 0,
				'harga_jual'        => $h_jual = (str_replace(['.', ','], '', (string)$this->input->post('harga_jual')) ?: 0),
				'harga_jual_retail' => str_replace(['.', ','], '', (string)$this->input->post('harga_jual_retail')) ?: $h_jual,
				'harga_jual_grosir' => str_replace(['.', ','], '', (string)$this->input->post('harga_jual_grosir')) ?: 0,
				'harga_jual_distributor' => str_replace(['.', ','], '', (string)$this->input->post('harga_jual_distributor')) ?: 0,
				'harga_jual_vip'    => str_replace(['.', ','], '', (string)$this->input->post('harga_jual_vip')) ?: 0,
				'stok_minimum'      => str_replace(['.', ','], '', (string)$this->input->post('stok_minimum')) ?: 0,
				'berat'             => $this->input->post('berat') ?: null,
				'deskripsi'         => $this->input->post('deskripsi'),
				'metode_stok'       => $this->input->post('metode_stok') ?: 'FIFO',
				'batch_tracking'    => $this->input->post('batch_tracking') ? 1 : 0,
				'tanggal_kadaluarsa'=> $this->input->post('tanggal_kadaluarsa') ? 1 : 0,
				'status'            => $this->input->post('status') ?: 'aktif',
				'updated_at'        => date('Y-m-d H:i:s'),
			];

			$save = $this->model_produk->change($id, $data);

			if ($save) {
				// Audit Log Perubahan Harga (Master Update)
				if ($old_produk) {
					$old_hb = (float)$old_produk->harga_beli;
					$new_hb = (float)$data['harga_beli'];
					$old_hj = (float)$old_produk->harga_jual;
					$new_hj = (float)$data['harga_jual'];

					if ($old_hb != $new_hb || $old_hj != $new_hj) {
						$this->db->insert('produk_harga_log', [
							'produk_id'       => $id,
							'tipe_perubahan'  => 'master_update',
							'harga_beli_lama' => $old_hb,
							'harga_beli_baru' => $new_hb,
							'harga_jual_lama' => $old_hj,
							'harga_jual_baru' => $new_hj,
							'catatan'         => 'Perubahan Manual pada Edit Master Produk',
							'created_by'      => get_user_data('username') ?: 'System',
							'created_at'      => date('Y-m-d H:i:s'),
						]);
					}
				}

				set_message('Produk berhasil diperbarui.', 'success');
				$this->data['success']  = true;
				$this->data['redirect'] = base_url('administrator/produk');
			} else {
				$this->data['success'] = false;
				$this->data['message'] = 'Tidak ada perubahan data.';
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}
		$this->response($this->data);
	}

	public function view($id)
	{
		$this->is_allowed('produk_view');
		$this->data['produk'] = $this->model_produk->join_available()->find($id);
		$this->data['stok_list'] = $this->db->get_where('stok', ['produk_id' => $id])->result();
		$this->data['riwayat_harga'] = $this->model_produk->get_riwayat_harga($id);
		$this->data['harga_logs']    = $this->db->where('produk_id', $id)->order_by('id', 'DESC')->get('produk_harga_log')->result();
		$this->template->title('Detail Produk');
		$this->render('backend/standart/administrator/produk/produk_view', $this->data);
	}

	public function delete($id = null)
	{
		$this->is_allowed('produk_delete');
		$arr_id = (array) $this->input->get('id');
		$ids = !empty($id) ? [$id] : $arr_id;
		$ids = array_filter(array_map('intval', $ids));

		if (empty($ids)) {
			set_message('Pilih produk yang ingin dihapus.', 'error');
			redirect_back();
			return;
		}

		$res = $this->model_produk->delete_cascade($ids);
		if ($res['status'] === 'success') {
			set_message($res['message'], 'success');
		} else {
			set_message($res['message'], 'error');
		}
		redirect_back();
	}

	public function get_harga()
	{
		$produk_id  = $this->input->get('produk_id');
		$tipe       = $this->input->get('tipe');
		$qty        = $this->input->get('qty') ?: 1;

		$this->load->model('model_pelanggan');
		$harga = $this->model_pelanggan->get_harga($produk_id, $tipe, $qty);
		$this->response(['harga' => $harga, 'success' => true]);
	}

	public function cek_stok()
	{
		$produk_id  = $this->input->get('produk_id');
				$stok = $this->model_produk->get_stok($produk_id);
		$this->response(['stok' => $stok, 'success' => true]);
	}

	public function kartu_stok($id)
	{
		$this->is_allowed('produk_view');
		$this->data['produk']    = $this->model_produk->join_available()->find($id);
		$this->data['logs']      = $this->db->select('stok_log.*')
			->where('stok_log.produk_id', $id)
			->order_by('stok_log.id', 'ASC')
			->get('stok_log')->result();

		$this->template->title('Kartu Stok & Audit Ledger Produk');
		$this->render('backend/standart/administrator/produk/produk_kartu_stok', $this->data);
	}

	public function export()
	{
		$this->is_allowed('produk_export');

		$q        = trim((string)$this->input->get('q'));
		$kategori = $this->input->get('kategori');
		$status   = $this->input->get('status');

		$builder = $this->db->select('produk.id, produk.kode_produk, produk.nama_produk, kategori_produk.nama_kategori, satuan.singkatan, produk.harga_beli, produk.harga_jual, produk.stok_minimum, produk.status')
			->from('produk')
			->join('kategori_produk', 'kategori_produk.id = produk.kategori_id', 'LEFT')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT');

		if (!empty($q)) {
			$builder->group_start()
				->like('produk.kode_produk', $q)
				->or_like('produk.nama_produk', $q)
				->or_like('kategori_produk.nama_kategori', $q)
				->group_end();
		}
		if (!empty($kategori)) {
			$builder->where('produk.kategori_id', $kategori);
		}
		if (!empty($status)) {
			$builder->where('produk.status', $status);
		}

		$produks = $builder->order_by('produk.id', 'ASC')->get()->result();

		$filename = 'Data_Produk_' . date('Y-m-d') . '.xls';

		if (ob_get_length()) { ob_end_clean(); }

		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		header('Pragma: public');

		echo "<!DOCTYPE html>\n<html>\n<head>\n<meta charset=\"utf-8\">\n";
		echo "<style>
			th { background-color: #1E40AF; color: #ffffff; font-weight: bold; padding: 10px 8px; border: 1px solid #1E3A8A; text-align: center; font-family: Arial, sans-serif; font-size: 10.5pt; }
			td { padding: 6px 8px; border: 1px solid #cbd5e1; font-family: Arial, sans-serif; font-size: 9.5pt; vertical-align: middle; }
			.zebra { background-color: #F8FAFC; }
			.num { mso-number-format:\"\\#\\,\\#\\#0\"; text-align: right; }
			.currency { mso-number-format:\"\\\"Rp\\\"\\ \\#\\,\\#\\#0\"; text-align: right; font-weight: bold; }
			.text { mso-number-format:\"\\@\"; }
			.center { text-align: center; }
		</style>\n</head>\n<body>\n";

		$headers = [
			'No',
			'Kode Produk',
			'Nama Produk',
			'Kategori',
			'Satuan',
			'Harga Beli (Rp)',
			'Harga Jual (Rp)',
			'Min. Stok',
			'Total Stok Fisik',
			'Status Produk'
		];

		echo "<table border=\"1\" cellpadding=\"4\" cellspacing=\"0\">\n<thead>\n<tr>\n";
		foreach ($headers as $h) {
			echo '<th>' . htmlspecialchars($h) . "</th>\n";
		}
		echo "</tr>\n</thead>\n<tbody>\n";

		$no = 1;
		foreach ($produks as $p) {
			$total_stok = $this->model_produk->get_stok($p->id);
			$cls_row    = ($no % 2 === 0) ? ' class="zebra"' : '';

			echo "<tr{$cls_row}>\n";
			echo "<td class=\"center\">" . ($no++) . "</td>\n";
			echo "<td class=\"text center\">" . htmlspecialchars($p->kode_produk) . "</td>\n";
			echo "<td>" . htmlspecialchars($p->nama_produk) . "</td>\n";
			echo "<td>" . htmlspecialchars($p->nama_kategori ?: '-') . "</td>\n";
			echo "<td class=\"center\">" . htmlspecialchars($p->singkatan ?: '-') . "</td>\n";
			echo "<td class=\"currency\">" . (float)$p->harga_beli . "</td>\n";
			echo "<td class=\"currency\">" . (float)$p->harga_jual . "</td>\n";
			echo "<td class=\"num\">" . (float)$p->stok_minimum . "</td>\n";
			echo "<td class=\"num\">" . (float)$total_stok . "</td>\n";
			echo "<td class=\"center\">" . htmlspecialchars(ucfirst($p->status)) . "</td>\n";
			echo "</tr>\n";
		}

		echo "</tbody>\n</table>\n</body>\n</html>";
		exit;
	}

	public function export_pdf()
	{
		$this->is_allowed('produk_export');

		@ini_set('memory_limit', '512M');
		@set_time_limit(180);

		$this->load->library('HtmlPdf');

		$q        = trim((string)$this->input->get('q'));
		$kategori = $this->input->get('kategori');
		$status   = $this->input->get('status');

		$builder = $this->db->select('produk.id, produk.kode_produk, produk.nama_produk, kategori_produk.nama_kategori, satuan.singkatan, produk.harga_beli, produk.harga_jual, produk.stok_minimum, produk.status')
			->from('produk')
			->join('kategori_produk', 'kategori_produk.id = produk.kategori_id', 'LEFT')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT');

		if (!empty($q)) {
			$builder->group_start()
				->like('produk.kode_produk', $q)
				->or_like('produk.nama_produk', $q)
				->or_like('kategori_produk.nama_kategori', $q)
				->group_end();
		}
		if (!empty($kategori)) {
			$builder->where('produk.kategori_id', $kategori);
		}
		if (!empty($status)) {
			$builder->where('produk.status', $status);
		}

		$produks = $builder->order_by('produk.id', 'ASC')->get()->result();

		foreach ($produks as $p) {
			$p->total_stok = $this->model_produk->get_stok($p->id);
		}

		$kategori_nama = '';
		if (!empty($kategori)) {
			$kat = $this->db->get_where('kategori_produk', ['id' => $kategori])->row();
			if ($kat) $kategori_nama = $kat->nama_kategori;
		}

		$config = [
			'orientation' => 'l',
			'format'      => 'a4',
			'marges'      => [7, 7, 7, 7]
		];

		$this->htmlpdf->initialize($config);

		$content = $this->load->view('produk/backend/standart/administrator/produk/produk_export_pdf', [
			'results'       => $produks,
			'search_q'      => $q,
			'kategori_nama' => $kategori_nama,
			'status_sel'    => $status,
		], true);

		$this->htmlpdf->writeHTML($content);

		if (ob_get_length()) { ob_end_clean(); }

		$this->htmlpdf->Output('Data_Produk_' . date('Y-m-d') . '.pdf', 'I');
		exit;
	}

}
