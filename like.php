<?php
session_start();
require_once('conecta.php');

if (isset($_POST['postagem_id'])) {
    $postagemId = $_POST['postagem_id'];
    $pessoaId = $_SESSION['id'];

    // Verifique se o usuário já deu like nesta postagem
    $verificar = "SELECT * FROM likes WHERE post_id = $postagemId AND user_id = $pessoaId";
    $resultadoVerificacao = mysqli_query($conexao, $verificar);

    if (mysqli_num_rows($resultadoVerificacao) == 0) {
        // Insira o novo like na tabela de likes
        $inserirLike = "INSERT INTO likes (post_id, user_id) VALUES ($postagemId, $pessoaId)";
        $resultadoInsercao = mysqli_query($conexao, $inserirLike);

        if ($resultadoInsercao) {
            // Atualize o contador de likes na tabela de postagens
            $atualizarLikesCount = "UPDATE postagens SET likes_count = likes_count + 1 WHERE cod_mensagem = $postagemId";
            $resultadoAtualizacao = mysqli_query($conexao, $atualizarLikesCount);

            if ($resultadoAtualizacao) {
                // Obtenha o novo contador de likes
                $novoLikesCount = getLikesCount($conexao, $postagemId);

                // Resposta de sucesso para o JavaScript
                echo json_encode(['success' => true, 'likeAdded' => true, 'likesCount' => $novoLikesCount]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erro ao atualizar contador de likes.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao inserir like.']);
        }
    } else {
        // O usuário já deu like nesta postagem, vamos remover o like
        $removerLike = "DELETE FROM likes WHERE post_id = $postagemId AND user_id = $pessoaId";
        $resultadoRemocao = mysqli_query($conexao, $removerLike);

        if ($resultadoRemocao) {
            // Atualize o contador de likes na tabela de postagens
            $atualizarLikesCount = "UPDATE postagens SET likes_count = likes_count - 1 WHERE cod_mensagem = $postagemId";
            $resultadoAtualizacao = mysqli_query($conexao, $atualizarLikesCount);

            if ($resultadoAtualizacao) {
                // Obtenha o novo contador de likes
                $novoLikesCount = getLikesCount($conexao, $postagemId);

                // Resposta de sucesso para o JavaScript
                echo json_encode(['success' => true, 'likeAdded' => false, 'likesCount' => $novoLikesCount]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erro ao atualizar contador de likes.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao remover like.']);
        }
    }
}

// Função auxiliar para obter o contador de likes de uma postagem
function getLikesCount($conexao, $postagemId) {
    $consulta = "SELECT likes_count FROM postagens WHERE cod_mensagem = $postagemId";
    $resultadoConsulta = mysqli_query($conexao, $consulta);
    $row = mysqli_fetch_assoc($resultadoConsulta);
    return $row['likes_count'];
}
?>