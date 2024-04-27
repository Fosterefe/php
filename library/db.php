<?php
function connectDb()
{
    $servername = "localhost";
    $user = "alex";
    $password = "tkdalex248";
    $db = "library";

    $conn = new mysqli($servername, $user, $password, $db);

    if ($conn->connect_error) {
        die("Erro connecting to db!");
    }

    return $conn;
}
