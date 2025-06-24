<?php
include 'components/head.php';
include 'session.php'; // Pastikan sesi dimulai jika navbar membutuhkannya
include 'koneksi.php'; // Sertakan file koneksi database

// Periksa apakah ID ada di URL dan valid
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    echo "<div class='container text-center mt-5'><div class='alert alert-danger'>ID Penyakit tidak valid.</div> <a href='penyakit.php' class='btn btn-secondary mt-3'>Kembali ke Daftar Penyakit</a></div>";
    exit();
}

$id_penyakit = $_GET['id'];

// Ambil data penyakit spesifik berdasarkan ID
try {
    $stmt = $pdo->prepare("SELECT * FROM penyakit WHERE id = ?");
    $stmt->execute([$id_penyakit]);
    $penyakit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$penyakit) {
        echo "<div class='container text-center mt-5'><div class='alert alert-warning'>Penyakit tidak ditemukan.</div> <a href='penyakit.php' class='btn btn-secondary mt-3'>Kembali ke Daftar Penyakit</a></div>";
        // Sertakan footer jika diinginkan
        // include 'components/footer.php';
        exit();
    }

    // Ambil semua penyakit untuk pagination (opsional)
    $stmt_all = $pdo->query('SELECT id FROM penyakit ORDER BY id');
    $all_penyakit_ids = $stmt_all->fetchAll(PDO::FETCH_COLUMN);
    $current_key = array_search($id_penyakit, $all_penyakit_ids);
    $previous_id = ($current_key !== false && $current_key > 0) ? $all_penyakit_ids[$current_key - 1] : null;
    $total_penyakit = count($all_penyakit_ids);
    $next_id = ($current_key !== false && $current_key < count($all_penyakit_ids) - 1) ? $all_penyakit_ids[$current_key + 1] : null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; // Head sudah diinclude di atas, bisa dihapus jika duplikat 
?>

<body id="page-top">
    <!-- Top Navbar -->
    <?php include 'components/navbar.php'; ?>
    <!-- End Top Navbar -->

    <!-- Detail Penyakit -->
    <section class="page-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Detail Penyakit -->
                    <h2 class="text-uppercase text-center mb-4"><?php echo htmlspecialchars($penyakit['nama_penyakit']); ?></h2>
                    <img class="img-fluid d-block mx-auto mb-4" src="<?php echo htmlspecialchars($penyakit['gambar']); ?>" alt="<?php echo htmlspecialchars($penyakit['nama_penyakit']); ?>" style="max-height: 400px; width: auto;" />

                    <!-- Menggunakan Accordion -->
                    <div class="accordion" id="accordionPenyakitDetail">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingInfoDetail">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfoDetail" aria-expanded="true" aria-controls="collapseInfoDetail">
                                    <b>Informasi Penyakit</b>
                                </button>
                            </h2>
                            <div id="collapseInfoDetail" class="accordion-collapse collapse show" aria-labelledby="headingInfoDetail" data-bs-parent="#accordionPenyakitDetail">
                                <div class="accordion-body text-start">
                                    <?php echo nl2br(htmlspecialchars($penyakit['informasi'] ?? 'Informasi tidak tersedia.')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingGejalaDetail">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGejalaDetail" aria-expanded="false" aria-controls="collapseGejalaDetail">
                                    <b>Gejala Penyakit</b>
                                </button>
                            </h2>
                            <div id="collapseGejalaDetail" class="accordion-collapse collapse" aria-labelledby="headingGejalaDetail" data-bs-parent="#accordionPenyakitDetail">
                                <div class="accordion-body text-start">
                                    <?php echo nl2br(htmlspecialchars($penyakit['gejala_detail'] ?? 'Detail gejala tidak tersedia.')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSolusiDetail">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSolusiDetail" aria-expanded="false" aria-controls="collapseSolusiDetail">
                                    <b>Solusi Penyakit</b>
                                </button>
                            </h2>
                            <div id="collapseSolusiDetail" class="accordion-collapse collapse" aria-labelledby="headingSolusiDetail" data-bs-parent="#accordionPenyakitDetail">
                                <div class="accordion-body text-start">
                                    <?php echo nl2br(htmlspecialchars($penyakit['solusi'] ?? 'Solusi tidak tersedia.')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="card-footer bg-transparent border-success my-2 mx-4">
                        <a href="penyakit.php" class="btn btn-secondary"><i class="fa fa-circle-left"></i>
                            Kembali
                        </a>
                    </div>

                    <!-- Navigasi Halaman Detail (Opsional, mirip feline1.php) -->
                    <nav aria-label="Page navigation example" class="mt-5">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo $previous_id === null ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $previous_id !== null ? 'detail_penyakit.php?id=' . $previous_id : '#'; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php
                            // Logika untuk menampilkan nomor halaman
                            $jumlah_nomor_tampil = 5; // Jumlah total nomor yang ingin ditampilkan (usahakan ganjil)
                            $setengah = floor($jumlah_nomor_tampil / 2);
                            $start_page = max(0, $current_key - $setengah);
                            $end_page = min($total_penyakit - 1, $current_key + $setengah);

                            // Adjust start_page jika end_page mencapai batas akhir
                            if ($end_page - $start_page + 1 < $jumlah_nomor_tampil) {
                                $start_page = max(0, $end_page - $jumlah_nomor_tampil + 1);
                            }
                            // Adjust end_page jika start_page mencapai batas awal
                            if ($end_page - $start_page + 1 < $jumlah_nomor_tampil) {
                                $end_page = min($total_penyakit - 1, $start_page + $jumlah_nomor_tampil - 1);
                            }

                            for ($i = $start_page; $i <= $end_page; $i++):
                                $page_id = $all_penyakit_ids[$i];
                                $is_active = ($i == $current_key);
                            ?>
                                <li class="page-item <?php echo $is_active ? 'active' : ''; ?>" <?php echo $is_active ? 'aria-current="page"' : ''; ?>>
                                    <a class="page-link" href="detail_penyakit.php?id=<?php echo $page_id; ?>"><?php echo $i + 1; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $next_id === null ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $next_id !== null ? 'detail_penyakit.php?id=' . $next_id : '#'; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>