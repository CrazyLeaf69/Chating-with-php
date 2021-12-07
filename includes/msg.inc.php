<?php
$msg = $_POST['msg'];
$from = $_POST['from'];
$to = $_POST['to'];

require_once 'dbh.inc.php';
require_once 'functions.inc.php';
if ($to != "") {
    message_send($conn, $msg, $from, $to);
    exit;
}