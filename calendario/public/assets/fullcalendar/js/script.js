

// para comprobar que el cdn del jquery funciona llamar a una funcion con alert
/* $(function(){
    alert('prueba jquery funciona')
}); */

$(function(){

    $('.date-time').mask('00/00/0000 00:00:00'); //$('.date-time').mask('00/00/0000 00:00:00');
    $('.time').mask('00:00:00');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* $("#select-users").onChange(function()
    {
      var idAlumno = document.getElementById("select-users");
      var seleccionado = idAlumno.value;
    
      console.log(seleccionado);
    }); */
    /* document.getElementById('select-users').onchange = function filterEvents(){

        var idAlumno = document.getElementById("select-users");
        var seleccionado = idAlumno.value;

        console.log(seleccionado);
    };
 */

    
    $('#filtrado').click(function(){
        var idAlumno = document.getElementById("select-users");
        var seleccionado = idAlumno.value;

        console.log(seleccionado);

    });



    

/* 
    //modal creacion de usuarios nuevos
    $("#newUsuario").click(function(){
        clearMessages('.message');
        resetForm("#formUsuario");

        $("#modalUsuario input[name='id']").val('');

        $("#modalUsuario").modal('show');
        $("#modalUsuario #titleModal").text('Crear nuevo usuario');
        $("#modalUsuario button.deleteUsuario").css("display","none");
    });
 

    // accion boton de guardar nuevo usuario
    $(".saveUsuario").click(function () {
        // let id = $("#modalUsuario input[name='id']").val(); // el id se asigna en la DB

        let nombre = $("#modalUsuario input[name='nombre']").val();
        let apellidos = $("#modalUsuario input[name='apellidos']").val();
        let email = $("#modalUsuario input[name='email']").val();

        let route;
        let Usuario = {
            nombre: nombre,
            apellidos: apellidos,
            email: email
        };

        route = routeEvents('routeUsuarioStore');

        console.log(Usuario);
       sendEvent(route,Usuario);
    });
*/

/**
 * boton de nueva actividad para crear actividades de la izquierda
 */
    $("#newFastEvent").click(function(element){
        clearMessages('.message');
        resetForm("#formFastEvent");

        //recoge los datos según la clase
        //document.getElementsByClassName('fc-entrenador-id')[0].innerHTML;


        /* let id = JSON.parse($(this).attr('fc-entrenador'));
        console.log(id); */
        $("#modalFastEvent input[name='id']").val('');
        $("#modalFastEvent input[name='tutor_id']").val(document.getElementsByClassName('fc-entrenador-id')[0].innerHTML);
        $("#modalFastEvent").modal('show');
        $("#modalFastEvent #titleModal").text('Crear nueva actividad');
        $("#modalFastEvent button.deleteFastEvent").css("display","none");

    });

/**
 * modal al clicar sobre una de las actividades de la izquierda
 */
    $('.fc-event').click(function(){
        clearMessages('.message');
        resetForm("#formFastEvent");

        let Event = JSON.parse($(this).attr('data-event'));
        console.log(Event);
        $('#modalFastEvent').modal('show');
        $("#modalFastEvent #titleModal").text('Modificar actividad');
        $("#modalFastEvent button.deleteFastEvent").css("display","flex");

        $("#modalFastEvent input[name='id']").val(Event.id);
        $("#modalFastEvent input[name='tutor_id']").val(Event.tutor_id);
        $("#modalFastEvent input[name='title']").val(Event.title);
        $("#modalFastEvent input[name='start']").val(Event.start);
        $("#modalFastEvent input[name='end']").val(Event.end);
        $("#modalFastEvent input[name='color']").val(Event.color);
        $("#modalFastEvent textarea[name='description']").val(Event.description);

    });
    
/*
    //modificacion de usuarios
    $('.fc-usuario').click(function(){
        clearMessages('.message');
        resetForm("#formFastEvent");

        let Event = JSON.parse($(this).attr('data-event'));
        console.log(Event);
        $('#modalUsuario').modal('show');
        $("#modalUsuario #titleModal").text('Modificar usuario');
        $("#modalUsuario button.deleteFastEvent").css("display","flex");

        ///////////////////////////////////////////////////////////////////
        $("#modalFastEvent input[name='id']").val(Event.id);
        $("#modalFastEvent input[name='tutor_id']").val(Event.tutor_id);
        $("#modalFastEvent input[name='title']").val(Event.title);
        $("#modalFastEvent input[name='start']").val(Event.start);
        $("#modalFastEvent input[name='end']").val(Event.end);
        $("#modalFastEvent input[name='color']").val(Event.color);
        $("#modalFastEvent textarea[name='description']").val(Event.description); 
        //////////////////////////////////////////////////////////////////
    });
*/

    $(".saveFastEvent").click(function () {

        let id = $("#modalFastEvent input[name='id']").val();

        let title = $("#modalFastEvent input[name='title']").val();
        let description = $("#modalFastEvent textarea[name='description']").val();
        let tutor_id = $("#modalFastEvent input[name='tutor_id']").val();

        let FastEvent = {
            tutor_id:tutor_id,
            act_title: title,
            act_description: description,
        };

        let route;

        if(id == ''){
            route = routeEvents('routeFastEventStore');
        }else{
            route = routeEvents('routeFastEventUpdate');
            FastEvent.id = id;
            FastEvent._method = 'PUT';
        }
        //console.log(FastEvent);

        sendEvent(route,FastEvent);
    });


    $(".deleteFastEvent").click(function () {

        let id = $("#modalFastEvent input[name='id']").val();


        let Event = {
            id: id,
            _method: 'DELETE'
        };

        let route = routeEvents('routeFastEventDelete');

        sendEvent(route,Event);

    });


    
/**
 * boton de borrado de eventos del calendario
 */
    $(".deleteEvent").click(function(){
        
        let id = $("#modalCalendar input[name='id']").val();

        let Event = {
            id:id,
            _method: 'DELETE'
        };

        let route = routeEvents('routeEventDelete');
        sendEvent(route,Event);
    });

/**
 * boton de guardado de eventos del calendario
 */
    $(".saveEvent").click(function(){

        let id = $("#modalCalendar input[name='id']").val();

        let tutor_id = $("#modalCalendar input[name='tutor_id']").val(); //

        let alumno_id = $("#modalCalendar input[name='alumno_id']").val(); //

        let title = $("#modalCalendar input[name='title']").val();
        
        let start = moment($("#modalCalendar input[name='start']").val(),"DD-MM-YYYY HH:mm:ss").format("YYYY-MM-DD HH:mm:ss");
        
        let end = moment($("#modalCalendar input[name='end']").val(),"DD-MM-YYYY HH:mm:ss").format("YYYY-MM-DD HH:mm:ss");

        //let color =  $("#modalCalendar input[name='color']").val();
        var radioValue = $("#modalCalendar input[name='color']:checked").val();
        //let color = $("#modalCalendar input[name='color']").val();
        let description = $("#modalCalendar textarea[name='description']").val();

        let Event = {
            tutor_id: tutor_id,
            alumno_id:alumno_id,
            title: title,
            start: start,
            end: end,
            color: radioValue,
            description: description,
        };

        //console.log(routeEvents ('routeEventStore'));
        let route;
        // faltaria añadir los id de alumno y tutor
        if(id == ''){
            route = routeEvents('routeEventStore');
        }else{
            route = routeEvents('routeEventUpdate');
            Event.id = id;
            Event._method = 'PUT';
        }
        //console.log(Event);
        sendEvent(route, Event);
    });


});

function sendEvent(route,data_){

    $.ajax({
        url:route,
        data:data_,
        method:'POST',
        dataType:'json',
        success:function(json){

            if(json){
               location.reload();
               //objCalendar.refetchEvents();
            }
        },
        error:function (json) {

            let responseJSON = json.responseJSON.errors;

            $(".message").html(loadErrors(responseJSON));
        }
    })
}

/* function filterEvents(){
    var idAlumno = document.getElementById("select-users");
    var seleccionado = idAlumno.value;

    console.log(seleccionado);

} */

function loadErrors(response){

    let boxAlert = `<div class="alert alert-danger">`;

    for (let fields in response){
        boxAlert += `<span>${response[fields]}</span><br/>`;
    }

    boxAlert += `</div>`;

    return boxAlert.replace(/\,/g,"<br/>");
}


function routeEvents(route){
    return document.getElementById('calendar').dataset[route];
}

function clearMessages(element){
    $(element).text('');
}
/**
 * Limpia el formulario
 * @param {} form 
 */
function resetForm(form){
    $(form)[0].reset();
}