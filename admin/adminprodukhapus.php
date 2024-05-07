<?php
include '../koneksi.php';

$id_produk = $_GET['id'];

$hapus = mysqli_query($mysqli, "DELETE FROM products WHERE id_produk = '$id_produk'") or die(mysqli_error($mysqli));

if($hapus) {
    header("Location: adminproduk.php");
    exit();
} else {
    echo "Gagal menghapus produk.";
}
?>
