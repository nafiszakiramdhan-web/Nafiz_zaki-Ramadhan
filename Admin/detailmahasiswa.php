<?php
$idx=$_GET['id'];
require_once "../config.php";

$sql="select * from mhs where id='$idx'";
$data=$db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Mahasiswa</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    </head>
<body>
<div class="app-main">
  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h2 class="mb-4">Detail Data Mahasiswa</h2>
          
          <?php if (empty($data)): ?>
            <div class="alert alert-warning">Data mahasiswa tidak ditemukan.</div>
          <?php else: ?>

          <div class="row"> 
            <div class="col-md-6">
              <table class="table table-bordered">
                <?php
                // Baris 74 dimulai disini
                foreach($data as $d){
                  if($d['gender']=='L'){
                    $jk="Laki-laki";
                  }else{
                    $jk="Perempuan";
                  }
                  switch ($d['prodi']) {
                    case '1': $prodi="Informatika"; break;
                    case '2': $prodi="Arsitektur"; break;
                    case '3': $prodi="Ilmu Lingkungan"; break;

                    default:
                      $prodi ="Tidak Dikenal";
                      break;
                  }
                  
                  // Perbaikan: Menambahkan tag <td> yang hilang setelah NIM, NAMA, dll.
                  echo"<tr><td>NIM</td><td>$d[nim]</td></tr>"; 
                  echo"<tr><td>NAMA</td><td>$d[nama]</td></tr>";
                  echo"<tr><td>JENIS KELAMIN</td><td>$jk</td></tr>";
                  echo"<tr><td>ALAMAT</td><td>$d[alamat]</td></tr>";
                  echo"<tr><td>PRODI</td><td>$prodi</td></tr>";
                }
                ?>
              </table>
              <a href="javascript:history.back(-1)" class="btn btn-secondary">Kembali</a>
            </div>
            </div> 
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="path/to/bootstrap.bundle.min.js"></script> 
</body>
</html>