<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

require "conecta.php";

$sql = "SELECT * FROM login
        WHERE reset_token_hash = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
	die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
	die("token has expired");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Mudar Senha</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />

	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="style/main.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css
" rel="stylesheet">
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="processo-reset-senha.php">
					<span class="login100-form-title p-b-26">
						Mudar Senha
					</span>
					<span class="login100-form-title p-b-48">
						<i class=""></i>
						<img src="images/loguinho.png" class="img-login" style="height: 150px;">
					</span>

					<input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

					<div class="wrap-input100 validate-input">
						<span class="btn-show-pass" id="mostrarOcultarBtn">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="senha" id="senha" placeholder="Nova senha">
					</div>

					<div class="wrap-input100 validate-input" data-validate="Insira a Senha">
						<span class="btn-show-pass" id="mostrarOcultarBtn2">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="senha_confirmar" id="senha_confirmar" placeholder="Repetir senha">
					</div>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="redefinir">
								Redefinir
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js
"></script>
	<script src="js/jquery-3.7.0.min.js"></script>
	<script src="midia.js"></script>
	<script>
		const mostrarOcultarBtn = document.getElementById('mostrarOcultarBtn');
		const mostrarOcultarBtn2 = document.getElementById('mostrarOcultarBtn2');
		const senhaInput = document.getElementById('senha');
		const senhaInput2 = document.getElementById('senha_confirmar');

		mostrarOcultarBtn.addEventListener('click', function() {
			if (senhaInput.type === 'password') {
				senhaInput.type = 'text';
			} else {
				senhaInput.type = 'password';
			}
		});
		mostrarOcultarBtn2.addEventListener('click', function() {
			if (senhaInput2.type === 'password') {
				senhaInput2.type = 'text';
			} else {
				senhaInput2.type = 'password';
			}
		});
	</script>


	<div id="dropDownSelect1"></div>


	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

	<script src="vendor/animsition/js/animsition.min.js"></script>

	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

	<script src="vendor/select2/select2.min.js"></script>

	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>

	<script src="vendor/countdowntime/countdowntime.js"></script>

	<script src="js/main.js"></script>

	<?php
	require_once 'conecta.php';
	?>