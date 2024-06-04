<?php
include '../koneksi.php';

// Cek apakah ada pencarian
$search_term = '';
if (isset($_POST['search'])) {
    $search_term = $_POST['search'];
}

// Query pencarian produk
$query_search = "
    SELECT p.id_produk, p.nama_produk, p.kategori, p.harga_produk, p.gambar_produk, 
           AVG(t.rating) as avg_rating, COUNT(t.rating) as rating_count, p.deskripsi
    FROM products p
    LEFT JOIN transaksi t ON p.id_produk = t.id_produk
    WHERE p.nama_produk LIKE ?
    GROUP BY p.id_produk, p.nama_produk, p.kategori, p.harga_produk, p.gambar_produk
";

if ($stmt_search = $mysqli->prepare($query_search)) {
    $search_term = '%' . $search_term . '%';
    $stmt_search->bind_param("s", $search_term);
    $stmt_search->execute();
    $search_result = $stmt_search->get_result();
    $search_data = $search_result->fetch_all(MYSQLI_ASSOC);
    $stmt_search->close();
}

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Query untuk mendapatkan detail produk saat ini
    $query_mysql = "
        SELECT p.id_produk, p.nama_produk, p.kategori, p.harga_produk, p.gambar_produk, 
               AVG(t.rating) as avg_rating, COUNT(t.rating) as rating_count, p.deskripsi
        FROM products p
        LEFT JOIN transaksi t ON p.id_produk = t.id_produk
        WHERE p.id_produk = ?
        GROUP BY p.id_produk, p.nama_produk, p.kategori, p.harga_produk, p.gambar_produk
    ";

    if ($stmt = $mysqli->prepare($query_mysql)) {
        $stmt->bind_param("i", $id_produk);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($data = $result->fetch_assoc()) {
            // Query untuk mendapatkan ID produk sebelumnya
            $prev_query = "SELECT id_produk, gambar_produk FROM products WHERE id_produk < ? ORDER BY id_produk DESC LIMIT 1";
            $prev_stmt = $mysqli->prepare($prev_query);
            $prev_stmt->bind_param("i", $id_produk);
            $prev_stmt->execute();
            $prev_result = $prev_stmt->get_result();
            $prev_product = $prev_result->fetch_assoc();
            $prev_id = $prev_product['id_produk'] ?? null;
            $prev_img = $prev_product['gambar_produk'] ?? null;

            // Query untuk mendapatkan ID produk berikutnya
            $next_query = "SELECT id_produk, gambar_produk FROM products WHERE id_produk > ? ORDER BY id_produk ASC LIMIT 1";
            $next_stmt = $mysqli->prepare($next_query);
            $next_stmt->bind_param("i", $id_produk);
            $next_stmt->execute();
            $next_result = $next_stmt->get_result();
            $next_product = $next_result->fetch_assoc();
            $next_id = $next_product['id_produk'] ?? null;
            $next_img = $next_product['gambar_produk'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="detailproduk.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
</head>
<body>

    <section class="produk-detail">
        <div class="produk-container">
            <div class="gambar-produk">
                <img src="../admin/img/<?php echo $data['gambar_produk']; ?>" alt="<?php echo $data['nama_produk']; ?>">
            </div>
            <div class="detail-produk">
                <h1><?php echo htmlspecialchars($data['nama_produk']); ?></h1>
                <p>Kategori: <?php echo htmlspecialchars($data['kategori']); ?></p>
                <h4>Harga: Rp <?php echo number_format($data['harga_produk'], 0, ',', '.'); ?></h4>
                <p><?php echo htmlspecialchars($data['deskripsi']); ?></p><br>
                <?php 
                if (!is_null($data['avg_rating'])) { 
                    $rating = $data['avg_rating'];
                    $rating_count = $data['rating_count'];
                    $full_stars = floor($rating);
                    $half_star = ceil($rating - $full_stars);
                    $empty_stars = 5 - $full_stars - $half_star;
                    echo "<div class='rating'>";
                    for ($i = 0; $i < $full_stars; $i++) {
                        echo "<i class='bx bxs-star'></i>";
                    }
                    if ($half_star) {
                        echo "<i class='bx bxs-star-half'></i>";
                    }
                    for ($i = 0; $i < $empty_stars; $i++) {
                        echo "<i class='bx bx-star'></i>";
                    }
                    echo "<p>(" . number_format($rating, 1) . "/5) dari " . $rating_count . " rating</p>";
                    echo "</div>";
                    
                } else {
                    echo "<p>Belum ada rating</p>";
                }
                ?>
                <div class="navi">
                    <a href="keranjang.php?id=<?php echo $data['id_produk']; ?>" class="btn">Masukan Keranjang</a>
                    <a href="lihatrating.php?id=<?php echo $data['id_produk']; ?>" class="btn">Lihat Rating</a>

                    <a href="produk.php" class="btn">Kembali</a>
                </div>
            </div>
        </div>
        <div class="nav-buttons">
            <?php if ($prev_id) { ?>
                <div class="nav-img">
                    <a href="detailproduk.php?id=<?php echo $prev_id; ?>"><img src="../admin/img/<?php echo $prev_img; ?>" alt="Produk Sebelumnya"></a>
                </div>
            <?php } ?>
            <?php if ($next_id) { ?>
                <div class="nav-img">
                    <a href="detailproduk.php?id=<?php echo $next_id; ?>"><img src="../admin/img/<?php echo $next_img; ?>" alt="Produk Berikutnya"></a>
                </div>
            <?php } ?>
        </div>
    </section>
    <br><br>
</body>
</html>
<?php
        } else {
            echo "<p>Produk tidak ditemukan.</p>";
        }
        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }
} else {
    echo "<p>ID produk tidak ditemukan.</p>";
}
?>
