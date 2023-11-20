<?php
$server = "localhost";
$username = "root";
$password = "";
$db = "griya";
$koneksi = mysqli_connect($server, $username, $password, $db);
if (mysqli_connect_errno()) {
    echo "koneksi Gagal : " .mysqli_connect_error();
}

?>