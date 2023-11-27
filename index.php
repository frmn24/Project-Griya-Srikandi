<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_email'])) {
    header('Location: index.html'); // Redirect pengguna ke halaman login jika mereka belum login
    exit;
}

// Tampilkan konten halaman jika pengguna sudah login
$user_fullname = $_SESSION['user_fullname'];
?>

<!DOCTYPE html>
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
    <script src="path/to/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
                    <li><a class="dropdown-item" onclick="confirmLogout()">Keluar</a></li>
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
                        <li class="breadcrumb-item active" style="font-size: 24px; font-weight: bold;">Dashboard</li>
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
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="pesanan.php">Lihat Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <?php
                                    include "koneksi.php";
                                    $sql = "SELECT SUM(TPembayaran) as total_pemasukan FROM pemesanan";
                                    $hasil = mysqli_query($koneksi, $sql);
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($hasil)):
                                        ?>
                                        <p class="card-text">Total Pemasukan:</p>
                                        <p class="card-text text-center mb-3 display-6">
                                            <?php echo number_format ($data['total_pemasukan']); ?><br>Rupiah
                                        </p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="pemasukan.php">Lihat Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <?php
                                    include "koneksi.php";
                                    $sql = "SELECT COUNT(*) as total_produk FROM produk";
                                    $hasil = mysqli_query($koneksi, $sql);
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($hasil)):
                                        ?>
                                        <p class="card-text">Total Produk:</p>
                                        <p class="card-text text-center mb-3 display-6">
                                            <?php echo $data['total_produk']; ?><br>Produk
                                        </p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="databarang.php">Lihat Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Line Chart Pemasukan
                                </div>
                                <?php
                                include "koneksi.php";

                                // Query untuk mengambil nilai bulan dari kolom TglPemesanan
                                $result = mysqli_query($koneksi, "SELECT MONTH(TglPemesanan) AS bulan, SUM(TPembayaran) AS total FROM pemesanan GROUP BY bulan;");

                                // Mengambil hasil query ke dalam array asosiatif
                                $data = [];
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $data[$row['bulan']] = $row['total'];
                                }

                                // Tambahkan data default untuk setiap bulan
                                for ($i = 1; $i <= 12; $i++) {
                                    $bulan = date('F', mktime(0, 0, 0, $i, 1));
                                    if (!isset($data[$i])) {
                                        $data[$i] = 0;
                                    }
                                }

                                // Sortir data berdasarkan bulan
                                ksort($data);

                                // Update array bulan dan total
                                $bulanArray = array_map(function ($bulan) {
                                    return date('F', mktime(0, 0, 0, $bulan, 1));
                                }, array_keys($data));

                                $totalArray = array_values($data);

                                // Inisialisasi array untuk menyimpan data bulan dan total
                                $bulanArray = array_map(function ($bulan) {
                                    return date('F', mktime(0, 0, 0, $bulan, 1));
                                }, array_keys($data));

                                // Memisahkan data bulan dan total menjadi dua array terpisah
                                $totalArray = array_values($data);
                                ?>
                                <canvas id="areachart" style="width:100%;max-width:600px"></canvas>
                                <script>
                                    var xValues = <?php echo json_encode($bulanArray); ?>;
                                    var yValues = <?php echo json_encode($totalArray); ?>;

                                    new Chart("areachart", {
                                        type: "line",
                                        data: {
                                            labels: xValues,
                                            datasets: [{
                                                fill: false,
                                                lineTension: 0,
                                                backgroundColor: "rgba(0,0,255,1.0)",
                                                borderColor: "rgba(0,0,255,0.1)",
                                                data: yValues
                                            }]
                                        },
                                        options: {
                                            legend: { display: false },
                                            scales: {
                                                yAxes: [{ ticks: { min: 6, max: 16 } }],
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
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

                                <canvas id="myChart1" style="width:100%;max-width:600px"></canvas>
                                <script>
                                    // Menggunakan data yang diambil dari database
                                    var xValues = <?php echo json_encode($bulanArray); ?>;
                                    var yValues = <?php echo json_encode($totalArray); ?>;
                                    var barColors = ["red", "green", "blue", "orange", "brown", "purple", "pink", "gray", "cyan", "magenta", "yellow", "lime"];

                                    new Chart("myChart1", {
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
                                            title: { display: true },
                                            layout: {
                                                padding: {
                                                    left: 20, // Jarak kiri
                                                    right: 20, // Jarak kanan
                                                    top: 0, // Jarak atas
                                                    bottom: 0 // Jarak bawah
                                                }
                                            }
                                        }
                                    });
                                </script>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>