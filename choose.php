<?php include_once('auth.php'); ?>
<?php

  include_once("config.php");

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

  $user_id = $_SESSION["id"];
  $user_first_name = $_SESSION["first_name"];
  $user_last_name = $_SESSION["last_name"];
  $auswahl = $_POST["auswahl"];

  if (isset($user_first_name, $user_last_name, $auswahl, $user_id)) {

    try {
      // Begin transaction
      $pdo->beginTransaction();

      // Delete existing records
      $delete_sql = "DELETE FROM zusabs WHERE user_id = :user_id";
      $stmt = $pdo->prepare($delete_sql);
      $stmt->execute([':user_id' => $user_id]);

      // Insert new record
      $post_sql = "INSERT OR IGNORE INTO zusabs (id, user_id, first_name, last_name, auswahl) VALUES (NULL, :user_id, :first_name, :last_name, :auswahl)";
      $stmt = $pdo->prepare($post_sql);
      $stmt->execute([
        ':user_id'    => $user_id,
        ':first_name' => $user_first_name,
        ':last_name'  => $user_last_name,
        ':auswahl'    => $auswahl
      ]);

      // Commit transaction
      $pdo->commit();

    } catch (PDOException $e) {
      // Rollback transaction if an error occurs
      $pdo->rollBack();
      die("S**t, das war wohl nix <br>" . $e->getMessage());
    }

  }

  header('Location: '.constant("SITE_ROOT").'index.php');
  exit;

?>
