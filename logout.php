/* Destruye la session del usuario en uso*/

<?php
session_start();
session_unset($_SESSION['correo']);
session_destroy();

header('location: sesion.html');
?>