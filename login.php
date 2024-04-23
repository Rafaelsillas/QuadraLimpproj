<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icone1.png" />

	<link rel="stylesheet" type="text/css" href="css1/boots.min.css">

	<link rel="stylesheet" type="text/css" href="css1/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="css1/css/material-design-iconic-font.min.css">

	<link rel="stylesheet" type="text/css" href="css1/main.css">	

	<link rel="stylesheet" type="text/css" href="css1/estilo.css">	

</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST">
				<div class= "voltar">
					<h4><a class="txt3" style= "color: DodgerBlue;"  href="index.html">
						Home
	            </a></h4>
					<span class="login100-form-title p-b-26">
						Bem vindo
					</span>
					<span class="login100-form-title p-b-48">
						<center><img src="images/icone1.png" class="img-login" style="height: 150px; width: auto; margin-bottom: 50px"></center>
					</span>

					<div class="wrap-input100 validate-input" data-validate="Login não valido">
						<input class="input100" type="text" name="login" placeholder="Login">
					</div>

					<div class="wrap-input100 validate-input" data-validate="Insira a Senha">
						<span class="btn-show-pass" id="mostrarOcultarBtn">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="senha" placeholder="Senha" id="senha">
					</div>

					<div style="display: flex; justify-content: center; margin-top:5px; font-weight: bold; color: DodgerBlue">
						<a style="margin-left:20px;" href="esqueceu-a-senha.php">
							Esqueçeu a senha?
						</a>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" name="entrar">
								Logar
							</button>
						</div>
					</div>

					<div style="display: flex;justify-content: center;margin-top:10px;">
						<span class="txt1">
							Você não tem uma conta?
						</span>

						<a style="margin-left:20px; font-weight: bold; color: DodgerBlue;" href="cadastrar.php">
							Cadastrar
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		const mostrarOcultarBtn = document.getElementById('mostrarOcultarBtn');
		const senhaInput = document.getElementById('senha');

		mostrarOcultarBtn.addEventListener('click', function () {
			if (senhaInput.type === 'password') {
				senhaInput.type = 'text';
			} else {
				senhaInput.type = 'password';
			}
		});
	</script>


	<div id="dropDownSelect1"></div>


	<link rel="stylesheet" href="css1/boots.min.css">
	<link rel="stylesheet" href="css1/animado.min.css">
 
  	<link rel="stylesheet" href="css1/et-line-font.css">
	<link rel="stylesheet" href="css1/font-awesome.min.css">

  	<link rel="stylesheet" href="css1/vegas.min.css">
	<link rel="stylesheet" href="css1/estilo.css">
  <link rel="icon" href="images/icon1.png">
	<link href='https://fonts.googleapis.com/css?family=Rajdhani:400,500,700' rel='stylesheet' type='text/css'>

	<?php
	
require "delete_profiles.php";
require_once 'conecta.php';

	if (isset($_POST['entrar'])) {

		$login = $_POST['login'];
		$senha = $_POST['senha'];

		$stmt = $conexao->prepare("SELECT senha, valido FROM login WHERE login = ?");
		$stmt->bind_param("s", $login);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows === 1) {
			$row = $result->fetch_assoc();
			$senhaCriptografada = $row['senha'];
			$valido = $row['valido'];
			if ($valido == 'n') {
				echo "<script> window.alert('Valide seu email para se logar!');
					window.location.href='login.php'
					</script>";
			} elseif (password_verify($senha, $senhaCriptografada)) {
				// Login bem-sucedido, redirecionar para a página de dashboard ou outra área restrita
				session_start();
				$SQL = "select * FROM login where login='" . $login . "'";
				$resultado = mysqli_query($conexao, $SQL);
				while ($dados = mysqli_fetch_array($resultado)) {
					$_SESSION['nome'] = $dados['nome'];
					$_SESSION['id'] = $dados['id'];
					$_SESSION['senha'] = $dados['senha'];
					$_SESSION['login'] = $dados['login'];
					$_SESSION['email'] = $dados['email'];
					$_SESSION['celular'] = $dados['celular'];
					$_SESSION['tipo'] = $dados['tipo'];
					$_SESSION['picture'] = $dados['picture'];
					$_SESSION['turno'] = $dados['turno'];
					$_SESSION['descricao'] = $dados['descricao'];
				}
				echo "<script> window.alert('Login feito com sucesso!');
					window.location.href='index.php'
					</script>";
				header('location:index.php');
			} else {
				echo "<script> window.alert('Acesso Negado!');</script>";
			}
		}
	}
	?>
</body>

</html>