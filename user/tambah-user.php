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

$title = "Tambah User - Rekam Medis";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

?>

    
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h1 class="h2">User Baru</h1>
            <a href="<?= $main_url ?>user" class="text-decoration-none">Kembali</a>
            </div>
         
        <form action="proses-user.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-4 mb-4 text-center"> 
                    <div class="px-4 mb-4">
                        <img src="<?= $main_url ?>asset/gambar/default-user.png" alt="user" 
                        class="img-thumbnail mb-3 rounded-circle tampil" width="120px">
                        <input type="file" class="form-control form-control-sm"
                        name="gambar" onchange="imgView()" id="gambar">
                        <span class="text-sm">Type file Gambar JPG | PNG | GIF</span><br>
                        <span class="text-small">Ukuran foto maksimal 1 MB</span>
            </div>
<button type="reset" class="btn btn-outline-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x align" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg>Reset </button>

<button type="submit" name="simpan" class="btn btn-outline-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1z"/>
  <path fill-rule="evenodd" d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z"/>
  </svg>Simpan</button>
</div>
<div class="col-lg-8">
    <div class="form-group mb-3">
      <label for="username" class="form-label">Username</label>
        <input type="text" name="username" class="form-control"
        id="username" placeholder="masukan username" autocomplete="off"
        autofocus required>
    </div>
    <div class="form-group mb-3">
      <label for="fullname" class="form-label">Fullname</label>
        <input type="text" name="fullname" class="form-control"
        id="fullname" placeholder="masukan nama lengkap user" required>
    </div>
    <div class="form-group mb-3">
      <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control"
        id="password" placeholder="masukan password" required>
    </div>
    <div class="form-group mb-3">
      <label for="password2" class="form-label">Konfirmasi password</label>
        <input type="password" name="password2" class="form-control"
        id="password2" placeholder="masukan password lagi" required>
    </div>
    <div class="form-group mb-3">
      <label for="jabatan" class="form-label">Jabatan</label>
      <select name="jabatan" id="jabatan" class="form-select" required>
        <option value="">-- Pilih Jabatan --</option>
        <option value="1">Administrator</option>
        <option value="2">Petugas</option>
        <option value="3">Dokter</option>
      </select>
    </div>
    <div class="form-group mb-3">
      <label for="alamat" class="form-label">Alamat</label>
       <textarea name="alamat" id="alamat" cols="" rows="3"
       class="form-control" placeholder="masukan alamat user"></textarea>
    </div>
</form>

        </main>
        <script>
          function imgView() {
            let gambar = document.getElementById('gambar');
            let tampil = document.querySelector('.tampil');

            let fileReader = new FileReader();
            fileReader.readAsDataURL(gambar.files[0]);

            fileReader.addEventListener('load', (e) => {
              tampil.src = e.target.result;
            })
          }
        </script>
 
<?php        
require "../template/footer.php";

?>