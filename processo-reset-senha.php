<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

require "conecta.php";

$sql = "SELECT * FROM login
        WHERE reset_token_hash = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["senha"]) < 5 or !preg_match("/[a-z]/i", $_POST["senha"]) or !preg_match("/[0-9]/", $_POST["senha"])) {
    echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'A senha deve conter pelo menos 5 caracteres, ter pelo menos uma letra e um número.',
            icon: 'error'
        });
    </script>";
    die();
}

if ($_POST["senha"] !== $_POST["senha_confirmar"]) {
    echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'As senha não coincidem.',
            icon: 'error'
        });
    </script>";
    die();
}

$password_hash = $_POST["senha"];
$hash_senha = password_hash($password_hash, PASSWORD_DEFAULT);

$sql = "UPDATE login
        SET senha = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("ss", $hash_senha, $user["id"]);

$stmt->execute();
echo "<script>
                Swal.fire({
                    title: 'Sucesso',
                    text: 'Senha alterada, agora você pode fazer login.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'login.php';
                });
            </script>";
