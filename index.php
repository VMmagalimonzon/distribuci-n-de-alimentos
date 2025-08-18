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