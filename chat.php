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
                        <i class='bx bxs-heart icon'></i>
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
        <div class="side-mobi">
            <div class="bar-cont">
                <a href="index.php"><i class='bx bxs-home icon'></i></a>
                <a href="novidades.php"><i class='bx bx-search icon'></i></a>
                <a href="index.php"><img src="images/loguinho.png"></a>
                <i class='bx bxs-heart icon' id="icone"></i>
                <a href="perfil.php"><i class='bx bxs-user icon'></i></a>

            </div>
        </div>
        <div class="ciminha">
            <div class="mobi-cima">
                <div class="text-mobi">
                    <p>Quadra Limp</p>
                </div>
                <i class='bx bx-moon icon moon moony' id="modoIcone"></i>

                <a href="chat.php"><i class='bx bxs-message-rounded-dots icononsons'></i></a>
            </div>
        </div>
        <div class="top">
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
        <div id="inbox" class="column">
            <p class="title">Conversas</p>
            <input type="text" maxlength="15" name="username" class="searchField" onkeyup="search()" placeholder="Pesquisar utilizador" />
            <div id="searchContainer" onclick="ocultarDiv2()"></div>
            <div class="container" onclick="ocultarDiv()">
                <?php


                /* ?>
                <div class="chat selected" onclick="chat('<?php echo $user['Id']; ?>')">
                    <img src="img/globe.png" />
                    <p>Toda a comunidade</p>
                </div>
                <?php */

                // Query
                $stmt = $conexao->prepare("SELECT * FROM conversations WHERE (MainUser = ?) ORDER BY Modification DESC");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $count = $result->num_rows;



                if ($count < 1) {
                    echo '<div class="empty"><p>Pesquise um utilizador e começe um chat!</p></div>';
                }

                $stmt = $conexao->prepare("SELECT gc.id, gc.name, gc.imagem
                          FROM group_conversations gc
                          INNER JOIN group_members gm ON gc.id = gm.conversation_id
                          WHERE gm.user_id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $group_results = $stmt->get_result();

                while ($inbox = $result->fetch_assoc()) {
                    $stmt = $conexao->prepare("SELECT id, nome, picture FROM login WHERE (id LIKE ?) LIMIT 1");
                    $stmt->bind_param("i", $inbox["OtherUser"]);
                    $stmt->execute();
                    $user = $stmt->get_result()->fetch_assoc();


                    if ($user) {
                ?>
                        <?php if ($inbox["Unred"] == "y") { ?>
                            <div class="chat new" onclick="chat('<?php echo $user['id']; ?>')">
                                <img src="profilePics/<?php echo $user["picture"]; ?>" />
                                <p class="p">
                                    <?php echo $user["nome"]; ?>
                                </p>
                                <i class='bx bxs-circle numero-notificacao'></i>
                                <?php
                                $stmt = $conexao->prepare("SELECT message_new FROM conversations WHERE MainUser = ? AND OtherUser = ?");
                                $stmt->bind_param("ii", $id, $inbox["OtherUser"]);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $numero_messagesNew = $row['message_new']; // Incremento do valor
                                ?>
                                <p class="p-notificacao">
                                    <?php echo $numero_messagesNew ?>
                                </p>
                            </div>
                        <?php } else { ?>
                            <div class="chat new" onclick="chat('<?php echo $user['id']; ?>')">
                                <img src="profilePics/<?php echo $user["picture"]; ?>" />
                                <p class="p">
                                    <?php echo $user["nome"]; ?>
                                </p>
                            </div>
                    <?php
                        }
                    }
                }

                while ($group = $group_results->fetch_assoc()) {
                    ?>
                    <div class="chat" onclick="chatGroup('<?php echo $group['id']; ?>')">
                        <img src="profilePics/<?php echo $group["imagem"]; ?>" />
                        <p class="p">
                            <?php echo $group["name"]; ?>
                        </p>
                    </div>
                <?php
                }
                ?>
            </div>
            <button onclick="toggleForm()" class="criar-grupo">
                <i class='bx bx-plus-circle icon'></i>
                <span class=" text nav-text">Criar Grupo</span>
                </a>
            </button>
        </div>
        <div id="overlay" class="overlay"></div>
        <div id="aparecer" class="form-add">
            <div>
                <span class="close-button" onclick="toggleForm()" title="Cancelar"><i class='bx bx-x'></i></span>
                <form action="chat.php" method="POST">
                    <label for="nome_grupo">Nome do Grupo:</label>
                    <input type="text" id="nome_grupo" name="nome_grupo" required>

                    <label for="membros">Membros:</label>
                    <select id="membros" name="membros[]" multiple>
                        <?php
                        // Recupere os membros disponíveis do banco de dados
                        $stmt = $conexao->prepare("SELECT id, nome FROM login WHERE id NOT LIKE $id");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Gere as opções do campo de seleção
                        while ($membro = $result->fetch_assoc()) {
                            echo '<option value="' . $membro["id"] . '">' . $membro["nome"] . '</option>';
                        }
                        ?>
                    </select>

                    <button type="submit">Criar Grupo</button>
            </div>
            </form>
        </div>
        </div>
        <div id="chat" class="column">
            <div class="empty">
                <img src="img/empty-chat.png" />
                <p>Selecione uma conversa para socializar com esse utilizador</p>
            </div>
        </div>
    </section>
    <?php
    include "conecta.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recupere o nome do grupo e os IDs dos membros do formulário
        $nome_grupo = $_POST["nome_grupo"];
        $membros_selecionados = $_POST["membros"];

        $membros_selecionados[] = $id;

        // Insira o novo grupo na tabela group_conversations
        $inserir_grupo = $conexao->prepare("INSERT INTO group_conversations (name,imagem) VALUES (?,'grupo.png')");
        $inserir_grupo->bind_param("s", $nome_grupo);
        $inserir_grupo->execute();
        $grupo_id = $inserir_grupo->insert_id; // Recupere o ID do grupo inserido

        // Insira os membros selecionados na tabela group_members
        foreach ($membros_selecionados as $membro_id) {
            $inserir_membro = $conexao->prepare("INSERT INTO group_members (conversation_id, user_id) VALUES (?, ?)");
            $inserir_membro->bind_param("ii", $grupo_id, $membro_id);
            $inserir_membro->execute();
        }
        echo "<script>
        Swal.fire({
            title: 'Sucesso',
            text: 'Grupo criado com sucesso!',
            icon: 'sucess'
        });
    </script>";
    }
    ?>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="midia.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var selectElement = document.getElementById("membros");

            selectElement.addEventListener("click", function(event) {
                var clickedOption = event.target;
                if (!event.ctrlKey && !event.metaKey) { // Verifica se Ctrl ou Cmd não estão pressionados
                    var isSelected = clickedOption.hasAttribute("selected");
                    if (!isSelected) {
                        clickedOption.setAttribute("selected", "selected");
                    } else {
                        clickedOption.removeAttribute("selected");
                    }
                }
            });
        });

        document.getElementById("selectArquivos").addEventListener("click", function() {
            document.getElementById("inputArquivos").click()
        });

        function toggleForm() {
            var form = document.getElementById("aparecer");
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

        function chat(id = 0) {
            $.ajax({
                url: 'chat1.php?id=' + id,
                success: function(data) {
                    $('#chat').html(data);
                    // Após carregar o chat, busque as mensagens iniciais
                    retrieveMessages(id);
                }
            });
        }

        function chatGroup(id = 0) {
            $.ajax({
                url: 'group_chat.php?id=' + id,
                success: function(data) {
                    $('#chat').html(data);
                    console.log(id);
                    retrieveMessages(id);
                }
            });
        }


        function search() {
            var term = $("input.searchField").val();
            if (term.length >= 1) {
                $.ajax({
                    url: 'search.php?term=' + term,
                    success: function(data) {
                        $('#searchContainer').show();
                        $('#searchContainer').html(data);
                    }
                });
            } else {
                $('#searchContainer').hide();
            }
        }

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

        function ocultarDiv() {
            if (window.matchMedia('(max-width: 768px)').matches) {
                var div = document.querySelector('.container'); // Adicione um ponto '.' antes de 'chat' e 'new'
                div.style.display = 'none';

                var div2 = document.querySelector('.criar-grupo'); // Seleciona a segunda div com a classe 'criar-grupo'
                div2.style.display = 'none'; // Define a propriedade 'display' para 

                var titleElement = document.querySelector('.title'); // Seleciona o elemento <p> com a classe 'title'
                titleElement.style.display = 'none'; // Define a propriedade 'displ

                var inputField = document.querySelector('.searchField'); // Seleciona o campo de entrada com a classe 'searchField'
                inputField.style.display = 'none'; // Define a propriedade 'display' para 'none' para ocultar o campo de entrada

                var div3 = document.querySelector('.ciminha'); // Seleciona a div com a classe 'ciminha'
                div3.style.display = 'none'; // Define a propriedade 'display' para 'none' para ocultar a terceira div

                var div4 = document.querySelector('.side-mobi'); // Seleciona a div com a classe 'ciminha'
                div4.style.display = 'none'; // Define a propriedade 'display' para 'none' para ocultar a terceira div
            }
        }

        function ocultarDiv2() {
            if (window.matchMedia('(max-width: 768px)').matches) {
                var div = document.querySelector('.container'); // Adicione um ponto '.' antes de 'chat' e 'new'
                div.style.display = 'none';

                var div2 = document.querySelector('.criar-grupo'); // Seleciona a segunda div com a classe 'criar-grupo'
                div2.style.display = 'none'; // Define a propriedade 'display' para 

                var titleElement = document.querySelector('.title'); // Seleciona o elemento <p> com a classe 'title'
                titleElement.style.display = 'none'; // Define a propriedade 'displ

                var inputField = document.querySelector('.searchField'); // Seleciona o campo de entrada com a classe 'searchField'
                inputField.style.display = 'none'; // Define a propriedade 'display' para 'none' para ocultar o campo de entrada

                var div3 = document.querySelector('.ciminha'); // Seleciona a div com a classe 'ciminha'
                div3.style.display = 'none'; // Define a propriedade 'display' para 'none' para ocultar a terceira div

                var div4 = document.querySelector('.side-mobi'); // Seleciona a div com a classe 'ciminha'
                div4.style.display = 'none'; // Define a propriedade 'display' para 'none' para ocultar a terceira div
            }
        }
    </script>
</body>

</html>