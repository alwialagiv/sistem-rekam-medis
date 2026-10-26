
<?php
session_start();

if (!isset($_SESSION['ssLoginRM'])) {
    header("location: ../autentikasi/index.php");
    exit();
}

require "../config.php";

$title = "Pembayaran - Rekam Medis";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pasien = (int)($_POST['id_pasien'] ?? 0);
    $biaya_pemeriksaan = (float)($_POST['biaya_pemeriksaan'] ?? 0);
    $biaya_obat = (float)($_POST['biaya_obat'] ?? 0);
    $jumlah_bayar = (float)($_POST['jumlah_bayar'] ?? 0);
    $metode = $_POST['metode_pembayaran'] ?? '';
    $keterangan = trim($_POST['keterangan'] ?? '');

    $total = $biaya_pemeriksaan + $biaya_obat;

    if (
        $id_pasien > 0 &&
        $biaya_pemeriksaan >= 0 &&
        $biaya_obat >= 0 &&
        $jumlah_bayar >= 0 &&
        $total > 0 &&
        in_array($metode, ['Tunai', 'Transfer', 'Debit', 'BPJS'], true)
    ) {
        $status = $jumlah_bayar >= $total
            ? 'Lunas'
            : 'Belum Lunas';

        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO tb_pembayaran
            (id_pasien, biaya_pemeriksaan, biaya_obat,
             total_biaya, jumlah_bayar, metode_pembayaran,
             status_pembayaran, keterangan)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "iddddsss",
            $id_pasien,
            $biaya_pemeriksaan,
            $biaya_obat,
            $total,
            $jumlah_bayar,
            $metode,
            $status,
            $keterangan
        );

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                alert('Pembayaran berhasil disimpan!');
                window.location='index.php';
            </script>";
            exit();
        } else {
            echo "<div class='alert alert-danger'>
                Gagal menyimpan pembayaran.
            </div>";
        }
    } else {
        echo "<div class='alert alert-warning'>
            Periksa kembali data pembayaran. Total biaya harus lebih dari nol.
        </div>";
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pembayaran Pasien</h1>
    </div>

    <div class="card mb-4">
        <div class="card-header">Input Pembayaran</div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Pasien</label>
                    <select name="id_pasien" class="form-select" required>
                        <option value="">-- Pilih Pasien --</option>
                        <?php
                        $daftarPasien = mysqli_query(
                            $koneksi,
                            "SELECT id, nama FROM tb_pasien ORDER BY nama"
                        );

                        while ($p = mysqli_fetch_assoc($daftarPasien)) {
                        ?>
                            <option value="<?= (int)$p['id'] ?>">
                                <?= htmlspecialchars($p['nama']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Biaya Pemeriksaan (Rp)</label>
                    <input type="number" name="biaya_pemeriksaan"
                        class="form-control" min="0" step="1000"
                        value="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Biaya Obat (Rp)</label>
                    <input type="number" name="biaya_obat"
                        class="form-control" min="0" step="1000"
                        value="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Dibayar (Rp)</label>
                    <input type="number" name="jumlah_bayar"
                        class="form-control" min="0" step="1000"
                        value="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="metode_pembayaran"
                        class="form-select" required>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Debit">Debit</option>
                        <option value="BPJS">BPJS</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control"
                        rows="2"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Pembayaran
                </button>
            </form>
        </div>
    </div>

    <h4 class="mb-3">Riwayat Pembayaran</h4>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Pasien</th>
                    <th>Total</th>
                    <th>Dibayar</th>
                    <th>Status</th>
                    <th>Metode</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $riwayat = mysqli_query(
                    $koneksi,
                    "SELECT b.*, p.nama AS nama_pasien
                     FROM tb_pembayaran b
                     LEFT JOIN tb_pasien p ON p.id = b.id_pasien
                     ORDER BY b.id DESC"
                );

                while ($r = mysqli_fetch_assoc($riwayat)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($r['tanggal']) ?></td>
                        <td><?= htmlspecialchars($r['nama_pasien'] ?? '-') ?></td>
                        <td>Rp <?= number_format($r['total_biaya'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($r['jumlah_bayar'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($r['status_pembayaran']) ?></td>
                        <td><?= htmlspecialchars($r['metode_pembayaran']) ?></td>
                    </tr>
                <?php } ?>

                <?php if ($no === 1) { ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada transaksi pembayaran.
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<?php require "../template/footer.php"; ?>
