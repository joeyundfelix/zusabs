<?php include('auth.php'); ?>
<?php

  session_start();

  include("config.php");

  $zusabs_sql = "SELECT * FROM `zusabs` ORDER BY id DESC";

  $req_zusabs = mysql_query($zusabs_sql) or die("Oh nein !<br>".$zusabs_sql."<br>".mysql_error());

  $rhodos = array();
  $zakyntos = array();
  $rimini = array();

  while( $data_zusabs = mysql_fetch_array($req_zusabs) ) {

    if ($data_zusabs["auswahl"] == 0) {
      array_push($rhodos, '<span>'.$data_zusabs["first_name"].'</span> <span>'.$data_zusabs["last_name"].'</span>'); 
    }

    if ($data_zusabs["auswahl"] == 1) {
      array_push($zakyntos, '<span>'.$data_zusabs["first_name"].'</span> <span>'.$data_zusabs["last_name"].'</span>');
    }

    if ($data_zusabs["auswahl"] == 2) {
      array_push($rimini, '<span>'.$data_zusabs["first_name"].'</span> <span>'.$data_zusabs["last_name"].'</span>');
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
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
  <title>Maturareise 2015</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="table.css">
  <link rel="stylesheet" href="labels.css">
</head>
<body class="home">
<header>
  <div class=""><h1>Maturareise</h1></div>
  <div class="profile">
    <div class="name">Hallo, <?php echo $_SESSION["first_name"]; ?></div>
    <div class="logout"><a href="logout.php">Abmelden</a></div>
  </div>
</header>
<main>

  <div class="info">
  <h2>Info</h2>
  <table>
  <thead>
    <tr>
      <th></th>
      <th>Rhodos / Zakynthos</th>
      <th>Zakynthos</th>
      <th>Rimini</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Dauer auf Insel</td>
      <td data-ort="Rhodos">7 Tage</td>
      <td data-ort="Zakynthos">10 - 14 Tage</td>
      <td data-ort="Rimini">7 Tage</td>
    </tr>
    <tr>
      <td>Ort</td>
      <td>Rhodos oder Zakynthos, Griechenland</td>
      <td>Zakynthos, Griechenland</td>
      <td>Rimini, Italien</td>
    </tr>
    <tr>
      <td>Unterkunft</td>
      <td data-ort="Rhodos">Hotel</td>
      <td data-ort="Zakynthos">"Strandhaus-Hotel Ding" in Griechenladn <br> Irgendwie in Serbien</td>
      <td data-ort="Rimini">Mehrere Apartments</td>
    </tr>
    <tr>
      <td>Anreise</td>
      <td data-ort="Rhodos">Flug nach Rhodos / Zakynthos</td>
      <td data-ort="Zakynthos">Bus nach Serbien <br> Übernachtung für eine Nacht <br> Flug nach Zakynthos</td>
      <td data-ort="Rimini">Zug (vielleicht während der Nacht) nach Rimini</td>
    </tr>
    <tr>
      <td>Extras</td>
      <td data-ort="Rhodos">All inklusive Hotel</td>
      <td data-ort="Zakynthos">Frühstück inklusive</td>
      <td data-ort="Rimini">kein Flug</td>
    </tr>
    <tr>
      <td>Preis Unterkunft + Anreise + Rückreise</td>
      <td data-ort="Rhodos">ca 700€ – 800€</td>
      <td data-ort="Zakynthos">ca 700€ – 900€</td>
      <td data-ort="Rimini">ca 300€ – 350€</td>
    </tr>
    <tr>
      <td>Link(s)</td>
      <td data-ort="Rhodos"><a href="http://www.lymberia-hotel-in-faliraki.com/">Offizielle Website</a></td>
      <td data-ort="Zakynthos"><a href="http://www.astirhotels.gr/astir-palace-zante/">Offizielle Website</a></td>
      <td data-ort="Rimini"><a href="http://www.booking.com/hotel/it/residence-internazionale.de.html?label=social_sharecenter_facebook&checkin=2015-06-20&checkout=2015-06-27">bei booking.com</a></td>
    </tr>
  </tbody>
  </table>
  </div>


  <div class="choice">
    <h2>Triff deine Auswahl</h2>
    <form action="choose.php" method="POST" class="choose">
      <label class="rhodos" for="rhodos">Rhodos</label>
      <label class="zakyntos" for="zakyntos">Zakynthos</label>
      <label class="rimini" for="rimini">Rimini</label>
      <input type="radio" id="rhodos" name="auswahl" value="0">
      <input type="radio" id="zakyntos" name="auswahl" value="1">
      <input type="radio" id="rimini" name="auswahl" value="2">
    </form>
  </div>
  <div class="list">
    <h2>Wer für ...</h2>
    <ul class="zusage">
      <li>... Rhodos / Zakynthos ist.</li>
      <?php
        for ($i=0; $i < count($rhodos); $i++) { 
          echo "<li>".$rhodos[$i]."</li>";
        }
      ?>
    </ul>
    <ul class="absage">
      <li>... Zakynthos ist.</li>
      <?php
        for ($i=0; $i < count($zakyntos); $i++) { 
          echo "<li>".$zakyntos[$i]."</li>";
        }
      ?>
    </ul>
    <ul class="absage">
      <li>... Rimini ist.</li>
      <?php
        for ($i=0; $i < count($rimini); $i++) {
          echo "<li>".$rimini[$i]."</li>";
        }
      ?>
    </ul>
  </div>
  <div class="guestbook">
    <h2>Diskussion <sup>BETA</sup></h2>
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
