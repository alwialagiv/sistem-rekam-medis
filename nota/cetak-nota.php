
<?php
session_start();

if (!isset($_SESSION['ssLoginRM'])) {
    header("Location: ../autentikasi/index.php");
    exit();
}

require "../config.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit("ID transaksi tidak valid.");
}

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT b.*, p.nama AS nama_pasien, p.alamat
     FROM tb_pembayaran b
     LEFT JOIN tb_pasien p ON p.id = b.id_pasien
     WHERE b.id = ?"
);

if (!$stmt) {
    exit("Query gagal: " . htmlspecialchars(mysqli_error($koneksi)));
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    exit("Data pembayaran tidak ditemukan.");
}

function rupiah($angka) {
    return "Rp " . number_format((float)$angka, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nota Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            color: #222;
        }
        h2, .center { text-align: center; }
        .nota {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .nota th, .nota td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .actions { margin-top: 25px; }
        button, .back {
            padding: 10px 15px;
            margin-right: 8px;
            cursor: pointer;
        }
        @media print {
            .actions { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <h2>NOTA PEMBAYARAN</h2>
    <p class="center">Aplikasi Rekam Medis</p>
    <hr>

    <p><strong>Nomor Transaksi:</strong> <?= (int)$data['id'] ?></p>
    <p><strong>Tanggal:</strong>
        <?= htmlspecialchars($data['tanggal']) ?></p>
    <p><strong>Nama Pasien:</strong>
        <?= htmlspecialchars($data['nama_pasien'] ?? '-') ?></p>
    <p><strong>Alamat:</strong>
        <?= htmlspecialchars($data['alamat'] ?? '-') ?></p>

    <table class="nota">
        <tr>
            <th>Biaya Pemeriksaan</th>
            <td><?= rupiah($data['biaya_pemeriksaan']) ?></td>
        </tr>
        <tr>
            <th>Biaya Obat</th>
            <td><?= rupiah($data['biaya_obat']) ?></td>
        </tr>
        <tr>
            <th>Total Biaya</th>
            <td><strong><?= rupiah($data['total_biaya']) ?></strong></td>
        </tr>
        <tr>
            <th>Jumlah Dibayar</th>
            <td><?= rupiah($data['jumlah_bayar']) ?></td>
        </tr>
        <tr>
            <th>Metode Pembayaran</th>
            <td><?= htmlspecialchars($data['metode_pembayaran']) ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= htmlspecialchars($data['status_pembayaran']) ?></td>
        </tr>
    </table>

    <?php if (!empty($data['keterangan'])) { ?>
        <p><strong>Keterangan:</strong>
            <?= htmlspecialchars($data['keterangan']) ?></p>
    <?php } ?>

    <p class="center">Terima kasih.</p>

    <div class="actions">
        <button onclick="window.print()">Cetak Nota</button>
        <a class="back" href="index.php">Kembali</a>
    </div>

</body>
</html>
