<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despachar</title>
</head>
<body>
    <h1>Zona despacho</h1>
    
    <?php if (isset($_SESSION['id_usuario'])): ?>
        <h2>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?> 👋</h2>
        <br>
        <a href="cerrar_sesion.php">
            <button>Cerrar sesión</button>
        </a>
          
        <a href="perfil.php">
            <button>Editar perfil</button>
        </a>
    <?php else: ?>
        <h3>No has iniciado sesión.</h3>
        <a href="index.php">
            <button>Volver al inicio</button>
        </a>
    <?php endif; ?>

</body>
</html>
