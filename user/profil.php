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
    <link rel="stylesheet" href="profil1.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
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
    <section class="user-info">
        <h1 class="heading">USER PROFIL</h1>
        <div class="profile-container">
            <img src="../user/img/<?php echo htmlspecialchars($userData['foto_profil']); ?>" alt="Profile Picture" class="profile-picture">
            <table class="user-table">
                <tr>
                    <th>Username</th>
                    <td><?php echo htmlspecialchars($userData['username']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($userData['email']); ?></td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td><?php echo htmlspecialchars($userData['password']); ?></td>
                </tr>
            </table>
            <br>
            <a href="../admin/adminuseruptade.php?id=<?php echo $userData['id_user']; ?>" class="btn">Edit profil</a><br>
            <a href="../index.php" class="btn">Log out</a>
        </div>
    </section>
    <br><br><br><br>


    <script src="main.js"></script>
</body>
</html>