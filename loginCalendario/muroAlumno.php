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

    $user = null;
    $events= null;

    //echo(json_encode($results));
    if (count($userResult) > 0) {
      $user = $userResult;

      if(count($resultSet) > 0){
        $events = $resultSet;
        //echo(json_encode($events));
        
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
        console.log(events);

    </script>

    <div id="div-ejercicios"> 
    
        <input type="date" id="input-date" onchange="dateSelected()">

        <script>
            function posSelected(){
                var e = document.getElementById("select-dia");
                var strUser = e.value;
                console.log(strUser);
            }
            function dateSelected(){
                var inputDate = document.getElementById("input-date");
                var date = inputDate.value;
                var divEjerciciosChild = document.getElementById("div-ejercicios-parent");
                if(divEjerciciosChild!=null){
                    divEjerciciosChild.remove();
                }
                //var eventDate = events[1]['start'];

                //var eventDateYmd = eventDate.substring(0,10);

                //console.log(date);
                //console.log(eventDate);
                //console.log(eventDateYmd);

                for (var i in events){
                   // console.log(events[i]);
                    var eventDate = events[i]['start'];
                    var eventDateYmd = eventDate.substring(0,10);

                    console.log(date==eventDateYmd);
                    if(date==eventDateYmd){
                        console.log(events[i]);

                        var element = document.getElementById("div-ejercicios");

                        var elementParent = document.createElement("div");
                        elementParent.setAttribute("id","div-ejercicios-parent");

                        var elementChild =document.createElement("div");
                        elementChild.setAttribute("id","div-ejercicios-child");

                        var divTitle = document.createElement("div");
                        var divDesc = document.createElement("div");
                        var ifrm = document.createElement("iframe");
                        var br = document.createElement("br");


                        var title = document.createTextNode(events[i]['title']);
                        var description = document.createTextNode(events[i]['description']);

                        //var url = document.createTextNode(events[i]['url']);
                        ifrm.setAttribute("src","https://www.youtube.com/embed/dQw4w9WgXcQ");
                        ifrm.setAttribute("class","embed-responsive-item");
                        ifrm.setAttribute("id","iframe-video-ejercicio");
                        ifrm.setAttribute('allowFullScreen', '')
                        ifrm.style.border= "5px solid black";
                        ifrm.style.overflow="hidden";
                        ifrm.style.width="50%";
                        ifrm.style.height="200px";
                        //ifrm.style.border-radius="5%";

                        divTitle.appendChild(title);
                        elementChild.appendChild(divTitle);
                        elementChild.appendChild(br);

                        divDesc.appendChild(description);
                        elementChild.appendChild(divDesc);
                        elementChild.appendChild(br);

                        elementChild.appendChild(ifrm);

                        elementParent.appendChild(elementChild);

                        element.appendChild(elementParent);
                        
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