# Project n°4

Web application in PHP and Mysql for Mister Forteroche
[The project](https://www.projet-4.kenjy-thiebault.fr/)

## Requirement
1. PHP < 7.2
2. MySql 5.6

## Installation 

1. Run `git clone git@github.com:Sx-Nyx/forteroche.git`
2. Create autoloader `composer dump-autoload`
3. Create `env.php` :
    ```
    <?php
    $settings = [
        'DB_HOST' => 'YOUR_DB_HOST',
        'DB_USERNAME' => 'YOUR_DB_USERNAME',
        'DB_PASSWORD' => 'YOUR_DB_PASSWORD',
        'DB_NAME' => 'YOUR_DB_NAME',
    ];
    
    foreach ($settings as $key => $value) {
        putenv("$key=$value");
    }
    ?>
    ```
   
4. Copy/paste the contents of bdd.sql in your database to create the tables.
5. Run the following commands to fill your database: 
    * `php console/addNovel.php`
    * `php console/addChapter.php`
    * `php console/addComment.php`
    * `php console/addUser.php`
    
6. Run PHP server  `php -S localhost:8000 -t public` 

## Connexion
* url : /login
* username : admin
* password : admin

