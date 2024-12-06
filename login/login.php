<?php

session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Verificar credenciales
    if ($usuario === 'admin' && $contrasena === '123456') {
        // Credenciales correctas: iniciar sesión y redirigir
        $_SESSION['usuario'] = 'admin';
        header('Location: ../index.php'); // Redirige a menu/menu.php
        exit;
    } elseif ($usuario !== 'admin') {
        // Usuario incorrecto
        $error = 'Usuario incorrecto';
    } else {
        // Contraseña incorrecta
        $error = 'Contraseña incorrecta';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
            
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
            
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>
