<?php

use Framework\Database\Connection;

require dirname(__DIR__) . '/vendor/autoload.php';

$pdo = Connection::getPDO();
$pdo->exec('TRUNCATE TABLE user');

$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user SET username='admin', password='$password'");
