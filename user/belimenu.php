<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="stylebeli.css">
</head>
<body>

    <?php
    include '../koneksi.php';

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_produk = $_POST['id_produk'];
        $total_transaksi = $_POST['total_transaksi'];
        $metode_transaksi = $_POST['metode_transaksi'];
        $tanggal_transaksi = $_POST['tanggal_transaksi'];

        // Insert transaction into the database
        $query = "INSERT INTO transactions (id_produk, total_transaksi, metode_transaksi, tanggal_transaksi) VALUES ('$id_produk', '$total_transaksi', '$metode_transaksi', '$tanggal_transaksi')";
        if (mysqli_query($mysqli, $query)) {
            echo "<p>Transaction successful!</p>";
        } else {
            echo "<p>Error: " . mysqli_error($mysqli) . "</p>";
        }
    }

    // Display product details
    if (isset($_GET['id'])) {
        $id_produk = $_GET['id'];
        $query = "SELECT * FROM products WHERE id_produk = $id_produk";
        $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            ?>

            <div class="product-details">
                <h2><?php echo $row['nama_produk']; ?></h2>
                <img src="../admin/img/<?php echo $row['gambar_produk']; ?>" alt="<?php echo $row['nama_produk']; ?>" width="200">
                <p>Price: Rp <?php echo $row['harga_produk']; ?></p>

                <form action="belimenu.php" method="POST">
                    <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">
                    <div class="form-group">
                        <label for="total_transaksi">Total Transaksi:</label>
                        <input type="number" id="total_transaksi" name="total_transaksi" placeholder="Tolong tulis sesuai harga produknya" required>
                    </div>
                    <div class="form-group">
                        <label for="metode_transaksi">Metode Transaksi:</label>
                        <select id="metode_transaksi" name="metode_transaksi" required>
                            <option value="Cash">Cash</option>
                            <option value="Debit">Debit</option>
                            <option value="Credit">Credit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_transaksi">Tanggal Transaksi:</label>
                        <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" placeholder="yyyy-mm-dd" required>
                    </div>
                    
                    <!-- Submit button -->
                    <input type="submit" value="Buy Now">
                </form>
            </div>

            <?php
        } else {
            echo "Product not found.";
        }
    } else {
        echo "Product ID not provided.";
    }
    ?>

    <!-- Add your HTML content for the buy menu page here -->

</body>
</html>
