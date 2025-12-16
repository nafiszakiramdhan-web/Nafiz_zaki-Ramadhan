<?php
$p = isset($_GET['p']) ? $_GET['p'] : 'home';

switch ($p) {
    case 'dosen':
        require_once "dosen.php";
        break;
 case 'tambahdosen': // Jaga-jaga kalau ada link lama yang pakai 'mhs'
        require_once "tambahdosen.php";
        break;

 case 'detaildosen': // Jaga-jaga kalau ada link lama yang pakai 'mhs'
        require_once "detaildosen.php";
        break;

 case 'editdosen': // Jaga-jaga kalau ada link lama yang pakai 'mhs'
        require_once "editdosendosen.php";
        break;

    case 'mahasiswa': // Diganti jadi 'mahasiswa' agar cocok dengan link tombol
        require_once "mahasiswa.php";
        break;

    case 'mhs': // Jaga-jaga kalau ada link lama yang pakai 'mhs'
        require_once "mahasiswa.php";
        break;
   

    case 'tambahmahasiswa':
        // Sesuai gambar: tambahmahasiswa.php (tanpa strip)
        require_once "tambahmahasiswa.php"; 
        break;

    case 'detailmahasiswa':
        require_once "detailmahasiswa.php";
        break;

    case 'editmahasiswa':
        require_once "editmahasiswa.php";
        break;    

    case 'hapus-mhs':
        // Link di tabel pakai 'hapus-mhs', tapi filenya 'hapusmahasiswa.php'
        require_once "hapusmahasiswa.php"; 
        break;

    default:
        // PERBAIKAN UTAMA DISINI:
        // Nama file disesuaikan dengan gambar Anda: "dasboard.php" (tanpa h)
        if(file_exists("dasboard.php")){
            require_once "dasboard.php";
        } else {
            echo "<div class='p-4'><h3>File dasboard.php tidak ditemukan. Cek nama filenya lagi.</h3></div>";
        }
        break;
}
?>