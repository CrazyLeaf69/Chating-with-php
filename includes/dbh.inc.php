<?php

// Development Connection
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "chating";

// Remote Database Connection
// $serverName = "remotemysql.com";
// $dBUsername = "WnjUQDzsw7";
// $dBPassword = "eYbm0MqX1l";
// $dBName = "WnjUQDzsw7";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}