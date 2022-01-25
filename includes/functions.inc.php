<?php

function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) {
    $result;
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;"; // do this with playlist
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $username, $pwd) {
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../signup.php?error=none");
    exit();
}

function emptyInputLogin($username, $pwd) {
    $result;
    if (empty($username) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function getid($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;"; // do this with playlist
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row["usersId"];
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function loginUser($conn, $username, $pwd) {
    $id = getid($conn, $username, $username);
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("Location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("Location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["usersid"];
        $_SESSION["fullName"] = $uidExists["usersName"];
        $_SESSION["email"] = $uidExists["usersEmail"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        
        // $_SESSION["userplaylist"] = $get_playlist;
        header("Location: ../index.php");
        exit();
    }
}

function getusers($conn, $search) {
    $sql = "SELECT * FROM users WHERE usersUid = ?;"; // do this with playlist
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $search);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}
function getuserbyId($conn, $id) {
    $sql = "SELECT * FROM users WHERE usersId = ?;"; // do this with playlist
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row["usersUid"];
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}
function message_send($conn, $message, $from, $to) {
    $sql = "INSERT INTO storage (message, from_, to_) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $message, $from, $to);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

function message_view($conn, $usersuid, $reciever) {
    $sql = "SELECT * FROM `storage` WHERE (from_ = ? OR from_ = ?) AND (to_ = ? OR to_ = ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss", $usersuid, $reciever, $usersuid, $reciever);
    mysqli_stmt_execute($stmt);

    $rows = array();
    $resultData = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    }
    return $rows;

    mysqli_stmt_close($stmt);
}
function message_view_latest($conn, $usersuid, $reciever, $stamp) {
    $sql = "SELECT * FROM `storage` WHERE (from_ = ? OR from_ = ?) AND (to_ = ? OR to_ = ?) AND (stamp > ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssss", $usersuid, $reciever, $usersuid, $reciever, $stamp);
    mysqli_stmt_execute($stmt);

    $rows = array();
    $resultData = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    }
    return $rows;

    mysqli_stmt_close($stmt);
}

function start_conversation($conn, $starter, $reciever) {
    if (check_conversations($conn, $starter, $reciever) != null) { 
        $sql = "INSERT INTO conversations (conv_starter, reciever) VALUES (?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../social.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $starter, $reciever);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
     } else { 
        return false;
     }  
}
function view_conversations($conn, $starter) {
    $sql = "SELECT * FROM `conversations` WHERE conv_starter = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $starter);
    mysqli_stmt_execute($stmt);

    $rows = array();
    $resultData = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    }
    return $rows;

    mysqli_stmt_close($stmt);
}

function check_conversations($conn, $starter, $reciever) {
    $sql = "SELECT * FROM `conversations` WHERE conv_starter = ? AND reciever = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $starter, $reciever);
    mysqli_stmt_execute($stmt);

    $rows = array();
    $resultData = mysqli_stmt_get_result($stmt);
    return $resultData;

    mysqli_stmt_close($stmt);
}

function latest_message($conn, $usersuid, $reciever) {
    $sql = "SELECT stamp FROM `storage` WHERE (from_ = ? OR from_ = ?) AND (to_ = ? OR to_ = ?) ORDER BY stamp DESC;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss", $usersuid, $reciever, $usersuid, $reciever);
    mysqli_stmt_execute($stmt);

    $rows = array();
    $resultData = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    }
    return $rows;

    mysqli_stmt_close($stmt);
}
function create_post($conn, $username, $title, $subject, $content) {
    $id = getid($conn, $username, $username);
    $sql = "INSERT INTO forums (usersId, title, subject, content) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "isss", $id, $title, $subject, $content);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../index.php?");
    exit();
}
function get_all_posts($conn) {
    $sql = "SELECT * FROM `forums`";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);

    $rows = array();
    $resultData = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    }
    return $rows;

    mysqli_stmt_close($stmt);
}