<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna adalah Admin (role_id = 1)
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    // Redirect atau tampilkan pesan error
    $_SESSION['error_message'] = "Anda tidak memiliki izin untuk melakukan aksi ini.";
    header('Location: data_user.php'); // Redirect ke halaman data user    
    exit();
}

// Pastikan request adalah POST dan tombol 'update' ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {

    // Ambil data dari form
    $id = $_POST['id'];
    $role_id = $_POST['role_id'];

    // Validasi dasar
    if (empty($id) || empty($role_id)) {
        $_SESSION['error_message'] = "Data tidak lengkap.";
        header('Location: edit_user.php?id=' . $id); // Kembali ke form edit
    }

    try {
        // Query SQL untuk update data user tanpa password
        $sql = "UPDATE users SET role_id = ? WHERE id = ?";
        $params = [$role_id, $id];

        $stmt = $pdo->prepare($sql);

        // Eksekusi query
        if ($stmt->execute($params)) {
            $_SESSION['success_message'] = "Role user berhasil diperbarui.";
            header('Location: data_user.php'); // Redirect kembali ke halaman data user
            exit();
        } else {
            echo "Gagal mengupdate role user.";
        }
    } catch (PDOException $e) {
        // Redirect kembali ke halaman edit jika terjadi error di atas
        header('Location: edit_user.php?id=' . $id);
        exit();
    }
} else {
    // Jika bukan POST atau tombol update tidak ditekan
    $_SESSION['error_message'] = "Akses tidak sah.";
    header('Location: data_user.php');
    exit();
}
