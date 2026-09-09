# Dokumentasi 2-Way WhatsApp Chat — Fonnte Webhook Integration

## 1. Format Nomor HP Kanonik

Format kanonik yang digunakan: **`62xxxxxxxxxx`** (tanpa `+`, tanpa spasi, tanpa `-`)

### Konversi Otomatis

| Input | Output Kanonik |
|-------|---------------|
| `0812-3456-789` | `62812345678` |
| `+62812345678` | `62812345678` |
| `62812345678` | `62812345678` |
| `812345678` | `62812345678` |

### Fungsi Normalisasi

```php
// Model: Model_crm::normalize_phone_number($phone)
// Bisa dipanggil langsung tanpa controller:
$this->model_crm->normalize_phone_number('08123456789');
// Output: '628123456789'
```

**Algoritma:**
1. Hapus semua karakter non-digit
2. Jika prefix `0` → ganti dengan `62`
3. Jika prefix bukan `62` → tambahkan `62` di depan
4. Jika sudah `62xxx` → return as-is

---

## 2. Webhook Payload — Fonnte

### Endpoint

```
POST /administrator/crm/fonnte_webhook
```

### Field yang Digunakan dari Payload Fonnte

| Field | Tipe | Wajib | Keterangan |
|-------|------|-------|------------|
| `sender` | string | ✅ | Nomor pengirim (format `08xx`, `628xx`, atau `+628xx`) |
| `message` | string | ✅ | Isi pesan teks |
| `name` | string | ❌ | Nama kontak (pushname WhatsApp) |
| `device` | string | ❌ | Nomor device Fonnte |
| `url` | string | ❌ | URL media (jika ada attachment) |
| `filename` | string | ❌ | Nama file media |
| `extension` | string | ❌ | Ekstensi file media |
| `member` | string | ❌ | Member info (untuk grup, di-skip) |

### Field Fallback (Jika Provider Bukan Fonnte)

Webhook juga mencoba field berikut sebagai fallback:
- `sender` fallback: `from`, `phone`, `wa_number`  
- `message` fallback: `body`, `text`, `caption`
- `name` fallback: `pushname`, `sender_name`

### Response

Selalu return HTTP 200 dengan JSON:
```json
{"success": true, "message": "...", "logged": 1}
```
Bahkan jika nomor tidak cocok, tetap HTTP 200 agar Fonnte tidak retry.

### Filter Otomatis

- **Pesan grup** (sender mengandung `@g.us` atau hyphen panjang) → di-skip
- **Pesan kosong** (sender/message kosong) → di-tolak

---

## 3. Flow Pengiriman Pesan CS → Customer

### Via Fonnte API (`wa_gateway` mode)

```
CS ketik pesan di chat modal
  → POST /administrator/crm/send_message_ajax
    → is_internal_note = 0
    → Model::send_wa_via_api() → POST https://api.fonnte.com/send
    → Insert crm_chat_history (direction='out', status='sent'/'failed')
    → Insert crm_broadcast_logs (legacy compat)
    → Insert crm_followup_notes (legacy compat)
```

### Via WA Direct Link (`wa_direct` mode)

```
CS ketik pesan di chat modal
  → POST /administrator/crm/send_message_ajax
    → is_internal_note = 0
    → Tidak ada API call
    → Insert crm_chat_history (direction='out', status='sent')
    → Return wa_link → browser buka wa.me/62xxx?text=...
```

### Catatan Internal

```
CS ketik catatan di chat modal (toggle ke "Catatan Internal")
  → POST /administrator/crm/send_message_ajax
    → is_internal_note = 1
    → TIDAK ada panggilan ke Fonnte
    → Insert crm_chat_history (direction='out', is_internal_note=1)
    → Insert crm_followup_notes (sender_type='cs')
```

---

## 4. Flow Penerimaan Balasan Customer

```
Customer balas via WhatsApp
  → Fonnte webhook POST ke /administrator/crm/fonnte_webhook
    → Log raw payload ke crm_webhook_logs (SEBELUM proses apapun)
    → Normalisasi nomor HP
    → Cari label di crm_transaction_followup_labels (tail-9 digit match)
    → Idempotency check (cek duplikat 5 menit terakhir)
    → Insert crm_chat_history (direction='in', status='delivered')
    → Insert crm_followup_notes (sender_type='customer')
    → Update status_label → 'Direspon'
    → Return HTTP 200
```

### Jika Nomor Tidak Cocok

```
  → Insert crm_unmatched_inbound (status='pending')
  → Tetap return HTTP 200
```

---

## 5. Tabel Database

### crm_chat_history (BARU)

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | INT AI | Primary key |
| `label_id` | INT | FK → crm_transaction_followup_labels.id |
| `customer_phone` | VARCHAR(50) | Nomor kanonik (62xxx) |
| `direction` | ENUM('in','out') | in = customer, out = CS |
| `message` | TEXT | Isi pesan |
| `sender_name` | VARCHAR(150) | Nama customer (untuk incoming) |
| `sender_cs_name` | VARCHAR(100) | Username CS (untuk outgoing) |
| `is_internal_note` | TINYINT(1) | 1 = catatan internal, tidak dikirim WA |
| `status` | ENUM | sent / delivered / read / failed |
| `fonnte_response` | TEXT | Raw response dari Fonnte API |
| `webhook_log_id` | INT | FK → crm_webhook_logs.id |
| `created_at` | DATETIME | Timestamp |

### Indexes
- `idx_label_id` — query per label
- `idx_customer_phone` — lookup per nomor
- `idx_created_at` — sorting time-based
- `idx_label_created` — composite untuk polling efisien

---

## 6. Endpoint API Reference

| Method | Endpoint | Params | Response |
|--------|----------|--------|----------|
| POST | `/administrator/crm/fonnte_webhook` | sender, message, name | `{success, message, logged}` |
| POST | `/administrator/crm/send_message_ajax` | label_id, message, is_internal_note | `{success, chat_id, status, message, api_result?, wa_link?}` |
| GET | `/administrator/crm/get_new_messages_ajax` | label_id, last_id | `{success, messages[], count, label}` |
| GET | `/administrator/crm/get_chat_timeline_ajax` | label_id | `{success, timeline[], count, label}` |
