<?php
include("conexion.php");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Traer cargos para el select
$query = "SELECT id, descripcion FROM cargo";
$resultado_cargos = mysqli_query($conexion, $query);
if (!$resultado_cargos) {
    die("Error al consultar cargos: " . mysqli_error($conexion));
}

// Guardar cargos en array para usar en HTML
$cargos = [];
while ($fila = mysqli_fetch_assoc($resultado_cargos)) {
    $cargos[] = $fila;
}

$error_registro = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['Nombre'] ?? '');
    $apellido = trim($_POST['Apellido'] ?? '');
    $correo = trim($_POST['Correo'] ?? '');
    $contraseña = trim($_POST['Contraseña'] ?? '');
    $id = $_POST['id'] ?? '';

    if ($nombre === '' || $apellido === '' || $correo === '' || $contraseña === '' || $id === '') {
        $error_registro = "Por favor completa todos los campos, incluido el cargo.";
    } else if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error_registro = "El correo electrónico no es válido.";
    } else {
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, correo, contraseña, id_cargo) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            $error_registro = "Error en la consulta: " . $conexion->error;
        } else {
            $stmt->bind_param("ssssi", $nombre, $apellido, $correo, $contraseña, $id);
            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                $error_registro = "Error al registrar usuario: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrarse</title>
</head>
<body>
    <h1>Registrarse</h1>
    <p>Por favor completa los siguientes campos para poder crearte un usuario</p>

    <?php if ($error_registro !== ''): ?>
        <p style="color:red;"><?= htmlspecialchars($error_registro) ?></p>
    <?php endif; ?>

    <form action="" method="post" name="registro">
        <input type="text" name="Nombre" placeholder="Nombre" required value="<?= htmlspecialchars($_POST['Nombre'] ?? '') ?>" />
        <input type="text" name="Apellido" placeholder="Apellido" required value="<?= htmlspecialchars($_POST['Apellido'] ?? '') ?>" />
        <input type="email" name="Correo" placeholder="Correo electrónico" required value="<?= htmlspecialchars($_POST['Correo'] ?? '') ?>" />
        <input type="password" name="Contraseña" placeholder="Contraseña" required />

        <label for="id">Selecciona tu cargo:</label>
        <select name="id" id="id" required>
            <option value="">-- Seleccionar cargo --</option>
            <?php foreach ($cargos as $cargo): ?> <!-- recorre el arreglo y me trae cada resultado  -->
                <option value="<?= $cargo['id'] ?>" <?= (isset($_POST['id']) && $_POST['id'] == $cargo['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cargo['descripcion']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>
        <input type="submit" value="Registrarse" />
        <button type="button" onclick="window.location.href=window.location.href">Limpiar</button>

    </form>

    <br>
    <p>¿Ya tienes una cuenta? Inicia sesión aquí</p>
    <a href="sesion.php"><button type="button">Iniciar sesión</button></a>
</body>
</html>
