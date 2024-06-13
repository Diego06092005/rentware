 // Define la función toggleMenu que se utiliza para mostrar u ocultar elementos del menú.
 function toggleMenu() {
    // Busca el elemento con la clase 'menu-content' dentro del documento.
    const menuContent = document.querySelector('.menu-content');
    // Cambia el estilo de display dependiendo de su estado actual.
    // Si está oculto (display = 'none'), lo cambia a visible (display = 'block'), y viceversa.
    menuContent.style.display = menuContent.style.display === 'none' ? 'block' : 'none';
  }
  // Agrega un listener para el evento 'DOMContentLoaded', que se dispara cuando el DOM está completamente cargado.
  document.addEventListener('DOMContentLoaded', function () {
    // Obtiene el formulario por su ID para poder manipularlo más tarde.
    const form = document.getElementById('action-form');
    // Agrega un listener para el click en el botón 'vaciar-chat-btn'.
    document.getElementById('vaciar-chat-btn').addEventListener('click', function() {
      // Lanza una ventana de alerta con SweetAlert para confirmar la acción de vaciar el chat.
      Swal.fire({
        title: '¿Estás seguro?', // Título de la ventana.
        text: "No podrás revertir esta acción de vaciar el chat.", // Texto de la ventana.
        icon: 'warning', // Icono de advertencia.
        showCancelButton: true, // Muestra un botón para cancelar la acción.
        confirmButtonColor: '#3085d6', // Color del botón de confirmar.
        cancelButtonColor: '#d33', // Color del botón de cancelar.
        confirmButtonText: 'Sí, vaciar!' // Texto del botón de confirmar.
      }).then((result) => {
        if (result.isConfirmed) {
          // Si la acción es confirmada, crea un input oculto.
          const input = document.createElement('input');
          input.type = 'hidden'; // Tipo oculto para que no sea visible en el formulario.
          input.name = 'vaciar_chat'; // Nombre del input para identificarlo en el servidor.
          form.appendChild(input); // Añade el input al formulario.
          form.submit(); // Envía el formulario.
        }
      });
    });
    // Repite un proceso similar para el botón 'eliminar-chat-btn'.
    document.getElementById('eliminar-chat-btn').addEventListener('click', function() {
      // Lanza una ventana de alerta con SweetAlert para confirmar la acción de eliminar el usuario y sus mensajes.
      Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminará a este usuario del sistema y todos los mensajes relacionados permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!'
      }).then((result) => {
        if (result.isConfirmed) {
          // Crea un input oculto para identificar la acción en el servidor.
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'eliminar_chat';
          form.appendChild(input); // Añade el input al formulario.
          form.submit(); // Envía el formulario.
        }
      });
    });
  });