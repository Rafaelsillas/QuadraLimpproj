<button onclick="toggleForm()" class="add-postagem">Adicionar comunicado</button>
<?php
require_once('conecta.php');
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
$consulta = "SELECT * FROM postagens ORDER BY data_mensagem DESC";
$resultado = mysqli_query($conexao, $consulta);

$posts = []; // Crie uma matriz para armazenar as postagens

while ($row = mysqli_fetch_array($resultado)) {
    $posts[] = $row; // Adicione cada postagem à matriz de postagens
}

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
?>
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
    </script>
</body>

</html>