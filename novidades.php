<?php
require "delete_profiles.php";
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
$nome = $_SESSION['nome'];
$tipo = $_SESSION['tipo'];
$id = $_SESSION['id'];
$picture = $_SESSION['picture'];
$senha = $_SESSION['senha'];
$login = $_SESSION['login'];
$email = $_SESSION['email'];
$celular = $_SESSION['celular'];

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/icon.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>MídiaTec</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <a href="index.php"><img src="images/loguinho.png" alt="logo"></a>
                </span>
                <div class="text header-text">
                    <span class="name">MídiaTec</span>
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
                    <a href="#">
                        <i class='bx bxs-heart icon'></i>
                        <span class="text nav-text">Notificações</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="novidades.php">
                        <i class='bx bxs-bell icon'></i>
                        <span class="text nav-text">Novidades</span>
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
                        <span class="text nav-text">Apps amigos</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="sobre.php">
                        <i class='bx bxs-dog icon'></i>
                        <span class="text nav-text">Sobre nós</span>
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
        <a href="index.php"><i class='bx bxs-home icon' ></i></a>
        <a href="novidades.php"><i class='bx bx-search icon' ></i></a>
        <a href="index.php"><img src="images/loguinho.png" ></a>
        <i class='bx bxs-heart icon' id="icone"></i>
        <a href="perfil.php"><i class='bx bxs-user icon'></i></a>

    </div>
    </div>
    <div class="ciminha">
        <div class="mobi-cima"> 
            <div class="text-mobi"><p>MídiaTec</p></div>
        <i class='bx bx-moon icon moon moony' id="modoIcone"></i>

        <a href="chat.php"><i class='bx bxs-message-rounded-dots icononsons'></i></a>
    </div>
    </div>
    <div class="nov-mob">
    <input type="text" maxlength="15" name="username" class="searchField" onkeyup="search()" placeholder="Pesquisar utilizador" id="search-nov">
            <div id="online-users-list">

            </div>
    </div>
        <div class="top">
            <div class="search-barsin">
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Pesquise aqui...">
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
        </div>
    </section>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="midia.js"></script>
    <script>
        // Função para enviar um "heartbeat" a cada 30 segundos
  function sendHeartbeat() {
            var userId = <?php echo $id; ?>;
            $.ajax({
                type: 'POST',
                url: 'heartbeat.php', // Arquivo PHP para lidar com o "heartbeat"
                data: { userId: userId },
            });
        }

        // Enviar um "heartbeat" a cada 1 segundo (ou outro intervalo de sua escolha)
        setInterval(sendHeartbeat, 1000); // 1 segundo

        function updateOnlineUsers() {
            $.ajax({
                url: 'get_online_users_mob.php', // Substitua 'get_online_users.php' pelo caminho correto do seu arquivo PHP para obter usuários online.
                method: 'GET',
                success: function (data) {
                    // Atualize a lista de usuários online com os dados recebidos do servidor
                    $('#online-users-list').html(data);
                }
            });
        }

        // Atualize a lista de usuários online a cada 1 segundo (ou outro intervalo de sua escolha)
        setInterval(updateOnlineUsers, 100); // 1 milisegundo
    </script>
</body>

</html>