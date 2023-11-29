<?php
// Koneksi ke database (sesuaikan dengan koneksi Anda)
$koneksi = mysqli_connect("griya-srikandi.tifa.myhost.id", "tifamyho_srikandi", "JTIpolije2023", "tifamyho_srikandi");

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Query untuk mendapatkan kode produk berikutnya
$query = "SELECT MAX(KProduk) AS max_kode_produk FROM produk";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);
$next_kode_produk = $row['max_kode_produk'];

// Mengekstrak nomor dari kode produk berikutnya
$nomor = (int) substr($next_kode_produk, 2); // Mengabaikan "KP" dan mengubahnya menjadi angka

// Increment nomor untuk mendapatkan kode produk berikutnya
$nomor++;

// Format kode produk dengan tambahan nol pada awal (misalnya, "KP001")
$new_kode_produk = "KP" . sprintf("%03d", $nomor);

// Mengembalikan kode produk yang dihasilkan
echo $new_kode_produk;

// Tutup koneksi ke database
mysqli_close($koneksi);
?>
