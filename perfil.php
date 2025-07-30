<?php
session_start();
include("conexion.php");

// Validar sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$id = $_SESSION['id_usuario'];

$sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/perfil.css" />
    <title>Perfil</title>
</head>
<body>
    <H1>Perfil</H1>
  <main>
    <section class="perfil-container">
      <div class="perfil-info">
        <div class="foto-nombre">
          <div class="foto-perfil">
            <img id="imgPerfil" src="https://via.placeholder.com/100" alt="Foto de perfil">
            <input type="file" id="fileInput" accept="image/*">
          </div>
          <div class="datos-usuario">
            <h2><?= htmlspecialchars($usuario['nombre']) . " " . htmlspecialchars($usuario['apellido']) ?></h2>
            <p><?= htmlspecialchars($usuario['correo']) ?></p>
          </div>
        </div>

        <div class="descripcion">
          <h3>Editar Información</h3>
          <form method="POST" action="procesar_actualizacion_perfil.php">
            <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">

            <label>Nombre:</label><br>
            <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required><br><br>

            <label>Apellido:</label><br>
            <input type="text" name="apellido" value="<?= htmlspecialchars($usuario['apellido']) ?>" required><br><br>

            <label>Correo:</label><br>
            <input type="email" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required><br><br>

            <label>Contraseña (dejar en blanco si no se cambia):</label><br>
            <input type="password" name="contraseña" autocomplete="new-password"><br><br>

            <button type="submit">Actualizar</button>
            <?php
            $destinoCancelar = ($usuario['id_cargo'] == 3) ? "despachar.php" : "inicio.php";
            ?>
              <a href="<?= $destinoCancelar ?>"><button type="button">Cancelar</button></a>

          </form>
        </div>

        <div class="eliminar">
          <form method="POST" action="eliminar_cuenta.php" onsubmit="return confirm('¿Estás seguro que querés eliminar tu cuenta?')">
            <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
            <button type="submit" class="btn-eliminar">Eliminar cuenta</button>
          </form>
        </div>
      </div>
    </section>
  </main>

  <script>
    // Mostrar imagen cargada (sin guardar en base de datos)
    const fileInput = document.getElementById("fileInput");
    const imgPerfil = document.getElementById("imgPerfil");

    fileInput.addEventListener("change", function () {
      const archivo = fileInput.files[0];
      if (archivo) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imgPerfil.src = e.target.result;
        };
        reader.readAsDataURL(archivo);
      }
    });
  </script>
</body>
</html>
