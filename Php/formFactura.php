<?php
include_once("classCurso.php");
include_once("classFactura.php");

$nombre = $_POST['nombre'];
$curso_principal = $_POST['curso_principal'];
$cursos_seleccionados = $_POST['curso_adicional'] ?? [];

// Crear objeto del curso principal
$cursoPrincipal = new Curso($curso_principal);

// Crear factura
$factura = new Factura($nombre, $cursoPrincipal, $cursos_seleccionados);
$resumenFactura = $factura->getResumenFactura();

// Extraer datos para la vista
$costo_base = $resumenFactura["Costo Base"];
$descuento = $resumenFactura["Descuento Aplicado (%)"];
$iva = $resumenFactura["IVA (19%)"];
$total = $resumenFactura["Total a Pagar"];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Css/style.css">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="p-4 bg-white shadow rounded">
        <h1 class="mb-3">Factura de Inscripción</h1>
        <p><strong>Estudiante:</strong> <?php echo ($nombre); ?></p>
        <p><strong>Curso Principal:</strong> <?php echo ($curso_principal); ?> - $<?php echo number_format($costo_base, 0, ',', '.'); ?></p>

        <p><strong>Cursos Adicionales:</strong></p>
        <?php if (!empty($cursos_seleccionados)): ?>
            <ul>
                <?php foreach ($cursos_seleccionados as $curso) : ?>
                    <li><?php echo htmlspecialchars($curso); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No se seleccionaron cursos adicionales.</p>
        <?php endif; ?>

        <p><strong>Descuento aplicado:</strong> <?php echo $descuento; ?>%</p>
        <p><strong>IVA (19%):</strong> $<?php echo number_format($iva, 0, ',', '.'); ?></p>
        <p><strong>Total a pagar:</strong> $<?php echo number_format($total, 0, ',', '.'); ?></p>

        <div class="mt-4 text-center">
            <a href="/Html/index.html" class="btn btn-primary">Volver</a>
        </div>
    </div>

</body>

</html>