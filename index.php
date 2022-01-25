<?php
  include_once 'header.php';
?>

<div class="jumbotron jumbotron-fluid">
        <h1>Forum For Sheep Skulls</h1>
      </div>
    </header>
    <div class="container">
      <?php
        if (isset($_SESSION["useruid"])) {
          echo "<button id='myBtn'>Make post</button>";
          if (isset($_GET['error'])) {
            if ($_GET['error'] == 'emptypost') {
              echo "<p>Fill in all the fields</p>";
            }
          }
        }
        else {
          echo "<h4>Log in to make a post</h4>";
        }
      ?>
      <h2>Forums:</h2>
      <?php
      require_once './includes/functions.inc.php';
      require_once './includes/dbh.inc.php';
      $result = get_all_posts($conn);
      // print_r($result);
      foreach ($result as $row) {
        echo '<div class="post">
        <div class="post-title">Title: '.$row["title"].'</div>
        <div class="post-subject">Subject: '.$row["subject"].'</div>
        <div class="post-content">Content: '.$row["content"].'</div>
        <div class="post-creator">Creator: '.getuserbyId($conn, $row["usersId"]).'</div>
      </div><br>';
      }
      ?>
    </div>
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <form action="includes/create_post.inc.php" method="post">
          <input type="text" name="title" placeholder="Title..."><br>
          <input type="text" name="subject" placeholder="Subject..."><br>
          <input type="text" name="content" placeholder="Content..."><br>
          <button type="submit" name="submit">Post</button>
        </form>
      </div>

    </div>

    <?php
      include_once 'footer.php';
    ?>
    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- egen javascript -->
    <script src="javascript/index.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  </body>
</html>