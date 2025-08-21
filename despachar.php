<?php
session_start();
require_once("conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    echo "<h3>No has iniciado sesión.</h3>";
    echo "<a href='index.php'><button>Volver al inicio</button></a>";
    exit;
}

// --- FILTROS ---
$dni       = $_GET['dni']       ?? '';
$curso     = $_GET['curso']     ?? '';
$division  = $_GET['division']  ?? '';

$sql = "SELECT * FROM alumno WHERE 1=1";

if ($dni != '') {
    $sql .= " AND dni LIKE '%" . mysqli_real_escape_string($conexion, $dni) . "%'";
}
if ($curso != '') {
    $sql .= " AND curso LIKE '%" . mysqli_real_escape_string($conexion, $curso) . "%'";
}
if ($division != '') {
    $sql .= " AND division LIKE '%" . mysqli_real_escape_string($conexion, $division) . "%'";
}

$alumnos = $conexion->query($sql);
if (!$alumnos) {
    die("Error al consultar alumnos: " . mysqli_error($conexion));
}

// Traer lotes
$lotes = $conexion->query("SELECT num_lote, nombre_lote, stock FROM alimentos");
$lotes_data = [];
while ($row = $lotes->fetch_assoc()) {
    $lotes_data[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona despacho</title>
    <link rel="stylesheet" href="css/despachar.css">
</head>
<body>
    <h1>Zona despacho</h1>
    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?> 👋</h2>
    <br>
    <a href="cerrar_sesion.php"><button>Cerrar sesión</button></a>
    <a href="perfil.php"><button>Editar perfil</button></a>

    <h3>Filtrar alumnos</h3>
    <form method="get" action="">
        <input type="text" name="dni" placeholder="DNI" value="<?= htmlspecialchars($dni) ?>">
        <input type="text" name="curso" placeholder="Curso" value="<?= htmlspecialchars($curso) ?>">
        <input type="text" name="division" placeholder="División" value="<?= htmlspecialchars($division) ?>">
        <button type="submit">Filtrar</button>
        <a href="despachar.php"><button type="button">Limpiar filtros</button></a>
    </form>
    
    <h3>Listado de alumnos</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>DNI</th>
            <th>Curso</th>
            <th>División</th>
            <th>Módulos</th>
            <th>Despachar</th>
        </tr>
        <?php while($alumno = $alumnos->fetch_assoc()): ?>
        <tr>
            <td><?= $alumno['nombre'] ?></td>
            <td><?= $alumno['apellido'] ?></td>
            <td><?= $alumno['dni'] ?></td>
            <td><?= $alumno['curso'] ?></td>
            <td><?= $alumno['division'] ?></td>
            <td><?= $alumno['modulo'] ?></td>
            <td>
                <form action="procesar_despacho.php" method="POST">
                    <input type="hidden" name="id_alumno" value="<?= $alumno['id_alumno'] ?>">
                    <input type="hidden" name="dni" value="<?= htmlspecialchars($dni) ?>">
                    <input type="hidden" name="curso" value="<?= htmlspecialchars($curso) ?>">
                    <input type="hidden" name="division" value="<?= htmlspecialchars($division) ?>">

                    <select name="id_lote">
                        <?php foreach ($lotes_data as $l): ?>
                            <option value="<?= $l['num_lote'] ?>" <?= $l['stock'] <= 0 ? 'disabled' : '' ?>>
                                <?= $l['nombre_lote'] ?> (Stock: <?= $l['stock'] ?><?= $l['stock'] <= 0 ? ' - SIN STOCK' : '' ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Checkbox que despacha automáticamente -->
                    <input type="checkbox" name="despachar" value="1" onchange="this.form.submit()">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
