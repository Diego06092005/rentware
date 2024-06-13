<?php
include "modelo/conexion.php"; 
// Consulta para obtener los arrendadores
$arrendadoresQuery = "SELECT id, nombres, apellidos FROM usuarios WHERE id_cargo = 1";
$arrendadoresResult = mysqli_query($mysqli, $arrendadoresQuery);
$arrendadores = [];
if ($arrendadoresResult && mysqli_num_rows($arrendadoresResult) > 0) {
    while ($row = mysqli_fetch_assoc($arrendadoresResult)) {
        $arrendadores[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
     <!--inicio de header, donde estan algunos links-->
<head>
 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with FoodHut landing page.">
    <meta name="author" content="Devcrud">
    <title>Rent ware</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="Website Icon" type="png" href="vista/IMG/rent2.png">
    <!-- font icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="modelo/assets/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="modelo/assets/vendors/animate/animate.css">
	  <link rel="stylesheet" href="modelo/assets/css/rent.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link rel="stylesheet" href="modelo/css/style_index.css">
    <link rel="stylesheet" href="modelo/CSS/login.css">
    <!-- #region -->
    <script src="modelo/javascript/script_index.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- script para el boton de subir (flecha) -->
<script src="modelo/assets/vendor/typed.js/typed.umd.js"></script>
<script src="modelo/assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="modelo/assets/vendor/php-email-form/validate.js"></script>
<script src="modelo/assets/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
 <!--inicio cuerpo de pagina -->
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
  <div class="preloader">
    <img src="vista/IMG/renwargif.gif" alt="Loading...">
  </div>
    <!-- Navbar opciones, home, Inicia, Registarte, acerca de nosostros -->
    <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Inicia o registrate</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./vista/informacion_inicio.html">Acerca de nosotros</a>
                </li>
            </ul>
            <a class="navbar-brand m-auto" href="#">
                <img src="vista/IMG/logo2.png" class="brand-img" alt="">
                <span class="brand-txt">Rent-Ware</span>
            </a>   
        </div>
  
    </nav>
    <!-- HOME debajo del logo rent-ware -->
    <header id="home" class="header">
        <div class="overlay text-white text-center">
        <div class="logo-container">
         <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
        </section>
        <img src="vista/IMG/logo2.png" alt="Logo" class="logo">
      </div>
      <div class="hero-container" data-aos="fade-in" style="font-size: 30px;">
      <p><i class="fas fa-home" style="color:red;"></i> Es <span class="typed" data-typed-items="Orden., Tranquilidad., Confiable., Seguridad." style="font-size: 30px;"></span></p>
      </div>
        </div>
    </header>
    <!--  inicio Section -->
    <div id="about" class="container-fluid bg-dark2  fadeIn" id="about"data-wow-duration="1.5s">
 <div class="row">  
    <section class="principal">
        <div class="animacion"> 
            <div class="entrar">
            <div class="rectangulo">
              <br> <br>
            <img src="vista/IMG/logo2.png" alt="Logo" class="logorent"> 
                <h1>«B I E N V E N I D O»</h1>
                <p>
                 "Recuerda verificar tu información de acceso antes de ingresar. Si tienes problemas para iniciar sesión, no dudes en utilizar la opción de recuperación de contraseña o contactarnos para asistencia. Tu seguridad y privacidad son importantes para nosotros."</p>
           <br><br><br><br><br>
          <p> <b> ¿Aun no tienes una cuenta?</b></p>
        <a href="#" onclick="toggleView(event)" class="animate__animated animate__pulse animate__infinite">Regístrate ❯</a>
 </div>
 </div>
        <div class="register">
        <div class="rectangulo">
          <br><br>
            <img src="vista/IMG/logo2.png" alt="Logo" class="logorent"> 
                <h1>¡H O L A!</h1>
                <p>
                 "Para tu seguridad, te recomendamos crear una contraseña fuerte, única para este sitio. Combina mayúsculas, minúsculas, números y símbolos, y evita palabras o fechas comunes. ¡Tu seguridad es nuestra prioridad!"</p>
                 <br><br><br><br><br><br>
                   <p><b>¿Ya tienes una cuenta?</b></p>        
                 <a href="#" onclick="toggleView(event)" class="animate__animated animate__pulse animate__infinite">❮ Inicia</a>
            </div>
        </div>
        </div>
        <div class="login">
    <form onsubmit="mostrarLoading()" action="controlador/validar.php" method="post" style="animation: animate__animated animate__backInLeft 1s;">    
        <div class="logo-container" style="text-align: center; margin-bottom: 20px;">
        <div id="mensaje-error" style="display:none; color: red;">
        <strong style="color:black;">Cédula o contraseña incorrecta. Por favor, intenta de nuevo.</strong>
        </div>
            <h2>I N I C I A R</h2>
            <img src="vista/IMG/logo2.png" alt="Logo" class="logo" style="max-width: 150px;">
        </div>
        <input type="number" placeholder="Cédula" name="usuario" id="usuario" maxlength="10" min="999999" required><!-- Cambiado el placeholder a "Cédula" -->
        <div style="position: relative;">
        <input type="password" placeholder="Contraseña" name="contraseña" id="contraseña" required>
            <span onclick="togglePassword()" style="position: absolute; right: 70px; top: 50%; transform: translateY(-50%); cursor: pointer; background: transparent; border: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="color: red;">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.88 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.215.31-.441.608-.688.897-.956 1.118-2.319 2.103-4.14 2.103s-3.184-.985-4.14-2.103A13.556 13.556 0 0 1 1.173 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                </svg>
            </span>
     </div>
        <a href="vista/recuperar_contraseña.php" style="font-size: medium; color: red; display: block; margin-top: 10px;">¿Olvidaste tu contraseña?</a>
        <div class="field input">
        <input type="hidden" name="status" value="En línea">
        </div>
        <button type="submit" class="animate__animated animate__headShake animate__infinite" style="margin-top: 20px;">E N T R A R ❯</button>
       </form>
    </div>
        <div class="singup">
        <form action="controlador/register.php" method="post" enctype="multipart/form-data">
                <h2 style="color:rgb(255, 12, 12);">R E G I S T R A T E</h2>
       <div class="wrapper">
    <section class="form signup">
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="name-details">
          <div class="field input">
            <input type="text" name="nombres" placeholder="Nombre" required>    
          <div class="field input">
            <input type="text" name="apellidos" placeholder="Apellido" required>
          </div>       
          <div class="field input">
    <input type="number" name="cedula" placeholder="Cédula de Identidad" maxlength="10" min="999999" required>
</div>
        <div class="field input">
          <input type="email" name="email" placeholder="tucorreo@correo.com" required>
        </div>     
        <div class="field input">
          <input type="password" name="password" id="password" placeholder="Ingresa tu contraseña" required>
        </div>
        <div class="field input">
       <input type="number" name="telefono" placeholder="Número de teléfono" maxlength="10" min="2999999999" required>
        </div>
        <div class="field input">
    <label>Fecha de Nacimiento</label>
    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" required>      
    </div>
    <div class="field input">
    <select name="id_cargo" id="id_cargo" required>
        <option value=""disabled selected>Seleccionar Rol (Ej:arrendador o arrendatario)</option>
        <option value="1">Arrendador</option>
        <option value="2">Arrendatario</option>
    </select>
 </div>
 <div class="custom-select-container mb-3" id="arrendador_select" style="display: none;">
    <select name="id_arrendador" required>
        <option value="">(Selecciona tu arrendador)</option>
        <?php foreach ($arrendadores as $arrendador): ?>
            <option value="<?= htmlspecialchars($arrendador['id']) ?>"><?= htmlspecialchars($arrendador['nombres']) . ' ' . htmlspecialchars($arrendador['apellidos']) ?></option>
        <?php endforeach; ?>
    </select>
 </div>
 </div>
<br>
 <div class="containerimg">
  <input type="file" class="form-control-file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
  <span class="file-name"></span>
</div>
        <div class="field input">
        <input type="hidden" name="status" value="Desconectado">
        </div>
                <br><br><br>
                <!-- Botón de Envío -->
                <button type="submit">R E G I S T R A R</button>
            </form>
        </div>
    </section>
 </div>
 </div>
 </div>
<footer class="footer" id="book-table">
    <div class="item" data-text="Somos una organización comprometida con la simplificación y eficiencia en la gestión de arriendos, esto nos ha llevado a desarrollar Rent-Ware, un software especializado diseñado para facilitar el control de arriendos de manera intuitiva y eficaz.Buscamos transformar la manera en que se administran los procesos de arrendamiento.">Acerca de</div>
    <div class="item" data-text="Nuestra misión es ofrecer a propietarios, arrendadores y arrendatarios una plataforma integral, Rent-Ware, que simplifique la gestión de arriendos mediante un software de vanguardia. Nos esforzamos por proporcionar soluciones ágiles, seguras y fáciles de usar, optimizando el control y la administración de propiedades, promoviendo así relaciones de arrendamiento sólidas y transparentes">Misión</div>
    <div class="item" data-text="Nos visualizamos como líderes en la innovación tecnológica para la gestión de arriendos a nivel global. Buscamos ser reconocidos por nuestra excelencia en ofrecer herramientas que revolucionen y optimicen la experiencia de arrendamiento, permitiendo a propietarios y arrendatarios interactuar de manera eficiente y confiable en un entorno digital seguro y accesible">Visión</div>
    <div class="item full-row">
            <div class="row">
              <div class="col-sm-4">
                <h3><i class="fas fa-envelope"></i> EMAIL</h3>
                <p class="text-muted">rentware@hotmail.com</p>
              </div>
              <div class="col-sm-4">
                <h3><i class="fas fa-phone"></i> Llámanos</h3>
                <p class="text-muted">+57 324 586 2613</p>
              </div>
              <div class="col-sm-4">
                <h3><i class="fas fa-map-marker-alt"></i> Ubícanos</h3>
                <p class="text-muted">Cra 89 45-434</p>
              </div>
          </div>
    </div>
  </footer>
     <div class="bg-dark text-light text-center border-top wow fadeIn">
        <p>Rent-Ware</p>
    </div>    <!-- end of page footer -->
	<!-- core  -->
    <script src="modelo/assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="modelo/assets/vendors/bootstrap/bootstrap.bundle.js"></script>
    <!-- bootstrap affix -->
    <script src="modelo/assets/vendors/bootstrap/bootstrap.affix.js"></script>
    <!-- wow.js -->
    <script src="modelo/assets/vendors/wow/wow.js"></script>
    <!--  js -->
    <script src="modelo/assets/js/rent.js"></script>
  <!-- volver arriba seccion  -->
  <a href="#" class="btn btn-lg btn-primary" id="rounded-btn"><i class="fas fa-arrow-up"></i></a>
  <!-- fin arriba seccion  -->  
</body> <!-- FIN cuerpo de pagina -->
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- script para el boton de subir (flecha) -->
<script src="modelo/assets/vendor/typed.js/typed.umd.js"></script>
<script src="modelo/assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="modelo/assets/vendor/php-email-form/validate.js"></script>
<script src="modelo/assets/js/main.js"></script>
<script src="modelo/javascript/script_index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>