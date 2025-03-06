<?php
session_start();
include_once("classCurso.php");
include_once("classFactura.php");

// Recuperar datos de sesión
$nombre = $_SESSION['nombre'];
$cursoPrincipal = unserialize($_SESSION['curso']);
$numCursosAdicionales = $_SESSION['num_cursos'];
$cursosSeleccionados = $_POST['curso_adicional'];

// Calcular costos de los cursos adicionales
$cursosAdicionales = [];
foreach ($cursosSeleccionados as $curso) {
    $costo = $cursoPrincipal->getCursosAdicionalesDisponibles()[$curso];
    $cursosAdicionales[] = ["nombre" => $curso, "costo" => $costo];
}

// Crear la factura
$factura = new Factura($nombre, $cursoPrincipal, $cursosAdicionales);
$resumenFactura = $factura->getResumenFactura();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="p-4 bg-white shadow rounded">
        <h1 class="mb-3">Factura de Cursos</h1>
        <p><strong>Estudiante:</strong> <?php echo $resumenFactura['Estudiante']; ?></p>
        <p><strong>Curso Principal:</strong> <?php echo $resumenFactura['Curso Principal']->getNombre(); ?></p>
        <p><strong>Costo Base:</strong> $<?php echo number_format($resumenFactura['Costo Base'], 2); ?></p>
        <h4 class="mt-3">Cursos Adicionales</h4>
        <ul>
            <?php foreach ($resumenFactura['Cursos Adicionales'] as $curso) { ?>
                <li><?php echo $curso['nombre'] . " - $" . number_format($curso['costo'], 2); ?></li>
            <?php } ?>
        </ul>
        <p><strong>Descuento Aplicado:</strong> <?php echo $resumenFactura['Descuento Aplicado (%)']; ?>%</p>
        <p><strong>IVA (19%):</strong> $<?php echo number_format($resumenFactura['IVA (19%)'], 2); ?></p>
        <h3><strong>Total a Pagar:</strong> $<?php echo number_format($resumenFactura['Total a Pagar'], 2); ?></h3>
        <a href="/Html/index.html" class="btn btn-dark w-100 mt-3">Volver</a>
    </div>
</body>
</html>
