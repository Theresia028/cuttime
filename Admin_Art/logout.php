<?php
    // logout, hapus semua session, lalu pindah ke halaman index
    session_start();
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
?>