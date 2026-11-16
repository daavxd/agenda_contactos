<?php
include 'conexion_db.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password_plano = $_POST['password'];

    if (empty($nombre) || empty($correo) || empty($password_plano)) {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        $verificar = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $verificar->execute([$correo]);
        
        if ($verificar->rowCount() > 0) {
            $mensaje = "Este correo electrónico ya está registrado.";
        } else {
            $password_seguro = password_hash($password_plano, PASSWORD_DEFAULT);
            $insertar = $conexion->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
            if ($insertar->execute([$nombre, $correo, $password_seguro])) {
                header("Location: login_db.php?exito=1");
                exit();
            } else {
                $mensaje = "Hubo un error al registrar el usuario.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - UTPL</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Fondo azul institucional UTPL (sin imagen, color sólido elegante) */
            background: linear-gradient(135deg, #002244 0%, #003366 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .caja-reg {
            background: rgba(255, 255, 255, 0.98);
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 380px;
            border-top: 5px solid #003366; /* Azul institucional UTPL */
        }
        h2 {
            color: #003366;
            text-align: center;
            margin-top: 0;
        }
        label {
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0 18px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 11px;
            background: #003366; /* Azul UTPL */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s;
        }
        button:hover {
            background: #002244;
        }
        .msg {
            color: #721c24;
            background: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            border: 1px solid #f5c6cb;
        }
        .link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        .link a {
            color: #003366;
            text-decoration: none;
            font-weight: bold;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="caja-reg">
    <h2>UTPL - Registro</h2>
    <?php if (!empty($mensaje)): ?>
        <div class="msg"><?= $mensaje ?></div>
    <?php endif; ?>

    <form action="registro_db.php" method="POST">
        <label>Nombre Completo:</label>
        <input type="text" name="nombre" required>

        <label>Correo Electrónico:</label>
        <input type="email" name="correo" required>

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit">Registrarse</button>
    </form>

    <div class="link">
        ¿Ya tienes una cuenta? <a href="login_db.php">Inicia sesión</a>
    </div>
</div>

</body>
</html>