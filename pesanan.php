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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
                        <a class="nav-link active" href="pesanan.php">
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
                    <ol class="breadcrumb mb-5">
                        <li class="breadcrumb-item active" style="font-size: 24px; font-weight: bold;">Pesanan</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <?php
                                    include "koneksi.php";
                                    $sql = "SELECT COUNT(*) as total_pesanan FROM pemesanan";
                                    $hasil = mysqli_query($koneksi, $sql);
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($hasil)):
                                        ?>
                                        <p class="card-text">Total Pesanan:</p>
                                        <p class="card-text text-center mb-3 display-6">
                                            <?php echo $data['total_pesanan']; ?><br>Pesanan
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <?php
                                    include "koneksi.php";
                                    $sql = "SELECT COUNT(*) as total_pesanan FROM detail_pesanan WHERE keterangan = 'Pesanan Masuk'";
                                    $hasil = mysqli_query($koneksi, $sql);

                                    if ($hasil) {
                                        $data = mysqli_fetch_array($hasil);
                                        $total_pesanan = $data['total_pesanan'];
                                        ?>
                                        <p class="card-text">Total Pesanan Masuk:</p>
                                        <p class="card-text text-center mb-3 display-6">
                                            <?php echo $total_pesanan; ?><br>Pesanan
                                        </p>
                                        <?php
                                    } else {
                                        echo "Error: " . mysqli_error($koneksi);
                                    }

                                    mysqli_close($koneksi);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <?php
                                    include "koneksi.php";
                                    $sql = "SELECT COUNT(*) as total_pesanan FROM detail_pesanan WHERE keterangan = 'Dalam Proses'";
                                    $hasil = mysqli_query($koneksi, $sql);

                                    if ($hasil) {
                                        $data = mysqli_fetch_array($hasil);
                                        $total_pesanan = $data['total_pesanan'];
                                        ?>
                                        <p class="card-text">Total Pesanan Dalam Proses:</p>
                                        <p class="card-text text-center mb-3 display-6">
                                            <?php echo $total_pesanan; ?><br>Pesanan
                                        </p>
                                        <?php
                                    } else {
                                        echo "Error: " . mysqli_error($koneksi);
                                    }

                                    mysqli_close($koneksi);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-secondary text-white mb-4">
                                <div class="card-body">
                                    <?php
                                    include "koneksi.php";
                                    $sql = "SELECT COUNT(*) as total_pesanan FROM detail_pesanan WHERE keterangan = 'Selesai'";
                                    $hasil = mysqli_query($koneksi, $sql);
                                    if ($hasil) {
                                        $data = mysqli_fetch_array($hasil);
                                        $total_pesanan = $data['total_pesanan'];
                                        ?>
                                        <p class="card-text">Total Pesanan Selesai:</p>
                                        <p class="card-text text-center mb-3 display-6">
                                            <?php echo $total_pesanan; ?><br>Pesanan
                                        </p>
                                        <?php
                                    } else {
                                        echo "Error: " . mysqli_error($koneksi);
                                    }

                                    mysqli_close($koneksi);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!--grafik-->

                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-table me-1"></i>
                                    Tabel Pesanan
                                </div>
                                <div class="row1" style="margin-left: 160px;">
                                    <a href="pesanan.php" class="btn btn-primary">All Pesanan</a>
                                    <a href="pesanan_msk.php" class="btn btn-primary">Pesanan Masuk</a>
                                    <a href="pesanan_dp.php" class="btn btn-primary">Dalam Proses</a>
                                    <a href="pesanan_sls.php" class="btn btn-primary">Pesanan Selesai</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table border='1' id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th style="border: 1px solid black;">Nomor</th>
                                        <th style="border: 1px solid black;">Nomor Pemesanan</th>
                                        <th style="border: 1px solid black;">Kode Produk</th>
                                        <th style="border: 1px solid black;">Harga Produk</th>
                                        <th style="border: 1px solid black;">Total Item</th>
                                        <th style="border: 1px solid black;">Tanggal Ambil</th>
                                        <th style="border: 1px solid black;">Keterangan</th>
                                        <th style="border: 1px solid black;" colspan='2'>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "koneksi.php";
                                    $sql = "SELECT * FROM detail_pesanan";
                                    $hasil = mysqli_query($koneksi, $sql);
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($hasil)):
                                        ?>
                                        <tr>
                                            <td style="border: 2px solid black;">
                                                <?php echo $no++ ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["NoPesanan"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["KProduk"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["harga"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["jumlah"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["tanggal_ambil"]; ?>
                                            </td>
                                            <td style="border: 1px solid black;">
                                                <?php echo $data["keterangan"]; ?>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-warning" role="button" class="btn btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalUbahPesanan<?php echo $no; ?>">Update</a>
                                            </td>
                                        </tr>
                                        <!-- Awal Modal Update -->
                                        <div class="modal fade" id="modalUbahPesanan<?php echo $no; ?>"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Ubah Produk
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="update.php" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="kodeproduk" class="form-label">Nomor
                                                                    Pemesanan</label>
                                                                <input type="text" name="kodeproduk"
                                                                    value="<?php echo $data["NoPesanan"]; ?>"
                                                                    class="form-control" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="kodeProduk" class="form-label">Kode
                                                                    Produk</label>
                                                                <input type="text" name="kodeProduk"
                                                                    value="<?php echo $data["KProduk"]; ?>"
                                                                    class="form-control" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="hargaproduk" class="form-label">Harga
                                                                    Produk</label>
                                                                <input type="number" name="hargaproduk"
                                                                    value="<?php echo $data["harga"]; ?>"
                                                                    class="form-control" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="titem" class="form-label">Total Item</label>
                                                                <input type="number" name="titem"
                                                                    value="<?php echo $data["jumlah"]; ?>"
                                                                    class="form-control" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tanggal_ambil" class="form-label">Tanggal
                                                                    Ambil</label>
                                                                <input type="text" id="tanggal_ambil" name="tanggal_ambil"
                                                                    value="<?php echo $data["tanggal_ambil"]; ?>"
                                                                    class="form-control datepicker">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="keterangan"
                                                                    class="form-label">Keterangan</label>
                                                                <input type="text" name="keterangan"
                                                                    value="<?php echo $data["keterangan"]; ?>"
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
                                        <?php
                                    endwhile;
                                    ?>
                                </tbody>
                            </table>
                        </div>
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
    <script>
        $(document).ready(function () {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd', // Sesuaikan dengan format tanggal yang Anda inginkan
                changeMonth: true,
                changeYear: true
            });
        });
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