<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

include "../koneksiPDO.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUTTIME</title>

    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/main.css">

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

    <!-- menampilkan jumlah dari data user, admin, dan post -->
    <div class="main_contant">

        <div class="bread-crumbs">
            <ul>
                <li>
                    <span><i class="fas fa-home"></i></span>
                    <h3>Dashboard</h3>
                </li>
            </ul>
        </div>
        
        <div class="info_card">
            <div class="card">
                <span><i class="fas fa-male"></i></span>
                <div class="number_detail">
                    <?php $userRows = $koneksi->query('select count(*) from user WHERE level="user"')->fetchColumn(); ?>
                    <p>Users</p>
                    <h2><?php echo $userRows ;?></h2>
                </div>
            </div>
            <div class="card">
                <span><i class="fas fa-image"></i></span>
                <div class="number_detail">
                    <?php $photosRows = $koneksi->query('select count(*) from photos')->fetchColumn(); ?>
                    <p>Photos</p>
                    <h2><?php echo $photosRows ;?></h2>
                </div>
            </div>
            <div class="card">
                <span><i class="fas fa-info"></i></span>
                <div class="number_detail">
                    <?php $adminRows = $koneksi->query('select count(*) from user WHERE level="admin"')->fetchColumn(); ?>
                    <p>Users</p>
                    <h2><?php echo $adminRows ;?></h2>
                </div>
            </div>
        </div>

    </div>
                                       
</body>
</html>