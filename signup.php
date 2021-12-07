<?php
  include_once 'header.php';
?>

      <div class="container">
        <div class="signup">
          <h2 id="test">Sign Up</h2>
          <form action="includes/signup.inc.php" method="post">
            <input type="text" name="name" placeholder="Full name..."><br>
            <input type="text" name="email" placeholder="Email..."><br>
            <input type="text" name="uid" placeholder="Username..."><br>
            <input type="password" name="pwd" placeholder="Password..."><br>
            <input type="password" name="pwdrepeat" placeholder="Repeat password..."><br>
            <button type="submit" name="submit">Sign Up</button>
          </form>
          <?php
            if (isset($_GET['error'])) {
              if ($_GET['error'] == 'emptyinput') {
                echo "<p>FIll in all fields!</p>";
              }
              else if ($_GET['error'] == 'invaliduid') {
                echo "<p>Chosse a proper username!</p>";
              }
              else if ($_GET['error'] == 'invalidemail') {
                echo "<p>Chosse a proper email!</p>";
              }
              else if ($_GET['error'] == 'passwordsdontmatch') {
                echo "<p>Passwords doesn't match!</p>";
              }
              else if ($_GET['error'] == 'stmtfailed') {
                echo "<p>Something went wrong, try again!</p>";
              }
              else if ($_GET['error'] == 'usernametaken') {
                echo "<p>Username already taken!</p>";
              }
              else if ($_GET['error'] == 'none') {
                echo "<p id='succes'>You have successfully signed up!</p>";
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