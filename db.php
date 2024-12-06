<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "beautystock"; // Asegúrate de que el nombre de la base de datos sea correcto

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>