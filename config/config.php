<?php
$servername = "localhost";
$username = "root";
$password = '';
$db_name = 'travel_agency_db';

$mysqli = new mysqli($servername, $username, $password, $db_name);

if ($mysqli->connect_error) {
    die('connection failed' . $conn->connect_error);
} else {
     //echo "connection established";
}