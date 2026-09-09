# Task: Implementasi 2-Way WhatsApp Chat (Fonnte) di Modul CRM

## 1. Objective
Buat fitur chat dua arah antara CS (admin) dan customer di dalam modul CRM, menggunakan Fonnte sebagai WhatsApp gateway. CS mengirim pesan dari web app → keluar sebagai WA ke HP customer. Balasan customer via WA → masuk otomatis ke chat timeline di web app melalui webhook, tanpa refresh halaman.

## 2. Tech Stack & Constraints (WAJIB DIPATUHI)
- Framework: **CodeIgniter 3 HMVC** — modul ada di `application/modules/crm/{controllers,models,views}`.
- PHP version: **strict PHP 7.2**. Jangan pakai sintaks PHP 7.4+/8.x (`??=`, `fn() =>`, `?->`, named arguments, dll).
- Environment lokal: Laragon. Webhook publik ditest via tunnel (ngrok/cloudflared).
- Tidak boleh ada kode placeholder / `TODO` / stub — semua fungsi harus jalan penuh dan bisa langsung dites.
- Semua dependency (library PHP/JS) harus di-pin versi eksaknya, jangan pakai `latest` atau range version.

## 3. Current State (sudah ada, jangan dibangun ulang — hanya diperbaiki/dilengkapi)
- Endpoint webhook: `/administrator/crm/fonnte_webhook` dan `/waha_webhook`.
- Tabel log mentah: `crm_webhook_logs` (menyimpan raw payload, sender, message, timestamp).
- Pengiriman keluar via Fonnte API sudah berhasil.
- **Masalah yang belum solve**: balasan dari customer kadang tidak muncul di chat timeline web (dugaan: format nomor HP tidak konsisten saat pencocokan ke data transaksi).

## 4. Functional Requirements

### 4.1 Terima pesan masuk (webhook)
- Endpoint `fonnte_webhook` menerima POST dari Fonnte dengan field: `device`, `sender`, `message`, `text`, `name`, `member` (jika grup), `location`, dan (jika device full-feature) `url`/`filename`/`extension` untuk media.
- Simpan raw payload lengkap ke `crm_webhook_logs` SEBELUM melakukan proses apapun (biar tidak ada data hilang kalau proses berikutnya error).
- **Normalisasi nomor HP** dari field `sender` sebelum dicocokkan: hilangkan karakter non-digit, samakan prefix (`0812...` ⇄ `62812...` ⇄ `+62812...`) ke satu format kanonik (disarankan format `62xxxxxxxxxx` tanpa `+`).
- Cocokkan nomor hasil normalisasi ke tabel customer/transaksi (`sales_order` / `penjualan_marketplace`). Kalau ketemu, insert pesan ke tabel chat history dengan `direction = 'in'`, status label pelanggan diubah jadi **"Direspon"**.
- Kalau nomor TIDAK ketemu di data customer manapun: tetap simpan ke log & ke tabel "unmatched inbound messages" terpisah (jangan silent-drop), supaya CS bisa cek manual nanti.
- Return HTTP 200 dengan body JSON `{"status": true}` ke Fonnte SELALU (walaupun pencocokan gagal), supaya Fonnte tidak retry berulang dan menganggap webhook error.

### 4.2 Kirim pesan keluar (dari CS)
- Endpoint CI3 (controller method) untuk kirim pesan ke customer via `POST https://api.fonnte.com/send`.
- Simpan pesan ke tabel chat history dengan `direction = 'out'`, `sender_cs_name`, timestamp, status awal `sent`.
- Tangani response gagal dari Fonnte (misal token invalid, device offline) — jangan anggap sukses kalau `status` dari response Fonnte bernilai false. Tampilkan error yang jelas ke CS di UI.
- Dukung juga mode **Catatan Internal** (tidak dikirim ke Fonnte sama sekali, cuma tersimpan lokal dengan flag `is_internal_note = 1`).

### 4.3 Chat timeline UI
- View modal chat 2 arah, load riwayat pesan (in + out + internal note) urut berdasarkan timestamp per customer/transaksi.
- **Live update tanpa refresh**: polling AJAX tiap 3 detik ke endpoint `get_new_messages` (kirim `last_message_id` atau `last_timestamp` dari client, return hanya pesan baru — jangan query ulang semua history tiap polling, ini penting untuk performa).
- Render 3 jenis bubble sesuai spesifikasi:
  - Keluar (CS → kanan, hijau `#d9fdd3`)
  - Masuk (customer → kiri, putih `#ffffff`)
  - Internal note (tengah, emas `#fef3c7`)
- Toggle switch untuk pilih mode kirim: **Balasan WA** vs **Catatan Internal**.

## 5. Non-Functional Requirements
- **Retry/alert mechanism**: kalau webhook gagal diproses (exception di server), log error ke file/tabel terpisah dan (minimal) catat di log — jangan sampai silent fail tanpa jejak.
- **Idempotency**: kalau Fonnte mengirim webhook duplikat (retry dari sisi mereka), jangan sampai pesan yang sama masuk 2x ke chat history — cek berdasarkan kombinasi sender+message+timestamp sebelum insert.
- Query pencocokan nomor HP & fetch pesan baru harus pakai index database (nomor HP dan timestamp), karena akan sering diakses tiap 3 detik oleh banyak sesi chat sekaligus.

## 6. Deliverables
1. Migration/SQL untuk tabel chat history (kalau belum ada) dan tabel unmatched inbound messages.
2. Model: fungsi normalisasi nomor HP (unit-testable, bisa dipanggil terpisah dari controller).
3. Controller method: `fonnte_webhook()`, `send_message()`, `get_new_messages()`.
4. View + JS: modal chat dengan polling, render bubble, toggle mode kirim.
5. Dokumentasi singkat: daftar field payload webhook yang dipakai, dan format nomor kanonik yang dipilih.

## 7. Test Plan (Acceptance Criteria)
- [ ] Kirim pesan dari CS → muncul di WA customer (device test).
- [ ] Balas dari WA customer (nomor format `0812...`) → webhook diterima → nomor ternormalisasi cocok ke transaksi yang pakai format `+62812...` di database → pesan muncul di chat timeline dalam ≤3 detik tanpa refresh.
- [ ] Kirim webhook dengan nomor yang tidak ada di data manapun → tidak error, masuk ke tabel unmatched, status HTTP tetap 200.
- [ ] Kirim webhook duplikat (payload sama persis 2x) → tidak dobel di chat history.
- [ ] Simulasikan Fonnte API gagal (token salah) saat kirim pesan → CS melihat pesan error yang jelas, bukan silent fail.
- [ ] Test end-to-end di local Laragon via ngrok tunnel sesuai flow yang sudah didiskusikan.

## 8. Out of Scope (untuk task ini)
- Role/permission multi-user CS (masih 1 role untuk tahap testing).
- Broadcast massal & rate limiting pengiriman.
- Dashboard analytics.
