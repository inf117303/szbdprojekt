<?php

// Global variables
$db_server = 'localhost';
$db_user = 'bart494_admin3';
$db_password = '8TKgqpZg6WJe';
$db_name = 'bart494_szpitalpr';

// Database connection

$mysqli = new mysqli($db_server, $db_user, $db_password, $db_name);

if ($mysqli->connect_errno) {    
    echo "ERROR\nFailed to make a MySQL connection. Details below:\n";
    echo $mysqli->connect_errno . "\n";
    echo $mysqli->connect_error . "\n";
    exit;
}

$mysqli->set_charset("utf8");
$mysqli->query("SET collation_connection = utf8_polish_ci");

?>