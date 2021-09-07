<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT * FROM usuarios WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $userResult = $records->fetch(PDO::FETCH_ASSOC);


    $recordsEvents = $conn->prepare('SELECT * FROM events WHERE alumno_id = :id  AND deleted_at is null');
    //SELECT * FROM `events` WHERE `alumno_id` =1 and `deleted_at` is NULL
    $recordsEvents->bindParam(':id', $_SESSION['user_id']);
    $recordsEvents->execute();
    $resultSet = array();
    //$eventsResult = $recordsEvents->fetch(PDO::FETCH_ASSOC);
    while ($row = $recordsEvents->fetch(PDO::FETCH_ASSOC)){
        $resultSet[]=$row;
    }


    $recordsFastEvents = $conn->prepare('SELECT * FROM fast_events WHERE tutor_id =:id AND deleted_at is null');
    $recordsFastEvents->bindParam(':id', $_SESSION['tutor_id']);
    $recordsFastEvents->execute();
    $resultSetFastEvents = array();
    while($row = $recordsFastEvents->fetch(PDO::FETCH_ASSOC)){
      $resultSetFastEvents[]=$row;
    }

    $user = null;
    $events= null;
    $fastEvents = null;

    //echo(json_encode($results));
    if (count($userResult) > 0) {
      $user = $userResult;

      if(count($resultSet) > 0){
        $events = $resultSet;
        //echo(json_encode($events));
        
      }

      if(count($resultSetFastEvents) > 0){
        $fastEvents = $resultSetFastEvents;
        //echo(json_encode($fastEvents));
        
      }
    } 
    
  }
?>
    

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>login calendario</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($user)): ?>
      <br> Hola <?= $user['nombre']; ?>
      <br> Pongámonos a trabajar!
      <br>

    <script type="text/javascript">
        var events = <?php echo json_encode($events); ?>;
        var fastEvents = <?php echo json_encode($fastEvents); ?>;
        //console.log(events);
        //console.log(fastEvents);

    </script>

     
    
    <input type="date" id="input-date" onchange="dateSelected()">
    <div id="div-ejercicios" style="margin:50px;column-count:2">
        <script>
            function posSelected(){
                var e = document.getElementById("select-dia");
                var strUser = e.value;
                console.log(strUser);
            }
            function getRandomRound(min,max){
              var i = Math.random()*(max-min)+min;
              return Math.round(i);
            }

            function genEvent(element,i){

              var elementChild =document.createElement("div");
                      elementChild.setAttribute("id","div-ejercicios-child");
                      elementChild.style.marginBottom="30px";
                      elementChild.style.border="2px solid grey";
                      elementChild.style.borderRadius="5%";

                      var divTitle = document.createElement("div");
                      //divTitle.style.margin="50px";

                      var divDesc = document.createElement("div");
                      var ifrm = document.createElement("iframe");
                      var br = document.createElement("br");

                      var title = document.createTextNode(events[i]['title']);
                      var description = document.createTextNode(events[i]['description']);

                      ifrm.setAttribute("src","https://www.youtube.com/embed/dQw4w9WgXcQ");
                      ifrm.setAttribute("class","embed-responsive-item");
                      ifrm.setAttribute("id","iframe-video-ejercicio");
                      ifrm.setAttribute('allowFullScreen', '')
                      ifrm.style.border= "5px solid black";
                      ifrm.style.overflow="hidden";
                      ifrm.style.width="50%";
                      ifrm.style.height="200px";
                      ifrm.style.borderRadius="5%";


                      divTitle.appendChild(title);
                      elementChild.appendChild(divTitle);
                      elementChild.appendChild(br);

                      divDesc.appendChild(description);
                      elementChild.appendChild(divDesc);
                      elementChild.appendChild(br);

                      elementChild.appendChild(ifrm);

                      element.appendChild(elementChild);
            }

            function dateSelected(){
                var inputDate = document.getElementById("input-date");
                var date = inputDate.value;
                var divEjerciciosChild = document.getElementById("div-ejercicios-parent");
                if(divEjerciciosChild!=null){
                    divEjerciciosChild.remove();
                }

                var element = document.getElementById("div-ejercicios");
                element.style.border="2px solid grey";
                element.style.padding="10px";
                element.style.borderRadius="5%";

                //limpia la caja de los anteriores eventos.
                while(element.firstChild){
                  element.removeChild(element.lastChild);
                }

                for (var i in events){
                  // console.log(events[i]);
                  var eventDate = events[i]['start'];
                  var eventDateYmd = eventDate.substring(0,10);

                  console.log(date==eventDateYmd);
                  if(date==eventDateYmd){
                      genEvent(element,i);
                      
                  }
                }

                //en caso de día sin registros
                if( element.innerHTML ===""){
                  var title = document.createTextNode("día vacío, eventos random:");
                  
                  element.appendChild(title);

                  var ids = null;
                  const min = 0;
                  const max = fastEvents.length-1;

                  //genera 4 eventos random
                  for(var i = 0; i<4;i++){
                      var random = getRandomRound(min,max);

                      genEvent(element,random);
                  }

                }


            }
        </script>

    </div>



      <a href="logout.php">
        Salir
      </a>
      




















    <?php else: ?>
      <h1>¿Eres?</h1>

      <a href="loginProfesor.php">Profesor</a> o
      <a href="loginAlumno.php">Alumno</a>
    <?php endif; ?>
  </body>
</html>