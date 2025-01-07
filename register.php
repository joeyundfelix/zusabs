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


    $user_first_name = $_POST["user_first_name"];
    $user_last_name  = $_POST["user_last_name"];
    $user_email      = $_POST["user_email"];
    $user_password   = $_POST["user_password"];

    if (isset($user_first_name, $user_last_name, $user_email, $user_password)) {

      $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

      try {
        $insert_user_sql = "INSERT OR IGNORE INTO user (user_id, user_first_name, user_last_name, user_email, user_password) VALUES (NULL, :user_first_name, :user_last_name, :user_email, :user_password)";
        $stmt = $pdo->prepare($insert_user_sql);
        $stmt->execute([
          ':user_first_name' => $user_first_name,
          ':user_last_name'  => $user_last_name,
          ':user_email'      => $user_email,
          ':user_password'   => $hashed_password
        ]);        
      } catch (PDOException $e) {
        die("S**t, das war wohl nix <br>" . $e->getMessage());
      }
    }
    
    header('Location: '.constant("SITE_ROOT").'login.php');
    exit;

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
  <h2>Registrieren <span class="or">oder <a href="login.php">einloggen</a></span></h2>
  <div>
    <form action="register.php" method="POST">
      <label><span>Vorname:</span><input type="text" name="user_first_name" required placeholder="Max" ></label>
      <label><span>Nachname:</span><input type="text" name="user_last_name" required placeholder="Mustermann" ></label>
      <label><span>E-Mail-Adresse:</span><input type="email" name="user_email" required placeholder="me@example.org" ></label>
      <label><span>Passwort:</span><input type="password" required name="user_password" ></label>
      <input type="submit" value="Abschicken">
    </form>
  </div>
</main>
</body>
</html>