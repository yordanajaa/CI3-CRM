<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section
class Sales_order extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_sales_order');
	}

	public function index($offset = 0)
	{
		$this->is_allowed('sales_order_list');

		$filter = $this->input->get('q');
		$field  = $this->input->get('f');

		// Auto-sync SO status with sent/shipped Invoices (only for early stages draft/confirmed/packing)
		$this->db->query("
			UPDATE sales_order so
			JOIN invoice inv ON inv.so_id = so.id
			SET so.status = 'shipped'
			WHERE (inv.status_kirim = 'shipped' OR inv.status = 'sent') AND so.status IN ('draft', 'confirmed', 'packing')
		");

		$this->data['sos']       = $this->model_sales_order->get($filter, $field, $this->limit_page, $offset);
		$this->data['so_counts'] = $this->model_sales_order->count_all($filter, $field);
		$this->data['stats']     = $this->model_sales_order->get_stats();
		$this->data['pelanggans']= $this->db->order_by('nama_pelanggan', 'ASC')->get('pelanggan')->result();

		$config = [
			'base_url'    => 'administrator/sales_order/index/',
			'total_rows'  => $this->data['so_counts'],
			'per_page'    => $this->limit_page,
			'uri_segment' => 4,
		];
		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Transaksi Penjualan');
		$this->render('backend/standart/administrator/sales_order/sales_order_list', $this->data);
	}

	public function cepat()
	{
		$this->is_allowed('sales_order_add');
		$this->data['nomor_baru']      = $this->model_sales_order->generate_nomor();
		$this->data['nomor_ref_baru']  = $this->model_sales_order->generate_nomor_referensi();
		$this->data['pelanggans']      = $this->db->where('status', 'aktif')->order_by('nama_pelanggan', 'ASC')->get('pelanggan')->result();
		$this->data['produks']     = $this->db->select('produk.*, satuan.singkatan as nama_satuan, COALESCE(stok.qty, 0) as stok_qty')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT')
			->join('stok', 'stok.produk_id = produk.id', 'LEFT')
			->where('produk.status', 'aktif')
			->order_by('produk.id', 'ASC')
			->get('produk')->result();

		// Rekap 5 transaksi terakhir khusus POS Kasir Asli
		$this->data['last_transactions'] = $this->db
			->select('so.id, so.nomor_so, so.tanggal_so, so.total as grand_total, COALESCE(NULLIF(so.nama_penerima, ""), p.nama_pelanggan, "Pelanggan Umum") as nama_pelanggan, so.created_at')
			->from('sales_order so')
			->join('pelanggan p', 'p.id = so.pelanggan_id', 'LEFT')
			->where("(so.source = 'pos' OR so.catatan LIKE '%[POS CEPAT%')")
			->where('so.status !=', 'cancelled')
			->order_by('so.id', 'DESC')
			->limit(5)
			->get()->result();

		$this->template->title('Penjualan Cepat (POS Kasir)');
		$this->render('backend/standart/administrator/sales_order/sales_order_cepat', $this->data);
	}

	public function ajax_add_pelanggan()
	{
		$nama = trim((string)$this->input->post('nama_pelanggan'));
		if (empty($nama)) {
			$this->response(['success' => false, 'message' => 'Nama Pelanggan wajib diisi!']);
			return;
		}

		$telp   = trim((string)$this->input->post('telepon'));
		$tipe   = trim((string)$this->input->post('tipe_pelanggan')) ?: 'retail';
		$alamat = trim((string)$this->input->post('alamat'));
		$kota   = trim((string)$this->input->post('kota'));
		$email  = trim((string)$this->input->post('email'));

		$this->load->model('pelanggan/model_pelanggan');
		$kode = $this->model_pelanggan->generate_kode();

		$data = [
			'kode_pelanggan'  => $kode,
			'nama_pelanggan'  => $nama,
			'tipe_pelanggan'  => $tipe,
			'tier_pelanggan'  => strtoupper($tipe),
			'telepon'         => $telp,
			'no_telp'         => $telp,
			'email'           => $email,
			'alamat'          => $alamat,
			'kota'            => $kota,
			'status'          => 'aktif',
			'created_by'      => get_user_data('username') ?: 'admin',
			'created_at'      => date('Y-m-d H:i:s'),
		];

		$id = $this->model_pelanggan->store($data);

		if ($id) {
			$this->response([
				'success' => true,
				'message' => 'Data Pelanggan baru berhasil didaftarkan!',
				'data'    => [
					'id'     => $id,
					'kode'   => $kode,
					'nama'   => $nama,
					'tipe'   => $tipe,
					'telp'   => $telp,
					'alamat' => $alamat,
					'kota'   => $kota,
				]
			]);
		} else {
			$this->response(['success' => false, 'message' => 'Gagal menyimpan data pelanggan ke database.']);
		}
	}

	public function cepat_save()
	{
		if (!$this->is_allowed('sales_order_add', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$this->form_validation->set_rules('pelanggan_id', 'Pelanggan', 'trim|required');
		$this->form_validation->set_rules('tanggal_so', 'Tanggal Penjualan', 'trim|required');

		if ($this->form_validation->run()) {
			$pelanggan_raw    = trim($this->input->post('pelanggan_id'));
			$cust_telp_post   = trim($this->input->post('customer_telepon') ?: '');
			$cust_alamat_post = trim($this->input->post('customer_alamat') ?: '');
			$cust_kota_post   = trim($this->input->post('customer_kota') ?: '');
			$cust_tipe_post   = trim($this->input->post('customer_tipe') ?: '');

			if (is_numeric($pelanggan_raw)) {
				$pelanggan = $this->db->get_where('pelanggan', ['id' => $pelanggan_raw])->row();
				$pelanggan_id = $pelanggan ? $pelanggan->id : 1;
				$nama_penerima = $pelanggan ? $pelanggan->nama_pelanggan : 'Pelanggan Umum';
				$no_telepon    = $cust_telp_post ?: ($pelanggan ? ($pelanggan->no_telp ?: $pelanggan->telepon) : '');
				$alamat_pengiriman = $cust_alamat_post ?: ($pelanggan ? $pelanggan->alamat : '');
				$kota_kabupaten    = $cust_kota_post ?: ($pelanggan ? $pelanggan->kota : '');

				// Update data pelanggan jika sebelumnya kosong namun diisi di transaksi
				if ($pelanggan) {
					$up_cust = [];
					if (!empty($cust_telp_post) && empty($pelanggan->no_telp)) {
						$up_cust['no_telp'] = $cust_telp_post;
						$up_cust['telepon'] = $cust_telp_post;
					}
					if (!empty($cust_alamat_post) && empty($pelanggan->alamat)) {
						$up_cust['alamat'] = $cust_alamat_post;
					}
					if (!empty($cust_kota_post) && empty($pelanggan->kota)) {
						$up_cust['kota'] = $cust_kota_post;
					}
					if (!empty($cust_tipe_post) && $pelanggan->tipe_pelanggan != $cust_tipe_post) {
						$up_cust['tipe_pelanggan'] = $cust_tipe_post;
						$up_cust['tier_pelanggan'] = strtoupper($cust_tipe_post);
					}
					if (!empty($up_cust)) {
						$this->db->update('pelanggan', $up_cust, ['id' => $pelanggan->id]);
					}
				}
			} else {
				$nama_penerima = $pelanggan_raw;
				$pelanggan = $this->db->get_where('pelanggan', ['nama_pelanggan' => $nama_penerima])->row();
				if ($pelanggan) {
					$pelanggan_id = $pelanggan->id;
					$no_telepon   = $cust_telp_post ?: ($pelanggan->no_telp ?: $pelanggan->telepon);
					$alamat_pengiriman = $cust_alamat_post ?: $pelanggan->alamat;
					$kota_kabupaten    = $cust_kota_post ?: $pelanggan->kota;
					$up_cust = [];
					if (!empty($cust_telp_post) && empty($pelanggan->no_telp)) {
						$up_cust['no_telp'] = $cust_telp_post;
						$up_cust['telepon'] = $cust_telp_post;
					}
					if (!empty($cust_alamat_post) && empty($pelanggan->alamat)) {
						$up_cust['alamat'] = $cust_alamat_post;
					}
					if (!empty($cust_kota_post) && empty($pelanggan->kota)) {
						$up_cust['kota'] = $cust_kota_post;
					}
					if (!empty($cust_tipe_post) && $pelanggan->tipe_pelanggan != $cust_tipe_post) {
						$up_cust['tipe_pelanggan'] = $cust_tipe_post;
						$up_cust['tier_pelanggan'] = strtoupper($cust_tipe_post);
					}
					if (!empty($up_cust)) {
						$this->db->update('pelanggan', $up_cust, ['id' => $pelanggan->id]);
					}
				} else {
					$prefix_c = 'CUST-' . date('Ym') . '-';
					$last_c = $this->db->like('kode_pelanggan', $prefix_c, 'after')->order_by('id', 'DESC')->limit(1)->get('pelanggan')->row();
					$num_c = $last_c ? ((int) substr($last_c->kode_pelanggan, -4)) + 1 : 1;
					$kode_cus = $prefix_c . str_pad($num_c, 4, '0', STR_PAD_LEFT);
					$tipe_new = $cust_tipe_post ?: 'retail';
					$this->db->insert('pelanggan', [
						'kode_pelanggan' => $kode_cus,
						'nama_pelanggan' => $nama_penerima,
						'tipe_pelanggan' => $tipe_new,
						'tier_pelanggan' => strtoupper($tipe_new),
						'telepon'        => $cust_telp_post,
						'no_telp'        => $cust_telp_post,
						'alamat'         => $cust_alamat_post,
						'kota'           => $cust_kota_post,
						'status'         => 'aktif',
						'created_by'     => get_user_data('username') ?: 'admin',
						'created_at'     => date('Y-m-d H:i:s'),
					]);
					$pelanggan_id = $this->db->insert_id();
					$pelanggan = $this->db->get_where('pelanggan', ['id' => $pelanggan_id])->row();
					$no_telepon   = $cust_telp_post;
					$alamat_pengiriman = $cust_alamat_post;
					$kota_kabupaten    = $cust_kota_post;
				}
			}
			$nomor_so = $this->model_sales_order->generate_nomor();

			$metode_bayar = $this->input->post('metode_pembayaran') ?: 'tunai';
			$akun_kas     = $this->input->post('akun_kas_bank') ?: ($metode_bayar == 'tunai' ? 'Cash' : 'Transfer Bank');
			$no_ref       = trim($this->input->post('nomor_referensi')) ?: $this->model_sales_order->generate_nomor_referensi();
			$catatan_raw  = trim($this->input->post('catatan') ?: '');
			$catatan_bayar= $this->input->post('catatan_bayar') ?: ('Pembayaran Lunas Kasir SO ' . $nomor_so);

			$data = [
				'nomor_so'              => $nomor_so,
				'no_pesanan'            => $nomor_so,
				'pelanggan_id'          => $pelanggan_id,
				'nama_penerima'         => $nama_penerima,
				'no_telepon'            => $no_telepon,
				'alamat_pengiriman'     => $alamat_pengiriman,
				'kota_kabupaten'        => $kota_kabupaten,
				'source'                => 'pos',
				'tanggal_so'            => $this->input->post('tanggal_so') ?: date('Y-m-d'),
				'tanggal_estimasi_kirim'=> date('Y-m-d'),
				'diskon'                => (float) $this->input->post('diskon_persen_total'),
				'diskon_total'          => str_replace(['.', ','], '', (string)$this->input->post('diskon_total')) ?: 0,
				'pajak_persen'          => $this->input->post('pajak_persen') ?: 0,
				'status'                => 'delivered',
				'status_pesanan'        => 'selesai',
				'status_kirim'          => 'terkirim',
				'waktu_pembayaran'      => date('Y-m-d H:i:s'),
				'catatan'               => trim($catatan_raw . ' [POS CEPAT LUNAS - ' . strtoupper($metode_bayar) . ']' . ($no_ref ? ' Ref: ' . $no_ref : '')),
				'created_by'            => get_user_data('username'),
				'created_at'            => date('Y-m-d H:i:s'),
			];

			$items = $this->input->post('items');
			if (empty($items)) {
				$this->response(['success' => false, 'message' => 'Pilih minimal 1 item produk pesanan!']);
				return;
			}

			// Validasi stok secara agregat per produk
			$qty_per_produk = [];
			foreach ($items as $item) {
				if (empty($item['produk_id'])) continue;
				$pid = (int) $item['produk_id'];
				$q = max(0.001, (float) ($item['qty'] ?? 1));
				$qty_per_produk[$pid] = ($qty_per_produk[$pid] ?? 0) + $q;
			}

			if (empty($qty_per_produk)) {
				$this->response(['success' => false, 'message' => 'Pilih minimal 1 item produk pesanan!']);
				return;
			}

			foreach ($qty_per_produk as $pid => $total_qty_item) {
				$stok_row = $this->db->get_where('stok', ['produk_id' => $pid])->row();
				$stok_avail = $stok_row ? (float)$stok_row->qty : 0;

				if ($total_qty_item > $stok_avail) {
					$prod = $this->db->get_where('produk', ['id' => $pid])->row();
					$prod_name = $prod ? $prod->nama_produk : 'Produk';
					$this->response([
						'success' => false,
						'message' => "Gagal Simpan: Jumlah pesanan untuk ({$prod_name}) sejumlah {$total_qty_item} unit melebihi stok yang tersedia ({$stok_avail} unit)!"
					]);
					return;
				}
			}

			// Mulai Database Transaction agar seluruh pencatatan & pemotongan stok konsisten tanpa eror
			$this->db->trans_start();

			$so_id = $this->model_sales_order->store($data);

			if ($so_id) {
				foreach ($items as $item) {
					if (empty($item['produk_id'])) continue;
					$qty     = max(0.001, (float) ($item['qty'] ?? 1));
					$harga   = (float) str_replace(['.', ','], '', $item['harga_satuan']);
					$diskon  = (float) ($item['diskon_persen'] ?? 0);
					$d_nom   = $harga * $qty * ($diskon / 100);
					$subtotal = ($harga * $qty) - $d_nom;
					$this->db->insert('sales_order_item', [
						'so_id'         => $so_id,
						'produk_id'     => $item['produk_id'],
						'qty'           => $qty,
						'satuan'        => $item['satuan'] ?? 'pcs',
						'harga_satuan'  => $harga,
						'diskon_persen' => $diskon,
						'diskon_nominal'=> $d_nom,
						'subtotal'      => $subtotal,
						'catatan'       => $item['catatan'] ?? '',
					]);
				}
				$this->model_sales_order->update_total($so_id);
			}

			// Generate CRM Labels
			$this->load->model('crm/model_crm');
			$this->model_crm->generate_labels_for_order('sales_order', $so_id);

			$so = $this->model_sales_order->find($so_id);
			$this->db->update('sales_order', ['total_pembayaran' => $so->total], ['id' => $so_id]);

			// 1. Buat Faktur Invoice Paid
			$this->load->model('invoice/model_invoice');
			$nomor_inv = $this->model_invoice->generate_nomor();
			$data_inv = [
				'nomor_invoice'       => $nomor_inv,
				'so_id'               => $so_id,
				'pelanggan_id'        => $pelanggan_id,
				'tanggal_invoice'     => date('Y-m-d'),
				'tanggal_jatuh_tempo' => date('Y-m-d'),
				'subtotal'            => $so->subtotal,
				'diskon_total'        => $so->diskon_total,
				'pajak_persen'        => $so->pajak_persen,
				'pajak_nominal'       => $so->pajak_nominal,
				'total'               => $so->total,
				'status'              => 'paid',
				'status_kirim'        => 'delivered',
				'catatan'             => 'Faktur Penjualan Langsung Lunas (POS Cepat) SO ' . $nomor_so,
				'created_by'          => get_user_data('username'),
				'created_at'          => date('Y-m-d H:i:s'),
			];
			$invoice_id = $this->model_invoice->store($data_inv);

			// Insert invoice items
			$so_items = $this->model_sales_order->get_items($so_id);
			foreach ($so_items as $si) {
				$this->db->insert('invoice_item', [
					'invoice_id'    => $invoice_id,
					'produk_id'     => $si->produk_id,
					'so_item_id'    => $si->id,
					'qty'           => $si->qty,
					'satuan'        => $si->satuan,
					'harga_satuan'  => $si->harga_satuan,
					'diskon_persen' => $si->diskon_persen,
					'diskon_nominal'=> $si->diskon_nominal,
					'subtotal'      => $si->subtotal,
				]);
			}

			// 2. Potong Stok (FIFO/FEFO Log)
			$this->model_invoice->kurangi_stok($invoice_id, get_user_data('username'));

			// 3. Catat Piutang Usaha (Status: Lunas, Sisa: 0)
			$this->load->model('piutang_usaha/model_piutang_usaha');
			$prefix_piu = 'PIU-' . date('Ym') . '-';
			$last_p = $this->db->like('nomor_piutang', $prefix_piu, 'after')->order_by('id', 'DESC')->limit(1)->get('piutang_usaha')->row();
			$num_p = $last_p ? ((int) substr($last_p->nomor_piutang, -4)) + 1 : 1;
			$nomor_piu = $prefix_piu . str_pad($num_p, 4, '0', STR_PAD_LEFT);
			while ($this->db->where('nomor_piutang', $nomor_piu)->get('piutang_usaha')->num_rows() > 0) {
				$num_p++;
				$nomor_piu = $prefix_piu . str_pad($num_p, 4, '0', STR_PAD_LEFT);
			}

			$this->db->insert('piutang_usaha', [
				'nomor_piutang'       => $nomor_piu,
				'pelanggan_id'        => $pelanggan_id,
				'tanggal_piutang'     => date('Y-m-d'),
				'invoice_id'          => $invoice_id,
				'so_id'               => $so_id,
				'subtotal'            => $so->subtotal,
				'diskon'              => $so->diskon_total,
				'pajak'               => $so->pajak_nominal,
				'total'               => $so->total,
				'terbayar'            => $so->total,
				'sisa'                => 0,
				'tanggal_jatuh_tempo' => date('Y-m-d'),
				'status'              => 'lunas',
				'catatan'             => 'Pelunasan Langsung (POS Cepat) SO ' . $nomor_so,
				'created_at'          => date('Y-m-d H:i:s'),
			]);
			$piutang_id = $this->db->insert_id();

			// 4. Terbitkan Bukti Kas Masuk (BKM)
			$nomor_bkm = $this->model_piutang_usaha->generate_bkm();
			$this->db->insert('pembayaran_piutang', [
				'nomor_bkm'         => $nomor_bkm,
				'piutang_id'        => $piutang_id,
				'pelanggan_id'      => $pelanggan_id,
				'tanggal_bayar'     => date('Y-m-d'),
				'akun_kas_bank'     => $akun_kas,
				'metode_pembayaran' => $metode_bayar,
				'nomor_referensi'   => $no_ref,
				'nominal'           => $so->total,
				'catatan'           => $catatan_bayar,
				'created_by'        => get_user_data('username'),
			]);

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				$this->response([
					'success' => false,
					'message' => 'Terjadi kesalahan sistem database saat memproses transaksi kasir. Data transaksi dibatalkan demi keamanan.'
				]);
				return;
			}

			// Prepare receipt items for modal & printing
			$receipt_items = [];
			foreach ($so_items as $si) {
				$receipt_items[] = [
					'nama'          => $si->nama_produk,
					'nama_produk'   => $si->nama_produk,
					'qty'           => (float) $si->qty,
					'satuan'        => $si->satuan ?: 'pcs',
					'harga'         => (float) $si->harga_satuan,
					'harga_satuan'  => (float) $si->harga_satuan,
					'diskon'        => (float) $si->diskon_persen,
					'diskon_persen' => (float) $si->diskon_persen,
					'subtotal'      => (float) $si->subtotal,
				];
			}

			$uang_diterima_post = (float) str_replace(['.', ','], '', (string)$this->input->post('uang_diterima'));
			if ($uang_diterima_post <= 0) {
				$uang_diterima_post = (float) $so->total;
			}
			$kembalian_post = max(0, $uang_diterima_post - (float)$so->total);

			set_message("⚡ Transaksi Penjualan Cepat Berhasil Disimpan & LUNAS! No. Transaksi: {$nomor_so}, Faktur: {$nomor_inv}, Kas (BKM): {$nomor_bkm}. Stok otomatis terpotong.", 'success');
			$this->data['success']       = true;
			$this->data['message']       = "Transaksi {$nomor_so} Berhasil Disimpan & LUNAS!";
			$this->data['so_id']         = $so_id;
			$this->data['invoice_id']    = $invoice_id;
			$this->data['receipt']       = [
				'so_id'            => $so_id,
				'nomor_so'         => $nomor_so,
				'nomor_inv'        => $nomor_inv,
				'nomor_bkm'        => $nomor_bkm,
				'nomor_ref'        => $no_ref,
				'tanggal'          => date('d/m/Y H:i'),
				'kasir'            => get_user_data('username') ?: 'Kasir POS',
				'pelanggan'        => $nama_penerima,
				'telepon'          => $no_telepon,
				'alamat'           => $alamat_pengiriman,
				'metode_pembayaran'=> strtoupper($metode_bayar),
				'subtotal'         => (float) $so->subtotal,
				'diskon_total'     => (float) $so->diskon_total,
				'pajak_nominal'    => (float) $so->pajak_nominal,
				'total'            => (float) $so->total,
				'uang_diterima'    => (float) $uang_diterima_post,
				'kembalian'        => (float) $kembalian_post,
				'items'                 => $receipt_items,
				'print_struk_url'       => site_url('administrator/sales_order/cetak_struk/' . $so_id . '?template=thermal'),
				'print_nota_lebar_url'  => site_url('administrator/sales_order/cetak_struk/' . $so_id . '?template=lebar'),
				'print_pdf_url'         => site_url('administrator/sales_order/cetak/' . $so_id),
			];
			$this->data['next_nomor_so'] = $this->model_sales_order->generate_nomor();
			$this->data['next_nomor_ref']= $this->model_sales_order->generate_nomor_referensi();
			$this->data['redirect']      = base_url('administrator/sales_order/view/' . $so_id);
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}
		$this->response($this->data);
	}

	public function add()
	{
		$this->is_allowed('sales_order_add');
		$this->data['nomor_baru']  = $this->model_sales_order->generate_nomor();
		$this->data['pelanggans']  = $this->db->where('status', 'aktif')->order_by('nama_pelanggan', 'ASC')->get('pelanggan')->result();
		$this->data['produks']     = $this->db->select('produk.*, satuan.singkatan as nama_satuan, COALESCE(stok.qty, 0) as stok_qty')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT')
			->join('stok', 'stok.produk_id = produk.id', 'LEFT')
			->where('produk.status', 'aktif')
			->order_by('produk.id', 'ASC')
			->get('produk')->result();
		$this->template->title('Buat Transaksi Penjualan');
		$this->render('backend/standart/administrator/sales_order/sales_order_add', $this->data);
	}

	public function add_save()
	{
		if (!$this->is_allowed('sales_order_add', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$this->form_validation->set_rules('pelanggan_id', 'Pelanggan', 'trim|required');
		$this->form_validation->set_rules('tanggal_so', 'Tanggal Penjualan', 'trim|required');

		if ($this->form_validation->run()) {
			$pelanggan_id = $this->input->post('pelanggan_id');
			$pelanggan = $this->db->get_where('pelanggan', ['id' => $pelanggan_id])->row();
			$nomor_so = $this->model_sales_order->generate_nomor();

			$status_pembayaran = $this->input->post('status_pembayaran') ?: 'tempo';
			$save_action = $this->input->post('save_action');
			if (empty($save_action) || $save_action == 'confirm' || $save_action == 'draft') {
				$save_action = ($status_pembayaran == 'lunas' || $status_pembayaran == 'pay_lunas') ? 'lunas' : 'tempo';
			}
			if ($save_action != 'lunas' && $save_action != 'pay_lunas') {
				$save_action = 'tempo';
			}

			$syarat_bayar  = $this->input->post('syarat_pembayaran') ?: 'net_30';
			$tgl_tempo     = $this->input->post('tanggal_jatuh_tempo') ?: date('Y-m-d', strtotime('+30 days'));
			$tgl_tempo_fmt = date('d/m/Y', strtotime($tgl_tempo));

			$status_so = 'confirmed';
			$catatan_tambahan = '';
			if ($save_action == 'pay_lunas' || $save_action == 'lunas') {
				$status_so = 'delivered';
				$catatan_tambahan = ' [LUNAS ' . strtoupper($this->input->post('metode_pembayaran') ?: 'TUNAI') . ']';
			} else {
				$status_so = 'confirmed';
				$catatan_tambahan = ' [TEMPO ' . strtoupper(str_replace('_', ' ', $syarat_bayar)) . ' - Jatuh Tempo: ' . $tgl_tempo_fmt . ']';
			}

			$data = [
				'nomor_so'              => $nomor_so,
				'no_pesanan'            => $nomor_so,
				'pelanggan_id'          => $pelanggan_id,
				'nama_penerima'         => $pelanggan ? $pelanggan->nama_pelanggan : '',
				'no_telepon'            => $pelanggan ? ($pelanggan->no_telp ?: $pelanggan->telepon) : '',
				'alamat_pengiriman'     => $pelanggan ? $pelanggan->alamat : '',
				'kota_kabupaten'        => $pelanggan ? $pelanggan->kota : '',
				'source'                => 'manual',
				'tanggal_so'            => $this->input->post('tanggal_so'),
				'tanggal_estimasi_kirim'=> $tgl_tempo,
				'diskon'                => (float) $this->input->post('diskon_persen_total'),
				'diskon_total'          => str_replace(['.', ','], '', (string)$this->input->post('diskon_total')) ?: 0,
				'pajak_persen'          => $this->input->post('pajak_persen') ?: 0,
				'status'                => $status_so,
				'status_pesanan'        => ($save_action == 'pay_lunas' || $save_action == 'lunas') ? 'selesai' : 'proses',
				'status_kirim'          => ($save_action == 'pay_lunas' || $save_action == 'lunas') ? 'terkirim' : 'pending',
				'waktu_pembayaran'      => ($save_action == 'pay_lunas' || $save_action == 'lunas') ? date('Y-m-d H:i:s') : null,
				'catatan'               => trim(($this->input->post('catatan') ?: '') . $catatan_tambahan),
				'created_by'            => get_user_data('username'),
				'created_at'            => date('Y-m-d H:i:s'),
			];

			$so_id = $this->model_sales_order->store($data);

			if ($so_id && $this->input->post('items')) {

				// Backend Stock Check
				foreach ($this->input->post('items') as $item) {
					if (empty($item['produk_id'])) continue;
					$qty = max(1, (int) round($item['qty']));
					$stok_row = $this->db->get_where('stok', ['produk_id' => $item['produk_id']])->row();
					$stok_avail = $stok_row ? (float)$stok_row->qty : 0;

					if ($qty > $stok_avail) {
						$prod = $this->db->get_where('produk', ['id' => $item['produk_id']])->row();
						$prod_name = $prod ? $prod->nama_produk : 'Produk';
						$this->db->delete('sales_order', ['id' => $so_id]);
						$this->response([
							'success' => false,
							'message' => "Gagal Simpan: Jumlah pesanan untuk ({$prod_name}) sejumlah {$qty} unit melebihi stok yang tersedia ({$stok_avail} unit)!"
						]);
						return;
					}
				}

				foreach ($this->input->post('items') as $item) {
					if (empty($item['produk_id'])) continue;
					$qty     = max(1, (int) round($item['qty']));
					$harga   = (float) str_replace(['.', ','], '', $item['harga_satuan']);
					$diskon  = (float) $item['diskon_persen'];
					$d_nom   = $harga * $qty * ($diskon / 100);
					$subtotal = ($harga * $qty) - $d_nom;
					$this->db->insert('sales_order_item', [
						'so_id'         => $so_id,
						'produk_id'     => $item['produk_id'],
						'qty'           => $qty,
						'satuan'        => $item['satuan'],
						'harga_satuan'  => $harga,
						'diskon_persen' => $diskon,
						'diskon_nominal'=> $d_nom,
						'subtotal'      => $subtotal,
						'catatan'       => $item['catatan'] ?? '',
					]);
				}
				$this->model_sales_order->update_total($so_id);
			}

			// Generate CRM Follow-up Labels instantly
			$this->load->model('crm/model_crm');
			$this->model_crm->generate_labels_for_order('sales_order', $so_id);

			if ($save_action == 'pay_lunas' || $save_action == 'lunas') {
				$so = $this->model_sales_order->find($so_id);
				$metode_bayar = $this->input->post('metode_pembayaran') ?: 'tunai';
				$akun_kas     = $this->input->post('akun_kas_bank') ?: ($metode_bayar == 'tunai' ? 'Cash' : 'Transfer Bank');
				$no_ref       = $this->input->post('nomor_referensi') ?: '';
				$catatan_bayar= $this->input->post('catatan_bayar') ?: ('Pembayaran Lunas Kasir SO ' . $nomor_so);

				// Update total_pembayaran di SO
				$this->db->update('sales_order', ['total_pembayaran' => $so->total], ['id' => $so_id]);

				// 1. Buat Invoice Otomatis (Status: Paid, Status Kirim: Delivered)
				$this->load->model('invoice/model_invoice');
				$nomor_inv = $this->model_invoice->generate_nomor();
				$data_inv = [
					'nomor_invoice'       => $nomor_inv,
					'so_id'               => $so_id,
					'pelanggan_id'        => $pelanggan_id,
					'tanggal_invoice'     => $this->input->post('tanggal_so') ?: date('Y-m-d'),
					'tanggal_jatuh_tempo' => date('Y-m-d'),
					'subtotal'            => $so->subtotal,
					'diskon_total'        => $so->diskon_total,
					'pajak_persen'        => $so->pajak_persen,
					'pajak_nominal'       => $so->pajak_nominal,
					'total'               => $so->total,
					'status'              => 'paid',
					'status_kirim'        => 'delivered',
					'catatan'             => 'Faktur Penjualan Langsung Lunas SO ' . $nomor_so,
					'created_by'          => get_user_data('username'),
					'created_at'          => date('Y-m-d H:i:s'),
				];
				$invoice_id = $this->model_invoice->store($data_inv);

				// Insert invoice items
				$so_items = $this->model_sales_order->get_items($so_id);
				foreach ($so_items as $si) {
					$this->db->insert('invoice_item', [
						'invoice_id'    => $invoice_id,
						'produk_id'     => $si->produk_id,
						'so_item_id'    => $si->id,
						'qty'           => $si->qty,
						'satuan'        => $si->satuan,
						'harga_satuan'  => $si->harga_satuan,
						'diskon_persen' => $si->diskon_persen,
						'diskon_nominal'=> $si->diskon_nominal,
						'subtotal'      => $si->subtotal,
					]);
				}

				// 2. Potong Stok dengan FIFO / FEFO Log
				$this->model_invoice->kurangi_stok($invoice_id, get_user_data('username'));

				// 3. Catat Piutang Usaha (Status: Lunas, Sisa: 0)
				$this->load->model('piutang_usaha/model_piutang_usaha');
				$prefix_piu = 'PIU-' . date('Ym') . '-';
				$last_p = $this->db->like('nomor_piutang', $prefix_piu, 'after')->order_by('id', 'DESC')->limit(1)->get('piutang_usaha')->row();
				$num_p = $last_p ? ((int) substr($last_p->nomor_piutang, -4)) + 1 : 1;
				$nomor_piu = $prefix_piu . str_pad($num_p, 4, '0', STR_PAD_LEFT);
				while ($this->db->where('nomor_piutang', $nomor_piu)->get('piutang_usaha')->num_rows() > 0) {
					$num_p++;
					$nomor_piu = $prefix_piu . str_pad($num_p, 4, '0', STR_PAD_LEFT);
				}

				$this->db->insert('piutang_usaha', [
					'nomor_piutang'       => $nomor_piu,
					'pelanggan_id'        => $pelanggan_id,
					'tanggal_piutang'     => $this->input->post('tanggal_so') ?: date('Y-m-d'),
					'invoice_id'          => $invoice_id,
					'so_id'               => $so_id,
					'subtotal'            => $so->subtotal,
					'diskon'              => $so->diskon_total,
					'pajak'               => $so->pajak_nominal,
					'total'               => $so->total,
					'terbayar'            => $so->total,
					'sisa'                => 0,
					'tanggal_jatuh_tempo' => date('Y-m-d'),
					'status'              => 'lunas',
					'catatan'             => 'Pelunasan Langsung (POS) SO ' . $nomor_so,
					'created_at'          => date('Y-m-d H:i:s'),
				]);
				$piutang_id = $this->db->insert_id();

				// 4. Terbitkan Bukti Kas Masuk (BKM)
				$nomor_bkm = $this->model_piutang_usaha->generate_bkm();
				$this->db->insert('pembayaran_piutang', [
					'nomor_bkm'         => $nomor_bkm,
					'piutang_id'        => $piutang_id,
					'pelanggan_id'      => $pelanggan_id,
					'tanggal_bayar'     => date('Y-m-d'),
					'akun_kas_bank'     => $akun_kas,
					'metode_pembayaran' => $metode_bayar,
					'nomor_referensi'   => $no_ref,
					'nominal'           => $so->total,
					'catatan'           => $catatan_bayar,
					'created_by'        => get_user_data('username'),
					'created_at'        => date('Y-m-d H:i:s'),
				]);

				set_message("Transaksi LUNAS Berhasil! No. Transaksi: {$nomor_so}, Faktur: {$nomor_inv}, Kas (BKM): {$nomor_bkm}. Stok otomatis terpotong.", 'success');
				$this->data['success']  = true;
				$this->data['redirect'] = base_url('administrator/sales_order/view/' . $so_id);
			} elseif ($save_action == 'tempo') {
				$so = $this->model_sales_order->find($so_id);
				$syarat_bayar = $this->input->post('syarat_pembayaran') ?: 'net_30';
				$tgl_tempo    = $this->input->post('tanggal_jatuh_tempo') ?: date('Y-m-d', strtotime('+30 days'));

				// 1. Buat Invoice Otomatis (Status: sent, Status Kirim: processing)
				$this->load->model('invoice/model_invoice');
				$nomor_inv = $this->model_invoice->generate_nomor();
				$data_inv = [
					'nomor_invoice'       => $nomor_inv,
					'so_id'               => $so_id,
					'pelanggan_id'        => $pelanggan_id,
					'tanggal_invoice'     => $this->input->post('tanggal_so') ?: date('Y-m-d'),
					'tanggal_jatuh_tempo' => $tgl_tempo,
					'subtotal'            => $so->subtotal,
					'diskon_total'        => $so->diskon_total,
					'pajak_persen'        => $so->pajak_persen,
					'pajak_nominal'       => $so->pajak_nominal,
					'total'               => $so->total,
					'status'              => 'sent',
					'status_kirim'        => 'processing',
					'catatan'             => 'Faktur Tagihan Penjualan Tempo (' . strtoupper(str_replace('_', ' ', $syarat_bayar)) . ') SO ' . $nomor_so,
					'created_by'          => get_user_data('username'),
					'created_at'          => date('Y-m-d H:i:s'),
				];
				$invoice_id = $this->model_invoice->store($data_inv);

				// Insert invoice items
				$so_items = $this->model_sales_order->get_items($so_id);
				foreach ($so_items as $si) {
					$this->db->insert('invoice_item', [
						'invoice_id'    => $invoice_id,
						'produk_id'     => $si->produk_id,
						'so_item_id'    => $si->id,
						'qty'           => $si->qty,
						'satuan'        => $si->satuan,
						'harga_satuan'  => $si->harga_satuan,
						'diskon_persen' => $si->diskon_persen,
						'diskon_nominal'=> $si->diskon_nominal,
						'subtotal'      => $si->subtotal,
					]);
				}

				// 2. Potong Stok dengan FIFO / FEFO Log
				$this->model_invoice->kurangi_stok($invoice_id, get_user_data('username'));

				// 3. Catat Piutang Usaha (Status: belum_bayar, Sisa: total, Terbayar: 0)
				$this->load->model('piutang_usaha/model_piutang_usaha');
				$prefix_piu = 'PIU-' . date('Ym') . '-';
				$last_p = $this->db->like('nomor_piutang', $prefix_piu, 'after')->order_by('id', 'DESC')->limit(1)->get('piutang_usaha')->row();
				$num_p = $last_p ? ((int) substr($last_p->nomor_piutang, -4)) + 1 : 1;
				$nomor_piu = $prefix_piu . str_pad($num_p, 4, '0', STR_PAD_LEFT);
				while ($this->db->where('nomor_piutang', $nomor_piu)->get('piutang_usaha')->num_rows() > 0) {
					$num_p++;
					$nomor_piu = $prefix_piu . str_pad($num_p, 4, '0', STR_PAD_LEFT);
				}

				$this->db->insert('piutang_usaha', [
					'nomor_piutang'       => $nomor_piu,
					'pelanggan_id'        => $pelanggan_id,
					'tanggal_piutang'     => $this->input->post('tanggal_so') ?: date('Y-m-d'),
					'invoice_id'          => $invoice_id,
					'so_id'               => $so_id,
					'subtotal'            => $so->subtotal,
					'diskon'              => $so->diskon_total,
					'pajak'               => $so->pajak_nominal,
					'total'               => $so->total,
					'terbayar'            => 0,
					'sisa'                => $so->total,
					'tanggal_jatuh_tempo' => $tgl_tempo,
					'status'              => 'belum_bayar',
					'catatan'             => 'Tagihan Piutang Penjualan Tempo (' . strtoupper(str_replace('_', ' ', $syarat_bayar)) . ') No. Transaksi ' . $nomor_so,
					'created_at'          => date('Y-m-d H:i:s'),
				]);

				$tgl_tempo_fmt = date('d/m/Y', strtotime($tgl_tempo));
				$tot_fmt = number_format($so->total, 0, ',', '.');
				set_message("Penjualan Tempo Berhasil Diterbitkan! No. Transaksi: {$nomor_so}, Faktur: {$nomor_inv}, Piutang: {$nomor_piu} senilai Rp {$tot_fmt} (Jatuh Tempo: {$tgl_tempo_fmt}). Tagihan otomatis masuk ke Piutang Usaha.", 'success');
				$this->data['success']  = true;
				$this->data['redirect'] = base_url('administrator/sales_order/view/' . $so_id);
			} else {
				set_message('Transaksi Penjualan berhasil dibuat sebagai Draft.', 'success');
				$this->data['success']  = true;
				$this->data['redirect'] = base_url('administrator/sales_order/view/' . $so_id);
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}
		$this->response($this->data);
	}

	public function view($id)
	{
		$this->is_allowed('sales_order_view');
		$this->data['so']    = $this->model_sales_order->find_with_detail($id);
		$this->data['items'] = $this->model_sales_order->get_items($id);
		$this->template->title('Detail Transaksi Penjualan');
		$this->render('backend/standart/administrator/sales_order/sales_order_view', $this->data);
	}

	public function konfirmasi($id)
	{
		$this->is_allowed('sales_order_update');
		$so = $this->model_sales_order->find($id);

		if ($so && $so->status == 'draft') {
			// Cek stok dulu
			$stok_errors = $this->model_sales_order->cek_stok($id);
			if (count($stok_errors) > 0) {
				set_message('Gagal: ' . implode(', ', $stok_errors), 'error');
			} else {
				$this->db->update('sales_order', ['status' => 'confirmed', 'updated_at' => date('Y-m-d H:i:s')], ['id' => $id]);
				$this->load->model('crm/model_crm');
				$this->model_crm->generate_labels_for_order('sales_order', $id);
				set_message('Transaksi Penjualan berhasil dikonfirmasi.', 'success');
			}
		} else {
			set_message('Transaksi Penjualan sudah dikonfirmasi sebelumnya.', 'warning');
		}
		redirect('administrator/sales_order/view/' . $id);
	}

	public function buat_invoice($id)
	{
		$this->is_allowed('invoice_add');
		redirect('administrator/invoice/from_so/' . $id);
	}


	public function edit($id)
	{
		$this->is_allowed('sales_order_update');
		$this->data['so'] = $this->model_sales_order->find($id);
		if (!$this->data['so'] || $this->data['so']->status == 'cancelled') {
			set_message('Pesanan yang dibatalkan tidak bisa diedit.', 'error');
			redirect('administrator/sales_order');
		}
		$this->data['pelanggans'] = $this->db->where('status', 'aktif')->order_by('nama_pelanggan', 'ASC')->get('pelanggan')->result();
		$this->data['produks']    = $this->db->where('status', 'aktif')->get('produk')->result();
		$this->data['items']      = $this->model_sales_order->get_items($id);
		$this->template->title('Edit Transaksi Penjualan');
		$this->render('backend/standart/administrator/sales_order/sales_order_update', $this->data);
	}

	public function edit_save($id)
	{
		if (!$this->is_allowed('sales_order_update', false)) {
			$this->response(['success' => false, 'message' => 'Tidak punya akses']); return;
		}

		$existing = $this->model_sales_order->find($id);
		if (!$existing || $existing->status == 'cancelled') {
			$this->response(['success' => false, 'message' => 'Pesanan yang dibatalkan tidak bisa diedit.']); return;
		}

		$pelanggan_id = $this->input->post('pelanggan_id');
		$pelanggan = $this->db->get_where('pelanggan', ['id' => $pelanggan_id])->row();

		$data = [
			'catatan'               => $this->input->post('catatan'),
			'updated_at'            => date('Y-m-d H:i:s'),
			'updated_by'            => get_user_data('username'),
			'pelanggan_id'          => $pelanggan_id,
			'nama_penerima'         => $pelanggan ? $pelanggan->nama_pelanggan : '',
			'no_telepon'            => $pelanggan ? ($pelanggan->no_telp ?? $pelanggan->telepon ?? '') : '',
			'alamat_pengiriman'     => $pelanggan ? $pelanggan->alamat : '',
			'kota_kabupaten'        => $pelanggan ? $pelanggan->kota : '',
			'source'                => $existing->source ?: 'manual',
			'tanggal_so'            => $this->input->post('tanggal_so'),
			'tanggal_estimasi_kirim'=> $this->input->post('tanggal_estimasi_kirim') ?: null,
			'diskon'                => (float) $this->input->post('diskon_persen_total'),
			'diskon_total'          => (float) str_replace(['.', ','], '', (string)$this->input->post('diskon_total')),
			'pajak_persen'          => (float) str_replace(['.', ','], '', (string)$this->input->post('pajak_persen')),
		];

		$this->model_sales_order->change($id, $data);

		// Update items: delete old and insert new
		$this->db->delete('sales_order_item', ['so_id' => $id]);
		if ($this->input->post('items')) {
			foreach ($this->input->post('items') as $item) {
				if (empty($item['produk_id'])) continue;
				$qty     = max(1, (int) round($item['qty']));
				$harga   = (float) str_replace(['.', ','], '', $item['harga_satuan']);
				$diskon  = isset($item['diskon_persen']) ? (float) $item['diskon_persen'] : 0;
				$d_nom   = $harga * $qty * ($diskon / 100);
				$subtotal = ($harga * $qty) - $d_nom;
				$this->db->insert('sales_order_item', [
					'so_id'         => $id,
					'produk_id'     => $item['produk_id'],
					'qty'           => $qty,
					'satuan'        => $item['satuan'] ?? 'pcs',
					'harga_satuan'  => $harga,
					'diskon_persen' => $diskon,
					'diskon_nominal'=> $d_nom,
					'subtotal'      => $subtotal,
					'catatan'       => $item['catatan'] ?? '',
				]);
			}
			$this->model_sales_order->update_total($id);
		}

		// Sync CRM labels
		$this->load->model('crm/model_crm');
		$this->model_crm->generate_labels_for_order('sales_order', $id);

		$status_pembayaran = $this->input->post('status_pembayaran') ?: 'tempo';
		$save_action = $this->input->post('save_action') ?: $status_pembayaran;
		if (empty($save_action) || $save_action == 'confirm' || $save_action == 'draft') {
			$save_action = ($status_pembayaran == 'lunas' || $status_pembayaran == 'pay_lunas') ? 'lunas' : 'tempo';
		}
		if ($save_action != 'lunas' && $save_action != 'pay_lunas') {
			$save_action = 'tempo';
		}

		if ($save_action == 'pay_lunas' || $save_action == 'lunas') {
			$so = $this->model_sales_order->find($id);
			$metode_bayar = $this->input->post('metode_pembayaran') ?: 'tunai';
			$akun_kas     = $this->input->post('akun_kas_bank') ?: ($metode_bayar == 'tunai' ? 'Cash' : 'Transfer Bank');
			$no_ref       = $this->input->post('nomor_referensi') ?: '';
			$catatan_bayar= $this->input->post('catatan_bayar') ?: ('Pembayaran Lunas Kasir SO ' . $so->nomor_so);

			$this->db->update('sales_order', [
				'status'           => 'delivered',
				'status_pesanan'   => 'selesai',
				'status_kirim'     => 'terkirim',
				'waktu_pembayaran' => $so->waktu_pembayaran ?: date('Y-m-d H:i:s'),
				'total_pembayaran' => $so->total,
				'updated_at'       => date('Y-m-d H:i:s')
			], ['id' => $id]);

			$this->load->model('invoice/model_invoice');
			$existing_inv = $this->db->get_where('invoice', ['so_id' => $id])->row();
			if ($existing_inv) {
				$invoice_id = $existing_inv->id;
				$this->db->update('invoice', [
					'pelanggan_id'        => $pelanggan_id,
					'tanggal_invoice'     => $this->input->post('tanggal_so') ?: date('Y-m-d'),
					'subtotal'            => $so->subtotal,
					'diskon_total'        => $so->diskon_total,
					'pajak_persen'        => $so->pajak_persen,
					'pajak_nominal'       => $so->pajak_nominal,
					'total'               => $so->total,
					'status'              => 'paid',
					'status_kirim'        => 'delivered',
					'updated_at'          => date('Y-m-d H:i:s'),
				], ['id' => $invoice_id]);

				$this->db->delete('invoice_item', ['invoice_id' => $invoice_id]);
				$so_items = $this->model_sales_order->get_items($id);
				foreach ($so_items as $si) {
					$this->db->insert('invoice_item', [
						'invoice_id'    => $invoice_id,
						'produk_id'     => $si->produk_id,
						'so_item_id'    => $si->id,
						'qty'           => $si->qty,
						'satuan'        => $si->satuan,
						'harga_satuan'  => $si->harga_satuan,
						'diskon_persen' => $si->diskon_persen,
						'diskon_nominal'=> $si->diskon_nominal,
						'subtotal'      => $si->subtotal,
					]);
				}
			} else {
				$nomor_inv = $this->model_invoice->generate_nomor();
				$data_inv = [
					'nomor_invoice'       => $nomor_inv,
					'so_id'               => $id,
					'pelanggan_id'        => $pelanggan_id,
					'tanggal_invoice'     => $this->input->post('tanggal_so') ?: date('Y-m-d'),
					'tanggal_jatuh_tempo' => date('Y-m-d'),
					'subtotal'            => $so->subtotal,
					'diskon_total'        => $so->diskon_total,
					'pajak_persen'        => $so->pajak_persen,
					'pajak_nominal'       => $so->pajak_nominal,
					'total'               => $so->total,
					'status'              => 'paid',
					'status_kirim'        => 'delivered',
					'catatan'             => 'Faktur Penjualan Langsung Lunas SO ' . $so->nomor_so,
					'created_by'          => get_user_data('username'),
					'created_at'          => date('Y-m-d H:i:s'),
				];
				$invoice_id = $this->model_invoice->store($data_inv);

				$so_items = $this->model_sales_order->get_items($id);
				foreach ($so_items as $si) {
					$this->db->insert('invoice_item', [
						'invoice_id'    => $invoice_id,
						'produk_id'     => $si->produk_id,
						'so_item_id'    => $si->id,
						'qty'           => $si->qty,
						'satuan'        => $si->satuan,
						'harga_satuan'  => $si->harga_satuan,
						'diskon_persen' => $si->diskon_persen,
						'diskon_nominal'=> $si->diskon_nominal,
						'subtotal'      => $si->subtotal,
					]);
				}
				$this->model_invoice->kurangi_stok($invoice_id, get_user_data('username'));
			}

			// Update/Insert piutang
			$this->load->model('piutang_usaha/model_piutang_usaha');
			$existing_piu = $this->db->get_where('piutang_usaha', ['so_id' => $id])->row();
			if ($existing_piu) {
				$this->db->update('piutang_usaha', [
					'pelanggan_id'        => $pelanggan_id,
					'subtotal'            => $so->subtotal,
					'diskon'              => $so->diskon_total,
					'pajak'               => $so->pajak_nominal,
					'total'               => $so->total,
					'terbayar'            => $so->total,
					'sisa'                => 0,
					'status'              => 'lunas',
					'updated_at'          => date('Y-m-d H:i:s'),
				], ['id' => $existing_piu->id]);
			} else {
				$prefix_piu = 'PIU-' . date('Ym') . '-';
				$last_p = $this->db->like('nomor_piutang', $prefix_piu, 'after')->order_by('id', 'DESC')->limit(1)->get('piutang_usaha')->row();
				$num_p = $last_p ? ((int) substr($last_p->nomor_piutang, -4)) + 1 : 1;
				$nomor_piu = $prefix_piu . str_pad($num_p, 4, '0', STR_PAD_LEFT);
				while ($this->db->where('nomor_piutang', $nomor_piu)->get('piutang_usaha')->num_rows() > 0) {
					$num_p++;
					$nomor_piu = $prefix_piu . str_pad($num_p, 4, '0', STR_PAD_LEFT);
				}

				$this->db->insert('piutang_usaha', [
					'nomor_piutang'       => $nomor_piu,
					'pelanggan_id'        => $pelanggan_id,
					'tanggal_piutang'     => $this->input->post('tanggal_so') ?: date('Y-m-d'),
					'invoice_id'          => $invoice_id,
					'so_id'               => $id,
					'subtotal'            => $so->subtotal,
					'diskon'              => $so->diskon_total,
					'pajak'               => $so->pajak_nominal,
					'total'               => $so->total,
					'terbayar'            => $so->total,
					'sisa'                => 0,
					'tanggal_jatuh_tempo' => date('Y-m-d'),
					'status'              => 'lunas',
					'catatan'             => 'Pelunasan Langsung (POS) SO ' . $so->nomor_so,
					'created_at'          => date('Y-m-d H:i:s'),
				]);
				$piutang_id = $this->db->insert_id();

				$nomor_bkm = $this->model_piutang_usaha->generate_bkm();
				$this->db->insert('pembayaran_piutang', [
					'nomor_bkm'         => $nomor_bkm,
					'piutang_id'        => $piutang_id,
					'pelanggan_id'      => $pelanggan_id,
					'tanggal_bayar'     => date('Y-m-d'),
					'akun_kas_bank'     => $akun_kas,
					'metode_pembayaran' => $metode_bayar,
					'nomor_referensi'   => $no_ref,
					'nominal'           => $so->total,
					'catatan'           => $catatan_bayar,
					'created_by'        => get_user_data('username'),
					'created_at'        => date('Y-m-d H:i:s'),
				]);
			}

			set_message("Perubahan Transaksi Penjualan {$so->nomor_so} (Lunas) berhasil disimpan.", 'success');
			$this->data['success']  = true;
			$this->data['redirect'] = base_url('administrator/sales_order/view/' . $id);
		} elseif ($save_action == 'tempo') {
			$so = $this->model_sales_order->find($id);
			$syarat_bayar = $this->input->post('syarat_pembayaran') ?: 'net_30';
			$tgl_tempo    = $this->input->post('tanggal_jatuh_tempo') ?: date('Y-m-d', strtotime('+30 days'));

			$this->db->update('sales_order', [
				'status'         => 'confirmed',
				'status_pesanan' => 'proses',
				'status_kirim'   => 'pending',
				'updated_at'     => date('Y-m-d H:i:s'),
			], ['id' => $id]);

			$this->load->model('invoice/model_invoice');
			$existing_inv = $this->db->get_where('invoice', ['so_id' => $id])->row();
			if ($existing_inv) {
				$invoice_id = $existing_inv->id;
				$this->db->update('invoice', [
					'pelanggan_id'        => $pelanggan_id,
					'tanggal_invoice'     => $this->input->post('tanggal_so') ?: date('Y-m-d'),
					'tanggal_jatuh_tempo' => $tgl_tempo,
					'subtotal'            => $so->subtotal,
					'diskon_total'        => $so->diskon_total,
					'pajak_persen'        => $so->pajak_persen,
					'pajak_nominal'       => $so->pajak_nominal,
					'total'               => $so->total,
					'updated_at'          => date('Y-m-d H:i:s'),
				], ['id' => $invoice_id]);

				$this->db->delete('invoice_item', ['invoice_id' => $invoice_id]);
				$so_items = $this->model_sales_order->get_items($id);
				foreach ($so_items as $si) {
					$this->db->insert('invoice_item', [
						'invoice_id'    => $invoice_id,
						'produk_id'     => $si->produk_id,
						'so_item_id'    => $si->id,
						'qty'           => $si->qty,
						'satuan'        => $si->satuan,
						'harga_satuan'  => $si->harga_satuan,
						'diskon_persen' => $si->diskon_persen,
						'diskon_nominal'=> $si->diskon_nominal,
						'subtotal'      => $si->subtotal,
					]);
				}
			} else {
				$nomor_inv = $this->model_invoice->generate_nomor();
				$data_inv = [
					'nomor_invoice'       => $nomor_inv,
					'so_id'               => $id,
					'pelanggan_id'        => $pelanggan_id,
					'tanggal_invoice'     => $this->input->post('tanggal_so') ?: date('Y-m-d'),
					'tanggal_jatuh_tempo' => $tgl_tempo,
					'subtotal'            => $so->subtotal,
					'diskon_total'        => $so->diskon_total,
					'pajak_persen'        => $so->pajak_persen,
					'pajak_nominal'       => $so->pajak_nominal,
					'total'               => $so->total,
					'status'              => 'sent',
					'status_kirim'        => 'processing',
					'catatan'             => 'Faktur Tagihan Penjualan Tempo (' . strtoupper(str_replace('_', ' ', $syarat_bayar)) . ') SO ' . $so->nomor_so,
					'created_by'          => get_user_data('username'),
					'created_at'          => date('Y-m-d H:i:s'),
				];
				$invoice_id = $this->model_invoice->store($data_inv);

				$so_items = $this->model_sales_order->get_items($id);
				foreach ($so_items as $si) {
					$this->db->insert('invoice_item', [
						'invoice_id'    => $invoice_id,
						'produk_id'     => $si->produk_id,
						'so_item_id'    => $si->id,
						'qty'           => $si->qty,
						'satuan'        => $si->satuan,
						'harga_satuan'  => $si->harga_satuan,
						'diskon_persen' => $si->diskon_persen,
						'diskon_nominal'=> $si->diskon_nominal,
						'subtotal'      => $si->subtotal,
					]);
				}
				$this->model_invoice->kurangi_stok($invoice_id, get_user_data('username'));
			}

			// Update/Insert piutang usaha
			$this->load->model('piutang_usaha/model_piutang_usaha');
			$existing_piu = $this->db->get_where('piutang_usaha', ['so_id' => $id])->row();
			if ($existing_piu) {
				$this->db->update('piutang_usaha', [
					'pelanggan_id'        => $pelanggan_id,
					'subtotal'            => $so->subtotal,
					'diskon'              => $so->diskon_total,
					'pajak'               => $so->pajak_nominal,
					'total'               => $so->total,
					'sisa'                => max(0, $so->total - (float)$existing_piu->terbayar),
					'tanggal_jatuh_tempo' => $tgl_tempo,
					'updated_at'          => date('Y-m-d H:i:s'),
				], ['id' => $existing_piu->id]);
			} else {
				$prefix_piu = 'PIU-' . date('Ym') . '-';
				$last_p = $this->db->like('nomor_piutang', $prefix_piu, 'after')->order_by('id', 'DESC')->limit(1)->get('piutang_usaha')->row();
				$num_p = $last_p ? ((int) substr($last_p->nomor_piutang, -4)) + 1 : 1;
				$nomor_piu = $prefix_piu . str_pad($num_p, 4, '0', STR_PAD_LEFT);
				while ($this->db->where('nomor_piutang', $nomor_piu)->get('piutang_usaha')->num_rows() > 0) {
					$num_p++;
					$nomor_piu = $prefix_piu . str_pad($num_p, 4, '0', STR_PAD_LEFT);
				}

				$this->db->insert('piutang_usaha', [
					'nomor_piutang'       => $nomor_piu,
					'pelanggan_id'        => $pelanggan_id,
					'tanggal_piutang'     => $this->input->post('tanggal_so') ?: date('Y-m-d'),
					'invoice_id'          => $invoice_id,
					'so_id'               => $id,
					'subtotal'            => $so->subtotal,
					'diskon'              => $so->diskon_total,
					'pajak'               => $so->pajak_nominal,
					'total'               => $so->total,
					'terbayar'            => 0,
					'sisa'                => $so->total,
					'tanggal_jatuh_tempo' => $tgl_tempo,
					'status'              => 'belum_bayar',
					'catatan'             => 'Tagihan Piutang Penjualan Tempo (' . strtoupper(str_replace('_', ' ', $syarat_bayar)) . ') SO ' . $so->nomor_so,
					'created_at'          => date('Y-m-d H:i:s'),
				]);
			}

			set_message("Perubahan Transaksi Penjualan {$so->nomor_so} (Tempo) berhasil disimpan.", 'success');
			$this->data['success']  = true;
			$this->data['redirect'] = base_url('administrator/sales_order/view/' . $id);
		}
		$this->response($this->data);
	}

	public function update_status($id)
	{
		$this->is_allowed('sales_order_update');
		$status = $this->input->post('status') ?: $this->input->get('status');
		$so = $this->model_sales_order->find($id);

		if ($so && $status) {
			if (in_array($status, ['confirmed', 'packing']) && $so->status == 'draft') {
				$err = $this->model_sales_order->cek_stok($id);
				if (!empty($err)) {
					set_message(implode('<br>', $err), 'error');
					redirect('administrator/sales_order');
					return;
				}
			}

			$this->db->update('sales_order', [
				'status'     => $status,
				'updated_at' => date('Y-m-d H:i:s'),
				'updated_by' => get_user_data('username')
			], ['id' => $id]);

			// Auto sync Invoice status if shipped/delivered
			if (in_array($status, ['shipped', 'delivered'])) {
				$this->db->update('invoice', ['status_kirim' => $status], ['so_id' => $id]);
			}

			// Sync CRM follow-up labels for this order
			$this->load->model('crm/model_crm');
			$this->model_crm->generate_labels_for_order('sales_order', $id);

			$status_labels = [
				'draft'        => 'Draft (Pesanan Baru)',
				'confirmed'    => 'Terkonfirmasi (Stok Ready)',
				'packing'      => 'Sedang Dikemas (Packing)',
				'shipped'      => 'Dalam Pengiriman (Shipped)',
				'delivered'    => 'Pesanan Selesai (Delivered)',
				'cancelled'    => 'Dibatalkan'
			];

			$lbl = isset($status_labels[$status]) ? $status_labels[$status] : strtoupper($status);
			set_message('Status Transaksi Penjualan <strong>' . $so->nomor_so . '</strong> berhasil diperbarui ke: <strong>' . $lbl . '</strong>', 'success');
		}

		redirect('administrator/sales_order');
	}

	public function delete($id = null)
	{
		$this->is_allowed('sales_order_delete');
		$so = $this->model_sales_order->find($id);
		if ($so && $so->status == 'draft') {
			$this->db->delete('sales_order_item', ['so_id' => $id]);
			$this->model_sales_order->remove($id);
			set_message('Transaksi Penjualan berhasil dihapus.', 'success');
		} else {
			set_message('Hanya Transaksi Penjualan berstatus Draft yang bisa dihapus.', 'error');
		}
		redirect('administrator/sales_order');
	}

	public function export()
	{
		$this->is_allowed('sales_order_export');

		$q     = $this->input->get('q');
		$field = $this->input->get('f');

		// Ambil semua record SO sesuai filter tanpa pagination
		$sos = $this->model_sales_order->get($q, $field, 0, 0);

		$filename = 'Laporan_Transaksi_Penjualan_' . date('Y-m-d') . '.xls';

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
			'No. Transaksi Penjualan',
			'No. Pesanan',
			'Tanggal Transaksi Penjualan',
			'Pelanggan',
			'No. Telepon',
			'Tipe Pelanggan',
			'Saluran',
			'Subtotal (Rp)',
			'Diskon (Rp)',
			'Pajak (Rp)',
			'Total Nilai (Rp)',
			'Status Order',
			'Status Bayar'
		];

		echo "<table border=\"1\" cellpadding=\"4\" cellspacing=\"0\">\n<thead>\n<tr>\n";
		foreach ($headers as $h) {
			echo '<th>' . htmlspecialchars($h) . "</th>\n";
		}
		echo "</tr>\n</thead>\n<tbody>\n";

		$no = 1;
		foreach ($sos as $s) {
			$pelanggan = $s->nama_pelanggan ?: ($s->nama_penerima ?: 'Pelanggan Umum');
			if (!empty($s->username_pembeli)) {
				$pelanggan .= ' (' . $s->username_pembeli . ')';
			}

			$telp_val = !empty($s->no_telepon) && $s->no_telepon !== '-' 
				? (string)$s->no_telepon 
				: (!empty($s->telp_pelanggan) && $s->telp_pelanggan !== '-' 
					? (string)$s->telp_pelanggan 
					: (!empty($s->no_telepon_pengirim) && $s->no_telepon_pengirim !== '-' 
						? (string)$s->no_telepon_pengirim 
						: '-'));

			$source = 'Transaksi Offline';
			if ($s->source == 'pos' || strpos((string)$s->catatan, '[POS CEPAT') !== false) {
				$source = 'POS Kasir';
			} elseif ($s->source == 'excel_import' || (!empty($s->no_pesanan) && $s->source != 'manual')) {
				$source = 'Marketplace';
			}

			$is_paid = (!empty($s->waktu_pembayaran) || ($s->inv_status_db ?? '') == 'paid');
			$pay_status = $is_paid ? 'LUNAS' : 'TEMPO';
			$cls_row    = ($no % 2 === 0) ? ' class="zebra"' : '';

			echo "<tr{$cls_row}>\n";
			echo "<td class=\"center\">" . ($no++) . "</td>\n";
			echo "<td class=\"text center\">" . htmlspecialchars($s->nomor_so) . "</td>\n";
			echo "<td class=\"text center\">" . htmlspecialchars($s->no_pesanan ?: '-') . "</td>\n";
			echo "<td class=\"center text\">" . date('d/m/Y', strtotime($s->tanggal_so)) . "</td>\n";
			echo "<td>" . htmlspecialchars($pelanggan) . "</td>\n";
			echo "<td class=\"text center\">" . htmlspecialchars($telp_val) . "</td>\n";
			echo "<td class=\"center\">" . htmlspecialchars(strtoupper($s->tipe_pelanggan ?: '-')) . "</td>\n";
			echo "<td class=\"center\">" . htmlspecialchars($source) . "</td>\n";
			echo "<td class=\"currency\">" . (float)$s->subtotal . "</td>\n";
			echo "<td class=\"currency\">" . (float)($s->diskon_total ?: $s->diskon) . "</td>\n";
			echo "<td class=\"currency\">" . (float)$s->pajak_nominal . "</td>\n";
			echo "<td class=\"currency\">" . (float)$s->total . "</td>\n";
			echo "<td class=\"center\">" . htmlspecialchars(strtoupper($s->status)) . "</td>\n";
			echo "<td class=\"center\">" . htmlspecialchars($pay_status) . "</td>\n";
			echo "</tr>\n";
		}

		echo "</tbody>\n</table>\n</body>\n</html>";
		exit;
	}

	public function cetak($id)
	{
		$this->is_allowed('sales_order_view');
		$this->data['so'] = $this->model_sales_order->join_available()->find($id);
		if (!$this->data['so']) {
			show_404();
			return;
		}
		$this->data['items'] = $this->model_sales_order->get_items($id);
		
		@ini_set('memory_limit', '512M');
		@set_time_limit(180);

		$this->load->library('HtmlPdf');
		$this->htmlpdf->initialize(['orientation' => 'P', 'format' => 'A4', 'marges' => [5, 5, 5, 5]]);
		$content = $this->load->view('sales_order/backend/standart/administrator/sales_order/sales_order_pdf', $this->data, true);
		
		$this->htmlpdf->writeHTML($content);
		$so = $this->data['so'];
		$doc_num = preg_replace('/[^a-zA-Z0-9_-]/', '_', $so->nomor_so ?? $id);
		$filename = 'transaksi_penjualan_' . $doc_num . '.pdf';
		if (ob_get_length()) { ob_end_clean(); }
		
		$mode = ($this->input->get('download') == '1' || $this->input->get('mode') === 'download') ? 'D' : 'I';
		$this->htmlpdf->Output($filename, $mode);
		exit;
	}

	public function cetak_struk($id)
	{
		$this->is_allowed('sales_order_view');
		$so = $this->model_sales_order->join_available()->find($id);
		if (!$so) {
			show_404();
			return;
		}

		$items = $this->model_sales_order->get_items($id);
		$inv = $this->db->get_where('invoice', ['so_id' => $id])->row();
		$bkm = null;
		if ($inv) {
			$piutang = $this->db->get_where('piutang_usaha', ['invoice_id' => $inv->id])->row();
			if ($piutang) {
				$bkm = $this->db->where('piutang_id', $piutang->id)->order_by('id', 'DESC')->limit(1)->get('pembayaran_piutang')->row();
			}
		}

		$this->data['so']       = $so;
		$this->data['items']    = $items;
		$this->data['inv']      = $inv;
		$this->data['bkm']      = $bkm;
		$this->data['template'] = $this->input->get('template') ?: 'thermal';

		$this->load->view('sales_order/backend/standart/administrator/sales_order/sales_order_struk', $this->data);
	}

	public function cetak_nota_lebar($id)
	{
		$this->is_allowed('sales_order_view');
		$_GET['template'] = 'lebar';
		$this->cetak_struk($id);
	}

	public function get_produk()
	{
		$produks = $this->db->select('produk.id, produk.kode_produk, produk.nama_produk, produk.harga_jual, produk.harga_jual_grosir, produk.harga_jual_distributor, produk.harga_jual_vip, COALESCE(stok.qty, 0) as qty, satuan.singkatan as nama_satuan')
			->from('produk')
			->join('stok', 'stok.produk_id = produk.id', 'LEFT')
			->join('satuan', 'satuan.id = produk.satuan_id', 'LEFT')
			->where('produk.status', 'aktif')
			->order_by('produk.id', 'ASC')
			->get()->result();
			
		$this->response(['success' => true, 'data' => $produks]);
	}

	public function get_produk_by_gudang()
	{
		return $this->get_produk();
	}

	public function export_pdf()
	{
		$this->is_allowed('sales_order_export');

		@ini_set('memory_limit', '512M');
		@set_time_limit(180);

		$q     = $this->input->get('q');
		$field = $this->input->get('f');

		// Ambil seluruh data sales order realtime dari database sesuai filter aktif
		$sos = $this->model_sales_order->get($q, $field, 0, 0);

		$pelanggan_nama = '';
		$pelanggan_id = (int) $this->input->get('pelanggan_id');
		if ($pelanggan_id) {
			$p = $this->db->get_where('pelanggan', ['id' => $pelanggan_id])->row();
			if ($p) $pelanggan_nama = $p->nama_pelanggan;
		}

		$total_omset = 0;
		$total_lunas = 0;
		$total_tempo = 0;
		foreach ($sos as $s) {
			$total_omset += (float)$s->total;
			$is_paid = (!empty($s->waktu_pembayaran) || ($s->inv_status_db ?? '') == 'paid');
			if ($is_paid) {
				$total_lunas += (float)$s->total;
			} else {
				$total_tempo += (float)$s->total;
			}
		}

		$this->load->library('HtmlPdf');

		$config = [
			'orientation' => 'l',
			'format'      => 'a4',
			'marges'      => [8, 8, 8, 8]
		];

		$this->htmlpdf->initialize($config);

		$content = $this->load->view('sales_order/backend/standart/administrator/sales_order/sales_order_rekap_pdf', [
			'results'        => $sos,
			'status_sel'     => $this->input->get('status'),
			'source_sel'     => $this->input->get('source'),
			'pelanggan_nama' => $pelanggan_nama,
			'search_q'       => $q,
			'summary'        => [
				'total_omset' => $total_omset,
				'total_lunas' => $total_lunas,
				'total_tempo' => $total_tempo,
			]
		], true);

		$this->htmlpdf->writeHTML($content);

		if (ob_get_length()) { ob_end_clean(); }

		$this->htmlpdf->Output('Laporan_Rekap_Transaksi_Penjualan_' . date('Y-m-d') . '.pdf', 'I');
		exit;
	}


	public function download_template_shopee()
	{
		$headers = [
			"No. Pesanan",
			"Status Pesanan",
			"Alasan Pembatalan (tambahan kolom)",
			"Status Pembatalan/ Pengembalian",
			"No. Resi",
			"Opsi Pengiriman",
			"Antar ke counter/ pick-up",
			"Pesanan Harus Dikirimkan Sebelum (Menghindari keterlambatan)",
			"Waktu Pengiriman Diatur",
			"Waktu Pesanan Dibuat",
			"Waktu Pembayaran Dilakukan",
			"SKU Induk",
			"Nama Produk",
			"Nomor Referensi SKU",
			"Nama Variasi",
			"Harga Awal",
			"Harga Setelah Diskon",
			"Jumlah",
			"Total Harga Produk",
			"Total Diskon",
			"Diskon Dari Penjual",
			"Diskon Dari Shopee",
			"Berat Produk",
			"Jumlah Produk di Pesan",
			"Total Berat",
			"Voucher Ditanggung Penjual",
			"Cashback Koin",
			"Voucher Ditanggung Shopee",
			"Paket Diskon",
			"Paket Diskon (Diskon dari Shopee)",
			"Paket Diskon (Diskon dari Penjual)",
			"Potongan Koin Shopee",
			"Diskon Kartu Kredit",
			"Ongkos Kirim Dibayar oleh Pembeli",
			"Total Pembayaran",
			"Perkiraan Ongkos Kirim",
			"Catatan dari Pembeli",
			"Catatan",
			"Username (Pembeli)",
			"Nama Penerima",
			"No. Telepon",
			"Alamat Pengiriman",
			"Kota/Kabupaten",
			"Provinsi",
			"Waktu Pesanan Selesai"
		];

		if (ob_get_length()) {
			ob_end_clean();
		}

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=template_shoppe_18_08_2026.csv');
		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fputcsv($output, $headers);
		fclose($output);
		exit;
	}

	public function download_template_tokopedia()
	{
		$headers = [
			"No. Pesanan", "Status Pesanan", "No. Resi", "Kurir",
			"Waktu Pembayaran", "SKU Induk", "Nama Produk", "Nama Variasi",
			"Harga Satuan", "Jumlah", "Total Harga Produk", "Total Pembayaran",
			"Catatan Pembeli", "Username Pembeli", "Nama Penerima", "No. Telepon",
			"Alamat Pengiriman", "Kota/Kabupaten", "Provinsi"
		];

		if (ob_get_length()) {
			ob_end_clean();
		}

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=template_import_tokopedia_sales.csv');
		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fputcsv($output, $headers);
		fclose($output);
		exit;
	}

	public function download_template_tiktok()
	{
		$headers = [
			"Order ID", "Order Status", "Order Substatus", "Cancelation/Return Type", "Normal or Pre-order",
			"SKU ID", "Seller SKU", "Product Name", "Variation", "Quantity",
			"Sku Quantity of return", "SKU Unit Original Price", "SKU Subtotal Before Discount", "SKU Platform Discount", "SKU Seller Discount",
			"SKU Subtotal After Discount", "Shipping Fee After Discount", "Original Shipping Fee", "Shipping Fee Seller Discount", "Shipping Fee Platform Discount",
			"Taxes", "Order Amount", "Order Refund Amount", "Created Time", "Paid Time",
			"RTS Time", "Shipped Time", "Delivered Time", "Cancelled Time", "Cancel By",
			"Cancel Reason", "Fulfillment Type", "Warehouse Name", "Tracking ID", "Delivery Option",
			"Shipping Provider Name", "Buyer Message", "Buyer Username", "Recipient", "Phone #",
			"Zipcode", "Country", "Province", "Regency and City", "Districts",
			"Villages", "Detail Address", "Additional address information", "Payment Method", "Weight(kg)",
			"Product Category", "Package ID", "Seller Note", "Checked Status", "Checked Marked by"
		];

		if (ob_get_length()) {
			ob_end_clean();
		}

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=template-tiktokshop-' . date('d-m-Y') . '.csv');
		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
		fputcsv($output, $headers);
		fclose($output);
		exit;
	}

	private function _read_import_rows($file_path, $file_name)
	{
		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		$rows = [];
		if ($ext === 'csv') {
			$handle = fopen($file_path, 'r');
			if ($handle !== false) {
				$bom = fread($handle, 3);
				if ($bom !== "\xEF\xBB\xBF") rewind($handle);
				$first_line = fgets($handle);
				if ($bom !== "\xEF\xBB\xBF") rewind($handle); else fseek($handle, 3);
				$delimiter = (strpos($first_line, ';') !== false) ? ';' : ((strpos($first_line, "\t") !== false) ? "\t" : ',');
				$r_idx = 1;
				while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
					if (empty($data) || (count($data) === 1 && trim((string)$data[0]) === '')) continue;
					$row_dict = [];
					$col_letter = 'A';
					foreach ($data as $cell) {
						$row_dict[$col_letter] = trim((string)$cell);
						$col_letter++;
					}
					$rows[$r_idx] = $row_dict;
					$r_idx++;
				}
				fclose($handle);
			}
		} else {
			require_once FCPATH . 'application/libraries/Excel/PHPExcel/IOFactory.php';
			$objPHPExcel = PHPExcel_IOFactory::load($file_path);
			$sheet = $objPHPExcel->getActiveSheet();
			$rows = $sheet->toArray(null, true, true, true);
		}
		return $rows;
	}

	public function import_shopee()
	{
		$this->is_allowed('sales_order_add');
		@ini_set('memory_limit', '1024M');
		@set_time_limit(0);

		if (empty($_FILES['file_csv']['name'])) {
			set_message('Silakan pilih file CSV/Excel Shopee yang akan diimport.', 'error');
			redirect('administrator/sales_order');
			return;
		}

		$file_path = $_FILES['file_csv']['tmp_name'];
		$file_name = $_FILES['file_csv']['name'];

		try {
			$rows = $this->_read_import_rows($file_path, $file_name);
		} catch (Exception $e) {
			set_message('Gagal membaca file CSV/Excel Shopee: ' . $e->getMessage(), 'error');
			redirect('administrator/sales_order');
			return;
		}

		if (empty($rows) || count($rows) < 2) {
			set_message('File CSV/Excel kosong atau format tidak sesuai.', 'error');
			redirect('administrator/sales_order');
			return;
		}

		// Row 1 is header
		$header_row = $rows[1];
		$header_map = [];
		foreach ($header_row as $colLetter => $hText) {
			if ($hText !== null && $hText !== '') {
				$clean_h = trim(preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $hText));
				$header_map[$colLetter] = $clean_h;
			}
		}

		$get_val = function($data_row, $keys) use ($header_map) {
			foreach ($keys as $k) {
				$k_norm = strtolower(preg_replace('/[^a-z0-9]/', '', $k));
				foreach ($header_map as $colLetter => $hName) {
					if (strtolower(preg_replace('/[^a-z0-9]/', '', $hName)) === $k_norm) {
						$val = isset($data_row[$colLetter]) ? trim((string)$data_row[$colLetter]) : '';
						if ($val !== '') return $val;
					}
				}
			}
			return '';
		};

		$default_pelanggan = $this->db->get_where('pelanggan', ['kode_pelanggan' => 'CUS-MARKETPLACE'])->row() 
			?: $this->db->get('pelanggan')->row();
		$pelanggan_id = $default_pelanggan ? $default_pelanggan->id : 1;

		// Pre-fetch all customers into array for O(1) matching by phone or name
		$all_pelanggan = $this->db->select('id, kode_pelanggan, nama_pelanggan, telepon, no_telp')->get('pelanggan')->result();
		$cust_by_phone = [];
		$cust_by_name = [];
		foreach ($all_pelanggan as $cp) {
			$p1 = preg_replace('/[^0-9]/', '', (string)$cp->telepon);
			$p2 = preg_replace('/[^0-9]/', '', (string)$cp->no_telp);
			if (!empty($p1)) $cust_by_phone[$p1] = (int)$cp->id;
			if (!empty($p2)) $cust_by_phone[$p2] = (int)$cp->id;
			if (!empty($cp->nama_pelanggan)) {
				$cust_by_name[strtolower(trim($cp->nama_pelanggan))] = (int)$cp->id;
			}
		}
		$max_cust_row = $this->db->select_max('id')->get('pelanggan')->row();
		$next_cust_num = ($max_cust_row && $max_cust_row->id) ? ((int)$max_cust_row->id + 1) : 1;

		// Pre-fetch all existing order IDs for O(1) duplicate lookup
		$existing_orders = [];
		$res_existing = $this->db->select('no_pesanan')->get('sales_order')->result();
		foreach ($res_existing as $e_row) {
			if (!empty($e_row->no_pesanan)) {
				$existing_orders[$e_row->no_pesanan] = true;
			}
		}

		// Pre-fetch all products into memory
		$all_products = $this->db->get('produk')->result();
		$default_prod = !empty($all_products) ? $all_products[0] : null;
		$prod_by_code = [];
		$prod_by_name = [];
		foreach ($all_products as $pr) {
			if (!empty($pr->kode_produk)) {
				$prod_by_code[strtolower(trim($pr->kode_produk))] = $pr;
			}
			if (!empty($pr->nama_produk)) {
				$prod_by_name[strtolower(trim($pr->nama_produk))] = $pr;
			}
		}

		// Pre-fetch CRM categories
		$crm_categories = $this->db->get_where('crm_followup_categories', ['is_active' => 1])->result();
		$bulk_crm_labels = [];

		$success_count = 0;
		$skipped_count = 0;
		$now_dt = date('Y-m-d H:i:s');

		$this->db->trans_start();

		for ($r = 2; $r <= count($rows); $r++) {
			$data_row = $rows[$r];
			if (empty(array_filter($data_row))) continue;

			$no_pesanan = $get_val($data_row, ['No. Pesanan', 'No Pesanan', 'Nomor Pesanan']);
			if (empty($no_pesanan)) continue;

			if (isset($existing_orders[$no_pesanan])) {
				$skipped_count++;
				continue;
			}
			$existing_orders[$no_pesanan] = true;

			$status_pesanan = $get_val($data_row, ['Status Pesanan']);
			$raw_status = strtolower($status_pesanan);
			$status = 'draft';
			if (strpos($raw_status, 'selesai') !== false || strpos($raw_status, 'completed') !== false) {
				$status = 'delivered';
			} elseif (strpos($raw_status, 'batal') !== false || strpos($raw_status, 'cancelled') !== false) {
				$status = 'cancelled';
			} elseif (strpos($raw_status, 'perlu dikirim') !== false || strpos($raw_status, 'dikirim') !== false) {
				$status = 'shipped';
			}

			$tot_bayar_raw = $get_val($data_row, ['Total Pembayaran', 'Total Harga Produk']);
			$total_bayar = (float) str_replace(['.', ',', 'Rp', ' '], '', $tot_bayar_raw);
			$nomor_so = $this->model_sales_order->generate_nomor();

			$waktu_bayar_raw = $get_val($data_row, ['Waktu Pembayaran Dilakukan', 'Waktu Pembayaran', 'Waktu Pesanan Dibuat']);
			$waktu_bayar = !empty($waktu_bayar_raw) ? date('Y-m-d H:i:s', strtotime($waktu_bayar_raw)) : date('Y-m-d H:i:s');
			$tanggal_so = !empty($waktu_bayar_raw) ? date('Y-m-d', strtotime($waktu_bayar_raw)) : date('Y-m-d');

			$username_buyer = $get_val($data_row, ['Username (Pembeli)', 'Username Pembeli', 'Username']);
			$nama_penerima  = $get_val($data_row, ['Nama Penerima']);
			$no_telp       = $get_val($data_row, ['No. Telepon', 'No Telepon', 'Notelp']);
			$phone_clean   = preg_replace('/[^0-9]/', '', (string)$no_telp);
			$alamat        = $get_val($data_row, ['Alamat Pengiriman']);
			$kota          = $get_val($data_row, ['Kota/Kabupaten', 'Kota']);
			$provinsi      = $get_val($data_row, ['Provinsi']);
			$sku_induk     = $get_val($data_row, ['SKU Induk']);
			$nama_produk   = $get_val($data_row, ['Nama Produk']);
			$sku_ref       = $get_val($data_row, ['Nomor Referensi SKU']);
			$variasi       = $get_val($data_row, ['Nama Variasi']);
			$no_resi       = $get_val($data_row, ['No. Resi', 'No Resi']);
			$opsi_kirim    = $get_val($data_row, ['Opsi Pengiriman']);
			$alasan_batal  = $get_val($data_row, ['Alasan Pembatalan (tambahan kolom)', 'Alasan Pembatalan']);
			$st_batal      = $get_val($data_row, ['Status Pembatalan/ Pengembalian', 'Status Pembatalan/Pengembalian']);

			// Dynamic customer synchronization into 'pelanggan'
			$row_pelanggan_id = null;
			if (!empty($phone_clean) && isset($cust_by_phone[$phone_clean])) {
				$row_pelanggan_id = $cust_by_phone[$phone_clean];
			} elseif (!empty($nama_penerima) && isset($cust_by_name[strtolower(trim($nama_penerima))])) {
				$row_pelanggan_id = $cust_by_name[strtolower(trim($nama_penerima))];
			} elseif (!empty($username_buyer) && isset($cust_by_name[strtolower(trim($username_buyer))])) {
				$row_pelanggan_id = $cust_by_name[strtolower(trim($username_buyer))];
			} else {
				$c_kode = 'CUST-' . str_pad($next_cust_num++, 4, '0', STR_PAD_LEFT);
				while ($this->db->where('kode_pelanggan', $c_kode)->get('pelanggan')->num_rows() > 0) {
					$c_kode = 'CUST-' . str_pad($next_cust_num++, 4, '0', STR_PAD_LEFT);
				}
				$cust_name = !empty($nama_penerima) ? $nama_penerima : (!empty($username_buyer) ? $username_buyer : 'Customer Shopee');
				$new_cust = [
					'kode_pelanggan' => $c_kode,
					'nama_pelanggan' => $cust_name,
					'telepon'        => $phone_clean,
					'no_telp'        => $phone_clean,
					'alamat'         => !empty($alamat) ? $alamat : 'Imported via Shopee',
					'kota'           => !empty($kota) ? $kota : '',
					'tipe_pelanggan' => 'Marketplace',
					'tier_pelanggan' => 'RETAIL',
					'status'         => 'aktif',
					'created_by'     => get_user_data('username') ?: 'admin',
					'created_at'     => $now_dt,
				];
				$this->db->insert('pelanggan', $new_cust);
				$row_pelanggan_id = $this->db->insert_id();
				if (!empty($phone_clean)) $cust_by_phone[$phone_clean] = $row_pelanggan_id;
				$cust_by_name[strtolower(trim($cust_name))] = $row_pelanggan_id;
			}
			if (empty($row_pelanggan_id)) {
				$row_pelanggan_id = $pelanggan_id;
			}

			$so_data = [
				'nomor_so'                    => $nomor_so,
				'no_pesanan'                  => $no_pesanan,
				'source'                      => 'shopee',
				'pelanggan_id'                => $row_pelanggan_id,
				'tanggal_so'                  => $tanggal_so,
				'status'                      => $status,
				'status_pesanan'              => $status_pesanan,
				'alasan_pembatalan'           => $alasan_batal,
				'status_pembatalan_pengembalian' => $st_batal,
				'nomor_resi'                  => $no_resi,
				'kurir_ekspedisi'             => $opsi_kirim,
				'opsi_pengiriman'             => $opsi_kirim,
				'waktu_pembayaran'            => $waktu_bayar,
				'username_pembeli'            => $username_buyer,
				'nama_penerima'               => $nama_penerima,
				'no_telepon'                  => $no_telp,
				'alamat_pengiriman'           => $alamat,
				'kota_kabupaten'              => $kota,
				'provinsi'                    => $provinsi,
				'sku_induk'                   => $sku_induk,
				'nama_produk_marketplace'     => $nama_produk,
				'nomor_referensi_sku'         => $sku_ref,
				'nama_variasi'                => $variasi,
				'subtotal'                    => $total_bayar,
				'total'                       => $total_bayar,
				'catatan'                     => 'Import Shopee Excel - Buyer: ' . $username_buyer,
				'created_by'                  => get_user_data('username') ?: 'admin',
				'created_at'                  => $now_dt,
			];

			$so_id = $this->model_sales_order->store($so_data);

			if ($so_id) {
				$sku = trim($sku_ref ?: $sku_induk);
				$prod = null;
				if ($sku && isset($prod_by_code[strtolower($sku)])) {
					$prod = $prod_by_code[strtolower($sku)];
				}
				if (!$prod && $nama_produk && isset($prod_by_name[strtolower($nama_produk)])) {
					$prod = $prod_by_name[strtolower($nama_produk)];
				}
				if (!$prod && $nama_produk) {
					$np_lower = strtolower($nama_produk);
					foreach ($prod_by_name as $pn => $pobj) {
						if (strpos($np_lower, $pn) !== false || strpos($pn, $np_lower) !== false) {
							$prod = $pobj;
							break;
						}
					}
				}
				if (!$prod) {
					$prod = $default_prod;
				}

				$qty_raw = $get_val($data_row, ['Jumlah', 'Jumlah Produk di Pesan']);
				$qty = (float) str_replace(['.', ','], '', $qty_raw ?: 1);

				$harga_raw = $get_val($data_row, ['Harga Setelah Diskon', 'Harga Awal']);
				$harga = (float) str_replace(['.', ',', 'Rp', ' '], '', $harga_raw);
				if ($harga <= 0 && $qty > 0) {
					$harga = $total_bayar / $qty;
				}

				$this->db->insert('sales_order_item', [
					'so_id'         => $so_id,
					'produk_id'     => $prod ? $prod->id : 1,
					'qty'           => max(1, $qty),
					'satuan'        => 'pcs',
					'harga_satuan'  => $harga,
					'diskon_persen' => 0,
					'diskon_nominal'=> 0,
					'subtotal'      => $harga * $qty,
					'catatan'       => $nama_produk,
				]);

				// Generate CRM follow-up labels in batch
				if (!empty($crm_categories)) {
					$ship_date = !empty($tanggal_so) ? $tanggal_so : date('Y-m-d');
					foreach ($crm_categories as $cat) {
						$target_lbl = date('Y-m-d', strtotime($ship_date . ' + ' . $cat->jumlah_hari . ' days'));
						$bulk_crm_labels[] = [
							'order_source'          => 'Shopee',
							'order_id'              => $so_id,
							'order_table'           => 'sales_order',
							'customer_nama'         => !empty($nama_penerima) ? $nama_penerima : (!empty($username_buyer) ? $username_buyer : 'Customer Shopee'),
							'customer_phone'        => $phone_clean,
							'customer_pelanggan_id' => $row_pelanggan_id,
							'no_pesanan'            => $no_pesanan,
							'nomor_resi'            => !empty($no_resi) ? $no_resi : '',
							'tanggal_pengiriman'    => $ship_date,
							'followup_category_id'  => $cat->id,
							'tanggal_label_muncul'  => $target_lbl,
							'created_at'            => $now_dt,
						];
					}

					if (count($bulk_crm_labels) >= 500) {
						$this->db->insert_batch('crm_transaction_followup_labels', $bulk_crm_labels);
						$bulk_crm_labels = [];
					}
				}

				$success_count++;
			}
		}

		if (!empty($bulk_crm_labels)) {
			$this->db->insert_batch('crm_transaction_followup_labels', $bulk_crm_labels);
		}

		$this->db->trans_complete();

		if ($success_count == 0 && $skipped_count > 0) {
			set_message("Gagal Import! Data pesanan sudah ada di sistem dan tidak bisa dimasukkan lagi ({$skipped_count} pesanan duplikat ditolak).", 'error');
		} elseif ($success_count > 0 && $skipped_count > 0) {
			set_message("Berhasil mengimport {$success_count} pesanan baru. Peringatan: {$skipped_count} pesanan dilewati karena sudah ada di database (Duplikat).", 'warning');
		} elseif ($success_count > 0) {
			set_message("Berhasil mengimport {$success_count} pesanan Shopee baru.", 'success');
		} else {
			set_message("Tidak ada data pesanan baru yang diimport.", 'warning');
		}
		redirect('administrator/sales_order');
	}

	public function import_tokopedia()
	{
		$this->is_allowed('sales_order_add');
		@ini_set('memory_limit', '1024M');
		@set_time_limit(0);

		if (empty($_FILES['file_csv']['name'])) {
			set_message('Silakan pilih file CSV/Excel Tokopedia yang akan diimport.', 'error');
			redirect('administrator/sales_order');
			return;
		}

		$file_path = $_FILES['file_csv']['tmp_name'];
		$file_name = $_FILES['file_csv']['name'];

		try {
			$rows = $this->_read_import_rows($file_path, $file_name);
		} catch (Exception $e) {
			set_message('Gagal membaca file CSV/Excel Tokopedia: ' . $e->getMessage(), 'error');
			redirect('administrator/sales_order');
			return;
		}

		if (empty($rows) || count($rows) < 2) {
			set_message('File CSV/Excel kosong atau format tidak sesuai.', 'error');
			redirect('administrator/sales_order');
			return;
		}

		$header_row = $rows[1];
		$header_map = [];
		foreach ($header_row as $colLetter => $hText) {
			if ($hText !== null && $hText !== '') {
				$clean_h = trim(preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $hText));
				$header_map[$colLetter] = $clean_h;
			}
		}

		$get_val = function($data_row, $keys) use ($header_map) {
			foreach ($keys as $k) {
				$k_norm = strtolower(preg_replace('/[^a-z0-9]/', '', $k));
				foreach ($header_map as $colLetter => $hName) {
					if (strtolower(preg_replace('/[^a-z0-9]/', '', $hName)) === $k_norm) {
						$val = isset($data_row[$colLetter]) ? trim((string)$data_row[$colLetter]) : '';
						if ($val !== '') return $val;
					}
				}
			}
			return '';
		};

		$default_pelanggan = $this->db->get_where('pelanggan', ['kode_pelanggan' => 'CUS-MARKETPLACE'])->row() 
			?: $this->db->get('pelanggan')->row();
		$pelanggan_id = $default_pelanggan ? $default_pelanggan->id : 1;

		// Pre-fetch all customers into array for O(1) matching by phone or name
		$all_pelanggan = $this->db->select('id, kode_pelanggan, nama_pelanggan, telepon, no_telp')->get('pelanggan')->result();
		$cust_by_phone = [];
		$cust_by_name = [];
		foreach ($all_pelanggan as $cp) {
			$p1 = preg_replace('/[^0-9]/', '', (string)$cp->telepon);
			$p2 = preg_replace('/[^0-9]/', '', (string)$cp->no_telp);
			if (!empty($p1)) $cust_by_phone[$p1] = (int)$cp->id;
			if (!empty($p2)) $cust_by_phone[$p2] = (int)$cp->id;
			if (!empty($cp->nama_pelanggan)) {
				$cust_by_name[strtolower(trim($cp->nama_pelanggan))] = (int)$cp->id;
			}
		}
		$max_cust_row = $this->db->select_max('id')->get('pelanggan')->row();
		$next_cust_num = ($max_cust_row && $max_cust_row->id) ? ((int)$max_cust_row->id + 1) : 1;

		// Pre-fetch all existing order IDs for O(1) duplicate lookup
		$existing_orders = [];
		$res_existing = $this->db->select('no_pesanan')->get('sales_order')->result();
		foreach ($res_existing as $e_row) {
			if (!empty($e_row->no_pesanan)) {
				$existing_orders[$e_row->no_pesanan] = true;
			}
		}

		// Pre-fetch all products into memory
		$all_products = $this->db->get('produk')->result();
		$default_prod = !empty($all_products) ? $all_products[0] : null;
		$prod_by_code = [];
		$prod_by_name = [];
		foreach ($all_products as $pr) {
			if (!empty($pr->kode_produk)) {
				$prod_by_code[strtolower(trim($pr->kode_produk))] = $pr;
			}
			if (!empty($pr->nama_produk)) {
				$prod_by_name[strtolower(trim($pr->nama_produk))] = $pr;
			}
		}

		// Pre-fetch CRM categories
		$crm_categories = $this->db->get_where('crm_followup_categories', ['is_active' => 1])->result();
		$bulk_crm_labels = [];

		$success_count = 0;
		$skipped_count = 0;
		$now_dt = date('Y-m-d H:i:s');

		$this->db->trans_start();

		for ($r = 2; $r <= count($rows); $r++) {
			$data_row = $rows[$r];
			if (empty(array_filter($data_row))) continue;

			$no_pesanan = $get_val($data_row, ['No. Pesanan', 'No Pesanan', 'Nomor Pesanan']);
			if (empty($no_pesanan)) continue;

			if (isset($existing_orders[$no_pesanan])) {
				$skipped_count++;
				continue;
			}
			$existing_orders[$no_pesanan] = true;

			$status_pesanan = $get_val($data_row, ['Status Pesanan']);
			$raw_status = strtolower($status_pesanan);
			$status = 'draft';
			if (strpos($raw_status, 'selesai') !== false) {
				$status = 'delivered';
			} elseif (strpos($raw_status, 'batal') !== false) {
				$status = 'cancelled';
			} elseif (strpos($raw_status, 'dikirim') !== false) {
				$status = 'shipped';
			}

			$tot_bayar_raw = $get_val($data_row, ['Total Pembayaran', 'Total Harga Produk']);
			$total_bayar = (float) str_replace(['.', ',', 'Rp', ' '], '', $tot_bayar_raw);
			$nomor_so = $this->model_sales_order->generate_nomor();

			$waktu_bayar_raw = $get_val($data_row, ['Waktu Pembayaran']);
			$waktu_bayar = !empty($waktu_bayar_raw) ? date('Y-m-d H:i:s', strtotime($waktu_bayar_raw)) : date('Y-m-d H:i:s');
			$tanggal_so = !empty($waktu_bayar_raw) ? date('Y-m-d', strtotime($waktu_bayar_raw)) : date('Y-m-d');

			$username_buyer = $get_val($data_row, ['Username Pembeli', 'Username']);
			$nama_penerima  = $get_val($data_row, ['Nama Penerima']);
			$no_telp       = $get_val($data_row, ['No. Telepon', 'No Telepon']);
			$phone_clean   = preg_replace('/[^0-9]/', '', (string)$no_telp);
			$alamat        = $get_val($data_row, ['Alamat Pengiriman']);
			$kota          = $get_val($data_row, ['Kota/Kabupaten', 'Kota']);
			$provinsi      = $get_val($data_row, ['Provinsi']);

			// Dynamic customer synchronization into 'pelanggan'
			$row_pelanggan_id = null;
			if (!empty($phone_clean) && isset($cust_by_phone[$phone_clean])) {
				$row_pelanggan_id = $cust_by_phone[$phone_clean];
			} elseif (!empty($nama_penerima) && isset($cust_by_name[strtolower(trim($nama_penerima))])) {
				$row_pelanggan_id = $cust_by_name[strtolower(trim($nama_penerima))];
			} elseif (!empty($username_buyer) && isset($cust_by_name[strtolower(trim($username_buyer))])) {
				$row_pelanggan_id = $cust_by_name[strtolower(trim($username_buyer))];
			} else {
				$c_kode = 'CUST-' . str_pad($next_cust_num++, 4, '0', STR_PAD_LEFT);
				while ($this->db->where('kode_pelanggan', $c_kode)->get('pelanggan')->num_rows() > 0) {
					$c_kode = 'CUST-' . str_pad($next_cust_num++, 4, '0', STR_PAD_LEFT);
				}
				$cust_name = !empty($nama_penerima) ? $nama_penerima : (!empty($username_buyer) ? $username_buyer : 'Customer Tokopedia');
				$new_cust = [
					'kode_pelanggan' => $c_kode,
					'nama_pelanggan' => $cust_name,
					'telepon'        => $phone_clean,
					'no_telp'        => $phone_clean,
					'alamat'         => !empty($alamat) ? $alamat : 'Imported via Tokopedia',
					'kota'           => !empty($kota) ? $kota : '',
					'tipe_pelanggan' => 'Marketplace',
					'tier_pelanggan' => 'RETAIL',
					'status'         => 'aktif',
					'created_by'     => get_user_data('username') ?: 'admin',
					'created_at'     => $now_dt,
				];
				$this->db->insert('pelanggan', $new_cust);
				$row_pelanggan_id = $this->db->insert_id();
				if (!empty($phone_clean)) $cust_by_phone[$phone_clean] = $row_pelanggan_id;
				$cust_by_name[strtolower(trim($cust_name))] = $row_pelanggan_id;
			}
			if (empty($row_pelanggan_id)) {
				$row_pelanggan_id = $pelanggan_id;
			}

			$so_data = [
				'nomor_so'            => $nomor_so,
				'no_pesanan'          => $no_pesanan,
				'source'              => 'tokopedia',
				'pelanggan_id'        => $row_pelanggan_id,
				'tanggal_so'          => $tanggal_so,
				'status'              => $status,
				'status_pesanan'      => $status_pesanan,
				'nomor_resi'          => $get_val($data_row, ['No. Resi', 'No Resi']),
				'kurir_ekspedisi'     => $get_val($data_row, ['Kurir']),
				'waktu_pembayaran'    => $waktu_bayar,
				'username_pembeli'    => $username_buyer,
				'nama_penerima'       => $nama_penerima,
				'no_telepon'          => $no_telp,
				'alamat_pengiriman'   => $alamat,
				'kota_kabupaten'      => $kota,
				'provinsi'            => $provinsi,
				'sku_induk'           => $get_val($data_row, ['SKU Induk']),
				'nama_produk_marketplace' => $get_val($data_row, ['Nama Produk']),
				'nama_variasi'        => $get_val($data_row, ['Nama Variasi']),
				'subtotal'            => $total_bayar,
				'total'               => $total_bayar,
				'catatan'             => 'Import Tokopedia Excel - Buyer: ' . $username_buyer,
				'created_by'          => get_user_data('username') ?: 'admin',
				'created_at'          => $now_dt,
			];

			$so_id = $this->model_sales_order->store($so_data);

			if ($so_id) {
				$sku = trim($get_val($data_row, ['SKU Induk']));
				$nama_prod = trim($get_val($data_row, ['Nama Produk']));
				$prod = null;
				if ($sku && isset($prod_by_code[strtolower($sku)])) {
					$prod = $prod_by_code[strtolower($sku)];
				}
				if (!$prod && $nama_prod && isset($prod_by_name[strtolower($nama_prod)])) {
					$prod = $prod_by_name[strtolower($nama_prod)];
				}
				if (!$prod && $nama_prod) {
					$np_lower = strtolower($nama_prod);
					foreach ($prod_by_name as $pn => $pobj) {
						if (strpos($np_lower, $pn) !== false || strpos($pn, $np_lower) !== false) {
							$prod = $pobj;
							break;
						}
					}
				}
				if (!$prod) {
					$prod = $default_prod;
				}

				$qty = (float) str_replace(['.', ','], '', $get_val($data_row, ['Jumlah']) ?: 1);
				$harga = (float) str_replace(['.', ',', 'Rp', ' '], '', $get_val($data_row, ['Harga Satuan']) ?: 0);
				if ($harga <= 0 && $qty > 0) {
					$harga = $total_bayar / $qty;
				}

				$this->db->insert('sales_order_item', [
					'so_id'         => $so_id,
					'produk_id'     => $prod ? $prod->id : 1,
					'qty'           => max(1, $qty),
					'satuan'        => 'pcs',
					'harga_satuan'  => $harga,
					'diskon_persen' => 0,
					'diskon_nominal'=> 0,
					'subtotal'      => $harga * $qty,
					'catatan'       => $nama_prod,
				]);

				// Generate CRM follow-up labels in batch
				if (!empty($crm_categories)) {
					$ship_date = !empty($tanggal_so) ? $tanggal_so : date('Y-m-d');
					foreach ($crm_categories as $cat) {
						$target_lbl = date('Y-m-d', strtotime($ship_date . ' + ' . $cat->jumlah_hari . ' days'));
						$bulk_crm_labels[] = [
							'order_source'          => 'Tokopedia',
							'order_id'              => $so_id,
							'order_table'           => 'sales_order',
							'customer_nama'         => !empty($nama_penerima) ? $nama_penerima : (!empty($username_buyer) ? $username_buyer : 'Customer Tokopedia'),
							'customer_phone'        => $phone_clean,
							'customer_pelanggan_id' => $row_pelanggan_id,
							'no_pesanan'            => $no_pesanan,
							'nomor_resi'            => $get_val($data_row, ['No. Resi', 'No Resi']),
							'tanggal_pengiriman'    => $ship_date,
							'followup_category_id'  => $cat->id,
							'tanggal_label_muncul'  => $target_lbl,
							'created_at'            => $now_dt,
						];
					}

					if (count($bulk_crm_labels) >= 500) {
						$this->db->insert_batch('crm_transaction_followup_labels', $bulk_crm_labels);
						$bulk_crm_labels = [];
					}
				}

				$success_count++;
			}
		}

		if (!empty($bulk_crm_labels)) {
			$this->db->insert_batch('crm_transaction_followup_labels', $bulk_crm_labels);
		}

		$this->db->trans_complete();

		if ($success_count == 0 && $skipped_count > 0) {
			set_message("Gagal Import! Data pesanan sudah ada di sistem dan tidak bisa dimasukkan lagi ({$skipped_count} pesanan duplikat ditolak).", 'error');
		} elseif ($success_count > 0 && $skipped_count > 0) {
			set_message("Berhasil mengimport {$success_count} pesanan baru. Peringatan: {$skipped_count} pesanan dilewati karena sudah ada di database (Duplikat).", 'warning');
		} elseif ($success_count > 0) {
			set_message("Berhasil mengimport {$success_count} pesanan Tokopedia baru.", 'success');
		} else {
			set_message("Tidak ada data pesanan baru yang diimport.", 'warning');
		}
		redirect('administrator/sales_order');
	}
}

// Helper function for CSV line parsing if not existing
if (!function_exists('fputcsv_get_row')) {
	function fputcsv_get_row($handle) {
		return fgetcsv($handle, 4000, ",");
	}
}

