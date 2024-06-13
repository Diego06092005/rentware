<?php session_start(); ?>
<!DOCTYPE html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuncio Creado</title>
    <link rel="stylesheet" href="path/to/your/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="../modelo/assets/css/anuncio_creado.css">
</head>
<body>

    <script>
        // Función para mostrar la alerta y redirigir automáticamente
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "¡Excelente!",
                text: "Ha sido exitosa la creación del anuncio.",
                icon: "success",
                confirmButtonText: "Volver"
            }).then((result) => {
                // Verificar si el usuario dio clic en el botón "OK"
                if (result.isConfirmed) {
                    window.location.href = 'crearAnuncio.php';
                }
            });
        });
    </script>

    <script src="path/to/your/js/bootstrap.bundle.min.js"></script> 
</body>
</html>