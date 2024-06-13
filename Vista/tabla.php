<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
require_once("../modelo/conexion.php");

// Consulta para usuarios con id_cargo igual a 1
$sql_cargo1 = "SELECT * FROM usuarios WHERE id_cargo = 1";
$result_cargo1 = $mysqli->query($sql_cargo1);
// Consulta para usuarios con id_cargo igual a 2
$sql_cargo2 = "SELECT * FROM usuarios WHERE id_cargo = 2";
$result_cargo2 = $mysqli->query($sql_cargo2);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arrendadores y arrendatarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../modelo/assets/css/tabla.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="sesiones514.php">
        <img src="../IMG/regresar.png" alt="regresar" class="img">
    </a>
</nav>

<div class="container mt-5">
    <!-- Tabla para usuarios con id_cargo igual a 1 -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand mb-0 h1 text-center w-100">A R R E N D A D O R E S</span>
        </div>
    </nav>
    <div class="table-responsive">
        <table class="table table-striped mt-3">
            <!-- Encabezado de la tabla -->
            <thead class="thead-dark">
                <tr>
                    <th>id</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Correo Electrónico</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Número de Cédula</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Teléfono</th>
                    <th>ID de Cargo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($result_cargo1)) {
                    while ($row = $result_cargo1->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['nombres'] . "</td>";
                        echo "<td>" . $row['apellidos'] . "</td>";
                        echo "<td>" . $row['cedula'] . "</td>";
                        echo "<td>" . $row['fecha_nacimiento'] . "</td>";
                        echo "<td>" . $row['telefono'] . "</td>";
                        echo "<td>" . $row['id_cargo'] . "</td>"; 
                        echo "<td>";
                        echo "<a href='cambia.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm mr-1'><i class='fas fa-pencil-alt'></i></a>";
                        echo "<form method='POST' action='tabla.php' class='d-inline'>";
                        echo "<input type='hidden' name='id_a_borrar' value='" . $row['id'] . "'>";
                        echo "<button class='btn btn-danger btn-sm' type='submit' name='borrar'><i class='fas fa-trash-alt'></i></button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand mb-0 h1 text-center w-100">A R R E N D A T A R I O S</span>
    </div>
</nav>

    <div class="table-responsive">
        <table class="table table-striped mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>id</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Correo Electrónico</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Número de Cédula</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Teléfono</th>
                    <th>ID de Cargo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($result_cargo2)) {
                    while ($row = $result_cargo2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['nombres'] . "</td>";
                        echo "<td>" . $row['apellidos'] . "</td>";
                        echo "<td>" . $row['cedula'] . "</td>";
                        echo "<td>" . $row['fecha_nacimiento'] . "</td>";
                        echo "<td>" . $row['telefono'] . "</td>";
                        echo "<td>" . $row['id_cargo'] . "</td>"; 
                        echo "<td>";
                        echo "<a href='cambia.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm mr-1'><i class='fas fa-pencil-alt'></i></a>";
                        echo "<form method='POST' action='tabla.php' class='d-inline'>";
                        echo "<input type='hidden' name='id_a_borrar' value='" . $row['id'] . "'>";
                        echo "<button class='btn btn-danger btn-sm' type='submit' name='borrar'><i class='fas fa-trash-alt'></i></button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

