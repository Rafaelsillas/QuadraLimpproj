<?php
session_start();
require_once('conecta.php');

// Verifica se o usuário está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: index.php'); // Redireciona para a página inicial
    exit();
}

// Obtém o ID do usuário da sessão
$userID = $_SESSION['id'];

// Lógica para excluir a conta do usuário
$sql = "DELETE FROM login WHERE id = '$userID'";
if ($conexao->query($sql)) {
    // Se a exclusão for bem-sucedida, redirecione para a página de login
    session_destroy(); // Destroi a sessão do usuário
    header('Location: login.php');
    exit();
} else {
    // Se a exclusão falhar, exiba uma mensagem de erro
    echo "Erro ao excluir a conta.";
}
?>