<?php
session_start();

// Pastikan hanya user login yang bisa akses
if (!isset($_SESSION['ssLoginRM'])) {
    header("location: ../autentikasi/index.php");
    exit();
}

require "../config.php";

// tambah pasien baru
if (isset($_POST['simpan'])) {
    $nama     = trim(htmlspecialchars($_POST['nama']));
    $tglLahir = $_POST['tgl_lahir']; 
    $gender   = $_POST['gender'];
    $telpon   = trim(htmlspecialchars($_POST['telpon']));
    $alamat   = trim(htmlspecialchars($_POST['alamat']));
    $id       = date('ymdhis');


$query = "INSERT INTO tb_pasien (id, nama, tgl_lahir, gender, telpon, alamat)
          VALUES ('$id', '$nama', '$tglLahir', '$gender', '$telpon', '$alamat')";


    if (!mysqli_query($koneksi, $query)) {
        die("Insert gagal: " . mysqli_error($koneksi));
    }

    echo "<script>
            alert('Pasien baru berhasil diregistrasi!');
            window.location = 'index.php';
          </script>";
    exit;
}

if (@$_GET['aksi'] == 'hapus-pasien') {
    $id = $_GET['id'];

    mysqli_query($koneksi, "DELETE FROM tb_pasien WHERE id = '$id'");

    echo "<script>
                    alert('Pasien berhasil dihapus !');
                    window.location = 'index.php';
        </script>";
    return;
}

// Update Pasien Baru
if (isset($_POST['update'])) {
    $nama     = trim(htmlspecialchars($_POST['nama']));
    $tglLahir = $_POST['tgl_lahir']; 
    $gender   = $_POST['gender'];
    $telpon   = trim(htmlspecialchars($_POST['telpon']));
    $alamat   = trim(htmlspecialchars($_POST['alamat']));
    $id       = trim(htmlspecialchars($_POST['id']));


mysqli_query($koneksi, "UPDATE tb_pasien SET 
                        nama = '$nama',
                        tgl_lahir = '$tglLahir',
                        gender = '$gender',
                        telpon = '$telpon',
                        alamat = '$alamat'
                        WHERE id = '$id'");
    echo "<script>
            alert('Data pasien berhasil diperbarui!');
            window.location = 'index.php';
          </script>";
    exit;
}