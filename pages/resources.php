<?php
include '../components/globals.php';
include '../components/check_session.php';

if(isset($_GET['option'])) {
	$option = $_GET['option'];
} else {
	$option = 'showstock';
}
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
					<li class="nav-item">
						<a class="nav-link" href="./summary.php">Podsumowanie</a>
					</li>
					<li class="nav-item active">
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

			<div class="row">
				<div class="col-sm-3">
					<div class="list-group">
						<a href="./resources.php?option=showstock" class="list-group-item list-group-item-action <?php echo ($option == 'showstock' ? 'active' : ''); ?>">Stan magazynu</a>
						<a href="./resources.php?option=placeorder" class="list-group-item list-group-item-action <?php echo (($option == 'placeorder' || $option == 'processorder') ? 'active' : ''); ?>">Nowe zamówienie</a>
						<a href="./resources.php?option=orderhistory" class="list-group-item list-group-item-action <?php echo ($option == 'orderhistory' ? 'active' : ''); ?>">Historia zamówień</a>
						<a href="./resources.php?option=addmedicine" class="list-group-item list-group-item-action <?php echo (($option == 'addmedicine' || $option == 'processaddmed') ? 'active' : ''); ?>">Dodaj lek</a>
					</div>
				</div>
				<div class="col-sm-1">
					
				</div>
				<div class="col-sm-8">
					
					<?php
					if($option == 'showstock') {
						echo '<h1>Stan magazynu</h1>';
						
						$sql = "SELECT * FROM leki_w_magazynie ORDER BY nazwa";
						$result = $mysqli->query($sql);
						if ($result->num_rows == 0) {
							echo '<div class="alert alert-info" role="alert">
								<strong>Informacja</strong> Nie wprowadzono jeszcze żadnych leków do bazy danych.
							</div>';
						} else {
							echo "<table>\n<tr><th>ID</th><th>Nazwa</th><th>Ilość</th></tr>\n";							
							while ($row = $result->fetch_assoc()) {
								echo "<tr><td>". $row['id_leku'] ."</td><td>". $row['nazwa'] ."</td><td>". $row['ilosc'] ."</td></tr>\n";
							}
							echo "</table>\n";
						}
					} elseif($option == 'placeorder') {
						echo "<h1>Nowe zamówienie</h1>\n<h5>Wprowadź informacje o zamówieniu</h5>";
						
						$sql = "SELECT * FROM leki_w_magazynie ORDER BY nazwa";
						$result = $mysqli->query($sql);
						$leki=array();						
						while ($row = $result->fetch_assoc()) {
							array_push($leki,array($row['id_leku'], $row['nazwa']));
						}
						
						echo '<form action="./resources.php?option=processorder" method="post">
								<div class="form-group">
									<label for="fselect1">Nazwa leku</label>
									<select class="form-control" id="fselect1" name="zam_id_leku">';
									foreach ($leki as &$entry) {
										echo '<option value="'. $entry[0] .'">'. $entry[1] .'</option>';
									}
						echo '</select>
								</div>
								<div class="form-group">
									<label for="finput1">Zamawiana ilość</label>
									<input type="number" class="form-control" id="finput1" name="zam_ilosc">
								</div>
								<div class="form-group">
									<label for="finput2">Kwota zamówienia</label>
									<input type="number" class="form-control" id="finput2" name="zam_kwota">
								</div>
								<button type="submit" class="btn btn-primary">Zatwierdź</button>
							</form>';
					} elseif($option == 'processorder') {
						echo "<h1>Nowe zamówienie</h1>\n";
						$form_data_valid = false;
						if(isset($_POST['zam_id_leku']) && isset($_POST['zam_ilosc']) && isset($_POST['zam_kwota'])) {
							if(is_numeric($_POST['zam_ilosc']) && $_POST['zam_ilosc'] > 0 && is_numeric($_POST['zam_kwota']) && $_POST['zam_kwota'] > 0) {
								$form_data_valid = true;
							}							
						}
						if($form_data_valid == true) {
							$zam_data = date('Y-m-d');
							$zam_id = dechex(time());
							$zam_id_leku = $_POST['zam_id_leku'];
							$zam_ilosc = $_POST['zam_ilosc'];
							$zam_kwota = $_POST['zam_kwota'];
							$sql_do1 = "INSERT INTO `zamowienia`(`data`, `ilosc`, `wartosc`, `id_zamowienia`, `id_leku`) VALUES ('$zam_data', $zam_ilosc, $zam_kwota, '$zam_id', '$zam_id_leku')";
							$sql_do2 = "UPDATE `leki_w_magazynie` SET `ilosc`=ilosc+$zam_ilosc WHERE `id_leku`='$zam_id_leku'";
							if (!$result1 = $mysqli->query($sql_do1)) {
								echo '<div class="alert alert-danger" role="alert">
										<strong>Wystąpił błąd bazy danych!</strong><br>Numer błędu: '. $mysqli->errno .'<br>Opis: '. $mysqli->error .'
									</div>';
							} else {
								if (!$result2 = $mysqli->query($sql_do2)) {
									echo '<div class="alert alert-danger" role="alert">
											<strong>Wystąpił błąd</strong><br>Numer błędu: '. $mysqli->errno .'<br>Opis: '. $mysqli->error .'
										</div>';
								} else {
									echo '<div class="alert alert-success" role="alert">
										<strong>Sukces</strong> Zamówienie zostało pomyślnie wprowadzone do bazy danych.
									</div>';
								}								
							}
						} else {
							echo '<div class="alert alert-warning" role="alert">
									<strong>Ostrzeżenie</strong> W formularzu wprowadzono nieprawidłowe dane. Ilość oraz kwota zamówienia muszą być liczbami większymi od zera.
								</div>';
						}
					} elseif($option == 'orderhistory') {
						echo '<h1>Historia zamówień</h1>';
						
						$sql = "SELECT *, zam.ilosc AS ilezamowiono FROM zamowienia AS zam JOIN leki_w_magazynie AS lek ON zam.id_leku=lek.id_leku ORDER BY zam.id_zamowienia DESC";
						$result = $mysqli->query($sql);
						
						if ($result->num_rows == 0) {
							echo '<div class="alert alert-info" role="alert">
								<strong>Informacja</strong> Nie wprowadzono jeszcze żadnych zamówień do bazy danych.
							</div>';
						} else {
							echo "<table>\n<tr><th>ID zamówienia</th><th>Data</th><th>Nazwa leku</th><th>ID leku</th><th>Zamówiona ilość</th><th>Wartość</th></tr>\n";							
							while ($row = $result->fetch_assoc()) {
								echo "<tr><td>". $row['id_zamowienia'] ."</td><td>". $row['data'] ."</td><td>". $row['nazwa'] ."</td><td>". $row['id_leku'] ."</td><td>". $row['ilezamowiono'] ."</td><td>". $row['wartosc'] ."</td></tr>\n";
							}
							//print_r($row);
							echo "</table>\n";
						}
					} elseif($option == 'addmedicine') {
						echo "<h1>Dodaj nowy lek</h1>\n<h5>Wprowadź informacje na temat nowego leku</h5>";
						
						echo '<form action="./resources.php?option=processaddmed" method="post">
								<div class="form-group">
									<label for="finput1">Identyfikator leku</label>
									<input type="text" maxlength="15" class="form-control" id="finput1" name="dnl_id">
								</div>
								<div class="form-group">
									<label for="finput2">Nazwa leku</label>
									<input type="text" maxlength="40" class="form-control" id="finput2" name="dnl_nazwa">
								</div>
								<div class="form-group">
									<label for="finput3">Początkowy stan ilościowy w magazynie</label>
									<input type="number" class="form-control" id="finput3" name="dnl_ilosc">
								</div>
								<button type="submit" class="btn btn-primary">Zatwierdź</button>
							</form>';
					} elseif($option == 'processaddmed') {
						echo "<h1>Dodaj nowy lek</h1>\n";
						$form_data_valid = false;
						if(isset($_POST['dnl_id']) && isset($_POST['dnl_nazwa']) && isset($_POST['dnl_ilosc'])) {
							if(is_numeric($_POST['dnl_ilosc']) && $_POST['dnl_ilosc'] >= 0 && strlen($_POST['dnl_id']) <= 15 && strlen($_POST['dnl_id']) > 0 && strlen($_POST['dnl_nazwa']) <= 40 && strlen($_POST['dnl_nazwa']) > 0) {
								$form_data_valid = true;
							}
						}
						if($form_data_valid == true) {
							$dnl_id = $_POST['dnl_id'];
							$dnl_nazwa = $_POST['dnl_nazwa'];
							$dnl_ilosc = $_POST['dnl_ilosc'];
							$sql_do1 = "SELECT COUNT(*) AS NumberOfRows FROM leki_w_magazynie WHERE id_leku='$dnl_id'";
							$result1 = $mysqli->query($sql_do1);
							$field1 = $result1->fetch_assoc();
							$sql_do2 = "SELECT COUNT(*) AS NumberOfRows FROM leki_w_magazynie WHERE nazwa='$dnl_nazwa'";
							$result2 = $mysqli->query($sql_do2);
							$field2 = $result2->fetch_assoc();
							if($field1['NumberOfRows'] != 0 || $field2['NumberOfRows'] != 0) {
								echo '<div class="alert alert-warning" role="alert">
									<strong>Ostrzeżenie</strong> W formularzu wprowadzono dane o leku, który już istnieje w bazie danych (identyfikator oraz nazwa muszą być unikalne).
								</div>';
							} else {
								$sql_do3 = "INSERT INTO `leki_w_magazynie`(`id_leku`, `nazwa`, `ilosc`) VALUES ('$dnl_id', '$dnl_nazwa' , $dnl_ilosc)";
								if (!$result3 = $mysqli->query($sql_do3)) {
								echo '<div class="alert alert-danger" role="alert">
										<strong>Wystąpił błąd bazy danych!</strong><br>Numer błędu: '. $mysqli->errno .'<br>Opis: '. $mysqli->error .'
									</div>';
								} else {
									echo '<div class="alert alert-success" role="alert">
										<strong>Sukces</strong> Zamówienie zostało pomyślnie wprowadzone do bazy danych.
									</div>';
								}
							}
						} else {
							echo '<div class="alert alert-warning" role="alert">
									<strong>Ostrzeżenie</strong> W formularzu wprowadzono nieprawidłowe dane. Identyfikator leku musi być nie dłuższa niż 15 znaków, a nazwa nie dłuższa niż 40 znaków.
								</div>';
						}
					}
					
					?>
				</div>
			</div>

		</main>
		
	</body>
</html>
