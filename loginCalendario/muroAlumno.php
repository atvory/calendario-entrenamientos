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

    $recordsFrases = $conn->prepare('SELECT * FROM frases_motivadoras');
    $recordsFrases->execute();
    $resultSetFrases = array();
    while($row = $recordsFrases->fetch(PDO::FETCH_ASSOC)){
      $resultSetFrases[]=$row;
    }

    $user = null;
    $events= null;
    $fastEvents = null;
    $frasesMotivadoras = null;

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

      if(count($resultSetFrases)>0){
        $frasesMotivadoras = $resultSetFrases;
        //echo(json_encode($frasesMotivadoras));
      }
      
    } 
    
  }

  //recoge el día para hacer un echo sobre el valor seleccionado en el input date
  $month = date('m');
  $day = date('d');
  $year = date('Y');

  $today = $year . '-' . $month . '-' . $day;
?>
    

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>login calendario</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
      
      @media only screen and (max-device-width: 768px) {
        .col-ejercicios {
          column-count:1;
        }
      }
      
      @media only screen and (min-device-width: 768px){
        .col-ejercicios{
          column-count:2
        }
      }
    </style>

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
        var frasesMotivadoras = <?php echo json_encode($frasesMotivadoras); ?>;
        //console.log(events);
        //console.log(fastEvents);

    </script>

     
    
    <input type="date" id="input-date" value="<?php echo $today; ?>" onchange="dateSelected()">
    <div id="div-alert"></div>
    <div id="div-ejercicios" class="col-ejercicios">
        <script>
            function posSelected(){
                var e = document.getElementById("select-dia");
                var strUser = e.value;
                //console.log(strUser);
            }
            function getRandomRound(min,max){
              var i = Math.random()*(max-min)+min;
              return Math.round(i);
            }

            function getRandomRoundUnique(max){
              var lista = [];



              /* while(lista<max){
                var random = getRandomRound(0,max);
                //console.log(lista);
                //console.log(lista.includes(random));

                if(lista.includes(random)!=true){
                  lista.push(random);
                  console.log("añade "+lista);
                }else{
                  console.log("falla");
                }
              } */

              for(var i = 0; i<=max+(max*10);i++){
                var random = getRandomRound(0,max);
                //console.log(lista);
                //console.log(lista.includes(random));

                if(lista.includes(random)!=true){
                  lista.push(random);
                  //console.log("añade "+lista);
                }else{
                  //console.log("falla");
                }
              }
              //console.log(lista);
              return lista;
            }

            function changeBckgrnd(i){
              var cb = document.getElementById("cb-completed"+i);
              var div = document.getElementById("div-ejercicios-child"+i);
              var divTitle = document.getElementById("div-titulo-actividad"+i);
              var divDesc = document.getElementById("div-desc-actividad"+i);
              var divFrase = document.getElementById("div-frase-motivadora"+i);
              var divCompletado = document.getElementById("div-completed"+i);
              var divButton = document.getElementById("div-button-fb"+i);


              if (cb.checked==true){
                //div.setAttribute("")
                div.style.backgroundColor="green";
                divTitle.style.color="white";
                divDesc.style.color="white";
                divFrase.style.color="transparent";
                divFrase.style.height="0px";
                
                divCompletado.style.color="white";
                divButton.style.backgroundColor="white";
                divButton.style.borderColor="white";
                divButton.style.color="green";

              }else{
                div.style.backgroundColor="white";
                divTitle.style.color="black";
                divDesc.style.color="black";
                divFrase.style.color="rgb(255, 0, 242)";
                divFrase.style.height="19px";
                divCompletado.style.color="black";
                divButton.style.backgroundColor="green";
                divButton.style.borderColor="green";
                divButton.style.color="white";
              }

            }


            function genEvent(element,i,k){

              var elementChild =document.createElement("div");
              elementChild.setAttribute("id","div-ejercicios-child"+i);
              elementChild.setAttribute("class","div-ejercicios-child");

              //averiguar por qué no funciona en hoja de estilo por class ////// <<<<---- estilos
              elementChild.style.boxShadow ="0px 0px 15px rgb(177, 177, 177)";////////////////
              elementChild.style.margin ="25px";/////////////////////////////////////////////
              elementChild.style.border ="2px solid rgb(202,202,202)";/////////////////////////
              elementChild.style.padding ="10px";///////////////////////////////////////////
              elementChild.style.borderRadius ="2%";////////////////////////////////////////

              var elementTable = document.createElement("table");
              var elementTd1 = document.createElement("td");
              var elementTd2 = document.createElement("td");
              elementTd2.style.position="relative";
              elementTd2.style.top="-120px";///////////////////////////////////////////////////
              elementTable.style.width="100%";////////////////////////////////////////////////
              elementTable.style.margin="20px";///////////////////////////////////////////
              
              //generacion de divs ids y clases
              var divTitle = document.createElement("div");
              divTitle.setAttribute("id","div-titulo-actividad"+i);
              divTitle.setAttribute("class","div-titulo-actividad");
              divTitle.style.fontWeight="bold";///////////////////////////////////////////////


              var divDesc = document.createElement("div");
              divDesc.setAttribute("id","div-desc-actividad"+i);
              divDesc.setAttribute("class","div-desc-actividad");

              var divFrase = document.createElement("div");
              divFrase.setAttribute("id","div-frase-motivadora"+i);
              divFrase.setAttribute("class","div-frase-motivadora");

              divFrase.style.color="rgb(255,0,242)"; ///////////////////////////////////////////

              var ifrm = document.createElement("iframe");
              ifrm.setAttribute("class","embed-responsive-item");
              ifrm.setAttribute("id","iframe-video-ejercicio"+i);
              ifrm.setAttribute("class","iframe-video-ejercicio");
              ifrm.setAttribute('allowFullScreen', '');

              ifrm.style.border="5px solid rgb(185, 185, 185)"; ///////////////////////////////
              ifrm.style.overflow="hidden";////////////////////////////////////////////////////
              ifrm.style.width="200px";////////////////////////////////////////////////////////
              ifrm.style.borderRadius="5%";///////////////////////////////////////////////////

              var br = document.createElement("br");

              var divCompleted = document.createElement("div");
              divCompleted.setAttribute("id","div-completed"+i);
              divCompleted.setAttribute("class","div-completed");

              var divFeedback = document.createElement("div");
              divFeedback.setAttribute("id","div-feedback"+i);
              divFeedback.setAttribute("class","div-feedback");
              divFeedback.style.borderRadius="8px";/////////////////////////////////

              //contenidos de las divs
              var frase = document.createTextNode(frasesMotivadoras[k]['frase']);
              var title = document.createTextNode(fastEvents[i]['act_title']);
              var description = document.createTextNode(fastEvents[i]['act_description']);

              var video = fastEvents[i]['video'];
              ifrm.setAttribute("src",video);

              var completedCheckB = document.createElement("input");
              completedCheckB.type="checkbox";
              completedCheckB.setAttribute("id","cb-completed"+i);
              completedCheckB.setAttribute("onclick","changeBckgrnd("+i+")");
              var labelCb= document.createElement("label");
              labelCb.for="checkbox";
              labelCb.innerHTML = "¿Completado?";

              var feedbackInput = document.createElement("textarea");
              feedbackInput.setAttribute("id","textarea-feedback"+i);
              feedbackInput.setAttribute("class","textarea-feedback");
              feedbackInput.setAttribute("placeholder","¿Qué tal ha salido?");
              feedbackInput.style.borderRadius="8px";//////////////////////////////////////////

              var feedbackButton = document.createElement("button");
              feedbackButton.setAttribute("id","div-button-fb"+i);
              feedbackButton.setAttribute("class","div-button-fb");
              feedbackButton.name="completado";
              feedbackButton.innerHTML = "enviar";

              feedbackButton.style.backgroundColor="green";////////////////////////////////////
              feedbackButton.style.borderColor="green";////////////////////////////////////////
              feedbackButton.style.color="white";//////////////////////////////////////////////
              feedbackButton.style.fontFamily="Verdana, Geneva, Tahoma, sans-serif";/////////////
              feedbackButton.style.marginLeft="10px";///////////////////////////////////////////
              feedbackButton.style.borderRadius="8px";////////////////////////////////////////
              

              //asociacion de contenidos y cajas
              divTitle.appendChild(title);
              elementChild.appendChild(divTitle);
              elementChild.appendChild(br);

              divDesc.appendChild(description);
              elementChild.appendChild(divDesc);
              elementChild.appendChild(br);

              
              divFrase.appendChild(frase);
              elementChild.appendChild(divFrase);
              elementChild.appendChild(br);

              elementTd1.appendChild(ifrm);
              //elementTd1.appendChild(br);

              divCompleted.appendChild(labelCb);
              divCompleted.appendChild(completedCheckB);
              elementTd2.appendChild(divCompleted);
              elementTd2.appendChild(br);

              divFeedback.appendChild(feedbackInput);
              divFeedback.appendChild(feedbackButton);
              elementTd2.appendChild(divFeedback);
              

              elementTable.appendChild(elementTd1);
              elementTable.appendChild(elementTd2);
              elementChild.appendChild(elementTable);
              
              element.appendChild(elementChild);
              
            }

            function dateSelected(){
                var inputDate = document.getElementById("input-date");
                var date = inputDate.value;
                var spanAlert = document.getElementById("span-alert");
                var divEjerciciosChild = document.getElementById("div-ejercicios-parent");
                
                if(divEjerciciosChild!=null){
                  divEjerciciosChild.remove();
                }
                if(spanAlert!=null){
                  spanAlert.remove();
                }

                var element = document.getElementById("div-ejercicios");
                /* element.style.border="2px solid grey";
                element.style.padding="10px";
                element.style.borderRadius="5%"; */

                //limpia la caja de los anteriores eventos.
                while(element.firstChild){
                  element.removeChild(element.lastChild);
                }

                for (var i in events){
                  // console.log(events[i]);
                  var eventDate = events[i]['start'];
                  var eventDateYmd = eventDate.substring(0,10);

                  //console.log(date==eventDateYmd);
                  if(date==eventDateYmd){
                      genEvent(element,i);
                      
                  }
                }

                //en caso de día sin registros
                if( element.innerHTML ===""){
                  var elementAlert = document.getElementById("div-alert");
                  var title = document.createElement("span");
                  title.textContent = "Día vacío, eventos random generados:";
                  //title.setAttribute ="id, span-alert";
                  title.setAttribute("id","span-alert");
                  elementAlert.appendChild(title);

                  //array con los id de los fastEvents sin repetir.
                  var idsUniques = null;
                  const max = fastEvents.length-1;
                  idsUniques = getRandomRoundUnique(max);
                  //console.log("ids eventos "+idsUniques);
                  //array con los id de las frases sin repetir.
                  var idsFrases = null;
                  const maxFrases = frasesMotivadoras.lenght-1;
                  idsFrases = getRandomRoundUnique(max);
                  //console.log("ids frases "+idsFrases);
                  

                  //genera 4 eventos random sustituir por el número de eventos random a generar si vacío
                  for(var i = 0; i<4;i++){
                      var random = idsUniques[i];
                      var random2 = idsFrases[i];
                      //console.log("pos array"+idsUniques[i]);
                      genEvent(element,random,random2);
                  }

                }


            }
        </script>
        <script>
            //getRandomRoundUnique(5);
            dateSelected();
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
  <style>
      @media only screen and (max-width: 768px) {
        .col-ejercicios {
          
          column-count:1;
        }
      }
    </style>
</html>