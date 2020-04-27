## Created influence:
[Flat PHP or Symfony](https://symfony.com/doc/current/introduction/from_flat_php_to_symfony.html)

## Database default settings
	Database: blog_db
	User: myuser
	Pass: mypassword

## Ensuring is encription is correct
In CLI put 
	php encode.php password

## Authenticate from:
[Secure Login System with PHP and MySQL](https://codeshack.io/secure-login-system-php-mysql/)

| File name         | 									|
|-------------------|:----------------------------------|
| login.php		    | not secure, controller			|
| model.php		    | function authenticate()			|
| logout.php	    | logout controller					|
| home.php	  	    | controller with secure content	|
| profile.php 	    | controller and view secure		|
| login_form.php    | template of login form			|
| login_success.php | template after success loged in	|
| login_failure.php | template after failed loged in	|

## Main usefull files

Public part of files are index.php - frontend controller coresponding with post table and with templates/list.php as view

Private part of files are home.php - backend controller coresponding with post table and with templates/home.php as view

## PHP basic pagination:
[index.php and home.php include it](http://www.phpfreaks.com/tutorial/basic-pagination)
