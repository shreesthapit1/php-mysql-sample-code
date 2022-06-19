<?php
/**
 * Author: Shree Sthapit
 * Email: shreesthapit1@gmail.com
 */

//credentials
$server_host = 'localhost';
$username = 'root';
$password = '';

try {
    //Mysql Connection
    $mysql = new mysqli($server_host, $username, $password);
    //Check if mysql is connected successfully
    if (!$mysql->connect_error) {
        echo "Mysql connected successfully!";
    }

    //close mysql connection
    $mysql->close();
} catch (Exception $e) { //handling mysql connection exceptions
    die($e->getMessage());
}