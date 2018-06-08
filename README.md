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
