<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: login_db.php");
    exit();
}

include 'conexion_db.php';
$id_usuario = $_SESSION['id_user'];

if (isset($_GET['eliminar'])) {
    $id_contacto_eliminar = $_GET['eliminar'];
    $del = $conexion->prepare("DELETE FROM contactos WHERE id = ? AND id_usuario = ?");
    $del->execute([$id_contacto_eliminar, $id_usuario]);
    header("Location: dashboard_db.php");
    exit();
}

$id_contacto = $_GET['id'] ?? null;
if (!$id_contacto) {
    header("Location: dashboard_db.php");
    exit();
}

$stmt = $conexion->prepare("SELECT * FROM contactos WHERE id = ? AND id_usuario = ?");
$stmt->execute([$id_contacto, $id_usuario]);
$contacto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contacto) {
    header("Location: dashboard_db.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_nombre = trim($_POST['nombre']);
    $nuevo_telefono = trim($_POST['telefono']);
    $nuevo_correo = trim($_POST['correo']);
    $nueva_ciudad = trim($_POST['ciudad']);

    if (!empty($nuevo_nombre) && !empty($nuevo_telefono)) {
        $update = $conexion->prepare("UPDATE contactos SET nombre = ?, telefono = ?, correo = ?, ciudad = ? WHERE id = ? AND id_usuario = ?");
        $update->execute([$nuevo_nombre, $nuevo_telefono, $nuevo_correo, $nueva_ciudad, $id_contacto, $id_usuario]);
        header("Location: dashboard_db.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Editar Contacto</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .caja-edit { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        input { width: 100%; padding: 10px; margin: 8px 0 15px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { padding: 10px 15px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn-volver { background: #6c757d; text-decoration: none; padding: 10px 15px; color: white; border-radius: 4px; display: inline-block; }
    </style>
</head>
<body>
<div class="caja-edit">
    <h2>Modificar Contacto</h2>
    <form action="editar_db.php?id=<?= $contacto['id'] ?>" method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($contacto['nombre']) ?>" required>
        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($contacto['telefono']) ?>" required>
        <label>Correo:</label>
        <input type="email" name="correo" value="<?= htmlspecialchars($contacto['correo']) ?>">
        <label>Ciudad:</label>
        <input type="text" name="ciudad" value="<?= htmlspecialchars($contacto['ciudad']) ?>">
        <button type="submit">Guardar Cambios</button>
        <a href="dashboard_db.php" class="btn-volver">Cancelar</a>
    </form>
</div>
</body>
</html>