<?php
// Lakukan koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "griya4";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah form telah dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir
    $nopesanan = $_POST["nopesan"];
    $status = $_POST["status"];

    // Lakukan query update
    $sql = "UPDATE pemesanan SET Status = '$status' WHERE NoPesanan = '$nopesanan'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Data berhasil diupdate.');
                window.location.href='pemasukan_bl.php'; // Gantilah dengan halaman yang sesuai
             </script>";
    } else {
        echo "<script>
                alert('Error: " . $sql . "\\n" . $conn->error . "');
                window.location.href='pemasukan_bl.php'; // Gantilah dengan halaman yang sesuai
             </script>";
    }
}

// Tutup koneksi
$conn->close();
?>
