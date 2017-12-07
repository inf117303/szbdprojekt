<?php

if(isset($_COOKIE['WebmasterSavedLogin']) && isset($_COOKIE['WebmasterSavedPassword'])) {
	$check_login = $_COOKIE['WebmasterSavedLogin'];
	$check_password = $_COOKIE['WebmasterSavedPassword'];
	$cookies_exists = true;
} else {    
	$cookies_exists = false;
}

if($cookies_exists == false) {
	//No cookies found
	header('Location: http://managehospital.ga/index.php?err=3');
	exit;
}

$mysqli = new mysqli('localhost', 'bart494_admin2', 'TvUurftbBeHp', 'bart494_szpitaltest2');

if ($mysqli->connect_errno) {    
    echo "ERROR\nFailed to make a MySQL connection. Details below:\n";
    echo $mysqli->connect_errno . "\n";
    echo $mysqli->connect_error . "\n";
    exit;
}

$sql = "SELECT id FROM webmasters WHERE login='$check_login' AND password='$check_password'";
if (!$result = $mysqli->query($sql)) {
    echo "ERROR\nQuery failed to execute and here is why: \n";
    echo $mysqli->errno . "\n";
    echo $mysqli->error . "\n";
    exit;
}

if ($result->num_rows == 0) {
    //Wrong data in cookies or session has expired
	header('Location: http://managehospital.ga/index.php??err=4');
	exit;
} else {
	// odśwież ciasteczka
	setcookie("WebmasterSavedLogin", "$check_login", time()+3600, "/");
	setcookie("WebmasterSavedPassword", "$check_password", time()+3600, "/");
}


?>