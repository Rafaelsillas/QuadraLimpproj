<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="style.css">
	<link rel="icon" href="images/icon.png">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css
" rel="stylesheet">
</head>

<body>
	<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js
"></script>
	<script src="js/jquery-3.7.0.min.js"></script>
	<script src="midia.js"></script>
	<?php
	include("conecta.php");
	$token = $_GET["token"];

	$token_hash = hash("sha256", $token);


	$update = $conexao->prepare("UPDATE `login` SET valido = 'y' WHERE token_validate = ?");
	$update->bind_param("i", $token_hash);

	if ($update->execute()) {
		echo "<script>
                Swal.fire({
                    title: 'Sucesso',
                    text: 'Email validado com sucesso!',
                    icon: 'success'
                }).then(() => {
                    window.location.href='login.php'
                });
            </script>";
	}
	?>
</body>

</html>