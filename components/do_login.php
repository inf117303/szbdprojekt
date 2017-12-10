<?php

include './globals.php';

if (isset($_POST['login']) && isset($_POST['password'])) {
    $check_login = $_POST['login'];
	$check_password = $_POST['password'];
	$data_sent = true;
} else {
    $data_sent = false;
}

if($data_sent == false) {
	//No form post data received
	header('Location: http://managehospital.ga/index.php?err=0');
	exit;
}

if($check_login == "" || $check_password == "") {
	//Empty strings
	header('Location: http://managehospital.ga/index.php?err=1');
	exit;
}

$sql = "SELECT id FROM webmasters WHERE login='$check_login' AND password='$check_password'";
if (!$result = $mysqli->query($sql)) {
    echo "ERROR\nQuery failed to execute and here is why: \n";
    echo $mysqli->errno . "\n";
    echo $mysqli->error . "\n";
    exit;
}

if ($result->num_rows == 1) {
    setcookie("WebmasterSavedLogin", "$check_login", time()+3600, "/");
	setcookie("WebmasterSavedPassword", "$check_password", time()+3600, "/");
	header('Location: http://managehospital.ga/pages/summary.php');
	exit;
} else {
	//Login or password is invalid
	header('Location: http://managehospital.ga/index.php?err=2');
	exit;
}


?>