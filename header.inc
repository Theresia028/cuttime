
<div class="nav-header">
    <div class="container-head">
        <a class="home" href="status.php">Home</a>
    </div>
    <div class="form-search">
        <form action="search.php" method="GET"> 
            <input class="search" type="search" name="cari_nama" placeholder="Search..." value="<?php if(isset($_GET['cari_nama'])) echo htmlspecialchars($_GET['cari_nama'])?>">               
            <input class="button" type="submit" value="Search">        
        </form> 
    </div>
    <div class="container-head">
        <a href="profile.php?id_user=<?php echo $_SESSION['id_user']?>" class="logout">Profile</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</div>