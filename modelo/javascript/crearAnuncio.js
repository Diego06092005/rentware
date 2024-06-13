       // Obtener el elemento del input de fecha
       var fechaInput = document.getElementById('fecha_publicacion');
    // Obtener la fecha actual
    var fechaActual = new Date();
    // Formatear la fecha actual como YYYY-MM-DD (formato de entrada de fecha)
    var fechaFormateada = fechaActual.toISOString().split('T')[0];
    // Establecer la fecha actual como el valor del campo de entrada de fecha
    fechaInput.value = fechaFormateada;
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
    document.addEventListener("DOMContentLoaded", function() {
    const cardsPerPage = 3;
    let currentPage = 1;

    function showPage(page) {
        const cards = document.querySelectorAll('.card-item');
        const totalPages = Math.ceil(cards.length / cardsPerPage);

        if (page < 1 || page > totalPages) return;
        currentPage = page;
        document.getElementById('currentPage').textContent = page;

        let start = (page - 1) * cardsPerPage;
        let end = start + cardsPerPage;

        cards.forEach((card, index) => {
            if (index >= start && index < end) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
    window.changePage = function(delta) {
        showPage(currentPage + delta);
    };
    showPage(1); // Initialize the first page
});