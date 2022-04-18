<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("Location: index.php");
		exit;
	}

	// validasi
	$errnama = $errphone = $errtgl = $erralamat = $errgambar = "";
	$valnama = $errphone = $valtgl = $valalamat = "";
	include "koneksiPDO.php";
	if (isset($_POST["submit"])){
		$valid=0;
		if ($_POST["Name"] == ""){
	        $errnama = "nama harus diisi";
	        $valnama = "";
	    } elseif (!preg_match('/^[a-zA-Z ]*$/', $_POST["Name"])){
	        $errnama = "nama hanya boleh huruf dan spasi";
	        $valnama = "";
	    } elseif (strlen($_POST["Name"]) < 3 || strlen($_POST["Name"]) > 50){
	        $errnama = "Nama minimal 3 karakter dan maksimal 50 karakter";
	        $valnama = "";
	    } else {
	        $valid++;
	        $errnama = "";
	        $valnama = $_POST["Name"];
	    }

	    if($_POST["PhoneNumber"] == ""){
	        $errphone = "No telpon harus diisi";
	        $valphone = "";
	    } elseif (!preg_match( "/^[0-9]*$/", $_POST["PhoneNumber"])){
	        $errphone = "No telpon harus berupa angka";
	        $valphone = "";
	    } elseif (strlen($_POST["PhoneNumber"]) < 8 || strlen($_POST["PhoneNumber"]) > 13){
	        $errphone = "No telpon minimal 8 angka dan maksimal 13 angka";
	        $valphone = "";
	    } else {
	        $valid++;
	        $errphone = "";
	        $valphone = $_POST["PhoneNumber"];
	    }

	    if ($_POST["tgllahir"] == ""){
        	$errtgl = "tanggal lahir harus diisi";
        } else {
            $errtgl = "";
            $valid++;
    
        }


	    if ($_POST["alamat"] == ""){
        	$erralamat = "alamat harus diisi";
        	$valalamat = "";
        } else {
            $erralamat = "";    
            $valalamat = $_POST["alamat"];
            $valid++;

        }

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
		    	$errname = "File bukan gambar";
		    } else {
		    	move_uploaded_file($tempname, "profil/". $namaFile);
		    	$valid++;
		    }
	    }

	    if($valid == 5){
	    	$query = $koneksi->prepare("UPDATE user SET nama = :nama, no_hp = :phonenumber, tgl_lahir = :tgllahir, alamat = :alamat, photos = :photo WHERE id_user = :id_user");
	    	$query->bindValue(":nama", $_POST["Name"]);
	    	$query->bindValue(":phonenumber", $_POST["PhoneNumber"]);
	    	$query->bindValue(":tgllahir", $_POST["tgllahir"]);
	    	$query->bindValue(":alamat", $_POST["alamat"]);
	    	$query->bindValue(":photo", $namaFile);
	    	$query->bindValue(":id_user", $_SESSION["id_user"]);
	    	$query->execute();

			// berhasil
			echo "<script>alert('Berhasil !!');";
            echo "document.location.href = 'profile.php';";
            echo "</script>";
	    }

	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Edit Profile</title>
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" href="css/header.css">
</head>
<body>
    <!-- header -->
    <?php
		include('header.inc');
	?>
    <!-- Edit profile -->
	<div>
		<h1> CUTTIME </h1>
    </div>
    <div align="center">
		<fieldset class="box">
			<h3 for="file">Edit Profil</h3>
			<!-- form edit profile -->
			<form action="menu.php" method="post" enctype="multipart/form-data">
				<!-- ambil data dari user saat ini untuk ditampilkan sebagai value dari input -->
				<?php
				include('koneksiPDO.php');			
				$statement = $koneksi->prepare("SELECT * FROM user where (id_user = :id_user)");
				$statement->bindValue(':id_user', $_SESSION['id_user']);
				$statement->execute();
				$isi = $statement->fetch(PDO::FETCH_ASSOC);
				
				?>
				<?php echo '<img src="profil/'. $isi['photos'] .'" alt="photo">'; ?> 
				<br>
				<?php echo $errgambar ?>
				<input class="btn-file" type="file" name="gambar" id="file" accept="image/*"/>
				<br><?php echo $errnama ?>
				<input type="text" name="Name" placeholder="Name" value="<?php if(isset($isi['nama'])) echo htmlspecialchars($isi['nama'])?>" />
				<?php echo $errphone ?>
				<input type="text" name="PhoneNumber" placeholder="Phone Number" value="<?php if(isset($isi['no_hp'])) echo htmlspecialchars($isi['no_hp'])?>" />
				<?php echo $errtgl ?>
				<input type="date" name="tgllahir" placeholder="Tanggal Tahir" value="<?php if(isset($isi['tgl_lahir'])) echo htmlspecialchars($isi['tgl_lahir'])?>" />
				<br>
				<br>
				<?php echo $erralamat ?>
				<input type="text" name="alamat" placeholder="Alamat" value="<?php if(isset($isi['alamat'])) echo htmlspecialchars($isi['alamat'])?>" />
				<br>
				<input class="btn-submit-reset" type="reset" name="reset" value="Reset"/>
				<input class="btn-submit-reset" type="submit" name="submit" value="Submit"/>
		    </form>
		</fieldset>
	</div>
</body>
</html>