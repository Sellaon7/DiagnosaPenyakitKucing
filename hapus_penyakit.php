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
    echo "ID Penyakit tidak valid.";
    exit();
}

$id_penyakit = $_GET['id'];

try {
    // 1. Ambil path gambar sebelum menghapus data dari DB
    $stmt_select = $pdo->prepare("SELECT gambar FROM penyakit WHERE id = ?");
    $stmt_select->execute([$id_penyakit]);
    $penyakit = $stmt_select->fetch(PDO::FETCH_ASSOC);
    $gambar_path = ($penyakit && isset($penyakit['gambar'])) ? $penyakit['gambar'] : null;

    // 2. Hapus data dari database
    $stmt_delete = $pdo->prepare("DELETE FROM penyakit WHERE id = ?");

    if ($stmt_delete->execute([$id_penyakit])) {
        // 3. Jika data DB berhasil dihapus, hapus file gambar jika ada
        if ($gambar_path !== null && file_exists($gambar_path)) {
            unlink($gambar_path);
        }
        // Redirect kembali ke halaman penyakit setelah berhasil
        header('Location: penyakit.php');
        exit();
    } else {
        echo "Gagal menghapus data penyakit dari database.";
    }
} catch (PDOException $e) {
    // Tangani error, misalnya jika ada foreign key constraint (jika penyakit terhubung ke tabel lain)
    echo "Error saat menghapus data: " . $e->getMessage();
}
