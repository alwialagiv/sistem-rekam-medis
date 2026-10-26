<?php

session_start();

if(!isset($_SESSION['ssLoginRM'])) {
  header("location: index.php");
  exit();
}


require "../config.php";

$title = "Password - Rekam Medis";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";


?>

    
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap 
            align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Ganti Password</h1>
            </div> 

            <form action="../user/proses-user.php" method="post">
                <div class="form-group mb-3 col-6">
                    <label for="oldPass" class="form-label">Password Lama</label>
                    <input type="password" name="oldPass"
                    class="form-control" id="oldPass" placeholder="Masukan password lama" autocomplete="off" required>
                </div>
                <form action="../user/proses-user.php" method="post">
                <div class="form-group mb-3 col-6">
                    <label for="newPass" class="form-label">Password Baru</label>
                    <input type="password" name="newPass"
                    class="form-control" id="newPass" placeholder="Masukan password baru" autocomplete="off" required>
                </div>
                <form action="../user/proses-user.php" method="post">
                <div class="form-group mb-3 col-6">
                    <label for="confPass" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="confPass"
                    class="form-control" id="confPass" placeholder="Masukan kembali password baru" autocomplete="off" required>
                </div>
                <button type="reset" class="btn btn-outline-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x align" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>Reset </button>

                <button type="submit" name="ganti-password" class="btn btn-outline-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1z"/>
                <path fill-rule="evenodd" d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708z"/>
                </svg>Simpan</button>
            </form>
        </main>

 
<?php        
require "../template/footer.php";

?>