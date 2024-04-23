<?php
require_once('conecta.php'); // Certifique-se de que esta linha corresponda ao caminho correto do seu arquivo de conexão


session_start();

$current_time = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
$current_time_str = $current_time->format('Y-m-d H:i:s');
$heartbeat = "UPDATE login SET online = NULL WHERE TIMESTAMPDIFF(SECOND, online, '$current_time_str') > 2"; // Defina o limite de tempo de inatividade (60 segundos)
$resultado = mysqli_query($conexao, $heartbeat);

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $update_query = "UPDATE login SET online = '$current_time_str' WHERE id = '$id'";
    mysqli_query($conexao, $update_query);
}
