<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Model extends CI_Model {

    private $primary_key = 'id';
    private $table_name = 'table';
    private $field_search;

    public function __construct($config = array())
    {
        parent::__construct();

        foreach ($config as $key => $val)
        {
            if(isset($this->$key))
                $this->$key = $val;
        }

        $this->load->database();
    }

    public function remove($id = NULL)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table_name);
    }

    public function change($id = NULL, $data = array())
    {        
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table_name, $data);
    }

    public function find($id = NULL, $select_field = [])
    {
        if (is_array($select_field) AND count($select_field)) {
            $this->db->select($select_field);
        }

        $this->db->where("".$this->table_name.'.'.$this->primary_key,$id);
        $query = $this->db->get($this->table_name);

        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return FALSE;
        }
    }

    public function find_all()
    {
        $this->db->order_by($this->primary_key, 'DESC');
        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function store($data = array())
    {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function get_all_data($table = '')
    {
        $query = $this->db->get($table);

        return $query->result();
    }


    public function get_single($where)
    {
        $query = $this->db->get_where($this->table_name, $where);

        return $query->row();
    }

    public function scurity($input)
    {
        if (is_array($input)) {
            return array_map(array($this, 'scurity'), $input);
        }
        if ($this->db->conn_id instanceof mysqli) {
            return mysqli_real_escape_string($this->db->conn_id, (string)$input);
        }
        return $this->db->escape_str($input);
    }

    public function generate_url($field, $text = null, $except = null)
    {
        $url = url_title($text);
        if ($except) {
            $this->db->where($this->primary_key." != ".$except);
        }
        $this->db->order_by($this->primary_key, 'DESC');
        $data = $this->db->get_where($this->table_name, [$field => $url])->row();

        if ($data) {
            return $url.($data->id+=1);
        }

        return $url;
    }

    public function get_clean_table_columns($table)
    {
        $all_fields = $this->db->list_fields($table);

        $clean_table_columns = [
            'pelanggan' => [
                'columns' => ['kode_pelanggan', 'nama_pelanggan', 'tipe_pelanggan', 'kontak_person', 'no_telp', 'kota', 'limit_kredit', 'status'],
                'labels'  => ['Kode Pelanggan', 'Nama Pelanggan', 'Tipe', 'Kontak Person', 'No. Telepon', 'Kota', 'Limit Kredit (Rp)', 'Status']
            ],
            'supplier' => [
                'columns' => ['kode_supplier', 'nama_supplier', 'kontak_person', 'telepon', 'email', 'kota', 'mata_uang', 'status'],
                'labels'  => ['Kode Supplier', 'Nama Supplier', 'Kontak Person', 'No. Telepon', 'Email', 'Kota', 'Mata Uang', 'Status']
            ],
            'produk' => [
                'columns' => ['kode_produk', 'barcode', 'nama_produk', 'harga_beli', 'harga_jual', 'stok_minimum', 'status', 'created_at'],
                'labels'  => ['Kode Produk', 'Barcode', 'Nama Produk', 'Harga Beli (Rp)', 'Harga Jual (Rp)', 'Stok Minimum', 'Status', 'Tanggal Dibuat']
            ],
            'kategori_produk' => [
                'columns' => ['kode_kategori', 'nama_kategori', 'deskripsi', 'created_at'],
                'labels'  => ['Kode Kategori', 'Nama Kategori', 'Deskripsi', 'Tanggal Dibuat']
            ],
            'satuan' => [
                'columns' => ['singkatan', 'nama_satuan', 'deskripsi', 'created_at'],
                'labels'  => ['Singkatan', 'Nama Satuan', 'Deskripsi', 'Tanggal Dibuat']
            ],
            'invoice' => [
                'columns' => ['nomor_invoice', 'tanggal_invoice', 'tanggal_jatuh_tempo', 'subtotal', 'diskon_total', 'total', 'status', 'status_kirim'],
                'labels'  => ['No. Invoice', 'Tgl Invoice', 'Jatuh Tempo', 'Subtotal (Rp)', 'Diskon (Rp)', 'Total Nilai (Rp)', 'Status Bayar', 'Status Kirim']
            ],
            'purchase_order' => [
                'columns' => ['nomor_po', 'tanggal_po', 'nama_supplier', 'mata_uang', 'grand_total_web', 'subtotal', 'diskon', 'kurs', 'tanggal_estimasi', 'status'],
                'labels'  => ['No. PO', 'Tgl PO', 'Supplier', 'Mata Uang', 'Grand Total', 'Subtotal', 'Diskon', 'Kurs Valas', 'Est. Datang', 'Status PO']
            ],
            'penjualan_marketplace' => [
                'columns' => ['no_pesanan', 'nomor_so', 'source', 'status_pesanan', 'nomor_resi', 'opsi_pengiriman', 'waktu_pembayaran', 'username_pembeli', 'nama_penerima', 'no_telepon', 'total'],
                'labels'  => ['No. Pesanan', 'No. Transaksi Penjualan', 'Saluran', 'Status Pesanan', 'No. Resi', 'Kurir / Opsi Kirim', 'Waktu Bayar', 'Username Pembeli', 'Nama Penerima', 'No. Telepon', 'Total Nilai (Rp)']
            ],
            'sales_order' => [
                'columns' => ['nomor_so', 'no_pesanan', 'tanggal_so', 'source', 'subtotal', 'diskon', 'total', 'status'],
                'labels'  => ['No. Transaksi Penjualan', 'No. Pesanan', 'Tanggal Transaksi', 'Saluran', 'Subtotal (Rp)', 'Diskon (Rp)', 'Total Nilai (Rp)', 'Status Order']
            ],
            'aauth_users' => [
                'columns' => ['username', 'full_name', 'email', 'last_login', 'banned'],
                'labels'  => ['Username', 'Nama Lengkap', 'Email', 'Login Terakhir', 'Status Akun']
            ],
            'utang_usaha' => [
                'columns' => ['nomor_utang', 'tanggal_utang', 'tanggal_jatuh_tempo', 'total', 'terbayar', 'sisa', 'status'],
                'labels'  => ['No. Utang', 'Tanggal Utang', 'Jatuh Tempo', 'Total Tagihan (Rp)', 'Terbayar (Rp)', 'Sisa Utang (Rp)', 'Status']
            ],
            'piutang_usaha' => [
                'columns' => ['nomor_piutang', 'tanggal_piutang', 'tanggal_jatuh_tempo', 'total', 'terbayar', 'sisa', 'status'],
                'labels'  => ['No. Piutang', 'Tanggal Piutang', 'Jatuh Tempo', 'Total Tagihan (Rp)', 'Terbayar (Rp)', 'Sisa Piutang (Rp)', 'Status']
            ],
            'retur_penjualan' => [
                'columns' => ['nomor_retur', 'tanggal_retur', 'nama_pelanggan', 'alasan', 'total', 'status'],
                'labels'  => ['No. Retur', 'Tanggal Retur', 'Pelanggan', 'Alasan Retur', 'Total Nilai (Rp)', 'Status Retur']
            ],
            'retur_pembelian' => [
                'columns' => ['nomor_retur', 'tanggal_retur', 'nama_supplier', 'nomor_po', 'alasan', 'total', 'status'],
                'labels'  => ['No. Retur', 'Tanggal Retur', 'Supplier', 'Nomor PO', 'Alasan Retur', 'Total Retur (Rp)', 'Status']
            ],
            'harga_pelanggan' => [
                'columns' => ['id', 'harga', 'diskon_persen', 'created_at'],
                'labels'  => ['ID', 'Harga Khusus (Rp)', 'Diskon (%)', 'Tanggal Dibuat']
            ]
        ];

        $selected_fields = [];
        $selected_labels = [];

        if (isset($clean_table_columns[$table])) {
            foreach ($clean_table_columns[$table]['columns'] as $idx => $col) {
                if (in_array($col, $all_fields)) {
                    $selected_fields[] = $col;
                    $selected_labels[$col] = $clean_table_columns[$table]['labels'][$idx] ?? ucwords(str_replace('_', ' ', $col));
                }
            }
        }

        if (empty($selected_fields)) {
            $blacklist = [
                'id', 'pass', 'password', 'salt', 'remember_time', 'reset_code', 'ip_address', 
                'verification_code', 'created_by', 'updated_by', 'deleted_at', 'deleted_by', 
                'so_id', 'pelanggan_id', 'supplier_id', 'produk_id', 'default_rak_id', 
                'approval_level', 'is_default', 'keterangan_bc', 'alasan_pembatalan', 
                'status_pembatalan_pengembalian', 'kurs_manual', 'nomor_referensi_sku', 'sku_induk', 
                'nama_variasi', 'pesanan_harus_dikirim_sebelum', 'waktu_pengiriman_diatur', 'waktu_pesanan_dibuat'
            ];
            foreach ($all_fields as $col) {
                if (!in_array($col, $blacklist)) {
                    $selected_fields[] = $col;
                    $col_label = ucwords(str_replace(['_', '-'], ' ', $col));
                    $f_low = strtolower($col);
                    if (in_array($f_low, ['nomor_so', 'no_so'])) {
                        $col_label = 'No. Transaksi Penjualan';
                    } elseif (in_array($f_low, ['tanggal_so', 'tgl_so'])) {
                        $col_label = 'Tanggal Transaksi Penjualan';
                    } elseif ($f_low === 'so_id') {
                        $col_label = 'ID Transaksi Penjualan';
                    }
                    $selected_labels[$col] = $col_label;
                }
            }
            if (count($selected_fields) > 10) {
                $selected_fields = array_slice($selected_fields, 0, 10);
            }
        }

        return [$selected_fields, $selected_labels];
    }

    public function export($table, $subject = 'file')
    {
        @ini_set('memory_limit', '512M');
        @set_time_limit(180);

        // Terapkan filter pencarian aktif jika ada
        $q = trim((string)$this->input->get('q'));
        $f = trim((string)$this->input->get('f'));
        if (!empty($q)) {
            if (!empty($f) && $this->db->field_exists($f, $table)) {
                $this->db->like($table . '.' . $f, $q);
            } elseif (!empty($this->field_search)) {
                $this->db->group_start();
                $first = true;
                foreach ($this->field_search as $sfield) {
                    $clean_col = strpos($sfield, '.') !== false ? explode('.', $sfield)[1] : $sfield;
                    if ($this->db->field_exists($clean_col, $table)) {
                        if ($first) {
                            $this->db->like($table . '.' . $clean_col, $q);
                            $first = false;
                        } else {
                            $this->db->or_like($table . '.' . $clean_col, $q);
                        }
                    }
                }
                $this->db->group_end();
            }
        }

        $status = $this->input->get('status');
        if (!empty($status) && $this->db->field_exists('status', $table)) {
            $this->db->where($table . '.status', $status);
        }

        // Urutan sinkron: record terbaru di atas
        if ($this->db->field_exists('updated_at', $table) && $this->db->field_exists('created_at', $table)) {
            $this->db->order_by('GREATEST(COALESCE(' . $table . '.updated_at, "1970-01-01"), COALESCE(' . $table . '.created_at, "1970-01-01"))', 'DESC', FALSE);
        }
        if ($this->db->field_exists($this->primary_key, $table)) {
            $this->db->order_by($table . '.' . $this->primary_key, 'DESC');
        }

        list($clean_fields, $clean_labels) = $this->get_clean_table_columns($table);

        if ($table === 'purchase_order') {
            $this->db->select('purchase_order.*, supplier.nama_supplier');
            $this->db->join('supplier', 'supplier.id = purchase_order.supplier_id', 'LEFT');
        } elseif ($table === 'retur_penjualan') {
            $this->db->select('retur_penjualan.*, pelanggan.nama_pelanggan, invoice.nomor_invoice');
            $this->db->join('pelanggan', 'pelanggan.id = retur_penjualan.pelanggan_id', 'LEFT');
            $this->db->join('invoice', 'invoice.id = retur_penjualan.invoice_id', 'LEFT');
        } elseif ($table === 'retur_pembelian') {
            $this->db->select('retur_pembelian.*, supplier.nama_supplier, purchase_order.nomor_po');
            $this->db->join('supplier', 'supplier.id = retur_pembelian.supplier_id', 'LEFT');
            $this->db->join('purchase_order', 'purchase_order.id = retur_pembelian.po_id', 'LEFT');
        }

        $result = $this->db->get($table);

        if (ob_get_length()) { ob_end_clean(); }

        $clean_subject = str_ireplace(['sales_order', 'sales order', 'so_'], ['transaksi_penjualan', 'transaksi penjualan', 'transaksi_penjualan_'], $subject);
        $filename = ucwords(str_replace(['_', '-'], ' ', $clean_subject)) . '-' . date('Y-m-d') . '.xls';

        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        echo "<!DOCTYPE html>\n<html>\n<head>\n<meta charset=\"utf-8\">\n";
        echo "<style>
            th { background-color: #1E40AF; color: #ffffff; font-weight: bold; padding: 10px 8px; border: 1px solid #1E3A8A; text-align: center; font-family: Arial, sans-serif; font-size: 11pt; }
            td { padding: 6px 8px; border: 1px solid #cbd5e1; font-family: Arial, sans-serif; font-size: 10pt; vertical-align: middle; }
            .zebra { background-color: #F8FAFC; }
            .num { mso-number-format:\"\\#\\,\\#\\#0\"; text-align: right; }
            .currency { mso-number-format:\"\\\"Rp\\\"\\ \\#\\,\\#\\#0\"; text-align: right; }
            .text { mso-number-format:\"\\@\"; }
            .center { text-align: center; }
        </style>\n</head>\n<body>\n";
        echo "<table border=\"1\" cellpadding=\"4\" cellspacing=\"0\">\n<thead>\n<tr>\n";
        echo "<th>No</th>\n";
        foreach ($clean_fields as $col) {
            $col_label = $clean_labels[$col] ?? ucwords(str_replace(['_', '-'], ' ', $col));
            echo '<th>' . htmlspecialchars($col_label) . "</th>\n";
        }
        echo "</tr>\n</thead>\n<tbody>\n";

        $no = 1;
        foreach ($result->result() as $row) {
            $cls_row = ($no % 2 === 0) ? ' class="zebra"' : '';
            echo "<tr{$cls_row}>\n";
            echo "<td class=\"center\">" . ($no++) . "</td>\n";
            foreach ($clean_fields as $col) {
                $val = $row->$col ?? '';
                $f_lower = strtolower($col);

                // Penyesuaian khusus Purchase Order agar identik dengan tampilan web
                if ($table === 'purchase_order') {
                    $mata_uang = !empty($row->mata_uang) ? strtoupper($row->mata_uang) : 'IDR';
                    $kurs_po   = (float) ($row->kurs ?? 1);
                    if ($kurs_po <= 0) $kurs_po = 1;
                    $tot_valas = (float) ($row->total ?? 0);
                    $tot_rp    = $tot_valas * $kurs_po;

                    if ($f_lower === 'grand_total_web') {
                        $val = ($mata_uang !== 'IDR')
                            ? $mata_uang . ' ' . number_format($tot_valas, 2, ',', '.') . ' (Rp ' . number_format($tot_rp, 0, ',', '.') . ')'
                            : 'Rp ' . number_format($tot_valas, 0, ',', '.');
                    } elseif ($f_lower === 'total_rp') {
                        $val = $tot_rp;
                    } elseif ($f_lower === 'subtotal' && $mata_uang !== 'IDR') {
                        $val = $mata_uang . ' ' . number_format((float)($row->subtotal ?? 0), 2, ',', '.');
                    } elseif ($f_lower === 'diskon' && $mata_uang !== 'IDR') {
                        $val = $mata_uang . ' ' . number_format((float)($row->diskon ?? 0), 2, ',', '.');
                    } elseif ($f_lower === 'kurs') {
                        $val = ($mata_uang !== 'IDR') ? ('Rp ' . number_format($kurs_po, 0, ',', '.')) : '-';
                    } elseif ($f_lower === 'status') {
                        $val = ($row->status == 'completed') ? 'SELESAI (MASUK STOK)' : strtoupper($row->status);
                    }
                }

                if ($table === 'sales_order' && $f_lower === 'source') {
                    if ($val === 'pos' || strpos((string)($row->catatan ?? ''), '[POS CEPAT') !== false) {
                        $val = 'POS Kasir';
                    } elseif (in_array(strtolower((string)$val), ['manual', 'offline', '']) || is_null($val)) {
                        $val = 'Transaksi Offline';
                    }
                }

                // Fallback otomatis jika kode_kategori kosong
                if ($f_lower === 'kode_kategori' && empty(trim((string)$val))) {
                    $nama_k = $row->nama_kategori ?? ('CAT' . ($row->id ?? ''));
                    $clean_k = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $nama_k), 0, 6));
                    $val = 'KAT-' . ($clean_k ?: 'GEN');
                }

                // Fallback jika tipe_pelanggan kosong
                if ($f_lower === 'tipe_pelanggan' && empty(trim((string)$val))) {
                    $val = 'Retail';
                }

                // Fallback jika kontak_person kosong
                if ($f_lower === 'kontak_person' && empty(trim((string)$val))) {
                    $val = !empty($row->nama_pelanggan) ? $row->nama_pelanggan : (!empty($row->nama_supplier) ? $row->nama_supplier : '-');
                }

                // Format dan fallback kolom tanggal
                if (strpos($f_lower, 'tanggal') !== false || in_array($f_lower, ['created_at', 'updated_at', 'last_login', 'waktu_pembayaran'])) {
                    if (empty(trim((string)$val)) || $val === '0000-00-00 00:00:00' || $val === '0000-00-00' || strtotime($val) <= 0) {
                        $val = '-';
                    } elseif (strlen($val) > 10) {
                        $val = date('d/m/Y H:i', strtotime($val));
                    } else {
                        $val = date('d/m/Y', strtotime($val));
                    }
                }

                // Jika kolom non-numerik bernilai null atau string kosong, tampilkan tanda '-' agar data tidak kosong
                $is_numeric_col = in_array($f_lower, ['total', 'subtotal', 'harga', 'harga_beli', 'harga_jual', 'limit_kredit', 'diskon', 'diskon_total', 'sisa_utang', 'sisa_piutang', 'terbayar', 'sisa', 'total_nilai', 'stok_minimum', 'total_qty', 'diskon_persen']);
                if (!$is_numeric_col && (is_null($val) || trim((string)$val) === '')) {
                    $val = '-';
                }

                $cls = '';
                if (in_array($f_lower, ['no_telp', 'telepon', 'no_telepon', 'nomor_resi', 'resi', 'barcode', 'kode_produk', 'kode_pelanggan', 'kode_supplier', 'singkatan', 'kode_kategori', 'no_pesanan', 'nomor_so', 'nomor_po', 'nomor_invoice', 'nomor_utang', 'nomor_piutang', 'nomor_retur'])) {
                    $cls = ' class="text"';
                } elseif (is_numeric($val) && strlen((string)$val) > 1 && substr((string)$val, 0, 1) === '0') {
                    $cls = ' class="text"'; // Nomor telepon, resi, kode berawalan 0
                } elseif (in_array($f_lower, ['total', 'subtotal', 'harga', 'harga_beli', 'harga_jual', 'limit_kredit', 'diskon', 'diskon_total', 'sisa_utang', 'sisa_piutang', 'terbayar', 'sisa', 'total_nilai'])) {
                    $cls = ' class="currency"';
                } elseif (is_numeric($val) && strpos($f_lower, 'id') === false) {
                    $cls = ' class="num"';
                } elseif (in_array($f_lower, ['status', 'status_pesanan', 'status_kirim', 'singkatan', 'mata_uang', 'tipe_pelanggan']) || strpos($f_lower, 'tanggal') !== false || in_array($f_lower, ['created_at', 'updated_at', 'last_login'])) {
                    $cls = ' class="center"';
                }
                echo '<td' . $cls . '>' . htmlspecialchars((string)$val) . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</tbody>\n</table>\n</body>\n</html>";
        exit;
    }


    public function pdf($table, $title)
    {
        @ini_set('memory_limit', '512M');
        @set_time_limit(180);

        $this->load->library('HtmlPdf');

        // Terapkan filter pencarian aktif secara realtime jika pengguna melakukan filter di halaman list
        $q = trim((string)$this->input->get('q'));
        $f = trim((string)$this->input->get('f'));

        if (!empty($q)) {
            if (!empty($f) && $this->db->field_exists($f, $table)) {
                $this->db->like($table . '.' . $f, $q);
            } elseif (!empty($this->field_search)) {
                $this->db->group_start();
                $first = true;
                foreach ($this->field_search as $sfield) {
                    $clean_col = strpos($sfield, '.') !== false ? explode('.', $sfield)[1] : $sfield;
                    if ($this->db->field_exists($clean_col, $table)) {
                        if ($first) {
                            $this->db->like($table . '.' . $clean_col, $q);
                            $first = false;
                        } else {
                            $this->db->or_like($table . '.' . $clean_col, $q);
                        }
                    }
                }
                $this->db->group_end();
            }
        }

        // Terapkan filter status jika ada di URL dan kolom status ada di tabel
        $status = $this->input->get('status');
        if (!empty($status) && $this->db->field_exists('status', $table)) {
            $this->db->where($table . '.status', $status);
        }

        // Urutan sinkron: record terbaru di atas
        if ($this->db->field_exists('updated_at', $table) && $this->db->field_exists('created_at', $table)) {
            $this->db->order_by('GREATEST(COALESCE(' . $table . '.updated_at, "1970-01-01"), COALESCE(' . $table . '.created_at, "1970-01-01"))', 'DESC', FALSE);
        }
        if ($this->db->field_exists($this->primary_key, $table)) {
            $this->db->order_by($table . '.' . $this->primary_key, 'DESC');
        }

        list($selected_fields, $selected_labels) = $this->get_clean_table_columns($table);

        if ($table === 'purchase_order') {
            $this->db->select('purchase_order.*, supplier.nama_supplier');
            $this->db->join('supplier', 'supplier.id = purchase_order.supplier_id', 'LEFT');
        } elseif ($table === 'retur_penjualan') {
            $this->db->select('retur_penjualan.*, pelanggan.nama_pelanggan, invoice.nomor_invoice');
            $this->db->join('pelanggan', 'pelanggan.id = retur_penjualan.pelanggan_id', 'LEFT');
            $this->db->join('invoice', 'invoice.id = retur_penjualan.invoice_id', 'LEFT');
        } elseif ($table === 'retur_pembelian') {
            $this->db->select('retur_pembelian.*, supplier.nama_supplier, purchase_order.nomor_po');
            $this->db->join('supplier', 'supplier.id = retur_pembelian.supplier_id', 'LEFT');
            $this->db->join('purchase_order', 'purchase_order.id = retur_pembelian.po_id', 'LEFT');
        }

        // Ambil data asli realtime dari database
        $result = $this->db->get($table);
        $rows   = $result->result();

        if ($table === 'purchase_order') {
            foreach ($rows as $row) {
                $mata_uang = !empty($row->mata_uang) ? strtoupper($row->mata_uang) : 'IDR';
                $kurs_po   = (float) ($row->kurs ?? 1);
                if ($kurs_po <= 0) $kurs_po = 1;
                $tot_valas = (float) ($row->total ?? 0);
                $tot_rp    = $tot_valas * $kurs_po;

                $row->grand_total_web = ($mata_uang !== 'IDR')
                    ? $mata_uang . ' ' . number_format($tot_valas, 2, ',', '.') . ' (Rp ' . number_format($tot_rp, 0, ',', '.') . ')'
                    : 'Rp ' . number_format($tot_valas, 0, ',', '.');
                $row->total_rp = 'Rp ' . number_format($tot_rp, 0, ',', '.');
                $row->status = ($row->status == 'completed') ? 'SELESAI (MASUK STOK)' : strtoupper($row->status);
            }
        }

        // Gunakan landscape jika jumlah field > 4 agar data tidak berdesakan dan terpotong di tepi kertas
        $orientation = count($selected_fields) > 4 ? 'l' : 'p';
      
        $config = array(
            'orientation' => $orientation,
            'format' => 'a4',
            'marges' => array(7, 7, 7, 7)
        );

        $this->pdf = new HtmlPdf($config);

        $clean_title = str_ireplace(['sales_order', 'sales order'], 'Transaksi Penjualan', $title);
        if (trim(strtolower($clean_title)) === 'so') {
            $clean_title = 'Transaksi Penjualan';
        }

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/pdf', [
            'results'     => $rows,
            'fields'      => $selected_fields,
            'labels'      => $selected_labels,
            'title'       => $clean_title,
            'orientation' => $orientation
        ], TRUE);

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        if (ob_get_length()) { ob_end_clean(); }
        $out_name = str_ireplace(['sales_order', 'sales order'], 'transaksi_penjualan', $table);
        $this->pdf->Output($out_name.'.pdf', 'I');
        exit;
    }

    public function generate_id($suffix = null) 
    {
        $format = $suffix.(new DateTime)->format('Ymd');
        $exist = $this->db->query('SELECT * FROM '.$this->table_name.' WHERE '.$this->primary_key . '  LIKE "%'.$format.'%" ORDER BY '.$this->primary_key. ' DESC');

        $numbering = '0001';
        if ($exist->num_rows()) {
            $last = $exist->row();
            $last_numbering = substr($last->{$this->primary_key}, -4);
            $next_number = $last_numbering+=1;
            $numbering = sprintf("%04d", $next_number);

            return $format.$numbering;
        } 
        else {
            return $format.$numbering;
        }
    }
}

/* End of file My_Model.php */
/* Location: ./application/core/My_Model.php */