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

// Ambil data gejala yang akan diedit
$sql = "SELECT * FROM gejala WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$symptom = $stmt->fetch();

// Proses form edit gejala
if (isset($_POST['id']) && isset($_POST['nama_gejala'])) {
    $id = $_POST['id'];
    $nama_gejala = $_POST['nama_gejala'];

    $stmt = $pdo->prepare('UPDATE gejala SET nama_gejala = ? WHERE id = ?');
    if ($stmt->execute([$nama_gejala, $id])) {
        header('Location: data_gejala.php');
        exit();
    } else {
        echo "Gagal mengupdate gejala.";
    }
} else {
    echo "Data tidak lengkap.";
}
?>