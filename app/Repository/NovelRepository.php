<?php

namespace App\Repository;

use App\Entity\Novel;
use Framework\Database\AbstractRepository;
use PDO;

class NovelRepository extends AbstractRepository
{
    /**
     * @var PDO
     */
    protected $PDO;

    protected $table = 'novel';

    protected $entity = Novel::class;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO);
    }

    /**
     * @return Novel
     */
    public function findLatest(): Novel
    {
        $query = $this->PDO->query('SELECT * FROM novel ORDER BY created_at DESC LIMIT 1', PDO::FETCH_CLASS, Novel::class);
        return $query->fetch();
    }

    /**
     * @param Novel $novel
     * @throws \Exception
     */
    public function updateNovel(Novel $novel): void
    {
        $this->update([
            'title'         => $novel->getTitle(),
            'slug'          => $novel->getSlug(),
            'description'   => $novel->getDescription()
        ], $novel->getId());
    }
}
