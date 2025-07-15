<?php
session_start();
include("conexion.php");

// Verificar sesión activa
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Verificar que se envió por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario = intval($_POST['id_usuario']);

    // Solo permitimos que se elimine su propia cuenta (o en todo caso desde un panel admin)
    if ($id_usuario != $_SESSION['id_usuario']) {
        echo "❌ No tenés permisos para eliminar esta cuenta.";
        exit();
    }

    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_usuario);

    if ($stmt->execute()) {
        // Cerrar sesión
        session_unset();
        session_destroy();

        // Redirigir al index
        header("Location: index.php");
        exit();
    } else {
        echo "❌ Error al eliminar la cuenta.";
    }
} else {
    // Si alguien intenta entrar directo sin POST
    header("Location: index.php");
    exit();
}
?>
