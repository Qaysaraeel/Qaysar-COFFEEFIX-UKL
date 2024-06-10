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
    SELECT transaksi.id_transaksi, products.nama_produk, products.harga_produk, transaksi.jumlah, transaksi.total_transaksi, transaksi.metode_transaksi, transaksi.tanggal_transaksi, transaksi.waktu_transaksi, transaksi.id_produk, transaksi.rating, transaksi.status
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .btn-1 {
            padding: 10px 30px;
            border-radius: 0.3rem;
            background: rgb(0, 211, 14);
            color: var(--bg-color);
            font-weight: 500;
            border: none;
        }
        .btn-1:hover {
            background: #149400;
        }
        .btn-cancel {
            padding: 10px 30px;
            border-radius: 0.3rem;
            background: rgb(255, 69, 58);
            color: var(--bg-color);
            font-weight: 500;
            border: none;
        }
        .btn-cancel:hover {
            background: rgb(200, 35, 35);
        }
    </style>
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
        <li><a href="produk.php">Menu</a></li>
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
        <a href="peringkat.php" class="btn">Lihat Peringkat Berdasarkan Total Pembelian</a><br><br>
        <div class="transactions-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="transaction" id="transaction-<?php echo $row['id_transaksi']; ?>">
                        <p><strong>Nama Produk:</strong> <?php echo htmlspecialchars($row['nama_produk']); ?></p>
                        <p><strong>Harga Produk:</strong> Rp <?php echo number_format($row['harga_produk'], 0, ',', '.'); ?></p>
                        <p><strong>Jumlah:</strong> <?php echo htmlspecialchars($row['jumlah']); ?></p>
                        <p><strong>Total Transaksi:</strong> Rp <?php echo number_format($row['total_transaksi'], 0, ',', '.'); ?></p>
                        <p><strong>Metode Transaksi:</strong> <?php echo htmlspecialchars($row['metode_transaksi']); ?></p>
                        <p><strong>Tgl Transaksi:</strong> <?php echo htmlspecialchars($row['tanggal_transaksi']); ?></p>
                        <p><strong>Waktu Transaksi:</strong> <?php echo htmlspecialchars($row['waktu_transaksi']); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?></p>
                        <br>
                        <?php if ($row['status'] == 'Pesanan di proses' || $row['status'] == 'Konfirmasi'): ?>
                            <button class="btn-cancel" onclick="confirmCancelOrder(<?php echo $row['id_transaksi']; ?>)">Batalkan Pemesanan</button>
                        <?php elseif ($row['status'] == 'Pemesanan Selesai'): ?>
                            <?php if ($row['rating']): ?>
                                <p>Sudah Rating</p>
                            <?php else: ?>
                                <a href="ratingmenu.php?id_produk=<?php echo $row['id_produk']; ?>" class="btn">Beri Rating</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <p>Pemesanan sedang diproses</p>
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
<script>
    function confirmCancelOrder(id) {
        if (confirm("Apakah Anda yakin ingin membatalkan pesanan ini?")) {
            cancelOrder(id);
        }
    }

    function cancelOrder(id) {
        $.ajax({
            url: '../barista/updatestatus.php',
            type: 'POST',
            data: { id: id, action: 'cancel' },
            success: function(response) {
                if ($.trim(response) == 'success') {
                    $('#transaction-' + id).remove();
                } else {
                    alert('Gagal membatalkan pesanan.');
                }
            },
            error: function() {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    }
</script>
</body>
</html>
