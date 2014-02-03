<?php include('auth.php'); ?>
<?php

  session_start();

  include("config.php");

  $get_sql = "SELECT * FROM `zusabs` ORDER BY id DESC";

  $req = mysql_query($get_sql) or die("Oh nein !<br>".$get_sql."<br>".mysql_error());

  $zusagen = array();
  $absagen = array();

  while( $data = mysql_fetch_array($req) ) {

    if ($data["auswahl"] == 1) {
      array_push($zusagen, $data["first_name"].' '.$data["last_name"]); 
    }

    if ($data["auswahl"] == 0) {
      array_push($absagen, $data["first_name"].' '.$data["last_name"]);
    }

  };

  setlocale(LC_TIME, "de_DE");

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
    <div><?php echo strftime('%eter %B %Y'); ?></div>
  </div>
</header>
<main>
  <h2>Triff deine Auswahl</h2>
  <div>
    <form action="choose.php" method="POST" class="choose">
      <input type="radio" name="auswahl" value="1">
      <input type="radio" name="auswahl" value="0">
    </form>
  </div>
  <div>
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
</main>
</body>
<script type="text/javascript" src="script.js"></script>
</html>