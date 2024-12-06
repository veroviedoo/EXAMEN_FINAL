<?php
include 'db.php'; // Conexión a la base de datos
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['usuario'])) {
    header('Location: login/login.php');
    exit;
}

$cliente = null; // Inicializar la variable cliente
$error_message = ''; // Variable para almacenar mensajes de error

if (isset($_GET['id_cliente'])) {
    $id_cliente = intval($_GET['id_cliente']);
    $query_cliente = $conn->prepare("SELECT cedula, nombre, telefono, ciudad, direccion FROM clientes WHERE id = ?");
    $query_cliente->bind_param("i", $id_cliente);
    $query_cliente->execute();
    $result_cliente = $query_cliente->get_result();
    $cliente = $result_cliente->fetch_assoc(); // Obtener el cliente
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $cedula = htmlspecialchars($_POST['cedula']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $ciudad = htmlspecialchars($_POST['ciudad']);
    $direccion = htmlspecialchars($_POST['direccion']);

    // Validar que el teléfono contenga solo números
    if (!preg_match('/^\d+$/', $telefono)) {
        $error_message = "Error: El número de teléfono solo debe contener dígitos.";
    } else {
        $query_update_cliente = $conn->prepare("UPDATE clientes SET cedula = ?, nombre = ?, telefono = ?, ciudad = ?, direccion = ? WHERE id = ?");
        $query_update_cliente->bind_param("sssssi", $cedula, $nombre, $telefono, $ciudad, $direccion, $id_cliente);
        
        if ($query_update_cliente->execute()) {
            header("Location: clientes.php?success=1");
            exit();
        } else {
            $error_message = "Error al actualizar el cliente: " . htmlspecialchars($conn->error);
        }
    }
}

// Verificar si el cliente fue encontrado
if ($cliente === null) {
    echo "<p style='color: red;'>Error: Cliente no encontrado.</p>";
    exit; // Detener la ejecución si no se encuentra el cliente
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Cliente</title>
    <link rel="stylesheet" href="assets/css/modificar_cliente.css">
</head>
<body>
    <h1>Modificar Cliente</h1>
    <?php if ($error_message): ?>
        <p style='color: red;'><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="modificar_cliente.php?id_cliente=<?php echo $id_cliente; ?>" method="post">
        <input type="hidden" name="action" value="update">
        <label for="cedula">Número de Cédula:</label>
        <input type="text" name="cedula" value="<?php echo htmlspecialchars($cliente['cedula']); ?>" required>
        
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
        
        <label for="telefono">Número de Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo htmlspecialchars($cliente['telefono']); ?>" required pattern="\d+" title="Por favor, ingrese solo números.">
        
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" value="<?php echo htmlspecialchars($cliente['ciudad']); ?>" required>
        
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" value="<?php echo htmlspecialchars($cliente['direccion']); ?>" required>
        
        <button type="submit">Actualizar Cliente</button>
    </form>
</body>
</html>