<?php

// disabled showing errors
error_reporting(0);

// set timezone
date_default_timezone_set('Europe/Amsterdam');

// Open connection
function openConn() {
    $host = "127.0.0.1";
    $user = "root";
    $password = "";
    $name = "reserveringssysteem";

    $conn = new mysqli($host, $user, $password, $name);

    // check connection
    if ($conn->connect_error) {        
        die("Database Error"); // $conn->connect_error
    }

    // return connection
    return $conn;
}

// Close connection
function closeConn($conn) {
    $conn->close();
}

?>
