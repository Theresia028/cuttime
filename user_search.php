<!-- halaman user lain, bukan halaman user yg sedang login  -->
<?php
// start session, 
session_start();
if(!isset($_SESSION['user'])){
    header("Location: user_login.php");
    exit;
}

// koneksi db
include("./koneksiPDO.php");

// memasukkan data ketika melakukan follow ke db
$id_user_follow = $_GET['id_user'];
if(isset($_GET['follow'])){
	$follow_user = $koneksi->prepare("INSERT INTO follow ( id_user, id_user_follow) VALUES ( :id_user, :id_user_follow)");
	$follow_user->bindValue(':id_user', $_SESSION['id_user']);
	$follow_user->bindValue(':id_user_follow', $id_user_follow);
	$follow_user->execute();
}

// menghapus data di db ketika unfollow
if(isset($_GET['unfollow'])){
	$hapus = $koneksi->prepare("DELETE FROM follow WHERE (id_user = :id_user) AND (id_user_follow = :id_user_follow)");
	$hapus->bindValue(':id_user', $_SESSION['id_user']);
	$hapus->bindValue(':id_user_follow', $id_user_follow);
	$hapus->execute();
}


?>

<!DOCTYPE html>
<html lang="id">
<head>
	<link rel="stylesheet" type="text/css" href="css/profileStatus.css">
	<meta charset="utf-8">
	<title>Profile Orang</title>
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
				<?php
					// mengambil data user yg dituju
			   		include('koneksiPDO.php');	
					$id_user = $_GET['id_user'];
					$statement = $koneksi->prepare("SELECT photos, nama, alamat, no_hp FROM user WHERE(id_user = :id_user)");
					$statement->bindValue('id_user', $id_user);
					$statement->execute();
					// ambil data
					foreach ($statement as $row){ 
						$photos=$row['photos'];
						$nama=$row['nama'];
						$alamat=$row['alamat'];
						$nomor=$row['no_hp'];
					}
				?>
				<!-- menampilkan data user yg dituju -->
				<?php echo '<img src="profil/'.$photos.'" alt="photo" </a>'; ?>  
				<h2><?php echo $nama; ?></h2>
				<p><?php echo $alamat; ?></p>
				<p><?php echo $nomor; ?></p>
				<!-- button follow dan unfollow -->
				<div class="button1">
					<form action="user_search.php" method="get">
						<?php
							// mengambil data following dari tabel follow
							$unfollow = false;
							$following = $koneksi->prepare("SELECT * FROM follow WHERE (id_user = :id_user)");
							$following->bindValue(':id_user', $_SESSION['id_user']);
							$following->execute();
							foreach ($following as $list ) {
								// cari id user yang dicari, jika id user yang dicari ada di db follow
								// maka var unfollow true, sehingga akan menampilkan tombol unfollow
								// jika var unfollow tetap false, maka tampil tombol follow
								$id_follow = $list['id_user_follow'];
								if($id_user_follow == $id_follow){
									$unfollow = true;
								}
							}
							// cek, lalu tampil follow/unfollow
							if($unfollow == true){
								echo'<input type="hidden" name="id_user" value="';echo $id_user; echo'">';
								echo'<button type="submit" name="unfollow" class="btn_unfollow"><h4>Unfollow</h4></button>';
							} else{
								echo'<input type="hidden" name="id_user" value="';echo $id_user; echo'">';
								echo'<button type="submit" name="follow" class="btn1"><h4>Follow</h4></button>';
							}
						?>
						
					</form>
				</div>
			
			</div>
			<?php
			// mengambil data postingan dari user yg dituju
			include('koneksiPDO.php');
			$status = $koneksi->prepare("SELECT * FROM photos WHERE(id_user = :id_user)");
			$status->bindValue('id_user', $id_user);
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