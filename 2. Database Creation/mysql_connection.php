<?php
/**
 * Author: Shree Sthapit
 * Email: shreesthapit1@gmail.com
 */

//credentials
$server_host = 'localhost';
$username = 'root';
$password = '';
$database_name = 'sample_database';
try {
    //Mysql Connection

    $mysql = new mysqli($server_host, $username, $password);
    //Check if mysql is connected successfully
    if (!$mysql->connect_error) {
        //query to create database if it does not exist
        $sql = 'CREATE DATABASE IF NOT EXISTS ' . $database_name;

        //execution of query using mysql
        if ($mysql->query($sql)) {
            echo "Database created successfully!!";
        } else {
            echo "Error Occurred. Something went wrong while creating database!!";
        }

        //close mysql connection
        $mysql->close();
    }
} catch (Exception $e) { //handling mysql connection exceptions
    die($e->getMessage());
}