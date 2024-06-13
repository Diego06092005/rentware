<?php
// Establecer conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_de_datos = 'rentware'; // Nombre de tu base de datos

$mysqli = new mysqli($host, $usuario, $contrasena, $base_de_datos);

if ($mysqli->connect_error) {
    die("Error de conexión a la base de datos: " . $mysqli->connect_error);
}

// Verificar si los campos están presentes en $_POST
if (
    isset($_POST['nombres']) &&
    isset($_POST['new_username']) &&
    isset($_POST['new_password']) &&
    isset($_POST['email']) &&
    isset($_POST['cedula']) &&
    isset($_POST['fecha_nacimiento']) &&
    isset($_POST['telefono']) &&
    isset($_POST['id_cargo']) &&
    isset($_POST['apellidos']) &&
    isset($_FILES['imagen']) // Verificar si se envió la imagen
) {
    // Recoger datos del formulario
    $nombre = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $new_usuario = $_POST['new_username'];
    $new_contraseña = $_POST['new_password'];
    $email = $_POST['email'];
    $cedula = $_POST['cedula'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $telefono = $_POST['telefono'];
    $id_cargo = $_POST['id_cargo'];

    // Procesar y guardar la imagen
    $ruta_destino = "C:/xampp/htdocs/rentware/uploads/";
    $nombre_imagen = $_FILES["imagen"]["name"];
    $ruta_imagen = $ruta_destino . $nombre_imagen;

    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_imagen)) {
        // Consulta para insertar los datos en la base de datos
        $sql = "INSERT INTO usuarios (nombres, apellidos, username, password, email, cedula, fecha_nacimiento, telefono, id_cargo, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la consulta
        if ($stmt = $mysqli->prepare($sql)) {
            try {
                // Vincular parámetros y ejecutar la consulta
                $stmt->bind_param("ssssssssis", $nombre, $apellidos, $new_usuario, $new_contraseña, $email, $cedula, $fecha_nacimiento, $telefono, $id_cargo, $ruta_imagen);
                $stmt->execute();

                // Verificar si la inserción fue exitosa
                if ($stmt->affected_rows > 0) {
                    // Inserción exitosa, puedes redirigir a una página de éxito o mostrar un mensaje
                    echo '<p class="success-message">Registro exitoso. ¡Bienvenido al sistema! ' . $nombre . ' ' . $apellidos . '</p>';
                } else {
                    echo "Error al insertar el usuario.";
                }
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() === 1062) { // Código específico de error de duplicado en MySQL
                    echo "La cédula ingresada ya está registrada.";
                } else {
                    echo "Error: " . $e->getMessage();
                }
            }

            // Cerrar la consulta preparada
            $stmt->close();
        } else {
            echo "Error en la consulta: " . $mysqli->error;
        }
    } else {
        echo "Hubo un error al subir la imagen.";
    }
} else {
    echo "Faltan datos en el formulario.";
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>

<!-- El resto de tu código HTML y CSS sigue igual -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volver al Registro</title>
 
</head>
<body>
<a href="../vista/registro2.php" class="login-link">Volver al Registro</a>

</body>
</html>
<style>
    .login-link {
    display: inline-block;
    padding: 12px 20px;
    background-color: #FF0000;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    text-transform: uppercase;
    transition: background-color 0.3s, color 0.3s, transform 0.3s;
}

.login-link:hover {
    background-color: #00FF00;
    color: rgb(0, 0, 0);
    transform: scale(1.05);
}

/* Otros estilos que puedas necesitar para el enlace */

   .success-message {
    color: #008000; /* Verde oscuro */
    font-weight: bold;
    font-size: 30px; /* Tamaño de la fuente */
    margin-top: 20px; /* Espacio superior */
}

    body {
    background-image: url('../IMG/rent.png'); 
    background-size: cover; 
    background-position: center center; 
    text-align: center;
    margin-top: 50px;
    background-color: #333; /* Negro */
    color: #fff; /* Blanco */
}

.login-link {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3498db; /* Azul */
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
}

/* Estilos para el formulario */
form {
    background-color: #fff; /* Blanco */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #333; /* Negro */
}

input,
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc; /* Gris */
    border-radius: 4px;
    box-sizing: border-box;
    background-color: #fff; /* Blanco */
    color: #333; /* Negro */
}

select {
    appearance: none;
    -webkit-appearance: none;
}

/* Estilo para el mensaje de error */
.error-message {
    color: #ff0000; /* Rojo */
    font-weight: bold;
}

/* Estilo para el mensaje de éxito */
.success-message {
    color: #008000; /* Verde oscuro */
    font-weight: bold;
}

</style>