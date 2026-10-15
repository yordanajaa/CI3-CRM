<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

// Auto detect database credentials (Localhost vs Hostinger)
$raw_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost');
$server_name = explode(':', $raw_host)[0];
$local_hosts = array('localhost', '127.0.0.1', 'ci3_metafora.test', 'host.docker.internal');
$is_local = in_array($server_name, $local_hosts) 
    || (substr($server_name, -5) === '.test') 
    || (substr($server_name, -6) === '.local')
    || preg_match('/^(192\.168\.|10\.|172\.(1[6-9]|2[0-9]|3[0-1])\.)/', $server_name);

$is_online = !$is_local;

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

