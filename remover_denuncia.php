<?php
// remover_denuncia.php

require_once "conecta.php"; // Substitua com o caminho correto para o seu arquivo de configuração

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idDenuncia = $_POST['id_denuncia'];

    // Execute a lógica para remover a denúncia do banco de dados
    $removerDenunciaQuery = "DELETE FROM denuncias WHERE id_denuncia = '$idDenuncia'";

    if (mysqli_query($conexao, $removerDenunciaQuery)) {
        echo "Denúncia removida com sucesso!";
    } else {
        echo "Erro ao remover a denúncia: " . mysqli_error($conexao);
    }
} else {
    echo "Acesso não autorizado.";
}
