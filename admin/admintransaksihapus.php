<?php
include '../koneksi.php';


if(isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];

      $query = "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'";
    $result = mysqli_query($mysqli, $query);

    if($result) {
        header("Location: admintransaksi.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
} else {
    header("Location: admintransaksi.php");
    exit;
}
?>
