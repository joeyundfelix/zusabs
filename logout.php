<?php
  session_start();
  session_destroy();

  include("config.php");

  header('Location: '.constant("SITE_ROOT").'login.php');
  exit;
?>