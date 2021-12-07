<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>LyricsFlow</title>
    <meta charset="utf-8">
    <meta name="description" content="search for lyrics">
    <meta name="keywords" content="LyricsFlow, Lyrics">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>

    <link rel="stylesheet" href="css/style.css" />

    <script src="https://kit.fontawesome.com/70fb894d64.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <header>
    <nav class="navbar navbar-expand-md">
        <button class="navbar-toggler" id="burgerbtn" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="fas fa-bars"></span>
        </button>
        <div class="nav navbar-toggler">
          <?php
            if (isset($_SESSION["useruid"])) {
              echo "<div class='navbar-brand'>".$_SESSION["useruid"]."</div>";
              echo "<a href='profile.php' class='link navbar-brand'>Profile</a>";
              echo "<a href='includes/logout.inc.php' class='link navbar-brand'>Log out</a>";
            }
            else {
              echo "<a href='signup.php' class='link navbar-brand'>Sign up</a>";
              echo "<a href='login.php' class='link navbar-brand'>Log in</a>";
            }

          ?>
        </div>
      
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <!-- <span class="sr-only">(current)</span> -->
              <a href="index.php" class="link nav-link navbar-brand">Home</a>
            </li>
            <li class="nav-item">
              <!-- <span class="sr-only">(current)</span> -->
              <a href="social.php" class="link nav-link navbar-brand">Social</a>
            </li>
          </ul>
          <div class="nav-toggle">
            <?php
              if (isset($_SESSION["useruid"])) {
                echo "<div class='navbar-brand'>".$_SESSION["useruid"]."</div>";
                echo "<a href='profile.php' class='link navbar-brand'>Profile</a>";
                echo "<a href='includes/logout.inc.php' class='link navbar-brand'>Log out</a>"; 
              }
              else {
                echo "<a href='signup.php' class='link navbar-brand'>Sign up</a>";
                echo "<a href='login.php' class='link navbar-brand'>Log in</a>";
              }

            ?>
          </div>
          </div>
      </nav>