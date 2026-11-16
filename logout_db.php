<?php
session_start();

// Limpiamos todas las variables de sesión
$_SESSION = array();

// Destruimos la sesión por completo
session_destroy();

// Redirigimos al usuario de regreso a la pantalla de inicio de sesión
header("Location: login_db.php");
exit();
?>