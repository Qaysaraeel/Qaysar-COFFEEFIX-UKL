<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login Coffe</title>
    <link rel="icon" type="image/png" href="logotitle.png">
    <link rel="stylesheet" href="style.css">
    <style>
        .btn{
    padding: 10px 168px;
    border-radius: 0.3rem;
    background: var(--main-color);
    color: var(--bg-color);
    font-weight: 500;
    text-decoration:none;

}
.btn:hover{
    background: #8a6f4d;
}
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Log-in</h1><br>
        <form class="form" action="login.php" method="post">
            <input type="text" name="Username" placeholder="Username">
            <input type="password" name="Password" placeholder="Password">
            <a href="login.php?id=<?php echo $data['id_user']; ?>"><button class="button">Login</button></a><br><br>
            <a href="index.php" class="btn">Kembali</a>
        </form>
        <div class="forgot">
            <p>Tidak memiliki akun? <a href="register.php">Register</a></p>
        </div>
    </div>
</body>
</html>