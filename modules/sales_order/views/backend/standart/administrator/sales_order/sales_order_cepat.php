<link rel="stylesheet" href="<?= base_url('asset/admin-lte/plugins/select2/select2.min.css'); ?>">
<style>
/* Select2 Modern Styling for POS */
.select2-container {
  width: 100% !important;
}
.select2-container .selection {
  width: 100% !important;
  display: block !important;
}
.select2-container--default .select2-selection--single {
  height: 36px !important;
  line-height: 34px !important;
  width: 100% !important;
  border-radius: 6px !important;
  border: 1px solid #cbd5e1 !important;
  background: #fff !important;
  padding: 0 8px !important;
  display: block !important;
  box-sizing: border-box !important;
  transition: all .15s ease !important;
  position: relative !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
  color: #1e293b !important;
  font-size: 13px !important;
  padding-left: 0 !important;
  padding-right: 44px !important;
  line-height: 34px !important;
  font-weight: 500 !important;
  overflow: hidden !important;
  text-overflow: ellipsis !important;
  white-space: nowrap !important;
  display: block !important;
  width: 100% !important;
  box-sizing: border-box !important;
}
.select2-container--default .select2-selection--single .select2-selection__clear {
  position: absolute !important;
  right: 24px !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
  font-size: 15px !important;
  font-weight: bold !important;
  color: #94a3b8 !important;
  cursor: pointer !important;
  line-height: 1 !important;
  padding: 2px !important;
  z-index: 2 !important;
  transition: color 0.15s ease !important;
}
.select2-container--default .select2-selection--single .select2-selection__clear:hover {
  color: #ef4444 !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 34px !important;
  right: 6px !important;
}
.select2-container--default .select2-selection--single:focus,
.select2-container--default.select2-container--open .select2-selection--single {
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.12) !important;
}
.select2-dropdown {
  border: 1px solid #cbd5e1 !important;
  border-radius: 8px !important;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
  z-index: 9999 !important;
  overflow: hidden !important;
}
.select2-search--dropdown {
  padding: 8px !important;
  background: #f8fafc !important;
  border-bottom: 1px solid #f1f5f9 !important;
}
.select2-search--dropdown .select2-search__field {
  border: 1px solid #cbd5e1 !important;
  border-radius: 6px !important;
  padding: 6px 10px !important;
  font-size: 13px !important;
  height: 34px !important;
  outline: none !important;
}
.select2-search--dropdown .select2-search__field:focus {
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 2px rgba(59,130,246,0.1) !important;
}
.select2-results__option {
  padding: 7px 10px !important;
  font-size: 12.5px !important;
  color: #334155 !important;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
  background-color: #3b82f6 !important;
  color: #fff !important;
}
.select2-container--default .select2-results__option[aria-selected=true] {
  background-color: #eff6ff !important;
  color: #1d4ed8 !important;
  font-weight: 600 !important;
}
#tbl_items select.form-control,
#tbl_items .select2,
#tbl_items .select2-container,
#tbl_items .select2-container .selection {
  width: 100% !important;
  min-width: 100% !important;
  max-width: 100% !important;
  display: block !important;
  box-sizing: border-box !important;
}
#tbl_items .select2-container--default .select2-selection--single {
  width: 100% !important;
  min-width: 100% !important;
  max-width: 100% !important;
  display: block !important;
  box-sizing: border-box !important;
  height: 34px !important;
  line-height: 32px !important;
  border-radius: 6px !important;
  border: 1px solid #cbd5e1 !important;
  position: relative !important;
  padding: 0 8px !important;
}
#tbl_items .select2-container--default .select2-selection--single .select2-selection__rendered {
  width: 100% !important;
  display: block !important;
  line-height: 32px !important;
  font-size: 12px !important;
  padding-left: 0 !important;
  padding-right: 32px !important;
  box-sizing: border-box !important;
  text-overflow: ellipsis !important;
  overflow: hidden !important;
  white-space: nowrap !important;
}
#tbl_items .select2-container--default .select2-selection--single .select2-selection__clear {
  position: absolute !important;
  right: 22px !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
  font-size: 14px !important;
  color: #94a3b8 !important;
  line-height: 1 !important;
}
#tbl_items .select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 34px !important;
  width: 22px !important;
  position: absolute !important;
  top: 0 !important;
  right: 4px !important;
}
.btn-delete-row {
  height: 34px !important;
  width: 34px !important;
  padding: 0 !important;
  border-radius: 6px !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  background: #fef2f2 !important;
  border: 1px solid #fecaca !important;
  color: #ef4444 !important;
  font-size: 14px !important;
  transition: all 0.15s ease !important;
  cursor: pointer;
}
.btn-delete-row:hover, .btn-delete-row:active {
  background: #ef4444 !important;
  border-color: #dc2626 !important;
  color: #ffffff !important;
  transform: translateY(-1px);
  box-shadow: 0 2px 6px rgba(239,68,68,0.25);
}
.satuan-badge {
  background: #f8fafc;
  color: #475569;
  border: 1px solid #cbd5e1;
  font-size: 11.5px;
  font-weight: 700;
  height: 34px;
  line-height: 32px;
  display: block;
  border-radius: 6px;
  text-align: center;
  box-sizing: border-box;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}
/* Tanggal form controls */
#tanggal_so {
  height: 36px !important;
  border-radius: 6px !important;
  border: 1px solid #cbd5e1 !important;
  font-size: 13px !important;
  font-weight: 600 !important;
  padding-right: 24px !important;
  transition: all .15s ease !important;
}
#tanggal_so:focus {
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.12) !important;
}
/* Row flash highlight on scan */
@keyframes rowFlashEffect {
  0% { background-color: #bbf7d0 !important; }
  100% { background-color: transparent !important; }
}
.row-flash {
  animation: rowFlashEffect 1.2s ease-out !important;
}
/* Pelanggan column overflow fix */
.col-pelanggan-wrap .select2-container {
  max-width: 100% !important;
}
.col-pelanggan-wrap {
  overflow: hidden !important;
}
/* Modern POS Styles */
.pos-card {
  border-radius: 10px !important;
  border: 1px solid #e2e8f0 !important;
  box-shadow: 0 4px 16px rgba(0,0,0,0.04) !important;
  margin-bottom: 20px;
}
.pos-card .box-header {
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  padding: 12px 18px;
}
.table-pos {
  margin-bottom: 0;
  width: 100% !important;
  table-layout: fixed !important;
  border-collapse: separate !important;
  border-spacing: 0 !important;
}
.table-pos th {
  background: #f8fafc !important;
  color: #334155 !important;
  font-weight: 700 !important;
  font-size: 11px !important;
  text-transform: uppercase !important;
  letter-spacing: 0.4px !important;
  padding: 10px 6px !important;
  border-top: none !important;
  border-bottom: 2px solid #cbd5e1 !important;
  border-left: none !important;
  border-right: 1px solid #e2e8f0 !important;
  white-space: nowrap !important;
  vertical-align: middle !important;
}
.table-pos th:last-child {
  border-right: none !important;
}
.table-pos td {
  padding: 6px 4px !important;
  vertical-align: middle !important;
  background: #ffffff !important;
  border-top: 1px solid #f1f5f9 !important;
  border-bottom: 1px solid #f1f5f9 !important;
  border-left: none !important;
  border-right: 1px solid #f1f5f9 !important;
}
.table-pos td:last-child {
  border-right: none !important;
}
.table-pos tbody tr:hover td {
  background: #f8fafc !important;
}
.table-pos .form-control {
  height: 34px !important;
  font-size: 12.5px !important;
  font-weight: 600 !important;
  color: #1e293b !important;
  background-color: #ffffff !important;
  border: 1px solid #cbd5e1 !important;
  border-radius: 6px !important;
  padding: 4px 6px !important;
  box-shadow: none !important;
  transition: all .15s ease !important;
}
.table-pos .form-control:focus {
  border-color: #3b82f6 !important;
  box-shadow: 0 0 0 2px rgba(59,130,246,0.15) !important;
}

@media (max-width: 767px) {
  #tbl_items {
    min-width: 700px !important;
  }
}
@media (min-width: 768px) {
  #tbl_items {
    width: 100% !important;
    min-width: 0 !important;
  }
}

/* Remove spin buttons from number inputs inside table to prevent text clipping */
.table-pos input[type=number]::-webkit-inner-spin-button, 
.table-pos input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none !important; 
  margin: 0 !important; 
}
.table-pos input[type=number] {
  -moz-appearance: textfield !important;
}

.sticky-checkout {
  position: -webkit-sticky;
  position: sticky;
  top: 20px;
}

/* Mobile & Responsive Rules */
.table-responsive {
  width: 100% !important;
  overflow-x: auto !important;
  -webkit-overflow-scrolling: touch !important;
  margin-bottom: 0 !important;
  border: none !important;
}

/* Custom scrollbar for horizontal table */
.table-responsive::-webkit-scrollbar {
  height: 6px;
}
.table-responsive::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}

/* Floating Mobile Checkout Bar */
.mobile-sticky-bar {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  border-top: 1px solid #cbd5e1;
  box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
  padding: 10px 16px;
  padding-bottom: calc(10px + env(safe-area-inset-bottom, 0px));
  z-index: 1040;
  display: none;
}

@media (max-width: 991px) {
  .checkout-options-col {
    border-right: none !important;
    border-bottom: 1px solid #e2e8f0 !important;
    padding-right: 15px !important;
    padding-bottom: 20px !important;
    margin-bottom: 20px !important;
  }
  .checkout-pay-col {
    padding-left: 15px !important;
  }
  .sticky-checkout {
    position: static !important;
    margin-top: 16px !important;
  }
  .pos-card {
    margin-bottom: 16px !important;
  }
  .mobile-sticky-bar {
    display: block !important;
  }
  .content {
    padding-bottom: 90px !important;
  }
}

@media (min-width: 992px) {
  .mobile-sticky-bar {
    display: none !important;
  }
}

@media (max-width: 767px) {
  .content-header h1 {
    font-size: 18px !important;
    line-height: 1.3 !important;
  }
  .content-header h1 small {
    display: block !important;
    font-size: 11.5px !important;
    margin-top: 2px !important;
  }
  .content-header h1 .label {
    display: inline-block !important;
    margin-top: 6px !important;
    margin-left: 0 !important;
  }
  .breadcrumb {
    position: static !important;
    padding: 6px 0 !important;
    margin-bottom: 10px !important;
    background: transparent !important;
  }
  .pos-card .box-header {
    padding: 10px 14px !important;
  }
  .pos-card .box-title {
    font-size: 13px !important;
  }
  #btn_add_item {
    font-size: 11.5px !important;
    padding: 5px 10px !important;
  }
  #display_grand_total_big {
    font-size: 26px !important;
  }
  .table-pos th {
    font-size: 10.5px !important;
    padding: 8px 4px !important;
  }
  .table-pos td {
    padding: 5px 3px !important;
  }
  .table-pos .form-control {
    font-size: 12px !important;
    padding: 4px 5px !important;
  }
  .col-pelanggan-wrap, .col-sm-3 {
    margin-bottom: 10px !important;
  }
  #customer_info_chip > div {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 8px !important;
  }
  #btn_edit_cust_chip {
    width: 100% !important;
    min-height: 32px !important;
    text-align: center !important;
  }

  /* Responsive Modal Nota Kasir on Mobile */
  #modal_nota_kasir .modal-dialog {
    margin: 8px auto !important;
    width: calc(100% - 16px) !important;
    max-width: 100% !important;
  }
  #modal_nota_kasir .modal-header {
    padding: 10px 14px !important;
  }
  #modal_nota_kasir .modal-title {
    font-size: 13.5px !important;
  }
  #modal_nota_kasir .modal-body {
    padding: 10px 10px !important;
    max-height: 60vh !important;
  }
  #modal_nota_kasir .modal-footer {
    padding: 10px 12px !important;
    gap: 8px !important;
    display: flex !important;
    flex-wrap: wrap !important;
  }
  #modal_nota_tabs_wrap {
    flex-wrap: wrap !important;
    gap: 6px !important;
  }
  #btn_modal_print_bluetooth {
    flex: 1 1 100% !important;
    min-width: 100% !important;
    min-height: 44px !important;
    font-size: 13px !important;
    padding: 10px 14px !important;
    order: 1 !important;
  }
  #btn_modal_main_selesai {
    flex: 1 1 100% !important;
    min-width: 100% !important;
    min-height: 44px !important;
    font-size: 13px !important;
    padding: 10px 14px !important;
    order: 2 !important;
  }
  #btn_modal_print_browser {
    flex: 1 1 calc(50% - 4px) !important;
    min-width: 0 !important;
    min-height: 40px !important;
    font-size: 11.5px !important;
    padding: 8px 6px !important;
    order: 3 !important;
    text-align: center !important;
  }
  #btn_modal_batal {
    flex: 1 1 calc(50% - 4px) !important;
    min-width: 0 !important;
    min-height: 40px !important;
    font-size: 11.5px !important;
    padding: 8px 6px !important;
    order: 4 !important;
    text-align: center !important;
  }
  #bt_status_bar {
    flex-direction: column !important;
    align-items: stretch !important;
    gap: 8px !important;
    padding: 10px !important;
  }
  #bt_status_bar > div:last-child {
    width: 100% !important;
    display: flex !important;
    gap: 6px !important;
  }
  #btn_bt_pair, #btn_bt_unpair {
    flex: 1 1 auto !important;
    min-height: 36px !important;
    font-size: 11.5px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
  }
  #btn_modal_print_pdf {
    min-height: 30px !important;
    font-size: 11px !important;
    display: inline-flex !important;
    align-items: center !important;
    padding: 4px 10px !important;
  }
  #container_preview_lebar {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
  }
  #receipt_preview_paper {
    padding: 12px 10px !important;
    font-size: 11px !important;
    word-break: break-word !important;
  }
  #receipt_preview_lebar {
    padding: 12px 10px !important;
    font-size: 10px !important;
    min-width: 500px !important;
  }

  /* Responsive Modal Pelanggan Baru on Mobile */
  #modal_add_pelanggan .modal-dialog {
    margin: 8px auto !important;
    width: calc(100% - 16px) !important;
    max-width: 100% !important;
  }
  #modal_add_pelanggan .modal-header {
    padding: 12px 14px !important;
  }
  #modal_add_pelanggan .modal-body {
    padding: 14px 14px !important;
  }
  #modal_add_pelanggan .modal-footer {
    padding: 10px 14px !important;
    display: flex !important;
    gap: 8px !important;
  }
  #modal_add_pelanggan .modal-footer button {
    flex: 1 1 50% !important;
    min-height: 40px !important;
  }
}

/* ==========================================================
   MODERN POS TOP TOOLBAR & TRANSAKSI TERAKHIR STYLES
   ========================================================== */
.pos-top-toolbar {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 10px !important;
  box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04) !important;
  padding: 10px 16px !important;
  margin-bottom: 16px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
  flex-wrap: wrap !important;
  gap: 12px !important;
}
.pos-top-left {
  display: flex !important;
  align-items: center !important;
  gap: 10px !important;
  flex-wrap: wrap !important;
}
.pos-badge-mode {
  background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
  color: #ffffff !important;
  font-weight: 700 !important;
  font-size: 11.5px !important;
  letter-spacing: 0.3px !important;
  padding: 6px 14px !important;
  border-radius: 20px !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 6px !important;
  box-shadow: 0 2px 6px rgba(5, 150, 105, 0.25) !important;
}
.pos-badge-mode .pos-mode-icon {
  color: #fef08a !important;
  animation: pulseBolt 2s infinite !important;
}
@keyframes pulseBolt {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.75; transform: scale(1.15); }
}
.pos-top-features {
  display: inline-flex !important;
  align-items: center !important;
  gap: 6px !important;
  color: #64748b !important;
  font-size: 11.5px !important;
  font-weight: 500 !important;
}
.pos-feat-item {
  display: inline-flex !important;
  align-items: center !important;
  gap: 4px !important;
  background: #f8fafc !important;
  border: 1px solid #e2e8f0 !important;
  padding: 4px 8px !important;
  border-radius: 6px !important;
  color: #334155 !important;
  font-size: 11px !important;
  font-weight: 600 !important;
}
.pos-feat-item i {
  color: #10b981 !important;
}

.pos-top-right {
  display: flex !important;
  align-items: center !important;
  gap: 8px !important;
  flex-wrap: wrap !important;
}
.btn-pos-history {
  background: #f8fafc !important;
  border: 1px solid #cbd5e1 !important;
  color: #0f172a !important;
  font-weight: 600 !important;
  font-size: 12px !important;
  padding: 6px 14px !important;
  border-radius: 8px !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 7px !important;
  cursor: pointer !important;
  transition: all 0.2s ease !important;
  outline: none !important;
}
.btn-pos-history:hover, .btn-pos-history.active {
  background: #0f172a !important;
  color: #ffffff !important;
  border-color: #0f172a !important;
  box-shadow: 0 3px 10px rgba(15, 23, 42, 0.15) !important;
}
.btn-pos-history:hover .badge-history-count, .btn-pos-history.active .badge-history-count {
  background: #10b981 !important;
  color: #ffffff !important;
}
.btn-pos-history:hover .chevron-history, .btn-pos-history.active .chevron-history {
  color: #cbd5e1 !important;
}
.badge-history-count {
  background: #e2e8f0 !important;
  color: #0f172a !important;
  font-size: 10px !important;
  font-weight: 700 !important;
  padding: 2px 7px !important;
  border-radius: 12px !important;
  transition: all 0.2s ease !important;
}
.chevron-history {
  font-size: 10px !important;
  color: #64748b !important;
  transition: transform 0.25s ease !important;
}
.btn-pos-history.active .chevron-history {
  transform: rotate(180deg) !important;
}

.btn-pos-nav-link {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  color: #475569 !important;
  font-weight: 600 !important;
  font-size: 11.5px !important;
  padding: 6px 12px !important;
  border-radius: 8px !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 5px !important;
  text-decoration: none !important;
  transition: all 0.15s ease !important;
}
.btn-pos-nav-link:hover {
  background: #f1f5f9 !important;
  color: #0f172a !important;
  border-color: #cbd5e1 !important;
}

/* ==========================================================
   COLLAPSIBLE TRANSAKSI TERAKHIR PANEL
   ========================================================== */
.pos-history-panel {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 12px !important;
  box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05) !important;
  margin-bottom: 18px !important;
  padding: 14px 18px !important;
  transition: all 0.2s ease !important;
}
.pos-history-header {
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
  margin-bottom: 12px !important;
  padding-bottom: 10px !important;
  border-bottom: 1px solid #f1f5f9 !important;
  flex-wrap: wrap !important;
  gap: 8px !important;
}
.pos-history-title-group {
  display: flex !important;
  align-items: center !important;
  gap: 8px !important;
}
.pos-history-title {
  font-size: 13px !important;
  font-weight: 700 !important;
  color: #0f172a !important;
  display: flex !important;
  align-items: center !important;
  gap: 6px !important;
}
.pos-history-title i {
  color: #059669 !important;
}
.pos-history-live-pill {
  background: #ecfdf5 !important;
  color: #047857 !important;
  border: 1px solid #a7f3d0 !important;
  font-size: 10px !important;
  font-weight: 600 !important;
  padding: 2px 7px !important;
  border-radius: 10px !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 4px !important;
}
.pos-history-live-dot {
  width: 6px !important;
  height: 6px !important;
  border-radius: 50% !important;
  background: #10b981 !important;
  display: inline-block !important;
  animation: livePulse 1.5s infinite !important;
}
@keyframes livePulse {
  0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
  70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
  100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

.pos-history-header-actions {
  display: flex !important;
  align-items: center !important;
  gap: 8px !important;
}
.view-switch-group {
  display: inline-flex !important;
  background: #f1f5f9 !important;
  border-radius: 6px !important;
  padding: 2px !important;
  border: 1px solid #e2e8f0 !important;
}
.btn-view-toggle {
  background: transparent !important;
  border: none !important;
  padding: 3px 8px !important;
  border-radius: 4px !important;
  color: #64748b !important;
  font-size: 11px !important;
  cursor: pointer !important;
  transition: all 0.15s ease !important;
}
.btn-view-toggle.active {
  background: #ffffff !important;
  color: #0f172a !important;
  box-shadow: 0 1px 3px rgba(0,0,0,0.08) !important;
}
.link-see-all-orders {
  font-size: 11.5px !important;
  font-weight: 600 !important;
  color: #059669 !important;
  text-decoration: none !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 4px !important;
  margin-left: 6px !important;
}
.link-see-all-orders:hover {
  color: #047857 !important;
  text-decoration: underline !important;
}
.btn-close-history-panel {
  background: #f8fafc !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 6px !important;
  width: 26px !important;
  height: 26px !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  color: #94a3b8 !important;
  cursor: pointer !important;
  margin-left: 4px !important;
  transition: all 0.15s ease !important;
}
.btn-close-history-panel:hover {
  background: #fee2e2 !important;
  color: #ef4444 !important;
  border-color: #fca5a5 !important;
}

/* ==========================================================
   CARDS GRID VIEW
   ========================================================== */
.pos-history-cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(225px, 1fr));
  gap: 12px;
}
#wrapper_cards_rekap[style*="display: none"],
#wrapper_cards_rekap.is-hidden,
.pos-history-cards-grid[style*="display: none"],
.pos-history-cards-grid.is-hidden {
  display: none !important;
}
#wrapper_tabel_rekap[style*="display: none"],
#wrapper_tabel_rekap.is-hidden {
  display: none !important;
}
.pos-trx-card {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 10px !important;
  padding: 12px 14px !important;
  box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03) !important;
  display: flex !important;
  flex-direction: column !important;
  justify-content: space-between !important;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
  position: relative !important;
  overflow: hidden !important;
}
.pos-trx-card:hover {
  transform: translateY(-2px) !important;
  border-color: #cbd5e1 !important;
  box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08) !important;
}
.pos-trx-card::before {
  content: '' !important;
  position: absolute !important;
  top: 0 !important;
  left: 0 !important;
  width: 3.5px !important;
  height: 100% !important;
  background: #059669 !important;
  border-radius: 3px 0 0 3px !important;
}
.pos-trx-card.card-new-arrival {
  animation: newTrxHighlight 2.5s ease-out !important;
}
@keyframes newTrxHighlight {
  0% { background: #d1fae5 !important; border-color: #10b981 !important; }
  100% { background: #ffffff !important; border-color: #e2e8f0 !important; }
}

.pos-trx-top {
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
  margin-bottom: 8px !important;
}
.pos-trx-so-badge {
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
  font-size: 11px !important;
  font-weight: 700 !important;
  color: #1e293b !important;
  background: #f1f5f9 !important;
  border: 1px solid #e2e8f0 !important;
  padding: 2px 7px !important;
  border-radius: 5px !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 4px !important;
}
.pos-trx-time {
  font-size: 11px !important;
  color: #64748b !important;
  display: inline-flex !important;
  align-items: center !important;
  gap: 4px !important;
}

.pos-trx-cust-row {
  display: flex !important;
  align-items: center !important;
  gap: 8px !important;
  margin-bottom: 10px !important;
}
.pos-trx-avatar {
  width: 28px !important;
  height: 28px !important;
  border-radius: 50% !important;
  background: #ecfdf5 !important;
  color: #059669 !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  font-size: 12px !important;
  flex-shrink: 0 !important;
}
.pos-trx-cust-info {
  min-width: 0 !important;
  flex: 1 !important;
}
.pos-trx-cust-name {
  font-size: 12px !important;
  font-weight: 600 !important;
  color: #0f172a !important;
  white-space: nowrap !important;
  overflow: hidden !important;
  text-overflow: ellipsis !important;
}
.pos-trx-cust-date {
  font-size: 10.5px !important;
  color: #94a3b8 !important;
}

.pos-trx-amount-box {
  background: #f8fafc !important;
  border: 1px solid #f1f5f9 !important;
  border-radius: 8px !important;
  padding: 6px 10px !important;
  margin-bottom: 10px !important;
  display: flex !important;
  align-items: baseline !important;
  justify-content: space-between !important;
}
.pos-trx-amount-label {
  font-size: 10px !important;
  color: #64748b !important;
  text-transform: uppercase !important;
  font-weight: 600 !important;
  letter-spacing: 0.3px !important;
}
.pos-trx-amount-value {
  font-size: 14px !important;
  font-weight: 800 !important;
  color: #059669 !important;
  letter-spacing: -0.3px !important;
}

.pos-trx-actions {
  display: grid !important;
  grid-template-columns: 1fr auto !important;
  gap: 6px !important;
}
.btn-trx-print {
  background: #0f172a !important;
  color: #ffffff !important;
  font-size: 11px !important;
  font-weight: 600 !important;
  padding: 6px 10px !important;
  border-radius: 6px !important;
  text-align: center !important;
  text-decoration: none !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 5px !important;
  transition: all 0.15s ease !important;
  border: 1px solid #0f172a !important;
}
.btn-trx-print:hover {
  background: #1e293b !important;
  color: #ffffff !important;
  transform: translateY(-1px) !important;
  box-shadow: 0 3px 8px rgba(15, 23, 42, 0.2) !important;
}
.btn-trx-detail {
  background: #ffffff !important;
  color: #334155 !important;
  border: 1px solid #cbd5e1 !important;
  font-size: 11px !important;
  font-weight: 600 !important;
  padding: 6px 10px !important;
  border-radius: 6px !important;
  text-align: center !important;
  text-decoration: none !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 4px !important;
  transition: all 0.15s ease !important;
}
.btn-trx-detail:hover {
  background: #f1f5f9 !important;
  color: #0f172a !important;
  border-color: #94a3b8 !important;
}

/* ==========================================================
   TABLE VIEW (Clean & Compact)
   ========================================================== */
.pos-history-table-wrap {
  overflow-x: auto !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 8px !important;
}
.pos-history-table {
  width: 100% !important;
  margin-bottom: 0 !important;
  font-size: 11.5px !important;
  border-collapse: collapse !important;
  background: #ffffff !important;
}
.pos-history-table th {
  background: #f8fafc !important;
  color: #475569 !important;
  font-weight: 700 !important;
  padding: 8px 12px !important;
  text-transform: uppercase !important;
  font-size: 10.5px !important;
  letter-spacing: 0.3px !important;
  border-bottom: 2px solid #e2e8f0 !important;
  white-space: nowrap !important;
}
.pos-history-table td {
  padding: 8px 12px !important;
  vertical-align: middle !important;
  border-bottom: 1px solid #f1f5f9 !important;
  color: #334155 !important;
}
.pos-history-table tbody tr:hover td {
  background: #f8fafc !important;
}
.pos-history-empty {
  text-align: center !important;
  padding: 24px 10px !important;
  color: #94a3b8 !important;
}
.pos-history-empty i {
  font-size: 28px !important;
  margin-bottom: 6px !important;
  color: #cbd5e1 !important;
  display: block !important;
}

/* ==========================================================
   MOBILE & RESPONSIVE TWEAKS FOR POS TOOLBAR & RIWAYAT
   ========================================================== */
@media (max-width: 767px) {
  .pos-top-toolbar {
    padding: 8px 10px !important;
    gap: 8px !important;
    margin-bottom: 12px !important;
  }
  .pos-top-left {
    width: 100% !important;
    justify-content: space-between !important;
  }
  .pos-badge-mode {
    font-size: 11px !important;
    padding: 5px 10px !important;
  }
  .pos-top-features {
    display: none !important;
  }
  .pos-top-right {
    width: 100% !important;
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 6px !important;
    justify-content: space-between !important;
  }
  #btn_top_bt_printer {
    flex: 1 1 calc(50% - 3px) !important;
    padding: 7px 8px !important;
    font-size: 11.5px !important;
    min-height: 38px !important;
    justify-content: center !important;
  }
  .btn-pos-history {
    flex: 1 1 calc(50% - 3px) !important;
    padding: 7px 8px !important;
    font-size: 11.5px !important;
    min-height: 38px !important;
    justify-content: center !important;
    gap: 5px !important;
  }
  .btn-pos-nav-link {
    flex: 1 1 calc(50% - 3px) !important;
    padding: 7px 8px !important;
    font-size: 11px !important;
    min-height: 36px !important;
    justify-content: center !important;
    text-align: center !important;
  }

  .pos-history-panel {
    padding: 10px 12px !important;
    margin-bottom: 14px !important;
    border-radius: 10px !important;
  }
  .pos-history-header {
    margin-bottom: 8px !important;
    padding-bottom: 8px !important;
    gap: 6px !important;
  }
  .pos-history-title {
    font-size: 11.5px !important;
  }
  .pos-history-live-pill {
    font-size: 9px !important;
    padding: 1px 5px !important;
  }
  .link-see-all-orders {
    font-size: 10.5px !important;
  }
  .btn-close-history-panel {
    width: 26px !important;
    height: 26px !important;
    font-size: 11px !important;
  }

  /* Horizontal swipeable cards reel on mobile */
  .pos-history-cards-grid {
    display: flex;
    flex-direction: row;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scroll-snap-type: x mandatory;
    gap: 10px;
    padding-bottom: 8px;
    margin-bottom: 2px;
  }
  .pos-history-cards-grid::-webkit-scrollbar {
    height: 4px !important;
  }
  .pos-history-cards-grid::-webkit-scrollbar-thumb {
    background: #cbd5e1 !important;
    border-radius: 4px !important;
  }
  .pos-trx-card {
    flex: 0 0 250px !important;
    min-width: 250px !important;
    max-width: 260px !important;
    scroll-snap-align: start !important;
    padding: 10px 12px !important;
    margin-bottom: 0 !important;
  }
  .btn-trx-print, .btn-trx-detail {
    min-height: 36px !important;
    font-size: 11px !important;
    padding: 6px 8px !important;
  }

  /* Compact Table on mobile */
  .pos-history-table th, .pos-history-table td {
    padding: 6px 8px !important;
    font-size: 10.5px !important;
  }
}

@media (max-width: 480px) {
  .pos-top-toolbar {
    padding: 6px 8px !important;
  }
  .pos-badge-mode {
    font-size: 10px !important;
    padding: 4px 8px !important;
  }
  .btn-pos-history {
    font-size: 11px !important;
    padding: 6px 4px !important;
  }
  .badge-history-count {
    padding: 1px 5px !important;
    font-size: 9.5px !important;
  }
  .btn-pos-nav-link {
    padding: 6px 4px !important;
    font-size: 10.5px !important;
  }
  .pos-trx-card {
    flex: 0 0 235px !important;
    min-width: 235px !important;
  }
  .pos-trx-amount-value {
    font-size: 13.5px !important;
  }
  #mobile_sticky_bar strong {
    font-size: 16px !important;
  }
  #btn_scroll_bayar {
    padding: 7px 12px !important;
    font-size: 11px !important;
  }
}
</style>

<section class="content-header">
   <h1>
      <i class="fa fa-bolt text-yellow"></i> Penjualan Cepat <small>POS &amp; Kasir Langsung Lunas</small>
      <span class="label label-success" style="font-size:11px; margin-left:8px; border-radius:10px; vertical-align:middle;">
         <i class="fa fa-check-circle"></i> Otomatis Lunas, Faktur, Stok, &amp; Kas
      </span>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= base_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= base_url('administrator/sales_order'); ?>">Penjualan</a></li>
      <li class="active">Penjualan Cepat (POS)</li>
   </ol>
</section>

<section class="content">

<!-- Modern POS Top Toolbar -->
<div class="pos-top-toolbar">
   <div class="pos-top-left">
      <span class="pos-badge-mode">
         <i class="fa fa-bolt pos-mode-icon"></i> POS KASIR DIRECT
      </span>
      <div class="pos-top-features hidden-xs">
         <span class="pos-feat-item" title="Faktur Penjualan diterbitkan otomatis"><i class="fa fa-check-circle"></i> Auto-Faktur</span>
         <span class="pos-feat-item" title="Stok otomatis terpotong (FIFO/FEFO)"><i class="fa fa-check-circle"></i> Potong Stok</span>
         <span class="pos-feat-item" title="Bukti Kas Masuk (BKM) otomatis dicatat"><i class="fa fa-check-circle"></i> Kas BKM</span>
      </div>
   </div>
   <div class="pos-top-right">
      <button type="button" class="btn-pos-nav-link" id="btn_top_bt_printer" style="display:inline-flex; align-items:center; gap:6px; background:#f8fafc; border:1px solid #cbd5e1; color:#334155; font-weight:700; cursor:pointer;" title="Status Printer Bluetooth Thermal (Klik untuk Hubungkan / Ganti Printer)">
         <i class="fa fa-bluetooth" id="top_bt_icon" style="color:#2563eb; font-size:13px;"></i>
         <span class="hidden-xs" id="top_bt_label">Thermal BT</span>
         <span class="badge" id="top_bt_badge" style="background:#94a3b8; font-size:9px; padding:2px 6px; font-weight:700;">Belum Konek</span>
      </button>
      <button type="button" class="btn-pos-history" id="btn_toggle_riwayat" title="Tampilkan / Sembunyikan Riwayat Transaksi Kasir">
         <i class="fa fa-history text-primary"></i>
         <span class="hidden-xs">Riwayat Transaksi Kasir</span><span class="visible-xs-inline">Riwayat</span>
         <span class="badge-history-count" id="badge_count_rekap"><?= !empty($last_transactions) ? count($last_transactions) : 0; ?></span>
         <i class="fa fa-chevron-down chevron-history" id="icon_toggle_rekap"></i>
      </button>
      <a href="<?= site_url('administrator/sales_order/add'); ?>" class="btn-pos-nav-link" title="Beralih ke Formulir Transaksi Offline / Tempo">
         <i class="fa fa-file-text-o text-primary"></i> <span class="hidden-xs">Transaksi Offline &rarr;</span><span class="visible-xs-inline">Offline</span>
      </a>
      <a href="<?= site_url('administrator/sales_order'); ?>" class="btn-pos-nav-link" title="Buka Daftar Semua Penjualan">
         <i class="fa fa-list text-muted"></i> <span class="hidden-xs">Daftar Penjualan</span><span class="visible-xs-inline">Daftar</span>
      </a>
   </div>
</div>

<!-- Modern Collapsible History Panel (Hidden by default to focus on cashier input) -->
<div id="panel_riwayat_transaksi" class="pos-history-panel" style="display:none;">
   <div class="pos-history-header">
      <div class="pos-history-title-group">
         <span class="pos-history-title">
            <i class="fa fa-clock-o"></i> Riwayat Transaksi Kasir POS
         </span>
         <span class="pos-history-live-pill">
            <span class="pos-history-live-dot"></span> Live POS
         </span>
      </div>
      <div class="pos-history-header-actions">
         <div class="view-switch-group">
            <button type="button" class="btn-view-toggle active" id="btn_toggle_view_cards" title="Tampilan Kartu Modern">
               <i class="fa fa-th-large"></i>
            </button>
            <button type="button" class="btn-view-toggle" id="btn_toggle_view_table" title="Tampilan Tabel Compact">
               <i class="fa fa-list"></i>
            </button>
         </div>
         <a href="<?= site_url('administrator/sales_order'); ?>" class="link-see-all-orders">
            Lihat Semua Pesanan &rarr;
         </a>
         <button type="button" class="btn-close-history-panel" id="btn_close_panel_riwayat" title="Sembunyikan Panel Riwayat">
            <i class="fa fa-times"></i>
         </button>
      </div>
   </div>

   <!-- View 1: Modern Cards Grid -->
   <div id="wrapper_cards_rekap" class="pos-history-cards-grid">
      <?php if (!empty($last_transactions)): ?>
         <?php foreach($last_transactions as $lt): ?>
         <div class="pos-trx-card" id="card_trx_<?= $lt->id; ?>">
            <div class="pos-trx-top">
               <span class="pos-trx-so-badge">
                  <i class="fa fa-receipt text-muted"></i> <?= $lt->nomor_so; ?>
               </span>
               <span class="pos-trx-time" title="<?= date('d/m/Y H:i', strtotime($lt->created_at)); ?>">
                  <i class="fa fa-clock-o text-muted"></i> <?= date('H:i', strtotime($lt->created_at)); ?>
               </span>
            </div>
            <div class="pos-trx-cust-row">
               <div class="pos-trx-avatar">
                  <i class="fa fa-user"></i>
               </div>
               <div class="pos-trx-cust-info">
                  <div class="pos-trx-cust-name" title="<?= htmlspecialchars($lt->nama_pelanggan ?: 'Pelanggan Umum'); ?>">
                     <?= _ent($lt->nama_pelanggan ?: 'Pelanggan Umum'); ?>
                  </div>
                  <div class="pos-trx-cust-date"><?= date('d/m/Y', strtotime($lt->created_at)); ?></div>
               </div>
            </div>
            <div class="pos-trx-amount-box">
               <span class="pos-trx-amount-label">Total Bayar</span>
               <span class="pos-trx-amount-value">Rp <?= number_format((float)$lt->grand_total, 0, ',', '.'); ?></span>
            </div>
            <div class="pos-trx-actions">
               <a href="<?= site_url('administrator/sales_order/cetak_struk/' . $lt->id); ?>" class="btn-trx-print" title="Cetak Ulang Struk Kasir">
                  <i class="fa fa-print"></i> Cetak Struk
               </a>
               <a href="<?= site_url('administrator/sales_order/view/' . $lt->id); ?>" class="btn-trx-detail" title="Lihat Detail Transaksi">
                  <i class="fa fa-eye"></i> Detail
               </a>
            </div>
         </div>
         <?php endforeach; ?>
      <?php else: ?>
         <div class="pos-history-empty" id="empty_history_placeholder">
            <i class="fa fa-inbox"></i>
            <div>Belum ada riwayat transaksi kasir hari ini.</div>
         </div>
      <?php endif; ?>
   </div>

   <!-- View 2: Compact Table View (Alternative) -->
   <div id="wrapper_tabel_rekap" class="pos-history-table-wrap" style="display:none; margin-top:6px;">
      <table class="pos-history-table">
         <thead>
            <tr>
               <th>No. Transaksi Penjualan</th>
               <th>Tanggal &amp; Waktu</th>
               <th>Pelanggan</th>
               <th style="text-align:right;">Total Bayar</th>
               <th style="text-align:center;">Aksi Cepat</th>
            </tr>
         </thead>
         <tbody id="tbody_rekap_transaksi">
            <?php if (!empty($last_transactions)): ?>
               <?php foreach($last_transactions as $lt): ?>
               <tr id="row_trx_<?= $lt->id; ?>">
                  <td>
                     <span class="pos-trx-so-badge"><?= $lt->nomor_so; ?></span>
                  </td>
                  <td><i class="fa fa-clock-o text-muted"></i> <?= date('d/m/Y H:i', strtotime($lt->created_at)); ?></td>
                  <td style="font-weight:600; color:#0f172a;"><i class="fa fa-user-circle text-muted" style="margin-right:4px;"></i> <?= _ent($lt->nama_pelanggan ?: 'Pelanggan Umum'); ?></td>
                  <td style="text-align:right; font-weight:700; color:#059669;">Rp <?= number_format((float)$lt->grand_total, 0, ',', '.'); ?></td>
                  <td style="text-align:center; white-space:nowrap;">
                     <a href="<?= site_url('administrator/sales_order/cetak_struk/' . $lt->id); ?>" class="btn-trx-print" style="padding:4px 8px; font-size:10.5px;" title="Cetak Struk">
                        <i class="fa fa-print"></i> Cetak
                     </a>
                     <a href="<?= site_url('administrator/sales_order/view/' . $lt->id); ?>" class="btn-trx-detail" style="padding:4px 8px; font-size:10.5px; margin-left:4px;" title="Lihat Detail">
                        <i class="fa fa-eye"></i> Detail
                     </a>
                  </td>
               </tr>
               <?php endforeach; ?>
            <?php else: ?>
               <tr id="empty_row_rekap">
                  <td colspan="5" style="text-align:center; padding:15px; color:#94a3b8;">Belum ada riwayat transaksi kasir.</td>
               </tr>
            <?php endif; ?>
         </tbody>
      </table>
   </div>
</div>

<form id="form_so_cepat">
<div class="row">

   <!-- 1. KARTU ATAS: PELANGGAN & INFORMASI TRANSAKSI (col-md-12) -->
   <div class="col-md-12">

      <!-- Header & Konfigurasi Singkat -->
      <div class="box pos-card" style="border-top: 3px solid #10b981; margin-bottom: 16px;">
         <div class="box-header with-border" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; padding: 12px 18px; background: #fafcff;">
            <h3 class="box-title" style="font-weight: 700; color: #047857; font-size: 13.5px; margin:0; display:flex; align-items:center; gap:6px;">
               <i class="fa fa-user-circle text-success"></i> Pelanggan &amp; Tanggal Transaksi
            </h3>
            <span class="text-muted" style="font-size: 12px; font-weight: 600;">
               No. Transaksi Baru: <strong class="text-primary" id="display_nomor_so"><?= _ent($nomor_baru); ?></strong>
            </span>
         </div>
         <div class="box-body" style="padding: 14px 18px;">
            <div class="row">
               <div class="col-md-5 col-sm-6 col-xs-12 col-pelanggan-wrap">
                  <div class="form-group" style="margin-bottom: 8px;">
                     <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px; flex-wrap:wrap; gap:4px;">
                        <label style="margin:0; font-size:12px; font-weight:700;"><i class="fa fa-user text-primary"></i> Pelanggan <span class="text-danger">*</span></label>
                        <div>
                           <a href="javascript:void(0);" id="btn_refresh_pelanggan" class="text-success" style="font-size:11px; font-weight:600; margin-right:6px;" title="Segarkan daftar pelanggan">
                              <i class="fa fa-refresh"></i> Segarkan
                           </a>
                           <button type="button" id="btn_open_modal_cust" class="btn btn-xs btn-primary" style="font-size:11px; font-weight:700; border-radius:4px; padding:2px 8px;" title="Tambah Pelanggan Baru dengan No. HP & Alamat">
                              <i class="fa fa-user-plus"></i> + Input Data Pelanggan
                           </button>
                        </div>
                     </div>
                     <select class="form-control select2" name="pelanggan_id" id="pelanggan_id" required style="width:100%;">
                        <option value="">-- Ketik Nama Manual / Pilih Pelanggan --</option>
                        <?php foreach($pelanggans as $p): ?>
                           <?php 
                              $telp = $p->no_telp ?: $p->telepon;
                           ?>
                           <option value="<?= $p->id; ?>" 
                                   data-kode="<?= _ent($p->kode_pelanggan); ?>"
                                   data-nama="<?= _ent($p->nama_pelanggan); ?>"
                                   data-tipe="<?= _ent($p->tipe_pelanggan); ?>"
                                   data-telp="<?= _ent($telp); ?>"
                                   data-alamat="<?= _ent($p->alamat); ?>"
                                   data-kota="<?= _ent($p->kota); ?>">
                              <?= _ent($p->nama_pelanggan); ?><?= !empty($telp) ? ' ('.$telp.')' : ''; ?>
                           </option>
                        <?php endforeach; ?>
                     </select>
                     <!-- Hidden Inputs untuk Merekap Data Pelanggan Lengkap -->
                     <input type="hidden" name="customer_telepon" id="cust_input_telepon" value="">
                     <input type="hidden" name="customer_alamat" id="cust_input_alamat" value="">
                     <input type="hidden" name="customer_kota" id="cust_input_kota" value="">
                     <input type="hidden" name="customer_tipe" id="cust_input_tipe" value="">
                  </div>
               </div>

               <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group" style="margin-bottom: 8px;">
                     <label style="font-size:12px; font-weight:700; margin-bottom:4px; display:block;"><i class="fa fa-calendar text-primary"></i> Tanggal Penjualan</label>
                     <input type="date" class="form-control" name="tanggal_so" id="tanggal_so" value="<?= date('Y-m-d'); ?>" required style="height:36px; border-radius:6px; font-weight:600;">
                  </div>
               </div>

               <div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="form-group" style="margin-bottom: 8px;">
                     <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                        <label style="font-size: 12px; font-weight: 700; color: #334155; margin:0;"><i class="fa fa-ticket text-primary"></i> No. Ref / Slip Transaksi</label>
                        <span class="label label-success" style="font-size:9.5px; font-weight:600; border-radius:4px;"><i class="fa fa-check"></i> Otomatis Urut</span>
                     </div>
                     <input type="text" class="form-control" name="nomor_referensi" id="nomor_referensi" value="<?= _ent($nomor_ref_baru ?? ''); ?>" style="font-weight:700; color:#1e40af; background:#f0fdf4; border:1px solid #86efac; border-radius:6px; height:36px;">
                  </div>
               </div>
            </div>

            <!-- Customer preview chip with quick edit / complete data -->
            <div id="customer_info_chip" style="display:none; background:#f0f9ff; border:1px solid #bae6fd; border-radius:6px; padding:8px 14px; font-size:12px; color:#0369a1; margin-top:8px;">
               <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                  <div>
                     <i class="fa fa-id-card-o text-primary"></i> <strong id="chip_cust_nama" style="font-size:13px; color:#0c4a6e;">-</strong> 
                     <span id="chip_cust_tipe" style="display:none;"></span>
                     &middot; <i class="fa fa-phone text-success"></i> <span id="chip_cust_telp" style="font-weight:600;">-</span>
                     <span id="chip_cust_alamat_wrapper" style="display:none;">
                        &middot; <i class="fa fa-map-marker text-danger"></i> <span id="chip_cust_alamat" style="color:#475569;">-</span>
                     </span>
                  </div>
                  <div>
                     <button type="button" id="btn_edit_cust_chip" class="btn btn-xs btn-default" style="font-size:11px; font-weight:600; border-radius:4px; color:#0284c7; border-color:#93c5fd; background:#fff;">
                        <i class="fa fa-pencil text-primary"></i> Lengkapi / Ubah Data Pelanggan
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- 2. KARTU TENGAH: KERANJANG ITEM PESANAN FULL WIDTH (col-md-12) -->
   <div class="col-md-12">

      <!-- Item Keranjang Penjualan -->
      <div class="box pos-card" style="border-top: 3px solid #3b82f6;">
         <div class="box-header with-border" style="display:flex; justify-content:space-between; align-items:center; padding: 12px 18px; background: #ffffff;">
            <h3 class="box-title" style="font-weight: 700; color: #1e293b; font-size: 14px; margin:0; display:flex; align-items:center; gap:8px;">
               <i class="fa fa-shopping-cart text-primary" style="font-size:16px;"></i> Keranjang Item Pesanan
            </h3>
            <button type="button" id="btn_add_item" class="btn btn-sm btn-success" style="border-radius:6px; font-weight:700; padding:6px 14px; background:#059669; border-color:#047857; box-shadow:0 2px 6px rgba(5,150,105,0.25);">
               <i class="fa fa-plus-circle"></i> + Tambah Item Manual
            </button>
         </div>
         <div class="box-body" style="padding: 0;">
            <div class="visible-xs visible-sm" style="padding: 6px 14px; background: #f8fafc; font-size: 11px; color: #64748b; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
               <span><i class="fa fa-arrows-h text-primary"></i> <i>Geser tabel ke samping untuk rincian item &amp; subtotal</i></span>
               <span class="label label-default" style="font-size: 9px;"><i class="fa fa-hand-o-right"></i> Scroll</span>
            </div>
            <div class="table-responsive" style="overflow-x: auto; border: none; margin-bottom: 0;">
               <table class="table table-pos" id="tbl_items" style="width:100%; margin-bottom:0;">
                  <colgroup>
                     <col style="width: 32%;">
                     <col style="width: 8%;">
                     <col style="width: 8%;">
                     <col style="width: 16%;">
                     <col style="width: 7%;">
                     <col style="width: 17%;">
                     <col style="width: 7%;">
                     <col style="width: 5%;">
                  </colgroup>
                  <thead>
                     <tr>
                        <th style="text-align: left; padding: 10px 10px;"><i class="fa fa-cubes text-primary" style="margin-right:4px;"></i> PRODUK</th>
                        <th class="text-center" style="padding: 10px 4px;">QTY</th>
                        <th class="text-center" style="padding: 10px 4px;">SATUAN</th>
                        <th class="text-right" style="padding: 10px 8px;">HARGA JUAL</th>
                        <th class="text-center" style="padding: 10px 4px;">DISC%</th>
                        <th class="text-right" style="padding: 10px 8px;">SUBTOTAL</th>
                        <th class="text-center" style="padding: 10px 4px;">STOK</th>
                        <th class="text-center" style="padding: 10px 4px;"><i class="fa fa-trash-o text-muted"></i></th>
                     </tr>
                  </thead>
                  <tbody id="item_rows">
                     <tr id="item_row_0" class="item-row" data-row="0">
                        <td style="padding: 6px 8px; vertical-align: middle;">
                           <select class="form-control produk-select" name="items[0][produk_id]" required style="width:100%;">
                              <option value="">-- Cari / Pilih Produk --</option>
                              <?php foreach($produks as $p): 
                                 $stok_num = (float)($p->stok_qty ?? 0);
                              ?>
                                 <option value="<?= $p->id; ?>" data-harga="<?= $p->harga_jual; ?>" data-stok="<?= $stok_num; ?>">
                                    <?= _ent($p->kode_produk.' - '.$p->nama_produk.' [Stok: '.$stok_num.']'); ?>
                                 </option>
                              <?php endforeach; ?>
                           </select>
                        </td>
                        <td style="padding: 6px 4px; vertical-align: middle; text-align: center;">
                           <input type="number" step="any" min="0.01" class="form-control qty-input text-center" name="items[0][qty]" value="1" required style="font-weight:700;">
                        </td>
                        <td style="padding: 6px 4px; vertical-align: middle; text-align: center;">
                           <span class="satuan-badge">Pcs</span>
                           <input type="hidden" name="items[0][satuan]" value="Pcs">
                        </td>
                        <td style="padding: 6px 6px; vertical-align: middle; text-align: right;">
                           <input type="text" class="form-control harga-input text-right" name="items[0][harga_satuan]" value="0" required style="font-weight:700; color:#1e293b;">
                        </td>
                        <td style="padding: 6px 4px; vertical-align: middle; text-align: center;">
                           <input type="number" step="1" min="0" max="100" class="form-control disc-input text-center" name="items[0][diskon_persen]" value="0" style="font-weight:600; color:#dc2626;">
                        </td>
                        <td style="padding: 6px 6px; vertical-align: middle; text-align: right;">
                           <input type="text" class="form-control subtotal-display text-right" value="Rp 0" data-subtotal="0" readonly style="font-weight:800; color:#059669; background:#ecfdf5; border:1px solid #86efac; cursor:default;">
                        </td>
                        <td style="padding: 6px 3px; vertical-align: middle; text-align: center;">
                           <span class="stok-display badge bg-gray" style="font-size:11px; padding:4px 6px; border-radius:12px; font-weight:700; display:inline-block; min-width:32px;">-</span>
                        </td>
                        <td style="padding: 6px 4px; vertical-align: middle; text-align: center;">
                           <button type="button" class="btn btn-sm btn-delete-row remove-row" title="Hapus / Kosongkan Baris">
                              <i class="fa fa-trash-o"></i>
                           </button>
                        </td>
                     </tr>
                  </tbody>
                  <tfoot>
                     <tr style="background: #f8fafc; border-top: 2px solid #cbd5e1;">
                        <td colspan="3" style="padding: 12px 16px; vertical-align: middle; background: #f8fafc !important; border-top: 2px solid #cbd5e1 !important;">
                           <div style="display: flex; align-items: center; gap: 10px;">
                              <span style="font-size: 13px; font-weight: 700; color: #475569; display: flex; align-items: center; gap: 6px;">
                                 <i class="fa fa-shopping-basket text-primary" style="font-size: 14px;"></i> Total Ringkasan:
                              </span>
                              <strong id="count_items_label" class="label label-primary" style="font-size: 12px; padding: 5px 12px; border-radius: 12px; font-weight: 700; background: #0284c7; box-shadow: 0 1px 3px rgba(2,132,199,0.2);">0 Item (0 pcs)</strong>
                              <span id="count_items" style="display:none;">0</span>
                           </div>
                        </td>
                        <td colspan="5" class="text-right" style="padding: 10px 16px; vertical-align: middle; background: #f8fafc !important; border-top: 2px solid #cbd5e1 !important;">
                           <div style="display: inline-flex; align-items: center; justify-content: flex-end; gap: 10px; flex-wrap: nowrap;">
                              <span id="footer_gross_wrap" style="display:none; font-size: 12px; font-weight: 600; color: #64748b; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 10px; white-space: nowrap;">
                                 Total Bruto: <b id="footer_gross_val" style="color:#334155;">Rp 0</b>
                              </span>
                              <span id="footer_item_disc_wrap" style="display:none; font-size: 12px; font-weight: 700; color: #dc2626; background: #fee2e2; border: 1px solid #fecaca; border-radius: 6px; padding: 6px 10px; white-space: nowrap;">
                                 <i class="fa fa-tag"></i> Diskon Item: <b id="footer_item_disc_val">Rp 0</b>
                              </span>
                              <span style="font-size: 13px; font-weight: 700; color: #334155; white-space: nowrap;">
                                 Subtotal Keranjang:
                              </span>
                              <div style="background: #ecfdf5; border: 1.5px solid #86efac; border-radius: 8px; padding: 6px 18px; font-weight: 800; font-size: 15px; color: #059669; text-align: right; white-space: nowrap; box-shadow: 0 1px 4px rgba(5,150,105,0.12); min-width: 140px;">
                                 <span id="display_subtotal_items">Rp 0</span>
                              </div>
                           </div>
                        </td>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>
   </div>

   <!-- 3. KARTU BAWAH: TERMINAL PEMBAYARAN KASIR (col-md-12) -->
   <div class="col-md-12" id="terminal_kasir">
      <div class="box pos-card" style="border-top: 3px solid #059669; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 14px rgba(0,0,0,0.06);">
         <div class="box-header with-border" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; background: linear-gradient(135deg, #059669, #10b981); color: #ffffff; padding: 14px 20px; border-radius: 6px 6px 0 0;">
            <h3 class="box-title" style="font-weight: 700; color: #ffffff; font-size: 15px; margin:0; display:flex; align-items:center; gap:8px;">
               <i class="fa fa-money"></i> Terminal Pembayaran &amp; Checkout Kasir
            </h3>
            <div style="display:flex; align-items:center; gap:8px;">
               <button type="button" id="btn_cetak_ulang_last" class="btn btn-xs btn-default" style="display:none; font-weight:700; border-radius:4px; color:#047857; background:#ffffff; border-color:#ffffff;" title="Cetak ulang struk transaksi kasir terakhir">
                  <i class="fa fa-print"></i> Nota Terakhir
               </button>
               <span class="label" style="background:rgba(255,255,255,0.25); color:#fff; font-size:11px; padding: 4px 10px; border-radius:12px;">LUNAS DIRECT</span>
            </div>
         </div>
         
         <div class="box-body" style="padding: 22px;">
            <div class="row">
               <!-- Sub-Kolom Kiri: Diskon Global, Pajak, Metode Pembayaran & Catatan -->
               <div class="col-md-6 col-lg-6 checkout-options-col" style="border-right: 1px solid #e2e8f0; padding-right: 24px;">
                  <h4 style="font-size: 13.5px; font-weight: 700; color: #047857; margin-top: 0; margin-bottom: 16px; display: flex; align-items: center; gap: 6px;">
                     <i class="fa fa-sliders text-success"></i> Opsi Pembayaran &amp; Catatan
                  </h4>

                  <!-- Discount & Tax Row -->
                  <div class="row" style="margin-bottom: 14px;">
                     <div class="col-xs-6">
                        <div class="form-group" style="margin-bottom:0;">
                           <label style="font-size:12px; font-weight:700; color:#475569; margin-bottom:4px; display:block;">
                              <i class="fa fa-percent text-danger"></i> Diskon Tambahan Nota (%)
                           </label>
                           <input type="number" step="0.5" min="0" max="100" class="form-control" name="diskon_persen_total" id="diskon_persen_total" value="0" style="height:38px; border-radius:6px; font-weight:700;">
                           <input type="hidden" name="diskon_total" id="diskon_total" value="0">
                           <div style="margin-top:4px;">
                              <button type="button" id="btn_apply_disc_to_all" class="btn btn-xs btn-default" style="font-size:10.5px; border-radius:4px; color:#2563eb; border-color:#bfdbfe; font-weight:600; padding:2px 8px; background:#eff6ff;" title="Salin persen diskon ini ke seluruh item produk di tabel">
                                 <i class="fa fa-share"></i> Terapkan ke Semua Produk
                              </button>
                           </div>
                        </div>
                     </div>
                     <div class="col-xs-6">
                        <div class="form-group" style="margin-bottom:0;">
                           <label style="font-size:12px; font-weight:700; color:#475569; margin-bottom:4px; display:block;"><i class="fa fa-calculator text-primary"></i> Pajak PPN (%)</label>
                           <input type="number" step="1" min="0" class="form-control" name="pajak_persen" id="pajak_persen" value="0" style="height:38px; border-radius:6px; font-weight:700;">
                        </div>
                     </div>
                  </div>

                  <!-- Payment Method & Account -->
                  <div class="row" style="margin-bottom: 14px;">
                     <div class="col-xs-6">
                        <div class="form-group" style="margin-bottom:0;">
                           <label style="font-size: 12px; font-weight: 700; color: #334155;">
                              Metode Pembayaran <span class="text-danger">*</span>
                           </label>
                           <select class="form-control" name="metode_pembayaran" id="metode_pembayaran" style="font-weight: 700; height: 40px; border-radius:6px;">
                              <option value="tunai" selected>💵 Tunai (Cash Kasir)</option>
                              <option value="transfer_bank">🏦 Transfer Bank BCA</option>
                              <option value="transfer_mandiri">🏦 Transfer Bank Mandiri</option>
                              <option value="transfer_bri">🏦 Transfer Bank BRI / Lainnya</option>
                              <option value="qris">📱 QRIS / E-Wallet</option>
                              <option value="debit">💳 Kartu Debit / EDC</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-xs-6">
                        <div class="form-group" style="margin-bottom:0;">
                           <label style="font-size: 12px; font-weight: 700; color: #334155;">
                              Akun Kas / Bank <span class="text-danger">*</span>
                           </label>
                           <select class="form-control" name="akun_kas_bank" id="akun_kas_bank" style="font-weight: 600; height: 40px; border-radius:6px;">
                              <option value="Cash" selected>Cash</option>
                              <option value="Transfer Bank">Transfer Bank</option>
                           </select>
                        </div>
                     </div>
                  </div>

                  <!-- Catatan Kasir -->
                  <div class="form-group" style="margin-bottom: 12px;">
                     <label style="font-size: 12px; font-weight: 700; color: #475569;"><i class="fa fa-commenting-o text-muted"></i> Catatan Transaksi (Opsional)</label>
                     <input type="text" class="form-control" name="catatan" id="catatan" placeholder="Catatan transaksi penjualan cepat..." style="height:38px; border-radius:6px;">
                  </div>
               </div>

               <!-- Sub-Kolom Kanan: Total Pembayaran, Tunai & Tombol Checkout -->
               <div class="col-md-6 col-lg-6 checkout-pay-col" style="padding-left: 24px;">
                  <!-- Big Total Tagihan Card -->
                  <div style="background: #f0fdf4; border: 2px dashed #86efac; border-radius: 10px; padding: 14px 18px; text-align: center; margin-bottom: 16px;">
                     <span style="font-size: 12px; font-weight: 700; color: #166534; text-transform: uppercase; letter-spacing: 0.5px;">TOTAL YANG HARUS DIBAYAR:</span>
                     <div id="display_grand_total_big" style="font-size: 36px; font-weight: 900; color: #059669; line-height: 1.1; margin: 4px 0 6px 0;">
                        Rp 0
                     </div>
                     <div style="font-size: 12px; color: #475569; display:flex; justify-content:space-around; flex-wrap:wrap; gap:8px;">
                        <span>Subtotal Keranjang: <b id="text_subtotal_mini">Rp 0</b></span>
                        <span>Diskon Nota: <b id="text_disc_mini" class="text-muted">0%</b></span>
                        <span>Pajak: <b id="text_pajak_mini">0%</b></span>
                     </div>
                     <div id="text_item_disc_info" style="display:none; font-size:11.5px; color:#15803d; font-weight:600; margin-top:6px; padding-top:6px; border-top:1px dashed #bbf7d0;">
                        <i class="fa fa-check-circle"></i> Sudah termasuk hemat diskon item: <span id="text_item_disc_info_val" class="text-danger" style="font-weight:700;">-Rp 0</span>
                     </div>
                  </div>

                  <!-- Bagian Tunai: Uang Diterima & Kembalian -->
                  <div id="section_uang_tunai">
                     <div class="form-group" style="margin-bottom: 12px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                           <label style="font-size: 12px; font-weight: 700; color: #334155; margin:0;">
                              Nominal Uang Diterima (Rp) <span class="text-danger">*</span>
                           </label>
                           <!-- Quick Cash Preset Buttons -->
                           <div style="display:flex; gap:6px;">
                              <button type="button" class="btn btn-xs btn-quick-cash" data-cash="pas" style="border-radius:6px; font-weight:700; font-size:11px; padding:3px 8px; background:#f0fdf4; color:#059669; border:1px solid #86efac; cursor:pointer;" title="Bayar sesuai total pas">
                                 <i class="fa fa-check"></i> Uang Pas
                              </button>
                              <button type="button" class="btn btn-xs btn-quick-cash" data-cash="50000" style="border-radius:6px; font-weight:700; font-size:11px; padding:3px 8px; background:#f8fafc; color:#334155; border:1px solid #cbd5e1; cursor:pointer;">
                                 50.000
                              </button>
                              <button type="button" class="btn btn-xs btn-quick-cash" data-cash="100000" style="border-radius:6px; font-weight:700; font-size:11px; padding:3px 8px; background:#f8fafc; color:#334155; border:1px solid #cbd5e1; cursor:pointer;">
                                 100.000
                              </button>
                              <button type="button" class="btn btn-xs btn-quick-cash" data-cash="clear" style="border-radius:6px; font-weight:700; font-size:11px; padding:3px 8px; background:#fef2f2; color:#ef4444; border:1px solid #fecaca; cursor:pointer;" title="Kosongkan nominal uang diterima">
                                 <i class="fa fa-eraser"></i> Clear
                              </button>
                           </div>
                        </div>
                        <div class="input-group">
                           <span class="input-group-addon" style="font-weight: 700; background: #f8fafc; font-size:15px; border-radius:6px 0 0 6px;">Rp</span>
                           <input type="text" class="form-control" name="uang_diterima" id="uang_diterima" placeholder="0" style="font-size: 20px; font-weight: 800; color: #1e293b; height: 44px; border-radius:0 6px 6px 0;">
                        </div>
                     </div>

                     <!-- Box Kembalian -->
                     <div id="box_kembalian" style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 8px; padding: 10px 14px; margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 13px; font-weight: 700; color: #475569;"><i class="fa fa-calculator text-success"></i> Kembalian:</span>
                        <strong id="text_kembalian" style="font-size: 20px; color: #059669; font-weight: 800;">Rp 0</strong>
                     </div>
                  </div>

                  <!-- Tombol Selesaikan & Bayar Lunas -->
                  <button type="button" id="btn_submit_cepat" class="btn btn-success btn-block btn-lg" style="font-weight: 800; font-size: 15px; padding: 12px; background: #059669; border-color: #047857; border-radius: 8px; box-shadow: 0 4px 15px rgba(5,150,105,0.35); text-transform: uppercase; letter-spacing: 0.3px;">
                     <i class="fa fa-bolt"></i> ⚡ SELESAIKAN &amp; BAYAR LUNAS
                  </button>

                  <a href="<?= base_url('administrator/sales_order'); ?>" class="btn btn-default btn-block btn-sm" style="margin-top: 10px; border-radius: 6px; font-weight: 600; color: #64748b;">
                     <i class="fa fa-arrow-left"></i> Kembali ke Daftar Penjualan
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>

</div>

<!-- Floating Mobile Checkout Bar (Tampil di Layar HP & Tablet < 992px) -->
<div class="mobile-sticky-bar hidden-md hidden-lg" id="mobile_sticky_bar">
   <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
      <div>
         <span style="font-size: 10.5px; font-weight: 600; color: #64748b; display: block; text-transform: uppercase;">
            <i class="fa fa-shopping-cart text-primary"></i> <span id="mobile_bar_items">0 Item</span>
         </span>
         <strong id="mobile_bar_total" style="font-size: 18px; font-weight: 900; color: #059669; line-height: 1.2;">Rp 0</strong>
      </div>
      <div>
         <a href="#terminal_kasir" id="btn_scroll_bayar" class="btn btn-success btn-sm" style="font-weight: 800; border-radius: 8px; padding: 8px 16px; background: #059669; border-color: #047857; box-shadow: 0 3px 10px rgba(5,150,105,0.35); text-transform: uppercase; font-size: 12px; letter-spacing: 0.3px;">
            <i class="fa fa-bolt"></i> Bayar Sekarang &darr;
         </a>
      </div>
   </div>
</div>
</form>

<!-- Modal Input Data Pelanggan Baru / Lengkapi Data -->
<div class="modal fade" id="modal_add_pelanggan" tabindex="-1" role="dialog" aria-labelledby="modalAddPelangganLabel">
   <div class="modal-dialog" role="document" style="max-width: 520px;">
      <div class="modal-content" style="border-radius: 10px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
         <div class="modal-header" style="background: linear-gradient(135deg, #0284c7, #0369a1); color: #fff; padding: 14px 20px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.85; font-size: 24px;">&times;</button>
            <h4 class="modal-title" id="modalAddPelangganLabel" style="font-weight: 700; font-size: 15px;">
               <i class="fa fa-user-plus"></i> Input / Lengkapi Data Pelanggan
            </h4>
            <small style="color: #e0f2fe; font-size: 11.5px;">Data pelanggan akan otomatis tersimpan ke Master Pelanggan &amp; rekap seluruh transaksi.</small>
         </div>
         <form id="form_modal_pelanggan" onsubmit="return false;">
         <div class="modal-body" style="padding: 18px 20px;">
            <div class="form-group" style="margin-bottom: 12px;">
               <label style="font-size: 12px; font-weight: 700; color: #334155;">Nama Pelanggan / Usaha <span class="text-danger">*</span></label>
               <input type="text" class="form-control" name="nama_pelanggan" id="modal_cust_nama" placeholder="Contoh: Budi Santoso / Toko Berkah" required style="border-radius: 6px; font-weight: 600; height: 38px;">
            </div>

            <div class="row">
               <div class="col-xs-12">
                  <div class="form-group" style="margin-bottom: 12px;">
                     <label style="font-size: 12px; font-weight: 700; color: #334155;"><i class="fa fa-phone text-success"></i> No. Telp / WhatsApp <span class="text-danger">*</span></label>
                     <input type="text" class="form-control" name="telepon" id="modal_cust_telp" placeholder="08xxxxxxxxxx" required style="border-radius: 6px; font-weight: 600; height: 38px;">
                     <small class="text-muted" style="font-size: 10.5px;">Untuk kirim nota WA &amp; data CRM.</small>
                  </div>
               </div>
               <input type="hidden" name="tipe_pelanggan" id="modal_cust_tipe" value="retail">
            </div>

            <div class="form-group" style="margin-bottom: 12px;">
               <label style="font-size: 12px; font-weight: 700; color: #334155;"><i class="fa fa-map-marker text-danger"></i> Alamat Lengkap (Opsional)</label>
               <textarea class="form-control" name="alamat" id="modal_cust_alamat" rows="2" placeholder="Jl. Raya No..., RT/RW, Kelurahan..." style="border-radius: 6px; font-size: 12px; resize: vertical;"></textarea>
            </div>

            <div class="row">
               <div class="col-xs-12 col-sm-6">
                  <div class="form-group" style="margin-bottom: 0;">
                     <label style="font-size: 12px; font-weight: 700; color: #334155;">Kota / Wilayah</label>
                     <input type="text" class="form-control" name="kota" id="modal_cust_kota" placeholder="Nama Kota/Kabupaten" style="border-radius: 6px; height: 36px;">
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6">
                  <div class="form-group" style="margin-bottom: 0;">
                     <label style="font-size: 12px; font-weight: 700; color: #334155;">Email (Opsional)</label>
                     <input type="email" class="form-control" name="email" id="modal_cust_email" placeholder="email@contoh.com" style="border-radius: 6px; height: 36px;">
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
            <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-weight: 600;">Batal</button>
            <button type="button" id="btn_submit_modal_pelanggan" class="btn btn-primary" style="border-radius: 6px; font-weight: 700; padding: 7px 18px; background: #0284c7; border-color: #0369a1;">
               <i class="fa fa-check-circle"></i> Simpan &amp; Pilih Pelanggan
            </button>
         </div>
         </form>
      </div>
   </div>
</div>

<!-- Modal Preview & Cetak Nota Kasir (Thermal POS) -->
<div class="modal fade" id="modal_nota_kasir" tabindex="-1" role="dialog" aria-labelledby="modalNotaKasirLabel">
   <div class="modal-dialog" role="document" style="max-width: 500px; margin: 20px auto;">
      <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.3); border:none;">
         <div class="modal-header" style="background: linear-gradient(135deg, #059669, #10b981); color: #fff; padding: 12px 18px; display:flex; justify-content:space-between; align-items:center;">
            <div>
               <h4 class="modal-title" id="modalNotaKasirLabel" style="font-weight: 800; font-size: 15px; margin:0;">
                  <i class="fa fa-check-circle"></i> Transaksi Berhasil &amp; Lunas!
               </h4>
               <small style="color: #ecfdf5; font-size: 11px;">Struk Pembayaran Kasir Siap Dicetak</small>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
               <span class="label" id="modal_nota_badge_so" style="background: rgba(255,255,255,0.25); font-size: 11px; padding: 4px 8px; border-radius: 6px;">TRX</span>
               <button type="button" class="close btn-close-modal-nota" id="btn_close_modal_header" data-dismiss="modal" aria-label="Tutup" style="color: #ffffff; opacity: 1; font-size: 22px; font-weight: bold; text-shadow: none; line-height: 1; outline: none; margin: 0; padding: 0; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; background: rgba(0,0,0,0.2); border: none; cursor: pointer; transition: background 0.2s; position: relative; z-index: 1060;" title="Tutup / Keluar (Esc)">
                  <span aria-hidden="true" style="margin-top:-2px;">&times;</span>
               </button>
            </div>
         </div>
         <div class="modal-body" style="background: #f8fafc; padding: 12px 16px; max-height: 48vh; overflow-y: auto; overflow-x: hidden;">
             <!-- Template Switcher Tabs inside Modal -->
             <div id="modal_nota_tabs_wrap" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                <div style="display: flex; gap: 6px;">
                   <button type="button" class="btn btn-xs btn-success" id="btn_modal_tab_thermal" style="font-weight: 700; border-radius: 12px; padding: 4px 12px; font-size: 11px;">
                      <i class="fa fa-ticket"></i> Struk Thermal (58mm)
                   </button>
                   <button type="button" class="btn btn-xs btn-default" id="btn_modal_tab_lebar" style="font-weight: 700; border-radius: 12px; padding: 4px 12px; font-size: 11px; color: #0284c7; border: 1px solid #cbd5e1;">
                      <i class="fa fa-building-o"></i> Faktur Lebar (A4)
                   </button>
                </div>
                <div>
                   <a href="javascript:void(0);" id="btn_modal_print_pdf" target="_blank" rel="noopener noreferrer" style="font-size: 11px; font-weight: 700; color: #dc2626; text-decoration: none; padding: 4px 8px; border-radius: 6px; background: #fef2f2; border: 1px solid #fecaca;">
                      <i class="fa fa-file-pdf-o"></i> Unduh PDF
                   </a>
                </div>
             </div>

             <!-- Bluetooth Status Card inside Modal (Thermal Mode) -->
             <div id="bt_status_bar" style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; padding:8px 12px; margin-bottom:12px; font-size:12px;">
                <div style="display:flex; align-items:center; gap:8px;">
                   <i class="fa fa-bluetooth" id="bt_status_icon" style="color:#2563eb; font-size:16px;"></i>
                   <div>
                      <div id="bt_status_text" style="font-weight:700; color:#1e293b;">Printer Bluetooth: Belum Terhubung</div>
                      <small style="color:#64748b; font-size:10.5px;">Klik Cetak Bluetooth untuk langsung pairing &amp; cetak struk</small>
                   </div>
                </div>
                <div style="display:flex; gap:6px;">
                   <button type="button" id="btn_bt_pair" class="btn btn-xs btn-primary" style="font-weight:700; border-radius:6px; padding:5px 10px; background:#2563eb; border-color:#1d4ed8;">
                      <i class="fa fa-bluetooth"></i> <span id="btn_bt_pair_text">Sambungkan Printer</span>
                   </button>
                   <button type="button" id="btn_bt_unpair" class="btn btn-xs btn-default" style="display:none; font-weight:700; border-radius:6px; padding:5px 8px; color:#ef4444; border-color:#fca5a5;">
                      <i class="fa fa-times"></i> Putuskan
                   </button>
                </div>
             </div>

             <!-- Preview 1: Thermal Paper -->
             <div id="container_preview_thermal">
                <div id="receipt_preview_paper" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); font-family: 'Courier New', Courier, monospace; font-size: 11.5px; color: #1e293b; max-width: 100%; box-sizing: border-box; overflow-x: hidden;">
                   <!-- Konten struk dinamis JS -->
                </div>
             </div>

             <!-- Preview 2: Enterprise Wide Invoice -->
             <div id="container_preview_lebar" style="display: none;">
                <div id="receipt_preview_lebar" style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #0f172a;">
                   <!-- Konten faktur lebar dinamis JS -->
                </div>
             </div>
          </div>

          <div class="modal-footer" style="background: #ffffff; border-top: 1px solid #f1f5f9; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap;">
             <!-- Tombol 1: Cetak Bluetooth Langsung Pairing -->
             <button type="button" id="btn_modal_print_bluetooth" class="btn" style="flex: 1.3; min-width: 175px; background: #2563eb; color: #ffffff; font-weight: 700; border-radius: 20px; padding: 9px 16px; border: none; font-size: 12.5px; box-shadow: 0 2px 8px rgba(37,99,235,0.25);" title="Cetak struk menggunakan thermal Bluetooth (langsung buka pairing)">
                <i class="fa fa-bluetooth"></i> Cetak Menggunakan BT
             </button>

             <!-- Tombol 2: Cetak Biasa / Browser / USB -->
             <button type="button" id="btn_modal_print_browser" class="btn" style="flex: 1.1; min-width: 140px; background: #334155; color: #ffffff; font-weight: 700; border-radius: 20px; padding: 9px 14px; border: none; font-size: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.12);" title="Cetak struk via dialog browser printer / USB / PDF">
                <i class="fa fa-print"></i> Cetak Browser / USB
             </button>

             <!-- Tombol 3: Selesai & Transaksi Baru -->
             <button type="button" id="btn_modal_main_selesai" class="btn" style="flex: 1; min-width: 120px; background: #059669; color: #ffffff; font-weight: 700; border-radius: 20px; padding: 9px 14px; border: none; font-size: 12px; box-shadow: 0 2px 6px rgba(5,150,105,0.25);" title="Selesaikan transaksi & siap melayani pelanggan berikutnya">
                <i class="fa fa-check"></i> Selesai (Baru)
             </button>

             <!-- Tombol 4: Tutup -->
             <button type="button" class="btn btn-default btn-close-modal-nota" id="btn_modal_batal" data-dismiss="modal" style="flex: 0.6; min-width: 75px; border: 1.5px solid #cbd5e1; background: #ffffff; color: #64748b; font-weight: 700; border-radius: 20px; padding: 8px 12px; font-size: 12px; cursor: pointer;" title="Tutup pratinjau nota">
                <i class="fa fa-times"></i> Tutup
             </button>

             <!-- Hidden Compatibility Anchor for Legacy Scripts -->
             <button type="button" id="btn_modal_main_print" style="display:none;"></button>
          </div>
       </div>
    </div>
 </div>

</section>

<script src="<?= base_url('asset/admin-lte/plugins/select2/select2.full.min.js'); ?>"></script>
<script src="<?= base_url('asset/js/thermal-bluetooth-printer.js'); ?>"></script>
<script>
// Helper untuk memastikan request AJAX selalu menggunakan Origin (protokol, host, port) yang sama dengan halaman aktif saat ini
function get_same_origin_url(url) {
   if (!url) return '';
   try {
      if (url.indexOf('http://') === 0 || url.indexOf('https://') === 0) {
         var parsed = new URL(url);
         if (parsed.hostname === window.location.hostname || parsed.hostname === 'localhost' || parsed.hostname === '127.0.0.1') {
            return window.location.origin + parsed.pathname + parsed.search + parsed.hash;
         }
      }
   } catch(e){}
   return url;
}
var item_count = 1;
var produks_initial = <?= json_encode(array_map(function($p){ return ['id'=>$p->id, 'kode'=>$p->kode_produk, 'nama'=>$p->nama_produk, 'satuan'=>$p->nama_satuan ?? 'Pcs', 'harga_jual'=>$p->harga_jual, 'harga_jual_grosir'=>$p->harga_jual_grosir, 'harga_jual_distributor'=>$p->harga_jual_distributor, 'harga_jual_vip'=>$p->harga_jual_vip, 'qty'=>(float)($p->stok_qty ?? 0), 'stok'=>(float)($p->stok_qty ?? 0)]; }, $produks)); ?>;
var available_produks = produks_initial;
var lastReceiptData = null;
var nextSoNumber = '';
var nextRefNumber = '';

function play_pos_success_sound() {
   try {
      var ctx = new (window.AudioContext || window.webkitAudioContext)();
      var now = ctx.currentTime;
      var notes = [523.25, 659.25, 783.99]; // C5, E5, G5 arpeggio
      notes.forEach(function(freq, i){
         var osc = ctx.createOscillator();
         var gain = ctx.createGain();
         osc.type = 'triangle';
         osc.frequency.value = freq;
         gain.gain.setValueAtTime(0, now + (i * 0.08));
         gain.gain.linearRampToValueAtTime(0.25, now + (i * 0.08) + 0.02);
         gain.gain.exponentialRampToValueAtTime(0.001, now + (i * 0.08) + 0.28);
         osc.connect(gain);
         gain.connect(ctx.destination);
         osc.start(now + (i * 0.08));
         osc.stop(now + (i * 0.08) + 0.3);
      });
   } catch(e){}
}

function print_thermal_receipt(url) {
   if (!url) return;
   var printUrl = url.indexOf('?') !== -1 ? (url + '&autoprint=1') : (url + '?autoprint=1');
   var w = window.open(printUrl, 'NotaKasir', 'width=450,height=650,top=50,left=150,scrollbars=yes,resizable=yes');
   if (w) {
      w.focus();
   } else {
      window.open(printUrl, '_blank');
   }
}

function play_scanner_beep() {
   try {
      var ctx = new (window.AudioContext || window.webkitAudioContext)();
      var osc = ctx.createOscillator();
      var gain = ctx.createGain();
      osc.type = 'sine';
      osc.frequency.value = 1800;
      gain.gain.setValueAtTime(0.3, ctx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.00001, ctx.currentTime + 0.12);
      osc.connect(gain);
      gain.connect(ctx.destination);
      osc.start();
      osc.stop(ctx.currentTime + 0.12);
   } catch(e){}
}

function build_options() {
   var list = (available_produks && available_produks.length > 0) ? available_produks : produks_initial;
   if (!list || list.length === 0) {
      return '<option value="">-- Tidak ada produk aktif di sistem --</option>';
   }
   var opts = '<option value="">-- Cari / Pilih Produk --</option>';
   list.forEach(function(p) {
      var pId = p.id;
      var pKode = p.kode_produk || p.kode || '';
      var pNama = p.nama_produk || p.nama || '';
      var pHarga = p.harga_jual || 0;
      var stok = (p.qty !== undefined) ? parseFloat(p.qty) : (p.stok !== undefined ? parseFloat(p.stok) : 0);
      var stokBadge = ' [Stok: ' + stok + ']';
      opts += '<option value="' + pId + '" data-harga="' + pHarga + '" data-stok="' + stok + '">' + pKode + ' - ' + pNama + stokBadge + '</option>';
   });
   return opts;
}

function init_produk_select2($container) {
   if (typeof $.fn.select2 === 'function') {
      var $targets = $container ? $container.find('.produk-select') : $('.produk-select');
      $targets.each(function() {
         if ($(this).data('select2')) {
            $(this).select2('destroy');
         }
         $(this).select2({
            placeholder: '-- Cari / Pilih Produk --',
            allowClear: true,
            width: '100%'
         });
      });
   }
}

function update_all_product_dropdowns() {
   var opts = build_options();
   $('.item-row').each(function() {
      var $sel = $(this).find('.produk-select');
      var currVal = $sel.val();
      if ($sel.data('select2')) {
         $sel.select2('destroy');
      }
      $sel.html(opts);
      if (currVal && $sel.find('option[value="' + currVal + '"]').length > 0) {
         $sel.val(currVal);
         cek_stok(currVal, $(this).find('.stok-display'));
      } else {
         $sel.val('');
      }
   });
   init_produk_select2();
}


function format_rp(n) {
   return 'Rp ' + parseInt(n || 0).toLocaleString('id-ID');
}
function format_num_id(n) {
   return parseInt(n || 0).toLocaleString('id-ID');
}

function show_alert(msg, type) {
   if (typeof swal !== 'undefined') {
      var titles = {warning: 'Peringatan!', error: 'Error!', success: 'Berhasil!', info: 'Info'};
      swal(titles[type] || 'Pemberitahuan', msg, type || 'info');
   } else {
      alert(msg);
   }
}

function render_receipt_preview_html(rc) {
   if (!rc) return '';
   var html = '';
   html += '<div style="text-align:center; margin-bottom:8px;">';
   html += '  <div style="font-size:15px; font-weight:900; letter-spacing:0.5px;">IDMETAFORA STORE</div>';
   html += '  <div style="font-size:10px; color:#475569;">SISTEM KASIR &amp; PENJUALAN TERPADU</div>';
   html += '  <div style="font-size:10px; color:#475569;">Jl. Imogiri Timur KM 7, Banguntapan, Bantul, DIY</div>';
   html += '  <div style="font-size:10px; color:#475569;">Telp/WA: 0812-3456-7890</div>';
   html += '</div>';

   html += '<div style="border-top:1px dashed #334155; margin:8px 0;"></div>';

   html += '<table style="width:100%; font-size:11px; line-height:1.4;">';
   html += '  <tr><td style="width:28%;">No. Nota</td><td style="width:4%;">:</td><td style="font-weight:700;">' + (rc.nomor_so || '-') + '</td></tr>';
   if (rc.nomor_inv) {
      html += '  <tr><td>No. Faktur</td><td>:</td><td>' + rc.nomor_inv + '</td></tr>';
   }
   if (rc.nomor_bkm) {
      html += '  <tr><td>No. Kas/BKM</td><td>:</td><td>' + rc.nomor_bkm + '</td></tr>';
   }
   html += '  <tr><td>Tanggal</td><td>:</td><td>' + (rc.tanggal || '') + '</td></tr>';
   html += '  <tr><td>Kasir</td><td>:</td><td>' + (rc.kasir || 'Kasir POS') + '</td></tr>';
   html += '  <tr><td>Pelanggan</td><td>:</td><td style="font-weight:700;">' + (rc.pelanggan || 'Umum') + '</td></tr>';
   if (rc.telepon) {
      html += '  <tr><td>Telp</td><td>:</td><td>' + rc.telepon + '</td></tr>';
   }
   html += '</table>';

   html += '<div style="border-top:1px dashed #334155; margin:8px 0;"></div>';

   // Items list
   html += '<table style="width:100%; font-size:11px; line-height:1.35; word-break:break-word;">';
   var total_qty = 0;
   var gross_item_total = 0;
   var item_disc_total = 0;
   if (rc.items && rc.items.length > 0) {
      rc.items.forEach(function(it){
         var q = parseFloat(it.qty) || 0;
         total_qty += q;
         var h = parseFloat(it.harga !== undefined ? it.harga : (it.harga_satuan !== undefined ? it.harga_satuan : 0)) || 0;
         var d = parseFloat(it.diskon !== undefined ? it.diskon : (it.diskon_persen !== undefined ? it.diskon_persen : 0)) || 0;
         var sub = parseFloat(it.subtotal) || 0;
         var line_gross = q * h;
         var line_disc = line_gross * (d / 100);
         gross_item_total += line_gross;
         item_disc_total += line_disc;

         var nama = it.nama || it.nama_produk || '-';
         html += '<tr>';
         html += '  <td colspan="2" style="font-weight:700; padding-top:3px;">' + nama + '</td>';
         html += '</tr>';
         html += '<tr>';
         html += '  <td style="color:#334155; font-size:10.5px;">';
         html += '    ' + format_num_id(q) + ' ' + (it.satuan || 'pcs') + ' x ' + format_num_id(h);
         if (d > 0) {
            html += ' <span style="color:#dc2626;">(Disc ' + d + '%)</span>';
         }
         html += '  </td>';
         html += '  <td style="text-align:right; font-weight:700; white-space:nowrap;">Rp ' + format_num_id(sub) + '</td>';
         html += '</tr>';
      });
   }
   html += '</table>';

   html += '<div style="border-top:1px dashed #334155; margin:8px 0;"></div>';

   // Totals
   html += '<table style="width:100%; font-size:11px; line-height:1.4;">';
   if (item_disc_total > 0) {
      html += '  <tr><td>Subtotal Belanja (' + total_qty + ' pcs)</td><td style="text-align:right;">Rp ' + format_num_id(gross_item_total) + '</td></tr>';
      html += '  <tr><td>Diskon Item</td><td style="text-align:right; color:#dc2626;">- Rp ' + format_num_id(item_disc_total) + '</td></tr>';
   } else {
      html += '  <tr><td>Total Item (' + total_qty + ' pcs)</td><td style="text-align:right;">Rp ' + format_num_id(rc.subtotal) + '</td></tr>';
   }
   if (rc.diskon_total > 0) {
      html += '  <tr><td>Diskon Global</td><td style="text-align:right; color:#dc2626;">- Rp ' + format_num_id(rc.diskon_total) + '</td></tr>';
   }
   if (rc.pajak_nominal > 0) {
      html += '  <tr><td>PPN</td><td style="text-align:right;">+ Rp ' + format_num_id(rc.pajak_nominal) + '</td></tr>';
   }
   html += '</table>';

   html += '<div style="border-top:1px dashed #334155; border-bottom:1px dashed #334155; height:3px; margin:8px 0;"></div>';

   html += '<table style="width:100%; font-size:11px; line-height:1.5;">';
   html += '  <tr style="font-size:13px; font-weight:800;"><td style="color:#0f172a;">TOTAL TAGIHAN</td><td style="text-align:right; color:#059669;">Rp ' + format_num_id(rc.total) + '</td></tr>';
   html += '  <tr><td>Metode Bayar</td><td style="text-align:right; font-weight:700;">' + (rc.metode_pembayaran || 'TUNAI') + '</td></tr>';
   html += '  <tr><td>Bayar / Diterima</td><td style="text-align:right;">Rp ' + format_num_id(rc.uang_diterima) + '</td></tr>';
   html += '  <tr style="font-size:12px; font-weight:700;"><td>KEMBALIAN</td><td style="text-align:right; color:#059669;">Rp ' + format_num_id(rc.kembalian) + '</td></tr>';
   html += '</table>';

   html += '<div style="border-top:1px dashed #334155; border-bottom:1px dashed #334155; height:3px; margin:8px 0;"></div>';

   html += '<div style="text-align:center; font-size:10px; color:#475569; margin-top:8px; line-height:1.35;">';
   html += '  <div style="font-weight:700; color:#059669; font-size:10.5px;">=== STATUS: LUNAS DIRECT ===</div>';
   html += '  <div style="margin-top:4px;">TERIMA KASIH ATAS KUNJUNGAN ANDA!</div>';
   html += '  <div>Barang yang dibeli tidak dapat ditukar/dikembalikan.</div>';
   html += '  <div style="margin-top:4px; font-size:9px; color:#94a3b8;">Struk ini merupakan bukti pembayaran sah</div>';
   html += '</div>';

   return html;
}

function terbilang_id(nilai) {
   var bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
   nilai = Math.floor(Math.abs(nilai || 0));
   if (nilai < 12) return bilangan[nilai];
   if (nilai < 20) return terbilang_id(nilai - 10) + ' Belas';
   if (nilai < 100) return terbilang_id(Math.floor(nilai / 10)) + ' Puluh' + (nilai % 10 !== 0 ? ' ' + terbilang_id(nilai % 10) : '');
   if (nilai < 200) return 'Seratus' + (nilai - 100 !== 0 ? ' ' + terbilang_id(nilai - 100) : '');
   if (nilai < 1000) return terbilang_id(Math.floor(nilai / 100)) + ' Ratus' + (nilai % 100 !== 0 ? ' ' + terbilang_id(nilai % 100) : '');
   if (nilai < 2000) return 'Seribu' + (nilai - 1000 !== 0 ? ' ' + terbilang_id(nilai - 1000) : '');
   if (nilai < 1000000) return terbilang_id(Math.floor(nilai / 1000)) + ' Ribu' + (nilai % 1000 !== 0 ? ' ' + terbilang_id(nilai % 1000) : '');
   if (nilai < 1000000000) return terbilang_id(Math.floor(nilai / 1000000)) + ' Juta' + (nilai % 1000000 !== 0 ? ' ' + terbilang_id(nilai % 1000000) : '');
   if (nilai < 1000000000000) return terbilang_id(Math.floor(nilai / 1000000000)) + ' Miliar' + (nilai % 1000000000 !== 0 ? ' ' + terbilang_id(nilai % 1000000000) : '');
   return String(nilai);
}

function render_receipt_lebar_preview_html(rc) {
   if (!rc) return '';
   var html = '';
   var grandTotal = parseFloat(rc.total) || 0;
   var terbilangTxt = terbilang_id(grandTotal);

   html += '<div style="margin-bottom:12px;">';
   html += '  <table style="width:100%; border-collapse:collapse;">';
   html += '    <tr>';
   html += '      <td style="width:58%; vertical-align:top;">';
   html += '        <div style="font-size:16px; font-weight:900; color:#0f172a; letter-spacing:0.3px;">IDMETAFORA STORE / PT. IDMETAFORA INDONESIA</div>';
   html += '        <div style="font-size:10px; color:#475569; margin-top:2px;">SISTEM KASIR &amp; PENJUALAN TERPADU</div>';
   html += '        <div style="font-size:10px; color:#475569;">Jl. Imogiri Timur KM 7, Banguntapan, Bantul, DIY | Telp: (0274) 123456 / 0812-3456-7890</div>';
   html += '        <div style="font-size:10px; color:#64748b;">NPWP: 01.234.567.8-543.000</div>';
   html += '      </td>';
   html += '      <td style="width:42%; vertical-align:top;">';
   html += '        <div style="text-align:right; font-size:15px; font-weight:800; color:#0284c7; text-transform:uppercase; margin-bottom:4px;">FAKTUR PENJUALAN</div>';
   html += '        <table style="width:100%; font-size:10.5px; border-collapse:collapse; margin-left:auto;">';
   html += '          <tr><td style="width:40%; font-weight:700;">No. Faktur</td><td style="width:4%;">:</td><td style="font-weight:800; color:#0f172a;">' + (rc.nomor_inv || rc.nomor_so || '-') + '</td></tr>';
   html += '          <tr><td style="font-weight:700;">No. Transaksi Penjualan</td><td>:</td><td>' + (rc.nomor_so || '-') + '</td></tr>';
   if (rc.nomor_bkm) {
      html += '          <tr><td style="font-weight:700;">No. Kas/BKM</td><td>:</td><td>' + rc.nomor_bkm + '</td></tr>';
   }
   html += '          <tr><td style="font-weight:700;">Tanggal</td><td>:</td><td>' + (rc.tanggal || '-') + '</td></tr>';
   html += '          <tr><td style="font-weight:700;">Jatuh Tempo</td><td>:</td><td>CASH / LUNAS</td></tr>';
   html += '        </table>';
   html += '      </td>';
   html += '    </tr>';
   html += '  </table>';
   html += '</div>';

   html += '<div style="border-top:2px solid #0f172a; border-bottom:1px solid #0f172a; height:3px; margin:8px 0 12px 0;"></div>';

   // Info Customer & Detail Bayar
   html += '<table style="width:100%; border-collapse:collapse; margin-bottom:12px;">';
   html += '  <tr>';
   html += '    <td style="width:48%; background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:8px 12px; vertical-align:top;">';
   html += '      <div style="font-size:10.5px; font-weight:800; color:#0369a1; text-transform:uppercase; border-bottom:1px dashed #cbd5e1; padding-bottom:3px; margin-bottom:4px;">Kepada Yth (Customer):</div>';
   html += '      <table style="width:100%; font-size:10.5px; border-collapse:collapse;">';
   html += '        <tr><td style="width:28%; font-weight:700;">Pelanggan</td><td style="width:4%;">:</td><td style="font-weight:800; color:#0284c7;">' + (rc.pelanggan || 'Umum') + '</td></tr>';
   if (rc.telepon) {
      html += '        <tr><td style="font-weight:700;">No. Telp/WA</td><td>:</td><td>' + rc.telepon + '</td></tr>';
   }
   if (rc.alamat) {
      html += '        <tr><td style="font-weight:700;">Alamat</td><td>:</td><td>' + rc.alamat + '</td></tr>';
   }
   html += '      </table>';
   html += '    </td>';
   html += '    <td style="width:4%;"></td>';
   html += '    <td style="width:48%; background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:8px 12px; vertical-align:top;">';
   html += '      <div style="font-size:10.5px; font-weight:800; color:#0369a1; text-transform:uppercase; border-bottom:1px dashed #cbd5e1; padding-bottom:3px; margin-bottom:4px;">Detail Transaksi:</div>';
   html += '      <table style="width:100%; font-size:10.5px; border-collapse:collapse;">';
   html += '        <tr><td style="width:34%; font-weight:700;">Metode Bayar</td><td style="width:4%;">:</td><td style="font-weight:800; color:#047857;">' + (rc.metode_pembayaran || 'TUNAI') + '</td></tr>';
   html += '        <tr><td style="font-weight:700;">Kasir POS</td><td>:</td><td>' + (rc.kasir || 'Kasir') + '</td></tr>';
   html += '        <tr><td style="font-weight:700;">Status</td><td>:</td><td><span style="background:#dcfce7; color:#15803d; border:1px solid #86efac; padding:1px 6px; border-radius:3px; font-weight:800; font-size:9.5px;">✓ LUNAS DIRECT</span></td></tr>';
   html += '      </table>';
   html += '    </td>';
   html += '  </tr>';
   html += '</table>';

   // Tabel Items
   html += '<table style="width:100%; border-collapse:collapse; margin-bottom:12px; font-size:10.5px;">';
   html += '  <thead>';
   html += '    <tr style="background:#f1f5f9; text-transform:uppercase; font-size:10px;">';
   html += '      <th style="width:5%; border:1px solid #cbd5e1; padding:5px; text-align:center;">No</th>';
   html += '      <th style="width:38%; border:1px solid #cbd5e1; padding:5px; text-align:left;">Nama Produk &amp; Deskripsi</th>';
   html += '      <th style="width:9%; border:1px solid #cbd5e1; padding:5px; text-align:center;">Jumlah</th>';
   html += '      <th style="width:8%; border:1px solid #cbd5e1; padding:5px; text-align:center;">Satuan</th>';
   html += '      <th style="width:14%; border:1px solid #cbd5e1; padding:5px; text-align:right;">Harga Satuan</th>';
   html += '      <th style="width:9%; border:1px solid #cbd5e1; padding:5px; text-align:center;">Disc (%)</th>';
   html += '      <th style="width:17%; border:1px solid #cbd5e1; padding:5px; text-align:right;">Total Harga</th>';
   html += '    </tr>';
   html += '  </thead>';
   html += '  <tbody>';

   var totalQty = 0;
   var totalGross = 0;
   var totalItemDisc = 0;
   if (rc.items && rc.items.length > 0) {
      rc.items.forEach(function(it, idx){
         var q = parseFloat(it.qty) || 0;
         totalQty += q;
         var h = parseFloat(it.harga !== undefined ? it.harga : (it.harga_satuan !== undefined ? it.harga_satuan : 0)) || 0;
         var d = parseFloat(it.diskon !== undefined ? it.diskon : (it.diskon_persen !== undefined ? it.diskon_persen : 0)) || 0;
         var sub = parseFloat(it.subtotal) || 0;
         var line_gross = q * h;
         var line_disc = line_gross * (d / 100);
         totalGross += line_gross;
         totalItemDisc += line_disc;
         var nm = it.nama || it.nama_produk || '-';

         html += '  <tr style="border-bottom:1px solid #e2e8f0;">';
         html += '    <td style="border:1px solid #cbd5e1; padding:5px; text-align:center;">' + (idx + 1) + '</td>';
         html += '    <td style="border:1px solid #cbd5e1; padding:5px; font-weight:700;">' + nm + '</td>';
         html += '    <td style="border:1px solid #cbd5e1; padding:5px; text-align:center; font-weight:700;">' + format_num_id(q) + '</td>';
         html += '    <td style="border:1px solid #cbd5e1; padding:5px; text-align:center;">' + (it.satuan || 'Pcs') + '</td>';
         html += '    <td style="border:1px solid #cbd5e1; padding:5px; text-align:right;">Rp ' + format_num_id(h) + '</td>';
         html += '    <td style="border:1px solid #cbd5e1; padding:5px; text-align:center; color:' + (d > 0 ? '#dc2626' : '#64748b') + '; font-weight:600;">' + (d > 0 ? (d + '%') : '-') + '</td>';
         html += '    <td style="border:1px solid #cbd5e1; padding:5px; text-align:right; font-weight:700;">Rp ' + format_num_id(sub) + '</td>';
         html += '  </tr>';
      });
   }

   html += '  </tbody>';
   html += '  <tfoot>';
   html += '    <tr style="background:#f8fafc; font-weight:bold;">';
   html += '      <td colspan="2" style="border:1px solid #cbd5e1; padding:5px; text-align:right;">TOTAL KUANTITAS:</td>';
   html += '      <td style="border:1px solid #cbd5e1; padding:5px; text-align:center; color:#0284c7;">' + format_num_id(totalQty) + '</td>';
   html += '      <td colspan="3" style="border:1px solid #cbd5e1; padding:5px; text-align:right;">SUBTOTAL:</td>';
   html += '      <td style="border:1px solid #cbd5e1; padding:5px; text-align:right;">Rp ' + format_num_id(rc.subtotal) + '</td>';
   html += '    </tr>';
   html += '  </tfoot>';
   html += '</table>';

   // Bottom summary
   html += '<table style="width:100%; border-collapse:collapse; margin-bottom:10px;">';
   html += '  <tr>';
   html += '    <td style="width:56%; vertical-align:top;">';
   html += '      <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:6px 10px; font-size:10.5px; margin-bottom:6px;">';
   html += '        <span style="font-size:9.5px; color:#64748b; font-weight:700; text-transform:uppercase;">Terbilang:</span><br>';
   html += '        <strong style="font-style:italic; color:#0369a1;">' + terbilangTxt + ' Rupiah</strong>';
   html += '      </div>';
   html += '      <div style="font-size:9.5px; color:#475569; line-height:1.4;">';
   html += '        <strong>Syarat &amp; Ketentuan:</strong>';
   html += '        <ol style="margin-left:14px; margin-top:2px;">';
   html += '          <li>Barang yang dibeli telah diperiksa dan diterima dalam kondisi baik &amp; lengkap.</li>';
   html += '          <li>Rekening Resmi: Bank Mandiri 137-00-1234567-8 / Bank BCA 869-0123-456 a/n IDMETAFORA STORE.</li>';
   html += '          <li>Komplain maksimal 2 x 24 jam dengan menyertakan faktur ini.</li>';
   html += '        </ol>';
   html += '      </div>';
   html += '    </td>';
   html += '    <td style="width:4%;"></td>';
   html += '    <td style="width:40%; vertical-align:top;">';
   html += '      <table style="width:100%; font-size:10.5px; border-collapse:collapse;">';
   if (totalItemDisc > 0) {
      html += '        <tr><td>Subtotal Belanja</td><td style="text-align:right; font-weight:600;">Rp ' + format_num_id(totalGross) + '</td></tr>';
      html += '        <tr><td style="color:#dc2626;">Diskon Item</td><td style="text-align:right; color:#dc2626; font-weight:600;">- Rp ' + format_num_id(totalItemDisc) + '</td></tr>';
   } else {
      html += '        <tr><td>Subtotal Produk</td><td style="text-align:right; font-weight:600;">Rp ' + format_num_id(rc.subtotal) + '</td></tr>';
   }
   if (parseFloat(rc.diskon_total) > 0) {
      html += '        <tr><td style="color:#dc2626;">Diskon Nota</td><td style="text-align:right; color:#dc2626; font-weight:600;">- Rp ' + format_num_id(rc.diskon_total) + '</td></tr>';
   }
   if (parseFloat(rc.pajak_nominal) > 0) {
      html += '        <tr><td>PPN</td><td style="text-align:right; font-weight:600;">+ Rp ' + format_num_id(rc.pajak_nominal) + '</td></tr>';
   }
   html += '        <tr style="background:#f0fdf4; border-top:1.5px solid #86efac; border-bottom:1.5px solid #86efac; font-size:12px; font-weight:800;">';
   html += '          <td style="padding:4px 0;">TOTAL TAGIHAN</td><td style="text-align:right; color:#047857; padding:4px 0;">Rp ' + format_num_id(rc.total) + '</td>';
   html += '        </tr>';
   html += '        <tr><td>Bayar / Diterima</td><td style="text-align:right; font-weight:700;">Rp ' + format_num_id(rc.uang_diterima) + '</td></tr>';
   html += '        <tr><td>Kembalian</td><td style="text-align:right; font-weight:700; color:#047857;">Rp ' + format_num_id(rc.kembalian) + '</td></tr>';
   html += '      </table>';
   html += '    </td>';
   html += '  </tr>';
   html += '</table>';

   // Signatures
   html += '<table style="width:100%; border-collapse:collapse; margin-top:14px; text-align:center; font-size:10px;">';
   html += '  <tr>';
   html += '    <td style="width:25%;"><div>Tanda Terima / Customer,</div><div style="height:36px;"></div><div style="border-top:1px solid #334155; padding-top:2px; font-weight:700;">( ' + (rc.pelanggan || 'Pelanggan') + ' )</div></td>';
   html += '    <td style="width:25%;"><div>Pengemudi / Ekspedisi,</div><div style="height:36px;"></div><div style="border-top:1px solid #334155; padding-top:2px; font-weight:700;">( .................... )</div></td>';
   html += '    <td style="width:25%;"><div>Petugas Logistik,</div><div style="height:36px;"></div><div style="border-top:1px solid #334155; padding-top:2px; font-weight:700;">( .................... )</div></td>';
   html += '    <td style="width:25%;"><div>Hormat Kami / Kasir,</div><div style="height:36px;"></div><div style="border-top:1px solid #334155; padding-top:2px; font-weight:700;">( ' + (rc.kasir || 'Kasir POS') + ' )</div></td>';
   html += '  </tr>';
   html += '</table>';

   return html;
}

// Web Bluetooth Status UI Sync (Global Scope)
function handle_insecure_bluetooth_action() {
   var currentPort = window.location.port;
   var targetPort = '';
   if (currentPort && currentPort !== '80' && currentPort !== '443') {
      targetPort = ':' + currentPort;
   } else if (window.location.hostname && (window.location.hostname.indexOf('.test') !== -1 || window.location.hostname === 'localhost')) {
      targetPort = ':8443';
   }
   var targetHost = window.location.hostname || 'ci3_metafora.test';
   var targetUrl = 'https://' + targetHost + targetPort + window.location.pathname + window.location.search;

   if (typeof swal !== 'undefined') {
      swal({
         title: "Akses Bluetooth Butuh URL Aman (HTTPS)",
         text: "Browser mewajibkan Web Bluetooth berjalan di domain aman (HTTPS berlogo gembok).\n\nSaat ini Anda membuka via: " + window.location.origin + " (HTTP biasa).\n\nKlik tombol di bawah untuk membuka versi HTTPS ber-SSL.",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#0284c7",
         cancelButtonColor: "#64748b",
         confirmButtonText: "Buka via HTTPS (Aktifkan Bluetooth)",
         cancelButtonText: "Batal",
         closeOnConfirm: false
      }, function(isConfirm){
         if (isConfirm) {
            window.location.href = targetUrl;
         }
      });
   } else {
      if (confirm("Web Bluetooth memerlukan URL aman (HTTPS).\n\nKlik OK untuk berpindah ke HTTPS agar Bluetooth aktif.")) {
         window.location.href = targetUrl;
      }
   }
}

function update_bluetooth_status_ui() {
   if (!window.ThermalPrinter) return;
   var st = window.ThermalPrinter.getStatus();
   // st = { status: 'unpaired'|'connected'|'paired', label, color, icon }

   // 1. Update status bar di POS Top Toolbar
   if ($('#btn_top_bt_printer').length) {
      if (st.status === 'connected') {
         $('#top_bt_icon').css('color', '#10b981');
         $('#top_bt_label').text(window.ThermalPrinter.getDeviceName() || 'BT Thermal');
         $('#top_bt_badge').css('background', '#10b981').text('Tersambung');
         $('#btn_top_bt_printer').css({'background': '#ecfdf5', 'border-color': '#86efac', 'color': '#065f46'});
      } else if (st.status === 'paired') {
         $('#top_bt_icon').css('color', '#f59e0b');
         $('#top_bt_label').text(window.ThermalPrinter.getDeviceName() || 'BT Thermal');
         $('#top_bt_badge').css('background', '#f59e0b').text('Offline');
         $('#btn_top_bt_printer').css({'background': '#fffbeb', 'border-color': '#fde68a', 'color': '#92400e'});
      } else {
         $('#top_bt_icon').css('color', '#64748b');
         $('#top_bt_label').text('Printer BT');
         $('#top_bt_badge').css('background', '#94a3b8').text('Belum Konek');
         $('#btn_top_bt_printer').css({'background': '#f8fafc', 'border-color': '#cbd5e1', 'color': '#475569'});
      }
   }

   // 2. Update status bar di Modal Nota Kasir
   if ($('#bt_status_bar').length) {
      $('#bt_status_icon').removeClass('fa-bluetooth fa-check-circle fa-exclamation-circle fa-exclamation-triangle')
         .addClass('fa-' + (st.icon || 'bluetooth').replace('fa-',''))
         .css('color', st.color || '#2563eb');
      $('#bt_status_text').text('Printer Bluetooth: ' + (st.label || 'Belum Terhubung')).css('color', st.color || '#1e293b');

      if (st.status === 'unpaired') {
         $('#btn_bt_pair').show().html('<i class="fa fa-bluetooth"></i> <span id="btn_bt_pair_text">Sambungkan Printer</span>');
         $('#btn_bt_unpair').hide();
         $('#bt_status_bar').css({'background': '#f8fafc', 'border-color': '#cbd5e1'});
      } else if (st.status === 'connected') {
         $('#btn_bt_pair').show().html('<i class="fa fa-refresh"></i> <span id="btn_bt_pair_text">Ganti Printer</span>');
         $('#btn_bt_unpair').show();
         $('#bt_status_bar').css({'background': '#ecfdf5', 'border-color': '#86efac'});
      } else {
         $('#btn_bt_pair').show().html('<i class="fa fa-bluetooth"></i> <span id="btn_bt_pair_text">Sambungkan Ulang</span>');
         $('#btn_bt_unpair').show();
         $('#bt_status_bar').css({'background': '#fffbeb', 'border-color': '#fde68a'});
      }
   }
}
window.update_bluetooth_status_ui = update_bluetooth_status_ui;

function show_receipt_modal(rc) {
   if (!rc) return;
   lastReceiptData = rc;
   try {
      var printThermalUrl = rc.print_struk_url || ('<?= site_url("administrator/sales_order/cetak_struk"); ?>/' + (rc.so_id || '') + '?template=thermal');
      var printLebarUrl   = rc.print_nota_lebar_url || ('<?= site_url("administrator/sales_order/cetak_struk"); ?>/' + (rc.so_id || '') + '?template=lebar');
      var printPdfUrl     = rc.print_pdf_url || ('<?= site_url("administrator/sales_order/cetak"); ?>/' + (rc.so_id || ''));

      $('#modal_nota_badge_so').text(rc.nomor_so || 'TRX');
      $('#receipt_preview_paper').html(render_receipt_preview_html(rc));
      $('#receipt_preview_lebar').html(render_receipt_lebar_preview_html(rc));

      $('#btn_modal_print_struk').data('print-url', printThermalUrl);
      $('#btn_modal_print_lebar').data('print-url', printLebarUrl);
      $('#btn_modal_print_pdf').attr('href', printPdfUrl);

      // Pastikan tombol Cetak BT selalu dalam kondisi aktif siap klik
      $('#btn_modal_print_bluetooth').prop('disabled', false).html('<i class="fa fa-bluetooth"></i> Cetak Menggunakan BT');

      if (typeof update_bluetooth_status_ui === 'function') {
         update_bluetooth_status_ui();
      }
   } catch(e) {
      console.error('Error preparing receipt modal content:', e);
   }

   // Default tab: Thermal POS preview
   try {
      $('#btn_modal_tab_thermal').click();
   } catch(e){}

   // Tampilkan Modal Nota Kasir
   $('#modal_nota_kasir').modal('show');
}

function generate_item_row_html(idx) {
   return '<tr id="item_row_' + idx + '" class="item-row" data-row="' + idx + '">' +
      '<td style="padding: 6px 8px; vertical-align: middle;">' +
         '<select class="form-control produk-select" name="items[' + idx + '][produk_id]" required style="width:100%;">' +
            build_options() +
         '</select>' +
      '</td>' +
      '<td style="padding: 6px 4px; vertical-align: middle; text-align: center;">' +
         '<input type="number" step="any" min="0.01" class="form-control qty-input text-center" name="items[' + idx + '][qty]" value="1" required style="font-weight:700;">' +
      '</td>' +
      '<td style="padding: 6px 4px; vertical-align: middle; text-align: center;">' +
         '<span class="satuan-badge">Pcs</span>' +
         '<input type="hidden" name="items[' + idx + '][satuan]" value="Pcs">' +
      '</td>' +
      '<td style="padding: 6px 6px; vertical-align: middle; text-align: right;">' +
         '<input type="text" class="form-control harga-input text-right" name="items[' + idx + '][harga_satuan]" value="0" required style="font-weight:700; color:#1e293b;">' +
      '</td>' +
      '<td style="padding: 6px 4px; vertical-align: middle; text-align: center;">' +
         '<input type="number" step="1" min="0" max="100" class="form-control disc-input text-center" name="items[' + idx + '][diskon_persen]" value="0" style="font-weight:600; color:#dc2626;">' +
      '</td>' +
      '<td style="padding: 6px 6px; vertical-align: middle; text-align: right;">' +
         '<input type="text" class="form-control subtotal-display text-right" value="Rp 0" data-subtotal="0" readonly style="font-weight:800; color:#059669; background:#ecfdf5; border:1px solid #86efac; cursor:default;">' +
      '</td>' +
      '<td style="padding: 6px 3px; vertical-align: middle; text-align: center;">' +
         '<span class="stok-display badge bg-gray" style="font-size:11px; padding:4px 6px; border-radius:12px; font-weight:700; display:inline-block; min-width:32px;">-</span>' +
      '</td>' +
      '<td style="padding: 6px 4px; vertical-align: middle; text-align: center;">' +
         '<button type="button" class="btn btn-sm btn-delete-row remove-row" title="Hapus / Kosongkan Baris">' +
            '<i class="fa fa-trash-o"></i>' +
         '</button>' +
      '</td>' +
   '</tr>';
}

function reset_pos_cart(next_so, next_ref) {
   if (next_so) {
      $('#display_nomor_so').text(next_so);
   }
   if (next_ref) {
      $('#nomor_referensi').val(next_ref);
   }
   $('#catatan').val('');
   $('#diskon_persen_total').val('0');
   $('#diskon_total').val('0');
   $('#pajak_persen').val('0');
   $('#uang_diterima').val('');
   $('#text_kembalian').text('Rp 0');
   $('#metode_pembayaran').val('tunai').trigger('change');

   // Reset baris item menjadi 1 baris kosong
   item_count = 1;
   $('#item_rows').html(generate_item_row_html(0));
   init_produk_select2($('#item_rows'));
   recalc_total();

   $('#btn_modal_print_bluetooth').prop('disabled', false).html('<i class="fa fa-bluetooth"></i> Cetak Menggunakan BT');
   $('#modal_nota_kasir').modal('hide');
}

function recalc_row($row) {
   var pid = $row.find('.produk-select').val();
   if (!pid) {
      $row.find('.harga-input').val('0');
      $row.find('.subtotal-display').val('Rp 0').data('subtotal', 0);
      recalc_total();
      return;
   }
   var qty = parseFloat($row.find('.qty-input').val()) || 0;
   var raw_harga = String($row.find('.harga-input').val()).replace(/[^0-9]/g, '');
   var harga = parseFloat(raw_harga) || 0;
   var disc = parseFloat($row.find('.disc-input').val()) || 0;
   var sub = Math.max(0, (qty * harga) * (1 - disc / 100));
   $row.find('.subtotal-display').val(format_rp(sub)).data('subtotal', sub);
   recalc_total();
}

function get_current_grand_total() {
   var sub = 0;
   $('.item-row').each(function(){
      var raw_sub = $(this).find('.subtotal-display').data('subtotal');
      if (raw_sub !== undefined && raw_sub !== null && raw_sub !== '') {
         sub += parseFloat(raw_sub) || 0;
      } else {
         var txt = String($(this).find('.subtotal-display').val() || '');
         sub += parseFloat(txt.replace(/[^0-9]/g, '')) || 0;
      }
   });
   var disc_pct = parseFloat($('#diskon_persen_total').val()) || 0;
   var dis_nominal = sub * (disc_pct / 100);
   var pjk_pct = parseFloat($('#pajak_persen').val()) || 0;
   var after_disc = Math.max(0, sub - dis_nominal);
   var pjk_nominal = after_disc * (pjk_pct / 100);
   return Math.round(after_disc + pjk_nominal);
}

function recalc_total() {
   var gross_sub = 0;
   var item_disc_nom = 0;
   var sub = 0;
   var count_items = 0;
   var total_qty = 0;
   $('.item-row').each(function(){
      var pid = $(this).find('.produk-select').val();
      var raw_sub = $(this).find('.subtotal-display').data('subtotal');
      var s = 0;
      if (raw_sub !== undefined && raw_sub !== null && raw_sub !== '') {
         s = parseFloat(raw_sub) || 0;
      } else {
         var txt = String($(this).find('.subtotal-display').val() || '');
         s = parseFloat(txt.replace(/[^0-9]/g, '')) || 0;
      }
      var q = parseFloat($(this).find('.qty-input').val()) || 0;
      var raw_harga = String($(this).find('.harga-input').val() || '').replace(/[^0-9]/g, '');
      var h = parseFloat(raw_harga) || 0;
      var disc = parseFloat($(this).find('.disc-input').val()) || 0;

      if (pid) {
         var line_gross = q * h;
         var line_disc = line_gross * (disc / 100);
         gross_sub += line_gross;
         item_disc_nom += line_disc;
         sub += s;
         count_items++;
         total_qty += q;
      }
   });
   
   var disc_pct = parseFloat($('#diskon_persen_total').val()) || 0;
   var dis_nominal = sub * (disc_pct / 100);
   $('#diskon_total').val(dis_nominal.toFixed(0));

   var total_all_disc = item_disc_nom + dis_nominal;
   
   var pjk_pct = parseFloat($('#pajak_persen').val()) || 0;
   var after_disc = Math.max(0, sub - dis_nominal);
   var pjk_nominal = after_disc * (pjk_pct / 100);
   var total = Math.round(after_disc + pjk_nominal);
   
   $('#display_grand_total_big').text(format_rp(total));

   // Breakdown Mini Card: Selaras & Sinkron 100% dengan Subtotal Keranjang & Diskon Nota
   $('#text_subtotal_mini').text(format_rp(sub));
   if (disc_pct > 0) {
      $('#text_disc_mini').html('-' + format_rp(dis_nominal) + ' <small style="font-size:10px;">(' + disc_pct + '%)</small>').removeClass('text-muted').addClass('text-danger');
   } else {
      $('#text_disc_mini').text('0%').removeClass('text-danger').addClass('text-muted');
   }
   $('#text_pajak_mini').text(pjk_pct > 0 ? ('+' + format_rp(pjk_nominal) + ' (' + pjk_pct + '%)') : '0%');

   // Update Table Footer & Info Hemat Diskon
   $('#display_subtotal_items').text(format_rp(sub));
   if (item_disc_nom > 0) {
      $('#text_item_disc_info_val').text('-' + format_rp(item_disc_nom));
      $('#text_item_disc_info').show();
      $('#footer_gross_val').text(format_rp(gross_sub));
      $('#footer_gross_wrap').show();
      $('#footer_item_disc_val').text('-' + format_rp(item_disc_nom));
      $('#footer_item_disc_wrap').show();
   } else {
      $('#text_item_disc_info').hide();
      $('#footer_gross_wrap').hide();
      $('#footer_item_disc_wrap').hide();
   }

   var countText = count_items > 0 ? (count_items + ' Jenis Item (' + total_qty + ' pcs)') : '0 Item (0 pcs)';
   $('#count_items').text(countText);
   $('#count_items_label').text(countText);

   // Update Mobile Floating Checkout Bar
   $('#mobile_bar_total').text(format_rp(total));
   $('#mobile_bar_items').text(count_items > 0 ? (count_items + ' item (' + total_qty + ' pcs)') : '0 item');

   // Auto set default uang pas if uang_diterima is exact, empty, or flagged as uang-pas
   var currUang = parseFloat($('#uang_diterima').val().replace(/[^0-9]/g, '')) || 0;
   var isUangPas = $('#uang_diterima').data('is-uang-pas');
   if (currUang === 0 || currUang === total || isUangPas) {
      $('#uang_diterima').val(format_num_id(total)).data('is-uang-pas', true);
   }
   calculate_change();
}

function calculate_change() {
   var total = get_current_grand_total();
   var raw = $('#uang_diterima').val().replace(/[^0-9]/g, '');
   var bayar = parseFloat(raw) || 0;
   var diff = bayar - total;

   if (diff >= 0) {
      $('#text_kembalian').removeClass('text-danger').addClass('text-success').html('Rp ' + format_num_id(diff));
      $('#box_kembalian').css({'border-color': '#86efac', 'background': '#f0fdf4'});
   } else {
      $('#text_kembalian').removeClass('text-success').addClass('text-danger').html('- Rp ' + format_num_id(Math.abs(diff)) + ' <span style="font-size:11px; font-weight:normal;">(Kurang)</span>');
      $('#box_kembalian').css({'border-color': '#fca5a5', 'background': '#fef2f2'});
   }
}

function validate_row_qty($row) {
   var $qtyInp  = $row.find('.qty-input');
   var qty      = parseFloat($qtyInp.val()) || 0;
   var stokMax  = parseFloat($qtyInp.data('stok-max'));
   if (isNaN(stokMax)) {
      stokMax = parseFloat($row.find('.stok-display').text()) || 0;
   }
   
   $row.find('.stok-warn-msg').remove();

   if (stokMax > 0 && qty > stokMax) {
      $qtyInp.val(stokMax);
      $qtyInp.css({'border': '2px solid #ef4444', 'background-color': '#fef2f2'});
      $qtyInp.after('<small class="text-danger stok-warn-msg" style="display:block; font-weight:600; font-size:11px; margin-top:2px;"><i class="fa fa-exclamation-triangle"></i> Max: ' + stokMax + '</small>');
      if (typeof swal !== 'undefined') {
         swal("Stok Terbatas!", "Jumlah pembelian otomatis disesuaikan dengan stok tersedia (" + stokMax + " unit).", "warning");
      }
      recalc_row($row);
   } else {
      $qtyInp.css({'border': '', 'background-color': ''});
   }
}

function cek_stok(produk_id, $span) {
   if(!produk_id) {
      $span.text('-').removeClass('bg-green bg-red').addClass('bg-gray');
      return;
   }
   var $row = $span.closest('.item-row');

   // 1. Eksekusi instan: Ambil stok dari cache lokal tanpa jeda jaringan
   var localStok = null;
   var $opt = $row.find('.produk-select option:selected');
   if ($opt.length && $opt.data('stok') !== undefined && $opt.data('stok') !== '') {
      localStok = parseFloat($opt.data('stok'));
   }
   if (localStok === null && available_produks && available_produks.length > 0) {
      var found = available_produks.find(function(p){ return parseInt(p.id) === parseInt(produk_id); });
      if (found && (found.qty !== undefined || found.stok !== undefined)) {
         localStok = parseFloat(found.qty !== undefined ? found.qty : found.stok);
      }
   }
   if (localStok === null && produks_initial && produks_initial.length > 0) {
      var foundInit = produks_initial.find(function(p){ return parseInt(p.id) === parseInt(produk_id); });
      if (foundInit && (foundInit.qty !== undefined || foundInit.stok !== undefined)) {
         localStok = parseFloat(foundInit.qty !== undefined ? foundInit.qty : foundInit.stok);
      }
   }

   // Terapkan seketika (instant visual feedback)
   if (localStok !== null && !isNaN(localStok)) {
      $row.find('.qty-input').data('stok-max', localStok).attr('max', localStok);
      if (localStok > 0) {
         $span.text(localStok).removeClass('bg-red bg-gray').addClass('bg-green');
      } else {
         $span.text('0').removeClass('bg-green bg-gray').addClass('bg-red');
      }
      validate_row_qty($row);
   }

   // 2. Sinkronkan via AJAX di latar belakang
   $.get(get_same_origin_url('<?= site_url("administrator/produk/cek_stok"); ?>'), {produk_id: produk_id}, function(r){
      if (r && r.success && r.stok !== undefined) {
         var stok_num = parseFloat(r.stok) || 0;
         $row.find('.qty-input').data('stok-max', stok_num).attr('max', stok_num);
         if (stok_num > 0) {
            $span.text(stok_num).removeClass('bg-red bg-gray').addClass('bg-green');
         } else {
            $span.text('0').removeClass('bg-green bg-gray').addClass('bg-red');
         }
         validate_row_qty($row);
      }
   }, 'json').fail(function(){
      // Jika AJAX gagal atau offline, gunakan stok lokal yang sudah ada
      if (localStok !== null && !isNaN(localStok)) {
         $row.find('.qty-input').data('stok-max', localStok).attr('max', localStok);
         if (localStok > 0) {
            $span.text(localStok).removeClass('bg-red bg-gray').addClass('bg-green');
         } else {
            $span.text('0').removeClass('bg-green bg-gray').addClass('bg-red');
         }
      }
   });
}

function get_harga_by_tipe(produk_id, tipe_pelanggan) {
   if (!produk_id) return 0;
   var list = (available_produks && available_produks.length > 0) ? available_produks : produks_initial;
   var p = list.find(function(x) { return parseInt(x.id) === parseInt(produk_id); });
   if (!p && produks_initial && produks_initial.length > 0) {
      p = produks_initial.find(function(x) { return parseInt(x.id) === parseInt(produk_id); });
   }
   if (!p) {
      var optHarga = parseFloat($('option[value="' + produk_id + '"]').data('harga')) || 0;
      return optHarga;
   }
   if (!tipe_pelanggan) return parseFloat(p.harga_jual || 0);
   tipe_pelanggan = $.trim(tipe_pelanggan).toLowerCase();
   if (tipe_pelanggan === 'grosir' && parseFloat(p.harga_jual_grosir) > 0) return parseFloat(p.harga_jual_grosir);
   if (tipe_pelanggan === 'distributor' && parseFloat(p.harga_jual_distributor) > 0) return parseFloat(p.harga_jual_distributor);
   if (tipe_pelanggan === 'vip' && parseFloat(p.harga_jual_vip) > 0) return parseFloat(p.harga_jual_vip);
   return parseFloat(p.harga_jual || 0);
}

function get_satuan_by_produk(produk_id) {
   if (!produk_id) return 'Pcs';
   var list = (available_produks && available_produks.length > 0) ? available_produks : produks_initial;
   var p = list.find(function(x) { return parseInt(x.id) === parseInt(produk_id); });
   if (!p && produks_initial && produks_initial.length > 0) {
      p = produks_initial.find(function(x) { return parseInt(x.id) === parseInt(produk_id); });
   }
   if (!p) return 'Pcs';
   return p.nama_satuan || p.satuan || 'Pcs';
}

$(document).ready(function(){
   if (typeof $.fn.select2 === 'function') {
      $('#pelanggan_id').select2({
         placeholder: '-- Ketik Nama Manual / Pilih Pelanggan --',
         allowClear: true,
         tags: true,
         width: '100%'
      });
      init_produk_select2();
   }


   $('#btn_add_item').click(function(){
      var idx = item_count++;
      $('#item_rows').append(generate_item_row_html(idx));
      var $new_row = $('#item_rows tr:last');
      init_produk_select2($new_row);
      cek_stok($new_row.find('.produk-select').val(), $new_row.find('.stok-display'));
   });

   $(document).on('change', '.produk-select', function(){
      var $row = $(this).closest('.item-row');
      var pid = $(this).val();
      if (pid) {
         // Cek stok produk yang dipilih, tolak jika 0
         var $opt = $(this).find('option:selected');
         var optStok = parseFloat($opt.data('stok'));
         if (!isNaN(optStok) && optStok <= 0) {
            show_alert('Produk "' + $opt.text().trim() + '" stoknya habis (0). Tidak bisa ditambahkan ke keranjang.', 'warning');
            $(this).val('').trigger('change.select2');
            return;
         }
      }
      var tipe = $('#pelanggan_id option:selected').data('tipe') || '';
      var harga = get_harga_by_tipe(pid, tipe);
      var satuan = get_satuan_by_produk(pid);
      $row.find('.harga-input').val(format_num_id(harga));
      $row.find('input[name*="[satuan]"]').val(satuan);
      $row.find('.satuan-badge').text(satuan);
      recalc_row($row);
      cek_stok(pid, $row.find('.stok-display'));
   });

   $(document).on('input keyup change', '.qty-input', function(){
      var $row = $(this).closest('.item-row');
      recalc_row($row);
      validate_row_qty($row);
   });
   $(document).on('input keyup', '.harga-input', function(){
      var raw = $(this).val().replace(/[^0-9]/g, '');
      if (raw) {
         $(this).val(format_num_id(raw));
      } else {
         $(this).val('0');
      }
      recalc_row($(this).closest('.item-row'));
   });
   $(document).on('input keyup change', '.disc-input', function(){
      recalc_row($(this).closest('.item-row'));
   });
   $(document).on('click', '.remove-row', function(){
      if($('.item-row').length > 1){
         $(this).closest('.item-row').remove();
         recalc_total();
      } else {
         var $row = $(this).closest('.item-row');
         $row.find('.produk-select').val('').trigger('change');
         $row.find('.qty-input').val('1');
         $row.find('input[name*="[satuan]"]').val('Pcs');
         $row.find('.satuan-badge').text('Pcs');
         $row.find('.harga-input').val('0');
         $row.find('.disc-input').val('0');
         $row.find('.subtotal-display').val('Rp 0').data('subtotal', 0);
         $row.find('.stok-display').text('-').removeClass('bg-green bg-red').addClass('bg-gray');
         recalc_total();
      }
   });
   $('#diskon_persen_total, #pajak_persen').on('input change', function(){
      recalc_total();
   });

   // Terapkan diskon tambahan ke seluruh baris produk di tabel
   $('#btn_apply_disc_to_all').click(function(){
      var discVal = parseFloat($('#diskon_persen_total').val()) || 0;
      if (discVal <= 0) {
         if (typeof swal !== 'undefined') {
            swal("Diskon Kosong", "Isi nilai Diskon Tambahan Nota (%) terlebih dahulu.", "warning");
         } else {
            alert("Isi nilai Diskon Tambahan Nota (%) terlebih dahulu!");
         }
         return;
      }
      var countApplied = 0;
      $('.item-row').each(function(){
         var pid = $(this).find('.produk-select').val();
         if (pid) {
            $(this).find('.disc-input').val(discVal);
            recalc_row($(this));
            countApplied++;
         }
      });
      // Reset diskon nota ke 0 agar tidak terpotong ganda
      $('#diskon_persen_total').val(0);
      recalc_total();
      if (typeof toastr !== 'undefined') {
         toastr.success("Diskon " + discVal + "% berhasil disinkronkan ke " + countApplied + " item produk!");
      } else if (typeof swal !== 'undefined') {
         swal("Berhasil Sinkron!", "Diskon " + discVal + "% telah diterapkan ke " + countApplied + " item produk di keranjang.", "success");
      }
   });
   

   function render_customer_chip() {
      var val = $('#pelanggan_id').val();
      if (!val) {
         $('#customer_info_chip').hide();
         $('#cust_input_telepon').val('');
         $('#cust_input_alamat').val('');
         $('#cust_input_kota').val('');
         $('#cust_input_tipe').val('');
         return;
      }
      var $opt = $('#pelanggan_id option:selected');
      var rawNama = $opt.data('nama') || $opt.text() || val;
      // Bersihkan jika ada format [RETAIL] atau (telepon) dari teks option
      var nama = rawNama.replace(/\s*\[.*?\]/g, '').replace(/\s*\(.*?\)/g, '').trim();
      if (!nama) nama = rawNama;
      
      var tipe = ($opt.data('tipe') || 'retail').toString().toLowerCase();
      var telp = $opt.data('telp') || '';
      var alamat = $opt.data('alamat') || '';
      var kota = $opt.data('kota') || '';

      // Set input hidden untuk form sales_order
      $('#cust_input_telepon').val(telp);
      $('#cust_input_alamat').val(alamat);
      $('#cust_input_kota').val(kota);
      $('#cust_input_tipe').val(tipe);

      $('#chip_cust_nama').text(nama);
      $('#chip_cust_telp').text(telp ? telp : '(No HP belum diisi)');
      
      if (alamat || kota) {
         var alamat_str = alamat ? alamat : '';
         if (kota) alamat_str += (alamat_str ? ', ' : '') + kota;
         $('#chip_cust_alamat').text(alamat_str);
         $('#chip_cust_alamat_wrapper').show();
      } else {
         $('#chip_cust_alamat_wrapper').hide();
      }

      $('#customer_info_chip').slideDown(150);
   }

   $('#pelanggan_id').on('change', function(){
      render_customer_chip();
      var tipe = $(this).find(':selected').data('tipe') || '';
      $('.item-row').each(function(){
         var pid = $(this).find('.produk-select').val();
         if(pid){
            var h = get_harga_by_tipe(pid, tipe);
            $(this).find('.harga-input').val(format_num_id(h));
            recalc_row($(this));
         }
      });
   });
   render_customer_chip();

   // Payment Method change handler
   $('#metode_pembayaran').on('change', function(){
      var m = $(this).val();
      if (m === 'tunai') {
         $('#akun_kas_bank').val('Cash');
         $('#section_uang_tunai').slideDown(150);
      } else {
         $('#akun_kas_bank').val('Transfer Bank');
         $('#section_uang_tunai').slideUp(150);
      }
   });

   $('#uang_diterima').on('input keyup', function(){
      $('#uang_diterima').data('is-uang-pas', false);
      var raw = $(this).val().replace(/[^0-9]/g, '');
      if (raw) {
         $(this).val(format_num_id(raw));
      } else {
         $(this).val('');
      }
      calculate_change();
   });

   // Quick Cash Preset Handler
   $(document).on('click', '.btn-quick-cash', function(e){
      e.preventDefault();
      var action = $(this).data('cash');
      var total = get_current_grand_total();
      if (action === 'pas') {
         $('#uang_diterima').val(format_num_id(total)).data('is-uang-pas', true);
      } else if (action === 'clear') {
         $('#uang_diterima').val('').data('is-uang-pas', false);
      } else {
         var val = parseFloat(action) || 0;
         $('#uang_diterima').val(format_num_id(val)).data('is-uang-pas', false);
      }
      calculate_change();
   });

   // Submit Sales Order Cepat
   $('#btn_submit_cepat').click(function(){
      if (!$('#pelanggan_id').val()) {
         show_alert('Pilih atau ketik nama Pelanggan terlebih dahulu!', 'warning');
         return;
      }

      var hasItems = false;
      var is_valid = true;
      var err_msg = '';

      $('.item-row').each(function() {
         var $sel = $(this).find('.produk-select');
         var pid = $sel.val();
         var qty = parseFloat($(this).find('.qty-input').val()) || 0;
         var stok = parseFloat($(this).find('.stok-display').text()) || 0;
         var prod_nama = $sel.find('option:selected').text();

         if (pid) {
            hasItems = true;
            if (qty <= 0) {
               is_valid = false;
               err_msg = 'Qty penjualan harus lebih dari 0!';
               return false;
            }
            if (stok <= 0) {
               is_valid = false;
               err_msg = 'Produk (' + prod_nama + ') stoknya HABIS (0). Hapus item ini dari keranjang, atau ganti dengan produk lain.';
               return false;
            }
            if (qty > stok) {
               is_valid = false;
               err_msg = 'Qty pesanan untuk (' + prod_nama + ') sejumlah ' + qty + ' melebihi Stok yang tersedia (' + stok + ')!';
               return false;
            }
         }
      });

      if (!hasItems) {
         show_alert('Pilih minimal 1 item produk pesanan!', 'warning');
         return;
      }
      if (!is_valid) {
         show_alert(err_msg, 'warning');
         return;
      }

      var total = get_current_grand_total();
      if (total <= 0) {
         show_alert('Total pesanan harus lebih dari Rp 0!', 'warning');
         return;
      }

      var metode = $('#metode_pembayaran').val();
      var rawUang = $('#uang_diterima').val().replace(/[^0-9]/g, '');
      var uang = parseFloat(rawUang) || 0;

      if (metode === 'tunai' && uang < total) {
         show_alert('Nominal uang diterima (Rp ' + format_num_id(uang) + ') masih kurang dari Total Tagihan (Rp ' + format_num_id(total) + ')!', 'warning');
         $('#uang_diterima').focus();
         return;
      }

      var kembalian = Math.max(0, uang - total);
      var catatan_bayar = 'Pembayaran Lunas POS ' + '<?= $nomor_baru; ?>';
      if (metode === 'tunai') {
         catatan_bayar += ' [Uang Diterima: Rp ' + format_num_id(uang) + ', Kembalian: Rp ' + format_num_id(kembalian) + ']';
      }

      var $btn = $(this);
      var origHtml = $btn.html();
      $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> MEMPROSES TRANSAKSI...');

      var formData = $('#form_so_cepat').serialize() + '&catatan_bayar=' + encodeURIComponent(catatan_bayar);

      $.ajax({
         url: get_same_origin_url('<?= site_url("administrator/sales_order/cepat_save"); ?>'),
         method: 'POST',
         data: formData,
         dataType: 'json',
         success: function(res){
            if (res.success) {
               $btn.prop('disabled', false).html(origHtml);

               // Simpan data struk transaksi & nomor urut berikutnya
               lastReceiptData = res.receipt;
               nextSoNumber = res.next_nomor_so || '';
               nextRefNumber = res.next_nomor_ref || '';

               // Aktifkan tombol nota terakhir di header
               $('#btn_cetak_ulang_last').show();

               // Mainkan bunyi sukses POS
               play_pos_success_sound();

               // Tampilkan modal nota kasir & update riwayat live
               if (res.receipt) {
                  if (typeof add_transaction_to_history === 'function') {
                     add_transaction_to_history(res.receipt);
                  }
                  show_receipt_modal(res.receipt);
               } else if (res.redirect) {
                  window.location.href = res.redirect;
               }
            } else {
               show_alert(res.message || 'Gagal menyimpan transaksi POS.', 'error');
               $btn.prop('disabled', false).html(origHtml);
            }
         },
         error: function(xhr, status, error){
            console.error('AJAX SAVE ERROR:', xhr, status, error);
            var msg = 'Gagal menyimpan transaksi';
            try {
               var r = JSON.parse(xhr.responseText);
               if (r && r.message) {
                  msg = r.message;
               } else if (xhr.responseText) {
                  msg = 'Server (' + (xhr.status || status) + '): ' + xhr.responseText.replace(/<[^>]*>?/gm, ' ').replace(/\s+/g, ' ').substring(0, 150);
               }
            } catch(e){
               if (xhr.responseText) {
                  msg = 'Server (' + (xhr.status || status) + '): ' + xhr.responseText.replace(/<[^>]*>?/gm, ' ').replace(/\s+/g, ' ').substring(0, 150);
               } else {
                  msg = 'Koneksi error (' + (xhr.status || status) + '): ' + (error || 'Respon kosong atau koneksi ditolak');
               }
            }
            show_alert(msg, 'error');
            $btn.prop('disabled', false).html(origHtml);
         }
      });
   });

   // Refresh customer list
   $('#btn_refresh_pelanggan').click(function(){
      var $btn = $(this);
      $btn.html('<i class="fa fa-spinner fa-spin"></i>');
      $.getJSON(get_same_origin_url('<?= site_url("administrator/pelanggan/get_list_json"); ?>'), function(res){
         if (res && res.status && res.data) {
            var currVal = $('#pelanggan_id').val();
            var html = '<option value="">-- Ketik / Cari Nama / Telp Pelanggan --</option>';
            $.each(res.data, function(i, p){
               var telp = p.no_telp || p.telepon || '';
               var telp_fmt = telp ? ' (' + telp + ')' : '';
               var sel = (currVal == p.id) ? ' selected' : '';
               html += '<option value="' + p.id + '" data-kode="' + (p.kode_pelanggan||'') + '" data-nama="' + (p.nama_pelanggan||'') + '" data-tipe="' + (p.tipe_pelanggan||'') + '" data-telp="' + telp + '"' + sel + '>' + (p.nama_pelanggan||'') + telp_fmt + '</option>';
            });
            $('#pelanggan_id').html(html).trigger('change');
            show_alert('Daftar pelanggan berhasil diperbarui!', 'success');
         }
         $btn.html('<i class="fa fa-refresh"></i> Segarkan');
      }).fail(function(){
         $btn.html('<i class="fa fa-refresh"></i> Segarkan');
      });
   });

   // Mobile Floating Checkout Smooth Scroll
   $('#btn_scroll_bayar').click(function(e){
      e.preventDefault();
      var $target = $('#terminal_kasir');
      if ($target.length) {
         $('html, body').animate({
            scrollTop: $target.offset().top - 15
         }, 400, function(){
            $('#uang_diterima').focus();
         });
      }
   });

   // Buka Modal Tambah Pelanggan Baru
   $('#btn_open_modal_cust').click(function(){
      var currentVal = $('#pelanggan_id').val();
      var inputNama = '';
      if (currentVal && isNaN(currentVal)) {
         inputNama = currentVal.replace(/\s*\[.*?\]/g, '').replace(/\s*\(.*?\)/g, '').trim();
      }
      $('#modal_cust_nama').val(inputNama);
      $('#modal_cust_telp').val('');
      $('#modal_cust_tipe').val('retail');
      $('#modal_cust_alamat').val('');
      $('#modal_cust_kota').val('');
      $('#modal_cust_email').val('');
      $('#modal_add_pelanggan').modal('show');
      setTimeout(function(){
         if (!inputNama) {
            $('#modal_cust_nama').focus();
         } else {
            $('#modal_cust_telp').focus();
         }
      }, 350);
   });

   // Buka Modal Lengkapi / Edit Data dari Chip Pelanggan
   $('#btn_edit_cust_chip').click(function(){
      var $opt = $('#pelanggan_id option:selected');
      var currentVal = $('#pelanggan_id').val();
      var rawNama = $opt.data('nama') || $opt.text() || currentVal || '';
      var nama = rawNama.replace(/\s*\[.*?\]/g, '').replace(/\s*\(.*?\)/g, '').trim();
      var telp = $opt.data('telp') || $('#cust_input_telepon').val() || '';
      var tipe = ($opt.data('tipe') || $('#cust_input_tipe').val() || 'retail').toString().toLowerCase();
      var alamat = $opt.data('alamat') || $('#cust_input_alamat').val() || '';
      var kota = $opt.data('kota') || $('#cust_input_kota').val() || '';

      $('#modal_cust_nama').val(nama);
      $('#modal_cust_telp').val(telp);
      $('#modal_cust_tipe').val(tipe);
      $('#modal_cust_alamat').val(alamat);
      $('#modal_cust_kota').val(kota);
      $('#modal_add_pelanggan').modal('show');
      setTimeout(function(){
         if (!telp) {
            $('#modal_cust_telp').focus();
         } else {
            $('#modal_cust_alamat').focus();
         }
      }, 350);
   });

   // Submit Modal Tambah/Lengkapi Data Pelanggan via AJAX
   $('#btn_submit_modal_pelanggan').click(function(){
      var nama = $.trim($('#modal_cust_nama').val());
      var telp = $.trim($('#modal_cust_telp').val());
      var tipe = $('#modal_cust_tipe').val() || 'retail';
      var alamat = $.trim($('#modal_cust_alamat').val());
      var kota = $.trim($('#modal_cust_kota').val());
      var email = $.trim($('#modal_cust_email').val());

      if (!nama) {
         show_alert('Nama Pelanggan wajib diisi!', 'warning');
         $('#modal_cust_nama').focus();
         return;
      }
      if (!telp) {
         show_alert('No. Telepon / WhatsApp wajib diisi agar terekap di CRM!', 'warning');
         $('#modal_cust_telp').focus();
         return;
      }

      var $btn = $(this);
      var origHtml = $btn.html();
      $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan Data...');

      $.ajax({
         url: get_same_origin_url('<?= site_url("administrator/sales_order/ajax_add_pelanggan"); ?>'),
         method: 'POST',
         data: {
            nama_pelanggan: nama,
            telepon: telp,
            tipe_pelanggan: tipe,
            alamat: alamat,
            kota: kota,
            email: email
         },
         dataType: 'json',
         success: function(res){
            $btn.prop('disabled', false).html(origHtml);
            if (res && res.success && res.data) {
               var p = res.data;
               var telpFmt = p.telp ? ' (' + p.telp + ')' : '';
               var optionText = p.nama + telpFmt;
               
               // Tambahkan ke dropdown select2 dan pilih
               var newOption = new Option(optionText, p.id, true, true);
               $(newOption)
                  .attr('data-kode', p.kode)
                  .attr('data-nama', p.nama)
                  .attr('data-tipe', p.tipe)
                  .attr('data-telp', p.telp)
                  .attr('data-alamat', p.alamat)
                  .attr('data-kota', p.kota);

               $('#pelanggan_id').append(newOption).val(p.id).trigger('change');
               $('#modal_add_pelanggan').modal('hide');
               show_alert('Data pelanggan "' + p.nama + '" berhasil disimpan & dipilih!', 'success');
            } else {
               show_alert(res.message || 'Gagal menyimpan data pelanggan.', 'error');
            }
         },
         error: function(){
            $btn.prop('disabled', false).html(origHtml);
            show_alert('Terjadi kesalahan server saat menyimpan data pelanggan.', 'error');
         }
      });
   });

   // Web Bluetooth Connection State Manager & UI Sync

   if (window.ThermalPrinter) {
      window.ThermalPrinter.onStateChange(function(){
         update_bluetooth_status_ui();
      });
      update_bluetooth_status_ui();
   }

   // ---- Tombol Sambungkan/Pair Printer Bluetooth (Pop-up Pairing Seketika) ----
   $('#btn_bt_pair, #btn_top_bt_printer').click(async function(e){
      e.preventDefault();
      if (!window.ThermalPrinter) return;
      if (!window.isSecureContext) {
         handle_insecure_bluetooth_action();
         return;
      }
      var $btn = $(this);
      var origHtml = $btn.html();
      try {
         $btn.prop('disabled', true);
         // Panggil pair() secara langsung di baris pertama klik agar pop-up dialog browser muncul seketika!
         await window.ThermalPrinter.pair();
         update_bluetooth_status_ui();
         if (typeof toastr !== 'undefined') {
            toastr.success('Printer ' + (window.ThermalPrinter.getDeviceName() || 'Bluetooth') + ' berhasil tersambung!', 'Bluetooth Siap ✓');
         }
      } catch(err) {
         console.warn('Bluetooth pair error:', err);
         var isPairCancelled = err.name === 'NotFoundError' || err.name === 'AbortError' || (err.message && /cancel/i.test(err.message));
         if (!isPairCancelled) {
            show_alert('Gagal menyambungkan Bluetooth: ' + (err.message || err), 'warning');
         }
      } finally {
         $btn.prop('disabled', false).html(origHtml);
         update_bluetooth_status_ui();
      }
   });

   // ---- Tombol Putuskan / Lupakan Printer ----
   $('#btn_bt_unpair').click(function(e){
      e.preventDefault();
      if (!window.ThermalPrinter) return;
      window.ThermalPrinter.unpair();
      update_bluetooth_status_ui();
      if (typeof toastr !== 'undefined') {
         toastr.info('Printer Bluetooth diputuskan.', 'Bluetooth');
      }
   });

   // Helper cetak struk via browser popup window (fallback / USB / printer biasa)
   function do_browser_receipt_print() {
      // Cetak langsung menggunakan iframe tersembunyi agar TIDAK MEMBUKA TAB / RUTE BARU!
      var isLebar = $('#container_preview_lebar').is(':visible');
      var html = isLebar 
         ? $('#receipt_preview_lebar').html() 
         : $('#receipt_preview_paper').html();

      var pageStyle = isLebar 
         ? '@page{margin:10mm;size:A4 portrait;}body{margin:0;font-family:Arial,sans-serif;font-size:12px;color:#000;}' 
         : '@page{margin:0;size:58mm auto;}body{margin:2mm;font-family:monospace;font-size:12px;color:#000;}';

      var $iframe = $('#receipt_print_iframe');
      if (!$iframe.length) {
         $iframe = $('<iframe id="receipt_print_iframe" style="position:fixed;right:0;bottom:0;width:0;height:0;border:0;visibility:hidden;"></iframe>').appendTo('body');
      }
      var ifDoc = $iframe[0].contentWindow.document;
      ifDoc.open();
      ifDoc.write('<html><head><title>Struk Transaksi Kasir</title><style>' + pageStyle + '</style></head><body>' + html + '</body></html>');
      ifDoc.close();
      setTimeout(function(){
         try {
            $iframe[0].contentWindow.focus();
            $iframe[0].contentWindow.print();
         } catch(e) {
            console.warn('Iframe print error:', e);
         }
      }, 300);
   }

   // ---- Tombol Cetak Menggunakan BT ----
   // Ketika tombol ini diklik: jika belum tersambung, dialog browser pairing LANGSUNG MUNCUL SEKETIKA DI LAYAR!
   // Tidak ada routing / tidak membuka tab baru sama sekali!
   $('#btn_modal_print_bluetooth, #btn_modal_main_print').click(async function(e){
      e.preventDefault();
      if (!lastReceiptData) {
         show_alert('Data struk pesanan tidak ditemukan.', 'warning');
         return;
      }

      // Jika format faktur lebar (A4) yang sedang aktif di tab -> cetak via browser langsung
      if ($('#container_preview_lebar').is(':visible')) {
         do_browser_receipt_print();
         return;
      }

      if (!window.isSecureContext) {
         handle_insecure_bluetooth_action();
         return;
      }

      // Cek ketersediaan Web Bluetooth API pada browser ini
      if (!window.ThermalPrinter || !window.ThermalPrinter.isSupported()) {
         // JANGAN PERNAH ROUTE / BUKA HALAMAN BARU!
         // Berikan peringatan langsung di modal kasir bahwa browser ini (Opera GX) mematikan Web Bluetooth
         if (typeof swal !== 'undefined') {
            swal({
               title: "Web Bluetooth Butuh Chrome / Edge",
               text: "Browser Opera GX mematikan fitur Web Bluetooth secara bawaan.\n\nAgar jendela pairing Bluetooth langsung muncul seketika, silakan buka kasir ini di Google Chrome atau Microsoft Edge di alamat:\n" + window.location.href + "\n\n(Kedua browser ini sudah terpasang di komputer Anda)",
               type: "warning",
               showCancelButton: true,
               confirmButtonColor: "#2563eb",
               cancelButtonColor: "#64748b",
               confirmButtonText: "Salin Link POS untuk Chrome/Edge",
               cancelButtonText: "Cetak Biasa (USB)",
               closeOnConfirm: true
            }, function(isConfirm){
               if (isConfirm) {
                  if (navigator.clipboard) {
                     navigator.clipboard.writeText(window.location.href);
                  }
                  if (typeof toastr !== 'undefined') {
                     toastr.success('Link POS berhasil disalin ke clipboard! Silakan paste di Chrome atau Edge.', 'Berhasil Salin ✓');
                  }
               } else {
                  do_browser_receipt_print();
               }
            });
         } else {
            show_alert('Web Bluetooth tidak didukung di browser ini. Harap buka via Google Chrome atau Microsoft Edge.', 'warning');
         }
         return;
      }

      var $btn = $(this);
      var defaultBtnHtml = '<i class="fa fa-bluetooth"></i> Cetak Menggunakan BT';

      try {
         $btn.prop('disabled', true);

         // Langsung panggil pairAndPrint() - jika belum terhubung, navigator.bluetooth.requestDevice LANGSUNG MUNCUL SEKETIKA DI LAYAR!
         if (!window.ThermalPrinter.isConnected()) {
            $btn.html('<i class="fa fa-bluetooth"></i> Memilih Printer Bluetooth...');
         } else {
            $btn.html('<i class="fa fa-spinner fa-spin"></i> Mengirim ke Printer...');
         }

         await window.ThermalPrinter.pairAndPrint(lastReceiptData, function(percent){
            $btn.html('<i class="fa fa-spinner fa-spin"></i> Mencetak ' + percent + '%...');
         });

         $btn.html('<i class="fa fa-check"></i> Berhasil Dicetak!');
         if (typeof toastr !== 'undefined') {
            toastr.success('Struk berhasil dicetak ke ' + (window.ThermalPrinter.getDeviceName() || 'Thermal Bluetooth') + '!', 'Cetak Sukses ✓');
         }
         setTimeout(function(){
            $btn.html(defaultBtnHtml).prop('disabled', false);
         }, 2500);
      } catch(err) {
         console.warn('Bluetooth print error:', err);
         $btn.prop('disabled', false).html(defaultBtnHtml);
         var isPrintCancelled = err.name === 'NotFoundError' || err.name === 'AbortError' || (err.message && /cancel/i.test(err.message));
         if (isPrintCancelled) {
            // Kasir membatalkan dialog pencarian Bluetooth
            if (typeof toastr !== 'undefined') {
               toastr.info('Pencarian printer Bluetooth dibatalkan.', 'Bluetooth');
            }
         } else {
            show_alert('Gagal cetak Bluetooth: ' + (err.message || err), 'warning');
         }
      } finally {
         update_bluetooth_status_ui();
      }
   });

   // Tombol Cetak Browser / USB (Dialog cetak standar browser)
   $('#btn_modal_print_browser').click(function(e){
      e.preventDefault();
      do_browser_receipt_print();
   });

   // Tombol Selesai (Siap Transaksi Berikutnya)
   $('#btn_modal_main_selesai').click(function(){
      reset_pos_cart(nextSoNumber, nextRefNumber);
   });

   // Template Switcher Tab di dalam Modal Kasir
   $('#btn_modal_tab_thermal').click(function(){
      $('#btn_modal_tab_lebar').removeClass('btn-info').addClass('btn-default').css({'color': '#0284c7'});
      $(this).removeClass('btn-default').addClass('btn-success');
      $('#container_preview_lebar').hide();
      $('#container_preview_thermal').show();
      $('#bt_status_bar').show();
      $('#btn_modal_print_bluetooth').show();
      $('#btn_modal_print_browser').html('<i class="fa fa-print"></i> Cetak Browser / USB');
      if ($(window).width() >= 768) {
         $('#modal_nota_kasir .modal-dialog').css({'max-width': '500px'});
      } else {
         $('#modal_nota_kasir .modal-dialog').css({'max-width': '100%'});
      }
   });

   $('#btn_modal_tab_lebar').click(function(){
      $('#btn_modal_tab_thermal').removeClass('btn-success').addClass('btn-default');
      $(this).removeClass('btn-default').addClass('btn-info').css({'color': '#ffffff'});
      $('#container_preview_thermal').hide();
      $('#container_preview_lebar').show();
      $('#bt_status_bar').hide();
      $('#btn_modal_print_bluetooth').hide();
      $('#btn_modal_print_browser').html('<i class="fa fa-print"></i> Cetak Faktur Lebar (A4)');
      if ($(window).width() >= 768) {
         $('#modal_nota_kasir .modal-dialog').css({'max-width': '880px'});
      } else {
         $('#modal_nota_kasir .modal-dialog').css({'max-width': '100%'});
      }
   });

   // Cetak Struk Kasir Thermal via Browser Pop-up / USB
   $('#btn_modal_print_struk').click(function(){
      var url = $(this).data('print-url');
      if (url) {
         print_thermal_receipt(url);
      }
   });

   // Cetak Faktur Format Lebar Resmi Perusahaan (A4 / Continuous Form)
   $('#btn_modal_print_lebar').click(function(){
      var url = $(this).data('print-url');
      if (url) {
         print_thermal_receipt(url);
      }
   });

   // Transaksi Kasir Baru (Reset Form dan Siapkan Order Berikutnya)
   $('#btn_modal_transaksi_baru').click(function(){
      reset_pos_cart(nextSoNumber, nextRefNumber);
      if (typeof toastr !== 'undefined') {
         toastr.info('Kasir siap melayani transaksi baru.', 'POS Siap');
      }
   });

   // Buka Kembali Nota Terakhir
   $('#btn_cetak_ulang_last').click(function(){
      if (lastReceiptData) {
         show_receipt_modal(lastReceiptData);
      } else {
         show_alert('Belum ada transaksi pada sesi kasir saat ini.', 'info');
      }
   });

   // Handler Pasti untuk Tombol X Header, Tombol Batal, & Tutup
   $(document).on('click', '.btn-close-modal-nota, #btn_close_modal_header, #btn_modal_batal, #modal_nota_kasir .close, #modal_nota_kasir [data-dismiss="modal"]', function(e){
      e.preventDefault();
      e.stopPropagation();
      $('#modal_nota_kasir').modal('hide');
      setTimeout(function(){
         $('.modal-backdrop').remove();
         $('body').removeClass('modal-open').css('padding-right', '');
      }, 250);
   });

   // Saat modal nota ditutup, sinkronkan data nomor SO kasir berikutnya & refresh stok live
   $('#modal_nota_kasir').on('hidden.bs.modal', function(){
      if (nextSoNumber && $('#display_nomor_so').text() !== nextSoNumber) {
         $('#display_nomor_so').text(nextSoNumber);
         if (nextRefNumber) {
            $('#nomor_referensi').val(nextRefNumber);
         }
      }
      setTimeout(function(){
         $('.modal-backdrop').remove();
         $('body').removeClass('modal-open').css('padding-right', '');
      }, 100);
   });

   // Keyboard Shortcut: Saat modal nota kasir terbuka
   $(document).on('keydown', function(e){
      if ($('#modal_nota_kasir').is(':visible')) {
         // Jika tekan Enter -> cetak
         if (e.which === 13) {
            e.preventDefault();
            if ($('#container_preview_thermal').is(':visible')) {
               $('#btn_modal_print_bluetooth').click();
            } else {
               $('#btn_modal_print_browser').click();
            }
         }
         // Jika tekan Escape -> tutup modal & siapkan transaksi baru
         else if (e.which === 27) {
            e.preventDefault();
            $('#modal_nota_kasir').modal('hide');
            setTimeout(function(){
               $('.modal-backdrop').remove();
               $('body').removeClass('modal-open').css('padding-right', '');
            }, 200);
         }
      }
   });

   // ==========================================================
   // MODERN POS RIWAYAT TRANSAKSI CONTROLS
   // ==========================================================
   function toggle_pos_history_panel(forceOpen) {
      var $panel = $('#panel_riwayat_transaksi');
      var $btn = $('#btn_toggle_riwayat');
      if (forceOpen === true || ($panel.is(':hidden') && forceOpen !== false)) {
         $panel.slideDown(220);
         $btn.addClass('active');
         localStorage.setItem('pos_history_collapsed', '0');
      } else {
         $panel.slideUp(200);
         $btn.removeClass('active');
         localStorage.setItem('pos_history_collapsed', '1');
      }
   }

   $('#btn_toggle_riwayat').click(function(e){
      e.preventDefault();
      toggle_pos_history_panel();
   });

   $('#btn_close_panel_riwayat').click(function(e){
      e.preventDefault();
      toggle_pos_history_panel(false);
   });

   function set_pos_history_view(mode) {
      if (mode === 'table') {
         $('#btn_toggle_view_table').addClass('active');
         $('#btn_toggle_view_cards').removeClass('active');
         $('#wrapper_cards_rekap').hide().addClass('is-hidden');
         $('#wrapper_tabel_rekap').show().removeClass('is-hidden');
         localStorage.setItem('pos_history_view', 'table');
      } else {
         $('#btn_toggle_view_cards').addClass('active');
         $('#btn_toggle_view_table').removeClass('active');
         $('#wrapper_cards_rekap').show().removeClass('is-hidden');
         $('#wrapper_tabel_rekap').hide().addClass('is-hidden');
         localStorage.setItem('pos_history_view', 'cards');
      }
   }

   $('#btn_toggle_view_cards').click(function(e){
      e.preventDefault();
      set_pos_history_view('cards');
   });

   $('#btn_toggle_view_table').click(function(e){
      e.preventDefault();
      set_pos_history_view('table');
   });

   // Restore panel visibility & view preference (Default: Tertutup / Collapsed agar kasir langsung fokus transaksi)
   var isHistoryCollapsed = localStorage.getItem('pos_history_collapsed');
   if (isHistoryCollapsed === '0') {
      $('#panel_riwayat_transaksi').show();
      $('#btn_toggle_riwayat').addClass('active');
   } else {
      $('#panel_riwayat_transaksi').hide();
      $('#btn_toggle_riwayat').removeClass('active');
   }

   var savedView = localStorage.getItem('pos_history_view') || 'cards';
   set_pos_history_view(savedView);

   // Dynamic Add to History function
   window.add_transaction_to_history = function(receipt) {
      if (!receipt || !receipt.nomor_so) return;

      $('#empty_history_placeholder').remove();
      $('#empty_row_rekap').remove();

      var formattedTotal = 'Rp ' + Number(receipt.total || 0).toLocaleString('id-ID');
      var nowTime = new Date();
      var timeStr = ('0' + nowTime.getHours()).slice(-2) + ':' + ('0' + nowTime.getMinutes()).slice(-2);
      var dateStr = ('0' + nowTime.getDate()).slice(-2) + '/' + ('0' + (nowTime.getMonth() + 1)).slice(-2) + '/' + nowTime.getFullYear();
      var custName = receipt.pelanggan || 'Pelanggan Umum';
      var soId = receipt.so_id || '';
      var cetakUrl = '<?= site_url("administrator/sales_order/cetak_struk/"); ?>' + '/' + soId;
      var viewUrl = '<?= site_url("administrator/sales_order/view/"); ?>' + '/' + soId;

      // 1. Prepend to Card Grid
      var cardHtml = '<div class="pos-trx-card card-new-arrival" id="card_trx_' + (soId || Date.now()) + '">' +
         '<div class="pos-trx-top">' +
            '<span class="pos-trx-so-badge"><i class="fa fa-receipt text-muted"></i> ' + receipt.nomor_so + '</span>' +
            '<span class="pos-trx-time" title="' + dateStr + ' ' + timeStr + '"><i class="fa fa-clock-o text-muted"></i> ' + timeStr + '</span>' +
         '</div>' +
         '<div class="pos-trx-cust-row">' +
            '<div class="pos-trx-avatar"><i class="fa fa-user"></i></div>' +
            '<div class="pos-trx-cust-info">' +
               '<div class="pos-trx-cust-name" title="' + custName + '">' + custName + '</div>' +
               '<div class="pos-trx-cust-date">' + dateStr + '</div>' +
            '</div>' +
         '</div>' +
         '<div class="pos-trx-amount-box">' +
            '<span class="pos-trx-amount-label">Total Bayar</span>' +
            '<span class="pos-trx-amount-value">' + formattedTotal + '</span>' +
         '</div>' +
         '<div class="pos-trx-actions">' +
            '<a href="' + cetakUrl + '" class="btn-trx-print" title="Cetak Ulang Struk Kasir"><i class="fa fa-print"></i> Cetak Struk</a>' +
            '<a href="' + viewUrl + '" class="btn-trx-detail" title="Lihat Detail Transaksi"><i class="fa fa-eye"></i> Detail</a>' +
         '</div>' +
      '</div>';

      var $cardsContainer = $('#wrapper_cards_rekap');
      $cardsContainer.prepend(cardHtml);
      var $allCards = $cardsContainer.find('.pos-trx-card');
      if ($allCards.length > 5) {
         $allCards.last().remove();
      }

      // 2. Prepend to Table
      var rowHtml = '<tr class="row-flash" id="row_trx_' + (soId || Date.now()) + '">' +
         '<td><span class="pos-trx-so-badge">' + receipt.nomor_so + '</span></td>' +
         '<td><i class="fa fa-clock-o text-muted"></i> ' + dateStr + ' ' + timeStr + '</td>' +
         '<td style="font-weight:600; color:#0f172a;"><i class="fa fa-user-circle text-muted" style="margin-right:4px;"></i> ' + custName + '</td>' +
         '<td style="text-align:right; font-weight:700; color:#059669;">' + formattedTotal + '</td>' +
         '<td style="text-align:center; white-space:nowrap;">' +
            '<a href="' + cetakUrl + '" class="btn-trx-print" style="padding:4px 8px; font-size:10.5px;"><i class="fa fa-print"></i> Cetak</a> ' +
            '<a href="' + viewUrl + '" class="btn-trx-detail" style="padding:4px 8px; font-size:10.5px; margin-left:4px;"><i class="fa fa-eye"></i> Detail</a>' +
         '</td>' +
      '</tr>';

      var $tbody = $('#tbody_rekap_transaksi');
      $tbody.prepend(rowHtml);
      var $allRows = $tbody.find('tr:not(#empty_row_rekap)');
      if ($allRows.length > 5) {
         $allRows.last().remove();
      }

      // 3. Update count badge
      var curCount = parseInt($('#badge_count_rekap').text(), 10) || 0;
      $('#badge_count_rekap').text(Math.min(5, curCount + 1));
   };
});
</script>
