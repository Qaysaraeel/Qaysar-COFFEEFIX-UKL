<?php
include '../koneksi.php';

$id_rating = $_GET['id']; // Ambil id user dari parameter URL

// Hapus data user dari database
$hapus = mysqli_query($mysqli, "DELETE FROM rating WHERE id_rating = '$id_rating'") or die(mysqli_error($mysqli));

if($hapus) {
    // Redirect kembali ke halaman user.php setelah berhasil menghapus
    header("Location: adminrating.php");
    exit();
} else {
    echo "Gagal menghapus user.";
}
?>
