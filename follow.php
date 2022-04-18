<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("Location: user_login.php");
		exit;
	}
	include "koneksiPDO.php";
	
?>
<!DOCTYPE html>

<html lang="id">
<head>
	<link rel="stylesheet" type="text/css" href="css/profileStatus.css">
	<meta charset="utf-8">
	<title>Search</title>
	<link rel="stylesheet" href="css/header.css">
</head>
<body>
    <!-- header -->
    <?php
		include('header.inc');
	?>
    <!-- container -->
	<div align= "center" class="container">
        <h2>Daftar User yang Anda Ikuti</h2>
        <!-- menampilkan data nama dan foto user yang sudah anda ikuti -->
        <?php
            $following = $koneksi->prepare("SELECT * FROM follow WHERE (id_user = :id_user)");
            $following->bindValue(':id_user', $_SESSION['id_user']);
            $following->execute();
            foreach ($following as $list ) {
                // cari nama dan foto berdasarkan id user follow	
                $id_user_follow = $list['id_user_follow'];
                $cari_profil = $koneksi->prepare("SELECT nama, photos FROM user WHERE(id_user = :id_user)");
                $cari_profil->bindValue(':id_user', $id_user_follow);
                $cari_profil->execute();
                foreach($cari_profil as $list){
                    $nama_user = $list['nama'];
                    $foto_user = $list['photos'];
                }
                // tampilkan foto dan nama user yang sudah di follow
                echo'<div align="center" class="kotak" >
                <fieldset >
                    <div align="left" class="status">
                        <table>
                        <div class="row">
                            <td> ';
                        
                        echo '<img src="profil/'.$foto_user.'" alt="photo" </a>';
                        
                    echo'</td>
                        </div>
                        <div  class="colom">
                            <td><h3><a href="user_search.php?id_user='; echo $id_user_follow; echo'">'; echo $nama_user; echo '</a></h3></td>
                        </div>
                        </table>
                    </div>
                    </fieldset>
                    </div>';

            }
            ?>
        </fieldset>
		</div>
	</div>
</body>
</html>