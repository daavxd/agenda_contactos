<?php
$servidor = "localhost";
$usuario_db = "root";
$password_db = "";
$base_datos = "agenda_contactos"; // <-- Asegúrate de que tenga este nombre exacto

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$base_datos;charset=utf8", $usuario_db, $password_db);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error_conexion) {
    die("Fallo en la conexión a la base de datos: " . $error_conexion->getMessage());
}
?>