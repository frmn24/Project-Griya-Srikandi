<?php
$server = "griya-srikandi.tifa.myhost.id";
$username = "tifamyho_srikandi";
$password = "@JTIpolije2023";
$db = "tifamyho_srikandi";
$koneksi = mysqli_connect($server, $username, $password, $db);
if (mysqli_connect_errno()) {
    echo "koneksi Gagal : " .mysqli_connect_error();
}

?>