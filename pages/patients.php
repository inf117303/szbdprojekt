<?php
include '../components/globals.php';
include '../components/check_session.php';

if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = 'patients_list';
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

		<title>Pacjenci &bull; Manage Hospital</title>

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
					<li class="nav-item">
						<a class="nav-link" href="./personnel.php">Personel</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="./access_control.php">Kontrola dostępu</a>
					</li>
					<li class="nav-item active">
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
				<div class="col-sm-3">
					<div class="list-group">
						<a href="./patients.php?action=patients_list" class="list-group-item list-group-item-action <?php echo ($action == 'patients_list' ? 'active' : ''); ?>">Lista pacjentów</a>
						<a href="./patients.php?action=add_patient" class="list-group-item list-group-item-action <?php echo (($action == 'add_patient' || $action == 'process_add_patient') ? 'active' : ''); ?>">Nowy pacjent</a>
						<a href="./patients.php?action=therapies" class="list-group-item list-group-item-action <?php echo ($action == 'therapies' ? 'active' : ''); ?>">Terapie</a>
						<a href="./patients.php?action=add_therapy" class="list-group-item list-group-item-action <?php echo (($action == 'add_therapy' || $action == 'process_add_therapy') ? 'active' : ''); ?>">Nowa terapia</a>
						<a href="./patients.php?action=discharge_patient" class="list-group-item list-group-item-action <?php echo (($action == 'discharge_patient' || $action == 'process_discharge_patient') ? 'active' : ''); ?>">Wypisz pacjenta</a>
					</div>
				</div>
				<div class="col-sm-1">
					
				</div>
				<div class="col-sm-8">
					
					<?php
					if($action == 'patients_list') {
						echo '<h1>Lista pacjentów</h1>';
						
						$sql = "SELECT * FROM osoby o JOIN pacjenci p ON o.pesel=p.pesel JOIN rejestracje r ON r.pacjenci_pesel=p.pesel ORDER BY nazwisko";
						$result = $mysqli->query($sql);
						if ($result->num_rows == 0) {
							echo '<div class="alert alert-info" role="alert">
								<strong>Informacja</strong> Nie wprowadzono jeszcze żadnych informacji o pacjentach.
							</div>';
						} else {
                            echo "<table>\n<tr><th>Imię</th><th>Nazwisko</th><th>PESEL</th><th>Telefon</th><th>Adres</th><th>Wypis:</th></tr>\n";
							while ($row = $result->fetch_assoc()) {
								if($row['data_wypisu'] == NULL) $data_wypisu = "(w trakcie leczenia)"; else $data_wypisu = $row['data_wypisu'];
								echo "<tr><td>". $row['imie'] ."</td><td>". $row['nazwisko'] ."</td><td>". $row['pesel'] ."</td><td>". $row['telefon'] ."</td><td>". $row['adres'] ."</td><td>". $data_wypisu ."</td></tr>\n";
							}
							echo "</table>\n";
						}
					} elseif($action == 'add_patient') {
						echo "<h1>Nowy pacjent</h1>";
						
						echo '<form action="./patients.php?action=process_add_patient" method="post">
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
								<button type="submit" class="btn btn-primary">Zatwierdź</button>
							</form>';
					} elseif($action == 'process_add_patient') {
						echo "<h1>Dodaj pacjenta</h1>\n";
						$form_data_valid = false;
						if(isset($_POST['imie']) && isset($_POST['nazwisko']) && isset($_POST['pesel']) && isset($_POST['adres'])) {
							$form_data_valid = true;											
						}
						if($form_data_valid == true) {
							$imie = $_POST['imie'];
							$nazwisko = $_POST['nazwisko'];
							$pesel = $_POST['pesel'];
							$adres = $_POST['adres'];							
							if(isset($_POST['telefon'])) $telefon = $_POST['telefon'];
                            else $telefon = "";
                            $data = date('Y-m-d');
							$sql_do1 = "INSERT INTO `osoby`(`imie`, `nazwisko`, `pesel`, `adres`, `telefon`) VALUES ('$imie', '$nazwisko', '$pesel', '$adres', '$telefon')";
                            $sql_do2 = "INSERT INTO `pacjenci`(`pesel`) VALUES ('$pesel')";
                            $sql_do3 = "INSERT INTO `rejestracje`(`data`,`pacjenci_pesel`,`data_wypisu`) VALUES ('$data','$pesel',null)";
                            $result1 = $mysqli->query($sql_do1);
                            if($result1) $result2 = $mysqli->query($sql_do2);
                            if($result1 && $result2) $result3 = $mysqli->query($sql_do3);
							if (!$result1 || !$result2 || !$result3) {
								echo '<div class="alert alert-danger" role="alert">
										<strong>Wystąpił błąd bazy danych!</strong><br>Numer błędu: '. $mysqli->errno .'<br>Opis: '. $mysqli->error .'
									</div>';
							} else {
								echo '<div class="alert alert-success" role="alert">
                                        <strong>Sukces</strong> Informacja o nowym pacjencie została pomyślnie wprowadzona do bazy danych.
                                    </div>';							
							}
						} else {
							echo '<div class="alert alert-warning" role="alert">
									<strong>Ostrzeżenie</strong> W formularzu pojawiły się błędy. Wszystkie pola poza telefonem są wymagane.
								</div>';
						}
					} elseif($action == 'therapies') {
						echo '<h1>Historia przeprowadzonych terapii</h1>';
						
						$sql = "SELECT * FROM leczenia ORDER BY data DESC";
						$result = $mysqli->query($sql);
						
						if ($result->num_rows == 0) {
							echo '<div class="alert alert-info" role="alert">
								<strong>Informacja</strong> Nie dodano jeszcze żadnych informacji o terapiach do bazy danych.
							</div>';
						} else {
							echo "<table>\n<tr><th>Data</th><th>ID leczenia</th><th>Rozpoznanie</th><th>Pacjent</th><th>Lekarz</th></tr>\n";							
							while ($row = $result->fetch_assoc()) {
								echo "<tr><td>". $row['data'] ."</td><td>". $row['id_leczenia'] ."</td><td>". $row['nazwa_choroby'] ."</td><td>". $row['pacjenci_pesel'] ."</td><td>". $row['lekarz_pesel'] ."</td></tr>\n";
							}
							print_r($row);
							echo "</table>\n";
						}
					} elseif($action == 'add_therapy') {
						echo "<h1>Nowa terapia</h1>";

						$sql = "SELECT pesel FROM pacjenci";
						$result = $mysqli->query($sql);
						
						if ($result->num_rows == 0) {
							echo '<div class="alert alert-info" role="alert">
								<strong>Informacja</strong> Brak informacji o pacjentach w bazie danych, więc nie można przeprowadzić żadnych terapii.
							</div>';
						} else {					
							$pacjenci=array();						
							while ($row = $result->fetch_assoc()) {
								$tpesel = $row['pesel'];
								$sql2 = "SELECT imie, nazwisko FROM osoby WHERE pesel='$tpesel'";
								$result2 = $mysqli->query($sql2);
								$row2 = $result2->fetch_assoc();
								array_push($pacjenci, array($row2['imie'], $row2['nazwisko'], $tpesel));
							}
							
							$sql = "SELECT pesel FROM lekarze";
							$result = $mysqli->query($sql);
							$lekarze=array();						
							while ($row = $result->fetch_assoc()) {
								$tpesel = $row['pesel'];
								$sql2 = "SELECT imie, nazwisko FROM osoby WHERE pesel='$tpesel'";
								$result2 = $mysqli->query($sql2);
								$row2 = $result2->fetch_assoc();
								array_push($lekarze, array($row2['imie'], $row2['nazwisko'], $tpesel));
							}

							$sql = "SELECT * FROM leki_w_magazynie WHERE CAST(ilosc AS UNSIGNED) >= 14";
							$result = $mysqli->query($sql);
							$leki = array();
							while ($row = $result->fetch_assoc()) {
								array_push($leki, array($row['nazwa'], $row['ilosc'], $row['id_leku']));
							}

							echo "<h5>Wprowadź informacje na temat przeprowadzonej terapii.</h5>";
							
							echo '<form action="./patients.php?action=process_add_therapy" method="post">
									<div class="form-group">
										<label for="fselect1">Wybierz pacjenta</label>
										<select class="form-control" id="fselect1" name="pacjent" onchange="ustawKwoteWyplaty()">';
										foreach ($pacjenci as &$entrya) {
											echo '<option value="'. $entrya[2] .'">'. $entrya[0] . ' ' . $entrya[1] . ' (' . $entrya[2] .')</option>';
										}
							echo '</select>
									</div>
									<div class="form-group">
										<label for="finput1">Rozpoznanie (nazwa choroby)</label>
										<input type="rozpoznanie" class="form-control" id="finput1" name="rozpoznanie">
									</div>
									<div class="form-group">
										<label for="fselect2">Lekarz prowadzący</label>
										<select class="form-control" id="fselect2" name="lekarz" onchange="ustawKwoteWyplaty()">';
										foreach ($lekarze as &$entryb) {
											echo '<option value="'. $entryb[2] .'">'. $entryb[0] . ' ' . $entryb[1] . ' (' . $entryb[2] .')</option>';
										}
							echo '</select>
									</div>
									<div class="form-group">
										<label for="fselect3">Użyty lek</label>
										<select class="form-control" id="fselect3" name="lek" onchange="ustawKwoteWyplaty()">';
										foreach ($leki as &$entryc) {
											echo '<option value="'. $entryc[2] .'">'. $entryc[0] . ' (ilość: ' . $entryc[1] . ', ID: ' . $entryc[2] .')</option>';
										}
							echo '</select>
										<p><small>Każda terapia wymaga zastosowania 14 jednostek wybranego leku (pełne 2 tygodnie kuracji).
										Jeśli w magazynie znajduje się mniej niż 14 jednostek, wtedy lek nie wyświetla się na liście.</small></p>
									</div>
									<button type="submit" class="btn btn-primary">Zapisz</button>
								</form>';
						}
					} elseif($action == 'process_add_therapy') {
						echo "<h1>Nowa terapia</h1>\n";
						$form_data_valid = false;
						if(isset($_POST['rozpoznanie'])) {
							if(strlen($_POST['rozpoznanie']) > 0) {
								$form_data_valid = true;
							}							
						}
						if($form_data_valid == true) {
							$data = date('Y-m-d');
							$pacjent = $_POST['pacjent'];
							$rozpoznanie = $_POST['rozpoznanie'];
							$lekarz = $_POST['lekarz'];
							$lek = $_POST['lek'];
							$therapy_id = dechex(time());
							$sql_do1 = "INSERT INTO `leczenia`(`data`, `nazwa_choroby`, `pacjenci_pesel`, `id_leczenia`, `lekarz_pesel`) VALUES ('$data', '$rozpoznanie', '$pacjent' , '$therapy_id', '$lekarz')";
							$sql_do2 = "INSERT INTO `leczenie_leki_w_magazynie`(`zasob_id_leku`, `leczenie_pacjenci_pesel`, `leczenie_id_leczenia`) VALUES ('$lek', '$pacjent' , '$therapy_id')";
							$sql_do4 = 'SELECT CAST(ilosc AS UNSIGNED) INTO @oldamount FROM leki_w_magazynie WHERE id_leku=\'' . $lek .'\'; SET @newamount = @oldamount - 14; UPDATE leki_w_magazynie SET ilosc = CAST(@newamount AS CHAR) WHERE id_leku=\'' . $lek . '\';';
							$sql_do3 = "UPDATE rejestracje SET data_wypisu=NULL WHERE pacjenci_pesel=$pacjent";
							$result1 = $mysqli->query($sql_do1);
							if($result1) $result2 = $mysqli->query($sql_do2);
							if($result1 && $result2) $result3 = $mysqli->query($sql_do3);
							if($result1 && $result2 && $result3) $result4 = $mysqli->multi_query($sql_do4);
							if (!$result1 || !$result2 || !$result3 || !$result4) {
							echo '<div class="alert alert-danger" role="alert">
									<strong>Wystąpił błąd bazy danych!</strong><br>Numer błędu: '. $mysqli->errno .'<br>Opis: '. $mysqli->error .'
								</div>';
							} else {
								echo '<div class="alert alert-success" role="alert">
									<strong>Sukces</strong> Informacja o nowej terapii została pomyślnie zapisana w bazie danych!
								</div>';
							}
						} else {
							echo '<div class="alert alert-warning" role="alert">
									<strong>Ostrzeżenie</strong> W formularzu nie wypełniono pola Rozpoznanie.
								</div>';
						}
					} elseif($action == 'discharge_patient') {
						echo "<h1>Wypisz pacjenta ze szpitala</h1>";

						$sql = "SELECT imie, nazwisko, p.pesel FROM pacjenci p JOIN rejestracje r ON r.pacjenci_pesel=p.pesel JOIN osoby o ON p.pesel=o.pesel";
						$result = $mysqli->query($sql);
						
						if ($result->num_rows == 0) {
							echo '<div class="alert alert-info" role="alert">
								<strong>Informacja</strong> Brak informacji o pacjentach w bazie danych, więc nie można wykonać wypisu.
							</div>';
						} else {					
							$pacjenci=array();						
							while ($row = $result->fetch_assoc()) {
								array_push($pacjenci, array($row['imie'], $row['nazwisko'], $row['pesel']));
							}
							
							echo '<form action="./patients.php?action=process_discharge_patient" method="post">
									<div class="form-group">
										<label for="fselect1">Wybierz pacjenta, którego chcesz wypisać</label>
										<select class="form-control" id="fselect1" name="pacjent" onchange="ustawKwoteWyplaty()">';
										foreach ($pacjenci as &$entrya) {
											echo '<option value="'. $entrya[2] .'">'. $entrya[0] . ' ' . $entrya[1] . ' (' . $entrya[2] .')</option>';
										}
							echo '</select>
									</div>
									<button type="submit" class="btn btn-primary">Zatwierdź</button>
								</form>';
						}
					} elseif($action == 'process_discharge_patient') {
						echo "<h1>Wypisz pacjenta ze szpitala</h1>";

						$data = date('Y-m-d');
						$pacjent = $_POST['pacjent'];

						$sql_do = "UPDATE rejestracje SET data_wypisu='$data' WHERE pacjenci_pesel=$pacjent";
						$result = $mysqli->query($sql_do);

						if (!$result) {
						echo '<div class="alert alert-danger" role="alert">
								<strong>Wystąpił błąd bazy danych!</strong><br>Numer błędu: '. $mysqli->errno .'<br>Opis: '. $mysqli->error .'
							</div>';
						} else {
							echo '<div class="alert alert-success" role="alert">
								<strong>Sukces</strong> Pacjent został wypisany ze szpitala.
							</div>';
						}

					}
					
					?>
				</div>
			</div>

		</main>
		
	</body>
</html>
