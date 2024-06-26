<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Operational Coffee</title>
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="styleuptade.css">
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
        <h1 class="title">Register Operationals</h1><br>
        <form class="form" action="registeradmin.php" method="post" enctype="multipart/form-data">
            <input type="email" name="email" placeholder="Email" required> 
            <input type="text" name="username" placeholder="Username" required>
            <label for="kategori">level:</label>
                <select name="level" id="level" required>
                    <option value="admin">admin</option>
                    <option value="barista">barista</option>
                </select><br><br>
            <label for="foto_profil">Profile Picture:</label>
            <input type="file" id="foto_profil" name="foto_profil" accept="image/*" required>
            <br>
            <input type="password" name="password" placeholder="Password" required>
            <button class="button" name="submit" type="submit">Register</button><br><br>
            <a href="adminuser.php" class="btn">kembali</a>
            
            <?php
            if(isset($_POST['submit'])){
                $email= $_POST['email'];
                $username= $_POST['username'];
                $password= $_POST['password'];
                $level= $_POST['level'];

                // Handle file upload
                if ($_FILES["foto_profil"]["error"] == 4) {
                    echo "<script> alert('Image Does Not Exist'); </script>";
                } else {
                    $fileName = $_FILES["foto_profil"]["name"];
                    $fileSize = $_FILES["foto_profil"]["size"];
                    $tmpName = $_FILES["foto_profil"]["tmp_name"];

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

                        move_uploaded_file($tmpName, '../user/img/' . $newImageName);

                        include_once("../koneksi.php");

                        $result = mysqli_query($mysqli, 
                        "INSERT INTO user (email, username, password, foto_profil, level) VALUES ('$email', '$username', '$password', '$newImageName', '$level')");

                        if ($result) {
                            echo "<script>
                                alert('Successfully Added');
                                document.location.href = '../loginnya.php';
                            </script>";
                        } else {
                            echo "Error: " . mysqli_error($mysqli);
                        }
                    }
                }
            }
            ?>
        </form>
    </div>
</body>
</html>
