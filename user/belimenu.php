<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="../admin/styleuptade.css">
</head>
<body>
    <div class="container">
    <header>
        <h1 class="title">Tambah Transaksi Baru</h1>
        <section class="form">
        <form action="belimenu.php" method="POST">
            <div class="form-group">
                <label for="id_user">Username:</label>
                <select name="id_user" id="id_user">
                    <option value="3">qaesyaar</option>
                    <option value="10">aathar</option>
                    <option value="11">eepan</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="id_produk">ID Produk:</label>
                <select name="id_produk" id="id_produk">
                    <option value="1">cappucino</option>
                    <option value="2">americano</option>
                    <option value="3">milk coffe</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="total_transaksi">Total Transaksi:</label>
                <select name="total_transaksi" id="total_transaksi">
                    <option value="20000">cappucino</option>
                    <option value="25000">americano</option>
                    <option value="22000">milk coffe</option>
                </select>
            </div>
            <br>
            <div class="group">
                <label for="metode_transaksi">Metode Transaksi:</label>
                <select id="metode_transaksi" name="metode_transaksi" required>
                    <option value="Cash">Cash</option>
                    <option value="Debit">Debit</option>
                    <option value="Credit">Credit</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="tanggal_transaksi">Tanggal Transaksi:</label>
                <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" placeholder="yyyy-mm-dd" required>
            </div>
            <br>
            <br>
            <button type="submit" name="submit" class="button">Submit</button>

            <?php
            include '../koneksi.php';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id_user = $_POST['id_user'];
            $id_produk = $_POST['id_produk'];
            $total_transaksi = $_POST['total_transaksi'];
            $metode_transaksi = $_POST['metode_transaksi'];
            $tanggal_transaksi = $_POST['tanggal_transaksi'];

            $query = "INSERT INTO transaksi (id_user, id_produk, total_transaksi, metode_transaksi, tanggal_transaksi) 
              VALUES ('$id_user', '$id_produk', '$total_transaksi', '$metode_transaksi', '$tanggal_transaksi')";
    
            if (mysqli_query($mysqli, $query)) {
            header("Location: index.php");
            } else {
            echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
            }

             mysqli_close($mysqli);
            }
            ?>

        </form>
        </section>
    </header>
    </div>
</body>
</html>
