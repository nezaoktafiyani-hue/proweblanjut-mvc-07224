<?php
// ============================================================
// api/update.php — PUT: Edit data barang berdasarkan id
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
        "message" => "Field 'id' wajib diisi untuk update."
    ]);
    exit;
}

$id = $input['id'];

try {
    $model  = new Barang($pdo);

    // Ambil data lama sebagai nilai default jika field tidak dikirim
    $lama = $model->getById($id);

    if (!$lama) {
        echo json_encode([
            "status"  => "error",
            "message" => "Data dengan id=$id tidak ditemukan."
        ]);
        exit;
    }

    // Gunakan nilai baru jika dikirim, jika tidak pakai nilai lama
    $result = $model->update($id, [
        'nama_barang'   => $input['nama_barang']   ?? $lama['nama_barang'],
        'jumlah'        => $input['jumlah']         ?? $lama['jumlah'],
        'harga'         => $input['harga']          ?? $lama['harga'],
        'tanggal_masuk' => $input['tanggal_masuk']  ?? $lama['tanggal_masuk'],
        'gambar'        => $lama['gambar'],
        'thumb'         => $lama['thumb'],
    ]);

    if ($result) {
        echo json_encode([
            "status"  => "success",
            "message" => "Barang berhasil diupdate"
        ]);
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "Tidak ada perubahan data."
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "Gagal mengupdate barang: " . $e->getMessage()
    ]);
}
?>
