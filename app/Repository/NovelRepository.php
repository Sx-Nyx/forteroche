<?php

namespace App\Repository;

use App\Entity\Novel;
use PDO;

class NovelRepository
{
    /**
     * @var \PDO
     */
    private $PDO;

    public function __construct(\PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    public function findLatest(): Novel
    {
        $query = $this->PDO->query('SELECT * FROM novel ORDER BY created_at DESC LIMIT 1', PDO::FETCH_CLASS, Novel::class);
        return $query->fetch();
    }

    public function findBy(string $slug)
    {
        $query = $this->PDO->prepare('SELECT * FROM novel WHERE slug = :slug');
        $query->execute(['slug' => $slug]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Novel::class);
        return $query->fetch();
    }
}
