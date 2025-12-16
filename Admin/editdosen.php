admin > edit-mahasiswa.php

<?php
// ASUMSI: Proses pengambilan data awal (yang hilang dari potongan)
$idx=$_GET['id']; 
require_once "../config.php"; 

$sql_select="select * from mhs where id='$idx'"; 
$data_awal=$db->query($sql_select);
$d = $data_awal->fetch_assoc(); // Ambil satu baris data untuk pre-filling

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
</head>
<body>

<main class="app-main">
  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          
          <h2 class="mb-4">Edit Data Mahasiswa</h2>

          <div class="row">
            <div class="col-md-6">
            
              <form method="post" action="#"> 
              
                <?php
                // BLOK PHP UNTUK MENANGANI SUBMIT FORM (Baris 74 - 91)
                if(isset($_POST['simpanEdit'])){
                    $nim=$_POST['nim'];
                    $nama=$_POST['nama'];
                    $jk=$_POST['jk'];
                    $alamat=$_POST['alamat'];
                    $prodi=$_POST['prodi'];
                    
                    $sql="UPDATE mhs SET nim='$nim', nama='$nama', gender='$jk', alamat='$alamat', prodi='$prodi' WHERE id='$idx'";
                    
                    $hasil=$db->query($sql);
                    
                    if($hasil){
                        echo '<div class="alert alert-success">Data berhasil diedit!</div>';
                        // Refresh data setelah edit berhasil agar form menampilkan data terbaru
                        $data_awal=$db->query($sql_select); 
                        $d = $data_awal->fetch_assoc();
                        
                    }else{
                        echo '<div class="alert alert-danger">Data gagal diedit!</div>';
                    }
                }
                
                // BLOK PHP UNTUK MENGAMBIL DATA AWAL (Baris 94 - 104)
                // Catatan: Saya hanya akan menggunakan $d dari atas, tapi struktur perulangan dipertahankan
                
                // Simulasi data_awal dengan array agar perulangan foreach berfungsi
                $data_for_form = [$d]; 
                
                ?>
              <table class="table table-bordered">
                <?php
                foreach($data_for_form as $d_form){
                  
                  // Logic untuk menandai radio button yang sudah dipilih
                  $jkL = ($d_form['gender'] == 'L') ? 'checked' : '';
                  $jkP = ($d_form['gender'] == 'P') ? 'checked' : '';
                  
                  // Logic untuk switch/case (meskipun tidak digunakan dalam form, 
                  // saya sertakan sebagai penanda baris)
                  switch ($d_form['prodi']) {
                    case '1': $prodi="Informatika"; break;
                    case '2': $prodi="Arsitektur"; break;
                    case '3': $prodi="Ilmu Lingkungan"; break;

                    // Baris 106-108 dari potongan sebelumnya (Default case)
                    default:
                      $prodi ="Tidak Dikenal";
                      break;
                  }

                  // BARIS FORM INPUT DARI POTONGAN KODE SEBELUMNYA
                  // Menggunakan $d_form untuk nilai input
                  echo"<tr><td>NIM</td><td><input type='number' name='nim' value='{$d_form['nim']}' class='form-control'></td></tr>";
                  echo"<tr><td>NAMA</td><td><input type='text' name='nama' value='{$d_form['nama']}' class='form-control'></td></tr>";
                  echo"<tr><td>JENIS KELAMIN</td><td><input type='radio' name='jk' value='L' $jkL> Laki-laki
                  <input type='radio' name='jk' value='P' $jkP> Perempuan</td></tr>";
                  echo"<tr><td>ALAMAT</td><td><textarea class='form-control' name='alamat'>{$d_form['alamat']}</textarea></td></tr>";
                  echo"<tr><td>PRODI</td><td><select name='prodi' class='form-control'>
                  <option value=''></option>
                  <option value='1' "; if($d_form['prodi']=='1'){echo"selected";} echo">Informatika</option>
                  <option value='2' "; if($d_form['prodi']=='2'){echo"selected";} echo">Arsitektur</option>
                  <option value='3' "; if($d_form['prodi']=='3'){echo"selected";} echo">Ilmu Lingkungan</option>
                  </select></td></tr>";
                  echo"<tr><td></td><td>
                  <input type='submit' name='simpanEdit' value='Simpan Perubahan' class='btn btn-primary'>
                  </td></tr>";
                }
                ?>
              </table>
              
              <a href="./?p=mahasiswa" class="btn btn-secondary">Kembali</a>
              
              </form> 
              
            </div>
          </div> 
        </div>
      </div>
    </div>
  </div>
</main>

<script src="path/to/bootstrap.bundle.min.js"></script> 
</body>
</html>