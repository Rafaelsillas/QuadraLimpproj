<?php
require "conecta.php"; // Include your database connection code

$currentTimestamp = time();
$timeLimit = 5 * 60; // 5 minutes in seconds

$deleteThreshold = date("Y-m-d H:i:s", $currentTimestamp - $timeLimit);

$query = "DELETE FROM login WHERE valido = 'n' AND registro_timestamp < ?";
$stmt = $conexao->prepare($query);
$stmt->bind_param("s", $deleteThreshold);
$stmt->execute();

$stmt->close();
?>