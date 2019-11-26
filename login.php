<?php
    session_start();
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Confirmar loggin e iniciar sesión</title>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
			<?php
			#mandamos a traer el archivo para iniciar conexion
			include 'conexion.php';
			#hacemos la conexion con nuetra BD
			$conectar = mysqli_connect($cons_equipo,$cons_usario,$cons_contra,$cons_base_name);
			if (!$conectar) {
				die("Connection failed: " . mysqli_connect_error());
			}
			// datos enviados de sesion.html 
			$corre = $_POST['user'];
            $contra = $_POST['pass1'];

            // Query enviado a la BD
            $resultado = mysqli_query($conectar, "SELECT id_sesion, correo, password FROM sesion WHERE correo = '$corre'");

            // La variable $fila mantenga el resultado de la consulta
            $fila = mysqli_fetch_assoc($resultado);

            // La variable $hashed_password va a mantener el hash de contraseña en la base de datos
            $hashed_password = $fila['password'];

            /* 
            La función password_verify() verifica si la contraseña ingresada por el usuario
            coincide con el hash de contraseña en la base de datos. Si todo está bien la sesión
            se crea por un minuto. Cambie 1 en $ _SESSION [inicio] a 5 para una sesión de 5 minutos.
			*/

			if (password_verify($_POST['pass1'],$hashed_password)) 
			{	
				$_SESSION['loggedin'] = true;
				$_SESSION['name'] = $fila['id_sesion'];
				$_SESSION['start'] = time();
				$_SESSION['expire'] = $_SESSION['start'] + (5 * 60) ;
				echo "<div class='alert alert-success mt-4' role='alert'><strong>Welcome!</strong> $fila[id_sesion]			
				<p><a href='edit-profile.php'>Edit Profile</a></p>	
				<p><a href='logout.php'>Logout</a></p></div>";	
			}
			else
			{
				echo "<div class='alert alert-danger mt-4' role='alert'>El correo o la contraseña son incorrectos!
				<p><a href='sesion.html'><strong>Por favor intentelo de nuevo!</strong></a></p></div>";
			}
			?>
</div>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

	</body>
</html>