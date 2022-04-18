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
	<div align= "center" class="container">
        <!-- menampilkan foto dan nama user yang dicari berdasarkan nama -->
        <?php
            $cari_nama = '%' . $_GET['cari_nama'] . '%';
            $status = $koneksi->prepare("SELECT * FROM user WHERE nama LIKE(:cari_nama)");
            $status->bindValue(':cari_nama', $cari_nama);
            $status->execute();
            foreach ($status as $list ) {
                // cari profil user dari post	
                $id_searh_user = $list['id_user'];
                $level = $list['level'];
                $nama_user = $list['nama'];
                $foto_user = $list['photos'];
                // tidak akan memunculkan user yg login dan admin
                if($id_searh_user == $_SESSION['id_user']){
                    continue;
                } elseif($level == 'admin'){
                    continue;
                }
                // tampilkan hasil search
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
                            <td><h3><a href="user_search.php?id_user='; echo $id_searh_user; echo'">'; echo $nama_user; echo '</a></h3></td>
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