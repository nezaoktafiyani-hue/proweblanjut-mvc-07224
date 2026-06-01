<?php
// ============================================================
// api/read.php — GET: Ambil semua data barang
// Menggunakan Model Barang dari arsitektur MVC
// ============================================================
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
require_once '../app/models/Barang.php';

try {
    $model = new Barang($pdo);
    $data  = $model->getAll();

    echo json_encode($data);

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "Gagal mengambil data: " . $e->getMessage()
    ]);
}
?>
