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
        //query for data insertion using prepared statement
        //id not defined as it is auto increment

        $query = 'INSERT INTO USERS (name,email,password) VALUES (?,?,?)';
        $preparedStatement = $mysql->prepare($query);
        //binding prepared statement
        $preparedStatement->bind_param('sss', $name, $email, $password);

        //setting values for prepared statement
        $name = 'ram';
        $email = 'ram@email.com';
        $password = 'p@ssw0rd';
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