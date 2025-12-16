<?php
// =========================================================================
// BAGIAN 1: LOGIKA PHP (PENGAMBILAN DATA DARI DATABASE)
// =========================================================================

// PATH KONEKSI: Pastikan file config terhubung. Sesuaikan path jika letak file config berbeda.
require_once "../config.php"; 

// --- KONFIGURASI NAMA TABEL ---
$nama_tabel = "dosen"; 

// Mengambil input dari form pencarian
$keyword  = isset($_POST['keyword']) ? $_POST['keyword'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$cari     = isset($_POST['cari']) ? $_POST['cari'] : ''; 

// Query Default: Ambil semua data dosen
$sql = "SELECT * FROM $nama_tabel ORDER BY id DESC";

if($cari){
  // Amankan input dari karakter aneh
  $keyword  = $db->real_escape_string($keyword); 
  $category = $db->real_escape_string($category);

  if($category == "prodi"){
    // Logika mapping kode prodi (sesuaikan jika kode dosen berbeda)
    $prodi = ''; 
    if(stripos($keyword, "INFORMATIKA") !== false){ $prodi = 1; } 
    elseif(stripos($keyword, "ARSITEKTUR") !== false){ $prodi = 2; } 
    elseif(stripos($keyword, "LINGKUNGAN") !== false || stripos($keyword, "SISTEM") !== false){ $prodi = 3; }
    
    $sql = "SELECT * FROM $nama_tabel WHERE prodi LIKE '%$prodi%' ORDER BY id DESC";
  } else {
    // Query Pencarian Umum
    $sql = "SELECT * FROM $nama_tabel WHERE $category LIKE '%$keyword%' ORDER BY id DESC";  
  }
}

// Eksekusi query
$data = $db->query($sql);

// Tambahkan pengecekan error (Opsional, untuk debugging)
if ($data === false) {
    // ...
}
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Data Dosen</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Dosen</li>
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
              <table>
                <tr>
                  <td width="20"></td>
                  <td>
                    <form method="POST" action="">
                      <div class="input-group">
                        <input type='text' name='keyword' class="form-control form-control-sm" placeholder="Kata kunci..." value="<?=$keyword?>">
                        <select name="category" class="form-select form-select-sm">
                          <option value='nidn' <?php if($category=="nidn") echo"selected"; ?>>NIDN</option> 
                          <option value='nama' <?php if($category=="nama") echo"selected"; ?>>Nama</option>
                          <option value='gender' <?php if($category=="gender") echo"selected"; ?>>Gender</option>
                          <option value='prodi' <?php if($category=="prodi") echo"selected"; ?>>Prodi</option>
                        </select>
                        <input type="submit" name="cari" value="Search" class="btn btn-sm btn-default border">
                      </div>
                    </form>
                  </td>
                </tr>
              </table>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-striped table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>NO</th>
                    <th>NIDN</th> 
                    <th>Nama</th>
                    <th>Gender</th>
                    <th>Alamat</th>
                    <th>Prodi</th>
                    <th>Detail</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  // Menggunakan while loop fetch_assoc untuk kompatibilitas yang lebih baik
                  if ($data && $data->num_rows > 0) {
                      while ($dosen = $data->fetch_assoc()) {
                          $no++;
                          
                          // Logika tampilan Prodi
                          if($dosen['prodi'] == 1) { $nama_prodi = 'INFORMATIKA'; } 
                          elseif($dosen['prodi'] == 2) { $nama_prodi = 'ARSITEKTUR'; } 
                          elseif($dosen['prodi'] == 3) { $nama_prodi = 'ILMU LINGKUNGAN'; } 
                          else { $nama_prodi = 'TIDAK DIKENAL'; }
                          
                          echo "<tr>
                            <td>$no</td>
                            <td>{$dosen['nidn']}</td> 
                            <td>{$dosen['nama']}</td> 
                            <td>{$dosen['gender']}</td> 
                            <td>{$dosen['alamat']}</td>
                            <td>$nama_prodi</td>
                            <td>
                              
                            </td>
                          </tr>";
                      }
                  } else {
                      echo "<tr><td colspan='7' class='text-center'>Data Dosen tidak ditemukan atau query gagal.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</main>