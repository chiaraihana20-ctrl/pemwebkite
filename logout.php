<?php
session_start(); // Memulai sesi

// Menghapus semua variabel sesi
$_SESSION = array();

// Menghancurkan sesi
session_destroy();

// Mengalihkan ke halaman login dengan pesan keluar
header("Location: login.php?pesan=logged_out");
exit;
?>