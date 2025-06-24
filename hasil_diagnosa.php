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

    <!-- Hasil Diagnosa-->
    <section class="page-section bg-light">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Hasil Diagnosa</h2><br><br>
                </div>
                <div class="card border-success mb-3 mx-auto" style="max-width: 100rem;">
                    <div class="card-header bg-transparent border-success" align="center">
                        <h5>Nama Penyakit</h5>
                    </div>
                    <div class="card-body text-success">
                        <h1 class="card-title" align="center">

                            <?php
                            include 'koneksi.php';

                            if (isset($_POST['submit'])) {
                                $gejala = isset($_POST['gejala']) ? $_POST['gejala'] : array();

                                if (empty($gejala)) {
                                    echo '<div class="result">';
                                    echo "<p>Tidak ada gejala yang dipilih.</p>";
                                    echo '</div>';
                                } else {
                                    // Ambil data penyakit dan gejalanya dari database
                                    $penyakit_gejala = array();
                                    // Modifikasi query untuk mengambil p.id
                                    $stmt = $pdo->query('SELECT p.id AS penyakit_id, p.nama_penyakit, p.link_penjelasan, g.id AS gejala_id FROM penyakit p JOIN penyakit_gejala pg ON p.id = pg.penyakit_id JOIN gejala g ON g.id = pg.gejala_id');
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $penyakit_gejala[$row['nama_penyakit']]['gejala'][] = $row['gejala_id'];
                                        $penyakit_gejala[$row['nama_penyakit']]['id'] = $row['penyakit_id']; // Simpan ID penyakit
                                    }

                                    // Inisialisasi bobot untuk gejala
                                    $bobot = array_fill_keys(array_column($pdo->query('SELECT id FROM gejala')->fetchAll(PDO::FETCH_ASSOC), 'id'), 1);

                                    // Perceptron sederhana untuk mendeteksi penyakit berdasarkan gejala
                                    $penyakit_terdeteksi = array();
                                    foreach ($penyakit_gejala as $penyakit => $detail) {
                                        $gejala_penyakit = $detail['gejala'];
                                        $sum = 0;
                                        foreach ($gejala_penyakit as $g) {
                                            if (in_array($g, $gejala)) {
                                                $sum += $bobot[$g];
                                            }
                                        }

                                        // Simpan penyakit yang terdeteksi dan skornya
                                        if ($sum > 0) {
                                            $penyakit_terdeteksi[] = [
                                                'nama' => $penyakit,
                                                'score' => $sum,
                                                'gejala_count' => count($gejala_penyakit),
                                                'id' => $detail['id'] // Ambil ID penyakit
                                            ];
                                        }
                                    }

                                    // Filter penyakit berdasarkan gejala yang dipilih
                                    $penyakit_final = array();
                                    if (count($gejala) >= 2) {
                                        foreach ($penyakit_terdeteksi as $detail) {
                                            if ($detail['score'] >= 2) {
                                                $penyakit_final[] = $detail;
                                            }
                                        }
                                    } else if (count($gejala) == 1) {
                                        foreach ($penyakit_terdeteksi as $detail) {
                                            if ($detail['score'] == 1) {
                                                $penyakit_final[] = $detail;
                                            }
                                        }
                                    }

                                    // Tampilkan hasil
                                    if (count($penyakit_final) > 0) {
                                        usort($penyakit_final, function ($a, $b) {
                                            return $b['score'] - $a['score'];
                                        });

                                        // Ambil maksimal 2 penyakit teratas dengan score tertinggi
                                        $penyakit_final = array_slice($penyakit_final, 0, 2);

                                        echo "<h1 class='card-title' align='center'>";
                                        foreach ($penyakit_final as $detail) {
                                            echo '<div class="result">';
                                            // Buat link ke detail_penyakit.php menggunakan ID
                                            echo "<h1><a href='detail_penyakit.php?id={$detail['id']}'>{$detail['nama']}</a></h1>";
                                            echo '</div>';
                                        }
                                        echo "</h1>";
                                    } else {
                                        echo '<div class="result">';
                                        echo "<h1>Tidak ditemukan penyakit berdasarkan gejala yang dipilih.</h1>";
                                        echo '</div>';
                                    }
                                }
                            } else {
                                echo '<div class="result">';
                                echo "<h1>Tidak ada gejala yang dipilih.</h1>";
                                echo '</div>';
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="card-footer bg-transparent border-success">
                        <a href="diagnosa.php" class="btn btn-secondary"><i class="fa fa-circle-left"></i>
                            Kembali
                        </a>
                    </div>
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