<!DOCTYPE html>
<html lang="en">

<head>
	<title>Cadastrar</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icone1.png" />

<link rel="stylesheet" type="text/css" href="css1/boots.min.css">

<link rel="stylesheet" type="text/css" href="css1/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="css1/css/material-design-iconic-font.min.css">

<link rel="stylesheet" type="text/css" href="css1/main.css">	

<link rel="stylesheet" type="text/css" href="css1/estilo.css">	

	<style>
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>

</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form vaalidate-form" method="POST">
				<div class= "voltar">
					<h4><a class="txt3" style= "color: DodgerBlue;" href="index.html">
						Home
	            </a></h4>
					<span class="login100-form-title p-b-26">
						Bem vindo
					</span>
					<span class="login100-form-title p-b-48">
						<i class=""></i>
						<center><img src="images/icone1.png" style="height: 150px; width: auto; margin-bottom: 50px"></center>
					</span>

					<div class="wrap-input100 validate-input" data-validate="Login não valido">
						<input class="input100" type="text" name="login" placeholder="Login">
					</div>

					<div class="wrap-input100 validate-input" data-validate="Nome não valido">
						<input class="input100" type="text" name="nome" placeholder="Nome">
					</div>

					<div class="wrap-input100 validate-input" data-validate="Insira a Senha">
						<span class="btn-show-pass" id="mostrarOcultarBtn">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="senha" placeholder="Senha" id="senha">
					</div>

					<div class="wrap-input100 validate-input">
						<span class="btn-show-pass" id="mostrarOcultarBtn2">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="confirma_senha" placeholder="Confirme a senha" id="confirma_senha">
					</div>


					<div class="wrap-input100 validate-input" data-validate="Email não valido">
						<input class="input100" type="text" name="email" placeholder="Email">
					</div>
					<div class="wrap-input100 validate-input" style="display: flex;justify-content: center;" data-validate="Turno Obrigatório">
						<div class="itens">
							<label>
								<input type="checkbox" class="checkgroup" name="turno[]" value="Manha" onclick="marcaDesmarca(this)">Manhã
							</label>
							<label>
								<input type="checkbox" class="checkgroup" name="turno[]" value="Tarde" onclick="marcaDesmarca(this)">
								Tarde</label>
							<label>
								<input type="checkbox" class="checkgroup" name="turno[]" value="Integral" onclick="marcaDesmarca(this)">
								Integral</label>
						</div>
					</div>
</div>

					<div class="container-login100-form-btn" style="margin-top: -15px">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="cadastrar" >Cadastrar</button>
						</div>
					</div>
				</form>
				<div style="display: flex;justify-content: center;margin-top:10px;">
					<span class="txt1">
						Já tem uma conta?
					</span>

					<a class="txt2" style="margin-left:20px; margin-top:-5px; font-size:18px; color: DodgerBlue; font-weight: bold" href="login.php">
						Logar
					</a>
				</div>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>


	<script>
		function marcaDesmarca(caller) {
			var checks = document.querySelectorAll('input[type="checkbox"]');
			checks.forEach(c => c.checked = (c == caller));
		}

		const mostrarOcultarBtn = document.getElementById('mostrarOcultarBtn');
		const mostrarOcultarBtn2 = document.getElementById('mostrarOcultarBtn2');
		const senhaInput = document.getElementById('senha');
		const senhaInput2 = document.getElementById('confirma_senha');

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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js
"></script>
	<script src="js/jquery-3.7.0.min.js"></script>
	<script src="midia.js"></script>
	<?php
	require "delete_profiles.php";

	if (isset($_POST['cadastrar'])) {
		require "conecta.php";

		$login = $_POST['login'];
		$nome = $_POST['nome'];
		$senha = $_POST['senha'];
		$confirma_senha = $_POST['confirma_senha'];
		$email = $_POST['email'];
		$tipo = 1;
		$picture = "user.png";
		$allowedDomain = "gmail.com";

		//Declaramos a variável que vai receber o conteúdo da lista
		$turn = null;

		//Verificamos se o índice existe
		if (isset($_POST['turno'])) {

			//Atribuimos a variável todo conteúdo do índice
			$turn = $_POST['turno'];

			//Verificamos se a variável não é nula
			if ($turn !== null)

				//Percorremos todos os conteúdos do array
				for ($i = 0; $i < count($turn); $i++)

					//exibimos o valor atual na tela
					$turno = $turn[$i];

			if (strlen($senha) < 5 or !preg_match("/[a-z]/i", $senha) or !preg_match("/[0-9]/", $senha)) {
				echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'A senha deve conter pelo menos 5 caracteres, ter pelo menos uma letra e um número.',
            icon: 'error'
        });
    </script>";
				die();
			}

			if ($senha !== $confirma_senha) {
				echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'As senhas não coincidem.',
            icon: 'error'
        });
    </script>";

				die();
			} elseif (strpos($email, $allowedDomain) === false) {
				echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'Apenas e-mails com o domínio @gmail.com são permitidos.',
            icon: 'error'
        });
    </script>";
				die();
			}

			$buscar = "select login from login where login ='" . $login . "'";
			$resultado = mysqli_query($conexao, $buscar);
			while ($registro = mysqli_fetch_array($resultado)) {
				if ($login == $registro['login']) {
					echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'Login já Cadastrado.',
            icon: 'error'
        });
    </script>";
					exit;
				}
			}
			$buscar2 = "select email from login where email ='" . $email . "'";
			$resultado2 = mysqli_query($conexao, $buscar2);
			while ($registro2 = mysqli_fetch_array($resultado2)) {
				if ($email == $registro2['email']) {
					echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'Email já Cadastrado, caso tenha esquecido a senha você pode fazer a recuperação.',
            icon: 'error'
        });
    </script>";
					exit;
				}
			}
			$token = bin2hex(random_bytes(16));

			$token_hash = hash("sha256", $token);
			$hash_senha = password_hash($senha, PASSWORD_DEFAULT);

			$registro_timestamp = date("Y-m-d H:i:s");


			$stmt = $conexao->prepare("INSERT INTO login (login, nome, senha, email, turno, tipo, picture, valido, token_validate, registro_timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, 'n', ?, ?)");
			$stmt->bind_param("sssssssss", $login, $nome, $hash_senha, $email, $turno, $tipo, $picture, $token_hash, $registro_timestamp);

			if ($stmt->execute()) {

				$mail = require __DIR__ . "/mailer.php";
				$mail->Username = 'suporte.midiatec@midiatec.site';
				$mail->Password = 'Midia@2023';
				$mail->setFrom("suporte.midiatec@midiatec.site");
				$mail->addAddress($email);
				$mail->Subject = "Validar email";
				$mail->Body = <<<END

    Acesse esse link para validar seu email: <a href="http://midiatec.site/tcc/validar-email.php?token=$token">Aqui</a>.

    END;

				try {

					$mail->send();
				} catch (Exception $e) {

					echo "A mensagem não pôde ser enviada. erro do correio: {$mail->ErrorInfo}";
				}
			}
			if ($mail->send()) {
				echo "<script>
    Swal.fire({
        title: 'Sucesso',
        text: 'Olhe seu email para validar, após 5 minutos sem validação seu cadastro será excluído. Pode demorar alguns minutos para chegar à sua caixa de entrada!',
        icon: 'success',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'login.php';
        }
    });
</script>";
			} else {
				echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'Erro ao mandar email, tente se cadastrar novamente daqui alguns minutos.',
            icon: 'error'
        });
    </script>";
			}
		} else {
			echo "<script>
        Swal.fire({
            title: 'Erro',
            text: 'Erro ao cadastrar.',
            icon: 'error'
        });
    </script>";
		}

		$stmt->close();
		$conexao->close();
	}

	?>
</body>

</html>