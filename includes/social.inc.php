<?php

if (isset($_POST['submit'])) {
    
    $search = $_POST['search'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    session_start();
    if (getusers($conn, $search)) {
        $user = getusers($conn, $search);
    }
    else {
        $_SESSION['test'] = "";
        header("location: ../social.php");
    }
    
    $_SESSION['user'] = $user;

    header("location: ../social.php");
}
else {
    header("location: ../social.php");
    exit();
}