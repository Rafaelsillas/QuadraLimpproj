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


if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $user_id = $_GET["id"];

    // Get user
    $getUser = $conexao->prepare("SELECT nome, picture FROM login WHERE (Id LIKE $user_id) LIMIT 1");
    $getUser->execute();
    $user = $getUser->get_result()->fetch_assoc();

    ?>
    <div class="topMenu">
        <img src="img/close.png" class="hidden" onclick="chat()" />
        <img src="img/close-2.png" class="nao-hidden" onclick="chat()" />
        <div>
            <a href="chat.php"><i class='bx bx-chevron-left'></i></a>
            <img src="profilePics/<?php echo $user["picture"]; ?>" class="imagempessoa" />
            <p class="title">
                <?php echo $user["nome"]; ?>
            </p>
        </div>
    </div>

    <div class="innerContainer"></div>
 <div class="down">
    <form method="POST" enctype="multipart/form-data" id="sendMessage" action="chat1.php">
        <input type="number" value="<?php echo $user_id; ?>" name="id" hidden />
        <input type="text" maxlength="500" name="message" id="messageInput" placeholder="Escreva aqui a sua mensagem" />
        <input type='file' name="image" accept="image/x-png,image/jpeg" id="sendImage" hidden />
        <label for="sendImage" class="nao-hidden"><img src="img/image2.png" /></label>
        <label for="sendImage" class="hidden"><img src="img/image.png" /></label>
    </form>
    </div>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script>
        function sendMessage() {
            var formData = new FormData($("#sendMessage")[0]);
            $.ajax({
                type: 'post',
                url: 'send.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#sendMessage")[0].reset();
                    chat(<?php echo $user_id; ?>);
                }
            });
        }

        $("#messageInput").on('keyup', function (e) {
            if (e.keyCode === 13 && ($("#messageInput").val().length > 0)) {
                sendMessage()
            }
        });

        $("#sendImage").change(function () {
            sendMessage();
            console.log("SEND");
        });

        function retrieveMessages(userId) {
            $.ajax({
                url: 'retrieve.php?id=' + userId,
                success: function (data) {
                    $('#chat .innerContainer').html(data);
                    $('#chat .innerContainer').scrollTop($('#chat .innerContainer').prop("scrollHeight"));
                }
            });
        }
    </script>
    <?php

}

?>