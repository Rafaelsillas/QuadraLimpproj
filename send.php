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

if (isset($_POST["message"]) && isset($_POST["id"])) {

    // Normalization
    $user_id = $_POST["id"];
    $message = $_POST["message"];
    $image = "";

    if ($_FILES['image']['error'] <= 0) {
        $image = $nome . "_MESSAGE_" . rand(999, 999999) . $_FILES['image']['name'];
        $imagetemp = $_FILES['image']['tmp_name'];
        $imagePath = "uploads/";
        if (is_uploaded_file($imagetemp)) {
            if (move_uploaded_file($imagetemp, $imagePath . $image)) {
                echo "OK";
            } else {
                die(header("HTTP/1.0 401 Erro ao guardar imagem"));
            }
        } else {
            die(header("HTTP/1.0 401 Erro ao carregar imagem"));
        }
    } elseif ($user_id == "" || $message == "") {
        die(header("HTTP/1.0 401 Escreva uma mensagem"));
    }

    // Check if conversation exists
    $checkConversation = $conexao->prepare("SELECT id FROM `conversations` WHERE (MainUser = ? AND OtherUser = ?)");
    $checkConversation->bind_param("ii", $id, $user_id);
    $checkConversation->execute();
    $count = $checkConversation->get_result()->num_rows;
   
    $stmt = $conexao->prepare("SELECT message_new FROM conversations WHERE MainUser = ? AND OtherUser = ?");
    $stmt->bind_param("ii", $user_id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $numero_messagesNew = $row['message_new'] + 1; // Incremento do valor


    if ($count < 1) {
        // Create conversation user side
        $createChat = $conexao->prepare("INSERT INTO `conversations` (`MainUser`, `OtherUser`, `Unred`, `message_new`, `Creation`) VALUES (?, ?, '0', 'n', now())");
        $createChat->bind_param("ii", $id, $user_id);
        $createChat->execute();

        // Create conversation other user side
        $createChat2 = $conexao->prepare("INSERT INTO `conversations` (`MainUser`, `OtherUser`, `message_new`, `Unred`, `Creation`) VALUES (?, ?, ?, 'n', now())");
        $createChat2->bind_param("iii", $user_id, $id, $numero_messagesNew);
        $createChat2->execute();
    } else {
        $update = $conexao->prepare("UPDATE `conversations` SET Unred = 'y', message_new = ? WHERE (MainUser = ? AND OtherUser = ?)");
        $update->bind_param("iii", $numero_messagesNew, $user_id, $id);
        $update->execute();
    }

    $stmt = $conexao->prepare("INSERT INTO chat (`Sender`, `Reciever`, `Message`, `image`, `Creation`) VALUES (?, ?, ?, ?, now())");
    $stmt->bind_param("iiss", $id, $user_id, $message, $image);
    $stmt->execute();
    // Queries for creation and collection

    if (!$stmt || !$update) {
        die(header("HTTP/1.0 401 Ocorreu um erro ao enviar a sua mensagem"));
    }
} else {
    die(header("HTTP/1.0 401 Faltam parametros"));
}
?>