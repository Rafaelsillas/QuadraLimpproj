<?php

$email = $_POST['email'];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require __DIR__ . "/database.php";

$sql = "UPDATE login
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($mysqli->affected_rows) {

	$mail = require __DIR__ . "/mailer.php";

	$mail->setFrom("noreply@example.com");
	$mail->addAddress($email);
	$mail->Subject = "Mudar Senha";
	$mail->Body = <<<END

    Click <a href="http://localhost/tcc_midia/resetar-senha.php?token=$token">Aqui</a> 
    para mudar sua senha.

    END;

	try {

		$mail->send();

	} catch (Exception $e) {

		echo "A mensagem não pôde ser enviada. erro do correio: {$mail->ErrorInfo}";

	}

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />

	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="style/main.css">
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST">
					<span class="login100-form-title p-b-26">
						Olhe seu email
					</span>
					<span class="login100-form-title p-b-48">
						<i class=""></i>
						<img src="images/loguinho.png" class="img-login" style="height: 150px;">
					</span>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<a class="login100-form-btn" href="login.php">
								Fazer login
							</a>
						</div>
					</div>


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