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

// Pastikan koneksi tetap terbuka saat melakukan pengolahan formulir
include '../koneksi.php';

if(isset($_POST['submit'])){
    $rating = $_POST['rating'];
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $foto_profil = $_POST['foto_profil'];
    $pesan = $_POST['pesan'];

    $result = mysqli_query($mysqli,
    "INSERT INTO rating(rating, id_user, username,foto_profil, pesan) VALUES ('$rating', '$id_user', '$username','$foto_profil', '$pesan')");

    if ($result) {
        header("Location: ../user/rating.php");
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tambah Rating</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="styleuptade1.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Berikan Ratingmu</h1><br>
        <form class="form" action="adminratingtambah.php" method="post">

            <label for="rating">Rating (bintang): *1-5</label>
            <select id="rating" name="rating" required>
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
            </select>

            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>">
            <input type="hidden" name="foto_profil" value="<?php echo htmlspecialchars($userData['foto_profil']); ?>">
            <input type="text" name="pesan" placeholder="Pesan penilaian">
            <button class="button" name="submit" type="submit">Kirim</button>
        </form>

        <br><br>
        <a href="../user/index.php"><button class="button" type="submit">Kembali</button></a>
    </div>
</body>
</html>
