<?php
include 'db.php'; // Conexión a la base de datos
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_venta'])) {
    $id_venta = intval($_POST['id_venta']);

    // Eliminar la venta
    $query_delete = $conn->prepare("DELETE FROM ventas WHERE id = ?");
    $query_delete->bind_param("i", $id_venta);
    
    if ($query_delete->execute()) {
        // Redirigir a historial.php después de eliminar
        header('Location: historial.php?success=1');
        exit();
    } else {
        echo "Error al eliminar la venta: " . $conn->error;
    }
} else {
    echo "Error: ID de venta no proporcionado.";
}
?>