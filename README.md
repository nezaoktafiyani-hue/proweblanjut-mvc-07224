# Inventaris Barang — MVC

Aplikasi CRUD inventaris barang yang direfactor ke pola arsitektur **Model-View-Controller (MVC)**.

## Struktur Folder

```
project_mvc_inventaris/
│
├── app/
│   ├── controllers/
│   │   ├── BarangController.php   ← CRUD barang
│   │   └── AuthController.php     ← Login, register, logout
│   │
│   ├── models/
│   │   ├── Barang.php             ← Query database barang
│   │   └── User.php               ← Query database users
│   │
│   ├── helpers/
│   │   └── UploadHelper.php       ← Upload & thumbnail gambar
│   │
│   └── views/
│       ├── barang/
│       │   ├── index.php          ← Tampilan daftar barang
│       │   ├── tambah.php         ← Form tambah barang
│       │   └── edit.php           ← Form edit barang
│       └── auth/
│           ├── login.php          ← Halaman login
│           └── register.php       ← Halaman register
│
├── config/
│   └── database.php               ← Koneksi database PDO
│
├── public/                        ← Pintu masuk (akses dari browser)
│   ├── index.php
│   ├── tambah.php
│   ├── edit.php
│   ├── hapus.php
│   ├── login.php
│   ├── register.php
│   └── logout.php
│
├── assets/
│   ├── style.css                  ← CSS halaman utama
│   └── form.css                   ← CSS form tambah/edit
│
└── uploads/
    ├── original/                  ← Gambar asli yang diupload
    └── thumbs/                    ← Thumbnail gambar
```

## Cara Menjalankan

1. Copy folder `project_mvc_inventaris` ke dalam folder `htdocs` (XAMPP) atau `www` (WAMP).
2. Buat database `inventaris_db` di phpMyAdmin dan import tabel yang sudah ada.
3. Sesuaikan konfigurasi database di `config/database.php` jika perlu.
4. Akses lewat browser: `http://localhost/project_mvc_inventaris/public/`

## Database SQL

```sql
CREATE DATABASE IF NOT EXISTS inventaris_db;
USE inventaris_db;

CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    jumlah INT NOT NULL,
    harga DECIMAL(15,2) NOT NULL,
    tanggal_masuk DATE NOT NULL,
    gambar VARCHAR(255),
    thumb VARCHAR(255)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);
```

## Penjelasan MVC

| Komponen | File | Fungsi |
|---|---|---|
| **Model** | `app/models/Barang.php` | Query SELECT, INSERT, UPDATE, DELETE tabel barang |
| **Model** | `app/models/User.php` | Query login, register, cek username |
| **Controller** | `app/controllers/BarangController.php` | Atur alur CRUD barang |
| **Controller** | `app/controllers/AuthController.php` | Atur alur login/logout/register |
| **View** | `app/views/barang/*.php` | Tampilan HTML barang |
| **View** | `app/views/auth/*.php` | Tampilan HTML login & register |
| **Front Controller** | `public/*.php` | Pintu masuk, panggil controller yang tepat |
