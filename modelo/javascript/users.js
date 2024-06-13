(function() {
  document.addEventListener('DOMContentLoaded', () => {
    // Variable global para almacenar el estado de los permisos de notificación
    let notificationPermission = Notification.permission;

    // Función para solicitar permisos de notificación si aún no se han solicitado
    function requestNotificationPermission() {
      if (notificationPermission !== "granted") {
        Notification.requestPermission().then(permission => {
          notificationPermission = permission;
          if (permission !== "granted") {
            console.log("Permisos de notificación denegados");
          }
        });
      }
    }

    // Llama a la función para solicitar permisos al cargar la página, solo si aún no se han solicitado
    if (notificationPermission !== "granted") {
      requestNotificationPermission();
    }

    // Selecciona el input del campo de búsqueda
    const searchBar = document.querySelector(".search input"),
    // Selecciona el botón de búsqueda
    searchIcon = document.querySelector(".search button"),
    // Selecciona la lista de usuarios
    usersList = document.querySelector(".users-list");

    if (searchIcon && searchBar && usersList) {
      // Agrega un evento de clic al ícono de búsqueda
      searchIcon.onclick = () => {
        // Alterna la clase 'show' en el campo de búsqueda para mostrarlo o ocultarlo
        searchBar.classList.toggle("show");
        // Alterna la clase 'active' en el ícono de búsqueda para resaltarlo
        searchIcon.classList.toggle("active");
        // Pone el foco en el campo de búsqueda
        searchBar.focus();
        // Si el campo de búsqueda está activo, borra su contenido y quita la clase 'active'
        if (searchBar.classList.contains("active")) {
          searchBar.value = "";
          searchBar.classList.remove("active");
        }
      }

      // Agrega un evento de teclado al campo de búsqueda
      searchBar.onkeyup = () => {
        // Obtiene el término de búsqueda ingresado
        let searchTerm = searchBar.value;
        // Si el término de búsqueda no está vacío, agrega la clase 'active' al campo de búsqueda
        if (searchTerm != "") {
          searchBar.classList.add("active");
        } else {
          // De lo contrario, elimina la clase 'active'
          searchBar.classList.remove("active");
        }
        // Crea una nueva solicitud XMLHttpRequest
        let xhr = new XMLHttpRequest();
        // Abre una conexión POST al archivo de controlador para realizar la búsqueda
        xhr.open("POST", "../controlador/search.php", true);
        // Define la función que se ejecutará cuando la solicitud se complete
        xhr.onload = () => {
          // Verifica si la solicitud se ha completado correctamente
          if (xhr.readyState === XMLHttpRequest.DONE) {
            // Verifica si la respuesta del servidor es exitosa
            if (xhr.status === 200) {
              // Obtiene los datos de respuesta
              let data = xhr.response;
              // Actualiza la lista de usuarios con los datos obtenidos
              usersList.innerHTML = data;
            }
          }
        }
        // Establece el encabezado de la solicitud
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        // Envía la solicitud con el término de búsqueda como parámetro
        xhr.send("searchTerm=" + searchTerm);
      }

      // Cada medio segundo, realiza una solicitud para obtener la lista de usuarios válidos
      setInterval(() => {
        // Crea una nueva solicitud XMLHttpRequest
        let xhr = new XMLHttpRequest();
        // Abre una conexión GET al archivo de controlador para obtener la lista de usuarios válidos
        xhr.open("GET", "../controlador/users_valida.php", true);
        // Define la función que se ejecutará cuando la solicitud se complete
        xhr.onload = () => {
          // Verifica si la solicitud se ha completado correctamente
          if (xhr.readyState === XMLHttpRequest.DONE) {
            // Verifica si la respuesta del servidor es exitosa
            if (xhr.status === 200) {
              // Obtiene los datos de respuesta
              let data = xhr.response;
              // Verifica si el campo de búsqueda no está activo
              if (!searchBar.classList.contains("active")) {
                // Actualiza la lista de usuarios con los datos obtenidos
                usersList.innerHTML = data;
              }
            }
          }
        }
        // Envía la solicitud
        xhr.send();
      }, 500);

      // Variable para almacenar el último conteo de mensajes no leídos
      let lastUnreadCount = 0;
      // Variable para la notificación actual
      let notification = null;

      // Función para actualizar el contador de mensajes no leídos cada medio segundo
      function updateUnreadMessagesCount() {
        // Crea una nueva solicitud XMLHttpRequest
        let xhr = new XMLHttpRequest();
        // Abre una conexión GET al archivo de controlador para obtener el contador de mensajes no leídos
        xhr.open("GET", "../controlador/get-unread-count.php", true);
        // Define la función que se ejecutará cuando la solicitud se complete
        xhr.onload = () => {
          // Verifica si la solicitud se ha completado correctamente
          if (xhr.readyState === XMLHttpRequest.DONE) {
            // Verifica si la respuesta del servidor es exitosa
            if (xhr.status === 200) {
              // Obtiene el contador de mensajes no leídos de la respuesta
              let unreadCount = parseInt(xhr.responseText, 10);

              // Si el conteo de mensajes no leídos ha cambiado desde la última vez
              if (unreadCount !== lastUnreadCount) {
                // Selecciona el span que muestra el contador de mensajes no leídos
                let unreadSpan = document.querySelector(".alerta-mensajes-no-leidos span");
                if (!unreadSpan) {
                  const chatLink = document.querySelector("a[href='users.php']");
                  const newUnreadSpan = document.createElement("span");
                  newUnreadSpan.className = "alerta-mensajes-no-leidos";
                  newUnreadSpan.innerHTML = `<i class='fas fa-bell animate__animated animate__tada animate__infinite' style='color: red;'></i><span>${unreadCount}</span>`;
                  chatLink.appendChild(newUnreadSpan);
                  unreadSpan = newUnreadSpan.querySelector("span");
                } else {
                  unreadSpan.textContent = unreadCount;
                }
                // Actualiza el último conteo de mensajes no leídos
                lastUnreadCount = unreadCount;

                // Obtener el último conteo de mensajes no leídos notificado desde localStorage
                let lastNotifiedCount = parseInt(localStorage.getItem('lastNotifiedCount'), 10) || 0;

                // Mostrar la notificación solo si hay nuevos mensajes no leídos y no ha sido notificado ya
                if (notification && unreadCount > lastNotifiedCount) {
                  notification.close();
                }
                if (!notification && unreadCount > lastNotifiedCount) {
                  notification = new Notification("Rent-Ware: Tienes " + unreadCount + " mensajes nuevos");

                  // Guardar el nuevo conteo de mensajes no leídos notificado en localStorage
                  localStorage.setItem('lastNotifiedCount', unreadCount);

                  // Después de 5 segundos, cierra la notificación
                  setTimeout(() => {
                    notification.close();
                    notification = null;
                  }, 5000);

                  // Redirigir al usuario a users.php al hacer clic en la notificación
                  notification.onclick = function() {
                    window.location.href = "users.php";
                  };
                }
              }
            }
          }
        };
        // Envía la solicitud
        xhr.send();
      }

      // Ejecuta la función para actualizar el contador de mensajes no leídos cada medio segundo
      setInterval(updateUnreadMessagesCount, 500);
    }
  });
})();
