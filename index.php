<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login Coffe</title>
    <link rel="icon" type="image/png" href="logotitle.png">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container">
        <h1 class="title">Log-in</h1><br>
        <form class="form" action="login.php" method="post">
            <input type="text" name="Username" placeholder="Username">
            <input type="password" name="Password" placeholder="Password">
            <a href="login.php?id=<?php echo $data['id_user']; ?>"><button class="button">Login</button></a>
        </form>
        <div class="forgot">
            <a href="register.php">Register</a> <a href="#">Forgot Password</a>
        </div>
    </div>
</body>
</html>