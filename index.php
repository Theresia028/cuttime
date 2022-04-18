<?php
session_start();
if(isset($_SESSION['user'])){
    header("Location: status.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUTTIME</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <section>
        <!--navigation------------------------->
        <nav>
        <!--logo-->
        <a href="index.php" class="logo">CUTTIME</a>
        <!--menu-->
        <ul>
        <li><a href="pilih_login.php">Login</a></li>
        <li><a href="pilih_register.php">Daftar</a></li>
        </ul>
        <!--bars--------------->
        <div class="toggle"></div>
        
        </nav>
      </section>
      <!-- Content -->
      <div class="text-container">
        <p>Welcome To</p>
        <p>CUTTIME</p>
        <p>Curahkan Isi Hatimu Disini</p>
    </div>
    <div class="about-container">
        <!--img-->
            <img class="gambar" src="profil/art.png"/>
        <!--about-me-text-->
            <div class="about-text">
            <p>About ACUTTIME</p>
            <p>CUTTIME dalah website yang digunakan untuk melakukan postingan isi curhatan hati</p>
            </div>
        </div>
      
    
</body>
</html>