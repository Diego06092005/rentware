
<!DOCTYPE html>
<html>
<head>
<link rel="Website Icon" type="png" href="../rentware/IMG/rent2.png">
    <title>Modificar Registro</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-image: url('../rentware/IMG/rent.png'); 
        background-size: cover; 
        background-position: center center; 
        }
        h1 {
            color: red;
        }
        fieldset {
            border: 1px solid white;
            border-radius: 5px;
            padding: 20px;
            background-color: #333;
        }
        legend {
            color: red;
            font-weight: bold;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: white;
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
    <h1>Modificar Registro</h1>
<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redirigir o mostrar un mensaje de error
    header("Location: ../index.php"); // Redirigir a la página de inicio de sesión
    exit();
}

function consultar($con, $consulta) {
    if (!$datos = mysqli_query($con, $consulta) or mysqli_num_rows($datos) < 1) {
        return false; // Si la consulta fue rechazada por errores de sintaxis o no se encontraron registros, devolvemos false
    } else {
        return $datos;
    }
}

function editar($id) {
    if ($fila = mysqli_fetch_array($id)) {
        $usuarioActual = $fila['username'];
        $PasswordActual = $fila['password'];


        echo "usuario:" . $fila['username'] . "<br>";
        $id = '<form action="cambia.php" method="post">
        <fieldset><legend>Puede modificar los datos de este registro:</legend>
        <p>
        <label>usuario:
        <input name="username" type="text" value="' . $usuarioActual . '">
        </label>
        </p>
        <p>
        <label>Password:
        <input name="Password" type="varchar" value="' . $PasswordActual . '">
        </label>
        </p>
        <p>
        <input type="hidden" name="id" value="' . $fila['id'] . '">
        </p>
        <p>
        <input type="submit" name="Submit" value="Guardar cambios">
        </p>
        </fieldset>
        </form>';
    } else {
        $id = false;
    }
    return $id;
}
?>

