<?php
require_once './dbh.inc.php';
require_once './functions.inc.php';
if (isset($_POST['do']) && $_POST['do'] == 'new_messages') {
    $there_are_new_messages = false;
    $latest_message = latest_message($conn, $_POST["uid"], $_POST["reciever"]);
    $latest_loaded = $_POST['latest_loaded_message'];
    if ($latest_message[0]["stamp"] != $latest_loaded) {
        // there are new messages
        $arrs = message_view_latest($conn, $_POST["uid"], $_POST["reciever"], $latest_loaded);
        foreach ($arrs as $arr) {
            echo " : " . $arr["message"] . " | " . $arr["from_"] . " | " . $arr["to_"] . " | " . $arr["stamp"];
        }
        exit;
    }
    else {
        echo "no new messages";
    }
}
