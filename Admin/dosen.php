<?php
// =========================================================================
// BAGIAN 1: LOGIKA PHP (PENGAMBILAN DATA, QUERY, DAN DEBUGGING)
// =========================================================================

// PATH KONEKSI: Jika config.php ada di folder yang sama dengan dosen.php
// Jika config.php ada satu level di atas, ganti menjadi "../config.php" (seperti sebelumnya).
require_once "../config.php"; 

$error_message = '';
$data_dosen = []; 
$jumlah_baris = 0;

// Cek Koneksi Database
if (!isset($db) || (isset($db) && $db->connect_error)) {
    $error_message = '<strong>Gagal Kritis Koneksi:</strong> Tidak dapat terhubung ke database. Pesan Error: ' . (isset($db) ? $db->connect_error : 'Variabel $db (koneksi) tidak ditemukan. Cek path require_once dan file config.php.');
} else {
    $nama_tabel = "dosen"; 
    $keyword    = isset($_POST['keyword']) ? $_POST['keyword'] : '';
    $category   = isset($_POST['category']) ? $_POST['category'] : '';
    $cari       = isset($_POST['cari']) ? $_POST['cari'] : ''; 

    // Query Default
    $sql = "SELECT * FROM $nama_tabel ORDER BY id DESC";

    if($cari){
        $keyword  = $db->real_escape_string($keyword); 
        $category = $db->real_escape_string($category);

        if($category == "prodi"){
            $prodi = ''; 
            if(stripos($keyword, "INFORMATIKA") !== false){ $prodi = 1; } 
            elseif(stripos($keyword, "ARSITEKTUR") !== false){ $prodi = 2; } 
            elseif(stripos($keyword, "LINGKUNGAN") !== false || stripos($keyword, "SISTEM") !== false){ $prodi = 3; }
            
            $sql = "SELECT * FROM $nama_tabel WHERE prodi LIKE '%$prodi%' ORDER BY id DESC";
        } else {
            $sql = "SELECT * FROM $nama_tabel WHERE $category LIKE '%$keyword%' ORDER BY id DESC";  
        }
    }

    // Eksekusi query
    $result = $db->query($sql);

    if ($result === false) {
        // Query gagal
        $error_message = '<strong>ERROR QUERY DATABASE:</strong> Gagal mengambil data. Pesan Error: ' . $db->error . ' Query: ' . htmlspecialchars($sql);
    } else {
        // Query berhasil
        $data_dosen = $result; 
        $jumlah_baris = $data_dosen->num_rows; 
    }
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
                                    <td>
                                        <a href="./?p=tambahdosen" class="btn btn-primary" style="width: 150px">
                                            <i class="bi bi-person-plus-fill"></i> +Dosen
                                        </a>
                                    </td>
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
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            
            // Pengecekan data yang aman: Cek jika data_dosen adalah objek dan memiliki baris
            if (is_object($data_dosen) && $data_dosen->num_rows > 0) {
                
                // 🛑 PERBAIKAN KRITIS: Menggunakan while loop dengan fetch_assoc() 🛑
                // Ini memastikan PHP mengambil data baris per baris dengan benar
                while ($dosen = $data_dosen->fetch_assoc()) {
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
                            <a href='./?p=detaildosen&id={$dosen['id']}' class='btn btn-sm btn-info'>Detail</a>
                            <a href='./?p=editdosen&id={$dosen['id']}' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='./?p=hapusdosen&id={$dosen['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin hapus data ini?')\">Hapus</a>
                        </td>
                    </tr>";
                } // END while loop
            } else {
                echo "<tr><td colspan='7' class='text-center'>Data Dosen tidak ditemukan di database.</td></tr>";
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