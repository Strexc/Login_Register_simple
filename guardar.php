<!doctype html>
<html lang="en">
  <head>
    <title>Create account on database</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
<body>
	<div class="container">

<?php
//primero conectarnos con el servidor de la base de datos

#mandamos a traer las variables del archivo conexion
include 'conexion.php';

#acemos la conexion con el servidor y la base de datos
$conectar = mysqli_connect($cons_equipo,$cons_usario,$cons_contra,$cons_base_name);
/*verificar conexion con servidor 
if(!$conectar)
{
	echo "No se pudo establecer conexion con el servicor";
}
else{
	echo "Conexion exitosa<br>";
}*/
$correo = $_POST['correo'];
$contra = $_POST['contrase'];

$checkEmail = "SELECT * FROM sesion WHERE correo = '$_POST[correo]' ";

#resultado obtenido de checkCorreo para verificar si existe.
$resultado = $conectar-> query($checkEmail);

#contamos las filas para verificar el resultado
$count = mysqli_num_rows($resultado);

    if ($count == 1) 
    {
	echo "<div class='alert alert-warning mt-4' role='alert'>
					<p>That email is already in our database.</p>
					<p><a href='sesion.html'>Please login here</a></p>
				</div>";
	}
	else
	{
		#encriptamos la contraseña
		$passHash = password_hash($contra, PASSWORD_DEFAULT);
		#enviamos los datos y contraseña ya encriptada a la BD
		$query = "INSERT INTO sesion (id_sesion, correo, password) VALUES ('', '$correo', '$passHash')";
			if (mysqli_query($conectar, $query)) {
		echo "<div class='alert alert-success mt-4' role='alert'><h3>Tu cuenta ha sido creada.</h3>
		<a class='btn btn-outline-primary' href='sesion.html' role='button'>INICIAR SESIÓN</a></div>";		
		} else {
			echo "Error: " . $query . "<br>" . mysqli_error($conectar);
		}	
	}
	mysqli_close($conectar);
?>
</div>
	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>