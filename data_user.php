<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna adalah Admin (role_id = 1)
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    echo "<div class='container text-center mt-5'><div class='alert alert-danger'>Akses ditolak. Anda bukan Admin.</div> <a href='index.php' class='btn btn-secondary mt-3'>Kembali</a></div>";
    exit();
}

// Ambil semua data user beserta nama role nya
try {
    $stmt = $pdo->query("SELECT u.id, u.username, r.nama_role FROM users u JOIN roles r ON u.role_id = r.id ORDER BY u.id");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error mengambil data user: " . $e->getMessage());
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
                <h2 class="section-heading text-uppercase">Manajemen Data User</h2><br><br>
            </div>

            <div class="mb-3">
                <a href="tambah_user.php" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah User Baru</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($users) > 0): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <th scope="row"><?php echo htmlspecialchars($user['id']); ?></th>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['nama_role']); ?></td>
                                    <td class="text-center">
                                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-success me-1" title="Edit">
                                            <i class="fas fa-edit fa-fw"></i>
                                        </a>
                                        <?php if ($user['id'] != $_SESSION['user_id']): // Jangan tampilkan tombol hapus untuk diri sendiri 
                                        ?>
                                            <a href="hapus_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus user ini?');">
                                                <i class="fas fa-trash fa-fw"></i>
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-danger" disabled title="Tidak bisa menghapus diri sendiri">
                                                <i class="fas fa-trash fa-fw"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data user.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>