<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
if(isset($_POST['do']) && $_POST['do'] == 'show_messages') {
    require_once './dbh.inc.php';
    require_once './functions.inc.php';
    $from = $_POST['from'];
    $to = $_POST['to'];
    $arrs = message_view($conn, $from, $to);
        foreach ($arrs as $arr) {
            echo " : ".$arr["message"]." | ".$arr["from_"]." | ".$arr["to_"]. " | ".$arr["stamp"];
        }
  }