# MySQL Data Insertion using PHP OOP Method

## MySQL connection method:

``$mysql=mysqli_connect('localhost','username','password','database_name');``

#### Returns mysql object if credential matches else throws exception.

## MySQL query to insert data to table.

``$query = 'INSERT INTO USERS (name,email,password) VALUES ("ram","ram@email.com","p@ssw0rd")';``

## Execution of query

``$mysql->query($sql); //response bool``


