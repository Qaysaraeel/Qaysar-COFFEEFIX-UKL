<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Data Rating</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
</head>
<body>
<header>
        <a href="#" class="logo">
            <img src="../user/img/logo.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        <ul class="navbar">
            <li><a href="adminuser.php">User</a></li>
            <li><a href="adminproduk.php">Produk</a></li>
            <li><a href="admintransaksi.php">transaksi</a></li>
            <li><a href="adminmassage.php">kritiK/saran</a></li>
            <li><a href="adminrating.php">Rating/ulasan</a></li>
            <li><a href="profil.php">profil</a></li>
        </ul>
        </div>
    </header>
    <section class="user">
        <h1 class="heading">Data Rating/ulasan</h1>
        <br><br>
        <table border="1" class="table">
            <tr>
                <th>Nomor</th>
                <th>Id_Rating</th>
                <th>Rating</th>
                <th>Id User</th>
                <th>Username</th>
                <th>Foto Profil</th>
                <th>Pesan</th>   
                <th>Action</th>
            </tr>
            <?php
            include '../koneksi.php';
            $query = "
                SELECT rating.id_rating, rating.rating, rating.pesan, 
                       user.id_user, user.username, user.foto_profil 
                FROM rating
                JOIN user ON rating.id_user = user.id_user
            ";
            $query_mysql = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $data['id_rating']; ?></td>
                <td><?php echo $data['rating']; ?></td>
                <td><?php echo $data['id_user']; ?></td>
                <td><?php echo $data['username']; ?></td>
                <td><img src="../user/img/<?php echo $data["foto_profil"]; ?>" width="50" title="<?php echo $data['foto_profil']; ?>"></td>
                <td><?php echo $data['pesan']; ?></td>
                <td><a href="adminratinghapus.php?id=<?php echo $data['id_rating']; ?>" class="btn-hapus">Hapus</a></td>
            </tr>
            <?php } ?>
        </table>
        <br><br>
        <a href="../index.php" class="btn">Log Out</a>
    </section>
    <script src="main.js"></script>
</body>
</html>
