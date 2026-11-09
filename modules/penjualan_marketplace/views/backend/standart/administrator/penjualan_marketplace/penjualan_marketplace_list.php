<?php
/**
 * View: Penjualan Marketplace (Register All & Fulfillment Multi-Channel)
 * File: penjualan_marketplace_list.php
 * Ultra-Premium Executive UI/UX Design System
 */

/* Privacy Masking Helpers (Neat & Compact) */
if (!function_exists('mask_nama_penerima')) {
    function mask_nama_penerima($name) {
        if (empty($name) || $name == '-') return '-';
        $words = explode(' ', trim($name));
        $masked_words = [];
        foreach ($words as $idx => $w) {
            $len = strlen($w);
            if ($len <= 2) {
                $masked_words[] = $w;
            } else {
                $first = substr($w, 0, 1);
                $last  = substr($w, -1);
                $masked_words[] = $first . '***' . $last;
            }
            if ($idx >= 1 && count($words) > 2) {
               break;
            }
        }
        return implode(' ', $masked_words);
    }
}

if (!function_exists('mask_notelp')) {
    function mask_notelp($phone) {
        $phone = preg_replace('/[^0-9]/', '', trim($phone));
        if (empty($phone) || strlen($phone) < 6) return '08****00';
        $prefix = substr($phone, 0, 4);
        $suffix = substr($phone, -2);
        return $prefix . '****' . $suffix;
    }
}

if (!function_exists('clean_pm_product_title')) {
    function clean_pm_product_title($title) {
        if (empty($title) || $title === '-') return '';
        $parts = preg_split('/[,;\n\r]+/', $title);
        $unique_parts = [];
        foreach ($parts as $p) {
            $trimmed = trim($p);
            $norm = trim(preg_replace('/\s*\(x\d+\)$/i', '', $trimmed));
            if (!empty($norm) && !in_array(strtolower($norm), array_map('strtolower', $unique_parts))) {
                $unique_parts[] = $trimmed;
            }
        }
        return !empty($unique_parts) ? implode(', ', $unique_parts) : $title;
    }
}

$status_color = [
    'draft'      => 'label-default',
    'submitted'  => 'label-default',
    'confirmed'  => 'label-info',
    'approved'   => 'label-info',
    'packing'    => 'label-warning',
    'processing' => 'label-warning',
    'shipped'    => 'label-primary',
    'delivered'  => 'label-success',
    'completed'  => 'label-success',
    'cancelled'  => 'label-danger'
];
$per_page = isset($per_page) ? $per_page : 25;
?>
<style>
/* Modern Premium UI/UX Design Tokens */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

@keyframes pmFadeInUp {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}

.content-wrapper, .right-side {
   font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
}

/* Header Container */
.pm-header-container {
   background: #ffffff;
   border-radius: 14px;
   padding: 18px 24px;
   margin-bottom: 20px;
   box-shadow: 0 4px 20px rgba(0,0,0,0.03);
   border: 1px solid #e2e8f0;
   display: flex;
   align-items: center;
   justify-content: space-between;
   gap: 16px;
   flex-wrap: wrap;
   animation: pmFadeInUp 0.35s ease;
}
.pm-header-brand {
   display: flex;
   align-items: center;
   gap: 14px;
}
.pm-header-icon {
   width: 48px;
   height: 48px;
   min-width: 48px;
   background: linear-gradient(135deg, #ee4d2d 0%, #ff6b4a 100%);
   color: #ffffff;
   border-radius: 12px;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   font-size: 22px;
   box-shadow: 0 4px 12px rgba(238, 77, 45, 0.25);
   display: flex;
   flex-direction: column;
}
.pm-header-title-row {
   display: flex;
   align-items: center;
   gap: 10px;
   flex-wrap: wrap;
}
.pm-header-title {
   font-size: 21px;
   font-weight: 800;
   color: #0f172a;
   margin: 0;
   letter-spacing: -0.4px;
   line-height: 1.2;
}
.pm-order-pill {
   background: #e0f2fe;
   color: #0284c7;
   border: 1px solid #bae6fd;
   font-size: 11px;
   font-weight: 800;
   padding: 2.5px 9px;
   border-radius: 14px;
   display: inline-flex;
   align-items: center;
   gap: 4px;
   white-space: nowrap;
}
.pm-header-subtitle {
   font-size: 12.5px;
   color: #64748b;
   margin-top: 3px;
}

/* Button Bar */
.pm-btn-group {
   display: flex;
   gap: 8px;
   flex-wrap: wrap;
   align-items: center;
   justify-content: flex-end;
}
.pm-btn {
   border-radius: 8px;
   font-weight: 700;
   font-size: 11.5px;
   padding: 8px 13px;
   border: none;
   transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
   display: inline-flex;
   align-items: center;
   justify-content: center;
   gap: 6px;
   color: #ffffff !important;
   box-shadow: 0 2px 6px rgba(0,0,0,0.06);
   white-space: nowrap;
   text-decoration: none !important;
   cursor: pointer;
}
.pm-btn:hover {
   transform: translateY(-2px);
   box-shadow: 0 6px 14px rgba(0,0,0,0.12);
}
.pm-btn:active {
   transform: translateY(0);
}
.pm-btn-packed { background: #0284c7; }
.pm-btn-packed:hover { background: #0369a1; }
.pm-btn-import-penjualan { background: #6366f1; }
.pm-btn-import-penjualan:hover { background: #4f46e5; }
.pm-btn-import-resi {
   background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
   border: 1px solid rgba(255,255,255,0.18);
}
.pm-btn-import-resi:hover {
   background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
   box-shadow: 0 4px 14px rgba(2, 132, 199, 0.4);
}
.pm-btn-add { background: #ee4d2d; }
.pm-btn-add:hover { background: #dc2626; }
.pm-btn-xls { background: #059669; }
.pm-btn-xls:hover { background: #047857; }
.pm-btn-pdf { background: #e11d48; }
.pm-btn-pdf:hover { background: #be123c; }

/* 4 KPI Metric Cards */
.pm-kpi-card {
   background: #ffffff;
   border-radius: 14px;
   padding: 18px 22px;
   box-shadow: 0 4px 20px rgba(0,0,0,0.02);
   border: 1px solid #e2e8f0;
   margin-bottom: 22px;
   transition: all 0.2s ease;
   position: relative;
   overflow: hidden;
}
.pm-kpi-card:hover {
   transform: translateY(-3px);
   box-shadow: 0 10px 30px rgba(0,0,0,0.06);
   border-color: #cbd5e1;
}
.pm-kpi-title {
   font-size: 11px;
   font-weight: 800;
   text-transform: uppercase;
   color: #64748b;
   letter-spacing: 0.6px;
}
.pm-kpi-num {
   font-size: 24px;
   font-weight: 900;
   color: #0f172a;
   margin: 6px 0 2px 0;
   line-height: 1.1;
}
.pm-kpi-sub {
   font-size: 11.5px;
   color: #94a3b8;
}
.pm-kpi-icon {
   width: 44px;
   height: 44px;
   border-radius: 12px;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 20px;
   float: right;
   margin-top: -38px;
}

/* Filter Card */
.pm-filter-card {
   background: #ffffff;
   border: 1px solid #e2e8f0;
   border-radius: 14px;
   padding: 16px 20px;
   margin-bottom: 20px;
   box-shadow: 0 4px 15px rgba(0,0,0,0.02);
}
.pm-filter-row {
   display: grid;
   grid-template-columns: 210px 210px 130px 1fr;
   gap: 12px;
   align-items: flex-end;
}
.pm-filter-item {
   display: flex;
   flex-direction: column;
}
.pm-filter-label {
   font-size: 11px;
   font-weight: 700;
   color: #64748b;
   margin-bottom: 5px;
   display: flex;
   align-items: center;
   gap: 4px;
   text-transform: uppercase;
   letter-spacing: 0.3px;
}
.pm-filter-input {
   border-radius: 8px !important;
   border: 1px solid #cbd5e1 !important;
   font-size: 12.5px !important;
   font-weight: 600 !important;
   color: #1e293b !important;
   height: 38px !important;
   padding: 6px 12px !important;
   box-shadow: none !important;
   transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.pm-filter-input:focus {
   border-color: #0284c7 !important;
   box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12) !important;
}

.pm-search-wrap {
   display: flex;
   align-items: center;
   gap: 8px;
}
.pm-search-wrap .pm-filter-input {
   flex: 1;
   min-width: 0;
}
.pm-search-btn-pair {
   display: flex;
   gap: 6px;
   align-items: center;
}
.pm-btn-search {
   background: #0284c7;
   border-color: #0284c7;
   color: #ffffff !important;
   font-weight: 700;
   font-size: 12px;
   height: 38px;
   padding: 0 15px;
   border-radius: 8px;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   gap: 6px;
   transition: all 0.15s ease;
   border: none;
   white-space: nowrap;
}
.pm-btn-search:hover {
   background: #0369a1;
   color: #ffffff;
}
.pm-btn-reset {
   background: #f1f5f9;
   border: 1px solid #cbd5e1;
   color: #475569 !important;
   font-weight: 700;
   font-size: 12px;
   height: 38px;
   padding: 0 13px;
   border-radius: 8px;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   gap: 6px;
   transition: all 0.15s ease;
   white-space: nowrap;
   text-decoration: none !important;
}
.pm-btn-reset:hover {
   background: #e2e8f0;
   color: #0f172a !important;
}

.pm-mobile-hint {
   display: none;
   background: #f8fafc;
   border: 1px dashed #cbd5e1;
   border-radius: 8px;
   padding: 8px 12px;
   font-size: 11.5px;
   font-weight: 600;
   color: #64748b;
   text-align: center;
   margin-bottom: 12px;
}
.pm-mobile-hint i {
   color: #0284c7;
   margin-right: 4px;
}

/* Channel & Courier Badges */
.channel-pill {
   display: inline-flex;
   align-items: center;
   gap: 4px;
   padding: 3px 9px;
   border-radius: 12px;
   font-size: 10.5px;
   font-weight: 700;
   margin-top: 4px;
}
.channel-shopee { background: #fff2ee; color: #ee4d2d; border: 1px solid #ffccbe; }
.channel-tokopedia { background: #f2faf3; color: #03ac0e; border: 1px solid #c8edd0; }
.channel-tiktok { background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; }
.channel-tiktok i { color: #fe2c55; }
.channel-manual { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
.channel-resi { background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; font-weight: 700; }

.btn-copy-inline {
   background: transparent;
   border: 1px solid transparent;
   border-radius: 4px;
   padding: 1px 4px;
   color: #94a3b8;
   cursor: pointer;
   font-size: 11px;
   line-height: 1;
   transition: all 0.15s ease;
   display: inline-flex;
   align-items: center;
   justify-content: center;
}
.btn-copy-inline:hover {
   color: #0284c7;
   background: #e2e8f0;
   border-color: #cbd5e1;
}

.courier-pill {
   display: inline-block;
   padding: 3.5px 9px;
   border-radius: 6px;
   font-size: 11px;
   font-weight: 700;
   white-space: nowrap;
   border: 1px solid transparent;
}
.courier-spx { background: #ffedd5; color: #c2410c; border-color: #fed7aa; }
.courier-sicepat { background: #fce7f3; color: #be185d; border-color: #fbcfe8; }
.courier-jnt { background: #fee2e2; color: #b91c1c; border-color: #fecaca; }
.courier-gosend { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }
.courier-anteraja { background: #e0e7ff; color: #4338ca; border-color: #c7d2fe; }
.courier-ninja { background: #fef3c7; color: #b45309; border-color: #fde68a; }
.courier-jne { background: #e0f2fe; color: #0369a1; border-color: #bae6fd; }

.status-packed-badge {
   background: #0284c7;
   color: #ffffff;
   font-size: 10.5px;
   font-weight: 800;
   padding: 4px 9px;
   border-radius: 6px;
   display: inline-block;
}

/* Keterangan Badges: Green (Sudah Follow-Up), Red (Terlewat / Overdue), Orange (Hari Ini) */
.badge-keterangan-green {
   background: #10b981;
   color: #ffffff !important;
   font-size: 11px;
   font-weight: 800;
   padding: 4px 8px;
   border-radius: 4px;
   display: inline-block;
   letter-spacing: 0.3px;
   box-shadow: 0 1px 3px rgba(16, 185, 129, 0.3);
   white-space: nowrap;
}
.badge-keterangan-red {
   background: #ef4444;
   color: #ffffff !important;
   font-size: 11px;
   font-weight: 800;
   padding: 4px 8px;
   border-radius: 4px;
   display: inline-block;
   letter-spacing: 0.3px;
   box-shadow: 0 1px 3px rgba(239, 68, 68, 0.3);
   white-space: nowrap;
}
.badge-keterangan-orange {
   background: #f59e0b;
   color: #ffffff !important;
   font-size: 11px;
   font-weight: 800;
   padding: 4px 8px;
   border-radius: 4px;
   display: inline-block;
   letter-spacing: 0.3px;
   box-shadow: 0 1px 3px rgba(245, 158, 11, 0.3);
   white-space: nowrap;
}

/* Keterangan Follow-Up Interactive Buttons Group */
.btn-group-keterangan-bc {
   display: flex;
   flex-wrap: wrap;
   gap: 3px;
   align-items: center;
   max-width: 155px;
}
.badge-bc-pill, .btn-bc-pill {
   display: inline-flex;
   align-items: center;
   justify-content: center;
   background: #f8fafc;
   border: 1px solid #cbd5e1;
   border-radius: 4px;
   color: #475569;
   font-size: 10px;
   font-weight: 700;
   padding: 2.5px 6.5px;
   cursor: pointer !important;
   user-select: none;
   white-space: nowrap;
   line-height: 1.25;
   transition: all 0.15s ease;
}
.badge-bc-pill:hover, .btn-bc-pill:hover {
   background: #e2e8f0;
   border-color: #94a3b8;
   color: #0f172a;
   transform: translateY(-1px);
   box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.badge-bc-pill.btn-bc-overdue, .btn-bc-pill.btn-bc-overdue {
   background: #fee2e2;
   border-color: #fca5a5;
   color: #dc2626;
   font-weight: 700;
}
.badge-bc-pill.btn-bc-overdue:hover, .btn-bc-pill.btn-bc-overdue:hover {
   background: #fecaca;
   border-color: #f87171;
   color: #b91c1c;
}
.badge-bc-pill.active, .btn-bc-pill.active {
   background: #10b981 !important;
   border-color: #059669 !important;
   color: #ffffff !important;
   font-weight: 800;
   box-shadow: 0 1px 3px rgba(16, 185, 129, 0.35);
}
.badge-bc-pill.active:hover, .btn-bc-pill.active:hover {
   background: #059669 !important;
   border-color: #047857 !important;
}

.badge-keterangan-green, .badge-keterangan-red, .badge-keterangan-orange {
   cursor: pointer !important;
   transition: transform 0.15s ease, box-shadow 0.15s ease;
   user-select: none;
}
.badge-keterangan-green:hover, .badge-keterangan-red:hover, .badge-keterangan-orange:hover {
   transform: scale(1.06);
   box-shadow: 0 2px 5px rgba(0,0,0,0.15);
}

/* Action Icon Buttons */
.act-icon-btn {
   display: inline-flex;
   align-items: center;
   justify-content: center;
   width: 28px;
   height: 28px;
   background: #00a65a;
   color: #ffffff !important;
   border-radius: 6px;
   font-size: 12px;
   transition: all 0.15s ease;
   text-decoration: none !important;
}
.act-icon-btn:hover {
   background: #008d4c;
   transform: scale(1.08);
}

/* Sticky Action Column & Overhaul Design System */
.table-marketplace th.col-sticky-action,
.table-marketplace td.col-sticky-action {
   position: sticky !important;
   right: 0 !important;
   z-index: 10;
   box-shadow: -5px 0 12px rgba(0, 0, 0, 0.05);
   border-left: 1px solid #e2e8f0 !important;
}
.table-marketplace th.col-sticky-action {
   background: #0f172a !important;
   color: #ffffff !important;
   z-index: 11;
}
.table-marketplace td.col-sticky-action {
   background: #ffffff;
}
.table-marketplace tr:hover td.col-sticky-action {
   background: #f8fafc;
}

/* Compact & Clamped Product Title */
.pm-product-title {
   display: -webkit-box;
   -webkit-line-clamp: 2;
   -webkit-box-orient: vertical;
   overflow: hidden;
   text-overflow: ellipsis;
   font-size: 11px;
   color: #334155;
   line-height: 1.35;
   max-width: 250px;
   margin-top: 3px;
   word-break: break-word;
}

/* Compact Action Toolbar (2 rows) */
.pm-action-cell {
   display: flex;
   flex-direction: column;
   gap: 4px;
   width: 140px;
}
.pm-action-row {
   display: flex;
   gap: 3px;
   align-items: center;
}
.pm-act-btn {
   display: inline-flex;
   align-items: center;
   justify-content: center;
   gap: 3px;
   font-size: 10.5px;
   font-weight: 700;
   padding: 4px 6px;
   border-radius: 5px;
   text-decoration: none !important;
   transition: all 0.15s ease;
   border: none;
   white-space: nowrap;
   cursor: pointer;
}
.pm-act-btn:hover {
   transform: translateY(-1px);
   box-shadow: 0 2px 5px rgba(0,0,0,0.12);
}
.pm-act-fu { background: #16a34a; color: #fff !important; flex: 1.2; }
.pm-act-detail { background: #f1f5f9; color: #0284c7 !important; border: 1px solid #cbd5e1; flex: 1; }
.pm-act-edit { background: #f59e0b; color: #fff !important; flex: 1; }
.pm-act-print { background: #0284c7; color: #fff !important; flex: 1; }
.pm-act-delete { background: #ef4444; color: #fff !important; flex: 0.8; }

/* Responsive Media Queries */
@media (max-width: 1300px) {
   .pm-filter-row {
      grid-template-columns: 1fr 1fr 1fr !important;
   }
   .pm-filter-search-group {
      grid-column: span 3 !important;
   }
}
@media (max-width: 991px) {
   .pm-header-container {
      flex-direction: column !important;
      align-items: stretch !important;
      padding: 16px !important;
      gap: 14px !important;
   }
   .pm-btn-group {
      justify-content: flex-start !important;
      width: 100% !important;
   }
   .pm-filter-row {
      grid-template-columns: 1fr 1fr !important;
   }
   .pm-filter-search-group {
      grid-column: span 2 !important;
   }
}
@media (max-width: 768px) {
   .pm-mobile-hint {
      display: block !important;
   }
   .pm-header-container {
      padding: 14px !important;
      gap: 12px !important;
   }
   .pm-header-brand {
      width: 100% !important;
   }
   .pm-header-title {
      font-size: 18px !important;
   }
   .pm-header-icon {
      width: 40px !important;
      height: 40px !important;
      min-width: 40px !important;
      font-size: 17px !important;
      border-radius: 10px !important;
   }
   .pm-btn-group {
      display: grid !important;
      grid-template-columns: 1fr 1fr !important;
      gap: 8px !important;
      width: 100% !important;
   }
   .pm-btn-group .pm-btn-import-resi {
      grid-column: span 2 !important;
      order: -1 !important;
      padding: 11px 14px !important;
      font-size: 12.5px !important;
      font-weight: 800 !important;
      border-radius: 9px !important;
      box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25) !important;
   }
   .pm-btn-group .pm-btn-add {
      grid-column: span 1 !important;
      padding: 9px 8px !important;
      font-size: 11.5px !important;
   }
   .pm-btn {
      width: 100% !important;
      padding: 9px 8px !important;
      font-size: 11.5px !important;
      justify-content: center !important;
   }
   .pm-filter-card {
      padding: 14px 16px !important;
      border-radius: 12px !important;
   }
   .pm-filter-row {
      display: flex !important;
      flex-direction: column !important;
      gap: 12px !important;
   }
   .pm-filter-item {
      width: 100% !important;
   }
   .pm-filter-label {
      font-size: 11.5px !important;
      font-weight: 700 !important;
      color: #475569 !important;
      margin-bottom: 5px !important;
      display: flex !important;
      align-items: center !important;
      gap: 5px !important;
   }
   .pm-filter-input {
      width: 100% !important;
      height: 42px !important;
      font-size: 13px !important;
      border-radius: 8px !important;
   }
   .pm-search-wrap {
      display: flex !important;
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 8px !important;
   }
   .pm-search-btn-pair {
      display: grid !important;
      grid-template-columns: 1fr 1fr !important;
      gap: 8px !important;
      width: 100% !important;
   }
   .pm-btn-search,
   .pm-btn-reset {
      width: 100% !important;
      height: 40px !important;
      font-size: 13px !important;
      border-radius: 8px !important;
   }
   .table-marketplace th, .table-marketplace td {
      padding: 9px 8px !important;
      font-size: 11px !important;
   }
   .box-footer {
      padding: 12px 14px !important;
      text-align: center !important;
   }
   .box-footer .text-right {
      text-align: center !important;
      margin-top: 10px !important;
   }
   .box-footer .pagination {
      margin: 0 auto !important;
      display: inline-flex !important;
   }
}
</style>

<section class="content-header" style="padding-top:16px; padding-bottom:0;">
   <div class="pm-header-container">
      <div class="pm-header-brand">
         <div class="pm-header-icon">
            <i class="fa fa-shopping-bag"></i>
         </div>
         <div class="pm-header-info">
            <div class="pm-header-title-row">
               <h1 class="pm-header-title">Penjualan Marketplace</h1>
               <span class="pm-order-pill"><i class="fa fa-cubes"></i> <?= number_format($so_counts, 0, ',', '.'); ?> Order</span>
            </div>
            <div class="pm-header-subtitle">Register All &amp; Fulfillment Multi-Channel</div>
         </div>
      </div>
      <div class="pm-btn-group">
         <button type="button" class="pm-btn pm-btn-import-resi" data-toggle="modal" data-target="#modalImportResiMassal" title="Scan &amp; Import Resi dari Foto / PDF Label Thermal Banyak Sekaligus">
            <i class="fa fa-barcode"></i> <span>Scan &amp; Import Resi (Foto/PDF)</span>
         </button>
         <button type="button" class="pm-btn pm-btn-import-penjualan" data-toggle="modal" data-target="#modalImportMarketplace" title="Import Pesanan Shopee / Tokopedia / TikTok">
            <i class="fa fa-file-excel-o"></i> <span>Import CSV</span>
         </button>
         <a href="<?= site_url('administrator/penjualan_marketplace/add'); ?>" class="pm-btn pm-btn-add" title="Tambah Pesanan Baru">
            <i class="fa fa-plus-circle"></i> <span>Tambah Pesanan</span>
         </a>
         <?php $export_qs = !empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : ''; ?>
         <a href="<?= site_url('administrator/penjualan_marketplace/export' . $export_qs); ?>" class="pm-btn pm-btn-xls" title="Export Laporan Excel">
            <i class="fa fa-file-excel-o"></i> <span>Export XLS</span>
         </a>
         <a href="<?= site_url('administrator/penjualan_marketplace/export_pdf' . $export_qs); ?>" target="_blank" class="pm-btn pm-btn-pdf" title="Export Laporan PDF">
            <i class="fa fa-file-pdf-o"></i> <span>Export PDF</span>
         </a>
      </div>
   </div>
</section>

<section class="content" style="padding-top:0;">

   <!-- Sleek High-Contrast Result Notification Banner Card -->
   <?php 
   $f_message = $this->session->flashdata('f_message');
   $f_type    = $this->session->flashdata('f_type');
   if (!empty($f_message)):
      $alert_bg = ($f_type == 'error') ? '#fef2f2' : (($f_type == 'warning') ? '#fffbeb' : '#f0fdf4');
      $alert_border = ($f_type == 'error') ? '#ef4444' : (($f_type == 'warning') ? '#f59e0b' : '#10b981');
      $alert_title = ($f_type == 'error') ? 'Peringatan / Gagal' : 'Pemberitahuan Sistem';
      if (stripos($f_message, 'import') !== false) {
         $alert_title = ($f_type == 'error') ? 'Peringatan / Gagal Import' : 'Laporan Ringkasan Import Penjualan';
      } elseif (stripos($f_message, 'dihapus') !== false) {
         $alert_title = 'Berhasil Menghapus Data';
      } elseif (stripos($f_message, 'diperbarui') !== false || stripos($f_message, 'disimpan') !== false || stripos($f_message, 'menambahkan') !== false) {
         $alert_title = 'Berhasil Menyimpan Data';
      }
   ?>
   <div class="alert alert-dismissible" style="background:<?= $alert_bg; ?>; border:1px solid <?= $alert_border; ?>; border-left:6px solid <?= $alert_border; ?>; border-radius:12px; color:#0f172a; padding:16px 22px; margin-bottom:20px; box-shadow:0 4px 20px rgba(0,0,0,0.04);">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color:#0f172a; opacity:0.6; font-size:22px;">&times;</button>
      <div style="display:flex; align-items:flex-start; gap:14px;">
         <i class="fa <?= $alert_icon; ?>" style="font-size:24px; margin-top:2px;"></i>
         <div>
            <strong style="font-size:14.5px; font-weight:800; color:#0f172a; font-family:sans-serif;"><?= $alert_title; ?></strong>
            <div style="font-size:13px; color:#334155; margin-top:6px; line-height:1.7;">
               <?= $f_message; ?>
            </div>
         </div>
      </div>
   </div>
   <?php endif; ?>



   <!-- Filter Panel -->
   <div class="pm-filter-card">
      <form action="<?= base_url('administrator/penjualan_marketplace/index'); ?>" method="GET" id="formFilterMarketplace">
         <div class="pm-filter-row">
            <!-- Kategori / Saluran Penjualan -->
            <div class="pm-filter-item">
               <label class="pm-filter-label"><i class="fa fa-tags"></i> Kategori / Saluran</label>
               <select class="form-control pm-filter-input" name="source" onchange="this.form.submit()">
                  <option value="">-- Semua Kategori / Saluran --</option>
                  <option value="resi" <?= in_array($this->input->get('source'), ['resi', 'scan_resi', 'import_resi']) ? 'selected':''; ?>>Scan Resi (Import Resi)</option>
                  <option value="shopee" <?= $this->input->get('source') == 'shopee' ? 'selected':''; ?>>Penjualan Shopee</option>
                  <option value="tokopedia" <?= $this->input->get('source') == 'tokopedia' ? 'selected':''; ?>>Penjualan Tokopedia</option>
                  <option value="tiktok" <?= ($this->input->get('source') == 'tiktok' || $this->input->get('source') == 'tiktok shop') ? 'selected':''; ?>>Penjualan TikTok Shop</option>
               </select>
            </div>

            <!-- Status Pesanan -->
            <div class="pm-filter-item">
               <label class="pm-filter-label"><i class="fa fa-check-circle-o"></i> Status Pesanan</label>
               <select class="form-control pm-filter-input" name="status" onchange="this.form.submit()">
                  <option value="">-- Semua Status --</option>
                  <option value="draft" <?= $this->input->get('status') == 'draft' ? 'selected':''; ?>>Draft / Pesanan Baru</option>
                  <option value="confirmed" <?= $this->input->get('status') == 'confirmed' ? 'selected':''; ?>>Terkonfirmasi (Ready)</option>
                  <option value="packing" <?= $this->input->get('status') == 'packing' ? 'selected':''; ?>>Sedang Dikemas (Packing)</option>
                  <option value="shipped" <?= $this->input->get('status') == 'shipped' ? 'selected':''; ?>>Dalam Pengiriman</option>
                  <option value="delivered" <?= $this->input->get('status') == 'delivered' ? 'selected':''; ?>>Pesanan Selesai</option>
                  <option value="cancelled" <?= $this->input->get('status') == 'cancelled' ? 'selected':''; ?>>Dibatalkan</option>
               </select>
            </div>

            <!-- Limit Data -->
            <div class="pm-filter-item">
               <label class="pm-filter-label"><i class="fa fa-list-ol"></i> Tampilkan</label>
               <select class="form-control pm-filter-input" name="per_page" onchange="this.form.submit()">
                  <option value="25" <?= ($per_page == 25) ? 'selected':''; ?>>25 Data</option>
                  <option value="50" <?= ($per_page == 50) ? 'selected':''; ?>>50 Data</option>
                  <option value="100" <?= ($per_page == 100) ? 'selected':''; ?>>100 Data</option>
                  <option value="500" <?= ($per_page == 500) ? 'selected':''; ?>>500 Data</option>
               </select>
            </div>

            <!-- Cari & Action Buttons -->
            <div class="pm-filter-item pm-filter-search-group">
               <label class="pm-filter-label"><i class="fa fa-search"></i> Cari No Pesanan / Resi / Buyer / Receiver</label>
               <div class="pm-search-wrap">
                  <input type="text" class="form-control pm-filter-input" name="q" placeholder="Ketik No. Pesanan, Resi, atau Username..." value="<?= _ent($this->input->get('q')); ?>">
                  <div class="pm-search-btn-pair">
                     <button type="submit" class="pm-btn-search" title="Cari Data"><i class="fa fa-search"></i> <span>Search</span></button>
                     <a href="<?= site_url('administrator/penjualan_marketplace'); ?>" class="pm-btn-reset" title="Reset Filter"><i class="fa fa-refresh"></i> <span>Reset</span></a>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>

   <?php
   $all_bc_options = [];
   $crm_milestones = [];
   $source_cats = !empty($crm_categories) ? $crm_categories : null;
   if (empty($source_cats)) {
      $ci =& get_instance();
      $source_cats = $ci->db->where('is_active', 1)->order_by('jumlah_hari', 'ASC')->get('crm_followup_categories')->result();
   }
   if (!empty($source_cats)) {
      foreach ($source_cats as $cat) {
         if (isset($cat->jumlah_hari)) {
            $clean_cat = preg_replace('/\s*\(H\+\d+\)/i', '', $cat->nama_kategori);
            $all_bc_options[] = $clean_cat . ' (H+' . (int)$cat->jumlah_hari . ')';
            $crm_milestones[] = (int)$cat->jumlah_hari;
         }
      }
   }
   $all_bc_options = array_values(array_unique($all_bc_options));
   $crm_milestones = array_values(array_unique($crm_milestones));
   sort($crm_milestones);
   ?>

   <!-- Mobile Touch Scroll Hint -->
   <div class="pm-mobile-hint">
      <i class="fa fa-arrows-h"></i> Geser tabel ke kanan/kiri untuk melihat rincian lengkap &amp; tombol aksi
   </div>

   <!-- Main Executive Table System -->
   <div class="box box-solid" style="border-radius:14px; border:1px solid #e2e8f0; box-shadow:0 4px 25px rgba(0,0,0,0.03); overflow:hidden;">
      <div class="box-body" style="padding:0;">
         <div class="table-responsive" style="-webkit-overflow-scrolling: touch;">
            <table class="table table-hover table-marketplace" style="font-size:12px; margin-bottom:0; vertical-align:middle; width:100%;">
               <thead>
                  <tr style="background:#0f172a; color:#ffffff; font-size:11px; text-transform:uppercase; letter-spacing:0.6px; white-space:nowrap;">
                     <th width="35" class="text-center" style="padding:12px 6px; vertical-align:middle;"><input type="checkbox" id="check_all"></th>
                     <th style="padding:12px 10px; vertical-align:middle; min-width:200px; max-width:260px;">NO PESANAN &amp; PRODUK</th>
                     <th style="padding:12px 8px; text-align:center; vertical-align:middle; width:100px;">STATUS PESANAN</th>
                     <th style="padding:12px 10px; vertical-align:middle; width:145px;">PENGIRIMAN &amp; RESI</th>
                     <th style="padding:12px 6px; text-align:center; vertical-align:middle; width:45px;">QTY</th>
                     <th style="padding:12px 8px; vertical-align:middle; width:115px;">WAKTU BAYAR</th>
                     <th style="padding:12px 10px; vertical-align:middle; width:150px;">PENERIMA &amp; KONTAK</th>
                     <th style="padding:12px 6px; text-align:center; vertical-align:middle; width:80px;">PACK</th>
                     <th style="padding:12px 10px; vertical-align:middle; width:155px;">FOLLOW-UP CRM</th>
                     <th style="padding:12px 10px; text-align:center; vertical-align:middle; width:140px;" class="col-sticky-action">AKSI</th>
                  </tr>
               </thead>
               <tbody>
                  <?php if (!empty($sos)): ?>
                     <?php foreach ($sos as $so): 
                        $display_no_pesanan = !empty($so->no_pesanan) ? $so->no_pesanan : $so->nomor_so;
                        $display_status_pesanan = !empty($so->status_pesanan) ? $so->status_pesanan : 'Perlu Dikirim';
                        $display_resi = (!empty($so->nomor_resi) && $so->nomor_resi !== '-' && $so->nomor_resi !== $so->no_pesanan) ? $so->nomor_resi : '-';
                        $qty_item = isset($so->total_qty) ? (int)$so->total_qty : 1;
                        $opsi_kirim = !empty($so->opsi_pengiriman) ? $so->opsi_pengiriman : (!empty($so->kurir_ekspedisi) ? $so->kurir_ekspedisi : 'SPX Standard');
                        $waktu_bayar = !empty($so->waktu_pembayaran) ? date('Y-m-d H:i', strtotime($so->waktu_pembayaran)) : date('Y-m-d H:i', strtotime($so->created_at ?? $so->tanggal_so));
                        
                        $raw_penerima = clean_customer_name(!empty($so->nama_penerima) ? $so->nama_penerima : ($so->nama_pelanggan ?? '')) ?: '-';
                        $raw_username = clean_customer_username($so->username_pembeli ?? '', $raw_penerima);
                        $raw_notelp   = clean_customer_phone(!empty($so->no_telepon) && $so->no_telepon !== '-' ? $so->no_telepon : '') ?: '-';
                        
                        $masked_penerima = ($raw_penerima !== '-') ? mask_nama_penerima($raw_penerima) : '-';
                        $masked_notelp   = ($raw_notelp !== '-') ? mask_notelp($raw_notelp) : '-';

                        $source_lower = strtolower($so->source ?? 'shopee');
                        if (in_array($source_lower, ['pdf_scan', 'manual', 'regular', '', 'so'])) {
                            if (preg_match('/^\d{6}SHP/i', $so->no_pesanan) || (preg_match('/^\d{14,16}[A-Za-z0-9]*$/', $so->no_pesanan) && strlen($so->no_pesanan) >= 14) || stripos($so->opsi_pengiriman, 'SPX') !== false || stripos($so->catatan, 'Shopee') !== false || stripos($so->nomor_resi, 'SPX') !== false) {
                                $source_lower = 'shopee';
                            } elseif (preg_match('/^5789\d{10,}/', $so->no_pesanan) || stripos($so->catatan, 'TikTok') !== false) {
                                $source_lower = 'tiktok';
                            } elseif (preg_match('/^INV\/\d+/i', $so->no_pesanan) || stripos($so->nomor_resi, 'TKP') !== false) {
                                $source_lower = 'tokopedia';
                            }
                        }

                        if ($source_lower == 'tokopedia') {
                            $channel_badge = '<span class="channel-pill channel-tokopedia"><i class="fa fa-shopping-cart"></i> Tokopedia</span>';
                        } elseif ($source_lower == 'shopee') {
                            $channel_badge = '<span class="channel-pill channel-shopee"><i class="fa fa-shopping-bag"></i> Shopee</span>';
                        } elseif (in_array($source_lower, ['tiktok', 'tiktokshop', 'tiktok_shop', 'tiktok shop'])) {
                            $channel_badge = '<span class="channel-pill channel-tiktok"><i class="fa fa-music"></i> TikTok Shop</span>';
                        } else {
                            $channel_badge = '<span class="channel-pill channel-manual"><i class="fa fa-shopping-bag"></i> Marketplace Lainnya</span>';
                        }

                        $is_resi_source = (
                            in_array(strtolower($so->source ?? ''), ['resi', 'scan_resi', 'import_resi', 'scan']) ||
                            ($so->created_by ?? '') === 'import_resi' ||
                            stripos($so->catatan ?? '', 'Auto-Created') !== false ||
                            stripos($so->catatan ?? '', 'Label') !== false ||
                            stripos($so->catatan ?? '', 'Scan Resi') !== false
                        );
                        if ($is_resi_source) {
                            $channel_badge .= ' <span class="channel-pill channel-resi"><i class="fa fa-barcode"></i> Scan Resi</span>';
                        }

                        if ($opsi_kirim === 'Standard Delivery' && $source_lower === 'shopee') {
                            $opsi_kirim = 'SPX Express Standard';
                        }

                        $courier_lower = strtolower($opsi_kirim);
                        if (strpos($courier_lower, 'sicepat') !== false) {
                            $courier_badge_class = 'courier-sicepat';
                        } elseif (strpos($courier_lower, 'j&t') !== false || strpos($courier_lower, 'jnt') !== false) {
                            $courier_badge_class = 'courier-jnt';
                        } elseif (strpos($courier_lower, 'gosend') !== false || strpos($courier_lower, 'go-send') !== false || strpos($courier_lower, 'gojek') !== false) {
                            $courier_badge_class = 'courier-gosend';
                        } elseif (strpos($courier_lower, 'anteraja') !== false) {
                            $courier_badge_class = 'courier-anteraja';
                        } elseif (strpos($courier_lower, 'ninja') !== false) {
                            $courier_badge_class = 'courier-ninja';
                        } elseif (strpos($courier_lower, 'jne') !== false) {
                            $courier_badge_class = 'courier-jne';
                        } else {
                            $courier_badge_class = 'courier-spx';
                        }

                        $st_pesanan_raw = trim($display_status_pesanan);
                        $st_pesanan_lower = strtolower($st_pesanan_raw);
                        if (in_array($st_pesanan_lower, ['selesai', 'delivered', 'completed', 'sukses'])) {
                            $st_p_bg = '#dcfce7'; $st_p_color = '#15803d'; $st_p_border = '#bbf7d0'; $st_p_icon = 'fa-check-circle';
                            $st_p_text = 'Selesai';
                        } elseif (in_array($st_pesanan_lower, ['perlu dikirim', 'packing', 'menunggu diproses', 'diproses', 'awaiting shipment', 'awaiting collection', 'to ship', 'unpaid'])) {
                            $st_p_bg = '#fef3c7'; $st_p_color = '#b45309'; $st_p_border = '#fde68a'; $st_p_icon = 'fa-clock-o';
                            $st_p_text = 'Perlu Dikirim';
                        } elseif (in_array($st_pesanan_lower, ['dikirim', 'shipped', 'dalam pengiriman', 'in transit'])) {
                            $st_p_bg = '#e0f2fe'; $st_p_color = '#0369a1'; $st_p_border = '#bae6fd'; $st_p_icon = 'fa-truck';
                            $st_p_text = 'Dikirim';
                        } elseif (in_array($st_pesanan_lower, ['dibatalkan', 'batal', 'cancelled', 'canceled'])) {
                            $st_p_bg = '#fee2e2'; $st_p_color = '#b91c1c'; $st_p_border = '#fecaca'; $st_p_icon = 'fa-times-circle';
                            $st_p_text = 'Dibatalkan';
                        } else {
                            $st_p_bg = '#f1f5f9'; $st_p_color = '#475569'; $st_p_border = '#cbd5e1'; $st_p_icon = 'fa-info-circle';
                            $st_p_text = ucwords($st_pesanan_raw);
                        }

                        $waktu_ref = !empty($so->waktu_pengiriman_diatur) ? $so->waktu_pengiriman_diatur : (!empty($so->waktu_pembayaran) ? $so->waktu_pembayaran : $so->tanggal_so);
                        $diff_h = 0;
                        if (!empty($waktu_ref)) {
                           $dt_ref = new DateTime(date('Y-m-d', strtotime($waktu_ref)));
                           $dt_now = new DateTime(date('Y-m-d'));
                           $diff_h = max(0, (int)$dt_ref->diff($dt_now)->format('%r%a'));
                        }
                        $cur_bc = trim($so->keterangan_bc ?? '');

                        $h_done = null;
                        if (preg_match('/\(H\+(\d+)\)/i', $cur_bc, $m) || preg_match('/^H\+(\d+)$/i', $cur_bc, $m)) {
                           $h_done = (int)$m[1];
                        }

                        $highest_due_h = 0;
                        $milestones_check = !empty($crm_milestones) ? $crm_milestones : [0, 3, 7, 11, 30];
                        foreach ($milestones_check as $m_val) {
                           if ($diff_h >= $m_val) {
                              $highest_due_h = max($highest_due_h, $m_val);
                           }
                        }

                        $is_up_to_date = ($h_done !== null && $h_done >= $highest_due_h);

                        if ($is_up_to_date) {
                           $ket_cls = 'badge-keterangan-green';
                           $ket_icon = 'fa-check';
                           $ket_title = 'Sudah Di-Follow Up: ' . $cur_bc;
                        } elseif ($diff_h > 0) {
                           $ket_cls = 'badge-keterangan-red';
                           $ket_icon = 'fa-exclamation-triangle';
                           $ket_title = 'Terlewat: Belum Follow-Up H+' . $highest_due_h . ' (Umur Pesanan H+' . $diff_h . ')';
                        } else {
                           $ket_cls = 'badge-keterangan-orange';
                           $ket_icon = 'fa-clock-o';
                           $ket_title = 'Jadwal Hari Ini';
                        }

                        $st_lower = strtolower($so->status ?? 'packing');
                        if (in_array($st_lower, ['shipped', 'dikirim'])) {
                            $st_badge_bg = '#10b981';
                            $st_label = 'SHIPPED';
                        } elseif (in_array($st_lower, ['delivered', 'completed', 'selesai'])) {
                            $st_badge_bg = '#059669';
                            $st_label = 'DELIVERED';
                        } elseif (in_array($st_lower, ['cancelled', 'batal'])) {
                            $st_badge_bg = '#ef4444';
                            $st_label = 'CANCELLED';
                        } else {
                            $st_badge_bg = '#0284c7';
                            $st_label = (!empty($so->status_pesanan) && !in_array(strtolower($so->status_pesanan), ['perlu dikirim', 'awaiting shipment', 'to ship', 'packing'])) ? strtoupper($so->status_pesanan) : 'PACKED';
                        }
                     ?>
                     <tr style="border-bottom:1px solid #f1f5f9; transition:background 0.15s ease;">
                        <td class="text-center" style="vertical-align:middle; padding:10px 8px;">
                           <input type="checkbox" class="check_item" value="<?= $so->id; ?>">
                        </td>
                        
                        <!-- 1. NO PESANAN & PRODUK -->
                        <td style="vertical-align:middle; padding:10px 12px;">
                           <div style="display:flex; align-items:center; gap:6px;">
                              <strong style="color:#0f172a; font-family:monospace; font-size:12.5px;">
                                 <a href="<?= site_url('administrator/penjualan_marketplace/view/' . $so->id); ?>" style="color:#0f172a; text-decoration:none;"><?= _ent($display_no_pesanan); ?></a>
                              </strong>
                              <button type="button" class="btn-copy-inline" onclick="copyToClipboard('<?= _ent($display_no_pesanan); ?>', 'No Pesanan');" title="Salin No Pesanan">
                                 <i class="fa fa-clone"></i>
                              </button>
                           </div>
                           <div style="margin-top:3px;">
                              <?= $channel_badge; ?>
                           </div>
                           <?php 
                           $clean_title = clean_pm_product_title($so->nama_produk_marketplace ?? '');
                           if (!empty($clean_title)): 
                           ?>
                              <div class="pm-product-title" title="<?= _ent($clean_title); ?>">
                                 <i class="fa fa-cube text-muted" style="margin-right:2px;"></i><?= _ent($clean_title); ?>
                              </div>
                           <?php endif; ?>
                           <?php if (!empty($so->sku_induk) && $so->sku_induk !== '-'): ?>
                              <div style="margin-top:3px; display:flex; flex-wrap:wrap; gap:3px;">
                                 <span class="badge" style="font-family:monospace; font-size:9.5px; background:#e0f2fe; color:#0369a1; border:1px solid #bae6fd; font-weight:700; padding:2px 5px;"><i class="fa fa-barcode"></i> <?= _ent($so->sku_induk); ?></span>
                                 <?php if (!empty($so->nama_variasi) && strtolower($so->nama_variasi) !== 'default' && $so->nama_variasi !== '-'): ?>
                                    <span class="badge" style="font-size:9.5px; background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; font-weight:600; padding:2px 5px;"><i class="fa fa-tag"></i> <?= _ent($so->nama_variasi); ?></span>
                                 <?php endif; ?>
                              </div>
                           <?php elseif (!empty($so->nama_variasi) && strtolower($so->nama_variasi) !== 'default' && $so->nama_variasi !== '-'): ?>
                              <div style="margin-top:3px;">
                                 <span class="badge" style="font-size:9.5px; background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; font-weight:600; padding:2px 5px;"><i class="fa fa-tag"></i> <?= _ent($so->nama_variasi); ?></span>
                              </div>
                           <?php endif; ?>
                        </td>

                        <!-- 2. STATUS PESANAN -->
                        <td style="vertical-align:middle; text-align:center; padding:10px; white-space:nowrap;">
                           <span style="display:inline-flex; align-items:center; gap:5px; background:<?= $st_p_bg; ?>; color:<?= $st_p_color; ?>; border:1px solid <?= $st_p_border; ?>; font-size:10.5px; font-weight:700; padding:3px 8px; border-radius:12px; white-space:nowrap;">
                              <i class="fa <?= $st_p_icon; ?>" style="font-size:10px;"></i> <?= $st_p_text; ?>
                           </span>
                        </td>

                        <!-- 3. PENGIRIMAN & RESI -->
                        <td style="vertical-align:middle; padding:10px 12px; white-space:nowrap;">
                           <div>
                              <span class="courier-pill <?= $courier_badge_class; ?>"><?= _ent($opsi_kirim); ?></span>
                           </div>
                           <div style="margin-top:4px;">
                              <?php if ($display_resi != '-'): ?>
                                 <div style="display:flex; align-items:center; gap:5px;">
                                    <span style="font-family:monospace; font-weight:700; color:#0284c7; font-size:11.5px; background:#f0f9ff; border:1px solid #bae6fd; padding:1.5px 5px; border-radius:4px;"><?= _ent($display_resi); ?></span>
                                    <button type="button" class="btn-copy-inline" onclick="copyToClipboard('<?= _ent($display_resi); ?>', 'No Resi');" title="Salin No Resi">
                                       <i class="fa fa-clone"></i>
                                    </button>
                                 </div>
                              <?php else: ?>
                                 <span class="badge" style="background:#f1f5f9; color:#64748b; font-size:10px; font-weight:700; border:1px solid #cbd5e1; padding:2px 6px; border-radius:4px;" title="Nomor resi pengiriman belum terbit dari kurir">
                                    <i class="fa fa-clock-o text-muted"></i> Belum Terbit
                                 </span>
                              <?php endif; ?>
                           </div>
                           <div style="margin-top:3px;">
                              <?php 
                              $is_cod = (strtolower($so->tipe_pengiriman ?? '') === 'cod' || (!empty($so->total) && (float)$so->total > 0 && stripos($so->catatan ?? '', 'COD') !== false));
                              if ($is_cod): 
                              ?>
                                 <span class="badge" style="background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; font-weight:700; font-size:9.5px; padding:1.5px 5px;" title="Pembayaran COD Sesuai Resi">
                                    <i class="fa fa-money"></i> COD Rp <?= number_format($so->total, 0, ',', '.'); ?>
                                 </span>
                              <?php elseif (!empty($so->total) && (float)$so->total > 0): ?>
                                 <span class="badge" style="background:#eff6ff; color:#1e40af; border:1px solid #bfdbfe; font-weight:600; font-size:9.5px; padding:1.5px 5px;" title="Total Nilai Pesanan Sesuai Resi">
                                    <i class="fa fa-tag"></i> Rp <?= number_format($so->total, 0, ',', '.'); ?>
                                 </span>
                              <?php else: ?>
                                 <span class="badge" style="background:#f8fafc; color:#64748b; border:1px solid #e2e8f0; font-weight:600; font-size:9px; padding:1.5px 4px;" title="Non-COD / Cashless Marketplace">
                                    <i class="fa fa-credit-card"></i> Non-COD
                                 </span>
                              <?php endif; ?>
                           </div>
                        </td>

                        <!-- 4. QTY ITEM -->
                        <td class="text-center" style="vertical-align:middle; padding:10px 8px; white-space:nowrap;">
                           <span class="badge" style="background:#f1f5f9; color:#0f172a; border:1px solid #cbd5e1; font-size:12px; font-weight:800; padding:4px 8px; border-radius:6px;"><?= $qty_item; ?></span>
                        </td>

                        <!-- 5. WAKTU PEMBAYARAN -->
                        <td style="vertical-align:middle; padding:10px 10px; white-space:nowrap;">
                           <div style="font-size:11.5px; font-weight:600; color:#334155;">
                              <i class="fa fa-calendar-o text-muted" style="margin-right:3px;"></i><?= date('Y-m-d', strtotime($waktu_bayar)); ?>
                           </div>
                           <div style="font-size:11px; color:#64748b; margin-top:2px;">
                              <i class="fa fa-clock-o text-muted" style="margin-right:3px;"></i><?= date('H:i', strtotime($waktu_bayar)); ?>
                           </div>
                           <?php if (!empty($so->pesanan_harus_dikirim_sebelum)): ?>
                              <div style="font-size:9.5px; color:#b45309; font-weight:600; margin-top:3px;" title="Batas Kirim (Sesuai Resi)">
                                 <i class="fa fa-hourglass-half text-warning"></i> s/d <?= date('d/m/y', strtotime($so->pesanan_harus_dikirim_sebelum)); ?>
                              </div>
                           <?php endif; ?>
                        </td>

                        <!-- 6. PENERIMA & KONTAK -->
                        <td style="vertical-align:middle; padding:10px 10px; min-width:140px; max-width:165px;">
                           <div style="color:#0f172a; font-size:12px; font-weight:700;">
                              <?= _ent($masked_penerima); ?>
                           </div>
                           <?php if (!empty($raw_username) && $raw_username !== '-' && $raw_username !== $raw_penerima): ?>
                              <div style="margin-top:2px;">
                                 <small class="text-muted" style="font-size:10.5px;"><i class="fa fa-user-circle"></i> <?= _ent($raw_username); ?></small>
                              </div>
                           <?php endif; ?>
                           <?php if (!empty($raw_notelp) && $raw_notelp !== '-'): ?>
                              <div style="margin-top:3px; display:flex; align-items:center; gap:5px;">
                                 <small style="font-size:11px; font-weight:700; color:#16a34a;"><i class="fa fa-phone text-muted"></i> <?= _ent($masked_notelp); ?></small>
                                 <?php 
                                 $clean_wa_ph = preg_replace('/[^0-9]/', '', (string)$raw_notelp);
                                 if (!empty($clean_wa_ph) && strlen($clean_wa_ph) >= 9):
                                    if (substr($clean_wa_ph, 0, 1) === '0') $clean_wa_ph = '62' . substr($clean_wa_ph, 1);
                                    if (substr($clean_wa_ph, 0, 2) !== '62') $clean_wa_ph = '62' . $clean_wa_ph;
                                 ?>
                                    <a href="https://api.whatsapp.com/send?phone=<?= $clean_wa_ph; ?>" target="_blank" class="btn btn-xs btn-success" style="background:#25d366; border-color:#25d366; color:#fff; border-radius:4px; padding:1.5px 5px; font-size:9.5px; font-weight:700; display:inline-flex; align-items:center; gap:2px; text-decoration:none;" title="Chat WhatsApp Langsung">
                                       <i class="fa fa-whatsapp"></i> WA
                                    </a>
                                 <?php endif; ?>
                              </div>
                           <?php endif; ?>
                           <?php if (!empty($so->nama_pengirim) && $so->nama_pengirim !== '-'): ?>
                              <div style="margin-top:2px; font-size:10px; color:#64748b;" title="Dropshipper / Pengirim: <?= _ent($so->nama_pengirim); ?>">
                                 <i class="fa fa-paper-plane text-info"></i> <?= _ent($so->nama_pengirim); ?>
                              </div>
                           <?php endif; ?>
                        </td>

                        <!-- 7. STATUS PACK -->
                        <td style="vertical-align:middle; text-align:center; padding:10px 8px; white-space:nowrap;">
                           <span class="status-packed-badge" style="background:<?= $st_badge_bg; ?>; font-size:10px; padding:3px 7px;"><?= $st_label; ?></span>
                        </td>

                        <!-- 8. FOLLOW-UP CRM -->
                        <td style="vertical-align:middle; padding:10px 10px; width:155px;">
                           <div style="display:flex; align-items:center; gap:6px; margin-bottom:4px;">
                              <span class="<?= $ket_cls; ?>" id="badge-ket-so-<?= $so->id; ?>" data-order-id="<?= $so->id; ?>" data-diff-h="<?= $diff_h; ?>" data-highest-due="<?= $highest_due_h; ?>" title="<?= $ket_title; ?> (Klik untuk tandai Follow-Up)" style="font-size:10.5px; padding:2px 7px;">
                                 <i class="fa <?= $ket_icon; ?>"></i> H+<?= $diff_h; ?>
                              </span>
                              <?php if ($is_up_to_date): ?>
                                 <small style="color:#10b981; font-weight:700; font-size:10.5px;"><i class="fa fa-check-circle"></i> Selesai</small>
                              <?php elseif ($diff_h > 0): ?>
                                 <small style="color:#ef4444; font-weight:700; font-size:10.5px;"><i class="fa fa-exclamation-circle"></i> Terlewat</small>
                              <?php endif; ?>
                           </div>
                           <div class="btn-group-keterangan-bc" data-order-id="<?= $so->id; ?>" data-diff-h="<?= $diff_h; ?>" data-highest-due="<?= $highest_due_h; ?>">
                              <?php
                              $row_bc_opts = $all_bc_options;
                              foreach ($row_bc_opts as $bco):
                                 $is_h = preg_match('/\(H\+(\d+)\)/i', $bco, $m) || preg_match('/^H\+(\d+)$/i', $bco, $m);
                                 $h_val = $is_h ? (int)$m[1] : null;
                                 $display_text = $is_h ? ('H+' . $h_val) : $bco;

                                 $is_act = ($cur_bc === $bco || ($is_h && $h_done !== null && $h_done === $h_val));

                                 $btn_cls = '';
                                 if ($is_act) {
                                    $btn_cls = 'active';
                                    $btn_title = 'Sudah Di-Follow Up: ' . $bco . ' (Klik untuk batalkan)';
                                 } elseif (!$is_act && $is_h && $diff_h >= $h_val && ($h_done === null || $h_done < $h_val)) {
                                    $btn_cls = 'btn-bc-overdue';
                                    $btn_title = 'Terlewat: Belum Follow-Up ' . $bco . ' (Umur Pesanan H+' . $diff_h . ') - Klik untuk tandai selesai';
                                 } else {
                                    $btn_title = $bco . ' - Klik untuk tandai selesai';
                                 }
                              ?>
                                 <span class="badge-bc-pill <?= $btn_cls; ?>" data-val="<?= htmlspecialchars($bco); ?>" data-h="<?= $h_val !== null ? $h_val : ''; ?>" title="<?= $btn_title; ?>">
                                    <?php if ($is_act): ?><i class="fa fa-check"></i> <?php endif; ?><?= htmlspecialchars($display_text); ?>
                                 </span>
                              <?php endforeach; ?>
                           </div>
                        </td>

                        <!-- 9. AKSI (Sticky Right Toolbar) -->
                        <td class="text-center col-sticky-action" style="vertical-align:middle; padding:8px 10px; white-space:nowrap;">
                           <div class="pm-action-cell">
                              <div class="pm-action-row">
                                 <a href="<?= site_url('administrator/crm/journal_followup?phone=' . urlencode($raw_notelp)); ?>" target="_blank" class="pm-act-btn pm-act-fu" title="Buka CRM Chat Follow-Up Pelanggan">
                                    <i class="fa fa-whatsapp"></i> Follow-Up
                                 </a>
                                 <a href="<?= site_url('administrator/penjualan_marketplace/view/' . $so->id); ?>" class="pm-act-btn pm-act-detail" title="Lihat Detail Pesanan">
                                    <i class="fa fa-eye"></i> Detail
                                 </a>
                              </div>
                              <div class="pm-action-row">
                                 <a href="<?= site_url('administrator/penjualan_marketplace/edit/' . $so->id); ?>" class="pm-act-btn pm-act-edit" title="Edit Data Pesanan">
                                    <i class="fa fa-pencil"></i> Edit
                                 </a>
                                 <a href="<?= site_url('administrator/penjualan_marketplace/cetak_resi/' . $so->id); ?>" target="_blank" class="pm-act-btn pm-act-print" title="Cetak Struk / Resi Thermal AWB">
                                    <i class="fa fa-print"></i> Cetak
                                 </a>
                                 <a href="javascript:void(0);" data-href="<?= site_url('administrator/penjualan_marketplace/delete/' . $so->id); ?>" data-nopesanan="<?= _ent($display_no_pesanan); ?>" data-qty="<?= (int)$qty_item; ?>" class="pm-act-btn pm-act-delete remove-data" title="Hapus Pesanan">
                                    <i class="fa fa-trash"></i>
                                 </a>
                              </div>
                           </div>
                        </td>
                     </tr>
                     <?php endforeach; ?>
                  <?php else: ?>
                     <tr>
                        <td colspan="10" class="text-center text-muted" style="padding:50px;">
                           <i class="fa fa-shopping-cart fa-3x" style="color:#cbd5e1; margin-bottom:12px;"></i><br>
                           <span style="font-size:16px; font-weight:bold; color:#334155;">Belum ada data Penjualan Marketplace.</span><br>
                           <small class="text-muted">Silakan import CSV Shopee/Tokopedia atau buat pesanan baru.</small>
                        </td>
                     </tr>
                  <?php endif; ?>
               </tbody>
            </table>
         </div>
      </div>
      <div class="box-footer" style="background:#ffffff; border-top:1px solid #e2e8f0; padding:16px 24px;">
         <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12" style="padding-top:6px;">
               <span class="text-muted" style="font-size:12.5px;">Menampilkan total <strong><?= count($sos); ?></strong> dari <strong><?= $so_counts; ?></strong> Pesanan Penjualan Marketplace</span>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 text-right">
               <?= $pagination; ?>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- MODAL IMPORT PENJUALAN WITH LOKASI SELECTOR & CSV LIVE PREVIEW -->
<!-- MODAL IMPORT PENJUALAN MARKETPLACE (REDESIGNED ULTRA CLEAR UI/UX) -->
<style>
#modalImportMarketplace .modal-dialog {
   max-width: 880px;
   width: 95%;
   margin: 30px auto;
}
#modalImportMarketplace .modal-content {
   border-radius: 16px;
   border: 1px solid rgba(255, 255, 255, 0.1);
   box-shadow: 0 25px 60px -12px rgba(15, 23, 42, 0.35);
   overflow: hidden;
   background: #ffffff;
}
#modalImportMarketplace .modal-header {
   background: #F8FAFC;
   color: #1E293B;
   padding: 18px 24px;
   border-bottom: 1.5px solid #E2E8F0;
   position: relative;
}
#modalImportMarketplace .modal-title {
   font-size: 17px;
   font-weight: 700;
   color: #1E293B;
   display: flex;
   align-items: center;
   gap: 12px;
   margin: 0;
}
#modalImportMarketplace .header-icon-box {
   width: 36px;
   height: 36px;
   background: #EFF6FF;
   border: 1px solid #BFDBFE;
   border-radius: 8px;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   color: #2563EB;
   font-size: 16px;
}
#modalImportMarketplace .modal-subtitle {
   font-size: 12.5px;
   color: #64748B;
   margin-top: 4px;
   margin-left: 48px;
   font-weight: 400;
}
#modalImportMarketplace .close-btn-custom {
   position: absolute;
   top: 18px;
   right: 20px;
   background: #F1F5F9;
   border: 1px solid #E2E8F0;
   color: #64748B;
   width: 32px;
   height: 32px;
   border-radius: 8px;
   opacity: 1;
   font-size: 20px;
   line-height: 28px;
   text-align: center;
   transition: all 0.2s ease;
   cursor: pointer;
}
#modalImportMarketplace .close-btn-custom:hover {
   background: #E2E8F0;
   color: #0F172A;
}

/* Nav Tabs Pill-Cards */
.import-nav-tabs {
   display: flex;
   gap: 12px;
   border-bottom: 2px solid #F1F5F9;
   padding-bottom: 18px;
   margin-bottom: 24px;
   list-style: none;
   padding-left: 0;
}
.import-nav-tabs > li {
   flex: 1;
   margin: 0;
}
.import-nav-tabs > li > a {
   display: flex;
   align-items: center;
   justify-content: center;
   gap: 10px;
   padding: 13px 16px;
   border-radius: 12px;
   border: 1.5px solid #E2E8F0;
   background: #F8FAFC;
   color: #475569;
   font-weight: 700;
   font-size: 13.5px;
   transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
   text-decoration: none !important;
}
.import-nav-tabs > li > a i {
   font-size: 18px;
}
.import-nav-tabs > li.active > a.tab-shopee,
.import-nav-tabs > li > a.tab-shopee:hover {
   background: #FFF5F2 !important;
   border-color: #EE4D2D !important;
   color: #EE4D2D !important;
   box-shadow: 0 4px 14px rgba(238, 77, 45, 0.15);
}
.import-nav-tabs > li.active > a.tab-tokopedia,
.import-nav-tabs > li > a.tab-tokopedia:hover {
   background: #F0FDF4 !important;
   border-color: #03AC0E !important;
   color: #03AC0E !important;
   box-shadow: 0 4px 14px rgba(3, 172, 14, 0.15);
}
.import-nav-tabs > li.active > a.tab-tiktok,
.import-nav-tabs > li > a.tab-tiktok:hover {
   background: #F1F5F9 !important;
   border-color: #0F172A !important;
   color: #0F172A !important;
   box-shadow: 0 4px 14px rgba(15, 23, 42, 0.15);
}

/* Clear High-Contrast Instruction Box */
.import-instruction-card {
   border-radius: 12px;
   padding: 18px 22px;
   margin-bottom: 22px;
   border: 1px solid #E2E8F0;
   background: #FFFFFF;
   box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
   position: relative;
}
.guide-header {
   display: flex;
   justify-content: space-between;
   align-items: center;
   flex-wrap: wrap;
   gap: 12px;
   margin-bottom: 12px;
}
.guide-title {
   font-size: 15px;
   font-weight: 700;
   color: #0F172A;
   margin: 0;
}
.btn-download-tpl {
   display: inline-flex;
   align-items: center;
   gap: 6px;
   padding: 7px 14px;
   border-radius: 8px;
   color: #FFFFFF !important;
   font-size: 12px;
   font-weight: 700;
   text-decoration: none !important;
   transition: all 0.2s ease;
}
.btn-download-tpl:hover {
   opacity: 0.9;
   transform: translateY(-1px);
}
.guide-desc {
   font-size: 13px;
   color: #475569;
   line-height: 1.5;
   margin-bottom: 14px;
}
.guide-specs {
   display: flex;
   gap: 8px;
   flex-wrap: wrap;
}
.guide-spec-badge {
   background: #F8FAFC;
   border: 1px solid #E2E8F0;
   border-radius: 6px;
   padding: 4px 10px;
   font-size: 11.5px;
   font-weight: 600;
   color: #334155;
}

/* Custom Drag and Drop Zone */
.custom-dropzone {
   border: 2px dashed #CBD5E1;
   border-radius: 14px;
   padding: 32px 20px;
   text-align: center;
   cursor: pointer;
   background: #FAFAFA;
   transition: all 0.2s ease;
   position: relative;
   margin-bottom: 18px;
}
.custom-dropzone:hover {
   background: #F1F5F9;
   border-color: #94A3B8;
}
.dropzone-file-input {
   display: none;
}
.dropzone-icon {
   font-size: 38px;
   color: #64748B;
   margin-bottom: 10px;
}
.dropzone-title {
   font-size: 15px;
   font-weight: 700;
   color: #0F172A;
   margin-bottom: 4px;
}
.dropzone-subtitle {
   font-size: 12.5px;
   color: #64748B;
   margin-bottom: 14px;
}
.btn-browse-file {
   border-radius: 8px;
   font-weight: 700;
   font-size: 12.5px;
   padding: 7px 18px;
   border: 1px solid #CBD5E1;
   background: #FFFFFF;
}

/* Selected File Card */
.selected-file-display {
   display: none;
   align-items: center;
   justify-content: space-between;
   background: #F0FDF4;
   border: 1px solid #BBF7D0;
   border-radius: 10px;
   padding: 12px 16px;
   margin-bottom: 18px;
}
.selected-file-info {
   display: flex;
   align-items: center;
   gap: 12px;
}
.selected-file-icon {
   font-size: 26px;
   color: #16A34A;
}
.selected-file-name {
   font-size: 13.5px;
   font-weight: 700;
   color: #14532D;
}
.selected-file-meta {
   font-size: 11.5px;
   color: #16A34A;
   margin-top: 2px;
}

/* Modal Footer Custom */
.modal-footer-custom {
   display: flex;
   justify-content: flex-end;
   align-items: center;
   gap: 10px;
   padding-top: 18px;
   border-top: 1px solid #E2E8F0;
   margin-top: 16px;
}
.btn-import-cancel {
   border-radius: 8px;
   font-weight: 700;
   padding: 9px 18px;
   font-size: 13px;
   border: 1px solid #CBD5E1;
   background: #FFFFFF;
   color: #475569;
}
.btn-import-submit {
   border-radius: 8px;
   font-weight: 700;
   padding: 9px 22px;
   font-size: 13px;
   color: #FFFFFF !important;
   border: none;
   box-shadow: 0 4px 12px rgba(0,0,0,0.15);
   transition: all 0.2s ease;
}
.btn-import-submit:hover {
   transform: translateY(-1px);
   box-shadow: 0 6px 18px rgba(0,0,0,0.22);
}

@media (max-width: 768px) {
   #modalImportMarketplace .modal-dialog {
      width: 96% !important;
      margin: 10px auto !important;
   }
   #modalImportMarketplace .modal-content {
      border-radius: 14px !important;
   }
   #modalImportMarketplace .modal-header {
      padding: 14px 16px !important;
   }
   #modalImportMarketplace .modal-subtitle {
      margin-left: 0 !important;
      font-size: 11.5px !important;
   }
   #modalImportMarketplace .modal-body {
      padding: 16px 14px !important;
   }
   .import-nav-tabs {
      flex-direction: column !important;
      gap: 8px !important;
      padding-bottom: 12px !important;
      margin-bottom: 16px !important;
   }
   .import-nav-tabs > li > a {
      padding: 10px 14px !important;
      font-size: 12.5px !important;
      justify-content: flex-start !important;
   }
   .import-instruction-card {
      padding: 14px 14px !important;
      margin-bottom: 16px !important;
   }
   .guide-header {
      flex-direction: column !important;
      align-items: stretch !important;
   }
   .btn-download-tpl {
      width: 100% !important;
      justify-content: center !important;
      text-align: center !important;
   }
   .custom-dropzone {
      padding: 20px 14px !important;
   }
   .selected-file-display {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 10px !important;
   }
   .selected-file-display .btn {
      width: 100% !important;
   }
   .modal-footer-custom {
      flex-direction: column !important;
      gap: 8px !important;
   }
   .modal-footer-custom .btn {
      width: 100% !important;
      text-align: center !important;
   }
}
</style>

<div class="modal fade" id="modalImportMarketplace" tabindex="-1" role="dialog" aria-labelledby="modalImportMarketplaceLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close-btn-custom" data-dismiss="modal" aria-label="Close">&times;</button>
            <h4 class="modal-title" id="modalImportMarketplaceLabel">
               <span class="header-icon-box"><i class="fa fa-cloud-download"></i></span>
               Import Penjualan Marketplace
            </h4>
            <div class="modal-subtitle">Sinkronisasi data pesanan dari Shopee, Tokopedia, &amp; TikTok Shop ke CRM &amp; Inventori</div>
         </div>
         <div class="modal-body" style="padding:26px 28px;">
            <ul class="import-nav-tabs" role="tablist">
               <li role="presentation" class="active">
                  <a href="#shopee_tab" class="tab-shopee" aria-controls="shopee_tab" role="tab" data-toggle="tab">
                     <i class="fa fa-shopping-bag" style="color:#EE4D2D;"></i>
                     <span>Shopee Seller</span>
                  </a>
               </li>
               <li role="presentation">
                  <a href="#tokopedia_tab" class="tab-tokopedia" aria-controls="tokopedia_tab" role="tab" data-toggle="tab">
                     <i class="fa fa-shopping-cart" style="color:#03AC0E;"></i>
                     <span>Tokopedia Seller</span>
                  </a>
               </li>
               <li role="presentation">
                  <a href="#tiktok_tab" class="tab-tiktok" aria-controls="tiktok_tab" role="tab" data-toggle="tab">
                     <span>TikTok Shop</span>
                  </a>
               </li>
            </ul>

            <div class="tab-content">
               <!-- SHOPEE TAB -->
               <div role="tabpanel" class="tab-pane active" id="shopee_tab">
                  <div class="import-instruction-card shopee-guide">
                     <div class="guide-header">
                        <h5 class="guide-title"><i class="fa fa-info-circle text-danger"></i> Panduan Import CSV Shopee Seller:</h5>
                        <a href="<?= site_url('administrator/penjualan_marketplace/download_template_shopee'); ?>" class="btn-download-tpl" style="background:#EE4D2D;">
                           <i class="fa fa-download"></i> Download Template CSV Shopee
                        </a>
                     </div>
                     <p class="guide-desc">Upload file CSV hasil export pesanan resmi dari <strong>Shopee Seller Centre</strong>. Sistem secara otomatis mencocokkan produk, membuat profil pelanggan CRM baru jika belum terdaftar, serta memperbarui nomor resi pengiriman.</p>
                     <div class="guide-specs">
                        <span class="guide-spec-badge"><i class="fa fa-file-excel-o text-danger"></i> Format .XLSX / .XLS / .CSV</span>
                        <span class="guide-spec-badge"><i class="fa fa-user-plus text-success"></i> Auto-Sync CRM Pelanggan</span>
                        <span class="guide-spec-badge"><i class="fa fa-cubes text-primary"></i> Multi-Item Bundling Didukung</span>
                     </div>
                  </div>

                  <form action="<?= site_url('administrator/penjualan_marketplace/import_shopee'); ?>" method="POST" enctype="multipart/form-data">
                     <div class="custom-dropzone shopee-zone" id="dropzone_shopee">
                        <input type="file" id="file_csv_shopee" name="file_csv" class="dropzone-file-input" accept=".csv,.xlsx,.xls" required onchange="handleFileSelect(this, 'preview_shopee_box', 'btn_submit_shopee', 'selected_card_shopee', 'Shopee')">
                        <div class="dropzone-icon"><i class="fa fa-cloud-upload"></i></div>
                        <div class="dropzone-title">Tarik &amp; Lepas File CSV / Excel Shopee ke Sini</div>
                        <div class="dropzone-subtitle">Mendukung file Excel (.xlsx, .xls) atau CSV (.csv)</div>
                        <span class="btn btn-default btn-browse-file"><i class="fa fa-folder-open-o text-danger"></i> Pilih File Excel / CSV</span>
                     </div>

                     <!-- Selected File Card -->
                     <div class="selected-file-display" id="selected_card_shopee">
                        <div class="selected-file-info">
                           <div class="selected-file-icon"><i class="fa fa-file-excel-o"></i></div>
                           <div>
                              <div class="selected-file-name" id="selected_name_shopee">nama_file.csv</div>
                              <div class="selected-file-meta"><i class="fa fa-check-circle"></i> File terverifikasi &bull; <span id="selected_size_shopee">0 KB</span></div>
                           </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-default" onclick="$('#file_csv_shopee').click();" style="border-radius:6px; font-weight:700;"><i class="fa fa-refresh"></i> Ganti File</button>
                     </div>

                     <!-- CSV Live Preview Box -->
                     <div id="preview_shopee_box"></div>

                     <div class="modal-footer-custom">
                        <button type="button" class="btn btn-import-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" id="btn_submit_shopee" class="btn btn-import-submit" style="background:#EE4D2D;">
                           <i class="fa fa-upload"></i> Proses &amp; Import Shopee CSV
                        </button>
                     </div>
                  </form>
               </div>

               <!-- TOKOPEDIA TAB -->
               <div role="tabpanel" class="tab-pane" id="tokopedia_tab">
                  <div class="import-instruction-card tokopedia-guide">
                     <div class="guide-header">
                        <h5 class="guide-title"><i class="fa fa-info-circle text-success"></i> Panduan Import CSV Tokopedia:</h5>
                        <a href="<?= site_url('administrator/penjualan_marketplace/download_template_tokopedia'); ?>" class="btn-download-tpl" style="background:#03AC0E;">
                           <i class="fa fa-download"></i> Download Template CSV Tokopedia
                        </a>
                     </div>
                     <p class="guide-desc">Upload file CSV export laporan pesanan dari <strong>Tokopedia Seller Center</strong>. Sistem secara pintar memproses format invoice <code>INV/YYYYMMDD/MPL/...</code>, mendata kurir (SiCepat, GoSend, J&amp;T, dll), dan merekap transaksi secara akurat.</p>
                     <div class="guide-specs">
                        <span class="guide-spec-badge"><i class="fa fa-file-excel-o text-success"></i> Format .XLSX / .XLS / .CSV</span>
                        <span class="guide-spec-badge"><i class="fa fa-truck text-primary"></i> Kurir Instan &amp; Reguler</span>
                        <span class="guide-spec-badge"><i class="fa fa-shield text-warning"></i> Cek Duplikasi Otomatis</span>
                     </div>
                  </div>

                  <form action="<?= site_url('administrator/penjualan_marketplace/import_tokopedia'); ?>" method="POST" enctype="multipart/form-data">
                     <div class="custom-dropzone tokopedia-zone" id="dropzone_tokopedia">
                        <input type="file" id="file_csv_tokopedia" name="file_csv" class="dropzone-file-input" accept=".csv,.xlsx,.xls" required onchange="handleFileSelect(this, 'preview_tokopedia_box', 'btn_submit_tokopedia', 'selected_card_tokopedia', 'Tokopedia')">
                        <div class="dropzone-icon"><i class="fa fa-cloud-upload"></i></div>
                        <div class="dropzone-title">Tarik &amp; Lepas File CSV / Excel Tokopedia ke Sini</div>
                        <div class="dropzone-subtitle">Mendukung file Excel (.xlsx, .xls) atau CSV (.csv)</div>
                        <span class="btn btn-default btn-browse-file"><i class="fa fa-folder-open-o text-success"></i> Pilih File Excel / CSV</span>
                     </div>

                     <!-- Selected File Card -->
                     <div class="selected-file-display" id="selected_card_tokopedia">
                        <div class="selected-file-info">
                           <div class="selected-file-icon"><i class="fa fa-file-excel-o"></i></div>
                           <div>
                              <div class="selected-file-name" id="selected_name_tokopedia">nama_file.csv</div>
                              <div class="selected-file-meta"><i class="fa fa-check-circle"></i> File terverifikasi &bull; <span id="selected_size_tokopedia">0 KB</span></div>
                           </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-default" onclick="$('#file_csv_tokopedia').click();" style="border-radius:6px; font-weight:700;"><i class="fa fa-refresh"></i> Ganti File</button>
                     </div>

                     <!-- CSV Live Preview Box -->
                     <div id="preview_tokopedia_box"></div>

                     <div class="modal-footer-custom">
                        <button type="button" class="btn btn-import-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" id="btn_submit_tokopedia" class="btn btn-import-submit" style="background:#03AC0E;">
                           <i class="fa fa-upload"></i> Proses &amp; Import Tokopedia CSV
                        </button>
                     </div>
                  </form>
               </div>

               <!-- TIKTOK SHOP TAB -->
               <div role="tabpanel" class="tab-pane" id="tiktok_tab">
                  <div class="import-instruction-card tiktok-guide">
                     <div class="guide-header">
                        <h5 class="guide-title"><i class="fa fa-info-circle text-primary"></i> Panduan Import Excel / CSV TikTok Shop:</h5>
                        <a href="<?= site_url('administrator/penjualan_marketplace/download_template_tiktok'); ?>" class="btn-download-tpl" style="background:#0F172A;">
                           <i class="fa fa-download"></i> Download Template TikTok Shop
                        </a>
                     </div>
                     <p class="guide-desc">Upload file export pesanan resmi dari <strong>TikTok Shop Seller Center</strong> (.xls, .xlsx, atau .csv). Sistem otomatis mengelompokkan multi-item pesanan, mencatat tracking resi, serta menyinkronkan data pelanggan ke modul CRM.</p>
                     <div class="guide-specs">
                        <span class="guide-spec-badge"><i class="fa fa-file-excel-o text-success"></i> Format .XLSX / .XLS / .CSV</span>
                        <span class="guide-spec-badge"><i class="fa fa-tags text-primary"></i> Auto-Label Follow-Up CRM</span>
                        <span class="guide-spec-badge"><i class="fa fa-bolt text-warning"></i> Parsing Cepat Tanpa Batas</span>
                     </div>
                  </div>

                  <form action="<?= site_url('administrator/penjualan_marketplace/import_tiktok'); ?>" method="POST" enctype="multipart/form-data">
                     <div class="custom-dropzone tiktok-zone" id="dropzone_tiktok">
                        <input type="file" id="file_excel_tiktok" name="file_excel" class="dropzone-file-input" accept=".xls,.xlsx,.csv" required onchange="handleFileSelect(this, 'preview_tiktok_box', 'btn_submit_tiktok', 'selected_card_tiktok', 'TikTok Shop')">
                        <div class="dropzone-icon"><i class="fa fa-cloud-upload"></i></div>
                        <div class="dropzone-title">Tarik &amp; Lepas File TikTok Shop ke Sini</div>
                        <div class="dropzone-subtitle">Mendukung file Excel (.xlsx, .xls) atau CSV (.csv)</div>
                        <span class="btn btn-default btn-browse-file"><i class="fa fa-folder-open-o text-primary"></i> Pilih File Excel / CSV</span>
                     </div>

                     <!-- Selected File Card -->
                     <div class="selected-file-display" id="selected_card_tiktok">
                        <div class="selected-file-info">
                           <div class="selected-file-icon"><i class="fa fa-file-excel-o"></i></div>
                           <div>
                              <div class="selected-file-name" id="selected_name_tiktok">nama_file.xlsx</div>
                              <div class="selected-file-meta"><i class="fa fa-check-circle"></i> File terverifikasi &bull; <span id="selected_size_tiktok">0 KB</span></div>
                           </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-default" onclick="$('#file_excel_tiktok').click();" style="border-radius:6px; font-weight:700;"><i class="fa fa-refresh"></i> Ganti File</button>
                     </div>

                     <!-- Live Preview Box -->
                     <div id="preview_tiktok_box"></div>

                     <div class="modal-footer-custom">
                        <button type="button" class="btn btn-import-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" id="btn_submit_tiktok" class="btn btn-import-submit" style="background:#0F172A;">
                           <i class="fa fa-upload"></i> Proses &amp; Import TikTok Shop
                        </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<!-- ========================================================================= -->
<!-- MODAL: IMPORT RESI MASSAL DARI FOTO / PDF MULTI-HALAMAN                    -->
<!-- ========================================================================= -->
<!-- Multi-Tier Scanning & OCR Libraries: PDF.js + Tesseract OCR (Ind+Eng) + ZXing Universal Barcode Scanner -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@zxing/library@0.21.3/umd/index.min.js"></script>
<script src="<?= BASE_ASSET; ?>js/barcode128_decoder.js?v=<?= time(); ?>"></script>

<!-- remove-data handler handled centrally at footer script -->

<style>
@keyframes resiSpin {
   0% { transform: rotate(0deg); }
   100% { transform: rotate(360deg); }
}
@keyframes resiScanLaser {
   0%, 100% { top: 16%; opacity: 0.2; }
   50% { top: 78%; opacity: 1; }
}
@keyframes resiShimmer {
   0% { transform: translateX(-100%); }
   100% { transform: translateX(200%); }
}
@keyframes resiCardPop {
   0% { transform: scale(0.94); opacity: 0; }
   100% { transform: scale(1); opacity: 1; }
}
@keyframes resiCheckBounce {
   0% { transform: scale(0.3); opacity: 0; }
   50% { transform: scale(1.15); }
   70% { transform: scale(0.95); }
   100% { transform: scale(1); opacity: 1; }
}
@keyframes resiPulseDot {
   0%, 100% { transform: scale(1); opacity: 1; }
   50% { transform: scale(1.35); opacity: 0.6; }
}

/* Modal Dialog & Content Aesthetics */
.modal-resi-dialog {
   max-width: 1140px;
   width: 95%;
   margin: 24px auto;
}
.modal-resi-content {
   border-radius: 20px;
   border: none;
   box-shadow: 0 25px 60px rgba(15,23,42,0.28);
   overflow: hidden;
   position: relative;
   background: #ffffff;
}

/* Dropzone Styles & Auto-Compact Mode */
.modal-resi-dropzone {
   border: 2px dashed #94a3b8;
   background: #ffffff;
   border-radius: 16px;
   padding: 30px 20px;
   text-align: center;
   cursor: pointer;
   transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
   box-shadow: 0 4px 15px rgba(0,0,0,0.02);
   position: relative;
}
.modal-resi-dropzone:hover {
   border-color: #0284c7 !important;
   background: #f0f9ff !important;
   box-shadow: 0 0 25px rgba(2, 132, 199, 0.15);
}
.modal-resi-dropzone.is-compact {
   padding: 12px 20px !important;
   background: #f8fafc !important;
   border: 1.5px dashed #93c5fd !important;
}
.modal-resi-dropzone.is-compact .dropzone-main-content {
   display: flex !important;
   flex-direction: row !important;
   justify-content: space-between !important;
   align-items: center !important;
   text-align: left !important;
   gap: 14px !important;
}
.modal-resi-dropzone.is-compact .dropzone-icon-box {
   width: 38px !important;
   height: 38px !important;
   margin-bottom: 0 !important;
   flex-shrink: 0 !important;
}
.modal-resi-dropzone.is-compact .dropzone-icon-box i {
   font-size: 18px !important;
}
.modal-resi-dropzone.is-compact .dropzone-text-group {
   text-align: left !important;
   flex: 1 !important;
}
.modal-resi-dropzone.is-compact .dropzone-text-group h4 {
   font-size: 13.5px !important;
   margin: 0 !important;
   color: #1e293b !important;
}
.modal-resi-dropzone.is-compact .dropzone-desc,
.modal-resi-dropzone.is-compact .dropzone-footer-text {
   display: none !important;
}
.modal-resi-dropzone.is-compact .btn-resi-primary {
   padding: 7px 16px !important;
   font-size: 12px !important;
   border-radius: 8px !important;
   box-shadow: 0 2px 6px rgba(2,132,199,0.2) !important;
}

.btn-resi-primary:hover {
   transform: translateY(-1px);
   box-shadow: 0 6px 16px rgba(2,132,199,0.35) !important;
}

/* 4 Bento Stat Cards - CSS Grid */
.modal-resi-bento-grid {
   display: grid;
   grid-template-columns: repeat(4, 1fr);
   gap: 12px;
   margin-bottom: 16px;
}
@media (max-width: 991px) {
   .modal-resi-bento-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
   }
}
@media (max-width: 540px) {
   .modal-resi-bento-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;
   }
}
.modal-bento-card {
   transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.modal-bento-card:hover {
   transform: translateY(-2px);
   box-shadow: 0 6px 16px rgba(0,0,0,0.06);
}

/* Results Table Box & Sticky Thead */
.modal-resi-table-wrapper {
   background: #ffffff;
   border: 1px solid #cbd5e1;
   border-radius: 14px;
   overflow: hidden;
   box-shadow: 0 4px 15px rgba(0,0,0,0.03);
}
.modal-resi-table-scrollbox {
   max-height: 440px;
   min-height: 160px;
   overflow-y: auto;
   overflow-x: auto;
   position: relative;
   scrollbar-width: thin;
   scrollbar-color: #cbd5e1 #f8fafc;
   -webkit-overflow-scrolling: touch;
}
.modal-resi-table-scrollbox::-webkit-scrollbar {
   width: 7px;
   height: 7px;
}
.modal-resi-table-scrollbox::-webkit-scrollbar-track {
   background: #f8fafc;
}
.modal-resi-table-scrollbox::-webkit-scrollbar-thumb {
   background: #cbd5e1;
   border-radius: 4px;
}
.modal-resi-table-scrollbox::-webkit-scrollbar-thumb:hover {
   background: #94a3b8;
}

.modal-resi-table {
   width: 100%;
   margin-bottom: 0;
   border-collapse: separate !important;
   border-spacing: 0 !important;
}
.modal-resi-table thead th.th-sticky {
   position: sticky;
   top: 0;
   z-index: 10;
   background: #0f172a !important;
   color: #f8fafc !important;
   font-size: 10.5px;
   font-weight: 700;
   text-transform: uppercase;
   letter-spacing: 0.5px;
   padding: 12px 10px;
   border: none !important;
   border-bottom: 2px solid #334155 !important;
   box-shadow: 0 2px 6px rgba(15, 23, 42, 0.18);
   vertical-align: middle;
   white-space: nowrap;
}
.modal-resi-table tbody tr {
   transition: background-color 0.15s ease;
}
.modal-resi-table tbody tr:hover {
   filter: brightness(0.98);
}
.modal-resi-table tbody td {
   padding: 10px 10px;
   vertical-align: middle !important;
   border-top: 1px solid #e2e8f0;
   line-height: 1.4;
}

/* Frosted Glass Center Card Overlay */
.modal-resi-blur-card {
   transition: all 0.3s ease;
}
.blur-mini-stat {
   transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.blur-mini-stat:hover {
   transform: translateY(-2px);
   box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}
.btn-blur-action {
   transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn-blur-action:hover {
   transform: translateY(-1px);
}
.btn-resi-filter {
   transition: all 0.15s ease;
}
.btn-resi-filter:hover {
   filter: brightness(0.96);
}

@media (max-width: 768px) {
   .modal-resi-dialog {
      width: 96% !important;
      margin: 10px auto !important;
   }
   .modal-resi-content {
      border-radius: 14px !important;
   }
   .modal-resi-dropzone {
      padding: 16px 12px !important;
      border-radius: 12px !important;
   }
   .modal-resi-dropzone.is-compact {
      padding: 10px 12px !important;
   }
   .modal-resi-dropzone.is-compact .dropzone-main-content {
      flex-direction: column !important;
      text-align: center !important;
      gap: 8px !important;
   }
   .modal-resi-dropzone.is-compact .dropzone-text-group {
      text-align: center !important;
   }
   .modal-bento-card {
      padding: 9px 10px !important;
      gap: 8px !important;
      border-radius: 10px !important;
   }
   .modal-resi-table-scrollbox {
      max-height: 350px !important;
   }
   .modal-resi-table thead th.th-sticky {
      padding: 9px 8px !important;
      font-size: 9.5px !important;
   }
   .modal-resi-table tbody td {
      padding: 8px 8px !important;
      font-size: 11px !important;
   }
   .resi-filter-group {
      width: 100% !important;
      display: flex !important;
      justify-content: flex-start !important;
      gap: 4px !important;
      overflow-x: auto !important;
      padding-bottom: 4px !important;
      -webkit-overflow-scrolling: touch;
   }
   .btn-resi-filter {
      font-size: 10px !important;
      padding: 4px 8px !important;
      white-space: nowrap !important;
   }
   #modal_resi_blur_overlay {
      padding: 12px 10px !important;
   }
   .modal-resi-blur-card {
      max-width: 96% !important;
      padding: 18px 14px !important;
      border-radius: 16px !important;
   }
   #blur_scanner_box {
      width: 60px !important;
      height: 60px !important;
      margin-bottom: 10px !important;
   }
   #blur_scanner_icon {
      font-size: 26px !important;
   }
   #blur_overlay_title {
      font-size: 15px !important;
   }
   #blur_overlay_step {
      font-size: 11px !important;
      padding: 4px 10px !important;
   }
   .blur-mini-stat {
      padding: 7px 4px !important;
      border-radius: 8px !important;
   }
   .modal-footer {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 10px !important;
      padding: 12px 16px !important;
   }
   .modal-footer .btn {
      width: 100% !important;
   }
}
</style>

<div class="modal fade" id="modalImportResiMassal" tabindex="-1" role="dialog" aria-labelledby="modalImportResiMassalLabel">
   <div class="modal-dialog modal-resi-dialog" role="document">
      <div class="modal-content modal-resi-content">
         
         <!-- ========================================================================= -->
         <!-- CENTERED FROSTED GLASS BLUR LOADING OVERLAY (ALWAYS CENTERED IN VIEWPORT) -->
         <!-- ========================================================================= -->
         <div id="modal_resi_blur_overlay" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:1060; background:rgba(15, 23, 42, 0.72); backdrop-filter:blur(10px) saturate(180%); -webkit-backdrop-filter:blur(10px); align-items:center; justify-content:center; flex-direction:column; padding:20px; overflow-y:auto; transition:all 0.3s ease;">
            
            <div class="modal-resi-blur-card" style="width:100%; max-width:480px; max-height:92vh; overflow-y:auto; background:#ffffff; border-radius:22px; padding:28px 24px; text-align:center; box-shadow:0 25px 60px -15px rgba(0,0,0,0.45), 0 0 0 1px rgba(255,255,255,0.9) inset; border:1px solid rgba(226, 232, 240, 0.9); position:relative; animation:resiCardPop 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
               
               <!-- Close / Minimize Overlay Button -->
               <button type="button" id="btn_blur_close_overlay" style="position:absolute; top:16px; right:16px; background:#f1f5f9; border:1px solid #e2e8f0; width:32px; height:32px; border-radius:50%; color:#64748b; font-size:16px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.2s;" title="Lihat tabel di latar belakang">&times;</button>

               <!-- Ambient Top Glow -->
               <div style="position:absolute; top:-30px; left:50%; transform:translateX(-50%); width:240px; height:70px; background:radial-gradient(ellipse at center, rgba(14,165,233,0.3) 0%, rgba(255,255,255,0) 70%); pointer-events:none;"></div>
               
               <!-- Icon Scanner / Radar Animation -->
               <div id="blur_scanner_box" style="width:78px; height:78px; border-radius:50%; margin:0 auto 16px; position:relative; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border:2px solid #bae6fd; box-shadow:0 8px 24px rgba(2,132,199,0.2);">
                  <div class="scanner-ring" style="position:absolute; inset:-7px; border-radius:50%; border:2px dashed rgba(2,132,199,0.4); animation:resiSpin 10s linear infinite;"></div>
                  <div class="scanner-ring" style="position:absolute; inset:-3px; border-radius:50%; border:2.5px solid transparent; border-top-color:#0284c7; border-bottom-color:#38bdf8; animation:resiSpin 1.4s cubic-bezier(0.5, 0, 0.5, 1) infinite;"></div>
                  <i class="fa fa-barcode" id="blur_scanner_icon" style="font-size:34px; color:#0284c7; transition:all 0.3s ease;"></i>
                  <div class="scanner-laser" style="position:absolute; width:70%; height:2.5px; border-radius:2px; background:linear-gradient(90deg, transparent, #0284c7, #38bdf8, transparent); box-shadow:0 0 10px #38bdf8; animation:resiScanLaser 1.5s ease-in-out infinite;"></div>
               </div>

               <!-- Main Headline -->
               <h3 id="blur_overlay_title" style="font-size:17.5px; font-weight:800; color:#0f172a; margin:0 0 8px; letter-spacing:-0.3px; line-height:1.3;">
                  Memproses Import Resi Massal
               </h3>

               <!-- Step Description (Modern Pill Badge) -->
               <div style="margin-bottom:12px;">
                  <div id="blur_overlay_step" style="display:inline-flex; align-items:center; gap:8px; background:#f0f9ff; color:#0369a1; border:1px solid #bae6fd; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:700; box-shadow:0 2px 6px rgba(2,132,199,0.06); line-height:1.3; max-width:95%;">
                     <i class="fa fa-spinner fa-spin text-primary"></i> Mempersiapkan berkas &amp; dokumen resi...
                  </div>
               </div>

               <!-- Filename Pill -->
               <div id="blur_overlay_file_pill" style="display:flex; align-items:center; justify-content:center; gap:6px; max-width:88%; margin:0 auto 16px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:20px; padding:4px 12px; font-size:11.5px; color:#64748b; font-weight:600;">
                  <i class="fa fa-file-text-o text-primary" style="font-size:11px;"></i>
                  <span id="blur_overlay_filename" style="font-family:monospace; color:#334155; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:280px;">
                     Menyiapkan antrian data...
                  </span>
               </div>

               <!-- Large Progress Section -->
               <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:14px; padding:14px 16px; margin-bottom:14px; box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                     <div style="display:flex; align-items:center; gap:6px;">
                        <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#0284c7; box-shadow:0 0 6px rgba(2,132,199,0.6); animation:resiPulseDot 1.5s infinite;"></span>
                        <span style="font-size:11px; font-weight:800; color:#475569; text-transform:uppercase; letter-spacing:0.5px;">Progress Pemindaian</span>
                     </div>
                     <div style="display:flex; align-items:center; gap:6px;">
                        <span id="blur_overlay_pct" style="font-size:18px; font-weight:900; color:#0f172a; font-family:monospace; line-height:1;">0%</span>
                        <span id="blur_overlay_counter" class="badge" style="background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; font-weight:700; font-size:10px; border-radius:8px;">(0 / 0 Resi)</span>
                     </div>
                  </div>
                  <div style="height:9px; background:#f1f5f9; border-radius:20px; overflow:hidden; position:relative; border:1px solid #e2e8f0;">
                     <div id="blur_overlay_bar" style="width:0%; height:100%; border-radius:20px; background:linear-gradient(90deg, #0284c7 0%, #38bdf8 50%, #2563eb 100%); transition:width 0.3s cubic-bezier(0.4, 0, 0.2, 1); position:relative;">
                        <div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.45) 50%, rgba(255,255,255,0) 100%); animation:resiShimmer 1.5s infinite;"></div>
                     </div>
                  </div>
               </div>

               <!-- Mini Stats Row (Bento Cards with Icons) -->
               <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:10px; margin-bottom:14px;">
                  <div class="blur-mini-stat" style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:10px 8px; text-align:center;">
                     <div style="display:flex; align-items:center; justify-content:center; gap:4px; font-size:10px; font-weight:800; color:#16a34a; text-transform:uppercase; letter-spacing:0.3px;">
                        <i class="fa fa-check-circle"></i> Berhasil
                     </div>
                     <div id="blur_stat_success" style="font-size:20px; font-weight:900; color:#15803d; line-height:1.15; margin-top:3px;">0</div>
                  </div>
                  <div class="blur-mini-stat" style="background:#fffbeb; border:1px solid #fef3c7; border-radius:12px; padding:10px 8px; text-align:center;">
                     <div style="display:flex; align-items:center; justify-content:center; gap:4px; font-size:10px; font-weight:800; color:#b45309; text-transform:uppercase; letter-spacing:0.3px;">
                        <i class="fa fa-ban"></i> Ditolak
                     </div>
                     <div id="blur_stat_duplicate" style="font-size:20px; font-weight:900; color:#92400e; line-height:1.15; margin-top:3px;">0</div>
                  </div>
                  <div class="blur-mini-stat" style="background:#fef2f2; border:1px solid #fecaca; border-radius:12px; padding:10px 8px; text-align:center;">
                     <div style="display:flex; align-items:center; justify-content:center; gap:4px; font-size:10px; font-weight:800; color:#dc2626; text-transform:uppercase; letter-spacing:0.3px;">
                        <i class="fa fa-times-circle"></i> Gagal
                     </div>
                     <div id="blur_stat_failed" style="font-size:20px; font-weight:900; color:#991b1b; line-height:1.15; margin-top:3px;">0</div>
                  </div>
               </div>

               <!-- Live Preview & Duplicate Notice inside Center Card -->
               <div id="blur_duplicate_notice" style="display:none; background:#fffbeb; border:1px solid #fde68a; border-left:4px solid #f59e0b; border-radius:12px; padding:11px 14px; margin-bottom:14px; text-align:left; font-size:12px; color:#92400e; box-shadow:0 2px 6px rgba(245,158,11,0.08);">
                  <div style="display:flex; align-items:flex-start; gap:8px;">
                     <i class="fa fa-exclamation-triangle" style="font-size:16px; color:#d97706; margin-top:2px; flex-shrink:0;"></i>
                     <div>
                        <strong style="color:#b45309;">Peringatan Data Terduplikasi / Ditolak:</strong>
                        <div id="blur_duplicate_notice_msg" style="margin-top:2px; line-height:1.4;">Data resi ini sudah pernah tersimpan di database sistem.</div>
                     </div>
                  </div>
               </div>

               <div id="blur_live_preview_box" style="display:none; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:11px 14px; margin-bottom:14px; text-align:left; font-size:11.5px; box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                     <span style="font-weight:800; color:#475569; text-transform:uppercase; font-size:10px; letter-spacing:0.4px;"><i class="fa fa-eye text-info"></i> Pratinjau Terakhir</span>
                     <span id="blur_preview_badge" class="badge" style="background:#dcfce7; color:#15803d; font-size:10px;">Tersimpan</span>
                  </div>
                  <div id="blur_preview_content" style="color:#1e293b; line-height:1.4;"></div>
               </div>

               <!-- Completion Actions (Hidden during processing, shown on finish) -->
               <div id="blur_completion_actions" style="display:none; gap:10px; justify-content:center; flex-wrap:wrap; margin-top:4px;">
                  <button type="button" id="btn_blur_view_table" class="btn btn-default btn-blur-action" style="border-radius:10px; font-weight:700; padding:10px 18px; font-size:13px; border:1px solid #cbd5e1; background:#ffffff; color:#334155; box-shadow:0 2px 6px rgba(0,0,0,0.04);">
                     <i class="fa fa-list-alt text-info"></i> Lihat Rincian Tabel
                  </button>
                  <button type="button" id="btn_blur_reload_page" class="btn btn-success btn-blur-action" onclick="window.location.href='<?= site_url('administrator/penjualan_marketplace'); ?>';" style="border-radius:10px; font-weight:700; background:#16a34a; border-color:#16a34a; padding:10px 22px; font-size:13px; box-shadow:0 4px 14px rgba(22,163,74,0.35);">
                     <i class="fa fa-refresh"></i> Tampilkan di Daftar Penjualan
                  </button>
               </div>

            </div>
         </div>

         <!-- Modal Header -->
         <div class="modal-header" style="background:linear-gradient(135deg, #090d16 0%, #1e293b 100%); color:#ffffff; padding:20px 28px; border-bottom:1px solid rgba(255,255,255,0.08); display:flex; justify-content:space-between; align-items:center;">
            <div style="display:flex; align-items:center; gap:14px;">
               <div style="width:46px; height:46px; border-radius:14px; background:linear-gradient(135deg, #0284c7 0%, #2563eb 100%); display:flex; align-items:center; justify-content:center; color:#ffffff; font-size:22px; box-shadow:0 4px 14px rgba(2,132,199,0.4); border:1px solid rgba(255,255,255,0.15);">
                  <i class="fa fa-barcode"></i>
               </div>
               <div>
                  <h4 class="modal-title" id="modalImportResiMassalLabel" style="color:#ffffff; font-size:17.5px; font-weight:800; margin:0; line-height:1.25; letter-spacing:-0.2px;">
                     Import Resi Massal (Foto &amp; PDF Multi-Halaman)
                  </h4>
                  <div style="color:#94a3b8; font-size:12px; margin-top:3px;">
                     Auto-ekstraksi No. Resi, Barcode, Penerima &amp; Rincian Produk langsung tersinkron ke database.
                  </div>
               </div>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#ffffff; opacity:0.8; font-size:28px; line-height:1; text-shadow:none; width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; transition:all 0.2s;">&times;</button>
            </div>
         </div>

         <!-- Modal Body -->
         <div class="modal-body" style="padding:22px 28px; background:#f8fafc;">
            
            <!-- Panduan & Format yang Didukung -->
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:14px; padding:12px 18px; margin-bottom:16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
               <div style="display:flex; align-items:center; gap:10px;">
                  <i class="fa fa-info-circle text-info" style="font-size:20px;"></i>
                  <div style="font-size:12px; color:#334155; line-height:1.4;">
                     <strong>Mendukung Banyak File Sekaligus:</strong> Unggah banyak foto resi (JPG/PNG/WEBP) atau 1 file PDF berisi puluhan/ratusan halaman label thermal (Shopee, SPX, JNE, SiCepat, J&amp;T, Ninja, Anteraja).
                  </div>
               </div>
               <div style="display:flex; gap:6px; flex-wrap:wrap;">
                   <span class="badge" style="background:#e0f2fe; color:#0369a1; font-weight:700; font-size:10.5px; padding:5px 9px; border-radius:6px; border:1px solid #bae6fd;"><i class="fa fa-file-pdf-o"></i> PDF Multi-Halaman</span>
                   <span class="badge" style="background:#fef3c7; color:#92400e; font-weight:700; font-size:10.5px; padding:5px 9px; border-radius:6px; border:1px solid #fde68a;"><i class="fa fa-barcode"></i> ZXing &amp; Barcode Scanner</span>
                   <span class="badge" style="background:#f3e8ff; color:#7e22ce; font-weight:700; font-size:10.5px; padding:5px 9px; border-radius:6px; border:1px solid #e9d5ff;"><i class="fa fa-font"></i> Tesseract OCR (Ind+Eng)</span>
                   <span class="badge" style="background:#dcfce7; color:#15803d; font-weight:700; font-size:10.5px; padding:5px 9px; border-radius:6px; border:1px solid #bbf7d0;"><i class="fa fa-cubes"></i> Multi-Item &amp; SKU Parser</span>
                </div>
            </div>

            <!-- Modern Dropzone Box (Smooth Collapse into Action Bar on Upload) -->
            <div class="modal-resi-dropzone" id="modal_resi_dropzone">
               <div class="dropzone-main-content" style="display:flex; flex-direction:column; align-items:center;">
                  <div class="dropzone-icon-box" style="width:64px; height:64px; border-radius:50%; background:#f0f9ff; display:inline-flex; align-items:center; justify-content:center; margin-bottom:12px; border:1px solid #bae6fd; transition:all 0.3s ease;">
                     <i class="fa fa-cloud-upload text-primary" style="font-size:30px; color:#0284c7;"></i>
                  </div>
                  <div class="dropzone-text-group">
                     <h4 style="font-weight:800; color:#0f172a; margin-top:0; margin-bottom:6px; font-size:16.5px; letter-spacing:-0.2px;">
                        Tarik &amp; Lepaskan File PDF / Foto Resi ke Sini
                     </h4>
                     <p class="dropzone-desc" style="color:#64748b; font-size:12.5px; margin-bottom:16px; max-width:540px; margin-left:auto; margin-right:auto; line-height:1.5;">
                        Pilih satu atau banyak file foto resi, atau file dokumen PDF label pengiriman thermal dengan banyak halaman resi sekaligus.
                     </p>
                  </div>
                  <div class="dropzone-btn-row" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; justify-content:center;">
                     <label for="modal_resi_files_input" class="btn btn-primary btn-resi-primary" style="border-radius:10px; font-weight:700; background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border-color:#0284c7; cursor:pointer; padding:10px 24px; font-size:13px; box-shadow:0 4px 14px rgba(2,132,199,0.3); transition:all 0.2s; margin-bottom:0;">
                        <i class="fa fa-folder-open-o"></i> Pilih File Foto / PDF Resi (Bisa Banyak Sekaligus)
                     </label>
                  </div>
                  <input type="file" id="modal_resi_files_input" accept=".pdf,image/*" multiple style="display:none;">
                  <div class="dropzone-footer-text" style="margin-top:12px; font-size:11.5px; color:#94a3b8;">
                     <i class="fa fa-check-circle text-success"></i> Format didukung: PDF Dokumen, JPG, PNG, WEBP
                  </div>
               </div>
            </div>

            <!-- Batch Progress & Live Summary Section -->
            <div id="modal_resi_progress_container" style="display:none; margin-top:18px;">
               
               <!-- 4 Bento Stat Cards (Modern Responsive CSS Grid) -->
               <div class="modal-resi-bento-grid">
                  <div class="modal-bento-card" style="background:#eff6ff; border:1px solid #dbeafe; border-radius:14px; padding:12px 16px; display:flex; align-items:center; gap:12px; box-shadow:0 2px 6px rgba(37,99,235,0.04);">
                     <div style="width:42px; height:42px; border-radius:12px; background:#dbeafe; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa fa-files-o" style="font-size:18px; color:#2563eb;"></i>
                     </div>
                     <div style="min-width:0; flex:1;">
                        <div style="font-size:10px; font-weight:800; color:#3b82f6; text-transform:uppercase; letter-spacing:0.4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">TOTAL RESI / HALAMAN</div>
                        <div style="font-size:22px; font-weight:800; color:#1e40af; line-height:1.1; margin-top:2px;" id="modal_stat_total">0</div>
                     </div>
                  </div>

                  <div class="modal-bento-card" style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:14px; padding:12px 16px; display:flex; align-items:center; gap:12px; box-shadow:0 2px 6px rgba(22,163,74,0.04);">
                     <div style="width:42px; height:42px; border-radius:12px; background:#dcfce7; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa fa-check-circle" style="font-size:20px; color:#16a34a;"></i>
                     </div>
                     <div style="min-width:0; flex:1;">
                        <div style="font-size:10px; font-weight:800; color:#16a34a; text-transform:uppercase; letter-spacing:0.4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">BERHASIL DISINKRONKAN</div>
                        <div style="font-size:22px; font-weight:800; color:#15803d; line-height:1.1; margin-top:2px;" id="modal_stat_success">0</div>
                     </div>
                  </div>

                  <div class="modal-bento-card" style="background:#fffbeb; border:1px solid #fef3c7; border-radius:14px; padding:12px 16px; display:flex; align-items:center; gap:12px; box-shadow:0 2px 6px rgba(217,119,6,0.04);">
                     <div style="width:42px; height:42px; border-radius:12px; background:#fef3c7; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa fa-ban" style="font-size:20px; color:#d97706;"></i>
                     </div>
                     <div style="min-width:0; flex:1;">
                        <div style="font-size:10px; font-weight:800; color:#b45309; text-transform:uppercase; letter-spacing:0.4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">DATA SAMA (DITOLAK)</div>
                        <div style="font-size:22px; font-weight:800; color:#92400e; line-height:1.1; margin-top:2px;" id="modal_stat_duplicate">0</div>
                     </div>
                  </div>

                  <div class="modal-bento-card" style="background:#fef2f2; border:1px solid #fecaca; border-radius:14px; padding:12px 16px; display:flex; align-items:center; gap:12px; box-shadow:0 2px 6px rgba(220,38,38,0.04);">
                     <div style="width:42px; height:42px; border-radius:12px; background:#fee2e2; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa fa-exclamation-triangle" style="font-size:18px; color:#dc2626;"></i>
                     </div>
                     <div style="min-width:0; flex:1;">
                        <div style="font-size:10px; font-weight:800; color:#dc2626; text-transform:uppercase; letter-spacing:0.4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">GAGAL / TIDAK DITEMUKAN</div>
                        <div style="font-size:22px; font-weight:800; color:#991b1b; line-height:1.1; margin-top:2px;" id="modal_stat_failed">0</div>
                     </div>
                  </div>
               </div>

               <!-- Animated Progress Bar -->
               <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:14px; padding:14px 18px; margin-bottom:16px; box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                     <strong style="color:#0f172a; font-size:13px;" id="modal_progress_title">
                        <i class="fa fa-spinner fa-spin text-primary"></i> Memproses Import Resi Massal...
                     </strong>
                     <span class="badge" style="background:#0284c7; font-size:11.5px; padding:5px 12px; border-radius:10px;" id="modal_progress_counter">0 / 0</span>
                  </div>
                  <div class="progress" style="height:10px; border-radius:6px; background:#e2e8f0; margin-bottom:0; box-shadow:none;">
                     <div class="progress-bar progress-bar-primary progress-bar-striped active" id="modal_progress_bar" role="progressbar" style="width:0%; background:#0284c7; transition:width 0.25s ease;"></div>
                  </div>
               </div>

               <!-- Pemberitahuan Khusus Jika Ada Resi Yang Pernah Diinput Sebelumnya -->
               <div id="modal_table_duplicate_notice" style="display:none; background:#fffbeb; border:1px solid #fde68a; border-left:5px solid #f59e0b; border-radius:12px; padding:12px 16px; margin-bottom:14px; font-size:12px; color:#92400e; box-shadow:0 2px 6px rgba(245,158,11,0.06);">
                  <div style="display:flex; align-items:center; gap:8px;">
                     <i class="fa fa-exclamation-triangle" style="font-size:16px; color:#d97706; flex-shrink:0;"></i>
                     <div>
                        <strong>Pemberitahuan Duplikasi:</strong> Ditemukan <b id="duplicate_count_pill">0</b> data resi yang <strong>sudah pernah diinput sebelumnya</strong> di sistem. Data otomatis <strong>difilter &amp; ditolak</strong> agar tidak terjadi data dobel.
                     </div>
                  </div>
               </div>

               <!-- Live Results Table with Filter Tabs & Sticky Thead -->
               <div class="modal-resi-table-wrapper">
                  
                  <div style="padding:12px 18px; background:#f1f5f9; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                     <div style="display:flex; align-items:center; gap:8px;">
                        <strong style="font-size:13px; color:#0f172a;"><i class="fa fa-list-alt text-info"></i> Tabel Rincian Data Resi:</strong>
                        <span class="badge" style="background:#e2e8f0; color:#334155; font-size:11px; padding:4px 8px; border-radius:8px; font-weight:700;" id="modal_table_summary_label">0 Data</span>
                     </div>
                     
                     <!-- Filter Tabs / Tombol Filter Modern -->
                     <div class="resi-filter-group" style="display:inline-flex; gap:6px; flex-wrap:wrap;">
                        <button type="button" class="btn-resi-filter active" data-filter="all" style="padding:5px 12px; font-size:11px; font-weight:700; border-radius:20px; border:1px solid #0f172a; background:#0f172a; color:#ffffff; cursor:pointer;">
                           Semua (<span id="pill_count_all">0</span>)
                        </button>
                        <button type="button" class="btn-resi-filter" data-filter="success" style="padding:5px 12px; font-size:11px; font-weight:700; border-radius:20px; border:1px solid #bbf7d0; background:#f0fdf4; color:#15803d; cursor:pointer;">
                           <i class="fa fa-check-circle"></i> Berhasil (<span id="pill_count_success">0</span>)
                        </button>
                        <button type="button" class="btn-resi-filter" data-filter="duplicate" style="padding:5px 12px; font-size:11px; font-weight:700; border-radius:20px; border:1px solid #fde68a; background:#fffbeb; color:#92400e; cursor:pointer;">
                           <i class="fa fa-ban"></i> Sudah Pernah Diinput (<span id="pill_count_duplicate">0</span>)
                        </button>
                        <button type="button" class="btn-resi-filter" data-filter="failed" style="padding:5px 12px; font-size:11px; font-weight:700; border-radius:20px; border:1px solid #fecaca; background:#fef2f2; color:#991b1b; cursor:pointer;">
                           <i class="fa fa-times-circle"></i> Gagal (<span id="pill_count_failed">0</span>)
                        </button>
                     </div>
                  </div>

                  <!-- Container Scrollable dengan Sticky Thead & Sleek Scrollbar -->
                  <div class="modal-resi-table-scrollbox">
                     <table class="table modal-resi-table">
                        <thead>
                           <tr>
                              <th class="th-sticky text-center" style="width:40px;">#</th>
                              <th class="th-sticky" style="width:140px;">FILE / HALAMAN</th>
                              <th class="th-sticky" style="width:150px;">NO. RESI (AWB)</th>
                              <th class="th-sticky" style="width:140px;">NO. PESANAN</th>
                              <th class="th-sticky" style="width:130px;">KURIR</th>
                              <th class="th-sticky" style="width:190px;">PENERIMA &amp; KONTAK</th>
                              <th class="th-sticky" style="min-width:240px;">PRODUK &amp; DETAIL</th>
                              <th class="th-sticky text-center" style="width:150px;">STATUS DATABASE</th>
                           </tr>
                        </thead>
                        <tbody id="tbody_modal_resi_summary">
                           <!-- Baris hasil proses disisipkan di sini -->
                        </tbody>
                     </table>
                  </div>
               </div>

            </div>

         </div>

         <!-- Modal Footer -->
         <div class="modal-footer" style="background:#ffffff; border-top:1px solid #e2e8f0; padding:14px 24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
            <div style="font-size:11.5px; color:#64748b;">
               <i class="fa fa-shield text-success"></i> Data resi yang cocok langsung disimpan otomatis ke tabel Penjualan Marketplace.
            </div>
            <div style="display:flex; gap:8px;">
               <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:10px; font-weight:700; padding:8px 16px; border:1px solid #cbd5e1;">Tutup</button>
               <button type="button" id="btn_modal_resi_reload" class="btn btn-success" onclick="window.location.href='<?= site_url('administrator/penjualan_marketplace'); ?>';" style="border-radius:10px; font-weight:700; background:#16a34a; border-color:#16a34a; padding:8px 18px; display:none; box-shadow:0 4px 12px rgba(22,163,74,0.3);">
                  <i class="fa fa-refresh"></i> Selesai &amp; Tampilkan Data Terbaru di Atas
               </button>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
// Modal Import Resi Engine (Foto & PDF Multi-Halaman)
(function() {
   var anyResiImportedSuccess = false;
   if (typeof pdfjsLib !== 'undefined') {
      try {
         var workerCode = "importScripts('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js');";
         var blob = new Blob([workerCode], { type: 'text/javascript' });
         pdfjsLib.GlobalWorkerOptions.workerSrc = URL.createObjectURL(blob);
      } catch(e) {
         pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
      }
   }

   function playModalBeep(type) {
      try {
         var ctx = new (window.AudioContext || window.webkitAudioContext)();
         var osc = ctx.createOscillator();
         var gain = ctx.createGain();
         osc.connect(gain);
         gain.connect(ctx.destination);
         if (type === 'success') {
            osc.frequency.value = 1046.5;
            gain.gain.setValueAtTime(0.3, ctx.currentTime);
            osc.start();
            osc.stop(ctx.currentTime + 0.15);
         } else if (type === 'warning') {
            osc.frequency.value = 440;
            gain.gain.setValueAtTime(0.35, ctx.currentTime);
            osc.start();
            osc.stop(ctx.currentTime + 0.25);
         } else {
            osc.frequency.value = 220;
            gain.gain.setValueAtTime(0.3, ctx.currentTime);
            osc.start();
            osc.stop(ctx.currentTime + 0.3);
         }
      } catch(e) {}
   }

   $(document).ready(function() {
      var dropzone = $('#modal_resi_dropzone');
      var fileInput = $('#modal_resi_files_input');

      dropzone.on('dragover dragenter', function(e) {
         e.preventDefault();
         e.stopPropagation();
         dropzone.css({ 'border-color': '#0284c7', 'background': '#f0f9ff' });
      });

      dropzone.on('dragleave dragend drop', function(e) {
         e.preventDefault();
         e.stopPropagation();
         dropzone.css({ 'border-color': '#cbd5e1', 'background': '#ffffff' });
      });

      dropzone.on('drop', function(e) {
         var files = e.originalEvent.dataTransfer.files;
         if (files && files.length > 0) {
            startModalBatchProcess(files);
         }
      });

      fileInput.on('change', function(e) {
         var files = e.target.files;
         if (files && files.length > 0) {
            startModalBatchProcess(files);
         }
      });

      dropzone.on('click', function(e) {
         if (!$(e.target).is('#modal_resi_files_input') && !$(e.target).closest('label').length) {
            fileInput.click();
         }
      });

      // Otomatis segarkan halaman dan arahkan ke daftar utama teratas saat modal ditutup jika ada data resi berhasil
      $('#modalImportResiMassal').on('hidden.bs.modal', function() {
         $('#modal_resi_blur_overlay').hide();
         $('#modal_resi_dropzone').removeClass('is-compact');
         if (anyResiImportedSuccess) {
            window.location.href = '<?= site_url("administrator/penjualan_marketplace"); ?>';
         }
      });

      $('#modalImportResiMassal').on('show.bs.modal', function() {
         if ($('#tbody_modal_resi_summary tr').length === 0) {
            $('#modal_resi_dropzone').removeClass('is-compact');
            $('#modal_resi_progress_container').hide();
         }
      });

      // Tombol tutup / minimize overlay kartu tengah untuk melihat tabel hasil di latar belakang
      $(document).on('click', '#btn_blur_close_overlay, #btn_blur_peek_table, #btn_blur_view_table', function(e) {
         e.preventDefault();
         $('#modal_resi_blur_overlay').fadeOut(250, function() {
            var target = $('#modal_resi_progress_container');
            if (target.length) {
               $('#modalImportResiMassal').animate({
                  scrollTop: target.position().top - 15
               }, 350);
               target.css({
                  'box-shadow': '0 0 0 3px rgba(2, 132, 199, 0.45)',
                  'transition': 'box-shadow 0.4s ease'
               });
               setTimeout(function() {
                  target.css('box-shadow', 'none');
               }, 1800);
            }
         });
      });

      // Filter Tabs Interaktif di Atas Tabel Rincian Data Resi
      $(document).on('click', '.btn-resi-filter', function(e) {
         e.preventDefault();
         var filter = $(this).data('filter');
         $('.btn-resi-filter').removeClass('active').css({ 'background': '#f8fafc', 'color': '#475569', 'border-color': '#cbd5e1' });
         if (filter === 'all') {
            $(this).addClass('active').css({ 'background': '#0f172a', 'color': '#ffffff', 'border-color': '#0f172a' });
         } else if (filter === 'success') {
            $(this).addClass('active').css({ 'background': '#16a34a', 'color': '#ffffff', 'border-color': '#16a34a' });
         } else if (filter === 'duplicate') {
            $(this).addClass('active').css({ 'background': '#d97706', 'color': '#ffffff', 'border-color': '#d97706' });
         } else if (filter === 'failed') {
            $(this).addClass('active').css({ 'background': '#dc2626', 'color': '#ffffff', 'border-color': '#dc2626' });
         }

         $('#tbody_modal_resi_summary tr').each(function() {
            var rowType = $(this).attr('data-status-type');
            if (filter === 'all' || rowType === filter) {
               $(this).show();
            } else {
               $(this).hide();
            }
         });
      });
   });

   function startModalBatchProcess(files) {
      var fileList = Array.from(files);
      if (fileList.length === 0) return;

      anyResiImportedSuccess = false;
      $('#modal_resi_dropzone').addClass('is-compact');
      $('#modal_resi_progress_container').slideDown(250);
      $('#tbody_modal_resi_summary').empty();
      $('#btn_modal_resi_reload').hide();

      // Reset Live Preview & Alert Notifikasi
      $('#blur_live_preview_box').hide();
      $('#blur_preview_content').empty();
      $('#blur_duplicate_notice').hide();
      $('#modal_table_duplicate_notice').hide();
      $('#pill_count_all').text(0);
      $('#pill_count_success').text(0);
      $('#pill_count_duplicate').text(0);
      $('#pill_count_failed').text(0);
      $('.btn-resi-filter').removeClass('active').css({ 'background': '#f8fafc', 'color': '#475569', 'border-color': '#cbd5e1' });
      $('.btn-resi-filter[data-filter="all"]').addClass('active').css({ 'background': '#0f172a', 'color': '#ffffff', 'border-color': '#0f172a' });

      var totalFiles = fileList.length;
      $('#modal_stat_total').text(totalFiles);
      $('#modal_stat_success').text(0);
      $('#modal_stat_duplicate').text(0);
      $('#modal_stat_failed').text(0);
      $('#modal_progress_counter').text('0 / ' + totalFiles);
      $('#modal_progress_bar').css('width', '0%').addClass('active progress-bar-striped').css('background', '#0284c7');
      $('#modal_progress_title').html('<i class="fa fa-spinner fa-spin text-primary"></i> Mempersiapkan ' + totalFiles + ' berkas resi...');

      // --- TAMPILKAN CENTERED FROSTED-GLASS BLUR LOADING OVERLAY ---
      $('#modal_resi_blur_overlay').css('display', 'flex').hide().fadeIn(200);
      $('#blur_overlay_title').text('Memproses Import Resi Massal');
      $('#blur_overlay_step').html('<i class="fa fa-spinner fa-spin"></i> Mempersiapkan berkas &amp; dokumen resi...');
      $('#blur_overlay_filename').text(fileList[0] ? fileList[0].name : 'Mempersiapkan antrian...');
      $('#blur_overlay_pct').text('0%');
      $('#blur_overlay_counter').text('(0 / ' + totalFiles + ' Resi)');
      $('#blur_overlay_bar').css({ 'width': '0%', 'background': 'linear-gradient(90deg, #0284c7 0%, #38bdf8 50%, #2563eb 100%)' });
      $('#blur_stat_success').text('0');
      $('#blur_stat_duplicate').text('0');
      $('#blur_stat_failed').text('0');
      $('#blur_completion_actions').hide();

      // Reset Scanner Box ke mode scanning awal
      $('#blur_scanner_box .scanner-laser').show();
      $('#blur_scanner_box .scanner-ring').show();
      $('#blur_scanner_box').css({
         'background': 'linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%)',
         'border-color': '#bae6fd',
         'box-shadow': '0 8px 24px rgba(2,132,199,0.18)'
      });
      $('#blur_scanner_icon').attr('class', 'fa fa-barcode').css({
         'color': '#0284c7',
         'font-size': '36px',
         'animation': 'none'
      });

      var taskQueue = [];
      var prepIndex = 0;

      function prepareTasks() {
         if (prepIndex >= totalFiles) {
            executeTaskQueue(taskQueue);
            return;
         }
         var f = fileList[prepIndex];
         var ext = f.name.split('.').pop().toLowerCase();
         if (ext === 'pdf' && typeof pdfjsLib !== 'undefined') {
            var reader = new FileReader();
            var resolved = false;
            var safetyTimer = setTimeout(function() {
               if (!resolved) {
                  resolved = true;
                  taskQueue.push({ file: f, pageIndex: 0, totalPages: 1, label: f.name, type: 'pdf' });
                  prepIndex++;
                  prepareTasks();
               }
            }, 3500);

            reader.onload = function(e) {
               try {
                  pdfjsLib.getDocument({ data: new Uint8Array(e.target.result) }).promise.then(function(pdf) {
                     if (resolved) return;
                     clearTimeout(safetyTimer);
                     resolved = true;
                     var numPages = pdf.numPages || 1;
                     for (var p = 0; p < numPages; p++) {
                        taskQueue.push({
                            file: f,
                            pdfDoc: pdf,
                            pageIndex: p,
                            totalPages: numPages,
                            label: f.name + (numPages > 1 ? ' [Hal ' + (p + 1) + ']' : ''),
                            type: 'pdf'
                        });
                     }
                     prepIndex++;
                     prepareTasks();
                  }).catch(function() {
                     if (resolved) return;
                     clearTimeout(safetyTimer);
                     resolved = true;
                     taskQueue.push({ file: f, pageIndex: 0, totalPages: 1, label: f.name, type: 'pdf' });
                     prepIndex++;
                     prepareTasks();
                  });
               } catch(err) {
                  if (resolved) return;
                  clearTimeout(safetyTimer);
                  resolved = true;
                  taskQueue.push({ file: f, pageIndex: 0, totalPages: 1, label: f.name, type: 'pdf' });
                  prepIndex++;
                  prepareTasks();
               }
            };
            reader.readAsArrayBuffer(f);
         } else {
            taskQueue.push({ file: f, pageIndex: 0, totalPages: 1, label: f.name, type: (ext === 'pdf' ? 'pdf' : 'image') });
            prepIndex++;
            prepareTasks();
         }
      }

      prepareTasks();
   }

   function executeTaskQueue(queue) {
      var totalTasks = queue.length;
      $('#modal_stat_total').text(totalTasks);
      $('#modal_stat_success').text(0);
      $('#modal_stat_duplicate').text(0);
      $('#modal_stat_failed').text(0);
      $('#modal_table_summary_label').text('0 / ' + totalTasks + ' Selesai');

      $('#blur_overlay_counter').text('(0 / ' + totalTasks + ' Resi)');
      $('#blur_stat_success').text('0');
      $('#blur_stat_duplicate').text('0');
      $('#blur_stat_failed').text('0');

      var taskIdx = 0;
      var successCount = 0;
      var duplicateCount = 0;
      var failedCount = 0;

      function runNextTask() {
         if (taskIdx >= totalTasks) {
            var isAllDuplicate = (duplicateCount > 0 && successCount === 0 && failedCount === 0);
            var isAllFailed = (failedCount > 0 && successCount === 0 && duplicateCount === 0);
            var isMixed = (successCount > 0 && (duplicateCount > 0 || failedCount > 0));
            var isAllSuccess = (successCount > 0 && duplicateCount === 0 && failedCount === 0);

            // Hentikan laser & ring pemindai
            $('#blur_scanner_box .scanner-laser').hide();
            $('#blur_scanner_box .scanner-ring').hide();
            $('#blur_overlay_pct').text('100%');
            $('#blur_overlay_counter').text('(' + totalTasks + ' / ' + totalTasks + ' Selesai)');

            if (isAllDuplicate) {
               // --- KASUS: SEMUA DATA RESI SUDAH ADA DI DATABASE (AMBER / WARNING THEME) ---
               playModalBeep('warning');
               $('#modal_progress_bar').removeClass('active progress-bar-striped').css('background', '#d97706');
               $('#modal_progress_title').html('<i class="fa fa-exclamation-triangle" style="color:#d97706;"></i> <strong>Data Sudah Pernah Terdaftar!</strong> ' + duplicateCount + ' resi ditolak karena sudah ada di database.');
               $('#btn_modal_resi_reload').fadeIn(300).attr('class', 'btn btn-warning').css({ 'background': '#d97706', 'border-color': '#d97706', 'color': '#ffffff' }).html('<i class="fa fa-ban"></i> Selesai (' + duplicateCount + ' Data Ditolak) - Tutup Modal');

               // Blur overlay kartu tengah
               $('#blur_overlay_title').html('<i class="fa fa-exclamation-triangle" style="color:#d97706;"></i> Data Resi Sudah Pernah Terdaftar!');
               $('#blur_overlay_step').css({ 'background': '#fffbeb', 'color': '#b45309', 'border-color': '#fde68a' }).html('<i class="fa fa-ban" style="color:#d97706;"></i> <span><strong>DITOLAK:</strong> ' + duplicateCount + ' Resi Sudah Ada di Database</span>');
               $('#blur_overlay_filename').text('Semua berkas (' + totalTasks + ' resi) terdeteksi duplikat &amp; ditolak');
               $('#blur_overlay_bar').css({ 'width': '100%', 'background': 'linear-gradient(90deg, #f59e0b 0%, #d97706 100%)' });

               $('#blur_scanner_box').css({
                  'background': '#fffbeb',
                  'border-color': '#fde68a',
                  'box-shadow': '0 10px 25px rgba(217,119,6,0.22)'
               });
               $('#blur_scanner_icon').attr('class', 'fa fa-ban').css({
                  'color': '#d97706',
                  'font-size': '34px',
                  'animation': 'resiCheckBounce 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)'
               });

               // Tombol aksi di kartu blur
               $('#btn_blur_reload_page')
                  .attr('class', 'btn btn-warning btn-blur-action')
                  .css({ 'background': '#d97706', 'border-color': '#d97706', 'color': '#ffffff', 'box-shadow': '0 4px 14px rgba(217,119,6,0.35)' })
                  .html('<i class="fa fa-ban"></i> Tutup &amp; Lihat Data Ditolak')
                  .off('click').on('click', function(e) {
                     e.preventDefault();
                     $('#btn_blur_close_overlay').click();
                  });

               // Otomatis aktifkan tab Ditolak di tabel hasil
               $('.btn-resi-filter[data-filter="duplicate"]').click();

            } else if (isAllFailed) {
               // --- KASUS: SEMUA DATA RESI GAGAL (RED / DANGER THEME) ---
               playModalBeep('error');
               $('#modal_progress_bar').removeClass('active progress-bar-striped').css('background', '#dc2626');
               $('#modal_progress_title').html('<i class="fa fa-times-circle text-danger"></i> <strong>Gagal Memproses Resi!</strong> ' + failedCount + ' file gagal dipindai atau format tidak cocok.');
               $('#btn_modal_resi_reload').fadeIn(300).attr('class', 'btn btn-danger').css({ 'background': '#dc2626', 'border-color': '#dc2626', 'color': '#ffffff' }).html('<i class="fa fa-times"></i> Selesai (' + failedCount + ' Gagal) - Tutup Modal');

               $('#blur_overlay_title').html('<i class="fa fa-times-circle text-danger"></i> Gagal Memproses Berkas Resi!');
               $('#blur_overlay_step').css({ 'background': '#fef2f2', 'color': '#dc2626', 'border-color': '#fca5a5' }).html('<i class="fa fa-times-circle" style="color:#dc2626;"></i> <span><strong>GAGAL:</strong> ' + failedCount + ' Resi Gagal Dipindai / Tidak Terbaca</span>');
               $('#blur_overlay_filename').text('Semua berkas (' + totalTasks + ' resi) gagal diekstraksi');
               $('#blur_overlay_bar').css({ 'width': '100%', 'background': 'linear-gradient(90deg, #ef4444 0%, #dc2626 100%)' });

               $('#blur_scanner_box').css({
                  'background': '#fef2f2',
                  'border-color': '#fca5a5',
                  'box-shadow': '0 10px 25px rgba(220,38,38,0.22)'
               });
               $('#blur_scanner_icon').attr('class', 'fa fa-times').css({
                  'color': '#dc2626',
                  'font-size': '34px',
                  'animation': 'resiCheckBounce 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)'
               });

               $('#btn_blur_reload_page')
                  .attr('class', 'btn btn-danger btn-blur-action')
                  .css({ 'background': '#dc2626', 'border-color': '#dc2626', 'color': '#ffffff', 'box-shadow': '0 4px 14px rgba(220,38,38,0.35)' })
                  .html('<i class="fa fa-times-circle"></i> Tutup &amp; Periksa File')
                  .off('click').on('click', function(e) {
                     e.preventDefault();
                     $('#btn_blur_close_overlay').click();
                  });

               $('.btn-resi-filter[data-filter="failed"]').click();

            } else if (isMixed) {
               // --- KASUS: KOMBINASI (BERHASIL + DUPLIKAT/GAGAL - CYAN/BLUE THEME) ---
               playModalBeep('success');
               $('#modal_progress_bar').removeClass('active progress-bar-striped').css('background', '#0284c7');
               var summaryMsg = 'Selesai Sebagian! ' + successCount + ' resi disinkronkan, ' + duplicateCount + ' ditolak (sudah ada)' + (failedCount > 0 ? ', ' + failedCount + ' gagal' : '') + '.';
               $('#modal_progress_title').html('<i class="fa fa-info-circle text-primary"></i> <strong>' + summaryMsg + '</strong>');
               var reloadBtnText = '<i class="fa fa-refresh"></i> Selesai (' + successCount + ' Disinkronkan, ' + duplicateCount + ' Ditolak) - Muat Ulang';
               $('#btn_modal_resi_reload').fadeIn(300).attr('class', 'btn btn-success').css({ 'background': '#16a34a', 'border-color': '#16a34a', 'color': '#ffffff' }).html(reloadBtnText);

               $('#blur_overlay_title').html('<i class="fa fa-info-circle text-primary"></i> Pemrosesan Selesai Sebagian');
               var finishDetails = '<span style="color:#16a34a;"><i class="fa fa-check-circle"></i> ' + successCount + ' Berhasil</span> &bull; <span style="color:#b45309;"><i class="fa fa-ban"></i> ' + duplicateCount + ' Ditolak</span>';
               if (failedCount > 0) finishDetails += ' &bull; <span style="color:#dc2626;"><i class="fa fa-times-circle"></i> ' + failedCount + ' Gagal</span>';
               $('#blur_overlay_step').css({ 'background': '#f0f9ff', 'color': '#0369a1', 'border-color': '#bae6fd' }).html('<span style="font-weight:700;">' + finishDetails + '</span>');
               $('#blur_overlay_filename').text('Semua berkas (' + totalTasks + ' resi) selesai diproses');
               $('#blur_overlay_bar').css({ 'width': '100%', 'background': 'linear-gradient(90deg, #0284c7 0%, #16a34a 100%)' });

               $('#blur_scanner_box').css({
                  'background': '#f0f9ff',
                  'border-color': '#bae6fd',
                  'box-shadow': '0 8px 24px rgba(2,132,199,0.2)'
               });
               $('#blur_scanner_icon').attr('class', 'fa fa-check-circle').css({
                  'color': '#0284c7',
                  'font-size': '34px',
                  'animation': 'resiCheckBounce 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)'
               });

               $('#btn_blur_reload_page')
                  .attr('class', 'btn btn-success btn-blur-action')
                  .css({ 'background': '#16a34a', 'border-color': '#16a34a', 'color': '#ffffff', 'box-shadow': '0 4px 14px rgba(22,163,74,0.35)' })
                  .html('<i class="fa fa-refresh"></i> Tampilkan di Daftar Penjualan')
                  .off('click').on('click', function() {
                     window.location.href = '<?= site_url("administrator/penjualan_marketplace"); ?>';
                  });

               $('.btn-resi-filter[data-filter="all"]').click();

            } else {
               // --- KASUS: SEMUA SUKSES (GREEN / SUCCESS THEME) ---
               playModalBeep('success');
               $('#modal_progress_bar').removeClass('active progress-bar-striped').css('background', '#16a34a');
               $('#modal_progress_title').html('<i class="fa fa-check-circle text-success"></i> <strong>Selesai!</strong> Semua ' + successCount + ' resi berhasil disinkronkan ke database.');
               var reloadBtnText = '<i class="fa fa-refresh"></i> Selesai (' + successCount + ' Disinkronkan) - Muat Ulang Halaman';
               $('#btn_modal_resi_reload').fadeIn(300).attr('class', 'btn btn-success').css({ 'background': '#16a34a', 'border-color': '#16a34a', 'color': '#ffffff' }).html(reloadBtnText);

               $('#blur_overlay_title').html('<i class="fa fa-check-circle text-success"></i> Semua Resi Berhasil Disinkronkan!');
               $('#blur_overlay_step').css({ 'background': '#f0fdf4', 'color': '#15803d', 'border-color': '#bbf7d0' }).html('<i class="fa fa-check-circle" style="color:#16a34a;"></i> <span><strong>SUKSES:</strong> ' + successCount + ' Resi Berhasil Disimpan</span>');
               $('#blur_overlay_filename').text('Semua berkas (' + totalTasks + ' resi) selesai diproses');
               $('#blur_overlay_bar').css({ 'width': '100%', 'background': 'linear-gradient(90deg, #16a34a 0%, #22c55e 100%)' });

               $('#blur_scanner_box').css({
                  'background': '#f0fdf4',
                  'border-color': '#bbf7d0',
                  'box-shadow': '0 8px 24px rgba(22,163,74,0.2)'
               });
               $('#blur_scanner_icon').attr('class', 'fa fa-check').css({
                  'color': '#16a34a',
                  'font-size': '34px',
                  'animation': 'resiCheckBounce 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)'
               });

               $('#btn_blur_reload_page')
                  .attr('class', 'btn btn-success btn-blur-action')
                  .css({ 'background': '#16a34a', 'border-color': '#16a34a', 'color': '#ffffff', 'box-shadow': '0 4px 14px rgba(22,163,74,0.35)' })
                  .html('<i class="fa fa-refresh"></i> Tampilkan di Daftar Penjualan')
                  .off('click').on('click', function() {
                     window.location.href = '<?= site_url("administrator/penjualan_marketplace"); ?>';
                  });

               $('.btn-resi-filter[data-filter="success"]').click();
            }

            // Tampilkan notifikasi jika ada resi yang terduplikasi di atas tabel
            if (duplicateCount > 0) {
               $('#duplicate_count_pill').text(duplicateCount);
               $('#modal_table_duplicate_notice').slideDown(250);
            }

            // Tampilkan tombol aksi di kartu blur tengah secara jelas (solid & kontras tinggi)
            $('#blur_completion_actions').css({ 'display': 'flex', 'opacity': 0 }).animate({ 'opacity': 1 }, 250);
            return;
         }

         var currentTask = queue[taskIdx];
         var startPct = Math.round(((taskIdx) / totalTasks) * 100);
         $('#modal_progress_bar').css('width', startPct + '%');
         $('#modal_progress_counter').text((taskIdx + 1) + ' / ' + totalTasks);
         $('#modal_progress_title').html('<i class="fa fa-spinner fa-spin text-primary"></i> Memproses: <strong>' + currentTask.label + '</strong>...');

         // Update overlay status
         $('#blur_overlay_pct').text(startPct + '%');
         $('#blur_overlay_counter').text('(' + (taskIdx + 1) + ' / ' + totalTasks + ' Resi)');
         $('#blur_overlay_bar').css('width', startPct + '%');
         $('#blur_overlay_filename').text(currentTask.label);
         $('#blur_overlay_step').html('<i class="fa fa-spinner fa-spin"></i> Memindai barcode &amp; mencocokkan data resi...');

         sendModalResiAJAX(currentTask, function(resData) {
            successCount++;
            anyResiImportedSuccess = true;
            $('#modal_stat_success').text(successCount);
            $('#blur_stat_success').text(successCount);
            $('#pill_count_success').text(successCount);

            // Tampilkan Pratinjau Data Langsung di Kartu Tengah
            var pResi = (resData && resData.nomor_resi && resData.nomor_resi !== '-') ? resData.nomor_resi : ((resData && resData.no_pesanan) ? resData.no_pesanan : currentTask.label);
            var pNama = (resData && resData.unmasked_name) ? resData.unmasked_name : '-';
            var pKurir = (resData && resData.opsi_pengiriman) ? resData.opsi_pengiriman : '-';
            var pPhone = (resData && resData.unmasked_phone && resData.unmasked_phone !== '-') ? ' (' + resData.unmasked_phone + ')' : '';
            var pItems = (resData && resData.items && resData.items.length) ? resData.items.map(function(it){ return it.master_product_name + ' (x' + it.qty + ')'; }).join(', ') : '-';

            var previewHtml = '<div style="margin-bottom:3px;"><strong>No. Resi:</strong> <code style="font-weight:800; color:#0284c7; background:#e0f2fe; padding:2px 6px; border-radius:4px;">' + pResi + '</code> &bull; <strong>Kurir:</strong> <span class="badge" style="background:#f1f5f9; color:#475569; font-size:10px;">' + pKurir + '</span></div>' +
                              '<div style="margin-bottom:3px;"><strong>Penerima:</strong> <span style="font-weight:700; color:#0f172a;">' + pNama + '</span>' + pPhone + '</div>' +
                              '<div><strong>Produk:</strong> <span style="color:#0369a1; font-weight:600;">' + pItems + '</span></div>';
            $('#blur_preview_content').html(previewHtml);
            $('#blur_preview_badge').attr('class', 'badge').css({ 'background': '#dcfce7', 'color': '#15803d' }).html('<i class="fa fa-check"></i> Tersimpan');
            $('#blur_live_preview_box').slideDown(200);

            appendModalResultRow(taskIdx + 1, currentTask.label, resData, 'success');
            taskIdx++;
            $('#pill_count_all').text(taskIdx);
            var nextPct = Math.round((taskIdx / totalTasks) * 100);
            $('#blur_overlay_pct').text(nextPct + '%');
            $('#blur_overlay_bar').css('width', nextPct + '%');
            $('#modal_table_summary_label').text(taskIdx + ' / ' + totalTasks + ' Selesai');
            setTimeout(runNextTask, 60);
         }, function(resData, dupMsg) {
            duplicateCount++;
            $('#modal_stat_duplicate').text(duplicateCount);
            $('#blur_stat_duplicate').text(duplicateCount);
            $('#pill_count_duplicate').text(duplicateCount);

            // Tampilkan Pratinjau Data Duplikat di Kartu Tengah
            var pResi = (resData && resData.nomor_resi && resData.nomor_resi !== '-') ? resData.nomor_resi : ((resData && resData.no_pesanan) ? resData.no_pesanan : currentTask.label);
            var pNama = (resData && resData.unmasked_name) ? resData.unmasked_name : '-';
            var pKurir = (resData && resData.opsi_pengiriman) ? resData.opsi_pengiriman : '-';

            var previewHtml = '<div style="margin-bottom:3px;"><strong>No. Resi:</strong> <code style="font-weight:800; color:#b45309; background:#fef3c7; padding:2px 6px; border-radius:4px;">' + pResi + '</code> &bull; <strong>Kurir:</strong> <span class="badge" style="background:#fef3c7; color:#92400e; font-size:10px;">' + pKurir + '</span></div>' +
                              '<div style="margin-bottom:3px;"><strong>Penerima:</strong> <span style="font-weight:700; color:#0f172a;">' + pNama + '</span></div>' +
                              '<div style="color:#b45309; font-weight:700; font-size:11px;"><i class="fa fa-exclamation-triangle"></i> ' + (dupMsg || 'Data nomor resi sudah pernah diinput sebelumnya (Data Sama).') + '</div>';
            $('#blur_preview_content').html(previewHtml);
            $('#blur_preview_badge').attr('class', 'badge').css({ 'background': '#fef3c7', 'color': '#92400e' }).html('<i class="fa fa-ban"></i> Pernah Diinput (Ditolak)');
            $('#blur_live_preview_box').slideDown(200);

            // Notifikasi Peringatan di Kartu Blur
            $('#blur_duplicate_notice').slideDown(200);
            $('#blur_duplicate_notice_msg').html('Nomor resi <code>' + pResi + '</code> sudah pernah diinput sebelumnya di sistem. Data otomatis <b>difilter &amp; ditolak</b>.');

            // SweetAlert Notifikasi jika data sudah pernah diinput!
            if (typeof swal !== 'undefined') {
               swal({
                  title: "Data Sudah Pernah Diinput!",
                  text: dupMsg || ("Nomor resi " + pResi + " sudah terdaftar di sistem. Data otomatis difilter & ditolak agar tidak ganda."),
                  type: "warning",
                  confirmButtonColor: "#f59e0b",
                  confirmButtonText: "Mengerti & Lanjutkan"
               });
            }

            appendModalResultRow(taskIdx + 1, currentTask.label, $.extend({}, resData, { message: dupMsg }), 'duplicate');
            taskIdx++;
            $('#pill_count_all').text(taskIdx);
            var nextPct = Math.round((taskIdx / totalTasks) * 100);
            $('#blur_overlay_pct').text(nextPct + '%');
            $('#blur_overlay_bar').css('width', nextPct + '%');
            $('#modal_table_summary_label').text(taskIdx + ' / ' + totalTasks + ' Selesai');
            setTimeout(runNextTask, 60);
         }, function(errMsg) {
            failedCount++;
            $('#modal_stat_failed').text(failedCount);
            $('#blur_stat_failed').text(failedCount);
            $('#pill_count_failed').text(failedCount);

            appendModalResultRow(taskIdx + 1, currentTask.label, { message: errMsg }, 'failed');
            taskIdx++;
            $('#pill_count_all').text(taskIdx);
            var nextPct = Math.round((taskIdx / totalTasks) * 100);
            $('#blur_overlay_pct').text(nextPct + '%');
            $('#blur_overlay_bar').css('width', nextPct + '%');
            $('#modal_table_summary_label').text(taskIdx + ' / ' + totalTasks + ' Selesai');
            setTimeout(runNextTask, 60);
         }, function(stageText) {
            $('#blur_overlay_step').html('<i class="fa fa-spinner fa-spin"></i> ' + stageText);
         });
      }
      runNextTask();
   }

   // --- THERMAL IMAGE PREPROCESSING ENGINE (Adaptive Otsu Threshold + Noise Reduction) ---
   function preprocessThermalCanvas(srcCanvas) {
      try {
         var pCanvas = document.createElement("canvas");
         pCanvas.width = srcCanvas.width;
         pCanvas.height = srcCanvas.height;
         var ctx = pCanvas.getContext("2d");
         ctx.drawImage(srcCanvas, 0, 0);

         var imgData = ctx.getImageData(0, 0, pCanvas.width, pCanvas.height);
         var d = imgData.data;
         
         // Step 1: Convert to grayscale and collect histogram for Otsu's method
         var grayValues = new Uint8Array(pCanvas.width * pCanvas.height);
         var histogram = new Array(256).fill(0);
         for (var i = 0, j = 0; i < d.length; i += 4, j++) {
            var gray = Math.round(0.299 * d[i] + 0.587 * d[i+1] + 0.114 * d[i+2]);
            grayValues[j] = gray;
            histogram[gray]++;
         }

         // Step 2: Otsu's adaptive threshold calculation
         var totalPixels = grayValues.length;
         var sum = 0;
         for (var t = 0; t < 256; t++) sum += t * histogram[t];
         var sumB = 0, wB = 0, wF = 0;
         var maxVariance = 0, threshold = 128;
         for (var t = 0; t < 256; t++) {
            wB += histogram[t];
            if (wB === 0) continue;
            wF = totalPixels - wB;
            if (wF === 0) break;
            sumB += t * histogram[t];
            var mB = sumB / wB;
            var mF = (sum - sumB) / wF;
            var variance = wB * wF * (mB - mF) * (mB - mF);
            if (variance > maxVariance) {
               maxVariance = variance;
               threshold = t;
            }
         }

         // Step 3: Apply threshold with slight bias toward detecting ink (darken)
         var adjustedThreshold = Math.min(threshold + 15, 220);
         for (var i = 0, j = 0; i < d.length; i += 4, j++) {
            var val = (grayValues[j] < adjustedThreshold) ? 0 : 255;
            d[i] = val;
            d[i+1] = val;
            d[i+2] = val;
         }
         ctx.putImageData(imgData, 0, 0);
         return pCanvas;
      } catch(e) {
         return srcCanvas;
      }
   }

   // --- ENHANCED CONTRAST CANVAS (less aggressive, for barcode scanning) ---
   function enhanceContrastCanvas(srcCanvas) {
      try {
         var pCanvas = document.createElement("canvas");
         pCanvas.width = srcCanvas.width;
         pCanvas.height = srcCanvas.height;
         var ctx = pCanvas.getContext("2d");
         ctx.drawImage(srcCanvas, 0, 0);
         var imgData = ctx.getImageData(0, 0, pCanvas.width, pCanvas.height);
         var d = imgData.data;
         // Find min/max for auto-contrast stretching
         var minG = 255, maxG = 0;
         for (var i = 0; i < d.length; i += 4) {
            var gray = Math.round(0.299 * d[i] + 0.587 * d[i+1] + 0.114 * d[i+2]);
            if (gray < minG) minG = gray;
            if (gray > maxG) maxG = gray;
         }
         var range = maxG - minG;
         if (range < 20) range = 20;
         for (var i = 0; i < d.length; i += 4) {
            var gray = Math.round(0.299 * d[i] + 0.587 * d[i+1] + 0.114 * d[i+2]);
            var stretched = Math.round(((gray - minG) / range) * 255);
            stretched = Math.max(0, Math.min(255, stretched));
            d[i] = stretched;
            d[i+1] = stretched;
            d[i+2] = stretched;
         }
         ctx.putImageData(imgData, 0, 0);
         return pCanvas;
      } catch(e) {
         return srcCanvas;
      }
   }

   // --- MULTI-ENGINE BARCODE SCANNER: Native BarcodeDetector + ZXing Reader + Multi-Scale ---
   function scanBarcodesComprehensive(canvas) {
      return new Promise(function(resolve) {
         var results = [];

         function addBarcode(code) {
            if (code && typeof code === "string") {
               code = code.trim();
               if (code.length >= 6 && results.indexOf(code) === -1) {
                  results.push(code);
               }
            }
         }

         // Step 1: Native Chromium BarcodeDetector (Ultra-Fast)
         var pNative = Promise.resolve([]);
         if ("BarcodeDetector" in window) {
            try {
               var detector = new BarcodeDetector({ formats: ["code_128", "code_39", "qr_code", "ean_13", "itf"] });
               pNative = detector.detect(canvas).catch(function(){ return []; });
            } catch(e) {}
         }

         pNative.then(function(barcodes) {
            if (barcodes && barcodes.length > 0) {
               barcodes.forEach(function(b) {
                  if (b && b.rawValue) addBarcode(b.rawValue);
               });
            }

            // If native detector succeeded, return immediately
            if (results.length > 0) {
               resolve(results);
               return;
            }

            // Step 2: ZXing Library Reader (Universal Cross-Browser Code 128 / Code 39)
            if (typeof ZXing !== "undefined" && ZXing.BrowserMultiFormatReader) {
               try {
                  var zxingReader = new ZXing.BrowserMultiFormatReader();
                  
                  // Try original canvas first
                  zxingReader.decodeFromCanvas(canvas).then(function(zxRes) {
                     if (zxRes && zxRes.getText()) addBarcode(zxRes.getText());
                     if (results.length > 0) {
                        resolve(results);
                     } else {
                        // Step 3: Try enhanced contrast canvas (auto-stretch)
                        var enhCanvas = enhanceContrastCanvas(canvas);
                        zxingReader.decodeFromCanvas(enhCanvas).then(function(enhRes) {
                           if (enhRes && enhRes.getText()) addBarcode(enhRes.getText());
                           if (results.length > 0) {
                              resolve(results);
                           } else {
                              // Step 4: Try Otsu threshold B/W canvas
                              var bwCanvas = preprocessThermalCanvas(canvas);
                              zxingReader.decodeFromCanvas(bwCanvas).then(function(bwRes) {
                                 if (bwRes && bwRes.getText()) addBarcode(bwRes.getText());
                                 if (results.length > 0) {
                                    resolve(results);
                                 } else {
                                    // Step 5: Try upscaled canvas (2x) for small barcodes
                                    try {
                                       var upCanvas = document.createElement("canvas");
                                       upCanvas.width = canvas.width * 2;
                                       upCanvas.height = canvas.height * 2;
                                       var upCtx = upCanvas.getContext("2d");
                                       upCtx.imageSmoothingEnabled = false;
                                       upCtx.drawImage(canvas, 0, 0, upCanvas.width, upCanvas.height);
                                       zxingReader.decodeFromCanvas(upCanvas).then(function(upRes) {
                                          if (upRes && upRes.getText()) addBarcode(upRes.getText());
                                          resolve(results);
                                       }).catch(function() { resolve(results); });
                                    } catch(e5) { resolve(results); }
                                 }
                              }).catch(function() { resolve(results); });
                           }
                        }).catch(function() {
                           // Enhanced contrast failed, try BW
                           var bwCanvas = preprocessThermalCanvas(canvas);
                           zxingReader.decodeFromCanvas(bwCanvas).then(function(bwRes) {
                              if (bwRes && bwRes.getText()) addBarcode(bwRes.getText());
                              resolve(results);
                           }).catch(function() { resolve(results); });
                        });
                     }
                  }).catch(function() {
                     // Original failed, try enhanced contrast + BW
                     try {
                        var enhCanvas = enhanceContrastCanvas(canvas);
                        zxingReader.decodeFromCanvas(enhCanvas).then(function(enhRes) {
                           if (enhRes && enhRes.getText()) addBarcode(enhRes.getText());
                           if (results.length > 0) {
                              resolve(results);
                           } else {
                              var bwCanvas = preprocessThermalCanvas(canvas);
                              zxingReader.decodeFromCanvas(bwCanvas).then(function(bwRes) {
                                 if (bwRes && bwRes.getText()) addBarcode(bwRes.getText());
                                 resolve(results);
                              }).catch(function() { resolve(results); });
                           }
                        }).catch(function() {
                           var bwCanvas = preprocessThermalCanvas(canvas);
                           zxingReader.decodeFromCanvas(bwCanvas).then(function(bwRes) {
                              if (bwRes && bwRes.getText()) addBarcode(bwRes.getText());
                              resolve(results);
                           }).catch(function() { resolve(results); });
                        });
                     } catch(e3) { resolve(results); }
                  });
               } catch(eZ) { resolve(results); }
            } else {
               resolve(results);
            }
         }).catch(function() { resolve(results); });
      });
   }

   // --- MULTI-LINGUAL OCR ENGINE: Tesseract.js (Indonesian + English) ---
   function recognizeTextWithOCR(canvas) {
      return new Promise(function(resolve) {
         if (typeof Tesseract === "undefined") {
            resolve([]);
            return;
         }
         var procCanvas = enhanceContrastCanvas(canvas);
         
         // Prioritize Indonesian + English vocabulary
         Tesseract.recognize(procCanvas, "eng+ind+ara", { langPath: "<?= rtrim(BASE_ASSET, '/'); ?>/tessdata", cacheMethod: "refresh" }).then(function(tResult) {
            var lines = [];
            if (tResult && tResult.data && tResult.data.lines && tResult.data.lines.length > 0) {
               tResult.data.lines.forEach(function(l) {
                  var s = l.text ? l.text.trim() : '';
                  if (s) lines.push({ str: s });
               });
            } else if (tResult && tResult.data && tResult.data.text) {
               tResult.data.text.split(/\r?\n/).forEach(function(l) {
                  if (l.trim()) lines.push({ str: l.trim() });
               });
            }
            if (lines.length === 0) {
               var bwCanvas = preprocessThermalCanvas(canvas);
               Tesseract.recognize(bwCanvas, "eng+ind+ara", { langPath: "<?= rtrim(BASE_ASSET, '/'); ?>/tessdata", cacheMethod: "refresh" }).then(function(tResultBw) {
                  var linesBw = [];
                  if (tResultBw && tResultBw.data && tResultBw.data.text) {
                     tResultBw.data.text.split(/\r?\n/).forEach(function(l) {
                        if (l.trim()) linesBw.push({ str: l.trim() });
                     });
                  }
                  checkHeaderCrop(linesBw);
               }).catch(function() { checkHeaderCrop([]); });
            } else {
               checkHeaderCrop(lines);
            }

            function checkHeaderCrop(currLines) {
               var hasResi = currLines.some(function(l) {
                  return /^(SPX|00\d|SIC|JT|JP|JX|JNT|EZ|JNE|CTC|IDS|IDE|NLID|ANTR|LP|TKP|ID\d{9})/i.test(l.str) ||
                         /(?:No\.?\s*Resi|Resi)\s*[:\/ ]\s*[A-Za-z0-9]/i.test(l.str);
               });

               if (!hasResi) {
                  try {
                     var cropCanvas = document.createElement("canvas");
                     cropCanvas.width = canvas.width;
                     cropCanvas.height = Math.round(canvas.height * 0.35);
                     var cropCtx = cropCanvas.getContext("2d");
                     cropCtx.drawImage(canvas, 0, 0, canvas.width, cropCanvas.height, 0, 0, canvas.width, cropCanvas.height);
                     var procCrop = enhanceContrastCanvas(cropCanvas);
                     
                     Tesseract.recognize(procCrop, "eng").then(function(cropRes) {
                        if (cropRes && cropRes.data && cropRes.data.lines) {
                           cropRes.data.lines.forEach(function(cl) {
                              var cs = cl.text ? cl.text.trim() : '';
                              if (cs) currLines.unshift({ str: cs });
                           });
                        }
                        resolve(currLines);
                     }).catch(function() { resolve(currLines); });
                     return;
                  } catch(eCrop) {}
               }
               resolve(currLines);
            }
         }).catch(function() {
            // Fallback to English dictionary if offline/pack fails
            Tesseract.recognize(procCanvas, "eng").then(function(tResult2) {
               var lines2 = [];
               if (tResult2 && tResult2.data && tResult2.data.text) {
                  tResult2.data.text.split(/\r?\n/).forEach(function(l) {
                     if (l.trim()) lines2.push({ str: l.trim() });
                  });
               }
               resolve(lines2);
            }).catch(function() {
               resolve([]);
            });
         });
      });
   }

   function ocrCodBox(sourceCanvas, box, onDone) {
      if (!box || !sourceCanvas || typeof Tesseract === 'undefined') {
         if (onDone) onDone(null);
         return;
      }
      try {
         var insetXLeft = Math.max(30, Math.round(box.width * 0.08));
         var insetXRight = Math.max(15, Math.round(box.width * 0.04));
         var insetYTop = Math.max(7, Math.round(box.height * 0.16));
         var insetYBot = Math.max(7, Math.round(box.height * 0.16));

         var srcX = Math.max(0, box.x + insetXLeft);
         var srcY = Math.max(0, box.y + insetYTop);
         var srcW = Math.max(10, box.width - insetXLeft - insetXRight);
         var srcH = Math.max(10, box.height - insetYTop - insetYBot);

         var scale = Math.max(2.0, 50.0 / srcH);
         var cropCanvas = document.createElement('canvas');
         var pad = 40;
         cropCanvas.width = Math.round(srcW * scale) + (pad * 2);
         cropCanvas.height = Math.round(srcH * scale) + (pad * 2);

         var cCtx = cropCanvas.getContext('2d');
         cCtx.fillStyle = '#ffffff';
         cCtx.fillRect(0, 0, cropCanvas.width, cropCanvas.height);
         cCtx.imageSmoothingEnabled = true;
         cCtx.imageSmoothingQuality = 'high';
         cCtx.drawImage(sourceCanvas, srcX, srcY, srcW, srcH, pad, pad, Math.round(srcW * scale), Math.round(srcH * scale));

         try {
            var imgData = cCtx.getImageData(0, 0, cropCanvas.width, cropCanvas.height);
            var d = imgData.data;
            for (var i = 0; i < d.length; i += 4) {
               if (d[i+3] < 128) {
                  d[i] = 255; d[i+1] = 255; d[i+2] = 255; d[i+3] = 255;
               } else {
                  var lum = 0.299 * d[i] + 0.587 * d[i+1] + 0.114 * d[i+2];
                  var val = (lum < 140) ? 0 : 255;
                  d[i] = val; d[i+1] = val; d[i+2] = val;
               }
            }
            cCtx.putImageData(imgData, 0, 0);
         } catch(eBin) {}

         var tessPath = '<?= rtrim(BASE_ASSET, "/"); ?>/tessdata';
         Tesseract.recognize(cropCanvas, 'eng', { langPath: tessPath, cacheMethod: 'refresh' }).then(function(result) {
            var fullTxt = (result && result.data && result.data.text) ? result.data.text.trim() : '';
            console.log('[ocrCodBox list] Raw OCR text from COD box:', fullTxt);

            var m = fullTxt.match(/(?:C[O0DP][DDP0]?|C\s*O\s*D)\s*[:\/ ]\s*(?:Rp\.?\s*)?([0-9\., ]+)/i);
            if (m) {
               var cleanNom = m[1].replace(/[^0-9]/g, '');
               if (cleanNom.length >= 4 && cleanNom.length <= 8) {
                  if (onDone) onDone(cleanNom);
                  return;
               }
            }

            var numM = fullTxt.match(/([0-9]{1,3}[\.,][0-9]{3})/);
            if (numM) {
               var cleanNom = numM[1].replace(/[^0-9]/g, '');
               if (cleanNom.length >= 4 && cleanNom.length <= 8) {
                  if (onDone) onDone(cleanNom);
                  return;
               }
            }

            var rawDigits = fullTxt.match(/\b([1-9][0-9]{3,7})\b/);
            if (rawDigits) {
               if (onDone) onDone(rawDigits[1]);
               return;
            }

            if (onDone) onDone(null);
         }).catch(function(eOcr) {
            console.warn('[ocrCodBox list] Tesseract error:', eOcr);
            if (onDone) onDone(null);
         });
      } catch(e) {
         console.warn('[ocrCodBox list] Exception:', e);
         if (onDone) onDone(null);
      }
   }

   // Helper: Load File/Image to Offscreen High-Res Canvas
   function loadImageToCanvas(file) {
      return new Promise(function(resolve, reject) {
         var reader = new FileReader();
         reader.onload = function(e) {
            var img = new Image();
            img.onload = function() {
               // Upscale image if width < 1600px for optimal thermal reading
               var targetWidth = Math.max(img.width, 1600);
               var scale = targetWidth / img.width;
               var canvas = document.createElement("canvas");
               canvas.width = Math.round(img.width * scale);
               canvas.height = Math.round(img.height * scale);
               var ctx = canvas.getContext("2d");
               ctx.imageSmoothingEnabled = true;
               ctx.imageSmoothingQuality = "high";
               ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
               resolve(canvas);
            };
            img.onerror = reject;
            img.src = e.target.result;
         };
         reader.onerror = reject;
         reader.readAsDataURL(file);
      });
   }

   function sendModalResiAJAX(task, onSuccess, onDuplicate, onError, onStage) {
      var formData = new FormData();
      formData.append("nomor_resi", task.label);
      formData.append("page_index", task.pageIndex || 0);
      formData.append("file_pdf", task.file);

      if (onStage) onStage(task.type === 'pdf' ? 'Mengekstrak teks & struktur PDF...' : 'Memuat foto resi...');

      // --- TRIPLE-TIER ENGINE: DIGITAL VECTOR + MULTI-ENGINE BARCODE + IND/ENG OCR ---
      if (task.type === "pdf" && task.pdfDoc) {
         // Tier 1 (PDF): Extract Digital Text + Render High-Res Canvas for Barcode & OCR fallback
         task.pdfDoc.getPage((task.pageIndex || 0) + 1).then(function(page) {
            if (onStage) onStage('Membaca layer teks digital PDF...');
            page.getTextContent().then(function(textContent) {
               var lines = [];
               if (textContent && textContent.items && textContent.items.length > 0) {
                  var validItems = textContent.items.filter(function(it) {
                     return it.str && it.str.trim().length > 0;
                  });
                  // Sort by Y descending (top to bottom)
                  validItems.sort(function(a, b) {
                     var yA = (a.transform && a.transform[5]) ? a.transform[5] : 0;
                     var yB = (b.transform && b.transform[5]) ? b.transform[5] : 0;
                     if (Math.abs(yA - yB) > 3.5) {
                        return yB - yA;
                     }
                     var xA = (a.transform && a.transform[4]) ? a.transform[4] : 0;
                     var xB = (b.transform && b.transform[4]) ? b.transform[4] : 0;
                     return xA - xB;
                  });

                  // Group into visual lines
                  var currentLine = [];
                  var currentY = null;
                  validItems.forEach(function(it) {
                     var itY = (it.transform && it.transform[5]) ? it.transform[5] : 0;
                     if (currentY === null || Math.abs(itY - currentY) <= 3.5) {
                        currentLine.push(it);
                        if (currentY === null) currentY = itY;
                     } else {
                        currentLine.sort(function(a, b) {
                           return ((a.transform && a.transform[4]) ? a.transform[4] : 0) - ((b.transform && b.transform[4]) ? b.transform[4] : 0);
                        });
                        var rowStr = currentLine.map(function(item) { return item.str.trim(); }).join(" ");
                        if (rowStr) lines.push({ str: rowStr });
                        currentLine = [it];
                        currentY = itY;
                     }
                  });
                  if (currentLine.length > 0) {
                     currentLine.sort(function(a, b) {
                        return ((a.transform && a.transform[4]) ? a.transform[4] : 0) - ((b.transform && b.transform[4]) ? b.transform[4] : 0);
                     });
                     var rowStr = currentLine.map(function(item) { return item.str.trim(); }).join(" ");
                     if (rowStr) lines.push({ str: rowStr });
                  }
               }

               // Render high-res canvas (scale 2.2) for barcode decoding
               try {
                  var scale = 2.2;
                  var viewport = page.getViewport({ scale: scale });
                  var canvas = document.createElement("canvas");
                  canvas.width = viewport.width;
                  canvas.height = viewport.height;
                  var ctx = canvas.getContext("2d");

                  page.render({ canvasContext: ctx, viewport: viewport }).promise.then(function() {
                     if (onStage) onStage('Memindai barcode dokumen PDF (ZXing)...');
                     scanBarcodesComprehensive(canvas).then(function(barcodes) {
                        if (barcodes && barcodes.length > 0) {
                           barcodes.forEach(function(code) {
                              lines.unshift({ str: "BARCODE: " + code });
                              lines.push({ str: code });
                           });
                        }

                        // If digital text is sparse (e.g. raster scanned thermal PDF), run OCR
                        var codPromisePdf = Promise.resolve(null);
                        if (typeof Barcode128Decoder !== 'undefined' && Barcode128Decoder.detectCOD) {
                           try {
                              var codResPdf = Barcode128Decoder.detectCOD(canvas);
                              if (codResPdf && codResPdf.is_cod) {
                                 if (codResPdf.cod_nominal > 0) {
                                    lines.push({ str: 'IS_COD: YES' });
                                    lines.push({ str: 'COD : ' + codResPdf.cod_nominal });
                                 } else if (codResPdf.box) {
                                    codPromisePdf = new Promise(function(resCod) {
                                       var timer = setTimeout(function(){ resCod(null); }, 8000);
                                       ocrCodBox(canvas, codResPdf.box, function(num) {
                                          clearTimeout(timer);
                                          if (num) {
                                             var numInt = parseInt(num, 10);
                                             if (!isNaN(numInt) && numInt > 0) {
                                                lines.push({ str: 'IS_COD: YES' });
                                                lines.push({ str: 'COD : ' + numInt });
                                                lines.push({ str: 'COD : ' + numInt.toLocaleString('id-ID') });
                                                lines.push({ str: 'COD: Rp ' + numInt.toLocaleString('id-ID') });
                                             }
                                          }
                                          resCod(num);
                                       });
                                    });
                                 }
                              }
                           } catch(eCodPdf) {}
                        }

                        codPromisePdf.then(function() {
                           if (lines.length < 8) {
                              if (onStage) onStage('Mendeteksi teks dengan OCR Tesseract...');
                              recognizeTextWithOCR(canvas).then(function(ocrLines) {
                                 ocrLines.forEach(function(ol) { lines.push(ol); });
                                 formData.append("extracted_text_items", JSON.stringify(lines));
                                 doPost();
                              });
                           } else {
                              formData.append("extracted_text_items", JSON.stringify(lines));
                              doPost();
                           }
                        });
                     });
                  }).catch(function() {
                     if (lines.length > 0) formData.append("extracted_text_items", JSON.stringify(lines));
                     doPost();
                  });
               } catch(errRender) {
                  if (lines.length > 0) formData.append("extracted_text_items", JSON.stringify(lines));
                  doPost();
               }
            }).catch(function() { doPost(); });
         }).catch(function() { doPost(); });
      } else if (task.type === "image") {
         // Tier 2 (FOTO/GAMBAR): High-Res Canvas + Multi-Engine Barcode (ZXing) + Tesseract OCR (Ind+Eng)
         if (onStage) onStage('Memuat foto resi & penyesuaian kontras...');
         loadImageToCanvas(task.file).then(function(canvas) {
            if (onStage) onStage('Memindai barcode visual foto...');
            scanBarcodesComprehensive(canvas).then(function(barcodes) {
               var lines = [];
               if (barcodes && barcodes.length > 0) {
                  barcodes.forEach(function(code) {
                     lines.push({ str: "BARCODE: " + code });
                     lines.push({ str: code });
                  });
               }

               var codPromise = Promise.resolve(null);
               if (typeof Barcode128Decoder !== 'undefined' && Barcode128Decoder.detectCOD) {
                  try {
                     var codRes = Barcode128Decoder.detectCOD(canvas);
                     if (codRes && codRes.is_cod) {
                        if (codRes.cod_nominal > 0) {
                           lines.push({ str: 'IS_COD: YES' });
                           lines.push({ str: 'COD : ' + codRes.cod_nominal });
                        } else if (codRes.box) {
                           codPromise = new Promise(function(resCod) {
                              var timer = setTimeout(function(){ resCod(null); }, 8000);
                              ocrCodBox(canvas, codRes.box, function(num) {
                                 clearTimeout(timer);
                                 if (num) {
                                    var numInt = parseInt(num, 10);
                                    if (!isNaN(numInt) && numInt > 0) {
                                       lines.push({ str: 'IS_COD: YES' });
                                       lines.push({ str: 'COD : ' + numInt });
                                       lines.push({ str: 'COD : ' + numInt.toLocaleString('id-ID') });
                                       lines.push({ str: 'COD: Rp ' + numInt.toLocaleString('id-ID') });
                                    }
                                 }
                                 resCod(num);
                              });
                           });
                        }
                     }
                  } catch(eCod) {
                     console.warn('detectCOD error:', eCod);
                  }
               }

               codPromise.then(function() {
                  if (onStage) onStage('Mendeteksi teks & alamat dengan Tesseract OCR...');
                  recognizeTextWithOCR(canvas).then(function(ocrLines) {
                     ocrLines.forEach(function(ol) { lines.push(ol); });
                     formData.append("extracted_text_items", JSON.stringify(lines));
                     doPost();
                  }).catch(function() {
                     formData.append("extracted_text_items", JSON.stringify(lines));
                     doPost();
                  });
               });
            });
         }).catch(function() {
            doPost();
         });
      } else {
         doPost();
      }

      function doPost() {
         if (onStage) onStage('Menyimpan & sinkronisasi data resi ke database...');
         $.ajax({
            url: '<?= site_url("administrator/penjualan_marketplace/scan_resi_ajax"); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            timeout: 35000,
            success: function(res) {
               if (res && res.status === 'success') {
                  if (onSuccess) onSuccess(res.data);
               } else if (res && (res.status === 'duplicate' || res.is_duplicate)) {
                  if (onDuplicate) onDuplicate(res.data || {}, res.message || 'Data sama (Ditolak)');
               } else {
                  if (onError) onError(res ? res.message : 'Resi tidak dikenali');
               }
            },
            error: function(xhr, status, error) {
               if (onError) onError('Gagal terhubung ke server');
            }
         });
      }
   }

   function appendModalResultRow(num, fileName, data, statusType) {
      var rowBorder = 'border-left: 4px solid #16a34a; background-color: #ffffff;';
      if (statusType === 'duplicate') {
         rowBorder = 'border-left: 4px solid #f59e0b; background-color: #fffdf5;';
      } else if (statusType === 'failed') {
         rowBorder = 'border-left: 4px solid #ef4444; background-color: #fff8f8;';
      }
      
      var html = '<tr data-status-type="' + statusType + '" style="' + rowBorder + '">';
      html += '<td class="text-center" style="font-weight:700; color:#64748b; font-size:11px;">' + num + '</td>';
      
      var fileIcon = (fileName.indexOf('.pdf') !== -1) ? 'fa-file-pdf-o text-danger' : 'fa-file-image-o text-info';
      html += '<td><div title="' + fileName + '" style="font-weight:600; color:#334155; font-size:11px; max-width:140px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><i class="fa ' + fileIcon + '"></i> ' + fileName + '</div></td>';
      
      if (statusType === 'success' && data) {
         var pesanan = (data && data.no_pesanan) ? data.no_pesanan : '-';
         var resi = (data && data.nomor_resi && data.nomor_resi !== '-') ? data.nomor_resi : (pesanan !== '-' ? pesanan : '-');
         var kurir = data.opsi_pengiriman || '-';
         var penerima = data.unmasked_name || '-';
         var phone = data.unmasked_phone || '-';
         var pengirim = data.unmasked_pengirim || '-';
         var items = data.items || [];
         
         var productDisplay = '-';
         if (items.length > 0) {
            productDisplay = items.map(function(it) {
               var skuHtml = (it.sku && it.sku !== '-') ? '<span class="badge" style="background:#e0f2fe; color:#0369a1; border:1px solid #bae6fd; font-family:monospace; font-weight:700; font-size:9.5px; margin-right:3px;"><i class="fa fa-barcode"></i> ' + it.sku + '</span>' : '';
               var varHtml = (it.variasi && it.variasi !== 'Default' && it.variasi !== '-') ? '<span class="badge" style="background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; font-weight:600; font-size:9.5px; margin-right:3px;"><i class="fa fa-tag"></i> ' + it.variasi + '</span>' : '';
               var catHtml = it.kategori ? '<span class="badge" style="background:' + (it.is_mapped ? '#e0f2fe; color:#0369a1; border:1px solid #bae6fd;' : '#fef3c7; color:#92400e; border:1px solid #fde68a;') + ' font-size:9.5px; margin-right:3px;"><i class="fa fa-folder-open"></i> ' + it.kategori + '</span>' : '';
               var qtyHtml = '<span class="badge" style="background:#dcfce7; color:#15803d; border:1px solid #bbf7d0; font-weight:700; font-size:10px;">Qty: ' + it.qty + '</span>';

               return '<div style="margin-bottom:4px; padding-bottom:4px; border-bottom:1px dashed #e2e8f0; line-height:1.35;">' +
                      '<div style="font-weight:700; color:#1e293b; font-size:11.5px;">' + it.master_product_name + '</div>' +
                      '<div style="margin-top:2px; display:flex; flex-wrap:wrap; gap:3px; align-items:center;">' +
                      skuHtml + varHtml + catHtml + qtyHtml +
                      '</div></div>';
            }).join('');
         }

         var penerimaDisplay = '<div style="font-weight:700; color:#0f172a; font-size:12px;">' + penerima + '</div>';
         if (phone !== '-') {
            penerimaDisplay += '<div style="margin-top:2px;"><small style="color:#16a34a; font-family:monospace; font-weight:700; font-size:11px;"><i class="fa fa-phone"></i> ' + phone + '</small></div>';
         }
         if (pengirim !== '-') {
            penerimaDisplay += '<div style="margin-top:2px;"><span class="badge" style="background:#f8fafc; color:#475569; border:1px solid #cbd5e1; font-size:9.5px; padding:2px 6px;"><i class="fa fa-paper-plane text-info"></i> Pengirim: ' + pengirim + '</span></div>';
         }

         html += '<td><span style="font-family:monospace; font-weight:700; background:#f0f9ff; color:#0284c7; padding:4px 8px; border-radius:6px; border:1px solid #bae6fd; font-size:11.5px; display:inline-block; white-space:nowrap;">' + resi + '</span></td>';
         html += '<td><strong style="font-family:monospace; font-size:11.5px; color:#1e40af; white-space:nowrap;">' + pesanan + '</strong></td>';
         
         var kurirBadge = '<span class="badge" style="background:#f1f5f9; color:#475569; font-weight:700; border:1px solid #cbd5e1; font-size:10.5px;">' + kurir + '</span>';
         if (data && (data.tipe_pengiriman === 'COD' || data.is_cod)) {
            kurirBadge += '<div style="margin-top:3px;"><span class="badge" style="background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; font-weight:700; font-size:9.5px;"><i class="fa fa-money"></i> COD: Rp ' + Number(data.total_price || data.nominal_cod || 0).toLocaleString('id-ID') + '</span></div>';
         } else if (data && Number(data.total_price) > 0) {
            kurirBadge += '<div style="margin-top:3px;"><span class="badge" style="background:#eff6ff; color:#1e40af; border:1px solid #bfdbfe; font-weight:600; font-size:9.5px;"><i class="fa fa-tag"></i> Rp ' + Number(data.total_price).toLocaleString('id-ID') + '</span></div>';
         } else {
            kurirBadge += '<div style="margin-top:3px;"><span class="badge" style="background:#f8fafc; color:#64748b; border:1px solid #e2e8f0; font-weight:600; font-size:9px;"><i class="fa fa-credit-card"></i> Non-COD</span></div>';
         }
         html += '<td>' + kurirBadge + '</td>';
         html += '<td>' + penerimaDisplay + '</td>';
         html += '<td>' + productDisplay + '</td>';
         html += '<td class="text-center"><span class="badge" style="background:#16a34a; color:#fff; font-weight:700; font-size:10.5px; padding:5px 9px; border-radius:6px; box-shadow:0 1px 3px rgba(22,163,74,0.3);"><i class="fa fa-check-circle"></i> Tersimpan</span></td>';
      } else if (statusType === 'duplicate') {
         var pesanan = (data && data.no_pesanan) ? data.no_pesanan : '-';
         var resi = (data && data.nomor_resi && data.nomor_resi !== '-') ? data.nomor_resi : (pesanan !== '-' ? pesanan : '-');
         var kurir = (data && data.opsi_pengiriman) ? data.opsi_pengiriman : '-';
         var penerima = (data && data.unmasked_name) ? data.unmasked_name : '-';
         var dupMsg = (data && data.message) ? data.message : 'Data sudah ada di sistem';

         html += '<td><span style="font-family:monospace; font-weight:700; background:#fef3c7; color:#b45309; padding:4px 8px; border-radius:6px; border:1px solid #fde68a; font-size:11.5px; display:inline-block; white-space:nowrap;"><i class="fa fa-ban"></i> ' + resi + '</span></td>';
         html += '<td><strong style="font-family:monospace; font-size:11.5px; color:#92400e; white-space:nowrap;">' + pesanan + '</strong></td>';
         html += '<td><span class="badge" style="background:#fef3c7; color:#92400e; font-weight:700; border:1px solid #fde68a; font-size:10.5px;">' + kurir + '</span></td>';
         
         var penerimaDup = (penerima !== '-') ? '<div style="font-weight:700; color:#78350f; font-size:12px;">' + penerima + '</div>' : '';
         penerimaDup += '<div style="margin-top:2px;"><span class="badge" style="background:#fde68a; color:#78350f; font-weight:700; font-size:9.5px; padding:2px 6px;"><i class="fa fa-info-circle"></i> ' + dupMsg + '</span></div>';
         html += '<td>' + penerimaDup + '</td>';
         
         html += '<td><div style="color:#b45309; font-size:11px; font-weight:600;"><i class="fa fa-database"></i> Transaksi sudah tercatat di database</div></td>';
         html += '<td class="text-center"><span class="badge" style="background:#d97706; color:#fff; font-weight:700; font-size:10px; padding:5px 8px; border-radius:6px; box-shadow:0 1px 3px rgba(217,119,6,0.3);"><i class="fa fa-ban"></i> Sudah Ada (Ditolak)</span></td>';
      } else {
         var errMsg = (data && data.message) ? data.message : 'Gagal parsing resi';
         html += '<td colspan="5" style="color:#dc2626; font-size:11.5px;"><i class="fa fa-exclamation-circle"></i> ' + errMsg + '</td>';
         html += '<td class="text-center"><span class="badge" style="background:#dc2626; color:#fff; font-weight:700; font-size:10.5px; padding:5px 8px; border-radius:6px;"><i class="fa fa-times-circle"></i> Gagal</span></td>';
      }

      html += '</tr>';
      $('#tbody_modal_resi_summary').prepend(html);
   }
})();
</script>

<script>
$(document).ready(function(){
   $('#check_all').click(function(){
      $('.check_item').prop('checked', this.checked);
   });

   // Loading indicator on import submit
   $('#modalImportMarketplace form').on('submit', function() {
      var $btn = $(this).find('button[type="submit"]');
      $btn.html('<i class="fa fa-spinner fa-spin"></i> Memproses Import...').css('opacity', '0.85');
   });
});

/* Unified File Selection & Modern Preview Handler */
function handleFileSelect(fileInput, previewContainerId, submitBtnId, cardId, channelName) {
   var file = fileInput.files[0];
   if (!file) return;

   var fileSizeKB = Math.round(file.size / 1024);
   var fileSizeStr = fileSizeKB > 1024 ? (file.size / (1024 * 1024)).toFixed(2) + ' MB' : fileSizeKB + ' KB';

   // Show and update selected file card
   if ($('#' + cardId).length) {
      $('#' + cardId).css('display', 'flex');
      $('#' + cardId).find('.selected-file-name').text(file.name);
      $('#' + cardId).find('.selected-file-meta span').text(fileSizeStr);
   }

   // Enable submit button immediately
   $('#' + submitBtnId).prop('disabled', false).removeAttr('disabled').css({
      'opacity': '1',
      'cursor': 'pointer'
   });

   var fileName = file.name.toLowerCase();
   var ext = fileName.split('.').pop();

   if (ext === 'xls' || ext === 'xlsx') {
      var html = '<div style="margin-top:16px; border:1px solid #BBF7D0; border-radius:10px; padding:16px 20px; background:#F0FDF4; box-shadow:0 2px 8px rgba(16, 185, 129, 0.08);">';
      html += '<div style="display:flex; align-items:center; gap:14px;">';
      html += '<i class="fa fa-file-excel-o text-success" style="font-size:36px;"></i>';
      html += '<div>';
      html += '<div style="color:#166534; font-size:14.5px; font-weight:800;"><i class="fa fa-check-circle"></i> File Excel ' + channelName + ' Siap Diimpor: ' + file.name + ' (' + fileSizeStr + ')</div>';
      html += '<div style="font-size:13px; color:#15803D; margin-top:4px; font-weight:500;">Format <strong>.' + ext.toUpperCase() + '</strong> terverifikasi. Klik tombol <strong>"Proses &amp; Import"</strong> di bawah untuk memasukkan pesanan &amp; sinkronisasi otomatis ke CRM.</div>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      $('#' + previewContainerId).html(html);
   } else if (ext === 'csv') {
      previewCSV(fileInput, previewContainerId, submitBtnId, channelName);
   } else {
      $('#' + previewContainerId).html('<div class="alert alert-danger" style="margin-top:15px; border-radius:8px; font-weight:600;"><i class="fa fa-exclamation-triangle"></i> Format file tidak didukung. Harap upload file berekstensi .csv atau .xlsx.</div>');
   }
}

/* CSV Live Review / Preview Function with Auto Delimiter Detection & High Contrast Table */
function previewCSV(fileInput, previewContainerId, submitBtnId, channelName) {
   var file = fileInput.files[0];
   if (!file) return;

   var reader = new FileReader();
   reader.onload = function(e) {
      var text = e.target.result;
      var lines = text.split(/\r\n|\n/);
      if (lines.length <= 1) {
         $('#' + previewContainerId).html('<div class="alert alert-warning" style="margin-top:15px; border-radius:8px; font-weight:600;"><i class="fa fa-exclamation-circle"></i> File CSV kosong atau tidak memiliki baris data.</div>');
         return;
      }

      // Auto-detect delimiter (; or \t or ,)
      var firstLine = lines[0];
      var semiCount = (firstLine.match(/;/g) || []).length;
      var commaCount = (firstLine.match(/,/g) || []).length;
      var tabCount = (firstLine.match(/\t/g) || []).length;
      var delimiter = ',';
      if (semiCount > commaCount && semiCount > tabCount) {
         delimiter = ';';
      } else if (tabCount > commaCount && tabCount > semiCount) {
         delimiter = '\t';
      }

      function parseCSVLine(line, delim) {
         delim = delim || ',';
         var values = [];
         var current = '';
         var inQuotes = false;
         for (var i = 0; i < line.length; i++) {
            var char = line[i];
            if (char === '"') {
               if (inQuotes && i + 1 < line.length && line[i + 1] === '"') {
                  current += '"';
                  i++;
               } else {
                  inQuotes = !inQuotes;
               }
            } else if (char === delim && !inQuotes) {
               values.push(current.trim().replace(/^"|"$/g, ''));
               current = '';
            } else {
               current += char;
            }
         }
         values.push(current.trim().replace(/^"|"$/g, ''));
         return values;
      }

      var header = parseCSVLine(lines[0], delimiter);
      var headerClean = header.map(function(h){ return (h || '').toLowerCase().replace(/[^a-z0-9]/g, ''); });

      // Detect Marketplace Channel from CSV Header
      var isTiktok = headerClean.indexOf('sellersku') !== -1 || headerClean.indexOf('shippingprovidername') !== -1 || headerClean.indexOf('orderamount') !== -1 || headerClean.indexOf('buyermessage') !== -1;
      var isShopee = headerClean.indexOf('opsipengiriman') !== -1 || headerClean.indexOf('nomorreferensisku') !== -1 || headerClean.indexOf('antarkecounterpickup') !== -1 || headerClean.indexOf('hargasetelahdiskon') !== -1 || headerClean.indexOf('diskondarishopee') !== -1;
      var isTokopedia = (headerClean.indexOf('kurir') !== -1 && !isShopee && !isTiktok) || headerClean.indexOf('nomorinvoice') !== -1 || headerClean.indexOf('noinvoice') !== -1 || (headerClean.indexOf('hargasatuan') !== -1 && headerClean.indexOf('catatanpembeli') !== -1 && !isShopee);

      var detectedChannel = isTiktok ? 'TikTok Shop' : (isShopee ? 'Shopee' : (isTokopedia ? 'Tokopedia' : ''));

      if (detectedChannel && detectedChannel !== channelName) {
         var errHtml = '<div class="alert alert-danger" style="margin-top:16px; border-radius:10px; padding:16px 20px; box-shadow:0 2px 10px rgba(239, 68, 68, 0.2); font-size:13px; line-height:1.6; background:#FEF2F2; border:1px solid #F87171; color:#991B1B;">';
         errHtml += '<div style="font-weight:800; font-size:14.5px; margin-bottom:6px;"><i class="fa fa-ban text-danger"></i> Format File Salah: Terdeteksi Template ' + detectedChannel + '!</div>';
         errHtml += 'Anda saat ini membuka tab <strong>' + channelName + '</strong>, tetapi file yang Anda pilih adalah format/template dari <strong>' + detectedChannel + '</strong>.<br>';
         errHtml += 'Silakan klik tab <strong>' + detectedChannel + '</strong> di atas untuk mengimpor file ini, atau ganti dengan file template <strong>' + channelName + '</strong>.';
         errHtml += '</div>';
         $('#' + previewContainerId).html(errHtml);
         $('#' + submitBtnId).prop('disabled', true).attr('disabled', 'disabled').css({'opacity': '0.45', 'cursor': 'not-allowed'});
         return;
      }

      function findColIdx(names, fallbackIdx) {
         for (var k = 0; k < names.length; k++) {
            var target = names[k].toLowerCase().replace(/[^a-z0-9]/g, '');
            var idx = headerClean.indexOf(target);
            if (idx !== -1) return idx;
         }
         return fallbackIdx;
      }

      var idxPesanan = findColIdx(['nopesanan', 'nomorpesanan', 'orderid', 'idpesanan', 'noorder', 'nomororder'], 0);
      var idxResi    = findColIdx(['noresi', 'nomorresi', 'trackingid', 'resi', 'idpelacakan'], (channelName === 'Shopee' ? 4 : (channelName === 'TikTok Shop' ? 33 : 2)));
      var idxNama    = findColIdx(['namapenerima', 'recipient', 'penerima', 'usernamepembeli', 'username', 'buyerusername', 'namapembeli'], (channelName === 'Shopee' ? 39 : (channelName === 'TikTok Shop' ? 38 : 14)));
      var idxTotal   = findColIdx(['totalpembayaran', 'orderamount', 'totaltagihan', 'totalhargaproduk', 'total', 'hargatotal'], (channelName === 'Shopee' ? 34 : (channelName === 'TikTok Shop' ? 21 : 11)));

      var rows = [];
      for (var i = 1; i < lines.length; i++) {
         if (lines[i].trim() !== '') {
            var parsed = parseCSVLine(lines[i], delimiter);
            if (parsed.length >= 2) {
               rows.push(parsed);
            }
         }
      }

      if (rows.length === 0) {
         $('#' + previewContainerId).html('<div style="margin-top:15px; border:1px solid #BAE6FD; border-radius:10px; padding:15px; background:#F0F9FF; color:#0369A1; font-weight:600;"><i class="fa fa-info-circle"></i> File CSV terpilih: ' + file.name + '. Siap diproses oleh sistem. Klik tombol di bawah untuk import.</div>');
         return;
      }


      if (rows.length === 0) {
         $('#' + previewContainerId).html('<div class="alert alert-info" style="margin-top:15px; border-radius:6px;"><i class="fa fa-info-circle"></i> File CSV terpilih: ' + file.name + ' (' + Math.round(file.size/1024) + ' KB). Format siap diproses oleh sistem. Klik tombol di bawah untuk import.</div>');
         $('#' + submitBtnId).prop('disabled', false);
         return;
      }

      var html = '<div style="margin-top:15px; border:1px solid #e2e8f0; border-radius:8px; padding:15px; background:#f8fafc;">';
      html += '<div style="margin-bottom:10px; display:flex; justify-content:space-between; align-items:center;">';
      html += '<strong style="color:#0f172a; font-size:13px;"><i class="fa fa-table text-primary"></i> Review Pratinjau CSV (' + rows.length + ' Total Baris Pesanan ' + channelName + ')</strong>';
      html += '<span class="badge" style="background:#0284c7; font-size:11px; padding:4px 8px;">Pratinjau ' + Math.min(8, rows.length) + ' Baris Pertama</span>';
      html += '</div>';

      html += '<div class="table-responsive" style="max-height:220px; overflow-y:auto; border:1px solid #cbd5e1; border-radius:6px;">';
      html += '<table class="table table-bordered table-striped table-hover" style="font-size:11.5px; background:#fff; margin-bottom:0;">';
      html += '<thead><tr style="background:#0f172a; color:#fff;"><th>#</th><th>NO PESANAN</th><th>NO RESI</th><th>NAMA PENERIMA / PEMBELI</th><th>TOTAL PEMBAYARAN</th></tr></thead>';
      html += '<tbody>';

      var limit = Math.min(8, rows.length);
      for (var j = 0; j < limit; j++) {
         var r = rows[j];
         var no_pesanan = r[idxPesanan] || r[0] || '-';
         var no_resi = r[idxResi] || '-';
         var penerima = r[idxNama] || '-';
         var total = r[idxTotal] || '-';

         html += '<tr>';
         html += '<td>' + (j + 1) + '</td>';
         html += '<td><strong style="font-family:monospace; color:#0f172a;">' + no_pesanan + '</strong></td>';
         html += '<td><span style="font-family:monospace; color:#0284c7; font-weight:bold;">' + no_resi + '</span></td>';
         html += '<td><strong>' + penerima + '</strong></td>';
         html += '<td><strong class="text-success">Rp ' + total + '</strong></td>';
         html += '</tr>';
      }

      html += '</tbody></table></div>';
      html += '<div style="margin-top:10px; font-size:11.5px; color:#15803d; font-weight:700;"><i class="fa fa-check-circle"></i> File CSV Berhasil Dibaca! Silakan klik tombol "Proses &amp; Import" di bawah untuk memasukkan ke database.</div>';
      html += '</div>';

      $('#' + previewContainerId).html(html);
      $('#' + submitBtnId).prop('disabled', false);
   };
   reader.readAsText(file);
}

   // Keterangan BC Interactive Click Handler
   $(document).on('click', '.btn-bc-pill, .badge-bc-pill', function(e) {
      e.preventDefault();
      var btn = $(this);
      var group = btn.closest('.btn-group-keterangan-bc');
      var orderId = group.attr('data-order-id');
      var val = btn.attr('data-val');
      var isCurrentlyActive = btn.hasClass('active');
      var diffH = parseInt(group.attr('data-diff-h') || '0', 10);
      var highestDue = parseInt(group.attr('data-highest-due') || '0', 10);
      var rawH = btn.attr('data-h');
      var hVal = (rawH !== '' && rawH !== undefined) ? parseInt(rawH, 10) : null;

      var targetVal = isCurrentlyActive ? '' : val;

      // Pre-open blank tab synchronously in user click event to prevent popup blocker
      var chatTab = null;
      if (targetVal !== '') {
         try {
            chatTab = window.open('about:blank', '_blank');
         } catch(err) {
            chatTab = null;
         }
      }

      btn.css('opacity', '0.5');

      $.ajax({
         url: '<?= site_url("administrator/penjualan_marketplace/update_keterangan_bc_ajax"); ?>',
         type: 'POST',
         dataType: 'json',
         data: {
            id: orderId,
            keterangan_bc: targetVal
         },
         success: function(res) {
            btn.css('opacity', '1');
            if (res && res.success) {
               var ketBadge = $('#badge-ket-so-' + orderId);

               if (res.keterangan_bc) {
                  // Direct tab to WhatsApp if available
                  if (res.wa_url) {
                     if (chatTab && !chatTab.closed) {
                        chatTab.location.href = res.wa_url;
                     } else {
                        window.open(res.wa_url, '_blank');
                     }
                  }

                  group.find('.badge-bc-pill, .btn-bc-pill').each(function() {
                     var other = $(this);
                     var otherRawH = other.attr('data-h');
                     var otherH = (otherRawH !== '' && otherRawH !== undefined) ? parseInt(otherRawH, 10) : null;
                     other.removeClass('active');
                     other.find('i.fa-check').remove();
                     if (otherH !== null && diffH >= otherH) {
                        other.addClass('btn-bc-overdue');
                     }
                  });

                  btn.removeClass('btn-bc-overdue').addClass('active');
                  if (btn.find('i.fa-check').length === 0) {
                     btn.prepend('<i class="fa fa-check" style="margin-right:2px;"></i> ');
                  }
                  btn.attr('title', 'Sudah Di-Follow Up: ' + res.keterangan_bc + ' (Klik untuk batalkan)');

                  // Update KETERANGAN badge
                  if (ketBadge.length) {
                     if (hVal !== null && hVal >= highestDue) {
                        ketBadge.removeClass('badge-keterangan-red badge-keterangan-orange').addClass('badge-keterangan-green');
                        ketBadge.find('i').attr('class', 'fa fa-check');
                        ketBadge.attr('title', 'Sudah Di-Follow Up: ' + res.keterangan_bc + ' (Klik untuk tandai Follow-Up)');
                     }
                  }

                  if (typeof toastr !== 'undefined') {
                     var notifHtml = '<div style="font-size:12.5px; line-height:1.4;">' +
                        '<strong><i class="fa fa-check-circle"></i> ' + res.message + '</strong><br>' +
                        '<div style="margin-top:8px; display:flex; gap:6px; flex-wrap:wrap;">';
                     if (res.wa_url) {
                        notifHtml += '<a href="' + res.wa_url + '" target="_blank" class="btn btn-xs btn-success" style="background:#25d366; border-color:#25d366; color:#fff; font-weight:700; padding:3px 8px; border-radius:4px;"><i class="fa fa-whatsapp"></i> Chat WhatsApp</a>';
                     }
                     if (res.crm_url) {
                        notifHtml += '<a href="' + res.crm_url + '" target="_blank" class="btn btn-xs btn-default" style="background:#ffffff; color:#0f172a; font-weight:600; padding:3px 8px; border-radius:4px;"><i class="fa fa-tasks text-warning"></i> Journal CRM</a>';
                     }
                     notifHtml += '</div></div>';
                     toastr.success(notifHtml, '', {
                        timeOut: 8000,
                        closeButton: true,
                        progressBar: true,
                        escapeHtml: false
                     });
                  }
               } else {
                  // Untoggled / reset
                  if (chatTab && !chatTab.closed) {
                     chatTab.close();
                  }

                  btn.removeClass('active');
                  btn.find('i.fa-check').remove();
                  if (hVal !== null && diffH >= hVal) {
                     btn.addClass('btn-bc-overdue');
                  }
                  btn.attr('title', val + ' - Klik untuk tandai selesai');

                  // Update KETERANGAN badge back to red/orange
                  if (ketBadge.length) {
                     if (diffH > 0) {
                        ketBadge.removeClass('badge-keterangan-green badge-keterangan-orange').addClass('badge-keterangan-red');
                        ketBadge.find('i').attr('class', 'fa fa-exclamation-triangle');
                        ketBadge.attr('title', 'Terlewat: Belum Follow-Up H+' + highestDue + ' (Umur Pesanan H+' + diffH + ') (Klik untuk tandai Follow-Up)');
                     } else {
                        ketBadge.removeClass('badge-keterangan-green badge-keterangan-red').addClass('badge-keterangan-orange');
                        ketBadge.find('i').attr('class', 'fa fa-clock-o');
                        ketBadge.attr('title', 'Jadwal Hari Ini (Klik untuk tandai Follow-Up)');
                     }
                  }

                  if (typeof toastr !== 'undefined') {
                     toastr.info('Follow-up dibatalkan');
                  }
               }
            } else {
               if (chatTab && !chatTab.closed) chatTab.close();
               alert(res.message || 'Gagal memperbarui follow-up');
            }
         },
         error: function() {
            if (chatTab && !chatTab.closed) chatTab.close();
            btn.css('opacity', '1');
            alert('Gagal menghubungi server untuk memperbarui status follow-up.');
         }
      });
   });

   // Allow clicking the KETERANGAN badge (e.g. H+2) to trigger the due milestone pill
   $(document).on('click', '[id^="badge-ket-so-"]', function(e) {
      e.preventDefault();
      var badge = $(this);
      var row = badge.closest('tr');
      var group = row.find('.btn-group-keterangan-bc');
      var overduePill = group.find('.btn-bc-overdue').last();
      if (overduePill.length) {
         overduePill.trigger('click');
      } else {
         var activePill = group.find('.badge-bc-pill.active');
         if (activePill.length) {
            activePill.trigger('click');
         } else {
            var firstPill = group.find('.badge-bc-pill').first();
            if (firstPill.length) firstPill.trigger('click');
         }
      }
   });

   // Handler Konfirmasi Hapus Data Pesanan Marketplace (Cascading Multi-Product)
   $(document).on('click', '.remove-data', function(e){
      e.preventDefault();
      var url = $(this).attr('data-href');
      var noPesanan = $(this).attr('data-nopesanan') || '';
      var qty = $(this).attr('data-qty') || '1';

      var descText = "Data pesanan ini beserta seluruh produk (" + qty + " item) di dalamnya, transaksi sinkronisasi penjualan, dan riwayat CRM akan dihapus secara menyeluruh!";
      if (noPesanan) {
         descText = "Pesanan #" + noPesanan + " ini berisi " + qty + " produk. Seluruh produk pada pesanan ini serta data transaksi sinkronisasinya akan dihapus permanen!";
      }

      swal({
         title: "Apakah Anda Yakin?",
         text: descText,
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Ya, Hapus Semua!",
         cancelButtonText: "Batal",
         closeOnConfirm: true,
         closeOnCancel: true
      },
      function(isConfirm){
         if (isConfirm) {
            document.location.href = url;            
         }
      });
      return false;
   });

   // Privacy Masking Toggle for Nama Penerima
   var allNamesRevealed = false;
   window.togglePrivacyPenerima = function(id) {
      var el = $('#penerima_name_' + id);
      var icon = $('#penerima_icon_' + id);
      if (!el.length) return;
      var isMasked = el.attr('data-state') !== 'raw';
      if (isMasked) {
         el.text(el.attr('data-raw')).attr('data-state', 'raw').css('color', '#0284c7');
         if (icon.length) icon.removeClass('fa-eye-slash').addClass('fa-eye').css('color', '#0284c7');
      } else {
         el.text(el.attr('data-masked')).attr('data-state', 'masked').css('color', '#0f172a');
         if (icon.length) icon.removeClass('fa-eye').addClass('fa-eye-slash').css('color', '#94a3b8');
      }
   };

   window.toggleAllPrivacyNames = function() {
      allNamesRevealed = !allNamesRevealed;
      var btn = $('#btn_toggle_all_penerima');
      $('.privacy-name-text').each(function() {
         var el = $(this);
         var id = el.attr('id').replace('penerima_name_', '');
         var icon = $('#penerima_icon_' + id);
         if (allNamesRevealed) {
            el.text(el.attr('data-raw')).attr('data-state', 'raw').css('color', '#0284c7');
            if (icon.length) icon.removeClass('fa-eye-slash').addClass('fa-eye').css('color', '#0284c7');
         } else {
            el.text(el.attr('data-masked')).attr('data-state', 'masked').css('color', '#0f172a');
            if (icon.length) icon.removeClass('fa-eye').addClass('fa-eye-slash').css('color', '#94a3b8');
         }
      });
      if (allNamesRevealed) {
         btn.html('<i class="fa fa-eye-slash"></i> Sensor').attr('title', 'Sensor Semua Nama Penerima');
      } else {
         btn.html('<i class="fa fa-eye"></i> Buka').attr('title', 'Buka Semua Nama Penerima');
      }
   };
</script>

