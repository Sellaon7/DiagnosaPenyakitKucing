<?php
include 'session.php';
include 'koneksi.php';

// Periksa apakah pengguna memiliki role ID 1 (Admin)
if ($_SESSION['role_id'] != 1) {
    // Redirect atau beri pesan error jika tidak memiliki akses
    echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
    exit();
}

// Ambil daftar penyakit_gejala dari database
$stmt = $pdo->query('SELECT penyakit_gejala.id, penyakit.nama_penyakit, penyakit_id, gejala.nama_gejala, gejala_id FROM penyakit_gejala JOIN penyakit ON penyakit_gejala.penyakit_id = penyakit.id  JOIN gejala ON penyakit_gejala.gejala_id = gejala.id limit 50');
$symptoms = $stmt->fetchAll();

// Ambil semua data penyakit dan gejala untuk dropdown
$stmt_penyakit = $pdo->query('SELECT * FROM penyakit');
$penyakit_list = $stmt_penyakit->fetchAll();

$stmt_gejala = $pdo->query('SELECT * FROM gejala');
$gejala_list = $stmt_gejala->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>JST Data Kriteria</title>
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
                <h2 class="section-heading text-uppercase">Data Kriteria</h2><br><br>
            </div>

            <!-- Topbar Search -->
            <form class="navbar-search">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="cari">Cari Penyakit & Gejala</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="filter" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2"><br>
                    </div>
                </div>
            </form>

            <!-- Form untuk menambahkan kriteria -->
            <form action="insert.php" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="penyakit_id">Nama Penyakit</label>
                    <div class="col-sm-5">
                        <select class="form-control" id="penyakit_id" name="penyakit_id" required>
                            <?php foreach ($penyakit_list as $penyakit): ?>
                                <option value="<?php echo $penyakit['id']; ?>"><?php echo $penyakit['nama_penyakit']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="gejala_id">Nama Gejala</label>
                    <div class="col-sm-5">
                        <select class="form-control" id="gejala_id" name="gejala_id" required>
                            <?php foreach ($gejala_list as $gejala): ?>
                                <option value="<?php echo $gejala['id']; ?>"><?php echo $gejala['nama_gejala']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="mb-4">
                        <button type="submit" name="add" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>

            <!-- Tabel untuk menampilkan penyakit_gejala -->
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Penyakit</th>
                            <th>Id Penyakit</th>
                            <th>Nama Gejala</th>
                            <th>Id Gejala</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($symptoms as $symptom): ?>
                            <tr>
                                <td><?php echo $symptom['nama_penyakit']; ?></td>
                                <td><?php echo $symptom['penyakit_id']; ?></td>
                                <td><?php echo $symptom['nama_gejala']; ?></td>
                                <td><?php echo $symptom['gejala_id']; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-success me-md-2 edit-penyakit-gejala" data-id="<?php echo $symptom['id']; ?>" data-penyakit-id="<?php echo $symptom['penyakit_id']; ?>" data-gejala-id="<?php echo $symptom['gejala_id']; ?>"><i class="fa fa-edit"></i></button>
                                        <a class="btn btn-danger" href="delete.php?id=<?php echo $symptom['id']; ?>"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal untuk Edit Penyakit Gejala -->
    <div class="modal fade" id="editPenyakitGejalaModal" tabindex="-1" aria-labelledby="editPenyakitGejalaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="edit.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPenyakitGejalaModalLabel">Edit Kriteria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="form-group">
                            <label for="edit-penyakit_id">Penyakit:</label>
                            <select class="form-control" id="edit-penyakit_id" name="penyakit_id" required>
                                <?php foreach ($penyakit_list as $penyakit): ?>
                                    <option value="<?php echo $penyakit['id']; ?>"><?php echo $penyakit['nama_penyakit']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-gejala_id">Gejala:</label>
                            <select class="form-control" id="edit-gejala_id" name="gejala_id" required>
                                <?php foreach ($gejala_list as $gejala): ?>
                                    <option value="<?php echo $gejala['id']; ?>"> <?php echo $gejala['nama_gejala']; ?></option>
                                <?php endforeach; ?>
                            </select>
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
            $('.edit-penyakit-gejala').on('click', function() {
                var id = $(this).data('id');
                var penyakitId = $(this).data('penyakit-id');
                var gejalaId = $(this).data('gejala-id');

                $('#edit-id').val(id);
                $('#edit-penyakit_id').val(penyakitId);
                $('#edit-gejala_id').val(gejalaId);

                $('#editPenyakitGejalaModal').modal('show');
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