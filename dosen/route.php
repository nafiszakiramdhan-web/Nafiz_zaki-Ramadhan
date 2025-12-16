<?php
// Ambil parameter 'p' dari URL. Jika tidak ada, defaultnya adalah 'dashboard'.
$p = isset($_GET['p']) ? $_GET['p'] : 'dashboard';

// Tentukan file yang akan di-include
$file_to_include = '';

switch ($p) {
    case 'dosen':
        // **PERBAIKAN PATH:** Tambahkan 'dosen/' di depan nama file
        $file_to_include = "dosen.php";
        break;

    case 'tambahdosen':
        // **PERBAIKAN PATH:** Tambahkan 'dosen/'
        $file_to_include = "tambahdosen.php"; 
        break;

    case 'detaildosen':
        // **PERBAIKAN PATH:** Tambahkan 'dosen/'
        $file_to_include = "etaildosen.php";
        break;

    case 'editdosen':
        // **PERBAIKAN PATH:** Tambahkan 'dosen/'
        $file_to_include = "dosen/editdosen.php";
        break; 

    case 'hapusdosen':
        // **PERBAIKAN PATH:** Tambahkan 'dosen/'
        $file_to_include = "dosen/hapusdosen.php"; 
        break;
        
    case 'dashboard':
        // Asumsi: dasboard.php ada di folder yang sama dengan index.php
        $file_to_include = "dasboard.php"; 
        break;

    default:
        $file_to_include = "dasboard.php";
        break;
}

// Logika Pemrosesan Konten
if (!empty($file_to_include) && file_exists($file_to_include)) {
    require_once $file_to_include;
} else {
    // Tampilkan pesan error jika file yang diminta tidak ada
    echo "<main class='app-main'><div class='container-fluid'><h3 class='text-danger'>ERROR 404: Halaman '$file_to_include' tidak ditemukan.</h3></div></main>";
}
?>