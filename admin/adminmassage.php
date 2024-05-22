<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman data MASSAGE</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
</head>
<body>
    <header>
        <a href="#" class="logo">
            <img src="img/logo1.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        <ul class="navbar">
            <li><a href="adminuser.php">User</a></li>
            <li><a href="adminproduk.php">Products</a></li>
            <li><a href="admintransaksi.php">transaction</a></li>
            <li><a href="adminmassage.php">Massange</a></li>
        </ul>
        </div>
    </header>
    <section class="user">
    <h1 class="heading">Data Massange</h1>
    <br>
        <a href="../user/index.php" id="contact" class="btn">Form massange</a>
        <br>
        <br>
        <br>
        <table border="1" class="table">
            <tr>
                <th>Nomer</th>
                <th>Username</th>
                <th>Email</th>
                <th>Massage</th>
                <th>Action</th> <!-- Menambah kolom aksi -->
                <th>Action</th>
            </tr>
            <?php
            include '../koneksi.php';
            $query_mysql = mysqli_query($mysqli, "SELECT * FROM kontak") or die(mysqli_error($mysqli));
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $data['username']; ?></td>
                <td><?php echo $data['email']; ?></td>
                <td><?php echo $data['pesan']; ?></td>
                <td><a href="adminmassagehapus.php?id=<?php echo $data['id_pesan']; ?>" class="btn-hapus">Hapus</a></td>
                <td><a href="adminmassageuptade.php?id=<?php echo $data['id_pesan']; ?>" class="btn-update">Update</a></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <br>
    <a href="../index.php" class="btn">Log Out</a>
    </section>
    

    <script src="main.js"></script>
</body>
</html>
