<?php

session_start();

if(!isset($_SESSION['ssLoginRM'])) {
  header("location: ../autentikasi/index.php");
  exit();
}


require "../config.php";

$title = "Pasien - Rekam Medis";

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

?>

    
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h1 class="h2">Data Pasien</h1>
           
            </div> 

            <a href="<?= $main_url ?>pasien/tambah-pasien.php" class="btn btn-outline-secondary
            btn-sm mb-3" title="tambah pasien baru"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>Pasien Baru</a>

            <table class="table table-responsive table-hover" id="myTable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>ID Pasien</th>
                  <th>Nama</th>
                  <th>Tgl Lahir</th>
                  <th>Jenis Kelamin</th>
                  <th>Telepon</th>
                  <th>Alamat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $queryPasien = mysqli_query($koneksi, "SELECT * FROM tb_pasien");
                while ($pasien = mysqli_fetch_assoc($queryPasien)) { ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $pasien['id'] ?></td>
                    <td><?= $pasien['nama'] ?></td>
                    <td><?= in_date($pasien['tgl_lahir'])  ?></td>
                    <td>
                      <?php 
                        if ($pasien['gender'] == 'P') {
                            echo 'Pria';
                        } else {
                          echo 'Wanita';
                        }
                      ?>
                    </td>
                        <td><?= $pasien['telpon']?></td>
                        <td><?= $pasien['alamat']?></td>
                        <td>
                          <a href="edit-pasien.php?id=<?= $pasien
                          ['id'] ?>" class="btn btn-sm
                          btn-outline-warning" title="edit pasien"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                          <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                          </svg></a>
                          <a href="proses-pasien.php?id=<?= $pasien
                          ['id'] ?>&aksi=hapus-pasien" 
                          onclick="return confirm('Anda yakin ingin menghapus pasien ini?')"
                          class="btn btn-sm btn-outline-danger" 
                          title="hapus pasien"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                         <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                        </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

        </main>

 
<?php        
require "../template/footer.php";

?>