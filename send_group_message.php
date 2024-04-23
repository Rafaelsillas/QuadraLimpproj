<?php
include("conecta.php");
session_start();
$nome = $_SESSION['nome'];
$tipo = $_SESSION['tipo'];
$id = $_SESSION['id'];
$picture = $_SESSION['picture'];
$senha = $_SESSION['senha'];
$login = $_SESSION['login'];
$email = $_SESSION['email'];
$celular = $_SESSION['celular'];

$SQL = "select * FROM login where login='" . $login . "'";
$resultado = mysqli_query($conexao, $SQL);
while ($dados = mysqli_fetch_array($resultado)) {
    $_SESSION['nome'] = $dados['nome'];
    $_SESSION['id'] = $dados['id'];
    $_SESSION['senha'] = $dados['senha'];
    $_SESSION['login'] = $dados['login'];
    $_SESSION['email'] = $dados['email'];
    $_SESSION['celular'] = $dados['celular'];
    $_SESSION['tipo'] = $dados['tipo'];
    $_SESSION['picture'] = $dados['picture'];
}


$group_id = $_POST["id"];
$message = $_POST["message"];
$image = "";

if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $nome . "_MESSAGE_" . rand(999, 999999) . $_FILES['image']['name'];
    $imageTemp = $_FILES['image']['tmp_name'];
    $imagePath = "uploads/";

    if (move_uploaded_file($imageTemp, $imagePath . $image)) {
        // Imagem foi enviada com sucesso
    } else {
        die(header("HTTP/1.0 401 Erro ao guardar imagem"));
    }
}
$stmt = $conexao->prepare("INSERT INTO group_messages (`group_id`, `sender_id`, `Message`, `image`) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $group_id, $id, $message, $image); // Use "group_id" em vez de "id" aqui
$stmt->execute();

?>