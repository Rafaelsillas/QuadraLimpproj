<?php
// Inclua seu arquivo de conexão com o banco de dados e outras configurações necessárias
require_once('conecta.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['postagem_id'])) {
        $postagem_id = $_POST['postagem_id'];

        // Certifique-se de validar e limpar os dados do motivo recebidos via POST
        $motivo = isset($_POST['motivo']) ? mysqli_real_escape_string($conexao, $_POST['motivo']) : '';

        // Verifique se o motivo foi fornecido
        if (empty($motivo)) {
            // Se o motivo estiver vazio, retorne um erro
            $response = ['status' => 'error', 'message' => 'Por favor, forneça um motivo para a denúncia.'];
        } else {
            $consulta = "SELECT * FROM postagens WHERE cod_mensagem = $postagem_id";
            $current_time = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
            $current_time_str = $current_time->format('Y-m-d H:i:s');
            // Executar a consulta
            $resultado = $conexao->query($consulta);
            $postagem = $resultado->fetch_assoc();

            // Agora, você pode acessar os campos da postagem, por exemplo:
            $mensagem = $postagem['mensagem'];
            $imagem = $postagem['imagem'];
            $idAutor = $postagem['id_pessoa'];

            $imagem = isset($postagem['imagem']) ? $postagem['imagem'] : null;

            // Insira a denúncia no banco de dados
            $inserirDenuncia = "INSERT INTO denuncias (id_usuario, id_autor, tipo_entidade, id_entidade, motivo, conteudo, imagem_conteudo, data_denuncia) VALUES (?, ?, 'Postagem', ?,?,?,?, '$current_time_str')";
            $stmt = $conexao->prepare($inserirDenuncia);
            $stmt->bind_param("iiisss", $_SESSION['id'], $idAutor, $postagem_id, $motivo, $mensagem, $imagem);

            if ($stmt->execute()) {
                // A denúncia foi inserida com sucesso
                $response = ['status' => 'success', 'message' => 'Denúncia realizada com sucesso! Obrigado por nos informar.'];
            } else {
                // Ocorreu um erro ao inserir a denúncia
                $response = ['status' => 'error', 'message' => 'Erro ao realizar a denúncia. Por favor, tente novamente mais tarde.', 'error_details' => $stmt->error];
            }
        }

        // Defina o cabeçalho Content-Type como application/json
        header('Content-Type: application/json');

        // Retorne o resultado em formato JSON
        echo json_encode($response);
        exit; // Adicione esta linha para evitar que o restante do código seja executado desnecessariamente
    }
}
