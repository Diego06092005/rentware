// funcion para que los mjs no leidos llegue en 500 mlsegundos (medio segundo)
function updateUnreadMessagesCount() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../controlador/get-unread-count.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                let unreadCount = xhr.responseText;
                const unreadSpan = document.querySelector(".alerta-mensajes-no-leidos span");
                if(unreadSpan) {
                    unreadSpan.textContent = unreadCount;
                } else if (unreadCount > 0) {
                    const chatLink = document.querySelector("a[href='users.php']");
                    const newUnreadSpan = document.createElement("span");
                    newUnreadSpan.className = "alerta-mensajes-no-leidos";
                    newUnreadSpan.innerHTML = `<i class='fas fa-bell animate__animated animate__tada animate__infinite' style='color: red;'></i><span>${unreadCount}</span>`;
                    chatLink.appendChild(newUnreadSpan);
                }
            }
        }
    };
    xhr.send();
}
setInterval(updateUnreadMessagesCount, 500);