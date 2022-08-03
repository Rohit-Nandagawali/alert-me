
# AlertMe - Diploma final year project
Platform for news sharing

## Libraries used
 - Bootstrap 5 ( for frontend development)- [https://getbootstrap.com/docs/5.0/getting-started/introduction/](https://getbootstrap.com/docs/5.0/getting-started/introduction/)
 - PHPMailer ( for sending mails ) - [https://github.com/PHPMailer/PHPMailer](https://github.com/PHPMailer/PHPMailer)
 
 
## Change login credentials in /assets/php/send_code.php

**Inside**
  - Do this setting to your gmail account before using it into your project
  - Watch this video to setup gmail account [https://www.youtube.com/watch?v=Kjn5vBbBsi8](https://www.youtube.com/watch?v=Kjn5vBbBsi8&t=481s)
  - Watch this video then change the username and password, other wise it will not work
  - change username and password
  
```php
    $mail->Username   = 'user@example.com';                     //SMTP username
    $mail->Password   = 'secret';  
```


## Import database 
> 1. Go to phpmyadmin
> 2. Click on `SQL` tab, and run following query to create new database
  ```sql
    CREATE DATABASE cpe 
  ```
> 3. Select `cpe` database using by clicking the `cpe` on left hand side
> 4. Click on `Import` tab, and Import `cpe.sql` file from project folder 
> 5. All done ! Now you can run it :)
## Admin Panel

> To access admin page type `Admin` after website url, ex: `localhost/alertme/Admin`
> `email` for Admin - `nandagawalirohit143@gmail.com`
> `password` for Admin - `12345`

- How to change username and password for admin 
1. Go to `phpmyadmin` and `cpe` and go to `admins` table and change the credentials. Password for admin is not encrypted.


## How to run this app

1. Clone the repository 
 ```
 git clone git clone https://github.com/Rohit-Nandagawali/alert-me
 ```

2. Start `Apache` and `MySQL` from xampp,wamp,etc.
3. Configure `send_code.php` file by changing mail and password.
4. Setup database, by Importing `cpe.sql` file.

## ⚠ This is private repository, DO NOT SELL THIS PROJECT, OR REUSE THIS PROJECT
