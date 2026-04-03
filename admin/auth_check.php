<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect ke halaman login jika belum ada session login admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
