<html>
<head>
	<title>Trackerman - Login</title>
	<?php
		include 'general/easyui_header.php';
		include 'general/header.php';
	?>
	<script type="text/javascript" src="lib/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="login/login.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body class="row">
	<div class="col-md-3">

	</div>
	<div class="col-md-6 vertical-center">
		<div class="loginpanel">
			<div class="row">
			<div class="col-md-5">
				<img src="images/trackermanlogo2_azul.png"></img>
			</div>				
			<div class="col-md-6">
				<form id="loginfrm" data-toggle="validator">
					<div class="form-group">
						<label for="email">Email</label>

						<input class="form-control" name="email" type="email" required></input>
					</div>

					<div class="form-group">
						<label for="password">Password</label>

						<input class="form-control" name="password" type="password" required></input>
					</div>
					<div>
						<button class="btn btn-default pull-right" id="submitbutton">Enviar</button>
					</div>

				</form>
				<div id="loginfailed" style="display:none;" class="alert alert-danger">
					Error de autenticacion: email o password erroneo
				</div>
			</div>
			</div>
		</div>
	</div>
	<div class="col-md-3">

	</div>

	<script type="text/javascript" src="login/login.js"></script>
</body>
</html>
