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

<body>
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
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
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
                            <a class="nav-link active" href="pemasukan.php">
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
                            <li class="breadcrumb-item active" style="font-size: 24px; font-weight: bold;">Pemasukan
                            </li>
                        </ol>
                        <div class="row">
                            <!--grafik-->
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Grafik Pemasukan
                                    </div>
                                    <?php
                                    include "koneksi.php";

                                    // Query untuk mengambil nilai bulan dari kolom TglPemesanan
                                    $result = mysqli_query($koneksi, "SELECT MONTH(TglPemesanan) AS bulan, SUM(TPembayaran) AS total FROM pemesanan GROUP BY bulan;");

                                    // Mengambil hasil query ke dalam array
                                    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

                                    // Inisialisasi array untuk menyimpan data bulan dan total
                                    $bulanArray = [];
                                    $totalArray = [];

                                    // Array bulan statis
                                    $allMonths = range(1, 12);

                                    // Mengisi nilai nol untuk setiap bulan
                                    $filledData = array_fill_keys($allMonths, 0);

                                    // Mengisi nilai total yang diperoleh dari hasil query
                                    foreach ($data as $row) {
                                        $filledData[$row['bulan']] = $row['total'];
                                    }

                                    // Mengonversi nilai bulan numerik menjadi nama bulan
                                    $bulanArray = array_map(function ($bulan) {
                                        return date('F', mktime(0, 0, 0, $bulan, 1));
                                    }, array_keys($filledData));

                                    // Memisahkan data bulan dan total menjadi dua array terpisah
                                    $totalArray = array_values($filledData);
                                    ?>

                                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                                    <script>
                                        // Menggunakan data yang diambil dari database
                                        var xValues = <?php echo json_encode($bulanArray); ?>;
                                        var yValues = <?php echo json_encode($totalArray); ?>;
                                        var barColors = ["red", "green", "blue", "orange", "brown", "purple", "pink", "gray", "cyan", "magenta", "yellow", "lime"];

                                        new Chart("myChart", {
                                            type: "bar",
                                            data: {
                                                labels: xValues,
                                                datasets: [{
                                                    backgroundColor: barColors,
                                                    data: yValues
                                                }]
                                            },
                                            options: {
                                                legend: { display: false },
                                                title: {
                                                    display: true,
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-table me-1"></i>
                                        Tabel Pemasukan
                                    </div>
                                    <div class="row1" style="margin-left: 160px;">
                                        <a href="pemasukan.php" class="btn btn-primary">All Pemasukan</a>
                                        <a href="pemasukan_bl.php" class="btn btn-primary">Belum Lunas</a>
                                        <a href="pemasukan_ln.php" class="btn btn-primary">Lunas</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table border='1' id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th style="border: 1px solid black;">Nomor</th>
                                            <th style="border: 1px solid black;">Nomor Pemesanan</th>
                                            <th style="border: 1px solid black;">Total Pembayaran</th>
                                            <th style="border: 1px solid black;">Tanggal Pemesanan</th>
                                            <th style="border: 1px solid black;">Total Item</th>
                                            <th style="border: 1px solid black;">Bayar Awal</th>
                                            <th style="border: 1px solid black;">Kurang</th>
                                            <th style="border: 1px solid black;">Kembali</th>
                                            <th style="border: 1px solid black;">Status</th>
                                            <th style="border: 1px solid black;">Diskon</th>
                                            <th style="border: 1px solid black;">Konsumen</th>
                                            <th style="border: 1px solid black;" colspan='2'>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include "koneksi.php";
                                        $sql = "select * from pemesanan WHERE status = 'Belum Lunas'";
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
                                                    <?php echo $data["TPembayaran"]; ?>
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    <?php echo $data["TglPemesanan"]; ?>
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    <?php echo $data["TItem"]; ?>
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    <?php echo $data["Bawal"]; ?>
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    <?php echo $data["Kurang"]; ?>
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    <?php echo $data["Kembali"]; ?>
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    <?php echo $data["Status"]; ?>
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    <?php echo $data["Diskon"]; ?>
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    <?php echo $data["IdKonsumen"]; ?>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-warning" role="button"
                                                        class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#modalUbahPemasukan<?php echo $no; ?>">Update</a>
                                                </td>
                                            </tr>
                                            <!-- Awal Modal Update -->
                                            <div class="modal fade" id="modalUbahPemasukan<?php echo $no; ?>"
                                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Ubah Keterangan
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST" action="update_pemasukan.php"
                                                            enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="nopesan" class="form-label">Nomor
                                                                        Pemesanan</label>
                                                                    <input type="text" name="nopesan" value="<?php echo $data["NoPesanan"]; ?>"
                                                                        class="form-control" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="total" class="form-label">Total
                                                                        Pembayaran</label>
                                                                    <input type="text" name="total" value="<?php echo $data["TPembayaran"]; ?>"
                                                                        class="form-control" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="bawal" class="form-label">Bayar Awal</label>
                                                                    <input type="text" name="bawal" value="<?php echo $data["Bawal"]; ?>"
                                                                        class="form-control" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="kurang" class="form-label">Kurang</label>
                                                                    <input type="text" name="kurang" value="<?php echo $data["Kurang"]; ?>"
                                                                        class="form-control" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <input type="text" name="status" value="<?php echo $data["Status"]; ?>"
                                                                        class="form-control" >
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
                <footer>
                </footer>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
            crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
            crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

</html>