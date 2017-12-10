<?php

// Global variables
$db_server = 'localhost';
$db_user = 'bart494_admin2';
$db_password = 'TvUurftbBeHp';
$db_name = 'bart494_szpitaltest2';

// Database connection

$mysqli = new mysqli($db_server, $db_user, $db_password, $db_name);

if ($mysqli->connect_errno) {    
    echo "ERROR\nFailed to make a MySQL connection. Details below:\n";
    echo $mysqli->connect_errno . "\n";
    echo $mysqli->connect_error . "\n";
    exit;
}

?>