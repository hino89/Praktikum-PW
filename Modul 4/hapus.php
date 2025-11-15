<?php
include 'auth.php'; // Cek login dan mulai session

// Dapatkan index kontak dari URL
$index = $_GET['index'];

// Cek apakah index valid
if (isset($index) && isset($_SESSION['contacts'][$index])) {
    // Hapus kontak dari array menggunakan unset
    unset($_SESSION['contacts'][$index]);
    
    // (Opsional tapi disarankan) Re-index array agar urutannya tidak bolong
    $_SESSION['contacts'] = array_values($_SESSION['contacts']);

    $_SESSION['message'] = "Kontak berhasil dihapus!";
} else {
    $_SESSION['message'] = "Gagal menghapus. Kontak tidak ditemukan.";
}

// Kembalikan ke halaman utama
header("Location: index.php");
exit;
?>