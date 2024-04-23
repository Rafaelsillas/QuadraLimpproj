<?php
require_once('conecta.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_evento = $_POST['data_evento'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $link = $_POST['link'];

    $inserirEvento = $mysqli->prepare("INSERT INTO eventos (data_evento, titulo, descricao, link) VALUES (?,?,?,?)");
    $inserirEvento->bind_param("ssss", $data_evento, $titulo, $descricao, $link);

    if ($inserirEvento->execute()) {
        echo "<script>
    alert('Evento adicionado com sucesso.');
</script>";
    } else {
        echo "<script>
    alert('Erro ao adicionar evento.');
</script>";
    }

    $inserirEvento->close();
}
?>