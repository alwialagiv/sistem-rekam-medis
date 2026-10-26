
<?php
session_start();

if (!isset($_SESSION['ssLoginRM'])) {
    header("location: ../autentikasi/index.php");
    exit();
}

require "../config.php";

$title = "BPJS & Asuransi - Rekam Medis";

if (isset($_POST['simpan'])) {
    $id_pasien = (int) $_POST['id_pasien'];
    $jenis = $_POST['jenis_jaminan'];
    $nama_asuransi = trim($_POST['nama_asuransi']);
    $nomor = trim($_POST['nomor_peserta']);
    $tanggal = $_POST['tanggal_daftar'];
    $status = $_POST['status_peserta'];
    $keterangan = trim($_POST['keterangan']);

    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO tb_asuransi
        (id_pasien, jenis_jaminan, nama_asuransi,
        nomor_peserta, tanggal_daftar, status_peserta, keterangan)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt, "issssss",
        $id_pasien, $jenis, $nama_asuransi,
        $nomor, $tanggal, $status, $keterangan
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
            alert('Data BPJS/Asuransi berhasil disimpan!');
            window.location='index.php';
        </script>";
        exit();
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }
}

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

$dataPasien = mysqli_query(
    $koneksi, "SELECT id, nama FROM tb_pasien ORDER BY nama ASC"
);

$dataAsuransi = mysqli_query(
    $koneksi,
    "SELECT a.*, p.nama AS nama_pasien
     FROM tb_asuransi a
     LEFT JOIN tb_pasien p ON p.id = a.id_pasien
     ORDER BY a.id DESC"
);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
    <div class="d-flex justify-content-between flex-wrap
        flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data BPJS & Asuransi</h1>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Tambah Data BPJS / Asuransi Pasien
        </div>

        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Pasien</label>
                    <select name="id_pasien" class="form-select" required>
                        <option value="">-- Pilih Pasien --</option>
                        <?php while ($p = mysqli_fetch_assoc($dataPasien)) { ?>
                            <option value="<?= (int)$p['id'] ?>">
                                <?= htmlspecialchars($p['nama']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Jaminan</label>
                    <select name="jenis_jaminan" class="form-select" required>
                        <option value="BPJS">BPJS Kesehatan</option>
                        <option value="Asuransi">Asuransi Swasta</option>
                        <option value="Mandiri">Mandiri / Umum</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Nama BPJS / Perusahaan Asuransi
                    </label>
                    <input type="text" name="nama_asuransi"
                        class="form-control"
                        placeholder="Contoh: BPJS Kesehatan atau nama perusahaan">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Peserta</label>
                    <input type="text" name="nomor_peserta"
                        class="form-control"
                        placeholder="Masukkan nomor peserta atau nomor identitas"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pendaftaran</label>
                    <input type="date" name="tanggal_daftar"
                        class="form-control"
                        value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Peserta</label>
                    <select name="status_peserta" class="form-select" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                        <option value="Menunggu">Menunggu Verifikasi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control"
                        rows="2" placeholder="Keterangan tambahan"></textarea>
                </div>

                <button type="submit" name="simpan"
                    class="btn btn-primary">
                    Simpan Data
                </button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Daftar BPJS & Asuransi Pasien</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pasien</th>
                        <th>Jenis</th>
                        <th>Nama Asuransi</th>
                        <th>Nomor Peserta</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($a = mysqli_fetch_assoc($dataAsuransi)) {
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($a['nama_pasien'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($a['jenis_jaminan']) ?></td>
                        <td><?= htmlspecialchars($a['nama_asuransi'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($a['nomor_peserta']) ?></td>
                        <td><?= htmlspecialchars($a['tanggal_daftar']) ?></td>
                        <td><?= htmlspecialchars($a['status_peserta']) ?></td>
                        <td><?= htmlspecialchars($a['keterangan'] ?? '-') ?></td>
                    </tr>
                    <?php } ?>

                    <?php if (mysqli_num_rows($dataAsuransi) == 0) { ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            Belum ada data BPJS atau asuransi.
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require "../template/footer.php"; ?>
