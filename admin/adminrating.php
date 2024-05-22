<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman data rating</title>
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
            <li><a href="adminproduk.php">Products</a></li>
            <li><a href="admintransaksi.php">transaction</a></li>
            <li><a href="adminmassage.php">Massage</a></li>
            <li><a href="adminrating.php">Rating</a></li>
        </ul>
        </div>
    </header>
    <section class="user">
    <h1 class="heading">Data rating</h1>
    <br>
        <br>
        <table border="1" class="table">
            <tr>
                <th>Nomer</th>
                <th>Id_Rating</th>
                <th>Rating</th>
                <th>rating</th>
                <th>pesan</th>   
                <th>Action</th> <!-- Menambah kolom aksi -->
            </tr>
            <?php
            include '../koneksi.php';
            $query_mysql = mysqli_query($mysqli, "SELECT * FROM rating") or die(mysqli_error($mysqli));
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $data['id_rating']; ?></td>
                <td><?php echo $data['rating']; ?></td>
                <td><?php echo $data['username']; ?></td>
                <td><?php echo $data['pesan']; ?></td>
                <td><a href="adminratinghapus.php?id=<?php echo $data['id_rating']; ?>" class="btn-hapus">Hapus</a> <!-- Tombol hapus --></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <br>
    <a href="../index.php" class="btn">Log Out</a>
    </section>
    

    <script src="../main.js"></script>
</body>
</html>
