<?php
include 'db.php'; // Conexión a la base de datos
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$producto = null; // Inicializar la variable producto
$error_message = ''; // Variable para almacenar mensajes de error

// Verificar si se ha pasado el ID del producto
if (isset($_GET['id_producto'])) {
    $id_producto = intval($_GET['id_producto']);
    $query_producto = $conn->prepare("SELECT nombre, descripcion, precio, stock FROM productos WHERE id = ?");
    $query_producto->bind_param("i", $id_producto);
    $query_producto->execute();
    $result_producto = $query_producto->get_result();
    $producto = $result_producto->fetch_assoc(); // Obtener el producto
}

// Manejo de la solicitud POST para actualizar el producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $nombre = htmlspecialchars($_POST['nombre']);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);

    // Validar que el precio y el stock no sean negativos
    if ($precio < 0 || $stock < 0) {
        $error_message = "Error: El precio y el stock no pueden ser negativos.";
    } else {
        $query_update_producto = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ? WHERE id = ?");
        $query_update_producto->bind_param("ssiii", $nombre, $descripcion, $precio, $stock, $id_producto);
        
        if ($query_update_producto->execute()) {
            header("Location: index.php?success=1"); // Redirigir a index.php después de actualizar
            exit();
        } else {
            $error_message = "Error al actualizar el producto: " . htmlspecialchars($conn->error);
        }
    }
}

// Verificar si el producto fue encontrado
if ($producto === null) {
    echo "<p style='color: red;'>Error: Producto no encontrado.</p>";
    exit; // Detener la ejecución si no se encuentra el producto
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="assets/css/editar_producto.css">
</head>
<body>
    <h1>Modificar Producto</h1>
    <?php if ($error_message): ?>
        <p style='color: red;'><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="editar_producto.php?id_producto=<?php echo $id_producto; ?>" method="post">
        <input type="hidden" name="action" value="update">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
        
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" rows="3" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
        
        <label for="precio">Precio:</label>
        <input type="number" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" step="0.01" min="0" required>
        
        <label for="stock">Stock:</label>
        <input type="number" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" min="0" required>
        
        <button type="submit">Actualizar Producto</button>
    </form>
</body>
</html>