<?php

  include("config.php");

  session_start();

  if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: '.constant("SITE_ROOT").'login.php');
    exit;
  }
  
?>