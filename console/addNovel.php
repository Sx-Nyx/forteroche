<?php

use Framework\Database\Connection;

require dirname(__DIR__) . '/vendor/autoload.php';

$pdo = Connection::getPDO();
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE novel');

$pdo->exec("INSERT INTO novel SET title='Un billet simple pour l\'Alaska.', slug='un-billet-simple-pour-l-alaska', description='Une petite description', created_at=NOW()");
