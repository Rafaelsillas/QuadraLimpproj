<?php
$conexao = mysqli_connect('localhost', 'root', '', 'tcc');
mysqli_set_charset($conexao, 'UTF8');
if (!$conexao)
    echo "Não foi possível no momento.";

?>