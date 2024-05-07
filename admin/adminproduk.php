<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman data PRODUCTS</title>
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
        </ul>
        </div>
    </header>
    <section class="user">
    <h1 class="heading">Data Products</h1>
    <br>
        <a href="adminproduktambah.php" class="btn">Tambah Produk</a>
        <br>
        <br>
        <table border="1" class="table">
            <tr>
                <th>Nomer</th>
                <th>Id_Products</th>
                <th>Name Products</th>
                <th>Price Products</th>
                <th>Stock</th>
                <th>Action</th> <!-- Menambah kolom aksi -->
                <th>Action</th>
            </tr>
            <?php
            include '../koneksi.php';
            $query_mysql = mysqli_query($mysqli, "SELECT * FROM products") or die(mysqli_error($mysqli));
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $data['id_produk']; ?></td>
                <td><?php echo $data['nama_produk']; ?></td>
                <td><?php echo $data['harga_produk']; ?></td>
                <td><?php echo $data['stock']; ?></td>
                <td><a href="adminprodukhapus.php?id=<?php echo $data['id_produk']; ?>" class="btn-hapus">Hapus</a></td>
                <td><a href="adminprodukuptade.php?id=<?php echo $data['id_produk']; ?>" class="btn-update">Update</a></td>
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
