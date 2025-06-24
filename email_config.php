<?php

// Pastikan path ke autoload.php benar. Sesuaikan jika struktur folder berbeda.
// Biasanya ada di dalam folder 'vendor' jika kamu menggunakan Composer.
require __DIR__ . '/vendor/autoload.php'; // Menggunakan __DIR__ untuk path relatif yang aman

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Membuat dan mengkonfigurasi instance PHPMailer.
 *
 * @return PHPMailer Instance PHPMailer yang sudah dikonfigurasi.
 * @throws Exception Jika terjadi error saat konfigurasi.
 */
function createMailer(): PHPMailer
{
    $mail = new PHPMailer(true); // Passing `true` enables exceptions

    try {
        // Pengaturan Server SMTP
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Aktifkan untuk debugging detail (jangan gunakan di produksi)
        $mail->SMTPDebug = SMTP::DEBUG_OFF;    // Matikan output debug di produksi
        $mail->isSMTP();                       // Menggunakan SMTP
        $mail->Host       = 'smtp.example.com'; // GANTI: Alamat server SMTP (misal: smtp.gmail.com, smtp.mailtrap.io)
        $mail->SMTPAuth   = true;              // Aktifkan otentikasi SMTP
        $mail->Username   = 'nama_pengguna@example.com'; // GANTI: Username SMTP (biasanya email Anda)
        $mail->Password   = 'password_rahasia_anda'; // GANTI: Password SMTP (jika Gmail & 2FA aktif, gunakan App Password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Aktifkan enkripsi TLS; `PHPMailer::ENCRYPTION_SMTPS` (SSL) juga opsi lain
        $mail->Port       = 587;               // GANTI: Port TCP untuk koneksi (587 untuk TLS, 465 untuk SSL)

        // Pengaturan Pengirim dan Penerima Default (bisa di-override nanti)
        // GANTI 'email_pengirim@example.com' dengan email yang akan muncul sebagai pengirim
        // GANTI 'Nama Aplikasi Anda' dengan nama yang ingin ditampilkan sebagai pengirim
        // Seringkali, email pengirim harus sama dengan $mail->Username
        $mail->setFrom('email_pengirim@example.com', 'Nama Aplikasi Anda');
        // $mail->addReplyTo('info@example.com', 'Information'); // Opsional: Alamat balasan
        // $mail->addCC('cc@example.com'); // Opsional: Tambahkan CC
        // $mail->addBCC('bcc@example.com'); // Opsional: Tambahkan BCC

        // Pengaturan Konten
        $mail->isHTML(true); // Atur format email ke HTML
        $mail->CharSet = 'UTF-8'; // Set karakter encoding

        return $mail;
    } catch (Exception $e) {
        // Jika terjadi error saat konfigurasi awal (jarang terjadi, tapi mungkin)
        // Log error ini atau tangani sesuai kebutuhan aplikasi Anda
        error_log("Mailer Configuration Error: {$e->getMessage()}");
        // Melempar kembali exception agar pemanggil tahu ada masalah
        throw $e;
    }
}
