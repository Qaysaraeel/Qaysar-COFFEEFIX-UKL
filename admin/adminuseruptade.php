<?php
include '../koneksi.php';

if(isset($_POST['update'])) {
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $newImageName = '';

    // Handle file upload
    if ($_FILES['foto_profil']['error'] === 0) {
        $fileName = $_FILES['foto_profil']['name'];
        $fileSize = $_FILES['foto_profil']['size'];
        $tmpName = $_FILES['foto_profil']['tmp_name'];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "Invalid image extension.";
            exit();
        } else if ($fileSize > 1000000) {
            echo "Image size is too large.";
            exit();
        } else {
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;
            move_uploaded_file($tmpName, '../user/img/' . $newImageName);
        }
    }

    // Update data in the database
    if ($newImageName) {
        $query = "UPDATE user SET username='$username', password='$password', email='$email', foto_profil='$newImageName' WHERE id_user=$id_user";
    } else {
        $query = "UPDATE user SET username='$username', password='$password', email='$email' WHERE id_user=$id_user";
    }
    $result = mysqli_query($mysqli, $query);

    if($result) {
        echo "Data berhasil diperbarui.";
        header("Location: adminuser.php"); // Redirect kembali ke halaman data user
        exit();
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($mysqli);
    }
}

// Mendapatkan data user yang akan diupdate
if(isset($_GET['id'])) {
    $id_user = $_GET['id'];
    $query = "SELECT * FROM user WHERE id_user=$id_user";
    $result = mysqli_query($mysqli, $query);
    $data = mysqli_fetch_assoc($result);
} else {
    echo "ID user tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="styleuptade.css">
</head>
<body>
<div class="container">
    <header>
        <h1 class="title">Update User</h1>
    </header>
    <section class="form">
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id_user" value="<?php echo $data['id_user']; ?>">

            <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $data['username']; ?>"><br>

            <input type="password" id="password" name="password" placeholder="Password" value="<?php echo $data['password']; ?>"><br>

            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $data['email']; ?>"><br><br>

            <label for="foto_profil">Profile Picture:</label>
            <input type="file" id="foto_profil" name="foto_profil" accept="image/*"><br><br>

            <input type="submit" name="update" value="Update" class="button">
        </form>
    </section>
</div>
</body>
</html>
