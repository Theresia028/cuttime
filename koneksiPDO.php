<!-- koneksi ke db -->
<?php 
$host       = "localhost";
$user       = "root";
$password_user   = "";
$database   = "socmed";
$koneksi    = new PDO("mysql:host=$host;dbname=$database", $user, $password_user);



?>