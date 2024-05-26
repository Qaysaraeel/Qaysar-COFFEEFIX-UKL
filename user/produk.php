<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee</title>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        .highlight {
            background-color: yellow;
            color: red;
        }
        header {
            background-color: #1b1b1b;
        }
    </style>
</head>
<body>
    <header>
        <a href="#" class="logo">
            <img src="img/logo.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        <ul class="navbar">
            <li><a href="index.php">Kembali ke Halaman Utama</a></li>
        </ul>
        <div class="search-box">
            <input type="search" name="" id="" placeholder="Search Here...">
        </div>
        <ul class="navbar">
            <li><a href="riwayatbeli.php">Riwayat pembelian</a></li>
            <li><a href="peringkat.php">Peringkat Pembelian</a></li>
            <li><a href="profil.php">Profil</a></li>
        </ul>
    </header>

    <section class="products" id="products">
        <br><br><br><br>
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
