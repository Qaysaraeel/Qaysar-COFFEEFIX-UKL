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
    <link rel="stylesheet" href="profil.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
<header>
        <a href="#" class="logo">
            <img src="img/logo.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        <ul class="navbar">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="index.php">Tentang</a></li>
            <li><a href="index.php">Produk</a></li>
            <li><a href="index.php">Ulasan</a></li>
            <li><a href="index.php">Hubungi Kami</a></li>
        </ul>
        <div class="header-icon">
            <a href="index.php"><i class='bx bx-cart-alt'></i></a>
            <a href="#"><i class='bx bx-search' id="search-icon"></i></a>
        </div>
        <div class="search-box">
            <input type="search" name="" id="" placeholder="Search Here...">
        </div>
        <ul class="navbar">
            <li><a href="../index.php">Logout</a></li>
        </ul>
    </header>
    <br><br><br>
    <section class="user-info">
        <h1 class="heading">User Profile</h1>
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
            <a href="../admin/adminuseruptade.php?id=<?php echo $userData['id_user']; ?>" class="btn">Edit profil</a>
        </div>
    </section>
    <br><br><br><br>


    <script src="main.js"></script>
</body>
</html>