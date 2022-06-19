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
    //Assume database is already created
    $mysql = new mysqli($server_host, $username, $password, $database_name);
    //Check if mysql is connected successfully
    if (!$mysql->connect_error) {
        //query for data insertion
        //id not defined as it is auto increment
        $query = 'INSERT INTO USERS (name,email,password) VALUES ("ram","ram@email.com","p@ssw0rd")';
        if ($mysql->query($query) == true) {
            echo "Data inserted successfully";
        } else {
            echo "Error Occurred. Something went wrong while inserting to table!!";
        }

        //close mysql connection
        $mysql->close();
    }
} catch (Exception $e) { //handling mysql connection exceptions
    die($e->getMessage());
}