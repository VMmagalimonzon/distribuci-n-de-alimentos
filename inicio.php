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
     <div class="menu">
      <a href="cerrar_sesion.php"><button><p>Cerrar sesión</p></button></a>
      <a href="despachar.php"><button><p>Despachar</p></button></a>
      <a href="añadir.php"><button><p>Añadir Alumnos</p></button></a>
      <a href="perfil.php"><button><p>Editar perfil</p></button></a>
      <a href="stock.php"><button><p>Stock</p></button></a>
      <a href="alumnos.php"><button><p>Alumnos registrados</p></button></a>
     </div>

    <?php else: ?>
        <div class="menu">
        <a href="sesion.php"><button><p>Iniciar sesión</p></button></a>
        <br><br>
        <a href="registrase.php"><button><p>Registrarse</p></button></a>
        </div>
    <?php endif; ?>
        <footer class="footer">
         <svg viewBox="0 0 1440 100" preserveAspectRatio="none">
          <path d="M0,0 C480,80 960,0 1440,60 L1440,100 L0,100 Z" fill="#008f6c" />
         </svg>
          <div class="footer-content">
           <p>&copy; 2025 Distribucion de Alimentos - Todos los derechos reservados</p>
          </div>
        </footer>

</body>
</html>
