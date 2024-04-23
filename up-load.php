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
    session_start();
    $nome = $_SESSION['nome'];
    $tipo = $_SESSION['tipo'];
    $id = $_SESSION['id'];
    $picture = $_SESSION['picture'];
    $senha = $_SESSION['senha'];
    $login = $_SESSION['login'];
    $email = $_SESSION['email'];
    $celular = $_SESSION['celular'];
    $turno = $_SESSION['turno'];

    require_once('conecta.php');

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

    if (isset($_FILES['arquivo'])) {

        $foto = ($_FILES['arquivo']);

        date_default_timezone_set("Brazil/East"); //Definindo timezone padrão
        $ext = strtolower(substr($_FILES['arquivo']['name'], -4)); //Pegando a extensão do arquivo

        $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
        $dir = 'img-postagem/'; //Diretório para uploads das imagens no servidor

        //Array com as extenções permitidas
        $extensoes_permitidas = array('.jpg', '.gif', '.png', 'bmp', 'jpeg');

        //Faz a verificação da extensão do arquivo enviado
        $extensao = strrchr($_FILES['arquivo']['name'], '.');

        //Faz a verificação do arquivo enviado
        if (!in_array(strtolower($extensao), $extensoes_permitidas) === true) {
            echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'Por favor, envie arquivos com as seguintes extenções: jpg, gif, png, bmp ou jpeg.',
            icon: 'error'
        });
    </script>";
            exit;
        }

        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir . $new_name)) { //Fazer upload do arquivo

            $mensagem = $_POST['mensagem'];

            $gravar = "INSERT INTO postagens (id_pessoa, nome, mensagem, imagem, imagemperfil, data_mensagem) VALUES ('$id', '$nome', '$mensagem', '$new_name', '$picture', now())";
            $resultado = mysqli_query($conexao, $gravar);

            if ($resultado == false) {
                echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'Problemas ao enviar.',
            icon: 'error'
        });
    </script>";
            } else {
                echo "<script>
                Swal.fire({
                    title: 'Sucesso',
                    text: 'Enviado com sucesso.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>";
            }
        }
    }
    ?>
</body>

</html>