<?php
session_start(); // Memulai session agar bisa diakses

// Menghapus semua variabel session (user, level, isLogin, dll)
session_unset(); 
session_destroy(); 

// Mengarahkan kembali ke halaman login (index.php di folder luar)
// Tanda "../" artinya "keluar dari folder ini, naik satu level ke atas"
header("Location: ../index.php"); 
exit();
?>