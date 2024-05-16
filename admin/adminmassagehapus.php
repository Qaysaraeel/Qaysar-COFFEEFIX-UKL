<?php
include '../koneksi.php';

$id_pesan = $_GET['id']; // Ambil id user dari parameter URL

// Hapus data user dari database
$hapus = mysqli_query($mysqli, "DELETE FROM kontak WHERE id_pesan = '$id_pesan'") or die(mysqli_error($mysqli));

if($hapus) {
    // Redirect kembali ke halaman user.php setelah berhasil menghapus
    header("Location: adminmassage.php");
    exit();
} else {
    echo "Gagal menghapus user.";
}
?>
