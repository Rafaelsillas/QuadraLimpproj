<!DOCTYPE html>
<html lang="en">

<head>
	<title>Esqueceu a Senha</title>
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
				<form class="login100-form validate-form" method="post" action="esqueceu-a-senha.php">
					<span class="login100-form-title p-b-26">
						Recuperar Senha
					</span>
					<span class="login100-form-title p-b-48">
						<i class=""></i>
						<img src="images/icone1.png" class="img-login" style="height: 150px;">
					</span>

					<div class="wrap-input100 validate-input" data-validate="Insira o Email">
						<input class="input100" type="email" name="email" placeholder="Email" required>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Enviar
							</button>
						</div>
					</div>

					<div style="display: flex;justify-content: center;margin-top:10px;">

						<a style="margin-left:20px;" href="login.php">
							Fazer login
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>



	<script src="vendor/animsition/js/animsition.min.js"></script>

	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

	<script src="vendor/select2/select2.min.js"></script>

	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>

	<script src="vendor/countdowntime/countdowntime.js"></script>

	<script src="js/main.js"></script>
	<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js
"></script>
	<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js
"></script>
	<script src="js/jquery-3.7.0.min.js"></script>
	<script src="midia.js"></script>
</body>

</html>

<?php

require "delete_profiles.php";
$email = $_POST['email'];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

require "conecta.php";

$sql = "UPDATE login
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($conexao->affected_rows) {

	$mail = require __DIR__ . "mailer.php";
	$mail->Username = 'suporte.midiatec@midiatec.site';
	$mail->Password = 'Midia@2023';
	$mail->setFrom("suporte.midiatec@midiatec.site");
	$mail->addAddress($email);
	$mail->Subject = "Recuperar senha";
	$mail->Body = <<<END

    Acesse esse link para recuperar sua senha: <a href="http://midiatec.site/tcc/resetar-senha.php?token=$token">Aqui</a>.

    END;

	try {

		$mail->send();
	} catch (Exception $e) {
		echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'A mensagem não pôde ser enviada. erro do correio: {$mail->ErrorInfo}',
            icon: 'error'
        });
    </script>";
	}
}
if ($mail->send()) {
	echo "<script>
        Swal.fire({
            title: 'Sucesso',
            text: 'Olhe seu email para resetar sua senha!',
            icon: 'sucess'
        });
    </script>";
} else {
	echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'Erro ao mandar email, tente novamente daqui alguns minutos.',
            icon: 'error'
        });
    </script>";
}
?>