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
        //query for table alteration
        $query = 'ALTER TABLE USERS ADD is_admin TINYINT(1) DEFAULT 0';
        if ($mysql->query($query) == true) {
            echo "Table altered successfully";
        } else {
            echo "Error Occurred. Something went wrong while altering table!!";
        }

        //close mysql connection
        $mysql->close();
    }
} catch (Exception $e) { //handling mysql connection exceptions
    die($e->getMessage());
}