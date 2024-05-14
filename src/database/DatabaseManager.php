<?php

function establishConnection()
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $port = 8889;
    $database = "project";

    $conn = new mysqli($servername, $username, $password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
