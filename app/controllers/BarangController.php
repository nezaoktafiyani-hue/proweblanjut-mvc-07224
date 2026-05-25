<?php
// =============================================================
// app/controllers/BarangController.php
// Controller: mengatur alur aplikasi untuk fitur barang (CRUD)
// =============================================================
require_once __DIR__ . '/../models/Barang.php';
require_once __DIR__ . '/../helpers/UploadHelper.php';

class BarangController
{
    private $model;
    private $uploader;
    private $baseDir;

    public function __construct($pdo, $baseDir)
    {
        $this->model    = new Barang($pdo);
        $this->baseDir  = $baseDir;
        $this->uploader = new UploadHelper($baseDir);
    }

    // ── INDEX: Tampilkan daftar barang ──────────────────────
    public function index()
    {
        $this->cekLogin();

        $data  = $this->model->getAll();
        $stats = $this->model->getStats($data);

        require __DIR__ . '/../views/barang/index.php';
    }

    // ── CREATE (GET): Tampilkan form tambah ─────────────────
    public function create()
    {
        $this->cekLogin();

        $errors = [];
        $old    = ['nama_barang' => '', 'jumlah' => '', 'harga' => '', 'tanggal_masuk' => date('Y-m-d')];

        require __DIR__ . '/../views/barang/tambah.php';
    }

    // ── STORE (POST): Simpan data baru ke database ──────────
    public function store()
    {
        $this->cekLogin();

        $errors = [];
        $old = [
            'nama_barang'   => trim($_POST['nama_barang']   ?? ''),
            'jumlah'        => trim($_POST['jumlah']        ?? ''),
            'harga'         => trim($_POST['harga']         ?? ''),
            'tanggal_masuk' => trim($_POST['tanggal_masuk'] ?? ''),
        ];

        $errors = $this->validasi($old);

        $gambarPath = null;
        $thumbPath  = null;

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
            $hasil = $this->uploader->upload($_FILES['gambar']);
            if (isset($hasil['error'])) {
                $errors['gambar'] = $hasil['error'];
            } else {
                $gambarPath = $hasil['gambar'];
                $thumbPath  = $hasil['thumb'];
            }
        }

        if (empty($errors)) {
            $this->model->insert([
                'nama_barang'   => $old['nama_barang'],
                'jumlah'        => $old['jumlah'],
                'harga'         => $old['harga'],
                'tanggal_masuk' => $old['tanggal_masuk'],
                'gambar'        => $gambarPath,
                'thumb'         => $thumbPath,
            ]);
            header('Location: index.php');
            exit;
        }

        // Jika ada error, tampilkan form lagi dengan pesan error
        require __DIR__ . '/../views/barang/tambah.php';
    }

    // ── EDIT (GET): Tampilkan form edit ─────────────────────
    public function edit()
    {
        $this->cekLogin();

        $id     = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $barang = $this->cariBarang($id);
        $errors = [];
        $val    = [
            'nama_barang'   => $barang['nama_barang'],
            'jumlah'        => $barang['jumlah'],
            'harga'         => $barang['harga'],
            'tanggal_masuk' => $barang['tanggal_masuk'],
        ];

        require __DIR__ . '/../views/barang/edit.php';
    }

    // ── UPDATE (POST): Simpan perubahan ke database ─────────
    public function update()
    {
        $this->cekLogin();

        $id     = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $barang = $this->cariBarang($id);

        $errors = [];
        $val = [
            'nama_barang'   => trim($_POST['nama_barang']   ?? ''),
            'jumlah'        => trim($_POST['jumlah']        ?? ''),
            'harga'         => trim($_POST['harga']         ?? ''),
            'tanggal_masuk' => trim($_POST['tanggal_masuk'] ?? ''),
        ];

        $errors = $this->validasi($val);

        $gambarPath = $barang['gambar'] ?? null;
        $thumbPath  = $barang['thumb']  ?? null;

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
            $hasil = $this->uploader->upload($_FILES['gambar']);
            if (isset($hasil['error'])) {
                $errors['gambar'] = $hasil['error'];
            } else {
                // Hapus file lama
                $this->uploader->hapusGambar($barang['gambar'], $barang['thumb'], $this->baseDir);
                $gambarPath = $hasil['gambar'];
                $thumbPath  = $hasil['thumb'];
            }
        }

        if (empty($errors)) {
            $this->model->update($id, [
                'nama_barang'   => $val['nama_barang'],
                'jumlah'        => $val['jumlah'],
                'harga'         => $val['harga'],
                'tanggal_masuk' => $val['tanggal_masuk'],
                'gambar'        => $gambarPath,
                'thumb'         => $thumbPath,
            ]);
            header('Location: index.php');
            exit;
        }

        require __DIR__ . '/../views/barang/edit.php';
    }

    // ── DELETE: Hapus barang ─────────────────────────────────
    public function delete()
    {
        $this->cekLogin();

        $id     = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $barang = $this->cariBarang($id);

        // Hapus file gambar dari server
        $this->uploader->hapusGambar($barang['gambar'], $barang['thumb'], $this->baseDir);

        $this->model->delete($id);
        header('Location: index.php');
        exit;
    }

    // ── PRIVATE HELPERS ──────────────────────────────────────

    private function cekLogin()
    {
        if (!isset($_SESSION['username'])) {
            header('Location: login.php');
            exit;
        }
    }

    private function cariBarang($id)
    {
        if (!$id) {
            header('Location: index.php');
            exit;
        }
        $barang = $this->model->getById($id);
        if (!$barang) {
            header('Location: index.php');
            exit;
        }
        return $barang;
    }

    private function validasi($data)
    {
        $errors = [];

        if (empty($data['nama_barang'])) {
            $errors['nama_barang'] = 'Nama barang tidak boleh kosong.';
        } elseif (strlen($data['nama_barang']) < 2) {
            $errors['nama_barang'] = 'Nama barang minimal 2 karakter.';
        }

        if ($data['jumlah'] === '') {
            $errors['jumlah'] = 'Jumlah tidak boleh kosong.';
        } elseif (!is_numeric($data['jumlah']) || (int)$data['jumlah'] < 1) {
            $errors['jumlah'] = 'Jumlah harus berupa angka positif (min. 1).';
        }

        if ($data['harga'] === '') {
            $errors['harga'] = 'Harga tidak boleh kosong.';
        } elseif (!is_numeric($data['harga']) || (float)$data['harga'] <= 0) {
            $errors['harga'] = 'Harga harus berupa angka lebih dari 0.';
        }

        if (empty($data['tanggal_masuk'])) {
            $errors['tanggal_masuk'] = 'Tanggal masuk tidak boleh kosong.';
        }

        return $errors;
    }
}
