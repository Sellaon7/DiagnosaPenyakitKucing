<?php
session_start(); // Mulai session di paling atas
$login_error = null; // Inisialisasi variabel error
if (isset($_SESSION['login_error'])) {
	$login_error = $_SESSION['login_error'];
	unset($_SESSION['login_error']); // Hapus error dari session setelah dibaca
}
// Ambil tipe error jika ada
$login_error_type = null;
if (isset($_SESSION['login_error_type'])) {
	$login_error_type = $_SESSION['login_error_type'];
	unset($_SESSION['login_error_type']);
}
// Ambil username yang dicoba jika ada
$login_attempt_username = '';
if (isset($_SESSION['login_attempt_username'])) {
	$login_attempt_username = $_SESSION['login_attempt_username'];
	unset($_SESSION['login_attempt_username']); // Hapus username dari session setelah dibaca
}
// Cek jumlah kegagalan login untuk username terakhir
$failure_count = 0;
$show_forgot_password = false;
if (!empty($login_attempt_username) && isset($_SESSION['login_failures'][$login_attempt_username])) {
	$failure_count = $_SESSION['login_failures'][$login_attempt_username];
}

// Check for success message from activation
$login_success_message = null;
if (isset($_SESSION['login_success_message'])) {
	$login_success_message = $_SESSION['login_success_message'];
	unset($_SESSION['login_success_message']);
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

	<title>JST - Masuk</title>

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

		/* Container baru hanya untuk input + icon */
		.input-icon-wrapper {
			position: relative;
		}

		.input-icon-wrapper .toggle-password {
			position: absolute;
			right: 15px;
			top: 50%;
			/* Sekarang relatif terhadap tinggi input-icon-wrapper */
			transform: translateY(-50%);
			z-index: 100;
			/* Pastikan ikon di atas elemen lain (misal ikon validasi Bootstrap) */
			cursor: pointer;
		}

		/* Hilangkan ikon validasi bawaan Bootstrap HANYA untuk input di dalam wrapper ini */
		.input-icon-wrapper .form-control.is-invalid,
		.input-icon-wrapper .form-control.is-valid {
			background-image: none !important;
		}

		/* Style untuk daftar kriteria password */
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

		#passwordCriteria li.met::before {
			content: "\f00c";
			/* Font Awesome check icon */
			font-family: "Font Awesome 5 Free";
			font-weight: 900;
			margin-right: 5px;
		}

		#passwordCriteria li:not(.met)::before {
			content: "\f00d";
			/* Font Awesome times icon */
			font-family: "Font Awesome 5 Free";
			font-weight: 900;
			margin-right: 5px;
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
			<!-- <div class="col-xl-4 col-lg-12 col-md-9" > -->
			<div class="card o-hidden border-0 shadow-lg my-5 col-lg-4 mx-auto bg-light ">
				<div class="card-body p-0">
					<div class="row">
						<div class="col-lg">
							<div class="p-5">
								<div class="text-center">
									<h1 class="h4 text-gray-900 mb-4">Silahkan Masuk!!</h1>
								</div>

								<?php if ($login_success_message): ?>
									<div class="alert alert-success text-center"><?php echo htmlspecialchars($login_success_message); ?></div>
								<?php endif; ?>

								<br><br>
								<form class="user" method="post" action="login_proses.php">
									<div class="form-group">
										<?php
										// Tentukan class untuk input username
										$username_class = '';
										if ($login_error_type === 'password') {
											$username_class = 'is-valid'; // Hijau jika password salah
										} elseif ($login_error_type === 'username') {
											$username_class = 'is-invalid'; // Merah jika username salah
										}
										?>
										<input type="text" class="form-control form-control-user <?php echo $username_class; ?>" name="username" id="InputUsername1" placeholder="Username" value="<?php echo htmlspecialchars($login_attempt_username); ?>" required>
										<!-- Tambahkan div untuk feedback AJAX username -->
										<div id="usernameLoginValidFeedback" class="valid-feedback"></div>
										<div id="usernameLoginInvalidFeedback" class="invalid-feedback">
											<?php if ($login_error_type === 'username') echo htmlspecialchars($login_error); /* Tampilkan error server-side jika ada */ ?>
										</div>
									</div>
									<div class="form-group password-container">
										<div class="input-icon-wrapper"> <!-- Wrapper baru -->
											<?php // Password selalu invalid jika ada error login
											$password_class = ($login_error) ? 'is-invalid' : ''; ?>
											<input type="password" class="form-control form-control-user <?php echo $password_class; ?>" name="password" id="InputPassword1" placeholder="Password" required>
											<i class="fas fa-eye toggle-password" id="togglePasswordLogin"></i>
										</div>
										<!-- Daftar Kriteria Password (dipindahkan ke luar wrapper) -->
										<!-- <div id="passwordCriteria">
											<ul>
												<li id="length">Minimal 8 karakter</li>
												<li id="lowercase">Setidaknya satu huruf kecil</li>
												<li id="uppercase">Setidaknya satu huruf besar</li>
												<li id="number">Setidaknya satu angka</li>
											</ul>
										</div> -->
										<?php if ($login_error && $login_error_type === 'password'): /* Tampilkan error password di sini */ ?>
											<div class="invalid-feedback d-block text-center mt-2"> <!-- Paksa tampilkan pesan error -->
												<?php echo htmlspecialchars($login_error); ?>
											</div>
										<?php endif; ?>
										<?php if ($login_error && $login_error_type === 'inactive'): /* Tampilkan error akun tidak aktif */ ?>
											<div class="invalid-feedback d-block text-center mt-2">
												<?php echo htmlspecialchars($login_error); ?>
												<!-- Optional link to verification page -->
												<!-- <br><a href="verify_otp.php">Masukkan Kode OTP</a> -->
											</div>
										<?php endif; ?>
									</div>
									<br><br>
									<button type="submit" class="btn btn-primary btn-user btn-block" name="login">Masuk</button>
									<div class="text-center">
										<?php if ($failure_count >= 5): ?>
											<a class="small d-block mt-2" href="lupa_password.php">Lupa Password?</a>
										<?php endif; ?>
										<hr>
										<a class="small" href="register.php">Buat Akun!</a>
									</div>
								</form>
								<hr>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->

	<!-- Bootstrap core JavaScript-->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="js/sb-admin-2.min.js"></script>

	<script>
		// Password Visibility Toggle Function
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

		// Apply toggle to the login password field
		setupPasswordToggle('InputPassword1', 'togglePasswordLogin');

		// --- Real-time Password Criteria Check ---
		const passwordInputLogin = document.getElementById('InputPassword1');
		const criteriaDiv = document.getElementById('passwordCriteria');
		const lengthCheck = document.getElementById('length');
		const lowerCheck = document.getElementById('lowercase');
		const upperCheck = document.getElementById('uppercase');
		const numberCheck = document.getElementById('number');

		// Tampilkan kriteria saat input password mendapat fokus
		passwordInputLogin.addEventListener('focus', function() {
			criteriaDiv.style.display = 'block';
		});

		// Sembunyikan kriteria saat input password kehilangan fokus (jika kosong)
		// passwordInputLogin.addEventListener('blur', function() {
		// 	if (this.value === '') {
		// 		criteriaDiv.style.display = 'none';
		// 	}
		// });

		passwordInputLogin.addEventListener('input', function() {
			const password = this.value;

			// Cek Panjang
			password.length >= 8 ? lengthCheck.classList.add('met') : lengthCheck.classList.remove('met');

			// Cek Huruf Kecil
			/[a-z]/.test(password) ? lowerCheck.classList.add('met') : lowerCheck.classList.remove('met');

			// Cek Huruf Besar
			/[A-Z]/.test(password) ? upperCheck.classList.add('met') : upperCheck.classList.remove('met');

			// Cek Angka
			/[0-9]/.test(password) ? numberCheck.classList.add('met') : numberCheck.classList.remove('met');

			// Selalu tampilkan jika ada isinya
			criteriaDiv.style.display = 'block';

		});

		// --- AJAX Username Check (Login) ---
		const usernameInputLogin = document.getElementById('InputUsername1');
		const usernameLoginValidFeedback = document.getElementById('usernameLoginValidFeedback');
		const usernameLoginInvalidFeedback = document.getElementById('usernameLoginInvalidFeedback');
		let debounceTimeoutUsernameLogin;

		usernameInputLogin.addEventListener('input', function() {
			clearTimeout(debounceTimeoutUsernameLogin);
			const username = this.value.trim();

			// Hapus status validasi sebelumnya & pesan AJAX
			usernameInputLogin.classList.remove('is-valid', 'is-invalid');
			usernameLoginValidFeedback.textContent = '';
			// Jangan hapus pesan error server-side awal, tapi siapkan untuk ditimpa
			// usernameLoginInvalidFeedback.textContent = '';

			if (username === '') {
				// Jika input kosong, hapus pesan invalid jika bukan dari server
				if (usernameLoginInvalidFeedback.textContent !== '<?php echo ($login_error_type === 'username') ? htmlspecialchars($login_error) : ''; ?>') {
					usernameLoginInvalidFeedback.textContent = '';
				}
				return; // Jangan cek string kosong
			}

			debounceTimeoutUsernameLogin = setTimeout(() => {
				fetch(`check_username.php?username=${encodeURIComponent(username)}`)
					.then(response => response.ok ? response.json() : Promise.reject('Network error'))
					.then(data => {
						usernameInputLogin.classList.remove('is-valid', 'is-invalid'); // Hapus lagi untuk state bersih
						if (data.exists) {
							// Username ditemukan (ini yang diharapkan saat login)
							usernameInputLogin.classList.add('is-valid');
							// usernameLoginValidFeedback.textContent = 'Username ditemukan.'; // Opsional
							usernameLoginInvalidFeedback.textContent = ''; // Pastikan invalid feedback kosong
						} else {
							// Username TIDAK ditemukan
							usernameInputLogin.classList.add('is-invalid');
							usernameLoginInvalidFeedback.textContent = 'Username tidak ditemukan.';
							usernameLoginValidFeedback.textContent = ''; // Pastikan valid feedback kosong
						}
					})
					.catch(error => console.error('Error checking username:', error));
			}, 400); // Tunggu 400ms setelah user berhenti mengetik
		});
	</script>
</body>

</html>