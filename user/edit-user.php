<?php

session_start();

if(!isset($_SESSION['ssLoginRM'])) {
  header("location: ../autentikasi/index.php");
  exit();
}

require "../config.php";

$title = "Edit User - Rekam Medis";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

$id = $_GET['id'];

$queryUser = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE 
userid = $id");

$user = mysqli_fetch_assoc($queryUser);

?>

    
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h1 class="h2">Edit User</h1>
            <a href="<?= $main_url ?>user" class="text-decoration-none">Kembali</a>
            </div>
         
        <form action="proses-user.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-4 mb-4 text-center"> 
                    <div class="px-4 mb-4">
                        <input type="hidden" name="gbrLama" value="<?=
                        $user['gambar'] ?>">
                        <img src="<?= $main_url ?>asset/gambar/<?=
                        $user['gambar'] ?>" alt="user" class="img-thumbnail mb-3 rounded-circle tampil" width="120px">
                        <input type="file" class="form-control form-control-sm"
                        name="gambar" onchange="imgView()" id="gambar">
                        <span class="text-sm">Type file Gambar JPG | PNG | GIF</span><br>
                        <span class="text-small">Ukuran foto maksimal 1 MB</span>
            </div>
<button type="submit" name="update" class="btn btn-outline-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1z"/>
  <path fill-rule="evenodd" d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z"/>
  </svg>Update</button>
</div>
<div class="col-lg-8">
    <div class="form-group mb-3">
        <input type="hidden" name="id" value="<?= $user
        ['userid'] ?>">
        <input type="hidden" name="usernameLama" 
        value="<?= $user['username'] ?>">
      <label for="username" class="form-label">Username</label>
        <input type="text" name="username" class="form-control"
        id="username" placeholder="masukan username" value="<?= $user
        ['username'] ?>" autocomplete="off" autofocus required>
    </div>
    <div class="form-group mb-3">
      <label for="fullname" class="form-label">Fullname</label>
        <input type="text" name="fullname" class="form-control"
        id="fullname" placeholder="masukan nama lengkap user" value="<?= $user
        ['fullname'] ?>"required>
    </div>
    <div class="form-group mb-3">
      <label for="jabatan" class="form-label">Jabatan</label>
      <select name="jabatan" id="jabatan" class="form-select" required>
        <option value="">-- Pilih Jabatan --</option>
        <option value="1" <?= $user['jabatan'] ==
        1 ? 'selected' : '' ?>>Administrator</option>
        <option value="2"  <?= $user['jabatan'] ==
        2 ? 'selected' : '' ?>>Petugas</option>
        <option value="3"  <?= $user['jabatan'] ==
        3 ? 'selected' : '' ?>>Dokter</option>
      </select>
    </div>
    <div class="form-group mb-3">
      <label for="alamat" class="form-label">Alamat</label>
       <textarea name="alamat" id="alamat" cols="" rows="3"
       class="form-control" placeholder="masukan alamat user"><?= $user
        ['alamat'] ?></textarea>
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