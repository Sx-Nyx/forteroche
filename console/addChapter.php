<?php

use Framework\Database\Connection;

require dirname(__DIR__) . '/vendor/autoload.php';

$pdo = Connection::getPDO();
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE chapter');

for ($i = 0; $i < 10; $i++) {
    $pdo->exec("INSERT INTO chapter SET title='Chapitre {$i}', slug='chapitre-{$i}', novel_id=1, created_at=NOW(), content='Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'");
}
