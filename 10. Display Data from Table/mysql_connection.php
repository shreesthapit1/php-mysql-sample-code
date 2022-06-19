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
        //query for getting records

        $query = 'SELECT * from users';
        $results = $mysql->query($query);

        //check if rows exists
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                echo $row['email'].'<br>';
            }
        }
        //close mysql connection
        $mysql->close();
    }
} catch (Exception $e) { //handling mysql connection exceptions
    die($e->getMessage());
}