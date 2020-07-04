<?php

namespace App\Repository;

use App\Entity\Chapter;
use App\Entity\Comment;
use Framework\Database\AbstractRepository;
use Framework\Database\Exception\NotFoundException;
use PDO;

class ChapterRepository extends AbstractRepository
{
    /**
     * @var \PDO
     */
    protected $PDO;

    protected $table = 'chapter';

    protected $entity = Chapter::class;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO);
    }

    /**
     * @param string $slug
     * @return Chapter
     * @throws NotFoundException
     */
    public function findWithComment(string $slug): Chapter
    {
        $chapter = $this->findBy('slug', $slug);

        $queryComment = $this->PDO->query("SELECT * FROM comment WHERE chapter_id = {$chapter->getId()} ORDER BY created_at");
        $comments = $queryComment->fetchAll(PDO::FETCH_CLASS, Comment::class);

        $chapter->setComments($comments);

        return $chapter;
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
    public function findAndCount(int $novelId): array
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
