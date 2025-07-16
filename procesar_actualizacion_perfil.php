<?php
session_start();
include("conexion.php");

// Validar sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Validar que se haya enviado por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario = intval($_POST['id_usuario']);
    $nombre     = trim($_POST['nombre']);
    $apellido   = trim($_POST['apellido']);
    $correo     = trim($_POST['correo']);
    $contraseña = trim($_POST['contraseña']);

    // Si se cargó una nueva contraseña, actualizarla
    if (!empty($contraseña)) {
        // Si ya usás contraseñas cifradas con password_hash
        // $hash = password_hash($contraseña, PASSWORD_DEFAULT);

        $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, contraseña = ? WHERE id_usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $apellido, $correo, $contraseña, $id_usuario);
    } else {
        // Si no se cargó contraseña, actualizar todo menos la contraseña
        $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, correo = ? WHERE id_usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $apellido, $correo, $id_usuario);
    }

    if ($stmt->execute()) {
        // Si el usuario actualizó su propio perfil, también actualizamos los datos en $_SESSION
        if ($id_usuario == $_SESSION['id_usuario']) {
            $_SESSION['nombre'] = $nombre;
            $_SESSION['correo'] = $correo;
        }

        header("Location: perfil.php");
        exit();
    } else {
        echo "❌ Error al actualizar los datos.";
    }

} else {
    // Si alguien intenta acceder directo sin POST
    header("Location: inicio.php");
    exit();
}
?>
