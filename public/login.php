<?php
// =============================================================
// public/login.php — Front Controller: Login
// =============================================================
session_start();
require_once '../config/database.php';
require_once '../app/controllers/AuthController.php';

$controller = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login();
} else {
    $controller->loginForm();
}
