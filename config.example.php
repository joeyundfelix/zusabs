<?php

  try {
    // Connect to SQLite database (update the path to your database file)
    $pdo = new PDO('sqlite:db/zusabs.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ensure UTF-8 encoding
    $pdo->exec("PRAGMA encoding = 'UTF-8';");
  } catch (PDOException $e) {
    die("LOL, du bist unfähig. " . $e->getMessage());
  }

  define("SITE_ROOT", "https://zusabs.yourdomain.com/");
  
?>
