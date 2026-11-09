<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Retur_penjualan extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_retur_penjualan');
	}

	public function index($offset = 0)
	{
		$this->is_allowed('retur_penjualan_list');
		$filter = $this->input->get('q');
		$field  = $this->input->get('f');

		$filter_extra = [
			'date_start' => $this->input->get('date_start'),
			'date_end'   => $this->input->get('date_end'),
			'bulan'      => $this->input->get('bulan'),
			'tahun'      => $this->input->get('tahun'),
			'status'     => $this->input->get('status'),
		];

		$this->data['returs']          = $this->model_retur_penjualan->get($filter, $field, $this->limit_page, $offset, $filter_extra);
		$this->data['retur_counts']    = $this->model_retur_penjualan->count_all($filter, $field, $filter_extra);
		$this->data['available_years'] = $this->model_retur_penjualan->get_available_years();

		$config = ['base_url' => 'administrator/retur_penjualan/index/', 'total_rows' => $this->data['retur_counts'], 'per_page' => $this->limit_page, 'uri_segment' => 4];
		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Retur Penjualan');
		$this->render('backend/standart/administrator/retur_penjualan/retur_penjualan_list', $this->data);
	}

	public function add()
	{
		$this->is_allowed('retur_penjualan_add');
		$this->data['nomor_baru']  = $this->model_retur_penjualan->generate_nomor();
		$this->data['invoices']    = $this->db->where_in('status', ['sent','partial','paid'])->get('invoice')->result();
		$this->template->title('Buat Retur Penjualan');
		$this->render('backend/standart/administrator/retur_penjualan/retur_penjualan_add', $this->data);
	}

	public function add_save()
	{
		if (!$this->is_allowed('retur_penjualan_add', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$this->form_validation->set_rules('invoice_id', 'Invoice', 'trim|required');
		$this->form_validation->set_rules('alasan', 'Alasan Retur Utama', 'trim|required');
		$this->form_validation->set_rules('catatan', 'Detail Alasan Retur', 'trim|required');
		$this->form_validation->set_rules('tanggal_retur', 'Tanggal Retur', 'trim|required');

		if ($this->form_validation->run()) {
			$invoice = $this->db->get_where('invoice', ['id' => $this->input->post('invoice_id')])->row();

			$data = [
				'nomor_retur'    => $this->model_retur_penjualan->generate_nomor(),
				'invoice_id'     => $this->input->post('invoice_id'),
				'pelanggan_id'   => $invoice->pelanggan_id,
				'tanggal_retur'  => $this->input->post('tanggal_retur'),
				'alasan'         => $this->input->post('alasan'),
				'catatan'        => $this->input->post('catatan'),
				'tindak_lanjut'  => $this->input->post('tindak_lanjut') ?: 'tukar_barang',
				'status'         => 'draft',
				'created_by'     => get_user_data('username'),
				'created_at'     => date('Y-m-d H:i:s'),
			];

			$retur_id = $this->model_retur_penjualan->store($data);
			$total = 0;

			if ($retur_id && $this->input->post('items')) {
				foreach ($this->input->post('items') as $item) {
					if (empty($item['produk_id'])) continue;
					$qty   = max(1, (int) round($item['qty_retur']));
					$harga = (float) str_replace(['.', ','], '', $item['harga_satuan']);
					$sub   = $qty * $harga;
					$total += $sub;
					$this->db->insert('retur_penjualan_item', [
						'retur_penjualan_id' => $retur_id,
						'produk_id'          => $item['produk_id'],
						'rak_id'             => !empty($item['rak_id']) ? $item['rak_id'] : null,
						'qty_retur'          => $qty,
						'harga_satuan'       => $harga,
						'subtotal'           => $sub,
						'kondisi'            => $item['kondisi'] ?: 'baik',
						'alasan'             => $item['alasan'],
					]);
				}
				$this->db->update('retur_penjualan', ['total' => $total], ['id' => $retur_id]);
			}

			set_message('Retur penjualan berhasil dibuat.', 'success');
			$this->data['success']  = true;
			$this->data['redirect'] = base_url('administrator/retur_penjualan');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}
		$this->response($this->data);
	}

	public function view($id)
	{
		$this->is_allowed('retur_penjualan_view');
		$this->data['retur'] = $this->model_retur_penjualan->find_with_join($id);
		$this->data['items'] = $this->model_retur_penjualan->get_items($id);
		$this->template->title('Detail Retur Penjualan');
		$this->render('backend/standart/administrator/retur_penjualan/retur_penjualan_view', $this->data);
	}

	public function proses($id)
	{
		$this->is_allowed('retur_penjualan_update');
		$retur = $this->model_retur_penjualan->find($id);
		if ($retur && in_array($retur->status, ['draft', 'approved'])) {
			$this->db->update('retur_penjualan', ['status' => 'approved'], ['id' => $id]);
			$this->model_retur_penjualan->proses_retur($id, get_user_data('username'));
			set_message('Retur penjualan diproses. Stok telah diperbarui.', 'success');
		}
		redirect('administrator/retur_penjualan/view/' . $id);
	}

	public function laporan()
	{
		$this->is_allowed('retur_penjualan_list');
		$produk_id   = $this->input->get('produk_id');
		$date_start  = $this->input->get('date_start');
		$date_end    = $this->input->get('date_end');

		$this->data['laporan']   = $this->model_retur_penjualan->get_laporan($produk_id, $date_start, $date_end);
		$this->data['produks']   = $this->db->get('produk')->result();
		$this->template->title('Laporan Retur Penjualan');
		$this->render('backend/standart/administrator/retur_penjualan/retur_penjualan_laporan', $this->data);
	}

	public function get_invoice_items()
	{
		$invoice_id = $this->input->get('invoice_id');
		$items = $this->db->select('invoice_item.*, produk.nama_produk, produk.kode_produk, produk.default_rak_id')
			->join('produk', 'produk.id = invoice_item.produk_id')
			->get_where('invoice_item', ['invoice_id' => $invoice_id])->result();
		$raks = $this->db->get('rak')->result();
		$this->response(['success' => true, 'items' => $items, 'raks' => $raks]);
	}


	public function edit($id)
	{
		$this->is_allowed('retur_penjualan_update');
		$this->data['retur'] = $this->model_retur_penjualan->find($id);
		if (!$this->data['retur'] || $this->data['retur']->status != 'draft') {
			set_message('Hanya data berstatus Draft yang bisa diedit.', 'error');
			redirect('administrator/retur_penjualan');
		}
		$this->data['pelanggans'] = $this->db->where('status', 'aktif')->get('pelanggan')->result();
		$this->data['sos']        = $this->db->get('sales_order')->result();
		$this->data['produks']    = $this->db->where('status', 'aktif')->get('produk')->result();
		$this->data['items']      = $this->model_retur_penjualan->get_items($id);
		$this->template->title('Edit Retur Penjualan');
		$this->render('backend/standart/administrator/retur_penjualan/retur_penjualan_update', $this->data);
	}

	public function edit_save($id)
	{
		if (!$this->is_allowed('retur_penjualan_update', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$existing = $this->model_retur_penjualan->find($id);
		if (!$existing || $existing->status != 'draft') {
			$this->response(['success' => false, 'message' => 'Hanya data berstatus Draft yang bisa diedit.']); return;
		}

		$data = [
			'catatan'       => $this->input->post('catatan'),
			'updated_at'    => date('Y-m-d H:i:s'),
			'updated_by'    => get_user_data('username'),
		];
		$data['pelanggan_id']  = $this->input->post('pelanggan_id');
		$data['tanggal_retur'] = $this->input->post('tanggal_retur');
		$data['alasan']        = $this->input->post('alasan');
		$data['tindak_lanjut'] = $this->input->post('tindak_lanjut');

		$this->model_retur_penjualan->change($id, $data);

		// Update items: delete old and insert new
		$this->db->delete('retur_penjualan_item', ['retur_penjualan_id' => $id]);
		$total = 0;
		if ($this->input->post('items')) {
			foreach ($this->input->post('items') as $item) {
				if (empty($item['produk_id'])) continue;
				$qty   = max(1, (int) round($item['qty_retur']));
				$harga = (float) str_replace(['.', ','], '', $item['harga_satuan']);
				$sub   = $qty * $harga;
				$total += $sub;
				$this->db->insert('retur_penjualan_item', [
					'retur_penjualan_id' => $id,
					'produk_id'          => $item['produk_id'],
					'qty_retur'          => $qty,
					'harga_satuan'       => $harga,
					'subtotal'           => $sub,
					'kondisi'            => $item['kondisi'] ?: 'baik',
					'alasan'             => $item['alasan'] ?? '',
				]);
			}
			$this->db->update('retur_penjualan', ['total' => $total], ['id' => $id]);
		}

		set_message('Retur Penjualan berhasil diupdate.', 'success');
		$this->data['success']  = true;
		$this->data['redirect'] = base_url('administrator/retur_penjualan');
		$this->response($this->data);
	}

	public function delete($id = null)
	{
		$this->is_allowed('retur_penjualan_delete');
		$r = $this->model_retur_penjualan->find($id);
		if ($r) {
			if ($r->status == 'draft' || $this->aauth->is_admin()) {
				$this->db->delete('retur_penjualan_item', ['retur_penjualan_id' => $id]);
				$this->model_retur_penjualan->remove($id);
				set_message('Retur berhasil dihapus.', 'success');
			} else {
				set_message('Hanya retur berstatus Draft yang dapat dihapus.', 'error');
			}
		} else {
			set_message('Data retur tidak ditemukan.', 'error');
		}
		redirect('administrator/retur_penjualan');
	}

	public function cetak($id)
	{
		$this->is_allowed('retur_penjualan_view');
		$this->data['retur'] = $this->model_retur_penjualan->find_with_join($id);
		$this->data['items'] = $this->model_retur_penjualan->get_items($id);
		
		$this->load->library('HtmlPdf');
		$this->htmlpdf->initialize(['orientation' => 'P', 'format' => 'A4', 'marges' => [5, 5, 5, 5]]);
		$content = $this->load->view('retur_penjualan/backend/standart/administrator/retur_penjualan/retur_penjualan_pdf', $this->data, true);
		
		$this->htmlpdf->writeHTML($content);
		$retur = $this->data['retur'];
		$doc_num = preg_replace('/[^a-zA-Z0-9_-]/', '_', $retur->nomor_retur ?? $id);
		$filename = 'retur_penjualan_' . $doc_num . '.pdf';
		if (ob_get_length()) { ob_clean(); }
		$mode = $this->input->get('mode') ?: 'I';
		$this->htmlpdf->Output($filename, $mode);
	}

	public function export()
	{
		$this->is_allowed('retur_penjualan_export');

		$q     = $this->input->get('q');
		$field = $this->input->get('f');
		$filter_extra = [
			'date_start' => $this->input->get('date_start'),
			'date_end'   => $this->input->get('date_end'),
			'bulan'      => $this->input->get('bulan'),
			'tahun'      => $this->input->get('tahun'),
			'status'     => $this->input->get('status'),
		];

		$returs = $this->model_retur_penjualan->get($q, $field, 0, 0, $filter_extra);

		$filename = 'Laporan_Retur_Penjualan_' . date('Y-m-d') . '.xls';

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
			.total-row { font-weight: bold; background-color: #E2E8F0; color: #0F172A; }
		</style>\n</head>\n<body>\n";

		$headers = [
			'No',
			'No. Retur',
			'No. Invoice',
			'Pelanggan',
			'Tanggal Retur',
			'Total Nilai (Rp)',
			'Alasan Retur',
			'Tindak Lanjut',
			'Status Retur'
		];

		echo "<table border=\"1\" cellpadding=\"4\" cellspacing=\"0\">\n<thead>\n<tr>\n";
		foreach ($headers as $h) {
			echo '<th>' . htmlspecialchars($h) . "</th>\n";
		}
		echo "</tr>\n</thead>\n<tbody>\n";

		$no = 1;
		$total_nominal = 0;
		foreach ($returs as $r) {
			$total_nominal += (float)$r->total;
			$cls_row        = ($no % 2 === 0) ? ' class="zebra"' : '';

			echo "<tr{$cls_row}>\n";
			echo "<td class=\"center\">" . ($no++) . "</td>\n";
			echo "<td class=\"text center\">" . htmlspecialchars($r->nomor_retur) . "</td>\n";
			echo "<td class=\"text center\">" . htmlspecialchars($r->nomor_invoice ?: '-') . "</td>\n";
			echo "<td>" . htmlspecialchars($r->nama_pelanggan ?: '-') . "</td>\n";
			echo "<td class=\"center text\">" . date('d/m/Y', strtotime($r->tanggal_retur)) . "</td>\n";
			echo "<td class=\"currency\">" . (float)$r->total . "</td>\n";
			echo "<td>" . htmlspecialchars($r->alasan ?: '-') . "</td>\n";
			echo "<td class=\"center\">" . htmlspecialchars(ucwords(str_replace('_', ' ', $r->tindak_lanjut ?: '-'))) . "</td>\n";
			echo "<td class=\"center\">" . htmlspecialchars(strtoupper($r->status ?: '-')) . "</td>\n";
			echo "</tr>\n";
		}

		echo "</tbody>\n<tfoot>\n";
		echo "<tr class=\"total-row\">\n";
		echo "<td colspan=\"5\" class=\"center\" style=\"padding:10px;\">TOTAL KESELURUHAN</td>\n";
		echo "<td class=\"currency\" style=\"font-size:11pt;\">" . $total_nominal . "</td>\n";
		echo "<td colspan=\"3\"></td>\n";
		echo "</tr>\n</tfoot>\n</table>\n</body>\n</html>";
		exit;
	}

	public function export_pdf()
	{
		$this->is_allowed('retur_penjualan_export');

		$q     = $this->input->get('q');
		$field = $this->input->get('f');
		$filter_extra = [
			'date_start' => $this->input->get('date_start'),
			'date_end'   => $this->input->get('date_end'),
			'bulan'      => $this->input->get('bulan'),
			'tahun'      => $this->input->get('tahun'),
			'status'     => $this->input->get('status'),
		];

		$returs = $this->model_retur_penjualan->get($q, $field, 0, 0, $filter_extra);

		$total_nominal = 0;
		foreach ($returs as $r) {
			$total_nominal += (float)$r->total;
		}

		$this->data['returs']        = $returs;
		$this->data['total_nominal'] = $total_nominal;
		$this->data['search_q']      = $q;
		$this->data['filter_extra']  = $filter_extra;

		$this->load->library('HtmlPdf');
		$this->htmlpdf->initialize(['orientation' => 'L', 'format' => 'A4', 'marges' => [8, 8, 8, 8]]);
		$content = $this->load->view('retur_penjualan/backend/standart/administrator/retur_penjualan/retur_penjualan_rekap_pdf', $this->data, true);

		$this->htmlpdf->writeHTML($content);
		$filename = 'Laporan_Retur_Penjualan_' . date('Y-m-d') . '.pdf';
		if (ob_get_length()) { ob_clean(); }
		$mode = $this->input->get('mode') ?: 'I';
		$this->htmlpdf->Output($filename, $mode);
	}

}
