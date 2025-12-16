<?php
// 1. PANGGIL KONEKSI DATABASE
// Pastikan lokasi file config.php sudah benar.
// Jika file ini ada di dalam folder admin, gunakan "../config.php"
// Jika file ini sejajar dengan config.php, gunakan "config.php"
require_once "../config.php"; 

// 2. CEK APAKAH ADA ID YANG DIKIRIM DARI LINK
if (isset($_GET['id'])) {
    
    // Ambil ID dari URL dan bersihkan (untuk keamanan)
    $id = $db->real_escape_string($_GET['id']);

    // 3. SIAPKAN PERINTAH HAPUS
    // "Hapus dari tabel 'mhs' dimana kolom 'id' sama dengan $id"
    $sql = "DELETE FROM mhs WHERE id='$id'";

    // 4. JALANKAN PERINTAH KE DATABASE
    $hapus = $db->query($sql);

    // 5. CEK HASILNYA
    if ($hapus) {
        // Jika BERHASIL, munculkan pesan dan kembali ke halaman data mahasiswa
        echo "<script>
                alert('Data Berhasil Dihapus Permanen!'); 
                window.location='index.php?p=mahasiswa';
              </script>";
    } else {
        // Jika GAGAL, munculkan pesan error asli dari database
        echo "<script>
                alert('Gagal Menghapus Data: " . $db->error . "'); 
                window.location='index.php?p=mahasiswa';
              </script>";
    }

} else {
    // Jika file ini dibuka tanpa membawa ID, langsung tendang balik ke index
    echo "<script>window.location='index.php?p=mahasiswa';</script>";
}
?>