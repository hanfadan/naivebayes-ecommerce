<?php

$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http');
$base_url .= '://'.$_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

define('BASEURL', $base_url);

define('DB_HOST', 'localhost');
define('DB_NAME', 'pro_naive_bayes');
define('DB_PASSWORD', '');
define('DB_USERNAME', 'root');

define('APP_NAME', 'Nama Toko Online');
define('APP_INFO', 'Isi keterangan toko disini');
define('APP_EMAIL', 'info@t-shop.com');
define('APP_PHONE', '0812345678');
define('APP_ADDRESS', 'Blok B7/P, Jl. Cendrawasih Raya Bintaro Jaya, Sawah Baru, Kec. Ciputat, Kota Tangerang Selatan, Banten 15413');
define('APP_WHATSAPP', '62812345678');