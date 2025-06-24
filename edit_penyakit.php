<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna memiliki role ID 1 (Admin)
if ($_SESSION['role_id'] != 1) {
    echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
    exit();
}

// Periksa apakah ID ada di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID Penyakit tidak valid.";
    exit();
}

$id_penyakit = $_GET['id'];

// Ambil data penyakit berdasarkan ID
try {
    $stmt = $pdo->prepare("SELECT * FROM penyakit WHERE id = ?");
    $stmt->execute([$id_penyakit]);
    $penyakit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$penyakit) {
        echo "Penyakit tidak ditemukan.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
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
                <h2 class="section-heading text-uppercase">Edit Penyakit</h2><br><br>
            </div>

            <!-- Form untuk mengedit penyakit -->
            <form action="proses_edit_penyakit.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($penyakit['id']); ?>">
                <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($penyakit['gambar']); ?>">

                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="nama_penyakit">Nama Penyakit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_penyakit" name="nama_penyakit" value="<?php echo htmlspecialchars($penyakit['nama_penyakit']); ?>" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Gambar Saat Ini</label>
                    <div class="col-sm-10">
                        <?php if (!empty($penyakit['gambar']) && file_exists($penyakit['gambar'])): ?>
                            <img src="<?php echo htmlspecialchars($penyakit['gambar']); ?>" alt="Gambar Saat Ini" style="max-height: 100px; max-width: 150px; margin-bottom: 10px;">
                        <?php else: ?>
                            <small class="text-muted">Tidak ada gambar.</small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="gambar_baru">Upload Gambar Baru (Opsional)</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="gambar_baru" name="gambar_baru" accept="image/*">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="informasi">Informasi Penyakit</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="informasi" name="informasi" rows="4"><?php echo htmlspecialchars($penyakit['informasi']); ?></textarea>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="gejala_detail">Detail Gejala</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="gejala_detail" name="gejala_detail" rows="4"><?php echo htmlspecialchars($penyakit['gejala_detail']); ?></textarea>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="solusi">Solusi Penyakit</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="solusi" name="solusi" rows="4"><?php echo htmlspecialchars($penyakit['solusi']); ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
                        <a href="penyakit.php" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>

        </div>
    </section>

    <?php include 'components/footer.php'; ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>