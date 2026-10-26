
<?php
session_start();

if (!isset($_SESSION['ssLoginRM'])) {
    header("location: ../autentikasi/index.php");
    exit();
}

require "../config.php";

$title = "Laporan Dokter - Rekam Medis";

$tanggalAwal = $_GET['awal'] ?? date('Y-m-01');
$tanggalAkhir = $_GET['akhir'] ?? date('Y-m-d');

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalAwal)) {
    $tanggalAwal = date('Y-m-01');
}
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalAkhir)) {
    $tanggalAkhir = date('Y-m-d');
}

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

$stmt = mysqli_prepare($koneksi, "
    SELECT r.no_rm, r.tgl_rm, r.keluhan, r.diagnosa, r.obat,
           p.nama AS nama_pasien,
           u.fullname AS nama_dokter
    FROM tb_rekamedis r
    LEFT JOIN tb_pasien p ON p.id = r.id_pasien
    LEFT JOIN tb_user u ON u.userid = r.id_dokter
    WHERE r.tgl_rm BETWEEN ? AND ?
    ORDER BY r.tgl_rm DESC, r.no_rm DESC
");

mysqli_stmt_bind_param($stmt, "ss", $tanggalAwal, $tanggalAkhir);
mysqli_stmt_execute($stmt);
$dataLaporan = mysqli_stmt_get_result($stmt);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
    <div class="d-flex justify-content-between align-items-center
        flex-wrap pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Laporan Dokter</h1>
        <button onclick="window.print()" class="btn btn-success">
            Cetak Laporan
        </button>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="awal" class="form-control"
                        value="<?= htmlspecialchars($tanggalAwal) ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="akhir" class="form-control"
                        value="<?= htmlspecialchars($tanggalAkhir) ?>" required>
                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        Tampilkan
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Periode <?= htmlspecialchars($tanggalAwal) ?>
            sampai <?= htmlspecialchars($tanggalAkhir) ?>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No. Rekam Medis</th>
                        <th>Tanggal</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Keluhan</th>
                        <th>Diagnosis</th>
                        <th>Obat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($r = mysqli_fetch_assoc($dataLaporan)) {
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($r['no_rm']) ?></td>
                        <td><?= htmlspecialchars($r['tgl_rm']) ?></td>
                        <td><?= htmlspecialchars($r['nama_pasien'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($r['nama_dokter'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($r['keluhan'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($r['diagnosa'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($r['obat'] ?? '-') ?></td>
                    </tr>
                    <?php } ?>

                    <?php if (mysqli_num_rows($dataLaporan) == 0) { ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            Tidak ada data pemeriksaan pada periode ini.
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <p class="mt-3 mb-0">
                <strong>Total data pemeriksaan:</strong>
                <?= mysqli_num_rows($dataLaporan) ?> data
            </p>
        </div>
    </div>
</main>

<style>
@media print {
    nav, aside, .sidebar, form, button, .btn {
        display: none !important;
    }
    main {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .card {
        border: none !important;
    }
    body {
        font-size: 10px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #000 !important;
        padding: 4px !important;
    }
}
</style>

<?php require "../template/footer.php"; ?>
