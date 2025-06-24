<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna adalah Admin (role_id = 1)
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    echo "Akses ditolak.";
    exit();
}

// Periksa apakah ID ada di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID User tidak valid.";
    exit();
}

$id_user_hapus = $_GET['id'];

// **PENTING: Cegah admin menghapus dirinya sendiri**
if ($id_user_hapus == $_SESSION['user_id']) {
    echo "<div class='container text-center mt-5'><div class='alert alert-danger'>Anda tidak dapat menghapus akun Anda sendiri.</div> <a href='data_user.php' class='btn btn-secondary mt-3'>Kembali</a></div>";
    exit();
}

try {
    // Hapus data user dari database
    $stmt_delete = $pdo->prepare("DELETE FROM users WHERE id = ?");

    if ($stmt_delete->execute([$id_user_hapus])) {
        header('Location: data_user.php'); // Redirect kembali ke halaman data user
        exit();
    } else {
        echo "Gagal menghapus data user.";
    }
} catch (PDOException $e) {
    echo "Error saat menghapus data: " . $e->getMessage();
}
