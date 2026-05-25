<?php
// =============================================================
// public/logout.php — Front Controller: Logout
// =============================================================
session_start();
require_once '../config/database.php';
require_once '../app/controllers/AuthController.php';

$controller = new AuthController($pdo);
$controller->logout();
