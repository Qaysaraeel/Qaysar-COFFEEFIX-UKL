<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../koneksi.php';
$username = $_SESSION['username'];

// Fetch user data
$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($mysqli));
}

$userData = mysqli_fetch_assoc($result);
$id_user = $userData['id_user'];

// Proses penambahan produk ke keranjang
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Ambil keranjang dari session, atau buat keranjang baru jika belum ada
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = array();
    }

    // Tambahkan produk ke keranjang
    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk]++;
    } else {
        $_SESSION['keranjang'][$id_produk] = 1;
    }

    // Redirect ke halaman keranjang
    header("Location: keranjang.php");
    exit();
}

// Proses penghapusan produk dari keranjang
if (isset($_GET['hapus'])) {
    $id_produk = $_GET['hapus'];

    // Hapus produk dari keranjang
    if (isset($_SESSION['keranjang'][$id_produk])) {
        unset($_SESSION['keranjang'][$id_produk]);
    }

    // Redirect ke halaman keranjang
    header("Location: keranjang.php");
    exit();
}

// Proses update jumlah produk
if (isset($_POST['update_jumlah'])) {
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    // Update jumlah produk di keranjang
    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk] = $jumlah;
    }

    // Redirect ke halaman keranjang
    header("Location: keranjang.php");
    exit();
}

// Proses penyimpanan transaksi
if (isset($_POST['submit'])) {
    $keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array();
    $metode_transaksi = $_POST['metode_transaksi'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $waktu_transaksi = $_POST['waktu_transaksi'];

    foreach ($keranjang as $id_produk => $jumlah) {
        $query_produk = "SELECT * FROM products WHERE id_produk = '$id_produk'";
        $result_produk = mysqli_query($mysqli, $query_produk);
        $produk = mysqli_fetch_assoc($result_produk);
        $total_transaksi = $produk['harga_produk'] * $jumlah;

        // Insert data transaksi ke tabel transaksi
        $query_transaksi = "INSERT INTO transaksi (id_user, id_produk, jumlah, total_transaksi, metode_transaksi, tanggal_transaksi, waktu_transaksi) 
                            VALUES ('$id_user', '$id_produk', '$jumlah', '$total_transaksi', '$metode_transaksi', '$tanggal_transaksi', '$waktu_transaksi')";
        
        mysqli_query($mysqli, $query_transaksi);
    }

    // Kosongkan keranjang setelah transaksi
    unset($_SESSION['keranjang']);
    header("Location: riwayatbeli.php");
    exit();
}

// Ambil keranjang dari session
$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="keranjang.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months start at 0!
    const dd = String(today.getDate()).padStart(2, '0');

    const formattedToday = yyyy + '-' + mm + '-' + dd;
    document.getElementById('tanggal_transaksi').value = formattedToday;
    });

    function setCurrentTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const currentTime = `${hours}:${minutes}`;
        document.getElementById('waktu_transaksi').value = currentTime;
        }

        window.onload = setCurrentTime;
    </script>
    
</head>
<body>
<header>
        <a href="#" class="logo">
            <img src="img/logo.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        
        <div class="header-icon">
            <a href="#"><i class='bx bx-searchiu' id="search-icon"></i></a>
        </div>
        <div class="search-box">
            <input type="search" name="" id="" placeholder="Search Here...">
        </div>
        <ul class="navbar">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="produk.php">menu</a></li>
            <li><a href="keranjang.php">Keranjang</a></li>
            <li><a href="riwayatbeli.php">Riwayat Pembelian</a></li>
            <li><a href="peringkat.php">Peringkat Pembelian</a></li>
            <li><a href="profil.php">Profil</a></li>
        </ul>
    </header>
    <br><br><br>
    <section class="keranjang">
        <h1>Keranjang Belanja</h1><br>
        <?php if (empty($keranjang)) : ?>
            <p>Keranjang belanja kosong.</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="keranjang-body">
                    <?php
                    $total_bayar = 0;
                    foreach ($keranjang as $id_produk => $jumlah) :
                        $query = "SELECT * FROM products WHERE id_produk = '$id_produk'";
                        $result = mysqli_query($mysqli, $query);
                        $produk = mysqli_fetch_assoc($result);
                        $total_harga = $produk['harga_produk'] * $jumlah;
                        $total_bayar += $total_harga;
                    ?>
                        <tr data-id="<?php echo $id_produk; ?>" data-harga="<?php echo $produk['harga_produk']; ?>">
                            <td><img src="../admin/img/<?php echo $produk['gambar_produk']; ?>" width="50" alt="<?php echo $produk['nama_produk']; ?>"></td>
                            <td><?php echo $produk['nama_produk']; ?></td>
                            <td>Rp <?php echo number_format($produk['harga_produk'], 0, ',', '.'); ?></td>
                            <td>
                                <form action="keranjang.php" method="POST">
                                    <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>">
                                    <input type="number" name="jumlah" value="<?php echo $jumlah; ?>" min="1" class="jumlah-input" onchange="this.form.submit()">
                                    <input type="hidden" name="update_jumlah" value="1">
                                </form>
                            </td>
                            <td class="total-harga">Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></td>
                            <td><a href="keranjang.php?hapus=<?php echo $id_produk; ?>" class="btn">Hapus</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Total Bayar</td>
                        <td id="total-bayar">Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <form action="keranjang.php" method="POST">
                <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>">

                <div class="form-group">
                    <label for="metode_transaksi">Metode Transaksi:</label>
                    <select id="metode_transaksi" name="metode_transaksi" required>
                        <option value="Cash">Cash</option>
                        <option value="Debit">Debit</option>
                        <option value="Credit">Credit</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="total_transaksi">Total Transaksi:</label>
                    <span id="total_transaksi">Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></span>
                    <input type="hidden" id="total_transaksi_hidden" name="total_transaksi" value="<?php echo $total_bayar; ?>">
                </div>

                <div class="form-group">
                    <label for="tanggal_transaksi">Tanggal Transaksi:</label>
                    <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" required>
                </div>

                <div class="form-group">
                    <label for="waktu_transaksi">Waktu Transaksi:</label>
                    <input type="time" id="waktu_transaksi" name="waktu_transaksi" required>
                </div>

                <input type="submit" value="Beli Sekarang" name="submit">
            </form>
        <?php endif; ?>
    </section>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const jumlahInputs = document.querySelectorAll(".jumlah-input");
        const totalBayarElement = document.getElementById("total-bayar");
        const totalTransaksiElement = document.getElementById("total_transaksi");
        const totalTransaksiHidden = document.getElementById("total_transaksi_hidden");

        jumlahInputs.forEach(input => {
            input.addEventListener("input", function() {
                let totalBayar = 0;

                jumlahInputs.forEach(i => {
                    const tr = i.closest("tr");
                    const harga = parseInt(tr.getAttribute("data-harga"));
                    const jumlah = parseInt(i.value);
                    const totalHargaElement = tr.querySelector(".total-harga");
                    const totalHarga = harga * jumlah;
                    totalHargaElement.textContent = "Rp " + totalHarga.toLocaleString('id-ID');
                    totalBayar += totalHarga;
                });

                totalBayarElement.textContent = "Rp " + totalBayar.toLocaleString('id-ID');
                totalTransaksiElement.textContent = "Rp " + totalBayar.toLocaleString('id-ID');
                totalTransaksiHidden.value = totalBayar;
            });
        });
    });
    </script>

    <section class="products" id="products">
        <br><br>
        <div class="heading">
            <h1>SEMUA MENU</h1>
        </div><br>
        <div class="search" id="search">
            <input type="search" id="search-input" placeholder="Cari menu disini..."> <br><br>
            <h3>KATEGORI:</h3><br>
            <button class="btn active" data-filter="all">Semua menu</button>
            <button class="btn" data-filter="coffee">Coffee</button>
            <button class="btn" data-filter="makanan">Makanan</button>
            <button class="btn" data-filter="non-coffee">Non-Coffee</button>
        </div>
        <div class="products-container" id="products-container">
    <?php
    include '../koneksi.php';
    $query_mysql = "
        SELECT p.id_produk, p.nama_produk, p.kategori, p.harga_produk, p.gambar_produk, 
               AVG(t.rating) as avg_rating, COUNT(t.rating) as rating_count
        FROM products p
        LEFT JOIN transaksi t ON p.id_produk = t.id_produk
        GROUP BY p.id_produk, p.nama_produk, p.kategori, p.harga_produk, p.gambar_produk
    ";
    $result = mysqli_query($mysqli, $query_mysql) or die(mysqli_error($mysqli));
    $counter = 0; // Initialize counter
    while($data = mysqli_fetch_array($result)) {
    ?>
    <div class="box" data-category="<?php echo strtolower($data['kategori']); ?>">
        <a href="detailproduk.php?id=<?php echo $data['id_produk']; ?>">
            <img src="../admin/img/<?php echo $data["gambar_produk"]; ?>" width="200" title="<?php echo $data['gambar_produk']; ?>">
            <h3><?php echo htmlspecialchars($data['nama_produk']); ?></h3>
        </a>
        <p><?php echo htmlspecialchars($data['kategori']); ?></p>
        <h4>Rp: <?php echo number_format($data['harga_produk'], 0, ',', '.'); ?></h4>
        <?php 
        if (!is_null($data['avg_rating'])) { 
            $rating = $data['avg_rating'];
            $rating_count = $data['rating_count'];
            $full_stars = floor($rating);
            $half_star = ceil($rating - $full_stars);
            $empty_stars = 5 - $full_stars - $half_star;
            echo "<p> ";
            // Full stars
            for ($i = 0; $i < $full_stars; $i++) {
                echo "<i class='bx bxs-star'></i>";
            }
            // Half star
            if ($half_star) {
                echo "<i class='bx bxs-star-half'></i>";
            }
            // Empty stars
            for ($i = 0; $i < $empty_stars; $i++) {
                echo "<i class='bx bx-star'></i>";
            }
            echo " (" . number_format($rating, 1) . "/5) " . "Dari ". $rating_count . " rating" . "</p>" ;
        } else {
            echo "<p>Belum ada rating</p>";
        }
        ?>
        <br>
        <div class="content">
            <h3><a href="keranjang.php?id=<?php echo $data['id_produk']; ?>" class="btn">Masukan Keranjang</a></h3>  
        </div>
    </div>
    <?php } ?>
    </div>
        <br><br>
    </section>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("search-input");
        const productsContainer = document.getElementById("products-container");
        const productItems = Array.from(productsContainer.getElementsByClassName("box"));
        const filterButtons = document.querySelectorAll(".search .btn");

        // Menampilkan semua item produk saat halaman dimuat
        productItems.forEach(item => {
            item.style.display = "block";
        });

        searchInput.addEventListener("input", function() {
            const query = searchInput.value.toLowerCase();

            productItems.forEach(item => {
                const productNameElement = item.querySelector("h3");
                const productCategoryElement = item.querySelector("p");
                const productName = productNameElement.textContent.toLowerCase();
                const productCategory = productCategoryElement.textContent.toLowerCase();

                if (productName.includes(query) || productCategory.includes(query)) {
                    item.style.display = "block";
                    highlightText(productNameElement, query);
                    highlightText(productCategoryElement, query);
                } else {
                    item.style.display = "none";
                }
            });
        });

        filterButtons.forEach(button => {
            button.addEventListener("click", function() {
                const filter = button.getAttribute("data-filter");

                filterButtons.forEach(btn => btn.classList.remove("active"));
                button.classList.add("active");

                productItems.forEach(item => {
                    const productCategory = item.getAttribute("data-category");

                    if (filter === "all" || productCategory === filter) {
                        item.style.display = "block";
                    } else {
                        item.style.display = "none";
                    }
                });
            });
        });

        function highlightText(element, query) {
            const innerHTML = element.innerHTML;
            const cleanText = innerHTML.replace(/<\/?span[^>]*>/g, ''); 
            const regex = new RegExp(`(${query})`, 'gi');
            const newHTML = cleanText.replace(regex, `<span class="highlight">$1</span>`);
            element.innerHTML = newHTML;
        }
    });
    </script>

    <script src="main.js"></script>
</body>
</html>

</body>
</html>
