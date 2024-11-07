
<div id="modalEdit" class="modal bottom-sheet col s12">
  <div class="modal-content">
      <h4>Editar Rol</h4>
      <form action="#" method="post">
          <input type="hidden" id="idRolEdit" name="idRolEdit">
          <label for="name">Nombre:</label>
          <input type="text" id="nameEdit" name="nameEdit" placeholder="Ingresa el nombre" required>

          <label for="message">Descripción:</label>
          <textarea id="descriptionEdit" name="descriptionEdit" rows="4" placeholder="Escribe la descripción" required></textarea>

          <a type="submit" class="waves-effect waves-light btn" id="btnSaveEdit">Guardar</a>
      </form>
  </div>
</div>

<script type="text/javascript">
    function viewModalEdit(idRol){
        console.log('viewModalEdit');
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
                $('#idRolEdit').val(rolData.rol_id);
                $('#nameEdit').val(rolData.name);
                $('#descriptionEdit').val(rolData.description);
            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }

    $('#btnSaveEdit').on("click",function() {
      console.log('save Edit');
      const idRol = $('#idRolEdit').val();
      const nameEdit = $('#nameEdit').val();
      const descriptionEdit = $('#descriptionEdit').val();
      $.ajax({
            url: '/api/roles/update',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {idRol: idRol, nameEdit: nameEdit, descriptionEdit: descriptionEdit},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'App-Token': <?= h($appTokenEnv); ?>,
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                const rolData = response.data; 
                $('#idRolEdit').val(rolData.rol_id);
                $('#nameEdit').val(rolData.name);
                $('#descriptionEdit').val(rolData.description);

                $('#roles-table').DataTable().ajax.reload();
                var modalEditI = M.Modal.getInstance(document.querySelector('#modalEdit'));
                modalEditI.close();

            },
            error: function(xhr, status, error) {
                // 
            }
        });
    });
</script>