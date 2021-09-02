<!-- Modal -->
<div class="modal fade" id="modalFastEvent" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
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
        
          <form id="formFastEvent">
              <div class="form-group row">
                  <label for="title" class="col-sm-4 col-form-label">Actividad</label>
                  <div class="col-sm-8">
                      <input type="text" name="title" class="form-control" id="title">
                      <input name="id" readonly hidden>
                      <input name="tutor_id" readonly hidden> <!-- ...............................................................-->
                      <!-- <input type="hidden" name="alumno_id" readonly> -->
                  </div>
              </div>
              <div class="form-group row">
                <!-- <label for="start" class="col-sm-4 col-form-label">Fecha/hora inicial</label> -->
                 <div class="col-sm-8">
                     <input type="hidden" name="start" class="form-control time" id="start">
                 </div>
             </div>
             <div class="form-group row">
                 <!-- <label for="end" class="col-sm-4 col-form-label">Fecha/hora final</label> -->
                 <div class="col-sm-8">
                     <input type="hidden" name="end" class="form-control time" id="end">
                 </div>
             </div>
              <div class="form-group row"> 
                 <!-- <label for="color" class="col-sm-4 col-form-label">Color</label> -->
                  <div class="col-sm-8">
                      <input type="hidden" type="color" name="color" class="form-control" id="color" value="#3cc926" readonly>
                  </div>
              </div> 
              
              <div class="form-group row">
                  <label for="description" class="col-sm-4 col-form-label">Descripción</label>
                  <div class="col-sm-8">
                      <textarea name="description" id="description" cols="40" rows="4"></textarea>
                  </div>
              </div>
          </form>
        </div>
  
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-danger deleteFastEvent">Borrar</button>
          <button type="button" class="btn btn-primary saveFastEvent">Guardar</button>
        </div>
      </div>
    </div>
  </div>