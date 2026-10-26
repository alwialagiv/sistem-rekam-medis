<?php
session_start();

// Pastikan hanya user login yang bisa akses
if (!isset($_SESSION['ssLoginRM'])) {
    header("location: ../autentikasi/index.php");
    exit();
}

require "../config.php";

// ========================
// TAMBAH USER
// ========================
if (isset($_POST['simpan'])) {
    $username  = trim(htmlspecialchars($_POST['username']));
    $nama      = trim(htmlspecialchars($_POST['fullname']));
    $jabatan   = $_POST['jabatan'];
    $alamat    = trim(htmlspecialchars($_POST['alamat']));
    $gambar    = htmlspecialchars($_FILES['gambar']['name']);
    $password  = trim(htmlspecialchars($_POST['password']));
    $password2 = trim(htmlspecialchars($_POST['password2']));

    // Cek username unik
    $cekUsername = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username = '$username'");
    if (mysqli_num_rows($cekUsername)) {
        echo "<script>
                alert('Username sudah terpakai!');
                window.location = 'tambah-user.php';
              </script>";
        exit;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
                window.location = 'tambah-user.php';
              </script>";
        exit;
    }

    $pass = password_hash($password, PASSWORD_DEFAULT);

    // Upload gambar atau pakai default
    if ($gambar != null) {
        $url = 'tambah-user.php';
        $gambar = uploadGbr($url);
    } else {
        $gambar = 'default-user.png';
    }

    $query = "INSERT INTO tb_user (userid, username, fullname, password, jabatan, alamat, gambar) 
              VALUES (NULL, '$username', '$nama', '$pass', '$jabatan', '$alamat', '$gambar')";

    if (!mysqli_query($koneksi, $query)) {
        die("Insert gagal: " . mysqli_error($koneksi));
    }

    echo "<script>
            alert('User baru berhasil diregistrasi!');
            window.location = 'index.php';
          </script>";
    exit;
}

// ========================
// UPDATE USER
// ========================
if (isset($_POST['update'])) {
    $id        = $_POST['id'];
    $username  = trim(htmlspecialchars($_POST['username']));
    $userLama  = trim(htmlspecialchars($_POST['usernameLama']));
    $nama      = trim(htmlspecialchars($_POST['fullname']));
    $jabatan   = $_POST['jabatan'];
    $alamat    = trim(htmlspecialchars($_POST['alamat']));
    $gambar    = htmlspecialchars($_FILES['gambar']['name']);
    $gbrLama   = htmlspecialchars($_POST['gbrLama']);

    // Cek jika username diganti, harus unik
    if ($username !== $userLama) {
        $cekUsername = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username = '$username'");
        if (mysqli_num_rows($cekUsername)) {
            echo "<script>
                    alert('Username sudah terpakai!');
                    window.location = 'index.php';
                  </script>";
            exit;
        }
    }

    // Upload gambar baru kalau ada
    if ($gambar != null) {
        $url = 'index.php';
        $gbrUser = uploadGbr($url);
        if ($gbrLama !== 'default-user.png') {
            @unlink('../asset/gambar/' . $gbrLama);
        }
    } else {
        $gbrUser = $gbrLama;
    }

    $query = "UPDATE tb_user SET 
                username = '$username',
                fullname = '$nama',
                jabatan  = '$jabatan',
                alamat   = '$alamat',
                gambar   = '$gbrUser'
              WHERE userid = $id";

    if (!mysqli_query($koneksi, $query)) {
        die('Update gagal: ' . mysqli_error($koneksi));
    }

    echo "<script>
            alert('Data user berhasil diperbarui!');
            window.location = 'index.php';
          </script>";
    exit;
}

// ========================
// HAPUS USER
// ========================
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus-user') {
    $id  = $_GET['id'];
    $gbr = $_GET['gambar'];

    $delete = mysqli_query($koneksi, "DELETE FROM tb_user WHERE userid = $id");
    if (!$delete) {
        die('Hapus gagal: ' . mysqli_error($koneksi));
    }

    // Hapus file gambar kalau bukan default
    if ($gbr != 'default-user.png') {
        @unlink('../asset/gambar/' . $gbr);
    }

    echo "<script>
            alert('User berhasil dihapus!');
            window.location = 'index.php';
          </script>";
    exit;
}

//ganti password
if (isset($_POST['ganti-password'])) {
        $curPass        = trim(htmlspecialchars($_POST['oldPass']));
        $newPass        = trim(htmlspecialchars($_POST['newPass']));
        $confPass        = trim(htmlspecialchars($_POST['confPass']));

        $userLogin      = $_SESSION['ssUserRM']; 
        $queryUser      = mysqli_query($koneksi, "SELECT * FROM tb_user 
        WHERE username = '$userLogin'");
        $dataUser = mysqli_fetch_assoc($queryUser);

        if ($newPass !== $confPass) {
         echo "<script>
            alert('Password gagal diperbarui, konfirmasi password tidak sama');
            window.location = '../autentikasi/password.php';
          </script>";
        return false;
        }

        if (!password_verify($curPass, $dataUser['password'])) {
              echo "<script>
            alert('Password gagal diperbarui, password lama tidak cocok');
            window.location = '../autentikasi/password.php';
          </script>";
        return false;   
        } else {
                $pass = password_hash($newPass, PASSWORD_DEFAULT);
                mysqli_query($koneksi, "UPDATE tb_user SET password = '$pass' WHERE 
                username = '$userLogin'");
        echo "<script>
            alert('Password berhasil diubah');
            window.location = '../autentikasi/password.php';
          </script>";
        return true; 
        }
}
?>
