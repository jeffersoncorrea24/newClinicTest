$(document).ready(function () {
    $('#data').DataTable({
            "order": [[ 5, "desc" ]],
            language: {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
               buttons: {
       
        "excel": 'Exportar a Excel',
      
    }
            },
     "bDestroy": true,
     
    dom: 'Bfrtip',
        buttons: [
            
            'excelHtml5'
            
        ]
        }

    );
});

/*table.buttons().container()
    .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );*/