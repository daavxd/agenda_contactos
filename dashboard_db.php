<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: login_db.php");
    exit();
}

include 'conexion_db.php';
$id_usuario_actual = $_SESSION['id_user'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == 'crear') {
    $nom_contacto = trim($_POST['nombre']);
    $tel_contacto = trim($_POST['telefono']);
    $mail_contacto = trim($_POST['correo']);
    $ciud_contacto = trim($_POST['ciudad']);

    if (!empty($nom_contacto) && !empty($tel_contacto)) {
        $insert_c = $conexion->prepare("INSERT INTO contactos (id_usuario, nombre, telefono, correo, ciudad) VALUES (?, ?, ?, ?, ?)");
        $insert_c->execute([$id_usuario_actual, $nom_contacto, $tel_contacto, $mail_contacto, $ciud_contacto]);
        header("Location: dashboard_db.php");
        exit();
    }
}

$consulta_contactos = $conexion->prepare("SELECT * FROM contactos WHERE id_usuario = ?");
$consulta_contactos->execute([$id_usuario_actual]);
$lista_contactos = $consulta_contactos->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Panel de Contactos</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .contenedor { max-width: 900px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; }
        .btn { padding: 6px 12px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; font-size: 13px; }
        .btn-danger { background: #dc3545; }
        .form-contacto { background: #f9f9f9; padding: 15px; border-radius: 6px; margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 10px; align-items: end; }
        .form-contacto input { padding: 8px; border: 1px solid #ccc; border-radius: 4px; width: 100%; box-sizing: border-box; }
        .logout { color: red; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
<div class="contenedor">
    <div class="header">
        <div>
            <h2>Bienvenido, <?= htmlspecialchars($_SESSION['nombre_user']) ?></h2>
            <small>Correo: <?= htmlspecialchars($_SESSION['correo_user']) ?></small>
        </div>
        <div><a href="logout_db.php" class="logout">Cerrar Sesión</a></div>
    </div>

    <h3>Mis Contactos Registrados</h3>

    <form action="dashboard_db.php" method="POST" class="form-contacto">
        <input type="hidden" name="accion" value="crear">
        <div><label><small>Nombre</small></label><input type="text" name="nombre" required></div>
        <div><label><small>Teléfono</small></label><input type="text" name="telefono" required></div>
        <div><label><small>Correo</small></label><input type="email" name="correo"></div>
        <div><label><small>Ciudad</small></label><input type="text" name="ciudad"></div>
        <div><button type="submit" class="btn" style="background: #28a745; height: 35px;">Agregar</button></div>
    </form>

    <table>
        <thead>
            <tr><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Ciudad</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php if (empty($lista_contactos)): ?>
                <tr><td colspan="5" style="text-align: center; color: #777;">No tienes contactos guardados todavía.</td></tr>
            <?php else: ?>
                <?php foreach ($lista_contactos as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['nombre']) ?></td>
                        <td><?= htmlspecialchars($c['telefono']) ?></td>
                        <td><?= htmlspecialchars($c['correo']) ?></td>
                        <td><?= htmlspecialchars($c['ciudad']) ?></td>
                        <td>
                            <a href="editar_db.php?id=<?= $c['id'] ?>" class="btn">Editar</a>
                            <a href="editar_db.php?eliminar=<?= $c['id'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este contacto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>