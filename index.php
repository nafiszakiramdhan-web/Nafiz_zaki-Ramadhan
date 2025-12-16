<?php
session_start(); 
$alert = "";

// Cek apakah tombol login ditekan
if (isset($_POST["btnLogin"])) {
    require_once("config.php"); 

    $tuser = mysqli_real_escape_string($db, $_POST['tuser']);
    $tpass = $_POST['tpass'];

    // Query cek user & password (MD5)
    $sql = "SELECT * FROM users WHERE username='$tuser' AND password=md5('$tpass')";
    $hasil = $db->query($sql);
    
   // ... di dalam blok if ($jml > 0) ...
    $data = $hasil->fetch_array();
    
    $_SESSION['isLogin'] = true;
    $_SESSION['user'] = $tuser;
    $_SESSION['level'] = $data['level']; // Kunci: 'admin', 'dosen', atau 'mhs'

    // --- LOGIKA PENGALIHAN BERBASIS PERAN (Perbaikan) ---
    $role = $data['level'];

   if ($role == 'admin') {
        header("location: Admin/"); 
    } else if ($role == 'dosen') {
        header("location: Dosen/");
    } else if ($role == 'mhs') {
        header("location: mahasiswa/");
    } else {
        // Jika level tidak terdaftar
        $alert = "<div class='alert alert-danger alert-dismissible'>...</div>";
        $_SESSION = array(); 
        session_destroy();
    }
    
    exit();

        
    } else {
        // Jika login gagal
        $alert = "<div class='alert alert-danger alert-dismissible'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  <i class='icon fas fa-ban'></i> Username atau Password Salah!
                  </div>";
    }

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIAKAD | Login</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>SIAKAD</b> Login</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silakan login untuk memulai sesi</p>

      <?php echo $alert; ?>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="tuser" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="tpass" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Ingat Saya
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="btnLogin">Sign In</button>
          </div>
          </div>  
      </form>
    </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>