<?php
include '../koneksi.php';

if(isset($_POST['update'])) {
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $level = $_POST['level']; // Tambahkan level jika perlu diubah

    // Lakukan proses update data di database
    $query = "UPDATE user SET username='$username', password='$password', email='$email', level='$level' WHERE id_user=$id_user";
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
    <link rel="stylesheet" href="styleuptade1.css">
</head>
<body>
<div class="container">
        <header>
            <h1 class="title">Update User</h1>
        </header>
        <section class="form">
        <form method="POST" action="">
        <input type="hidden" name="id_user" value="<?php echo $data['id_user']; ?>">

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?php echo $data['username']; ?>"><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" value="<?php echo $data['password']; ?>"><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $data['email']; ?>"><br>

        <!-- Tambahkan input untuk mengubah level -->
        <label for="level">Level:</label><br>
        <select id="level" name="level">
            <option value="user" <?php if($data['level'] == 'user') echo 'selected'; ?>>User</option>
            <option value="admin" <?php if($data['level'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="barista" <?php if($data['level'] == 'barista') echo 'selected'; ?>>Barista</option>
            <!-- Tambahkan opsi sesuai dengan kebutuhan -->
        </select><br><br>

        <input type="submit" name="update" value="Update" class="button">
    </form>
        </section>
    </div>
    
</body>
</html>
