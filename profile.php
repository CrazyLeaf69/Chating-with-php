<?php
include_once 'header.php';
?>

<div class="container">
  <?php

  require_once 'includes/dbh.inc.php';
  require_once 'includes/functions.inc.php';

  $userUid = $_SESSION["useruid"];

  if (isset($userUid)) {
    $id = getid($conn, $userUid, $userUid);
    echo "
          <div class='profile_div'>
            <h1 style='text-decoration: underline'>Your profile</h1>
            <h4>Username: " . $_SESSION["useruid"] . "</h4>
            <h4>Email: " . $_SESSION["email"] . "</h4>
            <h4>Full name: " . $_SESSION["fullName"] . "</h4>
          </div>";
    // echo "<br><h2 class='vidIdsOfPlaylist'>" . playlistExists($conn, $id) . "</h2>";
  }
  ?>
  <h1 style='text-decoration: underline'>Your Friends</h1>
  <table class="popularList">
    <tbody class="popularItem">
      <tr>
        <td class="nm">#</th>
        <td class="fonts" style="width: 13%;">
          <div class="ex-img" alt="song image">pfp</div>
        </td>
        <td class="ellipsis fonts" style="width: 40%;">
          <span class="title">username</span>
        </td>
        <td class="ellipsis fonts" style="width: 26%;">
        <td class="ellipsis fonts remove">
          <span style="text-align: center;"></span>
        </td>
      </tr>
    </tbody>
  </table>

  <?php
  if (isset($_SESSION["useruid"])) {
    echo "<form action='includes/remove.inc.php' method='post' id='form-id'>
    <input type='hidden' name='userUid' value='" . $_SESSION["useruid"] . "'>
    <input type='hidden' name='playlist' class='playlist'>
    <button type='submit' name='submit' hidden='hidden' id='hiddenBtn'></button>
  </form>";
  }
  ?>
  

</div>

<?php
include_once 'footer.php';
?>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- egen javascript -->
<script src="javascript/profile.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>