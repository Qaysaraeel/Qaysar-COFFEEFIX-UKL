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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];
    $total_transaksi = $_POST['total_transaksi'];
    $metode_transaksi = $_POST['metode_transaksi'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];
    $waktu_transaksi = $_POST['waktu_transaksi'];

    // Insert transaction into the database
    $query = "INSERT INTO transaksi (id_user, id_produk,jumlah, total_transaksi, metode_transaksi, tanggal_transaksi,waktu_transaksi) VALUES ('$id_user', '$id_produk','$jumlah', '$total_transaksi', '$metode_transaksi', '$tanggal_transaksi','$waktu_transaksi')";
    if (mysqli_query($mysqli, $query)) {
        echo "<script>
        alert('Successfully Added');
        document.location.href = 'riwayatbeli.php';
    </script>";
    } else {
        echo "<p>Error: " . mysqli_error($mysqli) . "</p>";
    }
}

// Display product details
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $query = "
        SELECT products.id_produk, products.nama_produk, products.harga_produk, products.gambar_produk, user.username 
        FROM products 
        JOIN user ON user.id_user = $id_user
        WHERE products.id_produk = $id_produk
    ";
    $result = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Beli menu</title>
<link rel="icon" type="image/png" href="../logotitle.png">
<link rel="stylesheet" href="beliy.css">
<style>
        .highlight {
            background-color: yellow;
            color: red;
        }
        .heading {
            text-align: center;
        }
    </style>
<script>
    function updateTotalTransaksi() {
    var harga = <?php echo $row['harga_produk']; ?>;
    var jumlah = document.getElementById('jumlah').value;
    var total = harga * jumlah;
    document.getElementById('total_transaksi').innerText = 'Rp ' + total;
    document.getElementById('total_transaksi_hidden').value = total;
                    }
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
        <ul class="navbar">
            <li><a href="index.php">Kembali ke Halaman Utama</a></li>
            <li><a href="riwayatbeli.php">Riwayat pembelian</a></li>
            <li><a href="peringkat.php">Peringkat Pembelian</a></li>
        </ul>
        <ul class="navbar">
            <li><a href="profil.php">profil</a></li>
        </ul>
    </header>
    
    <div class="product-details">
            <h2><?php echo $row['nama_produk']; ?></h2>
            <img src="../admin/img/<?php echo $row['gambar_produk']; ?>" alt="<?php echo $row['nama_produk']; ?>" width="200">
            <p>Price: Rp <?php echo $row['harga_produk']; ?></p>
            <p>Username: <?php echo $userData['username']; ?></p>

            <form action="belimenu.php" method="POST">
                <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">

                <label for="jumlah">Jumlah:</label>
                <input type="number" id="jumlah" name="jumlah" value="1" min="1" oninput="updateTotalTransaksi()" required><br><br>
            
                <div class="form-group">
                    <label for="total_transaksi">Total Transaksi:</label>
                    <span id="total_transaksi">Rp <?php echo $row['harga_produk']; ?></span>
                    <input type="hidden" id="total_transaksi_hidden" name="total_transaksi" value="<?php echo $row['harga_produk']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="metode_transaksi">Metode Transaksi:</label>
                    <select id="metode_transaksi" name="metode_transaksi" required>
                        <option value="Cash">Cash</option>
                        <option value="Debit">Debit</option>
                        <option value="Credit">Credit</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_transaksi">Tanggal Transaksi:</label>
                    <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" placeholder="yyyy-mm-dd" required>
                </div>

                <div class="form-group">
                    <label for="waktu_transaksi">Waktu Transaksi:</label>
                    <input type="time" id="waktu_transaksi" name="waktu_transaksi">
                </div>

            <input type="submit" value="Beli Sekarang" name="submit">
        </form>
    </div>

    <section class="products" id="products">
        <br><br>
        <div class="heading">
            <h2>SEMUA MENU</h2>
        </div><br>
        <div class="search" id="search">
            <input type="search" id="search-input" placeholder="Cari menu disini..."> <br><br>
            <h3>KATEGORI:</h3>
            <button class="btn active" data-filter="all">Semua menu</button>
            <button class="btn" data-filter="coffee">Coffee</button>
            <button class="btn" data-filter="makanan">Makanan</button>
            <button class="btn" data-filter="non-coffee">Non-Coffee</button>
        </div>
        <div class="products-container" id="products-container">
            <?php
            include '../koneksi.php';
            $query_mysql = mysqli_query($mysqli, "SELECT * FROM products") or die(mysqli_error($mysqli));
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <div class="box" data-category="<?php echo strtolower($data['kategori']); ?>">
                <img src="../admin/img/<?php echo $data["gambar_produk"]; ?>" width="200" title="<?php echo $data['gambar_produk']; ?>">
                <h3><?php echo $data['nama_produk']; ?></h3>
                <p><?php echo $data['kategori']; ?></p>
                <h4>Rp: <?php echo $data['harga_produk']; ?></h4><br>
                <div class="content">
                    <h3><a href="belimenu.php?id=<?php echo $data['id_produk']; ?>" class="btn">Beli</a></h3>
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


        <?php
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID not provided.";
}

mysqli_close($mysqli);
?>
