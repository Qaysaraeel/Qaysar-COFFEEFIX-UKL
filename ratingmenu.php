<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../koneksi.php';

$product = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $rating = $_POST['rating'];
    $username = $_SESSION['username'];

    // Fetch user ID
    $query = "SELECT id_user FROM user WHERE username = '$username'";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die("Query Error: " . mysqli_error($mysqli));
    }

    $userData = mysqli_fetch_assoc($result);
    $id_user = $userData['id_user'];

    // Update rating in the transaction table
    $query = "UPDATE transaksi SET rating = '$rating' WHERE id_user = '$id_user' AND id_produk = '$id_produk'";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        // Redirect to "Riwayat Pembelian"
        header("Location: riwayatbeli.php");
        exit();
    } else {
        echo "Failed to update rating: " . mysqli_error($mysqli);
    }
} else if (isset($_GET['id_produk'])) {
    $id_produk = $_GET['id_produk'];

    // Fetch product details
    $query = "SELECT * FROM products WHERE id_produk = '$id_produk'";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Failed to fetch product details: " . mysqli_error($mysqli);
        exit();
    }
} else {
    echo "No product ID provided.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Produk</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="ratingmenu.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Rate Produk</h1>
        <?php if ($product): ?>
                <div class="product-image-container">
                    <img src="../admin/img/<?php echo htmlspecialchars($product['gambar_produk']); ?>" alt="<?php echo htmlspecialchars($product['nama_produk']); ?>" class="product-image">
                </div>
                <div class="product-info">
                    <h2><?php echo htmlspecialchars($product['nama_produk']); ?></h2>
                    <p><?php echo htmlspecialchars($product['kategori']); ?></p>
                    <h4>Rp: <?php echo number_format($product['harga_produk'], 0, ',', '.'); ?></h4>
                </div>
        <?php endif; ?>
        <form method="POST" action="ratingmenu.php" class="rating-form">
            <input type="hidden" name="id_produk" value="<?php echo htmlspecialchars($id_produk); ?>">
            <label for="rating">Rating (1-5):</label>
            <select id="rating" name="rating" required>
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>
            <a href="#" onclick="document.querySelector('.rating-form').submit();" class="btn">Submit Rating</a>
            <a href="riwayatbeli.php" class="btn">Kembali</a>
        </form>
    </div>
</body>
</html>

