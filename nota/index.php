
<?php
session_start();

if (!isset($_SESSION['ssLoginRM'])) {
    header("location: ../autentikasi/index.php");
    exit();
}

require "../config.php";

$title = "Nota Pembayaran - Rekam Medis";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

$queryNota = mysqli_query(
    $koneksi,
    "SELECT b.*, p.nama AS nama_pasien
     FROM tb_pembayaran b
     LEFT JOIN tb_pasien p ON p.id = b.id_pasien
     ORDER BY b.id DESC"
);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Nota Pembayaran</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Nama Pasien</th>
                    <th>Total Biaya</th>
                    <th>Dibayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;

                while ($nota = mysqli_fetch_assoc($queryNota)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= (int)$nota['id'] ?></td>
                        <td><?= htmlspecialchars($nota['tanggal']) ?></td>
                        <td><?= htmlspecialchars($nota['nama_pasien'] ?? '-') ?></td>
                        <td>Rp <?= number_format($nota['total_biaya'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($nota['jumlah_bayar'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($nota['status_pembayaran'] === 'Lunas') { ?>
                                <span class="badge bg-success">Lunas</span>
                            <?php } else { ?>
                                <span class="badge bg-warning text-dark">Belum Lunas</span>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="cetak-nota.php?id=<?= (int)$nota['id'] ?>"
                               class="btn btn-sm btn-outline-primary"
                               target="_blank">
                                Lihat Nota
                            </a>
                        </td>
                    </tr>
                <?php } ?>

                <?php if ($no === 1) { ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            Belum ada transaksi pembayaran.
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<?php require "../template/footer.php"; ?>
