<?php
include '../components/globals.php';
include '../components/check_session.php';
?>
<!doctype html>
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" type="image/png" href="../images/website_icon.png">

		<title>Zasoby &bull; Manage Hospital</title>

		<!-- Bootstrap core CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="../css/common_style.css" rel="stylesheet">
		
		<!-- Bootstrap core JavaScript -->
		<script src="../js/jquery-3.2.1.min.js"></script>
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	</head>

	<body>
	
		<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
			<a class="navbar-brand" href="#">Manage Hospital</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarsExampleDefault">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="./summary.php">Podsumowanie</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="./resources.php">Zasoby</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="./personnel.php">Personel</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="./access_control.php">Kontrola dostępu</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="./treatments.php">Terapie</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown01">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="../components/do_logout.php">Wyloguj się</a>
					</li>
				</ul>
			</div>
		</nav>

		<main class="container">

			<div class="text-center" style="margin-bottom: 25px">
				<img class="img-fluid rounded" src="../hospital_photo.jpg" alt="Photo of the hospital"> 
			</div>			

			<div class="row">
				<div class="col-sm-4">
					<p>Liczba pacjentów w szpitalu:<br>AAA</p>
					<p>Liczba lekarzy:<br>BBB</p>
				</div>
				<div class="col-sm-4">
					Liczba odwiedzających dzisiaj:<br>CCC
				</div>
				<div class="col-sm-4">
					Stan magazynu:<br>DDD
				</div>
			</div>

		</main>
		
	</body>
</html>
