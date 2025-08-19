<?php
require_once("conexion.php");

$id_alumno = $_POST['id_alumno'] ?? null;
$id_lote   = $_POST['id_lote'] ?? null;

if(!$id_alumno || !$id_lote){
    die("Datos incompletos");
}

// Verificar stock disponible
$check = $conexion->query("SELECT stock FROM alimentos WHERE num_lote = $id_lote");
$lote = $check->fetch_assoc();

if ($lote['stock'] <= 0) {
    die("No hay stock disponible para este lote.");
}

// 1. Sumar módulo al alumno
$conexion->query("UPDATE alumno SET modulo = modulo + 1 WHERE id_alumno = $id_alumno");

// 2. Restar stock al lote
$conexion->query("UPDATE alimentos SET stock = stock - 1 WHERE num_lote = $id_lote");

// 3. Insertar en tabla fecha_despacho usando `id_alumnoo`
$fecha = date("Y-m-d");
$conexion->query("INSERT INTO fecha_despacho (id_alumnoo, fecha_entrega) VALUES ($id_alumno, '$fecha')");

// Redirigir manteniendo filtros
$dni       = $_POST['dni'] ?? '';
$curso     = $_POST['curso'] ?? '';
$division  = $_POST['division'] ?? '';

header("Location: despachar.php?dni=$dni&curso=$curso&division=$division");
exit;
?>
