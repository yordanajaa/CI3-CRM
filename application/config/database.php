<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

// Auto detect database credentials (Localhost vs Hostinger)
$is_online = isset($_SERVER['HTTP_HOST']) && !in_array($_SERVER['HTTP_HOST'], array('localhost', '127.0.0.1', 'ci3_metafora.test'));

if ($is_online) {
    // Pengaturan Database Hostinger (Sesuaikan dengan data MySQL cPanel Hostinger)
    $hostname = 'localhost';
    $username = 'u103077770_metafora';  // Ganti dengan Username Database Hostinger
    $password = 'PasswordHostingerAnda'; // Ganti dengan Password Database Hostinger
    $database = 'u103077770_metafora';  // Ganti dengan Nama Database Hostinger
} else {
    // Pengaturan Database Localhost (Laragon / XAMPP)
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'metafora';
}

$db['default'] = array(
	'dsn'	   => '',
	'hostname' => $hostname,
	'username' => $username,
	'password' => $password,
	'database' => $database,
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8mb4',
	'dbcollat' => 'utf8mb4_unicode_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

