<?php

  include("config.php");

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    session_start();

    if ($_SESSION['loggedin']) {
      header('Location: '.constant("SITE_ROOT").'index.php');
      exit;
    }

  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    session_start();

    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $sql = "SELECT * FROM `user` WHERE user_email='$user_email'";

    $req = mysql_query($sql) or die($error = true);

    $result = mysql_fetch_row($req);

    $user_password_db = $result[4];
    $user_id = $result[0];
    $user_first_name = $result[1];
    $user_last_name = $result[2];

    if (!isset($error) || !$error) {

      // Benutzername und Passwort werden überprüft
      if ($user_password == $user_password_db) {

        $_SESSION['loggedin'] = true;

        $_SESSION['id'] = $user_id;
        $_SESSION['last_name'] = $user_last_name;
        $_SESSION['first_name'] = $user_first_name;

        // Weiterleitung zur geschützten Startseite
        if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
          if (php_sapi_name() == 'cgi') {
            header('Status: 303 See Other');
          }
          else {
            header('HTTP/1.1 303 See Other');
          }
        }

        header('Location: '.constant("SITE_ROOT").'index.php');
        exit;

      }
    }
    else {

    }
  }

?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
  <title>Zusage / Absage</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="register">
<header>
  <div class="logo"><h1>Logo</h1></div>
  <div class="datum">Datum</div>
  <div class="profile">Name</div>
</header>
<main>
  <h2>Einloggen</h2>
  <div>
    <form action="login.php" method="POST">
      <label><span>E-Mail-Adresse:</span><input type="email" name="user_email" required placeholder="me@example.org" ></label>
      <label><span>Passwort:</span><input type="password" required name="user_password" ></label>
      <input type="submit" value="Anmelden">
    </form>
  </div>
</main>
</body>
</html>