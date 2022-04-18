<?php

// session, jika sudah login tidak dapat akses halaman ini
session_start();
if(isset($_SESSION['user'])){
    header("Location: status.php");
    exit;
} elseif(isset($_SESSION['admin'])){
    header("Location: Admin_art/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/register.css">

</head>
<body>
    <!-- pilih form login -->
    <div class="container">
        <fieldset>
        <h3 class="logo">CUTTIME </h3>
        <span></span>
        <h4 class="logo">LOGIN</h4>
        <input type="button" class="Back-Login" onclick="location.href='user_login.php'" value="Sebagai User" /><br>
        <input type="button" class="Back-Login" onclick="location.href='Admin_Art/admin_login.php'" value="Sebagai Admin" /><br>
        <input type="button" class="Back-Login" onclick="location.href='index.php'" value="Back To Menu" />
        </fieldset>
    </div>
</body>
</html>