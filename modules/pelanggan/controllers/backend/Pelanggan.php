<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Pelanggan extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_pelanggan');
	}

	public function index($offset = 0)
	{
		$this->is_allowed('pelanggan_list');

		$filter = $this->input->get('q');
		$field  = $this->input->get('f');

		$this->data['pelanggans']      = $this->model_pelanggan->get($filter, $field, $this->limit_page, $offset);
		$this->data['pelanggan_counts'] = $this->model_pelanggan->count_all($filter, $field);


		$config = [
			'base_url'    => 'administrator/pelanggan/index/',
			'total_rows'  => $this->data['pelanggan_counts'],
			'per_page'    => $this->limit_page,
			'uri_segment' => 4,
		];
		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Pelanggan List');
		$this->render('backend/standart/administrator/pelanggan/pelanggan_list', $this->data);
	}

	public function add()
	{
		$this->is_allowed('pelanggan_add');
		$this->data['kode_baru'] = $this->model_pelanggan->generate_kode();
		$this->template->title('Tambah Pelanggan');
		$this->render('backend/standart/administrator/pelanggan/pelanggan_add', $this->data);
	}

	public function add_save()
	{
		if (!$this->is_allowed('pelanggan_add', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'trim|required|max_length[150]');

		if ($this->form_validation->run()) {
			$kode = trim((string)$this->input->post('kode_pelanggan'));
			if (empty($kode) || $this->db->get_where('pelanggan', ['kode_pelanggan' => $kode])->num_rows() > 0) {
				$kode = $this->model_pelanggan->generate_kode();
			}
			$tipe = $this->input->post('tipe_pelanggan') ?: 'retail';
			$telp = $this->input->post('telepon') ?: '';

			$data = [
				'kode_pelanggan'  => $kode,
				'nama_pelanggan'  => $this->input->post('nama_pelanggan'),
				'tipe_pelanggan'  => $tipe,
				'tier_pelanggan'  => strtoupper($tipe),
				'kontak_person'   => $this->input->post('kontak_person'),
				'telepon'         => $telp,
				'no_telp'         => $telp,
				'email'           => $this->input->post('email'),
				'alamat'          => $this->input->post('alamat'),
				'kota'            => $this->input->post('kota'),
				'npwp'            => $this->input->post('npwp'),
				'limit_kredit'    => preg_replace('/[^0-9]/', '', (string)$this->input->post('limit_kredit')) ?: 0,
				'status'          => $this->input->post('status') ?: 'aktif',
				'catatan'         => $this->input->post('catatan'),
				'source'          => $this->input->post('source') ?: 'manual',
				'created_by'      => get_user_data('username'),
				'created_at'      => date('Y-m-d H:i:s'),
			];

			$id = $this->model_pelanggan->store($data);

			if ($id) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id']      = $id;
					$this->data['message'] = 'Pelanggan berhasil disimpan. ' . anchor('administrator/pelanggan/edit/' . $id, 'Edit');
				} elseif ($this->input->post('save_type') == 'sales_order') {
					set_message('Pelanggan berhasil disimpan. Silakan buat Transaksi Penjualan.', 'success');
					$this->data['success']  = true;
					$this->data['id']       = $id;
					$this->data['redirect'] = base_url('administrator/sales_order/add?pelanggan_id=' . $id);
				} else {
					set_message('Pelanggan berhasil disimpan.', 'success');
					$this->data['success']  = true;
					$this->data['id']       = $id;
					$this->data['redirect'] = base_url('administrator/pelanggan');
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
		$this->is_allowed('pelanggan_update');
		$this->data['pelanggan'] = $this->model_pelanggan->find($id);
		$this->template->title('Edit Pelanggan');
		$this->render('backend/standart/administrator/pelanggan/pelanggan_update', $this->data);
	}

	public function edit_save($id)
	{
		if (!$this->is_allowed('pelanggan_update', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'trim|required|max_length[150]');

		if ($this->form_validation->run()) {
			$tipe = $this->input->post('tipe_pelanggan') ?: 'retail';
			$telp = $this->input->post('telepon') ?: '';

			$data = [
				'nama_pelanggan'  => $this->input->post('nama_pelanggan'),
				'tipe_pelanggan'  => $tipe,
				'tier_pelanggan'  => strtoupper($tipe),
				'kontak_person'   => $this->input->post('kontak_person'),
				'telepon'         => $telp,
				'no_telp'         => $telp,
				'email'           => $this->input->post('email'),
				'alamat'          => $this->input->post('alamat'),
				'kota'            => $this->input->post('kota'),
				'npwp'            => $this->input->post('npwp'),
				'limit_kredit'    => preg_replace('/[^0-9]/', '', (string)$this->input->post('limit_kredit')) ?: 0,
				'status'          => $this->input->post('status') ?: 'aktif',
				'catatan'         => $this->input->post('catatan'),
				'source'          => $this->input->post('source') ?: 'manual',
				'updated_at'      => date('Y-m-d H:i:s'),
			];

			$save = $this->model_pelanggan->change($id, $data);

			if ($save) {
				set_message('Pelanggan berhasil diperbarui.', 'success');
				$this->data['success']  = true;
				$this->data['redirect'] = base_url('administrator/pelanggan');
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

	public function get_list_json()
	{
		$pelanggans = $this->db->where('status', 'aktif')->order_by('nama_pelanggan', 'ASC')->get('pelanggan')->result();
		$this->response(['status' => true, 'data' => $pelanggans]);
	}

	public function view($id)
	{
		$this->is_allowed('pelanggan_view');
		$this->data['pelanggan'] = $this->model_pelanggan->find($id);
		
		$pelanggan = $this->data['pelanggan'];
		$p_phone = !empty($pelanggan->telepon) ? preg_replace('/[^0-9]/', '', $pelanggan->telepon) : (!empty($pelanggan->no_telp) ? preg_replace('/[^0-9]/', '', $pelanggan->no_telp) : '');

		// Riwayat transaksi per pelanggan untuk analisis pembelian ulang (terkoneksi pelanggan_id & nomor HP)
		$this->db->group_start();
		$this->db->where('pelanggan_id', $id);
		if (!empty($p_phone)) {
			$this->db->or_where('no_telepon', $p_phone);
			$this->db->or_like('no_telepon', substr($p_phone, -9));
		}
		$this->db->group_end();
		$this->data['riwayat_so'] = $this->db->order_by('id', 'DESC')->get('sales_order')->result();

		$this->db->group_start();
		$this->db->where('pelanggan_id', $id);
		if (!empty($p_phone)) {
			$this->db->or_where('no_telepon', $p_phone);
			$this->db->or_like('no_telepon', substr($p_phone, -9));
		}
		$this->db->group_end();
		$this->data['riwayat_mp'] = $this->db->order_by('id', 'DESC')->get('penjualan_marketplace')->result();

		$this->data['riwayat_invoice'] = $this->db->order_by('id', 'DESC')->get_where('invoice', ['pelanggan_id' => $id])->result();
		
		// Hitung total volume tanpa double-counting antara sales_order dan penjualan_marketplace yang tersinkron
		$counted_so_numbers = [];
		$total_vol = 0;
		foreach ($this->data['riwayat_so'] as $rso) {
			$total_vol += (float)$rso->total;
			if (!empty($rso->nomor_so)) $counted_so_numbers[] = $rso->nomor_so;
			if (!empty($rso->no_pesanan)) $counted_so_numbers[] = $rso->no_pesanan;
		}
		foreach ($this->data['riwayat_mp'] as $rmp) {
			if (!in_array($rmp->nomor_so, $counted_so_numbers) && !in_array($rmp->no_pesanan, $counted_so_numbers)) {
				$total_vol += (float)$rmp->total;
			}
		}
		$this->data['total_volume'] = $total_vol;

		$this->template->title('Detail & Analisis Transaksi Pelanggan');
		$this->render('backend/standart/administrator/pelanggan/pelanggan_view', $this->data);
	}

	public function delete($id = null)
	{
		$this->is_allowed('pelanggan_delete');
		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
			$remove = $this->model_pelanggan->remove($id);
		} elseif (count($arr_id) > 0) {
			foreach ($arr_id as $aid) {
				$remove = $this->model_pelanggan->remove($aid);
			}
		}

		set_message($remove ? 'Pelanggan berhasil dihapus.' : 'Gagal menghapus.', $remove ? 'success' : 'error');
		redirect_back();
	}

	public function export()
	{
		$this->is_allowed('pelanggan_export');
		$this->model_pelanggan->export('pelanggan', 'pelanggan');
	}

	public function laporan_transaksi()
	{
		$this->is_allowed('pelanggan_list');
		$this->data['laporan'] = $this->model_pelanggan->get_laporan_transaksi();
		$this->template->title('Laporan Transaksi Pelanggan');
		$this->render('backend/standart/administrator/pelanggan/pelanggan_laporan_transaksi', $this->data);
	}

	public function export_pdf()
	{
		$this->is_allowed('pelanggan_export');
		$this->model_pelanggan->pdf('pelanggan', 'pelanggan');
	}

}
