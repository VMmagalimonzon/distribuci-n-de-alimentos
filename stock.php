<?php
require_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_entrada = $_POST['fecha_entrada'] ?? null;
    $stock_esp     = $_POST['stock_esp'] ?? null;
    $nombre_lote   = $_POST['nombre_lote'] ?? null;
    $num_lote      = $_POST['num_lote'] ?? null;
    $stock         = $_POST['stock'] ?? null;

    if ($fecha_entrada && $stock_esp && $nombre_lote && $num_lote && $stock) {
        // Convertimos la fecha a formato YYYYMMDD como entero (opcional)
        $fecha_int = (int) str_replace("-", "", $fecha_entrada);
        $stock_num = (int) $stock;

        $sql = "INSERT INTO alimentos (stock, fecha_entrada, stock_esp, nombre_lote, num_lote) 
                VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("isssi", $stock_num, $fecha_int, $stock_esp, $nombre_lote, $num_lote);

            if ($stmt->execute()) {
                $mensaje = "<p style='color: green;'>✅ Stock agregado correctamente.</p>";
            } else {
                $mensaje = "<p style='color: red;'>❌ Error al insertar: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            $mensaje = "<p style='color: red;'>❌ Error en la preparación de la consulta: " . $conexion->error . "</p>";
        }
    } else {
        $mensaje = "<p style='color: orange;'>⚠️ Completá todos los campos.</p>";
    }

    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Agregar Stock</title>
    <link rel="stylesheet" href="css/stock.css">
</head>
<body>
    <h2>Formulario para ingresar stock</h2>

    <!-- Mensaje de resultado -->
    <?php if (!empty($mensaje)) echo $mensaje; ?>

    <form method="POST" action="">
        <label>Fecha de entrada:</label><br>
        <input type="date" name="fecha_entrada" required><br><br>

        <label>Cantidad de stock:</label><br>
        <input type="number" name="stock" min="0" required><br><br>

        <label>Stock especial:</label><br>
        <input type="text" name="stock_esp" required><br><br>

        <label>Nombre de lote:</label><br>
        <input type="text" name="nombre_lote" required><br><br>

        <label>Número de lote:</label><br>
        <input type="text" name="num_lote" required><br><br>

        <input type="submit" value="Agregar stock">
    </form>

<div class="form-actions">
  <input type="submit" value="Guardar">
  <input type="reset" value="Limpiar">
  <a href="index.php"><button type="button">Inicio</button></a>
</div>

</body>
</html>
