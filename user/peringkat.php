<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../koneksi.php';

// Fetch the logged-in user's username
$username = $_SESSION['username'];

// Fetch top users by total transactions
$query = "
    SELECT user.username, SUM(transaksi.total_transaksi) as total_amount
    FROM transaksi 
    JOIN user ON transaksi.id_user = user.id_user
    GROUP BY user.username
    ORDER BY total_amount DESC
    LIMIT 10
";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($mysqli));
}

// Check if the logged-in user is in the top rankings
$rankings = [];
$userInRanking = false;
$rank = 1;

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['username'] == $username) {
        $userInRanking = true;
    }
    $row['rank'] = $rank++;
    $rankings[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peringkat Pengguna</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="peringkat.css">
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
            <input type="hidden" name="" id="" placeholder="Search Here...">
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

    <section class="peringkat">
        <div class="container"><br>
            <h1>Peringkat Pengguna Berdasarkan Total pembelian</h1><br>
            <div class="ranking-container">
                <table>
                    <thead>
                        <tr>
                            <th>Peringkat</th>
                            <th>Username</th>
                            <th>Total pembelian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rankings as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['rank']; ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td>Rp <?php echo number_format($row['total_amount'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="encouragement">
                <?php if ($userInRanking) { ?>
                    <p>Selamat, kamu berada di peringkat <strong><?php echo array_search($username, array_column($rankings, 'username')) + 1; ?></strong>!</p>
                <?php } else { ?>
                    <p>Kamu tidak masuk peringkat. Beli terus menu kami dan jadilah yang terbaik!</p>
                <?php } ?>
                <br>

                <p>Naikan peringkatmu dengan membeli terus menu kami dan jadilah yang terbaik!</p><br>
                <a href="produk.php" class="btn">Beli Sekarang</a>
            </div>
        </div>
    </section>

</body>
</html>

<?php
mysqli_close($mysqli);
?>
