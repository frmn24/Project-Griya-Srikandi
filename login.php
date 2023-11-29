<?php
session_start();
$koneksi = mysqli_connect("griya-srikandi.tifa.myhost.id", "tifamyho_srikandi", "JTIpolije2023", "tifamyho_srikandi");
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if (!empty(trim($email)) && !empty(trim($pass))) {
        $query = "SELECT * FROM admin_detail WHERE user_email = '$email'";
        $result = mysqli_query($koneksi, $query);
        $num = mysqli_num_rows($result);

        if ($num != 0) {
            $row = mysqli_fetch_array($result);
            $userVal = $row['user_email'];
            $passVal = $row['user_password'];
            $userName = $row['user_fullname'];

            if ($userVal == $email && $passVal == $pass) {
                // Masukkan user ke dalam sesi
                $_SESSION['user_email'] = $userVal;
                $_SESSION['user_fullname'] = $userName;
                // Anda dapat menambahkan variabel sesi lainnya sesuai kebutuhan

                header('Location: index.php?user_fullname=' . urlencode($userName));
            } else {
                $error = 'user atau password salah';
                header('Location: login.php');
            }
        } else {
            $error = 'user tidak ditemukan';
            header('Location: login.php');
        }
    } else {
        $error = 'data tidak boleh kosong';
        header('Location: login.php');
    }
}
?>
<!-- tes -->

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="login.php">
                                        <!-- Form action untuk mengirim data ke halaman "login.php" -->
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" name="email"
                                                placeholder="name@example.com" /> <!-- Menambahkan name="email" -->
                                            <label for="inputEmail">Masukkan Alamat Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password"
                                                name="password" placeholder="Password" />
                                            <!-- Menambahkan name="password" -->
                                            <label for="inputPassword">Masukkan Kata Sandi</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                                                value="" />
                                            <label class="form-check-label" for="inputRememberPassword">Ingat
                                                Saya</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.php">Lupa Kata Sandi?</a>
                                            <button class="btn btn-primary" type="submit" name="login">Login</button>
                                            <!-- Menggunakan button "Login" -->
                                        </div>
                                    </form>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                </div>
        </div>
        </footer>
    </div>
    </div>
    <script>
        // Cek apakah ada data login sebelumnya yang perlu di-remember
        window.addEventListener("load", function () {
            if (localStorage.getItem("rememberEmail")) {
                document.querySelector('input[name="email"]').value = localStorage.getItem("rememberEmail");
                document.getElementById("inputRememberPassword").checked = true;
            }
            if (localStorage.getItem("rememberPassword")) {
                document.querySelector('input[name="password"]').value = localStorage.getItem("rememberPassword");
            }
        });

        // Simpan email dan password pengguna saat login jika "Remember Me" dicentang
        document.querySelector('form').addEventListener("submit", function (e) {
            if (document.getElementById("inputRememberPassword").checked) {
                var email = document.querySelector('input[name="email"]').value;
                var password = document.querySelector('input[name="password"]').value;
                localStorage.setItem("rememberEmail", email);
                localStorage.setItem("rememberPassword", password);
            } else {
                localStorage.removeItem("rememberEmail");
                localStorage.removeItem("rememberPassword");
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
