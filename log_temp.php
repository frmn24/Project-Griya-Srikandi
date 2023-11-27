<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "griya4");
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
                header('Location: log_temp.php');
            }
        } else {
            $error = 'user tidak ditemukan';
            header('Location: log_temp.php');
        }
    } else {
        $error = 'data tidak boleh kosong';
        header('Location: log_temp.php');
    }
}
?>


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

<body>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="row g-0">
                                    <div class="col-md-5">
                                        <img src="gambar/bg_login.png" class="test_gambar" alt="">
                                    </div>
                                    <div class="col-md-7" style="margin-top: 50px;">
                                        <h3 class="text-center font-weight-light my-4" style="text-align:center;">WELCOME</h3>
                                        <div class="card-body">
                                            <form class="user" action="login.php" method="post" style="margin-right:30px; margin-top: 50px;">
                                                <div class="form-group">
                                                    <input type="email" name="email" class="form-control form-control-user" id="inputEmail" aria-describedby="emailHelp" placeholder="Masukkan Alamat Email...">
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" name="password" class="form-control form-control-user" id="inputPassword" placeholder="Masukan Kata Sandi..">
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox small">
                                                        <input type="checkbox" class="custom-control-input" id="inputRememberPassword" style="margin-left:20px;">
                                                        <label class="custom-control-label" for="customCheck" style="margin-left:3px;">Ingat saya</label>
                                                        <!-- <a class="small" href="password.php" style="margin-left: 200px;">Lupa Kata Sandi?</a> -->
                                                    </div>
                                                </div>
                                                <input type="submit" name="login" class="btn btn-primary btn-user btn-block" value="Masuk">
                                            </form>
                                        </div>
                                    </div>
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
        window.addEventListener("load", function() {
            if (localStorage.getItem("rememberEmail")) {
                document.querySelector('input[name="email"]').value = localStorage.getItem("rememberEmail");
                document.getElementById("inputRememberPassword").checked = true;
            }
            if (localStorage.getItem("rememberPassword")) {
                document.querySelector('input[name="password"]').value = localStorage.getItem("rememberPassword");
            }
        });

        // Simpan email dan password pengguna saat login jika "Remember Me" dicentang
        document.querySelector('form').addEventListener("submit", function(e) {
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>