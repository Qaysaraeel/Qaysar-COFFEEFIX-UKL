<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman data TRANSACTION</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="style1.css">
    <style>
        /* CSS untuk gaya pencarian dan filter */
        .filter-input {
            padding: 8px;
            margin-bottom: 10px;
            width: 400px;
            display: block;
        }

        /* CSS untuk penyorotan */
        .highlight {
            background-color: yellow;
            color: red;
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
        <h1 class="heading">Data Transaksi</h1>
        <br>
        <a href="../index.php" class="btn">Log Out</a>
        <br><br>
        <input type="text" id="searchInput" class="filter-input" placeholder="Cari berdasarkan nama pengguna">
        <input type="date" id="dateInput" class="filter-input" placeholder="Filter berdasarkan tanggal">
        <?php
        include '../koneksi.php';
        
        // Fetch all transactions with JOIN to get username and nama_produk
        $query_mysql = mysqli_query($mysqli, "
            SELECT transaksi.*, user.username, products.nama_produk 
            FROM transaksi 
            JOIN user ON transaksi.id_user = user.id_user 
            JOIN products ON transaksi.id_produk = products.id_produk
            ORDER BY transaksi.tanggal_transaksi DESC, transaksi.waktu_transaksi DESC
        ") or die(mysqli_error($mysqli));

        // Calculate total pendapatan
        $total_pendapatan_query = mysqli_query($mysqli, "SELECT SUM(total_transaksi) AS total_pendapatan FROM transaksi") or die(mysqli_error($mysqli));
        $total_pendapatan_result = mysqli_fetch_assoc($total_pendapatan_query);
        $total_pendapatan = $total_pendapatan_result['total_pendapatan'];
        ?>

        <style>
            h2 {
                color: #fff;
            }
        </style>

        <div class="total-pendapatan">
            <h2>Total Pendapatan Coffee: Rp <span id="totalPendapatan"><?php echo number_format($total_pendapatan, 0, ',', '.'); ?></span></h2>
        </div>
        <br>

        <table border="1" class="table" id="transaksiTable">
            <tr>
                <th>Nomor</th>
                <th>Username</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Total Transaksi</th>
                <th>Metode Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Waktu Transaksi</th>
                <th>Rating</th>
                <th>Action</th>
            </tr>
            <?php
            $total_rows = mysqli_num_rows($query_mysql);
            $nomor = $total_rows; // Mulai nomor dari jumlah total baris
            while ($data = mysqli_fetch_array($query_mysql)) {
            ?>
            <tr>
                <td><?php echo $nomor--; ?></td> <!-- Urutan nomor dibalik -->
                <td><?php echo $data['username']; ?></td>
                <td><?php echo $data['nama_produk']; ?></td>
                <td><?php echo $data['jumlah']; ?></td>
                <td class="total_transaksi"><?php echo number_format($data['total_transaksi'], 0, ',', '.'); ?></td>
                <td><?php echo $data['metode_transaksi']; ?></td>
                <td><?php echo $data['tanggal_transaksi']; ?></td>
                <td><?php echo $data['waktu_transaksi']; ?></td>
                <td><?php echo $data['rating']; ?></td>
                <td><a href="admintransaksihapus.php?id=<?php echo $data['id_transaksi']; ?>" class="btn-hapus">Hapus</a></td>
            </tr>
            <?php } ?>
        </table>
        <br><br>
    </section>

    <script>
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount).replace(/\D00(?=\D*$)/, '');
        }

        function updateTotalPendapatan() {
            var table, tr, td, i, total = 0;
            table = document.getElementById("transaksiTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) { // Mulai dari 1 untuk melewatkan header
                if (tr[i].style.display !== "none") {
                    td = tr[i].getElementsByClassName("total_transaksi")[0];
                    if (td) {
                        total += parseInt(td.innerText.replace(/[^\d]/g, ''));
                    }
                }
            }
            document.getElementById("totalPendapatan").innerText = formatRupiah(total);
        }

        document.getElementById("searchInput").addEventListener("input", function() {
            var input, filter, table, tr, td, i, txtValue;
            input = this.value.toUpperCase();
            table = document.getElementById("transaksiTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                td = tr[i].getElementsByTagName("td")[1]; // index 1 karena Username
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
            updateTotalPendapatan();
        });

        document.getElementById("dateInput").addEventListener("change", function() {
            var input, filter, table, tr, td, i, txtValue;
            input = this.value;
            table = document.getElementById("transaksiTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                td = tr[i].getElementsByTagName("td")[6]; // index 6 karena Tanggal Transaksi
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue === input || input === "") { // Menampilkan semua jika input kosong
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            updateTotalPendapatan();
        });
    </script>

    <script src="main.js"></script>
</body>
</html>
