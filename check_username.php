<?php
require 'koneksi.php'; // Pastikan path ini benar

$response = [
    'exists' => false,
    'message' => ''
];

if (isset($_GET['username'])) {
    $username = trim($_GET['username']);

    // Hanya cek jika username tidak kosong
    if (!empty($username)) {
        try {
            $stmt = $pdo->prepare("SELECT 1 FROM users WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);

            if ($stmt->fetchColumn()) {
                // Username ditemukan (sudah ada)
                $response['exists'] = true;
                $response['message'] = 'Username sudah digunakan.';
            } else {
                // Username tidak ditemukan (tersedia)
                $response['exists'] = false;
                $response['message'] = 'Username tersedia.';
            }
        } catch (PDOException $e) {
            // Handle error database jika perlu, tapi jangan tampilkan detail ke user
            $response['message'] = 'Gagal memeriksa username.'; // Pesan error generik
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
