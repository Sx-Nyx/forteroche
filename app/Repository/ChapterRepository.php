<?php

namespace App\Repository;

use App\Entity\Chapter;
use PDO;

class ChapterRepository
{
    /**
     * @var \PDO
     */
    private $PDO;

    public function __construct(\PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    /**
     * @param int $novelId
     * @return array
     */
    public function findAllBy(int $novelId)
    {
        $query = $this->PDO->prepare("SELECT * FROM chapter WHERE novel_id = :id ORDER BY created_at");
        $query->execute(['id' => $novelId]);
        return $query->fetchAll(PDO::FETCH_CLASS, Chapter::class);
    }

    /**
     * @param int $novelId
     * @return array
     */
    public function findAndCount(int $novelId):array
    {
        $chapters = $this->findAllBy($novelId);
        foreach ($chapters as $chapter) {
            $query = $this->PDO->query("SELECT COUNT(id) FROM comment WHERE chapter_id = {$chapter->getId()}");
            $comment = (int)$query->fetch(PDO::FETCH_COLUMN);
            $chapter->setNumberComment($comment);
        }
        return $chapters;
    }
}
