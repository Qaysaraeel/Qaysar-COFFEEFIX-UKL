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
    <title>Informasi Pengguna</title>
    <link rel="stylesheet" href="styleprofil.css">
</head>
<body>
    <div class="container">
        <section class="user-info">
            <h2>Informasi Pengguna</h2>
            <div class="user-details">
                <p><strong>Username:</strong> <?php echo $userData['username']; ?></p>
                <p><strong>Email:</strong> <?php echo $userData['email']; ?></p>
                <img src="../user/img/<?php echo $userData['foto_profil']; ?>" title="<?php echo $userData['username']; ?>">
            </div><br><br>
            <a href="index.php" class="btn">Kembali ke Halaman utama</a>
        </section>
    </div>
</body>
</html>
