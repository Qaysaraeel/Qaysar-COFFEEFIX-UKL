<?php

include '../koneksi.php';

if(isset($_GET['id'])) {
    $id_pesan = $_GET['id'];

    if(isset($_POST['submit'])) {

        $username = $_POST['username'];
        $email = $_POST['email'];
        $pesan = $_POST['pesan'];

        $query = "UPDATE kontak SET username='$username', email='$email', pesan='$pesan' WHERE id_pesan='$id_pesan'";
        $result = mysqli_query($mysqli, $query);

        if($result) {
            header("Location: adminmassage.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($mysqli);
        }
    }

    $query = "SELECT * FROM kontak WHERE id_pesan='$id_pesan'";
    $result = mysqli_query($mysqli, $query);
    $data = mysqli_fetch_assoc($result);
} else {
    header("Location: adminmassage.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Massage</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="styleuptade.css">
</head>
<body>
    <div class="container">
        <header>
            <h1 class="title">Update Massage</h1>
        </header>
        <section class="form">
        <form method="POST" action="">

            <input type="text" id="username" name="username" value="<?php echo $data['username']; ?>"><br>
           
            <input type="text" id="email" name="email" value="<?php echo $data['email']; ?>"><br>
         
            <input type="text" id="pesan" name="pesan" value="<?php echo $data['pesan']; ?>"><br><br>
            <input type="submit" name="submit" value="Update" class="button">
        </form>
        </section>
    </div>

    <script src="main.js"></script>
</body>
</html>
