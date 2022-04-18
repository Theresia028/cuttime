<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: user_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<link rel="stylesheet" type="text/css" href="css/profileStatus.css">
	<meta charset="utf-8">
	<title>Profile</title>
	<link rel="stylesheet" href="css/header.css">
</head>
<body >
    <!-- header -->
	<?php
		include('header.inc');
	?>
    <!-- profile -->
	<div align="center" class="container">
		<fieldset>
			<div align="center" class="contain">
				<!-- menampilkan data profil user -->
				<?php
			   		include('koneksiPDO.php');	
					$statement = $koneksi->prepare("SELECT photos, nama, alamat, no_hp FROM user WHERE(id_user = :id_user)");
					$statement->bindValue('id_user', $_SESSION['id_user']);
					$statement->execute();
					// ambil data
					foreach ($statement as $row){ 
						$photos=$row['photos'];
						$nama=$row['nama'];
						$alamat=$row['alamat'];
						$nomor=$row['no_hp'];
					}
				?>
				<?php echo '<img src="profil/'.$photos.'" alt="photo" </a>'; ?>  
				<h2><?php echo $nama; ?></h2>
				<p><?php echo $alamat; ?></p>
				<p><?php echo $nomor; ?></p>
				<div class="button1">
					<button class="btn1" onclick="window.location.href='menu.php';"><h4>Edit Profile</h4></button>
					<button class="btn1" onclick="window.location.href='follow.php';"><h4>Mengikuti</h4></button>
				</div>
				<div class="button2">
					<button onclick="window.location.href='post.php' " class="btn2">
					<?php
			  
			  		echo '<img src="profil/'.$row['photos'].'" alt="photo"</a>';

				?>  
			Buat Status</button>
				</div>

			
			</div>
			<!-- menampilkan postingan diambil dari tabel photos -->
			<?php
			include('koneksiPDO.php');
			$status = $koneksi->prepare("SELECT * FROM photos WHERE(id_user = :id_user)");
			$status->bindValue('id_user', $_SESSION['id_user']);
			$status->execute();
			$baris = $status->fetchAll(PDO::FETCH_ASSOC);
			$panjang_baris = count($baris);
			for($i=$panjang_baris-1; $i>=0;$i--){
				$row = $baris[$i];
				$photo=$row['nama_photos'];
				$keterangan=$row['keterangan'];
				echo'<div align="center" class="kotak" >
				<fieldset >
					<div align="left" class="status">
						<table>
						<div class="row">
							<td> ';
						
						echo '<img src="profil/'.$photos.'" alt="photo" </a>';
						
					echo'</td>
						</div>
						<div  class="colom">
							<td><h3>'; echo $nama; echo '</h3></td>
						</div>
						</table>
							
						<div>';
						
							echo'<p>'; echo $keterangan; echo'</p>
						</div>
						<div align="center">';
							echo '<img  class="img2" src="upload/'.$photo.'" alt="photo">';
						echo'</div>
						
					</div>
					</fieldset>
					</div>';
			}
			?>
		</fieldset>
	</div>
</body>
</html>