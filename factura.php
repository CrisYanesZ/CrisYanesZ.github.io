<?php
include "pdf/fpdf/fpdf.php";
include "conexion.php";

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont("Arial","",30);

$pdf->SetY(10);
$pdf->SetX(5);
//$pdf->Cell(10,10,"Bella Cosmetics");
$idp= $_GET['NumPedido'];
$id=1;
//$idp=1;
$idcliente="0301200100990";
$dato='Bella Cosmetics';
$datost="2772-1020";$datosd="Comayagua";$datosc="bellacosmetics@gmail.com";

$pdf->Image("logo.png",150,10, 20, 20,'PNG',"http://evilnapsis.com/");
$pdf->Cell(195, 5, utf8_decode($dato), 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Teléfono: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, $datost, 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Dirección: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, $datosd, 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, "Correo: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, $datosc, 0, 1, 'L');
$pdf->Ln();

$clientes = mysqli_query($conexion, "SELECT  NombreCompleto,Apellido, Telefono, Direccion FROM cliente WHERE NIT = $idcliente");
$datosC = mysqli_fetch_assoc($clientes);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(0, 0, 0);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(196, 5, "Datos del cliente", 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(90, 5, utf8_decode('Nombre'), 0, 0, 'L');
$pdf->Cell(50, 5, utf8_decode('Teléfono'), 0, 0, 'L');
$pdf->Cell(56, 5, utf8_decode('Dirección'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(90, 5, utf8_decode($datosC['NombreCompleto']." ".$datosC['Apellido']), 0, 0, 'L');
$pdf->Cell(50, 5, utf8_decode($datosC['Telefono']), 0, 0, 'L');
$pdf->Cell(56, 5, utf8_decode($datosC['Direccion']), 0, 1, 'L');
$pdf->Ln(3);

$detalle=mysqli_query($conexion, "SELECT  detalle.CodigoProd,NombreProd,Marca,CantidadProductos,PrecioProd
from producto,detalle,venta where detalle.NumPedido=venta.NumPedido and detalle.CodigoProd=producto.CodigoProd and venta.NumPedido ='$idp'");
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(196, 5, "Detalle de Producto", 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(14, 5, utf8_decode('N°'), 0, 0, 'L');
$pdf->Cell(90, 5, utf8_decode('Descripción'), 0, 0, 'L');
$pdf->Cell(25, 5, 'Cantidad', 0, 0, 'L');
$pdf->Cell(32, 5, 'Precio', 0, 0, 'L');
$pdf->Cell(35, 5, 'Sub Total.', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$contador = 1;
while ($row = mysqli_fetch_assoc($detalle)) {
    $pdf->Cell(14, 5, $contador, 0, 0, 'L');
    $pdf->Cell(90, 5, $row['NombreProd'], 0, 0, 'L');
    $pdf->Cell(25, 5, $row['CantidadProductos'], 0, 0, 'L');
    $pdf->Cell(32, 5, $row['PrecioProd'], 0, 0, 'L');
    $pdf->Cell(35, 5, number_format($row['CantidadProductos'] * $row['PrecioProd'], 2, '.', ','), 0, 1, 'L');
    $contador++;
}

$ventas = mysqli_query($conexion, "SELECT * FROM venta WHERE NumPedido='$idp'");
$datosV=mysqli_fetch_assoc($ventas);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(196, 5, "TOTAL A PAGAR", 1, 1, 'C', 1);
$pdf->Cell(196, 5, "             ", 1, 1, 'C', 1);
$pdf->Cell(196, 5, utf8_decode($datosV['TotalPagar']), 1, 1, 'C', 1);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Fecha: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5,$datosV['Fecha'], 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Estado: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, $datosV['Estado'], 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, "Envio: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, $datosV['TipoEnvio'], 0, 1, 'L');
$pdf->Ln();

$pdf->output();


?>