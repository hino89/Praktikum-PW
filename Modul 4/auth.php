<?php
// Selalu mulai session di awal
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika belum, redirect ke halaman login
    header("Location: login.php");
    exit;
}
?>