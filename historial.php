<?php  
include 'menu/menu.php';
include 'db.php'; // Conexión a la base de datos
session_start(); // Asegúrate de iniciar la sesión
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener las ventas
$query_ventas = $conn->prepare("
    SELECT v.id, v.fecha, v.cantidad, v.subtotal, p.precio AS precio_unitario, p.nombre AS nombre_producto, c.nombre AS nombre_cliente, c.cedula AS ci_cliente 
    FROM ventas v 
    JOIN clientes c ON v.ci_cliente COLLATE utf8mb4_0900_ai_ci = c.cedula COLLATE utf8mb4_0900_ai_ci
    JOIN productos p ON v.producto_id = p.id
    ORDER BY v.fecha DESC
");
$query_ventas->execute();
$result_ventas = $query_ventas->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Ventas</title>
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/historial.css">
</head>
<body>
    <h1>Historial de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Cédula</th>
                <th>Producto</th> <!-- Nueva columna para el nombre del producto -->
                <th>Cantidad</th>
                <th>Precio Unitario (Gs)</th>
                <th>Subtotal (Gs)</th>
                <th>Acciones</th> <!-- Nueva columna para acciones -->
            </tr>
        </thead>
        <tbody>
            <?php while ($venta = $result_ventas->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $venta['id']; ?></td>
                    <td><?php echo $venta['fecha']; ?></td>
                    <td><?php echo $venta['nombre_cliente']; ?></td>
                    <td><?php echo $venta['ci_cliente']; ?></td>
                    <td><?php echo $venta['nombre_producto']; ?></td> <!-- Mostrar el nombre del producto -->
                    <td><?php echo $venta['cantidad']; ?></td>
                    <td><?php echo number_format($venta['precio_unitario'], 0, ',', '.'); ?></td>
                    <td><?php echo number_format($venta['subtotal'], 0, ',', '.'); ?></td>
                    <td>
                        <form action="borrar_venta.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_venta" value="<?php echo $venta['id']; ?>">
                        </form>
                        <a href="factura.php?id=<?php echo $venta['id']; ?>" target="_blank">Imprimir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>