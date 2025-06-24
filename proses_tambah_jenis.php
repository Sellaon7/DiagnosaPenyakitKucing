<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna memiliki role ID 1 (Admin)
if ($_SESSION['role_id'] != 1) {
    echo "Anda tidak memiliki izin untuk melakukan aksi ini.";
    exit();
}

// Pastikan request adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {

    // Ambil data dari form
    $nama_jenis = $_POST['nama_jenis'];
    $deskripsi = $_POST['deskripsi'] ?? null; // Gunakan null coalescing operator jika bisa kosong
    $berat = $_POST['berat'] ?? null;
    $tinggi = $_POST['tinggi'] ?? null;
    $umur = $_POST['umur'] ?? null;
    $mantel_bulu = $_POST['mantel_bulu'] ?? null;
    $gambar_path = null; // Inisialisasi path gambar

    // Proses upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "assets/img/jenis/"; // Direktori tujuan upload
        // Pastikan direktori ada dan writable
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true); // Buat direktori jika belum ada
        }

        // Buat nama file yang unik untuk menghindari penimpaan (opsional tapi disarankan)
        $file_extension = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
        $unique_filename = uniqid('jenis_', true) . '.' . $file_extension;
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

        // Cek jika $uploadOk bernilai 0 karena error
        if ($uploadOk == 0) {
            echo "Maaf, file Anda tidak terupload.";
            // Jika semua ok, coba upload file
        } else {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $gambar_path = $target_file; // Simpan path relatif ke database
            } else {
                echo "Maaf, terjadi error saat mengupload file Anda.";
                $uploadOk = 0; // Set uploadOk ke 0 jika move gagal
            }
        }
    } else {
        // Handle jika tidak ada file atau ada error upload
        echo "Error saat upload gambar atau tidak ada gambar yang dipilih.";
        $uploadOk = 0; // Anggap gagal jika tidak ada file atau error
    }

    try {
        // Hanya lanjutkan jika upload gambar berhasil
        if (isset($uploadOk) && $uploadOk == 1 && $gambar_path !== null) {
            // Query SQL untuk menambah data baru
            $sql = "INSERT INTO jenis_kucing (nama_jenis, gambar, deskripsi, berat, tinggi, umur, mantel_bulu) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            // Eksekusi query dengan data yang sudah diambil (termasuk path gambar baru)
            if ($stmt->execute([$nama_jenis, $gambar_path, $deskripsi, $berat, $tinggi, $umur, $mantel_bulu])) {
                // Redirect kembali ke halaman jenis kucing setelah berhasil
                header('Location: jenis.php');
                exit();
            } else {
                echo "Gagal menambah data jenis kucing ke database.";
                // Hapus file yang sudah terupload jika insert gagal (opsional)
                if (file_exists($gambar_path)) {
                    unlink($gambar_path);
                }
            }
        } else {
            echo "<br>Penambahan data dibatalkan karena masalah upload gambar.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // Hapus file yang mungkin sudah terupload jika terjadi error DB (opsional)
        if (isset($gambar_path) && file_exists($gambar_path)) {
            unlink($gambar_path);
        }
    }
} else {
    // Jika bukan POST atau tombol 'tambah' tidak ditekan
    echo "Akses tidak sah.";
    // header('Location: jenis.php'); // Redirect jika perlu
    exit();
}
