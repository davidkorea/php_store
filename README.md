# php_store

# Issue 1 - xampp apache port 80 443 conflict

- config-http
```
Listen 8080
ServerName localhost:8080
```
- config-https
```
Listen 4433
ServerName www.example.com:4433 (X)
ServerName localhost:4433 (O)
```

# Issue 2 - Project path

```C:\xampp\htdocs\```

or else, phpstorm would raise error on interpreter & phpunit

# Issue 3 - insert into user

**Error**

> You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ''mail','nickname','password')values ("","","")' at line 1


**Answer**

```php
$sql = "insert into user('email','nickname','password')";  (X)
```
```php
$sql = "insert into user(`email`,`nickname`,`password`)";  (O)
```
# Issue 4 - Hash Password

1. when register, insert the hashed pw into mysql
```php
$hash = password_hash($password, PASSWORD_DEFAULT);
```
  - ```$password = $_POST['password']```, input by user
  - ```PASSWORD_DEFAULT```, default hash method
  
2. when login, verify current input == pw saved in mysql by $row['password']
```php
password_verify($_POST['password'], $row['password'])
```

# Issue 5 - SQL Injection Attack
**bind parameter**
```php
$sql = "insert into user(`email`, `nickname`, `password`) values (?,?,?)";
$stmt = mysqli_prepare($mysqli, $sql); // pre compile
mysqli_stmt_bind_param($stmt, 'sss', $email, $nickname, $hash);
$result = mysqli_stmt_execute($stmt); // instead mysqli_query()
```
- do not need to combine str by ' . '
- after pre compile, search speed much higher than before
