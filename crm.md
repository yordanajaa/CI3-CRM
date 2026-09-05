# 📋 DOKUMENTASI MODUL CRM & AFTER SALES — IDMETAFORA

> **Status: ✅ SELURUH MODUL AKTIF & STABIL (ZERO ERROR)**
> Terakhir diverifikasi: September 2026

---

## 📌 Brief Umum System Journey CRM

1. **Sumber Data Utama**
   - Data CRM mengambil data dari Data List Penjualan yang sudah tersedia.
   - Tidak perlu membuat input data customer/transaksi dari awal.
   - Sistem CRM cukup dikoneksikan dengan data penjualan yang sudah ada.

2. **Customer Data**
   - Data customer otomatis berasal dari data penjualan.
   - Informasi customer dan riwayat pembelian dapat ditampilkan berdasarkan transaksi yang sudah ada.

3. **Sumber Penjualan**
   - Setiap transaksi memiliki informasi sumber penjualan.
   - Sumber penjualan: **Toko**, **Shopee**, **Tokopedia**, **TikTok Shop**

4. **Customer Journey**
   - Data Penjualan → Customer → Riwayat Transaksi → Follow Up → Repeat Order

5. **Customer Follow Up / Broadcast**
   - Sistem digunakan untuk memonitor customer yang perlu dilakukan follow up.
   - Terdapat informasi status follow up customer.
   - Fitur broadcast pesan WhatsApp sesuai kelompok customer yang sudah ditentukan.
   - User dapat membuat kelompok status follow up customer beserta template chatnya.

6. **Customer History**
   - Menampilkan riwayat pembelian customer.
   - Dapat melihat jumlah transaksi, produk yang pernah dibeli, dan sumber pembeliannya.

7. **Dashboard CRM**
   - Menampilkan gambaran customer dan transaksi secara keseluruhan.
   - Dapat digunakan untuk melihat customer berdasarkan sumber penjualan, aktivitas pembelian, dan status follow up.

---

## 🌐 DAFTAR URL MODUL CRM

| No | Modul | URL | Status |
|----|-------|-----|--------|
| 1 | Dashboard CRM Analytics | `/administrator/crm/dashboard` | ✅ OK |
| 2 | Customer Directory | `/administrator/crm` atau `/administrator/crm/customer_list` | ✅ OK |
| 3 | Customer Detail | `/administrator/crm/customer_detail?phone=XXX` | ✅ OK |
| 4 | Journal Follow-Up | `/administrator/crm/journal_followup` | ✅ OK |
| 5 | Broadcast WhatsApp | `/administrator/crm/broadcast` | ✅ OK |
| 6 | Pengaturan Kelompok Follow-Up | `/administrator/crm/followup_setting` | ✅ OK |
| 7 | Otomasi & Monitoring Log | `/administrator/crm/automations` | ✅ OK |
| 8 | Kinerja & Konversi Tim CS | `/administrator/crm/cs_performance` | ✅ OK |

---

## 📂 STRUKTUR FILE

### Controller
- `modules/crm/controllers/backend/Crm.php`

### Model
- `modules/crm/models/Model_crm.php`

### Views (8 file)
- `crm_dashboard.php` — Dashboard Analytics dengan KPI cards & Chart.js
- `crm_customer_list.php` — Direktori pelanggan dengan pencarian & paginasi
- `crm_customer_detail.php` — Detail riwayat transaksi per pelanggan
- `crm_journal_followup.php` — Antrean follow-up dengan filter & aksi massal
- `crm_broadcast.php` — Broadcast WhatsApp dengan preview pesan & log
- `crm_followup_setting.php` — CRUD kelompok follow-up & template pesan
- `crm_automations.php` — 4 proses otomasi (Overdue, Cancellation, Bundle, Conversion)
- `crm_cs_performance.php` — Leaderboard CS, omset konversi, grafik Chart.js

### Tabel Database CRM
- `crm_followup_categories` — Kelompok follow-up (H+0, H+3, H+7, H+30, dll.)
- `crm_transaction_followup_labels` — Label follow-up per transaksi
- `crm_followup_notes` — Catatan follow-up per label
- `crm_broadcast_logs` — Log broadcast WhatsApp
- `crm_automation_logs` — Log eksekusi otomasi CRM

### Utilitas
- `run_crm_cron.bat` — Batch script untuk menjalankan otomasi CRM via CLI

---

## 📊 FITUR AJAX ENDPOINT

| Endpoint | Fungsi |
|----------|--------|
| `update_status_ajax` | Ubah status & tambah catatan follow-up |
| `get_notes_ajax` | Ambil catatan follow-up per label |
| `get_wa_link_ajax` | Generate link WhatsApp + preview pesan |
| `send_broadcast_ajax` | Kirim broadcast massal WA |
| `get_broadcast_recipients_ajax` | Ambil daftar penerima broadcast |
| `run_automations_ajax` | Jalankan 4 proses otomasi CRM |
| `generate_labels_cron` | Generate label follow-up untuk pesanan baru |
| `transaction_detail_ajax` | Detail item transaksi + timeline follow-up |

---

## 📤 EXPORT CSV

| Endpoint | Output |
|----------|--------|
| `export_customers` | Ekspor daftar pelanggan ke CSV |
| `export_journal` | Ekspor journal follow-up ke CSV |
| `export_cs_performance` | Ekspor laporan kinerja tim CS ke CSV |

---

## ✅ HASIL VERIFIKASI TERAKHIR

- **8 Halaman**: Semua HTTP 200 OK, zero PHP Error
- **6 AJAX Endpoint**: Semua return valid JSON, zero error
- **3 Export CSV**: Semua menghasilkan file CSV dengan content-type benar
- **Syntax Check**: Controller, Model, dan 8 View file — zero syntax error