<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="styleuptade.css">
</head>
<body>
    <div class="container">
        <header>
            <h1 class="title">Tambah Produk</h1>
        </header>
        <section class="form">
            <form action="adminproduktambah.php" method="POST">

                <input type="text" id="nama_produk" name="nama_produk" placeholder="Nama produk"><br>

                <input type="text" id="harga_produk" name="harga_produk" placeholder="Harga produk"><br>

                <input type="text" id="stock" name="stock" placeholder="Stock"><br><br>
                <input type="submit" name="submit" class="button" value="Tambah Produk">

                <?php
                if(isset($_POST['submit'])){
                    $nama_produk = $_POST['nama_produk'];
                    $harga_produk = $_POST['harga_produk'];
                    $stock = $_POST['stock'];

                    include_once("../koneksi.php");

                    $result = mysqli_query($mysqli,
                    "INSERT INTO products(nama_produk, harga_produk, stock) VALUES ('$nama_produk', '$harga_produk', '$stock')");

                    header("location:adminproduk.php");
                }
                ?>

            </form>
        </section>
    </div>
</body>
</html>
