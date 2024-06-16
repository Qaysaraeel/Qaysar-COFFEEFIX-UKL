<?php
session_start();
if (!isset($_SESSION['username'])) {
    $loggedIn = false;
} else {
    $loggedIn = true;
    include 'koneksi.php';
    $username = $_SESSION['username'];
    
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($mysqli, $query);
    
    if (!$result) {
        die("Query Error: " . mysqli_error($mysqli));
    }
    
    $userData = mysqli_fetch_assoc($result);
    
    mysqli_close($mysqli);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee</title>
    <link rel="stylesheet" href="user/rating.css">
    <link rel="icon" type="image/png" href="logotitle.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
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
        h1{
            text-align:center;
            text-transform:uppercase;
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
            <a href="#"><i class='bx bx-searchiu' id="search-icon"></i></a>
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
    <br><br><br><br>
    <section class="customers" id="customers">
        <div class="heading">
            <h1>Ulasan Customer</h1>
        </div><br><br><br>
        <a href="index.php" class="btn">Kembali</a>
        <a href="#" class="login-required" id="btn">Berikan Ulasan!</a>
        <div class="customers-container">
            <?php
            include 'koneksi.php';
            $query = "
                SELECT rating.*, user.username, user.foto_profil 
                FROM rating
                JOIN user ON rating.id_user = user.id_user
            ";
            $query_mysql = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <div class="box">
                <div class="stars">
                    <?php
                    // Display stars
                    $rating = $data['rating'];
                    $full_stars = floor($rating);
                    $half_star = ceil($rating - $full_stars);
                    $empty_stars = 5 - $full_stars - $half_star;
                    
                    // Full stars
                    for ($i = 0; $i < $full_stars; $i++) {
                        echo "<i class='bx bxs-star'></i>";
                    }
                    
                    // Half star
                    if ($half_star) {
                        echo "<i class='bx bxs-star-half'></i>";
                    }
                    
                    // Empty stars
                    for ($i = 0; $i < $empty_stars; $i++) {
                        echo "<i class='bx bx-star'></i>";
                    }
                    ?>
                </div>
                <p><?php echo $data['pesan']; ?></p>
                <h2><?php echo $data['username']; ?></h2>
                <img src="user/img/<?php echo $data['foto_profil']; ?>" width="50" title="<?php echo $data['foto_profil']; ?>">
            </div>
            <?php } ?>
        </div>
        <br><br>
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
            const loggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;
            const loginRequiredLinks = document.querySelectorAll('.login-required');
            const popupOverlay = document.getElementById('popup-overlay');
            const closeBtn = document.getElementById('close-btn');

            loginRequiredLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    if (!loggedIn) {
                        event.preventDefault();
                        popupOverlay.style.display = 'flex';
                    }
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
