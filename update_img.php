<?php
$server = "griya-srikandi.tifa.myhost.id";
$username = "tifamyho_srikandi";
$password = "@JTIpolije2023";
$db = "tifamyho_srikandi";
$koneksi = mysqli_connect($server, $username, $password, $db);
if (mysqli_connect_errno()) {
    echo "koneksi Gagal : " . mysqli_connect_error();
}

if (isset($_POST['ubah'])) {
    // Lakukan sanitasi input jika diperlukan
    $kode_produk = mysqli_real_escape_string($koneksi, $_POST['kodeproduk']);
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['namaproduk']);
    $harga_jual = mysqli_real_escape_string($koneksi, $_POST['hargajual']);
    $harga_produksi = mysqli_real_escape_string($koneksi, $_POST['hargapro']);
    $kd_kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);

    // Tentukan apakah ada gambar yang dipilih dalam formulir ubah
    $gambar_name = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_size = $_FILES['gambar']['size'];
    $gambar_error = $_FILES['gambar']['error'];

    $upload_dir = 'gambar/';

    // Gunakan parameterized query untuk mencegah SQL Injection
    if ($gambar_error === UPLOAD_ERR_OK && $gambar_name != "") {
        // Jika ada gambar yang dipilih dan nama gambar baru tidak kosong, simpan gambar seperti pada formulir simpan
        $gambar_new_name = uniqid('produk_', true) . '_' . $gambar_name;
        $gambar_path = $upload_dir . $gambar_new_name;
        move_uploaded_file($gambar_tmp, $gambar_path);
        chmod($gambar_path, 0644);
        $gambar_name_only = $gambar_new_name; // Save only the file name
        $update = mysqli_prepare($koneksi, "UPDATE produk SET NProduk=?, HJual=?, Hproduksi=?, gambarproduk=?, kd_kategori=? WHERE KProduk=?");
        mysqli_stmt_bind_param($update, 'ssdsss', $nama_produk, $harga_jual, $harga_produksi, $gambar_name_only, $kd_kategori, $kode_produk);
    } else {
        // Jika tidak ada gambar yang dipilih atau gagal mengunggah gambar, update tanpa mengubah gambar
        $update = mysqli_prepare($koneksi, "UPDATE produk SET NProduk=?, HJual=?, Hproduksi=?, kd_kategori=? WHERE KProduk=?");
        mysqli_stmt_bind_param($update, 'ssdss', $nama_produk, $harga_jual, $harga_produksi, $kd_kategori, $kode_produk);
    }

    // Execute statement
    $result = mysqli_stmt_execute($update);

    if ($result) {
        echo "<script>
                alert('Update Sukses');
                window.location.href='databarang.php';
                </script>";
    } else {
        echo "<script>
                alert('Update Gagal: " . mysqli_error($koneksi) . "');
                window.location.href='databarang.php';
                </script>";
    }
}
?>