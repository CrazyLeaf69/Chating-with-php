<?php
session_start();
if (isset($_POST['submit'])) {
    
    $username = $_SESSION["useruid"];
    $title = $_POST['title'];
    $subject = $_POST['subject'];
    $content = $_POST['content'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    if ($title == "" || $subject == "" || $content == "") {
        header('Location: ../index.php?error=emptypost');
    }
    else {
        create_post($conn, $username, $title, $subject, $content);
    }
}
else {
    header("location: ../index.php");
    exit();
}