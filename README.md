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
ServerName www.example.com:4433
```

# Issue 2 - Project path

```C:\xampp\htdocs\```

or else, phpstorm would raise error on interpreter & phpunit

# Issue 3 - insert into user

**Error**

> You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ''mail','nickname','password')values ("","","")' at line 1


**Answer**

```php
$sql = "insert into user('mail','nickname','password')";  (X)
```
```php
$sql = "insert into user(`mail`,`nickname`,`password`)";  (O)
```
