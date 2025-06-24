<?php
include 'koneksi.php';
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    // Pastikan kolom is_active ada di tabel users Anda
    // $stmt = $pdo->prepare('SELECT id, username, password, role_id, is_active FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // User ditemukan, cek password
        if (password_verify($password, $user['password'])) {
            // Password benar, cek apakah akun aktif
            // Pastikan kolom 'is_active' ada dan bernilai 1 untuk aktif
            if (isset($user['is_active']) && $user['is_active'] == 1) {
                // Akun aktif, login berhasil
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role_id'] = $user['role_id'];
                // Reset counter kegagalan jika login berhasil
                if (isset($_SESSION['login_failures'][$username])) {
                    unset($_SESSION['login_failures'][$username]);
                }
                // Hapus pesan sukses aktivasi jika ada
                unset($_SESSION['login_success_message']);
                header('Location: index.php'); // Redirect ke halaman utama setelah login
                exit(); // Pastikan script berhenti
            } else {
                // Akun belum aktif
                $_SESSION['login_error'] = 'Akun Anda belum aktif. Silakan cek email Anda untuk kode OTP verifikasi.';
                $_SESSION['login_error_type'] = 'inactive'; // Tandai error karena tidak aktif
                $_SESSION['login_attempt_username'] = $username;
                // Optional: Redirect ke halaman verifikasi jika ingin
                // $_SESSION['verification_user_email'] = $user['email']; // Pastikan kolom email ada
                // header('Location: verify_otp.php');
                // exit();
            }
            // Reset counter kegagalan jika login berhasil
            if (isset($_SESSION['login_failures'][$username])) {
                unset($_SESSION['login_failures'][$username]);
            }
            header('Location: index.php'); // Redirect ke halaman utama setelah login
        } else {
            // Password salah
            $_SESSION['login_error'] = 'Password salah.';
            $_SESSION['login_error_type'] = 'password'; // Tandai error pada password
            $_SESSION['login_attempt_username'] = $username; // Simpan username yang dicoba
            // Tambah counter kegagalan
            $_SESSION['login_failures'][$username] = ($_SESSION['login_failures'][$username] ?? 0) + 1;
            header('Location: login.php');
            exit(); // Pastikan script berhenti
        }
    } else {
        // User tidak ditemukan
        $_SESSION['login_error'] = 'Username tidak ditemukan.';
        $_SESSION['login_error_type'] = 'username'; // Tandai error pada username
        $_SESSION['login_attempt_username'] = $username; // Simpan username yang dicoba
        // Opsional: Reset counter jika username tidak ditemukan, agar tidak terkunci selamanya jika salah ketik username
        // unset($_SESSION['login_failures'][$username]);
        header('Location: login.php');
        exit(); // Pastikan script berhenti setelah redirect
    }
}
