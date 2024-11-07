
<div id="modalDelete" class="modal bottom-sheet col s12">
  <div class="modal-content">
      <h4>Eliminar Rol</h4>
      <form action="#" method="post">
          <input type="hidden" id="idRolDelete" name="idRolDelete">
          <p>¿Estas seguro de eliminar el registro <b><span id="nameDelete"></span></b>?</p>
          <p>Una vez eliminado ya no podrás recuperarlo.</p>

          <a type="submit" class="waves-effect waves-light btn" id="btnSaveDelete">Eliminar</a>
      </form>
  </div>
</div>

<script type="text/javascript">
    function viewModalDelete(idRol){
        console.log('viewModalDelete');
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
                $('#idRolDelete').val(rolData.rol_id);
                $('#nameDelete').text(rolData.name);
            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }

    $('#btnSaveDelete').on("click",function() {
      console.log('save Delete');
      const idRol = $('#idRolDelete').val();
      $.ajax({
            url: '/api/roles/delete',
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

                $('#roles-table').DataTable().ajax.reload();
                var modalEditI = M.Modal.getInstance(document.querySelector('#modalDelete'));
                modalEditI.close();

            },
            error: function(xhr, status, error) {
                // 
            }
        });
    });
</script>