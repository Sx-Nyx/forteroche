<?php

namespace Framework\Database;

use PDO;

class Connection
{
    /**
     * @return PDO
     */
    public static function getPDO (): PDO
    {
        return new PDO('mysql:dbname=forteroche;host=127.0.0.1', 'root', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
