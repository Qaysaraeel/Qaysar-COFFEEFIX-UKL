<?php
include '../koneksi.php';

$id_user = $_GET['id']; // Ambil id user dari parameter URL

// Hapus data user dari database
$hapus = mysqli_query($mysqli, "DELETE FROM user WHERE id_user = '$id_user'") or die(mysqli_error($mysqli));

if($hapus) {
    // Redirect kembali ke halaman user.php setelah berhasil menghapus
    header("Location: adminuser.php");
    exit();
} else {
    echo "Gagal menghapus user.";
}
?>
