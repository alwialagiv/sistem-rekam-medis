<?php


session_start();

if(!isset($_SESSION['ssLoginRM'])) {
  header("location: ../autentikasi/index.php");
  exit();
}

if(!isset($_SESSION['ssLoginRM'])) {
  header("location: ../autentikasi/index.php");
  exit();
}


require "../config.php";

$title = "Edit Pasien - Rekam Medis";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if ($dataUser['jabatan'] == 3) {
    echo "<script>
    alert('Halaman tidak ditemukan..');
    window.location = '../index.php';
    </script>";
    exit();
}


$id = $_GET['id'];

$queryPasien = mysqli_query($koneksi, "SELECT * FROM tb_pasien WHERE id = '$id'");
$pasien = mysqli_fetch_assoc($queryPasien);
?>
    
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
  <div
    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
  >
    <h1 class="h2">Edit Pasien</h1>
    <a href="<?= $main_url ?>pasien" class="text-decoration-none">Kembali</a>
  </div>

  <form action="proses-pasien.php" method="post">
    <div class="row">
      <div class="col-lg-8"> <!-- Semua form dimasukkan di dalam kolom ini -->
        <input type="hidden" name="id" value="<?= $pasien ['id'] ?>">
        <div class="form-group mb-3">
          <label for="nama" class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" id="nama"
            placeholder="Masukan nama pasien" value="<?= $pasien ['nama'] ?>" required>
        </div>

        <div class="form-group mb-3">
          <label for="tgl_lahir" class="form-label">Tgl lahir</label>
          <input type="date" name="tgl_lahir" value="<?= $pasien ['tgl_lahir'] ?>"class="form-control" id="tgl_lahir" required>
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Jenis Kelamin</label>
          <div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" id="pria" value="P" required <?= ($pasien['gender'] == 'P') ? 'checked' : ''; ?>>
              <label class="form-check-label" for="pria">Pria</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" id="wanita" value="W" <?= ($pasien['gender'] == 'W') ? 'checked' : ''; ?>>
              <label class="form-check-label" for="wanita">Wanita</label>
            </div>
          </div>
        </div>

        <div class="form-group mb-3">
          <label for="telpon" class="form-label">Nomor Telepon / HP</label>
          <input type="tel" name="telpon" id="telpon" placeholder="Masukan nomor telepon pasien"
            pattern="[0-9]{8,}" title="minimal 8 angka" class="form-control" id="tgl_lahir" value="<?= $pasien['telpon'] ?>" required>
        </div>

        <div class="form-group mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <textarea name="alamat" id="alamat" rows="3"
            class="form-control" placeholder="Masukan alamat pasien" required><?= $pasien['alamat'] ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-outline-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down" viewBox="0 0 16 16">
         <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1z"/>
        <path fill-rule="evenodd" d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z"/>
        </svg>Update</button>
      </div>
    </div> 
  </form>
</main>

 
<?php        
require "../template/footer.php";

?>