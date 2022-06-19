# MySQL Data insertion using prepared statement using PHP OOP Method

## MySQL connection method:

``$mysql=mysqli_connect('localhost','username','password','database_name');``

#### Returns mysql object if credential matches else throws exception.

## MySQL query to insert data using prepared statement.

`` $query = 'INSERT INTO USERS (name,email,password) VALUES (?,?,?)';``

## Binding prepared statement with variable.
```` 
$preparedStatement = $mysql->prepare($query);
$preparedStatement->bind_param('sss', $name, $email, $password);
````

## Setting values for prepared statement and executing it.

````
 $name = 'ram';
 $email = 'ram@email.com';
 $password = 'p@ssw0rd';
        
 $preparedStatement->execute();
````


## Execution of query

``$mysql->query($sql); //response bool``


