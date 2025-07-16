<?php
session_start();
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/inicio.css">
</head>
<body>
    <h1>Inicio</h1>
    <br>

    <?php if (isset($_SESSION['id_usuario'])): ?>
        <h2>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?> 👋</h2>
        <br>
        <a href="cerrar_sesion.php">
            <button>Cerrar sesión</button>
        </a>
          
    <a href="despachar.php">
        <button>Despachar</button>
    </a>
    <a href="añadir.php">
        <button>Añadir Alumnos</button>
    </a>
    <a href="perfil.php">
        <button>Editar perfil</button>
    </a>
    <a href="stock.php">
        <button>Stock</button>
    </a>
    <a href="alumnos.php">
        <button>Alumnos registrados</button>
    </a>
    <?php else: ?>
        <a href="sesion.php">
            <button>Iniciar sesión</button>
        </a>
        <br><br>
        <a href="registrase.php">
            <button>Registrarse</button>
        </a>
    <?php endif; ?>
        
</body>
</html>
