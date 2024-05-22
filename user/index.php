<?php
session_start(); // Mulai sesi

// Periksa apakah pengguna sudah login, jika tidak, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../koneksi.php';

// Ambil informasi login pengguna dari sesi atau cookie
$username = $_SESSION['username'];

// Query untuk mengambil data pengguna berdasarkan username
$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($mysqli, $query);

// Periksa apakah query berhasil dieksekusi
if (!$result) {
    die("Query Error: " . mysqli_error($mysqli));
}

// Ambil data pengguna dari hasil query
$userData = mysqli_fetch_assoc($result);

// Tutup koneksi database
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <header>
        <a href="#" class="logo">
            <img src="img/logo.png" alt="">
        </a>
        <i class='bx bx-menu' id="menu-icon"></i>
        <ul class="navbar">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#products">Products</a></li>
            <li><a href="#customers">Customers</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="header-icon">
            <a href="belimenu.php"><i class='bx bx-cart-alt'></i></a>
            <a href="#"><i class='bx bx-search' id="search-icon"></i></a>
        </div>
        <div class="search-box">
            <input type="search" name="" id="" placeholder="Search Here...">
        </div>
        <ul class="navbar">
            <li><a href="profil.php">profil</a></li>
            <li><a href="../index.php">Log out</a></li>
        </ul>
    </header>

    <section class="home" id="home">
        <div class="home-text">
            <h1>Start your day <br> with coffee</h1>
            <p>Kickstart your mornings with a cup of coffee. Experience the rich aroma and unmatched flavor as you embark on your day with our carefully selected brews. Whether you prefer a bold espresso or a smooth latte, our collection offers something for every coffee lover. Start your day right with the perfect cup of coffee from our menu.</p>
            <a href="#products" class="btn">Shop Now</a>
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
            <h2>Our History</h2>
            <p>Platform Coffee Shop started as a school project where founders crafted a digital platform mimicking the coffee shop ambiance. Through an interactive website, they showcased their web skills, while offering coffee aficionados a space to explore blends, brewing methods, and connect with others. Platform Coffee Shop merges tech with coffee culture, providing a distinctive online hub for education and enjoyment.</p>
            <a href="#" class="btn">Learn More</a>
        </div>
    </section>

    <section class="products" id="products">
    <div class="heading">
        <h2>Our popular products</h2>
    </div>
    <div class="products-container">
        <?php
        include '../koneksi.php';
        $query_mysql = mysqli_query($mysqli, "SELECT * FROM products") or die(mysqli_error($mysqli));
        $nomor = 1;
        while($data = mysqli_fetch_array($query_mysql)) { 
        ?>
        <div class="box">
            <img src="../admin/img/<?php echo $data["gambar_produk"]; ?>" width="200" title="<?php echo $data['gambar_produk']; ?>">
            <h3><?php echo $data['nama_produk']; ?></h3>
            <div class="content">
                <span>Rp: <?php echo $data['harga_produk']; ?></span>
                <a href="belimenu.php?id=<?php echo $data['id_produk']; ?>">Add to Cart</a>
            </div>
        </div>
        <?php } ?>
    </div>
    </section>

    <section class="customers" id="customers">
    <div class="heading">
        <h2>Our Customer's Ratings</h2>
    </div>
    <div class="customers-container">
        <?php
        include '../koneksi.php';
        $query_mysql = mysqli_query($mysqli, "SELECT * FROM rating") or die(mysqli_error($mysqli));
        while($data = mysqli_fetch_array($query_mysql)) { 
        ?>
        <div class="box">
            <div class="stars">
                <?php
                // Menghitung jumlah bintang yang ditampilkan
                $rating = $data['rating'];
                $full_stars = floor($rating); // Bintang penuh
                $half_star = ceil($rating - $full_stars); // Setengah bintang
                $empty_stars = 5 - $full_stars - $half_star; // Bintang kosong
                // Menampilkan bintang penuh
                for ($i = 0; $i < $full_stars; $i++) {
                    echo "<i class='bx bxs-star'></i>";
                }
                // Menampilkan setengah bintang jika ada
                if ($half_star) {
                    echo "<i class='bx bxs-star-half'></i>";
                }
                // Menampilkan bintang kosong
                for ($i = 0; $i < $empty_stars; $i++) {
                    echo "<i class='bx bx-star'></i>";
                }
                ?>
            </div>
            <p><?php echo $data['pesan']; ?></p>
            <h2><?php echo $data['username']; ?></h2>
            <!-- Mungkin kamu ingin menambahkan foto profil pengguna di sini -->
        </div>
        <?php } ?>
    </div>
    <br>
    <a href="../admin/adminratingtambah.php" class="btn">Berikan Ratingmu!</a>
    </section>




    <section class="customers" id="customers">
        <div class="heading">
            <h2>Our Costumer's</h2>
        </div>
        <div class="customers-container">
            <div class="box">
                <div class="stars">
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star-half' ></i>
                </div>
                <p>Their coffee is fresh and diverse, the atmosphere is cozy, and the service is friendly.</p>
                <h2>Abigail Caroline</h2>
                <img src="img/oke1.jpg" alt="">
            </div>
            <div class="box">
                <div class="stars">
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star' ></i>
                </div>
                <p>Fantastic coffee spot! Cozy vibe, friendly staff, and delicious coffee. Will be back soon!</p>
                <h2>Aaron Bromosov</h2>
                <img src="img/oke2.jpg" alt="">
            </div>
            <div class="box">
                <div class="stars">
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star' ></i>
                    <i class='bx bxs-star-half' ></i>
                </div>
                <p>Great coffee shop! Cozy atmosphere, friendly staff, amazing coffee. Will be back!</p>
                <h2>Chan Dwyne</h2>
                <img src="img/oke3.jpg" alt="">
            </div>
        </div>
        <br>
        <a href="../admin/adminratingtambah.php" class="btn">Berikan Ratingmu!</a>
    </section>

    <section class="contact" id="contact">
        <div class="content">
            <h2>Contact Us</h2>
            <p>Reach out with any questions, suggestions, or collaboration inquiries. We're dedicated to serving you. Fill out the contact form or get in touch directly using the contact information on this page. We look forward to hearing from you!</p>
        </div>
        <div class="container">
            <div class="contactInfo">
                <div class="box">
                    <div class="icon"><i class='bx bxs-map'></i></div>
                    <div class="text">
                        <h3>Address</h3>
                        <p>Perum Sunvillage Damarsi<br>Sidoarjo, Jawa Timur, <br>61252</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class='bx bxs-phone'></i></div>
                    <div class="text">
                        <h3>Phone</h3>
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
                    <h2>Send Massage</h2>
                    <div class="inputBox">
                        <input type="text" name="username" id="username" required="required">
                        <span>Username</span>
                    </div>
                    <div class="inputBox">
                        <input type="text" name="email" id="email" required="required">
                        <span>Email</span>
                    </div>
                    <div class="inputBox">
                        <textarea name="pesan" id="pesan" required="required"></textarea>
                        <span>Type Your Massage....</span>
                    </div>
                    <div class="inputBox">
                        <input type="submit" name="submit" required="required" value="Send">
                    </div>

                    <?php
                    if(isset($_POST['submit'])){
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $pesan = $_POST['pesan'];

                    include_once("../koneksi.php");

                    $result = mysqli_query($mysqli,
                    "INSERT INTO kontak(username, email, pesan) VALUES ('$username', '$email', '$pesan')");

                    }
                    ?>


                </form>
            </div>
        </div>
    </section>

    <section class="footer">
        <div class="footer-box">
            <h2>Coffe Shop</h2>
            <p>An inviting coffee haven with <br> delightful brews and warm ambiance.</p>
            <div class="social">
                <a href="https://youtube.com/@qaysaraqeel9891?si=3yz20nOEIvtHzt-t"><i class='bx bxl-youtube'></i></a>
                <a href="https://instagram.com/qaysaraqeell?igshid=OGQ5ZDc2ODk2ZA=="><i class='bx bxl-instagram'></i></a>
                <a href="https://x.com/quiseerrr?s=21"><i class='bx bxl-twitter'></i></a>
                <a href="https://www.tiktok.com/@qaysaraqeel?_t=8hbPZy2dlRK&_r=1"><i class='bx bxl-tiktok'></i></a>
            </div>
        </div>
        <div class="footer-box">
            <h3>Support</h3>
            <li><a href="#">Product</a></li>
            <li><a href="#">Help & Support</a></li>
            <li><a href="#">Return Policy</a></li>
            <li><a href="#">Terms Of use</a></li>
            <li><a href="#">Follow us</a></li>
        </div>
        <div class="footer-box">
            <h3>Guides</h3>
            <li><a href="#">Featurs</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Blog Post</a></li>
            <li><a href="#">Follow us</a></li>
            <li><a href="#">Our Branches</a></li>
        </div>
        <div class="footer-box">
            <h3>Company</h3>
            <li><a href="#">About</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Product</a></li>
            <li><a href="#">Login</a></li>
            <li><a href="#">Affiliate</a></li>
        </div>
    </section>

    <section class="copyright">
        <p>Copyright © @2023. All Rights Reserved.Design By qaysaraqeel.</p>
    </section>







    <script src="main.js"></script>
</body>
</html>