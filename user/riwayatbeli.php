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
        <ul class="navbar">
            <li><a href="index.php">Kembali ke Halaman Utama</a></li>
        </ul>
        <ul class="navbar">
            <li><a href="profil.php">profil</a></li>
        </ul>
    </header>

    <br><br><br>

    <section class="riwayatbeli">
    <div class="container">
        <h1>Riwayat Pembelian</h1>
        <div class="transactions-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="transaction">
                        <p><strong>Nama Produk:</strong> <?php echo $row['nama_produk']; ?></p>
                        <p><strong>Harga Produk:</strong> Rp <?php echo number_format($row['harga_produk'], 0, ',', '.'); ?></p>
                        <p><strong>Jumlah:</strong> <?php echo $row['jumlah']; ?></p>
                        <p><strong>Total Transaksi:</strong> Rp <?php echo number_format($row['total_transaksi'], 0, ',', '.'); ?></p>
                        <p><strong>Metode Transaksi:</strong> <?php echo $row['metode_transaksi']; ?></p>
                        <p><strong>Tanggal Transaksi:</strong> <?php echo $row['tanggal_transaksi']; ?></p>
                        <p><strong>Waktu Transaksi:</strong> <?php echo $row['waktu_transaksi']; ?></p>
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
        <h2>BELI MENU LAGI</h2>
    </div>
    <div class="products-container">
        <?php
        include '../koneksi.php';
        $query_mysql = mysqli_query($mysqli, "SELECT * FROM products") or die(mysqli_error($mysqli));
        $nomor = 1;
        while($data = mysqli_fetch_array($query_mysql)) { 
        ?>
        <div class="box">
            <img src="../admin/img/<?php echo $data["gambar_produk"]; ?>" width="200" title="<?php echo $data['gambar_produk']; ?>">
            <h3><?php echo $data['nama_produk']; ?></h3>
            <div class="content">
                <span>Rp: <?php echo $data['harga_produk']; ?></span>
                <a href="belimenu.php?id=<?php echo $data['id_produk']; ?>">Add to Cart</a>
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
