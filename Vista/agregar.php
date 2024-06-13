<?php
include ("../controlador/agregar_inmueble.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Registro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="Website Icon" type="png" href="../vista/IMG/rent2.png">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../modelo/assets/css/agregar.css">

</head>
<body>
    <div class="custom-container">
        <div class="barra-gris">
        <h2 class="mb-4" style="display: flex; align-items: center; justify-content: center;">
        <a class="navbar-brand" href="inmueble.php" style="margin-right: 10px;">
            <i class="ri-arrow-left-s-line ri-3x"></i>
        </a>
        <span style="text-align:center;">➕Agregar inmueble🏠</span>
    </h2>
    </div>
    <!--Creacion tabla -->
        <table class="table table-dark table-striped">
            <!--Envio del post. con vinculo al php que se encuentra en controlador/agregar_inmueble-->
        <form method="POST" action="../controlador/agregar_inmueble.php">
    <tr><!--Codigo catastral que es unico. tipo text y con 15 digitos como maximo-->
        <td><label for="Codigo_catastral">Codigo Catastral:</label></td>
        <td><input type="text" name="Codigo_catastral" maxlength="15" required></td>
    </tr>
    <tr><!--Apartado de direccion con un maximo de 20 caracteres-->
        <td><label for="Direccion">Direccion:</label></td>
        <td><input type="text" name="Direccion" maxlength="20" required></td>
    </tr>
    <tr><!--Numerod de apartamento en el que se encuentra el inmueble arrendado-->
        <td><label for="Nviviendas">Número de apartamento:</label></td>
        <td><!--Casilla dodne se ponen los parametros como el cual solo tiene que ser numero y un maximo de 3 digitos-->
        <input type="number" name="Nviviendas" maxlength="3">
        <span id="mensajeError" style="color: white; display: flex;">Si no clasifica. Deja el campo vacio</span>
        </td>
    </tr>
    <tr><!--Apartado de arrendatarios-->
        <td><label for="Arrendatarios">Elige un Arrendatario:</label></td>
        <td>
        <div class="tooltip-container">
        <select class="form-select custom-select-gray" name="Arrendatarios" required>
        <option value="" disabled selected>Desplegar para seleccionar</option>
        <option value="No ocupado">No ocupado</option>
           <!-- Opción "No ocupado" seleccionada por defecto -->
           <?php
           // Consulta para obtener la lista de arrendatarios
           $consulta_arrendatarios = "SELECT aren_nombre, aren_apellido FROM arrendatario";
           $resultado_arrendatarios = $mysqli->query($consulta_arrendatarios);
           if ($resultado_arrendatarios->num_rows > 0) {
           while ($fila_arrendatario = $resultado_arrendatarios->fetch_assoc()) {
           echo '<option value="' . $fila_arrendatario['aren_nombre'] . ' ' . $fila_arrendatario['aren_apellido'] . '">' . $fila_arrendatario['aren_nombre'] . ' ' . $fila_arrendatario['aren_apellido'] . '</option>';
           }
           } else {
           echo '<option value="" disabled>No hay arrendatarios registrados</option>'; // Si no hay arrendatarios registrados, se deshabilita la opción
           }
           ?>
          </select>
          <!--Aviso flotante en arrendatario-->
          <span class="custom-tooltip">Elige un arrendatario para asignarle un inmueble o selecciona "No ocupado" para dejarlo libre.</span>
        </div>
        </td>
    <tr><!--Precio del inmueble-->
        <td><label for="Precio">Precio:</label></td>
        <td><input type="number" name="Precio" maxlength="8" required></td>
    </tr>
    <tr>
        <td><!--Estrato del inmueble-->
        <label for="Estrato">Estrato:</label></td>
        <td>
        <!--Menu desplegable seleccion de estrato del inmueble-->
        <div class="tooltip-container">
            <select class="form-select custom-select-gray" id="Estrato" name="Estrato" required>
            <option value="" disabled selected>Selecciona el estrato</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            </select>
        </div>
       </td>
    </tr>
    <tr>
        <td colspan="2">
        <input type="submit" value="💾Guardar" class="btn btn-primary">
        </td>
    </tr>
        </form>
        </table>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const exito = urlParams.get('exito');
    if (exito === 'true') {
        Swal.fire({
            icon: 'success',
            title: '¡Inmueble agregado!',
            text: 'El nuevo inmueble se ha agregado correctamente.',
        }).then((result) => {
                // Redirige a otra página después de cerrar la alerta
                if (result.isConfirmed) {
                    window.location.href = '../vista/inmueble.php'; // Cambia 'otra_pagina.html' por la URL a la que quieras redirigir
                }
            });
        }

    // Función para validar la longitud del input number


    document.querySelectorAll('input[type="number"]').forEach(input =>{
        input.oninput = () =>{
            if(input.value.length > input.maxLength) input.value = input.value.slice(0, input.maxLength);
        };
    })

    
</script>
