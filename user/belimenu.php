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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];
    $total_transaksi = $_POST['total_transaksi'];
    $metode_transaksi = $_POST['metode_transaksi'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $waktu_transaksi = $_POST['waktu_transaksi'];

    // Insert transaction into the database
    $query = "INSERT INTO transaksi (id_user, id_produk,jumlah, total_transaksi, metode_transaksi, tanggal_transaksi,waktu_transaksi) VALUES ('$id_user', '$id_produk','$jumlah', '$total_transaksi', '$metode_transaksi', '$tanggal_transaksi','$waktu_transaksi')";
    if (mysqli_query($mysqli, $query)) {
        echo "<script>
        alert('Successfully Added');
        document.location.href = 'riwayatbeli.php';
    </script>";
    } else {
        echo "<p>Error: " . mysqli_error($mysqli) . "</p>";
    }
}

// Display product details
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $query = "
        SELECT products.id_produk, products.nama_produk, products.harga_produk, products.gambar_produk, user.username 
        FROM products 
        JOIN user ON user.id_user = $id_user
        WHERE products.id_produk = $id_produk
    ";
    $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Beli menu</title>
<link rel="icon" type="image/png" href="../logotitle.png">
<link rel="stylesheet" href="beli.css">
<script>
    function updateTotalTransaksi() {
    var harga = <?php echo $row['harga_produk']; ?>;
    var jumlah = document.getElementById('jumlah').value;
    var total = harga * jumlah;
    document.getElementById('total_transaksi').innerText = 'Rp ' + total;
    document.getElementById('total_transaksi_hidden').value = total;
                    }
    document.addEventListener('DOMContentLoaded', (event) => {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months start at 0!
    const dd = String(today.getDate()).padStart(2, '0');

    const formattedToday = yyyy + '-' + mm + '-' + dd;
    document.getElementById('tanggal_transaksi').value = formattedToday;
    });

    function setCurrentTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const currentTime = `${hours}:${minutes}`;
        document.getElementById('waktu_transaksi').value = currentTime;
        }

        window.onload = setCurrentTime;
    </script>
</head>
<body>

    <header>
        <a href="#" class="logo">
            <img src="img/logo.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        <ul class="navbar">
            <li><a href="index.php">Kembali ke Halaman Utama</a></li>
            <li><a href="riwayatbeli.php">Riwayat pembelian</a></li>
            <li><a href="peringkat.php">Peringkat Pembelian</a></li>
        </ul>
        <ul class="navbar">
            <li><a href="profil.php">profil</a></li>
        </ul>
    </header>
    
    <div class="product-details">
            <h2><?php echo $row['nama_produk']; ?></h2>
            <img src="../admin/img/<?php echo $row['gambar_produk']; ?>" alt="<?php echo $row['nama_produk']; ?>" width="200">
            <p>Price: Rp <?php echo $row['harga_produk']; ?></p>
            <p>Username: <?php echo $userData['username']; ?></p>

            <form action="belimenu.php" method="POST">
                <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">

                <label for="jumlah">Jumlah:</label>
                <input type="number" id="jumlah" name="jumlah" value="1" min="1" oninput="updateTotalTransaksi()" required><br><br>
            
                <div class="form-group">
                    <label for="total_transaksi">Total Transaksi:</label>
                    <span id="total_transaksi">Rp <?php echo $row['harga_produk']; ?></span>
                    <input type="hidden" id="total_transaksi_hidden" name="total_transaksi" value="<?php echo $row['harga_produk']; ?>" required>
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

                <div class="form-group">
                    <label for="waktu_transaksi">Waktu Transaksi:</label>
                    <input type="time" id="waktu_transaksi" name="waktu_transaksi">
                </div>


            <input type="submit" value="Buy Now" name="submit">
        </form>
    </div>

    <section class="products" id="products">
    <div class="heading">
        <h2>MENU</h2>
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
                <a href="belimenu.php?id=<?php echo $data['id_produk']; ?>">Beli</a>
            </div>
        </div>
        <?php } ?>
    </div>
    </section>



    <script src="main.js"></script>
</body>
</html>


        <?php
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID not provided.";
}

mysqli_close($mysqli);
?>
