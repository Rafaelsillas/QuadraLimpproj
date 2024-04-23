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
    $group_id = $_GET["id"];

    // Query
    $stmt = $conexao->prepare("SELECT `sender_id`, `group_id`, `Message`, `Image` FROM group_messages WHERE group_id = ? ORDER BY id");
    $stmt->bind_param("i", $group_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    $getUser = $conexao->prepare("SELECT id, nome, picture FROM login WHERE (id LIKE ?) LIMIT 1");
    $getUser->bind_param("i", $id);
    $getUser->execute();
    $user = $getUser->get_result()->fetch_assoc();

    while ($message = $result->fetch_assoc()) {
        if ($message["sender_id"] == $id && $message["Image"] != "") {
            ?>
            <div class="row sent">
                <img src="uploads/<?php echo $message["Image"] ?>" />
            </div>
            <?php
        } elseif ($message["sender_id"] == $id) {
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
            $getUser = $conexao->prepare("SELECT id, nome, picture FROM login WHERE (id LIKE ?) LIMIT 1");
            $getUser->bind_param("i", $message["sender_id"]);
            $getUser->execute();
            $user = $getUser->get_result()->fetch_assoc();
            ?>
            <div class="row2 recieved2">
                <img src="profilePics/<?php echo $user["picture"]; ?>" style="width: 40px;
  height: 40px; border-radius: 30px;" />
                <div class="msgs">
                    <p class="nome">
                        <?php $stmt = $conexao->prepare("SELECT id, nome, picture FROM login WHERE (id LIKE ?) LIMIT 1");
                        $stmt->bind_param("i", $message["sender_id"]);
                        $stmt->execute();
                        $user = $stmt->get_result()->fetch_assoc();
                        echo $user["nome"];
                        ?>
                    </p>
                    <p class="mensagem">
                        <?php echo $message["Message"] ?>
                    </p>
                </div>
            </div>
            <?php
        }
    }
}
?>