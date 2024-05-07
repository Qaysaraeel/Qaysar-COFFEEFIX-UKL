<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];

    if(isset($_POST['submit'])) {
        $total_transaksi = $_POST['total_transaksi'];
        $metode_transaksi = $_POST['metode_transaksi'];

        $query = "UPDATE transaksi SET total_transaksi='$total_transaksi', metode_transaksi='$metode_transaksi' WHERE id_transaksi='$id_transaksi'";
        $result = mysqli_query($mysqli, $query);

        if($result) {
            header("Location: admintransaksi.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($mysqli);
        }
    }

    $query = "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'";
    $result = mysqli_query($mysqli, $query);
    $data = mysqli_fetch_assoc($result);
} else {
    header("Location: admintransaksi.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Transaksi</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="styleuptade.css">
</head>
<body>
    <div class="container">
        <header>
            <h1 class="title">Update Produk</h1>
        </header>
        <section class="form">
        <form method="POST" action="">

            <input type="text" id="total_transaksi" name="total_transaksi" value="<?php echo $data['total_transaksi']; ?>"><br>

                <select requiredid id="metode_transaksi" name="metode_transaksi" value="<?php echo $data['metode_transaksi']; ?>">
                    <option value="Cash">Cash</option>
                    <option value="Debit">Debit</option>
                    <option value="Credit">Credit</option>
                </select> 
                
                <br><br>
                
            <input type="submit" name="submit" value="Update" class="button">
        </form>
        </section>
    </div>
    <script src="main.js"></script>
</body>
</html>
