<!DOCTYPE html>
<html lang="en">
<head>
<link rel="Website Icon" type="png" href="../rentware/IMG/rent2.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BORRADO DE REGISTROS</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            background-image: url('../rentware/IMG/rent.png'); 
        background-size: cover; 
        background-position: center center; 
        }
        h2 {
            color: red;
        }
        .form-container {
            margin: 0 auto;
            width: 300px;
            padding: 20px;
            background-color: #333;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 3px;
        }
        input[type="submit"] {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
        }
        input[type="submit"]:hover {
            background-color: #FF0000;
        }
    </style>
</head>
<body background="../rentware/IMG/rent.png">
    <h2>Eliminación de Registros</h2>
    <h3>Resultado de la operación</h3>

    <?php
    session_start();

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario'])) {
        // El usuario no ha iniciado sesión, redirigir o mostrar un mensaje de error
        header("Location: ../index.html"); // Redirigir a la página de inicio de sesión
        exit();
    }
    
include 'conexion.php';

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];

    // Consultamos el nombre asociado al ID
    $consulta_nombre = "SELECT username FROM usuarios WHERE id='$id'";
    $resultado_nombre = mysqli_query($conexion, $consulta_nombre);

    if ($resultado_nombre && mysqli_num_rows($resultado_nombre) > 0) {
        $fila = mysqli_fetch_assoc($resultado_nombre);
        $nombre = $fila['username'];

        // Eliminamos el registro
        $consulta = "DELETE FROM usuarios WHERE id='$id'";

        if (mysqli_query($conexion, $consulta)) {
            echo "Se eliminó el registro del usuario: " . $nombre . " con ID: " . $id . " satisfactoriamente.";
        } else {
            echo "No se pudo eliminar el registro.";
        }
    } else {
        echo "No se encontró un usuario con el ID proporcionado.";
    }

    echo '<p>Regresar al <a href="tabla.php">Inicio</a></p>';
} else {
    echo '<p>Error: ID no proporcionado o método incorrecto.</p>';
}

$conexion->close();
?>

</body>
</html>
