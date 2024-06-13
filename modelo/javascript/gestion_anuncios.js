$(document).ready(function() {
    $('.table').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json",
            "lengthMenu": "Mostrar _MENU_ registros" // Texto personalizado para el menú de longitud
        },
        "pagingType": "simple_numbers",
        "lengthMenu": [[5, 10, 20, 50, -1], [5, 10, 20, 50, "Todos"]],
        "pageLength": 5
    });
    // Ajusta el texto del label para la búsqueda para incluir los dos puntos
    $('.dataTables_filter label').contents().filter(function(){
        return this.nodeType === 3; //Node.TEXT_NODE
    }).replaceWith('Buscar: '); // Reemplaza el texto 'Buscar' por 'Buscar:'

    // Modifica el label de longitud para que se ajuste al formato solicitado
    $('.dataTables_length label').contents().filter(function(){
        return this.nodeType === 3;
    }).each(function() {
        if ($.trim(this.nodeValue).startsWith('Show')) {
            $(this).replaceWith('Mostrar ');
        }
    });
});