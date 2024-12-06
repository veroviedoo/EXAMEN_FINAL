<?php
include 'db.php'; // Conexión a la base de datos
include 'menu/menu.php'; // Incluir el menú
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error_message = ''; // Variable para almacenar mensajes de error

// Manejo de la solicitud POST para registrar un cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $cedula = htmlspecialchars($_POST['cedula']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $ciudad = htmlspecialchars($_POST['ciudad']);
    $direccion = htmlspecialchars($_POST['direccion']);

    // Verificar si la cédula ya existe
    $query_check = $conn->prepare("SELECT id FROM clientes WHERE cedula = ?");
    $query_check->bind_param("s", $cedula);
    $query_check->execute();
    $result_check = $query_check->get_result();

    if ($result_check->num_rows > 0) {
        $error_message = "Error: La cédula ya está registrada.";
    } else {
        // Insertar el nuevo cliente
        $query_insert = $conn->prepare("INSERT INTO clientes (cedula, nombre, telefono, ciudad, direccion) VALUES (?, ?, ?, ?, ?)");
        $query_insert->bind_param("sssss", $cedula, $nombre, $telefono, $ciudad, $direccion);
        
        if ($query_insert->execute()) {
            header("Location: clientes.php?success=1");
            exit();
        } else {
            $error_message = "Error al registrar el cliente: " . $conn->error;
        }
    }
}

// Manejo de la solicitud GET para eliminar un cliente
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id_cliente = intval($_GET['id']);
    
    // Eliminar el cliente de la base de datos
    $query_delete = $conn->prepare("DELETE FROM clientes WHERE id = ?");
    $query_delete->bind_param("i", $id_cliente);
    
    if ($query_delete->execute()) {
        header("Location: clientes.php?success=1");
        exit();
    } else {
        $error_message = "Error al eliminar el cliente: " . $conn->error;
    }
}

// Obtener la lista de clientes registrados
$query_clientes = $conn->prepare("SELECT id, cedula, nombre, telefono, ciudad, direccion FROM clientes");
$query_clientes->execute();
$result_clientes = $query_clientes->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cliente</title>
    <link rel="stylesheet" href="assets/css/menu.css"> 
    <link rel="stylesheet" href="assets/css/clientes.css"> 
</head>
<body>
    <h1>Registrar Cliente</h1>
    <?php if ($error_message): ?>
        <p style='color: red;'><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="clientes.php" method="post">
        <input type="hidden" name="action" value="register">
        <label for="cedula">Número de Cédula:</label>
        <input type="text" name="cedula" required>
        
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        
        <label for="telefono">Número de Teléfono:</label>
        <input type="text" name="telefono" required pattern="\d+" title="Por favor, ingrese solo números.">
        
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad" required>
        
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required>
        
        <button type="submit">Registrar Cliente</button>
    </form>

    <h2>Clientes Registrados</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Ciudad </th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cliente = $result_clientes->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <td><?php echo $cliente['cedula']; ?></td>
                    <td><?php echo $cliente['nombre']; ?></td>
                    <td><?php echo $cliente['telefono']; ?></td>
                    <td><?php echo $cliente['ciudad']; ?></td>
                    <td><?php echo $cliente['direccion']; ?></td>
                    <td>
                    <a href="modificar_cliente.php?id_cliente=<?php echo $cliente['id']; ?>">Modificar</a>
                    <a href="clientes.php?action=delete&id=<?php echo $cliente['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>