# MySQL Data deletion using PHP OOP Method

## MySQL connection method:

``$mysql=mysqli_connect('localhost','username','password','database_name');``

#### Returns mysql object if credential matches else throws exception.

## MySQL query to deleting data using prepared statement.

`` $query = 'DELETE FROM users where email=?';``

## Binding prepared statement with variable.
```` 
$preparedStatement = $mysql->prepare($query);
$preparedStatement->bind_param('s',  $email);
````

## Setting values for prepared statement and executing it.

````
 $email = 'ram@email.com';
        
 $preparedStatement->execute();
````


## Execution of query

``$mysql->query($sql); //response bool``


