<h1>Roles List</h1>
<?= $this->Html->link(
        'Crear Nuevo Rol', 
        ['controller' => 'Roles', 'action' => 'create'], 
        ['class' => 'waves-effect waves-light btn']
    );
?>

<table id="roles-table" class="display">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
</table>

<?= $this->element('Roles/modal_details') ?>
<?= $this->element('Roles/modal_edit') ?>
<?= $this->element('Roles/modal_delete') ?>


<!-- Initialize DataTable with server-side processing -->
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);
    });

    function clearFields(){
        $('#name').text('');

    }

$(document).ready(function() { 
    $.ajax({
        url: '/api/roles/cakes',
        async: 'true',
        type: 'POST',
        dataType: 'json',
        headers: {
            'contentType': 'application/json; charset=UTF-8',
            'App-Token': <?= h($appTokenEnv); ?>,
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log("response: ", response);
        },
        error: function(xhr, status, error) {
            // 
        }
    });

    

    // Manejar el click en el botón "Ver Detalles"
    $('#view-details').on('click', function() {
            // Obtener el ID del usuario de los datos del botón
            var userId = $(this).data('id');

            // Hacer la solicitud AJAX para obtener los detalles
            $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Users', 'action' => 'view']) ?>/' + userId,
                method: 'GET',
                success: function(response) {
                    // Cargar los datos recibidos en el cuerpo del modal
                    $('#modalBody').html(response);
                    // Mostrar el modal
                    $('#detailModal').modal('show');
                },
                error: function() {
                    // Mostrar el modal
                    $('#detailModal').modal('show');
                    alert('An error occurred while loading the details.');
                }
            });
        });


    $('#roles-table').DataTable({
        "data": null,
        "autoWidth": true,
        "destroy":true,
        "responsive": true,
        "searching": true,
        "info": true,
        "processing": true,  // Show loading indicator
        "serverSide": true,   // Enable server-side processing
        "ajax": {
            "url": "/api/roles/getall",
            "type": "GET",
            "datatype": "json",
            "dataSrc": "data.data",
            "headers": {
                'contentType': 'application/json; charset=UTF-8',
                'App-Token': <?= h($appTokenEnv); ?>,
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
        },
        "order": [],
        "columns": [
            { "data": 1 },  // Name
            { "data": 2 },  // Description
            {
                "render": function (data, type, full, meta) {
                    
                    console.log("full:", full);
                    console.log("data:", data);
                    console.log("data:", full[3]);
                    

                    let statusName = "Sin status";
                    let statusColor = "badge-table-primary";
                    switch(parseInt(full[3])){
                        case 1: statusName = "Activo"; statusColor = "badge-table-success";break;
                        case 1: statusName = "Inactivo"; statusColor = "badge-table-yellow";break;
                        case 1: statusName = "Eliminado"; statusColor = "badge-table-danger";break;


                    }
                    return `<span class="${statusColor} badge primary">${statusName}</span>`;
                }
            },
            {
                "render": function (data, type, full, meta) {

                    return `<a class="waves-effect waves-light btn-small modal-trigger" href="#modalDetails" onclick="viewModalDetail(${full[0]})"><i class="material-icons center">visibility</i></a>&nbsp<a class="waves-effect waves-orange btn-small orange lighten-1 modal-trigger" href="#modalEdit" onclick="viewModalEdit(${full[0]})"><i class="material-icons center">edit</i></a>&nbsp<a class="waves-effect waves-red btn-small red lighten-1 modal-trigger" href="#modalDelete" onclick="viewModalDelete(${full[0]})"><i class="material-icons center">delete</i></a>`;

                    // return `<a class="waves-effect waves-light btn-small" onclick="window.location.href='/roles/create'"><i class="material-icons center">visibility</i></a>&nbsp<a class="waves-effect waves-orange btn-small orange lighten-1" onclick="window.location.href='/roles/create'"><i class="material-icons center">edit</i></a>&nbsp<a class="waves-effect waves-red btn-small red lighten-1" onclick="window.location.href='/roles/create'"><i class="material-icons center">delete</i></a>`;
                }
            }
        ],
        "language": {
            "sProcessing":     "Cargando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Registros del _START_ al _END_ total de _TOTAL_ registros",
            "sInfoEmpty":      "Registros del 0 al 0  total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "sColumns": {
                "title": "Date"
            }
        },
    });

    
    $('#users-table').on('keyup', function() {
        table.search(this.value).draw(); // Aplica la búsqueda
    });
    
});
</script>
