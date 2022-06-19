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
        //query for table creation
        $query = 'CREATE TABLE IF NOT EXISTS users (
   id INT(10) AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(60) NOT NULL,
   email VARCHAR(60) NOT NULL,
   password VARCHAR(60) NOT NULL,
   created_at TIMESTAMP NOT NULL,
   updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)';
        if ($mysql->query($query) == true) {
            echo "Table created successfully";
        } else {
            echo "Error Occurred. Something went wrong while creating table!!";
        }

        //close mysql connection
        $mysql->close();
    }
} catch (Exception $e) { //handling mysql connection exceptions
    die($e->getMessage());
}