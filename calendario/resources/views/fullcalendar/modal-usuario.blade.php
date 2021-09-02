<!-- Modal -->
<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="titleModal">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
  
        <div class="modal-body">
  
        <div class="message"></div>

          <form id="formUsuario">
              <div class="form-group row">
                  <label for="nombre" class="col-sm-4 col-form-label">nombre</label>
                  <div class="col-sm-8">
                        
                      <input type="text" name="nombre" class="form-control" id="nombre">
                      <input name="id" readonly>
                  </div>
              </div>
              <div class="form-group row">
                  <label for="apellidos" class="col-sm-4 col-form-label">apellidos</label>
                  <div class="col-sm-8">
                      <input name="apellidos" id="apellidos" cols="40" rows="4">
                  </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label">email</label>
                <div class="col-sm-8">
                    <input name="email" id="email" cols="40" rows="4">
                </div>
            </div>
          </form>
        </div>
  
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-danger deleteUsuario">Borrar</button>
          <button type="button" class="btn btn-primary saveUsuario">Guardar</button>
        </div>
      </div>
    </div>
  </div>