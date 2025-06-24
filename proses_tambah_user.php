<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna adalah Admin (role_id = 1)
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    echo "Akses ditolak.";
    exit();
}

// Pastikan request adalah POST dan tombol 'tambah' ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {

    // Ambil data dari form
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];

    // Validasi dasar (tambahkan validasi lain jika perlu)
    if (empty($username) || empty($password) || empty($role_id)) {
        die("Username, password, dan role tidak boleh kosong.");
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Query SQL untuk menambah data user baru
        $sql = "INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Eksekusi query
        if ($stmt->execute([$username, $hashed_password, $role_id])) {
            header('Location: data_user.php'); // Redirect kembali ke halaman data user
            exit();
        } else {
            echo "Gagal menambah data user ke database.";
        }
    } catch (PDOException $e) {
        // Tangani error duplikat username
        if ($e->errorInfo[1] == 1062) { // Kode error MySQL untuk duplicate entry
            echo "Error: Username '{$username}' sudah digunakan. Silakan gunakan username lain.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    echo "Akses tidak sah.";
    exit();
}
