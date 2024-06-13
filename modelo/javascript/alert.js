// Agregue un event listener al elemento con id 'empty-chat' que se activa al hacer clic
document.getElementById('empty-chat').addEventListener('click', function() {
    // SweetAlert2 para mostrar una ventana de confirmación
    Swal.fire({
      title: '¿Estás seguro?',
      text: "¿Quieres vaciar la conversación? Esta acción no se puede deshacer.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, vaciar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      // Si el usuario confirma la acción
      if (result.isConfirmed) {
        // Crea un objeto FormData para enviar datos al servidor
        const formData = new FormData();
        formData.append('incoming_id', document.querySelector('.incoming_id').value); // El ID del usuario con quien se está chateando
        // Realiza una solicitud fetch al archivo empty_conversation.php
        fetch('../controlador/empty_conversation.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(result => {
          // Si la solicitud es exitosa
          if (result === 'success') {
            // Muestra un mensaje de éxito utilizando SweetAlert2
            Swal.fire(
              '¡Vaciado!',
              'La conversación ha sido vaciada.',
              'success'
            ).then(() => {
              location.reload(); // Recarga la página para reflejar los cambios
            });
          } else {
            // Muestra un mensaje de error utilizando SweetAlert2
            Swal.fire(
              'Error',
              'Hubo un error al vaciar la conversación.',
              'error'
            );
          }
        })
        .catch(error => {
          // En caso de un error en la solicitud fetch, muestra un mensaje de error
          console.error('Error:', error);
          Swal.fire(
            'Error',
            'Hubo un problema con la petición Fetch: ' + error.message,
            'error'
          );
        });
      }
    });
  });
  // Función para alternar la visibilidad del menú
  function toggleMenu(event) {
    event.stopPropagation(); // Evita que el evento de clic se propague al documento
    var menu = document.querySelector('.menu-content');
    menu.style.display = menu.style.display === "block" ? "none" : "block";
  }
  // Agrega un event listener al icono de menú para alternar su visibilidad
  document.querySelector('.menu-icon').addEventListener('click', toggleMenu);
  // Oculta el menú cuando se hace clic en cualquier parte fuera de él
  document.addEventListener('click', function(event) {
    var menu = document.querySelector('.menu-content');
    if (event.target.closest('.menu-content, .menu-icon')) {
      // Si el clic fue dentro del menú o en el icono, no hacer nada
      return;
    }
    // Si el clic fue fuera, oculta el menú
    menu.style.display = "none";
  });
  // Abre el explorador de archivos al hacer clic en el botón de carga
  document.getElementById("upload-btn").onclick = function() {
    document.getElementById("file-upload").click();
  };
  // Se activa cuando se selecciona un archivo para cargar
  document.getElementById("file-upload").onchange = function() {
    if (this.files && this.files[0]) {
      var formData = new FormData(form);
      formData.append("image", this.files[0]); // Añade la imagen seleccionada al objeto FormData
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "../controlador/insert-chat.php", true);
      xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            inputField.value = ""; // Limpiar el campo de texto
            scrollToBottom();
            // Aquí podrías añadir lógica adicional si es necesario
          }
        }
      };
      xhr.send(formData);
    }
  };
  