-- =============================================
-- Migration: 2-Way WhatsApp Chat (Fonnte)
-- Date: 2026-09-09
-- =============================================

-- 1. Tabel crm_chat_history (dedicated 2-way chat storage)
CREATE TABLE IF NOT EXISTS crm_chat_history (
  id INT AUTO_INCREMENT PRIMARY KEY,
  label_id INT NOT NULL COMMENT 'FK ke crm_transaction_followup_labels.id',
  customer_phone VARCHAR(50) NOT NULL,
  direction ENUM('in','out') NOT NULL COMMENT 'in=customer, out=CS',
  message TEXT NOT NULL,
  sender_name VARCHAR(150) DEFAULT NULL,
  sender_cs_name VARCHAR(100) DEFAULT NULL,
  is_internal_note TINYINT(1) NOT NULL DEFAULT 0,
  status ENUM('sent','delivered','read','failed') DEFAULT 'sent',
  fonnte_response TEXT DEFAULT NULL COMMENT 'Raw API response dari Fonnte',
  webhook_log_id INT DEFAULT NULL COMMENT 'FK ke crm_webhook_logs.id jika dari webhook',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_label_id (label_id),
  INDEX idx_customer_phone (customer_phone),
  INDEX idx_created_at (created_at),
  INDEX idx_label_created (label_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2. Index pada crm_webhook_logs.sender (untuk lookup cepat saat webhook)
ALTER TABLE crm_webhook_logs ADD INDEX idx_sender (sender);

-- 3. Index pada crm_followup_notes.created_at (untuk query timeline)
ALTER TABLE crm_followup_notes ADD INDEX idx_created_at (created_at);

-- 4. Expand ENUM metode_kirim di broadcast_logs (tambah wa_gateway_api)
ALTER TABLE crm_broadcast_logs MODIFY metode_kirim ENUM('wa_direct_link','wa_gateway','wa_gateway_api','manual') DEFAULT 'wa_direct_link';
