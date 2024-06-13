// Tiempo de inactividad en milisegundos (1 minuto)
var inactivityTime = 1 * 60 * 1000; // 1 minuto en milisegundos

var timeout;

function startTimer() {
    timeout = setTimeout(showLogoutWarning, inactivityTime - 10000); // Mostrar advertencia 10 segundos antes de cerrar la sesión
}

function resetTimer() {
    clearTimeout(timeout);
    startTimer();
}

function logoutUser() {
    window.location.href = "../controlador/logout.php?logout_id=<?php echo $id_usuario; ?>"; // Redirigir a la página de cierre de sesión
}

function showLogoutWarning() {
    // Mostrar un mensaje de confirmación al usuario
    var confirmLogout = confirm("Tu sesión está a punto de cerrarse debido a la inactividad. ¿Deseas continuar en la sesión?");
    if (confirmLogout) {
        // Si el usuario elige continuar, reiniciar el temporizador y no cerrar la sesión
        resetTimer();
    } else {
        // Si el usuario elige cerrar la sesión, redirigir a la página de cierre de sesión
        logoutUser();
    }
}

// Iniciar el temporizador cuando se carga la página
$(document).ready(function() {
    startTimer();
});

// Reiniciar el temporizador en la actividad del usuario
$(document).mousemove(function() {
    resetTimer();
});

$(document).keypress(function() {
    resetTimer();
});