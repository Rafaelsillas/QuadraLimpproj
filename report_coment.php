<?php
require_once('conecta.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment_id'])) {
        $comment_id = $_POST['comment_id'];

        // Certifique-se de validar e limpar os dados do motivo recebidos via POST
        $motivo = isset($_POST['motivo']) ? mysqli_real_escape_string($conexao, $_POST['motivo']) : '';
        $consulta = "SELECT * FROM comentarios WHERE id = $comment_id";

        // Executar a consulta
        $resultado = $conexao->query($consulta);
        $comentario = $resultado->fetch_assoc();

        // Agora, você pode acessar os campos da postagem, por exemplo:
        $conteudo_comentario = $comentario['comentario'];
        $idAutor = $comentario['usuario_id'];

        // Insira a denúncia no banco de dados
        $inserirDenuncia = "INSERT INTO denuncias (id_usuario, id_autor, tipo_entidade, id_entidade, motivo, conteudo) VALUES (?, ?, 'Comentario', ?, ?, ?)";
        $stmt = $conexao->prepare($inserirDenuncia);
        $stmt->bind_param("iiiss", $_SESSION['id'], $idAutor, $comment_id, $motivo, $conteudo_comentario);

        if ($stmt->execute()) {
            // A denúncia foi inserida com sucesso
            $response = ['status' => 'success', 'message' => 'Denúncia realizada com sucesso! Obrigado por nos informar.'];
        } else {
            // Ocorreu um erro ao inserir a denúncia
            $response = ['status' => 'error', 'message' => 'Erro ao realizar a denúncia. Por favor, tente novamente mais tarde.', 'error_details' => $stmt->error];
        }

        // Defina o cabeçalho Content-Type como application/json
        header('Content-Type: application/json');

        // Retorne o resultado em formato JSON
        echo json_encode($response);
        exit; // Adicione esta linha para evitar que o restante do código seja executado desnecessariamente
    }
}
