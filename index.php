<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!session_id()) {
    session_start();
}

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

date_default_timezone_set('Asia/Jakarta');

// Gunakan FCPATH untuk memastikan path relatif di-resolve dengan benar
require_once FCPATH . 'app/init.php';

$app = new App();