<?php
session_start();
include 'koneksi.php';

$username = $_POST['Username'];
$password = $_POST['Password'];

$login = mysqli_query($mysqli, "SELECT * FROM user WHERE username='$username' AND password='$password'");

if ($login) {
    $cek = mysqli_num_rows($login);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($login);

        if ($data['level'] == "admin") {
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "admin";
            header("Location: admin/adminuser.php");
        } else if ($data['level'] == "user") {
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "user";
            header("Location: user/index.php");
        } else if ($data['level'] == "barista") { // Add this condition for barista level
            $_SESSION['username'] = $username;
            $_SESSION['level'] = "barista";
            header("Location: barista/index.php"); // Update the redirection path for barista
        } else {
            header("Location: loginnya.php?pesan=gagal");
        }
    } else {
        header("Location: loginnya.php?pesan=gagal");
    }
} else {
    echo "Error: " . mysqli_error($mysqli);
}
?>
