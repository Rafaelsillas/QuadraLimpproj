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
  <link rel="icon" href="images/icone1.png">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>Quadra Limp</title>
  <style>
    .space-apps {
      width: calc(100% - 225px);
      display: flex;
      justify-content: center;
      /* Centralizar horizontalmente os elementos dentro da space-apps */
      margin: 20px;
      padding-left: 100px
    }

    .center,
    .center1,
    .center2 {
      transform: scale(1.5);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 20px;
      padding: 80px;
      margin-top: 150px;
    }

    /* Adicione Media Queries para ajustar o posicionamento em telas menores */
    @media (max-width: 768px) {

      .center,
      .center1,
      .center2 {
        transform: scale(1);
        /* Reduzir a escala em telas menores */
        margin-top: 100px;
        /* Redefinir as margens conforme necessário */
        margin-left: 0;
      }
    }

    .article-card {
      width: 280px;
      height: 180px;
      border-radius: 12px;
      overflow: hidden;
      position: relative;
      font-family: Arial, Helvetica, sans-serif;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
      transition: all 300ms;

    }

    .article-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }

    .article-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .article-card .content1 {
      box-sizing: border-box;
      width: 100%;
      position: absolute;
      padding: 30px 20px 20px 20px;
      height: auto;
      bottom: 0;
      background: linear-gradient(transparent, rgba(0, 0, 0, 0.6));
    }

    .article-card .date,
    .article-card .title {
      margin: 0;
    }

    .article-card .date {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.9);
      margin-bottom: 4px;
    }

    .article-card .title {
      font-size: 17px;
      color: #fff;
    }

    .second-space {
      width: calc(100% - 225px);
      height: 30%;
      display: flex;
      justify-content: center;
      /* Centralizar horizontalmente os elementos dentro da space-apps */
      position: absolute;
      top: 550px;
      margin: 20px;
      padding-left: 100px
    }

    .center-sec,
    .center-sec1,
    .center-sec2 {
      transform: scale(1.5);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 20px;
      padding: 80px;
    }

    /* Adicione Media Queries para ajustar o posicionamento em telas menores */
    @media (max-width: 768px) {

      .center,
      .center1,
      .center2 {
        transform: scale(1);
        /* Reduzir a escala em telas menores */
        margin-top: 100px;
        /* Redefinir as margens conforme necessário */
        margin-left: 0;
      }
    }

    .article-card-sec {
      width: 280px;
      height: 180px;
      border-radius: 12px;
      overflow: hidden;
      position: relative;
      font-family: Arial, Helvetica, sans-serif;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
      transition: all 300ms;

    }

    .article-card-sec:hover {
      transform: translateY(-2px);
      box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }

    .article-card-sec img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .article-card-sec .content-sec {
      box-sizing: border-box;
      width: 100%;
      position: absolute;
      padding: 30px 20px 20px 20px;
      height: auto;
      bottom: 0;
      background: linear-gradient(transparent, rgba(0, 0, 0, 0.6));
    }

    .article-card-sec .date,
    .article-card-sec .title {
      margin: 0;
    }

    .article-card-sec .date {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.9);
      margin-bottom: 4px;
    }

    .article-card-sec .title {
      font-size: 17px;
      color: #fff;
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
          <a href="#">
            <i class='bx bxs-heart icon' id="icone"></i>
            <span class="text nav-text">Notificações</span>
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
    <div class="overlay" id="meuFormulario2">
      <div class="fundo" id="meuFormulario">
        <i class='bx bx-x' onclick="fecharFormulario()"></i>
      </div>
    </div>
    <div class="space-apps">
      <div class="center" onclick="abrirFormulario()">
        <div class="article-card">
          <div class="content1">
            <p class="date">Conheça</p>
            <p class="title">Futuro Investidor</p>
          </div>
          <img src="images/futuro-investidor.png" alt="article-cover" />
        </div>
      </div>
      <div class="center1">
        <a href="https://sabordobem.site/" target="_blank" rel="noopener noreferrer">
          <div class="article-card">
            <div class="content1">
              <p class="date">Conheça</p>
              <p class="title">Sabor de Bem</p>
            </div>
            <img src="images/sabor-do-bem.png" alt="article-cover" />
          </div>
        </a>
      </div>
      <div class="center2">
        <div class="article-card">
          <div class="content1">
            <p class="date">Conheça</p>
            <p class="title">Conatus</p>
          </div>
          <img src="images/Cop.png" alt="article-cover">
        </div>
      </div>
    </div>
    <div class="second-space">
      <div class="center-sec">
        <div class="article-card-sec">
          <div class="content-sec">
            <p class="date">Conheça</p>
            <p class="title">Street Rango</p>
          </div>
          <img src="images/street rango.png" alt="article-cover" />
        </div>
      </div>
      <div class="center-sec1">
        <div class="article-card-sec">
          <div class="content-sec">
            <p class="date">Conheça</p>
            <p class="title">PsicoSaveME</p>
          </div>
          <img src="images/psico.png" alt="article-cover" />
        </div>
      </div>
      <div class="center-sec2">
        <div class="article-card-sec">
          <div class="content-sec">
            <p class="date">Conheça</p>
            <p class="title">Brain Strike</p>
          </div>
          <img src="images/strike.png" alt="article-cover" />
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
        data: {
          userId: userId
        },
      });
    }

    // Enviar um "heartbeat" a cada 1 segundos (ou outro intervalo de sua escolha)
    setInterval(sendHeartbeat, 1000); // 1 segundos

    function abrirFormulario() {
      var formulario = document.getElementById("meuFormulario");
      var formulario2 = document.getElementById("meuFormulario2");
      formulario.style.display = "block";
      formulario2.style.display = "block";
      setTimeout(function() {
        formulario.style.opacity = "1";
        formulario2.style.opacity = "1";
      }, 10);
    }

    function fecharFormulario() {
      var formulario = document.getElementById("meuFormulario");
      var formulario2 = document.getElementById("meuFormulario2");

      setTimeout(function() {
        formulario.style.display = "none";
        formulario2.style.display = "none";
      }, 100); // Tempo correspondente à duração da transição (0.3s)
    }
  </script>
</body>

</html>