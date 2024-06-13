<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$conexion = mysqli_connect("localhost", "root", "", "rentware");
if (!$conexion) {
    echo "Error de conexión a la base de datos";
    exit;
}

if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
    $cedula = $_POST['usuario']; // Usamos 'usuario' del formulario para pasar la cédula
    $contraseña = $_POST['contraseña'];

    $consulta = "SELECT * FROM usuarios WHERE cedula=?";
    $sentencia = mysqli_prepare($conexion, $consulta);
    if (!$sentencia) {
        die("Error en la consulta preparada: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($sentencia, "s", $cedula);
    mysqli_stmt_execute($sentencia);
    $resultado = mysqli_stmt_get_result($sentencia);
    $filas = mysqli_fetch_assoc($resultado);

    if ($filas && password_verify($contraseña, $filas['password'])) {
        $_SESSION['usuario'] = $filas['username']; // Guardamos el username en la sesión
        $_SESSION['id_usuario'] = $filas['id'];
        $_SESSION['id_cargo'] = $filas['id_cargo'];
        $_SESSION['unique_id'] = $filas['id']; // identificar de manera única al usuario
        $_SESSION['cedula'] = $cedula; // Guardamos la cédula en la sesión

        // Actualizar el estado del usuario a "En línea"
        $actualizarEstado = "UPDATE usuarios SET status = 'En línea' WHERE id = ?";
        $sentenciaEstado = mysqli_prepare($conexion, $actualizarEstado);
        if (!$sentenciaEstado) {
            die("Error al preparar actualización de estado: " . mysqli_error($conexion));
        }
        mysqli_stmt_bind_param($sentenciaEstado, "i", $_SESSION['id_usuario']);
        mysqli_stmt_execute($sentenciaEstado);
        mysqli_stmt_close($sentenciaEstado);

        header("location: ../Vista/sesiones514.php"); // Redirige a otra página después del login exitoso
    } else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Login</title>
    <style>
        body {
            background-image: url('../vista/IMG/fondos10.jpeg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #1f2120; color: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <h2 style="color: red; text-align: center; margin-bottom: 30px;"><i class='fas fa-exclamation-circle animate__animated animate__tada animate__infinite' style='color: red;'></i> Datos Incorrectos</h2>
        <p style="text-align: center;">Sistema dice: Cedula o contraseña incorrectas.</p>
        <div style="text-align: center; margin-top: 20px;">
            <button style="background-color: #1f9941; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;" onclick="window.location.href='../index.php#about';">Intentalo nuevamente</button>
        </div>
    </div>
</body>
</html>
<?php
        exit();
    }
}
?>
