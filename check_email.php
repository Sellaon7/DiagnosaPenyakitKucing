<?php
include 'koneksi.php'; // Include your database connection

header('Content-Type: application/json'); // Set response type to JSON

$response = [
    'exists' => false,
    'validFormat' => false,
    'message' => ''
];

if (isset($_GET['email'])) {
    $email = filter_var(trim($_GET['email']), FILTER_SANITIZE_EMAIL);

    // 1. Validate Format
    if (empty($email)) {
        $response['message'] = ''; // No message for empty input
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['validFormat'] = false;
        $response['message'] = 'Format email tidak valid.';
    } else {
        $response['validFormat'] = true;
        // 2. Check Database if format is valid
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $response['exists'] = true;
                $response['message'] = 'Email sudah terdaftar.';
            } else {
                $response['exists'] = false;
                $response['message'] = 'Email tersedia.'; // Success message
            }
        } catch (PDOException $e) {
            // Log error or handle appropriately
            $response['message'] = 'Error memeriksa email.'; // Generic error
        }
    }
} else {
    $response['message'] = 'Parameter email tidak ditemukan.';
}

echo json_encode($response);
