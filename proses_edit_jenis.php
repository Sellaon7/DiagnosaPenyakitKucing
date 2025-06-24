<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna memiliki role ID 1 (Admin)
if ($_SESSION['role_id'] != 1) {
    echo "Anda tidak memiliki izin untuk melakukan aksi ini.";
    exit();
}

// Pastikan request adalah POST dan tombol 'update' ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {

    // Ambil data dari form
    $id = $_POST['id'];
    $nama_jenis = $_POST['nama_jenis'];
    $deskripsi = $_POST['deskripsi'] ?? null;
    $berat = $_POST['berat'] ?? null;
    $tinggi = $_POST['tinggi'] ?? null;
    $umur = $_POST['umur'] ?? null;
    $mantel_bulu = $_POST['mantel_bulu'] ?? null;
    $gambar_lama = $_POST['gambar_lama']; // Path gambar lama
    $gambar_path_baru = null; // Inisialisasi path gambar baru
    $uploadOk = 1; // Status upload gambar baru

    // Proses upload gambar baru jika ada
    if (isset($_FILES['gambar_baru']) && $_FILES['gambar_baru']['error'] == UPLOAD_ERR_OK && $_FILES['gambar_baru']['size'] > 0) {
        $target_dir = "assets/img/jenis/"; // Direktori tujuan upload
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $file_extension = pathinfo($_FILES["gambar_baru"]["name"], PATHINFO_EXTENSION);
        $unique_filename = uniqid('jenis_', true) . '.' . $file_extension;
        $target_file = $target_dir . $unique_filename;
        $imageFileType = strtolower($file_extension);

        // Check jika file adalah gambar asli
        $check = getimagesize($_FILES["gambar_baru"]["tmp_name"]);
        if ($check === false) {
            echo "File baru bukan gambar.";
            $uploadOk = 0;
        }

        // Izinkan format file tertentu
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan untuk gambar baru.";
            $uploadOk = 0;
        }

        // Coba upload file baru jika validasi OK
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["gambar_baru"]["tmp_name"], $target_file)) {
                $gambar_path_baru = $target_file; // Simpan path gambar baru
            } else {
                echo "Maaf, terjadi error saat mengupload file baru Anda.";
                $uploadOk = 0;
            }
        }
    } elseif (isset($_FILES['gambar_baru']) && $_FILES['gambar_baru']['error'] != UPLOAD_ERR_NO_FILE) {
        // Ada error lain selain 'tidak ada file yang diupload'
        echo "Error saat upload gambar baru: " . $_FILES['gambar_baru']['error'];
        $uploadOk = 0;
    }

    // Lanjutkan hanya jika tidak ada error upload (jika ada file baru)
    if ($uploadOk == 1) {
        try {
            // Tentukan path gambar yang akan disimpan ke DB
            $gambar_untuk_db = ($gambar_path_baru !== null) ? $gambar_path_baru : $gambar_lama;

            // Query SQL untuk update data
            $sql = "UPDATE jenis_kucing SET
                        nama_jenis = ?,
                        gambar = ?,
                        deskripsi = ?,
                        berat = ?,
                        tinggi = ?,
                        umur = ?,
                        mantel_bulu = ?
                    WHERE id = ?";
            $stmt = $pdo->prepare($sql);

            // Eksekusi query
            if ($stmt->execute([$nama_jenis, $gambar_untuk_db, $deskripsi, $berat, $tinggi, $umur, $mantel_bulu, $id])) {
                // Jika update berhasil DAN ada gambar baru yang diupload, hapus gambar lama
                if ($gambar_path_baru !== null && !empty($gambar_lama) && file_exists($gambar_lama) && $gambar_lama != $gambar_path_baru) {
                    unlink($gambar_lama);
                }
                header('Location: jenis.php'); // Redirect kembali ke halaman jenis kucing
                exit();
            } else {
                echo "Gagal mengupdate data jenis kucing di database.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<br>Update dibatalkan karena masalah upload gambar baru.";
    }
} else {
    echo "Akses tidak sah atau data tidak lengkap.";
    exit();
}
