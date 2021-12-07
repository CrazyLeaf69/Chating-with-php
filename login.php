<?php
  include_once 'header.php';
?>
<head>
  <link rel="stylesheet" href="css/signup.css" />
</head>

      <div class="container">
        <div class="signup">
          <h2 id="test">Log In</h2>
          <form action="includes/login.inc.php" method="post">
            <input type="text" name="uid" placeholder="Username/Email..."><br>
            <input type="password" name="pwd" placeholder="Password..."><br>
            <button type="submit" name="submit">Log In</button>
          </form>
          <?php
            if (isset($_GET['error'])) {
              if ($_GET['error'] == 'emptyinput') {
                echo "<p>FIll in all fields!</p>";
              }
              else if ($_GET['error'] == 'wronglogin') {
                echo "<p>Incorect username or password!</p>";
              }
            }
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