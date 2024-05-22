<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_produk = $_POST['id_produk'];
    $total_transaksi = $_POST['total_transaksi'];
    $metode_transaksi = $_POST['metode_transaksi'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];

    $query = "INSERT INTO transaksi (id_produk, total_transaksi, metode_transaksi, tanggal_transaksi) 
              VALUES ('$id_produk', '$total_transaksi', '$metode_transaksi', '$tanggal_transaksi')";

    if (mysqli_query($mysqli, $query)) {
        header("Location: index.php");
        exit(); 
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
    }

    mysqli_close($mysqli);
} else {

    header("Location: index.php");
    exit();
}
?>
