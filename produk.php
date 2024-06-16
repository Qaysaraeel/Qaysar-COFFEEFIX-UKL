<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee</title>
    <link rel="stylesheet" href="user/index1.css">
    <link rel="icon" type="image/png" href="logotitle.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        .highlight {
            background-color: yellow;
            color: red;
        }
        header {
            background-color: #1b1b1b;
        }
        .love{
            display: inline-flex;
        }
        .bxs-heart {
            color: black;
            font-size:40px;
            margin:7px;
        }
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .popup {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            position: relative;
        }
        .popup h2 {
            margin: 0 0 10px;
        }
        .popup p {
            margin: 0 0 20px;
        }
        .popup a {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background: #bc9667;
            border-radius: 5px;
            text-decoration: none;
        }
        .popup a:hover {
            background: #8a6f4d;
        }
        .popup .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
        }
        #btn{
        padding: 10px 30px;
        border-radius: 0.3rem;
        background: var(--main-color);
        color: var(--bg-color);
        font-weight: 500;
        }
        #btn:hover{
        background: #8a6f4d;
        }
    </style>
</head>
<body>
    <?php
    // Misalnya Anda mendapatkan id_user dari sesi PHP
    session_start();
    $id_user = $_SESSION['id_user'];
    echo "<script>var id_user = $id_user;</script>";
    ?>
    
    <header>
        <a href="#" class="logo">
            <img src="user/img/logo.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        
        <div class="header-icon">
            <a href="#"><i class='bx bx-seacrh' id="search-icon"></i></a>
        </div>
        <div class="search-box">
            <input type="search" name="" id="" placeholder="Search Here...">
        </div>
        <ul class="navbar">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="produk.php">menu</a></li>
            <li><a href="#" class="login-required">Keranjang</a></li>
            <li><a href="#" class="login-required">riwayat pembelian</a></li>
            <li><a href="peringkat.php">Peringkat pembelian</a></li>
            <li><a href="loginnya.php">login</a></li>
        </ul>
    </header>

    <section class="products" id="products">
        <br><br><br><br>
        <div class="heading">
            <h2>SEMUA MENU</h2>
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
            include 'koneksi.php';
            $query_mysql = "
                SELECT p.id_produk, p.nama_produk, p.kategori, p.harga_produk, p.gambar_produk, 
                       AVG(t.rating) as avg_rating, COUNT(t.rating) as rating_count
                FROM products p
                LEFT JOIN transaksi t ON p.id_produk = t.id_produk
                GROUP BY p.id_produk, p.nama_produk, p.kategori, p.harga_produk, p.gambar_produk
            ";
            $result = mysqli_query($mysqli, $query_mysql) or die(mysqli_error($mysqli));
            while($data = mysqli_fetch_array($result)) {
            ?>
            <div class="box" data-category="<?php echo strtolower($data['kategori']); ?>">
        <a href="detailproduk.php?id=<?php echo $data['id_produk']; ?>">
            <img src="admin/img/<?php echo $data["gambar_produk"]; ?>" width="200" title="<?php echo $data['gambar_produk']; ?>">
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
            <h3><a href="#" class="login-required" id="btn">Masukan Keranjang</a></h3>  
        </div>
    </div>
    <?php } ?>
    </div>
        <br><br>
    </section>
    <div class="popup-overlay" id="popup-overlay">
        <div class="popup">
            <button class="close-btn" id="close-btn">&times;</button>
            <h2>Login Diperlukan</h2>
            <p>Anda perlu login untuk mengakses fitur ini.</p>
            <a href="loginnya.php">Login Sekarang</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginRequiredLinks = document.querySelectorAll('.login-required');
            const popupOverlay = document.getElementById('popup-overlay');
            const closeBtn = document.getElementById('close-btn');

            loginRequiredLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    popupOverlay.style.display = 'flex';
                });
            });

            closeBtn.addEventListener('click', function() {
                popupOverlay.style.display = 'none';
            });

            popupOverlay.addEventListener('click', function(event) {
                if (event.target === popupOverlay) {
                    popupOverlay.style.display = 'none';
                }
            });
        });
    </script>
    

    <script>
        document.querySelectorAll('.bx.bxs-heart').forEach(icon => {
    icon.addEventListener('click', function() {
        // Tangkap ID produk
        const id_produk = this.getAttribute('data-id');
        // Periksa apakah ikon telah diklik sebelumnya
        const isClicked = this.classList.contains('clicked');
        
        if (isClicked) {
            // Jika sudah diklik, hapus status dari localStorage dan ubah warna menjadi hitam
            localStorage.removeItem(`favorite_${id_produk}`);
            this.style.color = 'black';
            this.classList.remove('clicked');
            // Lakukan apa yang diperlukan ketika menghapus dari favorit, contohnya:
            // window.location.href = `hapusfavorit.php?id_user=${id_user}&id_produk=${id_produk}`;
        } else {
            // Jika belum diklik, simpan status ke localStorage, ubah warna menjadi merah
            localStorage.setItem(`favorite_${id_produk}`, 'true');
            this.style.color = 'red';
            this.classList.add('clicked');
            // Lakukan apa yang diperlukan ketika menambahkan ke favorit, contohnya:
            // window.location.href = `menufavorit.php?id_user=${id_user}&id_produk=${id_produk}`;
        }
    });
});

// Saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.bx.bxs-heart').forEach(icon => {
        const id_produk = icon.getAttribute('data-id');
        // Periksa status dari localStorage
        const isFavorite = localStorage.getItem(`favorite_${id_produk}`);
        if (isFavorite) {
            // Jika sudah ditandai sebagai favorit, ubah warna menjadi merah
            icon.style.color = 'red';
            icon.classList.add('clicked');
        }
    });
});


    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("search-input");
        const productsContainer = document.getElementById("products-container");
        const productItems = Array.from(productsContainer.getElementsByClassName("box"));
        const filterButtons = document.querySelectorAll(".search .btn");

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

        document.querySelectorAll('.bx.bxs-heart').forEach(icon => {
            icon.addEventListener('click', function() {
                const id_produk = this.getAttribute('data-id');
                window.location.href = `menufavorit.php?id_user=${id_user}&id_produk=${id_produk}`;
            });
        });
    });
    </script>

    <script src="main.js"></script>
</body>
</html>
