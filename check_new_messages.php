<?php
session_start();
include("conecta.php");

if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $user_id = $_GET["id"];

    // Query para verificar se há novas mensagens não lidas
    $stmt = $conexao->prepare("SELECT COUNT(*) FROM chat WHERE Reciever = ? AND Unread = 'y'");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_row()[0];

    // Retornar 'true' se houver novas mensagens não lidas, caso contrário, 'false'
    echo $count > 0 ? 'true' : 'false';
}
?>