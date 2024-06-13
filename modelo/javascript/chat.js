// Selecciona el formulario de escritura
const form = document.querySelector(".typing-area"),
// Obtiene el ID del usuario entrante
incoming_id = form.querySelector(".incoming_id").value,
// Selecciona el campo de entrada de texto
inputField = form.querySelector(".input-field"),
// Selecciona el botón de enviar
sendBtn = form.querySelector("button"),
// Selecciona el área del chat
chatBox = document.querySelector(".chat-box");
// Abre el explorador de archivos al hacer clic en el botón de carga
document.getElementById("upload-btn").onclick = function() {
    document.getElementById("file-upload").click();
};
// Se activa cuando se selecciona un archivo para cargar
document.getElementById("file-upload").onchange = function() {
    if(this.files && this.files[0]) {
        // Crea un objeto FormData para enviar los datos del formulario
        var formData = new FormData(form);
        // Añade la imagen seleccionada al objeto FormData
        formData.append("image", this.files[0]);
        // Crea una nueva solicitud XMLHttpRequest
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../controlador/insert-chat.php", true);
        // Define la función que se ejecutará cuando la solicitud se complete
        xhr.onload = () => {
            // Verifica si la solicitud se ha completado correctamente
            if(xhr.readyState === XMLHttpRequest.DONE){
                // Verifica si la respuesta del servidor es exitosa
                if(xhr.status === 200){
                    // Limpia el campo de texto después de enviar el mensaje
                    inputField.value = "";
                    // Desplaza hacia abajo para mostrar el mensaje más reciente
                    scrollToBottom();
                    // Aquí podrías añadir lógica adicional si es necesario
                }
            }
        };
        // Envía la solicitud con los datos del formulario
        xhr.send(formData);
    }
};
// Evita que se envíe el formulario al presionar Enter
form.onsubmit = (e)=>{
    e.preventDefault();
}
//Enfoca el campo de entrada de texto al cargar la página
inputField.focus();
// Activa o desactiva el botón de enviar según si hay texto en el campo de entrada
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}
// Envia el mensaje cuando se hace clic en el botón de enviar
sendBtn.onclick = ()=>{
    // Crea una nueva solicitud XMLHttpRequest
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../controlador/insert-chat.php", true);
    // Define la función que se ejecutará cuando la solicitud se complete
    xhr.onload = ()=>{
      // Verifica si la solicitud se ha completado correctamente
      if(xhr.readyState === XMLHttpRequest.DONE){
          // Verifica si la respuesta del servidor es exitosa
          if(xhr.status === 200){
              // Limpia el campo de texto después de enviar el mensaje
              inputField.value = "";
              // Desplaza hacia abajo para mostrar el mensaje más reciente
              scrollToBottom();
          }
      }
    }
    // Crea un objeto FormData para enviar los datos del formulario
    let formData = new FormData(form);
    // Envía la solicitud con los datos del formulario
    xhr.send(formData);
}
// Muestra el área de chat al pasar el mouse sobre ella
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}
// Oculta el área de chat al sacar el mouse de ella
chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}
// Bloque para obtener los mensajes en tiempo real (cada medio segundo)
setInterval(() =>{
    // Crea una nueva solicitud XMLHttpRequest
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../controlador/get-chat.php", true);
    // Define la función que se ejecutará cuando la solicitud se complete
    xhr.onload = ()=>{
      // Verifica si la solicitud se ha completado correctamente
      if(xhr.readyState === XMLHttpRequest.DONE){
          // Verifica si la respuesta del servidor es exitosa
          if(xhr.status === 200){
            // Obtiene los datos de respuesta
            let data = xhr.response;
            // Actualiza el contenido del área de chat con los nuevos mensajes
            chatBox.innerHTML = data;
            // Desplaza hacia abajo para mostrar el mensaje más reciente si el área de chat no está activa
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    // Establece el encabezado de la solicitud
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Envía la solicitud con el ID del usuario entrante
    xhr.send("incoming_id="+incoming_id);
}, 500); // Intervalo de actualización en milisegundos

// Función para desplazar el área de chat hacia abajo para mostrar el mensaje más reciente
function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}