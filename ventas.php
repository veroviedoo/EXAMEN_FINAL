<?php  
include('menu/menu.php'); // Incluir el menú
include 'db.php'; // Conexión a la base de datos
session_start(); // Asegúrate de iniciar la sesión
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener la lista de productos para el select
$query_productos = $conn->prepare("SELECT id, nombre FROM productos");
$query_productos->execute();
$result_productos = $query_productos->get_result();

// Obtener la lista de clientes para el select
$query_clientes = $conn->prepare("SELECT id, nombre FROM clientes");
$query_clientes->execute();
$result_clientes = $query_clientes->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cliente_id'], $_POST['producto_id'], $_POST['cantidad']) 
        && !empty($_POST['cliente_id']) 
        && !empty($_POST['producto_id']) 
        && !empty($_POST['cantidad'])) {
        
        $cliente_id = intval($_POST['cliente_id']);
        $producto_id = intval($_POST['producto_id']);
        $cantidad = intval($_POST['cantidad']);

        // Obtener información del cliente
        $query_cliente = $conn->prepare("SELECT nombre AS nombre_cliente, cedula AS ci_cliente, telefono AS telefono_cliente, direccion FROM clientes WHERE id = ?");
        $query_cliente->bind_param("i", $cliente_id);
        $query_cliente->execute();
        $result_cliente = $query_cliente->get_result();
        $cliente = $result_cliente->fetch_assoc();

        // Obtener precio del producto
        $query_precio = $conn->prepare("SELECT precio, stock FROM productos WHERE id = ?");
        $query_precio->bind_param("i", $producto_id);
        $query_precio->execute();
        $result_precio = $query_precio->get_result();

        if ($result_precio->num_rows > 0) {
            $producto = $result_precio->fetch_assoc();
            $precio_unitario = $producto['precio'];
            $stock = $producto['stock'];

            if ($stock >= $cantidad) {
                $subtotal = $cantidad * $precio_unitario;

                // Actualizar el stock del producto
                $nuevo_stock = $stock - $cantidad;
                $query_update_stock = $conn->prepare("UPDATE productos SET stock = ? WHERE id = ?");
                $query_update_stock->bind_param("ii", $nuevo_stock, $producto_id);
                $query_update_stock->execute();

                // Registrar la venta
                $query_insert_venta = $conn->prepare("INSERT INTO ventas 
                    (producto_id, cantidad, nombre_cliente, ci_cliente, telefono_cliente, direccion_cliente, subtotal, fecha) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
                $query_insert_venta->bind_param(
                    "iissssd", 
                    $producto_id, 
                    $cantidad, 
                    $cliente['nombre_cliente'], 
                    $cliente['ci_cliente'], 
                    $cliente['telefono_cliente'], 
                    $cliente['direccion'], 
                    $subtotal
                );
                $query_insert_venta->execute();

                // Guardar el ID de la venta para usarlo en factura.php
                $venta_id = $conn->insert_id; // Obtener el ID de la venta recién insertada

               
                if (isset($_POST['imprimir'])) {
                    header("Location: factura.php?id=" . $venta_id); // Redirigir a factura.php con el ID
                } else {
                    header("Location: historial.php");
                }
                exit;
            } else {
                echo "Error: No hay suficiente stock.";
            }
        } else {
            echo "Error: Producto no encontrado.";
        }
    } else {
        echo "Error: Faltan datos obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Venta</title>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/ventas.css"> 
</head>
<body>
    <h1>Registrar Venta</h1>
    <form method="POST" action="">
        
        <label for="cliente_id">Cliente:</label>
        <select name="cliente_id" id="cliente_id" required>
            <option value="">Seleccione un cliente</option>
            <?php while ($cliente = $result_clientes->fetch_assoc()): ?>
                <option value="<?php echo $cliente['id']; ?>"><?php echo $cliente['nombre']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="producto_id">Producto:</label>
        <select name="producto_id" id="producto_id" required>
            <option value="">Seleccione un producto</option>
            <?php while ($producto = $result_productos->fetch_assoc()): ?>
                <option value="<?php echo $producto['id']; ?>"><?php echo $producto['nombre']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" min="1" required>

        
        <button type="submit">Registrar</button>
    </form>
</body>
</html>