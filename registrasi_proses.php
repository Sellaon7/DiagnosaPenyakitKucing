<?php
include 'koneksi.php';
// include 'email_config.php'; // Include the email configuration
session_start(); // Mulai session

// use PHPMailer\PHPMailer\Exception;

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); // Sanitize and trim email
    $password_plain = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role_id = 2; // Automatically assign Role ID 2 (User)

    // Server-side validation: Check if passwords match
    if ($password_plain !== $confirm_password) {
        $_SESSION['register_error'] = 'Password dan konfirmasi password tidak cocok.';
        $_SESSION['register_error_field'] = 'password'; // Tandai error pada password
        $_SESSION['register_attempt_username'] = $username; // Simpan username
        $_SESSION['register_attempt_email'] = $email; // Simpan email
        header('Location: register.php');
        exit();
    }

    // Server-side validation: Check email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = 'Format email tidak valid.';
        $_SESSION['register_error_field'] = 'email'; // Tandai error pada email
        $_SESSION['register_attempt_username'] = $username;
        $_SESSION['register_attempt_email'] = $email;
        header('Location: register.php');
        exit();
    }

    $password_hashed = password_hash($password_plain, PASSWORD_BCRYPT);

    // Periksa apakah username atau email sudah ada
    $stmt_check = $pdo->prepare("SELECT id, username, email FROM users WHERE username = ? OR email = ?");
    $stmt_check->execute([$username, $email]);
    $existing_user = $stmt_check->fetch();

    if ($existing_user) {
        // Cek apakah username atau email yang duplikat
        if (strtolower($existing_user['username']) === strtolower($username)) {
            $_SESSION['register_error'] = 'Username sudah digunakan.';
            $_SESSION['register_error_field'] = 'username';
        } else {
            $_SESSION['register_error'] = 'Email sudah terdaftar.';
            $_SESSION['register_error_field'] = 'email';
        }
        $_SESSION['register_attempt_username'] = $username;
        $_SESSION['register_attempt_email'] = $email;
        header('Location: register.php');
        exit();
    } else {
        // Set is_active = 1, hapus kolom otp_code dan otp_expiry
        $stmt_insert = $pdo->prepare("INSERT INTO users (username, email, password, role_id, is_active) VALUES (?, ?, ?, ?, 1)");

        if ($stmt_insert->execute([$username, $email, $password_hashed, $role_id])) {
            // Pendaftaran berhasil, set pesan sukses dan arahkan ke halaman login
            // Gunakan key session yang sama dengan yang dicek di login.php
            $_SESSION['login_success_message'] = 'Registrasi berhasil! Silakan masuk dengan akun Anda.';
            header('Location: login.php');
            exit(); // Pastikan tidak ada output lain setelah header
        } else {
            // Jika insert gagal
            $_SESSION['register_error'] = 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.';
            $_SESSION['register_error_field'] = 'general'; // Error umum
            $_SESSION['register_attempt_username'] = $username; // Simpan username
            $_SESSION['register_attempt_email'] = $email; // Simpan email
            header('Location: register.php');
            exit();
        }
    }
}
