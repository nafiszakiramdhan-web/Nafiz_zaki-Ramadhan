<?php
// Pastikan file config terhubung
require_once "../config.php";

// Mengambil input dari form pencarian
$keyword  = isset($_POST['keyword']) ? $_POST['keyword'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$cari     = isset($_POST['cari']) ? $_POST['cari'] : ''; 

// --- MODIFIKASI 1: Query Default ---
// Ditambahkan "ORDER BY id DESC" agar data terbaru muncul paling atas
$sql = "SELECT * FROM mhs ORDER BY id DESC";

if($cari){
  // Amankan input dari karakter aneh
  $keyword  = $db->real_escape_string($keyword);
  $category = $db->real_escape_string($category);

  if($category == "prodi"){
    // --- LOGIKA PENCARIAN PRODI ---
    $prodi = ''; 
    if(stripos($keyword, "INFORMATIKA") !== false){
      $prodi = 1;
    } elseif(stripos($keyword, "ARSITEKTUR") !== false){
      $prodi = 2;
    } elseif(stripos($keyword, "LINGKUNGAN") !== false || stripos($keyword, "SISTEM") !== false){
      $prodi = 3;
    }
    
    // --- MODIFIKASI 2: Query Khusus Prodi ---
    // Ditambahkan "ORDER BY id DESC"
    $sql = "SELECT * FROM mhs WHERE prodi LIKE '%$prodi%' ORDER BY id DESC";
  } else {
    // --- MODIFIKASI 3: Query Pencarian Umum ---
    // Ditambahkan "ORDER BY id DESC"
    $sql = "SELECT * FROM mhs WHERE $category LIKE '%$keyword%' ORDER BY id DESC";  
  }
}

// Eksekusi query
$data = $db->query($sql);
?>

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Data Mahasiswa</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Mahasiswa</li>
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
                  <td>
                    <a href="./?p=tambahmahasiswa" class="btn btn-primary" style="width: 150px">
                        <i class="bi bi-plus-circle"></i> +Mahasiswa
                    </a>
                  </td>
                  <td width="20"></td>
                  <td>
                    <form method="POST" action="">
                      <div class="input-group">
                        <input type='text' name='keyword' class="form-control form-control-sm" placeholder="Kata kunci..." value="<?=$keyword?>">
                        <select name="category" class="form-select form-select-sm">
                            <option value='nim' <?php if($category=="nim") echo"selected"; ?>>NIM</option>
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
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Gender</th>
                    <th>Alamat</th>
                    <th>Prodi</th>
                    <th>Opsi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  foreach ($data as $d) {
                    $no++;
                    
                    // Logika tampilan Prodi
                    if($d['prodi'] == 1) {
                      $nama_prodi = 'INFORMATIKA';
                    } elseif($d['prodi'] == 2) {
                      $nama_prodi = 'ARSITEKTUR';
                    } elseif($d['prodi'] == 3) {
                      $nama_prodi = 'ILMU LINGKUNGAN';
                    } else {
                      $nama_prodi = 'TIDAK DIKENAL';
                    }
                    
                    echo "<tr>
                      <td>$no</td>
                      <td>{$d['nim']}</td>
                      <td>{$d['nama']}</td>
                      <td>{$d['gender']}</td>
                      <td>{$d['alamat']}</td>
                      <td>$nama_prodi</td>
                      <td>
                        <a href='./?p=detailmahasiswa&id={$d['id']}' class='btn btn-sm btn-info'>Detail</a>
                        <a href='./?p=editmahasiswa&id={$d['id']}' class='btn btn-sm btn-warning'>Edit</a>
                        <a href='./?p=hapus-mhs&id={$d['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin hapus data ini?')\">Hapus</a>
                      </td>
                    </tr>";
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