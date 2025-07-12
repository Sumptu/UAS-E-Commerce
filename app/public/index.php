<?php
// Load konfigurasi
require_once '../config/config.php';
require_once '../config/init.php';

// Jalankan router
$router = new Router();
$router->run(); 