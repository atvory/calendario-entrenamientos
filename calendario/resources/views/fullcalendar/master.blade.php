

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='assets/fullcalendar/packages/core/main.css' rel='stylesheet' />
<link href='assets/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
<link href='assets/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
<link href='assets/fullcalendar/packages/list/main.css' rel='stylesheet' />
{{-- 
<!-- link al bootstrap para bien ser deberia de bajarse y compilarse con el resto de assets por tema de consistencia-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<!-- link a capa de estilos -->
<link href='assets/fullcalendar/css/style.css' rel='stylesheet' />
<meta name="csrf-token" content="{{ csrf_token() }}"> --}}

</head>
<body>

  <link href='assets/fullcalendar/packages/core/main.css' rel='stylesheet' />
  <link href='assets/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
  <link href='assets/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
  <link href='assets/fullcalendar/packages/list/main.css' rel='stylesheet' />
  
  <!-- link al bootstrap para bien ser deberia de bajarse y compilarse con el resto de assets por tema de consistencia-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <!-- link a capa de estilos -->
  <link href='assets/fullcalendar/css/style.css' rel='stylesheet' />
  <meta name="csrf-token" content="{{ csrf_token() }}">

@include('fullcalendar.modal-calendar')
@include('fullcalendar.modal-fastEvents')
@include('fullcalendar.modal-usuario')

<div id='wrap'>

  <script>
    const valores = window.location.search;
    console.log(valores);

    const urlParams = new URLSearchParams(valores);
    var idEntrenador = urlParams.get('id');
    console.log(idEntrenador);

  </script>
  <!-- mover datos del script al if para mostrar solo el entrenador que se logea y sus alumnos-->
  
  <div id='external-events'>
    <h4>Entrenador:</h4>
    <div id="div-entrenador-actual">
      @if($entrenadores)
        
          @foreach($entrenadores as $entrenador)
            <div
              style="font-size:16px"
              class='fc-entrenador'
              data-event='"{{$entrenador->id}}"'>{{$entrenador->apodo}}
            </div>
            <div
              style="display: none;"
              class='fc-entrenador-id'>{{$entrenador->id}}
            </div>
          @endforeach
      @endif()
    </div>
    
    
    <h4>Alumno</h4>
    <div id="div-select-users"> 
      <select name="select" id="select-users" class="select-users">
        <option value="0" selected="selected">Selecciona</option>
        @if($usuarios)
          @foreach($usuarios as $usuario)
            <option
              class='fc-usuario'  
              value="{{$usuario->id}}"
                @if(request('usuario_id') == $usuario->id) selected @endif>{{$usuario->nombre}} {{$usuario->apellidos}}</option>
          @endforeach
        @endif()
      </select>
    </div>
    
    
    <!--
    <p>
      <button class="btn btn-sm btn-success" id="newUsuario">Nuevo Usuario</button>
    </p>
-->
     
    <h4>Actividades</h4>
    <div id='external-events-list'>
      @if($fastEvents)
        @foreach ($fastEvents as $fastEvent)
              <div
                  style="
                    padding: 4px; 
                    border:1px solid{{$fastEvent->color}}; 
                    background-color:{{$fastEvent->color}}"
                  class='fc-event' 
                  data-event='{"id":"{{$fastEvent->id}}","tutor_id":"{{$fastEvent->tutor_id}}","title":"{{$fastEvent->act_title}}","color":"{{$fastEvent->color}}","start":"{{$fastEvent->start}}","end":"{{$fastEvent->end}}","description":"{{$fastEvent->act_description}}","tipo":"{{$fastEvent->act_tipo}}","nivel":"{{$fastEvent->act_nivel}}","video":"{{$fastEvent->video}}"}'>{{$fastEvent->act_title}}</div>
        @endforeach
      @endif()
    </div>
    <p>
        <button class="btn btn-sm btn-success" id="newFastEvent">Nueva Actividad</button>
    </p>

   
  </div>



  <div 
      id='calendar'
      data-route-load-events="{{ route('routeLoadEvents') }}" 

      data-route-event-update="{{ route('routeEventUpdate') }}"
      data-route-event-store="{{ route('routeEventStore') }}"
      data-route-event-delete="{{ route('routeEventDelete') }}"

      data-route-fast-event-delete="{{ route('routeFastEventDelete') }}"
      data-route-fast-event-update="{{ route('routeFastEventUpdate') }}"
      data-route-fast-event-store="{{ route('routeFastEventStore') }}"

      data-route-usuario-store="{{route('routeUsuarioStore')}}"
      >
  </div>

  <div style='clear:both'></div>

</div>

<script src='assets/fullcalendar/packages/core/main.js'></script>
<script src='assets/fullcalendar/packages/interaction/main.js'></script>
<script src='assets/fullcalendar/packages/daygrid/main.js'></script>
<script src='assets/fullcalendar/packages/timegrid/main.js'></script>
<script src='assets/fullcalendar/packages/list/main.js'></script>
<!-- traduccion -->
<script src='assets/fullcalendar/packages/core/locales-all.js'></script>

<!-- cdn para jquery y para la libreria de moment.js para poder hacer persistentes cambios en los eventos -->
<script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>

<!-- cdn de jquery.mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<!-- cdn js para las modales -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>




<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script>let objCalendar;</script>

<!-- para cargar los eventos en el calendario, importante antes de cargar el calendario -->
<script src='assets/fullcalendar/js/script.js'></script>
<!-- link a los archivos js -->
<script src='assets/fullcalendar/js/calendar.js'></script>



</body>
</html>
