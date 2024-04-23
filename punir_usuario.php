<?php
require_once "conecta.php"; // Substitua com o caminho correto para o seu arquivo de configuração

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtenha os valores do JavaScript
    $idUsuario = $_POST['id_usuario'];
    $tempo = intval($_POST['tempoEmHoras']);
    $unidadeTempo = $_POST['unidadeTempo'];
    $motivo = $_POST['motivo'];
    $tipoEntidade = $_POST['tipoEntidade']; // Você precisa passar isso na sua requisição AJAX
    $idEntidade = $_POST['idEntidade']; // Você precisa passar isso na sua requisição AJAX

    // Verificar o tipo de entidade e realizar a ação apropriada
    if ($tipoEntidade === 'Postagem') {
        // Excluir a postagem do banco de dados
        $deleteQuery = "DELETE FROM postagens WHERE cod_mensagem = '$idEntidade'";
        mysqli_query($conexao, $deleteQuery);
    } elseif ($tipoEntidade === 'Comentario') {
        // Excluir o comentário do banco de dados
        $deleteQuery = "DELETE FROM comentarios WHERE id = '$idEntidade'";
        mysqli_query($conexao, $deleteQuery);
    }

    // Verifique se o tempo é válido (maior que 0)
    if ($tempo <= 0) {
        echo "O tempo de punição deve ser maior que 0.";
        exit();
    }

    // Lógica para aplicar a punição no banco de dados
    $current_time = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $current_time_str = $current_time->format('Y-m-d H:i:s');
    $punicaoTempoObj = clone $current_time;

    // Adicionar o tempo desejado
    $punicaoTempoObj->modify("+{$tempo} hours");
    $punicaoTempo = $punicaoTempoObj->format('Y-m-d H:i:s');
    $dataTerminoPunicao = $punicaoTempoObj->format('Y-m-d H:i:s');

    $updatePunicaoQuery = "UPDATE login SET punido_at = '$punicaoTempo' WHERE id = '$idUsuario'";
    mysqli_query($conexao, $updatePunicaoQuery);

    // Registrar a punição na tabela de punições com a data de término correta
    $inserirPunicaoQuery = "INSERT INTO punicoes (id_usuario, motivo, data_punicao) VALUES ('$idUsuario', '$motivo', '$dataTerminoPunicao')";
    mysqli_query($conexao, $inserirPunicaoQuery);



    echo "Usuário punido com sucesso!";
}
