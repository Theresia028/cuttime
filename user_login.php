<?php
session_start();
if(isset($_SESSION['user'])){
    header("Location: status.php");
    exit;
}
// email dan enkripsi password
// ini validasi
$erremail = $errpassword = "";
if (isset($_POST["submit"])){
    $valid=0;
    
    //validasi kosong(require)
    // validasi dengan email
    if ($_POST["email"] == ""){
        $erremail = "*email harus diisi";
    } elseif (!preg_match('/^[a-zA-Z0-9@.]*$/', $_POST["email"])){ 
        $erremail = "*harus boleh huruf dan angka";
    } else {
        $erremail = "";
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
    } else {
        $valid++;
        $errpassword = "";
    }


    if($valid == 2){
        try{
    
            $email = $_POST['email'];
            $password = $_POST['password'];
            //database
            include 'koneksiPDO.php';
            $statement = $koneksi->prepare("SELECT * FROM user WHERE(email = :email)");
            $statement->bindValue(':email', $_POST['email']);
            $statement->execute();
        
            // cek email, apakah ada?
            if( $statement->rowCount() >= 1){
        
                // cek password
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                if(password_verify($password, $row['password'])){
                    // alert message dan direct ke dashbord user jika levelnya sesuai
                    if($row['level'] == 'user'){
                        $_SESSION['user'] = true;
                        $_SESSION ['id_user'] = $row['id_user'];
                        header("Location: status.php");
                        exit;
                    }
                    // jika levelnya beda, maka akan kembali ke halaman login
                    echo "<script>alert('email / password salah !!');";
                    echo "document.location.href = 'user_login.php';";
                    echo "</script>";
                }
            }
        
            // jika error
            $error = True;
            if($error == True){
                echo "<script>alert('email / password salah !!');";
                echo "document.location.href = 'user_login.php';";
                echo "</script>";
            }
        }
        
        
        catch(PDOException $err)
        {
            echo $err->getMessage();
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <!-- form login -->
    <div class="container">
        <!-- logo -->
        <h3 class="logo">Art Room</h3>
        <span></span>
        <h4 class="logo">Silahkan login terlebih dahulu</h4>
        <br>
        <form action="user_login.php" method="post">
            <!-- email -->
            <div>
                <label>Email address</label>
                <?php echo '<div class="warna_huruf">' . $erremail . "</div>" ?>
                <div>
                    <input class="form-input" type="text" name="email" value="<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email'])?>">
                </div>
            </div>
            <!-- password -->
            <div>
                <label>Password</label>
                <?php echo '<div class="warna_huruf">' . $errpassword . "</div>" ?>
                <div>
                    <input class="form-input" type="password" name="password">
                </div>
            </div>
            <br>
            <button type="submit" class="login" name="submit">Login</button>
            <div class="atau">
                <span class="span1"></span>
                <span class="span2"></span>
                <p> atau </p>
                <span class="span2"></span>
                <span class="span1"></span>
            </div>
            <input type="button" class="daftar" onclick="location.href='user_register.php'" value="Daftar" />
        </form>
    </div>
</body>
</html>