<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman data USER</title>
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
        </ul>
        </div>
    </header>
    <section class="user">
    <h1 class="heading">Data User COFFEE</h1>
    <br>
        <a href="../register.php" class="btn">Tambah User</a>
        <br>
        <br>
        <table border="1" class="table">
            <tr>
                <th>Nomer</th>
                <th>Id_User</th>
                <th>Username</th>
                <th>Foto profil</th>
                <th>Password</th>   
                <th>Email</th>
                <th>Level</th>
                <th>Action</th> <!-- Menambah kolom aksi -->
                <th>Action</th> <!-- Menambah kolom aksi -->
            </tr>
            <?php
            include '../koneksi.php';
            $query_mysql = mysqli_query($mysqli, "SELECT * FROM user") or die(mysqli_error($mysqli));
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $data['id_user']; ?></td>
                <td><?php echo $data['username']; ?></td>
                <td><img src="img/<?php echo $data["pp"]; ?>" width="200" title="<?php echo $data['pp']; ?>"></td>
                <td><?php echo $data['password']; ?></td>
                <td><?php echo $data['email']; ?></td>
                <td><?php echo $data['level']; ?></td>
                <td><a href="adminuserhapus.php?id=<?php echo $data['id_user']; ?>" class="btn-hapus">Hapus</a> <!-- Tombol hapus --></td>
                <td><a href="adminuseruptade.php?id=<?php echo $data['id_user']; ?>" class="btn-update">Update</a> <!-- Tombol update --></td>
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
