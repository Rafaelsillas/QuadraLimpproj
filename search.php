<?php
session_start();
$id = $_SESSION['id'];
include("conecta.php");

if (isset($_GET["term"])) {
    $username = $_GET["term"];

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
            <div class="row" onclick="$('#searchContainer').hide(); chat('<?php echo $user['id']; ?>');">
                <img src="profilePics/<?php echo $user["picture"]; ?>" />
                <p>
                    <?php echo $user['nome']; ?>
                </p>
            </div>
            <?php
        }
    }

}
?>