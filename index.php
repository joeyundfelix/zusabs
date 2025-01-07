<?php include_once('auth.php'); ?>
<?php

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

  include_once("config.php");

  try {
    $zusabs_sql = "SELECT * FROM `zusabs` ORDER BY id DESC";

    $stmt_zusabs = $pdo->query($zusabs_sql);

    $zusagen = array();
    $absagen = array();

    while( $data_zusabs = $stmt_zusabs->fetch(PDO::FETCH_ASSOC) ) {

      if ($data_zusabs["auswahl"] == 1) {
        array_push($zusagen, $data_zusabs["first_name"].' '.$data_zusabs["last_name"]); 
      }

      if ($data_zusabs["auswahl"] == 0) {
        array_push($absagen, $data_zusabs["first_name"].' '.$data_zusabs["last_name"]);
      }

    };

    $guestbook_sql = "SELECT * FROM `guestbook` ORDER BY id DESC";

    $stmt_guestbook = $pdo->query($guestbook_sql);

  } catch (PDOException $e) {
    die("Oh nein !<br>".$e->getMessage());
  }

  $date = new DateTime();
  $formatterDay = new IntlDateFormatter(
    'de_AT',
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    $date->getTimezone(),
    IntlDateFormatter::GREGORIAN,
    'EEEE' // Day of the week
  );
  $formatterDate = new IntlDateFormatter(
    'de_AT',
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    $date->getTimezone(),
    IntlDateFormatter::GREGORIAN,
    'd. MMMM yyyy' // Day, Month, Year
  );

?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
  <title>Zusage / Absage</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="home">
<header>
  <div class="logo"><h1>Zusage / Absage</h1></div>
  <div class="profile">
    <div class="name">Hallo, <?php echo $_SESSION["first_name"]; ?></div>
    <div class="logout"><a href="logout.php">Abmelden</a></div>
  </div>
  <div class="date">
    <div><?php echo $formatterDay->format($date); ?></div>
    <div><?php echo $formatterDate->format($date); ?></div>
  </div>
</header>
<main>
  <div class="choice">
    <h2>Triff deine Auswahl</h2>
    <form action="choose.php" method="POST" class="choose">
      <label class="zusagen" for="zusagen">Zusagen</label>
      <label class="absagen" for="absagen">Absagen</label>
      <input type="radio" id="zusagen" name="auswahl" value="1">
      <input type="radio" id="absagen" name="auswahl" value="0">
    </form>
  </div>
  <div class="list">
    <h2>Wer nächstes Mal ...</h2>
    <ul class="zusage">
      <li>... da ist.</li>
      <?php
        for ($i=0; $i < count($zusagen); $i++) { 
          echo "<li>".$zusagen[$i]."</li>";
        }
      ?>
    </ul>
    <ul class="absage">
      <li>... nicht da ist.</li>
      <?php
        for ($i=0; $i < count($absagen); $i++) { 
          echo "<li>".$absagen[$i]."</li>";
        }
      ?>
    </ul>
  </div>
  <div class="guestbook">
    <h2>Gästebuch <sup>BETA</sup></h2>
    <form action="addentry.php" method="POST" class="entry">
      <textarea name="text"></textarea>
      <div class="help"><b>Styling: </b>{f} {/f}: Fett, {k} {/k}: Kursiv, {u} {/u}: Unterstrichen </div>
      <input type="submit" value="Eintrag absenden">
    </form>
    <ul>
      <?php
        while( $data_guestbook = $stmt_guestbook->fetch(PDO::FETCH_ASSOC) ) {
          echo "<li>";
          echo "<div class='by'>".$data_guestbook["first_name"]." ".$data_guestbook["last_name"]." sagte am ".$data_guestbook["time"].":</div>";
          echo "<div class='text'>".$data_guestbook["text"]."</div>";
          echo "</li>";
        }
      ?>
    </ul>
  </div>
</main>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
