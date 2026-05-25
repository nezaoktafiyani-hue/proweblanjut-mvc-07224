<?php
// =============================================================
// public/register.php — Front Controller: Register
// =============================================================
session_start();
require_once '../config/database.php';
require_once '../app/controllers/AuthController.php';

$controller = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->register();
} else {
    $controller->registerForm();
}
