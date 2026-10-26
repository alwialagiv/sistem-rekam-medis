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

$title = "Tambah Obat - Rekam Medis";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";



if (isset($_GET['msg'])) {
  $msg = $_GET['msg'];
} else {
  $msg = '';
}

$alert = '';
if ($msg == 'added') {
  $alert = '
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-check-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0m-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
</svg> Tambah obat baru berhasil!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
?>

    
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
  <div
    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
  >
    <h1 class="h2">Obat Baru</h1>
    <a href="<?= $main_url ?>obat" class="text-decoration-none">Kembali</a>
  </div>

  <form action="proses-obat.php" method="post">
    <div class="row">
      <div class="col-lg-8"> <!-- Semua form dimasukkan di dalam kolom ini -->
        <?php if ($msg !== '') {
          echo $alert;
        } ?>
        <div class="form-group mb-3">
          <label for="nama" class="form-label">Nama Obat</label>
          <input type="text" name="nama" class="form-control" id="nama"
            placeholder="Masukan nama obat" required>
        </div>

        <div class="form-group mb-3">
          <label for="kegunaan" class="form-label">Kegunaan</label>
          <textarea name="kegunaan" id="kegunaan" rows="3"
            class="form-control" placeholder="Masukan kegunaan obat" required></textarea>
        </div>
          <button type="reset" class="btn btn-outline-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x align" viewBox="0 0 16 16">
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
        </svg>Reset </button>

        <button type="submit" name="simpan" class="btn btn-outline-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down" viewBox="0 0 16 16">
         <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1z"/>
        <path fill-rule="evenodd" d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z"/>
        </svg>Simpan</button>
      </div>
    </div> 
  </form>
</main>

 
<?php        
require "../template/footer.php";

?>