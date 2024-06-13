<?php

include ("../controlador/update_inmueble.php");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    
    <link rel="Website Icon" type="png" href="../vista/IMG/rent2.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../modelo/assets/css/editar.css">
</head>
<body>
<br><br>
<table style="margin: 0 auto; width: auto; background-color: black; color: white; padding: 20px; border-radius:10px;">       
    <tr>
        <td>
            <div class="container">              
                <h1 style="margin-left: 10px;"> <a class="navbar-brand" href="inmueble.php" style="text-decoration: none;">
                <i class="ri-arrow-left-s-line ri-3x"></i>
                <!--formulario para editar el registro-->
                </a>🛠️Editar Registro🏠</h1>
                <hr style="border-top: 1px solid gray;">
                <form method="POST" action="editar.php">
            <div class="row">
            <div class="col-sm-6">
                <!--campo direccion -->
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="Direccion" value="<?php echo $row['Direccion']; ?>" required style="background-color: #333; color: white; border: 1px solid #555;">
            </div>
                <hr style="border-top: 1px solid gray;">                    
            </div>
                <hr style="border-top: 1px solid gray;">
            <div class="row">
            <div class="col-sm-6">
                <label for="num_viviendas">Número de Apto:</label>
                <input type="number" class="form-control" id="num_viviendas" name="Nviviendas" maxlength="3" value="<?php echo $row['Nviviendas']; ?>" required style="background-color: #333; color: white; border: 1px solid #555;">
            </div>
                <hr style="border-top: 1px solid gray;">
            <div class="col-sm-6">
                <label for="arrendatario">Arrendatario:</label>
                <select class="form-control" id="arrendatario" name="arrendatario" required style="background-color: #333; color: white; border: 1px solid #555;">
                <option value="" disabled selected>Selecciona arrendatario</option>
                <option value="No ocupado">No ocupado</option>
                <!--opcion donde nos permitira traer los arrendatarios que estan relacionados al arrendador -->
                <?php foreach ($arrendatarios as $arrendatario): ?>
                    <option value="<?= htmlspecialchars($arrendatario['aren_nombre'] . ' ' . $arrendatario['aren_apellido']) ?>">
                        <?= htmlspecialchars($arrendatario['aren_nombre']) . ' ' . htmlspecialchars($arrendatario['aren_apellido']) ?>
                    </option>
                <?php endforeach; ?>
               </select>
            </div>
            </div>
                <hr style="border-top: 1px solid gray;">
            <div class="row">
            <div class="col-sm-6">
                <label for="Precio">Precio:</label>
                <input type="number" class="form-control" id="Precio" name="Precio" maxlength="8" value="<?php echo $row['Precio']; ?>" required style="background-color: #333; color: white; border: 1px solid #555;">
            </div>
                <hr style="border-top: 1px solid gray;">
            <div class="col-sm-6">
                <label for="Estrato">Estrato:</label>
                <select class="form-control" id="Estrato" name="Estrato" required style="background-color: #333; color: white; border: 1px solid #555;">
                <option value="" disabled selected>Selecciona el estrato</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                </select>
            </div>
            </div>
                 <input type="hidden" name="Codigo_catastral" value="<?php echo $row['Codigo_catastral']; ?>">
            <div class="text-center">
                <br>
                <input type="submit" class="btn btn-primary" value="💾Guardar">
                <br><br>
                </div>
                </form>
            </div>
        </td>
    </tr>
</table>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
<script>   

 document.querySelectorAll('input[type="number"]').forEach(input =>{
        input.oninput = () =>{
            if(input.value.length > input.maxLength) input.value = input.value.slice(0, input.maxLength);
        };
    })
</script>