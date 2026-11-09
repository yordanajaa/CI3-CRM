<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Global Application Constants
 */

// Debug Backtrace
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

// File and Directory Modes
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

// File Stream Modes
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb');
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b');
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

// Exit Status Codes
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0);
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1);
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3);
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4);
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5);
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6);
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7);
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8);
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9);
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125);

// Base URLs & App Paths
$is_https = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
$http = $is_https ? 'https://' : 'http://';
$port = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80' && $_SERVER['SERVER_PORT'] != '443') ? ':' . $_SERVER['SERVER_PORT'] : '';
$host = isset($_SERVER['HTTP_HOST']) ? explode(':', $_SERVER['HTTP_HOST'])[0] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost');
$fo = str_replace("index.php", "", isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '');
$base = rtrim($http . $host . $port . $fo, '/') . '/';

defined('BASE_URL')             OR define('BASE_URL', $base);
defined('BASE_ASSET')           OR define('BASE_ASSET', BASE_URL . 'asset/');
defined('VERSION')              OR define('VERSION', '3.0.6');
defined('EXTENSION_PATH')       OR define('EXTENSION_PATH', FCPATH . 'cc-content/extensions/'); 
defined('ADMIN_NAMESPACE_URL')  OR define('ADMIN_NAMESPACE_URL', 'administrator'); 
