<?php
require_once("conexion.php");

// Obtener datos del formulario
$id_alumno = $_POST['id_alumno'] ?? null;
$id_lote   = $_POST['id_lote'] ?? null;

if ($id_alumno === null || $id_lote === null) {
    die("Datos incompletos");
}

// SUMAR módulo al alumno
$stmt = $conexion->prepare("UPDATE alumno SET modulo = modulo + 1 WHERE id_alumno = ?");
$stmt->bind_param("i", $id_alumno);
if (!$stmt->execute()) {
    die("Error al actualizar módulo del alumno: " . $stmt->error);
}
$stmt->close();

// RESTAR stock al lote
$stmt = $conexion->prepare("UPDATE alimentos SET stock = stock - 1 WHERE num_lote = ?");
$stmt->bind_param("i", $id_lote);
if (!$stmt->execute()) {
    die("Error al actualizar stock: " . $stmt->error);
}
$stmt->close();

// INSERTAR registro en fecha_despacho
$fecha_actual = date("Y-m-d");
$sql = "INSERT INTO fecha_despacho (id_alumnoo, id_distribucion, fecha_entrega) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
if (!$stmt) {
    die("Error en prepare: " . $conexion->error);
}
$stmt->bind_param("iis", $id_alumno, $id_lote, $fecha_actual);
if (!$stmt->execute()) {
    die("Error al guardar fecha de despacho: " . $stmt->error);
}
$stmt->close();

// Redirigir al listado
header("Location: despachar.php");
exit;
?>
