<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../koneksi.php';
$username = $_SESSION['username'];

// Fetch user data
$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($mysqli));
}

$userData = mysqli_fetch_assoc($result);
$id_user = $userData['id_user'];

// Fetch transactions for the user
$query = "
    SELECT transaksi.id_transaksi, products.nama_produk, products.harga_produk, transaksi.jumlah, transaksi.total_transaksi, transaksi.metode_transaksi, transaksi.tanggal_transaksi, transaksi.waktu_transaksi, transaksi.id_produk, transaksi.rating
    FROM transaksi 
    JOIN products ON transaksi.id_produk = products.id_produk 
    WHERE transaksi.id_user = '$id_user'
    ORDER BY transaksi.tanggal_transaksi DESC, transaksi.waktu_transaksi DESC
";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($mysqli));
}

// Calculate total transactions
$query_total = "
    SELECT SUM(total_transaksi) as total_amount
    FROM transaksi
    WHERE id_user = '$id_user'
";
$result_total = mysqli_query($mysqli, $query_total);

if (!$result_total) {
    die("Query Error: " . mysqli_error($mysqli));
}

$totalAmount = mysqli_fetch_assoc($result_total)['total_amount'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembelian</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="riwayatbeli.css">
</head>
<body>
<header>
        <a href="#" class="logo">
            <img src="img/logo.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        
        <div class="header-icon">
            <a href="#"><i class='bx bx-search' id="search-icon"></i></a>
        </div>
        <div class="search-box">
            <input type="search" name="" id="" placeholder="Search Here...">
        </div>
        <ul class="navbar">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="produk.php">menu</a></li>
            <li><a href="keranjang.php">Keranjang</a></li>
            <li><a href="riwayatbeli.php">Riwayat Pembelian</a></li>
            <li><a href="peringkat.php">Peringkat Pembelian</a></li>
            <li><a href="profil.php">Profil</a></li>
        </ul>
    </header>

    <br><br><br>

    <section class="riwayatbeli">
        <div class="container">
            <h1>Riwayat Pembelian</h1>
            <p><strong>Total pembelian Keseluruhan:</strong> Rp <?php echo number_format($totalAmount, 0, ',', '.'); ?></p> <br>
            <a href="peringkat.php" class="btn">Lihat peringkat Berdasarkan Total pembelian</a><br><br>
            <div class="transactions-container">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="transaction">
                            <p><strong>Nama Produk:</strong> <?php echo htmlspecialchars($row['nama_produk']); ?></p>
                            <p><strong>Harga Produk:</strong> Rp <?php echo number_format($row['harga_produk'], 0, ',', '.'); ?></p>
                            <p><strong>Jumlah:</strong> <?php echo htmlspecialchars($row['jumlah']); ?></p>
                            <p><strong>Total Transaksi:</strong> Rp <?php echo number_format($row['total_transaksi'], 0, ',', '.'); ?></p>
                            <p><strong>Metode Transaksi:</strong> <?php echo htmlspecialchars($row['metode_transaksi']); ?></p>
                            <p><strong>Tgl Transaksi:</strong> <?php echo htmlspecialchars($row['tanggal_transaksi']); ?></p>
                            <p><strong>Waktu Transaksi:</strong> <?php echo htmlspecialchars($row['waktu_transaksi']); ?></p>
                            <br>
                            <?php if ($row['rating']): ?>
                                <p>Sudah Rating</p>
                            <?php else: ?>
                                <a href="ratingmenu.php?id_produk=<?php echo $row['id_produk']; ?>" class="btn">Beri rating</a>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>Belum ada riwayat pembelian.</p>";
                }
                ?>
            </div>
        </div>
    </section>
</body>
</html>