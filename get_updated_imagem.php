<?php
// Inicie a sessão para acessar as variáveis de sessão
session_start();

// Recupere a última data de atualização da imagem (isso pode estar armazenado no banco de dados)
$lastUpdatedTimestamp = $_SESSION['last_updated_timestamp'];

// Obtenha a URL da imagem atual do perfil
$currentProfileImageURL = 'profilePics/' . $_SESSION['picture'];

// Verifique se a imagem foi atualizada com base em um critério (por exemplo, data/hora diferente)
if (filemtime($currentProfileImageURL) > $lastUpdatedTimestamp) {
    // Se a imagem foi atualizada, atualize a variável de sessão com o novo carimbo de data/hora
    $_SESSION['last_updated_timestamp'] = filemtime($currentProfileImageURL);
    // Retorne a nova URL da imagem
    echo $currentProfileImageURL . '?timestamp=' . time(); // Adiciona um timestamp para evitar o cache
} else {
    // Se a imagem não foi atualizada, retorne a URL da imagem existente
    echo $currentProfileImageURL;
}
