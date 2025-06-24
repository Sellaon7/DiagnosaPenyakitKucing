<?php
session_start(); // Mulai session di paling atas
$register_error = null;
if (isset($_SESSION['register_error'])) {
    $register_error = $_SESSION['register_error'];
    unset($_SESSION['register_error']);
}
$register_error_field = null;
if (isset($_SESSION['register_error_field'])) {
    $register_error_field = $_SESSION['register_error_field'];
    unset($_SESSION['register_error_field']);
}
$register_attempt_username = '';
if (isset($_SESSION['register_attempt_username'])) {
    $register_attempt_username = $_SESSION['register_attempt_username'];
    unset($_SESSION['register_attempt_username']);
}
$register_attempt_email = '';
if (isset($_SESSION['register_attempt_email'])) {
    $register_attempt_email = $_SESSION['register_attempt_email'];
    unset($_SESSION['register_attempt_email']);
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

    <title>JST - Daftar Akun</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .mySlides {
            display: none;
        }

        /* Style for password visibility toggle */
        .password-container {
            position: relative;
        }

        /* Container baru hanya untuk input + icon (jika diperlukan, tapi kita pakai dari login) */
        .input-icon-wrapper {
            position: relative;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 100;
            /* Pastikan ikon di atas ikon validasi Bootstrap */
            cursor: pointer;
        }

        /* Hilangkan ikon validasi bawaan Bootstrap untuk input password */
        .password-container .form-control.is-invalid {
            background-image: none !important;
        }

        /* Style untuk daftar kriteria password (dari login.php) */
        #passwordCriteria {
            font-size: 0.8rem;
            margin-top: 5px;
            padding-left: 20px;
            /* Sedikit indentasi */
            display: none;
            /* Sembunyikan awalnya */
        }

        #passwordCriteria ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #passwordCriteria li {
            color: #858796;
            /* Warna default (abu-abu) */
            transition: color 0.3s ease;
        }

        #passwordCriteria li.met {
            color: #1cc88a;
            /* Warna hijau jika terpenuhi */
        }

        #passwordCriteria li.met::before,
        #passwordCriteria li:not(.met)::before {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            margin-right: 5px;
        }

        #passwordCriteria li.met::before {
            content: "\f00c";
            /* check */
        }

        #passwordCriteria li:not(.met)::before {
            content: "\f00d";
            /* times */
        }
    </style>
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
            <div class="card o-hidden border-0 shadow-lg my-5 col-lg-4 mx-auto bg-light">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Daftar Akun</h1>
                                </div>
                                <br><br>
                                <form class="user" method="post" action="registrasi_proses.php">
                                    <!-- <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Name">
                                    </div> -->
                                    <div class="form-group">
                                        <?php $username_class = ($register_error_field === 'username') ? 'is-invalid' : ''; ?>
                                        <input type="text" class="form-control form-control-user <?php echo $username_class; ?>" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($register_attempt_username); ?>" required>
                                        <!-- Tambahkan div untuk feedback AJAX -->
                                        <div id="usernameValidFeedback" class="valid-feedback"></div>
                                        <div id="usernameInvalidFeedback" class="invalid-feedback">
                                            <?php if ($register_error_field === 'username') echo htmlspecialchars($register_error); /* Tampilkan error server-side jika ada */ ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?php $email_class = ($register_error_field === 'email') ? 'is-invalid' : ''; ?>
                                        <input type="email" class="form-control form-control-user <?php echo $email_class; ?>" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($register_attempt_email); ?>" required>
                                        <!-- Add valid feedback div and specific ID for invalid feedback -->
                                        <div id="emailValidFeedback" class="valid-feedback"></div>
                                        <div id="emailInvalidFeedback" class="invalid-feedback">
                                            <?php if ($register_error_field === 'email') echo htmlspecialchars($register_error); /* Server-side error */ ?></div>
                                    </div>
                                    <div class="form-group password-container">
                                        <div class="input-icon-wrapper"> <!-- Wrapper untuk input dan icon -->
                                            <?php $password_class = ($register_error_field === 'password') ? 'is-invalid' : ''; ?>
                                            <input type="password" class="form-control form-control-user <?php echo $password_class; ?>" id="InputPassword" name="password" placeholder="Password" required>
                                            <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                                        </div>
                                        <!-- Daftar Kriteria Password -->
                                        <div id="passwordCriteria">
                                            <ul>
                                                <li id="length">Minimal 8 karakter</li>
                                                <li id="lowercase">Setidaknya satu huruf kecil</li>
                                                <li id="uppercase">Setidaknya satu huruf besar</li>
                                                <li id="number">Setidaknya satu angka</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group password-container">
                                        <div class="input-icon-wrapper"> <!-- Wrapper untuk input dan icon -->
                                            <?php $confirm_password_class = ($register_error_field === 'password') ? 'is-invalid' : ''; ?>
                                            <input type="password" class="form-control form-control-user <?php echo $confirm_password_class; ?>" id="ConfirmPassword" name="confirm_password" placeholder="Ulangi Password" required>
                                            <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"></i>
                                        </div>
                                        <!-- Feedback untuk konfirmasi password -->
                                        <div id="confirmPasswordValidFeedback" class="valid-feedback">Password cocok.</div>
                                        <div id="confirmPasswordInvalidFeedback" class="invalid-feedback">
                                            <?php if ($register_error_field === 'password' && $register_error !== 'Username sudah digunakan.') echo htmlspecialchars($register_error); /* Tampilkan error server-side jika ada & relevan */ ?>
                                        </div>
                                        <?php if ($register_error && $register_error_field !== 'password' && $register_error_field !== 'username'): /* Tampilkan error umum di sini */ ?>
                                            <div class="invalid-feedback d-block text-center mt-2">
                                                <?php echo htmlspecialchars($register_error); /* Hanya tampilkan error umum atau yang tidak terkait field */ ?>
                                            </div>
                                        <?php elseif ($register_error_field === 'general'): ?>
                                            <div class="alert alert-danger text-center mt-2"><?php echo htmlspecialchars($register_error); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Role ID input removed -->
                                    <!-- <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" id="InputPassword" name="password" placeholder="Password">
                                        </div> -->
                                    <br><br>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" name="register"> Daftar</button>
                                    </a>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="login.php">Sudah punya akun? Masuk!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        // Password Visibility Toggle
        function setupPasswordToggle(inputId, toggleId) {
            const passwordInput = document.getElementById(inputId);
            const togglePassword = document.getElementById(toggleId);

            if (passwordInput && togglePassword) {
                togglePassword.addEventListener('click', function(e) {
                    // toggle the type attribute
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    // toggle the eye / eye-slash icon
                    this.classList.toggle('fa-eye-slash');
                });
            }
        }

        setupPasswordToggle('InputPassword', 'togglePassword');
        setupPasswordToggle('ConfirmPassword', 'toggleConfirmPassword');

        // Client-side password confirmation check (optional but good UX)
        const form = document.querySelector('.user');
        const password = document.getElementById('InputPassword');
        const confirmPassword = document.getElementById('ConfirmPassword');

        // Hapus alert bawaan, kita akan pakai validasi real-time + server-side
        /*
        form.addEventListener('submit', function(e) {
            if (password.value !== confirmPassword.value) {
                alert("Password dan konfirmasi password tidak cocok!");
                e.preventDefault(); // Prevent form submission
            }
        });
        */
        const confirmPasswordValidFeedback = document.getElementById('confirmPasswordValidFeedback');
        const confirmPasswordInvalidFeedback = document.getElementById('confirmPasswordInvalidFeedback');

        // --- AJAX Username Check ---
        const usernameInput = document.getElementById('username');
        const usernameValidFeedback = document.getElementById('usernameValidFeedback');
        const usernameInvalidFeedback = document.getElementById('usernameInvalidFeedback');
        let debounceTimeoutUsername;

        usernameInput.addEventListener('input', function() {
            clearTimeout(debounceTimeoutUsername);
            const username = this.value.trim();

            // Hapus status validasi sebelumnya & pesan
            usernameInput.classList.remove('is-valid', 'is-invalid');
            usernameValidFeedback.textContent = '';
            // Jangan hapus pesan error server-side awal, tapi siapkan untuk ditimpa
            // usernameInvalidFeedback.textContent = '';

            if (username === '') {
                // Jika input kosong, hapus pesan invalid jika bukan dari server
                if (usernameInvalidFeedback.textContent !== '<?php echo ($register_error_field === 'username') ? htmlspecialchars($register_error) : ''; ?>') {
                    usernameInvalidFeedback.textContent = '';
                }
                return; // Jangan cek string kosong
            }

            debounceTimeoutUsername = setTimeout(() => {
                fetch(`check_username.php?username=${encodeURIComponent(username)}`)
                    .then(response => response.ok ? response.json() : Promise.reject('Network error'))
                    .then(data => {
                        usernameInput.classList.remove('is-valid', 'is-invalid'); // Hapus lagi untuk state bersih
                        if (data.exists) {
                            usernameInput.classList.add('is-invalid');
                            usernameInvalidFeedback.textContent = data.message || 'Username sudah digunakan.';
                            usernameValidFeedback.textContent = ''; // Pastikan valid feedback kosong
                        } else {
                            usernameInput.classList.add('is-valid');
                            usernameValidFeedback.textContent = data.message || 'Username tersedia.';
                            usernameInvalidFeedback.textContent = ''; // Pastikan invalid feedback kosong
                        }
                    })
                    .catch(error => {
                        console.error('Error checking username:', error);
                        // Bisa tambahkan feedback error AJAX jika diperlukan
                    });
            }, 400); // Tunggu 400ms setelah user berhenti mengetik
        });

        // --- AJAX Email Check ---
        const emailInput = document.getElementById('email');
        const emailValidFeedback = document.getElementById('emailValidFeedback');
        const emailInvalidFeedback = document.getElementById('emailInvalidFeedback');
        let debounceTimeoutEmail;

        emailInput.addEventListener('input', function() {
            clearTimeout(debounceTimeoutEmail);
            const email = this.value.trim();

            // Reset validation state and messages from AJAX
            emailInput.classList.remove('is-valid', 'is-invalid');
            emailValidFeedback.textContent = '';
            // Keep server-side error initially, clear only if AJAX will provide feedback
            // emailInvalidFeedback.textContent = ''; // Don't clear server error yet

            if (email === '') {
                // If input is cleared, remove AJAX messages but keep potential server error
                if (emailInvalidFeedback.textContent !== '<?php echo ($register_error_field === 'email') ? htmlspecialchars($register_error) : ''; ?>') {
                    emailInvalidFeedback.textContent = '';
                }
                return; // Don't check empty string
            }

            debounceTimeoutEmail = setTimeout(() => {
                fetch(`check_email.php?email=${encodeURIComponent(email)}`)
                    .then(response => response.ok ? response.json() : Promise.reject('Network error'))
                    .then(data => {
                        emailInput.classList.remove('is-valid', 'is-invalid'); // Reset again before applying new state
                        if (!data.validFormat) {
                            emailInput.classList.add('is-invalid');
                            emailInvalidFeedback.textContent = data.message || 'Format email tidak valid.';
                        } else if (data.exists) {
                            emailInput.classList.add('is-invalid');
                            emailInvalidFeedback.textContent = data.message || 'Email sudah terdaftar.';
                        } else {
                            emailInput.classList.add('is-valid');
                            emailValidFeedback.textContent = data.message || 'Email tersedia.'; // Show success message
                        }
                    })
                    .catch(error => console.error('Error checking email:', error));
            }, 500); // Wait 500ms after user stops typing
        });

        // --- Real-time Password Criteria Check (Register) ---
        const passwordInputRegister = document.getElementById('InputPassword'); // Target input password pertama
        const criteriaDivRegister = document.getElementById('passwordCriteria');
        const lengthCheckRegister = document.getElementById('length');
        const lowerCheckRegister = document.getElementById('lowercase');
        const upperCheckRegister = document.getElementById('uppercase');
        const numberCheckRegister = document.getElementById('number');

        // Tampilkan kriteria saat input password mendapat fokus
        passwordInputRegister.addEventListener('focus', function() {
            criteriaDivRegister.style.display = 'block';
        });

        // Validasi saat mengetik
        passwordInputRegister.addEventListener('input', function() {
            const passwordValue = this.value;

            // Cek Panjang
            passwordValue.length >= 8 ? lengthCheckRegister.classList.add('met') : lengthCheckRegister.classList.remove('met');

            // Cek Huruf Kecil
            /[a-z]/.test(passwordValue) ? lowerCheckRegister.classList.add('met') : lowerCheckRegister.classList.remove('met');

            // Cek Huruf Besar
            /[A-Z]/.test(passwordValue) ? upperCheckRegister.classList.add('met') : upperCheckRegister.classList.remove('met');

            // Cek Angka
            /[0-9]/.test(passwordValue) ? numberCheckRegister.classList.add('met') : numberCheckRegister.classList.remove('met');

            // Selalu tampilkan jika ada isinya atau fokus
            criteriaDivRegister.style.display = 'block';
        });

        // Opsional: Sembunyikan jika input kosong dan kehilangan fokus
        // passwordInputRegister.addEventListener('blur', function() {
        //  if (this.value === '') criteriaDivRegister.style.display = 'none';
        // });

        // --- Real-time Confirm Password Check ---
        function validateConfirmPassword() {
            const passwordValue = password.value;
            const confirmPasswordValue = confirmPassword.value;

            // Hapus status validasi sebelumnya
            confirmPassword.classList.remove('is-valid', 'is-invalid');
            // Jangan hapus pesan error server-side awal
            // confirmPasswordInvalidFeedback.textContent = '';

            if (confirmPasswordValue === '') {
                if (confirmPasswordInvalidFeedback.textContent !== '<?php echo ($register_error_field === 'password' && $register_error !== 'Username sudah digunakan.') ? htmlspecialchars($register_error) : ''; ?>') {
                    confirmPasswordInvalidFeedback.textContent = '';
                }
                return; // Jangan validasi jika kosong
            }

            if (passwordValue === confirmPasswordValue) {
                confirmPassword.classList.add('is-valid');
            } else {
                confirmPassword.classList.add('is-invalid');
                confirmPasswordInvalidFeedback.textContent = 'Password tidak cocok.'; // Pesan real-time
            }
        }
        // Jalankan validasi saat mengetik di salah satu input password
        password.addEventListener('input', validateConfirmPassword);
        confirmPassword.addEventListener('input', validateConfirmPassword);
    </script>
</body>

</html>