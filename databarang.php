<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php'); // Redirect pengguna ke halaman login jika mereka belum login
    exit;
}

// Tampilkan konten halaman jika pengguna sudah login
$user_fullname = $_SESSION['user_fullname'];
?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3">Admin:
            <?php echo $user_fullname; ?>
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Cari" aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" onclick="confirmLogout()">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!-- <div class="sb-sidenav-menu-heading">Menu</div> -->
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="databarang.php">
                            Data Barang
                        </a>
                        <a class="nav-link" href="pemasukan.php">
                            Pemasukan
                        </a>
                        <a class="nav-link" href="pesanan.php">
                            Pesanan
                        </a>
                        <div class="sb-sidenav-menu-heading"></div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active" style="font-size: 24px; font-weight: bold;">Data Barang</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Tabel Barang
                        </div>
                        <div class="card-body">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary ms-3 float-end" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Tambah Produk
                            </button>
                            <table border='1' id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th style="border: 1px solid black;">Nomor</th>
                                        <th style="border: 1px solid black;">Kode Produk</th>
                                        <th style="border: 1px solid black;">Nama Produk</th>
                                        <th style="border: 1px solid black;">Harga Jual</th>
                                        <th style="border: 1px solid black;">Harga Produksi</th>
                                        <th style="border: 1px solid black;">Kategori</th>
                                        <th style="border: 1px solid black;">Gambar</th>
                                        <th style="border: 1px solid black;" colspan='2'>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "koneksi.php";
                                    $sql = "select * from produk order by KProduk asc";
                                    $hasil = mysqli_query($koneksi, $sql);
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($hasil)):
                                        ?>
                                        <tr>
                                            <td style="border: 2px solid black;">
                                                <?php echo $no++ ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["KProduk"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["NProduk"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["HJual"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["Hproduksi"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["kd_kategori"]; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if (!empty($data["gambarproduk"])) {
                                                    $gambar_path = 'gambar/' . $data["gambarproduk"]; 
                                                    echo "<img src='$gambar_path' alt='Gambar Produk' style='max-width: 100px; max-height: 100px;'>";
                                                } else {
                                                    echo "Tidak Ada Gambar";
                                                }
                                                ?>
                                            </td>



                                            <td>
                                                <a href="#" class="btn btn-warning" role="button" class="btn btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalUbah<?php echo $no; ?>">Update</a>
                                                <a href="#" class="btn btn-danger" role="button" data-bs-toggle="modal"
                                                    data-bs-target="#modalHapus<?php echo $no; ?>">Delete</a>
                                            </td>
                                        </tr>
                                        <!-- Awal Modal Update -->
                                        <div class="modal fade" id="modalUbah<?php echo $no; ?>" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Ubah Produk
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="update_img.php" enctype="multipart/form-data">
                                                        <div class="modal-body">

                                                            <div class="mb-3">
                                                                <label for="kodeproduk" class="form-label">Kode
                                                                    Produk</label>
                                                                <input type="text" name="kodeproduk"
                                                                    value="<?php echo $data["KProduk"]; ?>"
                                                                    class="form-control" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="namaproduk" class="form-label">Nama
                                                                    Produk</label>
                                                                <input type="text" name="namaproduk"
                                                                    value="<?php echo $data["NProduk"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="hargajual" class="form-label">Harga Jual</label>
                                                                <input type="number" name="hargajual"
                                                                    value="<?php echo $data["HJual"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="hargapro" class="form-label">Harga
                                                                    Produksi</label>
                                                                <input type="number" name="hargapro"
                                                                    value="<?php echo $data["Hproduksi"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="kategori" class="form-label">Kategori</label>
                                                                <input type="number" name="kategori"
                                                                    value="<?php echo $data["kd_kategori"]; ?>"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="gambar" class="form-label">Gambar Produk</label>
                                                                <input type="file" name="gambar" accept="image/*"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="ubah"
                                                                class="btn btn-primary">Ubah</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Akhir Modal Update -->


                                        <!-- Awal Modal Hapus -->
                                        <div class="modal fade" id="modalHapus<?php echo $no; ?>" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Hapus
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="create.php">
                                                        <div class="modal-body">

                                                            <h5 class="text-center"> Apakah Anda Yakin Akan Menghapus Data
                                                                Ini? <br>
                                                                <span class="text-danger">
                                                                    <?= $data["KProduk"] ?> -
                                                                    <?= $data["NProduk"] ?>
                                                                </span>
                                                            </h5>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="kodeproduk"
                                                                value="<?= $data["KProduk"] ?>">
                                                            <button type="submit" name="hapus" class="btn btn-danger">Ya,
                                                                Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Akhir Modal Hapus -->

                                        <?php
                                    endwhile;
                                    ?>
                                </tbody>
                            </table>
                            <!-- Awal Modal Tambah -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Form Tambah Produk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="POST" enctype="multipart/form-data" action="create.php">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="namaproduk" class="form-label">Nama Produk</label>
                                                    <input type="text" name="namaproduk" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="hargajual" class="form-label">Harga Jual</label>
                                                    <input type="number" name="hargajual" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="hargapro" class="form-label">Harga Produksi</label>
                                                    <input type="number" name="hargapro" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kategori" class="form-label">Kategori</label>
                                                    <input type="number" name="kategori" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="gambar" class="form-label">Gambar Produk</label>
                                                    <input type="file" name="gambar" class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="simpan"
                                                    class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Akhir Modal Tambah -->
                        </div>
                    </div>
            </main>
        </div>
    </div>
    <script>
        function confirmLogout() {
            var confirmation = confirm("Apakah Anda yakin ingin logout?");
            if (confirmation) {
                window.location.href = "logout.php";
            } else {

            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>