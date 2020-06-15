<?php

use Framework\Database\Connection;

require "../vendor/autoload.php";

$pdo = Connection::getPDO();
$pdo->exec('TRUNCATE TABLE novel');

$pdo->exec("INSERT INTO novel SET title='Un billet simple pour l\'Alaska.', slug='un-billet-simple-pour-l-alaska', description='Une petite description', created_at=NOW()");