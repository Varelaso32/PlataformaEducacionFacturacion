<?php
session_start();
include_once("classCurso.php");

$_SESSION['nombre'] = $_POST['nombre'];
$_SESSION['curso_principal'] = $_POST['curso_principal'];
$_SESSION['num_cursos'] = $_POST['num_cursos'];

$cursoPrincipal = new Curso($_SESSION['curso_principal']);

$cursosDisponibles = $cursoPrincipal->getCursosAdicionalesDisponibles();

$_SESSION['curso'] = serialize($cursoPrincipal);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Cursos Adicionales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Css/style.css">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="p-4 bg-white shadow rounded">
        <h1 class="mb-3">Selección de Cursos Adicionales</h1>
        <p class="text-muted">Seleccione los cursos adicionales que desea tomar.</p>

        <form action="/Php/formFactura.php" method="POST">
            <p><strong>Estudiante:</strong> <?php echo $_SESSION['nombre']; ?></p>
            <p><strong>Curso Principal:</strong> <?php echo $_SESSION['curso_principal']; ?></p>
            <p><strong>Número de Cursos Adicionales:</strong> <?php echo $_SESSION['num_cursos']; ?></p>

            <?php
            for ($i = 1; $i <= $_SESSION['num_cursos']; $i++) {
                echo "<div class='mb-3'>
                        <label class='form-label'>Curso Adicional $i:</label>
                        <select class='form-select' name='curso_adicional[]' required>
                            <option value='' disabled selected>Seleccione un curso</option>";

                foreach ($cursosDisponibles as $nombre => $costo) {
                    echo "<option value='$nombre'>$nombre - $$costo</option>";
                }

                echo "</select>
                      </div>";
            }
            ?>
            <button type="submit" class="btn btn-dark w-100">Generar Factura</button>
        </form>
    </div>

</body>

</html>