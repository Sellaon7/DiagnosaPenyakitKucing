<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna memiliki role ID 1 (Admin)
if ($_SESSION['role_id'] != 1) {
    // Redirect atau beri pesan error jika tidak memiliki akses
    echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
    exit();
}

// Proses form tambah gejala
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_gejala = $_POST['nama_gejala'];

    // Query SQL untuk menambah gejala baru
    $sql = "INSERT INTO gejala (nama_gejala) VALUES (:nama_gejala)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nama_gejala', $nama_gejala);

    if ($stmt->execute()) {
        // Redirect ke halaman manage symptoms setelah berhasil tambah gejala
        header('Location: data_gejala.php');
        exit();
    } else {
        echo "Gagal menambah gejala.";
    }
}
