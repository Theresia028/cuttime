<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
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

  <!-- menampilkan daftar dari post -->
  <div class="main_contant">

    <div class="bread-crumbs">
      <ul>
        <li>
          <span><i class="fas fa-file-image"></i></span>
          <h3>Photos</h3>
        </li>
      </ul>
    </div>
    <div class="main">
      <?php
                try {
                    include "../koneksiPDO.php";
                    echo " ";
                } catch (PDOException $mesaage) {
                    echo "koneksi gagal" . $message->getMessage();
                }

                $sql = "select * from photos JOIN user ON photos.id_user=user.id_user";
                $query = $koneksi->query($sql);
            ?>
      <table>
        <thead>
          <tr>
            <td>Nama</td>
            <td>Postingan</td>
            <td>Keterangan</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
          <?php
                            while ($baris = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $baris['nama'] . "</td>";
                                echo "<td><img src='../upload/".$baris['nama_photos']."' width='100' height='100'></td>";
                                echo "<td>" . $baris['keterangan'] . "</td>";
                                echo "<td>" . "<a href='delete.php?id_photo=". $baris['id_photos'] . "'>Delete</a>" . "</td>";
                                echo "</tr>";
                            }
                        ?>
        </tbody>
      </table>
    </div>

  </div>

</body>

</html>