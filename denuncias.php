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

if ($tipo != 'admin') {
    header('Location: index.php');
    exit();
}

$current_time = date('Y-m-d H:i:s'); // Obtém a data e hora atual no formato MySQL TIMESTAMP
$update_query = "UPDATE login SET online = '$current_time' WHERE id = '$id'";
mysqli_query($conexao, $update_query);

$mostrarBotoes = true;
$tipoDenunciaSelecionado = '';

// Verifique se o formulário de filtro foi enviado
if (isset($_GET['denunciaType'])) {
    $tipoDenunciaSelecionado = $_GET['denunciaType'];
}

// Verifique se o formulário foi enviado (quando um botão é clicado)
if ($tipoDenunciaSelecionado === '' || $tipoDenunciaSelecionado === 'todos') {
    $query = "SELECT * FROM denuncias";
} else {
    $query = "SELECT * FROM denuncias WHERE tipo_entidade = '$tipoDenunciaSelecionado'";
}

// Adicione a cláusula ORDER BY para ordenar pela data de criação (assumindo que o campo é chamado 'data_criacao')
$query .= " ORDER BY data_denuncia DESC";

$result = mysqli_query($conexao, $query);

// Verifique se há denúncias
if ($result) {
    $denuncias = array();

    // Use um loop while para obter todas as linhas
    while ($row = mysqli_fetch_assoc($result)) {
        $denuncias[] = $row;
    }
} else {
    $denuncias = array(); // Se não houver denúncias, inicialize como um array vazio
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
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
    <title>MídiaTec</title>
    <style>
        .form-postcoment {
            display: flex;
            margin-top: 100px;
        }

        .form-postcoment button {
            margin: 0 10px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .filtro-botoes button {
            background-color: #ca8a33;
            color: white;
            border: none;
            width: 120px;
            /* Ajuste a largura conforme necessário */
            height: 30px;
            /* Ajuste a altura conforme necessário */
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            /* Ajuste o tamanho da fonte conforme necessário */
            margin-right: 5px;
        }

        .filtro-botoes p {
            display: inline-block;
            margin-right: 10px;
        }

        .filtro-botoes button.selecionado {
            background-color: #1659a7;
        }

        .cards-denuncias {
            display: flex;
            flex-wrap: wrap;
            /* Permitir que os cards quebrem para a próxima linha quando não houver espaço suficiente */
            justify-content: flex-start;
            /* Alinhar os cards à esquerda */
            padding: 30px;
        }

        .denuncia-container {
            box-sizing: border-box;
            /* Inclui padding e borda na contagem total de largura/altura */
            padding: 20px;
            max-width: 300px;
            /* Definir uma altura fixa para os cards */
            margin: 10px;
            /* Adicionar margem entre os cards */
            cursor: pointer;
            transition: box-shadow 0.3s ease-in-out;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .denuncia-container:hover {
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
            /* Adicionar uma sombra mais pronunciada ao passar o mouse sobre o card */
        }

        .denuncia-container p {
            padding: 5px;
            margin: 5px 0;
            overflow: hidden;
            /* Evitar que o conteúdo ultrapasse a altura do card */
            text-overflow: ellipsis;
            /* Adicionar reticências (...) para indicar que o conteúdo foi cortado */
            white-space: nowrap;
            /* Impedir que o texto seja quebrado em várias linhas */
        }

        .denuncia-container img {
            max-width: 100%;
            /* Garantir que a imagem não ultrapasse a largura do card */
            height: auto;
            /* Permitir que a altura da imagem seja ajustada proporcionalmente à largura */
            margin-top: 10px;
            /* Adicionar margem acima da imagem */
        }
    </style>
</head>

<body>

    <nav class="sidebar close">
        <div id="minhaDiv" class="hidden-not">
            <h2>Notificações</h2>
        </div>
        <header>
            <div class="image-text">
                <span class="image">
                    <a href="index.php"><img src="images/loguinho.png" alt="logo"></a>
                </span>
                <div class="text header-text">
                    <span class="name">MídiaTec</span>
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
            <a href="index.php"><img src="images/loguinho.png"></a>
            <i class='bx bxs-heart icon' id="icone"></i>
            <a href="perfil.php"><i class='bx bxs-user icon'></i></a>

        </div>
    </div>
    <div class="ciminha">
        <div class="mobi-cima">
            <div class="text-mobi">
                <p>MídiaTec</p>
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
        <div id="denuncias" class="denuncias">
            <div class="form-postcoment">
                <p>Filtrar por:</p>
                <div class="filtro-botoes">
                    <form method="get">
                        <button type="submit" name="denunciaType" value="postagem" <?php echo ($tipoDenunciaSelecionado === 'postagem') ? 'class="selecionado"' : ''; ?>>Postagem</button>
                        <button type="submit" name="denunciaType" value="comentario" <?php echo ($tipoDenunciaSelecionado === 'comentario') ? 'class="selecionado"' : ''; ?>>Comentários</button>
                        <button type="submit" name="denunciaType" value="todos" <?php echo ($tipoDenunciaSelecionado === '' || $tipoDenunciaSelecionado === 'todos') ? 'class="selecionado"' : ''; ?>>Todos</button>
                    </form>
                </div>
            </div>
            <div class="cards-denuncias">
                <?php
                // Exibir denúncias com base no tipo selecionado
                if (!empty($denuncias)) {
                    foreach ($denuncias as $denuncia) {
                        $idAutor = $denuncia['id_autor'];
                        $queryNomeAutor = "SELECT nome FROM login WHERE id = $idAutor";
                        $resultNomeAutor = mysqli_query($conexao, $queryNomeAutor);
                        while ($row = mysqli_fetch_array($resultNomeAutor)) {
                            $nomeAutor = $row['nome'];
                        }

                        echo '<div id="denuncia-' . $denuncia['id_denuncia'] . '" class="denuncia-container" onclick="exibirDetalhes(' . $denuncia['id_denuncia'] . ')" data-id="' . $denuncia['id_autor'] . '" data-nome="' . $nomeAutor . '" data-motivo="' . $denuncia['motivo'] . '" data-conteudo="' . htmlspecialchars($denuncia['conteudo']) . '" data-imagem="' . $denuncia['imagem_conteudo'] . '" data-tipo-entidade="' . $denuncia['tipo_entidade'] . '" data-id-entidade="' . $denuncia['id_entidade'] . '">';
                        echo '<p><strong>Tipo : </strong>' . $denuncia['tipo_entidade'] . '</p>';
                        echo '<p><strong>Motivo:</strong> ' . $denuncia['motivo'] . '</p>';

                        if ($denuncia['tipo_entidade'] === 'postagem') {
                            // Verifica se há imagem
                            if ($denuncia['imagem_conteudo'] != '') {
                                echo '<img src="img-postagem/' . $denuncia['imagem_conteudo'] . '" alt="Imagem da Postagem">';
                            }

                            // Exibe o conteúdo da postagem, mesmo se não houver imagem
                            echo '<p><strong>Postagem:</strong> ' . $denuncia['conteudo'] . '</p>';
                        } elseif ($denuncia['tipo_entidade'] === 'comentario') {
                            echo '<p><strong>Comentário:</strong> ' . $denuncia['conteudo'] . '</p>';
                        }

                        echo '</div>';
                    }
                } else {
                    echo '<p style="text-align: center;">Nenhuma denúncia encontrada.</p>';
                }
                ?>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="midia.js"></script>
    <script>
        function punirUsuario(idUsuario, idDenuncia, tipoEntidade, idEntidade) {
            // Exibir modal do SweetAlert para escolher o tempo e motivo da punição
            Swal.fire({
                title: 'Punir Usuário',
                html: `<label for="tempo">Tempo de Punição:</label>
                <input type="number" id="tempo" class="swal2-input" min="1" required>
                <select id="unidadeTempo" class="swal2-select" required>
                    <option value="horas">Horas</option>
                    <option value="dias">Dias</option>
                </select>
                <label for="motivo">Motivo da Punição:</label>
                <input type="text" id="motivo" class="swal2-input" required>`,
                showCancelButton: true,
                confirmButtonText: 'Punir',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const tempo = Swal.getPopup().querySelector('#tempo').value;
                    const unidadeTempo = Swal.getPopup().querySelector('#unidadeTempo').value;
                    const motivo = Swal.getPopup().querySelector('#motivo').value;
                    return {
                        tempo,
                        unidadeTempo,
                        motivo
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Converter o tempo para horas (selecionado em minutos ou dias)
                    let tempoEmHoras = result.value.tempo;
                    if (result.value.unidadeTempo === 'dias') {
                        tempoEmHoras *= 24; // Converter dias para horas
                    }
                    console.log('idUsuario:', idUsuario);
                    console.log('idDenuncia:', idDenuncia);
                    console.log('tipoEntidade:', tipoEntidade);
                    console.log('idEntidade:', idEntidade);
                    // Fazer uma requisição AJAX para punir o usuário com tempo e motivo escolhidos
                    $.ajax({
                        type: "POST",
                        url: "punir_usuario.php",
                        data: {
                            id_usuario: idUsuario,
                            tempoEmHoras: tempoEmHoras,
                            unidadeTempo: result.value.unidadeTempo,
                            motivo: result.value.motivo,
                            tipoEntidade: tipoEntidade, // Passar tipoEntidade para o PHP
                            idEntidade: idEntidade // Passar idEntidade para o PHP
                        },
                        success: function(response) {
                            removerDenuncia(idDenuncia);
                            Swal.fire('Sucesso', response, 'success');
                            removerDenunciaDaInterface(idDenuncia);

                            // Remova a postagem ou comentário da interface
                            const entityElement = document.getElementById(`${tipoEntidade}-${idEntidade}`);
                            if (entityElement) {
                                entityElement.remove();
                            }
                        },
                        error: function(error) {
                            Swal.fire('Erro', 'Erro ao processar a punição.', 'error');
                        }
                    });
                }
            });
        }

        function removerDenuncia(idDenuncia) {
            // Fazer requisição AJAX para remover a denúncia
            $.ajax({
                type: "POST",
                url: "remover_denuncia.php",
                data: {
                    id_denuncia: idDenuncia
                },
                success: function(response) {
                    // Adicionar qualquer ação necessária após remover a denúncia
                    console.log(response); // Exemplo: exibir resposta no console
                },
                error: function(error) {
                    Swal.fire('Erro', 'Erro ao cancelar a denúncia.', 'error');
                }
            });
        }

        function naoPunirDenuncia(idDenuncia) {
            // Exibir confirmação para não punir
            Swal.fire({
                title: 'Cancelar Denúncia',
                text: 'Tem certeza de que deseja cancelar esta denúncia?',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Fazer requisição AJAX para remover a denúncia
                    $.ajax({
                        type: "POST",
                        url: "remover_denuncia.php", // Substitua com o caminho correto
                        data: {
                            id_denuncia: idDenuncia
                        },
                        success: function(response) {
                            Swal.fire('Denúncia Cancelada', response, 'success');
                            removerDenunciaDaInterface(idDenuncia);
                        },
                        error: function(error) {
                            Swal.fire('Erro', 'Erro ao cancelar a denúncia.', 'error');
                        }
                    });
                }
            });
        }

        function removerDenunciaDaInterface(idDenuncia) {
            // Remover o elemento HTML correspondente à denúncia pelo ID
            const denunciaElement = document.getElementById(`denuncia-${idDenuncia}`);

            if (denunciaElement) {
                denunciaElement.remove(); // Remover o elemento da página
            }
        }

        function exibirDetalhes(idDenuncia) {
            const denunciaElement = document.getElementById(`denuncia-${idDenuncia}`);
            // Obter os dados da denúncia
            const idAutor = denunciaElement.getAttribute('data-id');
            const idEntidade = denunciaElement.getAttribute('data-id-entidade');
            const tipoEntidade = denunciaElement.getAttribute('data-tipo-entidade');
            const nomeAutor = denunciaElement.getAttribute('data-nome');
            const motivo = denunciaElement.getAttribute('data-motivo');
            const conteudo = denunciaElement.getAttribute('data-conteudo');
            const imagem = denunciaElement.getAttribute('data-imagem');

            // Declarar a variável detalhesMessage fora dos blocos if e else
            let detalhesMessage = '';

            if (`${imagem}` == '') {
                detalhesMessage = `
            <p><strong>Nome do Autor:</strong> ${nomeAutor}</p>
            <p><strong>Motivo:</strong> ${motivo}</p>
            <p><strong>Conteúdo:</strong> ${conteudo}</p>
        `;
            } else {
                detalhesMessage = `
            <p><strong>Nome do Autor:</strong> ${nomeAutor}</p>
            <p><strong>Motivo:</strong> ${motivo}</p>
            <p><strong>Conteúdo:</strong> ${conteudo}</p>
            <p><strong>Imagem:</strong></p>
            <img src="img-postagem/${imagem}" alt="Imagem da Postagem" style="max-width: 100%; height: auto; margin-top: 10px;">
        `;
            }

            // Criar a mensagem personalizada para o SweetAlert

            // Exibir o SweetAlert
            Swal.fire({
                title: 'Detalhes Completos da Denúncia',
                html: detalhesMessage,
                showCancelButton: true,
                confirmButtonText: 'Punir',
                cancelButtonText: 'Não Punir'
            }).then((result) => {
                if (result.isConfirmed) {
                    punirUsuario(idAutor, idDenuncia, tipoEntidade, idEntidade);
                } else {
                    naoPunirDenuncia(idDenuncia);
                }
            });
        }

        // Adicione este código ao final do seu arquivo JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Evento acionado quando a modal é fechada
            document.addEventListener('click', function(event) {
                const bodyPaddingRight = window.getComputedStyle(document.body, null).getPropertyValue('padding-right');

                if (bodyPaddingRight !== '0px') {
                    document.body.style.paddingRight = '0px';
                }
            });
        });
    </script>
</body>

</html>