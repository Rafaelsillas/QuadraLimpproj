<?php
session_start();
$id = $_SESSION['id'];
include("conecta.php");

if (isset($_GET["term"])) {
    $username = mysqli_real_escape_string($conexao, $_GET["term"]);

    $stmt = $conexao->prepare("SELECT id, nome, picture FROM login WHERE (nome LIKE '%$username%' AND id NOT LIKE '$id') 
    ORDER BY login");
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    if ($count < 1) {
        echo '<p class="noResults">Sem Resultados</p>';
    } else {
        while ($user = $result->fetch_assoc()) {
            ?>
            <a href="perfil.php?id=<?php echo $user['id']; ?>" class="row">
                <p>
                    <?php echo $user['nome']; ?>
                </p>
            </a>
            <?php
        }
    }

}
?>