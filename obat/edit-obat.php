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

$title = "Edit Obat - Rekam Medis";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";
/** @var mysqli $koneksi */
/** @var string $main_url */

$id = $_GET['id'];

$queryObat = mysqli_query($koneksi, "SELECT * FROM tb_obat WHERE id = $id");
$obat = mysqli_fetch_assoc($queryObat);

?>

    
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
  <div
    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
  >
    <h1 class="h2">Edit Obat</h1>
    <a href="<?= $main_url ?>obat" class="text-decoration-none">Kembali</a>
  </div>

  <form action="proses-obat.php" method="post">
    <div class="row">
      <div class="col-lg-8"> <!-- Semua form dimasukkan di dalam kolom ini -->
        <div class="form-group mb-3">
          <input type="hidden" name="id" value="<?= $obat['id'] ?>">
          <label for="nama" class="form-label">Nama Obat</label>
          <input type="text" name="nama" class="form-control" id="nama"
            placeholder="Masukan nama obat" value="<?= $obat['nama'] ?>"required>
        </div>

        <div class="form-group mb-3">
          <label for="kegunaan" class="form-label">Kegunaan</label>
          <textarea name="kegunaan" id="kegunaan" rows="3"
            class="form-control" placeholder="Masukan kegunaan obat" required><?= $obat['kegunaan'] ?></textarea>
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