<?php
require "conecta.php";
session_start();
$id = $_SESSION['id'];
$query = "SELECT * FROM login WHERE online IS NOT NULL";
$resultado = mysqli_query($conexao, $query);

// Inicialize duas listas: uma para você e outra para os outros usuários online
$seuOnlineList = array();
$outrosOnlineList = array();

// Verifique se a consulta foi bem-sucedida
if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        if ($row['id'] == $id) {
            // Se for você, adicione à lista "Seu Online List"
            $seuOnlineList[] = $row;
        } else {
            // Caso contrário, adicione à lista "Outros Online List"
            $outrosOnlineList[] = $row;
        }
    }
}

// Exiba primeiro "Você está online" e depois outros usuários online
?>
<div class='online-list' style='margin-top:100px; display:flex;'>
<?php
if (!empty($seuOnlineList)) {
    echo "<a href='perfil.php?id=" . $id . "' class='onlineUsers'>
    <div style='block'>
            <img src='profilePics/{$seuOnlineList[0]['picture']}' alt=''>
            <i class='bx bxs-circle lolo'></i>
            <p>Você</p>
            </div>
          </a>";
}

if (!empty($outrosOnlineList)) {
    foreach ($outrosOnlineList as $row) {
        echo "<a href='perfil.php?id=" . $row['id'] . "' class='onlineUsers'>
        <div style='block'>
                <img src='profilePics/{$row['picture']}' alt=''>
                <i class='bx bxs-circle lolo'></i>
                <p>{$row['login']}</p>
                </div>
              </a>";
    }
}
?>
</div>