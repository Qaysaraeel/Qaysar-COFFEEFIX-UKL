<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Barista - Pemesanan Masuk</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="index.css">
    <style>
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
        .lurus{
            display:flex;
            gap:10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <a href="#" class="logo">
            <img src="../user/img/logo.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        <ul class="navbar">
            <li><a href="index.php">Pemesanan Masuk</a></li>
            <li><a href="pemesananselesai.php">Pemesanan Selesai</a></li>
            <li><a href="profil.php">Profil</a></li>
        </ul>
    </header>

    <section class="user">
        <h1 class="heading">Pesanan untuk Diproses</h1>
        <br><br>
        <div class="lurus">
            <input type="text" id="searchInput" class="filter-input" placeholder="Cari berdasarkan nama pengguna">
            <input type="date" id="dateInput" class="filter-input" placeholder="Filter berdasarkan tanggal">
        </div>
        
        <br>
        <a href="../index.php" class="btn">Log Out</a><br><br>
        <?php
        include '../koneksi.php';

        $query_mysql = mysqli_query($mysqli, "
            SELECT transaksi.*, user.username, products.nama_produk 
            FROM transaksi 
            JOIN user ON transaksi.id_user = user.id_user 
            JOIN products ON transaksi.id_produk = products.id_produk
            WHERE transaksi.status != 'Pemesanan Selesai'
            ORDER BY transaksi.tanggal_transaksi DESC, transaksi.waktu_transaksi DESC
        ") or die(mysqli_error($mysqli));
        ?>

        <table border="1" class="table" id="transaksiTable">
            <tr>
                <th>Nomor</th>
                <th>Username</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Tanggal Transaksi</th>
                <th>Waktu Transaksi</th>
                <th>Action</th>
            </tr>
            <?php
            $total_rows = mysqli_num_rows($query_mysql);
            $nomor = $total_rows;
            while ($data = mysqli_fetch_array($query_mysql)) {
            ?>
            <tr>
                <td><?php echo $nomor--; ?></td>
                <td><?php echo $data['username']; ?></td>
                <td><?php echo $data['nama_produk']; ?></td>
                <td><?php echo $data['jumlah']; ?></td>
                <td><?php echo $data['tanggal_transaksi']; ?></td>
                <td><?php echo $data['waktu_transaksi']; ?></td>
                <td>
                    <?php if ($data['status'] == 'Konfirmasi') { ?>
                        <button class="btn" onclick="updateStatus(<?php echo $data['id_transaksi']; ?>, 'accept')">Konfirmasi</button>
                    <?php } elseif ($data['status'] == 'Pesanan di proses') { ?>
                        <button class="btn-2" onclick="updateStatus(<?php echo $data['id_transaksi']; ?>, 'process')">Buat pesanan</button>
                    <?php } elseif ($data['status'] == 'Pesanan sedang dibuat') { ?>
                        <button class="btn-3" onclick="updateStatus(<?php echo $data['id_transaksi']; ?>, 'complete')">Selesai</button>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </table>
        <br><br>
    </section>

    <script>
        function updateStatus(id, action) {
    $.ajax({
        url: 'updatestatus.php',
        type: 'POST',
        data: { id: id, action: action },
        success: function(response) {
            if ($.trim(response) == 'success') {
                if (action === 'complete') {
                    // Jika berhasil memperbarui status ke "Pemesanan Selesai", alihkan ke halaman pemesananselesai.php
                    window.location.href = 'index.php';
                } else {
                    location.reload();
                }
            } else {
                alert('Gagal memperbarui status pesanan.');
            }
        },
        error: function() {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    });
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
        });

        document.getElementById("dateInput").addEventListener("change", function() {
            var input, filter, table, tr, td, i, txtValue;
            input = this.value;
            table = document.getElementById("transaksiTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                td = tr[i].getElementsByTagName("td")[4]; // index 4 karena Tanggal Transaksi
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue === input || input === "") { // Menampilkan semua jika input kosong
                        tr[i].style.display = "";
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
