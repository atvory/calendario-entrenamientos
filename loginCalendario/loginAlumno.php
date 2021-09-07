<?php

  session_start();

  
  require 'database.php';
  
  //if (!empty($_POST['email']) && !empty($_POST['password'])) {
  if (!empty($_POST['email'])){
    $records = $conn->prepare('SELECT * FROM usuarios WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    //echo($results);
    $message = '';

    //if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
    if ($results !=null){
      $_SESSION['user_id'] = $results['id'];
      $_SESSION['tutor_id'] = $results['tutor_id'];
      echo(json_encode($results));
      header("Location: /laravel/loginCalendario/muroAlumno.php");
    } else {
      $message = 'Lo siento, no existe un alumno con estos datos.';
    }

  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Login de alumnos</h1>
    
    <form action="loginAlumno.php" method="POST">
      <input name="email" type="text" placeholder="Introduce tu email">
      <!-- <input name="password" type="password" placeholder="Introduce tu contraseña"> -->
      <input type="submit" value="Entrar">
    </form>
  </body>
</html>
