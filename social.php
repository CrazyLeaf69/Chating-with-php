<?php
  include_once 'header.php';
?>

<div class="jumbotron jumbotron-fluid">
        <!-- <img src="images/logo 1.png" alt="LyricsFlow Logo" class="logo"> -->
        <h3>Social database</h1>
      </div>
    </header>

    <!-- <h3>Have you ever heard a song and thought to yourself, what are they actually singing? LyricsFlow is a site where you can lock up a lyrics by searching for it or its artist or even a line in the lyrics</h3> -->
    <div class="container">
      <?php if ($_SESSION['useruid']) {
        echo "Logged in as: " . $_SESSION['useruid'];
      }
      else {
        echo "Not logged in, please log in or register.";
      }?> 
    <div class="col-12 col-sm-9 col-lg-9" id="inputssss">
        <form action="includes/social.inc.php" method="post">
            <input id="input" class="input-lg" type="text" placeholder="Find people..." name="search">
            <button id="searchButton" type="submit" name="submit"><i class="fas fa-search fa-lg"></i></button>
        </form>
      </div><br>
      <div>People Found:</div>
      <div id="ResultList">
        <?php
        if (isset($_SESSION['user']["usersUid"])) {
          $Uid = $_SESSION['user']["usersUid"];
          $starter = $_SESSION['useruid'];
          echo $Uid;
          echo "<form action='includes/conv.inc.php' method='post'>
          <input type='hidden' name='starter' value='" . $starter . "'>
          <input type='hidden' name='reciever' value='" . $Uid . "'>
          <button type='submit' name='submit'>Start Conversation with " . $Uid . "</button>
          </form>";
        }
        else {
          $_SESSION['user'] = "";
          echo "nothing";        
        }
        ?>
      </div><br>
      <div class="showmesages">
        <h4>your conversations:</h4><br>
        <input type='hidden' name='starter' value=''>
        <?php
        require_once 'includes/dbh.inc.php';
        require_once 'includes/functions.inc.php';
        $arrs = view_conversations($conn, $_SESSION['useruid']);
        foreach ($arrs as $arr) {
          echo "Starter: " . $arr["conv_starter"] . " | with: " . $arr["reciever"];
          echo "<br>";
          echo "<form action='conv.php' method='get'>
          <input type='hidden' name='starter' value='" . $arr["conv_starter"] . "'>
          <input type='hidden' name='reciever' value='" . $arr["reciever"] . "'>
          <button type='submit'>go to conversation</button>
          </form>";
        }
        // print_r(message_view($conn));
        ?>
      </div>
    </div>

    <?php
      include_once 'footer.php';
    ?>
    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- egen javascript -->
    <!-- <script src="javascript/index.js"></script> -->

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  </body>
</html>