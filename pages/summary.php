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

		<title>Podsumowanie &bull; Manage Hospital</title>

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
						<a class="nav-link" href="./patients.php">Pacjenci</a>
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

			<div class="row">
				<div class="col-sm-1">
 
				</div>
				<div class="col-sm-10">
					<div class="text-center" style="margin-bottom: 25px">
						<img class="img-fluid rounded" src="../hospital_photo.jpg" alt="Photo of the hospital"> 
					</div>		
				</div>
				<div class="col-sm-1">
 
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4 text-center">
					<?php
						$sql = "SELECT pesel FROM lekarze";
						$result = $mysqli->query($sql);
						$liczba_lekarzy = $result->num_rows;
						echo "<p>Liczba zatrudnionych lekarzy:<br>". $liczba_lekarzy ."</p>";
					?>							
				</div>
				<div class="col-sm-4 text-center">
					<?php
						$sql = "SELECT pesel FROM pacjenci p JOIN rejestracje r ON r.pacjenci_pesel=p.pesel WHERE data_wypisu IS NULL";
						$result = $mysqli->query($sql);
						$liczba_pacjentów = $result->num_rows;
						echo "<p>Liczba pacjentów w szpitalu:<br>". $liczba_pacjentów ."</p>";
					?>			
				</div>
				<div class="col-sm-4 text-center">
					<?php
						$sql = "SELECT * FROM leki_w_magazynie WHERE CAST(ilosc AS UNSIGNED) < 14";
						$result = $mysqli->query($sql);
						$deficyty = $result->num_rows;
						if($deficyty > 0) {
							$mag = "Braki w zaopatrzeniu!";
						} else {
							$mag = "OK";
						}
						echo "<p>Stan magazynu:<br>". $mag ."</p>";
					?>					
				</div>
			</div>

		</main>
		
	</body>
</html>
