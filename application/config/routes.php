<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Init section


$route_path = APPPATH . 'routes/';
// require_once $route_path . 'routes_landing.php';


$route['default_controller'] = 'web';
$route['landing'] = 'web/landing';
$route['beranda'] = 'web/landing';
$route['404_override'] = 'not_found';
$route['translate_uri_dashes'] = FALSE;

// Administrator Routes
$route['administrator'] = 'dashboard/backend/dashboard';
$route['administrator/login'] = 'auth/backend/auth/login';
$route['administrator/register'] = 'auth/backend/auth/register';
$route['administrator/forgot-password'] = 'auth/backend/auth/forgot_password';

$route['page/chart/pie_chart'] = 'page/chart/pie_chart';
$route['page/(:any)'] = 'page/detail/$1';
$route['blog/index'] = 'blog/index';
$route['blog/(:any)'] = 'blog/detail/$1';
$route['administrator/web-page'] = 'page/backend/page/admin';


$route[ADMIN_NAMESPACE_URL.'/manage-form/(:any)'] = 'form/backend/$1';
$route[ADMIN_NAMESPACE_URL.'/manage-form/(:any)/(:any)'] = 'form/backend/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/manage-form/(:any)/(:any)/(:any)'] = 'form/backend/$1/$2/$3';
// Custom Routes for CRM Segments Module (Product RFM Matrix)
$route[ADMIN_NAMESPACE_URL.'/crm_segments'] = 'crm_segments/backend/crm_segments/product_rfm';
$route[ADMIN_NAMESPACE_URL.'/crm_segments/product_rfm'] = 'crm_segments/backend/crm_segments/product_rfm';
$route[ADMIN_NAMESPACE_URL.'/crm_segments/product_rfm_drilldown_ajax'] = 'crm_segments/backend/crm_segments/product_rfm_drilldown_ajax';
$route[ADMIN_NAMESPACE_URL.'/crm_segments/(:any)'] = 'crm_segments/backend/crm_segments/$1';
$route[ADMIN_NAMESPACE_URL.'/utang_usaha'] = 'utang_usaha/backend/utang_usaha';
$route[ADMIN_NAMESPACE_URL.'/utang_usaha/(:any)'] = 'utang_usaha/backend/utang_usaha/$1';
$route[ADMIN_NAMESPACE_URL.'/utang_usaha/(:any)/(:any)'] = 'utang_usaha/backend/utang_usaha/$1/$2';

$route[ADMIN_NAMESPACE_URL.'/pembayaran_utang'] = 'utang_usaha/backend/utang_usaha/kas_keluar';
$route[ADMIN_NAMESPACE_URL.'/pembayaran_utang/(:any)'] = 'utang_usaha/backend/utang_usaha/kas_keluar/$1';

$route[ADMIN_NAMESPACE_URL.'/(:any)'] = '$1/backend/$1';
$route[ADMIN_NAMESPACE_URL.'/(:any)/(:any)'] = '$1/backend/$1/$2';
$route[ADMIN_NAMESPACE_URL.'/(:any)/(:any)/(:any)'] = '$1/backend/$1/$2/$3';
$route[ADMIN_NAMESPACE_URL.'/(:any)/(:any)/(:any)/(:any)'] = '$1/backend/$1/$2/$3/$3';




$route['api/user/(:any)'] = 'api/user/$1';
$route[ADMIN_NAMESPACE_URL.'/tb_marketplace_orders'] = 'penjualan_marketplace/backend/penjualan_marketplace';
$route[ADMIN_NAMESPACE_URL.'/tb_marketplace_orders/(:any)'] = 'penjualan_marketplace/backend/penjualan_marketplace/$1';
$route[ADMIN_NAMESPACE_URL.'/tb_marketplace_orders/(:any)/(:any)'] = 'penjualan_marketplace/backend/penjualan_marketplace/$1/$2';

$route[ADMIN_NAMESPACE_URL.'/tb_receivables'] = 'piutang_usaha/backend/piutang_usaha';
$route[ADMIN_NAMESPACE_URL.'/tb_receivables/(:any)'] = 'piutang_usaha/backend/piutang_usaha/$1';

$route[ADMIN_NAMESPACE_URL.'/tb_receivable_payments'] = 'piutang_usaha/backend/piutang_usaha/kas_masuk';
$route[ADMIN_NAMESPACE_URL.'/tb_receivable_payments/(:any)'] = 'piutang_usaha/backend/piutang_usaha/kas_masuk/$1';

$route[ADMIN_NAMESPACE_URL.'/pembayaran_piutang'] = 'piutang_usaha/backend/piutang_usaha/kas_masuk';
$route[ADMIN_NAMESPACE_URL.'/pembayaran_piutang/(:any)'] = 'piutang_usaha/backend/piutang_usaha/kas_masuk/$1';

$route['api/(:any)'] = '$1/api/$1';
$route['api/(:any)/(:any)'] = '$1/api/$1/$2';
$route['api/(:any)/(:any)/(:any)'] = '$1/api/$1/$2/$3';
$route['api/(:any)/(:any)/(:any)/(:any)'] = '$1/api/$1/$2/$3/$3';



