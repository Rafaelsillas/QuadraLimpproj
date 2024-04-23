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


if (isset($_GET["id"])) {
    $user_id = $_GET["id"];

    // Query
    $stmt = $conexao->prepare("SELECT `Sender`, `Message`, `Image` FROM chat WHERE (Sender = ? AND Reciever = ?) OR (Reciever = ? AND Sender = ?) ORDER BY id");
    $stmt->bind_param("iiii", $user_id, $id, $user_id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    $getUser = $conexao->prepare("SELECT id, nome, picture FROM login WHERE (id LIKE ?) LIMIT 1");
    $getUser->bind_param("i", $user_id);
    $getUser->execute();
    $user = $getUser->get_result()->fetch_assoc();

    if ($count < 1) {
        echo '<p class="info">Envie a sua primeira mensagem para ' . $user["nome"] . '</p>';
    } else {
        while ($message = $result->fetch_assoc()) {
            if ($message["Sender"] == $id && $message["Image"] != "") {
                ?>
                <div class="row sent">
                    <img src="uploads/<?php echo $message["Image"] ?>" />
                </div>
                <?php
            } elseif ($message["Sender"] == $id) {
                ?>
                <div class="row sent">
                    <p>
                        <?php echo $message["Message"] ?>
                    </p>
                </div>
                <?php
            } elseif ($message["Image"] != "") {
                ?>
                <div class="row recieved">
                    <img src="uploads/<?php echo $message["Image"] ?>" />
                </div>
                <?php
            } else {
                ?>
                <div class="row recieved">
                    <p>
                        <?php echo $message["Message"] ?>
                    </p>
                </div>
                <?php
            }
        }

        // Update conversation has opened
        $stmt = $conexao->prepare("UPDATE conversations SET `Unred` = 'n' WHERE (MainUser = ? AND OtherUser = ?)");
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();

        $stmt = $conexao->prepare("UPDATE conversations SET `Unred` = 'n', `message_new` = '0'  WHERE (MainUser = ? AND OtherUser = ?)");
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
    }

} else {
    die(header("HTTP/1.0 401 Faltam parametros"));
}
?>