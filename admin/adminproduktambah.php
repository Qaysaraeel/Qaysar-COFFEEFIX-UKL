<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="styleuptade1.css">
    <style>
        .btn{
        padding: 10px 168px;
        border-radius: 0.3rem;
        background: var(--main-color);
        color: var(--bg-color);
        font-weight: 500;
        text-decoration: none;
        }
        .btn:hover{
        background: #8a6f4d;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1 class="title">Tambah Produk</h1>
        </header>
        <section class="form">
            <form action="adminproduktambah.php" method="POST" enctype="multipart/form-data">
                <input type="text" id="nama_produk" name="nama_produk" placeholder="Nama produk" required><br>

                <label for="kategori">Kategori:</label>
                <select name="kategori" id="kategori" required>
                    <option value="coffee">coffee</option>
                    <option value="makanan">makanan</option>
                    <option value="non-coffee">non-coffee</option>
                </select><br>

                <input type="text" id="harga_produk" name="harga_produk" placeholder="Harga produk" required><br>
                <input type="file" id="gambar_produk" name="gambar_produk" accept=".jpg, .jpeg, .png" required><br><br>
                <textarea name="deskripsi" id="" placeholder=" Deskripsi produk"></textarea><br><br>
                <input type="submit" name="submit" class="button" value="Tambah Produk"><br><br>
                <a href="adminproduk.php" class="btn">kembali</a>
            </form>

            <?php
            if (isset($_POST['submit'])) {
                $nama_produk = $_POST['nama_produk'];
                $kategori = $_POST['kategori'];
                $harga_produk = $_POST['harga_produk'];
                $deskripsi = $_POST['deskripsi'];

                // Handle file upload
                if ($_FILES["gambar_produk"]["error"] == 4) {
                    echo "<script>alert('Image Does Not Exist');</script>";
                } else {
                    $fileName = $_FILES["gambar_produk"]["name"];
                    $fileSize = $_FILES["gambar_produk"]["size"];
                    $tmpName = $_FILES["gambar_produk"]["tmp_name"];

                    $validImageExtension = ['jpg', 'jpeg', 'png'];
                    $imageExtension = explode('.', $fileName);
                    $imageExtension = strtolower(end($imageExtension));
                    
                    if (!in_array($imageExtension, $validImageExtension)) {
                        echo "<script>alert('Invalid Image Extension');</script>";
                    } else if ($fileSize > 1000000) {
                        echo "<script>alert('Image Size Is Too Large');</script>";
                    } else {
                        $newImageName = uniqid();
                        $newImageName .= '.' . $imageExtension;

                        move_uploaded_file($tmpName, 'img/' . $newImageName);

                        include_once("../koneksi.php");

                        $result = mysqli_query($mysqli, 
                        "INSERT INTO products (nama_produk, kategori, harga_produk, deskripsi, gambar_produk) VALUES ('$nama_produk', '$kategori', '$harga_produk','$deskripsi', '$newImageName')");

                        if ($result) {
                            echo "<script>
                                alert('Successfully Added');
                                document.location.href = 'adminproduk.php';
                            </script>";
                        } else {
                            echo "Error: " . $mysqli->error;
                        }
                    }
                }
            }
            ?>
        </section>
    </div>
</body>
</html>
