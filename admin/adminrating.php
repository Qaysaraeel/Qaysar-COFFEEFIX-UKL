<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Data Rating</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
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
            <li><a href="admintransaksi.php">Transaksi</a></li>
            <li><a href="adminmassage.php">Kritik/Saran</a></li>
            <li><a href="adminrating.php">Rating/Ulasan</a></li>
            <li><a href="profil.php">Profil</a></li>
        </ul>
    </header>
    <section class="user">
        <h1 class="heading">Data Rating/Ulasan</h1>
        <br>
        <a href="../index.php" class="btn">Log Out</a>
        <br><br>
        <input type="text" id="searchInput" placeholder="Cari berdasarkan nama pengguna">
        <br><br>
        <table border="1" class="table" id="ratingTable">
            <tr>
                <th>Nomor</th>
                <th>Rating yang diberikan</th>
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
                $rating = $data['rating'];
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td>
                    <?php
                    $full_stars = floor($rating);
                    $half_star = ceil($rating - $full_stars);
                    $empty_stars = 5 - $full_stars - $half_star;
                    for ($i = 0; $i < $full_stars; $i++) {
                        echo "<i class='bx bxs-star'></i>";
                    }
                    if ($half_star) {
                        echo "<i class='bx bxs-star-half'></i>";
                    }
                    for ($i = 0; $i < $empty_stars; $i++) {
                        echo "<i class='bx bx-star'></i>";
                    }
                    ?>
                </td>
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
    <script>
        document.getElementById("searchInput").addEventListener("input", function() {
            var input, filter, table, tr, td, i, txtValue;
            input = this.value.toUpperCase();
            table = document.getElementById("ratingTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2]; // index 2 karena Username
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(input) > -1) {
                        tr[i].style.display = "";
                        // Menyorot nama pengguna yang cocok dengan pencarian
                        var regex = new RegExp('(' + input + ')', 'ig');
                        td.innerHTML = txtValue.replace(regex, "<span class='highlight'>$1</span>");
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        });
    </script>
    <script src="main.js"></script>
</body>
</html>
