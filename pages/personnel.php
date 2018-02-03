<?php
include '../components/globals.php';
include '../components/check_session.php';

if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = 'workers';
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

		<title>Personel &bull; Manage Hospital</title>

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
					<li class="nav-item">
						<a class="nav-link" href="./resources.php">Zasoby</a>
					</li>
					<li class="nav-item active">
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
						<a href="./personnel.php?action=workers" class="list-group-item list-group-item-action <?php echo ($action == 'workers' ? 'active' : ''); ?>">Lista pracowników</a>
						<a href="./personnel.php?action=addworker" class="list-group-item list-group-item-action <?php echo (($action == 'addworker' || $action == 'processaddworker') ? 'active' : ''); ?>">Dodaj pracownika</a>
						<a href="./personnel.php?action=payments" class="list-group-item list-group-item-action <?php echo ($action == 'payments' ? 'active' : ''); ?>">Lista wypłat</a>
						<a href="./personnel.php?action=addpayment" class="list-group-item list-group-item-action <?php echo (($action == 'addpayment' || $action == 'processaddpayment') ? 'active' : ''); ?>">Nowa wypłata</a>
						<a href="./personnel.php?action=autopayments" class="list-group-item list-group-item-action <?php echo (($action == 'autopayments' || $action == 'processautopayments') ? 'active' : ''); ?>">Automatyczne wypłaty</a>
					</div>
				</div>
				<div class="col-sm-1">
					
				</div>
				<div class="col-sm-8">
					
					<?php
					if($action == 'workers') {
						echo '<h1>Lista pracowników</h1>';
						
						$sql = "SELECT * FROM osoby o JOIN pracownicy p ON o.pesel=p.pesel ORDER BY nazwisko";
						$result = $mysqli->query($sql);
						if ($result->num_rows == 0) {
							echo '<div class="alert alert-info" role="alert">
								<strong>Informacja</strong> Nie wprowadzono jeszcze żadnych informacji o pracownikach.
							</div>';
						} else {
							echo "<table>\n<tr><th>Imię</th><th>Nazwisko</th><th>PESEL</th><th>Telefon</th><th>Adres</th><th>Stanowisko</th><th>Pensja</th></tr>\n";							
							while ($row = $result->fetch_assoc()) {
								echo "<tr><td>". $row['imie'] ."</td><td>". $row['nazwisko'] ."</td><td>". $row['pesel'] ."</td><td>". $row['telefon'] ."</td><td>". $row['adres'] ."</td><td>". $row['stanowisko'] ."</td><td>". $row['pensja'] ."</td></tr>\n";
							}
							echo "</table>\n";
						}
					} elseif($action == 'addworker') {
						echo "<h1>Dodaj pracownika</h1>\n<h5>Wprowadź informacje o nowym pracowniku</h5>";
						
						echo '<form action="./personnel.php?action=processaddworker" method="post">
								<div class="form-group">
									<label for="finput1">Imię</label>
									<input type="text" class="form-control" id="finput1" name="imie">
								</div>
								<div class="form-group">
									<label for="finput2">Nazwisko</label>
									<input type="text" class="form-control" id="finput2" name="nazwisko">
								</div>
								<div class="form-group">
									<label for="finput3">PESEL</label>
									<input type="text" class="form-control" id="finput3" name="pesel">
								</div>
								<div class="form-group">
									<label for="finput4">Adres</label>
									<input type="text" class="form-control" id="finput4" name="adres">
								</div>
								<div class="form-group">
									<label for="finput5">Telefon</label>
									<input type="text" class="form-control" id="finput5" name="telefon">
								</div>
								<div class="form-group">
									<label for="finput6">Pensja</label>
									<input type="number" min="1" class="form-control" id="finput6" name="pensja">
								</div>
								<div class="form-group">
									<label for="fselect1">Stanowisko</label>
									<select class="form-control" id="fselect1" name="stanowisko" onchange="wybranoStanowisko()">
										<option value="pielęgniarka">Pielęgniarka</option>
										<option value="położna">Położna</option>
										<option value="asystent">Asystent</option>
										<option value="lekarz">Lekarz</option>
										<option value="laborant">Laborant</option>
										<option value="sanitariusz">Sanitariusz</option>
										<option value="salowy">Salowy</option>
										<option value="inne">Inne</option>
									</select>
								</div>
								<div class="form-group" id="inputSpecjalizacja" style="display: none">
									<label for="fselect2">Specjalizacja</label>
									<select class="form-control" id="fselect2" name="specjalizacja">
										<option value="laryngolog">Laryngolog</option>
										<option value="neurolog">Neurolog</option>
										<option value="kardiolog">Kardiolog</option>
										<option value="internista">Internista</option>
										<option value="dermatolog">Dermatolog</option>
										<option value="chirurg">Chirurg</option>
									</select>
								</div>
								<button type="submit" class="btn btn-primary">Zatwierdź</button>
							</form>';
							echo '<script>
							function wybranoStanowisko() {
								if(document.getElementById("fselect1").value == "lekarz") {
									document.getElementById("inputSpecjalizacja").style.display = "block";
								} else {
									document.getElementById("inputSpecjalizacja").style.display = "none";
								}
							}
							</script>';
					} elseif($action == 'processaddworker') {
						echo "<h1>Dodaj pracownika</h1>\n";
						$form_data_valid = false;
						if(isset($_POST['imie']) && isset($_POST['nazwisko']) && isset($_POST['pesel']) && isset($_POST['adres']) && isset($_POST['pensja'])) {
							if(is_numeric($_POST['pensja']) && $_POST['pensja'] > 0) {
								$form_data_valid = true;
							}												
						}
						if($form_data_valid == true) {
							$imie = $_POST['imie'];
							$nazwisko = $_POST['nazwisko'];
							$pesel = $_POST['pesel'];
							$adres = $_POST['adres'];							
							if(isset($_POST['telefon'])) $telefon = $_POST['telefon'];
							else $telefon = "";
							$pensja = $_POST['pensja'];		
							$stanowisko = $_POST['stanowisko'];
							$specjalizacja = $_POST['specjalizacja'];
							$sql_do1 = "INSERT INTO `osoby`(`imie`, `nazwisko`, `pesel`, `adres`, `telefon`) VALUES ('$imie', '$nazwisko', '$pesel', '$adres', '$telefon')";
							$sql_do2 = "INSERT INTO `pracownicy`(`stanowisko`, `pensja`, `pesel`) VALUES ('$stanowisko', '$pensja', '$pesel')";
							$sql_do3 = "INSERT INTO `lekarze`(`pesel`, `specjalizacja`) VALUES ('$pesel', '$specjalizacja')";
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
									if ($stanowisko == "lekarz") {
										if(!$result3 = $mysqli->query($sql_do3)) {
											echo '<div class="alert alert-danger" role="alert">
												<strong>Wystąpił błąd</strong><br>Numer błędu: '. $mysqli->errno .'<br>Opis: '. $mysqli->error .'
											</div>';
										} else {
											echo '<div class="alert alert-success" role="alert">
												<strong>Sukces</strong> Informacja o nowym pracowniku została pomyślnie wprowadzona do bazy danych.
											</div>';
										}
									} else {
										echo '<div class="alert alert-success" role="alert">
											<strong>Sukces</strong> Informacja o nowym pracowniku została pomyślnie wprowadzona do bazy danych.
										</div>';
									}									
								}								
							}
						} else {
							echo '<div class="alert alert-warning" role="alert">
									<strong>Ostrzeżenie</strong> W formularzu pojawyły się błędy. Wszystkie pola poza telefonem są wymagane. Pensja musi być liczbą większą od zera.
								</div>';
						}
					} elseif($action == 'payments') {
						echo '<h1>Lista wypłat</h1>';
						
						$sql = "SELECT * FROM wyplaty ORDER BY data DESC";
						$result = $mysqli->query($sql);
						
						if ($result->num_rows == 0) {
							echo '<div class="alert alert-info" role="alert">
								<strong>Informacja</strong> Nie dodano jeszcze żadnych wypłat do bazy danych.
							</div>';
						} else {
							echo "<table>\n<tr><th>Data</th><th>Kwota</th><th>PESEL</th></tr>\n";							
							while ($row = $result->fetch_assoc()) {
								echo "<tr><td>". $row['data'] ."</td><td>". $row['kwota'] ."</td><td>". $row['pracownicy_pesel'] ."</td></tr>\n";
							}
							print_r($row);
							echo "</table>\n";
						}
					} elseif($action == 'addpayment') {
						echo "<h1>Nowa wypłata</h1>";

						$sql = "SELECT pesel FROM pracownicy";
						$result = $mysqli->query($sql);
						
						if ($result->num_rows == 0) {
							echo '<div class="alert alert-info" role="alert">
								<strong>Informacja</strong> Brak informacji o pracownikach w bazie danych, więc nie można zlecić żadnych wypłat.
							</div>';
						} else {
							$sql = "SELECT o.imie, o.nazwisko, p.pesel, p.pensja FROM osoby o JOIN pracownicy p ON o.pesel=p.pesel ORDER BY o.nazwisko";
							$result = $mysqli->query($sql);
							$pracownicy=array();						
							while ($row = $result->fetch_assoc()) {
								array_push($pracownicy, array($row['imie'], $row['nazwisko'], $row['pesel'], $row['pensja']));
							}
							echo '<script>
	
							var dict = {};';
							foreach ($pracownicy as &$entry) {
								echo 'dict.p' .  $entry[2] . ' = ' . $entry[3] . ';';
							}
							
							echo 'function ustawKwoteWyplaty() {
								tpesel = document.getElementById("fselect1").value;
								pensja = dict["p" + tpesel];
								document.getElementById("finput1").value = pensja.toString();
							}

							window.onload = function(){ 
								ustawKwoteWyplaty();
							}
							</script>';
							echo '<form action="./personnel.php?action=processaddpayment" method="post">
									<div class="form-group">
										<label for="fselect1">Wybierz pracownika</label>
										<select class="form-control" id="fselect1" name="pesel" onchange="ustawKwoteWyplaty()">';
										foreach ($pracownicy as &$entry) {
											echo '<option value="'. $entry[2] .'">'. $entry[0] . ' ' . $entry[1] . ' (' . $entry[2] .')</option>';
										}
							echo '</select>
									</div>
									<div class="form-group">
										<label for="finput1">Kwota podstawowa</label>
										<input type="number" class="form-control" id="finput1" name="kwota" readonly>
									</div>
									<div class="form-group">
									<label for="finput2">Premia</label>
									<input type="number" min="0" class="form-control" id="finput2" name="premia" value="0">
								</div>
									<button type="submit" class="btn btn-primary">Zatwierdź</button>
								</form>';
						}
					} elseif($action == 'processaddpayment') {
						echo "<h1>Nowa wypłata</h1>\n";
						$form_data_valid = false;
						if(isset($_POST['kwota']) && isset($_POST['premia'])) {
							if(is_numeric($_POST['premia']) && $_POST['premia'] >= 0) {
								$form_data_valid = true;
							}
						}
						if($form_data_valid == true) {
							$data = date('Y-m-d');
							$pesel = $_POST['pesel'];
							$kwota = $_POST['kwota'] + $_POST['premia'];
							$sql_do1 = "INSERT INTO `wyplaty`(`data`, `kwota`, `pracownicy_pesel`) VALUES ('$data', '$kwota' , $pesel)";
							if (!$result1 = $mysqli->query($sql_do1)) {
							echo '<div class="alert alert-danger" role="alert">
									<strong>Wystąpił błąd bazy danych!</strong><br>Numer błędu: '. $mysqli->errno .'<br>Opis: '. $mysqli->error .'
								</div>';
							} else {
								echo '<div class="alert alert-success" role="alert">
									<strong>Sukces</strong> Informacja o zleconej wypłacie została pomyślnie zapisana w bazie danych!
								</div>';
							}
						} else {
							echo '<div class="alert alert-warning" role="alert">
									<strong>Ostrzeżenie</strong> W formularzu wprowadzono nieprawidłową wartość premii.
								</div>';
						}
					}
					
					?>
				</div>
			</div>

		</main>
		
	</body>
</html>
