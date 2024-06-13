<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registro de Inmuebles</title>
       <!-- Icono de la página web -->
       <link rel="icon" type="image/png" href="../vista/IMG/rent2.png">
    <!-- CSS de Bootstrap - Solo una versión -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
    <!-- Bootstrap Icons para iconos adicionales -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Animate.css para animaciones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> 
    <!-- Boxicons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../modelo/assets/css/vista_contratos.css">
    <!-- Script de jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Script de DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
   <!-- Script de Bootstrap (opcional si estás utilizando Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
   <!-- Script de DataTables Bootstrap -->
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="../modelo/javascript/contador.js"></script>
  <script>
$(document).ready(function() {
    $('.tabla-contratos').DataTable({
        "scrollY": "400px",
        "scrollCollapse": true,
        "lengthMenu": [5, 10, 15, 20],
        "paging": true, 
        "pageLength": 4,
        "startPage": 1,
        "searching": true,
        "language": { 
            "lengthMenu": "Mostrar _MENU_ Registros por página",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "previous": "←",
                "next": "→"
            }
        }
    });
});
</script>
<?php
session_start();
include '../modelo/conexion.php';
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
if (isset($_SESSION['usuario'])) {
    $nombre_usuario = $_SESSION['usuario'];
    $query_usuario = "SELECT id FROM usuarios WHERE username = '$nombre_usuario'";
    $result_usuario = mysqli_query($mysqli, $query_usuario);
    if ($result_usuario) {
        $fila_usuario = mysqli_fetch_assoc($result_usuario);
        $id_usuario = $fila_usuario['id'];
        $sqlMensajesNoLeidos = "SELECT COUNT(*) AS no_leidos FROM messages WHERE incoming_msg_id = $id_usuario AND is_read = 0";
        $resultadoMensajesNoLeidos = $mysqli->query($sqlMensajesNoLeidos);
        $mensajesNoLeidos = 0;
        if ($fila = $resultadoMensajesNoLeidos->fetch_assoc()) {
            $mensajesNoLeidos = $fila['no_leidos'];
        }
        echo "<br><br>";     
   } else {
       echo "Error: No se pudo obtener el ID del usuario.";
   }
} else {
   echo "Usuario no ha iniciado sesión.";
}
?>
</head>
<body>
<!-- Barra de Navegación Responsive con Menú de Usuario -->
<nav class="navbar navbar-dark navbar-expand-lg fixed-top" style="background-color: black;">
    <div class="container-fluid">
        <a href="sesiones514.php">
            <img src="../vista/IMG/logo2.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
           <a style="margin-bottom: 10px;"></a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'tabla_tario.php' ? 'active' : ''; ?>" href="tabla_tario.php"><i class="fa fa-users" style="color:red;"></i> Arrendatarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'inmueble.php' ? 'active' : ''; ?>" href="inmueble.php"><i class="fas fa-city" style="color:orange;"></i> Inmuebles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'vista_contratos.php' ? 'active' : ''; ?>" href="vista_contratos.php"><i class="bx bx-file" style="color:lightblue;" ></i> Contratos</a>
                </li>
                <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : ''; ?>" href="users.php">
                    <span style="display: inline-block; margin-right: 5px;"><i class="fas fa-comments" style="color:#08d847;"></i></span> Chat
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'crearAnuncio.php' ? 'active' : ''; ?>" href="crearAnuncio.php" ><i class="bi bi-megaphone" style="color:orange;" ></i> Anuncios</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="perfil.php"><i class="fa fa-user-circle" style="color:lightblue;"></i> Ir al perfil</a></li>
                     <li>
                       
                          
                     </li>  
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="../controlador/logout.php?logout_id=<?php echo $id_usuario; ?>" class="nav-link scrollto logout">
            <span style="color: white;"><i class="fas fa-sign-out-alt" style="color:red;"></i> Cerrar Sesión</span>
          </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<br>

    <div class="container mt-5">
    <h2> <i class="bx bx-file"></i> Subir Contrato </h2>
        <form action="../controlador/guardar_contrato.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="archivo" class="form-label">Seleccionar Archivo PDF</label>
                <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf" required>
            </div>
            <div class="mb-3">
                <label for="arrendatario" class="form-label">Seleccionar Arrendatario</label>
                <select class="form-select" id="arrendatario" name="arrendatario" required>
                    <option value="">Seleccionar Arrendatario</option>
<?php
 session_start();
 include 'conexion.php';
 if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
 if (isset($_SESSION['usuario'])) {
    $nombre_usuario = $_SESSION['usuario'];
    // consulta para obtener el id del usuario basado en su nombre de usuario.
    $query_usuario = "SELECT id FROM usuarios WHERE username = '$nombre_usuario'";
    $result_usuario = mysqli_query($mysqli, $query_usuario);
    if ($result_usuario) {
        $fila_usuario = mysqli_fetch_assoc($result_usuario);
        $id_usuario = $fila_usuario['id'];
        $query = "SELECT aren_cedula_id, aren_nombre, aren_apellido FROM arrendatario WHERE id_usuario = $id_usuario";
        $result = mysqli_query($mysqli, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['aren_cedula_id'] . "'>" . $row['aren_nombre'] . " " . $row['aren_apellido'] . "</option>";
        }
    } else {
        echo "Error: No se pudo obtener el ID del usuario.";
    }
 } else {
    echo "Usuario no ha iniciado sesión.";
 }
?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Subir Contrato</button>
        </form>
    </div>
<div class="container mt-5">
    <h2>Contratos de Arrendatarios</h2>
    <table class="tabla-contratos">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre Arrendatario</th>
                <th scope="col">Apellido Arrendatario</th>
                <th scope="col">Archivo</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <br>
            <?php
            // Consulta para obtener los contratos de los arrendatarios relacionados con el usuario
            $query_contratos = "SELECT contratos.id, arrendatario.aren_nombre, arrendatario.aren_apellido, contratos.archivo 
                                FROM contratos
                                INNER JOIN arrendatario ON contratos.id_arrendatario = arrendatario.aren_cedula_id
                                WHERE arrendatario.id_usuario = $id_usuario";
            $result_contratos = mysqli_query($mysqli, $query_contratos);
            if (mysqli_num_rows($result_contratos) > 0) {
                while($row = mysqli_fetch_assoc($result_contratos)) {
                    echo "<tr>";
                    echo "<td style='color: white;'>" . $row["id"] . "</td>";
                    echo "<td style='color: white;'>" . $row["aren_nombre"] . "</td>";
                    echo "<td style='color: white;'>" . $row["aren_apellido"] . "</td>";
                    echo "<td>";
                    echo "<a href='../modelo/Descargas/" . $row["archivo"] . "' target='_blank'>Ver Contrato</a>";
                    echo "</td>";
                    echo "<td>";
                    echo "<form action='../controlador/eliminar_contrato.php' method='post' onsubmit='return confirmDelete()'>";
                    // Pasar el ID del contrato como un campo oculto en el formulario
                    echo "<input type='hidden' name='contrato_id' value='" . $row["id"] . "'>";
                    echo "<button type='submit' class='btn btn-danger'>Eliminar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                    echo "<script>function confirmDelete() {
                        return confirm('¿Estás seguro de que deseas eliminar este contrato?');
                        }
                        </script>";
                    }
            } else {
                echo "<tr><td colspan='4' style='color: red;'>No se encontraron contratos.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
<script>
       const urlParams = new URLSearchParams(window.location.search);
     const exito = urlParams.get('exito');
 if (exito === 'true') {
    const popup = document.createElement('div');
    popup.style.position = 'fixed';
    popup.style.top = '0';
    popup.style.left = '0';
    popup.style.width = '100%';
    popup.style.height = '100%';
    popup.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    popup.style.zIndex = '9999';
    popup.style.display = 'flex';
    popup.style.alignItems = 'center';
    popup.style.justifyContent = 'center';
    const gif = document.createElement('img');
    gif.src = '../vista/IMG/rentwar.gif'; 
    gif.style.width = '300px'; 
    popup.appendChild(gif);
    document.body.appendChild(popup);
    // Cierra el popup después de 3 segundos (3000 milisegundos)
    setTimeout(() => {
        document.body.removeChild(popup);
    }, 2000);
 }
</script>
<script src="../modelo/javascript/notificaciones.js"></script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
</style>
