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
        return new PDO("mysql:dbname=" . env('DB_NAME') . ";host=" . env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
