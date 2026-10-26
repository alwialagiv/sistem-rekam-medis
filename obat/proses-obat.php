<?php
session_start();

// Pastikan hanya user login yang bisa akses
if (!isset($_SESSION['ssLoginRM'])) {
    header("location: ../autentikasi/index.php");
    exit();
}

require "../config.php";

// tambah obat baru
if (isset($_POST['simpan'])) {
    $nama     = trim(htmlspecialchars($_POST['nama']));
    $kegunaan     = trim(htmlspecialchars($_POST['kegunaan']));

$query = "INSERT INTO tb_obat (id, nama, kegunaan)
          VALUES ('$id', '$nama', '$kegunaan')";


    if (!mysqli_query($koneksi, $query)) {
        die("Insert gagal: " . mysqli_error($koneksi));
    }
    header('location: tambah-obat.php?msg=added');
    exit;
}

// hapus obat 

if (@$_GET['aksi'] == 'hapus-obat') {
    $id = $_GET['id'];

    mysqli_query($koneksi, "DELETE FROM tb_obat WHERE id = $id");

    header('location: index.php?msg=deleted');
    return;
}

//update obat 
if (isset($_POST['update'])) {
    // ambil data dari form edit
    $id       = intval($_POST['id']);
    $nama     = trim(htmlspecialchars($_POST['nama']));
    $kegunaan = trim(htmlspecialchars($_POST['kegunaan']));

    // buat query
    $query = "UPDATE tb_obat 
              SET nama = '$nama', kegunaan = '$kegunaan' 
              WHERE id = $id";

    // eksekusi query
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Update gagal: " . mysqli_error($koneksi));
    }

    // redirect kembali ke halaman tambah-obat.php dengan pesan sukses
    header('Location: index.php?msg=updated');
    exit;
}