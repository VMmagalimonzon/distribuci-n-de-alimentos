<?php
session_start();
include("conexion.php");


$correo = trim($_GET['Correo']);
$contraseña = trim($_GET['Contraseña']);


$sql = "SELECT id_usuario, correo, contraseña, id_cargo, nombre FROM usuarios WHERE correo = ? AND contraseña = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $correo, $contraseña);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if ($usuario) {
    
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['correo']     = $usuario['correo'];
    $_SESSION['nombre']     = $usuario['nombre'];
    $_SESSION['id_cargo']   = $usuario['id_cargo'];
    
   
    if ($usuario['id_cargo'] == 3) {
        header('Location: despachar.php');
    } else {
        header('Location: inicio.php');
    }
    exit();
} else {
    echo "❌ Correo o contraseña incorrectos.";
}
?>
