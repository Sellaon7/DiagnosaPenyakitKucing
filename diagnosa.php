<!DOCTYPE html>
<html lang="en">

<?php
include 'components/head.php';
?>

<body id="page-top">
    <!-- Top Navbar -->
    <?php
        include 'components/navbar.php';
    ?>
	<!-- End Top Navbar -->
    
    <!-- Jenis Gejala Grid-->
    <section class="page-section bg-light">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Pilihan Gejala</h2><br><br>
                </div>
                <div class="card o-hidden border-primary shadow-lg my-8 col-lg-5 mx-4 bg-light">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col">
                                <form class="list-group col-lg-12 gap-1" method="post" action="hasil_diagnosa.php">
                                    <?php
                                    include 'koneksi.php';
                                    $stmt = $pdo->query('SELECT * FROM gejala');
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo 
                                        '<li class="list-group-item">
                                            <label class="form-check-label stretched-link">
                                                <input class="form-check-input me-1" type="checkbox" name="gejala[]" value="' . $row['id'] . '"> ' . $row['nama_gejala'] . 
                                            '</label>
                                        </li>';
                                    }
                                    ?>
                                    <hr>
                                    <div class="d-grid gap-2 d-md-flex justify-content-end">
                                        <input class="btn btn-success me-md-2" type="submit" name="submit" value="Diagnosa Penyakit">
                                        <input class="btn btn-outline-danger" type="reset" value="Reset Pilihan">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-auto mx-auto my-auto">
                    <a>
                        <img class="img-fluid" src="assets/img/kucing2.png" alt="..." />
                    </a>
                </div>
                <div class="my-4">
                    <a href="index.php" class="btn btn-secondary"><i class="fa fa-circle-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php
    	include 'components/footer.php';
    ?>
	<!-- Bootstrap core JS-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>