<?php
session_start();
// Jika ada pesan dari proses sebelumnya (misal, link terkirim)
$message = null;
if (isset($_SESSION['forgot_password_message'])) {
    $message = $_SESSION['forgot_password_message'];
    unset($_SESSION['forgot_password_message']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>JST - Lupa Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body style="background: url(assets/img/kucing1.jpeg) ">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <br>
                <h3 class="fa fa-solid fa-cat"> DIAGNOSA PENYAKIT KUCING</h3>
            </div>
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="card o-hidden border-0 shadow-lg my-5 col-lg-5 mx-auto bg-light ">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Lupa Password</h1>
                                    <p class="mb-4">Masukkan username atau email Anda. Kami akan mengirimkan instruksi untuk mereset password Anda.</p>
                                </div>

                                <?php if ($message): ?>
                                    <div class="alert alert-info text-center"><?php echo htmlspecialchars($message); ?></div>
                                <?php endif; ?>

                                <form class="user" method="post" action="proses_lupa_password.php">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="username_or_email" id="usernameOrEmail" placeholder="Username atau Email" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" name="reset">
                                        Kirim Instruksi Reset
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="register.php">Buat Akun Baru!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="login.php">Sudah ingat? Masuk!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS includes -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>