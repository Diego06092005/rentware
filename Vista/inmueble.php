<?php
//Se traen todas las clases, variables e instancia definidas en general_inmueble que seran necesarias para este apartado
include ("../controlador/general_inmueble.php");
?>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Script de DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet" href="../modelo/assets/css/inmueble.css">
    <script>
$(document).ready(function() {
    $('.tabla-inmueble').DataTable({
        "scrollY": "400px",
        "scrollCollapse": true,
        "lengthMenu": [5, 10, 15, 20],
        "paging": true, 
        "pageLength": 5, 
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
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
</style>
</head>
<body>
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
                   
                        <li><a href="../controlador/logout.php?logout_id=<?php echo $id_usuario; ?>" class="nav-link scrollto logout">
            <span style="color: white;"><i class="fas fa-sign-out-alt" style="color:red;"></i> Cerrar Sesión</span>
          </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<br><br><br>
    <div class="container mt-1">        
        <!-- Elemento de búsqueda -->
  <br>
  <?php
  // Consulta para obtener la cantidad total de inmuebles del usuario actual
$sql_count = "SELECT COUNT(*) as total_inmuebles FROM inmueble WHERE id_usuario = $id_usuario";
$result_count = $mysqli->query($sql_count);


echo '<style>
.success-message-container {
    text-align: center;
    padding-top: 50px; /* Espacio adicional para evitar superposición con otros elementos */
}
.success-message {
    color: green;
    background-color: #ccffcc;
    border: 1px solid green;
    padding: 10px;
    border-radius: 5px;
    display: inline-block; /* Esto asegura que el mensaje no afecte el ancho de otros elementos */
}
</style>';

// Verificar si existe el mensaje de éxito en la sesión
if (isset($_SESSION['success_message'])) {
    echo "<div class='success-message-container'><p class='success-message' id='successMessage'>" . $_SESSION['success_message'] . "</p></div>";
    // Eliminar el mensaje después de mostrarlo para que no aparezca de nuevo
    unset($_SESSION['success_message']);
}
echo '<script>
window.onload = function() {
    setTimeout(function() {
        var messageElem = document.getElementById("successMessage");
        if (messageElem) {
            messageElem.style.display = "none";
        }
    }, 4000); // Tiempo en milisegundos antes de que el mensaje se oculte (5000ms = 5s)
};
</script>';

 
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete() {
    return confirm("¿Estás seguro de que quieres borrar este inmueble?");
}
</script>
<a href="agregar.php" class="btn btn-success">
    <i class="fas fa-plus"></i>
    <i class="fas fa-home"></i>
    <span class="badge bg-secondary"><?php echo $total_inmuebles; ?></span></a>
<!--Se crea tabla con todas las columnas a mostrar-->
<table class="tabla-inmueble" >
    <thead>
        <tr>
            <th>Codigo Catastral</th>
            <th>Direccion</th>
            <th>Número de Apto</th>
            <th>Arrendatarios</th>
            <th>Precio</th>
            <th>Estrato</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                echo "<tr>";
                echo "<td>" . $row['Codigo_catastral'] . "</td>";
                echo "<td>" . $row['Direccion'] . "</td>";
                echo "<td>" . $row['Nviviendas'] . "</td>";
                echo "<td>" . $row['Arrendatarios'] . "</td>";
                echo "<td>" . $row['Precio'] . "</td>";
                echo "<td>" . $row['Estrato'] . "</td>";
                echo "<td>";
                echo "<div class='action-buttons'>";
                echo "<a href='editar.php?Codigo_catastral=" . $row['Codigo_catastral'] . "' class='btn btn-primary'><i class='fas fa-edit'></i></a>";
                echo "<form method='POST' action='inmueble.php' onsubmit='return confirmDelete();'>";
                echo "<input type='hidden' name='Codigo_catastral_a_borrar' value='" . $row['Codigo_catastral'] . "'>";
                echo "<button class='btn btn-danger' type='submit' name='borrar'><i class='fas fa-trash-alt'></i></button>";           
                echo "</form>";
                echo "</div>";
                echo "</td>";       
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No se encontraron inmuebles para este código catastral o usuario.</td></tr>";
        }
        ?>
    </tbody>
</table>
    </div>
</body>
</html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../modelo/javascript/notificaciones.js"></script>
<script>
    // Tiempo de inactividad en milisegundos (1 minuto)
    var inactivityTime = 1 * 60 * 1000; // 1 minuto en milisegundos

    var timeout;
    var warningTimeout;

    function startTimer() {
        timeout = setTimeout(showLogoutWarning, inactivityTime - 10000); // Mostrar advertencia 10 segundos antes de cerrar la sesión
    }

    function resetTimer() {
        clearTimeout(timeout);
        clearTimeout(warningTimeout);
        startTimer();
    }

    function logoutUser() {
        window.location.href = "../controlador/logout.php?logout_id=<?php echo $id_usuario; ?>"; // Redirigir a la página de cierre de sesión
    }

    function showLogoutWarning() {
        Swal.fire({
            title: 'Tu sesión está a punto de cerrarse',
            text: 'Debido a la inactividad, tu sesión se cerrará automáticamente en breve. ¿Deseas continuar en la sesión?',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonText: 'Continuar en la sesión',
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 10000, // Tiempo límite para la interacción del usuario (10 segundos)
            timerProgressBar: true,
            willClose: () => {
                if (Swal.getTimerLeft() === 0) {
                    logoutUser(); // Cerrar sesión si el usuario no hace nada
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario elige continuar, reiniciar el temporizador y no cerrar la sesión
                resetTimer();
            }
        });

        // Establecer un timeout adicional para cerrar sesión si el usuario no interactúa con el diálogo
        warningTimeout = setTimeout(logoutUser, 10000);
    }

    // Iniciar el temporizador cuando se carga la página
    $(document).ready(function() {
        startTimer();
    });

    // Reiniciar el temporizador en la actividad del usuario
    $(document).mousemove(function() {
        resetTimer();
    });

    $(document).keypress(function() {
        resetTimer();
    });
</script>
