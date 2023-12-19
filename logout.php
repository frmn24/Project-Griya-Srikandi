<?php
session_start();
session_destroy(); // Menghapus semua data sesi

// Redirect pengguna kembali ke halaman login (misalnya login.php)
header('Location: indexx.php');
exit;
?>
