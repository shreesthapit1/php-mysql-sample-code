# MySQL Database Creation using PHP OOP Method

## MySQL connection method:

``$mysql=mysqli_connect('localhost','username','password');``

#### Returns mysql object if credential matches else throws exception.

## MySQL query to create database (If it does not exist).

``$sql='CREATE DATABASE IF NOT EXISTS database_name';``

## Execution of query

``$mysql->query($sql); //response bool``


