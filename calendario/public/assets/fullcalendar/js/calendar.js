
  document.addEventListener('DOMContentLoaded', function() {
    
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable

    /* initialize the external events
    -----------------------------------------------------------------*/

    var containerEl = document.getElementById('external-events-list');
    
    new Draggable(containerEl, {
      itemSelector: '.fc-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText.trim()
        }
      }
    });

    

    /* initialize the calendar
    -----------------------------------------------------------------*/

    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        displayEventTime: false,
        firstDay:1, //para empezar la semana en lunes (domingo 0)
        navLinks:true, // permite picar en el día y abrirlo
        eventLimit:true, //con muchos eventos aparece un +* y permite abrir un dialog que muestra todos
        selectable:true, //para seleccionar uno o varios días
        /* buttonText: {
        today: "Hoy",
        month: "Mes",
        week: "Semana",
        day: "Día",
        list:"Agenda"
        }, */
        locale:'es',
        editable: true, // permite mover eventos para soltarlos
        droppable: true, // permite soltar eventos encima del calendario
        eventTextColor:'#ffffff', // color textos de las cajas
        drop: function(element) {

          let Event = JSON.parse(element.draggedEl.dataset.event);

          let start = moment(`${element.dateStr} ${Event.start}`).format("YYYY-MM-DD HH:mm:ss");
          let end = moment(`${element.dateStr} ${Event.end}`).format("YYYY-MM-DD HH:mm:ss");

          // recoge el id del usuario seleccionado en el dd de usuarios
          var idAlumno = document.getElementById("select-users");
          var seleccionado = idAlumno.value;

          Event.start = start;
          Event.end = end;

          delete Event.id; //borra la id del evento prefijado para que coja la AI en el DB
          //console.log(Event);
          let newEvent = {
            tutor_id:Event.tutor_id,
            alumno_id:seleccionado,
            title: Event.title,
            id: Event.id,
            start: start,
            end: end,
            color:Event.color,
            description:Event.description,
            tipo:Event.tipo,
            video:Event.video
          };
          console.log("Evento soltado "+Event.tipo);
          console.log("newEvent creado "+newEvent.tipo);
          console.log("Evento soltado "+Event.video);
          console.log("newEvent creado "+newEvent.video);
 
          if(seleccionado!=0){
            
            sendEvent(routeEvents('routeEventStore'), newEvent);
          }
          else{
            alert("No has seleccionado alumno, el evento no se guardará.")
            location.reload();
          }

          //sendEvent(routeEvents('routeEventStore'), Event);
          //let Event = JSON.parse(element.draggedEl.dataset.event);
          //console.log(Event); // para comprobar el JSON
          //console.log(newEvent); // para comprobar el JSON
        },


        eventDrop: function(element){
          //modificacion de un evento al soltarlo sobre una nueva fecha
          let start = moment(element.event.start).format("YYYY-MM-DD HH:mm:ss");
          let end = moment(element.event.end).format("YYYY-MM-DD HH:mm:ss");
          
          var idAlumno = document.getElementById("select-users");
          var seleccionado = idAlumno.value;

          if(seleccionado!=0){
            let newEvent = {
              _method:'PUT',
              title: element.event.title,
              id: element.event.id,
              start: start,
              end: end
            };
            sendEvent(routeEvents('routeEventUpdate'),newEvent,calendar);
          }else{
            alert("No has seleccionado alumno, el evento no se guardará.")
            location.reload();
          }

          //console.log(newEvent); 

          sendEvent(routeEvents('routeEventUpdate'),newEvent,calendar);
        },

        eventResize: function(element){
          //modificacion de un evento al soltarlo sobre una nueva fecha
          //let start = moment(element.event.start).format("YYYY-MM-DD HH:mm:ss");
          //let end = moment(element.event.end).format("YYYY-MM-DD HH:mm:ss");
          element.resizable = false;
          /* let newEvent = {
            _method:'PUT',
            title: element.event.title,
            id: element.event.id,
            start: start,
            end: end
          }; */
          /* 
          console.log(start);
          console.log(end);
          console.log(newEvent); */
        
          //sendEvent(routeEvents('routeEventUpdate'),newEvent,calendar);
        },

        eventClick: function(element){
        //alert('event click');
          clearMessages('.message');
          resetForm('#formActividad');
          $("#modalCalendar").modal('show');
          $("#modalCalendar #titleModal").text('Modificar actividad');
          $("#modalCalendar button.deleteEvent").css('display','flex');

          let title = element.event.title;
          $("#modalCalendar input[name='title']").val(title);
          
          let id = element.event.id;
          $("#modalCalendar input[name='id']").val(id);

          let tutor_id = element.event.extendedProps.tutor_id;   //
          $("#modalCalendar input[name='tutor_id']").val(tutor_id);

          let alumno_id = element.event.extendedProps.alumno_id;   //
          $("#modalCalendar input[name='alumno_id']").val(alumno_id);

          let start = moment(element.event.start).format("DD/MM/YYYY HH:mm:ss");
          $("#modalCalendar input[name='start']").val(start);

          let end = moment(element.event.end).format("DD/MM/YYYY HH:mm:ss");
          $("#modalCalendar input[name='end']").val(end);

          /* let color = element.event.backgroundColor;
          $("#modalCalendar input[name='color']").val(color); */

          let video = element.event.extendedProps.video;
          $("#modalCalendar input[name='video-link']").val(video);

          let tipo = element.event.extendedProps.tipo;
          $("#modalCalendar select[name='select-tipo']").val(tipo);

          let description = element.event.extendedProps.description;
          $("#modalCalendar textarea[name='description']").val(description);

          console.log("Clic en elemento de calendario calendar.js "+ element.event.extendedProps.tipo); // <--------------- falta en el evento 

        },
        
        select: function(element){
          //alert('select');
          clearMessages('.message');
          resetForm('#formActividad');


          const tiempoTranscurrido = Date.now();
          const hoy = new Date(tiempoTranscurrido);
          //hoy.toLocaleDateString();

          function formatDate(date) {
            var d = new Date(date),
                day = '' + d.getDate(),
                month = '' + (d.getMonth() + 1),
                year = d.getFullYear();
        
            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;
        
            //return [year, month, day].join('/');
            return year+month+day;
          }
         
          let fechaHoy = formatDate(hoy);
          //console.log(fechaHoy);

          let start = moment(element.start).format("YYYYMMDD");
          //console.log(start);

          if(fechaHoy>start)
          {
            alert("No puedes crear eventos en días pasados.");
          }
          else{


            // recoge el id del usuario seleccionado en el dd de usuarios
            var idAlumno = document.getElementById("select-users");
            var seleccionado = idAlumno.value;
            if(seleccionado!=0){
              $("#modalCalendar").modal('show');
              $("#modalCalendar #titleModal").text('Nueva Actividad');
              $("#modalCalendar button.deleteEvent").css('display','none');

              $("#modalCalendar input[name='alumno_id']").val(seleccionado); // valor index de la caja de usuarios

              let start = moment(element.start).format("DD/MM/YYYY HH:mm:ss");
              $("#modalCalendar input[name='start']").val(start);
              let end = moment(element.end).format("DD/MM/YYYY HH:mm:ss");
              $("#modalCalendar input[name='end']").val(end);

              
              //$("#modalCalendar input[name='color']").val("#3eb579");

              $("#modalCalendar input[name='tutor_id']").val(document.getElementsByClassName('fc-entrenador-id')[0].innerHTML); 

              //console.log(document.getElementsByClassName('fc-entrenador-id')[0].innerHTM);
              calendar.unselect();
            }else{
              alert("Debes seleccionar un alumno para poder crear un evento");
            }
          }
        },
        events: routeEvents ('routeLoadEvents'),
          
    });
    objCalendar=calendar;
    calendar.render();
    





    $('#select-users').on('change',function(){
      calendar.destroy();
      var idAlumno = document.getElementById("select-users");
      var seleccionado = idAlumno.value;

      //calendar.getEvents().forEach(event=>event.remove());

      $.get(routeEvents ('routeLoadEvents'))
        .done(data => {
          //console.log(data);
          const parseData = JSON.parse(data);
          //console.log(parseData[1].alumno_id);

          var data_filter;
          if(seleccionado!=0){
            data_filter = parseData.filter( element => element.alumno_id ==seleccionado)
          }else{
            data_filter = parseData;
          }
          /* console.log(data_filter);
          console.log(seleccionado); */

          
      

        var calendar = new Calendar(calendarEl, {
          plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
          header: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
          },
          displayEventTime: false,
          firstDay:1, //para empezar la semana en lunes (domingo 0)
          navLinks:true, // permite picar en el día y abrirlo
          eventLimit:true, //con muchos eventos aparece un +* y permite abrir un dialog que muestra todos
          selectable:true, //para seleccionar uno o varios días
          /* buttonText: {
          today: "Hoy",
          month: "Mes",
          week: "Semana",
          day: "Día",
          list:"Agenda"
          }, */
          locale:'es',
          editable: true, // permite mover eventos para soltarlos
          droppable: true, // permite soltar eventos encima del calendario
          eventTextColor:'#ffffff', // color textos de las cajas
          drop: function(element) {
    
            let Event = JSON.parse(element.draggedEl.dataset.event);
    
            let start = moment(`${element.dateStr} ${Event.start}`).format("YYYY-MM-DD HH:mm:ss");
            let end = moment(`${element.dateStr} ${Event.end}`).format("YYYY-MM-DD HH:mm:ss");
    
            // recoge el id del usuario seleccionado en el dd de usuarios
            var idAlumno = document.getElementById("select-users");
            var seleccionado = idAlumno.value;
    
            Event.start = start;
            Event.end = end;
    
            delete Event.id; //borra la id del evento prefijado para que coja la AI en el DB
            console.log(Event);
            let newEvent = {
              tutor_id:Event.tutor_id,
              alumno_id:seleccionado,
              title: Event.title,
              id: Event.id,
              start: start,
              end: end,
              color:Event.color,
              description:Event.description,
              tipo:Event.tipo,
              video:Event.video
            };
            console.log("Evento soltado "+Event.tipo);
            console.log("newEvent creado "+newEvent.tipo);
            console.log("Evento soltado "+Event.video);
            console.log("newEvent creado "+newEvent.video);
   
            if(seleccionado!=0){
              
              sendEvent(routeEvents('routeEventStore'), newEvent);
            }
            else{
              alert("No has seleccionado alumno, el evento no se guardará.")
              location.reload();
            }
            //sendEvent(routeEvents('routeEventStore'), Event);
            //let Event = JSON.parse(element.draggedEl.dataset.event);
            //console.log(Event); // para comprobar el JSON
            //console.log(newEvent); // para comprobar el JSON
          },
    
    
          eventDrop: function(element){
            //modificacion de un evento al soltarlo sobre una nueva fecha
            let start = moment(element.event.start).format("YYYY-MM-DD HH:mm:ss");
            let end = moment(element.event.end).format("YYYY-MM-DD HH:mm:ss");
            
            let newEvent = {
              _method:'PUT',
              title: element.event.title,
              id: element.event.id,
              start: start,
              end: end
            };
    
            //console.log(newEvent); 
    
            sendEvent(routeEvents('routeEventUpdate'),newEvent,calendar);
          },
    
          eventResize: function(element){
            //modificacion de un evento al soltarlo sobre una nueva fecha
            //let start = moment(element.event.start).format("YYYY-MM-DD HH:mm:ss");
            //let end = moment(element.event.end).format("YYYY-MM-DD HH:mm:ss");
            element.resizable = false;
            /* let newEvent = {
              _method:'PUT',
              title: element.event.title,
              id: element.event.id,
              start: start,
              end: end
            }; */
            /* 
            console.log(start);
            console.log(end);
            console.log(newEvent); */
          
            //sendEvent(routeEvents('routeEventUpdate'),newEvent,calendar);
          },
    
          eventClick: function(element){
            //alert('event click');
            clearMessages('.message');
            resetForm('#formActividad');
            $("#modalCalendar").modal('show');
            $("#modalCalendar #titleModal").text('Modificar actividad');
            $("#modalCalendar button.deleteEvent").css('display','flex');
    
           console.log(element); //<- para mostrar lo que le llega a la consola al hacer click
            let title = element.event.title;
            $("#modalCalendar input[name='title']").val(title);
    
            let id = element.event.id;
            $("#modalCalendar input[name='id']").val(id);
    
            let tutor_id = element.event.extendedProps.tutor_id;   //
            $("#modalCalendar input[name='tutor_id']").val(tutor_id);
    
            let alumno_id = element.event.extendedProps.alumno_id;   //
            $("#modalCalendar input[name='alumno_id']").val(alumno_id);
    
            let start = moment(element.event.start).format("DD/MM/YYYY HH:mm:ss");
            $("#modalCalendar input[name='start']").val(start);
    
            let end = moment(element.event.end).format("DD/MM/YYYY HH:mm:ss");
            $("#modalCalendar input[name='end']").val(end);
    
            /* let color = element.event.backgroundColor;
            $("#modalCalendar input[name='color']").val(color); */
    
            let description = element.event.extendedProps.description;
            $("#modalCalendar textarea[name='description']").val(description);

            let tipo = element.event.extendedProps.tipo; 
            $("#modalCalendar select[name='select-tipo']").val(tipo);

            let video = element.event.extendedProps.video;
            $("#modalCalendar input[name='video-link']").val(video);

            console.log("Clic en elemento de calendario calendar.js "+element);

          },
          
          select: function(element){
            //alert('select');
            clearMessages('.message');
            resetForm('#formActividad');
  
  
            const tiempoTranscurrido = Date.now();
            const hoy = new Date(tiempoTranscurrido);
            //hoy.toLocaleDateString();
  
            function formatDate(date) {
              var d = new Date(date),
                  day = '' + d.getDate(),
                  month = '' + (d.getMonth() + 1),
                  year = d.getFullYear();
          
              if (month.length < 2) 
                  month = '0' + month;
              if (day.length < 2) 
                  day = '0' + day;
          
              //return [year, month, day].join('/');
              return year+month+day;
            }
           
            let fechaHoy = formatDate(hoy);
            //console.log(fechaHoy);
  
            let start = moment(element.start).format("YYYYMMDD");
            //console.log(start);
  
            if(fechaHoy>start)
            {
              alert("No puedes crear eventos en días pasados.");
            }
            else{
  
  
              // recoge el id del usuario seleccionado en el dd de usuarios
              var idAlumno = document.getElementById("select-users");
              var seleccionado = idAlumno.value;
              if(seleccionado!=0){
                $("#modalCalendar").modal('show');
                $("#modalCalendar #titleModal").text('Nueva Actividad');
                $("#modalCalendar button.deleteEvent").css('display','none');
  
                $("#modalCalendar input[name='alumno_id']").val(seleccionado); // valor index de la caja de usuarios
  
                let start = moment(element.start).format("DD/MM/YYYY HH:mm:ss");
                $("#modalCalendar input[name='start']").val(start);
                let end = moment(element.end).format("DD/MM/YYYY HH:mm:ss");
                $("#modalCalendar input[name='end']").val(end);
  
                //$("#modalCalendar input[name='color']").val("#3eb579");

                $("#modalCalendar input[name='tutor_id']").val(document.getElementsByClassName('fc-entrenador-id')[0].innerHTML); 
  
                //console.log(document.getElementsByClassName('fc-entrenador-id')[0].innerHTM);
                calendar.unselect();
              }else{
                alert("Debes seleccionar un alumno para poder crear un evento");
              }
            }
          },
          events:data_filter,  // anadir el routeLoadEvents ¿pasar id por aqui?
          
      });
      objCalendar=calendar;
      calendar.render();
      $('#select-users').on('change',function(){
        
        calendar.destroy();
      });
    });
    });



  });
  

  
  
//console.log(routeEvents ('routeLoadEvents'));
 

