<!-- Modal -->
<div class="modal fade" id="modalCalendar" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
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
      
        <form id="formActividad">
          <div>
            <label for="select-tipo">Tipo</label>
            <select name="select-tipo" id="select-tipo">
              <option value="1">Aeróbico</option>
              <option value="2">Fuerza (Resistencia)</option>
              <option value="3">Estiramientos</option>
            </select>
          </div>
          <div>
            <label for="select-nivel">Nivel</label>
            <select name="select-nivel" id="select-nivel">
              <option value="1">alto</option>
              <option value="2">medio</option>
              <option value="3">bajo</option>
            </select>
          </div>
          <div>
            <label for="select-ejercicio">Ejercicio</label>
            <select name="select-ejercicio" id="select-ejercicio">
              @if($fastEvents)
                @foreach ($fastEvents as $fastEvent)
                    <div
                      style="
                        padding: 4px;
                        border:1px solid{{$fastEvent->color}}; 
                        background-color:{{$fastEvent->color}}"
                      class='fc-event' 
                      data-event='{"id":"{{$fastEvent->id}}","tutor_id":"{{$fastEvent->tutor_id}}","title":"{{$fastEvent->act_title}}","color":"{{$fastEvent->color}}","start":"{{$fastEvent->start}}","end":"{{$fastEvent->end}}","description":"{{$fastEvent->act_description}}"}'>{{$fastEvent->act_title}}</div>
                @endforeach
              @endif()
            </select>
          </div>
          <div class="form-group row">
              <label for="title" class="col-sm-4 col-form-label">Actividad</label>
              <div class="col-sm-8">
                  <input type="text" name="title" class="form-control" id="title">
                  <input type="hidden" name="id" readonly>

                  <!-- <label for="tutor_id" class="col-sm-4 col-form-label">id tutor</label> -->         <!-- quitar labels y poner en hidden-->
                  <input type="hidden" name="tutor_id" readonly>

                  <!-- <label for="alumno_id" class="col-sm-4 col-form-label">id alumno</label> -->       <!-- quitar labels y poner en hidden-->
                  <input type="hidden" name="alumno_id" readonly>
              </div>
          </div>
          <div class="form-group row">
              <!-- <label for="start" class="col-sm-4 col-form-label">Fecha/hora inicial</label> -->
              <div class="col-sm-8">
                  <input type="hidden" name="start" class="form-control date-time" id="start">
              </div>
          </div>
          <div class="form-group row">
              <!-- <label for="end" class="col-sm-4 col-form-label">Fecha/hora final</label> -->
              <div class="col-sm-8">
                  <input type="hidden" name="end" class="form-control date-time" id="end">
              </div>
          </div>
          {{-- <div class="form-group row"> <!-- para el caso de una paleta concreta de colores usar una librería de js -->
              <label for="color" class="col-sm-4 col-form-label">Color</label>
              <div class="col-sm-8">
                  <input type="color" name="color" class="form-control" id="color">
              </div>
          </div>  --}}
          <div class="form-group row" style="margin-bottom: 50px"> <!-- falta capturar el index y pasarlo a la BD -->
            <label for="color" class="col-sm-4 col-form-label" style="margin-right: 15px">Color</label>
            <div class="radio" class="col-sm-4 col-form-label" style="margin-top: 10px">
              <input type="radio" name="color" id="rbverde" value="#3cc926">
              <label for="hombre" id="rbverde" style="background-color: #3cc926; color:#3cc926; border-radius: 25px; ">color1</label>
          
              <input type="radio" name="color" id="rbamarillo" value="#b6a827">
              <label for="mujer" id="rbamarillo" style="background-color: #b6a827; color: #b6a827; border-radius: 25px;">color2</label>
          
              <input type="radio" name="color" id="rbrojo" value="#d81515" >
              <label for="alien" id="rbrojo" style="background-color: #d81515; color: #d81515; border-radius: 25px;">color3</label>
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
        <button type="button" class="btn btn-danger deleteEvent">Borrar</button>
        <button type="button" class="btn btn-primary saveEvent">Guardar</button>
      </div>
    </div>
  </div>
</div>