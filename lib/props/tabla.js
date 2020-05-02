function DataTable(tabla, columnas = null, sort = null) {

    var accion = [{
            "targets": columnas,
            "searchable": true
        },
        {
            "targets": columnas,
            "orderable": true
        }
    ];
    if (sort != null) sort = [sort];
    else sort = [];

    var aux = $(tabla).DataTable();
    if (aux != null) aux.destroy();

    $(tabla).DataTable({
        "paging": true,
        "columnDefs": accion,
        "order": sort,
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "_START_ de _END_ | Total Registros _TOTAL_",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
            colReorder: true
        
    });
    //$('.dataTables_filter').hide();
}