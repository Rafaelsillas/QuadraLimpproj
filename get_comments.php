<?php
require_once('conecta.php');
session_start();

if (isset($_GET['postagem_id'])) {
    $postagem_id = $_GET['postagem_id'];

    // Coloque a lógica para buscar os comentários relacionados a essa postagem no banco de dados
    $consultaComentarios = "SELECT comentarios.*, login.nome, login.id as usuario_id, login.tipo FROM comentarios
                           JOIN login ON comentarios.usuario_id = login.id
                           WHERE comentarios.postagem_id = ?
                           ORDER BY comentarios.data_comentario DESC";
    $stmt = $conexao->prepare($consultaComentarios);
    $stmt->bind_param("i", $postagem_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = [
            'id' => $row['id'],
            'nome' => $row['nome'],
            'comentario' => $row['comentario'],
            'data_comentario' => $row['data_comentario'],
            'usuario_id' => $row['usuario_id'],
            'isCommentAuthor' => ($_SESSION['id'] == $row['usuario_id']),
            'tipo' => $_SESSION['tipo'], // Adicione o tipo do usuário aos dados do comentário
        ];
    }

    // Adicione a informação sobre o usuário dono da postagem
    $consultaPostagem = "SELECT id_pessoa FROM postagens WHERE cod_mensagem = ?";
    $stmtPostagem = $conexao->prepare($consultaPostagem);
    $stmtPostagem->bind_param("i", $postagem_id);
    $stmtPostagem->execute();
    $resultPostagem = $stmtPostagem->get_result();
    $postagem = $resultPostagem->fetch_assoc();
    $isPostOwner = ($_SESSION['id'] == $postagem['id_pessoa']);

    // Defina o cabeçalho Content-Type como application/json
    header('Content-Type: application/json');

    // Retorne os comentários e informações adicionais em formato JSON
    echo json_encode(['comments' => $comments, 'isPostOwner' => $isPostOwner]);
}
