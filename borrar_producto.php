<?php
include 'db.php'; // Conexión a la base de datos
session_start();

// Verificar si se ha enviado el ID del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_producto = intval($_POST['id_producto']);

    // Verificar si hay ventas asociadas al producto
    $query_check_ventas = $conn->prepare("SELECT COUNT(*) FROM ventas WHERE producto_id = ?");
    $query_check_ventas->bind_param("i", $id_producto);
    $query_check_ventas->execute();
    $query_check_ventas->bind_result($count);
    $query_check_ventas->fetch();
    $query_check_ventas->close();

    if ($count > 0) {
        // Si hay ventas asociadas, redirigir con un mensaje de error
        $_SESSION['error_message'] = "No se puede eliminar el producto porque hay ventas asociadas.";
        header('Location: index.php');
        exit();
    } else {
        // Si no hay ventas, proceder a eliminar el producto
        $query_delete = $conn->prepare("DELETE FROM productos WHERE id = ?");
        $query_delete->bind_param("i", $id_producto);
        
        if ($query_delete->execute()) {
            // Redirigir a index.php después de eliminar
            header('Location: index.php?success=1');
            exit();
        } else {
            // Manejar el error de eliminación
            $_SESSION['error_message'] = "Error al eliminar el producto: " . $conn->error;
            header('Location: index.php');
            exit();
        }
    }
} else {
    $_SESSION['error_message'] = "Error: ID de producto no proporcionado.";
    header('Location: index.php');
    exit();
}
?>