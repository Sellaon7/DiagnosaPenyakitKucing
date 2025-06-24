<?php
session_start();
include 'koneksi.php';
include 'email_config.php'; // Include email configuration

use PHPMailer\PHPMailer\Exception;

if (isset($_POST['reset'])) {
    $username_or_email = $_POST['username_or_email'];

    try {
        // 1. Cari user berdasarkan username atau email. Pastikan kolom email ada.
        $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username_or_email, $username_or_email]);
        $user = $stmt->fetch();

        if ($user && !empty($user['email'])) { // Pastikan user ditemukan dan punya email
            // 2. Jika ditemukan:
            //    a. Generate token reset yang unik dan simpan di DB beserta expiry time.
            $reset_token = bin2hex(random_bytes(32)); // Generate a secure token
            $reset_token_expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token valid for 1 hour

            // Pastikan kolom reset_token dan reset_token_expiry ada di tabel users
            $stmt_update = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE id = ?");
            if ($stmt_update->execute([$reset_token, $reset_token_expiry, $user['id']])) {
                //    b. Kirim email ke user berisi link reset
                // Ganti 'localhost/jst-kucing' dengan URL aplikasi Anda yang sebenarnya
                $reset_link = "http://localhost/jst-kucing/reset_password.php?token=" . $reset_token;

                try {
                    $mail = createMailer(); // Dari email_config.php
                    $mail->addAddress($user['email'], $user['username']);

                    $mail->isHTML(true);
                    $mail->Subject = 'Reset Password Akun Diagnosa Kucing';
                    $mail->Body    = "Halo {$user['username']},<br><br>Anda menerima email ini karena ada permintaan reset password untuk akun Anda.<br>Klik link berikut untuk mereset password Anda:<br><a href='{$reset_link}'>{$reset_link}</a><br><br>Link ini akan kedaluwarsa dalam 1 jam.<br><br>Jika Anda tidak meminta reset password, abaikan email ini.";
                    $mail->AltBody = "Halo {$user['username']},\n\nAnda menerima email ini karena ada permintaan reset password untuk akun Anda.\nKunjungi link berikut untuk mereset password Anda:\n{$reset_link}\n\nLink ini akan kedaluwarsa dalam 1 jam.\n\nJika Anda tidak meminta reset password, abaikan email ini.";

                    $mail->send();
                    $_SESSION['forgot_password_message'] = "Jika akun dengan data tersebut ditemukan dan memiliki email terdaftar, instruksi reset password telah dikirim.";
                } catch (Exception $e) {
                    error_log("Mailer Error (Password Reset): " . $mail->ErrorInfo); // Log error for admin
                    $_SESSION['forgot_password_message'] = "Terjadi kesalahan saat mencoba mengirim email. Silakan coba lagi nanti atau hubungi admin."; // Pesan error generik
                }
            } else {
                $_SESSION['forgot_password_message'] = "Gagal memproses permintaan reset. Silakan coba lagi.";
            }
        } else {
            // 3. Jika tidak ditemukan atau tidak ada email, tetap tampilkan pesan generik
            $_SESSION['forgot_password_message'] = "Jika akun dengan data tersebut ditemukan dan memiliki email terdaftar, instruksi reset password telah dikirim.";
        }
    } catch (PDOException $e) {
        error_log("Database Error (Password Reset): " . $e->getMessage()); // Log error
        $_SESSION['forgot_password_message'] = "Terjadi kesalahan pada sistem. Silakan coba lagi nanti."; // Pesan error generik
    }

    header('Location: lupa_password.php');
    exit();
} else {
    header('Location: login.php'); // Redirect jika akses langsung
    exit();
}
