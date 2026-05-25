<?php
// =============================================================
// app/controllers/AuthController.php
// Controller: mengatur alur login, register, dan logout
// =============================================================
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new User($pdo);
    }

    // ── LOGIN (GET): Tampilkan form login ────────────────────
    public function loginForm()
    {
        if (isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }
        $error = '';
        $remembered_username = $_COOKIE['remember_username'] ?? '';
        require __DIR__ . '/../views/auth/login.php';
    }

    // ── LOGIN (POST): Proses login ───────────────────────────
    public function login()
    {
        $error = '';
        $remembered_username = $_COOKIE['remember_username'] ?? '';

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        $user = $this->model->findByUsername($username);

        if ($user && $this->model->verifyPassword($password, $user['password'])) {
            $_SESSION['username'] = $username;

            if ($remember) {
                setcookie('remember_username', $username, time() + 60 * 60 * 24 * 30, '/');
            } else {
                setcookie('remember_username', '', time() - 3600, '/');
            }

            header('Location: index.php');
            exit;
        } else {
            $error = $user ? 'Password salah!' : 'Username tidak ditemukan!';
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    // ── REGISTER (GET): Tampilkan form register ──────────────
    public function registerForm()
    {
        if (isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }
        $error   = '';
        $success = '';
        require __DIR__ . '/../views/auth/register.php';
    }

    // ── REGISTER (POST): Proses registrasi ──────────────────
    public function register()
    {
        $error   = '';
        $success = '';

        $username         = trim($_POST['username']         ?? '');
        $password         = trim($_POST['password']         ?? '');
        $confirm_password = trim($_POST['confirm_password'] ?? '');

        if (empty($username) || empty($password) || empty($confirm_password)) {
            $error = 'Semua field wajib diisi.';
        } elseif ($password !== $confirm_password) {
            $error = 'Password dan konfirmasi password tidak cocok.';
        } elseif ($this->model->usernameExists($username)) {
            $error = 'Username sudah digunakan.';
        } else {
            if ($this->model->register($username, $password)) {
                $success = 'Registrasi berhasil! Silakan login.';
            } else {
                $error = 'Registrasi gagal, coba lagi.';
            }
        }

        require __DIR__ . '/../views/auth/register.php';
    }

    // ── LOGOUT ───────────────────────────────────────────────
    public function logout()
    {
        session_destroy();
        setcookie('remember_username', '', time() - 3600, '/');
        header('Location: login.php');
        exit;
    }
}
