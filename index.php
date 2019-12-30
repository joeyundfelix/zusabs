<?php include('auth.php'); ?>
<?php

  session_start();

  include("config.php");

  $zusabs_sql = "SELECT * FROM `zusabs` ORDER BY id DESC";

  $req_zusabs = mysql_query($zusabs_sql) or die("Oh nein !<br>".$zusabs_sql."<br>".mysql_error());

  $picknick = array();
  $prater = array();
  $kletterpark = array();
  $linz = array();
  $folter = array();
  $schoenbrunn = array();
  $tiergarten = array();

  while( $data_zusabs = mysql_fetch_array($req_zusabs) ) {

    if ($data_zusabs["auswahl"] == 0) {
      array_push($picknick, $data_zusabs["first_name"].' '.$data_zusabs["last_name"]); 
    }

    if ($data_zusabs["auswahl"] == 1) {
      array_push($prater, $data_zusabs["first_name"].' '.$data_zusabs["last_name"]);
    }

    if ($data_zusabs["auswahl"] == 2) {
      array_push($kletterpark, $data_zusabs["first_name"].' '.$data_zusabs["last_name"]);
    }

    if ($data_zusabs["auswahl"] == 3) {
      array_push($linz, $data_zusabs["first_name"].' '.$data_zusabs["last_name"]);
    }

    if ($data_zusabs["auswahl"] == 4) {
      array_push($folter, $data_zusabs["first_name"].' '.$data_zusabs["last_name"]);
    }

    if ($data_zusabs["auswahl"] == 5) {
      array_push($schoenbrunn, $data_zusabs["first_name"].' '.$data_zusabs["last_name"]);
    }

    if ($data_zusabs["auswahl"] == 6) {
      array_push($tiergarten, $data_zusabs["first_name"].' '.$data_zusabs["last_name"]);
    }

  };

  $guestbook_sql = "SELECT * FROM `guestbook` ORDER BY id DESC";

  $req_guestbook = mysql_query($guestbook_sql) or die("Oh nein !<br>".$guestbook_sql."<br>".mysql_error());

  setlocale(LC_TIME, "de_DE");
  date_default_timezone_set("Europe/Vienna")

?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
  <title>3HD</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="home">
<header>
  <div class=""><h1>3HD</h1></div>
  <div class="profile">
    <div class="name">Hallo, <?php echo $_SESSION["first_name"]; ?></div>
    <div class="logout"><a href="logout.php">Abmelden</a></div>
  </div>
  <div class="date">
    <div><?php echo strftime('%A'); ?></div>
    <div><?php echo strftime('%e. %B %Y'); ?></div>
  </div>
</header>
<main>
  <div class="choice">
    <h2>Triff deine Auswahl</h2>
    <form action="choose.php" method="POST" class="choose">
      <label class="picknick"    for="picknick">Picknick</label>
      <label class="prater"      for="prater">Prater</label>
      <label class="kletterpark" for="kletterpark">Kletterpark</label>
      <label class="linz"        for="linz">Linz</label>
      <label class="folter"      for="folter">Folter</label>
      <label class="schoenbrunn" for="schoenbrunn">Schönbrunn</label>
      <label class="tiergarten"  for="tiergarten">Tiergarten</label>
      <input type="radio" id="picknick"    name="auswahl" value="0">
      <input type="radio" id="prater"      name="auswahl" value="1">
      <input type="radio" id="kletterpark" name="auswahl" value="2">
      <input type="radio" id="linz"        name="auswahl" value="3">
      <input type="radio" id="folter"      name="auswahl" value="4">
      <input type="radio" id="schoenbrunn" name="auswahl" value="5">
      <input type="radio" id="tiergarten"  name="auswahl" value="6">
    </form>
  </div>
  <div class="list">
    <h2>Wer was will.</h2>
    <ul class="picknick">
      <li>Picknick</li>
      <?php
        for ($i=0; $i < count($picknick); $i++) { 
          echo "<li>".$picknick[$i]."</li>";
        }
      ?>
    </ul>
    <ul class="prater">
      <li>Prater</li>
      <?php
        for ($i=0; $i < count($prater); $i++) { 
          echo "<li>".$prater[$i]."</li>";
        }
      ?>
    </ul>
    <ul class="zusage">
      <li>Kletterpark</li>
      <?php
        for ($i=0; $i < count($kletterpark); $i++) {
          echo "<li>".$kletterpark[$i]."</li>";
        }
      ?>
    </ul>
    <ul class="zusage">
      <li>Linz</li>
      <?php
        for ($i=0; $i < count($linz); $i++) {
          echo "<li>".$linz[$i]."</li>";
        }
      ?>
    </ul>
    <ul class="zusage">
      <li>Foltermuseum</li>
      <?php
        for ($i=0; $i < count($folter); $i++) {
          echo "<li>".$folter[$i]."</li>";
        }
      ?>
    </ul>
    <ul class="zusage">
      <li>Schönbrunn</li>
      <?php
        for ($i=0; $i < count($schoenbrunn); $i++) {
          echo "<li>".$schoenbrunn[$i]."</li>";
        }
      ?>
    </ul>
    <ul class="zusage">
      <li>Tiergarten</li>
      <?php
        for ($i=0; $i < count($tiergarten); $i++) {
          echo "<li>".$tiergarten[$i]."</li>";
        }
      ?>
    </ul>
  </div>
  <div class="guestbook">
    <h2>Kommentare <sup>BETA</sup></h2>
    <form action="addentry.php" method="POST" class="entry">
      <textarea name="text"></textarea>
      <div class="help"><b>Styling: </b>{f} {/f}: Fett, {k} {/k}: Kursiv, {u} {/u}: Unterstrichen </div>
      <input type="submit" value="Eintrag absenden">
    </form>
    <ul>
      <?php
        while( $data_guestbook = mysql_fetch_array($req_guestbook) ) {
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
