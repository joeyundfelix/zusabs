<?php include('auth.php'); ?>
<?php

  include("config.php");

  session_start();

  $user_id = $_SESSION["id"];
  $user_first_name = $_SESSION["first_name"];
  $user_last_name = $_SESSION["last_name"];
  $auswahl = $_POST["auswahl"];

  $delete_sql = "DELETE FROM `zusabs` WHERE `user_id`=$user_id";
  mysql_query($delete_sql);

  if (isset($user_first_name, $user_last_name, $auswahl, $user_id)) {

    $post_sql = "INSERT IGNORE INTO `zusabs` (`id`, `user_id`, `first_name`, `last_name`, `auswahl`) VALUES (NULL,'$user_id', '$user_first_name', '$user_last_name', '$auswahl')";

    mysql_query($post_sql) or die("S**t, das war wohl nix <br>".mysql_error()); 

  }

  header('Location: '.constant("SITE_ROOT").'index.php');
  exit;

?>
