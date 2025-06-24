<?php
include 'session.php';
include 'koneksi.php';

if ($_SESSION['role_id'] != 1) {
    $_SESSION['error_message'] = "Anda tidak memiliki izin untuk mengakses halaman ini.";
    header('Location: index.php');
    exit();
}

if (isset($_POST['id']) && isset($_POST['penyakit_id']) && isset($_POST['gejala_id'])) {
    $id = $_POST['id'];
    $penyakit_id = $_POST['penyakit_id'];
    $gejala_id = $_POST['gejala_id'];

    $stmt = $pdo->prepare('UPDATE penyakit_gejala SET penyakit_id = ?, gejala_id = ? WHERE id = ?');
    if ($stmt->execute([$penyakit_id, $gejala_id, $id])) {
        header('Location: data_kriteria.php');
        exit();
    } else {
        echo "Gagal mengupdate penyakit gejala.";
    }
} else {
    echo "Data tidak lengkap.";
}
?>
