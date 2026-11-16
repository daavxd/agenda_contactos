<?php
session_start();
if (isset($_SESSION['id_user'])) {
    header("Location: dashboard_db.php");
    exit();
}

include 'conexion_db.php';
$mensaje_alerta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_ingresado = trim($_POST['email']);
    $clave_ingresada = $_POST['password'];

    if (empty($correo_ingresado) || empty($clave_ingresada)) {
        $mensaje_alerta = "Por favor, completa todos los campos.";
    } else {
        $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $consulta->execute([$correo_ingresado]);
        $usuario_encontrado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($usuario_encontrado && password_verify($clave_ingresada, $usuario_encontrado['password'])) {
            $_SESSION['id_user'] = $usuario_encontrado['id'];
            $_SESSION['nombre_user'] = $usuario_encontrado['nombre'];
            $_SESSION['correo_user'] = $usuario_encontrado['correo'];
            
            header("Location: dashboard_db.php");
            exit();
        } else {
            $mensaje_alerta = "Credenciales incorrectas. Inténtalo de nuevo.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - UTPL</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Aquí añadimos tu imagen de fondo de la UTPL */
            background: linear-gradient(rgba(0, 51, 102, 0.6), rgba(0, 51, 102, 0.6)), url('fondo_utpl.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .caja-login {
            background: rgba(255, 255, 255, 0.95);
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
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
        .error {
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

<div class="caja-login">
    <h2>UTPL - Agenda</h2>
    <?php if (!empty($mensaje_alerta)): ?>
        <div class="error"><?= $mensaje_alerta ?></div>
    <?php endif; ?>
    
    <form action="login_db.php" method="POST">
        <label>Correo Electrónico:</label>
        <input type="email" name="email" required>
        
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Iniciar Sesión</button>
    </form>
    
    <div class="link">
        ¿No tienes cuenta? <a href="registro_db.php">Regístrate aquí</a>
    </div>
</div>

</body>
</html>