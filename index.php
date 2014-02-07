<?php include('auth.php'); ?>
<?php

  session_start();

  include("config.php");

  $zusabs_sql = "SELECT * FROM `zusabs` ORDER BY id DESC";

  $req_zusabs = mysql_query($zusabs_sql) or die("Oh nein !<br>".$zusabs_sql."<br>".mysql_error());

  $zusagen = array();
  $absagen = array();

  while( $data_zusabs = mysql_fetch_array($req_zusabs) ) {

    if ($data_zusabs["auswahl"] == 1) {
      array_push($zusagen, $data_zusabs["first_name"].' '.$data_zusabs["last_name"]); 
    }

    if ($data_zusabs["auswahl"] == 0) {
      array_push($absagen, $data_zusabs["first_name"].' '.$data_zusabs["last_name"]);
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
    <div><?php echo strftime('%A'); ?></div>
    <div><?php echo strftime('%e. %B %Y'); ?></div>
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
</body>
<script type="text/javascript" src="script.js"></script>
</html>