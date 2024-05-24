<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman data TRANSACTION</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="style.css">
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
            <li><a href="admintransaksi.php">Transaction</a></li>
            <li><a href="adminmassage.php">Massage</a></li>
            <li><a href="adminrating.php">Rating</a></li>
            <li><a href="profil.php">Profil</a></li>
        </ul>
    </header>
    <section class="user">
        <h1 class="heading">Data Transaction</h1>
        <br>
        <a href="../user/index.php" class="btn">Ayo Beli</a>
        <br>
        <br>

        <?php
        include '../koneksi.php';
        
        // Fetch all transactions
        $query_mysql = mysqli_query($mysqli, "SELECT * FROM transaksi") or die(mysqli_error($mysqli));

        // Calculate total pendapatan
        $total_pendapatan_query = mysqli_query($mysqli, "SELECT SUM(total_transaksi) AS total_pendapatan FROM transaksi") or die(mysqli_error($mysqli));
        $total_pendapatan_result = mysqli_fetch_assoc($total_pendapatan_query);
        $total_pendapatan = $total_pendapatan_result['total_pendapatan'];
        ?>

        <style>
            h2{
                color:#fff;
            }
        </style>

        <div class="total-pendapatan">
            <h2>Total Pendapatan Coffee: Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></h2>
        </div>
        <br>

        <table border="1" class="table">
            <tr>
                <th>Nomer</th>
                <th>Id Transaksi</th>
                <th>Id User</th>
                <th>Id Produk</th>
                <th>Jumlah</th>
                <th>Total Transaksi</th>
                <th>Metode Transaksi</th>
                <th>Tanggal Transaksi</th>            
                <th>Waktu Transaksi</th>            
                <th>Action</th> 
            </tr>
            <?php
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $data['id_transaksi']; ?></td>
                <td><?php echo $data['id_user']; ?></td>
                <td><?php echo $data['id_produk']; ?></td>
                <td><?php echo $data['jumlah']; ?></td>
                <td><?php echo number_format($data['total_transaksi'], 0, ',', '.'); ?></td>
                <td><?php echo $data['metode_transaksi']; ?></td>
                <td><?php echo $data['tanggal_transaksi']; ?></td>
                <td><?php echo $data['waktu_transaksi']; ?></td>
                <td><a href="admintransaksihapus.php?id=<?php echo $data['id_transaksi']; ?>" class="btn-1">Hapus</a></td>
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
