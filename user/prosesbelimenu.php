<?php
// Include the database connection file
include '../koneksi.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $id_produk = $_POST['id_produk'];
    $total_transaksi = $_POST['total_transaksi'];
    $metode_transaksi = $_POST['metode_transaksi'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];

    // Insert the transaction into the database
    $query = "INSERT INTO transaksi (id_produk, total_transaksi, metode_transaksi, tanggal_transaksi) 
              VALUES ('$id_produk', '$total_transaksi', '$metode_transaksi', '$tanggal_transaksi')";

    if (mysqli_query($mysqli, $query)) {
        // Jika transaksi berhasil, arahkan kembali ke halaman utama
        header("Location: index.php");
        exit(); // Pastikan tidak ada kode ekstra yang dijalankan setelah redirect
    } else {
        // Jika terjadi kesalahan, tampilkan pesan kesalahan
        echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
    }

    // Close the database connection
    mysqli_close($mysqli);
} else {
    // Jika pengguna mencoba mengakses file ini secara langsung, arahkan kembali ke halaman utama
    header("Location: index.php");
    exit();
}
?>
