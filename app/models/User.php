<?php
// =============================================================
// app/models/User.php
// Model: mengelola semua query database untuk tabel 'users'
// =============================================================
class User
{
    private $conn;

    public function __construct($pdo)
    {
        $this->conn = $pdo;
    }

    // Cari user berdasarkan username
    public function findByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cek apakah username sudah ada
    public function usernameExists($username)
    {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->rowCount() > 0;
    }

    // Daftarkan user baru
    public function register($username, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hash]);
    }

    // Verifikasi password
    public function verifyPassword($inputPassword, $hashedPassword)
    {
        return password_verify($inputPassword, $hashedPassword);
    }
}
