<?php
// =============================================================
// public/hapus.php — Front Controller: Hapus Barang
// =============================================================
session_start();
require_once '../config/database.php';
require_once '../app/controllers/BarangController.php';

$controller = new BarangController($pdo, dirname(__DIR__));
$controller->delete();
