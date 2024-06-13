<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Anuncio</title>
    <link rel="icon" type="image/png" href="../vista/IMG/rent2.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../modelo/assets/css/editarAnuncio.css">
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rentware";
// Crear una nueva instancia de conexión mysqli
$mysqli = new mysqli($servername, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
if (isset($_GET['id'])) {
    $id_anuncio = $_GET['id'];
    // Comprobar si el formulario ha sido enviado y el botón update ha sido presionado
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        // consulta para actualizar los datos del anuncio
        $sql_update = "UPDATE anuncios SET titulo = ?, contenido = ? WHERE id = ?";
        $stmt_update = $mysqli->prepare($sql_update);
        $stmt_update->bind_param("ssi", $titulo, $contenido, $id_anuncio);
        if ($stmt_update->execute()) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Perfecto!',
                    text: 'Se ha actualizado el anuncio.',
                    icon: 'success',
                    confirmButtonText: 'Volver'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'gestion_anuncios.php';
                    }
                });
            });
        </script>";
        } else {
            echo "<p>Error al actualizar el anuncio.</p>";
        }
        $stmt_update->close();
    }
    // consulta para obtener los datos actuales del anuncio
    $sql = "SELECT titulo, contenido FROM anuncios WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id_anuncio);
    $stmt->execute();
    $result = $stmt->get_result();
    $anuncio = $result->fetch_assoc();
} else {
    header("Location: gestion_anuncios.php");
    exit;
}
?>
<form method="post">
    <div class="container">
        <div class="row">
            <div class="col s1">
                <a href="gestion_anuncios.php" class="btn waves-effect waves-light">
                    <i class="material-icons">arrow_back</i>
                </a><h1>Editar Anuncio</h1>
            </div>
        </div>
    </div>
    <hr>
    <br>
    <!-- Campo para editar el anuncio -->
    <label for="titulo"><strong>Título:</strong></label>
    <input type="text" name="titulo" id="titulo" required value="<?= htmlspecialchars($anuncio['titulo']) ?>">
    <label for="contenido"><strong> Contenido:</strong></label>
    <textarea name="contenido" id="contenido" required rows="5"><?= htmlspecialchars($anuncio['contenido']) ?></textarea>
    <br>
    <center><input type="submit" name="update" value="Actualizar"></center>
</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
<?php
$stmt->close();
$mysqli->close();
?>
