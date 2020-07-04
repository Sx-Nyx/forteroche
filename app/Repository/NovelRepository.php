<?php

namespace App\Repository;

use App\Entity\Novel;
use Framework\Database\AbstractRepository;
use PDO;

class NovelRepository extends AbstractRepository
{
    /**
     * @var \PDO
     */
    protected $PDO;

    protected $table = 'novel';

    protected $entity = Novel::class;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO);
    }

    public function findLatest(): Novel
    {
        $query = $this->PDO->query('SELECT * FROM novel ORDER BY created_at DESC LIMIT 1', PDO::FETCH_CLASS, Novel::class);
        return $query->fetch();
    }
}
