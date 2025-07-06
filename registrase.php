<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse </title>
</head>
<body>
    <h1>Registrase</h1>
    <p>Por favor completa los siguientes campos para poder crearte un usuario</p>

     <form action="" name="registro" method="post" required>
     <input type="text" name="Nombre" placeholder="Nombre" required>
     <input type="text" name="Apellido" placeholder="Apellido" required>
     <input type="email" name="Correo" placeholder="Correo electronico" required>
     <input type="password" name="Contraseña" placeholder="Contraseña" required>
     <input type="number" name="Dni" placeholder="Dni" required>


     <input type="submit" name="Registrar">
     <input type="reset">
    </form>
    <br>
    <p>¿Ya tienes una cuenta ? inicia secion aqui
    </p>
    <br>
    <a href="sesion.php">
        <button>Inicia sesion</button>
    </a>
</body>
 <?php
 include("conexion.php");
 
 if (isset($_POST['Registrar'])) {
      $nombre = trim($_POST['Nombre']);
      $apellido = trim($_POST['Apellido']);
      $correo = trim($_POST['Correo']);
      $contraseña = trim($_POST['Contraseña']);
      $dni= trim($_POST['Dni']);
      
      $consulta ="INSERT INTO usuarios VALUES('', '$nombre','$apellido', '$correo', '$contraseña','$dni', 2)";
      $resultado = mysqli_query($conexion, $consulta);
      if ($resultado) {
         header('location:index.php');
         ?>
         <h3 class="success">Tu registro se a completado </h3>
        
         <?php
      } else {
         ?>
         <h3 class="error">Ocurrio un error </h3>
         <?php
      }
 }
?>

</html>