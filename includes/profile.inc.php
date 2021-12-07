<?php

if (isset($_POST['submit'])) {
    
    $videoId = $_POST['videoId'];
    $userUid = $_POST['userUid'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';


    addtoplaylist($conn, $videoId, $userUid);
}
else {
    header("location: ../index.php");
    exit();
}