<?php
session_start();

// Cek sesi login
if (!isset($_SESSION['ssLoginRM'])) {
    header("location: ../autentikasi/index.php");
    exit();
}

// Panggil file konfigurasi dan template
require "../config.php";
$title = "edit data - Rekam Medis";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";


$id = $_GET['id'];
$sqlrm = "SELECT *, tb_pasien.alamat AS alamatpasien FROM tb_rekamedis INNER JOIN tb_pasien ON tb_rekamedis.id_pasien
                = tb_pasien.id INNER JOIN tb_user ON tb_rekamedis.id_dokter = 
                tb_user.userid WHERE no_rm = '$id'";
                $queryrm = mysqli_query($koneksi, $sqlrm);
                ($rm = mysqli_fetch_assoc($queryrm));

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Data Perekaman</h1>
        <a href="<?= $main_url ?>rekamedis" class="text-decoration-none">Kembali</a>
    </div>

    <form action="proses-data.php" method="post">
        <div class="row">
            <div class="col-lg-6 pe-4">
                <div class="form-group mb-3">
                    <label for="no-rm" class="form-label">No Rekam Medis</label>
                    <input type="text" name="no_rm" class="form-control" id="no-rm" value="<?= $rm ['no_rm'] ?>" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="tgl_rm" class="form-label">Tanggal Perekaman</label>
                    <input type="date" name="tgl_rm" class="form-control" id="tgl_rm" value="<?= $rm ['tgl_rm'] ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="pasien" class="form-label">Pasien</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="pasien_id" name="id_pasien" placeholder="ID Pasien" value="<?= $rm ['id_pasien'] ?>" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="cari" data-bs-toggle="modal" data-bs-target="#modalPasien">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <input type="text" id="namaPasien" class="form-control border-0 border-bottom mb-3" placeholder="Nama pasien" value="<?= $rm ['nama'] ?>"readonly>
                <textarea id="alamatPasien" class="form-control border-0 border-bottom mb-3" placeholder="Alamat pasien" rows="1" readonly><?= $rm ['alamatpasien'] ?></textarea>

                <div class="form-group mb-4">
                    <label for="keluhan" class="form-label">Keluhan</label>
                    <textarea name="keluhan" id="keluhan" class="form-control" placeholder="Keluhan pasien tentang penyakitnya" required><?= $rm ['keluhan'] ?></textarea>
                </div>
            </div>

            <div class="col-lg-6 border-start ps-4">
    <div class="form-group mb-4">
        <label for="dokter" class="form-label">Dokter</label>
        <select name="dokter" id="dokter" class="form-select" required>
            <?php
            // Asumsi $koneksi dan $rm sudah ada
            $queryDokter = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE jabatan = 3");
            while ($data = mysqli_fetch_assoc($queryDokter)) { ?>
            
                <option value="<?= $data['userid'] ?>" <?= $data['userid'] == $rm['id_dokter'] ? 'selected' : '' ?>><?= $data['fullname'] ?></option>
                <?php } ?>
            </select>
            </div>

                <div class="form-group mb-4">
                    <label for="diagnosa" class="form-label">Diagnosa</label>
                    <textarea name="diagnosa" id="diagnosa" class="form-control" placeholder="Hasil diagnosa dokter" required><?= $rm ['diagnosa'] ?></textarea>
                </div>

                <div class="form-group mb-4">
                    <label for="obat" class="form-label">Obat</label>
                    <input type="text" id="tokenfield" value="<?= $rm ['obat'] ?>"name="obat" class="form-control" list="obat-list">
                    
                    <datalist id="obat-list">
                        <?php
                        $queryObat = mysqli_query($koneksi, "SELECT * FROM tb_obat");
                        while ($data = mysqli_fetch_assoc($queryObat)) {
                            echo "<option value='" . htmlspecialchars($data['nama']) . "'>";
                        }
                        ?>
                    </datalist>
                </div>

                <button type="submit" name="update" class="btn btn-outline-primary btn-sm"> Update Data
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                        <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1z"/>
                    </svg> 
                </button>
            </div>
        </div>
    </form>

    <div class="modal fade" id="modalPasien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cari Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pasien</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $queryPasien = mysqli_query($koneksi, "SELECT * FROM tb_pasien");
                            while ($pasien = mysqli_fetch_assoc($queryPasien)) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $pasien['id'] ?></td>
                                    <td><?= $pasien['nama'] ?></td>
                                    <td><?= $pasien['alamat'] ?></td>
                                    <td>
                                        <button type="button" title="pilih pasien"
                                            data-id="<?= $pasien['id'] ?>" 
                                            data-namapasien="<?= $pasien['nama'] ?>"
                                            data-address="<?= $pasien['alamat'] ?>" 
                                            class="btn btn-sm btn-outline-primary cekPasien"
                                            data-bs-dismiss="modal"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap5-tags@1.4.0/dist/bootstrap5-tags.min.js"></script>

<script>
$(document).ready(function () {
    // === Fungsi untuk memilih pasien dari modal ===
    $(document).on('click', '.cekPasien', function () {
        // Ambil data dari tombol yang diklik
        let pasienID = $(this).data('id');
        let pasienName = $(this).data('namapasien');
        let pasienAddress = $(this).data('address');

        // Masukkan data ke dalam form di halaman utama
        $('#pasien_id').val(pasienID);
        $('#namaPasien').val(pasienName);
        $('#alamatPasien').val(pasienAddress);
    });

    // === Inisialisasi Tags Input dengan plugin BARU ===
    new Tags(document.querySelector('#tokenfield'), {
        keys: ['Enter', ','],
        allowDuplicates: false 
    });
});
</script>

<?php
// Panggil file footer
require "../template/footer.php";
?>