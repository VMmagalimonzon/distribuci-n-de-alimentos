<?php
session_start();
include("conexion.php");

// Validar sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario  = intval($_POST['id_usuario']);
    $nombre      = trim($_POST['nombre']);
    $apellido    = trim($_POST['apellido']);
    $correo      = trim($_POST['correo']);
    $descripcion = trim($_POST['descripcion']);
    $contraseña  = trim($_POST['contraseña']);

    $foto = null;

    // Manejo de la foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $permitidos = ['image/jpeg', 'image/png', 'image/jpg'];
        $tipoArchivo = mime_content_type($_FILES['foto']['tmp_name']);

        if (in_array($tipoArchivo, $permitidos)) {
            // Crear nombre único
            $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $nombreFoto = uniqid("perfil_") . "." . strtolower($extension);
            $rutaDestino = "fotos_perfil/" . $nombreFoto;

            // Mover archivo subido
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
                $foto = $rutaDestino;
            }
        } else {
            die("❌ Solo se permiten imágenes JPG o PNG.");
        }
    }

    // Construcción dinámica de la query
    if (!empty($contraseña)) {
        // ⚠️ Lo ideal sería usar password_hash()
        $sql = "UPDATE usuarios 
                SET nombre = ?, apellido = ?, correo = ?, contraseña = ?, descripcion = ?" .
                ($foto ? ", foto = ?" : "") .
                " WHERE id_usuario = ?";

        if ($foto) {
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssssssi", $nombre, $apellido, $correo, $contraseña, $descripcion, $foto, $id_usuario);
        } else {
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssssi", $nombre, $apellido, $correo, $contraseña, $descripcion, $id_usuario);
        }
    } else {
        $sql = "UPDATE usuarios 
                SET nombre = ?, apellido = ?, correo = ?, descripcion = ?" .
                ($foto ? ", foto = ?" : "") .
                " WHERE id_usuario = ?";

        if ($foto) {
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssssi", $nombre, $apellido, $correo, $descripcion, $foto, $id_usuario);
        } else {
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssssi", $nombre, $apellido, $correo, $descripcion, $id_usuario);
        }
    }

    if ($stmt->execute()) {
        // Actualizar datos en sesión
        if ($id_usuario == $_SESSION['id_usuario']) {
            $_SESSION['nombre'] = $nombre;
            $_SESSION['correo'] = $correo;
            $_SESSION['descripcion'] = $descripcion;
            if ($foto) {
                $_SESSION['foto'] = $foto;
            }
        }

        header("Location: perfil.php");
        exit();
    } else {
        echo "❌ Error al actualizar los datos.";
    }
} else {
    header("Location: inicio.php");
    exit();
}
?>
