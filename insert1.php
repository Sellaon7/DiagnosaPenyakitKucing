<?php
include 'session.php';
include 'koneksi.php';

if (isset($_POST['add'])) {
    $penyakit_id = $_POST['penyakit_id'];
    $gejala_id = $_POST['gejala_id'];

    // Insert data gejala baru ke dalam database
    $stmt = $pdo->prepare('INSERT INTO penyakit_gejala (penyakit_id, gejala_id) VALUES (?, ?)');
    $stmt->execute([$penyakit_id, $gejala_id]);

    header('Location: data_gejala.php');
    exit();
} else {
    echo "Akses tidak sah.";
}
?>
