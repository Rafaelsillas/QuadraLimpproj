<?php
require_once('conecta.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postagem_id'])) {
    $postagem_id = $_POST['postagem_id'];

    // Execute a lógica de exclusão da postagem aqui, por exemplo:
    $sql = "DELETE FROM postagens WHERE cod_mensagem = $postagem_id";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado) {
        // Envie uma resposta JSON indicando que a exclusão foi bem-sucedida
        echo json_encode(['success' => true]);
        exit;
    }
}

// Envie uma resposta JSON indicando que ocorreu um problema
echo json_encode(['success' => false]);
