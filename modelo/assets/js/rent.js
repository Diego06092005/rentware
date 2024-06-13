
// smooth scroll
$(document).ready(function(){
    $(".navbar .nav-link").on('click', function(event) {

        if (this.hash !== "") {

            event.preventDefault();

            var hash = this.hash;

            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 700, function(){
                window.location.hash = hash;
            });
        } 
    });
});

new WOW().init();

//INICIO DE JS RENTWARE
 document.getElementById('id_cargo').addEventListener('change', function() {
    var value = this.value;
    var arrendadorSelect = document.getElementById('arrendador_select');
    var arrendadorSelectInput = arrendadorSelect.querySelector('select');

    if (value == '2') { // Si el valor es 2 (Arrendatario), muestra el segundo select y lo hace requerido
        arrendadorSelect.style.display = 'block';
        arrendadorSelectInput.required = true;
    } else { // De lo contrario, ocúltalo y quita el atributo requerido
        arrendadorSelect.style.display = 'none';
        arrendadorSelectInput.required = false;
    }
 });

   //script para el error de credenciales-->

    document.addEventListener("DOMContentLoaded", function() {
    const items = document.querySelectorAll('.item');
    items.forEach(item => {
      const defaultText = item.textContent.trim(); // Guardar el texto original sin espacios al inicio o final
      if (!item.classList.contains('full-row')) {
        item.addEventListener('mouseenter', function() {
          const text = this.getAttribute('data-text');
          this.textContent = text;
        });
        item.addEventListener('mouseleave', function() {
          this.textContent = defaultText;
        });
      }
    });
  });
 document.addEventListener('DOMContentLoaded', (event) => {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');

    if(error === 'login') {
        const mensajeError = document.getElementById('mensaje-error');
        mensajeError.style.display = 'block';
    }
 });

 
 document.addEventListener("DOMContentLoaded", function() {
    const inputFile = document.querySelector('.containerimg input[type="file"]');
    const fileNameDisplay = document.querySelector('.containerimg .file-name');
    inputFile.addEventListener('change', function(e) {
      const fileName = e.target.files[0].name; // Obtiene el nombre del archivo
      const trimmedFileName = fileName.length > 10 ? fileName.substring(0, 10) + '...' : fileName; // Recorta a los primeros 10 caracteres
      fileNameDisplay.textContent = trimmedFileName || 'Sube tu Imagen de perfil'; // Actualiza el texto o vuelve al predeterminado si no hay archivo
    });
   });
      document.getElementById("fecha_nacimiento").addEventListener("input", function() {
          // Obtener el valor actual del campo de fecha
          var fecha = this.value;
          // Verificar si la longitud del año es mayor que 8
          if (fecha.length > 10) {
              // Cortar la fecha para incluir solo los primeros 8 caracteres (año)
              this.value = fecha.substring(0, 10);
          }
      });
      
    document.getElementById("fecha_nacimiento").addEventListener("input", function() {
        // Obtener el valor actual del campo de fecha
        var year = this.value;

        // Verificar si la longitud del año es mayor que 8
        if (fecha.length > 10) {
            // Cortar la fecha para incluir solo los primeros 8 caracteres (año)
            this.value = fecha.substring(0, 10);
        }
    });
 document.querySelectorAll('input[type="number"]').forEach(input =>{
  input.oninput = () =>{
    if(input.value.length > input.maxLength) input.value = input.value = input.value.slice(0, input.maxLength);
  };
 }); 
    document.addEventListener("DOMContentLoaded", function() {
    // Obtener el campo de fecha de nacimiento
    const fechaNacimientoInput = document.getElementById("fecha_nacimiento");
    // Agregar evento 'input' para detectar cambios en la fecha
    fechaNacimientoInput.addEventListener("input", function() {
        // Obtener la fecha seleccionada
        const fechaSeleccionada = new Date(this.value);   
        // Obtener la fecha actual
        const fechaActual = new Date();
        // Calcular la fecha que representa hace 18 años desde la fecha actual
        const fechaHace18Años = new Date(fechaActual.getFullYear() - 18, fechaActual.getMonth(), fechaActual.getDate());
        // Verificar si la fecha seleccionada es posterior a la fecha que representa hace 18 años
        if (fechaSeleccionada > fechaHace18Años) {
    // Mostrar mensaje de error con SweetAlert
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Debes ser mayor de 18 años para registrarte.",
    });
    // Limpiar el valor del campo de fecha
    this.value = "";
 }
    });
 });
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener el campo de fecha de nacimiento
        const fechaNacimientoInput = document.getElementById("fecha_nacimiento");

        // Agregar evento 'input' para detectar cambios en la fecha
        fechaNacimientoInput.addEventListener("input", function() {
            // Obtener la fecha seleccionada
            const fechaSeleccionada = new Date(this.value);
            
            // Obtener la fecha actual
            const fechaActual = new Date();

            // Calcular la edad
            const edad = fechaActual.getFullYear() - fechaSeleccionada.getFullYear();

            // Verificar si el usuario tiene menos de 18 años
            if (edad < 18) {
                // Mostrar mensaje de error
                alert("Debes ser mayor de 18 años para registrarte.");
                // Limpiar el valor del campo de fecha
                this.value = "";
            }
        });
    });

  document.addEventListener("DOMContentLoaded", function() {
  // Ocultar el preloader después de un tiempo de espera simulado (puedes ajustar el tiempo)
  setTimeout(function() {
    document.querySelector(".preloader").style.display = "none";
  }, 2000); // 2000 milisegundos = 2 segundos (ajusta según necesites)
 });