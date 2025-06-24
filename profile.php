<?php
include 'session.php'; // Memulai sesi dan memeriksa login
include 'koneksi.php'; // Koneksi database

// Ambil data pengguna saat ini dari database
try {
    $stmt = $pdo->prepare("SELECT id, username, name, email, photo FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Handle jika user tidak ditemukan (seharusnya tidak terjadi jika sesi valid)
        $_SESSION['error_message'] = "Data pengguna tidak ditemukan.";
        header('Location: index.php');
        exit();
    }
} catch (PDOException $e) {
    die("Error mengambil data pengguna: " . $e->getMessage());
}

// Ambil pesan sukses/error dari sesi jika ada
$success_message = $_SESSION['success_message'] ?? null;
$error_message = $_SESSION['error_message'] ?? null;
unset($_SESSION['success_message'], $_SESSION['error_message']); // Hapus pesan setelah dibaca

?>
<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>
<style>
    .profile-picture-circle {
        width: 150px;
        /* Sesuaikan ukuran */
        height: 150px;
        /* Sesuaikan ukuran */
        border-radius: 50%;
        object-fit: cover;
        /* Agar gambar terpotong rapi */
        border: 3px solid #dee2e6;
        /* Optional: border abu-abu */
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 1rem;
    }
</style>

<body id="page-top">

    <?php include 'components/navbar.php'; ?>

    <section class="page-section bg-light">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Profil Saya</h2><br><br>
            </div>

            <?php if ($success_message): ?>
                <div class="alert alert-success text-center"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Tampilkan Foto Profil -->
                    <?php
                    $photo_path = (!empty($user['photo']) && file_exists($user['photo'])) ? $user['photo'] : 'assets/img/user.png'; // Ganti dengan path placeholder jika perlu
                    ?>
                    <img src="<?php echo htmlspecialchars($photo_path); ?>" alt="Foto Profil" class="profile-picture-circle">

                    <!-- Form Edit Profil -->
                    <form action="profile_update.php" method="post" enctype="multipart/form-data">
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label" for="name">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" placeholder="Masukkan nama lengkap Anda">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label" for="username">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label" for="email">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly disabled>
                                <small class="form-text text-muted">Email tidak dapat diubah.</small>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label" for="photo">Ubah Foto Profil</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>