<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../koneksi.php';
$username = $_SESSION['username'];

$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($mysqli));
}

$userData = mysqli_fetch_assoc($result);

mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee</title>
    <link rel="stylesheet" href="rating.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
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
            <li><a href="produk.php">menu</a></li>
            <li><a href="keranjang.php">Keranjang</a></li>
            <li><a href="riwayatbeli.php">Riwayat Pembelian</a></li>
            <li><a href="peringkat.php">Peringkat Pembelian</a></li>
            <li><a href="profil.php">Profil</a></li>
        </ul>
    </header>
    <br><br><br><br>
    <section class="customers" id="customers">
        <div class="heading">
            <h1>ulasan customer</h1><br><br>
        </div>
        <a href="index.php" class="btn">Kembali</a>
        <a href="../admin/adminratingtambah.php?id_user=<?php echo $userData['id_user']; ?>" class="btn">Berikan ulasan!</a>
        <div class="customers-container">
            <?php
            include '../koneksi.php';
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
                <img src="../user/img/<?php echo $data['foto_profil']; ?>" width="50" title="<?php echo $data['foto_profil']; ?>">
            </div>
            <?php } ?>
        </div>
        <br><br>
        
    </section>
</body>
</html>