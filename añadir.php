<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Estudiantes</title>
</head>
<body>
    <h1>Añadir estudiantes</h1>
    <p>Por favor añada a los estudiantes con los datos correspondientes</p>

    <form action="" name="añadir" method="post">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <p>dni sin puntos y sin espacios </p>
        <input type="number" name="dni" placeholder="DNI" required>
        <input type="text" name="curso" placeholder="Curso" required>
        <input type="text" name="division" placeholder="División" required>

        <label>¿Es celíaco?</label>
        <select name="celiaco" required>
            <option value="1">Sí</option>
            <option value="0">No</option>
        </select>

        <label>¿Es diabético?</label>
        <select name="diabetico" required>
            <option value="1">Sí</option>
            <option value="0">No</option>
        </select>

        <br><br>
        <input type="submit" name="añadir" value="Añadir">
        <input type="reset" value="Limpiar">
    </form>
    <a href="inicio.php">
        <button>Volver al menu </button>
    </a>
    <a href="alumnos.php">
        <button>Ver registro de alumnos</button>
    </a>
   
    <?php
    include("conexion.php");

    if (isset($_POST['añadir'])) {
        $nombre = trim($_POST['nombre']);
        $apellido = trim($_POST['apellido']);
        $dni = trim($_POST['dni']);
        $curso = trim($_POST['curso']);
        $division = trim($_POST['division']);
        $celiaco = intval($_POST['celiaco']); // convertimos a entero
        $diabetico = intval($_POST['diabetico']);

        $consulta = "INSERT INTO alumno VALUES('', '$nombre', '$apellido', '$dni', '$curso', '$division', '$celiaco', '$diabetico')";
        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado) {
            header('Location: añadir.php');
            exit();
        } else {
            echo "<h3 class='error'>Ocurrió un error al guardar el registro.</h3>";
        }
    }
    ?>

</body>
</html>
