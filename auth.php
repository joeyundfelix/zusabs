<?php

  include_once("config.php");

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: '.constant("SITE_ROOT").'login.php');
    exit;
  }
  
?>