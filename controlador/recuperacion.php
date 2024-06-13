<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../modelo/conexion.php');
require '../modelo/PHPMailer/Exception.php';
require '../modelo/PHPMailer/PHPMailer.php';
require '../modelo/PHPMailer/SMTP.php';
$email = $_POST['email'];
$query = "SELECT * FROM usuarios WHERE email = '$email' AND status = 1";
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp-mail.outlook.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'rentware@hotmail.com';
    $mail->Password   = 'Chessmove';
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom('rentware@hotmail.com', 'Rentware');
    $mail->addAddress($email, 'Recuperacion de contraseña');

    $mail->isHTML(true);
$mail->Subject = 'Recuperacion de tu Clave Rentware';
$mail->Body = file_get_contents('../vista/plantilla.html');

$mail->Body = str_replace('{enlace}', '<a href="http://localhost/rentware/vista/nueva_contrase%C3%B1a.php">haz click aquí</a>', $mail->Body);
if ($mail->send()) {
    echo "<script>document.addEventListener('DOMContentLoaded', function() { document.getElementById('messageContainer').style.display = 'block'; document.getElementById('messageContainer').innerHTML = '<p>El correo ha sido enviado exitosamente.</p>'; });</script>";
} else {
    echo "<script>document.addEventListener('DOMContentLoaded', function() { document.getElementById('messageContainer').style.display = 'block'; document.getElementById('messageContainer').innerHTML = '<p>Error al enviar el correo.</p>'; });</script>";
}

    header('Location: ../vista/confirmacion_correo.html');

} catch (Exception $e) {
    echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
}
?>