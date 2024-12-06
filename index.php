<?php
session_start();
include 'menu/menu.php';
include 'db.php';


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Mostrar mensaje de error si existe
if (isset($_SESSION['error_message'])) {
    echo "<p style='color: red; text-align: center;'>" . $_SESSION['error_message'] . "</p>";
    unset($_SESSION['error_message']); // Limpiar el mensaje después de mostrarlo
}

// Procesar el formulario para agregar un producto
if (isset($_POST['agregar_producto'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Preparar la consulta
    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $stock);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>Producto agregado exitosamente.</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error al agregar producto: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Mostrar los productos
$query = "SELECT * FROM productos";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>BeautyStock</title>
    <script>
        function confirmDelete() {
            return confirm("¿Estás seguro de que deseas eliminar este producto?");
        }
    </script>
    <style>
        .action-buttons {
            display: flex; 
            gap: 5px; 
        }
        .btn-sm {
            padding: 5px 10px; /* Ajustar el tamaño del botón */
        }
        /* Estilos para la tabla */
        table {
            width: 80%; /* Ancho de la tabla */
            margin: 0 auto; /* Centrar la tabla */
            border-collapse: collapse; /* Colapsar bordes */
        }
        th, td {
            padding: 5px; /* Reducir el padding de las celdas */
            text-align: center; /* Centrar texto */
        }
        th {
            background-color: #ff6f91; /* Color de fondo para el encabezado */
            color: white; /* Color del texto en el encabezado */
        }
        .btn-danger {
            background-color: #ff6f91; /* Rosa fuerte para eliminar */
            color: white; /* Texto blanco */
        }
        .btn-warning {
            background-color: #ff9a9a; /* Rosa claro para editar */
            color: white; /* Texto blanco */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center" style="color: #5b2c6f;">Agregar Nuevo Producto</h2>
        <form action="index.php" method="POST" class="form-producto">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" class="form-control" step="0.01" min ="0" required>
            </div>
            <div class=" form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" class="form-control" min="0" required>
            </div>
            <button type="submit" name="agregar_producto" class="btn" style="background-color: #ff6f91; color: white;">
                <i class="fas fa-plus"></i> Agregar Producto
            </button>
        </form>

        <h2 class="text-center mt-5" style="color: #5b2c6f;">Productos Disponibles</h2>
        <table class="table table-bordered mt-3">
            <thead class="thead-light">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar si hay productos en la base de datos
                if ($result->num_rows > 0) {
                    // Mostrar los productos
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['precio']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['stock']) . "</td>";
                        echo "<td>
                                <div class='action-buttons'>
                                    <form action='borrar_producto.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='id_producto' value='" . $row['id'] . "'>
                                        <button type='submit' class='btn btn-danger btn-sm' onclick=\"return confirmDelete();\">
                                            <i class='fas fa-trash'></i> Eliminar
                                        </button>
                                    </form>
                                    <a href='editar_producto.php?id_producto=" . $row['id'] . "' class='btn btn-warning btn-sm'>
                                        <i class='fas fa-edit'></i> Editar
                                    </a>
                                </div>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No hay productos disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Enlace para ir a la página de ventas -->
        <p class="text-center">
            <a href="ventas.php" class="btn" style="background-color: #ff6f91; color: white;">Registrar una venta</a>
        </p>
    </div>
</body>
</html>

<?php
$conn->close(); // Cerrar la conexión a la base de datos
?>