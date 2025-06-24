<?php
include 'session.php';
include 'koneksi.php';

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $username = trim($_POST['username']);
    // $role_id = $_POST['role_id'];
    $user_id = $_SESSION['user_id'];

    // Validasi dasar
    if (empty($username)) {
        $_SESSION['error_message'] = "Username tidak boleh kosong.";
        header('Location: profile.php');
        exit();
    }
    // Opsional: Validasi nama jika diperlukan
    // if (empty($name)) {
    //     $_SESSION['error_message'] = "Nama tidak boleh kosong.";
    //     header('Location: profile.php');
    //     exit();
    // }

    // Upload foto profil jika dipilih
    $photo_path_baru = null; // Path foto baru
    $gambar_lama = null; // Path foto lama dari DB
    // Ambil path foto lama dari DB
    try {
        $stmt_old_photo = $pdo->prepare("SELECT photo FROM users WHERE id = ?");
        $stmt_old_photo->execute([$user_id]);
        $user_data = $stmt_old_photo->fetch(PDO::FETCH_ASSOC);
        $gambar_lama = $user_data['photo'] ?? null;
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Gagal mengambil data foto lama: " . $e->getMessage();
        header('Location: profile.php');
        exit();
    }

    // Proses upload foto profil jika dipilih
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK && $_FILES['photo']['size'] > 0) {
        $target_dir = "uploads/"; // Pastikan folder ini ada dan writable
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $file_extension = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
        $unique_filename = 'profile_' . $user_id . '_' . time() . '.' . $file_extension; // Nama file unik
        $target_file = $target_dir . $unique_filename;
        // Ambil path foto lama dari DB
        try {
            $stmt_old_photo = $pdo->prepare("SELECT photo FROM users WHERE id = ?");
            $stmt_old_photo->execute([$user_id]);
            $user_data = $stmt_old_photo->fetch(PDO::FETCH_ASSOC);
            $gambar_lama = $user_data['photo'] ?? null;
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Gagal mengambil data foto lama: " . $e->getMessage();
            header('Location: profile.php');
            exit();
        }

        // Proses upload foto profil jika dipilih
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK && $_FILES['photo']['size'] > 0) {
            $target_dir = "uploads/"; // Pastikan folder ini ada dan writable
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            $file_extension = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
            $unique_filename = 'profile_' . $user_id . '_' . time() . '.' . $file_extension; // Nama file unik
            $target_file = $target_dir . $unique_filename;

            $uploadOk = 1;
            $imageFileType = $file_extension;

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["photo"]["tmp_name"]);
            if ($check === false) {
                $_SESSION['error_message'] = "File yang diupload bukan gambar.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["photo"]["size"] > 50000000) {
                $_SESSION['error_message'] = "Maaf, ukuran file terlalu besar (maks 5MB).";
                $uploadOk = 0;
            }

            // Izinkan format file tertentu
            if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                $_SESSION['error_message'] = "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
                $uploadOk = 0;
            }
            // Jika semua validasi OK, coba upload
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    $photo_path_baru = $target_file; // Simpan path baru untuk update DB

                } else {
                    $_SESSION['error_message'] = "Maaf, terjadi error saat mengupload file Anda.";
                    $uploadOk = 0; // Tandai gagal upload            
                }
            }

            // Jika upload gagal, redirect kembali
            if ($uploadOk == 0) {
                header('Location: profile.php');
                exit();
            }
        }
    }

    // Tentukan path foto yang akan disimpan ke DB
    $gambar_untuk_db = ($photo_path_baru !== null) ? $photo_path_baru : $gambar_lama;

    // Update data pengguna di database
    try {
        // Hapus 'role_id = ?' dari query
        $stmt = $pdo->prepare('UPDATE users SET name = ?, username = ?, photo = ? WHERE id = ?');
        if ($stmt->execute([$name, $username, $gambar_untuk_db, $user_id])) {
            // Jika update berhasil DAN ada foto baru, hapus foto lama
            if ($photo_path_baru !== null && !empty($gambar_lama) && file_exists($gambar_lama) && $gambar_lama != $photo_path_baru) {
                unlink($gambar_lama);
            }
            // Perbarui sesi dengan username baru jika diubah
            $_SESSION['username'] = $username;
            $_SESSION['success_message'] = "Profil berhasil diperbarui.";
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui profil di database.";
        }
    } catch (PDOException $e) {
        // Tangani error duplikat username jika ada constraint UNIQUE
        if ($e->errorInfo[1] == 1062) {
            $_SESSION['error_message'] = "Error: Username '{$username}' sudah digunakan.";
        } else {
            $_SESSION['error_message'] = "Error database: " . $e->getMessage();
        }
    }

    header('Location: profile.php'); // Redirect kembali ke halaman profil
    exit();
} else {
    // Jika akses tidak melalui POST atau tombol update tidak ditekan
    header('Location: profile.php');
    exit();
}
