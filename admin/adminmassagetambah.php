<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee</title>
    <link rel="stylesheet" href="../user/style.css">
    <link rel="icon" type="image/png" href="../logotitle.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <section class="contact" id="contact">
        <div class="content">
            <h2>Contact Us</h2>
            <p>Reach out with any questions, suggestions, or collaboration inquiries. We're dedicated to serving you. Fill out the contact form or get in touch directly using the contact information on this page. We look forward to hearing from you!</p>
        </div>
        <div class="container">
            <div class="contactInfo">
                <div class="box">
                    <div class="icon"><i class='bx bxs-map'></i></div>
                    <div class="text">
                        <h3>Address</h3>
                        <p>Perum Sunvillage Damarsi<br>Sidoarjo, Jawa Timur, <br>61252</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class='bx bxs-phone'></i></div>
                    <div class="text">
                        <h3>Phone</h3>
                        <p>0881-0366-47856</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class='bx bx-envelope'></i></div>
                    <div class="text">
                        <h3>Email</h3>
                        <p>qaysaraqeel71@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="contactForm">
                <form action="index.php" method="POST">
                    <h2>Send Massage</h2>
                    <div class="inputBox">
                        <input type="text" name="username" id="username" required="required">
                        <span>Username</span>
                    </div>
                    <div class="inputBox">
                        <input type="text" name="email" id="email" required="required">
                        <span>Email</span>
                    </div>
                    <div class="inputBox">
                        <textarea name="pesan" id="pesan" required="required"></textarea>
                        <span>Type Your Massage....</span>
                    </div>
                    <div class="inputBox">
                        <input type="submit" name="submit" required="required" value="Send">
                    </div>

                    <?php
                    if(isset($_POST['submit'])){
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $pesan = $_POST['pesan'];

                    include_once("../koneksi.php");

                    $result = mysqli_query($mysqli,
                    "INSERT INTO kontak(username, email, pesan) VALUES ('$username', '$email', '$pesan')");

                    }
                    ?>


                </form>
            </div>
        </div>
    </section>
    <script src="main.js"></script>
</body>
</html>