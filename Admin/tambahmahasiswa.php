<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-sm-6"><h3 class="mb-0">Dashboard tambah mahasiswa</h3></div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard admin</li>
                </ol>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-12">
                <!--begin::Card-->
                <div class="card">
                  <!--begin::Card Header-->
                  <div class="card-header">
                    <!--begin::Card Title-->
                    <h3 class="card-title">Tambah Mahasiswa</h3>
                    <!--end::Card Title-->
                    <!--begin::Card Toolbar-->
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                      <button
                        type="button"
                        class="btn btn-tool"
                        data-lte-toggle="card-remove"
                        title="Remove"
                      >
                        <i class="bi bi-x-lg"></i>
                      </button>
                    </div>
                    <!--end::Card Toolbar-->
                  </div>
                  <!--end::Card Header-->
                  <!--begin::Card Body-->
                  <div class="card-body">
                    <!--begin::Row-->
                    <div class="row">
                      <!--begin::Col-->
                      <div class="col-md-3">

<?php
if($_POST['simpan']){
  $nim = $_POST['nim'];
  $nama = $_POST['nama'];
  $jk = $_POST['jk'];
  $alamat = $_POST['alamat'];
  $prodi = $_POST['prodi'];

  require_once "../config.php";
  $waktu = date("Y-m-d H:i:s");
  $sql="insert into mhs set nim='$nim', nama='$nama', gender='$jk', alamat='$alamat', prodi='$prodi', waktu='$waktu'";
  $tes=$db->query($sql);
  if($tes){
    echo "<div class='alert alert-success'>Data berhasil disimpan.<br>
    <a href='./?p=mahasiswa>Lihat Data</a></div>";
  }
}
?>
                         
<form method="post" action="#">
    <table>
        <tr>
            <td>NIM</td>
            <td><input type="number" name="nim" class="form-control" value="<?=$nim?>"></td>
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
        </tr>
        <tr>
            <td valign="top">Alamat</td>
            <td><textarea name="alamat" class="form-control" style="width:300px">
            <?=$alamat?>
            </textarea></td>
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
            <td><button type="submit" name="simpan" value="Simpan" class="btn btn-success">Simpan</button></td>
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