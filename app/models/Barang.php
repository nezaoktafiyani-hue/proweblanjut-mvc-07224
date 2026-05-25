<?php
// =============================================================
// app/models/Barang.php
// Model: mengelola semua query database untuk tabel 'barang'
// =============================================================
class Barang
{
    private $conn;

    public function __construct($pdo)
    {
        $this->conn = $pdo;
    }

    // Ambil semua data barang
    public function getAll()
    {
        $stmt = $this->conn->query("SELECT * FROM barang ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil satu barang berdasarkan ID
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM barang WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tambah barang baru
    public function insert($data)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO barang (nama_barang, jumlah, harga, tanggal_masuk, gambar, thumb)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['nama_barang'],
            (int)$data['jumlah'],
            (float)$data['harga'],
            $data['tanggal_masuk'],
            $data['gambar'],
            $data['thumb'],
        ]);
    }

    // Update data barang
    public function update($id, $data)
    {
        $stmt = $this->conn->prepare(
            "UPDATE barang
             SET nama_barang=?, jumlah=?, harga=?, tanggal_masuk=?, gambar=?, thumb=?
             WHERE id=?"
        );
        return $stmt->execute([
            $data['nama_barang'],
            (int)$data['jumlah'],
            (float)$data['harga'],
            $data['tanggal_masuk'],
            $data['gambar'],
            $data['thumb'],
            $id,
        ]);
    }

    // Hapus barang berdasarkan ID
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM barang WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Hitung statistik
    public function getStats($data)
    {
        return [
            'total_barang' => count($data),
            'total_stok'   => array_sum(array_column($data, 'jumlah')),
            'total_nilai'  => array_sum(array_map(fn($r) => $r['harga'] * $r['jumlah'], $data)),
        ];
    }
}
