<?php
session_start();
if (!isset($_SESSION['username'])) {
    $username = null; // Set username to null if the user is not logged in
} else {
    $username = $_SESSION['username'];
}

include 'koneksi.php';

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

// Retrieve the rankings
$rankings = [];
$rank = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $row['rank'] = $rank++;
    $rankings[] = $row;
}

mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peringkat Pengguna</title>
    <link rel="icon" type="image/png" href="logotitle.png">
    <link rel="stylesheet" href="user/peringkat.css">
    <style>
        #btn{
        padding: 10px 30px;
        border-radius: 0.3rem;
        background: var(--main-color);
        color: var(--bg-color);
        font-weight: 500;
        }
        #btn:hover{
        background: #8a6f4d;
        }
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .popup {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            position: relative;
        }
        .popup h2 {
            margin: 0 0 10px;
        }
        .popup p {
            margin: 0 0 20px;
        }
        .popup a {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background: #bc9667;
            border-radius: 5px;
            text-decoration: none;
        }
        .popup a:hover {
            background: #8a6f4d;
        }
        .popup .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<header>
    <a href="#" class="logo">
        <img src="user/img/logo.png" alt="">
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
        <li><a href="produk.php">Menu</a></li>
        <li><a href="#" class="login-required">Keranjang</a></li>
        <li><a href="#" class="login-required">Riwayat Pembelian</a></li>
        <li><a href="peringkat.php">Peringkat Pembelian</a></li>
        <li><a href="loginnya.php">Login</a></li>
    </ul>
</header>

<br><br><br>

<section class="peringkat">
    <div class="container">
        <br>
        <h1>Peringkat Pengguna Berdasarkan Total Pembelian</h1><br>
        <div class="ranking-container">
            <table>
                <thead>
                    <tr>
                        <th>Peringkat</th>
                        <th>Username</th>
                        <th>Total Pembelian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rankings as $row) { ?>
                        <tr>
                            <td><?php echo $row['rank']; ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td>Rp <?php echo number_format($row['total_amount'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="encouragement">
            <p>Login dan beli menu kami untuk masuk ke peringkat!</p><br>
            <a href="#" class="login-required" id="btn">Login</a>
        </div>
    </div>
</section>

<div class="popup-overlay" id="popup-overlay">
        <div class="popup">
            <button class="close-btn" id="close-btn">&times;</button>
            <h2>Login Diperlukan</h2>
            <p>Anda perlu login untuk mengakses fitur ini.</p>
            <a href="loginnya.php">Login Sekarang</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginRequiredLinks = document.querySelectorAll('.login-required');
            const popupOverlay = document.getElementById('popup-overlay');
            const closeBtn = document.getElementById('close-btn');

            loginRequiredLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    popupOverlay.style.display = 'flex';
                });
            });

            closeBtn.addEventListener('click', function() {
                popupOverlay.style.display = 'none';
            });

            popupOverlay.addEventListener('click', function(event) {
                if (event.target === popupOverlay) {
                    popupOverlay.style.display = 'none';
                }
            });
        });
    </script>

</body>
</html>
