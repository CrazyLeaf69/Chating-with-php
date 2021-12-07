<?php
  include_once 'header.php';
?>
      <link rel="stylesheet" href="css/test.css" />
    </header>

    <!-- <h3>Have you ever heard a song and thought to yourself, what are they actually singing? LyricsFlow is a site where you can lock up a lyrics by searching for it or its artist or even a line in the lyrics</h3> -->
    <div class="container">
      <?php if ($_SESSION['useruid']) {
        echo "<div id='user' style='display: none;'>Logged in as: ".$_SESSION['useruid']."</div>";
      }
      else {
        echo "Not logged in, please log in or register.";
      }?> 
      </div>
      <div class="showmesages">
        <?php
        // require_once 'includes/dbh.inc.php';
        // require_once 'includes/functions.inc.php';
        // $arrs = message_view($conn, $_SESSION['useruid'], $_GET['reciever']);
        //   echo "<div class='msg-container'>";
        //   foreach ($arrs as $arr) {
        //     echo "<div class='msg'>Message: ".$arr["message"]." | From: ".$arr["from_"]." | To ".$arr["to_"]. " | stamp ".$arr["stamp"]. "</div>";
        //   }
        // echo "</div>";
        ?>
        <div class="B">
          <h4>Your messages:</h4>
          <div class="Scroll height2" id="chatbot">
            <ul id="chat">
            </ul>
          </div>
          <div id="sendbox">
          <!-- action="includes/msg.inc.php" method="post" -->
            <!-- <form> -->
              <input type="text" name="msg" id="reciever" placeholder="<?php
                echo "Send message to " . $_GET["reciever"];?>">
              <input type="hidden" name="from" value="<?php 
              if ($_SESSION['useruid']) {
                echo $_SESSION['useruid'];
              }?>">
              <input type="hidden" name="to" <?php 
                echo "value='" . $_GET["reciever"] . "'";?>>
              <button id="btnSend">send</button>
            <!-- </form> -->
          </div>
        </div>
      </div>
    </div>

    <?php
      include_once 'footer.php';
    ?>
    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- egen javascript -->
    <script src="javascript/conv.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  </body>
</html>