<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../koneksi.php';
$username = $_SESSION['username'];

$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($mysqli));
}

$userData = mysqli_fetch_assoc($result);

mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee</title>
    <link rel="stylesheet" href="index1.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
    .navbar li:hover .dropdown {
        display: block;
    }
    .dropdown {
        display: none;
        position: absolute;
        z-index: -10000;
        background: #1b1b1b;
        border-radius: 10px;
    }
    .dropdown li {
        float: none;
    }
</style>
</head>
<body>
    <header>
        <a href="#" class="logo">
            <img src="img/logo.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        
        <div class="header-icon">
            <a href="#"><i class='bx bx-seacrh' id="search-icon"></i></a>
        </div>
        <div class="search-box">
            <input type="search" name="" id="" placeholder="Search Here...">
        </div>
        <ul class="navbar">
    <li>
        <a href="#home">Beranda</a>
        <ul class="dropdown">
        <br><li><a href="#about">Tentang</a></li><br>
            <li><a href="#products">Menu populer</a></li><br>
            <li><a href="#customers">Ulasan</a></li><br>
            <li><a href="#contact">Hubungi kami</a></li><br>
        </ul>
    </li>
    <li><a href="produk.php">Menu</a></li>
    <li><a href="keranjang.php">Keranjang</a></li>
    <li><a href="riwayatbeli.php">Riwayat Pembelian</a></li>
    <li><a href="peringkat.php">Peringkat Pembelian</a></li>
    <li><a href="profil.php">Profil</a></li>
</ul>

    </header>

    <section class="home" id="home">
        <div class="home-text">
            <h1>Nikmati Kesempurnaan <br> di Setiap Tegukan</h1>
            <p>Temukan kenikmatan kopi sejati dengan setiap tegukan. Kami menghadirkan biji kopi pilihan yang diproses dengan penuh dedikasi untuk memberikan pengalaman rasa yang tiada duanya. Setiap cangkir kopi kami adalah cerminan dari kualitas, keahlian, dan cinta pada kopi.</p>
            <a href="#products" class="btn">Beli Sekarang</a>
        </div>
        <div class="home-img">
            <img src="img/main.png" alt="">
        </div>
    </section>
     
    <section class="about" id="about">
        <div class="about-img">
            <img src="img/about1.jpg" alt="">
        </div>
        <div class="about-text">
            <h2>Tentang Kami</h2>
            <p>Selamat datang di COFFEE, tempat di mana kecintaan pada kopi bertemu dengan keahlian dalam setiap cangkir. Kami berdedikasi untuk menghadirkan pengalaman kopi yang luar biasa bagi Anda, dari biji kopi pilihan hingga proses penyeduhan yang sempurna.</p><br>
            <a href="https://id.wikipedia.org/wiki/Kopi" class="btn">Pelajari Lebih Lanjut</a>
        </div>
    </section>

    <section class="products" id="products">
    <div class="heading">
        <h2>Rekomendasi untukmu</h2>
    </div><br>
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

    // Fetch all results into an array
    $products = [];
    while ($data = mysqli_fetch_array($result)) {
        $products[] = $data;
    }

    // Select 3 random keys from the products array
    $random_keys = array_rand($products, 3);

    foreach ($random_keys as $key) {
        $data = $products[$key];
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
    <a href="produk.php" class="btn">Lihat Semua Menu</a>
</section>


<section class="customers" id="customers">
    <div class="heading">
        <h2>Ulasan Customer</h2>
    </div>
    <div class="customers-container">
        <?php
        include '../koneksi.php';
        $query = "
            SELECT rating.*, user.username, user.foto_profil 
            FROM rating
            JOIN user ON rating.id_user = user.id_user
        ";
        $query_mysql = mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));

        // Fetch all results into an array
        $reviews = [];
        while ($data = mysqli_fetch_array($query_mysql)) {
            $reviews[] = $data;
        }

        // Select 4 random keys from the reviews array
        $random_keys = array_rand($reviews, 4);

        foreach ($random_keys as $key) {
            $data = $reviews[$key];
        ?>
        <div class="box">
            <div class="stars">
                <?php
                // Tampilkan bintang
                $rating = $data['rating'];
                $full_stars = floor($rating);
                $half_star = ceil($rating - $full_stars);
                $empty_stars = 5 - $full_stars - $half_star;
                
                // Bintang penuh
                for ($i = 0; $i < $full_stars; $i++) {
                    echo "<i class='bx bxs-star'></i>";
                }
                
                // Setengah bintang
                if ($half_star) {
                    echo "<i class='bx bxs-star-half'></i>";
                }
                
                // Bintang kosong
                for ($i = 0; $i < $empty_stars; $i++) {
                    echo "<i class='bx bx-star'></i>";
                }
                ?>
            </div>
            <p><?php echo $data['pesan']; ?></p>
            <h2><?php echo $data['username']; ?></h2>
            <img src="../user/img/<?php echo $data['foto_profil']; ?>" width="50" title="<?php echo $data['foto_profil']; ?>">
        </div>
        <?php } ?>
    </div>
    <br><br>
    <a href="rating.php" class="btn">Lihat semua ulasan</a>
    <a href="../admin/adminratingtambah.php?id_user=<?php echo $userData['id_user']; ?>" class="btn">Berikan ulasan!</a>
</section>



    <section class="contact" id="contact">
        <div class="content">
            <h2>Hubungi Kami</h2>
            <p>Kami sangat senang mendengar dari Anda! Baik Anda memiliki pertanyaan, umpan balik, atau hanya ingin berbagi pengalaman Anda tentang kopi kami, tim kami siap membantu.</p> <br>
        </div>
        <div class="container">
            <div class="contactInfo">
                <div class="box">
                    <div class="icon"><i class='bx bx-time'></i></div>
                    <div class="text">
                        <h3>Jam Operasional</h3>
                        <p>Setiap hari/24 jam</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class='bx bxs-map'></i></div>
                    <div class="text">
                        <h3>Alamat</h3>
                        <p>Jalan Kavling DPR Gang 1 No.40, Pucang, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61252</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class='bx bxs-phone'></i></div>
                    <div class="text">
                        <h3>No Telp</h3>
                        <p>0881-0366-47856</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class='bx bx-envelope'></i></div>
                    <div class="text">
                        <h3>Email</h3>
                        <p>qaysaraqeel71@gmail.com</p>
                    </div>
                </div>
                
            </div>
            <div class="contactForm">
                <form action="index.php" method="POST">
                    <h2>Kotak pesan</h2>

                    <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($userData['id_user']); ?>">

                    <div class="inputfix">
                        <span class="label">Username</span>
                        <span class="value"><?php echo htmlspecialchars($userData['username']); ?></span>
                        <input type="hidden" name="username" id="username" value="<?php echo htmlspecialchars($userData['username']); ?>">
                    </div>
                    <div class="inputfix">
                        <span class="label">Email</span>
                        <span class="value"><?php echo htmlspecialchars($userData['email']); ?></span>
                        <input type="hidden" name="email" id="email" value="<?php echo htmlspecialchars($userData['email']); ?>">
                    </div>
                    <br>
                    <div class="inputBox">
                        <textarea name="pesan" id="pesan" required="required"></textarea>
                        <span>Ketik disini pesanmu...</span>
                    </div>
                    <div class="inputBox">
                        <input type="submit" name="submit" required="required" value="Kirim">
                    </div>

                    <?php
                    if(isset($_POST['submit'])){
                    $id_user = $_POST['id_user'];
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $pesan = $_POST['pesan'];

                    include_once("../koneksi.php");

                    $result = mysqli_query($mysqli,
                    "INSERT INTO kontak(id_user,username, email, pesan) VALUES ('$id_user','$username', '$email', '$pesan')");

                    }
                    ?>


                </form>
            </div>
        </div>
    </section>

    <section class="footer">
        <div class="footer-box">
            <h2>Coffe Shop</h2>
            <p>Surga kopi yang mengundang denganminuman yang nikmat dan suasana yang hangat.</p>
            <div class="social">
                <a href="https://youtube.com/@qaysaraqeel9891?si=3yz20nOEIvtHzt-t"><i class='bx bxl-youtube'></i></a>
                <a href="https://instagram.com/qaysaraqeell?igshid=OGQ5ZDc2ODk2ZA=="><i class='bx bxl-instagram'></i></a>
                <a href="https://x.com/quiseerrr?s=21"><i class='bx bxl-twitter'></i></a>
                <a href="https://www.tiktok.com/@qaysaraqeel?_t=8hbPZy2dlRK&_r=1"><i class='bx bxl-tiktok'></i></a>
            </div>
        </div>
        <div class="footer-box">
        <h3>Dukungan</h3>
            <li><a href="#">Produk</a></li>
            <li><a href="#">Bantuan</a></li>
            <li><a href="#">Pengembalian</a></li>
            <li><a href="#">Syarat</a></li>
            <li><a href="#">Ikuti</a></li>
        </div>
        <div class="footer-box">
            <h3>Panduan</h3>
            <li><a href="#">Fitur</a></li>
            <li><a href="#">Karier</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Ikuti</a></li>
            <li><a href="#">Cabang</a></li>
        </div>
        <div class="footer-box">
            <h3>Perusahaan</h3>
            <li><a href="#">Tentang</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Produk</a></li>
            <li><a href="#">Masuk</a></li>
            <li><a href="#">Afiliasi</a></li>
        </div>
    </section>

    <section class="copyright">
        <p>Copyright © @2023. All Rights Reserved.Design By qaysaraqeel.</p>
    </section>

    <script src="main.js"></script>
</body>
</html>