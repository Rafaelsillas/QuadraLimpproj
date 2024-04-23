<?php
header("Cache-Control: no-cache, must-revalidate"); // Não armazenar em cache
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Data de expiração no passado
require_once('conecta.php');
session_start();
$nome = $_SESSION['nome'];
$tipo = $_SESSION['tipo'];
$id = $_SESSION['id'];
$picture = $_SESSION['picture'];
$senha = $_SESSION['senha'];
$login = $_SESSION['login'];
$email = $_SESSION['email'];
$celular = $_SESSION['celular'];

$imagename = $login . "_" . rand(999, 999999) . $_FILES['imgInp']['name'];
$imagetemp = $_FILES['imgInp']['tmp_name'];
$imagePath = "profilePics/";

if (is_uploaded_file($imagetemp)) {
    if (move_uploaded_file($imagetemp, $imagePath . $imagename)) {
        $stmt = $conexao->prepare("UPDATE login SET `picture` = ? WHERE Id = ?");
        $stmt->bind_param("si", $imagename, $id);
        $stmt->execute();
        if ($stmt) {
            // Após a atualização do banco de dados, obtenha o URL da imagem atualizada
            $imageUrl = 'profilePics/' . $imagename;
            echo $imageUrl;
        } else {
            die(header("HTTP/1.0 401 Erro ao guardar imagem na base de dados"));
        }
    } else {
        die(header("HTTP/1.0 401 Erro ao guardar imagem"));
    }
} else {
    die(header("HTTP/1.0 401 Erro ao carregar imagem"));
}
