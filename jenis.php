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

    <!-- Jenis Kucing Grid-->
    <section class="page-section bg-light" id="portfolio">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Jenis Kucing</h2><br><br>
            </div>

            <div>
                <?php
                // Tampilkan tombol Tambah hanya jika role_id adalah 1 (Admin)
                if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                    <a href="tambah_jenis.php" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah Jenis</a>
                <?php endif; ?>
            </div>

            <?php
            // Ambil data jenis kucing dari database
            $stmt = $pdo->query('SELECT * FROM jenis_kucing ORDER BY id');
            $jenis_kucing_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <!-- Container untuk Grid View -->
            <div class="row">
                <?php foreach ($jenis_kucing_list as $jenis): ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- jenis kucing item -->
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal<?php echo $jenis['id']; ?>">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-solid fa-angle-right fa-3x"></i></div>
                                </div>
                                <!-- Bagian Gambar -->
                                <div class="portfolio-image-container">
                                    <img class="img-fluid jenis-kucing-img" src="<?php echo htmlspecialchars($jenis['gambar']); ?>" alt="<?php echo htmlspecialchars($jenis['nama_jenis']); ?>" />
                                </div>
                            </a>
                            <!-- Bagian Caption/Detail -->
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading"><?php echo htmlspecialchars($jenis['nama_jenis']); ?></div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <a class="portfolio-link text-muted" data-bs-toggle="modal" href="#portfolioModal<?php echo $jenis['id']; ?>">
                                        <small>Baca Selengkapnya...</small>
                                    </a>
                                    <div>
                                        <?php
                                        // Tampilkan ikon Edit dan Hapus hanya jika role_id adalah 1 (Admin)
                                        if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                                            <a href="edit_jenis.php?id=<?php echo $jenis['id']; ?>" class="btn btn-sm btn-outline-success ms-1" title="Edit">
                                                <i class="fas fa-edit fa-fw"></i>
                                            </a>
                                            <a href="hapus_jenis.php?id=<?php echo $jenis['id']; ?>" class="btn btn-sm btn-outline-danger ms-1" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus jenis kucing ini? Menghapus jenis ini juga akan menghapus data terkait.');">
                                                <i class="fas fa-trash fa-fw"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- Jenis Kucing-->
    <!-- Modals -->
    <?php foreach ($jenis_kucing_list as $jenis): ?>
        <div class="portfolio-modal modal fade" id="portfolioModal<?php echo $jenis['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg"
                            alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project details-->
                                    <h2 class="text-uppercase"><?php echo htmlspecialchars($jenis['nama_jenis']); ?></h2>
                                    <img class="img-fluid d-block mx-auto" src="<?php echo htmlspecialchars($jenis['gambar']); ?>" alt="<?php echo htmlspecialchars($jenis['nama_jenis']); ?>" />
                                    <p>
                                        <?php echo nl2br(htmlspecialchars($jenis['deskripsi'])); // nl2br untuk menjaga format paragraf jika ada di database 
                                        ?>
                                    </p>
                                    <ul class="list-inline">
                                        <li>
                                            <strong>Berat:</strong>
                                            <?php echo htmlspecialchars($jenis['berat']); ?>
                                        </li>
                                        <li>
                                            <strong>Tinggi:</strong>
                                            <?php echo htmlspecialchars($jenis['tinggi']); ?>
                                        </li>
                                        <li>
                                            <strong>Umur:</strong>
                                            <?php echo htmlspecialchars($jenis['umur']); ?>
                                        </li>
                                        <li>
                                            <strong>Mantel Bulu:</strong>
                                            <?php echo htmlspecialchars($jenis['mantel_bulu']); ?>
                                        </li>
                                    </ul>
                                    <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal"
                                        type="button">
                                        <i class="fas fa-xmark me-1"></i>
                                        Kembali
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Footer -->
    <?php
    include 'components/footer.php';
    ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (jika belum ada atau dibutuhkan oleh script lain) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>