<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman data PRODUCTS</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
    <style>
        /* CSS untuk gaya pencarian */
        #searchInput {
            padding: 8px;
            margin-bottom: 10px;
            width: 400px;
        }

        /* CSS untuk penyorotan */
        .highlight {
            background-color: yellow;
            color:red;
        }
    </style>
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
        <h1 class="heading">Data Produk</h1>
        <br>
        <a href="../index.php" class="btn">Log Out</a>
        <a href="adminproduktambah.php" class="btn">Tambah Produk</a>
        <br><br>
        <input type="text" id="searchInput" placeholder="Cari berdasarkan nama produk">
        <br><br>
        <table border="1" class="table" id="produkTable">
            <tr>
                <th>Nomer</th>
                <th>Name Products</th>
                <th>Kategory</th>
                <th>Price Products</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Action</th>
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
                <td><?php echo $data['nama_produk']; ?></td>
                <td><?php echo $data['kategori']; ?></td>
                <td><?php echo $data['harga_produk']; ?></td>
                <td><?php echo $data['deskripsi']; ?></td>
                <td><img src="img/<?php echo $data["gambar_produk"]; ?>" width="200" title="<?php echo $data['gambar_produk']; ?>"></td>
                <td><a href="adminprodukhapus.php?id=<?php echo $data['id_produk']; ?>" class="btn-hapus">Hapus</a></td>
                <td><a href="adminprodukuptade.php?id=<?php echo $data['id_produk']; ?>" class="btn-update">Update</a></td>
            </tr>
            <?php } ?>
        </table>
        <br><br>
        <a href="../index.php" class="btn">Log Out</a>
    </section>
    
    <script>
        document.getElementById("searchInput").addEventListener("input", function() {
            var input, filter, table, tr, td, i, txtValue;
            input = this.value.toUpperCase();
            table = document.getElementById("produkTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // index 1 karena Nama Produk
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(input) > -1) {
                        tr[i].style.display = "";
                        // Menyorot nama produk yang cocok dengan pencarian
                        var regex = new RegExp('(' + input + ')', 'ig');
                        td.innerHTML = txtValue.replace(regex, "<span class='highlight'>$1</span>");
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        });
    </script>
</body>
</html>
