<!doctype html>
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" type="image/png" href="../images/website_icon.png">

		<title>Logowanie &bull; Manage Hospital</title>

		<!-- Bootstrap core CSS -->
		<link href="./css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="./css/common_style.css" rel="stylesheet">
		
		<!-- Bootstrap core JavaScript -->
		<script src="./js/jquery-3.2.1.min.js"></script>
		<script src="./js/popper.min.js"></script>
		<script src="./js/bootstrap.min.js"></script>
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
						<a class="nav-link" href="./">Logowanie</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link 1</a>
					</li>
				</ul>
			</div>
		</nav>
		
		<main class="container">
			<div class="row">
				<div class="col-sm-3">
					
				</div>
				<div class="col-sm-6">
					<form action="./components/do_login.php" method="post">
						<h2>Logowanie do systemu</h2>
						<div class="form-group">
							<label for="exampleInputText1">Login</label>
							<input type="text" class="form-control" id="exampleInputText1" aria-describedby="textHelp" placeholder="Twój login" name="login">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Hasło</label>
							<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Twoje hasło" name="password">
						</div>
						<button type="submit" class="btn btn-primary">Zaloguj się</button>
					</form>
				</div>
				<div class="col-sm-3">
					
				</div>
			</div>
		</main>
		
		<?php
		
		if(isset($_GET['err'])) {
			$error_code = $_GET['err'];
			switch ($error_code) {
				case 0:
					echo "<script>\nsetTimeout(function(){ alert(\"Error: No data received!\"); }, 100);\n</script>";
					break;
				case 1:
					echo "<script>\nsetTimeout(function(){ alert(\"Error: Login or password field cannot be left empty!\"); }, 100);\n</script>";
					break;
				case 2:
					echo "<script>\nsetTimeout(function(){ alert(\"Error: Login or password is invalid!\"); }, 100);\n</script>";
					break;
				case 3:
					echo "<script>\nsetTimeout(function(){ alert(\"Error: No cookies found that means no valid session.\"); }, 100);\n</script>";
					break;
				case 4:
					echo "<script>\nsetTimeout(function(){ alert(\"Error: Wrong data in cookies or your session has expired.\"); }, 100);\n</script>";
					break;
			}
		}
		
		?>
		
	</body>
</html>
