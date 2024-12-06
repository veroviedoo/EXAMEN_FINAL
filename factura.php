<?php
require('fpdf/fpdf.php');

// Incluir conexión a la base de datos
include 'db.php';

// Verificar si se proporciona el ID de la venta
if (!isset($_GET['id'])) {
    die('Error: No se proporcionó el ID de la venta.');
}

$id_venta = intval($_GET['id']);

// Obtener los datos de la venta y el producto asociado desde la base de datos
$query_venta = $conn->prepare("
    SELECT v.nombre_cliente, v.ci_cliente, v.direccion_cliente, v.cantidad,
           p.nombre AS producto_nombre, p.precio
    FROM ventas v
    JOIN productos p ON v.producto_id = p.id
    WHERE v.id = ?
");
$query_venta->bind_param("i", $id_venta);
$query_venta->execute();
$result_venta = $query_venta->get_result();

if ($result_venta->num_rows === 0) {
    die('Error: No se encontró la venta con el ID proporcionado.');
}

$venta = $result_venta->fetch_assoc();

// Datos de la venta
$nombre_cliente = $venta['nombre_cliente'];
$ci_cliente = $venta['ci_cliente'];
$direccion_cliente = $venta['direccion_cliente'];
$cantidad = $venta['cantidad'];
$nombre_producto = $venta['producto_nombre'];
$precio_producto = $venta['precio'];

// Calcular valores
$subtotal = $cantidad * $precio_producto;
$iva = $subtotal * 0.10;
$total = $subtotal + $iva;

// Clase personalizada para la factura
class PDF extends FPDF
{
    // Encabezado
    function Header()
    {
        $this->SetFillColor(240, 240, 240);
        $this->Rect(0, 0, 210, 40, 'F');
        $this->Image('logo.png', 10, 10, 30);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(80);
        $this->Cell(50, 10, 'FACTURA', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(80);
        $this->Cell(50, 5, 'BeautyStock', 0, 1, 'C');
        $this->Cell(80);
        $this->Cell(50, 5, 'CAAGUAZU (CENTRO) ', 0, 1, 'C');
        $this->Cell(80);
        $this->Cell(50, 5, 'Telefono: 0983 506 777', 0, 1, 'C');
        $this->Cell(80);
        $this->Cell(50, 5, 'Email: beautystock@gmail.com', 0, 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . ' - BeautyStock', 0, 0, 'C');
    }
}

// Crear la factura
$pdf = new PDF();
$pdf->AddPage();

// Información del cliente
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(0, 8, 'DATOS DEL CLIENTE', 1, 1, 'L', true);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(60, 8, 'Nombre: ' . $nombre_cliente, 1, 0, 'L');
$pdf->Cell(60, 8, 'CI / RUC: ' . $ci_cliente, 1, 0, 'L');
$pdf->Cell(70, 8, 'Direccion: ' . $direccion_cliente, 1, 1, 'L');
$pdf->Ln(5);

// Tabla de productos
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(20, 10, 'CANT.', 1, 0, 'C', true);
$pdf->Cell(90, 10, 'DESCRIPCION', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'UNITARIO (G)', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'SUBTOTAL (G)', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 10, $cantidad, 1, 0, 'C');
$pdf->Cell(90, 10, $nombre_producto, 1, 0, 'L');
$pdf->Cell(40, 10, number_format($precio_producto, 0, ',', '.'), 1, 0, 'C');
$pdf->Cell(40, 10, number_format($subtotal, 0, ',', '.'), 1, 1, 'C');

// Subtotal, IVA y Total
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(150, 8, 'SUBTOTAL:', 1, 0, 'R');
$pdf->Cell(40, 8, number_format($subtotal, 0, ',', '.'), 1, 1, 'C');

$pdf->Cell(150, 8, 'IVA (10%):', 1, 0, 'R');
$pdf->Cell(40, 8, number_format($iva, 0, ',', '.'), 1, 1, 'C');

$pdf->Cell(150, 8, 'TOTAL:', 1, 0, 'R');
$pdf->Cell(40, 8, number_format($total, 0, ',', '.'), 1, 1, 'C');

// Nota al final
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, '* Factura Sin Valor Fiscal', 0, 1, 'C');

// Generar PDF
$pdf->Output();
?>
