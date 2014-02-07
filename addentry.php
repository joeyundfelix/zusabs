<?php include('auth.php'); ?>
<?php

  include ('config.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    session_start();

    if ($_SESSION['loggedin']) {
      header('Location: '.constant("SITE_ROOT").'index.php');
      exit;
    }

  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    session_start();

    setlocale(LC_TIME, "de_DE");
    date_default_timezone_set("Europe/Vienna");

    $user_id = $_SESSION["id"];
    $user_first_name = $_SESSION["first_name"];
    $user_last_name = $_SESSION["last_name"];
    $text = $_POST["text"];
    $time = strftime("%e. %B %Y um %R");

    // zeit: jetzige zeit zu eintrag

    if (isset($user_first_name, $user_last_name, $text, $user_id, $time)) {

      $post_sql = "INSERT IGNORE INTO `guestbook` (`id`, `user_id`, `first_name`, `last_name`, `text`, `time`) VALUES (NULL,'$user_id', '$user_first_name', '$user_last_name', '$text', '$time')";

      mysql_query($post_sql) or die("S**t, das war wohl nix <br>".mysql_error()); 

    }

  }

  header('Location: '.constant("SITE_ROOT").'index.php');
  exit;

?>