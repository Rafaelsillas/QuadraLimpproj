<?php
require "delete_profiles.php";
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
$descricao = $_SESSION['descricao'];

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
    $_SESSION['descricao'] = $dados['descricao'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="icon" href="images/icone1.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css
" rel="stylesheet">
    <title>Quadra Limp</title>

    <style>
        .trash {
            font-size: 25px;
            position: absolute;
            top: 92px;
            right: 230px;
            cursor: pointer;
            color: var(--text-color);
        }

        .trash:hover {
            color: var(--primary-color);
            transition: 1.2s;
        }



        .a {
            display: flex;
            width: 700px;
            position: absolute;
            transform: translateX(-50%);
            left: 38%;
            margin-top: 100px;
        }

        .pictureContainer2 {
            width: 90%;
            max-width: 200px;
        }

        .pictureContainer2 img {
            display: block;
            width: 100%;
            height: 200px;
            border-radius: 200px;
            object-fit: cover;
            object-position: center;
        }

        .pictureContainer {
            display: block;
            width: 200px;
            max-width: 100%;
        }

        .pictureContainer img {
            position: relative;
            width: 100%;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
            z-index: 1;
        }

        .imgInp {
            position: absolute;
            margin-top: -258px;
            margin-left: 49px;
            width: 200px;
            height: 200px;
            border-radius: 200px;
            opacity: 0;
            background: #000 url(upload-pic.png) no-repeat center;
            cursor: pointer;
            z-index: 1;
        }

        .imgInp2 {
            position: absolute;
            margin-top: -250px;
            margin-left: 54px;
            width: 200px;
            height: 200px;
            border-radius: 200px;
            opacity: 0;
            background: #000 url(upload-pic.png) no-repeat center;
            cursor: pointer;
            z-index: 1;
        }

        .imgBack {
            position: absolute;
            margin-left: 54px;
            margin-top: -250px;
            left: 0;
            opacity: 0;
            width: 200px;
            height: 200px;
            background-color: white;
            border-radius: 50%;
        }

        body.dark .imgBack {
            opacity: 1;
        }

        .pictureContainer .imgInp:hover {
            opacity: 0.7;
        }

        .pictureContainer .imgInp2:hover {
            opacity: 0.7;
        }

        p.name {
            display: block;
            margin: auto;
            padding: 0px 20px;
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 40px;
        }

        p.row {
            display: block;
            margin: 10px 30px;
            padding: 10px 15px;
            background-color: #EEE;
            border-radius: 5px;
        }

        .perf-name {
            display: flex;
            position: absolute;
            top: 120px;
            left: 345px;
            cursor: pointer;
        }

        .perf-name h2 {
            font-size: 30px;
            color: var(--text-color);
            font-weight: 600;
        }

        .perf-name img {
            width: 35px;
            margin-top: 9px;
            margin-left: 2px;
        }
    </style>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <a href="index.php"><img src="images/icone1.png" alt="logo"></a>
                </span>
                <div class="text header-text">
                    <span class="name">Quadra Limp</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="search" placeholder="Pesquise aqui..">
                </li>
                <ul class="menu-links"></ul>
                <li class="nav-link">
                    <a href="index.php">
                        <i class='bx bxs-home icon'></i>
                        <span class="text nav-text">Inicio</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="chat.php">
                        <i class='bx bxs-message-rounded-dots icon'></i>
                        <span class="text nav-text">Chat</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="apps.php">
                        <i class='bx bxs-dashboard icon'></i>
                        <span class="text nav-text">Serviços</span>
                    </a>
                </li>
                </ul>
                <li class="nav-link">
                    <a href="perfil.php">
                        <i class='bx bxs-user icon'></i>
                        <span class="text nav-text">Perfil</span>
                    </a>
                </li>

            </div>
            <div class="bottom-content">
                <li class="nav-link">
                    <a href="logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
                <li class="mode">
                    <div class="moon-sun">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Modo Escuro</span>

                    <div class="toggle-switch">
                        <sapn class="switch"></sapn>
                    </div>
                </li>
            </div>

        </div>
    </nav>
    <section class="resto">
        <div class="side-mobi">
            <div class="bar-cont">
                <a href="index.php"><i class='bx bxs-home icon'></i></a>
                <a href="novidades.php"><i class='bx bx-search icon'></i></a>
                <a href="index.php"><img src="images/loguinho.png"></a>
                <i class='bx bxs-heart icon' id="icone"></i>
                <a href="perfil.php"><i class='bx bxs-user icon'></i></a>

            </div>
        </div>
        <div class="overlei" id="divOverlei" style="opacity: 0;" onclick="fecharDiv()"></div>
        <div class="logout-mob" id="divLogoutMob" style="opacity: 0;">
            <img id="userImg" src="profilePics/<?php echo $picture; ?>" />
            <div class="edi" onclick="abrirEdit()">
                <p>Editar perfil</p>
            </div>
            <span>Tem certeza que quer sair?</span>
            <a href="logout.php">
                <h2>Sair da conta</h2>
            </a>
        </div>
        <div class="edit-mob" id="opEdit" style="display: none;">
            <a href="perfil.php"><i class='bx bx-chevron-left'></i></a>
            <form action="perfil.php" method="POST">
                <h2 class="mobh2">Editar Perfil</h2>
                <img id="userImg" class="mob-pic-perf" src="profilePics/<?php echo $picture; ?>" />
                <span class="altf">Alterar foto</span>
                <p class="fistone">Nome de usuário:</p>
                <input type="text" class="lip" id="login" name="login" value="<?php echo $login ?>" required>
                <p class="fisttwo">Nome:</p>
                <input type="text" class="jup" id="nome" name="nome" value="<?php echo $nome ?>" required>
                <p class="fistthree">Email:</p>
                <input type="text" class="own" id="email" name="email" value="<?php echo $email ?>" required>
                <p class="fistfour">Nome:</p>
                <div class="wrap-input100" data-validate="Insira a Senha">
                    <input class="input100" type="password" name="senha" placeholder="Senha Antiga" id="senha">
                    <span class="btn-show-pass" id="mostrarOcultarBtn">
                        <i class="zmdi zmdi-eye"></i>
                    </span>
                </div>

                <div class="wrap-input100">
                    <span class="btn-show-pass" id="mostrarOcultarBtn2">
                        <i class="zmdi zmdi-eye"></i>
                    </span>
                    <input class="input100" type="password" name="confirma_senha" placeholder="Nova senha" id="confirma_senha">
                </div>

                <label class="oiu" for="bio">Descrição:</label>
                <textarea id="bio" name="bio" rows="4" placeholder="<?php
                                                                    if (empty($descricao)) {
                                                                        echo "Escreva uma descrição";
                                                                    } else {
                                                                        echo $descricao;
                                                                    } ?>" required></textarea>
                <div class="buttons">
                    <input type="submit" value="Salvar Alterações" name="alterar">
                    <button onclick="aparecer()" class="btn-aparecer">Cancelar</button>
                </div>
            </form>
        </div>
        <div class="top">
            <div class="search-barsin">
                <i class='bx bx-search'></i>
                <input type="text" name="username" placeholder="Pesquise utilizadores aqui..." class="field" onkeyup="search()">
                <div id="search-results" class="search-results"></div>
            </div>
            <img src="profilePics/<?php echo $picture; ?>" class="user-pic" onclick="togglePerfil()">
        </div>
        <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
                <div class="user-info">
                    <img src="profilePics/<?php echo $picture; ?>">
                    <h6>Bem vindo,</h6>
                    <h3>
                        <?php echo "$nome" ?>
                    </h3>
                </div>
                <hr>

                <a href="perfil.php" class="sub-menu-link">
                    <i class='bx bxs-user ic'></i>
                    <span>Perfil</span>
                </a>
                <a href="#" class="sub-menu-link">
                    <i class='bx bxs-cog ic'></i>
                    <span>Configurações</span>
                </a>
                <a href="#" class="sub-menu-link">
                    <i class='bx bxs-help-circle ic'></i>
                    <span>Ajuda e suporte</span>
                </a>
                <a class="sub-menu-link" onclick="confirmDelete()">
                    <i class='bx bx-message-square-minus ic'></i>
                    <span>Excluir conta</span>
                </a>
                <a href="logout.php" class="sub-menu-link">
                    <i class='bx bx-log-out ic'></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
        <?php
        if (isset($_GET['id'])) {
            $idPessoa = $_GET['id'];
            if ($idPessoa == $id) {
        ?>
                <script>
                    // Função para enviar um "heartbeat" a cada 30 segundos
                    function sendHeartbeat() {
                        var userId = <?php echo $id; ?>;
                        $.ajax({
                            type: 'POST',
                            url: 'heartbeat.php', // Arquivo PHP para lidar com o "heartbeat"
                            data: {
                                userId: userId
                            },
                        });
                    }

                    // Enviar um "heartbeat" a cada 1 segundo (ou outro intervalo de sua escolha)
                    setInterval(sendHeartbeat, 1000); // 1 segundo
                </script>
                <div class="prof-mob">
                    <h3>
                        <?php echo $login; ?>
                        <i class='bx bx-chevron-down'></i>
                    </h3>
                    <img id="userImg" src="profilePics/<?php echo $picture; ?>" />
                    <h2>
                        <?php echo $nome; ?>
                    </h2>
                    <small>
                        Período :
                        <?php echo $turno ?>
                    </small>
                    <div class="descrip-mob">
                        <p>
                            <?php echo $descricao ?>
                        </p>
                    </div>
                </div>
                <div class="beg-prof">
                    <form method="POST" enctype="multipart/form-data" id="uploadPic">
                        <input type='file' name="imgInp" accept="image/x-png,image/jpeg" id="imgInp" hidden />
                        <div class="pictureContainer">
                            <img id="userImg" src="profilePics/<?php echo $picture; ?>" />
                            <?php
                            if ($picture == "user.png") {
                            ?>
                                <div class="imgBack"></div>
                                <label class="imgInp2" for="imgInp"></label>
                            <?php
                            } else {
                            ?>
                                <label class="imgInp" for="imgInp"></label>
                            <?php
                            }
                            ?>
                        </div>
                    </form>
                    <div class="tirar" id="tirar">
                        <button onclick="sumir()" class="ddd"><i class='bx bx-pencil popi' title="Editar Perfil"></i></button>

                        <button onclick="confirmDelete()" class="ddd"><i class='bx bxs-trash-alt trash' title="Excluir Conta"></i></button>

                        <div class="perf-name">
                            <h2>
                                <?php echo $nome; ?>
                            </h2>
                            <?php if ($tipo == 1) {
                            ?>
                                <img src="images/award.png" alt="" title="Estudante da Etec">
                            <?php } ?>
                            <?php if ($tipo == 2) {
                            ?>
                                <img src="images/award2.png" alt="" title="Ex-Estudante da Etec">
                            <?php } ?>
                        </div>
                        <div class="small-perf">
                            <small>
                                Período :
                                <?php echo $turno ?>
                            </small>
                        </div>
                        <div class="seguidor">
                            <p>4 Seguidores</p>
                        </div>
                        <div class="seguindo">
                            <p>10 Seguindo</p>
                        </div>
                        <?php
                        // Consulta para contar o número de publicações do usuário com base no ID do usuário
                        $sql_count_publications = "SELECT COUNT(*) AS total_publications FROM postagens WHERE id_pessoa = $id";
                        $result_count_publications = mysqli_query($conexao, $sql_count_publications);
                        $row_count_publications = mysqli_fetch_assoc($result_count_publications);
                        $total_publications = $row_count_publications['total_publications'];

                        // Agora você tem o total de publicações do usuário em $total_publications

                        ?>
                        <div class="Publicações">
                            <p>
                                <?php echo $total_publications; ?> Publicações
                            </p>
                        </div>
                        <div class="descrip">
                            <p>
                                <?php echo $descricao ?>
                            </p>
                        </div>
                    </div>
                    <div id="aparecer" class="aparecer">
                        <form action="perfil.php" method="POST">
                            <h2>Editar Perfil</h2>
                            <input type="text" id="login" name="login" value="<?php echo $login ?>" required>

                            <input type="text" id="nome" name="nome" value="<?php echo $nome ?>" required>

                            <input type="text" id="email" name="email" value="<?php echo $email ?>" required>

                            <div class="wrap-input100" data-validate="Insira a Senha">
                                <input class="input100" type="password" name="senha" placeholder="Senha Antiga (Não Obrigatório)" id="senha">
                                <span class="btn-show-pass" id="mostrarOcultarBtn">
                                    <i class="zmdi zmdi-eye"></i>
                                </span>
                            </div>

                            <div class="wrap-input100">
                                <span class="btn-show-pass" id="mostrarOcultarBtn2">
                                    <i class="zmdi zmdi-eye"></i>
                                </span>
                                <input class="input100" type="password" name="confirma_senha" placeholder="Nova senha (Não Obrigatório)" id="confirma_senha">
                            </div>

                            <label for="bio">Descrição:</label>
                            <textarea id="bio" name="bio" rows="4" placeholder="<?php
                                                                                if (empty($descricao)) {
                                                                                    echo "Escreva uma descrição";
                                                                                } else {
                                                                                    echo $descricao;
                                                                                } ?>" required></textarea>
                            <div class="buttons">
                                <input type="submit" value="Salvar Alterações" name="alterar">
                                <button onclick="aparecer()" class="btn-aparecer">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="pop">
                </hr>

                <div id="overlay" class="overlay"></div>
                <div id="form" class="form-add">
                    <span class="close-button" onclick="toggleForm()" title="Cancelar"><i class='bx bx-x'></i></span>
                    <form action="perfil.php" method="POST" enctype="multipart/form-data">
                        <center>
                            <p>
                                Mensagem <textarea id="mensagem" name="mensagem" rows="4" placeholder="Escreva sua mensagem" required class="textarea"></textarea>
                            </p>
                            <p>
                                <input type="file" name="arquivo" />
                            </p>
                            <button>Inserir Postagem</button>
                    </form>

                    <?php
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
                            echo "<script> window.alert('Por favor, envie arquivos com as seguintes extenções: jpg, gif, png, bmp ou jpeg.');
        window.location.href='perfil.php'
        </script>";
                            exit;
                        }

                        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir . $new_name)) { //Fazer upload do arquivo

                            $mensagem = $_POST['mensagem'];

                            $gravar = "INSERT INTO postagens (id_pessoa, nome, mensagem, imagem, imagemperfil, data_mensagem) VALUES ('$id', '$nome', '$mensagem', '$new_name', '$picture', now())";
                            $resultado = mysqli_query($conexao, $gravar);

                            if ($resultado == false) {
                                echo "<script> window.alert('Problemas ao enviar.');
        window.location.href='perfil.php'
        </script>";
                            } else {
                                echo "<script> window.alert('Enviado com sucesso.');
        window.location.href='perfil.php'
        </script>";
                            }
                        }
                    }
                    ?>
                </div>
                <div class="post-container">
                    <?php
                    require_once('conecta.php');
                    $consulta = "SELECT * FROM postagens where id_pessoa='$id' ORDER BY data_mensagem DESC ";

                    $resultado = mysqli_query($conexao, $consulta);

                    $posts = []; // Crie uma matriz para armazenar as postagens

                    while ($row = mysqli_fetch_array($resultado)) {
                        $posts[] = $row; // Adicione cada postagem à matriz de postagens
                    }
                    if (mysqli_num_rows($resultado) > 0) {
                        foreach ($posts as $post) {
                            $postagem_id = $post['cod_mensagem'];
                            $consultaComentarios = "SELECT * FROM comentarios WHERE postagem_id = $postagem_id";
                            $resultadoComentarios = mysqli_query($conexao, $consultaComentarios);
                            $data_postagem_formatada = date("d/m/Y H:i:s", strtotime($post['data_mensagem']));
                    ?>
                            <script src="https://unpkg.com/@popperjs/core@2"></script>
                        <?php
                            // Exiba a postagem
                            echo "<div class='post-cont'>
                        <div class='post-row'>
                            <div class='user-prof'>
                                <img src='profilePics/" . $post['imagemperfil'] . "' alt=''>
                                <div>
                                    <p>" . $post['nome'] . "</p>
                                    <small>" . $data_postagem_formatada . "</small>
                                </div>
                                <button onclick='reportPost(" . $post['cod_mensagem'] . ")' class='eee btn-error'>
    <i class='bx bx-error btn-post' title='Denunciar Postagem'></i>
</button>";

                            if ($post['id_pessoa'] == $id or $tipo == 'admin') {
                                echo "<button onclick='confirmDeletePostagem(" . $post['cod_mensagem'] . ")' class='eee btn-lixo'>
            <i class='bx bx-trash-alt btn-post' title='Deletar Postagem'></i>
        </button> ";
                            }
                            echo "</div>
                        </div>
                        <p class='post-text'>" . $post['mensagem'] . "
                            <img src='img-postagem/" . $post['imagem'] . "' alt='' class='post-img'>
                        </p>
                        <div class='post-row'>
                            <div class='active-icons'>";
                            $verificar = "SELECT * FROM likes WHERE post_id = $postagem_id AND user_id = $id";
                            $resultadoVerificacao = mysqli_query($conexao, $verificar);
                            if (mysqli_num_rows($resultadoVerificacao) == 0) {
                                echo "<div><i class='bx bxs-like ico' id='targetElement-" . $post['cod_mensagem'] . "' onclick='likePost(" . $post['cod_mensagem'] . ")'></i><p>" . $post['likes_count'] . "</p></div>";
                            } else {
                                echo "<div><i class='bx bxs-like ico liked' id='targetElement-" . $post['cod_mensagem'] . "' onclick='likePost(" . $post['cod_mensagem'] . ")'></i><p>" . $post['likes_count'] . "</p></div>";
                            }
                            echo "<div><i class='bx bx-comment-detail ico' onclick='toggleCommentBox(" . $post['cod_mensagem'] . ")'></i></div>
                                <div><i class='bx bxs-share ico'></i></div>
                            </div>
                        </div>
                        <form method='POST'>
                            <input type='hidden' name='postagem_id' value='" . $post['cod_mensagem'] . "'>
                            <div class='post-input' id='commentBox-" . $post['cod_mensagem'] . "' style='display: none;'>
                            <textarea rows='1' placeholder='Escreva seu comentário' name='comentario' data-postagem-id='" . $post['cod_mensagem'] . "'></textarea>
                            <button type='button' class='enviar-comentario-button' onclick='enviarComentario(" . $post['cod_mensagem'] . ")'>Enviar</button>
                            </div>
                        </form>";
                            echo "<div id='comment-container' data-postagem-id='" . $postagem_id . "'>";
                            // Aqui, você pode exibir os comentários relacionados a esta postagem, se necessário.
                            echo "</div>";

                            echo "</div>";
                        }
                    } else {
                        echo '<div class="doni">
                    <h1>Ainda não há publicações e atividades!</h1>
                </div>
                <div class="small-now">
                    <button onclick="toggleForm()"> Comece suas atividades no perfil agora </button>
        
                </div>'; ?>
                </div>
            <?php
                    }
                } else {
                    $sql2 = "select * FROM login where id='" . $idPessoa . "'";
                    $resultado2 = mysqli_query($conexao, $sql2);
                    while ($row = mysqli_fetch_array($resultado2)) {
                        $nomePessoa = $row['nome'];
                        $emailPessoa = $row['email'];
                        $tipoPessoa = $row['tipo'];
                        $turnoPessoa = $row['turno'];
                        $picturePessoa = $row['picture'];
                        $descricaoPessoa = $row['descricao']; ?>
                <script>
                    // Função para enviar um "heartbeat" a cada 30 segundos
                    function sendHeartbeat() {
                        var userId = <?php echo $id; ?>;
                        $.ajax({
                            type: 'POST',
                            url: 'heartbeat.php', // Arquivo PHP para lidar com o "heartbeat"
                            data: {
                                userId: userId
                            },
                        });
                    }

                    // Enviar um "heartbeat" a cada 1 segundo (ou outro intervalo de sua escolha)
                    setInterval(sendHeartbeat, 1000); // 1 segundo
                </script>
                <div class="beg-prof">
                    <div class="pictureContainer2">
                        <img id="userImg" src="profilePics/<?php echo $picturePessoa; ?>" style="width='100%'" />
                        <?php
                        if ($picturePessoa == "user.png") {
                        ?>
                            <div class="imgBack"></div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="tirar" id="tirar">

                        <div class="perf-name">
                            <h2>
                                <?php echo $nomePessoa; ?>
                            </h2>
                            <?php if ($tipo == 1) {
                            ?>
                                <img src="images/award.png" alt="" title="Estudante da Etec">
                            <?php } ?>
                            <?php if ($tipo == 2) {
                            ?>
                                <img src="images/award2.png" alt="" title="Ex-Estudante da Etec">
                            <?php } ?>
                        </div>
                        <div class="small-perf">
                            <small>
                                Período :
                                <?php echo $turnoPessoa ?>
                            </small>
                        </div>
                        <div class="seguidor">
                            <p>4 Seguidores</p>
                        </div>
                        <div class="seguindo">
                            <p>10 Seguindo</p>
                        </div>
                        <div class="Publicações">
                            <p> 0 Publicações</p>
                        </div>
                        <div class="descrip">
                            <p>
                                <?php echo $descricaoPessoa ?>
                            </p>
                        </div>
                    </div>
                </div>
                <hr class="pop">
                </hr>
                <div class="post-container">
                    <?php
                        require_once('conecta.php');
                        $consulta = "SELECT * FROM postagens where id_pessoa='$idPessoa' ORDER BY data_mensagem DESC ";

                        $resultado = mysqli_query($conexao, $consulta);

                        $posts = []; // Crie uma matriz para armazenar as postagens

                        while ($row = mysqli_fetch_array($resultado)) {
                            $posts[] = $row; // Adicione cada postagem à matriz de postagens
                        }
                        if (mysqli_num_rows($resultado) > 0) {
                            foreach ($posts as $post) {
                                $postagem_id = $post['cod_mensagem'];
                                $consultaComentarios = "SELECT * FROM comentarios WHERE postagem_id = $postagem_id";
                                $resultadoComentarios = mysqli_query($conexao, $consultaComentarios);
                                $data_postagem_formatada = date("d/m/Y H:i:s", strtotime($post['data_mensagem']));
                    ?>
                            <script src="https://unpkg.com/@popperjs/core@2"></script>
                    <?php
                                // Exiba a postagem
                                echo "<div class='post-cont'>
                        <div class='post-row'>
                            <div class='user-prof'>
                                <img src='profilePics/" . $post['imagemperfil'] . "' alt=''>
                                <div>
                                    <p>" . $post['nome'] . "</p>
                                    <small>" . $data_postagem_formatada . "</small>
                                </div>
                                <button onclick='reportPost(" . $post['cod_mensagem'] . ")' class='eee btn-error'>
    <i class='bx bx-error btn-post' title='Denunciar Postagem'></i>
</button>";

                                if ($post['id_pessoa'] == $id or $tipo == 'admin') {
                                    echo "<button onclick='confirmDeletePostagem(" . $post['cod_mensagem'] . ")' class='eee btn-lixo'>
            <i class='bx bx-trash-alt btn-post' title='Deletar Postagem'></i>
        </button> ";
                                }
                                echo "</div>
                        </div>
                        <p class='post-text'>" . $post['mensagem'] . "
                            <img src='img-postagem/" . $post['imagem'] . "' alt='' class='post-img'>
                        </p>
                        <div class='post-row'>
                            <div class='active-icons'>";
                                $verificar = "SELECT * FROM likes WHERE post_id = $postagem_id AND user_id = $id";
                                $resultadoVerificacao = mysqli_query($conexao, $verificar);
                                if (mysqli_num_rows($resultadoVerificacao) == 0) {
                                    echo "<div><i class='bx bxs-like ico' id='targetElement-" . $post['cod_mensagem'] . "' onclick='likePost(" . $post['cod_mensagem'] . ")'></i><p>" . $post['likes_count'] . "</p></div>";
                                } else {
                                    echo "<div><i class='bx bxs-like ico liked' id='targetElement-" . $post['cod_mensagem'] . "' onclick='likePost(" . $post['cod_mensagem'] . ")'></i><p>" . $post['likes_count'] . "</p></div>";
                                }
                                echo "<div><i class='bx bx-comment-detail ico' onclick='toggleCommentBox(" . $post['cod_mensagem'] . ")'></i></div>
                                <div><i class='bx bxs-share ico'></i></div>
                            </div>
                        </div>
                        <form method='POST'>
                            <input type='hidden' name='postagem_id' value='" . $post['cod_mensagem'] . "'>
                            <div class='post-input' id='commentBox-" . $post['cod_mensagem'] . "' style='display: none;'>
                            <textarea rows='1' placeholder='Escreva seu comentário' name='comentario' data-postagem-id='" . $post['cod_mensagem'] . "'></textarea>
                            <button type='button' class='enviar-comentario-button' onclick='enviarComentario(" . $post['cod_mensagem'] . ")'>Enviar</button>
                            </div>
                        </form>";
                                echo "<div id='comment-container' data-postagem-id='" . $postagem_id . "'>";
                                // Aqui, você pode exibir os comentários relacionados a esta postagem, se necessário.
                                echo "</div>";

                                echo "</div>";
                            }
                        } else {
                            echo '<div class="doni">
                    <h1>Ainda não há publicações e atividades!</h1>
                </div>';
                        }
                    ?>
                </div>

        <?php
                    }
                }
            } else {
        ?>
        <script>
            // Função para enviar um "heartbeat" a cada 30 segundos
            function sendHeartbeat() {
                var userId = <?php echo $id; ?>;
                $.ajax({
                    type: 'POST',
                    url: 'heartbeat.php', // Arquivo PHP para lidar com o "heartbeat"
                    data: {
                        userId: userId
                    },
                });
            }

            // Enviar um "heartbeat" a cada 1 segundo (ou outro intervalo de sua escolha)
            setInterval(sendHeartbeat, 1000); // 1 segundo
        </script>
        <div class="beg-prof">
            <form method="POST" enctype="multipart/form-data" id="uploadPic">
                <input type='file' name="imgInp" accept="image/x-png,image/jpeg" id="imgInp" hidden />
                <div class="pictureContainer">
                    <img id="userImg" src="profilePics/<?php echo $picture; ?>" />
                    <?php
                    if ($picture == "user.png") {
                    ?>
                        <div class="imgBack"></div>
                        <label class="imgInp2" for="imgInp"></label>
                    <?php
                    } else {
                    ?>
                        <label class="imgInp" for="imgInp"></label>
                    <?php
                    }
                    ?>
                </div>
            </form>
            <div class="tirar" id="tirar">
                <button onclick="sumir()" class="ddd"><i class='bx bx-pencil popi' title="Editar Perfil"></i></button>

                <button onclick="confirmDelete()" class="ddd"><i class='bx bxs-trash-alt trash' title="Excluir Conta"></i></button>

                <div class="perf-name">
                    <h2>
                        <?php echo $nome; ?>
                    </h2>
                    <?php if ($tipo == 1) {
                    ?>
                        <img src="images/award.png" alt="" title="Estudante da Etec">
                    <?php } ?>
                    <?php if ($tipo == 2) {
                    ?>
                        <img src="images/award2.png" alt="" title="Ex-Estudante da Etec">
                    <?php } ?>
                </div>
                <div class="small-perf">
                    <small>
                        Período :
                        <?php echo $turno ?>
                    </small>
                </div>
                <div class="seguidor">
                    <p>4 Seguidores</p>
                </div>
                <div class="seguindo">
                    <p>10 Seguindo</p>
                </div>
                <div class="Publicações">
                    <p> 0 Publicações</p>
                </div>
                <div class="descrip">
                    <p>
                        <?php echo $descricao ?>
                    </p>
                </div>
            </div>
            <div id="aparecer" class="aparecer">
                <form action="perfil.php" method="POST">
                    <h2>Editar Perfil</h2>
                    <input type="text" id="login" name="login" value="<?php echo $login ?>" required>

                    <input type="text" id="nome" name="nome" value="<?php echo $nome ?>" required>

                    <input type="text" id="email" name="email" value="<?php echo $email ?>" required>

                    <div class="wrap-input100" data-validate="Insira a Senha">
                        <input class="input100" type="password" name="senha" placeholder="Senha Antiga (Não Obrigatório)" id="senha">
                        <span class="btn-show-pass" id="mostrarOcultarBtn">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                    </div>

                    <div class="wrap-input100">
                        <span class="btn-show-pass" id="mostrarOcultarBtn2">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="confirma_senha" placeholder="Nova senha (Não Obrigatório)" id="confirma_senha">
                    </div>

                    <label for="bio">Descrição:</label>
                    <textarea id="bio" name="bio" rows="4" required><?php
                                                                    if (empty($descricao)) {
                                                                        echo "Escreva uma descrição";
                                                                    } else {
                                                                        echo $descricao;
                                                                    } ?></textarea>
                    <div class="buttons">
                        <input type="submit" value="Salvar Alterações" name="alterar">
                        <button onclick="aparecer()" class="btn-aparecer">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
        <hr class="pop">
        </hr>

        <button onclick="toggleForm()" class="btn-add">Adicionar Comunicado</button>

        <div id="overlay" class="overlay"></div>
        <div id="form" class="form-add">
            <span class="close-button" onclick="toggleForm()" title="Cancelar"><i class='bx bx-x'></i></span>
            <form action="perfil.php" method="POST" enctype="multipart/form-data">
                <p>
                    Mensagem <textarea id="mensagem" name="mensagem" rows="4" placeholder="Escreva sua mensagem" required class="textarea"></textarea>
                </p>
                <p>
                    <input type="file" name="arquivo" />
                </p>
                <button>Inserir Postagem</button>
            </form>


            <?php
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
                        echo "<script> window.alert('Por favor, envie arquivos com as seguintes extenções: jpg, gif, png, bmp ou jpeg.');
        window.location.href='perfil.php'
        </script>";
                        exit;
                    }

                    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir . $new_name)) { //Fazer upload do arquivo

                        $mensagem = $_POST['mensagem'];

                        $gravar = "INSERT INTO postagens (id_pessoa, nome, mensagem, imagem, imagemperfil, data_mensagem) VALUES ('$id', '$nome', '$mensagem', '$new_name', '$picture', now())";
                        $resultado = mysqli_query($conexao, $gravar);

                        if ($resultado == false) {
                            echo "<script> window.alert('Problemas ao enviar.');
        window.location.href='perfil.php'
        </script>";
                        } else {
                            echo "<script> window.alert('Enviado com sucesso.');
        window.location.href='perfil.php'
        </script>";
                        }
                    }
                }
            ?>
        </div>
        <div class="prof-mob">
            <h3>
                <?php echo $login; ?>
                <i class='bx bx-chevron-down' id="mostrarDivs" onclick="mostrarDivs()"></i>
                <i class='bx bx-plus re' onclick="toggleForm()"></i>
            </h3>
            <img id="userImg" src="profilePics/<?php echo $picture; ?>" />
            <h2>
                <?php echo $nome; ?>
            </h2>
            <small>
                Período :
                <?php echo $turno ?>
            </small>
            <div class="descrip-mob">
                <p>
                    <?php echo $descricao ?>
                </p>
            </div>
        </div>
        <div class="post-container">
            <?php
                require_once('conecta.php');
                $consulta = "SELECT * FROM postagens where id_pessoa='$id' ORDER BY data_mensagem DESC ";

                $resultado = mysqli_query($conexao, $consulta);

                $posts = []; // Crie uma matriz para armazenar as postagens

                while ($row = mysqli_fetch_array($resultado)) {
                    $posts[] = $row; // Adicione cada postagem à matriz de postagens
                }
                if (mysqli_num_rows($resultado) > 0) {
                    foreach ($posts as $post) {
                        $postagem_id = $post['cod_mensagem'];
                        $consultaComentarios = "SELECT * FROM comentarios WHERE postagem_id = $postagem_id";
                        $resultadoComentarios = mysqli_query($conexao, $consultaComentarios);
                        $data_postagem_formatada = date("d/m/Y H:i:s", strtotime($post['data_mensagem']));
            ?>
                    <script src="https://unpkg.com/@popperjs/core@2"></script>
                <?php
                        // Exiba a postagem
                        echo "<div class='post-cont'>
                        <div class='post-row'>
                            <div class='user-prof'>
                                <img src='profilePics/" . $post['imagemperfil'] . "' alt=''>
                                <div>
                                    <p>" . $post['nome'] . "</p>
                                    <small>" . $data_postagem_formatada . "</small>
                                </div>
                                <button onclick='reportPost(" . $post['cod_mensagem'] . ")' class='eee btn-error'>
    <i class='bx bx-error btn-post' title='Denunciar Postagem'></i>
</button>";

                        if ($post['id_pessoa'] == $id or $tipo == 'admin') {
                            echo "<button onclick='confirmDeletePostagem(" . $post['cod_mensagem'] . ")' class='eee btn-lixo'>
            <i class='bx bx-trash-alt btn-post' title='Deletar Postagem'></i>
        </button> ";
                        }
                        echo "</div>
                        </div>
                        <p class='post-text'>" . $post['mensagem'] . "
                            <img src='img-postagem/" . $post['imagem'] . "' alt='' class='post-img'>
                        </p>
                        <div class='post-row'>
                            <div class='active-icons'>";
                        $verificar = "SELECT * FROM likes WHERE post_id = $postagem_id AND user_id = $id";
                        $resultadoVerificacao = mysqli_query($conexao, $verificar);
                        if (mysqli_num_rows($resultadoVerificacao) == 0) {
                            echo "<div><i class='bx bxs-like ico' id='targetElement-" . $post['cod_mensagem'] . "' onclick='likePost(" . $post['cod_mensagem'] . ")'></i><p>" . $post['likes_count'] . "</p></div>";
                        } else {
                            echo "<div><i class='bx bxs-like ico liked' id='targetElement-" . $post['cod_mensagem'] . "' onclick='likePost(" . $post['cod_mensagem'] . ")'></i><p>" . $post['likes_count'] . "</p></div>";
                        }
                        echo "<div><i class='bx bx-comment-detail ico' onclick='toggleCommentBox(" . $post['cod_mensagem'] . ")'></i></div>
                                <div><i class='bx bxs-share ico'></i></div>
                            </div>
                        </div>
                        <form method='POST'>
                            <input type='hidden' name='postagem_id' value='" . $post['cod_mensagem'] . "'>
                            <div class='post-input' id='commentBox-" . $post['cod_mensagem'] . "' style='display: none;'>
                            <textarea rows='1' placeholder='Escreva seu comentário' name='comentario' data-postagem-id='" . $post['cod_mensagem'] . "'></textarea>
                            <button type='button' class='enviar-comentario-button' onclick='enviarComentario(" . $post['cod_mensagem'] . ")'>Enviar</button>
                            </div>
                        </form>";
                        echo "<div id='comment-container' data-postagem-id='" . $postagem_id . "'>";
                        // Aqui, você pode exibir os comentários relacionados a esta postagem, se necessário.
                        echo "</div>";

                        echo "</div>";
                    }
                } else {
                    echo '<div class="doni">
                    <h1>Ainda não há publicações e atividades!</h1>
                </div>
                <div class="small-now">
                    <button onclick="toggleForm()"> Comece suas atividades no perfil agora </button>
        
                </div>'; ?>
        </div>
<?php
                }
            }
?>
</div>

    </section>
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js
"></script>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="midia.js"></script>

    <script>
        function updateComments(postagemId = null) {
            if (postagemId === null) {
                // Se postagemId não for fornecido, percorra todas as postagens
                $('.post-cont').each(function() {
                    var postId = $(this).find('#comment-container').data('postagem-id');
                    updateComments(postId);
                });
            } else {
                $.ajax({
                    url: 'get_comments.php?postagem_id=' + postagemId,
                    method: 'GET',
                    success: function(data) {


                        var comments = data.comments || [];
                        var isPostOwner = data.isPostOwner;

                        // Limpe o contêiner de comentários específico da postagem
                        $('#comment-container[data-postagem-id="' + postagemId + '"]').empty();

                        // Exiba os comentários na página
                        for (var i = 0; i < comments.length; i++) {
                            var comment = comments[i];
                            var commentHtml = "<div class='comment'> <p> " + comment.nome + ": " + comment.comentario + " </p>";

                            commentHtml += "<div class='button-comment'><button onclick='showOptionsMenu(" + comment.id + ")'><i class='bx bx-dots-vertical-rounded'></i></button></div>";
                            commentHtml += "<div id='options-menu-" + comment.id + "' class='options-menu' style='display: none;'>";
                            commentHtml += "<button onclick='handleOptionClick(" + comment.id + ", \"Denunciar\")'>Denunciar</button>";

                            // Adicione a lógica para exibir o botão de exclusão se o usuário for admin ou o dono da postagem/comentário
                            if (comment.tipo === 'admin' || isPostOwner || comment.isCommentAuthor) {
                                commentHtml += "<button onclick='handleOptionClick(" + comment.id + ", \"Excluir\")'>Excluir</button>";
                            }

                            commentHtml += "<button onclick='hideOptionsMenu(" + comment.id + ")'>Cancelar</button>";
                            commentHtml += "</div></div>";

                            $('#comment-container[data-postagem-id="' + postagemId + '"]').append(commentHtml);
                        }
                    }
                });
            }
        }

        $(document).ready(function() {
            $('textarea[name="comentario"]').on('keydown', function(event) {
                if (event.keyCode === 13 && !event.shiftKey) {
                    event.preventDefault();
                    var postagemId = $(this).closest('form').find('input[name="postagem_id"]').val();
                    enviarComentario(postagemId);
                }
            });
            $('.post-cont').each(function() {
                var postagemId = $(this).find('#comment-container').data('postagem-id');
                updateComments();
            });
        });

        function enviarComentario(postagemId) {
            var comentarioInput = document.querySelector('#commentBox-' + postagemId + ' textarea');
            var comentario = comentarioInput.value;

            if (comentario.trim() === '') {
                alert('O campo de comentário está vazio.');
                return;
            }

            $.ajax({
                url: 'adicionar_comentario.php',
                method: 'POST',
                data: {
                    postagem_id: postagemId,
                    comentario: comentario
                },
                success: function(response) {
                    var responseData = JSON.parse(response);

                    if (responseData.status === 'success') {
                        // Limpe o campo de comentário após o envio bem-sucedido
                        comentarioInput.value = '';

                        $(document).trigger('comentarioAdicionado', {
                            postagemId: postagemId
                        });
                    } else if (responseData.status === 'error') {
                        // Se ocorrer um erro, exiba o alerta do SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: responseData.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição AJAX: ' + error);
                }
            });
        }

        $(document).on('comentarioAdicionado comentarioExcluido', function(event, data) {
            updateComments(data.postagemId);
        });

        function toggleCommentBox(postId) {
            var commentBox = document.getElementById('commentBox-' + postId);

            if (commentBox.style.display === 'none' || commentBox.style.display === '') {
                commentBox.style.display = 'block';
            } else {
                commentBox.style.display = 'none';
            }
        }

        function likePost(id_postagem) {
            $.ajax({
                url: 'like.php',
                method: 'POST',
                data: {
                    postagem_id: id_postagem
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        var likeIcon = document.getElementById('targetElement-' + id_postagem);
                        var likeCountElement = document.querySelector('#targetElement-' + id_postagem + ' + p');

                        if (data.likeAdded) {
                            likeIcon.classList.add('liked');
                        } else {
                            likeIcon.classList.remove('liked');
                        }

                        if (likeCountElement) {
                            likeCountElement.textContent = data.likesCount;
                        }
                    } else {
                        console.error('Erro ao interagir com o like: ' + data.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição AJAX: ' + error);
                }
            });
        }

        function perfil(id = 0) {
            $.ajax({
                url: 'perfil.php?id=' + id,
                success: function(data) {}
            });
        }

        function search() {
            var term = $("input.field").val();
            var searchResults = $('#search-results');

            if (term.length >= 1) {
                $.ajax({
                    url: 'search-index.php?term=' + term,
                    success: function(data) {
                        // Remova o conteúdo anterior e redefina max-height
                        searchResults.empty().css('max-height', 0);

                        // Adicione os novos resultados
                        searchResults.html(data);

                        // Calcule a altura total dos resultados e atribua a max-height
                        var resultHeight = searchResults.prop('scrollHeight');
                        searchResults.css('max-height', resultHeight + 'px');

                        // Remova a classe .visible se estiver presente
                        searchResults.removeClass('visible');

                        // Adicione a classe .visible para mostrar os resultados
                        searchResults.addClass('visible');
                    }
                });
            } else {
                // Remova a classe .visible e limpe os resultados
                searchResults.removeClass('visible').empty().css('max-height', 0);
            }
        }

        function toggleForm() {
            var form = document.getElementById("form");
            var overlay = document.getElementById("overlay");

            if (form.classList.contains("active")) {
                form.classList.remove("active");
                overlay.style.display = "none";
                document.body.style.overflow = "auto"; // Re-enable scrolling
            } else {
                form.classList.add("active");
                overlay.style.display = "block";
                document.body.style.overflow = "hidden"; // Disable scrolling
            }
        }

        function confirmDelete() {
            Swal.fire({
                title: 'Confirmação',
                text: 'Tem certeza de que deseja deletar sua conta?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "delete.php"; // Chame a função de retorno de chamada com true e o motivo
                } else {

                }
            });
        }

        function sumir() {
            var divParaOcultar = document.getElementById("tirar");
            divParaOcultar.style.display = "none";
            var divParaOcultar = document.getElementById("aparecer");
            divParaOcultar.style.display = "block";
        }

        function aparecer() {
            var divParaOcultar = document.getElementById("tirar");
            divParaOcultar.style.display = "block";
            var divParaOcultar = document.getElementById("aparecer");
            divParaOcultar.style.display = "none";
            location.reload();
        }

        function previewUpload(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#userImg').attr('src', e.target.result);
                    var formData = new FormData($("#uploadPic")[0]);
                    $.ajax({
                        type: 'post',
                        url: 'updateProfile.php',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            exibirAlerta(); // Chame a função para exibir o alerta
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro na requisição AJAX: ' + error);
                        }
                    });
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function exibirAlerta() {
            Swal.fire({
                title: 'Sucesso',
                text: 'Foto de perfil alterada com sucesso!',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload(); // Recarregar a página pela primeira vez
                    setTimeout(() => {
                        location.reload(); // Recarregar a página pela segunda vez após um pequeno atraso
                    }, 1000); // Atraso de 1000 milissegundos (1 segundo)
                }
            });
        }

        // Limpar a flag de recarregamento recente ao carregar a página
        $(document).ready(function() {
            sessionStorage.removeItem('recarregadaRecentemente');
        });

        $("#imgInp").change(function() {
            previewUpload(this);
        });

        $("#imgInp2").change(function() {
            previewUpload(this);
        });



        const mostrarOcultarBtn = document.getElementById('mostrarOcultarBtn');
        const mostrarOcultarBtn2 = document.getElementById('mostrarOcultarBtn2');
        const senhaInput = document.getElementById('senha');
        const senhaInput2 = document.getElementById('confirma_senha');

        mostrarOcultarBtn.addEventListener('click', function() {
            if (senhaInput.type === 'password') {
                senhaInput.type = 'text';
            } else {
                senhaInput.type = 'password';
            }
        });
        mostrarOcultarBtn2.addEventListener('click', function() {
            if (senhaInput2.type === 'password') {
                senhaInput2.type = 'text';
            } else {
                senhaInput2.type = 'password';
            }
        });

        // Função para enviar um "heartbeat" a cada 30 segundos
        // Função para enviar um "heartbeat" a cada 30 segundos
        function sendHeartbeat() {
            var userId = <?php echo $id; ?>;
            $.ajax({
                type: 'POST',
                url: 'heartbeat.php', // Arquivo PHP para lidar com o "heartbeat"
                data: {
                    userId: userId
                },
            });
        }

        // Enviar um "heartbeat" a cada 1 segundos (ou outro intervalo de sua escolha)
        setInterval(sendHeartbeat, 1000); // 1 segundos

        function mostrarDivs() {
            const divOverlei = document.getElementById("divOverlei");
            const divLogoutMob = document.getElementById("divLogoutMob");

            if (divOverlei.style.opacity === "0" || divLogoutMob.style.opacity === "0") {
                divOverlei.style.opacity = "1";
                divLogoutMob.style.opacity = "1";
                divOverlei.style.pointerEvents = "auto"; // Ativar eventos de clique
                divLogoutMob.style.pointerEvents = "auto"; // Ativar eventos de clique
            } else {
                divOverlei.style.opacity = "0";
                divLogoutMob.style.opacity = "0";
                divOverlei.style.pointerEvents = "none"; // Desativar eventos de clique
                divLogoutMob.style.pointerEvents = "none"; // Desativar eventos de clique
            }
        }

        function fecharDiv() {
            const divOverlei = document.getElementById("divOverlei");
            const divLogoutMob = document.getElementById("divLogoutMob");

            if (divOverlei.style.opacity === "1" || divLogoutMob.style.opacity === "1") {
                divOverlei.style.opacity = "0";
                divLogoutMob.style.opacity = "0";
                divOverlei.style.pointerEvents = "none"; // Desativar eventos de clique
                divLogoutMob.style.pointerEvents = "none"; // Desativar eventos de clique
            } else {
                divOverlei.style.opacity = "1";
                divLogoutMob.style.opacity = "1";
                divOverlei.style.pointerEvents = "auto"; // Ativar eventos de clique
                divLogoutMob.style.pointerEvents = "auto"; // Ativar eventos de clique
            }
        }

        function abrirEdit() {

            const openEdit = document.getElementById("opEdit");

            if (openEdit.style.display === "none") {
                openEdit.style.display = "block";
            } else {
                openEdit.style.display = "none";
            }
        }

        function showConfirmationDialog(message, callback) {
            // Crie um campo de entrada para o motivo
            Swal.fire({
                title: 'Confirmação',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    callback(true, result.value); // Chame a função de retorno de chamada com true e o motivo
                } else {
                    callback(false);
                }
            });
        }

        function confirmDeletePostagem(postagem_id) {
            showConfirmationDialog("Tem certeza de que deseja excluir esta postagem?", function(confirmed) {
                if (confirmed) {
                    // Use AJAX para enviar o ID da postagem ao servidor para exclusão
                    $.ajax({
                        url: 'deletePostagem.php',
                        method: 'POST',
                        data: {
                            postagem_id: postagem_id
                        },
                        dataType: 'json', // Indica que esperamos uma resposta JSON do servidor
                        success: function(data) {
                            if (data.success) {
                                // Exiba uma mensagem de sucesso usando Swal
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Postagem excluída com sucesso!',
                                }).then(function() {
                                    // Atualize a lista de postagens se desejado
                                    $(document).trigger('postExcluida');
                                    updatePosts(); // Chama a função para atualizar as postagens após a exclusão
                                });
                            } else {
                                // Exiba uma mensagem de erro usando Swal
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro ao excluir postagem',
                                    text: 'Ocorreu um erro ao excluir a postagem. Por favor, tente novamente mais tarde.',
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro na requisição AJAX: ' + error);
                            // Exiba uma mensagem de erro usando Swal
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro na requisição AJAX',
                                text: 'Ocorreu um erro na requisição AJAX. Por favor, tente novamente mais tarde.',
                            });
                        }
                    });
                }
            });
        }


        function deleteComment(commentId) {
            // Use a função showSwalConfirmation para exibir uma tela de confirmação
            showConfirmationDialog("Tem certeza de que deseja excluir este comentário?", function(confirmed) {
                if (confirmed) {
                    // Faça uma solicitação AJAX para excluir o comentário no lado do servidor
                    $.ajax({
                        url: 'delete_comment.php?comment_id=' + commentId,
                        method: 'GET',
                        success: function() {
                            // Dispare um evento indicando que o comentário foi excluído
                            $(document).trigger('comentarioExcluido', {
                                commentId: commentId
                            });
                        }
                    });
                }
            });
        }

        // Adicione funções para lidar com o menu de opções
        function showOptionsMenu(commentId) {
            var optionsMenu = document.getElementById('options-menu-' + commentId);
            optionsMenu.style.display = 'block';
        }

        function hideOptionsMenu(commentId) {
            var optionsMenu = document.getElementById('options-menu-' + commentId);
            optionsMenu.style.display = 'none';
        }

        function handleOptionClick(commentId, option) {
            // Lide com a opção clicada (por exemplo, 'Denunciar' ou 'Excluir')
            if (option === 'Denunciar') {
                // Altere o alert para chamar a função reportComment
                reportComment(commentId);
            } else if (option === 'Excluir') {
                deleteComment(commentId);
            }

            hideOptionsMenu(commentId);
        }


        // Adicione um evento de escuta de teclado para o campo de comentário
        $(document).ready(function() {
            updatePosts();
        });


        $(document).on('postAdicionada postExcluida', function() {
            updatePosts();
        });

        function showNotification(message, type, callback) {
            // Crie um elemento de notificação
            var notification = document.createElement('div');
            notification.className = 'notification ' + type;
            notification.innerHTML = message;

            // Adicione a notificação ao contêiner
            var container = document.getElementById('notification-container');
            container.appendChild(notification);

            // Adicione botões de ação à notificação
            var confirmButton = document.createElement('button');
            confirmButton.innerHTML = 'Confirmar';
            confirmButton.onclick = function() {
                container.removeChild(notification);
                callback(true); // Chame a função de retorno de chamada com true
            };
            notification.appendChild(confirmButton);

            var cancelButton = document.createElement('button');
            cancelButton.innerHTML = 'Cancelar';
            cancelButton.onclick = function() {
                container.removeChild(notification);
                callback(false); // Chame a função de retorno de chamada com false
            };
            notification.appendChild(cancelButton);
        }

        function reportPost(postagemId) {
            showSwalConfirmation("Você quer denúnciar essa postagem?", function(confirmed, reason) {
                if (confirmed) {
                    $.ajax({
                        url: 'report_post.php',
                        method: 'POST',
                        data: {
                            postagem_id: postagemId,
                            motivo: reason
                        },
                        success: function(response) {
                            var data = response;
                            if (data.status === 'success') {
                                // Exiba um alerta de sucesso usando Swal
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucesso!',
                                    text: data.message,
                                }).then(function() {
                                    // Recarregue as postagens após a denúncia
                                    updatePosts();
                                });
                            } else {
                                // Exiba um alerta de erro usando Swal
                                Swal.fire('Erro!', data.message, 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro na requisição AJAX: ' + error);
                            // Exiba um alerta de erro usando Swal
                            Swal.fire('Erro!', 'Erro ao realizar a denúncia. Por favor, tente novamente mais tarde.', 'error');
                        }
                    });
                }
            });
        }

        function reportComment(commentId) {
            showSwalConfirmation("Você quer denunciar esse comentário?", function(confirmed, reason) {
                if (confirmed) {
                    $.ajax({
                        url: 'report_coment.php',
                        method: 'POST',
                        data: {
                            comment_id: commentId,
                            motivo: reason // Adicione o motivo aqui
                        },
                        success: function(response) {
                            var data = response;
                            if (data.status === 'success') {
                                // Exiba um alerta de sucesso usando Swal
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucesso!',
                                    text: data.message,
                                }).then(function() {
                                    // Atualize os comentários ou faça outra ação necessária
                                });
                            } else {
                                // Exiba um alerta de erro usando Swal
                                Swal.fire('Erro!', data.message, 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro na requisição AJAX: ' + error);
                            // Exiba um alerta de erro usando Swal
                            Swal.fire('Erro!', 'Erro ao realizar a denúncia. Por favor, tente novamente mais tarde.', 'error');
                        }
                    });
                }
            });
        }
    </script>

    <?php
    if (isset($_POST['alterar'])) {
        require('conecta.php');

        $login = $_POST['login'];
        $nomealterar = $_POST['nome'];
        $email = $_POST['email'];
        $descricao = $_POST['bio'];
        $senha_confirma = $_POST['senha'];
        $senha_nova = $_POST['confirma_senha'];
        if ($senha_confirma && $senha_nova != "") {
            if (password_verify($senha_confirma, $senha)) {
                $hash_senha = password_hash($senha_nova, PASSWORD_DEFAULT);
                $sql = "UPDATE login SET login='$login', email='$email', descricao='$descricao', nome='$nomealterar', senha='$hash_senha' WHERE nome='$nome'";

                if ($conexao->query($sql) === TRUE) {
                    echo "<script>
    Swal.fire({
        title: 'Sucesso',
        text: 'Alterado com sucesso !',
        icon: 'success',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'perfil.php';
        }
    });
</script>";
                } else {
                    echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'Falha ao alterar !',
            icon: 'error'
        });
        exit();
    </script>";
                }
            } else {
                echo "<script>
                Swal.fire({
                    title: 'Erro',
                    text: 'As senhas não conferem !',
                    icon: 'error'
                });
                exit();
            </script>";
            }
        } else {
            $sql = "UPDATE login SET login='$login', email='$email', descricao='$descricao', nome='$nomealterar' WHERE nome='$nome'";

            if ($conexao->query($sql) === TRUE) {
                echo "<script>
    Swal.fire({
        title: 'Sucesso',
        text: 'Alterado com sucesso !',
        icon: 'success',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'perfil.php';
        }
    });
</script>";
            } else {
                echo "<script>
                Swal.fire({
                    title: 'Erro',
                    text: 'Falha ao alterar !',
                    icon: 'error'
                });
                exit();
            </script>";
            }
        }


        $login = $_POST['login'];
        $sql = "SELECT * FROM login WHERE login ='$login'";
        $resultado = mysqli_query($conexao, $sql);
        $registro = mysqli_num_rows($resultado);
        while ($dados = mysqli_fetch_array($resultado)) {
            $_SESSION['nome'] = $dados['nome'];
            $_SESSION['id'] = $dados['id'];
            $_SESSION['senha'] = $dados['senha'];
            $_SESSION['login'] = $dados['login'];
            $_SESSION['email'] = $dados['email'];
            $_SESSION['celular'] = $dados['celular'];
            $_SESSION['tipo'] = $dados['tipo'];
            $_SESSION['picture'] = $dados['picture'];
            $_SESSION['descricao'] = $dados['descricao'];
        }
    }
    ?>
</body>

</html>