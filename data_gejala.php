<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna memiliki role ID 1 (Admin)
if ($_SESSION['role_id'] != 1) {
    // Redirect atau beri pesan error jika tidak memiliki akses
    echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
    exit();
}

// Ambil data gejala dari database
$stmt = $pdo->query('SELECT * FROM gejala');
$symptoms = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>JST Data Gejala</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body id="page-top">

    <?php
    include 'components/navbar.php';
    ?>

    <section class="page-section bg-light">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Data Gejala</h2><br><br>
            </div>

            <!-- Topbar Search -->
            <form class="navbar-search">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="cari">Cari Gejala</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="filter" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2"><br>
                    </div>
                </div>
            </form>

            <!-- Form untuk menambahkan gejala -->
            <form action="tambah1.php" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="nama_gejala">Nama Gejala</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="nama_gejala" name="nama_gejala" required><br>
                    </div>
                    <div class="mb-4">
                        <button type="submit" name="add" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>

            <!-- Tabel untuk menampilkan gejala -->
            <div clas="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Gejala</th>
                            <th><i class="fa fa-cogs"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($symptoms as $symptom): ?>
                            <tr>
                                <td><?php echo $symptom['id']; ?></td>
                                <td><?php echo $symptom['nama_gejala']; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-success me-md-2 edit-symptom" data-id="<?php echo $symptom['id']; ?>" data-name="<?php echo $symptom['nama_gejala']; ?>"><i class="fa fa-edit"></i></button>
                                        <a class="btn btn-danger" href="delete1.php?id=<?php echo $symptom['id']; ?>"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal untuk Edit Gejala -->
    <div class="modal fade" id="editSymptomModal" role="dialog" tabindex="-1" aria-labelledby="editSymptomModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="edit1.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSymptomModalLabel">Edit Gejala</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="form-group">
                            <label for="edit-nama_gejala">Nama Gejala:</label>
                            <input type="text" class="form-control" id="edit-nama_gejala" name="nama_gejala" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    include 'components/footer.php';
    ?>

    <script>
        $(document).ready(function() {
            $('.edit-symptom').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#edit-id').val(id);
                $('#edit-nama_gejala').val(name);

                $('#editSymptomModal').modal('show');
            });
        });
    </script>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>