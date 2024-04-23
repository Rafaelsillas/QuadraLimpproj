<?php

$host = "localhost";
$dbname = "u277373511_tcc";
$username = "u277373511_midiatec";
$password = "Midia@2023";

$mysqli = new mysqli(
    hostname: $host,
    username: $username,
    password: $password,
    database: $dbname
);

if ($mysqli->connect_error) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;

?>