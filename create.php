<?php
require('koneksi.php');

if (isset($_POST['simpan'])) {
    // Ambil data dari formulir
    $kode_produk = $_POST['kodeproduk'];
    $nama_produk = $_POST['namaproduk'];
    $harga_jual = $_POST['hargajual'];
    $harga_produksi = $_POST['hargapro'];

    // Informasi gambar
    $gambar_name = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_size = $_FILES['gambar']['size'];
    $gambar_error = $_FILES['gambar']['error'];

    // Tentukan direktori penyimpanan gambar
    $upload_dir = 'path/ke/direktori/gambar/';

    // Cek apakah gambar diunggah dengan sukses
    if ($gambar_error === UPLOAD_ERR_OK) {
        // Cek ukuran gambar (jika diperlukan)
        // if ($gambar_size > 500000) {
        //     echo "Maaf, gambar terlalu besar.";
        // } else {
        // Generate nama unik untuk gambar
        $gambar_new_name = uniqid('produk_', true) . '_' . $gambar_name;

        // Pindahkan gambar ke direktori penyimpanan
        $gambar_path = $upload_dir . $gambar_new_name;
        move_uploaded_file($gambar_tmp, $gambar_path);

        // Simpan data ke database
        $simpan = mysqli_query($koneksi, "INSERT INTO produk (KProduk, NProduk, HJual, Hproduksi, gambarproduk) 
        VALUES ('$kode_produk', '$nama_produk', '$harga_jual', '$harga_produksi', '$gambar_path')");

        if ($simpan) {
            echo "<script>
                alert('Sukses Menambah Data');
                document.location='index.php';
                </script>";
        } else {
            echo "<script>
                alert('Gagal Menambah Data');
                document.location='index.php';
                </script>";
        }
    } else {
        // Handle kesalahan pengunggahan gambar
        echo "Error uploading image.";
    }
}

if (isset($_POST['ubah'])) {
    // $kode_produk = $_POST['kodeproduk'];
    // $nama_produk = $_POST['namaproduk'];
    // $harga_jual = $_POST['hargajual'];
    // $harga_produksi = $_POST['hargapro'];

    $ubah = mysqli_query($koneksi, "UPDATE produk SET  
    KProduk='$_POST[kodeproduk]', NProduk='$_POST[namaproduk]', HJual='$_POST[hargajual]', Hproduksi='$_POST[hargapro]' WHERE KProduk='$_POST[kodeproduk]'");

    if($ubah){
        echo"<script>
            alert('Update Sukses');
            document.location='index.php';
            </script>";
    }else{
        echo"<script>
            alert('Update Gagal');
            document.location='index.php';
            </script>";
    }
}

// if (isset($_POST['hapus'])) {
//     // $kode_produk = $_POST['kodeproduk'];
//     // $nama_produk = $_POST['namaproduk'];
//     // $harga_jual = $_POST['hargajual'];
//     // $harga_produksi = $_POST['hargapro'];

//     $hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE KProduk='$_POST[kodeproduk]'");

//     if($hapus){
//         echo"<script>
//             alert('Hapus Data Sukses');
//             document.location='index.php';
//             </script>";
//     }else{
//         echo"<script>
//             alert('Hapus Data Gagal');
//             document.location='index.php';
//             </script>";
//     }
// }

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
