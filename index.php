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
$turno = $_SESSION['turno'];

$current_time = date('Y-m-d H:i:s'); // Obtém a data e hora atual no formato MySQL TIMESTAMP
$update_query = "UPDATE login SET online = '$current_time' WHERE id = '$id'";
mysqli_query($conexao, $update_query);

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
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css
" rel="stylesheet">
    <title>Quadra Limp</title>
</head>

<body>

    <nav class="sidebar close">
        <div id="minhaDiv" class="hidden-not">
            <h2>Notificações</h2>
        </div>
        <header>
            <div class="image-text">
                <span class="image">
                    <a href="index.php"><img src="images/icone1.png" alt="logo"></a>
                </span>
                <div class="text header-text">
                    <span class="name">Quadra Limp</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle' id="chevron"></i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="search" placeholder="Pesquise aqui.." onkeyup="search()">
                </li>
                <ul class="menu-links"></ul>
                <li class="nav-link">
                    <a href="index.php">
                        <i class='bx bxs-home icon'></i>
                        <span class="text nav-text">Inicio</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a id="iconeLink">
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
                <li class="nav-link">
                    <a href="perfil.php">
                        <i class='bx bxs-user icon'></i>
                        <span class="text nav-text">Perfil</span>
                    </a>
                </li>
                <?php
                if ($tipo == "admin") { ?>
                    <li class="nav-link">
                        <a href="denuncias.php">
                            <i class='bx bxs-error icon'></i>
                            <span class="text nav-text">Denuncias</span>
                        </a>
                    </li>
                <?php
                }
                ?>
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
    <div class="side-mobi">
        <div class="bar-cont">
            <a href="index.php"><i class='bx bxs-home icon'></i></a>
            <a href="novidades.php"><i class='bx bx-search icon'></i></a>
            <a href="index.php"><img src="images/icone1.png"></a>
            <i class='bx bxs-heart icon' id="icone"></i>
            <a href="perfil.php"><i class='bx bxs-user icon'></i></a>

        </div>
    </div>
    <div class="ciminha">
        <div class="mobi-cima">
            <div class="text-mobi">
                <p>Quadra Limp</p>
                <i class="bx bx-plus-circle boom" onclick="toggleForm()"></i>
            </div>
            <i class='bx bx-moon icon moon moony' id="modoIcone"></i>

            <a href="chat.php">
                <i class="bx bxs-message-rounded-dots icononsons"></i>
            </a>
        </div>
    </div>
    <section class="resto">
        <div class="top">
            <div class="search-barsin">
                <i class='bx bx-search'></i>
                <input type="text" name="username" placeholder="Pesquise aqui..." class="field" onkeyup="search()">
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
                <a href="logout.php" class="sub-menu-link">
                    <i class='bx bx-log-out ic'></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
        </div>
        <div class="right-bar">
            <div class="title-bar">
                <h4>Eventos</h4>
                <button onclick="toggleForm2()">+</button>

            </div>
            <div class="event">
                <div class="left-event">
                    <h3>23</h3>
                    <span style='font-size: 11px'>Abril</span>
                </div>

                <div class="right-event">
                    <h4>Alinhamentos</h4>
                    <p>Quadras de Areia</p>
                    <a href="https://www.instagram.com/quadralimp/" target="_blank">Mais informações</a>
                </div>

            </div>
            <div class="title-bar">
                <h4>Ultima atualização</h4>
            </div>
            <a href="https://www.instagram.com/quadralimp/" target="_blank"><img src="images/nao.png" class="side-ads"></a>

            <div class="title-bar">
                <h4>Online</h4>
                <i class='bx bx-radio-circle-marked loli'></i>
            </div>
            <div id="online-users-list">

            </div>


            </div>
        <div id="overlay" class="overlay"></div>
        <div id="formularioEvento" class="form-add" style='text-align: center'>
            <span class="close-button" onclick="toggleForm2()" title="Cancelar"><i class='bx bx-x'></i></span>
            <form method="post" action="adicionar_evento.php">
                <label>Data do Evento:</label>
                <input type="date" name="data_evento" required>
                <label>Título:</label>
                <input type="text" name="titulo" required>
                <label>Descrição:</label>
                <textarea id="mensagem" name="mensagem" rows="4" placeholder="Escreva sua mensagem" required class="textarea"></textarea>
                <button type="submit">Adicionar Evento</button>
            </form>
        </div>
        <div id="aparecer" class="form-add" style='text-align: center'>
            <span class="close-button" onclick="toggleForm()" title="Cancelar"><i class='bx bx-x'></i></span>
            <form action="index.php" method="POST" enctype="multipart/form-data">
                    <p>
                        Mensagem <textarea id="mensagem" name="mensagem" rows="4" placeholder="Escreva sua mensagem" required class="textarea"></textarea>
                    </p>
                    <p>
                        <input type="file" name="arquivo" />
                    </p>
                    <button name="inserirarquivo" style='text-align: center display: block; margin-left: auto; margin-right: auto;'>Inserir Arquivo</button>
            </form>
        
        </div>
        <div class="post-container">
        </div>
        <div id="notification-container"></div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="midia.js"></script>
    <script>
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

        const minhaDiv = document.getElementById('minhaDiv');
        const iconeLink = document.getElementById('iconeLink');
        const chevronIcon = document.getElementById('chevron');

        iconeLink.addEventListener('click', () => {
            minhaDiv.classList.toggle('hidden-not');
            chevronIcon.style.display = 'none';



            setTimeout(() => {
                if (minhaDiv.classList.contains('hidden-not')) {
                    minhaDiv.style.left = '-600px';
                    chevronIcon.style.display = 'block';
                } else {
                    minhaDiv.style.left = '0';
                    chevronIcon.style.display = 'none';
                }
            }, 200); // Tempo de atraso em milissegundos
        });

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

        function toggleForm2() {
            var form2 = document.getElementById("formularioEvento");
            var overlay = document.getElementById("overlay");

            if (form2.classList.contains("active")) {
                form2.classList.remove("active");
                overlay.style.display = "none";
                document.body.style.overflow = "auto"; // Re-enable scrolling
            } else {
                form2.classList.add("active");
                overlay.style.display = "block";
                document.body.style.overflow = "hidden"; // Disable scrolling
            }
        }

        // Função para enviar um "heartbeat" a cada 5 segundos
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
        setInterval(sendHeartbeat, 100); // 1 segundos

        function updateOnlineUsers() {
            $.ajax({
                url: 'get_online_users.php', // Substitua 'get_online_users.php' pelo caminho correto do seu arquivo PHP para obter usuários online.
                method: 'GET',
                success: function(data) {
                    // Atualize a lista de usuários online com os dados recebidos do servidor
                    $('#online-users-list').html(data);
                }
            });
        }

        // Atualize a lista de usuários online a cada 1 segundo (ou outro intervalo de sua escolha)
        setInterval(updateOnlineUsers, 100); // 1 segundo

        function showSwalConfirmation(message, callback, isComment = false) {
            // Crie um campo de entrada para o motivo
            Swal.fire({
                title: 'Confirmação',
                text: message,
                icon: 'question', // Mantenha 'info' como base
                showCancelButton: true,
                input: 'text',
                inputPlaceholder: 'Digite o motivo...',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Por favor, informe o motivo da denúncia.';
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    callback(true, result.value); // Chame a função de retorno de chamada com true e o motivo
                } else {
                    callback(false);
                }
            });
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

        function updatePosts() {
            // Realize uma solicitação AJAX para buscar as postagens mais recentes do servidor
            $.ajax({
                url: 'get_posts.php', // Substitua pelo nome do seu script para obter as postagens
                method: 'GET',
                success: function(data) {
                    // Atualize as postagens na página
                    $('.post-container').html(data);
                }
            });
        }

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

    if (isset($_POST['inserirarquivo'])) { // Verifica se o botão "Inserir Arquivo" foi clicado
        $consultaPunicao = "SELECT punido_at FROM login WHERE id = $id";

        if ($punicao['punido_at'] !== null && $punicao['punido_at'] > $current_time_str) {
            echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'Você está punido e não pode adicionar postagens neste momento.',
            icon: 'error'
        });
    </script>";
            exit();
        }
        $con = "SELECT * FROM login WHERE id = $id";
        $resultado = mysqli_query($conexao, $con);
        while ($row2 = mysqli_fetch_array($resultado))
            setlocale(LC_TIME, "portuguese");
        $mensagem = $_POST['mensagem'];
        $current_time = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $current_time_str = $current_time->format('Y-m-d H:i:s');

        if (isset($_FILES['arquivo'])) {
            $foto = $_FILES['arquivo'];
            $ext = strtolower(substr($foto['name'], -4));
            $new_name = date("Y.m.d-H.i.s") . $ext;
            $dir = 'img-postagem/';

            $extensoes_permitidas = array('.jpg', '.gif', '.png', '.bmp', '.jpeg');
            $extensao = strrchr($foto['name'], '.');

            if (!in_array(strtolower($extensao), $extensoes_permitidas) && $extensao != "") {
                echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'Por favor, envie arquivos com as seguintes extensões: jpg, gif, png, bmp ou jpeg.',
            icon: 'error'
        });
    </script>";
                exit;
            }
        } else {
            $new_name = '';
        }
        $caminho_destino = $dir . $new_name;
        if (move_uploaded_file($foto['tmp_name'], $caminho_destino)) {
            // Insira a postagem no banco de dados (dentro ou fora do bloco condicional)
            $gravar = "INSERT INTO postagens (id_pessoa, nome, mensagem, imagem, imagemperfil, data_mensagem) VALUES ('$id', '$nome', '$mensagem', '$new_name', '$picture', '$current_time_str')";
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
                    window.location.href = window.location.href;
                });
            </script>";
                exit;
            }
        }
    }
    ?>
</body>

</html>