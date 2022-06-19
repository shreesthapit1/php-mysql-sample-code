# MySQL Alter Table using PHP OOP Method

## MySQL connection method:

``$mysql=mysqli_connect('localhost','username','password','database_name');``

#### Returns mysql object if credential matches else throws exception.

## MySQL query to alter table.

``$query = 'ALTER TABLE USERS ADD is_admin TINYINT(1) DEFAULT 0';``

## Execution of query

``$mysql->query($sql); //response bool``


