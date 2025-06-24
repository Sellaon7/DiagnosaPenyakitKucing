<?php
include 'session.php';
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data gejala berdasarkan ID
    $stmt = $pdo->prepare('DELETE FROM penyakit_gejala WHERE id = ?');
    $stmt->execute([$id]);

    header('Location: data_kriteria.php');
    exit();
} else {
    echo "Akses tidak sah.";
}
