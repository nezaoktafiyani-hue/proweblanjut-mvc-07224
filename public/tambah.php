<?php
// =============================================================
// public/tambah.php — Front Controller: Tambah Barang
// =============================================================
session_start();
require_once '../config/database.php';
require_once '../app/controllers/BarangController.php';

$controller = new BarangController($pdo, dirname(__DIR__));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->store();
} else {
    $controller->create();
}
