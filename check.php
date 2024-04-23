<?php
require_once('conecta.php');
if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];

    $stmt = $conexao->prepare("SELECT id, nome, picture, online FROM login WHERE (id = ?) LIMIT 1");
    $stmt->bind_param("isi", $id);
    $stmt->execute();
    $me = $stmt->get_result()->fetch_assoc();

    if (!me) {
        die();
    } else {
        $uid = $me["id"];
        $username = $me["nome"];
        $user_picture = ["picture"];
        $user_online = strotime($me["online"]);

        $stmt = $con->prepare("UPDATE login SET 'online' = now() WHERE id = ?");
        $stmt->bindparam("i", $uid);
        $stmt->execute();
    }
} else {
    die();
}



?>