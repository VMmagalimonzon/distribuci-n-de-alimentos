<?php
include("conexion.php");
session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <h1>Distribucion de alimentos</h1>

    <a href="sesion.php">
       <button>Iniciar sesión</button>
    </a>

    <a href="registrase.php">
        <button>Registrarse</button>
    </a>
      
    <div class="footer">
        Proyecto escolar • Distribución de alimentos
    </div>
</body>
</html>