<!DOCTYPE html>
<html lang="en">
<?php
include 'components/head.php';
include 'session.php'; // Pastikan sesi dimulai jika navbar membutuhkannya
include 'koneksi.php'; // Sertakan file koneksi database
?>

<body id="page-top">
    <!-- Top Navbar -->
    <?php
    include 'components/navbar.php';
    ?>
    <!-- End Top Navbar -->

    <!-- Penyakit-->
    <section class="page-section bg-light">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Penyakit Kucing</h2><br><br>
            </div>

            <div>
                <?php
                // Tampilkan tombol Tambah hanya jika role_id adalah 1 (Admin)
                if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                    <a href="tambah_penyakit.php" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah Penyakit</a>
                <?php endif; ?>
            </div>

            <?php
            // Ambil data penyakit dari database
            $stmt = $pdo->query('SELECT * FROM penyakit ORDER BY id');
            $penyakit_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <!-- Container untuk Grid View -->
            <div class="row">
                <?php foreach ($penyakit_list as $penyakit): ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- penyakit item -->
                        <!-- Tambahkan kelas card dan h-100 untuk tampilan kartu -->
                        <div class="portfolio-item card h-100 shadow-sm">
                            <a class="portfolio-link" href="detail_penyakit.php?id=<?php echo $penyakit['id']; ?>">
                                <!-- Bagian Gambar -->
                                <div class="portfolio-image-container">
                                    <!-- Gunakan kelas yang sama dengan jenis kucing untuk konsistensi ukuran -->
                                    <img class="img-fluid jenis-kucing-img" src="<?php echo htmlspecialchars($penyakit['gambar']); ?>" alt="<?php echo htmlspecialchars($penyakit['nama_penyakit']); ?>" />
                                </div>
                            </a>
                            <!-- Bagian Caption/Detail -->
                            <!-- Tambahkan text-center dan card-body -->
                            <div class="portfolio-caption card-body text-center">
                                <div class="portfolio-caption-heading"><?php echo htmlspecialchars($penyakit['nama_penyakit']); ?></div>
                                <!-- Hapus link Baca Selengkapnya -->
                                <a class="portfolio-link text-muted" href="detail_penyakit.php?id=<?php echo $penyakit['id']; ?>">
                                    <small>Baca Selengkapnya...</small>
                                </a>
                                <!-- Pindahkan ikon admin ke sini -->
                                <div class="mt-2">
                                    <?php
                                    // Tampilkan ikon Edit dan Hapus hanya jika role_id adalah 1 (Admin)
                                    if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                                        <a href="edit_penyakit.php?id=<?php echo $penyakit['id']; ?>" class="btn btn-sm btn-outline-success mx-1" title="Edit">
                                            <i class="fas fa-edit fa-fw"></i>
                                        </a>
                                        <a href="hapus_penyakit.php?id=<?php echo $penyakit['id']; ?>" class="btn btn-sm btn-outline-danger mx-1" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus penyakit ini?');">
                                            <i class="fas fa-trash fa-fw"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination dihapus -->
        </div>
    </section>

    <!-- Modals Penyakit Dihapus -->

    <!-- Footer -->
    <?php
    include 'components/footer.php';
    ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (jika belum ada atau dibutuhkan oleh script lain) -->
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>