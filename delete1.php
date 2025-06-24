<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna memiliki role ID 1 (Admin)
if ($_SESSION['role_id'] != 1) {
    // Redirect atau beri pesan error jika tidak memiliki akses
    echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
    exit();
}

// Ambil id gejala dari parameter URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id) {
    try {
        // Mulai transaksi
        $pdo->beginTransaction();

        // 1. Hapus relasi di tabel penyakit_gejala yang terkait dengan gejala ini
        $sql_delete_relations = "DELETE FROM penyakit_gejala WHERE gejala_id = :gejala_id";
        $stmt_relations = $pdo->prepare($sql_delete_relations);
        $stmt_relations->bindParam(':gejala_id', $id);
        $stmt_relations->execute();

        // 2. Hapus gejala dari tabel gejala
        $sql_delete_gejala = "DELETE FROM gejala WHERE id = :id";
        $stmt_gejala = $pdo->prepare($sql_delete_gejala);
        $stmt_gejala->bindParam(':id', $id);
        $stmt_gejala->execute();

        // Commit transaksi jika semua berhasil
        $pdo->commit();

        header('Location: data_gejala.php');
        exit();
    } catch (PDOException $e) {
        // Rollback transaksi jika terjadi error
        $pdo->rollBack();
        echo "Gagal menghapus gejala: " . $e->getMessage();
    }
} else {
    echo "ID Gejala tidak valid.";
}
