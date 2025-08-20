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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/perfil.css" />
    <title>Perfil</title>
</head>
<body>
    <h1>Perfil</h1>
    <main>
        <section class="perfil-container">

            <!-- Encabezado perfil -->
            <div class="perfil-header">
                <div class="perfil-foto">
                    <img id="preview-foto" src="<?= htmlspecialchars($usuario['foto'] ?? 'uploads/default.png') ?>" alt="Foto de perfil">
                </div>
                <div class="perfil-datos">
                    <h2><?= htmlspecialchars($usuario['nombre']) . " " . htmlspecialchars($usuario['apellido']) ?></h2>
                    <p class="correo"><?= htmlspecialchars($usuario['correo']) ?></p>
                    <p class="rol">Usuario registrado</p>
                    
                    <div class="perfil-botones">
                      
                        <a href="inicio.php"><button class="btn-azul">Ir a menú</button></a>
                    </div>
                </div>
                    
            </div>

           
            <!-- Formulario editar -->
            <div class="perfil-editar">
                <h3>Editar Información</h3>
                <form method="POST" action="procesar_actualizacion_perfil.php" enctype="multipart/form-data">
                    <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">

                    <label>Nombre:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

                    <label>Apellido:</label>
                    <input type="text" name="apellido" value="<?= htmlspecialchars($usuario['apellido']) ?>" required>

                    <label>Correo:</label>
                    <input type="email" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required>

                    <label>Descripción:</label>
                    <textarea name="descripcion" rows="4"><?= htmlspecialchars($usuario['descripcion']) ?></textarea>

                    <label for="foto" class="file-label">Foto de perfil:</label>
                    <input type="file" id="foto" name="foto" accept="image/*">

                    <label>Contraseña (dejar en blanco si no se cambia):</label>
                    <input type="password" name="contraseña" autocomplete="new-password">

                    <button type="submit" class="btn-verde">Actualizar</button>
                    <?php $destinoCancelar = ($usuario['id_cargo'] == 3) ? "despachar.php" : "inicio.php"; ?>
                    <a href="<?= $destinoCancelar ?>"><button type="button" class="btn-gris">Cancelar</button></a>
                </form>
            </div>

            <!-- Eliminar cuenta -->
            <div class="perfil-eliminar">
                <form method="POST" action="eliminar_cuenta.php" onsubmit="return confirm('¿Estás seguro que querés eliminar tu cuenta?')">
                    <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
                    <button type="submit" class="btn-rojo">Eliminar cuenta</button>
                </form>
            </div>
        </section>
    </main>

    <!-- Script para vista previa de foto -->
    <script>
    document.getElementById("foto").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("preview-foto").src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
</body>
</html>
