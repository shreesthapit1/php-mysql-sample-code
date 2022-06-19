# MySQL Table Creation using PHP OOP Method

## MySQL connection method:

``$mysql=mysqli_connect('localhost','username','password','database_name');``

#### Returns mysql object if credential matches else throws exception.

## MySQL query to create table (If it does not exist).

``$query = 'CREATE TABLE IF NOT EXISTS users (
id INT(10) AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(60) NOT NULL,
email VARCHAR(60) NOT NULL,
password VARCHAR(60) NOT NULL,
created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)';``

## Execution of query

``$mysql->query($sql); //response bool``


