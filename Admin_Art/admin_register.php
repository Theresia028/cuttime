<?php
session_start();
if(isset($_SESSION['admin'])){
    header("Location: index.php");
}
// ini validasi
$errnama = $erremail =  $errphone = $errtempat = $errtgl = $erralamat = $errpassword = $errgambar = "";
if (isset($_POST["submit"])){
    $valid=0;
    
    // validasi require all

    // validasi nama dan alfabet
    if ($_POST["nama"] == ""){
        $errnama = "*nama harus diisi";
    } elseif (!preg_match('/^[a-zA-Z ]*$/', $_POST["nama"])){ // validasi dengan alfabet
        $errnama = "*Hanya boleh huruf dan spasi";
    } else {
        $valid++;
        $errnama = "";
    }

    // validasi email
    if ($_POST["email"] == ""){
        $erremail = "*email harus diisi";
    } elseif (!preg_match('/^[a-zA-Z0-9@.]*$/', $_POST["email"]) ){ 
        $erremail = "*hanya huruf / angka dan @";
    } else {
        $erremail = "";
        $valid++;

    }

    // validasi numerik
    // validasi panjang karakter
    if($_POST["no_hp"] == ""){
        $errphone = "*No telpon harus diisi";
    } elseif (!preg_match( "/^[0-9]*$/", $_POST["no_hp"])){ // validasi dengan numerik
        $errphone = "*No telpon harus berupa angka";
    } elseif (strlen($_POST["no_hp"]) < 8 || strlen($_POST["no_hp"]) > 13){ 
        $errphone = "*No telpon minimal 8 angka dan maksimal 13 angka";
    } else {
        $valid++;
        $errphone = "";
    }

    // validasi alfabet
    if ($_POST["tempat_lahir"] == ""){
        $errtempat = "*tempat lahir harus diisi";
    } elseif (!preg_match('/^[a-zA-Z]*$/', $_POST["tempat_lahir"])){ // validasi dengan alfabet
        $errtempat = "*Hanya boleh huruf";
    } else {
        $errtempat = "";
        $valid++;

    }

    // validasi require
    if ($_POST["tgl_lahir"] == ""){
        $errtgl = "*tanggal lahir harus diisi";
    } else {
        $errtgl = "";
        $valid++;

    }

    // validasi require
    if ($_POST["alamat"] == ""){
        $erralamat = "*alamat harus diisi";
    } else {
        $erralamat = "";    
        $valid++;

    }

    // validasi panjang karakter minimal 8
    // validasi password dengan huruf besar kecil dan angka
    // validasi inputan password harus sama
    if($_POST["password"] == ""){
        $errpassword = "*password harus diisi";
    } elseif (strlen($_POST["password"]) < 8 ){
        $errpassword = "*minimal 8 karakter";
    } elseif (!preg_match('@[A-Z]@', $_POST["password"]) || !preg_match('@[a-z]@', $_POST["password"]) || !preg_match('@[0-9]@', $_POST["password"])){
        $errpassword = "*minimal harus ada 1 huruf besar, kecil dan angka ";
    } elseif($_POST["password"] != $_POST["password1"]){
        $errpassword = "*password tidak sama";
    } else {
        $valid++;
        $errpassword = "";
    }

    // validasi require
    if ($_FILES["photos"] == ""){
        $errgambar = "*gambar harus diupload";
    } else {
        $errgambar = "";
        $valid++;

    }

    // jika sudah tidak error, input ke db
    if($valid == 8){
        $namaFile = $_FILES["photos"]["name"];
        $ukuranFile = $_FILES["photos"]["size"];
        $error = $_FILES["photos"]["error"];
        $tempname = $_FILES["photos"]["tmp_name"];
            move_uploaded_file($tempname, "../profil/". $namaFile);

        // enkripsi password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        //database
        include("../koneksiPDO.php");
        $statement = $koneksi->prepare("INSERT INTO user (nama, email, alamat, no_hp, tgl_lahir, tempat_lahir, photos, level, password) VALUEs (:nama, :email, :alamat, :no_hp, :tgl_lahir, :tempat_lahir, :photos, :level, :password)");
        $statement->bindValue(':nama', $_POST['nama']);
        $statement->bindValue(':email', $_POST['email']);
        $statement->bindValue(':alamat', $_POST['alamat']);
        $statement->bindValue(':no_hp', $_POST['no_hp']);
        $statement->bindValue(':tgl_lahir', $_POST['tgl_lahir']);
        $statement->bindValue(':tempat_lahir', $_POST['tempat_lahir']);
        $statement->bindValue(':photos', $namaFile);
        $statement->bindValue(':level','admin');
        $statement->bindValue(':password', $password);
        $statement->execute();

        // alert message dan direct ke form-login
        echo "<script>alert('registrasi sukses !!');";
        echo "document.location.href = 'admin_login.php';";
        echo "</script>";

    }

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
    <!-- form register -->
    <div class="container">
        <fieldset>
        <h3 class="logo">Register Admin</h3>
        <span></span>
        <h4 class="logo">Buat akun Baru</h4>
        <!-- form register -->
        <form action="admin_register.php" enctype="multipart/form-data" method="post" >
            <label for="nama">Nama</label>
            <?php echo '<div class="warna_huruf">' . $errnama . "</div>" ?>
            <div>
                <input type="text" class="form-input" name="nama" value="<?php if(isset($_POST['nama'])) echo htmlspecialchars($_POST['nama'])?>">
            </div>
            <label for="email">E-Mail</label>
            <?php echo '<div class="warna_huruf">' . $erremail . "</div>" ?>
            <div>
                <input type="text" class="form-input" name="email" value="<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email'])?>">
            </div>
            <label for="telp">Alamat</label>
            <?php echo '<div class="warna_huruf">' . $erralamat . "</div>" ?>
            <div>
                <input type="text" class="form-input" name="alamat" value="<?php if(isset($_POST['alamat'])) echo htmlspecialchars($_POST['alamat'])?>">
            </div>
            <label for="telp">Nomor HP</label>
            <?php echo '<div class="warna_huruf">' . $errphone . "</div>" ?>
            <div>
                <input type="text" class="form-input" name="no_hp" value="<?php if(isset($_POST['no_hp'])) echo htmlspecialchars($_POST['no_hp'])?>">
            </div>
            <label for="telp">Tempat Lahir</label>
            <?php echo '<div class="warna_huruf">' . $errtempat . "</div>" ?>
            <div>
                <input type="text" class="form-input" name="tempat_lahir" value="<?php if(isset($_POST['tempat_lahir'])) echo htmlspecialchars($_POST['tempat_lahir'])?>">
            </div>
            <label for="tanggal-lahir">Tanggal lahir</label>
            <?php echo '<div class="warna_huruf">' . $errtgl . "</div>" ?>
            <div>
                <input type="date" class="form-input" name="tgl_lahir" value="<?php if(isset($_POST['tgl_lahir'])) echo htmlspecialchars($_POST['tgl_lahir'])?>"> 
            </div>
            <label for="tanggal-lahir">Upload Foto</label>
            <?php echo '<div class="warna_huruf">' . $errgambar . "</div>" ?>
            <div>
                <input type="file" name="photos" class="form-input">
            </div>
            <label for="password">Password</label>
            <?php echo '<div class="warna_huruf">' . $errpassword . "</div>" ?>
            <div>
                <input type="password" class="form-input" name="password">
            </div>
            <label for="password1">Konfirmasi Password</label>
            <?php echo '<div class="warna_huruf">' . $errpassword . "</div>" ?>
            <div>
                <input type="password" class="form-input" name="password1">
            </div>
            <br>
            <button type="submit" name="submit" class="daftar">Daftar</button>
            <div class="atau">
                <span class="span1"></span>
                <span class="span2"></span>
                <p> atau </p>
                <span class="span2"></span>
                <span class="span1"></span>
            </div>
            <input type="button" class="Back-Login" onclick="location.href='admin_login.php'" value="Back to Login" />
            
        </form>
        </fieldset>
    </div>
</body>
</html>