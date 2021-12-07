<?php

if (isset($_POST['submit'])) {
    
    $starter = $_POST['starter'];
    $reciever = $_POST['reciever'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    if ($reciever != "") {
        start_conversation($conn, $starter, $reciever);
    }
    header("location: ../conv.php?starter=".$starter."&reciever=".$reciever."");
}
else {
    header("location: ../index.php");
    exit();
}