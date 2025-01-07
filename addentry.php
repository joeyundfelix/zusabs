<?php include_once('auth.php'); ?>
<?php

  include_once ('config.php');

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

    $date = new DateTime();
    $formatter = new IntlDateFormatter(
      'de_AT',
      IntlDateFormatter::FULL,
      IntlDateFormatter::NONE,
      "Europe/Vienna",
      IntlDateFormatter::GREGORIAN,
      "d. MMMM yyyy 'um' HH:mm"
    );

    $user_id = $_SESSION["id"];
    $user_first_name = $_SESSION["first_name"];
    $user_last_name = $_SESSION["last_name"];
    $text = $_POST["text"];
    $time = $formatter->format($date);

    // zeit: jetzige zeit zu eintrag

    if (isset($user_first_name, $user_last_name, $text, $user_id, $time) && ($text != "")) {
      
      // verhindern von der nutzung von html tags
      
      $text = str_replace('<', '&lt;', $text);
      $text = str_replace('>', '&gt;', $text);
      
      // kleine styling mölichkeiten ( kursiv, fett, unterstrichen)
      
      $text = str_replace('{f}' , '<b>', $text);
      $text = str_replace('{/f}', '</b>', $text);
      $text = str_replace('{k}' , '<em>', $text);
      $text = str_replace('{/k}', '</em>', $text);
      $text = str_replace('{u}' , '<u>', $text);
      $text = str_replace('{/u}', '</u>', $text);
      
      // standard farben
      
      $text = str_replace('{y}', '<span style="color:yellow">', $text);
      $text = str_replace('{r}', '<span style="color:red">', $text);
      $text = str_replace('{b}', '<span style="color:blue">', $text);
      $text = str_replace('{g}', '<span style="color:green">', $text);
      $text = str_replace('{/y}', '</span>', $text);
      $text = str_replace('{/r}', '</span>', $text);
      $text = str_replace('{/b}', '</span>', $text);
      $text = str_replace('{/g}', '</span>', $text);

      try {
        $post_sql = "INSERT OR IGNORE INTO guestbook (id, user_id, first_name, last_name, text, time) VALUES (NULL, :user_id, :first_name, :last_name, :text, :time)";
        $stmt = $pdo->prepare($post_sql);
        $stmt->execute([
          ':user_id'    => $user_id,
          ':first_name' => $user_first_name,
          ':last_name'  => $user_last_name,
          ':text'       => $text,
          ':time'       => $time
        ]);        
      } catch (PDOException $e) {
        die("S**t, das war wohl nix <br>" . $e->getMessage());
      }

    }

  }

  header('Location: '.constant("SITE_ROOT").'index.php');
  exit;

?>
