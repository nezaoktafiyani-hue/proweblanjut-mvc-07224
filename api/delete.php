<?php
// ============================================================
// api/delete.php — DELETE: Hapus data barang berdasarkan id
// Menggunakan Model Barang dari arsitektur MVC
// ============================================================
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
require_once '../app/models/Barang.php';

// Ambil data JSON dari body request
$input = json_decode(file_get_contents("php://input"), true);

// Validasi: id wajib ada
if (empty($input['id'])) {
    echo json_encode([
        "status"  => "error",
        "message" => "Field 'id' wajib diisi untuk menghapus data."
    ]);
    exit;
}

$id = $input['id'];

try {
    $model = new Barang($pdo);

    // Cek dulu apakah data ada
    $barang = $model->getById($id);

    if (!$barang) {
        echo json_encode([
            "status"  => "error",
            "message" => "Data dengan id=$id tidak ditemukan."
        ]);
        exit;
    }

    $result = $model->delete($id);

    if ($result) {
        echo json_encode([
            "status"  => "success",
            "message" => "Barang berhasil dihapus"
        ]);
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "Gagal menghapus barang."
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "Gagal menghapus barang: " . $e->getMessage()
    ]);
}
?>
