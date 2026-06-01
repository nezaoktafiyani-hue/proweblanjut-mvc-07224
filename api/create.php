<?php
// ============================================================
// api/create.php — POST: Tambah data barang baru
// Menggunakan Model Barang dari arsitektur MVC
// ============================================================
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
require_once '../app/models/Barang.php';

// Ambil data JSON dari body request (Postman → raw → JSON)
$input = json_decode(file_get_contents("php://input"), true);

// Validasi field wajib
if (
    empty($input['nama_barang']) ||
    !isset($input['jumlah'])     ||
    !isset($input['harga'])
) {
    echo json_encode([
        "status"  => "error",
        "message" => "Field nama_barang, jumlah, dan harga wajib diisi."
    ]);
    exit;
}

try {
    $model  = new Barang($pdo);
    $result = $model->insert([
        'nama_barang'   => $input['nama_barang'],
        'jumlah'        => $input['jumlah'],
        'harga'         => $input['harga'],
        'tanggal_masuk' => $input['tanggal_masuk'] ?? date('Y-m-d'),
        'gambar'        => null,
        'thumb'         => null,
    ]);

    if ($result) {
        echo json_encode([
            "status"  => "success",
            "message" => "Barang berhasil ditambahkan",
            "id"      => $pdo->lastInsertId()
        ]);
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "Gagal menambahkan barang."
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "Gagal menambahkan barang: " . $e->getMessage()
    ]);
}
?>
