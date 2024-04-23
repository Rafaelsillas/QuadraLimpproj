<?php
require_once('conecta.php');
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['comment_id'])) {
    $commentId = $_GET['comment_id'];

    // Coloque a lógica para excluir o comentário no banco de dados
    $deleteCommentQuery = "DELETE FROM comentarios WHERE id = ?";
    $stmt = $conexao->prepare($deleteCommentQuery);
    $stmt->bind_param("i", $commentId);
    $stmt->execute();
}
