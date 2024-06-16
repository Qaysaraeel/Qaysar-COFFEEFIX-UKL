<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Query untuk mendapatkan detail produk
    $query_produk = "SELECT nama_produk, gambar_produk FROM products WHERE id_produk = ?";
    if ($stmt_produk = $mysqli->prepare($query_produk)) {
        $stmt_produk->bind_param("i", $id_produk);
        $stmt_produk->execute();
        $result_produk = $stmt_produk->get_result();
        if ($data_produk = $result_produk->fetch_assoc()) {
            $nama_produk = $data_produk['nama_produk'];
            $gambar_produk = $data_produk['gambar_produk'];
        } else {
            echo "Error: Produk tidak ditemukan.";
            exit;
        }
        $stmt_produk->close();
    } else {
        echo "Error: " . $mysqli->error;
        exit;
    }

    // Query untuk mendapatkan rating dan detail pengguna yang memberikan rating
    $query = "
        SELECT t.rating, u.username, u.foto_profil
        FROM transaksi t
        JOIN user u ON t.id_user = u.id_user
        WHERE t.id_produk = ? AND t.rating IS NOT NULL
        ORDER BY t.id_transaksi DESC
    ";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $id_produk);
        $stmt->execute();
        $result = $stmt->get_result();

        // Periksa apakah ada hasil dari query
        if ($result->num_rows > 0) {
            // Ambil data rating
            $ratings = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Tidak ada rating
            $ratings = [];
        }

        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }
} else {
    echo "<p>ID produk tidak ditemukan.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rating Produk</title>
    <link rel="stylesheet" href="user/detailproduk.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="icon" type="image/png" href="logotitle.png">
</head>
<body>
    <section class="customers" id="customers">
        <div class="heading">
            <h2>DETAIL RATING <?php echo isset($nama_produk) ? htmlspecialchars($nama_produk) : ''; ?></h2>
        </div>
        <a href="detailproduk.php?id=<?php echo $id_produk; ?>" class="btn">Kembali</a>
        <div class="customers-container">
            <?php if (!empty($ratings)) { ?>
                <?php foreach ($ratings as $rating) { ?>
                    <div class="box">
                        <div class="stars">
                            <?php
                            $full_stars = floor($rating['rating']);
                            $half_star = ceil($rating['rating'] - $full_stars);
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
                        </div>
                        <h2><?php echo htmlspecialchars($rating['username']); ?></h2>
                        <img src="user/img/<?php echo htmlspecialchars($rating['foto_profil']); ?>" width="50" title="<?php echo htmlspecialchars($rating['username']); ?>">
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>Belum ada rating untuk produk ini.</p>
            <?php } ?>
        </div>
        <br><br>
    </section>
    <br><br>

</body>
</html>
