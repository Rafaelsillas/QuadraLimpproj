<?php
// adicionar_comentario.php
session_start();
require_once('conecta.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postagem_id = $_POST['postagem_id'];
    $comentario = $_POST['comentario'];
    $usuario_id = $_SESSION['id'];

    $consultaPunicao = "SELECT punido_at FROM login WHERE id = '$usuario_id'";
    $resultadoPunicao = mysqli_query($conexao, $consultaPunicao);
    $punicao = mysqli_fetch_assoc($resultadoPunicao);
    $current_time = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $current_time_str = $current_time->format('Y-m-d H:i:s');

    if ($punicao['punido_at'] !== null && $punicao['punido_at'] > $current_time_str) {
        echo json_encode(['status' => 'error', 'message' => 'Você está punido e não pode adicionar comentários neste momento.']);
        exit();
    }

    if ($comentario != "") {
        // Preparar uma instrução SQL segura
        $inserirComentario = $conexao->prepare("INSERT INTO comentarios (postagem_id, usuario_id, comentario) VALUES (?, ?, ?)");

        // Vincular parâmetros e seus tipos
        $inserirComentario->bind_param("iis", $postagem_id, $usuario_id, $comentario);

        // Executar a instrução
        $resultadoInserir = $inserirComentario->execute();

        $inserirComentario->close();

        if ($resultadoInserir) {
            echo json_encode(['status' => 'success', 'message' => 'Comentário adicionado com sucesso.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Problemas ao adicionar o comentário.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'O campo de comentário está vazio.']);
    }
}
