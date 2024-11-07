
<div id="modalDetails" class="modal bottom-sheet col s12">
  <div class="modal-content">
      <h4>Ver Detalles del Rol</h4>
      <p>Nombre: <span id="name"></span></p>
      <p>Descripción: <span id="description"></span></p>
      <p>Status: <span id="status"></span></p>
      <p>Fecha de creación: <span id="dateCreate"></span></p>
  </div>
  <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
  </div>
</div>

<script type="text/javascript">
  function viewModalDetail(idRol){
        console.log('viewModalDetail');
        clearFields();
        $.ajax({
            url: '/api/roles/get',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {idRol: idRol},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'App-Token': <?= h($appTokenEnv); ?>,
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                const rolData = response.data; 
                $('#name').text(rolData.name);
                $('#description').text(rolData.description);
                $('#status').text(rolData.id_status === null ? 'Sin Información': (rolData.id_status === 1 ? 'Activo': 'Inactivo'));
                $('#dateCreate').text(rolData.date_create === null ? 'Sin Información':rolData.date_create);

            },
            error: function(xhr, status, error) {
                // 
            }
        });
        
    }

</script>