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
    echo "ID Jenis Kucing tidak valid.";
    exit();
}

$id_jenis = $_GET['id'];

// Ambil data jenis kucing berdasarkan ID
try {
    $stmt = $pdo->prepare("SELECT * FROM jenis_kucing WHERE id = ?");
    $stmt->execute([$id_jenis]);
    $jenis = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$jenis) {
        echo "Jenis Kucing tidak ditemukan.";
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
                <h2 class="section-heading text-uppercase">Edit Jenis Kucing</h2><br><br>
            </div>

            <!-- Form untuk mengedit jenis kucing -->
            <form action="proses_edit_jenis.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($jenis['id']); ?>">
                <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($jenis['gambar']); ?>"> <!-- Simpan path gambar lama -->

                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="nama_jenis">Nama Jenis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" value="<?php echo htmlspecialchars($jenis['nama_jenis']); ?>" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">Gambar Saat Ini</label>
                    <div class="col-sm-10">
                        <?php if (!empty($jenis['gambar']) && file_exists($jenis['gambar'])): ?>
                            <img src="<?php echo htmlspecialchars($jenis['gambar']); ?>" alt="Gambar Saat Ini" style="max-height: 100px; max-width: 150px; margin-bottom: 10px;">
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
                    <label class="col-sm-2 col-form-label" for="deskripsi">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?php echo htmlspecialchars($jenis['deskripsi']); ?></textarea>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="berat">Berat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="berat" name="berat" value="<?php echo htmlspecialchars($jenis['berat']); ?>" placeholder="Contoh: 5 - 10 pon">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="tinggi">Tinggi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tinggi" name="tinggi" value="<?php echo htmlspecialchars($jenis['tinggi']); ?>" placeholder="Contoh: 10 - 15 inci">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="umur">Umur</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="umur" name="umur" value="<?php echo htmlspecialchars($jenis['umur']); ?>" placeholder="Contoh: 12 - 15 tahun">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="mantel_bulu">Mantel Bulu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="mantel_bulu" name="mantel_bulu" value="<?php echo htmlspecialchars($jenis['mantel_bulu']); ?>" placeholder="Contoh: Pendek dan halus">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
                        <a href="jenis.php" class="btn btn-secondary">Batal</a>
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