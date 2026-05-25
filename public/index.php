<?php
// =============================================================
// public/index.php — Front Controller: Daftar Barang
// =============================================================
session_start();
require_once '../config/database.php';
require_once '../app/controllers/BarangController.php';

$controller = new BarangController($pdo, dirname(__DIR__));
$controller->index();
