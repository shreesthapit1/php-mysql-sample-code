# MySQL Database update using PHP OOP Method

## MySQL connection method:

``$mysql=mysqli_connect('localhost','username','password','database_name');``

#### Returns mysql object if credential matches else throws exception.

## MySQL query to update data using prepared statement.

`` $query = 'UPDATE users set is_admin=? where email=?';``

## Binding prepared statement with variable.
```` 
$preparedStatement = $mysql->prepare($query);
$preparedStatement->bind_param('ds', $is_admin, $email);
````

## Setting values for prepared statement and executing it.

````
 $is_admin = 1;
 $email = 'ram@email.com';
        
 $preparedStatement->execute();
````


## Execution of query

``$mysql->query($sql); //response bool``


