<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna memiliki role ID 1 (Admin)
if ($_SESSION['role_id'] != 1) {
    // Redirect atau beri pesan error jika tidak memiliki akses
    echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
    // header('Location: index.php'); // Atau redirect ke halaman lain
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
                <h2 class="section-heading text-uppercase">Tambah Jenis Kucing Baru</h2><br><br>
            </div>

            <!-- Form untuk menambahkan jenis kucing -->
            <form action="proses_tambah_jenis.php" method="post" enctype="multipart/form-data">
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="nama_jenis">Nama Jenis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="gambar">Upload Gambar</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                        <small class="form-text text-muted">Pilih file gambar (jpg, png, jpeg, gif).</small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="deskripsi">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="berat">Berat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="berat" name="berat" placeholder="Contoh: 5 - 10 pon">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="tinggi">Tinggi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tinggi" name="tinggi" placeholder="Contoh: 10 - 15 inci">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="umur">Umur</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="umur" name="umur" placeholder="Contoh: 12 - 15 tahun">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="mantel_bulu">Mantel Bulu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="mantel_bulu" name="mantel_bulu" placeholder="Contoh: Pendek dan halus">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" name="tambah" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Jenis Kucing</button>
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