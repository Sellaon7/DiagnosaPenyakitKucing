
<!DOCTYPE html>
<html>

<?php
include 'components/head.php';
?>

<body id="page-top">
	<!-- Top Navbar -->
	<?php
    	include 'components/navbar.php';
    ?>
	<!-- End Top Navbar -->

	<!-- Masthead-->
	<header class="masthead">
		<div class="container">
			<div class="masthead-subheading">Selamat Datang, <?php echo $_SESSION['username']; ?> !!</div>
			<div class="masthead-heading text-uppercase">Diagnosa Penyakit Kucing</div>
			<a class="btn btn-primary btn-xl text-uppercase" href="diagnosa.php">
				Mulai Diagnosa
				<i class="fa fa-reguler fa-circle-right"></i>
			</a>
		</div>
	</header>

	<!-- Footer -->
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