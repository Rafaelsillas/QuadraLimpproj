<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/icon.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css
" rel="stylesheet">
    <title>MídiaTec</title>
</head>

<body>
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js
"></script>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="midia.js"></script>
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

    $groupId = $_GET['id'];

    // Recuperar informações do grupo de conversa do banco de dados
    $stmt = $conexao->prepare("SELECT name, imagem FROM group_conversations WHERE id = ?");
    $stmt->bind_param("i", $groupId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        header("Location: chat.php"); // Redirecionar se o grupo não existir
        exit();
    }

    $groupInfo = $result->fetch_assoc();

    ?>
    <div class="topMenu">
        <img src="img/close.png" class="hidden" onclick="chat()" />
        <img src="img/close-2.png" class="nao-hidden" onclick="chat()" />
        <div>
            <img src="profilePics/<?php echo $groupInfo["imagem"]; ?>" class="imagempessoa" />
            <p class="title">
                <?php echo $groupInfo['name']; ?>
            </p>
        </div>
    </div>

    <div class="innerContainer"></div>

    <form method="POST" enctype="multipart/form-data" id="sendMessage" action="group_chat.php">
        <input type="number" value="<?php echo $groupId; ?>" name="id" hidden />
        <input type="text" maxlength="500" name="message" id="messageInput" placeholder="Escreva aqui a sua mensagem" />
        <input type='file' name="image" accept="image/x-png,image/jpeg" id="sendImage" hidden />
        <label for="sendImage" class="nao-hidden"><img src="img/image2.png" /></label>
        <label for="sendImage" class="hidden"><img src="img/image.png" /></label>
    </form>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script>
        function sendMessage() {
            var formData = new FormData($("#sendMessage")[0]);
            $.ajax({
                type: 'post',
                url: 'send_group_message.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#sendMessage")[0].reset();
                    chatGroup(<?php echo $groupId; ?>);
                }
            });
        }

        $("#messageInput").on('keyup', function(e) {
            if (e.keyCode === 13 && ($("#messageInput").val().length > 0)) {
                sendMessage()
            }
        });

        $("#sendImage").change(function() {
            sendMessage();
            console.log("SEND");
        });

        function retrieveMessages(groupId) {
            $.ajax({
                url: 'retrieve_group_message.php?id=' + groupId,
                success: function(data) {
                    $('#chat .innerContainer').html(data);
                    $('#chat .innerContainer').scrollTop($('#chat .innerContainer').prop("scrollHeight"));
                }
            });
        }
    </script>
</body>