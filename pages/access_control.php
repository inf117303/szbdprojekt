<?php
include '../components/globals.php';
include '../components/check_session.php';

if(isset($_GET['option'])) {
	$option = $_GET['option'];
} else {
	$option = 'rooms';
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
					<li class="nav-item">
						<a class="nav-link" href="./resources.php">Zasoby</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="./personnel.php">Personel</a>
					</li>
					<li class="nav-item active">
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
						<a href="./access_control.php?option=rooms" class="list-group-item list-group-item-action <?php echo ($option == 'rooms' ? 'active' : ''); ?>">Pomieszczenia</a>
						<a href="./access_control.php?option=access_cards" class="list-group-item list-group-item-action <?php echo ($option == 'access_cards' || $option == 'modify_access_card' ? 'active' : ''); ?>">Karty dostępu</a>
						<a href="./access_control.php?option=add_access_card" class="list-group-item list-group-item-action <?php echo (($option == 'add_access_card' || $option == 'process_add_access_card') ? 'active' : ''); ?>">Nowa karta dostępu</a>
					</div>
				</div>
				<div class="col-sm-1">
					
				</div>
				<div class="col-sm-8">
					
					<?php
					if($option == 'rooms') {
						echo '<h1>Pomieszczenia szpitalne</h1>';
						
						$sql = "SELECT * FROM pomieszczenia ORDER BY nr";
						$result = $mysqli->query($sql);
						if ($result->num_rows == 0) {
							echo '<div class="alert alert-info" role="alert">
								<strong>Informacja</strong> Nie wprowadzono jeszcze żadnych pomieszczeń do bazy danych.
							</div>';
						} else {
							echo "<table>\n<tr><th>Numer pomieszczenia</th><th>Typ pomieszczenia</th></tr>\n";							
							while ($row = $result->fetch_assoc()) {
								echo "<tr><td>". $row['nr'] ."</td><td>". $row['typ_pomieszczenia'] ."</td></tr>\n";
							}
							echo "</table>\n";
						}
					} elseif($option == 'access_cards') {
						echo '<h1>Wykaz kart dostępu</h1>';
						
						$sql = "SELECT * FROM karty_dostepu ORDER BY numer";
						$result = $mysqli->query($sql);
						
						if ($result->num_rows == 0) {
							echo '<div class="alert alert-info" role="alert">
								<strong>Informacja</strong> Nie wprowadzono jeszcze żadnych kart dostępu do bazy danych.
							</div>';
						} else {
							echo "<table>\n<tr><th>Numer karty</th><th>Posiadacz</th><th>Opcje</th></tr>\n";							
							while ($row = $result->fetch_assoc()) {
								$tpesel = $row['pracownicy_pesel'];
								$sql2 = "SELECT imie, nazwisko FROM osoby WHERE pesel=$tpesel";
								$result2 = $mysqli->query($sql2);
								$row2 = $result2->fetch_assoc();

								$opcje = '<form style="display: inline-block" action="./access_control.php?option=modify_access_card" method="post">
								<input type="hidden" name="cardnumber" value="'. $row['numer'] .'">
								<button type="submit" class="btn btn-primary btn-sm">Modyfikuj</button>
								</form> 
								<form style="display: inline-block" action="./access_control.php?option=delete_access_card" method="post">
								<input type="hidden" name="cardnumber" value="'. $row['numer'] .'">
								<button type="submit" class="btn btn-primary btn-sm">Usuń</button>
								</form>';

								echo "<tr><td>". $row['numer'] ."</td><td>". $row2['imie'] ." ". $row2['nazwisko'] ."(". $row['pracownicy_pesel'] .")</td><td>".$opcje."</td></tr>\n";
							}
							echo "</table>\n";
						}
					} elseif($option == 'add_access_card') {
						echo "<h1>Dodaj nową kartę dostępu</h1>";
						
						echo '<form action="./access_control.php?option=process_add_access_card" method="post">
								<div class="form-group">
									Jeśli chcesz dodać utworzyć nową kartę dostępu, kliknij poniższy przycisk.
									<input type="hidden" name="confirmation" value="yes">									
								</div>
								<button type="submit" class="btn btn-primary">Dodaj nową kartę</button>
							</form>';
					} elseif($option == 'modify_access_card') {
						echo "<h1>Modyfikacja karty dostępu</h1>\n";

						$tnumerkarty = $_POST['cardnumber'];
						$sql = "SELECT pracownicy_pesel FROM karty_dostepu WHERE numer=$tnumerkarty";
						$result = $mysqli->query($sql);
						$row = $result->fetch_assoc();
						$tpesel = $row['pracownicy_pesel'];

						$sql = "SELECT * FROM pomieszczenia";
						$result = $mysqli->query($sql);
						$pomieszczenia=array();						
						while ($row = $result->fetch_assoc()) {
							array_push($pomieszczenia, array($row['nr'], $row['typ_pomieszczenia']));
						}

						$sql = "SELECT pomieszczenie_nr FROM karta_dostepu_pomieszczenie WHERE karta_dostepu_numer=$tnumerkarty AND karta_dostepu_pracownicy_pesel=$tpesel";
						$result = $mysqli->query($sql);
						$zezwolenia=array();						
						while ($row = $result->fetch_assoc()) {
							array_push($zezwolenia, $row['pomieszczenie_nr']);
						}

						$sql = "SELECT pesel FROM pracownicy";
						$result = $mysqli->query($sql);
						$pracownicy=array();						
						while ($row = $result->fetch_assoc()) {
							array_push($pracownicy, $row['pesel']);
						}
						
						echo '<form action="./access_control.php?option=process_modify_access_card" method="post">
						<div class="form-group">
						<label for="fselect1">Posiadacz karty</label>
						<select class="form-control" id="fselect1" name="posiadacz">';
						foreach ($pracownicy as &$entry) {
							if($entry == $tpesel) {
								$param_selected = "selected";
							} else {
								$param_selected = "";
							}
							echo '<option value="'. $entry .'" '.$param_selected.'>'. $entry .'</option>';
						}
						echo '</select>
						</div>
								<div class="form-group">
									<label>Dozwolony dostęp do:</label>';
									foreach ($pomieszczenia as &$entry) {
										if(array_search($entry[0], $zezwolenia) != false) {
											$param_checked = "checked";
										} else {
											$param_checked = "";
										}
										echo '<div class="form-check">
											<input class="form-check-input" type="checkbox" name="zezwolenia" id="fradio'. $entry[0] .'" value="'. $entry[0] .'" '.$param_checked.'>
											<label class="form-check-label" for="fradio'. $entry[0] .'">
											Pomieszczenie nr '. $entry[0] .' (' . $entry[1] . ')
											</label>
										</div>';
									}
						echo '</div>
								<button type="submit" class="btn btn-primary">Zapisz zmiany</button>
							</form>';
					}
					
					?>
				</div>
			</div>

		</main>
		
	</body>
</html>
