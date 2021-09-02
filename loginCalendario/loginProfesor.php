<?php

  session_start();

 /*  if (isset($_SESSION['user_id'])) {
    header('Location: /php-login');
  } */
  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT * FROM entrenadores WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];
      header("Location: /php-login");
    } else {
      $message = 'Lo siento, no existe un entrenador con estos datos.';
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

    <h1>Login de Profesores</h1>

    <form action="../calendario/public/" method="GET">
      <input name="email" type="text" placeholder="Introduce tu email">
      <input name="password" type="password" placeholder="Introduce tu contraseña">
      <input type="submit" value="Entrar">
    </form>
  </body>
</html>
