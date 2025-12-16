<?php
$db = new mysqli("localhost", "root", "", "siakaddb");
if ($db) {
    echo"Koneksi Berhasil";
} else {
    echo"Koneksi Gagal";
}
?>
