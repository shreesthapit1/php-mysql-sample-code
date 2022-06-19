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
        //query for data updating using prepared statement

        $query = 'UPDATE users set is_admin=? where email=?';
        $preparedStatement = $mysql->prepare($query);
        //binding prepared statement
        $preparedStatement->bind_param('ds', $is_admin, $email);

        //setting values for prepared statement
        $is_admin = 1;
        $email = 'ram@email.com';
        //executing the query
        $preparedStatement->execute();

        //close prepared statement
        $preparedStatement->close();
        //close mysql connection
        $mysql->close();
    }
} catch (Exception $e) { //handling mysql connection exceptions
    die($e->getMessage());
}