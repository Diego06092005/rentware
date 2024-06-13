$(document).ready(function() {
    // Mostrar el botón después de desplazar cierta distancia
    $(window).scroll(function() {
      if ($(this).scrollTop() > 100) { // Cambia 100 a la distancia deseada para mostrar el botón
        $('#rounded-btn').fadeIn();
      } else {
        $('#rounded-btn').fadeOut();
      }
    });
    // Desplazamiento suave al hacer clic en el botón
    $('#rounded-btn').click(function(e) {
      e.preventDefault();
      $('html, body').animate({ scrollTop: 0 }, 'slow');
      return false;
    });
  });
 document.getElementById('custom-button').addEventListener('click', function () {
document.getElementById('actual-btn').click();
});
document.getElementById('actual-btn').addEventListener('change', function () {
var fileName = document.getElementById('actual-btn').files[0].name;
document.getElementById('file-chosen').textContent = fileName;
});
// Aquí el código JavaScript para togglePassword
      function togglePassword() {
          var x = document.getElementById("contraseña");
          if (x.type === "password") {
              x.type = "text";
          } else {
              x.type = "password";
          }
      }
      
      function mostrarLoading() {
          document.getElementById('loading').style.display = 'block';
      }
function toggleView(event) {
  // Prevenir el comportamiento predeterminado del evento
  if (event) event.preventDefault();
  const animacion = document.querySelector('.animacion');
  const entrarTexto = animacion.querySelector('.entrar');
  const registroTexto = animacion.querySelector('.register');
  // Verifica si la animación ya tiene la clase 'left'
  if (animacion.classList.contains('left')) {
      animacion.classList.remove('left');
      entrarTexto.style.display = "block";
      registroTexto.style.display = "none";
  } else {
      animacion.classList.add('left');
      entrarTexto.style.display = "none";
      registroTexto.style.display = "block";
  }
}
function togglePassword() {
    var passwordField = document.getElementById('contraseña');
    var icon = document.querySelector('.input-group-text svg');
    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      icon.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16" style="color: red;">
          <path d="M.5 8a7.5 7.5 0 0 1 15 0A7.5 7.5 0 0 1 .5 8zm8-6a9.5 9.5 0 0 0-8 8a9.5 9.5 0 0 0 8 8a9.5 9.5 0 0 0 8-8a9.5 9.5 0 0 0-8-8zm0 13a4.975 4.975 0 0 1-3.742-1.715A.75.75 0 0 1 5.282 10l5.525-5.525a.75.75 0 0 1 1.061 1.06L6.344 10l3.697 3.697a.75.75 0 1 1-1.06 1.061L5.28 11.06a4.975 4.975 0 0 1-1.18 1.654A4.962 4.962 0 0 1 8 15z"/>
        </svg>`;
    } else {
      passwordField.type = 'password';
      icon.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" style="color: red;">
          <path d="M8 4a3.5 3.5 0 0 0-2.473 5.973l1.482-1.482A2 2 0 0 1 8 6a2 2 0 0 1 1.932 1.46l1.482 1.482A3.5 3.5 0 0 0 8 4zm8 5a1 1 0 0 1-1 1c-2.981-.002-5.478-1.989-6.768-3a3 3 0 0 1 0-2c1.29-1.011 3.787-2.998 6.768-3a1 1 0 0 1 1 1c-.835.731-2.657 2.745-4 4a6.93 6.93 0 0 0-1.607 3.435A6.978 6.978 0 0 0 8 14a6.978 6.978 0 0 0 5.607-2.565A6.93 6.93 0 0 0 16 9zM1.053 8a23.7 23.7 0 0 1 2.408-3.072C4.418 3.649 6.48 2.305 8 2c1.52.305 3.582 1.649 4.539 2.928A23.7 23.7 0 0 1 14.947 8a23.7 23.7 0 0 1-2.408 3.072C11.582 12.351 9.52 13.695 8 14c-1.52-.305-3.582-1.649-4.539-2.928A23.7 23.7 0 0 1 1.053 8z"/>
        </svg>`;
    }
  }
  document.querySelectorAll('input[type="number"]').forEach(input =>{
    input.oninput = () =>{
      if(input.value.length > input.maxLength) input.value = input.value = input.value.slice(0, input.maxLength);
    };
  }); 

