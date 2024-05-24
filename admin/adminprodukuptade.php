<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    if (isset($_POST['submit'])) {
        $nama_produk = $_POST['nama_produk'];
        $kategori = $_POST['kategori'];
        $harga_produk = $_POST['harga_produk'];

        // Handle file upload
        $gambar_produk = $_POST['gambar_produk_existing'];
        if ($_FILES["gambar_produk"]["error"] == 4) {
            // No new image uploaded, use existing image
            $newImageName = $gambar_produk;
        } else {
            $fileName = $_FILES["gambar_produk"]["name"];
            $fileSize = $_FILES["gambar_produk"]["size"];
            $tmpName = $_FILES["gambar_produk"]["tmp_name"];

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));
            if (!in_array($imageExtension, $validImageExtension)) {
                echo "<script> alert('Invalid Image Extension'); </script>";
            } else if ($fileSize > 1000000) {
                echo "<script> alert('Image Size Is Too Large'); </script>";
            } else {
                $newImageName = uniqid();
                $newImageName .= '.' . $imageExtension;

                move_uploaded_file($tmpName, 'img/' . $newImageName);
            }
        }

        $query = "UPDATE products SET nama_produk='$nama_produk',kategori='$kategori', harga_produk='$harga_produk', gambar_produk='$newImageName' WHERE id_produk='$id_produk'";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            header("Location: adminproduk.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($mysqli);
        }
    }

    $query = "SELECT * FROM products WHERE id_produk='$id_produk'";
    $result = mysqli_query($mysqli, $query);
    $data = mysqli_fetch_assoc($result);
} else {
    header("Location: adminproduk.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Produk</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="styleuptade.css">
</head>
<body>
    <div class="container">
        <header>
            <h1 class="title">Update Produk</h1>
        </header>
        <section class="form">
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="text" id="nama_produk" name="nama_produk" value="<?php echo $data['nama_produk']; ?>" required><br>

                <label for="">Kategory:</label>
                <select name="kategori" id="">
                    <option value="coffee">coffee</option>
                    <option value="makanan">makanan</option>
                </select> <br>

                <input type="text" id="harga_produk" name="harga_produk" value="<?php echo $data['harga_produk']; ?>" required><br>
                <input type="file" id="gambar_produk" name="gambar_produk" accept=".jpg, .jpeg, .png"><br>
                <input type="hidden" name="gambar_produk_existing" value="<?php echo $data['gambar_produk']; ?>"><br>
                <input type="submit" name="submit" value="Update" class="button">
            </form>
        </section>
    </div>

    <script src="main.js"></script>
</body>
</html>
