<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna adalah Admin (role_id = 1)
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    echo "<div class='container text-center mt-5'><div class='alert alert-danger'>Akses ditolak. Anda bukan Admin.</div> <a href='index.php' class='btn btn-secondary mt-3'>Kembali</a></div>";
    exit();
}

// Ambil daftar roles
try {
    $stmt_roles = $pdo->query("SELECT id, nama_role FROM roles ORDER BY nama_role");
    $roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error mengambil data roles: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body id="page-top">

    <?php include 'components/navbar.php'; ?>

    <section class="page-section bg-light">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Tambah User Baru</h2><br><br>
            </div>

            <!-- Form untuk menambahkan user -->
            <form action="proses_tambah_user.php" method="post">
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="username">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="password">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="role_id">Role</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="role_id" name="role_id" required>
                            <option value="" selected disabled>-- Pilih Role --</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role['id']; ?>"><?php echo htmlspecialchars($role['nama_role']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" name="tambah" class="btn btn-primary"><i class="fa fa-save"></i> Simpan User</button>
                        <a href="data_user.php" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>