<?php
include("conexion.php");

// Obtener valores de los filtros (si vienen por GET)
$dni       = $_GET['dni']       ?? '';
$curso     = $_GET['curso']     ?? '';
$division  = $_GET['division']  ?? '';
$celiaco   = $_GET['celiaco']   ?? '';
$diabetico = $_GET['diabetico'] ?? '';

// Armar consulta base
$sql = "SELECT * FROM alumno WHERE 1=1";

// Agregar condiciones según los filtros
if ($dni != '') {
    $sql .= " AND dni = '" . mysqli_real_escape_string($conexion, $dni) . "'";
}
if ($curso != '') {
    $sql .= " AND curso = '" . mysqli_real_escape_string($conexion, $curso) . "'";
}
if ($division != '') {
    $sql .= " AND division = '" . mysqli_real_escape_string($conexion, $division) . "'";
}
if ($celiaco != '') {
    $sql .= " AND celiaco = " . intval($celiaco);
}
if ($diabetico != '') {
    $sql .= " AND diabetico = " . intval($diabetico);
}

$resultado = mysqli_query($conexion, $sql);
if (!$resultado) {
    die("Error al consultar alumnos: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumnos Registrados</title>
</head>
<body>
    <h1>Alumnos Registrados</h1>

    <h3>Filtrar alumnos</h3>
    <form method="get" action="">
        <input type="text" name="dni" placeholder="DNI" value="<?= htmlspecialchars($dni) ?>">
        <input type="text" name="curso" placeholder="Curso" value="<?= htmlspecialchars($curso) ?>">
        <input type="text" name="division" placeholder="División" value="<?= htmlspecialchars($division) ?>">

        <label for="celiaco">Celíaco:</label>
        <select name="celiaco" id="celiaco">
            <option value="">-- Todos --</option>
            <option value="1" <?= ($celiaco === '1') ? 'selected' : '' ?>>Sí</option>
            <option value="0" <?= ($celiaco === '0') ? 'selected' : '' ?>>No</option>
        </select>

        <label for="diabetico">Diabético:</label>
        <select name="diabetico" id="diabetico">
            <option value="">-- Todos --</option>
            <option value="1" <?= ($diabetico === '1') ? 'selected' : '' ?>>Sí</option>
            <option value="0" <?= ($diabetico === '0') ? 'selected' : '' ?>>No</option>
        </select>

        <button type="submit">Filtrar</button>
        <a href="alumnos.php"><button type="button">Limpiar filtros</button></a>
    </form>

    <br>
    <a href="añadir.php">
        <button>Añadir alumnos</button>
    </a>
    <br>
    <a href="inicio.php">
        <button>Volver</button>
    </a>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Curso</th>
                <th>División</th>
                <th>Celíaco</th>
                <th>Diabético</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while ($alumno = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= $alumno['id_alumno'] ?></td>
                        <td><?= htmlspecialchars($alumno['nombre']) ?></td>
                        <td><?= htmlspecialchars($alumno['apellido']) ?></td>
                        <td><?= htmlspecialchars($alumno['dni']) ?></td>
                        <td><?= htmlspecialchars($alumno['curso']) ?></td>
                        <td><?= htmlspecialchars($alumno['division']) ?></td>
                        <td><?= $alumno['celiaco'] ? 'Sí' : 'No' ?></td>
                        <td><?= $alumno['diabetico'] ? 'Sí' : 'No' ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No se encontraron alumnos.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
