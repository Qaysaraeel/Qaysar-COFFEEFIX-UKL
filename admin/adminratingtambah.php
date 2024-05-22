<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tambah Rating</title>
    <link rel="icon" type="image/png" href="logotitle.png">
    <link rel="stylesheet" href="styleuptade.css">
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

            <input type="text" name="username" placeholder="Username">
            <input type="text" name="pesan" placeholder="Pesan penilaian">
            <button class="button" name="sumbit" type="submit">Kirim</button>
            <?php
            if(isset($_POST['sumbit'])){
                $rating= $_POST['rating'];
                $username= $_POST['username'];
                $pesan= $_POST['pesan'];

                include_once("../koneksi.php");

                $result = mysqli_query($mysqli,
                "INSERT INTO rating(rating,username,pesan) VALUES ('$rating','$username','$pesan')");

                header("location:../user/index.php");
            }
            ?>
        </form>
    </div>
</body>
</html>
