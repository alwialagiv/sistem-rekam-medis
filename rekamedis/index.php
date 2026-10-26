<?php

session_start();

if(!isset($_SESSION['ssLoginRM'])) {
  header("location: ../autentikasi/index.php");
  exit();
}


require "../config.php";

$title = "Data - Rekam Medis";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if (isset($_GET['msg'])) {
  $msg = $_GET['msg'];
} else {
  $msg = '';
}

$alert = '';
if ($msg == 'deleted') {
  $alert = '
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-check-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0m-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
</svg> Hapus data rekam medis berhasil!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
if ($msg == 'updated') {
  $alert = '
  <div class="alert alert-success alert-dismissible fade show updated" role="alert">
    <strong><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-check-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0m-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
</svg> Edit data rekam berhasil!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}

?>

    
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h1 class="h2">Data Rekam Medis</h1>
            </div> 
            <?php 
            if ($msg !== ''){
                echo $alert;
            }
            ?>
            <a href="<?= $main_url ?>rekamedis/tambah-data.php" class="btn btn-outline-secondary
            btn-sm mb-3" title="tambah data"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>Data Perekaman</a>

            <table class="table table-responsive table-hover" id="myTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tgl</th>
                  <th>Pasien</th>
                  <th>Alamat</th>
                  <th>Keluhan</th>
                  <th>Dokter</th>
                  <th>Diagnosa</th>
                  <th>Obat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $sqlrm = "SELECT *, tb_pasien.alamat AS alamatpasien FROM tb_rekamedis INNER JOIN tb_pasien ON tb_rekamedis.id_pasien
                = tb_pasien.id INNER JOIN tb_user ON tb_rekamedis.id_dokter = 
                tb_user.userid order by tgl_rm desc";
                $queryrm = mysqli_query($koneksi, $sqlrm);
                while ($rm = mysqli_fetch_assoc($queryrm)) { ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= in_date($rm['tgl_rm']) ?></td>
                    <td><?= $rm['nama'] ?></td>
                    <td><?= $rm['alamatpasien'] ?></td>
                    <td><?= $rm['keluhan'] ?></td>
                    <td><?= ($rm['fullname']) ?></td>
                    <td><?= ($rm['diagnosa']) ?></td>
                    <td><?= ($rm['obat']) ?></td>
                    <td>
                          <a href="edit-data.php?id=<?= $rm
                          ['no_rm'] ?>" class="btn btn-sm
                          btn-outline-warning" title="edit data"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                          <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                          </svg></a>
                          <a href="proses-data.php?id=<?= $rm
                          ['no_rm'] ?>&aksi=hapus-data" 
                          onclick="return confirm('Anda yakin ingin menghapus data ini?')"
                          class="btn btn-sm btn-outline-danger" 
                          title="hapus data"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                         <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                        </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

        </main>

        <script>
            window.setTimeout(function() {
                $('.updated').fadeOut();
            }, 3000)
        </script>

 
<?php        
require "../template/footer.php";

?>