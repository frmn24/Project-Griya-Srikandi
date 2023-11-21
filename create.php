<?php
require('koneksi.php');

function getLatestProductCode($koneksi) {
    $query = "SELECT KProduk FROM produk ORDER BY KProduk DESC LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row['KProduk'];
    }

    return null;
}

// Ambil data dari formulir
$nama_produk = $_POST['namaproduk'];
$harga_jual = $_POST['hargajual'];
$harga_produksi = $_POST['hargapro'];

// Informasi gambar
$gambar_name = $_FILES['gambar']['name'];
$gambar_tmp = $_FILES['gambar']['tmp_name'];
$gambar_size = $_FILES['gambar']['size'];
$gambar_error = $_FILES['gambar']['error'];

// Tentukan direktori penyimpanan gambar
$upload_dir = 'gambar/';

// Cek apakah gambar diunggah dengan sukses
if ($gambar_error === UPLOAD_ERR_OK) {
    // Generate nama unik untuk gambar
    $gambar_new_name = uniqid('produk_', true) . '_' . $gambar_name;

    // Pindahkan gambar ke direktori penyimpanan
    $gambar_path = $upload_dir . $gambar_new_name;
    move_uploaded_file($gambar_tmp, $gambar_path);
    // Set izin baca untuk file gambar
    chmod($gambar_path, 0644);

    // Generate kode produk secara otomatis
    $latestCode = getLatestProductCode($koneksi);

    // Extract nomor dari kode produk terakhir
    $latestNumber = (int) substr($latestCode, 2);

    // Increment nomor
    $newNumber = $latestNumber + 1;

    // Format ulang nomor (menggunakan dua digit)
    $formattedNumber = sprintf('%02d', $newNumber);

    // Buat kode produk baru
    $kode_produk = 'KP' . $formattedNumber;

    // Gunakan parameterized query untuk mencegah SQL Injection
    $simpan = mysqli_prepare($koneksi, "INSERT INTO produk (KProduk, NProduk, HJual, Hproduksi, gambarproduk) VALUES (?, ?, ?, ?, ?)");

    // Bind parameter ke statement
    mysqli_stmt_bind_param($simpan, 'ssdds', $kode_produk, $nama_produk, $harga_jual, $harga_produksi, $gambar_path);

    // Execute statement
    $result = mysqli_stmt_execute($simpan);

    if ($result) {
        echo "<script>
            alert('Sukses Menambah Data');
            window.location.href='databarang.php';
            </script>";
        exit();
    } else {
        echo "<script>
            alert('Gagal Menambah Data');
            window.location.href='databarang.php';
            </script>";
        exit();
    }
} else {
    // Handle kesalahan pengunggahan gambar
    echo "Error uploading image: " . $gambar_error;
}

if (isset($_POST['ubah'])) {

    $ubah = mysqli_query($koneksi, "UPDATE produk SET  
    KProduk='$_POST[kodeproduk]', NProduk='$_POST[namaproduk]', HJual='$_POST[hargajual]', Hproduksi='$_POST[hargapro]' WHERE KProduk='$_POST[kodeproduk]'");

    if ($ubah) {
        echo "<script>
            alert('Update Sukses');
            window.location.href='databarang.php';
            </script>";
    } else {
        echo "<script>
            alert('Update Gagal');
            window.location.href='databarang.php';
            </script>";
    }
}


if (isset($_POST['hapus'])) {
    include "koneksi.php"; // Sertakan file koneksi

    $kode_produk = $_POST['kodeproduk'];

    $query = "DELETE FROM produk WHERE KProduk = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $kode_produk);

    if ($stmt->execute()) {
        echo "<script>
            alert('Hapus Data Sukses');
            document.location='index.php';
            </script>";
    } else {
        echo "<script>
            alert('Hapus Data Gagal');
            document.location='index.php';
            </script>";
    }
}

//hallo
?>