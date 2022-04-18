<?php
include "koneksiPDO.php";
session_start();
if(!isset($_SESSION['user'])){
    header("Location: user_login.php");
    exit;
}
// validasi gambar untuk post
$errgambar="";
if(isset($_POST["submit"])){
	$namaFile = $_FILES["gambar"]["name"];
	$ukuranFile = $_FILES["gambar"]["size"];
	$error = $_FILES["gambar"]["error"];
	$tempname = $_FILES["gambar"]["tmp_name"];

	if($error === 4){
	   $errgambar = "Pilih file";
	} else {

		$extvalid = ["jpg","jpeg","png"];
		$extgambar = explode('.', $namaFile);
		$extgambar = strtolower(end($extgambar));
		if( !in_array($extgambar, $extvalid)){
		    $errgambar = "File bukan gambar";
		} else {
		    move_uploaded_file($tempname, "upload/". $namaFile);
		    $query = $koneksi->prepare("INSERT INTO photos (id_user, nama_photos, keterangan) VALUES (:id_user, :nama_photos, :keterangan)");
	    	$query->bindValue(":id_user", $_SESSION["id_user"]);
	    	$query->bindValue(":nama_photos", $namaFile);
	    	$query->bindValue(":keterangan", $_POST["keterangan"]);
	    	$query-> execute();
			// pemberitahuan jika sukses
			echo "<script>alert('posting sukses !!');";
			echo "document.location.href = 'status.php';";
			echo "</script>";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Tambah Postingan</title>
	<link rel="stylesheet" type="text/css" href="./css/post.css">
	<link rel="stylesheet" href="css/header.css">
</head>
<body>
    <!-- header -->
	<?php
		include('header.inc');
	?>
    <!-- buat postingan -->
	<h1>CUTTIME</h1>



	<fieldset>
		<legend>Create Post</legend>
		<form action="post.php?id_user=5" method="post" enctype="multipart/form-data">
		<div>
			<textarea name="keterangan"></textarea>
		</div>
		<div>
			<input class="btn-file"  name="gambar" type="file" id="file" accept="image/*"/>
		</div>
		<div>
			<input class="btn-submit-reset" type="reset" name="reset" value="Cancel"/>
			<input class="btn-submit-reset" type="submit" name="submit" value="Post"/>
		</div>
		</form>
	</fieldset>
</body>
</html>