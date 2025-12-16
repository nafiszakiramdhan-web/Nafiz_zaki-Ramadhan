<main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6"><h3 class="mb-0">Dashboard Tambah Dosen</h3></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard Dosen</li>
            </ol>
          </div>
          </div>
        </div>
      </div>
    <div class="app-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tambah Data Dosen</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">

<?php
// =========================================================================
// BAGIAN 1: LOGIKA PHP UNTUK SIMPAN DATA DOSEN (SOLUSI SINKRONISASI DB)
// =========================================================================

// PATH KONEKSI: Anda sudah konfirmasi ini benar
require_once "../config.php"; 

$nidn = $nama = $jk = $alamat = $prodi = ''; // Inisialisasi variabel

if(isset($_POST['simpan'])){
    $nidn = $_POST['nidn']; 
    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $prodi = $_POST['prodi'];

    // UJI KONEKSI EKSPLISIT BERDASARKAN config.php ANDA
    if ($db->connect_error) {
        // Tampilkan error jika koneksi gagal total
        echo "<div class='alert alert-danger'><strong>Koneksi MySQLi GAGAL!</strong> Error: " . $db->connect_error . "</div>";
    } else {
        // 🛑 SOLUSI KRITIS: Memaksa pemilihan database (siakaddb) 🛑
        // Ini mengatasi masalah kegagalan sinkronisasi yang Anda alami.
        $db->select_db("siakaddb"); 
        
        if(empty($nidn) || empty($nama) || empty($jk) || empty($alamat) || empty($prodi)){
            echo "<div class='alert alert-danger'>Semua kolom wajib diisi!</div>";
        } else {
            
            // Sanitasi data
            $nidn_clean = $db->real_escape_string($nidn);
            $nama_clean = $db->real_escape_string($nama);
            $jk_clean = $db->real_escape_string($jk);
            $alamat_clean = $db->real_escape_string($alamat);
            $prodi_clean = $db->real_escape_string($prodi);

            // KOREKSI QUERY: Menghilangkan kolom 'waktu'
            $sql="INSERT INTO dosen 
                  SET nidn='$nidn_clean', 
                      nama='$nama_clean', 
                      gender='$jk_clean', 
                      alamat='$alamat_clean', 
                      prodi='$prodi_clean'"; 
            
            $tes=$db->query($sql);
            
            if($tes){
                // Data berhasil disimpan, langsung redirect ke dashboard dosen
                echo "<script>alert('Data Dosen berhasil disimpan!'); window.location.href='./?p=dosen';</script>";
                
                // Kosongkan variabel (jika redirect gagal)
                $nidn = $nama = $jk = $alamat = $prodi = '';
            } else {
                // Tampilkan error MySQL yang detail jika data ditolak
                echo "<div class='alert alert-danger'>Data gagal disimpan! MySQL Error: " . $db->error . "</div>";
            }
        }
    }
}
?>
            
<form method="post" action="#">
    <table>
      <tr>
          <td>NIDN</td>
          <td><input type="number" name="nidn" class="form-control" value="<?=$nidn?>"></td>
      </tr>
      <tr>
          <td>Nama Lengkap</td>
          <td><input type="text" name="nama" class="form-control" value="<?=$nama?>"></td>
      </tr>
      <tr>
          <td>Jenis Kelamin</td>
          <td>
              <input type="radio" name="jk" id="jkL" value="L" <?php if($jk=="L") echo "checked"; ?>>
              <label for="jkL">Laki-laki</label>
              <input type="radio" name="jk" id="jkP" value="P" <?php if($jk=="P") echo "checked"; ?>>
              <label for="jkL">Perempuan</label>
          </td>
      </tr>
      <tr>
          <td valign="top">Alamat</td>
          <td><textarea name="alamat" class="form-control" style="width:300px"><?=$alamat?></textarea></td>
      </tr>
      <tr>
          <td>Program Studi</td>
          <td>
              <select name="prodi" class="form-control">
                  <option></option>
                  <option value="1" <?php if($prodi==1) echo "selected";?>>Informatika</option>
                  <option value="2" <?php if($prodi==2) echo "selected";?>>Arsitektur</option>
                  <option value="3" <?php if($prodi==3) echo "selected";?>>Ilmu Lingkungan</option>
              </select>
          </td>
      </tr>
      <tr>
          <td></td>
          <td><button type="submit" name="simpan" value="Simpan" class="btn btn-success">Simpan Data Dosen</button></td>
      </tr>
    </table>
</form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>