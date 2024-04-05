<?php
session_start();
include "conexion.php";
$message = "Información no disponible."; // Mensaje por defecto
$message_type = "info";
// Recuperando los datos del formulario
$cedula = mysqli_real_escape_string($mysqli, $_POST['cedula']);
$nombres = mysqli_real_escape_string($mysqli, $_POST['nombres']);
$apellidos = mysqli_real_escape_string($mysqli, $_POST['apellidos']);
$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$password = mysqli_real_escape_string($mysqli, $_POST['password']);
$fecha_nacimiento = mysqli_real_escape_string($mysqli, $_POST['fecha_nacimiento']);
$telefono = mysqli_real_escape_string($mysqli, $_POST['telefono']);
$id_cargo = mysqli_real_escape_string($mysqli, $_POST['id_cargo']);
$status = mysqli_real_escape_string($mysqli, $_POST['status']);
$id_arrendador = mysqli_real_escape_string($mysqli, $_POST['id_arrendador']); // Recuperando el id_arrendador del formulario

// Modificamos la verificación para excluir el campo id_arrendador
if (!empty($cedula) && !empty($nombres) && !empty($apellidos) && !empty($email) && !empty($password) && !empty($fecha_nacimiento) && !empty($telefono) && !empty($id_cargo) && !empty($status)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE email = '{$email}' OR cedula = '{$cedula}'");
        if (mysqli_num_rows($sql) > 0) {
            $message = "¡Este e-mail o cédula ya existe!";
            $message_type = "success";
        } else {
            // Manejo de la carga de la imagen
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name']; // Obtener el nombre de la imagen cargada
                $img_size = $_FILES['image']['size'];
                $tmp_name = $_FILES['image']['tmp_name'];
                $error = $_FILES['image']['error'];

                if ($error === 0) {
                    if ($img_size > 10000000) { // Si el archivo es mayor de 1MB
                        echo "¡El archivo es demasiado grande!";
                    } else {
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_lc = strtolower($img_ex);
                        $allowed_exs = array("jpg", "jpeg", "png");

                        if (in_array($img_ex_lc, $allowed_exs)) {
                            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                            $img_upload_path = 'uploads/'.$new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);

                            // Insertar en la base de datos
                            // Modificamos la consulta para permitir un valor NULL en id_arrendador
                            $insert_query = mysqli_query($mysqli, "INSERT INTO usuarios (cedula, nombres, apellidos, email, password, fecha_nacimiento, telefono, id_cargo, profile_image, status, id_arrendador, username) VALUES ('{$cedula}', '{$nombres}', '{$apellidos}', '{$email}', '{$password}', '{$fecha_nacimiento}', '{$telefono}', '{$id_cargo}', '{$new_img_name}', '{$status}', ".(!empty($id_arrendador) ? "'$id_arrendador'" : "NULL").", '{$nombres}')");

                            if ($insert_query) {
                                $message = "Proceso Exitoso. Bienvenido " . $nombres . " " . $apellidos;
                                $message_type = "success";

                               
                            } else {
                                $message = "Algo salió mal. ¡Inténtalo de nuevo!";
                                $message_type = "success";
                            }
                        } else {
                            $message = "Cargue un archivo de imagen válido: jpeg, png, jpg";
                            $message_type = "success";
                        }
                    }
                } else {
                    $message = "Error al cargar la Imagen.";
                $message_type = "success";
                }
            } else {
                $message = "Imagen no cargada";
                $message_type = "success";
            }
        }
    } else {
        $message = "Dirección de correo electrónico no válida.";
        $message_type = "success";
    }
} else {
    echo "¡Todos los campos de entrada son obligatorios excepto el ID del arrendador!";
}
?>
<!-- Incluir Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Opcional: Incluir jQuery y Popper.js, y luego Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
       background-image: url('IMG/fondo_register.png');
            color: #00FF00; /* Texto verde claro, estilo terminal o Matrix */
            font-family: 'Courier New', Courier, monospace; /* Tipografía que recuerda a los viejos terminales */
            background-repeat: no-repeat;
        background-size: cover;
             
        }
        .message-container {
            text-align: center;
            max-width: 600px;
            padding: 20px;
            border: 1px solid #00FF00;
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #0056b3;
            border-color: #004085;
            /* Estilos adicionales para el botón si se desea */
        }
    </style>
</head>
<body>
<div class="message-container">
    <h2><?php echo $message; ?></h2>
    <?php if ($message_type == "success"): ?>
        <a href='index.php' class='btn btn-primary'>Ir al login</a>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>