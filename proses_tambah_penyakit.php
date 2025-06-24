<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna memiliki role ID 1 (Admin)
if ($_SESSION['role_id'] != 1) {
    echo "Anda tidak memiliki izin untuk melakukan aksi ini.";
    exit();
}

// Pastikan request adalah POST dan tombol 'tambah' ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {

    // Ambil data dari form
    $nama_penyakit = $_POST['nama_penyakit'];
    $informasi = $_POST['informasi'] ?? null;
    $gejala_detail = $_POST['gejala_detail'] ?? null;
    $solusi = $_POST['solusi'] ?? null;
    $gambar_path = null; // Inisialisasi path gambar

    // Proses upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "assets/img/penyakit/"; // Direktori tujuan upload (pastikan folder ini ada dan writable)
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $file_extension = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
        $unique_filename = uniqid('penyakit_', true) . '.' . $file_extension;
        $target_file = $target_dir . $unique_filename;

        $uploadOk = 1;
        $imageFileType = strtolower($file_extension);

        // Check jika file adalah gambar asli
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check === false) {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }

        // Izinkan format file tertentu
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
            $uploadOk = 0;
        }

        // Coba upload file jika validasi OK
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $gambar_path = $target_file; // Simpan path relatif ke database
            } else {
                echo "Maaf, terjadi error saat mengupload file Anda.";
                $uploadOk = 0;
            }
        }
    } else {
        echo "Error saat upload gambar atau tidak ada gambar yang dipilih.";
        $uploadOk = 0;
    }

    // Lanjutkan hanya jika upload gambar berhasil
    if ($uploadOk == 1 && $gambar_path !== null) {
        try {
            // Query SQL untuk menambah data baru
            $sql = "INSERT INTO penyakit (nama_penyakit, gambar, informasi, gejala_detail, solusi) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            // Eksekusi query
            if ($stmt->execute([$nama_penyakit, $gambar_path, $informasi, $gejala_detail, $solusi])) {
                header('Location: penyakit.php'); // Redirect kembali ke halaman penyakit
                exit();
            } else {
                echo "Gagal menambah data penyakit ke database.";
                if (file_exists($gambar_path)) {
                    unlink($gambar_path); // Hapus gambar jika insert gagal
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            if (isset($gambar_path) && file_exists($gambar_path)) {
                unlink($gambar_path); // Hapus gambar jika ada error DB
            }
        }
    } else {
        echo "<br>Penambahan data dibatalkan karena masalah upload gambar.";
    }
} else {
    echo "Akses tidak sah.";
    exit();
}
