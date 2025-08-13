<?php
require_once("conexion.php");

$id_alumno = $_POST['id_alumno'] ?? null;
$id_lote   = $_POST['id_lote'] ?? null;

if(!$id_alumno || !$id_lote){
    die("Datos incompletos");
}

// Sumar módulo al alumno
$conexion->query("UPDATE alumno SET modulo = modulo + 1 WHERE id_alumno = $id_alumno");

// Restar stock al lote
$conexion->query("UPDATE alimentos SET stock = stock - 1 WHERE num_lote = $id_lote");

// Guardar registro en fecha_despacho
$fecha_actual = date("Y-m-d");

$sql = "INSERT INTO fecha_despacho (id_alumno, id_distribucion, fecha_entrega) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);

if(!$stmt){
    die("Error en prepare: " . $conexion->error);
}

$stmt->bind_param("iis", $id_alumno, $id_lote, $fecha_actual);

if(!$stmt->execute()){
    die("Error en execute: " . $stmt->error);
}

// Volver a la página de despacho
header("Location: despachar.php");
exit;
