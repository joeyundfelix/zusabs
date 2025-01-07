<?php

  include_once("config.php");

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
      header('Location: '.constant("SITE_ROOT").'index.php');
      exit;
    }

  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    try {
      $sql = "SELECT * FROM `user` WHERE user_email = :user_email";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ':user_email' => $user_email,
      ]);
      
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if ($result) {
        $user_password_db = $result['user_password'];
        $user_id = $result['user_id'];
        $user_first_name = $result['user_first_name'];
        $user_last_name = $result['user_last_name'];
        
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
            } else {
              header('HTTP/1.1 303 See Other');
            }
          }

          header('Location: '.constant("SITE_ROOT").'index.php');
          exit;

        }
      }
    } catch (PDOException $e) {
      die("Error: " . $e->getMessage());
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
<div class="logo"><h1>Zusage / Absage</h1></div>
<div class="datum">Datum</div>
<div class="profile">Name</div>
</header>
<main>
<h2>Einloggen <span class="or">oder <a href="register.php">registrieren</a></span></h2>
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