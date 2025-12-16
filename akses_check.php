<?php
/**
 * Fungsi untuk memeriksa status login dan hak akses (level) pengguna.
 * @param array $required_roles Daftar peran yang diizinkan (e.g., ['admin', 'dosen', 'mhs'])
 */
function check_access($required_roles) {
    // 1. Cek apakah pengguna sudah login
    if (!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] !== true) {
        // Jika belum login, redirect ke halaman login utama (yang berada satu tingkat di atas folder Dosen/Mahasiswa/Admin)
        header('Location: ../index.php'); 
        exit;
    }

    $current_role = $_SESSION['level'];
    
    // 2. Cek apakah peran pengguna saat ini ada dalam daftar peran yang diizinkan
    if (!in_array($current_role, $required_roles)) {
        // Jika tidak memiliki izin (peran tidak sesuai), tolak akses
        // Redirect juga ke halaman login utama
        header('Location: ../index.php'); 
        exit;
    }
}
?>