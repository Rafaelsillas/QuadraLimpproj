<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $mensagem = $_POST["mensagem"];

    $destinatario = "projcap2024@gmail.com";  // Substitua pelo seu endereço de email

    $assunto = "Mensagem do Formulário de Contato";
    $corpo_email = "$nome\n";
    $corpo_email = "$email\n";
    $corpo_email = "\n$mensagem";

    // Enviar email
    
    mail($destinatario, $assunto, $corpo_email);
    
}
?>