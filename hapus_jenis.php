<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna memiliki role ID 1 (Admin)
if ($_SESSION['role_id'] != 1) {
    echo "Anda tidak memiliki izin untuk melakukan aksi ini.";
    exit();
}

// Periksa apakah ID ada di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID Jenis Kucing tidak valid.";
    exit();
}

$id_jenis = $_GET['id'];

try {
    // 1. Ambil path gambar sebelum menghapus data dari DB
    $stmt_select = $pdo->prepare("SELECT gambar FROM jenis_kucing WHERE id = ?");
    $stmt_select->execute([$id_jenis]);
    $jenis = $stmt_select->fetch(PDO::FETCH_ASSOC);
    $gambar_path = ($jenis && isset($jenis['gambar'])) ? $jenis['gambar'] : null;

    // 2. Hapus data dari database
    $stmt_delete = $pdo->prepare("DELETE FROM jenis_kucing WHERE id = ?");

    if ($stmt_delete->execute([$id_jenis])) {
        // 3. Jika data DB berhasil dihapus, hapus file gambar jika ada
        if ($gambar_path !== null && file_exists($gambar_path)) {
            unlink($gambar_path);
        }
        // Redirect kembali ke halaman jenis kucing setelah berhasil
        header('Location: jenis.php');
        exit();
    } else {
        echo "Gagal menghapus data jenis kucing dari database.";
    }
} catch (PDOException $e) {
    // Tangani error, misalnya jika ada foreign key constraint
    echo "Error saat menghapus data: " . $e->getMessage();
    // Mungkin perlu memberikan pesan yang lebih spesifik jika error disebabkan oleh relasi data
}
