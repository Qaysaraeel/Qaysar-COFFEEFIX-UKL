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
    SELECT transaksi.id_transaksi, products.nama_produk, products.harga_produk, transaksi.jumlah, transaksi.total_transaksi, transaksi.metode_transaksi, transaksi.tanggal_transaksi,transaksi.waktu_transaksi
    FROM transaksi 
    JOIN products ON transaksi.id_produk = products.id_produk 
    WHERE transaksi.id_user = '$id_user'
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
    <link rel="stylesheet" href="riwayatbeli1.css">
</head>
<body>
    <header>
        <a href="#" class="logo">
            <img src="img/logo.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        <ul class="navbar">
            <li><a href="index.php">Kembali ke Halaman Utama</a></li>
            <li><a href="peringkat.php">Peringkat Pembelian</a></li>
        </ul>
        <ul class="navbar">
            <li><a href="profil.php">profil</a></li>
        </ul>
    </header>

    <br><br><br>

    <section class="riwayatbeli">
        <div class="container">
            <h1>Riwayat Pembelian</h1>
            <p><strong>Total Belanja Keseluruhan:</strong> Rp <?php echo number_format($totalAmount, 0, ',', '.'); ?></p> <br>
            <a href="peringkat.php" class="btn">Lihat peringkat Berdasarkan Total Belanja</a><br><br>
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

    <section class="products" id="products">
    <div class="heading">
        <h2>BELI MENU</h2>
    </div>
    <div class="products-container" id="products-container">
            <?php
            include '../koneksi.php';
            $query_mysql = mysqli_query($mysqli, "SELECT * FROM products") or die(mysqli_error($mysqli));
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <div class="box" data-category="<?php echo strtolower($data['kategori']); ?>">
                <img src="../admin/img/<?php echo $data["gambar_produk"]; ?>" width="200" title="<?php echo $data['gambar_produk']; ?>">
                <h3><?php echo $data['nama_produk']; ?></h3>
                <p><?php echo $data['kategori']; ?></p>
                <h4>Rp: <?php echo $data['harga_produk']; ?></h4><br>
                <div class="content">
                    <h3><a href="belimenu.php?id=<?php echo $data['id_produk']; ?>" class="btn">Beli</a></h3>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>

    
    <script src="main.js"></script>
</body>
</html>

<?php
mysqli_close($mysqli);
?>
