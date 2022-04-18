<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

// validasi
$errnama = $errphone = $erralamat = $errgambar = "";
$valnama = $errphone = $valalamat = "";
include "../koneksiPDO.php";
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
            move_uploaded_file($tempname, "../profil/". $namaFile);
            $valid++;
        }
    }

    if($valid == 4){
        $query = $koneksi->prepare("UPDATE user SET nama = :nama, no_hp = :phonenumber, alamat = :alamat, photos = :photo WHERE id_user = :id_user");
        $query->bindValue(":nama", $_POST["Name"]);
        $query->bindValue(":phonenumber", $_POST["PhoneNumber"]);
        $query->bindValue(":alamat", $_POST["alamat"]);
        $query->bindValue(":photo", $namaFile);
        $query->bindValue(":id_user", $_SESSION['id_admin']);
        $query->execute();

        // berhasil
        echo "<script>alert('Berhasil !!');";
        echo "document.location.href = 'setting.php';";
        echo "</script>";
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUTTIME</title>

    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/menu.css">

</head>
<body>
    
    <!-- nav bar -->
    <div class="sidebar-nav">
        <div class="logo">
            <a href="#">
                <h1>CUTTIME</h1>
            </a>
            
        </div>
        <div class="side-nav">
            <ul>
                <li>
                    <span><i class="fas fa-home"></i></span>
                    <a href="index.php">Dashbord</a>
                </li>
                <li>
                    <span><i class="fa fa-user-circle"></i></span>
                    <a href="user.php">Users</a>
                </li>
                <li>
                    <span><i class="fa fa-user-circle"></i></span>
                    <a href="admin.php">Admin</a>
                </li>
                <li>
                    <span><i class="fa fa-file-image"></i></span>
                    <a href="photos.php">Photos</a>
                </li>
                <li>
                    <span><i class="fa fa-cog"></i></span>
                    <a href="setting.php">Setting</a>
                </li>
                <li>
                    <span><i class="fa fa-sign-out-alt"></i></span>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- edit profil -->
    <div class="main_contant">
        <div class="bread-crumbs">
            <ul>
                <li>
                    <span><i class="fas fa-user-circle"></i></span>
                    <h3>Setting - Edit Profile</h3>
                </li>
            </ul>
        </div>
        <div class="box">
            <?php
                try {
                    include "../koneksiPDO.php";
                    echo " ";
                } catch (PDOException $mesaage) {
                    echo "koneksi gagal" . $message->getMessage();
                }
                $id_admin = $_SESSION['id_admin'];
                $sql = "select * from user WHERE id_user=$id_admin";
                $query = $koneksi->query($sql);
                $baris = $query->fetch(PDO::FETCH_ASSOC);
            ?>
            <form action="setting.php" method="POST" enctype="multipart/form-data">
                <?php echo '<img src="../profil/'.$baris['photos'].'" alt="photo">'; ?> 
				<br>
				<?php echo $errgambar ?>
                <input class="btn-file" type="file" name="gambar" id="file" accept="image/*"/>
                <br><?php echo $errnama ?>
                <input type="text" name="Name" class="input-form" value="<?php if(isset($baris['nama'])) echo htmlspecialchars($baris['nama'])?>" >
                <br><?php echo $errphone ?>
                <input type="text" name="PhoneNumber" class="input-form" value="<?php if(isset($baris['no_hp'])) echo htmlspecialchars($baris['no_hp'])?>">
                <br><?php echo $erralamat ?>
                <input type="text" name="alamat" class="input-form" value="<?php if(isset($baris['alamat'])) echo htmlspecialchars($baris['alamat'])?>">
                 
                <input class="btn-simpan" name="submit" type="submit" value="Simpan">
            </form>
        </div>
    </div>
    
</body>
</html>