<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

include("../koneksiPDO.php");

$statement = $koneksi->prepare("DELETE FROM photos WHERE id_photos=:id_photos");
$statement->bindValue(":id_photos",$_GET["id_photo"]);
$statement->execute();

echo "<script>alert('Data berhasil dihapus !!');";
echo "document.location.href = 'photos.php';";
echo "</script>";