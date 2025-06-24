<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna memiliki role ID 1 (Admin)
if ($_SESSION['role_id'] != 1) {
    echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
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
                <h2 class="section-heading text-uppercase">Tambah Penyakit Baru</h2><br><br>
            </div>

            <!-- Form untuk menambahkan penyakit -->
            <form action="proses_tambah_penyakit.php" method="post" enctype="multipart/form-data">
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="nama_penyakit">Nama Penyakit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_penyakit" name="nama_penyakit" required>
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
                    <label class="col-sm-2 col-form-label" for="informasi">Informasi Penyakit</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="informasi" name="informasi" rows="4" placeholder="Jelaskan tentang penyakit ini..."></textarea>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="gejala_detail">Detail Gejala</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="gejala_detail" name="gejala_detail" rows="4" placeholder="Sebutkan gejala-gejala penyakit ini..."></textarea>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label" for="solusi">Solusi Penyakit</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="solusi" name="solusi" rows="4" placeholder="Jelaskan solusi atau penanganan penyakit ini..."></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" name="tambah" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Penyakit</button>
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