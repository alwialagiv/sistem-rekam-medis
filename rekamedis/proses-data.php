<?php
session_start();

// Pastikan hanya user login yang bisa akses
if (!isset($_SESSION['ssLoginRM'])) {
    header("location: ../autentikasi/index.php");
    exit();
}

require "../config.php";

// tambah data Rekam Medis
if (isset($_POST['simpan'])) {
    $no_rm     = $_POST['no_rm'];
    $tgl       = $_POST['tgl_rm'];
    $idpasien  = $_POST['id_pasien'];
    $keluhan   = trim(htmlspecialchars($_POST['keluhan']));
    $dokter    = $_POST['dokter'];
    $diagnosa  = trim(htmlspecialchars($_POST['diagnosa']));
    $obat      = trim(htmlspecialchars($_POST['obat']));

    $query = "INSERT INTO tb_rekamedis 
              (no_rm, tgl_rm, id_pasien, keluhan, id_dokter, diagnosa, obat)
              VALUES 
              ('$no_rm', '$tgl', '$idpasien', '$keluhan', '$dokter', '$diagnosa', '$obat')";

    if (!mysqli_query($koneksi, $query)) {
        die("Insert gagal: " . mysqli_error($koneksi));
    }

    header('location: tambah-data.php?msg=added');
    exit;
}


// hapus data

if (@$_GET['aksi'] == 'hapus-data') {
    $id = $_GET['id'];

    mysqli_query($koneksi, "DELETE FROM tb_rekamedis WHERE no_rm = '$id'");

    header('location: index.php?msg=deleted');
    return;
}

//update data
if (isset($_POST['update'])) {
    $no_rm     = $_POST['no_rm'];
    $tgl       = $_POST['tgl_rm'];
    $idpasien  = $_POST['id_pasien'];
    $keluhan   = trim(htmlspecialchars($_POST['keluhan']));
    $dokter    = $_POST['dokter'];
    $diagnosa  = trim(htmlspecialchars($_POST['diagnosa']));
    $obat      = trim(htmlspecialchars($_POST['obat']));

    mysqli_query($koneksi, "UPDATE tb_rekamedis SET
                                    tgl_rm      = '$tgl',
                                    id_pasien   = '$idpasien',
                                    keluhan     = '$keluhan',
                                    id_dokter   = '$dokter',
                                    diagnosa    = '$diagnosa',
                                    obat        = '$obat'
                                    WHERE no_rm = '$no_rm' 
                                    ");

    // redirect kembali ke halaman tambah-obat.php dengan pesan sukses
    header('Location: index.php?msg=updated');
    exit;
}